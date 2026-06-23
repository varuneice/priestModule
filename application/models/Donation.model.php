<?php

require_once MODELS_PATH . 'App.model.php';

class DonationModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'donation';
    
    var $schema = array(
       array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'varchar', 'default' => ''),
         array('name' => 'bank', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkno', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkdate', 'type' => 'Date', 'default' => ':NULL'),
        array('name' => 'MemberName', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Amount', 'type' => 'float', 'default' => ''),
        array('name' => 'PaymentOption', 'varchar' => 'decimal', 'default' => ''),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'update_on', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
		array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
		array('name' => 'pay_date', 'type' => 'Date', 'default' => ':NULL'),
		array('name' => 'cc_name', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'remarks', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'oid', 'type' => 'int', 'default' => ''),
		array('name' => 'pay_type', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'pay_for', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Address', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Street', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'State', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Zip_Code', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Phone_Number', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'City', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Tele1', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'eventid', 'type' => 'float', 'default' => ''),
        array('name' => 'spousename', 'type' => 'varchar', 'default' => ''),
        array('name' => 'purpose', 'type' => 'varchar', 'default' => ''),
        array('name' => 'ReceiveBy', 'type' => 'varchar', 'default' => ''),
        
        // Add new field 26july
        array('name' => 'paymentfor', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'admin_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'membercategory', 'type' => 'varchar', 'default' => ''),
        array('name' => 'alternatenumber', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'alternateemail', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'DepositAccount', 'type' => 'varchar', 'default' => '')
       
    );
    function getMaxid(){
        $sql = 'SELECT MAX(id)
 AS id FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['id'])){
            return $res[0]['id'];
        }else{
            return 0;
        }
    }
    
   public function DonationAll($opts)
    {
         $sql = 'SELECT * FROM '.$this->getTable().' WHERE pay_type ="'."DONATION".'" AND pay_for like "%DONATION%" ORDER BY id DESC';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    
     public function getDonationdata($transaction)
    {
       // $Memberid=$_POST['memberid'];
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE transaction_id="'."$transaction".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr[0] ?? null;

    }
    public function donationgiftmisc($opts)
    {
  
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE pay_type IN("gift", "misc")';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }

    public function SaveDataInDonation($value)
    {
            $donid = $this->getMaxid();
            $id =  $donid +1;
            $Member_id = $value['Member_id'] ?? '';
            $Member_id_sql = ($Member_id === '' || $Member_id === null) ? 'NULL' : (int)$Member_id;
            $type = $value['type'] ?? '';
            $bank = $value['bank'] ?? '';
            $chkno = $value['chkno'] ?? '';
            $chkdate = $value['chkdate'] ?? null;
            $chkdate_sql = !empty($chkdate) ? "'$chkdate'" : 'NULL';
            $MemberName = $value['MemberName'] ?? '';
            $Amount = $value['Amount'] ?? '';
            $Amount_sql = ($Amount === '' || $Amount === null) ? 'NULL' : (float)$Amount;
            $PaymentOption = $value['PaymentOption'] ?? '';
            $payment_status = $value['payment_status'] ?? '';
            $payment_timestamp = $value['payment_timestamp'] ?? '';
            //$payment_timestamp = mktime($payment_times);
            $stripe_return = $value['stripe_return'] ?? '';
            $transaction_id =  $value['transaction_id'] ?? '';
            $paid_amount = $value['paid_amount'] ?? '';
            $stripe_product = $value['stripe_product'] ?? '';
            $update_on = $value['update_on'] ?? null;
            $update_on_sql = !empty($update_on) ? "'$update_on'" : "'" . date('Y-m-d H:i:s') . "'";
            $pay_date = $value['pay_date'] ?? '';
            $cc_name = $value['MemberName'] ?? '';
            $remarks = $value['remarks'] ?? '';
            $oid =  $value['oid'] ?? '';
            $oid_sql = ($oid === '' || $oid === null) ? 'NULL' : (int)$oid;
            $pay_type = $value['pay_type'] ?? '';
            $pay_for = $value['pay_for'] ?? '';
            $Address = $value['Address'] ?? '';
            $street = $value['Street'] ?? '';
            $state = $value['State'] ?? '';
            $zip =  $value['Zip_Code'] ?? '';
            $tele = $value['Tele1'] ?? '';
            $email =  $value['email'] ?? '';
            $city = $value['City'] ?? '';
            $spousename = $value['spousename'] ?? '';
            $eventid = $value['eventid'] ?? '';
            $eventid_sql = ($eventid === '' || $eventid === null) ? 'NULL' : (float)$eventid;
            $purpose = $value['purpose'] ?? '';
            $ReceiveBy = $value['ReceiveBy'] ?? '';

             //new field 26july
            $paymentfor = $value['paymentfor'] ?? '';
            $admin_id = $value['admin_id'] ?? null;
            $admin_id_sql = $admin_id !== null && $admin_id !== '' ? "'$admin_id'" : 'NULL';
            $admin_name = $value['admin_name'] ?? '';
            $membercategory = $value['membercategory'] ?? '';
            $alternatenumber = $value['alternatenumber'] ?? '';
            $alternateemail =  $value['alternateemail'] ?? '';
            $DepositAccount = $value['DepositAccount'] ?? '';
           //update 26july
             //$sql=  "INSERT INTO ".$this->getTable()." VALUES ('$id','$type','$bank','$chkno','$chkdate','$MemberName','$Amount','$PaymentOption','$payment_status','$payment_timestamp','$stripe_return','$transaction_id','$paid_amount','$stripe_product','$update_on','$Member_id','$pay_date','$cc_name','$remarks','$oid','$pay_type','$pay_for','$Address','$street','$state','$zip','$tele','$email','$city','$eventid','$spousename','$purpose','$ReceiveBy')";
           $sql=  "INSERT INTO ".$this->getTable()." VALUES ('$id','$type','$bank','$chkno',$chkdate_sql,'$MemberName',$Amount_sql,'$PaymentOption','$payment_status','$payment_timestamp','$stripe_return','$transaction_id','$paid_amount','$stripe_product',$update_on_sql,$Member_id_sql,'$pay_date','$cc_name','$remarks',$oid_sql,'$pay_type','$pay_for','$Address','$street','$state','$zip','$tele','$alternatenumber','$email','$alternateemail','$city',$eventid_sql,'$spousename','$purpose','$ReceiveBy','$paymentfor',$admin_id_sql,'$admin_name','$membercategory','$DepositAccount')";
            $result = array();
             $arr = $this->execute($sql);
             return $arr;
        
    }
    
}

?>