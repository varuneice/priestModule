<head>
   <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src=
        "https://malsup.github.io/jquery.blockUI.js">
    </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" /> 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
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
    .medium {
        width: 450px !important;
    }

    @media screen and (max-width: 992px) and (min-width: 500px) {
        #menu-container {
            width: 100% !important;
        }
    }
    .disabledbutton {
    pointer-events: none;
    opacity: 0.4;
}
</style>

<?php
$tpl['option_arr_values'] = array_merge(
    [
        'currency' => '',
        'stripe_allow' => '',
        'others_allow' => '',
        'paypal_allow' => '',
        'authorize_allow' => '',
        '2checkout_allow' => '',
        'pay_arrival_allow' => '',
        'credit_card_allow' => '',
        'bank_acount_allow' => '',
        'stripe_publish_key' => '',
    ],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);
if (!empty($_POST['create_Student'])) {
?>
<section class="content left width_100">
    <div class="padding-19 nav-tabs-custom left width_100">
        <?php
    if (!empty($_SESSION['status'])) {
            ?>
        <div class="alert alert-danger in">
            <strong>
                <?php echo $_SESSION['status']; ?>
            </strong>
        </div>
        <?php
        unset($_SESSION['status']);
    } else {

        if (($_POST['payment_method'] ?? '') == 'stripe') {
            $subject = unserialize($tpl['arr']['subject'] ?? '');
            $subject = is_array($subject) ? $subject : [];
            $newsubject = unserialize($tpl['arr']['type'] ?? '');
            $newsubject = is_array($newsubject) ? $newsubject : [];
             $datefor = $tpl['arr']['pay_date'] ?? '';
            $timestamp = !empty($datefor) ? strtotime($datefor) : false;
            $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : ''; 
                ?>
        <table border="4" width='585px' style="margin: 0 auto;">
            <tr>
                <!-- <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> -->
                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style="margin-left:14em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
            </tr>
            <tr>
                <td>Order ID</td> <td><?php echo $tpl['arr']['oid'] ?? ''; ?></td>
           </tr>
            <tr>
                
                <td>Member Id</td>
                    <td><?php echo $tpl['arr']['reg_uid'] ?? ''; ?></td>
            </tr> 
             <tr>
                <td>Member Name</td>
                <td>
                    <?php echo $tpl['arr']['membername'] ?? ''; ?>
                </td>
            </tr>
            <tr>
                <td>Registration Type</td>
                <td>
                    <?php echo $tpl['arr']['Registration_type'] ?? ''; ?>
                </td>
            </tr>
            <tr>
                <td>First Student Name</td>
                <td>
                    <?php echo $tpl['arr']['St_Name1'] ?? ''; ?>
                </td>
            </tr>
            <tr>
                <td>First Student Subject</td>
                <td>
                    <?php echo implode(',',$subject); ?>
                </td>
            </tr>
            <tr>
                <td>Second Student Name</td>
                <td>
                    <?php echo $tpl['arr']['St_Name2'] ?? ''; ?>
                </td>
            </tr>
            <tr>
                <td>Second Student Subject</td>
                <td>
                <?php echo implode(',',$newsubject); ?>
                    
                </td>
            </tr>
             <tr><td>Payment Method</td>
             <td><?php echo "Credit Card"; ?></td></tr>
            <tr>
                <td>Amount</td>
                <td>
                  <span style="color:red;">$</span><?php echo $tpl['arr']['totalamount'] ?? ''; ?>
                </td>
            </tr>
            <tr>
                <td>Transaction ID</td>
                <td>
                    <?php echo $tpl['arr']['transaction_id'] ?? ''; ?>
                </td>
            </tr>
            <tr>
                <td>Pay Date</td>
                <td>
                    <?php echo $payfinaldate; ?>
                </td>
            </tr>
            <tr>
                <td>Payment Status</td>
                <td>
                    <?php echo $tpl['arr']['payment_status'] ?? ''; ?>
                </td>
            </tr>
            <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
            </tr>
        </table>
        <?php echo "<a href='" . INSTALL_URL . "Student/create'>Go to home</a>";?> 
        <!-- <div class="payment_information">
                        <p class="error" style="font-weight: bold; font-size: 22px;"><?php echo __('payment_information'); ?></p>
                        <p><strong><?php echo __('reference_number'); ?>:</strong> <?php echo $tpl['arr']['uid'] ?? ''; ?></p>
                        <p><strong><?php echo __('transaction_id'); ?>:</strong> <?php echo $tpl['payment']['balance_transaction'] ?? ''; ?></p>
                        <p><strong><?php echo __('paid_amount'); ?>:</strong> <?php echo Util::currenctFormat($tpl['option_arr_values']['currency'] ?? '', $tpl['arr']['amount'] ?? ''); ?></p>
                    </div> -->
        <?php
        } else {
                    ?>
        <div class="alert alert-success  in">
            <i class="fa-fw fa fa-check"></i>
            <strong>
                <?php echo __('success'); ?>
            </strong>
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
<section class="content-header" style ="display:none;">
   <h1>
        <?php echo __('add_Student'); ?>
    </h1> 
    <?php if ($this->controller->isLoged()) { ?>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                <?php echo __('home'); ?>
            </a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Student/index">Students</a></li>
        <li class="active">
            <?php echo __('add_Student'); ?>
        </li>
    </ol>
    <?php } ?>
</section>
<?php
    require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
    ?>

<div id="menu-container" style=" margin:3px auto;  background-color:rgba(237,237,237) !important;">
    <div id="page-body">
        <main role="main">
            <div class="logo" style="background-color: #357ca5;">
                <img src="../logo.jpg" class="profile" />
                <h3><b>Houston Durga Bari Society</b></h3> 
                <h4 style="text-align:center;"><b>Contact: education@durgabari.org  </b></h4>
                <h1 class="logo-caption"><span class="tweak">E</span>ducation</h1>
            </div>
            <!-- logo class -->
            <!-- <form id="donation-frm-id" class="form-horizontal" method="post" action="" role="form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <input type="hidden" name="create_donation" value="1" />
                    <fieldset class="asb"> -->
            <form id="new_student" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Student/create"
                method="post" name="create" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <table class="table">
                    <tr class="tr">
                        <td class="td" style="width:25%;">
                           Registration Type
                        </td>
                        <td class="td" style="width:25%;">
                            <select  required="" name="Registration_type" id="registrationtype"
                                class="form-control input-sm" aria-required="true" >
                                <option value="">Please select Registration type</option>
                                <option value="BanglaSchool">Bangla School</option>
                                <option value="Kalabhavan">Kalabhavan</option>
                                 <option value="workshops">Workshops</option>
                                <option value="library">Library</option>

                            </select>
                        </td>
                        <td class="td" style="width:25%;" >Durga Bari Member</td>
                        <td class="td" style="width:25%;"><select required="" name="regmember" id="registrationmember"
                                class="form-control input-sm" aria-required="true" aria-invalid="false"  >
                           <option value="">Please select Member type</option>
                                <option value="member" <?php echo (!empty($_SESSION['otp_verified_member'])) ? 'selected' : ''; ?>>Yes</option>
                                <option value="nonmember">No</option>
                                 </select>
                                </td>
                    </tr>
                    <tr class="tr" id="otp-gate" style="display:none;">
                        <td class="td" colspan="4" style="padding:8px 12px;">
                            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;background:#f0f8ff;border:1px solid #b0d0f0;border-radius:5px;padding:8px 12px;">
                                <span><strong>Member Identity Verification:</strong></span>
                                <button type="button" id="otp-gate-btn" class="btn btn-info btn-sm">Verify via OTP</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="tr" id="otp-verified-banner" style="display:none;">
                        <td class="td" colspan="4" style="padding:8px 12px;">
                            <div style="display:flex;align-items:center;gap:8px;background:#eafaf1;border:1px solid #b7e4c7;border-radius:5px;color:#1e8449;font-size:13px;font-weight:600;padding:8px 12px;">
                                <i class="fa fa-check-circle" style="color:#276632;font-size:16px;"></i>
                                <span>Member verified and details auto-filled.</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="tr">
                    
                    <td class="td" id="namemeemberregister">Member Name</td>
                    
                    <td  id="IDMembertd"  class="disabledbutton">
                    <input type="text" name="Member_id" id="term" placeholder="search member here...." class="form-control">
                   
                    
                    </td>
                    <td class="td" id="nonmembername" style="display:none;">Full Name</td>
                    <td  id="fieldtest" style="display:none;"> 
                     <input id="namenonmember" class="form-control" type="text" name="namenonmember" placeholder="Full Name" >
                    </td>
                    <input type="text" style="display:none" name="termMember" id="termMember" placeholder="search member here...." class="form-control">  
                    
                    <!-- <br>  
                    <input type="text" name="Member_id" id="term1" placeholder="search member here...." class="form-control">  -->
              

                
                
                <td class="td">Member Id</td>
                <td class="td"><input type="number" name='demmember' id="demmember" class="form-control input-sm point"  oninvalid="InvalidMsg(this);"  oninput="InvalidMsg(this);" >
                </td> </tr>

                    <tr class="tr">
                    <td class="td">E-mail</td>
                        <td class="td"> <input required="" id="Your_E-mail" class="form-control input-sm" type="email"
                                pattern="[^@\s]+@[^@\s]+\.[^@\s]+" name="email" size="25" value=""
                                placeholder="name@company.com"></td>
                        <td class="td">Phone Number</td>
                        <td class="td"> <input required="" placeholder="###) ###-####" id="Your_Number" maxlength = "10" class="form-control input-sm" type="nubmer" name="phone_number" onchange="checkphoneno(this.id)"> </td>
                                
                    </tr>
                    <tr class="tr" >

                        <td class="td">Student 1 Name</td>
                        <td class="td"><input required="" id="FirstStudentName" class="form-control input-sm" type="text"
                                placeholder="Student 1 Name" value="" name="St_Name1" tabindex="2" required></td>

                        <td class="td"> Student 2 Name</td>
                        <td class="td"><input id="SecondStudentName" class="form-control input-sm" type="text"
                                placeholder="Student 2 Name" value="" name="St_Name2" tabindex="3"></td>
                    </tr>
                    <div id="allsubject">
                    <tr class="tr" id="subjectrow">
                        <td class="td">Student 1 Subject</td>
                        <td class="td">
                        <select required="" name='subject[]' id='typecheck'   class="form-control input-sm"
                                aria-required="true" aria-invalid="false" multiple  >
                            </select>
                        </td>
                       
                        <td class="td">Student 2 Subject</td>

                        <td class="td"> 
                            <select name="type[]" id="type1"
                                class="form-control input-sm" required="" aria-invalid="false" multiple disabled>
                            </select>
                        
                        </td>
                    </tr>
    </div>
     <tr class="tr"><td class="td" colspan = 3 style="color:red; text-align: center;">Max. 2 subjects for Kala Bhavan; $10 off for 2 subjects; <b>Use Ctrl to select 2nd subject</b></td>
     <td class="td">
     <input readonly class="form-control input-sm" type="text" placeholder="Category" id="cattype" name="cat" value="" /></tr>
    
                    <tr class="tr">
                    <td class="td">Fee &nbsp;&nbsp; <span style="color:red; font-size: 12px;">(Members get $25 off per subject)</span></td>
                    <td class="td"><select required="" name='fee' id='fee' class="form-control input-sm" aria-required="true" aria-invalid="false" >
                    <td class="td">Total Amount</td>
                    <!-- <td><input  required="" id="Amount" class="form-control input-sm" type="number" placeholder="$Amount"  value="" name="fee" tabindex="10"> </td> -->
                 <td class="td">
                    <div class="form-group" style="margin-top: 6px!important;margin-bottom: 2px;">
                    <div class="input-group">
                    <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                    <input readonly required=""  id="Amount" class="form-control input-sm" type="number" placeholder="$Amount" value="" name="totalamount" tabindex="10" >
                    </div>
                    </div>
                    </td>
        </tr>
        <tr style="display:none;"> <td class="td"> <input id="Your_Name" class="form-control input-sm" type="text" name="membername"> </td></tr>

                    <!-- ............Payment Section Start............-->
                <table class="table">
                    <tr class="tr">
                        <td class="td" colspan="2">
                           Payment Method
                        </td>
                        <td class="td" colspan="2">
                        <select required="" name="payment_method" id="payment_method"
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
                    <tr class="tr" id="MemberID1" style="display:none;">
                        <td class="td" colspan="4">
                            <div style="margin:6px 0;">
                                <label class="control-label"><strong>Zelle Payment Details:</strong></label>
                                <div id="error_code1" style="margin-bottom:8px;font-size:13px;color:#555;"></div>
                                <select id="zelleid" name="oid" class="form-control input-sm" style="display:none;font-weight:bold;">
                                    <option value="">Please select your Zelle transaction</option>
                                </select>
                                <div id="zelle-action-btns" style="display:none;margin-top:8px;">
                                    <button type="button" id="zelle-verify-btn" class="btn btn-success btn-sm">Verify Selected Transaction</button>
                                    <button type="button" id="zelle-retry-btn" class="btn btn-default btn-sm" style="margin-left:8px;">Search Manually</button>
                                </div>
                                <div id="zelle-manual-fields" style="display:none;margin-top:10px;">
                                    <div class="form-group">
                                        <label style="font-size:13px;">Your name as used in Zelle:</label>
                                        <input type="text" id="zelle_donor_name" class="form-control input-sm" placeholder="Full name used for Zelle transfer">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size:13px;">Payment Date (optional):</label>
                                        <input type="date" id="zelle_date" class="form-control input-sm" style="max-width:220px;">
                                    </div>
                                    <button type="button" id="checkPaymentData" class="btn btn-primary btn-sm">Verify Zelle Payment</button>
                                </div>
                                <div id="zelle-no-match" style="display:none;color:#c0392b;font-size:13px;margin-top:8px;padding:8px;background:#fdecea;border-radius:4px;">
                                    No Zelle transaction found. Please check your name and amount, or contact admin.
                                </div>
                                <input type="hidden" name="code" id="Zellecode" value="">
                                <div id="error_codeimg" style="display:none;"></div>
                            </div>
                        </td>
                    </tr>
                    <div id="zelle-modal-overlay"
                        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9100;justify-content:center;align-items:center;">
                        <div
                            style="background:#fff;border-radius:8px;width:660px;max-width:96vw;max-height:90vh;overflow-y:auto;box-shadow:0 8px 32px rgba(0,0,0,0.25);position:relative;font-family:Arial,sans-serif;">
                            <div
                                style="background:#357ca5;padding:16px 20px 12px;text-align:center;position:relative;border-radius:8px 8px 0 0;">
                                <button id="zelle-modal-close" type="button"
                                    style="position:absolute;top:10px;right:14px;background:none;border:none;color:#fff;font-size:24px;cursor:pointer;line-height:1;padding:0;opacity:0.85;">&times;</button>
                                <h4 style="color:#fff;margin:0;font-size:18px;font-weight:bold;">Pay via Zelle</h4>
                                <p style="color:rgba(255,255,255,0.88);margin:4px 0 0;font-size:13px;">Scan QR or send
                                    to treasurer@durgabari.org</p>
                            </div>
                            <div style="padding:20px 24px 10px;text-align:center;">
                                <img id="zelle-modal-img" src="" alt="Zelle QR Code"
                                    style="max-width:580px;width:100%;height:auto;border-radius:4px;">
                            </div>
                            <div style="padding:0 24px 16px;font-size:14px;color:#333;line-height:1.8;">
                                <b>Step 1</b> - Open your bank app and navigate to Zelle.<br>
                                <b>Step 2</b> - Send your student/library amount to <b>treasurer@durgabari.org</b>.<br>
                                <b>Step 3</b> - After sending, click <b>"I've Completed Zelle Payment"</b> below.
                            </div>
                            <div style="padding:0 24px 22px;display:flex;gap:12px;justify-content:center;">
                                <button id="zelle-modal-paid-btn" type="button" class="btn btn-primary"
                                    style="min-width:200px;font-size:15px;">I've Completed Zelle Payment</button>
                                <button id="zelle-modal-cancel-btn" type="button" class="btn btn-default"
                                    style="min-width:120px;font-size:15px;background:#f5f5f5;border:1px solid #ccc;">Cancel</button>
                            </div>
                        </div>
                    </div>
                            </table>
                    <!-- ........Payment Section End ...........-->
                    <tr>
                        <td>
                            <fieldset>
                                <input type="hidden" name="create_Student" value="1" />
                                <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                                <button id="reset-btn-id" class="btn btn-primary" autocomplete="off" value="Reset"
                                    name="reset-btn" tabindex="9" type="submit"><i
                                        class="fa fa-refresh"></i>&nbsp;&nbsp;Reset</button>
                                <button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save"
                                    name="pay" tabindex="9" type="submit"><i
                                        class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Make Payment</button>
                            </fieldset>
                        </td>
                    </tr>
                </table>
                <div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key'] ?? ''; ?> </div>
            </form>
<?php require __DIR__ . '/../components/otp_modal.php'; ?>
<div id="otp-session-verified" style="display:none"><?= htmlspecialchars($_SESSION['otp_verified_member'] ?? '') ?></div>
<?php if (!empty($_SESSION['otp_verified_member'])): ?>
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

$(function() {
    $('#otp-gate').hide();
    $('#otp-verified-banner').addClass('otp-show').css('display', 'table-row');
});
</script>
<?php endif; ?>
        </main>
    </div>
    <?php } ?>
</div>
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


var browser ="";
$(document).ready(function(){
   
  getMobileOperatingSystem()
});

$('#demmember').keydown(function(e) {
    e.preventDefault();
    return false;
});

$('#term').on('input', function() {
  $(this).val($(this).val().replace(/[^a-z0-9]/gi, ''));
});

function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;

    // Windows Phone must come first because its UA also contains "Android"
    if (/windows phone/i.test(userAgent)) {
        //alert("Windows Phone");
        browser="Windows Phone";
    }

    if (/android/i.test(userAgent)) {
       //alert("Android");
        browser="Android";
    }

    // iOS detection from: http://stackoverflow.com/a/9039885/177710
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        //alert("iOS");
        browser="iOS";
    }

    
}
$(function(){
if(browser=="Android"){
$("#typecheck").on('change', function(){
//alert("iOS");
        var typemember = $("#registrationmember").val();
         var type = $("#typecheck").val();
         if(type==""){
             document.getElementById("Amount").value = "";
         }
 

        var selected1 = [];
        for (var option of document.getElementById('typecheck').options) {
            if (option.selected) {
                selected1.push(option.value);
            }
        }
        subjectsecond = selected1;
 //alert(subjectsecond);
 // alert(selected1);
        var retype = $("#registrationtype").val();
        debugger;
        if (retype == 'BanglaSchool') {
              
            if (subjectsecond.length > 1) {
               
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            
            if (subjectsecond.length > 2) {
                 
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }

        debugger;
        var newsubjectrec = selcetsubj.concat(subjectsecond);
        var price = $("#fee").val();
        var cat = $("#cattype").val();
        if (selcetsubj.length > 1 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

            document.getElementById("Amount").value = totalprice;
            
        }
        else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
            var totalprice = amount;

            document.getElementById("Amount").value = totalprice;
           
        }
        else if (newsubjectrec.length > 3) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
            document.getElementById("Amount").value = totalprice;
         

        }
        else if (newsubjectrec.length > 2) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

            document.getElementById("Amount").value = totalprice;
        
        }
        else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
            var totalsub = selcetsubj.concat(subjectsecond);
            var courceCount = totalsub.length
            var amount = courceCount * price;
             var totalprice = amount - 10;

            document.getElementById("Amount").value = totalprice;
          
        }
    });
    
    $("#type1").on('change', function(){
//alert("iOS");
        var typemember = $("#registrationmember").val();
         var type = $("#type1").val();
         if(type==""){
             document.getElementById("Amount").value = "";
         }
 

        var selected1 = [];
        for (var option of document.getElementById('type1').options) {
            if (option.selected) {
                selected1.push(option.value);
            }
        }
        subjectsecond = selected1;
 //alert(subjectsecond);
 // alert(selected1);
        var retype = $("#registrationtype").val();
        debugger;
        if (retype == 'BanglaSchool') {
              
            if (subjectsecond.length > 1) {
               
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            
            if (subjectsecond.length > 2) {
                 
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }

        debugger;
        var newsubjectrec = selcetsubj.concat(subjectsecond);
        var price = $("#fee").val();
        var cat = $("#cattype").val();
        if (selcetsubj.length > 1 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

            document.getElementById("Amount").value = totalprice;
            
        }
        else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
            var totalprice = amount;

            document.getElementById("Amount").value = totalprice;
           
        }
        else if (newsubjectrec.length > 3) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
            document.getElementById("Amount").value = totalprice;
         

        }
        else if (newsubjectrec.length > 2) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

            document.getElementById("Amount").value = totalprice;
        
        }
        else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
            var totalsub = selcetsubj.concat(subjectsecond);
            var courceCount = totalsub.length
            var amount = courceCount * price;
             var totalprice = amount - 10;

            document.getElementById("Amount").value = totalprice;
          
        }
    });
   }


});



 document.getElementById("typecheck").addEventListener('keydown', function (e) {
        if(event.shiftKey){
    alert("Use Ctrl to select 2nd subject");
        return false;
    }
    else if (event.ctrlKey && event.shiftKey && event.keyCode==73){        
             return false;
    }
})
document.getElementById("type1").addEventListener('keydown', function (e) {
        if(event.shiftKey){
    alert("Use Ctrl to select 2nd subject");
        return false;
    }
    else if (event.ctrlKey && event.shiftKey && event.keyCode==73){        
             return false;
    }
})

