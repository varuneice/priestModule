<style>
 .point{
    pointer-events: none;
    opacity: 0.8;
    }
#ui-id-1 {
    top: 540px;
    left: 511.827px;
    width: 384.297px
     } 
.ui-menu .ui-menu-item {
    margin: 0;
    cursor: pointer;
}
.ui-menu {
    list-style: none;
    padding: 0;
    margin: 0;
    display: block;
    outline: 0;
}
.ui-menu .ui-menu-item-wrapper {
    position: relative;
    padding: 3px 1em 3px 0.4em;
}
.ui-widget {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 13px;
}
.ui-widget.ui-widget-content {
    border: 1px solid #c5c5c5;
}
.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
}
</style>    
<?php
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
<form action="post" name="gz-time-slot-booking-form" id="gz-time-slot-booking-form-id">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title"><strong><?php echo __('Time slot'); ?></strong></h3>
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
                                <?php echo __('Prices'); ?>
                            </th>
                        <?php } ?>
                        <th>
                            <?php echo __('count'); ?>
                        </th>
                        <th>

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
                            </td>
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
                                        <?php
                                        if ($price > 0) {
                                            echo Util::currenctFormat($tpl['option_arr_values']['currency'], $count * $price);
                                        }
                                        ?>
                                    </td>
                                <?php } ?>
                                <td>
                                    <?php echo $count ?>
                                </td>
                                <td>
                                    <!-- <a href="javascript:" data-date="<?php echo $date; ?>" data-start-time="<?php echo $i; ?>" class="gzRemoveTimeSlotClass fa fa-fw fa-minus-square"></a> -->
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
            <h3 class="box-title"><strong><?php echo __('booking_details'); ?></strong></h3>
        </div>
        <div class="box-body">
            <?php if (empty($_POST['location']) && ($tpl['prices']['calendars_price'] ?? 0) != 0) { ?>

                <div class="form-group" style="display:none;">
                    <label class="control-label" for=""><?php echo __('calendar_price'); ?>:</label>
                    <span id="calendars_price"><?php echo $tpl['prices']['formated_calendars_price'] ?? ''; ?></span>
                </div> 

                <div class="form-group" >
                    <label class="control-label" for=""><?php echo __('total_price'); ?>:</label>
                    <span id="total"><?php echo $tpl['prices']['formated_total'] ?? ''; ?></span>
                </div>
                <?php
            } else {
                ?>
                <div style="display: none;" class="form-group">
                    <label class="control-label" style ="color:white;">Location:</label>
                    <select data-rule-required='true' name="location" id="location" class="form-control input-sm"  style="transform: translateX(-25%);">
                        
                        <?php

                        if($tpl['location_id'] == 1)
                        {
                            echo "<option  value='inside'>Inside Durgabari</option>";
                        }

                        if($tpl['location_id'] == 2)
                        {
                            echo " <option value='outside'>Outside Durgabari</option>";
                        }

                        if($tpl['location_id'] == 3)
                        {
                            echo "<option value='wholeday'>Outside Durgabari Whole Day</option>";
                        }
                        
                        ?>
                    </select>
                </div>

                <div class="form-group" id="hide1" style="display:none">
                    <label class="control-label" style ="color:white;">Select Puja Type:</label>
                    <!--<select data-rule-required='true' name="Puja" id="Puja" class="form-control input-sm"  onchange="populate(this.id)" style="transform: translateX(-25%);" >-->
                    <!--    <option value="" data-subtext="">Select Puja Type</option>-->
                    <!--    <option value="21.00" data-subtext="Walk-in Puja">$21.00 ... Walk-in Puja</option>-->
                    <!--    <option value="101.00" data-subtext="Sankalpa Puja">$101.00 ... Sankalpa Puja</option>-->
                          <!--previous comment-->
                        <!-- <option value="251.00" data-subtext="(Outside)">$251.00 ... Annaprasana</option> -->
                        <!--<option value="201.00" data-subtext="Annaprasana">$201.00 ... Annaprasana</option>-->
                        <!--<option value="51.00 " data-subtext="Anniversary">$51.00 ... Anniversary</option>-->
                        <!--<option value="201.00" data-subtext="Batsaric Sapindakaran">$201.00 ... Batsaric Sapindakaran</option>-->
                        <!--<option value="51.00" data-subtext="Birthday">$51.00 ... Birthday</option>-->
                        <!--<option value="151.00" data-subtext="Chaturthi Puja">$151.00 ... Chaturthi Puja</option>-->
                       <!--previous comment-->
                        <!-- <option value="301.00" data-subtext="">$301.00 ... Funeral Service</option> -->
                        <!--<option value="201.00" data-subtext="Grihaprabesh">$201.00 ... Grihaprabesh</option>-->
                        <!--<option value="101.00 " data-subtext="ePuja">$101.00 ... ePuja</option>-->
                        <!--<option value="101.00" data-subtext="Mahayagna">$101.00 ... Mahayagna</option>-->
                        <!--<option value="701.00" data-subtext="Marriage">$701.00 ... Marriage</option>-->
                         <!--previous comment-->
                       <!-- <option value="1001.00" data-subtext="(Outside)">$1001.00 ... Marriage</option> -->
                        <!--<option value="151.00" data-subtext="New Born">$151.00 ... New Born</option>-->
                        <!--<option value="201.00" data-subtext="Nandimukh">$201.00 ... Nandimukh</option>-->
                        <!--<option value="51.00" data-subtext="New Vehicle">$51.00 ... New Vehicle</option>-->
                        <!--<option value="601.00 " data-subtext="Poita / Uponayan">$601.00 ... Poita / Uponayan</option>-->
                        <!--<option value="301.00" data-subtext="Sraddhanushthan">$301.00 ... Sraddhanushthan</option>-->
                           <!--previous comment-->
                          <!-- <option value="251.00" data-subtext="Sponsoring Maha Pujas">$251.00 ... Sponsoring Maha Pujas</option>-->
                       <!-- <option value="121.00" data-subtext="">$121.00 ... Sponsoring Pujas</option> -->
                      <!--<option value="121.00" data-subtext="Satya Narayan Puja">$121.00 ... Satya Narayan Puja</option>-->
                          <!--previous comment-->
                        <!-- <option value="151.00" data-subtext="">$151.00 ... Sponsoring Pujas</option> -->
                        <!--<option value="21.00 " data-subtext="Tarpan">$21.00 ... Tarpan</option>-->
                        <!--<option value="301.00" data-subtext="Wedding Engagement">$301.00 ... Wedding Engagement</option>-->
                        <!--<option value="31.00" data-subtext="Sankalpa Puja ">$31.00 ... Sankalpa Puja (Special Occasion)</option>-->
                        <!--</optgroup>
                    
                    </select>-->
                    <select name="Puja" id="Puja"class="form-control input-sm"  onchange="populate(this.id)" style="transform: translateX(-25%);">
    
                    <option value="">---</option>
                        <?php
                            foreach (($tpl['insidearr'] ?? []) as $key => $value) {
                                ?>
                            
                                <option value="<?php echo $value['price']; ?>"><?php echo $value['pujaname'].' $'.$value['price']; ?></option> 
                                <?php
                            }
                            ?>
                        </select>
                </div>
                <div class="form-group" id="hide2" style="display:none;">
                    <label  class="control-label" style ="color:white;">Select Puja Type:</label>
                    <!--<select data-rule-required='true' name="Puja2" id="Puja2" class="form-control input-sm" onchange="populate(this.id)" style="transform: translateX(-25%);" >-->
                    <!--    <option value="" data-subtext="">Select Puja Type</option>-->
                    <!--    <option value="126" data-subtext="Sankalpa Puja">$126 ... Sankalpa Puja</option>-->
                    <!--    <option value="251" data-subtext="Annaprasana">$251 ... Annaprasana</option>-->
                    <!--    <option value="63.5" data-subtext="Anniversary">$63.5 ... Anniversary</option>-->
                    <!--    <option value="251" data-subtext="Batsaric Sapindakaran">$251 ... Batsaric Sapindakaran</option>-->
                    <!--    <option value="63.5" data-subtext="Birthday">$63.5 ... Birthday</option>-->
                    <!--    <option value="188.5" data-subtext="Chaturthi Puja">$188.5 ... Chaturthi Puja</option>-->
                    <!--    <option value="301.00" data-subtext="Funeral Service">$301.00 ... Funeral Service</option>-->
                    <!--    <option value="251" data-subtext="Grihaprabesh">$251 ... Grihaprabesh</option>-->
                    <!--    <option value="126 " data-subtext="ePuja">$126 ... ePuja</option>-->
                    <!--    <option value="126" data-subtext="Mahayagna">$126 ... Mahayagna</option>-->
                    <!--    <option value="876" data-subtext="Marriage">$876 ... Marriage</option>-->
                    <!--    <option value="190.00" data-subtext="New Born">$190.00 ... New Born</option>-->
                    <!--    <option value="251" data-subtext="Nandimukh">$251 ... Nandimukh</option>-->
                    <!--    <option value="751" data-subtext="Poita / Uponayan">$751 ... Poita / Uponayan</option>-->
                    <!--    <option value="376" data-subtext="Sraddhanushthan">$376 ... Sraddhanushthan</option>-->
                        <!--previous comment-->
                        <!--<option value="313.5" data-subtext="Sponsoring Maha Pujas">$313.5 ... Sponsoring Maha Pujas</option> -->
                       <!-- <option value="151.00" data-subtext="">$151.00 ... Sponsoring Pujas</option> -->
                        <!--<option value="151.00" data-subtext="Satya Narayan Puja">$151.00 ... Satya Narayan Puja</option>-->
                         <!--previous comment-->
                         <!--<option value="151" data-subtext="Sponsoring Maha Pujas">$151 ... Sponsoring Maha Pujas</option> -->
                    <!--    <option value="26" data-subtext="Tarpan">$26 ... Tarpan</option>-->
                    <!--    <option value="376" data-subtext="Wedding Engagement">$376 ... Wedding Engagement</option>-->
                    <!--    <option value="38.5" data-subtext="Sankalpa Puja">$38.5 ... Sankalpa Puja (Special Occasion)</option>-->
                    <!--    </optgroup>-->
                    <!--</select>-->
                    <select name="Puja2" id="Puja2"  class="form-control input-sm" onchange="populate(this.id)" style="transform: translateX(-25%);">
    
                 <option value="">---</option>
                    <?php
                         foreach (($tpl['outsidearr'] ?? []) as $key => $value) {
                    ?>
                <option value="<?php echo $value['price']; ?>"><?php echo $value['pujaname'].' $'.$value['price']; ?></option> 
                <?php
                 }
                 ?>
                </select>
                </div>

                <div class="form-group" id="hide3" style="display:none;">
                    <label  class="control-label" style ="color:white;">Select Puja Type:</label>
                    
                    <select name="Puja3" id="Puja3"  class="form-control input-sm" onchange="populate(this.id)" style="transform: translateX(-25%);">
    
                 <option value="">---</option>
                    <?php
                         foreach (($tpl['pujaWholeDay'] ?? []) as $key => $value) {
                    ?>
                <option value="<?php echo $value['price']; ?>"><?php echo $value['pujaname'].' $'.$value['price']; ?></option> 
                <?php
                 }
                 ?>
                </select>
                </div>

                <div class="form-group" style="display:none;">
                    <label class="control-label" for=""><?php echo __('calendar_price'); ?>:</label>
                    <span id="calendars_price"><?php echo $tpl['prices']['formated_calendars_price'] ?? ''; ?></span>
                </div> 
                <div class="form-group">
                    <label class="control-label" for="" style ="color:white;"><?php echo __('total_price'); ?>:</label>
                    <span id="total" style="transform: translateX(-25%);">
                        <?php echo $tpl['prices']['formated_total'] ?? ''; ?>
                    </span>
                </div>
                <?php
            }
            ?>
            <div class="form-group" >
                    <select style="transform: translateX(41%);" required="" name="regmember" id="registrationmember"
                                    class="form-control input-sm" aria-required="true" aria-invalid="false" >
                                    <!-- <option value="">Please select Member type</option> -->
                                    <option value="">Durga Bari Member</option>
                                    <option value="member">Yes</option>
                                    <option value="nonmember">No</option>

                                     </select>
                                     </div>
                    <div id="otp-session-verified" style="display:none"><?= htmlspecialchars($_SESSION['otp_verified_member'] ?? '') ?></div>
                    <div id="otp-verified-banner" style="display:none;padding:8px 14px;background:#eafaf1;border:1px solid #b7e4c7;border-radius:5px;color:#1e8449;font-size:13px;font-weight:600;margin-bottom:10px;gap:8px;align-items:center;transform:translateX(41%);max-width:55%;">
                        <i class="fa fa-check-circle" style="color:#276632;font-size:16px;"></i>
                        <span>Member verified and details auto-filled.</span>
                    </div>
                    <div  id="termdiv" class="form-group" style="display:none;">
                    <input type="text" style="display:none" name="termMember" id="termMember" placeholder="search member here...." class="form-control">  
                    <input type="text" style="transform: translateX(41%);" name="term" id="term" placeholder="search member here...." class="form-control">  
                     </div>
                 
                
                    <div id="memberidtd" style="display:none;" class="form-group">
                        <input id="idmem" style="transform: translateX(41%);" class="form-control input-sm point" oninvalid="setCustomValidity('Must be 4 Characters')" type="text" name="Member_id" size="25" value="" title="<?php echo _('Member Id'); ?>" placeholder="<?php echo _('Member Id'); ?>" >
                    </div> 
                    <div style="display:none;" class="form-group">
                    <label class="control-label" style ="color:white;"></label>
                        <input id="MemberSelect" class="form-control input-sm" type="text" name="MemberSelect" size="25" value="" title="<?php echo _('Member Id'); ?>" placeholder="<?php echo _('Member Id'); ?>">
                    </div> 

            
            <!-- <div class="form-group">
                    <label class="control-label" for="">YY<?php echo __('calendar_price'); ?>:</label>
                    <span id="calendars_price"><?php echo $tpl['prices']['formated_calendars_price'] ?? ''; ?></span>
                </div> 
               
                <div class="form-group">
                    <label class="control-label" for=""><?php echo __('total_price'); ?>:</label>
                    <span id="total"><?php echo $tpl['prices']['formated_total'] ?? ''; ?></span>
                </div> -->

            <div class="form-group" style="display:none;">
                <label class="control-label" for=""><?php echo __('promo_code'); ?>:</label>                     
                <input class="form-control input-sm medium" type="text" name="promo_code" value="" id="promo_code" />
                <!-- <span class="error" id="invalid_promo_code" style="display: none;"><?php echo __('invalid_promo_code'); ?></span> -->
            </div>
        </div> 
    </div>
    <?php require __DIR__ . '/booking_form.php'; ?>
    <div class="box box-solid box-primary">
        <div class="box-body">
            <?php
            foreach ($_POST as $name => $value) {
                if (!in_array($name, array('confirm_code', 'Puja', 'Puja2', 'location', 'extra_id', 'captcha', 'additional', 'payment_method', 'cc_type', 'cc_num', 'cc_code', 'cc_exp_year', 'cc_exp_month', 'fax', 'country', 'zip', 'state', 'address_2', 'address_1', 'company', 'email', 'phone', 'second_name', 'first_name', 'male', 'title'))) {
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            ?>
                            <input type="hidden" name="<?php echo $name; ?>[]" value="<?php echo $v ?>" />
                            <?php
                        }
                    } else {
                        ?>
                        <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value ?>" />
                        <?php
                    }
                }
            }
            ?> 
            <a data-style="expand-left" href="javascript:" class="btn btn-default btn btn-danger ladda-button" id="back_to_calendar_id" autocomplete="off" value="<?php echo __('back'); ?>" name="back" tabindex="9" type="submit">
                <span class="ladda-label"><?php echo __('back'); ?></span>
                <span class="ladda-spinner"></span>
            </a>
            <a data-style="expand-left" href="javascript:" class="btn btn-warning ladda-button  <?php echo (!(count($_SESSION[$this->controller->default_product]['slots'][$_REQUEST['cid']] ?? []) > 0)) ? "disabled" : ""; ?>" id="details_frm_btn_id" autocomplete="off" value="<?php echo __('booking'); ?>" name="submit" tabindex="9" type="submit">
                <span class="ladda-label"><i class="fa fa-gavel"></i>&nbsp;&nbsp;&nbsp;<?php echo __('booking'); ?></span>
                <span class="ladda-spinner"></span>
            </a>
        </div>
    </div>
    <div id='div_session_write' name='div_session_write'></div>
