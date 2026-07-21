<?php

require_once MODELS_PATH . 'App.model.php';

class vendorpriceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'vendorprice';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'paymentfor', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'price', 'type' => 'varchar', 'default' => ':NULL')
    );

    public function paymentfor()
    {
        $paymentfor = $_POST['paymentfor'] ?? '';
     
        //$res = 'SELECT * FROM '.$this->getTable().' WHERE  type="'."$registration".'"';
        
        $res = 'SELECT * FROM '.$this->getTable().' WHERE  paymentfor="'."$paymentfor".'" ';
        $result = array();
        $arr = $this->execute($res);
        foreach ($arr as $key => $value) {
            $result[$value['price']] = $value['type'];
         
        }
        return $arr; 
    }  

}
