<?php

require_once MODELS_PATH . 'App.model.php';

class EventnameModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'event_name';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'events', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Startdate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'Enddate', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'Starttime', 'type' => 'time', 'default' => ':NULL'),
        array('name' => 'Endtime', 'type' => 'time', 'default' => ':NULL'),
        array('name' => 'avatar', 'type' => 'varchar', 'default' => ''),
        array('name' => 'eventtype', 'type' => 'varchar', 'default' => ''),
        array('name' => 'eventdescription', 'type' => 'varchar', 'default' => '')
   
    );

  public  function getevents()
    {
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE eventtype ="event"';
        $result = array();
        $arr = $this->execute($sql);
        // foreach ($arr as $key => $value) {
        //     $result[$value['Country']] = $value['CountryCode'];
        // }
        return $arr;
    }

    public  function getevents2()
    {
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE eventtype ="event2"';
        $result = array();
        $arr = $this->execute($sql);
        // foreach ($arr as $key => $value) {
        //     $result[$value['Country']] = $value['CountryCode'];
        // }
        return $arr;
    }
    
    public  function getevents3()
    {
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE eventtype ="event3"';
        $result = array();
        $arr = $this->execute($sql);
        // foreach ($arr as $key => $value) {
        //     $result[$value['Country']] = $value['CountryCode'];
        // }
        return $arr;
    }
    
     public function checkdatevalid()
    {

        $res = 'SELECT * FROM '.$this->getTable().' WHERE eventtype ="event" AND Enddate >= CURDATE() order by Enddate asc LIMIT 1';

        $result = array();
        $arr = $this->execute($res);
        if (empty($arr)) { return; }
        $pricedata = $arr[0]['price'];
        $eventdescriptions = $arr[0]['eventdescription'];
        $idevent = $arr[0]['id'];
       // echo $pricedata;
       echo  "<input  id='dataprice' value='$pricedata'/> ";
       echo  "<input  id='currenteventdesc' value='$eventdescriptions'/> ";
       echo  "<input  id='uniqueeventid' value='$idevent'/> ";

    }

    public function checkdatevalid2()
    {

        $res = 'SELECT * FROM '.$this->getTable().' WHERE eventtype ="event2" AND Enddate >= CURDATE() order by Enddate asc LIMIT 1';

        $result = array();
        $arr = $this->execute($res);
        if (empty($arr)) { return; }
        $pricedata = $arr[0]['price'];
        $eventdescriptions = $arr[0]['eventdescription'];
        $idevent = $arr[0]['id'];
       // echo $pricedata;
       echo  "<input  id='dataprice' value='$pricedata'/> ";
       echo  "<input  id='currenteventdesc' value='$eventdescriptions'/> ";
       echo  "<input  id='uniqueeventid' value='$idevent'/> ";

    }

    public function checkdatevalid3()
    {

        $res = 'SELECT * FROM '.$this->getTable().' WHERE eventtype ="event3" AND Enddate >= CURDATE() order by Enddate asc LIMIT 1';

        $result = array();
        $arr = $this->execute($res);
        if (empty($arr)) { return; }
        $pricedata = $arr[0]['price'];
        $eventdescriptions = $arr[0]['eventdescription'];
        $idevent = $arr[0]['id'];
       // echo $pricedata;
       echo  "<input  id='dataprice' value='$pricedata'/> ";
       echo  "<input  id='currenteventdesc' value='$eventdescriptions'/> ";
       echo  "<input  id='uniqueeventid' value='$idevent'/> ";

    }

    public function checkdateevent()
    {
        $checkdatevalid = $_POST['checkdatevalid'] ?? '';
        $res = 'SELECT * FROM '.$this->getTable().' WHERE id = "'."$checkdatevalid".'"';
        $result = array();
        $arr = $this->execute($res);
        if (empty($arr)) { return; }
        $pricedata = $arr[0]['price'];
        $eventdescriptions = $arr[0]['eventdescription'];
        $idevent = $arr[0]['id'];
        echo  "<input  id='dataprice' value='$pricedata'/> ";
        echo  "<input  id='currenteventdesc' value='$eventdescriptions'/> ";
        echo  "<input  id='uniqueeventid' value='$idevent'/> ";

    }

    public function getevent()
    {
        $res = 'SELECT * FROM '.$this->getTable();
        $result = array();
        $arr = $this->execute($res);
        foreach ($arr as $key => $value) {
            $result[$value['id']] = $value['events'];
        }
        return $arr;
    }
}
 ?>