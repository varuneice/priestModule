<?php

require_once CONTROLLERS_PATH . 'App.php';

class Member extends App {

    var $layout = 'admin';
    var $option_arr = null;

    function beforeFilter() {

        GzObject::loadFiles('Model', 'Option','Member');
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

        if ($this->isMember() && ($_REQUEST['action'] ?? '') != 'pay' && ($_REQUEST['action'] ?? '') != 'calculatePrice' && ($_REQUEST['action'] ?? '') != 'checkout' && ($_REQUEST['action'] ?? '') != 'create') {
            GzObject::loadFiles('Model', array('Member'));
            $MemberModel = new MemberModel();

            $user = $this->getUser();

            $member = $MemberModel->get($user['ID']);

            if ($member['payment_status'] != 'confirmed' || $member['status'] == 'E') {
                Util::redirect(INSTALL_URL . "Member/pay");
            }

            $this->tpl['member'] = $member;
        }

       
        
        
        if ($this->isAdmin()){
        if ((!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login' && ($_REQUEST['action'] ?? '') != 'calculatePrice') || (!$this->isAdmin() && !in_array(($_REQUEST['action'] ?? ''), array('edit', 'pay', 'calculatePrice', 'checkout','index')))) {

             if(($_REQUEST['action'] ?? '') != 'create' && ($_REQUEST['action'] ?? '') != 'details' && ($_REQUEST['action'] ?? '') != 'membermaintenance' && ($_REQUEST['action'] ?? '') != 'memberedit' && ($_REQUEST['action'] ?? '') != 'memberlookup' && ($_REQUEST['action'] ?? '') != 'memberphone' && ($_REQUEST['action'] ?? '') != 'Membercheck'){
               
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }
    }
        if ($this->isRegistration()){
        if ((!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login' && ($_REQUEST['action'] ?? '') != 'calculatePrice') || (!$this->isRegistration() && !in_array(($_REQUEST['action'] ?? ''), array('edit', 'pay', 'calculatePrice', 'checkout','index')))) {

            if(($_REQUEST['action'] ?? '') != 'create' && ($_REQUEST['action'] ?? '') != 'details' && ($_REQUEST['action'] ?? '') != 'membermaintenance' && ($_REQUEST['action'] ?? '') != 'memberedit' && ($_REQUEST['action'] ?? '') != 'memberlookup' && ($_REQUEST['action'] ?? '') != 'memberphone' && ($_REQUEST['action'] ?? '') != 'Membercheck'){
              
               $_SESSION['err'] = 2;
               Util::redirect(INSTALL_URL . "Admin/login");
           }
       }
    }
   

    if ($this->isRental()){
        if ((!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login' && ($_REQUEST['action'] ?? '') != 'calculatePrice') || (!$this->isRental() && !in_array(($_REQUEST['action'] ?? ''), array('edit', 'pay', 'calculatePrice', 'checkout','index')))) {

            if(($_REQUEST['action'] ?? '') != 'create' && ($_REQUEST['action'] ?? '') != 'details' && ($_REQUEST['action'] ?? '') != 'membermaintenance' && ($_REQUEST['action'] ?? '') != 'memberedit' && ($_REQUEST['action'] ?? '') != 'memberlookup' && ($_REQUEST['action'] ?? '') != 'memberphone' && ($_REQUEST['action'] ?? '') != 'Membercheck'){
              
               $_SESSION['err'] = 2;
               Util::redirect(INSTALL_URL . "Admin/login");
           }
       }
    }
    
    if ($this->isEvents()){
        if ((!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login' && ($_REQUEST['action'] ?? '') != 'calculatePrice') || (!$this->isEvents() && !in_array(($_REQUEST['action'] ?? ''), array('edit', 'pay', 'calculatePrice', 'checkout','index')))) {

            if(($_REQUEST['action'] ?? '') != 'create' && ($_REQUEST['action'] ?? '') != 'details' && ($_REQUEST['action'] ?? '') != 'membermaintenance' && ($_REQUEST['action'] ?? '') != 'memberedit' && ($_REQUEST['action'] ?? '') != 'memberlookup' && ($_REQUEST['action'] ?? '') != 'memberphone' && ($_REQUEST['action'] ?? '') != 'Membercheck'){
              
               $_SESSION['err'] = 2;
               Util::redirect(INSTALL_URL . "Admin/login");
           }
       }
    }

    if ($this->isEducation()){
        if ((!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login' && ($_REQUEST['action'] ?? '') != 'calculatePrice') || (!$this->isEducation() && !in_array(($_REQUEST['action'] ?? ''), array('edit', 'pay', 'calculatePrice', 'checkout','index')))) {

            if(($_REQUEST['action'] ?? '') != 'create' && ($_REQUEST['action'] ?? '') != 'details' && ($_REQUEST['action'] ?? '') != 'membermaintenance' && ($_REQUEST['action'] ?? '') != 'memberedit' && ($_REQUEST['action'] ?? '') != 'memberlookup' && ($_REQUEST['action'] ?? '') != 'memberphone' && ($_REQUEST['action'] ?? '') != 'Membercheck'){
              
               $_SESSION['err'] = 2;
               Util::redirect(INSTALL_URL . "Admin/login");
           }
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

        // For search dropdown search box 
         $this->css[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/css/bootstrap-select.min.css', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/js/bootstrap-select.min.js', 'path' => JS_PATH);
        
        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);

        if (($_REQUEST['action'] ?? '') == 'pay') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        }
        if (($_REQUEST['action'] ?? '') == 'edit') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        }
        if (($_REQUEST['action'] ?? '') == 'create') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        }
         if (($_REQUEST['action'] ?? '') == 'memberedit') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        }
         if (($_REQUEST['action'] ?? '') == 'membermaintenance') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        }
        if (($_REQUEST['action'] ?? '') == 'memberlookup') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
            $this->js[] = array('file' => 'otp-member-verify.js?v=' . time(), 'path' => JS_PATH);
            $this->js[] = array('file' => 'GzMember.js?v=' . time(), 'path' => JS_PATH);
        } else {
            $this->js[] = array('file' => 'GzMember.js?v=' . time(), 'path' => JS_PATH);
        }
      
        $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
    }
    
    function details() {
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();
        
        $ID = $_GET['id'] ?? '';
        
        $this->tpl['arr'] = $MemberModel->get($ID);
    }
    
    
    function getmemberfirstnamelastname()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();
        $MemberId = $_POST['MemberId'] ?? '';
        $test = $MemberModel->getMemberF_name($MemberId);
    }


