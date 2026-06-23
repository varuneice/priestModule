<?php

class Util {

    /**
     * Redirect browser
     *
     * @param string $url
     * @param int $http_response_code
     * @param bool $exit
     * @return void
     * @access public
     * @static
     */
    public static $slot_lenght = array(
        '' => 'Select Timeslot',
        '10' => '10 minutes',
        '15' => '15 minutes',
        '20' => '20 minutes',
        '30' => '30 minutes',
        '60' => '1 hour',
        '120' => '2 hours',
        '180' => '3 hours',
        '240' => '4 hours',
        '300' => '5 hours',
        '360' => '6 hours',
        '420' => '7 hours',
        '480' => '8 hours',
        '540' => '9 hours',
        '600' => '10 hours',
        '660' => '11 hours',
        '720' => '12 hours',
    );
    public static $currencies = array(
        'AUD' => array('name' => "Australian Dollar", 'symbol' => "A$", 'ASCII' => "A&#36;"),
        'CAD' => array('name' => "Canadian Dollar", 'symbol' => "$", 'ASCII' => "&#36;"),
        'CZK' => array('name' => "Czech Koruna", 'symbol' => "Kč", 'ASCII' => ""),
        'DKK' => array('name' => "Danish Krone", 'symbol' => "Kr", 'ASCII' => ""),
        'EUR' => array('name' => "Euro", 'symbol' => "€", 'ASCII' => "&#128;"),
        'HKD' => array('name' => "Hong Kong Dollar", 'symbol' => "$", 'ASCII' => "&#36;"),
        'HUF' => array('name' => "Hungarian Forint", 'symbol' => "Ft", 'ASCII' => ""),
        'ILS' => array('name' => "Israeli New Sheqel", 'symbol' => "₪", 'ASCII' => "&#8361;"),
        'JPY' => array('name' => "Japanese Yen", 'symbol' => "¥", 'ASCII' => "&#165;"),
        'MXN' => array('name' => "Mexican Peso", 'symbol' => "$", 'ASCII' => "&#36;"),
        'NOK' => array('name' => "Norwegian Krone", 'symbol' => "Kr", 'ASCII' => ""),
        'NZD' => array('name' => "New Zealand Dollar", 'symbol' => "$", 'ASCII' => "&#36;"),
        'PHP' => array('name' => "Philippine Peso", 'symbol' => "₱", 'ASCII' => ""),
        'PLN' => array('name' => "Polish Zloty", 'symbol' => "zł", 'ASCII' => ""),
        'GBP' => array('name' => "Pound Sterling", 'symbol' => "£", 'ASCII' => "&#163;"),
        'SGD' => array('name' => "Singapore Dollar", 'symbol' => "$", 'ASCII' => "&#36;"),
        'SEK' => array('name' => "Swedish Krona", 'symbol' => "kr", 'ASCII' => ""),
        'CHF' => array('name' => "Swiss Franc", 'symbol' => "CHF", 'ASCII' => ""),
        'TWD' => array('name' => "Taiwan New Dollar", 'symbol' => "NT$", 'ASCII' => "NT&#36;"),
        'THB' => array('name' => "Thai Baht", 'symbol' => "฿", 'ASCII' => "&#3647;"),
        'USD' => array('name' => "U.S. Dollar", 'symbol' => "$", 'ASCII' => "&#36;")
    );
    public static $member_tokens = array(
        'ID' => '{ID}',
        'information' => '{Information}',
        'GovtissueID' => '{GovtissueID}',
        'membership_type' => '{MembershipType}',
        'Member_id' => '{Memberid}',
        'Category' => '{Category}',
        'F_Name' => '{F_Name}',
        'L_Name' => '{L_Name}',
        'Mob_No' => '{Mob_No}',
        'Sp_FName' => '{Sp_FName}',
        'Address1' => '{Address1}',
        'Address2' => '{Address2}',
        'Address3' => '{Address3}',
        'City' => '{City}',
        'State' => '{State}',
        'Country' => '{Country}',
        'Zip' => '{Zip}',
        'email' => '{Email}',
        'Email2' => '{Email2}',
        'Tele1' => '{Tele1}',
        'Tele2' => '{Tele2}',
        'Child1' => '{Child1}',
        'Age1' => '{Age1}',
        'Child2' => '{Child2}',
        'Age2' => '{Age2}',
        'Child3' => '{Child3}',
        'Age3' => '{Age3}',
        'Parent1' => '{Parent1}',
        'Parent2' => '{Parent2}',
        'remarks' => '{Remarks}',
        'swap' => '{Swap}',
        'FirstSal' => '{FirstSal}',
        'Payment_method' => '{Payment_method}',
        'SpouseSal' => '{SpouseSal}',
        'CreatedOn' => '{CreatedOn}',
        'password' => '{Password}',
        'type' => '{Type}',
        'status' => '{Status}'
    );
    