</form>
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

    var select = document.getElementById("location");
    var textBoxElement = document.getElementById("address_1");

    function hideDiv() {
        // var selectedString = select.options[select.selectedIndex].value;
        let elem = document.getElementById("location")
        debugger;

        if (elem.value == "inside") {
            document.getElementById('hide1').style.display = 'block';
            document.getElementById('hide2').style.display = "none";
            document.getElementById('hide3').style.display = "none";
            textBoxElement.required = false;
            textBoxElement.style.border="";
            
            $("#Puja").prop('required', true);
            $("#Puja2").prop('required', false);
            $("#Puja3").prop('required', false);

        }
        
        if(elem.value == "outside")
        {
            document.getElementById('hide2').style.display = "block";
            document.getElementById('hide1').style.display = 'none';
            document.getElementById('hide3').style.display = "none";
            textBoxElement.required = true;
            
            $("#Puja2").prop('required', true);
            $("#Puja").prop('required', false);
            $("#Puja3").prop('required', false); 
        }

        if (elem.value == "wholeday")
        {
            document.getElementById('hide3').style.display = "block";
            document.getElementById('hide1').style.display = 'none';
            document.getElementById('hide2').style.display = 'none';
            textBoxElement.required = true;
            
            $("#Puja3").prop('required', true);
            $("#Puja").prop('required', false);
            $("#Puja2").prop('required', false);


        }
    }
    hideDiv()

    sessionStorage.setItem('EICEP', '');
    function populate(membership1)
    {
        debugger;

        var e = document.getElementById(membership1);
        var strUser = e.value;
        var pujaDetail = e.options[e.selectedIndex].text;
       // var pujaName = pujaDetail.split("...");
        var pujaName = pujaDetail.split("$");
        
        sessionStorage.setItem('EICEP', strUser);
        //document.getElementById("promo_code").value = pujaName[1];
          document.getElementById("promo_code").value = pujaName[0];

    }
    
    
