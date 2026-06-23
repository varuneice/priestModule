<?php

require_once CONTROLLERS_PATH . 'App.php';
require __DIR__ . '/Twillio/vendor/autoload.php';
use Twilio\Rest\Client;

class BadgesAssign extends App {

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
            Util::redirect(INSTALL_URL . "Badges/index");
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
    
   
    
    function edit() {
        //my twillo account setting
        //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
        //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
          //hdbs twillo account setting
          $sid = defined('TWILIO_SID') ? TWILIO_SID : '';
          $token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
          $client = new Client($sid, $token);
        GzObject::loadFiles('Model', array('Badgesdata'));
        $BadgesdataModel  = new BadgesdataModel();
    
        if (!empty($_POST['ID'])) 
       {   
            $ID = $_POST['ID'] ?? '';
         
            $BadgesdataModel = $BadgesdataModel->get($_POST['ID'] ?? '');
            $data = array();
            $sign = $_POST['signed'] ?? '';
            if($this->isBadgesVolunteer() == 'true' ){
            if($sign == null || $sign == ""){
                echo '<script>alert("Signature required")</script>';
                Util::redirect(INSTALL_URL . "BadgesAssign/edit/$ID");
            }
        }
            
            
           if (!empty($_POST['signed']))
           {
        
           require_once APP_PATH . 'helpers/uploader/class.upload.php';
           $folderPath = "esign/";
           $image_parts = explode(";base64,", $_POST['signed'] ?? '');
           $image_type_aux = explode("image/", $image_parts[0]);
           $image_type = $image_type_aux[1];
           $image_base64 = base64_decode($image_parts[1]);
           $file = $folderPath ."MID_" .($_POST['MID'] ?? '') . '.'.$image_type;
           $filename = "MID_" .($_POST['MID'] ?? '') . '.'.$image_type;
           $_POST['Signature']  = $filename;
           
           file_put_contents($file, $image_base64);
           }
           
           $verifystudent = strtolower($_POST['StudentVerified'] ?? '');
            $pendingissue = strtolower($_POST['PendingIssues'] ?? '');
    
            if($this->isBadgesAdmin() == 'true'){
    
                //if($_POST['Name_Authorized']!=null){
                if((($_POST['total_badges'] ?? null)!=null ||($_POST['total_badges'] ?? '')!="" ) && $verifystudent!='no' ){
                    $_POST['Status'] = 'Badges Issued';
                }else if($pendingissue !='no' &&  $pendingissue !="" ){
                    $_POST['Status'] = 'Pending Issue';

                }
                else{
                    $_POST['Status'] = 'Pending';
                }
                
            }
            else{
                 $_POST['Status'] = 'Badges Issued';
                   
                }   
                        
            $ID = $this->UpdateAssignBadges($_POST);
            $this->saveBadgesInvoice($ID);
             $status = $_POST['Status'] ?? '';
            if($status =='Badges Issued'){
            $Badgesdata = $_POST;
            $Mid = $_POST['MID'] ?? '';
            $id = $_POST['ID'] ?? '';
            $mobileno = $Badgesdata['Phone'];
            $file ='Badges_' . $ID . '_invoice_' . $Mid . '.pdf';
            $path = INSTALL_URL . 'parkinginvoice/Badges_' . $id . '_invoice_' . $Mid . '.pdf';
                //$path = 'http://localhost/parking2/parkinginvoice/Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            $result = $this->sendEmailBadges($Badgesdata, $path);
            if ($Badgesdata['Phone'] != null) {
            $msg = 'Houston DurgaBari: Badges Details are MID: '. $Badgesdata['MID'].', Full Name: '. $Badgesdata['F_Name'].' '.$Badgesdata['L_Name'] .', Status: ' . $Badgesdata['Status']  . ' on ' . $Badgesdata['Date'] . '. Click here  for receipt:' . $path;
            $message = $client->messages->create(
                 // Where to send a text message (your cell phone?)
                '+1'.$Badgesdata['Phone'].'',
                 //'+91'.'8699399143'.'',
                 array(
                     //'from' => '+16184182672',
                      'from' => '+12815016454',
                     'body' => $msg
                 )
             );
            }
            }
            Util::redirect(INSTALL_URL . "BadgesAssign/index/");
       }
       
       $ID = $_GET['ID'] ?? '';
       $badgesarr  = $BadgesdataModel->get($ID);
       $this->tpl['badgesarr'] = $badgesarr;
       //$this->tpl['arr'] = $arr;
       
    }

