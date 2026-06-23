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
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
</head>
<style>
    .medium{
        width: 450px !important;
    }
    #footer{
        display:none!important;
    }
</style>
<?php
?>
<section class="content-header">
    <h1>
        <?php echo __('Edit Student'); ?>
    </h1>
    <?php if ($this->controller->isLoged()) { ?>
        <ol class="breadcrumb">
            <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i> <?php echo __('home'); ?></a></li>
            <li><a href="<?php echo INSTALL_URL; ?>Student/index">Students</a></li>
            <li class="active"><?php echo __('add_Student'); ?></li>
        </ol>
    <?php } ?>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$regtype = $tpl['arr']['Registration_type'] ?? '';
$memberregister = $tpl['arr']['regmember'] ?? '';
$firstsubject = unserialize($tpl['arr']['subject'] ?? '');
$firstsubject = is_array($firstsubject) ? $firstsubject : [];
$secsubject = unserialize($tpl['arr']['type'] ?? '');
$secsubject = is_array($secsubject) ? $secsubject : [];
?>
<section class="content left width_100">
    <form id="edit_student" class="frm-class user-frm-class" action="<?php echo INSTALL_URL; ?>Student/edit" method="post" name="create" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <table class="table">
        <tr class="tr">
                 <td class="td">
                  <h4>Registration Type</h4>
                 </td>
                        <td class="td"><select required="" name="Registration_type" id="Registration_type"
                                class="form-control input-sm" aria-required="true" aria-invalid="false">
                                <option value="">Please select Registration type</option>
                                 <option value="BanglaSchool">Bangla School</option>
                                <option value="Kalabhavan">Kalabhavan</option>
                                <option value="workshops">Workshops</option>
                                <option value="library">Library</option>
                            </select>
                        </td>
                        <td class="td" >Durga Bari Member</td>
                    <td class="td" > <select required="" name="regmember" id="registermembere"
                                class="form-control input-sm" aria-required="true" aria-invalid="false">
                                <option value="member">Yes</option>
                                <option value="nonmember">No</option>
                                  </select>
                                </td>
                        </tr>
                        <tr class="tr">
                        <td class="td">Student 1 Name</td>
                        <td class="td"><input required="" id="Student1Name" class="form-control input-sm" type="text"
                                placeholder="Student 1 Name" value="<?php echo $tpl['arr']['St_Name1'] ?? ''; ?>" name="St_Name1" tabindex="2" required></td>
                        <td class="td"> Student 2 Name</td>
                        <td class="td"><input id="Student2Name" class="form-control input-sm" type="text"
                                placeholder="Student 2 Name" value="<?php echo $tpl['arr']['St_Name2'] ?? ''; ?>" name="St_Name2" tabindex="3" >
                            </td>
                    </tr>
            <!-- </div> -->
          
           <tr class="tr">
                <!-- <?php
                $subject = unserialize($tpl['arr']['subject']);
                ?> -->
                <td class="td">
                Student 1 Subject
                </td>
                <td class="td">
                <!-- <select  name="subject[]" id="type" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false" multiple>
              
                </select> -->
                <input readonly  id="type" class="form-control input-sm" type="text" placeholder="" value="" name="subject">  
                        

                </td>
                <!-- </tr> -->
             
            <!-- <tr class="tr"> -->
                <!-- <?php
                $type = unserialize($tpl['arr']['type']);
                ?> -->
                <td class="td">
                Student 2 Subject
                </td>
                <td class="td">
                <!-- <select  name="type[]" id="type1" class="form-control input-sm medium valid" aria-required="true" aria-invalid="false" multiple> 
                </select> -->
                <input readonly  id="type1" class="form-control input-sm" type="text" placeholder="" value="" name="subject"> 
                </td>
           </tr>
             <tr class="tr">
              <td class="td">Member Name</td>
                        <td class="td">
                        <input id="membername" class="form-control input-sm" type="text"
                                placeholder="Member Name" value="<?php echo $tpl['arr']['membername'] ?? ''; ?>" name="membername" readonly >
                      </td>
                <td class="td">
                    Member ID</td>
                    <td class="td"> 
                        <input readonly  id="MemberID" class="form-control input-sm" type="number" placeholder="$Memberid" value="<?php echo $tpl['arr']['reg_uid'] ?? ''; ?>" name="reg_uid"  >  
                        </td>


                  <tr class="tr">
                    <td class="td">E-mail</td>
                        <td class="td"> <input required="" id="Your_E-mail" class="form-control input-sm" type="email"
                                pattern="[^@\s]+@[^@\s]+\.[^@\s]+" name="email" size="25" value="<?php echo $tpl['arr']['email'] ?? ''; ?>"
                                placeholder="E-mail"></td>
                        <td class="td">Phone Number</td>
                         <td class="td"><input required="" placeholder="###) ###-####" id="Your_Number" class="form-control input-sm" type="nubmer" name="phone_number" size="25" value="<?php echo $tpl['arr']['phone_number'] ?? ''; ?>" maxlength= "10" onchange="checkphoneno(this.id)"> </td>
            </tr>

            <tr class="tr">
            <td class="td">Fee</td>
                        <td class="td"> 
                        <input readonly  id="fee" class="form-control input-sm" type="number" placeholder="$Amount" value="<?php echo $tpl['arr']['fee'] ?? ''; ?>" name="fee"  >  
                        </td>
                <td class="td">
                   Total Amount</td>
                    <td class="td" colspan="3">
                    <input readonly  id="Amount" class="form-control input-sm" type="number" placeholder="$Amount" value="<?php echo $tpl['arr']['totalamount'] ?? ''; ?>" name="totalamount" tabindex="10" >
                </td>
     
                    
                    
            </tr>
            <tr class="tr">
              <td>
                 <fieldset>
                   <input type="hidden" name="edit_Student" value="1" /> 
                   <input type="hidden" name="uid" value="<?php echo $tpl['arr']['uid'] ?? ''; ?>" />
                   <button class="btn btn-primary" id="reset-btn-id" autocomplete="off" value="reset" name="reset" tabindex="9" type="reset"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Reset</button>
                   </td>
                   <td>
                   <button class="btn btn-primary" id="datasave" autocomplete="off" value="Save" name="pay" tabindex="9" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Save</button>
                 </fieldset>
              </td>
             </tr>
            <!-- <div class="form-group">
                <label class="control-label" for="F_Name">Pay Date</label>
                <input id="Your_Name" class="form-control input-sm" type="text" name="pay_date" size="25" value="<?php //echo $tpl['arr']['pay_date'] ?? ''; ?>" title="MemberID" placeholder="Pay_date">
            </div>
            <div class="form-group">
                <label class="control-label" for="F_Name">Remarks</label>
                <input id="Your_Name" class="form-control input-sm" type="text" name="remarks" size="25" value="<?php //echo $tpl['arr']['remarks'] ?? ''; ?>" title="MemberID" placeholder="Remarks">
            </div>
          </div> 
         <div class="form-group">
            <label class="control-label" for="F_Name">Created On</label>
            <input id="Your_Name" class="form-control input-sm" type="text" name="CreatedOn" size="25" value="<?php //echo $tpl['arr']['CreatedOn'] ?? ''; ?>" title="CreatedOn" placeholder="CreatedOn">
         </div>
         <div class="form-group">
            <label class="control-label" for="F_Name">Update on</label>
            <input id="Your_Name" class="form-control input-sm" type="text" name="update_on" size="25" value="<?php //echo $tpl['arr']['update_on'] ?? ''; ?>" title="update_on" placeholder="update on">
         </div> -->
        
        </tabel>
     </form>
