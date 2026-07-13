<head>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="<?= INSTALL_URL ?>application/web/js/otp-member-verify.js?v=2"></script>
</head>
<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .point {
        pointer-events: none;
        opacity: 0.3;
    }

    .body {
        padding: 0px;
        margin: 0px;
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
        font-size: 2.5rem;
        ;
    }

    h3 {

        /* font-size:30px; */
        color: #FFFFFF;
        font-weight: 400;
        margin-left: 4%;
        font-family: initial;
        line-height: normal;
    }

    h4 {
        text-align: center;
        color: #FFFFFF;
        font-family: initial;
    }

    .logo .tweak {
        color: #ff5252;
        font-weight: bold;
    }

    .abd {
        font-weight: bold;
        font-family: 'Poiret One', cursive;
        font-size: 20px;
        color: 00000;
    }

    .btn-custom {
        background: #ff5252;
        border-color: rgba(48, 46, 45, 1);
        color: #ffffff;
        font-weight: bold;
        font-size: 20px;
        width: -webkit-fill-available;
    }

    .btn-custom:hover {
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

    .text-center {
        text-align: center;
    }

    .btn.btn-primary {
        background-color: #00a5c5;
        border-color: #367fa9;
        color: #fff;
        font-size: 20px;
    }

    @media screen and (max-width: 992px) {
        #menu-container {
            width: 90% !important;
        }
    }

    .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }
