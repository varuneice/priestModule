<?php
/**
 * One-time script: add CSRF hidden input to every view file that contains a
 * POST form but does not yet have a csrf_token field.
 *
 * Run from CLI: php tools/add-csrf-tokens.php
 * Safe to re-run — files that already have csrf_token are skipped.
 */

$views_dir = dirname(__DIR__) . '/application/views';

$csrf_field = '<input type="hidden" name="csrf_token" value="<?= $_SESSION[\'csrf_token\'] ?? \'\' ?>">';

$it = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($views_dir, RecursiveDirectoryIterator::SKIP_DOTS)
);

$updated  = 0;
$skipped  = 0;
$no_form  = 0;

foreach ($it as $file) {
    if (strtolower($file->getExtension()) !== 'php') {
        continue;
    }

    $content = file_get_contents($file->getPathname());

    // Already protected
    if (stripos($content, 'csrf_token') !== false) {
        $skipped++;
        continue;
    }

    // No POST form in this file
    if (!preg_match('/<form\b[\s\S]*?method\s*=\s*["\']post["\']/i', $content)) {
        $no_form++;
        continue;
    }

    // Insert the hidden input immediately after every POST form's opening tag.
    // The regex matches <form ...> including multiline form tags ([\s\S]*? is lazy
    // and stops at the first >, which is always the end of the opening tag in practice).
    $new_content = preg_replace_callback(
        '/<form\b([\s\S]*?)>/i',
        function ($matches) use ($csrf_field) {
            if (preg_match('/method\s*=\s*["\']post["\']/i', $matches[0])) {
                return $matches[0] . "\n" . $csrf_field;
            }
            return $matches[0];
        },
        $content
    );

    if ($new_content !== $content) {
        file_put_contents($file->getPathname(), $new_content);
        $updated++;
        $rel = ltrim(str_replace([$views_dir, '\\'], ['', '/'], $file->getPathname()), '/');
        echo "UPDATED : $rel\n";
    }
}

echo "\n";
echo "Updated  : $updated files\n";
echo "Skipped (already had csrf_token) : $skipped files\n";
echo "Skipped (no POST form)           : $no_form files\n";
