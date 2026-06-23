<section class="content-header">
    <h1>
        <?php echo __('Vendor Heading'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                <?php echo __('home'); ?>
            </a></li>
        <li><a href="<?php echo INSTALL_URL; ?>vendordata/vendorpriceedit"><?php echo __('Vendor Heading'); ?></a></li>
        <li class="active">
            <?php echo __('Vendor Heading'); ?>
        </li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';


?>
<section class="content left width_100">
    <form id="vendoredit" class="frm-class user-frm-class"
        action="<?php echo INSTALL_URL; ?>vendordata/vendorheadingedit" method="post" name="vendorheadingedit"
        enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <table class="table">
                    <table class="table">
            <td class="td"><label class="control-label" for="vendorheading"><?php echo __('Vendor Heading'); ?>:</label>
                            <!-- <textarea name="vendorheading" class="form-control" ></textarea>  -->
                            <input type="headinginput" name="datavendor" class="form-control input-sm" value="<?php echo $tpl['vendorheadingarr']['datavendor'] ?? ''; ?>" required  /> 
                        </td> 
                    
                </td>
</table> 

                </table>
                <fieldset>
                    <input type="hidden" name="headingedit" value="1" />
                    <input type="hidden" name="id" value="<?php echo $tpl['vendorheadingarr']['id'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>"
                        name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;
                        <?php echo __('save') ?>
                    </button>
                </fieldset>
            </fieldset>
        </div>

    </form>

   
</section>

