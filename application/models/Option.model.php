<?php

require_once MODELS_PATH . 'App.model.php';

class OptionModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'options';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'key', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'tab_id', 'type' => 'tinyint', 'default' => ':NULL'),
        array('name' => 'group', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'value', 'type' => 'text', 'default' => ':NULL'),
        array('name' => 'title', 'type' => 'text', 'default' => ':NULL'),
        array('name' => 'description', 'type' => 'text', 'default' => ':NULL'),
        array('name' => 'label', 'type' => 'text', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'order', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL')
    );
    
    function getAllPairs($options = array()) {
        $arr = array();
        $result = $this->getAll($options);
        if (!empty($result)) {
            foreach ($result as $row) {
                $arr[$row['key']] = $row['value'];
            }
        }
        return $arr;
    }

    /**
     * Get array of key => values. Clear special values
     *
     * @param none
     * @access public
     * @return array
     */
    function getPairs($options = array()) {
        $arr = array();

        $result = $this->getAll($options);

        if (!empty($result)) {
            foreach ($result as $row) {
                switch ($row['type']) {
                    case 'enum':
                        list(, $arr[$row['key']]) = explode("::", $row['value'] ?? '');
                        break;
                    default:
                        $arr[$row['key']] = $row['value'];
                        break;
                }
            }
        }
        return $arr;
    }

    /**
     *
     * Gets all options and their values
     */
    function getAllPairValues($options = array()) {
        $arr = array();

        $result = $this->getAll($options);

        if (!empty($result)) {
            foreach ($result as $row) {
                if ($row['type'] == 'enum') {
                    if ($row['key'] == 'layout') {
                        list(, $value) = explode("::", $row['value'] ?? '');
                        $value = str_replace(' ', '_', strtolower($value));
                        $arr[$row['key']] = $value;
                    } else {
                        list(, $value) = explode("::", $row['value'] ?? '');
                        $arr[$row['key']] = $value;
                    }
                } else {
                    $arr[$row['key']] = $row['value'];
                }
            }
        }

        return $arr;
    }
    
    function getAllCalendarsPairValues($options = array()) {
        $arr = array();

        $result = $this->getAll($options);

        if (!empty($result)) {
            foreach ($result as $row) {
                if ($row['type'] == 'enum') {
                    if ($row['key'] == 'layout') {
                        list(, $value) = explode("::", $row['value'] ?? '');
                        $value = str_replace(' ', '_', strtolower($value));
                        $arr[$row['calendar_id']][$row['key']] = $value;
                    } else {
                        list(, $value) = explode("::", $row['value'] ?? '');
                        $arr[$row['calendar_id']][$row['key']] = $value;
                    }
                } else {
                    $arr[$row['calendar_id']][$row['key']] = $row['value'];
                }
            }
        }

        return $arr;
    }

    /**
     *
     * Check to know whether Option table has data or not
     */
    function checkOptionExist() {
        $arr = $this->getAll();
        if (!empty($arr)) {
            return true;
        } else {
            return false;
        }
    }

}

?>