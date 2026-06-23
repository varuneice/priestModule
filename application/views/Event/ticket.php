<head>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
 
  <!-- <link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
    rel="stylesheet" type="text/css" />
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"></script> -->
  
  
  <link href="<?= INSTALL_URL ?>Multi/styles/multiselect.css" rel="stylesheet"/>
	<script src="<?= INSTALL_URL ?>Multi/multiselect.min.js"></script>
  <script src="<?= INSTALL_URL ?>application/web/js/otp-member-verify.js?v=<?= time() ?>"></script>
</head>
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
.point{
    pointer-events: none;
    opacity: 0.3;
    }
    .multiselect-checkbox{
        margin:15px;
    }
    .multiselect-wrapper ul li.active {
    background-color: white!important;
    color: white;
}
    .multiselect-wrapper .multiselect-list .multiselect-checkbox {
    margin-right: 20px;
    margin-left: 5px;
}
    .body{
        padding:0px;
        margin:0px;
    }
    .logo .profile {
        margin-left: 50%;
        border-radius: 25%;
        transform: translate(-50%);
        filter: brightness(123%);
        padding: 10px;

    } 
    .logo .logo-caption {
        font-family: 'Poiret One', cursive;
        color: #FFFFFF;
        text-align: center;

    }
    .logo-caption .h1 {
        font-size:2.5rem;;
    }

    #Amount {
        margin-left: 0px;

    } 
    h3{

        /* font-size:30px; */
        color: #FFFFFF;
        font-weight: 400;
        margin-left:4%;
        font-family: initial;
        line-height: normal;
    }
    h4{
    text-align: center;
    color: #FFFFFF;
    font-family: initial;
}
    .logo .tweak {
        color: #ff5252;
        font-weight: bold;
    }
    .abd{
        font-weight: bold;
        font-family: 'Poiret One', cursive;
        font-size:20px;
        color:00000;
    }
    .btn-custom {
        background: #ff5252;
        border-color: rgba(48, 46, 45, 1);
        color: #ffffff;
        font-weight: bold;
        font-size:20px;
        width: -webkit-fill-available;
    }
    .btn-custom:hover{
        -webkit-transition: all 500ms ease;
        -moz-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
        transition: all 500ms ease;
        background: rgba(48, 46, 45, 1);
        border-color: #ff5252;
    }
    .footer {
        padding-top: 10px;
        margin-left: 15%;
        width: 85%;
        background: #111111;
        position: relative;
        bottom: 0;
        z-index: 1;
    }
    .form-group label {
        display: inline-block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-control {
        background-color: #f9fcfa;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgb(0 0 0 / 8%) inset;
        color: #555;
        display: block;
        font-size: 14px;
        height: 34px;
        line-height: 1.42857;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        width: 100%;
    }
    .form-horizontal .form-group {
        margin: 10px;
    }
    .asb {
        border-width: 0;
        border: 0 none;
        margin: 0;
        padding: 0;
    }
    .text-center{
        text-align:center;
    }
    .btn.btn-primary {
        background-color: #00a5c5;
        border-color: #367fa9;
        color: #fff;
        font-size: 20px;
    }
    #dataimg {
        display: block;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
    /*height: 233px;*/
}
     /* #dataimg{ 
        height:100%;
        width:100%; 
    }  */
@media screen and (max-width: 992px) {
    #menu-container{
        width: 90% !important;
    }
}
/* .column {
  float: left;
  width: 33.33%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
} */
#dataimg {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
}
.disabledbutton {
    pointer-events: none;
    opacity: 0.4;
}
</style>
<?php
 require_once APP_PATH . 'helpers/uploader/class.upload.php';

$eventimage =  $tpl['ticketEventname'][0]['ticketavatar'];
$allprice = $tpl['Eventname'] ?? [];

$test = array_column($allprice, 'price');



