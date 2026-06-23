<?php

require_once MODELS_PATH . 'App.model.php';

class rentaladvancepaymentModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'advancepayment';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'advanceamount', 'type' => 'int', 'default' => ':NULL'), 
        array('name' => 'description', 'type' => 'int', 'default' => ':NULL') 
		
    );

    public  function getamountadvance()
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