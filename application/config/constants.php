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

    // Load credentials from env.php — the single config file. Edit only that file.
    require_once __DIR__ . '/db.php';

    define("DEFAULT_HOST",   $DB_HOST);
    define("DEFAULT_USER",   $DB_USER);
    define("DEFAULT_PASS",   $DB_PASS);
    define("DEFAULT_DB",     $DB_NAME);
    define("DEFAULT_PREFIX", "");

    if (!defined("TWILIO_SID")) {
        define("TWILIO_SID", $ENV_TWILIO_SID ?? "");
    }
    if (!defined("TWILIO_TOKEN")) {
        define("TWILIO_TOKEN", $ENV_TWILIO_TOKEN ?? "");
    }
    if (!defined("TWILIO_FROM")) {
        define("TWILIO_FROM", $ENV_TWILIO_FROM ?? "");
    }
    if (!defined("STRIPE_PUBLISHABLE_KEY")) {
        define("STRIPE_PUBLISHABLE_KEY", $ENV_STRIPE_PUBLISHABLE_KEY ?? "");
    }
    if (!defined("STRIPE_PUJA_SECRET_KEY")) {
        define("STRIPE_PUJA_SECRET_KEY", $ENV_STRIPE_PUJA_SECRET_KEY ?? "");
    }

    if (preg_match('/\[hostname\]/', DEFAULT_HOST) || preg_match('/\[username\]/', DEFAULT_USER)) {
        Util::redirect("index.php?controller=Installer&action=step0&install=1");
    }
}

// if (!defined("INSTALL_PATH")) {
//     define("INSTALL_PATH", "/home2/durgab5/public_html/HDBS_Payment/");
// }
// if (!defined("INSTALL_URL")) {
//     define("INSTALL_URL", "http://localhost/HDBS_Payment/priestModule/");
// }
// if (!defined("INSTALL_FOLDER")) {
//     define("INSTALL_FOLDER", "/HDBS_Payment");
// }




if (!defined("INSTALL_PATH")) {
    define("INSTALL_PATH", $ENV_APP_PATH ?? 'C:/xampp82/htdocs/HDBS_Payment/priestModule/');
}
if (!defined("INSTALL_URL")) {
    define("INSTALL_URL", $ENV_APP_URL ?? 'http://localhost:8082/HDBS_Payment/priestModule/');
}
if (!defined("INSTALL_FOLDER")) {
    define("INSTALL_FOLDER", "/priestModule/");
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
