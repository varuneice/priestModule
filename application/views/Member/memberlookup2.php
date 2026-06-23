<head>
 
 
  <script src=
        "https://malsup.github.io/jquery.blockUI.js">
    </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" /> 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>
<style> 
body, html {
    color: #4e423a;
    margin: 0;
    padding: 0;
    /* overflow: hidden; */
}
.table{
    font-family: arial, sans-serif;
    width: 100%;
    border: 2px solid black;
    border-collapse: collapse;
    /* background-color: steelblue;
    color: white; */
}
        input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
.padding-19 {
    display: none;
}
.ui-icon-circle-triangle-w{
width:35px!important;
}
.ui-icon.ui-icon-circle-triangle-e{
width:35px!important;
margin-left: -29px!important;
font: bold;
}

h4 {
    text-align: center;
    font-family: initial;
}
/* #error_code1{
margin-left:10%!important;
margin-top:2%!important;
padding-top:12px!important;
display:block!important;
}


#error_codeimg{
margin-left:8%!important;
margin-top:2%!important;
} */
#payment-form > fieldset.asb > table:nth-child(12) > tbody > tr:nth-child(2) > td > div{display:none;}
#payment-form > fieldset.asb > table:nth-child(12) > tbody > tr:nth-child(3) > td > div{display:none;}
#payment-form > fieldset.asb > table:nth-child(12) > tbody > tr:nth-child(4) > td > div{display:none;}
#payment-form > fieldset.asb > table:nth-child(12) > tbody > tr:nth-child(5) > td > div{display:none;}
</style>
<div id="menu-container" style="width: 54%; margin:3px auto; background-color:rgba(237,237,237) !important;">
    <div id="page-body">
        <main role="main">
            <div class="logo" style="background-color: #357ca5;">
                 <img src="../logo.jpg" class="profile" /> 
                <h3><b>Houston Durga Bari Society</b></h4>
                    <h4><b>Contact: treasurer@durgabari.org </b></h4>
                    <h1 class="logo-caption"><span class="tweak">M</span>embership <span class="tweak">R</span>enewal and <span class="tweak">M</span>aintenance</h1>
            </div>
            <!-- logo class -->
            <form id="payment-form" class="form-horizontal" method="post" action="" role="form">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <input type="hidden" name="pay_usermaintenance" value="1"/>
                <fieldset class="asb" >  
                 
    <table class="table">
<tr class="tr">

 <td class="td">Member Name</td>
<td class="td">                         
<input type="text" name="Member_id" id="term" placeholder="search member here...." class="form-control">

<input type="text" style="display:none" name="termMember" id="termMember" placeholder="search member here...." class="form-control">  
 
</td>
<td class="td">Member Id</td>
<td class="td"><input type="text" name='demmember' id="demmember" class="form-control input-sm" aria-required="true" readonly >
                
</td>
</tr>
<tr class="tr">
<td class="td">Spouse Name</td>
<td class="td"><input  id="spousename" class="form-control input-sm" type="text" placeholder="Spouse Name" value="" name="spousename" tabindex="3" ></td>
<td class="td">	Membership Type</td>
<td class="td" id="indvidualradio" style="display:none;">
<input type="radio" id="individual_membershipradio" name="membership_type" value="IND"  />Individual Membership<br>
 </td> 
<td class="td" id="familyradio" style="display:none;">
<input type="radio" id="family_membershipradio" name="membership_type" value="FAM" />Family Membership
</td>
</tr>

<tr class="tr">
<td class="td"> Street No<span style="color:#ff0000">*</span></td>
<td class="td"> <input  id="Street" class="form-control input-sm" type="text" placeholder="Street No" value="" name="Address1" tabindex="5" required></td>
 <td class="td">Address<span style="color:#ff0000">*</span></td> 
<td class="td"> <input  id="ressidentalAddress" class="form-control input-sm" type="text" placeholder="Address" value="" name="Address2" tabindex="6" required></td>

</tr>

