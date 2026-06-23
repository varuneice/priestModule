<?php

require_once MODELS_PATH . 'App.model.php';

class vendorpaymentforModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'vendorpaymenfor';
    
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'payfor', 'type' => 'varchar', 'default' => ''),
        array('name' => 'payforalice', 'type' => 'varchar', 'default' => ''),
        array('name' => 'description', 'type' => 'varchar', 'default' => '')
        
    );

  public function vendorpayment()
    {
      $res = 'SELECT * FROM '.$this->getTable().'';
      $result = array();
      $arr = $this->execute($res);
      return $arr; 
    }

   
}

?>