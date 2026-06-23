<section class="content-header">
    <h1>
        <?php echo __('category'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>category/index"><?php echo __('title_edit'); ?></a></li>
        <li class="active"><?php echo __('Edit Category'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

  ?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Category/edit" method="post" name="edit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <table class="table">
                 
                    <tr class="tr">
                    <td class="td">Category</td>
                        <td class="td"><input required="true"  id="category" class="form-control input-sm" type="text" name="category" size="25" value="<?php echo $tpl['Categoryarr']['category'] ?? ''; ?>" title="Category" placeholder="Category"></td>
                        
                    </tr>
                    </table>
                     
                
                <fieldset>
                    <input type="hidden" name="edit_Category" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['Categoryarr']['id'] ?? ''; ?>" />
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
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Category/edit" method="post" name="edit" enctype="multipart/form-data">
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