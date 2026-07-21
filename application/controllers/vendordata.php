<?php

require_once CONTROLLERS_PATH . 'App.php';

class vendordata extends App
{

    var $layout = 'admin';
    var $option_arr = null;

    function beforeFilter()
    {

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

            // if (($_REQUEST['action'] ?? '') != 'edit') {
            //     $_SESSION['err'] = 2;
            //     Util::redirect(INSTALL_URL . "Admin/login");
            // }

            if (($_REQUEST['action'] ?? '') != 'useredit') {
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

        //for stripe payment
        if (($_REQUEST['action'] ?? '') == 'useredit') {
            $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        }
        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);
        // $this->js[] = array('file' => 'GzVendorPayment.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzVendorPayment.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
    }

    function edit()
    {
        GzObject::loadFiles('Model', array('Vendor', 'vendorinvoice'));
        $VendorModel = new VendorModel();
        $vendorinvoiceModel = new vendorinvoiceModel();

        if (!empty($_POST['edit_vendordata'])) {

            $data = array();

            $vendorid = $_POST['vendorid'] ?? '';
            $vendorinvoiceid = $_POST['vendorinvoiceid'] ?? '';
            $status = $_POST['status'] ?? '';
            if ($status == 'Active') {
                $url = INSTALL_URL . "vendordata/useredit/$vendorinvoiceid";
                $this->sendEmailvendor($_POST, $url);
                $paymentfor = $_POST['paytype'] ?? '';
                    if ($paymentfor == 'BOOTH') {
                        $payforui = 'Booth Rentals';
                    } else if ($paymentfor == 'MAGADV') {
                        $payforui = 'Magazine Advertisements';
                    } else if ($paymentfor == 'OTHADV') {
                        $payforui = 'Other Advertisements';
                    }
                    else{
                        $payforui = $_POST['paytype'] ?? '';
                    }
                    $type = $_POST['item_desc'] ?? '';
                $mobileno = $_POST['phone'] ?? '';
                if ($mobileno  != null) {
                   $msg = 'Houston Durga Bari: ' . ($_POST['ownername'] ?? '') . ', Payment For: ' . $payforui .  ', Type: ' . $type. '. Durga Bari has been Approved the request please check your email and complete final payment.' ;
                   $this->SendSMS($mobileno, $msg);
                 }
            }
            
            $afterpaystatus = $_POST['finalpaystatus'] ?? '';
            if($afterpaystatus == "Paid" && $status == "confirmed"){
                $_POST['status'] = "confirmed";
                $paymentmode = $_POST['pay_mode'] ?? '';
                if($paymentmode == "Credit Card"){ $_POST['pay_mode'] = "stripe";}
                elseif($paymentmode == "Zelle"){$_POST['pay_mode'] = "others";}
                elseif($paymentmode == "Cash"){$_POST['pay_mode'] = "cash";}
                elseif($paymentmode == "Check"){$_POST['pay_mode'] = "check";}
                elseif($paymentmode == "Direct Deposit"){$_POST['pay_mode'] = "directdeposit";}
            }
            
            //$arr1 = $vendorinvoiceModel->getAllvendorinvoiceData($id);
             $opts = array();
            $opts['id'] = $vendorinvoiceid;
            $vendorinvoiceModel->update(array_merge($opts,$_POST));
            $data['id'] = $vendorid;
            $id = $VendorModel->update(array_merge($data, $_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin() && !$this->isVendor()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "vendordata/index");
            }
        }
        $id = $_GET['id'] ?? '';
        // $arr = $VendorModel->get($id);
        // $this->tpl['arr'] = $arr;

        $arr1 = $vendorinvoiceModel->getAllvendorinvoiceData($id);
        $this->tpl['vendorinvoicedata'] = $arr1;

        $arr = $VendorModel->get($arr1['custid']);
        $this->tpl['arr'] = $arr;
    }


