<?php

require_once CONTROLLERS_PATH . 'App.php';

class Adminpaymentstudent extends App {

    var $layout = 'admin';
    var $option_arr = null;

    function beforeFilter() {

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
        //$this->js[] = array('file' => 'jquery.min.js', 'path' => JS_PATH);
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
        
       // $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
    }
    
    
    function Adminpaymentstudent() {
        $this->js[] = array('file' => 'jquery.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzadminpaymentStudent.js', 'path' => JS_PATH);
        GzObject::loadFiles('Model', array('Donation', 'Member', 'idnumbers','Student'));
        $DonationModel = new DonationModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();  
        $StudentModel = new StudentModel();
        if (!empty($_POST['create_Student'])) {
            $adminamount = 0;
            $firststsubject = '';
            $studentsecondsubject = '';

            $data = array();
            $data['subject'] = serialize($_POST['subject'] ?? []);
            $data['type'] = serialize($_POST['type'] ?? []);

            $neememberid = $_POST['demmember'] ?? '';
            $newmember = $_POST['membername'] ?? '';
            $namemember = $_POST['namenonmember'] ?? '';
            $checkmember =  $_POST['regmember'] ?? '';
            
            $datamember =  $MemberModel->studentcheckduplicatemember();
            if($datamember == null){
                
                // for generate memberid for gd
                    $maxid = $idnumbersModel->getMaxmid() + 1;
                    $update_mid = $idnumbersModel->Updatemid($maxid);
                    $_POST['reg_uid'] = $maxid;
               // end generate memberid for gd 
            }
            if ($datamember != null) {
                $_POST['reg_uid'] = $datamember;
            }
            
           if($checkmember == "nonmember"){
                $_POST['membername'] = $namemember; 
               } else {
                $_POST['membername'] = $newmember;
                //$_POST['reg_uid'] = $neememberid;

            }
            $subject = is_array($_POST['subject'] ?? null) ? $_POST['subject'] : [];

            $type = is_array($_POST['type'] ?? null) ? $_POST['type'] : [];
            $subjectcount = count($subject);
           $secondsubjectcount =  count($type);
            if($subjectcount == 2){
              $firststsubject = $subject[0].','. $subject[1];
            } 
            if($subjectcount == 1)
            {
                $firststsubject = $subject[0];
            }

            if($secondsubjectcount == 2){
                $studentsecondsubject = $type[0].','. $type[1];
                 } 
                 if($secondsubjectcount == 1)
                 {
                     $studentsecondsubject = $type[0];
                 }
            $_POST['subject'] = $subject;  
            unset($_POST['subject']);
            unset($_POST['type']);
            
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
        // end generate oid for 
            //pay_date end......

            $id = $StudentModel->getidMax() + 1;
            $_POST['uid'] = $id;
            
            
            $_POST['pay_type']= 'REGISTRATION';
            $regtype =  $_POST['Registration_type'] ?? '';
            if($regtype == "BanglaSchool"){
            $_POST['pay_for']= 'BS School';
            $_POST['school'] = 'BANGLA';
            }
            else if($regtype == "Kalabhavan"){
                $_POST['pay_for']= 'KB School';
                $_POST['school'] = 'KALAB';
            } else if ($regtype == "workshops") {
                $_POST['pay_for'] = 'Workshops';
                $_POST['school'] = 'OTHER';
            }
            else if($regtype == "library"){
                $_POST['pay_for']= 'Library';
                $_POST['school'] = 'OTHER';
            }
            $studentfeeprice = $_POST['totalamount'] ?? ''; 
            if (($_POST['payment_method'] ?? '') == 'check') {
                $adminamount = $_POST['checkAmount'] ?? '';
               // $_POST['totalamount'] = $adminamount;
                $_POST['bank'] = $_POST['checkbankname'] ?? '';
                $_POST['chkdate'] = !empty($_POST['CheckDate']) ? $_POST['CheckDate'] : null;
                $_POST['chkno'] =  $_POST['checkno'] ?? '';
                $_POST['pay_date']= $_POST['CheckDate'] ?? '';
            }
            elseif (($_POST['payment_method'] ?? '') == 'cash') {
                $adminamount = $_POST['cashAmount'] ?? '';
                //$_POST['totalamount'] = $adminamount;
                $_POST['pay_date'] = $_POST['cashDate'] ?? ''; 
            }
            elseif (($_POST['payment_method'] ?? '') == 'directdeposit'){
                $_POST['bank'] = $_POST['directbank'] ?? '';
                $_POST['pay_date'] = $_POST['transactiondate'] ?? '';
                $_POST['transaction_id'] = $_POST['transactioncode'] ?? '';
                $adminamount = $_POST['directdepositAmount'] ?? '';
                //$_POST['totalamount'] =  $adminamount;

            }
            $adminamount = is_numeric($adminamount) ? (float)$adminamount : 0;
            $studentfeeprice = is_numeric($studentfeeprice) ? (float)$studentfeeprice : 0;
            if($adminamount > $studentfeeprice){
                $_POST['totalamount'] = $studentfeeprice;
                }else{
                    $_POST['totalamount'] =  $adminamount;
                }

            $_POST['payment_status'] = 'confirmed';
            $_POST['CreatedOn'] = $_POST['CreatedOn'] ?? date('Y-m-d');
            $_POST['update_on'] = $_POST['update_on'] ?? date('Y-m-d H:i:s');
            $datamemberarr =  array_merge([
                'oid' => '',
                'reg_uid' => '',
                'membername' => '',
                'totalamount' => '',
                'payment_method' => '',
                'bank' => '',
                'chkno' => '',
                'chkdate' => null,
                'ReceiveBy' => '',
                'transaction_id' => '',
                'UpdateOn' => date('Y-m-d H:i:s'),
                'update_on' => date('Y-m-d H:i:s'),
                'CreatedOn' => date('Y-m-d'),
                'pay_date' => '',
                'pay_type' => '',
                'pay_for' => '',
                'phone_number' => '',
                'email' => '',
                'Registration_type' => '',
                'St_Name1' => '',
                'St_Name2' => '',
                'payment_status' => '',
            ], $_POST, $data);
            $StudentModel->save(array_merge($_POST, $data));
            $value = array();
                                $value['oid'] =$datamemberarr['oid'];
                                $value['Member_id'] = $datamemberarr['reg_uid'];
                                $value['MemberName'] = $datamemberarr['membername'];
                                $value['Amount'] = $datamemberarr['totalamount'];
                                $value['PaymentOption'] = $datamemberarr['payment_method'];
                                $value['bank'] = $datamemberarr['bank'];
                                $value['chkno'] = $datamemberarr['chkno'];
                                $value['chkdate'] = $datamemberarr['chkdate'];
                                $value['ReceiveBy'] = $datamemberarr['ReceiveBy'];
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
                                $value['Tele1'] = $datamemberarr['phone_number'];
                                $value['email'] = $datamemberarr['email'];
                                
                                if($studentfeeprice == $adminamount ){
                                    $value['pay_type'] = $datamemberarr['pay_type'];
                                    $value['pay_for'] = $datamemberarr['pay_for'];
                                    $value['Amount'] = $datamemberarr['totalamount'];
                                $DonationModel->SaveDataInDonation($value);
                                } 
                                if($adminamount > 0 && $adminamount < $studentfeeprice){
                                    $value['pay_type'] = $datamemberarr['pay_type'];
                                    $value['pay_for'] = $datamemberarr['pay_for'];
                                    $value['Amount'] = $adminamount;
                                    $DonationModel->SaveDataInDonation($value);
                                }
                                if($adminamount >$studentfeeprice){
                                    $firstAmount= $studentfeeprice;
                                    $SecondAmount= $adminamount - $studentfeeprice;
                                    for($i=0;$i<=1;$i++){
                                        if($i==0){
                                            $value['pay_type'] = $datamemberarr['pay_type'];
                                            $value['pay_for'] = $datamemberarr['pay_for'];
                                            $value['Amount'] = $firstAmount;
                                            $DonationModel->SaveDataInDonation($value);
                                        }
                                        if($i==1){
                                            $value['pay_type'] = 'DONATION';
                                            $value['pay_for'] = 'DONATION / Unrestricted';
                                            $value['Amount'] = $SecondAmount;
            
                                            $DonationModel->SaveDataInDonation($value);
                                        }
                                        
                                    }
                                    
                                   
                                    }
            if($datamember == null){
                $value = array();
                // $value['id'] = $_POST['id'] ?? '';
                $value['Registration_type'] = $_POST['Registration_type'] ?? '';
                $value['Child1'] = $_POST['St_Name1'] ?? '';
                $value['Child2'] = $_POST['St_Name2'] ?? '';
                $value['school'] = $_POST['school'] ?? '';
                $value['subject'] = $_POST['subject'] ?? '';
                $value['type'] = $_POST['type'] ?? '';
                $value['fee'] = $_POST['fee'] ?? '';
                $value['State'] = $_POST['State'] ?? '';
                $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                $value['payment_status'] = 'confirmed';
                $value['transaction_id'] = $_POST['transaction_id'] ?? '';
                $value['Tele1'] = $_POST['phone_number'] ?? '';
                $value['email'] = $_POST['email'] ?? '';
                $value['Member_id'] = $_POST['reg_uid'] ?? '';
                $value['pay_date'] = $_POST['pay_date'] ?? '';
                $value['cc_name'] = $_POST['cc_name'] ?? '';
                $value['remarks'] = $_POST['remarks'] ?? '';
                $value['oid'] = $_POST['oid'] ?? '';
                $value['pay_type'] = $_POST['pay_type'] ?? '';
                $value['pay_for'] = $_POST['pay_for'] ?? '';
                $value['CreatedOn'] = $_POST['CreatedOn'] ?? date('Y-m-d');
                $value['UpdateOn'] = $_POST['update_on'] ?? date('Y-m-d H:i:s');
                $value['MemberName'] = $_POST['membername'] ?? '';
                $value['Amount'] = $_POST['totalamount'] ?? '';
                $MemberModel->SaveDataInmember($value);
            }
            $opts = $_POST['payment_status'] ?? '';
		    $this->sendEmailstudent($_POST, $firststsubject,$studentsecondsubject);
            $mobileno = $_POST['phone_number'] ?? '';
                 if (!empty($_POST['phone_number'])) {
                       $msg = 'Houston Durga Bari: Student Registration confirmation are Member Id: '. $datamemberarr['reg_uid'].' , Member Name: '.  $datamemberarr['membername'].', Registration Type: '.  $datamemberarr['Registration_type'].', First Student Name: '.  $datamemberarr['St_Name1'].', First Student Subject: '. $firststsubject.' , Second Student Name: '. $datamemberarr['St_Name2'].', Second Student Subject: '. $studentsecondsubject.'  , Fee: $'.  $datamemberarr['totalamount'].',  Order Id: '.  $datamemberarr['oid'].', Status: ' .  $datamemberarr['payment_status'];
                       $this->SendSMS($mobileno, $msg);
                 }
                 echo '<script>alert("Data Updated Successfully")</script>';
                 Util::redirect(INSTALL_URL . "Student/index");
            }
            
           

        }
    }