     function membercheck()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();
        $email = $_POST['email'] ?? '';
        $MemberModel->Membercheck($email);
    }

    // function memberlookup()
    // {
    //  }

    function memberphone()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();
        $Tele = $_POST['Tele1'] ?? '';
        $MemberModel->memberphone($Tele);
    }
    
    private function getExpiredStatusFromMember($member)
    {
        $firstLate = (($member['FirstSal'] ?? '') == 'Late');
        $spouseLate = (($member['SpouseSal'] ?? '') == 'Late');

        if ($firstLate && $spouseLate) {
            return 'both';
        }
        if ($firstLate) {
            return 'member';
        }
        if ($spouseLate) {
            return 'spouse';
        }
        return '';
    }

    private function getExpiredLogStatus($expiredStatus)
    {
        switch ($expiredStatus) {
            case 'member':
                return 'Firste';
            case 'spouse':
                return 'Spe';
            case 'both':
                return 'E';
            case '':
                return 'ExpiredCleared';
            default:
                return '';
        }
    }

    private function applyExpiredStatusSelection()
    {
        if (!array_key_exists('expired_status', $_POST)) {
            return null;
        }

        $expiredStatus = $_POST['expired_status'];
        if (!in_array($expiredStatus, array('', 'member', 'spouse', 'both'), true)) {
            $expiredStatus = '';
        }

        $_POST['FirstSal'] = '';
        $_POST['SpouseSal'] = '';

        if ($expiredStatus == 'member' || $expiredStatus == 'both') {
            $_POST['FirstSal'] = 'Late';
        }

        if ($expiredStatus == 'spouse' || $expiredStatus == 'both') {
            $_POST['SpouseSal'] = 'Late';
        }

        if ($expiredStatus == 'both') {
            $_POST['status'] = 'E';
        } elseif (($_POST['status'] ?? '') == 'E') {
            $_POST['status'] = 'T';
        }

        unset($_POST['expired_status']);
        return $expiredStatus;
    }

    private function logExpiredStatusChange($MemberLogModel, $oldExpiredStatus, $newExpiredStatus)
    {
        if ($newExpiredStatus === null || $oldExpiredStatus === $newExpiredStatus) {
            return;
        }

        $status = $this->getExpiredLogStatus($newExpiredStatus);
        if ($status === '') {
            return;
        }

        $logData = array();
        $logData['Category'] = $_POST['membercategory'] ?? ($_POST['Category'] ?? '');
        $logData['member_id'] = $_POST['Member_id'] ?? ($_POST['dataid'] ?? '');
        $logData['Createdon'] = date('Y-m-d H:i:s');
        $logData['Updatedby'] = $this->isMember() ? (string)(int)$this->getMemberId() : (string)(int)($this->getUserId() ?: 0);
        $logData['Status'] = $status;
        $MemberLogModel->save($logData);
    }

    function create() {
        GzObject::loadFiles('Model', array('Member', 'Country', 'nextmid', 'ConfirmCode', 'idnumbers', 'Donation', 'MemberLog'));
        $MemberModel = new MemberModel();
        $CountryModel = new CountryModel();
        $nextmidModel = new nextmidModel();
        $arr= $CountryModel->getCountry();
		$ConfirmCodeModel = new ConfirmCodeModel();
		$idnumbersModel = new idnumbersModel();
        $DonationModel = new DonationModel();
        $MemberLogModel = new MemberLogModel();
        $this->tpl['Country'] =  $arr;

        $logFile = sys_get_temp_dir() . '/member_create_debug.log';
        $log = function($msg) use ($logFile) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . ' ' . $msg . PHP_EOL, FILE_APPEND);
        };

        if (!empty($_POST['create_member']) ) {
            $log('STEP1: create_member POST received. Payment_method=' . ($_POST['Payment_method'] ?? 'N/A') . ' rate=' . ($_POST['rate'] ?? 'N/A') . ' total=' . ($_POST['total'] ?? 'N/A'));
            $data = array();
              // $data['Application_date'] = date('Y-m-d H:i:s');
            // $StartingDate =date('Y');
            // $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
            // $renew = $newEndingDate."-"."03"."-"."31";
            // $total =$_POST['total'] ?? 0;
            // if($total=="3000"){
            //     $data['Renew_date'] = "9999-12-31";
            // }else{
            //     $data['Renew_date'] = $renew;
            // }
            
            if (!empty($_FILES['img'])) {


                require_once APP_PATH . 'helpers/uploader/class.upload.php';

               $files = array_filter($_FILES['img']['name']);
               $total_count = count($_FILES['img']['name']);
               $str = '';
                if(!empty(array_filter($_FILES['img']['name']))) {
                    foreach ($_FILES['img']['tmp_name'] as $key => $value) { 
                        $name = $_FILES['img']['name'][$key];
                        $type = $_FILES['img']['type'][$key];
                        $tmp_name = $_FILES['img']['tmp_name'][$key];
                        $error = $_FILES['img']['error'][$key];
                        $size = $_FILES['img']['size'][$key];
                        $img = array("name" => $name, "type" => $type, "tmp_name" => $tmp_name, "error" => $error,  "size" => $size);

                    $handle = new upload($img);
                    $img_name = time();

                        if ($handle->uploaded) {

                            $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

                            $handle->file_new_name_body = $img_name;
                            $handle->image_resize = true;
                            $handle->image_x = 200;
                            $handle->image_ratio_y = true;
                            $handle->allowed = array('image/*');
                            $handle->process($thumb_dest);

                            if ($handle->processed) {
                                $handle->clean();
                            } else {
                                echo 'error : ' . $handle->error;
                            } 
                            $imgname = $handle->file_dst_name;
                            $str .= $imgname;
                            $str .= ' / ';
                            $data['avatar'] = $str;

                        }
                    }
                }
            }
            
            if (($_POST['status'] ?? '') == 'T') {
               $pasword = Util::incrementalHash(10);
               $data['password'] = md5($pasword);
           }
            
            switch($_POST['rate'] ?? ''){
                case 'gmi_1':
                    $data['Category'] = 'GD';
                    break;
                case 'gmi_4':
                    $data['Category'] = 'GD';
                    break;
                case 'gmf_1':
                    $data['Category'] = 'GD';
                    break;
                case 'gmf_4':
                    $data['Category'] = 'GD';
                    break;
                case 'lm':
                    $data['Category'] = 'LM';
                    break;
                case 'bf':
                    $data['Category'] = 'BF';
                    break;
                case 'pm':
                    $data['Category'] = 'CT';
                    break;
                case 'lm_h':
                    $data['Category'] = 'LM';
                    break;
            }
           
           // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            //$_POST['oid'] = $maxoid;
            $oid= $maxoid;
        // end generate oid for
           
           
            if(empty($_POST['status'])){
               //previous default status pending
                $_POST['status'] = 'F';
            }
            $ID = $MemberModel->getMaxid() + 1;
            $data['ID'] = $ID;
            $data['Member_id'] = 0;

            // Clean INT fields — non-numeric strings rejected by MySQL strict mode
            foreach (['Age1', 'Age2', 'Age3', 'Age4', 'Mob_No'] as $intField) {
                if (isset($_POST[$intField]) && !is_numeric($_POST[$intField])) {
                    $_POST[$intField] = null;
                }
            }

            // Clean DATE fields — empty string rejected by MySQL strict mode
            foreach (['Renew_date', 'pay_date'] as $dateField) {
                if (isset($_POST[$dateField]) && $_POST[$dateField] === '') {
                    $_POST[$dateField] = null;
                }
            }

            // Clean FLOAT fields — empty string rejected by MySQL strict mode
            foreach (['amount', 'donation', 'total'] as $floatField) {
                if (isset($_POST[$floatField]) && $_POST[$floatField] === '') {
                    $_POST[$floatField] = null;
                }
            }

            // Ensure NOT NULL varchar fields with no DB default are always present
            if (!isset($_POST['FirstSal']))  { $_POST['FirstSal']  = ''; }
            if (!isset($_POST['SpouseSal'])) { $_POST['SpouseSal'] = ''; }

            $log('STEP2: Attempting membersave. ID=' . $ID . ' Member_id=0 Category=' . ($data['Category'] ?? 'N/A'));

           // $ID = $MemberModel->save(array_merge($_POST, $data));
             $check = $MemberModel->membersave(array_merge($_POST, $data));
            $log('STEP3: membersave result=' . ($check ? 'true' : 'false'));
              if ($check == true) {
            $log('STEP4: check=true, entering payment flow. Payment_method=' . ($_POST['Payment_method'] ?? 'N/A'));
			if (($_POST['Payment_method'] ?? '') == 'others') {
                $log('STEP4a: Payment method = others (Zelle)');

                $opts = array();
                $cmCode=$_POST['code'] ?? '';
                $arr= $ConfirmCodeModel->UpdateCode($cmCode);
                $_POST['transaction_id'] =  $cmCode;
                $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                $arr = $ConfirmCodeModel->getAll($opts);

                if ($oid !=null) {
                    $opts = array();
                    //$opts['id'] = $id;
                    $opts['ID'] = $ID;
                    $opts['payment_status'] = 'confirmed';
                     date_default_timezone_set("America/Chicago");
                     $today = date("Y/m/d");
                    $_POST['pay_date']= $today;
                    $_POST['pay_type']= 'REGISTRATION';
                    $_POST['pay_for'] = 'New Membership';
                   // $this->sendEmailmember($data, $opts);
                   $datamemberarr = array();
                   $datamemberarr =  array_merge($opts, $_POST);
                   $MemberModel->update(array_merge($opts, $_POST));
                   $value = array();
                        $value['oid'] = $oid;
                        $value['Category'] = $datamemberarr['Category'] ?? '';
                        $value['MemberName'] = ($datamemberarr['F_Name'] ?? '').($datamemberarr['M_Name'] ?? '').($datamemberarr['L_Name'] ?? '');
                        $value['Amount'] = $datamemberarr['total'] ?? '';
                        $value['PaymentOption'] = $datamemberarr['Payment_method'] ?? '';
                        $value['payment_status'] = 'succeeded';
                        $value['transaction_id'] = $datamemberarr['transaction_id'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'] ?? '';
                        $value['Address'] = $datamemberarr['Address2'] ?? '';
                        $value['Street'] = $datamemberarr['Address1'] ?? '';
                        $value['State'] = $datamemberarr['State'] ?? '';
                        $value['Zip_Code'] = $datamemberarr['Zip'] ?? '';
                        $value['Tele1'] = $datamemberarr['Tele1'] ?? '';
                        $value['email'] = $datamemberarr['email'] ?? '';
                        $value['City'] = $datamemberarr['City'] ?? '';
                        $value['spousename'] = ($datamemberarr['Sp_FName'] ?? '').($datamemberarr['Sp_LName'] ?? '');
                        $DonationModel->SaveDataInDonation($value);
						$this->sendEmailmember($datamemberarr, $oid);
                    //$MemberModel->update($opts);
                         $email =  $_POST['email'] ?? '';
						 $mobile = $_POST['Tele1'] ?? '';
                         $membershiptype = $_POST['membership_type'] ?? '';
                         if($membershiptype == 'IND'){
                            $membertype = 'Individual Membership';
                           }
                           else{
                               $membertype =  'Family Membership';
                           }
                        echo "<div style='margin-left:23em;' class = 'pay'>
                            <table border='4'  width='598px' style='margin-left:4em;'>
                            <tr>
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                            <tr>
                            <td colspan='2'><b>Your membership request have been submitted.
                                Membership details will be shared with you after approval.
                                For more details please contact to<a href='mailto:treasurer@durgabari.org'> treasurer@durgabari.org</a></b></td></tr>
                              <tr>
                              <tr><td>Order Id</td> <td>" .$oid.  "</td> </tr>
                            <tr>
                           <td>Member Name</td> <td>" .($_POST['F_Name'] ?? '').' ' .($_POST['M_Name'] ?? '').' ' .($_POST['L_Name'] ?? ''). "</td> </tr>
                           <tr><td>Member Email Address</td> <td>" .$email.  "</td> </tr>
                           <tr><td>Member Phone Number</td> <td>" .$mobile. "</td>  </tr>
                           <tr><td>Membership Type</td> <td>" . $membertype. "</td>  </tr>
                           <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                           </tr>";
                           echo "</table>";
                           echo "</div>";	
                         $membershiptype = $datamemberarr['membership_type'] ?? '';
                            if($membershiptype == 'IND'){
                            $membertype = 'Individual Membership';
                            }
                            else{
                                $membertype =  'Family Membership';
                            }
                            $mobileno = $datamemberarr['Tele1'] ?? '';
                            if (!empty($mobileno)) {
                                $msg = 'Houston DurgaBari: New Member Registration are  Member Name: '. ($datamemberarr['F_Name'] ?? '').' '.  ($datamemberarr['M_Name'] ?? ''). ' '.  ($datamemberarr['L_Name'] ?? ''). ' , Email: '.  ($datamemberarr['email'] ?? ''). ', Amount: $'. ($datamemberarr['total'] ?? '').', Membership Type: '. $membertype.', Order Id: '. $oid.', Status: ' . ($datamemberarr['payment_status'] ?? '')  ;
                                try { $this->SendSMS($mobileno, $msg); } catch (Exception $e) { /* SMS failed, continue */ }
                              }
                    $data = array();
                    $data['rate'] = $_POST['rate'] ?? '';

                    switch($_POST['rate'] ?? ''){
                        case 'gmi_1':
                            $data['Category'] = 'GD';
                            break;
                        case 'gmi_4':
                            $data['Category'] = 'GD';
                            break;
                        case 'gmf_1':
                            $data['Category'] = 'GD';
                            break;
                        case 'gmf_4':
                            $data['Category'] = 'GD';
                            break;
                        case 'lm':
                            $data['Category'] = 'LM';
                            break;
                        case 'bf':
                            $data['Category'] = 'BF';
                            break;
                        case 'pm':
                            $data['Category'] = 'CT';
                            break;
                        case 'lm_h':
                            $data['Category'] = 'LM';
                            break;
                    }
                    $data['Createdon'] = date('Y-m-d H:i:s');

                    if($this->isMember()){
                        $data['Updatedby'] = $this->getMemberId();
                    }else{
                        $data['Updatedby'] = $this->getUserId();
                    }

                    $data['Status'] = 'P';

                    $MemberLogModel->save($data);
                }
            }elseif (($_POST['Payment_method'] ?? '') == 'stripe') {
                $log('STEP4b: Payment method = stripe');
                $price = $this->calculateMemberPrice();
                $log('STEP5: calculateMemberPrice total=' . ($price['total'] ?? 'N/A'));
                $amount = $price['total'];
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                    $_POST['pay_date']= $today;
                    $_POST['pay_type']= 'REGISTRATION';
                    $_POST['pay_for'] = 'New Membership';
                //$total = $amount;
                require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                $error = '';
                $success = '';

                Stripe::setApiKey($this->tpl["option_arr_values"]["stripe_api_key"]);

                try {
                    if (!isset($_POST['stripeToken'])) {
                        $log('STEP6_ERR: stripeToken not set');
                        throw new Exception("The Stripe Token was not generated correctly");
                    }
                    $log('STEP6: Stripe charge starting. amount_cents=' . round($amount * 100));
                    $amount = round($amount * 100);

                    $payment = Stripe_Charge::create(array(
                                "amount" => $amount,
                                "currency" => $this->tpl["option_arr_values"]["currency"],
                                "card" => $_POST['stripeToken'],
                                //"description" => $_POST['email'] . ', ' . ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? ''),
                                "description" =>  "Pay For:".($_POST['pay_for'] ?? ''). ', ' ."Email:".($_POST['email'] ?? '') . ', ' ."Full Name:". ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? ''),
                                "metadata" => ["orderid" => $oid]
                    ));

                    $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                    $this->tpl['payment']['amount'] = $payment->amount;
                    $this->tpl['payment']['status'] = $payment->status;
                    $this->tpl['payment']['currency'] = $payment->currency;
                    $log('STEP7: Stripe response status=' . ($payment->status ?? 'N/A'));

                    if ($payment->status == 'succeeded') {
                        $log('STEP8: Stripe succeeded. Updating member record.');
                        //$ID = $MemberModel->getid($idm);
                        // $StartingDate =date('Y');
                        //  $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                        //  $renew = $newEndingDate."-"."03"."-"."31";
                         $total =$_POST['total'] ?? 0;
                         //$opts['id'] = $id;
                         $opts['ID'] = $ID;
                        //  if($total=="3000"){
                        //         $opts['Renew_date'] = "9999-12-31";
                        //     }else{
                        //         $opts['Renew_date'] = $renew;
                        //     }
                           // $MemberModel->update($opts);
                        unset($_POST['amount']);

                        $opts = array();
                        //$opts['id'] = $id;
                        $opts['ID'] = $ID;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['donation'] = $_POST['donation'] ?? 0;
                        
                        $opts['amount'] = $price['total'] - (float)($_POST['donation'] ?? 0);
                        $opts['total'] = $price['total'];
                        $opts['stripe_product'] = $payment->description;
                        $opts['payment_status'] = 'confirmed';
                        $opts['payment_timestamp'] = time();
                        
                        switch($_POST['rate'] ?? ''){
                            case 'gmi_1':
                                $opts['Category'] = 'GD';
                                break;
                            case 'gmi_4':
                                $opts['Category'] = 'GD';
                                break;
                            case 'gmf_1':
                                $opts['Category'] = 'GD';
                                break;
                            case 'gmf_4':
                                $opts['Category'] = 'GD';
                                break;
                            case 'lm':
                                $opts['Category'] = 'LM';
                                break;
                            case 'bf':
                                $opts['Category'] = 'BF';
                                break;
                            case 'pm':
                                $opts['Category'] = 'CT';
                                break;
                            case 'lm_h':
                                $opts['Category'] = 'LM';
                                break;
                        }
                        $datamemberarr = array();
                        $datamemberarr =  array_merge($opts, $_POST) ;
                        $MemberModel->update(array_merge($opts, $_POST));
                        
                         $value = array();
                        $value['oid'] = $oid;
                        $value['Category'] = $datamemberarr['Category'] ?? '';
                        $value['MemberName'] = ($datamemberarr['F_Name'] ?? '').($datamemberarr['M_Name'] ?? '').($datamemberarr['L_Name'] ?? '');
                        $value['Amount'] = $datamemberarr['total'] ?? '';
                        $value['PaymentOption'] = $datamemberarr['Payment_method'] ?? '';
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $datamemberarr['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $datamemberarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $datamemberarr['transaction_id'] ?? '';
                        $value['paid_amount'] = $datamemberarr['paid_amount'] ?? '';
                        $value['update_on'] = $datamemberarr['UpdateOn'] ?? '';
                        $value['stripe_product'] = $datamemberarr['stripe_product'] ?? '';
                        $value['pay_date'] = $datamemberarr['pay_date'] ?? '';
                        $value['pay_type'] = $datamemberarr['pay_type'] ?? '';
                        $value['pay_for'] = $datamemberarr['pay_for'] ?? '';
                        $value['Address'] = $datamemberarr['Address2'] ?? '';
                        $value['Street'] = $datamemberarr['Address1'] ?? '';
                        $value['State'] = $datamemberarr['State'] ?? '';
                        $value['Zip_Code'] = $datamemberarr['Zip'] ?? '';
                        $value['Tele1'] = $datamemberarr['Tele1'] ?? '';
                        $value['email'] = $datamemberarr['email'] ?? '';
                        $value['City'] = $datamemberarr['City'] ?? '';
                        $value['spousename'] = ($datamemberarr['Sp_FName'] ?? '').($datamemberarr['Sp_LName'] ?? '');
                        $DonationModel->SaveDataInDonation($value);
                       $this->sendEmailmember($datamemberarr, $oid);
                       $membershiptype = $datamemberarr['membership_type'] ?? '';
                       if($membershiptype == 'IND'){
                        $membertype = 'Individual Membership';
                       }
                       else{
                           $membertype = 'Family Membership';
                       }
                        $mobileno = $datamemberarr['Tele1'] ?? '';
                        if (!empty($mobileno)) {
                           $msg = 'Houston DurgaBari: New Member Registration are  Member Name: '. ($datamemberarr['F_Name'] ?? '').' '.  ($datamemberarr['M_Name'] ?? ''). ' '.  ($datamemberarr['L_Name'] ?? ''). ' , Email: '.  ($datamemberarr['email'] ?? ''). ', Amount: $'. ($datamemberarr['total'] ?? '').', Membership Type: '. $membertype.', Order Id: '. $oid.', Status: ' . ($datamemberarr['payment_status'] ?? '')  ;
                           try { $this->SendSMS($mobileno, $msg); } catch (Exception $e) { /* SMS failed, continue */ }
                          }
                        $data = array();
                        $data['rate'] = $_POST['rate'] ?? '';

                        switch($_POST['rate'] ?? ''){
                            case 'gmi_1':
                                $data['Category'] = 'GD';
                                break;
                            case 'gmi_4':
                                $data['Category'] = 'GD';
                                break;
                            case 'gmf_1':
                                $data['Category'] = 'GD';
                                break;
                            case 'gmf_4':
                                $data['Category'] = 'GD';
                                break;
                            case 'lm':
                                $data['Category'] = 'LM';
                                break;
                            case 'bf':
                                $data['Category'] = 'BF';
                                break;
                            case 'pm':
                                $data['Category'] = 'CT';
                                break;
                            case 'lm_h':
                                $data['Category'] = 'LM';
                                break;
                        }
                        
                       // $data['member_id'] = $id;
                        //$data['member_id'] = $ID;

                        $data['Createdon'] = date('Y-m-d H:i:s');

                        if($this->isMember()){
                          $data['Updatedby'] = $this->getMemberId();
                        }else{
                            $data['Updatedby'] = $this->getUserId();
                        }

                       // $data['Status'] = 'P';

                        //$MemberLogModel->save($data);
                        
                       //$this->tpl['arr'] = $MemberModel->get($ID);
                        $data =$MemberModel->get($ID);
                       if (session_status() === PHP_SESSION_NONE) { session_start(); }
                       $_SESSION['myValue']=$oid;
                       $this->tpl['arr'] = $data;
                    } else {

                        $opts = array();
                      // $opts['id'] = $id;
                        $opts['ID'] = $ID;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;
                        
                        $MemberModel->update($opts);

                        $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                    }
                } catch (Exception $ex) {
                    $log('STEP_ERR: Exception caught: ' . $ex->getMessage());
                    $_SESSION['status'] = $ex->getMessage();
                }
            }
          else{
            $log('STEP_ERR: membersave returned false. Member NOT created.');
            $_SESSION['status'] = 'An error occurred, please try again!';
           }

            GzObject::loadFiles('Model', array('MemberLog'));
            $MemberLogModel = new MemberLogModel();

                date_default_timezone_set("America/Chicago");
                $today = date("Y-m-d");
                if (!is_array($data)) {
                    $data = [];
                }
                $data['member_id'] = $ID;
                $data['rate'] = $_POST['rate'] ?? '';
                switch($_POST['rate'] ?? '') {
                    case 'gmi_1': case 'gmi_4': case 'gmf_1': case 'gmf_4':
                        $data['Category'] = 'GD'; break;
                    case 'lm': case 'lm_h':
                        $data['Category'] = 'LM'; break;
                    case 'bf':
                        $data['Category'] = 'BF'; break;
                    case 'pm':
                        $data['Category'] = 'CT'; break;
                    default:
                        $data['Category'] = 'GD'; break;
                }
                $data['Createdon'] = $today;
                //$_POST['Createdon'] = date('Y-m-d H:i:s');
                //$_POST['Createdon'] = date('Y-m-d');
                $data['Status'] = $_POST['status'] ?? '';
                $data['Updatedby'] = $this->isMember() ? (string)(int)$this->getMemberId() : (string)(int)($this->getUserId() ?: 0);
                $log('STEP9: Saving members_log. member_id=' . $ID . ' Category=' . ($data['Category'] ?? 'N/A') . ' rate=' . ($data['rate'] ?? 'N/A'));
                $MemberLogModel->save($data);

            $this->tpl['arr'] = $MemberModel->get($ID);
            $log('STEP10: Redirecting to Member/details/' . $ID);
            Util::redirect(INSTALL_URL . "Member/details/".$ID);
        }
		}
    }
    
     function adminedit() {

        GzObject::loadFiles('Model', array('Member', 'nextmid', 'Country', 'Donation','MemberLog'));
        $MemberModel = new MemberModel();
        $nextmidModel = new nextmidModel();
        $CountryModel = new CountryModel();
        $DonationModel = new DonationModel();
        $MemberLogModel = new MemberLogModel();

        $arr= $CountryModel->getCountry();
        $this->tpl['Country'] =  $arr;
    
        if (!empty($_POST['editadmin_user'])) {

            if (!$this->isLoged()) {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }

            $member = $MemberModel->get($_POST['ID'] ?? '');
            if (($_POST['status'] ?? '') == 'E') {
                $Sp_FName = $_POST['Sp_FName'] ?? '';
                $Sp_LName = $_POST['Sp_LName'] ?? '';
                //$F_Name = $_POST['F_Name'];
                $F_Name = ($_POST['F_Name'] ?? '') . ($_POST['M_Name'] ?? '');
                $L_Name = $_POST['L_Name'] ?? '';

                $data = array();
                if (trim($_POST['late'] ?? '') == trim($_POST['F_Name'] ?? '') && trim($_POST['Sp_FName'] ?? '') != "") {
                    $_POST['F_Name'] = $Sp_FName;
                    $_POST['L_Name'] = $Sp_LName;
                    $_POST['M_Name'] = " ";
                    $data['swap'] = '0';
                    $_POST['Sp_FName'] = $F_Name;
                    $_POST['Sp_LName'] = $L_Name;
                    $_POST['SpouseSal'] = "Late";
                    //$_POST['status'] = 'T';
                    $_POST['status'] ='T';
                    
                    
                    $data['Category'] =  $_POST['membercategory'] ?? '';
                    $data['Status'] = 'Spousee';
                    $data['member_id'] = $_POST['dataid'] ?? '';
                    $MemberLogModel->save($data);
                }
                if (trim($_POST['late'] ?? '') == trim($_POST['F_Name'] ?? '') && trim($_POST['Sp_FName'] ?? '') == "") {
                    $_POST['FirstSal'] = "Late";
                   $_POST['status'] ='E';
                   
                   $data['Category'] =  $_POST['membercategory'] ?? '';
                   $data['Status'] = 'Firste';
                   $data['member_id'] = $_POST['dataid'] ?? '';
                   $MemberLogModel->save($data);
                 }
                if (trim($_POST['late'] ?? '') == trim($_POST['Sp_FName'] ?? '')) {
                    $_POST['SpouseSal'] = "Late";
                    $_POST['status'] ='T';
                    
                    $data['Category'] =  $_POST['membercategory'] ?? '';
                    $data['Status'] = 'Spe';
                    $data['member_id'] = $_POST['dataid'] ?? '';
                    $MemberLogModel->save($data);
                }
                if (trim($_POST['late'] ?? '') == "both") {
                    $_POST['SpouseSal'] = "Late";
                    $_POST['FirstSal'] = "Late";
                    $_POST['status'] = 'E';
                    
                     $data['Category'] =  $_POST['membercategory'] ?? '';
                    $data['Status'] = 'E';
                    $data['member_id'] = $_POST['dataid'] ?? '';
                    $MemberLogModel->save($data);
                }
            }
            $data = array();

            if (!empty($_FILES['img'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['img']);

                $img_name = time();

                if ($handle->uploaded) {

                    $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

                    $handle->file_new_name_body = $img_name;
                    $handle->image_resize = true;
                    $handle->image_x = 200;
                    $handle->image_ratio_y = true;
                    $handle->allowed = array('image/*');
                    $handle->process($thumb_dest);

                    if ($handle->processed) {
                        $handle->clean();
                    } else {
                        echo 'error : ' . $handle->error;
                    }
                    $data['avatar'] = $handle->file_dst_name;
                }
            }
                // $cat = $_POST['Category'] ?? '';
                if (!empty($_POST['password'])) {
                    $pasword = $_POST['password'] ?? '';
                    $data['password'] = md5($pasword);
                    $cur_member_id = 0; // set from DB after fetch below
    
                    $status = $_POST['status'] ?? '';
                    $getdataid = $_POST['ID'] ?? '';
                    $datamemberarr = $MemberModel->get($getdataid);
                    $memberstatus =  $datamemberarr['status'];
                    $status =  $_POST['status'] ?? '';
                    $cat = $datamemberarr['Category'];
                    $cur_member_id = (int)($datamemberarr['Member_id'] ?? 0);
                    if(($cur_member_id == 0 && $cat == 'GD') && ($memberstatus == 'F' && $status == "T")){
                        $data['Application_date'] = date('Y-m-d H:i:s');
                        $StartingDate =date('Y');
                        $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                        $renew = $newEndingDate."-"."03"."-"."31";
                        $data['Renew_date'] = $renew;
                        
                    
                    $idm = $nextmidModel->getMax() + 1;
                    $_POST['Member_id'] = $idm;
                    $update_mid = $nextmidModel->Updateid($idm);
                    $_POST['Member_id'] = $idm;
                    $data['Category'] = 'GM';
                    
                    
                    $transaction = $_POST['transactionid'] ?? '';
                    $getDonationId = $DonationModel->getDonationdata($transaction);

                    $value = array();
                    $uniquedonationid = $getDonationId['id'];
                    $_POST['id'] = $uniquedonationid;
                    $_POST['Member_id'] = $idm;
                    $updateResult = $DonationModel->update( $_POST);
                    
                    // chnage on 14_october_2025
                    
                    if ($updateResult === false) {
                        echo "<script>alert('payment not found , user not updated');</script>";

                        if (!$this->isAdmin() && !$this->isRental() && !$this->isEducation() && !$this->isEvents()) {
                            Util::redirect(INSTALL_URL . "Member/adminedit/" . ($_POST['ID'] ?? ''));
                            exit;

                        } else {
                            Util::redirect(INSTALL_URL . "Member/index");
                            exit;
                        }

                    }
                    
                    
                    
                    $mobileno = $datamemberarr['Tele1']; 	
                     if ($datamemberarr['Tele1'] != null) {
                       $msg = 'Houston Durga Bari: Your Membership Request has been Accepted and Your Member Id: '. $idm.', Member Name: '. $datamemberarr['F_Name'].' '.  $datamemberarr['M_Name']. ' '.  $datamemberarr['L_Name']. ' , Email: '.  $datamemberarr['email'];
                       //$this->SendSMS($mobileno, $msg);
                      }
                      $category =  $data['Category'];
                        $data['Category'] = $category;
                        $data['Status'] = $_POST['status'] ?? '';
                        $data['member_id'] = $_POST['Member_id'] ?? '';
                        $data['Createdon'] = date('Y-m-d H:i:s');
                        $data['Updatedby'] = $this->isMember() ? (string)(int)$this->getMemberId() : (string)(int)($this->getUserId() ?: 0);
                        $MemberLogModel->save($data);
                    }


                    if(($cur_member_id == 0 && $cat == 'LM') && ($memberstatus == 'F'  && $status == "T")){
                        $data['Application_date'] = date('Y-m-d H:i:s');
                        $StartingDate =date('Y');
                        $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                        $renew = $newEndingDate."-"."03"."-"."31";
                        $data['Renew_date'] = $renew;
                        $idm = $nextmidModel->getMax() + 1;
                        $_POST['Member_id'] = $idm;
                        $update_mid = $nextmidModel->Updateid($idm);
                        $_POST['Member_id'] = $idm;
                        
                        
                        $transaction = $_POST['transactionid'] ?? '';
                        $getDonationId = $DonationModel->getDonationdata($transaction);

                        $value = array();
                        $uniquedonationid = $getDonationId['id'];
                        $_POST['id'] = $uniquedonationid;
                        $_POST['Member_id'] = $idm;
                        $updateResult2 = $DonationModel->update( $_POST);

                        if ($updateResult2 === false)
                        {
                            echo "<script>alert('payment not found , user not updated');</script>";

                            if (!$this->isAdmin() && !$this->isRental() && !$this->isEducation() && !$this->isEvents())
                            {
                               Util::redirect(INSTALL_URL . "Member/adminedit/" . ($_POST['ID'] ?? ''));
                               exit;

                            }

                            else
                            {
                               Util::redirect(INSTALL_URL . "Member/index");
                               exit;
                            }

                        }



                         $mobileno = $datamemberarr['Tele1'];
                    if ($datamemberarr['Tele1'] != null) {
                       $msg = 'Houston Durga Bari: Your Membership Request has been Accepted and Your Member Id: '. $idm.', Member Name: '. $datamemberarr['F_Name'].' '.  $datamemberarr['M_Name']. ' '.  $datamemberarr['L_Name']. ' , Email: '.  $datamemberarr['email'];
                       //$this->SendSMS($mobileno, $msg);
                      }

                      $category =  $data['Category'];
                        $data['Category'] =  $category;
                        $dta['Status'] = $_POST['status'] ?? '';
                        $data['member_id'] = $_POST['Member_id'] ?? '';
                        $data['Createdon'] = date('Y-m-d H:i:s');
                        $data['Updatedby'] = $this->isMember() ? (string)(int)$this->getMemberId() : (string)(int)($this->getUserId() ?: 0);
                        $MemberLogModel->save($data);
                    }

                }

            unset($_POST['password']);
            $_POST['Senior'] = !empty($_POST['Senior']) ? 'YES' : '';
            $oldExpiredStatus = $this->getExpiredStatusFromMember($member);
            $newExpiredStatus = $this->applyExpiredStatusSelection();

            $ID = $MemberModel->update(array_merge($data, $_POST));
            if (!empty($ID)) {
                $this->logExpiredStatusChange($MemberLogModel, $oldExpiredStatus, $newExpiredStatus);
            }
            $seniorSaved = $MemberModel->updateSeniorStatusById($_POST['ID'] ?? 0, $_POST['Senior'] ?? '', $_POST['Gotra'] ?? '');
            if (empty($ID) && $seniorSaved) {
                $ID = $_POST['ID'] ?? 0;
            }

            $approvedMemberId = (int) ($_POST['Member_id'] ?? 0);
            $approvedCategory = strtoupper(trim((string) ($data['Category'] ?? ($_POST['Category'] ?? $cat ?? ''))));
            if (!empty($ID) && ($_POST['status'] ?? '') == 'T' && $approvedMemberId > 0 && $approvedMemberId < 10000 && $approvedCategory !== 'GC') {
                $MemberModel->deactivateDuplicateGcContact($ID, $_POST['email'] ?? '', $_POST['Tele1'] ?? '');
            }

            if (($_POST['status'] ?? '') == 'T' && $member['status'] != 'T') {

                $_POST['password'] = $pasword;

                $this->sendMemberEmails($_POST['ID'] ?? '', 'active', 'member');
            }

            if (!empty($ID)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

           if (!$this->isAdmin() && !$this->isRental() && !$this->isEducation() && !$this->isEvents() && !$this->isRegistration()) {
                // working code 
                //Util::redirect(INSTALL_URL . "Admin/dashboard");
                // new url for stop same page
                Util::redirect(INSTALL_URL . "Member/adminedit/" . ($_POST['ID'] ?? ''));
 
            } else {
                Util::redirect(INSTALL_URL . "Member/index");
            }
        }

        if (!$this->isLoged()) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }
        
        $ID = $_GET['ID'] ?? '';
        $arr = $MemberModel->get($ID);

        $this->tpl['arr'] = $arr;
    }
    function admineditBackup() {

        GzObject::loadFiles('Model', array('Member', 'nextmid', 'Country', 'Donation','MemberLog'));
        $MemberModel = new MemberModel();
        $nextmidModel = new nextmidModel();
        $CountryModel = new CountryModel();
        $DonationModel = new DonationModel();
        $MemberLogModel = new MemberLogModel();

        $arr= $CountryModel->getCountry();
        $this->tpl['Country'] =  $arr;
    
        if (!empty($_POST['editadmin_user'])) {

            if ($this->isMember() && ($_POST['ID'] ?? '') != $this->getMemberId()) {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }

            $member = $MemberModel->get($_POST['ID'] ?? '');
            if (($_POST['status'] ?? '') == 'E') {
                $Sp_FName = $_POST['Sp_FName'] ?? '';
                $Sp_LName = $_POST['Sp_LName'] ?? '';
                //$F_Name = $_POST['F_Name'];
                $F_Name = ($_POST['F_Name'] ?? '') . ($_POST['M_Name'] ?? '');
                $L_Name = $_POST['L_Name'] ?? '';

                $data = array();
                if (trim($_POST['late'] ?? '') == trim($_POST['F_Name'] ?? '') && trim($_POST['Sp_FName'] ?? '') != "") {
                    $_POST['F_Name'] = $Sp_FName;
                    $_POST['L_Name'] = $Sp_LName;
                    $_POST['M_Name'] = " ";
                    $data['swap'] = '0';
                    $_POST['Sp_FName'] = $F_Name;
                    $_POST['Sp_LName'] = $L_Name;
                    $_POST['SpouseSal'] = "Late";
                    //$_POST['status'] = 'T';
                    $_POST['status'] ='T';
                    
                    
                    $data['Category'] =  $_POST['membercategory'] ?? '';
                    $data['Status'] = 'Spousee';
                    $data['member_id'] = $_POST['dataid'] ?? '';
                    $MemberLogModel->save($data);
                }
                if (trim($_POST['late'] ?? '') == trim($_POST['F_Name'] ?? '') && trim($_POST['Sp_FName'] ?? '') == "") {
                    $_POST['FirstSal'] = "Late";
                   $_POST['status'] ='E';
                   
                   $data['Category'] =  $_POST['membercategory'] ?? '';
                   $data['Status'] = 'Firste';
                   $data['member_id'] = $_POST['dataid'] ?? '';
                   $MemberLogModel->save($data);
                 }
                if (trim($_POST['late'] ?? '') == trim($_POST['Sp_FName'] ?? '')) {
                    $_POST['SpouseSal'] = "Late";
                    $_POST['status'] ='T';
                    
                    $data['Category'] =  $_POST['membercategory'] ?? '';
                    $data['Status'] = 'Spe';
                    $data['member_id'] = $_POST['dataid'] ?? '';
                    $MemberLogModel->save($data);
                }
                if (trim($_POST['late'] ?? '') == "both") {
                    $_POST['SpouseSal'] = "Late";
                    $_POST['FirstSal'] = "Late";
                    $_POST['status'] = 'E';
                    
                     $data['Category'] =  $_POST['membercategory'] ?? '';
                    $data['Status'] = 'E';
                    $data['member_id'] = $_POST['dataid'] ?? '';
                    $MemberLogModel->save($data);
                }
            }
            $data = array();

            if (!empty($_FILES['img'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['img']);

                $img_name = time();

                if ($handle->uploaded) {

                    $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

                    $handle->file_new_name_body = $img_name;
                    $handle->image_resize = true;
                    $handle->image_x = 200;
                    $handle->image_ratio_y = true;
                    $handle->allowed = array('image/*');
                    $handle->process($thumb_dest);

                    if ($handle->processed) {
                        $handle->clean();
                    } else {
                        echo 'error : ' . $handle->error;
                    }
                    $data['avatar'] = $handle->file_dst_name;
                }
            }
                // $cat = $_POST['Category'] ?? '';
                if (!empty($_POST['password'])) {
                    $pasword = $_POST['password'] ?? '';
                    $data['password'] = md5($pasword);
                    $cur_member_id = 0; // set from DB after fetch below
    
                    $status = $_POST['status'] ?? '';
                    $getdataid = $_POST['ID'] ?? '';
                    $datamemberarr = $MemberModel->get($getdataid);
                    $memberstatus =  $datamemberarr['status'];
                    $status =  $_POST['status'] ?? '';
                    $cat = $datamemberarr['Category'];
                    $cur_member_id = (int)($datamemberarr['Member_id'] ?? 0);
                    if(($cur_member_id == 0 && $cat == 'GD') && ($memberstatus == 'F' && $status == "T")){
                        $data['Application_date'] = date('Y-m-d H:i:s');
                        $StartingDate =date('Y');
                        $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                        $renew = $newEndingDate."-"."03"."-"."31";
                        $data['Renew_date'] = $renew;
                        
                    
                    $idm = $nextmidModel->getMax() + 1;
                    $_POST['Member_id'] = $idm;
                    $update_mid = $nextmidModel->Updateid($idm);
                    $_POST['Member_id'] = $idm;
                    $data['Category'] = 'GM';
                    
                    
                    $transaction = $_POST['transactionid'] ?? '';
                    $getDonationId = $DonationModel->getDonationdata($transaction);

                    $value = array();
                    $uniquedonationid = $getDonationId['id'];
                    $_POST['id'] = $uniquedonationid;
                    $_POST['Member_id'] = $idm;
                    $DonationModel->update( $_POST);
                    $mobileno = $datamemberarr['Tele1'];
                     if ($datamemberarr['Tele1'] != null) {
                       $msg = 'Houston Durga Bari: Your Membership Request has been Accepted and Your Member Id: '. $idm.', Member Name: '. $datamemberarr['F_Name'].' '.  $datamemberarr['M_Name']. ' '.  $datamemberarr['L_Name']. ' , Email: '.  $datamemberarr['email'];
                       $this->SendSMS($mobileno, $msg);
                      }
                      $category =  $data['Category'];
                        $data['Category'] = $category;
                        $data['Status'] = $_POST['status'] ?? '';
                        $data['member_id'] = $_POST['Member_id'] ?? '';
                        $data['Createdon'] = date('Y-m-d H:i:s');
                        $data['Updatedby'] = $this->isMember() ? (string)(int)$this->getMemberId() : (string)(int)($this->getUserId() ?: 0);
                        $MemberLogModel->save($data);
                    }


                    if(($cur_member_id == 0 && $cat == 'LM') && ($memberstatus == 'F'  && $status == "T")){
                        $data['Application_date'] = date('Y-m-d H:i:s');
                        $StartingDate =date('Y');
                        $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                        $renew = $newEndingDate."-"."03"."-"."31";
                        $data['Renew_date'] = $renew;
                        $idm = $nextmidModel->getMax() + 1;
                        $_POST['Member_id'] = $idm;
                        $update_mid = $nextmidModel->Updateid($idm);
                        $_POST['Member_id'] = $idm;
                        
                        
                       $transaction = $_POST['transactionid'] ?? '';
                        $getDonationId = $DonationModel->getDonationdata($transaction);

                        $value = array();
                        $uniquedonationid = $getDonationId['id'];
                        $_POST['id'] = $uniquedonationid;
                        $_POST['Member_id'] = $idm;
                        $DonationModel->update( $_POST);
                         $mobileno = $datamemberarr['Tele1'];
                    if ($datamemberarr['Tele1'] != null) {
                       $msg = 'Houston Durga Bari: Your Membership Request has been Accepted and Your Member Id: '. $idm.', Member Name: '. $datamemberarr['F_Name'].' '.  $datamemberarr['M_Name']. ' '.  $datamemberarr['L_Name']. ' , Email: '.  $datamemberarr['email'];
                       $this->SendSMS($mobileno, $msg);
                      }

                      $category =  $data['Category'];
                        $data['Category'] =  $category;
                        $dta['Status'] = $_POST['status'] ?? '';
                        $data['member_id'] = $_POST['Member_id'] ?? '';
                        $data['Createdon'] = date('Y-m-d H:i:s');
                        $data['Updatedby'] = $this->isMember() ? (string)(int)$this->getMemberId() : (string)(int)($this->getUserId() ?: 0);
                        $MemberLogModel->save($data);
                    }

                }

            unset($_POST['password']);

            $ID = $MemberModel->update(array_merge($data, $_POST));
            
            if (($_POST['status'] ?? '') == 'T' && $member['status'] != 'T') {

                $_POST['password'] = $pasword;

                $this->sendMemberEmails($_POST['ID'] ?? '', 'active', 'member');
            }

            if (!empty($ID)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                // working code 
                //Util::redirect(INSTALL_URL . "Admin/dashboard");
                // new url for stop same page
                Util::redirect(INSTALL_URL . "Member/edit/" . ($_POST['ID'] ?? ''));
          
                
            } else {
                Util::redirect(INSTALL_URL . "Member/index");
            }
        }

        if ($this->isMember() && $_GET['ID'] ?? '' != $this->getMemberId()) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }
        
        $ID = $_GET['ID'] ?? '';
        $arr = $MemberModel->get($ID);

        $this->tpl['arr'] = $arr;
    }
    
function adminedit1() {

        GzObject::loadFiles('Model', array('Member', 'nextmid', 'Country'));
        $MemberModel = new MemberModel();
        $nextmidModel = new nextmidModel();
        $CountryModel = new CountryModel();
        $arr= $CountryModel->getCountry();
        $this->tpl['Country'] =  $arr;
    
        if (!empty($_POST['editadmin_user'])) {

            if ($this->isMember() && ($_POST['ID'] ?? '') != $this->getMemberId()) {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }

            $member = $MemberModel->get($_POST['ID'] ?? '');
            if (($_POST['status'] ?? '') == 'E') {
                $Sp_FName = $_POST['Sp_FName'] ?? '';
                $Sp_LName = $_POST['Sp_LName'] ?? '';
                //$F_Name = $_POST['F_Name'];
                $F_Name = ($_POST['F_Name'] ?? '') . ($_POST['M_Name'] ?? '');
                $L_Name = $_POST['L_Name'] ?? '';

                $data = array();
                if (trim($_POST['late'] ?? '') == trim($_POST['F_Name'] ?? '') && trim($_POST['Sp_FName'] ?? '') != "") {
                    $_POST['F_Name'] = $Sp_FName;
                    $_POST['L_Name'] = $Sp_LName;
                    $_POST['M_Name'] = " ";
                    $data['swap'] = '0';
                    $_POST['Sp_FName'] = $F_Name;
                    $_POST['Sp_LName'] = $L_Name;
                    $_POST['SpouseSal'] = "Late";
                    //$_POST['status'] = 'T';
                    $_POST['status'] ='T';
                }
                if (trim($_POST['late'] ?? '') == trim($_POST['F_Name'] ?? '') && trim($_POST['Sp_FName'] ?? '') == "") {
                    $_POST['FirstSal'] = "Late";
                   $_POST['status'] ='E';
                 }
                if (trim($_POST['late'] ?? '') == trim($_POST['Sp_FName'] ?? '')) {
                    $_POST['SpouseSal'] = "Late";
                    $_POST['status'] ='T';
                }
                if (trim($_POST['late'] ?? '') == "both") {
                    $_POST['SpouseSal'] = "Late";
                    $_POST['FirstSal'] = "Late";
                    $_POST['status'] = 'E';
                }
            }
            $data = array();

            if (!empty($_FILES['img'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['img']);

                $img_name = time();

                if ($handle->uploaded) {

                    $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

                    $handle->file_new_name_body = $img_name;
                    $handle->image_resize = true;
                    $handle->image_x = 200;
                    $handle->image_ratio_y = true;
                    $handle->allowed = array('image/*');
                    $handle->process($thumb_dest);

                    if ($handle->processed) {
                        $handle->clean();
                    } else {
                        echo 'error : ' . $handle->error;
                    }
                    $data['avatar'] = $handle->file_dst_name;
                }
            }
                if (!empty($_POST['password'])) {
                    $pasword = $_POST['password'] ?? '';
                    $data['password'] = md5($pasword);
                    $cur_member_id = 0; // set from DB after fetch below
    
                    $status = $_POST['status'] ?? '';
                    $getdataid = $_POST['ID'] ?? '';
                    $datamemberarr = $MemberModel->get($getdataid);
                    $memberstatus =  $datamemberarr['status'];
                    $status =  $_POST['status'] ?? '';
                    $cat = $datamemberarr['Category'];
                    $cur_member_id = (int)($datamemberarr['Member_id'] ?? 0);
                    if(($cur_member_id == 0 && $cat == 'GD') && ($memberstatus == 'F' && $status == "T")){
                         $data['Application_date'] = date('Y-m-d H:i:s');
                        $StartingDate =date('Y');
                        $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                        $renew = $newEndingDate."-"."03"."-"."31";
                        $data['Renew_date'] = $renew;
                    $idm = $nextmidModel->getMax() + 1;
                    $_POST['Member_id'] = $idm;
                    $update_mid = $nextmidModel->Updateid($idm);
                    $_POST['Member_id'] = $idm;
                    $data['Category'] = 'GM';
                    }
    
                    if(($cur_member_id == 0 && $cat == 'LM') && ($memberstatus == 'F'  && $status == "T")){
                         $data['Application_date'] = date('Y-m-d H:i:s');
                        $StartingDate =date('Y');
                        $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                        $renew = $newEndingDate."-"."03"."-"."31";
                        $data['Renew_date'] = $renew;
                        
                        $idm = $nextmidModel->getMax() + 1;
                        $_POST['Member_id'] = $idm;
                        $update_mid = $nextmidModel->Updateid($idm);
                        $_POST['Member_id'] = $idm;
                        //$data['Category'] = 'GM';
                     }
    
    
                }
            
            unset($_POST['password']);
      
            $ID = $MemberModel->update(array_merge($data, $_POST));
            
            GzObject::loadFiles('Model', array('MemberLog'));
            $MemberLogModel = new MemberLogModel();

            $data = array();
            $data['rate'] = $_POST['rate'] ?? '';

            // $data['Createdon'] = date('Y-m-d H:i:s');

            if($this->isMember()){
                $data['Updatedby'] = $this->getMemberId();
            }else{
                $data['Updatedby'] = $this->getUserId();
            }
            
            // $data['Status'] = $_POST['status'] ?? '';

            $MemberLogModel->save($data);

            if (($_POST['status'] ?? '') == 'T' && $member['status'] != 'T') {

                $_POST['password'] = $pasword;

                $this->sendMemberEmails($_POST['ID'] ?? '', 'active', 'member');
            }

            if (!empty($ID)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                // working code 
                //Util::redirect(INSTALL_URL . "Admin/dashboard");
                // new url for stop same page
                Util::redirect(INSTALL_URL . "Member/edit/" . ($_POST['ID'] ?? ''));
          
                
            } else {
                Util::redirect(INSTALL_URL . "Member/index");
            }
        }

        if ($this->isMember() && $_GET['ID'] ?? '' != $this->getMemberId()) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }
        
        $ID = $_GET['ID'] ?? '';
        $arr = $MemberModel->get($ID);

        $this->tpl['arr'] = $arr;
    }

 function edit() {

        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();

        if (!empty($_POST['edit_user'])) {

            if ($this->isMember() && ($_POST['ID'] ?? '') != $this->getMemberId()) {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }

            $member = $MemberModel->get($_POST['ID'] ?? '');

            $data = array();

            if (!empty($_FILES['img'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['img']);

                $img_name = time();

                if ($handle->uploaded) {

                    $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

                    $handle->file_new_name_body = $img_name;
                    $handle->image_resize = true;
                    $handle->image_x = 200;
                    $handle->image_ratio_y = true;
                    $handle->allowed = array('image/*');
                    $handle->process($thumb_dest);

                    if ($handle->processed) {
                        $handle->clean();
                    } else {
                        echo 'error : ' . $handle->error;
                    }
                    $data['avatar'] = $handle->file_dst_name;
                }
            }

            if (!empty($_POST['password'])) {
                $idm = $nextmidModel->getMax() + 1;
                $data['Member_id'] = $idm;
                $update_mid = $nextmidModel->Updateid($idm);
                $data['Member_id'] = $idm;
                $pasword = $_POST['password'] ?? '';
                $data['password'] = md5($pasword);
            }
            
            unset($_POST['password']);
        if ($member['payment_status'] == "confirmed"){
            switch($_POST['rate'] ?? ''){
                case 'gmi_1':
                    $data['Category'] = 'GM';
                    break;
                case 'gmi_4':
                    $data['Category'] = 'GM';
                    break;
                case 'gmf_1':
                    $data['Category'] = 'GM';
                    break;
                case 'gmf_4':
                    $data['Category'] = 'GM';
                    break;
                case 'lm':
                    $data['Category'] = 'LM';
                    break;
                case 'bf':
                    $data['Category'] = 'BF';
                    break;
                case 'pm':
                    $data['Category'] = 'CT';
                    break;
                case 'lm_h':
                    $data['Category'] = 'LM';
                    break;
            }
        }
        else{
            switch($_POST['rate'] ?? ''){
                case 'gmi_1':
                    $data['Category'] = 'GD';
                    break;
                case 'gmi_4':
                    $data['Category'] = 'GD';
                    break;
                case 'gmf_1':
                    $data['Category'] = 'GD';
                    break;
                case 'gmf_4':
                    $data['Category'] = 'GD';
                    break;
                case 'lm':
                    $data['Category'] = 'LM';
                    break;
                case 'bf':
                    $data['Category'] = 'BF';
                    break;
                case 'pm':
                    $data['Category'] = 'CT';
                    break;
                case 'lm_h':
                    $data['Category'] = 'LM';
                    break;
            }
        }
            $ID = $MemberModel->update(array_merge($data, $_POST));
            
            GzObject::loadFiles('Model', array('MemberLog'));
            $MemberLogModel = new MemberLogModel();

            $data = array();
            $data['rate'] = $_POST['rate'] ?? '';
        if ($member['payment_status'] == "confirmed"){
            switch($_POST['rate'] ?? ''){
                case 'gmi_1':
                    $data['Category'] = 'GM';
                    break;
                case 'gmi_4':
                    $data['Category'] = 'GM';
                    break;
                case 'gmf_1':
                    $data['Category'] = 'GM';
                    break;
                case 'gmf_4':
                    $data['Category'] = 'GM';
                    break;
                case 'lm':
                    $data['Category'] = 'LM';
                    break;
                case 'bf':
                    $data['Category'] = 'BF';
                    break;
                case 'pm':
                    $data['Category'] = 'CT';
                    break;
                case 'lm_h':
                    $data['Category'] = 'LM';
                    break;
            }
        }else{
            switch($_POST['rate'] ?? ''){
                case 'gmi_1':
                    $data['Category'] = 'GD';
                    break;
                case 'gmi_4':
                    $data['Category'] = 'GD';
                    break;
                case 'gmf_1':
                    $data['Category'] = 'GD';
                    break;
                case 'gmf_4':
                    $data['Category'] = 'GD';
                    break;
                case 'lm':
                    $data['Category'] = 'LM';
                    break;
                case 'bf':
                    $data['Category'] = 'BF';
                    break;
                case 'pm':
                    $data['Category'] = 'CT';
                    break;
                case 'lm_h':
                    $data['Category'] = 'LM';
                    break;
            }
        }

            $data['member_id'] = $_POST['ID'] ?? '';

            $data['Createdon'] = date('Y-m-d H:i:s');

            if($this->isMember()){
                $data['Updatedby'] = $this->getMemberId();
            }else{
                $data['Updatedby'] = $this->getUserId();
            }
            
            $data['Status'] = $_POST['status'] ?? '';

            $MemberLogModel->save($data);

            if (($_POST['status'] ?? '') == 'T' && $member['status'] != 'T') {

                $_POST['password'] = $pasword;

                $this->sendMemberEmails($_POST['ID'] ?? '', 'active', 'member');
            }

            if (!empty($ID)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                // working code 
                //Util::redirect(INSTALL_URL . "Admin/dashboard");
                // new url for stop same page
                Util::redirect(INSTALL_URL . "Member/edit/" . ($_POST['ID'] ?? ''));
          
                
            } else {
                Util::redirect(INSTALL_URL . "Member/index");
            }
        }

        if ($this->isMember() && $_GET['ID'] ?? '' != $this->getMemberId()) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }
        
        $ID = $_GET['ID'] ?? '';
        $arr = $MemberModel->get($ID);

        $this->tpl['arr'] = $arr;
    }
    
    function memberedit() {

         GzObject::loadFiles('Model', array('Member', 'ConfirmCode', 'MemberLog' , 'Donation', 'Country', 'idnumbers'));
        $MemberModel = new MemberModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberLogModel = new MemberLogModel();
        $CountryModel = new CountryModel();
        $DonationModel = new DonationModel();
        $idnumbersModel = new idnumbersModel();
        $arr= $CountryModel->getCountry();
        $this->tpl['Country'] =  $arr;
        
        $member = $MemberModel->get($_GET['ID'] ?? '');
        $user = $this->getUser();
        
        
        $this->tpl['arr'] = $member;

        if (!empty($_POST['pay_user']) && !empty($_POST['ID'])) {
            
            $id = $member['ID'];
            $id = $_POST['ID'] ?? '';
            $cat = $_POST['membercategory'] ?? '';
            if ($cat == 'LM' || $cat == 'BF' || $cat == 'FM'|| $cat == 'FP'|| $cat == 'PM') {
                $MemberModel->update(array_merge($_POST));
                 $data['member_id'] = $_POST['Member_id'] ?? '';
                $data['Category'] = $cat;
                $MemberLogModel->save($data);
                Util::redirect(INSTALL_URL . "Member/memberedit/" . ($_POST['ID'] ?? ''));
            
            }
            if($cat == 'GM'){
                $StartingDate =date('Y');
                $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                $renew = $newEndingDate."-"."03"."-"."31";
                $total =$_POST['total'] ?? 0;
                $opts['id'] = $id;
                if($total=="3000"){
                       $_POST['Renew_date'] = "9999-12-31";
                   }else{
                       $_POST['Renew_date'] = $renew;
                   }
            
                $MemberModel->update(array_merge($_POST));
                $data['member_id'] = $_POST['Member_id'] ?? '';
                $data['Category'] = $cat;
                $MemberLogModel->save($data);
                Util::redirect(INSTALL_URL . "Member/memberedit/" . ($_POST['ID'] ?? ''));
            }
            else{
                 // for generate oid 
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            //$_POST['oid'] = $maxoid;
            $oid = $maxoid;
        // end generate oid for
             if (($_POST['Payment_method'] ?? '') == 'others') {
                    
                $opts = array();
                $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                $arr = $ConfirmCodeModel->getAll($opts);
                $cmCode=$_POST['code'] ?? '';
                $arr= $ConfirmCodeModel->UpdateCode($cmCode);
                $_POST['transaction_id'] =  $cmCode;

                if ($oid !=null) {
                    $opts = array();
                    $opts['id'] = $id;
                    $opts['payment_status'] = 'confirmed';
                    $StartingDate =date('Y');
                    $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                    $renew = $newEndingDate."-"."03"."-"."31";
                    $_POST['Renew_date'] = $renew;
                     date_default_timezone_set("America/Chicago");
                    $today = date("Y/m/d");
                    $_POST['pay_date']= $today;
                    $_POST['pay_type']= 'REGISTRATION';
                    if ($cat == 'GD') {

                        $_POST['pay_for'] = 'DB / HDBS Annual General Membership (GM)';
                    } else {
                        $_POST['pay_for'] = 'DB / HDBS Annual Maintenance';
                    }
                    $datamemberarr = array();
                    $datamemberarr =  array_merge($opts, $_POST);
                    $MemberModel->update(array_merge($opts, $_POST));
                    $value = array();
                    $value['oid'] = $oid;
                    $value['Category'] = $datamemberarr['Category'];
                    $value['Member_id'] =$datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['F_Name'].''.$datamemberarr['M_Name'].''.$datamemberarr['L_Name'];
                    $value['Amount'] = $datamemberarr['total'];
                    $value['PaymentOption'] = $datamemberarr['Payment_method'];
                    $value['payment_status'] = 'succeeded';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Address'] = $datamemberarr['Address2'];
                    $value['Street'] = $datamemberarr['Address1'];
                    $value['State'] = $datamemberarr['State'];
                    $value['Zip_Code'] = $datamemberarr['Zip'];
                    $value['Tele1'] = $datamemberarr['Tele1'];
                    $value['email'] = $datamemberarr['email'];
                    $value['City'] = $datamemberarr['City'];
                    $value['spousename'] = $datamemberarr['Sp_FName'].''.$datamemberarr['Sp_LName'];
                    $DonationModel->SaveDataInDonation($value);
                    echo '<script>alert("Payment Successfully")</script>';
                    $data = array();
                    $data['rate'] = $_POST['rate'] ?? '';

                    switch($_POST['rate'] ?? ''){
                        case 'gmi_1':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmi_4':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmf_1':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmf_4':
                            $data['Category'] = 'GM';
                            break;
                        case 'lm':
                            $data['Category'] = 'LM';
                            break;
                        case 'bf':
                            $data['Category'] = 'BF';
                            break;
                        case 'pm':
                            $data['Category'] = 'CT';
                            break;
                        case 'lm_h':
                            $data['Category'] = 'LM';
                            break;
                    }

                    $data['member_id'] = $_POST['Member_id'] ?? '';

                    $data['Createdon'] = date('Y-m-d H:i:s');

                    if($this->isMember()){
                        $data['Updatedby'] = $this->getMemberId();
                    }else{
                        $data['Updatedby'] = $this->getUserId();
                    }

                    if ($cat == 'GD') {
                            $data['Status'] = 'R';
                            }else{
        
                            $data['Status'] = 'A';
                            }
                    $MemberLogModel->save($data);
                    $this->sendEmailrenewalmember($datamemberarr, $oid);
                    $currentyear = date("Y");
                     $mobileno = $datamemberarr['Tele1']; 	
                     if ($datamemberarr['Tele1'] != null) {
                        $msg = 'Houston Durga Bari: Your Membership Renewal/Maintenance Payment Request for year '.$currentyear.' details are Member Id: '.  $datamemberarr['Member_id']. ', Member Name: '. $datamemberarr['F_Name'].''.  $datamemberarr['M_Name']. ''.  $datamemberarr['L_Name']. ' , Email: '.  $datamemberarr['email']. ', Amount: $'. $datamemberarr['total'].', Pay For: '. $datamemberarr['pay_for'].', Membership Type: '. ($datamemberarr['membership_type'] ?? '').', Order Id: '. $oid.', Status: ' . $datamemberarr['payment_status']  ;
                        $this->SendSMS($mobileno, $msg);
                    }
                }
            }elseif (($_POST['Payment_method'] ?? '') == 'stripe') {
                
                $price = $this->calculateMemberPrice();
                
                $amount = $price['total'];
                 //$total = $amount;
                require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                $error = '';
                $success = '';

                Stripe::setApiKey($this->tpl["option_arr_values"]["stripe_api_key"]);

                try {
                    if (!isset($_POST['stripeToken'])) {
                        throw new Exception("The Stripe Token was not generated correctly");
                    }
                     if ($cat == 'GD') {
                        $pay_for = 'DB / HDBS Annual General Membership (GM)';
                    } else {
                        $pay_for = 'DB / HDBS Annual Maintenance';
                    }

                    $amount = round($amount * 100);

                    $payment = Stripe_Charge::create(array(
                                "amount" => $amount,
                                "currency" => $this->tpl["option_arr_values"]["currency"],
                                "card" => $_POST['stripeToken'],
                                "description" => "Pay For:".$pay_for. ', ' ."Email:".($_POST['email'] ?? '') . ', ' ."Full Name:". ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? ''),
                                "metadata" => ["orderid" => $oid]
                    ));

                    $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                    $this->tpl['payment']['amount'] = $payment->amount;
                    $this->tpl['payment']['status'] = $payment->status;
                    $this->tpl['payment']['currency'] = $payment->currency;

                    if ($payment->status == 'succeeded') {

                      
                        $StartingDate =date('Y');
                         $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                         $renew = $newEndingDate."-"."03"."-"."31";
                         $total =$_POST['total'] ?? 0;
                         $opts['id'] = $id;
                         if($total=="3000"){
                                $_POST['Renew_date'] = "9999-12-31";
                            }else{
                                $_POST['Renew_date'] = $renew;
                            }

                            $MemberModel->update($opts);
                        unset($_POST['amount']);

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['donation'] = $_POST['donation'] ?? 0;
                        
                        $opts['amount'] = $price['total'] - (float)($_POST['donation'] ?? 0);
                        $opts['total'] = $price['total'];
                        $opts['stripe_product'] = $payment->description;
                        $opts['payment_status'] = 'confirmed';
                        $opts['payment_timestamp'] = time();
                        
                        switch($_POST['rate'] ?? ''){
                            case 'gmi_1':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmi_4':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmf_1':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmf_4':
                                $opts['Category'] = 'GM';
                                break;
                            case 'lm':
                                $opts['Category'] = 'LM';
                                break;
                            case 'bf':
                                $opts['Category'] = 'BF';
                                break;
                            case 'pm':
                                $opts['Category'] = 'CT';
                                break;
                            case 'lm_h':
                                $opts['Category'] = 'LM';
                                break;
                        }
                        date_default_timezone_set("America/Chicago");
                        $todaydate = date("Y/m/d");
                        $_POST['pay_date']= $todaydate;
                        $_POST['pay_type']= 'REGISTRATION';
                        if ($cat == 'GD') {

                            $_POST['pay_for'] = 'DB / HDBS Annual General Membership (GM)';
                        } else {
                            $_POST['pay_for'] = 'DB / HDBS Annual Maintenance';
                        }
                        $datamemberarr = array();
                        $datamemberarr =  array_merge($opts, $_POST) ;
                       $MemberModel->update(array_merge($opts, $_POST));
                       $value = array();
                       $value['oid'] = $oid;
                       $value['Category'] = $datamemberarr['Category'] ?? '';
                       $value['Member_id'] =$datamemberarr['Member_id'];
                       $value['MemberName'] = $datamemberarr['F_Name'].''.$datamemberarr['M_Name'].''.$datamemberarr['L_Name'];
                       $value['Amount'] = $datamemberarr['total'];
                       $value['PaymentOption'] = $datamemberarr['Payment_method'];
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
                       $value['Address'] = $datamemberarr['Address2'];
                       $value['Street'] = $datamemberarr['Address1'];
                       $value['State'] = $datamemberarr['State'];
                       $value['Zip_Code'] = $datamemberarr['Zip'];
                       $value['Tele1'] = $datamemberarr['Tele1'];
                       $value['email'] = $datamemberarr['email'];
                       $value['City'] = $datamemberarr['City'];
                       $value['spousename'] = $datamemberarr['Sp_FName'].''.$datamemberarr['Sp_LName'];
                       $DonationModel->SaveDataInDonation($value);
                       $this->sendEmailrenewalmember($datamemberarr, $oid);   
                       $currentyear = date("Y");
                       $mobileno = $datamemberarr['Tele1']; 	
                       if ($datamemberarr['Tele1'] != null) {
                          $msg = 'Houston Durga Bari: Your Membership Renewal/Maintenance Payment Request for year '.$currentyear.' details are Member Id: '.  $datamemberarr['Member_id']. ', Member Name: '. $datamemberarr['F_Name'].''.  $datamemberarr['M_Name']. ''.  $datamemberarr['L_Name']. ' , Email: '.  $datamemberarr['email']. ', Amount: $'. $datamemberarr['total'].', Pay For: '. $datamemberarr['pay_for'].', Membership Type: '. ($datamemberarr['membership_type'] ?? '').', Order Id: '. $oid.', Status: ' . $datamemberarr['payment_status']  ;
                          $this->SendSMS($mobileno, $msg);
                         }
                       echo '<script>alert("Payment Successfully")</script>';
                                               
                        $data = array();
                        $data['rate'] = $_POST['rate'] ?? '';

                        switch($_POST['rate'] ?? ''){
                            case 'gmi_1':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmi_4':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmf_1':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmf_4':
                                $data['Category'] = 'GM';
                                break;
                            case 'lm':
                                $data['Category'] = 'LM';
                                break;
                            case 'bf':
                                $data['Category'] = 'BF';
                                break;
                            case 'pm':
                                $data['Category'] = 'CT';
                                break;
                            case 'lm_h':
                                $data['Category'] = 'LM';
                                break;
                        }

                        $data['member_id'] = $datamemberarr['Member_id'];

                        $data['Createdon'] = date('Y-m-d H:i:s');

                        if($this->isMember()){
                            $data['Updatedby'] = $this->getMemberId();
                        }else{
                            $data['Updatedby'] = $this->getUserId();
                        }

                        if ($cat == 'GD') {
                            $data['Status'] = 'R';
                            }else{
        
                            $data['Status'] = 'A';
                            }


                        $MemberLogModel->save($data);
                        
                        $this->tpl['arr'] = $MemberModel->get($id);
                         Util::redirect(INSTALL_URL . "Member/memberedit/" . ($_POST['ID'] ?? ''));
                    } else {

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;
                        
                        $MemberModel->update($opts);

                        $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                    }
                
                } catch (Exception $ex) {
                    $_SESSION['status'] = $ex->getMessage();
                }
            }
             else{
            $_SESSION['status'] = 'An error occurred, please try again!';
           }
        }
    }
    }

 function membermaintenance() {

        GzObject::loadFiles('Model', array('Member', 'ConfirmCode', 'MemberLog', 'Country'));
        $MemberModel = new MemberModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberLogModel = new MemberLogModel();
        $CountryModel = new CountryModel();
        $arr= $CountryModel->getCountry();
        $this->tpl['Country'] =  $arr;
        //$member = $MemberModel->get($_GET['ID'] ?? '');
        if ($_GET['ID'] ?? '' != 0) {
            $member = $MemberModel->getbymemberid($_GET['ID'] ?? '');
            $this->tpl['arr'] = $member;
        }
        $user = $this->getUser();
        

        if (!empty($_POST['pay_usermaintenance']) && !empty($_POST['ID'])) {
            
            $id = $member['ID'];
            $id = $_POST['ID'] ?? '';
            $cat = $_POST['membercategory'] ?? '';
           
             if (($_POST['Payment_method'] ?? '') == 'others') {
                    
                $opts = array();
                $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                $arr = $ConfirmCodeModel->getAll($opts);

                if (!empty($arr[0])) {
                    $opts = array();
                    $opts['id'] = $id;
                    $opts['payment_status'] = 'confirmed';
                    $StartingDate =date('Y');
                    $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                    $renew = $newEndingDate."-"."03"."-"."31";
                    $total =$_POST['total'] ?? 0;
                    $opts['id'] = $id;
                    $_POST['Renew_date'] = $renew;
                    date_default_timezone_set("America/Chicago");
                    $today = date("Y/m/d");
                    $_POST['pay_date']= $today;
                    $_POST['pay_type']= 'REGISTRATION';
                     if ($cat == 'GD') {
                        $opts['Category'] = 'GM';
                         $_POST['pay_for'] = 'DB / HDBS Annual General Membership (GM)';
                     } else {
                         $_POST['pay_for'] = 'DB / HDBS Annual Maintenance';
                     }

                    $MemberModel->update($opts,  $_POST);

                    $data = array();
                    $data['rate'] = $_POST['rate'] ?? '';

                    
                    $data['member_id'] = $id;

                    $data['Createdon'] = date('Y-m-d H:i:s');

                    if($this->isMember()){
                        $data['Updatedby'] = $this->getMemberId();
                    }else{
                        $data['Updatedby'] = $this->getUserId();
                    }

                    $data['Status'] = 'P';

                        $MemberLogModel->save($data);
					    $Memberid = $_POST['Member_id'] ?? '';
						$email =  $_POST['email'] ?? '';
						$mobile = $_POST['Tele1'] ?? '';

						$transactionid = $opts['transaction_id'];
                        echo "<div style='margin-left:23em;' class = 'pay'>
                            <table border='4'  width='585px' style='margin-left:4em;'>
                            <tr>
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                          
                            <tr>
							<td>Member ID</td> <td>" .$Memberid. "</td> </tr>
                           <td>Member Name</td> <td>" .($_POST['F_Name'] ?? '').' ' .($_POST['M_Name'] ?? '').' ' .($_POST['L_Name'] ?? ''). "</td> </tr>
                           <tr><td>Member Email Address</td> <td>" .$email.  "</td> </tr>
                           <tr><td>Member Phone Number</td> <td>" .$mobile. "</td>  </tr>
                           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                           </tr>";
                           echo "</table>";
                           echo "</div>";	
                }
            }elseif (($_POST['Payment_method'] ?? '') == 'stripe') {
                
                $price = $this->calculateMemberPrice();
                
                $amount = $price['total'];
                //$total = $amount;
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
                                "description" => $_POST['email'] . ', ' . ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '')
                    ));

                    $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                    $this->tpl['payment']['amount'] = $payment->amount;
                    $this->tpl['payment']['status'] = $payment->status;
                    $this->tpl['payment']['currency'] = $payment->currency;

                    if ($payment->status == 'succeeded') {

                      
                        $StartingDate =date('Y');
                         $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                         $renew = $newEndingDate."-"."03"."-"."31";
                         $total =$_POST['total'] ?? 0;
                         $opts['id'] = $id;
                         $_POST['Renew_date'] = $renew;
                        //  if($total=="3000"){
                        //         $_POST['Renew_date'] = "9999-12-31";
                        //     }else{
                        //         $_POST['Renew_date'] = $renew;
                        //     }

                            $MemberModel->update($opts);
                        unset($_POST['amount']);

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['donation'] = $_POST['donation'] ?? 0;
                        
                        $opts['amount'] = $price['total'] - (float)($_POST['donation'] ?? 0);
                        $opts['total'] = $price['total'];
                        $opts['stripe_product'] = $payment->description;
                        $opts['payment_status'] = 'confirmed';
                        $opts['payment_timestamp'] = time();
                        
                        date_default_timezone_set("America/Chicago");
                        $today = date("Y/m/d");
                        $_POST['pay_date']= $today;
                        $_POST['pay_type']= 'REGISTRATION';
                         if ($cat == 'GD') {
                             $opts['Category'] = 'GM';
                             $_POST['pay_for'] = 'DB / HDBS Annual General Membership (GM)';
                         } else {
                             $_POST['pay_for'] = 'DB / HDBS Annual Maintenance';
                         }

                       $MemberModel->update(array_merge($opts, $_POST));
					    					
                       //echo '<script>alert("Payment Successfully")</script>';
                                               
                        $data = array();
                        

                        $data['member_id'] = $id;

                        $data['Createdon'] = date('Y-m-d H:i:s');

                        if($this->isMember()){
                            $data['Updatedby'] = $this->getMemberId();
                        }else{
                            $data['Updatedby'] = $this->getUserId();
                        }

                        $data['Status'] = 'P';

                        $MemberLogModel->save($data);
                        
                        $this->tpl['arr'] = $MemberModel->get($id);	
                       // Util::redirect(INSTALL_URL . "Member/membermaintenance/" .$_POST['ID']);
                    } else {

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;
                        
                        $MemberModel->update($opts);

                        $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                    }
                
                } catch (Exception $ex) {
                    $_SESSION['status'] = $ex->getMessage();
                }
            }
             else{
            $_SESSION['status'] = 'An error occurred, please try again!';
           }
        }
    }
   