if (!empty($_POST['create_ticket'])) {
    ?>
    <section class="content left width_100">
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

                if (($_POST['PaymentOption'] ?? '') == 'stripe') {
                    ?>
                     <table border="4" width='585px' style= "margin-left:424px;" >
                                 <tr>
                                 <!-- <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> </tr> -->
                                 <td colspan='2'> <img src='../thankyouscreeniamge.jfif' alt='' height='167px' style="margin-left:12em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                <tr>
                                <tr><td>Name</td> <td><?php echo $tpl['arr']['MemberName'] ?? ''; ?></td></tr>
                                <tr><td>Amount</td> <td><?php echo $tpl['arr']['totaldonation'] ?? ''; ?></td></tr>
                                <tr><td>Transaction ID</td> <td><?php echo $tpl['arr']['transaction_id'] ?? ''; ?></td></tr>
                                <tr><td>Payment Status</td> <td><?php echo $tpl['arr']['payment_status'] ?? ''; ?></td></tr>
                                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                                </tr> 
                        </table>
                        <?php echo "<a href='" . INSTALL_URL . "Event/event'>Go to home</a>";?> 
                    <!--div class="payment_information">
                        <p class="error" style="font-weight: bold; font-size: 22px;"><?php echo __('payment_information'); ?></p>
                        <p><strong><?php echo __('reference_number'); ?>:</strong> <?php echo $tpl['arr']['uid'] ?? ''; ?></p>
                        <p><strong><?php echo __('transaction_id'); ?>:</strong> <?php echo $tpl['payment']['balance_transaction'] ?? ''; ?></p>
                        <p><strong><?php echo __('paid_amount'); ?>:</strong> <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'] ?? '', $tpl['arr']['amount'] ?? 0); ?></p>
                    </div-->
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
    <div id="menu-container" style="width:54%; margin:3px auto;  background-color:rgba(237,237,237) !important;">
        <div id="page-body">
            <main role="main">
                <div class="logo" style="background-color: #357ca5;">
                    <img src="../logo.jpg" class="profile"/>
                    <h3><b>Houston Durga Bari Society</b></h3>
                      <h4><b>Contact: treasurer@durgabari.org </b></h4>
                    <h1 class="logo-caption" ><span class="tweak">T</span>ickets<span class="" id="evenam"></span></h1>
                </div> 
                <!-- logo class -->
                <form id="donation-frm-id" class="form-horizontal" method="post" action="" role="form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <input type="hidden" name="create_ticket" value="1" />
                    <fieldset class="asb">

                    <!-- <div class="row" id="imageevent" style="display:none;">
                    <div class="column">
                    <img id="dataimg" src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . ($tpl['Eventname']['avatar'] ?? ''); ?>" />
                      </div>
                      <div class="column">
                    <textarea id="description" class="form-control input-sm" name="descriptionTable" value="" placeholder="Description............. "rows="4" cols="50"></textarea> </div>
                    </div>
                    &nbsp; -->
                   <?php if ($eventimage !== null) { ?>  
                    <table class="table">
                    
                    <tr class="tr" id="imageevent" style="display : none;">
                    <td class="td" style="width : 50%;">
                    <img id="dataimg" src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . ($tpl['Eventname']['avatar'] ?? ''); ?>" />
                    </td>
                    <td class="td" style="width : 50%;">
                    <div readonly id="description" class="form-control input-sm" name="descriptionTable"  value="" placeholder="Description............. "rows="4" cols="50" style="height: 242px;border-radius: 9px;border: 1px solid mediumorchid;"></div> </td>
                    </tr>&nbsp;
                    </table>
                    <?php
                } else {
                    ?>
                    <table class="table">
                    <tr class="tr" id="imageevent" style="display : none;">
                    <td class="td" style="width :1000px!important;">
                    <div readonly id="description" class="form-control input-sm" name="descriptionTable"  value="" placeholder="Description............. "rows="4" cols="50" style="height: 242px;border-radius: 9px;border: 1px solid mediumorchid;"></div> </td>
                    </tr>&nbsp;
                    </table>
                    <?php
                }
                ?>


                    <table class="table">
                   <tr class="tr">
                        <td class="td">Event Type <span style="color:#ff0000">*</span></td>
                        <td class="td">
                        <input readonly id="eventtype" class="form-control input-sm" type="text" placeholder="Event Name" value="" name="type">
                         </td>
                         <td class="td" >Durga Bari Member</td>
                        <td class="td"><select required="" name="regmember" id="registrationmember"
                                class="form-control input-sm" aria-required="true" aria-invalid="false" >
                         <option value="">Please select Member type</option> 
                                <option value="member">Yes</option>
                                <option value="nonmember">No</option>
                                 </select>
                                </td>
                     </tr>
                     <tr class="tr">                          
                         <td class="td" id="namemeemberregister">Member Name<span style="color:#ff0000">*</span></td>
                    <td  id="IDMembertd"  class="disabledbutton" style="border: 1px;">                        
                       
                        <input type="text" name="Member_id" id="term" placeholder="search member here...."  class="form-control" tabindex="2">

                    </td>

                     <td class="td" id="nonmembername" style="display:none;">Full Name</td>
                       <td  id="fieldtest" style="display:none;"> 
                         <input id="namenonmember" class="form-control" type="text" name="namenonmember" placeholder="Full Name" >
                      </td>

                    <input type="text" style="display:none" name="termMember" id="termMember"  placeholder="search member here...." class="form-control">
                         
                    <td class="td">Member Id</td>
                     <td class="td"><input type="number" name='demmember' id="demmember" class="form-control input-sm point"  oninvalid="InvalidMsg(this);"  oninput="InvalidMsg(this);" tabindex="3" >                                
                    </td> 
                    
                                </tr>
                    <tr class="tr">  
                    <td class="td">Email <span style="color:#ff0000">*</span></td>
                            <td class="td"><input required="" id="Email" class="form-control input-sm" placeholder="name@company.com" type="text" placeholder="Email" value="" name="email"  size="25" value="<?php echo $tpl['arr']['email'] ?? ''; ?>" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" tabindex="4" required></td> 
                                                    
                            <td class="td"> Phone Number</td>
                        <td class="td"> <input  id="Tele1" class="form-control input-sm" type="text"  name="tele" size="25" value="<?php echo $tpl['arr']['Tele1'] ?? ''; ?>"  placeholder="### ###-####" tabindex="5" required onchange="sponsorphone(this.id)" maxlength="10"></td> 
                    </tr>

                    <tr class="tr">
                        <td class="td">Event Day</td>          
                        <td class="td">
                       <!-- <select class="form-control input-sm" id="ticketday" name="itemeventday" tabindex="6" onChange="eventdaydropdown(this.id)" multiple>    </select>    -->
                       <!-- new -->
                       
                       <!--28apr-->
                        <!--<select  id="ticketday" name="itemeventday" class="form-control input-sm"  style="width:100%!important;  height:50%;"  multiple required oninvalid="InvalidMsgticketday(this);"  oninput="InvalidMsgticketday(this);">-->
                        
                         <select  id="ticketday" name="itemeventday" class="form-control input-sm"  style="width:100%!important;  height:50%;"   required oninvalid="InvalidMsgticketday(this);"  oninput="InvalidMsgticketday(this);">
                        
                            <?php
                            // foreach ($tpl['ticketeventprice'] as $key => $value) {
                            //     ?>
                            
                                <!--<option value="<?php echo $value['ticketprice'].','.$value['itemeventday']; ?>"><?php echo $value['itemeventday']; ?></option> -->
                            //     <?php
                            // }
                            
                            $value['ticketprice'] = "30";
                                        $value['itemeventday'] = "Saturday 05/24/2025";
                                        $value['itemeName'] = "Day pass ";

                                        $value['ticketprice2'] = "30";
                                        $value['itemeventday2'] = "Sunday 05/25/2025";
                                        $value['itemeName2'] = "Day pass ";

                                        $value['ticketprice3'] = "50";
                                        $value['itemeventday3'] = "Saturday 05/24/2025 and Sunday 05/25/2025 ";
                                        $value['itemeName3'] = "Season Pass ";

                                        $value['ticketprice4'] = "100";
                                        $value['itemeventday4'] = "Saturday 05/24/2025 and Sunday 05/25/2025";
                                        $value['itemeName4'] = "Sponsorship category ";

                                        echo '<option value="' . $value['ticketprice'] . ',' . $value['itemeventday']." ".$value['itemeName'] . '">' . $value['itemeName']  ."(". $value['itemeventday'].")" ." Price- $30".   '</option>';
                                        echo '<option value="' . $value['ticketprice2'] . ',' . $value['itemeventday2']." ".$value['itemeName2']. '">' . $value['itemeName2'] ."(". $value['itemeventday2'].")"  ." Price- $30". '</option>';
                                        echo '<option value="' . $value['ticketprice3'] . ',' . $value['itemeventday3']." ".$value['itemeName3']. '">'. $value['itemeName3'] ."(".  $value['itemeventday3'].")" ." Price- $50". '</option>';
                                        echo '<option value="' . $value['ticketprice4'] . ',' . $value['itemeventday4']." ".$value['itemeName4']. '">'. $value['itemeName4']."(". $value['itemeventday4'] .")" ." Price- $100". '</option>';
                            
                            
                            ?>
                            
                            
                            </select>    
                        </td> 
                        <td class="td">Quantity</td>
                            <td class="td"><input required="" id="quantity" class="form-control input-sm" type="number" placeholder="Quantity"  value="" name="item_number" tabindex="7" onChange="ticketqunatity()" min="0" oninput="validity.valid||(value='');"></td> 
                        </tr>
                  
                  
                    <tr class="tr">                          
                            <td class="td">Ticket Amount<span style="color:#ff0000">*</span></td>
                        <td class="td"><input readonly required="" id="Amount" class="form-control input-sm" type="number" placeholder="$Amount"  value="" name="item_cost" tabindex="8"></td> 
                         <td class="td">Extra Donation</td>
            <td class="td"><input id="extraamount" class="form-control input-sm" type="number" placeholder="$Amount"
                    value="" name="extradonation" tabindex="12" onchange="sponsoramount(this.id)" min="0" oninput="validity.valid||(value='');"></td>
            </td>
                    </tr>
                        <tr class="tr">  
                        <td class="td">Total Amount</td>
                            
                        <td class="td">
<div class="form-group">

<div class="input-group">
 <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
 <input readonly required="" id="totalamount" class="form-control input-sm" type="number" placeholder="$Amount"  value="" name="amount" tabindex="9">
  </div>
 </div>
 </td>
 <td class="td" colspan=2>
            <textarea id="description" class="form-control input-sm" name="remarks" value="" placeholder="Additional Comments"  style="border: 1px solid mediumvioletred; height:100px; resize: none;"></textarea>
            </td>
                    </tr>

                    <div id="payment-method-wrapper" style="display:block;">
                        <table class="table">
                            <tr class="tr">
                                <td class="td" colspan="2">
                                   Payment Method<span style="color:#ff0000">*</span>
                                </td>
                                <td class="td" colspan="2">
                                <select required="" name="PaymentOption" id="PaymentOption"
                                        class="form-control input-sm" aria-required="true" aria-invalid="false"
                                        style="width:100%;  height:50%;">
                                        <option value="" class="amd">---</option>
                                        <?php
                                        $payment_method_arr = __('payment_method_arr');
                                        foreach ($payment_method_arr as $k => $v) {
                                            if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                                ?>
                                        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
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
                        <tr class="tr" id="MemberID1" style="display:none;">
                            <td class="td" colspan="4">
                                <select id="MemberID" name="oid" class="form-control input-sm"
                                    style="display:none;font-weight:bold;margin-bottom:6px;">
                                    <option value="">Please select your Zelle transaction</option>
                                </select>
                                <div id="zelle-action-btns" style="display:none;margin-bottom:6px;">
                                    <button type="button" id="zelle-retry-btn" class="btn btn-default btn-sm" style="background:#f5f5f5;border:1px solid #ccc;font-weight:bold;">Retry</button>
                                </div>
                                <div id="zelle-manual-fields" style="display:none;">
                                    <div style="margin-bottom:6px;display:flex;gap:6px;flex-wrap:wrap;align-items:center;">
                                        <input type="text" id="zelle_donor_name" class="form-control input-sm"
                                            placeholder="Your name as sent in Zelle" autocomplete="off" style="flex:2;min-width:160px;">
                                        <input type="date" id="zelle_date" class="form-control input-sm"
                                            title="Transaction date (optional)" style="flex:1;min-width:130px;">
                                        <button type="button" id="checkPaymentData" class="btn btn-primary btn-sm" style="white-space:nowrap;">Verify Zelle Payment</button>
                                    </div>
                                    <div id="zelle-no-match" style="display:none;color:#c0392b;font-size:13px;margin-bottom:6px;">
                                        No matching Zelle transaction found. Please check your name, amount, and date.
                                    </div>
                                </div>
                                <div id="error_code1" style="margin-top:6px;font-size:13px;"></div>
                                <div id="error_codeimg"></div>
                            </td>
                        </tr>
                    </table>
                            </table>
                        <div class="form-group">
                            <button id="reset-btn-id" class="btn btn-primary" autocomplete="off" value="Save" name="Reset" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Reset</button>
                            <button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save" name="Payment" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Make Payment</button>
                        </div>
                        <tr><td class="td"> <input id="Your_Name" class="form-control input-sm" type="text" name="MemberName" style="display:none;"> </td></tr>
                        <tr><td class="td"> <input id="Days" class="form-control input-sm" type="text" name="Daysticket" style="display:none;"> </td></tr>
                          <tr style="display:none;"> <td class="td"> <input id="Zellecode" class="form-control input-sm" type="text" name="code" style="display:none;"> </td>
                           <td class="td"> <input id="ticketeventid" class="form-control input-sm" type="texyt" name="ticketuniqueeventid"
                    style="display:none;"> </td>
                          </tr> 
                        
                    </fieldset>
                    <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                </form>
<?php require __DIR__ . '/../components/otp_modal.php'; ?>
<div id="otp-session-verified" style="display:none"><?= htmlspecialchars($_SESSION['otp_verified_member'] ?? '') ?></div>
<div id="zelle-modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9100;justify-content:center;align-items:center;">
    <div style="background:#fff;border-radius:8px;width:660px;max-width:96vw;max-height:90vh;overflow-y:auto;box-shadow:0 8px 32px rgba(0,0,0,0.25);position:relative;font-family:Arial,sans-serif;">
        <div style="background:#357ca5;padding:16px 20px 12px;text-align:center;position:relative;border-radius:8px 8px 0 0;">
            <button id="zelle-modal-close" type="button" style="position:absolute;top:10px;right:14px;background:none;border:none;color:#fff;font-size:24px;cursor:pointer;line-height:1;padding:0;opacity:0.85;">&times;</button>
            <h4 style="color:#fff;margin:0;font-size:18px;font-weight:bold;">Pay via Zelle</h4>
            <p style="color:rgba(255,255,255,0.88);margin:4px 0 0;font-size:13px;">Send to treasurer@durgabari.org</p>
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
            </main>
        </div>
    </div>
<?php } ?>
<div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key'] ?? ''; ?></div>
<div id="account_type" style="display: none"><?php echo $tpl['account_type'] ?? 'Eventaccount'; ?></div>

<script>
   // debugger;
   document.multiselect('#ticketday')
		.setCheckBoxClick("checkboxAll", function(target, args) {
			//console.log("Checkbox 'Select All' was clicked and got value ", args.checked);
		})
		.setCheckBoxClick("1", function(target, args) {
            //console.log("Checkbox for item with value '1' was clicked and got value ", args.checked);
        });

	function enable() {
		document.multiselect('#ticketday').setIsEnabled(true);
	}

	function disable() {
		document.multiselect('#ticketday').setIsEnabled(false);
	}


     const phoneInputField = document.querySelector("#Tele1");
      const phoneInput = window.intlTelInput(phoneInputField, {
        // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
        preferredCountries: ["us", "co", "in", "de"],
        utilsScript:
          "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      });

     function sponsorphone(elem){
        //debugger;
    const phonenumber =  $("#Tele1").val();
        if(!!phonenumber){
         if(isNaN(phonenumber)){  
            alert("Please Enter mobile Number");
            $("#payment_btn_id").addClass('disabled');
            //document.getElementById("totalamount").value = price; 
         }
         else if(phonenumber.length > 10 ){
              alert("Number should be 10 digits");
              $("#payment_btn_id").addClass('disabled');  
         }
         else if(phonenumber.length < 10){
            alert("Number should be 10 digits");
            $("#payment_btn_id").addClass('disabled');  
         }
         else if(phonenumber.length == 10){  
            $("#payment_btn_id").removeClass('disabled');
         }
         else{
            $("#payment_btn_id").removeClass('disabled');
         }
        }
        else{
            $("#Tele1").prop('required',true);
            $("#payment_btn_id").removeClass('disabled');
        }
     }

////Lookup autocomplete for member search
    $(function () {
        // Always compute base URL from window.location — splits on '/Event/' to get root
        var baseUrl = window.location.href.split('/Event/')[0] + '/';
        $("#term").autocomplete({
            source: baseUrl + 'ajax-db-search.php',
            select: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                MemberSelectticketevent();
            },
            onclick: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                MemberSelectticketevent();
            },
            onchange: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                MemberSelectticketevent();
            },
        });
    });
    ////Lookup End

//function autocomplete

     function MemberSelectticketevent() {
         var url2 = $("#container-abc-url-id").text(); 
            //debugger
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
                        //debugger;
                        //var Membertext = $("#MemberSelectValue").text();
                        //document.getElementById("MemberSelect").value = Membertext;
                        let MemberName = "";
                        const memberNameElement = $(res).filter("input#MemberName");
                        if (memberNameElement.length) {
                            MemberName = memberNameElement[0].value;
                        }
                        let LastName = "";
                        const LastNameElement = $(res).filter("input#last_name");
                        if (LastNameElement.length) {
                            LastName = LastNameElement[0].value;
                        }
                      document.getElementById("Your_Name").value =  MemberName.concat(" ", LastName);
    
                        // let MemberfullName= "";
                        // const MemberfullNameElement = $(res).filter("input#MemberName");
                        // if (MemberfullNameElement.length) {
                        //     MemberfullName = MemberfullNameElement[0].value;
                        // }
                        
                        
                        
                        let memberid = "";
                        const memberElement = $(res).filter("input#memberid");
                        if (memberElement.length) {
                            memberid = memberElement[0].value;
                        }
                        document.getElementById("demmember").value = memberid;
                        // if(memberid != ""){
                        // document.getElementById("demmember").value = memberid;
                        // var url ="https://durgabari.org/HDBS_PaymentNew/Member/membermaintenance/" +memberid
                        // window.location.assign(url);
                        // }
                        let phoneNo = "";
                        const phoneNoElement = $(res).filter("input#Tele1");
                       if(phoneNoElement.length){
                          phoneNo = phoneNoElement[0].value; 
                       }
                       document.getElementById("Tele1").value = phoneNo;
                       
                       let email = "";
                       const emailElement = $(res).filter("input#email");
                      if(emailElement.length){
                          email = emailElement[0].value; 
                      }
                      document.getElementById("Email").value = email;
    
    
                    }
                });
            } else {
                $("#MemberName").val("");
                $("#phone").val("");
                $("#MemberName").val("");
                $("#memberid").val("");
                 $("#Tele1").val("");
                 $("#Email").val("");
    
            }
        }
        }

       function ticketqunatity() {
          //debugger;
            //var ticketdaynew = $("#ticketday").text();
                var ticketweekprice = $("#ticketday").val();
                var titketquantity = $("#quantity").val();
                $("#extraamount").val("");
                if(ticketweekprice == null){
                alert('Please Select Event Day First')
                $("#quantity").val("");
                $("#Amount").val("");
                $("#totalamount").val("");
                $("#extraamount").val("");
                }
                if(ticketweekprice != null){
             debugger;
                var selected = [];
                var selectedday = [];
                for (var option of document.getElementById('ticketday').options)
                {
                    if (option.selected) {
                        var d=option.value.split(',');
                        selected.push(d[0]);
                        selectedday.push(d[1]);
                    }
                }
                
                selecetday = selected;
                var sum = 0;
                for (i = 0; i < selecetday.length; i++) {
                    sum += parseInt(selected[i]);
                     
                    } 
                    var finalamount = sum * parseInt(titketquantity);
                    document.getElementById("Amount").value = sum;  
                    document.getElementById("totalamount").value = finalamount;
                    document.getElementById("Days").value = selectedday; 
                }
            }


