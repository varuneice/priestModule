<?php

require_once CONTROLLERS_PATH . 'AppRental.php';
require __DIR__ . '/Twillio/vendor/autoload.php';
use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
//use \vendor\twilio\sdk\src\Twilio\Rest\Client;

class RentalBooking extends AppRental {

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

        date_default_timezone_set($this->tpl['option_arr_values']['timezone']);

        $action = $_REQUEST['action'] ?? '';

        if (!$this->isLoged() && $action != 'login') {
            //$_SESSION['err'] = 2;
            if ($action != 'useredit' && $action != 'locationprice') {
                $_SESSION['err'] = 2;
                Util::redirect(INSTALL_URL . "Admin/login");
            }
            //Util::redirect(INSTALL_URL . "Admin/login");
        }
        
        if ($this->isMember() ) {
            $_SESSION['err'] = 2;
            Util::redirect(INSTALL_URL . "Admin/login");
        }

        $this->css[] = array('file' => 'front/style.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/bootstrap.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/font-awesome.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/ionicons.min.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/daterangepicker/daterangepicker-bs3.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'ui-custom.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/admin.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/datepicker/datepicker.css', 'path' => CSS_PATH);
        $this->css[] = array('file' => 'admin/gzstyling/gzstyle.css', 'path' => CSS_PATH);

        $this->js[] = array('file' => 'jquery/jquery-1.9.1.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/bootstrap.min.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/jquery.dataTables.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datatables/dataTables.bootstrap.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/gzadmin/app.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery-ui.min.js', 'path' => LIBS_PATH . 'jquery/ui/');
        $this->js[] = array('file' => 'ajax-upload/das.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'ajax-upload/jquery.form.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'jquery/jquery-validation-1.13.0/dist/jquery.validate.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'jquery/ui/jquery-ui.min.js', 'path' => LIBS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/daterangepicker/daterangepicker.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'gzadmin/plugins/datepicker/bootstrap-datepicker.js', 'path' => JS_PATH);
        //for stripe payment
         if ($action == 'useredit') {
             $this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
         } 
        //$this->js[] = array('file' => '', 'path' => 'https://js.stripe.com/v3/', 'remote' => 1);
        if ($action == 'send') {
            $this->js[] = array('file' => 'jquery/tinymce/tinymce.min.js', 'path' => LIBS_PATH);
        }
        $this->js[] = array('file' => 'GzRentalBooking.js', 'path' => JS_PATH);
        $this->js[] = array('file' => 'loadingoverlay.js', 'path' => JS_PATH);
    }


    function locationprice()
    {
        GzObject::loadFiles('Model', array('RentalLocationPriceDetails'));
        $RentalLocationPriceDetailsModel = new RentalLocationPriceDetailsModel();
       // $location = $_POST['location'];
        $arr = $RentalLocationPriceDetailsModel->locationprice();
        $this->tpl['price'] =  $arr;
        foreach ($arr as $key => $value) {    
            echo  "<input  id='rentallocationprice' value='$value[price]'/> ";            
                                                  
        }   
    }

function selecteddate()
    {
        GzObject::loadFiles('Model', array('RentalBookingSlot'));
        $RentalBookingSlotModel = new RentalBookingSlotModel();
        $getdateui = $_POST['selecteddate'] ?? '';
        $newDatefinal = strtotime($getdateui);
        $arr = $RentalBookingSlotModel->selecteddate($newDatefinal);
        foreach ($arr as $key => $value) {   
            echo  "<input  id='rentaldate' value='$value[timestamp]'/> "; 
            echo  "<input  id='uirentaldate' value='$newDatefinal'/> ";            
                                                  
        }   
    }

    function rentalpricecreate()
    {
        GzObject::loadFiles('Model', array('RentalLocationPriceDetails'));
        $RentalLocationPriceDetailsModel = new RentalLocationPriceDetailsModel();

        if (!empty($_POST['rentallocationcreate'])) {
           
                  // $data = array();

            $id = $RentalLocationPriceDetailsModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "RentalBooking/index");
        }
    }
    function rentalcreate()
    {
        GzObject::loadFiles('Model', array('rentaladvancepayment'));
        $rentaladvancepaymentModel = new rentaladvancepaymentModel();

        if (!empty($_POST['rentalcreate'])) {


            // $data = array();

            $id = $rentaladvancepaymentModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "RentalBooking/index");
        }

    }

    function rentaledit(){
        GzObject::loadFiles('Model', array('RentalLocationPriceDetails', 'rentaladvancepayment'));
        $RentalLocationPriceDetailsModel = new RentalLocationPriceDetailsModel();
        $rentaladvancepaymentModel = new rentaladvancepaymentModel();
        if (!empty($_POST['priceedit'])) {
    
            $data = array();
            $id = $RentalLocationPriceDetailsModel->update(array_merge($_POST));
    
            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }
    
            if (!$this->isAdmin() && !$this->isRental() && !$this->isEducation()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "RentalBooking/index");
            }
        }
        $id = $_GET['id'] ?? '';
        $rentalpricearr = $RentalLocationPriceDetailsModel->get($id);
        $this->tpl['rentalpricearr'] = $rentalpricearr;
         if (!empty($_POST['edit_addamount'])) {
    
                $data = array();
                $id = $rentaladvancepaymentModel->update(array_merge($data, $_POST));
        
    
                if (!empty($bong)) {
                    $_SESSION['status'] = 20;
                } else {
                    $_SESSION['status'] = 21;
                }
    
                if (!$this->isAdmin() && !$this->isRental() && !$this->isEducation()) {
                    Util::redirect(INSTALL_URL . "Admin/dashboard");
                } else {
                    Util::redirect(INSTALL_URL . "RentalBooking/index");
                }
    
            }
            $id = $_GET['id'] ?? '';
            $rentalarr = $rentaladvancepaymentModel->get($id);
    
            $this->tpl['rentalarr'] = $rentalarr;
    }

    function categorycreate()
    {
        GzObject::loadFiles('Model', array('Category'));
        $CategoryModel = new CategoryModel();

        if (!empty($_POST['categorycreate'])) {


            // $data = array();

            $id = $CategoryModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            Util::redirect(INSTALL_URL . "RentalBooking/categoryitemindex");
        }

    }
    function categoryedit(){
    
        GzObject::loadFiles('Model', array('Category'));
        $CategoryModel = new CategoryModel();

      if (!empty($_POST['edit_Category'])) {

            $data = array();
            $id = $CategoryModel->update(array_merge($data, $_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "RentalBooking/categoryitemindex");
            }
        }
        $id = $_GET['id'] ?? '';
        $Categoryarr = $CategoryModel->get($id);

        $this->tpl['Categoryarr'] = $Categoryarr; 
     
    }

    function itemscreate() {
        GzObject::loadFiles('Model', array('Items', 'Category'));
        $ItemsModel = new ItemsModel();
        $CategoryModel = new CategoryModel();
        $arr= $CategoryModel->getcategory();
        $this->tpl['Categoryname'] =  $arr;

        if (!empty($_POST['itemscreate'])) {


            if (!empty($_FILES['img'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['img']);

                $img_name = time();

                if ($handle->uploaded) {

                    $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

                    $handle->file_new_name_body = $img_name;
                    $handle->image_resize = true;
                    $handle->image_x = 200;
                    $handle->image_ratio_y = true;
                    $handle->allowed = array('image/*');
                    $handle->process($thumb_dest);

                    if ($handle->processed) {
                        $handle->clean();
                    } else {
                        echo 'error : ' . $handle->error;
                    }
                    $data['avatar'] = $handle->file_dst_name;
                }
            }
           // $data = array();
            //$item = $_POST['items'];
            //$price = $_POST['price'];
            
           // $id = $ItemsModel->getMaxid() + 1;
           // $_POST['id'] = $id;
            
            //$id = $ItemsModel->save(array_merge($_POST, $data));
            $id = $ItemsModel->save(array_merge($_POST));

            if (!empty($id)) {
                $_SESSION['status'] = 16;
            } else {
                $_SESSION['status'] = 17;
            }
            
            Util::redirect(INSTALL_URL . "RentalBooking/categoryitemindex");
        }

    }



    function useredit()
    {
        GzObject::loadFiles('Model', array('RentalBooking', 'Calendar', 'RentalBookingSlot', 'CustomDate', 'ConfirmCode', 'RentalReservationsHistory', 'idnumbers', 'Donation'));
        $RentalBookingModel = new RentalBookingModel();
        $CalendarModel = new CalendarModel();
        $RentalBookingSlotModel = new RentalBookingSlotModel();
        $CustomDateModel = new CustomDateModel();
        $ConfirmCodeModel = new ConfirmCodeModel();
        $RentalReservationsHistoryModel = new RentalReservationsHistoryModel();
        $idnumbersModel = new idnumbersModel();
         $DonationModel = new DonationModel();

        
        if (!empty($_POST['edit_booking'])) {

            $data = array();
            $old = $RentalBookingModel->get($_POST['id'] ?? '');

            $data['amount'] = (($_POST['deposit'] ?? 0) > 0) ? ($_POST['deposit'] ?? 0) : ($_POST['total'] ?? 0);
            $data['amount'] = number_format($data['amount'], 2, '.', '');
            
            $getdate = $_POST['date'] ?? '';
            $newDate = strtotime($getdate);
            $_POST['date'] = $newDate;
            $time = time();
            $_POST['created'] = $time;
            //$finalDate = date("Y-m-d", $time);
            //$_POST['finalDate'] = $finalDate;
            $id = $_POST['id'] ?? '';
               // for generate oid 
        $maxoid = $idnumbersModel->getMaxoid() + 1;
        $update_oid = $idnumbersModel->Updateoid($maxoid);
        $_POST['oid'] = $maxoid;
         // end generate oid for
             $RentalBookingModel->update(array_merge($data, $_POST));
              $starttime = $_POST['Starttime'] ?? '';
                        $endtime = $_POST['Endtime'] ?? '';
                        $hours = $_POST['Hours'] ?? '';
                        $stime = $starttime;
                        $etime = $endtime;
                        $h = $hours;
                       $location = $_POST['location'] ?? '';
            
            $slotid = $_POST['slotid'] ?? '';
            if (!empty($slotid)) {

                //foreach ($_SESSION[$this->default_product]['slots'][$_REQUEST['cid']] as $i => $count) {
                $dataslot = array();
                $dataslot['calendar_id'] = 2;
                $dataslot['id'] = $slotid;
                $dataslot['booking_id'] = $id;
                $dataslot['timestamp'] = $newDate;
                $time = time();
                $dataslot['timecreated'] = $time;
                
                // $data['StartTime'] = $_POST['Starttime'] ?? '';
                // $data['EndTime'] = $_POST['Endtime'] ?? '';
                // $data['Hours'] = $_POST['Hours'] ?? '';
                $current = $dataslot['timecreated'];
                $bookingdate = $dataslot['timestamp'];
                 //$RentalBookingSlotModel->update($dataslot);
                //$RentalBookingSlotModel->save($data);
                $bookdate = date("Y-m-d", $bookingdate);
                //}
                $RentalBookingSlotModel->update($dataslot);
                $invoiceid = $RentalBookingModel->saveInvoice($id);
                unset($_SESSION[$this->default_product]);

                $_SESSION[$this->default_product] = array();

                if (($_POST['payment_method'] ?? '') == 'others') {
                    $opts = array();
                    $opts['Confirmation'] = $_POST['confirm_code'] ?? '';
                    $arr = $ConfirmCodeModel->getAll($opts);
                    $oid = $_POST['oid'] ?? '';
                    $cmCode = $_POST['zellecode'] ?? '';
                     $ConfirmCodeModel->UpdateCode($cmCode);
                    if ($oid !=null) {
                        $opts = array();
                        $opts['id'] = $id;
                        $opts['transaction_id']=$cmCode;
                       $opts['status'] = 'confirmed';
                        $arr = $RentalBookingModel->get($id);
                        $pujaType = $arr['promo_code'];
                        $location = $arr['location'];
                        $mobileno = $arr['phone'];
                        $email = $arr['email'];
                        $address_1 = $arr['address_1'];
                        $payment_method = $arr['payment_method'];
                        $Bookinno = $arr['booking_number'];
                        $Name = $arr['first_name'] . $arr['second_name'];
                        $Date = date("F j, Y", $newDate);
                        $BookingTime = $dataslot['timestamp'] ?? $newDate;
                        $rentaldataarr = array();
                        $rentaldataarr =  array_merge($opts, $_POST);
                        $RentalBookingModel->update($opts);
                        // save data in donations start
                        date_default_timezone_set("America/Chicago");
                        $today = date("Y/m/d");
                        $value = array();
                        $value['oid'] = $_POST['oid'] ?? '';
                        $value['Member_id'] = $_POST['Member_id'] ?? '';
                        $value['MemberName'] = $_POST['first_name'] . ' ' . ($_POST['second_name'] ?? '');
                        $value['Amount'] = $rentaldataarr['total'];
                        $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                        $value['payment_status'] = 'succeeded';
                        $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                        $value['stripe_return'] = $opts['stripe_return'] ?? '';
                        $value['transaction_id'] = $opts['transaction_id'] ?? '';
                        $value['paid_amount'] = $opts['paid_amount'] ?? '';
                        $value['update_on'] = $_POST['UpdateOn'] ?? '';
                        $value['stripe_product'] = $opts['stripe_product'] ?? '';
                        $value['pay_date'] = $today;
                        $value['pay_type'] = 'RENTAL';
                        $value['pay_for'] = '1 Rental';
                        $value['Tele1'] = $_POST['phone'] ?? '';
                        $value['email'] = $_POST['email'] ?? '';
                        $value['City'] = $_POST['city'] ?? '';
                        $value['State'] = $_POST['state'] ?? '';
                        $value['Zip_Code'] = $_POST['zip'] ?? '';
                        $value['bank'] = $_POST['bank'] ?? '';
                        $value['chkno'] = $_POST['chkno'] ?? '';
                        $value['chkdate'] = $_POST['chkdate'] ?? null;
                        $value['ReceiveBy'] = $_POST['ReceiveBy'] ?? '';
                        $DonationModel->SaveDataInDonation($value);

                        // end

                        
                        $value = array();
                        $value['oid'] = $rentaldataarr['oid'];
                        $value['id'] = $rentaldataarr['id'];
                        $value['calendar_id'] = $old['calendar_id'];
                        $value['booking_number'] = $rentaldataarr['booking_number'];
                        $value['location'] = $rentaldataarr['location'];
                        $value['first_name'] = $rentaldataarr['first_name'];
                        $value['second_name'] = $rentaldataarr['second_name'];
                        $value['phone'] = $rentaldataarr['phone'];
                        $value['email'] = $rentaldataarr['email'];
                        $value['address_1'] = $rentaldataarr['address_1'];
                        $value['additional'] = $rentaldataarr['additional'];
                        $value['amount'] = $rentaldataarr['total'];
                        $value['total'] = $rentaldataarr['total'];
                        $value['status'] = $rentaldataarr['status'];
                        $value['payment_method'] = $rentaldataarr['payment_method'];
                        $value['created'] = $rentaldataarr['created'];
                        $value['transaction_id'] = $rentaldataarr['transaction_id'];
                        $value['date'] = $rentaldataarr['date'];
                        $value['enddate'] = $rentaldataarr['enddate'] ?? '';
                        $value['finalDate'] = $rentaldataarr['finalDate'] ?? '';
                        $value['Member_id'] = $rentaldataarr['Member_id'] ?? '';
						$value['extraamount'] = $rentaldataarr['extraamount'] ?? '';
						$value['rentalprice'] = $rentaldataarr['rentalprice'] ?? '';
                        //$RentalReservationsHistoryModel->SaveDataInhistory($value);
                        $msg = '';
                        // $result = $this->sendBookingEmails($id, 'confirmation', 'client');
                                 //$this->sendBookingEmails($id, 'confirmation', 'admin');
                                 $result = $this->sendBookingEmailsNew($id, 'confirmation', 'Rental Client',$email,$mobileno,$Date ,$location,$stime,$etime,$h,$address_1,$msg,$invoiceid);
                                 //$this->sendBookingEmailsNew($id, 'confirmation', 'Rental Admin',$mobileno,$currentDate ,$location,$stime,$etime,$h,$address_1,$email,$msg,$invoiceid);
                                // $this->sendBookingEmailsNew($id, 'confirmation', 'Education Admin',$mobileno,$currentDate ,$location,$stime,$etime,$h,$address_1,$email,$msg,$invoiceid);
    
                        $invoiceID = $result;
                        $totalfinalamount = $rentaldataarr['total'];
                        //$path ='C:\xampp\htdocs\HDBS\application\web\upload\invoice\booking_'.$id.'_invoice_'.$invoiceID.'.pdf';
                        $path = INSTALL_URL . 'application/web/upload/invoice/Rentalbooking_' . $id . '_invoice_' . $invoiceID . '.pdf';
                         
                          $msg = 'Houston Durga Bari: Your Rental Booking Number is ' . $Bookinno . ' for ' . $location . ' on ' . $Date . '  Durga Bari has been confirmed Paid Amount: $ ' . $totalfinalamount . '  Order Id: '. $rentaldataarr['oid'].'. Click here  for receipt:' . $path;
                        $this->SendSMS($mobileno, $msg);
                        //echo "<a onclick = 'alertcheck()'>Go to home</a> ";
                        // echo '<script>alert("Booking has been saved successfully! please check your mail.")</script>';
                        //Util::redirect(INSTALL_URL . "GzPreview/index");
                    } else {
                        echo "<div style='margin-left:140px;' class = 'pay'>
                    <table border='4' width='585px'>
                    <tr>
                    <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> </tr>
                    <tr>
                    <td colspan='2'><b>Your booking request have been submitted.
                    Your payment is not confirmed yet. To confirm your booking please contact to<a href='mailto:hdbs.payment@durgabari.org'> hdbs.payment@durgabari.org</a></b></td></tr>
                    </tr>";
                        echo "</table>";
                        echo "</div>";
                    }

                } elseif (($_POST['payment_method'] ?? '') == 'stripe') {
                    require APP_PATH . '/helpers/stripe/lib/Stripe.php';

                    $error = '';
                    $success = '';

                    Stripe::setApiKey($this->tpl["option_arr_values"]["stripe_api_key"]);

                    try {
                        if (!isset($_POST['stripeToken'])) {
                            throw new Exception("The Stripe Token was not generated correctly");
                        }
                        $oid = $_POST['oid'] ?? '';
                        $oldamount = $_POST['total'] ?? '';
                        $amount = round($oldamount * 100);
                        $FinalBookingNo = $_POST['booking_number'] ?? '';
                        $payment = Stripe_Charge::create(
                            array(
                                "amount" => $amount,
                                "currency" => $this->tpl["option_arr_values"]["currency"],
                                "card" => $_POST['stripeToken'],
                                "description" => "Booking No:" . $FinalBookingNo . ', ' . "Email:" . ($_POST['email'] ?? '') . ', ' . "Full Name:" . ($_POST['first_name'] ?? '') . ' ' . ($_POST['second_name'] ?? '') . ' , ' . "Location:" . ($_POST['location'] ?? '')  . ' ,  ' . "Additional:" . ($_POST['additional'] ?? ''),
                                "metadata" => ["orderid" => $oid]
                            )
                        );

                        $this->tpl['payment']['balance_transaction'] = $payment->balance_transaction;
                        $this->tpl['payment']['amount'] = $payment->amount;
                        $this->tpl['payment']['status'] = $payment->status;
                        $this->tpl['payment']['currency'] = $payment->currency;

                        if ($payment->status == 'succeeded') {

                            $booking = $RentalBookingModel->get($id);

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            $opts['status'] = 'confirmed';
                            //$opts['status'] =$_POST['status'] ?? '';
                            $string = substr($payment->amount, 0, -2);
                            $arr = $RentalBookingModel->get($id);
                            $pujaType = $arr['promo_code'];
                            $Bookinno = $arr['booking_number'];
                            $location = $arr['location'];
                            $mobileno = $arr['phone'];
                            $address_1 = $arr['address_1'];
                            $payment_method = $arr['payment_method'];
                            $memberid = $_POST['Member_id'] ?? '';
                            $BookingTime = $dataslot['timestamp'] ?? $newDate;
                            $str_arr = explode(",", $payment->description ?? '');
                            //$replacement['date'] = date($option_arr['date_format'], strtotime($invoice['date']));
                            //$Date=date (strtotime("m-d-Y",$t1));
                            $Date = date("F j, Y", $newDate);
                          
                              $rentaldataarr = array();
                             $rentaldataarr =  array_merge($opts, $_POST);
                            $RentalBookingModel->update($opts);
                            // save data in donations start
                            date_default_timezone_set("America/Chicago");
                            $today = date("Y/m/d");
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['MemberName'] = $_POST['first_name'] . ' ' . ($_POST['second_name'] ?? '');
                            $value['Amount'] = $rentaldataarr['total'];
                            $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                            $value['payment_status'] = 'succeeded';
                            $value['payment_timestamp'] = $opts['payment_timestamp'] ?? '';
                            $value['stripe_return'] = $opts['stripe_return'] ?? '';
                            $value['transaction_id'] = $opts['transaction_id'] ?? '';
                            $value['paid_amount'] = $opts['paid_amount'] ?? '';
                            $value['update_on'] = $_POST['UpdateOn'] ?? '';
                            $value['stripe_product'] = $opts['stripe_product'] ?? '';
                            $value['pay_date'] = $today;
                            $value['pay_type'] = 'RENTAL';
                            $value['pay_for'] = '1 Rental';
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['bank'] = $_POST['bank'] ?? '';
                            $value['chkno'] = $_POST['chkno'] ?? '';
                            $value['chkdate'] = $_POST['chkdate'] ?? null;
                            $value['ReceiveBy'] = $_POST['ReceiveBy'] ?? '';
                            $DonationModel->SaveDataInDonation($value);

                            // end
                            
                            $value = array();
                        //$value['oid'] = $oid;
                        $value['id'] = $rentaldataarr['id'];
                        $value['calendar_id'] = $old['calendar_id'];
                        $value['booking_number'] = $rentaldataarr['booking_number'];
                        $value['location'] = $rentaldataarr['location'];
                        $value['first_name'] = $rentaldataarr['first_name'];
                        $value['second_name'] = $rentaldataarr['second_name'];
                        $value['phone'] = $rentaldataarr['phone'];
                        $value['email'] = $rentaldataarr['email'];
                        $value['address_1'] = $rentaldataarr['address_1'];
                        $value['additional'] = $rentaldataarr['additional'];
                        $value['amount'] = $rentaldataarr['total'];
                        $value['total'] = $rentaldataarr['total'];
                        $value['status'] = $rentaldataarr['status'];
                        $value['payment_method'] = $rentaldataarr['payment_method'];
                        $value['created'] = $rentaldataarr['created'];
                        $value['stripe_return'] = $rentaldataarr['stripe_return'] ?? '';
                        $value['transaction_id'] = $rentaldataarr['transaction_id'];
                        $value['paid_amount'] = $rentaldataarr['paid_amount'] ?? '';
                        $value['stripe_product'] = $rentaldataarr['stripe_product'] ?? '';
                        $value['date'] = $rentaldataarr['date'];
                        $value['enddate'] = $rentaldataarr['enddate'] ?? '';
                        $value['finalDate'] = $rentaldataarr['finalDate'] ?? '';
                        $value['Member_id'] = $rentaldataarr['Member_id'] ?? '';
						$value['extraamount'] = $rentaldataarr['extraamount'] ?? '';
						$value['rentalprice'] = $rentaldataarr['rentalprice'] ?? '';
                        //$RentalReservationsHistoryModel->SaveDataInhistory($value);
                             $email = $_POST['email'] ?? '';
                             $msg = '';
                           // $result = $this->sendBookingEmails($id, 'confirmation', 'client');
                                 //$this->sendBookingEmails($id, 'confirmation', 'admin');
                                $result = $this->sendBookingEmailsNew($id, 'confirmation', 'Rental Client',$email,$mobileno,$Date ,$location,$stime,$etime,$h,$address_1,$msg,$invoiceid);
                                //$this->sendBookingEmailsNew($id, 'confirmation', 'Rental Admin',$mobileno,$currentDate ,$location,$stime,$etime,$h,$address_1,$email,$msg,$invoiceid);
                               // $this->sendBookingEmailsNew($id, 'confirmation', 'Education Admin',$mobileno,$currentDate ,$location,$stime,$etime,$h,$address_1,$email,$msg,$invoiceid);
                            $invoiceID = $result;
                           $totalfinalamount = $rentaldataarr['total'];  
                            $path = INSTALL_URL . 'application/web/upload/invoice/Rentalbooking_' . $id . '_invoice_' . $invoiceID . '.pdf';
                              $msg = 'Houston Durga Bari: Your Rental Booking Number is ' . $Bookinno . ' for ' . $location . ' on ' . $Date . '  Durga Bari has been confirmed Paid Amount: $ ' . $totalfinalamount . '  Order Id: '. $rentaldataarr['oid'].'. Click here  for receipt:' . $path;
                            $this->SendSMS($mobileno, $msg);

                            //echo "<a onclick = 'alertcheck()'>Go to home</a> ";
                        } else {
                            $booking = $RentalBookingModel->get($id);

                            $opts = array();
                            $opts['id'] = $id;
                            $opts['stripe_return'] = $payment->status;
                            $opts['transaction_id'] = $payment->id;
                            $opts['paid_amount'] = $payment->amount;
                            $opts['stripe_product'] = $payment->description;
                            $BookingModel->update($opts);

                            $_SESSION['status'] = '<strong>' . __('declined_card') . '</strong>';

                           // Util::redirect(INSTALL_URL . "GzRental/index");
                        }
                    } catch (Exception $e) {

                        $_SESSION['status'] = '<strong>Error!</strong> ' . $e->getMessage();
                    }
                } elseif (($_POST['payment_method'] ?? '') == 'authorize') {
                    require_once APP_PATH . 'helpers/sdk-php-master/autoload.php';
                }
                 
                $this->tpl['booking_details'] = $RentalBookingModel->getBookingDetails($id);

                $status = 10;
            } else {
                $status = 11;
            }
            // session_start();
            // $_SESSION['myValue']=$oid;
            //Avinash comment 
            // if (!empty($id)) {
            //     $_SESSION['status'] = 14;
            // } else {
            //     $_SESSION['status'] = 15;
            // }

            //Util::redirect(INSTALL_URL . "RentalBooking/index");
             //Util::redirect(INSTALL_URL . "RentalBooking/useredit/".$id);


        }

         $id = $_GET['id'] ?? '';
        if ($id != null || $id = "") {
            $arr = $RentalBookingModel->get($id);
            $this->tpl['booking'] = $arr;
            $arr1 = $RentalBookingSlotModel->getAllBookingSlotData($id);
            $this->tpl['bookingslot'] = $arr1;
        }
    }


       
   
    function itemsedit() {
        GzObject::loadFiles('Model', array('Items', 'Category'));
        $ItemsModel = new ItemsModel();
        $CategoryModel = new CategoryModel();
        $arr= $CategoryModel->getcategory();
        $this->tpl['Categoryname'] =  $arr;
    
        if (!empty($_POST['edit_user'])) {
            $data = array();
            if (!empty($_FILES['img'])) {

                require_once APP_PATH . 'helpers/uploader/class.upload.php';

                $handle = new upload($_FILES['img']);

                $img_name = time();

                if ($handle->uploaded) {

                    $thumb_dest = INSTALL_PATH . UPLOAD_PATH . 'avatar/thumb/';

                    $handle->file_new_name_body = $img_name;
                    $handle->image_resize = true;
                    $handle->image_x = 200;
                    $handle->image_ratio_y = true;
                    $handle->allowed = array('image/*');
                    $handle->process($thumb_dest);

                    if ($handle->processed) {
                        $handle->clean();
                    } else {
                        echo 'error : ' . $handle->error;
                    }
                    $data['avatar'] = $handle->file_dst_name;
                }
            }

            if (empty($_FILES['img'])) {
                $avat = $_POST['avatar'] ?? '';
                //$event = $_POST['events'];
                $item = $_POST['items'] ?? '';
                //$price = $_POST['price'];
                //$eventprice = $price."/".$event."/". $avat;
                //$_POST['price'] = $eventprice;
                //$_POST['events'] = $eventprice;
                $id = $ItemsModel->update(array_merge($data, $_POST));
            } else {
                $item = $_POST['items'] ?? '';
                //$price = $_POST['price'];
                $avat = $data['avatar'];
                //$_POST['avatar'] = $avat;
                //$eventprice = $price."/".$event."/". $avat;
                //$_POST['price'] = $eventprice;
                //$_POST['events'] = $eventprice;
                $id = $ItemsModel->update(array_merge($data, $_POST));
                
            }
            //$data = array();
            

            if (!empty($id)) {
                $_SESSION['status'] = 20;
            } else {
                $_SESSION['status'] = 21;
            }

            if (!$this->isAdmin()) {
                Util::redirect(INSTALL_URL . "Admin/dashboard");
            } else {
                Util::redirect(INSTALL_URL . "RentalBooking/categoryitemindex");
            }
        }
        $id = $_GET['id'] ?? '';
        $Itemsarr = $ItemsModel->get($id);
        $this->tpl['Itemsarr'] = $Itemsarr;

    }
// function rentaledit(){
//     GzObject::loadFiles('Model', array('RentalLocationPriceDetails'));
//     $RentalLocationPriceDetailsModel = new RentalLocationPriceDetailsModel();
//     if (!empty($_POST['priceedit'])) {

//         $data = array();
//         $id = $RentalLocationPriceDetailsModel->update(array_merge($_POST));

//         if (!empty($id)) {
//             $_SESSION['status'] = 20;
//         } else {
//             $_SESSION['status'] = 21;
//         }

//         if (!$this->isAdmin()) {
//             Util::redirect(INSTALL_URL . "Admin/dashboard");
//         } else {
//             Util::redirect(INSTALL_URL . "RentalBooking/index");
//         }
//     }
//     $id = $_GET['id'] ?? '';
//     $rentalpricearr = $RentalLocationPriceDetailsModel->get($id);
//     $this->tpl['rentalpricearr'] = $rentalpricearr;
// }

function categoryitemindex(){
    GzObject::loadFiles('Model', array('Category', 'Items'));
        $CategoryModel = new CategoryModel();
        $ItemsModel = new ItemsModel();
        $opts = array();
        $Categoryarr = $CategoryModel->getAll($opts);
        $this->tpl['Categoryarr'] = $Categoryarr;

        
        $opts = array();
        $Itemsarr = $ItemsModel->getAll($opts);
        $this->tpl['Itemsarr'] = $Itemsarr;
    }


   function create() {
        GzObject::loadFiles('Model', array('RentalBooking', 'Calendar', 'RentalBookingSlot','Member', 'idnumbers', 'Donation'));
        $RentalBookingModel = new RentalBookingModel();
        $CalendarModel = new CalendarModel();
        $RentalBookingSlotModel = new RentalBookingSlotModel();
        $MemberModel = new MemberModel();
        $idnumbersModel = new idnumbersModel();
        $DonationModel = new DonationModel();

        if (!empty($_POST['create_booking'])) {

            // for generate oid 
            $maxoid = $idnumbersModel->getMaxoid() + 1;
            $update_oid = $idnumbersModel->Updateoid($maxoid);
            $_POST['oid'] = $maxoid;
            // end generate oid for
            $datamember =  $MemberModel->rentalmemberduplicate();
            if($datamember == null){
                    
                    // for generate memberid for gd
                        $maxid = $idnumbersModel->getMaxmid() + 1;
                        $update_mid = $idnumbersModel->Updatemid($maxid);
                        $_POST['Member_id'] = $maxid;
                   // end generate memberid for gd 
                }
                if ($datamember != null) {
                    $_POST['Member_id'] = $datamember;
                }
                $data['Member_id'] = $_POST['Member_id'] ?? '';
                //$data['booking_number'] = Util::incrementalHash(10);

                $_POST['total'] = $_POST['totalamoutndata'];
                $date = date('Y');
                $BookingNo = $RentalBookingModel->getMax();
                $bno =  substr($BookingNo,4);
                $bnonumeric = intval($bno);
               // if($bno==false){
                //     $data['booking_number'] = $date."001";
                // }
                // else{ }
                $bookingnumber = $bnonumeric +1 ;
                $_POST['booking_number'] = $date."0".$bookingnumber;
                $_POST['calendar_id'] = 2;
            $data = array();
          
            //$data['amount'] = (($_POST['deposit'] ?? 0) > 0) ? ($_POST['deposit'] ?? 0) : ($_POST['total'] ?? 0);
            //$data['amount'] = number_format($data['amount'], 2, '.', '');
            // $data['date'] = strtotime(date('Y-m-d'));
            // $time = time();
                
            // $data['created'] = $time;

            // $finalDate = date("Y-m-d", $time);

            // $data['finalDate'] = $finalDate;

            $getdate = $_POST['date'] ?? '';
                $newDate = strtotime($getdate);
                $data['date'] = $newDate;
                $time = time();
                $data['created'] = $time;
                $finalDate = date("Y-m-d", $time);
                $data['finalDate'] = $getdate;

            $id = $RentalBookingModel->save(array_merge($_POST, $data));

            if (!empty($id)) {
                //foreach ($_SESSION[$this->default_product]['admin']['slots'][$_POST['calendar_id']] as $i => $count) {
                    // $data = array();
                    // $data['calendar_id'] = $_POST['calendar_id'] ?? '';
                    // $data['booking_id'] = $id;
                    // $data['timestamp'] = $i;
                    // $data['count'] = $count;
                    // $data['timecreated'] = time();
                    $data = array();
                        $data['calendar_id'] = 2;
                        $data['booking_id'] = $id;
                        $data['timestamp'] = $newDate;
                       
                        $currentDate = date("Y-m-d", $newDate);
                        $data['count'] = 1;
                        $data['timecreated'] = time();
                        $data['StartTime'] = $_POST['hidestarttime'] ?? '';
                        $data['EndTime'] = $_POST['hideendtime'] ?? '';
                        $data['Hours'] = $_POST['Hours'] ?? '';
                        $starttime = $data['StartTime'];
                        $endtime = $data['EndTime'];
                        $hours = $data['Hours'];
                        $stime = $starttime;
                        $etime = $endtime;
                        $h = $hours;

                    $RentalBookingSlotModel->save($data);
                    $invoiceid = $RentalBookingModel->saveInvoice($id);
                    
                   $rentalfinalpaidamount = is_numeric($_POST['totalamoutndata'] ?? null) ? (float)$_POST['totalamoutndata'] : 0;
                   $adminamount = 0;
                   $data['bank'] = '';
                   $data['chkdate'] = null;
                   $data['chkno'] = '';
                   $data['ReceiveBy'] = '';
                   $data['transaction_id'] = '';
                   $data['pay_date'] = '';
                if (($_POST['payment_method'] ?? '') == 'check') {

                    $adminamount = is_numeric($_POST['checkAmount'] ?? null) ? (float)$_POST['checkAmount'] : 0;
                    $data['bank'] = $_POST['checkbankname'] ?? '';
                    $data['chkdate'] = $_POST['CheckDate'] ?: null;
                    $data['chkno'] = $_POST['CheckNo'] ?? '';
                    $data['pay_date'] = $_POST['CheckDate'] ?? '';
                } elseif (($_POST['payment_method'] ?? '') == 'cash') {
                    $adminamount = is_numeric($_POST['cashAmount'] ?? null) ? (float)$_POST['cashAmount'] : 0;
                    $data['ReceiveBy'] = $_POST['ReceiveBy'] ?? '';
                    $data['pay_date'] = $_POST['cashCheckDate'] ?? '';
                } elseif (($_POST['payment_method'] ?? '') == 'directdeposit') {
                    $data['bank'] = $_POST['BankName'] ?? '';
                    $data['pay_date'] = $_POST['transactiondate'] ?? '';
                    $data['transaction_id'] = $_POST['ISFCCode'] ?? '';
                    $adminamount = is_numeric($_POST['directamount'] ?? null) ? (float)$_POST['directamount'] : 0;
                }
                $data['amount'] = $adminamount;
                $data['status'] = 'confirmed';

                $data['id'] =  $id;
                $RentalBookingModel->update($data);
                date_default_timezone_set("America/Chicago");
                $today = date("Y/m/d");
                            // save data in donations start
                            $value = array();
                            $value['oid'] = $_POST['oid'] ?? '';
                            $value['Member_id'] = $_POST['Member_id'] ?? '';
                            $value['MemberName'] = $_POST['first_name'] . ' ' . ($_POST['second_name'] ?? '');
                            $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                            $value['payment_status'] = 'succeeded';
                            $value['transaction_id'] = $data['transaction_id'];
                            $value['update_on'] = $_POST['UpdateOn'] ?? '';
                            $value['pay_date'] = $data['pay_date'];
                            $value['Tele1'] = $_POST['phone'] ?? '';
                            $value['email'] = $_POST['email'] ?? '';
                            $value['City'] = $_POST['city'] ?? '';
                            $value['State'] = $_POST['state'] ?? '';
                            $value['Zip_Code'] = $_POST['zip'] ?? '';
                            $value['bank'] =  $data['bank'];
                            $value['chkno'] =  $data['chkno'];
                            $value['chkdate'] =  $data['chkdate'];
                            $value['ReceiveBy'] =  $data['ReceiveBy'];
                            if ($rentalfinalpaidamount == $adminamount) {
                                $value['pay_type'] = 'RENTAL';
                                $value['pay_for'] = '1 Rental';
                                $value['Amount'] = $adminamount;
                                $DonationModel->SaveDataInDonation($value);
                            }
                            if ($adminamount > 0 && $adminamount < $rentalfinalpaidamount) {
                                $value['pay_type'] = 'RENTAL';
                                $value['pay_for'] = '1 Rental';
                                $value['Amount'] = $adminamount;
                                $DonationModel->SaveDataInDonation($value);
                            }
                            if ($adminamount  > $rentalfinalpaidamount ) {
                                $firstAmount = $rentalfinalpaidamount;
                                $SecondAmount = $adminamount - $rentalfinalpaidamount;
                                for ($i = 0; $i <= 1; $i++) {
                                    if ($i == 0) {
                                        $value['pay_type'] = 'RENTAL';
                                        $value['pay_for'] = '1 Rental';
                                        $value['Amount'] = $firstAmount;
                                        $DonationModel->SaveDataInDonation($value);
                                    }
                                    if ($i == 1) {
                                        $value['pay_type'] = 'DONATION';
                                        $value['pay_for'] ='DONATION / Unrestricted';
                                        $value['Amount'] = $SecondAmount;
                                        $DonationModel->SaveDataInDonation($value);
                                    }
                
                                }
                            }
                            // end

                   if($datamember == null) {
                    $name =$_POST['first_name'].' '.$_POST['second_name'];
                    $value = array();
                    // $value['id'] = $_POST['id'] ?? '';
                    $value['Payment_For'] = $_POST['Payment_For'] ?? '';
                    $value['MemberName'] = $name;
                    $value['Amount'] = $_POST['total'] ?? '';
                    $value['PaymentOption'] = $_POST['payment_method'] ?? '';
                    $value['payment_status'] = 'confirmed';
                    $value['transaction_id'] =$data['transaction_id'];
                    $value['update_on'] = $_POST['update_on'] ?? '';
                    $value['Member_id'] = $_POST['Member_id'] ?? '';
                    $value['cc_name'] = $_POST['cc_name'] ?? '';
                    $value['remarks'] = $_POST['remarks'] ?? '';
                    $value['oid'] = $_POST['oid'] ?? '';
                    $value['pay_date'] = $today; 
                    $value['pay_type'] = 'Rental'; 
                    $value['pay_for'] = '1 Rental'; 
                    $value['Address'] = $_POST['address_1'] ?? '';
                    $value['email'] = $_POST['email'] ?? '';
                    $value['Tele1'] = $_POST['phone'] ?? '';
                    $MemberModel->SaveDataInmember($value);
                }
                $email = $_POST['email'] ?? '';
                $mobileno = $_POST['phone'] ?? '';
                $location = $_POST['location'] ?? '';
                $address_1 = $_POST['address_1'] ?? '';
                $Date=date("F j, Y",$newDate);
                $Bookinno = $_POST['booking_number'] ?? '';
                $msg='';
                // $result = $this->sendBookingEmails($id, 'confirmation', 'client');
                    // $this->sendBookingEmails($id, 'confirmation', 'admin');
                    $result = $this->sendBookingEmailsNew($id, 'confirmation', 'Rental Client',$email,$mobileno,$Date ,$location,$stime,$etime,$h,$address_1,$msg,$invoiceid);
                   // $this->sendBookingEmailsNew($id, 'confirmation', 'Rental Admin',$mobileno,$currentDate ,$location,$stime,$etime,$h,$address_1,$email,$msg);
                    //$this->sendBookingEmailsNew($id, 'confirmation', 'Education Admin',$mobileno,$currentDate ,$location,$stime,$etime,$h,$address_1,$email,$msg);
                $invoiceID= $result;

                //$path ='C:\xampp\htdocs\HDBS\application\web\upload\invoice\booking_'.$id.'_invoice_'.$invoiceID.'.pdf';
               $path = INSTALL_URL . 'application/web/upload/invoice/Rentalbooking_' . $id . '_invoice_' . $invoiceID . '.pdf';
                $msg = 'Houston Durga Bari: Your Rental Booking Number is ' . $Bookinno . ' for ' . $location . ' on ' . $Date . '  Durga Bari has been confirmed Paid Amount: $ ' . $adminamount . '  Order Id: '. ($_POST['oid'] ?? '').'. Click here  for receipt:' . $path;
                $this->SendSMS($mobileno, $msg);
                
                
                $_SESSION['status'] = 10;
            } else {
                $_SESSION['status'] = 11;
            }
            echo '<script>alert("Data Updated Successfully")</script>';
            Util::redirect(INSTALL_URL . "RentalBooking/index");
        }

        $opts = array();
        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);

        unset($_SESSION[$this->default_product]['admin']);
    }

    function edit() {
        GzObject::loadFiles('Model', array('RentalBooking', 'Calendar', 'RentalBookingSlot', 'CustomDate'));
        $RentalBookingModel = new RentalBookingModel();
        $CalendarModel = new CalendarModel();
        $RentalBookingSlotModel = new RentalBookingSlotModel();
        $CustomDateModel = new CustomDateModel();

        if (!empty($_POST['edit_booking'])) {
            $data = array();
            
            $old = $RentalBookingModel->get($_POST['id'] ?? '');

            
            $ID = $_POST['id'] ?? '';
            $getdate = $_POST['date'] ?? '';
            $newDate = strtotime($getdate);
            $_POST['date'] = date('Y-m-d', $newDate ?: time());

            $_POST['booking_id'] = $ID;
            $_POST['finalDate'] = $getdate;
            $_POST['timestamp'] = $newDate;
            $_POST['timecreated'] = time();

            // Remove empty strings for numeric columns to prevent MySQL strict mode errors
            foreach (['calendars_price', 'tax', 'deposit', 'discount', 'amount', 'total', 'security', 'extraamount', 'oid'] as $numField) {
                if (isset($_POST[$numField]) && $_POST[$numField] === '') {
                    unset($_POST[$numField]);
                }
            }

            //unset($_POST['date']);
                $Bookinno = $_POST['booking_number'] ?? '';
                $location = $_POST['location'] ?? '';
                $mobileno = $_POST['phone'] ?? '';
              $invoiceid =  $RentalBookingModel->saveInvoice($ID);
           $bookingstatus = $_POST['status'] ?? '';
            if($bookingstatus == 'Active'){
                $Date=date("F j, Y", $newDate ?: time());
                $url = INSTALL_URL . "RentalBooking/useredit/$ID";
                $result = $this->sendBookingEmailsNew($ID, 'confirmation', 'Rental Client', $_POST['email'],$_POST['phone'],$Date,$_POST['location'],$_POST['Starttime'],$_POST['Endtime'],$_POST['Hours'],$_POST['address_1'],$url,$invoiceid);
                $msg = 'Houston Durga Bari: Your Rental Booking Number is ' . $Bookinno . ' for ' . $location . ' on ' . $Date . '  Durga Bari has been Approved the request please check your email and complete final payment for Rental Reservation ';
                $this->SendSMS($mobileno, $msg);
            }
            if($bookingstatus == 'cancelled'){
                $Date=date("F j, Y", $newDate ?: time());
                $url ="Your booking has been canceled Your Security Deposit will be refunded.";
                $result = $this->sendBookingEmailsNew($ID, 'cancellation', 'client', $_POST['email'],$_POST['phone'],$Date,$_POST['location'],$_POST['Starttime'],$_POST['Endtime'],$_POST['Hours'],$_POST['address_1'],$url,$invoiceid);
                $msg = 'Houston Durga Bari: Your Rental Booking Number is ' . $Bookinno . ' for ' . $location . ' on ' . $Date . '  Durga Bari has been canceled your rental reservation booking. Your Security Deposit will be refunded';
                $this->SendSMS($mobileno, $msg);
            }
            
            // if($bookingstatus == 'pending'){
            //   $newDate =  $_POST['date'];
            //     $Date=date("F j, Y",$newDate);
            //     $url ="Your booking has been pending";
            //     $_POST['email'] = "varunkumar953685@gmail.com" ;
            //     $_POST['phone'] = 9536855214;
            //     $result = $this->sendBookingEmailsNew($ID, 'pending', 'client', $_POST['email'],$_POST['phone'],$Date,$_POST['location'],$_POST['Starttime'],$_POST['Endtime'],$_POST['Hours'],$_POST['address_1'],$url,$invoiceid);
            //     $msg = 'Houston Durga Bari: Your Rental Booking Number is ' . $Bookinno . ' for ' . $location . ' on ' . $Date . '  Durga Bari has been canceled your rental reservation booking. Your Security Deposit will be refunded';
            //     // $this->SendSMS($mobileno, $msg);
            // }
            
            $id = $RentalBookingModel->update(array_merge($data, $_POST));
            $arr1 = $RentalBookingSlotModel->getAllBookingSlotData($ID);
            $_POST['id'] = $arr1['id'];
            $RentalBookingSlotModel->update($_POST);
            // $RentalBookingSlotModel->deleteFrom($RentalBookingSlotModel->getTable())
            //         ->where(array('booking_id' => $_POST['id']))->execute();

            

            if (!empty($id)) {
                $_SESSION['status'] = 14;
            } else {
                $_SESSION['status'] = 15;
            }
            Util::redirect(INSTALL_URL . "RentalBooking/index");
           

        }
        $id = $_GET['id'] ?? '';
        $arr = $RentalBookingModel->get($id);
       
        $this->tpl['booking'] = $arr;
        //$opts = array();
        // if ($this->isEditor()) {
        //     $opts['user_id'] = $this->getUserId();
        // }
        // $this->tpl['calendars'] = $CalendarModel->getI18nAll($opts);

        // unset($_SESSION[$this->default_product]['admin']);

        // GzObject::loadFiles('Model', array('TimePrice'));
        // $TimePriceModel = new TimePriceModel();

        // $opts = array();

        // $opts['calendar_id'] = $this->tpl['booking']['calendar_id'];
        // $working_times = $TimePriceModel->getAll($opts, 'id');

        // if (!empty($working_times)) {
        //     $this->tpl['working_time'] = $working_times[0];
        // }
        
        // $opts = array();
        // $opts['calendar_id'] = $this->tpl['booking']['calendar_id'];
        // $custom_dates = $CustomDateModel->getAll($opts);
        
        // if (!empty($custom_dates)) {
        //     foreach ($custom_dates as $k => $v) {
        //         for($i = $v['timestamp']; $i <= $v['timestamp_end']; $i+=86400){
        //             $this->tpl['custom_dates'][mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
        //         }
        //     }
        // }

         $opts = array();
         $opts['booking_id'] = $id;

         $arr1 = $RentalBookingSlotModel->getAllBookingSlotData($id);
        $this->tpl['bookingslot'] = $arr1;
        //  $arr1 = $RentalBookingSlotModel->getAll($opts);
        //  $this->tpl['bookingslot'] = $arr1;
        // foreach ($arr as $key => $value) {
        //     $_SESSION[$this->default_product]['admin']['slots'][$this->tpl['booking']['calendar_id']][$value['timestamp']] = $value['count'];
        // }
    }
    function index() {
        GzObject::loadFiles('Model', array('RentalBooking', 'Calendar','RentalLocationPriceDetails', 'rentaladvancepayment'));
        $RentalBookingModel = new RentalBookingModel();
        $CalendarModel = new CalendarModel();
        $RentalLocationPriceDetailsModel = new RentalLocationPriceDetailsModel();
        $rentaladvancepaymentModel = new rentaladvancepaymentModel();

         $opts = array();

        if (!empty($_POST['status'])) {
            $opts['status = :status'] = array(':status' => ($_POST['status'] ?? ''));
        }
        if (!empty($_POST['first_name'])) {
            $opts['first_name LIKE :first_name'] = array(':first_name' => "%" . ($_POST['first_name'] ?? '') . "%");
        }
        if (!empty($_POST['second_name'])) {
            $opts['second_name LIKE :second_name'] = array(':second_name' => "%" . ($_POST['second_name'] ?? '') . "%");
        }
        if (!empty($_POST['email'])) {
            $opts['email LIKE :email'] = array(':email' => "%" . ($_POST['email'] ?? '') . "%");
        }
        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }
        if(!empty($_GET['today'])){
            $opts['t1.date = :date'] = array(':date' => strtotime(date("Y-m-d")));
        }
        if(!empty($_GET['week'])){
            $opts['t1.date BETWEEN :date1 AND :date2'] = array(':date1' => strtotime('last Monday', time()),':date2' => (strtotime('next Sunday', time()) + 86400 ));
        }
        if(!empty($_POST['calendar_id'])){
            $opts['t1.calendar_id = :calendar_id'] = array(':calendar_id' => ($_POST['calendar_id'] ?? ''));
        }
        if (!empty($_POST['booking_number'])) {
            $opts['booking_number LIKE :booking_number'] = array(':booking_number' => "%" . ($_POST['booking_number'] ?? '') . "%");
        }

        if (!empty($_POST['location'])) {
            $opts['location LIKE :location'] = array(':location' => "%" . ($_POST['location'] ?? '') . "%");
        }
        
       $opts = array();
        // $RentalBookingarr = $RentalLocationPriceDetailsModel->getAll($opts);
        $RentalBookingarr = $RentalBookingModel->getRentalBookingWithSlot($opts);
        $this->tpl['arr'] = $RentalBookingarr;
        if ($this->isEditor()) {
            $opts['user_id'] = $this->getUserId();
        }

       
         //$opts = array();
       // $RentalBookingarr = $RentalLocationPriceDetailsModel->getAll($opts);
       // $this->tpl['RentalBookingarr'] = $RentalBookingarr;

        $opts = array();
        $Rentallocationpricearr  = $RentalLocationPriceDetailsModel->getAll($opts);
        $this->tpl['Rentallocationpricearr'] = $Rentallocationpricearr;

        $opts = array();
        $advanceamountarr = $rentaladvancepaymentModel->getAll($opts);
        $this->tpl['advanceamountarr'] = $advanceamountarr;
}

    function delete() {
        $this->isAjax = true;
        $id = $_REQUEST['id'] ?? '';
          $cat = $_REQUEST['cat'] ?? '';
        GzObject::loadFiles('Model', array('RentalBooking', 'RentalBookingSlot','RentalLocationPriceDetails'));
        $RentalBookingModel = new RentalBookingModel();
        $RentalBookingSlotModel = new RentalBookingSlotModel();
        $RentalLocationPriceDetailsModel = new RentalLocationPriceDetailsModel();

            
     if($cat == 1){
        $RentalBookingSlotModel->deleteFrom($RentalBookingSlotModel->getTable())
                ->where('booking_id', $id)->execute();
        $RentalBookingModel->deleteFrom($RentalBookingModel->getTable())
                ->where('id', $id)->execute();
      }elseif($cat == 2){
     $RentalLocationPriceDetailsModel->deleteFrom($RentalLocationPriceDetailsModel->getTable())
                ->where('id', $id)->execute();
      }
        ///$this->index();
        Util::redirect(INSTALL_URL . "RentalBooking/index");
    }

    function deleteSelected() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('RentalBooking', 'RentalBookingSlot'));
        $RentalBookingModel = new RentalBookingModel();
        $RentalBookingSlotModel = new RentalBookingSlotModel();

        if (!empty($_POST['mark'])) {
            $RentalBookingModel->deleteFrom($RentalBookingModel->getTable())
                    ->where('id', $_POST['mark'])->execute();

            $RentalBookingSlotModel->deleteFrom($RentalBookingSlotModel->getTable())
                    ->where('booking_id', $_POST['mark'])->execute();
        }

        $this->index();
    }

    function calculatePrice() {
        $this->isAjax = true;

        $post = $_POST;

        $price = array('calendars_price' => 0, 'discount' => 0, 'total' => 0, 'tax' => 0, 'security' => 0, 'deposit' => 0);
        $calendarId = $_REQUEST['calendar_id'] ?? '';
        $price = $this->calclateBookingPrice($post, $_SESSION[$this->default_product]['admin']['slots'][$calendarId] ?? []);

        header("Content-Type: application/json", true);
        echo json_encode($price);
    }

    function send_29_oct_2025() {

        GzObject::loadFiles('Model', array('Option', 'RentalBooking', 'Invoice'));
        $OptionModel = new OptionModel();
        $RentalBookingModel = new RentalBookingModel();
        $InvoiceModel = new InvoiceModel();
        $option_arr = $OptionModel->getAllPairValues();

        $opts = array();
       $opts['booking_id'] = $_GET['id'] ?? '';
       // $opts['booking_id'] = $_GET['booking_number'];
        $invoice = $InvoiceModel->getAll($opts, 'id desc');

        $booking_details = $RentalBookingModel->getBookingDetails($_GET['id'] ?? '');

        if (!empty($_POST['send_email'])) {

            try {
                $mail = new PHPMailer(true); //New instance, with exceptions enabled
                //$mail->IsSendmail();  // tell the class to use Sendmail
                $mail->AddReplyTo($option_arr['notify_email'], "Admin");
                $mail->From = $option_arr['notify_email'];
                $mail->FromName = $option_arr['notify_email'];
                $mail->AddAddress($booking_details['email']);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = $_POST['subject'] ?? '';
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                $mail->WordWrap = 80; // set word wrap
                $mail->MsgHTML($_POST['message'] ?? '');
                if (!empty($invoice)) {
                    $invoice_id = $invoice[0]['id'];
                    if (is_file(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . $id . '_invoice_' . $invoice_id . '.pdf')) {
                        $mail->AddAttachment(INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . ($_GET['id'] ?? '') . '_invoice_' . $invoice_id . '.pdf'); // attachment
                    }
                }
                $mail->IsHTML(true); // send as HTML
                $mail->Send();
            } catch (PHPMailerException $e) {
                //echo $e->errorMessage();
            }

            $_SESSION['status'] = '28';

            Util::redirect(INSTALL_URL . "RentalBooking/index");
        }

        $replacement = array();
        $replacement['id'] = $booking_details['id'];
        //$replacement['id'] = $booking_details['booking_number'];
        $replacement['location'] = $booking_details['location'];
       
        $replacement['first_name'] = $booking_details['first_name'];
        $replacement['second_name'] = $booking_details['second_name'];
        $replacement['phone'] = $booking_details['phone'];
        $replacement['email'] = $booking_details['email'];
       // $replacement['company'] = $booking_details['company'];
          $replacement['company'] = $booking_details['transaction_id'];
        $replacement['address_1'] = $booking_details['address_1'];
        $replacement['address_2'] = $booking_details['address_2'];
        $replacement['city'] = $booking_details['city'];
        $replacement['state'] = $booking_details['state'];
        $replacement['zip'] = $booking_details['zip'];
        $replacement['country'] = $booking_details['country'];
        $replacement['fax'] = $booking_details['fax'];
        $replacement['male'] = $booking_details['male'];
        $replacement['additional'] = $booking_details['additional'];
        $replacement['calendars'] = $booking_details['calendar'];
        $replacement['cc_type'] = $booking_details['cc_type'];
        $replacement['cc_num'] = $booking_details['cc_num'];
        $replacement['cc_code'] = $booking_details['cc_code'];
        $replacement['cc_exp_month'] = $booking_details['cc_exp_month'];
        $replacement['cc_exp_year'] = $booking_details['cc_exp_year'];
        $location_arr = __('location_arr');
        $replacement['location'] = $location_arr[$booking_details['location']];
        $replacement['title'] = $booking_details['promo_code'];
        $replacement['transaction_id'] = $booking_details['transaction_id'];
        $payment_method = __('payment_method_arr');
        
        $replacement['payment_method'] = $payment_method[$booking_details['payment_method']];
        $replacement['deposit'] = $booking_details['deposit'];
        $replacement['tax'] = $booking_details['booking_number'];
        $replacement['total'] = $booking_details['total'];
        $replacement['calendars_price'] = $booking_details['calendars_price'];
        $replacement['discount'] = $booking_details['discount'];
        $replacement['slots'] = implode(', ', $booking_details['slots']);

        switch ($booking_details['status']) {
            case 'pending':
                $client_message = Util::replaceToken($option_arr['client_create_email_booking'], $replacement);
                $client_subjetc = $option_arr['client_create_subject_booking'];
                $client_to = $booking_details['email'];

                $admin_message = Util::replaceToken($option_arr['admin_create_email_booking'], $replacement);
                $admin_subjetc = $option_arr['admin_create_subject_booking'];
                $admin_to = $option_arr['notify_email'];

                break;
            case 'confirmed':
                $client_message = Util::replaceToken($option_arr['client_confirmation_email_booking'], $replacement);
                $client_subjetc = $option_arr['client_confirmation_subject_booking'];
                $client_to = $booking_details['email'];

                $admin_message = Util::replaceToken($option_arr['admin_confirmation_email_booking'], $replacement);
                $admin_subjetc = $option_arr['admin_confirmation_subject_booking'];
                $admin_to = $option_arr['notify_email'];

                break;
            case 'cancelled':
                $client_message = Util::replaceToken($option_arr['client_cancellation_email_booking'], $replacement);
                $client_subjetc = $option_arr['client_cancellation_subject_booking'];
                $client_to = $booking_details['email'];

                $admin_message = Util::replaceToken($option_arr['admin_cancellation_email_booking'], $replacement);
                $admin_subjetc = $option_arr['admin_cancellation_subject_booking'];
                $admin_to = $option_arr['notify_email'];

                break;
        }

        $this->tpl['message'] = $client_message;
        $this->tpl['subjetc'] = $client_subjetc;
    }
    
    function send() {
    // ---------- MODEL SETUP ----------
    GzObject::loadFiles('Model', array('Option', 'RentalBooking', 'Invoice'));
    $OptionModel = new OptionModel();
    $RentalBookingModel = new RentalBookingModel();
    $InvoiceModel = new InvoiceModel();
    $option_arr = $OptionModel->getAllPairValues();

    $opts = array();
    $opts['booking_id'] = $_GET['id'] ?? '';
    $invoice = $InvoiceModel->getAll($opts, 'id desc');
    $booking_details = $RentalBookingModel->getBookingDetails($_GET['id'] ?? '');

    // ---------- LOGGING SETUP ----------
    // $logDir = APP_PATH . DIRECTORY_SEPARATOR . 'logs';
    $logDir = __DIR__ . '/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }

   
     $logFile = $logDir . '/mail_debug.txt';

    $log = function ($msg) use ($logFile) {
        $timestamp = date('Y-m-d H:i:s');
        $entry = "[$timestamp] $msg" . PHP_EOL;

        // Safe file write with locking (important for shared hosting)
        $fp = fopen($logFile, 'a');
        if ($fp) {
            flock($fp, LOCK_EX);
            fwrite($fp, $entry);
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    };

    // ---------- START LOGGING ----------
    // $log(str_repeat('-', 80));
    // $log("Mail process started for Booking ID: " . ($_GET['id'] ?? '' ?? 'UNKNOWN'));
    // $log("Booking details: " . print_r($booking_details, true));
    // $log("POST data: " . print_r($_POST, true));

    try {
        if (!empty($_POST['send_email'])) {
            $log("Send Email Request Detected");

            $mail = new PHPMailer(true);

            $log("PHPMailer Initialized");

            try {
                $mail->AddReplyTo($option_arr['notify_email'], "Admin");
                $mail->From = $option_arr['notify_email'];
                $mail->FromName = $option_arr['notify_email'];
                $mail->AddAddress($booking_details['email']);
                $mail->AddCC('rental@durgabari.org');
                $mail->AddBCC('varun.kumar@eicetechnology.com');
                $mail->CharSet = 'UTF-8';
                $mail->Subject = $_POST['subject'] ?? '';
                $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
                $mail->WordWrap = 80;
                $mail->MsgHTML($_POST['message'] ?? '');

                $log("Mail Configured: To={$booking_details['email']}, From={$option_arr['notify_email']}, Subject={$_POST['subject']}");
                
                
                // chech mail body
                // $log("Message Preview: " . substr(strip_tags($_POST['message']), 0, 200));

                // ---------- ATTACHMENT CHECK ----------
                if (!empty($invoice)) {
                    $invoice_id = $invoice[0]['id'];
                    $invoicePath = INSTALL_PATH . UPLOAD_PATH . 'invoice/' . 'booking_' . ($_GET['id'] ?? '') . '_invoice_' . $invoice_id . '.pdf';

                    if (is_file($invoicePath)) {
                        $mail->AddAttachment($invoicePath);
                        $log("Attachment Found and Added: $invoicePath");
                    } else {
                        $log("⚠️ Attachment Missing: $invoicePath");
                    }
                } else {
                    $log("ℹ️ No invoice data found for booking ID: " . ($_GET['id'] ?? ''));
                }

                // ---------- SEND EMAIL ----------
                $mail->IsHTML(true);
                if ($mail->Send()) {
                    $log("✅ Mail Sent Successfully to {$booking_details['email']}");
                } else {
                    $log("❌ Mail Sending Failed. PHPMailer Error: " . $mail->ErrorInfo);
                }

            } catch (PHPMailerException $e) {
                $log("🚨 PHPMailer Exception: " . $e->errorMessage());
            } catch (Exception $e) {
                $log("🚨 General Exception: " . $e->getMessage());
            }

            $_SESSION['status'] = '28';
            $log("Session status set to 28. Redirecting to RentalBooking/index");
            Util::redirect(INSTALL_URL . "RentalBooking/index");
        }

        // ---------- TEMPLATE DATA ----------
        $rawBookingDate = $booking_details['date'] ?? '';
        $replacement = array(
            'id' => $booking_details['id'],
            'location' => $booking_details['location'],
            'first_name' => $booking_details['first_name'],
            'second_name' => $booking_details['second_name'],
            'phone' => $booking_details['phone'],
            'email' => $booking_details['email'],
            'company' => $booking_details['transaction_id'],
            'address_1' => $booking_details['address_1'] ?? null,
            'address_2' => $booking_details['address_2'] ?? null,
            'city' => $booking_details['city'] ?? null,
            'state' => $booking_details['state'] ?? null,
            'zip' => $booking_details['zip'] ?? null,
            'country' => $booking_details['country'] ?? null,
            'fax' => $booking_details['fax'] ?? null,
            'male' => $booking_details['male'] ?? null,
            'additional' => $booking_details['additional'] ?? null,
            'nights' => $booking_details['nights'] ?? null,
            'date_from' => $booking_details['date_from'] ?? null,
            'date_to' => $booking_details['date_to'] ?? null,
            'calendars' => $booking_details['calendar'] ?? null,
            'cc_type' => $booking_details['cc_type'] ?? null,
            'cc_num' => $booking_details['cc_num'] ?? null,
            'cc_code' => $booking_details['cc_code'] ?? null,
            'cc_exp_month' => $booking_details['cc_exp_month'] ?? null,
            'cc_exp_year' => $booking_details['cc_exp_year'] ?? null,
            'payment_method' => __('payment_method_arr')[$booking_details['payment_method'] ?? ''] ?? '',
            'deposit' => $booking_details['deposit'] ?? null,
            'tax' => $booking_details['booking_number'] ?? null,
            'total' => $booking_details['total'] ?? null,
            'calendars_price' => $booking_details['calendars_price'] ?? null,
            'extra_price' => $booking_details['extra_price'] ?? null,
            'discount' => $booking_details['discount'] ?? null,
            'title' => $booking_details['promo_code'] ?? null,
            'location' => __('location_arr')[$booking_details['location'] ?? ''] ?? ($booking_details['location'] ?? null),
            'transaction_id' => $booking_details['transaction_id'] ?? null,
            'slots' => implode(', ', $booking_details['slots'] ?? []),
            'create_date' => date($this->tpl['option_arr_values']['date_format'], is_numeric($rawBookingDate) ? (int)$rawBookingDate : (strtotime($rawBookingDate) ?: time()))
        );

        // ---------- EMAIL TEMPLATE SELECTION ----------
        $log("Preparing Email Templates based on Booking Status: {$booking_details['status']}");

        switch ($booking_details['status']) {
            case 'pending':
                $client_message = Util::replaceToken($option_arr['client_create_email_booking'], $replacement);
                $client_subjetc = $option_arr['client_create_subject_booking'];
                $log("📩 Pending Booking: Client Subject: $client_subjetc");
                break;

            case 'confirmed':
                $client_message = Util::replaceToken($option_arr['client_confirmation_email_booking'], $replacement);
                $client_subjetc = $option_arr['client_confirmation_subject_booking'];
                $log("📩 Confirmed Booking: Client Subject: $client_subjetc");
                break;

            case 'cancelled':
                $client_message = Util::replaceToken($option_arr['client_cancellation_email_booking'], $replacement);
                $client_subjetc = $option_arr['client_cancellation_subject_booking'];
                $log("📩 Cancelled Booking: Client Subject: $client_subjetc");
                break;

            default:
                $log("⚠️ Unknown booking status: {$booking_details['status']}");
                $client_message = '';
                $client_subjetc = '';
        }

        $this->tpl['message'] = $client_message;
        $this->tpl['subjetc'] = $client_subjetc;

    } catch (Throwable $t) {
        $log("💥 Fatal Error in send() function: " . $t->getMessage());
    }

    $log("Mail process ended for Booking ID: " . ($_GET['id'] ?? '' ?? 'UNKNOWN'));
    $log(str_repeat('-', 80) . PHP_EOL);
}

    function export() {

        $this->isAjax = true;

        GzObject::loadFiles('Model', array('RentalBooking', 'RentalBookingSlot'));
        $RentalBookingModel = new RentalBookingModel();
        $RentalBookingSlotModel = new RentalBookingSlotModel();

        $output = "";

        $query = $RentalBookingModel->from($RentalBookingModel->getTable());

        $bookings = $query->fetchAll();

        $query = $RentalBookingModel->from($RentalBookingSlotModel->getTable());

        $slots = $query->fetchAll();

        if (empty($bookings)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

        foreach ($bookings[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        
        foreach ($slots[0] as $k => $v) {
            if($k != 'id' && $k != 'calendar_id' && $k != 'booking_id'){
                $output .= '"' . $k . '",';
            }
        }
        $output .="\n";

        foreach ($bookings as $key => $value) {
            
            $opts = array();
            $opts['booking_id'] = $value['id'];
            $slots = $RentalBookingSlotModel->getAll($opts);
            
            foreach ($value as $k => $v) {
                if($k == 'date'){
                    $output .='"' . date("Y-m-d H:i", $v) . '",';
                }else{
                    $output .='"' . $v . '",';
                }
            }
            foreach($slots as $slot){
                foreach($slot as $k => $s){
                    if($k != 'id' && $k != 'calendar_id' && $k != 'booking_id'){
                        if($k == 'timestamp'){
                            $output .='"' . date("Y-m-d H:i", $s) . '",';
                        }else{
                            $output .='"' . $s . '",';
                        }
                    }
                }
            }
            $output .="\n";
        }

        $filename = "Rentalbooking_" . time() . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }

    function import() {

        if (!empty($_POST['import'])) {

            if (!empty($_FILES['csv_file'])) {

                $filename = time() . '_' . $_FILES['csv_file']['name'];

                $path = INSTALL_PATH . UPLOAD_PATH . 'csv/' . $filename;

                $this->tpl['booking_arr'] = array();

                if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $path)) {

                    $row = 0;
                    if (($handle = fopen($path, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ",", '"', '\\')) !== FALSE) {
                            $num = count($data);
                            if (!empty($num) && $num > 1 && !empty($data)) {
                                if ($data[0] != 'id') {
                                    $row++;

                                    $this->tpl['booking_arr'][$row] = array();

                                    for ($c = 0; $c < $num; $c++) {
                                        $this->tpl['booking_arr'][$row][] = $data[$c];
                                    }
                                } else {
                                    continue;
                                }
                            }
                        }
                        fclose($handle);
                    }
                    $this->tpl['row_count'] = $row;
                }
                
            }
        } elseif (!empty($_POST['save'])) {

            if (!empty($_POST['calendar_id'])) {

                GzObject::loadFiles('Model', array('RentalBooking', 'RentalBookingSlot'));
                $RentalBookingModel = new RentalBookingModel();
                $RentalBookingSlotModel = new RentalBookingSlotModel();

                foreach (($_POST['id'] ?? []) as $k => $v) {
                    $data = array();

                    $data['calendar_id'] = $_POST['calendar_id'][$k];
                    $data['booking_number'] = $_POST['booking_number'][$k];
                    $data['title'] = $_POST['title'][$k];
                    $data['first_name'] = $_POST['first_name'][$k];
                    $data['second_name'] = $_POST['second_name'][$k];
                    $data['phone'] = $_POST['phone'][$k];
                    $data['email'] = $_POST['email'][$k];
                    $data['company'] = $_POST['company'][$k];
                    $data['address_1'] = $_POST['address_1'][$k];
                    $data['address_2'] = $_POST['address_2'][$k];
                    $data['state'] = $_POST['state'][$k];
                    $data['city'] = $_POST['city'][$k];
                    $data['zip'] = $_POST['zip'][$k];
                    $data['country'] = $_POST['country'][$k];
                    $data['fax'] = $_POST['fax'][$k];
                    $data['male'] = $_POST['male'][$k];
                    $data['additional'] = $_POST['additional'][$k];
                    $data['promo_code'] = $_POST['promo_code'][$k];
                    $data['status'] = $_POST['status'][$k];
                    $data['calendars_price'] = $_POST['calendars_price'][$k];
                    $data['amount'] = $_POST['amount'][$k];
                    $data['discount'] = $_POST['discount'][$k];
                    $data['total'] = $_POST['total'][$k];
                    $data['tax'] = $_POST['tax'][$k];
                    $data['security'] = $_POST['security'][$k];
                    $data['payment_method'] = $_POST['payment_method'][$k];
                    $data['cc_type'] = $_POST['cc_type'][$k];
                    $data['cc_num'] = $_POST['cc_num'][$k];
                    $data['cc_code'] = $_POST['cc_code'][$k];
                    $data['cc_exp_month'] = $_POST['cc_exp_month'][$k];
                    $data['cc_exp_year'] = $_POST['cc_exp_year'][$k];
                    $data['date'] = strtotime($_POST['date'][$k]);

                    $id = $RentalBookingModel->save($data);
                    
                    if(!empty($_POST['timestamp'][$v])){
                        foreach (($_POST['timestamp'][$v] ?? []) as $key => $value) {
                            $data = array();
                            $data['calendar_id'] = $_POST['calendar_id'][$k];
                            $data['booking_id'] = $id;
                            $data['timestamp'] = strtotime($value);
                            $data['count'] = $_POST['count'][$v][$key];
                            $data['timecreated'] = time();

                            $RentalBookingSlotModel->save($data);
                        }
                    }
                }
                $status = 30;
                $_SESSION['status'] = $status;
                
                Util::redirect(INSTALL_URL . "RentalBooking/index");
            }
        }
    }

    function getSlots() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('TimePrice', 'BookingSlot', 'CustomDate', 'CustomDate', 'Booking'));
        $TimePriceModel = new TimePriceModel();
        $BookingSlotModel = new BookingSlotModel();
        $CustomDateModel = new CustomDateModel();
        $BookingModel = new BookingModel();
        
        $date = Util::dateToTimestamp($this->tpl['option_arr_values']['date_format'], $_POST['date']);
        
        $opts = array();
        $opts[':timestamp BETWEEN timestamp AND timestamp_end AND calendar_id = :calendar_id'] = array(':timestamp' => $date, ':calendar_id' => ($_POST['calendar_id'] ?? ''));
        $custom_dates = $CustomDateModel->getAll($opts);
        
        if (!empty($custom_dates[0])) {
            $this->tpl['custom_dates'] = $custom_dates[0];
        }

        $opts = array();
        $opts['calendar_id'] = $_POST['calendar_id'] ?? '';
        $working_times = $TimePriceModel->getAll($opts, 'id');
        
        $from = $date - 86400;
        $to = $date + 86400;
        
        $before = time() - 5 * 60;
        
        $sql = "SELECT * FROM " . $BookingSlotModel->getTable() . " as t1 LEFT JOIN  " . $BookingModel->getTable() . " as t2 ON t1.booking_id = t2.id WHERE (t2.status = 'confirmed' OR (t2.status = 'pending' AND t2.created >= " . $before . " )) AND t1.timestamp BETWEEN " . $from . "  AND " . $to . " AND t1.calendar_id = " . ($_POST['calendar_id'] ?? '') . " ";
        $booked_slots = $BookingSlotModel->execute($sql);

        $this->tpl['booked_slots'] = array();
        
        if (!empty($booked_slots)) {
            foreach ($booked_slots as $key => $value) {
                if (!empty($this->tpl['booked_slots'][$value['timestamp']])) {
                    $this->tpl['booked_slots'][$value['timestamp']] += $value['count'];
                } else {
                    $this->tpl['booked_slots'][$value['timestamp']] = $value['count'];
                }
            }
        }
        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }
    }

    function removeTimeSlot() {
        $this->isAjax = true;

        unset($_SESSION[$this->default_product]['admin']['slots'][$_REQUEST['cid'] ?? ''][$_POST['slot'] ?? '']);
    }

    function addTimeSlot() {
        $this->isAjax = true;

        $_SESSION[$this->default_product]['admin']['slots'][$_REQUEST['cid'] ?? ''][$_POST['slot'] ?? ''] = $_POST['count'] ?? '';
    }

    function getSlotsTable() {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('TimePrice', 'CustomDate'));
        $TimePriceModel = new TimePriceModel();
        $CustomDateModel = new CustomDateModel();
        
        $opts = array();
        $opts['calendar_id'] = $_POST['calendar_id'] ?? '';
        $custom_dates = $CustomDateModel->getAll($opts);
        
        if (!empty($custom_dates)) {
            foreach ($custom_dates as $k => $v) {
                for($i = $v['timestamp']; $i <= $v['timestamp_end']; $i+=86400){
                    $this->tpl['custom_dates'][mktime(0, 0, 0, date('n', $i), date('d', $i), date('Y', $i))] = $v;
                }
            }
        }

        $opts = array();

        $opts['calendar_id'] = $_POST['calendar_id'] ?? '';
        $working_times = $TimePriceModel->getAll($opts, 'id');

        if (!empty($working_times)) {
            $this->tpl['working_time'] = $working_times[0];
        }
    }


    function categoryimport()
    {
        if (!empty($_POST['import'])) {
            if (!empty($_FILES['csv_file'])) {
                $filename = time() . '_' . $_FILES['csv_file']['name'];

                $path = INSTALL_PATH . UPLOAD_PATH . 'csv/' . $filename;

                $this->tpl['categoryarr'] = array();

                if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $path)) {
                    $row = 0;
                    if (($handle = fopen($path, "r")) !== false) {
                        while (($data = fgetcsv($handle, 1000, ",", '"', '\\')) !== false) {
                            $num = count($data);
                            if (!empty($num) && $num > 1 && !empty($data)) {
                                if ($data[0] != 'id') {
                                    $row++;
                                     //if($row == 1 ){
                                        //continue;
                                           // }
                                    $this->tpl['categoryarr'][$row] = array();

                                    for ($c = 0; $c < $num; $c++) {
                                        $this->tpl['categoryarr'][$row][] = $data[$c];
                                    }
                                } else {
                                    continue;
                                }
                            }
                        }
                        fclose($handle);
                    }
                    $this->tpl['row_count'] = $row;
                }
            }
        } elseif (!empty($_POST['save'])) {
            if (!empty($_POST['id'])) {
                GzObject::loadFiles('Model', array('Category'));
                $CategoryModel = new CategoryModel();
              
                foreach (($_POST['id'] ?? []) as $k => $v) {
                    $data = array();

                    $data['id'] = $data[' '] = $_POST['id'][$k];
                    $data['category'] = $_POST['category'][$k];

                    $id = $CategoryModel->save($data);

                    // if(!empty($_POST['timestamp'][$v])){
                    //     foreach (($_POST['timestamp'][$v] ?? []) as $key => $value) {
                    //         $data = array();
                    //         $data['calendar_id'] = $_POST['calendar_id'][$k];
                    //         $data['booking_id'] = $id;
                    //         $data['timestamp'] = strtotime($value);
                    //         $data['count'] = $_POST['count'][$v][$key];
                    //         $data['timecreated'] = time();

                    //         $BookingSlotModel->save($data);
                    //     }
                    // }
                }
                $status = 30;
                $_SESSION['status'] = $status;

                Util::redirect(INSTALL_URL . "RentalBooking/categoryitemindex");
            }
        }

    }
    
    function categoryexport()
    {
        $this->isAjax = true;

        GzObject::loadFiles('Model', array('Category'));
        $CategoryModel = new CategoryModel();

        $output = "";

        $query = $CategoryModel->from($CategoryModel->getTable());


        $members = $query->fetchAll();

        if (empty($members)) { header('Content-Type: text/html; charset=utf-8'); echo 'No data to export.'; exit; }

        foreach ($members[0] as $k => $v) {
            $output .= '"' . $k . '",';
        }
        $output .= "\n";

        foreach ($members as $key => $value) {

            $opts = array();
            $opts['member_id'] = $value['id'];
            $slots = $CategoryModel->getAll($opts);

            foreach ($value as $k => $v) {
                if ($k == 'date') {
                    $output .= '"' . date("Y-m-d H:i", $v) . '",';
                } else {
                    $output .= '"' . $v . '",';
                }
            }
            // foreach($slots as $slot){
            //     foreach($slot as $k => $s){
            //         if($k != 'id' && $k != 'calendar_id' && $k != 'booking_id'){
            //             if($k == 'timestamp'){
            //                 $output .='"' . date("Y-m-d H:i", $s) . '",';
            //             }else{
            //                 $output .='"' . $s . '",';
            //             }
            //         }
            //     }
            // }
            $output .= "\n";
        }

        $filename = "category_" . time() . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        echo $output;
        exit;
    }
