<?php

require_once MODELS_PATH . 'App.model.php';

class FieldModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'i18n_field';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'language_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'in_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'field_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'table_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'value', 'type' => 'text', 'default' => ':NULL'),
    );

    //$data['product_short_description'][1] = 'value1',$data['product_short_description'][2] = 'value2', $data['product_short_description'][3] = 'value3', 
    //$data['product_description'][1] = 'value1',$data['product_description'][2] = 'value2', $data['product_description'][3] = 'value3', 
    function saveI18n($id, $data, $table) {

        foreach ($data as $key => $value) {

            foreach ($value as $k => $v) {
                $field = array();
                $field['language_id'] = $k;
                $field['field_name'] = $key;
                $field['table_name'] = $table;
                $field['value'] = $v;
                $field['in_id'] = $id;

                $this->save($field);
            }
        }
    }

    function updateI18n($id, $data, $table) {

        foreach ($data as $key => $value) {

            foreach ($value as $k => $v) {

                $field = array();
                $field['field_name'] = $key;
                $field['table_name'] = $table;
                $field['value'] = $v;
                $field['in_id'] = $id;

                $this->update($this->getTable())
                        ->set(array('value' => $v))
                        ->where('language_id', $k)
                        ->where('table_name', $table)
                        ->where('field_name', $key)
                        ->where('in_id', $id)
                        ->execute();
            }
        }
    }

    function getI18n($in_id = null, $table = null, $field_name = null, $q = null) {
        $opts = array();

        if (!empty($in_id)) {
            $opts['in_id'] = $in_id;
        }
        if (!empty($table)) {
            $opts['table_name'] = $table;
        }
        if (!empty($field_name)) {
            $opts['field_name'] = $field_name;
        }
        if (!empty($q)) {
            $opts['`value` like ?'] = "%" . $q . "%";
        }
        
        $query = $this->from($this->getTable())->where($opts);
        $arr = $query->fetchAll();

        $result = array();

        foreach ($arr as $key => $value) {
            $result[$value['language_id']][$value['field_name']] = $value['value'];
        }
        return $result;
    }

}

?>