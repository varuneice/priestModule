<?php
ini_set("display_errors", "Off");
header('Access-Control-Allow-Origin: *');
header('data-Type:application/json; charset=UTF-8');
header('Content-Type: application/json; charset=UTF-8');
include "config.php";
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//$query1 = "DELETE  FROM tickets WHERE date_format(created_on,'%Y.%m.%d')  = CURDATE() ";
//$query1 = "DELETE  FROM tickets WHERE 1=1 ";
//mysqli_query($con, $query1);
$reponce = json_decode(file_get_contents('php://input'), true);
if (isset($_POST)) {

    foreach ($reponce as $value) {

        

// foreach ($_POST['mydata'] as $index=>$value) {
    $id = $value['uid'];
    $oid = $value['oid'];
    $name =  $value['name'];
    $address = $value['address'];
    $tele = $value['tele'];
    $email = $value['email'];
    $city = $value['city'];
    $state =  $value['state'];
    $zip = $value['zip'];
    $item_name = $value['item_name'];
    $item_number =  $value['item_number'];
    $item_cost = $value['item_cost'];
    $amount = $value['amount'];
    $pay_for = $value['pay_for'];
    $pay_date = $value['pay_date'];
    $txn_id = $value['txn_id'];
    $status = $value['status'];
    $remarks = $value['remarks'];
    $created_on = $value['created_on'];
    $update_on = $value['update_on'];
    // newfield
    $PaymentOption = '';
    $payment_status =  '';
    $payment_timestamp = '';
    $stripe_return = '';
    $paid_amount = '';
    $stripe_product = '';
    $cc_name = '';
    $Member_id = '';
    $type = '';
    $street = '';
    $eventdonation = '';
    $totaldonation = '';
    $itemeventday = '';

    $get = "SELECT * FROM tickets WHERE id='$id'";
    $result = mysqli_query($con, $get);
if (mysqli_num_rows($result) > 0) {
    
    $res =mysqli_fetch_assoc($result);
    $update =  "UPDATE tickets SET name='$name',address='$address',tele='$tele',city='$city',state='$state',item_name='$item_name',item_number='$item_number',item_cost='$item_cost',amount='$amount',pay_for='$pay_for',txn_id='$txn_id',status='$status',remarks='$remarks',update_on='$update_on',PaymentOption='$PaymentOption',payment_status='$payment_status',payment_timestamp='$payment_timestamp',stripe_return='$stripe_return',paid_amount='$paid_amount',stripe_product='$stripe_product',cc_name='$cc_name',Member_id='$Member_id',type='$type',street='$street',eventdonation='$eventdonation',totaldonation='$totaldonation',itemeventday='$itemeventday'  WHERE id='$id'";  
    //AND pay_for like 'PUJA / MiscPay%' AND (status = 'APPROVED' OR status = 'succeeded') AND item_name like '%Parking%''%Parking%'";
    $tres =mysqli_query($con, $update);
    $tickets=$tres;
}
else{
    $sql = "INSERT INTO tickets VALUES ('$id','$oid','$name','$address','$tele','$email','$city','$state','$zip','$item_name','$item_number','$item_cost','$amount','$pay_for','$pay_date','$txn_id','$status','$remarks','$created_on','$update_on','$PaymentOption','$payment_status','$payment_timestamp','$stripe_return','$paid_amount','$stripe_product','$cc_name','$Member_id','$type','$street','$eventdonation','$totaldonation','$itemeventday')";
    //$sql = "INSERT INTO confirm_code  VALUES ('','$str','$GetData[2]','$GetData[1]','$GetData[3]')";
    $retval =mysqli_query($con, $sql);
    $tickets = $retval;
}
}
//return $tickets;
}
?>