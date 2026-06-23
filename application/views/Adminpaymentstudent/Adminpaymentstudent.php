<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://malsup.github.io/jquery.blockUI.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" /> 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>



</head>
<style>
    .disabledbutton {
        pointer-events: none;
        opacity: 0.4;
    }
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

        #ui-id-1{
            width: 315.391px!important;
            left: 38em!important;
            top: 196px!important;
        }       

    .medium {
        width: 450px !important;
    }

    #footer {
        display: none !important;
    }
</style>
<?php
?>
<section class="content-header">
    <h1>
        <?php echo __('Admin Payment'); ?>
    </h1>
    <?php if ($this->controller->isLoged()) { ?>
        <ol class="breadcrumb">
            <li><a href="<?php echo INSTALL_URL; ?>"><i class="fa fa-dashboard"></i>
                    <?php echo __('home'); ?>
                </a></li>
            <li><a href="<?php echo INSTALL_URL; ?>Adminpayment/index">Admin Payment</a></li>
            <li class="active">
                <?php echo __('Admin Payment'); ?>
            </li>
        </ol>
    <?php } ?>
</section>
<?php
require_once VIEWS_PATH . 'Layouts/admin/error_notice.php';
$tpl['option_arr_values'] = array_merge(
    ['currency' => ''],
    is_array($tpl['option_arr_values'] ?? null) ? $tpl['option_arr_values'] : []
);

?>
<!-- <table class="table">
    <tr class="tr">
        <td class="td">Payment For</td>
        <td class="td">
            <select name="Paymentfor" id="paymentfor" class="form-control input-sm" onchange="checkpayfor(this)">
                <option value="">Payment For</option>
                <option value="member">Member</option>
                <option value="donation">Donations</option>
                 <option value="student">Student</option>
                <option value="event">Event</option>
                <option value="ticket">Ticket</option>
            </select>
        </td>
    </tr>
</table> -->