<tr class="tr">
<td class="td">City<span style="color:#ff0000">*</span></td>
<td class="td"><input  id="city" class="form-control input-sm" type="text" name="City" size="25" value="" title="City" placeholder="City" tabindex="7" required></td>
<td class="td"> State<span style="color:#ff0000">*</span></td>
<td class="td">
    <!-- <input required="" id="state" class="form-control input-sm" type="text" placeholder="State" value="" name="State" tabindex="8"> -->
    <select required id="state" class="form-control input-sm"  name="State" value="">       
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
<td class="td"> <input id="zip_code" class="form-control input-sm" type="text" placeholder="Zip Code" value="" name="Zip" tabindex="9" required></td>

<td class="td"> Phone Number<span style="color:#ff0000">*</span></td>
<td class="td">  
 <input id="phone" class="form-control input-sm" type="text" required="" value="" name="Tele1" placeholder="###) ###-####" onchange="sponsoramount(this.id)" maxlength="10" tabindex="9"> 
<!-- <input id="phone" name="phone" type="tel"> -->
</td>

</tr>
<tr class="tr">
<td class="td">Membership Category</td>
<td class="td">  
 <input id="MembCategory" class="form-control input-sm" type="text" placeholder="Membership Category"  value="" name="membercategory" tabindex="13" readonly> 
</td>
<td class="td">Email<span style="color:#ff0000">*</span></td>
<td class="td"><input required="" id="email" class="form-control input-sm" type="text" placeholder="name@company.com" value="" name="email" tabindex="14" pattern="[^@\s]+@[^@\s]+\.[^@\s]+"></td>
</tr>

<tr class="tr">
 <td class="td">Lifetime Contribution</td>
<td class="td"> <input id="ltd1" class="form-control input-sm" type="text" placeholder="Lifetime Contribution" value="" name="LTD" tabindex="11" readonly></td>

<td class="td">Annual Donation</td>
<td class="td">  
 <input id="ytd1" class="form-control input-sm" type="text" placeholder="Annual Donation"  value="" name="YTD" tabindex="12" readonly> 
</td>
</tr>
<tr style="display:none;">
<td class="td">  
 <input id="membershiptypehide" class="form-control input-sm" type="text"  value="" readonly> 
</td>
<td class="td"><input id="Your_Name" class="form-control input-sm" type="text" name="membername"> </td>
<td class="td"><input id="Your_id" class="form-control input-sm" type="text" name="idunique"> </td>
</tr>
<tr class="tr">
<td class="td" colspan="2"><input required="" id="amountlabel" class="form-control input-sm" type="text"  value="" name="amountlabel" tabindex="" readonly></td>

<td class="td" colspan="2" >
<div class="form-group">

<div class="input-group">
 <span class="input-group-addon"><?php echo Util::getCurrensySimbol($tpl['option_arr_values']['currency']); ?></span>
 <input required="" id="total" class="form-control input-sm" type="number" placeholder="$Amount" value="" name="total" tabindex="15" readonly>
  </div>
 </div>
 </td>

