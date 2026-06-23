<?php

require_once MODELS_PATH . 'App.model.php';

class vendorpaymentaccountModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'vendorpaymentaccount';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'paymentaccount', 'type' => 'varchar', 'default' => ':NULL'), 
        array('name' => 'admin_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'modulename', 'type' => 'varchar', 'default' => '')
    );
    
   public function getEventPaymentAccountName($modulename)
    {
        
        $sql = 'SELECT paymentaccount, id FROM ' . $this->getTable() . " WHERE modulename = '$modulename'";
        $arr = $this->execute($sql);
        return $arr;
        
    }

    public function getVendorPaymentAccountName($modulename)
    {
        
        $sql = 'SELECT paymentaccount, id FROM ' . $this->getTable() . " WHERE modulename = '$modulename'";
        $arr = $this->execute($sql);
        return $arr;
        
    }

    public function EventPaymentAccount()
    {
        $sql = 'SELECT * FROM ' . $this->getTable() . " WHERE modulename NOT IN ('vendor')";
        $arr = $this->execute($sql);
        return $arr; 
    }

}

?>