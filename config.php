<?php

// Loads DB credentials and APP_URL/APP_PATH from env.php
require_once __DIR__ . '/application/config/db.php';
require_once __DIR__ . '/application/config/functions.inc.php';

if (!defined('INSTALL_URL')) {
    define('INSTALL_URL', $ENV_APP_URL ?? 'http://localhost:8082/HDBS_Payment/priestModule/');
}

// Connect to database — SSL-aware for remote hosts (e.g. Azure MySQL)
$con = gz_mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
// Check connection
if (!$con || $con->connect_error) {
    die("Connection failed: " . mysqli_connect_error());
}
