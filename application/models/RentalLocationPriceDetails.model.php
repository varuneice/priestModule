<?php

require_once MODELS_PATH . 'App.model.php';

class RentalLocationPriceDetailsModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'rentallocationpricedetails';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'location', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'price', 'type' => 'varchar', 'default' => ':NULL') ,
        array('name' => 'hours', 'type' => 'varchar', 'default' => ':NULL')
    );

    public function locationprice20June()
    {
        $location = $_POST['location'] ?? '';
        $membertype = $_POST['membertype'] ?? '';
        //$res = 'SELECT * FROM '.$this->getTable().' WHERE  type="'."$registration".'"';
        
        $res = 'SELECT * FROM '.$this->getTable().' WHERE  location="'."$location".'" AND type="'."$membertype".'"';
        $result = array();
        $arr = $this->execute($res);
        foreach ($arr as $key => $value) {
            $result[$value['price']] = $value['price'];
        }
        return $arr; 
    }  
    
     public function locationprice()
    {
        $location = $_POST['location'] ?? '';
        $membertype = $_POST['membertype'] ?? '';
        
        $hoursRaw = isset($_POST['hours']) ? trim($_POST['hours']) : null;
        $numericDayRaw = isset($_POST['numericDay']) ? trim($_POST['numericDay']) : '';
        $numericDay = (is_numeric($numericDayRaw) && $numericDayRaw !== '') ? intval($numericDayRaw) : 1;
       
        $res = "";
        if ($hoursRaw !== null && $hoursRaw !== "" && is_numeric($hoursRaw) && floatval($hoursRaw) == 4 &&  $numericDay !== 6   ) {
            $hours = floatval($hoursRaw);
            $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE location="' . $location . '" AND type="' . $membertype . '" AND hours="' . $hours . '"';
        } else {
            // $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE location="' . $location . '" AND type="' . $membertype . '"';
               $res = 'SELECT * FROM ' . $this->getTable() . ' WHERE location="' . $location . '" AND type="' . $membertype . '" AND hours IS NULL';

        }

        

        $result = array();
        $arr = $this->execute($res);
        foreach ($arr as $key => $value) {
            $result[$value['price']] = $value['price'];
        }
        return $arr;
    }

}

?>