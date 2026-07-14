<section class="content-header">
    <h1>
        <?php echo __('title_members'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('title_members'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<style>
    .member-index-tabs > .nav-tabs {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    .member-index-tabs > .nav-tabs > li {
        float: none;
        margin-bottom: -1px;
    }
    .member-index-tabs > .nav-tabs > li > a {
        white-space: nowrap;
    }
</style>
<!-- Main content -->
<section class="content">
    <div class="navbar-inner">
        <ul class="nav nav-pills">
            <li class="<?php echo (($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Member/index"><?php echo __('all_members'); ?></a></li>
            <li>
                <a id="search-drop-btn-id" href="#"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;<?php echo __('search'); ?></a>
            </li>
            <!-- <li class="active" style="float: right" >
                <a  href="<?php echo INSTALL_URL; ?>Member/import">
                    <i class="fa fa-fw fa-upload"></i>
                    <?php echo __('import'); ?>
                </a>
            </li>-->
        </ul>
        <?php require 'component/search.php'; ?>
    </div>
    <div class="nav-tabs-custom member-index-tabs">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#tab_1"><?php echo __('Gen Active Members'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_2"><?php echo __('Life Members'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_3"><?php echo __('Benefactors'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_4"><?php echo __('CT members'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_5"><?php echo __('Inactive Members'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_6"><?php echo __('Expired'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_7"><?php echo __('GD Members'); ?></a>
            </li>
             <li class="">
                <a data-toggle="tab" href="#tab_8"><?php echo __('GC Members'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_9"><?php echo __('All Members'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_10"><?php echo __('Duplicates marked inactive'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_11">GC Duplicates</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="tab_1" class="tab-pane active">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Member&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_1_table.php';
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
                            <form name="table-frm" id="table-frm-2-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Member&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_2_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_3" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_3_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-3-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Member&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_3_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_4" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_4_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-4-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Member&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_4_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_5" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_5_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-5-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Member&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_5_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_6" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_6_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-6-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Member&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_6_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_7" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_7_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-7-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Member&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_7_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
             <div id="tab_8" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_8_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-8-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Member&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_8_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_9" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_9_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-9-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Member&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_9_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_10" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_10_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-10-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Member&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_10_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_11" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_11_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <?php
                            require 'component/tab_11_table.php';
                            ?>
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
