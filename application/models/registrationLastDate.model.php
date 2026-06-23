<?php

require_once MODELS_PATH . 'App.model.php';

class registrationLastDateModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'registrationlastdate';
    
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'registrationDate', 'type' => 'Date', 'default' => ':NULL'),
        array('name' => 'admin_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'admin_name', 'type' => 'varchar', 'default' => '')

    );

}

?>