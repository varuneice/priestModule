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
        <?php echo __('Edit'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
        <li><a href="<?php echo INSTALL_URL; ?>Student/feeedit"><?php echo __('title_editStudent'); ?></a></li>
        <li class="active"><?php echo __('Edit'); ?></li>
    </ol>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
 $feeval = $tpl['feearr']['Price'] ?? '';
 $name=explode("/",$feeval);
  $first = $name[0];
    $last= $name[1] ?? '';
    $member = $tpl['feearr']['type'] ?? '';
    $school = $tpl['subjectarr']['type'] ?? '';
    $registerationschool = $tpl['feearr']['SemmsterName'] ?? '';
    $lateFeeAmount = $tpl['feearr']['lateFee'] ?? ''

?>
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Student/feeedit" method="post" name="feeedit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
                <h1  style ="margin:0; font-size:24px; color:#2679b5;"> Edit Fee</h1><br>
            <table class="table">
                    <tr>
                    <th>School Type</th>
                    <th>Price</th>
                    <th>Late Fee</th>
                    <th>Type</th>
                    </tr>
                    <tr class="tr">
                         <td class="td">
                            <!-- <input required="true"  id="Semester_Name" class="form-control input-sm" type="text" name="SemmsterName" size="25" value="<?php echo $tpl['feearr']['SemmsterName'] ?? ''; ?>" title="Semester Name" placeholder="School Type"> -->
                            <select  required="" name="SemmsterName" id="Semester_Name"
                                class="form-control input-sm" aria-required="true" >
                                <option value="">Please select school</option>
                                <option value="BanglaSchool">Bangla School</option>
                                <option value="Kalabhavan">Kalabhavan</option>
                                 <option value="Workshops">Workshops</option>
                                <option value="library">Library</option>

                            </select>
                        
                        </td>
                        <td class="td"><input required="true" id="Price" class="form-control input-sm" type="number" name="Price" size="25" value="<?php echo $first; ?>" title="<?php echo __('Price'); ?>" placeholder="Price"></td>
                        <td class="td"><input  id="lateFee" class="form-control input-sm" type="number" name="lateFee" size="25" value="<?php echo $lateFeeAmount; ?>" title="<?php echo __('Latefee'); ?>" placeholder="Late Fee"></td>
                        
                       <td class="td">
                            
                        <!-- <input  required="true" id="type" class="form-control input-sm" type="text" name="type" size="25" value="<?php echo $tpl['feearr']['type'] ?? ''; ?>" title="<?php echo __('Type'); ?>" placeholder="Type"> -->
                    
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
                    <input type="hidden" name="feeedit_Student" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['feearr']['Id'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>

            

        </div>

    </form>
   
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
</section>

<!-- New subject code -->
<section class="content left width_100">
    <form id="edit_user" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Student/feeedit" method="post" name="feeedit" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <div class="padding-19 nav-tabs-custom left width_100">
            <fieldset>
            <h1  style ="margin:0; font-size:24px; color:#2679b5;"> Edit Subject</h1><br>
            <table class="table">
                    <tr>
                   <th>Subject</th>
                   <th>Type</th>
                    </tr>
                    <tr class="tr">
                       <td class="td"><input required="true"  id="subject" class="form-control input-sm" type="text" name="subject" size="25" value="<?php echo $tpl['subjectarr']['subject'] ?? ''; ?>" title="subject" placeholder="subject"></td>
                     <td class="td">
                         <!-- <input  required="true" id="type" class="form-control input-sm" type="text" name="type" size="25" value="<?php echo $tpl['subjectarr']['type'] ?? ''; ?>" title="<?php echo __('Type'); ?>" placeholder="Type"> -->
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
                <fieldset>
                    <input type="hidden" name="createnewsubject" value="1" /> 
                    <input type="hidden" name="id" value="<?php echo $tpl['subjectarr']['id'] ?? ''; ?>" />
                    <button id="submit" class="btn btn-primary" autocomplete="off" value="<?php echo __('save'); ?>" name="submit" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;<?php echo __('save') ?></button>
                </fieldset>
            </fieldset>

            

        </div>

    </form>
   
    <div id="dialogDeleteImage" title="<?php echo htmlspecialchars(__('gallery_del_title')); ?>" style="display:none">
        <p><?php echo __('gallery_del_body'); ?></p>
    </div>
</section>
<script>

$(document).ready(function() {
    debugger;
    checkmember();
    checkschooltype();
    feeschoolname();
  
});

var regmember = <?php echo(json_encode($member)); ?>;
function checkmember(){
    if(regmember !=null || regmember == "" || regmember == " "){
 $("#membertype").val(regmember);
}
}

var registerschool = <?php echo(json_encode($school)); ?>;
function checkschooltype(){
    debugger;
    if(registerschool !=null || registerschool == "" || registerschool == " "){
 $("#typeschool").val(registerschool);
}
}

var schoolfeee = <?php echo(json_encode($registerationschool)); ?>;
function feeschoolname(){
    debugger;
    if(schoolfeee !=null || schoolfeee == "" || schoolfeee == " "){
 $("#Semester_Name").val(schoolfeee);
}
}

</script>


