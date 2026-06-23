<?php

require_once MODELS_PATH . 'App.model.php';

class idnumbersModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'idnumbers';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'oid', 'type' => 'int', 'default' => ''),
        array('name' => 'oid_puja', 'type' => 'int', 'default' => ''),
        array('name' => 'reg_uid', 'type' => 'int', 'default' => '')
       
    );

    // for oid row 
    public function Updateoid($id)
    {
        //$code =trim($cmCode);
       // $Date = date("Y/m/d");
        $sql = 'UPDATE '.$this->getTable().' SET oid ="'.$id.'" WHERE id="'."1".'"';
        $result = array();
        $arr = $this->execute($sql);
        
        return $arr;
        
    }

    function getMaxoid(){
        $sql = 'SELECT MAX(oid) AS oid FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['oid'])){
            return $res[0]['oid'];
        }else{
            return 0;
        }
    }


// for mid row

    public function Updatemid($id)
    {
        //$code =trim($cmCode);
       // $Date = date("Y/m/d");
        $sql = 'UPDATE '.$this->getTable().' SET reg_uid ="'.$id.'" WHERE id="'."1".'"';
        $result = array();
        $arr = $this->execute($sql);
        
        return $arr;
        
    }
    function getMaxmid(){
        $sql = 'SELECT MAX(reg_uid) AS reg_uid FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['reg_uid'])){
            return $res[0]['reg_uid'];
        }else{
            return 0;
        }
    }

}

?>