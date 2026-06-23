<?php
/**
 * XSS (Cross-Site Scripting) Tests
 *
 * RED phase  : These tests FAIL now, confirming that view files echo variables
 *              without htmlspecialchars() / h() escaping.
 * GREEN phase: Tests PASS after all output is wrapped in h() or htmlspecialchars().
 *
 * Strategy: Scan actual view and controller files for echo/print statements
 * that output variables without escaping. Any unescaped output fails.
 */

use PHPUnit\Framework\TestCase;

class XssTest extends TestCase
{
    private string $root;

    // Directories containing output files to scan
    private array $scan_dirs = [
        'application/views',
        'application/controllers',
    ];

    // Files known to echo member/user data without escaping
    private array $known_vulnerable_files = [
        'application/controllers/Donations.php',
        'application/controllers/Member.php',
        'application/controllers/Admin.php',
        'application/controllers/GzFront.php',
    ];

    protected function setUp(): void
    {
        $this->root = realpath(__DIR__ . '/../../');
    }

    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    /**
     * Find lines in a file that echo a variable WITHOUT htmlspecialchars or h().
     * Catches patterns like:
     *   echo $var;
     *   echo "...$var...";
     *   <?= $var ?>
     *   echo "<input value='$var'>";
     */
    private function findUnescapedEchoLines(string $file): array
    {
        $path = $this->root . '/' . $file;
        if (!file_exists($path)) {
            return [];
        }

        $lines   = file($path, FILE_IGNORE_NEW_LINES);
        $matches = [];

        foreach ($lines as $n => $line) {
            $trimmed = ltrim($line);

            // Skip comments
            if (strpos($trimmed, '//') === 0 || strpos($trimmed, '*') === 0 || strpos($trimmed, '#') === 0) {
                continue;
            }

            // Look for echo/print with a variable, NOT wrapped in htmlspecialchars or h()
            if (preg_match('/\becho\b.*\$[a-zA-Z_]/', $line) || preg_match('/<\?=\s*\$[a-zA-Z_]/', $line)) {
                // Skip lines that already use escaping functions
                if (preg_match('/htmlspecialchars\s*\(|htmlentities\s*\(|\bh\s*\(/', $line)) {
                    continue;
                }
                // Skip lines that only echo static strings or numeric values
                if (preg_match('/echo\s+["\'][^$]*["\']/', $line)) {
                    continue;
                }
                $matches[] = sprintf('Line %d: %s', $n + 1, trim($line));
            }
        }

        return $matches;
    }

    // -----------------------------------------------------------------------
    // Tests — one per known-vulnerable file
    // -----------------------------------------------------------------------

    /**
     * @group xss
     * @group vulnerable
     */
    public function testDonationsControllerHasNoUnescapedOutput(): void
    {
        $found = $this->findUnescapedEchoLines('application/controllers/Donations.php');

        $this->assertEmpty(
            $found,
            "Donations.php echoes variables without htmlspecialchars()/h() on " .
            count($found) . " line(s):\n" . implode("\n", array_slice($found, 0, 10))
        );
    }

    /**
     * @group xss
     * @group vulnerable
     */
    public function testMemberControllerHasNoUnescapedOutput(): void
    {
        $found = $this->findUnescapedEchoLines('application/controllers/Member.php');

        $this->assertEmpty(
            $found,
            "Member.php echoes variables without htmlspecialchars()/h() on " .
            count($found) . " line(s):\n" . implode("\n", array_slice($found, 0, 10))
        );
    }

    /**
     * @group xss
     * @group vulnerable
     */
    public function testAdminControllerHasNoUnescapedOutput(): void
    {
        $found = $this->findUnescapedEchoLines('application/controllers/Admin.php');

        $this->assertEmpty(
            $found,
            "Admin.php echoes variables without htmlspecialchars()/h() on " .
            count($found) . " line(s):\n" . implode("\n", array_slice($found, 0, 10))
        );
    }

    /**
     * @group xss
     * @group vulnerable
     */
    public function testGzFrontControllerHasNoUnescapedOutput(): void
    {
        $found = $this->findUnescapedEchoLines('application/controllers/GzFront.php');

        $this->assertEmpty(
            $found,
            "GzFront.php echoes variables without htmlspecialchars()/h() on " .
            count($found) . " line(s):\n" . implode("\n", array_slice($found, 0, 10))
        );
    }

    /**
     * Scan all view files and report any that echo unescaped variables.
     *
     * @group xss
     * @group vulnerable
     */
    public function testViewFilesHaveNoUnescapedOutput(): void
    {
        $views_dir = $this->root . '/application/views';
        $files     = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($views_dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        $all_violations = [];
        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') continue;

            $relative = str_replace($this->root . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $relative = str_replace('\\', '/', $relative);
            $found    = $this->findUnescapedEchoLines($relative);

            if (!empty($found)) {
                $all_violations[$relative] = count($found);
            }
        }

        $summary = '';
        foreach ($all_violations as $file => $count) {
            $summary .= "  {$file}: {$count} unescaped echo(s)\n";
        }

        $this->assertEmpty(
            $all_violations,
            count($all_violations) . " view file(s) echo variables without escaping:\n" . $summary
        );
    }

    /**
     * Verify that a properly escaped file is NOT flagged (positive control).
     * This should always pass.
     *
     * @group xss
     * @group target
     */
    public function testProperlyEscapedOutputIsNotFlagged(): void
    {
        $safe_code = <<<'PHP'
<?php
echo htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8');
echo h($value['Member_id']);
?><input value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
PHP;
        $tmp = $this->root . '/tests/tmp/safe_view.php';
        file_put_contents($tmp, $safe_code);

        $found = $this->findUnescapedEchoLines('tests/tmp/safe_view.php');
        unlink($tmp);

        $this->assertEmpty(
            $found,
            "Properly escaped output should NOT be flagged by the XSS scanner"
        );
    }
}
