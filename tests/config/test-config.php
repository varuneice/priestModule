<?php
/**
 * Test environment database configuration.
 * This connects to the TEST database only — never production.
 */

define('TEST_DB_HOST', 'localhost');
define('TEST_DB_NAME', 'hdbs_test');
define('TEST_DB_USER', 'root');
define('TEST_DB_PASS', '');

define('BASE_URL', 'http://localhost/HDBS_Payment/priestModule');
