<?php
header('Access-Control-Allow-Origin: *');
header('data-Type:application/json; charset=UTF-8');
header('Content-Type: application/json; charset=UTF-8');
include "config.php";
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$reponce = json_decode(file_get_contents('php://input'), true);

if (isset($_POST)) {
    foreach ($reponce as $value) {
        $type             = null;
        $gift             = null;
        $Payment_For      = null;
        $MemberName       = $value['cc_name'];
        $Amount           = $value['amount'];
        $PaymentOption    = $value['pay_mode'];
        $payment_status   = $value['status'];
        $payment_times    = $value['update_on'];
        $payment_timestamp = mktime($payment_times);
        $stripe_return    = 'succeeded';
        $transaction_id   = $value['cc_ref_no'];
        $paidamount       = $value['amount'];
        $paid_amount      = $paidamount . "00";
        $stripe_product   = $value['cc_name'] . $value['Email'];
        $update_on        = $value['update_on'];
        $Member_id        = $value['reg_uid'];
        $pay_date         = $value['pay_date'];
        $cc_name          = $value['cc_name'];
        $remarks          = $value['remarks'];
        $oid              = $value['oid'];
        $pay_type         = $value['pay_type'];
        $pay_for          = $value['pay_for'];

        $insert = $con->prepare(
            "INSERT INTO donation VALUES ('',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
        );
        $insert->bind_param(
            'sssssssssssssssssss',
            $type, $gift, $Payment_For, $MemberName, $Amount, $PaymentOption,
            $payment_status, $payment_timestamp, $stripe_return, $transaction_id,
            $paid_amount, $stripe_product, $update_on, $Member_id, $pay_date,
            $cc_name, $remarks, $oid, $pay_type, $pay_for
        );
        $insert->execute();
        $insert->close();
    }
}
