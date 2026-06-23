<section class="content-header">
    <h1>
        <?php echo __('Vendor Payment For'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                <?php echo __('home'); ?>
            </a></li>
        <li><a href="<?php echo INSTALL_URL; ?>vendordata/vendorpaymentforedit"><?php echo __('Vendor Payment For'); ?></a></li>
        <li class="active">
            <?php echo __('Vendor Payment For'); ?>
        </li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';


?>
<section class="content left width_100">
    <form id="vendoredit" class="frm-class user-frm-class"
        action="<?php echo INSTALL_URL; ?>vendordata/vendorpaymentforedit" method="post" name="vendorpaymentforedit"
        enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <table class="table">
                    <table class="table">
            <td class="td"><label class="control-label" for="vendorheading"><?php echo __('Vendor Payment For'); ?>:</label>
                            <input type="headinginput" name="payfor" class="form-control input-sm" value="<?php echo $tpl['vendorpaymentdata']['payfor'] ?? ''; ?>" required  /> 
                        </td> 
                    
                </td>

                <td class="td"><label class="control-label" for="Alice"><?php echo __('Alice'); ?>:</label>
                            <input type="text" name="payforalice" class="form-control input-sm" value="<?php echo $tpl['vendorpaymentdata']['payforalice'] ?? ''; ?>" required  /> 
                        </td> 
                    
                </td>
                <td class="td"><label class="control-label" for="Alice"><?php echo __('Description'); ?>:</label>
                            <input type="text" name="description" class="form-control input-sm"  value="<?php echo $tpl['vendorpaymentdata']['description'] ?? ''; ?>" required  /> 
                        </td> 
                    
                </td>
</table> 

                </table>
                <fieldset>
                    <input type="hidden" name="vendorpaymentforedit" value="1" />
                    <input type="hidden" name="id" value="<?php echo $tpl['vendorpaymentdata']['id'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>"
                        name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;
                        <?php echo __('save') ?>
                    </button>
                </fieldset>
            </fieldset>
        </div>

    </form>

   
</section>