    public static $tokens = array(
        'id' => '{BookingID}',
        'title' => '{Title}',
        'first_name' => '{FirstName}',
        'second_name' => '{LastName}',
        'phone' => '{Phone}',
        'email' => '{Email}',
        'company' => '{Company}',
        'address_1' => '{Address1}',
        'address_2' => '{Address2}',
        'city' => '{City}',
        'state' => '{State}',
        'zip' => '{Zip}',
        'country' => '{Country}',
        'fax' => '{Fax}',
        'male' => '{Male}',
        'additional' => '{Additional}',
        'calendars' => '{Calendars}',
        'cc_type' => '{CCType}',
        'cc_num' => '{CCNum}',
        'cc_code' => '{CCExpMonth}',
        'cc_exp_month' => '{CCExpYear}',
        'cc_exp_year' => '{CCSec}',
        'payment_method' => '{PaymentMethod}',
        'deposit' => '{Deposit}',
        'tax' => '{Tax}',
        'total' => '{Total}',
        'calendars_price' => '{CalendarPrice}',
        'extra_price' => '{ExtraPrice}',
        'discount' => '{Discount}',
        'slots' => '{Slots}',
        'location' => '{Location}',
        'transaction_id' => '{transaction_id}',
        'create_date' => '{CreateDate}'
    );
    public static $invoice_tokens = array(
        'calendar' => '{Calendars}',
        'booking_number' => '{BookingNumber}',
        'booking_id' => '{BookingID}',
        'title' => '{Title}',
        'first_name' => '{FirstName}',
        'second_name' => '{LastName}',
        'phone' => '{Phone}',
        'email' => '{Email}',
        'company' => '{Company}',
        'address_1' => '{Address1}',
        'address_2' => '{Address2}',
        'city' => '{City}',
        'state' => '{State}',
        'zip' => '{Zip}',
        'country' => '{Country}',
        'fax' => '{Fax}',
        'payment_method' => '{PaymentMethod}',
        'deposit' => '{Deposit}',
        'tax' => '{Tax}',
        'total' => '{Total}',
        'calendar_price' => '{CalendarPrice}',
        'extra_price' => '{ExtraPrice}',
        'discount' => '{Discount}',
        'invoice_number' => '{InvoiceNumber}',
        'invoice_company' => '{YourCompany}',
        'invoice_name' => '{YourName}',
        'invoice_address' => '{YourAddress}',
        'invoice_city' => '{YourCity}',
        'invoice_state' => '{YourState}',
        'invoice_zip' => '{YourZip}',
        'invoice_fax' => '{YourFax}',
        'invoice_phone' => '{YourPhone}',
        'invoice_email' => '{YourEmail}',
        'date' => '{InvoiceDate}',
        'status' => '{Status}',
        'slots' => '{Slots}',
        'location' => '{Location}',
        'slots' => '{Slots}',
        'create_date' => '{CreateDate}',
        'transaction_id' => '{transaction_id}',
    );
    
    public static $forgotEmailToken = array(
        'email' => '{Email}',
        'password' => '{Password}',
        'first' => '{FirstName}',
        'last' => '{LastName}',
    );

    public static function redirect($url, $http_response_code = null, $exit = true) {

        echo '<html><head><title></title><script type="text/javascript">window.location.href="' . $url . '";</script></head><body></body></html>';

        if ($exit) {
            exit();
        }
    }

    /**
     * Print notice
     *
     * @param string $value
     * @return string
     * @access public
     * @static
     */
    public static function printNotice($value, $class, $convert = true) {
        ?>
        <div class="box-body">
            <div class="alert <?php echo $class; ?> alert-dismissable">
                <i class="fa fa-ban"></i>
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <b>Alert!</b>
        <?php echo $convert ? htmlspecialchars(stripslashes($value ?? '')) : stripslashes($value ?? ''); ?>
            </div>
        </div>
        <?php
    }

