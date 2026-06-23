<?php
if (!empty($tpl['arr'])) {
    require 'show.php';
} else {
    ?>
    <div id="menu-container" style="width: 70%; margin:3px auto;  background-color:rgba(211,211,211) !important;">
        <div id="page-body">
            <main role="main">
                <div class="logo" style="background-color: #357ca5;">
                    <img src="../logo.jpg" class="profile"/>
                    <h3><b>Houston Durgabari Society</b></h3>
                    <h1 class="logo-caption"><span class="tweak">M</span>embership <span class="tweak">F</span>orm</h1>
                </div> 
                <!-- logo class -->
                <form id="payment-form" class="form-horizontal" method="post" action="" role="form" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <input type="hidden" name="login_user" value="1" />
                    <fieldset class="asb">
                        <table  class="table"> 
                            <tr class="tr">
                                <td class="td">Applicant Information &nbsp;&nbsp; (Check One)</td>
                                <td class="td">
                                    <input type="radio" id="new" name="information" value="new">New
                                </td>
                                <td class="td">
                                    <?php /*
                                      <label class="control-label" for="Member id"><?php echo __('Member id'); ?>:</label>
                                     */ ?>
                                </td>
                                <td class="MemberID">
                                    <?php /*
                                      <input required="true" id="Member id" class="form-control input-sm" type="text" name="Member_id" size="25" value="" title="MemberID" placeholder="MemberID">

                                     */ ?>
                                </td>
                            </tr>
                            <tr class="tr">
                                <td  class="td"><label class="control-label" for="F_Name">Member's First Name</label></td>
                                <td  class="td">
                                    <input required="true" id="Your_Name" class="form-control input-sm" type="text" name="F_Name" size="25" value="" title="First Name" placeholder="First Name">
                                </td>
                                <td  class="td"><label class="control-label" for="Sp_FName">Spouse Name</label></td>
                                <td  class="td"> 
                                    <input required="true" id="Spouse" class="form-control input-sm" type="text" name="Sp_FName" size="25" value="" title="Spouse Name" placeholder="Spouse Name">
                                </td>
                            </tr>
                            <tr class="tr">
                                <td  class="td">Govt Issued Photo ID/No:</td>
                                <td  class="td"> 
                                    <input type="radio" id="checked" name="GovtissueID" value="checked" />
                                                                    <label for="checked">Checked</label>
                                                                    <input type="radio" id="not_available" name="GovtissueID" value="not_available" />
                                                                    <label for="not_available">Not Available</label>
                                </td>
                                <td colspan="2"  class="td"> 
                                    <input type="radio" id="individual_membership" name="membership_type" value="individual_membership">
                                                                     <label for="individual_membership">Individual Membership</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                     <input type="radio" id="family_membership" name="membership_type" value="family_membership">
                                                                     <label for="family_membership">Family Membership</label>
                                </td>
                            </tr>
                            <tr class="tr">
                                <td  class="td"><label class="control-label" for="Address">Residential Address</label></td>
                                <td colspan="3" class="td">
                                    <input required="true" id="Address" class="form-control input-sm" type="text" name="Address1" size="25" value="" title="Address" placeholder="Address">
                                </td>                          
                            </tr>
                            <tr class="tr">
                                <td class="td"><label class="control-label" for="city">City</label>&nbsp; &nbsp; &nbsp; 
                                    <input required="true" id="city" class="form-control input-sm" type="text" name="City" size="25" value="" title="city" placeholder="city">
                                </td>
                                <td class="td"><label class="control-label" for="state">State</label> &nbsp;&nbsp; &nbsp;   
                                    <input required="true" id="state" class="form-control input-sm" type="text" name="State" size="25" value="" title="state" placeholder="state">  
                                </td>   .
                                <td  class="td"><label class="control-label" for="zip_code">Zip Code</label></td>
                                <td class="td">
                                    <input required="true" id="zip_code" class="form-control input-sm" type="text" name="Zip" size="25" value="" title="zip_code" placeholder="zip_code">  
                                </td>                        
                            </tr>
                            <tr class="tr">
                                <td class="td"><label class="control-label" for="phone_No">Phone No</label> </td>
                                <td class="td">
                                    <input required="true" id="phone_No" class="form-control input-sm" type="number" name="Mob_No"  value="" title="phone_No" placeholder="phone_No">
                                </td>   
                                <td class="td">
                                    <input required="true" id="phone_mobile" class="form-control input-sm" type="number" name="Tele1" size="25" value="" title="Tele1" placeholder="Tele1">
                                </td>
                                <td class="td">
                                    <input required="true" id="phone_work" class="form-control input-sm" type="number" name="Tele2" size="25" value="" title="phone_work" placeholder="phone_work">
                                </td>                        
                            </tr>
                            <tr class="tr">
                                <td  class="td"><label class="control-label" for="email">Email 1:</label></td>
                                <td  class="td">
                                    <input required="true" id="email" class="form-control input-sm" type="text" name="email" size="25" value="" title="email" placeholder="Email1">
                                </td>   
                                <td class="td"><label class="control-label" for="email">Email 2:</label></td>
                                <td class="td">  
                                    <input id="email2" class="form-control input-sm" type="text" name="Email2" size="25" value="" title="Email2" placeholder="Email2">
                                </td>                        
                            </tr>
                            <tr class="tr">
                                <td class="td" colspan="4" ><h3>Children's Information</h3></td>                     
                            </tr>
                            <tr class="tr">
                                <td class="td">
                                    <label class="control-label" for="Child">Children 1</label>&nbsp;&nbsp;&nbsp;
                                    <input id="Child" class="form-control input-sm" type="text" name="Child1" size="25" value="" title="Children" placeholder="Children 1">
                                </td>
                                <td class="td">
                                    <label class="control-label" for="year_birth">Year of Birth</label>&nbsp;&nbsp;&nbsp;
                                    <input max="<?php echo date('Y-m-d'); ?>" id="year_birth1" class="form-control input-sm" type="date" name="Age1" size="25" value="" title="year_birth" placeholder="">
                                </td>   
                                <td class="td">
                                    <label class="control-label" for="Child">Children 2</label>&nbsp;&nbsp;&nbsp;
                                    <input id="Child" class="form-control input-sm" type="text" name="Child2" size="25" value="" title="Children" placeholder="Children 2">
                                </td>
                                <td class="td">
                                    <label class="control-label" for="year_birth">Year of Birth</label>&nbsp;&nbsp;&nbsp;
                                    <input max="<?php echo date('Y-m-d'); ?>"  id="year_birth2" class="form-control input-sm" type="date" name="Age2" size="25" value="" title="year_birth" placeholder="">
                                </td>                       
                            </tr>
                            <tr class="tr">
                                <td  class="td">
                                    <label class="control-label" for="Child">Children 3</label>&nbsp;&nbsp;&nbsp;
                                    <input id="Child" class="form-control input-sm" type="text" name="Child3" size="25" value="" title="Children" placeholder="Children 3">
                                </td>
                                <td  class="td">
                                    <label class="control-label" for="year_birth">Year of Birth</label>&nbsp;&nbsp;&nbsp;
                                    <input max="<?php echo date('Y-m-d'); ?>"  id="year_birth3" class="form-control input-sm" type="date" name="Age3" size="25" value="" title="year_birth" placeholder="">
                                </td>   
                                <td  class="td">
                                    <label class="control-label" for="Child">Children 4</label>&nbsp;&nbsp;&nbsp;
                                    <input id="Child" class="form-control input-sm" type="text" name="Child4" size="25" value="" title="Children" placeholder="Children 4">
                                </td>
                                <td  class="td">
                                    <label class="control-label" for="year_birth">Year of Birth</label>&nbsp;&nbsp;&nbsp;
                                    <input max="<?php echo date('Y-m-d'); ?>"  id="year_birth4" class="form-control input-sm" type="date" name="Age4" size="25" value="" title="year_birth" placeholder="">
                                </td>                       
                            </tr>
                            <tr class="tr">
                                <td class="td" colspan="4"><h3>Membership Categories & Payment Details</h3></td>                     
                            </tr>
                            <tr class="tr">
                                <td class="td"><label class="control-label" for="Child">Category</label></td>
                                <td class="td"> </td>   
                                <td class="td"> <label class="control-label" for="Child">Rate </label></td>
                                <td class="td"><label class="control-label" for="Child"> Paid</label> </td>                        
                            </tr>
                            <tr class="tr">
                                <td colspan="2" class="td">General Member-Individual(Due jan1/Apr 1 every year) </td>
                                <td class="td">
                                    <input required="" type="radio" name="rate" value="gmi_1">$<?php echo $tpl['option_arr_values']['gmi_1'] ?? ''; ?>/ 
                                    <input required="" type="radio" name="rate" value="gmi_4">$<?php echo $tpl['option_arr_values']['gmi_4'] ?? ''; ?>
                                </td>
                                <td class="td">
                                    <input id="gmi_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="" title="Paid" placeholder="$">
                                </td>                        
                            </tr>
                            <tr class="tr">
                                <td colspan="2" class="td">General Member-Family(Due jan1/Apr 1 every year)</td>
                                <td class="td"> 
                                    <input required="" type="radio" name="rate" value="gmf_1">$<?php echo $tpl['option_arr_values']['gmf_1'] ?? ''; ?>/<input type="radio" name="rate" value="gmf_4">$<?php echo $tpl['option_arr_values']['gmf_4'] ?? ''; ?>
                                </td>
                                <td class="td">
                                    <input id="gmf_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="" title="Paid" placeholder="$">
                                </td>                        
                            </tr>
                            <tr class="tr">
                                <td colspan="2" class="td">Life Member(LM) </td> 
                                <td class="td">
                                    <input required="" type="radio" name="rate" value="lm">$<?php echo $tpl['option_arr_values']['lm'] ?? ''; ?>
                                </td>
                                <td class="td">
                                    <input id="lm_amount" class="form-control input-sm" type="text" name="amount[]" size="25" value="" title="Paid" placeholder="$">
                                </td>                        
                            </tr>
                            <tr class="tr">
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
                            </tr>
                            <tr class="tr">
                                <td class="td">Extra Donation</td>
                                <td class="td"></td>   
                                <td class="td">Any Amount</td>
                                <td class="td">
                                    <input id="donation" required="true" class="form-control input-sm" type="text" name="donation" size="25" value="" title="Paid" placeholder="$">
                                </td>                        
                            </tr>
                            <tr class="tr">  
                                <td class="td" colspan="3">Total</td>
                                <td class="td">
                                    <input id="total" required="true" class="form-control input-sm" type="text" name="total" size="25" value="" title="Paid" placeholder="$">
                                </td>                        
                            </tr>
                            <tr class="tr">
                                <td class="td" colspan="2">
                                    <label class="control-label" for="img" Style="margin-right:116px;">Driving Liscence/Passport</label>
                                </td>
                                <td class="td" colspan="2">
                                    <input required="true" class="form-control" type="file" name="img">
                                </td>
                            </tr>
                            <?php if ($this->controller->isLoged()) { ?>
                                <tr class="tr">
                                    <td class="td" colspan="2"><h3>Payment Method</h3></td>
                                    <td class="td" colspan="2">
                                        <select name="Payment_method" id="Payment_method" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false" style="width:100%;  height:50%;"> 
                                            <option value="" class ="amd">---</option>
                                            <?php
                                            $payment_method_arr = __('payment_method_arr');
                                            foreach ($payment_method_arr as $k => $v) {
                                                if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                                    ?>
                                                    <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>                    
                                </tr>
                            <?php } ?>
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
                                                <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr class="tr">
                                <td  class="td" colspan="4"><h3>Declaration Required</h3></td>                    
                            </tr>
                            <tr class="tr">
                                <td class="td" colspan="4">
                                    <input required="true" type="checkbox" id="terms" name="terms" value="terms">I pledge that I will cause no harm to HDBS, to its reputation or the reputation of its employees, 
                                    members and volunteers. I will abide by the rules and regulations of HDBS as set out in its 
                                    Constitution and Bylaws and policy documents. If I am found to be in any violation, my membership 
                                    can be denied, suspended or revoked. I understand that if I am a General Member (GM) and I default 
                                    to pay my dues on time, I will become a donor (GD) and lose all privileges including but not 
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
                                    <input required="true" type="checkbox" id="terms" name="terms" value="terms">
                                    I hereby declare that the above information is correct to the best of my knowledge. I shall 
                                    notify HDBS in writing, if there is any change to the above information within one month of the change.
                                </td>                    
                            </tr>
                            <tr class="tr">
                                <td class="td" colspan="4">
                                    <input required="true" type="checkbox" id="terms" name="terms" value="terms">
                                    I authorize HDBS to communicate with me by e-mail, and share my contact information in HDBS 
                                    magazine(s) or on the HDBS website.
                                </td>                    
                            </tr>
                            <tr class="tr">
                                <td class="td" colspan="4">
                                    <input required="true" type="checkbox" id="terms" name="terms" value="terms">
                                    I understand that my visit to Durga Bari will be at my own 
                                    risk and I will hold HDBS or its volunteers harmless from any liability and loss.
                                </td>                    
                            </tr>
                            <tr class="tr">
                                <td class="td" colspan="4">
                                    <input required="true" type="checkbox" id="terms" name="terms" value="terms">
                                    BY SIGNING BELOW, I AGREE WITH ALL OF THE ABOVE.
                                </td>                    
                            </tr>
                        </table>
                    </fieldset>
                    <fieldset>
                        <input type="hidden" name="create_member" value="1" /> 
                        <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo _('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo _('save') ?></button>
                    </fieldset>
                </form>
            </main>
        </div>
    </div>
<?php } ?>