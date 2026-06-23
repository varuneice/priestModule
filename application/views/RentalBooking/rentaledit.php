<section class="content-header">
    <h1>
        <?php echo __('RentalAmount'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>RentalBooking/rentaledit"><?php echo __('RentalAmount'); ?></a></li>
        <li class="active"><?php echo __(' RentalAmount'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$rentalamount = $tpl['rentalpricearr']['location'] ?? '';
$membertype = $tpl['rentalpricearr']['type'] ?? '';

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>RentalBooking/rentaledit" method="post" name="feeedit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;"> Add Amount</h1><br>
            <table class="table">
            <tr>
                    <th>Location</th>
                    <th>Type</th>
                    <th>price</th>
                    <th>Duration (Hours)</th>
                    </tr>
                    <tr class="tr">
                        <td class="td">
                        <select data-rule-required='true' name="location" id="rentalocationfield" class="form-control input-sm" >
                        <option value="">Select location:</option>
                        <option value="auditorium">Auditorium</option>
                        <option value="kalabhavan">Kalabhavan</option>
                        <option value="both">Both Auditorium and Kalabhavan</option>
                    </select>
                        </td>
                        <td class="td">
                        <select required="" name="type" id="registrationmember"
                                class="form-control input-sm" aria-required="true" aria-invalid="false" >
                                <option value="">Please select Member type</option>
                                <option value="member">Member</option>
                                <option value="nonmember">Non-Member</option>
                                 </select></td>
                        <td class="td"><input required="true" id="Price" class="form-control input-sm" type="number" name="price" size="25" value="<?php echo $tpl['rentalpricearr']['price'] ?? ''; ?>" title="<?php echo __('Price'); ?>" placeholder="Price"></td>
                        <td class="td"><input required="true" id="hours" class="form-control input-sm" type="number" name="hours" size="25" value="<?php echo $tpl['rentalpricearr']['hours'] ?? ''; ?>" title="<?php echo __('Duration'); ?>" placeholder="Duration"></td>
                        
                     </tr>
                   
                </table>
                <fieldset>
                   <input type="hidden" name="priceedit" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['rentalpricearr']['id'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>

            

        </div>

    </form>
   
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
</section>


<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>RentalBooking/rentaledit" method="post" name="edit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;"> Advance Amount</h1><br>
            <table class="table">
                 
            <tr class="tr">
                <th >Advance Amount</th>
                <th >Description</th>

                </tr>

                <tr class="tr">
                    <td class="td"><input  required="true" id="advanceamount" class="form-control input-sm" type="text" name="advanceamount" size="25" value="<?php echo $tpl['rentalarr']['advanceamount'] ?? ''; ?>" title="AdvanceAmount" placeholder="AdvanceAmount"></td>
                   
                   <td class="td"><input  required="true" id="description" class="form-control input-sm" type="text" name="description" size="25" value="<?php echo $tpl['rentalarr']['description'] ?? ''; ?>" title="Description" placeholder="Description"></td>
                   
                </tr>
                  

                    </table>
                     
                
                <fieldset>
                    <input type="hidden" name="edit_addamount" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['rentalarr']['id'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>
        </div>
    </form>
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
</section>


 <script >
$(document).ready(function() {
    debugger;
    rentalfieldlocation();
    checkmember();
  
});
var loccrental = <?php echo(json_encode($rentalamount)); ?>;
function rentalfieldlocation(){
    if(loccrental !=null || loccrental == "" || loccrental == " "){
 $("#rentalocationfield").val(loccrental);
}

}


var regmember = <?php echo(json_encode($membertype)); ?>;
function checkmember(){
    if(regmember !=null || regmember == "" || regmember == " "){
 $("#registrationmember").val(regmember);
}

}
</script> 