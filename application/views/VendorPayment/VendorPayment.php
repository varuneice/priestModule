<head>
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"  crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 
</head>
<style>
    .body{
        padding:0px;
        margin:0px;
    }
    .logo .profile {
        margin-left: 50%;
        border-radius: 25%;
        transform: translate(-50%);
        filter: brightness(123%);
        padding: 10px;

    } 
    .logo .logo-caption {
        font-family: 'Poiret One', cursive;
        color: #FFFFFF;
        text-align: center;

    }
    .logo-caption .h1 {
        font-size:2.5rem;;
    }
    h3{

        /* font-size:30px; */
        color: #FFFFFF;
        font-weight: 400;
        margin-left:4%;
        font-family: initial;
        line-height: normal;
    }
    h4{
    text-align: center;
    color: #FFFFFF;
    font-family: initial;
}
    .logo .tweak {
        color: #ff5252;
        font-weight: bold;
    }
    .abd{
        font-weight: bold;
        font-family: 'Poiret One', cursive;
        font-size:20px;
        color:00000;
    }
    .btn-custom {
        background: #ff5252;
        border-color: rgba(48, 46, 45, 1);
        color: #ffffff;
        font-weight: bold;
        font-size:20px;
        width: -webkit-fill-available;
    }
    .btn-custom:hover{
        -webkit-transition: all 500ms ease;
        -moz-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
        transition: all 500ms ease;
        background: rgba(48, 46, 45, 1);
        border-color: #ff5252;
    }
    .footer {
        padding-top: 10px;
        margin-left: 15%;
        width: 85%;
        background: #111111;
        position: relative;
        bottom: 0;
        z-index: 1;
    }
    .form-group label {
        display: inline-block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-control {
        background-color: #f9fcfa;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgb(0 0 0 / 8%) inset;
        color: #555;
        display: block;
        font-size: 14px;
        height: 34px;
        line-height: 1.42857;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        width: 100%;
    }
    .form-horizontal .form-group {
        margin: 10px;
    }
    .asb {
        border-width: 0;
        border: 0 none;
        margin: 0;
        padding: 0;
    }
    .text-center{
        text-align:center;
    }
    .btn.btn-primary {
        background-color: #00a5c5;
        border-color: #367fa9;
        color: #fff;
        font-size: 20px;
    }
@media screen and (max-width: 992px) {
    #menu-container{
        width: 90% !important;
    }
}
.disabledbutton {
    pointer-events: none;
    opacity: 0.4;
}
.black_overlay {
  display: none;
  position: absolute;
  top: 0%;
  left: 0%;
  width: 100%;
  height: 100%;
  /* background-color: black; */
  z-index: 1001;
  -moz-opacity: 0.8;
  opacity: .80;
  filter: alpha(opacity=80);
}
.white_content {
  display: none;
  position: absolute;
  top: 34%;
  left: 19%;
  width: 68%;
  height: 25%;
  padding: 16px;
  /* border: 16px solid orange; */
  background-color: white;
  z-index: 1002;
  overflow: auto;
}


</style>
<?php
   // $today = date("Y");
   // $heading1 = "HDBS Puja";
   //$heading2 = "- Commercial Application Form";
    //$fullheading = $heading1 ." ". $today ." ". $heading2;
    $fullheading =  $tpl['dataarr'][0]['datavendor'];
    ?>

    <div id="menu-container" style="width:54%; margin:3px auto;  background-color:rgba(237,237,237) !important;">
        <div id="page-body">
            <main role="main">
                <div class="logo" style="background-color: #357ca5;">
                    <img src="../logo.jpg" class="profile"/>
                    <h3><b>Houston Durga Bari Society</b></h3>
                      <h4><b>Contact: vendor@durgabari.org<br> advertisement@durgabari.org </b></h4>
                      <h1 class="logo-caption"><?php echo $fullheading ?></h1>
                      <!-- <h1 class="logo-caption"><span class="tweak">H</span>DBS <span class="tweak">P</span>uja <span class="tweak">C</span>ommercial <span class="tweak">A</span>pplication <span class="tweak">F</span>orm</h1> -->
                </div> 
                <!-- logo class -->
                <form id="donation-frm-id" class="form-horizontal" method="post" action="" role="form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    <input type="hidden" name="create_vendorpayment" value="1" />
                    <fieldset class="asb">
