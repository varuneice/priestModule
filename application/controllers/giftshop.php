<?php

require_once CONTROLLERS_PATH . 'App.php';

class giftshop extends App {

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

        if (!$this->isLoged() && ($_REQUEST['action'] ?? '') != 'login') {

            if (($_REQUEST['action'] ?? '') != 'edit') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
        }
        $this->css[] = array('file' => 'front/style.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.min.js', 'path' => LIBS_PATH . 'jquery/ui/');
        $this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);

        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
    }
    
    
    

    function index() {
        GzObject::loadFiles('Model', array('Donationnewview'));
        $DonationnewviewModel = new DonationnewviewModel();
      
         $opts = array();
         //$Donationarr = $DonationModel->getAll($opts);
         $giftmiscarr = $DonationnewviewModel->donationgiftmisc($opts);
         $this->tpl['giftmiscarr'] = $giftmiscarr;
        
    }

   
    function export() {

        $this->isAjax = true;
        $type= $_GET['ID'] ?? '';

        GzObject::loadFiles('Model', array('Donation'));
        $DonationModel = new DonationModel();
        $opts = array();
        $header_args = array( 'id', 'type', 'bank', 'chkno', 'chkdate', 'MemberName', 'Amount', 'PaymentOption', 'payment_status', 'payment_timestamp', 'stripe_return', 'transaction_id', 'paid_amount', 'stripe_product', 'update_on', 'Member_id', 'pay_date', 'cc_name', 'remarks', 'oid', 'pay_type', 'pay_for', 'Address', 'Street', 'State', 'Zip_Code', 'Tele1', 'email', 'City', 'eventid', 'spousename', 'purpose', 'ReceiveBy' );
     
        
               header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Giftshop&other_export.csv');
        $output = fopen( 'php://output', 'w' );
        if (ob_get_level()) ob_end_clean();
        fputcsv($output, $header_args, ',', '"', '\\');
          if($type=="Gift"){
            $query = $DonationModel->donationgiftmisc($type);
        }
         $members = $query;

        foreach ($members as $data_item) {
            fputcsv($output, $data_item, ',', '"', '\\');
        }
        exit;
    }
    

}

?>

