<?php
$tpl['option_arr_values'] = array_merge(
    [
        'date_format' => 'Y-m-d',
        'time_format' => 'H:i',
        'currency' => '',
        'title' => '',
        'male' => '',
        'first_name' => '',
        'second_name' => '',
        'phone' => '',
        'email' => '',
        'company' => '',
        'address_1' => '',
        'address_2' => '',
        'city' => '',
        'state' => '',
        'zip' => '',
        'country' => '',
        'fax' => '',
        'additional' => '',
        'enable_payment' => '',
    ],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);
$tprice = 0;
foreach ($_SESSION[$this->controller->default_product]['slots'][$_REQUEST['cid']] ?? [] as $i => $count) {
    if ($count > 0) {
        $date = strtotime(date("Y-m-d", $i));

        if (!empty($tpl['custom_dates'][$date])) {
            $tprice += $tpl['custom_dates'][$date]['price'];
        } else {

            switch (date('N', $i)) {
                case '1':

                    if (!empty($tpl['custom_prices'][1][date('h:i', $i)])) {
                        $tprice += $tpl['custom_prices'][1][date('h:i', $i)]['price'];
                    } else {
                        $tprice += $tpl['working_time']['monday_price'] ?? 0;
                    }
                    break;
                case '2':

                    if (!empty($tpl['custom_prices'][2][date('h:i', $i)])) {
                        $tprice += $tpl['custom_prices'][2][date('h:i', $i)]['price'];
                    } else {
                        $tprice += $tpl['working_time']['tuesday_price'] ?? 0;
                    }
                    break;
                case '3':

                    if (!empty($tpl['custom_prices'][3][date('h:i', $i)])) {
                        $tprice += $tpl['custom_prices'][3][date('h:i', $i)]['price'];
                    } else {
                        $tprice += $tpl['working_time']['wednesday_price'] ?? 0;
                    }
                    break;
                case '4':

                    if (!empty($tpl['custom_prices'][4][date('h:i', $i)])) {
                        $tprice += $tpl['custom_prices'][4][date('h:i', $i)]['price'];
                    } else {
                        $tprice += $tpl['working_time']['thursday_price'] ?? 0;
                    }
                    break;
                case '5':

                    if (!empty($tpl['custom_prices'][5][date('h:i', $i)])) {
                        $tprice += $tpl['custom_prices'][5][date('h:i', $i)]['price'];
                    } else {
                        $tprice += $tpl['working_time']['friday_price'] ?? 0;
                    }
                    break;
                case '6':

                    if (!empty($tpl['custom_prices'][6][date('h:i', $i)])) {
                        $tprice += $tpl['custom_prices'][6][date('h:i', $i)]['price'];
                    } else {
                        $tprice += $tpl['working_time']['saturday_price'] ?? 0;
                    }
                    break;
                case '7':

                    if (!empty($tpl['custom_prices'][7][date('h:i', $i)])) {
                        $tprice += $tpl['custom_prices'][7][date('h:i', $i)]['price'];
                    } else {
                        $tprice += $tpl['working_time']['sunday_price'] ?? 0;
                    }
                    break;
            }
        }
    }
}
?>
<style>
   .amd z{display:none;}
  .ab z{display:none;}
