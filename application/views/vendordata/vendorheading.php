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

th {
  border: 1px solid black;
  text-align: left;
  background-color: #f6f6f6;
   border-collapse: collapse;
}

</style>

<section class="content-header">
    <h1>
        <?php echo __('Vendor Heading'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>vendorheading/index"><?php echo __('vendorheading'); ?></a></li>
        <li class="active"><?php echo __('Vendor Heading'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>
<section class="content left width_100">
    <form id="create_heading" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>vendordata/vendorheading" method="post" name="vendorheading" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <table class="table">
            <td class="td"><label class="control-label" for="vendorheading"><?php echo __('Vendor Heading'); ?>:</label>
                            <!-- <textarea name="vendorheading" class="form-control" ></textarea>  -->
                            <input type="headinginput" name="datavendor" class="form-control input-sm" required  /> 
                        </td> 
                    
                </td>
</table> 
                       
                 <fieldset>
                    <input type="hidden" name="createvendorheading" value="1" /> 
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
                
              
            </fieldset>
</div> 
</form>
   
</section>
