<?php
/*
 * Phase 3 Library Upgrade Script
 *
 * Upgrades all application code from:
 *   - PHPMailer 5.2.4 (helpers/PHPMailer_5.2.4) → PHPMailer 6.x (Composer)
 *   - mPDF 5.7      (helpers/MPDF57)           → mPDF 8.x     (Composer)
 *
 * Prerequisites:
 *   - vendor/autoload.php already present (Composer ran:
 *     composer require phpmailer/phpmailer:"^6.0" mpdf/mpdf:"^8.0")
 *
 * Run from project root:
 *   C:/xampp82/php/php.exe tools/phase3-library-upgrade.php
 */

define('BASE', realpath(__DIR__ . '/..'));

$log = [];

// ─────────────────────────────────────────────────────────────────────────────
// Helper
// ─────────────────────────────────────────────────────────────────────────────
function fix_file($path, callable $mutate, array &$log) {
    $src = file_get_contents($path);
    $new = $mutate($src);
    if ($new === $src) {
        $log[] = "  (no change) " . basename($path);
        return;
    }
    file_put_contents($path, $new);
    $log[] = "  UPDATED     " . basename($path);
}

// ─────────────────────────────────────────────────────────────────────────────
// STEP 1 — Add vendor/autoload.php to index.php
// ─────────────────────────────────────────────────────────────────────────────
echo "STEP 1: index.php — adding vendor/autoload.php\n";
fix_file(BASE . '/index.php', function($src) {
    if (strpos($src, "vendor/autoload.php") !== false) {
        return $src; // already done
    }
    return str_replace(
        "require_once ROOT_PATH . 'application/config/config.php';",
        "require_once ROOT_PATH . 'vendor/autoload.php';\nrequire_once ROOT_PATH . 'application/config/config.php';",
        $src
    );
}, $log);

// ─────────────────────────────────────────────────────────────────────────────
// STEP 2 — PHPMailer: controller files that already have use Twilio\Rest\Client
// ─────────────────────────────────────────────────────────────────────────────
echo "\nSTEP 2: PHPMailer 5.2.4 → 6.x (controller files with Twilio use)\n";

$twilio_controllers = [
    BASE . '/application/controllers/App.php',
    BASE . '/application/controllers/AppRental.php',
    BASE . '/application/controllers/RentalBooking.php',
    BASE . '/application/controllers/Booking.php',
];

foreach ($twilio_controllers as $file) {
    fix_file($file, function($src) {
        // 1. Add PHPMailer use statements after the Twilio use line (once only)
        if (strpos($src, 'use PHPMailer\\PHPMailer\\PHPMailer;') === false) {
            $src = str_replace(
                "use Twilio\\Rest\\Client;",
                "use Twilio\\Rest\\Client;\nuse PHPMailer\\PHPMailer\\PHPMailer;\nuse PHPMailer\\PHPMailer\\Exception as PHPMailerException;",
                $src
            );
        }
        // 2. Remove every require_once line for PHPMailer 5.2.4 (with optional leading whitespace)
        $src = preg_replace(
            '/[ \t]*require_once APP_PATH \. \'\/helpers\/PHPMailer_5\.2\.4\/class\.phpmailer\.php\';\r?\n/',
            '',
            $src
        );
        // 3. Fix catch clause
        $src = str_replace(
            'catch (phpmailerException $e)',
            'catch (PHPMailerException $e)',
            $src
        );
        return $src;
    }, $log);
}

// ─────────────────────────────────────────────────────────────────────────────
// STEP 3 — PHPMailer: Invoice.php (no Twilio use, extends App.php)
// ─────────────────────────────────────────────────────────────────────────────
echo "\nSTEP 3: PHPMailer 5.2.4 → 6.x (Invoice.php)\n";

fix_file(BASE . '/application/controllers/Invoice.php', function($src) {
    // Add use statements after require_once CONTROLLERS_PATH . 'App.php'; (once only)
    if (strpos($src, 'use PHPMailer\\PHPMailer\\PHPMailer;') === false) {
        $src = preg_replace(
            '/(require_once CONTROLLERS_PATH \. \'App\.php\';)(\r?\n)/',
            "$1$2use PHPMailer\\\\PHPMailer\\\\PHPMailer;\nuse PHPMailer\\\\PHPMailer\\\\Exception as PHPMailerException;\n",
            $src,
            1  // replace first occurrence only
        );
    }
    $src = preg_replace(
        '/[ \t]*require_once APP_PATH \. \'\/helpers\/PHPMailer_5\.2\.4\/class\.phpmailer\.php\';\r?\n/',
        '',
        $src
    );
    $src = str_replace(
        'catch (phpmailerException $e)',
        'catch (PHPMailerException $e)',
        $src
    );
    return $src;
}, $log);

// ─────────────────────────────────────────────────────────────────────────────
// STEP 4 — PHPMailer: root-level standalone scripts
// ─────────────────────────────────────────────────────────────────────────────
echo "\nSTEP 4: PHPMailer 5.2.4 → 6.x (root-level scripts)\n";

