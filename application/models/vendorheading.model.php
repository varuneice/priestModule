<?php

require_once MODELS_PATH . 'App.model.php';

class vendorheadingModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'vendorheading';
    
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'datavendor', 'type' => 'varchar', 'default' => '')
       
        
    );
    function getMaxid(){
        $sql = 'SELECT MAX(id)
 AS id FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['id'])){
            return $res[0]['id'];
        }else{
            return 0;
        }
    }  

   
}

?>