function memberlookup() {

        GzObject::loadFiles('Model', array('Member', 'ConfirmCode', 'MemberLog', 'Country', 'Donation', 'idnumbers'));
        $MemberModel = new MemberModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberLogModel = new MemberLogModel();
        $CountryModel = new CountryModel();
        $DonationModel = new DonationModel();
        $idnumbersModel = new idnumbersModel();
        $arr= $CountryModel->getCountry();
        $this->tpl['Country'] =  $arr;
        //$member = $MemberModel->get($_GET['ID'] ?? '');
        if ($_GET['ID'] ?? '' != 0) {
            $member = $MemberModel->getbymemberid($_GET['ID'] ?? '');
            $this->tpl['arr'] = $member;
        }
        $user = $this->getUser();
         $id = $_POST['idunique'] ?? '';

        if (!empty($_POST['pay_usermaintenance']) && !empty($id)) {
            if (empty($_SESSION['otp_verified_member'])) {
                $_SESSION['status'] = 'Member verification required. Please complete OTP verification before submitting.';
                Util::redirect(INSTALL_URL . 'Member/memberlookup');
                return;
            }
            $_POST['demmember'] = $_SESSION['otp_verified_member'];
            $spouse = $_POST['spousename'] ?? '';
            $newspousename =    explode(" ",$spouse);
            $spousefirst = $newspousename[0] ?? '';
            $spouselast = $newspousename[1] ?? '';
            $_POST['Sp_FName'] = $spousefirst;
            $_POST['Sp_LName'] = $spouselast;

          $memberna = $_POST['membername'] ?? '';
          $newspousename = explode(" ",$memberna);
          $memberfirst = $newspousename[0] ?? '';
          $memberlast = $newspousename[1] ?? '';
          $membermiddle = $newspousename[2] ?? '';

          $_POST['F_Name'] = $memberfirst;
          $_POST['L_Name'] = $memberlast;
          $_POST['M_Name'] = $membermiddle; 
            
          $idmember = $_POST['demmember'] ?? '';
          $_POST['Member_id'] = $idmember;

          $id = $_POST['idunique'] ?? '';
           // $id = $_POST['ID'] ?? '';
           // for generate oid
            //$oid= Util::incrementalHash(4);
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            //$_POST['oid']  = $maxoid;
           $oid  = $maxoid;

        // end generate oid for

            $cat = $_POST['membercategory'] ?? '';

             if (($_POST['Payment_method'] ?? '') == 'others') {

                $opts = array();
                $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                $arr = $ConfirmCodeModel->getAll($opts);
                $cmCode=$_POST['code'] ?? '';
                $arr= $ConfirmCodeModel->UpdateCode($cmCode);
                $_POST['transaction_id'] =  $cmCode;
                if ($oid !=null) {
                    $opts = array();
                   $opts['id'] = $id;
                    $_POST['ID'] =$_POST['idunique'];
                    $opts['payment_status'] = 'confirmed';
                    $StartingDate =date('Y');
                    $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                    $renew = $newEndingDate."-"."04"."-"."05";
                    $total =$_POST['total'] ?? 0;
                    $_POST['Renew_date'] = $renew;
                    date_default_timezone_set("America/Chicago");
                    $today = date("Y/m/d");
                    $_POST['pay_date']= $today;
                    $_POST['pay_type']= 'REGISTRATION';
                     if ($cat == 'GD') {
                        $opts['Category'] = 'GM';
                         $_POST['pay_for'] = 'DB / HDBS Annual General Membership (GM)';
                     } else {
                         $_POST['pay_for'] = 'DB / HDBS Annual Maintenance';
                     }
                     $datamemberarr = array();
                     $datamemberarr =  array_merge($opts, $_POST) ;
                    $MemberModel->update(array_merge($opts, $_POST));
                    $value = array();
                    $value['oid'] = $oid;
                    $value['Category'] = $datamemberarr['Category'] ?? '';
                    $value['Member_id'] =$datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['F_Name'].''.$datamemberarr['M_Name'].''.$datamemberarr['L_Name'];
                    $value['Amount'] = $datamemberarr['total'];
                    $value['PaymentOption'] = $datamemberarr['Payment_method'];
                    $value['payment_status'] = 'succeeded';
                    $value['transaction_id'] = $datamemberarr['transaction_id'];
                    $value['update_on'] = $datamemberarr['UpdateOn'];
                    $value['pay_date'] = $datamemberarr['pay_date'];
                    $value['pay_type'] = $datamemberarr['pay_type'];
                    $value['pay_for'] = $datamemberarr['pay_for'];
                    $value['Address'] = $datamemberarr['Address2'];
                    $value['Street'] = $datamemberarr['Address1'];
                    $value['State'] = $datamemberarr['State'];
                    $value['Zip_Code'] = $datamemberarr['Zip'];
                    $value['Tele1'] = $datamemberarr['Tele1'];
                    $value['email'] = $datamemberarr['email'];
                    $value['City'] = $datamemberarr['City'];
                    $value['spousename'] = $datamemberarr['Sp_FName'].''.$datamemberarr['Sp_LName'];
                    $DonationModel->SaveDataInDonation($value);
					
                  //$this->sendEmailrenewalmember($datamemberarr);
                    $data = array();
                    $data['member_id'] = $datamemberarr['Member_id'];
                    $data['Createdon'] = date('Y-m-d H:i:s');
                    $data['rate'] = $_POST['total'] ?? '';
                    $categ = $datamemberarr['Category'];
                    if($categ == null){
                        $data['Category'] = $datamemberarr['membercategory'];
                    }
                    else{
                    $data['Category'] = $datamemberarr['Category'];
                    }
                    
                    if ($cat == 'GD') {
                    $data['Status'] = 'R';
                    }else{

					$data['Status'] = 'A';
                    }

                    $MemberLogModel->save($data);
                        if ($cat == 'GD') {
                            $labelname = 'Membership Renewal';
                        } else {
                            $labelname = 'Annual Maintenance';
                        }
					    $Memberid = $_POST['Member_id'] ?? '';
						$email =  $_POST['email'] ?? '';
						$mobile = $_POST['Tele1'] ?? '';
                        echo "<div style='margin-left:23em;' class = 'pay'>
                            <table border='4'  width='585px' style='margin-left:4em;'>
                            <tr>
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                            <tr><td>Order Id</td> <td>" .$oid. "</td> </tr>
                            <tr><td>Member ID</td> <td>" .$Memberid. "</td> </tr>
                           <td>Member Name</td> <td>" .($_POST['F_Name'] ?? '').' ' .($_POST['M_Name'] ?? '').' ' .($_POST['L_Name'] ?? ''). "</td> </tr>
                           <tr><td>Member Email Address</td> <td>" .$email.  "</td> </tr>
                           <tr><td>Member Phone Number</td> <td>" .$mobile. "</td>  </tr>
                            <tr><td>Payment Method</td> <td>Zelle</td>  </tr>
                           <tr><td>$labelname</td> <td><span style= 'color:red;'>$</span>" .$datamemberarr['total']. "</td>  </tr>
                           
                           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                           </tr>";
                           echo "</table>";
                           echo "</div>";
                      $this->sendEmailrenewalmember($datamemberarr, $oid);
                    $currentyear = date("Y");
                     $mobileno = $datamemberarr['Tele1']; 	
                     if ($datamemberarr['Tele1'] != null) {
                        $msg = 'Houston Durga Bari: Your Membership Renewal/Maintenance Payment Request for year '.$currentyear.' details are Member Id: '.  $datamemberarr['Member_id']. ', Member Name: '. $datamemberarr['F_Name'].''.  $datamemberarr['M_Name']. ''.  $datamemberarr['L_Name']. ' , Email: '.  $datamemberarr['email']. ', Amount: $'. $datamemberarr['total'].', Pay For: '. $datamemberarr['pay_for'].', Membership Type: '. ($datamemberarr['membership_type'] ?? '').', Order Id: '. $oid.', Status: ' . $datamemberarr['payment_status']  ;
                        $this->SendSMS($mobileno, $msg);
                    }
                }
            }elseif (($_POST['Payment_method'] ?? '') == 'stripe') {
            $amount = $_POST['total'] ?? 0;
            //$total = $amount;
            require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                $error = '';
                $success = '';

                Stripe::setApiKey($this->tpl["option_arr_values"]["stripe_api_key"]);

                try {
                    if (!isset($_POST['stripeToken'])) {
                        throw new Exception("The Stripe Token was not generated correctly");
                    }
                    if ($cat == 'GD') {
                         $pay_for = 'DB / HDBS Annual General Membership (GM)';
                     } else {
                         $pay_for = 'DB / HDBS Annual Maintenance';
                     }

                    $amount = round($amount * 100);

                    $payment = Stripe_Charge::create(array(
                                "amount" => $amount,
                                "currency" => $this->tpl["option_arr_values"]["currency"],
                                "card" => $_POST['stripeToken'],
                                "description" =>  "Pay For:".$pay_for. ', ' ."Email:".$_POST['email'] . ', ' ."Full Name:". ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? ''),
                                "metadata" => ["orderid" => $oid]
                    ));

                  

                    if ($payment->status == 'succeeded') {

                      
                         $StartingDate =date('Y');
                         $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                         $renew = $newEndingDate."-"."03"."-"."31";
                         $total =$_POST['total'] ?? 0;
                         $opts['id'] = $id;
                         $_POST['Renew_date'] = $renew;
                 
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['donation'] = $_POST['donation'] ?? 0;
                        
                        $opts['amount'] = $amount;
                        $opts['total'] = $_POST['total'] ?? '';
                        $opts['stripe_product'] = $payment->description;
                        $opts['payment_status'] = 'confirmed';
                        $opts['payment_timestamp'] = time();
                        
                        date_default_timezone_set("America/Chicago");
                        $today = date("Y/m/d");
                        $_POST['pay_date']= $today;
                        $_POST['pay_type']= 'REGISTRATION';
                         if ($cat == 'GD') {
                             $opts['Category'] = 'GM';
                             $_POST['pay_for'] = 'DB / HDBS Annual General Membership (GM)';
                         } else {
                             $_POST['pay_for'] = 'DB / HDBS Annual Maintenance';
                         }
                       $_POST['ID'] =$_POST['idunique'];
                       date_default_timezone_set("America/Chicago");
                       $todaydate = date("Y/m/d");
                       $_POST['UpdateOn']= $todaydate;
                        $datamemberarr = array();
                        $datamemberarr =  array_merge($opts, $_POST) ;
                       $MemberModel->update(array_merge($opts, $_POST));
                       
					    $value = array();
                    $value['oid'] = $oid;
                    $value['Category'] = $datamemberarr['Category'] ?? '';
                    $value['Member_id'] =$datamemberarr['Member_id'];
                    $value['MemberName'] = $datamemberarr['F_Name'].''.$datamemberarr['M_Name'].''.$datamemberarr['L_Name'];
                    $value['Amount'] = $datamemberarr['total'];
                    $value['PaymentOption'] = $datamemberarr['Payment_method'];
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
                    $value['Address'] = $datamemberarr['Address2'];
                    $value['Street'] = $datamemberarr['Address1'];
                    $value['State'] = $datamemberarr['State'];
                    $value['Zip_Code'] = $datamemberarr['Zip'];
                    $value['Tele1'] = $datamemberarr['Tele1'];
                    $value['email'] = $datamemberarr['email'];
                    $value['City'] = $datamemberarr['City'];
                    $value['spousename'] = $datamemberarr['Sp_FName'].''.$datamemberarr['Sp_LName'];
                    $DonationModel->SaveDataInDonation($value);
					$this->sendEmailrenewalmember($datamemberarr, $oid);
                     //echo '<script>alert("Payment Successfully")</script>';
                      $currentyear = date("Y");
                     $mobileno = $datamemberarr['Tele1']; 	
                     if ($datamemberarr['Tele1'] != null) {
                        $msg = 'Houston Durga Bari: Your Membership Renewal/Maintenance Payment Request for year '.$currentyear.' details are Member Id: '.  $datamemberarr['Member_id']. ', Member Name: '. $datamemberarr['F_Name'].''.  $datamemberarr['M_Name']. ''.  $datamemberarr['L_Name']. ' , Email: '.  $datamemberarr['email']. ', Amount: $'. $datamemberarr['total'].', Pay For: '. $datamemberarr['pay_for'].', Membership Type: '. ($datamemberarr['membership_type'] ?? '').', Order Id: '. $oid.', Status: ' . $datamemberarr['payment_status']  ;
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
                        if($categ == null){
                            $data['Category'] = $datamemberarr['membercategory'];
                        }
                        else{
                        $data['Category'] = $datamemberarr['Category'];
                        }
                        
                        if ($cat == 'GD') {
                            $data['Status'] = 'R';
                            }else{
        
                            $data['Status'] = 'A';
                            }

                        $MemberLogModel->save($data);
                         if ($cat == 'GD') {
                            $labelname = 'Membership Renewal';
                        } else {
                            $labelname = 'Annual Maintenance';
                        }
                        echo "<div style='margin-left:23em;' class = 'pay'>
                            <table border='4'  width='585px' style='margin-left:4em;'>
                            <tr>
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                          
                             <tr>
                            <td>Order Id</td> <td>" .$oid. "</td> </tr>
                            <tr>
							<td>Member ID</td> <td>" .$datamemberarr['Member_id']. "</td> </tr>
                            <tr><td>Member Name</td> <td>" .$datamemberarr['F_Name'].' ' .$datamemberarr['M_Name'].' ' .$datamemberarr['L_Name']. "</td> </tr>
                           <tr><td>Member Email Address</td> <td>" .$datamemberarr['email'].  "</td> </tr>
                           <tr><td>Member Phone Number</td> <td>" .$datamemberarr['Tele1']. "</td>  </tr>
                             <tr><td>Payment Method</td> <td>Credit Card</td>  </tr>
                            <tr><td>$labelname</td> <td><span style= 'color:red;'>$</span>" .$datamemberarr['total']. "</td>  </tr>
                           <tr><td>Transaction id</td> <td>" .$datamemberarr['transaction_id']. "</td>  </tr>
                           <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                           </tr>";
                           echo "</table>";
                           echo "</div>";
                           echo "<a style='margin-left:5em;' href='" . INSTALL_URL . "Member/memberlookup' >Go to home</a>";
                           
                       // $this->tpl['arr'] = $MemberModel->get($id);	
                       // Util::redirect(INSTALL_URL . "Member/membermaintenance/" .$_POST['ID']);
                    } else {

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;
                        
                        $MemberModel->update($opts);

                        $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                    }
                
                } catch (Exception $ex) {
                    $_SESSION['status'] = $ex->getMessage();
                }
            }
             else{
            $_SESSION['status'] = 'An error occurred, please try again!';
           }
           exit();
        }
    }
   

    function index() {
        // GzObject::loadFiles('Model', array('Member'));
        // $MemberModel = new MemberModel();
        GzObject::loadFiles('Model', array('ltdytdmember', 'Member'));
        $ltdytdmemberModel = new ltdytdmemberModel();
        $MemberModel = new MemberModel();
        
        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }
        
        $searchOpts = array();

        if (!empty($_POST['Member_id'])) {
            $searchOpts['Member_id LIKE :search_Member_id'] = array(':search_Member_id' => "%" . ($_POST['Member_id'] ?? '') . "%");
        }
        if (!empty($_POST['F_Name'])) {
            $searchOpts['F_Name LIKE :search_F_Name'] = array(':search_F_Name' => "%" . ($_POST['F_Name'] ?? '') . "%");
        }
        if (!empty($_POST['Sp_FName'])) {
            $searchOpts['Sp_FName LIKE :search_Sp_FName'] = array(':search_Sp_FName' => "%" . ($_POST['Sp_FName'] ?? '') . "%");
        }
        if (!empty($_POST['Category'])) {
            $searchOpts['Category LIKE :search_Category'] = array(':search_Category' => "%" . ($_POST['Category'] ?? '') . "%");
        }
        if (!empty($_POST['Email'])) {
            $searchOpts['email LIKE :search_email'] = array(':search_email' => "%" . ($_POST['Email'] ?? '') . "%");
        }
        if (!empty($_POST['status'])) {
            $searchOpts['status = :search_status'] = array(':search_status' => $_POST['status']);
        }
        // $this->tpl['active'] = $ltdytdmemberModel->getAll($opts);  memberGM
        $this->tpl['active'] = $ltdytdmemberModel->memberGM($searchOpts);

        // $this->tpl['life'] = $ltdytdmemberModel->getAll($opts);
        $this->tpl['life'] = $ltdytdmemberModel->memberLM($searchOpts);

        // $this->tpl['benefactors'] = $ltdytdmemberModel->getAll($opts);
        $this->tpl['benefactors'] = $ltdytdmemberModel->memberBF($searchOpts);
        
         $this->tpl['ctmemeber'] = $ltdytdmemberModel->ctmember($searchOpts);

        $inactiveOpts = array_merge($searchOpts, array(
            'status = :inactive_status' => array(':inactive_status' => "F")
        ));
        $this->tpl['inactive'] = $ltdytdmemberModel->getAll($inactiveOpts);
        
        //$opts = array();
        //$opts['status = :status'] = array(':status' => "E");
        $this->tpl['expired'] = $ltdytdmemberModel->memberExpired($searchOpts);
        
        $this->tpl['activeGD'] = $ltdytdmemberModel->memberGD($searchOpts);
        
        $this->tpl['GCactive'] = $ltdytdmemberModel->GCmember($searchOpts);
        
        $this->tpl['All'] = $ltdytdmemberModel->All($searchOpts);
        
        $this->tpl['inactiveMembers'] = $ltdytdmemberModel->getInactiveMembers($searchOpts);
        $this->tpl['gcDuplicateMembers'] = $MemberModel->getActiveGcMemberDuplicates();
        

    }

    function markGcDuplicateInactive() {
        if (!$this->isLoged()) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }

        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();
        $gcId = $_POST['gc_id'] ?? ($_GET['gc_id'] ?? '');

        if ($MemberModel->deactivateGcDuplicateById($gcId)) {
            $_SESSION['status'] = 'GC duplicate marked inactive successfully.';
        } else {
            $_SESSION['status'] = 'Unable to mark GC duplicate inactive.';
        }

        Util::redirect(INSTALL_URL . "Member/index");
    }


    function delete() {
        $this->isAjax = true;

        $id = $_REQUEST['id'] ?? '';

        GzObject::loadFiles('Model', array('Booking', 'Member'));
        $MemberModel = new MemberModel();

        $MemberModel->deleteFrom($MemberModel->getTable())
                ->where('id', $id)->execute();

        $this->index();
    }

    function deleteImage() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();

        if (!empty($_POST['ID'])) {

            $ID = $_POST['ID'] ?? '';

            $member = $MemberModel->get($ID);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $member['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $MemberModel->update(array_merge($_POST, $data));
        }

        $opts = array();

        $this->tpl['arr'] = $MemberModel->getAll($opts, 'ID desc');
    }

    function deleteEditedImage() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();

        if (!empty($_POST['id'])) {

            $ID = $_POST['id'] ?? '';

            $member = $MemberModel->get($ID);

            $dest = INSTALL_PATH . UPLOAD_PATH . "avatar/thumb/" . $member['avatar'];
            if (is_file($dest)) {
                unlink($dest);
            }

            $data = array();
            $data['avatar'] = '';

            $MemberModel->update(array_merge($_POST, $data));
        }
    }

     public function export()
    {
	    $this->isAjax = true;
        $type= $_GET['ID'] ?? '';
		
        GzObject::loadFiles('Model', array('Member','ltdytdmember'));
        $MemberModel = new MemberModel();
        $ltdytdmemberModel = new ltdytdmemberModel();
		
        $opts = array();
		if($type=="GM"){
            $query = $ltdytdmemberModel->memberGM($type);
        }
		else if($type=="LM"){
            $query = $ltdytdmemberModel->memberLM($type);
        }
		else if($type=="BF"){
            $query = $ltdytdmemberModel->memberBF($type);
        }
		else if($type=="CT"){
            $query = $ltdytdmemberModel->ctmember($type);
        }
		else if($type=="GD"){
            $query = $ltdytdmemberModel->memberGD($type);
        }
        else if($type=="GC"){
            $query = $ltdytdmemberModel->GCmember($type);
        }
         else if($type=="All"){
             $query = $ltdytdmemberModel->All($type);
         }
        else if($type=="F"){
            $query = $ltdytdmemberModel->pendingmember($type);
            
        }
        else if($type=="E"){
            $query = $ltdytdmemberModel->memberExpired($type);
        }
        else if($type=="inactiveMembers"){
            $query = $ltdytdmemberModel->getInactiveMembers($type);
        }
        
        $data = $query;

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=MEMBER_export.csv');

        $output = fopen('php://output', 'w');

        if (!empty($data)) {
            $columns = array_keys($data[0]); 
            fputcsv($output, $columns, ',', '"', '\\');
        }

        foreach ($data as $row) {
            fputcsv($output, $row, ',', '"', '\\');
        }

        fclose($output);
        exit;
    }
    
    function exportprevious() {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Booking', 'Member'));
        $MemberModel = new MemberModel();
        //$BookingSlotModel = new BookingSlotModel();

        $output = "";

        $query = $MemberModel->from($MemberModel->getTable());

        $members = $query->fetchAll();

        if (empty($members)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

        foreach ($members[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($members as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'] ?? '';
            $slots = $MemberModel->getAll($opts);

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

        $filename = "member_" . time() . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        print $output; // CSV download — htmlspecialchars would corrupt the content
        exit;
    }

    function pay() {
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();

        $user = $this->getUser();

        $this->tpl['arr'] = $MemberModel->get($user['ID']);
    }

    function checkout() {

        GzObject::loadFiles('Model', array('Member', 'ConfirmCode', 'MemberLog'));
        $MemberModel = new MemberModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberLogModel = new MemberLogModel();

        $user = $this->getUser();
        
        $this->tpl['arr'] = $user;

        if (!empty($_POST['pay_user']) && !empty($_POST['ID'])) {

            // Rate limit: block more than 5 payment submissions per minute from the same IP
            $ip = RateLimit::clientIp();
            if (RateLimit::isBlocked('payment', $ip)) {
                Util::redirect(INSTALL_URL . "Member/pay");
                return false;
            }
            RateLimit::record('payment', $ip);

            $id = $user['ID'];
            $cat = $_POST['membercategory'] ?? '';
            if($cat == 'GM'){
                  $StartingDate =date('Y');
                $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                $renew = $newEndingDate."-"."03"."-"."31";
                $total =$_POST['total'] ?? 0;
                $opts['id'] = $id;
                if($total=="3000"){
                       $_POST['Renew_date'] = "9999-12-31";
                   }else{
                       $_POST['Renew_date'] = $renew;
                   }
                $MemberModel->update(array_merge($_POST));
                Util::redirect(INSTALL_URL . "Member/edit/" . ($_POST['ID'] ?? ''));
            }
            else{
             if (($_POST['Payment_method'] ?? '') == 'others') {
                    
                $opts = array();
                $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                $arr = $ConfirmCodeModel->getAll($opts);

                if (!empty($arr[0])) {
                    $opts = array();
                    $opts['id'] = $id;
                    $opts['payment_status'] = 'confirmed';

                    $MemberModel->update($opts);

                    $data = array();
                    $data['rate'] = $_POST['rate'] ?? '';

                    switch($_POST['rate'] ?? ''){
                        case 'gmi_1':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmi_4':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmf_1':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmf_4':
                            $data['Category'] = 'GM';
                            break;
                        case 'lm':
                            $data['Category'] = 'LM';
                            break;
                        case 'bf':
                            $data['Category'] = 'BF';
                            break;
                        case 'pm':
                            $data['Category'] = 'CT';
                            break;
                        case 'lm_h':
                            $data['Category'] = 'LM';
                            break;
                    }

                    $data['member_id'] = $id;

                    $data['Createdon'] = date('Y-m-d H:i:s');

                    if($this->isMember()){
                        $data['Updatedby'] = $this->getMemberId();
                    }else{
                        $data['Updatedby'] = $this->getUserId();
                    }

                    $data['Status'] = 'P';

                    $MemberLogModel->save($data);
                }
            }elseif (($_POST['Payment_method'] ?? '') == 'stripe') {
                
                $price = $this->calculateMemberPrice();
                
                $amount = $price['total'];

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
                                "description" => $_POST['email'] . ', ' . ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '')
                    ));

                    $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                    $this->tpl['payment']['amount'] = $payment->amount;
                    $this->tpl['payment']['status'] = $payment->status;
                    $this->tpl['payment']['currency'] = $payment->currency;

                    if ($payment->status == 'succeeded') {

                      
                        $StartingDate =date('Y');
                         $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                         $renew = $newEndingDate."-"."03"."-"."31";
                         $total =$_POST['total'] ?? 0;
                         $opts['id'] = $id;
                         if($total=="3000"){
                                $_POST['Renew_date'] = "9999-12-31";
                            }else{
                                $_POST['Renew_date'] = $renew;
                            }
                     

                            $MemberModel->update($opts);
                        unset($_POST['amount']);

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['donation'] = $_POST['donation'] ?? 0;
                        
                        $opts['amount'] = $price['total'] - (float)($_POST['donation'] ?? 0);
                        $opts['total'] = $price['total'];
                        $opts['stripe_product'] = $payment->description;
                        $opts['payment_status'] = 'confirmed';
                        $opts['payment_timestamp'] = time();
                        
                        switch($_POST['rate'] ?? ''){
                            case 'gmi_1':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmi_4':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmf_1':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmf_4':
                                $opts['Category'] = 'GM';
                                break;
                            case 'lm':
                                $opts['Category'] = 'LM';
                                break;
                            case 'bf':
                                $opts['Category'] = 'BF';
                                break;
                            case 'pm':
                                $opts['Category'] = 'CT';
                                break;
                            case 'lm_h':
                                $opts['Category'] = 'LM';
                                break;
                        }

                       $MemberModel->update(array_merge($opts, $_POST));
                                      
                        $data = array();
                        $data['rate'] = $_POST['rate'] ?? '';

                        switch($_POST['rate'] ?? ''){
                            case 'gmi_1':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmi_4':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmf_1':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmf_4':
                                $data['Category'] = 'GM';
                                break;
                            case 'lm':
                                $data['Category'] = 'LM';
                                break;
                            case 'bf':
                                $data['Category'] = 'BF';
                                break;
                            case 'pm':
                                $data['Category'] = 'CT';
                                break;
                            case 'lm_h':
                                $data['Category'] = 'LM';
                                break;
                        }

                        $data['member_id'] = $id;

                        $data['Createdon'] = date('Y-m-d H:i:s');

                        if($this->isMember()){
                            $data['Updatedby'] = $this->getMemberId();
                        }else{
                            $data['Updatedby'] = $this->getUserId();
                        }

                        $data['Status'] = 'P';

                        $MemberLogModel->save($data);
                        
                        $this->tpl['arr'] = $MemberModel->get($id);
                    } else {

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;
                        
                        $MemberModel->update($opts);

                        $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                    }
                
                } catch (Exception $ex) {
                    $_SESSION['status'] = $ex->getMessage();
                }
            }
             else{
            $_SESSION['status'] = 'An error occurred, please try again!';
           }
        }
    }
    }

    function checkoutold1() {

        GzObject::loadFiles('Model', array('Member', 'ConfirmCode', 'MemberLog'));
        $MemberModel = new MemberModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $MemberLogModel = new MemberLogModel();

        $user = $this->getUser();
        
        $this->tpl['arr'] = $user;

        if (!empty($_POST['pay_user']) && !empty($_POST['ID'])) {

            // Rate limit: block more than 5 payment submissions per minute from the same IP
            $ip = RateLimit::clientIp();
            if (RateLimit::isBlocked('payment', $ip)) {
                Util::redirect(INSTALL_URL . "Member/pay");
                return false;
            }
            RateLimit::record('payment', $ip);

            $id = $user['ID'];

            if (($_POST['Payment_method'] ?? '') == 'others') {
                    
                $opts = array();
                $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                $arr = $ConfirmCodeModel->getAll($opts);

                if (!empty($arr[0])) {
                    $opts = array();
                    $opts['id'] = $id;
                    $opts['payment_status'] = 'confirmed';

                    $MemberModel->update($opts);

                    $data = array();
                    $data['rate'] = $_POST['rate'] ?? '';

                    switch($_POST['rate'] ?? ''){
                        case 'gmi_1':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmi_4':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmf_1':
                            $data['Category'] = 'GM';
                            break;
                        case 'gmf_4':
                            $data['Category'] = 'GM';
                            break;
                        case 'lm':
                            $data['Category'] = 'LM';
                            break;
                        case 'bf':
                            $data['Category'] = 'BF';
                            break;
                        case 'pm':
                            $data['Category'] = 'CT';
                            break;
                        case 'lm_h':
                            $data['Category'] = 'LM';
                            break;
                    }

                    $data['member_id'] = $id;

                    $data['Createdon'] = date('Y-m-d H:i:s');

                    if($this->isMember()){
                        $data['Updatedby'] = $this->getMemberId();
                    }else{
                        $data['Updatedby'] = $this->getUserId();
                    }

                    $data['Status'] = 'P';

                    $MemberLogModel->save($data);
                }
            }elseif (($_POST['Payment_method'] ?? '') == 'stripe') {
                
                $price = $this->calculateMemberPrice();
                
                $amount = $price['total'];

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
                                "description" => $_POST['email'] . ', ' . ($_POST['F_Name'] ?? '') . ' ' . ($_POST['L_Name'] ?? '')
                    ));

                    $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                    $this->tpl['payment']['amount'] = $payment->amount;
                    $this->tpl['payment']['status'] = $payment->status;
                    $this->tpl['payment']['currency'] = $payment->currency;

                    if ($payment->status == 'succeeded') {

                       
                        $renewdate = $_POST['Renew_date'] ?? '';
                       if($renewdate == null){
                        $StartingDate =date('Y');
                         $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
                         $renew = $newEndingDate."-"."03"."-"."31";
                         $total =$_POST['total'] ?? 0;
                         $opts['id'] = $id;
                         if($total=="3000"){
                                $_POST['Renew_date'] = "9999-12-31";
                            }else{
                                $_POST['Renew_date'] = $renew;
                            }
                        }
                        else{
                            $renewdate = $_POST['Renew_date'] ?? '';
                            $newEndingDate =date('Y', strtotime('+1 year', strtotime($renewdate)) );
                            $renew = $newEndingDate."-"."03"."-"."31";
                             $total =$_POST['total'] ?? 0;
                             $opts['id'] = $id;
                             if($total=="3000"){
                                $_POST['Renew_date'] = "9999-12-31";
                            }else{
                                $_POST['Renew_date'] = $renew;
                            }
                        }

                            $MemberModel->update($opts);
                        unset($_POST['amount']);

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['donation'] = $_POST['donation'] ?? 0;
                        
                        $opts['amount'] = $price['total'] - (float)($_POST['donation'] ?? 0);
                        $opts['total'] = $price['total'];
                        $opts['stripe_product'] = $payment->description;
                        $opts['payment_status'] = 'confirmed';
                        $opts['payment_timestamp'] = time();
                        
                        switch($_POST['rate'] ?? ''){
                            case 'gmi_1':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmi_4':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmf_1':
                                $opts['Category'] = 'GM';
                                break;
                            case 'gmf_4':
                                $opts['Category'] = 'GM';
                                break;
                            case 'lm':
                                $opts['Category'] = 'LM';
                                break;
                            case 'bf':
                                $opts['Category'] = 'BF';
                                break;
                            case 'pm':
                                $opts['Category'] = 'CT';
                                break;
                            case 'lm_h':
                                $opts['Category'] = 'LM';
                                break;
                        }

                        $MemberModel->update(array_merge($opts, $_POST));
                        
                        $data = array();
                        $data['rate'] = $_POST['rate'] ?? '';

                        switch($_POST['rate'] ?? ''){
                            case 'gmi_1':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmi_4':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmf_1':
                                $data['Category'] = 'GM';
                                break;
                            case 'gmf_4':
                                $data['Category'] = 'GM';
                                break;
                            case 'lm':
                                $data['Category'] = 'LM';
                                break;
                            case 'bf':
                                $data['Category'] = 'BF';
                                break;
                            case 'pm':
                                $data['Category'] = 'CT';
                                break;
                            case 'lm_h':
                                $data['Category'] = 'LM';
                                break;
                        }

                        $data['member_id'] = $id;

                        $data['Createdon'] = date('Y-m-d H:i:s');

                        if($this->isMember()){
                            $data['Updatedby'] = $this->getMemberId();
                        }else{
                            $data['Updatedby'] = $this->getUserId();
                        }

                        $data['Status'] = 'P';

                        $MemberLogModel->save($data);
                        
                        $this->tpl['arr'] = $MemberModel->get($id);
                    } else {

                        $opts = array();
                        $opts['id'] = $id;
                        $opts['stripe_return'] = $payment->status;
                        $opts['transaction_id'] = $payment->id;
                        $opts['paid_amount'] = $payment->amount;
                        $opts['stripe_product'] = $payment->description;
                        
                        $MemberModel->update($opts);

                        $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';
                    }
                } catch (Exception $ex) {
                    $_SESSION['status'] = $ex->getMessage();
                }
            }
        }else{
            $_SESSION['status'] = 'An error occurred, please try again!';
        }
    }
    
    function calculatePrice(){
        $this->isAjax = true;
        
        $price = $this->calculateMemberPrice();

        header("Content-Type: application/json", true);
        print json_encode($price); // JSON response — htmlspecialchars would corrupt the output
    }


    function membersReport()
    {
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();
        
        
         if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }

        $opts = array();
        $this->tpl['gd'] = $MemberModel->GD_MemberReport();
        $this->tpl['otherCategory'] = $MemberModel->othersCategoryReport();
    }


    function GD_ReportExport()
    {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();

        $output = "";

        $opts = array();
        $arr = $MemberModel->GD_MemberReport(array_merge($opts));
        $members = $arr;

        foreach (($members[0] ?? []) as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach (($members ?: []) as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'] ?? '';
            foreach ($value as $k => $v) {
                if ($k == 'date') {
                    $output .= '"' . date("Y-m-d H:i", $v) . '",';
                } else {
                    $output .= '"' . $v . '",';
                }
            }

            $output .= "\n";
        }

        $filename = "RenewReport_" . time() . ".csv";

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);

        print $output; // CSV download — htmlspecialchars would corrupt the content
        exit;
    }

    function otherCategoryReportExport()
    {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();
        $output = "";

        $opts = array();

        $arr = $MemberModel->othersCategoryReport(array_merge($opts));

        $members = $arr;

        foreach ($members[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($members as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'] ?? '';

            foreach ($value as $k => $v) {
                if ($k == 'date') {
                    $output .= '"' . date("Y-m-d H:i", $v) . '",';
                } else {
                    $output .= '"' . $v . '",';
                }
            }

            $output .= "\n";
        }

        $filename = "MaintenanceReport_" . time() . ".csv";

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);

        print $output; // CSV download — htmlspecialchars would corrupt the content
        exit;
    }

}

?>





