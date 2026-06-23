<?php

require_once FRAMEWORK_PATH . 'Controller.class.php';
require __DIR__ . '/Twillio/vendor/autoload.php';

use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class AppRental extends Controller
{

    var $models = array();

    function __construct()
    {


        GzObject::loadFiles('Model', array('Languages', 'Local'));

        $LanguagesModel = new LanguagesModel();

        $LocalModel = new LocalModel();



        $this->tpl['languages'] = $LanguagesModel->getAll(null, 'order');



        foreach ($this->tpl['languages'] as $k => $v) {

            $this->tpl['local'][$v['id']] = $LocalModel->getAll(array('language_id' => $v['id']));
        }



        $default_language = $LanguagesModel->getAll(array('isdefault' => 1), 'order');

        $select_language = $this->getLanguage();



        $language = $select_language ? $LanguagesModel->getAll(array('id' => $select_language['id']), 'order') : [];



        if (empty($language)) {

            $this->setLanguage($default_language[0]);
        }



        $this->tpl['default_language'] = $default_language[0];



        GzObject::loadFiles('Model', 'Option');

        $OptionModel = new OptionModel();



        $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues();

        $tz = $this->tpl['option_arr_values']['timezone'] ?? '';
        if ($tz) {
            date_default_timezone_set($tz);
        }
    }

    function isUser()
    {

        return $this->getRoleId() == 2;
    }

    function calclateBookingPrice($params, $session = array())
    {

        if (empty($session)) {

            $session = $_SESSION[$this->default_product]['slots'][$params['calendar_id']];
        }

        GzObject::loadFiles('Model', array('TimePrice', 'Calendar', 'Option', 'CustomPrice', 'Discount', 'CustomDate'));

        $TimePriceModel = new TimePriceModel();

        $OptionModel = new OptionModel();

        $CustomDateModel = new CustomDateModel();

        $CustomPriceModel = new CustomPriceModel();

        $DiscountModel = new DiscountModel();



        $option_arr = $OptionModel->getAllPairValues(array('calendar_id' => $params['calendar_id']));



        $result = array('calendars_price' => 0, 'discount' => 0, 'total' => 0, 'tax' => 0, 'security' => 0, 'deposit' => 0, 'formated_calendars_price' => Util::currenctFormat($option_arr['currency'], 0), 'formated_discount' => Util::currenctFormat($option_arr['currency'], 0), 'formated_total' => Util::currenctFormat($option_arr['currency'], 0), 'formated_tax' => Util::currenctFormat($option_arr['currency'], 0), 'formated_security' => Util::currenctFormat($option_arr['currency'], 0), 'formated_deposit' => Util::currenctFormat($option_arr['currency'], 0));

        if (empty($params['calendar_id'])) {

            return $result;
        }



        $opts = array();

        $opts['calendar_id'] = $params['calendar_id'];

        $custom_dates = $CustomDateModel->getAll($opts);



        if (!empty($custom_dates)) {

            foreach ($custom_dates as $k => $v) {

                for ($i = $v['timestamp']; $i <= $v['timestamp_end']; $i += 86400) {

                    $custom_dates[mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }



        $opts = array();

        $opts['calendar_id'] = $params['calendar_id'];

        $custom_prices_arr = $CustomPriceModel->getAll($opts);



        $custom_prices = array();

        if (!empty($custom_prices_arr)) {

            foreach ($custom_prices_arr as $key => $value) {

                $custom_prices[$value['day']][date('h:i', $value['start_timestamp'])] = $value;
            }
        }



        $opts = array();

        $opts['id'] = $params['calendar_id'];



        $id = $params['calendar_id'];



        //search for price that match with adults and children 

        $arr = $TimePriceModel->getPrices($params, $id);



        if (empty($arr) || count($arr) == 0) {

            //search for default price if not price that match with adults and children 



            $arr = $TimePriceModel->getDefaultPrices($id);
        }



        $price = 0;



        foreach ($session as $i => $count) {

            if ($count > 0) {

                $date = strtotime(date("Y-m-d", $i));



                if (!empty($custom_dates[$date])) {

                    $price += $custom_dates[$date]['price'] * $count;
                } else {



                    switch (date('N', $i)) {

                        case 1:

                            if (!empty($custom_prices[1][date('h:i', $i)])) {

                                $price += $custom_prices[1][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['monday_price'] * $count;
                            }

                            break;

                        case 2:

                            if (!empty($custom_prices[2][date('h:i', $i)])) {

                                $price += $custom_prices[2][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['tuesday_price'] * $count;
                            }

                            break;

                        case 3:

                            if (!empty($custom_prices[3][date('h:i', $i)])) {

                                $price += $custom_prices[3][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['wednesday_price'] * $count;
                            }

                            break;

                        case 4:

                            if (!empty($custom_prices[4][date('h:i', $i)])) {

                                $price += $custom_prices[4][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['thursday_price'] * $count;
                            }

                            break;

                        case 5:

                            if (!empty($custom_prices[5][date('h:i', $i)])) {

                                $price += $custom_prices[5][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['friday_price'] * $count;
                            }

                            break;

                        case 6:

                            if (!empty($custom_prices[6][date('h:i', $i)])) {

                                $price += $custom_prices[6][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['saturday_price'] * $count;
                            }

                            break;

                        case 7:

                            if (!empty($custom_prices[7][date('h:i', $i)])) {

                                $price += $custom_prices[7][date('h:i', $i)]['price'];
                            } else {

                                $price += $arr['sunday_price'] * $count;
                            }

                            break;
                    }
                }
            }
        }



        if (empty($price) && (!empty($_POST['Puja']) || !empty($_POST['Puja2']))) {



            $slot_price = 0;



            if (($_POST['location'] ?? '') == 'inside' || ($_POST['location'] ?? '') == "online") {

                $_POST['Puja'] = floatval($_POST['Puja'] ?? 0);

                $slot_price = $_POST['Puja'] ?? '';
            } else {

                $_POST['Puja2'] = floatval($_POST['Puja2'] ?? 0);

                $slot_price = $_POST['Puja2'] ?? '';
            }



            foreach ($session as $i => $count) {

                if ($count > 0) {

                    $price += $slot_price * $count;
                }
            }
        }





        $result['calendars_price'] = $price;

        $result['total'] = $price;



        if (!empty($params['promo_code'])) {

            $opts = array();

            $opts['t1.promo_code'] = $params['promo_code'];

            $opts['t1.calendar_id'] = $params['calendar_id'];



            $discount_arr = $DiscountModel->getAll($opts);
        }



        if (!empty($discount_arr) && count($discount_arr) > 0) {



            $discount = $discount_arr[0];



            switch ($discount['type']) {

                case 'price':

                    $result['discount'] = $discount['discount'];



                    break;

                case 'percent':

                    $result['discount'] = $result['total'] * $discount['discount'] / 100;

                    break;
            }



            if ($result['total'] > $result['discount']) {

                $result['total'] -= $result['discount'];
            } else {

                $result['discount'] = 0;
            }
        }



        if (!empty($option_arr['tax'])) {

            switch ($option_arr['tax_type']) {

                case 'price':

                    $result['tax'] = $option_arr['tax'];

                    $result['total'] = $result['total'] + $result['tax'];

                    break;

                case 'percent':

                    $result['tax'] = ($result['total'] * $option_arr['tax']) / 100;

                    $result['total'] = $result['total'] + $result['tax'];

                    break;
            }
        }



        if (!empty($option_arr['deposit'])) {

            switch ($option_arr['deposit_type']) {

                case 'price':

                    $result['deposit'] = $option_arr['deposit'];

                    break;

                case 'percent':

                    $result['deposit'] = ($result['total'] * $option_arr['deposit']) / 100;

                    break;
            }
        }



        if (empty($result['calendars_price']) && !empty($_POST['calendars_price']) && ($_POST['create_booking'] || $_POST['edit_booking'])) {

            $result['calendars_price'] = $_POST['calendars_price'] ?? '';

            $result['total'] = $result['calendars_price'];
        }



        $result['formated_discount'] = Util::currenctFormat($option_arr['currency'], $result['discount']);

        $result['formated_deposit'] = Util::currenctFormat($option_arr['currency'], $result['deposit']);

        $result['formated_total'] = Util::currenctFormat($option_arr['currency'], $result['total']);

        $result['formated_calendars_price'] = Util::currenctFormat($option_arr['currency'], $result['calendars_price']);

        $result['formated_tax'] = Util::currenctFormat($option_arr['currency'], $result['tax']);;


        return $result;
    }


    function sendBookingEmailsNew_for_testing($id, $type, $group, $email, $mobileno, $Date, $loc, $stime, $etime, $h, $address_1, $msg, $invoiceid)
    {
        // 🔹 Create /logs folder dynamically (if not exists)
        $logDir = __DIR__ . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        // 🔹 Daily rotating log file (e.g., rental_mail_debug_2025-11-04.txt)
        $logFile = $logDir . '/rental_mail_debug_' . date('Y-m-d') . '.txt';

        // 🔹 Start log entry
        file_put_contents($logFile, "---- New Mail Triggered: " . date('Y-m-d H:i:s') . " ----\n", FILE_APPEND);
        file_put_contents($logFile, "Booking ID: $id | Type: $type | Group: $group | Email: $email\n", FILE_APPEND);

        GzObject::loadFiles('Model', array('Option', 'RentalBooking', 'Rentalinvoice'));
        $OptionModel = new OptionModel();
        $RentalBookingModel = new RentalBookingModel();
        $RentalinvoiceModel = new RentalinvoiceModel();

        $booking_details = $RentalBookingModel->getBookingDetails($id);

        $opts = array();
        $opts['calendar_id'] = $booking_details['calendar_id'];
        $option_arr = $OptionModel->getAllPairValues($opts);

        $opts = array();
        $opts['booking_id'] = $id;
        $invoice = $RentalinvoiceModel->getinvoice($invoiceid);

        $replacement = array();
        $replacement['id'] = $booking_details['id'];
        $prevlocation = $booking_details['location'];
        if ($prevlocation == 'Both') {
            $location = 'Auditorium & Kalabhavan';
        } else {
            $location = $booking_details['location'];
        }
        $replacement['location'] = $location;
        $replacement['first_name'] = $booking_details['first_name'];
        $replacement['second_name'] = $booking_details['second_name'];
        $replacement['phone'] = $booking_details['phone'];
        $replacement['email'] = $booking_details['email'];
        $replacement['company'] = $booking_details['oid'];
        $replacement['address_1'] = $booking_details['address_1'];
        $replacement['address_2'] = $booking_details['address_2'];
        $replacement['city'] = $booking_details['city'];
        $replacement['state'] = $booking_details['state'];
        $replacement['zip'] = $booking_details['zip'];
        $replacement['country'] = $booking_details['country'];
        $replacement['fax'] = $booking_details['fax'] ?? null;
        $replacement['male'] = $booking_details['male'] ?? null;
        $replacement['additional'] = $booking_details['additional'] ?? null;
        $replacement['nights'] = $booking_details['nights'] ?? null;
        $replacement['date_from'] = $booking_details['date_from'] ?? null;
        $replacement['date_to'] = $booking_details['date_to'] ?? null;
        $replacement['calendars'] = $booking_details['calendar'] ?? null;
        $replacement['cc_type'] = $msg;
        $replacement['cc_num'] = $booking_details['cc_num'] ?? null;
        $replacement['cc_code'] = $booking_details['cc_code'] ?? null;
        $replacement['cc_exp_month'] = $booking_details['cc_exp_month'] ?? null;
        $replacement['cc_exp_year'] = $booking_details['cc_exp_year'] ?? null;

        $paymentmethod = $booking_details['payment_method'] ?? '';
        if ($paymentmethod == "stripe") {
            $replacement['payment_method'] = 'Credit Card';
        } else if ($paymentmethod == "others") {
            $replacement['payment_method'] = 'Zelle';
        } else if ($paymentmethod == "cash") {
            $replacement['payment_method'] = 'Cash';
        } else if ($paymentmethod == "check") {
            $replacement['payment_method'] = 'Check';
        } else if ($paymentmethod == "directdeposit") {
            $replacement['payment_method'] = 'Direct Deposit';
        }
        $replacement['tax'] = $booking_details['booking_number'];
        $sign = '<span style="color:red;">$</span>';
        $replacement['total'] = $sign . '' . $booking_details['amount'];
        $replacement['deposit'] = $sign . '' . $booking_details['advanceamount'];
        $replacement['calendars_price'] = $booking_details['calendars_price'];
        $replacement['extra_price'] = $booking_details['extra_price'] ?? null;
        $replacement['discount'] = $booking_details['discount'];
        $location_arr = __('location_arr');
        $replacement['title'] = $booking_details['promo_code'];
        $replacement['transaction_id'] = $booking_details['transaction_id'];
        $dmyydate = $booking_details['finalDate'];
        $timestamp = strtotime($dmyydate);
        $finaluidate = date("m/d/Y", $timestamp);
        $replacement['slots'] = $finaluidate . ' - ' . $invoice['startendtime'] . ' - ' . $invoice['hours'];
        $rawDate = $booking_details['date'] ?? '';
        $replacement['create_date'] = date($this->tpl['option_arr_values']['date_format'], is_numeric($rawDate) ? (int)$rawDate : (strtotime($rawDate) ?: time()));

        switch ($type) {
            case 'create':
                switch ($group) {
                    case 'Rental Client':
                        $message = Util::replaceToken($option_arr['client_create_email_booking'], $replacement);
                        $subjetc = $option_arr['client_create_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'Rental Admin':
                        $message = Util::replaceToken($option_arr['admin_create_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_create_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'confirmation':
                switch ($group) {
                    case 'Rental Client':
                        $message = Util::replaceToken($option_arr['client_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_confirmation_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'Rental Admin':
                        $message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_confirmation_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                    case 'Education Admin':
                        $message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_confirmation_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'cancellation':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_cancellation_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_cancellation_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;


            case 'pending':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_cancellation_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_cancellation_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
        }

        try {
            file_put_contents($logFile, "Preparing email to send...\n", FILE_APPEND);

            $from_name = "HDBS Durgabari";
            $from_address = "hdbs.payment@durgabari.org";
            // $to_name = $email;
            // $to_address = $email;


            $to_name = "varunkumar953685@gmail.com";
            $to_address = "varunkumar953685@gmail.com";



            $startTime = $Date . $stime;
            $endTime = $Date . $etime;
            $subject = "Rental Reservations";
            $description = $msg;
            $location = $loc;
            $domain = INSTALL_URL . 'Rental/index';
            $mail = new PHPMailer(true);

            $mail->AddReplyTo($option_arr['notify_email'] ?? '', "Admin");
            $mail->From = $option_arr['notify_email'] ?? '';
            $mail->FromName = $option_arr['notify_email'] ?? '';
            // $mail->AddCC('rental@durgabari.org');

            $mail->AddCC('varunkumar953685@gmail.com');

            // Event calendar data (unchanged)
            $ical = 'BEGIN:VCALENDAR' . "\r\n" .
                // ... (same as original)
                'END:VCALENDAR' . "\r\n";

            $to = "varunkumar953685@gmail.com";
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress($to_address, $to_name);
            $mail->Subject = $subjetc;
            $mail->AddStringAttachment($ical, "meeting.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
            $mail->Ical = $ical;
            $mail->WordWrap = 80;
            $mail->MsgHTML($message);

            if (!empty($invoice)) {
                $invoice_id = $invoice['id'];
                $pdfPath = INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'Rentalbooking_' . $id . '_invoice_' . $invoice_id . '.pdf';
                if (is_file($pdfPath)) {
                    $mail->AddAttachment($pdfPath);
                    file_put_contents($logFile, "Invoice attached: $pdfPath\n", FILE_APPEND);
                } else {
                    file_put_contents($logFile, "Invoice file not found: $pdfPath\n", FILE_APPEND);
                }
            }

            $mail->IsHTML(true);
            $mail->Send();
            file_put_contents($logFile, "✅ Email sent successfully to: $to\n", FILE_APPEND);
        } catch (PHPMailerException $e) {
            file_put_contents($logFile, "❌ Mail sending failed: " . $e->errorMessage() . "\n", FILE_APPEND);
        } catch (Exception $ex) {
            file_put_contents($logFile, "❌ General Error: " . $ex->getMessage() . "\n", FILE_APPEND);
        }

        file_put_contents($logFile, "---- End ----\n\n", FILE_APPEND);
        return $invoice_id;
    }

    function sendBookingEmailsNew_4th_nov_2025_old($id, $type, $group, $email, $mobileno, $Date, $loc, $stime, $etime, $h, $address_1, $msg, $invoiceid)
    {

        GzObject::loadFiles('Model', array('Option', 'RentalBooking', 'Rentalinvoice'));
        $OptionModel = new OptionModel();
        $RentalBookingModel = new RentalBookingModel();
        $RentalinvoiceModel = new RentalinvoiceModel();

        $booking_details = $RentalBookingModel->getBookingDetails($id);

        $opts = array();
        $opts['calendar_id'] = $booking_details['calendar_id'];
        $option_arr = $OptionModel->getAllPairValues($opts);

        $opts = array();
        $opts['booking_id'] = $id;
        //$opts['booking_id'] = $booking_details['booking_number'];;
        //$invoice = $RentalinvoiceModel->getAll($opts);
        $invoice = $RentalinvoiceModel->getinvoice($invoiceid);
        //$bookingslothours = $invoice[0]['hours'];
        $replacement = array();
        $replacement['id'] = $booking_details['id'];
        //$replacement['id'] = $booking_details['booking_number'];
        $prevlocation = $booking_details['location'];
        if ($prevlocation == 'Both') {
            $location = 'Auditorium & Kalabhavan';
        } else {
            $location = $booking_details['location'];
        }
        $replacement['location'] = $location;
        //$replacement['title'] = $booking_details['title'];
        $replacement['first_name'] = $booking_details['first_name'];
        $replacement['second_name'] = $booking_details['second_name'];
        $replacement['phone'] = $booking_details['phone'];
        $replacement['email'] = $booking_details['email'];
        // $replacement['company'] = $booking_details['company'];
        //$replacement['company'] = $booking_details['transaction_id'];
        $replacement['company'] = $booking_details['oid'];
        $replacement['address_1'] = $booking_details['address_1'];
        $replacement['address_2'] = $booking_details['address_2'];
        $replacement['city'] = $booking_details['city'];
        $replacement['state'] = $booking_details['state'];
        $replacement['zip'] = $booking_details['zip'];
        $replacement['country'] = $booking_details['country'];
        $replacement['fax'] = $booking_details['fax'] ?? null;
        $replacement['male'] = $booking_details['male'] ?? null;
        $replacement['additional'] = $booking_details['additional'] ?? null;
        $replacement['nights'] = $booking_details['nights'] ?? null;
        $replacement['date_from'] = $booking_details['date_from'] ?? null;
        $replacement['date_to'] = $booking_details['date_to'] ?? null;
        $replacement['calendars'] = $booking_details['calendar'] ?? null;
        $replacement['cc_type'] = $msg;
        $replacement['cc_num'] = $booking_details['cc_num'] ?? null;
        $replacement['cc_code'] = $booking_details['cc_code'] ?? null;
        $replacement['cc_exp_month'] = $booking_details['cc_exp_month'] ?? null;
        $replacement['cc_exp_year'] = $booking_details['cc_exp_year'] ?? null;

        // $payment_method = __('payment_method_arr');
        // $replacement['payment_method'] = $payment_method[$booking_details['payment_method']];
        $paymentmethod = $booking_details['payment_method'] ?? '';
        if ($paymentmethod == "stripe") {
            $replacement['payment_method'] = 'Credit Card';
        } else if ($paymentmethod == "others") {
            $replacement['payment_method'] = 'Zelle';
        } else if ($paymentmethod == "cash") {
            $replacement['payment_method'] = 'Cash';
        } else if ($paymentmethod == "check") {
            $replacement['payment_method'] = 'Check';
        } else if ($paymentmethod == "directdeposit") {
            $replacement['payment_method'] = 'Direct Deposit';
        }
        $replacement['tax'] = $booking_details['booking_number'];

        $sign = '<span style="color:red;">$</span>';
        $replacement['total'] = $sign . '' . $booking_details['amount'];
        //$replacement['deposit'] = $booking_details['deposit'];
        $replacement['deposit'] = $sign . '' . $booking_details['advanceamount'];
        $replacement['calendars_price'] = $booking_details['calendars_price'];
        $replacement['extra_price'] = $booking_details['extra_price'] ?? null;
        $replacement['discount'] = $booking_details['discount'];
        $location_arr = __('location_arr');
        $replacement['title'] = $booking_details['promo_code'];
        // $replacement['location'] = $location_arr[$booking_details['location']];
        $replacement['transaction_id'] = $booking_details['transaction_id'];
        //$replacement['slots'] = implode(', ', $booking_details['slots']);
        $dmyydate =  $booking_details['finalDate'];
        $timestamp = strtotime($dmyydate);
        $finaluidate = date("m/d/Y", $timestamp);
        $replacement['slots'] = $finaluidate . ' - ' . $invoice['startendtime'] . ' - ' . $invoice['hours'];
        $rawDate = $booking_details['date'] ?? '';
        $replacement['create_date'] = date($this->tpl['option_arr_values']['date_format'], is_numeric($rawDate) ? (int)$rawDate : (strtotime($rawDate) ?: time()));

        switch ($type) {
            case 'create':
                switch ($group) {
                    case 'Rental Client':
                        $message = Util::replaceToken($option_arr['client_create_email_booking'], $replacement);
                        $subjetc = $option_arr['client_create_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'Rental Admin':
                        $message = Util::replaceToken($option_arr['admin_create_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_create_subject_booking'];
                        //$to = 'paras.sharma@eiceinternational.com';
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'confirmation':
                switch ($group) {
                    case 'Rental Client':
                        $message = Util::replaceToken($option_arr['client_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_confirmation_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'Rental Admin':
                        $message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_confirmation_subject_booking'];
                        //$to = $option_arr['notify_email']." , "; $to .= 'paras.kaka2@gmail.com';
                        $to = $option_arr['notify_email'];
                        break;
                    case 'Education Admin':
                        $message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_confirmation_subject_booking'];
                        //$to = 'paras.sharma@eiceinternational.com';
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'cancellation':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_cancellation_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_cancellation_subject_booking'];
                        // $to = 'paras.sharma@eiceinternational.com';
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
        }
        try {



            // event params
            $from_name = "HDBS Durgabari";
            $from_address = "hdbs.payment@durgabari.org";
            $to_name = $email;
            $to_address = $email;
            $startTime = $Date . $stime;
            $endTime = $Date . $etime;
            $subject = "Rental Reservations";
            $description = $msg;
            $location = $loc;
            $domain = INSTALL_URL . 'Rental/index';
            $mail = new PHPMailer(true); //New instance, with exceptions enabled
            //$mail->isSMTP();
            //$mail->SMTPDebug = 0;  // tell the class to use Sendmail
            $mail->AddReplyTo($option_arr['notify_email'] ?? '', "Admin");
            $mail->From = $option_arr['notify_email'] ?? '';
            $mail->FromName = $option_arr['notify_email'] ?? '';
            $mail->AddCC('varunkumar953685@gmail.com');


            //$mail->ContentType = 'text/calendar';

            //$mail->addCustomHeader('MIME-version',"1.0");
            //$mail->addCustomHeader('Content-type',"text/calendar; name=event.ics; method=REQUEST; charset=UTF-8;");
            //$mail->addCustomHeader('Content-type',"text/html; charset=UTF-8");
            //$mail->addCustomHeader('Content-Transfer-Encoding',"7bit");
            //$mail->addCustomHeader('X-Mailer',"Microsoft Office Outlook 12.0");
            //$mail->addCustomHeader("Content-class: urn:content-classes:calendarmessage");


            //Event setting
            $ical = 'BEGIN:VCALENDAR' . "\r\n" .
                'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
                'VERSION:2.0' . "\r\n" .
                'METHOD:REQUEST' . "\r\n" .
                'BEGIN:VTIMEZONE' . "\r\n" .
                'TZID:Eastern Time' . "\r\n" .
                'BEGIN:STANDARD' . "\r\n" .
                'DTSTART:20091101T020000' . "\r\n" .
                'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
                'TZOFFSETFROM:-0400' . "\r\n" .
                'TZOFFSETTO:-0500' . "\r\n" .
                'TZNAME:EST' . "\r\n" .
                'END:STANDARD' . "\r\n" .
                'BEGIN:DAYLIGHT' . "\r\n" .
                'DTSTART:20090301T020000' . "\r\n" .
                'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3' . "\r\n" .
                'TZOFFSETFROM:-0500' . "\r\n" .
                'TZOFFSETTO:-0400' . "\r\n" .
                'TZNAME:EDST' . "\r\n" .
                'END:DAYLIGHT' . "\r\n" .
                'END:VTIMEZONE' . "\r\n" .
                'BEGIN:VEVENT' . "\r\n" .
                'ORGANIZER;CN="' . $from_name . '":MAILTO:' . $from_address . "\r\n" .
                'ATTENDEE;CN="' . $to_name . '";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:' . $to_address . "\r\n" .
                'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
                'UID:' . date("Ymd\TGis", strtotime($startTime)) . random_int(0, PHP_INT_MAX) . "@" . $domain . "\r\n" .
                'DTSTAMP:' . date("Ymd\TGis") . "\r\n" .
                'DTSTART;TZID="America/Chicago":' . date("Ymd\THis", strtotime($startTime)) . "\r\n" .
                'DTEND;TZID="America/Chicago":' . date("Ymd\THis", strtotime($endTime)) . "\r\n" .
                'TRANSP:OPAQUE' . "\r\n" .
                'SEQUENCE:1' . "\r\n" .
                'SUMMARY:' . $subject . "\r\n" .
                'LOCATION:' . $location . "\r\n" .
                'CLASS:PUBLIC' . "\r\n" .
                'PRIORITY:5' . "\r\n" .
                'BEGIN:VALARM' . "\r\n" .
                'TRIGGER:-PT15M' . "\r\n" .
                'ACTION:DISPLAY' . "\r\n" .
                'DESCRIPTION:Reminder' . "\r\n" .
                'END:VALARM' . "\r\n" .
                'END:VEVENT' . "\r\n" .
                'END:VCALENDAR' . "\r\n";
            // $message1 .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
            // $message1 .= "Content-Transfer-Encoding: 8bit\n\n";
            // $message1 .= $ical;

            $mail->CharSet = 'UTF-8';
            $mail->AddAddress($to_address, $to_name);
            $mail->Subject = $subjetc;
            $mail->AddStringAttachment($ical, "meeting.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->Ical = $ical;
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            //$mail->Body = $ical;
            if (!empty($invoice)) {
                $invoice_id = $invoice['id'];
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'Rentalbooking_' . $id . '_invoice_' . $invoice_id . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'Rentalbooking_' . $id . '_invoice_' . $invoice_id . '.pdf');
                    //$mail->addAttachment('meeting.ics');   // attachment
                }
            }

            $mail->IsHTML(true); // send as HTML

            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
        return $invoice_id;
        // try {
        //     $mail = new PHPMailer(true); //New instance, with exceptions enabled
        //     //$mail->IsSendmail();  // tell the class to use Sendmail
        //     $mail->AddReplyTo($option_arr['notify_email'], "Admin");
        //     $mail->From = $option_arr['notify_email'];
        //     $mail->FromName = $option_arr['notify_email'];
        //     $mail->CharSet = 'UTF-8';
        //     $mail->AddAddress($to);
        //     $mail->Subject = $subjetc;
        //     $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        //     $mail->WordWrap = 80; // set word wrap
        //     $mail->MsgHTML($message);

        //     if (!empty($invoice)) {
        //         $invoice_id = $invoice[0]['id'];
        //         if (is_file(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf')) {
        //             $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf'); // attachment
        //         }
        //     }

        //     $mail->IsHTML(true); // send as HTML

        //     $mail->Send();
        // } catch (PHPMailerException $e) {
        //     //echo $e->errorMessage();
        // }
        //  return $invoice_id;
    }

    function sendBookingEmailsNew($id, $type, $group, $email, $mobileno, $Date, $loc, $stime, $etime, $h, $address_1, $msg, $invoiceid)
    {
        // 🔹 Create /logs folder dynamically (if not exists)
        $logDir = __DIR__ . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        // 🔹 Daily rotating log file (e.g., rental_mail_debug_2025-11-04.txt)
        $logFile = $logDir . '/rental_mail_debug_' . date('Y-m-d') . '.txt';

        // 🔹 Start log entry
        file_put_contents($logFile, "---- New Mail Triggered: " . date('Y-m-d H:i:s') . " ----\n", FILE_APPEND);
        file_put_contents($logFile, "Booking ID: $id | Type: $type | Group: $group | Email: $email\n", FILE_APPEND);

        GzObject::loadFiles('Model', array('Option', 'RentalBooking', 'Rentalinvoice'));
        $OptionModel = new OptionModel();
        $RentalBookingModel = new RentalBookingModel();
        $RentalinvoiceModel = new RentalinvoiceModel();

        $booking_details = $RentalBookingModel->getBookingDetails($id);

        $opts = array();
        $opts['calendar_id'] = $booking_details['calendar_id'];
        $option_arr = $OptionModel->getAllPairValues($opts);

        $opts = array();
        $opts['booking_id'] = $id;
        $invoice = $RentalinvoiceModel->getinvoice($invoiceid);

        $replacement = array();
        $replacement['id'] = $booking_details['id'];
        $prevlocation = $booking_details['location'];
        if ($prevlocation == 'Both') {
            $location = 'Auditorium & Kalabhavan';
        } else {
            $location = $booking_details['location'];
        }
        $replacement['location'] = $location;
        $replacement['first_name'] = $booking_details['first_name'];
        $replacement['second_name'] = $booking_details['second_name'];
        $replacement['phone'] = $booking_details['phone'];
        $replacement['email'] = $booking_details['email'];
        $replacement['company'] = $booking_details['oid'];
        $replacement['address_1'] = $booking_details['address_1'];
        $replacement['address_2'] = $booking_details['address_2'];
        $replacement['city'] = $booking_details['city'];
        $replacement['state'] = $booking_details['state'];
        $replacement['zip'] = $booking_details['zip'];
        $replacement['country'] = $booking_details['country'];
        $replacement['fax'] = $booking_details['fax'] ?? null;
        $replacement['male'] = $booking_details['male'] ?? null;
        $replacement['additional'] = $booking_details['additional'] ?? null;
        $replacement['nights'] = $booking_details['nights'] ?? null;
        $replacement['date_from'] = $booking_details['date_from'] ?? null;
        $replacement['date_to'] = $booking_details['date_to'] ?? null;
        $replacement['calendars'] = $booking_details['calendar'] ?? null;
        $replacement['cc_type'] = $msg;
        $replacement['cc_num'] = $booking_details['cc_num'] ?? null;
        $replacement['cc_code'] = $booking_details['cc_code'] ?? null;
        $replacement['cc_exp_month'] = $booking_details['cc_exp_month'] ?? null;
        $replacement['cc_exp_year'] = $booking_details['cc_exp_year'] ?? null;

        $paymentmethod = $booking_details['payment_method'] ?? '';
        if ($paymentmethod == "stripe") {
            $replacement['payment_method'] = 'Credit Card';
        } else if ($paymentmethod == "others") {
            $replacement['payment_method'] = 'Zelle';
        } else if ($paymentmethod == "cash") {
            $replacement['payment_method'] = 'Cash';
        } else if ($paymentmethod == "check") {
            $replacement['payment_method'] = 'Check';
        } else if ($paymentmethod == "directdeposit") {
            $replacement['payment_method'] = 'Direct Deposit';
        }
        $replacement['tax'] = $booking_details['booking_number'];
        $sign = '<span style="color:red;">$</span>';
        $replacement['total'] = $sign . '' . $booking_details['amount'];
        $replacement['deposit'] = $sign . '' . $booking_details['advanceamount'];
        $replacement['calendars_price'] = $booking_details['calendars_price'];
        $replacement['extra_price'] = $booking_details['extra_price'] ?? null;
        $replacement['discount'] = $booking_details['discount'];
        $location_arr = __('location_arr');
        $replacement['title'] = $booking_details['promo_code'];
        $replacement['transaction_id'] = $booking_details['transaction_id'];
        $dmyydate = $booking_details['finalDate'];
        $timestamp = strtotime($dmyydate);
        $finaluidate = date("m/d/Y", $timestamp);
        $replacement['slots'] = $finaluidate . ' - ' . $invoice['startendtime'] . ' - ' . $invoice['hours'];
        $rawDate = $booking_details['date'] ?? '';
        $replacement['create_date'] = date($this->tpl['option_arr_values']['date_format'], is_numeric($rawDate) ? (int)$rawDate : (strtotime($rawDate) ?: time()));

        switch ($type) {
            case 'create':
                switch ($group) {
                    case 'Rental Client':
                        $message = Util::replaceToken($option_arr['client_create_email_booking'], $replacement);
                        $subjetc = $option_arr['client_create_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'Rental Admin':
                        $message = Util::replaceToken($option_arr['admin_create_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_create_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'confirmation':
                switch ($group) {
                    case 'Rental Client':
                        $message = Util::replaceToken($option_arr['client_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_confirmation_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'Rental Admin':
                        $message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_confirmation_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                    case 'Education Admin':
                        $message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_confirmation_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'cancellation':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_cancellation_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_cancellation_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
        }

        try {
            file_put_contents($logFile, "Preparing email to send...\n", FILE_APPEND);

            $from_name = "HDBS Durgabari";
            $from_address = "hdbs.payment@durgabari.org";
            $to_name = $email;
            $to_address = $email;
            $startTime = $Date . $stime;
            $endTime = $Date . $etime;
            $subject = "Rental Reservations";
            $description = $msg;
            $location = $loc;
            $domain = INSTALL_URL . 'Rental/index';
            $mail = new PHPMailer(true);

            $mail->AddReplyTo($option_arr['notify_email'] ?? '', "Admin");
            $mail->From = $option_arr['notify_email'] ?? '';
            $mail->FromName = $option_arr['notify_email'] ?? '';
            $mail->AddCC('varunkumar953685@gmail.com');
            $mail->AddBCC('varun.kumar@eicetechnology.com');

            // Event calendar data (unchanged)
            $ical = 'BEGIN:VCALENDAR' . "\r\n" .
                // ... (same as original)
                'END:VCALENDAR' . "\r\n";

            $mail->CharSet = 'UTF-8';
            $mail->AddAddress($to_address, $to_name);
            $mail->Subject = $subjetc;
            $mail->AddStringAttachment($ical, "meeting.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
            $mail->Ical = $ical;
            $mail->WordWrap = 80;
            $mail->MsgHTML($message);

            if (!empty($invoice)) {
                $invoice_id = $invoice['id'];
                $pdfPath = INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'Rentalbooking_' . $id . '_invoice_' . $invoice_id . '.pdf';
                if (is_file($pdfPath)) {
                    $mail->AddAttachment($pdfPath);
                    file_put_contents($logFile, "Invoice attached: $pdfPath\n", FILE_APPEND);
                } else {
                    file_put_contents($logFile, "Invoice file not found: $pdfPath\n", FILE_APPEND);
                }
            }

            $mail->IsHTML(true);
            $mail->Send();
            file_put_contents($logFile, "✅ Email sent successfully to: $to\n", FILE_APPEND);
        } catch (PHPMailerException $e) {
            file_put_contents($logFile, "❌ Mail sending failed: " . $e->errorMessage() . "\n", FILE_APPEND);
        } catch (Exception $ex) {
            file_put_contents($logFile, "❌ General Error: " . $ex->getMessage() . "\n", FILE_APPEND);
        }

        file_put_contents($logFile, "---- End ----\n\n", FILE_APPEND);
        return $invoice_id;
    }




    function sendBookingEmails($id, $type, $group)
    {

        GzObject::loadFiles('Model', array('Option', 'RentalBooking', 'Rentalinvoice'));
        $OptionModel = new OptionModel();
        $RentalBookingModel = new RentalBookingModel();
        $RentalinvoiceModel = new RentalinvoiceModel();

        $booking_details = $RentalBookingModel->getBookingDetails($id);

        $opts = array();
        $opts['calendar_id'] = $booking_details['calendar_id'];
        $option_arr = $OptionModel->getAllPairValues($opts);

        $opts = array();
        $opts['booking_id'] = $id;
        $invoice = $RentalinvoiceModel->getAll($opts, 'id');

        $replacement = array();
        //$replacement['id'] = $booking_details['id'];
        $replacement['id'] = $booking_details['booking_number'];
        $replacement['location'] = $booking_details['location'];
        //$replacement['title'] = $booking_details['title'];
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
        $replacement['fax'] = $booking_details['fax'] ?? null;
        $replacement['male'] = $booking_details['male'] ?? null;
        $replacement['additional'] = $booking_details['additional'] ?? null;
        $replacement['nights'] = $booking_details['nights'] ?? null;
        $replacement['date_from'] = $booking_details['date_from'] ?? null;
        $replacement['date_to'] = $booking_details['date_to'] ?? null;
        $replacement['calendars'] = $booking_details['calendar'] ?? null;
        $replacement['cc_type'] = $booking_details['cc_type'];
        $replacement['cc_num'] = $booking_details['cc_num'] ?? null;
        $replacement['cc_code'] = $booking_details['cc_code'] ?? null;
        $replacement['cc_exp_month'] = $booking_details['cc_exp_month'] ?? null;
        $replacement['cc_exp_year'] = $booking_details['cc_exp_year'] ?? null;

        $payment_method = __('payment_method_arr');
        $replacement['payment_method'] = $payment_method[$booking_details['payment_method']];

        $replacement['deposit'] = $booking_details['deposit'];
        $replacement['tax'] = $booking_details['tax'];
        $replacement['total'] = $booking_details['total'];
        $replacement['calendars_price'] = $booking_details['calendars_price'];
        $replacement['extra_price'] = $booking_details['extra_price'] ?? null;
        $replacement['discount'] = $booking_details['discount'];
        $location_arr = __('location_arr');
        $replacement['title'] = $booking_details['promo_code'];
        $replacement['location'] = $location_arr[$booking_details['location']];
        $replacement['transaction_id'] = $booking_details['transaction_id'];
        $replacement['slots'] = implode(', ', $booking_details['slots']);
        $rawDate = $booking_details['date'] ?? '';
        $replacement['create_date'] = date($this->tpl['option_arr_values']['date_format'], is_numeric($rawDate) ? (int)$rawDate : (strtotime($rawDate) ?: time()));

        switch ($type) {
            case 'create':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_create_email_booking'], $replacement);
                        $subjetc = $option_arr['client_create_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_create_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_create_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'confirmation':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_confirmation_subject_booking'];

                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_confirmation_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'cancellation':
                switch ($group) {
                    case 'client':
                        $message = Util::replaceToken($option_arr['client_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['client_cancellation_subject_booking'];
                        $to = $booking_details['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceToken($option_arr['admin_cancellation_email_booking'], $replacement);
                        $subjetc = $option_arr['admin_cancellation_subject_booking'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
        }

        try {
            $mail = new PHPMailer(true); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->AddReplyTo($option_arr['notify_email'] ?? '', "Admin");
            $mail->From = $option_arr['notify_email'] ?? '';
            $mail->FromName = $option_arr['notify_email'] ?? '';
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress('varunkumar953685@gmail.com');
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);

            if (!empty($invoice)) {
                $invoice_id = $invoice[0]['id'];
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf'); // attachment
                }
            }

            $mail->IsHTML(true); // send as HTML

            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
        return $invoice_id;
    }

    function getCSS()
    {

        header("Content-type: text/css");



        $css = file_get_contents(INSTALL_PATH . 'application/web/css/front/gzAbCalCalendar.css');



        GzObject::loadFiles('Model', 'Option');

        $OptionModel = new OptionModel();



        $cid = $_GET['cid'] ?? '';

        $opts['calendar_id'] = $cid;

        $option_arr_values = $OptionModel->getAllPairValues($opts);



        $search = array(
            '{bg_past_dates}',
            '{color_past_dates}',
            '{bg_nav_month}',
            '{bg_nav_hover_month}',
            '{color_month}',
            '{bg_month}',
            '{month_size_past}',
            '{font_style_month}',
            '{font_famaly_month}',
            '{border_color}',
            '{border_widht}',
            '{color_legend}',
            '{font_size_legend}',
            '{font_famaly_legend}',
            '{font_style_legend}',
            '{color_week}',
            '{bg_week}',
            '{bg_booked}',
            '{color_booked}',
            '{font_size_booked}',
            '{font_famaly_booked}',
            '{font_style_booked}',
            '{bg_pending}',
            '{color_pending}',
            '{font_size_pending}',
            '{font_famaly_pending}',
            '{font_style_pending}',
            '{font_size_past}',
            '{font_famaly_past}',
            '{font_style_past}',
            '{bg_available}',
            '{color_available}',
            '{font_size_available}',
            '{font_famaly_available}',
            '{font_style_available}',
            '{bg_empty}',
            '{bg_selected}',
            '{color_today}',
            '{font_size_today}',
            '{font_famaly_today}',
            '{font_style_today}',
            '{calendarContainer}',
            '{bg_day_off}',
            '{color_day_off}',
            '{font_size_day_off}',
            '{font_famaly_day_off}',
            '{font_style_day_off}',
        );



        $replace = array(
            $option_arr_values['bg_past_dates'],
            $option_arr_values['color_past_dates'],
            $option_arr_values['bg_nav_month'],
            $option_arr_values['bg_nav_hover_month'],
            $option_arr_values['color_month'],
            $option_arr_values['bg_month'],
            $option_arr_values['month_size_past'],
            $option_arr_values['font_style_month'],
            $option_arr_values['font_famaly_month'],
            $option_arr_values['border_color'],
            $option_arr_values['border_widht'],
            $option_arr_values['color_legend'],
            $option_arr_values['font_size_legend'],
            $option_arr_values['font_famaly_legend'],
            $option_arr_values['font_style_legend'],
            $option_arr_values['color_week'],
            $option_arr_values['bg_week'],
            $option_arr_values['bg_booked'],
            $option_arr_values['color_booked'],
            $option_arr_values['font_size_booked'],
            $option_arr_values['font_famaly_booked'],
            $option_arr_values['font_style_booked'],
            $option_arr_values['bg_pending'],
            $option_arr_values['color_pending'],
            $option_arr_values['font_size_pending'],
            $option_arr_values['font_famaly_pending'],
            $option_arr_values['font_style_pending'],
            $option_arr_values['font_size_past'],
            $option_arr_values['font_famaly_past'],
            $option_arr_values['font_style_past'],
            $option_arr_values['bg_available'],
            $option_arr_values['color_available'],
            $option_arr_values['font_size_available'],
            $option_arr_values['font_famaly_available'],
            $option_arr_values['font_style_available'],
            $option_arr_values['bg_empty'],
            $option_arr_values['bg_selected'],
            $option_arr_values['color_today'],
            $option_arr_values['font_size_today'],
            $option_arr_values['font_famaly_today'],
            $option_arr_values['font_style_today'],
            '#gz-abc-main-container-' . ($_GET['cid'] ?? ''),
            $this->tpl['option_arr_values']['bg_day_off'],
            $this->tpl['option_arr_values']['color_day_off'],
            $this->tpl['option_arr_values']['font_size_day_off'],
            $this->tpl['option_arr_values']['font_famaly_day_off'],
            $this->tpl['option_arr_values']['font_style_day_off']
        );



        echo str_replace($search, $replace, $css);
    }

    function checkAvailability($cal_id)
    {



        GzObject::loadFiles('Model', array('TimePrice', 'Option', 'CustomPrice', 'BookingSlot', 'Booking'));

        $TimePriceModel = new TimePriceModel();

        $OptionModel = new OptionModel();

        $CustomPriceModel = new CustomPriceModel();

        $BookingSlotModel = new BookingSlotModel();

        $BookingModel = new BookingModel();



        $check = true;



        foreach ((array)($_SESSION[$this->default_product]['slots'][$cal_id] ?? []) as $slot => $ccount) {



            $from = ($slot - 86400);

            $to = ($slot + 86400);



            $before = time() - 5 * 60;



            $sql = "SELECT * FROM " . $BookingSlotModel->getTable() . " as t1 LEFT JOIN  " . $BookingModel->getTable() . " as t2 ON t1.booking_id = t2.id WHERE (t2.status = 'confirmed' OR (t2.status = 'pending' AND t2.created >= " . $before . " )) AND t1.timestamp BETWEEN " . $from . "  AND " . $to . " AND t1.calendar_id = " . $cal_id . " ";

            $booking = $BookingSlotModel->execute($sql);



            $booked_slots = array();



            if (!empty($booking)) {

                foreach ($booking as $key => $value) {

                    if (!empty($booked_slots[$value['timestamp']])) {

                        $booked_slots[$value['timestamp']] += $value['count'];
                    } else {

                        $booked_slots[$value['timestamp']] = $value['count'];
                    }
                }
            }



            $opts = array();

            $opts['calendar_id'] = $cal_id;

            $custom_prices_arr = $CustomPriceModel->getAll($opts);



            $opts = array();



            $opts['calendar_id'] = $cal_id;

            $working_times = $TimePriceModel->getAll($opts, 'id');



            $date = $slot;



            foreach ($working_times as $working_time) {



                switch (date('N', $date)) {

                    case '1':

                        $start_time = explode(':', $working_time['monday_start'] ?? '00:00');

                        $end_time = explode(':', $working_time['monday_end'] ?? '00:00');



                        $slot_lenght = $working_time['monday_slot_lenght'];

                        $price = $working_time['monday_price'];

                        $count = $working_time['monday_count'];

                        break;

                    case '2':

                        $start_time = explode(':', $working_time['tuesday_start'] ?? '00:00');

                        $end_time = explode(':', $working_time['tuesday_end'] ?? '00:00');



                        $slot_lenght = $working_time['tuesday_slot_lenght'];

                        $price = $working_time['tuesday_price'];

                        $count = $working_time['tuesday_count'];

                        break;

                    case '3':

                        $start_time = explode(':', $working_time['wednesday_start'] ?? '00:00');

                        $end_time = explode(':', $working_time['wednesday_end'] ?? '00:00');



                        $slot_lenght = $working_time['wednesday_slot_lenght'];

                        $price = $working_time['wednesday_price'];

                        $count = $working_time['wednesday_count'];

                        break;

                    case '4':

                        $start_time = explode(':', $working_time['thursday_start'] ?? '00:00');

                        $end_time = explode(':', $working_time['thursday_end'] ?? '00:00');



                        $slot_lenght = $working_time['thursday_slot_lenght'];

                        $price = $working_time['thursday_price'];

                        $count = $working_time['thursday_count'];

                        break;

                    case '5':

                        $start_time = explode(':', $working_time['friday_start'] ?? '00:00');

                        $end_time = explode(':', $working_time['friday_end'] ?? '00:00');



                        $slot_lenght = $working_time['friday_slot_lenght'];

                        $price = $working_time['friday_price'];

                        $count = $working_time['friday_count'];

                        break;

                    case '6':

                        $start_time = explode(':', $working_time['saturday_start'] ?? '00:00');

                        $end_time = explode(':', $working_time['saturday_end'] ?? '00:00');



                        $slot_lenght = $working_time['saturday_slot_lenght'];

                        $price = $working_time['saturday_price'];

                        $count = $working_time['saturday_count'];

                        break;

                    case '7':

                        $start_time = explode(':', $working_time['sunday_start'] ?? '00:00');

                        $end_time = explode(':', $working_time['sunday_end'] ?? '00:00');



                        $slot_lenght = $working_time['sunday_slot_lenght'];

                        $price = $working_time['sunday_price'];

                        $count = $working_time['sunday_count'];

                        break;
                }





                if (!empty($start_time[0]) && !empty($end_time[0])) {

                    for ($i = mktime($start_time[0], $start_time[1] ?? 0, 0, date('n', $date), date('j', $date), date('Y', $date)); $i <= mktime($end_time[0], $end_time[1] ?? 0, 0, date('n', $date), date('j', $date), date('Y', $date)); $i += $slot_lenght * 60) {

                        $booked = 0;



                        if ($i == $slot) {

                            foreach ($booked_slots as $booked_timestamp => $booked_count) {

                                if ($booked_timestamp >= $i && $booked_timestamp < ($i + $slot_lenght * 60)) {

                                    $booked += $booked_count;
                                }
                            }

                            if (($count + 1) < ($booked + $ccount)) {

                                $check = false;
                            }
                        }
                    }
                }
            }
        }

        return $check;
    }


    function calculateMemberPrice()
    {
        $price = array('gmi_amount' => 0, 'gmf_amount' => 0, 'lm_amount' => 0, 'bf_amount' => 0, 'pm_amount' => 0, 'lm_h_amount' => 0, 'total' => 0);

        switch ($_POST['rate'] ?? '') {
            case 'gmi_1':
                $price['gmi_amount'] = $this->tpl['option_arr_values']['gmi_1'];
                break;
            case 'gmi_4':
                $price['gmi_amount'] = $this->tpl['option_arr_values']['gmi_4'];
                break;
            case 'gmf_1':
                $price['gmf_amount'] = $this->tpl['option_arr_values']['gmf_1'];
                break;
            case 'gmf_4':
                $price['gmf_amount'] = $this->tpl['option_arr_values']['gmf_4'];
                break;
            case 'lm':
                $price['lm_amount'] = $this->tpl['option_arr_values']['lm'];
                break;
            case 'bf':
                $price['bf_amount'] = $this->tpl['option_arr_values']['bf'];
                break;
            case 'pm':
                $price['pm_amount'] = $this->tpl['option_arr_values']['pm'];
                break;
            case 'lm_h':
                $price['lm_h_amount'] = $this->tpl['option_arr_values']['lm_h'];
                break;
        }

        $price['total'] = $price['gmi_amount'] + $price['gmf_amount'] + $price['lm_amount'] + $price['bf_amount'] + $price['pm_amount'] + $price['lm_h_amount'] + (float)($_POST['donation'] ?? 0);

        return $price;
    }

    function sendEmailsConfirm($members_details, $type, $group, $pass = NULL)
    {
        GzObject::loadFiles('Model', array('Option', 'User'));
        $OptionModel = new OptionModel();
        $option_arr = $OptionModel->getAllPairValues();

        $replacement = array();

        $replacement['last'] = $members_details['last'];
        $replacement['first'] = $members_details['first'];
        $replacement['email'] = $members_details['email'];
        $replacement['password'] = $pass;

        switch ($type) {
            case 'forgot':
                switch ($group) {
                    case 'members':
                        $message = Util::replaceForgotEmailToken($option_arr['forgot_password_message'], $replacement);
                        $subjetc = $option_arr['forgot_password_subject'];
                        $to = $members_details['email'];
                        break;
                }
                break;
        }


        try {
            $mail = new PHPMailer(true); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail

            $email_arr = explode(',', $option_arr['notify_email'] ?? '');

            foreach ($email_arr as $email) {
                $mail->AddReplyTo(trim($email), "Admin");
            }

            $email_arr = explode(',', $option_arr['notify_email'] ?? '');
            $mail->From = $email_arr[0] ?? '';
            $mail->FromName = $email_arr[0] ?? '';

            $mail->AddAddress('varunkumar953685@gmail.com');
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            $mail->IsHTML(true); // send as HTML
            $mail->Send();
        } catch (PHPMailerException $e) {

            echo $e->errorMessage();
        }
    }

    function SendSMS($mobileno, $msg)
    {

        //hdbs twillo account setting
        $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
        $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
        $client = new Client($sid, $token);
        try {
            $message = $client->messages->create(
                // Where to send a text message (your cell phone?)


                '+19536855214',
                array(
                    'from' => '+12815016454',
                    'body' => $msg
                )
            );
        } catch (\Exception $e) {
            error_log('SMS send failed: ' . $e->getMessage());
        }
    }
}


