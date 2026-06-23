<?php

require_once CONTROLLERS_PATH . 'App.php';
require __DIR__ . '/Twillio/vendor/autoload.php';
use Twilio\Rest\Client;

class Badges extends App {

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
     
        // if (!($this->isLoged()) && ($_REQUEST['action'] ?? '') != 'login') {
        //     $_SESSION['err'] = 2;
        //     Util::redirect(INSTALL_URL . "Badges/index");
        // }
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
        $this->js[] = array('file' => 'jquery.signature.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery.ui.touch-punch.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery.ui.touch-punch.min.js', 'path' => JS_PATH);
        if (($_REQUEST['action'] ?? '') == 'send') {
            $this->js[] = array('file' => 'jquery/tinymce/tinymce.min.js', 'path' => LIBS_PATH);
        }
          $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
        //$this->js[] = array('file' => 'GzBooking.js', 'path' => JS_PATH);
       // $this->js[] = array('file' => 'GzBooking.js', 'path' => JS_PATH);
    }
    
    function details() {
        GzObject::loadFiles('Model', array('Member'));
        $MemberModel = new MemberModel();
        
        $ID = $_GET['id'] ?? '';
        
        $this->tpl['arr'] = $MemberModel->get($ID);
    }
    
    function create() {
        GzObject::loadFiles('Model', array('Parkingdata'));
        $ParkingdataModel = new ParkingdataModel();
        // $CountryModel = new CountryModel();
        // $arr= $CountryModel->getCountry();
        // $this->tpl['Country'] =  $arr;
        if (!empty($_POST['create_parking'])) {
            $ParkingdataModel->Decal  =$_POST['Decal'] ?? '';
            $ParkingdataModel->Pending_Issues  =$_POST['Pending_Issues'] ?? '';
            $ParkingdataModel->parking_assigned  =$_POST['parking_assigned'] ?? '';
            $ParkingdataModel->Name_Authorized  =$_POST['Name_Authorized'] ?? '';
            $ParkingdataModel->Date  =$_POST['Name_Authorized'] ?? '';
            $ParkingdataModel->signature  =$_POST['Name_Authorized'] ?? '';


            //$folderPath = $_FILES['sig'];
            require_once APP_PATH . 'helpers/uploader/class.upload.php';
            $folderPath = "../application/web/sig/";
            $image_parts = explode(";base64,", $_POST['signed'] ?? '');
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = $folderPath . uniqid() . '.'.$image_type;
            file_put_contents($file, $image_base64);
            $data = array();
           // $data['Application_date'] = date('Y-m-d H:i:s');
            // $StartingDate =date('Y');
            // $newEndingDate = date("Y", strtotime(date("Y", strtotime($StartingDate)) . " + 365 day"));
            // $renew = $newEndingDate."-"."01"."-"."01";
            // $total =$_POST['total'] ?? '';
            // if($total=="3000"){
            //     $data['Renew_date'] = "9999-12-31";
            // }else{
            //     $data['Renew_date'] = $renew;
            // }
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
            
            // if (($_POST['status'] ?? '') == 'T') {
            //     $pasword = Util::incrementalHash(10);
            //     $data['password'] = md5($pasword);
            // }
            
            // switch($_POST['rate']){
            //     case 'gmi_1':
            //         $data['Category'] = 'GM';
            //         break;
            //     case 'gmi_4':
            //         $data['Category'] = 'GM';
            //         break;
            //     case 'gmf_1':
            //         $data['Category'] = 'GM';
            //         break;
            //     case 'gmf_4':
            //         $data['Category'] = 'GM';
            //         break;
            //     case 'lm':
            //         $data['Category'] = 'LM';
            //         break;
            //     case 'bf':
            //         $data['Category'] = 'BF';
            //         break;
            //     case 'pm':
            //         $data['Category'] = 'CT';
            //         break;
            //     case 'lm_h':
            //         $data['Category'] = 'LM';
            //         break;
            // }
            
            // $data['Member_id'] = $MemberModel->getMax() + 1;
            
            // if(empty($_POST['status'])){
            //     $_POST['status'] = 'F';
            // }
            //$ID = $volunteersModel->update(array_merge($data, $_POST));
            $ID = $ParkingdataModel->save(array_merge($_POST, $data));
            
            // GzObject::loadFiles('Model', array('MemberLog'));
            // $MemberLogModel = new MemberLogModel();

            // $data = array();
            // $data['rate'] = $_POST['rate'] ?? '';

            // switch($_POST['rate']){
            //     case 'gmi_1':
            //         $data['Category'] = 'GM';
            //         break;
            //     case 'gmi_4':
            //         $data['Category'] = 'GM';
            //         break;
            //     case 'gmf_1':
            //         $data['Category'] = 'GM';
            //         break;
            //     case 'gmf_4':
            //         $data['Category'] = 'GM';
            //         break;
            //     case 'lm':
            //         $data['Category'] = 'LM';
            //         break;
            //     case 'bf':
            //         $data['Category'] = 'BF';
            //         break;
            //     case 'pm':
            //         $data['Category'] = 'CT';
            //         break;
            //     case 'lm_h':
            //         $data['Category'] = 'LM';
            //         break;
            // }

            // $data['member_id'] = $ID;

            // $data['Createdon'] = date('Y-m-d H:i:s');
            // $data['Application_date'] = date('Y-m-d H:i:s');


            // if($this->isMember()){
            //     $data['Updatedby'] = $this->getMemberId();
            // }else{
            //     $data['Updatedby'] = $this->getUserId();
            // }
            
            
            
            $this->tpl['arr'] = $ParkingdataModel->get($ID);
            
            Util::redirect(INSTALL_URL . "Badges/index/");
        }
    }
    
     // Function for Matrix index
  function matrix() {

    GzObject::loadFiles('Model', array('Matrixview'));
    $MatrixviewModel = new MatrixviewModel();
 
    $opts = array();
    $matrixarr = $MatrixviewModel->getAll($opts);
    $this->tpl['matrixarr'] = $matrixarr;
  }
  
  // matrix export functionality
