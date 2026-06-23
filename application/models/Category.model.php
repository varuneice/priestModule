<?php

require_once MODELS_PATH . 'App.model.php';

class CategoryModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'category';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'category', 'type' => 'int', 'default' => ':NULL')
		
    );
    public  function getcategory()
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