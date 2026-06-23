<?php
/*
 * Fix remaining curly-brace string/array offset syntax in MPDF57/mpdf.php
 * The previous fix script only caught $var{N} (digit index).
 * This script catches $this->prop{N} and other forms missed before.
 */

$file = __DIR__ . '/../application/helpers/MPDF57/mpdf.php';
$src  = file_get_contents($file);

// Replace: ->property{N} and ->property{$var} style offsets
// Pattern: any ->identifier followed by {digit} or {$var}
$new = preg_replace_callback(
    '/(->\w+)\{(\d+|\$\w+)\}/',
    function($m) { return $m[1] . '[' . $m[2] . ']'; },
    $src
);

// Also catch plain $var{N} that might have been missed (variable names with arrows)
$new = preg_replace_callback(
    '/(\$[\w\->]+)\{(\d+|\$\w+)\}/',
    function($m) { return $m[1] . '[' . $m[2] . ']'; },
    $new
);

$count = substr_count($new, '{') !== substr_count($src, '{') ? 'changed' : 'unchanged';
$replaced = ($new !== $src);

file_put_contents($file, $new);

// Report: find lines still containing ->word{ or $word{ (not inside strings/regex)
$lines = explode("\n", $new);
$remaining = [];
foreach ($lines as $i => $line) {
    if (preg_match('/->\w+\{\d|->(\w+)\{\$|\$\w+\{\d|\$\w+\{\$/', $line)) {
        $remaining[] = ($i + 1) . ': ' . trim($line);
    }
}

echo "Replaced: " . ($replaced ? 'YES' : 'NO') . PHP_EOL;
echo "Remaining curly-brace offset lines: " . count($remaining) . PHP_EOL;
foreach ($remaining as $r) {
    echo "  $r" . PHP_EOL;
}