<table class="table">
<tr class="tr">
<td class="td" colspan="2">Payment For<span style="color:#ff0000">*</span></td>
<td class="td" colspan="2">
    
<!-- <select name="paymentfor" id="paymentForboothrental" class="form-control input-sm" required="" onchange="payfor(this.id)">
                                            <option value="">Please Select</option>
                                            <option value="BOOTH">Booth Rentals</option>
									        <option value="MAGADV">Magazine Advertisements</option>
                                            <option value="OTHADV">Other Advertisements</option>
                                        </select> -->
                                        <select name="paymentfor" id="paymentForboothrental" class="form-control input-sm" required="" onchange="payfor(this.id)">
                        <option value="">---</option>
                         <?php
                         foreach (($tpl['vendorpayforarr'] ?? []) as $key => $value) {
                             ?>
                            
                                    <option value="<?php echo $value['payforalice']; ?>"><?php echo $value['payfor']; ?></option> 
                                    <?php
                         }
                         ?>
        </select>
                                    
                                    </td>

</tr>
<tr class="tr">
<td class="td" colspan="2"> <select required="" name='type' id='payfortype'   class="form-control input-sm"
                                aria-required="true" aria-invalid="false"  onchange="paytypebooth(this)">
                            </select>
                        </td>
<td class="td">Amount<span style="color:#ff0000">*</span></td> 
<td class="td"><div class="form-group">
<div class="input-group">
 <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
 <input required="" id="total" class="form-control input-sm" type="text" placeholder="$Amount" value="" name="amount" tabindex="16" >
  </div>
 </div></td> 

</tr>

<!-- <tr class="tr">
    <td class="td" >Durga Bari Member</td>
                        <td class="td"><select required="" name="regmember" id="registrationmember"
                                class="form-control input-sm" aria-required="true" aria-invalid="false" >
                         <option value="">Please select Member type</option> 
                                <option value="member">Yes</option>
                                <option value="nonmember">No</option>
                                 </select>
                                </td>

                 <td class="td" id="namemeemberregister">Member Name<span style="color:#ff0000">*</span></td>
                    <td  id="IDMembertd"  class="disabledbutton" style="border: 1px;">                        
                       
                        <input type="text" name="term" id="term" placeholder="search member here...."  class="form-control" tabindex="2">
                      </td>
                      <td class="td" id="nonmembername" style="display:none;">Full Name</td>
                        <td id="fieldtest" style="border: 1px; display: table-cell;display:none;"> 
                         <input id="namenonmember" class="form-control" type="text" name="namenonmember" placeholder="Full Name" >
                      </td>
                    <input type="text" style="display:none" name="termMember" id="termMember"  placeholder="search member here...." class="form-control">
                 </tr>  -->
            
    
    <!-- <tr class="tr">
                    
                   
                   
                     <td class="td">Member Id</td>
                     <td class="td"><input type="text" name='demmember' id="demmember" class="form-control input-sm" aria-required="true" readonly tabindex="3" >
                     <td class="td" id="fullname">Name<span style="color:#ff0000">*</span></td>
                     <td class="td">
                     <input id="fullname" class="form-control" type="text" name="MemberName" placeholder="Full Name" required >   
                    </td> 
                    
                    <td class="td">Spouse Name</td>
                    <td class="td"><input  id="spousename" class="form-control input-sm" type="text" placeholder="Spouse Name" value="" name="spousename" tabindex="4"  ></td>
                       
             </tr>  -->
  <tr class="tr">
<td class="td">Owner Name<span style="color:#ff0000">*</span></span></td>
<td class="td">  
 <input id="ownername" class="form-control input-sm" type="text" placeholder="Name of Owner"  value="" name="ownername"  required=""> 
</td>
 <td class="td">Business Name<span style="color:#ff0000">*</span></td>
<td class="td"> <input id="businessname" class="form-control input-sm" type="text" placeholder="Name of Business" value="" name="businessname" required=""></td>
 </tr>

<tr class="tr">

<td class="td">Quantity<span style="color:#ff0000">*</span></td>
<td class="td"> 
<input  id="quantity" class="form-control input-sm" type="number" placeholder="Quantity" value="" name="Quantity"  required  onchange="finalpricecal(this.id)" ></td>
</td>
<!-- <td class="td"> Street No<span style="color:#ff0000">*</span></td>
<td class="td"> <input  id="Street" class="form-control input-sm" type="text" placeholder="Street No" value="" name="Street"  required></td> -->