    public static function getTimezone($offset) {
        $db = array(
            '-14400' => 'America/Porto_Acre',
            '-18000' => 'America/Porto_Acre',
            '-7200' => 'America/Goose_Bay',
            '-10800' => 'America/Halifax',
            '14400' => 'Asia/Baghdad',
            '-32400' => 'America/Anchorage',
            '-36000' => 'America/Anchorage',
            '-28800' => 'America/Anchorage',
            '21600' => 'Asia/Aqtobe',
            '18000' => 'Asia/Aqtobe',
            '25200' => 'Asia/Almaty',
            '10800' => 'Asia/Yerevan',
            '43200' => 'Asia/Anadyr',
            '46800' => 'Asia/Anadyr',
            '39600' => 'Asia/Anadyr',
            '0' => 'Atlantic/Azores',
            '-3600' => 'Atlantic/Azores',
            '7200' => 'Europe/London',
            '28800' => 'Asia/Brunei',
            '3600' => 'Europe/London',
            '-39600' => 'America/Adak',
            '32400' => 'Asia/Shanghai',
            '36000' => 'Asia/Choibalsan',
            '-21600' => 'America/Chicago',
            '-25200' => 'Chile/EasterIsland',
            '-43200' => 'Pacific/Kwajalein'
        );
        if (is_null($offset) && strlen($offset) === 0) {
            return $db;
        }
        return array_key_exists($offset, $db) ? $db[$offset] : false;
    }

    public static function getPageURL() {
        $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

//You do not need to alter these functions
    public static function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale = 1) {
        list($imagewidth, $imageheight, $imageType) = getimagesize($image);
        $imageType = image_type_to_mime_type($imageType);

        $newImageWidth = ceil($width * $scale);
        $newImageHeight = ceil($height * $scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        switch ($imageType) {
            case "image/gif":
                $source = imagecreatefromgif($image);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $source = imagecreatefromjpeg($image);
                break;
            case "image/png":
            case "image/x-png":
                $source = imagecreatefrompng($image);
                break;
        }
        imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height);
        switch ($imageType) {
            case "image/gif":
                imagegif($newImage, $thumb_image_name);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($newImage, $thumb_image_name, 90);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($newImage, $thumb_image_name);
                break;
        }
        chmod($thumb_image_name, 0777);
        return $thumb_image_name;
    }

    public static function parse_query_str($query) {

        $arr1 = explode('&', $query);
        $arr2 = array();

        foreach ($arr1 as $k => $v) {
            $arr = explode('=', $v);

            if (is_array($arr[0]) || strpos($arr[0], '%5B%5D')) {

                $key = str_replace("%5B%5D", "", $arr[0]);
                $arr2[$key][] = $arr[1];
            } else {
                $arr2[$arr[0]] = $arr[1];
            }
        }
        return $arr2;
    }

    public static function getJsDateFormta($php_format) {

        $dateFormats['Y-m-d'] = array('js' => 'yy-mm-dd', 'php' => 'Y-m-d', 'separator' => '-', 'iso' => 'YYYY-MM-DD');
        $dateFormats['Y/m/d'] = array('js' => 'yy/mm/dd', 'php' => 'Y/m/d', 'separator' => '/', 'iso' => 'YYYY/MM/DD');
        $dateFormats['Y.m.d'] = array('js' => 'yy.mm.dd', 'php' => 'Y.m.d', 'separator' => '.', 'iso' => 'YYYY.MM.DD');
        $dateFormats['m-d-Y'] = array('js' => 'mm-dd-yy', 'php' => 'm-d-Y', 'separator' => '-', 'iso' => 'MM-DD-YYYY');
        $dateFormats['m/d/Y'] = array('js' => 'mm/dd/yy', 'php' => 'm/d/Y', 'separator' => '/', 'iso' => 'MM/DD/YYYY');
        $dateFormats['m.d.Y'] = array('js' => 'mm.dd.yy', 'php' => 'm.d.Y', 'separator' => '.', 'iso' => 'MM.DD.YYYY');
        $dateFormats['d-m-Y'] = array('js' => 'dd-mm-yy', 'php' => 'd-m-Y', 'separator' => '-', 'iso' => 'DD-MM-YYYY');
        $dateFormats['d/m/Y'] = array('js' => 'dd/mm/yy', 'php' => 'd/m/Y', 'separator' => '/', 'iso' => 'DD/MM/YYYY');
        $dateFormats['d.m.Y'] = array('js' => 'dd.mm.yy', 'php' => 'd.m.Y', 'separator' => '.', 'iso' => 'DD.MM.YYYY');

        if (!empty($php_format)) {
            if (array_key_exists($php_format, $dateFormats)) {
                return $dateFormats[$php_format]['js'];
            }
        }
        return $dateFormats['d.m.Y']['js'];
    }

