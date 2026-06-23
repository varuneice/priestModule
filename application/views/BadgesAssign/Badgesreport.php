<section class="content-header">
<h1>
        <?php echo __('Parking'); ?>
    </h1>
    <ol class="breadcrumb header">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('Parking'); ?></li>
        <li><a style = "background-color:#428bca; color:white;margin-top:-10px"href="<?php echo INSTALL_URL ?>Admin/logout" class="btn btn-default btn-flat"><i class="fa fa-fw fa-sign-out"></i>&nbsp;<?php echo __('sign_out'); ?></a>
       </li>
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
                <a data-toggle="tab" href="#sponsortab"><?php echo __('Badges report'); ?></a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="sponsortab" class="tab-pane active">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Badges&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/badgesreport_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('Badges')); ?>" style="display:none">
    <p><?php echo __('member_del_body'); ?></p>
</div>
<div id="record_id" style="display:none"></div>
<div id="cat_id" style="display:none"></div>
<div id="dialogDeleteSelected" title="<?php echo htmlspecialchars(__('Badges')); ?>" style="display:none">
    <p><?php echo __('member_del_selected_body'); ?></p>
</div>


