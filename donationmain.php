<?php
ini_set("display_errors", "Off");
header('Access-Control-Allow-Origin: *');
header('data-Type:application/json; charset=UTF-8');
header('Content-Type: application/json; charset=UTF-8');

include "config.php";
require_once __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
$reponce = json_decode(file_get_contents('php://input'), true);
$return_arr = array();
$query1 ="UPDATE membersnew SET Category='GD' WHERE `Category` = 'GM'";
$result1 = mysqli_query($con,$query1);
$query = "SELECT  * FROM `membersnew` WHERE  `Category`  = 'GD ' ";

//$query = "SELECT  * FROM `puja_payment_detail` WHERE  `created_on`  > '$reponce ' ";

//$query = "SELECT  * FROM `puja_payment_detail` ";

$result = mysqli_query($con,$query);
while($r = mysqli_fetch_assoc($result )) {
    $rows[] = $r;
    sendEmail($r);
}
// foreach ($rows as $data) {
//     sendEmail($data);
// }
function sendEmail($data) {

    if (!empty($data)) {
        $subjetc='HDBS Renewal Reminder';
             $ID = $data['ID'];
             $Member_id =$data['Member_id'];
             $F_Name =$data['F_Name'];
             $email =$data['email'];
             $type =$data['membersnewhip_type'];
             $url = INSTALL_URL . "Member/memberedit/$ID";


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
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">First Name&nbsp;&nbsp;</td>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$F_Name.'</td>
        </tr>
        <tr>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Email&nbsp;&nbsp;</td>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$email.'</td>
        </tr>
        <tr>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">Membershihp Type&nbsp;</td>
        <td style="border: 1px solid black; margin-left: auto; border-collapse: collapse; margin-right: auto; text-align: left;">'.$type.'</td>
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
            //$mail->FromName = 'avinash.verma@eiceinternational.com';
            $mail->FromName = $data['email'];
            $mail->CharSet = 'UTF-8';
            $mail->AddAddress($data['email']);
            //$mail->addaddress('avinash.verma@eiceinternational.com');
            $mail->Subject = $subjetc;
            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->WordWrap = 80; // set word wrap
            $mail->MsgHTML($message);
            //$file ='Parking_' . $ID . '_invoice_' . $Mid . '.pdf';
            // if (is_file(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf')) {
            //     $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'parkinginvoice/' . 'Parking_' . $Parking['ID'] . '_invoice_' . $Parking['Member_id'] . '.pdf'); // attachment
            // }
            $mail->IsHTML(true); // send as HTML
            $mail->Send();
        } catch (PHPMailerException $e) {
            //echo $e->errorMessage();
        }
        $_SESSION['status'] = 28;
        //echo "<script type='text/javascript'>window.open('$path','_self');</script>";
        //Util::redirect(INSTALL_URL . "Badges/index/");
    }
}


// Encoding array in JSON format
echo json_encode("Renewal mail reminder with renewal link has been sent to all GD members");