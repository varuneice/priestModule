<?php

require_once MODELS_PATH . 'App.model.php';

class vendorinvoiceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'vendorinvoices';
    
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'oid', 'type' => 'int', 'default' => ''),
        array('name' => 'custid', 'type' => 'varchar', 'default' => ''),
        array('name' => 'name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paytype', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'created_on', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'invoice_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'invoice_num', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'item_desc', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'item_number', 'type' => 'smallint', 'default' => ':NULL'),
        array('name' => 'item_cost', 'type' => 'float', 'default' => ''),
        array('name' => 'amount', 'type' => 'float', 'default' => ''), 
        array('name' => 'status', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_mode', 'type' => 'varchar', 'default' => ''),
        array('name' => 'pay_date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkno', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'bank', 'type' => 'varchar', 'default' => ''),
        array('name' => 'chkdate', 'type' => 'varchar', 'default' => ''),
        array('name' => 'remarks', 'type' => 'varchar', 'default' => ''),
        array('name' => 'update_on', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),

        // newfield
        array('name' => 'payment_status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'payment_timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'receiveby', 'type' => 'varchar', 'default' => '')
        
    );

    function getAllvendorinvoiceData($ID){
        //$sql = 'SELECT * FROM '.$this->getTable().' WHERE custid="'."$ID".'" ';
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE id="'."$ID".'" ';

        $arr = $this->execute($sql);
        return $arr[0] ?? null;
    }

}
