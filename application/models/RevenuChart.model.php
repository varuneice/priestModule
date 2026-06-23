<?php

require_once MODELS_PATH . 'App.model.php';
class RevenuChartModel extends AppModel
{
    public $primaryKey = 'id';
    public $table = 'RevenuChart';
    public $schema = array(
        array('name' => 'yr', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'mon', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Renew', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Maintenance', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Donation', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Event', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Ticket', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Rental', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Education', 'type' => 'varchar', 'default' => ':NULL')
    );
    public function Chart()
    {
        
        $sql = 'SELECT * FROM '.$this->getTable().' ';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
}
?>