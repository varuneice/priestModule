<?php

require_once MODELS_PATH . 'App.model.php';

class priestservicepriceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'priestserviceprice';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'pujaname', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'location', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'price', 'type' => 'varchar', 'default' => ':NULL')
    );


//     public function pujapriceinside()
//   {
//     $res = 'SELECT * FROM '.$this->getTable().' WHERE location = "'."inside".'" ORDER BY pujaname';
//     $result = array();
//     $arr = $this->execute($res);
//     return $arr; 
//   }
  
  
//   public function pujapriceoutside()
//   {
//     $res = 'SELECT * FROM '.$this->getTable().' WHERE location = "'."outside".'" ORDER BY pujaname';
//     $result = array();
//     $arr = $this->execute($res);
//     return $arr; 
//   }


 public function pujapriceinside()
  {
    $res = 'SELECT * FROM '.$this->getTable().' WHERE location = "'."inside".'" ORDER BY pujaname';
    $result = array();
    $arr = $this->execute($res);
    return $arr; 
  }

  public function pujaWholeDay()
  {
    $res = 'SELECT * FROM '.$this->getTable().' WHERE location = "'."wholeday".'" ORDER BY pujaname';
    $result = array();
    $arr = $this->execute($res);
    return $arr; 
  }
  
  
  public function pujapriceoutside()
  {
    $res = 'SELECT * FROM '.$this->getTable().' WHERE location = "'."outside".'" ORDER BY pujaname';
    $result = array();
    $arr = $this->execute($res);
    return $arr; 
  }

  public function pujapriceoutsidewholeday()
  {
    $res = 'SELECT * FROM '.$this->getTable().' WHERE location = "'."outsidewholeday".'" ORDER BY pujaname';
    $result = array();
    $arr = $this->execute($res);
    return $arr; 
  }
  
 
}

?>