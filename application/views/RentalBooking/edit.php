<section class="content-header">
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

$bookingDefaults = [
    'rentalprice' => null,
    'payment_method' => '',
    'cc_type' => '',
    'cc_exp_month' => '',
    'cc_exp_year' => '',
    'calendar_id' => '',
    'status' => '',
    'title' => '',
    'date' => '',
    'Member_id' => '',
    'alcoholic_beverage' => '',
];
$tpl['booking'] = array_merge($bookingDefaults, is_array($tpl['booking'] ?? null) ? $tpl['booking'] : []);
$tpl['option_arr_values'] = array_merge(
    ['currency' => '', 'week_first_day' => ''],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);
$tpl['bookingslot'] = is_array($tpl['bookingslot'] ?? null) ? $tpl['bookingslot'] : [];
$tpl['js_format'] = $tpl['js_format'] ?? '';
$defaultLanguageId = $this->controller->tpl['default_language']['id'] ?? null;

$paymethod = $tpl['booking']['payment_method'] ?? '';
if($paymethod == 'stripe'){
$paymentdata = 'Credit Card';
}
else if($paymethod == "others"){
    $paymentdata = 'Zelle';
}
else if($paymethod =="cash"){
    $paymentdata = 'Cash';
}
else if($paymethod == "check"){
    $paymentdata = 'Check';
}
else if($paymethod == "directdeposit"){
    $paymentdata = 'Direct Deposit';
} else {
    $paymentdata = $paymethod;
}
$slotID = $tpl['bookingslot']['id'] ?? '';
$regmember = $tpl['booking']['Member_id'] ?? '';
$Book_date = $tpl['booking']['date'] ?? '';
$bookDate = date("m/d/Y", is_numeric($Book_date) ? (int)$Book_date : (strtotime($Book_date) ?: time()));

$rentalbookingprice = $tpl['booking']['rentalprice'] ?? '';



