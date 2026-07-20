<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
</head>
<style>
 @media only screen and (max-width: 499px){
		 .right-side {
              margin-left:0px!important;
             }
	}
		@media (min-width: 500px) and (max-width: 767px) {
			.right-side {
              margin-left:0px!important;
             }
		}

		@media (min-width: 768px) and (max-width: 830px) {
            .right-side {
              margin-left:0px!important;
             }
		}

		@media(min-width: 831px) and (max-width: 990px) {
			.right-side {
              margin-left:0px!important;
             }
		}	
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
.ui-icon-circle-triangle-w{
width:35px!important;
}
.ui-icon.ui-icon-circle-triangle-e{
width:35px!important;
margin-left: -29px!important;
font: bold;
}
.icheckbox_minimal{
    display:none;
}
#payment-form > div > fieldset > table:nth-child(7) > tbody > tr:nth-child(6) > td > div
{display:block;}
</style>
<section class="content-header">
    <h1>
        <?php echo __('edit_member'); ?>
    </h1>
    <?php if (!$this->controller->isMember()) { ?>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Member/index"><?php echo __('title_members'); ?></a></li>
        <li class="active"><?php echo __('edit_member'); ?></li>
    </ol>
    <?php } ?>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$memberDefaults = [
    'Renew_date' => '',
    'CreatedOn' => '',
    'Category' => '',
    'State' => '',
    'Age1' => '',
    'Age2' => '',
    'Age3' => '',
    'Age4' => '',
    'avatar' => '',
    'membership_type' => '',
    'information' => '',
    'GovtissueID' => '',
    'Country' => '',
    'rate' => '',
    'Payment_method' => '',
    'status' => '',
    'Senior' => '',
];
$optionDefaults = [
    'currency' => '',
    'gmi_1' => '',
    'gmi_4' => '',
    'gmf_1' => '',
    'gmf_4' => '',
    'lm' => '',
    'bf' => '',
    'pm' => '',
    'lm_h' => '',
    'stripe_allow' => '',
    'others_allow' => '',
    'paypal_allow' => '',
    'authorize_allow' => '',
    '2checkout_allow' => '',
    'pay_arrival_allow' => '',
    'credit_card_allow' => '',
    'bank_acount_allow' => '',
];
$tpl['arr'] = array_merge($memberDefaults, is_array($tpl['arr'] ?? null) ? $tpl['arr'] : []);
$tpl['option_arr_values'] = array_merge($optionDefaults, is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []);
 $renew =strtotime($tpl['arr']['Renew_date'] ?? '');
$date = date("m/d/Y", $renew );
$categ = $tpl['arr']['Category'] ?? '';
  $Application_date =strtotime($tpl['arr']['CreatedOn'] ?? '');
  $App_date = date("m/d/Y", $Application_date );
  $state = $tpl['arr']['State'] ?? ''; 
  $Dateage = $tpl['arr']['Age1'] ?? '';
  $birthDate = $tpl['arr']['Age2'] ?? '';
  $dobage3 = $tpl['arr']['Age3'] ?? '';
  $childage = $tpl['arr']['Age4'] ?? '';
   $avatarimag = $tpl['arr']['avatar'] ?? '';
   $name=explode("/",$avatarimag);
   $memtype = $tpl['arr']['membership_type'] ?? '';
   $psword = $tpl['arr']['password'] ?? '';
    $reg =  $this->controller->isRegistration();
    $adminreg =  $this->controller->isAdmin();
  
