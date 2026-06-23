<section class="content-header">
    <h1>
         <?php echo __('Renew/Maintenance Report'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('title_members'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<!-- Main content -->
<section class="content">




    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#tab_1"><?php echo __('Pending Renew'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_2"><?php echo __('Pending Maintenance'); ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="tab_1" class="tab-pane active">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id">
                                <?php
                                require 'component/gd_member_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_2" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_2_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-2-id">
                                <?php
                                require 'component/other_category_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section><!-- /.content -->
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('member')); ?>" style="display:none">
    <p><?php echo __('ARE YOU SURE YOU WANT TO DELETE'); ?></p>
</div>
<div id="record_id" style="display:none"></div>
<div id="cat_id" style="display:none"></div>
<div id="dialogDeleteSelected" title="<?php echo htmlspecialchars(__('member')); ?>" style="display:none">
    <p><?php echo __('member_del_selected_body'); ?></p>
</div>