<?php

require_once MODELS_PATH . 'App.model.php';

class ticketeventdayModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'ticketevevetday';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'eventid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'itemeventday', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'ticketprice', 'type' => 'varchar', 'default' => ':NULL')
        
   
    );

    public  function getallticket()
    {
        $sql = 'SELECT * FROM '.$this->getTable().' ';
        $result = array();
        $arr = $this->execute($sql);
        // foreach ($arr as $key => $value) {
        //     $result[$value['Country']] = $value['CountryCode'];
        // }
        return $arr;
    }
   

 public function neweventdayprice($eventdayid)
    { 
    
        $res = 'SELECT * FROM '.$this->getTable().' WHERE eventid="'."$eventdayid".'"';
        $result = array();
        $arr = $this->execute($res);
        return $arr; 
       
    }


    public function ticketprice()
    { 
        
        $valticket=$_POST['valticket'] ?? '';
        
       // $res = 'SELECT * FROM '.$this->getTable().' WHERE  ticketprice="'."$dayticket".'"';
        $res = 'SELECT * FROM '.$this->getTable().' WHERE eventid="'."$valticket".'"';
        $result = array();
        $arr = $this->execute($res);
        foreach ($arr as $key => $value) {
            $result[$value['ticketprice']] = $value['itemeventday'];
        }
        return $arr; 
       
    }

     public function ticketall($id)
     {
        
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE eventid ="'.$id.'"';
         $result = array();
         $arr = $this->execute($sql);
         return $arr;
        
     }

    // public function ticketdelete($deleteid)
    // {
    //     $sql = 'DELETE from ' . $this->getTable() . ' eventid ="' . $deleteid . '"';
    //     $result = array();
    //     $arr = $this->execute($sql);
    //     return $arr;
        
    // }

}
 ?>