<?php
/*
 * Fix mpdf.php for PHP 8.0+ compatibility:
 * 1. each() -> foreach (5 locations)
 * 2. get_magic_quotes_runtime() check removed
 * 3. Curly-brace string/array offset syntax -> square brackets
 *    (preserves the ] that precedes the {})
 */

$file = __DIR__ . '/../application/helpers/MPDF57/mpdf.php';
$src  = file_get_contents($file);
$new  = $src;

// ── FIX 1: each() replacements ────────────────────────────────────────────

// 1a: reset($this->images) + while(list=each($this->images))
$tab2 = str_repeat("\t", 2);
$old1a = $tab2 . "reset(\$this->images);\n" .
         $tab2 . "while (list(\$file, \$info) = each(\$this->images)) {";
$new1a = $tab2 . "foreach (\$this->images as \$file => \$info) {";
$new = str_replace($old1a, $new1a, $new);

// 1b: reset($this->formobjects) + while(list=each($this->formobjects))
$old1b = $tab2 . "reset(\$this->formobjects);\n" .
         $tab2 . "while (list(\$file, \$info) = each(\$this->formobjects)) {";
$new1b = $tab2 . "foreach (\$this->formobjects as \$file => \$info) {";
$new = str_replace($old1b, $new1b, $new);

// 1c: nested each() in _putimportedobjects (6-tab indentation)
$tab6 = str_repeat("\t", 6);
$tab7 = str_repeat("\t", 7);
$tab8 = str_repeat("\t", 8);
$old1c = $tab6 . "reset(\$tpl['resources'][1]);\n" .
         $tab6 . "while (list(\$k, \$v) = each(\$tpl['resources'][1])) {\n" .
         $tab7 . "if (\$k == '/Shading') {\n" .
         $tab8 . "while (list(\$k2, \$v2) = each(\$v[1])) {";
$new1c = $tab6 . "foreach (\$tpl['resources'][1] as \$k => \$v) {\n" .
         $tab7 . "if (\$k == '/Shading') {\n" .
         $tab8 . "foreach (\$v[1] as \$k2 => \$v2) {";
$new = str_replace($old1c, $new1c, $new);

// 1d: reset($value[1]) + while(list=each($value[1])) — 4-tab indentation
$tab4 = str_repeat("\t", 4);
$old1d = $tab4 . "reset(\$value[1]);\n" .
         $tab4 . "while (list(\$k, \$v) = each(\$value[1])) {";
$new1d = $tab4 . "foreach (\$value[1] as \$k => \$v) {";
$new = str_replace($old1d, $new1d, $new);

// ── FIX 2: magic_quotes_runtime removal ───────────────────────────────────

$tab1 = "\t";
$old2 = $tab2 . "\$mqr = ini_get(\"magic_quotes_runtime\");\n" .
        $tab2 . "if (\$mqr) {\n" .
        $tab2 . $tab1 . "throw new MpdfException('mPDF requires magic_quotes_runtime to be turned off e.g. by using ini_set(\"magic_quotes_runtime\", 0);');\n" .
        $tab2 . "}\n";
$new = str_replace($old2, '', $new);

// ── FIX 3: Curly-brace offset syntax ──────────────────────────────────────
// IMPORTANT: must preserve the ] that precedes {
// Patterns to fix:
//   ->property{N}      -> ->property[N]
//   ->property{$var}   -> ->property[$var]
//   $var['key']{N}     -> $var['key'][N]   (] comes from key, not consumed)
//   $var[$c]['key']{$i}-> $var[$c]['key'][$i]

// Pass A: ]{digit}  or  ]{$var}  -> ][$1]   (keep the ])
$new = preg_replace('/\]\{(\$[\w]+|\d+)\}/', '][$1]', $new);

// Pass B: ->word{digit} or ->word{$var}
$new = preg_replace('/(->\w+)\{(\$[\w]+|\d+)\}/', '$1[$2]', $new);

// Pass C: $word{digit} or $word{$var} (simple scalar variables)
$new = preg_replace('/(\$\w+)\{(\$[\w]+|\d+)\}/', '$1[$2]', $new);

// ── Verify and report ──────────────────────────────────────────────────────

$changed = ($new !== $src);
file_put_contents($file, $new);

// Check for remaining curly-brace offsets (not inside regex strings)
$lines = explode("\n", $new);
$issues = [];
foreach ($lines as $i => $line) {
    $stripped = preg_replace('/preg_[a-z_]+\(.*/', '', $line); // remove regex calls
    if (preg_match('/(\]\{|\->\w+\{|\$\w+\{)[\$\d]/', $stripped)) {
        $issues[] = ($i + 1) . ': ' . trim($line);
    }
}

echo "Changed: " . ($changed ? 'YES' : 'NO') . PHP_EOL;
echo "each() and magic_quotes fixes applied." . PHP_EOL;
echo "Remaining curly-brace offset issues: " . count($issues) . PHP_EOL;
foreach ($issues as $r) {
    echo "  $r" . PHP_EOL;
}
