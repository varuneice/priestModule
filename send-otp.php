<?php
header('Content-Type: application/json');

require_once __DIR__ . '/vendor/autoload.php';
$twilioAutoload = __DIR__ . '/application/controllers/Twillio/vendor/autoload.php';
if (file_exists($twilioAutoload)) {
    require_once $twilioAutoload;
}
require_once __DIR__ . '/application/config/env.php';
include  __DIR__ . '/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use Twilio\Rest\Client as TwilioClient;

// ── Helpers ──────────────────────────────────────────────────────────
function jsonOut($success, $message, $extra = []) {
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

function otpDebugLog($message) {
    $line = date('Y-m-d H:i:s') . ' ' . $message . PHP_EOL;
    @file_put_contents(__DIR__ . '/otp_debug.log', $line, FILE_APPEND | LOCK_EX);
    error_log($message);
}

function maskEmail($email) {
    $parts = explode('@', $email);
    $name  = $parts[0];
    return substr($name, 0, 2) . str_repeat('*', max(2, strlen($name) - 2)) . '@' . $parts[1];
}

function maskPhone($phone) {
    $digits = preg_replace('/\D/', '', $phone);
    return '***-***-' . substr($digits, -4);
}

function normalizeSmsPhone($phone) {
    $digits = preg_replace('/\D/', '', $phone);
    if (strlen($digits) === 10) {
        return '+1' . $digits;
    }
    if (strlen($digits) === 11 && substr($digits, 0, 1) === '1') {
        return '+' . $digits;
    }
    if (strlen($digits) >= 8 && strlen($digits) <= 15) {
        return '+' . $digits;
    }
    return '';
}

function normalizeLookupPhone($phone) {
    return preg_replace('/\D/', '', $phone);
}

function envFlag($name, $fallback = false) {
    $value = $GLOBALS[$name] ?? $fallback;
    return filter_var($value, FILTER_VALIDATE_BOOLEAN);
}

function findMemberByEmailOrPhone($con, $lookup) {
    $lookup = trim($lookup);
    $isEmail = strpos($lookup, '@') !== false;

    if ($isEmail) {
        $email = strtolower($lookup);
        $sql = "SELECT Member_id, email, Email2, Tele1, Tele2, Mob_No
                FROM memberltdytd
                WHERE (Active IS NULL OR Active = '')
                    AND Category <> 'GC'
                    AND (LOWER(email) = ? OR LOWER(Email2) = ?)
                LIMIT 2";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ss', $email, $email);
    } else {
        $phone = normalizeLookupPhone($lookup);
        if ($phone === '') {
            return ['error' => 'Please enter a valid email or phone number.'];
        }
        $phoneExpr1 = "REPLACE(REPLACE(REPLACE(REPLACE(COALESCE(Tele1, ''), '-', ''), '(', ''), ')', ''), ' ', '')";
        $phoneExpr2 = "REPLACE(REPLACE(REPLACE(REPLACE(COALESCE(Tele2, ''), '-', ''), '(', ''), ')', ''), ' ', '')";
        $phoneExpr3 = "REPLACE(REPLACE(REPLACE(REPLACE(COALESCE(CAST(Mob_No AS CHAR), ''), '-', ''), '(', ''), ')', ''), ' ', '')";
        $sql = "SELECT Member_id, email, Email2, Tele1, Tele2, Mob_No
                FROM memberltdytd
                WHERE (Active IS NULL OR Active = '')
                    AND Category <> 'GC'
                    AND ($phoneExpr1 = ? OR $phoneExpr2 = ? OR $phoneExpr3 = ?)
                LIMIT 2";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('sss', $phone, $phone, $phone);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $members = [];
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
    $stmt->close();

    if (count($members) === 0) {
        return ['error' => 'No active member found with this email or phone number.'];
    }
    if (count($members) > 1) {
        return ['error' => 'Multiple active members found with this email or phone number. Please contact the administrator.'];
    }

    return ['member' => $members[0], 'method' => $isEmail ? 'email' : 'sms'];
}

// ── Input ─────────────────────────────────────────────────────────────
$lookup = trim($_POST['lookup'] ?? '');

if (!$lookup) {
    jsonOut(false, 'Please enter your email or phone number.');
}

// ── 1. Look up member by email or phone ───────────────────────────────
$lookupResult = findMemberByEmailOrPhone($con, $lookup);
if (!empty($lookupResult['error'])) {
    jsonOut(false, $lookupResult['error']);
}
$member = $lookupResult['member'];
$method = $lookupResult['method'];

$member_id = $member['Member_id'];
$email     = trim($member['email']  ?? '');
$email2    = trim($member['Email2'] ?? '');
$tele1     = trim($member['Tele1']  ?? '');
$tele2     = trim($member['Tele2']  ?? '');
$mob       = trim($member['Mob_No'] ?? '');

// ── 2. Validate the chosen method has a contact on file ───────────────
if ($method === 'email') {
    $email = trim($lookup);
    if (!$email || strpos($email, '@') === false) {
        $email = $email ?: $email2;
    }
    if (!$email) {
        jsonOut(false, 'No email address on file for this member. Please contact the administrator.');
    }
    $masked = maskEmail($email);
} else {
    $phone = normalizeLookupPhone($lookup);
    if (!$phone) {
        $phone = $mob ?: ($tele1 ?: $tele2);
    }
    if (!$phone) {
        jsonOut(false, 'No phone number on file for this member. Please contact the administrator.');
    }
    if (!normalizeSmsPhone($phone)) {
        otpDebugLog('[send-otp] Invalid SMS phone for member ' . $member_id . ': ' . $phone);
        jsonOut(false, 'The phone number on file is invalid. Please contact the administrator.');
    }
    $masked = maskPhone($phone);
}

// ── 3. Rate limit: max 3 requests in 5 minutes ───────────────────────
$stmt = $con->prepare(
    "SELECT COUNT(*) AS cnt FROM otp_verification
     WHERE member_id = ? AND created_at > DATE_SUB(NOW(), INTERVAL 5 MINUTE)"
);
$stmt->bind_param('s', $member_id);
$stmt->execute();
$rate = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ((int)$rate['cnt'] >= 3) {
    jsonOut(false, 'Too many requests. Please wait 5 minutes and try again.');
}

// ── 4. Generate 6-digit OTP ───────────────────────────────────────────
$otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

// ── 5. Store OTP ──────────────────────────────────────────────────────
$stmt = $con->prepare(
    "INSERT INTO otp_verification (member_id, otp, method, expires_at, attempts, verified)
     VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 5 MINUTE), 0, 0)"
);
$stmt->bind_param('sss', $member_id, $otp, $method);
$stmt->execute();
$stmt->close();

