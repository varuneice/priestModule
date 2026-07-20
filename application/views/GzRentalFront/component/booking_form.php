<meta name="viewport" content="width=960; user-scalable=yes;" />
<style>
 .amd z{display:none;}
  .ab z{display:none;}
#vid{display:none;}
 #MemberID1{clear:both;}
 .booking-zelle-fields{font-weight:bold;margin-left:25%;width:75%;max-width:602px;}
 .booking-zelle-fields #zelle-manual-fields{width:100%;max-width:100%;}
 .booking-zelle-fields .form-control{font-weight:bold;width:100%;max-width:100%;}
 .booking-zelle-fields #MemberID{display:block!important;clear:both!important;float:none!important;width:100%!important;max-width:100%!important;margin:0!important;transform:none!important;}
 .booking-zelle-fields .zelle-field-row{display:block!important;clear:both!important;float:none!important;width:100%!important;margin-bottom:10px;}
 .booking-zelle-fields .zelle-field-label{color:#555;font-size:13px;font-weight:bold;display:block!important;float:none!important;width:auto!important;text-align:left!important;margin:0 0 5px 0!important;transform:none!important;}
 .booking-zelle-fields .zelle-field-row input{display:block!important;clear:both!important;float:none!important;margin-left:0!important;transform:none!important;}
 .booking-zelle-fields #checkPaymentData{display:inline-block!important;float:none!important;margin:0!important;transform:none!important;width:auto!important;}
 .booking-zelle-fields #error_code1{display:block!important;width:100%;max-width:100%;margin:0 0 12px 0!important;text-align:left!important;line-height:1.4;}
 .booking-zelle-fields #error_code1:empty{display:none!important;margin:0!important;}
 .booking-zelle-fields #zelle_donor_name{width:100%!important;max-width:100%!important;}
 .booking-zelle-fields #zelle_date{width:100%!important;max-width:100%!important;}
    </style>
<?php
$tpl['option_arr_values'] = array_merge(
    [
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
        'stripe_allow' => '',
        'others_allow' => '',
        'paypal_allow' => '',
        'authorize_allow' => '',
        '2checkout_allow' => '',
        'pay_arrival_allow' => '',
        'credit_card_allow' => '',
        'bank_acount_allow' => '',
        'show_captcha' => '',
        'show_terms' => '',
    ],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);
$rand_code = "";
$length = 0;
for ($i = 0; $i < 6; $i++) {
    $rand_code .= chr(random_int(65, 90));
}
$_SESSION[$this->controller->default_product][$this->controller->default_captcha] = $rand_code;
?>
<div class="box box-solid box-primary">
    <div class="box-header">
        <h3 class="box-title"><strong>Alcoholic Beverage</strong></h3>
    </div>
    <div class="box-body">
        <div class="form-group">
            <h2>Will Alcoholic Beverage be Served?</h2>
            <h6>You must hire two(2) HPD security officers, arranged by HDBS if alcohol is served during the event.</h6>
            <input type="radio" id="yes" name="alcoholic_beverage" value="yes" required/> Yes
            <input type="radio" id="no" name="alcoholic_beverage" value="no"/> No
        </div>
      
        <div class="form-group">
            <label class="control-label" for="organizationname" style="color:white;">
                <?php echo __('Organisation Name'); ?>:
            </label>
            <input id="organizationname" class="form-control input-sm" type="text" name="organization_name" size="25"
                value="<?php echo @$_POST['organisation name']; ?>" title="<?php echo __('organisation name'); ?>"
                placeholder="Name of the organization/company your represent:"
                style="font-weight: bold;transform: translateX(-25%);">
        </div>

    </div>
    </div>

<div class="box box-solid box-primary">
    <div class="box-header">
       <h3 class="box-title"><strong><?php echo __('User details'); ?></strong></h3>
    </div>
    <div class="box-body">
        <?php if ($tpl['option_arr_values']['title'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="title"><?php echo __('booking_title'); ?>:</label>
                <select title="<?php echo __('booking_title'); ?>" name="title" id="type_id" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['title'] == 3) ? " data-rule-required='true'" : ""; ?>>
                    <option value="">---</option>
                    <?php
                    $title_arr = __('title_arr');
                    foreach ($title_arr as $k => $v) {
                        ?>
                        <option <?php echo (!empty($_POST['title']) && $_POST['title'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['male'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="male"><?php echo __('male'); ?>:</label>
                <select title="<?php echo __('male'); ?>" name="gender" id="male" class="form-control input-sm"  <?php echo ($tpl['option_arr_values']['male'] == 3) ? " data-rule-required='true'" : ""; ?>>
                    <option value="">---</option>
                    <?php
                    $male_arr = __('male_arr');
                    foreach ($male_arr as $k => $v) {
                        ?>
                        <option <?php echo (!empty($_POST['male']) && $_POST['male'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['first_name'] != 1) { ?>
            <div class="control-group"></div>
            <div class="form-group">
                <label class="control-label" for="first_name" style="color:white;"><?php echo __('first_name'); ?>:</label>
                <input id="first_name" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['first_name'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="first_name" size="25" value="<?php echo @$_POST['first_name']; ?>" title="<?php echo __('first_name'); ?>" placeholder="First Name" style="font-weight: bold;transform: translateX(-25%);">
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['second_name'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="second_name" style="color:white;"><?php echo __('second_name'); ?>:</label>
                <input id="second_name" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['second_name'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="second_name" size="25" value="<?php echo @$_POST['second_name']; ?>" title="<?php echo __('second_name'); ?>" placeholder="Last Name" style="font-weight: bold;transform: translateX(-25%);">
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['phone'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="phone" style="color:white;"><?php echo __('phone'); ?>:</label>
                <input id="phone" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['phone'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="phone" size="25" value="<?php echo @$_POST['phone']; ?>" title="<?php echo __('phone'); ?>"pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"" placeholder="### ###-####" maxlength = "10" style="font-weight: bold;transform: translateX(-25%);">
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['email'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="email" style="color:white;"><?php echo __('email'); ?>:</label>
                <input id="email" class="form-control input-sm"  <?php echo ($tpl['option_arr_values']['email'] == 3) ? "data-rule-required='true'" : ""; ?> type="email" name="email" size="25" value="<?php echo @$_POST['email']; ?>" title="<?php echo __('email'); ?>" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" placeholder="name@company.com" style="font-weight: bold;transform: translateX(-25%);">
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['company'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="company"><?php echo __('company'); ?>:</label>
                <input id="company" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['company'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="company" size="25" value="<?php echo @$_POST['company']; ?>" title="<?php echo __('company'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['address_1'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="address_1" style="color:white;"><?php echo __('address_1'); ?>:</label>
                <input id="address_1" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['address_1'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="address_1" size="25" value="<?php echo @$_POST['address_1']; ?>" title="<?php echo __('address_1'); ?>" placeholder="Address" style="font-weight: bold;transform: translateX(-25%);">
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['address_2'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="address_2"><?php echo __('address_2'); ?>:</label>
                <input id="address_2" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['address_2'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="address_2" size="25" value="<?php echo @$_POST['address_2']; ?>" title="<?php echo __('address_2'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['city'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="city"><?php echo __('city'); ?>:</label>
                <input id="city" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['city'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="city" size="25" value="<?php echo @$_POST['city']; ?>" title="<?php echo __('city'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['state'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="state"><?php echo __('state'); ?>:</label>
                <input id="state" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['state'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="state" size="25" value="<?php echo @$_POST['state']; ?>" title="<?php echo __('state'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['zip'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="zip"><?php echo __('zip'); ?>:</label>
                <input id="zip" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['zip'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="zip" size="25" value="<?php echo @$_POST['zip']; ?>" title="<?php echo __('zip'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['country'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="country"><?php echo __('country'); ?>:</label>
                <input id="country" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['country'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="country" size="25" value="<?php echo @$_POST['country']; ?>" title="<?php echo __('country'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php } ?>
        <?php if ($tpl['option_arr_values']['fax'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="fax"><?php echo __('fax'); ?>:</label>
                <input id="fax" class="form-control input-sm" <?php echo ($tpl['option_arr_values']['fax'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="fax" size="25" value="<?php echo @$_POST['fax']; ?>" title="<?php echo __('fax'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
            <?php
        } 
        if ($tpl['option_arr_values']['additional'] != 1) { ?>
            <div class="form-group">
                <label class="control-label" for="additional" style="color:white;"><?php echo __('additional'); ?>:</label>
                <textarea  style="font-weight: bold;transform: translateX(-25%);" placeholder="Short Description of the Event" <?php echo ($tpl['option_arr_values']['additional'] == 3) ? "data-rule-required='true'" : ""; ?> name="additional" class="form-control" title="<?php echo __('additional'); ?>"><?php echo @$_POST['additional']; ?></textarea>
            </div>
            <?php
        }
        if ($tpl['option_arr_values']['enable_payment'] == 1) {
            ?>
            <div class="form-group">
                <label class="control-label" for="payment_method" style="color:white;"><?php echo __('payment_method'); ?>:</label>
                <select title="<?php echo __('payment_method'); ?>" name="payment_method" id="payment_method" class="form-control input-sm" data-rule-required='true' style="font-weight: bold;transform: translateX(-25%);">
                    <option value="" >Select Payment Method</option>
                    <?php
                    $payment_method_arr = __('payment_method_arr');
                    foreach ($payment_method_arr as $k => $v) {
                        if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                            ?>
                            <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                            <?php
                        }
                    }
                    ?>
                    <?php if ($this->controller->isAdmin()) { ?>
                        <option value="check">Check</option>
                    <?php } ?>
                </select>
            </div>
            <div id="stripe_details" style="display: none;"></div>

            <div class="card-errors"></div>
            <div id="others_details" style="display: none;">
                <div class="form-group" style="display: none;">
                    <label class="control-label" for="confirm_code"><?php echo __('confirm_code'); ?>:</label>
                    <input data-rule-required='true' id="confirm_code" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>">
                    <div class="control-group"></div>
                   
                </div>
            </div>
            <div class="box-body" style="display:none" id="checkdata">
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped" style="margin-top: -30px;">
                        <thead>
                            <tr>
                                <th>Bank Name</th>
                                <th>Check No</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Deposit Account</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="td"><input style="WIDTH: 100%;" type="text" id="checkbankname" name="bank" class="form-control input-sm" value=""></td>
                                <td class="td"><input style="WIDTH: 100%;" type="number" id="checkno" name="chkno" class="form-control input-sm" value=""></td>
                                <td class="td"><input style="WIDTH: 100%;" type="number" id="checkamount" name="checkAmount" class="form-control input-sm" value=""></td>
                                <td class="td"><input style="WIDTH: 100%;" type="date" id="checkdate" name="chkdate" class="form-control input-sm" value=""></td>
                                <td class="td"><select name="ReceiveBy" class="accountDropdown">
                                    <option value="RentalAccount">Rental Account</option>
                                    <option value="RegularAccount">Regular Account</option>
                                </select></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="MemberID1" style="display:none;width:100%;max-width:100%;margin-top:10px;" class="form-group">
                <div class="booking-zelle-fields">
                    <label class="control-label" style="color:#555;"><strong>Zelle Payment Details:</strong></label>
                    <div id="error_code1" style="font-size:13px;"></div>
                    <select id="MemberID" name="oid" class="form-control input-sm" style="display:none;">
                        <option value="">Please select your Zelle transaction</option>
                    </select>
                    <div id="zelle-action-btns" style="display:none;margin-top:8px;">
                        <button type="button" id="zelle-verify-btn" class="btn btn-success btn-sm">Verify Selected Transaction</button>
                        <button type="button" id="zelle-retry-btn" class="btn btn-default btn-sm" style="margin-left:8px;">Search Manually</button>
                    </div>
                    <div id="zelle-manual-fields" style="display:none;margin-top:10px;">
                        <div class="zelle-field-row">
                            <label class="zelle-field-label">Your name as used in Zelle:</label>
                            <input type="text" id="zelle_donor_name" class="form-control input-sm" placeholder="Full name used for Zelle transfer">
                        </div>
                        <div class="zelle-field-row" style="margin-bottom:12px;">
                            <label class="zelle-field-label">Payment Date (optional):</label>
                            <input type="date" id="zelle_date" class="form-control input-sm" style="max-width:220px;">
                        </div>
                        <div style="display:flex;justify-content:flex-start;align-items:center;">
                            <button type="button" id="checkPaymentData" class="btn btn-primary btn-sm" style="min-width:190px;">Verify Zelle Payment</button>
                        </div>
                    </div>
                    <div id="zelle-no-match" style="display:none;color:#c0392b;font-size:13px;margin-top:8px;padding:8px;background:#fdecea;border-radius:4px;">
                        No Zelle transaction found. Please check your name and amount, or contact admin.
                    </div>
                    <input type="hidden" name="zellecode" id="Zellecode" value="">
                    <div id="error_codeimg" style="display:none;"></div>
                    <div id="error_code"></div>
                </div>
            </div>
            <div id="credit_card_details" style="display: none;">
                <div class="form-group">
                    <label class="control-label" for="cc_type"><?php echo __('label_cc_type'); ?>:</label>
                    <select title="<?php echo __('label_cc_type'); ?>" data-rule-required='true' name="cc_type" id="cc_type" class="form-control input-sm" >
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
                    <div class="control-group"></div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="cc_num"><?php echo __('cc_num'); ?>:</label>
                    <input data-rule-required='true' id="cc_num" class="form-control input-sm" type="text" name="cc_num" size="25" value="" title="<?php echo __('cc_num'); ?>" placeholder="<?php echo __('cc_num'); ?>">
                    <div class="control-group"></div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="cc_code"><?php echo __('cc_code'); ?>:</label>
                    <input data-rule-required='true' id="cc_code" class="form-control input-sm" type="text" name="cc_code" size="25" value="" title="<?php echo __('cc_code'); ?>" placeholder="<?php echo __('cc_code'); ?>">
                    <div class="control-group"></div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="cc_exp_month"><?php echo __('cc_exp_date'); ?>:</label>
                    <div class="input-group">
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
                        <select title="<?php echo __('cc_exp_date'); ?>" data-rule-required='true' name="cc_exp_year" id="cc_exp_year" class="form-control input-sm mini left margin-left-10" >
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
                    <div class="control-group"></div>
                </div>
            </div>
            <div id="bank_acount_details" style="display: none;">
                <div class="form-group">
                    <label class="control-label" for=""><?php echo __('bank_info'); ?>:</label>
                    <span><?php echo $tpl['option_arr_values']['bank_account_info'] ?? ''; ?></span>
                </div>
            </div>
            <div id="zelle-modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9100;justify-content:center;align-items:center;">
                <div style="background:#fff;border-radius:8px;width:660px;max-width:96vw;max-height:90vh;overflow-y:auto;box-shadow:0 8px 32px rgba(0,0,0,0.25);position:relative;font-family:Arial,sans-serif;">
                    <div style="background:#357ca5;padding:16px 20px 12px;text-align:center;position:relative;border-radius:8px 8px 0 0;">
                        <button id="zelle-modal-close" type="button" style="position:absolute;top:10px;right:14px;background:none;border:none;color:#fff;font-size:24px;cursor:pointer;line-height:1;padding:0;opacity:0.85;">&times;</button>
                        <h4 style="color:#fff;margin:0;font-size:18px;font-weight:bold;">Pay via Zelle</h4>
                        <p style="color:rgba(255,255,255,0.88);margin:4px 0 0;font-size:13px;">Scan QR or send to treasurer@durgabari.org</p>
                    </div>
                    <div style="padding:20px 24px 10px;text-align:center;">
                        <img id="zelle-modal-img" src="" alt="Zelle QR Code" style="max-width:580px;width:100%;height:auto;border-radius:4px;">
                    </div>
                    <div style="padding:0 24px 16px;font-size:14px;color:#333;line-height:1.8;">
                        <b>Step 1</b> - Open your bank app and navigate to Zelle.<br>
                        <b>Step 2</b> - Send your payment amount to <b>treasurer@durgabari.org</b>.<br>
                        <b>Step 3</b> - After sending, click <b>"I've Completed Zelle Payment"</b> below.
                    </div>
                    <div style="padding:0 24px 22px;display:flex;gap:12px;justify-content:center;">
                        <button id="zelle-modal-paid-btn" type="button" class="btn btn-primary" style="min-width:200px;font-size:15px;">I've Completed Zelle Payment</button>
                        <button id="zelle-modal-cancel-btn" type="button" class="btn btn-default" style="min-width:120px;font-size:15px;background:#f5f5f5;border:1px solid #ccc;">Cancel</button>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php
        if ($tpl['option_arr_values']['show_captcha'] != 1) {
            ?>
            <div class="form-group height-50">
                <label class="control-label" for="captcha-id">
                    <?php echo __('captcha'); ?>
                </label>
                <img class="img-captcha left margin_right" src="<?php echo INSTALL_URL; ?>index.php?controller=GzFront&amp;action=captcha&amp;renew=<?php echo $rand_code; ?>&amp;<?php echo random_int(1, 999999); ?>" alt="CAPTCHA" />
                <input data-rule-required='true' type="text" name="captcha" id="captcha-id" title="<?php echo __('vertification_code_not_correct'); ?>" class=" form-control input-sm left" style="width: 25%;" maxlength="6" />
                <?php
                if (!empty($_SESSION['err']['captcha'])) {
                    ?>
                    <label id="captcha-id-error" class="error" for="captcha-id"><?php echo __('vertification_code_not_correct'); ?></label>
                    <?php
                    unset($_SESSION['err']['captcha']);
                }
                ?>
            </div>
            <?php
        }
        
        if ($tpl['option_arr_values']['show_terms'] != 1) {
            ?>
            <div class="form-group height-50 text-center">
                <input id="terms" name="terms" data-rule-required='true' type="checkbox" value="1" title="<?php echo __('terms_and_conditional'); ?>" />
                <?php echo __('accept_with'); ?>&nbsp;<a href="javascript: void;" id="terms_link" ><?php echo __('terms_and_conditional'); ?></a>  
                <div id="dialogTerms" title="<?php echo htmlspecialchars(__('dialogTermsTitle')); ?>" style="display:none">
                    <p><?php echo $tpl['option_arr_values']['terms'] ?? ''; ?></p>
                </div>
            </div>
            <?php
        }
        ?>

</div>
<?php require __DIR__ . '/../../components/otp_modal.php'; ?>
<div id="otp-session-verified" style="display:none"><?= htmlspecialchars($_SESSION['otp_verified_member'] ?? '') ?></div>
