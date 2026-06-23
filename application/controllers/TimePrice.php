<?php

require_once CONTROLLERS_PATH . 'App.php';

class TimePrice extends App {

    var $layout = 'admin';
    var $option_arr = null;

    function beforeFilter() {

        GzObject::loadFiles('Model', 'Option');
        $OptionModel = new OptionModel();
        $this->option_arr = $OptionModel->getAllPairValues();
        $this->tpl['option_arr'] = $OptionModel->getAllPairs();
        $this->tpl['option_arr_values'] = $this->option_arr;

        $this->tpl['js_format'] = Util::getJsDateFormta($this->tpl['option_arr_values']['date_format']);
        $this->tpl['iso_format'] = Util::getISODateFormta($this->tpl['option_arr_values']['date_format']);

        $tz = $this->tpl['option_arr_values']['timezone'] ?? '';
        if ($tz) {
            date_default_timezone_set($tz);
        }

        if (!($this->isLoged()) && ($_REQUEST['action'] ?? '') != 'login') {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }
        
        if ($this->isMember() ) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }

        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'gzadmin/plugins/touchspin/jquery.bootstrap-touchspin.css', 'path' => JS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/timepicker/bootstrap-timepicker.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.min.js', 'path' => LIBS_PATH . 'jquery/ui/');
        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/touchspin/jquery.bootstrap-touchspin.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/timepicker/bootstrap-timepicker.min.js', 'path' => JS_PATH);

