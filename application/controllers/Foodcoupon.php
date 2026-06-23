<?php

require_once CONTROLLERS_PATH . 'App.php';
require __DIR__ . '/Twillio/vendor/autoload.php';
use Twilio\Rest\Client;

class Foodcoupon extends App {

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

     if (!($this->isLoged()) && ($_REQUEST['action'] ?? '') != 'login') {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Foudcoupon/index");
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
    
    function SendSMS($mobileno, $msg)
    {
        //my twillo account setting
        // $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
        //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
        //hdbs twillo account setting
        $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
        $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
        $client = new Client($sid, $token);
        $message = $client->messages->create(
            // Where to send a text message (your cell phone?)
            '+1' . $mobileno . '',
            array(
                //'from' => '+19707037189',
                'from' => '+12815016454',
                'body' => $msg
            )
        );

    }

    
    function edit() {
        
          GzObject::loadFiles('Model', array('Foodcoupon'));
          $FoodcouponModel = new FoodcouponModel();
    
        if (!empty($_POST['ID'])) 
       {   
            $ID = $_POST['ID'] ?? '';
         
            $FoodcouponModel = $FoodcouponModel->get($_POST['ID'] ?? '');
            $data = array();
            $sign = $_POST['signed'] ?? '';
            if($this->isFoodcouponVolunteer() == 'true' ){
            if($sign == null || $sign == ""){
                echo '<script>alert("Signature required")</script>';
                Util::redirect(INSTALL_URL . "Foodcoupon/edit/$ID");
            }
        }
            
            
           if (!empty($_POST['signed']))
           {
        
           require_once APP_PATH . 'helpers/uploader/class.upload.php';
           $folderPath = "esign/";
           $image_parts = explode(";base64,", $_POST['signed']);
           $image_type_aux = explode("image/", $image_parts[0]);
           $image_type = $image_type_aux[1];
           $image_base64 = base64_decode($image_parts[1]);
           $todayyear = date("Y"); 
           $file = $folderPath ."MID_" .$_POST['MID'].$todayyear  . '.'.$image_type;
           $filename = "MID_" .$_POST['MID'].$todayyear . '.'.$image_type;
           $_POST['Signature']  = $filename;
           
           file_put_contents($file, $image_base64);
           }
           
           //$verifystudent = strtolower($_POST['StudentVerified']);
            //$pendingissue = strtolower($_POST['PendingIssues']);
    
           if($this->isFoodcouponAdmin() == 'true' || $this->isAdmin() == 'true'){
                //$_POST['Status'] = 'Coupon Issued';
                
                if(($sign == null || $sign == "" ) && $this->isFoodcouponAdmin() == 'true' ){
                    $_POST['Status'] = '';
                }
                else{
                    $_POST['Status'] = 'Coupon Issued';
                }
                
            }
            else{
                 $_POST['Status'] = 'Coupon Issued';
                   
                }

             $todayyear = date("Y"); 
             $Mid = $_POST['MID'].$todayyear;
             $name = 'Foodcoupon_' . $ID . '_invoice_' .  $Mid . '.pdf';
             $_POST['filename']  = $name;
             $ID = $this->Updatefoodcoupon($_POST);
           
             $this->saveFoodcouponInvoice($ID);
             $status = $_POST['Status'] ?? '';
            if($status =='Coupon Issued'){
            $fooddata = $_POST;
            $Mid = $_POST['MID'] ?? '';
            $id = $_POST['ID'] ?? '';
            $mobileno = $fooddata['Phone'];
            $path = INSTALL_URL . 'parkinginvoice/' . $name;
            //$path = 'http://localhost/HDBS_Payment/ParkingBadges/parkinginvoice/Foodcoupon_' . $name;
             $result = $this->foodsendEmail($fooddata, $path);
             if ($fooddata['Phone'] != null) {
             $msg = 'Houston DurgaBari: Food Coupons Details are MID: '. $fooddata['MID'].', Full Name: '. $fooddata['F_Name'].' '.$fooddata['L_Name'] .', Status: ' . $fooddata['Status']  . ' on ' . $fooddata['Date'] . '. Click here  for receipt:' . $path;
                    if ($fooddata['Phone'] != null) {
                        $this->SendSMS($mobileno, $msg);
                    }
        
            }
            }
            Util::redirect(INSTALL_URL . "Foodcoupon/index/");
       }
       
        $ID = $_GET['ID'] ?? '';
        $foodarr  = $FoodcouponModel->getfood($ID);
        $this->tpl['foodarr'] = $foodarr;  
       

      
       
       
    }

    function index()
    {

        GzObject::loadFiles('Model', array('Foodcoupon'));
        $FoodcouponModel = new FoodcouponModel();

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
        $opts = array();
        $saraswatiarr = $FoodcouponModel->saraswati($opts);
        $this->tpl['foodarr'] = $saraswatiarr;

        $opts = array();
        $foodarr = $FoodcouponModel->kali($opts);
        $this->tpl['kalifoodarr'] = $foodarr;
    }
       

     
    
    

// Function for Badges Report index
  function Foodcouponsreport() {

    GzObject::loadFiles('Model', array('Foodcouponreport', 'Foodcouponsaraswatireport'));
    $FoodcouponreportModel = new FoodcouponreportModel();
        $FoodcouponsaraswatireportModel = new FoodcouponsaraswatireportModel();
    $opts = array();
    $reportarr = $FoodcouponreportModel->getAll($opts);
    $this->tpl['reportarr'] = $reportarr;

    $opts = array();
    $saraswatireportarr = $FoodcouponsaraswatireportModel->getAll($opts);
    $this->tpl['saraswatireportarr'] = $saraswatireportarr;

   }
  
   function saraswatireportexport() {

    $this->isAjax = true;

    GzObject::loadFiles('Model', array('Foodcouponsaraswatireport'));
        $FoodcouponsaraswatireportModel = new FoodcouponsaraswatireportModel();

    $output = "";

    $query = $FoodcouponsaraswatireportModel->from($FoodcouponsaraswatireportModel->getTable());

    $parking = $query->fetchAll();

    foreach ($parking[0] as $k => $v) {
        $output .= '"' . $k . '",';
    }
    $output .= "\n";

    foreach ($parking as $key => $value) {

        $opts = array();
       // $opts['member_id'] = $value['id'];
        $slots = $FoodcouponsaraswatireportModel->getAll($opts);

        foreach ($value as $k => $v) {
            if ($k == 'date') {
                $output .= '"' . date("Y-m-d H:i", $v) . '",';
            } else {
                $output .= '"' . $v . '",';
            }
        }
        $output .= "\n";
    }

    $filename = "SaraswatipujareportData_" . time() . ".csv";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    echo $output;
    exit;
}


   function saraswatiexport() {

    $this->isAjax = true;

    GzObject::loadFiles('Model', array('Foodcoupon'));
     $FoodcouponModel = new FoodcouponModel();
     $opts = array();
     $header_args = array( 'id', 'MID', 'OID', 'Category', 'F_Name', 'L_Name', 'Sp_FName', 'City', 'State', 'Country', 'Zip', 'Email', 'Phone', 'Parent2', 'Parent1', 'Child3', 'Child2', 'Child1', 'Total', 'Child', 'Adult', 'YTD', 'Magazines', 'Sponsorship_Amount', 'Sponsor', 'Student', 'SeqNo', 'StudentVerified', 'PendingIssues', 'Signature', 'Date', 'Status', 'Name_Authorized', 'total_coupon', 'Veggies', 'PujaType', 'filename', 'Parents', 'Tele2' );
   
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=saraswatipujadata_export.csv');
    $output = fopen( 'php://output', 'w' );
    if (ob_get_level()) ob_end_clean();
    fputcsv($output, $header_args, ',', '"', '\\');
    $reportarr = $FoodcouponModel->saraswati($opts);
        foreach ($reportarr as $data_item) {
            fputcsv($output, $data_item, ',', '"', '\\');
        }
        exit;
   
  }
  


function export() {

    $this->isAjax = true;

    GzObject::loadFiles('Model', array('Foodcoupon'));
     $FoodcouponModel = new FoodcouponModel();
     $opts = array();
     $header_args = array( 'id', 'MID', 'OID', 'Category', 'F_Name', 'L_Name', 'Sp_FName', 'City', 'State', 'Country', 'Zip', 'Email', 'Phone', 'Parent2', 'Parent1', 'Child3', 'Child2', 'Child1', 'Total', 'Child', 'Adult', 'YTD', 'Magazines', 'Sponsorship_Amount', 'Sponsor', 'Student', 'SeqNo', 'StudentVerified', 'PendingIssues', 'Signature', 'Date', 'Status', 'Name_Authorized', 'total_coupon', 'Veggies', 'PujaType', 'filename', 'Parents', 'Tele2' );
  
     header('Content-Type: text/csv; charset=utf-8');
     header('Content-Disposition: attachment; filename=kalipujadata_export.csv');
     $output = fopen( 'php://output', 'w' );
     if (ob_get_level()) ob_end_clean();
     fputcsv($output, $header_args, ',', '"', '\\');
     $reportarr = $FoodcouponModel->kali($opts);
         foreach ($reportarr as $data_item) {
             fputcsv($output, $data_item, ',', '"', '\\');
         }
         exit;
  }
  
   function getMaxSN(){
    GzObject::loadFiles('Model', array('Foodcouponreport'));
        $FoodcouponreportModel = new FoodcouponreportModel();
    $sql = 'SELECT MAX(SeqNo) AS SeqNo FROM foodcoupon ';
    
    $res = $FoodcouponreportModel->execute($sql);
    
    if(!empty($res[0]['SeqNo'])){
        return $res[0]['SeqNo'];
    }else{
        return 0;
    }
}

function reportexport() {

    $this->isAjax = true;

    GzObject::loadFiles('Model', array('Foodcouponreport'));
        $FoodcouponreportModel = new FoodcouponreportModel();

    $output = "";

    $query = $FoodcouponreportModel->from($FoodcouponreportModel->getTable());

    $parking = $query->fetchAll();

    foreach ($parking[0] as $k => $v) {
        $output .= '"' . $k . '",';
    }
    $output .= "\n";

    foreach ($parking as $key => $value) {

        $opts = array();
       // $opts['member_id'] = $value['id'];
        $slots = $FoodcouponreportModel->getAll($opts);

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

    $filename = "FoodcouponsreportData_" . time() . ".csv";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    echo $output;
    exit;
}


public function getFoodcoupon($ID) {
    GzObject::loadFiles('Model', array('Foodcoupon'));
    $FoodcouponModel = new FoodcouponModel();
    $sql = 'SELECT * FROM '.$FoodcouponModel->getTable().' WHERE ID="'."$ID".'"';
   // $sql = 'SELECT * FROM '.$FoodcouponModel->getTable().' WHERE ID="'."$ID".'"';
    $result = array();
    $arr = $FoodcouponModel->execute($sql);
    return $arr[0];
}

function saveFoodcouponInvoice($ID){
        
    if (!empty($ID)) {

        GzObject::loadFiles('Model', array('Foodcoupon'));
        $FoodcouponModel = new FoodcouponModel();
     
        
        $Foodcoupon = $this->getFoodcoupon($ID);
        //$Path = "http://localhost/HDBS_Payment/ParkingBadges/esign/";
        //$Path = 'https://durgabari.org/HDBS_PaymentNew/esign/';
        $Path = INSTALL_URL . 'esign/';
        $signName = $Foodcoupon['Signature'];
        $todaynew = date("Y");
        $file = $Foodcoupon['filename'];
        //$Mid = $Foodcoupon['MID'].$todaynew;
        $pujatype = $Foodcoupon['PujaType'];
            if ($pujatype == "kali") {
                $today = date("Y");
                $pujname = "Kali Puja Food Coupons";
                $fullpujaname = $today . " " . $pujname;
            }
            if ($pujatype == "saraswati") {
                $today = date("Y");
                $pujaname = "Saraswati Puja Food Coupons";
                $fullpujaname = $today ." ". $pujaname;
            }
        $FinalSignImage =$Path.$signName;
        $opts = array();

        //$opts['calendar_id'] = $booking['calendar_id'];
        //$option_arr = $OptionModel->getAllPairValues($opts);

        $data = array();
        $variable = "<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>
        <div class='email-token-class' style='text-align: justify;'>
        <div class='email-token-class' style='text-align: center;'>
        <div class='email-token-class' style='text-align: center;'>
        <table style='height: 77px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;' width='606'>
        <tbody>
        <tr>
        <td style='text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;'><img src='" . INSTALL_URL . "application/web/upload/image/create.png' alt='' width='396' height='66' /></td>
        </tr>
        </tbody>
        </table>
        </div>
        <div class='email-token-class' style='text-align: center;'>
        <table style='height: 22px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;' width='604'>
        <tbody>
        <tr>
        <td style='text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;'><strong>$fullpujaname</strong></td>
        </tr>
        </tbody>
        </table>
        </div>
        <div class='email-token-class' style='text-align: center;'>
        <table style='height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;' width='604'>
        <tbody>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>MID&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Foodcoupon[MID]</td>
        </tr>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>First Name&nbsp;&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Foodcoupon[F_Name]</td>
        </tr>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Last Name&nbsp;&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Foodcoupon[L_Name]</td>
        </tr>
       
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Spouse Name&nbsp;&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Foodcoupon[Sp_FName]</td>
        </tr>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Total &nbsp;&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Foodcoupon[total_coupon]</td>
        </tr>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Status&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Foodcoupon[Status]</td>
        </tr>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Name Authorized To Collect &nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Foodcoupon[Name_Authorized]</td>
        </tr>
        <tr>
        <td colspan=2 style='text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;'><img src='$FinalSignImage' alt='' width='396' height='80' /></td>
        </tr>
        </tbody>
        </table>
        </div>
        </div>
        </div>";

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($variable);
        $folderPath = "parkinginvoice/";
        $mpdf->Output($folderPath . $file, 'F');

        $save = array();

        
    }
    
    return false;
}

function viewInvoice() {
    //my twillo account setting
  //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
  //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
   //hdbs twillo account setting
   //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
   //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
   //$client = new Client($sid, $token);
   GzObject::loadFiles('Model', array('Foodcoupon'));
   $FoodcouponModel = new FoodcouponModel();
   if (!empty($_GET['id'] ?? '')) {
       $Food = $this->getFoodcoupon($_GET['id'] ?? '');
       $Mid = $Food['MID'];
       $ID = $_GET['id'] ?? '';
       $today = date("Y");
       $file = $Food['filename'];
       if($Food['filename']==null){
        $file ='Foodcoupon_' . $ID . '_invoice_' . $Mid  .'.pdf';
       }else{
        $file = $Food['filename'];
       }
        
     
       
       $path = INSTALL_URL . 'parkinginvoice/' . $file;
       
      //$path = 'https://durgabari.org/HDBS_PaymentNew/parkinginvoice/' . $file;
        
      //$path = 'http://localhost/HDBS_Payment/ParkingBadges/parkinginvoice/' . $file;
      // $result = $this->sendEmail($Parking, $path);
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
 Util::redirect(INSTALL_URL . "Foodcoupon/index/");
}   
public function Updatefoodcoupon($POST)
    {
    GzObject::loadFiles('Model', array('Foodcoupon'));
    $FoodcouponModel = new FoodcouponModel();
        $id=$POST['ID'];
        // $Category=$POST['Category']; 
        // $City=$POST['City']; 
        // $State=$POST['State']; 
        // $Country=$POST['Country'];
        // $Zip=$POST['Zip']; 
        // $Email=$POST['Email']; 
        // $Phone=$POST['Phone']; 
        $Parent1=$POST['Parent1']; 
        $Parent2=$POST['Parent2']; 
        $Child3=$POST['Child3']; 
        $Child2=$POST['Child2']; 
        $Child1=$POST['Child1']; 
        $Total=$POST['Total']; 
        $Child=$POST['Child']; 
        $Adult=$POST['Adult']; 
        $YTD=$POST['YTD']; 
        $Magazines=$POST['Magazines']; 
        $Sponsorship_Amount=$POST['Sponsorship_Amount']; 
        $Sponsor=$POST['Sponsor']; 
        $Name_Authorized=$POST['Name_Authorized']; 
        $SeqNo=$POST['SeqNo']; 
        $StudentVerified=$POST['StudentVerified']; 
        $PendingIssues=$POST['PendingIssues']; 
        $Signature=$POST['Signature']; 
        $Date=$POST['Date']; 
        $Status=$POST['Status']; 
        $total_coupon=$POST['total_coupon'];
        $Student=$POST['Student'];
        $Veggies=$POST['Veggies'];
        $filename=$POST['filename'];
        $Parents=$POST['Parents'];
        
        $sql = 'UPDATE foodcoupon SET Parent2="'."$Parent2".'",Parent1="'."$Parent1".'",Child3="'."$Child3".'",Child2="'."$Child2".'",Child1="'."$Child1".'",Total="'."$Total".'",Child="'."$Child".'",Adult="'."$Adult".'",YTD="'."$YTD".'",Magazines="'."$Magazines".'",Sponsorship_Amount="'."$Sponsorship_Amount".'",Sponsor="'."$Sponsor".'",SeqNo="'."$SeqNo".'",StudentVerified="'."$StudentVerified".'",PendingIssues="'."$PendingIssues".'",Signature="'."$Signature".'"
        ,Date="'."$Date".'",Status="'."$Status".'",Name_Authorized="'."$Name_Authorized".'",total_coupon="'."$total_coupon".'",Student="'."$Student".'",Veggies="'."$Veggies".'",filename="'."$filename".'",Parents="'."$Parents".'" WHERE id="'."$id".'"';
        // $sql = 'SELECT CONCAT(date," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().'; ';
        $result = array();
        $arr = $FoodcouponModel->execute($sql);
        
        return $id;
        
    }
    
    function import() {
    if (!empty($_POST['import'])) {
        if (!empty($_FILES['csv_file'])) {
            $filename = time() . '_' . $_FILES['csv_file']['name'];

            $path = INSTALL_PATH . UPLOAD_PATH . 'csv/' . $filename;

            $this->tpl['foodarr'] = array();

            if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $path)) {
                $row = 0;
                if (($handle = fopen($path, "r")) !== false) {
                    while (($data = fgetcsv($handle, 1000, ",", '"', '\\')) !== false) {
                        $num = count($data);
                        if (!empty($num) && $num > 1 && !empty($data)) {
                            if ($data[0] != 'id') {
                                $row++;
                                // if($row == 1 ){
                                //     continue;
                                //        }
                                $this->tpl['foodarr'][$row] = array();

                                for ($c = 0; $c < $num; $c++) {
                                    $this->tpl['foodarr'][$row][] = $data[$c];
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
            GzObject::loadFiles('Model', array('Foodcoupon'));
            $FoodcouponModel = new FoodcouponModel();
            // $BookingSlotModel = new BookingSlotModel();

            foreach (($_POST['id'] ?? []) as $k => $v) {
                $data = array();

                $data['id']=$data[' ']=$_POST['id'][$k];
                $data['MID']=$_POST['MID'][$k];
                $data['OID']=$_POST['OID'][$k];
                $data['Category']=$_POST['Category'][$k];
                $data['F_Name']=$_POST['F_Name'][$k];
                $data['L_Name']=$_POST['L_Name'][$k];
                $data['Sp_FName']=$_POST['Sp_FName'][$k];
                $data['City']=$_POST['City'][$k];
                $data['State']=$_POST['State'][$k];
                $data['Country']=$_POST['Country'][$k];
                $data['Zip']=$_POST['Zip'][$k];
                $data['Email']=$_POST['Email'][$k];
                $data['Phone']=$_POST['Phone'][$k];
                $data['Parent2']=$_POST['Parent2'][$k];
                $data['Parent1']=$_POST['Parent1'][$k];
                $data['Child3']=$_POST['Child3'][$k];
                $data['Child2']=$_POST['Child2'][$k];
                $data['Child1']=$_POST['Child1'][$k];
                $data['Total']=$_POST['Total'][$k];
                $data['Child']=$_POST['Child'][$k];
                $data['Adult']=$_POST['Adult'][$k];
                $data['YTD']=$_POST['YTD'][$k];
                $data['Magazines']=$_POST['Magazines'][$k];
                $data['Sponsorship_Amount']=$_POST['Sponsorship_Amount'][$k];
                $data['Sponsor']=$_POST['Sponsor'][$k];
                $data['Student']=$_POST['Student'][$k];
                $data['SeqNo']=$_POST['SeqNo'][$k];
                $data['StudentVerified']=$_POST['StudentVerified'][$k];
                $data['PendingIssues']=$_POST['PendingIssues'][$k];
                $data['Signature']=$_POST['Signature'][$k];
                $data['Date']=$_POST['Date'][$k];
                $data['Status']=$_POST['Status'][$k];
                $data['Name_Authorized']=$_POST['Name_Authorized'][$k];
                $data['total_coupon']=$_POST['total_coupon'][$k];   
                $data['Veggies']=$_POST['Veggies'][$k];
                 $data['Amount']=$_POST['Amount'][$k];
                
                $id = $FoodcouponModel->save($data);

                // if(!empty($_POST['timestamp'][$v])){
                    //     foreach ($_POST['timestamp'][$v] as $key => $value) {
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

            Util::redirect(INSTALL_URL . "Foodcoupon/index");
        }
    }
}


}

?>