    function useredit()
    {
        GzObject::loadFiles('Model', array('Vendor', 'vendorinvoice', 'ConfirmCode', 'idnumbers' , 'vendorpaymentaccount'));
        $VendorModel = new VendorModel();
        $vendorinvoiceModel = new vendorinvoiceModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $idnumbersModel = new idnumbersModel();
          $vendorpaymentaccountModel = new vendorpaymentaccountModel();
          
          
           $xmlPath = __DIR__ . '/../../web.config';
        $xml = simplexml_load_file($xmlPath);
        $stripePublishedKey = (defined('STRIPE_PUBLISHABLE_KEY') && STRIPE_PUBLISHABLE_KEY !== '') ? STRIPE_PUBLISHABLE_KEY : (string) $xml->appSettings->add[0]->attributes()->value;
        $this->tpl['StripePublishedApiKey'] = $stripePublishedKey;

        $vendorpayAccountarr = $vendorpaymentaccountModel->getAll();

        $result = $vendorpaymentaccountModel->getVendorPaymentAccountName("vendor");
        $accountType = $result[0]['paymentaccount'] ?? null;
        $this->tpl['account_type'] =  $accountType;

        if ($accountType == "Regularaccount") {
            $this->tpl['hbds_email'] = "treasurer@durgabari.org";
           
        } else {
            $this->tpl['hbds_email'] = "treasurerpuja@durgabari.org";
           
        }
        
        
        
        if (!empty($_POST['edit_vendoruserdata'])) {

            $data = array();
            $id = $_POST['vendorid'] ?? '';
            $custid = $_POST['custid'] ?? '';
            // for generate oid 
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for

            if (!empty($custid)) {

                $invoiceid = $VendorModel->savevendorInvoice($id);
// create payment confirmation msg
$OwnerName = $_POST['ownername'] ?? '';
$paymentfor = $_POST['paytype'] ?? '';
if ($paymentfor == 'BOOTH') {
    $payforui = 'Booth Rentals';
} else if ($paymentfor == 'MAGADV') {
    $payforui = 'Magazine Advertisements';
} else if ($paymentfor == 'OTHADV') {
    $payforui = 'Other Advertisements';
}
else{
    $payforui = $_POST['paymentfor'] ?? '';
}
$type = $_POST['item_desc'] ?? '';
$BusinessName = $_POST['businessname'] ?? '';
$taxid = $_POST['taxid'] ?? '';
$Quantity = $_POST['item_number'] ?? '';
$Amount = $_POST['item_cost'] ?? '';
$totalamount = $_POST['amount'] ?? '';
$oid = $_POST['oid'] ?? '';
$paytype = $_POST['pay_mode'] ?? '';
if($paytype == 'others'){
    $paymentmethod = 'Zelle';
} elseif($paytype == 'stripe'){
    $paymentmethod = 'Credit Card';
} elseif($paytype == 'cash'){
    $paymentmethod = 'Cash';
} elseif($paytype == 'check'){
    $paymentmethod = 'Check';
} elseif($paytype == 'directdeposit'){
    $paymentmethod = 'Direct Deposit';
} else {
    $paymentmethod = '';
}

$msg = 'Houston Durga Bari: Payment confirmation are Owner Name is ' . $OwnerName . ', Payment For: ' . $payforui .  ', Type: ' . $type . ', Business Name: ' . $BusinessName . ', Tax Id: '. $taxid. ', Order Id: ' . $oid .', Quantity: ' . $Quantity .', Amount : $' . $Amount . ', Total Amount: $'. $totalamount. ',  Payment Method:'. $paymentmethod;
                      
                if (($_POST['pay_mode'] ?? '') == 'others') {
                    $opts = array();
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                    $arr = $ConfirmCodeModel->getAll($opts);
                    $oid = $_POST['oid'] ?? '';
                    $cmCode = $_POST['zellecode'] ?? '';
                    $ConfirmCodeModel->UpdateCode($cmCode);
                    if ($oid != null) {
                        $opts = array();
                        //$opts['id'] = $custid;
                         $opts['id'] = $_POST['vendorinvoiceid'] ?? '';
                        $opts['transaction_id'] = $cmCode;
                        $_POST['status'] = 'confirmed';
                        $_POST['invoice_id'] = $invoiceid;
                        date_default_timezone_set("America/Chicago");
                        $today = date("Y/m/d"); 
                        $_POST['pay_date']= $today;
                        $vendorinvoiceModel->update(array_merge($opts, $_POST));
                        $opts['id'] = $id;
                        $VendorModel->update(array_merge($opts, $_POST));
                       
                        $this->userpaymentemail($_POST);
                        $mobileno = $_POST['phone'] ?? '';
                        if ($mobileno  != null) {
                          $this->SendSMS($mobileno, $msg);
                         }
                    }
                   

                } elseif (($_POST['pay_mode'] ?? '') == 'stripe') {
                    require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                    $error = '';
                    $success = '';

                    // Stripe::setApiKey($this->tpl["option_arr_values"]["stripe_api_key"]);
                    
                     $xmlPath = __DIR__ . '/../../web.config';
                    $xml = simplexml_load_file($xmlPath);
                    $stripeApiKey = (defined('STRIPE_PUJA_SECRET_KEY') && STRIPE_PUJA_SECRET_KEY !== '') ? STRIPE_PUJA_SECRET_KEY : (string) $xml->appSettings->add[1]->attributes()->value;
                    Stripe::setApiKey2($this->tpl["option_arr_values"]["stripe_api_key"], $accountType, $stripeApiKey);

                    try {
                        if (!isset($_POST['stripeToken'])) {
                            throw new Exception("The Stripe Token was not generated correctly");
                        }
                        
                        $paytypeuser = $_POST['paytype'] ?? '';
                        if ($paytypeuser == 'BOOTH') {
                            $paytypestripe = 'Booth Rentals';
                        } else if ($paytypeuser == 'MAGADV') {
                            $paytypestripe = 'Magazine Advertisements';
                        } else if ($paytypeuser == 'OTHADV') {
                            $paytypestripe = 'Other Advertisements';
                        }
                        else{
                            $paytypestripe  = $tpl['vendorpricearr'][$i]['paymentfor'];
                        }

                        $oid = $_POST['oid'] ?? '';
                        $oldamount = $_POST['amount'] ?? '';
                        $amount = round($oldamount * 100);
                        $payment = Stripe_Charge::create(
                             array(
                              
                                "amount" => $amount,
                                "currency" => $this->tpl["option_arr_values"]["currency"],
                                "card" => $_POST['stripeToken'],
                                "description" => "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['ownername'] ?? '') .', '. "paytype:" . $paytypestripe,
                                "metadata" => ["orderid" => $oid]
                            )
                        );

                        $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                        $this->tpl['payment']['amount'] = $payment->amount;
                        $this->tpl['payment']['status'] = $payment->status;
                        $this->tpl['payment']['currency'] = $payment->currency;

                        if ($payment->status == 'succeeded') {

                            $vendordata = $VendorModel->get($id);

                            $opts = array();
                            // $opts['id'] = $id;
                            $opts['id'] = $_POST['vendorinvoiceid'] ?? '';
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            $opts['payment_status'] = 'succeeded';
                            $opts['payment_timestamp'] = time();
                            $_POST['status'] = 'confirmed';
                            $_POST['invoice_id'] = $invoiceid;
                             date_default_timezone_set("America/Chicago");
                            $today = date("Y/m/d"); 
                            $_POST['pay_date']= $today;

                            $vendorinvoiceModel->update(array_merge($opts, $_POST));
                            $opts['id'] = $id;
                            $VendorModel->update(array_merge($opts, $_POST));
                            $this->userpaymentemail($_POST);
                            $mobileno = $_POST['phone'] ?? '';
                            if ($mobileno  != null) {
                            $this->SendSMS($mobileno, $msg);
                         }

                        } else {
                            $vendordata = $VendorModel->get($id);

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            $VendorModel->update($opts);

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';

                        }
                    } catch (Exception $e) {

                        $_SESSION['status'] = '<strong>Error!</strong> ' . $e->getMessage();
                    }
                } elseif (($_POST['payment_method'] ?? '') == 'authorize') {
                    require_once APP_PATH . 'helpers/sdk-php-master/autoload.php';
                }
                $this->tpl['vendordetails'] = $VendorModel->get($id);
                $status = 10;
            } else {
                $status = 11;
            }
        }

        $id = $_GET['id'] ?? '';
        if ($id != null || $id = "") {
            // $arr = $VendorModel->get($id);
            // $this->tpl['arr'] = $arr;
            $arr1 = $vendorinvoiceModel->getAllvendorinvoiceData($id);
            $this->tpl['vendorinvoicedata'] = $arr1;

            $arr = $VendorModel->get($arr1['custid']);
            $this->tpl['arr'] = $arr;
        }
    }


