<style>
    .navbar-inner{
                 display:none;
    }
    </style>
<section class="content-header">
    <h1>
        <?php echo __('Member Logs'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('Member Logs'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<!-- Main content -->
<section class="content">
<div class="navbar-inner">
        <ul class="nav nav-pills">
            <li class="<?php echo (($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>">
                <a href="<?php echo INSTALL_URL; ?>MemberLog/index"><?php echo __('Meember Logs'); ?></a></li>
            <li>
                <a id="search-drop-btn-id" href="#"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;<?php echo __('search'); ?></a>
            </li>
        </ul>
        <?php require 'component/search.php'; ?>
    </div>
    <div class="box">
    <div class="box-body table-responsive">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                <form name="member-table-frm" id="member-table-frm-id" action="" method="post">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <fieldset>
                    <?php
                    require 'component/booking_table.php';
                    ?>
                      </fieldset>
                </form>
            </div>
            
        </div>
    </div>
</section><!-- /.content -->
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('student_del_title')); ?>" style="display:none">
    <p><?php echo __('student_del_body'); ?></p>
</div>
<div id="dialogDeleteGallery" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
    <p><?php echo __('gallery_del_body'); ?></p>
</div>
<div id="record_id" style="display:none"></div>