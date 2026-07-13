<?php

require_once FRAMEWORK_PATH . 'Controller.class.php';
require __DIR__ . '/Twillio/vendor/autoload.php';
use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

function _gz_new_mailer(): PHPMailer {
    global $ENV_MAIL_ENABLED, $ENV_SMTP_HOST, $ENV_SMTP_PORT, $ENV_SMTP_USER, $ENV_SMTP_PASS, $ENV_SMTP_FROM;
    $mail = new PHPMailer(true);
    if ($ENV_MAIL_ENABLED) {
        $mail->isSMTP();
        $mail->Host       = $ENV_SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = $ENV_SMTP_USER;
        $mail->Password   = $ENV_SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int)$ENV_SMTP_PORT;
    }
    $mail->From     = $ENV_SMTP_FROM;
    $mail->FromName = 'Houston Durga Bari Society';
    return $mail;
}

class App extends Controller {

    var $models = array();

    function __construct() {


        GzObject::loadFiles('Model', array('Languages', 'Local'));

        $LanguagesModel = new LanguagesModel();

        $LocalModel = new LocalModel();



        $this->tpl['languages'] = $LanguagesModel->getAll(null, 'order');



        foreach (($this->tpl['languages'] ?: []) as $k => $v) {

            $this->tpl['local'][$v['id']] = $LocalModel->getAll(array('language_id' => $v['id']));
        }



        $default_language = $LanguagesModel->getAll(array('isdefault' => 1), 'order');

        $select_language = $this->getLanguage();



        $language = $select_language ? $LanguagesModel->getAll(array('id' => $select_language['id']), 'order') : [];



        $default_language_row = is_array($default_language) ? ($default_language[0] ?? []) : [];

        if (empty($language)) {

            $this->setLanguage($default_language_row);
        }



        $this->tpl['default_language'] = $default_language_row;



        GzObject::loadFiles('Model', 'Option');

        $OptionModel = new OptionModel();



        $this->tpl['option_arr_values'] = $OptionModel->getAllPairValues();

        $tz = $this->tpl['option_arr_values']['timezone'] ?? '';
        if ($tz) {
            date_default_timezone_set($tz);
        }
    }

    protected function getStripeApiKey()
    {
        $stripeApiKey = trim((string) ($this->tpl["option_arr_values"]["stripe_api_key"] ?? ''));
        if ($stripeApiKey !== '') {
            return $stripeApiKey;
        }

        $stripeApiKey = trim((string) ($this->option_arr["stripe_api_key"] ?? ''));
        if ($stripeApiKey !== '') {
            return $stripeApiKey;
        }

        try {
            GzObject::loadFiles('Model', 'Option');
            $OptionModel = new OptionModel();
            $options = $OptionModel->getAllPairValues();
            $stripeApiKey = trim((string) ($options["stripe_api_key"] ?? ''));
            if ($stripeApiKey !== '') {
                $this->option_arr = $options;
                $this->tpl['option_arr_values'] = $options;
                return $stripeApiKey;
            }
        } catch (Throwable $e) {
        }

        foreach (array('STRIPE_API_KEY', 'STRIPE_SECRET_KEY', 'STRIPE_PUJA_SECRET_KEY') as $envKey) {
            if (defined($envKey)) {
                $stripeApiKey = trim((string) constant($envKey));
                if ($stripeApiKey !== '') {
                    return $stripeApiKey;
                }
            }
            $stripeApiKey = trim((string) getenv($envKey));
            if ($stripeApiKey !== '') {
                return $stripeApiKey;
            }
        }

        return '';
    }
    function isUser() {

        return $this->getRoleId() == 2;
    }
    
