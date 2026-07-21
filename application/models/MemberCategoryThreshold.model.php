<?php

require_once MODELS_PATH . 'App.model.php';

class MemberCategoryThresholdModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'member_category_thresholds';

    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'category_code', 'type' => 'varchar', 'default' => ''),
        array('name' => 'category_name', 'type' => 'varchar', 'default' => ''),
        array('name' => 'threshold_amount', 'type' => 'decimal', 'default' => '0.00'),
        array('name' => 'display_order', 'type' => 'int', 'default' => '0'),
        array('name' => 'is_active', 'type' => 'tinyint', 'default' => '1'),
        array('name' => 'created_on', 'type' => 'datetime', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'updated_on', 'type' => 'datetime', 'default' => ':CURRENT_TIMESTAMP')
    );

    public function getActiveThresholds()
    {
        return $this->getAll(array('is_active' => 1), 'display_order ASC, threshold_amount ASC');
    }

    public function getThresholdMap()
    {
        $thresholds = array();
        $rows = $this->getActiveThresholds();

        foreach ($rows as $row) {
            $thresholds[$row['category_code']] = (float) $row['threshold_amount'];
        }

        return $thresholds;
    }

    public function updateThresholdAmount($id, $amount)
    {
        $id = (int) $id;
        $amount = (float) $amount;

        if ($id <= 0 || $amount < 0) {
            return false;
        }

        $stmt = $this->getPdo()->prepare('UPDATE ' . $this->getTable() . ' SET threshold_amount = :amount WHERE id = :id');
        $stmt->execute(array(':amount' => $amount, ':id' => $id));

        return true;
    }
}