#vid{display:none;}
</style>
<form name="ABCBookingForm" id="gz-abc-form-id">
    <?php if (!empty($_SESSION[$this->controller->default_product]['slots'][$_REQUEST['cid']])) { ?>
        <fieldset>
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        <strong><?php echo __('booking_details'); ?></strong>
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo __('date'); ?>
                                </th>
                                <th>
                                    <?php echo __('start_time'); ?>
                                </th>
                                <th>
                                    <?php echo __('end_time'); ?>
                                </th>
                                <?php if ($tprice > 0) { ?>
                                    <th>
                                        <?php echo __('prices'); ?>
                                    </th>
                                <?php } ?>
                                <th>
                                    <?php echo __('count'); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($_SESSION[$this->controller->default_product]['slots'][$_REQUEST['cid']] ?? [] as $i => $count) {
                                if ($count > 0) {
                                    $date = strtotime(date("Y-m-d", $i));

                                    if (!empty($tpl['custom_dates'][$date])) {
                                        $slot_lenght = $tpl['custom_dates'][$date]['slot_lenght'];
                                        $price = $tpl['custom_dates'][$date]['price'];
                                    } else {
                                        switch (date('N', $i)) {
                                            case '1':
                                                $slot_lenght = $tpl['working_time']['monday_slot_lenght'] ?? '';

                                                if (!empty($tpl['custom_prices'][1][date('h:i', $i)])) {
                                                    $price = $tpl['custom_prices'][1][date('h:i', $i)]['price'];
                                                } else {
                                                    $price = $tpl['working_time']['monday_price'] ?? '';
                                                }
                                                break;
                                            case '2':
                                                $slot_lenght = $tpl['working_time']['tuesday_slot_lenght'] ?? '';

                                                if (!empty($tpl['custom_prices'][2][date('h:i', $i)])) {
                                                    $price = $tpl['custom_prices'][2][date('h:i', $i)]['price'];
                                                } else {
                                                    $price = $tpl['working_time']['tuesday_price'] ?? '';
                                                }
                                                break;
                                            case '3':
                                                $slot_lenght = $tpl['working_time']['wednesday_slot_lenght'] ?? '';

                                                if (!empty($tpl['custom_prices'][3][date('h:i', $i)])) {
                                                    $price = $tpl['custom_prices'][3][date('h:i', $i)]['price'];
                                                } else {
                                                    $price = $tpl['working_time']['wednesday_price'] ?? '';
                                                }
                                                break;
                                            case '4':
                                                $slot_lenght = $tpl['working_time']['thursday_slot_lenght'] ?? '';

                                                if (!empty($tpl['custom_prices'][4][date('h:i', $i)])) {
                                                    $price = $tpl['custom_prices'][4][date('h:i', $i)]['price'];
                                                } else {
                                                    $price = $tpl['working_time']['thursday_price'] ?? '';
                                                }
                                                break;
                                            case '5':
                                                $slot_lenght = $tpl['working_time']['friday_slot_lenght'] ?? '';

                                                if (!empty($tpl['custom_prices'][5][date('h:i', $i)])) {
                                                    $price = $tpl['custom_prices'][5][date('h:i', $i)]['price'];
                                                } else {
                                                    $price = $tpl['working_time']['friday_price'] ?? '';
                                                }
                                                break;
                                            case '6':
                                                $slot_lenght = $tpl['working_time']['saturday_slot_lenght'] ?? '';

                                                if (!empty($tpl['custom_prices'][6][date('h:i', $i)])) {
                                                    $price = $tpl['custom_prices'][6][date('h:i', $i)]['price'];
                                                } else {
                                                    $price = $tpl['working_time']['saturday_price'] ?? '';
                                                }
                                                break;
                                            case '7':
                                                $slot_lenght = $tpl['working_time']['sunday_slot_lenght'] ?? '';

                                                if (!empty($tpl['custom_prices'][7][date('h:i', $i)])) {
                                                    $price = $tpl['custom_prices'][7][date('h:i', $i)]['price'];
                                                } else {
                                                    $price = $tpl['working_time']['sunday_price'] ?? '';
                                                }
                                                break;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo date($tpl['option_arr_values']['date_format'], $i); ?>
                                        </td>
                                        <td>
                                            <?php echo date($tpl['option_arr_values']['time_format'], $i); ?>
                                        </td>
                                        <td>
                                            <?php echo date($tpl['option_arr_values']['time_format'], ($i + $slot_lenght * 60)); ?>
                                        </td>
                                        <?php if ($tprice > 0) { ?>
                                            <td>
                                                <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'], $count * $price); ?>
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <?php echo $count ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title"><strong><?php echo __('prices_details'); ?></strong></h3>
                </div>
                <div class="box-body">
                    <div class="form-group" style="display:none;">
                        <label class="control-label" for=""><?php echo __('calendar_price'); ?>:</label>
                        <span id="calendars_price"><?php echo $tpl['prices']['formated_calendars_price'] ?? ''; ?></span>
                        <div class="control-group"></div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="control-label" for=""><?php echo __('tax'); ?>:</label>
                        <span id="tax"><?php echo $tpl['prices']['formated_tax'] ?? ''; ?></span>
                        <div class="control-group"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for=""><?php echo __('discount'); ?>:</label>
                        <span id="discount"><?php echo $tpl['prices']['formated_discount'] ?? ''; ?></span>
                        <div class="control-group"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for=""><?php echo __('deposit_price'); ?>:</label>
                        <span id="deposit"><?php echo $tpl['prices']['formated_deposit'] ?? ''; ?></span>
                        <div class="control-group"></div>
                    </div> -->
                    <div class="form-group">
                        <label class="control-label" for=""><?php echo __('total_price'); ?>:</label>
                        <span id="total"><?php echo $tpl['prices']['formated_total'] ?? ''; ?></span>
                        <div class="control-group"></div>
                    </div>
                </div>
            </div>
            <?php if ($tpl['option_arr_values']['title'] != 1 || $tpl['option_arr_values']['male'] != 1 || $tpl['option_arr_values']['first_name'] != 1 || $tpl['option_arr_values']['second_name'] != 1 || $tpl['option_arr_values']['phone'] != 1 || $tpl['option_arr_values']['email'] != 1) { ?>
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><strong><?php echo __('personal_details'); ?></strong></h3>
                    </div>
                    <div class="box-body">
                        <?php if ($tpl['option_arr_values']['title'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="title"><?php echo __('booking_title'); ?>:</label>
                                <span><?php
                                    $title_arr = __('title_arr');
                                    echo $title_arr[$_POST['title'] ?? ''] ?? '';
                                    ?></span>
                            </div>
                        <?php } ?>
                        <?php if ($tpl['option_arr_values']['male'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="male"><?php echo __('male'); ?>:</label>
                                <span><?php
                                    $male_arr = __('male_arr');
                                    echo $male_arr[$_POST['male'] ?? ''] ?? '';
                                    ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>
                        <?php if ($tpl['option_arr_values']['first_name'] != 1) { ?>
                            <div class="control-group"></div>
                            <div class="form-group">
                                <label class="control-label" for="first_name"><?php echo __('first_name'); ?>:</label>
                                <span><?php echo $_POST['first_name'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>
                        <?php if ($tpl['option_arr_values']['second_name'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="second_name"><?php echo __('second_name'); ?>:</label>
                                <span><?php echo $_POST['second_name'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>
                        <?php if ($tpl['option_arr_values']['phone'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="phone"><?php echo __('phone'); ?>:</label>
                                <span><?php echo $_POST['phone'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>
                        <?php if ($tpl['option_arr_values']['email'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="email"><?php echo __('email'); ?>:</label>
                                <span><?php echo $_POST['email'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <?php if ($tpl['option_arr_values']['company'] != 1 || $tpl['option_arr_values']['address_1'] != 1 || $tpl['option_arr_values']['address_2'] != 1 || $tpl['option_arr_values']['state'] != 1 || $tpl['option_arr_values']['city'] != 1 || $tpl['option_arr_values']['zip'] != 1 || $tpl['option_arr_values']['country'] != 1 || $tpl['option_arr_values']['fax'] != 1) { ?>
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><strong><?php echo __('billing_address'); ?></strong></h3>
                    </div>
                    <div class="box-body">
                        <?php if ($tpl['option_arr_values']['company'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="company"><?php echo __('company'); ?>:</label>
                                <span><?php echo $_POST['company'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>
                        <?php if ($tpl['option_arr_values']['address_1'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="address" ><?php echo __('address_1'); ?>:</label>
                                <span><?php echo $_POST['address_1'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>
                        <?php if ($tpl['option_arr_values']['address_2'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="address_2"><?php echo __('address_2'); ?>:</label>
                                <span><?php echo $_POST['address_2'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>
                        <?php if ($tpl['option_arr_values']['city'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="city"><?php echo __('city'); ?>:</label>
                                <span><?php echo $_POST['city'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>
                        <?php if ($tpl['option_arr_values']['state'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="state"><?php echo __('state'); ?>:</label>
                                <span><?php echo $_POST['state'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>
                        <?php if ($tpl['option_arr_values']['zip'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="zip"><?php echo __('zip'); ?>:</label>
                                <span><?php echo $_POST['zip'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>
                        <?php if ($tpl['option_arr_values']['country'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="country"><?php echo __('country'); ?>:</label>
                                <span><?php echo $_POST['country'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div>
                        <?php } ?>


                        <?php if ($tpl['option_arr_values']['fax'] != 1) { ?>
                            <div class="form-group">
                                <label class="control-label" for="fax"><?php echo __('hdbs  member'); ?>:</label>
                                <span><?php echo $_POST['fax'] ?? ''; ?></span>
                                <div class="control-group"></div>
                            </div> 


                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <?php if ($tpl['option_arr_values']['enable_payment'] == 1) { ?>
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><strong><?php echo __('payment_details'); ?></strong></h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label" for="payment_method"><?php echo __('payment_method'); ?>:</label>
                            <span>
                                <?php
                                $payment_method_arr = __('payment_method_arr');
                                echo $payment_method_arr[$_POST['payment_method'] ?? ''] ?? '';
                                ?>
                            </span>
                            <div class="control-group"></div>
                        </div>
                    </div>
                </div>
                <?php
                if (($_POST['payment_method'] ?? '') == 'credit_card') {
                    ?>
                    <div class="box box-solid box-primary" id="credit_card_details">
                        <div class="box-header">
                            <h3 class="box-title"><strong><?php echo __('credit_card_details'); ?></strong></h3>
                        </div>
                        <div class="box-body">
                            <div >
                                <div class="form-group">
                                    <label class="control-label" for="cc_type"><?php echo __('label_cc_type'); ?>:</label>
                                    <span><?php
                                        $cc_type = __('cc_type');
                                        echo $cc_type[$_POST['cc_type'] ?? ''] ?? '';
                                        ?>
                                    </span>
                                    <div class="control-group"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="cc_num"><?php echo __('cc_num'); ?>:</label>
                                    <span><?php echo $_POST['cc_num'] ?? ''; ?></span>
                                    <div class="control-group"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="cc_code"><?php echo __('cc_code'); ?>:</label>
                                    <span><?php echo $_POST['cc_code'] ?? ''; ?></span>
                                    <div class="control-group"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label left" for="cc_exp_year"><?php echo __('cc_exp_date'); ?>:</label>
                                    <span class="medium  margin-right-5"><?php
                                        $month_arr = __('month_arr');
                                        echo $month_arr[$_POST['cc_exp_month'] ?? ''] ?? '';
                                        ?>
                                    </span>
                                    <span class="mini "><?php echo $_POST['cc_exp_year'] ?? ''; ?></span>
                                    <div class="control-group"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } elseif (($_POST['payment_method'] ?? '') == 'bank_acount') {
                    ?>
                    <div class="box box-solid box-primary" id="bank_acount_details">
                        <div class="box-header">
                            <h3 class="box-title"><strong><?php echo __('bank_acount_details'); ?></strong></h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label" for=""><?php echo __('bank_info'); ?>:</label>
                                <span><?php echo $tpl['option_arr_values']['bank_account_info'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            <?php } ?>
            <?php if ($tpl['option_arr_values']['additional'] != 1) { ?>
                <div class="box box-solid box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><strong><?php echo __('additional'); ?></strong></h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label" for="additional"><?php echo __('additional'); ?>:</label>
                            <span><?php echo $_POST['additional'] ?? ''; ?></span>
                            <div class="control-group"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </fieldset>

        <fieldset>
            <div class="box box-solid box-primary margin-0">
                <div class="box-body  text-center">
                    <?php
                    foreach ($_POST as $name => $value) {
                        if (is_array($value)) {
                            foreach ($value as $k => $v) {
                                ?>
                                <input type="hidden" name="<?php echo $name; ?>[]" value="<?php echo $v ?>" >
                                <?php
                            }
                        } else {
                            ?>
                            <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value ?>" >
                            <?php
                        }
                    }
                    ?>                
                    <input type="hidden" name="create_booking" value="1"  > 
                    <button data-style="expand-left" class="btn btn-default btn-danger ladda-button" id="back_booking_frm_btn_id" autocomplete="off" value="<?php echo __('back'); ?>" name="back" tabindex="9" type="submit">
                        <span class="ladda-label">               
                            <?php echo __('back'); ?>
                        </span>        
                        <span class="ladda-spinner"></span>
                    </button>
                    <button data-style="expand-left" class="btn btn-warning btn-warning ladda-button" id="checkout_frm_btn_id" autocomplete="off" value="<?php echo __('booking'); ?>" name="submit" tabindex="9" type="submit">
                        <span class="ladda-label"><i class="fa fa-gavel"></i>&nbsp;&nbsp;&nbsp;<?php echo __('booking'); ?></span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>
            </div>
        </fieldset>
    <?php } else {
        ?>
        <div class="alert alert-warning  in">
            <i class="fa-fw fa fa-warning"></i>
            <strong><?php echo __('warning'); ?></strong>
            <?php echo __('rooms_error_message'); ?>
        </div>
        <fieldset>
            <div class="box box-solid box-primary margin-0">
                <div class="box-body">
                    <button style="float: left;" class="btn btn-default" id="back_booking_frm_btn_id" autocomplete="off" value="<?php echo __('back'); ?>" name="back" tabindex="9" type="submit"><?php echo __('back'); ?></button>
                </div>
            </div>
        </fieldset>
        <?php
    }
    ?>

    
</form>
<script>
    var sessVal = sessionStorage.getItem('EICEP');
</script>
