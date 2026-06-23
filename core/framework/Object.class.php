<?php
class GzObject {
    function _getNextOrder($table, $conditions = array()) {
        $sql_conditions = "";
        if (count($conditions) > 0) {
            foreach ($conditions as $key => $value) {
                $sql_conditions .= " AND `$key` = '$value' ";
            }
        }
        $stmt = $this->pdo->query("SELECT MAX(`order`) AS `max` FROM `" . $table . "` WHERE 1=1 $sql_conditions ");
        $row = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
        return ($row === false || $row['max'] === null) ? 1 : $row['max'] + 1;
    }

    function loadFiles($type, $name) {
        $type = strtolower($type);
        if (!in_array($type, array('model', 'component'))) {
            return false;
        }

        switch ($type) {
            case 'model':
                if (is_array($name)) {
                    foreach ($name as $n) {
                        require_once MODELS_PATH . $n . '.model.php';
                    }
                } else {
                    require_once MODELS_PATH . $name . '.model.php';
                }
                break;
            case 'component':
                if (is_array($name)) {
                    foreach ($name as $n) {
                        require_once COMPONENTS_PATH . $n . '.php';
                    }
                } else {

                    require_once COMPONENTS_PATH . $name . '.php';
                }
                break;
        }
        return;
    }

}