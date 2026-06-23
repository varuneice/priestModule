<?php

require_once MODELS_PATH . 'App.model.php';

class TimePriceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'time_price';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL'),
        
        array('name' => 'monday_tooltip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'tuesday_tooltip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'wednesday_tooltip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'thursday_tooltip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'friday_tooltip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'saturday_tooltip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'sunday_tooltip', 'type' => 'varchar', 'default' => ':NULL'),
        
        array('name' => 'monday_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'tuesday_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'wednesday_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'thursday_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'friday_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'saturday_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'sunday_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'monday_price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'tuesday_price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'wednesday_price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'thursday_price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'friday_price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'saturday_price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'sunday_price', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'monday_slot_lenght', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'tuesday_slot_lenght', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'wednesday_slot_lenght', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'thursday_slot_lenght', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'friday_slot_lenght', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'saturday_slot_lenght', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'sunday_slot_lenght', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'monday_count', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'tuesday_count', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'wednesday_count', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'thursday_count', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'friday_count', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'saturday_count', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'sunday_count', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'monday_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'tuesday_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'wednesday_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'thursday_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'friday_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'saturday_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'sunday_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'monday_lunch_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'tuesday_lunch_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'wednesday_lunch_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'thursday_lunch_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'friday_lunch_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'saturday_lunch_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'sunday_lunch_start', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'monday_lunch_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'tuesday_lunch_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'wednesday_lunch_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'thursday_lunch_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'friday_lunch_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'saturday_lunch_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'sunday_lunch_end', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'monday_is_day_off', 'type' => 'tinyint', 'default' => ':NULL'),
        array('name' => 'tuesday_is_day_off', 'type' => 'tinyint', 'default' => ':NULL'),
        array('name' => 'wednesday_is_day_off', 'type' => 'tinyint', 'default' => ':NULL'),
        array('name' => 'thursday_is_day_off', 'type' => 'tinyint', 'default' => ':NULL'),
        array('name' => 'friday_is_day_off', 'type' => 'tinyint', 'default' => ':NULL'),
        array('name' => 'saturday_is_day_off', 'type' => 'tinyint', 'default' => ':NULL'),
        array('name' => 'sunday_is_day_off', 'type' => 'tinyint', 'default' => ':NULL'),
        array('name' => 'date', 'type' => 'int', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'location_id', 'type' => 'varchar', 'default' => ':NULL'),
    );

    function getCalendarPrices($params, $id) {

        $opts = array();
        $opts['t1.calendar_id = :calendar_id'] = array(':calendar_id' => $id);
        $opts["((:from_date <= t1.from_date AND :to_date > t1.from_date) OR (:from_date <= t1.to_date AND :to_date > t1.to_date))"] = array(':from_date' => $params['from_date'], ':to_date' => $params['to_date']);

        $query = $this->from($this->getTable() . ' as t1')->where($opts);

        /*
          $query->debug = true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />';
         */

        $result = $query->fetchAll();

        return $result;
    }

    function getPrices($params, $id) {

        $opts = array();
        $opts['t1.calendar_id = :calendar_id'] = array(':calendar_id' => $id);
        $query = $this->from($this->getTable() . ' as t1')->where($opts);

        /*
          $query->debug = true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />';
         */

        $result = $query->fetch();

        return $result;
    }

    function getDefaultPrices($id) {
       
        $opts = array();

        $opts['t1.calendar_id = :calendar_id'] = array(':calendar_id' => $id);
        
        $query = $this->from($this->getTable() . ' as t1')->where($opts);

        /*
          $query->debug = true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />';
         */

        $result = $query->fetchAll();

        return $result;
    }

}

?>