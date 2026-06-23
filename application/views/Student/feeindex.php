<section class="content-header">
    <h1>
        <?php echo __('Student Fee'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('Student Fee'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content">
    <div class="box">
        <div class="box-body table-responsive">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                <form name="table-Studentfeecreate" id="table-Studentfeecreate-id" action="" method="post">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <fieldset>
                        <?php require 'component/tab_2_table.php'; ?>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('Event')); ?>" style="display:none">
    <p><?php echo __('event_del_body'); ?></p>
</div>
<div id="dialogDeleteGallery" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
    <p><?php echo __('gallery_del_body'); ?></p>
</div>
<div id="record_id" style="display:none"></div>