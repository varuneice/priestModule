<?php

require_once MODELS_PATH . 'App.model.php';

class RentalReservationsHistoryModel extends AppModel  {

    var $primaryKey = 'id';
    var $table = 'rentalreservationshistory';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'booking_number', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'location', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'title', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'first_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'second_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'phone', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'company', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'address_1', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'address_2', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'state', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'city', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'zip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'country', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'fax', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'gender', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'additional', 'type' => 'text', 'default' => ':NULL'),
        array('name' => 'promo_code', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'amount', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'calendars_price', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'discount', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'total', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'tax', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'security', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'deposit', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'payment_method', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'cc_type', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'cc_num', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'cc_code', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'cc_exp_month', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'cc_exp_year', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'created', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'confirm_code', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_return', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'transaction_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'paid_amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'stripe_product', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'date', 'type' => 'varchar', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'enddate', 'type' => 'varchar', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'finalDate', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Member_id', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'advanceamount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'extraamount', 'type' => 'varchar', 'default' => ':NULL')
    );

   function getMaxid(){
        $sql = 'SELECT MAX(id) AS id FROM '.$this->getTable().'; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['id'])){
            return $res[0]['id'];
        }else{
            return 0;
        }
    }
    
    public function SaveDataInhistory($value)
    {
            $uniqueid = $this->getMaxid();
            $id =  $uniqueid +1;
            $calendar_id = $value['calendar_id'] ?? '';
            $location = $value['location'] ?? '';
            $booking_number =  $value['booking_number'] ?? '';
            $first_name = $value['first_name'] ?? '';
            $second_name = $value['second_name'] ?? '';
            $phone = $value['phone'] ?? '';
            $email = $value['email'] ?? '';
            $address_1 = $value['address_1'] ?? '';
            $additional = $value['additional'] ?? '';
            //$payment_timestamp = mktime($payment_times);
            $amount = $value['amount'] ?? '';
            $total =  $value['total'] ?? '';
            $payment_method = $value['payment_method'] ?? '';
            $created = $value['created'] ?? '';
            $stripe_return = $value['stripe_return'] ?? '';
            $transaction_id = $value['transaction_id'] ?? '';
            $paid_amount = $value['paid_amount'] ?? '';
            $stripe_product = $value['stripe_product'] ?? '';
            $date =  $value['date'] ?? '';
            $enddate = $value['enddate'] ?? '';
            $finalDate = $value['finalDate'] ?? '';
            $Member_id = $value['Member_id'] ?? '';
            $advanceamount = '';
            $extraamount = $value['extraamount'] ?? '';
            $rentalprice =  $value['rentalprice'] ?? '';
            $tele = $value['Tele1'] ?? '';
            $email =  $value['email'] ?? '';
            $city = $value['City'] ?? '';
            $title = '';
            $address_2 ='';
            $state ='';
            $zip ='';
            $country ='';
            $fax ='';
            $gender ='';
            $promo_code ='';
            $status = $value['status'] ?? '';
            $calendars_price ='';
            $discount ='';
            $tax ='';
            $security ='';
            $deposit ='';
            $cc_type ='';
            $cc_num ='';
            $cc_code ='';
            $cc_exp_month ='';
            $cc_exp_year ='';
            $company ='';
            $confirm_code ='';

            // SQL-safe values for float/int columns (NULL instead of '' to avoid type errors)
            $calendar_id_sql = ($calendar_id === '' || $calendar_id === null) ? 'NULL' : (int)$calendar_id;
            $amount_sql       = ($amount === '' || $amount === null) ? 'NULL' : (float)$amount;
            $calendars_price_sql = 'NULL';
            $discount_sql     = 'NULL';
            $total_sql        = ($total === '' || $total === null) ? 'NULL' : (float)$total;
            $tax_sql          = 'NULL';
            $security_sql     = 'NULL';
            $deposit_sql      = 'NULL';

            $sql=  "INSERT INTO ".$this->getTable()." VALUES ('$id', $calendar_id_sql, '$location', '$booking_number', '$title', '$first_name', '$second_name', '$phone', '$email', '$company', '$address_1', '$address_2', '$city', '$state', '$zip', '$country', '$fax', '$gender', '$additional', '$promo_code', '$status', $amount_sql, $calendars_price_sql, $discount_sql, $total_sql, $tax_sql, $security_sql, $deposit_sql, '$payment_method', '$cc_type', '$cc_num', '$cc_code', '$cc_exp_month', '$cc_exp_year', '$created', '$confirm_code', '$stripe_return', '$transaction_id', '$paid_amount', '$stripe_product', '$date', '$finalDate', '$enddate', '$Member_id', '$advanceamount', '$extraamount')";
            $result = array();
             $arr = $this->execute($sql);
             return $arr;
        
    } 
}

?>