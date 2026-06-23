
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
];
$tpl['booking'] = array_merge($bookingDefaults, is_array($tpl['booking'] ?? null) ? $tpl['booking'] : []);
$tpl['option_arr_values'] = array_merge(
    ['currency' => '', 'week_first_day' => ''],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);
$tpl['bookingslot'] = is_array($tpl['bookingslot'] ?? null) ? $tpl['bookingslot'] : [];
$tpl['js_format'] = $tpl['js_format'] ?? '';
$defaultLanguageId = $this->controller->tpl['default_language']['id'] ?? null;

?>
<form id="new_booking" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>RentalBooking/create" method="post" name="create">
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
                                  
                                    <div class="form-group" style="display:none;">
                                        <label class="control-label" for="advanceamount"><?php echo __('Security Deposit'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input  id="advanceamount" class="form-control input-sm" type="text" name="advanceamount" size="25" value="<?php echo $tpl['booking']['advanceamount'] ?? ''; ?>" title="advanceamount" placeholder="Security Deposit">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                     <label class="control-label" for="rentalprice"><?php echo __('Rental Price'); ?>:</label>
                                     <div class="input-group">
                                     <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                     <?php if (($tpl['booking']['rentalprice'] ?? null) === null)  { ?>
                                     <input id="rentalprice" class="form-control input-sm" type="number" name="rentalprice" size="25" value="" title="<?php echo __('rentalprice'); ?>" placeholder="Rental Price" onchange="rentalamount(this.id)" required>
                                     <?php
                                } ?>
                                <?php if (($tpl['booking']['rentalprice'] ?? null) !== null && ($tpl['booking']['rentalprice'] ?? '') !== "")  { ?>
                                     <input id="rentalpricedata" class="form-control input-sm" type="number" name="rentalprice" size="25" value="" title="<?php echo __('rentalprice'); ?>" placeholder="Rental Price" onchange="rentalamount(this.id)" required>
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
                                  <div class="form-group" style="display:none;">
                                        <label class="control-label" for="extra_amount"><?php echo __('Extra Amount'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input id="extra_amount" class="form-control input-sm" type="text" name="extraamount" size="25" value="<?php echo $tpl['booking']['extraamount'] ?? ''; ?>" title="extraamount" placeholder="Extra Amount" >
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
                            <!-- <div class="box box-solid box-primary">
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
                                            <option value="">---</option>
                               
                                            <?php
                                            $payment_method_arr = __('payment_method_arr');
                                            foreach ($payment_method_arr as $k => $v) {
                                                ?>
                                                <option <?php echo ($tpl['booking']['payment_method'] == $k) ? "selected='selected'" : ""; ?>  value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select> 
                                        <input data-rule-required="true" id="paymentmethod" class="form-control input-sm" type="text" name="payment_method" size="25" value="<?php echo $tpl['booking']['payment_method'] ?? ''; ?>" title="Payment Method" readonly >
                                    </div>
                                </div> -->

                                <!-- <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('Other Payment Details'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div> -->
                                <!-- cash check dropdown-->
                                <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('payment_method'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
             
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="payment_method"><?php echo __('payment_method'); ?>:</label>
                                        <select name="payment_method" id="cashcheck_method" class="form-control input-sm" onchange="checkCountry(this.id)" required>
                                            <option value="">Please Select</option>
                                            <option value="check">Check</option>
									        <option value="cash">Cash</option>
                                            <option value="directdeposit">Direct Deposit</option>
                                        </select>
                                    </div>
                                </div> 
                                <!-- check dropdown-->
                                <div class="box-body" style="display:none" id="checkdata">
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
                                        <td class="td"><input  style="WIDTH: 100%;" type="text" id="checkamount" name="checkAmount" class="form-control input-sm" value="<?php echo $tpl['booking']['total'] ?? ''; ?>" onchange="rentalcheckamount(this.id)"></td>
                                        <td class="td"><input  style="WIDTH: 100%;" type="date" id="checkdate" name="CheckDate" class="form-control input-sm" value="<?php echo $tpl['booking']['CheckDate'] ?? ''; ?>"></td>  
                                        </tr>
                                 </tbody>
                                </table>
                                 </div>
                                    </div> 
                               <!--check dropdown end-->
                             <!-- cash start-->

                             <div class="box-body"  style="display:none" id="cashdata">
                                <div class="box-body">
                                        <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                         <tr>
                                            <th>Receive By</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                        <td class="td"><input  style="WIDTH: 100%;" type="text" id="receiveby" name="ReceiveBy" class="form-control input-sm" value="<?php echo $tpl['booking']['ReceiveBy'] ?? ''; ?>"></td>
                                        <td class="td"><input  style="WIDTH: 100%;" type="text" id="cashamount" name="cashAmount" class="form-control input-sm" value="<?php echo $tpl['booking']['total'] ?? ''; ?>"  onchange="rentalcashamount(this.id)"></td>
                                         <td class="td"><input  style="WIDTH: 100%;" type="date" id="cashdate" name="cashCheckDate" class="form-control input-sm" value="<?php echo $tpl['booking']['CheckDate'] ?? ''; ?>"></td> 
                                        </tr>
                                 </tbody>
                        </table>
                    </div>
                                    </div> 
                                    <!-- cash end-->
                             <!-- Direct deposit-->
                             <div class="box-body" style="display:none" id="directdeposite">
                                <div class="box-body">
                                        <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                         <tr>
                                            <th>Bank Name</th>
                                            <th>Transaction Code</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                        <td class="td"><input style="WIDTH: 100%;"  type="text" id="bankname" name="BankName" class="form-control input-sm" value="<?php echo $tpl['booking']['BankName'] ?? ''; ?>"></td>
                                        <td class="td"><input  style="WIDTH: 100%;" type="text" id="ISFCCode" name="ISFCCode" class="form-control input-sm" value="<?php echo $tpl['booking']['ISFCCode'] ?? ''; ?>"></td>
                                        <td class="td"><input  style="WIDTH: 100%;" type="text" id="directamount" name="directamount" class="form-control input-sm" value="<?php echo $tpl['booking']['total'] ?? ''; ?>"  onchange="rentaldirectamount(this.id)"></td>
                                        <td class="td"><input  style="WIDTH: 100%;" type="date" id="directdepositdate" name="transactiondate" class="form-control input-sm" value="<?php echo $tpl['booking']['CheckDate'] ?? ''; ?>"></td> 
                                        </tr>
                                 </tbody>
                                </table>
                                 </div>
                                    </div>
					     <!-- Direct deposit end-->

                                <fieldset class="form-actions">
                                <input type="hidden" name="create_booking" value="1" /> 
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
                                    <label class="control-label" for="membertype"><?php echo __('Durga Bari Member'); ?>:</label>
                                    <!-- <input id="membertype" class="form-control input-sm" type="text" name="membertype" size="25" value="" title="<?php echo __('membertype'); ?>" placeholder="" > -->
                                    <select  required="" name="regmember" id="registrationmember"
                                    class="form-control input-sm" aria-required="true" aria-invalid="false" onchange="membercheck(this)" >
                                    <!-- <option value="">Please select Member type</option> -->
                                    <option value="">Please select Member type</option> 
                                    <option value="member">Yes</option> 
                                    <option value="nonmember">No</option>
                            
                                     </select>
                                        </div>
                                        <div  id="termdiv" class="form-group" style="display:none;">
                                         <input type="text" style="display:none" name="termMember" id="termMember" placeholder="search member here...." class="form-control">  
                                         <input type="text"  name="term" id="term" placeholder="search member here...." class="form-control">  
                                        </div>

                                    <div class="form-group">
                                    <label class="control-label" for="location"><?php echo __('Location'); ?>:</label>
                                    <!-- <input id="location" class="form-control input-sm" type="text" name="location" size="25" value="<?php echo $tpl['booking']['location'] ?? ''; ?>" title="Location" placeholder="" readonly> -->
                                    <select data-rule-required='true' name="location" id="location" class="form-control input-sm"  onchange="rentallocationpriceadmin(this)">
                        <option value="">Select Space</option>
                        <option value="Auditorium">Auditorium </option>
                        <option value="Kalabhavan">Kalabhavan </option>
                        <option value="Both">Both Auditorium and Kalabhavan</option>
                    </select>
                                
                                </div>
                                    
                                    
                                    <div class="box-body" style = "display:none;">
                                        <div class="form-group">
                                            <label class="control-label" for="status"><?php echo __('booking_status'); ?>:</label>
                                            <select name="status" id="status" class="form-control input-sm" >
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
                                    
                                <div class="box-body" style="margin-top: -22px;">
                                    <label class="control-label" for="select_date"><?php echo __('select_date'); ?>:</label>
                                    <div class="input-group">    
                                        <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>
                                        <input required="true" min="<?php echo date('Y-m-d'); ?>"  id="select_date" class="form-control input-sm" type="date" name="date" size="25"  value="" title="Date" placeholder="" onchange="checkdateadmin(this.id)"></td> 
                                        <!-- <input data-rule-required="true" id="select_date" class="form-control input-sm datepicker" type="text" name="date" size="25" value="" data-date-format="<?php echo $tpl['js_format']; ?>" first-day="<?php echo $tpl['option_arr_values']['week_first_day'] ?? ''; ?>"> -->
                                    </div>
                                    <div class="box-body">
                                    <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                     <tr>
                                       <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Total Duration(Hours)</th>
                                      </thead>
                                      <tbody>
                                    
                                    <td class="td"><select id="starttime" name="Starttime"  class="form-control input-sm"style="width: 106px;" onchange="Checkstarttime(this)">
                                <?php for($i = 0; $i < 24; $i++): ?>
                                    <option value="<?= $i % 24 ? $i % 24 : 24 ?>:00 <?= $i >= 24  ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'PM' : 'AM' ?></option>
                                    <?php endfor ?>
                                </select>
                                <input id="hidestarttime" class="form-control" type="text" name="hidestarttime"style="display:none;">
                                <input id="hideendtime" class="form-control" type="text" name="hideendtime"  style ="display:none;">
                            </td>
                                    
                                    <td class="td">
                                    <select id="endtime" name="Endtimeui"  class="form-control input-sm"style="width: 106px;" >
                                <?php for($i = 0; $i < 24; $i++): ?>
                                    <option value="<?= $i % 24 ? $i % 24 : 24 ?>:00 <?= $i >= 24  ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'PM' : 'AM' ?></option>
                                    <?php endfor ?>
                                </select>
                                </td>
                                <td class="td" style="display:none;">
                                <select id="Your_endtime" name="Endtime"  class="form-control input-sm"style="width: 100px;" >
                                <?php for($i = 0; $i < 24; $i++): ?>
                                    <option value="<?= $i % 24 ? $i % 24 : 24 ?>:00 <?= $i >= 24  ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'PM' : 'AM' ?></option>
                                    <?php endfor ?>
                                </select>
                                </td>
                              
                                     <td class="td"><input  style="WIDTH: 106%;"   required="true" type="text" id="hours" name="Hours" class="form-control input-sm" value="<?php echo $tpl['bookingslot']['Hours'] ?? ''; ?>" onchange="CheckHour(this)"></td>  
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
                            <label class="control-label" for="idmem"><?php echo __('Member Id'); ?>:</label>
                            <input id="idmem" class="form-control input-sm" type="text" name="Member_id" size="25" value="<?php echo $tpl['booking']['Member_id'] ?? ''; ?>" title="Member_id" placeholder="" readonly>
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
                            <input id="phone" class="form-control input-sm" type="text" name="phone" size="25" value="<?php echo $tpl['booking']['phone'] ?? ''; ?>" title="phone" placeholder="" maxlength = "10">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email"><?php echo __('email'); ?>:</label>
                            <input id="email" class="form-control input-sm" type="text" name="email" size="25" value="<?php echo $tpl['booking']['email'] ?? ''; ?>" title="email" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address_1"><?php echo __('Address'); ?>:</label>
                            <input id="address_1" class="form-control input-sm" type="text" name="address_1" size="25" value="<?php echo $tpl['booking']['address_1'] ?? ''; ?>" title="Address" placeholder="">
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
                        <!-- <button id="submit"  class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button> -->
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
    document.getElementById("starttime").value ="10:00 ";
    $("#endtime").attr("disabled", "disabled");
 });
        

// function rentalamount(){
//         debugger;
//        const extraamount =  parseInt($("#extra_amount").val());
//        const rentalnewprice =  parseInt($("#rentalprice").val()); 
//        const secutirtamount =  parseInt($("#advanceamount").val()); 
//         if(Number.isNaN(extraamount)){     
//             document.getElementById("total").value = rentalnewprice + secutirtamount; 
//          }
//          else{
//             const finalamount = rentalnewprice + extraamount + secutirtamount
//             document.getElementById("total").value = finalamount; 
//             //document.getElementById("remainingamount").value = finalamount; 
//          }
//     }

function rentalamount(){
        debugger;
       
       const rentalnewprice =  parseInt($("#rentalprice").val()); 
     document.getElementById("total").value = rentalnewprice; 
        
    
    }

// function extraitemamount(){
//        // debugger;
//        const pendingamount =  parseInt($("#remainingamount").val());
//        const extrafieldprice =  parseInt($("#extra_amount").val()); 
//        const securityamount =  parseInt($("#advanceamount").val());
//        const rentalnewprice =  parseInt($("#rentalprice").val()); 

//         if(isNaN(extrafieldprice)){     
//             const finalamount = rentalnewprice - securityamount
//             document.getElementById("total").value = finalamount; 
//          }
//          else{
//             const finaltotalamount = extrafieldprice + pendingamount
//             document.getElementById("total").value = finaltotalamount; 
            
//          }

//     }

    
 function checkCountry(elem){
    debugger
    var con = $("#cashcheck_method").val();
    if(con=="check"){
        $("#checkdata").show();
        $("#cashdata").hide();
		$("#directdeposite").hide();

            $("#receiveby").prop('required',false); 
            $("#cashamount").prop('required',false); 
            $("#cashdate").prop('required',false); 

            $("#bankname").prop('required',false); 
            $("#ISFCCode").prop('required',false); 
            $("#directamount").prop('required',false); 
            $("#directdepositdate").prop('required',false); 

            $("#checkbankname").prop('required',true); 
            $("#checkno").prop('required',true); 
            $("#checkamount").prop('required',true); 
            $("#checkdate").prop('required',true); 

		}else if(con=="cash"){
        $("#cashdata").show();
		$("#checkdata").hide();
        $("#directdeposite").hide();

            $("#checkbankname").prop('required',false); 
            $("#checkno").prop('required',false); 
            $("#checkamount").prop('required',false); 
            $("#checkdate").prop('required',false); 

            $("#bankname").prop('required',false); 
            $("#ISFCCode").prop('required',false); 
            $("#directamount").prop('required',false); 
            $("#directdepositdate").prop('required',false); 

            $("#receiveby").prop('required',true); 
            $("#cashamount").prop('required',true); 
            $("#cashdate").prop('required',true); 
		}else if (con == "directdeposit"){
        $("#directdeposite").show();
        $("#cashdata").hide();
		$("#checkdata").hide();
        
        $("#checkbankname").prop('required',false); 
            $("#checkno").prop('required',false); 
            $("#checkamount").prop('required',false); 
            $("#checkdate").prop('required',false);

            $("#receiveby").prop('required',false); 
            $("#cashamount").prop('required',false); 
            $("#cashdate").prop('required',false); 

            $("#bankname").prop('required',true); 
            $("#ISFCCode").prop('required',true); 
            $("#directamount").prop('required',true); 
            $("#directdepositdate").prop('required',true); 
     }
     else {
            $("#cashdata").hide();
            $("#checkdata").hide();
            $("#directdeposite").hide();
        }

    
 }

function membercheck() {
    debugger;
       // var selectedString = select.options[select.selectedIndex].value;
       var checkdata = $("#registrationmember").val();
        //var checkdata = selectedString;

        if (checkdata == "member") {
          //$('#term option:not(:selected)').attr('disabled', false);
          document.getElementById('termdiv').style.display = "block";
            $("#advanceamount").val("");
            $("#rentalprice").val("");
            $("#remainingamount").val("");
            $("#extra_amount").val("");
            $("#total").val("");
            $("#location").val("");
            $("#idmem").val("");
            $("#first_name").val("");
            $("#second_name").val("");
            $("#phone").val("");
			$("#email").val("");
            $("#address_1").val("");
            $("#term").val("");
            $("#termMember").val("");
 

        } else
        {
            document.getElementById('termdiv').style.display = "none";
            $("#advanceamount").val("");
            $("#rentalprice").val("");
            $("#remainingamount").val("");
            $("#extra_amount").val("");
            $("#total").val("");
            $("#location").val("");
            $("#idmem").val("");
            $("#first_name").val("");
            $("#second_name").val("");
            $("#phone").val("");
			$("#email").val("");
            $("#address_1").val("");
            $("#term").val("");
            $("#termMember").val("");
             
        }
    }
    $(function() {
        debugger;
    $("#term").autocomplete({
        //source: "http://localhost/6march/ajax-db-search.php",
        source: '<?= INSTALL_URL ?>ajax-db-search.php',
        select: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelectdonation();
        }
       });
    });

    //autocomplete  
   function MemberSelectdonation() {
        var url2 = $("#container-abc-url-id").text(); 
        debugger
        var self = this;
        var data = $("#termMember").val();
        var term = $("#term").val();
        if (term != "") {
        const Memberid = data.split("-");
        //var url = gz$("#container-abc-url-id").text(); 
        if (term.trim() != "") {
            $.ajax({
                type: "POST",
                data: {
                    memberid: data
                },
                //url: self.options.server  +"load.php?controller=Donations&action=AllMember&cid=" + self.options.cal_id,
                url: url2 + "load.php?controller=Donations&action=AllMemberNew",
                success: function (res) {
                    debugger;
                    //var Membertext = $("#MemberSelectValue").text();
                 //document.getElementById("MemberSelect").value = Membertext;
                 let MemberName = "";
                
                   const memberNameElement = $(res).filter("input#MemberName");
                  if(memberNameElement.length){
                   MemberName = memberNameElement[0].value; 
                  }
                  document.getElementById("first_name").value = MemberName;

                 
                  let LastName = "";
                    const LastNameElement = $(res).filter("input#last_name");
                    if(LastNameElement.length){
                        LastName = LastNameElement[0].value; 
                       }
                   document.getElementById("second_name").value = LastName;



                  let memberid = "";
                  const memberElement = $(res).filter("input#memberid");
                 if(memberElement.length){
                  memberid = memberElement[0].value; 
                 }
                 document.getElementById("idmem").value = memberid;
     
     
                    let phoneNo = "";
                    let MNo="";
                     const phoneNoElement = $(res).filter("input#Tele1");
                    if(phoneNoElement.length){
                       phoneNo = phoneNoElement[0].value;
                       phoneNo= phoneNo.replace("-", "");
                       MNo = phoneNo; 
                       MNo=MNo.replace("-", ""); 
                    }
                    document.getElementById("phone").value = MNo;
     
                    let email = "";
                     const emailElement = $(res).filter("input#email");
                    if(emailElement.length){
                        email = emailElement[0].value; 
                    }
                    document.getElementById("email").value = email;

                   let street = "";
                   const streetElement = $(res).filter("input#ressidentalAddress");
                  if(streetElement.length){
                    street = streetElement[0].value; 
                  }
                  

                  let resaddress = "";
                   const resaddressElement = $(res).filter("input#Address");
                  if(resaddressElement.length){
                    resaddress = resaddressElement[0].value; 
                  }
                 

                  let state = "";
                  const stateElement = $(res).filter("input#state");
                 if(stateElement.length){
                   state = stateElement[0].value; 
                 }
               

                 let city = "";
                    const cityElement = $(res).filter("input#city");
                   if(cityElement.length){
                      city = cityElement[0].value; 
                   }
                   

                   let zipcode = "";
                    const zipcodeElement = $(res).filter("input#zip_code");
                   if(zipcodeElement.length){
                    zipcode = zipcodeElement[0].value; 
                   }
                   
                   document.getElementById("address_1").value = street.concat(" ",resaddress," ",state," ",city," ",zipcode);
     
                }
            
            });
        } else {
            $("#MemberName").val("");
            $("#phone").val("");
            $("#Your_E-mail").val("");
            $("#memberid").val("");
            $("#spousename").val("");
            $("#Street").val("");
            $("#ressidentalAddress").val("");
            $("#state").val("");
            $("#city").val("");
            $("#zip_code").val("");
            $("#phone").val("");
            $("#email").val("");
            $("#MembCategory").val("");

        }
       }
    }

    // for rental price

 function rentallocationpriceadmin(){
    debugger;
    var regmember = $("#registrationmember").val();
    var location = $("#location").val();
   if(regmember == ""){
     alert("Please Select Member Type First");
     $("#location").val("");
   }  
   if(regmember != ""){
    $.ajax({
            type: "POST",
            data: {
                location: location,
                membertype: regmember,
            },
            //url: url + "load.php?controller=RentalBooking&action=locationprice&cid=location",
            url: "<?= INSTALL_URL ?>load.php?controller=RentalBooking&action=locationprice",
           // url: "http://localhost/6march/load.php?controller=RentalBooking&action=locationprice",
            success: function (res) {
                let price = "";
                const locationpriceElement = $(res).filter("input#rentallocationprice");
                if (locationpriceElement.length) {
                    price = locationpriceElement[0].value;
                }
                
                document.getElementById("rentalprice").value = price;
                $("#total").val(price);
                // var rentalprice =  $("#rentalprice").val();
                // var advanceamount = $("#advanceamount").val();
            
                // var remainingamount = parseInt(rentalprice);
                // $("#remainingamount").val(remainingamount);

                // var extra_amount = $("#extra_amount").val();
                // if(extra_amount.trim() != "")
                //   {
                //     var total = parseInt(remainingamount) + parseInt(extra_amount);
                //     $("#total").val(total);
                //  }
                // else{
                //     $("#total").val(remainingamount);
                // }
                
            }
        });
     }
    }

    // Start time end time calculation
    function Checkstarttime(){
            debugger;
            var start = document.getElementById("starttime").value;
            var newtime = start.split(":");
             var startnewtime = newtime[0]; 
             var startdate = document.getElementById('select_date');
             var date = startdate.value;
             var newdate = date.split("-").reverse().join("-");
             const d = new Date(newdate);
              if(newdate == ""){
               alert("Please select Date First");
               $("#starttime").val("");
               $("#hours").val("");
               $("#endtime").val("");
              }


            if(d.getDay() == 0 ){
                if (startnewtime < 15) {
                alert("HDBS Kala Bhavan cannot be rented during Sunday from 10:00 AM to 3:00 ");
                document.getElementById('endtime').value = '';
                document.getElementById('starttime').value = '';
                 document.getElementById('hours').value = '';
                }
            }
            if(d.getDay() != 0 ){
                if(startnewtime < 10){
                    alert("User can only select minimum start time from 10:00 AM  to end time latest by 12:00 pm ");
                document.getElementById('endtime').value = '';
                document.getElementById('starttime').value = '';
                document.getElementById('hours').value = '';
                }
           
               
            } 
        }

        function CheckHour() {
            debugger;
            var txtstarttime = $("#starttime option:selected").text();
            var start = document.getElementById("starttime").value;
            var newtime = start.split(":");
             var startnewtime = newtime[0];
             
             var hour = document.getElementById("hours").value;
             var newendtime  = parseInt(startnewtime) + parseInt(hour);
    
    
             var startdate = document.getElementById('select_date');
             var date = startdate.value;
             var newdate = date.split("-").reverse().join("-");
             const d = new Date(newdate);
    
             if(newdate == ""){
               alert("Please select Date First");
               $("#starttime").val("");
               $("#hours").val("");
               $("#endtime").val("");
              }
             if(d.getDay() == 0 ){
                if (startnewtime < 16) {
                alert("HDBS Kala Bhavan cannot be rented during Sunday from 10:00 AM to 4:00 ");
                document.getElementById('endtime').value = '';
                document.getElementById('starttime').value = '';
                 document.getElementById('hours').value = '';
                }
                if(hour < 4){
                alert("Please select minimum 4-hour");
                 document.getElementById('endtime').value = '';
                document.getElementById('starttime').value = '';
                document.getElementById('hours').value = '';
             }
            }
            if(d.getDay() != 0 ){
                if(startnewtime < 10){
                    alert("User can only select minimum start time from 10:00 AM  to end time latest by 12:00 pm ");
                document.getElementById('endtime').value = '';
                document.getElementById('starttime').value = '';
                document.getElementById('hours').value = '';
                }
           } 
            if(hour < 4 ){
                alert("Please select minimum 4-hour");
                 document.getElementById('endtime').value = '';
                 document.getElementById('starttime').value = '';
                 document.getElementById('hours').value = '';
               }
    
              else if(newendtime > 24 ||newendtime < 10) {
                alert("User can only  select minimum start time from 10:00 AM  to end time latest by 11:00 pm");
                document.getElementById('endtime').value = '';
                document.getElementById('starttime').value = '';
                document.getElementById('hours').value = '';
              }
              else if(newendtime >= 4) {
                document.getElementById("endtime").value = newendtime +':00 ';
                document.getElementById("Your_endtime").value = newendtime +':00 ';
                
                var endtimetxt = $("#endtime option:selected").text();
                document.getElementById("hidestarttime").value = txtstarttime;
                document.getElementById("hideendtime").value = endtimetxt; 
              }
              
        } 


// for amount match 
function rentalcheckamount(){
    debugger;
    var rentalfinalamount = ($("#total").val() * 1);
            var checkamount = ($("#checkamount").val() * 1);
            if(rentalfinalamount > checkamount){
                alert('Rental price and Check amount not same please select correct payment');
                $("#submit").addClass('disabled');
            }
            else{
                $("#submit").removeClass('disabled');
            }

}

function rentalcashamount(){
    debugger;
    var rentalfinalamount = ($("#total").val() * 1);
            var cashamount = ($("#cashamount").val() *1);
            if( rentalfinalamount > cashamount){
                alert('Rental price and cash amount not same please select correct payment');
                $("#submit").addClass('disabled');
            }else{
                $("#submit").removeClass('disabled');
            }
}

function rentaldirectamount(){
    debugger;
    var rentalfinalamount = ($("#total").val() * 1);
            var directdeposit = ($("#directamount").val() *1);
            if( rentalfinalamount > directdeposit ){
                alert('Rental price and direct deposit amount not same please select correct payment');
                $("#submit").addClass('disabled');
            }
            else{
                $("#submit").removeClass('disabled');
            }
}

// For check date admin end  

function checkdateadmin(){
    debugger;
    var selecteddate = $("#select_date").val(); 
    $.ajax({
            type: "POST",
            data: {
                selecteddate: selecteddate,
            },
            //url: url + "load.php?controller=RentalBooking&action=locationprice&cid=location",
            url: "<?= INSTALL_URL ?>load.php?controller=RentalBooking&action=selecteddate",
            //url: "http://localhost/6march/load.php?controller=RentalBooking&action=selecteddate",
            success: function (res) {
                let existingdate = "";
                const registereddateElement = $(res).filter("input#rentaldate");
                if (registereddateElement.length) {
                    existingdate = registereddateElement[0].value;
                }
                
                let admindate = "";
                const notregdateElement = $(res).filter("input#uirentaldate");
                if (notregdateElement.length) {
                    admindate = notregdateElement[0].value;
                }

               if((existingdate != "" && admindate != "") && (existingdate == admindate)){
                alert("Date already booked please select another date");
                $("#submit").addClass('disabled');
               }
               else{
                $("#submit").removeClass('disabled');
               }
              
            }
        });        
}
</script>
