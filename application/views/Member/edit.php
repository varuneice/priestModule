<style>
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
    'information' => '',
    'membership_type' => '',
    'GovtissueID' => '',
    'rate' => '',
    'status' => '',
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
  $Application_date =strtotime($tpl['arr']['CreatedOn'] ?? '');
  $App_date = date("m/d/Y", $Application_date );
    $membercategory = $tpl['arr']['Category'] ?? '';
    $state = $tpl['arr']['State'] ?? ''; 
    $Dateage = $tpl['arr']['Age1'] ?? '';
    $birthDate = $tpl['arr']['Age2'] ?? '';
    $dobage3 = $tpl['arr']['Age3'] ?? '';
    $childage = $tpl['arr']['Age4'] ?? '';
?>            
<section class="content left width_100" id="renewmembership" >
    <form id="payment-form" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Member/checkout"
        method="post" name="payment-form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <table class="table">
                    <tr class="tr">

                        <td class="td">Applicant Information</td>
                        <td class="td" id="renew"style="display:none;">
                        <input type="radio" id="renewal" name="information" value="renewal" Checked>Renewal
                             
                        </td>
                        <td class="td"> Membership No</td>
                        <td class="td">
                            <input readonly id="Member_id" class="form-control input-sm" type="text" name="Member_id"
                                size="12" value="<?php echo $tpl['arr']['Member_id'] ?? ''; ?>" title="Member ID"
                                placeholder="Member ID">
                        </td>
                        <td class="td">Date of Renewal</td>
                        <td class="td">
                        <?php if ($tpl['arr']['Renew_date'] !="0000-00-00")  { ?>
                             <input readonly id="Renew_date" class="form-control input-sm" type="text"
                                name="Renew_date" size="12" value="<?php echo $date; ?>"
                                title="Renew Date" placeholder="Renew Date">
                                <?php
                } else {
                    ?>
                     <input readonly id="Renew_date" class="form-control input-sm" type="text"
                                name="Renew_date" size="12" value=""
                                title="Renew Date" placeholder="Renew Date">
                    <?php
                }
                ?>
                            </td>
                    </tr>
                </table>
                <!-- <table class="table">
                    <tr class="tr">
                        <td class="td">Applicant Information<span style="color:#ff0000">*</span></td>
                        <td class="td">
                            <input <?php echo ($tpl['arr']['information'] == 'new') ? "checked='checked'" : ""; ?>
                                required="" type="radio" id="new" name="information" value="new" />
                            New
                            <input <?php echo ($tpl['arr']['information'] == 'renewal') ? "checked='checked'" : ""; ?>
                                required="" type="radio" id="renewal" name="information" value="renewal" />
                            Renewal
                        </td>
                        <td class="td"> Membership No<span style="color:#ff0000">*</span></td>
                        <td class="td">
                            <input required="" id="Member_id" class="form-control input-sm" type="text" name="Member_id"
                                size="12" value="<?php echo $tpl['arr']['Member_id'] ?? ''; ?>" title="Member ID"
                                placeholder="Member ID">
                        </td>
                        <td class="td">Date of Renewal</td>
                        <td class="td">
                        <?php if ($renew !=false) { ?>
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
                    </tr>
                </table> -->
                <table class="table">
                    <tr class="tr">
                        <td class="td">
                            Member's First Name<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input required="" id="Your_Name" class="form-control input-sm" type="text" name="F_Name"
                                size="25" value="<?php echo $tpl['arr']['F_Name'] ?? ''; ?>" title="First Name"
                                placeholder="First Name">
                        </td>
                        <td class="td">Middle Name</td>
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
                        <td colspan="2" class="td test">
                            <input
                                <?php echo ($tpl['arr']['membership_type'] == 'individual_membership') ? "checked='checked'" : ""; ?>
                                required="" type="radio" id="individual_membership" name="membership_type"
                                value="individual_membership">
                            Individual Mebership &nbsp;&nbsp;&nbsp;&nbsp;
                            <input
                                <?php echo ($tpl['arr']['membership_type'] == 'family_membership') ? "checked='checked'" : ""; ?>
                                required="" type="radio" id="family_membership" name="membership_type"
                                value="family_membership">
                            Family Membership
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            Spouse Name
                        </td>
                        <td class="td">
                            <input required="" id="Spouse" class="form-control input-sm" type="text" name="Sp_FName"
                                size="25" value="<?php echo $tpl['arr']['Sp_FName'] ?? ''; ?>" title="Spouse Name"
                                placeholder="Spouse Name">
                        </td>
                        <td class="td">
                            Last Name<span style="color:#ff0000">*</span> </td>
                        <td class="td">
                            <input required="true" id="Spouselast" class="form-control input-sm" type="text"
                                name="Sp_LName" size="25" value="<?php echo $tpl['arr']['Sp_LName'] ?? ''; ?>"
                                title="Spouse Last Name" placeholder="Spouse Last Name">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            Residential Address<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input required="" id="Address" class="form-control input-sm" type="text" name="Address1"
                                size="25" value="<?php echo $tpl['arr']['Address1'] ?? ''; ?>" title="Address"
                                placeholder="Address">
                        </td>
                        <td class="td">Address 2
                        </td>
                        <td class="td">
                            <input id="Address" class="form-control input-sm" type="text" name="Address2" size="25"
                                value="<?php echo $tpl['arr']['Address2'] ?? ''; ?>" title="Address"
                                placeholder="Address Line 2">
                        </td>
                        <!-- <td class="td">Govt Issued Photo ID/No<span style="color:#ff0000">*</span></td>
                        <td class="td"> 
                            <input <?php echo ($tpl['arr']['GovtissueID'] == 'checked') ? "checked='checked'" : ""; ?> required="" type="radio" id="checked" name="GovtissueID" value="checked">
                            Available
                            <input <?php echo ($tpl['arr']['GovtissueID'] == 'not_available') ? "checked='checked'" : ""; ?> required="" type="radio" id="not_available" name="GovtissueID" value="not_available">
                            Not Available
                        </td> -->

                    </tr>
                    <tr class="tr">
                    <td class="td">Country</td>
                    <td class="td">
                    
                    <input id="Country" class="form-control input-sm" type="text" name="Country" 
                                value="<?php echo $tpl['arr']['Country'] ?? ''; ?>" title="Country" placeholder="Country" readonly>
                        
                    </td> 
                        <td class="td">
                            City<span style="color:#ff0000">*</span> </td>
                        <td class="td">
                            <input required="" id="city" class="form-control input-sm" type="text" name="City" size="25"
                                value="<?php echo $tpl['arr']['City'] ?? ''; ?>" title="City" placeholder="City">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            State<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <select required id="states" style="width: 100%!important;height: 36px!important;" 
                                        name="State" value="<?php echo $tpl['arr']['State'] ?? ''; ?>" class="form-control input-sm medium valid">
                                        <option value="">Please select State</option>
                                        <option value="Alabama">Alabama</option>
                                        <option value="Alaska">Alaska</option>
                                        <option value="Arizona">Arizona</option>
                                        <option value="Arkansas">Arkansas</option>
                                        <option value="California ">California</option>
										<option value="Colorado">Colorado</option>
										<option value="Connecticut">Connecticut</option>
										<option value="Delaware">Delaware</option>
										<option value="Florida">Florida</option>
										<option value="Georgia">Georgia</option>
										<option value="Hawaii">Hawaii</option>
										<option value="Idaho">Idaho</option>
										<option value="Illinois">Illinois</option>
										<option value="Indiana">Indiana</option>
										<option value="Iowa">Iowa</option>
										<option value="Kansas">Kansas</option>
										<option value="Kentucky">Kentucky</option>
										<option value="Louisiana">Louisiana</option>
										<option value="Maine">Maine</option>
										<option value="Maryland">Maryland</option>
										<option value="Massachusetts">Massachusetts</option>
										<option value="Michigan">Michigan</option>
										<option value="Minnesota">Minnesota</option>
										<option value="Mississippi">Mississippi</option>
										<option value="Missouri">Missouri</option>
										<option value="Montana">Montana</option>
										<option value="Nebraska">Nebraska</option>
										<option value="Nevada">Nevada</option>
										<option value="NewHampshire">New Hampshire</option>
										<option value="NewJersey">New Jersey</option>
										<option value="NewMexico">New Mexico</option>
										<option value="NewYork">New York</option>
										<option value="NorthCarolina">North Carolina</option>
										<option value="NorthDakota">North Dakota</option>
										<option value="Ohio">Ohio</option>
										<option value="Oklahoma">Oklahoma</option>
										<option value="Oregon">Oregon</option>
										<option value="Pennsylvania">Pennsylvania</option>
										<option value="RhodeIsland">Rhode Island</option>
										<option value="SouthCarolina">South Carolina</option>
										<option value="SouthDakota">South Dakota</option>
										<option value="Tennessee">Tennessee</option>
										<option value="TX">Texas</option>
										<option value="Utah">Utah</option>
										<option value="Vermont">Vermont</option>
										<option value="Virginia">Virginia</option>
										<option value="Washington">Washington</option>
										<option value="WestVirginia">West Virginia</option>
										<option value="Wisconsin">Wisconsin</option>
										<option value="Wyoming">Wyoming</option>
																			
                                    </select>
                        </td> 
                        <td class="td">
                            Zip Code<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input required="" id="zip_code" class="form-control input-sm" type="text" name="Zip"
                                size="25" value="<?php echo $tpl['arr']['Zip'] ?? ''; ?>" title="Zip Code"
                                placeholder="Zip Code">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            Phone No<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input required="" id="Tele1" class="form-control input-sm" type="number" name="Tele1"
                                size="25" value="<?php echo $tpl['arr']['Tele1'] ?? ''; ?>" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" title="Tele 1"
                                placeholder="Mobile No">
                        </td>
                        <td class="td">
                            <input id="phone_No" class="form-control input-sm" type="number" name="Mob_No" size="25"
                                value="<?php echo $tpl['arr']['Mob_No'] ?? ''; ?>" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" title="Phone No" placeholder="Phone No">
                        </td>
                        <td class="td">
                            <input id="phone_work" class="form-control input-sm" type="number" name="Tele2" size="25"
                                value="<?php echo $tpl['arr']['Tele2'] ?? ''; ?>" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" title="Work Phone" placeholder="Work Phone">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            Email<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input required="" id="email" class="form-control input-sm" type="text" name="email"
                                size="25" value="<?php echo $tpl['arr']['email'] ?? ''; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Email" placeholder="Email">
                        </td>
                        <td class="td">
                            Email 2
                        </td>
                        <td class="td">
                            <input id="email" class="form-control input-sm" type="text" name="Email2" size="25"
                                value="<?php echo $tpl['arr']['Email2'] ?? ''; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Email 2" placeholder="Email 2">
                        </td>
                    </tr>
                </table>
                <table id="children" style="display:none;" class="table">
                    <tr class="tr">
                        <td class="td" colspan="8">
                            <h3>Children's Information</h3>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="4" class="td">Child 1<input id="Child" class="form-control input-sm" type="text"
                                name="Child1" size="25" value="<?php echo $tpl['arr']['Child1'] ?? ''; ?>" title="Child"
                                placeholder="Full Name"></td>
                        <td class="td">Year of Birth
                        
                        <!-- <input id="year_birth" class="form-control input-sm date-picker"
                                name="Age1" size="25" value="<?php echo $tpl['arr']['Age1'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                                <select name="Age1" class="form-control input-sm selectpicker " data-live-search="true" id="yearpicker"></select>
                                
                                </td>
                        <td class="td">Child 2<input id="Child" class="form-control input-sm" type="text" name="Child2"
                                size="25" value="<?php echo $tpl['arr']['Child2'] ?? ''; ?>" title="Child"
                                placeholder="Full Name"></td>
                        <td class="td">Year of Birth
                        <!-- <input id="year_birth" class="form-control input-sm date-picker"
                                name="Age2" size="25" value="<?php echo $tpl['arr']['Age2'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                         <select name="Age2" class="form-control input-sm selectpicker " data-live-search="true" id="year_birth2"></select>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="4" class="td">Child 3<input id="Child" class="form-control input-sm" type="text"
                                name="Child3" size="25" value="<?php echo $tpl['arr']['Child3'] ?? ''; ?>" title="Child"
                                placeholder="Full Name"></td>
                        <td class="td">Year of Birth
                        
                         <!--<input id="year_birth" class="form-control input-sm date-picker"
                                name="Child" size="25" value="<?php echo $tpl['arr']['Age3'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                                 <select name="Age3" class="form-control input-sm selectpicker " data-live-search="true"  id="year_birth3"></select>
                                
                                </td>
                        <td class="td">Child 4<input id="Child" class="form-control input-sm" type="text" name="Child4"
                                size="25" value="<?php echo $tpl['arr']['Child4'] ?? ''; ?>" title="Child"
                                placeholder="Full Name"></td>
                        <td class="td">Year of Birth
                         <!--<input id="year_birth" class="form-control input-sm date-picker"
                                name="Age4" size="25" value="<?php echo $tpl['arr']['Age4'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                                 <select name="Age4" class="form-control input-sm selectpicker " data-live-search="true"  id="year_birth4"></select>
                                </td>
                    </tr>
                </table>
                <table class="table" style="display:none;" id="membershipcategory">
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <h3 style ="width:1213px;">Mebership Categories & Payment Details</h3>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td"><label class="control-label" for="Child">Category<span
                                    style="color:#ff0000">*</span></label></td>
                        <td class="td"> <label class="control-label" for="Child">Rate<span
                                    style="color:#ff0000">*</span> </label></td>
                        <td class="td"><label class="control-label" for="Child"> Paid</label> </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">General Member-Individual(Due jan1/Apr 1 every year) </td>
                        <td class="td">
                            <input <?php echo ($tpl['arr']['rate'] == 'gmi_1') ? "checked='checked'" : ""; ?>
                                required="" type="radio" name="rate"
                                value="gmi_1">$<?php echo $tpl['option_arr_values']['gmi_1'] ?? ''; ?>/
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
                            /<input <?php echo ($tpl['arr']['rate'] == 'gmf_4') ? "checked='checked'" : ""; ?> 
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
                        <td colspan="2" class="td">Extra Donation</td>
                        <td class="td">Any Amount</td>
                        <td class="td">
                            <input id="donation" class="form-control input-sm" type="text" name="donation" size="25"
                                value="<?php echo $tpl['arr']['donation'] ?? ''; ?>" title="Paid" placeholder="$">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="3" class="td" colspan="2">Total</td>
                        <td class="td">
                            <input id="total" class="form-control input-sm" type="text" name="total" size="25"
                                value="<?php echo $tpl['arr']['total'] ?? ''; ?>" title="Paid" placeholder="$" readonly>
                        </td>
                    </tr>
                </table>
                <table class="table" id="govtid">
                    <tr class="tr">
                        <td class="td">Add References</td>
                        <td class="td">
                            <input id="references" class="form-control input-sm" type="text" name="remarks" size="25"
                                value="<?php echo $tpl['arr']['remarks'] ?? ''; ?>" title="References" placeholder="References">
                        </td>
                        <td class="td">Phone No</td>
                                <td class="td"> <input  id="Ref_Phone" class="form-control input-sm" type="number"
                                    name="Ref_Phone" size="25" value="<?php echo $tpl['arr']['Ref_Phone'] ?? ''; ?>" title="Phone No" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="Phone No">
                                </td>
                        <td class="td">Date of Application<span style="color:#ff0000">*</span></td>
                        <td class="td">
                        <input disabled="" id="Application_date" class="form-control input-sm" type="text"
                                name="CreatedOn" size="12" value="<?php echo $App_date; ?>"
                                title="Application Date" placeholder="Application Date">
                        </td>
                    </tr>
                    
                </table>
              
                <table class="table" style="display:none;" id="payment">
                    <tr class="tr">
                        <td class="td" colspan="2" id="paytext">
                            <h3>Payment Method</h3>
                        </td>
                        <td class="td" colspan="2" id="paymethod">
                            <select  name="Payment_method" id="Payment_method"
                                class="form-control input-sm medium valid"  aria-invalid="false"
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
                                <option <?php echo ($tpl['arr']['status'] == $k) ? "selected='selected'" : ""; ?>
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
                    <table class="table">
                    <tr class="tr"  id="MemberID1" style="display: none;" class="form-group">
                    <label class="control-label" for="F_Name" style="color:white;">Payment Details:</label>
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
                <input type="hidden" name="pay_user" value="1" />
                <input type="hidden" name="ID" value="<?php echo $tpl['arr']['ID'] ?? ''; ?>" />
                <input type="hidden" name="membercategory" value="<?php echo $tpl['arr']['Category'] ?? ''; ?>" /> 
                <!-- <input type="hidden" name="Renew_date" value="<?php echo $tpl['arr']['Renew_date'] ?? ''; ?>" /> -->
                <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                <?php if ($membercategory == "GD")  { ?>
                <button id="member_btn_id" class="btn btn-primary" autocomplete="off" value="<?php echo __('pay'); ?>"
                    name="pay" tabindex="9" type="submit">
                    <i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('pay') ?>
                </button>
                <?php
                                } else {
                                    ?>
                <button id="member_btn_id" class="btn btn-primary" autocomplete="off" value="<?php echo __('pay'); ?>"
                    name="pay" tabindex="9" type="submit">
                    <i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?>
                </button>
                <?php
                            } ?>	
            </fieldset>
        </div>
    </form>
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
</section>
<div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key'] ?? ''; ?>
</div>
<script>
debugger;
var membercategory = <?php echo(json_encode($membercategory)); ?>;
if(membercategory == 'GD'){
    
    document.getElementById( 'renew' ).style.display = 'block';
    document.getElementById( 'payment' ).style.display = 'block';
    $("#Payment_method").prop('required',true);
    document.getElementById("paytext").style.width = "800px";
    document.getElementById("paymethod").style.width = "428px";
    document.getElementById("renew").style.height = "50px";
    document.getElementById("paytext").style.height = "95px";
    document.getElementById( 'membershipcategory' ).style.display = 'block';
}
else{
    document.getElementById( 'renew' ).style.display = 'none';
    document.getElementById( 'payment' ).style.display = 'none';
    document.getElementById( 'membershipcategory' ).style.display = 'none';
        $("#Payment_method").prop('required',false);
}
$( document ).ready(function() {
statedrop();
yearage();
datebirth();
childdate();
yearchild();
});
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
    debugger;
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
