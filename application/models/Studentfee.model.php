<?php

require_once MODELS_PATH . 'App.model.php';

class StudentfeeModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'studentsfee';
    
    var $schema = array(
       array('name' => 'Id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'SemmsterName', 'type' => 'varchar', 'default' => ''),
        array('name' => 'Price', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'lateFee', 'type' => 'float', 'default' => ':NULL')
        
    );

    function getMaxid(){
        $sql = 'SELECT MAX(ID) AS ID FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['ID'])){
            return $res[0]['ID'];
        }else{
            return 0;
        }
    }
    public  function getfee()
    {
        $sql = 'SELECT * FROM '.$this->getTable().' ';
        $result = array();
        $arr = $this->execute($sql);
        // foreach ($arr as $key => $value) {
        //     $result[$value['Country']] = $value['CountryCode'];
        // }
        return $arr;
    }
    public function feeprice()
    {
        $regmember=$_POST['regmember'] ?? '';
        $registertype = $_POST['typeregistration'] ?? '';

        $res = 'SELECT * FROM '.$this->getTable().' WHERE  type="'."$regmember".'" AND SemmsterName="'."$registertype".'"';
        $result = array();
        $arr = $this->execute($res);
        foreach ($arr as $key => $value) {
            $result[$value['Price']] = $value['Price'];
        }
        return $arr; 
    }
    
}

?>