<?php

require_once MODELS_PATH . 'App.model.php';

class ThresholdAmountModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'eventthresholdammount';
    
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => null, 'primary' => true, 'auto_increment' => true),
        array('name' => 'amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'createdAt', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'admin_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => ':NULL'),
    );

   
    

    public function  getThresholdAmount()
    {
        $sql = 'SELECT * FROM ' . $this->getTable();
        $arr = $this->execute($sql);
        return $arr; 
    }
    

   







    
}

?>