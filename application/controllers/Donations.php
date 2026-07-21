<?php

require_once CONTROLLERS_PATH . 'App.php';

class Donations extends App
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

        $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format'] ?? '');
        $this->tpl['iso_format'] = Util::getISODateFormta($this->tpl['option_arr_values']['date_format'] ?? '');

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

        // $this->js[] = array('file' => 'GzDonation.js', 'path' => JS_PATH);

        $this->js[] = array(
            'file' => 'GzDonation.js?v=' . time(),
            'path' => JS_PATH
        );
        
        $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
        //$this->js[] = array('file' => 'GzMember.js', 'path' => JS_PATH);
    }

    function AllMember()
    {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('ltdytdmember'));
        $ltdytdmemberModel = new ltdytdmemberModel();
        $arr = array();
        $Memberid = $_POST['memberid'] ?? null;
        $arr = $ltdytdmemberModel->AllMember($Memberid);
        foreach ($arr as $key => $value) {
            echo "<input  id='memberid' value='$value[Member_id]'/> ";
            echo "<input  id='MemberName' value='$value[F_Name]'/> ";
            echo "<input  id='middle_name' value='$value[M_Name]'/> ";
            echo "<input  id='last_name' value='$value[L_Name]'/> ";
            echo "<input  id='membershiptype' value='$value[membership_type]'/> ";
            echo "<input  id='Spouse' value='$value[Sp_FName]'/> ";
            echo "<input  id='Spouselast' value='$value[Sp_LName]'/> ";
            echo "<input  id='ressidentalAddress' value='$value[Address1]'/> ";
            echo "<input  id='Address' value='$value[Address2]'/> ";
            echo "<input  id='Country' value='$value[Country]'/> ";
            echo "<input  id='city' value='$value[City]'/> ";
            echo "<input  id='state' value='$value[State]'/> ";
            echo "<input  id='zip_code' value='$value[Zip]'/> ";
            echo "<input  id='Tele1' value='$value[Tele1]'/> ";
            echo "<input  id='phone_No' value='$value[Mob_No]'/> ";
            echo "<input  id='phone_work' value='$value[Tele2]'/> ";
            echo "<input  id='email' value='$value[email]'/> ";
            echo "<input  id='ltd' value='$value[LTC]'/> ";
            echo "<input  id='ytd' value='$value[YTD]'/> ";
            echo "<input  id='membercategory' value='$value[Category]'/> ";
            echo "<input  id='tableid' value='$value[ID]'/> ";
            echo "<input  id='tableid' value='$value[ID]'/> ";
            echo "<input  id='updatedate' value='$value[pay_date]'/> ";
            // echo  "<input  id='updatedate' value='$value[UpdateOn]'/> ";
            echo "<input  id='payfor' value='$value[pay_for]'/> ";

        }

    }

    function AllMemberNew()
    {
        $this->isAjax = true;
        if (!$this->isLoged() && empty($_SESSION['otp_verified_member'])) {
            return;
        }
        $con = gz_mysqli_connect(DEFAULT_HOST, DEFAULT_USER, DEFAULT_PASS, DEFAULT_DB);
        // Always use the OTP-verified session member — never trust POST input here.
        $Memberid = (int)($_SESSION['otp_verified_member'] ?? 0);
        if ($Memberid <= 0 && $this->isLoged()) {
            $Memberid = (int)($_POST['memberid'] ?? ($_POST['member_id'] ?? 0));
        }
        if ($Memberid <= 0) {
            return;
        }
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $stmt = $con->prepare("SELECT * FROM memberltdytd WHERE Member_id=?");
        $stmt->bind_param('s', $Memberid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // output data of each row
            while ($value = $result->fetch_assoc()) {
                $mid = $value['Member_id'];
                $F_Name = $value['F_Name'];
                $M_Name = $value['M_Name'];
                $L_Name = $value['L_Name'];
                $membership_type = $value['membership_type'];
                $Sp_FName = $value['Sp_FName'];
                $Sp_LName = $value['Sp_LName'];
                $Address1 = $value['Address1'];
                $Address2 = $value['Address2'];
                $Country = $value['Country'];
                $City = $value['City'];
                $State = $value['State'];
                $Zip = $value['Zip'];
                $Tele1 = $value['Tele1'];
                $Mob_No = $value['Mob_No'];
                $Tele2 = $value['Tele2'];
                $email = $value['email'];
                $LTC = $value['LTC'];
                $YTD = $value['YTD'];
                $Category = $value['Category'];
                $ID = $value['ID'];

                $pay_date = $value['pay_date'];
                $pay_for = $value['pay_for'];



                echo "<input  id='memberid' value='$mid'/> ";
                echo "<input  id='MemberName' value='$F_Name'/> ";
                echo "<input  id='middle_name' value='$M_Name'/> ";
                echo "<input  id='last_name' value='$L_Name'/> ";
                echo "<input  id='membershiptype' value='$membership_type'/> ";
                echo "<input  id='Spouse' value='$Sp_FName'/> ";
                echo "<input  id='Spouselast' value='$Sp_LName'/> ";
                echo "<input  id='ressidentalAddress' value='$Address1'/> ";
                echo "<input  id='Address' value='$Address2'/> ";
                echo "<input  id='Country' value='$Country'/> ";
                echo "<input  id='city' value='$City'/> ";
                echo "<input  id='state' value='$State'/> ";
                echo "<input  id='zip_code' value='$Zip'/> ";
                echo "<input  id='Tele1' value='$Tele1'/> ";
                echo "<input  id='phone_No' value='$Mob_No'/> ";
                echo "<input  id='phone_work' value='$Tele2'/> ";
                echo "<input  id='email' value='$email'/> ";
                echo "<input  id='ltd' value='$LTC'/> ";
                echo "<input  id='ytd' value='$YTD'/> ";
                echo "<input  id='membercategory' value='$Category'/> ";
                echo "<input  id='tableid' value='$ID'/> ";

                echo "<input  id='updatedate' value='$pay_date'/> ";
                // echo  "<input  id='updatedate' value='$value[UpdateOn]'/> ";
                echo "<input  id='payfor' value='$pay_for'/> ";
            }
        } else {
            echo "0 results";
        }
        $stmt->close();

    }


    function donation()
    {
        $this->layout = 'login';

        GzObject::loadFiles('Model', array('Donation', 'ConfirmCode', 'Member', 'idnumbers'));
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();

        $this->tpl['members'] = $MemberModel->getAll();

        if (!empty($_POST['create_donation'])) {

            if (isset($_SESSION['donation_processed']) && $_SESSION['donation_processed'] === true) {
                unset($_SESSION['donation_processed']);
                Util::redirect(INSTALL_URL . "Donations/donation");
                exit();
            }

            // Rate limit: block more than 5 payment submissions per minute from the same IP
            $ip = RateLimit::clientIp();
            if (RateLimit::isBlocked('payment', $ip)) {
                Util::redirect(INSTALL_URL . "Donations/donation");
                return false;
            }
            RateLimit::record('payment', $ip);

            // OTP guard: member donations require a verified session
            if (($_POST['regmember'] ?? '') === 'member' && empty($_SESSION['otp_verified_member'])) {
                $_SESSION['status'] = 'Member verification required. Please complete OTP verification before submitting.';
                Util::redirect(INSTALL_URL . 'Donations/donation');
                return;
            }

            $data = array();
            $id = $DonationModel->getMaxid() + 1;
            $data['id'] = $id;
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['pay_date'] = $today;
            $_POST['pay_type'] = 'DONATION';
            $_POST['pay_for'] = 'DONATION / Unrestricted';
            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for

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
            $registermember = $_POST['MemberName'] ?? '';
            $regmember = $_POST['regmember'] ?? '';
            if ($regmember == "nonmember") {
                $nonmember = $_POST['namenonmember'] ?? '';
                $_POST['MemberName'] = $nonmember;
            } else {

                $_POST['MemberName'] = $registermember;
                //$memberid = $_POST['demmember'] ?? ''; 
                //$_POST['Member_id'] = $memberid;
            }

            $DonationModel->save(array_merge($_POST, $data));

            if (!empty($id)) {

                if (($_POST['PaymentOption'] ?? '') == 'others') {

                    $opts = array();
                    $oid = $_POST['oid'] ?? '';
                    $cmCode = $_POST['code'] ?? '';
                    $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                    $_POST['transaction_id'] = $cmCode;
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                    $arr = $ConfirmCodeModel->getAll($opts);
                    if ($oid != null) {
                        //if (!empty($arr[0])) {
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['payment_status'] = 'succeeded';
                        $data = $_POST;
                        $MemberName = $_POST['MemberName'] ?? '';
                        $Amount = $_POST['Amount'] ?? '';
                        $memberid = $_POST['Member_id'] ?? '';
                        $payment_status = $opts['payment_status'];
                        $paymentoption = $_POST['PaymentOption'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $Purpose = $_POST['purpose'] ?? '';

                        echo "<div style='margin-left:31em;' class = 'pay'>
                        <table border='4' width='585px'>
                        <tr>
                        <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                         </tr>
                         <tr><td style='width:50%;'>Order Id</td> <td style='width:50%;'>" . $oid . "</td> </tr>
                         <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                         <tr><td>Name</td> <td>" . $MemberName . "</td> </tr>
                         <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                         <tr><td>Donation Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                          <tr><td>Purpose</td> <td>" . $Purpose . "</td>  </tr>
                         <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                         <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                         <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                         </tr>";

                        echo "</table>";
                        echo "</div>";
                        echo "<a  href='" . INSTALL_URL . "Donations/donation'>Go to home</a>";
                        $this->sendEmailDonations($data);
                        $data = $_POST;
                        $DonationModel->update(array_merge($opts, $_POST));
                        if ($datamember == null) {
                            $value = array();
                            // $value['id'] = $_POST['id'] ?? '';
                            $value['type'] = $_POST['type'] ?? '';
                            $value['gift'] = $_POST['gift'] ?? '';
                            $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                            $value['MemberName'] = $_POST['MemberName'] ?? '';
                            $value['Amount'] = $_POST['Amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                            $value['payment_status'] = 'confirmed';
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
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['purpose'] = $_POST['purpose'] ?? '';
                            $value['Address3'] = $_POST['Address3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $mobileno = $data['Tele1'];
                        if ($data['Tele1'] != null) {
                            $msg = 'Houston Durga Bari: Donation confirmation are Member Id: ' . $data['Member_id'] . ', Member Name: ' . $data['MemberName'] . ' , Amount: $' . $data['Amount'] . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $data['oid'] . ', Status: ' . $opts['payment_status'];
                            try {
                                $this->SendSMS($mobileno, $msg);
                            } catch (\Exception $e) {
                                error_log('SMS error: ' . $e->getMessage());
                            }
                        }
                        $_SESSION['donation_processed'] = true;
                        exit();
                    }
                } elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                    $amount = $_POST['Amount'] ?? '';

                    $total = $amount;

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
                            "description" => "Pay For:" . ($_POST['pay_type'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['MemberName'] ?? ''),
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
                            //$opts['payment_status'] = 'confirmed';
                            $opts['payment_status'] = 'succeeded';
                            $opts['payment_timestamp'] = time();
                            $data = $_POST;
                            $this->sendEmailDonations($data);
                            $DonationModel->update(array_merge($opts, $_POST));

                            if ($datamember == null) {
                                $value = array();
                                // $value['id'] = $_POST['id'] ?? '';
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
                                $value['spousename'] = $_POST['spousename'] ?? '';
                                $value['purpose'] = $_POST['purpose'] ?? '';
                                $value['Address3'] = $_POST['Address3'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                            $datefor = $_POST['pay_date'] ?? '';
                            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                            $mobileno = $data['Tele1'];
                            if ($data['Tele1'] != null) {
                                $msg = 'Houston Durga Bari: Donation confirmation are Member Id: ' . $data['Member_id'] . ', Member Name: ' . $data['MemberName'] . ' , Amount: $' . $data['Amount'] . ', Pay Date: ' . $payfinaldate . ',  Order Id: ' . $data['oid'] . ', Status: ' . $opts['payment_status'];
                                try {
                                    $this->SendSMS($mobileno, $msg);
                                } catch (\Exception $e) {
                                    error_log('SMS error: ' . $e->getMessage());
                                }
                            }

                            $this->tpl['arr'] = $DonationModel->get($id);
                            $_SESSION['donation_processed'] = true;
                        } else {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            $DonationModel->update($opts);

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    } catch (Exception $ex) {
                        $_SESSION['status'] = $ex->getMessage();
                    }

                    $this->tpl['arr'] = $DonationModel->get($id);
                    if (is_array($this->tpl['arr'])) {
                        $this->tpl['arr']['amount'] = $total;
                    }
                } else {
                    $_SESSION['status'] = 16;

                }
            } else {
                $_SESSION['status'] = 17;
            }
        }
    }
    // For gift
    function GiftShop()
    {
        $this->layout = 'login';

        GzObject::loadFiles('Model', array('Donation', 'ConfirmCode', 'Member', 'idnumbers'));
        $DonationModel = new DonationModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();

        $this->tpl['members'] = $MemberModel->getAll();

        if (!empty($_POST['create_donationgiftmisc'])) {

            if (isset($_SESSION['donation_processed']) && $_SESSION['donation_processed'] === true) {
                unset($_SESSION['donation_processed']);
                Util::redirect(INSTALL_URL . "Donations/GiftShop");
                exit();
            }

            $data = array();
            $id = $DonationModel->getMaxid() + 1;
            $data['id'] = $id;
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['pay_date'] = $today;

            $gift = $_POST['paymentfor'] ?? '';
            if ($gift == "gift") {
                $_POST['pay_type'] = 'GIFT';
                $_POST['pay_for'] = '1 Gift Shop';
            } else {
                $_POST['pay_type'] = 'MISC';
                $_POST['pay_for'] = '1 Miscelaneous';
            }


            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for

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
            $registermember = $_POST['MemberName'] ?? '';
            $regmember = $_POST['regmember'] ?? '';
            if ($regmember == "nonmember") {
                $nonmember = $_POST['namenonmember'] ?? '';
                $_POST['MemberName'] = $nonmember;
            } else {

                $_POST['MemberName'] = $registermember;
                // $memberid = $_POST['demmember'] ?? '';
                // $_POST['Member_id'] = $memberid;
            }

            $DonationModel->save(array_merge($_POST, $data));

            if (!empty($id)) {

                if (($_POST['PaymentOption'] ?? '') == 'others') {

                    $opts = array();
                    $oid = $_POST['oid'] ?? '';
                    $cmCode = $_POST['code'] ?? '';
                    $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                    $_POST['transaction_id'] = $cmCode;
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                    $arr = $ConfirmCodeModel->getAll($opts);
                    if ($oid != null) {
                        //if (!empty($arr[0])) {
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['payment_status'] = 'succeeded';
                        $data = $_POST;
                        $MemberName = $_POST['MemberName'] ?? '';
                        $Amount = $_POST['Amount'] ?? '';
                        $payment_status = $opts['payment_status'];
                        $usermemberid = $_POST['Member_id'] ?? '';
                        $Purpose = $_POST['purpose'] ?? '';
                        $payfor = $_POST['pay_type'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';


                        echo "<div style='margin-left:23em;' class = 'pay'>
                    <table border='4'  width='585px' style='margin-left:4em;'>
                    <tr>
                    <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                  
                    <tr><td style='width:50%;'>Order ID</td><td style='width:50%;'>" . $oid . "</td></tr>
                    <tr><td>Member Id</td> <td>" . $usermemberid . "</td> </tr>
                    <tr><td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                    <tr><td>Payment For</td> <td>" . $payfor . "</td>  </tr>
                    <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount . "</td> </tr>
                    <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                    <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                    <tr><td>Purpose</td> <td>" . $Purpose . "</td>  </tr>
                   <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                   <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                   </tr>";
                        echo "</table>";
                        echo "</div>";
                        echo "<a  href='" . INSTALL_URL . "Donations/GiftShop'>Go to home</a>";
                        $this->sendGiftShopMisc($data);
                        $data = $_POST;
                        $DonationModel->update(array_merge($opts, $_POST));

                        if ($datamember == null) {
                            $value = array();
                            // $value['id'] = $_POST['id'] ?? '';
                            $value['type'] = $_POST['type'] ?? '';
                            $value['gift'] = $_POST['gift'] ?? '';
                            $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                            $value['MemberName'] = $_POST['MemberName'] ?? '';
                            $value['Amount'] = $_POST['Amount'] ?? '';
                            $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                            $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                            $value['payment_status'] = 'confirmed';
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
                            $value['spousename'] = $_POST['spousename'] ?? '';
                            $value['purpose'] = $_POST['purpose'] ?? '';
                            $value['Address3'] = $_POST['Address3'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $datefor = $_POST['pay_date'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $mobileno = $data['Tele1'];
                        if ($data['Tele1'] != null) {
                            $msg = 'Houston Durga Bari: Payment confirmation are Member Id: ' . $data['Member_id'] . ', Order Id: ' . $data['oid'] . ', Member Name: ' . $data['MemberName'] . ' , Pay For: ' . $payfor . ' ,Amount: $' . $data['Amount'] . ', Prupose:' . $data['purpose'] . ', Pay Date: ' . $payfinaldate . ',  Status: ' . $opts['payment_status'];
                            try {
                                $this->SendSMS($mobileno, $msg);
                            } catch (\Exception $e) {
                                error_log('SMS error: ' . $e->getMessage());
                            }
                        }
                        $_SESSION['donation_processed'] = true;
                        exit();
                    }
                } elseif (($_POST['PaymentOption'] ?? '') == 'stripe') {

                    $amount = $_POST['Amount'] ?? '';

                    $total = $amount;

                    require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                    $error = '';
                    $success = '';

                    // Stripe::setApiKey($this->tpl["option_arr_values"]["stripe_api_key"]);
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
                            "description" => "Pay For:" . ($_POST['pay_type'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['MemberName'] ?? ''),
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
                            //$opts['payment_status'] = 'confirmed';
                            $opts['payment_status'] = 'succeeded';
                            $opts['payment_timestamp'] = time();
                            $data = $_POST;
                            $this->sendGiftShopMisc($data);
                            $DonationModel->update(array_merge($opts, $_POST));
                            $MemberName = $_POST['MemberName'] ?? '';
                            $Amount = $_POST['Amount'] ?? '';
                            $transaction_id = $opts['transaction_id'];
                            $payment_status = $opts['payment_status'];
                            $usermemberid = $_POST['Member_id'] ?? '';
                            $Purpose = $_POST['purpose'] ?? '';
                            $payfor = $_POST['pay_type'] ?? '';
                            $datefor = $_POST['pay_date'] ?? '';
                            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';

                            echo "<div style='margin-left:23em;' class = 'pay'>
                        <table border='4'  width='585px' style='margin-left:4em;'>
                        <tr>
                        <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                      
                         <tr><td style='width:50%;'>Order ID</td><td style='width:50%;'>" . $oid . "</td></tr>
                         <tr><td>Member Id</td> <td>" . $usermemberid . "</td> </tr>
                        <tr><td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                        <tr><td>Payment For</td> <td>" . $payfor . "</td>  </tr>
                        <tr><td>Amount</td> <td><span style= 'color:red;'>$</span>" . $Amount . "</td> </tr>
                        <tr><td>Payment Method</td> <td>Credit Card</td>  </tr>
                        <tr><td>Transaction ID</td> <td>" . $transaction_id . "</td> </tr>
                        <tr><td>Pay Date</td> <td>" . $payfinaldate . "</td>  </tr>
                        <tr><td>Purpose</td> <td>" . $Purpose . "</td>  </tr>
                       <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                       <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                       </tr>";
                            echo "</table>";
                            echo "</div>";
                            echo "<a  href='" . INSTALL_URL . "Donations/GiftShop'>Go to home</a>";


                            if ($datamember == null) {
                                $value = array();
                                // $value['id'] = $_POST['id'] ?? '';
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
                                $value['spousename'] = $_POST['spousename'] ?? '';
                                $value['purpose'] = $_POST['purpose'] ?? '';
                                $value['Address3'] = $_POST['Address3'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }
                            $datefor = $_POST['pay_date'] ?? '';
                            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                            $mobileno = $data['Tele1'];
                            if ($data['Tele1'] != null) {
                                $msg = 'Houston Durga Bari: Payment confirmation are Member Id: ' . $data['Member_id'] . ', Order Id: ' . $data['oid'] . ', Member Name: ' . $data['MemberName'] . ' , Pay For: ' . $payfor . ' , Amount: $' . $data['Amount'] . ', Prupose:' . $data['purpose'] . ', Pay Date: ' . $payfinaldate . ',  Status: ' . $opts['payment_status'];
                                try {
                                    $this->SendSMS($mobileno, $msg);
                                } catch (\Exception $e) {
                                    error_log('SMS error: ' . $e->getMessage());
                                }
                            }

                            $this->tpl['arr'] = $DonationModel->get($id);
                            $_SESSION['donation_processed'] = true;
                        } else {

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            $DonationModel->update($opts);



                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    } catch (Exception $ex) {
                        $_SESSION['status'] = $ex->getMessage();
                    }

                    $this->tpl['arr'] = $DonationModel->get($id);
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



}