?>
<!-- <section class="content left width_100"> -->
   <form id="payment-form" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Member/adminedit"
        method="post" name="adminedit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>"> 
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <section>
                <table class="table">
                    <tr class="tr">
                        <td class="td">Applicant Information</td>
                        <td class="td">
                            <input <?php echo ($tpl['arr']['information'] == 'new') ? "checked='checked'" : ""; ?>
                                type="radio" id="new" name="information" value="new">
                              <label for="new">New</label>
                              <?php if ($this->controller->isMember()) { ?>
                              <input <?php echo ($tpl['arr']['information'] == 'renewal') ? "checked='checked'" : ""; ?>
                                type="radio" id="renewal" name="information" value="renewal">
                            <label for="renewal">Renewal</label>
                               <?php } ?>
                        </td>
                        <td class="td"> Membership No</td>
                        <td class="td">
                            <input disabled="" id="Member_id" class="form-control input-sm" type="text" name="Member_id"
                                size="12" value="<?php echo $tpl['arr']['Member_id'] ?? ''; ?>" title="Member ID"
                                placeholder="Member ID">
                        </td>
                        <!-- <td class="td">Date of Renewal</td>
                        <td class="td">
                        <?php if (($tpl['arr']['Renew_date'] !="0000-00-00") && ($categ == 'GD' || $categ == 'GM'))  { ?>
                             <input disabled="" id="Renew_date" class="form-control input-sm" type="text"
                                name="Renew_date" size="12" value="<?php echo $date; ?>"
                                title="Renew Date" placeholder="Renew Date">
                                <?php
                } else {
                    ?>
                     <input disabled="" id="Renew_date" class="form-control input-sm" type="text"
                                name="Renew_date" size="12" value=""
                                title="Renew Date" placeholder="Renew Date">
                    <?php
                }
                ?>
                            </td> -->

                            <?php if ($categ == "GD" ||$categ == "GM")  { ?>
                          <td class="td" id="renewdatetext">Date of Renewal</td>
                        <td class="td" id="renewdatefield">
                        <?php if (($tpl['arr']['Renew_date'] !="0000-00-00" ) && ($categ == 'GD' || $categ == 'GM'))  { ?>
                            <input disabled="" id="Renew_date" class="form-control input-sm" type="text"
                                name="Renew_date" size="12" value="<?php echo $date; ?>"
                                title="Renew Date" placeholder="Renew Date">
                                <?php
                } else {
                    ?>
                    <input disabled="" id="Renew_date" class="form-control input-sm" type="text"
                                name="Renew_date" size="12" value=""
                                title="Renew Date" placeholder="Renew Date">
                    <?php
                }
                ?>
                            </td>
				 <?php
                            } ?> 				
							
					<?php if ($categ == "LM" ||$categ == "PM" || $categ == "BF" || $categ == "FM" || $categ == "FP")  { ?>		
							<td class="td" id="maintdate" style="display:none;">Date of Maintenance</td>
                        <td class="td" id="maintdatefield" style="display:none;">
                        <?php if (($tpl['arr']['Renew_date'] !="0000-00-00" ) && ($categ == 'LM' || $categ == 'PM' || $categ == 'BF' || $categ == 'FM' || $categ == 'FP'))  { ?>
                             <input disabled="" id="maintenance_date" class="form-control input-sm" type="text"
                                name="Renew_date" size="12" value="<?php echo $date; ?>"
                                title="Maintenance Date" placeholder="Maintenance Date">
                                <?php
                } else {
                    ?>
                     <input disabled="" id="Renew_date" class="form-control input-sm" type="text"
                                name="Renew_date" size="12" value=""
                                title="Maintenance Date" placeholder="Maintenance Date">
                    <?php
                }
                ?>
                            </td>
	 <?php
                            } ?>  
                    </tr>
                </table>
            </section>
            <!-- section for new member -->
            <section id="membernew">
            <form id="payment-form" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Member/edit"
                method="post" name="edit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <table class="table">
                    <tr class="tr">
                        <td class="td">
                            Member's First Name<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input id="Your_Name" class="form-control input-sm" type="text" name="F_Name" size="25"
                                value="<?php echo $tpl['arr']['F_Name'] ?? ''; ?>" title="First Name"
                                placeholder="First Name">
                        </td>
                        <td class="td">Middle Name<span style="color:#ff0000">*</span></td>
                        <td class="td">
                            <input id="middle name" class="form-control input-sm" type="text" name="M_Name" size="25"
                                value="<?php echo $tpl['arr']['M_Name'] ?? ''; ?>" title="Middle Name"
                                placeholder="Middle Name">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">Last Name <span style="color:#ff0000">*</span></td>
                        <td class="td">
                            <input required="true" id="last name" class="form-control input-sm" type="text"
                                name="L_Name" size="25" value="<?php echo $tpl['arr']['L_Name'] ?? ''; ?>" title="Last Name"
                                placeholder="Last Name">

                        </td>
                        <td class="td">
                            Membership Type<span style="color:#ff0000">*</span>
                        </td>
                        <td colspan="2" class="td">
                            <input
                                <?php echo ($tpl['arr']['membership_type'] == 'IND') ? "checked='checked'" : ""; ?>
                                type="radio" id="individual_membership" name="membership_type"
                                value="IND">
                            Individual Membership
                            <input
                                <?php echo ($tpl['arr']['membership_type'] == 'FAM') ? "checked='checked'" : ""; ?>
                                type="radio" id="family_membership" name="membership_type" value="FAM">
                            Family Membership
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">Senior 70+</td>
                        <td class="td">
                            <?php $isSenior = (($tpl['arr']['Senior'] ?? '') == 'YES'); ?>
                            <select id="Senior" name="Senior" class="form-control input-sm" style="width: 140px;">
                                <option value="" <?php echo !$isSenior ? "selected='selected'" : ""; ?>>No</option>
                                <option value="YES" <?php echo $isSenior ? "selected='selected'" : ""; ?>>Yes</option>
                            </select>
                        </td>
                        <td class="td">Gotra</td>
                        <td class="td">
                            <input id="Gotra" class="form-control input-sm" type="text" name="Gotra" size="25"
                                value="<?php echo $tpl['arr']['Gotra'] ?? ''; ?>" title="Gotra" placeholder="Gotra">
                        </td>
                    </tr>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            Spouse Name
                        </td>
                        <td class="td">
                            <input id="Spousefirst" class="form-control input-sm" type="text" name="Sp_FName" size="25"
                                value="<?php echo $tpl['arr']['Sp_FName'] ?? ''; ?>" title="Spouse Name"
                                placeholder="Spouse Name" readonly>
                        </td>
                        <td class="td">
                            Last Name </td>
                        <td class="td">
                            <input  id="Spouselast" class="form-control input-sm" type="text"
                                name="Sp_LName" size="25" value="<?php echo $tpl['arr']['Sp_LName'] ?? ''; ?>"
                                title="Spouse Last Name" placeholder="Spouse Last Name" readonly>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            Street No<span style="color:#ff0000">*</span>
                        </td>
                        <td  class="td">
                            <input id="Address" class="form-control input-sm" type="text" name="Address1" size="25"
                                value="<?php echo $tpl['arr']['Address1'] ?? ''; ?>" title="Address" placeholder="Street No">
                        </td>
                        <td class="td">Address<span style="color:#ff0000">*</span></td>
                        <td class="td">
                            <input id="Address" class="form-control input-sm" type="text" name="Address2" size="25"
                                value="<?php echo $tpl['arr']['Address2'] ?? ''; ?>" title="Address"
                                placeholder="Address" required="true">
                        </td>
                        <!-- <td  class="td">Govt Issued Photo ID/No:<span style="color:#ff0000">*</span> </td>
                        <td  class="td">
                            <input <?php echo ($tpl['arr']['GovtissueID'] == 'checked') ? "checked='checked'" : ""; ?> type="radio" id="checked" name="GovtissueID" value="checked">
                            Available
                            <input <?php echo ($tpl['arr']['GovtissueID'] == 'not_available') ? "checked='checked'" : ""; ?> type="radio" id="not_available" name="GovtissueID" value="not_available">
                            Not Available
                        </td> -->

                    </tr>
                    <tr class="tr">
                    <td class="td">Country</td>
                    <td class="td">

                     <input id="Country" class="form-control input-sm" type="text" name="Country" 
                                value="<?php echo $tpl['arr']['Country'] ?? ''; ?>" title="Country" placeholder="Country" readonly> 
                                <!-- <select name="Country" id="Country" class="form-control input-sm" >
                                <option value="">---</option>	
                                    <?php
                                    foreach (($tpl['Country'] ?? []) as $key => $value) {
                                    ?>
                                     <option <?php echo ($tpl['arr']['Country'] == $value['CountryCode']) ? "selected='selected'" : ""; ?> value="<?php echo $value['CountryCode']; ?>"><?php echo $value['Country']; ?></option> 
		
                                <?php
                                }
                                 ?>	
                                </select>  -->

                    </td>
                        <td class="td"> City<span style="color:#ff0000">*</span></td>
                        <td class="td">
                            <input id="city" class="form-control input-sm" type="text" name="City" size="25"
                                value="<?php echo $tpl['arr']['City'] ?? ''; ?>" title="City" placeholder="City">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            State <span style="color:#ff0000">*</span> </td>
                        <td class="td">
                            <select required id="states" style="width: 100%!important;height: 36px!important;" 
                                        name="State" value="<?php echo $tpl['arr']['State'] ?? ''; ?>" class="form-control input-sm medium valid">
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
                        <td class="td">
                            Zip Code<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input id="zip_code" class="form-control input-sm" type="text" name="Zip" size="25"
                                value="<?php echo $tpl['arr']['Zip'] ?? ''; ?>" title="Zip Code" placeholder="Zip Code">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            Mobile<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                             <input id="phone_mobile" class="form-control input-sm" type="text"  value="<?php echo $tpl['arr']['Tele1'] ?? ''; ?>" required="" placeholder="###) ###-####" value="" name="Tele1"  onchange="sponsoramount(this.id)" maxlength="12">
                        </td>
                       <td class="td">
                        Home
                        </td>
                        <td class="td">
                             <input id="phone_No" class="form-control input-sm" type="text" placeholder="###) ###-####" value="<?php echo $tpl['arr']['Tele2'] ?? ''; ?>" name="Tele2"  onchange="numberduplicatecheck(this.id)" maxlength="12"> 

                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            Email<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input id="email" class="form-control input-sm" type="text" name="email" size="25"
                                value="<?php echo $tpl['arr']['email'] ?? ''; ?>" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Email" placeholder="name@company.com">
                        </td>
                        <td class="td">
                            Email 2
                        </td>
                        <td class="td">
                            <input id="email" class="form-control input-sm" type="text" name="Email2" size="25"
                                value="<?php echo $tpl['arr']['Email2'] ?? ''; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Email 2" placeholder="name@company.com">
                        </td>
                    </tr>
                </table>
                <table id="children" style="display: none;" class="table">
                    <tr class="tr">
                        <td class="td" colspan="8">
                            <h3>Children's Information</h3>
                        </td>
                    </tr>
                    <tr class="tr">
                    <tr class="tr">
                        <td colspan="4" class="td">Child 1<input id="Child" class="form-control input-sm" type="text"
                                name="Child1" size="25" value="<?php echo $tpl['arr']['Child1'] ?? ''; ?>" title="Child"
                                placeholder="Full Name"></td>
                        <td class="td">Year of Birth
                        
                         <!--<input max="<?php echo date('Y-m-d'); ?>" id="year_birth"
                                class="form-control input-sm date-picker" name="Age1" size="25"
                                value="<?php echo $tpl['arr']['Age1'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                                
                               <select name="Age1" class="form-control input-sm selectpicker " data-live-search="true" id="yearpicker">
                               <option>Select year of birth</option>
                               </select>  
                                </td>
                        <td class="td">Child 2<input id="Child2" class="form-control input-sm" type="text" name="Child2"
                                size="25" value="<?php echo $tpl['arr']['Child2'] ?? ''; ?>" title="Child"
                                placeholder="Full Name"></td>
                        <td class="td">Year of Birth
                        
                        <!-- <input max="<?php echo date('Y-m-d'); ?>" id="year_birth"
                                class="form-control input-sm date-picker" name="Age2" size="25"
                                value="<?php echo $tpl['arr']['Age2'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                                 <select name="Age2" class="form-control input-sm selectpicker" data-live-search="true"   id="year_birth2">
                                 <option>Select year of birth</option>
                                 </select>
                                
                                </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="4" class="td">Child 3<input id="Child3" class="form-control input-sm" type="text"
                                name="Child3" size="25" value="<?php echo $tpl['arr']['Child3'] ?? ''; ?>" title="Child"
                                placeholder="Full Name"></td>
                        <td class="td">Year of Birth
                        
                         <!--<input max="<?php echo date('Y-m-d'); ?>" id="year_birth"
                                class="form-control input-sm date-picker" name="Child" size="25"
                                value="<?php echo $tpl['arr']['Age3'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                                  <select name="Age3" class="form-control input-sm selectpicker " data-live-search="true"  id="year_birth3">
                                  <option>Select year of birth</option>
                                  </select>
                                </td>
                        <td class="td">Child 4<input id="Child4" class="form-control input-sm" type="text" name="Child4"
                                size="25" value="<?php echo $tpl['arr']['Child4'] ?? ''; ?>" title="Child"
                                placeholder="Full Name"></td>
                        <td class="td">Year of Birth
                        
                        <!-- <input max="<?php echo date('Y-m-d'); ?>" id="year_birth"
                                class="form-control input-sm date-picker" name="Age4" size="25"
                                value="<?php echo $tpl['arr']['Age4'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                                 <select name="Age4" class="form-control input-sm selectpicker " data-live-search="true"  id="year_birth4">
                                 <option>Select year of birth</option>
                                 </select>
                                </td>
                    </tr>
                    </tr>
                </table>
                <?php if ($categ == "GD" || $categ == "GM" || $categ == "LM")  { ?>
                <table class="table">
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <h3>Membership Categories & Payment Details</h3>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="2"><label class="control-label" for="Child"
                                style="float:left;">Category<span style="color:#ff0000">*</span></label></td>

                        <td class="td"> <label class="control-label" for="Child" style="float:left;">Rate<span
                                    style="color:#ff0000">*</span> </label></td>
                        <td class="td"><label class="control-label" for="Child" style="float:left;"> Paid<span
                                    style="color:#ff0000">*</span></label> </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">General Member-Individual(Due jan1/Apr 1 every year) </td>
                        <td class="td">
                            <input <?php echo ($tpl['arr']['rate'] == 'gmi_1') ? "checked='checked'" : ""; ?>
                                required="" type="radio" name="rate"
                                value="gmi_1">$<?php echo $tpl['option_arr_values']['gmi_1'] ?? ''; ?> 
                            <input <?php echo ($tpl['arr']['rate'] == 'gmi_4') ? "checked='checked'" : ""; ?>
                                required="" type="radio" name="rate"
                                value="gmi_4">$<?php echo $tpl['option_arr_values']['gmi_4'] ?? ''; ?>
                        </td>
                        <td class="td">
                            <?php
                            $amount = 0;
                            if ($tpl['arr']['rate'] == 'gmi_1') {
                                $amount = $tpl['option_arr_values']['gmi_1'] ?? '';
                            } elseif ($tpl['arr']['rate'] == 'gmi_4') {
                                $amount = $tpl['option_arr_values']['gmi_4'] ?? '';
                            }
                            ?>
                            <input id="gmi_amount" class="form-control input-sm" type="text" name="amount[]" size="25"
                                value="<?php echo ($amount > 0) ? $amount : ''; ?>" title="Paid" placeholder="$" readonly>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">General Member-Family(Due jan1/Apr 1 every year)</td>
                        <td class="td">
                            <input <?php echo ($tpl['arr']['rate'] == 'gmf_1') ? "checked='checked'" : ""; ?>
                                required="" type="radio" name="rate"
                                value="gmf_1">$<?php echo $tpl['option_arr_values']['gmf_1'] ?? ''; ?>
                             <input <?php echo ($tpl['arr']['rate'] == 'gmf_4') ? "checked='checked'" : ""; ?> 
					  type="radio" name="rate" value="gmf_4">$<?php echo $tpl['option_arr_values']['gmf_4'] ?? ''; ?>
                        </td>
                        <td class="td">
                            <?php
                            $amount = 0;
                            if ($tpl['arr']['rate'] == 'gmf_1') {
                                $amount = $tpl['option_arr_values']['gmf_1'] ?? '';
                            } elseif ($tpl['arr']['rate'] == 'gmf_4') {
                                $amount = $tpl['option_arr_values']['gmf_4'] ?? '';
                            }
                            ?>
                            <input id="gmf_amount" class="form-control input-sm" type="text" name="amount[]" size="25"
                                value="<?php echo ($amount > 0) ? $amount : ''; ?>" title="Paid" placeholder="$" readonly>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">Life Member(LM) </td>
                        <td class="td">
                            <input <?php echo ($tpl['arr']['rate'] == 'lm') ? "checked='checked'" : ""; ?> required=""
                                type="radio" name="rate" value="lm">$<?php echo $tpl['option_arr_values']['lm'] ?? ''; ?>
                        </td>
                        <td class="td">
                            <input id="lm_amount" class="form-control input-sm" type="text" name="amount[]" size="25"
                                value="<?php echo ($tpl['arr']['rate'] == 'lm') ? $tpl['option_arr_values']['lm'] : ""; ?>"
                                title="Paid" placeholder="$" readonly>
                        </td>
                    </tr>
                    <!-- <tr class="tr">
                        <td colspan="2" class="td">Benefactor(BF)</td>
                        <td class="td">
                            <input <?php echo ($tpl['arr']['rate'] == 'bf') ? "checked='checked'" : ""; ?> required="" type="radio" name="rate" value="bf">$<?php echo $tpl['option_arr_values']['bf'] ?? ''; ?>
                        </td>

                        <td class="td">
                            <input id="bf_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="<?php echo ($tpl['arr']['rate'] == 'bf') ? $tpl['option_arr_values']['bf'] : ""; ?>" title="Paid" placeholder="$">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">Patron Member(pm) </td>
                        <td class="td">
                            <input <?php echo ($tpl['arr']['rate'] == 'pm') ? "checked='checked'" : ""; ?> required="" type="radio" name="rate" value="pm">$<?php echo $tpl['option_arr_values']['pm'] ?? ''; ?>
                        </td>
                        <td class="td">
                            <input id="pm_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="<?php echo ($tpl['arr']['rate'] == 'pm') ? $tpl['option_arr_values']['pm'] : ""; ?>" title="Paid" placeholder="$">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">Maintenance (LM and higher)-per calendar Year </td>
                        <td class="td">
                            <input <?php echo ($tpl['arr']['rate'] == 'lm_h') ? "checked='checked'" : ""; ?> required="" type="radio" name="rate" value="lm_h">$<?php echo $tpl['option_arr_values']['lm_h'] ?? ''; ?>
                        </td>
                        <td class="td">
                            <input id="lm_h_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="<?php echo ($tpl['arr']['rate'] == 'lm_h') ? $tpl['option_arr_values']['lm_h'] : ""; ?>" title="Paid" placeholder="$">
                        </td>
                    </tr> -->
                    <tr class="tr">
                        <td class="td" colspan="2">Extra Donation</td>
                        <td class="td">Any Amount</td>
                        <td class="td">
                            <input id="donation" class="form-control input-sm" type="text" name="donation" size="25"
                                value="<?php echo $tpl['arr']['donation'] ?? ''; ?>" title="Paid" placeholder="$" readonly>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="3">Total</td>
                        <td class="td">
                            <input id="total" class="form-control input-sm" type="text" name="total" size="25"
                                value="<?php echo $tpl['arr']['total'] ?? ''; ?>" title="Paid" placeholder="$" readonly>
                        </td>
                    </tr>
                </table>
                 <?php } ?> 
                 <?php if ($categ == "GD" || $categ == "GM" || $categ == "LM")  { ?>
                <table class="table">
                    <tr class="tr">
                        <td class="td" colspan="2">
                            <h3>Payment Method</h3>
                        </td>
                        <td class="td" colspan="2">
                            <select name="Payment_method" id="Payment_method" class="form-control input-sm medium valid"
                                aria-required="true" aria-invalid="false" style="width:100%;  height:50%;">
                                <option value="" class="amd">---</option>
                                <?php
                                $payment_method_arr = __('payment_method_arr');
                                foreach ($payment_method_arr as $k => $v) {
                                    if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                        ?>
                                <option
                                    <?php echo ($tpl['arr']['Payment_method'] == $k) ? "selected='selected'" : ""; ?>
                                    value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php } ?> 
                <table class="table">
                    <tr class="tr">
                        <td class="td" colspan="2">
                            <label> Image<span style="color:#ff0000">*</span> </label>
                        </td>
                        <td class="td"  id="img-file-id"  colspan="2">
                            <?php foreach ($name as $key => $value) { ?>
                                <?php if ($value != " " && $value != "") { ?>
                            <fieldset>
                                <div class="view view-tenth">
								   <img  src="<?php echo INSTALL_URL . UPLOAD_PATH . 'avatar/thumb/' . trim($value); ?>" style="width: 286px;height: 183px;"/>
                                    <div class="mask">
                                        <a rev="<?php echo $tpl['arr']['id'] ?? ''; ?>"
                                            class="info btn btn-app btn-danger gallery-delete"
                                            href="<?php echo INSTALL_URL; ?>User/deleteImage/<?php echo $tpl['arr']['id'] ?? ''; ?>"><i
                                                class="fa fa-times"></i><?php echo __('remove'); ?></a>
                                    </div>
                    
                                </div>
                            </fieldset>
                            <?php } ?>
                            <?php } ?>
                             <?php if ($value == "") { ?>

                                <input id="avatar" class="form-control input-sm" type="file" name="img" size="25" value=""
                                title="avatar" placeholder="avatar">
                                <?php } ?>
                            
                        </td>
                    </tr>
                    <tr class="tr" style="display:none;">
                        <td class="td" colspan="2">
                            <label>Password<span style="color:#ff0000">*</span></label>
                        </td>
                        <td class="td" colspan="2">
                            
                        </td>
                    </tr>
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
                            <select name="status" id="status" class="form-control input-sm medium">
                                <option value="">---</option>
                                <?php
                                    $user_status_arr = __('member_status_arr');
                                    foreach ($user_status_arr as $k => $v) {
                                        ?>
                                <option <?php echo ($tpl['arr']['status'] == $k) ? "selected='selected'" : ""; ?>
                                    value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                                    }
                                    ?>
                            </select>
                            <?php
                                $expiredStatus = '';
                                if (($tpl['arr']['FirstSal'] ?? '') == 'Late' && ($tpl['arr']['SpouseSal'] ?? '') == 'Late') {
                                    $expiredStatus = 'both';
                                } elseif (($tpl['arr']['FirstSal'] ?? '') == 'Late') {
                                    $expiredStatus = 'member';
                                } elseif (($tpl['arr']['SpouseSal'] ?? '') == 'Late') {
                                    $expiredStatus = 'spouse';
                                }
                            ?>
                            <select name="expired_status" id="expired_status" class="form-control input-sm medium" style="margin-top:5px;">
                                <option value="" <?php echo ($expiredStatus == '') ? "selected='selected'" : ""; ?>>No expired status</option>
                                <option value="member" <?php echo ($expiredStatus == 'member') ? "selected='selected'" : ""; ?>>Member expired</option>
                                <option value="spouse" <?php echo ($expiredStatus == 'spouse') ? "selected='selected'" : ""; ?>>Spouse expired</option>
                                <option value="both" <?php echo ($expiredStatus == 'both') ? "selected='selected'" : ""; ?>>Both expired</option>
                            </select>
                             <select name="late" id="late" class="form-control input-sm medium" style="display:none;">
                               
                               
                             </select>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr class="tr">
                        <td class="td">Add References</td>
                        <td class="td">
                            <input id="references" class="form-control input-sm" type="text" name="remarks" size="25"
                                value="<?php echo $tpl['arr']['remarks'] ?? ''; ?>" title="References" placeholder="References">
                        </td>
                        <td class="td">Phone No</td>
                                <td class="td">  <input maxlength="12" id="Ref_Phone" class="form-control input-sm" type="text" placeholder="###) ###-####"  name="Ref_Phone" value="<?php echo $tpl['arr']['Ref_Phone'] ?? ''; ?>" onchange="numberrefcheck(this.id)" >
                                  </td>

                    </tr>
                    <tr class="tr">

                        <td colspan="2" class="td">Date of Application<span style="color:#ff0000">*</span></td>
                        <td>
                        <input disabled="" id="Application_date" class="form-control input-sm" type="text"
                                name="CreatedOn" size="12" value="<?php echo $App_date; ?>"
                                title="Application Date" placeholder="Application Date">
                        </td>

                    </tr>
                </table>
                <table class="table">
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <h3>Declaration Required</h3>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <input checked="" required="" type="checkbox" id="terms" name="terms" value="terms">I pledge
                            that I will cause no harm to HDBS, to its reputation or the reputation of its employees,
                            members and volunteers. I will abide by the rules and regulations of HDBS as set out in its
                            Constitution and Bylaws and policy documents. If I am found to be in any violation, my
                            membership
                            can be denied, suspended or revoked. I understand that if I am a General Member (GM) and I
                            default
                            to pay my dues on time, I will become a donor (GD) and lose all privileges including but not
                            limited to voting rights normally enjoyed by a GM.
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <input checked="" required="" type="checkbox" id="terms" name="terms" value="terms">I hereby
                            declare that the above information is correct to the best of my knowledge. I shall
                            notify HDBS in writing, if there is any change to the above information within one month of
                            the change.
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <input checked="" required="" type="checkbox" id="terms" name="terms" value="terms">I
                            authorize HDBS to communicate with me by e-mail, and share my contact information in HDBS
                            magazine(s) or on the HDBS website.
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <input checked="" required="" type="checkbox" id="terms" name="terms" value="terms">I
                            understand that my visit to Durga Bari will be at my own
                            risk and I will hold HDBS or its volunteers harmless from any liability and loss.
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <input checked="" required="" type="checkbox" id="terms" name="terms" value="terms">BY
                            SIGNING BELOW, I AGREE WITH ALL OF THE ABOVE.
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="editadmin_user" value="1" />
                <input  id="password" type="hidden" name="password"  value="eice@123"  placeholder="password">
                <input type="hidden" name="ID" value="<?php echo $tpl['arr']['ID'] ?? ''; ?>" />
                <input type="hidden" name="dataid" value="<?php echo $tpl['arr']['Member_id'] ?? ''; ?>" />
                <input type="hidden" name="membercategory" value="<?php echo $tpl['arr']['Category'] ?? ''; ?>" />
                <input type="hidden" name="transactionid" value="<?php echo $tpl['arr']['transaction_id'] ?? ''; ?>" />
                <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>"
                    name="submit" tabindex="9" type="submit"><i
                        class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save'); ?></button>
                                </form>
            </section>
        </fieldset>
        </div>
    <!-- </form> -->
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
<script>
var reg = <?php echo(json_encode($reg)); ?>;
var superadminreg = <?php echo(json_encode($adminreg)); ?>;
$( document ).ready(function() {
     //if(reg==true){
      if(reg==false && superadminreg==false){
           
       $("input").attr("disabled", "disabled");
               $("#submit").attr("disabled", "disabled");
               $("#states").attr("disabled", "disabled");
             
      }
    
statedrop();
yearage();
datebirth();
childdate();
yearchild();
membertype();
passwordcheck();
});

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
function sponsoramount(elem){
        //debugger;
        const phonenumber =  $("#phone_mobile").val();
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
            $("#phone_mobile").prop('required',true);
            $("#submit").removeClass('disabled');
        }
     }
    

     function numbercheck(elem){
        //debugger;
        const contact =  $("#phone_work").val();
        if(!!contact){
         if(isNaN(contact)){  
            alert("Please Enter mobile Number");
            $("#submit").addClass('disabled');
            //document.getElementById("totalamount").value = price; 
         }
         else if(contact.length > 10 ){
              alert("Number should be 10 digits");
              $("#submit").addClass('disabled');  
         }
         else if(contact.length < 10){
            alert("Number should be 10 digits");
            $("#submit").addClass('disabled');  
         }
         else if(contact.length == 10){  
            $("#submit").removeClass('disabled');
         }
         else{
            $("#submit").removeClass('disabled');
         }
        }
        else{
            $("#submit").removeClass('disabled');
        }
     }
     function numberduplicatecheck(elem){
        //debugger;
        const workphone =  $("#phone_No").val();
        if(!!workphone){
         if(isNaN(workphone)){  
            alert("Please Enter mobile Number");
            $("#submit").addClass('disabled');
            //document.getElementById("totalamount").value = price; 
         }
         else if(workphone.length > 10 ){
              alert("Number should be 10 digits");
              $("#submit").addClass('disabled');  
         }
         else if(workphone.length < 10){
            alert("Number should be 10 digits");
            $("#submit").addClass('disabled');  
         }
         else if(workphone.length == 10){  
            $("#submit").removeClass('disabled');
         }
         else{
            $("#submit").removeClass('disabled');
         }
        }
        else{
            $("#submit").removeClass('disabled');
        }
     }
     function numberrefcheck(elem){
        //debugger;
        const refrence =  $("#Ref_Phone").val();
        if(!!refrence){
         if(isNaN(refrence)){  
            alert("Please Enter mobile Number");
            $("#submit").addClass('disabled');
            //document.getElementById("totalamount").value = price; 
         }
         else if(refrence.length > 10 ){
              alert("Number should be 10 digits");
              $("#submit").addClass('disabled');  
         }
         else if(refrence.length < 10){
            alert("Number should be 10 digits");
            $("#submit").addClass('disabled');  
         }
         else if(refrence.length == 10){  
            $("#submit").removeClass('disabled');
         }
         else{
            $("#submit").removeClass('disabled');
         }
        }
        else{
            $("#submit").removeClass('disabled');
        }
     } 


