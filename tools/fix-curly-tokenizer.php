<?php
/*
 * Fix curly-brace string/array offset syntax using PHP tokenizer.
 * Scans outside of string literals and replaces {expr} offsets with [expr].
 *
 * Approach:
 * 1. Tokenize the file.
 * 2. Walk token-by-token.
 * 3. Track whether we're "inside a string literal" (T_CONSTANT_ENCAPSED_STRING,
 *    T_ENCAPSED_AND_WHITESPACE, heredoc, etc.).
 * 4. When we see an open-brace `{` that:
 *    a. Is NOT inside a string
 *    b. Is NOT T_CURLY_OPEN (${var} interpolation)
 *    c. Follows a token that ends a variable expression (T_VARIABLE, T_STRING, ']')
 *    — replace it with '[' and its matching '}' with ']'.
 *
 * This is complex, so instead we use a simpler but effective approach:
 * reconstruct the file from tokens, replacing `{` with `[` when appropriate.
 */

$file = $argv[1] ?? __DIR__ . '/../application/helpers/MPDF57/mpdf.php';
$src  = file_get_contents($file);
$tokens = @token_get_all($src);

$out = '';
$count = 0;
$last_was_var_expr = false; // whether the last token could end a var expression

foreach ($tokens as $tok) {
    if (is_array($tok)) {
        $type = $tok[0];
        $text = $tok[1];

        // Tokens that can end a variable expression (allow {} offset after them):
        // T_VARIABLE ($var), T_STRING (identifier/method name), T_LNUMBER, T_DNUMBER
        // Also: after ']' (handled below as character token)
        if (in_array($type, [T_VARIABLE, T_STRING, T_LNUMBER, T_DNUMBER,
                              T_CONSTANT_ENCAPSED_STRING])) {
            $last_was_var_expr = true;
        } elseif (in_array($type, [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT])) {
            // Whitespace/comments don't reset the var expr state
        } else {
            $last_was_var_expr = false;
        }

        $out .= $text;
    } else {
        // Character token (single char)
        $char = $tok;

        if ($char === '{' && $last_was_var_expr) {
            // This is a curly-brace offset — replace with [
            // Find the matching }
            $out .= '[';
            $count++;
            $last_was_var_expr = false;
            // We need to replace the corresponding } too.
            // We do this by tracking nesting depth in the output stream,
            // but since we're processing linearly, we need to set a flag.
            // Instead, mark that the next } at depth 0 should be ]
            // We'll handle this with a depth counter.
            // Actually, let's use a different approach: we track the offset-depth.
            // For now, just replace { and trust that the matching } will be at depth 0.
            // This works for simple non-nested expressions like $var{$i} or $var{rand()}.
            // We'll handle it via a post-process step.
            // NOTE: we set a flag here and also process tokens to fix the matching }.
            // This is getting complex. Use a simpler post-processing approach.
        } elseif ($char === ']') {
            $last_was_var_expr = true;
            $out .= $char;
        } elseif ($char === ')') {
            $last_was_var_expr = true;
            $out .= $char;
        } else {
            if ($char !== '{' && $char !== '}') {
                $last_was_var_expr = false;
            }
            $out .= $char;
        }
    }
}

// The tokenizer approach above has a problem: we replace { but not the matching }.
// Use a different strategy: regex with excluded contexts.

// Reset and use a line-by-line regex approach that avoids strings:
// We process the file line by line, and for each line we:
// 1. Extract string literals and replace them with placeholders
// 2. Apply the regex on the non-string parts
// 3. Restore string literals

$lines = explode("\n", $src);
$fixed_lines = [];
$replacements = 0;

foreach ($lines as $line) {
    // Replace string literals with placeholders
    $strings = [];
    $protected = preg_replace_callback(
        '/(?<!\\\)([\'"])(?:[^\\\\\'"]|\\\\.)*\1/',
        function($m) use (&$strings) {
            $key = "\x00STR" . count($strings) . "\x00";
            $strings[$key] = $m[0];
            return $key;
        },
        $line
    );

    // Now apply offset fix to non-string parts
    // Pattern: variable/array expression end followed by {expr}
    // Var expression ends: \w, ], )
    $fixed = preg_replace_callback(
        '/(?<=[a-zA-Z0-9_\]])\{([^{}\'\"]+)\}/',
        function($m) use (&$replacements) {
            // Check if inner expression looks like a regex quantifier
            // (just digits and comma: {3} or {2,5})
            // These inside actual PHP code are offset accesses.
            $replacements++;
            return '[' . $m[1] . ']';
        },
        $protected
    );

    // Restore string literals
    $restored = str_replace(array_keys($strings), array_values($strings), $fixed);
    $fixed_lines[] = $restored;
}

$new = implode("\n", $fixed_lines);

if ($new !== $src) {
    file_put_contents($file, $new);
    echo "Done. Replacements: $replacements" . PHP_EOL;
} else {
    echo "No changes made." . PHP_EOL;
}
