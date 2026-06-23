<?php
/**
 * PHPUnit Bootstrap
 * Loaded before any test runs. Sets up DB connection and autoloading.
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config/test-config.php';

// Start session before any output so CSRF tests can use $_SESSION
session_start();

// Establish shared test DB connection (non-fatal — DB-dependent tests skip if unavailable)
$GLOBALS['test_db'] = null;

mysqli_report(MYSQLI_REPORT_OFF); // suppress mysqli connection warnings
$conn = @new mysqli(TEST_DB_HOST, TEST_DB_USER, TEST_DB_PASS, TEST_DB_NAME);
if ($conn->connect_error) {
    fwrite(STDERR, "\n[BOOTSTRAP WARNING] Cannot connect to test database '" . TEST_DB_NAME . "'.\n");
    fwrite(STDERR, "DB-dependent tests will be skipped. To enable them:\n");
    fwrite(STDERR, "  1. Start MySQL via XAMPP Control Panel\n");
    fwrite(STDERR, "  2. Run: bash tests/setup-test-db.sh\n\n");
} else {
    $GLOBALS['test_db'] = $conn;
}

/**
 * Returns the shared test DB connection, or null if unavailable.
 */
function get_test_db(): ?mysqli {
    return $GLOBALS['test_db'];
}
