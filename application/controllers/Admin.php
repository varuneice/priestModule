<?php

require_once CONTROLLERS_PATH . 'App.php';

class Admin extends App {

    var $layout = 'admin';
    var $option_arr = null;

    private function getAdminSessionTimeoutSeconds(): int {
        return 7200;
    }

    private function setAdminSessionActivity(): void {
        if (!isset($_SESSION['admin_login_time'])) {
            $_SESSION['admin_login_time'] = time();
        }
        $_SESSION['admin_last_activity'] = time();
    }

    private function clearAdminSession(): void {
        unset(
            $_SESSION[$this->default_user],
            $_SESSION['admin_login_time'],
            $_SESSION['admin_last_activity']
        );
    }

    private function isAdminSessionExpired(): bool {
        $lastActivity = (int) ($_SESSION['admin_last_activity'] ?? 0);
        if ($lastActivity <= 0) {
            return false;
        }
        return (time() - $lastActivity) > $this->getAdminSessionTimeoutSeconds();
    }

    function beforeFilter() {
        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();
        $this->option_arr = $OptionModel->getAllPairValues();
        $this->tpl['option_arr'] = $OptionModel->getAllPairs();
        $this->tpl['option_arr_values'] = $this->option_arr;

        $tz = $this->tpl['option_arr_values']['timezone'] ?? '';
        if ($tz) {
            date_default_timezone_set($tz);
        }

        if (!empty($this->tpl['option_arr_values']['date_format'])) {
            $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format']);
        }

        $req_action = $_REQUEST['action'] ?? '';
        if (!$this->isLoged() && $req_action != 'login' && $req_action != 'registration' && $req_action != 'forgot') {

            Util::redirect(INSTALL_URL . "Admin/login");
        }

        if ($this->isLoged()) {
            if ($this->isAdminSessionExpired()) {
                $this->clearAdminSession();
                Util::redirect(INSTALL_URL . "Admin/login");
            }
            $this->setAdminSessionActivity();
        }

        if ($this->isMember() && ($_REQUEST['action'] ?? '') != 'logout') {
            GzObject::loadFiles('Model', array('Member'));
            $MemberModel = new MemberModel();

            $user = $this->getUser();

            $member = $MemberModel->get($user['ID']);

            if (!$member || $member['payment_status'] != 'confirmed' || $member['status'] == 'E') {
                Util::redirect(INSTALL_URL . "Member/pay");
            }

            $this->tpl['member'] = $member;
        }

        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);

