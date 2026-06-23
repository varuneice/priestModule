<?php
/**
 * fix-dynamic-option-arr.php
 * PHP 8.2 deprecated dynamic properties. Every controller that assigns
 * $this->option_arr without declaring it needs "var $option_arr = null;"
 * added to the class body.
 *
 * Strategy: insert the declaration on the line after the first
 * "var $layout = " line in each affected file.
 *
 * Run from project root:
 *   php tools/fix-dynamic-option-arr.php
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
    'application/controllers/MemberLog.php',
    'application/controllers/RentalBooking.php',
    'application/controllers/Settings.php',
    'application/controllers/Statistic.php',
    'application/controllers/Student.php',
    'application/controllers/TimePrice.php',
    'application/controllers/User.php',
    'application/controllers/vendordata.php',
    'application/controllers/VendorPayment.php',
];

$base = dirname(__DIR__);
$fixed = 0;
$skipped = 0;

foreach ($targets as $rel) {
    $path = $base . '/' . $rel;
    if (!file_exists($path)) {
        echo "MISSING: $rel\n";
        continue;
    }
    $src = file_get_contents($path);

    // Already declared — skip
    if (preg_match('/var\s+\$option_arr\b/', $src)) {
        echo "SKIP (already declared): $rel\n";
        $skipped++;
        continue;
    }

    // Insert after the first "var $layout = ..." line (handles both LF and CRLF)
    $new = preg_replace(
        '/([ \t]*var\s+\$layout\s*=[^;]+;)(\r?\n)/',
        "$1$2    var \$option_arr = null;\$2",
        $src,
        1,  // only first occurrence
        $count
    );

    if ($count === 0) {
        echo "NO MATCH (no var \$layout line): $rel\n";
        continue;
    }

    file_put_contents($path, $new);
    echo "FIXED: $rel\n";
    $fixed++;
}

echo "\nDone. Fixed: $fixed  Skipped (already declared): $skipped\n";
