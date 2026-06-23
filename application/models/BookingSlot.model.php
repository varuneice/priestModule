<?php

require_once MODELS_PATH . 'App.model.php';

class BookingSlotModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'booking_slot';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'booking_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'timecreated', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'count', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'location', 'type' => 'varchar', 'default' => ':NULL'),
    );

}
