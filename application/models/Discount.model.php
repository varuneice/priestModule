<?php

require_once MODELS_PATH . 'App.model.php';

class DiscountModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'discount';
    
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'discount_title', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'promo_code', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'discount', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'enum', 'default' => ':NULL')
    );

}

?>