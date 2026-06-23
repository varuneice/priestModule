<?php

require_once MODELS_PATH . 'App.model.php';
class piechartdataModel extends AppModel
{
    public $primaryKey = 'id';
    public $table = 'piechartData';
    public $schema = array(
        array('name' => 'EventName', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Revenu', 'type' => 'varchar', 'default' => ':NULL')
        
    );

   public function TicketEventsData($opts)
    {
        
        $sql = 'SELECT * FROM '.$this->getTable().' ';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
        
    }
}
?>