function matrixexport() {

    $this->isAjax = true;

    GzObject::loadFiles('Model', array('Matrixview'));
        $MatrixviewModel = new MatrixviewModel();

    $output = "";

    $query = $MatrixviewModel->from($MatrixviewModel->getTable());

    $parking = $query->fetchAll();

    if (empty($parking)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

    foreach ($parking[0] as $k => $v) {
        $output .= '"' . $k . '",';
    }
    $output .= "\n";

    foreach ($parking as $key => $value) {

        $opts = array();
       // $opts['member_id'] = $value['id'];
        $slots = $MatrixviewModel->getAll($opts);

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

    $filename = "MatrixData_" . time() . ".csv";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    echo $output;
    exit;
}

  
    
    function edit() {
        //my twillo account setting
                  //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
                  //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
                //hdbs twillo account setting
                 $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
                 $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
                 $client = new Client($sid, $token);
               
                      GzObject::loadFiles('Model', array('Parkingdataview', 'Parkingdata'));
                       $ParkingdataModel  = new ParkingdataModel();
                       $ParkingdataviewModel = new ParkingdataviewModel();
                      
                     
                       if (!empty($_POST['edit_parking'])) 
                      {   
                           $ID = $_POST['ID'] ?? '';
                          $decal = $_POST['Decal'] ?? '';
                          $name=explode("-",$decal);
                          $first = $name[0];
                          $last = $name[1];
                          if($this->isVolunteer() == 'true' && $last == null){
                              echo '<script>alert("Please Assign Decal")</script>';
                              Util::redirect(INSTALL_URL . "Badges/edit/$ID");
                          }
                          
                           $Parkingdataview = $ParkingdataviewModel->get($_POST['ID'] ?? '');
                           $data = array();
                           $parkingdataviewID = $_POST['ID'] ?? '';
                          if (!empty($_POST['signed']))
                          {
                       
                          require_once APP_PATH . 'helpers/uploader/class.upload.php';
                          //$thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';
                         // $folderPath = "../application/web/sig/";
                          $folderPath = "esign/";
                          $image_parts = explode(";base64,", $_POST['signed'] ?? '');
                          $image_type_aux = explode("image/", $image_parts[0]);
                          $image_type = $image_type_aux[1];
                          $image_base64 = base64_decode($image_parts[1]);
                          $file = $folderPath ."Member_id_" .($_POST['Member_id'] ?? '') . '.'.$image_type;
                          $filename = "Member_id_" .($_POST['Member_id'] ?? '') . '.'.$image_type;
                          //$ParkingdataModel->Signature  =$file;
                          $_POST['Signature']  = $filename;
                          $_POST['Registration_Status']  = "Yes";
                          $_POST['Parking_Basis']  = "Sponsor";
                          file_put_contents($file, $image_base64);
                          }
                          $spamount = $_POST['sponsor_amount'] ?? '';
                          $ytd = $_POST['donation'] ?? '';

                        if( $spamount >= 400 ){
                              
                              
                             if($this->isParkingAdmin() == 'true'){
              
                             if($last!=null){
                                   $_POST['status'] = 'Decal Assigned';
                                 }else{
                                 $_POST['status'] = 'Parking Lot Assigned';
                                 }
                               
                                   }
                                  else{
                                    $_POST['status'] = 'Decal Assigned';
                                  
                                   }
              
                          if (!empty($_POST['parkingid'])) {
                         
                           $ID = $ParkingdataModel->update(array_merge($data, $_POST));
                          
                          }
                          else{
                            $ID = $ParkingdataModel->save(array_merge($_POST, $data));     
                          }
                           $ParkingdataviewModel->saveParkingInvoice($parkingdataviewID);
                      }
                      else if( $spamount < 400)
                      {
                          $_POST['status'] = '';
                          $_POST['Decal'] = '';
                          $_POST['parking_assigned'] = '';
                          $_POST['Spon_Category'] = 'General';
                          $_POST['Date'] = '';
                          $_POST['Name_Authorized'] = '';
                          $_POST['Pending_Issues'] = '';
                          $last = '';
                          
                          if (!empty($_POST['parkingid'])) {
                         
                              $ID = $ParkingdataModel->update(array_merge($data, $_POST));
                             //Util::redirect(INSTALL_URL . "Badges/index/");
                             
                             }
                             else{
                               $ID = $ParkingdataModel->save(array_merge($_POST, $data));     
                               //Util::redirect(INSTALL_URL . "Badges/index");
                            }
                            //echo '<script>alert("General member are not allowed for parking")</script>';
                           // Util::redirect(INSTALL_URL . "Badges/index/");
                            
      
                      }
                      else
                      {


            
                        if($this->isParkingAdmin() == 'true'){
              
                           if($last!=null){
                                   $_POST['status'] = 'Decal Assigned';
                                 }else{
                                 $_POST['status'] = 'Parking Lot Assigned';
                                 }
                               
                                   }
                                  else{
                                    $_POST['status'] = 'Decal Assigned';
                                  
                                   }
            
                        if (!empty($_POST['parkingid'])) {
                       
                         $ID = $ParkingdataModel->update(array_merge($data, $_POST));
                        
                        }
                        else{
                          $ID = $ParkingdataModel->save(array_merge($_POST, $data));     
                        }
                         $ParkingdataviewModel->saveParkingInvoice($parkingdataviewID);
            
                         }
                    if($last != null){        
                    $parking = $_POST;
                    $Mid = $_POST['Member_id'] ?? '';
                    $ID = $_POST['ID'] ?? '';
                    $mobileno = $parking['Tele1'];

                      $file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                       $path = INSTALL_URL . 'parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
                        //$path = 'http://localhost/final/parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';    
                         $result = $this->sendEmail($parking, $path);
                         if ($parking['Tele1'] != null) {

                          $msg = 'Houston DurgaBari: Your Parking Details are MemberID: '. $parking['Member_id'].', Full Name: '. $parking['F_Name'].' '.$parking['L_Name'] .', DecalNO: ' . $parking['Decal'] . ', ParkingAssigned: ' . $parking['parking_assigned'] . ' on ' . $parking['Date'] . '. Click here  for receipt:' . $path;
                          $message = $client->messages->create(
                               // Where to send a text message (your cell phone?)
                               '+1'.$mobileno.'',
                                 //'+91'.'8699399143'.'',
                               array(
                                  // 'from' => '+16184182672',
                                   'from' => '+12815016454',
                                   'body' => $msg
                         
                               )
                               );
                         }
                    }
                   Util::redirect(INSTALL_URL . "Badges/index/");
                      
              
                   }
                      
                      $ID = $_GET['ID'] ?? '';
                      $arr = $ParkingdataviewModel->get($ID);
              
                      $this->tpl['arr'] = $arr;
                      
                }

    function index() {

        GzObject::loadFiles('Model', array('Parkingdataview','Volunteersdata','Paidparkingview','Badgesdata'));
        $ParkingdataviewModel = new ParkingdataviewModel();
        $VolunteersdataModel = new VolunteersdataModel();
        $PaidparkingviewModel = new PaidparkingviewModel();
        $BadgesdataModel = new BadgesdataModel();
     
        $opts = array();

        if (!empty($_POST['Member_id'])) {
            $opts['Member_id LIKE :Member_id'] = array(':Member_id' => "%" . ($_POST['Member_id'] ?? '') . "%");
        }
        if (!empty($_POST['F_Name'])) {
            $opts['F_Name LIKE :F_Name'] = array(':F_Name' => "%" . ($_POST['F_Name'] ?? '') . "%");
        }
        if (!empty($_POST['Sp_FName'])) {
            $opts['Sp_FName LIKE :Sp_FName'] = array(':Sp_FName' => "%" . ($_POST['Sp_FName'] ?? '') . "%");
        }
        if (!empty($_POST['Category'])) {
            $opts['Category LIKE :Category'] = array(':Category' => "%" . ($_POST['Category'] ?? '') . "%");
        }
        if (!empty($_POST['Email'])) {
            $opts['email LIKE :email'] = array(':email' => "%" . ($_POST['email'] ?? '') . "%");
        }


       $arr = $ParkingdataviewModel->getAll($opts);
       $this->tpl['arr'] = $arr;

// for volunteer parking

       $opts = array();
       $volarr = $VolunteersdataModel->getAll($opts);
       $this->tpl['volarr'] = $volarr;

// for paid parking 

       $opts = array();
       $paidarr = $PaidparkingviewModel->getAll($opts);
       $this->tpl['paidarr'] = $paidarr;



// for assign badges

    $opts = array();
    $badgesarr = $BadgesdataModel->getAll($opts);
    $this->tpl['badgesarr'] = $badgesarr;

       
    }
    
// Function for Paid parking code edit & new
    function Paidparking() {
         //my twillo account setting
       //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
       //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
        //hdbs twillo account setting
        $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
        $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
       $client = new Client($sid, $token);
        GzObject::loadFiles('Model', array('Parkingdata', 'Paidparkingview'));
        $ParkingdataModel  = new ParkingdataModel();
        $PaidparkingviewModel = new PaidparkingviewModel();
       
      
        if (!empty($_POST['edit_paidparking'])) 
       { 
           $id = $_POST['id'] ?? '';
           $decal = $_POST['Decal'] ?? '';
           $name=explode("-",$decal);
           $first = $name[0];
           $last = $name[1];
           if($this->isVolunteer() == 'true' && $last == null){
            echo '<script>alert("Please Assign Decal")</script>';
            Util::redirect(INSTALL_URL . "Badges/Paidparking/$id");
        }
            $Paidparkingview = $PaidparkingviewModel->get($_POST['id'] ?? '');
            $data = array();
            $Paidparkingviewoid = $_POST['id'] ?? '';
           if (!empty($_POST['signed']))
           {
        
           require_once APP_PATH . 'helpers/uploader/class.upload.php';
           //$thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';
           //$folderPath = "../application/web/sig/";
           $folderPath = "esign/";
           $image_parts = explode(";base64,", $_POST['signed'] ?? '');
           $image_type_aux = explode("image/", $image_parts[0]);
           $image_type = $image_type_aux[1];
           $image_base64 = base64_decode($image_parts[1]);
           $file = $folderPath ."oid_" .($_POST['oid'] ?? '') . '.'.$image_type;
           $filename = "oid_" .($_POST['oid'] ?? '') . '.'.$image_type;
           //$ParkingdataModel->Signature  =$file;
           $_POST['Signature']  = $filename;
           $_POST['Registration_Status']  = "Yes";
           $_POST['Parking_Basis']  = "Paid";
           file_put_contents($file, $image_base64);
           }

           if($this->isParkingAdmin() == 'true'){

           if($last!=null){
                $_POST['status'] = 'Decal Assigned';
               }else{
                $_POST['status'] = 'Parking Lot Assigned';
              }
        
            }
           else{
             $_POST['status'] = 'Decal Assigned';
           
            }
           
            
           if (!empty($_POST['parkingid'])) {
           
            $ID = $ParkingdataModel->update(array_merge($data, $_POST));
           
           }
           else{
               
             $decal = $_POST['Decal'] ?? '';
             $name=explode("-",$decal);
             $first = $name[0];
             $last = $name[1];
             if($this->isParkingAdmin() == 'true' && $last == null){
                $_POST['Decal'] = null;

             }
             $ID = $ParkingdataModel->save(array_merge($_POST, $data));     
           

           }
            $PaidparkingviewModel->saveParkingInvoice($Paidparkingviewoid);
          if($last != null){   
           $Parking = $_POST;
           $Mid = $_POST['oid'] ?? '';
           $ID = $_POST['id'] ?? '';
           $mobileno = $Parking['tele'];
           $file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
           $path = INSTALL_URL . 'parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            //$path = 'http://localhost/final/parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            $result = $this->sendEmailPaid($Parking, $path);
            if ($Parking['tele'] != null) {
           $msg = 'Houston DurgaBari: Your Parking Details are OID: '. $Parking['oid'].', Full Name: '. $Parking['name'].' '.$Parking['L_Name'] .', DecalNO: ' . $Parking['Decal'] . ', ParkingAssigned: ' . $Parking['parking_assigned'] . ' on ' . $Parking['Date'] . '. Click here  for receipt:' . $path;
           $message = $client->messages->create(
                // Where to send a text message (your cell phone?)
                '+1'.$mobileno.'',
                //'+91'.'8699399143'.'',
                array(
                       //'from' => '+16184182672',
                      'from' => '+12815016454',
                        'body' => $msg
                    )
            );
            }
          }
          Util::redirect(INSTALL_URL . "Badges/index/");
       }

       
       
       $id = $_GET['id'] ?? '';
       $paidarr = $PaidparkingviewModel->get($id);

       $this->tpl['paidarr'] = $paidarr;
       
    }
    
// Function for volenteer code edit & new
function Volunteers() {
    //my twillo account setting
    //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
    //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
      //hdbs twillo account setting
    $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
    $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
    $client = new Client($sid, $token);
    GzObject::loadFiles('Model', array('Volunteersdata'));
    $VolunteersdataModel  = new VolunteersdataModel();

    if (!empty($_POST['edit_volenteers'])) 
   {   
        $ID = $_POST['ID'] ?? '';
        $decal = $_POST['Decal'] ?? '';
        $name=explode("-",$decal);
        $first = $name[0];
        $last = $name[1];
     if($this->isVolunteer() == 'true' && $last == null){
        echo '<script>alert("Please Assign Decal")</script>';
        Util::redirect(INSTALL_URL . "Badges/Volunteers/$ID");
     }
        $volunteersdataModel = $VolunteersdataModel->get($_POST['ID'] ?? '');
        $data = array();
        $VolunteersID = $_POST['ID'] ?? '';
       if (!empty($_POST['signed']))
       {
    
       require_once APP_PATH . 'helpers/uploader/class.upload.php';
       //$thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';
       //$folderPath = "../application/web/sig/";
       $folderPath = "esign/";
       $image_parts = explode(";base64,", $_POST['signed'] ?? '');
       $image_type_aux = explode("image/", $image_parts[0]);
       $image_type = $image_type_aux[1];
       $image_base64 = base64_decode($image_parts[1]);
       $file = $folderPath ."MID_" .($_POST['MID'] ?? '') . '.'.$image_type;
       $filename = "MID_" .($_POST['MID'] ?? '') . '.'.$image_type;
       $_POST['Signature']  = $filename;
       //$_POST['Registration_Status']  = "Yes";
       //$_POST['Parking_Basis']  = "Sponsor";
       file_put_contents($file, $image_base64);
       }

        if($this->isParkingAdmin() == 'true'){

                if($last!=null){
                $_POST['Status'] = 'Decal Assigned';
               }else{
                $_POST['Status'] = 'Parking Lot Assigned';
              }
        
            }
           else{
             $_POST['Status'] = 'Decal Assigned';
           
            }
                    
        $ID = $VolunteersdataModel->Update(array_merge($data, $_POST));
        $VolunteersdataModel->saveParkingInvoice($VolunteersID);
        if($last != null){   
        $parking = $_POST;
        $Mid = $_POST['MID'] ?? '';
        $ID = $_POST['ID'] ?? '';
        $mobileno = $parking['Tele1'];
        $file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
        $path = INSTALL_URL . 'parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
        //$path = 'http://localhost/final/parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
        $result = $this->sendEmailvolunteer($parking, $path);
        if ($parking['Tele1'] != null) {
        $msg = 'Houston DurgaBari: Your Parking Details are MID: '. $parking['MID'].', Full Name: '. $parking['Volunteer_Name'].' '.$parking['L_Name'] .', DecalNO: ' . $parking['Decal'] . ', ParkingAssigned: ' . $parking['parking_assigned'] . ' on ' . $parking['Date'] . '. Click here  for receipt:' . $path;
        $message = $client->messages->create(
             // Where to send a text message (your cell phone?)
             '+1'.$mobileno.'',
             //'+91'.'8699399143'.'',
             array(
                 //'from' => '+16184182672',
                  'from' => '+12815016454',
                 'body' => $msg
             )
         );
        }
        }
        Util::redirect(INSTALL_URL . "Badges/index/");
   }
   
   $ID = $_GET['ID'] ?? '';
   $volarr  = $VolunteersdataModel->get($ID);
   $this->tpl['volarr'] = $volarr;
   //$this->tpl['arr'] = $arr;
   
}

function export() {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Parkingdataview'));
        $ParkingdataviewModel = new ParkingdataviewModel();

        $output = "";

        $query = $ParkingdataviewModel->from($ParkingdataviewModel->getTable());

        $parking = $query->fetchAll();

        if (empty($parking)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

        foreach ($parking[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($parking as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'];
            $slots = $ParkingdataviewModel->getAll($opts);

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

        $filename = "ParkingSponsor_" . time() . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }
// volunteer export functionality
function Volunteeerexport() {

    $this->isAjax = true;

    GzObject::loadFiles('Model', array('Volunteersdata'));
    $VolunteersdataModel  = new VolunteersdataModel();

    $output = "";

    $query = $VolunteersdataModel->from($VolunteersdataModel->getTable());

    $parking = $query->fetchAll();

    if (empty($parking)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

    foreach ($parking[0] as $k => $v) {
        $output .= '"' . $k . '",';
    }
    $output .= "\n";

    foreach ($parking as $key => $value) {

        $opts = array();
        $opts['member_id'] = $value['id'];
        $slots = $VolunteersdataModel->getAll($opts);

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

    $filename = "ParkingVolunteer_" . time() . ".csv";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    echo $output;
    exit;
}

// Invoice functionality 
function viewInvoice() {
         //my twillo account setting
       //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
       //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
        //hdbs twillo account setting
        $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
        $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
        $client = new Client($sid, $token);
        GzObject::loadFiles('Model', array('Parkingdataview'));
        $ParkingdataviewModel = new ParkingdataviewModel();
        if (!empty($_GET['ID'] ?? '')) {
            $Parking = $ParkingdataviewModel->getparking($_GET['ID'] ?? '');
            $Mid = $Parking['Member_id'];
            $ID = $_GET['ID'] ?? '';
            $file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            
            $path = INSTALL_URL . 'parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            //$path = 'http://localhost/final/parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
           //$result = $this->sendEmail($Parking, $path);
            echo "<script type='text/javascript'>window.open('$path','_self');</script>";
        }
        //$msg = 'Houston DurgaBari: Your Parking Details are MemberID: '. //$Parking['Member_id'].', Full Name: '. $Parking['F_Name'].' '.$Parking['L_Name'] .', DecalNO: ' . $Parking['Decal'] . ', ParkingAssigned: ' . $Parking['parking_assigned'] . ' on ' . $Parking['Date'] . '. Click here  for receipt:' . $path;
       // $message = $client->messages->create(
             // Where to send a text message (your cell phone?)
             //'+1'.$Parking['Tele1'].'',
             //'+91'.'7017618292'.'',
             //array(
                // 'from' => '+19707037189',
                //  'from' => '+12815016454',
                 //'body' => $msg
            // )
         //);
      Util::redirect(INSTALL_URL . "Badges/index/");
    }   


//Volunteers view invoice functionallity
function VolunteersviewInvoice() {
  //my twillo account setting
  //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
  //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
   //hdbs twillo account setting
   $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
   $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
   $client = new Client($sid, $token);
        GzObject::loadFiles('Model', array('Volunteersdata'));
        $VolunteersdataModel  = new VolunteersdataModel();
        if (!empty($_GET['ID'] ?? '')) 
         {
            $Parking = $VolunteersdataModel->getparking($_GET['ID'] ?? '');
            //$test = $_POST['edit_parking'];
            $Mid = $Parking['MID'];
            $ID = $_GET['ID'] ?? '';

         $path = INSTALL_URL . 'parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
           // $path = 'http://localhost/final/parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            //$result = $this->sendEmailvolunteer($Parking, $path);
        echo "<script type='text/javascript'>window.open('$path','_self');</script>";
        }
       // $msg = 'Houston DurgaBari: Your Parking Details are MemberID: '. $Parking['Member_id'].', Full Name: '. $Parking['F_Name'].' '.$Parking['L_Name'] .', DecalNO: ' . $Parking['Decal'] . ', ParkingAssigned: ' . $Parking['parking_assigned'] . ' on ' . $Parking['Date'] . '. Click here  for receipt:' . $path;
       // $message = $client->messages->create(
             // Where to send a text message (your cell phone?)
            //'+1'.$Parking['Tele1'].'',
            // '+91'.'7017618292'.'',
            // array(
                 //'from' => '+19707037189',
               //   'from' => '+12815016454',
               //  'body' => $msg
           //  )
        // );
        Util::redirect(INSTALL_URL . "Badges/index/");
    }

// Paid parking  view invoice functionality
function PaidparkingviewInvoice() {
//my twillo account setting
  $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
  $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
   //hdbs twillo account setting
  // $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
  // $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
   $client = new Client($sid, $token);
        GzObject::loadFiles('Model', array('Paidparkingview'));
        $PaidparkingviewModel = new PaidparkingviewModel();
        if (!empty($_GET['ID'] ?? '')) 
         {
            $Parking = $PaidparkingviewModel->getparking($_GET['ID'] ?? '');
            //$test = $_POST['edit_parking'];
            $Mid = $Parking['oid'];
            $ID = $_GET['id'] ?? '';
            $path = INSTALL_URL . 'parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            //$path = 'http://localhost/final/parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
           //$result = $this->sendEmailPaid($Parking, $path);
         echo "<script type='text/javascript'>window.open('$path','_self');</script>";
        }
    //    $msg = 'Houston DurgaBari: Your Parking Details are MemberID: '. $Parking['Member_id'].', Full Name: '. $Parking['F_Name'].' '.$Parking['L_Name'] .', DecalNO: ' . $Parking['Decal'] . ', ParkingAssigned: ' . $Parking['parking_assigned'] . ' on ' . $Parking['Date'] . '. Click here  for receipt:' . $path;
    //     $message = $client->messages->create(
    //          //Where to send a text message (your cell phone?)
    //         //'+1'.$Parking['Tele1'].'',
    //          '+91'.'8699399143'.'',
    //         array(
    //              'from' => '+16184182672',
    //              //'from' => '+12815016454',
    //             'body' => $msg
    //         )
    //     );
     
        Util::redirect(INSTALL_URL . "Badges/index/");
    }
// Paid parking export functionality
function Paidparkingexport() {

    $this->isAjax = true;

    GzObject::loadFiles('Model', array('Paidparkingview'));
        $PaidparkingviewModel = new PaidparkingviewModel();

    $output = "";

    $query = $PaidparkingviewModel->from($PaidparkingviewModel->getTable());

    $parking = $query->fetchAll();

    if (empty($parking)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

    foreach ($parking[0] as $k => $v) {
        $output .= '"' . $k . '",';
    }
    $output .= "\n";

    foreach ($parking as $key => $value) {

        $opts = array();
        $opts['member_id'] = $value['id'];
        $slots = $PaidparkingviewModel->getAll($opts);

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

    $filename = "Paidparking_" . time() . ".csv";

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

            $this->tpl['volarr'] = array();

            // Validate MIME type before moving the file — reject anything that is not CSV/plain text
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $_FILES['csv_file']['tmp_name']);
            finfo_close($finfo);
            $allowed_csv_mimes = ['text/plain', 'text/csv', 'application/csv', 'application/vnd.ms-excel'];
            if (!in_array($mime, $allowed_csv_mimes, true)) {
                $_SESSION['upload_error'] = 'Invalid file type. Only CSV files are accepted.';
                Util::redirect(INSTALL_URL . "Badges/indexsync");
                return;
            }

            if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $path)) {

                $row = 0;
                if (($handle = fopen($path, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",", '"', '\\')) !== FALSE) {
                        $num = count($data);
                        if (!empty($num) && $num > 1 && !empty($data)) {
                            if ($data[0] != 'id') {
                                $row++;
                                if($row == 1 ){
                                    continue;
                                       }
                                $this->tpl['volarr'][$row] = array();

                                for ($c = 0; $c < $num; $c++) {
                                    $this->tpl['volarr'][$row][] = $data[$c];
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

        if (!empty($_POST['MID'])) {

            GzObject::loadFiles('Model', array('Volunteersdata'));
            $VolunteersdataModel = new VolunteersdataModel();
           // $BookingSlotModel = new BookingSlotModel();
           
            foreach (($_POST['id'] ?? []) as $k => $v) {
                $data = array();

                $data['MID'] = $_POST['MID'][$k];
                $data['Volunteer_Name'] = $_POST['Volunteer_Name'][$k];
                $data['L_Name'] = $_POST['L_Name'][$k];
                $data['Core_Team'] = $_POST['Core_Team'][$k];
                $data['Core_TeamRole'] = $_POST['Core_TeamRole'][$k];
                $data['Other_Teams'] = $_POST['Other_Teams'][$k];
                $data['Spouse_Name'] = $_POST['Spouse_Name'][$k];
                $data['Spouse_Team'] = $_POST['Spouse_Team'][$k];
                $data['Registered'] = $_POST['Registered'][$k];
                $data['Sponsor_Parking'] = $_POST['Sponsor_Parking'][$k];
                $data['Spouse_volunteerparking'] = $_POST['Spouse_volunteerparking'][$k];
                $data['Priority'] = $_POST['Priority'][$k];
                $data['Day_FullParking'] = $_POST['Day_FullParking'][$k];
                $data['Day_assigned'] = $_POST['Day_assigned'][$k];
                $data['Parking_AreaAssigned'] = $_POST['Parking_AreaAssigned'][$k];
                $data['Date'] = $_POST['Date'][$k];
                $data['Signature'] = $_POST['Signature'][$k];
                $data['Status'] = $_POST['Status'][$k];
                $data['Decal'] = $_POST['Decal'][$k];
                $data['Name_Authorized'] = $_POST['Name_Authorized'][$k];
                $data['paid_parking'] = $_POST['paid_parking'][$k];

                $id = $VolunteersdataModel->save($data);
                
                // if(!empty($_POST['timestamp'][$v])){
                //     foreach (($_POST['timestamp'][$v] ?? []) as $key => $value) {
                //         $data = array();
                //         $data['calendar_id'] = $_POST['calendar_id'][$k];
                //         $data['booking_id'] = $id;
                //         $data['timestamp'] = strtotime($value);
                //         $data['count'] = $_POST['count'][$v][$key];
                //         $data['timecreated'] = time();

                //         $BookingSlotModel->save($data);
                //     }
                // }
            }
            $status = 30;
            $_SESSION['status'] = $status;
            
            Util::redirect(INSTALL_URL . "Badges/index");
        }
    }
}

}

?>