<td class="td">Address<span style="color:#ff0000">*</span></td> 
<td class="td"> <input  id="ressidentalAddress" class="form-control input-sm" type="text" placeholder="Address" value="" name="address"  required></td>
</tr>

<tr class="tr">
<td class="td">City<span style="color:#ff0000">*</span></td>
<td class="td">  <input  id="city" class="form-control input-sm" type="text" name="city" size="25" value="" title="City" placeholder="City"  required></td>

<td class="td"> State<span style="color:#ff0000">*</span></td>
<td class="td"><select required id="state" name="state" value="" class="form-control input-sm">
                                        <option value="">Please select State</option>
                                        <option value="AL">Alabama</option>
                                        <option value="AK">Alaska</option>
                                        <option value="AZ">Arizona</option>
                                        <option value="AR">Arkansas</option>
                                        <option value="CA">California</option>
                                        <option value="CO">Colorado</option>
                                        <option value="CT">Connecticut</option>
                                        <option value="DE">Delaware</option>
                                        <option value="DC">District of Columbia</option>
                                        <option value="FL">Florida</option>
                                        <option value="GA">Georgia</option>
                                        <option value="HI">Hawaii</option>
                                        <option value="ID">Idaho</option>
                                        <option value="IL">Illinois</option>
                                        <option value="IN">Indiana</option>
                                        <option value="IA">Iowa</option>
                                        <option value="KS">Kansas</option>
                                        <option value="KY">Kentucky</option>
                                        <option value="LA">Louisiana</option>
                                        <option value="ME">Maine</option>
                                        <option value="MD">Maryland</option>
                                        <option value="MA">Massachusetts</option>
                                        <option value="MI">Michigan</option>
                                        <option value="MN">Minnesota</option>
                                        <option value="MS">Mississippi</option>
                                        <option value="MO">Missouri</option>
                                        <option value="MT">Montana</option>
                                        <option value="NE">Nebraska</option>
                                        <option value="NV">Nevada</option>
                                        <option value="NH">New Hampshire</option>
                                        <option value="NJ">New Jersey</option>
                                        <option value="NM">New Mexico</option>
                                        <option value="NY">New York</option>
                                        <option value="NC">North Carolina</option>
                                        <option value="ND">North Dakota</option>
                                        <option value="OH">Ohio</option>
                                        <option value="OK">Oklahoma</option>
                                        <option value="OR">Oregon</option>
                                        <option value="PA">Pennsylvania</option>
                                        <option value="RI">Rhode Island</option>
                                        <option value="SC">South Carolina</option>
                                        <option value="SD">South Dakota</option>
                                        <option value="TN">Tennessee</option>
                                        <option value="TX">Texas</option>
                                        <option value="UT">Utah</option>
                                        <option value="VT">Vermont</option>
                                        <option value="VA">Virginia</option>
                                        <option value="WA">Washington</option>
                                        <option value="WV">West Virginia</option>
                                        <option value="WI">Wisconsin</option>
                                        <option value="WY">Wyoming</option>
                                    </select>
                                </td>
</tr>

<tr class="tr">
<td class="td">Zip<span style="color:#ff0000">*</span></td>
<td class="td"> <input id="zip_code" class="form-control input-sm" type="text" placeholder="Zip Code" value="" name="zip"  required></td>
<td class="td"> Phone Number<span style="color:#ff0000">*</span></td>
<td class="td">  
 <input id="phone" class="form-control input-sm" type="text" required="" placeholder="### ###-####" value="" name="phone"  onchange="checkmobileno(this.id)" maxlength="10" > 
</td>
 </tr>

<tr class="tr">
<td class="td">Email<span style="color:#ff0000">*</span></td>
<td class="td"><input required="" id="email" class="form-control input-sm" type="email" placeholder="name@company.com" value="" name="email"  ></td>

<td class="td">Tax ID<span style="color:#ff0000">*</span></td>
<td class="td">  
 <input id="taxiD" class="form-control input-sm" type="text" placeholder="Business Tax ID"  value="" name="taxid" required="" > 
</td>
</tr>
<tr class="tr">
<td class="td" >TotalAmount<span style="color:#ff0000">*</span></td>