</style>
<?php
if (!empty($_POST['create_donation'])) {
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
                    $datefor = $tpl['arr']['pay_date'] ?? '';
                    $timestamp = !empty($datefor) ? strtotime($datefor) : false;
                    $payfinaldate = $timestamp ? date("m/d/Y", $timestamp) : '';
                    ?>
                    <table border="4" width='585px' style="margin-left:30em;">
                        <tr>
                            <!-- <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> </tr> -->
                            <!-- <td colspan='2'> <img src='../create.png' alt='' height='102px' ></td>-->
                            <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style="margin-left:12em;">
                                <h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari
                                        Society</b></h1>
                            </td>

                        </tr>
                        <tr>
                        <tr>
                            <td style="width:50%;">Order ID</td>
                            <td style="width:50%;"><?php echo $tpl['arr']['oid'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Member Id</td>
                            <td><?php echo $tpl['arr']['Member_id'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td><?php echo $tpl['arr']['MemberName'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Donation Amount</td>
                            <td><span style="color:red;">$</span><?php echo $tpl['arr']['Amount'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Purpose</td>
                            <td><?php echo $tpl['arr']['purpose'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td><?php echo "Credit Card"; ?></td>
                        </tr>
                        <tr>
                            <td>Transaction ID</td>
                            <td><?php echo $tpl['arr']['transaction_id'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Pay Date</td>
                            <td><?php echo $payfinaldate; ?></td>
                        </tr>
                        <tr>
                            <td>Payment Status</td>
                            <td><?php echo $tpl['arr']['payment_status'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        </tr>
                    </table>

                    <?php echo "<a href='" . INSTALL_URL . "Donations/donation'>Go to home</a>"; ?>
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
                    <img src="../logo.jpg" class="profile" />
                    <h3><b>Houston Durga Bari Society</b></h3>
                    <h4><b>Contact: treasurer@durgabari.org </b></h4>
                    <h1 class="logo-caption"><span class="tweak">D</span>onation</h1>
                </div>
                <!-- logo class -->
                <form id="donation-frm-id" class="form-horizontal" method="post" action="" role="form">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <input type="hidden" name="create_donation" value="1" />
                    <fieldset class="asb">
                        <table class="table">
                            <tr class="tr">
                                <td class="td" style="width:25%;">Durga Bari Member</td>
                                <td class="td" style="width:25%;"><select required="" name="regmember"
                                        id="registrationmember" class="form-control input-sm" aria-required="true"
                                        aria-invalid="false">
                                        <option value="">Please select Member type</option>
                                        <option value="member">Yes</option>
                                        <option value="nonmember">No</option>
                                    </select>
                                </td>

                                <td class="td" id="namemeemberregister" style="width:25%;">Member Name<span
                                        style="color:#ff0000">*</span></td>
                                <td id="IDMembertd" class="disabledbutton" style="border: 1px;width:25%;">

                                    <input type="text" name="term" id="term" placeholder="search member here...."
                                        class="form-control" tabindex="2">

                                </td>

                                <td class="td" id="nonmembername" style="display:none;width:25%;">Full Name</td>
                                <td id="fieldtest" style="border: 1px; display: table-cell;display:none;width:25%;">
                                    <input id="namenonmember" class="form-control" type="text" name="namenonmember"
                                        placeholder="Full Name">
                                </td>

                                <input type="text" style="display:none" name="termMember" id="termMember"
                                    placeholder="search member here...." class="form-control">

                            </tr>
                            <tr class="tr">



                                <td class="td">Member Id</td>
                                <td class="td"><input type="number" name='demmember' id="demmember"
                                        class="form-control input-sm point" oninvalid="InvalidMsg(this);"
                                        oninput="InvalidMsg(this);" tabindex="3">
                                </td>


                                <td class="td">Spouse Name</td>
                                <td class="td"><input id="spousename" class="form-control input-sm" type="text"
                                        placeholder="Spouse Name" value="" name="spousename" tabindex="4"></td>

                            </tr>

                            <tr class="tr">

                                <td class="td">Purpose</td>
                                <td class="td">
                                    <input type="text" class="form-control input-sm" name="purpose" value="General"
                                        selectBoxOptions="General;" tabindex="5">
                                </td>
                                <td class="td"> Street No<span style="color:#ff0000">*</span></td>
                                <td class="td"> <input id="Street" class="form-control input-sm" type="text"
                                        placeholder="Street No" value="" name="Street" tabindex="6" required=""></td>
                            </tr>

                            <tr class="tr">

                                <td class="td">Address<span style="color:#ff0000">*</span></td>
                                <td class="td"> <input id="ressidentalAddress" class="form-control input-sm" type="text"
                                        placeholder="Address" value="" name="Address" tabindex="7" required=""></td>
                                <td class="td">City<span style="color:#ff0000">*</span></td>
                                <td class="td"> <input id="city" class="form-control input-sm" type="text" name="City"
                                        size="25" value="" title="City" placeholder="City" tabindex="8" required=""></td>
                            </tr>

                            <tr class="tr">

                                <td class="td"> State<span style="color:#ff0000">*</span></td>

                                <td class="td"><select required id="state" name="State" value=""
                                        class="form-control input-sm">
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
                                </td>

                                <td class="td">Zip<span style="color:#ff0000">*</span></td>
                                <td class="td"> <input id="zip_code" class="form-control input-sm" type="text"
                                        placeholder="Zip Code" value="" name="Zip_Code" tabindex="10" required=""></td>
                            </tr>

                            <tr class="tr">
                                <td class="td"> Phone Number<span style="color:#ff0000">*</span></td>
                                <td class="td">
                                    <input id="phone" class="form-control input-sm" type="text" required=""
                                        placeholder="###) ###-####" value="" name="Tele1" onchange="sponsoramount(this.id)"
                                        maxlength="10" tabindex="11">
                                    <!-- <input id="phone" name="phone" type="tel"> -->
                                </td>
                                <td class="td">Email<span style="color:#ff0000">*</span></td>
                                <td class="td"><input required="" id="email" class="form-control input-sm" type="text"
                                        placeholder="name@company.com" value="" name="email" tabindex="12"
                                        pattern="[^@\s]+@[^@\s]+\.[^@\s]+"></td>


                            </tr>

                            <tr class="tr">
                                <td class="td">Lifetime Contribution</td>
                                <td class="td"> <input id="ltd1" class="form-control input-sm" type="text"
                                        placeholder="Lifetime Contribution" value="" name="LTC" tabindex="13" readonly></td>


                                <td class="td">Annual Donation</span></td>
                                <td class="td">
                                    <input id="ytd1" class="form-control input-sm" type="text" placeholder="Annual Donation"
                                        value="" name="YTD" tabindex="14" readonly>
                                </td>

                            </tr>

                            <tr class="tr">
                                <td class="td">Membership Category</td>
                                <td class="td">
                                    <input id="MembCategory" class="form-control input-sm" type="text"
                                        placeholder="Membership Category" value="" name="Membership Category" tabindex="15"
                                        readonly>
                                </td>
                                <td class="td">Amount<span style="color:#ff0000">*</span></td>


                                <td class="td">
                                    <div class="form-group">

                                        <div class="input-group">
                                            <span
                                                class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency'] ?? ''); ?></span>
                                            <input required="" id="total" class="form-control input-sm" type="number"
                                                placeholder="$Amount" value="25" name="Amount" tabindex="16"
                                                onchange="amountvalid(this.id)">
                                        </div>
                                    </div>
                                </td>



                            </tr>
                            <tr style="display:none;">
                                <td class="td"> <input id="Your_Name" class="form-control input-sm" type="test"
                                        name="MemberName"> </td>
                            </tr>
                            <tr style="display:none;">
                                <td class="td"> <input id="Zellecode" class="form-control input-sm" type="text" name="code">
                                </td>
                            </tr>

                            <div id="payment-method-wrapper" style="display:block;">
                                <table class="table">
                                    <tr class="tr">
                                        <td class="td" colspan="2">
                                            Payment Method
                                        </td>
                                        <td class="td" colspan="2">
                                            <select required="" name="PaymentOption" id="PaymentOption"
                                                class="form-control input-sm medium valid" aria-required="true"
                                                aria-invalid="false" style="width:100%;  height:50%;" tabindex="15">
                                                <option value="" class="amd">---</option>
                                                <?php
                                                $payment_method_arr = __('payment_method_arr');
                                                foreach (is_array($payment_method_arr) ? $payment_method_arr : [] as $k => $v) {
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
                                                <div
                                                    style="margin-bottom:6px;display:flex;gap:6px;flex-wrap:wrap;align-items:center;">
                                                    <input type="text" id="zelle_donor_name" class="form-control input-sm"
                                                        placeholder="Your name as sent in Zelle" autocomplete="off"
                                                        style="flex:2;min-width:160px;">
                                                    <input type="date" id="zelle_date" class="form-control input-sm"
                                                        title="Transaction date (optional)" style="flex:1;min-width:130px;">
                                                    <button type="button" id="checkPaymentData"
                                                        class="btn btn-primary btn-sm" style="white-space:nowrap;">Verify
                                                        Zelle Payment</button>
                                                </div>
                                                <div id="zelle-no-match"
                                                    style="display:none;color:#c0392b;font-size:13px;margin-bottom:6px;">
                                                    No matching Zelle transaction found. Please check your name, amount, and
                                                    date.
                                                </div>
                                            </div>
                                        </td>
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
                            <tr>
                                <td><button id="reset-btn-id" class="btn btn-primary" autocomplete="off" value="Save"
                                        name="Reset" tabindex="16" type="submit"><i
                                            class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Reset</button></td>
                                <td><button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save"
                                        name="Payment" tabindex="17" type="submit"><i
                                            class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Make Payment</button></td>
                            </tr>
                            <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                        </table>
                        <div id="stripe_secret_key_id" style="display: none">
                            <?php echo $tpl['option_arr_values']['stripe_publish_key'] ?? ''; ?></div>

                        <!-- Zelle Instructions Modal -->
                        <div id="zelle-modal-overlay"
                            style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9100;justify-content:center;align-items:center;">
                            <div
                                style="background:#fff;border-radius:8px;width:660px;max-width:96vw;max-height:90vh;overflow-y:auto;box-shadow:0 8px 32px rgba(0,0,0,0.25);position:relative;font-family:Arial,sans-serif;">
                                <div
                                    style="background:#357ca5;padding:16px 20px 12px;text-align:center;position:relative;border-radius:8px 8px 0 0;">
                                    <button id="zelle-modal-close" type="button"
                                        style="position:absolute;top:10px;right:14px;background:none;border:none;color:#fff;font-size:24px;cursor:pointer;line-height:1;padding:0;opacity:0.85;">&times;</button>
                                    <h4 style="color:#fff;margin:0;font-size:18px;font-weight:bold;">Pay via Zelle</h4>
                                    <p style="color:rgba(255,255,255,0.88);margin:4px 0 0;font-size:13px;">Send to treasurer@durgabari.org</p>
                                </div>
                                <div style="padding:0 24px 16px;font-size:14px;color:#333;line-height:1.8;">
                                    <b>Step 1</b> — Open your bank app and navigate to Zelle.<br>
                                    <b>Step 2</b> — Send your donation amount to <b>treasurer@durgabari.org</b>.<br>
                                    <b>Step 3</b> — After sending, click <b>"I've Completed Zelle Payment"</b> below.
                                </div>
                                <div style="padding:0 24px 22px;display:flex;gap:12px;justify-content:center;">
                                    <button id="zelle-modal-paid-btn" type="button" class="btn btn-primary"
                                        style="min-width:200px;font-size:15px;">I've Completed Zelle Payment</button>
                                    <button id="zelle-modal-cancel-btn" type="button" class="btn btn-default"
                                        style="min-width:120px;font-size:15px;background:#f5f5f5;border:1px solid #ccc;">Cancel</button>
                                </div>
                            </div>
                        </div>

                        <!-- OTP Member Verification Modal -->
                        <style>
                            .otp-overlay {
                                display: none;
                                position: fixed;
                                inset: 0;
                                background: rgba(0, 0, 0, 0.55);
                                z-index: 9000;
                                justify-content: center;
                                align-items: center
                            }

                            .otp-overlay.otp-active {
                                display: flex
                            }

                            .otp-modal {
                                background: #fff;
                                border-radius: 8px;
                                width: 380px;
                                max-width: 95vw;
                                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.22);
                                overflow: hidden;
                                position: relative;
                                font-family: Arial, sans-serif
                            }

                            .otp-modal-header {
                                background: #357ca5;
                                padding: 18px 20px 14px;
                                text-align: center;
                                position: relative
                            }

                            .otp-modal-header h4 {
                                color: #fff;
                                margin: 0 0 4px;
                                font-size: 18px;
                                font-weight: bold
                            }

                            .otp-modal-header p {
                                color: rgba(255, 255, 255, 0.88);
                                margin: 0;
                                font-size: 13px
                            }

                            .otp-close-btn {
                                position: absolute;
                                top: 10px;
                                right: 14px;
                                background: none;
                                border: none;
                                color: #fff;
                                font-size: 20px;
                                cursor: pointer;
                                line-height: 1;
                                padding: 0;
                                opacity: 0.8
                            }

                            .otp-close-btn:hover {
                                opacity: 1
                            }

                            .otp-modal-body {
                                padding: 22px 24px 18px
                            }

                            #otp-screen-2 {
                                display: none
                            }

                            .otp-field-group {
                                margin-bottom: 14px
                            }

                            .otp-field-group label {
                                display: block;
                                font-size: 13px;
                                font-weight: bold;
                                color: #444;
                                margin-bottom: 5px
                            }

                            .otp-field-group label span.otp-req {
                                color: #ff5252
                            }

                            .otp-field-group input[type="text"],
                            .otp-field-group input[type="number"] {
                                width: 100%;
                                height: 36px;
                                padding: 6px 10px;
                                border: 1px solid #ccc;
                                border-radius: 4px;
                                font-size: 14px;
                                color: #555;
                                background: #f9fcfa;
                                box-sizing: border-box;
                                transition: border-color 0.15s
                            }

                            .otp-field-group input:focus {
                                outline: none;
                                border-color: #357ca5;
                                box-shadow: 0 0 0 2px rgba(53, 124, 165, 0.15)
                            }

                            .otp-field-group input.otp-error-border {
                                border-color: #ff5252
                            }

                            .otp-method-toggle {
                                display: flex;
                                gap: 10px;
                                margin-top: 4px
                            }

                            .otp-method-btn {
                                flex: 1;
                                padding: 8px 0;
                                border: 2px solid #ccc;
                                border-radius: 5px;
                                background: #f5f5f5;
                                color: #666;
                                font-size: 13px;
                                font-weight: bold;
                                cursor: pointer;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                gap: 6px;
                                transition: all 0.18s
                            }

                            .otp-method-btn:hover {
                                border-color: #357ca5;
                                color: #357ca5
                            }

                            .otp-method-btn.otp-selected {
                                border-color: #357ca5;
                                background: #357ca5;
                                color: #fff
                            }

                            .otp-submit-btn {
                                width: 100%;
                                padding: 10px;
                                background: #357ca5;
                                color: #fff;
                                border: none;
                                border-radius: 5px;
                                font-size: 15px;
                                font-weight: bold;
                                cursor: pointer;
                                margin-top: 6px;
                                transition: background 0.18s
                            }

                            .otp-submit-btn:hover {
                                background: #2a6185
                            }

                            .otp-submit-btn:disabled {
                                opacity: 0.6;
                                cursor: not-allowed
                            }

                            .otp-security-note {
                                text-align: center;
                                font-size: 11.5px;
                                color: #888;
                                margin-top: 12px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                gap: 5px
                            }

                            .otp-security-note i {
                                color: #357ca5
                            }

                            .otp-alert {
                                padding: 8px 12px;
                                border-radius: 4px;
                                font-size: 13px;
                                margin-bottom: 12px;
                                display: none
                            }

                            .otp-alert.otp-alert-error {
                                background: #fdecea;
                                border: 1px solid #f5c6cb;
                                color: #c0392b
                            }

                            .otp-alert.otp-alert-success {
                                background: #eaf6ec;
                                border: 1px solid #c3e6cb;
                                color: #276632
                            }

                            .otp-alert.otp-show {
                                display: block
                            }

                            .otp-sent-to {
                                text-align: center;
                                font-size: 13px;
                                color: #555;
                                margin-bottom: 16px;
                                line-height: 1.5
                            }

                            .otp-sent-to strong {
                                color: #333
                            }

                            .otp-change-link {
                                color: #357ca5;
                                font-weight: bold;
                                text-decoration: none;
                                cursor: pointer;
                                font-size: 13px
                            }

                            .otp-change-link:hover {
                                text-decoration: underline
                            }

                            .otp-digits {
                                display: flex;
                                justify-content: center;
                                gap: 8px;
                                margin: 10px 0 14px
                            }

                            .otp-digit-input {
                                width: 42px;
                                height: 48px;
                                text-align: center;
                                font-size: 22px;
                                font-weight: bold;
                                border: 2px solid #ccc;
                                border-radius: 6px;
                                color: #333;
                                background: #f9fcfa;
                                transition: border-color 0.15s;
                                -moz-appearance: textfield
                            }

                            .otp-digit-input::-webkit-outer-spin-button,
                            .otp-digit-input::-webkit-inner-spin-button {
                                -webkit-appearance: none;
                                margin: 0
                            }

                            .otp-digit-input:focus {
                                outline: none;
                                border-color: #357ca5;
                                box-shadow: 0 0 0 2px rgba(53, 124, 165, 0.15)
                            }

                            .otp-digit-input.otp-filled {
                                border-color: #357ca5;
                                background: #f0f7fb
                            }

                            .otp-digit-input.otp-error-border {
                                border-color: #ff5252
                            }

                            .otp-resend-row {
                                text-align: center;
                                font-size: 12.5px;
                                color: #777;
                                margin-bottom: 6px
                            }

                            .otp-resend-link {
                                color: #357ca5;
                                font-weight: bold;
                                cursor: pointer;
                                text-decoration: none;
                                display: none
                            }

                            .otp-resend-link:hover {
                                text-decoration: underline
                            }

                            .otp-resend-link.otp-show {
                                display: inline
                            }

                            #otp-countdown {
                                font-weight: bold;
                                color: #357ca5
                            }

                            #otp-verified-banner {
                                display: none;
                                padding: 8px 14px;
                                background: #eaf6ec;
                                border: 1px solid #c3e6cb;
                                color: #276632;
                                border-radius: 4px;
                                font-size: 13px;
                                margin: 6px 0 4px
                            }

                            #otp-verified-banner.otp-show {
                                display: flex;
                                align-items: center;
                                gap: 8px
                            }
                        </style>

                        <div id="otp-overlay" class="otp-overlay">
                            <div class="otp-modal">
                                <div class="otp-modal-header">
                                    <button class="otp-close-btn" id="otp-close-btn" type="button">&times;</button>
                                    <h4>Verify Your Membership</h4>
                                    <p id="otp-modal-subtitle">Please verify your identity to access member details.</p>
                                </div>
                                <div class="otp-modal-body">
                                    <div id="otp-alert" class="otp-alert"></div>
                                    <div id="otp-screen-1">
                                        <div class="otp-field-group">
                                            <label>Email or Phone Number <span class="otp-req">*</span></label>
                                            <input type="text" id="otp-lookup" placeholder="Enter your email or phone number"
                                                autocomplete="off" />
                                        </div>
                                        <div class="otp-field-group">
                                            <label>Receive OTP via <span class="otp-req">*</span></label>
                                            <div class="otp-method-toggle">
                                                <button type="button" class="otp-method-btn" id="otp-method-email"
                                                    data-method="email"><i class="fa fa-envelope"></i> Email</button>
                                                <button type="button" class="otp-method-btn" id="otp-method-sms"
                                                    data-method="sms"><i class="fa fa-mobile"></i> SMS</button>
                                            </div>
                                        </div>
                                        <button type="button" class="otp-submit-btn" id="otp-send-btn">Send OTP</button>
                                        <div class="otp-security-note"><i class="fa fa-lock"></i> Your information is secure
                                            and will not be shared.</div>
                                    </div>
                                    <div id="otp-screen-2">
                                        <div class="otp-sent-to">OTP has been sent to<br><strong
                                                id="otp-masked-destination"></strong>&nbsp;<a class="otp-change-link"
                                                id="otp-change-link">Change</a></div>
                                        <div class="otp-field-group">
                                            <label>Enter OTP <span class="otp-req">*</span></label>
                                            <div class="otp-digits">
                                                <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9"
                                                    data-index="0" />
                                                <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9"
                                                    data-index="1" />
                                                <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9"
                                                    data-index="2" />
                                                <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9"
                                                    data-index="3" />
                                                <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9"
                                                    data-index="4" />
                                                <input class="otp-digit-input" type="number" maxlength="1" min="0" max="9"
                                                    data-index="5" />
                                            </div>
                                        </div>
                                        <div class="otp-resend-row">
                                            <span id="otp-resend-timer">Resend OTP in <span
                                                    id="otp-countdown">00:45</span></span>
                                            <a class="otp-resend-link" id="otp-resend-link">Resend OTP</a>
                                        </div>
                                        <button type="button" class="otp-submit-btn" id="otp-verify-btn">Verify OTP</button>
                                        <div class="otp-security-note"><i class="fa fa-lock"></i> Your information is secure
                                            and will not be shared.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="otp-verified-banner">
                            <i class="fa fa-check-circle" style="color:#276632;font-size:16px;"></i>
                            Verification successful! You can now search and select member.
                        </div>
                        <?php
                        $otpVerifiedMember = '';
                        if (!empty($_SESSION['otp_verified_member'])) {
                            $otpVerifiedMember = is_array($_SESSION['otp_verified_member'])
                                ? ($_SESSION['otp_verified_member']['member_id'] ?? '')
                                : $_SESSION['otp_verified_member'];
                        }
                        ?>
                        <div id="otp-session-verified" style="display:none"><?= htmlspecialchars((string) $otpVerifiedMember, ENT_QUOTES, 'UTF-8') ?></div>

                    <?php } ?>

                    <script type="text/javascript">
                        $(window).bind("pageshow", function () {
                            var form = $('form');
                            form[0].reset();
                        });

                        const phoneInputField = document.querySelector("#phone");
                        const phoneInput = window.intlTelInput(phoneInputField, {
                            // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
                            preferredCountries: ["us", "co", "in", "de"],
                            utilsScript:
                                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                        });

                        $(function () {
                            $('input[type="text"]').change(function () {
                                this.value = $.trim(this.value);
                            });
                        });


                        ////Lookup.......................Start..............................////
                        $(function () {
                            $("#term").autocomplete({
                                //source: "http://localhost/HDBS_Payment/PriestMember/ajax-db-search.php",
                                source: '<?= INSTALL_URL ?>ajax-db-search.php',
                                select: function (event, ui) {
                                    event.preventDefault();
                                    var name = ui.item.value;
                                    var f_name = name.split(",");
                                    $("#term").val(f_name[0]);
                                    $("#termMember").val(ui.item.id);
                                    MemberSelectdonation();
                                },
                                onclick: function (event, ui) {
                                    event.preventDefault();
                                    var name = ui.item.value;
                                    var f_name = name.split(",");
                                    $("#term").val(f_name[0]);
                                    $("#termMember").val(ui.item.id);
                                    MemberSelectdonation();
                                },
                                onchange: function (event, ui) {
                                    event.preventDefault();
                                    var name = ui.item.value;
                                    var f_name = name.split(",");
                                    $("#term").val(f_name[0]);
                                    $("#termMember").val(ui.item.id);
                                    MemberSelectdonation();
                                },
                            });
                        });

                        ////Lookup.......................End..............................////

                        function optionreq() {

                            if (GdSelect != null) {
                                document.getElementById('MemberName').required = true;
                                document.getElementById('Street').required = true;
                                document.getElementById('Tele1').required = true;
                                document.getElementById('email').required = true;
                                document.getElementById('PaymentOption').required = true;
                                document.getElementById('zip_code').required = true;
                                document.getElementById('state').required = true;
                                document.getElementById('city').required = true;
                                document.getElementsByClassName("form-control input-sm").required = true;

                            } else {
                                document.getElementById('MemberName').required = false;
                                document.getElementById('Street').required = false;
                                document.getElementById('Tele1').required = true;
                                document.getElementById('email').required = true;
                                document.getElementById('PaymentOption').required = false;
                                document.getElementById('zip_code').required = false;
                                document.getElementById('state').required = false;
                                document.getElementById('city').required = false;
                                document.getElementsByClassName("form-control input-sm").required = false;
                            }
                        }

                        $('#demmember').keydown(function (e) {
                            e.preventDefault();
                            return false;
                        });

                        $('#term').on('input', function () {
                            $(this).val($(this).val().replace(/[^a-z0-9]/gi, ''));
                        });

                        function sponsoramount(elem) {
                            const phonenumber = $("#phone").val();
                            if (!!phonenumber) {
                                if (isNaN(phonenumber)) {
                                    alert("Please Enter mobile Number");
                                    $("#payment_btn_id").addClass('disabled');
                                    //document.getElementById("totalamount").value = price; 
                                }
                                else if (phonenumber.length > 10) {
                                    alert("Number should be 10 digits");
                                    $("#payment_btn_id").addClass('disabled');
                                }
                                else if (phonenumber.length < 10) {
                                    alert("Number should be 10 digits");
                                    $("#payment_btn_id").addClass('disabled');
                                }
                                else if (phonenumber.length == 10) {
                                    $("#payment_btn_id").removeClass('disabled');
                                }
                                else {
                                    $("#payment_btn_id").removeClass('disabled');
                                }
                            }
                            else {
                                $("#phone").prop('required', true);
                                $("#payment_btn_id").removeClass('disabled');
                            }
                        }

                        function amountvalid() {
                            const price = $("#total").val();
                            if (price < 25) {
                                alert("Minimum Amount $25");
                                $("#total").prop('required', true);
                                $("#payment_btn_id").addClass('disabled');
                            }
                            else {
                                $("#payment_btn_id").removeClass('disabled');
                            }
                        }

                        //autocomplete  
    function getDonationMemberInput(res, id) {
        var nodes = $.parseHTML($.trim(res || ''), document, false) || [];
        var $nodes = $(nodes);
        var $el = $nodes.filter('input#' + id);
        if (!$el.length) {
            $el = $('<div>').append($nodes).find('input#' + id);
        }
        return $el;
    }
   function MemberSelectdonation() {
                            var url2 = $("#container-abc-url-id").text();
                            var self = this;
                            var data = $("#termMember").val();
                            var term = $("#term").val();
                            if (term != "") {
                                const Memberid = data.split("-");
                                if (term.trim() != "") {
                                    $.ajax({
                                        type: "POST",
                                        data: {
                                            memberid: data
                                        },
                                        url: url2 + "load.php?controller=Donations&action=AllMemberNew",
                                        success: function (res) {
                                            //var Membertext = $("#MemberSelectValue").text();
                                            //document.getElementById("MemberSelect").value = Membertext;
                                            let MemberName = "";
                                            const memberNameElement = getDonationMemberInput(res, "MemberName");
                                            if (memberNameElement.length) {
                                                MemberName = memberNameElement[0].value;
                                            }
                                            let LastName = "";
                                            const LastNameElement = getDonationMemberInput(res, "last_name");
                                            if (LastNameElement.length) {
                                                LastName = LastNameElement[0].value;
                                            }

                                            document.getElementById("Your_Name").value = MemberName.concat(" ", LastName);;



                                            let memberid = "";
                                            const memberElement = getDonationMemberInput(res, "memberid");
                                            if (memberElement.length) {
                                                memberid = memberElement[0].value;
                                            }
                                            document.getElementById("demmember").value = memberid;
                                            // if(memberid != ""){
                                            // document.getElementById("demmember").value = memberid;
                                            // var url ="https://durgabari.org/HDBS_PaymentNew/Member/membermaintenance/" +memberid
                                            // window.location.assign(url);
                                            // }
                                            let spouseName = "";
                                            let spouseLastName = "";
                                            const spouseNameElement = getDonationMemberInput(res, "Spouse");
                                            const spouseLastNameElement = getDonationMemberInput(res, "Spouselast");
                                            if (spouseLastNameElement.length) {
                                                spouseLastName = spouseLastNameElement[0].value;
                                            }
                                            if (spouseNameElement.length) {
                                                spouseName = spouseNameElement[0].value;
                                            }
                                            document.getElementById("spousename").value = spouseName.concat(" ", spouseLastName);

                                            let street = "";
                                            const streetElement = getDonationMemberInput(res, "ressidentalAddress");
                                            if (streetElement.length) {
                                                street = streetElement[0].value;
                                            }
                                            document.getElementById("Street").value = street;

                                            let resaddress = "";
                                            const resaddressElement = getDonationMemberInput(res, "Address");
                                            if (resaddressElement.length) {
                                                resaddress = resaddressElement[0].value;
                                            }
                                            document.getElementById("ressidentalAddress").value = resaddress;

                                            let state = "";
                                            const stateElement = getDonationMemberInput(res, "state");
                                            if (stateElement.length) {
                                                state = stateElement[0].value;
                                            }
                                            document.getElementById("state").value = state;


                                            let city = "";
                                            const cityElement = getDonationMemberInput(res, "city");
                                            if (cityElement.length) {
                                                city = cityElement[0].value;
                                            }
                                            document.getElementById("city").value = city;

                                            let zipcode = "";
                                            const zipcodeElement = getDonationMemberInput(res, "zip_code");
                                            if (zipcodeElement.length) {
                                                zipcode = zipcodeElement[0].value;
                                            }
                                            document.getElementById("zip_code").value = zipcode;

                                            let phoneNo = "";
                                            const phoneNoElement = getDonationMemberInput(res, "Tele1");
                                            if (phoneNoElement.length) {
                                                phoneNo = phoneNoElement[0].value;
                                            }
                                            document.getElementById("phone").value = phoneNo;

                                            let email = "";
                                            const emailElement = getDonationMemberInput(res, "email");
                                            if (emailElement.length) {
                                                email = emailElement[0].value;
                                            }
                                            document.getElementById("email").value = email;

                                            let ltd = "";
                                            const ltdElement = getDonationMemberInput(res, "ltd");
                                            if (ltdElement.length) {
                                                ltd = ltdElement[0].value;
                                            }
                                            document.getElementById("ltd1").value = ltd;

                                            let ytd = "";
                                            const ytdElement = getDonationMemberInput(res, "ytd");
                                            if (ytdElement.length) {
                                                ytd = ytdElement[0].value;
                                            }
                                            document.getElementById("ytd1").value = ytd;


                                            let cat = "";
                                            const catElement = getDonationMemberInput(res, "membercategory");
                                            if (catElement.length) {
                                                cat = catElement[0].value;
                                            }
                                            document.getElementById("MembCategory").value = cat;


                                        }

                                    });
                                } else {
                                    $("#MemberName").val("");
                                    $("#phone").val("");
                                    $("#Your_E-mail").val("");
                                    $("#memberid").val(""); Member_id

                                    $("#spousename").val("");
                                    $("#Street").val("");
                                    $("#ressidentalAddress").val("");
                                    $("#state").val("");
                                    $("#city").val("");
                                    $("#zip_code").val("");
                                    $("#phone").val("");
                                    $("#email").val("");
                                    $("#ltd1").val("");
                                    $("#ytd1").val("");
                                    $("#MembCategory").val("");

                                }
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
                            } else {
                                textbox.setCustomValidity('');
                                $('#demmember').addClass('point')
                            }
                            return true;

                        }

                    </script>