        switch (@$_REQUEST['action']) {
            case 'price':
                $this->js[] = array('file' => '/ajax-upload/jquery.form.js', 'path' => JS_PATH);
                break;
        }

        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzTimePrice.js', 'path' => JS_PATH);
    }

    function index23May() {

        GzObject::loadFiles('Model', array('Calendar', 'TimePrice', 'CustomDate'));
        $CalendarModel = new CalendarModel();
        $TimePriceModel = new TimePriceModel();
        $CustomDateModel = new CustomDateModel();
        
       if ($this->isAdmin()) {
        $this->tpl['arr'] = $CustomDateModel->getAll();
        }
        if ($this->isEditor()) {
        $this->tpl['arr'] = $CustomDateModel->getpriestdata();
        }
        
        
        foreach (($this->tpl['arr'] ?? []) as $k => $v) {
            $this->tpl['arr'][$k]['calendar'] = $CalendarModel->getI18n($v['calendar_id']);
        }
        
        $opts = array();

        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }

        if ($this->isRental()) {
            $opts['user_id'] = $this->getUserId();
        }
        
        $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);

        if (!empty($_GET['id'] ?? '')) {
            $this->tpl['default_calendar'] = $CalendarModel->getI18n($_GET['id'] ?? '');
        } elseif (!empty($this->tpl['calendars'][0])) {

            $this->tpl['default_calendar'] = $this->tpl['calendars'][0];
        }
        if (!empty($_POST['workin_time_send'])) {

            $data = array();
            $data['monday_is_day_off'] = (!empty($_POST['monday_is_day_off'])) ? 1 : 0;
            $data['tuesday_is_day_off'] = (!empty($_POST['tuesday_is_day_off'])) ? 1 : 0;
            $data['wednesday_is_day_off'] = (!empty($_POST['wednesday_is_day_off'])) ? 1 : 0;
            $data['thursday_is_day_off'] = (!empty($_POST['thursday_is_day_off'])) ? 1 : 0;
            $data['friday_is_day_off'] = (!empty($_POST['friday_is_day_off'])) ? 1 : 0;
            $data['saturday_is_day_off'] = (!empty($_POST['saturday_is_day_off'])) ? 1 : 0;
            $data['sunday_is_day_off'] = (!empty($_POST['sunday_is_day_off'])) ? 1 : 0;
            
            $data['monday_price'] = (!empty($_POST['monday_price'])) ? $_POST['monday_price'] : 0;
            $data['tuesday_price'] = (!empty($_POST['tuesday_price'])) ? $_POST['tuesday_price'] : 0;
            $data['wednesday_price'] = (!empty($_POST['wednesday_price'])) ? $_POST['wednesday_price'] : 0;
            $data['thursday_price'] = (!empty($_POST['thursday_price'])) ? $_POST['thursday_price'] : 0;
            $data['friday_price'] = (!empty($_POST['friday_price'])) ? $_POST['friday_price'] : 0;
            $data['saturday_price'] = (!empty($_POST['saturday_price'])) ? $_POST['saturday_price'] : 0;
            $data['sunday_price'] = (!empty($_POST['sunday_price'])) ? $_POST['sunday_price'] : 0;
            
            $data['monday_slot_lenght'] = (!empty($_POST['monday_slot_lenght'])) ? $_POST['monday_slot_lenght'] : 0;
            $data['tuesday_slot_lenght'] = (!empty($_POST['tuesday_slot_lenght'])) ? $_POST['tuesday_slot_lenght'] : 0;
            $data['wednesday_slot_lenght'] = (!empty($_POST['wednesday_slot_lenght'])) ? $_POST['wednesday_slot_lenght'] : 0;
            $data['thursday_slot_lenght'] = (!empty($_POST['thursday_slot_lenght'])) ? $_POST['thursday_slot_lenght'] : 0;
            $data['friday_slot_lenght'] = (!empty($_POST['friday_slot_lenght'])) ? $_POST['friday_slot_lenght'] : 0;
            $data['saturday_slot_lenght'] = (!empty($_POST['saturday_slot_lenght'])) ? $_POST['saturday_slot_lenght'] : 0;
            $data['sunday_slot_lenght'] = (!empty($_POST['sunday_slot_lenght'])) ? $_POST['sunday_slot_lenght'] : 0;
            
            $data['monday_count'] = (!empty($_POST['monday_count'])) ? $_POST['monday_count'] : 0;
            $data['tuesday_count'] = (!empty($_POST['tuesday_count'])) ? $_POST['tuesday_count'] : 0;
            $data['wednesday_count'] = (!empty($_POST['wednesday_count'])) ? $_POST['wednesday_count'] : 0;
            $data['thursday_count'] = (!empty($_POST['thursday_count'])) ? $_POST['thursday_count'] : 0;
            $data['friday_count'] = (!empty($_POST['friday_count'])) ? $_POST['friday_count'] : 0;
            $data['saturday_count'] = (!empty($_POST['saturday_count'])) ? $_POST['saturday_count'] : 0;
            $data['sunday_count'] = (!empty($_POST['sunday_count'])) ? $_POST['sunday_count'] : 0;
            
            if (!empty($_POST['id'])) {
                $TimePriceModel->update(array_merge($_POST, $data));
            } else {
                unset($_POST['id']);
                $TimePriceModel->save(array_merge($_POST, $data));
            }

            $_SESSION['status'] = '34';
        }
        $opts = array();
        $opts['calendar_id'] = $this->tpl['default_calendar']['id'];
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }
    }
    
     function index() {

        GzObject::loadFiles('Model', array('Calendar', 'TimePrice', 'CustomDate'));
        $CalendarModel = new CalendarModel();
        $TimePriceModel = new TimePriceModel();
        $CustomDateModel = new CustomDateModel();

        if ($this->isAdmin()) {
            $this->tpl['arr'] = $CustomDateModel->getAll();
        }
        if ($this->isEditor()) {
            $this->tpl['arr'] = $CustomDateModel->getpriestdata();
        }

        foreach (($this->tpl['arr'] ?? []) as $k => $v) {
            $this->tpl['arr'][$k]['calendar'] = $CalendarModel->getI18n($v['calendar_id']);
        }
        
        $opts = array();

        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }

        if ($this->isRental()) {
            $opts['user_id'] = $this->getUserId();
        }
        
        $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);

        if (!empty($_GET['id'] ?? '')) {
            $this->tpl['default_calendar'] = $CalendarModel->getI18n($_GET['id'] ?? '');
        } elseif (!empty($this->tpl['calendars'][0])) {

            $this->tpl['default_calendar'] = $this->tpl['calendars'][0];
        }
        if (!empty($_POST['workin_time_send'])) {

            $data = array();
            $data['monday_is_day_off'] = (!empty($_POST['monday_is_day_off'])) ? 1 : 0;
            $data['tuesday_is_day_off'] = (!empty($_POST['tuesday_is_day_off'])) ? 1 : 0;
            $data['wednesday_is_day_off'] = (!empty($_POST['wednesday_is_day_off'])) ? 1 : 0;
            $data['thursday_is_day_off'] = (!empty($_POST['thursday_is_day_off'])) ? 1 : 0;
            $data['friday_is_day_off'] = (!empty($_POST['friday_is_day_off'])) ? 1 : 0;
            $data['saturday_is_day_off'] = (!empty($_POST['saturday_is_day_off'])) ? 1 : 0;
            $data['sunday_is_day_off'] = (!empty($_POST['sunday_is_day_off'])) ? 1 : 0;
            
            $data['monday_price'] = (!empty($_POST['monday_price'])) ? $_POST['monday_price'] : 0;
            $data['tuesday_price'] = (!empty($_POST['tuesday_price'])) ? $_POST['tuesday_price'] : 0;
            $data['wednesday_price'] = (!empty($_POST['wednesday_price'])) ? $_POST['wednesday_price'] : 0;
            $data['thursday_price'] = (!empty($_POST['thursday_price'])) ? $_POST['thursday_price'] : 0;
            $data['friday_price'] = (!empty($_POST['friday_price'])) ? $_POST['friday_price'] : 0;
            $data['saturday_price'] = (!empty($_POST['saturday_price'])) ? $_POST['saturday_price'] : 0;
            $data['sunday_price'] = (!empty($_POST['sunday_price'])) ? $_POST['sunday_price'] : 0;
            
            $data['monday_slot_lenght'] = (!empty($_POST['monday_slot_lenght'])) ? $_POST['monday_slot_lenght'] : 0;
            $data['tuesday_slot_lenght'] = (!empty($_POST['tuesday_slot_lenght'])) ? $_POST['tuesday_slot_lenght'] : 0;
            $data['wednesday_slot_lenght'] = (!empty($_POST['wednesday_slot_lenght'])) ? $_POST['wednesday_slot_lenght'] : 0;
            $data['thursday_slot_lenght'] = (!empty($_POST['thursday_slot_lenght'])) ? $_POST['thursday_slot_lenght'] : 0;
            $data['friday_slot_lenght'] = (!empty($_POST['friday_slot_lenght'])) ? $_POST['friday_slot_lenght'] : 0;
            $data['saturday_slot_lenght'] = (!empty($_POST['saturday_slot_lenght'])) ? $_POST['saturday_slot_lenght'] : 0;
            $data['sunday_slot_lenght'] = (!empty($_POST['sunday_slot_lenght'])) ? $_POST['sunday_slot_lenght'] : 0;
            
            $data['monday_count'] = (!empty($_POST['monday_count'])) ? $_POST['monday_count'] : 0;
            $data['tuesday_count'] = (!empty($_POST['tuesday_count'])) ? $_POST['tuesday_count'] : 0;
            $data['wednesday_count'] = (!empty($_POST['wednesday_count'])) ? $_POST['wednesday_count'] : 0;
            $data['thursday_count'] = (!empty($_POST['thursday_count'])) ? $_POST['thursday_count'] : 0;
            $data['friday_count'] = (!empty($_POST['friday_count'])) ? $_POST['friday_count'] : 0;
            $data['saturday_count'] = (!empty($_POST['saturday_count'])) ? $_POST['saturday_count'] : 0;
            $data['sunday_count'] = (!empty($_POST['sunday_count'])) ? $_POST['sunday_count'] : 0;
            
            if (!empty($_POST['id'])) {
                $TimePriceModel->update(array_merge($_POST, $data));
            } else {
                unset($_POST['id']);
                $TimePriceModel->save(array_merge($_POST, $data));
            }

            $_SESSION['status'] = '34';
        }
        $opts = array();
        $opts['calendar_id'] = $this->tpl['default_calendar']['id'];



        $location_id = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['puja_location'])) {
               
                $location_id = $_POST['puja_location'] ?? '';
                
            } 
        }
        


        $opts['location_id'] =  $location_id;
        // $opts['location_id'] =  "3";

        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }
    }

