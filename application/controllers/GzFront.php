<?php

set_time_limit(0);
require_once CONTROLLERS_PATH . 'App.php';
// require __DIR__ . '/Twillio/vendor/autoload.php';

// use Twilio\Rest\Client;

//use \vendor\twilio\sdk\src\Twilio\Rest\Client;

class GzFront extends App {

    //var $icase ='old';
    var $layout = 'front';
    var $default_captcha = 'GzCaptcha';

    function beforeFilter() {

        if (isset($_REQUEST['lang'])) {

            GzObject::loadFiles('Model', array('Languages'));
            $LanguagesModel = new LanguagesModel();

            $default_language = $LanguagesModel->getAll(array('id' => $_REQUEST['lang']), 'order');

            if (!empty($default_language[0])) {
                $this->setLanguage($default_language[0]);
                $this->tpl['select_language'] = $this->getLanguage();
            } else {
                $this->setLanguage($this->tpl['default_language']);
                $this->tpl['select_language'] = $this->getLanguage();
            }
        } else {

            if (!$this->getLanguage() || !is_array($this->getLanguage())) {
                $this->setLanguage($this->tpl['default_language']);
            }
            $this->tpl['select_language'] = $this->getLanguage();
        }

        GzObject::loadFiles('Model', array('Calendar', 'Option'));
        $CalendarModel = new CalendarModel();
        $OptionModel = new OptionModel();

        if (!empty($_GET['cid'] ?? [])) {
            $opts = array();
            $opts['calendar_id'] = $_GET['cid'] ?? [];

            $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues($opts);

            $this->tpl['calendar'] = $CalendarModel->getI18n($_GET['cid'] ?? []);
        } else {

            $this->tpl['calendar'] = $CalendarModel->getI18n();
        }
    }

    /**
     * (non-PHPdoc)
     * @see core/framework/Controller::beforeRender()
     */
    function beforeRender() {
        $this->css[] = array('file' => 'front/style.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'front/gz-production.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/lada/ladda-themeless.min.css', 'path' => JS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/tooltipster/css/tooltipster.css', 'path' => JS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/tooltipster/css/themes/tooltipster-light.css', 'path' => JS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/lada/prism.css', 'path' => JS_PATH);
        foreach ((array)($_GET['cid'] ?? []) as $cid) {
            $this->css[] = array('file' => 'index.php?controller=GzFront&action=GzABCCss&cid=' . $cid, 'path' => '');
        }
        $this->js[] = array('file' => 'jquery-2.0.2.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery-ui.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery.colorbox-min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/lada/spin.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/lada/ladda.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/tooltipster/js/jquery.tooltipster.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        $this->js[] = array('file' => 'otp-member-verify.js?v=' . time(), 'path' => JS_PATH);
        // $this->js[] = array('file' => 'load.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'load.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'options.js', 'path' => JS_PATH);
    }

    function captcha($renew = null) {
        $this->isAjax = true;

        GzObject::loadFiles('component', 'Captcha');
        $Captcha = new Captcha('application/web/fonts/Fishfingers.ttf', 'GzScripts', $this->default_captcha, 6);
        $Captcha->setFileName('application/web/img/captcha/45-degree-fabric.png');
        $renew = isset($_GET['renew']) ? $_GET['renew'] : null;
        $Captcha->create($renew);
    }

    /**
     * Write given $content to file
     *
     * @param string $content
     * @param string $filename If omitted use 'payment.log'
     * @access public
     * @return void
     * @static
     */
    function log($content, $filename = null) {
        if (TEST_MODE) {
            $filename = is_null($filename) ? 'payment.log' : $filename;
            @file_put_contents($filename, $content . "\n", FILE_APPEND | FILE_TEXT);
        }
    }

    function removeTimeSlot() {
        $this->isAjax = true;

        $cid = $_REQUEST['cid'] ?? '';
        $slot = $_POST['slot'] ?? '';

        unset($_SESSION[$this->default_product]['slots'][$cid][$slot]);
        unset($_SESSION[$this->default_product]['event'][$cid][$slot]);
        unset($_SESSION[$this->default_product]['normal'][$cid][$slot]);
        unset($_SESSION[$this->default_product]['location_id']);
    }

    function addTimeSlot22_may() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('CustomDate'));
        $CustomDateModel = new CustomDateModel();
        $cid = $_REQUEST['cid'] ?? '';

        $opts = array();
        $opts[':timestamp BETWEEN timestamp AND timestamp_end AND calendar_id = :calendar_id'] = array(':timestamp' => ($_POST['date'] ?? ''), ':calendar_id' => $cid);
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            $_SESSION[$this->default_product]['event'][$cid][$_POST['slot'] ?? ''] = $_POST['count'] ?? '';

            unset($_SESSION[$this->default_product]['normal']);

