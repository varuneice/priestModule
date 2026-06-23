<?php

require_once MODELS_PATH . 'App.model.php';

class ItemsModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'items';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),     
        array('name' => 'categories', 'type' => 'varchar', 'default' => ''),
        array('name' => 'count', 'type' => 'varchar', 'default' => ''),
        array('name' => 'title', 'type' => 'varchar', 'default' => ''),
        array('name' => 'description', 'type' => 'varchar', 'default' => ''),
        array('name' => 'rent_by_hour', 'type' => 'varchar', 'default' => ''),
        array('name' => 'rent_by_day', 'type' => 'varchar', 'default' => ''),
        array('name' => 'rent_by_week', 'type' => 'varchar', 'default' => ''),
        array('name' => 'rent_by_hour', 'type' => 'varchar', 'default' => ''),
        array('name' => 'avatar', 'type' => 'varchar', 'default' => '')
       	
    );
     public  function getitems()
    {
        $sql = 'SELECT * FROM '.$this->getTable().' ';
        $result = array();
        $arr = $this->execute($sql);
        // foreach ($arr as $key => $value) {
        //     $result[$value['Country']] = $value['CountryCode'];
        // }
        return $arr;
    }   


    
}            

?>