</tr>
<table class="table" id="paymentdrop">
                    <tr class="tr">
                        <td class="td" colspan="2">
                           Payment Method
                        </td>
                        <td class="td" colspan="2">
                            <select required="" name="Payment_method" id="Payment_method"
                                class="form-control input-sm" aria-required="true" aria-invalid="false"
                                style="width:100%;  height:50%;">
                                <option value="" class="amd">---</option>
                                <?php
                                $payment_method_arr = __('payment_method_arr');
                                foreach ($payment_method_arr as $k => $v) {
                                    if (($k == 'stripe' && $tpl['option_arr_values']['stripe_allow'] == '1') || ($k == 'others' && $tpl['option_arr_values']['others_allow'] == '1') || ($k == 'paypal' && $tpl['option_arr_values']['paypal_allow'] == '1') || ($k == 'authorize' && $tpl['option_arr_values']['authorize_allow'] == '1') || ($k == '2checkout' && $tpl['option_arr_values']['2checkout_allow'] == '1') || ($k == 'pay_arrival' && $tpl['option_arr_values']['pay_arrival_allow'] == '1') || ($k == 'credit_card' && $tpl['option_arr_values']['credit_card_allow'] == '1') || ($k == 'bank_acount' && $tpl['option_arr_values']['bank_acount_allow'] == '1')) {
                                        ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <table class="table">
                <tr id="stripe_details" class="tr" style="display: none;">
                        <td class="td" colspan="4">
                            <div class="form-group">
                                <label for="card-element">
                                    Credit or debit card
                                </label> 
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display Element errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>            
                        
                        </td>
                    </tr>
                    <tr id="others_details" style="display: none;">
                        <td class="td" colspan="4">
                            <div class="form-group">
                                <label class="control-label"
                                    for="confirm_code"><?php echo __('confirm_code'); ?>:</label>
                                <input data-rule-required='true' id="confirm_code" class="form-control input-sm"
                                    type="text" name="confirm_code"  value=""
                                    title="<?php echo __('confirm_code'); ?>"
                                    placeholder="<?php echo __('confirm_code'); ?>">
                                <div class="control-group"></div>
                                <div id="error_code"></div>
                            </div>
                        </td>
                    </tr>
                    <table class="table">
                    <tr class="tr"  id="MemberID1" style="display: none;" class="form-group">
                    <label class="control-label" for="F_Name" style="color:rgba(237,237,237) !important;">Payment Details:</label>
                    <!-- <td  class="td" colspan="2" class="auto-widget"> -->
                    <td class="td"><button style="display: none;float:left!important;" type="button" id="checkPaymentData" >Get Zelle Payment Details</button></td>
                    <!-- <input data-rule-required='true' id="MemberID" class="form-control input-sm" type="text" name="confirm_code" size="25" value="" title="<?php echo __('confirm_code'); ?>" placeholder="<?php echo __('confirm_code'); ?>"> -->
                    <td  class="td" colspan="3"><select data-rule-required='true' id="MemberID" name="oid"  class="form-control input-sm" style="font-weight: bold;float:right!important;">
                    <option value="">Please select your payment details</option>
                        <?php
                        foreach (($tpl['Amount'] ?? []) as $key => $value) {
                            ?>
                           
                            <option value="<?php echo $value['Amount']; ?>"><?php echo $value['Amount']; ?></option> 
                            <?php
                            //echo '<option value="'.$value['Amount'].'">'.$value['Amount']. '</option>';
                        }
                        ?>
                    </select>
                    </td>
                    <!-- </td> -->
                
                    </tr>
            </table>
         <table class="table">
                    <tr>
                <td id="error_code1"></td>
                <!-- <td id="error_code"></td> -->
                <td id="error_codeimg"></td>
                     </tr>
                    </table>
                            </table>
                            <tr style="display:none;"> <td class="td"> <input id="Your_Name" class="form-control input-sm" type="test" name="MemberName" style="display:none;"> </td></tr>
                             <tr style="display:none;"> <td class="td"> <input id="Zellecode" class="form-control input-sm" type="text" name="code" style="display:none;"></td></tr>
          <tr>
                <input type="hidden" name="pay_usermaintenance" value="1" />
                <input type="hidden" name="ID" value="<?php echo $tpl['arr']['ID'] ?? ''; ?>" />

        <td><button id="reset-btn-id" class="btn btn-primary" autocomplete="off" value="Save" name="Reset" tabindex="16" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Reset</button></td>
        <td><button id="member_btn_id" class="btn btn-primary" autocomplete="off" value="Pay" name="Pay" tabindex="17" type="submit"><i class="fa fa-fw fa-save"></i>&nbsp;&nbsp;Make Payment</button></td>
    </tr>
    <input type="hidden" name="stripeToken" id="stripeToken" value="" />
</table>
<div id="stripe_secret_key_id" style="display: none"><?php echo $tpl['option_arr_values']['stripe_publish_key'] ?? ''; ?></div>
</fieldset>
                    
                
                
            </form>
        </main>
    </div>
</div>

</div>
<script>
    $(function() {
        //debugger;
        var url1 = $("#container-abc-url-id").text();
    $("#term").autocomplete({
        //source: "http://localhost/HDBS_Payment/PriestMember/ajax-db-search.php",
       source: '<?= INSTALL_URL ?>ajax-db-search-lookup.php',
        select: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelect3();
        },
        onclick: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelect3();
        },
        onchange: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelect3();
        },
        //focus: function( event, ui ) {
        //    event.preventDefault();
         //   var name =  ui.item.value;
        //    var f_name = name.split(",");
         //   $("#term").val(f_name[0]);
         //   $("#termMember").val(ui.item.id);
           // MemberSelect3();
        //},
  });
});

