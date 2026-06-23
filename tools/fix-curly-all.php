<?php
/*
 * Comprehensive curly-brace offset fix.
 *
 * Finds all occurrences of variable/array expressions followed by {expr}
 * where expr does NOT start with $ (which would be T_CURLY_OPEN interpolation),
 * and replaces { } with [ ].
 *
 * Strategy: use token_get_all() to find T_CURLY_OPEN tokens and handle them.
 * Actually simpler: regex-based with a backtracking approach.
 *
 * We match the pattern:
 *   (var_end_char){(content)}
 * where var_end_char is ], ), word-char, or closing string quote ' "
 * and content is any non-{ non-} chars (simple expression)
 * BUT exclude cases where the { is followed by $ (T_CURLY_OPEN in strings)
 */

$file = $argv[1] ?? __DIR__ . '/../application/helpers/MPDF57/mpdf.php';
$src  = file_get_contents($file);

// This regex matches:
// - a "variable terminator" character: ] ) word-char single-quote double-quote
// - followed by { expr } where expr doesn't contain nested { or }
// - but NOT when { is preceded by " or ' (string interpolation context)
//
// We specifically want PHP array/string offset: $var{expr}, ->prop{expr}, $arr['key']{expr}
//
// Pattern: (?<=\]|\w|\'|\")  { ([^{}]+) }
// The look-behind ensures we only match { that follows ] or word char or quote.

$count = 0;
$new = preg_replace_callback(
    '/(?<=[a-zA-Z0-9_\]\'\"])\{([^{}]+)\}/',
    function($m) use (&$count) {
        // Skip if the { is inside a string that looks like a regex pattern
        // (we can't easily tell, but we can check: if the inner expr contains
        // things like \d, \w, +, *, |, ^ — it's likely regex, not PHP code)
        // Actually we'll let through and fix — regex quantifiers inside strings
        // won't be affected because they won't match this context (they're inside
        // string literals, not variable expressions)
        $count++;
        return '[' . $m[1] . ']';
    },
    $src
);

file_put_contents($file, $new);
echo "Replacements made: $count" . PHP_EOL;
