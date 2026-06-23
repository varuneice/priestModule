<?php

require_once MODELS_PATH . 'App.model.php';
class eventrevenueModel extends AppModel
{
    public $primaryKey = 'id';
    public $table = 'piechartDataNew';
    public $schema = array(
        array('name' => 'year', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'EventName', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Revenue', 'type' => 'double', 'default' => ':NULL')
       
    );

    Function DonationForTicketEvents($filter){
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE year="'."$filter".'"';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
    }


}
?>