    public static function getISODateFormta($php_format) {

        $dateFormats['Y-m-d'] = array('js' => 'yy-mm-dd', 'php' => 'Y-m-d', 'separator' => '-', 'iso' => 'YYYY-MM-DD');
        $dateFormats['Y/m/d'] = array('js' => 'yy/mm/dd', 'php' => 'Y/m/d', 'separator' => '/', 'iso' => 'YYYY/MM/DD');
        $dateFormats['Y.m.d'] = array('js' => 'yy.mm.dd', 'php' => 'Y.m.d', 'separator' => '.', 'iso' => 'YYYY.MM.DD');
        $dateFormats['m-d-Y'] = array('js' => 'mm-dd-yy', 'php' => 'm-d-Y', 'separator' => '-', 'iso' => 'MM-DD-YYYY');
        $dateFormats['m/d/Y'] = array('js' => 'mm/dd/yy', 'php' => 'm/d/Y', 'separator' => '/', 'iso' => 'MM/DD/YYYY');
        $dateFormats['m.d.Y'] = array('js' => 'mm.dd.yy', 'php' => 'm.d.Y', 'separator' => '.', 'iso' => 'MM.DD.YYYY');
        $dateFormats['d-m-Y'] = array('js' => 'dd-mm-yy', 'php' => 'd-m-Y', 'separator' => '-', 'iso' => 'DD-MM-YYYY');
        $dateFormats['d/m/Y'] = array('js' => 'dd/mm/yy', 'php' => 'd/m/Y', 'separator' => '/', 'iso' => 'DD/MM/YYYY');
        $dateFormats['d.m.Y'] = array('js' => 'dd.mm.yy', 'php' => 'd.m.Y', 'separator' => '.', 'iso' => 'DD.MM.YYYY');

        if (!empty($php_format)) {
            if (array_key_exists($php_format, $dateFormats)) {
                return $dateFormats[$php_format]['iso'];
            }
        }
        return $dateFormats['d.m.Y']['iso'];
    }

    public static function dateToTimestamp($stFormat, $stData) {

        $aDataRet = array();

        if (empty($stData)) {
            return 0;
        }
        $aPieces = preg_split('[\.|-|/]', $stFormat);
        $aDatePart = preg_split('[\.|-|/]', $stData);

        foreach ($aPieces as $key => $chPiece) {
            switch ($chPiece) {
                case 'd':
                case 'j':
                    $aDataRet['day'] = $aDatePart[$key];
                    break;

                case 'F':
                case 'M':
                case 'm':
                case 'n':
                    $aDataRet['month'] = $aDatePart[$key];
                    break;

                case 'o':
                case 'Y':
                case 'y':
                    $aDataRet['year'] = $aDatePart[$key];
                    break;

                case 'g':
                case 'G':
                case 'h':
                case 'H':
                    $aDataRet['hour'] = $aDatePart[$key];
                    break;

                case 'i':
                    $aDataRet['minute'] = $aDatePart[$key];
                    break;

                case 's':
                    $aDataRet['second'] = $aDatePart[$key];
                    break;
            }
        }

        return mktime(0, 0, 0, (int)($aDataRet['month'] ?? 0), (int)($aDataRet['day'] ?? 0), (int)($aDataRet['year'] ?? 0));
    }

    public static function getCurrensySimbol($code) {
        if (!empty($code) && array_key_exists($code, self::$currencies)) {
            return self::$currencies[$code]['symbol'];
        } else {
            return $code;
        }
    }