    function calclateBookingPrice($params, $session = array()) {

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



        if (empty($price) && (!empty($_POST['Puja']) || !empty($_POST['Puja2']) || !empty($_POST['Puja3']))) {



            $slot_price = 0;



            if (($_POST['location'] ?? '') == 'inside' || ($_POST['location'] ?? '') == "online") {

                $_POST['Puja'] = floatval($_POST['Puja'] ?? 0);

                $slot_price = $_POST['Puja'] ?? '';
            }

            if(($_POST['location'] ?? '') == 'wholeday')
            {
                $_POST['Puja3'] = floatval($_POST['Puja3'] ?? 0);

                $slot_price = $_POST['Puja3'] ?? '';
            }

            if(($_POST['location'] ?? '') == 'outside')
             {

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

        $result['formated_tax'] = Util::currenctFormat($option_arr['currency'], $result['tax']);



        return $result;
    }

    function calclateBookingPrice_23_may($params, $session = array()) {

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

        $result['formated_tax'] = Util::currenctFormat($option_arr['currency'], $result['tax']);



        return $result;
    }
    
    function sendMemberEmails($id, $type, $group) {

        GzObject::loadFiles('Model', array('Option', 'Member'));
        $OptionModel = new OptionModel();
        $MemberModel = new MemberModel();

        $member = $MemberModel->get($id);

        $opts = array();
        $option_arr = $OptionModel->getAllPairValues($opts);

        $replacement = array();
        $replacement['ID'] = $member['ID'];
        $replacement['information'] = $member['information'];
        $replacement['GovtissueID'] = $member['GovtissueID'];
        $replacement['membership_type'] = $member['membership_type'];
        $replacement['Member_id'] = $member['Member_id'];
        $replacement['Category'] = $member['Category'];
        $replacement['F_Name'] = $member['F_Name'];
        $replacement['L_Name'] = $member['L_Name'];
        $replacement['Mob_No'] = $member['Mob_No'];
        $replacement['Sp_FName'] = $member['Sp_FName'];
        $replacement['Address1'] = $member['Address1'];
        $replacement['Address2'] = $member['Address2'];
        $replacement['Address3'] = $member['Address3'];
        $replacement['City'] = $member['City'];
        $replacement['State'] = $member['State'];
        $replacement['Country'] = $member['Country'];
        $replacement['Zip'] = $member['Zip'];
        $replacement['email'] = $member['email'];
        $replacement['Email2'] = $member['Email2'];
        $replacement['Tele1'] = $member['Tele1'];
        $replacement['Tele2'] = $member['Tele2'];
        $replacement['Child1'] = $member['Child1'];
        $replacement['Age1'] = $member['Age1'];
        $replacement['Child2'] = $member['Child2'];
        $replacement['Age2'] = $member['Age2'];
        $replacement['Child3'] = $member['Child3'];
        $replacement['Age3'] = $member['Age3'];
        $replacement['Parent1'] = $member['Parent1'];
        $replacement['Parent2'] = $member['Parent2'];
        $replacement['remarks'] = $member['remarks'];
        $replacement['swap'] = $member['swap'];
        $replacement['FirstSal'] = $member['FirstSal'];
        
        $payment_method = __('payment_method_arr');
        $replacement['Payment_method'] = $payment_method[$member['Payment_method']];
        
        $replacement['SpouseSal'] = $member['SpouseSal'];
        $replacement['CreatedOn'] = $member['CreatedOn'];
        $replacement['password'] = $_POST['password'] ?? '';
        $replacement['type'] = $member['type'];
        
        $user_status_arr = __('user_status_arr');
        $replacement['status'] = $user_status_arr[$member['status']];

        switch ($type) {
            case 'create':
                switch ($group) {
                    case 'member':
                        $message = Util::replaceMemberToken($option_arr['admin_new_member_body'], $replacement);
                        $subjetc = $option_arr['admin_new_member_subject'];
                        $to = $member['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceMemberToken($option_arr['admin_new_member_body'], $replacement);
                        $subjetc = $option_arr['admin_new_member_subject'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
            case 'active':
                switch ($group) {
                    case 'member':
                        $message = Util::replaceMemberToken($option_arr['active_member_body'], $replacement);
                        $subjetc = $option_arr['active_member_subject'];
                        $to = $member['email'];
                        break;
                    case 'admin':
                        $message = Util::replaceMemberToken($option_arr['active_member_body'], $replacement);
                        $subjetc = $option_arr['active_member_subject'];
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
        }

        try {
            $mail = _gz_new_mailer(); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->AddReplyTo($option_arr['notify_email'] ?? '', "Admin");
            // $mail->From = $option_arr['notify_email'] ?? ''; // shared-hosting sendmail
            // $mail->FromName = $option_arr['notify_email'] ?? ''; // shared-hosting sendmail
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress('varunkumar953685@gmail.com');
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);

            $mail->IsHTML(true); // send as HTML

            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
    }

    function sendBookingEmailsNew($id, $type, $group,$name, $email,$mobileno,$Date, $stime,$etime,$puja,$loc,$msg) {

        GzObject::loadFiles('Model', array('Option', 'Booking', 'Invoice'));
        $OptionModel = new OptionModel();
        $BookingModel = new BookingModel();
        $InvoiceModel = new InvoiceModel();

        $booking_details = $BookingModel->getBookingDetails($id);

        $opts = array();
        $opts['calendar_id'] = $booking_details['calendar_id'];
        $option_arr = $OptionModel->getAllPairValues($opts);

        $opts = array();
        $opts['booking_id'] = $id;
        //$opts['booking_id'] = $booking_details['booking_number'];;
        $invoice = $InvoiceModel->getAll($opts, 'id');

        $replacement = array();
        $replacement['id'] = $booking_details['id'];
        //$replacement['id'] = $booking_details['booking_number'];
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
        $replacement['cc_type'] = $booking_details['cc_type'] ?? null;
        $replacement['cc_num'] = $booking_details['cc_num'] ?? null;
        $replacement['cc_code'] = $booking_details['cc_code'] ?? null;
        $replacement['cc_exp_month'] = $booking_details['cc_exp_month'] ?? null;
        $replacement['cc_exp_year'] = $booking_details['cc_exp_year'] ?? null;

        $payment_method = __('payment_method_arr');
        $replacement['payment_method'] = $payment_method[$booking_details['payment_method'] ?? ''] ?? null;

        $replacement['deposit'] = $booking_details['deposit'] ?? null;
        $replacement['tax'] = $booking_details['booking_number'] ?? null;
        $replacement['total'] = $booking_details['total'] ?? null;
        $replacement['calendars_price'] = $booking_details['calendars_price'] ?? null;
        $replacement['extra_price'] = $booking_details['extra_price'] ?? null;
        $replacement['discount'] = $booking_details['discount'];
        $location_arr = __('location_arr');
         $replacement['title'] = $booking_details['promo_code'];
        $replacement['location'] = $location_arr[$booking_details['location']] ?? '';
         $replacement['transaction_id'] = $booking_details['transaction_id'];
        $replacement['slots'] = implode(', ', $booking_details['slots'] ?? []);
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
                        //$to = $option_arr['notify_email']." , "; $to .= 'paras.kaka2@gmail.com';
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
                        //$to = $option_arr['notify_email']." , "; $to .= 'paras.kaka2@gmail.com';
                        $to = $option_arr['notify_email'];
                        break;
                        case 'priest':
                            $message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                            $subjetc = $option_arr['admin_confirmation_subject_booking'];
                            $to = 'varun.kumar@eicetechnology.com';
                            //$to = $option_arr['notify_email'];
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
                        //$to = $option_arr['notify_email']." , "; $to .= 'paras.kaka2@gmail.com';
                        $to = $option_arr['notify_email'];
                        break;
                }
                break;
        }
        try {
           
   
    
            // event params
                $from_name = "HDBS Durgabari";
                $from_address = "hdbs.payment@durgabari.org";
                $to_name = $name;
                $to_address = $email;
                //$to_address = "avinash.verma@eiceinternational.com ";
                $startTime = $Date.$stime;
                $endTime = $Date.$etime;
                $subject = $puja;
                $description = $msg;
                $location = $loc;
                $domain = INSTALL_URL . 'Preview/index';
                $mail = _gz_new_mailer(); //New instance, with exceptions enabled
                //$mail->isSMTP();
                //$mail->SMTPDebug = 0;  // tell the class to use Sendmail
                $mail->AddReplyTo($option_arr['notify_email'] ?? '', "Admin");
                // $mail->From = $option_arr['notify_email'] ?? ''; // shared-hosting sendmail
                // $mail->FromName = $option_arr['notify_email'] ?? ''; // shared-hosting sendmail
           
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
'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
'UID:'.date("Ymd\TGis", strtotime($startTime)).random_int(0, PHP_INT_MAX)."@".$domain."\r\n" .
'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
'DTSTART;TZID="America/Chicago":'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
'DTEND;TZID="America/Chicago":'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
'TRANSP:OPAQUE'. "\r\n" .
'SEQUENCE:1'. "\r\n" .
'SUMMARY:' . $subject . "\r\n" .
'LOCATION:' . $location . "\r\n" .
'CLASS:PUBLIC'. "\r\n" .
'PRIORITY:5'. "\r\n" .
'BEGIN:VALARM' . "\r\n" .
'TRIGGER:-PT15M' . "\r\n" .
'ACTION:DISPLAY' . "\r\n" .
'DESCRIPTION:Reminder' . "\r\n" .
'END:VALARM' . "\r\n" .
'END:VEVENT'. "\r\n" .
'END:VCALENDAR'. "\r\n";
                // $message1 .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
                // $message1 .= "Content-Transfer-Encoding: 8bit\n\n";
                // $message1 .= $ical;

                $mail->CharSet = 'UTF-8';
                $mail->AddAddress('varunkumar953685@gmail.com');
                $mail->Subject = $subjetc;
                $mail->AddStringAttachment($ical, "meeting.ics", "7bit", "text/calendar; charset=utf-8; method=REQUEST");
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->Ical = $ical;
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($message);
                //$mail->Body = $ical;
                $invoice_id = null;
                if (!empty($invoice)) {
                    $invoice_id = $invoice[0]['id'];
                    if (is_file(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf')) {
                        $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf');
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
        //     $mail = _gz_new_mailer(); //New instance, with exceptions enabled
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

    function sendBookingEmails($id, $type, $group) {

        GzObject::loadFiles('Model', array('Option', 'Booking', 'Invoice'));
        $OptionModel = new OptionModel();
        $BookingModel = new BookingModel();
        $InvoiceModel = new InvoiceModel();

        $booking_details = $BookingModel->getBookingDetails($id);

        $opts = array();
        $opts['calendar_id'] = $booking_details['calendar_id'];
        $option_arr = $OptionModel->getAllPairValues($opts);

        $opts = array();
        $opts['booking_id'] = $id;
        $invoice = $InvoiceModel->getAll($opts, 'id');

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
        $replacement['cc_type'] = $booking_details['cc_type'] ?? null;
        $replacement['cc_num'] = $booking_details['cc_num'] ?? null;
        $replacement['cc_code'] = $booking_details['cc_code'] ?? null;
        $replacement['cc_exp_month'] = $booking_details['cc_exp_month'] ?? null;
        $replacement['cc_exp_year'] = $booking_details['cc_exp_year'] ?? null;

        $payment_method = __('payment_method_arr');
        $replacement['payment_method'] = $payment_method[$booking_details['payment_method'] ?? ''] ?? null;

        $replacement['deposit'] = $booking_details['deposit'] ?? null;
        $replacement['tax'] = $booking_details['tax'] ?? null;
        $replacement['total'] = $booking_details['total'] ?? null;
        $replacement['calendars_price'] = $booking_details['calendars_price'] ?? null;
        $replacement['extra_price'] = $booking_details['extra_price'] ?? null;
        $replacement['discount'] = $booking_details['discount'];
        $location_arr = __('location_arr');
         $replacement['title'] = $booking_details['promo_code'];
        $replacement['location'] = $location_arr[$booking_details['location']] ?? '';
         $replacement['transaction_id'] = $booking_details['transaction_id'];
        $replacement['slots'] = implode(', ', $booking_details['slots'] ?? []);
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
            $mail = _gz_new_mailer(); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->AddReplyTo($option_arr['notify_email'] ?? '', "Admin");
            // $mail->From = $option_arr['notify_email'] ?? ''; // shared-hosting sendmail
            // $mail->FromName = $option_arr['notify_email'] ?? ''; // shared-hosting sendmail
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

    function getCSS() {

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
            $option_arr_values['bg_past_dates'] ?? '',
            $option_arr_values['color_past_dates'] ?? '',
            $option_arr_values['bg_nav_month'] ?? '',
            $option_arr_values['bg_nav_hover_month'] ?? '',
            $option_arr_values['color_month'] ?? '',
            $option_arr_values['bg_month'] ?? '',
            $option_arr_values['month_size_past'] ?? '',
            $option_arr_values['font_style_month'] ?? '',
            $option_arr_values['font_famaly_month'] ?? '',
            $option_arr_values['border_color'] ?? '',
            $option_arr_values['border_widht'] ?? '',
            $option_arr_values['color_legend'] ?? '',
            $option_arr_values['font_size_legend'] ?? '',
            $option_arr_values['font_famaly_legend'] ?? '',
            $option_arr_values['font_style_legend'] ?? '',
            $option_arr_values['color_week'] ?? '',
            $option_arr_values['bg_week'] ?? '',
            $option_arr_values['bg_booked'] ?? '',
            $option_arr_values['color_booked'] ?? '',
            $option_arr_values['font_size_booked'] ?? '',
            $option_arr_values['font_famaly_booked'] ?? '',
            $option_arr_values['font_style_booked'] ?? '',
            $option_arr_values['bg_pending'] ?? '',
            $option_arr_values['color_pending'] ?? '',
            $option_arr_values['font_size_pending'] ?? '',
            $option_arr_values['font_famaly_pending'] ?? '',
            $option_arr_values['font_style_pending'] ?? '',
            $option_arr_values['font_size_past'] ?? '',
            $option_arr_values['font_famaly_past'] ?? '',
            $option_arr_values['font_style_past'] ?? '',
            $option_arr_values['bg_available'] ?? '',
            $option_arr_values['color_available'] ?? '',
            $option_arr_values['font_size_available'] ?? '',
            $option_arr_values['font_famaly_available'] ?? '',
            $option_arr_values['font_style_available'] ?? '',
            $option_arr_values['bg_empty'] ?? '',
            $option_arr_values['bg_selected'] ?? '',
            $option_arr_values['color_today'] ?? '',
            $option_arr_values['font_size_today'] ?? '',
            $option_arr_values['font_famaly_today'] ?? '',
            $option_arr_values['font_style_today'] ?? '',
            '#gz-abc-main-container-' . ($_GET['cid'] ?? ''),
            $this->tpl['option_arr_values']['bg_day_off'],
            $this->tpl['option_arr_values']['color_day_off'],
            $this->tpl['option_arr_values']['font_size_day_off'],
            $this->tpl['option_arr_values']['font_famaly_day_off'],
            $this->tpl['option_arr_values']['font_style_day_off']
        );



        echo str_replace($search, $replace, $css);
    }

    function checkAvailability($cal_id) {



        GzObject::loadFiles('Model', array('TimePrice', 'Option', 'CustomPrice', 'BookingSlot', 'Booking'));

        $TimePriceModel = new TimePriceModel();

        $OptionModel = new OptionModel();

        $CustomPriceModel = new CustomPriceModel();

        $BookingSlotModel = new BookingSlotModel();

        $BookingModel = new BookingModel();



        $check = true;



        foreach ($_SESSION[$this->default_product]['slots'][$cal_id] as $slot => $ccount) {



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

    
    function calculateMemberPrice(){
        $price = array('gmi_amount' => 0, 'gmf_amount' => 0, 'lm_amount' => 0, 'bf_amount' => 0, 'pm_amount' => 0, 'lm_h_amount' => 0, 'total' => 0);
        
        switch($_POST['rate'] ?? ''){
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
        
        $price['total'] = (float)($price['gmi_amount'] ?? 0) + (float)($price['gmf_amount'] ?? 0) + (float)($price['lm_amount'] ?? 0) + (float)($price['bf_amount'] ?? 0) + (float)($price['pm_amount'] ?? 0) + (float)($price['lm_h_amount'] ?? 0) + (float)($_POST['donation'] ?? 0);
        
        return $price;
    }
    
    function sendEmailsConfirm($members_details, $type, $group, $pass = NULL) {
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
            $mail = _gz_new_mailer(); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail

            $email_arr = explode(',', $option_arr['notify_email'] ?? '');

            foreach ($email_arr as $email) {
                $mail->AddReplyTo(trim($email), "Admin");
            }

            $email_arr = explode(',', $option_arr['notify_email'] ?? '');
            // $mail->From = $email_arr[0] ?? ''; // shared-hosting sendmail
            // $mail->FromName = $email_arr[0] ?? ''; // shared-hosting sendmail

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
	

     // Badges email for sponsor

        function sendEmail($Parking,$path) {

        if (!empty($Parking)) {
            $subjetc='HDBS Parking Confirmation';
            $member_id =$Parking['Member_id'];
            $name =$Parking['name'];
            $Volunteer_Name =$Parking['Volunteer_Name'];
            $F_Name =$Parking['F_Name'];
            $L_Name =$Parking['L_Name'];
            $Sp_FName =$Parking['Sp_FName'];
            $parking_assigned =$Parking['parking_assigned'];
            $Decal =$Parking['Decal'];
            $Date =$Parking['Date'];
            $signName = $Parking['Signature'];
            $Path = INSTALL_URL . "esign/";
            $FinalSignImage =$Path.$signName;

            $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Parking Details</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member ID&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$member_id.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">First Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$F_Name.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Last Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$L_Name.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Spouse Name&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Sp_FName.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parking Lot Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$parking_assigned.'</td>
            </tr>
			<tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Deacl Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Decal.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Date&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Date .'</td>
            </tr>
            <tr>
            <td colspan=2 style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src='.$FinalSignImage.'  alt="" width="396" height="80" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
            GzObject::loadFiles('Model', array('Parkingdataview', 'Parkingdata'));
            $ParkingdataModel  = new ParkingdataModel();
            $ParkingdataviewModel = new ParkingdataviewModel();
           
            try {
                $mail = _gz_new_mailer(); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
                // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
                // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
                //$mail->FromName = $Parking['email'];
                $mail->CharSet = 'UTF-8';
                $mail->AddAddress('varunkumar953685@gmail.com');
                //$mail->addaddress('avinash.verma@eiceinternational.com');
                $mail->Subject = $subjetc;
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($message);
                //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf'); // attachment
                }
                $mail->IsHTML(true); // send as HTML
                $mail->Send();
            } catch (PHPMailerException $e) {
                //echo $e->errorMessage();
            }
            $_SESSION['status'] = 28;
            //echo "<script type='text/javascript'>window.open('$path','_self');</script>";
            //Util::redirect(INSTALL_URL . "Badges/index/");
        }
    }
    
    
         // Badges email for Paid parking
         
         function sendEmailPaid($Parking,$path) {

        if (!empty($Parking)) {
            $subjetc='HDBS Parking Confirmation';
            $oid =$Parking['oid'];
            $name =$Parking['name'];
            $parking_assigned =$Parking['parking_assigned'];
            $Decal =$Parking['Decal'];
            $Date =$Parking['Date'];
            $signName = $Parking['Signature'];
            $Path = INSTALL_URL . "esign/";
            $FinalSignImage =$Path.$signName;

            $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Parking Details</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">OID&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$oid.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$name .'</td>
            </tr>        
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parking Lot Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$parking_assigned.'</td>
            </tr>
			<tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Deacl Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Decal.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Date&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Date .'</td>
            </tr>
            <tr>
            <td colspan=2 style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src='.$FinalSignImage.'  alt="" width="396" height="80" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
            GzObject::loadFiles('Model', array('Parkingdata','Paidparkingview'));
            $ParkingdataModel  = new ParkingdataModel();
            $PaidparkingviewModel = new PaidparkingviewModel();
           
            try {
                $mail = _gz_new_mailer(); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
                // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
                // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
                //$mail->FromName = $Parking['email'];
                $mail->CharSet = 'UTF-8';
                $mail->AddAddress('varunkumar953685@gmail.com');
                //$mail->addaddress('avinash.verma@eiceinternational.com');
                $mail->Subject = $subjetc;
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($message);
                //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf'); // attachment
                }
                $mail->IsHTML(true); // send as HTML
                $mail->Send();
            } catch (PHPMailerException $e) {
                //echo $e->errorMessage();
            }
            $_SESSION['status'] = 28;
           // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
            //Util::redirect(INSTALL_URL . "Badges/index/");
        }
    }
    
    function sendEmailBadges($Badges, $path)
{
    if (!empty($Badges)) {
        $subjetc='HDBS Badges Confirmation';
        $MID =$Badges['MID'];
        $F_Name =$Badges['F_Name'];
        $L_Name =$Badges['L_Name'];
        $Spouse_Name =$Badges['Sp_FName'];
        $total =$Badges['Total'];
        $Status =$Badges['Status'];

        $Date =$Badges['Date'];
        $signName = $Badges['Signature'];
        $Path = INSTALL_URL . "esign/";
        $FinalSignImage =$Path.$signName;

        $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Badges Details</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">MID&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$MID.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">First Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$F_Name .'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Last Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$L_Name.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Spouse Name&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Spouse_Name.'</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total &nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$total.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Status.'</td>
            </tr>
			
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Date&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Date .'</td>
            </tr>
            <tr>
            <td colspan=2 style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src='.$FinalSignImage.'  alt="" width="396" height="80" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
        GzObject::loadFiles('Model', array('Badgesdata'));
        $BadgesdataModel = new BadgesdataModel();

        try {
            $mail = _gz_new_mailer(); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
            // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
            // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
            //$mail->FromName = $Parking['email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress('varunkumar953685@gmail.com');
             //$mail->addaddress('avinash.verma@eiceinternational.com');
             //$list = array('one@example.com', 'two@example.com', 'three@example.com');
             //$this->mail->ADDCC($list);
             $mail->AddCC('varun.kumar@eicetechnology.com');
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            if (!empty($Badges) && is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf')) {
                $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf'); // attachment
            }
            $mail->IsHTML(true); // send as HTML
            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
        $_SESSION['status'] = 28;
        // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
        //Util::redirect(INSTALL_URL . "Badges/index/");
    }
}
    
         // Badges email for Volunteer
    
    function sendEmailvolunteer($Parking,$path) {

        if (!empty($Parking)) {
            $subjetc='HDBS Parking Confirmation';
            $MID =$Parking['MID'];
            $Volunteer_Name =$Parking['Volunteer_Name'];
            $L_Name =$Parking['L_Name'];
            $Spouse_Name =$Parking['Spouse_Name'];
            $Parking_AreaAssigned =$Parking['Parking_AreaAssigned'];
            $Decal =$Parking['Decal'];
            $Date =$Parking['Date'];
            $signName = $Parking['Signature'];
            $Path = INSTALL_URL . "esign/";
            $FinalSignImage =$Path.$signName;

            $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Parking Details</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">MID&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$MID.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">First Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Volunteer_Name .'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Last Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$L_Name.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Spouse Name&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Spouse_Name.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Parking Lot Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Parking_AreaAssigned.'</td>
            </tr>
			<tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Deacl Assigned&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Decal.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Date&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Date .'</td>
            </tr>
            <tr>
            <td colspan=2 style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src='.$FinalSignImage.'  alt="" width="396" height="80" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
            GzObject::loadFiles('Model', array('Volunteersdata'));
            $VolunteersdataModel = new VolunteersdataModel();
           
            try {
                $mail = _gz_new_mailer(); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
                // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
                // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
                //$mail->FromName = $Parking['email'];
                $mail->CharSet = 'UTF-8';
                $mail->AddAddress('varunkumar953685@gmail.com');
                //$mail->addaddress('avinash.verma@eiceinternational.com');
                $mail->Subject = $subjetc;
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($message);
                //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf'); // attachment
                }
                $mail->IsHTML(true); // send as HTML
                $mail->Send();
            } catch (PHPMailerException $e) {
                //echo $e->errorMessage();
            }
            $_SESSION['status'] = 28;
           // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
            //Util::redirect(INSTALL_URL . "Badges/index/");
        }
    }
    // Food Coupons email 
    function foodsendEmail($fooddata, $path)
    {
        if (!empty($fooddata)) {
            $subjetc='HDBS Food Coupons Confirmation';
            $MID =$fooddata['MID'];
            $F_Name =$fooddata['F_Name'];
            $L_Name =$fooddata['L_Name'];
            $Spouse_Name =$fooddata['Sp_FName'];
            $Status =$fooddata['Status'];
            $total =$fooddata['Total'];
            $Date =$fooddata['Date'];
            $signName = $fooddata['Signature'];
            $Path = INSTALL_URL . "esign/";
            //$Path = "https://durgabari.org/HDBS_Payment_Parking_Badges/esign/";
            $FinalSignImage =$Path.$signName;
    
            $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
                <div class="email-token-class" style="text-align: justify;">
                <div class="email-token-class" style="text-align: center;">
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
                <tbody>
                <tr>
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>2022 Kali Puja Food Coupon Details</strong></td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="email-token-class" style="text-align: center;">
                <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
                <tbody>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">MID&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$MID.'</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">First Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$F_Name .'</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Last Name&nbsp;&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$L_Name.'</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Spouse Name&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Spouse_Name.'</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total &nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$total.'</td>
                </tr>
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Status.'</td>
                </tr>
                
                <tr>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Date&nbsp;</td>
                <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Date .'</td>
                </tr>
                <tr>
                <td colspan=2 style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src='.$FinalSignImage.'  alt="" width="396" height="80" /></td>
                </tr>
                </tbody>
                </table>
                </div>
                </div>
                </div>';
            GzObject::loadFiles('Model', array('Foodcoupon'));
              $FoodcouponModel = new FoodcouponModel();
    
            try {
                $mail = _gz_new_mailer(); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
                // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
                // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
                //$mail->FromName = $fooddata['email'];
                $mail->CharSet = 'UTF-8';
                $mail->AddAddress('varunkumar953685@gmail.com');
                 //$mail->addaddress('avinash.verma@eiceinternational.com');
                // $list = array('paras.sharma@eiceinternational.com');
                 //$this->mail->ADDCC($list);
                 $mail->addcc('varun.kumar@eicetechnology.com');
                $mail->Subject = $subjetc;
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($message);
                //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                if (is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'fooddata_' . $fooddata['id'] . '_invoice_' . $fooddata['MID'] . '.pdf')) {
                    $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'Foodcouponinvoice/' . 'fooddata_' . $fooddata['id'] . '_invoice_' . $fooddata['MID'] . '.pdf'); // attachment
                }
                $mail->IsHTML(true); // send as HTML
                $mail->Send();
            } catch (PHPMailerException $e) {
                //echo $e->errorMessage();
            }
            $_SESSION['status'] = 28;
            // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
            //Util::redirect(INSTALL_URL . "Foodcoupon/index/");
        }
    }
    
    //Donations email
    function sendEmailDonations($data)
   {
    if (!empty($data)) {
        $subjetc='HDBS Donation Confirmation';
        $MID =$data['Member_id'];
        $membername =$data['MemberName'];
        $Amount =$data['Amount'];
        $orderid =$data['oid'];
        $datefor =$data['pay_date'];
        $timestamp = strtotime($datefor);
		$paydate = date("m/d/Y", $timestamp);
        $status ='succeeded';
        $paymethod = $data['PaymentOption'] ?? '';
        $purpose =  $_POST['purpose'] ?? '';
        if($paymethod == "others"){
            $paymethodfinal = 'Zelle';

        }
        elseif($paymethod == "cash"){
            $paymethodfinal = 'Cash';
         }
         elseif($paymethod == "check"){
            $paymethodfinal = 'Check';
         }
         elseif($paymethod == "directdeposit"){
            $paymethodfinal = 'Direct Deposit';
         }
        else{
            $paymethodfinal = 'Credit Card';
        }
    
        $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Donation Confirmation</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;width:50%;">Member ID&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;width:50%;">'.$MID.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$membername .'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paymethodfinal.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$Amount.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Purpose&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$purpose.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order ID&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$orderid.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paydate.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$status.'</td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
        GzObject::loadFiles('Model', array('Donation'));
       $DonationModel = new DonationModel();

        try {
            $mail = _gz_new_mailer(); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
            // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
            // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
            //$mail->FromName = $data['email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress('varunkumar953685@gmail.com');
            $mail->AddAddress('varun.kumar@eicetechnology.com', 'Admin');
             //$mail->addaddress('hdbs.payment@durgabari.org');
             //$this->mail->ADDCC($list);
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            if (!empty($Badges) && is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf')) {
                $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf'); // attachment
            }
            $mail->IsHTML(true); // send as HTML
            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
       // $_SESSION['status'] = 28;
        // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
       // Util::redirect(INSTALL_URL . "Donations/donation/");
    }
   } 
   function sendGiftShopMisc($data)
   {
    if (!empty($data)) {
        $subjetc='HDBS Payment confirmation';
        $MID =$data['Member_id'];
        $membername =$data['MemberName'];
        $mainamount = $data['Amount'];
        if($mainamount != null){
            $Amount =$data['Amount'];
        }
        if($mainamount == null){
            $Amount =$data['adminamount'];
        }
        $orderid =$data['oid'];
        $paytype =$data['pay_type'];
        $datefor =$data['pay_date'];
        $timestamp = strtotime($datefor);
		$paydate = date("m/d/Y", $timestamp);
        $status ='succeeded';
        $Purpose = $_POST['purpose'] ?? '';
         $paymethod = $data['PaymentOption'] ?? '';
        if($paymethod == "others"){
            $paymethodfinal = 'Zelle';

        }
        elseif($paymethod == "cash"){
            $paymethodfinal = 'Cash';
         }
         elseif($paymethod == "check"){
            $paymethodfinal = 'Check';
         }
         elseif($paymethod == "directdeposit"){
            $paymethodfinal = 'Direct Deposit';
         }
        else{
            $paymethodfinal = 'Credit Card';
        }
    
        $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>HDBS Payment confirmation</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member ID&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">'.$MID.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$membername .'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment For&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paytype.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$Amount.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paymethodfinal.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order ID&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$orderid.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Purpose&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Purpose.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paydate.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$status.'</td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
        GzObject::loadFiles('Model', array('Donation'));
       $DonationModel = new DonationModel();

        try {
            $mail = _gz_new_mailer(); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
            // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
            // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
            //$mail->FromName = $data['email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress('varunkumar953685@gmail.com');
            $mail->AddAddress('varun.kumar@eicetechnology.com', 'Admin');
             //$mail->addaddress('hdbs.payment@durgabari.org');
             //$this->mail->ADDCC($list);
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            if (!empty($Badges) && is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf')) {
                $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf'); // attachment
            }
            $mail->IsHTML(true); // send as HTML
            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
       // $_SESSION['status'] = 28;
        // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
       // Util::redirect(INSTALL_URL . "Donations/donation/");
    }
   } 
  //Event email 
function sendEmailEvent($data)
   {
    if (!empty($data)) {
        $subjetc='HDBS Event Confirmation';
        $MID =$data['Member_id'];
        $membername =$data['MemberName'];
       $mainamount =  $data['totaldonation'];
       
        if($mainamount != null){
            $Amount = $data['totaldonation'];
        }
        if($mainamount == null){
            $Amount =$data['adminamount'];
        }
        $orderid =$data['oid'];
        $datefor =$data['pay_date'];
        $timestamp = strtotime($datefor);
		$paydate = date("m/d/Y", $timestamp);
        $status ='succeeded';
        $eventname =$data['type'];
        $description =$data['description'];
        $paymethod = $data['PaymentOption'] ?? '';
        if($paymethod == "others"){
            $paymethodfinal = 'Zelle';

        }
        elseif($paymethod == "cash"){
            $paymethodfinal = 'Cash';
         }
         elseif($paymethod == "check"){
            $paymethodfinal = 'Check';
         }
         elseif($paymethod == "directdeposit"){
            $paymethodfinal = 'Direct Deposit';
         }
        else{
            $paymethodfinal = 'Credit Card';
        }
        
        $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Event Payment Confirmation</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Member Id&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">'.$MID.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$membername .'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Event Name &nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$eventname.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$Amount.'</td>
            </tr> 
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paymethodfinal.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order Id&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$orderid.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Additional Comments &nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$description.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paydate.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$status.'</td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
          GzObject::loadFiles('Model', array('Event'));
          $EventModel = new EventModel();

         try {
            $mail = _gz_new_mailer(); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
            // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
            // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
            //$mail->FromName = $data['email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress('varunkumar953685@gmail.com');
            $mail->AddAddress('varun.kumar@eicetechnology.com', 'Admin');
             //$mail->addaddress('hdbs.payment@durgabari.org');
            //$this->mail->ADDCC($list);
            $mail->AddCC('varun.kumar@eicetechnology.com');
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            if (!empty($Badges) && is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf')) {
                $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf'); // attachment
            }
            $mail->IsHTML(true); // send as HTML
            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
        //$_SESSION['status'] = 28;
        // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
        //Util::redirect(INSTALL_URL . "Event/event/");
    }  
}

//Ticket email
function sendEmailTicketEvent($data)
   {
    if (!empty($data)) {
        $subjetc='HDBS Ticket Confirmation';
        $MID =$data['Member_id'];
        $membername =$data['name'];
       $adminamount = $_POST['adminamount'] ?? null;
       if($adminamount != null){
        $totalamount = $adminamount;
    }
    if($adminamount == null){
        $totalamount =$data['amount'];
    }
        $orderid =$data['oid'];
        $datefor =$data['pay_date'];
        $timestamp = strtotime($datefor);
		$paydate = date("m/d/Y", $timestamp);
		$qunatity = $data['item_number'];
		$eventday = $data['itemeventday'];
        $ticketprice = $data['item_cost'];
        $status ='succeeded';
        $eventname =$data['type'];
		$paymethod = $data['PaymentOption'] ?? '';

        if($paymethod == "others"){
            $paymethodfinal = 'Zelle';

        }
        elseif($paymethod == "cash"){
            $paymethodfinal = 'Cash';
         }
         elseif($paymethod == "check"){
            $paymethodfinal = 'Check';
         }
         elseif($paymethod == "directdeposit"){
            $paymethodfinal = 'Direct Deposit';
         }
        else{
            $paymethodfinal = 'Credit Card';
        }

         $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Ticket Payment Confirmation</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;  width:50%;">Member ID&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;  width:50%;">'.$MID.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$membername .'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Event Name&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$eventname.'</td>
            </tr> 
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Event Day &nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$eventday.'</td>
            </tr>
			
			 <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Quantity &nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$qunatity.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Ticket Amount&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$ticketprice.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$totalamount.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paymethodfinal.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order ID&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$orderid.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paydate.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$status.'</td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
          GzObject::loadFiles('Model', array('Event'));
          $EventModel = new EventModel();

         try {
            $mail = _gz_new_mailer(); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
            // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
            // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
            //$mail->FromName = $data['email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress('varunkumar953685@gmail.com');
            $mail->AddAddress('varun.kumar@eicetechnology.com', 'Admin');
             //$mail->addaddress('hdbs.payment@durgabari.org');
            //$this->mail->ADDCC($list);
            $mail->AddCC('varun.kumar@eicetechnology.com');
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            if (!empty($Badges) && is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf')) {
                $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf'); // attachment
            }
            $mail->IsHTML(true); // send as HTML
            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
        //$_SESSION['status'] = 28;
        // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
        //Util::redirect(INSTALL_URL . "Event/event/");
    }  
}


//Student email
    function sendEmailstudent($data,$firststsubject,$studentsecondsubject)
   {
    if (!empty($data)) {
        $subjetc='HDBS Student Registration Confirmation';
        $memberid =$data['reg_uid'];
		$membername =$data['membername'];
		$Studentfirstname =$data['St_Name1'];
        $Studentsecondname =$data['St_Name2'];
        $Amount =$data['totalamount'];
        $orderid =$data['oid'];
        $datefor =$data['pay_date'];
        $timestamp = strtotime($datefor);
		$paydate = date("m/d/Y", $timestamp);
        $status ='succeeded';
        $registration =$data['Registration_type'];
        $subjectone = $firststsubject;
        $subjecttwo = $studentsecondsubject;
         $paymethod = $data['payment_method'] ?? '';
        if($paymethod == "others"){
            $paymethodfinal = 'Zelle';

        }
        elseif($paymethod == "cash"){
            $paymethodfinal = 'Cash';
         }
         elseif($paymethod == "check"){
            $paymethodfinal = 'Check';
         }
         elseif($paymethod == "directdeposit"){
            $paymethodfinal = 'Direct Deposit';
         }
        else{
            $paymethodfinal = 'Credit Card';
        }
		
        $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Student Registration Confirmation</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$memberid.'</td>
            </tr>
            	<tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$membername.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Registration Type&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$registration.'</td>
            </tr>
			  <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">First Student Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Studentfirstname.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">First Student Subject&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$subjectone.'</td>
            </tr>
			  <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Second Student Name&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Studentsecondname.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Second Student Subject&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$subjecttwo.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paymethodfinal.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Fee&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$Amount.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order ID&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$orderid.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paydate.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$status.'</td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
        GzObject::loadFiles('Model', array('Student'));
       $StudentModel = new StudentModel();

        try {
            $mail = _gz_new_mailer(); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
            // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
            // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
            //$mail->FromName = $data['email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress('varunkumar953685@gmail.com');
            $mail->AddAddress('varun.kumar@eicetechnology.com', 'Admin');
             //$mail->addaddress('hdbs.payment@durgabari.org');
             //$this->mail->ADDCC($list);
           $mail->AddCC('varun.kumar@eicetechnology.com');
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            if (!empty($Badges) && is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf')) {
                $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf'); // attachment
            }
            $mail->IsHTML(true); // send as HTML
            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
       // $_SESSION['status'] = 28;
        // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
       // Util::redirect(INSTALL_URL . "Student/create/");
    }
}
//member email registration time
function sendEmailmember($data, $oid)
   {
    if (!empty($data)) {
        $subjetc='HDBS Membership Registration';
        $Firstname =$data['F_Name'].' ' .$data['M_Name'].' ' .$data['L_Name'];
        $email =$data['email'];
       $membershiptype = $data['membership_type'];
        if($membershiptype == 'IND'){
         $membertype = 'Individual Membership';
        }
        else{
            $membertype =  'Family Membership';
        }
        $orderid = $oid;
        $status =$data['payment_status'];
		$amount =$data['total'];
        $paymethod = $data['Payment_method'] ?? '';
        if($paymethod == "others"){
            $paymethodfinal = 'Zelle';
        }
        elseif($paymethod == "cash"){
            $paymethodfinal = 'Cash';
        }
        elseif($paymethod == "check"){
            $paymethodfinal = 'Check';
        }
        elseif($paymethod == "directdeposit"){
            $paymethodfinal = 'Direct Deposit';
        }
        else{
            $paymethodfinal = 'Credit Card';
        }

        $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Member Registration</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Firstname.'</td>
            </tr>
			  <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Email &nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$email .'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Mebership Type&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'. $membertype.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paymethodfinal.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$amount.'</td>
            </tr>
             <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order ID&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$orderid.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$status.'</td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
        GzObject::loadFiles('Model', array('Member'));
       $MemberModel = new MemberModel();

        try {
            $mail = _gz_new_mailer(); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
            // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
            // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
            //$mail->FromName = $data['email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress('varunkumar953685@gmail.com');
            $mail->AddAddress('varun.kumar@eicetechnology.com', 'Admin');
             //$mail->addaddress('hdbs.payment@durgabari.org');
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            if (!empty($Badges) && is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf')) {
                $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf'); // attachment
            }
            $mail->IsHTML(true); // send as HTML
            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
       // $_SESSION['status'] = 28;
        // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
       // Util::redirect(INSTALL_URL . "Member/create/");
    }
}

//member email Renew & Maintenance
function sendEmailrenewalmember($data, $oid)
   {
    if (!empty($data)) {
        $subjetc='HDBS Membership Renewal & Maintenance';
        $memberid =$data['Member_id'];
        $Firstname =$data['F_Name'].' ' .$data['M_Name'].' ' .$data['L_Name'];
        $email =$data['email'];
		$payfor =$data['pay_for'];
		$datefor =$data['pay_date'];
        $timestamp = strtotime($datefor);
		$paydate = date("m/d/Y", $timestamp);
        $status =$data['payment_status'];
        $orderid = $oid;
       $amountadmin = $data['adminamount'] ?? null;
        if($amountadmin != null){
            $amount =$data['adminamount'];
        }
        if($amountadmin == null){
            $amount =$data['total'];
        } 
        $paymethod = $data['Payment_method'] ?? '';
        if($paymethod == "others"){
            $paymethodfinal = 'Zelle';

        }
        elseif($paymethod == "cash"){
            $paymethodfinal = 'Cash';
         }
         elseif($paymethod == "check"){
            $paymethodfinal = 'Check';
         }
         elseif($paymethod == "directdeposit"){
            $paymethodfinal = 'Direct Deposit';
         }
        else{
            $paymethodfinal = 'Credit Card';
        }

		
        $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
            <div class="email-token-class" style="text-align: justify;">
            <div class="email-token-class" style="text-align: center;">
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
            <tr>
            <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Membership Renewal & Maintenance</strong></td>
            </tr>
            </tbody>
            </table>
            </div>
            <div class="email-token-class" style="text-align: center;">
            <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
            <tbody>
              <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Id&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$memberid.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Firstname.'</td>
            </tr>
			  <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Email &nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$email .'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paymethodfinal.'</td>
            </tr>
			 <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay For&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$payfor.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$amount.'</td>
            </tr>
			 <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Pay Date&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paydate.'</td>
            </tr>
             <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Order ID&nbsp;&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$orderid.'</td>
            </tr>
            <tr>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status&nbsp;</td>
            <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$status.'</td>
            </tr>
            </tbody>
            </table>
            </div>
            </div>
            </div>';
        GzObject::loadFiles('Model', array('Member'));
       $MemberModel = new MemberModel();

        try {
            $mail = _gz_new_mailer(); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
            // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
            // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
            //$mail->FromName = $data['email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress('varunkumar953685@gmail.com');
            $mail->AddAddress('varun.kumar@eicetechnology.com', 'Admin');
            $mail->AddBCC('varun.kumar@eicetechnology.com');
             //$mail->addaddress('hdbs.payment@durgabari.org');
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            if (!empty($Badges) && is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf')) {
                $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . ($Badges['id'] ?? '') . '_invoice_' . ($Badges['MID'] ?? '') . '.pdf'); // attachment
            }
            $mail->IsHTML(true); // send as HTML
            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
       // $_SESSION['status'] = 28;
        // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
       // Util::redirect(INSTALL_URL . "Member/create/");
    }
}

function userpaymentemail($data)
{
 if (!empty($data)) {
     $subjetc='HDBS Commercial Invoice';
     $name =$data['ownername'] ?? '';
     $oid =$data['oid'] ?? '';
     $custid =$data['custid'] ?? '';
     $email =$data['email'] ?? '';
     $mainpaytype =$data['paytype'] ?? '';
     if($mainpaytype == "OTHADV"){
        $paytype  = 'Other Advertisements' ;
        $ccemail ='advertisement@durgabari.org';
        }
        elseif($mainpaytype == "BOOTH"){
            $paytype  =  'Booth Rentals';
            $ccemail ='vendor@durgabari.org';
        }
        elseif($mainpaytype == "MAGADV"){
            $paytype  = 'Magazine Advertisements';
            $ccemail ='advertisement@durgabari.org';
            }

     $created_on =$data['created_on'] ?? '';
     $businessname =$data['businessname'] ?? '';
     $taxid =$data['taxid'] ?? '';
     $item_desc =$data['item_desc'] ?? '';
     $qty =$data['item_number'] ?? '';
     $unitcost =$data['item_cost'] ?? '';
     $amount =$data['amount'] ?? '';
     $status =$data['status'] ?? '';
     $paymethod =$data['pay_mode'] ?? '';
     if($paymethod == "others"){
         $paymethodfinal = 'Zelle';
     }
     elseif($paymethod == "cash"){
        $paymethodfinal = 'Cash';
     }
     elseif($paymethod == "check"){
        $paymethodfinal = 'Check';
     }
     elseif($paymethod == "directdeposit"){
        $paymethodfinal = 'Direct Deposit';
     }
     else{
         $paymethodfinal = 'Credit Card';
     }


     //$mailsubject = $subjetc."[Invoice #".$invoice_num." ]";

     $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
         <div class="email-token-class" style="text-align: justify;">
         <div class="email-token-class" style="text-align: center;">
         <div class="email-token-class" style="text-align: center;">
         <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
         <tbody>
         <tr>
         <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
         </tr>
         </tbody>
         </table>
         </div>
         <div class="email-token-class" style="text-align: center;">
         <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
         <tbody>
         <tr>
         <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>HDBS Payment Confirmation</strong></td>
         </tr>
         </tbody>
         </table>
         </div>
         <div class="email-token-class" style="text-align: center;">
         <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
         <tbody>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Order Id&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">'.$oid.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Owner Name&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$name.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Business Name &nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$businessname.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Tax Id &nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$taxid.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Payment For&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paytype.'</td>
        </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Type &nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$item_desc.'</td>
         </tr>
         <tr>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Method&nbsp;&nbsp;</td>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paymethodfinal.'</td>
        </tr>
        <tr>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Quantity &nbsp;&nbsp;</td>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$qty.'</td>
        </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount &nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$unitcost.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount &nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$amount.'</td>
         </tr>
        </tbody>
         </table>
         </div>
         </div>
         </div>';
     GzObject::loadFiles('Model', array('Vendor'));
     $VendorModel = new VendorModel();

     try {
         $mail = _gz_new_mailer(); //New instance, with exceptions enabled
         $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
         // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
         // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
         $mail->CharSet = 'UTF-8';
         $mail->AddAddress('varunkumar953685@gmail.com');
         $mail->addcc('varun.kumar@eicetechnology.com');
         $mail->Subject = $subjetc;
         $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
         $mail->WordWrap = 80; // set word wrap
         $mail->MsgHTML($message);
         $invoice = $data['invoice_id'] ?? '';
         $invoice_number = $data['invoice_num'] ?? '';

          if (!empty($invoice)) {
            $invoice_id = $data['invoice_id'];
           if (is_file(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'Vendordata_' . $invoice . '_invoice_' . $invoice_number . '.pdf')) {
                $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'Vendordata_' . $invoice . '_invoice_' . $invoice_number . '.pdf');
                //$mail->addAttachment('meeting.ics');   // attachment
            }
        }
         $mail->IsHTML(true); // send as HTML
         $mail->Send();
     } catch (PHPMailerException $e) {
         error_log('[userpaymentemail] PHPMailer error: ' . $e->getMessage());
     }
     return $invoice_id;
    // $_SESSION['status'] = 28;
     // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
    // Util::redirect(INSTALL_URL . "Donations/donation/");
 }
}   

// end user end vendor payment

// start vendor payment
function sendEmailvendor($data, $url)
{
 if (!empty($data)) {
     $subjetc='HDBS Vendor Payment';
     $totalamount =$data['amount'];
     //$membername =$data['MemberName'];
     $Amount =$data['item_cost'];
     $businessname =$data['businessname'];
     $ownername =$data['ownername'];
     $taxid = $data['taxid'];
     $quantity  =$data['item_number'];
     $paytype  =$data['paytype'];
     if ($paytype == 'BOOTH') {
        $paymentfor = 'Booth Rentals';
        $ccemail ='vendor@durgabari.org';
        
    } else if ($paytype == 'MAGADV') {
        $paymentfor = 'Magazine Advertisements';
        $ccemail ='advertisement@durgabari.org';
        
       
    } else if ($paytype == 'OTHADV') {
        $paymentfor = 'Other Advertisements';
        $ccemail ='advertisement@durgabari.org';
       
    }


     $type = $data['item_desc'];

     $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
         <div class="email-token-class" style="text-align: justify;">
         <div class="email-token-class" style="text-align: center;">
         <div class="email-token-class" style="text-align: center;">
         <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
         <tbody>
         <tr>
         <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
         </tr>
         </tbody>
         </table>
         </div>
         <div class="email-token-class" style="text-align: center;">
         <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
         <tbody>
         <tr>
         <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Vendor Payment</strong></td>
         </tr>
         </tbody>
         </table>
         </div>
         <div class="email-token-class" style="text-align: center;">
         <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
         <tbody>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Owner Name&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">'.$ownername.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Business Name&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$businessname.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Tax ID&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$taxid.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Payment For&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$paymentfor.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Type&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$type.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Quantity&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$quantity.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$Amount.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount &nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$totalamount.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment Url&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$url.'</td>
         </tr>
         
        </tbody>
         </table>
         </div>
         </div>
         </div>';
     GzObject::loadFiles('Model', array('Vendor'));
    $VendorModel = new VendorModel();

     try {
         $mail = _gz_new_mailer(); //New instance, with exceptions enabled
         $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
         // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
         // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
         $mail->CharSet = 'UTF-8';
         $mail->AddAddress('varunkumar953685@gmail.com');
         $mail->addcc('varun.kumar@eicetechnology.com');
         $mail->Subject = $subjetc;
         $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
         $mail->WordWrap = 80; // set word wrap
         $mail->MsgHTML($message);
         //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
         if (!empty($Badges['id']) && !empty($Badges['MID']) && is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . $Badges['id'] . '_invoice_' . $Badges['MID'] . '.pdf')) {
             $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . $Badges['id'] . '_invoice_' . $Badges['MID'] . '.pdf'); // attachment
         }
         $mail->IsHTML(true); // send as HTML
         $mail->Send();
     } catch (PHPMailerException $e) {
         //echo $e->errorMessage();
     }
    // $_SESSION['status'] = 28;
     // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
    // Util::redirect(INSTALL_URL . "Donations/donation/");
 }
}   

// end vendor payment
// start admin end vendor payment
function sendrecemail($data)
{
 if (!empty($data)) {
     $subjetc='HDBS Commercial Invoice';
     $name =$data['name'] ?? '';
     $business =$data['businessname'] ?? '';
     $oid =$data['oid'] ?? '';
     $custid =$data['custid'] ?? '';
     $email =$data['email'] ?? '';
     $paytype =$data['paytype'] ?? '';
     if ($paytype == 'BOOTH') {
        $payforui = 'Booth Rentals';
        $ccemail ='vendor@durgabari.org';
         
    } else if ($paytype == 'MAGADV') {
        $payforui = 'Magazine Advertisements';
        $ccemail ='advertisement@durgabari.org';
        
    } else if ($paytype == 'OTHADV') {
        $payforui = 'Other Advertisements';
        $ccemail ='advertisement@durgabari.org';
       
    }
     $created_on =$data['created_on'] ?? '';
     $invoice_id =$data['invoice_id'] ?? '';
     $invoice_num =$data['invoice_num'] ?? '';
     $item_desc =$data['item_desc'] ?? '';
     $qty =$data['item_number'] ?? '';
     $unitcost =$data['item_cost'] ?? '';
     $amount =$data['amount'] ?? '';
     $status =$data['status'] ?? '';

     //$mailsubject = $subjetc."[Invoice #".$invoice_num." ]";

     $message = '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
         <div class="email-token-class" style="text-align: justify;">
         <div class="email-token-class" style="text-align: center;">
         <div class="email-token-class" style="text-align: center;">
         <table style="height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="606">
         <tbody>
         <tr>
         <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><img src="' . INSTALL_URL . 'application/web/upload/image/create.png" alt="" width="396" height="66" /></td>
         </tr>
         </tbody>
         </table>
         </div>
         <div class="email-token-class" style="text-align: center;">
         <table style="height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
         <tbody>
         <tr>
         <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>HDBS Commercial Invoice</strong></td>
         </tr>
         </tbody>
         </table>
         </div>
         <div class="email-token-class" style="text-align: center;">
         <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
         <tbody>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">Owner Name&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left; width:50%;">'.$name.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Email &nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$email.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Payment For&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$payforui.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Type&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$item_desc.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Amount &nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$unitcost.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Total Amount &nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"><span style="color:red;">$</span>'.$amount.'</td>
         </tr>
         <tr>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;"> Invoice Date&nbsp;&nbsp;</td>
         <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$created_on.'</td>
         </tr>
        </tbody>
         </table>
         </div>
         </div>
         </div>';
     GzObject::loadFiles('Model', array('Vendor'));
    $VendorModel = new VendorModel();

     try {
         $mail = _gz_new_mailer(); //New instance, with exceptions enabled
         $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
         // $mail->From = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail — now set by _gz_new_mailer()
         // $mail->FromName = 'hdbs.payment@durgabari.org'; // shared-hosting sendmail
         $mail->CharSet = 'UTF-8';
         $mail->AddAddress('varunkumar953685@gmail.com');
         $mail->addcc('varun.kumar@eicetechnology.com');
         $mail->Subject = $subjetc;
         $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
         $mail->WordWrap = 80; // set word wrap
         $mail->MsgHTML($message);
         //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
         if (!empty($Badges['id']) && !empty($Badges['MID']) && is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . $Badges['id'] . '_invoice_' . $Badges['MID'] . '.pdf')) {
             $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Badges_' . $Badges['id'] . '_invoice_' . $Badges['MID'] . '.pdf'); // attachment
         }
         $mail->IsHTML(true); // send as HTML
         $mail->Send();
     } catch (PHPMailerException $e) {
         //echo $e->errorMessage();
     }
    // $_SESSION['status'] = 28;
     // echo "<script type='text/javascript'>window.open('$path','_self');</script>";
    // Util::redirect(INSTALL_URL . "Donations/donation/");
 }
}   

// end admin end vendor payment




//send sms
function SendSMS($mobileno, $msg)
{
    if (empty($mobileno)) {
        return;
    }

    // Normalize to E.164 format (+1XXXXXXXXXX for US numbers)
    $digits = preg_replace('/\D/', '', $mobileno);
    if (strlen($digits) === 10) {
        $to = '+1' . $digits;
    } elseif (strlen($digits) === 11 && substr($digits, 0, 1) === '1') {
        $to = '+' . $digits;
    } else {
        $to = '+' . $digits;
    }

    try {
        //hdbs twillo account setting
        $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
        $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
        $client = new Client($sid, $token);
        $client->messages->create(
            $to,
            array(
                'from' => '+12815016454',
                'body' => $msg
            )
        );
    } catch (\Exception $e) {
        error_log('[SendSMS] Failed to send SMS to ' . $to . ': ' . $e->getMessage());
    }

}

}