function membercheck() {
    //debugger;
        var checkdata = $("#registrationmember").val();

        if (checkdata == "member") {
          document.getElementById('termdiv').style.display = "block";
          document.getElementById('memberidtd').style.display = "block";
                $("#first_name").val("");
                $("#second_name").val("");
                $("#phone").val("");
                $("#email").val("");
                $("#address_1").val("");
                $("#term").val("");
                $("#termMember").val("");
                $("#idmem").val("");
                $("#term").prop('required',true);
                $("#idmem").prop('required',true);

        } else
        {
            document.getElementById('termdiv').style.display = "none";
            document.getElementById('memberidtd').style.display = "none";
                $("#first_name").val("");
                $("#second_name").val("");
                $("#phone").val("");
                $("#email").val("");
                $("#address_1").val("");
                $("#term").val("");
                $("#termMember").val("");
                $("#idmem").val("");
                $("#term").prop('required',false);
                $("#idmem").prop('required',false);
                
             
        }
    }
    
    gz$(function(){
        gz$('input[type="text"]').change(function(){
        this.value = $.trim(this.value);
    });
    });
    
    gz$('#idmem').keydown(function(e) {
     e.preventDefault();
     return false;
    });
 
    gz$('#term').on('input', function() {
     gz$(this).val(gz$(this).val().replace(/[^a-z0-9]/gi, ''));
    });


    gz$(function() {
        gz$("#term").autocomplete({
        // source: "http://localhost/HDBS_Payment/PriestMember/ajax-db-search.php",
        // source: '<?= INSTALL_URL ?>ajax-db-search.php',
        // source: "http://localhost:8080/HDBS_Payment/priestModule/ajax-db-search.php",
        // source: 'https://durgabari.org/HDBS_PaymentNew/ajax-db-search.php',
         source: '<?= INSTALL_URL ?>ajax-db-search.php',
         minLength: 3,
        select: function( event, ui ) {
           
            event.preventDefault();
            gz$("#term").val(ui.item.value);
            gz$("#termMember").val(ui.item.id);
            MemberSelectPriest();
        },
        onclick: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelectPriest();
          
        },
        onchange: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
             MemberSelectPriest();
          
        },
    });
});


