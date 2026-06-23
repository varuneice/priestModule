<?php

require_once MODELS_PATH . 'App.model.php';

class ticketModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'tickets';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'oid', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'address', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'tele', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'city', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'state', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'zip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'item_number', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'item_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'item_cost', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'amount', 'type' => 'float', 'default' => ''),
        array('name' => 'pay_for', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_date', 'type' => 'datetime', 'default' => ''),
        array('name' => 'txn_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'PaymentOption', 'varchar' => 'decimal', 'default' => ''),
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ''),
		array('name' => 'cc_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'remarks', 'type' => 'varchar', 'default' => ':NULL'),
        // CreatedOn column does not exist in tickets table — removed
        array('name' => 'UpdateOn', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'), 
        array('name' => 'type', 'type' => 'varchar', 'default' => ''),
        array('name' => 'street', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'eventid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'itemeventday', 'type' => 'varchar', 'default' => ''),
        array('name' => 'bank', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkno', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkdate', 'type' => 'Date', 'default' => ':NULL'),
        array('name' => 'ReceiveBy', 'type' => 'varchar', 'default' => ''),
        array('name' => 'extradonation', 'type' => 'varchar', 'default' => '')

    );
 
    function getticketMaxid(){
        $sql = 'SELECT MAX(id) AS id FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['id'])){
            return $res[0]['id'];
        }else{
            return 0;
        }
    }

    public function ticketAlldata($opts)
    {
        $sql = 'SELECT * FROM '.$this->getTable().'  ORDER BY id DESC';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
    
    
}            

?>