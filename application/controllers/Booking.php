<?php

require_once CONTROLLERS_PATH . 'App.php';
require __DIR__ . '/Twillio/vendor/autoload.php';
use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
//use \vendor\twilio\sdk\src\Twilio\Rest\Client;

class Booking extends App {

    var $layout = 'admin';
    var $option_arr = null;

    function beforeFilter() {

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();
        $this->option_arr = $OptionModel->getAllPairValues();
        $this->tpl['option_arr'] = $OptionModel->getAllPairs();
        $this->tpl['option_arr_values'] = $this->option_arr;

        $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format']);
        $this->tpl['iso_format'] = Util::getISODateFormta($this->tpl['option_arr_values']['date_format']);

        date_default_timezone_set($this->tpl['option_arr_values']['timezone']);

        $action = $_REQUEST['action'] ?? '';

        if (!$this->isLoged() && $action != 'login') {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }
        
        if ($this->isMember() ) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }

        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/datepicker/datepicker.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.min.js', 'path' => LIBS_PATH . 'jquery/ui/');
        $this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datepicker/bootstrap-datepicker.js', 'path' => JS_PATH);
        if ($action == 'send') {
            $this->js[] = array('file' => 'jquery/tinymce/tinymce.min.js', 'path' => LIBS_PATH);
        }
        $this->js[] = array('file' => 'GzBooking.js', 'path' => JS_PATH);
    }

    function create() {
        GzObject::loadFiles('Model', array('Booking', 'Calendar', 'BookingSlot'));
        $BookingModel = new BookingModel();
        $CalendarModel = new CalendarModel();
        $BookingSlotModel = new BookingSlotModel();

        if (!empty($_POST['create_booking'])) {

            $data = array();
            $data['booking_number'] = Util::incrementalHash(10);
            $data['amount'] = (($_POST['deposit'] ?? 0) > 0) ? ($_POST['deposit'] ?? 0) : ($_POST['total'] ?? 0);
            $data['amount'] = number_format($data['amount'], 2, '.', '');
            $data['date'] = strtotime(date('Y-m-d'));
            $time = time();
                
            $data['created'] = $time;

            $finalDate = date("Y-m-d", $time);

            $data['finalDate'] = $finalDate;

            $id = $BookingModel->save(array_merge($_POST, $data));

            if (!empty($id)) {
                foreach ($_SESSION[$this->default_product]['admin']['slots'][$_POST['calendar_id'] ?? 0] as $i => $count) {
                    $data = array();
                    $data['calendar_id'] = $_POST['calendar_id'] ?? '';
                    $data['booking_id'] = $id;
                    $data['timestamp'] = $i;
                    $data['count'] = $count;
                    $data['timecreated'] = time();

                    $BookingSlotModel->save($data);
                }
                
                $BookingModel->saveInvoice($id);
                
                $_SESSION['status'] = 10;
            } else {
                $_SESSION['status'] = 11;
            }

            Util::redirect(INSTALL_URL . "Booking/index");
        }

        $opts = array();
        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);

        unset($_SESSION[$this->default_product]['admin']);
    }

    function edit() {
         //my twillo account setting
       // $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
       //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
         //hdbs twillo account setting
       $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
        $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
        $client = new Client($sid, $token);
        GzObject::loadFiles('Model', array('Booking', 'Calendar', 'BookingSlot', 'CustomDate'));
        $BookingModel = new BookingModel();
        $CalendarModel = new CalendarModel();
        $BookingSlotModel = new BookingSlotModel();
        $CustomDateModel = new CustomDateModel();

        if (!empty($_POST['edit_booking'])) {
            $data = array();
            
            $old = $BookingModel->get($_POST['id'] ?? '');

            $data['amount'] = (($_POST['deposit'] ?? 0) > 0) ? ($_POST['deposit'] ?? 0) : ($_POST['total'] ?? 0);
            $data['amount'] = number_format($data['amount'], 2, '.', '');
            $data['date'] = $old['date'];
            $testDate = $_POST['date'] ?? '';
            //$testDate=date("Y-m-d",$t);
            $mobileno = $_POST['phone'] ?? '';
            $Bookinno = $old['booking_number'];
            $pujaType = $_POST['promo_code'] ?? '';
            $ID = $_POST['id'] ?? '';
            
            $location = $_POST['location'] ?? '';

            unset($_POST['date']);

            $id = $BookingModel->update(array_merge($data, $_POST));
               if($mobileno!=""){
             $msg='Houston DurgaBari: Your Priest Service Booking Number is '.$Bookinno.' updated for '.$pujaType.' on '.$testDate.' '. $location .' Durga Bari.';
                               try {
                                $message = $client->messages->create(
                                // Where to send a text message (your cell phone?)
                                '+1'.$mobileno.'',
                                array(
                                     //'from' => '+19707037189',
                                    'from' => '+12815016454',
                                    'body' => $msg
                                )
                            );
                               } catch (\Exception $e) {
                                   error_log('SMS send failed: ' . $e->getMessage());
                               }
               }
            
            $BookingSlotModel->deleteFrom($BookingSlotModel->getTable())
                    ->where(array('booking_id' => (int) ($_POST['id'] ?? 0)))->execute();

            foreach ($_SESSION[$this->default_product]['admin']['slots'][$_POST['calendar_id'] ?? 0] as $i => $count) {
                $data = array();
                $data['calendar_id'] = $_POST['calendar_id'] ?? '';
                $data['booking_id'] = $_POST['id'] ?? '';
                $data['timestamp'] = $i;
                $data['count'] = $count;
                $data['location'] = $_POST['location'] ?? '';

                $BookingSlotModel->save($data);
            }

            if (!empty($id)) {
                $_SESSION['status'] = 14;
            } else {
                $_SESSION['status'] = 15;
            }
            Util::redirect(INSTALL_URL . "Booking/index");
           

        }
        $id = $_GET['id'] ?? '';
        $arr = $BookingModel->get($id);
       
        $this->tpl['booking'] = $arr;
        $opts = array();
        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);

        unset($_SESSION[$this->default_product]['admin']);

        GzObject::loadFiles('Model', array('TimePrice'));
        $TimePriceModel = new TimePriceModel();

        $opts = array();

        $opts['calendar_id'] = $this->tpl['booking']['calendar_id'];
        $working_times = $TimePriceModel->getAll($opts, 'id');
        
        
        if ($arr['location'] == "inside") {
            if (!empty($working_times)) {
                $this->tpl['working_time'] = $working_times[0];
            }
        }

        else if ($arr['location'] == "outside") {
            if (!empty($working_times)) {
                $this->tpl['working_time'] = $working_times[1];
            }
        }

       else if ($arr['location'] == "wholeday") {
            if (!empty($working_times)) {
                $this->tpl['working_time'] = $working_times[2];
            }
        }

        else{

            if (!empty($working_times)) {
                $this->tpl['working_time'] = $working_times[0];
            }

        }
        
        
        
        $this->tpl['location_booking'] = $arr['location'];
        
        

        // if (!empty($working_times)) {
        //     $this->tpl['working_time'] = $working_times[0];
        // }
        
        $opts = array();
        $opts['calendar_id'] = $this->tpl['booking']['calendar_id'];
        $custom_dates = $CustomDateModel->getAll($opts);
        
        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for($i = $v['timestamp']; $i <= $v['timestamp_end']; $i+=86400){
                    $this->tpl['custom_dates'][mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $opts = array();
        $opts['booking_id'] = $id;
        $arr = $BookingSlotModel->getAll($opts);

        foreach ($arr as $key => $value) {
            $_SESSION[$this->default_product]['admin']['slots'][$this->tpl['booking']['calendar_id']][$value['timestamp']] = $value['count'];
        }
    }

    function index() {
        GzObject::loadFiles('Model', array('Booking', 'Calendar'));
        $BookingModel = new BookingModel();
        $CalendarModel = new CalendarModel();

        $opts = array();

        if (!empty($_POST['status'])) {
            $opts['status = :status'] = array(':status' => ($_POST['status'] ?? ''));
        }
        if (!empty($_POST['first_name'])) {
            $opts['first_name LIKE :first_name'] = array(':first_name' => "%" . ($_POST['first_name'] ?? '') . "%");
        }
        if (!empty($_POST['second_name'])) {
            $opts['second_name LIKE :second_name'] = array(':second_name' => "%" . ($_POST['second_name'] ?? '') . "%");
        }
        if (!empty($_POST['email'])) {
            $opts['email LIKE :email'] = array(':email' => "%" . ($_POST['email'] ?? '') . "%");
        }
        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        if(!empty($_GET['today'])){
            $opts['t1.date = :date'] = array(':date' => strtotime(date("Y-m-d")));
        }
        if(!empty($_GET['week'])){
            $opts['t1.date BETWEEN :date1 AND :date2'] = array(':date1' => strtotime('last Monday', time()),':date2' => (strtotime('next Sunday', time()) + 86400 ));
        }
        if(!empty($_POST['calendar_id'])){
            $opts['t1.calendar_id = :calendar_id'] = array(':calendar_id' => ($_POST['calendar_id'] ?? ''));
        }
        if (!empty($_POST['booking_number'])) {
            $opts['booking_number LIKE :booking_number'] = array(':booking_number' => "%" . ($_POST['booking_number'] ?? '') . "%");
        }

        if (!empty($_POST['location'])) {
            $opts['location LIKE :location'] = array(':location' => "%" . ($_POST['location'] ?? '') . "%");
        }
        
        $arr = $BookingModel->getAll($opts);

        $this->tpl['arr'] = $arr;
        $opts = array();
        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);
    }

    function priestpriceindex() {
        GzObject::loadFiles('Model', array('priestserviceprice'));
        $priestservicepriceModel = new priestservicepriceModel();

        $opts = array();

       // for admin priest price
        $pujapricearr = $priestservicepriceModel->getAll($opts);
        $this->tpl['pujapricearr'] = $pujapricearr;
    }



    function preiestpricecreate(){
      GzObject::loadFiles('Model', array('priestserviceprice'));
      $priestservicepriceModel = new priestservicepriceModel();

     if (!empty($_POST['preiestpricecreate'])) {

         $id = $priestservicepriceModel->save(array_merge($_POST));

         if (!empty($id)) {
            $_SESSION['status'] = 16;
         } else {
            $_SESSION['status'] = 17;
         }
         Util::redirect(INSTALL_URL . "Booking/priestpriceindex");
        }
        
    }

