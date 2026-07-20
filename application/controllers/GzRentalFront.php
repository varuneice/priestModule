<?php

set_time_limit(0);
require_once CONTROLLERS_PATH . 'AppRental.php';
require __DIR__ . '/Twillio/vendor/autoload.php';

use Twilio\Rest\Client;

//use \vendor\twilio\sdk\src\Twilio\Rest\Client;

class GzRentalFront extends AppRental {

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

        GzObject::loadFiles('Model', array('Calendar','Member', 'Option','Category', 'Items','rentaladvancepayment','ltdytdmember'));
        $CalendarModel = new CalendarModel();
        $OptionModel = new OptionModel();
        $CategoryModel = new CategoryModel();
        $rentaladvancepaymentModel = new rentaladvancepaymentModel();
        $ItemsModel = new ItemsModel();
        if (!empty($_GET['cid'] ?? [])) {
            $opts = array();
            $opts['calendar_id'] = $_GET['cid'] ?? [];

            $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues($opts);
            $arr1= $CategoryModel->getcategory();
            $arr= $ItemsModel->getitems();
            $arr2= $rentaladvancepaymentModel->getamountadvance();
            $this->tpl['category'] =  $arr1;
            $this->tpl['items'] =  $arr;
            $this->tpl['advanceamount'] =  $arr2;
            $MemberModel = new MemberModel();
            $ltdytdmemberModel = new ltdytdmemberModel();
            //$this->tpl['members'] = $ltdytdmemberModel->GetMemberByName();
            $this->tpl['members'] = $MemberModel->getAll();
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
        // foreach ($_GET['cid'] ?? [] as $cid) {
        //     $this->css[] = array('file' => 'index.php?controller=GzFront&action=GzABCCss&cid=' . $cid, 'path' => '');
        // }
        foreach ($_GET['cid'] ?? [] as $cid) {
            $this->css[] = array('file' => 'index.php?controller=GzRentalFront&action=GzABCCss&cid=' . $cid, 'path' => '');
        }
             
        $this->js[] = array('file' => 'jquery-2.0.2.min.js', 'path' => LIBS_PATH);
          $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery.colorbox-min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/lada/spin.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/lada/ladda.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/tooltipster/js/jquery.tooltipster.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        $this->js[] = array('file' => 'otp-member-verify.js?v=' . time(), 'path' => JS_PATH);
        // $this->js[] = array('file' => 'load.js', 'path' => JS_PATH);
        // $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
        // $this->js[] = array('file' => 'options.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadRental.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'options.js', 'path' => JS_PATH);
        // For search dropdown search box 
       
        
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
    }

