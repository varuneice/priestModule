<?php
/**
 * Fix CSRF tokens that were inserted inside form action attributes.
 *
 * Root cause: add-csrf-tokens.php matched the close-tag sequence inside a
 * PHP expression in the action attribute as the closing > of the form tag,
 * then inserted the hidden CSRF input between the PHP close tag and the
 * rest of the action URL -- splitting the form tag across lines.
 *
 * Broken pattern (two lines):
 *   <form ... action="<?php echo INSTALL_URL; ?>
 *   <input type="hidden" name="csrf_token" value="...">?controller=X&action=Y">
 *
 * Fixed pattern:
 *   <form ... action="<?php echo INSTALL_URL; ?>?controller=X&action=Y">
 *   <input type="hidden" name="csrf_token" value="...">
 *
 * Usage: php tools/fix-csrf-form-actions.php [--dry-run]
 */

$root    = realpath(__DIR__ . '/../') . '/';
$dry_run = in_array('--dry-run', $argv);

$csrf_input = '<input type="hidden" name="csrf_token" value="<?= $_SESSION[\'csrf_token\'] ?? \'\' ?>">';

$iter = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(
        $root . 'application',
        RecursiveDirectoryIterator::SKIP_DOTS
    )
);

$fixed = 0;

foreach ($iter as $file_info) {
    if ($file_info->getExtension() !== 'php') {
        continue;
    }

    $src = file_get_contents($file_info->getRealPath());

    // Quick check: skip files that don't have the broken pattern
    if (strpos($src, $csrf_input) === false) {
        continue;
    }

    /*
     * Match: PHP close-tag at end of a line (inside a form action attribute)
     *        newline
     *        CSRF hidden input (no leading whitespace -- inserted without indentation)
     *        continuation of action URL ending with "> (closes action attr + form tag)
     *
     * Capture groups:
     *   $1 = the PHP close-tag sequence
     *   $2 = continuation of action URL + closing ">
     */
    $pattern     = '/(\?' . '>)\r?\n' . preg_quote($csrf_input, '/') . '([^\n]*">)/';
    $replacement = '$1$2' . "\n" . $csrf_input;

    $new = preg_replace($pattern, $replacement, $src);

    if ($new === null) {
        echo 'ERROR (preg_replace failed): ' . $file_info->getRealPath() . "\n";
        continue;
    }

    if ($new !== $src) {
        $rel   = str_replace(array('\\', $root), array('/', ''), $file_info->getRealPath());
        $count = preg_match_all($pattern, $src);
        echo ($dry_run ? '[DRY RUN] ' : '') . "Fixed [{$count}]: {$rel}\n";
        ++$fixed;

        if (!$dry_run) {
            file_put_contents($file_info->getRealPath(), $new);
        }
    }
}

echo "\n" . ($dry_run ? '[DRY RUN] ' : '') . "Fixed {$fixed} files.\n";
