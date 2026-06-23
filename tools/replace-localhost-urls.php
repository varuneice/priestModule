<?php
/**
 * Replace hardcoded localhost base URL with the INSTALL_URL constant.
 *
 * Uses PHP's tokenizer to determine string context for each occurrence,
 * then applies the correct substitution:
 *
 *   T_CONSTANT_ENCAPSED_STRING (single-quoted)  →  ' . INSTALL_URL . '
 *   T_CONSTANT_ENCAPSED_STRING (double-quoted)  →  " . INSTALL_URL . "
 *   T_INLINE_HTML (raw HTML/JS in view files)   →  <?= INSTALL_URL ?>
 *
 * T_ENCAPSED_AND_WHITESPACE (double-quoted strings with variable interpolation)
 * is intentionally skipped and reported — those need manual review.
 *
 * Usage:
 *   php tools/replace-localhost-urls.php           # apply changes
 *   php tools/replace-localhost-urls.php --dry-run # preview only
 */

define('URL_TO_REPLACE', 'http://localhost/HDBS_Payment/priestModule/');

// Root of the application (one level up from tools/)
$root = realpath(__DIR__ . '/../') . '/';

$dry_run = in_array('--dry-run', $argv);

// Files to skip — INSTALL_URL fallback is defined here using the localhost URL
$excluded_rel = [
    'application/config/constants.php',
];

// -----------------------------------------------------------------------
// Collect all .php files under application/
// -----------------------------------------------------------------------
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(
        $root . 'application',
        RecursiveDirectoryIterator::SKIP_DOTS
    )
);

$changed     = [];   // rel_path => substitution count
$skipped     = [];   // rel_path => reason (e.g., T_ENCAPSED_AND_WHITESPACE hit)
$total_subs  = 0;

foreach ($files as $file_info) {
    if ($file_info->getExtension() !== 'php') {
        continue;
    }

    $abs = $file_info->getRealPath();
    $rel = str_replace('\\', '/', substr($abs, strlen($root)));

    // Skip excluded files
    if (in_array($rel, $excluded_rel, true)) {
        continue;
    }

    $source = file_get_contents($abs);
    if (strpos($source, URL_TO_REPLACE) === false) {
        continue;
    }

    $tokens = @token_get_all($source);
    if ($tokens === false) {
        $skipped[$rel] = 'tokenizer error';
        continue;
    }

    $output        = '';
    $subs          = 0;
    $has_uncovered = false;

    foreach ($tokens as $token) {
        // Scalar tokens (single characters like ; { } etc.)
        if (!is_array($token)) {
            $output .= $token;
            continue;
        }

        list($type, $text) = $token;

        // Fast path — no URL in this token
        if (strpos($text, URL_TO_REPLACE) === false) {
            $output .= $text;
            continue;
        }

        $occurrences = substr_count($text, URL_TO_REPLACE);

        switch ($type) {

            case T_CONSTANT_ENCAPSED_STRING:
                // Single or double-quoted string with no variable interpolation.
                // The token text includes the surrounding quote characters.
                if ($text[0] === "'") {
                    $text = str_replace(URL_TO_REPLACE, "' . INSTALL_URL . '", $text);
                    // Remove leading empty string: '' .  →  (nothing)
                    $text = preg_replace("/^'' \. /", '', $text);
                    // Remove trailing empty string:  . '' →  (nothing)
                    $text = preg_replace("/ \. ''$/", '', $text);
                } elseif ($text[0] === '"') {
                    $text = str_replace(URL_TO_REPLACE, '" . INSTALL_URL . "', $text);
                    // Remove leading empty string: "" .  →  (nothing)
                    $text = preg_replace('/^"" \. /', '', $text);
                    // Remove trailing empty string:  . "" →  (nothing)
                    $text = preg_replace('/ \. ""$/', '', $text);
                }
                $subs += $occurrences;
                break;

            case T_INLINE_HTML:
                // Raw HTML / JavaScript output outside PHP tags (view files).
                $text = str_replace(URL_TO_REPLACE, '<?= INSTALL_URL ?>', $text);
                $subs += $occurrences;
                break;

            case T_ENCAPSED_AND_WHITESPACE:
                // Text segment inside a double-quoted string that also has
                // interpolated PHP variables.  Inserting " . INSTALL_URL . "
                // here would require restructuring the surrounding token stream.
                // Flag for manual review instead.
                $has_uncovered = true;
                break;

            default:
                // Any other token type — leave unchanged.
                break;
        }

        $output .= $text;
    }

    if ($has_uncovered) {
        $skipped[$rel] = 'contains T_ENCAPSED_AND_WHITESPACE occurrences — manual fix required';
    }

    if ($subs > 0) {
        $changed[$rel] = $subs;
        $total_subs   += $subs;

        if (!$dry_run) {
            file_put_contents($abs, $output);
        }
    }
}

// -----------------------------------------------------------------------
// Report
// -----------------------------------------------------------------------
$label = $dry_run ? '[DRY RUN] ' : '';

echo "{$label}Replaced URL in " . count($changed) . " files ({$total_subs} substitutions):\n\n";
foreach ($changed as $rel => $count) {
    $flag = isset($skipped[$rel]) ? ' [!]' : '';
    echo "  [{$count}]{$flag}  {$rel}\n";
}

if (!empty($skipped)) {
    echo "\n{$label}Skipped / needs manual fix (" . count($skipped) . " files):\n\n";
    foreach ($skipped as $rel => $reason) {
        echo "  {$rel}\n    → {$reason}\n";
    }
}

echo "\nDone.\n";
