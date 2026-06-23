<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
</head>
<style>
        input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}

.ui-datepicker-calendar {
    display: none;
}

.ui-datepicker-month {
    display: none;
}

.padding-19 {
    display: none;
}
.ui-icon-circle-triangle-w{
width:35px!important;
}
.ui-icon.ui-icon-circle-triangle-e{
width:35px!important;
margin-left: -29px!important;
font: bold;
}

h4 {
    text-align: center;
    font-family: initial;
}
#payment-form > fieldset.asb > table:nth-child(12) > tbody > tr:nth-child(2) > td > div{display:none;}
#payment-form > fieldset.asb > table:nth-child(12) > tbody > tr:nth-child(3) > td > div{display:none;}
#payment-form > fieldset.asb > table:nth-child(12) > tbody > tr:nth-child(4) > td > div{display:none;}
#payment-form > fieldset.asb > table:nth-child(12) > tbody > tr:nth-child(5) > td > div{display:none;}
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
$decaldb = $img ?? null;
if (!empty($tpl['arr'])) {
    require 'show.php';
} else {
    ?>
<div id="menu-container" style="width: 70%; margin:3px auto; background-color:rgba(237,237,237) !important;">
    <div id="page-body">
        <main role="main">
            <div class="logo" style="background-color: #357ca5;">
                <img src="../logo.jpg" class="profile" />
                <h3><b>Houston Durga Bari Society</b></h4>
                    <h4><b>Contact: treasurer@durgabari.org </b></h4>
                    <h1 class="logo-caption"><span class="tweak">M</span>embership <span class="tweak">F</span>orm</h1>
            </div>
            <!-- logo class -->
            <form id="payment-form" class="form-horizontal" method="post" action="" role="form"
                enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <input type="hidden" name="login_user" value="1" />
                <fieldset class="asb">
                    <table class="table">
                        <tr colspan="8" class="tr">
                            <td class="td">Applicant Information <span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input type="radio" id="new" name="information" value="new" Checked>New
                            </td>
                            <td class="td">

                                <?php echo __('Member ID'); ?>

                            </td>
                            <td class="td MemberID">

                                <input id="Member id" class="form-control input-sm" type="text" name="Member_id"
                                    size="12" value="" title="MemberID" placeholder="Member ID" readonly>


                            </td>
                            <td class="td">Date of Renewal<span style="color:#ff0000"></span></td>
                            <td class="td">
                                <input id="Renew_date" class="form-control input-sm" type="text" name="Renew_date"
                                    size="12" value="" title="Renew Date" placeholder="Renewal Date" readonly>
                            </td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr class="tr">
                            <td class="td">Member's First Name<span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input required="true" id="Your_Name" class="form-control input-sm" type="text"
                                    name="F_Name" size="25" value="" title="First Name" placeholder="First Name">
                            </td>
                            <td class="td">Middle Name</td>
                            <td class="td">
                                <input id="middle name" class="form-control input-sm" type="text" name="M_Name"
                                    size="25" value="" title="Middle Name" placeholder="Middle Name">
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td">Last Name <span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input required="true" id="last name" class="form-control input-sm" type="text"
                                    name="L_Name" size="25" value="" title="Last Name" placeholder="Last Name">
                                <!--  -->
                            </td>
                            <td class="td">
                                Membership Type<span style="color:#ff0000">*</span>
                            </td>
                            <td class="td">
                                <input type="radio" id="individual_membership" name="membership_type"
                                    value="IND" checked />
                                Individual Membership<br>
                                <input type="radio" id="family_membership" name="membership_type"
                                    value="FAM" />
                                Family Membership
                            </td>

                        </tr>
                        <tr class="tr">
                            <td class="td">Spouse Name</td>
                            <td class="td">
                                <input  id="Spousefirst" class="form-control input-sm" type="text"
                                    name="Sp_FName" size="25" value="" title="Spouse Name" placeholder="Spouse Name" readonly>
                            </td>
                            <td class="td">
                                Last Name </td>
                            <td class="td">
                                <input  id="Spouselast" class="form-control input-sm" type="text"
                                    name="Sp_LName" size="25" value="" title="Spouse Last Name"
                                    placeholder="Spouse Last Name" readonly>
                            </td>
                        </tr>
                        <tr class="tr">
                            <!-- <td  class="td">Govt Issued Photo ID/No:<span style="color:#ff0000">*</span></td>
                                <td  class="td"> 
                                    <input type="radio" id="checked" name="GovtissueID" value="checked" checked />
                                     Available
                                     <input type="radio" id="not_available" name="GovtissueID" value="not_available" />
                                     Not Available
                                </td> -->
                             <!-- <td class="td">
                            Residential Address<span style="color:#ff0000">*</span>
                        </td> -->
                          <!-- <td class="td">
                           Street No <span style="color:#ff0000">*</span>
                        </td> -->
                        <td class="td">
                        Street No   <span style="color:#ff0000">*</span>
                        </td>
                            <td class="td">
                             <input required="true" id="Address" class="form-control input-sm" type="text"
                                 name="Address1" size="25" value="" title="Address" placeholder="Street No">
                                 
                            </td>
                             <td class="td">Address<span style="color:#ff0000">*</span> 

                            <td class="td">
                                <input id="Address" class="form-control input-sm" type="text" name="Address2" size="25"
                                    value="" title="Address" placeholder="Address" required="true">
                            </td>
                            <!-- <td class="td">
                                <input id="Address" class="form-control input-sm" type="text" name="Address3" size="25"
                                    value="" title="Address" placeholder="Appartment No" > -->
                            </td>
                        </tr>
                        <tr class="tr">
                        <td class="td">Country</td>
                        <td class="td"><div class="dropdown">
                        <input id="Country" class="form-control input-sm" type="text" 
                                    title="Country" placeholder="USA" readonly>
    <!--<select id="Country" name="Country" class="form-control input-sm medium valid"  style="width:100%!important;  height:50%;" >
    <option value="USA">United States of America</option>
   
     <?php
    foreach (($tpl['Country'] ?? []) as $key => $value) {
        ?>
       
        <option value="<?php echo $value['CountryCode']; ?>"><?php echo $value['Country']; ?></option> 
        <?php
    }
    ?>
    </select> -->
    </div>   </td>
                            <td class="td">City<span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input required="true" id="city" class="form-control input-sm" type="text" name="City"
                                    size="25" value="" title="City" placeholder="City">
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td">State<span style="color:#ff0000">*</span> </td>
                            <td class="td">
                                <select required id="states" style="width: 100%!important;height: 36px!important;" 
                                        name="State" value="" class="form-control input-sm medium valid">
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

                            </td> .
                            <td class="td">Zip Code<span style="color:#ff0000">*</span></td>
                            <td class="td">
                                <input required="true" id="zip_code" class="form-control input-sm" type="text"
                                    name="Zip" size="25" value="" title="Zip Code" placeholder="Zip Code">
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td">Mobile<span style="color:#ff0000">*</span> </td> 
                            <td class="td">
                            <!-- <input class="form-control input-sm" id="phone_mobile" name="Tele1" type="number" placeholder="Phone" data-rule-required="true" required="true" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==10 && event.keyCode!=8) return false;"> -->
                            <input id="phone_mobile" class="form-control input-sm" placeholder="###) ###-####" type="text"  required="" value="" name="Tele1"  onchange="sponsoramount(this.id)" maxlength="10"> 
                        
                        </td>
                            <!-- <td class="td">
                           <input id="phone_work" class="form-control input-sm" type="text" placeholder="Phone"  value="" name="Mob_No"  onchange="numbercheck(this.id)" maxlength="10"> 
                            </td> -->
                            <td class="td">
                           Home
                        </td>
                            <td class="td">
                            <input id="phone_No" class="form-control input-sm" type="text"  placeholder="###) ###-####" value="" name="Tele2"  onchange="numberduplicatecheck(this.id)"  maxlength="10"> 
                                <!-- <input id="phone_work" class="form-control input-sm" type="number" name="Tele2"
                                    size="25" value="" title="Work Phone" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="Home" maxlength="10"> -->
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td">Email<span style="color:#ff0000">*</span></td>
                            <td class="td">
                               <input type="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required="true" id="email" class="form-control input-sm" type="text" name="email"
                                    size="25" value="" title="Email" placeholder="name@company.com" >
                            </td>
                            <td class="td">Email 2</td>
                            <td class="td">
                                <input id="email2" class="form-control input-sm" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" type="text" name="Email2" size="25"
                                    value="" title="Email 2" placeholder="name@company.com">
                            </td>
                        </tr>
                    </table>
                    <table class="table" id="children" style="display: none;">
                        <tr class="tr">
                        <tr class="tr">
                            <td class="td" colspan="8">
                                <h3>Children's Information</h3>
                            </td>
                        </tr>

                        <tr class="tr">
                            <td colspan="4" class="td">Child 1<input id="Child" class="form-control input-sm"
                                    type="text" name="Child1" size="25" value="" title="Child" placeholder="Full Name">
                            </td>
                            <td class="td">Year of Birth
                            <!-- <input max="<?php echo date('Y-m-d'); ?>" id="year_birth1"
                                    class="form-control input-sm date-picker" name="Age1" size="25" value=""
                                    title="year_birth" placeholder="Year of Birth">-->
                                    <select name="Age1" class="form-control input-sm selectpicker " data-live-search="true" id="yearpicker">
                                         <option>Select year of birth</option>
                                    </select>
                                    
                                    </td>
                            <td class="td">Child 2<input id="Child2" class="form-control input-sm" type="text"
                                    name="Child2" size="25" value="" title="Children" placeholder="Full Name"></td>
                            <td class="td"> Year of Birth
                            
                            
                           <!-- <input max="<?php echo date('Y-m-d'); ?>" id="year_birth2"
                                    class="form-control input-sm date-picker" name="Age2" size="25" value=""
                                    title="year_birth" placeholder="Year of Birth"> -->
                                    
                                      <select name="Age2" class="form-control input-sm selectpicker " data-live-search="true" id="year_birth2">
                                           <option>Select year of birth</option>
                                      </select>
                                    
                                    </td>
                        </tr>
                        <tr class="tr">
                            <td colspan="4" class="td">Child 3<input id="Child3" class="form-control input-sm"
                                    type="text" name="Child3" size="25" value="" title="Child" placeholder="Full Name">
                            </td>
                            <td class="td"> Year of Birth
                            
                             <!--<input max="<?php echo date('Y-m-d'); ?>" id="year_birth3"
                                    class="form-control input-sm date-picker" name="Age3" size="25" value=""
                                    title="year_birth" placeholder="Year of Birth"> -->
                                    
                                    <select name="Age3" class="form-control input-sm selectpicker " data-live-search="true" id="year_birth3">
                                         <option>Select year of birth</option>
                                    </select>
                                    
                                    </td>
                            <td class="td">Child 4<input id="Child4" class="form-control input-sm" type="text"
                                    name="Child4" size="25" value="" title="Child" placeholder="Full Name"></td>
                            <td class="td">Year of Birth
                            
                            
                           <!-- <input max="<?php echo date('Y-m-d'); ?>" id="year_birth4"
                                    class="form-control input-sm date-picker" name="Age4" size="25" value=""
                                    title="year_birth" placeholder="Year of Birth">-->
                                    
                                    <select name="Age4" class="form-control input-sm selectpicker " data-live-search="true"  id="year_birth4">
                                         <option>Select year of birth</option>
                                    </select>
                                    
                                    </td>
                        </tr>
                        </tr>
                    </table>

                    <table class="table">
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <h3>Membership Categories & Payment Details</h3>
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="2"><label class="control-label" for="Child"
                                    style="float:left;">Category<span style="color:#ff0000">*</span></label></td>
                            <td class="td"><label class="control-label" for="Child" style="float:left;">
                                    Rate</label><span style="color:#ff0000">*</span> </td>
                            <td class="td"><label class="control-label" for="Child" style="float:left;">Paid</label>
                            </td>
                        </tr>
                        <tr class="tr" id="memberindividual">
                            <td colspan="2" class="td">General Member-Individual(Due jan1/Apr 1 every year) </td>
                            <td class="td" id="newprice" >
                                <input  required="" type="radio" name="rate"
                                    value="gmi_1">$<?php echo $tpl['option_arr_values']['gmi_1'] ?? ''; ?>
                                </td>
								<td class="td" id="renprice" style="display: none;">
								<input required="" type="radio" name="rate"
                                    value="gmi_4">$<?php echo $tpl['option_arr_values']['gmi_4'] ?? ''; ?>
                            </td>
                            <td class="td">
                                <input id="gmi_amount" class="form-control input-sm" type="text" name="amount[]"
                                    size="25" value="" title="Paid" placeholder="$" readonly>
                            </td>
                        </tr> 
	                     <tr class="tr" id="pricemembership" style="display:none; width:100%">
                            <td colspan="2" class="td">General Member-Family(Due jan1/Apr 1 every year)</td>
                            <td class="td" id="newprice" >
                                <input required="" type="radio" name="rate"
                                    value="gmf_1">$<?php echo $tpl['option_arr_values']['gmf_1'] ?? ''; ?>
							    </td>
                               
								<td class="td" id="renprice" style="display:none;">
									<input   type="radio" name="rate" value="gmf_4">$<?php echo $tpl['option_arr_values']['gmf_4'] ?? ''; ?>
                            </td>
                            <td class="td" >
                                <input id="gmf_amount" class="form-control input-sm" type="text" name="amount[]"
                                    size="25" value="" title="Paid" placeholder="$" readonly>
                            </td>
                        </tr>
                        <tr class="tr">
                            <td colspan="2" class="td">Life Member(LM) </td>
                            <td class="td">
                                <input required="" type="radio" name="rate"
                                    value="lm">$<?php echo $tpl['option_arr_values']['lm'] ?? ''; ?>
                            </td>
                            <td class="td">
                                <input id="lm_amount" class="form-control input-sm" type="text" name="amount[]"
                                    size="25" value="" title="Paid" placeholder="$" readonly>
                            </td>
                        </tr>
                        <!-- <tr class="tr">
                                <td colspan="2" class="td">Benefactor(BF)</td>  
                                <td class="td">
                                    <input required="" type="radio" name="rate" value="bf">$<?php echo $tpl['option_arr_values']['bf'] ?? ''; ?>
                                </td>
                                <td class="td">
                                    <input id="bf_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="" title="Paid" placeholder="$">
                                </td>                        
                            </tr>
                            <tr class="tr">
                                <td colspan="2" class="td">Patron Member(pm) </td>
                                <td class="td">
                                    <input required="" type="radio" name="rate" value="pm">$<?php echo $tpl['option_arr_values']['pm'] ?? ''; ?>
                                </td>
                                <td class="td">
                                    <input id="pm_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="" title="Paid" placeholder="$">
                                </td>                        
                            </tr>
                            <tr class="tr">
                                <td colspan="2" class="td">Maintenance (LM and higher)-per calendar Year </td> 
                                <td class="td">
                                    <input required="" type="radio" name="rate" value="lm_h">$<?php echo $tpl['option_arr_values']['lm_h'] ?? ''; ?>
                                </td>
                                <td class="td">
                                    <input id="lm_h_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="" title="Paid" placeholder="$">
                                </td>                        
                            </tr> -->
                        <tr class="tr">
                            <td class="td" colspan="2">Extra Donation</td>
                            <td class="td">Any Amount</td>
                            <td class="td">
                                <input id="donation" class="form-control input-sm" type="number" name="donation" size="25"
                                    value="" title="Paid" placeholder="$">
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="3">Total</td>
                            <td class="td">
                                <input id="total" required="true" class="form-control input-sm" type="text" name="total"
                                    size="25" value="" title="Paid" placeholder="$" readonly>
                            </td>
                        </tr>
                    </table>
					
					
                    <table class="table" id="govtid">
                        <tr class="tr">
                        <tr class="tr">
                            <td class="td" colspan="8">Driving Licence/Passport<span style="color:#ff0000">*</span></td>
                            <td class="td">
                                 <!-- <input class="form-control" type="file" name="img[]" id="filename" required="true" multiple  onchange="getNewName_one(this.value)"> -->
                                 <!-- <input type="file" onchange="getNewName_one(this.value)" multiple name="file" data-maxfilesize="5000000"> -->
                                 <input type="file" id="select_file" multiple name="img[]" required="true"/>
                                <p>Note:Your documents will be kept confidential or will be deleted on verification. Upload JPG format only. <span style="color:red;">Use Ctrl to upload more than one file.</span></p>
                            </td>
                        </tr>
                        </tr>
                    </table>
                    <table class="table">
                        <?php if ($this->controller->isLoged() && $this->controller->isAdmin()) { ?>
                        <tr class="tr">
                            <td class="td">
                                <label class="control-label" for="type"><?php echo __('type'); ?>:</label>
                            </td>
                            <td class="td">
                                <input type="hidden" name="type" value="2" />
                                <?php echo __('member'); ?>
                            </td>
                            <td class="td">
                                <label class="control-label" for="type"><?php echo __('user_status'); ?>:</label>
                            </td>
                            <td class="td">
                                <select required="true" name="status" id="status" class="form-control input-sm medium">
                                    <option value="">---</option>
                                    <?php
                                            $user_status_arr = __('member_status_arr');
                                            foreach ($user_status_arr as $k => $v) {
                                                ?>
                                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                    <?php
                                            }
                                            ?>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr class="tr">
                            <td class="td">Add References</td>
                            <td class="td">
                                <input id="references" class="form-control input-sm" type="text" name="remarks" size="25"
                                    value="" title="References" placeholder="References">
                            </td>
                            <td class="td">Phone No</td>
                                <td class="td">
                                <input maxlength="10" id="Ref_Phone" class="form-control input-sm" type="text" placeholder="###) ###-####"  name="Ref_Phone"  onchange="numberrefcheck(this.id)" >
                               </td>
                                <td  class="td">Date of Application<span style="color:#ff0000">*</span></td>
                                <td class="td">
                              <input required="true" min="<?php echo date('Y-m-d'); ?>"  id="year_birth3" class="form-control input-sm" type="date" name="CreatedOn" size="25" value="<?php echo date('Y-m-d'); ?>" title="Date" placeholder=""></td> 
                        </tr>
                    </table>
                    <table class="table">
                    <tr class="tr">
                        <td class="td" colspan="2">
                            <h3>Payment Method</h3>
                        </td>
                        <td class="td" colspan="2">
                            <select required="" name="Payment_method" id="Payment_method"
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
                    <?php if ($this->controller->isAdmin()) { ?>
                    <tr class="tr">
                        <td class="td">
                            <label class="control-label" for="type"><?php echo __('type'); ?>:</label>
                        </td>
                        <td class="td">
                            <?php echo __('member'); ?>
                        </td>
                        <td class="td">
                            <label class="control-label" for="type"><?php echo __('user_status'); ?>:</label>
                        </td>
                        <td class="td">
                            <select required="" name="status" id="status" class="form-control input-sm medium">
                                <option value="">---</option>
                                <?php
                                    $user_status_arr = __('member_status_arr');
                                    foreach ($user_status_arr as $k => $v) {
                                        ?>
                                <option <?php echo (($tpl['arr']['status'] ?? '') == $k) ? "selected='selected'" : ""; ?>
                                    value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                                    }
                                    ?>
                            </select>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr id="stripe_details" class="tr" style="display: none;">
                        <td class="td" colspan="4">
                            <div class="form-row row col-sm-6">
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
                    <tr id="MemberID1" style="display:none;">
                        <td class="td" colspan="4">
                            <div style="margin:6px 0;">
                                <label class="control-label"><strong>Zelle Payment Details:</strong></label>
                                <div id="error_code1" style="margin-bottom:8px;font-size:13px;color:#555;"></div>
                                <select id="MemberID" name="oid" class="form-control input-sm" style="display:none;font-weight:bold;">
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
                                <b>Step 2</b> - Send your membership amount to <b>treasurer@durgabari.org</b>.<br>
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
                    <table class="table">
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <h3>Declaration Required</h3>
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <input required="true" type="checkbox"  checked  id="terms" name="terms" value="terms">I pledge
                                that I will cause no harm to HDBS, to its reputation or the reputation of its employees,
                                members and volunteers. I will abide by the rules and regulations of HDBS as set out in
                                its
                                Constitution and Bylaws and policy documents. If I am found to be in any violation, my
                                membership
                                can be denied, suspended or revoked. I understand that if I am a General Member (GM) and
                                I default
                                to pay my dues on time, I will become a donor (GD) and lose all privileges including but
                                not
                                limited to voting rights normally enjoyed by a GM.
                            </td>
                        </tr>
                        <!-- <tr class="tr">
                            <td  class="td" colspan="4">• I wish to become HDBS member for the following interest(s):<input type="checkbox" id="terms" name="terms" value="terms"> Hindu Religion/Spiritual Need 
                                   <input type="checkbox" id="terms" name="terms" value="terms">Bengali Culture <input type="checkbox" id="terms" name="terms" value="terms">Volunteering <input type="checkbox" id="terms" name="terms" value="terms">Other (please note down):
                            </td>                    
                            </tr> -->
                        <!-- <tr class="tr">
                            <td  class="td" colspan="4">How often do you plan to visit Durga Bari* <input type="checkbox" id="terms" name="terms" value="terms"> Regularly (every week) <input type="checkbox" id="terms" name="terms" value="terms"> Once a month <input type="checkbox" id="terms" name="terms" value="terms"> Only during 
                              major pujas <input type="checkbox" id="terms" name="terms" value="terms"> Never</td>                    
                            </tr> -->
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <input required="true" type="checkbox" checked  id="terms" name="terms" value="terms">
                                I hereby declare that the above information is correct to the best of my knowledge. I
                                shall
                                notify HDBS in writing, if there is any change to the above information within one month
                                of the change.
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <input required="true" type="checkbox" checked  id="terms" name="terms" value="terms">
                                I authorize HDBS to communicate with me by e-mail, sms or social media and share my contact information in
                                HDBS
                                magazine(s) or on the HDBS website.
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <input required="true" type="checkbox" checked id="terms" name="terms" value="terms">
                                I understand that my visit to Durga Bari will be at my own
                                risk and I will hold HDBS or its volunteers harmless from any liability and loss.
                            </td>
                        </tr>
                        <tr class="tr">
                            <td class="td" colspan="4">
                                <input required="true" type="checkbox" id="terms" name="terms" value="terms">
                                By clicking the submit button below, I hereby agree to and accept the above following terms and conditions.
                            </td>
                        </tr>
                            </table>
                </fieldset>
                <fieldset>
                    <input type="hidden" name="create_member" value="1" />
                    <input type="hidden" name="pay_user" value="1" />
                        <input id="Country" type="hidden" name="Country" value="USA">
                    <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                <button id="member_btn_id" class="btn btn-primary" autocomplete="off" value="<?php echo __('pay'); ?>"
                    name="pay" tabindex="9" type="submit">
                    <i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('Make Payment') ?>
                </button>
                </fieldset>
            </form>
        </main>
    </div>
</div>
<div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key'] ?? ''; ?>
</div>
<?php } ?>
<script>
    const phoneInputField = document.querySelector("#phone_mobile");
      const phoneInput = window.intlTelInput(phoneInputField, {
        // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
        preferredCountries: ["us", "co", "in", "de"],
        utilsScript:
          "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      });

      const InputphoneField = document.querySelector("#phone_No");
      const Inputphone = window.intlTelInput(InputphoneField, {
        // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
        preferredCountries: ["us", "co", "in", "de"],
        utilsScript:
          "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      });
      const InputreferenceField = document.querySelector("#Ref_Phone");
      const Inputrefrencephone = window.intlTelInput(InputreferenceField, {
        // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
        preferredCountries: ["us", "co", "in", "de"],
        utilsScript:
          "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      });
      
      
    $(function(){
    $('input[type="text"]').change(function(){
        this.value = $.trim(this.value);
    });
});

function sponsoramount(elem){
        debugger;
        const phonenumber =  $("#phone_mobile").val();
        if(!!phonenumber){
         if(isNaN(phonenumber)){  
            alert("Please Enter mobile Number");
            $("#member_btn_id").addClass('disabled');
            //document.getElementById("totalamount").value = price; 
         }
         else if(phonenumber.length > 10 ){
              alert("Number should be 10 digits");
              $("#member_btn_id").addClass('disabled');  
         }
         else if(phonenumber.length < 10){
            alert("Number should be 10 digits");
            $("#member_btn_id").addClass('disabled');  
         }
         else if(phonenumber.length == 10){  
            $("#member_btn_id").removeClass('disabled');
         }
         else{
            $("#member_btn_id").removeClass('disabled');
         }
        }
        else{
            $("#phone_mobile").prop('required',true);
            $("#member_btn_id").removeClass('disabled');
        }
     }
    

     function numbercheck(elem){
        debugger;
        const contact =  $("#phone_work").val();
        if(!!contact){
         if(isNaN(contact)){  
            alert("Please Enter mobile Number");
            $("#member_btn_id").addClass('disabled');
            //document.getElementById("totalamount").value = price; 
         }
         else if(contact.length > 10 ){
              alert("Number should be 10 digits");
              $("#member_btn_id").addClass('disabled');  
         }
         else if(contact.length < 10){
            alert("Number should be 10 digits");
            $("#member_btn_id").addClass('disabled');  
         }
         else if(contact.length == 10){  
            $("#member_btn_id").removeClass('disabled');
         }
         else{
            $("#member_btn_id").removeClass('disabled');
         }
        }
        else{
            $("#member_btn_id").removeClass('disabled');
        }
     }
     function numberduplicatecheck(elem){
        debugger;
        const workphone =  $("#phone_No").val();
        if(!!workphone){
         if(isNaN(workphone)){  
            alert("Please Enter mobile Number");
            $("#member_btn_id").addClass('disabled');
            //document.getElementById("totalamount").value = price; 
         }
         else if(workphone.length > 10 ){
              alert("Number should be 10 digits");
              $("#member_btn_id").addClass('disabled');  
         }
         else if(workphone.length < 10){
            alert("Number should be 10 digits");
            $("#member_btn_id").addClass('disabled');  
         }
         else if(workphone.length == 10){  
            $("#member_btn_id").removeClass('disabled');
         }
         else{
            $("#member_btn_id").removeClass('disabled');
         }
        }
        else{
            $("#member_btn_id").removeClass('disabled');
        }
     }
     function numberrefcheck(elem){
        debugger;
        const refrence =  $("#Ref_Phone").val();
        if(!!refrence){
         if(isNaN(refrence)){  
            alert("Please Enter mobile Number");
            $("#member_btn_id").addClass('disabled');
            //document.getElementById("totalamount").value = price; 
         }
         else if(refrence.length > 10 ){
              alert("Number should be 10 digits");
              $("#member_btn_id").addClass('disabled');  
         }
         else if(refrence.length < 10){
            alert("Number should be 10 digits");
            $("#member_btn_id").addClass('disabled');  
         }
         else if(refrence.length == 10){  
            $("#member_btn_id").removeClass('disabled');
         }
         else{
            $("#member_btn_id").removeClass('disabled');
         }
        }
        else{
            $("#member_btn_id").removeClass('disabled');
        }
     }

     function _(element)
{
    return document.getElementById(element);
}

_('select_file').onchange = function(event){
//debugger;
    var form_data = new FormData();

    var image_number = 1;

    var img = [];

    for(var count = 0; count < _('select_file').files.length; count++)  
    {
        if(!['image/jpeg', 'image/png', 'video/mp4'].includes(_('select_file').files[count].type))
        {
            // error += '<div class="alert alert-danger"><b>'+image_number+'</b> Selected File must be .jpg or .png Only.</div>';
            alert("Upload image only jpg,png,jpeg format");
             $("#select_file").val(null);
            //$("#member_btn_id").addClass('disabled'); 
        }
        else
        {
            img.push("images[]", _('select_file').files[count]);
            //$("#member_btn_id").removeClass('disabled');
        }

        image_number++;
    }

    return img;
   
};

let startYear = 1800;
    let endYear = new Date().getFullYear();
    for (i = endYear; i > startYear; i--)
    {
      $('#yearpicker').append($('<option />').val(i).html(i));

      $('#year_birth2').append($('<option />').val(i).html(i));
      $('#year_birth3').append($('<option />').val(i).html(i));
      $('#year_birth4').append($('<option />').val(i).html(i));
    }





</script>