function sponsoramount(elem) {
        //debugger;
        const sponsoramount = parseInt($("#extraamount").val());
        const amounttotal = parseInt($("#totalamount").val());
        const ticketamount = parseInt($("#Amount").val());
        const quantity = parseInt($("#quantity").val());
        
            if(quantity == ""){
            alert("Please fill Event day/ Quantity");
                $("#totalamount").val("");
                $("#extraamount").val("");
            }

        if (isNaN(sponsoramount)) {

           ticketqunatity();
        }
        else {

            var selected = [];
                var selectedday = [];
                for (var option of document.getElementById('ticketday').options)
                {
                    if (option.selected) {
                        var d=option.value.split(',');
                        selected.push(d[0]);
                        selectedday.push(d[1]);
                    }
                }
                
                selecetday = selected;
                var sum = 0;
                for (i = 0; i < selecetday.length; i++) {
                    sum += parseInt(selected[i]);
                     
                    } 
                    var finalamount = sum * parseInt(quantity);
                    const totalpriceticket = sponsoramount + finalamount;
                    document.getElementById("Amount").value = sum;

                    document.getElementById("totalamount").value = totalpriceticket;
                    document.getElementById("Days").value = selectedday; 
                }
            

        }

function InvalidMsg(textbox) {
    //debugger
    
var selectValmember = $('#registrationmember').val();
            if (selectValmember != "nonmember") {
  if (textbox.value === '') {
textbox.setCustomValidity('Please search the name in the autocomplete of member name and select name.');
$('#demmember').addClass('point')      
          
  } else {
      textbox.setCustomValidity('');
      $('#demmember').addClass('point')    
  }
}else{
    textbox.setCustomValidity('');
    $('#demmember').addClass('point')    
}
  return true;
            
}


