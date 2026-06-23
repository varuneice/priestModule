<style>
 .amd a{display:none;}
  .ab a{display:none;}
#vid{display:none;}
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
    $length    = 0;
    for ($i = 0; $i < 6; $i++) {
        $rand_code .= chr(random_int(65, 90));
    }
    $_SESSION[$this->controller->default_product][$this->controller->default_captcha] = $rand_code;
?>
<div class="box box-solid box-primary">
    <div class="box-header">
       <h3 class="box-title"><strong><?php echo __('User details'); ?></strong></h3>
    </div>
    <div class="box-body">
        <?php if ($tpl['option_arr_values']['title'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="title"><?php echo __('booking_title'); ?>:</label>
                <select title="<?php echo __('booking_title'); ?>" name="title" id="type_id" class="form-control input-sm"<?php echo($tpl['option_arr_values']['title'] == 3) ? " data-rule-required='true'" : ""; ?>>
                    <option value="">---</option>
                    <?php
                        $title_arr = __('title_arr');
                            foreach ($title_arr as $k => $v) {
                            ?>
                        <option<?php echo(! empty($_POST['title']) && $_POST['title'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                        <?php
                            }
                            ?>
                </select>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['male'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="male"><?php echo __('male'); ?>:</label>
                <select title="<?php echo __('male'); ?>" name="gender" id="male" class="form-control input-sm"<?php echo($tpl['option_arr_values']['male'] == 3) ? " data-rule-required='true'" : ""; ?>>
                    <option value="">---</option>
                    <?php
                        $male_arr = __('male_arr');
                            foreach ($male_arr as $k => $v) {
                            ?>
                        <option<?php echo(! empty($_POST['male']) && $_POST['male'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                        <?php
                            }
                            ?>
                </select>
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['first_name'] != 1) {?>
            <div class="control-group"></div>
            <div class="form-group">
                <label class="control-label" for="first_name"><?php echo __('first_name'); ?>:</label>
                <input id="first_name" class="form-control input-sm"                                                                                                                                         <?php echo($tpl['option_arr_values']['first_name'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="first_name" size="25" value="<?php echo @$_POST['first_name']; ?>" title="<?php echo __('first_name'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['second_name'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="second_name"><?php echo __('second_name'); ?>:</label>
                <input id="second_name" class="form-control input-sm"                                                                                                                                           <?php echo($tpl['option_arr_values']['second_name'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="second_name" size="25" value="<?php echo @$_POST['second_name']; ?>" title="<?php echo __('second_name'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['phone'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="phone"><?php echo __('phone'); ?>:</label>
                <input id="phone" class="form-control input-sm"                                                                                                                               <?php echo($tpl['option_arr_values']['phone'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="phone" size="25" value="<?php echo @$_POST['phone']; ?>" title="<?php echo __('phone'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['email'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="email"><?php echo __('email'); ?>:</label>
                <input id="email" class="form-control input-sm"                                                                                                                                <?php echo($tpl['option_arr_values']['email'] == 3) ? "data-rule-required='true'" : ""; ?> type="email" name="email" size="25" value="<?php echo @$_POST['email']; ?>" title="<?php echo __('email'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['company'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="company"><?php echo __('company'); ?>:</label>
                <input id="company" class="form-control input-sm"                                                                                                                                   <?php echo($tpl['option_arr_values']['company'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="company" size="25" value="<?php echo @$_POST['company']; ?>" title="<?php echo __('company'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['address_1'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="address_1"><?php echo __('address_1'); ?>:</label>
                <input id="address_1" class="form-control input-sm"                                                                                                                                       <?php echo($tpl['option_arr_values']['address_1'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="address_1" size="25" value="<?php echo @$_POST['address_1']; ?>" title="<?php echo __('address_1'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['address_2'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="address_2"><?php echo __('address_2'); ?>:</label>
                <input id="address_2" class="form-control input-sm"                                                                                                                                       <?php echo($tpl['option_arr_values']['address_2'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="address_2" size="25" value="<?php echo @$_POST['address_2']; ?>" title="<?php echo __('address_2'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['city'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="city"><?php echo __('city'); ?>:</label>
                <input id="city" class="form-control input-sm"                                                                                                                             <?php echo($tpl['option_arr_values']['city'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="city" size="25" value="<?php echo @$_POST['city']; ?>" title="<?php echo __('city'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['state'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="state"><?php echo __('state'); ?>:</label>
                <input id="state" class="form-control input-sm"                                                                                                                               <?php echo($tpl['option_arr_values']['state'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="state" size="25" value="<?php echo @$_POST['state']; ?>" title="<?php echo __('state'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['zip'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="zip"><?php echo __('zip'); ?>:</label>
                <input id="zip" class="form-control input-sm"                                                                                                                           <?php echo($tpl['option_arr_values']['zip'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="zip" size="25" value="<?php echo @$_POST['zip']; ?>" title="<?php echo __('zip'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['country'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="country"><?php echo __('country'); ?>:</label>
                <input id="country" class="form-control input-sm"                                                                                                                                   <?php echo($tpl['option_arr_values']['country'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="country" size="25" value="<?php echo @$_POST['country']; ?>" title="<?php echo __('country'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
        <?php }?>
<?php if ($tpl['option_arr_values']['fax'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="fax"><?php echo __('fax'); ?>:</label>
                <input id="fax" class="form-control input-sm"                                                                                                                           <?php echo($tpl['option_arr_values']['fax'] == 3) ? "data-rule-required='true'" : ""; ?> type="text" name="fax" size="25" value="<?php echo @$_POST['fax']; ?>" title="<?php echo __('fax'); ?>" placeholder="">
                <div class="control-group"></div>
            </div>
            <?php
                }
            if ($tpl['option_arr_values']['additional'] != 1) {?>
            <div class="form-group">
                <label class="control-label" for="additional"><?php echo __('additional'); ?>:</label>
                <textarea                                                   <?php echo($tpl['option_arr_values']['additional'] == 3) ? "data-rule-required='true'" : ""; ?> name="additional" class="form-control" title="<?php echo __('additional'); ?>"><?php echo @$_POST['additional']; ?></textarea>
            </div>
            <?php
                }
                if ($tpl['option_arr_values']['enable_payment'] == 1) {
                ?>
            <div class="form-group">
                <label class="control-label" for="payment_method"><?php echo __('payment_method'); ?>:</label>
                <select title="<?php echo __('payment_method'); ?>" name="payment_method" id="payment_method" class="form-control input-sm" data-rule-required='true'>
                    <option value="">Select Payment Method</option>
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
                </select>
            </div>
            <div id="stripe_details" style="display: none;"></div>
            <div class="card-errors"></div>
            <div id="others_details" style="display: none;">
                <div class="form-group" style="display: none;">
                    <label class="control-label" for="confirm_code"><?php echo __('confirm_code'); ?>:</label>
                    <input data-rule-required='true' id="confirm_code" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>">
                    <div class="control-group"></div>
                    <div id="error_code1"></div>
                    <div id="error_code"></div>
                    <div  id="error_codeimg">
                </div>
            </div>
            <div id="MemberID1" class="form-group">
                    <label class="control-label" for="F_Name">Confirm Code</label>
                    <div class="auto-widget">
                    <!-- <input data-rule-required='true' id="MemberID" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>"> -->
                    <select required="" id="MemberID" name="oid"  class="form-control input-sm">
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
        <?php }?>
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
                    if (! empty($_SESSION['err']['captcha'])) {
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
</div>
