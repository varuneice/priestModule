<?php

require_once MODELS_PATH . 'App.model.php';

class LanguagesModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'i18n_languages';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'language', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'flag', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'order', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'isdefault', 'type' => 'tinyint', 'default' => ':NULL')
    );

}

?>