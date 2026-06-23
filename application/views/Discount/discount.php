<section class="content-header">
    <h1>
        <?php echo __('discount'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('discount'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content">
    <div class="box">
        <div class="box-body table-responsive">
            <div class="callout callout-info ">
                <p><?php echo __('discount_info'); ?></p>
            </div>
            <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                <form name="discount-frm" id="discount-frm-id" action="" method="post">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <fieldset>
                        <?php require 'component/discount_table.php'; ?>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>
<div id="dialogAddDiscount" title="<?php echo htmlspecialchars(__('Add_Discount')); ?>" style="display:none">
    <?php require 'component/frm_add_discount.php'; ?>
</div>
<div id="dialogEditDiscount" title="<?php echo htmlspecialchars(__('Edit_Discount')); ?>" style="display:none">
    <?php require 'component/frm_edit_discount.php'; ?>
</div>
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('discount_del_title')); ?>" style="display:none">
    <p><?php echo __('discount_del_body'); ?></p>
</div>
<div id="record_id" style="display:none"></div>
<div id="room_type_id" style="display:none"></div>