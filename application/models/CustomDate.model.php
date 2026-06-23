<?php
require_once MODELS_PATH . 'App.model.php';

class CustomDateModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'custom_date';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'tooltip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'timestamp_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'slot_lenght', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'count', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'lunch_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'lunch_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'is_day_off', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'date', 'type' => 'int', 'default' => ':CURRENT_TIMESTAMP'),
    );
    
    function getdata(){
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE calendar_id = 2 ';
            
        $arr = $this->execute($sql);
        return $arr;
    }
    function getpriestdata(){
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE calendar_id = 1 ';
            
        $arr = $this->execute($sql);
        return $arr;
    }

}