function rentalindex() {

        GzObject::loadFiles('Model', array('Calendar', 'TimePrice', 'CustomDate'));
        $CalendarModel = new CalendarModel();
        $TimePriceModel = new TimePriceModel();
        $CustomDateModel = new CustomDateModel();
        
        //$this->tpl['arr'] = $CustomDateModel->getAll();
        $this->tpl['arr'] = $CustomDateModel->getdata();

        foreach (($this->tpl['arr'] ?? []) as $k => $v) {
            $this->tpl['arr'][$k]['calendar'] = $CalendarModel->getI18n($v['calendar_id']);
            //$this->tpl['arr'][$k]['calendar'] = $CalendarModel->getI18n(2);
        }
        
        $opts = array();

        if ($this->isRental()) {
            $opts['user_id'] = $this->getUserId();
        }

        $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);

        if (!empty($_GET['id'] ?? '')) {
            $this->tpl['default_calendar'] = $CalendarModel->getI18n($_GET['id'] ?? '');
        } elseif (!empty($this->tpl['calendars'][0])) {

            $this->tpl['default_calendar'] = $this->tpl['calendars'][0];
        }
        if (!empty($_POST['workin_time_send'])) {

            $data = array();
            $data['monday_is_day_off'] = (!empty($_POST['monday_is_day_off'])) ? 1 : 0;
            $data['tuesday_is_day_off'] = (!empty($_POST['tuesday_is_day_off'])) ? 1 : 0;
            $data['wednesday_is_day_off'] = (!empty($_POST['wednesday_is_day_off'])) ? 1 : 0;
            $data['thursday_is_day_off'] = (!empty($_POST['thursday_is_day_off'])) ? 1 : 0;
            $data['friday_is_day_off'] = (!empty($_POST['friday_is_day_off'])) ? 1 : 0;
            $data['saturday_is_day_off'] = (!empty($_POST['saturday_is_day_off'])) ? 1 : 0;
            $data['sunday_is_day_off'] = (!empty($_POST['sunday_is_day_off'])) ? 1 : 0;
            
            $data['monday_price'] = (!empty($_POST['monday_price'])) ? $_POST['monday_price'] : 0;
            $data['tuesday_price'] = (!empty($_POST['tuesday_price'])) ? $_POST['tuesday_price'] : 0;
            $data['wednesday_price'] = (!empty($_POST['wednesday_price'])) ? $_POST['wednesday_price'] : 0;
            $data['thursday_price'] = (!empty($_POST['thursday_price'])) ? $_POST['thursday_price'] : 0;
            $data['friday_price'] = (!empty($_POST['friday_price'])) ? $_POST['friday_price'] : 0;
            $data['saturday_price'] = (!empty($_POST['saturday_price'])) ? $_POST['saturday_price'] : 0;
            $data['sunday_price'] = (!empty($_POST['sunday_price'])) ? $_POST['sunday_price'] : 0;
            
            $data['monday_slot_lenght'] = (!empty($_POST['monday_slot_lenght'])) ? $_POST['monday_slot_lenght'] : 0;
            $data['tuesday_slot_lenght'] = (!empty($_POST['tuesday_slot_lenght'])) ? $_POST['tuesday_slot_lenght'] : 0;
            $data['wednesday_slot_lenght'] = (!empty($_POST['wednesday_slot_lenght'])) ? $_POST['wednesday_slot_lenght'] : 0;
            $data['thursday_slot_lenght'] = (!empty($_POST['thursday_slot_lenght'])) ? $_POST['thursday_slot_lenght'] : 0;
            $data['friday_slot_lenght'] = (!empty($_POST['friday_slot_lenght'])) ? $_POST['friday_slot_lenght'] : 0;
            $data['saturday_slot_lenght'] = (!empty($_POST['saturday_slot_lenght'])) ? $_POST['saturday_slot_lenght'] : 0;
            $data['sunday_slot_lenght'] = (!empty($_POST['sunday_slot_lenght'])) ? $_POST['sunday_slot_lenght'] : 0;
            
            $data['monday_count'] = (!empty($_POST['monday_count'])) ? $_POST['monday_count'] : 0;
            $data['tuesday_count'] = (!empty($_POST['tuesday_count'])) ? $_POST['tuesday_count'] : 0;
            $data['wednesday_count'] = (!empty($_POST['wednesday_count'])) ? $_POST['wednesday_count'] : 0;
            $data['thursday_count'] = (!empty($_POST['thursday_count'])) ? $_POST['thursday_count'] : 0;
            $data['friday_count'] = (!empty($_POST['friday_count'])) ? $_POST['friday_count'] : 0;
            $data['saturday_count'] = (!empty($_POST['saturday_count'])) ? $_POST['saturday_count'] : 0;
            $data['sunday_count'] = (!empty($_POST['sunday_count'])) ? $_POST['sunday_count'] : 0;
            
            if (!empty($_POST['id'])) {
                $TimePriceModel->update(array_merge($_POST, $data));
            } else {
                unset($_POST['id']);
                $TimePriceModel->save(array_merge($_POST, $data));
            }

            $_SESSION['status'] = '34';
        }
        $opts = array();
        $opts['calendar_id'] = $this->tpl['default_calendar']['id'];
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }
    }


    function saveCustomPrice() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('CustomPrice'));
        $CustomPriceModel = new CustomPriceModel();

        if (!empty($_POST['price'])) {
            $opts = array();
            $opts['calendar_id'] = $_POST['calendar_id'] ?? '';
            $opts['day'] = $_POST['day'] ?? '';

            $CustomPriceModel->deleteFrom($CustomPriceModel->getTable())
                    ->where($opts)
                    ->execute();

            foreach (($_POST['price'] ?? []) as $i => $price) {
                $data = array();
                $data['day'] = $_POST['day'] ?? '';
                $data['calendar_id'] = $_POST['calendar_id'] ?? '';
                $data['start_timestamp'] = $i;
                $data['price'] = $price;

                $CustomPriceModel->save($data);
            }
        }
    }

    function getCustomPriceFrm() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('TimePrice', 'CustomPrice'));
        $TimePriceModel = new TimePriceModel();
        $CustomPriceModel = new CustomPriceModel();

        $opts['calendar_id'] = $_POST['calendar_id'] ?? '';
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }

        $opts = array();

        $opts['calendar_id'] = $_POST['calendar_id'] ?? '';
        $opts['day'] = $_POST['day'] ?? '';
        $custom_prices = $CustomPriceModel->getAll($opts);
        $this->tpl['custom_prices'] = array();

        foreach ($custom_prices as $key => $value) {
            $this->tpl['custom_prices'][date('h:i', $value['start_timestamp'])] = $value['price'];
        }
    }
    
    function addCustomTimePrices() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('CustomDate', 'Calendar'));
        $CustomDateModel = new CustomDateModel();
        $CalendarModel = new CalendarModel();

        if (!empty($_POST['timestamp'])) {
            $data = array();
            $data['timestamp'] = Util::dateToTimestamp('m/d/Y', $_POST['timestamp'] ?? '');
            $data['timestamp_end'] = Util::dateToTimestamp('m/d/Y', $_POST['timestamp_end'] ?? '');
            $custom_timestamp = $data['timestamp'];

            unset($_POST['timestamp']);
            unset($_POST['timestamp_end']);

            $data['is_day_off'] = (!empty($_POST['is_day_off'])) ? 1 : 0;

            // Convert empty strings to 0 for float columns (MySQL strict mode rejects '' in float)
            $_POST['price']       = (isset($_POST['price'])       && $_POST['price']       !== '') ? (float)$_POST['price']       : 0;
            $_POST['count']       = (isset($_POST['count'])       && $_POST['count']       !== '') ? (float)$_POST['count']       : 0;
            $_POST['slot_lenght'] = (isset($_POST['slot_lenght']) && $_POST['slot_lenght'] !== '') ? (float)$_POST['slot_lenght'] : 0;

            $CustomDateModel->save(array_merge($_POST, $data));
        }

         if ($this->isAdmin()) {
            $this->tpl['arr'] = $CustomDateModel->getAll();
            }
            if ($this->isRental()) {
              $this->tpl['arr'] = $CustomDateModel->getdata();
            }
            if ($this->isEditor()) {
                $this->tpl['arr'] = $CustomDateModel->getpriestdata();
            }

        foreach (($this->tpl['arr'] ?? []) as $k => $v) {
            $this->tpl['arr'][$k]['calendar'] = $CalendarModel->getI18n($v['calendar_id']);
        }
    }
    
    function getEditCustomTime(){
        $this->isAjax = true;
         
        GzObject::loadFiles('Model', array('CustomDate', 'Calendar'));
        $CustomDateModel = new CustomDateModel();
        $CalendarModel = new CalendarModel();
        
        $this->tpl['arr'] = $CustomDateModel->get($_POST['id'] ?? '');
        $this->tpl['calendars'] = $CalendarModel->getI18nAll();
    }
    
    function edit(){
        $this->isAjax = true;
        
        GzObject::loadFiles('Model', array('CustomDate', 'Calendar'));
        $CustomDateModel = new CustomDateModel();
        $CalendarModel = new CalendarModel();
        
        if(!empty($_POST['id'])){

            $_POST['is_day_off'] = (!empty($_POST['is_day_off'])) ? 1 : 0;
            $_POST['timestamp'] = Util::dateToTimestamp('m/d/Y', $_POST['timestamp'] ?? '');
            $_POST['timestamp_end'] = Util::dateToTimestamp('m/d/Y', $_POST['timestamp_end'] ?? '');

            // Convert empty strings to 0 for float columns (MySQL strict mode rejects '' in float)
            $_POST['price']       = (isset($_POST['price'])       && $_POST['price']       !== '') ? (float)$_POST['price']       : 0;
            $_POST['count']       = (isset($_POST['count'])       && $_POST['count']       !== '') ? (float)$_POST['count']       : 0;
            $_POST['slot_lenght'] = (isset($_POST['slot_lenght']) && $_POST['slot_lenght'] !== '') ? (float)$_POST['slot_lenght'] : 0;

            $CustomDateModel->update($_POST);
        }
        
        if ($this->isAdmin()) {
        $this->tpl['arr'] = $CustomDateModel->getAll();
        }
        if ($this->isRental()) {
          $this->tpl['arr'] = $CustomDateModel->getdata();
        }
        if ($this->isEditor()) {
            $this->tpl['arr'] = $CustomDateModel->getpriestdata();
        }

        foreach (($this->tpl['arr'] ?? []) as $k => $v) {
            $this->tpl['arr'][$k]['calendar'] = $CalendarModel->getI18n($v['calendar_id']);
        }
    }
    
    function delete() {
        $this->isAjax = true;
        $id = $_REQUEST['id'];

        GzObject::loadFiles('Model', array('CustomDate', 'Calendar', 'CustomPrice'));
        $CustomDateModel = new CustomDateModel();
        $CustomPriceModel = new CustomPriceModel();
        $CalendarModel = new CalendarModel();

        $CustomDateModel->deleteFrom($CustomDateModel->getTable())
                ->where('id', $id)->execute();

        if ($this->isAdmin()) {
        $this->tpl['arr'] = $CustomDateModel->getAll();
        }
        if ($this->isRental()) {
          $this->tpl['arr'] = $CustomDateModel->getdata();
        }
        if ($this->isEditor()) {
            $this->tpl['arr'] = $CustomDateModel->getpriestdata();
        }

        foreach (($this->tpl['arr'] ?? []) as $k => $v) {
            $this->tpl['arr'][$k]['calendar'] = $CalendarModel->getI18n($v['calendar_id']);
        }
    }

}