?>
<form id="edit_booking" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>RentalBooking/edit" method="post" name="create">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
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
                                            <input data-rule-required="true" id="calendars_price" class="form-control input-sm" type="text" name="calendars_price" size="25" value="<?php echo $tpl['booking']['calendars_price'] ?? ''; ?>" title="<?php echo __('calendars_price'); ?>" placeholder="calendars_price">
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
                                        <label class="control-label" for="advanceamount"><?php echo __('Security Deposit'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="advanceamount" class="form-control input-sm" type="text" name="advanceamount" size="25" value="<?php echo $tpl['booking']['advanceamount'] ?? ''; ?>" title="advanceamount" placeholder="Security Deposit" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                     <label class="control-label" for="rentalprice"><?php echo __('Rental Price'); ?>:</label>
                                     <div class="input-group">
                                     <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                     <?php if ($tpl['booking']['rentalprice'] == null)  { ?>
                                     <input id="rentalprice" class="form-control input-sm" type="text" name="rentalprice" size="25" value="<?php echo $tpl['booking']['rentalprice'] ?? ''; ?>" title="<?php echo __('rentalprice'); ?>" placeholder="Rental Price" onchange="rentalamount(this.id)">
                                     <?php
                                } ?>
                                <?php if ($tpl['booking']['rentalprice'] != "")  { ?>
                                     <input id="rentalpricedata" class="form-control input-sm" type="text" name="rentalprice" size="25" value="<?php echo $tpl['booking']['rentalprice'] ?? ''; ?>" title="<?php echo __('rentalprice'); ?>" placeholder="Rental Price" onchange="rentalamount(this.id)">
                                     <?php
                                } ?>
                                    </div>
                                    </div>
                                    <div class="form-group" style="display:none;">
                                        <label class="control-label" for="remaining"><?php echo __('Remaining Amount'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="remainingamount" class="form-control input-sm" type="text" name="remaining" size="25" value="" title="remaining" placeholder="Remaining" readonly>
                                        </div>
                                    </div>
                                  <div class="form-group">
                                        <label class="control-label" for="extra_amount"><?php echo __('Extra Amount'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="extra_amount" class="form-control input-sm" type="text" name="extraamount" size="25" value="<?php echo $tpl['booking']['extraamount'] ?? ''; ?>" title="extraamount" placeholder="Extra Amount" onchange="extraitemamount(this.id)">
                                        </div>
                                    </div> 
                                   
                                    <div class="form-group">
                                        <label class="control-label" for="total"><?php echo __('Final Payment Amount'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="total" class="form-control input-sm" type="text" name="totalamoutndata" size="25" value="" title="total" placeholder="total" readonly>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label" for="promo_code"><?php echo __('promo_code'); ?>:</label>
                                        <input id="promo_code" class="form-control input-sm" type="text" name="promo_code" size="25" title="<?php echo __('promo_code'); ?>" value="<?php echo $tpl['booking']['promo_code'] ?? ''; ?>" placeholder="">
                                    </div> -->
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
                                        <!-- <select data-rule-required="true" name="payment_method" id="payment_method" class="form-control input-sm" >
                                            <option value="">---</option>
                                            <?php
                                            $payment_method_arr = __('payment_method_arr');
                                            foreach ($payment_method_arr as $k => $v) {
                                                ?>
                                                <option <?php echo ($tpl['booking']['payment_method'] == $k) ? "selected='selected'" : ""; ?>  value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select> -->
                                        <input data-rule-required="true" id="paymentmethod" class="form-control input-sm" type="text" name="payment_method" size="25" value="<?php echo $paymentdata; ?>" title="Payment Method" readonly >
                                    </div>
                                </div>

                                <!-- <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('Other Payment Details'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div> -->
                                <!-- cash check dropdown-->
                                <!-- <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="payment_method"><?php echo __('payment_method'); ?>:</label>
                                        <select name="adminpayment_method" id="cashcheck_method" class="form-control input-sm" onchange="checkCountry(this.id)">
                                            <option value="">Please Select</option>
                                            <option value="check">Check</option>
									        <option value="cash">Cash</option>
                                            <option value="directdeposit">Direct Deposit</option>
                                        </select>
                                    </div>
                                </div>  -->
                                <!-- check dropdown-->
                             <!-- <div class="box-body" style="display:none" id="checkdata">
                                <div class="box-body">
                                        <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                         <tr>
                                            <th>Bank Name</th>
                                            <th>Check No</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                        <td class="td"><input style="WIDTH: 100%;"  type="text" id="checkbankname" name="checkbankname" class="form-control input-sm" value="<?php echo $tpl['booking']['BankName'] ?? ''; ?>"></td>
                                        <td class="td"><input  style="WIDTH: 100%;" type="text" id="checkno" name="CheckNo" class="form-control input-sm" value="<?php echo $tpl['booking']['CheckNo'] ?? ''; ?>"></td>
                                        <td class="td"><input  style="WIDTH: 100%;" type="text" id="checkamount" name="checkAmount" class="form-control input-sm" value="<?php echo $tpl['booking']['total'] ?? ''; ?>"></td>
                                        <td class="td"><input  style="WIDTH: 100%;" type="date" id="checkdate" name="CheckDate" class="form-control input-sm" value="<?php echo $tpl['booking']['CheckDate'] ?? ''; ?>"></td>  
                                        </tr>
                                 </tbody>
                                </table>
                                 </div>
                                    </div>  -->
                               <!--check dropdown end-->
                             <!-- cash start-->

                                <!-- <div class="box-body"  style="display:none" id="cashdata">
                                <div class="box-body">
                                        <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                         <tr>
                                            <th>Receive By</th> -->
                                            <!-- <th>Receive From</th> -->
                                            <!-- <th>Amount</th>
                                            <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                        <td class="td"><input  style="WIDTH: 100%;" type="text" id="receiveby" name="ReceiveBy" class="form-control input-sm" value="<?php echo $tpl['booking']['ReceiveBy'] ?? ''; ?>"></td> -->
                                        <!-- <td class="td"><input  style="WIDTH: 100%;" type="text" id="receivefrom" name="ReceiveFrom" class="form-control input-sm" value="<?php echo $tpl['booking']['ReceiveFrom'] ?? ''; ?>"></td> -->
                                        <!-- <td class="td"><input  style="WIDTH: 100%;" type="text" id="cashamount" name="cashAmount" class="form-control input-sm" value="<?php echo $tpl['booking']['total'] ?? ''; ?>"></td>
                                         <td class="td"><input  style="WIDTH: 100%;" type="date" id="cashdate" name="cashCheckDate" class="form-control input-sm" value="<?php echo $tpl['booking']['CheckDate'] ?? ''; ?>"></td> 
                                        </tr>
                                 </tbody>
                        </table>
                    </div>
                                    </div>  -->
                                    <!-- cash end-->
                             <!-- Direct deposit-->
                                <!-- <div class="box-body" style="display:none" id="directdeposite">
                                <div class="box-body">
                                        <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                         <tr>
                                            <th>Bank Name</th>
                                            <th>Transaction code</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                        <td class="td"><input style="WIDTH: 100%;"  type="text" id="bankname" name="BankName" class="form-control input-sm" value="<?php echo $tpl['booking']['BankName'] ?? ''; ?>"></td>
                                        <td class="td"><input  style="WIDTH: 100%;" type="text" id="ISFCCode" name="Transactioncode" class="form-control input-sm" value="<?php echo $tpl['booking']['Transactioncode'] ?? ''; ?>"></td>
                                        <td class="td"><input  style="WIDTH: 100%;" type="text" id="directamount" name="directamount" class="form-control input-sm" value="<?php echo $tpl['booking']['total'] ?? ''; ?>"></td>
                                        <td class="td"><input  style="WIDTH: 100%;" type="date" id="date" name="directCheckDate" class="form-control input-sm" value="<?php echo $tpl['booking']['CheckDate'] ?? ''; ?>"></td> 
                                        </tr>
                                 </tbody>
                                </table>
                                 </div>
                                    </div> -->
					     <!-- Direct deposit end-->

                                <fieldset class="form-actions">
                                    <input type="hidden" name="edit_booking" value="1" /> 
                                    <input type="hidden" name="id" value="<?php echo $tpl['booking']['id'] ?? ''; ?>" /> 
                                    <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                                </fieldset>
                            </div>
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
                                                <option <?php echo ($tpl['booking']['cc_type'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
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
                                            <select data-rule-required="true" name="status" id="status" class="form-control input-sm" >
                                                <option value="">---</option>
                                                <?php
                                                $status_arr = __('status_arr');
                                                foreach ($status_arr as $k => $v) {
                                                    ?>
                                                    <option <?php echo ($tpl['booking']['status'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
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
                        <!-- Avinash -->
                        <section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('Rental Date & Time'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    
                                <div class="box-body">
                                    <label class="control-label" for="select_date"><?php echo __('select_date'); ?>:</label>
                                    <div class="input-group">    
                                        <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>
                                        <input required="true" min="<?php echo date('Y-m-d'); ?>"  id="select_date" class="form-control input-sm" type="date" name="date" size="25"  value="<?php echo date('Y-m-d', strtotime($bookDate)); ?>" title="Date" placeholder="" ></td> 
                                        <!-- <input data-rule-required="true" id="select_date" class="form-control input-sm datepicker" type="text" name="date" size="25" value="" data-date-format="<?php echo $tpl['js_format']; ?>" first-day="<?php echo $tpl['option_arr_values']['week_first_day'] ?? ''; ?>"> -->
                                    </div>
                                    <div class="box-body">
                                    <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                     <tr>
                                       <th>Event Start Time</th>
                                        <th>Event End Time</th>
                                        <th>Total Duration(Hours)</th>
                                      </thead>
                                      <tbody>
                                    <td class="td"><input style="WIDTH: 100%;" readonly required="true" type="text" id="starttime" name="Starttime" class="form-control input-sm" value="<?php echo $tpl['bookingslot']['StartTime'] ?? ''; ?>"></td>
                                    <td class="td"><input  style="WIDTH: 100%;" readonly required="true" type="text" id="endtime" name="Endtime" class="form-control input-sm" value="<?php echo $tpl['bookingslot']['EndTime'] ?? ''; ?>"></td>
                                    <td class="td"><input  style="WIDTH: 100%;" readonly required="true" type="text" id="hours" name="Hours" class="form-control input-sm" value="<?php echo $tpl['bookingslot']['Hours'] ?? ''; ?>"></td>    
                                 </tr>
                             </tbody>
                    </table>
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
                        <!-- ENd -->
                        <!-- <section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-body">
                                    <label class="control-label" for="select_date"><?php echo __('select_date'); ?>:</label>
                                    <div class="input-group">    
                                        <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>
                                        <input data-rule-required="true" id="select_date" class="form-control input-sm datepicker" type="text" name="date" size="25" value="<?php echo $tpl['booking']['finalDate'] ?? '';?>" data-date-format="<?php echo $tpl['js_format']; ?>" first-day="<?php echo $tpl['option_arr_values']['week_first_day'] ?? ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-body" id="slotsTable">
                                     <?php 
                                     $_REQUEST['calendar_id'] = $tpl['booking']['calendar_id'] ;
                                     require 'getSlotsTable.php'; ?>
                                </div>
                            </div>
                        </section> -->
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
                            <input id="second_name" class="form-control input-sm" type="text" name="second_name" size="25" value="<?php echo $tpl['booking']['second_name'] ?? ''; ?>" title="second_name" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="phone"><?php echo __('phone'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="phone" size="25" value="<?php echo $tpl['booking']['phone'] ?? ''; ?>" title="phone" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email"><?php echo __('email'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="email" size="25" value="<?php echo $tpl['booking']['email'] ?? ''; ?>" title="email" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address_1"><?php echo __('Address'); ?>:</label>
                            <input id="address_1" class="form-control input-sm" type="text" name="address_1" size="25" value="<?php echo $tpl['booking']['address_1'] ?? ''; ?>" title="Address" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="Order Id"><?php echo __('Order Id'); ?>:</label>
                            <input id="Order Id" class="form-control input-sm" type="text" name="oid" size="25" value="<?php echo $tpl['booking']['oid'] ?? ''; ?>" title="Order Id" placeholder="" readonly>
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
                            <label class="control-label" for="Puja  Details"><?php echo __('Puja Type'); ?>:</label>
                            <input id="Puja  Details" class="form-control input-sm" type="text" name="promo_code" size="25" value="<?php echo $tpl['booking']['promo_code'] ?? ''; ?>" title="Puja  Details" placeholder="">
                        </div> -->
                        <!-- <div class="form-group">
                            <label class="control-label" for="location"><?php echo __('Location'); ?>:</label>
                            <input id="location" class="form-control input-sm" type="text" name="location" size="25" value="<?php echo $tpl['booking']['location'] ?? ''; ?>" title="Location" placeholder="">
                        </div> -->
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
                            <textarea name="additional" class="form-control" ><?php echo $tpl['booking']['additional'] ?? ''; ?></textarea>
                        </div>
                    </fieldset>
                    <fieldset class="form-actions">
                        <input type="hidden" name="edit_booking" value="1" /> 
                        <input type="hidden" name="id" value="<?php echo $tpl['booking']['id'] ?? ''; ?>" />
                        <input type="hidden" name="bookingnumber" value="<?php echo $tpl['booking']['booking_number'] ?? ''; ?>" /> 
                        <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</form>
<div id="dialogSlots" title="<?php echo __('tooltip_selected_slots'); ?>" style="display:none">
    <div name="dialogSlotsDivId" id="dialogSlotsDivId">
    </div>
</div>
<script>
 $(document).ready(function() {
    checkmember(); 
    //payvalue();   
    debugger;
          var bookingtable = <?php echo(json_encode($rentalbookingprice)); ?>;
          var location = $("#location").val();
          var notmem = $("#membertype").val();
          var notgegister = notmem.replace(/ /gi,'').trim();
          var membertype = notgegister.toLowerCase();
            var hours = $("#hours").val();
             var dayValue = document.getElementById("select_date").value;
          var numericDay = new Date(dayValue).getDay();
         //$.blockUI();
         // $.LoadingOverlay("show");
         //var url = $("#container-abc-url-id").text();
         if(!bookingtable){
         $.ajax({
            type: "POST",
            data: {
                location: location,
                membertype: membertype,
                hours : hours ,
                numericDay : numericDay
                
            },
            //url: url + "load.php?controller=RentalBooking&action=locationprice&cid=location",
            url: "<?= INSTALL_URL ?>load.php?controller=RentalBooking&action=locationprice",
            //url: "http://localhost/HDBS_Payment/PriestMember/load.php?controller=RentalBooking&action=locationprice",
            success: function (res) {
                debugger;
                console.log(res);
                let price = "";
                const locationpriceElement = $(res).filter("input#rentallocationprice");
                if (locationpriceElement.length) {
                    price = locationpriceElement[0].value;
                }
                
                document.getElementById("rentalprice").value = price;
                var rentalprice =  $("#rentalprice").val();
                var advanceamount = $("#advanceamount").val();
               

               // var remainingamount = parseInt(rentalprice)-parseInt(advanceamount);
                //$("#remainingamount").val(remainingamount);
                var remainingamount = parseInt(rentalprice);
                $("#remainingamount").val(remainingamount);

                var extra_amount = $("#extra_amount").val();
                if(extra_amount.trim() != "")
                  {
                    var total = parseInt(remainingamount) + parseInt(extra_amount);
                    $("#total").val(total);
                 }
                else{
                    $("#total").val(remainingamount);
                }
                
            }
        });
    }else{
        var rentalprice =  $("#rentalpricedata").val();
                var advanceamount = $("#advanceamount").val();

                 //for check & cash
                //  var cashamount = $("#cashamount").val();
                // var checkamount = $("#checkamount").val();
                // var directamount = $("#directamount").val();
                //var remainingamount = parseInt(rentalprice)-parseInt(advanceamount)-parseInt(cashamount)-parseInt(checkamount)-parseInt(directamount);
                //var remainingamount = parseInt(rentalprice)-parseInt(advanceamount);
                var remainingamount = parseInt(rentalprice) || 0;
                $("#remainingamount").val(remainingamount);
                var extra_amount = $("#extra_amount").val();
                if(extra_amount && extra_amount.trim() != "") {
                    var total = parseInt(remainingamount) + (parseInt(extra_amount) || 0);
                } else {
                    var total = parseInt(remainingamount);
                }
                $("#total").val(total);
    }
    }); 

function checkmember20june(){
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


function checkmember() {
    var notregister = "Non Member";
    var register = "Member";
    var memberreg = <?php echo (json_encode($regmember)); ?>;
    console.log(memberreg);

    let cleanMemberReg = (memberreg || "").toString().trim();

    if (
        cleanMemberReg === "" || 
        cleanMemberReg === "0" || 
        cleanMemberReg === null || 
        cleanMemberReg.length >= 5
    ) {
        $("#membertype").val(notregister);
    } else {
        $("#membertype").val(register);
    }
}

function rentalamount(){
        //debugger;
       const securityamount =  parseInt($("#advanceamount").val());
       const rentalnewprice =  parseInt($("#rentalprice").val()); 

       console.log(rentalnewprice)

        if(isNaN(rentalnewprice)){
            document.getElementById("total").value = securityamount;
         }

        //   if(isNaN(extrafieldprice) ){     
        //     document.getElementById("total").value = securityamount; 
        //  }
         else{
            //const finalamount = rentalnewprice - securityamount
            const finalamount = rentalnewprice
            document.getElementById("total").value = finalamount; 
            document.getElementById("remainingamount").value = finalamount; 
         }
    }

function extraitemamount(){
       // debugger;
    //    const pendingamount =  parseInt($("#remainingamount").val());
    //    const extrafieldprice =  parseInt($("#extra_amount").val()); 
    //    const securityamount =  parseInt($("#advanceamount").val());
    //    const rentalnewprice =  parseInt($("#rentalprice").val()); 


        const pendingamount =  parseInt($("#remainingamount").val()) || 0;
       const extrafieldprice =  parseInt($("#extra_amount").val()); 
       const securityamount =  parseInt($("#advanceamount").val());
       const rentalnewprice =  parseInt($("#rentalprice").val()) || 0; 

        if(isNaN(extrafieldprice)){     
            //const finalamount = rentalnewprice - securityamount
            const finalamount = rentalnewprice
            document.getElementById("total").value = finalamount; 
         }
         else{
            const finaltotalamount = extrafieldprice + pendingamount
            document.getElementById("total").value = finaltotalamount; 
            
         }

    }

    
// function checkcash() {
//     //debugger;
//     selectVal = $('#cashcheck_method').val();
//     if (selectVal == "check") {
//         document.getElementById('cashdata').style.display = 'none';
//         document.getElementById('checkdata').style.removeProperty('display');
// 		$("#cashamount").prop('required',false);
//         $("#cashdate").prop('required',false);
// 		  $("#bankname").prop('required',true);
//           $("#checkno").prop('required',true);
// 	      $("#checkamount").prop('required',true);
//           $("#checkdate").prop('required',true);
        
//     }
//     if(selectVal == "cash") {
//         document.getElementById('checkdata').style.display = 'none';
//         document.getElementById('cashdata').style.removeProperty('display');
//         $("#bankname").prop('required',false);
//         $("#checkno").prop('required',false);
// 		$("#checkamount").prop('required',false);
//         $("#checkdate").prop('required',false); 
//         $("#cashamount").prop('required',true);
//         $("#cashdate").prop('required',true);		
//     }
//   };

// function checkCountry(elem){
//         debugger
//     var con = $("#cashcheck_method").val();
//     if(con=="check"){
//         $("#checkdata").show();
//         $("#cashdata").hide();
// 		$("#directdeposite").hide();
// 		}else if(con=="cash"){
//         $("#cashdata").show();
// 		 $("#checkdata").hide();
//         $("#directdeposite").hide();
// 		}else{
//         $("#directdeposite").show();
//         $("#cashdata").hide();
// 		 $("#checkdata").hide();
        
//     }
    
// }

// function payvalue() {
//     debugger
// var pay = <?php echo(json_encode($paymethod)); ?>;
// if (pay !='stripe' && pay !='others' ) 
// {   
// document.getElementById("cashcheck_method").value = pay;
// checkCountry();  

// } 
// else{
//     document.getElementById("cashcheck_method").value ="";
//     document.getElementById("checkamount").value ="";
//     document.getElementById("cashamount").value ="";
//     document.getElementById("directamount").value ="";

// }

// }

</script>