// start alert for if event day field null
    function InvalidMsgticketday(textbox) {
    //debugger;
    // chnage on 28 apr
    ticketqunatity();
    var ticketdaydate = $('#ticketday').val();
    if (ticketdaydate == null) {
      if (textbox.value === '') {
     alert('Please Select Event Day Test.');

      }
    }else{
        textbox.setCustomValidity('');
       //$('#ticketday').addClass('point')
    }
      return true;

    }
    // end
</script>

// ── Ticket Zelle + OTP Flow ──────────────────────────────────────────────────
<script>
(function ($) {
    var otpVerifiedMemberId = $('#otp-session-verified').text().trim();
    var otpSessionVerified  = !!otpVerifiedMemberId;

    function autoFillMemberById(memberId) {
        var url2 = $('#container-abc-url-id').text();
        $('#term').val('Loading…');
        $.ajax({
            type: 'POST',
            data: { memberid: memberId },
            url: url2 + 'load.php?controller=Donations&action=AllMemberNew',
            success: function (res) {
                var firstName = '', lastName = '', el;
                el = $(res).filter('input#MemberName'); if (el.length) firstName = el[0].value;
                el = $(res).filter('input#last_name');  if (el.length) lastName  = el[0].value;
                var fullName = (firstName + ' ' + lastName).trim();
                $('#term').val(fullName);
                $('#termMember').val(memberId);
                document.getElementById('Your_Name').value = fullName;
                el = $(res).filter('input#memberid'); if (el.length) document.getElementById('demmember').value = el[0].value;
                el = $(res).filter('input#Tele1');    if (el.length) document.getElementById('Tele1').value    = el[0].value;
                el = $(res).filter('input#email');    if (el.length) document.getElementById('Email').value    = el[0].value;
            }
        });
    }

    $(document).off('change', '#registrationmember');
    $('#registrationmember').off('change').on('change', function (event) {
        event.stopImmediatePropagation();
        var selectVal = $('#registrationmember').val();
        if (selectVal === 'member') {
            $('#IDMembertd').find(':input').prop('disabled', false);
            $('#IDMembertd').removeClass('disabledbutton');
            document.getElementById('term').value = '';
            document.getElementById('Tele1').value = '';
            document.getElementById('Email').value = '';
            document.getElementById('namenonmember').value = '';
            $('#otp-verified-banner').removeClass('otp-show');

            if (otpSessionVerified) {
                $('#otp-verified-banner').addClass('otp-show');
                autoFillMemberById(otpVerifiedMemberId);
                return;
            }

            OtpMemberVerify.open({
                onVerified: function (memberId) {
                    otpSessionVerified = true;
                    otpVerifiedMemberId = memberId;
                    $('#otp-session-verified').text(memberId || '');
                    $('#otp-verified-banner').addClass('otp-show');
                    autoFillMemberById(memberId);
                }
            });

            window.onOtpModalCancelled = function () {
                $('#registrationmember').val('');
                $('#IDMembertd').find(':input').prop('disabled', true);
                $('#IDMembertd').addClass('disabledbutton');
            };
        } else {
            $('#IDMembertd').find(':input').prop('disabled', true);
            $('#IDMembertd').addClass('disabledbutton');
            document.getElementById('term').value = '';
            document.getElementById('Tele1').value = '';
            document.getElementById('Email').value = '';
            document.getElementById('namenonmember').value = '';
            $('#otp-verified-banner').removeClass('otp-show');
            if (selectVal !== 'nonmember') {
                otpSessionVerified = false;
                otpVerifiedMemberId = '';
                $('#otp-session-verified').text('');
            }
        }
    });

    // ── Zelle flow ────────────────────────────────────────────────────────────
    $(function () {
        var url = $('#container-abc-url-id').text();

        // Payment option change
        $('#PaymentOption').on('change', function () {
            var val = $(this).val();
            if (val === 'others') {
                $('#others_details').hide();
                $('#stripe_details').hide();
                $('#MemberID').empty().append('<option value="">Please select your Zelle transaction</option>');
                $('#zelle-no-match').hide();
                $('#payment_btn_id').prop('disabled', true).addClass('disabled');
                $('#zelle-modal-overlay').css('display', 'flex');
                $.post(url + 'load.php?controller=GzFront&action=importZelleAndSearch', {});
            } else if (val === 'stripe') {
                $('#others_details').hide();
                $('#stripe_details').show();
                $('#MemberID1').hide();
                $('#MemberID').hide().prop('required', false);
                $('#payment_btn_id').prop('disabled', false).removeClass('disabled');
            } else {
                $('#stripe_details').hide();
                $('#others_details').hide();
                $('#MemberID1').hide();
                $('#MemberID').hide().prop('required', false);
                $('#zelle-no-match').hide();
                $('#payment_btn_id').prop('disabled', false).removeClass('disabled');
            }
        });

        $('#zelle-modal-paid-btn').on('click', function () {
            $('#zelle-modal-overlay').hide();
            doZelleImportSearch();
        });

        $('#zelle-modal-cancel-btn, #zelle-modal-close').on('click', function () {
            $('#zelle-modal-overlay').hide();
            $('#PaymentOption').val('').trigger('change');
            $('#payment_btn_id').prop('disabled', false).removeClass('disabled');
        });

        // Retry button
        $('#zelle-retry-btn').on('click', function () {
            $('#zelle-action-btns').hide();
            $('#zelle-manual-fields').show();
            $('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
            $('#zelle-no-match').hide();
            $('#payment_btn_id').prop('disabled', true).addClass('disabled');
        });

        // Manual verify button
        $('#checkPaymentData').on('click', function () {
            var donorName = $.trim($('#zelle_donor_name').val());
            var zelleAmt  = $.trim($('#totalamount').val());
            var zelleDate = $.trim($('#zelle_date').val());
            if (!donorName) { alert('Please enter your name as used in Zelle.'); $('#zelle_donor_name').focus(); return; }
            if (!zelleAmt)  { alert('Please enter the ticket amount first.'); return; }
            $('#zelle-no-match').hide();
            $('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
            $('#payment_btn_id').prop('disabled', true).addClass('disabled');
            $.ajax({
                type: 'POST',
                url: url + 'load.php?controller=GzFront&action=importZelleAndSearch&account=' + encodeURIComponent($.trim($('#account_type').text())),
                data: { donor_name: donorName, zelle_amount: zelleAmt, zelle_date: zelleDate },
                success: function (res) {
                    var trimmed = $.trim(res);
                    if (!trimmed || trimmed === 'NO_MATCH') { $('#zelle-no-match').show(); return; }
                    var $opts = $(trimmed);
                    $('#MemberID').empty().append('<option value="">Please select your Zelle transaction</option>').append($opts).show();
                    $('#zelle-action-btns').show();
                    $('#zelle-manual-fields').hide();
                    if ($opts.length === 1) { $('#MemberID').val($opts.first().val()).trigger('change'); }
                },
                error: function () { alert('Could not verify Zelle payment. Please try again.'); }
            });
        });

        // Dropdown change — validate amount match
        $('#MemberID').on('change', function () {
            var dd = $(this).val();
            if (!dd) return;
            var parts  = dd.split('/');
            var cmCode = parts[3];
            var price  = parseFloat((parts[2] || '').replace(/[$,\s]/g, ''));
            var tot    = parseFloat($.trim($('#totalamount').val()).replace(/[$,\s]/g, ''));
            if (cmCode) { $('#Zellecode').val(cmCode); }
            if (!isNaN(tot) && !isNaN(price) && tot === price) {
                $('#payment_btn_id').prop('disabled', false).removeClass('disabled');
            } else {
                $('#payment_btn_id').prop('disabled', true).addClass('disabled');
                if (dd) { alert('Selected Zelle amount does not match the ticket amount. Please select the correct transaction.'); }
            }
        });

        function doZelleImportSearch() {
            var zelleAmt = $.trim($('#totalamount').val());
            if (!zelleAmt) { alert('Please wait for the ticket amount to load.'); return; }

            var regVal    = $('#registrationmember').val();
            var donorName = '';
            if (regVal === 'member') {
                donorName = $.trim($('#Your_Name').val());
                if (!donorName) {
                    $('#MemberID1').show(); $('#zelle-manual-fields').show(); $('#zelle-action-btns').hide();
                    $('#error_code1').css({'display':'block','color':'#c0392b'}).html('Please complete OTP verification first, then search your Zelle transaction manually below.');
                    return;
                }
            } else if (regVal === 'nonmember') {
                donorName = $.trim($('#namenonmember').val());
                if (!donorName) {
                    $('#MemberID1').show(); $('#zelle-manual-fields').show(); $('#zelle-action-btns').hide();
                    $('#error_code1').css({'display':'block','color':'#c0392b'}).html('Please enter your full name above, then search your Zelle transaction manually below.');
                    $('#namenonmember').focus(); return;
                }
            } else {
                $('#MemberID1').show(); $('#zelle-manual-fields').show(); $('#zelle-action-btns').hide();
                $('#error_code1').css({'display':'block','color':'#c0392b'}).html('Please select whether you are a Durga Bari member, then search your Zelle transaction manually below.');
                $('#registrationmember').focus(); return;
            }

            $('#error_code1').css({'display':'block','color':'#357ca5'}).html('<i class="fa fa-spinner fa-spin"></i> Searching your Zelle transaction…');
            $('#MemberID1').show();
            $('#zelle-no-match').hide();
            $('#MemberID').hide().empty().append('<option value="">Please select your Zelle transaction</option>');
            $('#payment_btn_id').prop('disabled', true).addClass('disabled');

            var today = new Intl.DateTimeFormat('en-CA', {
                timeZone: 'America/Chicago',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }).format(new Date());
            $.ajax({
                type: 'POST',
                url: url + 'load.php?controller=GzFront&action=importZelleAndSearch&account=' + encodeURIComponent($.trim($('#account_type').text())),
                data: { donor_name: donorName, zelle_amount: zelleAmt, zelle_date: today },
                success: function (res) {
                    var trimmed = $.trim(res);
                    if (!trimmed || trimmed === 'NO_MATCH') {
                        $('#error_code1').css('color','#c0392b').html('Transaction not found. Enter your name and date above, then click <b>Verify Zelle Payment</b>.');
                        if (donorName) { $('#zelle_donor_name').val(donorName); }
                        $('#MemberID1').show(); $('#zelle-manual-fields').show(); $('#zelle-action-btns').hide();
                        return;
                    }
                    var $opts = $(trimmed);
                    $('#MemberID').append($opts).show();
                    $('#MemberID1').show(); $('#zelle-action-btns').show(); $('#zelle-manual-fields').hide();
                    if ($opts.length === 1) {
                        $('#MemberID').val($opts.first().val()).trigger('change');
                        $('#error_code1').css('color','#276632').html('<i class="fa fa-check-circle"></i> Zelle transaction matched and selected automatically.');
                    } else {
                        $('#error_code1').css('color','#276632').html('Multiple possible matches found. Please select your transaction.');
                    }
                },
                error: function () {
                    $('#error_code1').css('color','#c0392b').html('Could not search Zelle transactions. Enter your name and date below to search manually.');
                }
            });
        }
    });
}(jQuery));
// ── End Ticket Zelle + OTP Flow ───────────────────────────────────────────────
</script>