function itemsimport() {
        if (!empty($_POST['import'])) {
            if (!empty($_FILES['csv_file'])) {
                $filename = time() . '_' . $_FILES['csv_file']['name'];
    
                $path = INSTALL_PATH . UPLOAD_PATH . 'csv/' . $filename;
    
                $this->tpl['Itemsarr'] = array();
    
                if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $path)) {
                    $row = 0;
                    if (($handle = fopen($path, "r")) !== false) {
                        while (($data = fgetcsv($handle, 1000, ",", '"', '\\')) !== false) {
                            $num = count($data);
                            if (!empty($num) && $num > 1 && !empty($data)) {
                                if ($data[0] != 'id') {
                                    $row++;
                                   // if($row == 1 ){
                                    //     continue;
                                    //        }
                                    $this->tpl['Itemsarr'][$row] = array();
    
                                    for ($c = 0; $c < $num; $c++) {
                                        $this->tpl['Itemsarr'][$row][] = $data[$c];
                                    }
                                } else {
                                    continue;
                                }
                            }
                        }
                        fclose($handle);
                    }
                    $this->tpl['row_count'] = $row;
                }
            }
        } elseif (!empty($_POST['save'])) {
            if (!empty($_POST['id'])) {
                GzObject::loadFiles('Model', array('Items'));
                $ItemsModel = new ItemsModel();
                // $BookingSlotModel = new BookingSlotModel();
    
                foreach (($_POST['id'] ?? []) as $k => $v) {
                    $data = array();
    
                    $data['id']=$data[' ']=$_POST['id'][$k];
                    $data['categories']=$_POST['categories'][$k];
                    $data['count']=$_POST['count'][$k];
                    $data['title']=$_POST['title'][$k];
                    $data['description']=$_POST['description'][$k];
                    $data['rent_by_hour']=$_POST['rent_by_hour'][$k];
                    $data['rent_by_day']=$_POST['rent_by_day'][$k];
                    $data['rent_by_week']=$_POST['rent_by_week'][$k];

                    
                    $id = $ItemsModel->save($data);
    
                    // if(!empty($_POST['timestamp'][$v])){
                        //     foreach (($_POST['timestamp'][$v] ?? []) as $key => $value) {
                        //         $data = array();
                        //         $data['calendar_id'] = $_POST['calendar_id'][$k];
                        //         $data['booking_id'] = $id;
                        //         $data['timestamp'] = strtotime($value);
                        //         $data['count'] = $_POST['count'][$v][$key];
                        //         $data['timecreated'] = time();
    
                        //         $BookingSlotModel->save($data);
                        //     }
                    // }
                }
                $status = 30;
                $_SESSION['status'] = $status;
    
                Util::redirect(INSTALL_URL . "RentalBooking/categoryitemindex");
            }
        }
    }

}

?>


