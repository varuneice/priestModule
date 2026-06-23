<?php
/**
 * CSRF Protection Tests
 *
 * RED phase  : These tests FAIL now, confirming that the base Controller
 *              has no CSRF token validation and forms have no CSRF tokens.
 * GREEN phase: Tests PASS after CSRF validation is added to the base Controller
 *              and tokens are embedded in all POST forms.
 *
 * Strategy: Read the actual Controller base class and view files to verify
 * CSRF token generation and validation code is present.
 */

use PHPUnit\Framework\TestCase;

class CsrfTest extends TestCase
{
    private string $root;

    protected function setUp(): void
    {
        $this->root = realpath(__DIR__ . '/../../');
    }

    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    private function fileContains(string $file, string $pattern, bool $is_regex = false): bool
    {
        $path = $this->root . '/' . $file;
        if (!file_exists($path)) {
            return false;
        }
        $content = file_get_contents($path);
        if ($is_regex) {
            return (bool) preg_match($pattern, $content);
        }
        return strpos($content, $pattern) !== false;
    }

    private function countPostFormsWithoutCsrfToken(string $dir): array
    {
        $path  = $this->root . '/' . $dir;
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        $violations = [];
        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') continue;

            $content  = file_get_contents($file->getPathname());
            $relative = str_replace($this->root . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $relative = str_replace('\\', '/', $relative);

            // Find POST forms
            if (!preg_match('/<form[^>]+method\s*=\s*["\']post["\']/i', $content)) {
                continue;
            }

            // Check if the form contains a CSRF token hidden input
            if (!preg_match('/name\s*=\s*["\']csrf_token["\']/i', $content)) {
                $violations[] = $relative;
            }
        }

        return $violations;
    }

    // -----------------------------------------------------------------------
    // Tests
    // -----------------------------------------------------------------------

    /**
     * Verify that the base Controller validates CSRF tokens on POST requests.
     * FAILS until CSRF check is added to core/framework/Controller.class.php.
     *
     * @group csrf
     * @group vulnerable
     */
    public function testBaseControllerValidatesCsrfToken(): void
    {
        $file = 'core/framework/Controller.class.php';

        $has_csrf_check = $this->fileContains($file, 'csrf_token', false);

        $this->assertTrue(
            $has_csrf_check,
            "VULNERABILITY: core/framework/Controller.class.php has no CSRF token validation.\n" .
            "Add a check for \$_SESSION['csrf_token'] on all POST requests in beforeFilter() or equivalent."
        );
    }

    /**
     * Verify that the base Controller generates a CSRF token for views.
     * FAILS until token generation is added.
     *
     * @group csrf
     * @group vulnerable
     */
    public function testBaseControllerGeneratesCsrfToken(): void
    {
        $file = 'core/framework/Controller.class.php';

        $has_token_generation = $this->fileContains($file, 'random_bytes', false) ||
                                $this->fileContains($file, 'csrf_token', false);

        $this->assertTrue(
            $has_token_generation,
            "VULNERABILITY: Base Controller does not generate a CSRF token using random_bytes().\n" .
            "Add: \$_SESSION['csrf_token'] = bin2hex(random_bytes(32)); in the controller setup."
        );
    }

    /**
     * Verify that POST forms in views include a CSRF token hidden input.
     * FAILS until csrf_token fields are added to all forms.
     *
     * @group csrf
     * @group vulnerable
     */
    public function testViewFormsContainCsrfToken(): void
    {
        $violations = $this->countPostFormsWithoutCsrfToken('application/views');

        $this->assertEmpty(
            $violations,
            count($violations) . " view file(s) have POST forms without a CSRF token hidden input:\n" .
            implode("\n", array_map(fn($f) => "  - {$f}", $violations))
        );
    }

    /**
     * Verify that the base Controller uses hash_equals() for timing-safe comparison.
     * FAILS until hash_equals is used in the CSRF check.
     *
     * @group csrf
     * @group vulnerable
     */
    public function testBaseControllerUsesTimingSafeComparison(): void
    {
        $file = 'core/framework/Controller.class.php';

        $has_hash_equals = $this->fileContains($file, 'hash_equals', false);

        $this->assertTrue(
            $has_hash_equals,
            "VULNERABILITY: Base Controller should use hash_equals() for CSRF token comparison.\n" .
            "Using === is vulnerable to timing attacks. Use: hash_equals(\$_SESSION['csrf_token'], \$submitted_token)"
        );
    }

    /**
     * Verify CSRF token generation uses cryptographically secure random.
     * srand()/rand() must not be used for token generation.
     *
     * Skipped in the red phase (before CSRF is implemented) because this test
     * is a guard against a *bad fix* — there is nothing to validate until
     * csrf_token code is present in the Controller.
     *
     * NOTE: Controller.class.php contains srand() on line ~154 for password
     * generation (unrelated to CSRF). This test only runs once csrf_token
     * is present so we can verify the CSRF implementation specifically uses
     * random_bytes() and not srand().
     *
     * @group csrf
     * @group target
     */
    public function testCsrfTokenDoesNotUseSrand(): void
    {
        $file = 'core/framework/Controller.class.php';

        // Skip until CSRF token code is actually present in the Controller
        if (!$this->fileContains($file, 'csrf_token', false)) {
            $this->markTestSkipped(
                'CSRF token not yet implemented in Controller — skipping srand guard check.'
            );
        }

        // Once csrf_token IS present: ensure random_bytes() is used, not srand()
        $uses_srand = $this->fileContains($file, '/srand\s*\(/i', true);

        $this->assertFalse(
            $uses_srand,
            "CSRF token generation must not use srand() — it produces predictable values.\n" .
            "Use random_bytes(32) instead."
        );
    }
}
