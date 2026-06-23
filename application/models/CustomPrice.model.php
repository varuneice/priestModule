<?php
require_once MODELS_PATH . 'App.model.php';

class CustomPriceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'custom_price';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'start_timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'day', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'price', 'type' => 'float', 'default' => ':NULL'),
    );

}
