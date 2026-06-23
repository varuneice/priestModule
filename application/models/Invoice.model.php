<?php

require_once MODELS_PATH . 'App.model.php';

class InvoiceModel extends AppModel {

    var $primaryKey = 'id';
    var $table = 'invoice';
    var $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'invoice_number', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'booking_id', 'type' => 'int', 'default' => ':NULL'),
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
        array('name' => 'male', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'currency', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'calendar_price', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'amount', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'discount', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'total', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'tax', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'security', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'deposit', 'type' => 'float', 'default' => ':NULL'),
        array('name' => 'calendars_number', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'payment_method', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'invoice_company', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'invoice_name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'invoice_address', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'invoice_city', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'invoice_state', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'invoice_zip', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'invoice_fax', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'invoice_phone', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'invoice_email', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'date', 'type' => 'timestamp', 'default' => ':CURRENT_TIMESTAMP'),
        array('name' => 'booking_number', 'type' => 'varchar', 'default' => ':NULL'),
         array('name' => 'additional', 'type' => 'text', 'default' => ':NULL')
    );

    public function generateInvoice_23_may($id) {
        GzObject::loadFiles('Model', array('Option', 'Booking', 'Invoice'));

        $BookingModel = new BookingModel();
        $InvoiceModel = new InvoiceModel();
        $OptionModel = new OptionModel();

        $invoice = $InvoiceModel->get($id);
        if (!$invoice) return '';
        $booking_details = $BookingModel->getBookingDetails($invoice['booking_id']);
        if (!$booking_details) return '';

        $opts = array();
        $opts['calendar_id'] = $booking_details['calendar_id'] ?? null;
        $option_arr = $OptionModel->getAllPairValues($opts);

        $replacement = array();

        $replacement['calendar'] = $booking_details['calendar'] ?? '';
        $replacement['booking_number'] = $booking_details['booking_number'] ?? '';
        $replacement['booking_id'] = $invoice['booking_id'] ?? '';
        $replacement['title'] = $invoice['title'] ?? '';
        $replacement['first_name'] = $invoice['first_name'] ?? '';
        $replacement['second_name'] = $invoice['second_name'] ?? '';
        $replacement['phone'] = $invoice['phone'] ?? '';
        $replacement['email'] = $invoice['email'] ?? '';
        $replacement['company'] = $invoice['company'] ?? '';
        $replacement['address_1'] = $invoice['address_1'] ?? '';
        $replacement['address_2'] = $invoice['address_2'] ?? '';
        $replacement['city'] = $invoice['city'] ?? '';
        $replacement['state'] = $invoice['state'] ?? '';
        $replacement['zip'] = $invoice['zip'] ?? '';
        $replacement['country'] = $invoice['country'] ?? '';
        $replacement['fax'] = $invoice['fax'] ?? '';
        $replacement['male'] = $invoice['male'] ?? '';
        $replacement['additional'] = $invoice['additional'] ?? '';
        $replacement['slots'] = implode(', ', (array)($booking_details['slots'] ?? []));
        $location_arr = __('location_arr');
        $replacement['location'] = $location_arr[$booking_details['location'] ?? ''] ?? '';

        if (!empty($booking_details['calendars'])) {
            $replacement['calendars'] = $booking_details['calendar'] ?? '';
        } else {
            $replacement['calendars'] = '';
        }
        $payment_method = __('payment_method_arr');
        $replacement['payment_method'] = $payment_method[$invoice['payment_method'] ?? ''] ?? '';
        $replacement['deposit'] = Util::currenctFormat($option_arr['currency'] ?? '', $invoice['deposit'] ?? 0);
        $replacement['tax'] = Util::currenctFormat($option_arr['currency'] ?? '', $invoice['tax'] ?? 0);
        $replacement['total'] = Util::currenctFormat($option_arr['currency'] ?? '', $invoice['total'] ?? 0);
        $replacement['calendar_price'] = Util::currenctFormat($option_arr['currency'] ?? '', $invoice['calendar_price'] ?? 0);
        $replacement['discount'] = Util::currenctFormat($option_arr['currency'] ?? '', $invoice['discount'] ?? 0);
        $replacement['invoice_number'] = $invoice['invoice_number'] ?? '';
        $replacement['invoice_company'] = $invoice['additional'] ?? '';
        $replacement['invoice_name'] = $invoice['invoice_name'] ?? '';
        $replacement['invoice_address'] = $invoice['invoice_address'] ?? '';
        $replacement['invoice_city'] = $invoice['invoice_city'] ?? '';
        $replacement['invoice_state'] = $invoice['invoice_state'] ?? '';
        $replacement['invoice_zip'] = $invoice['invoice_zip'] ?? '';
        $replacement['invoice_fax'] = $invoice['invoice_fax'] ?? '';
        $replacement['invoice_phone'] = $invoice['invoice_phone'] ?? '';
        $replacement['invoice_email'] = $invoice['invoice_email'] ?? '';
        $replacement['date'] = date($option_arr['date_format'] ?? 'Y-m-d', strtotime($invoice['date'] ?? 'now'));
        $replacement['status'] = $invoice['status'] ?? '';
        $replacement['create_date'] = $invoice['date'] ?? '';
        $replacement['transaction_id'] = $booking_details['transaction_id'] ?? '';
        return $result = Util::replaceInvoiceToken($option_arr['invoice'] ?? '', $replacement);
    }
    
     public function generateInvoice($id) {
        GzObject::loadFiles('Model', array('Option', 'Booking', 'Invoice'));

        $BookingModel = new BookingModel();
        $InvoiceModel = new InvoiceModel();
        $OptionModel = new OptionModel();

        $invoice = $InvoiceModel->get($id);
        if (!$invoice) return '';
        $booking_details = $BookingModel->getBookingDetails($invoice['booking_id']);
        if (!$booking_details) return '';

        $opts = array();
        $opts['calendar_id'] = $booking_details['calendar_id'] ?? null;
        $option_arr = $OptionModel->getAllPairValues($opts);

        $replacement = array();


    $bookingLocation = "" ;
      if(  $booking_details['location'] == "inside")
      {
        $bookingLocation = "Inside Durgabari" ;
      }

      else if(  $booking_details['location'] == "outside")
      {
        $bookingLocation = "Outside Durgabari" ;
      }

      else if(  $booking_details['location'] == "outsidewholeday")
      {
        $bookingLocation = "Outside Durgabari / Whole day" ;
      }
       else if(  $booking_details['location'] == "wholeday")
      {
        $bookingLocation = "Out of town / Whole day" ;
      }

      else
      {
        $location_arr = __('location_arr');
        $bookingLocation = $location_arr[$booking_details['location'] ?? ''] ?? '';
      }

        $replacement['calendar'] = $booking_details['calendar'] ?? '';
        $replacement['booking_number'] = $booking_details['booking_number'] ?? '';
        $replacement['booking_id'] = $invoice['booking_id'] ?? '';
        $replacement['title'] = $invoice['title'] ?? '';
        $replacement['first_name'] = $invoice['first_name'] ?? '';
        $replacement['second_name'] = $invoice['second_name'] ?? '';
        $replacement['phone'] = $invoice['phone'] ?? '';
        $replacement['email'] = $invoice['email'] ?? '';
        $replacement['company'] = $invoice['company'] ?? '';
        $replacement['address_1'] = $invoice['address_1'] ?? '';
        $replacement['address_2'] = $invoice['address_2'] ?? '';
        $replacement['city'] = $invoice['city'] ?? '';
        $replacement['state'] = $invoice['state'] ?? '';
        $replacement['zip'] = $invoice['zip'] ?? '';
        $replacement['country'] = $invoice['country'] ?? '';
        $replacement['fax'] = $invoice['fax'] ?? '';
        $replacement['male'] = $invoice['male'] ?? '';
        $replacement['additional'] = $invoice['additional'] ?? '';
        $replacement['slots'] = implode(', ', (array)($booking_details['slots'] ?? []));
        $replacement['location'] = $bookingLocation;

        if (!empty($booking_details['calendars'])) {
            $replacement['calendars'] = $booking_details['calendar'] ?? '';
        } else {
            $replacement['calendars'] = '';
        }
        $payment_method = __('payment_method_arr');
        $replacement['payment_method'] = $payment_method[$invoice['payment_method'] ?? ''] ?? '';
        $replacement['deposit'] = Util::currenctFormat($option_arr['currency'] ?? '', $invoice['deposit'] ?? 0);
        $replacement['tax'] = Util::currenctFormat($option_arr['currency'] ?? '', $invoice['tax'] ?? 0);
        $replacement['total'] = Util::currenctFormat($option_arr['currency'] ?? '', $invoice['total'] ?? 0);
        $replacement['calendar_price'] = Util::currenctFormat($option_arr['currency'] ?? '', $invoice['calendar_price'] ?? 0);
        $replacement['discount'] = Util::currenctFormat($option_arr['currency'] ?? '', $invoice['discount'] ?? 0);
        $replacement['invoice_number'] = $invoice['invoice_number'] ?? '';
        $replacement['invoice_company'] = $invoice['additional'] ?? '';
        $replacement['invoice_name'] = $invoice['invoice_name'] ?? '';
        $replacement['invoice_address'] = $invoice['invoice_address'] ?? '';
        $replacement['invoice_city'] = $invoice['invoice_city'] ?? '';
        $replacement['invoice_state'] = $invoice['invoice_state'] ?? '';
        $replacement['invoice_zip'] = $invoice['invoice_zip'] ?? '';
        $replacement['invoice_fax'] = $invoice['invoice_fax'] ?? '';
        $replacement['invoice_phone'] = $invoice['invoice_phone'] ?? '';
        $replacement['invoice_email'] = $invoice['invoice_email'] ?? '';
        $replacement['date'] = date($option_arr['date_format'] ?? 'Y-m-d', strtotime($invoice['date'] ?? 'now'));
        $replacement['status'] = $invoice['status'] ?? '';
        $replacement['create_date'] = $invoice['date'] ?? '';
        $replacement['transaction_id'] = $booking_details['transaction_id'] ?? '';
        return $result = Util::replaceInvoiceToken($option_arr['invoice'] ?? '', $replacement);
    }
    
     function getAll($options = null, $column = null, $limit = null) {
        GzObject::loadFiles('Model', array('Booking'));
        $BookingModel = new BookingModel();

        $query = $this->from($this->getTable() . ' as t1');
        $query->select('t1.*, t2.booking_number as booking_number');
        $query->leftJoin($BookingModel->getTable() . ' as t2 ON t2.id = t1.booking_id');
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
       // echo $query->getQuery();
        /*
          $query->debug=true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />';
         */
        $arr = $query->fetchAll();
        
        return $arr;
    }

}

?>