            $_SESSION[$this->default_product]['slots'] = $_SESSION[$this->default_product]['event'];
        } else {
            $_SESSION[$this->default_product]['normal'][$cid][$_POST['slot'] ?? ''] = $_POST['count'] ?? '';

            unset($_SESSION[$this->default_product]['event']);

            $_SESSION[$this->default_product]['slots'] = $_SESSION[$this->default_product]['normal'];
        }
    }
    
     public function addTimeSlot()
    {
        $this->isAjax = true;

        GzObject::loadFiles('Model', ['CustomDate']);
        $CustomDateModel = new CustomDateModel();
        $cid = $_REQUEST['cid'] ?? '';

        if ($_POST['cal_location'] ?? null == 2 || $_POST['cal_location'] ?? null == 3) {
            unset($_SESSION[$this->default_product]);
        }

        $opts = [];
        $opts[':timestamp BETWEEN timestamp AND timestamp_end AND calendar_id = :calendar_id '] = [':timestamp' => ($_POST['date'] ?? ''), ':calendar_id' => $cid];

        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            $_SESSION[$this->default_product]['event'][$cid][$_POST['slot'] ?? ''] = $_POST['count'] ?? '';

            unset($_SESSION[$this->default_product]['normal']);

            $_SESSION[$this->default_product]['slots'] = $_SESSION[$this->default_product]['event'];
        } else {
            $_SESSION[$this->default_product]['normal'][$cid][$_POST['slot'] ?? ''] = $_POST['count'] ?? '';

            unset($_SESSION[$this->default_product]['event']);

            $_SESSION[$this->default_product]['slots'] = $_SESSION[$this->default_product]['normal'];

            // if($_POST['cal_location'] ?? null == 1)
            // {
            //     $_SESSION[$this->default_product]['location_id'] = $_POST['cal_location'] ?? null;
            // }
            // if($_POST['cal_location'] ?? null == 2)
            // {
            //     $_SESSION[$this->default_product]['location_id'] = $_POST['cal_location'] ?? null;
            // }
            // if($_POST['cal_location'] ?? null == 3)
            // {
            //     $_SESSION[$this->default_product]['location_id'] = 3;
            // }

            $_SESSION[$this->default_product]['location_id'] = $_POST['cal_location'] ?? null;

        }

    }

    function load() {
        $this->layout = 'empty';
    }

    function getTimeSlot23_may() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('TimePrice', 'BookingSlot', 'CustomPrice', 'CustomDate', 'Booking'));
        $TimePriceModel = new TimePriceModel();
        $BookingSlotModel = new BookingSlotModel();
        $CustomPriceModel = new CustomPriceModel();
        $CustomDateModel = new CustomDateModel();
        $BookingModel = new BookingModel();

        $opts = array();
        $opts[':timestamp BETWEEN timestamp AND timestamp_end AND calendar_id = :calendar_id'] = array(':timestamp' => ($_POST['date'] ?? ''), ':calendar_id' => ($_POST['cal_id'] ?? ''));
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates[0])) {
            $this->tpl['custom_dates'] = $custom_dates[0];
        }

        $opts = array();
        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }

        /*
          $opts = array();
          $opts['calendar_id = :cal_id'] = array(':cal_id' => ($_POST['cal_id'] ?? ''));
          $opts['timestamp BETWEEN :from AND :to'] = array(':from' => ($_POST['date'] - 86400), ':to' => ($_POST['date'] + 86400));
          $booked_slots = $BookingSlotModel->getAll($opts, 'id'); */

        $from   = (int) $_POST['date'] - 86400;
        $to     = (int) $_POST['date'] + 86400;
        $cal_id = (int) $_POST['cal_id'];

        $before = time() - 5 * 60;

        $sql = "SELECT * FROM " . $BookingSlotModel->getTable() . " as t1 LEFT JOIN  " . $BookingModel->getTable() . " as t2 ON t1.booking_id = t2.id WHERE (t2.status = 'confirmed' OR (t2.status = 'pending' AND t2.created >= " . $before . " )) AND t1.timestamp BETWEEN " . $from . "  AND " . $to . " AND t1.calendar_id = " . $cal_id . " ";
        $booked_slots = $BookingSlotModel->execute($sql);

        $this->tpl['booked_slots'] = array();

        if (!empty($booked_slots)) {
            foreach ($booked_slots as $key => $value) {
                if (!empty($this->tpl['booked_slots'][$value['timestamp']])) {
                    $this->tpl['booked_slots'][$value['timestamp']] += $value['count'];
                } else {
                    $this->tpl['booked_slots'][$value['timestamp']] = $value['count'];
                }
            }
        }

        $opts = array();

        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
        $opts['day'] = date('N', $_POST['date']);
        $custom_prices = $CustomPriceModel->getAll($opts);

        $this->tpl['custom_prices'] = array();

        if (!empty($custom_prices)) {
            foreach ($custom_prices as $key => $value) {
                $this->tpl['custom_prices'][date('h:i', $value['start_timestamp'])] = $value['price'];
            }
        }
    }
    
    
      public function getTimeSlot()
    {
        $this->isAjax = true;

        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        unset($_SESSION['time_slot_booking']);

        GzObject::loadFiles('Model', ['TimePrice', 'BookingSlot', 'CustomPrice', 'CustomDate', 'Booking']);
        $TimePriceModel = new TimePriceModel();
        $BookingSlotModel = new BookingSlotModel();
        $CustomPriceModel = new CustomPriceModel();
        $CustomDateModel = new CustomDateModel();
        $BookingModel = new BookingModel();

        $opts = [];
        $opts[':timestamp BETWEEN timestamp AND timestamp_end AND calendar_id = :calendar_id'] = [':timestamp' => ($_POST['date'] ?? ''), ':calendar_id' => ($_POST['cal_id'] ?? '')];
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates[0])) {
            $this->tpl['custom_dates'] = $custom_dates[0];
        }

        $opts = [];
        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
        if (!empty($_POST['cal_locationID'])) {
            $opts['location_id'] = $_POST['cal_locationID'];
        }

        $this->tpl['location_id'] = $_POST['cal_locationID'] ?? '';

        // $opts['location_id'] = $_POST['option'] ?? '';

        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }

        /*
          $opts = array();
          $opts['calendar_id = :cal_id'] = array(':cal_id' => ($_POST['cal_id'] ?? ''));
          $opts['timestamp BETWEEN :from AND :to'] = array(':from' => ($_POST['date'] - 86400), ':to' => ($_POST['date'] + 86400));
          $booked_slots = $BookingSlotModel->getAll($opts, 'id'); */

        $from   = (int) $_POST['date'] - 86400;
        $to     = (int) $_POST['date'] + 86400;
        $cal_id = (int) $_POST['cal_id'];
        $date2  = date('d,m,Y,h:i', $from);
        $date   = date('d,m,Y,h:i', $to);
        $dbDate = date('d,m,Y,h:i', 1748343600);

        $before = time() - 5 * 60;

        $sql = "SELECT * FROM " . $BookingSlotModel->getTable() . " as t1 LEFT JOIN  " . $BookingModel->getTable() . " as t2 ON t1.booking_id = t2.id WHERE (t2.status = 'confirmed' OR (t2.status = 'pending' AND t2.created >= " . $before . " )) AND t1.timestamp BETWEEN " . $from . "  AND " . $to . " AND t1.calendar_id = " . $cal_id . " ";

        $booked_slots = $BookingSlotModel->execute($sql);

        $location = $booked_slots[0]['location'] ?? null;
        $flag = false;
        // if( $location == "outside" || $location == "wholeday")
        // {
        //     $flag = true;
        //     $this->tpl['flag'] = $flag;

        // }
        // $this->tpl['count'] = $booked_slots[0]['count'];
        // $this->tpl['booked_location'] = $value['location'];

        $this->tpl['booked_slots'] = [];
        $this->tpl['booked_location'] = [];

        if (!empty($booked_slots)) {
            foreach ($booked_slots as $key => $value) {
                if (!empty($this->tpl['booked_slots'][$value['timestamp']])) {
                    $this->tpl['booked_slots'][$value['timestamp']] += $value['count'];
                } else {
                    $this->tpl['booked_slots'][$value['timestamp']] = $value['count'];
                    $this->tpl['booked_location'][$value['timestamp']] = $value['location'];
                }
            }

        }

        $dayFullyBooked = false;
        $this->tpl['day_fully_booked'] = false;

        $dayOfWeek = strtolower(date('l', $_POST['date']));
        $working_time = $this->tpl['working_time'] ?? [];
        $start_time = explode(":", $working_time[$dayOfWeek . '_start'] ?? '0:00');
        $end_time   = explode(":", $working_time[$dayOfWeek . '_end']   ?? '0:00');
        if (!isset($start_time[1])) { $start_time[1] = '0'; }
        if (!isset($end_time[1]))   { $end_time[1]   = '0'; }
        $slot_length = (int) ($working_time[$dayOfWeek . '_slot_lenght'] ?? 0);

        $date = (int) $_POST['date'];

        // Only block when a location was explicitly chosen but has no slot configuration.
        // Without a location (first date click), always let the view render the "Choose Location" form.
        if (!empty($_POST['cal_locationID']) && $slot_length <= 0) {
            echo '<div class="GZBookingContainer" style="padding:1rem;">'
               . '<p style="color:#c0392b;font-weight:bold;">No time slots are configured for this date. Please select another date.</p>'
               . '<a href="javascript:" id="back_to_calendar_id" class="btn btn-default btn-danger ladda-button" style="margin-top:8px;">Back to Calendar</a>'
               . '</div>';
            return;
        }

        for (
            $i = mktime((int) $start_time[0], (int) $start_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
            $i < mktime((int) $end_time[0], (int) $end_time[1], 0, date('n', $date), date('j', $date), date('Y', $date));
            $i += $slot_length * 60
        ) {
            foreach ($this->tpl['booked_location'] as $booked_timestamp => $booked_location) {
                if ((int) $booked_timestamp >= $i && (int) $booked_timestamp < ($i + $slot_length * 60)) {
                    if (in_array($booked_location, ['outside', 'wholeday'  , "outsidewholeday"])) {
                        $dayFullyBooked = 'full_dey';
                        break 2; // Break both loops
                    }

                    if (in_array($booked_location, ['inside'])) {
                        $dayFullyBooked = 'inside';
                        break 2; // Break both loops
                    }
                }
            }
        }

        $this->tpl['day_fully_booked'] = $dayFullyBooked;

        $opts = [];

        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
        $opts['day'] = date('N', $_POST['date']);
        $custom_prices = $CustomPriceModel->getAll($opts);

        $this->tpl['custom_prices'] = [];

        if (!empty($custom_prices)) {
            foreach ($custom_prices as $key => $value) {
                $this->tpl['custom_prices'][date('h:i', $value['start_timestamp'])] = $value['price'];
            }
        }
    }

    function index() {
        header("content-type: application/javascript");

        require APP_PATH . 'helpers/ABCalendar/ABCalendar.php';

        $d = date('j');
        $m = date('n');
        $y = date('Y');

        $this->tpl['abcalendar'] = array();

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();

        foreach ((array)($_GET['cid'] ?? []) as $cid) {
            $opts = array();
            $opts['calendar_id'] = $cid;
            $this->tpl['option_arr_values'][$cid] = $OptionModel->getAllPairValues($opts);

            $this->tpl['abcalendar'][$cid] = new ABCalendar($m, $d, $y, $cid, $_GET['view_month'] ?? 1, $this->tpl['option_arr_values'][$cid], $this->tpl['select_language']);
        }
    }

    function calendars() {
        $this->isAjax = true;

        require APP_PATH . 'helpers/ABCalendar/ABCalendar.php';

        $d = date('j');
        $m = date('n');
        $y = date('Y');

        $this->tpl['abcalendar'] = array();

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();

        foreach ((array)($_GET['cid'] ?? []) as $cid) {
            $opts = array();
            $opts['calendar_id'] = $cid;
            $this->tpl['option_arr_values'][$cid] = $OptionModel->getAllPairValues($opts);
            $this->tpl['abcalendar'][$cid] = new ABCalendar($m, $d, $y, $cid, $_GET['view_month'] ?? 1, $this->tpl['option_arr_values'][$cid], $this->tpl['select_language']);
        }
    }

    function booking_details23_may() {
        $this->isAjax = true;
        unset($_SESSION['err']);

        GzObject::loadFiles('Model', array('TimePrice', 'CustomPrice', 'Option', 'CustomDate'));
        $TimePriceModel = new TimePriceModel();
        $OptionModel = new OptionModel();
        $CustomPriceModel = new CustomPriceModel();
        $CustomDateModel = new CustomDateModel();

        $opts = array();
        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for ($i = $v['timestamp']; $i <= $v['timestamp_end']; $i += 86400) {
                    $this->tpl['custom_dates'][mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $opts = array();

        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }

        $opts = array();
        $opts['calendar_id'] = $_GET['cid'] ?? [];
        $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues($opts);

        $this->tpl['prices'] = $this->calclateBookingPrice($_POST);

        if (!(@$this->tpl['option_arr_values']['show_captcha'] != 3 || (!empty($_SESSION[$this->default_product][$this->default_captcha]) && (strtoupper(@$_POST['captcha']) == $_SESSION[$this->default_product][$this->default_captcha])))) {

            $_SESSION['err']['captcha'] = __('wrong ceptcha');
        }

        $opts = array();
        $opts['calendar_id'] = $_GET['cid'] ?? [];
        $custom_prices_arr = $CustomPriceModel->getAll($opts);
        $this->tpl['custom_prices'] = array();
        if (!empty($custom_prices_arr)) {
            foreach ($custom_prices_arr as $key => $value) {
                $this->tpl['custom_prices'][$value['day']][date('h:i', $value['start_timestamp'])] = $value;
            }
        }
    }
    
    public function booking_details()
    {
        $this->isAjax = true;
        unset($_SESSION['err']);

        GzObject::loadFiles('Model', ['TimePrice', 'CustomPrice', 'Option', 'CustomDate']);
        $TimePriceModel = new TimePriceModel();
        $OptionModel = new OptionModel();
        $CustomPriceModel = new CustomPriceModel();
        $CustomDateModel = new CustomDateModel();

        $opts = [];
        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
        // $opts['location_id'] = 3;
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for ($i = $v['timestamp']; $i <= $v['timestamp_end']; $i += 86400) {
                    $this->tpl['custom_dates'][mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $opts = [];

        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {

            if (($_POST['location'] ?? '') == "inside") {
                $this->tpl['working_time'] = $working_times[0];
            }

            if (($_POST['location'] ?? '') == "outside") {
                $outside_wholeday = $_POST['time_slote'] ?? '';

                // 1749294000
                if ($outside_wholeday == "360") {

                    $this->tpl['working_time']['monday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['tuesday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['wednesday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['thursday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['friday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['saturday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['sunday_slot_lenght'] = $outside_wholeday;

                } else {
                    $this->tpl['working_time'] = $working_times[1];
                }

            }

            if (($_POST['location'] ?? '') == "wholeday") {
                $this->tpl['working_time'] = $working_times[2];
            }

        }

        $opts = [];
        $opts['calendar_id'] = $_GET['cid'] ?? [];
        $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues($opts);

        $this->tpl['prices'] = $this->calclateBookingPrice($_POST);

        if (!(@$this->tpl['option_arr_values']['show_captcha'] != 3 || (!empty($_SESSION[$this->default_product][$this->default_captcha]) && (strtoupper(@$_POST['captcha']) == $_SESSION[$this->default_product][$this->default_captcha])))) {

            $_SESSION['err']['captcha'] = __('wrong ceptcha');
        }

        $opts = [];
        $opts['calendar_id'] = $_GET['cid'] ?? [];
        $custom_prices_arr = $CustomPriceModel->getAll($opts);
        $this->tpl['custom_prices'] = [];
        if (!empty($custom_prices_arr)) {
            foreach ($custom_prices_arr as $key => $value) {
                $this->tpl['custom_prices'][$value['day']][date('h:i', $value['start_timestamp'])] = $value;
            }
        }
    }

    function checkout() {
        $this->isAjax = true;
        //my twillo account setting
        //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
       // $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
        //hdbs twillo account setting
        // $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
        // $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
        // $client = new Client($sid, $token);

        if (!empty($_POST['create_booking'])) {
            $oid= $_POST['oid'] ?? '';
            $cid = $_REQUEST['cid'] ?? '';
            $check = $this->checkAvailability($cid);

            if ($check == true) {

                GzObject::loadFiles('Model', 'Option');
                $OptionModel = new OptionModel();

                $opts = array();
                $opts['calendar_id'] = $_GET['cid'] ?? [];
                $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues($opts);

                GzObject::loadFiles('Model', array('Booking', 'BookingSlot', 'ConfirmCode', 'Member', 'idnumbers'));
                $BookingModel = new BookingModel();
                $BookingSlotModel = new BookingSlotModel();
                $ConfirmCodeModel = new ConfirmCodeModel();
                $MemberModel = new MemberModel();
                $idnumbersModel = new idnumbersModel();

                $data = array();
                $data['status'] = "pending";
                $prices = $this->calclateBookingPrice($_POST);
                $data['calendars_price'] = $prices['calendars_price'];
                $data['amount'] = ($prices['deposit'] > 0) ? $prices['deposit'] : $prices['total'];
                $data['amount'] = number_format($data['amount'], 2, '.', '');
                $amount = $data['amount'];
                $data['discount'] = $prices['discount'];
                $data['total'] = $prices['total'];
                $data['tax'] = $prices['tax'];
                $data['security'] = $prices['security'];
                $data['deposit'] = $prices['deposit'];
                $data['discount'] = $prices['discount'];
                $data['currency'] = $this->tpl['option_arr_values']['currency'];
                //$data['booking_number'] = Util::incrementalHash(10);
                $date = date('Y');
                $BookingNo = $BookingModel->getMax();
                $bno =  substr($BookingNo,4);
                $bnonumeric = intval($bno);
                // if($bno==false){
                //     $data['booking_number'] = $date."001";
                // }
                // else{ }
                 
                    $bookingnumber = $bnonumeric +1 ;
                    $data['booking_number'] = $date."0".$bookingnumber;
                    $FinalBookingNo = $data['booking_number'];
                $data['date'] = strtotime(date('Y-m-d'));

                $time = time();

                $data['created'] = $time;

                $finalDate = date("Y-m-d", $time);

                $data['finalDate'] = $finalDate;
                
                // check member exist or not
                $datamember =  $MemberModel->rentalmemberduplicate();
                if($datamember == null){
                    // for generate memberid for gd
                        $maxid = $idnumbersModel->getMaxmid() + 1;
                        $update_mid = $idnumbersModel->Updatemid($maxid);
                        $_POST['Member_id'] = $maxid;
                   // end generate memberid for gd 
                }
                if ($datamember != null) {
                    $_POST['Member_id'] = $datamember;
                }
                
                if (($_POST['time_slote'] ?? '') == "360") {
                    $_POST['location'] = "outsidewholeday";
                }

                $id = $BookingModel->save(array_merge($_POST, $data));

                if (!empty($id)) {

                    foreach (($_SESSION[$this->default_product]['slots'][$cid] ?? []) as $i => $count) {
                        $data = array();
                        $data['calendar_id'] = $_GET['cid'] ?? [];
                        $data['booking_id'] = $id;
                        $data['timestamp'] = $i;
                        $t = $i;
                        $currentDate = date("Y-m-d", $t);
                        $data['count'] = $count;
                        $data['timecreated'] = time();
                         $t= $i;
                        $timeSlot=date("h:i",$t);
                        $current=$data['timecreated'];
                        $bookingdate=$data['timestamp'];
                        
                         $data['location'] = "";
                        if (($_POST['time_slote'] ?? '') == "360") {
                            $data['location'] = "outsidewholeday";
                        } else {
                            $data['location'] = $_POST['location'] ?? '';
                        }
                        
                        
                        $BookingSlotModel->save($data);
                        $bookdate = date("Y-m-d", $bookingdate);
                    }
                    
                    $BookingModel->saveInvoice($id);

                    //$this->sendBookingEmails($id, 'create', 'client');
                    //$this->sendBookingEmails($id, 'create', 'admin');

                    unset($_SESSION[$this->default_product]);

                    $_SESSION[$this->default_product] = array();

                    if (($_POST['payment_method'] ?? '') == 'others') {
                        $opts = array();
                        $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                        $arr = $ConfirmCodeModel->getAll($opts);
                        $cmCode=$_POST['zellecode'] ?? '';
                        $ConfirmCodeModel->UpdateCode($cmCode);

                        //if (!empty($arr[0])) { if code is not find in table booking will pending
                            if ($oid!=="1") {
                            $opts = array();
                            $opts['id'] = $id;
                            $opts['status'] = 'confirmed';
                            $opts['transaction_id']=$cmCode;
                            $arr = $BookingModel->get($id);
                                $pujaType =$arr['promo_code'];
                                $location =$arr['location'];
                                $mobileno =$arr['phone'];
                                $email = $arr['email'];
                                $address_1 =$arr['address_1'];
                                $payment_method =$arr['payment_method'];
                                $timeSlotS =$timeSlot;
                                
                                // $newDate = date('H:i', strtotime($timeSlotS. ' +120 minutes'));
                                // $timeSlotE =$newDate;
                                
                                 $newDate = "";

                            if ($arr['location'] == "inside") {
                                $newDate = date('H:i', strtotime($timeSlotS . ' +120 minutes'));
                            }
                            if ($arr['location'] == "outside") {

                                $newDate = date('H:i', strtotime($timeSlotS . ' +180 minutes'));
                            }

                            if ($arr['location'] == "outsidewholeday") {
                                $newDate = date('H:i', strtotime($timeSlotS . ' +380 minutes'));
                            }


                            if ($arr['location'] == "wholeday") {
                                $newDate = date('H:i', strtotime($timeSlotS . ' +360 minutes'));
                            }

                            $timeSlotE = $newDate;
                                
                                $Bookinno =$arr['booking_number'];
                                $Name = $arr['first_name']  .  $arr['second_name'];
                                $totalEle= 10;
                                 $Date=date("F j, Y",$bookingdate);
                                $BookingTime =$data['timestamp'];
                                echo "<div style='margin-left:110px;' class = 'pay'>
                                 <table border='4' width='585px'>
                                 <tr>
                                 <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> </tr>
                                 <tr>
                                 <td>Booking Number</td> <td>" .$Bookinno. "</td> </tr>
                                
                                 <tr><td>Customer Name</td> <td>" .$arr['first_name'].' ' .$arr['second_name']. "</td> </tr>
                                 <tr><td>Customer Email Address</td> <td>" .$arr['email'].   "</td> </tr>
                                 <tr><td>Customer Phone Number</td> <td>" .$mobileno. "</td>  </tr>
                                 <tr><td>Address</td> <td>" .$address_1. "</td>  </tr>
                                 <tr><td>Selected Payment Method</td> <td>" .'Zelle'. "</td>  </tr>
                                 <tr><td>Date and Time</td> <td>"  .$Date.' ' .$timeSlotS.'-'.$timeSlotE. "</td>  </tr>
                                 <tr><td>Puja Type</td> <td>" . $pujaType. "</td>  </tr>
                                 <tr><td>Status</td> <td>" .'confirmed'. "</td>
                                 </tr>"  ;
                              


echo "</table>";
echo "</div>" ; 

                            
                            
                            $data = $_POST;
                            $BookingModel->update($opts);
                            $msg='';
                            // $result =$this->sendBookingEmails($id, 'confirmation', 'client');
                            // $this->sendBookingEmails($id, 'confirmation', 'admin');
                            $result = $this->sendBookingEmailsNew($id, 'confirmation', 'client',$Name, $email,$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                            $this->sendBookingEmailsNew($id, 'confirmation', 'admin',$Name,$email,$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                            $this->sendBookingEmailsNew($id, 'confirmation', 'priest',$Name, $email,$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                            $invoiceID= $result;
          
                            //$path ='C:\xampp\htdocs\HDBS\application\web\upload\invoice\booking_'.$id.'_invoice_'.$invoiceID.'.pdf';
                            $path = INSTALL_URL . 'application/web/upload/invoice/booking_' . $id . '_invoice_' . $invoiceID . '.pdf';
                            //$msg='Houston DurgaBari: Your Priest Service Booking Number is '.$Bookinno. ' for '.$pujaType. ' on '.$testDate.' '. $location . ' Durga Bari. Transaction ID:'. $payment->id . ' Confirmed  paid amount($)'.$string. '. Click here  for receipt:'. $path;
                            // $msg = 'Houston DurgaBari: Your Priest Booking Number  is ' . $Bookinno . ' for ' . $pujaType . ' on ' . $Date . ' ' . $location . ' Durga Bari. Click here  for receipt:' . $path;
                           // $message = $client->messages->create(
                                // Where to send a text message (your cell phone?)
                                // '+1'.$mobileno.'',
                                // array(
                                //     //'from' => '+19707037189',
                                //      'from' => '+12815016454',
                                //     'body' => $msg
                                // )
                            // );
                            echo "<a onclick = 'alertcheck()'>Go to home</a> " ;
                             if($datamember == null) {
                                $value = array();
                                $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                $value['MemberName'] = $_POST['first_name'].' '.$_POST['second_name'];
                                $value['Amount'] = $_POST['Puja'] ?? '';
                                $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                                $value['payment_status'] = 'confirmed';
                                $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                $value['transaction_id'] = $opts['transaction_id'];
                                $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['update_on'] = $_POST['update_on'] ?? '';
                                $value['Member_id'] = $_POST['Member_id'] ?? '';
                                $value['cc_name'] = $_POST['cc_name'] ?? '';
                                $value['remarks'] = $_POST['remarks'] ?? '';
                                date_default_timezone_set("America/Chicago");
                                $today = date("Y/m/d");
                                $value['pay_date'] = $today; 
                                $value['Address'] = $_POST['address_1'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['Tele1'] = $_POST['phone'] ?? ''; 
                                $MemberModel->SaveDataInmember($value);
                            }
                           // echo '<script>alert("Booking has been saved successfully! please check your mail.")</script>';
                            //Util::redirect(INSTALL_URL . "GzPreview/index");
                        }else{
                            echo "<div style='margin-left:140px;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> </tr>
                    <tr>
                    <td colspan='2'><b>Your booking request have been submitted.
                    Your payment is not confirmed yet. To confirm your booking please contact to<a href='mailto:hdbs.payment@durgabari.org'> hdbs.payment@durgabari.org</a></b></td></tr>
                    </tr>"  ;
                            echo "</table>";
                            echo "</div>";
                    }
                    
                    } 
                    
                    // check payment
                    if (($_POST['payment_method'] ?? '') == 'check') {

                        //if (!empty($arr[0])) { if code is not find in table booking will pending
                            if ($_POST['checkAmount'] !== '' && $_POST['checkAmount'] !== null &&  $_POST['checkAmount']  > 0 ) {
                            $opts = array();
                            $opts['id'] = $id;
                            $opts['status'] = 'confirmed';
                            $arr = $BookingModel->get($id);
                                $pujaType =$arr['promo_code'];
                                $location =$arr['location'];
                                $mobileno =$arr['phone'];
                                $email = $arr['email'];
                                $address_1 =$arr['address_1'];
                                $payment_method =$arr['payment_method'];
                                $timeSlotS =$timeSlot;
                                
                                // $newDate = date('H:i', strtotime($timeSlotS. ' +120 minutes'));
                                // $timeSlotE =$newDate;
                                
                                 $newDate = "";

                            if ($arr['location'] == "inside") {
                                $newDate = date('H:i', strtotime($timeSlotS . ' +120 minutes'));
                            }
                            if ($arr['location'] == "outside") {

                                $newDate = date('H:i', strtotime($timeSlotS . ' +180 minutes'));
                            }

                            if ($arr['location'] == "outsidewholeday") {
                                $newDate = date('H:i', strtotime($timeSlotS . ' +380 minutes'));
                            }


                            if ($arr['location'] == "wholeday") {
                                $newDate = date('H:i', strtotime($timeSlotS . ' +360 minutes'));
                            }

                            $timeSlotE = $newDate;
                                
                                $Bookinno =$arr['booking_number'];
                                $Name = $arr['first_name']  .  $arr['second_name'];
                                $totalEle= 10;
                                 $Date=date("F j, Y",$bookingdate);
                                $BookingTime =$data['timestamp'];
                                echo "<div style='margin-left:110px;' class = 'pay'>
                                 <table border='4' width='585px'>
                                 <tr>
                                 <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> </tr>
                                 <tr>
                                 <td>Booking Number</td> <td>" .$Bookinno. "</td> </tr>
                                
                                 <tr><td>Customer Name</td> <td>" .$arr['first_name'].' ' .$arr['second_name']. "</td> </tr>
                                 <tr><td>Customer Email Address</td> <td>" .$arr['email'].   "</td> </tr>
                                 <tr><td>Customer Phone Number</td> <td>" .$mobileno. "</td>  </tr>
                                 <tr><td>Address</td> <td>" .$address_1. "</td>  </tr>
                                 <tr><td>Selected Payment Method</td> <td>" .'check'. "</td>  </tr>
                                 <tr><td>Date and Time</td> <td>"  .$Date.' ' .$timeSlotS.'-'.$timeSlotE. "</td>  </tr>
                                 <tr><td>Puja Type</td> <td>" . $pujaType. "</td>  </tr>
                                 <tr><td>Status</td> <td>" .'confirmed'. "</td>
                                 </tr>"  ;
                              


echo "</table>";
echo "</div>" ; 

                            
                            
                            $data = $_POST;
                            $BookingModel->update($opts);
                            $msg='';
                            // $result =$this->sendBookingEmails($id, 'confirmation', 'client');
                            // $this->sendBookingEmails($id, 'confirmation', 'admin');
                            $result = $this->sendBookingEmailsNew($id, 'confirmation', 'client',$Name, $email,$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                            // $this->sendBookingEmailsNew($id, 'confirmation', 'admin',$Name,$email,$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                            // $this->sendBookingEmailsNew($id, 'confirmation', 'priest',$Name, $email,$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                            $invoiceID= $result;
          
                            //$path ='C:\xampp\htdocs\HDBS\application\web\upload\invoice\booking_'.$id.'_invoice_'.$invoiceID.'.pdf';
                            $path = INSTALL_URL . 'application/web/upload/invoice/booking_' . $id . '_invoice_' . $invoiceID . '.pdf';
                            //$msg='Houston DurgaBari: Your Priest Service Booking Number is '.$Bookinno. ' for '.$pujaType. ' on '.$testDate.' '. $location . ' Durga Bari. Transaction ID:'. $payment->id . ' Confirmed  paid amount($)'.$string. '. Click here  for receipt:'. $path;
                            // $msg = 'Houston DurgaBari: Your Priest Booking Number  is ' . $Bookinno . ' for ' . $pujaType . ' on ' . $Date . ' ' . $location . ' Durga Bari. Click here  for receipt:' . $path;
                           // $message = $client->messages->create(
                                // Where to send a text message (your cell phone?)
                                // '+1'.$mobileno.'',
                                // array(
                                //     //'from' => '+19707037189',
                                //      'from' => '+12815016454',
                                //     'body' => $msg
                                // )
                            // );
                            echo "<a onclick = 'alertcheck()'>Go to home</a> " ;
                             if ($datamember == null) {
                                $value                   = [];
                                $value['Payment_For']    = $_POST['Payment_For'] ?? '';
                                $value['MemberName']     = $_POST['first_name'] . ' ' . ($_POST['second_name'] ?? '');
                                $value['Amount']         = $_POST['Puja'] ?? '';
                                $value['PaymentOption']  = $_POST['payment_method'] ?? '';
                                $value['payment_status'] = 'confirmed';
                                $value['stripe_return']  = $opts['stripe_return'] ?? '';
                                $value['transaction_id'] = $opts['transaction_id'];
                                $value['paid_amount']    = $opts['paid_amount'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['update_on']      = $_POST['update_on'] ?? '';
                                $value['Member_id']      = $_POST['Member_id'] ?? '';
                                $value['cc_name']        = $_POST['cc_name'] ?? '';
                                $value['remarks']        = $_POST['remarks'] ?? '';
                                date_default_timezone_set("America/Chicago");
                                $today             = date("Y/m/d");
                                $value['pay_date'] = $today;
                                $value['Address']  = $_POST['address_1'] ?? '';
                                $value['email']    = $_POST['email'] ?? '';
                                $value['Tele1']    = $_POST['phone'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                           // echo '<script>alert("Booking has been saved successfully! please check your mail.")</script>';
                            //Util::redirect(INSTALL_URL . "GzPreview/index");
                        }else{
                            echo "<div style='margin-left:140px;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> </tr>
                    <tr>
                    <td colspan='2'><b>Your booking request have been submitted.
                    Your payment is not confirmed yet. To confirm your booking please contact to<a href='mailto:hdbs.payment@durgabari.org'> hdbs.payment@durgabari.org</a></b></td></tr>
                    </tr>"  ;
                            echo "</table>";
                            echo "</div>";
                    }
                    
                    }
                    
                    
                    elseif (($_POST['payment_method'] ?? '') == 'stripe') {
                        require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                        $error = '';
                        $success = '';

                        Stripe::setApiKey($this->tpl["option_arr_values"]["stripe_api_key"]);

                        try {
                            if (!isset($_POST['stripeToken'])) {
                                throw new Exception("The Stripe Token was not generated correctly");
                            }

                            $amount = round($amount * 100);

                             $payment = Stripe_Charge::create(array(
                                        "amount" => $amount,
                                        "currency" => $this->tpl["option_arr_values"]["currency"],
                                        "card" => $_POST['stripeToken'],
                                        "metadata" => ["order_id" => $id],
                                        "description" =>  "Booking No:".$FinalBookingNo. ', ' ."Email:".$_POST['email'] . ', ' ."Full Name:". ($_POST['first_name'] ?? '') . ' ' . ($_POST['second_name'] ?? '').' , '."Puja Type:" . ($_POST['promo_code'] ?? '').' , ' ."Location:". ($_POST['location'] ?? '') . "-Durgabari".' ,  '."Additional:" . ($_POST['additional'] ?? '')
                            ));

                            $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                            $this->tpl['payment']['amount'] = $payment->amount;
                            $this->tpl['payment']['status'] = $payment->status;
                            $this->tpl['payment']['currency'] = $payment->currency;

                            if ($payment->status == 'succeeded') {

                                $booking = $BookingModel->get($id);

                                $opts = array();
                                $opts['id'] = $id;
                                $opts['stripe_return'] = $payment->status;
                                $opts['transaction_id'] = $payment->id;
                                $opts['paid_amount'] = $payment->amount;
                                $opts['stripe_product'] = $payment->description;
                                $opts['status'] = 'confirmed';
                                $string = substr($payment->amount, 0, -2);
                                $arr = $BookingModel->get($id);
                                $pujaType = $arr['promo_code'];
                                $Bookinno = $arr['booking_number'];
                                $location = $arr['location'];
                                $mobileno = $arr['phone'];
                                $address_1 =$arr['address_1'];
                                $payment_method =$arr['payment_method'];
                                $timeSlotS =$timeSlot;
                                // $newDate = date('H:i', strtotime($timeSlotS. ' +120 minutes'));
                                // $timeSlotE =$newDate;
                                
                                $newDate = "";

                                if ($arr['location'] == "inside") {
                                    $newDate = date('H:i', strtotime($timeSlotS . ' +120 minutes'));
                                }
                                if ($arr['location'] == "outside") {
                                    $newDate = date('H:i', strtotime($timeSlotS . ' +180 minutes'));
                                }

                                if ($arr['location'] == "outsidewholeday") {

                                    $newDate = date('H:i', strtotime($timeSlotS . ' +380 minutes'));
                                }
                                if ($arr['location'] == "wholeday") {
                                    $newDate = date('H:i', strtotime($timeSlotS . ' +360 minutes'));
                                }

                                $timeSlotE = $newDate;
                                
                                
                                $totalEle= 10;
                                $BookingTime =$data['timestamp'];
                                $str_arr = explode (",", $payment->description); 
                                //$replacement['date'] = date($option_arr['date_format'], strtotime($invoice['date']));
                                //$Date=date (strtotime("m-d-Y",$t1));
                                $Date=date("F j, Y",$bookingdate);
                                echo "<div style='margin-left:110px;' class = 'pay'>
                                 <table border='4' width='585px'>
                                 <tr>
                                 <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> </tr>
                                <tr>
                                <td>Booking Number</td> <td>" .$Bookinno. "</td> </tr>
                                <tr><td>Customer Name</td> <td>" .$arr['first_name'].' ' .$arr['second_name']. "</td> </tr>
                                <tr><td>Customer Email Address</td> <td>" .$arr['email'].   "</td> </tr>
                                <tr><td>Customer Phone Number</td> <td>" .$mobileno. "</td>  </tr>
                                <tr><td>Address</td> <td>" .$address_1. "</td>  </tr>
                                <tr><td>Selected Payment Method</td> <td>" .$payment_method. "</td>  </tr>
                                <tr><td>Date and Time</td> <td>"  .$Date.' ' .$timeSlotS.'-'.$timeSlotE. "</td>  </tr>
                                <tr><td>Puja Type</td> <td>" . $pujaType. "</td>  </tr>
                                <tr><td>Total Amount($)</td> <td>" .$string. "</td>  </tr>
                                <tr><td>Transaction ID</td> <td>" .$payment->id. "</td> </tr>
                                <tr><td>Status</td> <td>" .'confirmed'. "</td>
                                </tr>"  ;


// echo "<tr>";
// echo"<td>" .$id. "</td>";                        
// echo"<td>" .$payment->status. "</td>";
// echo"<td>" .$payment->id. "</td>";
// echo"<td>" .$payment->amount. "</td>";
// echo"<td>" .$payment->description. "</td>";
// echo"<td>" .'confirmed'. "</td>";
// echo "</tr>";
                                echo "</table>";
                                echo "</div>";
// echo "<div id='app' ></div>" ;






                                $data = $_POST;
                                $BookingModel->update($opts);

                                $msg = '';
                                // $result = $this->sendBookingEmails($id, 'confirmation', 'client');
                                // $this->sendBookingEmails($id, 'confirmation', 'admin');
                                $result = $this->sendBookingEmailsNew($id, 'confirmation', 'client',$str_arr[1], $str_arr[0],$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                                // $this->sendBookingEmailsNew($id, 'confirmation', 'admin',$str_arr[1], $str_arr[0],$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                                // $this->sendBookingEmailsNew($id, 'confirmation', 'priest',$str_arr[1], $str_arr[0],$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                                $invoiceID = $result;

                                $path = INSTALL_URL . 'application/web/upload/invoice/booking_' . $id . '_invoice_' . $invoiceID . '.pdf';

                                // $msg = 'Houston DurgaBari: Your Priest Service Booking Number is ' . $Bookinno . ' for ' . $pujaType . ' on ' . $Date . ' ' . $location . ' Durga Bari has been confirmed paid Amount($) ' . $string . '. Click here  for receipt:' . $path;
                                // $msg='Houston DurgaBari: Your Priest Service Booking Number is '.$Bookinno. ' for '.$pujaType. ' on '.$testDate.' '. $location . ' Durga Bari. Click here  for receipt:'. $path;

                                // $message = $client->messages->create(
                                //         // Where to send a text message (your cell phone?)
                                //         '+1' . $mobileno . '',
                                //         array(
                                //             //'from' => '+19707037189', //paras
                                //             'from' => '+12815016454',
                                //             'body' => $msg
                                //         )
                                // );
                                echo "<a onclick = 'alertcheck()'>Go to home</a> ";
                                if($datamember == null) {
                                    $value = array();
                                    $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                    $value['MemberName'] = $_POST['first_name'].' '.$_POST['second_name'];
                                    $value['Amount'] = $_POST['Puja'] ?? '';
                                    $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                                    $value['payment_status'] = 'confirmed';
                                    $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                    $value['transaction_id'] = $opts['transaction_id'];
                                    $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                    $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                    $value['update_on'] = $_POST['update_on'] ?? '';
                                    $value['Member_id'] = $_POST['Member_id'] ?? '';
                                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                                    $value['remarks'] = $_POST['remarks'] ?? '';
                                    date_default_timezone_set("America/Chicago");
                                    $today = date("Y/m/d");
                                    $value['pay_date'] = $today; 
                                    $value['Address'] = $_POST['address_1'] ?? '';
                                    $value['email'] = $_POST['email'] ?? '';
                                    $value['Tele1'] = $_POST['phone'] ?? ''; 
                                    $value['pay_type'] = 'Priest'; 
                                    $value['pay_for'] = 'Priest'; 
                                    $MemberModel->SaveDataInmember($value);
                                }

                                // echo "<div id='app' class='animation-container'>
                                //<span></span>
                                //<span></span>
                                //<span></span>
                                //<span></span>
                                //<span></span>
                                //<span></span>
                                //<span></span>
                                //<span></span>
                                //<span></span>
                                //<span></span>
                                //<span></span>
                                //</div>" ;
                                // echo '<script>alertcheck();</script>';
                                //Util::redirect(INSTALL_URL . "GzPreview/index");
                            } else {
                                $booking = $BookingModel->get($id);

                                $opts = array();
                                $opts['id'] = $id;
                                $opts['stripe_return'] = $payment->status;
                                $opts['transaction_id'] = $payment->id;
                                $opts['paid_amount'] = $payment->amount;
                                $opts['stripe_product'] = $payment->description;
                                $BookingModel->update($opts);

                                $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';

                                Util::redirect(INSTALL_URL . "GzPreview/index");
                            }
                        } catch (Exception $e) {

                            $_SESSION['status'] = '<strong>Error!</strong> ' . $e->getMessage();
                        }
                    } elseif (($_POST['payment_method'] ?? '') == 'authorize') {
                        require_once APP_PATH . 'helpers/sdk-php-master/autoload.php';
                    }
                    
                    $this->tpl['booking_details'] = $BookingModel->getBookingDetails($id);
                    
                    $status = 10;
                } else {
                    $status = 11;
                }
            } else {
                $err = __('err');
                $_SESSION['status'] = $err[11];
            }
        }
    }

    function paypal_confirm() {

        define("DEBUG", 1);
        define("USE_SANDBOX", 0);
        define("LOG_FILE", "./ipn.log");

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key = $value";
        }

        if (USE_SANDBOX == true) {
            $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        } else {
            $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
        }

        $ch = curl_init($paypal_url);
        if ($ch == FALSE) {
            return FALSE;
        }

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        if (DEBUG == true) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        $res = curl_exec($ch);

        if (curl_errno($ch) != 0) { // cURL error
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
            }
            curl_close($ch);
            exit;
        } else {
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "HTTP request of validation request:" . curl_getinfo($ch, CURLINFO_HEADER_OUT) . " for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
                error_log(date('[Y-m-d H:i e] ') . "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
                list($headers, $res) = explode("\r\n\r\n", $res, 2);
            }
            curl_close($ch);
        }

        $item_name = $_POST['item_name'] ?? '';
        $item_number = $_POST['item_number'] ?? '';
        $payment_status = $_POST['payment_status'] ?? '';
        $payment_amount = $_POST['mc_gross'] ?? '';
        $payment_currency = $_POST['mc_currency'] ?? '';
        $txn_id = $_POST['txn_id'] ?? '';
        $receiver_email = $_POST['receiver_email'] ?? '';
        $payer_email = $_POST['payer_email'] ?? '';
        $payer_custom = $_POST['custom'] ?? '';

        GzObject::loadFiles('Model', array('Booking'));
        $BookingModel = new BookingModel();

        $opts = array();
        $opts['id'] = $payer_custom;
        $opts['status'] = 'confirmed';

        $booking = $BookingModel->get($payer_custom);
        if (strpos($res, 'VERIFIED') !== false) {

            if ($booking) {

                $BookingModel->update($opts);
                $this->sendBookingEmails($payer_custom, 'confirmation', 'client');
                $this->sendBookingEmails($payer_custom, 'confirmation', 'admin');
            }
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "Verified IPN: $req " . PHP_EOL, 3, LOG_FILE);
            }
        }
        Util::redirect($this->tpl['option_arr_values']['payment_redirect']);
    }

    function confirm_2checkout() {
        GzObject::loadFiles('Model', array('Booking'));
        $BookingModel = new BookingModel();

        $booking = $BookingModel->get($_REQUEST['merchant_order_id']);

        $hashSecretWord = $this->tpl['option_arr_values']['checkout_SecretWord']; //2Checkout Secret Word
        $hashSid = $this->tpl['option_arr_values']['checkout_acc']; //2Checkout account number
        $hashTotal = $booking['amount']; //Sale total to validate against
        $hashOrder = $_REQUEST['order_number']; //2Checkout Order Number
        $StringToHash = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));

        if ($StringToHash != $_REQUEST['key']) {
            $result = 'Fail - Hash Mismatch';
        } else {

            $opts = array();
            $opts['id'] = $_REQUEST['merchant_order_id'];
            $opts['status'] = 'confirmed';

            if ($booking) {

                $BookingModel->update($opts);
                $this->sendBookingEmails($payer_custom, 'confirmation', 'client');
                $this->sendBookingEmails($payer_custom, 'confirmation', 'admin');
            }
        }
        Util::redirect($this->tpl['option_arr_values']['payment_redirect']);
    }

    function authorize_confirm() {
        $ResponseCode = trim($_POST["x_response_code"]);
        $ResponseReasonText = trim($_POST["x_response_reason_text"]);
        $ResponseReasonCode = trim($_POST["x_response_reason_code"]);
        $AVS = trim($_POST["x_avs_code"]);
        $TransID = trim($_POST["x_trans_id"]);
        $AuthCode = trim($_POST["x_auth_code"]);
        $Amount = trim($_POST["x_amount"]);
        $sequence = trim($_POST["x_fp_sequence"]);

        // Test to see if this is a test transaction.
        if ($TransID === 0 && $ResponseCode === 1) {
            // If so, print it to the screen, so we know that the transaction will not be processed because your account is in Test Mode.
        }
        // Test to see if the transaction resulted in Approvavl, Decline or Error
        if ($ResponseCode === 1) {
            GzObject::loadFiles('Model', array('Booking'));
            $BookingModel = new BookingModel();

            $opts = array();
            $opts['id'] = $sequence;
            $opts['status'] = 'confirmed';

            $booking = $BookingModel->get($sequence);

            if ($booking) {

                $BookingModel->update($opts);
                $this->sendBookingEmails($sequence, 'confirmation', 'client');
                $this->sendBookingEmails($sequence, 'confirmation', 'admin');
            }
        } else if ($ResponseCode === 2) {
            //This transaction has been declined.
        } else if ($ResponseCode === 3) {
            //There was an error processing this transaction.
        }

        Util::redirect($this->tpl['option_arr_values']['payment_redirect']);

        if ($TransID === 0) {
            echo 'Not Applicable.';
        } else {
            echo htmlspecialchars($TransID, ENT_QUOTES, 'UTF-8');
        }

        if ($AuthCode === "000000") {
            echo 'Not Applicable.';
        } else {
            echo htmlspecialchars($AuthCode, ENT_QUOTES, 'UTF-8');
        }

        // Turn the AVS code into the corresponding text string.
        switch ($AVS) {
            case "A":
                echo "Address (Street) matches, ZIP does not.";
                break;
            case "B":
                echo "Address Information Not Provided for AVS Check.";
                break;
            case "C":
                echo "Street address and Postal Code not verified for international transaction due to incompatible formats. (Acquirer sent both street address and Postal Code.)";
                break;
            case "D":
                echo "International Transaction:  Street address and Postal Code match.";
                break;
            case "E":
                echo "AVS Error.";
                break;
            case "G":
                echo "Non U.S. Card Issuing Bank.";
                break;
            case "N":
                echo "No Match on Address (Street) or ZIP.";
                break;
            case "P":
                echo "AVS not applicable for this transaction.";
                break;
            case "R":
                echo "Retry. System unavailable or timed out.";
                break;
            case "S":
                echo "Service not supported by issuer.";
                break;
            case "U":
                echo "Address information is unavailable.";
                break;
            case "W":
                echo "9 digit ZIP matches, Address (Street) does not.";
                break;
            case "X":
                echo "Address (Street) and 9 digit ZIP match.";
                break;
            case "Y":
                echo "Address (Street) and 5 digit ZIP match.";
                break;
            case "Z":
                echo "5 digit ZIP matches, Address (Street) does not.";
                break;
            default:
                echo "The address verification system returned an unknown value.";
                break;
        }
    }

    function calculatePrice() {
        $this->isAjax = true;

        $_POST['calendar_id'] = $_GET['cid'] ?? [];
        $price = $this->calclateBookingPrice($_POST);

        header("Content-Type: application/json", true);
        print json_encode($price); // JSON response — htmlspecialchars would corrupt the output
    }

    function calendar() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();

        $opts = array();
        $opts['calendar_id'] = $_GET['cid'] ?? [];
        $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues($opts);

        require APP_PATH . 'helpers/ABCalendar/ABCalendar.php';

        $d = date('j');
        if (!empty($_POST['month'])) {
            $m = $_POST['month'] ?? '';
        } else {
            $m = date('m');
        }
        if (!empty($_POST['year'])) {
            $y = $_POST['year'] ?? '';
        } else {
            $y = date('Y');
        }

        $this->tpl['abcalendar'] = new ABCalendar($m, $d, $y, $_GET['cid'] ?? [], $_GET['view_month'] ?? 1, $this->tpl['option_arr_values'], $this->tpl['select_language']);
    }

    function booking_form23_may() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('TimePrice', 'Option', 'CustomPrice', 'CustomDate','priestserviceprice'));
        $TimePriceModel = new TimePriceModel();
        $OptionModel = new OptionModel();
        $CustomDateModel = new CustomDateModel();
        $CustomPriceModel = new CustomPriceModel();
        $priestservicepriceModel = new priestservicepriceModel();
        
        $insidearr = $priestservicepriceModel->pujapriceinside();
        $this->tpl['insidearr'] =  $insidearr;
        
        $outsidearr = $priestservicepriceModel->pujapriceoutside();
        $this->tpl['outsidearr'] =  $outsidearr;

        $opts = array();
        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for ($i = $v['timestamp']; $i <= $v['timestamp_end']; $i += 86400) {
                    $this->tpl['custom_dates'][mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $opts = array();

        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }

        $opts = array();
        $opts['calendar_id'] = $_GET['cid'] ?? [];
        $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues($opts);

        $_POST['calendar_id'] = $_GET['cid'] ?? [];
        $this->tpl['prices'] = $this->calclateBookingPrice($_POST);

        $opts = array();
        $opts['calendar_id'] = $_GET['cid'] ?? [];
        $custom_prices_arr = $CustomPriceModel->getAll($opts);
        $this->tpl['custom_prices'] = array();
        if (!empty($custom_prices_arr)) {
            foreach ($custom_prices_arr as $key => $value) {
                $this->tpl['custom_prices'][$value['day']][date('h:i', $value['start_timestamp'])] = $value;
            }
        }
    }
    
     public function booking_form()
    {
        $this->isAjax = true;

        GzObject::loadFiles('Model', ['TimePrice', 'Option', 'CustomPrice', 'CustomDate', 'priestserviceprice']);
        $TimePriceModel = new TimePriceModel();
        $OptionModel = new OptionModel();
        $CustomDateModel = new CustomDateModel();
        $CustomPriceModel = new CustomPriceModel();
        $priestservicepriceModel = new priestservicepriceModel();

        $insidearr = $priestservicepriceModel->pujapriceinside();
        $this->tpl['insidearr'] = $insidearr;

        $value = $_POST['location'] ?? '';
        $time_slote = $_POST['time_slote'] ?? '';

        $this->tpl['location_id'] = $value;
        $this->tpl['custom_time'] = $time_slote;

        $outsidearr = $priestservicepriceModel->pujapriceoutside();

        $pujaWholeDay = $priestservicepriceModel->pujaWholeDay();
        $this->tpl['pujaWholeDay'] = $pujaWholeDay;

        $pujaOutsideWholeDay = $priestservicepriceModel->pujapriceoutsidewholeday();

        if ($time_slote == '360') {
            $this->tpl['outsidearr'] = $pujaOutsideWholeDay;

        } else {
            $this->tpl['outsidearr'] = $outsidearr;
        }

        $opts = [];
        $opts['calendar_id'] = $_POST['cal_id'] ?? '';

        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for ($i = $v['timestamp']; $i <= $v['timestamp_end']; $i += 86400) {
                    $this->tpl['custom_dates'][mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $opts = [];

        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {

            $location = $_POST['location'] ?? '';

            if ($location == 1) {
                $this->tpl['working_time'] = $working_times[0];
            }

            if ($location == 2) {
                $outside_wholeday = $_POST['time_slote'] ?? '';

                if ($outside_wholeday == "360") {

                    $this->tpl['working_time']['monday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['tuesday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['wednesday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['thursday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['friday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['saturday_slot_lenght'] = $outside_wholeday;
                    $this->tpl['working_time']['sunday_slot_lenght'] = $outside_wholeday;

                } else {
                    $this->tpl['working_time'] = $working_times[1];
                }

            }

            if ($location == 3) {
                $this->tpl['working_time'] = $working_times[2];
            }

        }

        $opts = [];
        $opts['calendar_id'] = $_GET['cid'] ?? [];
        // $opts['location_id'] = 3;
        $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues($opts);

        $_POST['calendar_id'] = $_GET['cid'] ?? [];
        $this->tpl['prices'] = $this->calclateBookingPrice($_POST);

        $opts = [];
        $opts['calendar_id'] = $_GET['cid'] ?? [];
        $custom_prices_arr = $CustomPriceModel->getAll($opts);
        $this->tpl['custom_prices'] = [];
        if (!empty($custom_prices_arr)) {
            foreach ($custom_prices_arr as $key => $value) {
                $this->tpl['custom_prices'][$value['day']][date('h:i', $value['start_timestamp'])] = $value;
            }
        }

        GzObject::loadFiles('Model', ['ConfirmCode']);
        $ConfirmCodeModel = new ConfirmCodeModel();
        $this->tpl['Amount'] = $ConfirmCodeModel->getMaxAll('Regularsystem');
    }

    function GzABCCss() {
        $this->layout = 'empty';
        $this->getCss();
    }

    function string_between_two_string($str, $starting_word, $ending_word) {

        $subtring_start = strpos($str, $starting_word);
        //Adding the starting index of the starting word to
        //its length would give its ending index
        $subtring_start += strlen($starting_word);
        //Length of our required sub string
        $size = strpos($str, $ending_word, $subtring_start) - $subtring_start;
        // Return the substring from the index substring_start of length size
        return substr($str, $subtring_start, $size);
    }

    function removeTableIfImg($matches) {
        $table = $matches[0];
        return preg_match('/<img\b[^>]*>/i', $table, $img) ? preg_replace('/<\/?(?:table|td|tr)\b[^>]*>\s*/i', '', $table) : $table;
    }

    private function zelleMailLog($message, $context = array())
    {
        $root = defined('INSTALL_PATH') ? rtrim(INSTALL_PATH, "/\\") : dirname(__DIR__, 2);
        $logFile = $root . DIRECTORY_SEPARATOR . 'zelle_mail_debug.log';
        $safeContext = array();
        foreach ((array)$context as $key => $value) {
            if (stripos($key, 'pass') !== false || stripos($key, 'password') !== false) {
                continue;
            }
            $safeContext[$key] = $value;
        }
        $line = '[' . date('Y-m-d H:i:s') . '] ' . $message;
        if (!empty($safeContext)) {
            $line .= ' | ' . json_encode($safeContext);
        }
        @file_put_contents($logFile, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    
    
    
     public function getConfirmationCode($account_type)
    {
        if ($account_type == "Pujaaccount") {
            $email_address = "treasurerpuja@durgabari.org";
            $app_password = "ggtfnczdodeukgzp";
            $payment_system = 'pujaregistration';
        } else {
            $email_address = "treasurer@durgabari.org";
            $app_password = "ywbfszrjiubozbjt";
            $payment_system = 'Regularsystem';
        }

        $password_clean = str_replace(' ', '', $app_password);
        $dateMail = date("d-M-Y", strtotime("-7 days"));

        $this->zelleMailLog('Starting Zelle mail read using cURL IMAPS', array(
            'account_type' => $account_type,
            'email_address' => $email_address,
            'payment_system' => $payment_system,
            'date_from' => $dateMail
        ));

        if (!function_exists('curl_init')) {
            $this->zelleMailLog('PHP cURL extension is not available; curl_init function missing', array(
                'account_type' => $account_type,
                'email_address' => $email_address
            ));
            return [];
        }

        $curlVersion = curl_version();
        $protocols = isset($curlVersion['protocols']) && is_array($curlVersion['protocols']) ? $curlVersion['protocols'] : [];
        if (!in_array('imaps', $protocols, true)) {
            $this->zelleMailLog('cURL IMAPS protocol is not available', array(
                'protocols' => implode(',', $protocols)
            ));
            return [];
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'imaps://imap.gmail.com:993/INBOX',
            CURLOPT_USERPWD => $email_address . ':' . $password_clean,
            CURLOPT_CUSTOMREQUEST => 'SEARCH SUBJECT "You received money with Zelle" SINCE "' . $dateMail . '"',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT => 45,
        ]);

        $this->zelleMailLog('Searching Zelle emails with cURL IMAPS', array(
            'email_address' => $email_address,
            'date_from' => $dateMail
        ));

        $searchResult = curl_exec($ch);
        if ($searchResult === false || curl_errno($ch)) {
            $this->zelleMailLog('cURL IMAPS search failed', array(
                'curl_errno' => curl_errno($ch),
                'curl_error' => curl_error($ch),
                'http_code' => curl_getinfo($ch, CURLINFO_RESPONSE_CODE)
            ));
            curl_close($ch);
            return [];
        }

        $searchResult = str_replace('* SEARCH', '', $searchResult);
        $messageIds = array_filter(array_map('trim', explode(' ', trim($searchResult))));

        if (empty($messageIds)) {
            $this->zelleMailLog('No Zelle emails found by cURL IMAPS search', array(
                'raw_search_result' => trim($searchResult)
            ));
            curl_close($ch);
            return [];
        }

        $this->zelleMailLog('Zelle emails found by cURL IMAPS search', array(
            'count' => count($messageIds),
            'message_ids' => implode(',', $messageIds)
        ));

        $transactionList = [];
        foreach (array_reverse($messageIds) as $msgId) {
            $msgId = trim($msgId);
            if ($msgId === '' || !is_numeric($msgId)) {
                continue;
            }

            curl_setopt_array($ch, [
                CURLOPT_URL => 'imaps://imap.gmail.com:993/INBOX;MAILINDEX=' . $msgId,
                CURLOPT_CUSTOMREQUEST => null,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_TIMEOUT => 45,
            ]);

            $message = curl_exec($ch);
            if ($message === false || curl_errno($ch)) {
                $this->zelleMailLog('cURL IMAPS fetch failed', array(
                    'message_id' => $msgId,
                    'curl_errno' => curl_errno($ch),
                    'curl_error' => curl_error($ch)
                ));
                continue;
            }

            $message = preg_replace('/<style[^>]*>.*?<\/style>/s', '', $message);
            $message = strip_tags($message);
            $message = preg_replace('/\s+/', ' ', $message);
            $message = preg_replace('/=[\dA-Fa-f]{2}/', '', $message);

            $confirmationRegex = '/Confirmation:\s*([\S]+)/';
            $amountRegex = '/sent you \s*([^\r\n]+?)\s*Date:/';
            $memoRegex = '/Memo: ([^\r\n]{1,50})/';
            $dateRegex = '/Date:\s*([\d\/]+)/';
            $nameRegex = '/Wells Fargo Alert\s*([^\r\n]+?)\s*sent you/';

            $confirmation = preg_match($confirmationRegex, $message, $m) ? strip_tags($m[1]) : '';
            $amount = preg_match($amountRegex, $message, $m) ? strip_tags($m[1]) : '';
            $amount = rtrim(rtrim($amount, '0'), '.');
            $amount = str_replace(',', '', $amount);
            $memo = preg_match($memoRegex, $message, $m) ? strip_tags($m[1]) : '';
            $date = preg_match($dateRegex, $message, $m) ? strip_tags($m[1]) : '';
            $name = preg_match($nameRegex, $message, $m) ? strip_tags($m[1]) : '';
            $name = str_replace("'", '', $name);

            $timestamp = strtotime(trim($date));
            $PaydateMail = $timestamp ? date("Y-m-d", $timestamp) : '';

            $transaction = [
                'Paydate' => $PaydateMail,
                'Amount' => $amount,
                'ConfirmationCode' => $confirmation,
                'Description' => $memo,
                'DonarName' => $name,
                'paymentfrom' => $payment_system,
            ];

            if ($confirmation === '' || $amount === '' || $name === '' || empty($timestamp)) {
                $this->zelleMailLog('Parsed cURL Zelle email has missing fields', array(
                    'message_id' => $msgId,
                    'paydate' => $PaydateMail,
                    'amount' => $amount,
                    'confirmation' => $confirmation,
                    'donor_name' => $name,
                    'memo' => $memo
                ));
            } else {
                $this->zelleMailLog('Parsed cURL Zelle email', array(
                    'message_id' => $msgId,
                    'paydate' => $PaydateMail,
                    'amount' => $amount,
                    'confirmation' => $confirmation,
                    'donor_name' => $name,
                    'paymentfrom' => $payment_system
                ));
            }

            $transactionList[] = $transaction;
        }

        curl_close($ch);
        $this->zelleMailLog('Finished cURL Zelle mail read', array(
            'transactions_parsed' => count($transactionList)
        ));

        return $transactionList;

        // if ($mails) {
        //     rsort($mails);
        //     $transactionList = array();

        //     foreach ($mails as $email_number) {
        //         $headers = imap_fetch_overview($conn, $email_number, 0);
        //         $message = imap_fetchbody($conn, $email_number, '1');

        //         // Remove HTML tags and CSS
        //         $message = preg_replace('/<style[^>]*>.*?<\/style>/s', '', $message);
        //         $message = strip_tags($message);

        //         // Remove unwanted spaces and characters
        //         $message = preg_replace('/\s+/', ' ', $message);
        //         $message = preg_replace('/=[\dA-Fa-f]{2}/', '', $message);
        //         $confirmationRegex = '/Confirmation:\s*([\S]+)/';
        //         //$amountRegex = '/sent you \$(\d+(?:\.\d{2})?)/';
        //         $amountRegex = '/sent you \s*([^\r\n]+?)\s*Date:/';
        //         //$memoRegex = '/Memo:\s*([^<]+)/';
        //         $memoRegex = '/Memo: ([^\r\n]{1,50})/';

        //         //$memoRegex = '/Memo: (.+?We deposited the = money in your Wells Fargo account ending in ...2631\.)/s';

        //         $dateRegex = '/Date:\s*([\d\/]+)/';
        //         //$nameRegex = '/Wells Fargo Alert\s*([^\n]+?)\s*sent you/';
        //         $nameRegex = '/Wells Fargo Alert\s*([^\r\n]+?)\s*sent you/';

        //         $confirmation = strip_tags(preg_match($confirmationRegex, $message, $matchesConfirmation) ? $matchesConfirmation[1] : '');
        //         $amount = strip_tags(preg_match($amountRegex, $message, $matchesAmount) ? $matchesAmount[1] : '');

        //         //$amount = number_format($amount, 2);

        //         $amount = rtrim($amount, '0');

        //         $amount = rtrim($amount, '.');
        //         $amount = str_replace(',', '', $amount);
        //         //echo "<script>alert('The amount is: $amount');</script>";
        //         $memo = strip_tags(preg_match($memoRegex, $message, $matchesMemo) ? $matchesMemo[1] : '');
        //         $date = strip_tags(preg_match($dateRegex, $message, $matchesDate) ? $matchesDate[1] : '');
        //         //$name = strip_tags(preg_match($nameRegex, $headers[0]->subject, $matchesName) ? $matchesName[1] : '');
        //         $name = strip_tags(preg_match($nameRegex, $message, $matchesDate) ? $matchesDate[1] : '');
        //         $name = str_replace("'", '', $name);
        //         // $paymentfrom  = 'Regularsystem';
        //         $paymentfrom  = $payment_system;
        //         $timestamp = strtotime(trim($date));
        //         $PaydateMail = date("Y-m-d", $timestamp);

        //         // Create an associative array for each transaction
        //         $transaction = array(
        //             'Paydate' => $PaydateMail,
        //             'Amount' => $amount,
        //             'ConfirmationCode' => $confirmation,
        //             'Description' => $memo,
        //             'DonarName' => $name,
        //             'paymentfrom' => $paymentfrom
        //         );

        //         $transactionList[] = $transaction;
        //     }

        //     // Now $transactionList contains the extracted information for each transaction

        // }

        // imap_close($conn);
        // return $transactionList;
    }
    
    
    function getConfirmationCode28July($account_type) {
        
        
        $password = '';
        $payment_system = '';
        $email_address = "";

        if ($account_type == "Pujaaccount") {
            $email_address = "treasurerpuja@durgabari.org";
            $password = 'ggtfnczdodeukgzp';
            $payment_system = 'pujaregistration';
        } else {
            $email_address = "treasurer@durgabari.org";
            $password = 'ywbfszrjiubozbjt';
            $payment_system = 'Regularsystem';
        }
        
        
        
        
        
        
        
        
        $conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'treasurer@durgabari.org', 'ywbfszrjiubozbjt
        ') or die('Cannot connect to Gmail: ' . imap_last_error());
        $dateMail = date("d M Y", strtotime("-7 days"));
        $dateMail1 = date("d M Y", strtotime("+1 days"));
        $mails = imap_search($conn, 'SUBJECT "You received money with Zelle" SINCE "' . $dateMail . '" BEFORE "' . $dateMail1 . '"');
    
        if ($mails) {
            rsort($mails);
            $transactionList = array();
    
            foreach ($mails as $email_number) {
                $headers = imap_fetch_overview($conn, $email_number, 0);
                $message = imap_fetchbody($conn, $email_number, '1');
        
                // Remove HTML tags and CSS
                $message = preg_replace('/<style[^>]*>.*?<\/style>/s', '', $message);
                $message = strip_tags($message);
        
                // Remove unwanted spaces and characters
                $message = preg_replace('/\s+/', ' ', $message);
                $message = preg_replace('/=[\dA-Fa-f]{2}/', '', $message);
                $confirmationRegex = '/Confirmation:\s*([\S]+)/';
                //$amountRegex = '/sent you \$(\d+(?:\.\d{2})?)/';
                $amountRegex = '/sent you \s*([^\r\n]+?)\s*Date:/';
                //$memoRegex = '/Memo:\s*([^<]+)/';
                $memoRegex = '/Memo: ([^\r\n]{1,50})/';
                



                //$memoRegex = '/Memo: (.+?We deposited the = money in your Wells Fargo account ending in ...2631\.)/s';


                $dateRegex = '/Date:\s*([\d\/]+)/';
                //$nameRegex = '/Wells Fargo Alert\s*([^\n]+?)\s*sent you/';
                $nameRegex = '/Wells Fargo Alert\s*([^\r\n]+?)\s*sent you/';


                $confirmation = strip_tags(preg_match($confirmationRegex, $message, $matchesConfirmation) ? $matchesConfirmation[1] : '');
                $amount = strip_tags(preg_match($amountRegex, $message, $matchesAmount) ? $matchesAmount[1] : '');
                
                
                //$amount = number_format($amount, 2);

                $amount = rtrim($amount, '0');

                $amount = rtrim($amount, '.');
                $amount = str_replace(',', '', $amount);
                //echo "<script>alert('The amount is: $amount');</script>";
                $memo = strip_tags(preg_match($memoRegex, $message, $matchesMemo) ? $matchesMemo[1] : '');
                $date = strip_tags(preg_match($dateRegex, $message, $matchesDate) ? $matchesDate[1] : '');
                //$name = strip_tags(preg_match($nameRegex, $headers[0]->subject, $matchesName) ? $matchesName[1] : '');
                $name = strip_tags(preg_match($nameRegex, $message, $matchesDate) ? $matchesDate[1] : '');
                $name = str_replace("'", '', $name);
                $paymentfrom  = 'Regularsystem';
                $timestamp = strtotime(trim($date));
                $PaydateMail = date("Y-m-d", $timestamp); 

                
                // Create an associative array for each transaction
                $transaction = array(
                    'Paydate' => $PaydateMail,
                    'Amount' => $amount,
                    'ConfirmationCode' => $confirmation,
                    'Description' => $memo,
                    'DonarName' => $name,
                    'paymentfrom' => $paymentfrom
                );
        
                $transactionList[] = $transaction;
            }
            
    
            // Now $transactionList contains the extracted information for each transaction
            
        }
    
        imap_close($conn);
        return $transactionList;
    
    }
    
    function getConfirmationCodeOldFormat() {
        //$z[] = 0;
        $conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'treasurer@durgabari.org', 'ywbfszrjiubozbjt
') or die('Cannot connect to Gmail: ' . imap_last_error());
        //$conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'paras.sharma@eiceinternational.com', '9319648110@8619') or die('Cannot connect to Gmail: ' . imap_last_error());
        $dateMail = date ( "d M Y", strToTime ( "-7 days" ) );
        //$dateMail1 = date ( "d M Y", strToTime ( "+1 hours" ) );
         $dateMail1 = date ( "d M Y", strToTime ( "+1 days" ) );
        //$some   = imap_search($conn, 'SUBJECT "You received money with Zelle"" SINCE "$date"', SE_UID);
       // $mails = imap_search($conn, 'SUBJECT "You received money with Zelle" ON "' . $dateMail . '"');
        $mails = imap_search($conn,'SUBJECT "You received money with Zelle" SINCE "'.$dateMail.'" BEFORE "'.$dateMail1.'"');
       
        //$mails = imap_search($conn, 'SUBJECT "SUBJECT "You sent money with Zelle" ON "' . $dateMail . '"');
        //$mails = imap_search($conn, 'SUBJECT "You sent money with Zelle"');
        //$mails = imap_search($conn, 'SUBJECT "You received money with Zelle"');
        if ($mails) {

            /* Mail output variable starts */

            // rsort is used to display the latest emails on top /
            rsort($mails);
            $items = array();
            // For each email /
            foreach ($mails as $email_number) {
               //if ($email_number == 7418){
                /* Retrieve specific email information */
                $headers = imap_fetch_overview($conn, $email_number, 0);
                //if ($headers[0]->seen == 1){
                //if ($headers[0]->recent == 1) {
                    //$read = "Yes";
                 
                    // if ($headers->Subject == "SUBJECT "You received money with Zelle") {
                
                    //    //Note 5
                    //     //Run code to parse body information
                    // }
                    /* Returns a particular section of the body */
                    $message = imap_fetchbody($conn, $email_number, '1');
                    //$html = preg_replace_callback('/<table\b[^>]*>.*?<\/table>/si', 'removeTableIfImg', $message);

                    $subMessage = substr($message, 1500, 3000); // Sukhitest
                    $finalMessage1 = trim(quoted_printable_decode($subMessage));
                    // $message2 = imap_fetchbody($conn, $email_number, '1.2');
                    // $removehtmltags= htmlspecialchars($subMessage);// Sukhitest
                    $removehtmltags_Striptag = strip_tags($subMessage);
                    $removehtmltags_Striptag_result = str_replace("=20", '', trim($removehtmltags_Striptag));
                    $whatIWant = substr($subMessage, "You received money with Zelle=C2=AE");
                    $whatIWant1 = substr($subMessage, strpos($subMessage, "You received money with Zelle=C2=AE") - 1);
                    $variable = substr($whatIWant1, 0, strpos($whatIWant1, "XXXXXX2631"));
                    $variable1 = substr($variable, -1, strpos($variable, "You received money with Zelle���"));
                    $finalMessage = trim(quoted_printable_decode($subMessage));
                    $substring = $this->string_between_two_string($finalMessage, 'sent you money. Here are the details:', 'This money has been deposited in your Wells Fargo account XXXXXX2631.');
                    var_dump($finalMessage);


                    $newstr = str_replace("'", '', $substring);
                    $str = str_replace(' ', "", $newstr);
                    // Taking all 4 values from the form data(input)
                    $Date = date("Y-m-d", strtotime($headers[0]->date));
                   // $Date = date("Y/m/d");
                    $FinalDate = $this->string_between_two_string($removehtmltags_Striptag_result, 'Date', 'Amount');
                    $Donar = $this->string_between_two_string($removehtmltags_Striptag_result, 'You received money with Zelle=C2=AE', 'sent you money.');
                    $FinalAmount = $this->string_between_two_string($removehtmltags_Striptag_result, 'Amount', '.00');
                    $Amount = trim($FinalAmount);
                    $dsk = strstr($removehtmltags_Striptag_result, 'Description' );
                    if($dsk!=null ||$dsk!="")
                    {
                        $FinalConfirmationCode = $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation Code', 'Description');
                        $ConfirmationCode = trim($FinalConfirmationCode);
                    //$Description = substr($str, strpos($removehtmltags_Striptag_result, "Description")  +13);
                    //$Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', 'This');
                    $Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', '=09=09=09');
                    //$Description  = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description=', 'will receive');
                    $FinalDescription = trim($Description);
                    }else{
                        $FinalConfirmationCode = $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation Code', '=09=09=09'); 
                        $ConfirmationCode = trim($FinalConfirmationCode);
                    //$Description = substr($str, strpos($removehtmltags_Striptag_result, "Description")  +13);
                    //$Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', 'This');
                    $Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', '=09=09=09');
                    //$Description  = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description=', 'will receive');
                    $FinalDescription = trim($Description);
                    }
                    //$FinalConfirmationCode =   $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation code', 'Description=');
                    
                    $FinalDesc = preg_replace('/[^a-zA-Z0-9\s]/', '', $FinalDescription);
                    $FinalNewDescription =trim($FinalDesc);
                    $name = preg_replace('/[^a-zA-Z0-9\s]/', '', $Donar);
                    $DonarName =trim($name);
                    $timestamp = strtotime(trim($FinalDate));
                    $Paydate = date("Y-m-d", $timestamp); 
                    $paymentfrom  = 'Regularsystem';
                    $items[] = [$Paydate, $Amount, $ConfirmationCode, $FinalNewDescription,$DonarName,$paymentfrom];
                //}
            }
            // imap connection is closed /
       // }
        //echo("<script type='text/javascript'> alert('".$items[0][4]."'); </script>");

    }

        imap_close($conn);
        return $items;
    }

    
function getConfirmationCodeoldbackup() {
        //$z[] = 0;
        $conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'treasurer@durgabari.org', 'ywbfszrjiubozbjt
') or die('Cannot connect to Gmail: ' . imap_last_error());
        //$conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'paras.sharma@eiceinternational.com', '9319648110@8619') or die('Cannot connect to Gmail: ' . imap_last_error());
        $dateMail = date ( "d M Y", strToTime ( "-7 days" ) );
        //$dateMail1 = date ( "d M Y", strToTime ( "+1 hours" ) );
         $dateMail1 = date ( "d M Y", strToTime ( "+1 days" ) );
        //$some   = imap_search($conn, 'SUBJECT "You received money with Zelle"" SINCE "$date"', SE_UID);
       // $mails = imap_search($conn, 'SUBJECT "You received money with Zelle" ON "' . $dateMail . '"');
        $mails = imap_search($conn,'SUBJECT "You received money with Zelle" SINCE "'.$dateMail.'" BEFORE "'.$dateMail1.'"');
       
        //$mails = imap_search($conn, 'SUBJECT "SUBJECT "You sent money with Zelle" ON "' . $dateMail . '"');
        //$mails = imap_search($conn, 'SUBJECT "You sent money with Zelle"');
        //$mails = imap_search($conn, 'SUBJECT "You received money with Zelle"');
        if ($mails) {

            /* Mail output variable starts */

            // rsort is used to display the latest emails on top /
            rsort($mails);
            $items = array();
            // For each email /
            foreach ($mails as $email_number) {

                /* Retrieve specific email information */
                $headers = imap_fetch_overview($conn, $email_number, 0);
                //if ($headers[0]->seen == 1){
                //if ($headers[0]->recent == 1) {
                    //$read = "Yes";
                 
                    // if ($headers->Subject == "SUBJECT "You received money with Zelle") {
                
                    //    //Note 5
                    //     //Run code to parse body information
                    // }
                    /* Returns a particular section of the body */
                    $message = imap_fetchbody($conn, $email_number, '1');
                    //$html = preg_replace_callback('/<table\b[^>]*>.*?<\/table>/si', 'removeTableIfImg', $message);

                    $subMessage = substr($message, 1500, 3000); // Sukhitest
                    $finalMessage1 = trim(quoted_printable_decode($subMessage));
                    // $message2 = imap_fetchbody($conn, $email_number, '1.2');
                    // $removehtmltags= htmlspecialchars($subMessage);// Sukhitest
                    $removehtmltags_Striptag = strip_tags($subMessage);
                    $removehtmltags_Striptag_result = str_replace("=20", '', trim($removehtmltags_Striptag));
                    $whatIWant = substr($subMessage, "You received money with Zelle=C2=AE");
                    $whatIWant1 = substr($subMessage, strpos($subMessage, "You received money with Zelle=C2=AE") - 1);
                    $variable = substr($whatIWant1, 0, strpos($whatIWant1, "XXXXXX2631"));
                    $variable1 = substr($variable, -1, strpos($variable, "You received money with Zelle���"));
                    $finalMessage = trim(quoted_printable_decode($subMessage));
                    $substring = $this->string_between_two_string($finalMessage, 'sent you money. Here are the details:', 'This money has been deposited in your Wells Fargo account XXXXXX2631.');
                    var_dump($finalMessage);


                    $newstr = str_replace("'", '', $substring);
                    $str = str_replace(' ', "", $newstr);
                    // Taking all 4 values from the form data(input)
                    $Date = date("Y-m-d", strtotime($headers[0]->date));
                   // $Date = date("Y/m/d");
                    $FinalDate = $this->string_between_two_string($removehtmltags_Striptag_result, 'Date', 'Amount');
                    $Donar = $this->string_between_two_string($removehtmltags_Striptag_result, 'You received money with Zelle=C2=AE', 'sent you money.');
                    $FinalAmount = $this->string_between_two_string($removehtmltags_Striptag_result, 'Amount', '.00');
                    $Amount = trim($FinalAmount);
                    //$FinalConfirmationCode =   $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation code', 'Description=');
                    $FinalConfirmationCode = $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation Code', 'Description');
                    $ConfirmationCode = trim($FinalConfirmationCode);
                    //$Description = substr($str, strpos($removehtmltags_Striptag_result, "Description")  +13);
                    //$Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', 'This');
                    $Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', '=09=09=09');
                    //$Description  = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description=', 'will receive');
                    $FinalDescription = trim($Description);
                    $DonarName =trim($Donar);
                    $timestamp = strtotime(trim($FinalDate));
                    $Paydate = date("Y-m-d", $timestamp); 
                    $items[] = [$Paydate, $Amount, $ConfirmationCode, $FinalDescription,$DonarName];
                //}
            }
            // imap connection is closed /
        }

        imap_close($conn);
        return $items;
    }

    function getConfirmationCode2() {
        //$z[] = 0;
        $conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'treasurer@durgabari.org', 'treasurer1234') or die('Cannot connect to Gmail: ' . imap_last_error());
        //$conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'paras.sharma@eiceinternational.com', '9319648110@8619') or die('Cannot connect to Gmail: ' . imap_last_error());
        $dateMail = date ( "d M Y", strToTime ( "-7 days" ) );
        //$dateMail1 = date ( "d M Y", strToTime ( "+1 hours" ) );
         $dateMail1 = date ( "d M Y", strToTime ( "+1 days" ) );
        //$some   = imap_search($conn, 'SUBJECT "You received money with Zelle"" SINCE "$date"', SE_UID);
       // $mails = imap_search($conn, 'SUBJECT "You received money with Zelle" ON "' . $dateMail . '"');
        $mails = imap_search($conn,'SUBJECT "You received money with Zelle" SINCE "'.$dateMail.'" BEFORE "'.$dateMail1.'"');
       
        //$mails = imap_search($conn, 'SUBJECT "SUBJECT "You sent money with Zelle" ON "' . $dateMail . '"');
        //$mails = imap_search($conn, 'SUBJECT "You sent money with Zelle"');
        //$mails = imap_search($conn, 'SUBJECT "You received money with Zelle"');
        if ($mails) {

            /* Mail output variable starts */

            // rsort is used to display the latest emails on top /
            rsort($mails);
            $items = array();
            // For each email /
            foreach ($mails as $email_number) {

                /* Retrieve specific email information */
                $headers = imap_fetch_overview($conn, $email_number, 0);
                //if ($headers[0]->seen == 1){
                //if ($headers[0]->recent == 1) {
                    //$read = "Yes";
                 
                    // if ($headers->Subject == "SUBJECT "You received money with Zelle") {
                
                    //    //Note 5
                    //     //Run code to parse body information
                    // }
                    /* Returns a particular section of the body */
                    $message = imap_fetchbody($conn, $email_number, '1');
                    //$html = preg_replace_callback('/<table\b[^>]*>.*?<\/table>/si', 'removeTableIfImg', $message);

                    $subMessage = substr($message, 1500, 3000); // Sukhitest
                    $finalMessage1 = trim(quoted_printable_decode($subMessage));
                    // $message2 = imap_fetchbody($conn, $email_number, '1.2');
                    // $removehtmltags= htmlspecialchars($subMessage);// Sukhitest
                    $removehtmltags_Striptag = strip_tags($subMessage);
                    $removehtmltags_Striptag_result = str_replace("=20", '', trim($removehtmltags_Striptag));
                    $whatIWant = substr($subMessage, "You received money with Zelle=C2=AE");
                    $whatIWant1 = substr($subMessage, strpos($subMessage, "You received money with Zelle=C2=AE") - 1);
                    $variable = substr($whatIWant1, 0, strpos($whatIWant1, "XXXXXX2631"));
                    $variable1 = substr($variable, -1, strpos($variable, "You received money with Zelle���"));
                    $finalMessage = trim(quoted_printable_decode($subMessage));
                    $substring = $this->string_between_two_string($finalMessage, 'sent you money. Here are the details:', 'This money has been deposited in your Wells Fargo account XXXXXX2631.');
                    var_dump($finalMessage);


                    $newstr = str_replace("'", '', $substring);
                    $str = str_replace(' ', "", $newstr);
                    // Taking all 4 values from the form data(input)
                    $Date = date("d F, Y", strtotime($headers[0]->date));
                    //$Date = date("Y/m/d");
                    $Donar = $this->string_between_two_string($removehtmltags_Striptag_result, 'You received money with Zelle=C2=AE', 'sent you money.');
                    $FinalAmount = $this->string_between_two_string($removehtmltags_Striptag_result, 'Amount', '.00');
                    $Amount = trim($FinalAmount);
                    //$FinalConfirmationCode =   $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation code', 'Description=');
                    $FinalConfirmationCode = $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation Code', 'Description');
                    $ConfirmationCode = trim($FinalConfirmationCode);
                    //$Description = substr($str, strpos($removehtmltags_Striptag_result, "Description")  +13);
                    //$Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', 'This');
                    $Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', '=09=09=09');
                    //$Description  = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description=', 'will receive');
                    $FinalDescription = trim($Description);
                    $DonarName =trim($Donar);
                    $items[] = [$Date, $Amount, $ConfirmationCode, $FinalDescription,$DonarName];
                //}
            }
            // imap connection is closed /
        }

        imap_close($conn);
        return $items;
    }

    function getConfirmationCode1() {
        //$z[] = 0;
        $conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'treasurer@durgabari.org', 'treasurer1234') or die('Cannot connect to Gmail: ' . imap_last_error());
        //$conn = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'paras.sharma@eiceinternational.com', '9319648110@8619') or die('Cannot connect to Gmail: ' . imap_last_error());
        //$dateMail = date("d M Y", strToTime("0 days"));
        //$some   = imap_search($conn, 'SUBJECT "You received money with Zelle"" SINCE "$date"', SE_UID);
        //$mails = imap_search($conn, 'SUBJECT "You received money with Zelle" ON "' . $dateMail . '"');
        //$mails = imap_search($conn, 'SUBJECT "SUBJECT "You sent money with Zelle" ON "' . $dateMail . '"');
        //$mails = imap_search($conn, 'SUBJECT "You sent money with Zelle"');
        $mails = imap_search($conn, 'SUBJECT "You received money with Zelle"');
        if ($mails) {

            /* Mail output variable starts */

            // rsort is used to display the latest emails on top /
            rsort($mails);
            $items = array();
            // For each email /
            foreach ($mails as $email_number) {

                /* Retrieve specific email information */
                $headers = imap_fetch_overview($conn, $email_number, 0);
                // if ($headers) {

                /* Returns a particular section of the body */
                $message = imap_fetchbody($conn, $email_number, '1');
                //$html = preg_replace_callback('/<table\b[^>]*>.*?<\/table>/si', 'removeTableIfImg', $message);

                $subMessage = substr($message, 2132, 3000); // Sukhitest
                $finalMessage1 = trim(quoted_printable_decode($subMessage));
                // $message2 = imap_fetchbody($conn, $email_number, '1.2');
                // $removehtmltags= htmlspecialchars($subMessage);// Sukhitest
                $removehtmltags_Striptag = strip_tags($subMessage);
                $removehtmltags_Striptag_result = str_replace("=20", '', trim($removehtmltags_Striptag));
                $whatIWant = substr($subMessage, "You received money with Zelle=C2=AE");
                $whatIWant1 = substr($subMessage, strpos($subMessage, "You received money with Zelle=C2=AE") - 1);
                $variable = substr($whatIWant1, 0, strpos($whatIWant1, "XXXXXX2631"));
                $variable1 = substr($variable, -1, strpos($variable, "You received money with Zelle���"));
                $finalMessage = trim(quoted_printable_decode($subMessage));
                $substring = $this->string_between_two_string($finalMessage, 'sent you money. Here are the details:', 'This money has been deposited in your Wells Fargo account XXXXXX2631.');
                var_dump($finalMessage);


                $newstr = str_replace("'", '', $substring);
                $str = str_replace(' ', "", $newstr);
                // Taking all 4 values from the form data(input)
                $Date = date("d F, Y", strtotime($headers[0]->date));
                //$Date = date("Y/m/d");
                $FinalAmount = $this->string_between_two_string($removehtmltags_Striptag_result, 'Amount', '.00');
                $Amount = trim($FinalAmount);
                //$FinalConfirmationCode =   $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation code', 'Description=');
                $FinalConfirmationCode = $this->string_between_two_string($removehtmltags_Striptag_result, 'Confirmation Code', 'Description');
                $ConfirmationCode = trim($FinalConfirmationCode);
                //$Description = substr($str, strpos($removehtmltags_Striptag_result, "Description")  +13);
                $Description = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description', 'This');
                //$Description  = $this->string_between_two_string($removehtmltags_Striptag_result, 'Description=', 'will receive');
                $FinalDescription = trim($Description);
                $items[] = [$Date, $Amount, $ConfirmationCode, $FinalDescription];
            }
        }
        // imap connection is closed /

        imap_close($conn);
        return $items;
    }

    //     function ReceiptSave($GetData) {
    //         $servername = "localhost";
    //         $username = "durgab5";
    //         $password = "GhKiBW1zVyCL";
    //         $dbname = "durgab5_HDBS_Payment";
    //         //$str = str_replace(',', "", trim($GetData[0]));
    //         // Create connection
    //         $conn = new mysqli($servername,$username, $password, $dbname);
    //         foreach ($GetData as $payment_code) {
    //             $Date = $payment_code[0];
    //             $Confirmationcode = $payment_code[2];
    //             $Amount = $payment_code[1];
    //             $Description = $payment_code[3];
    //         // Check connection
    //         if ($conn->connect_error) {
    //             die("Connection failed: ". $conn->connect_error);
    //         }
    //         $sql = "INSERT INTO confirm_code  VALUES ('','$Date','$Confirmationcode','$Amount','$Description')";
    //         $retval = mysqli_query( $conn,$sql  );
    //     }
    //         //$query_run = mysqli_query($con, $query);
    //         // if ($conn->query($sql) === TRUE) {
    //         //     echo "record inserted successfully";
    //         // } else {
    //         //     echo "Error: " . $sql . "<br>" . $conn->error;
    //         // }
    // }


    function ReceiptSave($GetData) {
        $this->zelleMailLog('Saving Zelle confirmation to DB', array(
            'paydate' => $GetData['Paydate'] ?? '',
            'amount' => $GetData['Amount'] ?? '',
            'confirmation' => $GetData['ConfirmationCode'] ?? '',
            'donor_name' => $GetData['DonarName'] ?? '',
            'paymentfrom' => $GetData['paymentfrom'] ?? ''
        ));
        $conn = gz_mysqli_connect(DEFAULT_HOST, DEFAULT_USER, DEFAULT_PASS, DEFAULT_DB);

        // Check connection
        if ($conn->connect_error) {
            $this->zelleMailLog('DB connection failed while saving Zelle confirmation', array(
                'error' => $conn->connect_error
            ));
            die("Connection failed: " . $conn->connect_error);
            
        }
        $this->zelleMailLog('DB connection opened for Zelle confirmation save');

        $paydate = $GetData['Paydate'] ?? '';
        $confirmation = $GetData['ConfirmationCode'] ?? '';
        $amount = $GetData['Amount'] ?? '';
        $description = $GetData['Description'] ?? '';
        $donarName = $GetData['DonarName'] ?? '';
        $paymentfrom = $GetData['paymentfrom'] ?? '';

        if ($confirmation === '') {
            $this->zelleMailLog('Zelle confirmation DB save skipped because confirmation is empty');
            mysqli_close($conn);
            return false;
        }

        $checkStmt = mysqli_prepare($conn, 'SELECT id FROM confirm_code WHERE Confirmation = ? LIMIT 1');
        if (!$checkStmt) {
            $this->zelleMailLog('Prepare failed for Zelle duplicate check', array('mysqli_error' => mysqli_error($conn)));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($checkStmt, 's', $confirmation);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);
        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            mysqli_stmt_close($checkStmt);
            mysqli_close($conn);
            $this->zelleMailLog('Zelle confirmation already exists, skipping insert', array('confirmation' => $confirmation));
            return true;
        }
        mysqli_stmt_close($checkStmt);

        $stmt = mysqli_prepare($conn, 'INSERT INTO confirm_code (date, Confirmation, Amount, Description, DonarName, UpdatedOn, paymentfrom) VALUES (?, ?, ?, ?, ?, NULL, ?)');
        if (!$stmt) {
            $this->zelleMailLog('Prepare failed for Zelle confirmation insert', array('mysqli_error' => mysqli_error($conn)));
            mysqli_close($conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, 'ssssss', $paydate, $confirmation, $amount, $description, $donarName, $paymentfrom);
        $retval = mysqli_stmt_execute($stmt);
        $affectedRows = mysqli_stmt_affected_rows($stmt);
        $stmtError = mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        $this->zelleMailLog('Zelle confirmation DB save finished', array(
            'confirmation' => $confirmation,
            'success' => $retval ? 'yes' : 'no',
            'affected_rows' => $affectedRows,
            'mysqli_error' => $stmtError
        ));
        return $retval;
        
    }

    function UpdateCodeData() {
        $cmCode = $_POST['code'] ?? '';
        GzObject::loadFiles('Model', array('ConfirmCode'));
        $ConfirmCodeModel = new ConfirmCodeModel();
        $arr = array();
        $arr= $ConfirmCodeModel->UpdateCode($cmCode);
        echo '<span class="success_code">' . __('Your payment code is matched you can book') . '</span>';
    }
    // function checkCodeDD() {
    //     GzObject::loadFiles('Model', array('ConfirmCode'));
    //     $ConfirmCodeModel = new ConfirmCodeModel();
    //     $arr = array();
    //     $arr= $ConfirmCodeModel->getMaxAll();
    //     $this->tpl['Amount'] =  $arr;
    //     foreach ($arr as $key => $value) {
                           
    //     echo '<option value="'.$value['Amount'].'">'.$value['Amount']. '</option>';
                            
                           
    //     }
        
    // }
    
    function checkCodeDD() {
        $this->isAjax = true;
        session_write_close(); // release session lock — this action only reads, never writes session
        GzObject::loadFiles('Model', array('ConfirmCode'));
        $ConfirmCodeModel = new ConfirmCodeModel();

        $donor_name  = trim($_POST['donor_name']   ?? '');
        $zelle_amt   = trim($_POST['zelle_amount']  ?? '');
        $zelle_date  = trim($_POST['zelle_date']    ?? '');

        $account_type   = isset($_GET['account']) ? trim($_GET['account']) : ($_POST['account'] ?? null);
        $payment_system = ($account_type === 'Pujaaccount') ? 'pujaregistration' : 'Regularsystem';

        $this->zelleMailLog('Searching confirm_code for Zelle transaction', array(
            'donor_name' => $donor_name,
            'amount' => $zelle_amt,
            'date' => $zelle_date,
            'account_type' => $account_type,
            'payment_system' => $payment_system
        ));

        if ($donor_name === '' || $zelle_amt === '') {
            $this->zelleMailLog('Zelle search skipped because donor or amount was empty');
            echo 'NO_MATCH';
            return;
        }

        $return_id = !empty($_POST['return_id']);
        $arr = $ConfirmCodeModel->getByMember($donor_name, $zelle_amt, $zelle_date ?: null, $payment_system, $return_id);

        if (empty($arr)) {
            $this->zelleMailLog('No matching Zelle transaction in confirm_code');
            echo 'NO_MATCH';
            return;
        }

        $this->zelleMailLog('Matching Zelle transactions found in confirm_code', array('count' => count($arr)));

        foreach ($arr as $value) {
            $opt = htmlspecialchars($value['Amount'], ENT_QUOTES);
            $id = htmlspecialchars($return_id ? ($value['id'] ?? $value['Amount']) : $value['Amount'], ENT_QUOTES);
            echo '<option value="' . $id . '">' . $opt . '</option>';
        }
    }

    function importZelleAndSearch() {
        $this->isAjax = true;
        session_write_close(); // release session lock before slow external API call
        GzObject::loadFiles('Model', array('ConfirmCode'));
        $ConfirmCodeModel = new ConfirmCodeModel();

        $account_type = isset($_GET['account']) ? trim($_GET['account']) : ($_POST['account'] ?? null);
        $payment_system = ($account_type === 'Pujaaccount') ? 'pujaregistration' : 'Regularsystem';
        $this->zelleMailLog('Import Zelle and search started', array(
            'account_type' => $account_type,
            'payment_system' => $payment_system,
            'donor_name' => $_POST['donor_name'] ?? '',
            'amount' => $_POST['zelle_amount'] ?? '',
            'date' => $_POST['zelle_date'] ?? ''
        ));
        $transactions = $this->getConfirmationCode($account_type);
        $inserted = 0;
        $skipped = 0;
        foreach ($transactions as $payment_code) {
            $existing = $ConfirmCodeModel->getConfirmCodeCheck($payment_code['ConfirmationCode']);
            if (empty($existing)) {
                if ($this->ReceiptSave($payment_code)) {
                    $inserted++;
                }
            } else {
                $skipped++;
            }
        }

        $this->zelleMailLog('Import Zelle DB sync finished', array(
            'transactions_from_mail' => count($transactions),
            'inserted' => $inserted,
            'already_existing' => $skipped
        ));

        $donorName = trim($_POST['donor_name']  ?? '');
        $zelleAmt  = trim($_POST['zelle_amount'] ?? '');
        $zelleDate = trim($_POST['zelle_date']   ?? '') ?: null;

        if (empty($donorName) || empty($zelleAmt)) {
            $this->zelleMailLog('Import finished without search because donor or amount was empty');
            echo 'NO_MATCH';
            return;
        } else {
            $return_id = !empty($_POST['return_id']);
            $arr = $ConfirmCodeModel->getByMember($donorName, $zelleAmt, $zelleDate, $payment_system, $return_id);
        }

        if (empty($arr)) {
            $this->zelleMailLog('Import finished, no matching confirm_code row after search', array(
                'donor_name' => $donorName,
                'amount' => $zelleAmt,
                'date' => $zelleDate,
                'payment_system' => $payment_system
            ));
            echo 'NO_MATCH';
            return;
        }

        $this->zelleMailLog('Import finished, matching confirm_code rows found', array('count' => count($arr)));

        foreach ($arr as $value) {
            $opt = htmlspecialchars($value['Amount'], ENT_QUOTES);
            $id = htmlspecialchars($return_id ? ($value['id'] ?? $value['Amount']) : $value['Amount'], ENT_QUOTES);
            echo '<option value="' . $id . '">' . $opt . '</option>';
        }
    }

    function debugZelleMailImport() {
        $this->isAjax = true;
        session_write_close();
        header('Content-Type: text/plain; charset=utf-8');

        GzObject::loadFiles('Model', array('ConfirmCode'));
        $ConfirmCodeModel = new ConfirmCodeModel();

        $account_type = isset($_GET['account']) ? trim($_GET['account']) : ($_POST['account'] ?? null);
        $payment_system = ($account_type === 'Pujaaccount') ? 'pujaregistration' : 'Regularsystem';

        $this->zelleMailLog('Manual Zelle mail import debug started', array(
            'account_type' => $account_type,
            'payment_system' => $payment_system
        ));

        $transactions = $this->getConfirmationCode($account_type);
        $inserted = 0;
        $existingCount = 0;
        $failed = 0;

        foreach ($transactions as $payment_code) {
            $confirmation = $payment_code['ConfirmationCode'] ?? '';
            if ($confirmation === '') {
                $failed++;
                $this->zelleMailLog('Skipping parsed Zelle transaction with empty confirmation code', $payment_code);
                continue;
            }

            $existing = $ConfirmCodeModel->getConfirmCodeCheck($confirmation);
            if (!empty($existing)) {
                $existingCount++;
                continue;
            }

            if ($this->ReceiptSave($payment_code)) {
                $inserted++;
            } else {
                $failed++;
            }
        }

        $result = array(
            'account_type' => $account_type,
            'payment_system' => $payment_system,
            'mail_transactions_parsed' => count($transactions),
            'inserted_into_confirm_code' => $inserted,
            'already_existing' => $existingCount,
            'failed_or_skipped' => $failed,
            'log_file' => 'zelle_mail_debug.log'
        );

        $this->zelleMailLog('Manual Zelle mail import debug finished', $result);

        foreach ($result as $key => $value) {
            echo $key . ': ' . $value . PHP_EOL;
        }
    }

 function sortFunction( $a, $b ) {
        return strtotime($b["date"]) - strtotime($a["date"]);
    }
   function checkCode() {

        try {
            $this->isAjax = true;
            GzObject::loadFiles('Model', array('ConfirmCode'));
            $ConfirmCodeModel = new ConfirmCodeModel();
            $arr = array();
            // $z = $this->getConfirmationCode();
            
             $account = isset($_GET['account']) ? trim($_GET['account']) : null;
            $z = $this->getConfirmationCode($account);
            // $i=0;
            $result = false;
            foreach ($z as $payment_code) {

            $arr= $ConfirmCodeModel->getConfirmCodeCheck($payment_code['ConfirmationCode']);
                if (empty($arr) ) {
                    $result = $this->ReceiptSave($payment_code);
                }



            }
        if ($result == true) {
                // echo("<meta http-equiv='refresh' content='1'>");
                //echo '<script>alert("Your payment code is matched you can book")</script>';
                echo '<span class="success_code">' . __('Your payment code is matched you can book') . '</span>';
            } else {
                //echo '<script>alert("This code has not find in mail used used for another booking. Please provide another code, or else contact admin")</script>';

                echo '<span class="error_code">' . __('This code has not find in mail used used for another booking. Please provide another code, or else contact admin') . '</span>';
            }
        
        } catch (Exception $ex) {
            // jump to this part
            // if an exception occurred
        }
    }

    function checkCode2() {

        try {
            $this->isAjax = true;
            GzObject::loadFiles('Model', array('ConfirmCode'));
            $ConfirmCodeModel = new ConfirmCodeModel();

            $opts = array();
            $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
            $arr = $ConfirmCodeModel->getAll($opts);

            $Entercode = $_POST['confirm_code'] ?? '';
            $DatabaseCode = $arr[0]['Confirmation'] ?? '';
            echo '<span class="error_code"></span>';
            if ($DatabaseCode != $Entercode) {
                echo '';
                //echo '<span class="error_code">'.__('This code is not been used for any booking.').'</span>';

                $z = $this->getConfirmationCode();


                foreach ($z as $payment_code) {
                    if ($payment_code[2] == $Entercode) {
                        $result = $this->ReceiptSave($payment_code);
                    }
                }

                if ($result == true) {
                    echo '<script>alert("Your payment code is matched you can book")</script>';
                    echo '<span class="success_code">' . __('Your payment code is matched you can book') . '</span>';
                } else {
                    echo '<script>alert("This code has not find in mail used used for another booking. Please provide another code, or else contact admin")</script>';

                    echo '<span class="error_code">' . __('This code has not find in mail used used for another booking. Please provide another code, or else contact admin') . '</span>';
                }
            }

            if ($DatabaseCode == $Entercode) {
                echo '<script>alert("This code has already been used for another booking. Please provide another code, or else contact admin")</script>';
                echo '<span class="error_code">' . __('This code has already been used for another booking. Please provide another code, or else contact admin') . '</span>';
            }
        } catch (Exception $ex) {
            // jump to this part
            // if an exception occurred
        }
    }

    function checkCode1() {

        try {
            $this->isAjax = true;
            GzObject::loadFiles('Model', array('ConfirmCode'));
            $ConfirmCodeModel = new ConfirmCodeModel();

            $opts = array();
            $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
            $arr = $ConfirmCodeModel->getAll($opts);
            //$step =$this->icase;
            //if($step=="old"){
            $Entercode = $_POST['confirm_code'] ?? '';
            $DatabaseCode = $arr[0]['Confirmation'] ?? '';
            if ($DatabaseCode == $Entercode) {
                //echo '<script>alert("This code has already been used for another booking. Please provide another code, or else contact admin.")</script>';
                echo '<span class="error_code">' . __('This code has already been used for another booking. Please provide another code, or else contact admin') . '</span>';
                //$this->icase = 'new';
                exit;
            } else {

                $z = $this->getConfirmationCode();
                foreach ($z as $payment_code) {
                    if ($payment_code[2] == $Entercode) {
                        $result = $this->ReceiptSave($payment_code);
                    }
                }
                if ($result == true) {

                    //echo '<script>alert("Your payment code is matched you can book.")</script>';
                    echo '<span class="success_code">' . __('Your payment code is matched you can book') . '</span>';
                    // $this->icase = 'new';
                    echo '<script>alert("Your payment code is matched you can book")</script>';
                    //exit(0);
                    exit;
                    if (1 == 1) {
                        exit;
                    }
                    //echo '<script>alert("Your payment code is matched you can book")</script>';
                } else {

                    //echo '<script>alert("Your payment code is matched you can book")</script>';
                    //echo '<script>alert("This code has not find in mail used used for another booking. Please provide another code, or else contact admin.")</script>';
                    echo '<span class="error_code">' . __('This code has not find in mail used used for another booking. Please provide another code, or else contact admin') . '</span>';
                    //$this->i = 'new';
                    exit;
                }
            }
        } catch (Exception $ex) {
            // jump to this part
            // if an exception occurred
        }
    }

    // function checkCode() {
    //     $this->isAjax = true;
    //     GzObject::loadFiles('Model', array('ConfirmCode'));
    //     $ConfirmCodeModel = new ConfirmCodeModel();
    //     $opts = array();
    //     $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
    //     $arr = $ConfirmCodeModel->getAll($opts);
    //     if (!empty($arr[0])) {
    //         echo '<span class="success_code">'.__('success_code').'</span>';
    //     }else{
    //         echo '<span class="error_code">'.__('error_code').'</span>';
    //     }
    // }
}


