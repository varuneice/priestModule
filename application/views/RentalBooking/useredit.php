<style>
    .profile {
    margin-left: 50%;
    border-radius: 25%;
    transform: translate(-50%);
    filter: brightness(94%);
    padding: 10px;
    height: 166px;
}
    </style>
 <?php
$bookingDefaults = [
    'booking_number' => '',
    'payment_method' => '',
    'cc_type' => '',
    'cc_exp_month' => '',
    'cc_exp_year' => '',
    'calendar_id' => '',
    'status' => '',
    'title' => '',
    'alcoholic_beverage' => '',
];
$bookingDetailsDefaults = [
    'location' => '',
    'finalDate' => '',
    'booking_number' => '',
    'oid' => '',
    'Member_id' => '',
    'first_name' => '',
    'second_name' => '',
    'email' => '',
    'phone' => '',
    'total' => '',
    'address_1' => '',
    'status' => '',
];
$tpl['booking'] = array_merge($bookingDefaults, is_array($tpl['booking'] ?? null) ? $tpl['booking'] : []);
$tpl['booking_details'] = array_merge($bookingDetailsDefaults, is_array($tpl['booking_details'] ?? null) ? $tpl['booking_details'] : []);
$tpl['option_arr_values'] = array_merge(
    [
        'currency' => '',
        'week_first_day' => '',
        'stripe_allow' => '',
        'others_allow' => '',
        'paypal_allow' => '',
        'authorize_allow' => '',
        '2checkout_allow' => '',
        'pay_arrival_allow' => '',
        'credit_card_allow' => '',
        'bank_acount_allow' => '',
    ],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);
