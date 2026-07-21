<?php

require_once CONTROLLERS_PATH . 'App.php';

class VendorPayment extends App
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
        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);
        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);

        // For search dropdown search box 
        $this->css[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/css/bootstrap-select.min.css', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/bootstrap-select/dist/js/bootstrap-select.min.js', 'path' => JS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);

        $this->js[] = array('file' => 'admin.js', 'path' => JS_PATH);

        // $this->js[] = array('file' => 'GzVendorPayment.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'GzVendorPayment.js?v=1', 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);

    }

    function paymentfor()
    {
        GzObject::loadFiles('Model', array('vendorprice'));
        $vendorpriceModel = new vendorpriceModel();
        // $location = $_POST['location'];
        $arr = $vendorpriceModel->paymentfor();
        $this->tpl['price'] = $arr;
        foreach ($arr as $key => $value) {
            echo '<option value="' . $value['price'] . '">' . $value['type'] . '</option>';

        }
    }


    function VendorPayment()
    {
        $this->layout = 'login';
        GzObject::loadFiles('Model', array('Vendor', 'vendorinvoice','vendorheading','vendorpaymentfor'));
        $VendorModel = new VendorModel();
        $vendorinvoiceModel = new vendorinvoiceModel();
        $vendorheadingModel = new vendorheadingModel(); 
        $vendorpaymentforModel = new vendorpaymentforModel();

        $dataarr = $vendorheadingModel->getall();
        $this->tpl['dataarr'] =  $dataarr;
        
        $vendorpayforarr = $vendorpaymentforModel->getall();
        $this->tpl['vendorpayforarr'] =  $vendorpayforarr;
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['vendor_payment_processed']);
        }

        if (!empty($_POST['create_vendorpayment'])) {

            $log = function($msg) {
                @file_put_contents(sys_get_temp_dir() . '/vendorpayment_debug.log',
                    date('Y-m-d H:i:s') . ' ' . $msg . PHP_EOL, FILE_APPEND);
            };
            $log('=== VendorPayment submit start ===');
            $log('POST keys: ' . implode(', ', array_keys($_POST)));

             if (isset($_SESSION['vendor_payment_processed']) && $_SESSION['vendor_payment_processed'] === true) {
                $log('Session already processed — redirecting');
                unset($_SESSION['vendor_payment_processed']);
                Util::redirect(INSTALL_URL . "VendorPayment/VendorPayment");
                exit();
            }



           $paymentfornew = $_POST['paymentfor'] ?? '';
           $paydescnew =  $_POST['paydesc'] ?? '';
           $quantitynew =  $_POST['Quantity'] ?? '';
           $amountnew =  $_POST['amount'] ?? '';
           $totalamountnew =  $_POST["TotalAmount"] ?? '';
            $datamember =  $VendorModel->checkduplicatemember();
            $log('checkduplicatemember result: ' . var_export($datamember, true));
            if($datamember == null){
                $_POST["CreatedOn"] = date("Y-m-d H:i:s");
                $_POST['custid'] = '';  // NOT NULL column — set placeholder before INSERT
                $_POST['vax'] = '';    // NOT NULL column — set placeholder before INSERT
                $id = $VendorModel->save(array_merge($_POST));
                $log('VendorModel->save() returned: ' . var_export($id, true));
                $_POST['name'] = $_POST['ownername'] ?? '';
                $_POST['custid'] = $id;
                $_POST['paytype'] = $_POST['paymentfor'] ?? '';
                $_POST['status'] = 'pending';
                $_POST["item_desc"] = $_POST['paydesc'] ?? '';
                $_POST["item_number"] = $_POST['Quantity'] ?? '';
                $_POST["item_cost"] = $_POST['amount'] ?? '';
                $_POST["amount"] = $_POST["TotalAmount"] ?? '';
                $_POST["created_on"] = date("Y-m-d H:i:s");
                // Pre-fill NOT NULL invoice columns (Azure strict mode requires values)
                $_POST['oid'] = abs((int)(microtime(true) * 100) % 999999) ?: 1;
                $_POST['invoice_id'] = '';
                $_POST['invoice_num'] = '';
                $_POST['pay_mode'] = '';
                $_POST['pay_date'] = date('Y-m-d');
                $_POST['transaction_id'] = '';
                $_POST['chkno'] = '';
                $_POST['bank'] = '';
                $_POST['chkdate'] = '';
                $log('Invoice POST before save — paytype:' . ($_POST['paytype'] ?? '') . ' custid:' . ($_POST['custid'] ?? '') . ' oid:' . ($_POST['oid'] ?? '') . ' item_cost:' . ($_POST['item_cost'] ?? '') . ' amount:' . ($_POST['amount'] ?? '') . ' status:' . ($_POST['status'] ?? '') . ' pay_date:' . ($_POST['pay_date'] ?? 'NOT_SET'));
                $invoiceSaveResult = $vendorinvoiceModel->save($_POST);
                $log('vendorinvoiceModel->save() returned: ' . var_export($invoiceSaveResult, true));
                $this->sendrecemail($_POST);
                if (!empty($id)) {

                    $Amount = $_POST['item_cost'] ?? '';
                    $totalamount = $_POST['amount'] ?? '';
                    $BusinessName = $_POST['businessname'] ?? '';
                    $OwnerName = $_POST['ownername'] ?? '';
                    $taxid = $_POST['taxid'] ?? '';
                    $paymentfor = $_POST['paymentfor'] ?? '';
                    if ($paymentfor == 'BOOTH') {
                        $payforui = 'Booth Rentals';
                    } else if ($paymentfor == 'MAGADV') {
                        $payforui = 'Magazine Advertisements';
                    } else if ($paymentfor == 'OTHADV') {
                        $payforui = 'Other Advertisements';
                    }else{
                        $payforui = $paymentfor;
                    }
                    $type = $_POST['item_desc'] ?? '';


                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                <table border='4' width='585px'>
                <tr>
                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                 </tr>
                 <tr><td style='width:50%;'>Owner Name</td> <td style='width:50%;'>" . $OwnerName . "</td> </tr>
                 <tr><td>Business Name</td> <td>" . $BusinessName . "</td> </tr>
                 <tr><td>Tax Id</td> <td>" . $taxid . "</td>  </tr>
                 <tr><td>Payment For</td> <td>" . $payforui . "</td> </tr>
                 <tr><td>Type</td> <td>" . $type . "</td> </tr>
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                 <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";
    
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "VendorPayment/VendorPayment'>Go to home</a>";
                    echo "</div>";
                   
                    $mobileno = $_POST['phone'] ?? '';
                    if ($mobileno  != null) {
                       $msg = 'Houston Durga Bari: Your Vendor request have been submitted. Owner Name is ' . $OwnerName . ', Payment For: ' . $payforui .  ', Type:  ' . $type . ', Business Name:  ' . $BusinessName . ', Tax Id: '. $taxid. ', Amount : $' . $Amount . ', Total Amount: $'. $totalamount;
                       $this->SendSMS($mobileno, $msg);
                     }
                      $_SESSION['vendor_payment_processed'] = true;
                    exit();
                }

            }
            if ($datamember != null) {
                $log('Duplicate vendor path — existing id: ' . $datamember);
                $data['id'] = $datamember;
                $id  = $datamember;
                $VendorModel->update(array_merge($_POST, $data));
                $_POST['name'] = $_POST['ownername'] ?? '';
                $_POST['custid'] = $id;
                $_POST['paytype'] = $_POST['paymentfor'] ?? '';
                $_POST['status'] = 'pending';
                $_POST["item_desc"] = $_POST['paydesc'] ?? '';
                $_POST["item_number"] = $_POST['Quantity'] ?? '';
                $_POST["item_cost"] = $_POST['amount'] ?? '';
                $_POST["amount"] = $_POST["TotalAmount"] ?? '';
                $_POST["created_on"] = date("Y-m-d H:i:s");
                // Pre-fill NOT NULL invoice columns (Azure strict mode requires values)
                $_POST['oid'] = abs((int)(microtime(true) * 100) % 999999) ?: 1;
                $_POST['invoice_id'] = '';
                $_POST['invoice_num'] = '';
                $_POST['pay_mode'] = '';
                $_POST['pay_date'] = date('Y-m-d');
                $_POST['transaction_id'] = '';
                $_POST['chkno'] = '';
                $_POST['bank'] = '';
                $_POST['chkdate'] = '';
                $log('Invoice POST (dup path) — paytype:' . ($_POST['paytype'] ?? '') . ' custid:' . ($_POST['custid'] ?? '') . ' oid:' . ($_POST['oid'] ?? '') . ' item_cost:' . ($_POST['item_cost'] ?? '') . ' amount:' . ($_POST['amount'] ?? '') . ' status:' . ($_POST['status'] ?? '') . ' pay_date:' . ($_POST['pay_date'] ?? 'NOT_SET'));
                $invoiceSaveResult2 = $vendorinvoiceModel->save($_POST);
                $log('vendorinvoiceModel->save() (dup path) returned: ' . var_export($invoiceSaveResult2, true));
                $this->sendrecemail($_POST);
                if (!empty($id)) {

                    $Amount = $_POST['item_cost'] ?? '';
                    $totalamount = $_POST['amount'] ?? '';
                    $BusinessName = $_POST['businessname'] ?? '';
                    $OwnerName = $_POST['ownername'] ?? '';
                    $taxid = $_POST['taxid'] ?? '';
                    $paymentfor = $_POST['paymentfor'] ?? '';
                    if ($paymentfor == 'BOOTH') {
                        $payforui = 'Booth Rentals';
                    } else if ($paymentfor == 'MAGADV') {
                        $payforui = 'Magazine Advertisements';
                    } else if ($paymentfor == 'OTHADV') {
                        $payforui = 'Other Advertisements';
                    }
                    else{
                        $payforui = $paymentfor;
                    }
                    $type = $_POST['item_desc'] ?? '';
    
                    echo "<div style='text-align: -webkit-center;' class = 'pay'>
                <table border='4' width='585px'>
                <tr>
                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style='margin-left:12em;'><h1 style='text-align:center;font-family:fangsong; font-size:30px;'><b>Houston Durga Bari Society</b></h1> </td>
                 </tr>
                 <tr><td style='width:50%;'>Owner Name</td> <td style='width:50%;'>" . $OwnerName . "</td> </tr>
                 <tr><td>Business Name</td> <td>" . $BusinessName . "</td> </tr>
                 <tr><td>Tax Id</td> <td>" . $taxid . "</td>  </tr>
                 <tr><td>Payment For</td> <td>" . $payforui . "</td> </tr>
                 <tr><td>Type</td> <td>" . $type . "</td> </tr>
                 <tr><td>Amount</td> <td><span style='color:red;'>$</span>" . $Amount . "</td> </tr>
                 <tr><td>Total Amount</td> <td><span style='color:red;'>$</span>" . $totalamount . "</td> </tr>
                 <tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   </tr>
                 </tr>";
    
                    echo "</table>";
                    echo "<a  href='" . INSTALL_URL . "VendorPayment/VendorPayment'>Go to home</a>";
                    echo "</div>";
                   
                   $mobileno = $_POST['phone'] ?? '';
                    if ($mobileno  != null) {
                        $msg = 'Houston Durga Bari: Your Vendor request have been submitted. Owner Name is ' . $OwnerName . ', Payment For: ' . $payforui .  ', Type:  ' . $type . ', Business Name:  ' . $BusinessName . ', Tax Id: '. $taxid. ', Amount : $' . $Amount . ', Total Amount: $'. $totalamount;
                       $this->SendSMS($mobileno, $msg);
                     }
                      $_SESSION['vendor_payment_processed'] = true;
                    exit();
                }
            }

          
           
        }
    }


}
