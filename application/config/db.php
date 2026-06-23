<?php
// ============================================================
// DATABASE CONFIGURATION — DO NOT edit credentials here.
// Edit application/config/env.php instead.
// ============================================================

$_env_file = __DIR__ . '/env.php';
if (file_exists($_env_file)) {
    require_once $_env_file;
    $DB_HOST = $ENV_DB_HOST;
    $DB_NAME = $ENV_DB_NAME;
    $DB_USER = $ENV_DB_USER;
    $DB_PASS = $ENV_DB_PASS;
} else {
    // Fallback if env.php is missing — prevents a blank fatal error
    die('Missing config: application/config/env.php not found. Copy env.example.php to env.php and fill in your values.');
}
