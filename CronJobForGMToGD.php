<?php

include "config.php";
require_once __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
header('Access-Control-Allow-Origin: *');
header('data-Type:application/json; charset=UTF-8');
header('Content-Type: application/json; charset=UTF-8');
$reponce = json_decode(file_get_contents('php://input'), true);
$return_arr = array();
$query1 ="UPDATE members SET Category='GD' WHERE `Category` = 'GM' AND LENGTH(Member_id) <= 4 AND (Active IS NULL OR Active='')";
$result1 = mysqli_query($con,$query1);
$query = "SELECT  * FROM `members` WHERE  `Category`  = 'GD' AND LENGTH(Member_id) <= 4 AND (Active IS NULL OR Active='')";


$result = mysqli_query($con,$query);
while($r = mysqli_fetch_assoc($result )) {
    $rows[] = $r;
    // sendEmail($r);
}

function sendEmail($data) {

    if (!empty($data)) {
        $subjetc='HDBS Renewal Reminder';
             $ID = $data['ID'];
             $Member_id =$data['Member_id'];
             $fullName =$data['F_Name']. ' ' . $data['M_Name']. ' ' . $data['L_Name'];
             $email =$data['email'];
             //$type =$data['membersnewhip_type'];
             $status =$data['Category'];
             $url = INSTALL_URL . "Member/memberlookup";

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
        <td style="text-align: center; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;"><strong>Renew Reminder</strong></td>
        </tr>
        </tbody>
        </table>
        </div>
        <div class="email-token-class" style="text-align: center;">
        <table style="height: 190px; border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto;" width="604">
        <tbody>
        <tr>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member ID&nbsp;</td>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$Member_id.'</td>
        </tr>
        <tr>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Member Name&nbsp;&nbsp;</td>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$fullName.'</td>
        </tr>
        <tr>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Email&nbsp;&nbsp;</td>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$email.'</td>
        </tr>
        <tr>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Status Type&nbsp;</td>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$status.'</td>
        </tr>
        <tr>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Renew Url&nbsp;</td>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$url.'</td>
        </tr>
        </tbody>
        </table>
        </div>
        </div>
        </div>';
       

       
        try {
            $mail = new PHPMailer(true); //New instance, with exceptions enabled
            //$mail->IsSendmail();  // tell the class to use Sendmail
            $mail->addreplyto('hdbs.payment@durgabari.org', "Admin");
            $mail->From = 'hdbs.payment@durgabari.org';
            $mail->FromName = 'hdbs.payment@durgabari.org';
            //$mail->FromName = $data['email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress($data['email']);
            $mail->AddAddress('hdbs.payment@durgabari.org', 'Admin');
            //$mail->addaddress('avinash.verma@eiceinternational.com');
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            $mail->IsHTML(true); // send as HTML
            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
        $_SESSION['status'] = 28;
        //echo "<script type='text/javascript'>window.open('$path','_self');</script>";
        
    }
}


// Encoding array in JSON format
echo json_encode("Renewal mail reminder with renewal link has been sent to all GD members");