// ── 6. Send OTP ───────────────────────────────────────────────────────
$otpMailEnabled = envFlag('ENV_OTP_MAIL_ENABLED', false);
$otpSmsEnabled  = envFlag('ENV_OTP_SMS_ENABLED', false);

if ($method === 'email') {

    if ($otpMailEnabled) {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $ENV_SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = $ENV_SMTP_USER;
            $mail->Password   = $ENV_SMTP_PASS;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = $ENV_SMTP_PORT;
            $mail->CharSet    = 'UTF-8';
            $mail->From       = $ENV_SMTP_FROM;
            $mail->FromName   = 'Houston Durga Bari Society';
            $mail->addAddress($email);
            $mail->Subject    = 'Your OTP for Member Verification';
            $mail->isHTML(true);
            $mail->Body = '
                <div style="font-family:Arial,sans-serif;max-width:480px;margin:0 auto;">
                    <div style="background:#357ca5;padding:16px;text-align:center;">
                        <h2 style="color:#fff;margin:0;">Houston Durga Bari Society</h2>
                    </div>
                    <div style="padding:24px;background:#f9f9f9;">
                        <p style="font-size:15px;color:#333;">Your One-Time Password (OTP) for member verification is:</p>
                        <div style="font-size:36px;font-weight:bold;letter-spacing:10px;text-align:center;color:#357ca5;padding:16px 0;">'
                            . $otp .
                        '</div>
                        <p style="font-size:13px;color:#888;">This OTP is valid for <strong>5 minutes</strong>. Do not share it with anyone.</p>
                    </div>
                </div>';
            $mail->send();
        } catch (PHPMailerException $e) {
            error_log('[send-otp] Email failed: ' . $e->getMessage());
            jsonOut(false, 'Failed to send OTP email. Please try again.');
        }
    } else {
        otpDebugLog('[send-otp TEST] Email OTP generated for member ' . $member_id);
    }

} else {

    if ($otpSmsEnabled) {
        $to = normalizeSmsPhone($phone);
        otpDebugLog('[send-otp] Sending SMS OTP for member ' . $member_id . ' to ' . maskPhone($to));
        try {
            $client = new TwilioClient($ENV_TWILIO_SID, $ENV_TWILIO_TOKEN);
            $client->messages->create($to, [
                'from' => $ENV_TWILIO_FROM,
                'body' => 'Houston Durga Bari Society: Your OTP is ' . $otp . '. Valid for 5 minutes. Do not share.'
            ]);
            otpDebugLog('[send-otp] SMS OTP sent successfully for member ' . $member_id . ' to ' . maskPhone($to));
        } catch (\Exception $e) {
            $twilioCode = method_exists($e, 'getCode') ? $e->getCode() : '';
            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : '';
            otpDebugLog('[send-otp] SMS failed for member ' . $member_id . ' to ' . maskPhone($to) . ' | status=' . $statusCode . ' code=' . $twilioCode . ' | ' . $e->getMessage());
            jsonOut(false, 'Failed to send OTP SMS. Please try again.');
        }
    } else {
        otpDebugLog('[send-otp TEST] SMS OTP generated for member ' . $member_id . ' but SMS is disabled.');
    }

}

jsonOut(true, 'OTP sent successfully.', [
    'member_id' => $member_id,
    'masked'    => $masked,
]);
