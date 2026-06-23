<?php
/*
 * Second pass: fix multi-level array curly-brace offsets like
 * $arr[$i]['key']{$n} which the first pass missed.
 */

$file = __DIR__ . '/../application/helpers/MPDF57/mpdf.php';
$src  = file_get_contents($file);

// Pass 1: replace ]{$var} and ]{\d+}
$new = preg_replace('/\]\{(\$\w+|\d+)\}/', '[$1]', $src);

// Pass 2: replace word/quote/paren followed by {$var} or {\d+}
// (covers $var{'key'} style and single-level $str{0})
$new = preg_replace('/([a-zA-Z0-9_\'\"])\{(\$\w+|\d+)\}/', '$1[$2]', $new);

$changed = ($new !== $src);
file_put_contents($file, $new);

// Verify
$lines = explode("\n", $new);
$remaining = [];
foreach ($lines as $i => $line) {
    // Look for variable/array access followed by {
    if (preg_match('/(\$\w|\])\{[\$\d]/', $line)) {
        $remaining[] = ($i + 1) . ': ' . trim($line);
    }
}

echo "Changed: " . ($changed ? 'YES' : 'NO') . PHP_EOL;
echo "Remaining: " . count($remaining) . PHP_EOL;
foreach ($remaining as $r) {
    echo "  $r" . PHP_EOL;
}
