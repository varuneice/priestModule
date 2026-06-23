<?php

require_once MODELS_PATH . 'App.model.php';

class RentalBookingSlotModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'rentalbooking_slot';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'booking_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'timestamp', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'timecreated', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'StartTime', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'EndTime', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Hours', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'count', 'type' => 'int', 'default' => ':NULL')
    );
    
    function getAllBookingSlotData($bookingID){
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE booking_id="'."$bookingID".'" ';
        
        $arr = $this->execute($sql);
        return $arr[0] ?? null;
    }

     function selecteddate($newDatefinal){
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE timestamp="'."$newDatefinal".'" ';
        $result = array();
        $arr = $this->execute($sql);
        return $arr;
    }
    
    //  function getAllRentalBookingSlotData(){
    //     $sql = 'SELECT * FROM '.$this->getTable().' ';
        
    //     $arr = $this->execute($sql);
    //     return $arr;
    // }
    
    
    // method for get booked rental location for show tool tip message 21-APR-2025
    function getBookingRentalLocation($date){
        $sql =  "
        SELECT GROUP_CONCAT(rentalreservations.location SEPARATOR ', ') AS location
        FROM rentalbooking_slot
        INNER JOIN rentalreservations ON rentalreservations.id = rentalbooking_slot.booking_id
        WHERE rentalreservations.finalDate = '$date'";
        $arr = $this->execute($sql);
        return $arr[0]['location'] ?? null;
    }

    // Load ALL dates and locations in ONE query for calendar caching
    function getAllBookingRentalLocations(){
        $sql = "
        SELECT finalDate,
               GROUP_CONCAT(location SEPARATOR ', ') AS location
        FROM rentalreservations
        WHERE finalDate IS NOT NULL AND finalDate != ''
        AND status IN ('confirmed', 'pending')
        GROUP BY finalDate";
        return $this->execute($sql);
    }


    function getLocationRentalBooking($date){

        $sql =  "SELECT rentalreservations.location FROM rentalbooking_slot INNER JOIN rentalreservations ON rentalreservations.id = rentalbooking_slot.booking_id WHERE rentalreservations.finalDate = '$date'";
        $arr = $this->execute($sql);
        return $arr[0]['location'] ?? null;
        
    }
    
    
    function getAllRentalBookingSlotData() {
        $sql = "
        SELECT date AS timestamp, location
        FROM rentalreservations
        WHERE status IN ('confirmed', 'pending')
        AND (
            location = 'both'
            OR date IN (
                SELECT date FROM rentalreservations
                WHERE location IN ('Kalabhavan', 'Auditorium')
                AND status IN ('confirmed', 'pending')
                GROUP BY date
                HAVING COUNT(DISTINCT location) = 2
            )
        )";
        return $this->execute($sql);
    }
    
    
    
    
    
    
    
    
    
}