<!-- Student div end -->
<div id="studentdiv">
<form id="new_student" class="frm-class user-frm-class" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <table class="table">
                    <tr class="tr">
                        <td class="td">
                           Registration Type
                        </td>
                        <td class="td">
                            <select  required="" name="Registration_type" id="registrationtype"
                                class="form-control input-sm" aria-required="true" >
                                <option value="">Please select Registration type</option>
                                <option value="BanglaSchool">Bangla School</option>
                                <option value="Kalabhavan">Kalabhavan</option>
                                 <option value="workshops">Workshops</option>
                                <option value="library">Library</option>

                            </select>
                        </td>
                        <td class="td" >Durga Bari Member</td>
                        <td class="td"><select required="" name="regmember" id="registrationmember"
                                class="form-control input-sm" aria-required="true" aria-invalid="false"  >
                           <option value="">Please select Member type</option>
                                <option value="member">Yes</option>
                                <option value="nonmember">No</option>
                                 </select>
                                </td>
                    </tr>
                    <tr class="tr">
                    
                    <td class="td" id="namemeemberregister">Member Name</td>
                    
                    <td  id="IDMembertd"  class="disabledbutton">
                    <input type="text" name="Member_id" id="term" placeholder="search member here...." class="form-control">
                   
                    
                    </td>
                    <td class="td" id="nonmembername" style="display:none;">Full Name</td>
                    <td  id="fieldtest" style="display:none;"> 
                     <input id="namenonmember" class="form-control" type="text" name="namenonmember" placeholder="Full Name" >
                    </td>
                    <input type="text" style="display:none" name="termMember" id="termMember" placeholder="search member here...." class="form-control">  
                   
                <td class="td">Member Id</td>
                <td class="td"><input type="text" name='demmember' id="demmember" class="form-control input-sm" aria-required="true" readonly >
                </select>
                </td> </tr>

                    <tr class="tr">
                    <td class="td">E-mail</td>
                        <td class="td"> <input required="" id="Your_E-mail" class="form-control input-sm" type="email"
                                pattern="[^@\s]+@[^@\s]+\.[^@\s]+" name="email" size="25" value=""
                                placeholder="name@company.com"></td>
                        <td class="td">Phone Number</td>
                        <td class="td"> <input required="" placeholder="### ###-####" id="Your_Number" maxlength = "10" class="form-control input-sm" type="nubmer" name="phone_number" onchange="checkphoneno(this.id)"> </td>
                                
                    </tr>
                    <tr class="tr" >

                        <td class="td">Student 1 Name</td>
                        <td class="td"><input required="" id="FirstStudentName" class="form-control input-sm" type="text"
                                placeholder="Student 1 Name" value="" name="St_Name1" tabindex="2" required></td>

                        <td class="td"> Student 2 Name</td>
                        <td class="td"><input id="SecondStudentName" class="form-control input-sm" type="text"
                                placeholder="Student 2 Name" value="" name="St_Name2" tabindex="3"></td>
                    </tr>
                    <div id="allsubject">
                    <tr class="tr" id="subjectrow">
                        <td class="td">Student 1 Subject</td>
                        <td class="td">
                        <select required="" name='subject[]' id='typecheck'   class="form-control input-sm"
                                aria-required="true" aria-invalid="false" multiple  >
                            </select>
                        </td>
                       
                        <td class="td">Student 2 Subject</td>

                        <td class="td"> 
                            <select name="type[]" id="type1"
                                class="form-control input-sm" required="" aria-invalid="false" multiple disabled>
                            </select>
                        
                        </td>
                    </tr>
    </div>
     <tr class="tr"><td class="td" colspan = 3 style="color:red; text-align: center;">Max. 2 subjects for Kala Bhavan; $10 off for 2 subjects; <b>Use Ctrl to select 2nd subject</b></td>
     <td class="td">
     <input readonly class="form-control input-sm" type="text" placeholder="Category" id="cattype" name="cat" value="" /></tr>
    
                    <tr class="tr">
                    <td class="td">Fee &nbsp;&nbsp; <span style="color:red; font-size: 12px;">(Members get $25 off per subject)</span></td>
                    <td class="td"><select required="" name='fee' id='fee' class="form-control input-sm" aria-required="true" aria-invalid="false" >
                    <td class="td">Total Amount</td>
                  
                 <td class="td">
                    <div class="form-group" style="margin-top: 6px!important;margin-bottom: 2px;">
                    <div class="input-group">
                    <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
                    <input readonly required=""  id="Amount" class="form-control input-sm" type="number" placeholder="$Amount" value="" name="totalamount" tabindex="10" >
                    </div>
                    </div>
                    </td>
        </tr>
        <tr class="tr">
                    <td class="td" colspan="2">Payment Method</span></td>
                    <td class="td" colspan="2">
                        <select name="payment_method" id="cashcheck_method" class="form-control input-sm"
                            onchange="paymethod(this.id)" required>
                            <option value="">Please Select</option>
                            <option value="check">Check</option>
                            <option value="cash">Cash</option>
                            <option value="directdeposit">Direct Deposit</option>
                        </select>
                    </td>
                </tr>
                <!-- payment dropdown start -->

                <table class="table table-bordered table-hover table-striped" style="display:none" id="checkdata">
                    <thead>
                        <tr class="tr">
                            <th>Bank Name</th>
                            <th>Check No</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tr">
                            <td class="td"><input style="WIDTH: 100%;" type="text" id="checkbankname"
                                    name="checkbankname" class="form-control input-sm" value=""></td>
                            <td class="td"><input style="WIDTH: 100%;" type="text" id="checkno" name="checkno"
                                    class="form-control input-sm" value=""></td>

                            <td class="td">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                                        </span>
                                        <input style="WIDTH: 100%;" type="number" id="checkamount" name="checkAmount"
                                            class="form-control input-sm" value="">
                            </td>
