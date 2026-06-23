<?php

require_once MODELS_PATH . 'App.model.php';

class BlockingModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'calendar_bloking';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'from_date', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'to_date', 'type' => 'varchar', 'default' => ':NULL')
    );

    function getBlockings($opts) {
        GzObject::loadFiles('Model', array('Calendar', 'Field'));

        $CalendarModel = new CalendarModel();
        $FieldModel = new FieldModel();

        $query = $this->from($this->getTable() . ' as t1');
        $query->select(null);
        $query->select('t1.*, t2.title, t2.id as room_id');
        $query->where($opts);
        $query->leftJoin($CalendarModel->getTable() . ' as t2 ON t2.id = t1.calendar_id');
        $arr = $query->fetchAll();

        $result = array();
        foreach ($arr as $key => $row) {
            $result[$key] = $row;

            $opts['table_name'] = $CalendarModel->getTable();
            $opts['in_id'] = $row['calendar_id'];

            $query = $this->from($FieldModel->getTable())->where($opts);
            $i18n_arr = $query->fetchAll();

            foreach ($i18n_arr as $k => $value) {
                $result[$key]['i18n'][$value['language_id']][$value['field_name']] = $value['value'];
            }

        }

        return $result;
    }

    function getBlockingsWithRoomAndRoomsType($opts) {
        GzObject::loadFiles('Model', array('Calendar'));

        $CalendarModel = new CalendarModel();

        $query = $this->from($this->getTable() . ' as t1');
        $query->select(null);
        $query->select('t1.*, t2.title, t2.calendar_id');
        $query->where($opts);
        $query->leftJoin($CalendarModel->getTable() . ' as t2 ON t2.id = t1.calendar_id');
        
        $blocks = $query->fetchAll();

        return $blocks;
    }

}

?>