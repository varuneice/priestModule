<?php

require_once CONTROLLERS_PATH . 'App.php';
class Student extends App
{

    var $layout = 'admin';
    var $option_arr = null;

    function beforeFilter()
    {
        GzObject::loadFiles('Model', array('Option', 'Student', 'Member'));
        //GzObject::loadFiles('Model', 'Option','Student','Member');
        $OptionModel = new OptionModel();
        $MemberModel = new MemberModel();
        $this->tpl['members'] = $MemberModel->getAll();
        $this->option_arr = $OptionModel->getAllPairValues();
        $this->tpl['option_arr'] = $OptionModel->getAllPairs();
        $this->tpl['option_arr_values'] = $this->option_arr;



        $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format']);
        $this->tpl['iso_format'] = Util::getISODateFormta($this->tpl['option_arr_values']['date_format']);

        $tz = $this->tpl['option_arr_values']['timezone'] ?? '';
        if ($tz) {
            date_default_timezone_set($tz);
        }



        if ($this->isAdmin()) {
            if ((!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') || (!$this->isAdmin() && !in_array(($_REQUEST['action'] ?? ''), array('edit')))) {
                GzObject::loadFiles('Model', array('Student'));
                $StudentModel = new StudentModel();
                if (($_REQUEST['action'] ?? '') != 'create' && ($_REQUEST['action'] ?? '') != 'feeprice'  && ($_REQUEST['action'] ?? '') != 'AllMember' && ($_REQUEST['action'] ?? '') != 'subjectsstudent') {
                    $_SESSION['err'] = 2;
                    Util::redirect(INSTALL_URL . "Admin/login");
                }
            }
        }

        if ($this->isEducation() || $this->isRegistration()) {
            if ((!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') || (!$this->isEducation() && !in_array(($_REQUEST['action'] ?? ''), array('edit')))) {
                GzObject::loadFiles('Model', array('Student'));
                $StudentModel = new StudentModel();
                if (($_REQUEST['action'] ?? '') != 'create' && ($_REQUEST['action'] ?? '') != 'feeprice'  && ($_REQUEST['action'] ?? '') != 'AllMember' && ($_REQUEST['action'] ?? '') != 'subjectsstudent') {
                    $_SESSION['err'] = 2;
                    Util::redirect(INSTALL_URL . "Admin/login");
                }
            }
        }

        if ($this->isMember()) {

            if (($_REQUEST['action'] ?? '') != 'create') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }

        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/css/bootstrap-select.min.css', 'path' => JS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);

        // For search dropdown search box 
        //$this->css[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/css/bootstrap-select.min.css', 'path' => JS_PATH);
        //$this->js[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/js/bootstrap-select.min.js', 'path' => JS_PATH);
        //$this->js[] = array('file' => 'jquery.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.min.js', 'path' => LIBS_PATH . 'jquery/ui/');
        $this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/js/bootstrap-select.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);

        if (($_REQUEST['action'] ?? '') == 'create') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
            $this->js[] = array('file' => 'otp-member-verify.js?v=' . time(), 'path' => JS_PATH);
        }

        $this->js[] = array('file' => 'GzStudent.js?v=' . time(), 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
        //$this->js[] = array('file' => 'load.js', 'path' => JS_PATH);
        //$this->js[] = array('file' => 'GzBooking.js', 'path' => JS_PATH);
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
            echo  "<input  id='Tele1' value='$value[Tele1]'/> ";
            echo  "<input  id='email' value='$value[email]'/> ";
            echo  "<input  id='memberid' value='$value[Member_id]'/> ";
        }
    }