var psword = <?php echo(json_encode($psword)); ?>;
function passwordcheck(){
    //debugger

    if(psword == "" || psword == " " || psword == null){
        
      $("#password").prop('required', true);

   }else{
    $("#password").prop('required', false);
   }
}


// $(function() {
//     $('.date-picker').datepicker({
//         changeMonth: false,
//         changeDate: false,
//         changeYear: true,
//         showButtonPanel: true,
//         dateFormat: 'yy',
//         maxDate: new Date(new Date().getFullYear(), 1, 1),
//         onClose: function(dateText, inst) {
//             //var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
//             var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
//             $(this).datepicker('setDate', new Date(year, 1, 1));
//         }
//     });
// });

var state = <?php echo(json_encode($state)); ?>;
function statedrop(){
    if(state != null || state == "" || state == " "){
      $("#states").val(state);

   }
}

var Dateage = <?php echo(json_encode($Dateage)); ?>;
function yearage(){
    //debugger;
    if(Dateage != null || Dateage == "" || Dateage == " "){
      $("#yearpicker").val(Dateage);

   }
}

 var birthDate = <?php echo(json_encode($birthDate)); ?>;
function datebirth(){
    if(birthDate != null || birthDate == "" || birthDate == " "){
      $("#year_birth2").val(birthDate);

   }
}

var dobage3 = <?php echo(json_encode($dobage3)); ?>;
function childdate(){
    if(dobage3 != null || dobage3 == "" || dobage3 == " "){
      $("#year_birth3").val(dobage3);

   }
}

var childage = <?php echo(json_encode($childage)); ?>;
function yearchild(){
    if(childage != null || childage == "" || childage == " "){
      $("#year_birth4").val(childage);

   }
}

function membertype(){ 
    //debugger;
    var checkmembertype = <?php echo(json_encode($memtype)); ?>; 

if(checkmembertype == "FAM"){
    document.getElementById('children').style.removeProperty('display'); 
    document.getElementById("Spousefirst").readOnly = false;
    document.getElementById("Spouselast").readOnly = false; 
}
}


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





