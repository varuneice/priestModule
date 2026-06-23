<style>
  @media only screen and (max-width: 499px){
		 .right-side {
              margin-left:0px!important;
             }
	}
		@media (min-width: 500px) and (max-width: 767px) {
			.right-side {
              margin-left:0px!important;
             }
		}

		@media (min-width: 768px) and (max-width: 830px) {
            .right-side {
              margin-left:0px!important;
             }
		}

		@media(min-width: 831px) and (max-width: 990px) {
			.right-side {
              margin-left:0px!important;
             }
		}
</style>
<section class="content-header">
    <h1>
      </h1>  
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li class="active"><?php echo __('title_RegistrationDate'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
?>
<section class="content">

<div class="navbar-inner" style="display:none;">
        <ul class="nav nav-pills">
            <li class="<?php echo (($_REQUEST['action'] ?? '') == 'index') ? "active" : ""; ?>">
                <a href="<?php echo INSTALL_URL; ?>createnewsubject/index"><?php echo __('all_subject'); ?></a></li>
            <li>
                <a id="search-drop-btn-id" href="#"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;<?php echo __('search'); ?></a>
            </li>
        </ul>
        <?php require 'component/search.php'; ?>
    </div> 
    <div class="box">
        <div class="box-body table-responsive">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                <form name="table-frm" id="table-frm-id" method="post" action="<?php echo INSTALL_URL; ?>?controller=Student&action=registrationDate">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <fieldset>
                        <?php
                         require 'component/Student_Registration_Date_table.php';
                        ?>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>
<div id="dialogDelete" title="<?php echo htmlspecialchars(__('createnewsubject_del_title')); ?>" style="display:none">
    <p><?php echo __('createnewsubject_del_body'); ?></p>
</div>
<div id="dialogDeleteGallery" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
    <p><?php echo __('gallery_del_body'); ?></p>
</div>
<div id="record_id" style="display:none"></div>