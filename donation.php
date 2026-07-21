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
        $id               = $value['uid'];
        $type             = null;
        $bank             = $value['bank'];
        $chkno            = $value['chkno'];
        $chkdate          = $value['chkdate'];
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
        $Address          = '';
        $Street           = '';
        $State            = '';
        $Zip_Code         = '';
        $email            = '';
        $City             = '';
        $Tele1            = '';
        $eventdonation    = '';
        $spousename       = '';
        $purpose          = '';

        // Check if record exists
        $stmt = $con->prepare("SELECT id FROM donation WHERE id = ?");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            $update = $con->prepare(
                "UPDATE donation SET
                    bank=?, chkno=?, chkdate=?, MemberName=?, Amount=?, PaymentOption=?,
                    payment_status=?, payment_timestamp=?, stripe_return=?, transaction_id=?,
                    paid_amount=?, stripe_product=?, update_on=?, Member_id=?, pay_date=?,
                    cc_name=?, remarks=?, oid=?, pay_type=?, pay_for=?, Address=?, Street=?,
                    State=?, Zip_Code=?, Tele1=?, email=?, City=?, eventdonation=?,
                    spousename=?, purpose=?
                 WHERE id=?"
            );
            $update->bind_param(
                'sssssssssssssssssssssssssssssss',
                $bank, $chkno, $chkdate, $MemberName, $Amount, $PaymentOption,
                $payment_status, $payment_timestamp, $stripe_return, $transaction_id,
                $paid_amount, $stripe_product, $update_on, $Member_id, $pay_date,
                $cc_name, $remarks, $oid, $pay_type, $pay_for, $Address, $Street,
                $State, $Zip_Code, $Tele1, $email, $City, $eventdonation,
                $spousename, $purpose,
                $id
            );
            $update->execute();
            $update->close();
        } else {
            $stmt->close();
            $insert = $con->prepare(
                "INSERT INTO donation VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
            );
            $insert->bind_param(
                'sssssssssssssssssssssssssssssss',
                $id, $type, $bank, $chkno, $chkdate, $MemberName, $Amount, $PaymentOption,
                $payment_status, $payment_timestamp, $stripe_return, $transaction_id,
                $paid_amount, $stripe_product, $update_on, $Member_id, $pay_date,
                $cc_name, $remarks, $oid, $pay_type, $pay_for, $Address, $Street,
                $State, $Zip_Code, $Tele1, $email, $City, $eventdonation,
                $spousename, $purpose
            );
            $insert->execute();
            $insert->close();
        }
    }
}