$root_scripts = [
    BASE . '/donationmain.php',
    BASE . '/CronJobForGMToGD.php',
];

foreach ($root_scripts as $file) {
    fix_file($file, function($src) {
        // Replace the direct include of PHPMailer 5.2.4 with autoloader + use
        if (strpos($src, "vendor/autoload.php") === false) {
            $old = 'include "application/helpers/PHPMailer_5.2.4/class.phpmailer.php";';
            $new = "require_once __DIR__ . '/vendor/autoload.php';\nuse PHPMailer\\PHPMailer\\PHPMailer;\nuse PHPMailer\\PHPMailer\\Exception as PHPMailerException;";
            $src = str_replace($old, $new, $src);
        }
        // Remove any commented-out APP_PATH require_once lines (dead code cleanup)
        $src = preg_replace(
            '/[ \t]*\/\/\s*require_once APP_PATH \. \'\/helpers\/PHPMailer_5\.2\.4\/class\.phpmailer\.php\';\r?\n/',
            '',
            $src
        );
        // Fix catch clause
        $src = str_replace(
            'catch (phpmailerException $e)',
            'catch (PHPMailerException $e)',
            $src
        );
        return $src;
    }, $log);
}

// ─────────────────────────────────────────────────────────────────────────────
// STEP 5 — mPDF: model files
// ─────────────────────────────────────────────────────────────────────────────
echo "\nSTEP 5: mPDF 5.7 → 8.x (model files)\n";

$mpdf_models = [
    BASE . '/application/models/Volunteersdata.model.php',
    BASE . '/application/models/Vendor.model.php',
    BASE . '/application/models/RentalBooking.model.php',
    BASE . '/application/models/Parkingdataview.model.php',
    BASE . '/application/models/Paidparkingview.model.php',
    BASE . '/application/models/Booking.model.php',
];

foreach ($mpdf_models as $file) {
    fix_file($file, function($src) {
        // Remove include_once line for MPDF57
        $src = preg_replace(
            '/[ \t]*include_once \(APP_PATH \. "helpers\/MPDF57\/mpdf\.php"\);\r?\n/',
            '',
            $src
        );
        // Replace instantiation
        $src = str_replace('new mPDF(', 'new \\Mpdf\\Mpdf(', $src);
        return $src;
    }, $log);
}

// ─────────────────────────────────────────────────────────────────────────────
// STEP 6 — mPDF: controller files
// ─────────────────────────────────────────────────────────────────────────────
echo "\nSTEP 6: mPDF 5.7 → 8.x (controller files)\n";

$mpdf_controllers = [
    BASE . '/application/controllers/Foodcoupon.php',
    BASE . '/application/controllers/BadgesAssign.php',
];

foreach ($mpdf_controllers as $file) {
    fix_file($file, function($src) {
        $src = preg_replace(
            '/[ \t]*include_once \(APP_PATH \. "helpers\/MPDF57\/mpdf\.php"\);\r?\n/',
            '',
            $src
        );
        $src = str_replace('new mPDF(', 'new \\Mpdf\\Mpdf(', $src);
        return $src;
    }, $log);
}

// ─────────────────────────────────────────────────────────────────────────────
// Summary
// ─────────────────────────────────────────────────────────────────────────────
echo "\nDone. File log:\n";
foreach ($log as $entry) {
    echo $entry . "\n";
}
echo "\nVerification — remaining old references:\n";

// Check for any leftover PHPMailer 5.2.4 requires
$remaining_pm = shell_exec('grep -r "PHPMailer_5.2.4" "' . BASE . '/application/controllers" "' . BASE . '/application/models" "' . BASE . '/donationmain.php" "' . BASE . '/CronJobForGMToGD.php" 2>/dev/null');
echo "PHPMailer_5.2.4 requires remaining: " . (empty(trim($remaining_pm)) ? "NONE" : "\n" . $remaining_pm) . "\n";

// Check for any leftover mPDF 5.7 includes
$remaining_mpdf = shell_exec('grep -r "MPDF57/mpdf" "' . BASE . '/application/controllers" "' . BASE . '/application/models" 2>/dev/null');
echo "MPDF57/mpdf includes remaining:    " . (empty(trim($remaining_mpdf)) ? "NONE" : "\n" . $remaining_mpdf) . "\n";

// Check for any leftover phpmailerException
$remaining_exc = shell_exec('grep -r "phpmailerException" "' . BASE . '/application/controllers" "' . BASE . '/donationmain.php" "' . BASE . '/CronJobForGMToGD.php" 2>/dev/null');
echo "phpmailerException remaining:      " . (empty(trim($remaining_exc)) ? "NONE" : "\n" . $remaining_exc) . "\n";

// Check for old new mPDF() without namespace
$remaining_mpdf_new = shell_exec('grep -rn "new mPDF(" "' . BASE . '/application/controllers" "' . BASE . '/application/models" 2>/dev/null');
echo "new mPDF() remaining:              " . (empty(trim($remaining_mpdf_new)) ? "NONE" : "\n" . $remaining_mpdf_new) . "\n";