        switch (@$_REQUEST['action']) {
            case 'dashboard':
                $this->js[] = array('file' => 'gzadmin/plugins/morris/raphael-min.js', 'path' => JS_PATH);
                $this->js[] = array('file' => 'gzadmin/plugins/morris/morris.min.js', 'path' => JS_PATH);
                break;
        }

        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'login.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzAdmin.js', 'path' => JS_PATH);
    }

    function index() {
        Util::redirect(INSTALL_URL . "Admin/dashboard");
    }
    function login() {

        $this->layout = 'login';

        if (isset($_POST['login_user']) && $_POST['login_user'] == '1') {

            $ip = RateLimit::clientIp();

            $logFile = defined('INSTALL_PATH') ? INSTALL_PATH . 'login_debug.log' : __DIR__ . '/../../login_debug.log';
            $logLine = function($msg) use ($logFile) {
                $line = '[' . date('Y-m-d H:i:s') . '] LOGIN_DEBUG: ' . $msg . PHP_EOL;
                error_log('LOGIN_DEBUG: ' . $msg);
                @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
            };

            $logLine('=== Login attempt start ===');
            $logLine('REMOTE_ADDR=' . ($_SERVER['REMOTE_ADDR'] ?? 'n/a'));
            $logLine('HTTP_X_FORWARDED_FOR=' . ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? 'n/a'));
            $logLine('HTTP_X_REAL_IP=' . ($_SERVER['HTTP_X_REAL_IP'] ?? 'n/a'));
            $logLine('Resolved IP=' . $ip);
            $logLine('Email=' . ($_POST['email'] ?? ''));
            $logLine('INSTALL_URL=' . (defined('INSTALL_URL') ? INSTALL_URL : 'NOT DEFINED'));
            $logLine('session_name=' . session_name() . ' session_id=' . session_id());

            // Block IPs that have exceeded the failure threshold
            // $blocked = RateLimit::isBlocked('login', $ip);
            // $logLine('RateLimit isBlocked=' . ($blocked ? 'YES' : 'no'));
            // if ($blocked) {
            //     $logLine('Redirecting: rate-limited -> Admin/login');
            //     Util::redirect(INSTALL_URL . "Admin/login");
            //     return false;
            // }

            GzObject::loadFiles('Model', array('User', 'Member'));
            $UserModel = new UserModel();
            $MemberModel = new MemberModel();

            $opts = array();
            $opts['email'] = $_POST['email'] ?? '';
            $opts['password'] = md5($_POST['password'] ?? '');
            $opts['status'] = 'T';

            $user = $MemberModel->getAll($opts);

            $logLine('MemberModel->getAll count=' . (is_array($user) ? count($user) : 'false/null'));

            if (is_array($user) && count($user) == 1) {
                $user = $user[0];
                $logLine('Member found: ID=' . ($user['ID'] ?? 'n/a') . ' status=' . ($user['status'] ?? 'n/a'));

                if ($user['status'] != 'T') {
                    $logLine('Redirecting: member status not T -> Admin/login');
                    // RateLimit::record('login', $ip);
                    Util::redirect(INSTALL_URL . "Admin/login");
                }

                $user['is_member'] = '1';

                // RateLimit::clear('login', $ip);
                $_SESSION[$this->default_user] = $user;
                  $url = "Member/edit/". $user['ID'];

                $logLine('Member login success, redirecting -> ' . $url);
                Util::redirect(INSTALL_URL . $url);
            }

            $opts = array();
            $opts['email'] = $_POST['email'] ?? '';
            $opts['password'] = md5($_POST['password'] ?? '');
            $opts['status'] = 'T';

            $user = $UserModel->getAll($opts);

            $logLine('UserModel->getAll count=' . (is_array($user) ? count($user) : 'false/null'));

            if (!is_array($user) || count($user) != 1) {
                $logLine('Redirecting: user not found or multiple results -> Admin/login');
                // RateLimit::record('login', $ip);
                Util::redirect(INSTALL_URL . "Admin/login");
            } else {
                $user = $user[0];
                $logLine('User found: id=' . ($user['id'] ?? 'n/a') . ' type=' . ($user['type'] ?? 'n/a') . ' status=' . ($user['status'] ?? 'n/a'));

                if (!in_array($user['type'], array(1, 2, 3, 5, 6,7,8,9,10,11,12,13,14,16))) {
                    $logLine('Redirecting: user type ' . ($user['type'] ?? 'n/a') . ' not allowed -> Admin/login');
                    // RateLimit::record('login', $ip);
                    Util::redirect(INSTALL_URL . "Admin/login");
                }
                if ($user['status'] != 'T') {
                    $logLine('Redirecting: user status ' . ($user['status'] ?? 'n/a') . ' not T -> Admin/login');
                    // RateLimit::record('login', $ip);
                    Util::redirect(INSTALL_URL . "Admin/login");
                }

                // RateLimit::clear('login', $ip);
                $_SESSION[$this->default_user] = $user;

                $data['id'] = $user['id'];
                $data['last_login'] = date("Y-m-d H:i:s");
                $UserModel->update($data);

                if (in_array($user['type'], array(5, 6))) {
                    $logLine('User login success type=' . $user['type'] . ', redirecting -> Badges/index');
                    Util::redirect(INSTALL_URL . "Badges/index");
                }
                 if (in_array($user['type'], array(7, 8))) {
                    $logLine('User login success type=' . $user['type'] . ', redirecting -> BadgesAssign/index');
                    Util::redirect(INSTALL_URL . "BadgesAssign/index");
                }
                if (in_array($user['type'], array(9, 10))) {
                    $logLine('User login success type=' . $user['type'] . ', redirecting -> Foodcoupon/index');
                    Util::redirect(INSTALL_URL . "Foodcoupon/index");
                }
                 if (in_array($user['type'], array(11))) {
                    $logLine('User login success type=' . $user['type'] . ', redirecting -> Student/index');
                    Util::redirect(INSTALL_URL . "Student/index");
                }
                if (in_array($user['type'], array(12))) {
                    $logLine('User login success type=' . $user['type'] . ', redirecting -> Member/index');
                    Util::redirect(INSTALL_URL . "Member/index");
                }
                if (in_array($user['type'], array(13))) {
                    $logLine('User login success type=' . $user['type'] . ', redirecting -> RentalBooking/index');
                    Util::redirect(INSTALL_URL . "RentalBooking/index");
                }

                if (in_array($user['type'], array(14))) {
                    $logLine('User login success type=' . $user['type'] . ', redirecting -> Eventadmin/index');
                    Util::redirect(INSTALL_URL . "Eventadmin/index");
                }
                if (in_array($user['type'], array(16))) {
                    $logLine('User login success type=' . $user['type'] . ', redirecting -> vendordata/index');
                    Util::redirect(INSTALL_URL . "vendordata/index");
                }

                $logLine('User login success type=' . $user['type'] . ', redirecting -> Admin/dashboard');
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            }

            return false;
        }
    }

    function loginOld() {

        $this->layout = 'login';

        if (isset($_POST['login_user']) && $_POST['login_user'] == '1') {

            GzObject::loadFiles('Model', array('User', 'Member'));
            $UserModel = new UserModel();
            $MemberModel = new MemberModel();

            $opts = array();
            $opts['email'] = $_POST['email'] ?? '';
            $opts['password'] = md5($_POST['password'] ?? '');
            $opts['status'] = 'T';

            $user = $MemberModel->getAll($opts);

            if (is_array($user) && count($user) == 1) {
                $user = $user[0];

                if ($user['status'] != 'T') {
                    # Login forbidden
                    Util::redirect(INSTALL_URL . "Admin/login");
                }

                $user['is_member'] = '1';

                $_SESSION[$this->default_user] = $user;
                  $url = "Member/edit/". $user['ID'];

               
                Util::redirect(INSTALL_URL . $url);
                //Util::redirect(INSTALL_URL . "Admin/dashboard");
               // Util::redirect(INSTALL_URL . "Admin/dashboard");
            }

            $opts = array();
            $opts['email'] = $_POST['email'] ?? '';
            $opts['password'] = md5($_POST['password'] ?? '');
            $opts['status'] = 'T';

            $user = $UserModel->getAll($opts);

            if (!is_array($user) || count($user) != 1) {
                # Login failed
                Util::redirect(INSTALL_URL . "Admin/login");
            } else {
                $user = $user[0];

                if (!in_array($user['type'], array(1, 2, 3))) {
                    # Login denied
                    Util::redirect(INSTALL_URL . "Admin/login");
                }
                if ($user['status'] != 'T') {
                    # Login forbidden
                    Util::redirect(INSTALL_URL . "Admin/login");
                }

                $_SESSION[$this->default_user] = $user;

                $data['id'] = $user['id'];
                $data['last_login'] = date("Y-m-d H:i:s");
                $UserModel->update($data);

                Util::redirect(INSTALL_URL . "Admin/dashboard");
            }

            return false;
        }
    }
    function dashboard() {
        GzObject::loadFiles('Model', array('Booking', 'Calendar', 'User', 'MemberLog','Donation','Donationnewview','RevenuChart','Member','piechartdata'));
        $BookingModel = new BookingModel();
        $CalendarModel = new CalendarModel();
        $UserModel = new UserModel();
        $MemberLogModel = new MemberLogModel();
        $DonationModel = new DonationModel();
        $DonationnewviewModel = new DonationnewviewModel();
        $RevenuChartModel = new RevenuChartModel();
        $piechartdataModel= new piechartdataModel();
        $MemberModel = new MemberModel();
        $opts = array();

        if ($this->isMember()) {
            $opts = array();
            $opts['user_id'] = $this->getMemberId();
        }
        $arr = $BookingModel->getAll($opts, 'id desc', '7');

        $this->tpl['arr'] = $arr;
        $this->tpl['chart'] = array();

        $where = '';

        if ($this->isMember()) {
            $opts = array();
            $opts['user_id'] = $this->getMemberId();
            $bookings = $BookingModel->getAll($opts);

            $booking_id = array();
            foreach ($bookings as $key => $value) {
                $booking_id[$value['id']] = $value['id'];
            }

            $where = "AND id IN ('" . implode("','", $booking_id) . "') ";
        }

        for ($i = (date('n') - 11); $i <= date('n'); $i++) {

            $from_timestamp = mktime(0, 0, 0, $i, 1, date('Y'));
            $to_timestamp = mktime(0, 0, 0, $i + 1, 0, date('Y'));

            $sql = "SELECT count(id) as count FROM " . $BookingModel->getTable() . " WHERE (year(finalDate) = year(curdate())) and date BETWEEN " . $from_timestamp . "  AND " . $to_timestamp . " $where ";

            $arr = $BookingModel->execute($sql);

            $this->tpl['chart']['booking'][date('M', mktime(0, 0, 0, $i, 1, date('Y')))] = $arr[0] ?? null;
        }
        //$sql = "SELECT  year(finalDate) ,month(finalDate) ,SUM(total)   as count   FROM " . $BookingModel->getTable()  ." group by year(finalDate),month(finalDate) order by year(created),month(finalDate) ";
        $sql = "SELECT  year(finalDate) as yr,month(finalDate) as mon ,SUM(total)   as count   FROM " . $BookingModel->getTable() . " where (year(finalDate) = year(curdate()))  group by year(finalDate),month(finalDate) order by year(finalDate),month(finalDate) ";
        //$sql = "SELECT  SUM(total)   as count   FROM " . $BookingModel->getTable() . "  group by " .  year($from_timestamp) . "  , " . month($to_timestamp). "  order by " .  year($from_timestamp) . "  , " . month($to_timestamp)  ";
        //$sql = "SELECT  year(date) as yr,month(date) as mon ,SUM(total)   as count   FROM " . $BookingModel->getTable()  ." group by year(date),month(date) order by year(date),month(date) ";
        $arr = $BookingModel->execute($sql);
        $arrLength = count($arr);
        for ($i = 0; $i < $arrLength; $i++) {

            $this->tpl['chartRevenu']['booking'][date('M', mktime(0, 0, 0, $arr[$i]['mon'], 1, date('Y')))] = $arr[$i];
        }

        $sql = "SELECT count(id) as today_reservation FROM " . $BookingModel->getTable() . " WHERE date = '" . strtotime(date("Y-m-d")) . "' $where";
        $arr = $BookingModel->execute($sql);
        $this->tpl['today_reservation'] = $arr[0] ?? null;

        $arr = array();
        $sql = "SELECT count(id) as bookings_this_week FROM " . $BookingModel->getTable() . " WHERE date BETWEEN '" . strtotime('last Monday', time()) . "' AND '" . ( strtotime('next Sunday', time()) + 86400 ) . "' $where";
        $arr = $BookingModel->execute($sql);
        $this->tpl['bookings_this_week'] = $arr[0] ?? null;


        //$this->tpl['users'] = $UserModel->getAll();
       
        $Miscarr= $DonationnewviewModel->donationgiftmiscytd();
        $this->tpl['misc'] =$Miscarr;


        $arr = array();

          $sql = "SELECT SUM(total) as revenue  FROM " . $BookingModel->getTable($opts) . " WHERE  DATE_FORMAT(finalDate,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-01-01'),'%y-%m-%d')";
        $arr = $BookingModel->execute($sql);

        $this->tpl['revenue'] = $arr[0]['revenue'] ?? null;
        
        //Donation
       $sql = "SELECT SUM(Amount) as donation  FROM " . $DonationModel->getTable($opts) . " WHERE  (payment_status = 'APPROVED' OR payment_status = 'succeeded') AND pay_type='DONATION' AND pay_for like '%DONATION%' AND DATE_FORMAT(pay_date,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-01-01'),'%y-%m-%d')";
       $arr = $DonationModel->execute($sql);
       $this->tpl['donation'] = round($arr[0]['donation'] ?? 0);

        //MemberRenew
        $sql = "SELECT SUM(Amount) as renew  FROM " . $DonationModel->getTable($opts) . " WHERE  (payment_status = 'APPROVED' OR payment_status = 'succeeded') AND pay_for='DB / HDBS Annual General Membership (GM)' AND DATE_FORMAT(pay_date,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-01-01'),'%y-%m-%d')";
        $arrrenew = $DonationModel->execute($sql);
        $this->tpl['renew'] = round($arrrenew[0]['renew'] ?? 0);

        //MemberMaintennace
        $sql = "SELECT SUM(Amount) as maintenence  FROM " . $DonationModel->getTable($opts) . " WHERE  (payment_status = 'APPROVED' OR payment_status = 'succeeded') AND pay_for='DB / HDBS Annual Maintenance' AND DATE_FORMAT(pay_date,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-01-01'),'%y-%m-%d')";
        $arrmaintenence = $DonationModel->execute($sql);
        $this->tpl['maintenence'] = round($arrmaintenence[0]['maintenence'] ?? 0);

        //Student
        $sql = "SELECT SUM(Amount) as student  FROM " . $DonationModel->getTable($opts) . " WHERE  (payment_status = 'APPROVED' OR payment_status = 'succeeded') AND (pay_for='BS School' or  pay_for='KB School' or  pay_for='Workshops'or  pay_for='Library') AND DATE_FORMAT(pay_date,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-01-01'),'%y-%m-%d')";
        $arrstudent = $DonationModel->execute($sql);
        $this->tpl['student'] = round($arrstudent[0]['student'] ?? 0);
        
           //New Member Count
         //$sql = "SELECT count(ID) as newMemberCount  FROM " . $MemberModel->getTable($opts) . " WHERE   (Category='GM' or Category='LM') AND DATE_FORMAT(CreatedOn,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-01-01'),'%y-%m-%d')";
        // $arrnewMemberCount = $MemberModel->execute($sql);
         //$this->tpl['newMemberCount'] = round($arrnewMemberCount[0]['newMemberCount']);
         $arr = $MemberModel->getNewMemberWithPayment($opts);
        $this->tpl['newMemberCount'] = $arr[0]['newMemberCount'] ?? 0;
         
         
         //Event
        $sql = "SELECT SUM(Amount) as event  FROM " . $DonationModel->getTable($opts) . " WHERE  (payment_status = 'APPROVED' OR payment_status = 'succeeded') AND pay_for like'%event%' AND DATE_FORMAT(pay_date,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-01-01'),'%y-%m-%d')";
        $arrevent = $DonationModel->execute($sql);
        $this->tpl['event'] = round($arrevent[0]['event'] ?? 0);
          //Ticket
          $sql = "SELECT SUM(Amount) as ticket  FROM " . $DonationModel->getTable($opts) . " WHERE  (payment_status = 'APPROVED' OR payment_status = 'succeeded') AND pay_for like'%ticket%' AND DATE_FORMAT(pay_date,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-01-01'),'%y-%m-%d')";
          $arrticket = $DonationModel->execute($sql);
          $this->tpl['ticket'] = round($arrticket[0]['ticket'] ?? 0);

          //Rental
          $sql = "SELECT SUM(Amount) as rental  FROM " . $DonationModel->getTable($opts) . " WHERE  (payment_status = 'APPROVED' OR payment_status = 'succeeded') AND pay_type ='Rental' AND DATE_FORMAT(pay_date,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-01-01'),'%y-%m-%d')";
          $arrrental = $DonationModel->execute($sql);
          $this->tpl['rental'] = round($arrrental[0]['rental'] ?? 0);

        $opts = array();
        
         //3D Chart
         $Eventarr = $piechartdataModel->TicketEventsData($opts);
         $this->tpl['Eventarr'] = $Eventarr;

         //3D Chart
         $MemberTypearr = $DonationnewviewModel->MemberData($opts);
         $this->tpl['MemberTypearr'] = $MemberTypearr;
         
         $arr = $RevenuChartModel->Chart();
         $this->tpl['chartevent']=$arr;
         $opts = array();
        

      

        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        $this->tpl['calendars'] = $CalendarModel->getAll($opts);

        $opts = array();
        $this->tpl['log_arr'] = $MemberLogModel->getAllWithMember($opts);
    }

    function dashboardBackup() {
        GzObject::loadFiles('Model', array('Booking', 'Calendar', 'User', 'MemberLog'));
        $BookingModel = new BookingModel();
        $CalendarModel = new CalendarModel();
        $UserModel = new UserModel();
        $MemberLogModel = new MemberLogModel();

        $opts = array();

        if ($this->isMember()) {
            $opts = array();
            $opts['user_id'] = $this->getMemberId();
        }
        $arr = $BookingModel->getAll($opts, 'id desc', '7');

        $this->tpl['arr'] = $arr;
        $this->tpl['chart'] = array();

        $where = '';

        if ($this->isMember()) {
            $opts = array();
            $opts['user_id'] = $this->getMemberId();
            $bookings = $BookingModel->getAll($opts);

            $booking_id = array();
            foreach ($bookings as $key => $value) {
                $booking_id[$value['id']] = $value['id'];
            }

            $where = "AND id IN ('" . implode("','", $booking_id) . "') ";
        }

        for ($i = (date('n') - 11); $i <= date('n'); $i++) {

            $from_timestamp = mktime(0, 0, 0, $i, 1, date('Y'));
            $to_timestamp = mktime(0, 0, 0, $i + 1, 0, date('Y'));

            $sql = "SELECT count(id) as count FROM " . $BookingModel->getTable() . " WHERE date BETWEEN " . $from_timestamp . "  AND " . $to_timestamp . " $where ";

            $arr = $BookingModel->execute($sql);

            $this->tpl['chart']['booking'][date('M', mktime(0, 0, 0, $i, 1, date('Y')))] = $arr[0] ?? null;
        }
        //$sql = "SELECT  year(finalDate) ,month(finalDate) ,SUM(total)   as count   FROM " . $BookingModel->getTable()  ." group by year(finalDate),month(finalDate) order by year(created),month(finalDate) ";
       // $sql = "SELECT  year(finalDate) as yr,month(finalDate) as mon ,SUM(total)   as count   FROM " . $BookingModel->getTable() . " group by year(finalDate),month(finalDate) order by year(finalDate),month(finalDate) ";
        $sql = "SELECT  year(finalDate) as yr,month(finalDate) as mon ,SUM(total)   as count   FROM " . $BookingModel->getTable() . " WHERE  DATE_FORMAT(finalDate,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-01-01'),'%y-%m-%d') group by year(finalDate),month(finalDate) order by year(finalDate),month(finalDate) ";
       
        //$sql = "SELECT  SUM(total)   as count   FROM " . $BookingModel->getTable() . "  group by " .  year($from_timestamp) . "  , " . month($to_timestamp). "  order by " .  year($from_timestamp) . "  , " . month($to_timestamp)  ";
        //$sql = "SELECT  year(date) as yr,month(date) as mon ,SUM(total)   as count   FROM " . $BookingModel->getTable()  ." group by year(date),month(date) order by year(date),month(date) ";
        $arr = $BookingModel->execute($sql);
        $arrLength = count($arr);
        for ($i = 0; $i < $arrLength; $i++) {

            $this->tpl['chartRevenu']['booking'][date('M', mktime(0, 0, 0, $arr[$i]['mon'], 1, date('Y')))] = $arr[$i];
        }

        $sql = "SELECT count(id) as today_reservation FROM " . $BookingModel->getTable() . " WHERE date = '" . strtotime(date("Y-m-d")) . "' $where";
        $arr = $BookingModel->execute($sql);
        $this->tpl['today_reservation'] = $arr[0] ?? null;

        $arr = array();
        $sql = "SELECT count(id) as bookings_this_week FROM " . $BookingModel->getTable() . " WHERE date BETWEEN '" . strtotime('last Monday', time()) . "' AND '" . ( strtotime('next Sunday', time()) + 86400 ) . "' $where";
        $arr = $BookingModel->execute($sql);
        $this->tpl['bookings_this_week'] = $arr[0] ?? null;


        $this->tpl['users'] = $UserModel->getAll();

        $arr = array();

        //$sql = "SELECT SUM(total) as revenue  FROM " . $BookingModel->getTable($opts) . " ";
         //$sql = "SELECT SUM(total) as revenue  FROM " . $BookingModel->getTable($opts) . " WHERE  YEAR(finalDate) = YEAR(CURRENT_DATE()) ";
        //$sql = "SELECT SUM(total) as revenue  FROM " . $BookingModel->getTable($opts) . " WHERE  finalDate >=CONCAT(Year(CURRENT_DATE), '-07-01') ";
        // $sql = "SELECT SUM(total) as revenue  FROM " . $BookingModel->getTable($opts) . " WHERE  DATE_FORMAT(finalDate,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-07-01'),'%y-%m-%d')";
         
         $sql = "SELECT SUM(total) as revenue  FROM " . $BookingModel->getTable($opts) . " WHERE  DATE_FORMAT(finalDate,'%y-%m-%d') >= DATE_FORMAT(CONCAT(Year(CURRENT_DATE), '-01-01'),'%y-%m-%d')";
         
        $arr = $BookingModel->execute($sql);

        $this->tpl['revenue'] = round($arr[0]['revenue'] ?? 0);

        $opts = array();

        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        $this->tpl['calendars'] = $CalendarModel->getAll($opts);

        $opts = array();
        $this->tpl['log_arr'] = $MemberLogModel->getAllWithMember($opts);
    }

    function array_value_recursive($key, array $arr) {
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val) {
            if ($k == $key)
                array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }

    function logout() {
        if ($this->isLoged()) {
            $this->clearAdminSession();
            Util::redirect(INSTALL_URL . "Admin/login");
        } else {
            Util::redirect(INSTALL_URL . "Admin/login");
        }
    }

    function getMultyCalendarCSS() {
        $this->layout = 'empty';
        $this->replaceMultyCalendarCSS();
    }

    function update_db() {
        $this->layout = 'install';

        GzObject::loadFiles('Model', array('App'));
        $AppModel = new AppModel();

        $string = file_get_contents('application/config/update_db_10.sql');
        preg_match_all('/DROP\s+TABLE(\s+IF\s+EXISTS)?\s+`(\w+)`/i', $string, $match);

        if (count($match[0]) > 0) {
            $arr = array();
            foreach ($match[2] as $k => $table) {

                $sql = "SHOW TABLES FROM `" . $AppModel->database . "` LIKE '" . $AppModel->prefix . $table . "'";

                $arr = $AppModel->execute($sql);

                if (!empty($arr)) {
                    $_SESSION['message'] = "Database already has an updated";
                }
            }
        }

        if (!empty($_POST['update_db'])) {
            $file = 'application/config/update_db_10.sql';

            $prefix = $AppModel->prefix;

            $string = file_get_contents($file);
            $string = preg_replace(
                    array('/INSERT\s+INTO\s+`/', '/DROP\s+TABLE\s+IF\s+EXISTS\s+`/', '/CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS\s+`/', '/DROP\s+TABLE\s+`/', '/CREATE\s+TABLE\s+`/'), array('INSERT INTO `' . $prefix, 'DROP TABLE IF EXISTS `' . $prefix, 'CREATE TABLE IF NOT EXISTS `' . $prefix, 'DROP TABLE `' . $prefix, 'CREATE TABLE `' . $prefix), $string);

            $arr = preg_split('/;(\s+)?\n/', $string);
            foreach ($arr as $v) {
                $v = trim($v);
                if (!empty($v)) {
                    $AppModel->execute($v);
                }
            }

            $_SESSION['status'] = "Database has been updated";
        }
    }

    function registration() {
        $this->layout = 'login';
        if (!empty($_POST['submit']) && $_POST['submit'] == 1) {
            GzObject::loadFiles('Model', 'User');
            $UserModel = new UserModel();
            $data['password'] = md5($_POST['password'] ?? '');
            // $data['email'] = $_POST['email'] ?? '';
            // $data['first'] = $_POST['first'] ?? '';
            // $data['last'] = $_POST['last'] ?? '';
            $data['type'] = 2;
            $data['status'] = 'T';
            $id = $UserModel->save(array_merge($_POST, $data));
            if (!empty($id)) {

                $_SESSION['status'] = 16;
                Util::redirect(INSTALL_URL . "Admin/login");
            } else {
                $_SESSION['status'] = 17;
            }
        }
    }

    function export() {
        $this->isAjax = true;

        $time = time();
        $file = 'db-backup-' . $time . '.sql';
        $backup_path = INSTALL_PATH . 'application/web/upload/backup/' . $file;

        exec('mysqldump --user=' . DEFAULT_USER . ' --password=' . DEFAULT_PASS . ' --host=' . DEFAULT_HOST . ' ' . DEFAULT_DB . ' > ' . $backup_path);
    }

    function forgot() {
        $this->layout = 'login';

        if (!empty($_REQUEST['forgo_password'])) {
            GzObject::loadFiles('Model', 'User');
            $UserModel = new UserModel();

            $opts = array();
            $opts['email'] = $_REQUEST['email'];

            $arr = $UserModel->getAll($opts);

            if (!empty($arr[0]['email'])) {

                $new_pass = Util::random_password();

                $data['password'] = md5($new_pass);
                $data['id'] = $arr[0]['id'];
                $UserModel->update($data);

                $members_details = $arr[0];

                $type = 'forgot';
                $group = 'members';
                $pass = $new_pass;
                $this->sendEmailsConfirm($members_details, $type, $group, $pass);

                $_SESSION['status'] = 35;
            } else {
                GzObject::loadFiles('Model', array('Member'));
                $MemberModel = new MemberModel();

                $opts = array();
                $opts['email'] = $_REQUEST['email'];

                $arr = $MemberModel->getAll($opts);

                if (!empty($arr[0]['email'])) {

                    $new_pass = Util::random_password();
                    echo htmlspecialchars($new_pass, ENT_QUOTES, 'UTF-8');

                    $data['password'] = md5($new_pass);
                    $data['ID'] = $arr[0]['ID'];
                    $MemberModel->update($data);

                    $members_details = array();

                    $members_details['email'] = $arr[0]['email'];
                    $members_details['last'] = $arr[0]['Sp_FName'];
                    $members_details['first'] = $arr[0]['F_Name'];

                    $type = 'forgot';
                    $group = 'members';
                    $pass = $new_pass;
                    $this->sendEmailsConfirm($members_details, $type, $group, $pass);

                    $_SESSION['status'] = 35;
                } else {
                    $_SESSION['err'] = 12;
                }
            }
        }
    }

}
