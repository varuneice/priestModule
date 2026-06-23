(function ($) {
    $(function () {
       debugger;
            var url1 = $("#container-abc-url-id").text();
        $("#lookupterm").autocomplete({
           // source: "http://localhost/HDBS_Payment/PriestMember/ajax-db-search.php",
           source: url1 + 'ajax-db-search.php',
            select: function( event, ui ) {
                event.preventDefault();
                var name =  ui.item.value;
                var f_name = name.split(",");
                $("#lookupterm").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                MemberSelect3();
            }
      });
      $("#eventterm").autocomplete({
        //source: "http://localhost/HDBS_Payment/PriestMember/ajax-db-search.php",
        source: url1 + 'ajax-db-search.php',
         select: function (event, ui) {
             event.preventDefault();
             var name = ui.item.value;
             var f_name = name.split(",");
             $("#eventterm").val(f_name[0]);
             $("#termMemberevent").val(ui.item.id);
             MemberSelectevent();
         }
     });

     $("#ticketterm").autocomplete({
        //source: "http://localhost/HDBS_Payment/PriestMember/ajax-db-search.php",
        source: url1 + 'ajax-db-search.php',
        select: function (event, ui) {
            event.preventDefault();
            var name = ui.item.value;
            var f_name = name.split(",");
            $("#ticketterm").val(f_name[0]);
            $("#termMemberticket").val(ui.item.id);
            MemberSelectticketevent();

        }
    });

    $("#termgift").autocomplete({
        //source: "http://localhost/HDBS_Payment/PriestMember/ajax-db-search.php",
        source: url1 + 'ajax-db-search.php',
         select: function (event, ui) {
             event.preventDefault();
             var name = ui.item.value;
             var f_name = name.split(",");
             $("#termgift").val(f_name[0]);
             $("#termMembergift").val(ui.item.id);
             MemberSelectgiftmisc();
         }
     });

        var url = $("#container-abc-url-id").text(); 
        function eventcurrentticket() {
           // debugger;
            $.ajax({
                type: "POST",

                url: url + "load.php?controller=Event&action=checkticket",
                success: function (res) {
                    var data = JSON.stringify(res); 
                    var newdata = data.trim();
                    var datanew = JSON.parse(newdata);
                    var evedata = datanew.split('<');
                    var evenewata = evedata[0].replace(/\\\"/g, '');
                    var getdata = JSON.parse(evenewata);

                    if (getdata.Events!=null) {
                        LastName = getdata.Events;
                        document.getElementById("ticketeventtype").value = LastName;
                    }
                    else{
                        LastName = "";
                    }
                    
                    if (getdata.Idevent!=null) {
                    
                        document.getElementById("ticketeventid").value = getdata.Idevent;
                    }  
                }
            });
        }
        function eventcurrentticket_old() {
            debugger;
            $.ajax({
                type: "POST",

                url: url + "load.php?controller=Event&action=checkticket",
                success: function (res) {
                    var priceimage = $(res).filter("input#dataprice");
                    if (priceimage.length) {
                        LastName = priceimage[0].value;
                    }
                    
                    var eventuniqueid = $(res).filter("input#eventid");
                if (eventuniqueid.length) {
                    finaluniqueid = eventuniqueid[0].value;
                    document.getElementById("ticketeventid").value = finaluniqueid;
                }
                    
                    var ticketid = $(res).filter("input#eventid");
                    var parts = LastName.split("/");
                    var namepuja = parts[0];
                    document.getElementById("ticketeventtype").value = namepuja;
                }
            });
        }

        $(document).ready(function () {
            debugger;
            eventcurrentticket();
        });
        
// Ticket function autocomplete
        function MemberSelectticketevent() {
            debugger
            var self = this;
            var data = $("#termMemberticket").val();
            var term = $("#ticketterm").val();
            if (term != "") {
                const Memberid = data.split("-");
        
                //var url = gz$("#container-abc-url-id").text(); 
                if (term.trim() != "") {
                    $.ajax({
                        type: "POST",
                        data: {
                            memberid: data
                        },
                        //url: self.options.server  +"load.php?controller=Donations&action=AllMember&cid=" + self.options.cal_id,
                        url: url + "load.php?controller=Donations&action=AllMember&cid",
                        success: function (res) {
                            //debugger;
                           
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
                            document.getElementById("ticketYour_Name").value = MemberName.concat(" ", LastName);
        
        
                            let memberid = "";
                            const memberElement = $(res).filter("input#memberid");
                            if (memberElement.length) {
                                memberid = memberElement[0].value;
                            }
                            document.getElementById("demmemberticket").value = memberid;
                            
                            let phoneNo = "";
                            const phoneNoElement = $(res).filter("input#Tele1");
                            if (phoneNoElement.length) {
                                phoneNo = phoneNoElement[0].value;
                            }
                            document.getElementById("ticketTele1").value = phoneNo;
        
                            let email = "";
                            const emailElement = $(res).filter("input#email");
                            if (emailElement.length) {
                                email = emailElement[0].value;
                            }
                            document.getElementById("Emailticket").value = email;
        
        
                        }
                    });
                } else {
                    $("#MemberName").val("");
                    $("#phone").val("");
                    $("#MemberName").val("");
                    $("#memberid").val("");
                    // $("#Street").val("");
                    // $("#Address").val("");
                    // $("#Zip").val("");
                    $("#Tele1").val("");
                    // $("#City").val("");
                    // $("#State").val("");
                    $("#Email").val("");
        
                }
            }
        }
        
//function autocomplete
function MemberSelectevent() {
    var url2 = $("#container-abc-url-id").text();
    debugger
    var self = this;
    var data = $("#termMemberevent").val();
    var term = $("#eventterm").val();
    if (term != "") {
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
                    debugger;
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
                    document.getElementById("eventYour_Name").value = MemberName.concat(" ", LastName);

                    let memberid = "";
                    const memberElement = $(res).filter("input#memberid");
                    if (memberElement.length) {
                        memberid = memberElement[0].value;
                    }
                    document.getElementById("demmemberevent").value = memberid;
                    
                    let phoneNo = "";
                    const phoneNoElement = $(res).filter("input#Tele1");
                    if (phoneNoElement.length) {
                        phoneNo = phoneNoElement[0].value;
                    }
                    document.getElementById("Tele1").value = phoneNo;

                    let email = "";
                    const emailElement = $(res).filter("input#email");
                    if (emailElement.length) {
                        email = emailElement[0].value;
                    }
                    document.getElementById("Email").value = email;


                }
            });
        } else {
            $("#MemberName").val("");
            $("#phone").val("");
            $("#MemberName").val("");
            $("#demmemberevent").val("");
            // $("#Street").val("");
            // $("#Address").val("");
            // $("#Zip").val("");
            $("#Tele1").val("");
            // $("#City").val("");
            // $("#State").val("");
            $("#Email").val("");

        }
    }
}

//function autoselect fir giftmisc
function MemberSelectgiftmisc() {
    var url2 = $("#container-abc-url-id").text();
    debugger
    var self = this;
    var data = $("#termMembergift").val();
    var term = $("#termgift").val();
    if (term != "") {
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
                    debugger;
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

                    document.getElementById("Your_Namegiftmisc").value = MemberName.concat(" ", LastName);

                    let memberid = "";
                    const memberElement = $(res).filter("input#memberid");
                    if (memberElement.length) {
                        memberid = memberElement[0].value;
                    }
                    document.getElementById("demmembergift").value = memberid;
                    
                    let spouseName = "";
                    let spouseLastName = "";
                    const spouseNameElement = $(res).filter("input#Spouse");
                    const spouseLastNameElement = $(res).filter("input#Spouselast");
                    if (spouseLastNameElement.length) {
                        spouseLastName = spouseLastNameElement[0].value;
                    }
                    if (spouseNameElement.length) {
                        spouseName = spouseNameElement[0].value;
                    }
                    document.getElementById("spousenamegift").value = spouseName.concat(" ", spouseLastName);

                    let street = "";
                    const streetElement = $(res).filter("input#ressidentalAddress");
                    if (streetElement.length) {
                        street = streetElement[0].value;
                    }
                    document.getElementById("Streetgift").value = street;

                    let resaddress = "";
                    const resaddressElement = $(res).filter("input#Address");
                    if (resaddressElement.length) {
                        resaddress = resaddressElement[0].value;
                    }
                    document.getElementById("ressidentalAddressgift").value = resaddress;

                    let state = "";
                    const stateElement = $(res).filter("input#state");
                    if (stateElement.length) {
                        state = stateElement[0].value;
                    }
                    document.getElementById("stategift").value = state;


                    let city = "";
                    const cityElement = $(res).filter("input#city");
                    if (cityElement.length) {
                        city = cityElement[0].value;
                    }
                    document.getElementById("citygift").value = city;

                    let zipcode = "";
                    const zipcodeElement = $(res).filter("input#zip_code");
                    if (zipcodeElement.length) {
                        zipcode = zipcodeElement[0].value;
                    }
                    document.getElementById("zip_codegift").value = zipcode;

                    let phoneNo = "";
                    const phoneNoElement = $(res).filter("input#Tele1");
                    if (phoneNoElement.length) {
                        phoneNo = phoneNoElement[0].value;
                    }
                    document.getElementById("phonegift").value = phoneNo;

                    let email = "";
                    const emailElement = $(res).filter("input#email");
                    if (emailElement.length) {
                        email = emailElement[0].value;
                    }
                    document.getElementById("emailgift").value = email;

                }

            });
        } else {
            $("#MemberNamegift").val("");
            $("#phonegift").val("");
            $("#memberidgift").val(""); Member_id
            $("#spousenamegift").val("");
            $("#Streetgift").val("");
            $("#ressidentalAddressgift").val("");
            $("#stategift").val("");
            $("#citygift").val("");
            $("#zip_codegift").val("");
            $("#phonegift").val("");
            $("#emailgift").val("");
            $("#ltd1").val("");
            $("#ytd1").val("");
            $("#MembCategory").val("");

        }
    }
}


         // For Member Search option...........................

         function MemberSelect3() {

            var self = this;    
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
                          document.getElementById("lookupYour_Name").value = MemberName.concat(" ", LastName);
            
                        let memberid = "";
                        const memberElement = $(res).filter("input#memberid");
                        if (memberElement.length) {
                            memberid = memberElement[0].value;
                        }
                        document.getElementById("lookupdemmember").value = memberid;
                        // if(memberid != ""){
                        // document.getElementById("demmember").value = memberid;
                        // var url ="http://localhost/HDBS_Payment/priestModule/Member/membermaintenance/" +memberid
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
                      document.getElementById("spouselookup").value = spouseName.concat(" ",spouseLastName);
            
                      let street = "";
                            const streetElement = $(res).filter("input#ressidentalAddress");
                          if(streetElement.length){
                           street = streetElement[0].value; 
                           }
                           document.getElementById("lookupStreet").value = street;
            
                           let resaddress = "";
                   const resaddressElement = $(res).filter("input#Address");
                  if(resaddressElement.length){
                    resaddress = resaddressElement[0].value; 
                  }
                  document.getElementById("lookupressidentalAddress").value = resaddress;
            
                  let state = "";
                  const stateElement = $(res).filter("input#state");
                 if(stateElement.length){
                   state = stateElement[0].value; 
                 }
                 document.getElementById("lookupstate").value = state;
                 
            
                 let city = "";
                    const cityElement = $(res).filter("input#city");
                   if(cityElement.length){
                      city = cityElement[0].value; 
                   }
                   document.getElementById("lookupcity").value = city;
            
                   let zipcode = "";
                    const zipcodeElement = $(res).filter("input#zip_code");
                   if(zipcodeElement.length){
                    zipcode = zipcodeElement[0].value; 
                   }
                   document.getElementById("lookupzip_code").value = zipcode;
            
                   let phoneNo = "";
                    const phoneNoElement = $(res).filter("input#Tele1");
                   if(phoneNoElement.length){
                      phoneNo = phoneNoElement[0].value; 
                   }
                   document.getElementById("lookupphone").value = phoneNo;
            
                   let email = "";
                    const emailElement = $(res).filter("input#email");
                   if(emailElement.length){
                       email = emailElement[0].value; 
                   }
                   document.getElementById("lookupemail").value = email;
                   
                   let uniqueid = "";
                   const uniqueidElement = $(res).filter("input#tableid");
                  if(uniqueidElement.length){
                      uniqueid = uniqueidElement[0].value; 
                  }
                  document.getElementById("Your_id").value = uniqueid;
            
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
                //let currentdaydate = formatDate(new Date());
                 var currentdaydate = serverDateTime;
                //const currentYear = "<?php echo $currentYear; ?>";
                debugger
                // Create a new Date object for March 31st of the current year
                const maintenancedate = new Date(currentYear, 2, 31); // Month is zero-based

                // Extract year, month, and day from the Date object
                const year = maintenancedate.getFullYear();
                const month = maintenancedate.getMonth() + 1; // Adjust month (zero-based to one-based)
                const day = maintenancedate.getDate();

                // Format the date as "Y-m-d"
                const maintenancedatePrev = year + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
                            //let maintenancedatePrev= '31'+'/03/'+date;
                
                 if(categ == 'GD' && membercategorytype == 'IND'){
                    document.getElementById('familyradio').style.display = 'none';
                     document.getElementById("amountlabel").value ="Membership Renewal"; 
                    $('#individual_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
                    document.getElementById('amountlabel').style.removeProperty('display');
                                document.getElementById('total').style.removeProperty('display');
                                //document.getElementById('paymentdrop').style.removeProperty('display');
                                document.getElementById('member_btn_id').style.removeProperty('display');
                    document.getElementById('indvidualradio').style.removeProperty('display');
                    document.getElementById('meberpaymethod').style.removeProperty('display');
                                if (currentdaydate  > maintenancedatePrev){
                                    	
                                    document.getElementById("total").value ="165"
                                }
                                else{
                                    document.getElementById("total").value ="150" 
                                   
                                }
                  }
                 else if(categ == 'GD' && membercategorytype == 'FAM'){
                    document.getElementById('indvidualradio').style.display = 'none';
                     document.getElementById("amountlabel").value ="Membership Renewal"; 
                    $('#family_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
                    document.getElementById('amountlabel').style.removeProperty('display');
                                document.getElementById('total').style.removeProperty('display');
                                //document.getElementById('paymentdrop').style.removeProperty('display');
                                document.getElementById('member_btn_id').style.removeProperty('display');
                    document.getElementById('familyradio').style.removeProperty('display');
                    document.getElementById('meberpaymethod').style.removeProperty('display');
                                if (currentdaydate  > maintenancedatePrev){
                                    document.getElementById("total").value ="225"
                                    
                                }
                                else{
                                   
                                    document.getElementById("total").value ="200"
                                }
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
                       // document.getElementById('paymentdrop').style.removeProperty('display');
                    document.getElementById('member_btn_id').style.removeProperty('display');
                        document.getElementById('meberpaymethod').style.display = 'display';
                     }else{
                       // document.getElementById('paymentdrop').style.display = 'none';
                        //document.getElementById('Payment_method').style.display = 'none';
                        document.getElementById('meberpaymethod').style.display = 'none';
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
                        //document.getElementById('paymentdrop').style.removeProperty('display');
                                document.getElementById('member_btn_id').style.removeProperty('display');
                                document.getElementById('meberpaymethod').style.display = 'display';
                             
                        }
                            else{
                               // document.getElementById('paymentdrop').style.display = 'none';
                                //document.getElementById('Payment_method').style.display = 'none';
                                document.getElementById('member_btn_id').style.display = 'none';
                                 document.getElementById('meberpaymethod').style.display = 'none';
                                 $("#total").val("");
                            }
                        }
                              else if(categ == 'GM'   && membercategorytype == 'IND'){
                              
                                document.getElementById('meberpaymethod').style.display = 'none';
                                document.getElementById('member_btn_id').style.display = 'none';
                                document.getElementById('familyradio').style.display = 'none';
                                document.getElementById('indvidualradio').style.removeProperty('display');
                                $('#individual_membershipradio').parent().attr('aria-checked', 'true').addClass('checked');
                                $("#total").val("");
                              }
                               else if(categ == 'GM' && membercategorytype == 'FAM'){
                              
                                 document.getElementById('meberpaymethod').style.display = 'none';
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
                                 document.getElementById('meberpaymethod').style.display = 'none';
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
    }).delegate('#lookupdirectamount', 'change', function () {
        debugger;
        var renewmaintenanceprice = $("#total").val();
        var lookupdirectamount = $("#lookupdirectamount").val();
       
       
        if( lookupdirectamount < renewmaintenanceprice ){
            alert('Renew price and direct deposit amount not same please select correct payment');
            $("#member_btn_id").addClass('disabled');
        }
        else{
            $("#member_btn_id").removeClass('disabled');
        }
    }).delegate('#lookupcashamount', 'change', function () {
        debugger;
        var lookupcash = $("#lookupcashamount").val();
        var renewmaintenanceprice = $("#total").val();

        if( lookupcash < renewmaintenanceprice){
            alert('Renew price and cash amount not same please select correct payment');
            $("#member_btn_id").addClass('disabled');
        }
        else{
            $("#member_btn_id").removeClass('disabled');
        }
    }).delegate('#lookupcheckamount', 'change', function () {
        debugger;
        var lookupamountcheck = $("#lookupcheckamount").val();
        var renewmaintenanceprice = $("#total").val();
        if( lookupamountcheck < renewmaintenanceprice ){
            alert('Renew price and check amount not same please select correct payment');
            $("#member_btn_id").addClass('disabled');
        }
        else{
            $("#member_btn_id").removeClass('disabled');
        }
    }).delegate('#eventdirectamount', 'change', function () {
        debugger;
        var eventtotalprice = $("#totalamount").val();
        var eventdirectamount = $("#eventdirectamount").val();
        if( eventdirectamount < eventtotalprice ){
            alert('Event price and direct deposit amount not same please select correct payment');
            $("#payment_btn_id").addClass('disabled');
        }
        else{
            $("#payment_btn_id").removeClass('disabled');
        }
    }).delegate('#eventcashamount', 'change', function () {
        debugger;
        var eventcash = $("#eventcashamount").val();
        var eventprice = $("#totalamount").val();

        if( eventcash < eventprice){
            alert('Event price and cash amount not same please select correct payment');
            $("#payment_btn_id").addClass('disabled');
        }
        else{
            $("#payment_btn_id").removeClass('disabled');
        }
    }).delegate('#eventcheckamount', 'change', function () {
        debugger;
        var eventcheck = $("#eventcheckamount").val();
        var priceeventticket = $("#totalamount").val();
        if( eventcheck < priceevent ){
            alert('Event price and check amount not same please select correct payment');
            $("#payment_btn_id").addClass('disabled');
        }
        else{
            $("#payment_btn_id").removeClass('disabled');
        }
    }).delegate('#ticketdirectamount', 'change', function (e) {
        e.stopImmediatePropagation();
        debugger;
        var tickettotal = ($("#totalamount").val() * 1);
        var ticketdirectprice = ($("#ticketdirectamount").val() * 1);
        if(tickettotal > ticketdirectprice){
            alert('Ticket price and direct deposit amount not same please select correct payment');
            $("#payment_btn_idticket").addClass('disabled');
        }
        else{
            $("#payment_btn_idticket").removeClass('disabled');
        }
    }).delegate('#ticketcashamount', 'change', function (e) {
        e.stopImmediatePropagation();
        debugger;
        var ticketcash = ($("#ticketcashamount").val() * 1);
        var ticketpricecash = ($("#totalamount").val() * 1);
        if( ticketpricecash > ticketcash){
            alert('Ticket price and cash amount not same please select correct payment');
            $("#payment_btn_idticket").addClass('disabled');
        }
        else{
            $("#payment_btn_idticket").removeClass('disabled');
        }
     
    }).delegate('#ticketcheckamount', 'change', function (e) {
        e.stopImmediatePropagation();
        debugger;
        var ticketcheck = $("#ticketcheckamount").val();
        var priceticketcheck = $("#totalamount").val();
        if( priceticketcheck > ticketcheck ){
            alert('Ticket price and check amount not same please select correct payment');
            $("#payment_btn_idticket").addClass('disabled');
        }
        else{
            $("#payment_btn_idticket").removeClass('disabled');
        }
    }).delegate('#checkamountgift', 'change', function (e) {
        e.stopImmediatePropagation();
        debugger;
        var giftcheck = ($("#checkamountgift").val() * 1);
        var donationamount = ($("#totalgiftdonationamount").val() * 1);
        if( donationamount > giftcheck ){
            alert('Gift/Misc price and check amount not same please select correct payment');
            $("#submit").addClass('disabled');
        }
        else{
            $("#submit").removeClass('disabled');
        }
    }).delegate('#cashamountgift', 'change', function (e) {
        e.stopImmediatePropagation();
        debugger;
        var giftcash = ($("#cashamountgift").val() * 1);
       var donationamount = ($("#totalgiftdonationamount").val() * 1);
        if( donationamount > giftcash){
            alert('Gift/Misc price and cash amount not same please select correct payment');
            $("#submit").addClass('disabled');
        }
        else{
            $("#submit").removeClass('disabled');
        }
     
    }).delegate('#directamountgift', 'change', function (e) {
        e.stopImmediatePropagation();
        debugger;
        var donationamount = ($("#totalgiftdonationamount").val() * 1);
        var giftdirectprice = ($("#directamountgift").val() * 1);
        if(donationamount > giftdirectprice){
            alert('Gift/Misc price and direct deposit amount not same please select correct payment');
            $("#submit").addClass('disabled');
        }
        else{
            $("#submit").removeClass('disabled');
        }
    }).delegate('#registrationmembergiftmisc', 'change', function () {
        debugger;
        selectVal = $('#registrationmembergiftmisc').val();
    if (selectVal == "member") {
        $('#IDMembertdgift').find(':input').prop("disabled", false);
            document.getElementById("termgift").value = "";
            document.getElementById("demmembergift").value = "";
            document.getElementById("spousenamegift").value = "";
            document.getElementById("Streetgift").value = "";
            document.getElementById("ressidentalAddressgift").value = "";
            document.getElementById("citygift").value = "";
            document.getElementById("stategift").value = "";
            document.getElementById("zip_codegift").value = "";
            document.getElementById("phonegift").value = "";
            document.getElementById("emailgift").value = "";
            $('#nonmembernamegift').hide();
            $('#fieldtestgift').hide();
            $('#namemeemberregistergift').show();
            $('#IDMembertdgift').show();
            $('#namemeemberregistergift').show();
            $("#namenonmembergift").prop('required',false);
            $("#termgift").prop('required',true);
    }
    else {
        $('#IDMembertdgift').find(':input').prop("disabled", true);
        document.getElementById("termgift").value = "";
        document.getElementById("demmembergift").value = "";
        document.getElementById("spousenamegift").value = "";
        document.getElementById("Streetgift").value = "";
        document.getElementById("ressidentalAddressgift").value = "";
        document.getElementById("citygift").value = "";
        document.getElementById("stategift").value = "";
        document.getElementById("zip_codegift").value = "";
        document.getElementById("phonegift").value = "";
        document.getElementById("emailgift").value = "";
        $('#namemeemberregistergift').hide();
        $('#IDMembertdevent').hide();
        $('#nonmembernamegift').show();
        $('#fieldtestgift').show();
        $("#fieldtestgift").prop('readonly',true);
        $("#namenonmembergift").prop('required',true);
        $("#termgift").prop('required',false);
    }
    }).delegate('#registrationmembergiftmisc', 'change', function () {
        debugger;
        selectVal = $('#registrationmembergiftmisc').val();
    if (selectVal == "member") {
            $('#IDMembertdgift').find(':input').prop("disabled", false);
            $('#nonmembernamegift').hide();
            $('#fieldtestgift').hide();
            $('#namemeemberregistergift').show();
            $('#IDMembertdgift').show();
            $('#namemeemberregistergift').show();
            $("#namenonmembergift").prop('required',false);
            $("#eventterm").prop('required',true);
        }
        else {
            $('#IDMembertdgift').find(':input').prop("disabled", true);
            $('#namemeemberregistergift').hide();
            $('#IDMembertdgift').hide();
            $('#nonmembernamegift').show();
            $('#fieldtestgift').show();
            $("#fieldtestgift").prop('readonly',true);
            $("#namenonmembergift").prop('required',true);
            $("#eventterm").prop('required',false);
        }
    }).delegate('#registrationmemberevent', 'change', function () {
        debugger;
        selectVal = $('#registrationmemberevent').val();
    if (selectVal == "member") {
        $('#IDMembertdevent').find(':input').prop("disabled", false);
            document.getElementById("eventterm").value = "";
            document.getElementById("namenonmemberevent").value = "";
            document.getElementById("Tele1").value = "";
            document.getElementById("Email").value = "";
            document.getElementById("demmemberevent").value = "";
            $('#nonmembernameevent').hide();
            $('#fieldtestevent').hide();
            $('#namemeemberregisterevent').show();
            $('#IDMembertdevent').show();
            $('#namemeemberregisterevent').show();
            $("#namenonmemberevent").prop('required',false);
            $("#eventterm").prop('required',true);

    }
    else {
        $('#IDMembertdevent').find(':input').prop("disabled", true);
            document.getElementById("eventterm").value = "";
            document.getElementById("Tele1").value = "";
            document.getElementById("Email").value = "";
            document.getElementById("demmemberevent").value = "";
            document.getElementById("namenonmemberevent").value = "";

            $('#namemeemberregisterevent').hide();
            $('#IDMembertdevent').hide();
            $('#nonmembernameevent').show();
            $('#fieldtestevent').show();
            $("#fieldtestevent").prop('readonly',true);
            $("#namenonmemberevent").prop('required',true);
            $("#eventterm").prop('required',false);
    }
    }).delegate('#ticketregistrationmember', 'change', function () {
        debugger;
        selectVal = $('#ticketregistrationmember').val();
    if (selectVal == "member") {
        $('#IDMembertdticket').find(':input').prop("disabled", false);
            //document.getElementById("MemberName").value = "";
            document.getElementById("Tele1").value = "";
            document.getElementById("email").value = "";
            document.getElementById("IDMembertdticket").value = "";
            $('#ticketnonmembername').hide();
            $('#ticketfield').hide();
            $('#ticketnamemeemberregister').show();
            $('#IDMembertdticket').show();
            $('#ticketnamemeemberregister').show();
            $("#ticketnamenonmember").prop('required',false);
            $("#ticketterm").prop('required',true);

    }
    else {
        $('#IDMembertdticket').find(':input').prop("disabled", true);
            //document.getElementById("MemberName").value = "";
            document.getElementById("Tele1").value = "";
            document.getElementById("email").value = "";
            document.getElementById("IDMembertdticket").value = "";

            $('#ticketnamemeemberregister').hide();
            $('#IDMembertdticket').hide();
            $('#ticketnonmembername').show();
            $('#ticketfield').show();
            $("#ticketfield").prop('readonly',true);
            $("#ticketnamenonmember").prop('required',true);
            $("#ticketterm").prop('required',false);
    }
    }).delegate('#reset-btn-id', 'click',  function (e) {
             e.preventDefault();
             $('#payment-form')[0].reset();
             $('#tablecheck').hide();
            $('#tablecash').hide();
            $('#directdepositetable').hide();
        }).delegate('#reset-btn-idevent', 'click',  function (e) {
            debugger;
            e.preventDefault();
            $('#donation-frm-idevent')[0].reset();  
            $('#checkdataevent').hide();
            $('#cashdataevent').hide();
            $('#directdepositeevent').hide();
        }).delegate('#donationreset-btn-id', 'click',  function (e) {
            debugger;
            e.preventDefault();
            $('#donation-frm-id')[0].reset();
             $('#checkdata').hide();
            $('#cashdata').hide();
            $('#directdeposite').hide();
       }).delegate('#reset-btn-idticket', 'click',  function (e) {
        debugger;
        e.preventDefault();
        $('#donation-frm-idticket')[0].reset();  
        $('#checkdataticket').hide();
        $('#cashdataticket').hide();
        $('#directdepositeticket').hide();
   }).delegate('#giftreset-btn-id', 'click',  function (e) {
    debugger;
    e.preventDefault();
    $('#donation-frm-idgiftmisc')[0].reset();  
    $("#checkdatagiftmisc").hide();
    $("#cashdatagiftmisc").hide();
    $('#directdepositegiftmisc').hide();
});

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
}(jQuery));