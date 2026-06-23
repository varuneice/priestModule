<?php
/**
 * SQL Injection Tests
 *
 * RED phase  : These tests FAIL now, confirming vulnerabilities exist in the codebase.
 * GREEN phase: Tests PASS after prepared statements replace raw interpolation.
 *
 * Strategy: Read the actual source files and assert that no raw $_GET/$_POST
 * interpolation exists in SQL strings. A file with raw interpolation fails.
 * A file using prepared statements / query builder passes.
 */

use PHPUnit\Framework\TestCase;

class SqlInjectionTest extends TestCase
{
    // Files confirmed to contain raw SQL interpolation
    private array $vulnerable_files = [
        'donation.php',
        'donationmore.php',
        'ajax-db-search.php',
        'ajax-db-search-lookup.php',
        'application/controllers/GzFront.php',
        'application/controllers/Booking.php',
        'application/controllers/Member.php',
    ];

    private string $root;

    protected function setUp(): void
    {
        $this->root = realpath(__DIR__ . '/../../');
    }

    // -----------------------------------------------------------------------
    // Pattern detection helpers
    // -----------------------------------------------------------------------

    /**
     * Returns all lines in $file that contain a SQL string with a directly
     * interpolated superglobal ($_GET, $_POST, $_REQUEST, $_COOKIE).
     */
    private function findRawInterpolationLines(string $file): array
    {
        $path = $this->root . '/' . $file;
        if (!file_exists($path)) {
            return [];
        }

        // Strip block comments before scanning to avoid false positives
        $content = file_get_contents($path);
        $content = preg_replace('~/\*.*?\*/~s', '', $content);
        $lines   = explode("\n", $content);
        $matches = [];

        foreach ($lines as $n => $line) {
            $trimmed = ltrim($line);

            // Skip single-line comments
            if (strpos($trimmed, '//') === 0 || strpos($trimmed, '*') === 0 || strpos($trimmed, '#') === 0) {
                continue;
            }

            // Skip if superglobal is safely cast to int before use
            if (preg_match('/\(int\)\s*\$_(GET|POST|REQUEST|COOKIE)\s*\[/i', $line)) {
                continue;
            }

            // Skip query builder ->where() method calls — the query builder
            // uses parameterized placeholders internally (see CommonQuery.php)
            if (preg_match('/->where\s*\(/i', $line) && !preg_match('/"[^"]*\$_(GET|POST|REQUEST|COOKIE)/i', $line)) {
                continue;
            }

            // Detect superglobal used directly inside a SQL string (interpolated or concatenated)
            // Matches: "...LIKE '{$_GET['term']}%'" or "... = " . $_POST['id']
            if (preg_match('/\b(SELECT|INSERT|UPDATE|DELETE|WHERE|FROM)\b.*\$_(GET|POST|REQUEST|COOKIE)\s*\[/i', $line)) {
                $matches[] = sprintf('Line %d: %s', $n + 1, trim($line));
            }
        }

        return $matches;
    }

    /**
     * Returns all lines in $file that build a SQL string using variable
     * interpolation (e.g. "$var" or {$var} inside a quoted SQL string).
     */
    private function findStringInterpolationInSql(string $file): array
    {
        $path = $this->root . '/' . $file;
        if (!file_exists($path)) {
            return [];
        }

        $lines   = file($path, FILE_IGNORE_NEW_LINES);
        $matches = [];

        foreach ($lines as $n => $line) {
            // SQL keyword + a variable interpolated inside a quoted string
            if (preg_match('/\b(SELECT|INSERT|UPDATE|DELETE|WHERE)\b[^;]*["\'].*\$[a-zA-Z_].*["\']/', $line)) {
                // Exclude lines that are comments
                $trimmed = ltrim($line);
                if (strpos($trimmed, '//') === 0 || strpos($trimmed, '*') === 0 || strpos($trimmed, '#') === 0) {
                    continue;
                }
                $matches[] = sprintf('Line %d: %s', $n + 1, trim($line));
            }
        }

        return $matches;
    }