$tpl['bookingslot'] = is_array($tpl['bookingslot'] ?? null) ? $tpl['bookingslot'] : [];
$tpl['js_format'] = $tpl['js_format'] ?? '';
$defaultLanguageId = $this->controller->tpl['default_language']['id'] ?? null;
if (!empty($_POST['edit_booking'])) {
    ?>
    <section class="content left width_100" >
        <div class="padding-19 nav-tabs-custom left width_100">
            <?php
            if (!empty($_SESSION['status'])) {
                ?>
                <div class="alert alert-danger in">
                    <strong><?php echo $_SESSION['status']; ?></strong>
                </div>
                <?php
                unset($_SESSION['status']);
            } else {
                $starttimefinal = $_POST['Starttime'] ?? '';
                $endtimefinal = $_POST['Endtime'] ?? '';
                $prevlocation = $tpl['booking_details']['location'] ?? '';
                                if($prevlocation == 'Both'){
                                    $location = 'Auditorium & Kalabhavan';
                              }else{
                                $location = $tpl['booking_details']['location'] ?? '';
                              }
                              $previousuidate = $tpl['booking_details']['finalDate'] ?? '';
                              $timestamp = strtotime($previousuidate);
                                               $finaluidate = date("m/d/Y", $timestamp);
                if (($_POST['payment_method'] ?? '') == 'stripe') {
                    ?>
                     <table border="4" width='585px' style= "margin-left:30em;" >
                                 <tr>
                                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style="margin-left:15em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                            </tr>
                                <tr>
                                <tr><td>Booking Number</td> <td><?php echo $tpl['booking_details']['booking_number'] ?? ''; ?></td></tr>
                                <tr><td>order Id</td> <td><?php echo $tpl['booking_details']['oid'] ?? '';?></td></td></tr>
                                <tr><td>Member Id</td> <td><?php echo $tpl['booking_details']['Member_id'] ?? '';?></td></td></tr>
                                <tr><td>Customer Name</td> <td><?php echo ($tpl['booking_details']['first_name'] ?? '').' ' .($tpl['booking_details']['second_name'] ?? ''); ?></td></tr>
                                <tr><td>Customer Email Address</td> <td><?php echo $tpl['booking_details']['email'] ?? ''; ?></td></tr>
                                <tr><td>Customer Phone Number</td> <td><?php echo $tpl['booking_details']['phone'] ?? ''; ?></td></tr>
								<tr><td>Location</td> <td><?php echo $location; ?></td></tr>
                                <tr><td>Amount</td> <td><span style="color:red;">$</span><?php echo $tpl['booking_details']['total'] ?? ''; ?></td></tr>
                                <tr><td>Address</td> <td><?php echo $tpl['booking_details']['address_1'] ?? ''; ?></td></tr>
								<tr><td>Payment Method</td> <td><?php echo "Credit Card"; ?></td></tr>
                                <tr><td>Rental Date</td> <td><?php echo $finaluidate; ?></td></tr>
                                <tr><td>Start Time</td> <td><?php echo $starttimefinal; ?></td></tr>
								<tr><td>End Time</td> <td><?php echo $endtimefinal; ?></td></tr>
                                <tr><td>Hours</td> <td><?php echo ($_POST['Hours'] ?? ''). ' '. 'Hours'; ?></td></tr>
                                <tr><td>Status</td> <td><?php echo $tpl['booking_details']['status'] ?? ''; ?></td></tr>
                                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                            </tr> 
                        </table> 
                        
                    <?php
                } else if(($_POST['payment_method'] ?? '') == 'others'){
                    ?>
                     <table border="4" width='585px' style= "margin-left:26em;" >
                                 <tr>
                                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style="margin-left:14em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                            </tr>
                                <tr>
                                <tr><td>Booking Number</td> <td><?php echo $tpl['booking_details']['booking_number'] ?? ''; ?></td></tr>
                                <tr><td>order Id</td> <td><?php echo $tpl['booking_details']['oid'] ?? '';?></td></td></tr>
                                <tr><td>Member Id</td> <td><?php echo $tpl['booking_details']['Member_id'] ?? '';?></td></td></tr>
                                <tr><td>Customer Name</td> <td><?php echo ($tpl['booking_details']['first_name'] ?? '').' ' .($tpl['booking_details']['second_name'] ?? ''); ?></td></tr>
                                <tr><td>Customer Email Address</td> <td><?php echo $tpl['booking_details']['email'] ?? ''; ?></td></tr>
                                <tr><td>Customer Phone Number</td> <td><?php echo $tpl['booking_details']['phone'] ?? ''; ?></td></tr>
								<tr><td>Location</td> <td><?php echo $location; ?></td></tr>
                                <tr><td>Amount</td> <td><span style="color:red;">$</span><?php echo $tpl['booking_details']['total'] ?? ''; ?></td></tr>
                                <tr><td>Address</td> <td><?php echo $tpl['booking_details']['address_1'] ?? ''; ?></td></tr>
								<tr><td>Payment Method</td> <td><?php echo "Zelle"; ?></td></tr>
                                <tr><td>Rental Date</td> <td><?php echo $finaluidate; ?></td></tr>
                                <tr><td>Start Time</td> <td><?php echo $starttimefinal; ?></td></tr>
								<tr><td>End Time</td> <td><?php echo $endtimefinal ; ?></td></tr>
                                <tr><td>Hours</td> <td><?php echo ($_POST['Hours'] ?? ''). ' '. 'Hours'; ?></td></tr>
                                <tr><td>Status</td> <td><?php echo $tpl['booking_details']['status'] ?? ''; ?></td></tr>
                                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                            </tr> 
                        </table> 
                        
                    <?php

                } else {
                    ?>
                    <div class="alert alert-success  in">
                        <i class="fa-fw fa fa-check"></i>
                        <strong><?php echo __('success'); ?></strong>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <?php
} else {
    ?>
<section class="content-header" style="display:none;">
    <h1>
        <?php echo __('booking_header'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>RentalBooking/index"><?php echo __('booking'); ?></a></li>
        <li class="active"><?php echo __('edit_booking'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$slotID = $tpl['bookingslot']['id'] ?? '';
$regmember = $tpl['booking']['Member_id'] ?? '';
$Book_date = $tpl['booking']['date'] ?? '';
$bookDate = date("m/d/Y", is_numeric($Book_date) ? (int)$Book_date : (strtotime($Book_date) ?: time()));
?>
<form id="edit_bookingnew" class="frm-class booking-frm-class" role="form" action="<?php echo INSTALL_URL; ?>RentalBooking/useredit" method="post" name="edit_bookingnew">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
<td colspan='2'>
     <!-- <img src='<?= INSTALL_URL ?>images/logopp.png' alt='' height='167px' style="margin-left:35em;margin-top: 1em;"> -->
     <img src="<?= INSTALL_URL ?>thankyouscreen.jpg" class="profile" />
     <h2  style="text-align:center;font-family:fangsong; font-size:30px;margin-top:-10px;">HDBS Rental Payment</h2>
    </td> 
<div class="padding-19">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1"><?php echo __('pay_details'); ?></a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab_2"><?php echo __('client_details'); ?></a>
                </li>

            </ul>
            <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                    <fieldset>
                        <section class="col-lg-7 connectedSortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('booking_details'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group" style="display:none;">
                                        <label class="control-label" for="calendars_price"><?php echo __('calendars_price'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="calendars_price" class="form-control input-sm" type="text" name="calendars_price" size="25" value="<?php echo $tpl['booking']['calendars_price'] ?? ''; ?>" title="<?php echo __('calendars_price'); ?>" placeholder="calendars_price" readonly>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label" for="tax"><?php echo __('tax'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="tax" class="form-control input-sm" type="text" name="tax" size="25" value="<?php echo $tpl['booking']['tax'] ?? ''; ?>" title="tax" placeholder="tax">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="deposit"><?php echo __('deposit'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="deposit" class="form-control input-sm" type="text" name="deposit" size="25" value="<?php echo $tpl['booking']['deposit'] ?? ''; ?>" title="deposit" placeholder="deposit">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="discount"><?php echo __('discount'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="discount" class="form-control input-sm" type="text" name="discount" size="25" value="<?php echo $tpl['booking']['discount'] ?? ''; ?>" title="discount" placeholder="discount">
                                        </div>
                                    </div> -->

                                    <div class="form-group">
                                     <label class="control-label" for="bookingnumber"><?php echo __('Booking Number'); ?>:</label>    
                                     <input id="bookingnumber" class="form-control input-sm " type="text" name="booking_number" size="25" value="<?php echo $tpl['booking']['booking_number'] ?? ''; ?>" title="<?php echo __('bookingnumber'); ?>" placeholder="Booking Number" readonly>
                                    </div>

                                    <div class="form-group">
                                     <label class="control-label" for="rentalprice"><?php echo __('Rental Price'); ?>:</label>
                                     <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                     <input id="rentalprice" class="form-control input-sm" type="text" name="rentalprice" size="25" value="<?php echo $tpl['booking']['rentalprice'] ?? ''; ?>" title="<?php echo __('rentalprice'); ?>" placeholder="Rental Price" readonly>
                                     </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="advanceamount"><?php echo __('Security Deposit'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="advanceamount" class="form-control input-sm" type="text" name="advanceamount" size="25" value="<?php echo $tpl['booking']['advanceamount'] ?? ''; ?>" title="advanceamount" placeholder="Security Deposit" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display:none;">
                                        <label class="control-label" for="remaining"><?php echo __('Remaining Amount'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input  id="remainingamount" class="form-control input-sm" type="text" name="remaining" size="25" value="" title="remaining" placeholder="Remaining" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="extra_amount"><?php echo __('Extra Amount'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="extra_amount" class="form-control input-sm" type="text" name="extraamount" size="25" value="<?php echo $tpl['booking']['extraamount'] ?? ''; ?>" title="extraamount" placeholder="Extra Amount" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="total"><?php echo __('Final Payment Amount'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="total" class="form-control input-sm" type="text" name="total" size="25" value="<?php echo $tpl['booking']['total'] ?? ''; ?>" title="total" placeholder="total" readonly>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label" for="promo_code"><?php echo __('promo_code'); ?>:</label>
                                        <input id="promo_code" class="form-control input-sm" type="text" name="promo_code" size="25" title="<?php echo __('promo_code'); ?>" value="<?php echo $tpl['booking']['promo_code'] ?? ''; ?>" placeholder="">
                                    </div> -->
                                </div>
                                <div class="form-group" style="display:none;">
                                    <label class="control-label" for=""><?php echo __('Zellecode'); ?>:</label>                     
                                    <input class="form-control input-sm medium" type="text" name="zellecode" value="" id="Zellecode" />
                                 </div>
                                <fieldset class="form-actions">
                                    <input type="hidden" name="edit_booking" value="1" /> 
                                    <input type="hidden" name="id" value="<?php echo $tpl['booking']['id'] ?? ''; ?>" /> 
                                </fieldset>
                            </div>
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('payment_details'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="payment_method"><?php echo __('payment_method'); ?>:</label>
                                        <select data-rule-required="true" name="payment_method" id="payment_method" class="form-control input-sm" >
                                            <option value="">Please Select Payment Method</option>
                                            <?php
                                $payment_method_arr = __('payment_method_arr');
                                foreach ($payment_method_arr as $k => $v) {
                                    if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                        ?>
                                <option  value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                                    }
                                }
                                ?>
                                        </select>
                                    </div>
                                </div>
                                <table class="table">
                <tr id="stripe_details" class="tr" style="display: none;">
                        <td class="td" colspan="4">
                            <div class="form-group">
                                <label for="card-element">
                                    Credit or debit card
                                </label>
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display Element errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>            
                        
                        </td>
                    </tr>
                    <tr id="others_details" style="display: none;">
                        <td class="td" colspan="4">
                            <div class="form-group">
                                <label class="control-label"
                                    for="confirm_code"><?php echo __('confirm_code'); ?>:</label>
                                <input data-rule-required='true' id="confirm_code" class="form-control input-sm"
                                    type="text" name="confirm_code" size="25" value=""
                                    title="<?php echo __('confirm_code'); ?>"
                                    placeholder="<?php echo __('confirm_code'); ?>">
                                <div class="control-group"></div>
                                <div id="error_code"></div>
                            </div>
                        </td>
                    </tr>
                    <table class="table">
                    <tr class="tr"  id="MemberID1" style="display: none;" class="form-group">
                    <label class="control-label" for="F_Name" style="color:white !important;">Payment Details:</label>
                    <!-- <td  class="td" colspan="2" class="auto-widget"> -->
                    <td class="td"><button style="display: none;float:left!important;" type="button" id="checkPaymentData" >Get Zelle Payment Details</button></td>
                    <!-- <input data-rule-required='true' id="MemberID" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>"> -->
                    <td  class="td" colspan="3"><select data-rule-required='true' id="MemberID" name="oid"  class="form-control input-sm" style="font-weight: bold;float:right!important;">
                    <option value="">Please select your payment details</option>
                        <?php
                        foreach (($tpl['Amount'] ?? []) as $key => $value) {
                            ?>
                           
                            <option value="<?php echo $value['Amount']; ?>"><?php echo $value['Amount']; ?></option> 
                            <?php
                            //echo '<option value="'.$value['Amount'].'">'.$value['Amount']. '</option>';
                        }
                        ?>
                    </select>
                    </td>
                    <!-- </td> -->
                
                    </tr>
            </table>
                    <table class="table">
                    <tr>
                <td id="error_code1"></td>
                <!-- <td id="error_code"></td> -->
                <td id="error_codeimg"></td>
                     </tr>
                    </table>
                            </table>
                                
                                <fieldset class="form-actions">
                                    <input type="hidden" name="edit_booking" value="1" /> 
                                    <input type="hidden" name="id" value="<?php echo $tpl['booking']['id'] ?? ''; ?>" /> 
                                    <input type="hidden" name="slotid" value="<?php echo $slotID; ?>" /> 
                                    <input type="hidden" name="booking_number" value="<?php echo $tpl['booking']['booking_number'] ?? ''; ?>" /> 
                                    <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                                    <td><button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save" name="Payment" tabindex="17" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Payment</button></td>
                                  
                                
                                     <!--  <button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save" name="Payment" tabindex="17" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Payment</button> -->
                                
                                </fieldset>
                                
                            </div>
                           
                            <div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key'] ?? ''; ?></div>
      
                           
                            <div class="box box-solid box-primary" id="credit_card_details" style="<?php echo (($tpl['booking']['payment_method'] ?? '') != "credit_card") ? "display: none;" : ""; ?>">
                                <div class="box-header">
                                    <h3 class="box-title"><strong><?php echo __('credit_card_details'); ?></strong></h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="cc_type"><?php echo __('label_cc_type'); ?>:</label>
                                        <select title="<?php echo __('cc_type'); ?>" data-rule-required='true' name="cc_type" id="cc_type" class="form-control input-sm" >
                                            <option value="">---</option>
                                            <?php
                                            $cc_type = __('cc_type');
                                            foreach ($cc_type as $k => $v) {
                                                ?>
                                                <option   <?php echo ($tpl['booking']['cc_type'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="cc_num"><?php echo __('cc_num'); ?>:</label>
                                        <input data-rule-required='true' id="cc_num" class="form-control input-sm" type="text" name="cc_num" size="25" value="<?php echo $tpl['booking']['cc_num'] ?? ''; ?>" title="<?php echo __('cc_num'); ?>" placeholder="<?php echo __('cc_num'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="cc_code"><?php echo __('cc_code'); ?>:</label>
                                        <input data-rule-required='true' id="fax" class="form-control input-sm" type="text" name="cc_code" size="25" value="<?php echo $tpl['booking']['cc_code'] ?? ''; ?>" title="<?php echo __('cc_code'); ?>" placeholder="<?php echo __('cc_code'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="cc_exp_month"><?php echo __('cc_exp_date'); ?>:</label>
                                        <div class="input-group left width_100">
                                            <select title="<?php echo __('cc_exp_date'); ?>" data-rule-required='true' name="cc_exp_month" id="cc_exp_month" class="form-control input-sm medium left margin-right-5" >
                                                <option value="">---</option>
                                                <?php
                                                $month_arr = __('month_arr');
                                                foreach ($month_arr as $k => $v) {
                                                    ?>
                                                    <option <?php echo ($tpl['booking']['cc_exp_month'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <select title="<?php echo __('cc_exp_date'); ?>" data-rule-required='true' name="cc_exp_year" id="cc_exp_year" class="form-control input-sm medium left" >
                                                <option value="">---</option>
                                                <?php
                                                for ($v = date('Y'); $v <= date('Y') + 10; $v++) {
                                                    ?>
                                                    <option <?php echo ($tpl['booking']['cc_exp_year'] == $v) ? "selected='selected'" : ""; ?> value="<?php echo $v; ?>" ><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <fieldset class="form-actions">
                                        <input type="hidden" name="edit_booking" value="1" /> 
                                        <input type="hidden" name="id" value="<?php echo $tpl['booking']['id'] ?? ''; ?>" /> 
                                    </fieldset>
                                </div>
                            </div>
                        </section>
                        <section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('booking_details'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <!-- <div class="form-group" id="calendars-container-id">
                                        <label class="control-label" for="calendar_id"><?php echo __('calendars'); ?>:</label>
                                        <select data-rule-required="true" name="calendar_id" id="calendar_id" class="form-control input-sm" >
                                            <?php
                                            foreach (($tpl['calendars'] ?? []) as $k => $v) {
                                                ?>
                                                <option <?php echo ($tpl['booking']['calendar_id'] == $v['id']) ? "selected='selected'" : ""; ?> value="<?php echo $v['id']; ?>" ><?php echo $v['i18n'][$defaultLanguageId]['title'] ?? ($v['title'] ?? ''); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div> -->
                                    

                                    <div class="form-group">
                                    <label class="control-label" for="location"><?php echo __('Location'); ?>:</label>
                                    <input id="location" class="form-control input-sm" type="text" name="location" size="25" value="<?php echo $tpl['booking']['location'] ?? ''; ?>" title="Location" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                    <label class="control-label" for="membertype"><?php echo __('Member Type'); ?>:</label>
                                    <input id="membertype" class="form-control input-sm" type="text" name="membertype" size="25" value="" title="<?php echo __('membertype'); ?>" placeholder="" readonly>
                                    </div>
                                   
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="control-label" for="status"><?php echo __('booking_status'); ?>:</label>
                                            <!-- <select data-rule-required="true" name="status" id="status" class="form-control input-sm" >
                                                <option value="">---</option>
                                                <?php
                                                $status_arr = __('status_arr');
                                                foreach ($status_arr as $k => $v) {
                                                    ?>
                                                    <option <?php echo ($tpl['booking']['status'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?> 
                                            </select>-->
                                            <input id="status" class="form-control input-sm" type="text" name="status" size="25" value="<?php echo $tpl['booking']['status'] ?? ''; ?>" title="<?php echo __('status'); ?>" placeholder="Status" readonly>

                                        </div>
                                    </div>
                                    
                                </div>
                                <fieldset class="form-actions">
                                    <input type="hidden" name="edit_booking" value="1" /> 
                                    <input type="hidden" name="id" value="<?php echo $tpl['booking']['id'] ?? ''; ?>" /> 
                                    <button id="calculate-price-id-1" style ="display:none;" class="btn btn-success calculate-price-class" autocomplete="off" value="<?php echo __('calculate'); ?>" name="calculate" tabindex="9" type="submit"><i class="fa fa-fw fa-rotate-right"></i>&nbsp;&nbsp;<?php echo __('calculate'); ?></button>
                                </fieldset>
                            </div>
                        </section>
                       <!-- paras -->
                        <section class="col-lg-5 connectedSortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('Rental Date & Time'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
	                        </div>
                            <div class="box-body">
                                    <label class="control-label" for="select_date"><?php echo __('select_date'); ?>:</label>
                                    <div class="input-group">    
                                        <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>
                                        <input required="true" min="<?php echo date('Y-m-d'); ?>"  id="select_date" class="form-control input-sm" type="date" name="date" size="25"  value="<?php echo date('Y-m-d', strtotime($bookDate)); ?>" title="Date" placeholder="" readonly></td> 
                                        <!-- <input data-rule-required="true" id="select_date" class="form-control input-sm datepicker" type="text" name="date" size="25" value="" data-date-format="<?php echo $tpl['js_format']; ?>" first-day="<?php echo $tpl['option_arr_values']['week_first_day'] ?? ''; ?>"> -->
                                    </div>
                                    <div class="box-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                            <!-- <th>Event Date</th> -->
                        <!-- <th>End Date</th> -->
                        <th>Event Start Time</th>
                        <th>Event End Time</th>
                        <th>Total Duration(Hours)</th>
                        </thead>
                        <tbody>
                        <!-- <td class="td"><input readonly required="true" id="startdate" class="form-control input-sm"  name="Startdate" size="25" value="<?php echo $_POST['Startdate'] ?? ''; ?>" title="Date" placeholder=""></td> -->
                            <!-- <td class="td"><input readonly required="true" id="enddate" class="form-control input-sm"  name="Enddate" size="25" value="<?php echo $_POST['Enddate'] ?? ''; ?>" title="Date" placeholder=""></td>
                               -->
                                <td class="td"><input style="WIDTH: 100%;" readonly required="true" type="numbers" id="starttime" name="Starttime" class="form-control input-sm" value="<?php echo $tpl['bookingslot']['StartTime'] ?? ''; ?>"></td>
                                <td class="td"><input  style="WIDTH: 100%;" readonly required="true" type="numbers" id="endtime" name="Endtime" class="form-control input-sm" value="<?php echo $tpl['bookingslot']['EndTime'] ?? ''; ?>"></td>
                                <td class="td"><input  style="WIDTH: 100%;" readonly required="true" type="numbers" id="hours" name="Hours" class="form-control input-sm" value="<?php echo $tpl['bookingslot']['Hours'] ?? ''; ?>"></td>  
                            </tr>
                                   
                                
                        </tbody>
                    </table>
                </div>
                                </div>
                           </section>
                        <!-- <section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-body">
                                    <label class="control-label" for="select_date"><?php echo __('select_date'); ?>:</label>
                                    <div class="input-group">    
                                        <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>
                                        <input data-rule-required="true" id="select_date" class="form-control input-sm datepicker" type="text" name="date" size="25" value="" data-date-format="<?php echo $tpl['js_format']; ?>" first-day="<?php echo $tpl['option_arr_values']['week_first_day'] ?? ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </section> -->
                        <section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-body" id="slotsTable">
                                     <?php 
                                     $_REQUEST['calendar_id'] = $tpl['booking']['calendar_id'] ?? '' ;
                                     require 'getSlotsTable.php'; ?>
                                </div>
                            </div>
                        </section>
                    </fieldset>
                </div>
                <div id="tab_2" class="tab-pane">
                    <fieldset>
                        <div class="form-group" style="display:none;">
                            <label class="control-label" for="title"><?php echo __('booking_title'); ?>:</label>
                            <select name="title" id="title" class="form-control input-sm width_150" >
                                <option value="">---</option>
                                <?php
                                $title_arr = __('title_arr');
                                foreach ($title_arr as $k => $v) {
                                    ?>
                                    <option <?php echo ($tpl['booking']['title'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="first_name"><?php echo __('first_name'); ?>:</label>
                            <input id="first_name" class="form-control input-sm" type="text" name="first_name" size="25" value="<?php echo $tpl['booking']['first_name'] ?? ''; ?>" title="first_name" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="second_name"><?php echo __('second_name'); ?>:</label>
                            <input id="second_name" class="form-control input-sm" type="text" name="second_name" size="25" value="<?php echo $tpl['booking']['second_name'] ?? ''; ?>" title="second_name" placeholder="" >
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="phone"><?php echo __('phone'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="phone" size="25" value="<?php echo $tpl['booking']['phone'] ?? ''; ?>" title="phone" placeholder="" >
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email"><?php echo __('email'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="email" size="25" value="<?php echo $tpl['booking']['email'] ?? ''; ?>" title="email" placeholder="" >
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address_1"><?php echo __('Address'); ?>:</label>
                            <input id="address_1" class="form-control input-sm" type="text" name="address_1" size="25" value="<?php echo $tpl['booking']['address_1'] ?? ''; ?>" title="Address" placeholder="" >
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="address_1"><?php echo __('Will Alcholic Beverage be Served?'); ?>:</label><br>
                            <input <?php echo ($tpl['booking']['alcoholic_beverage'] == 'yes') ? "checked='checked'" : ""; ?>
                                type="radio" id="yes" name="alcoholic_beverage"
                                value="yes"> Yes
                            <input
                                <?php echo ($tpl['booking']['alcoholic_beverage'] == 'no') ? "checked='checked'" : ""; ?>
                                type="radio" id="no" name="alcoholic_beverage" value="no"> No
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="organization_name"><?php echo __('Name of the organization/company your represent'); ?>:</label>
                            <input id="organization_name" class="form-control input-sm" type="text" name="organization_name" size="25" value="<?php echo $tpl['booking']['organization_name'] ?? ''; ?>" title="organization name" placeholder="">
                        </div>
                        <!-- <div class="form-group">
                            <label class="control-label" for="company"><?php echo __('company'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="company" size="25" value="<?php echo $tpl['booking']['company'] ?? ''; ?>" title="company" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address_1"><?php echo __('address_1'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="address_1" size="25" value="<?php echo $tpl['booking']['address_1'] ?? ''; ?>" title="address_1" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address_2"><?php echo __('address_2'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="address_2" size="25" value="<?php echo $tpl['booking']['address_2'] ?? ''; ?>" title="address_2" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="city"><?php echo __('city'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="city" size="25" value="<?php echo $tpl['booking']['city'] ?? ''; ?>" title="city" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="state"><?php echo __('state'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="state" size="25" value="<?php echo $tpl['booking']['state'] ?? ''; ?>" title="<?php echo $tpl['booking']['state'] ?? ''; ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="zip"><?php echo __('zip'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="zip" size="25" value="<?php echo $tpl['booking']['zip'] ?? ''; ?>" title="<?php echo $tpl['booking']['zip'] ?? ''; ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="country"><?php echo __('country'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="country" size="25" value="<?php echo $tpl['booking']['country'] ?? ''; ?>" title="<?php echo $tpl['booking']['country'] ?? ''; ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="fax"><?php echo __('fax'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="fax" size="25" value="<?php echo $tpl['booking']['fax'] ?? ''; ?>" title="<?php echo $tpl['booking']['fax'] ?? ''; ?>" placeholder="">
                        </div> -->
                        
                        <div class="form-group">
                            <label class="control-label" for="additional"><?php echo __('additional'); ?>:</label>
                            <textarea  name="additional" class="form-control" ><?php echo $tpl['booking']['additional'] ?? ''; ?></textarea>
                        </div>
                    </fieldset>
                    <fieldset class="form-actions">
                        <input type="hidden" name="edit_booking" value="1" /> 
                        <input type="hidden" name="id" value="<?php echo $tpl['booking']['id'] ?? ''; ?>" /> 
                        
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="paras" id="paras" value="" />
</form>
<div id="dialogSlots" title="<?php echo __('tooltip_selected_slots'); ?>" style="display:none">
    <div name="dialogSlotsDivId" id="dialogSlotsDivId">
    </div>
</div>
 <?php } ?> 
<script>
    function getSafeResponseInput(res, id, jq) {
        var $jq = jq || (typeof gz$ !== 'undefined' ? gz$ : $);
        var nodes = $jq.parseHTML($jq.trim(res || ''), document, false) || [];
        var $nodes = $jq(nodes);
        var $el = $nodes.filter('input#' + id);
        if (!$el.length) {
            $el = $jq('<div>').append($nodes).find('input#' + id);
        }
        return $el;
    }


$(document).ready(function() {
            debugger;
            checkmember();
          var location = $("#location").val();
          var notmem = $("#membertype").val();
          var notgegister = notmem.replace(/ /gi,'').trim();
          var membertype = notgegister.toLowerCase();
         //$.blockUI();
         // $.LoadingOverlay("show");
         //var url = $("#container-abc-url-id").text();
         $.ajax({
            type: "POST",
            data: {
                location: location,
                membertype: membertype,
            },
            //url: url + "load.php?controller=RentalBooking&action=locationprice&cid=location",
            url: "<?= INSTALL_URL ?>load.php?controller=RentalBooking&action=locationprice",
            //url: "http://localhost/HDBS_Payment/PriestMember/load.php?controller=RentalBooking&action=locationprice",
            success: function (res) {
                let price = "";
                // const locationpriceElement = getSafeResponseInput(res, "rentallocationprice", $);
                // if (locationpriceElement.length) {
                //     price = locationpriceElement[0].value;
                // }
                
                //document.getElementById("rentalprice").value = price;
                var rentalprice =  $("#rentalprice").val();
                var advanceamount = $("#advanceamount").val();
                //var remainingamount = parseInt(rentalprice)-parseInt(advanceamount);
                var remainingamount = parseInt(rentalprice) || 0;
                $("#remainingamount").val(remainingamount);
                var extra_amount = $("#extra_amount").val();
                var total;
                if (extra_amount && extra_amount.trim() != "") {
                    total = remainingamount + (parseInt(extra_amount) || 0);
                } else {
                    total = remainingamount;
                }
                $("#total").val(total);
                
                
            }
        });
            
        }); 

function checkmember(){
var notregister = "Non Member";
var  register = "Member";
var  memberreg = <?php echo(json_encode($regmember)); ?>;
if(memberreg == 0){
 $("#membertype").val(notregister);

}
if(memberreg != 0){
 $("#membertype").val(register);

}
}
</script>
