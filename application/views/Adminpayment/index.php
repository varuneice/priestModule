
<style>
.connectedSortable {
    min-height: 68px;
}
</style>

<script>
      $(document).ready(function () {
        debugger;
    
            var yearget =  $("#datanew").val();
            if(yearget != ""){
                var element = document.getElementById("dropdownYear");
                element.value = yearget; 
            }
           else{
            var firstval =  $("#dropdownYear").val();
            $("#data").val(firstval);

           } 


       });
</script>
<section class="content-header">
    <h1>
        <?php echo __('Year wise revenue'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('Year wise revenue'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

$earliest_year = 2017;
  $current_year = date("Y");

?>
<!-- Main content -->
<form id="form" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Adminpayment/index"
        method="post" name="edit" enctype="multipart/form-data">
<section class="content">
    <div class="navbar-inner" style="display:none;">
        <ul class="nav nav-pills">
            <li class="<?php echo (($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Adminpayment/index"><?php echo __('Year wise revenue'); ?></a></li>
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
       
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#tab_1"><?php echo __('Year wise revenue'); ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="tab_1" class="tab-pane active">
                <div class="box">
                <section class="col-lg-6 connectedSortable" >
                            <?php                        
                                 echo '<select name="select" class="form-control" id="dropdownYear" style="width: 120px; margin-top: 15px;"
                                 onchange="getProjectReportFunc()">';
                                foreach (range(date('Y'), $earliest_year) as $x) {
                                   echo '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                 
                                }

                                ?>
                       </select>

                          
                    </section>
                    <section class="col-lg-6 connectedSortable">
                    <input class="button" name="submit_button" type="submit" class="form-control" style="width: 120px; margin-top: 20px;"/>
                    </section>
                    <section class="content">
                    <div class="box-body table-responsive">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Adminpayment&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/tab_1_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form><!-- /.content -->

<div id="dialogDelete" title="<?php echo htmlspecialchars(__('member')); ?>" style="display:none">
    <p><?php echo __('member_del_body'); ?></p>
</div>
<div id="record_id" style="display:none"></div>
<div id="cat_id" style="display:none"></div>
<input type="text" placeholder="Enter Data" name="data" style="display:none;" id="data">
<div id="dialogDeleteSelected" title="<?php echo htmlspecialchars(__('member')); ?>" style="display:none">
    <p><?php echo __('member_del_selected_body'); ?></p>
</div>
<script>

    
    function getProjectReportFunc(){
        debugger
        var year = $("#dropdownYear").val();
        $("#data").val(year);
    }
</script>