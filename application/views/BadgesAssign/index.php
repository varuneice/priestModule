<section class="content-header">
    <h1>
        <?php echo __('Badges_header'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('Badges_header'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<!-- Main content -->
<section class="content">
    <div class="navbar-inner">
        <ul class="nav nav-pills">
            <li class="<?php echo (($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>BadgesAssign/index"><?php echo __('All_Badges'); ?></a></li>
            <li>
                <a id="search-drop-btn-id" href="#"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;<?php echo __('search'); ?></a>
            </li>
            
        </ul>
        <?php require 'component/search.php'; ?>
    </div>
    <div class="box">
        <div class="box-body table-responsive">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Booking&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <?php
                     require 'component/badgestab_table.php';
                    ?>
                </form>
            </div>
        </div>
    </div>
</section><!-- /.content -->
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('book_del_title')); ?>" style="display:none">
    <p><?php echo __('book_del_body'); ?></p>
</div>
<div id="record_id" style="display:none"></div>
<div id="dialogDeleteSelected" title="<?php echo htmlspecialchars(__('book_del_selected_title')); ?>" style="display:none">
    <p><?php echo __('book_del_selected_body'); ?></p>
</div>
<script>
$('#search-drop-btn-id').click(function(e) {
    debugger
    e.preventDefault();

if ($('#search-booking-frm-id').is(':visible')) {
    $('#search-booking-frm-id').slideUp();
} else {
    $('#search-booking-frm-id').slideDown();
}


   });
</script>