</section>
<script>

$( document ).ready(function() {
debugger;
Registration();
checkmember();
subjectnamesecond();
subjectname();
});
var Register = <?php echo(json_encode($regtype)); ?>;
function Registration() {
if(Register !=null || Register == "" || Register == " "){
 $("#Registration_type").val(Register);
}
}
var notmember = <?php echo(json_encode($memberregister)); ?>;
function checkmember() {
debugger;
if(notmember !=null || notmember == "" || notmember == " "){
 $("#registermembere").val(notmember);
}
}

var subfirst = <?php echo(json_encode($firstsubject)); ?>;
function subjectname() {
if(subfirst !=null || subfirst == "" || subfirst == " "){
 $("#type").val(subfirst);
}
}

var subjectsecond = <?php echo(json_encode($secsubject)); ?>;
function subjectnamesecond() {
if(subjectsecond !=null || subjectsecond == "" || subjectsecond == " "){
 $("#type1").val(subjectsecond);
}
}

const phoneInputField = document.querySelector("#Your_Number");
      const phoneInput = window.intlTelInput(phoneInputField, {
        // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
        preferredCountries: ["us", "co", "in", "de"],
        utilsScript:
          "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      });


function checkphoneno(elem){
        debugger;
    const phonenumber =  $("#Your_Number").val();
        if(!!phonenumber){
         if(isNaN(phonenumber)){  
            alert("Please Enter mobile Number");
            $("#datasave").addClass('disabled');
            //document.getElementById("totalamount").value = price; 
         }
         else if(phonenumber.length > 10 ){
              alert("Number should be 10 digits");
              $("#datasave").addClass('disabled');  
         }
         else if(phonenumber.length < 10){
            alert("Number should be 10 digits");
            $("#datasave").addClass('disabled');  
         }
         else if(phonenumber.length == 10){  
            $("#datasave").removeClass('disabled');
         }
         else{
            $("#datasave").removeClass('disabled');
         }
        }
        else{
            $("#Your_Number").prop('required',true);
            $("#datasave").removeClass('disabled');
        }
     }


</script>
