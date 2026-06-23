<?php

require_once MODELS_PATH . 'App.model.php';

class CountryModel extends AppModel {

    var $primaryKey = 'ID';
    var $table = 'countries';
    var $schema = array(
        array('name' => 'ID', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Countries', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'CountryCode', 'type' => 'varchar', 'default' => ':NULL')
        
    );

    public  function getCountry()
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