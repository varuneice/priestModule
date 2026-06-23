<style>

th {
  border: 1px solid black;
  text-align: left;
  background-color: #f6f6f6;
   border-collapse: collapse;
}

</style>

<section class="content-header">
    <h1>
        <?php echo __('Amount'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>RentalBooking/index"><?php echo __('Amount'); ?></a></li>
        <li class="active"><?php echo __('Amount'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>RentalBooking/rentalpricecreate" method="post" name="RentalBooking" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;"> Add Amount</h1><br>
                <table class="table">
                    <tr> 
                    <th>Location</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Duration (Hours)</th>
                    </tr>
                    <tr class="tr">
                    <td class="td">
                        <select data-rule-required='true' name="location" id="location" class="form-control input-sm" >
                        <option value="">Select location:</option>
                        <option value="auditorium">Auditorium</option>
                        <option value="kalabhavan">Kalabhavan</option>
                        <option value="both">Both Auditorium and Kalabhavan</option>
                    </select> </td>
                    <td class="td"><select required="" name="type" id="registrationmember"
                                class="form-control input-sm" aria-required="true" aria-invalid="false">
                              <option value="">Please select Member type</option> 
                                <option value="member">Member</option>
                                <option value="nonmember">Non-Member</option>
                                 </select></td>
                    <td class="td"><input  required="true" id="Price" class="form-control input-sm" type="number" name="price" size="25" value="" title="<?php echo __('Price'); ?>" placeholder="Price"></td>
                     <td class="td"><input required="true" id="hours" class="form-control input-sm" type="number"
                                name="hours" size="25" value="" title="<?php echo __('hours'); ?>" placeholder="hours">
                        </td>
                    
                        </tr>
                        </table>
               
                   
                <fieldset>
                    <input type="hidden" name="rentallocationcreate" value="1" /> 
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
                
              
            </fieldset>
</div> 
</form>
 
</section>

<!-- <section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>RentalBooking/rentalcreate" method="post" name="rentalcreate" enctype="multipart/form-data">
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
                    <td class="td"><input  required="true" id="advanceamount" class="form-control input-sm" type="text" name="advanceamount" size="25" value="" title="AdvanceAmount" placeholder="AdvanceAmount"></td>
                   
                   <td class="td"><input  required="true" id="description" class="form-control input-sm" type="text" name="description" size="25" value="" title="Description" placeholder="Description"></td>
                   
                </tr>
                  
                </table>
                   
                <fieldset>
                    <input type="hidden" name="id" value="<?php echo $tpl['rentalarr']['id'] ?? ''; ?>" />
                    <input type="hidden" name="rentalcreate" value="1" /> 
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>
</div> 
</form>
    
</section> -->