    function addTimeSlot() {
        $this->isAjax = true;

        $cid = $_REQUEST['cid'] ?? '';
        $slot = $_POST['slot'] ?? '';

        GzObject::loadFiles('Model', array('CustomDate'));
        $CustomDateModel = new CustomDateModel();

        $opts = array();
        $opts[':timestamp BETWEEN timestamp AND timestamp_end AND calendar_id = :calendar_id'] = array(':timestamp' => ($_POST['date'] ?? ''), ':calendar_id' => $cid);
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            $_SESSION[$this->default_product]['event'][$cid][$slot] = $_POST['count'] ?? '';

            unset($_SESSION[$this->default_product]['normal']);

            $_SESSION[$this->default_product]['slots'] = $_SESSION[$this->default_product]['event'];
        } else {
            $_SESSION[$this->default_product]['normal'][$cid][$slot] = $_POST['count'] ?? '';

            unset($_SESSION[$this->default_product]['event']);

            $_SESSION[$this->default_product]['slots'] = $_SESSION[$this->default_product]['normal'];
        }
    }

    function load() {
        $this->layout = 'empty';
    }
    
    // 21-apr-2025 , get location for making dropdown value red 
    function GetLocationByDate(){
        GzObject::loadFiles('Model', array('TimePrice', 'RentalBookingSlot', 'CustomPrice', 'CustomDate', 'Booking'));
        $RentalBookingSlotModel = new RentalBookingSlotModel();
        $opts = array();
        // $date =$_POST['bookdate'];
        $date = isset($_GET['date']) ? trim($_GET['date']) : null;
        $location = $RentalBookingSlotModel->getLocationRentalBooking($date);
       
        echo json_encode(['location' => $location,]);


    }

    function getTimeSlot() {
        $this->isAjax = true;

        $date = (int)($_POST['date'] ?? 0);
        $calId = (int)($_POST['cal_id'] ?? 0);

        GzObject::loadFiles('Model', array('TimePrice', 'RentalBookingSlot', 'CustomPrice', 'CustomDate', 'Booking'));
        $TimePriceModel = new TimePriceModel();
        $RentalBookingSlotModel = new RentalBookingSlotModel();
        $CustomPriceModel = new CustomPriceModel();
        $CustomDateModel = new CustomDateModel();
        $BookingModel = new BookingModel();

        $opts = array();
        $opts[':timestamp BETWEEN timestamp AND timestamp_end AND calendar_id = :calendar_id'] = array(':timestamp' => $date, ':calendar_id' => $calId);
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates[0])) {
            $this->tpl['custom_dates'] = $custom_dates[0];
        }

        $opts = array();
        $opts['calendar_id'] = $calId;
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }

        /*
          $opts = array();
          $opts['calendar_id = :cal_id'] = array(':cal_id' => ($_POST['cal_id'] ?? ''));
          $opts['timestamp BETWEEN :from AND :to'] = array(':from' => ($_POST['date'] - 86400), ':to' => ($_POST['date'] + 86400));
          $booked_slots = $BookingSlotModel->getAll($opts, 'id'); */

        $from = $date - 86400;
        $to = $date + 86400;

        $before = time() - 5 * 60;

        $sql = "SELECT * FROM " . $RentalBookingSlotModel->getTable() . " as t1 LEFT JOIN  " . $BookingModel->getTable() . " as t2 ON t1.booking_id = t2.id WHERE (t2.status = 'confirmed' OR (t2.status = 'pending' AND t2.created >= " . $before . " )) AND t1.timestamp BETWEEN " . $from . "  AND " . $to . " AND t1.calendar_id = " . $calId . " ";
        $booked_slots = $RentalBookingSlotModel->execute($sql);

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

    function index() {
        header("content-type: application/javascript");

        require APP_PATH . 'helpers/ABCalendar/RentalABCalendar.php';

        $d = date('j');
        $m = date('n');
        $y = date('Y');

        $this->tpl['abcalendar'] = array();

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();

        foreach ($_GET['cid'] ?? [] as $cid) {
            $opts = array();
            $opts['calendar_id'] = $cid;
            $this->tpl['option_arr_values'][$cid] = $OptionModel->getAllPairValues($opts);

            $this->tpl['abcalendar'][$cid] = new RentalABCalendar($m, $d, $y, $cid, $_GET['view_month'] ?? 1, $this->tpl['option_arr_values'][$cid], $this->tpl['select_language']);
        }
    }

    function calendars() {
        $this->isAjax = true;

        require APP_PATH . 'helpers/ABCalendar/RentalABCalendar.php';

        $d = date('j');
        $m = date('n');
        $y = date('Y');

        $this->tpl['abcalendar'] = array();

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();

        foreach ($_GET['cid'] ?? [] as $cid) {
            $opts = array();
            $opts['calendar_id'] = $cid;
            $this->tpl['option_arr_values'][$cid] = $OptionModel->getAllPairValues($opts);
            $this->tpl['abcalendar'][$cid] = new RentalABCalendar($m, $d, $y, $cid, $_GET['view_month'] ?? 1, $this->tpl['option_arr_values'][$cid], $this->tpl['select_language']);
        }
    }
    

    function booking_details()
    {
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
        //$this->tpl['prices'] = $this->calclateBookingPrice($_POST);

        if (!(@$this->tpl['option_arr_values']['show_captcha'] != 3 || (!empty($_SESSION[$this->default_product][$this->default_captcha]) && (strtoupper(@$_POST['captcha']) == $_SESSION[$this->default_product][$this->default_captcha])))) {

            $_SESSION['err']['captcha'] = __('wrong ceptcha');
        }
    }
    
      function checkout() {
        $this->isAjax = true;
       
        if (!empty($_POST['create_booking'])) {
            //$oid= $_POST['oid'] ?? '';
            $cid = $_REQUEST['cid'] ?? '';
            $check = $this->checkAvailability($cid);

            if ($check == true) {

                GzObject::loadFiles('Model', 'Option');
                $OptionModel = new OptionModel();

                $opts = array();
                $opts['calendar_id'] = $_GET['cid'] ?? [];
                $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues($opts);

                GzObject::loadFiles('Model', array('RentalBooking', 'RentalBookingSlot', 'ConfirmCode', 'RentalReservationsHistory','Member', 'idnumbers', 'Donation'));
                $RentalBookingModel = new RentalBookingModel();
                $RentalBookingSlotModel = new RentalBookingSlotModel();
                $ConfirmCodeModel = new ConfirmCodeModel();
                $RentalReservationsHistoryModel = new RentalReservationsHistoryModel();
                $MemberModel = new MemberModel();
                $idnumbersModel = new idnumbersModel();
                 $DonationModel = new DonationModel();
                
                // for generate oid 
                    $maxoid = $idnumbersModel->getMaxoid() + 1;
                    $update_oid = $idnumbersModel->Updateoid($maxoid);
                    $_POST['oid'] = $maxoid;
              // end generate oid for
              
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
                
                $data = array();
                $data['status'] = "pending";
                $data['Member_id'] = $_POST['Member_id'] ?? '';
                //$prices = $this->calclateBookingPrice($_POST);
                $calPrice = $_POST['advanceamount'] ?? '';
                $price=explode(" ",$calPrice);
                $data['total'] = $price[1] ?? 0;
                $amount = $price[1] ?? 0;
                $_POST['advanceamount'] = $amount;
                $data['currency'] = $this->tpl['option_arr_values']['currency'];
                //$data['booking_number'] = Util::incrementalHash(10);
                $date = date('Y');
                $BookingNo = $RentalBookingModel->getMax();
                $bno =  substr($BookingNo,4);
                $bnonumeric = intval($bno);
               // if($bno==false){
                //     $data['booking_number'] = $date."001";
                // }
                // else{ }
                $bookingnumber = $bnonumeric +1 ;
                $data['booking_number'] = $date."0".$bookingnumber;
                $FinalBookingNo = $data['booking_number'];
                $getdate = $_POST['Startdate'] ?? '';
                $newDate = strtotime($getdate);
                $data['date'] = $newDate;
                $time = time();
                $data['created'] = $time;
                $finalDate = date("Y-m-d", $time);
                $data['finalDate'] = $getdate;
                $data['calendar_id'] = $_GET['cid'] ?? [];
                $data['enddate'] = date('Y-m-d', $newDate ?: time());
                $id = $RentalBookingModel->save(array_merge($_POST, $data));
                 //$RentalReservationsHistoryModel->save(array_merge($_POST, $data));
                if (!empty($id)) {

                    //foreach ($_SESSION[$this->default_product]['slots'][$_REQUEST['cid'] ?? []] as $i => $count) {
                        $data = array();
                        $data['calendar_id'] = $_GET['cid'] ?? [];
                        $data['booking_id'] = $id;
                        $data['timestamp'] = $newDate;
                       
                        $currentDate = date("Y-m-d", $newDate);
                        $data['count'] = 1;
                        $data['timecreated'] = time();
                        $data['StartTime'] = $_POST['hidestarttime'] ?? '';
                        $data['EndTime'] = $_POST['hideendtime'] ?? '';
                        $data['Hours'] = $_POST['Hours'] ?? '';
                        $starttime = $data['StartTime'];
                        $endtime = $data['EndTime'];
                        $hours = $data['Hours'];
                          $stime = $starttime;
                        $etime = $endtime;
                        $h = $hours;
                        $current=$data['timecreated'];
                        $bookingdate=$data['timestamp'];
                        $RentalBookingSlotModel->save($data);   
                        $bookdate = date("Y-m-d", $bookingdate);
                    //}
                    
                   $invoiceid = $RentalBookingModel->saveInvoice($id);
                    unset($_SESSION[$this->default_product]);

                    $_SESSION[$this->default_product] = array();

                    if (($_POST['payment_method'] ?? '') == 'others') {
                        $opts = array();
                        $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                        $arr = $ConfirmCodeModel->getAll($opts);
                        $oid = $_POST['oid'] ?? '';
                        $cmCode=$_POST['zellecode'] ?? '';
                         $ConfirmCodeModel->UpdateCode($cmCode);
                            if ($oid !=null) {
                            $opts = array();
                            $opts['id'] = $id;
                            $opts['transaction_id']=$cmCode;
                            //$opts['status'] = 'confirmed';
                                $opts['status'] = 'pending';
                                $arr = $RentalBookingModel->get($id);
                                $pujaType =$arr['promo_code'];
                                $prevlocation = $arr['location'];
                                if($prevlocation == 'Both'){
                                    $location = 'Auditorium & Kalabhavan';
                              }else{
                                $location = $arr['location'];
                              }
                               //$location = $arr['location'];
                                $mobileno =$arr['phone'];
                                $email = $arr['email'];
                                $address_1 =$arr['address_1'];
                                $payment_method =$arr['payment_method'];
                                $memberid = $_POST['Member_id'] ?? '';
                                $Bookinno =$arr['booking_number'];
                                 $Date=date("F j, Y",$newDate);
                                $BookingTime =$data['timestamp'];
                                $starttimefinal = $data['StartTime'];
                                $endtimefinal = $data['EndTime'];
                                $timestamp = strtotime($getdate);
                                $finaluidate = date("m/d/Y", $timestamp);
                                echo "<div style='margin-left:110px;' class = 'pay'>
                                <table border='4' width='585px'>
                                <tr>
                                <td colspan='2'> <img src='" . INSTALL_URL . "thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                                <tr>
                                <td>Booking Number</td> <td>" .$Bookinno. "</td> </tr>
                                <td>Order ID</td> <td>" .$_POST['oid']. "</td> </tr>
                                <tr><td>Member Id</td> <td>" .$memberid. "</td> </tr>
                                <tr><td>Customer Name</td> <td>" .$arr['first_name'].' ' .$arr['second_name']. "</td> </tr>
                                <tr><td>Customer Email Address</td> <td>" .$arr['email'].   "</td> </tr>
                                <tr><td>Customer Phone Number</td> <td>" .$mobileno. "</td>  </tr>
                                <tr><td>Location</td> <td>" .$location. "</td>  </tr>
                                <tr><td>Security Deposit</td> <td><span style='color:red;'>$</span>" . ($price[1] ?? 0). "</td>  </tr>
                                <tr><td>Address</td> <td>" .$address_1. "</td>  </tr>
                                <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                                 <tr><td>Rental Date</td> <td>"  .$finaluidate.  "</td>  </tr>
                                <tr><td>Start Time</td> <td>" .$starttimefinal. "</td>  </tr>
                                <tr><td>End Time</td> <td>" .$endtimefinal. "</td>  </tr>
                                <tr><td>Hours</td> <td>" .$data['Hours']. ' '. 'Hours'."</td>  </tr>
                                <tr><td>Status</td> <td>" .'pending'. "</td>
                                </tr>"  ;
                             $RentalBookingModel->update($opts);
                            //$RentalReservationsHistoryModel->update($opts);
                            date_default_timezone_set("America/Chicago");
                            $today = date("Y/m/d");
                                        // save data in donations start
                                        $value = array();
                                        $value['oid'] = $_POST['oid'] ?? '';
                                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                                        $value['MemberName'] = $_POST['first_name'] . ' ' . ($_POST['second_name'] ?? '');
                                        $value['Amount'] = $_POST['advanceamount'] ?? '';
                                        $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                                        $value['payment_status'] = 'succeeded';
                                        $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                                        $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                        $value['transaction_id'] = $opts['transaction_id'] ?? '';
                                        $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                        $value['update_on'] = $_POST['UpdateOn'] ?? '';
                                        $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                        $value['pay_date'] = $today;
                                        $value['pay_type'] = 'RENTAL';
                                        $value['pay_for'] = '1 Rental';
                                        $value['Tele1'] = $_POST['phone'] ?? '';
                                        $value['email'] = $_POST['email'] ?? '';
                                        $value['City'] = $_POST['city'] ?? '';
                                        $value['State'] = $_POST['state'] ?? '';
                                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                                        $value['bank'] = $_POST['bank'] ?? '';
                                        $value['chkno'] = $_POST['chkno'] ?? '';
                                        $value['chkdate'] = $_POST['chkdate'] ?? '';
                                        $value['ReceiveBy'] = $_POST['ReceiveBy'] ?? '';
                                        $DonationModel->SaveDataInDonation($value);
                                        // end
        
                               if($datamember == null) {
                                $name =$_POST['first_name'].' '.$_POST['second_name'];
                                $value = array();
                                // $value['id'] = $_POST['id'] ?? '';
                                $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                $value['MemberName'] = $name;
                                $value['Amount'] = $_POST['total'] ?? '';
                                $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                                $value['payment_status'] = 'confirmed';
                                $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                $value['transaction_id'] = $opts['transaction_id'] ?? '';
                                $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['update_on'] = $_POST['update_on'] ?? '';
                                $value['Member_id'] = $_POST['Member_id'] ?? '';
                                $value['cc_name'] = $_POST['cc_name'] ?? '';
                                $value['remarks'] = $_POST['remarks'] ?? '';
                                $value['oid'] = $_POST['oid'] ?? '';
							    $value['pay_date'] = $today; 
                                $value['pay_type'] = 'Rental'; 
                                $value['pay_for'] = '1 Rental'; 
                                $value['Address'] = $_POST['address_1'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['Tele1'] = $_POST['phone'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                            $string = $amount ?? '';
                            $email = $_POST['email'] ?? '';
                            $msg='';
                            // $result = $this->sendBookingEmails($id, 'confirmation', 'client');
                                // $this->sendBookingEmails($id, 'confirmation', 'admin');
                               $result = $this->sendBookingEmailsNew($id, 'confirmation', 'Rental Client',$email,$mobileno,$Date ,$location,$stime,$etime,$h,$address_1,$msg,$invoiceid);
                                //$this->sendBookingEmailsNew($id, 'confirmation', 'Rental Admin',$email,$mobileno,$Date ,$location,$stime,$etime,$h,$address_1,$msg,$invoiceid);
                                //$this->sendBookingEmailsNew($id, 'confirmation', 'Education Admin',$email,$mobileno,$Date ,$location,$stime,$etime,$h,$address_1,$msg,$invoiceid);
                            $invoiceID= $result;

                            //$path ='C:\xampp\htdocs\HDBS\application\web\upload\invoice\booking_'.$id.'_invoice_'.$invoiceID.'.pdf';
                            $path = INSTALL_URL . 'application/web/upload/invoice/Rentalbooking_' . $id . '_invoice_' . $invoiceID . '.pdf';
                            $msg = 'Houston Durga Bari: Your Rental reservation request have been submitted. Booking Number is ' . $Bookinno . ' for ' . $location . ' on ' . $Date . ' Security Deposit: $ ' . $string . '  Order Id: '. ($_POST['oid'] ?? '').'. Click here  for receipt:' . $path;
                              $this->SendSMS($mobileno, $msg);
                        
                            echo "<a onclick = 'alertcheck()'>Go to home</a> " ; 
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
                    
                    } elseif (($_POST['payment_method'] ?? '') == 'check') {
                        if ($_POST['checkAmount'] !== '' && $_POST['checkAmount'] !== null && $_POST['checkAmount'] > 0) {
                            $opts = array();
                            $opts['id'] = $id;
                            $opts['status'] = 'confirmed';
                            $RentalBookingModel->update($opts);

                            date_default_timezone_set("America/Chicago");
                            $today = date("Y/m/d");
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['MemberName'] = trim(($_POST['first_name'] ?? '') . ' ' . ($_POST['second_name'] ?? ''));
                            $value['Amount'] = $_POST['checkAmount'] ?? '';
                            $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['payment_timestamp'] = '';
                            $value['stripe_return'] = '';
                            $value['transaction_id'] = $_POST['chkno'] ?? '';
                            $value['paid_amount'] = $_POST['checkAmount'] ?? '';
                            $value['update_on'] = $_POST['UpdateOn'] ?? '';
                            $value['stripe_product'] = '';
                            $value['pay_date'] = $_POST['chkdate'] ?? $today;
                            $value['pay_type'] = 'RENTAL';
                            $value['pay_for'] = '1 Rental';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['bank'] = $_POST['bank'] ?? '';
                            $value['chkno'] = $_POST['chkno'] ?? '';
                            $value['chkdate'] = $_POST['chkdate'] ?? '';
                            $value['ReceiveBy'] = $_POST['ReceiveBy'] ?? '';
                            $DonationModel->SaveDataInDonation($value);

                            $arr = $RentalBookingModel->get($id);
                            $prevlocation = $arr['location'] ?? '';
                            if ($prevlocation == 'Both') {
                                $location = 'Auditorium & Kalabhavan';
                            } else {
                                $location = $prevlocation;
                            }
                            $mobileno = $arr['phone'] ?? '';
                            $email = $arr['email'] ?? '';
                            $address_1 = $arr['address_1'] ?? '';
                            $Bookinno = $arr['booking_number'] ?? '';
                            $memberid = $_POST['Member_id'] ?? '';
                            $Date = date("F j, Y", $newDate);
                            $starttimefinal = $data['StartTime'] ?? '';
                            $endtimefinal = $data['EndTime'] ?? '';
                            $hours = $data['Hours'] ?? '';
                            $checkAmount = $_POST['checkAmount'] ?? '';

                            echo "<div style='margin-left:110px;' class = 'pay'>
                                <table border='4' width='585px'>
                                <tr>
                                <td colspan='2'> <img src='" . INSTALL_URL . "thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                                <tr>
                                <td>Booking Number</td> <td>" . $Bookinno . "</td> </tr>
                                <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                                <tr><td>Customer Name</td> <td>" . ($arr['first_name'] ?? '') . ' ' . ($arr['second_name'] ?? '') . "</td> </tr>
                                <tr><td>Customer Email Address</td> <td>" . $email . "</td> </tr>
                                <tr><td>Customer Phone Number</td> <td>" . $mobileno . "</td>  </tr>
                                <tr><td>Location</td> <td>" . $location . "</td>  </tr>
                                <tr><td>Amount</td> <td>$ " . $checkAmount . "</td>  </tr>
                                <tr><td>Address</td> <td>" . $address_1 . "</td>  </tr>
                                <tr><td>Selected Payment Method</td> <td>Check</td>  </tr>
                                <tr><td>Rental Date</td> <td>" . $getdate . "</td>  </tr>
                                <tr><td>Start Time</td> <td>" . $starttimefinal . "</td>  </tr>
                                <tr><td>End Time</td> <td>" . $endtimefinal . "</td>  </tr>
                                <tr><td>Hours</td> <td>" . $hours . "</td>  </tr>
                                <tr><td>Status</td> <td>confirmed</td></tr>";

                            $msg = '';
                            $result = $this->sendBookingEmailsNew($id, 'confirmation', 'Rental Client', $email, $mobileno, $Date, $location, $starttimefinal, $endtimefinal, $hours, $address_1, $msg, $invoiceid);
                            $invoiceID = $result;
                            $path = INSTALL_URL . 'application/web/upload/invoice/Rentalbooking_' . $id . '_invoice_' . $invoiceID . '.pdf';
                            $smsMsg = 'Houston Durga Bari: Your Rental reservation request have been submitted. Booking Number is ' . $Bookinno . ' for ' . $location . ' on ' . $Date . ' Security Deposit: $ ' . $checkAmount . '  Order Id: ' . ($_POST['oid'] ?? '') . '. Click here for receipt:' . $path;
                            $this->SendSMS($mobileno, $smsMsg);

                            echo "<a onclick = 'alertcheck()'>Go to home</a> ";
                        } else {
                            echo "<div style='margin-left:140px;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> </tr>
                    <tr>
                    <td colspan='2'><b>Your booking request have been submitted.
                    Your payment is not confirmed yet. To confirm your booking please contact to<a href='mailto:hdbs.payment@durgabari.org'> hdbs.payment@durgabari.org</a></b></td></tr>
                    </tr>";
                            echo "</table>";
                            echo "</div>";
                        }
                    } elseif (($_POST['payment_method'] ?? '') == 'stripe') {
                        require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                        $error = '';
                        $success = '';

                        Stripe::setApiKey($this->tpl["option_arr_values"]["stripe_api_key"]);

                        try {
                            if (!isset($_POST['stripeToken'])) {
                                throw new Exception("The Stripe Token was not generated correctly");
                            }
                            $oid = $_POST['oid'] ?? '';
                            $amount = round($amount * 100);

                            $payment = Stripe_Charge::create(array(
                                        "amount" => $amount,
                                        "currency" => $this->tpl["option_arr_values"]["currency"],
                                        "card" => $_POST['stripeToken'],
                                        "description" =>  "Booking No:".$FinalBookingNo. ', ' ."Email:".$_POST['email'] . ', ' ."Full Name:". ($_POST['first_name'] ?? '') . ' ' . ($_POST['second_name'] ?? '').' , ' ."Location:". ($_POST['location'] ?? '') .' ,  '."Additional:" . ($_POST['additional'] ?? ''),
                                       "metadata" => ["orderid" => $oid]
                                    ));

                            $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                            $this->tpl['payment']['amount'] = $payment->amount;
                            $this->tpl['payment']['status'] = $payment->status;
                            $this->tpl['payment']['currency'] = $payment->currency;

                            if ($payment->status == 'succeeded') {

                                $booking = $RentalBookingModel->get($id);

                                $opts = array();
                                $opts['id'] = $id;
                                $opts['stripe_return'] = $payment->status;
                                $opts['transaction_id'] = $payment->id;
                                $opts['paid_amount'] = $payment->amount;
                                $opts['stripe_product'] = $payment->description;
                                $opts['status'] = 'pending';
                                $string = substr($payment->amount, 0, -2);
                                $arr = $RentalBookingModel->get($id);
                                $pujaType = $arr['promo_code'];
                                $Bookinno = $arr['booking_number'];
                                $prevlocation = $arr['location'];
                                if($prevlocation == 'Both'){
                                    $location = 'Auditorium & Kalabhavan';
                              }else{
                                $location = $arr['location'];
                              }
                               //$location = $arr['location'];
                                $mobileno = $arr['phone'];
                                $address_1 =$arr['address_1'];
                                $payment_method =$arr['payment_method'];
                                // $timeSlotS =$timeSlot;
                                // $newDate = date('H:i', strtotime($timeSlotS. ' +120 minutes'));
                                // $timeSlotE =$newDate;
                               // $totalEle= 10;
                                $memberid = $_POST['Member_id'] ?? '';
                                $BookingTime =$data['timestamp'];
                                $str_arr = explode (",", $payment->description); 
                                //$replacement['date'] = date($option_arr['date_format'], strtotime($invoice['date']));
                                //$Date=date (strtotime("m-d-Y",$t1));
                                $Date=date("F j, Y",$newDate);
                                $starttimefinal = $data['StartTime'];
                                $endtimefinal = $data['EndTime'];
                                $timestamp = strtotime($getdate);
                                $finaluidate = date("m/d/Y", $timestamp);
                                echo "<div style='margin-left:110px;' class = 'pay'>
                                <table border='4' width='585px'>
                                <tr>
                                <td colspan='2'> <img src='" . INSTALL_URL . "thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                                <tr>
                                <td>Booking Number</td> <td>" .$Bookinno. "</td> </tr>
                                <td>Order ID</td> <td>" .$_POST['oid']. "</td> </tr>
                                <tr><td>Member Id</td> <td>" .$memberid. "</td> </tr>
                                <tr><td>Customer Name</td> <td>" .$arr['first_name'].' ' .$arr['second_name']. "</td> </tr>
                                <tr><td>Customer Email Address</td> <td>" .$arr['email'].   "</td> </tr>
                                <tr><td>Customer Phone Number</td> <td>" .$mobileno. "</td>  </tr>
                                <tr><td>Location</td> <td>" .$location. "</td>  </tr>
                                <tr><td>Security Deposit</td> <td><span style='color:red;'>$</span>" . ($price[1] ?? 0). "</td>  </tr>
                                <tr><td>Address</td> <td>" .$address_1. "</td>  </tr>
                                <tr><td>Payment Method</td> <td>Credit Card</td>  </tr>
                                <tr><td>Rental Date</td> <td>"  . $finaluidate.  "</td>  </tr>
                                <tr><td>Start Time</td> <td>" .$starttimefinal. "</td>  </tr>
                                <tr><td>End Time</td> <td>" .$endtimefinal. "</td>  </tr>
                                 <tr><td>Hours</td> <td>" .$data['Hours']. ' '. 'Hours'."</td>  </tr>
                                <tr><td>Status</td> <td>" .'pending'. "</td>
                                </tr>"  ;
                               $RentalBookingModel->update($opts);
                               //$RentalReservationsHistoryModel->update($opts);
                              
                              date_default_timezone_set("America/Chicago");
                                    $today = date("Y/m/d");
                                // save data in donations start
                                $value = array();
                                $value['oid'] = $_POST['oid'] ?? '';
                                $value['Member_id'] = $_POST['Member_id'] ?? '';
                                $value['MemberName'] = $_POST['first_name'] . ' ' . ($_POST['second_name'] ?? '');
                                $value['Amount'] = $_POST['advanceamount'] ?? '';
                                $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                                $value['payment_status'] = 'succeeded';
                                $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                                $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                $value['transaction_id'] = $opts['transaction_id'] ?? '';
                                $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                $value['update_on'] = $_POST['UpdateOn'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['pay_date'] = $today;
                                $value['pay_type'] = 'RENTAL';
                                $value['pay_for'] = '1 Rental';
                                $value['Tele1'] = $_POST['phone'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['City'] = $_POST['city'] ?? '';
                                $value['State'] = $_POST['state'] ?? '';
                                $value['Zip_Code'] = $_POST['zip'] ?? '';
                                $value['bank'] = $_POST['bank'] ?? '';
                                $value['chkno'] = $_POST['chkno'] ?? '';
                                $value['chkdate'] = $_POST['chkdate'] ?? '';
                                $value['ReceiveBy'] = $_POST['ReceiveBy'] ?? '';
                                $DonationModel->SaveDataInDonation($value);
                                // end
                              
                               if($datamember == null) {
                                  
                                $name =$_POST['first_name'].' '.$_POST['second_name'];
                                $value = array();
                                // $value['id'] = $_POST['id'] ?? '';
                                $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                $value['MemberName'] = $name;
                                $value['Amount'] = $_POST['total'] ?? '';
                                $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                                $value['payment_status'] = 'confirmed';
                                $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                $value['transaction_id'] = $opts['transaction_id'] ?? '';
                                $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['update_on'] = $_POST['update_on'] ?? '';
                                $value['Member_id'] = $_POST['Member_id'] ?? '';
                                $value['cc_name'] = $_POST['cc_name'] ?? '';
                                $value['remarks'] = $_POST['remarks'] ?? '';
                                $value['oid'] = $_POST['oid'] ?? '';
							    $value['pay_date'] = $today; 
                                $value['pay_type'] = 'Rental'; 
                                $value['pay_for'] = 'Rental'; 
                                $value['Address'] = $_POST['address_1'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['Tele1'] = $_POST['phone'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                            $email = $_POST['email'] ?? '';
                            $msg = '';
                               // $result = $this->sendBookingEmails($id, 'confirmation', 'client');
                                // $this->sendBookingEmails($id, 'confirmation', 'admin');
                                $result = $this->sendBookingEmailsNew($id, 'confirmation', 'Rental Client',$email,$mobileno,$Date ,$location,$stime,$etime,$h,$address_1,$msg,$invoiceid);
                                //$this->sendBookingEmailsNew($id, 'confirmation', 'Rental Admin',$email,$mobileno,$Date ,$location,$stime,$etime,$h,$address_1,$msg,$invoiceid);
                                //$this->sendBookingEmailsNew($id, 'confirmation', 'Education Admin',$email,$mobileno,$Date ,$location,$stime,$etime,$h,$address_1,$msg,$invoiceid);
                                $invoiceID = $result;

                                $path = INSTALL_URL . 'application/web/upload/invoice/Rentalbooking_' . $id . '_invoice_' . $invoiceID . '.pdf';
                                $msg = 'Houston Durga Bari: Your Rental reservation request have been submitted. Booking Number is ' . $Bookinno . ' for ' . $location . ' on ' . $Date . ' Security Deposit: $ ' . $string . '  Order Id: '. ($_POST['oid'] ?? '').'. Click here  for receipt:' . $path;
                                $this->SendSMS($mobileno, $msg);
                                echo "<a onclick = 'alertcheck()'>Go to home</a> ";
                            } else {
                                $booking = $RentalBookingModel->get($id);

                                $opts = array();
                                $opts['id'] = $id;
                                $opts['stripe_return'] = $payment->status;
                                $opts['transaction_id'] = $payment->id;
                                $opts['paid_amount'] = $payment->amount;
                                $opts['stripe_product'] = $payment->description;
                                $BookingModel->update($opts);

                                $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';

                                Util::redirect(INSTALL_URL . "GzRental/index");
                            }
                        } catch (Exception $e) {

                            $_SESSION['status'] = '<strong>Error!</strong> ' . $e->getMessage();
                            Util::redirect(INSTALL_URL . "GzRental/index");
                            return;
                        }
                    } elseif (($_POST['payment_method'] ?? '') == 'authorize') {
                        require_once APP_PATH . 'helpers/sdk-php-master/autoload.php';
                    }

                    $this->tpl['booking_details'] = $RentalBookingModel->getBookingDetails($id);

                    $status = 10;
                } else {
                    $status = 11;
                    $_SESSION['status'] = '<strong>Warning Error!</strong> Booking could not be saved. Please try again or contact support.';
                }
            } else {
                $err = __('err');
                $_SESSION['status'] = $err[11];
            }
        }
    }
    
    function checkout1febbackup() {
        $this->isAjax = true;
        //my twillo account setting
       // $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
        //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
        //hdbs twillo account setting
        //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
        //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
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

                GzObject::loadFiles('Model', array('RentalBooking', 'RentalBookingSlot', 'ConfirmCode', 'RentalReservationsHistory'));
                $RentalBookingModel = new RentalBookingModel();
                $RentalBookingSlotModel = new RentalBookingSlotModel();
                $ConfirmCodeModel = new ConfirmCodeModel();
                $RentalReservationsHistoryModel = new RentalReservationsHistoryModel();

                $data = array();
                $data['status'] = "pending";
                $data['Member_id'] = $_POST['Member_id'] ?? '';
                //$prices = $this->calclateBookingPrice($_POST);
                $calPrice = $_POST['advanceamount'] ?? '';
                $price=explode(" ",$calPrice);
                $data['total'] = $price[1] ?? 0;
                $amount = $price[1] ?? 0;
                
                $data['currency'] = $this->tpl['option_arr_values']['currency'];
                //$data['booking_number'] = Util::incrementalHash(10);
                $date = date('Y');
                $BookingNo = $RentalBookingModel->getMax();
                $bno =  substr($BookingNo,4);
                $bnonumeric = intval($bno);
               // if($bno==false){
                //     $data['booking_number'] = $date."001";
                // }
                // else{ }
                $bookingnumber = $bnonumeric +1 ;
                $data['booking_number'] = $date."0".$bookingnumber;
                $FinalBookingNo = $data['booking_number'];
                $getdate = $_POST['Startdate'] ?? '';
                $newDate = strtotime($getdate);
                $data['date'] = $newDate;
                $time = time();
                $data['created'] = $time;
                $finalDate = date("Y-m-d", $time);
                $data['finalDate'] = $getdate;
                $data['calendar_id'] = $_GET['cid'] ?? [];
                $id = $RentalBookingModel->save(array_merge($_POST, $data));
                //$RentalReservationsHistoryModel->save(array_merge($_POST, $data));

                if (!empty($id)) {

                    //foreach ($_SESSION[$this->default_product]['slots'][$_REQUEST['cid'] ?? []] as $i => $count) {
                        $data = array();
                        $data['calendar_id'] = $_GET['cid'] ?? [];
                        $data['booking_id'] = $id;
                        $data['timestamp'] = $newDate;
                       
                        $currentDate = date("Y-m-d", $newDate);
                        $data['count'] = 1;
                        $data['timecreated'] = time();
                        $data['StartTime'] = $_POST['Starttime'] ?? '';
                        $data['EndTime'] = $_POST['Endtime'] ?? '';
                        $data['Hours'] = $_POST['Hours'] ?? '';
                        $current=$data['timecreated'];
                        $bookingdate=$data['timestamp'];
                        $RentalBookingSlotModel->save($data);   
                        $bookdate = date("Y-m-d", $bookingdate);
                    //}
                    
                    $RentalBookingModel->saveInvoice($id);
                    unset($_SESSION[$this->default_product]);

                    $_SESSION[$this->default_product] = array();

                    if (($_POST['payment_method'] ?? '') == 'others') {
                        $opts = array();
                        $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                        $arr = $ConfirmCodeModel->getAll($opts);

                        //if (!empty($arr[0])) { if code is not find in table booking will pending
                            if ($oid!=="1") {
                            $opts = array();
                            $opts['id'] = $id;
                            $opts['status'] = 'confirmed';

                            $arr = $RentalBookingModel->get($id);
                                $pujaType =$arr['promo_code'];
                                $location =$arr['location'];
                                $mobileno =$arr['phone'];
                                $email = $arr['email'];
                                $address_1 =$arr['address_1'];
                                $payment_method =$arr['payment_method'];
                                // $timeSlotS =$timeSlot;
                                // $newDate = date('H:i', strtotime($timeSlotS. ' +120 minutes'));
                                $timeSlotE =$newDate;
                                $Bookinno =$arr['booking_number'];
                                $Name = $arr['first_name']  .  $arr['second_name'];
                                $totalEle= 10;
                                 $Date=date("F j, Y",$bookingdate);
                                $BookingTime =$data['timestamp'];
                                echo "<div style='margin-left:110px;' class = 'pay'>
                                <table border='4' width='585px'>
                                <tr>
                                <td colspan='2'> <img src='" . INSTALL_URL . "thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                                <tr>
                                <td>Booking Number</td> <td>" .$Bookinno. "</td> </tr>
                               
                                <tr><td>Customer Name</td> <td>" .$arr['first_name'].' ' .$arr['second_name']. "</td> </tr>
                                <tr><td>Customer Email Address</td> <td>" .$arr['email'].   "</td> </tr>
                                <tr><td>Customer Phone Number</td> <td>" .$mobileno. "</td>  </tr>
                                <tr><td>Address</td> <td>" .$address_1. "</td>  </tr>
                                <tr><td>Selected Payment Method</td> <td>" .'Zelle'. "</td>  </tr>
                                <tr><td>Date and Time</td> <td>"  . $data['StartTime'].' ' .$data['EndTime']. "</td>  </tr>
                                <tr><td>Puja Type</td> <td>" . $pujaType. "</td>  </tr>
                                <tr><td>Status</td> <td>" .'confirmed'. "</td>
                                </tr>"  ;
                            $RentalBookingSlotModel->update($opts);
                            $msg='';
                            // $result =$this->sendBookingEmails($id, 'confirmation', 'client');
                            // $this->sendBookingEmails($id, 'confirmation', 'admin');
                            $result = $this->sendBookingEmailsNew($id, 'confirmation', 'client',$Name, $email,$mobileno,$Date ,$timeSlotE,$timeSlotE,$pujaType,$address_1,$msg);
                            $this->sendBookingEmailsNew($id, 'confirmation', 'admin',$Name,$email,$mobileno,$Date ,$timeSlotE,$timeSlotE,$pujaType,$address_1,$msg);
                            $this->sendBookingEmailsNew($id, 'confirmation', 'priest',$Name, $email,$mobileno,$Date ,$timeSlotE,$timeSlotE,$pujaType,$address_1,$msg);
                            $invoiceID= $result;

                            //$path ='C:\xampp\htdocs\HDBS\application\web\upload\invoice\booking_'.$id.'_invoice_'.$invoiceID.'.pdf';
                            $path = INSTALL_URL . 'application/web/upload/invoice/booking_' . $id . '_invoice_' . $invoiceID . '.pdf';
                            //$msg='Houston DurgaBari: Your Priest Service Booking Number is '.$Bookinno. ' for '.$pujaType. ' on '.$testDate.' '. $location . ' Durga Bari. Transaction ID:'. $payment->id . ' Confirmed  paid amount($)'.$string. '. Click here  for receipt:'. $path;
                        //     $msg = 'Houston DurgaBari: Your Priest Booking Number  is ' . $Bookinno . ' for ' . $pujaType . ' on ' . $Date . ' ' . $location . ' Durga Bari. Click here  for receipt:' . $path;
                        //    $message = $client->messages->create(
                        //         // Where to send a text message (your cell phone?)
                        //         '+91'.$mobileno.'',
                        //         array(
                        //             'from' => '+19707037189',
                        //              //'from' => '+12815016454',
                        //             'body' => $msg
                        //         )
                        //     );
                            echo "<a onclick = 'alertcheck()'>Go to home</a> " ; 
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
                    
                    } elseif (($_POST['payment_method'] ?? '') == 'stripe') {
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
                                        "description" =>  "Booking No:".$FinalBookingNo. ', ' ."Email:".$_POST['email'] . ', ' ."Full Name:". ($_POST['first_name'] ?? '') . ' ' . ($_POST['second_name'] ?? '').' , '."Puja Type:" . ($_POST['promo_code'] ?? '').' , ' ."Location:". ($_POST['location'] ?? '') . "-Durgabari".' ,  '."Additional:" . ($_POST['additional'] ?? ''),
                                        "metadata" => ["Reservtion" => $id]
                                    ));

                            $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                            $this->tpl['payment']['amount'] = $payment->amount;
                            $this->tpl['payment']['status'] = $payment->status;
                            $this->tpl['payment']['currency'] = $payment->currency;

                            if ($payment->status == 'succeeded') {

                                $booking = $RentalBookingModel->get($id);

                                $opts = array();
                                $opts['id'] = $id;
                                $opts['stripe_return'] = $payment->status;
                                $opts['transaction_id'] = $payment->id;
                                $opts['paid_amount'] = $payment->amount;
                                $opts['stripe_product'] = $payment->description;
                                $opts['status'] = 'confirmed';
                                $string = substr($payment->amount, 0, -2);
                                $arr = $RentalBookingModel->get($id);
                                $pujaType = $arr['promo_code'];
                                $Bookinno = $arr['booking_number'];
                                $location = $arr['location'];
                                $mobileno = $arr['phone'];
                                $address_1 =$arr['address_1'];
                                $payment_method =$arr['payment_method'];
                                $timeSlotS =$timeSlot;
                                $newDate = date('H:i', strtotime($timeSlotS. ' +120 minutes'));
                                $timeSlotE =$newDate;
                                $totalEle= 10;
                                $memberid = $_POST['Member_id'] ?? '';
                                $BookingTime =$data['timestamp'];
                                $str_arr = explode (",", $payment->description); 
                                //$replacement['date'] = date($option_arr['date_format'], strtotime($invoice['date']));
                                //$Date=date (strtotime("m-d-Y",$t1));
                                $Date=date("F j, Y",$bookingdate);
                                echo "<div style='margin-left:110px;' class = 'pay'>
                                <table border='4' width='585px'>
                                <tr>
                                <td colspan='2'> <img src='" . INSTALL_URL . "thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td> </tr>
                                <tr>
                                <td>Booking Number</td> <td>" .$Bookinno. "</td> </tr>
                                <tr><td>Member Id</td> <td>" .$memberid. "</td> </tr>
                                <tr><td>Customer Name</td> <td>" .$arr['first_name'].' ' .$arr['second_name']. "</td> </tr>
                                <tr><td>Customer Email Address</td> <td>" .$arr['email'].   "</td> </tr>
                                <tr><td>Customer Phone Number</td> <td>" .$mobileno. "</td>  </tr>
                                <tr><td>Location</td> <td>" .$location. "</td>  </tr>
                                <tr><td>Amount</td> <td>" . $price[1]. "</td>  </tr>
                                <tr><td>Address</td> <td>" .$address_1. "</td>  </tr>
                                <tr><td>Selected Payment Method</td> <td>" .$payment_method. "</td>  </tr>
                                <tr><td>Rental Date</td> <td>"  .$getdate.  "</td>  </tr>
                                <tr><td>Start Time</td> <td>" .$data['StartTime']. "</td>  </tr>
                                <tr><td>End Time</td> <td>" .$data['EndTime']. "</td>  </tr>
                                <tr><td>Hours</td> <td>" .$data['Hours']. "</td>  </tr>
                                <tr><td>Status</td> <td>" .'confirmed'. "</td>
                                </tr>"  ;
                               $RentalBookingModel->update($opts);
                               //$RentalReservationsHistoryModel->rentalbookingsave(array_merge($opts, $data));
                                // $result = $this->sendBookingEmails($id, 'confirmation', 'client');
                                // $this->sendBookingEmails($id, 'confirmation', 'admin');
                                $result = $this->sendBookingEmailsNew($id, 'confirmation', 'client',$str_arr[1], $str_arr[0],$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                                $this->sendBookingEmailsNew($id, 'confirmation', 'admin',$str_arr[1], $str_arr[0],$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                                $this->sendBookingEmailsNew($id, 'confirmation', 'priest',$str_arr[1], $str_arr[0],$mobileno,$Date ,$timeSlotS,$timeSlotE,$pujaType,$address_1,$msg);
                                $invoiceID = $result;

                                $path = INSTALL_URL . 'application/web/upload/invoice/booking_' . $id . '_invoice_' . $invoiceID . '.pdf';

                                // $msg = 'Houston DurgaBari: Your Priest Service Booking Number is ' . $Bookinno . ' for ' . $pujaType . ' on ' . $Date . ' ' . $location . ' Durga Bari has been confirmed paid Amount($) ' . $string . '. Click here  for receipt:' . $path;
                                // // $msg='Houston DurgaBari: Your Priest Service Booking Number is '.$Bookinno. ' for '.$pujaType. ' on '.$testDate.' '. $location . ' Durga Bari. Click here  for receipt:'. $path;

                                // $message = $client->messages->create(
                                //         // Where to send a text message (your cell phone?)
                                //         '+91' . $mobileno . '',
                                //         array(
                                //             'from' => '+19707037189', //paras
                                //             //'from' => '+12815016454',
                                //             'body' => $msg
                                //         )
                                // );
                                echo "<a onclick = 'alertcheck()'>Go to home</a> ";
                            } else {
                                $booking = $RentalBookingModel->get($id);

                                $opts = array();
                                $opts['id'] = $id;
                                $opts['stripe_return'] = $payment->status;
                                $opts['transaction_id'] = $payment->id;
                                $opts['paid_amount'] = $payment->amount;
                                $opts['stripe_product'] = $payment->description;
                                $BookingModel->update($opts);

                                $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';

                                Util::redirect(INSTALL_URL . "GzRental/index");
                            }
                        } catch (Exception $e) {

                            $_SESSION['status'] = '<strong>Error!</strong> ' . $e->getMessage();
                            Util::redirect(INSTALL_URL . "GzRental/index");
                            return;
                        }
                    } elseif (($_POST['payment_method'] ?? '') == 'authorize') {
                        require_once APP_PATH . 'helpers/sdk-php-master/autoload.php';
                    }

                    $this->tpl['booking_details'] = $RentalBookingModel->getBookingDetails($id);

                    $status = 10;
                } else {
                    $status = 11;
                    $_SESSION['status'] = '<strong>Warning Error!</strong> Booking could not be saved. Please try again or contact support.';
                }
            } else {
                $err = __('err');
                $_SESSION['status'] = $err[11];
            }
        }
    }

    

    

    
    function calculatePrice() {
        $this->isAjax = true;

        $_POST['calendar_id'] = $_GET['cid'] ?? [];
        $price = $this->calclateBookingPrice($_POST);

        header("Content-Type: application/json", true);
        echo json_encode($price);
    }

    function calendar() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();

        $opts = array();
        $opts['calendar_id'] = $_GET['cid'] ?? [];
        $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues($opts);

        require APP_PATH . 'helpers/ABCalendar/RentalABCalendar.php';

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

        $this->tpl['abcalendar'] = new RentalABCalendar($m, $d, $y, $_GET['cid'] ?? [], $_GET['view_month'] ?? 1, $this->tpl['option_arr_values'], $this->tpl['select_language']);
    }

    
    
    function booking_form() {
        $this->isAjax = true;
        $opts = array();
      
        $this->tpl['startdate'] =$_POST['start_date'];
        $this->tpl['enddate'] =$_POST['end_date'];
        $opts['calendar_id'] = $_POST['cal_id'] ?? '';
       // $this->tpl['prices'] = $this->calclateBookingPrice($_POST);
        //$this->tpl['prices'] = $_POST['cal_id'];

        
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
    function getConfirmationCode() {
        $email_address = 'treasurer@durgabari.org';
        $app_password = 'ywbfszrjiubozbjt';
        $dateMail = date("d-M-Y", strtotime("-7 days"));
        $items = array();

        $this->zelleMailLog('Starting rental Zelle mail read using cURL IMAPS', array(
            'email_address' => $email_address,
            'date_from' => $dateMail
        ));

        if (!function_exists('curl_init')) {
            $this->zelleMailLog('PHP cURL extension is not available; curl_init function missing');
            return $items;
        }

        $curlVersion = curl_version();
        $protocols = isset($curlVersion['protocols']) && is_array($curlVersion['protocols']) ? $curlVersion['protocols'] : array();
        if (!in_array('imaps', $protocols, true)) {
            $this->zelleMailLog('cURL IMAPS protocol is not available', array('protocols' => implode(',', $protocols)));
            return $items;
        }

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => 'imaps://imap.gmail.com:993/INBOX',
            CURLOPT_USERPWD => $email_address . ':' . str_replace(' ', '', $app_password),
            CURLOPT_CUSTOMREQUEST => 'SEARCH SUBJECT "You received money with Zelle" SINCE "' . $dateMail . '"',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT => 45,
        ));

        $searchResult = curl_exec($ch);
        if ($searchResult === false || curl_errno($ch)) {
            $this->zelleMailLog('cURL IMAPS search failed', array(
                'curl_errno' => curl_errno($ch),
                'curl_error' => curl_error($ch),
                'http_code' => curl_getinfo($ch, CURLINFO_RESPONSE_CODE)
            ));
            curl_close($ch);
            return $items;
        }

        $searchResult = str_replace('* SEARCH', '', $searchResult);
        $messageIds = array_filter(array_map('trim', explode(' ', trim($searchResult))));
        if (empty($messageIds)) {
            $this->zelleMailLog('No Zelle emails found by cURL IMAPS search', array('raw_search_result' => trim($searchResult)));
            curl_close($ch);
            return $items;
        }

        foreach (array_reverse($messageIds) as $msgId) {
            if ($msgId === '' || !is_numeric($msgId)) {
                continue;
            }

            curl_setopt_array($ch, array(
                CURLOPT_URL => 'imaps://imap.gmail.com:993/INBOX;MAILINDEX=' . $msgId,
                CURLOPT_CUSTOMREQUEST => null,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_TIMEOUT => 45,
            ));

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

            $confirmation = preg_match('/Confirmation:\s*([\S]+)/', $message, $m) ? trim(strip_tags($m[1])) : '';
            $amount = preg_match('/sent you \s*([^\r\n]+?)\s*Date:/', $message, $m) ? trim(strip_tags($m[1])) : '';
            $amount = rtrim(rtrim(str_replace(',', '', $amount), '0'), '.');
            $date = preg_match('/Date:\s*([\d\/]+)/', $message, $m) ? trim(strip_tags($m[1])) : '';
            $name = preg_match('/Wells Fargo Alert\s*([^\r\n]+?)\s*sent you/', $message, $m) ? trim(strip_tags($m[1])) : '';
            $name = str_replace("'", '', $name);
            $description = preg_match('/Memo: ([^\r\n]{1,50})/', $message, $m) ? trim(strip_tags($m[1])) : '';
            $timestamp = strtotime(trim($date));
            $payDate = $timestamp ? date("d F, Y", $timestamp) : '';

            $items[] = array($payDate, $amount, $confirmation, $description, $name);
        }

        curl_close($ch);
        $this->zelleMailLog('Finished rental cURL Zelle mail read', array('transactions_parsed' => count($items)));
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
        $str = str_replace(',', "", trim($GetData[0]));
        $conn = gz_mysqli_connect(DEFAULT_HOST, DEFAULT_USER, DEFAULT_PASS, DEFAULT_DB);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO confirm_code (date, Confirmation, Amount, Description, DonarName, UpdatedOn) VALUES (?, ?, ?, ?, ?, '')");
        if (!$stmt) {
            return false;
        }

        $confirmation = $GetData[2] ?? '';
        $amount = $GetData[1] ?? '';
        $description = $GetData[3] ?? '';
        $donorName = $GetData[4] ?? '';
        $stmt->bind_param('sssss', $str, $confirmation, $amount, $description, $donorName);
        $retval = $stmt->execute();
        $stmt->close();
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
    function checkCodeDD() {
        $this->isAjax = true;
        session_write_close();
        GzObject::loadFiles('Model', array('ConfirmCode'));
        $ConfirmCodeModel = new ConfirmCodeModel();

        $donorName = trim($_POST['donor_name'] ?? '');
        $zelleAmt  = trim($_POST['zelle_amount'] ?? '');
        $zelleDate = trim($_POST['zelle_date'] ?? '') ?: null;

        if (empty($donorName) || empty($zelleAmt)) {
            echo 'NO_MATCH';
            return;
        }

        $arr = $ConfirmCodeModel->getByMember($donorName, $zelleAmt, $zelleDate);
        if (empty($arr)) {
            echo 'NO_MATCH';
            return;
        }

        foreach ($arr as $value) {
            $opt = htmlspecialchars($value['Amount'], ENT_QUOTES);
            echo '<option value="' . $opt . '">' . $opt . '</option>';
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
            $z = $this->getConfirmationCode();
            // $i=0;
            foreach ($z as $payment_code) {
             
                $arr= $ConfirmCodeModel->getConfirmCodeCheck($payment_code[2]);
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
            $DatabaseCode = $arr[0]['Confirmation'];
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
            $DatabaseCode = $arr[0]['Confirmation'];
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


