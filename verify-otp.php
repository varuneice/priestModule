<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_name('TimeSlotBookingCalendarPHP');
    session_start();
}

require_once __DIR__ . '/application/config/env.php';
include  __DIR__ . '/config.php';

function jsonOut($success, $message, $extra = []) {
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

function normalizeLookupPhone($phone) {
    return preg_replace('/\D/', '', $phone);
}

function findMemberIdByEmailOrPhone($con, $lookup) {
    $lookup = trim($lookup);
    if (strpos($lookup, '@') !== false) {
        $email = strtolower($lookup);
        $stmt = $con->prepare(
            "SELECT Member_id FROM memberltdytd
             WHERE (Active IS NULL OR Active = '')
                AND Category <> 'GC'
                AND (LOWER(email) = ? OR LOWER(Email2) = ?)
             LIMIT 2"
        );
        $stmt->bind_param('ss', $email, $email);
    } else {
        $phone = normalizeLookupPhone($lookup);
        if ($phone === '') {
            return '';
        }
        $phoneExpr1 = "REPLACE(REPLACE(REPLACE(REPLACE(COALESCE(Tele1, ''), '-', ''), '(', ''), ')', ''), ' ', '')";
        $phoneExpr2 = "REPLACE(REPLACE(REPLACE(REPLACE(COALESCE(Tele2, ''), '-', ''), '(', ''), ')', ''), ' ', '')";
        $phoneExpr3 = "REPLACE(REPLACE(REPLACE(REPLACE(COALESCE(CAST(Mob_No AS CHAR), ''), '-', ''), '(', ''), ')', ''), ' ', '')";
        $stmt = $con->prepare(
            "SELECT Member_id FROM memberltdytd
             WHERE (Active IS NULL OR Active = '')
                AND Category <> 'GC'
                AND ($phoneExpr1 = ? OR $phoneExpr2 = ? OR $phoneExpr3 = ?)
             LIMIT 2"
        );
        $stmt->bind_param('sss', $phone, $phone, $phone);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $members = [];
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
    $stmt->close();

    return count($members) === 1 ? trim($members[0]['Member_id'] ?? '') : '';
}

// ── Input ─────────────────────────────────────────────────────────────
$member_id = trim($_POST['member_id'] ?? '');
$lookup    = trim($_POST['lookup']    ?? '');
$otp_input = trim($_POST['otp']       ?? '');

if (!$member_id && $lookup) {
    $member_id = findMemberIdByEmailOrPhone($con, $lookup);
}

if (!$member_id || !$otp_input) {
    jsonOut(false, 'All fields are required.');
}
if (!preg_match('/^\d{6}$/', $otp_input)) {
    jsonOut(false, 'Invalid OTP format.');
}

// ── 1. Fetch latest unexpired, unverified OTP ─────────────────────────
$stmt = $con->prepare(
    "SELECT id, otp, attempts FROM otp_verification
     WHERE member_id = ? AND verified = 0 AND expires_at > NOW()
     ORDER BY created_at DESC LIMIT 1"
);
$stmt->bind_param('s', $member_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$row) {
    jsonOut(false, 'OTP expired or not found. Please request a new one.');
}

// ── 2. Check attempt cap ──────────────────────────────────────────────
if ((int)$row['attempts'] >= 5) {
    jsonOut(false, 'Too many failed attempts. Please request a new OTP.');
}

// ── 3. Increment attempts ─────────────────────────────────────────────
$stmt = $con->prepare("UPDATE otp_verification SET attempts = attempts + 1 WHERE id = ?");
$stmt->bind_param('i', $row['id']);
$stmt->execute();
$stmt->close();

// ── 4. Check OTP ──────────────────────────────────────────────────────
if ($row['otp'] !== $otp_input) {
    $used      = (int)$row['attempts'] + 1;
    $remaining = max(0, 5 - $used);
    if ($remaining === 0) {
        jsonOut(false, 'Too many failed attempts. Please request a new OTP.');
    }
    jsonOut(false, 'Invalid OTP. ' . $remaining . ' attempt' . ($remaining === 1 ? '' : 's') . ' remaining.');
}

// ── 5. Mark verified ──────────────────────────────────────────────────
$stmt = $con->prepare("UPDATE otp_verification SET verified = 1 WHERE id = ?");
$stmt->bind_param('i', $row['id']);
$stmt->execute();
$stmt->close();

// ── 6. Set session ────────────────────────────────────────────────────
$_SESSION['otp_verified_member'] = $member_id;
$_SESSION['otp_verified_at']     = time();
session_write_close();

jsonOut(true, 'Verified successfully.', ['member_id' => $member_id]);