function MemberSelectPriest() {
    //debugger;
            var self = this;
            var serverurl = gz$("#server-id").text();
                var data = gz$("#termMember").val();
                const Memberid = data.split("-");
                if(data != "")
                  {  
         gz$.ajax({
             type: "POST",
             data: {
                 memberid: data
             },
             url: serverurl  +"load.php?controller=Donations&action=AllMemberNew&",
            success: function (res) {
                 debugger;
                 var Membertext = gz$("#MemberSelectValue").text();
                 document.getElementById("MemberSelect").value = Membertext;
                 let MemberName = "";
                
                   const memberNameElement = getSafeResponseInput(res, "MemberName", gz$);
                  if(memberNameElement.length){
                   MemberName = memberNameElement[0].value; 
                  }
                  document.getElementById("first_name").value = MemberName;

                 
                  let LastName = "";
                    const LastNameElement = getSafeResponseInput(res, "last_name", gz$);
                    if(LastNameElement.length){
                        LastName = LastNameElement[0].value; 
                       }
                   document.getElementById("second_name").value = LastName;



                  let memberid = "";
                  const memberElement = getSafeResponseInput(res, "memberid", gz$);
                 if(memberElement.length){
                  memberid = memberElement[0].value; 
                 }
                 document.getElementById("idmem").value = memberid;
     
     
                    let phoneNo = "";
                    let MNo="";
                     const phoneNoElement = getSafeResponseInput(res, "Tele1", gz$);
                    if(phoneNoElement.length){
                       phoneNo = phoneNoElement[0].value;
                       phoneNo= phoneNo.replace("-", "");
                       MNo = phoneNo; 
                       MNo=MNo.replace("-", ""); 
                    }
                    document.getElementById("phone").value = MNo;
     
                    let email = "";
                     const emailElement = getSafeResponseInput(res, "email", gz$);
                    if(emailElement.length){
                        email = emailElement[0].value; 
                    }
                    document.getElementById("email").value = email;

                   let street = "";
                   const streetElement = getSafeResponseInput(res, "ressidentalAddress", gz$);
                  if(streetElement.length){
                    street = streetElement[0].value; 
                  }
                  

                  let resaddress = "";
                   const resaddressElement = getSafeResponseInput(res, "Address", gz$);
                  if(resaddressElement.length){
                    resaddress = resaddressElement[0].value; 
                  }
                 

                  let state = "";
                  const stateElement = getSafeResponseInput(res, "state", gz$);
                 if(stateElement.length){
                   state = stateElement[0].value; 
                 }
               

                 let city = "";
                    const cityElement = getSafeResponseInput(res, "city", gz$);
                   if(cityElement.length){
                      city = cityElement[0].value; 
                   }
                   

                   let zipcode = "";
                    const zipcodeElement = getSafeResponseInput(res, "zip_code", gz$);
                   if(zipcodeElement.length){
                    zipcode = zipcodeElement[0].value; 
                   }
                   
                   document.getElementById("address_1").value = street.concat(" ",resaddress," ",state," ",city," ",zipcode);
     
                 }
             });
         }else{ 
             $("#MemberName").val("");
             $("#phone").val("");
             $("#email").val("");
     
         }
        }




</script>
