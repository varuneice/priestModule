<section class="content-header">
    <h1>
        <?php echo __('Event'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('Event'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<!-- Main content -->
<section class="content">
    <div class="navbar-inner" style="display:none;">
        <ul class="nav nav-pills" >
            <li class="<?php echo (($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Eventadmin/index"><?php echo __('all_event'); ?></a></li>
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
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active">
                <a data-toggle="tab" href="#tab_1"><?php echo __('Event'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#tab_2"><?php echo __('Ticket Event'); ?></a>
            </li>
             <li class="">
                <a data-toggle="tab" href="#tab_3"><?php echo __('Event Payment'); ?></a>
            </li>
            
             <li class="">
                <a data-toggle="tab" href="#tab_4"><?php echo __('Event Threshold Ammount'); ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="tab_1" class="tab-pane active">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Eventadmin&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                 require 'component/tab_2_table.php';
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
                            <form name="table-frm" id="table-frm-2-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Eventadmin&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_3_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--29 july-->
            
            <div id="tab_3" class="tab-pane">
               <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_3_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <?php
                                require 'component/event_payment.php';
                                ?>
                        </div>
                    </div>
                </div>
            </div>
            
             <div id="tab_4" class="tab-pane">
               <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_4_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <!-- <form name="table-frm" id="table-frm-2-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Eventadmin&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>"> -->
                                <?php
                                require 'component/event_threshold_amount.php';
                                ?>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</section><!-- /.content -->
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('Event')); ?>" style="display:none">
    <p><?php echo __('ARE YOU SURE YOU WANT TO DELETE'); ?></p>
</div>
<div id="record_id" style="display:none"></div>
<div id="cat_id" style="display:none"></div>
<div id="dialogDeleteSelected" title="<?php echo htmlspecialchars(__('member')); ?>" style="display:none">
    <p><?php echo __('member_del_selected_body'); ?></p>
</div>
<script>
      $(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
});
    </script>