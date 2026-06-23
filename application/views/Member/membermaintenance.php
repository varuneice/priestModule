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
#renewmembership{
    padding: 0px 15px;
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
.profile {
    margin-left: 50%;
    border-radius: 25%;
    transform: translate(-50%);
    filter: brightness(94%);
    padding: 10px;
    height: 166px;
}
#payment-form > div > fieldset > table:nth-child(7) > tbody > tr:nth-child(6) > td > div
{display:block;}
</style>
<?php
$memberDefaults = [
    'Renew_date' => '',
    'CreatedOn' => '',
    'Category' => '',
    'F_Name' => '',
    'M_Name' => '',
    'L_Name' => '',
    'membership_type' => '',
    'GovtissueID' => '',
    'Country' => '',
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
if (!empty($_POST['pay_usermaintenance'])) {
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

                if (($_POST['Payment_method'] ?? '') == 'stripe') {
                    ?>
                     <table border="4" width='585px' style= "margin-left:30em;" >
                                 <tr>
                                 <!-- <td colspan='2'> <img src='../thankyou.jpg' alt='' height='405px' width='580px'></td> </tr> -->
                                   <!-- <td colspan='2'> <img src='../create.png' alt='' height='102px' ></td>-->  
                                <td colspan='2'> <img src='../thankyouscreen.jpg' alt='' height='167px' style="margin-left:12em;"><h1 style="text-align:center;font-family:fangsong; font-size:30px;"><b>Houston Durga Bari Society</b></h1> </td> 
                                
                            </tr>
                                <tr>
                                <tr><td>Member ID</td> <td><?php echo $tpl['arr']['Member_id'] ?? ''; ?></td></tr>
                                <tr><td>Member Name</td> <td><?php echo ($tpl['arr']['F_Name'] ?? '').' ' .($tpl['arr']['M_Name'] ?? '').' ' .($tpl['arr']['L_Name'] ?? '');?></td></td></tr>
                                <tr><td>Member Email Address</td> <td><?php echo $tpl['arr']['email'] ?? ''; ?></td></tr>
                                <tr><td>Member Phone Number</td> <td><?php echo $tpl['arr']['Tele1'] ?? ''; ?></td></tr>
                                <tr><td>Amount</td> <td><?php echo $tpl['arr']['amount'] ?? ''; ?></td></tr>
								<tr><td>Transaction ID</td> <td><?php echo $tpl['arr']['transaction_id'] ?? ''; ?></td></tr>
                                <tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
                            </tr> 
                        </table> 
                        
                        <?php echo "<a href='" . INSTALL_URL . "Member/memberlookup'>Go to home</a>";?> 
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


<div id="page-body">

                <img src="<?= INSTALL_URL ?>thankyouscreen.jpg" class="profile" />
                </div>  
            
<section class="content-header" style="display:none;">
    <h1>
        <?php echo __('Member'); ?>
    </h1>
    <?php if (!$this->controller->isMember()) { ?>
    <ol class="breadcrumb" style="display:none;">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Member/index"><?php echo __('title_members'); ?></a></li>
        <li class="active"><?php echo __('edit_member'); ?></li>
    </ol>
    <?php } ?>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
  $renew =strtotime($tpl['arr']['Renew_date'] ?? '');
  $categ = $tpl['arr']['Category'] ?? '';
  $date = date("m/d/Y", $renew );
  $Application_date =strtotime($tpl['arr']['CreatedOn'] ?? '');
  $App_date = date("m/d/Y", $Application_date );
  $membercategory = $tpl['arr']['Category'] ?? '';
  $idmember = $tpl['arr']['ID'] ?? '';
  $state = $tpl['arr']['State'] ?? ''; 
  $Dateage = $tpl['arr']['Age1'] ?? '';
  $birthDate = $tpl['arr']['Age2'] ?? '';
  $dobage3 = $tpl['arr']['Age3'] ?? '';
  $childage = $tpl['arr']['Age4'] ?? '';
  $memtype = $tpl['arr']['membership_type'] ?? '';
  $coun = $tpl['arr']['Country'] ?? '';

?>            

<section class="content left width_100" id="renewmembership" >
    <form id="payment-form" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Member/membermaintenance"
        method="post" name="payment-form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <table class="table" >
                    <tr class="tr">
                    <!-- <input id="categorymember"  style="display:none;" class="form-control input-sm" type="text" name="Category"
                         size="12" value="<?php echo $tpl['arr']['Category'] ?? ''; ?>" title="Category" placeholder="Category" readonly>
</tr> -->
</table> 
            <table class="table">
                    <tr class="tr">
                        <td class="td">Applicant Information</td>
                        <td class="td" id="renew"style="display:none;">
                        <input type="radio" id="renewal" name="information" value="renewal">Renewal&nbsp;&nbsp;
                        </td>
                        <td class="td" id="maintenanceradio"style="display:none;">
                        <input type="radio" id="annulamaintenance" name="information" value="annulamaintenance" >Annual Maintenance
                         </td>
                        
                        <td class="td"> Membership No</td>
                        <td class="td">
                            <input readonly id="Member_id" class="form-control input-sm" type="text" name="Member_id"
                                size="12" value="<?php echo $tpl['arr']['Member_id'] ?? ''; ?>" title="Member ID"
                                placeholder="Member ID">
                        </td>
                        <!-- <td class="td">Date of Renewal</td>
                        <td class="td">
                       
                             <input readonly id="Renew_date" class="form-control input-sm" type="text"
                                name="Renew_date" size="12" value="<?php echo $date; ?>"
                                title="Renew Date" placeholder="Renew Date">
               
                            </td> -->
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

                        <td class="td">Category</td>
                        <td class="td">
                        <input disabled=""  id="member_category" class="form-control input-sm" type="text" name="Category"
                                size="12" value="<?php echo $tpl['arr']['Category'] ?? ''; ?>" title="Category"
                                placeholder="Category">
                        </td>
                    </tr>
                </table>

                <table class="table">
                    <tr class="tr">
                        <td class="td">
                            Member's First Name<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input readonly required="" id="Your_Name" class="form-control input-sm" type="text" name="F_Name"
                                size="25" value="<?php echo $tpl['arr']['F_Name'] ?? ''; ?>" title="First Name"
                                placeholder="First Name">
                        </td>
                        <td class="td">Middle Name</td>
                        <td class="td">
                            <input readonly id="middle name" class="form-control input-sm" type="text" name="M_Name" size="25"
                                value="<?php echo $tpl['arr']['M_Name'] ?? ''; ?>" title="Middle Name"
                                placeholder="Middle Name">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">Last Name <span style="color:#ff0000">*</span></td>
                        <td class="td">
                            <input readonly required="true" id="last name" class="form-control input-sm" type="text"
                                name="L_Name" size="25" value="<?php echo $tpl['arr']['L_Name'] ?? ''; ?>" title="Last Name"
                                placeholder="Last Name">
                        </td>
                        <td class="td">
                            Membership Type<span style="color:#ff0000">*</span>
                        </td>
                        <!-- <td colspan="2" class="td test">
                            <input
                                <?php echo ($tpl['arr']['membership_type'] == 'IND') ? "checked='checked'" : ""; ?>
                                required="" type="radio" id="individual_membership" name="membership_type"
                                value="IND">
                            Individual Membership &nbsp;&nbsp;&nbsp;&nbsp;
                            <input
                                <?php echo ($tpl['arr']['membership_type'] == 'FAM') ? "checked='checked'" : ""; ?>
                                required="" type="radio" id="family_membership" name="membership_type"
                                value="FAM">
                            Family Membership
                        </td> -->
                        <?php if ($membercategory == "GD" ||$membercategory == "GM")  { ?>
                                <td colspan="2" class="td test">
                                                            <input
                                                                <?php echo ($tpl['arr']['membership_type'] == 'IND') ? "checked='checked'" : ""; ?>
                                                                required="" type="radio" id="individual_membership" name="membership_type"
                                                                value="IND">
                                                            Individual Membership &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input
                                                                <?php echo ($tpl['arr']['membership_type'] == 'FAM') ? "checked='checked'" : ""; ?>
                                                                required="" type="radio" id="family_membership" name="membership_type"
                                                                value="FAM">
                                                            Family Membership
                                                        </td>
                                <?php
                                                            } ?> 						
                                                        
                                                    
                                <?php if ($membercategory == "LM" ||$membercategory == "PM" || $membercategory == "BF" || $membercategory == "FM" || $membercategory == "FP")  { ?>						
                                <?php if ($memtype == "IND")  { ?>						
                                <td class="td" id="individualradio">
                                <input <?php echo ($tpl['arr']['membership_type'] == 'IND') ? "checked='checked'" : ""; ?>
                                                                required="" type="radio" id="individual_membership" name="membership_type"
                                                                value="IND">
                                                            Individual Membership
                                </td>
                                <?php
                                } ?>
                                <?php if ($memtype == "FAM")  { ?>	
                                <td class="td" id="familyradio">
                                <input <?php echo ($tpl['arr']['membership_type'] == 'FAM') ? "checked='checked'" : ""; ?>
                                                                required="" type="radio" id="family_membership" name="membership_type"
                                                                value="FAM">
                                                            Family Membership
                                </td>
                                <?php
                                } ?>
                                <?php
                                } ?>
                                </tr>
                    <tr class="tr">
                        <td class="td">
                            Spouse Name
                        </td>
                        <td class="td">
                            <input readonly id="Spousefirst" class="form-control input-sm" type="text" name="Sp_FName"
                                size="25" value="<?php echo $tpl['arr']['Sp_FName'] ?? ''; ?>" title="Spouse Name"
                                placeholder="Spouse Name" readonly>
                        </td>
                        <td class="td">
                            Last Name </td>
                        <td class="td">
                            <input readonly id="Spouselast" class="form-control input-sm" type="text"
                                name="Sp_LName" size="25" value="<?php echo $tpl['arr']['Sp_LName'] ?? ''; ?>"
                                title="Spouse Last Name" placeholder="Spouse Last Name" readonly>
                        </td>
                    </tr>
                    <tr class="tr">
                        <!-- <td class="td">
                            Residential Address<span style="color:#ff0000">*</span>
                        </td> -->
                          <td class="td">
                          Street No <span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input readonly required="true" id="Address" class="form-control input-sm" type="text" name="Address1"
                                size="25" value="<?php echo $tpl['arr']['Address1'] ?? ''; ?>" title="Address"
                                placeholder="Street No">
                        </td>
                      <td class="td">Address<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input readonly id="Address" class="form-control input-sm" type="text" name="Address2" size="25"
                                value="<?php echo $tpl['arr']['Address2'] ?? ''; ?>" title="Address"
                                placeholder="Address" required="true" >
                        </td>
                        <!-- <td class="td">
                            <input id="Address" class="form-control input-sm" type="text" name="Address2" size="25"
                                value="<?php echo $tpl['arr']['Address3'] ?? ''; ?>" title="Address"
                                placeholder="Appartment No" >
                        </td> -->
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
                    <!-- <input id="Country" class="form-control input-sm" type="text" name="Country" 
                                value="<?php echo $tpl['arr']['Country'] ?? ''; ?>" title="Country" placeholder="Country" > -->
                                <select name="Country" id="Country" class="form-control input-sm" readonly>
                                <option value="">---</option>	
                                    <?php
                                    foreach (($tpl['Country'] ?? []) as $key => $value) {
                                    ?>
                                     <option <?php echo ($tpl['arr']['Country'] == $value['CountryCode']) ? "selected='selected'" : ""; ?> value="<?php echo $value['CountryCode']; ?>"><?php echo $value['Country']; ?></option> 
		
                                <?php
                                }
                                 ?>	
                                </select> 
                    </td> 
                        <td class="td">
                            City<span style="color:#ff0000">*</span> </td>
                        <td class="td">
                            <input readonly required="" id="city" class="form-control input-sm" type="text" name="City" size="25"
                                value="<?php echo $tpl['arr']['City'] ?? ''; ?>" title="City" placeholder="City">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            State<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                             <select readonly required id="states" style="width: 100%!important;height: 36px!important;" 
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
                            <input readonly required="" id="zip_code" class="form-control input-sm" type="text" name="Zip"
                                size="25" value="<?php echo $tpl['arr']['Zip'] ?? ''; ?>" title="Zip Code"
                                placeholder="Zip Code">
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                        Mobile No<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <!-- <input id="phone_No" class="form-control input-sm" type="number" name="Tele1" size="25"
                                value="<?php echo $tpl['arr']['Tele1'] ?? ''; ?>" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" title="Tele1" placeholder="Tele1" maxlength="10">  -->
                                <input id="phone_mobile" maxlength="10" readonly class="form-control input-sm" type="text"  value="<?php echo $tpl['arr']['Tele1'] ?? ''; ?>"  placeholder="###) ###-####" accesskey=""required=""  name="Tele1"  onchange="sponsoramount(this.id)" > 
                        </td>
                        <td class="td">
                        Home
                        </td>
                        <!-- <td class="td">
                           <input id="phone_work" maxlength="10" class="form-control input-sm" type="text" placeholder="Phone"  value="<?php echo $tpl['arr']['Mob_No'] ?? ''; ?>" name="Mob_No"  onchange="numbercheck(this.id)" > 

                        </td> -->
                        <td class="td">
                        <input id="phone_No" class="form-control input-sm" maxlength="10" readonly type="text" placeholder="###) ###-####"  value="<?php echo $tpl['arr']['Tele2'] ?? ''; ?>" name="Tele2"  onchange="numberduplicatecheck(this.id)" > 

                            <!-- <input id="phone_work" class="form-control input-sm" type="number" name="Tele2" size="25"
                                value="<?php echo $tpl['arr']['Tele2'] ?? ''; ?>" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" title="Work Phone" placeholder="Work Phone" maxlength="10"> -->
                        </td>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                            Email<span style="color:#ff0000">*</span>
                        </td>
                        <td class="td">
                            <input required="" readonly id="email" class="form-control input-sm" type="text" name="email"
                                size="25" value="<?php echo $tpl['arr']['email'] ?? ''; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Email" placeholder="name@company.com">
                        </td>
                        <td class="td">
                            Email 2
                        </td>
                        <td class="td">
                            <input id="email" readonly class="form-control input-sm" type="text" name="Email2" size="25"
                                value="<?php echo $tpl['arr']['Email2'] ?? ''; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Email 2" placeholder="name@company.com">
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
                                placeholder="Full Name" ></td>
                        <td class="td">Year of Birth
                        <!-- <input id="year_birth" class="form-control input-sm date-picker"
                                name="Age1" size="25" value="<?php echo $tpl['arr']['Age1'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                                  <select name="Age1"  class="form-control input-sm selectpicker " data-live-search="true" id="yearpicker">
                                  <option>Select year of birth</option>
                                  </select>
                                </td>
                        <td class="td">Child 2<input id="Child" class="form-control input-sm" type="text" name="Child2"
                                size="25" value="<?php echo $tpl['arr']['Child2'] ?? ''; ?>" title="Child"
                                placeholder="Full Name" ></td>
                        <td class="td">Year of Birth
                         <!--<input id="year_birth" class="form-control input-sm date-picker"
                                name="Age2" size="25" value="<?php echo $tpl['arr']['Age2'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                               <select name="Age2" class="form-control input-sm selectpicker " data-live-search="true" id="year_birth2" >
                               <option>Select year of birth</option>
                               </select>  
                        </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="4" class="td">Child 3<input id="Child" class="form-control input-sm" type="text"
                                name="Child3" size="25" value="<?php echo $tpl['arr']['Child3'] ?? ''; ?>" title="Child"
                                placeholder="Full Name" ></td>
                        <td class="td">Year of Birth
                         <!--<input id="year_birth" class="form-control input-sm date-picker"
                                name="Child" size="25" value="<?php echo $tpl['arr']['Age3'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                                  <select name="Age3" class="form-control input-sm selectpicker " data-live-search="true" id="year_birth3" >
                                  <option>Select year of birth</option>
                                  </select>
                                </td>
                        <td class="td">Child 4<input  id="Child" class="form-control input-sm" type="text" name="Child4"
                                size="25" value="<?php echo $tpl['arr']['Child4'] ?? ''; ?>" title="Child"
                                placeholder="Full Name"></td>
                        <td class="td">Year of Birth
                        
                         <!--<input id="year_birth" class="form-control input-sm date-picker"
                                name="Age4" size="25" value="<?php echo $tpl['arr']['Age4'] ?? ''; ?>" title="year_birth"
                                placeholder="Year of Birth">-->
                                
                                 <select  name="Age4" class="form-control input-sm selectpicker " data-live-search="true" id="year_birth4">
                                 <option>Select year of birth</option>
                                 </select>
                                </td>
                    </tr>
                </table>
                <table class="table" style="display:none;" id="membershipcategory" >
                    <tr class="tr">
                        <td class="td" colspan="4">
                            <h3>Membership Categories & Payment Details</h3>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td"><label class="control-label" for="Child">Category<span
                                    style="color:#ff0000">*</span></label></td>
                        <td class="td"> <label class="control-label" for="Child">Rate<span
                                    style="color:#ff0000">*</span> </label></td>
                        <td class="td"><label class="control-label" for="Child"> Paid</label> </td>
                    </tr>
                    <?php if ($membercategory == "GD")  { ?>
                    <tr class="tr"  id="memberindividual">
                        <td colspan="2" class="td">General Member-Individual(Due jan1/Apr 1 every year) </td>
                        <td class="td" style="display:none;">
                            <input <?php echo ($tpl['arr']['rate'] == 'gmi_1') ? "checked='checked'" : ""; ?>
                            id="price" type="radio" name="rate"
                                value="gmi_1">$<?php echo $tpl['option_arr_values']['gmi_1'] ?? ''; ?>
                                </td>

                         <td class="td" >
                            <input <?php echo ($tpl['arr']['rate'] == 'gmi_4') ? "checked='checked'" : ""; ?>
                            id="price2" type="radio" name="rate"
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
                                value="" title="Paid" placeholder="$" readonly>
                        </td>
                    </tr>
                    <tr class="tr" id="pricemembership" style="display:none; width:100%">
                        <td colspan="2" class="td">General Member-Family(Due jan1/Apr 1 every year)</td>
                        <td class="td" style="display:none;">
                            <input <?php echo ($tpl['arr']['rate'] == 'gmf_1') ? "checked='checked'" : ""; ?>
                            id="price3" type="radio" name="rate"
                                value="gmf_1">$<?php echo $tpl['option_arr_values']['gmf_1'] ?? ''; ?>
                                </td>
                                <td class="td" >
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
                                value="" title="Paid" placeholder="$" readonly>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td colspan="2" class="td">Life Member(LM) </td>
                        <td class="td">
                            <input <?php echo ($tpl['arr']['rate'] == 'lm') ? "checked='checked'" : ""; ?> id="price4"
                                type="radio" name="rate" value="lm">$<?php echo $tpl['option_arr_values']['lm'] ?? ''; ?>
                        </td>
                        <td class="td">
                            <input id="lm_amount" class="form-control input-sm" type="text" name="amount[]" size="25"
                                value="<?php echo ($tpl['arr']['rate'] == 'lm') ? $tpl['option_arr_values']['lm'] : ""; ?>"
                                title="Paid" placeholder="$" readonly>
                        </td>
                    </tr>
                    <?php
                            } ?> 
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
                    </tr>-->
                    <?php if ($membercategory == "LM" ||$membercategory == "PM" || $membercategory == "BF" || $membercategory == "FM" || $membercategory == "FP")  { ?>
                    <tr class="tr">
                        <td colspan="2" class="td">Maintenance (LM and higher)-per calendar Year </td> 
                        <td class="td">
                            <input <?php echo ($tpl['arr']['rate'] == 'lm_h') ? "checked='checked'" : ""; ?> id="maintenanceprice" type="radio" name="rate" value="lm_h">$<?php echo $tpl['option_arr_values']['lm_h'] ?? ''; ?>
                       
                        </td>
                        <td class="td">
                            <input id="lm_h_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="<?php echo ($tpl['arr']['rate'] == 'lm_h') ? $tpl['option_arr_values']['lm_h'] : ""; ?>" title="Paid" placeholder="$" readonly>
                        </td>                        
                    </tr>
                    <?php
                            } ?> 
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
                                value="" title="Paid" placeholder="$" readonly>
                        </td>
                    </tr>
                </table>
                <table class="table" id="govtid">
                    <tr class="tr">
                        <td class="td">Add References</td>
                        <td class="td">
                            <input readonly id="references" class="form-control input-sm" type="text" name="remarks" size="25"
                                value="<?php echo $tpl['arr']['remarks'] ?? ''; ?>" title="References" placeholder="References">
                        </td>
                        <td class="td">Phone No</td>
                                <td class="td"> 
                                    <!-- <input  id="Ref_Phone" class="form-control input-sm" type="number"
                                    name="Ref_Phone" size="25" value="<?php echo $tpl['arr']['Ref_Phone'] ?? ''; ?>" title="Phone No"  placeholder="Phone No" maxlength="10"> -->
                                 <input readonly maxlength="10" class="form-control" id="Ref_Phone" name="Ref_Phone"  type="number" value="<?php echo $tpl['arr']['Ref_Phone'] ?? ''; ?>"  onchange="numberrefcheck(this.id)">
                                </td>
                        <td class="td">Date of Application<span style="color:#ff0000">*</span></td>
                        <td class="td">
                        <input disabled="" id="Application_date" class="form-control input-sm" type="text"
                                name="CreatedOn" size="12" value="<?php echo $App_date; ?>"
                                title="Application Date" placeholder="Application Date">
                        </td>
                    </tr>
                </table>
              
                <table class="table" >
                <tbody style="display:none;" id="payment">
                <!-- <table class="table" style="visibility:hidden;display: none;" id="payment"> -->
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
                </tbody>
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
                    <table class="table" >
                    <tr>
                <td id="error_code1"></td>
                <!-- <td id="error_code"></td> -->
                <td id="error_codeimg"></td>
                    
                   
                    </tr>
                    </table>
                </table>
                <input type="hidden" name="pay_usermaintenance" value="1" />
                <input type="hidden" name="ID" value="<?php echo $tpl['arr']['ID'] ?? ''; ?>" />
                 <input type="hidden" name="membercategory" value="<?php echo $tpl['arr']['Category'] ?? ''; ?>" />  
                <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                <?php if ($membercategory == "GD" || $membercategory == "LM" || $membercategory == "PM" || $membercategory == "BF" || $membercategory == "FM" || $membercategory == "FP")  { ?>
                <button id="member_btn_id" class="btn btn-primary" autocomplete="off" value="<?php echo __('pay'); ?>"
                    name="pay" tabindex="9" type="submit">
                    <i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('pay') ?>
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
<?php } ?>
<script>
   $( document ).ready(function() {
    //debugger;
     //window.location.reload(); 
     statedrop();
     yearage();
     datebirth();
     childdate();
     yearchild();
     membertype();
     radiovaluecheck();
     //maintenancepaymentdate();
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
        //debugger;
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
        //debugger;
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
        //debugger;
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
var membercategory = <?php echo(json_encode($membercategory)); ?>;
if(membercategory == 'GD' || membercategory == 'LM' || membercategory == 'PM' || membercategory == 'BF' || membercategory == 'FM' || membercategory == 'FP'){
    document.getElementById( 'renew' ).style.display = 'block';
    document.getElementById('payment').style.removeProperty('display');
    document.getElementById("paytext").style.width = "800px";
    document.getElementById("paymethod").style.width = "649px";
    document.getElementById("renew").style.height = "50px";
    document.getElementById("paytext").style.height = "95px";
    document.getElementById('membershipcategory').style.removeProperty('display');
   // document.getElementById( 'member_btn_id' ).style.display = 'block';
    //document.getElementById( 'membersavebtn' ).style.display = 'none';
    $("#Payment_method").prop('required',true);
    $("#price").prop('required',true);
    $("#price2").prop('required',true);
    $("#price3").prop('required',true);
    $("#price4").prop('required',true);
    $("#maintenanceprice").prop('required',true);
}
else{
    document.getElementById( 'renew' ).style.display = 'none';
    document.getElementById( 'payment' ).style.display = 'none';
    document.getElementById( 'membershipcategory' ).style.display = 'none';
    //document.getElementById( 'member_btn_id' ).style.display = 'none';
    //document.getElementById( 'membersavebtn' ).style.display = 'block';
    $("#Payment_method").prop('required',false);
    $("#price").prop('required',false);
    $("#price2").prop('required',false);
    $("#price3").prop('required',false);
    $("#price4").prop('required',false);
    $("#maintenanceprice").prop('required',false);
}



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

var membercheckcategory = <?php echo(json_encode($membercategory)); ?>;
function radiovaluecheck(){
//debugger;
if(membercheckcategory == 'GD'){
    $('#renewal').parent().attr('aria-checked', 'true').addClass('checked');
    document.getElementById('renew').style.removeProperty('display');
    document.getElementById('maintenanceradio').style.display = 'none';

    document.getElementById('maintdatefield').style.display = 'none';
    document.getElementById('maintdate').style.display = 'none';
	document.getElementById('renewdatetext').style.removeProperty('display');
	document.getElementById('renewdatefield').style.removeProperty('display');
    
}

if( membercheckcategory == 'LM' || membercheckcategory == 'PM' || membercheckcategory == 'BF' || membercheckcategory == 'FM' || membercheckcategory == 'FP')
{
    $('#annulamaintenance').parent().attr('aria-checked', 'true').addClass('checked');
    document.getElementById('maintenanceradio').style.removeProperty('display');
    document.getElementById('renew').style.display = 'none';

    document.getElementById('renewdatetext').style.display = 'none';
  document.getElementById('renewdatefield').style.display = 'none';
  document.getElementById('maintdatefield').style.removeProperty('display');
  document.getElementById('maintdate').style.removeProperty('display');
    
}
}

function membertype(){ 
    //debugger;
    var checkmembertype = <?php echo(json_encode($memtype)); ?>; 

if(checkmembertype == "FAM"){
    document.getElementById('children').style.removeProperty('display');   
}
}

// function maintenancepaymentdate(){
//     debugger;
// let date =  new Date().getFullYear();
//  let maintenancedate = '31'+'/03/'+date;
//  let maintenancedatePrev= '15'+'/03/'+date;
//  let current_date = new Date();
//  let Month = current_date.getMonth()+1;
//  let cc = current_date.getDate()+"/"+Month+"/"+current_date.getFullYear();
//  if((cc  >= maintenancedatePrev) && cc  <= maintenancedate){
    
//     document.getElementById('payment').style.removeProperty('display');  
//     document.getElementById('member_btn_id').style.removeProperty('display'); 
//    }
//    else{
//     document.getElementById('payment').style.display = 'none';
//     document.getElementById('member_btn_id').style.display = 'none';

//    }
// }






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
