<?php

require_once MODELS_PATH . 'App.model.php';

class CalendarModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'calendars';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'user_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'title', 'type' => 'varchar', 'default' => ''),
        array('name' => 'description', 'type' => 'text', 'default' => ''),
        array('name' => 'date', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP')
    );

    public function getI18nAll($options = null, $column = null) {
        $this->loadFiles('model', array('Field', 'User', 'Option'));
        $FieldModel = new FieldModel();
        $UserModel = new UserModel();
        $OptionModel = new OptionModel();

        $query = $this->from($this->getTable());
        $query->select(null);
        $query->select($this->getTable() . '.*, t2.first, t2.last, t2.email');
        $query->leftJoin($UserModel->getTable() . ' as t2 ON t2.id = `' . $this->getTable() . '`.`user_id`');
        $query->where($options);
        if (!empty($column)) {

            $query->orderBy("`" . $column . "`");
        }

        $arr = $query->fetchAll();
/////////////////////////////////////////////////////
        $result = array();
        if (!empty($arr)) {
            foreach ($arr as $key => $row) {
                $result[$key] = $row;

                $opts = array();
                $opts['calendar_id'] = $row['id'];

                $result[$key]['options'] = $OptionModel->getAllPairValues($opts);

                $opts = array();

                $opts['table_name'] = $this->getTable();
                $opts['in_id'] = $row['id'];

                $query = $this->from($FieldModel->getTable())->where($opts);
                $i18n_arr = $query->fetchAll();

                foreach ($i18n_arr as $k => $value) {
                    $result[$key]['i18n'][$value['language_id']][$value['field_name']] = $value['value'];
                }
            }
        }
        /* $query->debug=true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />'; */
        return $result;
    }

    function getI18n($id = null) {
        $this->loadFiles('model', array('Field'));
        $FieldModel = new FieldModel();
        
        $options = array();
        if (!empty($id)) {
            $options['id'] = $id;
        }

        $query = $this->from($this->getTable())->where($options);

        if (!empty($column)) {

            $query->orderBy("`" . $column . "`");
        }

        $arr = $query->fetchAll();
        $result = $arr[0] ?? null;

        if (empty($result)) {
            return null;
        }

        $opts['table_name'] = $this->getTable();
        $opts['in_id'] = $result['id'] ?? null;

        $query = $this->from($FieldModel->getTable())->where($opts);
        $i18n_arr = $query->fetchAll();

        foreach ($i18n_arr as $k => $value) {
            $result['i18n'][$value['language_id']][$value['field_name']] = $value['value'];
        }

        $opts = array();

        $opts['calendar_id'] = $result['id'];
        /* $query->debug=true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />'; */
        return $result;
    }

}

?>