    function index()
    {
        GzObject::loadFiles('Model', array('Vendor','vendorprice','vendorheading','vendorpaymentfor' , 'vendorpaymentaccount'));
        $VendorModel = new VendorModel();
        $vendorpriceModel = new vendorpriceModel();
        $vendorheadingModel = new vendorheadingModel();
        $vendorpaymentforModel = new vendorpaymentforModel(); 
        
        $vendorpaymentaccountModel = new vendorpaymentaccountModel();

        $opts = array();
        $arr = $VendorModel->getallvendordatawithinvoice($opts);
        $this->tpl['arr'] = $arr;


        $opts = array();
        $vendorpricearr = $vendorpriceModel->getAll($opts);
        $this->tpl['vendorpricearr'] = $vendorpricearr;
        
        $headingvendorarr = $vendorheadingModel->getAll($opts);
        $this->tpl['headingvendor'] = $headingvendorarr;
        
        
        $vendorpayarr = $vendorpaymentforModel->getAll($opts);
        $this->tpl['vendorpayarr'] = $vendorpayarr;
        
        
        
        $modulename="vendor";
        $vendorpayAccountarr = $vendorpaymentaccountModel->getEventPaymentAccountName($modulename);
        $this->tpl['vendorpayAccountarr'] = $vendorpayAccountarr;

    }