$(function(){
    $('input[type="text"]').change(function(){
        this.value = $.trim(this.value);
    });
});
     
$(function() {
    $("#term").autocomplete({
        //source: "http://localhost/HDBS_Payment/PriestMember/ajax-db-search.php",
        source: '<?= INSTALL_URL ?>ajax-db-search.php',
        select: function( event, ui ) {
            event.preventDefault();
           // $("#term").val(ui.item.value);
            //$("#termMember").val(ui.item.id);
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            document.getElementById("type1").value = "";
            document.getElementById("typecheck").value = "";
		    document.getElementById("FirstStudentName").value = "";
		   document.getElementById("SecondStudentName").value = "";
		   document.getElementById("Amount").value = "";
            MemberSelectStudent();
        },
            onclick: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelectStudent();
        },
        onchange: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelectStudent();
        },
  });
});

    const phoneInputField = document.querySelector("#Your_Number");
      const phoneInput = window.intlTelInput(phoneInputField, {
        // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
        preferredCountries: ["us", "co", "in", "de"],
        utilsScript:
          "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      });
      
      function MemberSelectStudent() {
            //debugger
            var self = this;
            var term = $("#termMember").val();
            var data = $("#termMember").val();
			var url2 = $("#container-abc-url-id").text(); 
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
                        const memberNameElement = getSafeResponseInput(res, "MemberName", $);
                        if (memberNameElement.length) {
                            MemberName = memberNameElement[0].value;
                        }

                        let LastName = "";
                        const LastNameElement = getSafeResponseInput(res, "last_name", $);
                        if (LastNameElement.length) {
                            LastName = LastNameElement[0].value;
                        }
                        document.getElementById("Your_Name").value = MemberName.concat(" ", LastName);
                        //    document.getElementById("second_name").value = LastName;



                        let memberid = "";
                        const memberElement = getSafeResponseInput(res, "memberid", $);
                        if (memberElement.length) {
                            memberid = memberElement[0].value;
                        }
                        document.getElementById("demmember").value = memberid;


                        let phoneNo = "";
                        let MNo = "";
                        const phoneNoElement = getSafeResponseInput(res, "Tele1", $);
                        if (phoneNoElement.length) {
                            phoneNo = phoneNoElement[0].value;
                            phoneNo = phoneNo.replace("-", "");
                            MNo = phoneNo;
                            MNo = MNo.replace("-", "");
                        }
                        document.getElementById("Your_Number").value = MNo;

                        let email = "";
                        const emailElement = getSafeResponseInput(res, "email", $);
                        if (emailElement.length) {
                            email = emailElement[0].value;
                        }
                        document.getElementById("Your_E-mail").value = email;
                        
                        
                        let cat1 = "";
                        const catElement = getSafeResponseInput(res, "membercategory", $);
                        if (catElement.length) {
                            cat1 = catElement[0].value;
                        }
                           // var cat = $("#cat").val(cat1);
                        document.getElementById("cattype").value = cat1;
                    }
                });
            } else {
                $("#MemberName").val("");
                $("#phone").val("");
                $("#Your_E-mail").val("");

            }
        }


function checkphoneno(elem){
        //debugger;
    const phonenumber =  $("#Your_Number").val();
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
            $("#Your_Number").prop('required',true);
            $("#payment_btn_id").removeClass('disabled');
        }
     }

function InvalidMsg(textbox) {
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

     </script>