</div>
</div>
<td class="td"><input style="WIDTH: 100%;" type="date" id="checkdate" name="CheckDate" class="form-control input-sm"
        value=""></td>
</tr>
</tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="cashdata">
    <thead>
        <tr class="tr">
            <th>Receive By</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="receiveby" name="ReceiveBy"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="cashamount" name="cashAmount"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>
            <td class="td"><input style="WIDTH: 100%;" type="date" id="cashdate" name="cashDate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered table-hover table-striped" style="display:none" id="directdeposite">
    <thead>
        <tr class="tr">
            <th>Bank Name</th>
            <th>Transaction Code</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr class="tr">
            <td class="td"><input style="WIDTH: 100%;" type="text" id="bankname" name="directbank"
                    class="form-control input-sm" value=""></td>
            <td class="td"><input style="WIDTH: 100%;" type="text" id="ISFCCode" name="transactioncode"
                    class="form-control input-sm" value=""></td>

            <td class="td">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?>
                        </span>
                        <input style="WIDTH: 100%;" type="number" id="directamount" name="directdepositAmount"
                            class="form-control input-sm" value="">
                    </div>
                </div>
            </td>

            <td class="td"><input style="WIDTH: 100%;" type="date" id="date" name="transactiondate"
                    class="form-control input-sm" value=""></td>
        </tr>
    </tbody>
</table>
<!-- payment dropdown end --> 
        <tr style="display:none;"> <td class="td"> <input id="Your_Name" class="form-control input-sm" type="text" name="membername" style="display:none;"> </td></tr>
        <tr style="display:none;"> <td class="td"> <input id="Zellecode" class="form-control input-sm" type="text" name="code" style="display:none;"></td></tr>
                    <tr>
                        <td>
                            <fieldset>
                                <input type="hidden" name="create_Student" value="1" />
                                 <input type="hidden" id="cattype" name="cat" value="" />
                                <button id="reset-btn-id" class="btn btn-primary" autocomplete="off" value="Reset"
                                    name="reset-btn" tabindex="9" type="submit"><i
                                        class="fa fa-refresh"></i>&nbsp;&nbsp;Reset</button>
                                <button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save"
                                    name="pay" tabindex="9" type="submit"><i
                                        class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Save</button>
                            </fieldset>
                        </td>
                    </tr>
                </table>
            </form>

</div>
<!-- Student div end -->



<script>
 document.getElementById("typecheck").addEventListener('keydown', function (e) {
        if(event.shiftKey){
    alert("Use Ctrl to select 2nd subject");
        return false;
    }
    else if (event.ctrlKey && event.shiftKey && event.keyCode==73){        
             return false;
    }
})
document.getElementById("type1").addEventListener('keydown', function (e) {
        if(event.shiftKey){
    alert("Use Ctrl to select 2nd subject");
        return false;
    }
    else if (event.ctrlKey && event.shiftKey && event.keyCode==73){        
             return false;
    }
})



