<?php
/**
 * fix-timezone-null-guard.php
 * PHP 8.1 deprecated passing null to date_default_timezone_set(string).
 * 28 controllers call it without a null guard.
 *
 * Replaces:
 *   date_default_timezone_set($this->tpl['option_arr_values']['timezone']);
 * With:
 *   $tz = $this->tpl['option_arr_values']['timezone'] ?? '';
 *   if ($tz) {
 *       date_default_timezone_set($tz);
 *   }
 *
 * Also handles the variant with extra whitespace or indentation.
 *
 * Run from project root:
 *   php tools/fix-timezone-null-guard.php
 */

$targets = [
    'application/controllers/Adminpayment.php',
    'application/controllers/Adminpaymentstudent.php',
    'application/controllers/BadgesAssign.php',
    'application/controllers/Badges.php',
    'application/controllers/Booking.php',
    'application/controllers/Calendar.php',
    'application/controllers/Category.php',
    'application/controllers/Discount.php',
    'application/controllers/donationdata.php',
    'application/controllers/Donations.php',
    'application/controllers/Event.php',
    'application/controllers/Eventadmin.php',
    'application/controllers/Foodcoupon.php',
    'application/controllers/giftshop.php',
    'application/controllers/GzInstall.php',
    'application/controllers/Invoice.php',
    'application/controllers/Items.php',
    'application/controllers/Member.php',
    'application/controllers/MemberLog.php',
    'application/controllers/RentalBooking.php',
    'application/controllers/Settings.php',
    'application/controllers/Statistic.php',
    'application/controllers/Student.php',
    'application/controllers/TimePrice.php',
    'application/controllers/User.php',
    'application/controllers/vendordata.php',
    'application/controllers/VendorPayment.php',
    'application/controllers/AppRental.php',
];

$base = dirname(__DIR__);
$fixed = 0;
$skipped = 0;
$noMatch = 0;

foreach ($targets as $rel) {
    $path = $base . '/' . $rel;
    if (!file_exists($path)) {
        echo "MISSING: $rel\n";
        continue;
    }
    $src = file_get_contents($path);

    // Already guarded — skip
    if (strpos($src, 'date_default_timezone_set($tz)') !== false) {
        echo "SKIP (already guarded): $rel\n";
        $skipped++;
        continue;
    }

    // Match: optional indent + date_default_timezone_set($this->tpl['option_arr_values']['timezone']);
    // Capture the leading whitespace so we can replicate indentation.
    $pattern = '/^([ \t]*)date_default_timezone_set\(\$this->tpl\[\'option_arr_values\'\]\[\'timezone\'\]\);[ \t\r]*$/m';

    $new = preg_replace_callback($pattern, function ($m) {
        $indent = $m[1];
        return $indent . '$tz = $this->tpl[\'option_arr_values\'][\'timezone\'] ?? \'\';' . "\n"
             . $indent . 'if ($tz) {' . "\n"
             . $indent . '    date_default_timezone_set($tz);' . "\n"
             . $indent . '}';
    }, $src, -1, $count);

    if ($count === 0) {
        echo "NO MATCH: $rel\n";
        $noMatch++;
        continue;
    }

    file_put_contents($path, $new);
    echo "FIXED ($count occurrence" . ($count > 1 ? 's' : '') . "): $rel\n";
    $fixed++;
}

echo "\nDone. Fixed: $fixed  Skipped (already guarded): $skipped  No match: $noMatch\n";
