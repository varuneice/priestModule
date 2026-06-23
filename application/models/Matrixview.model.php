<?php

require_once MODELS_PATH . 'App.model.php';

class MatrixviewModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'Matrix';

    var $schema = array(
        array('name' => 'Type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'TotalMatrix', 'type' => 'bigint', 'default' => ':NULL'),
        array('name' => 'KalaBhavan', 'type' => 'decimal', 'default' => ':NULL'),
        array('name' => 'MainParking', 'type' => 'decimal', 'default' => ':NULL'),
        array('name' => 'GreenField', 'type' => 'decimal', 'default' => ':NULL'),
        array('name' => 'JainTemple', 'type' => 'decimal', 'default' => ':NULL'),
    );
    
    public function update($data = array()) {
        $save = array();
        foreach ($this->schema as $field) {

            if (isset($data[$field['name']])) {

                if (!is_array($data[$field['name']])) {
                    $save["`" . $field['name'] . "`"] = $data[$field['name']];
                } else {
                    if (isset($data[$field['name']][0])) {
                        $save["`" . $field['name'] . "`"] = $data[$field['name']][0];
                    }
                }
            }
        }

        $query = new UpdateQuery($this, $this->getTable());
        $query->set($save);
       
        if (!empty($data['ID'])) {
            $query = $query->where('ID', $data['ID']);
        }

        return $query->execute();
    }
     public function getAllData()
    {
        $sql = 'SELECT * FROM '.$this->getTable().'; ';
        $result = array();
        $arr = $this->execute($sql);
        print $sql;
        echo  $sql;
        return $arr;
        
    }
    
    
}            

?>