    function subjectsstudent()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('subjectfee'));
        $subjectfeeModel = new subjectfeeModel();
        $registration = $_POST['regtype'] ?? '';
        $arr = $subjectfeeModel->subjectsstudent($registration);
        $this->tpl['subject'] =  $arr;
        foreach ($arr as $key => $value) {

            echo '<option value="' . $value['subject'] . '">' . $value['subject'] . '</option>';
        }
    }
    function feeprice()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('Studentfee', 'registrationLastDate'));

        $StudentfeeModel = new StudentfeeModel();
        $registrationLastDateModel = new registrationLastDateModel();

        $regmember = $_POST['regmember'] ?? '';
        $registertype = $_POST['typeregistration'] ?? '';
        $arr = $StudentfeeModel->feeprice($regmember);
        $this->tpl['Price'] =  $arr;

        $registrationLastnDate = $registrationLastDateModel->getAll();
        $latefeedate = $registrationLastnDate[0]['registrationDate'] ?? null;

        date_default_timezone_set("America/Chicago");
        $today = date("Y-m-d");
        if ($today >= $latefeedate) {
            foreach ($arr as $key => $value) {
                $pricelatefee =  $value['Price'] + $value['lateFee'];
                echo '<option value="' . $pricelatefee . '">' . $pricelatefee . '</option>';
            }
        } else {
            foreach ($arr as $key => $value) {
                echo '<option value="' . $value['Price'] . '">' . $value['Price'] . '</option>';
            }
        }
    }

    function RegistrationLasteDateindex()
    {

        GzObject::loadFiles('Model', array('registrationLastDate'));
        $registrationLastDateModel = new registrationLastDateModel();

        if (!$this->isLoged() && (($_REQUEST['action'] ?? '') ?? '') != 'login') {

            if ((($_REQUEST['action'] ?? '') ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }

        $opts = array();
        $RegistrationLastDatearr = $registrationLastDateModel->getAll($opts);
        $this->tpl['RegistrationLastDatearr'] = $RegistrationLastDatearr;
    }

    function registrationDate()
    {
        GzObject::loadFiles('Model', array('registrationLastDate', 'User'));
        $registrationLastDateModel = new registrationLastDateModel();
        $UserModel = new UserModel();

        if (!empty($_POST['registrationDate'])) {

            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'] . ' ' . $admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;
            }

            $id = $registrationLastDateModel->update($_POST);

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Student/RegistrationLasteDateindex");
            }
        }
    }
    function Studentfee()
    {
        GzObject::loadFiles('Model', array('Studentfee', 'subjectfee'));
        $StudentfeeModel = new StudentfeeModel();
        $subjectfeeModel = new subjectfeeModel();


        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }

        if (!empty($_POST['create'])) {

            $SemesterName = $_POST['SemmsterName'] ?? '';
            $price = $_POST['Price'] ?? '';
            $Semesterprice = $price . "/" . $SemesterName;
            $_POST['Price'] = $Semesterprice;

            $id = $StudentfeeModel->getMaxid() + 1;
            $_POST['Id'] = $id;
            $StudentfeeModel->save(array_merge($_POST));
            $Id = $_POST['Id'] ?? '';
            if (!empty($Id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Student/feeindex");
        }
        if (!empty($_POST['createnewsubject'])) {

            //$id = $subjectfeeModel->getMaxid() + 1;
            //$_POST['Id'] = $id;

            $id = $subjectfeeModel->save(array_merge($_POST));
            //$Id = $_POST['id'];
            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "Student/subjectindex");
        }
    }

    function feeedit()
    {

        GzObject::loadFiles('Model', array('Studentfee', 'subjectfee'));
        $StudentfeeModel = new StudentfeeModel();
        $subjectfeeModel = new subjectfeeModel();

        if (!empty($_POST['feeedit_Student'])) {

            $data = array();

            $id = $StudentfeeModel->update(array_merge($data, $_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Student/feeindex");
            }
        }
        $id = $_GET['id'] ?? '';
        $feearr = $StudentfeeModel->get($id);
        $this->tpl['feearr'] = $feearr;
        if (!empty($_POST['createnewsubject'])) {

            $data = array();

            $id = $subjectfeeModel->update(array_merge($data, $_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Student/subjectindex");
            }
        }
        $id = $_GET['id'] ?? '';
        $subjectarr = $subjectfeeModel->get($id);

        $this->tpl['subjectarr'] = $subjectarr;
    }


    function feeindex()
    {

        GzObject::loadFiles('Model', array('Studentfee'));
        $StudentfeeModel = new StudentfeeModel();

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }



        $opts = array();
        $feearr = $StudentfeeModel->getAll($opts);
        $this->tpl['feearr'] = $feearr;
    }

    function subjectindex()
    {

        GzObject::loadFiles('Model', array('subjectfee'));
        $subjectfeeModel = new subjectfeeModel();

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }


        $opts = array();
        $subjectarr = $subjectfeeModel->getAll($opts);
        $this->tpl['subjectarr'] = $subjectarr;
    }

    function create()
    {
        $this->js[] = array('file' => 'jquery.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzStudent.js?v=' . time(), 'path' => JS_PATH);
        GzObject::loadFiles('Model', array('Student', 'ConfirmCode', 'Country', 'Studentfee', 'idnumbers', 'Member', 'Donation'));
        $StudentModel = new StudentModel();
        $CountryModel = new CountryModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $arr = $CountryModel->getCountry();
        $StudentfeeModel = new StudentfeeModel();
        $idnumbersModel = new idnumbersModel();
        $MemberModel = new MemberModel();
        $DonationModel = new DonationModel();
        //$arr= $StudentfeeModel->getfee();
        // $this->tpl['allfee'] =  $arr;


        $this->tpl['Country'] =  $arr;
        if (!empty($_POST['create_Student'])) {

            if (isset($_SESSION['StudentPaymentProcessed']) && $_SESSION['StudentPaymentProcessed'] === true) {
                unset($_SESSION['StudentPaymentProcessed']);
                Util::redirect(INSTALL_URL . "Student/create");
                exit();
            }

            $data = array();
            $data['subject'] = serialize($_POST['subject'] ?? []);
            $data['type'] = serialize($_POST['type'] ?? []);

            $neememberid = $_POST['demmember'] ?? '';
            $newmember = $_POST['membername'] ?? '';
            $namemember = $_POST['namenonmember'] ?? '';
            $checkmember =  $_POST['regmember'] ?? '';

            if ($checkmember === 'member' && empty($_SESSION['otp_verified_member'])) {
                $_SESSION['status'] = 'Member verification required. Please complete OTP verification before submitting.';
                Util::redirect(INSTALL_URL . 'Student/create');
                return;
            }

            $datamember =  $MemberModel->studentcheckduplicatemember();
            if ($datamember == null) {

                // for generate memberid for gd
                $maxid = $idnumbersModel->getMaxmid() + 1;
                $update_mid = $idnumbersModel->Updatemid($maxid);
                $_POST['reg_uid'] = $maxid;
                // end generate memberid for gd 
            }
            if ($datamember != null) {
                $_POST['reg_uid'] = $datamember;
            }

            if ($checkmember == "nonmember") {
                $_POST['membername'] = $namemember;
            } else {
                $_POST['reg_uid'] = $_SESSION['otp_verified_member'] ?? $neememberid;
                $_POST['demmember'] = $_POST['reg_uid'];
                $_POST['membername'] = $newmember;
                //$_POST['reg_uid'] = $neememberid;

            }
            $subject = $_POST['subject'] ?? [];

            $type = $_POST['type'] ?? [];
            $subjectcount = count(is_array($subject) ? $subject : []);
            $secondsubjectcount = count(is_array($type) ? $type : []);
            $firststsubject = '';
            $studentsecondsubject = '';
            if ($subjectcount == 2) {
                $firststsubject = $subject[0] . ',' . $subject[1];
            }
            if ($subjectcount == 1) {
                $firststsubject = $subject[0];
            }

            if ($secondsubjectcount == 2) {
                $studentsecondsubject = $type[0] . ',' . $type[1];
            }
            if ($secondsubjectcount == 1) {
                $studentsecondsubject = $type[0];
            }
            //$datamember = $_POST['Member_id'];
            //$name=explode("/",$datamember);
            //$oid = $name[0];
            // $membername= $name[1]; 
            $_POST['subject'] = $subject;




            unset($_POST['subject']);
            unset($_POST['type']);

            // pay_date save start.....
            date_default_timezone_set("America/Chicago");
            $today = date("Y/m/d");
            $_POST['pay_date'] = $today;

            //$reg_uid = $StudentModel->getMaxid() + 1;
            //$_POST['reg_uid'] = $reg_uid;
            // $oid= Util::incrementalHash(4);
            // $_POST['oid'] = $oid;
            // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for 
            //pay_date end......

            $id = $StudentModel->getidMax() + 1;
            $_POST['uid'] = $id;


            $_POST['pay_type'] = 'REGISTRATION';
            $regtype =  $_POST['Registration_type'] ?? '';
            if ($regtype == "BanglaSchool") {
                $_POST['pay_for'] = 'BS School';
            } else if ($regtype == "Kalabhavan") {
                $_POST['pay_for'] = 'KB School';
            } else if ($regtype == "workshops") {
                $_POST['pay_for'] = 'Workshops';
            } else if ($regtype == "library") {
                $_POST['pay_for'] = 'Library';
            }

            $data['CreatedOn'] = date("Y-m-d");
            //$id = $StudentModel->save(array_merge($_POST, $data));
            $StudentModel->save(array_merge($_POST, $data));

            if (!empty($id)) {

                if (($_POST['payment_method'] ?? '') == 'others') {

                    $opts = array();
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                    $arr = $ConfirmCodeModel->getAll($opts);
                    $cmCode = $_POST['code'] ?? '';
                    $arr = $ConfirmCodeModel->UpdateCode($cmCode);
                    $_POST['transaction_id'] =  $cmCode;
                    $oid = $_POST['oid'] ?? '';


                    if ($oid !== null) {
                        //if (!empty($arr[0])) {
                        $opts = array();
                        $opts['uid'] = $id;
                        $opts['payment_status'] = 'confirmed';
                        $data = $_POST;
                        $memberid = $_POST['reg_uid'] ?? '';
                        $MemberName = $_POST['membername'] ?? '';
                        $FirstStudentName = $_POST['St_Name1'] ?? '';
                        $SecondStudentName = $_POST['St_Name2'] ?? '';
                        $Amount = $_POST['totalamount'] ?? '';
                        $schoolregirter = $_POST['Registration_type'] ?? '';
                        $datefor = $_POST['pay_date'] ?? '';
                        $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                        $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                        $payment_status = $opts['payment_status'];

                        echo "<div style='margin-left:24em;' class = 'pay'>
                            <table border='4' width='585px'>
                            <tr>
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td></tr>
                            <tr><td>Order Id</td> <td>" . $oid . "</td> </tr>
                            <tr><td>Member Id</td> <td>" . $memberid . "</td> </tr>
                            <tr><td>Member Name</td> <td>" . $MemberName . "</td> </tr>
                            <tr><td>Registration Type</td> <td>" . $schoolregirter . "</td> </tr>
                           <tr><td>First Student Name</td> <td>" . $FirstStudentName . "</td> </tr>
                           <td>First Student Subject</td> <td>" . $firststsubject . "</td> </tr>
                           <td>Second Student Name</td> <td>" . $SecondStudentName . "</td> </tr>
                           <td>Second Student Subject</td> <td>" . $studentsecondsubject . "</td> </tr>
                           <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                           <tr><td>Amount</td> <td>" . $Amount .  "</td> </tr>
                           <tr><td>Pay Date</td> <td>" . $payfinaldate .  "</td> </tr>
                           <tr><td>Payment Status</td> <td>" . $payment_status . "</td>  </tr>
                           </tr>";

                        echo "</table>";
                        echo "</div>";
                        echo "<a  href='" . INSTALL_URL . "Student/create'>Go to home</a>";

                        $this->sendEmailstudent($data, $firststsubject, $studentsecondsubject);
                        $datamemberarr = array();
                        $datamemberarr =  array_merge($opts, $_POST);
                        $StudentModel->update(array_merge($opts, $_POST));
                        $value = array();
                        $value['oid'] = $oid;
                        $value['Member_id'] = $datamemberarr['reg_uid'];
                        $value['MemberName'] = $datamemberarr['membername'];
                        $value['Amount'] = $datamemberarr['totalamount'];
                        $value['PaymentOption'] = $datamemberarr['payment_method'];
                        $value['payment_status'] = 'succeeded';
                        $value['transaction_id'] = $datamemberarr['transaction_id'];
                        $value['update_on'] = $datamemberarr['UpdateOn'];
                        $value['pay_date'] = $datamemberarr['pay_date'];
                        $value['pay_type'] = $datamemberarr['pay_type'];
                        $value['pay_for'] = $datamemberarr['pay_for'];
                        $value['Tele1'] = $datamemberarr['phone_number'];
                        $value['email'] = $datamemberarr['email'];
                        $DonationModel->SaveDataInDonation($value);
                        if ($datamember == null) {
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
                            $value['CreatedOn'] = $_POST['CreatedOn'] ?? '';
                            $value['UpdateOn'] = $_POST['update_on'] ?? '';
                            $value['MemberName'] = $_POST['membername'] ?? '';
                            $value['Amount'] = $_POST['totalamount'] ?? '';
                            $MemberModel->SaveDataInmember($value);
                        }
                        $mobileno = $data['phone_number'];
                        if ($data['phone_number'] != null) {
                            $msg = 'Houston Durga Bari: Student Registration confirmation are Member Id: ' . $data['reg_uid'] . ' , Member Name: ' . $data['membername'] . ', Registration Type: ' . $data['Registration_type'] . ', First Student Name: ' . $data['St_Name1'] . ', First Student Subject: ' . $firststsubject . ' , Second Student Name: ' . $data['St_Name2'] . ', Second Student Subject: ' . $studentsecondsubject . '  , Fee: $' . $data['totalamount'] . ', Pay Date: $' . $payfinaldate . ',  Order Id: ' . $data['oid'] . ', Status: ' . $opts['payment_status'];
                            try { $this->SendSMS($mobileno, $msg); } catch (Exception $e) { /* SMS failed, continue */ }
                        }
                        $_SESSION['StudentPaymentProcessed'] = true;
                        exit();
                    }
                } elseif (($_POST['payment_method'] ?? '') == 'stripe') {

                    // switch ($_POST['fee']) {
                    //     case '1':
                    //         $amount = $this->tpl['option_arr_values']['student_annual'];
                    //         break;
                    //     case '2':
                    //         $amount = $this->tpl['option_arr_values']['student_semester'];
                    //         break;
                    //     case '3':
                    //             $amount = $this->tpl['option_arr_values']['student_annualprice'];
                    //             break;

                    //     case '4':
                    //             $amount = $this->tpl['option_arr_values']['spring'];
                    //             break;

                    //       case '5':
                    //              $amount = $this->tpl['option_arr_values']['springprice'];
                    //             break;

                    //       case '6':
                    //              $amount = $this->tpl['option_arr_values']['Fall'];
                    //             break;

                    //       case '7':
                    //               $amount = $this->tpl['option_arr_values']['Fallprice'];
                    //             break;


                    // }

                    //  if(($firstsubject !=null &&  $secondsubject!=null) && ($newfirstsubject !=null &&  $newsecondsubject!=null)){
                    //     $amount = count($subject)*$amount + count($type)*$amount;
                    //     $totalprice = $amount - 20;

                    //     }
                    //    elseif(($firstsubject !=null &&  $secondsubject!=null) && ($newfirstsubject ==null &&  $newsecondsubject ==null)){
                    //     $amount = count($subject) * $amount;
                    //     $totalprice = $amount - 10;
                    //    }
                    //    elseif(($firstsubject !=null &&  $secondsubject!=null) && ($newfirstsubject !=null &&  $newsecondsubject ==null)){
                    //     $amount = count($subject)*$amount + count($type)*$amount;
                    //     $totalprice = $amount - 10;
                    //    }
                    //    elseif(($firstsubject !=null &&  $secondsubject==null) && ($newfirstsubject !=null &&  $newsecondsubject !=null)){
                    //     $amount = count($subject)*$amount + count($type)*$amount;
                    //     $totalprice = $amount - 10;
                    //    } else {
                    //     $amount = count($subject)*$amount + count($type)*$amount;
                    //     $totalprice = $amount;
                    //     }

                    //     $total = $totalprice;
                    // $amount = count($subject)*$amount + count($type)*$amount;
                    $amount = $_POST['totalamount'] ?? '';
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
                        //$amount = round($total * 100);

                        $payment = Stripe_Charge::create(array(
                            "amount" => $amount,
                            "currency" => $this->tpl["option_arr_values"]["currency"],
                            "card" => $_POST['stripeToken'],
                            "description" =>  "Pay For:" . ($_POST['pay_for'] ?? '') . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Student 1 Name:" . ($_POST['St_Name1'] ?? '') . ',' . "Student 2 Name:" . ($_POST['St_Name2'] ?? ''),
                            "metadata" => ["orderid" => $oid]
                        ));

                        $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                        $this->tpl['payment']['amount'] = $payment->amount;
                        $this->tpl['payment']['status'] = $payment->status;
                        $this->tpl['payment']['currency'] = $payment->currency;



                        if ($payment->status == 'succeeded') {

                            unset($_POST['amount']);

                            $opts = array();
                            $opts['uid'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            $opts['payment_status'] = 'confirmed';
                            $opts['payment_timestamp'] = time();
                            $data = $_POST;
                            $this->sendEmailstudent($data, $firststsubject, $studentsecondsubject);
                            $datamemberarr = array();
                            $datamemberarr =  array_merge($opts, $_POST);
                            $StudentModel->update(array_merge($opts, $_POST));
                            $value = array();
                            $value['oid'] = $oid;
                            $value['Member_id'] = $datamemberarr['reg_uid'];
                            $value['MemberName'] = $datamemberarr['membername'];
                            $value['Amount'] = $datamemberarr['totalamount'];
                            $value['PaymentOption'] = $datamemberarr['payment_method'];
                            $value['payment_status'] = 'succeeded';
                            $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                            $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                            $value['transaction_id'] = $datamemberarr['transaction_id'];
                            $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                            $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                            $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                            $value['pay_date'] = $datamemberarr['pay_date'];
                            $value['pay_type'] = $datamemberarr['pay_type'];
                            $value['pay_for'] = $datamemberarr['pay_for'];
                            $value['Tele1'] = $datamemberarr['phone_number'];
                            $value['email'] = $datamemberarr['email'];
                            $DonationModel->SaveDataInDonation($value);
                            if ($datamember == null) {
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
                                $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                                $value['stripe_return'] = $opts['stripe_return'] ?? '';
                                $value['transaction_id'] = $opts['transaction_id'];
                                $value['paid_amount'] = $opts['paid_amount'] ?? '';
                                $value['stripe_product'] = $opts['stripe_product'] ?? '';
                                $value['Tele1'] = $_POST['phone_number'] ?? '';
                                $value['email'] = $_POST['email'] ?? '';
                                $value['Member_id'] = $_POST['reg_uid'] ?? '';
                                $value['pay_date'] = $_POST['pay_date'] ?? '';
                                $value['cc_name'] = $_POST['cc_name'] ?? '';
                                $value['remarks'] = $_POST['remarks'] ?? '';
                                $value['oid'] = $_POST['oid'] ?? '';
                                $value['pay_type'] = $_POST['pay_type'] ?? '';
                                $value['pay_for'] = $_POST['pay_for'] ?? '';
                                $value['CreatedOn'] = $_POST['CreatedOn'] ?? '';
                                $value['UpdateOn'] = $_POST['update_on'] ?? '';
                                $value['MemberName'] = $_POST['membername'] ?? '';
                                $value['Amount'] = $_POST['totalamount'] ?? '';
                                $MemberModel->SaveDataInmember($value);
                            }

                            $mobileno = $data['phone_number'];
                            if ($data['phone_number'] != null) {
                                $msg = 'Houston Durga Bari: Student Registration confirmation are Member Id: ' . $data['reg_uid'] . ' , Member Name: ' . $data['membername'] . ', Registration Type: ' . $data['Registration_type'] . ', First Student Name: ' . $data['St_Name1'] . ', First Student Subject: ' . $firststsubject . ' , Second Student Name: ' . $data['St_Name2'] . ', Second Student Subject: ' . $studentsecondsubject . '  , Fee: $' . $data['totalamount'] . ',  Order Id: ' . $data['oid'] . ', Status: ' . $opts['payment_status'];
                                try { $this->SendSMS($mobileno, $msg); } catch (Exception $e) { /* SMS failed, continue */ }
                            }

                            $this->tpl['arr'] = $StudentModel->get($id);
                            $_SESSION['StudentPaymentProcessed'] = true;
                        } else {

                            $opts = array();
                            $opts['uid'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;

                            $StudentModel->update($opts);

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                        }
                    } catch (Exception $ex) {
                        $_SESSION['status'] = $ex->getMessage();
                    }

                    $this->tpl['arr'] = $StudentModel->get($id);
                    if (is_array($this->tpl['arr'])) {
                        $this->tpl['arr']['amount'] = $total;
                    }
                } else {
                    $_SESSION['status'] = 16;
                    Util::redirect(INSTALL_URL . "Student/index");
                }
            } else {
                $_SESSION['status'] = 17;

                Util::redirect(INSTALL_URL . "Student/index");
            }
        }
    }

    function edit()
    {
        GzObject::loadFiles('Model', array('Student', 'Member'));
        $StudentModel = new StudentModel();
        $MemberModel = new MemberModel();


        $this->tpl['members'] = $MemberModel->getAll();

        if (!$this->isAdmin() && ($_REQUEST['id'] ?? '') != $this->getUserId()) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }

        if (!empty($_POST['edit_Student'])) {

            $data = array();

            $id = $_POST['uid'] ?? '';



            $data['subject'] = serialize($_POST['subject'] ?? []);
            $data['type'] = serialize($_POST['type'] ?? []);
            unset($_POST['subject']);
            unset($_POST['type']);
            $id = $this->Updatestudent(array_merge($_POST));
            //$id = $StudentModel->update(array_merge($data, $_POST));
            // $id = $StudentModel->Updatestudent(array_merge($data, $_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "Student/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $arr = $StudentModel->get($id);

        $this->tpl['arr'] = $arr;
    }
    public function Updatestudent($POST)
    {
        GzObject::loadFiles('Model', array('Student'));
        $StudentModel = new StudentModel();
        $id = $POST['uid'];
        $stname = $POST['St_Name1'];
        $secondstudent = $POST['St_Name2'];
        $email = $POST['email'];
        $phonenumber = $POST['phone_number'];

        $sql = 'UPDATE students SET St_Name1="' . "$stname" . '",St_Name2="' . "$secondstudent" . '",email="' . "$email" . '",phone_number="' . "$phonenumber" . '" WHERE uid="' . "$id" . '"';

        $result = array();
        $arr = $StudentModel->execute($sql);

        return $id;
    }

    function index()
    {
        $this->js[] = array('file' => 'GzStudent.js?v=' . time(), 'path' => JS_PATH);
        GzObject::loadFiles('Model', array('Student'));
        $StudentModel = new StudentModel();


        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }




        if (!empty($_POST['uid'])) {
            $opts['uid LIKE :uid'] = array(':uid' => "%" . ($_POST['uid'] ?? '') . "%");
        }
        if (!empty($_POST['St_Name1'])) {
            $opts['St_Name1 LIKE :St_Name1'] = array(':St_Name1' => "%" . ($_POST['St_Name1'] ?? '') . "%");
        }
        if (!empty($_POST['St_Name2'])) {
            $opts['St_Name2 LIKE :St_Name2'] = array(':St_Name2' => "%" . ($_POST['St_Name2'] ?? '') . "%");
        }
        if (!empty($_POST['session'])) {
            $opts['session LIKE :session'] = array(':session' => "%" . ($_POST['session'] ?? '') . "%");
        }

        if (!empty($_POST['school'])) {
            $opts['school LIKE :school'] = array(':school' => "%" . ($_POST['school'] ?? '') . "%");
        }
        if (!empty($_POST['Email'])) {
            $opts['subject LIKE :subject'] = array(':subject' => "%" . ($_POST['subject'] ?? '') . "%");
        }

        $opts = array();

        //$arr = $StudentModel->getAll(array_merge($opts));
        $arr = $StudentModel->studentAll(array_merge($opts));

        $this->tpl['arr'] = $arr;
    }

    function delete()
    {
        $this->isAjax = true;

        $id = $_REQUEST['id'] ?? '';

        GzObject::loadFiles('Model', array('Student'));
        $StudentModel = new StudentModel();

        $StudentModel->deleteFrom($StudentModel->getTable())
            ->where('uid', $id)->execute();

        $opts = array();
        Util::redirect(INSTALL_URL . "Student/index");
        // $arr = $StudentModel->getAll($opts);
        //  $this->tpl['arr'] = $arr;
    }


    function deleteSelected()
    {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('User'));
        $UserModel = new BookingModel();

        if (!empty($_POST['mark'])) {

            $UserModel->deleteFrom($UserModel->getTable())
                ->where('id', $_POST['mark'] ?? '')->execute();
        }

        $arr = $UserModel->getAll();

        $this->tpl['arr'] = $arr;
    }
    function export()
    {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Student'));
        $StudentModel = new StudentModel();
        //$BookingSlotModel = new BookingSlotModel();

        $output = "";

        $query = $StudentModel->from($StudentModel->getTable());

        $students = $query->fetchAll();

        if (empty($students)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

        foreach ($students[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($students as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'];
            $slots = $StudentModel->getAll($opts);

            foreach ($value as $k => $v) {
                if ($k == 'date') {
                    $output .= '"' . date("Y-m-d H:i", $v) . '",';
                } else {
                    $output .= '"' . $v . '",';
                }
            }
            // foreach($slots as $slot){
            //     foreach($slot as $k => $s){
            //         if($k != 'id' && $k != 'calendar_id' && $k != 'booking_id'){
            //             if($k == 'timestamp'){
            //                 $output .='"' . date("Y-m-d H:i", $s) . '",';
            //             }else{
            //                 $output .='"' . $s . '",';
            //             }
            //         }
            //     }
            // }
            $output .= "\n";
        }

        $filename = "student" . time() . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }
}


