<?php

require_once MODELS_PATH . 'App.model.php';

class DonationnewviewModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'Donationnewview';
    
    var $schema = array(
        array('name' => 'pay_date', 'type' => 'Date', 'default' => ':NULL'),
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
        array('name' => 'oid', 'type' => 'int', 'default' => ''),
        array('name' => 'MemberName', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Amount', 'type' => 'float', 'default' => ''),
		array('name' => 'pay_type', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'pay_for', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Mobile', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'purpose', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'chkdate', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paymentfor', 'type' => 'varchar', 'default' => ':NULL')
        
    );
//     function getMaxid(){
//         $sql = 'SELECT MAX(id)
//  AS id FROM '.$this->getTable().'; ';
        
//         $res = $this->execute($sql);
        
//         if(!empty($res[0]['id'])){
//             return $res[0]['id'];
//         }else{
//             return 0;
//         }
//     }
    
   public function DonationAll($opts)
    {
        //$sql = 'SELECT * FROM '.$this->getTable().' WHERE pay_type ="'."Donation".'"';ORDER BY
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE pay_type ="'."DONATION".'" AND pay_for like "%DONATION%" AND Amount >0 ORDER BY pay_date DESC';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    // public function SaveDataInDonation($value)
    // {
    //         $donid = $this->getMaxid();
    //         $id =  $donid +1;
    //         $Member_id = $value['Member_id'];
    //         $type = $value['type'];
    //         $gift =  $value['gift'];
    //         $Payment_For =$value['Payment_For'];
    //         $MemberName = $value['MemberName'];
    //         $Amount = $value['Amount'];
    //         $PaymentOption = $value['PaymentOption'];
    //         $payment_status = $value['payment_status'];
    //         $payment_timestamp = $value['payment_timestamp'];
    //         //$payment_timestamp = mktime($payment_times);
    //         $stripe_return = $value['stripe_return'];
    //         $transaction_id =  $value['transaction_id'];
    //         $paid_amount = $value['paid_amount'];
    //         $stripe_product = $value['stripe_product'];
    //         $update_on = $value['update_on']; 
    //         $pay_date = $value['pay_date'];
    //         $cc_name = $value['MemberName'];
    //         $remarks = $value['remarks'];
    //         $oid =  Util::incrementalHash(4);
    //         $pay_type = $value['pay_type'];
    //         $pay_for = $value['pay_for'];
    //         $Address = $value['Address'];
    //         $street = $value['Street'];
    //         $state = $value['State'];
    //         $zip =  $value['Zip_Code'];
    //         $tele = $value['Tele1'];
    //         $email =  $value['email'];
    //         $city = $value['City'];
    //         $spousename = $value['spousename'];
    //         $eventdonation = $value['eventdonation'];
    //         $purpose = $value['purpose'];
    //         $Address3 = $value['Address3'];
    //         $sql=  "INSERT INTO ".$this->getTable()." VALUES ('$id','$type','$gift','$Payment_For','$MemberName','$Amount','$PaymentOption','$payment_status','$payment_timestamp','$stripe_return','$transaction_id','$paid_amount','$stripe_product','$update_on','$Member_id','$pay_date','$cc_name','$remarks','$oid','$pay_type','$pay_for','$Address','$street','$state','$zip','$tele','$email','$city','$eventdonation','$spousename','$purpose','$Address3')";
    //         $result = array();
    //          $arr = $this->execute($sql);
    //          return $arr;
        
    // }
    public function MemberData($opts)
    {
        //$pay_type =trim($cmCode);
        //$pay_for =trim($cmCode);
        //$year =trim($cmCode);
        //SELECT Donationnewview.pay_for AS EventName,sum(Donationnewview.Amount) AS Revenue FROM Donationnewview WHERE pay_type ="OTHER"  AND year(Donationnewview.pay_date) < 2023 GROUP BY EventName
        //$sql = 'SELECT * FROM '.$this->getTable().' WHERE pay_type ="'."Donation".'"';ORDER BY  year(curdate())
        $sql = 'SELECT donationnewview.pay_for AS MemberType, sum(donationnewview.Amount) AS Revenue'
            . ' FROM ' . $this->getTable()
            . ' WHERE donationnewview.pay_for IN ("DB / HDBS Annual General Membership (GM)", "DB / HDBS Annual Maintenance", "New Membership")'
            . ' AND donationnewview.pay_type = "REGISTRATION"'
            . ' AND year(`donationnewview`.`pay_date`) < year(curdate())'
            . ' GROUP BY donationnewview.pay_for';
        //$sql = 'SELECT Donationnewview.id as ID,Donationnewview.pay_for AS EventName,sum(Donationnewview.Amount) AS Revenue FROM '.$this->getTable().' WHERE  year(`Donationnewview`.`pay_date`) < 2023 GROUP BY EventName';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    
    // for giftshop grid
     public function donationgiftmisc($opts)
    {
        // Query donation table directly (not the view) to include non-member donations
        // The Donationnewview uses INNER JOIN with members, which excludes non-member rows
        $sql = 'SELECT *, email AS Email, Tele1 AS Mobile FROM donation WHERE pay_type IN("GIFT", "MISC") ORDER BY pay_date DESC';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;

    }
    public function donationgiftmiscytd()
    {
        // Query donation table directly (not the view) to include non-member donations
        $sql = 'SELECT SUM(Amount) as misc FROM donation WHERE (year(pay_date) = year(curdate())) and pay_type IN("GIFT", "MISC")';
        $result = array();
        $arr = $this->execute($sql);
        return $arr[0]['misc'] ?? null;

    }
    
}

?>