function paymethod(elem) {
        debugger
        var con = $("#cashcheck_method").val();
         if (con == "check" ) {
            $("#checkdata").show();
            $("#cashdata").hide();
            $("#directdeposite").hide();

            $("#receiveby").prop('required',false); 
            $("#cashamount").prop('required',false); 
            $("#cashdate").prop('required',false); 

            $("#bankname").prop('required',false); 
            $("#ISFCCode").prop('required',false); 
            $("#directamount").prop('required',false); 
            $("#directdepositdate").prop('required',false); 

            $("#checkbankname").prop('required',true); 
            $("#checkno").prop('required',true); 
            $("#checkamount").prop('required',true); 
            $("#checkdate").prop('required',true); 

        } else if (con == "cash") {
            $("#cashdata").show();
            $("#checkdata").hide();
            $("#directdeposite").hide();

            $("#checkbankname").prop('required',false); 
            $("#checkno").prop('required',false); 
            $("#checkamount").prop('required',false); 
            $("#checkdate").prop('required',false); 

            $("#bankname").prop('required',false); 
            $("#ISFCCode").prop('required',false); 
            $("#directamount").prop('required',false); 
            $("#directdepositdate").prop('required',false); 

            $("#receiveby").prop('required',true); 
            $("#cashamount").prop('required',true); 
            $("#cashdate").prop('required',true); 


        } else if (con == "directdeposit") {
            $("#directdeposite").show();
            $("#cashdata").hide();
            $("#checkdata").hide();

            $("#checkbankname").prop('required',false); 
            $("#checkno").prop('required',false); 
            $("#checkamount").prop('required',false); 
            $("#checkdate").prop('required',false);

            $("#receiveby").prop('required',false); 
            $("#cashamount").prop('required',false); 
            $("#cashdate").prop('required',false); 

            $("#bankname").prop('required',true); 
            $("#ISFCCode").prop('required',true); 
            $("#directamount").prop('required',true); 
            $("#directdepositdate").prop('required',true); 

        }
        else {
            $("#cashdata").hide();
            $("#checkdata").hide();
            $("#directdeposite").hide();
        }


    }
    
       $(function(){
    $('input[type="text"]').change(function(){
        this.value = $.trim(this.value);
    });
});

    $(function() {
    $("#term").autocomplete({
        //source: "http://localhost/HDBS_Payment/PriestMember/ajax-db-search.php",
        source: '<?= INSTALL_URL ?>ajax-db-search.php',
        select: function( event, ui ) {
            event.preventDefault();
           // $("#term").val(ui.item.value);
            //$("#termMember").val(ui.item.id);
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            document.getElementById("type1").value = "";
            document.getElementById("typecheck").value = "";
		    document.getElementById("FirstStudentName").value = "";
		   document.getElementById("SecondStudentName").value = "";
		   document.getElementById("Amount").value = "";
            MemberSelectStudent();
        }
  });
});
function MemberSelectStudent() {
            debugger
            var self = this;
            var term = $("#termMember").val();
            var data = $("#termMember").val();
			var url2 = $("#container-abc-url-id").text(); 
            const Memberid = data.split("-");
            //var url = gz$("#container-abc-url-id").text(); 
            if (term.trim() != "") {
                $.ajax({
                    type: "POST",
                    data: {
                        memberid: data
                    },
                    //url: self.options.server  +"load.php?controller=Donations&action=AllMember&cid=" + self.options.cal_id,
                     url: url2 + "load.php?controller=Donations&action=AllMemberNew",
                    success: function (res) {
                        //debugger;
                        //var Membertext = $("#MemberSelectValue").text();
                        //document.getElementById("MemberSelect").value = Membertext;
                        let MemberName = "";
                        const memberNameElement = $(res).filter("input#MemberName");
                        if (memberNameElement.length) {
                            MemberName = memberNameElement[0].value;
                        }

                        let LastName = "";
                        const LastNameElement = $(res).filter("input#last_name");
                        if (LastNameElement.length) {
                            LastName = LastNameElement[0].value;
                        }
                        document.getElementById("Your_Name").value = MemberName.concat(" ", LastName);
                        //    document.getElementById("second_name").value = LastName;



                        let memberid = "";
                        const memberElement = $(res).filter("input#memberid");
                        if (memberElement.length) {
                            memberid = memberElement[0].value;
                        }
                        document.getElementById("demmember").value = memberid;


                        let phoneNo = "";
                        let MNo = "";
                        const phoneNoElement = $(res).filter("input#Tele1");
                        if (phoneNoElement.length) {
                            phoneNo = phoneNoElement[0].value;
                            phoneNo = phoneNo.replace("-", "");
                            MNo = phoneNo;
                            MNo = MNo.replace("-", "");
                        }
                        document.getElementById("Your_Number").value = MNo;

                        let email = "";
                        const emailElement = $(res).filter("input#email");
                        if (emailElement.length) {
                            email = emailElement[0].value;
                        }
                        document.getElementById("Your_E-mail").value = email;
                        
                        
                        let cat1 = "";
                        const catElement = $(res).filter("input#membercategory");
                        if (catElement.length) {
                            cat1 = catElement[0].value;
                        }
                           // var cat = $("#cat").val(cat1);
                        document.getElementById("cattype").value = cat1;
                    }
                });
            } else {
                $("#MemberName").val("");
                $("#phone").val("");
                $("#Your_E-mail").val("");

            }
        }


    function memberhceck() {
        debugger;
        var regmember = $("#registrationmember").val();
        selectVal = $('#registrationmember').val();
        if (selectVal == "member") {
            $("#IDMembertd").removeClass("disabledbutton");
            document.getElementById("spousename").value = "";
            document.getElementById("Street").value = "";
            document.getElementById("ressidentalAddress").value = "";
            document.getElementById("city").value = "";
            document.getElementById("state").value = "";
            document.getElementById("zip_code").value = "";
            document.getElementById("email").value = "";
            document.getElementById("phone").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("MembCategory").value = "";
            document.getElementById("term").value = "";
            document.getElementById("demmember").value = "";
            $('#nonmembername').hide();
            $('#fieldtest').hide();
            $('#namemeemberregister').show();
            $('#IDMembertd').show();
            $("#namenonmember").prop('required', false);
            $("#term").prop('required', true);

        }
        if (selectVal == "nonmember") {
            $("#IDMembertd").addClass("disabledbutton");
            document.getElementById("spousename").value = "";
            document.getElementById("Street").value = "";
            document.getElementById("ressidentalAddress").value = "";
            document.getElementById("city").value = "";
            document.getElementById("state").value = "";
            document.getElementById("zip_code").value = "";
            document.getElementById("email").value = "";
            document.getElementById("phone").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("MembCategory").value = "";
            document.getElementById("term").value = "";
            document.getElementById("demmember").value = "";
            $('#namemeemberregister').hide();
            $('#IDMembertd').hide();
            $('#nonmembername').show();
            $('#fieldtest').show();
            $("#fieldtest").prop('readonly', true);
            $("#namenonmember").prop('required', true);
            $("#term").prop('required', false);

        }
        if (selectVal == "" || selectVal == " ") {
            document.getElementById("demmember").value = "";
            document.getElementById("spousename").value = "";
            document.getElementById("Street").value = "";
            document.getElementById("ressidentalAddress").value = "";
            document.getElementById("city").value = "";
            document.getElementById("state").value = "";
            document.getElementById("zip_code").value = "";
            document.getElementById("email").value = "";
            document.getElementById("phone").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("MembCategory").value = "";
            document.getElementById("term").value = "";
            $("#IDMembertd").removeClass("disabledbutton");
        }

    }  
    
    function checkphoneno(elem){
        //debugger;
    const phonenumber =  $("#Your_Number").val();
        if(!!phonenumber){
         if(isNaN(phonenumber)){  
            alert("Please Enter mobile Number");
            $("#payment_btn_id").addClass('disabled');
            //document.getElementById("totalamount").value = price; 
         }
         else if(phonenumber.length > 10 ){
              alert("Number should be 10 digits");
              $("#payment_btn_id").addClass('disabled');  
         }
         else if(phonenumber.length < 10){
            alert("Number should be 10 digits");
            $("#payment_btn_id").addClass('disabled');  
         }
         else if(phonenumber.length == 10){  
            $("#payment_btn_id").removeClass('disabled');
         }
         else{
            $("#payment_btn_id").removeClass('disabled');
         }
        }
        else{
            $("#Your_Number").prop('required',true);
            $("#payment_btn_id").removeClass('disabled');
        }
     }  
</script>
