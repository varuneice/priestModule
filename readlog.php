<?php
// Temporary log reader — DELETE after debugging
$allowed = ['vendorpayment_debug.log', 'hdbs_debug.log', 'member_create_debug.log'];
$file = $_GET['f'] ?? 'vendorpayment_debug.log';
if (!in_array($file, $allowed)) { die('Invalid file'); }
$path = sys_get_temp_dir() . '/' . $file;
header('Content-Type: text/plain');
echo "=== $file ===\n";
echo file_exists($path) ? file_get_contents($path) : "(file does not exist yet: $path)";
