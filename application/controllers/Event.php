<?php

require_once CONTROLLERS_PATH . 'App.php';

class Event extends App
{

    var $layout = 'admin';
    var $option_arr = null;

    function beforeFilter()
    {

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();
        $this->option_arr = $OptionModel->getAllPairValues();
        $this->tpl['option_arr'] = $OptionModel->getAllPairs();
        $this->tpl['option_arr_values'] = $this->option_arr;

        $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format']);
        $this->tpl['iso_format'] = Util::getISODateFormta($this->tpl['option_arr_values']['date_format']);

        $tz = $this->tpl['option_arr_values']['timezone'] ?? '';
        if ($tz) {
            date_default_timezone_set($tz);
        }

        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        // For search dropdown search box 
        $this->css[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/css/bootstrap-select.min.css', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/js/bootstrap-select.min.js', 'path' => JS_PATH);


        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);

        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);

        $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);

        // $this->js[] = array('file' => 'GzEvent.js', 'path' => JS_PATH);
         $this->js[] = array('file' => 'GzEvent.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
    }

    function AllMember()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();
        $arr = array();
        $Memberid = $_POST['memberid'] ?? '';
        $arr = $MemberModel->AllMember($Memberid);
        foreach ($arr as $key => $value) {
            echo  "<input  id='memberid' value='$value[Member_id]'/> ";
            echo  "<input  id='MemberName' value='$value[F_Name]'/> ";
            echo  "<input  id='middle_name' value='$value[M_Name]'/> ";
            echo  "<input  id='last_name' value='$value[L_Name]'/> ";
            echo  "<input  id='membershiptype' value='$value[membership_type]'/> ";
            echo  "<input  id='Spouse' value='$value[Sp_FName]'/> ";
            echo  "<input  id='Spouselast' value='$value[Sp_LName]'/> ";
            echo  "<input  id='ressidentalAddress' value='$value[Address1]'/> ";
            echo  "<input  id='Address' value='$value[Address2]'/> ";
            echo  "<input  id='Country' value='$value[Country]'/> ";
            echo  "<input  id='city' value='$value[City]'/> ";
            echo  "<input  id='state' value='$value[State]'/> ";
            echo  "<input  id='zip_code' value='$value[Zip]'/> ";
            echo  "<input  id='Tele1' value='$value[Tele1]'/> ";
            echo  "<input  id='phone_No' value='$value[Mob_No]'/> ";
            echo  "<input  id='phone_work' value='$value[Tele2]'/> ";
            echo  "<input  id='email' value='$value[email]'/> ";
        }
    }

    function checkdatevalid()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('Eventname'));
        $EventnameModel = new EventnameModel();
        $arr = $EventnameModel->checkdatevalid();
    }

    function checkdatevalid2()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('Eventname'));
        $EventnameModel = new EventnameModel();
        $arr = $EventnameModel->checkdatevalid2();
    }

    function checkdatevalid3()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('Eventname'));
        $EventnameModel = new EventnameModel();
        $arr = $EventnameModel->checkdatevalid3();
    }

    function checkdateevent()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('Eventname'));
        $EventnameModel = new EventnameModel();
        $arr = $EventnameModel->checkdateevent();
    }
    function getevent()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('Eventname'));
        $EventnameModel = new EventnameModel();
        $arr = $EventnameModel->getevent();
        $this->tpl['allevent'] =  $arr;
        foreach ($arr as $key => $value) {
            echo '<option value="' . $value['id'] . '">' . $value['events'] . '</option>';
        }
    }

    function checkticket()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('ticketeventname'));
        $ticketeventnameModel = new ticketeventnameModel();
        $arr = $ticketeventnameModel->checkticket();
        if (empty($arr)) {
            echo json_encode(['Events' => '', 'Image' => '', 'Desc' => '', 'Idevent' => '']);
            return;
        }
        $name = $arr['ticketevents'];
        $image = $arr['ticketavatar'];
        $desc = $arr['descriptionTable'];
        $eventid =  $arr['id'];
        $arr1 = ['Events' => $name];
        $arr2 = ['Image' =>  $image];
        $arr3 = ['Desc' => $desc];
        $arr4 = ['Idevent' => $eventid];
        $arr5 = $arr1 + $arr2 + $arr3 + $arr4;


        echo json_encode($arr5);
    }

    function ticketprice()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('ticketeventday'));
        $ticketeventdayModel = new ticketeventdayModel();
        $arr = $ticketeventdayModel->ticketprice();
        $this->tpl['ticketprice'] =  $arr;
        foreach ($arr as $key => $value) {

            echo '<option value="' . $value['ticketprice'] . '">' . $value['itemeventday'] . '</option>';
        }
    }

    function logPaymentError($message)
    {
        $logFile = $_SERVER['DOCUMENT_ROOT'] . "/payment_error.log";
        // $logFile = __DIR__ . "/payment_error.log";   // log file in same folder as Event.php
        // $logFile = $_SERVER['DOCUMENT_ROOT'] . "./payment_error.log";
        $time = date("Y-m-d H:i:s");
        $entry = "[$time] $message" . PHP_EOL;
        file_put_contents($logFile, $entry, FILE_APPEND); // append log
    }

    function event()
    {
        $this->layout = 'login';

        GzObject::loadFiles('Model', array('Event', 'ConfirmCode', 'Member', 'Eventname', 'Donation', 'idnumbers', 'vendorpaymentaccount', 'ThresholdAmount'));
        $EventModel = new EventModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $DonationModel = new DonationModel();
        $EventnameModel = new EventnameModel();
        $idnumbersModel = new idnumbersModel();
        $arr = $EventnameModel->getevents();

        // 28 july
        $vendorpaymentaccountModel = new vendorpaymentaccountModel();
        $ThresholdAmount = new ThresholdAmountModel();
        $EventThresholdAmount =  $ThresholdAmount->getThresholdAmount();
        $EventThresholdAmount = $EventThresholdAmount[0]['amount'] ?? null;

        $this->tpl['Eventname'] =  $arr;
        $this->tpl['members'] = $MemberModel->getAll();

        // api key according to account

        $result = $vendorpaymentaccountModel->getEventPaymentAccountName("event");
        $accountType = $result[0]['paymentaccount'] ?? null;

        $this->tpl['account_type'] =  $accountType;
        $xmlPath = __DIR__ . '/../../web.config';
        $xml = simplexml_load_file($xmlPath);
        $stripePublishedKey = (defined('STRIPE_PUBLISHABLE_KEY') && STRIPE_PUBLISHABLE_KEY !== '') ? STRIPE_PUBLISHABLE_KEY : (string) $xml->appSettings->add[0]->attributes()->value;
        $this->tpl['StripePublishedApiKey'] = $stripePublishedKey;

        $result2 = $vendorpaymentaccountModel->getEventPaymentAccountName("event2");
        $accountType2 = $result2[0]['paymentaccount'] ?? null;

        $result3 = $vendorpaymentaccountModel->getEventPaymentAccountName("event3");
        $accountType3 = $result3[0]['paymentaccount'] ?? null;




        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['EventPaymentProcessed']);
        }

        if (!empty($_POST['create_event'])) {

            if (isset($_SESSION['EventPaymentProcessed']) && $_SESSION['EventPaymentProcessed'] === true) {
                unset($_SESSION['EventPaymentProcessed']);
                Util::redirect(INSTALL_URL . "Event/event");
                exit();
            }

            $data = array();
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['pay_date'] = $today;
            $_POST['pay_type'] = 'EVENT';
            $_POST['pay_for'] = 'EVENT' . '/' . ($_POST['type'] ?? '');

            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for

            $memberid = $_POST['demmember'] ?? '';
            $_POST['Member_id'] = $memberid;
            $registermember = $_POST['MemberName'] ?? '';
            $regmember = $_POST['regmember'] ?? '';


            $datamember =  $MemberModel->checkduplicatemember();
            if ($datamember == null) {

                // for generate memberid for gd
                $maxid = $idnumbersModel->getMaxmid() + 1;
                $update_mid = $idnumbersModel->Updatemid($maxid);
                $_POST['Member_id'] = $maxid;
                // end generate memberid for gd 
            }
            if ($datamember != null) {
                $_POST['Member_id'] = $datamember;
            }

            if ($regmember == "nonmember") {
                $nonmember = $_POST['namenonmember'] ?? '';
                $_POST['MemberName'] = $nonmember;
            } else {

                $_POST['MemberName'] = $registermember;
            }
            $id = $EventModel->getMaxid() + 1;
            $data['id'] = $id;
            $_POST['id'] = $id;
            $_POST['eventid'] = $_POST['uniqueeventid'] ?? '';

            // Ensure float columns are never empty string (causes DB truncation)
            $_POST['eventdonation'] = strlen(trim($_POST['eventdonation'] ?? '')) > 0 ? floatval($_POST['eventdonation']) : 0;
            // Ensure NOT NULL columns without defaults always have a value
            $_POST['Address']      = $_POST['Address']      ?? '';
            $_POST['Street']       = $_POST['Street']       ?? '';
            $_POST['State']        = $_POST['State']        ?? '';
            $_POST['Zip_Code']     = $_POST['Zip_Code']     ?? '';
            $_POST['Phone_Number'] = $_POST['Phone_Number'] ?? '';
            $_POST['City']         = $_POST['City']         ?? '';
            $_POST['cc_name']      = $_POST['cc_name']      ?? '';
            $_POST['remarks']      = $_POST['remarks']      ?? '';
            $_POST['description']  = $_POST['description']  ?? '';

            $EventModel->save(array_merge($_POST, $data));
            if (!empty($id)) {

                if (($_POST['PaymentOption'] ?? '') == 'others') {

                    $opts = array();
                    $cmCode = $_POST['code'] ?? '';
                    $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                    $_POST['transaction_id'] =  $cmCode;
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                    $arr = $ConfirmCodeModel->getAll($opts);
                    $oid = $_POST['oid'] ?? '';
                    //if (!empty($arr[0])) {
                    if ($oid != null) {
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['payment_status'] = 'succeeded';
                        $data = $_POST;
                        $MemberName = $_POST['MemberName'] ?? '';
                        $Amount = $_POST['totaldonation'] ?? '';
                        $payment_status = $opts['payment_status'];
                        $memberid = $_POST['Member_id'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                        $eventname = $_POST['type'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $description = $_POST['description'] ?? '';

                        echo "<div style='margin-left:23em;' class = 'pay'>
                            <table border='4'  width='585px' style='margin-left:4em;'>
                            <tr>
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                           <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                            <tr> <td>Member Id</td> <td>" . $memberid . "</td></tr>
                            <tr><td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                            <tr><td>Event Name</td> <td>" . $eventname . "</td> </tr>
                           <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount .  "</td> </tr>
                            <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                            <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                            <tr><td>Additional Comments </td> <td>" . $description .   "</td> </tr>
                           <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                           </tr>";
                        echo "</table>";
                        echo "</div>";
                        echo "<a  href='" . INSTALL_URL . "Event/event'>Go to home</a>";

                        $this->sendEmailEvent($data);
                        $datamemberarr = array();
                        $datamemberarr =  array_merge($opts, $_POST);
                        $EventModel->update(array_merge($opts, $_POST));
                        
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['eventid'] = $datamemberarr['eventid'];
                        $value['type'] = $datamemberarr['type'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['MemberName'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['update_on'] ?? ($datamemberarr['UpdateOn'] ?? '');
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['Tele1'];
                        $value['email'] = $datamemberarr['email'];
                        $extradonationamount = $datamemberarr['eventdonation'];

                        if ($extradonationamount == null) {
                            $value['Amount'] = $datamemberarr['Amount'];
                            $DonationModel->SaveDataInDonation($value);
                        }
                        //   if($extradonationamount != null){
                        //           for($i=0;$i<=1;$i++){
                        //               if($i==0){
                        //                   $value['pay_type'] = $datamemberarr['pay_type'];
                        //                   $value['pay_for'] = $datamemberarr['pay_for'];
                        //                   $value['Amount'] = $datamemberarr['Amount'];
                        //                   $DonationModel->SaveDataInDonation($value);
                        //               }
                        //               if($i==1){
                        //                   //$value['pay_type'] = 'OTHER';
                        //                   //$value['pay_for'] = $datamemberarr['pay_for'];
                        //                     $value['pay_type'] = 'DONATION';
                        //                     $value['pay_for'] = 'DONATION / Unrestricted';
                        //                   $value['Amount'] = $extradonationamount;
                        //                   $DonationModel->SaveDataInDonation($value);
                        //               }

                        //           }
                        //       }

                        // 28 july
                        if ($extradonationamount != null) {
                            for ($i = 0; $i <= 1; $i++) {
                                if ($i == 0) {
                                    if ($extradonationamount <= $EventThresholdAmount) {

                                        $value['pay_type'] = $datamemberarr['pay_type'];
                                        $value['pay_for'] = $datamemberarr['pay_for'];
                                        $value['Amount'] = $datamemberarr['Amount'] + $extradonationamount;
                                        $DonationModel->SaveDataInDonation($value);
                                    } else {
                                        $value['pay_type'] = $datamemberarr['pay_type'];
                                        $value['pay_for'] = $datamemberarr['pay_for'];
                                        $value['Amount'] = $datamemberarr['Amount'] + $EventThresholdAmount;
                                        $DonationModel->SaveDataInDonation($value);
                                    }
                                }
                                if ($i == 1) {
                                    if ($extradonationamount > $EventThresholdAmount) {

                                        $value['pay_type'] = 'DONATION';
                                        $value['pay_for'] = 'DONATION / Unrestricted';
                                        $value['Amount'] = $extradonationamount - $EventThresholdAmount;
                                        $DonationModel->SaveDataInDonation($value);
                                    }
                                }
                            }
                        }

                        if ($datamember == null) {
                            $value = array();
                            $value['type'] = $_POST['type'] ?? '';
                            $value['MemberName'] = $_POST['MemberName'] ?? '';
                            $value['Amount'] = $_POST['Amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                            $value['update_on'] = $_POST['update_on'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['pay_date'] = $_POST['pay_date'] ?? '';
                            $value['cc_name'] = $_POST['cc_name'] ?? '';
                            $value['remarks'] = $_POST['remarks'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['Address'] = $_POST['Address'] ?? '';
                            $value['Street'] = $_POST['Street'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                            $value['Phone_Number'] = $_POST['Phone_Number'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['Tele1'] = $_POST['Tele1'] ?? '';
                            $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                            $value['totaldonation'] = $_POST['totaldonation'] ?? '';
                            $value['Address3'] = $_POST['Address3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $mobileno = $data['Tele1'];
                        if ($data['Tele1'] != null) {
                            $msg = 'Houston Durga Bari: Event confirmation are Member Id: ' . $data['Member_id'] . ',  Order Id: ' . $data['oid'] . ', Member Name: ' . $data['MemberName'] . ' , Event Name: ' . $data['type'] . ' , Amount: $' . $data['totaldonation'] . ', Pay Date: ' . $payfinaldate . ',  Status: ' . $opts['payment_status'];
                            try { $this->SendSMS($mobileno, $msg); } catch (Exception $smsEx) { $this->logPaymentError("SMS error OrderID: " . ($data['oid'] ?? '') . " | " . $smsEx->getMessage()); }
                        }
                        $_SESSION['EventPaymentProcessed'] = true;
                        exit();
                    }
                } elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                    //$amount = $_POST['Amount'];
                    $amount = $_POST['totaldonation'] ?? '';


                    $total = $amount;

                    require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                    $error = '';
                    $success = '';

                    // Stripe::setApiKey1($this->tpl["option_arr_values"]["stripe_api_key"]);
                    $xmlPath = __DIR__ . '/../../web.config';
                    $xml = simplexml_load_file($xmlPath);
                    $stripeApiKey = (defined('STRIPE_PUJA_SECRET_KEY') && STRIPE_PUJA_SECRET_KEY !== '') ? STRIPE_PUJA_SECRET_KEY : (string) $xml->appSettings->add[1]->attributes()->value;
                    // Stripe::setApiKey2($this->tpl["option_arr_values"]["stripe_api_key"], $accountType, $stripeApiKey);

                    // if (($_POST['event'] ?? '') == "event2")
                    // {
                    //      Stripe::setApiKey2($this->tpl["option_arr_values"]["stripe_api_key"], $accountType2, $stripeApiKey);
                    //      $this->logPaymentError("stripe key for event 2: $oid | key: {$stripeApiKey} | account: {$accountType2}");
                    // }

                    // else
                    // {
                    //     Stripe::setApiKey2($this->tpl["option_arr_values"]["stripe_api_key"], $accountType, $stripeApiKey);
                    //     $this->logPaymentError("stripe key for event : $oid | key: {$stripeApiKey} | account: {$accountType}");
                    // }



                    $oid = $_POST['oid'] ?? '';
                    if (($_POST['event'] ?? '') == "event2") {
                        Stripe::setApiKey2($this->tpl["option_arr_values"]["stripe_api_key"], $accountType2, $stripeApiKey);
                        $this->logPaymentError("stripe key for event 2: $oid | key: {$stripeApiKey} | account: {$accountType2}");
                    } elseif (($_POST['event'] ?? '') == "event3") {
                        Stripe::setApiKey2($this->tpl["option_arr_values"]["stripe_api_key"], $accountType3, $stripeApiKey);
                        $this->logPaymentError("stripe key for event 3: $oid | key: {$stripeApiKey} | account: {$accountType3}");
                    } else {
                        Stripe::setApiKey2($this->tpl["option_arr_values"]["stripe_api_key"], $accountType, $stripeApiKey);
                        $this->logPaymentError("stripe key for event 1: $oid | key: {$stripeApiKey} | account: {$accountType}");
                    }

                    try {
                        if (!isset($_POST['stripeToken'])) {
                            throw new Exception("The Stripe Token was not generated correctly");
                        }
                        $amount = round($amount * 100);

                        $payment = Stripe_Charge::create(array(
                            "amount" => $amount,
                            "currency" => "USD",
                            //"currency" => "INR",
                            "card" => $_POST['stripeToken'],
                            // "description" => $id.', '.$_POST['MemberName'],
                            "description" =>  "Pay For:" . $_POST['pay_for'] . ', ' . "Email:" . $_POST['email'] . ', ' . "Full Name:" . ($_POST['MemberName'] ?? ''),
                            "metadata" => ["orderid" => $oid]
                        ));

                        $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                        $this->tpl['payment']['amount'] = $payment->amount;
                        $this->tpl['payment']['status'] = $payment->status;
                        $this->tpl['payment']['currency'] = $payment->currency;

                        if ($payment->status == 'succeeded') {

                            $this->logPaymentError("Payment success for OrderID: $oid | Status: {$payment->status} | Email: {$_POST['email']}");

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            $opts['payment_status'] = 'succeeded';
                            $opts['payment_timestamp'] = time();
                            //thankyou screen UI
                            $data = $_POST;
                            $MemberName = $_POST['MemberName'] ?? '';
                            $Amount = $_POST['totaldonation'] ?? '';
                            $transaction_id = $opts['transaction_id'];
                            $payment_status = $opts['payment_status'];
                            $memberid = $_POST['Member_id'] ?? '';
                            $datefor = $_POST['pay_date'] ?? '';
                            $eventname = $_POST['type'] ?? '';
                            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                            $description = $_POST['description'] ?? '';

                            echo "<div style='margin-left:23em;' class = 'pay'>
                           <table border='4'  width='585px' style='margin-left:4em;'>
                            <tr>
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                          
                             <tr><td style='width:50%;'>Order Id</td><td style='width:50%;'>" . $oid . "</td></tr>
                             <tr>
                            <td>Member Id</td> <td>" . $memberid . "</td></tr>
                            <tr>
                           <td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                           <tr><td>Event Name</td> <td>" . $eventname . "</td> </tr>
                           <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount .  "</td> </tr>
                           <tr><td>Payment Method</td> <td>Credit Card</td>  </tr>
                           <tr><td>Transaction Id</td> <td>" . $transaction_id .   "</td> </tr>
                           <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                           <tr><td>Additional Comments </td> <td>" . $description .   "</td> </tr>
                           <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                           </tr>";

                            echo "</table>";
                            echo "</div>";
                            echo "<a  href='" . INSTALL_URL . "Event/event'>Go to home</a>";
                            $this->sendEmailEvent($data);
                            $datamemberarr = array();
                            $datamemberarr =  array_merge($opts, $_POST);
                            $EventModel->update(array_merge($opts, $_POST));

                            $value = array();
                            $value['oid'] = $datamemberarr['oid'];
                            $value['eventid'] = $datamemberarr['eventid'];
                            $value['type'] = $datamemberarr['type'];
                            $value['Member_id'] = $datamemberarr['Member_id'];
                            $value['MemberName'] = $datamemberarr['MemberName'];
                            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                            $value['payment_status'] = 'succeeded';
                            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                            $value['transaction_id'] = $datamemberarr['transaction_id'];
                            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                            $value['update_on'] = $datamemberarr['UpdateOn'] ?? ($datamemberarr['update_on'] ?? '');
                            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                            $value['pay_date'] = $datamemberarr['pay_date'];
                            $value['pay_type'] = $datamemberarr['pay_type'];
                            $value['pay_for'] = $datamemberarr['pay_for'];
                            $value['Tele1'] = $datamemberarr['Tele1'];
                            $value['email'] = $datamemberarr['email'];
                            $extradonationamount = $datamemberarr['eventdonation'];

                            if ($extradonationamount == null) {
                                $value['Amount'] = $datamemberarr['Amount'];
                                $DonationModel->SaveDataInDonation($value);
                            }
                            //   if($extradonationamount != null){
                            //             for($i=0;$i<=1;$i++){
                            //                 if($i==0){
                            //                     $value['pay_type'] = $datamemberarr['pay_type'];
                            //                     $value['pay_for'] = $datamemberarr['pay_for'];
                            //                     $value['Amount'] = $datamemberarr['Amount'];
                            //                     $DonationModel->SaveDataInDonation($value);
                            //                 }
                            //                 if($i==1){
                            //                     //$value['pay_type'] = 'OTHER';
                            //               //$value['pay_for'] = $datamemberarr['pay_for'];
                            //                 $value['pay_type'] = 'DONATION';
                            //                 $value['pay_for'] = 'DONATION / Unrestricted';
                            //                     $value['Amount'] = $extradonationamount;
                            //                     $DonationModel->SaveDataInDonation($value);
                            //                 }

                            //             }
                            //         }

                            // 28 th july

                            if ($extradonationamount != null) {
                                for ($i = 0; $i <= 1; $i++) {


                                    if ($i == 0) {

                                        if ($extradonationamount <= $EventThresholdAmount) {

                                            $value['pay_type'] = $datamemberarr['pay_type'];
                                            $value['pay_for'] = $datamemberarr['pay_for'];
                                            $value['Amount'] = $datamemberarr['Amount'] + $extradonationamount;
                                            $DonationModel->SaveDataInDonation($value);
                                        } else {
                                            $value['pay_type'] = $datamemberarr['pay_type'];
                                            $value['pay_for'] = $datamemberarr['pay_for'];
                                            $value['Amount'] = $datamemberarr['Amount'] + $EventThresholdAmount;
                                            $DonationModel->SaveDataInDonation($value);
                                        }
                                    }

                                    if ($i == 1) {

                                        if ($extradonationamount > $EventThresholdAmount) {

                                            $value['pay_type'] = 'DONATION';
                                            $value['pay_for'] = 'DONATION / Unrestricted';
                                            $value['Amount'] = $extradonationamount - $EventThresholdAmount;
                                            $DonationModel->SaveDataInDonation($value);
                                        }


                                        //$value['pay_type'] = 'OTHER';
                                        //$value['pay_for'] = $datamemberarr['pay_for'];

                                        // $value['pay_type'] = 'DONATION';
                                        // $value['pay_for'] = 'DONATION / Unrestricted';
                                        // $value['Amount'] = $extradonationamount;
                                        // $resultvalue =  $DonationModel->SaveDataInDonation($value);
                                    }
                                }
                            }


                            if ($datamember == null) {
                                $value = array();
                                $value['type'] = $_POST['type'] ?? '';
                                $value['gift'] = $_POST['gift'] ?? '';
                                $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                $value['MemberName'] = $_POST['MemberName'] ?? '';
                                $value['Amount'] = $_POST['Amount'] ?? '';
                                $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                                $value['payment_status'] = 'confirmed';
                                $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                                $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                $value['transaction_id'] = $opts['transaction_id'];
                                $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['update_on'] = $_POST['update_on'] ?? '';
                                $value['Member_id'] = $_POST['Member_id'] ?? '';
                                $value['pay_date'] = $_POST['pay_date'] ?? '';
                                $value['cc_name'] = $_POST['cc_name'] ?? '';
                                $value['remarks'] = $_POST['remarks'] ?? '';
                                $value['oid'] = $_POST['oid'] ?? '';
                                $value['pay_type'] = $_POST['pay_type'] ?? '';
                                $value['pay_for'] = $_POST['pay_for'] ?? '';
                                $value['Address'] = $_POST['Address'] ?? '';
                                $value['Street'] = $_POST['Street'] ?? '';
                                $value['State'] = $_POST['State'] ?? '';
                                $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                                $value['Phone_Number'] = $_POST['Phone_Number'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['City'] = $_POST['City'] ?? '';
                                $value['Tele1'] = $_POST['Tele1'] ?? '';
                                $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                                $value['totaldonation'] = $_POST['totaldonation'] ?? '';
                                $value['Address3'] = $_POST['Address3'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                            $mobileno = $data['Tele1'];
                            if ($data['Tele1'] != null) {
                                $msg = 'Houston Durga Bari: Event confirmation are Member Id: ' . $data['Member_id'] . ',  Order Id: ' . $data['oid'] . ', Member Name: ' . $data['MemberName'] . ' , Event Name: ' . $data['type'] . ' , Amount: $' . $data['totaldonation'] . ', Pay Date: ' . $payfinaldate . ',  Status: ' . $opts['payment_status'];
                                try { $this->SendSMS($mobileno, $msg); } catch (Exception $smsEx) { $this->logPaymentError("SMS error OrderID: " . ($data['oid'] ?? '') . " | " . $smsEx->getMessage()); }
                            }

                            $this->tpl['arr'] = $EventModel->get($id);
                            $_SESSION['EventPaymentProcessed'] = true;
                        } else {

                            // ❌ Payment failed
                            $this->logPaymentError("Payment FAILED for OrderID: $oid | Status: {$payment->status} | Email: {$_POST['email']}");
                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            $EventModel->update($opts);

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    }

                    //     catch (Exception $ex) {
                    //   $_SESSION['status'] = $ex->getMessage();
                    //     }


                    catch (\Stripe\Exception\CardException $e) {
                        // Card declined or card-specific error
                        $this->logPaymentError("Card error for OrderID: $oid | Message: " . $e->getError()->message);
                        if (!headers_sent()) {
                            header("Refresh:0");
                        }
                        exit;
                    } catch (\Stripe\Exception\RateLimitException $e) {
                        // Too many requests
                        $this->logPaymentError("Rate limit error | OrderID: $oid | " . $e->getMessage());
                        if (!headers_sent()) {
                            header("Refresh:0");
                        }
                        exit;
                    } catch (\Stripe\Exception\InvalidRequestException $e) {
                        // Invalid parameters
                        $this->logPaymentError("Invalid request | OrderID: $oid | " . $e->getMessage());
                        if (!headers_sent()) {
                            header("Refresh:0");
                        }
                        exit;
                    } catch (\Stripe\Exception\AuthenticationException $e) {
                        // Authentication with Stripe API failed
                        $this->logPaymentError("Auth error | OrderID: $oid | " . $e->getMessage());
                        if (!headers_sent()) {
                            header("Refresh:0");
                        }
                        exit;
                    } catch (\Stripe\Exception\ApiConnectionException $e) {
                        // Network communication error
                        $this->logPaymentError("Network error | OrderID: $oid | " . $e->getMessage());
                        if (!headers_sent()) {
                            header("Refresh:0");
                        }
                        exit;
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                        // Generic Stripe API error
                        $this->logPaymentError("Stripe API error | OrderID: $oid | " . $e->getMessage());
                        if (!headers_sent()) {
                            header("Refresh:0");
                        }
                        exit;
                    } catch (Exception $e) {
                        // Catch any other PHP error
                        $this->logPaymentError("General error | OrderID: $oid | " . $e->getMessage());
                        if (!headers_sent()) {
                            header("Refresh:0");
                        }
                        exit;
                    }

                    $this->tpl['arr'] = $EventModel->get($id);
                    if (is_array($this->tpl['arr'])) {
                        $this->tpl['arr']['amount'] = $total;
                    }
                } else {
                    $_SESSION['status'] = 16;
                }
            } else {
                $_SESSION['status'] = 17;
            }
            exit();
        }
    }
    function event2()
    {
        $this->layout = 'login';

        GzObject::loadFiles('Model', array('Event', 'ConfirmCode', 'Member', 'Eventname', 'Donation', 'idnumbers', 'vendorpaymentaccount', 'ThresholdAmount'));
        $EventModel = new EventModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $DonationModel = new DonationModel();
        $EventnameModel = new EventnameModel();
        $idnumbersModel = new idnumbersModel();
        $arr = $EventnameModel->getevents2();

        // 28 july
        $vendorpaymentaccountModel = new vendorpaymentaccountModel();
        $ThresholdAmount = new ThresholdAmountModel();
        $EventThresholdAmount = $ThresholdAmount->getThresholdAmount();
        $EventThresholdAmount = $EventThresholdAmount[0]['amount'] ?? null;

        $this->tpl['Eventname'] =  $arr;

        $this->tpl['members'] = $MemberModel->getAll();

        $result = $vendorpaymentaccountModel->getEventPaymentAccountName("event2");
        $accountType = $result[0]['paymentaccount'] ?? null;
        $this->tpl['account_type'] =  $accountType;

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['PaymentProcessed']);
        }


        // $xmlPath = __DIR__ . '/../../web.config';
        // $xml = simplexml_load_file($xmlPath);
        // $stripePublishedKey = (defined('STRIPE_PUBLISHABLE_KEY') && STRIPE_PUBLISHABLE_KEY !== '') ? STRIPE_PUBLISHABLE_KEY : (string) $xml->appSettings->add[0]->attributes()->value;
        // $this->tpl['StripePublishedApiKey'] = $stripePublishedKey;

        $xmlPath = __DIR__ . '/../../web.config';
        $xml = simplexml_load_file($xmlPath);
        $stripePublishedKey = (defined('STRIPE_PUBLISHABLE_KEY') && STRIPE_PUBLISHABLE_KEY !== '') ? STRIPE_PUBLISHABLE_KEY : (string) $xml->appSettings->add[0]->attributes()->value;
        $this->tpl['StripePublishedApiKey'] = $stripePublishedKey;

        if (!empty($_POST['create_event'])) {

            if (isset($_SESSION['PaymentProcessed']) && $_SESSION['PaymentProcessed'] === true) {
                unset($_SESSION['PaymentProcessed']);
                Util::redirect(INSTALL_URL . "Event/event2");
                exit();
            }
            $data = array();
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['pay_date'] = $today;
            $_POST['pay_type'] = 'EVENT';
            $_POST['pay_for'] = 'EVENT' . '/' . ($_POST['type'] ?? '');

            // for generate oid
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for

            $memberid = $_POST['demmember'] ?? '';
            $_POST['Member_id'] = $memberid;
            $registermember = $_POST['MemberName'] ?? '';
            $regmember = $_POST['regmember'] ?? '';


            $datamember =  $MemberModel->checkduplicatemember();
            if ($datamember == null) {

                // for generate memberid for gd
                $maxid = $idnumbersModel->getMaxmid() + 1;
                $update_mid = $idnumbersModel->Updatemid($maxid);
                $_POST['Member_id'] = $maxid;
                // end generate memberid for gd
            }
            if ($datamember != null) {
                $_POST['Member_id'] = $datamember;
            }

            if ($regmember == "nonmember") {
                $nonmember = $_POST['namenonmember'] ?? '';
                $_POST['MemberName'] = $nonmember;
            } else {

                $_POST['MemberName'] = $registermember;
            }
            $id = $EventModel->getMaxid() + 1;
            $data['id'] = $id;
            $_POST['id'] = $id;
            $_POST['eventid'] = $_POST['uniqueeventid'] ?? '';

            // Ensure float columns are never empty string (causes DB truncation)
            $_POST['eventdonation'] = strlen(trim($_POST['eventdonation'] ?? '')) > 0 ? floatval($_POST['eventdonation']) : 0;
            // Ensure NOT NULL columns without defaults always have a value
            $_POST['Address']      = $_POST['Address']      ?? '';
            $_POST['Street']       = $_POST['Street']       ?? '';
            $_POST['State']        = $_POST['State']        ?? '';
            $_POST['Zip_Code']     = $_POST['Zip_Code']     ?? '';
            $_POST['Phone_Number'] = $_POST['Phone_Number'] ?? '';
            $_POST['City']         = $_POST['City']         ?? '';
            $_POST['cc_name']      = $_POST['cc_name']      ?? '';
            $_POST['remarks']      = $_POST['remarks']      ?? '';
            $_POST['description']  = $_POST['description']  ?? '';

            $this->logPaymentError("EVENT2 SAVE ATTEMPT | id=$id | MemberName=" . ($_POST['MemberName'] ?? '') . " | oid=" . ($_POST['oid'] ?? '') . " | Amount=" . ($_POST['Amount'] ?? '') . " | pay_type=" . ($_POST['pay_type'] ?? '') . " | PaymentOption=" . ($_POST['PaymentOption'] ?? ''));
            $saveResult = $EventModel->save(array_merge($_POST, $data));
            $this->logPaymentError("EVENT2 SAVE RESULT | id=$id | result=" . ($saveResult ? 'SUCCESS' : 'FAILED/FALSE'));
            if (!empty($id)) {

                if (($_POST['PaymentOption'] ?? '') == 'others') {

                    $opts = array();
                    $cmCode = $_POST['code'] ?? '';
                    $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                    $_POST['transaction_id'] =  $cmCode;
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                    $arr = $ConfirmCodeModel->getAll($opts);
                    $oid = $_POST['oid'] ?? '';
                    //if (!empty($arr[0])) {
                    if ($oid != null) {
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['payment_status'] = 'succeeded';
                        $data = $_POST;
                        $MemberName = $_POST['MemberName'] ?? '';
                        $Amount = $_POST['totaldonation'] ?? '';
                        $payment_status = $opts['payment_status'];
                        $memberid = $_POST['Member_id'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                        $eventname = $_POST['type'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $description = $_POST['description'] ?? '';

                        echo "<div style='margin-left:23em;' class = 'pay'>
                            <table border='4'  width='585px' style='margin-left:4em;'>
                            <tr>
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                           <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                            <tr> <td>Member Id</td> <td>" . $memberid . "</td></tr>
                            <tr><td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                            <tr><td>Event Name</td> <td>" . $eventname . "</td> </tr>
                           <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount .  "</td> </tr>
                            <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                            <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                            <tr><td>Additional Comments </td> <td>" . $description .   "</td> </tr>
                           <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                           </tr>";
                        echo "</table>";
                        echo "</div>";
                        echo "<a  href='" . INSTALL_URL . "Event/event'>Go to home</a>";

                        $this->sendEmailEvent($data);
                        $datamemberarr = array();
                        $datamemberarr =  array_merge($opts, $_POST);
                        $EventModel->update(array_merge($opts, $_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['eventid'] = $datamemberarr['eventid'];
                        $value['type'] = $datamemberarr['type'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['MemberName'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['update_on'] ?? ($datamemberarr['UpdateOn'] ?? '');
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['Tele1'];
                        $value['email'] = $datamemberarr['email'];
                        $extradonationamount = $datamemberarr['eventdonation'];

                        if ($extradonationamount == null) {
                            $value['Amount'] = $datamemberarr['Amount'];
                            $DonationModel->SaveDataInDonation($value);
                        }
                        //   if($extradonationamount != null){
                        //           for($i=0;$i<=1;$i++){
                        //               if($i==0){
                        //                   $value['pay_type'] = $datamemberarr['pay_type'];
                        //                   $value['pay_for'] = $datamemberarr['pay_for'];
                        //                   $value['Amount'] = $datamemberarr['Amount'];
                        //                   $DonationModel->SaveDataInDonation($value);
                        //               }
                        //               if($i==1){
                        //                   //$value['pay_type'] = 'OTHER';
                        //                   //$value['pay_for'] = $datamemberarr['pay_for'];
                        //                     $value['pay_type'] = 'DONATION';
                        //                     $value['pay_for'] = 'DONATION / Unrestricted';
                        //                   $value['Amount'] = $extradonationamount;
                        //                   $DonationModel->SaveDataInDonation($value);
                        //               }

                        //           }
                        //       }


                        if ($extradonationamount != null) {
                            for ($i = 0; $i <= 1; $i++) {
                                if ($i == 0) {
                                    if ($extradonationamount <= $EventThresholdAmount) {

                                        $value['pay_type'] = $datamemberarr['pay_type'];
                                        $value['pay_for'] = $datamemberarr['pay_for'];
                                        $value['Amount'] = $datamemberarr['Amount'] + $extradonationamount;
                                        $DonationModel->SaveDataInDonation($value);
                                    } else {
                                        $value['pay_type'] = $datamemberarr['pay_type'];
                                        $value['pay_for'] = $datamemberarr['pay_for'];
                                        $value['Amount'] = $datamemberarr['Amount'] + $EventThresholdAmount;
                                        $DonationModel->SaveDataInDonation($value);
                                    }
                                }
                                if ($i == 1) {
                                    if ($extradonationamount > $EventThresholdAmount) {

                                        $value['pay_type'] = 'DONATION';
                                        $value['pay_for'] = 'DONATION / Unrestricted';
                                        $value['Amount'] = $extradonationamount - $EventThresholdAmount;
                                        $DonationModel->SaveDataInDonation($value);
                                    }
                                }
                            }
                        }

                        if ($datamember == null) {
                            $value = array();
                            $value['type'] = $_POST['type'] ?? '';
                            $value['MemberName'] = $_POST['MemberName'] ?? '';
                            $value['Amount'] = $_POST['Amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                            $value['update_on'] = $_POST['update_on'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['pay_date'] = $_POST['pay_date'] ?? '';
                            $value['cc_name'] = $_POST['cc_name'] ?? '';
                            $value['remarks'] = $_POST['remarks'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['Address'] = $_POST['Address'] ?? '';
                            $value['Street'] = $_POST['Street'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                            $value['Phone_Number'] = $_POST['Phone_Number'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['Tele1'] = $_POST['Tele1'] ?? '';
                            $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                            $value['totaldonation'] = $_POST['totaldonation'] ?? '';
                            $value['Address3'] = $_POST['Address3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $mobileno = $data['Tele1'];
                        if ($data['Tele1'] != null) {
                            $msg = 'Houston Durga Bari: Event confirmation are Member Id: ' . $data['Member_id'] . ',  Order Id: ' . $data['oid'] . ', Member Name: ' . $data['MemberName'] . ' , Event Name: ' . $data['type'] . ' , Amount: $' . $data['totaldonation'] . ', Pay Date: ' . $payfinaldate . ',  Status: ' . $opts['payment_status'];
                            try { $this->SendSMS($mobileno, $msg); } catch (Exception $smsEx) { $this->logPaymentError("SMS error OrderID: " . ($data['oid'] ?? '') . " | " . $smsEx->getMessage()); }
                        }
                        $_SESSION['PaymentProcessed'] = true;
                        exit();
                    }
                } elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                    //$amount = $_POST['Amount'];
                    $amount = $_POST['totaldonation'] ?? '';


                    $total = $amount;

                    require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                    $error = '';
                    $success = '';

                    // Stripe::setApiKey1($this->tpl["option_arr_values"]["stripe_api_key"]);

                    // $xmlPath = __DIR__ . '/../../web.config';
                    // $xml = simplexml_load_file($xmlPath);
                    // $stripeApiKey = (defined('STRIPE_PUJA_SECRET_KEY') && STRIPE_PUJA_SECRET_KEY !== '') ? STRIPE_PUJA_SECRET_KEY : (string) $xml->appSettings->add[1]->attributes()->value;
                    // Stripe::setApiKey2($this->tpl["option_arr_values"]["stripe_api_key"], $accountType, $stripeApiKey);

                    $xmlPath = __DIR__ . '/../../web.config';
                    $xml = simplexml_load_file($xmlPath);
                    $stripeApiKey = (defined('STRIPE_PUJA_SECRET_KEY') && STRIPE_PUJA_SECRET_KEY !== '') ? STRIPE_PUJA_SECRET_KEY : (string) $xml->appSettings->add[1]->attributes()->value;
                    Stripe::setApiKey2($this->tpl["option_arr_values"]["stripe_api_key"], $accountType, $stripeApiKey);

                    try {
                        if (!isset($_POST['stripeToken'])) {
                            throw new Exception("The Stripe Token was not generated correctly");
                        }
                        $oid = $_POST['oid'] ?? '';
                        $amount = round($amount * 100);

                        $payment = Stripe_Charge::create(array(
                            "amount" => $amount,
                            "currency" => "USD",
                            //"currency" => "INR",
                            "card" => $_POST['stripeToken'],
                            // "description" => $id.', '.$_POST['MemberName'],
                            "description" =>  "Pay For:" . $_POST['pay_for'] . ', ' . "Email:" . $_POST['email'] . ', ' . "Full Name:" . ($_POST['MemberName'] ?? ''),
                            "metadata" => ["orderid" => $oid]
                        ));

                        $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                        $this->tpl['payment']['amount'] = $payment->amount;
                        $this->tpl['payment']['status'] = $payment->status;
                        $this->tpl['payment']['currency'] = $payment->currency;

                        if ($payment->status == 'succeeded') {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            $opts['payment_status'] = 'succeeded';
                            $opts['payment_timestamp'] = time();
                            //thankyou screen UI
                            $data = $_POST;
                            $MemberName = $_POST['MemberName'] ?? '';
                            $Amount = $_POST['totaldonation'] ?? '';
                            $transaction_id = $opts['transaction_id'];
                            $payment_status = $opts['payment_status'];
                            $memberid = $_POST['Member_id'] ?? '';
                            $datefor = $_POST['pay_date'] ?? '';
                            $eventname = $_POST['type'] ?? '';
                            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                            $description = $_POST['description'] ?? '';

                            echo "<div style='margin-left:23em;' class = 'pay'>
                           <table border='4'  width='585px' style='margin-left:4em;'>
                            <tr>
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                          
                             <tr><td style='width:50%;'>Order Id</td><td style='width:50%;'>" . $oid . "</td></tr>
                             <tr>
                            <td>Member Id</td> <td>" . $memberid . "</td></tr>
                            <tr>
                           <td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                           <tr><td>Event Name</td> <td>" . $eventname . "</td> </tr>
                           <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount .  "</td> </tr>
                           <tr><td>Payment Method</td> <td>Credit Card</td>  </tr>
                           <tr><td>Transaction Id</td> <td>" . $transaction_id .   "</td> </tr>
                           <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                           <tr><td>Additional Comments </td> <td>" . $description .   "</td> </tr>
                           <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                           </tr>";

                            echo "</table>";
                            echo "</div>";
                            echo "<a  href='" . INSTALL_URL . "Event/event'>Go to home</a>";
                            $this->sendEmailEvent($data);
                            $datamemberarr = array();
                            $datamemberarr =  array_merge($opts, $_POST);
                            $EventModel->update(array_merge($opts, $_POST));

                            $value = array();
                            $value['oid'] = $datamemberarr['oid'];
                            $value['eventid'] = $datamemberarr['eventid'];
                            $value['type'] = $datamemberarr['type'];
                            $value['Member_id'] = $datamemberarr['Member_id'];
                            $value['MemberName'] = $datamemberarr['MemberName'];
                            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                            $value['payment_status'] = 'succeeded';
                            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                            $value['transaction_id'] = $datamemberarr['transaction_id'];
                            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                            $value['update_on'] = $datamemberarr['UpdateOn'] ?? ($datamemberarr['update_on'] ?? '');
                            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                            $value['pay_date'] = $datamemberarr['pay_date'];
                            $value['pay_type'] = $datamemberarr['pay_type'];
                            $value['pay_for'] = $datamemberarr['pay_for'];
                            $value['Tele1'] = $datamemberarr['Tele1'];
                            $value['email'] = $datamemberarr['email'];
                            $extradonationamount = $datamemberarr['eventdonation'];

                            if ($extradonationamount == null) {
                                $value['Amount'] = $datamemberarr['Amount'];
                                $DonationModel->SaveDataInDonation($value);
                            }
                            //   if($extradonationamount != null){
                            //             for($i=0;$i<=1;$i++){
                            //                 if($i==0){
                            //                     $value['pay_type'] = $datamemberarr['pay_type'];
                            //                     $value['pay_for'] = $datamemberarr['pay_for'];
                            //                     $value['Amount'] = $datamemberarr['Amount'];
                            //                     $DonationModel->SaveDataInDonation($value);
                            //                 }
                            //                 if($i==1){
                            //                     //$value['pay_type'] = 'OTHER';
                            //               //$value['pay_for'] = $datamemberarr['pay_for'];
                            //                 $value['pay_type'] = 'DONATION';
                            //                 $value['pay_for'] = 'DONATION / Unrestricted';
                            //                     $value['Amount'] = $extradonationamount;
                            //                     $DonationModel->SaveDataInDonation($value);
                            //                 }

                            //             }
                            //         }


                            // 28 july

                            if ($extradonationamount != null) {
                                for ($i = 0; $i <= 1; $i++) {


                                    if ($i == 0) {

                                        if ($extradonationamount <= $EventThresholdAmount) {
                                            $value['pay_type'] = $datamemberarr['pay_type'];
                                            $value['pay_for'] = $datamemberarr['pay_for'];
                                            $value['Amount'] = $datamemberarr['Amount'] + $extradonationamount;
                                            $DonationModel->SaveDataInDonation($value);
                                        } else {
                                            $value['pay_type'] = $datamemberarr['pay_type'];
                                            $value['pay_for'] = $datamemberarr['pay_for'];
                                            $value['Amount'] = $datamemberarr['Amount'] + $EventThresholdAmount;
                                            $DonationModel->SaveDataInDonation($value);
                                        }
                                    }

                                    if ($i == 1) {

                                        if ($extradonationamount > $EventThresholdAmount) {

                                            $value['pay_type'] = 'DONATION';
                                            $value['pay_for'] = 'DONATION / Unrestricted';
                                            $value['Amount'] = $extradonationamount - $EventThresholdAmount;
                                            $DonationModel->SaveDataInDonation($value);
                                        }


                                        //$value['pay_type'] = 'OTHER';
                                        //$value['pay_for'] = $datamemberarr['pay_for'];

                                        // $value['pay_type'] = 'DONATION';
                                        // $value['pay_for'] = 'DONATION / Unrestricted';
                                        // $value['Amount'] = $extradonationamount;
                                        // $resultvalue =  $DonationModel->SaveDataInDonation($value);
                                    }
                                }
                            }

                            if ($datamember == null) {
                                $value = array();
                                $value['type'] = $_POST['type'] ?? '';
                                $value['gift'] = $_POST['gift'] ?? '';
                                $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                $value['MemberName'] = $_POST['MemberName'] ?? '';
                                $value['Amount'] = $_POST['Amount'] ?? '';
                                $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                                $value['payment_status'] = 'confirmed';
                                $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                                $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                $value['transaction_id'] = $opts['transaction_id'];
                                $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['update_on'] = $_POST['update_on'] ?? '';
                                $value['Member_id'] = $_POST['Member_id'] ?? '';
                                $value['pay_date'] = $_POST['pay_date'] ?? '';
                                $value['cc_name'] = $_POST['cc_name'] ?? '';
                                $value['remarks'] = $_POST['remarks'] ?? '';
                                $value['oid'] = $_POST['oid'] ?? '';
                                $value['pay_type'] = $_POST['pay_type'] ?? '';
                                $value['pay_for'] = $_POST['pay_for'] ?? '';
                                $value['Address'] = $_POST['Address'] ?? '';
                                $value['Street'] = $_POST['Street'] ?? '';
                                $value['State'] = $_POST['State'] ?? '';
                                $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                                $value['Phone_Number'] = $_POST['Phone_Number'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['City'] = $_POST['City'] ?? '';
                                $value['Tele1'] = $_POST['Tele1'] ?? '';
                                $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                                $value['totaldonation'] = $_POST['totaldonation'] ?? '';
                                $value['Address3'] = $_POST['Address3'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                            $mobileno = $data['Tele1'];
                            if ($data['Tele1'] != null) {
                                $msg = 'Houston Durga Bari: Event confirmation are Member Id: ' . $data['Member_id'] . ',  Order Id: ' . $data['oid'] . ', Member Name: ' . $data['MemberName'] . ' , Event Name: ' . $data['type'] . ' , Amount: $' . $data['totaldonation'] . ', Pay Date: ' . $payfinaldate . ',  Status: ' . $opts['payment_status'];
                                try {
                                    $this->SendSMS($mobileno, $msg);
                                } catch (Exception $smsEx) {
                                    $this->logPaymentError("SMS error OrderID: $oid | " . $smsEx->getMessage());
                                }
                            }

                            $this->tpl['arr'] = $EventModel->get($id);
                            $_SESSION['PaymentProcessed'] = true;
                            exit();
                        } else {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            $EventModel->update($opts);

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    } catch (Exception $ex) {
                        $_SESSION['status'] = $ex->getMessage();
                    }

                    $this->tpl['arr'] = $EventModel->get($id) ?: [];
                    $this->tpl['arr']['amount'] = $total;
                } else {
                    $_SESSION['status'] = 16;
                }
            } else {
                $_SESSION['status'] = 17;
            }
        }
    }


    function event3()
    {
        $this->layout = 'login';

        GzObject::loadFiles('Model', array('Event', 'ConfirmCode', 'Member', 'Eventname', 'Donation', 'idnumbers', 'vendorpaymentaccount', 'ThresholdAmount'));
        $EventModel = new EventModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $DonationModel = new DonationModel();
        $EventnameModel = new EventnameModel();
        $idnumbersModel = new idnumbersModel();

        $arr = $EventnameModel->getevents3();

        $vendorpaymentaccountModel = new vendorpaymentaccountModel();
        $ThresholdAmount = new ThresholdAmountModel();
        $EventThresholdAmount = $ThresholdAmount->getThresholdAmount();
        $EventThresholdAmount = $EventThresholdAmount[0]['amount'] ?? null;

        $this->tpl['Eventname'] = $arr;
        $this->tpl['members'] = $MemberModel->getAll();

        $result = $vendorpaymentaccountModel->getEventPaymentAccountName("event3");
        $accountType = $result[0]['paymentaccount'] ?? null;
        $this->tpl['account_type'] =  $accountType;

        $xmlPath = __DIR__ . '/../../web.config';
        $xml = simplexml_load_file($xmlPath);
        $stripePublishedKey = (defined('STRIPE_PUBLISHABLE_KEY') && STRIPE_PUBLISHABLE_KEY !== '') ? STRIPE_PUBLISHABLE_KEY : (string) $xml->appSettings->add[0]->attributes()->value;
        $this->tpl['StripePublishedApiKey'] = $stripePublishedKey;


        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['PaymentProcessed']);
        }

        if (!empty($_POST['create_event'])) {

            if (isset($_SESSION['PaymentProcessed']) && $_SESSION['PaymentProcessed'] === true) {
                unset($_SESSION['PaymentProcessed']);
                Util::redirect(INSTALL_URL . "Event/event3");
                exit();
            }

            $data = array();
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['pay_date'] = $today;
            $_POST['pay_type'] = 'EVENT';
            $_POST['pay_for'] = 'EVENT' . '/' . ($_POST['type'] ?? '');

            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for

            $memberid = $_POST['demmember'] ?? '';
            $_POST['Member_id'] = $memberid;
            $registermember = $_POST['MemberName'] ?? '';
            $regmember = $_POST['regmember'] ?? '';


            $datamember = $MemberModel->checkduplicatemember();
            if ($datamember == null) {

                // for generate memberid for gd
                $maxid = $idnumbersModel->getMaxmid() + 1;
                $update_mid = $idnumbersModel->Updatemid($maxid);
                $_POST['Member_id'] = $maxid;
                // end generate memberid for gd 
            }
            if ($datamember != null) {
                $_POST['Member_id'] = $datamember;
            }

            if ($regmember == "nonmember") {
                $nonmember = $_POST['namenonmember'] ?? '';
                $_POST['MemberName'] = $nonmember;
            } else {

                $_POST['MemberName'] = $registermember;
            }
            $id = $EventModel->getMaxid() + 1;
            $data['id'] = $id;
            $_POST['id'] = $id;
            $_POST['eventid'] = $_POST['uniqueeventid'] ?? '';

            // Ensure float columns are never empty string (causes DB truncation)
            $_POST['eventdonation'] = strlen(trim($_POST['eventdonation'] ?? '')) > 0 ? floatval($_POST['eventdonation']) : 0;
            // Ensure NOT NULL columns without defaults always have a value
            $_POST['Address']      = $_POST['Address']      ?? '';
            $_POST['Street']       = $_POST['Street']       ?? '';
            $_POST['State']        = $_POST['State']        ?? '';
            $_POST['Zip_Code']     = $_POST['Zip_Code']     ?? '';
            $_POST['Phone_Number'] = $_POST['Phone_Number'] ?? '';
            $_POST['City']         = $_POST['City']         ?? '';
            $_POST['cc_name']      = $_POST['cc_name']      ?? '';
            $_POST['remarks']      = $_POST['remarks']      ?? '';
            $_POST['description']  = $_POST['description']  ?? '';

            $EventModel->save(array_merge($_POST, $data));
            if (!empty($id)) {

                if (($_POST['PaymentOption'] ?? '') == 'others') {

                    $opts = array();
                    $cmCode = $_POST['code'] ?? '';
                    $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                    $_POST['transaction_id'] = $cmCode;
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                    $arr = $ConfirmCodeModel->getAll($opts);
                    $oid = $_POST['oid'] ?? '';
                    //if (!empty($arr[0])) {
                    if ($oid != null) {
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['payment_status'] = 'succeeded';
                        $data = $_POST;
                        $MemberName = $_POST['MemberName'] ?? '';
                        $Amount = $_POST['totaldonation'] ?? '';
                        $payment_status = $opts['payment_status'];
                        $memberid = $_POST['Member_id'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                        $eventname = $_POST['type'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $description = $_POST['description'] ?? '';

                        echo "<div style='margin-left:23em;' class = 'pay'>
                            <table border='4'  width='585px' style='margin-left:4em;'>
                            <tr>
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                           <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                            <tr> <td>Member Id</td> <td>" . $memberid . "</td></tr>
                            <tr><td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                            <tr><td>Event Name</td> <td>" . $eventname . "</td> </tr>
                           <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount . "</td> </tr>
                            <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                            <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                            <tr><td>Additional Comments </td> <td>" . $description . "</td> </tr>
                           <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                           </tr>";
                        echo "</table>";
                        echo "</div>";
                        echo "<a  href='" . INSTALL_URL . "Event/event3'>Go to home</a>";

                        $this->sendEmailEvent($data);
                        $datamemberarr = array();
                        $datamemberarr = array_merge($opts, $_POST);
                        $EventModel->update(array_merge($opts, $_POST));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['eventid'] = $datamemberarr['eventid'];
                        $value['type'] = $datamemberarr['type'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['MemberName'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['update_on'] ?? ($datamemberarr['UpdateOn'] ?? '');
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['Tele1'];
                        $value['email'] = $datamemberarr['email'];
                        $extradonationamount = $datamemberarr['eventdonation'];

                        if ($extradonationamount == null) {
                            $value['Amount'] = $datamemberarr['Amount'];
                            $DonationModel->SaveDataInDonation($value);
                        }
                        if ($extradonationamount != null) {
                            for ($i = 0; $i <= 1; $i++) {
                                if ($i == 0) {
                                    if ($extradonationamount <= $EventThresholdAmount) {
                                        $value['pay_type'] = $datamemberarr['pay_type'];
                                        $value['pay_for'] = $datamemberarr['pay_for'];
                                        $value['Amount'] = $datamemberarr['Amount'] + $extradonationamount;
                                        $DonationModel->SaveDataInDonation($value);
                                    } else {
                                        $value['pay_type'] = $datamemberarr['pay_type'];
                                        $value['pay_for'] = $datamemberarr['pay_for'];
                                        $value['Amount'] = $datamemberarr['Amount'] + $EventThresholdAmount;
                                        $DonationModel->SaveDataInDonation($value);
                                    }
                                }
                                if ($i == 1) {
                                    if ($extradonationamount > $EventThresholdAmount) {
                                        $value['pay_type'] = 'DONATION';
                                        $value['pay_for'] = 'DONATION / Unrestricted';
                                        $value['Amount'] = $extradonationamount - $EventThresholdAmount;
                                        $DonationModel->SaveDataInDonation($value);
                                    }
                                }
                            }
                        }

                        if ($datamember == null) {
                            $value = array();
                            $value['type'] = $_POST['type'] ?? '';
                            $value['MemberName'] = $_POST['MemberName'] ?? '';
                            $value['Amount'] = $_POST['Amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                            $value['update_on'] = $_POST['update_on'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['pay_date'] = $_POST['pay_date'] ?? '';
                            $value['cc_name'] = $_POST['cc_name'] ?? '';
                            $value['remarks'] = $_POST['remarks'] ?? '';
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['pay_type'] = $_POST['pay_type'] ?? '';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['Address'] = $_POST['Address'] ?? '';
                            $value['Street'] = $_POST['Street'] ?? '';
                            $value['State'] = $_POST['State'] ?? '';
                            $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                            $value['Phone_Number'] = $_POST['Phone_Number'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['City'] ?? '';
                            $value['Tele1'] = $_POST['Tele1'] ?? '';
                            $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                            $value['totaldonation'] = $_POST['totaldonation'] ?? '';
                            $value['Address3'] = $_POST['Address3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $mobileno = $data['Tele1'];
                        if ($data['Tele1'] != null) {
                            $msg = 'Houston Durga Bari: Event confirmation are Member Id: ' . $data['Member_id'] . ',  Order Id: ' . $data['oid'] . ', Member Name: ' . $data['MemberName'] . ' , Event Name: ' . $data['type'] . ' , Amount: $' . $data['totaldonation'] . ', Pay Date: ' . $payfinaldate . ',  Status: ' . $opts['payment_status'];
                            try { $this->SendSMS($mobileno, $msg); } catch (Exception $smsEx) { $this->logPaymentError("SMS error OrderID: " . ($data['oid'] ?? '') . " | " . $smsEx->getMessage()); }
                        }
                        $_SESSION['PaymentProcessed'] = true;
                        exit();
                    }
                } elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                    //$amount = $_POST['Amount'];
                    $amount = $_POST['totaldonation'] ?? '';


                    $total = $amount;

                    require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                    $error = '';
                    $success = '';

                    // latest payment code
                    $xmlPath = __DIR__ . '/../../web.config';
                    $xml = simplexml_load_file($xmlPath);
                    $stripeApiKey = (defined('STRIPE_PUJA_SECRET_KEY') && STRIPE_PUJA_SECRET_KEY !== '') ? STRIPE_PUJA_SECRET_KEY : (string) $xml->appSettings->add[1]->attributes()->value;
                    Stripe::setApiKey2($this->tpl["option_arr_values"]["stripe_api_key"], $accountType, $stripeApiKey);

                    // old code
                    // Stripe::setApiKey1($this->tpl["option_arr_values"]["stripe_api_key"]);

                    // code based on current payment account
                    // Stripe::setApiKey1($this->tpl[$CurrentStripeKey]);

                    try {
                        if (!isset($_POST['stripeToken'])) {
                            throw new Exception("The Stripe Token was not generated correctly");
                        }
                        $oid = $_POST['oid'] ?? '';
                        $amount = round($amount * 100);

                        $payment = Stripe_Charge::create(array(
                            "amount" => $amount,
                            "currency" => "USD",
                            //"currency" => "INR",
                            "card" => $_POST['stripeToken'],
                            // "description" => $id.', '.$_POST['MemberName'],
                            "description" => "Pay For:" . ($_POST['pay_for'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['MemberName'] ?? ''),
                            "metadata" => ["orderid" => $oid]
                        ));

                        $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                        $this->tpl['payment']['amount'] = $payment->amount;
                        $this->tpl['payment']['status'] = $payment->status;
                        $this->tpl['payment']['currency'] = $payment->currency;

                        if ($payment->status == 'succeeded') {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            $opts['payment_status'] = 'succeeded';
                            $opts['payment_timestamp'] = time();
                            //thankyou screen UI
                            $data = $_POST;
                            $MemberName = $_POST['MemberName'] ?? '';
                            $Amount = $_POST['totaldonation'] ?? '';
                            $transaction_id = $opts['transaction_id'];
                            $payment_status = $opts['payment_status'];
                            $memberid = $_POST['Member_id'] ?? '';
                            $datefor = $_POST['pay_date'] ?? '';
                            $eventname = $_POST['type'] ?? '';
                            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                            $description = $_POST['description'] ?? '';

                            echo "<div style='margin-left:23em;' class = 'pay'>
                           <table border='4'  width='585px' style='margin-left:4em;'>
                            <tr>
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                          
                             <tr><td style='width:50%;'>Order Id</td><td style='width:50%;'>" . $oid . "</td></tr>
                             <tr>
                            <td>Member Id</td> <td>" . $memberid . "</td></tr>
                            <tr>
                           <td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                           <tr><td>Event Name</td> <td>" . $eventname . "</td> </tr>
                           <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount . "</td> </tr>
                           <tr><td>Payment Method</td> <td>Credit Card</td>  </tr>
                           <tr><td>Transaction Id</td> <td>" . $transaction_id . "</td> </tr>
                           <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                           <tr><td>Additional Comments </td> <td>" . $description . "</td> </tr>
                           <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                           </tr>";

                            echo "</table>";
                            echo "</div>";
                            echo "<a  href='" . INSTALL_URL . "Event/event3'>Go to home</a>";
                            $this->sendEmailEvent($data);
                            $datamemberarr = array();
                            $datamemberarr = array_merge($opts, $_POST);
                            $EventModel->update(array_merge($opts, $_POST));

                            $value = array();
                            $value['oid'] = $datamemberarr['oid'];
                            $value['eventid'] = $datamemberarr['eventid'];
                            $value['type'] = $datamemberarr['type'];
                            $value['Member_id'] = $datamemberarr['Member_id'];
                            $value['MemberName'] = $datamemberarr['MemberName'];
                            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                            $value['payment_status'] = 'succeeded';
                            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                            $value['transaction_id'] = $datamemberarr['transaction_id'];
                            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                            $value['update_on'] = $datamemberarr['UpdateOn'] ?? ($datamemberarr['update_on'] ?? '');
                            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                            $value['pay_date'] = $datamemberarr['pay_date'];
                            $value['pay_type'] = $datamemberarr['pay_type'];
                            $value['pay_for'] = $datamemberarr['pay_for'];
                            $value['Tele1'] = $datamemberarr['Tele1'];
                            $value['email'] = $datamemberarr['email'];
                            $extradonationamount = $datamemberarr['eventdonation'];

                            if ($extradonationamount == null) {
                                $value['Amount'] = $datamemberarr['Amount'];
                                $DonationModel->SaveDataInDonation($value);
                            }
                            if ($extradonationamount != null) {
                                for ($i = 0; $i <= 1; $i++) {
                                    if ($i == 0) {
                                        // $value['pay_type'] = $datamemberarr['pay_type'];
                                        // $value['pay_for'] = $datamemberarr['pay_for'];
                                        // $value['Amount'] = $datamemberarr['Amount'];
                                        // $DonationModel->SaveDataInDonation($value);



                                        if ($extradonationamount <= $EventThresholdAmount) {

                                            $value['pay_type'] = $datamemberarr['pay_type'];
                                            $value['pay_for'] = $datamemberarr['pay_for'];
                                            $value['Amount'] = $datamemberarr['Amount'] + $extradonationamount;
                                            $DonationModel->SaveDataInDonation($value);
                                        } else {
                                            $value['pay_type'] = $datamemberarr['pay_type'];
                                            $value['pay_for'] = $datamemberarr['pay_for'];
                                            $value['Amount'] = $datamemberarr['Amount'] + $EventThresholdAmount;
                                            $DonationModel->SaveDataInDonation($value);
                                        }
                                    }
                                    if ($i == 1) {
                                        //$value['pay_type'] = 'OTHER';
                                        //$value['pay_for'] = $datamemberarr['pay_for'];


                                        // $value['pay_type'] = 'DONATION';
                                        // $value['pay_for'] = 'DONATION / Unrestricted';
                                        // $value['Amount'] = $extradonationamount;
                                        // $DonationModel->SaveDataInDonation($value);

                                        if ($extradonationamount > $EventThresholdAmount) {

                                            $value['pay_type'] = 'DONATION';
                                            $value['pay_for'] = 'DONATION / Unrestricted';
                                            $value['Amount'] = $extradonationamount - $EventThresholdAmount;
                                            $DonationModel->SaveDataInDonation($value);
                                        }
                                    }
                                }
                            }


                            if ($datamember == null) {
                                $value = array();
                                $value['type'] = $_POST['type'] ?? '';
                                $value['gift'] = $_POST['gift'] ?? '';
                                $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                                $value['MemberName'] = $_POST['MemberName'] ?? '';
                                $value['Amount'] = $_POST['Amount'] ?? '';
                                $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                                $value['payment_status'] = 'confirmed';
                                $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                                $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                $value['transaction_id'] = $opts['transaction_id'];
                                $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['update_on'] = $_POST['update_on'] ?? '';
                                $value['Member_id'] = $_POST['Member_id'] ?? '';
                                $value['pay_date'] = $_POST['pay_date'] ?? '';
                                $value['cc_name'] = $_POST['cc_name'] ?? '';
                                $value['remarks'] = $_POST['remarks'] ?? '';
                                $value['oid'] = $_POST['oid'] ?? '';
                                $value['pay_type'] = $_POST['pay_type'] ?? '';
                                $value['pay_for'] = $_POST['pay_for'] ?? '';
                                $value['Address'] = $_POST['Address'] ?? '';
                                $value['Street'] = $_POST['Street'] ?? '';
                                $value['State'] = $_POST['State'] ?? '';
                                $value['Zip_Code'] = $_POST['Zip_Code'] ?? '';
                                $value['Phone_Number'] = $_POST['Phone_Number'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['City'] = $_POST['City'] ?? '';
                                $value['Tele1'] = $_POST['Tele1'] ?? '';
                                $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                                $value['totaldonation'] = $_POST['totaldonation'] ?? '';
                                $value['Address3'] = $_POST['Address3'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                            $mobileno = $data['Tele1'];
                            if ($data['Tele1'] != null) {
                                $msg = 'Houston Durga Bari: Event confirmation are Member Id: ' . $data['Member_id'] . ',  Order Id: ' . $data['oid'] . ', Member Name: ' . $data['MemberName'] . ' , Event Name: ' . $data['type'] . ' , Amount: $' . $data['totaldonation'] . ', Pay Date: ' . $payfinaldate . ',  Status: ' . $opts['payment_status'];
                                try { $this->SendSMS($mobileno, $msg); } catch (Exception $smsEx) { $this->logPaymentError("SMS error OrderID: " . ($data['oid'] ?? '') . " | " . $smsEx->getMessage()); }
                            }

                            $this->tpl['arr'] = $EventModel->get($id);
                            $_SESSION['PaymentProcessed'] = true;
                        } else {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            $EventModel->update($opts);

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    } catch (Exception $ex) {
                        $_SESSION['status'] = $ex->getMessage();
                    }

                    $this->tpl['arr'] = $EventModel->get($id) ?: [];
                    $this->tpl['arr']['amount'] = $total;
                } else {
                    $_SESSION['status'] = 16;
                }
            } else {
                $_SESSION['status'] = 17;
            }
            exit();
        }
    }
    //function for ticket payment

    function ticket()
    {
        $this->layout = 'login';

        GzObject::loadFiles('Model', array('ticketeventname', 'ConfirmCode', 'Member', 'Donation', 'ticket', 'idnumbers', 'ticketeventday', 'vendorpaymentaccount'));
        $ticketeventnameModel = new ticketeventnameModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $DonationModel = new DonationModel();
        $ticketModel = new ticketModel();
        $idnumbersModel = new idnumbersModel();
        $ticketeventdayModel = new ticketeventdayModel();
        $vendorpaymentaccountModel = new vendorpaymentaccountModel();

        $accountResult = $vendorpaymentaccountModel->getEventPaymentAccountName("event");
        $this->tpl['account_type'] = $accountResult[0]['paymentaccount'] ?? 'Eventaccount';

        $arr = $ticketeventnameModel->getallticket();
        $this->tpl['ticketEventname'] =  $arr;

        $arrticket = $ticketeventnameModel->checkticket();
        $eventdayid = $arrticket['id'] ?? null;
        $arrnew = $ticketeventdayModel->neweventdayprice($eventdayid);
        $this->tpl['ticketeventprice'] =  $arrnew;


        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['TicketPaymentProcessed']);
        }

        if (!empty($_POST['create_ticket'])) {
            if (isset($_SESSION['TicketPaymentProcessed']) && $_SESSION['TicketPaymentProcessed'] === true) {
                unset($_SESSION['TicketPaymentProcessed']);
                Util::redirect(INSTALL_URL . "Event/ticket");
                exit();
            }

            $data = array();
            date_default_timezone_set("America/Chicago");
            $today = date("Y-m-d");
            $_POST['pay_date'] = $today;
            $_POST['pay_for'] = 'TICKET' . '/' . ($_POST['type'] ?? '');

            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for 
            $registermember = $_POST['MemberName'] ?? '';
            $regmember = $_POST['regmember'] ?? '';

            $datamember =  $MemberModel->ticketduplicatemember();
            if ($datamember == null) {

                // for generate memberid for gd
                $maxid = $idnumbersModel->getMaxmid() + 1;
                $update_mid = $idnumbersModel->Updatemid($maxid);
                $_POST['Member_id'] = $maxid;
                // end generate memberid for gd 
            }
            if ($datamember != null) {
                $_POST['Member_id'] = $datamember;
            }
            if ($regmember == "nonmember") {
                $nonmember = $_POST['namenonmember'] ?? '';
                $_POST['name'] = $nonmember;
            } else {

                $_POST['name'] = $registermember;
            }
            $eventday =   $_POST['Daysticket'] ?? '';
            $_POST['itemeventday'] = $eventday;
            $_POST['eventid'] = (int)($_POST['ticketuniqueeventid'] ?? 0) ?: null;
            $_POST['amount'] = strlen(trim($_POST['amount'] ?? '')) > 0 ? floatval($_POST['amount']) : 0;
            $_POST['Member_id'] = $_POST['Member_id'] ?? 0;

            $_POST['bank']              = $_POST['bank']              ?? '';
            $_POST['chkno']             = $_POST['chkno']             ?? '';
            $_POST['ReceiveBy']         = $_POST['ReceiveBy']         ?? '';
            $_POST['cc_name']           = $_POST['cc_name']           ?? '';
            $_POST['street']            = $_POST['street']            ?? '';
            $_POST['address']           = $_POST['address']           ?? '';
            $_POST['city']              = $_POST['city']              ?? '';
            $_POST['state']             = $_POST['state']             ?? '';
            $_POST['zip']               = $_POST['zip']               ?? '';
            $_POST['item_name']         = $_POST['item_name']         ?? ($_POST['type'] ?? '');
            $_POST['txn_id']            = $_POST['txn_id']            ?? '';
            $_POST['payment_status']    = $_POST['payment_status']    ?? '';
            $_POST['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
            $_POST['stripe_return']     = $_POST['stripe_return']     ?? '';
            $_POST['paid_amount']       = $_POST['paid_amount']       ?? '';
            $_POST['stripe_product']    = $_POST['stripe_product']    ?? '';
            $_POST['status']            = $_POST['status']            ?? '';

            $id = $ticketModel->getticketMaxid() + 1;
            $data['id'] = $id;
            $_POST['id'] = $id;

            $saveData = array_merge($_POST, $data);
            $this->logPaymentError("TICKET SAVE DATA | " . json_encode($saveData));
            $saveResult = $ticketModel->save($saveData);
            $this->logPaymentError("TICKET SAVE RESULT | id=$id | result=" . ($saveResult ? 'SUCCESS' : 'FAILED/FALSE'));

            if (!empty($id)) {

                if (($_POST['PaymentOption'] ?? '') == 'others') {

                    $opts = array();
                    $cmCode = $_POST['code'] ?? '';
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                    $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                    $_POST['txn_id'] =  $cmCode;
                    $arr = $ConfirmCodeModel->getAll($opts);
                    $oid = $_POST['oid'] ?? '';
                    if ($oid != null) {
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['payment_status'] = 'confirmed';
                        $data = $_POST;
                        $memberid = $_POST['Member_id'] ?? '';
                        $MemberName = $_POST['name'] ?? '';
                        $totalamount = $_POST['amount'] ?? '';
                        $payment_status = $opts['payment_status'];
                        $datefor = $_POST['pay_date'] ?? '';
                        $eventday = $_POST['itemeventday'] ?? '';
                        $Quantity = $_POST['item_number'] ?? '';
                        $ticketprice = $_POST['item_cost'] ?? '';
                        $eventname = $_POST['type'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                        echo "<div style='margin-left:23em;' class = 'pay'>
                      <table border='4'  width='585px' style='margin-left:4em;'>
                      <tr>
                      <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                      <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                      <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                      <tr><td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                       <tr><td>Event Name</td> <td>" . $eventname . "</td> </tr>
                      <tr><td>Event Day</td> <td>" . $eventday . "</td> </tr>
                      <tr><td>Quantity</td> <td>" . $Quantity . "</td> </tr>
                      <tr><td>Ticket Amount</td> <td><span style= 'color:red;'>$</span>" . $ticketprice .  "</td> </tr>
                      <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span>" . $totalamount .  "</td> </tr>
                      <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                      <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                      <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";
                        echo "</table>";
                        echo "</div>";
                        echo "<a  href='" . INSTALL_URL . "Event/ticket'>Go to home</a>";

                        $this->sendEmailTicketEvent($data);
                        $datamemberarr = array();
                        $datamemberarr =  array_merge($_POST, $opts);
                        $ticketModel->update(array_merge($_POST, $opts));
                        $value = array();
                        $value['oid'] = $datamemberarr['oid'];
                        $value['eventid'] = $datamemberarr['eventid'];
                        $value['type'] = $datamemberarr['type'];
                        $value['Member_id'] = $datamemberarr['Member_id'];
                        $value['MemberName'] = $datamemberarr['name'];
                        $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['Amount'] = $datamemberarr['amount'];
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['txn_id'];
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['update_on'] ?? ($datamemberarr['UpdateOn'] ?? '');
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = 'TICKET';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['tele'];
                        $value['email'] = $datamemberarr['email'];
                        $extradonationamount = floatval($datamemberarr['extradonation'] ?? 0);
                        $tickettotalamount = floatval($datamemberarr['amount'] ?? 0) - $extradonationamount;
                        if ($extradonationamount == null) {
                            $value['Amount'] = $datamemberarr['amount'];
                            $DonationModel->SaveDataInDonation($value);
                        }
                        if ($extradonationamount != null) {
                            for ($i = 0; $i <= 1; $i++) {
                                if ($i == 0) {
                                    $value['pay_type'] = 'TICKET';
                                    $value['pay_for'] = $datamemberarr['pay_for'];
                                    $value['Amount'] = $tickettotalamount;
                                    $DonationModel->SaveDataInDonation($value);
                                }
                                if ($i == 1) {
                                    $value['pay_type'] = 'DONATION';
                                    $value['pay_for'] = 'DONATION / Unrestricted';
                                    $value['Amount'] = $extradonationamount;
                                    $DonationModel->SaveDataInDonation($value);
                                }
                            }
                        }
                        if ($datamember == null) {
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['MemberName'] = $_POST['name'] ?? '';
                            $value['Address'] = $_POST['address'] ?? '';
                            $value['Tele1'] = $_POST['tele'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['Item_Name'] = $_POST['item_name'] ?? '';
                            $value['Item_Number'] = $_POST['item_number'] ?? '';
                            $value['Item_Cost'] = $_POST['item_cost'] ?? '';
                            $value['Amount'] = $_POST['amount'] ?? '';
                            $value['pay_type'] = 'TICKET';
                            $value['pay_for'] = $_POST['pay_for'] ?? '';
                            $value['pay_date'] = $_POST['pay_date'] ?? '';
                            $value['transaction_id'] = $_POST['txn_id'] ?? '';
                            $value['remarks'] = $_POST['remarks'] ?? '';
                            $value['created_on'] = $_POST['created_on'] ?? '';
                            $value['update_on'] = $_POST['update_on'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['payment_status'] = 'confirmed';
                            $value['cc_name'] = $_POST['cc_name'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['type'] = $_POST['type'] ?? '';
                            $value['street'] = $_POST['street'] ?? '';
                            $value['itemeventday'] = $_POST['itemeventday'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $mobileno = $data['tele'];
                        if ($data['tele'] != null) {
                            $msg = 'Houston Durga Bari: Ticket Confirmation are Member Id: ' . $data['Member_id'] . ', Order Id: ' . $data['oid'] . ', Member Name: ' . $data['MemberName'] . ', Event Name: ' . $data['type'] . ', Event Day: ' . $data['itemeventday'] . ', Quantity: ' . $data['item_number'] . ' , Ticket Amount: $' . $data['item_cost'] . ' , Total Amount: $' . $data['amount'] . ', Pay Date: ' . $payfinaldate . ',   Status: ' . $opts['payment_status'];
                            try { $this->SendSMS($mobileno, $msg); } catch (Exception $smsEx) { $this->logPaymentError("SMS error OrderID: " . ($data['oid'] ?? '') . " | " . $smsEx->getMessage()); }
                        }
                        $_SESSION['TicketPaymentProcessed'] = true;
                        exit();
                    }
                } elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                    //$amount = $_POST['Amount'];
                    $amount = $_POST['amount'] ?? '';


                    $total = $amount;

                    require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                    $error = '';
                    $success = '';

                    Stripe::setApiKey1($this->tpl["option_arr_values"]["stripe_api_key"]);

                    try {
                        if (!isset($_POST['stripeToken'])) {
                            throw new Exception("The Stripe Token was not generated correctly");
                        }

                        $oid = $_POST['oid'] ?? '';
                        $amount = round($amount * 100);

                        $payment = Stripe_Charge::create(array(
                            "amount" => $amount,
                            "currency" => "USD",
                            //"currency" => "INR",
                            "card" => $_POST['stripeToken'],
                            //"description" => $id.', '.$_POST['name'],
                            "description" =>  "Pay For:" . $_POST['pay_for'] . ', ' . "Email:" . $_POST['email'] . ', ' . "Full Name:" . ($_POST['name'] ?? ''),
                            "metadata" => ["orderid" => $oid]
                        ));

                        $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                        $this->tpl['payment']['amount'] = $payment->amount;
                        $this->tpl['payment']['status'] = $payment->status;
                        $this->tpl['payment']['currency'] = $payment->currency;

                        if ($payment->status == 'succeeded') {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['txn_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            $opts['payment_status'] = 'confirmed';
                            $opts['payment_timestamp'] = time();
                            //thankyou screen UI
                            $data = $_POST;
                            $MemberName = $_POST['name'] ?? '';
                            $totalamount = $_POST['amount'] ?? '';
                            $transaction_id = $opts['txn_id'];
                            $payment_status = $opts['payment_status'];
                            $memberid = $_POST['Member_id'] ?? '';
                            $datefor = $_POST['pay_date'] ?? '';
                            $eventday = $_POST['itemeventday'] ?? '';
                            $Quantity = $_POST['item_number'] ?? '';
                            $ticketprice = $_POST['item_cost'] ?? '';
                            $eventname = $_POST['type'] ?? '';
                            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                            echo "<div style='margin-left:23em;' class = 'pay'>
                      <table border='4'  width='585px' style='margin-left:4em;'>
                      <tr>
                      <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                    
                       <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                      <tr><td>Member Id</td> <td>" . $memberid . "</td></tr>
                      <tr><td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                       <tr><td>Event Name</td> <td>" . $eventname . "</td> </tr>
                      <tr><td>Event Day</td> <td>" . $eventday . "</td> </tr>
                      <tr><td>Quantity</td> <td>" . $Quantity . "</td> </tr>
                      <tr><td>Ticket Amount</td> <td><span style= 'color:red;'>$</span>" . $ticketprice .  "</td> </tr>
                      <tr><td>Total Amount</td> <td><span style= 'color:red;'>$</span>" . $totalamount .  "</td> </tr>
                      <tr><td>Payment Method</td> <td>Credit Card</td>  </tr>
                      <tr><td>Transaction Id</td> <td>" . $transaction_id .   "</td> </tr>
                     <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                     <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                     <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                     </tr>";

                            echo "</table>";
                            echo "</div>";
                            echo "<a  href='" . INSTALL_URL . "Event/ticket'>Go to home</a>";
                            $this->sendEmailTicketEvent($data);
                            $datamemberarr = array();
                            $datamemberarr =  array_merge($opts, $_POST);
                            $this->logPaymentError("TICKET UPDATE DATA | id=" . ($opts['id'] ?? '') . " | txn_id=" . ($opts['txn_id'] ?? '') . " | payment_status=" . ($opts['payment_status'] ?? '') . " | paid_amount=" . ($opts['paid_amount'] ?? '') . " | stripe_return=" . ($opts['stripe_return'] ?? ''));
                            $updateResult = $ticketModel->update($opts);
                            $this->logPaymentError("TICKET UPDATE RESULT | id=" . ($opts['id'] ?? '') . " | result=" . ($updateResult ? 'SUCCESS' : 'FAILED/FALSE'));
                            $value = array();
                            $value['oid'] = $datamemberarr['oid'];
                            $value['eventid'] = $datamemberarr['eventid'];
                            $value['type'] = $datamemberarr['type'];
                            $value['Member_id'] = $datamemberarr['Member_id'];
                            $value['MemberName'] = $datamemberarr['name'];
                            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
                            $value['payment_status'] = 'succeeded';
                            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                            $value['Amount'] = $datamemberarr['amount'];
                            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                            $value['transaction_id'] = $datamemberarr['txn_id'];
                            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                            $value['update_on'] = $datamemberarr['update_on'] ?? ($datamemberarr['UpdateOn'] ?? '');
                            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                            $value['pay_date'] = $datamemberarr['pay_date'];
                            $value['pay_type'] = 'TICKET';
                            $value['pay_for'] = $datamemberarr['pay_for'];
                            $value['Tele1'] = $datamemberarr['tele'];
                            $value['email'] = $datamemberarr['email'];
                            $extradonationamount = floatval($datamemberarr['extradonation'] ?? 0);
                            $tickettotalamount = floatval($datamemberarr['amount'] ?? 0) - $extradonationamount;
                            if ($extradonationamount == null) {
                                $value['Amount'] = $datamemberarr['amount'];
                                $DonationModel->SaveDataInDonation($value);
                            }
                            if ($extradonationamount != null) {
                                for ($i = 0; $i <= 1; $i++) {
                                    if ($i == 0) {
                                        $value['pay_type'] = 'TICKET';
                                        $value['pay_for'] = $datamemberarr['pay_for'];
                                        $value['Amount'] = $tickettotalamount;
                                        $DonationModel->SaveDataInDonation($value);
                                    }
                                    if ($i == 1) {
                                        $value['pay_type'] = 'DONATION';
                                        $value['pay_for'] = 'DONATION / Unrestricted';
                                        $value['Amount'] = $extradonationamount;
                                        $DonationModel->SaveDataInDonation($value);
                                    }
                                }
                            }

                            if ($datamember == null) {
                                $value = array();
                                $value['oid'] = $_POST['oid'] ?? '';
                                $value['MemberName'] = $_POST['name'] ?? '';
                                $value['Address'] = $_POST['address'] ?? '';
                                $value['Tele1'] = $_POST['tele'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['City'] = $_POST['city'] ?? '';
                                $value['State'] = $_POST['state'] ?? '';
                                $value['Zip_Code'] = $_POST['zip'] ?? '';
                                $value['Item_Name'] = $_POST['item_name'] ?? '';
                                $value['Item_Number'] = $_POST['item_number'] ?? '';
                                $value['Item_Cost'] = $_POST['item_cost'] ?? '';
                                $value['Amount'] = $_POST['amount'] ?? '';
                                $value['pay_type'] = 'TICKET';
                                $value['pay_for'] = $_POST['pay_for'] ?? '';
                                $value['pay_date'] = $_POST['pay_date'] ?? '';
                                $value['transaction_id'] = $opts['txn_id'];
                                $value['remarks'] = $_POST['remarks'] ?? '';
                                $value['created_on'] = $_POST['created_on'] ?? '';
                                $value['update_on'] = $_POST['update_on'] ?? '';
                                $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                                $value['payment_status'] = 'confirmed';
                                $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                                $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['cc_name'] = $_POST['cc_name'] ?? '';
                                $value['Member_id'] = $_POST['Member_id'] ?? '';
                                $value['type'] = $_POST['type'] ?? '';
                                $value['street'] = $_POST['street'] ?? '';
                                $value['totaldonation'] = $_POST['totaldonation'] ?? '';
                                $value['itemeventday'] = $_POST['itemeventday'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                            $mobileno = $data['tele'];
                            if ($data['tele'] != null) {
                                $msg = 'Houston Durga Bari: Ticket Confirmation are Member Id: ' . $data['Member_id'] . ', Order Id: ' . $data['oid'] . ', Member Name: ' . $data['MemberName'] . ', Event Name: ' . $data['type'] . ', Event Day: ' . $data['itemeventday'] . ', Quantity: ' . $data['item_number'] . ' , Ticket Amount: $' . $data['item_cost'] . ' , Total Amount: $' . $data['amount'] . ', Pay Date: ' . $payfinaldate . ',  Status: ' . $opts['payment_status'];
                                try { $this->SendSMS($mobileno, $msg); } catch (Exception $smsEx) { $this->logPaymentError("SMS error OrderID: " . ($data['oid'] ?? '') . " | " . $smsEx->getMessage()); }
                            }

                            $this->tpl['arr'] = $ticketModel->get($id);
                            $_SESSION['TicketPaymentProcessed'] = true;
                        } else {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            $ticketeventnameModel->update($opts);

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    } catch (Exception $ex) {
                        $_SESSION['status'] = $ex->getMessage();
                    }

                    $this->tpl['arr'] = $ticketModel->get($id) ?: [];
                    $this->tpl['arr']['amount'] = $total;
                } else {
                    $_SESSION['status'] = 16;
                }
            } else {
                $_SESSION['status'] = 17;
            }
            exit();
        }
    }
}



