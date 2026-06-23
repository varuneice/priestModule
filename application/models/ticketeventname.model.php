<?php

require_once MODELS_PATH . 'App.model.php';

class ticketeventnameModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'ticketevent_name';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'ticketevents', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'ticketprice', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'ticketStartdate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'ticketEnddate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'ticketStarttime', 'type' => 'time', 'default' => ':NULL'),
        array('name' => 'ticketEndtime', 'type' => 'time', 'default' => ':NULL'),
        array('name' => 'ticketavatar', 'type' => 'varchar', 'default' => ''),
        array('name' => 'eventtype', 'type' => 'varchar', 'default' => ''),
        array('name' => 'itemeventday', 'type' => 'varchar', 'default' => ''),
         array('name' => 'descriptionTable', 'type' => 'varchar', 'default' => '')
   
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
    public function checkticket()
    {

        $res = 'SELECT * FROM '.$this->getTable().' WHERE ticketEnddate >= CURDATE() order by ticketEnddate asc LIMIT 1';

        $result = array();
       $arr = $this->execute($res);
        if (empty($arr)) { return null; }
        $pricedata = $arr[0]['ticketevents'];
        $ticketavatar = $arr[0]['ticketavatar'];
        $descriptionTable = $arr[0]['descriptionTable'];
        $idevent = $arr[0]['id'];
       // echo $pricedata;
       // echo $pricedata;
    //    echo  "<input  id='dataprice' value='$pricedata'/> ";
    //    echo  "<input  id='eventid' value='$idevent'/> ";
    //    echo  "<input  id='ticketimage' value='$ticketavatar'/> ";
    //    echo  "<input  id='descriptiontext' value='$descriptionTable'/> ";
       return $arr[0];
    }

}
 ?>