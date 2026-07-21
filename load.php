<?php
ini_set("display_errors", "Off");

if (!headers_sent()) {
    @session_name('TimeSlotBookingCalendarPHP');
    @session_start();
    require_once __DIR__ . '/application/config/otp_session.php';
    header("Content-type: text/html; charset=utf-8");
}

if (!defined("ROOT_PATH")) {
    define("ROOT_PATH", dirname(__FILE__) . '/');
}

if (!defined("INSTALL_FOLDER")) {
    $pathinfo = pathinfo($_SERVER["PHP_SELF"]);
    define("INSTALL_FOLDER", $pathinfo['dirname'] . '/');
}

require_once ROOT_PATH . 'application/config/config.php';
require_once FRAMEWORK_PATH . 'I18n.php';
$I18n = new I18n();

$app = new Bootstrap();
$app->setController(@$_REQUEST['controller']);
$app->setAction(@$_REQUEST['action']);
$app->init();
