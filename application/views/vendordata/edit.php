<section class="content-header">
    <h1>
        <?php echo __('Vendor'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                <?php echo __('home'); ?>
            </a></li>
        <li><a href="<?php echo INSTALL_URL; ?>vendordata/index"><?php echo __('Vendor'); ?></a></li>
        <li class="active">
            <?php echo __('edit_vendor'); ?>
        </li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$state = $tpl['arr']['state'] ?? '';
$paymethod = $tpl['vendorinvoicedata']['pay_mode'] ?? '';
$paymentdata = '';
if ($paymethod == 'stripe') {
    $paymentdata = 'Credit Card';
} else if ($paymethod == "others") {
    $paymentdata = 'Zelle';
} else if ($paymethod == "cash") {
    $paymentdata = 'Cash';
} else if ($paymethod == "check") {
    $paymentdata = 'Check';
} else if ($paymethod == "directdeposit") {
    $paymentdata = 'Direct Deposit';
}
$paystatus = $tpl['vendorinvoicedata']['status'] ?? '';
?>
<form id="edit_vendordata" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>vendordata/edit"
    method="post" name="create">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <div class="padding-19">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1">
                        <?php echo __('Vendor Data'); ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                    <fieldset>
                        <section class="col-lg-7 connectedSortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Business Details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="first_name">
                                            <?php echo __('Owner Name'); ?>:
                                        </label>
                                        <input id="first_name" class="form-control input-sm" type="text"
                                            name="ownername" size="25" value="<?php echo $tpl['arr']['ownername'] ?? ''; ?>"
                                            title="OwnerName" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="first_name">
                                            <?php echo __('Business Name'); ?>:
                                        </label>
                                        <input id="first_name" class="form-control input-sm" type="text"
                                            name="businessname" size="25"
                                            value="<?php echo $tpl['arr']['businessname'] ?? ''; ?>" title="BusinessName"
                                            placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="first_name">
                                            <?php echo __('Tax ID'); ?>:
                                        </label>
                                        <input id="first_name" class="form-control input-sm" type="text" name="taxid"
                                            size="25" value="<?php echo $tpl['arr']['taxid'] ?? ''; ?>" title="TaxID"
                                            placeholder="">
                                    </div>
                                </div>
                        
                      
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Price Details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('Quantity'); ?>:
                                        </label>
                                        <input id="quantity" class="form-control input-sm" type="text"
                                            name="item_number" size="25"
                                            value="<?php echo $tpl['vendorinvoicedata']['item_number'] ?? ''; ?>"
                                            title="<?php echo __('Quantity'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="advanceamount">
                                            <?php echo __('Amount'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                            <input data-rule-required="true" id="advanceamount"
                                                class="form-control input-sm" type="text" name="item_cost" size="25"
                                                value="<?php echo $tpl['vendorinvoicedata']['item_cost'] ?? ''; ?>"
                                                title="Amount" placeholder="Amount" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="rentalprice">
                                            <?php echo __('Total Amount'); ?>:
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                            </span>
                                            <input id="rentalpricedata" class="form-control input-sm" type="number"
                                                name="amount" size="25"
                                                value="<?php echo $tpl['vendorinvoicedata']['amount'] ?? ''; ?>"
                                                title="<?php echo __('totalamount'); ?>" placeholder="Total Amount"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Payment Method'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="payment_method"><?php echo __('payment_method'); ?>:</label>
                                        <input data-rule-required="true" id="paymentmethod" class="form-control input-sm" type="text" name="pay_mode" size="25" value="<?php echo $paymentdata; ?>" title="Payment Method" readonly >
                                    </div>
                                    </div>
                                    </div>

                        </section>
<!--start #state -->

<section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('Payment details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Payment For'); ?>:
                                        </label>
                                        <input id="paymentfor" class="form-control input-sm" type="text" name="paytype"
                                            size="25" value="<?php echo $tpl['vendorinvoicedata']['paytype'] ?? ''; ?>"
                                            title="<?php echo __('paymentfor'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="paymentfor">
                                            <?php echo __('Type'); ?>:
                                        </label>
                                        <input id="type" class="form-control input-sm" type="text" name="item_desc"
                                            size="25" value="<?php echo $tpl['vendorinvoicedata']['item_desc'] ?? ''; ?>"
                                            title="<?php echo __('type'); ?>" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                            <label class="control-label" for="status">
                                                <?php echo __('Status'); ?>:
                                            </label>
                                            <select data-rule-required="true" name="status" id="status"
                                                class="form-control input-sm">
                                                <option value="">---</option>
                                                <?php
                                                $status_arr = __('status_arr');
                                                foreach ($status_arr as $k => $v) {
                                                    ?>
                                                    <option <?php echo ($tpl['vendorinvoicedata']['status'] == $k) ? "selected='selected'" : ""; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <input id="paymnentstatus" class="form-control input-sm" type="text" name="finalpaystatus"
                                            size="25" value="Paid"
                                            title="<?php echo __('Payment Status'); ?>" placeholder="" readonly style="display:none;">
                                        </div>
                                    
                                </div>
                        </section>

<!--end -->


                        <section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <?php echo __('User details'); ?>
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label" for="phone">
                                            <?php echo __('phone'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="phone"
                                            size="25" value="<?php echo $tpl['arr']['phone'] ?? ''; ?>" title="phone"
                                            maxlength="10" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="email">
                                            <?php echo __('email'); ?>:
                                        </label>
                                        <input id="phone" class="form-control input-sm" type="text" name="email"
                                            size="25" value="<?php echo $tpl['arr']['email'] ?? ''; ?>" title="email"
                                            placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="address_1">
                                            <?php echo __('Address'); ?>:
                                        </label>
                                        <input id="address_1" class="form-control input-sm" type="text" name="address"
                                            size="25" value="<?php echo $tpl['arr']['address'] ?? ''; ?>" title="Address"
                                            placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('City'); ?>:
                                        </label>
                                        <input id="city" class="form-control input-sm" type="text" name="city" size="25"
                                            value="<?php echo $tpl['arr']['city'] ?? ''; ?>" title="<?php echo __('City'); ?>"
                                            placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('State'); ?>:
                                        </label>
                                        <!-- <input id="state" class="form-control input-sm" type="text" name="state" size="25" value="<?php echo $tpl['arr']['state'] ?? ''; ?>" title="<?php echo __('State'); ?>" placeholder=""> -->
                                        <select required id="state" name="state" value="" class="form-control input-sm">
                                            <option value="">Please select State</option>
                                            <option value="AL">Alabama</option>
                                            <option value="AK">Alaska</option>
                                            <option value="AZ">Arizona</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="CA">California</option>
                                            <option value="CO">Colorado</option>
                                            <option value="CT">Connecticut</option>
                                            <option value="DE">Delaware</option>
                                            <option value="DC">District of Columbia</option>
                                            <option value="FL">Florida</option>
                                            <option value="GA">Georgia</option>
                                            <option value="HI">Hawaii</option>
                                            <option value="ID">Idaho</option>
                                            <option value="IL">Illinois</option>
                                            <option value="IN">Indiana</option>
                                            <option value="IA">Iowa</option>
                                            <option value="KS">Kansas</option>
                                            <option value="KY">Kentucky</option>
                                            <option value="LA">Louisiana</option>
                                            <option value="ME">Maine</option>
                                            <option value="MD">Maryland</option>
                                            <option value="MA">Massachusetts</option>
                                            <option value="MI">Michigan</option>
                                            <option value="MN">Minnesota</option>
                                            <option value="MS">Mississippi</option>
                                            <option value="MO">Missouri</option>
                                            <option value="MT">Montana</option>
                                            <option value="NE">Nebraska</option>
                                            <option value="NV">Nevada</option>
                                            <option value="NH">New Hampshire</option>
                                            <option value="NJ">New Jersey</option>
                                            <option value="NM">New Mexico</option>
                                            <option value="NY">New York</option>
                                            <option value="NC">North Carolina</option>
                                            <option value="ND">North Dakota</option>
                                            <option value="OH">Ohio</option>
                                            <option value="OK">Oklahoma</option>
                                            <option value="OR">Oregon</option>
                                            <option value="PA">Pennsylvania</option>
                                            <option value="RI">Rhode Island</option>
                                            <option value="SC">South Carolina</option>
                                            <option value="SD">South Dakota</option>
                                            <option value="TN">Tennessee</option>
                                            <option value="TX">Texas</option>
                                            <option value="UT">Utah</option>
                                            <option value="VT">Vermont</option>
                                            <option value="VA">Virginia</option>
                                            <option value="WA">Washington</option>
                                            <option value="WV">West Virginia</option>
                                            <option value="WI">Wisconsin</option>
                                            <option value="WY">Wyoming</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="membertype">
                                            <?php echo __('Zip'); ?>:
                                        </label>
                                        <input id="zip" class="form-control input-sm" type="text" name="zip" size="25"
                                            value="<?php echo $tpl['arr']['zip'] ?? ''; ?>"
                                            title="<?php echo __('Zip_Code'); ?>" placeholder="">
                                    </div>
                                </div>
                        </section>
                    </fieldset>
                </div>

                <fieldset class="form-actions">
                    <input type="hidden" name="edit_vendordata" value="1" />
                    <input type="hidden" name="vendorid" value="<?php echo $tpl['arr']['id'] ?? ''; ?>" /> 
                    <input type="hidden" name="vendorinvoiceid" value="<?php echo $tpl['vendorinvoicedata']['id'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="Submit" name="submit"
                        tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;
                        <?php echo __('save'); ?>
                    </button>
                </fieldset>

            </div>
        </div>
    </div>
</form>
<div id="dialogSlots" title="<?php echo __('tooltip_selected_slots'); ?>" style="display:none">
    <div name="dialogSlotsDivId" id="dialogSlotsDivId">
    </div>
</div>
<script>

    $(document).ready(function () {
        debugger;
        statedrop();
        var paymentstatus = <?php echo (json_encode($paystatus)); ?>;
        var paymentmethodtest = <?php echo (json_encode($paymethod)); ?>;
        
       if(paymentstatus == "confirmed"){
        $("#status").hide();
        $("#paymnentstatus").show();
       }
       else{
        $("#status").show();
        $("#paymnentstatus").hide();
       }
       
       const dropdown = document.getElementById("status");
       const optionToHide = dropdown.querySelector("option[value='confirmed']");
       optionToHide.style.display = "none";
    });
    var state = <?php echo (json_encode($state)); ?>;
    function statedrop() {
        if (state != null || state == "" || state == " ") {
            $("#state").val(state);

        }
    }
</script>