function priestpriceedit(){
    GzObject::loadFiles('Model', array('priestserviceprice'));
    $priestservicepriceModel = new priestservicepriceModel();

    if (!empty($_POST['priestpriceedit'])) {

        $data = array();
        $id = $priestservicepriceModel->update(array_merge($_POST));

        if (!empty($id)) {
            $_SESSION['status'] = 20;
        } else {
            $_SESSION['status'] = 21;
        }

        if (!$this->isAdmin()) {
            Util::redirect(INSTALL_URL . "Admin/dashboard");
        } else {
            Util::redirect(INSTALL_URL . "Booking/priestpriceindex");
        }
    }
    $id = $_GET['id'] ?? '';
    $priestpricearr = $priestservicepriceModel->get($id);
    $this->tpl['priestpricearr'] = $priestpricearr;

  }



    function delete() {
        $this->isAjax = true;
        $id = $_REQUEST['id'] ?? '';
        $cat = $_REQUEST['cat'] ?? '';
         
        GzObject::loadFiles('Model', array('Booking', 'BookingSlot','priestserviceprice'));
        $BookingModel = new BookingModel();
        $BookingSlotModel = new BookingSlotModel();
        $priestservicepriceModel = new priestservicepriceModel();
        
         if($cat == 1){
        $BookingSlotModel->deleteFrom($BookingSlotModel->getTable())
                ->where('booking_id', $id)->execute();
        $BookingModel->deleteFrom($BookingModel->getTable())
                ->where('id', $id)->execute();
                //$this->index();
                Util::redirect(INSTALL_URL . "Booking/index");
        }
        if($cat == 2){
            $priestservicepriceModel->deleteFrom($priestservicepriceModel->getTable())
            ->where('id', $id)->execute();
            Util::redirect(INSTALL_URL . "Booking/priestpriceindex");
        }

    }

    function deleteSelected() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Booking', 'BookingSlot'));
        $BookingModel = new BookingModel();
        $BookingSlotModel = new BookingSlotModel();

        if (!empty($_POST['mark'])) {
            $BookingModel->deleteFrom($BookingModel->getTable())
                    ->where('id', (int) ($_POST['mark'] ?? 0))->execute();

            $BookingSlotModel->deleteFrom($BookingSlotModel->getTable())
                    ->where('booking_id', (int) ($_POST['mark'] ?? 0))->execute();
        }

        $this->index();
    }

    function calculatePrice() {
        $this->isAjax = true;

        $post = $_POST;

        $price = array('calendars_price' => 0, 'discount' => 0, 'total' => 0, 'tax' => 0, 'security' => 0, 'deposit' => 0);
        $calendarId = $_REQUEST['calendar_id'] ?? '';
        $price = $this->calclateBookingPrice($post, $_SESSION[$this->default_product]['admin']['slots'][$calendarId] ?? []);

        header("Content-Type: application/json", true);
        echo json_encode($price);
    }

    function send() {

        GzObject::loadFiles('Model', array('Option', 'Booking', 'Invoice'));
        $OptionModel = new OptionModel();
        $BookingModel = new BookingModel();
        $InvoiceModel = new InvoiceModel();
        $option_arr = $OptionModel->getAllPairValues();

        $opts = array();
       $opts['booking_id'] = $_GET['id'] ?? '';
       // $opts['booking_id'] = $_GET['booking_number'];
        $invoice = $InvoiceModel->getAll($opts, 'id desc');

        $booking_details = $BookingModel->getBookingDetails($_GET['id'] ?? '');

        if (!empty($_POST['send_email'])) {

            try {
                $mail = new PHPMailer(true); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->AddReplyTo($option_arr['notify_email'], "Admin");
                $mail->From = $option_arr['notify_email'];
                $mail->FromName = $option_arr['notify_email'];
                $mail->AddAddress($booking_details['email']);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = $_POST['subject'] ?? '';
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($_POST['message'] ?? '');
                if (!empty($invoice)) {
                    $invoice_id = $invoice[0]['id'];
                    if (is_file(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . ($_GET['id'] ?? '') . '_invoice_' . $invoice_id . '.pdf')) {
                        $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . ($_GET['id'] ?? '') . '_invoice_' . $invoice_id . '.pdf'); // attachment
                    }
                }
                $mail->IsHTML(true); // send as HTML
                $mail->Send();
            } catch (PHPMailerException $e) {
                //echo $e->errorMessage();
            }

            $_SESSION['status'] = '28';

            Util::redirect(INSTALL_URL . "Booking/index");
        }

        $replacement = array();
        $replacement['id'] = $booking_details['id'];
        //$replacement['id'] = $booking_details['booking_number'];
        // $replacement['location'] = $booking_details['location'];
        
        $bookingLocation = "" ;
      if(  $booking_details['location'] == "inside")
      {
        $bookingLocation = "Inside Durgabari" ;
      }

      else if(  $booking_details['location'] == "outside")
      {
        $bookingLocation = "Outside Durgabari" ;
      }

      else if(  $booking_details['location'] == "outsidewholeday")
      {
        $bookingLocation = "Outside Durgabari / Whole day" ;
      }
       else if(  $booking_details['location'] == "wholeday")
      {
        $bookingLocation = "Out of town / Whole day" ;
      }

      else
      {
        // $bookingLocation  = $booking_details['location'];
         $location_arr = __('location_arr');
        $bookingLocation = $location_arr[$booking_details['location']];
      }
       
        $replacement['first_name'] = $booking_details['first_name'];
        $replacement['second_name'] = $booking_details['second_name'];
        $replacement['phone'] = $booking_details['phone'];
        $replacement['email'] = $booking_details['email'];
       // $replacement['company'] = $booking_details['company'];
          $replacement['company'] = $booking_details['transaction_id'];
        $replacement['address_1'] = $booking_details['address_1'];
        $replacement['address_2'] = $booking_details['address_2'];
        $replacement['city'] = $booking_details['city'];
        $replacement['state'] = $booking_details['state'];
        $replacement['zip'] = $booking_details['zip'];
        $replacement['country'] = $booking_details['country'];
        $replacement['fax'] = $booking_details['fax'];
        $replacement['male'] = $booking_details['male'] ?? '';
        $replacement['additional'] = $booking_details['additional'];
        $replacement['calendars'] = $booking_details['calendar'];
        $replacement['cc_type'] = $booking_details['cc_type'];
        $replacement['cc_num'] = $booking_details['cc_num'];
        $replacement['cc_code'] = $booking_details['cc_code'];
        $replacement['cc_exp_month'] = $booking_details['cc_exp_month'];
        $replacement['cc_exp_year'] = $booking_details['cc_exp_year'];
        $location_arr = __('location_arr');
        // $replacement['location'] = $location_arr[$booking_details['location']];
        $replacement['location'] =  $bookingLocation;
        $replacement['title'] = $booking_details['promo_code'];
        $replacement['transaction_id'] = $booking_details['transaction_id'];
        $payment_method = __('payment_method_arr');
        
        $replacement['payment_method'] = $payment_method[$booking_details['payment_method']];
        $replacement['deposit'] = $booking_details['deposit'];
        $replacement['tax'] = $booking_details['booking_number'];
        $replacement['total'] = $booking_details['total'];
        $replacement['calendars_price'] = $booking_details['calendars_price'];
        $replacement['discount'] = $booking_details['discount'];
        $replacement['slots'] = implode(', ', $booking_details['slots']);

        switch ($booking_details['status']) {
            case 'pending':
                $client_message = Util::replaceToken($option_arr['client_create_email_booking'], $replacement);
                $client_subjetc = $option_arr['client_create_subject_booking'];
                $client_to = $booking_details['email'];

                $admin_message = Util::replaceToken($option_arr['admin_create_email_booking'], $replacement);
                $admin_subjetc = $option_arr['admin_create_subject_booking'];
                $admin_to = $option_arr['notify_email'];

                break;
            case 'confirmed':
                $client_message = Util::replaceToken($option_arr['client_confirmation_email_booking'], $replacement);
                $client_subjetc = $option_arr['client_confirmation_subject_booking'];
                $client_to = $booking_details['email'];

                $admin_message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                $admin_subjetc = $option_arr['admin_confirmation_subject_booking'];
                $admin_to = $option_arr['notify_email'];

                break;
            case 'cancelled':
                $client_message = Util::replaceToken($option_arr['client_cancellation_email_booking'], $replacement);
                $client_subjetc = $option_arr['client_cancellation_subject_booking'];
                $client_to = $booking_details['email'];

                $admin_message = Util::replaceToken($option_arr['admin_cancellation_email_booking'], $replacement);
                $admin_subjetc = $option_arr['admin_cancellation_subject_booking'];
                $admin_to = $option_arr['notify_email'];

                break;
        }

        $this->tpl['message'] = $client_message;
        $this->tpl['subjetc'] = $client_subjetc;
    }

    function export() {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Booking', 'BookingSlot'));
        $BookingModel = new BookingModel();
        $BookingSlotModel = new BookingSlotModel();

        $output = "";

        $query = $BookingModel->from($BookingModel->getTable());

        $bookings = $query->fetchAll();

        $query = $BookingModel->from($BookingSlotModel->getTable());

        $slots = $query->fetchAll();

        if (empty($bookings)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

        foreach ($bookings[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        
        foreach ($slots[0] as $k => $v) {
            if($k != 'id' && $k != 'calendar_id' && $k != 'booking_id'){
                $output .= '"' . $k . '",';
            }
        }
        $output .="\n";

        foreach ($bookings as $key => $value) {
            
            $opts = array();
            $opts['booking_id'] = $value['id'];
            $slots = $BookingSlotModel->getAll($opts);
            
            foreach ($value as $k => $v) {
                if($k == 'date'){
                    $output .='"' . date("Y-m-d H:i", $v) . '",';
                }else{
                    $output .='"' . $v . '",';
                }
            }
            foreach($slots as $slot){
                foreach($slot as $k => $s){
                    if($k != 'id' && $k != 'calendar_id' && $k != 'booking_id'){
                        if($k == 'timestamp'){
                            $output .='"' . date("Y-m-d H:i", $s) . '",';
                        }else{
                            $output .='"' . $s . '",';
                        }
                    }
                }
            }
            $output .="\n";
        }

        $filename = "booking_" . time() . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }

    function import() {

        if (!empty($_POST['import'])) {

            if (!empty($_FILES['csv_file'])) {

                $filename = time() . '_' . $_FILES['csv_file']['name'];

                $path = INSTALL_PATH . UPLOAD_PATH . 'csv/' . $filename;

                $this->tpl['booking_arr'] = array();

                if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $path)) {

                    $row = 0;
                    if (($handle = fopen($path, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ",", '"', '\\')) !== FALSE) {
                            $num = count($data);
                            if (!empty($num) && $num > 1 && !empty($data)) {
                                if ($data[0] != 'id') {
                                    $row++;

                                    $this->tpl['booking_arr'][$row] = array();

                                    for ($c = 0; $c < $num; $c++) {
                                        $this->tpl['booking_arr'][$row][] = $data[$c];
                                    }
                                } else {
                                    continue;
                                }
                            }
                        }
                        fclose($handle);
                    }
                    $this->tpl['row_count'] = $row;
                }
                
            }
        } elseif (!empty($_POST['save'])) {

            if (!empty($_POST['calendar_id'])) {

                GzObject::loadFiles('Model', array('Booking', 'BookingSlot'));
                $BookingModel = new BookingModel();
                $BookingSlotModel = new BookingSlotModel();

                foreach (($_POST['id'] ?? []) as $k => $v) {
                    $data = array();

                    $data['calendar_id'] = $_POST['calendar_id'][$k];
                    $data['booking_number'] = $_POST['booking_number'][$k];
                    $data['title'] = $_POST['title'][$k];
                    $data['first_name'] = $_POST['first_name'][$k];
                    $data['second_name'] = $_POST['second_name'][$k];
                    $data['phone'] = $_POST['phone'][$k];
                    $data['email'] = $_POST['email'][$k];
                    $data['company'] = $_POST['company'][$k];
                    $data['address_1'] = $_POST['address_1'][$k];
                    $data['address_2'] = $_POST['address_2'][$k];
                    $data['state'] = $_POST['state'][$k];
                    $data['city'] = $_POST['city'][$k];
                    $data['zip'] = $_POST['zip'][$k];
                    $data['country'] = $_POST['country'][$k];
                    $data['fax'] = $_POST['fax'][$k];
                    $data['male'] = $_POST['male'][$k];
                    $data['additional'] = $_POST['additional'][$k];
                    $data['promo_code'] = $_POST['promo_code'][$k];
                    $data['status'] = $_POST['status'][$k];
                    $data['calendars_price'] = $_POST['calendars_price'][$k];
                    $data['amount'] = $_POST['amount'][$k];
                    $data['discount'] = $_POST['discount'][$k];
                    $data['total'] = $_POST['total'][$k];
                    $data['tax'] = $_POST['tax'][$k];
                    $data['security'] = $_POST['security'][$k];
                    $data['payment_method'] = $_POST['payment_method'][$k];
                    $data['cc_type'] = $_POST['cc_type'][$k];
                    $data['cc_num'] = $_POST['cc_num'][$k];
                    $data['cc_code'] = $_POST['cc_code'][$k];
                    $data['cc_exp_month'] = $_POST['cc_exp_month'][$k];
                    $data['cc_exp_year'] = $_POST['cc_exp_year'][$k];
                    $data['date'] = strtotime($_POST['date'][$k]);

                    $id = $BookingModel->save($data);
                    
                    if(!empty($_POST['timestamp'][$v])){
                        foreach (($_POST['timestamp'][$v] ?? []) as $key => $value) {
                            $data = array();
                            $data['calendar_id'] = $_POST['calendar_id'][$k];
                            $data['booking_id'] = $id;
                            $data['timestamp'] = strtotime($value);
                            $data['count'] = $_POST['count'][$v][$key];
                            $data['timecreated'] = time();

                            $BookingSlotModel->save($data);
                        }
                    }
                }
                $status = 30;
                $_SESSION['status'] = $status;
                
                Util::redirect(INSTALL_URL . "Booking/index");
            }
        }
    }

    function getSlots() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('TimePrice', 'BookingSlot', 'CustomDate', 'CustomDate', 'Booking'));
        $TimePriceModel = new TimePriceModel();
        $BookingSlotModel = new BookingSlotModel();
        $CustomDateModel = new CustomDateModel();
        $BookingModel = new BookingModel();
        
        $date = Util::dateToTimestamp($this->tpl['option_arr_values']['date_format'], $_POST['date']);
        
        $opts = array();
        $opts[':timestamp BETWEEN timestamp AND timestamp_end AND calendar_id = :calendar_id'] = array(':timestamp' => $date, ':calendar_id' => ($_POST['calendar_id'] ?? ''));
        $custom_dates = $CustomDateModel->getAll($opts);
        
        if (!empty($custom_dates[0])) {
            $this->tpl['custom_dates'] = $custom_dates[0];
        }

        $opts = array();
        $opts['calendar_id'] = $_POST['calendar_id'] ?? '';
        $working_times = $TimePriceModel->getAll($opts, 'id');
        
        $from = $date - 86400;
        $to = $date + 86400;
        
        $before = time() - 5 * 60;
        
        $cal_id = (int) $_POST['calendar_id'];
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
        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }
    }

    function removeTimeSlot() {
        $this->isAjax = true;

        unset($_SESSION[$this->default_product]['admin']['slots'][$_REQUEST['cid'] ?? ''][$_POST['slot'] ?? '']);
    }

    function addTimeSlot() {
        $this->isAjax = true;

        $_SESSION[$this->default_product]['admin']['slots'][$_REQUEST['cid'] ?? ''][$_POST['slot'] ?? ''] = $_POST['count'] ?? '';
    }

    function getSlotsTable() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('TimePrice', 'CustomDate'));
        $TimePriceModel = new TimePriceModel();
        $CustomDateModel = new CustomDateModel();
        
        $opts = array();
        $opts['calendar_id'] = $_POST['calendar_id'] ?? '';
        $custom_dates = $CustomDateModel->getAll($opts);
        
        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for($i = $v['timestamp']; $i <= $v['timestamp_end']; $i+=86400){
                    $this->tpl['custom_dates'][mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $opts = array();

        $opts['calendar_id'] = $_POST['calendar_id'] ?? '';
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }
    }

}

?>


