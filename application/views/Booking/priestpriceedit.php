<section class="content-header">
    <h1>
        <?php echo __('Amount'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Booking/priestpriceedit"><?php echo __('Amount'); ?></a></li>
        <li class="active"><?php echo __('Amount'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$pujalocation = $tpl['priestpricearr']['location'] ?? '';

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Booking/priestpriceedit" method="post" name="priestpriceedit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;"> Add Amount</h1><br>
            <table class="table">
            <tr>    
                    <th>Type</th>
                    <th>Location</th>
                    <th>price</th>
                    </tr>
                    <tr class="tr">
                    <td class="td"><input  required="true" id="pujname" class="form-control input-sm" type="text" name="pujaname" size="25" value="<?php echo $tpl['priestpricearr']['pujaname'] ?? ''; ?>" title="<?php echo __('Puja Name'); ?>" placeholder="Puja Name"></td>
                    <td class="td">
                        <select data-rule-required='true' name="location" id="location" class="form-control input-sm" >
                            <option value="">Select location</option>
                            <option value="inside">Inside Durgabari</option>
                            <option value="outside">Outside Durgabari</option>
                            <option value="outsidewholeday">OutSide DurgaBari Whole Day</option>
                            <option value="wholeday">Out Of Town / Whole Day</option>
                        </select>
                    </td>
                    <td class="td"><input required="true" id="Price" class="form-control input-sm" type="text" name="price" size="25" value="<?php echo $tpl['priestpricearr']['price'] ?? ''; ?>" title="<?php echo __('Price'); ?>" placeholder="Price"></td>
                     </tr>
                   
                </table>
                <fieldset>
                   <input type="hidden" name="priestpriceedit" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['priestpricearr']['id'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>

            

        </div>

    </form>
</section>

 <script >
$(document).ready(function() {
    debugger;
    locationprice();
  
});
var pujalocation = <?php echo(json_encode($pujalocation)); ?>;
function locationprice(){
    if(pujalocation !=null || pujalocation == "" || pujalocation == " "){
 $("#location").val(pujalocation);
}

}
</script> 