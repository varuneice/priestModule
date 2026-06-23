<?php

require_once(ROOT_PATH . 'application/config/functions.inc.php');

$stop = false;
if (isset($_GET['controller']) && $_GET['controller'] == 'Installer') {
    $stop = true;
    if (isset($_GET['install'])) {
        switch ($_GET['install']) {
            case 1:
                $stop = true;
                break;
            default:
                $stop = false;
                break;
        }
    }
}

if (!$stop) {

    define("DEFAULT_HOST", "[hostname]");
    define("DEFAULT_USER", "[username]");
    define("DEFAULT_PASS", "[password]");
    define("DEFAULT_DB", "[database]");
    define("DEFAULT_PREFIX", "[prefix]");

    if (preg_match('/\[hostname\]/', DEFAULT_HOST) || preg_match('/\[username\]/', DEFAULT_USER)) {
        Util::redirect("index.php?controller=Installer&action=step0&install=1");
    }
}

if (!defined("INSTALL_PATH")) {
    define("INSTALL_PATH", "[INSTALL_PATH]");
}
if (!defined("INSTALL_URL")) {
    define("INSTALL_URL", "[INSTALL_URL]");
}
if (!defined("INSTALL_FOLDER")) {
    define("INSTALL_FOLDER", "[INSTALL_FOLDER]");
}

if (!defined("APP_PATH")) {
    define("APP_PATH", ROOT_PATH . "application/");
}
if (!defined("CORE_PATH")) {
    define("CORE_PATH", ROOT_PATH . "core/");
}
if (!defined("LIBS_PATH")) {
    define("LIBS_PATH", "core/libs/");
}
if (!defined("FRAMEWORK_PATH")) {
    define("FRAMEWORK_PATH", CORE_PATH . "framework/");
}
if (!defined("CONFIG_PATH")) {
    define("CONFIG_PATH", APP_PATH . "config/");
}
if (!defined("CONTROLLERS_PATH")) {
    define("CONTROLLERS_PATH", APP_PATH . "controllers/");
}
if (!defined("COMPONENTS_PATH")) {
    define("COMPONENTS_PATH", APP_PATH . "controllers/components/");
}
if (!defined("MODELS_PATH")) {
    define("MODELS_PATH", APP_PATH . "models/");
}
if (!defined("VIEWS_PATH")) {
    define("VIEWS_PATH", APP_PATH . "views/");
}
if (!defined("WEB_PATH")) {
    define("WEB_PATH", APP_PATH . "web/");
}
if (!defined("CSS_PATH")) {
    define("CSS_PATH", "application/web/css/");
}
if (!defined("IMG_PATH")) {
    define("IMG_PATH", "application/web/img/");
}
if (!defined("JS_PATH")) {
    define("JS_PATH", "application/web/js/");
}
if (!defined("UPLOAD_PATH")) {
    define("UPLOAD_PATH", "application/web/upload/");
}
?>