    public static function currenctFormat($code, $price) {
        if (!empty($code) && array_key_exists($code, self::$currencies)) {
            return self::$currencies[$code]['symbol'] . ' ' . $price;
        } else {
            return $code . ' ' . $price;
        }
    }

    public static function replaceToken($searhing_in, $replacement) {

        foreach ($replacement as $k => $v) {
            if (!empty(self::$tokens[$k])) {
                $token = self::$tokens[$k];
                $searhing_in = str_replace($token, $v ?? '', $searhing_in ?? '');
            }
        }

        return $searhing_in;
    }
    
    public static function replaceMemberToken($searhing_in, $replacement) {

        foreach ($replacement as $k => $v) {
            if (!empty(self::$member_tokens[$k])) {
                $token = self::$member_tokens[$k];
                $searhing_in = str_replace($token, $v ?? '', $searhing_in ?? '');
            }
        }

        return $searhing_in;
    }

    public static function replaceInvoiceToken($searhing_in, $replacement) {

        foreach ($replacement as $k => $v) {
            if (!empty(self::$invoice_tokens[$k])) {
                $token = self::$invoice_tokens[$k];
                $searhing_in = str_replace($token, $v ?? '', $searhing_in ?? '');
            }
        }

        return $searhing_in;
    }

    public static function replaceForgotEmailToken($searhing_in, $replacement) {

        foreach ($replacement as $k => $v) {
            if (!empty(self::$forgotEmailToken[$k])) {
                $token = self::$forgotEmailToken[$k];
                $searhing_in = str_replace($token, $v ?? '', $searhing_in ?? '');
            }
        }

        return $searhing_in;
    }

    public static function incrementalHash($len = 10) {

        return random_int((int) pow(10, $len - 1), (int) (pow(10, $len) - 1));
    }

     public static function random_password() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = random_int(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

}

/**
 * Rate limiting for login and payment endpoints.
 *
 * Tracks attempts per client IP in the `login_attempts` table.
 * Requires update_db_11.sql to be applied first.
 *
 * Thresholds:
 *   login   — 5 failures in 15 minutes → blocked for 15 minutes
 *   payment — 5 attempts in 60 seconds → blocked for 60 seconds
 *
 * Thresholds are configurable via environment variables (see RateLimit::cfg()).
 */
class RateLimit {

    /**
     * Read an integer configuration value from an environment variable.
     * Falls back to $default if the variable is unset or empty.
     *
     * Configurable env vars:
     *   RATE_LOGIN_MAX_ATTEMPTS   (default 5)
     *   RATE_LOGIN_WINDOW_SECS    (default 900 — 15 minutes)
     *   RATE_PAYMENT_MAX_ATTEMPTS (default 5)
     *   RATE_PAYMENT_WINDOW_SECS  (default 60  — 1 minute)
     */
    private static function cfg($key, $default) {
        $val = getenv($key);
        return ($val !== false && $val !== '') ? (int)$val : $default;
    }

    /** Return the client IP address, honouring X-Forwarded-For behind Azure/proxies. */
    public static function clientIp() {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // X-Forwarded-For may be "ip:port" or "ip1, ip2" — take the first entry and strip port
            $ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
            $ip = preg_replace('/:\d+$/', '', $ip);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
        return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    }

    /**
     * Ensure the login_attempts table exists with the correct schema.
     * Repairs the table if id column is missing AUTO_INCREMENT (Azure deployment issue).
     */
    private static function ensureTable($conn) {
        // Create table if it doesn't exist
        $conn->query(
            "CREATE TABLE IF NOT EXISTS `login_attempts` (
                `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `action`       VARCHAR(20)  NOT NULL DEFAULT 'login',
                `identifier`   VARCHAR(255) NOT NULL,
                `attempted_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_lookup` (`action`, `identifier`, `attempted_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );
        // Fix id column if it exists without AUTO_INCREMENT (Azure table created incorrectly)
        $res = $conn->query("SHOW COLUMNS FROM `login_attempts` LIKE 'id'");
        if ($res) {
            $col = $res->fetch_assoc();
            if ($col && stripos($col['Extra'], 'auto_increment') === false) {
                $conn->query("ALTER TABLE `login_attempts` MODIFY COLUMN `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`id`)");
            }
        }
    }

