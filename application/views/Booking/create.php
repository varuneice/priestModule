<section class="content-header">
    <h1>
        <?php echo __('booking_header'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Booking/index"><?php echo __('booking'); ?></a></li>
        <li class="active"><?php echo __('add_booking'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$tpl['option_arr_values'] = array_merge(
    ['currency' => '', 'week_first_day' => ''],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);
$tpl['js_format'] = $tpl['js_format'] ?? '';
$defaultLanguageId = $this->controller->tpl['default_language']['id'] ?? null;
?>
<form id="new_booking" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>Booking/create" method="post" name="create">
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
                                    <h3 class="box-title"><?php echo __('price_calculator'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="calendars_price"><?php echo __('calendars_price'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="calendars_price" class="form-control input-sm" type="text" name="calendars_price" size="25" value="" title="<?php echo __('calendars_price'); ?>" placeholder="">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label" for="tax"><?php echo __('tax'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="tax" class="form-control input-sm" type="text" name="tax" size="25" value="" title="tax" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="deposit"><?php echo __('deposit'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="deposit" class="form-control input-sm" type="text" name="deposit" size="25" value="" title="deposit" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="discount"><?php echo __('discount'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="discount" class="form-control input-sm" type="text" name="discount" size="25" value="" title="discount" placeholder="">
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label class="control-label" for="total"><?php echo __('total'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="total" class="form-control input-sm" type="text" name="total" size="25" value="" title="total" placeholder="">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label" for="promo_code"><?php echo __('promo_code'); ?>:</label>
                                        <input id="promo_code" class="form-control input-sm" type="text" name="promo_code" size="25" value="" title="<?php echo __('promo_code'); ?>" placeholder="">
                                    </div> -->
                                    <fieldset class="form-actions">
                                        <input type="hidden" name="create_booking" value="1" /> 
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
                                                <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <fieldset class="form-actions">
                                        <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                                    </fieldset>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div class="box box-solid box-primary" id="credit_card_details" style="display: none;">
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
                                                <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="cc_num"><?php echo __('cc_num'); ?>:</label>
                                        <input data-rule-required='true' id="cc_num" class="form-control input-sm" type="text" name="cc_num" size="25" value="" title="<?php echo __('cc_num'); ?>" placeholder="<?php echo __('cc_num'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="cc_code"><?php echo __('cc_code'); ?>:</label>
                                        <input data-rule-required='true' id="fax" class="form-control input-sm" type="text" name="cc_code" size="25" value="" title="<?php echo __('cc_code'); ?>" placeholder="<?php echo __('cc_code'); ?>">
                                    </div>
                                    <div class="form-group width_100">
                                        <label class="control-label" for="cc_exp_month"><?php echo __('cc_exp_date'); ?>:</label>
                                        <div class="input-group left width_100">
                                            <select title="<?php echo __('cc_exp_date'); ?>" data-rule-required='true' name="cc_exp_month" id="cc_exp_month" class="form-control input-sm medium left margin-right-5" >
                                                <option value="">---</option>
                                                <?php
                                                $month_arr = __('month_arr');
                                                foreach ($month_arr as $k => $v) {
                                                    ?>
                                                    <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <select title="<?php echo __('cc_exp_date'); ?>" data-rule-required='true' name="cc_exp_year" id="cc_exp_year" class="form-control input-sm mini left" >
                                                <option value="">---</option>
                                                <?php
                                                for ($v = date('Y'); $v <= date('Y') + 10; $v++) {
                                                    ?>
                                                    <option value="<?php echo $v; ?>" ><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <fieldset class="form-actions">
                                        <input type="hidden" name="create_booking" value="1" /> 
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
                                    <div class="form-group" id="calendars-container-id">
                                        <label class="control-label" for="calendar_id"><?php echo __('calendars'); ?>:</label>
                                        <select data-rule-required="true" name="calendar_id" id="calendar_id" class="form-control input-sm" >
                                            <?php
                                            foreach (($tpl['calendars'] ?? []) as $k => $v) {
                                                ?>
                                                <option value="<?php echo $v['id']; ?>" ><?php echo $v['i18n'][$defaultLanguageId]['title'] ?? ($v['title'] ?? ''); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="status"><?php echo __('booking_status'); ?>:</label>
                                        <select data-rule-required="true" name="status" id="status" class="form-control input-sm" >
                                            <option value="">---</option>
                                            <?php
                                            $status_arr = __('status_arr');
                                            foreach ($status_arr as $k => $v) {
                                                ?>
                                                <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <fieldset class="form-actions">
                                        <input type="hidden" name="create_booking" value="1" /> 
                                        <button id="calculate-price-id-1" class="btn btn-success calculate-price-class" autocomplete="off" value="<?php echo __('calculate'); ?>" name="calculate" tabindex="9" type="submit"><i class="fa fa-fw fa-rotate-right"></i>&nbsp;&nbsp;<?php echo __('calculate'); ?></button>
                                    </fieldset>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </section>
                        <section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-body">
                                    <label class="control-label" for="select_date"><?php echo __('select_date'); ?>:</label>
                                    <div class="input-group">    
                                        <span class="input-group-addon"><i class="fa fa-fw fa-calendar"></i></span>
                                        <input data-rule-required="true" id="select_date" class="form-control input-sm datepicker" type="text" name="date" size="25" value="" data-date-format="<?php echo $tpl['js_format']; ?>" first-day="<?php echo $tpl['option_arr_values']['week_first_day'] ?? ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-body" id="slotsTable">
                                    
                                </div>
                            </div>
                        </section>
                    </fieldset>
                </div>
                <div id="tab_2" class="tab-pane">
                    <fieldset>
                        <div class="form-group">
                            <label class="control-label" for="title"><?php echo __('booking_title'); ?>:</label>
                            <div class="input-group">
                                <select name="title" id="title" class="form-control input-sm width_150" >
                                    <option value="">---</option>
                                    <?php
                                    $title_arr = __('title_arr');
                                    foreach ($title_arr as $k => $v) {
                                        ?>
                                        <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="first_name"><?php echo __('first_name'); ?>:</label>
                            <input id="first_name" class="form-control input-sm" type="text" name="first_name" size="25" value="" title="<?php echo __('first_name'); ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="second_name"><?php echo __('second_name'); ?>:</label>
                            <input id="second_name" class="form-control input-sm" type="text" name="second_name" size="25" value="" title="<?php echo __('second_name'); ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="phone"><?php echo __('phone'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="phone" size="25" value="" title="<?php echo __('phone'); ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email"><?php echo __('email'); ?>:</label>
                            <input id="email" class="form-control input-sm" type="text" name="email" size="25" value="" title="<?php echo __('email'); ?>" placeholder="">
                        </div>
                        <!-- <div class="form-group">
                            <label class="control-label" for="company"><?php echo __('company'); ?>:</label>
                            <input id="company" class="form-control input-sm" type="text" name="company" size="25" value="" title="<?php echo __('company'); ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address_1"><?php echo __('address_1'); ?>:</label>
                            <input id="address_1" class="form-control input-sm" type="text" name="address_1" size="25" value="" title="<?php echo __('address_1'); ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="address_2"><?php echo __('address_2'); ?>:</label>
                            <input id="address_2" class="form-control input-sm" type="text" name="address_2" size="25" value="" title="<?php echo __('address_2'); ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="city"><?php echo __('city'); ?>:</label>
                            <input id="city" class="form-control input-sm" type="text" name="city" size="25" value="" title="<?php echo __('city'); ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="state"><?php echo __('state'); ?>:</label>
                            <input id="state" class="form-control input-sm" type="text" name="state" size="25" value="" title="<?php echo __('state'); ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="zip"><?php echo __('zip'); ?>:</label>
                            <input id="zip" class="form-control input-sm" type="text" name="zip" size="25" value="" title="<?php echo __('zip'); ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="country"><?php echo __('country'); ?>:</label>
                            <input id="country" class="form-control input-sm" type="text" name="country" size="25" value="" title="<?php echo __('country'); ?>" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="fax"><?php echo __('fax'); ?>:</label>
                            <input id="fax" class="form-control input-sm" type="text" name="fax" size="25" value="" title="<?php echo __('fax'); ?>" placeholder="">
                        </div> -->
                        <div class="form-group">
                            <label class="control-label" for="male"><?php echo __('male'); ?>:</label>
                            <select name="gender" id="male" class="form-control input-sm width_150" >
                                <option value="">---</option>
                                <?php
                                $male_arr = __('male_arr');
                                foreach ($male_arr as $k => $v) {
                                    ?>
                                    <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                         <div class="form-group">
                            <label class="control-label" for="additional"><?php echo __('additional'); ?>:</label>
                            <textarea name="additional" class="form-control" ></textarea>
                        </div> 
                    </fieldset>
                    <fieldset class="form-actions">
                        <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
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