    // -----------------------------------------------------------------------
    // Tests — one per confirmed-vulnerable file
    // -----------------------------------------------------------------------

    /**
     * @group sql-injection
     * @group vulnerable
     */
    public function testDonationPhpHasNoRawSqlInterpolation(): void
    {
        $found = $this->findRawInterpolationLines('donation.php');

        $this->assertEmpty(
            $found,
            "donation.php contains raw \$_GET/\$_POST in SQL strings — use prepared statements:\n" .
            implode("\n", $found)
        );
    }

    /**
     * @group sql-injection
     * @group vulnerable
     */
    public function testDonationMorePhpHasNoRawSqlInterpolation(): void
    {
        $found = $this->findRawInterpolationLines('donationmore.php');

        $this->assertEmpty(
            $found,
            "donationmore.php contains raw \$_GET/\$_POST in SQL strings — use prepared statements:\n" .
            implode("\n", $found)
        );
    }

    /**
     * @group sql-injection
     * @group vulnerable
     */
    public function testAjaxDbSearchHasNoRawSqlInterpolation(): void
    {
        $found = $this->findRawInterpolationLines('ajax-db-search.php');

        $this->assertEmpty(
            $found,
            "ajax-db-search.php contains raw \$_GET/\$_POST in SQL strings — this endpoint is public-facing:\n" .
            implode("\n", $found)
        );
    }

    /**
     * @group sql-injection
     * @group vulnerable
     */
    public function testAjaxDbSearchLookupHasNoRawSqlInterpolation(): void
    {
        $found = $this->findRawInterpolationLines('ajax-db-search-lookup.php');

        $this->assertEmpty(
            $found,
            "ajax-db-search-lookup.php contains raw \$_GET/\$_POST in SQL strings — this endpoint is public-facing:\n" .
            implode("\n", $found)
        );
    }

    /**
     * @group sql-injection
     * @group vulnerable
     */
    public function testGzFrontControllerHasNoRawSqlInterpolation(): void
    {
        $found = $this->findRawInterpolationLines('application/controllers/GzFront.php');

        $this->assertEmpty(
            $found,
            "GzFront.php contains raw \$_GET/\$_POST in SQL strings:\n" .
            implode("\n", $found)
        );
    }

    /**
     * @group sql-injection
     * @group vulnerable
     */
    public function testBookingControllerHasNoRawSqlInterpolation(): void
    {
        $found = $this->findRawInterpolationLines('application/controllers/Booking.php');

        $this->assertEmpty(
            $found,
            "Booking.php contains raw \$_GET/\$_POST in SQL strings:\n" .
            implode("\n", $found)
        );
    }

    /**
     * @group sql-injection
     * @group vulnerable
     */
    public function testMemberControllerHasNoRawSqlInterpolation(): void
    {
        $found = $this->findRawInterpolationLines('application/controllers/Member.php');

        $this->assertEmpty(
            $found,
            "Member.php contains raw \$_GET/\$_POST in SQL strings:\n" .
            implode("\n", $found)
        );
    }

    /**
     * Verify prepared statements work correctly when used (positive control).
     * This test should always pass — it proves our detection logic isn't broken.
     *
     * @group sql-injection
     * @group target
     */
    public function testPreparedStatementPatternIsNotFlaggedAsDangerous(): void
    {
        // Write a temp file that uses proper prepared statements
        $safe_code = <<<'PHP'
<?php
$stmt = $pdo->prepare("SELECT * FROM members WHERE Member_id = ?");
$stmt->execute([$_GET['id']]);
$stmt2 = $db->prepare("UPDATE donation SET status=? WHERE id=?");
PHP;
        $tmp = $this->root . '/tests/tmp/safe_example.php';
        file_put_contents($tmp, $safe_code);

        $found = $this->findRawInterpolationLines('tests/tmp/safe_example.php');
        unlink($tmp);

        $this->assertEmpty(
            $found,
            "Prepared statement pattern should NOT be flagged as dangerous"
        );
    }
}
