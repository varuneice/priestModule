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
    <div class="navbar-inner">
        <ul class="nav nav-pills" >
            <li class="<?php echo (($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>"><a href="<?php echo INSTALL_URL; ?>Badges/index"><?php echo __('All_Parking'); ?></a></li>
            <?php if ($this->controller->isAdmin()||$this->controller->isParkingAdmin())  { ?>


            <li><a id="Sync" class="" style="background-color: indianred;color: white;">Data_Sync</a>
            </li>
            <?php
          } ?>
            <li>
                <a id="search-drop-btn-id" href="#"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;<?php echo __('search'); ?></a>
            </li>
            <!-- <li class="active" style="float: right" >
                <a  href="<?php echo INSTALL_URL; ?>Badges/import">
                    <i class="fa fa-fw fa-upload"></i>
                    <?php echo __('import'); ?>
                </a>
            </li> -->
        </ul>
        <?php require 'component/search.php'; ?>
    </div>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active">
                <a data-toggle="tab" href="#sponsortab"><?php echo __('Sponsor'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#paidtab"><?php echo __('Paid Parking'); ?></a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#volunteertab"><?php echo __('Volunteers Parking'); ?></a>
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
                                require 'component/sponsortab_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="paidtab" class="tab-pane">
               <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_2_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-2-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Badges&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/paidtab_table.php';
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="volunteertab" class="tab-pane">
                <div class="box">
                    <div class="box-body table-responsive">
                        <div id="tab_3_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <form name="table-frm" id="table-frm-3-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Badges&action=deleteSelected">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                <?php
                                require 'component/volunteertab_table.php';
                                ?>
                                 <!-- <a href="http://localhost/parking/Badges/edit"> <button style="margin-top:-13px;" type="button"  class="btn btn-primary "><?php echo __('Add New'); ?></button></a> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>          
        </div>
    </div>
</section><!-- /.content -->
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('Badges')); ?>" style="display:none">
    <p><?php echo __('member_del_body'); ?></p>
</div>
<div id="record_id" style="display:none"></div>
<div id="cat_id" style="display:none"></div>
<div id="dialogDeleteSelected" title="<?php echo htmlspecialchars(__('Badges')); ?>" style="display:none">
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
    function ticket(){
        $.LoadingOverlay("show");
        $.ajax({
        url: 'https://www.durgabari.net/paras/ticket.php',
        type: 'get',
        dataType: 'JSON',
        success: function(res2){
			 debugger;   
            $.ajax({
                type: 'POST',
                //url: 'http://localhost/5sep/ticket.php',
                url: '<?= INSTALL_URL ?>ticket.php',
               //data: {mydata:res2},
              
               data: JSON.stringify(res2),
                encode: true,
                async: false,
                success: function (data) {
                   
                }
            });
            member();
             
        }
        
    });
    }
    function member(){
     
        $.ajax({
         url: 'https://www.durgabari.net/paras/member.php',
         type: 'get',
        dataType: 'JSON',
       success: function(res){
        debugger;   
            $.ajax({
                type: 'POST',
                //url: 'http://localhost/5sep/member.php',
                url: '<?= INSTALL_URL ?>member.php',
            //    data: {mydata:res},
            data: JSON.stringify(res),
                async: false,
                success: function (data) {
                    debugger;
                    //ticket();      
                }
            });
            donation(); 
        }
    }); 
    }
    function donation(){
       
        $.ajax({
        url: 'https://www.durgabari.net/paras/donation.php',
        type: 'get',
        dataType: 'JSON',
        success: function(res1){
        $.LoadingOverlay("hide");  
          
            $.ajax({
                type: 'POST',
                url: '<?= INSTALL_URL ?>donation.php',
                //url: 'http://localhost/5sep/donation.php',
                // data: {mydata:res1},
                data: JSON.stringify(res1),
                encode: true,
                async: false,
                success: function (data) {
                   // member();    
                }
                 
            });
             alert("Data sync successfully"); 
            
              
        }
    });
     

    }
$('#Sync').click(function(e) {
        e.preventDefault();
      
		ticket();
	 
	
   });
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