    function index() {

        GzObject::loadFiles('Model', array('Badgesdata'));
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

// for assign badges
    $badgesarr = $BadgesdataModel->getAll($opts);
    $this->tpl['badgesarr'] = $badgesarr;    
    }

// Function for Badges Report index
  function badgesreport() {

    GzObject::loadFiles('Model', array('Badgesreport'));
    $BadgesreportModel = new BadgesreportModel();
 
    $opts = array();
    $reportarr = $BadgesreportModel->getAll($opts);
    $this->tpl['reportarr'] = $reportarr;
   }
  

function Badgesexport() {

    $this->isAjax = true;

    GzObject::loadFiles('Model', array('Badgesdata'));
    $BadgesdataModel  = new BadgesdataModel();

    $output = "";

    $query = $BadgesdataModel->from($BadgesdataModel->getTable());

    $badges = $query->fetchAll();

    if (empty($badges)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

    foreach ($badges[0] as $k => $v) {
        $output .= '"' . $k . '",';
    }
    $output .= "\n";

    foreach ($badges as $key => $value) {

        $opts = array();
        $opts['member_id'] = $value['id'];
        $slots = $BadgesdataModel->getAll($opts);

        foreach ($value as $k => $v) {
            if ($k == 'date') {
                $output .= '"' . date("Y-m-d H:i", $v) . '",';
            } else {
                $output .= '"' . $v . '",';
            }
        }
        
        $output .= "\n";
    }

    $filename = "Badges_Data" . time() . ".csv";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    echo $output;
    exit;  
  }
  
  function getMaxSN(){
    GzObject::loadFiles('Model', array('Badgesdata'));
    $BadgesdataModel  = new BadgesdataModel();
    $sql = 'SELECT MAX(SeqNo) AS SeqNo FROM badgesdata ';
    
    $res = $BadgesdataModel->execute($sql);
    
    if(!empty($res[0]['SeqNo'])){
        return $res[0]['SeqNo'];
    }else{
        return 0;
    }
}


function reportexport() {

    $this->isAjax = true;

    GzObject::loadFiles('Model', array('Badgesreport'));
        $BadgesreportModel = new BadgesreportModel();

    $output = "";

    $query = $BadgesreportModel->from($BadgesreportModel->getTable());

    $parking = $query->fetchAll();

    if (empty($parking)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

    foreach ($parking[0] as $k => $v) {
        $output .= '"' . $k . '",';
    }
    $output .= "\n";

    foreach ($parking as $key => $value) {

        $opts = array();
       // $opts['member_id'] = $value['id'];
        $slots = $BadgesreportModel->getAll($opts);

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

    $filename = "BadgesreportData_" . time() . ".csv";

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $filename);

    echo $output;
    exit;
}


public function getBADGES($ID) {
    GzObject::loadFiles('Model', array('Badgesdata'));
    $BadgesdataModel  = new BadgesdataModel();
    $sql = 'SELECT * FROM '.$BadgesdataModel->getTable().' WHERE ID="'."$ID".'"';
    $result = array();
    $arr = $BadgesdataModel->execute($sql);
    return $arr[0];
}

function saveBadgesInvoice($ID){
        
    if (!empty($ID)) {

        GzObject::loadFiles('Model', array('Badgesdata'));
        $BadgesdataModel = new BadgesdataModel();
     
        
        $Badges = $this->getBADGES($ID);
        //$Path = "http://localhost/final/esign/";
        $Path = INSTALL_URL . 'esign/';
        //$Path = 'https://durgabari.org/HDBS_Payment_Parking_Badges/esign/';
        $signName = $Badges['Signature'];
        $Mid = $Badges['MID'];
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
        <td style='text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;'><strong>Badges Details</strong></td>
        </tr>
        </tbody>
        </table>
        </div>
        <div class='email-token-class' style='text-align: center;'>
        <table style='height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;' width='604'>
        <tbody>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>MID&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Badges[MID]</td>
        </tr>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>First Name&nbsp;&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Badges[F_Name]</td>
        </tr>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Last Name&nbsp;&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Badges[L_Name]</td>
        </tr>
       
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Spouse Name&nbsp;&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Badges[Sp_FName]</td>
        </tr>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Total &nbsp;&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Badges[Total]</td>
        </tr>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Badges Status&nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Badges[Status]</td>
        </tr>
        <tr>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>Name Authorized To Collect &nbsp;</td>
        <td style='border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;'>$Badges[Name_Authorized]</td>
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
        $name = 'Badges_' . $ID . '_invoice_' .  $Mid . '.pdf';
        $folderPath = "parkinginvoice/";
        $mpdf->Output($folderPath . $name, 'F');

        $save = array();

        return $id;
    }
    
    return false;
}

function viewInvoiceBadges() {
    //my twillo account setting
  //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
  //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
   //hdbs twillo account setting
   //$sid = defined('TWILIO_SID') ? TWILIO_SID : '';
   //$token = defined('TWILIO_TOKEN') ? TWILIO_TOKEN : '';
   //$client = new Client($sid, $token);
   GzObject::loadFiles('Model', array('Badgesdata'));
   $BadgesdataModel = new BadgesdataModel();
   if (!empty($_GET['id'] ?? '')) {
       $Badges = $this->getBADGES($_GET['ID'] ?? '');
       $Mid = $Badges['MID'];
       $ID = $_GET['id'] ?? '';
       $file ='Badges_' . $ID . '_invoice_' . $Mid . '.pdf';
       
       $path = INSTALL_URL . 'parkinginvoice/Badges_' . $ID . '_invoice_' . $Mid . '.pdf';
       
        //$path = 'https://durgabari.org/HDBS_Payment_Parking_Badges/parkinginvoice/Badges_' . $ID . '_invoice_' . $Mid . '.pdf';
        
      //$path = 'http://localhost/final/parkinginvoice/Badges_' . $ID . '_invoice_' . $Mid . '.pdf';
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
 Util::redirect(INSTALL_URL . "BadgesAssign/index/");
}   
public function UpdateAssignBadges($POST)
    {
    GzObject::loadFiles('Model', array('Badgesdata'));
    $BadgesdataModel  = new BadgesdataModel();
        $id=$POST['ID'] ?? '';
        // $Category=$POST['Category'];
        // $City=$POST['City'];
        // $State=$POST['State'];
        // $Country=$POST['Country'];
        // $Zip=$POST['Zip'];
        // $Email=$POST['Email'];
        // $Phone=$POST['Phone'];
        $Parent1=$POST['Parent1'] ?? '';
        $Parent2=$POST['Parent2'] ?? '';
        $Child3=$POST['Child3'] ?? '';
        $Child2=$POST['Child2'] ?? '';
        $Child1=$POST['Child1'] ?? '';
        $Total=$POST['Total'] ?? '';
        $Child=$POST['Child'] ?? '';
        $Adult=$POST['Adult'] ?? '';
        $YTD=$POST['YTD'] ?? '';
        $Magazines=$POST['Magazines'] ?? '';
        $Sponsorship_Amount=$POST['Sponsorship_Amount'] ?? '';
        $Sponsor=$POST['Sponsor'] ?? '';
        $Name_Authorized=$POST['Name_Authorized'] ?? '';
        $SeqNo=$POST['SeqNo'] ?? '';
        $StudentVerified=$POST['StudentVerified'] ?? '';
        $PendingIssues=$POST['PendingIssues'] ?? '';
        $Signature=$POST['Signature'] ?? '';
        $Date=$POST['Date'] ?? '';
        $Status=$POST['Status'] ?? '';
        $Total_badges=$POST['total_badges'] ?? '';
        $Student=$POST['Student'] ?? '';
        $Veggies=$POST['Veggies'] ?? '';
        
   
         $sql = 'UPDATE badgesdata SET Parent2="'."$Parent2".'",Parent1="'."$Parent1".'",Child3="'."$Child3".'",Child2="'."$Child2".'",Child1="'."$Child1".'",Total="'."$Total".'",Child="'."$Child".'",Adult="'."$Adult".'",YTD="'."$YTD".'",Magazines="'."$Magazines".'",Sponsorship_Amount="'."$Sponsorship_Amount".'",Sponsor="'."$Sponsor".'",SeqNo="'."$SeqNo".'",StudentVerified="'."$StudentVerified".'",PendingIssues="'."$PendingIssues".'",Signature="'."$Signature".'"
         ,Date="'."$Date".'",Status="'."$Status".'",Name_Authorized="'."$Name_Authorized".'",Total_badges="'."$Total_badges".'",Student="'."$Student".'",Veggies="'."$Veggies".'" WHERE id="'."$id".'"';
        // $sql = 'SELECT CONCAT(date," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().'; ';
        $result = array();
        $arr = $BadgesdataModel->execute($sql);
        
        return $id;
        
    }
    
    function badgesimport() {
    if (!empty($_POST['import'])) {
        if (!empty($_FILES['csv_file'])) {
            $filename = time() . '_' . $_FILES['csv_file']['name'];

            $path = INSTALL_PATH . UPLOAD_PATH . 'csv/' . $filename;

            $this->tpl['badgesarr'] = array();

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
                                $this->tpl['badgesarr'][$row] = array();

                                for ($c = 0; $c < $num; $c++) {
                                    $this->tpl['badgesarr'][$row][] = $data[$c];
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
            GzObject::loadFiles('Model', array('Badgesdata'));
            $BadgesdataModel = new BadgesdataModel();
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
                $data['total_badges']=$_POST['total_badges'][$k];
                $data['Veggies']=$_POST['Veggies'][$k];
                
                $id = $BadgesdataModel->save($data);

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

            Util::redirect(INSTALL_URL . "BadgesAssign/index");
        }
    }
}

function delete() {
    $this->isAjax = true;
    $id = $_REQUEST['id'];
    GzObject::loadFiles('Model', array('Badgesdata'));
    $BadgesdataModel = new BadgesdataModel();
    

    $BadgesdataModel->deleteFrom($BadgesdataModel->getTable())
            ->where('id', $id)->execute();
    $BadgesdataModel->deleteFrom($BadgesdataModel->getTable())
            ->where('id', $id)->execute();

    $this->index();
}

}

?>

