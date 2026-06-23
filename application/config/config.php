<?php 

// Error reporting: development shows all errors; production logs them silently.
// Set APP_ENV=production in the server environment to enable production mode.
if (getenv('APP_ENV') === 'production') {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

require_once ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'application/config/constants.php';
require_once FRAMEWORK_PATH . 'I18n.php';
require_once ROOT_PATH . 'core/bootstrap.php';
require_once ROOT_PATH . 'application/config/i18n.php';