    /** Return true if the identifier has exceeded the allowed attempts for the given action. */
    public static function isBlocked($action, $identifier) {
        $conn = self::connect();
        if (!$conn) return false; // fail open if DB unavailable

        try {
            self::ensureTable($conn);

            $max    = ($action === 'login') ? self::cfg('RATE_LOGIN_MAX_ATTEMPTS', 5)   : self::cfg('RATE_PAYMENT_MAX_ATTEMPTS', 5);
            $window = ($action === 'login') ? self::cfg('RATE_LOGIN_WINDOW_SECS',  900) : self::cfg('RATE_PAYMENT_WINDOW_SECS',  60);
            $cutoff = date('Y-m-d H:i:s', time() - $window);

            $stmt = $conn->prepare(
                "SELECT COUNT(*) FROM login_attempts
                  WHERE action = ? AND identifier = ? AND attempted_at > ?"
            );
            if (!$stmt) { $conn->close(); return false; }

            $stmt->bind_param('sss', $action, $identifier, $cutoff);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            $conn->close();

            return $count >= $max;
        } catch (\mysqli_sql_exception $e) {
            $conn->close();
            return false;
        }
    }

    /** Record one attempt for the given action+identifier. */
    public static function record($action, $identifier) {
        $conn = self::connect();
        if (!$conn) return;

        try {
            self::ensureTable($conn);

            $stmt = $conn->prepare(
                "INSERT INTO login_attempts (action, identifier, attempted_at) VALUES (?, ?, NOW())"
            );
            if ($stmt) {
                $stmt->bind_param('ss', $action, $identifier);
                $stmt->execute();
                $stmt->close();
            }
        } catch (\mysqli_sql_exception $e) {
            // Rate limiting failure must never crash the login page
        }
        $conn->close();
    }

    /** Clear all attempts for the given action+identifier (call on successful login). */
    public static function clear($action, $identifier) {
        $conn = self::connect();
        if (!$conn) return;

        try {
            $stmt = $conn->prepare(
                "DELETE FROM login_attempts WHERE action = ? AND identifier = ?"
            );
            if ($stmt) {
                $stmt->bind_param('ss', $action, $identifier);
                $stmt->execute();
                $stmt->close();
            }
        } catch (\mysqli_sql_exception $e) {
            // fail silently
        }
        $conn->close();
    }

    private static function connect() {
        if (!defined('DEFAULT_HOST')) return null;
        try {
            $conn = gz_mysqli_connect(DEFAULT_HOST, DEFAULT_USER, DEFAULT_PASS, DEFAULT_DB);
            return ($conn && !$conn->connect_error) ? $conn : null;
        } catch (\mysqli_sql_exception $e) {
            return null;
        }
    }
}

/**
 * Create a mysqli connection with SSL support for remote hosts (e.g. Azure MySQL).
 * Uses utf8mb4 charset and handles Azure username@servername format automatically.
 */
function gz_mysqli_connect($host, $user, $pass, $db) {
    $is_remote = ($host !== 'localhost' && $host !== '127.0.0.1');

    if ($is_remote) {
        $conn = mysqli_init();
        // Find system CA cert for SSL (Azure Linux is Debian/Ubuntu based)
        $ca_paths = [
            '/etc/ssl/certs/ca-certificates.crt',
            '/etc/pki/tls/certs/ca-bundle.crt',
            '/etc/ssl/ca-bundle.pem',
        ];
        $ca_found = '';
        foreach ($ca_paths as $ca) {
            if (file_exists($ca)) { $ca_found = $ca; break; }
        }
        mysqli_ssl_set($conn, null, null, $ca_found ?: null, null, null);
        mysqli_real_connect($conn, $host, $user, $pass, $db, 3306, null, MYSQLI_CLIENT_SSL | MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);
    } else {
        $conn = new mysqli($host, $user, $pass, $db);
    }

    if ($conn && !$conn->connect_error) {
        $conn->set_charset('utf8mb4');
        // Azure MySQL enforces ONLY_FULL_GROUP_BY; remove it so GROUP BY queries
        // work the same as on local MySQL where it is typically not set.
        $conn->query("SET SESSION sql_mode = REPLACE(@@SESSION.sql_mode, 'ONLY_FULL_GROUP_BY', '')");
    }

    return $conn;
}

function days_in_month($month, $year) {
    // calculate number of days in a month
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}
?>