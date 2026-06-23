<?php

require_once MODELS_PATH . 'App.model.php';

class nextmidModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'nxtmid';

    var $schema = array(
        array('name' => 'mid', 'type' => 'int', 'default' => ''),
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL')
       
    );
    public function Updateid($id)
    {
        //$code =trim($cmCode);
       // $Date = date("Y/m/d");
        $sql = 'UPDATE '.$this->getTable().' SET mid ="'.$id.'" WHERE id="'."1".'"';
        $result = array();
        $arr = $this->execute($sql);
        
        return $arr;
        
    }
    function getMax(){
        $sql = 'SELECT MAX(mid) AS mid FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['mid'])){
            return $res[0]['mid'];
        }else{
            return 0;
        }
    }

}

?>