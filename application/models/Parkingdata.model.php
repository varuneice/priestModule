<?php

require_once MODELS_PATH . 'App.model.php';

class ParkingdataModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'parkingdata';

    var $schema = array(
       array('name' => 'parkingid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Member_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'Pending_Issues', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Decal', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Name_Authorized', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Signature', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'parking_assigned', 'type' => 'enum', 'default' => ':NULL'),
        array('name' => 'Date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'Registration_Status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Parking_Basis', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'oid', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'senior', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'ct_members', 'type' => 'varchar', 'default' => ':NULL'),
         array('name' => 'sponsor_amount', 'type' => 'varchar', 'default' => ':NULL'),
          array('name' => 'SponsorshipCategory', 'type' => 'varchar', 'default' => ':NULL')
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
       
        if (!empty($data['parkingid'])) {
            $query = $query->where('parkingid', $data['parkingid']);
        }

        return $query->execute();
    }
    
   

}            

?>