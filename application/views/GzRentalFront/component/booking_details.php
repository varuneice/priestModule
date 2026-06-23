
<style>
   .amd z{display:none;}
  .ab z{display:none;}
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
    ],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);
?>
<form name="ABCBookingForm" id="gz-abc-form-id">
    
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
                            <th>Event Date</th>
                        <!-- <th>End Date</th> -->
                        <th>Event Start Time</th>
                        <th>Event End Time</th>
                        <th>Total Duration(Hours)</th>
                        </thead>
                        <?php
                      $SS = $_POST['Startdate'] ?? '';  
                      $timestamp = strtotime($SS);      
                      $stuidate = date("m-d-Y", $timestamp);
                     
                      ?>
                        <tbody>
                       <td class="td">
                        <input readonly required="true" id="startdateui" class="form-control input-sm"  name="Startdateui" size="25" value="<?php echo $stuidate; ?>" title="Date" placeholder="">    
                        <input readonly required="true" id="startdate" class="form-control input-sm"  name="Startdate" size="25" value="<?php echo $_POST['Startdate'] ?? ''; ?>" title="Date" placeholder="" style="display:none;">
                    </td>
                            <!-- <td class="td"><input readonly required="true" id="enddate" class="form-control input-sm"  name="Enddate" size="25" value="<?php echo $_POST['Enddate'] ?? ''; ?>" title="Date" placeholder=""></td>
                               -->
                                <td class="td">
                                <input style="WIDTH: 100%;" readonly required="true" type="numbers" id="uistarttime" name="uiStarttime" class="form-control input-sm" value="<?php echo $_POST['hidestarttime'] ?? ''; ?>">
                                    <input style="WIDTH: 100%; display:none;" readonly required="true" type="numbers" id="starttime" name="Starttime" class="form-control input-sm" value="<?php echo $_POST['Starttime'] ?? ''; ?>" >
                                </td>
                                
                                <td class="td">
                                <input  style="WIDTH: 100%;" readonly required="true" type="numbers" id="uiendtime" name="uiEndtime" class="form-control input-sm" value="<?php echo $_POST['hideendtime'] ?? ''; ?>">
                                    <input  style="WIDTH: 100%; display:none;" readonly  required="true" type="numbers" id="endtime" name="Endtime" class="form-control input-sm" value="<?php echo $_POST['Endtime'] ?? ''; ?>" >
                                </td>
                                <td class="td"><input  style="WIDTH: 100%;" readonly required="true" type="numbers" id="hours" name="Hours" class="form-control input-sm" value="<?php echo $_POST['Hours'] ?? ''; ?>"></td>  
                            </tr>
                                   
                                
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title"><strong><?php echo __('prices_details'); ?></strong></h3>
                </div>
                <div class="box-body">
                    
               
                    <!-- <div class="form-group" >
                        <label class="control-label" for=""><?php echo __('Member Name'); ?>:</label>
                        <span id="total"><?php echo $_POST['MemberSelect'] ?? ''; ?></span>
                        <div class="control-group"></div>
                    </div> -->
                    <div class="form-group" >
                        <label class="control-label" for=""><?php echo __('Member id'); ?>:</label>
                        <span id="total"><?php echo $_POST['termMember'] ?? ''; ?></span>
                        <div class="control-group"></div>
                    </div>
                    <div class="form-group" >
                        <label class="control-label" for=""><?php echo __('Location'); ?>:</label>
                        <span id="total"><?php echo $_POST['location'] ?? ''; ?></span>
                        <div class="control-group"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for=""><?php echo __('total_price'); ?>:</label>
                        <span id="total"><?php echo $_POST['advanceamount'] ?? ''; ?></span>
                        <div class="control-group"></div>
                    </div>
                    
                    <div class="form-group" style="display:none">
                        <label class="control-label" for=""><?php echo __('Category'); ?>:</label>
                        <span id="total"><?php echo $_POST['category'] ?? ''; ?></span>
                        <div class="control-group"></div>
                    </div>
                    <div class="form-group" style="display:none">
                        <label class="control-label" for=""><?php echo __('Item'); ?>:</label>
                        <span id="total"><?php echo $_POST['item'] ?? ''; ?></span>
                        <div class="control-group"></div>
                    </div>
                </div>
            </div>
            
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
   
   

</form>
<script>
    var sessVal = sessionStorage.getItem('EICEP');
</script>