<td class="td">
<div class="form-group">
<div class="input-group">
 <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
 <input required="" id="totalamount" class="form-control input-sm" type="text" placeholder="$TotalAmount" value="" name="TotalAmount"  readonly>
  </div>
 </div>
 </td>
<tr class="tr">
<td class="td" colspan="4">
<a href="javascript:void(0)" onclick="document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><input required="true" type="checkbox" id="terms" name="terms" value="terms"> </a> 
Accept with terms and conditions
<div id="light" class="white_content"><p style="color:black"><b>Terms and conditions</b> <a href="javascript:void(0)" onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" class="close" style="font-size: 14px; transform: translateY(-13px);"><br><b>X</b></a></p> <hr>
 Click<a href="https://durgabari.net/invoice/HDBS%20Puja%20%20T-C_2022.pdf" target="_blank">here</a>for Booth Rental terms & conditions<br>
Click <a href="https://durgabari.net/invoice/HDBS%20Puja%20Advertisement%20T-C_2022.pdf" target="_blank">here</a> for Advertisement terms & conditions.  

  </div>
  <div id="fade" class="black_overlay"></div>
</td>
</tr>
<input id="paydescription" class="form-control input-sm" type="text"
                            name="paydesc" style="display:none;"> 
<tr class="tr"> 
<td class="td" colspan="4">
<input required="true" type="checkbox" id="terms" name="terms" value="terms"> I agree to Not hold HDBS liable for any loss due to damage, theft, fire, vandalism or act of nature.
</td>
</tr>    

<!-- <tr style="display:none;"> <td class="td"> <input id="Your_Name" class="form-control input-sm" type="test" name="MemberName"> </td></tr> -->
           
    <tr class="tr">
        <td ><button id="reset-btn-id" class="btn btn-primary" autocomplete="off" value="Save" name="Reset" tabindex="16" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Reset</button></td>
        <td ><button id="payment_btn_id" class="btn btn-primary" autocomplete="off" value="Save" name="Payment" tabindex="17" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Submit</button></td>
    </tr>
 
</table>


                       
    
<?php  ?>

<script type="text/javascript">
$(window).bind("pageshow", function() {
       var form = $('form'); 
       form[0].reset();
     });

      const phoneInputField = document.querySelector("#phone");
      const phoneInput = window.intlTelInput(phoneInputField, {
        // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
        preferredCountries: ["us", "co", "in", "de"],
        utilsScript:
          "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
      });
      
      
function payfor(){
    //debugger
    var paymentfor = $("#paymentForboothrental").val();
    document.getElementById("totalamount").value = "";
        document.getElementById("quantity").value = "";
		document.getElementById("total").value = "";
        document.getElementById("paydescription").value = "";
    $.ajax({
            type: "POST",
            data: {
                paymentfor: paymentfor,
               
            },
            url: "<?= INSTALL_URL ?>load.php?controller=VendorPayment&action=paymentfor",
           //url: "http://localhost/HDBS_Payment/PriestMember/load.php?controller=VendorPayment&action=paymentfor",
            success: function (res) {
                
                $('#payfortype').empty(); //remove all child nodes
                var payfortypenewOption = $(res);
                var newOption = $('<option value="">Please select pay type</option>');
                $('#payfortype').append(newOption);
                $('#payfortype').append(payfortypenewOption);
                $('#payfortype').trigger("chosen:updated");
                
            }
        });

    
    }


// Checkphoneno

function checkmobileno(elem){
        debugger;
    const phonenumber =  $("#phone").val();
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
            $("#phone").prop('required',true);
            $("#payment_btn_id").removeClass('disabled');
        }
     }

     function paytypebooth() 
     {
        var durgapujabooth = $("#payfortype").val();
         document.getElementById("totalamount").value = "";
        document.getElementById("quantity").value = "";
		document.getElementById("total").value = durgapujabooth;

        var txtpayfor = $("#payfortype option:selected").text();
        document.getElementById("paydescription").value = txtpayfor;
	} 
	
	 function finalpricecal(){
	  var pujaquantity = $("#quantity").val();
	  var pujaprice = $("#total").val();
      if(pujaprice == "")
      {
        alert('Please select payment for and type first');
        document.getElementById("quantity").value = "";
      }
      else{
        var finalpayamount = pujaprice * pujaquantity
	    document.getElementById("totalamount").value = finalpayamount;
      }
	  
	}

</script>