///

function MemberSelect3() {

var self = this;
var root = <?php echo json_encode($root); ?>;
    
var data = $("#termMember").val();
const Memberid = data.split("-");

var url2 = $("#container-abc-url-id").text(); 
if (data != "") {
    $.ajax({
        type: "POST",
        data: {
            memberid: data
        },
        url: url2 + "load.php?controller=Donations&action=AllMemberNew",
        //url:"http://localhost/HDBS_Payment/PriestMember/load.php?controller=Donations&action=AllMember&cid",
        success: function (res) {
            debugger;
            //var Membertext = $("#MemberSelectValue").text();
            //document.getElementById("MemberSelect").value = Membertext;
            let MemberName = "";
            const memberNameElement = $(res).filter("input#MemberName");
            if (memberNameElement.length) {
                MemberName = memberNameElement[0].value;
            }
              //document.getElementById("second_name").value = MemberName;

              let LastName = "";
              const LastNameElement = $(res).filter("input#last_name");
              if (LastNameElement.length) {
                  LastName = LastNameElement[0].value;
              }
              document.getElementById("Your_Name").value = MemberName.concat(" ", LastName);

            let memberid = "";
            const memberElement = $(res).filter("input#memberid");
            if (memberElement.length) {
                memberid = memberElement[0].value;
            }
            document.getElementById("demmember").value = memberid;
            // if(memberid != ""){
            // document.getElementById("demmember").value = memberid;
            // var url ="<?= INSTALL_URL ?>Member/membermaintenance/" +memberid
            // window.location.assign(url);
            // }
        let spouseName = "";
        let spouseLastName = "";
        const spouseNameElement = $(res).filter("input#Spouse");
        const spouseLastNameElement = $(res).filter("input#Spouselast");
         if(spouseLastNameElement.length){
         spouseLastName = spouseLastNameElement[0].value; 
         }
         if(spouseNameElement.length){
         spouseName = spouseNameElement[0].value; 
         }
          document.getElementById("spousename").value = spouseName.concat(" ",spouseLastName);

          let street = "";
                const streetElement = $(res).filter("input#ressidentalAddress");
              if(streetElement.length){
               street = streetElement[0].value; 
               }
               document.getElementById("Street").value = street;

               let resaddress = "";
       const resaddressElement = $(res).filter("input#Address");
      if(resaddressElement.length){
        resaddress = resaddressElement[0].value; 
      }
      document.getElementById("ressidentalAddress").value = resaddress;

      let state = "";
      const stateElement = $(res).filter("input#state");
     if(stateElement.length){
       state = stateElement[0].value; 
     }
     document.getElementById("state").value = state;
     

     let city = "";
        const cityElement = $(res).filter("input#city");
       if(cityElement.length){
          city = cityElement[0].value; 
       }
       document.getElementById("city").value = city;

       let zipcode = "";
        const zipcodeElement = $(res).filter("input#zip_code");
       if(zipcodeElement.length){
        zipcode = zipcodeElement[0].value; 
       }
       document.getElementById("zip_code").value = zipcode;

       let phoneNo = "";
        const phoneNoElement = $(res).filter("input#Tele1");
       if(phoneNoElement.length){
          phoneNo = phoneNoElement[0].value; 
       }
       document.getElementById("phone").value = phoneNo;

       let email = "";
        const emailElement = $(res).filter("input#email");
       if(emailElement.length){
           email = emailElement[0].value; 
       }
       document.getElementById("email").value = email;
       
       let uniqueid = "";
       const uniqueidElement = $(res).filter("input#tableid");
      if(uniqueidElement.length){
          uniqueid = uniqueidElement[0].value; 
      }
      document.getElementById("Your_id").value = uniqueid;

     let ltd = "";
        const ltdElement = $(res).filter("input#ltd");
       if(ltdElement.length){
        ltd = ltdElement[0].value; 
       }
       document.getElementById("ltd1").value = ltd;

       let ytd = "";
       const ytdElement = $(res).filter("input#ytd");
      if(ytdElement.length){
        ytd = ytdElement[0].value; 
      }
      document.getElementById("ytd1").value = ytd;

      let dateupdate = "";
      const dateupdateElement = $(res).filter("input#updatedate");
     if(dateupdateElement.length){
      dateupdate = dateupdateElement[0].value; 
      var newupdate = dateupdate.split("-");
      var newupdatedate = newupdate[0];
           var finalupdatedate  = Number(newupdatedate);
     }

     
     
     let payfor = "";
      const payforElement = $(res).filter("input#payfor");
     if(payforElement.length){
      payfor = payforElement[0].value;
      let text = payfor;
      var result = text.includes("Maintenance"); 
     }

      let cat = "";
      const catElement = $(res).filter("input#membercategory");
     if(catElement.length){
       cat = catElement[0].value; 
     }
     document.getElementById("MembCategory").value = cat;
     
     let membertype = "";
     const membertypeElement = $(res).filter("input#membershiptype");
    if(membertypeElement.length){
        membertype = membertypeElement[0].value; 
    }
    document.getElementById("membershiptypehide").value = membertype;
    let current_date = new Date();
    let currentyeardate = current_date.getFullYear();
    const membercategorytype =  $("#membershiptypehide").val();
    const categ =  $("#MembCategory").val();
    //var currentdaydate = new Date();
      let currentdaydate = formatDate(new Date());
    
                //var g1 = '2023-04-1';
                let date =  new Date().getFullYear();
                let maintenancedatePrev= '31'+'/03/'+date;
    
     if(categ == 'GD' && membercategorytype == 'IND'){
        document.getElementById('familyradio').style.display = 'none';
         document.getElementById("amountlabel").value ="Membership Renewal"; 
        $('#individual_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
        document.getElementById('amountlabel').style.removeProperty('display');
		document.getElementById('total').style.removeProperty('display');
		document.getElementById('paymentdrop').style.removeProperty('display');
		document.getElementById('member_btn_id').style.removeProperty('display');
        document.getElementById('indvidualradio').style.removeProperty('display');
        document.getElementById("total").value = (currentdaydate < maintenancedatePrev) ? "150" : "165";
        
      }
     else if(categ == 'GD' && membercategorytype == 'FAM'){
        document.getElementById('indvidualradio').style.display = 'none';
        document.getElementById("amountlabel").value ="Membership Renewal"; 
        $('#family_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
        document.getElementById('amountlabel').style.removeProperty('display');
		document.getElementById('total').style.removeProperty('display');
		document.getElementById('paymentdrop').style.removeProperty('display');
		document.getElementById('member_btn_id').style.removeProperty('display');
        document.getElementById('familyradio').style.removeProperty('display');
        document.getElementById("total").value = (currentdaydate < maintenancedatePrev) ? "200" : "225";
        
      }
      
      else if((categ == 'LM' || categ == 'PM' || categ == 'BF' || categ == 'FM' || categ == 'FP') && (membercategorytype == 'IND')){
            document.getElementById('amountlabel').style.removeProperty('display');
                    document.getElementById('total').style.removeProperty('display');
        document.getElementById('familyradio').style.display = 'none';
        document.getElementById("amountlabel").value ="Annual Maintenance";
        document.getElementById("total").value = "120"; 
        $('#individual_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
        document.getElementById('indvidualradio').style.removeProperty('display');
        
       
        if((finalupdatedate < currentyeardate) || (finalupdatedate == "" || finalupdatedate ==" ")){
            document.getElementById('paymentdrop').style.removeProperty('display');
        document.getElementById('member_btn_id').style.removeProperty('display');
            
         }else{
            document.getElementById('paymentdrop').style.display = 'none';
            //document.getElementById('Payment_method').style.display = 'none';
            document.getElementById('member_btn_id').style.display = 'none';
            $("#total").val("");
        }
    }
      else if((categ == 'LM' || categ == 'PM' || categ == 'BF' || categ == 'FM' || categ == 'FP') && (membercategorytype == 'FAM')){
            document.getElementById('amountlabel').style.removeProperty('display');
                    document.getElementById('total').style.removeProperty('display');
        document.getElementById('indvidualradio').style.display = 'none';
        document.getElementById("amountlabel").value ="Annual Maintenance";
        document.getElementById("total").value ="120"; 
        $('#family_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
        document.getElementById('familyradio').style.removeProperty('display');
        
         if((finalupdatedate < currentyeardate) || (finalupdatedate == "" || finalupdatedate ==" ")){ 
            document.getElementById('paymentdrop').style.removeProperty('display');
                    document.getElementById('member_btn_id').style.removeProperty('display');
                 
            }
                else{
                    document.getElementById('paymentdrop').style.display = 'none';
                    //document.getElementById('Payment_method').style.display = 'none';
                    document.getElementById('member_btn_id').style.display = 'none';
                    $("#total").val("");
                }
            }
        else if(categ == 'GM'   && membercategorytype == 'IND'){
                  
                    document.getElementById('paymentdrop').style.display = 'none';
                    document.getElementById('member_btn_id').style.display = 'none';
                    document.getElementById('familyradio').style.display = 'none';
                    document.getElementById('indvidualradio').style.removeProperty('display');
                    $('#individual_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');	
                     $("#total").val("");
                  }
                   else if(categ == 'GM' && membercategorytype == 'FAM'){
                  
                    document.getElementById('paymentdrop').style.display = 'none';
                    document.getElementById('member_btn_id').style.display = 'none';
                    document.getElementById('indvidualradio').style.display = 'none';
                    document.getElementById('familyradio').style.removeProperty('display');
                    $('#family_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
                     $("#total").val("");
                  }
                   else if(categ == 'GC'){
                       document.getElementById('familyradio').style.display = 'none';
                    document.getElementById('indvidualradio').style.display = 'none';
                   document.getElementById("amountlabel").style.display = "none";
                   document.getElementById("total").style.display = "none";
                    document.getElementById('paymentdrop').style.display = 'none';
                    document.getElementById('member_btn_id').style.display = 'none';
                     $("#total").val("");
               
                  }
                  

    }


    });
} else {
    $("#MemberName").val("");
    $("#phone").val("");
    $("#Your_E-mail").val("");
    $("#memberid").val("");

}
}


///

   function member(timeStamp){
        $.ajax({
        type: 'POST',
         url: 'https://www.durgabari.net/api/member.php',
         data: JSON.stringify(timeStamp),
       success: function(res){
        //debugger;   
            $.ajax({
                type: 'POST',
                //url: 'http://localhost/5sep/member.php',
                url: '<?= INSTALL_URL ?>member.php',
            //    data: {mydata:res},
            data: JSON.stringify(res),
                async: false,
                success: function (data) {
                          
                }
            });
            donation(timeStamp); 
        }
    }); 
    }

function ticket(timeStamp){
        $.LoadingOverlay("show");
        $.ajax({
        type: 'POST',
        url: 'https://www.durgabari.net/api/ticket.php',
       
        // dataType: 'JSON',
        data: JSON.stringify(timeStamp),
        success: function(res2){
			 //debugger;   
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
            member(timeStamp);  
        }
        
    });
    }
    function lastsync(){
    $.ajax({
        url: 'https://www.durgabari.net/api/lastsync.php',
        type: 'get',
        dataType: 'JSON',
        success: function(timestampres){
        $.LoadingOverlay("hide");  
        //debugger;   
            $.ajax({
                type: 'POST',
                url: '<?= INSTALL_URL ?>lastsync.php',
                //url: 'http://localhost/shiv/lastsync.php',
                data: JSON.stringify(timestampres),
                encode: true,
                async: false,
                success: function (data) {
                        
                }
            });
            alert("Data sync successfully");
            window.location.reload();
        }
    }); 
    }
    function donation(timeStamp){
        $.ajax({
        type: 'POST',
        url: 'https://www.durgabari.net/api/donation.php',
        data: JSON.stringify(timeStamp),
        success: function(res1){
        $.LoadingOverlay("hide");  
        //debugger;   
            $.ajax({
                type: 'POST',
                url: '<?= INSTALL_URL ?>donation.php',
                //url: 'http://localhost/5sep/donation.php',
                // data: {mydata:res1},
                data: JSON.stringify(res1),
                encode: true,
                async: false,
                success: function (data) {
                    //member();    
                }
            });
             lastsync();
        }
    });
     

    }

    $('#Sync').click(function(e) {
        e.preventDefault();
       // $.LoadingOverlay("show");
       //debugger
       var output = <?php echo json_encode($lastsync); ?>;
    

       ticket(output);
	 
	
   });

    //    Reset the page automatic
   $(window).bind("pageshow", function() {
    var form = $('form'); 
    form[0].reset();
});
//    Reset the page automatic

// payment method

$('#Payment_method').click(function(e) {
            debugger;
            var val = $(this).val();
             var totalpriceamount =   $("#total").val();

            if(totalpriceamount.trim() == ""){
              alert('please Select Fill Member Details');
              $("#total").prop('required',true);
              document.getElementById("Payment_method").value = "";
             
              return;
                }

            if (val == 'stripe') {
                $("#others_details").hide();
                $("#stripe_details").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $('#member_btn_id').prop('disabled', false);
                var elements = stripe.elements();

                var style = {
                    base: {
                        // Add your base input styles here. For example:
                        fontSize: '16px',
                        color: "#32325d",
                    }
                };

                var card = elements.create('card', {style: style});

                card.mount('#card-element');

                card.addEventListener('change', function (event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });

                var form = document.getElementById('payment-form');

                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    stripe.createToken(card).then(function (result) {
                        if (result.error) {
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                            $("#stripeToken").val(result.token.id);
                            form.submit();
                        }
                    });
                });
            } else if (val == 'others') {
                debugger
                var elem = document.createElement("img");
                    elem.setAttribute("src", "<?= INSTALL_URL ?>zelle.png");
                    elem.setAttribute("height", "600");
                    elem.setAttribute("width", "600");

                    elem.setAttribute("alt", "Flower");
                    $('#error_codeimg').html(elem);
                    document.getElementById("error_codeimg").style.marginLeft = "8%";
                    document.getElementById("error_codeimg").style.marginTop = "2%";
                    document.getElementById("error_code1").style.marginLeft = "24%";
                    document.getElementById("error_code1").style.paddingTop = "12px";
                    
                    document.getElementById("checkPaymentData").style.display = "block";
                    document.getElementById("MemberID1").style.display = "block";
                    document.getElementById("error_code1").style.display = "block";
                    document.getElementById("error_codeimg").style.display = "block";
                    $('#error_code1').html("Step 1 - Send your Zelle payment to treasurer@durgabari.org;" + "<br>" + "Step 2 - Click get zelle payment details button."+ "<br>" + "Step 3 - Select your payment details from  dropdown.");
                $("#stripe_details").hide();
                $("#MemberID1").show();
                //$("#others_details").show();
            } else {
                $("#stripe_details").hide();
                $("#others_details").hide();
            }
        })
        
        
        function padTo2Digits(num) {
          return num.toString().padStart(2, '0');
        }

       function formatDate(date) {
       return [
       padTo2Digits(date.getDate()),
       padTo2Digits(date.getMonth() + 1),
       date.getFullYear(),
       ].join('/');
    }

</script>