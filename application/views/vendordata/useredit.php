<style>
    .profile {
    margin-left: 50%;
    border-radius: 25%;
    transform: translate(-50%);
    filter: brightness(94%);
    padding: 10px;
    height: 166px;
}
#gz-time-slot-booking-container-id > aside > section > div > span {
display:none;
}
</style>
<?php
if (!empty($_POST['edit_vendoruserdata'])) {
    ?>
    <section class="content left width_100" >
        <div class="padding-19 nav-tabs-custom left width_100">
            <?php
            if (!empty($_SESSION['status'])) {
                ?>
                <div class="alert alert-danger in">
                    <strong><?php echo $_SESSION['status']; ?></strong>
                </div>
                <?php
                unset($_SESSION['status']);
            } else {
                if (($_POST['pay_mode'] ?? '') == 'stripe') {
                    $mainpaytype = $_POST['paytype'] ?? '';
                    if($mainpaytype == "OTHADV"){
                        $paymentfor = 'Other Advertisements' ;
                        }
                        elseif($mainpaytype == "BOOTH"){
                         $paymentfor =  'Booth Rentals';
                        }
                        elseif($mainpaytype == "MAGADV"){
                          $paymentfor = 'Magazine Advertisements';
                            }
                    ?>
                     <table border="4" width='585px' style= "margin-left:26em;" >
                                 <tr>
                                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style="margin-left:14em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                            </tr>
                                <tr>
                                <tr><td style="width:50%">Order Id</td> <td style="width:50%"><?php echo $_POST['oid'] ?? '';?></td></td></tr>
                                <tr><td>Owner Name</td> <td><?php echo $tpl['vendordetails']['ownername'] ?? '';?></td></td></tr>
                                <tr><td>Business Name</td> <td><?php echo $tpl['vendordetails']['businessname'] ?? ''; ?></td></tr>
                                <tr><td>Tax Id</td> <td><?php echo $tpl['vendordetails']['taxid'] ?? ''; ?></td></tr>
                                <tr><td>Payment For</td> <td><?php echo $paymentfor; ?></td></tr>
								<tr><td>Type</td> <td><?php echo $_POST['item_desc'] ?? ''; ?></td></tr>
                                <tr><td>Payment Method</td> <td><?php echo "Credit Card"; ?></td></tr>
                                <tr><td>Quantity</td> <td><?php echo $_POST['item_number'] ?? ''; ?></td></tr>
                                <tr><td>Amount</td> <td><span style="color:red;">$</span><?php echo $_POST['item_cost'] ?? ''; ?></td></tr>
								<tr><td>Total Amount</td> <td><span style="color:red;">$</span><?php echo $_POST['amount'] ?? ''; ?></td></tr>
                                
                                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                            </tr> 
                        </table> 
                        
                    <?php
                } else if(($_POST['pay_mode'] ?? '') == 'others'){
                     $mainpaytype = $_POST['paytype'] ?? '';
                    if($mainpaytype == "OTHADV"){
                        $paymentfor = 'Other Advertisements' ;
                        }
                        elseif($mainpaytype == "BOOTH"){
                         $paymentfor =  'Booth Rentals';
                        }
                        elseif($mainpaytype == "MAGADV"){
                          $paymentfor = 'Magazine Advertisements';
                            }
                    ?>
                     <table border="4" width='585px' style= "margin-left:23em;" >
                                 <tr>
                                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style="margin-left:14em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                            </tr>
                                <tr>
                                <tr><td style="width:50%;">Order Id</td> <td style="width:50%;"><?php echo $_POST['oid'] ?? '';?></td></td></tr>
                                <tr><td>Owner Name</td> <td><?php echo $tpl['vendordetails']['ownername'] ?? '';?></td></td></tr>
                                <tr><td>Business Name</td> <td><?php echo $tpl['vendordetails']['businessname'] ?? ''; ?></td></tr>
                                <tr><td>Tax Id</td> <td><?php echo $tpl['vendordetails']['taxid'] ?? ''; ?></td></tr>
                                <tr><td>Payment For</td> <td><?php echo $paymentfor; ?></td></tr>
								<tr><td>Type</td> <td><?php echo $_POST['item_desc'] ?? ''; ?></td></tr>
                                <tr><td>Payment Method</td> <td><?php echo "Zelle"; ?></td></tr>
                                <tr><td>Quantity</td> <td><?php echo $_POST['item_number'] ?? '';; ?></td></tr>
                                <tr><td>Amount</td> <td><span style="color:red;">$</span><?php echo $_POST['item_cost'] ?? ''; ?></td></tr>
                                <tr><td>Total Amount</td> <span style="color:red;">$</span><td><?php echo $_POST['amount'] ?? ''; ?></td></tr>
								
                                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                            </tr> 
                        </table> 
                        
                    <?php

                } else {
                    ?>
                    <div class="alert alert-success  in">
                        <i class="fa-fw fa fa-check"></i>
                        <strong><?php echo __('success'); ?></strong>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <?php
} else {
    ?>

<section class="content-header" style="display:none;">
    <h1>
        <?php echo __('Vendor'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>vendordata/index"><?php echo __('Vendor'); ?></a></li>
        <li class="active"><?php echo __('edit_vendor'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$state = $tpl['arr']['state'] ?? ''; 
$paymentstatus = $tpl['vendorinvoicedata']['status'] ?? ''; 
?>
<form id="edit_vendoruserdata" class="frm-class booking-frm-class" action="<?php echo INSTALL_URL; ?>vendordata/useredit" method="post" name="edit_vendoruserdata">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
<td colspan='2'>
     <img src="<?= INSTALL_URL ?>thankyouscreen.jpg" class="profile" />
     <h2  style="text-align:center;font-family:fangsong; font-size:30px;margin-top:-10px;">HDBS Vendor Payment</h2>
    </td> 
<div class="padding-19">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#tab_1"><?php echo __('pay_details'); ?></a>
                </li>
                 </ul>
            <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                    <fieldset>
                        <section class="col-lg-7 connectedSortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('Vendor Details'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                <div class="form-group">
                            <label class="control-label" for="first_name"><?php echo __('Owner Name'); ?>:</label>
                            <input id="first_name" class="form-control input-sm" type="text" name="ownername" size="25" value="<?php echo $tpl['arr']['ownername'] ?? ''; ?>" title="OwnerName" placeholder="">
                        </div>

                                    <div class="form-group">
                            <label class="control-label" for="first_name"><?php echo __('Business Name'); ?>:</label>
                            <input id="first_name" class="form-control input-sm" type="text" name="businessname" size="25" value="<?php echo $tpl['arr']['businessname'] ?? ''; ?>" title="BusinessName" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="first_name"><?php echo __('Tax ID'); ?>:</label>
                            <input id="first_name" class="form-control input-sm" type="text" name="taxid" size="25" value="<?php echo $tpl['arr']['taxid'] ?? ''; ?>" title="TaxID" placeholder="">
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
                                    <label class="control-label" for="membertype"><?php echo __('Quantity'); ?>:</label>
                                    <input id="quantity" class="form-control input-sm" type="text" name="item_number" size="25" value="<?php echo $tpl['vendorinvoicedata']['item_number'] ?? ''; ?>" title="<?php echo __('Quantity'); ?>" placeholder="" readonly>
                                        </div>


                                    <div class="form-group">
                                        <label class="control-label" for="advanceamount"><?php echo __('Amount'); ?>:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                            <input data-rule-required="true" id="advanceamount" class="form-control input-sm" type="text" name="item_cost" size="25" value="<?php echo $tpl['vendorinvoicedata']['item_cost'] ?? ''; ?>" title="Amount" placeholder="Amount" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                     <label class="control-label" for="rentalprice"><?php echo __('Total Amount'); ?>:</label>
                                     <div class="input-group">
                                     <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                                     <input id="totalitemcost" class="form-control input-sm" type="number" name="amount" size="25" value="<?php echo $tpl['vendorinvoicedata']['amount'] ?? ''; ?>" title="<?php echo __('totalamount'); ?>" placeholder="Total Amount" readonly>
                                    </div>
</div>
                                </div>
                            </div>

                            <div class="form-group" style="display:none;">
                                    <label class="control-label" for=""><?php echo __('Zellecode'); ?>:</label>                     
                                    <input class="form-control input-sm medium" type="text" name="zellecode" value="" id="Zellecode" />
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
                                    <div class="form-group" id="paymentdropdown">
                                        <label class="control-label" for="payment_method"><?php echo __('payment_method'); ?>:</label>
                                        <select data-rule-required="true" name="pay_mode" id="payment_method" class="form-control input-sm" required>
                                            <option value="">Please Select Payment Method</option>
                                            <?php
                                $payment_method_arr = __('payment_method_arr');
                                foreach ($payment_method_arr as $k => $v) {
                                    if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                        ?>
                                <option  value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                                    }
                                }
                                ?>
                                        </select>
                                    </div>
                                </div>
                                <table class="table">
                <tr id="stripe_details" class="tr" style="display: none;">
                        <td class="td" colspan="4">
                            <div class="form-group">
                                <label for="card-element">
                                    Credit or debit card
                                </label>
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display Element errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>            
                        
                        </td>
                    </tr>
                    <tr id="others_details" style="display: none;">
                        <td class="td" colspan="4">
                            <div class="form-group">
                                <label class="control-label"
                                    for="confirm_code"><?php echo __('confirm_code'); ?>:</label>
                                <input data-rule-required='true' id="confirm_code" class="form-control input-sm"
                                    type="text" name="confirm_code" size="25" value=""
                                    title="<?php echo __('confirm_code'); ?>"
                                    placeholder="<?php echo __('confirm_code'); ?>">
                                <div class="control-group"></div>
                                <div id="error_code"></div>
                            </div>
                        </td>
                    </tr>
                    <table class="table">
                    <tr class="tr"  id="MemberID1" style="display: none;" class="form-group">
                    <label class="control-label" for="F_Name" style="color:white !important;">Payment Details:</label>
                    <!-- <td  class="td" colspan="2" class="auto-widget"> -->
                    <td class="td"><button style="display: none;float:left!important;" type="button" id="checkPaymentData" >Get Zelle Payment Details</button></td>
                    <!-- <input data-rule-required='true' id="MemberID" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>"> -->
                    <td  class="td" colspan="3"><select data-rule-required='true' id="MemberID" name="oid"  class="form-control input-sm" style="font-weight: bold;float:right!important;">
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
                    </td>
                    <!-- </td> -->
                
                    </tr>
            </table>
                    <table class="table">
                    <tr>
                <td id="error_code1"></td>
                <!-- <td id="error_code"></td> -->
                <td id="error_codeimg"></td>
                     </tr>
                    </table>
                            </table>
                                
                                <fieldset class="form-actions">
                                <input type="hidden" name="edit_vendoruserdata" value="1" /> 
                                   <!-- <input type="hidden" name="id" value="<?php echo $tpl['arr']['id'] ?? ''; ?>" /> -->
                                    <input type="hidden" name="vendorid" value="<?php echo $tpl['arr']['id'] ?? ''; ?>" /> 
                                    <input type="hidden" name="vendorinvoiceid" value="<?php echo $tpl['vendorinvoicedata']['id'] ?? ''; ?>" />
                                     <input type="hidden" name="custid" value="<?php echo $tpl['vendorinvoicedata']['custid'] ?? ''; ?>" />
                                     <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                                    <td><button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save" name="Payment" tabindex="17" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Make Payment</button></td>
                                
                                </fieldset>
                                
                            </div>
                           
                            <!--<div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key'] ?? ''; ?></div>-->
                            
                            <div id="stripe_secret_key_id" style="display:none;">
                                        <?php
                                        if ($tpl['account_type'] == 'Pujaaccount') {
                                            echo $tpl['StripePublishedApiKey'];
                                        } else {
                                            echo $tpl['option_arr_values']['stripe_publish_key'] ?? '';
                                        }
                                        ?>
                                    </div>


                                    <div id="account_type" style="display : none">
                                        <?php echo ($tpl['account_type']); ?>
                                    </div>
                
                        </section>
<!-- Avinashstart #state -->

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
                                            <label class="control-label" for="status"><?php echo __('Status'); ?>:</label>
                                            <input id="status" class="form-control input-sm" type="text" name="status" size="25" value="<?php echo $tpl['vendorinvoicedata']['status'] ?? ''; ?>" title="<?php echo __('status'); ?>" placeholder="Status" readonly>

                                        </div>
                                    
                                </div>
                        </section>

<!-- Avinash end -->





                        <section class="col-lg-5 connectedSortable ui-sortable">
                            <div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo __('User details'); ?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">

                        <div class="form-group">
                            <label class="control-label" for="phone"><?php echo __('phone'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="phone" size="25" value="<?php echo $tpl['arr']['phone'] ?? ''; ?>" title="phone" maxlength="10" placeholder="">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email"><?php echo __('email'); ?>:</label>
                            <input id="phone" class="form-control input-sm" type="text" name="email" size="25" value="<?php echo $tpl['arr']['email'] ?? ''; ?>" title="email" placeholder="">
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="address_1"><?php echo __('Address'); ?>:</label>
                            <input id="address_1" class="form-control input-sm" type="text" name="address" size="25" value="<?php echo $tpl['arr']['address'] ?? ''; ?>" title="Address" placeholder="">
                        </div>

                                        <div class="form-group">
                                    <label class="control-label" for="membertype"><?php echo __('City'); ?>:</label>
                                    <input id="city" class="form-control input-sm" type="text" name="city" size="25" value="<?php echo $tpl['arr']['city'] ?? ''; ?>" title="<?php echo __('City'); ?>" placeholder="">
                                        </div>
                                        
                                        <div class="form-group">
                                    <label class="control-label" for="membertype"><?php echo __('State'); ?>:</label>
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
                                    <label class="control-label" for="membertype"><?php echo __('Zip'); ?>:</label>
                                    <input id="zip" class="form-control input-sm" type="text" name="zip" size="25" value="<?php echo $tpl['arr']['zip'] ?? ''; ?>" title="<?php echo __('Zip_Code'); ?>" placeholder="">
                                        </div>
                            </div>
                        </section>
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
<?php } ?> 
<script>
    
    $( document ).ready(function() {
        statedrop();
        paydropdown();
    });
var state = <?php echo(json_encode($state)); ?>;
function statedrop(){
    if(state != null || state == "" || state == " "){
      $("#state").val(state);

   }
}

var paystatus = <?php echo(json_encode($paymentstatus)); ?>;
function paydropdown(){
    debugger;
    if(paystatus == 'confirmed' || paystatus == 'pending'){
      $("#paymentdropdown").hide();
		
   }
   if(paystatus == 'Active'){
    $("#paymentdropdown").show();
   }
}
</script>