  function vendorpaymentfor()
    {
        GzObject::loadFiles('Model', array('vendorpaymentfor'));
        $vendorpaymentforModel = new vendorpaymentforModel(); 
        if (!empty($_POST['createvendorpaymentfor'])) {
            
            $id =  $vendorpaymentforModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "vendordata/index");
        }   
    }


    function vendorpaymentforedit()
    {
        GzObject::loadFiles('Model', array('vendorpaymentfor'));
        $vendorpaymentforModel = new vendorpaymentforModel(); 
        if (!empty($_POST['vendorpaymentforedit'])) {

            $data = array();
            $id = $vendorpaymentforModel->update(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "vendordata/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $vendorpaymentdata = $vendorpaymentforModel->get($id);
        $this->tpl['vendorpaymentdata'] = $vendorpaymentdata;

    }


    function vendorheading()
    {
        GzObject::loadFiles('Model', array('vendorheading'));
        $vendorheadingModel = new vendorheadingModel(); 
        if (!empty($_POST['createvendorheading'])) {

            $id =  $vendorheadingModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "vendordata/index");
        }   
    }


    function vendorheadingedit()
    {
        GzObject::loadFiles('Model', array('vendorheading'));
        $vendorheadingModel = new vendorheadingModel();
        if (!empty($_POST['headingedit'])) {

            $data = array();
            $id = $vendorheadingModel->update(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "vendordata/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $vendorheading = $vendorheadingModel->get($id);
        $this->tpl['vendorheadingarr'] = $vendorheading;

    }

    function vendorpricecreate()
    {
         GzObject::loadFiles('Model', array('vendorprice','vendorpaymentfor'));
        $vendorpriceModel = new vendorpriceModel();
        $vendorpaymentforModel = new vendorpaymentforModel();

        $dataarr = $vendorpaymentforModel->vendorpayment();
        $this->tpl['dataarr'] = $dataarr;
        if (!empty($_POST['vendorpricecreate'])) {

            // $data = array();

            $id = $vendorpriceModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "vendordata/index");
        }
    }



    function vendorpriceedit()
    {
         GzObject::loadFiles('Model', array('vendorprice','vendorpaymentfor'));
        $vendorpriceModel = new vendorpriceModel();
        $vendorpaymentforModel = new vendorpaymentforModel();

        $dataarr = $vendorpaymentforModel->vendorpayment();
        $this->tpl['dataarr'] = $dataarr;
        if (!empty($_POST['priceedit'])) {

            $data = array();
            $id = $vendorpriceModel->update(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "vendordata/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $vendorpicearr = $vendorpriceModel->get($id);
        $this->tpl['vendorpicearr'] = $vendorpicearr;

    }


    function export()
    {
        $this->isAjax = true;
        GzObject::loadFiles('Model', array('Vendor', 'vendorinvoice'));
        $VendorModel = new VendorModel();
        $vendorinvoiceModel = new vendorinvoiceModel(); 
        $opts = array();
         $header_args = array( 'id', 'businessname', 'ownername', 'email', 'phone', 'address', 'city', 'state', 'zip', 'country', 'taxid', 'custid', 'vax', 'Created_On', 'Update_On', 'UpdateBy', 'oid',  'paytype', 'invoice_id', 'invoice_num', 'item_desc', 'item_number', 'item_cost', 'amount', 'status', 'pay_mode', 'pay_date', 'payment_status', 'payment_timestamp', 'stripe_return', 'transaction_id', 'paid_amount', 'stripe_product', 'chkno', 'bank', 'chkdate', 'receiveby', 'remarks');
     
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Vendordata_export.csv');
        $output = fopen( 'php://output', 'w' );
        if (ob_get_level()) ob_end_clean();
        fputcsv($output, $header_args, ',', '"', '\\');
        $reportarr = $VendorModel->getallvendordataexport($opts);
            foreach ($reportarr as $data_item) {
                fputcsv($output, $data_item, ',', '"', '\\');
            }
        
        exit;
    }
    
    function delete()
    {
        $this->isAjax = true;
        $id = $_REQUEST['id'];
        $cat = $_REQUEST['cat'];
        GzObject::loadFiles('Model', array('Vendor','vendorprice', 'vendorinvoice','vendorheading','vendorpaymentfor'));
        $VendorModel = new VendorModel();
        $vendorpriceModel = new vendorpriceModel();
        $vendorinvoiceModel = new vendorinvoiceModel();
        $vendorheadingModel = new vendorheadingModel();
        $vendorpaymentforModel = new vendorpaymentforModel();

        if($cat == 1){
        // $VendorModel->deleteFrom($VendorModel->getTable())
        //     ->where('id', $id)->execute();
        //     $vendorinvoiceModel->deleteFrom($vendorinvoiceModel->getTable())
        //     ->where('custid', $id)->execute();
         $vendorinvoiceModel->deleteFrom($vendorinvoiceModel->getTable())
                        ->where('id', $id)->execute();
        }
        elseif($cat == 2){
                $vendorpriceModel->deleteFrom($vendorpriceModel->getTable())
            ->where('id', $id)->execute();
        } 
         elseif($cat == 3){
            $vendorheadingModel->deleteFrom($vendorheadingModel->getTable())
          ->where('id', $id)->execute();
        } 

        elseif($cat == 4){
         $vendorpaymentforModel->deleteFrom($vendorpaymentforModel->getTable())
         ->where('id', $id)->execute();
        } 

        Util::redirect(INSTALL_URL . "vendordata/index");
        $this->index();
    }
    
    
    // 28 july
      function updateVendorPayAccount(){
        GzObject::loadFiles('Model', array('vendorpaymentaccount','User'));
        $vendorpaymentaccountModel = new vendorpaymentaccountModel(); 
        $UserModel = new UserModel();
    
        if (!empty($_POST['paymentaccount'])) {
            
            if ($this->isAdmin() || $this->isEditor()) {
                $id = $this->getUserId();
                $admin = $UserModel->get($id);
                $rolename = $admin['first'] . ' ' . $admin['last'];
                $_POST['admin_id'] = $admin['id'];
                $_POST['admin_name'] = $rolename;   
            }
            
            $id = $vendorpaymentaccountModel->update($_POST);
    
            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }
    
            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "vendordata/index");
            }
        }
    }

}
