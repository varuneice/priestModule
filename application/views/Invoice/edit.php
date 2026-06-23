<section class="content-header">
    <h1>
        <?php echo __('invoices'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Invoice/index"><?php echo __('invoice'); ?></a></li>
        <li class="active"><?php echo __('edit_invoice'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$invoiceDefaults = [
    'booking_id' => '',
    'status' => '',
    'payment_method' => '',
    'title' => '',
];
$tpl['invoice'] = array_merge($invoiceDefaults, is_array($tpl['invoice'] ?? null) ? $tpl['invoice'] : []);
$tpl['option_arr_values'] = array_merge(
    ['currency' => ''],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);
?>
<form id="edit_invoice_id" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>Invoice/edit" method="post" name="create">
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
                <li class="">
                    <a data-toggle="tab" href="#tab_3"><?php echo __('your_details'); ?></a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                    <fieldset>
                        <section class="col-lg-7 connectedSortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('price_details'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="calendars_price"><?php echo __('calendar_price'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="calendars_price" class="form-control input-sm" type="text" name="calendar_price" size="25" value="<?php echo $tpl['invoice']['calendar_price'] ?? ''; ?>">
                                        </div>
                                        <div class="control-group"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="tax"><?php echo __('tax'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="tax" class="form-control input-sm" type="text" name="tax" size="25" value="<?php echo $tpl['invoice']['tax'] ?? ''; ?>" title="tax" placeholder="">
                                        </div>
                                        <div class="control-group"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="deposit"><?php echo __('deposit'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="deposit" class="form-control input-sm" type="text" name="deposit" size="25" value="<?php echo $tpl['invoice']['deposit'] ?? ''; ?>" title="deposit" placeholder="">
                                        </div>
                                        <div class="control-group"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="discount"><?php echo __('discount'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="discount" class="form-control input-sm" type="text" name="discount" size="25" value="<?php echo $tpl['invoice']['discount'] ?? ''; ?>" title="discount" placeholder="">
                                        </div>
                                        <div class="control-group"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="total"><?php echo __('total'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="total" class="form-control input-sm" type="text" name="total" size="25" value="<?php echo $tpl['invoice']['total'] ?? ''; ?>" title="total" placeholder="">
                                        </div>
                                    </div>
                                    <fieldset class="form-actions">
                                        <input type="hidden" name="id" value="<?php echo $tpl['invoice']['id'] ?? ''; ?>" />
                                        <input type="hidden" name="edit_invoice" value="1" /> 
                                        <button id="submit-4" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                                    </fieldset>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
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
                                    <div class="form-group">
                                        <label class="control-label" for="booking_id"><?php echo __('label_booking'); ?>:</label>
                                        <select data-rule-required="true" name="booking_id" id="booking_id" class="form-control input-sm" >
                                            <option value="">---</option>
                                            <?php foreach (($tpl['booking_arr'] ?? []) as $k => $v) {
                                                ?>
                                                <option <?php echo ($tpl['invoice']['booking_id'] == $v['id'])?"selected='selected'":""; ?> value="<?php echo $v['id']; ?>" ><?php echo $v['booking_number']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="control-group"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="status"><?php echo __('booking_status'); ?>:</label>
                                        <select data-rule-required="true" name="status" id="status" class="form-control input-sm" >
                                            <option value="">---</option>
                                            <?php 
                                            $status_arr = __('status_arr');
                                            foreach ($status_arr as $k => $v) {
                                                ?>
                                                <option <?php echo ($tpl['invoice']['status'] == $k)?"selected='selected'":""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="control-group"></div>
                                    </div>
                                    <fieldset class="form-actions">
                                        <input type="hidden" name="id" value="<?php echo $tpl['invoice']['id'] ?? ''; ?>" />
                                        <input type="hidden" name="edit_invoice" value="1" /> 
                                        <button id="submit-2" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                                    </fieldset>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
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
                                            <option value="">---</option>
                                            <?php 
                                            $payment_method_arr = __('payment_method_arr');
                                            foreach ($payment_method_arr as $k => $v) {
                                                ?>
                                                <option <?php echo ($tpl['invoice']['payment_method'] == $k)?"selected='selected'":""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <fieldset class="form-actions">
                                        <input type="hidden" name="id" value="<?php echo $tpl['invoice']['id'] ?? ''; ?>" />
                                        <input type="hidden" name="edit_invoice" value="1" /> 
                                        <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                                    </fieldset>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </section>
                    </fieldset>
                </div>
                <div id="tab_2" class="tab-pane">
                    <fieldset>
                        <div class="form-group">
                            <label class="control-label" for="title"><?php echo __('booking_title'); ?>:</label>
                            <div class="input-group">
                                <select name="title" id="type_id" class="form-control input-sm" >
                                    <option value="">---</option>
                                    <?php 
                                    $title_arr = __('title_arr');
                                    foreach ($title_arr as $k => $v) {
                                        ?>
                                        <option <?php echo ($tpl['invoice']['title'] == $k)?"selected='selected'":""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group"></div>
                        <div class="form-group">
                            <label class="control-label" for="first_name"><?php echo __('first_name'); ?>:</label>
                            <input id="first_name" class="form-control input-sm" type="text" name="first_name" size="25" value="<?php echo $tpl['invoice']['first_name'] ?? ''; ?>" title="first_name" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="second_name"><?php echo __('second_name'); ?>:</label>
                            <input id="second_name" class="form-control input-sm" type="text" name="second_name" size="25" value="<?php echo $tpl['invoice']['second_name'] ?? ''; ?>" title="second_name" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="phone"><?php echo __('phone'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="phone" size="25" value="<?php echo $tpl['invoice']['phone'] ?? ''; ?>" title="phone" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email"><?php echo __('email'); ?>:</label>
                            <input id="email" class="form-control input-sm" type="text" name="email" size="25" value="<?php echo $tpl['invoice']['email'] ?? ''; ?>" title="email" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="company"><?php echo __('company'); ?>:</label>
                            <input id="company" class="form-control input-sm" type="text" name="company" size="25" value="<?php echo $tpl['invoice']['company'] ?? ''; ?>" title="company" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address_1"><?php echo __('address_1'); ?>:</label>
                            <input id="address_1" class="form-control input-sm" type="text" name="address_1" size="25" value="<?php echo $tpl['invoice']['address_1'] ?? ''; ?>" title="address_1" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address_2"><?php echo __('address_2'); ?>:</label>
                            <input id="address_2" class="form-control input-sm" type="text" name="address_2" size="25" value="<?php echo $tpl['invoice']['address_2'] ?? ''; ?>" title="address_2" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="state"><?php echo __('state'); ?>:</label>
                            <input id="state" class="form-control input-sm" type="text" name="state" size="25" value="<?php echo $tpl['invoice']['state'] ?? ''; ?>" title="state" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="zip"><?php echo __('zip'); ?>:</label>
                            <input id="zip" class="form-control input-sm" type="text" name="zip" size="25" value="<?php echo $tpl['invoice']['zip'] ?? ''; ?>" title="zip" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="country"><?php echo __('country'); ?>:</label>
                            <input id="country" class="form-control input-sm" type="text" name="country" size="25" value="<?php echo $tpl['invoice']['country'] ?? ''; ?>" title="country" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="fax"><?php echo __('fax'); ?>:</label>
                            <input id="fax" class="form-control input-sm" type="text" name="fax" size="25" value="<?php echo $tpl['invoice']['fax'] ?? ''; ?>" title="fax" placeholder="">
                            <div class="control-group"></div>
                        </div>
                    </fieldset>
                    <fieldset class="form-actions">
                        <input type="hidden" name="id" value="<?php echo $tpl['invoice']['id'] ?? ''; ?>" />
                        <input type="hidden" name="edit_invoice" value="1" /> 
                        <button id="submit" class="btn btn-default" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><?php echo __('save'); ?></button>
                    </fieldset>
                </div>
                <div id="tab_3" class="tab-pane">
                    <fieldset>

                        <div class="control-group"></div>
                        <div class="form-group">
                            <label class="control-label" for="invoice_company"><?php echo __('invoice_company'); ?>:</label>
                            <input id="invoice_company" class="form-control input-sm" type="text" name="invoice_company" size="25" value="<?php echo $tpl['invoice']['invoice_company'] ?? ''; ?>" title="<?php echo __('invoice_company'); ?>" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="invoice_name"><?php echo __('invoice_name'); ?>:</label>
                            <input id="invoice_name" class="form-control input-sm" type="text" name="invoice_name" size="25" value="<?php echo $tpl['invoice']['invoice_name'] ?? ''; ?>" title="<?php echo __('invoice_name'); ?>" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="invoice_address"><?php echo __('invoice_address'); ?>:</label>
                            <input id="invoice_address" class="form-control input-sm" type="text" name="invoice_address" size="25" value="<?php echo $tpl['invoice']['invoice_address'] ?? ''; ?>" title="<?php echo __('invoice_address'); ?>" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="invoice_city"><?php echo __('invoice_city'); ?>:</label>
                            <input id="invoice_city" class="form-control input-sm" type="text" name="invoice_city" size="25" value="<?php echo $tpl['invoice']['invoice_city'] ?? ''; ?>" title="<?php echo __('invoice_city'); ?>" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="invoice_state"><?php echo __('invoice_state'); ?>:</label>
                            <input id="invoice_state" class="form-control input-sm" type="text" name="invoice_state" size="25" value="<?php echo $tpl['invoice']['invoice_state'] ?? ''; ?>" title="<?php echo __('invoice_state'); ?>" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="invoice_zip"><?php echo __('invoice_zip'); ?>:</label>
                            <input id="invoice_zip" class="form-control input-sm" type="text" name="invoice_zip" size="25" value="<?php echo $tpl['invoice']['invoice_zip'] ?? ''; ?>" title="<?php echo __('invoice_zip'); ?>" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="invoice_fax"><?php echo __('invoice_fax'); ?>:</label>
                            <input id="invoice_fax" class="form-control input-sm" type="text" name="invoice_fax" size="25" value="<?php echo $tpl['invoice']['invoice_fax'] ?? ''; ?>" title="<?php echo __('invoice_fax'); ?>" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="invoice_phone"><?php echo __('invoice_phone'); ?>:</label>
                            <input id="invoice_phone" class="form-control input-sm" type="text" name="invoice_phone" size="25" value="<?php echo $tpl['invoice']['invoice_phone'] ?? ''; ?>" title="<?php echo __('invoice_phone'); ?>" placeholder="">
                            <div class="control-group"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="invoice_email"><?php echo __('invoice_email'); ?>:</label>
                            <input id="invoice_email" class="form-control input-sm" type="text" name="invoice_email" size="25" value="<?php echo $tpl['invoice']['invoice_email'] ?? ''; ?>" title="<?php echo __('invoice_email'); ?>" placeholder="">
                            <div class="control-group"></div>
                        </div>
                    </fieldset>
                    <fieldset class="form-actions">
                        <input type="hidden" name="id" value="<?php echo $tpl['invoice']['id'] ?? ''; ?>" />
                        <input type="hidden" name="edit_invoice" value="1" /> 
                        <button id="submit-3" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</form>
