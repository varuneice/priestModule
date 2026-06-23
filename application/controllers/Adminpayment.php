<?php
$serverDateTime = date('Y-m-d');
$currentYear = date('Y');
require_once CONTROLLERS_PATH . 'App.php';

class Adminpayment extends App
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
        $this->tpl['option_arr_values'] = array_merge(
            ['date_format' => 'Y-m-d', 'timezone' => '', 'currency' => ''],
            is_array($this->tpl['option_arr_values'] ?? null) ? $this->tpl['option_arr_values'] : []
        );

        $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format']);
        $this->tpl['iso_format'] = Util::getISODateFormta($this->tpl['option_arr_values']['date_format']);

        $tz = $this->tpl['option_arr_values']['timezone'] ?? '';
        if ($tz) {
            date_default_timezone_set($tz);
        }

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }
        $this->css[] = array('file' => 'front/style.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.min.js', 'path' => LIBS_PATH . 'jquery/ui/');
        $this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);

        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'Gzadminpayment.js', 'path' => JS_PATH);

        // $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
    }


    function Adminpayment()
    {

        GzObject::loadFiles('Model', array('Donation', 'Member', 'idnumbers', 'ticketeventname', 'ticketeventday', 'MemberLog', 'Event', 'ticket'));
        $DonationModel = new DonationModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $ticketeventnameModel = new ticketeventnameModel();
        $ticketeventdayModel = new ticketeventdayModel();
        $MemberLogModel = new MemberLogModel();
        $EventModel = new EventModel();
        $ticketModel = new ticketModel();

        $arr= $ticketeventnameModel->checkticket();
        $eventdayid = $arr['id'] ?? null;
        $arrnew = $ticketeventdayModel->neweventdayprice($eventdayid);
        $this->tpl['ticketeventprice'] = $arrnew;
        $reset = $_POST['create_donation'] ?? null;
        if (!empty($_POST['create_donation'])) {

            $data = array();
            $id = $DonationModel->getMaxid() + 1;
            $data['id'] = $id;
            //date_default_timezone_set("America/Chicago");
            //$today = date("Y/m/d"); 
            //$_POST['pay_date']= $today;
            $_POST['pay_type'] = 'DONATION';
            $_POST['pay_for'] = 'DONATION / Unrestricted';

            // for generate oid 
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
            if (($_POST['PaymentOption'] ?? '') == 'check') {

                $_POST['Amount'] = $_POST['checkAmount'] ?? '';
                $_POST['bank'] = $_POST['checkbankname'] ?? '';
                $_POST['chkdate'] = !empty($_POST['CheckDate']) ? $_POST['CheckDate'] : null;
                $_POST['chkno'] = $_POST['checkno'] ?? '';
                $_POST['pay_date'] = $_POST['CheckDate'] ?? '';
            } elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                $_POST['Amount'] = $_POST['cashAmount'] ?? '';
                $_POST['pay_date'] = $_POST['cashDate'] ?? '';
            } elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                $_POST['bank'] = $_POST['directbank'] ?? '';
                $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';

            }
            $_POST['payment_status'] = 'succeeded';
            $DonationModel->save(array_merge($_POST, $data));

            if ($datamember == null) {
                $value = array();
                $value['type'] = $_POST['type'] ?? '';
                $value['bank'] = $_POST['bank'] ?? '';
                $value['chkno'] = $_POST['chkno'] ?? '';
                $value['chkdate'] = !empty($_POST['chkdate']) ? $_POST['chkdate'] : null;
                $value['MemberName'] = $_POST['MemberName'] ?? '';
                $value['Amount'] = $_POST['Amount'] ?? '';
                $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                $value['payment_status'] = 'confirmed';
                $value['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
                $value['stripe_return'] = $_POST['stripe_return'] ?? '';
                $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                $value['paid_amount'] = $_POST['paid_amount'] ?? '';
                $value['stripe_product'] = $_POST['stripe_product'] ?? '';
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
                $value['spousename'] = $_POST['spousename'] ?? '';
                $value['purpose'] = $_POST['purpose'] ?? '';
                $value['Address3'] = $_POST['Address3'] ?? '';
                $MemberModel->SaveDataInmember($value);
            }
            $this->sendEmailDonations($_POST);
            $mobileno= $_POST['Tele1'] ?? '';
            if ($mobileno != null) {
                $msg = 'Houston Durga Bari: Donation confirmation are Member Id: '. ($_POST['Member_id'] ?? '').', Member Name: '. ($_POST['MemberName'] ?? '').' , Amount: $'. ($_POST['Amount'] ?? '').', Purpose: '. ($_POST['purpose'] ?? '').', Order Id: '. ($_POST['oid'] ?? '').', Status: ' . ($_POST['payment_status'] ?? '')  ;
                $this->SendSMS($mobileno, $msg);
             }
             echo '<script>alert("Data Updated Successfully")</script>';
            Util::redirect(INSTALL_URL . "donationdata/index");
        }

        if (!empty($_POST['pay_usermaintenance'])) {
            $adminamount = 0;
            $spouse = $_POST['spousename'] ?? '';
            $newspousename = explode(" ", $spouse);
            $spousefirst = $newspousename[0] ?? '';
            $spouselast = $newspousename[1] ?? '';
            $_POST['Sp_FName'] = $spousefirst;
            $_POST['Sp_LName'] = $spouselast;

            $memberna = $_POST['MemberName'] ?? '';
            $newspousename = explode(" ", $memberna);
            $memberfirst = $newspousename[0] ?? '';
            $memberlast = $newspousename[1] ?? '';
            $membermiddle = $newspousename[2] ?? '';

            $_POST['F_Name'] = $memberfirst;
            $_POST['L_Name'] = $memberlast;
            $_POST['M_Name'] = $membermiddle;

            $idmember = $_POST['demmember'] ?? '';
            $_POST['Member_id'] = $idmember;

            $id = $_POST['idunique'] ?? '';
            // $id = $_POST['ID'];
            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            //$_POST['oid']  = $maxoid;
            $oid = $maxoid;

            // end generate oid for

            $cat = $_POST['membercategory'] ?? '';


            if (($_POST['Payment_method'] ?? '') == 'check') {

                $adminamount = $_POST['checkAmount'] ?? '';
                $_POST['bank'] = $_POST['checkbankname'] ?? '';
                $_POST['chkdate'] = !empty($_POST['CheckDate']) ? $_POST['CheckDate'] : null;
                $_POST['pay_date'] = $_POST['CheckDate'] ?? '';
                $_POST['chkno'] = $_POST['checkno'] ?? '';

            } elseif (($_POST['Payment_method'] ?? '') == 'cash') {
                $adminamount = $_POST['cashAmount'] ?? '';
                $_POST['pay_date'] = $_POST['cashDate'] ?? '';
                $_POST['ReceiveBy'] = $_POST['lookupReceiveBy'] ?? '';
            } elseif (($_POST['Payment_method'] ?? '') == 'directdeposit') {
                $_POST['bank'] = $_POST['directbank'] ?? '';
                $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';
                $adminamount = $_POST['directdepositamount'] ?? '';

            }
            $renewmaintenancepreice = $_POST['total'] ?? '';
            if ($adminamount > $renewmaintenancepreice) {
                $_POST['amount'] = $renewmaintenancepreice;
            } else {
                $_POST['amount'] = $adminamount;
            }
            if (($_POST['amount'] ?? null) != null) {

                $StartingDate = date('Y');
                $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                $renew = $newEndingDate . "-" . "03" . "-" . "31";
                $total = $_POST['total'] ?? '';
                $opts['id'] = $id;
                $_POST['Renew_date'] = $renew;

                $opts = array();
                $opts['payment_timestamp'] = time();
                //date_default_timezone_set("America/Chicago");
                //$today = date("Y/m/d");
                //$_POST['pay_date']= $today;
                $_POST['pay_type'] = 'REGISTRATION';
                if ($cat == 'GD') {
                    $opts['Category'] = 'GM';
                    $_POST['pay_for'] = 'DB / HDBS Annual General Membership (GM)';
                } else {
                    $_POST['pay_for'] = 'DB / HDBS Annual Maintenance';
                }
                $_POST['payment_status'] = 'confirmed';
                $_POST['ID'] = $_POST['idunique'] ?? '';
                date_default_timezone_set("America/Chicago");
                $todaydate = date("Y/m/d");
                $_POST['UpdateOn'] = $todaydate;
                $datamemberarr = array();
                $datamemberarr = array_merge($opts, $_POST);
                $MemberModel->update(array_merge($opts, $_POST));

                $value = array();
                $value['oid'] = $oid;
                $value['Category'] = $datamemberarr['Category'];
                $value['Member_id'] = $datamemberarr['Member_id'];
                $value['MemberName'] = $datamemberarr['F_Name'] . '' . $datamemberarr['M_Name'] . '' . $datamemberarr['L_Name'];
                $value['ReceiveBy'] = $_POST['ReceiveBy'] ?? '';
                $value['PaymentOption'] = $datamemberarr['Payment_method'];
                $value['payment_status'] = 'succeeded';
                $value['bank'] = $_POST['bank'] ?? '';
                $value['chkno'] = $_POST['chkno'] ?? '';
                $value['chkdate'] = !empty($_POST['chkdate']) ? $_POST['chkdate'] : null;
                $value['transaction_id'] = $datamemberarr['transaction_id'];
                $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                $value['update_on'] = $datamemberarr['UpdateOn'];
                $value['pay_date'] = $datamemberarr['pay_date'];
                $value['Address'] = $datamemberarr['Address2'];
                $value['Street'] = $datamemberarr['Address1'];
                $value['State'] = $datamemberarr['State'];
                $value['Zip_Code'] = $datamemberarr['Zip'];
                $value['Tele1'] = $datamemberarr['Tele1'];
                $value['email'] = $datamemberarr['email'];
                $value['City'] = $datamemberarr['City'];
                $value['spousename'] = $datamemberarr['Sp_FName'] . '' . $datamemberarr['Sp_LName'];
                if ($renewmaintenancepreice == $adminamount) {
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Amount'] = $datamemberarr['total'];
                    $DonationModel->SaveDataInDonation($value);
                }
                if ($adminamount > $renewmaintenancepreice) {
                    $firstAmount = $renewmaintenancepreice;
                    $SecondAmount = $adminamount - $renewmaintenancepreice;
                    for ($i = 0; $i <= 1; $i++) {
                        if ($i == 0) {
                            $value['pay_type'] = $datamemberarr['pay_type'];
                            $value['pay_for'] = $datamemberarr['pay_for'];
                            $value['Amount'] = $firstAmount;
                            $DonationModel->SaveDataInDonation($value);
                        }
                        if ($i == 1) {
                            $value['pay_type'] = 'DONATION';
                            $value['pay_for'] = 'DONATION / Unrestricted';
                            $value['Amount'] = $SecondAmount;

                            $DonationModel->SaveDataInDonation($value);
                        }

                    }

                   
                }
                 $datamemberarr['adminamount'] = $adminamount;
                $this->sendEmailrenewalmember($datamemberarr, $oid);

                $currentyear = date("Y");
                $mobileno = $datamemberarr['Tele1'];
                if ($datamemberarr['Tele1'] != null) {
                    $msg = 'Houston Durga Bari: Your Membership Renewal/Maintenance Payment Request for year ' . $currentyear . ' details are Member Id: ' . $datamemberarr['Member_id'] . ', Member Name: ' . $datamemberarr['F_Name'] . '' . $datamemberarr['M_Name'] . '' . $datamemberarr['L_Name'] . ' , Email: ' . $datamemberarr['email'] . ', Amount: $' . $adminamount . ', Pay For: ' . $datamemberarr['pay_for'] . ', Membership Type: ' . $datamemberarr['membership_type'] . ', Order Id: ' . $oid . ', Status: ' . $datamemberarr['payment_status'];
                    $this->SendSMS($mobileno, $msg);
                }



                $data = array();

                $data['member_id'] = $datamemberarr['Member_id'];
                $data['Createdon'] = date('Y-m-d H:i:s');
                $data['rate'] = $_POST['total'] ?? '';
                // if($this->isMember()){
                //     $data['Updatedby'] = $this->getMemberId();
                // }else{
                //     $data['Updatedby'] = $this->getUserId();
                // }
                $categ = $datamemberarr['Category'];
                if ($categ == null) {
                    $data['Category'] = $datamemberarr['membercategory'];
                } else {
                    $data['Category'] = $datamemberarr['Category'];
                }

                if ($cat == 'GD') {
                    $data['Status'] = 'R';
                } else {

                    $data['Status'] = 'A';
                }

                $MemberLogModel->save($data);
                if ($cat == 'GD') {
                    $labelname = 'Membership Renewal';
                } else {
                    $labelname = 'Annual Maintenance';
                }

            }
            echo '<script>alert("Data Updated Successfully")</script>';
            Util::redirect(INSTALL_URL . "Member/index");
        }

        // For event
        if (!empty($_POST['create_event'])) {
            $eventadminamount = 0;

            $data = array();
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
            //$data['id'] = $id;
            $_POST['id'] = $id;
            $mandatoryamount = $_POST['Amount'] ?? '';
            if (($_POST['PaymentOption'] ?? '') == 'check') {

                $eventadminamount = $_POST['eventcheckAmount'] ?? '';
                $_POST['bank'] = $_POST['eventbankname'] ?? '';
                $_POST['chkdate'] = !empty($_POST['eventCheckDate']) ? $_POST['eventCheckDate'] : null;
                $_POST['pay_date'] = $_POST['eventCheckDate'] ?? '';
                $_POST['chkno'] = $_POST['eventcheckno'] ?? '';

            } elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                $eventadminamount = $_POST['eventcashAmount'] ?? '';
                $_POST['pay_date'] = $_POST['eventcashDate'] ?? '';
                $_POST['ReceiveBy'] = $_POST['eventReceiveBy'] ?? '';
            } elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                $_POST['bank'] = $_POST['eventdirectbank'] ?? '';
                $eventadminamount = $_POST['eventAmount'] ?? '';
                $_POST['transaction_id'] = $_POST['eventtransactioncode'] ?? '';
                $_POST['pay_date'] = $_POST['eventtransactiondate'] ?? '';

            }
            $eventdonation = $eventadminamount - $mandatoryamount;
            //$_POST['Amount'] = $eventadminamount;
            $_POST['Amount'] = $mandatoryamount;
            $_POST['eventdonation'] = $eventdonation;
            $_POST['totaldonation'] = $eventadminamount;
            $_POST['payment_status'] = 'succeeded';
            $_POST['eventid'] = $_POST['uniqueeventid'] ?? '';
            $datamemberarr = array_merge([
                'oid' => '',
                'eventid' => '',
                'bank' => '',
                'chkno' => '',
                'chkdate' => null,
                'ReceiveBy' => '',
                'type' => '',
                'Member_id' => '',
                'MemberName' => '',
                'PaymentOption' => '',
                'transaction_id' => '',
                'UpdateOn' => '',
                'pay_date' => '',
                'pay_type' => '',
                'pay_for' => '',
                'Tele1' => '',
                'email' => '',
                'Amount' => '',
            ], $_POST);
            $EventModel->save($_POST);
            $value = array();
            $value['oid'] = $datamemberarr['oid'];
            $value['eventid'] = $datamemberarr['eventid'];
            $value['bank'] = $datamemberarr['bank'];
            $value['chkno'] = $datamemberarr['chkno'];
            $value['chkdate'] = $datamemberarr['chkdate'];
            $value['ReceiveBy'] = $datamemberarr['ReceiveBy'];
            $value['type'] = $datamemberarr['type'];
            $value['Member_id'] = $datamemberarr['Member_id'];
            $value['MemberName'] = $datamemberarr['MemberName'];
            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
            $value['payment_status'] = 'succeeded';
            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
            $value['transaction_id'] = $datamemberarr['transaction_id'];
            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
            $value['update_on'] = $datamemberarr['UpdateOn'];
            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
            $value['pay_date'] = $datamemberarr['pay_date'];
            $value['pay_type'] = $datamemberarr['pay_type'];
            $value['pay_for'] = $datamemberarr['pay_for'];
            $value['Tele1'] = $datamemberarr['Tele1'];
            $value['email'] = $datamemberarr['email'];

            if ($mandatoryamount == $eventadminamount) {
                $value['pay_type'] = $datamemberarr['pay_type'];
                $value['pay_for'] = $datamemberarr['pay_for'];
                $value['Amount'] = $datamemberarr['Amount'];
                $DonationModel->SaveDataInDonation($value);
            }
            if ($eventadminamount > $mandatoryamount) {
                $firstAmount = $mandatoryamount;
                $SecondAmount = $eventadminamount - $mandatoryamount;
                for ($i = 0; $i <= 1; $i++) {
                    if ($i == 0) {
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Amount'] = $firstAmount;
                        $DonationModel->SaveDataInDonation($value);
                    }
                    if ($i == 1) {
                        $value['pay_type'] = 'DONATION';
                        $value['pay_for'] = 'DONATION / Unrestricted';
                        ;
                        $value['Amount'] = $SecondAmount;
                        $DonationModel->SaveDataInDonation($value);
                    }

                }
            }
            if ($datamember == null) {
                $value = array();
                $value['type'] = $_POST['type'] ?? '';
                $value['bank'] = $_POST['bank'] ?? '';
                $value['chkno'] = $_POST['chkno'] ?? '';
                $value['chkdate'] = !empty($_POST['chkdate']) ? $_POST['chkdate'] : null;
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
                $value['Phone_Number'] = $_POST['Tele1'] ?? '';
                $value['email'] = $_POST['email'] ?? '';
                $value['eventdonation'] = $_POST['eventdonation'] ?? '';
                $value['Address3'] = $_POST['Address3'] ?? '';
                $MemberModel->SaveDataInmember($value);
            }
            
            $_POST['adminamount'] = $eventadminamount;
            $this->sendEmailEvent($_POST);
            $mobileno = $_POST['Tele1'] ?? '';
            $datefor = $_POST['pay_date'] ?? '';
            $timestamp = strtotime($datefor);
            $payfinaldate = date("m/d/Y", $timestamp);
            if ($mobileno != null) {
              $msg = 'Houston Durga Bari: Event confirmation are Member Id: '. ($_POST['Member_id'] ?? '').',  Order Id: '. ($_POST['oid'] ?? '').', Member Name: '. ($_POST['MemberName'] ?? '').' , Event Name: '. ($_POST['type'] ?? '').' , Amount: $'. $eventadminamount.', Pay Date: '.$payfinaldate.',  Status: ' . ($_POST['payment_status'] ?? '')  ;
              $this->SendSMS($mobileno, $msg);
              }
            echo '<script>alert("Data Updated Successfully")</script>';
            Util::redirect(INSTALL_URL . "Eventadmin/index");
        }


        // For ticket
        if (!empty($_POST['create_ticket'])) {
            $ticketadminamount = 0;

            $data = array();
            $_POST['pay_for'] = 'TICKET' . '/' . ($_POST['type'] ?? '');

            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for 
            $registermember = $_POST['MemberName'] ?? '';
            $regmember = $_POST['regmember'] ?? '';

            $datamember = $MemberModel->ticketduplicatemember();
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
            $eventday = $_POST['Daysticket'] ?? '';
            $_POST['itemeventday'] = $eventday;
            $_POST['eventid'] = $_POST['ticketuniqueeventid'] ?? '';

            $id = $ticketModel->getticketMaxid() + 1;
            //$data['id'] = $id;
            $_POST['id'] = $id;

            $tickettotalamount = $_POST['amount'] ?? '';
            if (($_POST['PaymentOption'] ?? '') == 'check') {

                $ticketadminamount = $_POST['ticketcheckAmount'] ?? '';
                $_POST['bank'] = $_POST['ticketbankname'] ?? '';
                $_POST['chkdate'] = !empty($_POST['ticketCheckDate']) ? $_POST['ticketCheckDate'] : null;
                $_POST['pay_date'] = $_POST['ticketCheckDate'] ?? '';
                $_POST['chkno'] = $_POST['ticketcheckno'] ?? '';

            } elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                $ticketadminamount = $_POST['ticketcashAmount'] ?? '';
                $_POST['pay_date'] = $_POST['ticketcashDate'] ?? '';
                $_POST['ReceiveBy'] = $_POST['ticketReceiveBy'] ?? '';
            } elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                $_POST['bank'] = $_POST['ticketdirectbank'] ?? '';
                $ticketadminamount = $_POST['ticketdirectamount'] ?? '';
                $_POST['txn_id'] = $_POST['tickettransactioncode'] ?? '';
                $_POST['pay_date'] = $_POST['tickettransactiondate'] ?? '';

            }
            $_POST['amount'] = $ticketadminamount;
            $_POST['payment_status'] = 'confirmed';
            $_POST['eventid'] = $_POST['ticketuniqueeventid'] ?? '';
            $datamemberarr = array_merge([
                'oid' => '',
                'eventid' => '',
                'type' => '',
                'bank' => '',
                'chkno' => '',
                'chkdate' => null,
                'ReceiveBy' => '',
                'Member_id' => '',
                'name' => '',
                'PaymentOption' => '',
                'txn_id' => '',
                'UpdateOn' => '',
                'pay_date' => '',
                'pay_for' => '',
                'tele' => '',
                'email' => '',
                'amount' => '',
            ], $_POST);
            $ticketModel->save($_POST);

            $value = array();
            $value['oid'] = $datamemberarr['oid'];
            $value['eventid'] = $datamemberarr['eventid'];
            $value['type'] = $datamemberarr['type'];
            $value['bank'] = $datamemberarr['bank'];
            $value['chkno'] = $datamemberarr['chkno'];
            $value['chkdate'] = $datamemberarr['chkdate'];
            $value['ReceiveBy'] = $datamemberarr['ReceiveBy'];
            $value['Member_id'] = $datamemberarr['Member_id'];
            $value['MemberName'] = $datamemberarr['name'];
            $value['PaymentOption'] = $datamemberarr['PaymentOption'];
            $value['payment_status'] = 'succeeded';
            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
            $value['transaction_id'] = $datamemberarr['txn_id'];
            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
            $value['update_on'] = $datamemberarr['UpdateOn'];
            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
            $value['pay_date'] = $datamemberarr['pay_date'];
            $value['pay_type'] = 'TICKET';
            $value['pay_for'] = $datamemberarr['pay_for'];
            $value['Tele1'] = $datamemberarr['tele'];
            $value['email'] = $datamemberarr['email'];
            if ($tickettotalamount == $ticketadminamount) {
                $value['pay_type'] = 'TICKET';
                $value['pay_for'] = $datamemberarr['pay_for'];
                $value['Amount'] = $datamemberarr['amount'];
                $DonationModel->SaveDataInDonation($value);
            }
            if ($ticketadminamount > $tickettotalamount) {
                $firstAmount = $tickettotalamount;
                $SecondAmount = $ticketadminamount - $tickettotalamount;
                for ($i = 0; $i <= 1; $i++) {
                    if ($i == 0) {
                        $value['pay_type'] = 'TICKET';
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Amount'] = $firstAmount;
                        $DonationModel->SaveDataInDonation($value);
                    }
                    if ($i == 1) {
                        $value['pay_type'] = 'DONATION';
                        $value['pay_for'] = 'DONATION / Unrestricted';
                        ;
                        $value['Amount'] = $SecondAmount;
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
                $value['transaction_id'] = $opts['txn_id'] ?? ($_POST['txn_id'] ?? '');
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
             $_POST['adminamount'] = $ticketadminamount;
            
            $this->sendEmailTicketEvent($_POST);
            $datefor = $_POST['pay_date'] ?? '';
            $timestamp = strtotime($datefor);
            $payfinaldate = date("m/d/Y", $timestamp);
            $mobileno = $_POST['tele'] ?? ''; 
            if ($mobileno != null) {
              $msg = 'Houston Durga Bari: Ticket Confirmation are Member Id: '. ($_POST['Member_id'] ?? '').', Order Id: '. ($_POST['oid'] ?? '').', Member Name: '. ($_POST['MemberName'] ?? '').', Event Name: '. ($_POST['type'] ?? '').', Event Day: '. ($_POST['itemeventday'] ?? '').', Quantity: '. ($_POST['item_number'] ?? '').' , Ticket Amount: $'. ($_POST['item_cost'] ?? '').' , Total Amount: $'. $ticketadminamount.', Pay Date: '. $payfinaldate.',  Status: ' . ($_POST['payment_status'] ?? '') ;
             $this->SendSMS($mobileno, $msg);
            }
            echo '<script>alert("Data Updated Successfully")</script>';
            Util::redirect(INSTALL_URL . "Eventadmin/index");
        }
       //for gift& misc
        if (!empty($_POST['create_donationgiftmisc'])) {
            $adminamount = 0;

            $data = array();
            $id = $DonationModel->getMaxid() + 1;
            $data['id'] = $id;
            $gift =  $_POST['paymentfor'] ?? '';
            if($gift == "gift")
            {
                $_POST['pay_type']= 'GIFT';
                $_POST['pay_for']= '1 Gift Shop';
            }  
            else{
                $_POST['pay_type']= 'MISC';
                $_POST['pay_for']= '1 Miscelaneous';
            }  

            // for generate oid 
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
            if (($_POST['PaymentOption'] ?? '') == 'check') {
                 $adminamount = $_POST['checkAmountgift'] ?? '';
                $_POST['bank'] = $_POST['checkbanknamegift'] ?? '';
                $_POST['chkdate'] = !empty($_POST['CheckDategift']) ? $_POST['CheckDategift'] : null;
                $_POST['chkno'] = $_POST['checknogift'] ?? '';
                $_POST['pay_date'] = $_POST['CheckDategift'] ?? '';
            } elseif (($_POST['PaymentOption'] ?? '') == 'cash') {
                $_POST['pay_date'] = $_POST['cashDategift'] ?? '';
                $_POST['ReceiveBy'] = $_POST['ReceiveBygift'] ?? '';
                $adminamount = $_POST['cashAmountgift'] ?? '';   
            } elseif (($_POST['PaymentOption'] ?? '') == 'directdeposit') {
                $_POST['bank'] = $_POST['banknamegiftmisc'] ?? '';
                $_POST['pay_date'] = $_POST['dategiftmisc'] ?? '';
                $_POST['transaction_id'] = $_POST['transactioncodegift'] ?? '';
                $adminamount = $_POST['directamountgift'] ?? '';
            }
            $_POST['payment_status'] = 'succeeded';
            //$_POST['Amount'] = $adminamount;
             $giftdonationamount = is_numeric($_POST['giftdonationamount'] ?? null) ? (float)$_POST['giftdonationamount'] : 0;
             $adminamount = is_numeric($adminamount) ? (float)$adminamount : 0;

             if ($giftdonationamount == $adminamount) {
                 $data['pay_type'] = $_POST['pay_type'] ?? '';
                 $data['pay_for'] = $_POST['pay_for'] ?? '';
                 $data['Amount'] = $adminamount;
                 //$DonationModel->SaveDataInDonation($value);
                 $DonationModel->save(array_merge($_POST, $data));
             }
             if ($adminamount > 0 && $adminamount < $giftdonationamount) {
                 $data['pay_type'] = $_POST['pay_type'] ?? '';
                 $data['pay_for'] = $_POST['pay_for'] ?? '';
                 $data['Amount'] = $adminamount;
                 $DonationModel->save(array_merge($_POST, $data));
             }

             if ($adminamount > $giftdonationamount) {
                $firstAmount = $giftdonationamount;
                $SecondAmount = $adminamount - $giftdonationamount;
                for ($i = 0; $i <= 1; $i++) {
                    if ($i == 0) {
                        $data['pay_type'] = $_POST['pay_type'] ?? '';
                        $data['pay_for'] = $_POST['pay_for'] ?? '';
                        $data['Amount'] = $firstAmount;
                        $DonationModel->save(array_merge($_POST, $data));
                        //$DonationModel->SaveDataInDonation($value);
                    }
                    if ($i == 1) {
                        $data['pay_type'] = 'DONATION';
                        $data['pay_for'] = 'DONATION / Unrestricted';
                        $data['Amount'] = $SecondAmount;
                        $id = $DonationModel->getMaxid() + 1;
                        $data['id'] = $id;
                        //$DonationModel->SaveDataInDonation($value);
                        $DonationModel->save(array_merge($_POST, $data));
                    }

                }

            }
            if ($datamember == null) {
                $value = array();
                $value['type'] = $_POST['type'] ?? '';
                $value['bank'] = $_POST['bank'] ?? '';
                $value['chkno'] = $_POST['chkno'] ?? '';
                $value['chkdate'] = !empty($_POST['chkdate']) ? $_POST['chkdate'] : null;
                $value['MemberName'] = $_POST['MemberName'] ?? '';
                $value['Amount'] = $data['Amount'] ?? '';
                $value['PaymentOption'] = $_POST['PaymentOption'] ?? '';
                $value['payment_status'] = 'confirmed';
                $value['payment_timestamp'] = $_POST['payment_timestamp'] ?? '';
                $value['stripe_return'] = $_POST['stripe_return'] ?? '';
                $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                $value['paid_amount'] = $_POST['paid_amount'] ?? '';
                $value['stripe_product'] = $_POST['stripe_product'] ?? '';
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
           $_POST['adminamount'] = $adminamount;
            $datefor = $_POST['pay_date'] ?? '';
            $timestamp = strtotime($datefor);
             $payfinaldate = date("m/d/Y", $timestamp);
            $this->sendGiftShopMisc($_POST);
            $mobileno= $_POST['Tele1'] ?? '';
            if ( $mobileno != null) {
                 $msg = 'Houston Durga Bari: Payment confirmation are Member Id: '. ($_POST['Member_id'] ?? '').', Order Id: '. ($_POST['oid'] ?? '').', Member Name: '. ($_POST['MemberName'] ?? '').' , Pay For: '. ($_POST['pay_type'] ?? '').' , Amount: $'. $adminamount.', Prupose:'. ($_POST['purpose'] ?? '').', Pay Date: '. $payfinaldate.',  Status: ' . ($_POST['payment_status'] ?? '')  ;
                 $this->SendSMS($mobileno, $msg);
            } 
            echo '<script>alert("Data Updated Successfully")</script>';

            Util::redirect(INSTALL_URL . "giftshop/index");
        }

    }
    
    
     function index() {
       
        GzObject::loadFiles('Model', array('eventrevenue'));
        $eventrevenueModel = new eventrevenueModel();
      
        $filter = $_POST['select'] ?? null;
       
        $opts = array();
         if(isset($filter)){
         $Eventarr = $eventrevenueModel->DonationForTicketEvents($filter);
         }
         else{
            $currentyear = date("Y");
            $Eventarr = $eventrevenueModel->DonationForTicketEvents($currentyear);  
         }
         $this->tpl['Eventarr'] = $Eventarr;
         $this->tpl['date'] = $filter;
         echo  "<input  id='datanew' style='display:none;' value='$filter'/> ";

    }
    
    function exportyear() {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('eventrevenue'));
        $eventrevenueModel = new eventrevenueModel();
        $opts = array();
       
        $type= $_GET['ID'] ?? '';

        $header_args = array( 'year', 'EventName', 'Revenue');
     
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Eventrevenuedata_export.csv');
        $output = fopen( 'php://output', 'w' );
        if (ob_get_level()) ob_end_clean();
        fputcsv($output, $header_args, ',', '"', '\\');
        $reportarr = $eventrevenueModel->DonationForTicketEvents($type);
            foreach ($reportarr as $data_item) {
                fputcsv($output, $data_item, ',', '"', '\\');
            }
        
        exit;
    }
}
?>

<script>
    var serverDateTime = "<?php echo $serverDateTime; ?>";
    var currentYear = "<?php echo $currentYear; ?>";
</script>


