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
        <?php echo __('Student Fee'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Studentfee/index"><?php echo __('Studentfee'); ?></a></li>
        <li class="active"><?php echo __('Student Fee'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Student/Studentfee" method="post" name="Studentfee" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <table class="table">
                    <tr> 
                    <th>School Type</th>
                    <th>Price</th>
                    <th>Late Fee</th>
                    <th>Type</th>
                    
                    </tr>
                    <tr class="tr">
                   <td class="td">
                        <!-- <input  required="true" id="SemesterName" class="form-control input-sm" type="text" name="SemmsterName" size="25" value="" title="<?php echo __('SemesterName'); ?>" placeholder="School Type"> -->
                        <select  required="" name="SemmsterName" id="SemesterName"
                                class="form-control input-sm" aria-required="true" >
                                <option value="">Please select school</option>
                                <option value="BanglaSchool">Bangla School</option>
                                <option value="Kalabhavan">Kalabhavan</option>
                                 <option value="Workshops">Workshops</option>
                                <option value="library">Library</option>

                            </select>
                </td>
                    <td class="td"><input  required="true" id="Price" class="form-control input-sm" type="number" name="Price" size="25" value="" title="<?php echo __('Price'); ?>" placeholder="Price"></td>
                    <td class="td"><input  id="lateFee" class="form-control input-sm" type="number" name="lateFee" size="25" value="" title="<?php echo __('Latefee'); ?>" placeholder="Late Fee"></td>
                    <td class="td">
                        <!-- <input  required="true" id="type" class="form-control input-sm" type="text" name="type" size="25" value="" title="<?php echo __('Type'); ?>" placeholder="Type"> -->
                              <select required="" name="type" id="membertype"
                                class="form-control input-sm" aria-required="true" aria-invalid="false">
                               <option value="">Please select Member type</option> 
                                <option value="member">Member</option>
                                <option value="nonmember">Non-Member</option>
                                 </select>
                    </td>
                        
                        </tr>
                        </table>
               
                   
                <fieldset>
                    <input type="hidden" name="create" value="1" /> 
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
                
              
            </fieldset>
</div> 
</form>
    <!-- <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div> -->
</section>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Student/Studentfee" method="post" name="Studentfee" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <h1  style ="margin:0; font-size:24px; color:#2679b5;"> Add Subject</h1><br>
                <table class="table">
                    <tr> 
                   <th> Subject</th>
                   <th>Type</th>
                 </tr>
                    <tr class="tr">
                    <td class="td"><input  required="true" id="subject" class="form-control input-sm" type="text" name="subject" size="25" value="" title="<?php echo __('subject'); ?>" placeholder="Subject"></td>
                   <td class="td">
                        
                     <!-- <input  required="true" id="type" class="form-control input-sm" type="text" name="type" size="25" value="" title="<?php echo __('type'); ?>" placeholder="Type">  -->
                     <select  required="" name="type" id="typeschool" class="form-control input-sm" aria-required="true" onchange="studentdropdownsubject(this)">
                                <option value="">Please select Registration type</option>
                                <option value="BanglaSchool">Bangla School</option>
                                <option value="kalabhavan">Kalabhavan</option>
                                 <!-- <option value="workshops">Workshops</option>
                                <option value="library">Library</option> -->

                            </select>
                    </td> 
                                   
                </tr>
                        </table>
                    </fieldset>
                   
                <fieldset>
                  <input type="hidden" name="createnewsubject" value="1" />  
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo _('save'); ?>" name="submit" tabindex="" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo _('save') ?></button>
                </fieldset>
</div> 
</form>
    <!-- <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div> -->
</section>