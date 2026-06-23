<?php
require_once FRAMEWORK_PATH . 'Object.class.php';

class Controller extends GzObject {

    var $tpl;
    var $js = array();
    var $css = array();
    var $default_user = 'admin_user';
    var $default_order = 'gz_shopping_cart_order';
    var $front_user = 'front_user';
    var $default_language = 'lang';
    var $default_product = 'time_slot_booking';
    var $layout = 'default';
    var $isAjax = false;

    function __construct() {
        
    }

    function beforeFilter() {
        
    }

    function beforeRender() {
        
    }

    function index() {
        
    }

    function isAjax() {
        return $this->isAjax;
    }

    function setIsAjax($bool) {
        $this->isAjax = $bool;
    }

    function getLayout() {
        return $this->layout;
    }

    function getLanguage() {
        return (!empty($_SESSION[$this->default_language])) ? $_SESSION[$this->default_language] : false;
    }

    function setLanguage($lang) {
        $_SESSION[$this->default_language] = $lang;
    }

    function getUserId() {
        return isset($_SESSION[$this->default_user]) && array_key_exists('id', $_SESSION[$this->default_user]) ? $_SESSION[$this->default_user]['id'] : false;
    }
    
    function getMemberId() {
        return isset($_SESSION[$this->default_user]) && array_key_exists('ID', $_SESSION[$this->default_user]) ? $_SESSION[$this->default_user]['ID'] : false;
    }

    function getFrontUserId() {
        return isset($_SESSION[$this->front_user]) && array_key_exists('id', $_SESSION[$this->front_user]) ? $_SESSION[$this->front_user]['id'] : false;
    }

    function getType() {
        return isset($_SESSION[$this->default_user]) && array_key_exists('type', $_SESSION[$this->default_user]) ? $_SESSION[$this->default_user]['type'] : false;
    }

    function isLoged() {
        if (!empty($_SESSION[$this->default_user])) {
            return true;
        }
        return false;
    }

    function isFrontLoged() {

        if (!empty($_SESSION[$this->front_user])) {
            return true;
        }
        return false;
    }

    function getFrontUser() {
        if (!empty($_SESSION[$this->front_user])) {
            return $_SESSION[$this->front_user];
        }
        return false;
    }

    function getUser() {
        if (!empty($_SESSION[$this->default_user])) {
            return $_SESSION[$this->default_user];
        }
        return false;
    }

    function isAdmin() {
        return $this->getType() == 1;
    }
    function isEditor() {
        return $this->getType() == 3;
    }
    function isMember() {
        return @$_SESSION[$this->default_user]['is_member'] == 1;
    }

    function isXHR() {
        return @$_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
    function isVolunteer() {
        return $this->getType() == 5;
    }

    function isParkingAdmin() {
        return $this->getType() == 6;
    }
    
    function isBadgesVolunteer() {
        return $this->getType() == 7;
    }

    function isBadgesAdmin() {
        return $this->getType() == 8;
    }
    
      function isFoodcouponVolunteer() {
        return $this->getType() == 9;
    }

    function isFoodcouponAdmin() {
        return $this->getType() == 10;
    }
    function isEducation() {
        return $this->getType() == 11;
    }
    function isRegistration() {
        return $this->getType() == 12;
    }
    function isRental() {
        return $this->getType() == 13;
    }
    
     function isEvents() {
        return $this->getType() == 14;
    }


    function isVendor() {
        return $this->getType() == 16;
    }

    function getRandomPassword($n = 6, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890') {
        $m = strlen($chars);
        $randPassword = "";
        while ($n--) {
            $randPassword .= $chars[random_int(0, $m - 1)];
        }
        return $randPassword;
    }

    /**
     * Generate a CSRF token for the current session if one does not already exist.
     * Called by Bootstrap::init() on every request before beforeFilter().
     */
    function csrfInit() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    /**
     * Validate the CSRF token on POST requests.
     * Uses hash_equals() to prevent timing attacks.
     * AJAX (XHR) requests are exempt — they rely on the Same-Origin Policy.
     * Called by Bootstrap::init() on every request before beforeFilter().
     */
    function csrfValidate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        if ($this->isXHR()) {
            return;
        }
        $submitted = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
        $stored    = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '';
        if (!hash_equals($stored, $submitted)) {
            http_response_code(403);
            exit('Invalid CSRF token.');
        }
    }

    function setDefaultProduct($str) {
        $this->default_product = $str;
        return $this;
    }

}