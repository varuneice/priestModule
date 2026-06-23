<?php

require_once MODELS_PATH . 'App.model.php';

class LocalModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'i18n_local';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'language_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'layout', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'value', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'field', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'key', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'arr_key', 'type' => 'varchar', 'default' => ':NULL'),
    );

}

?>