<head>
<?php
$serverDateTime = date('Y-m-d');
$currentYear = date('Y');
?>
    <link href="<?= INSTALL_URL ?>Multi/styles/multiselect.css" rel="stylesheet" />
    <script src="<?= INSTALL_URL ?>Multi/multiselect.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
</head>
<style>
    .multiselect-checkbox {
        margin: 15px;
    }

    .multiselect-wrapper ul li.active {
        background-color: white !important;
        color: white;
    }

    .multiselect-wrapper .multiselect-list .multiselect-checkbox {
        margin-right: 20px;
        margin-left: 5px;
    }


    .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }

    @media only screen and (max-width: 499px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media (min-width: 500px) and (max-width: 767px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media (min-width: 768px) and (max-width: 830px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    @media(min-width: 831px) and (max-width: 990px) {
        .right-side {
            margin-left: 0px !important;
        }
    }

    .medium {
        width: 450px !important;
    }

    #footer {
        display: none !important;
    }
</style>
<?php
$tpl['option_arr_values'] = array_merge(
    ['currency' => ''],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);
?>
<section class="content-header">
    <h1>
        <?php echo __('Admin Payment'); ?>
    </h1>
    <?php if ($this->controller->isLoged()) { ?>
        <ol class="breadcrumb">
            <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                    <?php echo __('home'); ?>
                </a></li>
            <li><a href="<?php echo INSTALL_URL; ?>Adminpayment/index">Admin Payment</a></li>
            <li class="active">
                <?php echo __('Admin Payment'); ?>
            </li>
        </ol>
    <?php } ?>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>
<table class="table">
    <tr class="tr">
        <td class="td">Payment For</td>
        <td class="td">
            <select name="Paymentfor" id="paymentfor" class="form-control input-sm" onchange="checkpayfor(this)">
                <option value="">Payment For</option>
                <option value="member">Member(Membership Renewal/Maintenance )</option>
                <option value="donation">Donations</option>
                <option value="event">Event</option>
                <option value="ticket">Ticket</option>
                <option value="giftmisc">Gift & Misc</option>  
            </select>
        </td>
    </tr>
</table>

<div id="donationdiv" style="display:none;">
    <section class="content left width_100">
        <form id="donation-frm-id" class="form-horizontal" method="post" action="" role="form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
            <input type="hidden" name="create_donation" value="1" />
            <table class="table" id="tabledontation">
                <tr class="tr">
                    <td class="td">Durga Bari Member</td>
                    <td class="td"><select required="" name="regmember" id="registrationmember"
                            class="form-control input-sm" aria-required="true" aria-invalid="false"
                            onchange="memberhceck()">
                            <option value="">Please select Member type</option>
                            <option value="member">Yes</option>
                            <option value="nonmember">No</option>
                        </select>
                    </td>

                    <td class="td" id="namemeemberregister">Member Name<span style="color:#ff0000">*</span></td>
                    <td id="IDMembertd" class="disabledbutton" style="border: 1px;">

                        <input type="text" name="term" id="term" placeholder="search member here...."
                            class="form-control" tabindex="2">

                    </td>

                    <td class="td" id="nonmembername" style="display:none;">Full Name</td>
                    <td id="fieldtest" style="border: 1px; display: table-cell;display:none;">
                        <input id="namenonmember" class="form-control" type="text" name="namenonmember"
                            placeholder="Full Name">
                    </td>

                    <input type="text" style="display:none" name="termMember" id="termMember"
                        placeholder="search member here...." class="form-control">
                </tr>
                <tr class="tr">

                    <td class="td">Member Id</td>
                    <td class="td"><input type="text" name='demmember' id="demmember" class="form-control input-sm"
                            aria-required="true" readonly tabindex="3">
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
                    <td class="td"> <input id="Street" class="form-control input-sm" type="text" placeholder="Street No"
                            value="" name="Street" tabindex="6" required></td>
                </tr>
                <tr class="tr">
                    <td class="td">Address<span style="color:#ff0000">*</span></td>
                    <td class="td"> <input id="ressidentalAddress" class="form-control input-sm" type="text"
                            placeholder="Address" value="" name="Address" tabindex="7" required></td>

                    <td class="td">City<span style="color:#ff0000">*</span></td>
                    <td class="td"> <input id="city" class="form-control input-sm" type="text" name="City" size="25"
                            value="" title="City" placeholder="City" tabindex="8" required></td>
                </tr>
                <tr class="tr">
                    <td class="td"> State<span style="color:#ff0000">*</span></td>
                    <td class="td"><select required id="state" name="State" value="" class="form-control input-sm">
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
                            placeholder="Zip Code" value="" name="Zip_Code" tabindex="10" required></td>
                </tr>
                <tr class="tr">
                    <td class="td"> Phone Number<span style="color:#ff0000">*</span></td>
                    <td class="td">
                        <input id="phone" class="form-control input-sm" type="text" required=""
                            placeholder="### ###-####" value="" name="Tele1" maxlength="10" tabindex="11"
                            onchange="checkphoneno(this.id)">
                    </td>
                    <td class="td">Email<span style="color:#ff0000">*</span></td>
                    <td class="td"><input required="" id="email" class="form-control input-sm" type="text"
                            placeholder="name@company.com" value="" name="email" tabindex="12"
                            pattern="[^@\s]+@[^@\s]+\.[^@\s]+"></td>
                </tr>
                <tr class="tr">
                    <td class="td" colspan="2">Payment Method</span></td>
                    <td class="td" colspan="2">
                        <select name="PaymentOption" id="cashcheck_method" class="form-control input-sm"
                            onchange="paymethod(this.id)" required>
                            <option value="">Please Select</option>
                            <option value="check">Check</option>
                            <option value="cash">Cash</option>
                            <option value="directdeposit">Direct Deposit</option>
                        </select>
                    </td>
                </tr>
                <!-- payment dropdown start -->

                <table class="table table-bordered table-hover table-striped" style="display:none" id="checkdata">
                    <thead>
                        <tr class="tr">
                            <th>Bank Name</th>
                            <th>Check No</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tr">
                            <td class="td"><input style="WIDTH: 100%;" type="text" id="checkbankname"
                                    name="checkbankname" class="form-control input-sm" value=""></td>
                            <td class="td"><input style="WIDTH: 100%;" type="text" id="checkno" name="checkno"
                                    class="form-control input-sm" value=""></td>

                            <td class="td">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                        </span>
                                        <input style="WIDTH: 100%;" type="number" id="checkamount" name="checkAmount"
                                            class="form-control input-sm" value="">
                            </td>
</div>
</div>
<td class="td"><input style="WIDTH: 100%;" type="date" id="checkdate" name="CheckDate" class="form-control input-sm"
        value=""></td>
</tr>
</tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="cashdata">
    <thead>
        <tr class="tr">
            <th>Receive By</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="receiveby" name="ReceiveBy"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="cashamount" name="cashAmount"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>
            <td class="td"><input style="WIDTH: 100%;" type="date" id="cashdate" name="cashDate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="directdeposite">
    <thead>
        <tr class="tr">
            <th>Bank Name</th>
            <th>Transaction Code</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="bankname" name="directbank"
                    class="form-control input-sm" value=""></td>
            <td class="td"><input style="WIDTH: 100%;" type="text" id="ISFCCode" name="transactioncode"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="directamount" name="Amount"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>

            <td class="td"><input style="WIDTH: 100%;" type="date" id="date" name="transactiondate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<!-- payment dropdown end -->
<td class="td" style="display:none;"> <input id="Your_Name" class="form-control input-sm" type="test" name="MemberName"
        style="display:none;"> </td>

<td class="td" style="display:none;"> <input id="membershiptypehide" class="form-control input-sm" type="text" value=""
        readonly style="display:none;">
</td>
</tabel>
<input type="hidden" name="create_user" value="1" />
<button class="btn btn-primary" id='donationreset-btn-id' autocomplete="off" value="reset" name="Reset" tabindex="9"
    type="submit"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Reset</button>&nbsp;&nbsp;&nbsp;
<button class="btn btn-primary" id="submit" autocomplete="off" value="Save" name="submit" tabindex="9" type="submit"><i
        class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Save</button>
</table>
</form>
</section>
</div>
<!-- dontation div end  -->
<!-- memberlookup div start -->
<div id="lookupdiv" style="display:none;">
    <form id="payment-form" class="form-horizontal" method="post" action="" role="form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <input type="hidden" name="pay_usermaintenance" value="1" />
        <fieldset class="asb">

            <table class="table">
                <tr class="tr">

                    <td class="td">Member Name</td>
                    <td class="td">
                        <input type="text" name="Member_id" id="lookupterm" placeholder="search member here...."
                            class="form-control">

                        <input type="text" style="display:none" name="termMember" id="termMember"
                            placeholder="search member here...." class="form-control">

                    </td>
                    <td class="td">Member Id</td>
                    <td class="td"><input type="text" name='demmember' id="lookupdemmember"
                            class="form-control input-sm" aria-required="true" readonly>

                    </td>
                </tr>
                <tr class="tr">
                    <td class="td">Spouse Name</td>
                    <td class="td"><input id="spouselookup" class="form-control input-sm" type="text"
                            placeholder="Spouse Name" value="" name="spousename" tabindex="3"></td>
                    <td class="td"> Membership Type</td>
                    <td class="td" id="indvidualradio" style="display:none;">
                        <input type="radio" id="individual_membershipradio" name="membership_type"
                            value="IND" />Individual Membership<br>
                    </td>
                    <td class="td" id="familyradio" style="display:none;">
                        <input type="radio" id="family_membershipradio" name="membership_type" value="FAM" />Family
                        Membership
                    </td>
                </tr>

                <tr class="tr">
                    <td class="td"> Street No<span style="color:#ff0000">*</span></td>
                    <td class="td"> <input id="lookupStreet" class="form-control input-sm" type="text"
                            placeholder="Street No" value="" name="Address1" tabindex="5" required></td>
                    <td class="td">Address<span style="color:#ff0000">*</span></td>
                    <td class="td"> <input id="lookupressidentalAddress" class="form-control input-sm" type="text"
                            placeholder="Address" value="" name="Address2" tabindex="6" required></td>

                </tr>

                <tr class="tr">
                    <td class="td">City<span style="color:#ff0000">*</span></td>
                    <td class="td"><input id="lookupcity" class="form-control input-sm" type="text" name="City"
                            size="25" value="" title="City" placeholder="City" tabindex="7" required></td>
                    <td class="td"> State<span style="color:#ff0000">*</span></td>
                    <td class="td">
                        <!-- <input required="" id="state" class="form-control input-sm" type="text" placeholder="State" value="" name="State" tabindex="8"> -->
                        <select required id="lookupstate" class="form-control input-sm" name="State" value="">
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
                </tr>

                <tr class="tr">
                    <td class="td">Zip<span style="color:#ff0000">*</span></td>
                    <td class="td"> <input id="lookupzip_code" class="form-control input-sm" type="text"
                            placeholder="Zip Code" value="" name="Zip" tabindex="9" required></td>

                    <td class="td"> Phone Number<span style="color:#ff0000">*</span></td>
                    <td class="td">
                        <input id="lookupphone" class="form-control input-sm" type="text" required="" value=""
                            name="Tele1" placeholder="### ###-####" onchange="lookupcheckphoneno(this.id)"
                            maxlength="10" tabindex="9">
                        <!-- <input id="phone" name="phone" type="tel"> -->
                    </td>

                </tr>
                <tr class="tr">
                    <td class="td">Membership Category</td>
                    <td class="td">
                        <input id="MembCategory" class="form-control input-sm" type="text"
                            placeholder="Membership Category" value="" name="membercategory" tabindex="13" readonly>
                    </td>
                    <td class="td">Email<span style="color:#ff0000">*</span></td>
                    <td class="td"><input required="" id="lookupemail" class="form-control input-sm" type="text"
                            placeholder="name@company.com" value="" name="email" tabindex="14"
                            pattern="[^@\s]+@[^@\s]+\.[^@\s]+"></td>
                </tr>

                <tr style="display:none;">
                    <td class="td">
                        <input id="membershiptypehide" class="form-control input-sm" type="text" value="" readonly>
                    </td>
                    <td class="td"><input id="Your_Name" class="form-control input-sm" type="text" name="membername">
                    </td>
                    <td class="td"><input id="Your_id" class="form-control input-sm" type="text" name="idunique"> </td>
                </tr>
                <tr class="tr">
                    <td class="td" colspan="2"><input required="" id="amountlabel" class="form-control input-sm"
                            type="text" value="" name="amountlabel" tabindex="" readonly></td>

                    <td class="td" colspan="2">
                        <div class="form-group">

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                </span>
                                <input required="" id="total" class="form-control input-sm" type="number"
                                    placeholder="$Amount" value="" name="total" tabindex="15" readonly>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="tr">
                    <td class="td" colspan="2">Payment Method</span></td>
                    <td class="td" colspan="2">
                        <select name="Payment_method" id="meberpaymethod" class="form-control input-sm"
                            onchange="lookuppaymethod(this.id)" required>
                            <option value="">Please Select</option>
                            <option value="check">Check</option>
                            <option value="cash">Cash</option>
                            <option value="directdeposit">Direct Deposit</option>
                        </select>
                    </td>
                </tr>
                <table class="table table-bordered table-hover table-striped" style="display:none" id="tablecheck">
                    <thead>
                        <tr class="tr">
                            <th>Bank Name</th>
                            <th>Check No</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tr">
                            <td class="td"><input style="WIDTH: 100%;" type="text" id="lookupcheckbankname"
                                    name="checkbankname" class="form-control input-sm" value=""></td>
                            <td class="td"><input style="WIDTH: 100%;" type="text" id="lookupcheckno" name="checkno"
                                    class="form-control input-sm" value=""></td>

                            <td class="td">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                        </span>
                                        <input style="WIDTH: 100%;" type="number" id="lookupcheckamount"
                                            name="checkAmount" class="form-control input-sm" value="">
                            </td>
</div>
</div>
<td class="td"><input style="WIDTH: 100%;" type="date" id="lookupcheckdate" name="CheckDate"
        class="form-control input-sm" value=""></td>
</tr>
</tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="tablecash">
    <thead>
        <tr class="tr">
            <th>Receive By</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="lookupreceiveby" name="lookupReceiveBy"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="lookupcashamount" name="cashAmount"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>
            <td class="td"><input style="WIDTH: 100%;" type="date" id="loookupcashdate" name="cashDate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="directdepositetable">
    <thead>
        <tr class="tr">
            <th>Bank Name</th>
            <th>Transaction Code</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="lookupdirectbankname" name="directbank"
                    class="form-control input-sm" value=""></td>
            <td class="td"><input style="WIDTH: 100%;" type="text" id="lookupISFCCode" name="transactioncode"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="lookupdirectamount" name="directdepositamount"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>

            <td class="td"><input style="WIDTH: 100%;" type="date" id="lookupdirectdate" name="transactiondate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<!-- payment dropdown end -->

<tr style="display:none;">
    <td class="td"> <input id="lookupYour_Name" class="form-control input-sm" type="test" name="MemberName"
            style="display:none;"> </td>
</tr>
<tr>
    <input type="hidden" name="pay_usermaintenance" value="1" />
    <input type="hidden" name="ID" value="<?php echo $tpl['arr']['ID'] ?? ''; ?>" />

    <td><button id="reset-btn-id" class="btn btn-primary" autocomplete="off" value="reset" name="Reset" tabindex="16"
            type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Reset</button></td>
    <td><button id="member_btn_id" class="btn btn-primary" autocomplete="off" value="Pay" name="Pay" tabindex="17"
            type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Save</button></td>
</tr>

</table>

</fieldset>
</form>
</div>
<!-- memberlookup div end -->

<!-- event div start -->
<div id="eventdiv" style="display:none;">
    <form id="donation-frm-idevent" class="form-horizontal" method="post" action="" role="form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <input type="hidden" name="create_event" value="1" />
        <fieldset class="asb">

            <!-- <div id="imageevent" style="display:none;">
                    <img id="dataimg" src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . ($tpl['Eventname']['avatar'] ?? ''); ?>" />
                    </div>&nbsp; -->
            <table class="table">
                <tr class="tr">
                    <td class="td">Event Type <span style="color:#ff0000">*</span></td>
                    <td class="td">
                       <!-- <input readonly id="eventtype" class="form-control input-sm" type="text"
                            placeholder="Event Name" value="" name="type"> -->

                            <select required="" name='eventtype' id='eventtype'   class="form-control input-sm"
                                aria-required="true" aria-invalid="false" onchange="eventcurrentrun(this.id)">
                            </select>
                    </td>
                    <td class="td">Durga Bari Member</td>
                    <td class="td"><select required="" name="regmember" id="registrationmemberevent"
                            class="form-control input-sm" aria-required="true" aria-invalid="false">
                            <option value="">Please select Member type</option>
                            <option value="member">Yes</option>
                            <option value="nonmember">No</option>
                        </select>
                    </td>
</div>
</tr>
<tr class="tr">
    <td class="td" id="namemeemberregisterevent">Member Name<span style="color:#ff0000">*</span></td>
    <td id="IDMembertdevent" style="border: 1px;">

        <input type="text" name="Member_id" id="eventterm" placeholder="search member here...." class="form-control"
            tabindex="2" disabled>

    </td>

    <td class="td" id="nonmembernameevent" style="display:none;">Full Name</td>
    <td id="fieldtestevent" style="display:none;">
        <input id="namenonmemberevent" class="form-control" type="text" name="namenonmember" placeholder="Full Name">
    </td>

    <input type="text" style="display:none" name="termMember" id="termMemberevent" placeholder="search member here...."
        class="form-control">

    <td class="td">Member Id</td>
    <td class="td"><input type="text" name='demmember' id="demmemberevent" class="form-control input-sm"
            aria-required="true" readonly tabindex="3">
    </td>
</tr>
<tr class="tr">
    <td class="td"> Phone Number</td>
    <td class="td"> <input id="Tele1" class="form-control input-sm" type="text" name="Tele1" size="25"
            value="<?php echo $tpl['arr']['Tele1'] ?? ''; ?>" placeholder="### ###-####" tabindex="9" required
            onchange="eventphone(this.id)" maxlength="10"></td>

    <td class="td">Email <span style="color:#ff0000">*</span></td>
    <td class="td"><input required="" id="Email" class="form-control input-sm" type="text"
            placeholder="name@company.com" value="" name="email" size="25" value="<?php echo $tpl['arr']['email'] ?? ''; ?>"
            pattern="[^@\s]+@[^@\s]+\.[^@\s]+" tabindex="10" required></td>
</tr>

<tr class="tr">
    <td class="td">Amount<span style="color:#ff0000">*</span></td>
    <td class="td"><input readonly required="" id="Amount" class="form-control input-sm" type="number"
            placeholder="$Amount" value="" name="Amount" tabindex="11"></td>

    <td class="td">Payment Method</span></td>
    <td class="td">
        <select name="PaymentOption" id="cashcheck_methodevent" class="form-control input-sm"
            onchange="paymethodevent(this.id)" required>
            <option value="">Please Select</option>
            <option value="check">Check</option>
            <option value="cash">Cash</option>
            <option value="directdeposit">Direct Deposit</option>
        </select>
    </td>
    <!-- <td class="td">Extra Donation</td>
    <td class="td"><input id="extradonation" class="form-control input-sm" type="number" placeholder="$Amount" value=""
            name="eventdonation" tabindex="12" onchange="sponsoramount(this.id)"></td>
    </td> -->
</tr>

<!-- payment dropdown start -->

<table class="table table-bordered table-hover table-striped" style="display:none" id="checkdataevent">
    <thead>
        <tr class="tr">
            <th>Bank Name</th>
            <th>Check No</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="eventbankname" name="eventbankname"
                    class="form-control input-sm" value=""></td>

            <td class="td"><input style="WIDTH: 100%;" type="text" id="eventcheckno" name="eventcheckno"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="eventcheckamount" name="eventcheckAmount"
                            class="form-control input-sm" value="">
            </td>
            </div>
            </div>
            <td class="td"><input style="WIDTH: 100%;" type="date" id="eventcheckdate" name="eventCheckDate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="cashdataevent">
    <thead>
        <tr class="tr">
            <th>Receive By</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="eventreceiveby" name="eventReceiveBy"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="eventcashamount" name="eventcashAmount"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>
            <td class="td"><input style="WIDTH: 100%;" type="date" id="eventcashdate" name="eventcashDate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="directdepositeevent">
    <thead>
        <tr class="tr">
            <th>Bank Name</th>
            <th>Transaction Code</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="eventdirectbankname" name="eventdirectbank"
                    class="form-control input-sm" value=""></td>
            <td class="td"><input style="WIDTH: 100%;" type="text" id="eventISFCCode" name="eventtransactioncode"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="eventdirectamount" name="eventAmount"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>

            <td class="td"><input style="WIDTH: 100%;" type="date" id="eventdate" name="eventtransactiondate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<!-- payment dropdown end -->
</table>
<div class="form-group">
    <button id="reset-btn-idevent" class="btn btn-primary" autocomplete="off" value="Save" name="Reset" tabindex="9"
        type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Reset</button>
    <button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save" name="Payment" tabindex="9"
        type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Save</button>
</div>
<tr>
    <td class="td"> <input id="eventYour_Name" class="form-control input-sm" type="test" name="MemberName"
            style="display:none;"> </td>
    <td class="td"> <input id="eventid" class="form-control input-sm" type="text" name="uniqueeventid"
            style="display:none;"> </td>
    <td class="td"> <input id="eventnamehidden" class="form-control input-sm" type="text" name="type" style="display:none;"> </td>
</tr>
</fieldset>
</form>
</div>

<!-- event div end -->

<!-- ticket div end -->
<div id="ticketdiv" style="display:none;">
    <form id="donation-frm-idticket" class="form-horizontal" method="post" action="" role="form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <input type="hidden" name="create_ticket" value="1" />
        <fieldset class="asb">
            <table class="table">
                <tr class="tr">
                    <td class="td">Event Type <span style="color:#ff0000">*</span></td>
                    <td class="td">
                        <input readonly id="ticketeventtype" class="form-control input-sm" type="text"
                            placeholder="Event Name" value="" name="type">
                    </td>
                    <td class="td">Durga Bari Member</td>
                    <td class="td"><select required="" name="regmember" id="ticketregistrationmember"
                            class="form-control input-sm" aria-required="true" aria-invalid="false">
                            <option value="">Please select Member type</option>
                            <option value="member">Yes</option>
                            <option value="nonmember">No</option>
                        </select>
                    </td>
                </tr>
                <tr class="tr">
                    <td class="td" id="ticketnamemeemberregister">Member Name<span style="color:#ff0000">*</span></td>
                    <td id="IDMembertdticket" style="border: 1px;">

                        <input type="text" name="Member_id" id="ticketterm" placeholder="search member here...."
                            class="form-control" tabindex="2" disabled>

                    </td>

                    <td class="td" id="ticketnonmembername" style="display:none;">Full Name</td>
                    <td id="ticketfield" style="display:none;">
                        <input id="ticketnamenonmember" class="form-control" type="text" name="namenonmember"
                            placeholder="Full Name">
                    </td>

                    <input type="text" style="display:none" name="termMember" id="termMemberticket"
                        placeholder="search member here...." class="form-control">

                    <td class="td">Member Id</td>
                    <td class="td"><input type="text" name='demmember' id="demmemberticket"
                            class="form-control input-sm" aria-required="true" readonly tabindex="3">
                    </td>

                </tr>
                <tr class="tr">
                    <td class="td">Email <span style="color:#ff0000">*</span></td>
                    <td class="td"><input required="" id="Emailticket" class="form-control input-sm"
                            placeholder="name@company.com" type="text" placeholder="Email" value="" name="email"
                            size="25" value="<?php echo $tpl['arr']['email'] ?? ''; ?>"
                            pattern="[^@\s]+@[^@\s]+\.[^@\s]+" tabindex="4" required></td>

                    <td class="td"> Phone Number</td>
                    <td class="td"> <input id="ticketTele1" class="form-control input-sm" type="text" name="tele"
                            size="25" value="<?php echo $tpl['arr']['Tele1'] ?? ''; ?>" placeholder="### ###-####"
                            tabindex="5" required onchange="ticketphone(this.id)" maxlength="10"></td>
                </tr>

                <tr class="tr">
                    <td class="td">Event Day</td>
                    <td class="td">
                        <!-- new -->
                        <select id="ticketday" name="itemeventday" class="form-control input-sm"
                            style="width:100%!important;  height:50%;" multiple>

                            <?php
                            foreach (($tpl['ticketeventprice'] ?? []) as $key => $value) {
                                ?>

                                <option value="<?php echo $value['ticketprice'] . ',' . $value['itemeventday']; ?>"><?php echo $value['itemeventday']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td class="td">Quantity</td>
                    <td class="td"><input required="" id="quantity" class="form-control input-sm" type="number"
                            placeholder="Quantity" value="" name="item_number" tabindex="7" onChange="ticketqunatity()">
                    </td>
                </tr>

                <tr class="tr">
                    <td class="td">Ticket Amount<span style="color:#ff0000">*</span></td>
                    <td class="td"><input readonly required="" id="ticketAmount" class="form-control input-sm"
                            type="number" placeholder="$Amount" value="" name="item_cost" tabindex="8"></td>
                    <td class="td">Total Amount</td>

                    <td class="td">
                        <div class="form-group">

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                </span>
                                <input readonly required="" id="totalamount" class="form-control input-sm" type="number"
                                    placeholder="$Amount" value="" name="amount" tabindex="9">
                            </div>
                        </div>
                    </td>

                </tr>
                <tr class="tr">
                    <td class="td">Payment Method</span></td>
                    <td class="td">
                        <select name="PaymentOption" id="cashcheck_methodticket" class="form-control input-sm"
                            onchange="paymethodticket(this.id)" required>
                            <option value="">Please Select</option>
                            <option value="check">Check</option>
                            <option value="cash">Cash</option>
                            <option value="directdeposit">Direct Deposit</option>
                        </select>
                    </td>
                </tr>
                <!-- payment dropdown start -->

                <table class="table table-bordered table-hover table-striped" style="display:none" id="checkdataticket">
                    <thead>
                        <tr class="tr">
                            <th>Bank Name</th>
                            <th>Check No</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tr">
                            <td class="td"><input style="WIDTH: 100%;" type="text" id="ticketbankname"
                                    name="ticketbankname" class="form-control input-sm" value=""></td>

                            <td class="td"><input style="WIDTH: 100%;" type="text" id="ticketcheckno"
                                    name="ticketcheckno" class="form-control input-sm" value=""></td>

                            <td class="td">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                        </span>
                                        <input style="WIDTH: 100%;" type="number" id="ticketcheckamount"
                                            name="ticketcheckAmount" class="form-control input-sm" value="">
                            </td>
</div>
</div>
<td class="td"><input style="WIDTH: 100%;" type="date" id="ticketcheckdate" name="ticketCheckDate"
        class="form-control input-sm" value=""></td>
</tr>

</tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="cashdataticket">
    <thead>
        <tr class="tr">
            <th>Receive By</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="ticketreceiveby" name="ticketReceiveBy"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="ticketcashamount" name="ticketcashAmount"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>
            <td class="td"><input style="WIDTH: 100%;" type="date" id="ticketcashdate" name="ticketcashDate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="directdepositeticket">
    <thead>
        <tr class="tr">
            <th>Bank Name</th>
            <th>Transaction Code</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="ticketdirectbankname" name="ticketdirectbank"
                    class="form-control input-sm" value=""></td>
            <td class="td"><input style="WIDTH: 100%;" type="text" id="ticketISFCCode" name="tickettransactioncode"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="ticketdirectamount" name="ticketdirectamount"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>

            <td class="td"><input style="WIDTH: 100%;" type="date" id="ticketdate" name="tickettransactiondate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<!-- payment dropdown end -->
</table>
<div class="form-group">
    <button id="reset-btn-idticket" class="btn btn-primary" autocomplete="off" value="Save" name="Reset" tabindex="9"
        type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Reset</button>
    <button id="payment_btn_idticket" class="btn btn-primary" autocomplete="off" value="Save" name="Payment"
        tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Save</button>
</div>
<tr>
    <td class="td"> <input id="ticketYour_Name" class="form-control input-sm" type="text" name="MemberName"
            style="display:none;"> </td>
</tr>
<tr>
    <td class="td"> <input id="Days" class="form-control input-sm" type="text" name="Daysticket" style="display:none;">
    </td>
</tr>
<tr style="display:none;">
    <td class="td"> <input id="ticketeventid" class="form-control input-sm" type="text" name="ticketuniqueeventid"
            style="display:none;"> </td>
</tr>

</fieldset>
</form>

</div>
<!-- ticket div end -->
<!-- Gift & misc div end -->
<div id="giftmiscdiv" style="display:none;">
<section class="content left width_100">
<form id="donation-frm-idgiftmisc" class="form-horizontal" method="post" action="" role="form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
            <input type="hidden" name="create_donationgiftmisc" value="1" />
            <table class="table" id="tabledontation">
                <tr class="tr">
               <td class="td" >Payment For</td>
                <td class="td"><select  name="paymentfor" id="paymentfor" class="form-control input-sm" aria-required="true" aria-invalid="false" required="">
                         <option value="">Please select Payment For</option> 
                                <option value="gift">Gift Shop</option>
                                <option value="other">Other</option>
                                 </select></td>
                    <td class="td">Durga Bari Member</td>
                    <td class="td"><select required="" name="regmember" id="registrationmembergiftmisc"
                            class="form-control input-sm" aria-required="true" aria-invalid="false">
                            <option value="">Please select Member type</option>
                            <option value="member">Yes</option>
                            <option value="nonmember">No</option>
                        </select>
                    </td>

                </tr>
                <tr class="tr">
                <td class="td" id="namemeemberregistergift">Member Name<span style="color:#ff0000">*</span></td>
                    <td id="IDMembertdgift"  style="border: 1px;">
                        <input type="text" name="term" id="termgift" placeholder="search member here...."
                            class="form-control" tabindex="2" disabled>
                    </td>
                    <td class="td" id="nonmembernamegift" style="display:none;">Full Name</td>
                    <td id="fieldtestgift" style="border: 1px; display: table-cell;display:none;">
                        <input id="namenonmembergift" class="form-control" type="text" name="namenonmember"
                            placeholder="Full Name">
                    </td>

                    <input type="text" style="display:none" name="termMember" id="termMembergift"
                        placeholder="search member here...." class="form-control">

                    <td class="td">Member Id</td>
                    <td class="td"><input type="text" name='demmember' id="demmembergift" class="form-control input-sm"
                            aria-required="true" readonly tabindex="3">
                    </td>
                </tr>
                <tr class="tr">
                <td class="td">Spouse Name</td>
                    <td class="td"><input id="spousenamegift" class="form-control input-sm" type="text"
                            placeholder="Spouse Name" value="" name="spousename" tabindex="4"></td>

                    <td class="td">Purpose</td>
                    <td class="td">
                        <input type="text" class="form-control input-sm" name="purpose" value="General"
                            selectBoxOptions="General;" tabindex="5">
                    </td>
                </tr>
                <tr class="tr">
                <td class="td"> Street No<span style="color:#ff0000">*</span></td>
                    <td class="td"> <input id="Streetgift" class="form-control input-sm" type="text" placeholder="Street No"
                            value="" name="Street" tabindex="6" required></td>

                    <td class="td">Address<span style="color:#ff0000">*</span></td>
                    <td class="td"> <input id="ressidentalAddressgift" class="form-control input-sm" type="text"
                            placeholder="Address" value="" name="Address" tabindex="7" required></td>

                    
                </tr>
                <tr class="tr">

                <td class="td">City<span style="color:#ff0000">*</span></td>
                    <td class="td"> <input id="citygift" class="form-control input-sm" type="text" name="City" size="25"
                            value="" title="City" placeholder="City" tabindex="8" required></td>

                    <td class="td"> State<span style="color:#ff0000">*</span></td>
                    <td class="td"><select required id="stategift" name="State" value="" class="form-control input-sm">
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
                </tr>
                <tr class="tr">
                <td class="td">Zip<span style="color:#ff0000">*</span></td>
                    <td class="td"> <input id="zip_codegift" class="form-control input-sm" type="text"
                            placeholder="Zip Code" value="" name="Zip_Code" tabindex="10" required></td>

                    <td class="td"> Phone Number<span style="color:#ff0000">*</span></td>
                    <td class="td">
                        <input id="phonegift" class="form-control input-sm" type="text" required=""
                            placeholder="### ###-####" value="" name="Tele1" maxlength="10" tabindex="11" onchange="checkphonenogiftmisc(this.id)">
                    </td>
                </tr>
                <tr class="tr">
                <td class="td">Email<span style="color:#ff0000">*</span></td>
                    <td class="td"><input required="" id="emailgift" class="form-control input-sm" type="text"
                            placeholder="name@company.com" value="" name="email" tabindex="12"
                            pattern="[^@\s]+@[^@\s]+\.[^@\s]+"></td>

                    <td class="td">Amount</span></td>
                    <td class="td">
                 <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                     <input  id="totalgiftdonationamount" class="form-control input-sm" type="number" required="" placeholder="$Amount" value="" name="giftdonationamount" tabindex="16">
                 </div>
                </div>
                   </td>
                </tr>
                <tr class="tr">
                <td class="td" colspan = 2>Payment Method</span></td>
                    <td class="td" colspan = 2>
                        <select name="PaymentOption" id="cashcheck_methodgift" class="form-control input-sm"
                            onchange="paymethodgiftmisc(this.id)" required>
                            <option value="">Please Select</option>
                            <option value="check">Check</option>
                            <option value="cash">Cash</option>
                            <option value="directdeposit">Direct Deposit</option>
                        </select>
                    </td>
                </tr>

                <!-- payment dropdown start -->

                <table class="table table-bordered table-hover table-striped" style="display:none" id="checkdatagiftmisc">
                    <thead>
                        <tr class="tr">
                            <th>Bank Name</th>
                            <th>Check No</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tr">
                            <td class="td"><input style="WIDTH: 100%;" type="text" id="checkbanknamegift"
                                    name="checkbanknamegift" class="form-control input-sm" value=""></td>
                            <td class="td"><input style="WIDTH: 100%;" type="text" id="checknogift" name="checknogift"
                                    class="form-control input-sm" value=""></td>

                            <td class="td">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                        </span>
                                        <input style="WIDTH: 100%;" type="number" id="checkamountgift" name="checkAmountgift"
                                            class="form-control input-sm" value="">
                            </td>
</div>
</div>
<td class="td"><input style="WIDTH: 100%;" type="date" id="checkdategift" name="CheckDategift" class="form-control input-sm"
        value=""></td>
</tr>
</tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="cashdatagiftmisc">
    <thead>
        <tr class="tr">
            <th>Receive By</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="receivebygift" name="ReceiveBygift"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="cashamountgift" name="cashAmountgift"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>
            <td class="td"><input style="WIDTH: 100%;" type="date" id="cashdategift" name="cashDategift"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="directdepositegiftmisc">
    <thead>
        <tr class="tr">
            <th>Bank Name</th>
            <th>Transaction Code</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="banknamegiftmisc" name="banknamegiftmisc"
                    class="form-control input-sm" value=""></td>
            <td class="td"><input style="WIDTH: 100%;" type="text" id="ISFCCodegift" name="transactioncodegift"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="directamountgift" name="directamountgift"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>

            <td class="td"><input style="WIDTH: 100%;" type="date" id="dategiftmisc" name="dategiftmisc"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<!-- payment dropdown end -->
<td class="td" style="display:none;"> <input id="Your_Namegiftmisc" class="form-control input-sm" type="text" name="MemberName"
        style="display:none;"> </td>
</td>
</tabel>
<button class="btn btn-primary" id ='giftreset-btn-id' autocomplete="off" value="reset" name="Reset" tabindex="9" type="submit"><i
        class="fa fa-refresh"></i>&nbsp;&nbsp;Reset</button>&nbsp;&nbsp;&nbsp;
<button class="btn btn-primary" id="submit" autocomplete="off" value="Save" name="submit" tabindex="9" type="submit"><i
        class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Save</button>
</table>
</form>
  
    </section>
</div>


<!-- Gift & misc div end -->


<script>
    $(document).ready(function () {
        debugger
        checkpayfor("donation");
         getcurrentevent();
        $('#ticketday').multiselect();
    });

    function paymethod(elem) {
        debugger
        var con = $("#cashcheck_method").val();
        if (con == "check") {
            $("#checkdata").show();
            $("#cashdata").hide();
            $("#directdeposite").hide();

            $("#receiveby").prop('required', false);
            $("#cashamount").prop('required', false);
            $("#cashdate").prop('required', false);

            $("#bankname").prop('required', false);
            $("#ISFCCode").prop('required', false);
            $("#directamount").prop('required', false);
            $("#directdepositdate").prop('required', false);

            $("#checkbankname").prop('required', true);
            $("#checkno").prop('required', true);
            $("#checkamount").prop('required', true);
            $("#checkdate").prop('required', true);

        } else if (con == "cash") {
            $("#cashdata").show();
            $("#checkdata").hide();
            $("#directdeposite").hide();

            $("#checkbankname").prop('required', false);
            $("#checkno").prop('required', false);
            $("#checkamount").prop('required', false);
            $("#checkdate").prop('required', false);

            $("#bankname").prop('required', false);
            $("#ISFCCode").prop('required', false);
            $("#directamount").prop('required', false);
            $("#directdepositdate").prop('required', false);

            $("#receiveby").prop('required', true);
            $("#cashamount").prop('required', true);
            $("#cashdate").prop('required', true);


        } else if (con == "directdeposit") {
            $("#directdeposite").show();
            $("#cashdata").hide();
            $("#checkdata").hide();

            $("#checkbankname").prop('required', false);
            $("#checkno").prop('required', false);
            $("#checkamount").prop('required', false);
            $("#checkdate").prop('required', false);

            $("#receiveby").prop('required', false);
            $("#cashamount").prop('required', false);
            $("#cashdate").prop('required', false);

            $("#bankname").prop('required', true);
            $("#ISFCCode").prop('required', true);
            $("#directamount").prop('required', true);
            $("#directdepositdate").prop('required', true);

        }
        else {
            $("#cashdata").hide();
            $("#checkdata").hide();
            $("#directdeposite").hide();
        }


    }
     $(function(){
    $('input[type="text"]').change(function(){
        this.value = $.trim(this.value);
    });
});

    $(function () {
        bindAdminMemberAutocomplete({
            term: "#term",
            memberToken: "#termMember",
            name: "#Your_Name",
            memberId: "#demmember",
            spouse: "#spousename",
            street: "#Street",
            address: "#ressidentalAddress",
            state: "#state",
            city: "#city",
            zip: "#zip_code",
            phone: "#phone",
            email: "#email"
        });
        bindAdminMemberAutocomplete({
            term: "#eventterm",
            memberToken: "#termMemberevent",
            name: "#eventYour_Name",
            memberId: "#demmemberevent",
            phone: "#Tele1",
            email: "#Email"
        });
        bindAdminMemberAutocomplete({
            term: "#ticketterm",
            memberToken: "#termMemberticket",
            name: "#ticketYour_Name",
            memberId: "#demmemberticket",
            phone: "#ticketTele1",
            email: "#Emailticket"
        });
        bindAdminMemberAutocomplete({
            term: "#termgift",
            memberToken: "#termMembergift",
            name: "#Your_Namegiftmisc",
            memberId: "#demmembergift",
            spouse: "#spousenamegift",
            street: "#Streetgift",
            address: "#ressidentalAddressgift",
            state: "#stategift",
            city: "#citygift",
            zip: "#zip_codegift",
            phone: "#phonegift",
            email: "#emailgift"
        });

        setupAdminMemberMode("#registrationmemberevent", {
            term: "#eventterm",
            memberToken: "#termMemberevent",
            memberNameLabel: "#namemeemberregisterevent",
            memberFieldCell: "#IDMembertdevent",
            nonMemberLabel: "#nonmembernameevent",
            nonMemberCell: "#fieldtestevent",
            nonMemberName: "#namenonmemberevent",
            memberId: "#demmemberevent",
            name: "#eventYour_Name",
            phone: "#Tele1",
            email: "#Email"
        });
        setupAdminMemberMode("#ticketregistrationmember", {
            term: "#ticketterm",
            memberToken: "#termMemberticket",
            memberNameLabel: "#ticketnamemeemberregister",
            memberFieldCell: "#IDMembertdticket",
            nonMemberLabel: "#ticketnonmembername",
            nonMemberCell: "#ticketfield",
            nonMemberName: "#ticketnamenonmember",
            memberId: "#demmemberticket",
            name: "#ticketYour_Name",
            phone: "#ticketTele1",
            email: "#Emailticket"
        });
        setupAdminMemberMode("#registrationmembergiftmisc", {
            term: "#termgift",
            memberToken: "#termMembergift",
            memberNameLabel: "#namemeemberregistergift",
            memberFieldCell: "#IDMembertdgift",
            nonMemberLabel: "#nonmembernamegift",
            nonMemberCell: "#fieldtestgift",
            nonMemberName: "#namenonmembergift",
            memberId: "#demmembergift",
            name: "#Your_Namegiftmisc",
            spouse: "#spousenamegift",
            street: "#Streetgift",
            address: "#ressidentalAddressgift",
            state: "#stategift",
            city: "#citygift",
            zip: "#zip_codegift",
            phone: "#phonegift",
            email: "#emailgift"
        });
    });

    function bindAdminMemberAutocomplete(config) {
        $(config.term).autocomplete({
            source: '<?= INSTALL_URL ?>ajax-db-search.php',
            select: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value || "";
                var f_name = name.split(",");
                $(config.term).val($.trim(f_name[0]));
                $(config.memberToken).val(ui.item.id);
                selectAdminPaymentMember(config);
            }
        });
    }

    function getMemberResponseValue(res, id) {
        var element = $(res).filter("input#" + id);
        return element.length ? element[0].value : "";
    }

    function setAdminPaymentField(selector, value) {
        if (selector && $(selector).length) {
            $(selector).val(value || "");
        }
    }

    function selectAdminPaymentMember(config) {
        var url2 = $("#container-abc-url-id").text();
        var data = $(config.memberToken).val();
        var term = $(config.term).val();
        if (term != "") {
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
                        var memberName = getMemberResponseValue(res, "MemberName");
                        var lastName = getMemberResponseValue(res, "last_name");
                        var spouseName = getMemberResponseValue(res, "Spouse");
                        var spouseLastName = getMemberResponseValue(res, "Spouselast");

                        setAdminPaymentField(config.name, $.trim(memberName + " " + lastName));
                        setAdminPaymentField(config.memberId, getMemberResponseValue(res, "memberid"));
                        setAdminPaymentField(config.spouse, $.trim(spouseName + " " + spouseLastName));
                        setAdminPaymentField(config.street, getMemberResponseValue(res, "ressidentalAddress"));
                        setAdminPaymentField(config.address, getMemberResponseValue(res, "Address"));
                        setAdminPaymentField(config.state, getMemberResponseValue(res, "state"));
                        setAdminPaymentField(config.city, getMemberResponseValue(res, "city"));
                        setAdminPaymentField(config.zip, getMemberResponseValue(res, "zip_code"));
                        setAdminPaymentField(config.phone, getMemberResponseValue(res, "Tele1"));
                        setAdminPaymentField(config.email, getMemberResponseValue(res, "email"));
                    }

                });
            } else {
                clearAdminPaymentMember(config);
            }
        }
    }

    function clearAdminPaymentMember(config) {
        setAdminPaymentField(config.term, "");
        setAdminPaymentField(config.memberToken, "");
        setAdminPaymentField(config.name, "");
        setAdminPaymentField(config.memberId, "");
        setAdminPaymentField(config.spouse, "");
        setAdminPaymentField(config.street, "");
        setAdminPaymentField(config.address, "");
        setAdminPaymentField(config.state, "");
        setAdminPaymentField(config.city, "");
        setAdminPaymentField(config.zip, "");
        setAdminPaymentField(config.phone, "");
        setAdminPaymentField(config.email, "");
    }

    function setupAdminMemberMode(selectSelector, config) {
        $(selectSelector).on("change", function () {
            var selectVal = $(this).val();
            clearAdminPaymentMember(config);
            setAdminPaymentField(config.nonMemberName, "");
            if (selectVal == "member") {
                $(config.term).prop("disabled", false).prop("required", true);
                $(config.memberFieldCell).show().removeClass("disabledbutton");
                $(config.memberNameLabel).show();
                $(config.nonMemberLabel).hide();
                $(config.nonMemberCell).hide();
                $(config.nonMemberName).prop("required", false);
            } else if (selectVal == "nonmember") {
                $(config.term).prop("disabled", true).prop("required", false);
                $(config.memberFieldCell).hide().addClass("disabledbutton");
                $(config.memberNameLabel).hide();
                $(config.nonMemberLabel).show();
                $(config.nonMemberCell).show();
                $(config.nonMemberName).prop("required", true);
            } else {
                $(config.term).prop("disabled", true).prop("required", false);
                $(config.memberFieldCell).show().addClass("disabledbutton");
                $(config.memberNameLabel).show();
                $(config.nonMemberLabel).hide();
                $(config.nonMemberCell).hide();
                $(config.nonMemberName).prop("required", false);
            }
        });
    }

    function memberhceck() {
        debugger;
        var regmember = $("#registrationmember").val();
        selectVal = $('#registrationmember').val();
        if (selectVal == "member") {
            $("#IDMembertd").removeClass("disabledbutton");
            document.getElementById("spousename").value = "";
            document.getElementById("Street").value = "";
            document.getElementById("ressidentalAddress").value = "";
            document.getElementById("city").value = "";
            document.getElementById("state").value = "";
            document.getElementById("zip_code").value = "";
            document.getElementById("email").value = "";
            document.getElementById("phone").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("MembCategory").value = "";
            document.getElementById("term").value = "";
            document.getElementById("demmember").value = "";
            $('#nonmembername').hide();
            $('#fieldtest').hide();
            $('#namemeemberregister').show();
            $('#IDMembertd').show();
            $("#namenonmember").prop('required', false);
            $("#term").prop('required', true);

        }
        if (selectVal == "nonmember") {
            $("#IDMembertd").addClass("disabledbutton");
            document.getElementById("spousename").value = "";
            document.getElementById("Street").value = "";
            document.getElementById("ressidentalAddress").value = "";
            document.getElementById("city").value = "";
            document.getElementById("state").value = "";
            document.getElementById("zip_code").value = "";
            document.getElementById("email").value = "";
            document.getElementById("phone").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("MembCategory").value = "";
            document.getElementById("term").value = "";
            document.getElementById("demmember").value = "";
            $('#namemeemberregister').hide();
            $('#IDMembertd').hide();
            $('#nonmembername').show();
            $('#fieldtest').show();
            $("#fieldtest").prop('readonly', true);
            $("#namenonmember").prop('required', true);
            $("#term").prop('required', false);

        }
        if (selectVal == "" || selectVal == " ") {
            document.getElementById("demmember").value = "";
            document.getElementById("spousename").value = "";
            document.getElementById("Street").value = "";
            document.getElementById("ressidentalAddress").value = "";
            document.getElementById("city").value = "";
            document.getElementById("state").value = "";
            document.getElementById("zip_code").value = "";
            document.getElementById("email").value = "";
            document.getElementById("phone").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("MembCategory").value = "";
            document.getElementById("term").value = "";
            $("#IDMembertd").removeClass("disabledbutton");
        }

    }


    function checkpayfor(e) {
        var paymenttype = "";
        if (e.value == undefined) {
            document.getElementById("paymentfor").value = "donation";
            paymenttype = e;

        } else {
            paymenttype = e.value;
        }


        if (paymenttype == "donation") {
            document.getElementById('lookupdiv').style.display = 'none';
            document.getElementById('eventdiv').style.display = 'none';
            document.getElementById('ticketdiv').style.display = 'none';
            document.getElementById('giftmiscdiv').style.display = 'none';
            document.getElementById('donationdiv').style.removeProperty('display');
        }
        else if (paymenttype == "member") {
            document.getElementById('donationdiv').style.display = 'none';
            document.getElementById('eventdiv').style.display = 'none';
            document.getElementById('ticketdiv').style.display = 'none';
            document.getElementById('giftmiscdiv').style.display = 'none';
            document.getElementById('lookupdiv').style.removeProperty('display');

        }
        else if (paymenttype == "event") {
            document.getElementById('donationdiv').style.display = 'none';
            document.getElementById('lookupdiv').style.display = 'none';
            document.getElementById('ticketdiv').style.display = 'none';
            document.getElementById('giftmiscdiv').style.display = 'none';
            document.getElementById('eventdiv').style.removeProperty('display');
        }
        else if (paymenttype == "ticket") {
            document.getElementById('donationdiv').style.display = 'none';
            document.getElementById('lookupdiv').style.display = 'none';
            document.getElementById('eventdiv').style.display = 'none';
            document.getElementById('giftmiscdiv').style.display = 'none';
            document.getElementById('ticketdiv').style.removeProperty('display');
        }
        else if (paymenttype == "giftmisc") {
            document.getElementById('donationdiv').style.display = 'none';
            document.getElementById('lookupdiv').style.display = 'none';
            document.getElementById('eventdiv').style.display = 'none';
            document.getElementById('ticketdiv').style.display = 'none';
            document.getElementById('giftmiscdiv').style.removeProperty('display');
        }
        else {
            document.getElementById('donationdiv').style.display = 'none';
            document.getElementById('lookupdiv').style.display = 'none';
            document.getElementById('eventdiv').style.display = 'none';
            document.getElementById('ticketdiv').style.display = 'none';
            document.getElementById('giftmiscdiv').style.display = 'none';
        }
    }

    function lookuppaymethod(elem) {
        debugger
        var renewprice = $("#total").val();
        var paymethod = $("#meberpaymethod").val();
        if (renewprice !== "") {
            if (paymethod == "check") {
                $("#tablecheck").show();
                $("#tablecash").hide();
                $("#directdepositetable").hide();

                $("#lookupdirectbankname").prop('required', false);
                $("#lookupISFCCode").prop('required', false);
                $("#lookupdirectamount").prop('required', false);
                $("#lookupdirectdate").prop('required', false);

                $("#lookupreceiveby").prop('required', false);
                $("#lookupcashamount").prop('required', false);
                $("#loookupcashdate").prop('required', false);

                $("#lookupcheckbankname").prop('required', true);
                $("#lookupcheckno").prop('required', true);
                $("#lookupcheckamount").prop('required', true);
                $("#lookupcheckdate").prop('required', true);


            } else if (paymethod == "cash") {
                $("#tablecash").show();
                $("#tablecheck").hide();
                $("#directdepositetable").hide();

                $("#lookupcheckbankname").prop('required', false);
                $("#lookupcheckno").prop('required', false);
                $("#lookupcheckamount").prop('required', false);
                $("#lookupcheckdate").prop('required', false);

                $("#lookupdirectbankname").prop('required', false);
                $("#lookupISFCCode").prop('required', false);
                $("#lookupdirectamount").prop('required', false);
                $("#lookupdirectdate").prop('required', false);


                $("#lookupreceiveby").prop('required', true);
                $("#lookupcashamount").prop('required', true);
                $("#loookupcashdate").prop('required', true);
            } else if (paymethod == "directdeposit") {
                $("#directdepositetable").show();
                $("#tablecash").hide();
                $("#tablecheck").hide();

                $("#lookupcheckbankname").prop('required', false);
                $("#lookupcheckno").prop('required', false);
                $("#lookupcheckamount").prop('required', false);
                $("#lookupcheckdate").prop('required', false);

                $("#lookupreceiveby").prop('required', false);
                $("#lookupcashamount").prop('required', false);
                $("#loookupcashdate").prop('required', false);

                $("#lookupdirectbankname").prop('required', true);
                $("#lookupISFCCode").prop('required', true);
                $("#lookupdirectamount").prop('required', true);
                $("#lookupdirectdate").prop('required', true);

            }
            else {
                $("#tablecash").hide();
                $("#tablecheck").hide();
                $("#directdepositetable").hide();
            }
        }
    }


    function checkphoneno(elem) {
        //debugger;
        const phonenumber = $("#phone").val();
        if (!!phonenumber) {
            if (isNaN(phonenumber)) {
                alert("Please Enter mobile Number");
                $("#submit").addClass('disabled');
                //document.getElementById("totalamount").value = price; 
            }
            else if (phonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#submit").addClass('disabled');
            }
            else if (phonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#submit").addClass('disabled');
            }
            else if (phonenumber.length == 10) {
                $("#submit").removeClass('disabled');
            }
            else {
                $("#submit").removeClass('disabled');
            }
        }
        else {
            $("#phone").prop('required', true);
            $("#submit").removeClass('disabled');
        }
    }


    function lookupcheckphoneno(elem) {
        //debugger;
        const lookupphonenumber = $(lookupphone).val();
        if (!!phonenumber) {
            if (isNaN(lookupphonenumber)) {
                alert("Please Enter mobile Number");
                $("#member_btn_id").addClass('disabled');
                //document.getElementById("totalamount").value = price; 
            }
            else if (lookupphonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#member_btn_id").addClass('disabled');
            }
            else if (lookupphonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#member_btn_id").addClass('disabled');
            }
            else if (lookupphonenumber.length == 10) {
                $("#member_btn_id").removeClass('disabled');
            }
            else {
                $("#member_btn_id").removeClass('disabled');
            }
        }
        else {
            $("#lookupphone").prop('required', true);
            $("#member_btn_id").removeClass('disabled');
        }
    }
    // event js work start
    
    function  getcurrentevent(){
        //debugger;
        $.ajax({
            type: "POST",
            //url: "http://localhost/HDBS_Payment/PriestMember/load.php?controller=Event&action=getevent",  
            url: "<?= INSTALL_URL ?>load.php?controller=Event&action=getevent",
            success: function (res) {
                $('#eventtype').empty(); //remove all child nodes
                var eventOption = $(res);
                var newOption = $('<option value="">Please select Event Name</option>');
                $('#eventtype').append(newOption);
                $('#eventtype').append(eventOption);
                $('#eventtype').trigger("chosen:updated");
            }
        });
    }
    
   function eventcurrentrun() {
        var eventdayid = $("#eventtype").val();
        $("#eventnamehidden").val("");
        
        $.ajax({
            type: "POST",
            data: {
                checkdatevalid: eventdayid,
               
            },

            //url: "http://localhost/HDBS_Payment/PriestMember/load.php?controller=Event&action=checkdateevent",
            url: "<?= INSTALL_URL ?>load.php?controller=Event&action=checkdateevent",
            success: function (res) {
                var priceimage = $(res).filter("input#dataprice");
                if (priceimage.length) {
                    LastName = priceimage[0].value;
                }
                var parts = LastName.split("/");
                var namepuja = parts[0];
                var puja = parts[1];

                document.getElementById("Amount").value = namepuja;
                //document.getElementById("totalamount").value = namepuja;
                document.getElementById("eventnamehidden").value = puja;
                var eventuniqueid = $(res).filter("input#uniqueeventid");
                if (eventuniqueid.length) {
                    finaluniqueid = eventuniqueid[0].value;
                    document.getElementById("eventid").value = finaluniqueid;
                }


            }
        });
    }


    // For event payment dropdown
    function paymethodevent(elem) {
        debugger
        var con = $("#cashcheck_methodevent").val();
        if (con == "check") {
            $("#checkdataevent").show();
            $("#cashdataevent").hide();
            $("#directdepositeevent").hide();

            $("#eventreceiveby").prop('required', false);
            $("#eventcashamount").prop('required', false);
            $("#eventcashdate").prop('required', false);

            $("#eventdirectbankname").prop('required', false);
            $("#eventISFCCode").prop('required', false);
            $("#eventdirectamount").prop('required', false);
            $("#eventdate").prop('required', false);

            $("#eventbankname").prop('required', true);
            $("#eventcheckno").prop('required', true);
            $("#eventcheckamount").prop('required', true);
            $("#eventcheckdate").prop('required', true);

        } else if (con == "cash") {
            $("#cashdataevent").show();
            $("#checkdataevent").hide();
            $("#directdepositeevent").hide();

            $("#eventbankname").prop('required', false);
            $("#eventcheckno").prop('required', false);
            $("#eventcheckamount").prop('required', false);
            $("#eventcheckdate").prop('required', false);

            $("#eventdirectbankname").prop('required', false);
            $("#eventISFCCode").prop('required', false);
            $("#eventdirectamount").prop('required', false);
            $("#eventdate").prop('required', false);

            $("#eventreceiveby").prop('required', true);
            $("#eventcashamount").prop('required', true);
            $("#eventcashdate").prop('required', true);


        } else if (con == "directdeposit") {
            $("#directdepositeevent").show();
            $("#cashdataevent").hide();
            $("#checkdataevent").hide();

            $("#eventbankname").prop('required', false);
            $("#eventcheckno").prop('required', false);
            $("#eventcheckamount").prop('required', false);
            $("#eventcheckdate").prop('required', false);

            $("#eventreceiveby").prop('required', false);
            $("#eventcashamount").prop('required', false);
            $("#eventcashdate").prop('required', false);

            $("#eventdirectbankname").prop('required', true);
            $("#eventISFCCode").prop('required', true);
            $("#eventdirectamount").prop('required', true);
            $("#eventdate").prop('required', true);

        }
        else {
            $("#cashdataevent").hide();
            $("#checkdataevent").hide();
            $("#directdepositeevent").hide();
        }
    }
    // event phone no condition 
    function eventphone(elem) {
        //debugger;
        const phonenumber = $("#Tele1").val();
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
            $("#Tele1").prop('required', true);
            $("#payment_btn_id").removeClass('disabled');
        }
    }
    // For ticket payment dropdown
    function paymethodticket(elem) {
        debugger
        var con = $("#cashcheck_methodticket").val();
        if (con == "check") {
            $("#checkdataticket").show();
            $("#cashdataticket").hide();
            $("#directdepositeticket").hide();

            $("#ticketreceiveby").prop('required', false);
            $("#ticketcashamount").prop('required', false);
            $("#ticketcashdate").prop('required', false);

            $("#ticketdirectbankname").prop('required', false);
            $("#ticketISFCCode").prop('required', false);
            $("#ticketdirectamount").prop('required', false);
            $("#ticketdate").prop('required', false);

            $("#ticketbankname").prop('required', true);
            $("#ticketcheckno").prop('required', true);
            $("#ticketcheckamount").prop('required', true);
            $("#ticketcheckdate").prop('required', true);

        } else if (con == "cash") {
            $("#cashdataticket").show();
            $("#checkdataticket").hide();
            $("#directdepositeticket").hide();

            $("#ticketbankname").prop('required', false);
            $("#ticketcheckno").prop('required', false);
            $("#ticketcheckamount").prop('required', false);
            $("#ticketcheckdate").prop('required', false);

            $("#ticketdirectbankname").prop('required', false);
            $("#ticketISFCCode").prop('required', false);
            $("#ticketdirectamount").prop('required', false);
            $("#ticketdate").prop('required', false);

            $("#ticketreceiveby").prop('required', true);
            $("#ticketcashamount").prop('required', true);
            $("#ticketcashdate").prop('required', true);


        } else if (con == "directdeposit") {
            $("#directdepositeticket").show();
            $("#cashdataticket").hide();
            $("#checkdataticket").hide();

            $("#ticketbankname").prop('required', false);
            $("#ticketcheckno").prop('required', false);
            $("#ticketcheckamount").prop('required', false);
            $("#ticketcheckdate").prop('required', false);

            $("#ticketreceiveby").prop('required', false);
            $("#ticketcashamount").prop('required', false);
            $("#ticketcashdate").prop('required', false);

            $("#ticketdirectbankname").prop('required', true);
            $("#ticketISFCCode").prop('required', true);
            $("#ticketdirectamount").prop('required', true);
            $("#ticketdate").prop('required', true);

        }
        else {
            $("#cashdataticket").hide();
            $("#checkdataticket").hide();
            $("#directdepositeticket").hide();
        }
    }

    // event phone no condition 
    function ticketphone(elem) {
        debugger;
        const phonenumber = $("#ticketTele1").val();
        if (!!phonenumber) {
            if (isNaN(phonenumber)) {
                alert("Please Enter mobile Number");
                $("#payment_btn_idticket").addClass('disabled');
                //document.getElementById("totalamount").value = price; 
            }
            else if (phonenumber.length > 10) {
                alert("Number should be 10 digits");
                $("#payment_btn_idticket").addClass('disabled');
            }
            else if (phonenumber.length < 10) {
                alert("Number should be 10 digits");
                $("#payment_btn_idticket").addClass('disabled');
            }
            else if (phonenumber.length == 10) {
                $("#payment_btn_idticket").removeClass('disabled');
            }
            else {
                $("#payment_btn_idticket").removeClass('disabled');
            }
        }
        else {
            $("#ticketTele1").prop('required', true);
            $("#payment_btn_idticket").removeClass('disabled');
        }
    }


    // function for calculate ticket price

    function ticketqunatity() {
        debugger;
        //var ticketdaynew = $("#ticketday").text();
        var ticketweekprice = $("#ticketday").val();
        var titketquantity = $("#quantity").val();
        if (ticketweekprice == null) {
            alert('Please Select Event Day First')
            $("#quantity").val("");
            $("#Amount").val("");
            $("#totalamount").val("");
        }
        if(ticketweekprice != null){
        var selected = [];
        var selectedday = [];
        for (var option of document.getElementById('ticketday').options) {
            if (option.selected) {
                var d = option.value.split(',');
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
        document.getElementById("ticketAmount").value = sum;
        document.getElementById("totalamount").value = finalamount;
        document.getElementById("Days").value = selectedday;
    }
    }
//for gift payment 
function paymethodgiftmisc(elem) {
        debugger
        var con = $("#cashcheck_methodgift").val();
        if (con == "check") {
            $("#checkbanknamegift").val("");
            $("#checknogift").val("");
            $("#checkamountgift").val("");
            $("#checkdategift").val("");
            $("#banknamegiftmisc").val("");
            $("#ISFCCodegift").val("");
            $("#directamountgift").val("");
            $("#dategiftmisc").val("");
            $("#receivebygift").val("");
            $("#cashamountgift").val("");
            $("#cashdategift").val("");

            $("#checkdatagiftmisc").show();
            $("#cashdatagiftmisc").hide();
            $("#directdepositegiftmisc").hide();

            $("#receivebygift").prop('required', false);
            $("#cashamountgift").prop('required', false);
            $("#cashdategift").prop('required', false);

            $("#banknamegiftmisc").prop('required', false);
            $("#ISFCCodegift").prop('required', false);
            $("#directamountgift").prop('required', false);
            $("#dategiftmisc").prop('required', false);

            $("#checkbanknamegift").prop('required', true);
            $("#checknogift").prop('required', true);
            $("#checkamountgift").prop('required', true);
            $("#checkdategift").prop('required', true);
        } else if (con == "cash") {
            $("#checkbanknamegift").val("");
            $("#checknogift").val("");
            $("#checkamountgift").val("");
            $("#checkdategift").val("");
            $("#banknamegiftmisc").val("");
            $("#ISFCCodegift").val("");
            $("#directamountgift").val("");
            $("#dategiftmisc").val("");
            $("#receivebygift").val("");
            $("#cashamountgift").val("");
            $("#cashdategift").val("");

			$("#checkdatagiftmisc").hide();
            $("#cashdatagiftmisc").show();
            $("#directdepositegiftmisc").hide();

            $("#checkbanknamegift").prop('required', false);
            $("#checknogift").prop('required', false);
            $("#checkamountgift").prop('required', false);
            $("#checkdategift").prop('required', false);

            $("#banknamegiftmisc").prop('required', false);
            $("#ISFCCodegift").prop('required', false);
            $("#directamountgift").prop('required', false);
            $("#dategiftmisc").prop('required', false);

           $("#receivebygift").prop('required', true);
            $("#cashamountgift").prop('required', true);
            $("#cashdategift").prop('required', true);

                    
        } else if (con == "directdeposit") {
            $("#checkbanknamegift").val("");
            $("#checknogift").val("");
            $("#checkamountgift").val("");
            $("#checkdategift").val("");
            $("#banknamegiftmisc").val("");
            $("#ISFCCodegift").val("");
            $("#directamountgift").val("");
            $("#dategiftmisc").val("");
            $("#receivebygift").val("");
            $("#cashamountgift").val("");
            $("#cashdategift").val("");

            $("#checkdatagiftmisc").hide();
            $("#cashdatagiftmisc").hide();
            $("#directdepositegiftmisc").show();

            $("#checkbanknamegift").prop('required', false);
            $("#checknogift").prop('required', false);
            $("#checkamountgift").prop('required', false);
            $("#checkdategift").prop('required', false);

            $("#receivebygift").prop('required', false);
            $("#cashamountgift").prop('required', false);
            $("#cashdategift").prop('required', false);

            $("#banknamegiftmisc").prop('required', true);
            $("#ISFCCodegift").prop('required', true);
            $("#directamountgift").prop('required', true);
            $("#dategiftmisc").prop('required', true);

        }
        else {
            $("#checkbanknamegift").val("");
            $("#checknogift").val("");
            $("#checkamountgift").val("");
            $("#checkdategift").val("");
            $("#banknamegiftmisc").val("");
            $("#ISFCCodegift").val("");
            $("#directamountgift").val("");
            $("#dategiftmisc").val("");
            $("#receivebygift").val("");
            $("#cashamountgift").val("");
            $("#cashdategift").val("");
            $("#checkdatagiftmisc").hide();
            $("#cashdatagiftmisc").hide();
            $("#directdepositegiftmisc").hide();
        }
    }
// phone no validation gift 
    function checkphonenogiftmisc(elem){
        //debugger;
    const phonenumber =  $("#phonegift").val();
        if(!!phonenumber){
         if(isNaN(phonenumber)){  
            alert("Please Enter mobile Number");
            $("#submit").addClass('disabled');
            //document.getElementById("totalamount").value = price; 
         }
         else if(phonenumber.length > 10 ){
              alert("Number should be 10 digits");
              $("#submit").addClass('disabled');  
         }
         else if(phonenumber.length < 10){
            alert("Number should be 10 digits");
            $("#submit").addClass('disabled');  
         }
         else if(phonenumber.length == 10){  
            $("#submit").removeClass('disabled');
         }
         else{
            $("#submit").removeClass('disabled');
         }
        }
        else{
            $("#phonegift").prop('required',true);
            $("#submit").removeClass('disabled');
        }
     }  

</script>
