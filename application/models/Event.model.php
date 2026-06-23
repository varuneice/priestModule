<?php

require_once MODELS_PATH . 'App.model.php';

class EventModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'event';

     var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'eventid', 'type' => 'int', 'default' => ''),
        array('name' => 'Payment_For', 'type' => 'varchar', 'default' => ''),
        array('name' => 'MemberName', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Amount', 'type' => 'float', 'default' => ''),
        array('name' => 'eventdonation', 'type' => 'float', 'default' => ''),
        array('name' => 'totaldonation', 'type' => 'float', 'default' => ''),
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
        array('name' => 'description', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'bank', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkno', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkdate', 'type' => 'Date', 'default' => ':NULL'),
        array('name' => 'ReceiveBy', 'type' => 'varchar', 'default' => '')
        
		
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
    
   public function EventAll($opts)
    {
        $sql = 'SELECT * FROM '.$this->getTable().'  ORDER BY id DESC';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }

}            

?>