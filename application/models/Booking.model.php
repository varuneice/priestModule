<?php

require_once MODELS_PATH . 'App.model.php';

class BookingModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'reservations';
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
        array('name' => 'finalDate', 'type' => 'varchar', 'default' => ':NULL'),
         array('name' => 'Member_id', 'type' => 'varchar', 'default' => ':NULL'),
         array('name' => 'checkbankname', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'checkno', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'checkAmount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'CheckDate', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'CheckDepositAccount', 'type' => 'varchar', 'default' => ':NULL'),
    );

    public function getBookingDetails_23_may($id) {
        GzObject::loadFiles('Model', array('Calendar', 'BookingSlot', 'TimePrice', 'CustomDate'));
        $CalendarModel = new CalendarModel();
        $BookingSlotModel = new BookingSlotModel();
        $TimePriceModel = new TimePriceModel();
        $CustomDateModel = new CustomDateModel();

        $arr = $this->get($id);
        $booked_calendar = $CalendarModel->getI18n($arr['calendar_id']);

        $arr['booked_calendar'] = $booked_calendar;

        $language_arr = $_SESSION['lang'];
        $language_id = $language_arr['id'];

        $arr['calendar'] = $booked_calendar['i18n'][$language_id]['title'];

        $opts = array();

        $opts['booking_id'] = $arr['id'];
        $slots = $BookingSlotModel->getAll($opts);
        $opts = array();
        $opts['calendar_id'] = $arr['calendar_id'];
        $working_time = $TimePriceModel->getAll($opts, 'id');
        
        $opts = array();
        $opts['calendar_id'] = $arr['calendar_id'];
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for($i = $v['timestamp']; $i <= $v['timestamp_end']; $i+=86400){
                    $custom_dates[mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $slot = array();
        
        foreach ($slots as $k => $v) {
            $i = $v['timestamp'];
            $count = $v['count'];
            
            if(!empty($custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))])){
                $slot_lenght = $custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['slot_lenght'];
                $price = $custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['price'];
            }else{

                switch (date('N', $i)) {
                    case '1':
                        $slot_lenght = $working_time[0]['monday_slot_lenght'];
                        $price = $working_time[0]['monday_price'];
                        break;
                    case '2':
                        $slot_lenght = $working_time[0]['tuesday_slot_lenght'];
                        $price = $working_time[0]['tuesday_price'];
                        break;
                    case '3':
                        $slot_lenght = $working_time[0]['wednesday_slot_lenght'];
                        $price = $working_time[0]['wednesday_price'];
                        break;
                    case '4':
                        $slot_lenght = $working_time[0]['thursday_slot_lenght'];
                        $price = $working_time[0]['thursday_price'];
                        break;
                    case '5':
                        $slot_lenght = $working_time[0]['friday_slot_lenght'];
                        $price = $working_time[0]['friday_price'];
                        break;
                    case '6':
                        $slot_lenght = $working_time[0]['saturday_slot_lenght'];
                        $price = $working_time[0]['saturday_price'];
                        break;
                    case '7':
                        $slot_lenght = $working_time[0]['sunday_slot_lenght'];
                        $price = $working_time[0]['sunday_price'];
                        break;
                }
            }

            $slot[] = date('F d, Y H:i', $i) . "-" . date('H:i', ($i + $slot_lenght * 60));
        }
        $arr['slots'] = $slot;
        return $arr;
    }
    
      public function getBookingDetails($id) {
        GzObject::loadFiles('Model', array('Calendar', 'BookingSlot', 'TimePrice', 'CustomDate'));
        $CalendarModel = new CalendarModel();
        $BookingSlotModel = new BookingSlotModel();
        $TimePriceModel = new TimePriceModel();
        $CustomDateModel = new CustomDateModel();

        $arr = $this->get($id);
        if (!$arr) return null;
        $booked_calendar = $CalendarModel->getI18n($arr['calendar_id']);

        $arr['booked_calendar'] = $booked_calendar;

        $language_arr = $_SESSION['lang'];
        $language_id = $language_arr['id'];

        $arr['calendar'] = $booked_calendar['i18n'][$language_id]['title'];

        $opts = array();

        $opts['booking_id'] = $arr['id'];
        $slots = $BookingSlotModel->getAll($opts);
        $bookedLocation = $slots[0]['location'] ?? null;
        $opts = array();
        $opts['calendar_id'] = $arr['calendar_id'];
        $working_time = $TimePriceModel->getAll($opts, 'id');
        
        $opts = array();
        $opts['calendar_id'] = $arr['calendar_id'];
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for($i = $v['timestamp']; $i <= $v['timestamp_end']; $i+=86400){
                    $custom_dates[mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $slot = array();
        
        foreach ($slots as $k => $v) {
            $i = $v['timestamp'];
            $count = $v['count'];
            
            if(!empty($custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))])){
                $slot_lenght = $custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['slot_lenght'];
                $price = $custom_dates[mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['price'];
            }else{

                 $Index = 0;
                    if($bookedLocation == "inside" )
                    {
                        $Index = 0;
                    }

                    if($bookedLocation == "outside" )
                    {
                        $Index = 1;
                    }

                    if($bookedLocation == "wholeday" )
                    {
                        $Index = 2;
                    }

                switch (date('N', $i)) {
                    case '1':
                        $slot_lenght = $working_time[$Index]['monday_slot_lenght'];
                        $price = $working_time[$Index]['monday_price'];
                        break;
                    case '2':
                        $slot_lenght = $working_time[$Index]['tuesday_slot_lenght'];
                        $price = $working_time[$Index]['tuesday_price'];
                        break;
                    case '3':
                        $slot_lenght = $working_time[$Index]['wednesday_slot_lenght'];
                        $price = $working_time[$Index]['wednesday_price'];
                        break;
                    case '4':
                        $slot_lenght = $working_time[$Index]['thursday_slot_lenght'];
                        $price = $working_time[$Index]['thursday_price'];
                        break;
                    case '5':
                        $slot_lenght = $working_time[$Index]['friday_slot_lenght'];
                        $price = $working_time[$Index]['friday_price'];
                        break;
                    case '6':
                        $slot_lenght = $working_time[$Index]['saturday_slot_lenght'];
                        $price = $working_time[$Index]['saturday_price'];
                        break;
                    case '7':
                        $slot_lenght = $working_time[$Index]['sunday_slot_lenght'];
                        $price = $working_time[$Index]['sunday_price'];
                        break;
                }
            }

             if($bookedLocation == "outsidewholeday")
                {
                    $slot[] = date('F d, Y H:i', $i) . "-" . date('H:i', ($i + 360 * 60));
                }

                else{
                   $slot[] = date('F d, Y H:i', $i) . "-" . date('H:i', ($i + $slot_lenght * 60));
                }

            // $slot[] = date('F d, Y H:i', $i) . "-" . date('H:i', ($i + $slot_lenght * 60));
        }
        $arr['slots'] = $slot;
        return $arr;
    }
    
    function saveInvoice($id){
        
        if (!empty($id)) {

            GzObject::loadFiles('Model', array('Invoice', 'Option'));
            $OptionModel = new OptionModel();
            $InvoiceModel = new InvoiceModel();
            
            $booking = $this->get($id);

            $opts = array();
            $opts['calendar_id'] = $booking['calendar_id'];
            $option_arr = $OptionModel->getAllPairValues($opts);

            $data = array();

            $data['invoice_number'] = Util::incrementalHash(10);
            $data['booking_id'] = $id;
            $data['booking_number'] = $booking['booking_number'];
            $data['title'] = $booking['title'];
            $data['first_name'] = $booking['first_name'];
            $data['second_name'] = $booking['second_name'];
            $data['phone'] = $booking['phone'];
            $data['email'] = $booking['email'];
            $data['company'] = $booking['company'];
            $data['address_1'] = $booking['address_1'];
            $data['address_2'] = $booking['address_2'];
            $data['city'] = $booking['city'];
            $data['state'] = $booking['state'];
            $data['zip'] = $booking['zip'];
            $data['country'] = $booking['country'];
            $data['fax'] = $booking['promo_code'];
            $data['male'] = $booking['male'] ?? null;
            $data['additional'] = $booking['additional'];
            $data['status'] = $booking['status'];
            $data['amount'] = $booking['amount'];
            $data['discount'] = $booking['discount'];
            $data['total'] = $booking['total'];
            $data['calendar_price'] = $booking['calendars_price'];
            $data['tax'] = $booking['tax'];
            $data['security'] = $booking['security'];
            $data['deposit'] = $booking['deposit'];
            $data['payment_method'] = $booking['payment_method'];
            $data['invoice_company'] = $option_arr['invoice_company'];
            $data['invoice_name'] = $option_arr['invoice_name'];
            $data['invoice_address'] = $option_arr['invoice_address'];
            $data['invoice_city'] = $option_arr['invoice_city'];
            $data['invoice_state'] = $option_arr['invoice_state'];
            $data['invoice_zip'] = $option_arr['invoice_zip'];
            $data['invoice_fax'] = $option_arr['invoice_fax'];
            $data['invoice_phone'] = $option_arr['invoice_phone'];
            $data['invoice_email'] = $option_arr['invoice_email'];
            $data['slots'] = $option_arr['slots'] ?? null;
            $invoice_id = $InvoiceModel->save($data);
            $invoice = $InvoiceModel->generateInvoice($invoice_id);


            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($invoice);
            $name = 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf';
            $mpdf->Output(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . $name, 'F');

            $save = array();

            return $id;
        }
        
        return false;
    }

    function getAll_23_may($options = null, $column = null, $limit = null) {
        GzObject::loadFiles('Model', array('TimePrice', 'BookingSlot', 'Calendar', 'CustomDate'));
        $TimePriceModel = new TimePriceModel();
        $BookingSlotModel = new BookingSlotModel();
        $CalendarModel = new CalendarModel();
        $CustomDateModel = new CustomDateModel();
        
        $opts = array();
        $custom_dates = $CustomDateModel->getAll($opts);

        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for($i = $v['timestamp']; $i <= $v['timestamp_end']; $i+=86400){
                    $custom_dates[$v['calendar_id']][mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }
        
        $query = $this->from($this->getTable() . ' as t1');
        $query->select('t1.*, t2.user_id as user_id');
        $query->leftJoin($CalendarModel->getTable() . ' as t2 ON t2.id = t1.calendar_id');
        //for new transaction first in grid
        $query->orderBy("t1.id DESC");
        $query = $query->where($options);

        if (!empty($column)) {
            if (strpos($column, ' ')) {
                $query->orderBy($column);
            } else {
                $query->orderBy("`" . $column . "`");
            }
        }
        if (!empty($limit)) {
            $query->limit($limit);
        }
        /*
          $query->debug=true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />';
         */
        $arr = $query->fetchAll();

        $res = array();

        foreach ($arr as $key => $value) {
            $res[$key] = $value;
            $opts = array();

            $opts['booking_id'] = $value['id'];
            $slots = $BookingSlotModel->getAll($opts);
            $opts = array();
            $opts['calendar_id'] = $value['calendar_id'];
            $working_time = $TimePriceModel->getAll($opts, 'id');

            $slot = array();
            foreach ($slots as $k => $v) {
                $i = $v['timestamp'];
                $count = $v['count'];
                
                if(!empty($custom_dates[$value['calendar_id']][mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))])){
                    $slot_lenght = $custom_dates[$value['calendar_id']][mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['slot_lenght'];
                    $price = $custom_dates[$value['calendar_id']][mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['price'];
                }else{

                    switch (date('N', $i)) {
                        case '1':
                            $slot_lenght = $working_time[0]['monday_slot_lenght'];
                            $price = $working_time[0]['monday_price'];
                            break;
                        case '2':
                            $slot_lenght = $working_time[0]['tuesday_slot_lenght'];
                            $price = $working_time[0]['tuesday_price'];
                            break;
                        case '3':
                            $slot_lenght = $working_time[0]['wednesday_slot_lenght'];
                            $price = $working_time[0]['wednesday_price'];
                            break;
                        case '4':
                            $slot_lenght = $working_time[0]['thursday_slot_lenght'];
                            $price = $working_time[0]['thursday_price'];
                            break;
                        case '5':
                            $slot_lenght = $working_time[0]['friday_slot_lenght'];
                            $price = $working_time[0]['friday_price'];
                            break;
                        case '6':
                            $slot_lenght = $working_time[0]['saturday_slot_lenght'];
                            $price = $working_time[0]['saturday_price'];
                            break;
                        case '7':
                            $slot_lenght = $working_time[0]['sunday_slot_lenght'];
                            $price = $working_time[0]['sunday_price'];
                            break;
                    }
                }

                $slot[] = date('m/d/Y H:i', $i) . "-" . date('H:i', ($i + $slot_lenght * 60)) . 'x' . $count;
            }
            $res[$key]['slots'] = $slot;
        }
        return $res;
    }
    
    function getAll($options = null, $column = null, $limit = null) {
        GzObject::loadFiles('Model', array('TimePrice', 'BookingSlot', 'Calendar', 'CustomDate'));
        $TimePriceModel = new TimePriceModel();
        $BookingSlotModel = new BookingSlotModel();
        $CalendarModel = new CalendarModel();
        $CustomDateModel = new CustomDateModel();

        // Load all custom dates in ONE query and build lookup map
        $custom_dates_map = array();
        $all_custom_dates = $CustomDateModel->getAll(array());
        if (!empty($all_custom_dates)) {
            foreach ($all_custom_dates as $v) {
                for ($i = $v['timestamp']; $i <= $v['timestamp_end']; $i += 86400) {
                    $custom_dates_map[$v['calendar_id']][mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $query = $this->from($this->getTable() . ' as t1');
        $query->select('t1.*, t2.user_id as user_id');
        $query->leftJoin($CalendarModel->getTable() . ' as t2 ON t2.id = t1.calendar_id');
        $query->orderBy("t1.id DESC");
        $query = $query->where($options);

        if (!empty($column)) {
            if (strpos($column, ' ')) {
                $query->orderBy($column);
            } else {
                $query->orderBy("`" . $column . "`");
            }
        }
        if (!empty($limit)) {
            $query->limit($limit);
        }

        $arr = $query->fetchAll();

        if (empty($arr)) return array();

        // Collect all booking IDs and unique calendar IDs
        $booking_ids = array_column($arr, 'id');
        $calendar_ids = array_unique(array_column($arr, 'calendar_id'));

        // Load ALL slots for all bookings in ONE query
        $slots_map = array();
        if (!empty($booking_ids)) {
            $in = implode(',', array_map('intval', $booking_ids));
            $all_slots = $BookingSlotModel->execute(
                "SELECT * FROM " . $BookingSlotModel->getTable() . " WHERE booking_id IN ($in)"
            );
            foreach ((array)$all_slots as $slot) {
                $slots_map[$slot['booking_id']][] = $slot;
            }
        }

        // Load time prices per unique calendar_id (usually only 1-5 calendars)
        $working_times_map = array();
        foreach ($calendar_ids as $cal_id) {
            $opts = array('calendar_id' => $cal_id);
            $working_times_map[$cal_id] = $TimePriceModel->getAll($opts, 'id');
        }

        $res = array();
        foreach ($arr as $key => $value) {
            $res[$key] = $value;
            $slots = $slots_map[$value['id']] ?? array();
            $bookLocation = $slots[0]['location'] ?? null;
            $working_time = $working_times_map[$value['calendar_id']] ?? array();

            $slot = array();
            foreach ($slots as $k => $v) {
                $i = $v['timestamp'];
                $count = $v['count'];

                if (!empty($custom_dates_map[$value['calendar_id']][mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))])) {
                    $slot_lenght = $custom_dates_map[$value['calendar_id']][mktime(0, 0, 0, date('m', $i), date('d', $i), date('Y', $i))]['slot_lenght'];
                } else {
                    $arrayIndex = 0;
                    if ($bookLocation == "outside") $arrayIndex = 1;
                    if ($bookLocation == "wholeday") $arrayIndex = 2;

                    switch (date('N', $i)) {
                        case '1': $slot_lenght = $working_time[$arrayIndex]['monday_slot_lenght'] ?? 60; break;
                        case '2': $slot_lenght = $working_time[$arrayIndex]['tuesday_slot_lenght'] ?? 60; break;
                        case '3': $slot_lenght = $working_time[$arrayIndex]['wednesday_slot_lenght'] ?? 60; break;
                        case '4': $slot_lenght = $working_time[$arrayIndex]['thursday_slot_lenght'] ?? 60; break;
                        case '5': $slot_lenght = $working_time[$arrayIndex]['friday_slot_lenght'] ?? 60; break;
                        case '6': $slot_lenght = $working_time[$arrayIndex]['saturday_slot_lenght'] ?? 60; break;
                        case '7': $slot_lenght = $working_time[$arrayIndex]['sunday_slot_lenght'] ?? 60; break;
                        default:  $slot_lenght = 60;
                    }
                }

                if ($bookLocation == "outsidewholeday") {
                    $slot[] = date('m/d/Y H:i', $i) . "-" . date('H:i', ($i + 360 * 60)) . 'x' . $count;
                } else {
                    $slot[] = date('m/d/Y H:i', $i) . "-" . date('H:i', ($i + $slot_lenght * 60)) . 'x' . $count;
                }
            }
            $res[$key]['slots'] = $slot;
        }
        return $res;
    }
    function getMax(){
        $sql = 'SELECT booking_number FROM '.$this->getTable().' order by created  DESC LIMIT 1; ';
        
        $res = $this->execute($sql);
        
        if(!empty($res[0]['booking_number'])){
            return $res[0]['booking_number'];
        }else{
            return 0;
        }
    }

}

?>