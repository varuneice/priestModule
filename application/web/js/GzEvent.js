(function ($) {
    $(function () {
        
         $(function(){
            $('input[type="text"]').change(function(){
                this.value = $.trim(this.value);
            });
            
             $('#demmember').keydown(function(e) {
              e.preventDefault();
             return false;
            });

            $('#term').on('input', function() {
             $(this).val($(this).val().replace(/[^a-z0-9]/gi, ''));
            });
        }); 
        
        var url = $("#container-abc-url-id").text();
        debugger;
        $("#term").autocomplete({
            //source: "http://localhost/HDBS_Payment/PriestMember/ajax-db-search.php",
            source: url + 'ajax-db-search.php',
            select: function (event, ui) {
                event.preventDefault();
                var name = ui.item.value;
                var f_name = name.split(",");
                $("#term").val(f_name[0]);
                $("#termMember").val(ui.item.id);
                MemberSelectticketevent();

            },
            onclick: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelectticketevent();
        },
         onchange: function( event, ui ) {
            event.preventDefault();
            var name =  ui.item.value;
            var f_name = name.split(",");
            $("#term").val(f_name[0]);
            $("#termMember").val(ui.item.id);
            MemberSelectticketevent();
        },
        });

        // $('#tab-1-table-id').dataTable({
        //     "aoColumnDefs": [
        //         {'bSortable': false, 'aTargets': [5, 6]}
        //     ]
        // });
        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }
        function eventcurrent() {
           // debugger;
            $.ajax({
                type: "POST",

                url: url + "load.php?controller=Event&action=checkticket",
                success: function (res) {
                    debugger
                    var data = JSON.stringify(res); 
                    var newdata = data.trim();
                    var datanew = JSON.parse(newdata);
                    var evedata = datanew.split('<');
                    var evenewata = evedata[0].replace(/\\\"/g, '');
                    var getdata = JSON.parse(evenewata);
                    
                 
                    if (getdata.Events!=null) {
                        LastName = getdata.Events;
                    }
                    else{
                        LastName = "";
                    }
                    if(LastName != ""){
                        if (getdata.Image!=null) {
                            ticketeventimage = getdata.Image;
                        }
                        else{
                            ticketeventimage = "";
                        }
                    
                if (getdata.Idevent!=null) {
                    
                    document.getElementById("ticketeventid").value = getdata.Idevent;
                }
                   
                    if (getdata.Desc!=null) {
                        descriptiondata = getdata.Desc;
                        var test = descriptiondata.split(".");
                        var data = test.length;


                        var addRow = "";
                        
                        if(ticketeventimage == "")
                        {
                            if (test !== null || test !== undefined) {
                                addRow += "<label for='Files' title='Files' class='control_label' id='description' style ='color:red;position: relative;left: 40%;text-align: center;margin: 0 auto; '>Important Instructions</label>";
                                addRow += "<label for='Files' title='Files' class='control_label' id='line' style ='color:red;text-align: center;width:100%!important'>-------------------------------------------</label>";
                                //  addRow += "<table>";
                                for (let i = 0; i < data - 1; i++) {
                                    addRow +="<label style='color:gray; font-size:15px; margin-top:2%;position: relative;text-align: center;'>" + test[i] + "</label></br>"
    
                                }
    
                                //   addRow += "</table>";
                                $("#description").append(addRow)
                            }
    

                        }
                        else{

                            if (test !== null || test !== undefined) {
                                addRow += "<label for='Files' title='Files' class='control_label' id='description' style ='color:red;position: relative;left: 25%;text-align: center;margin: 0 auto; '>Important Instructions</label>";
                                addRow += "<label for='Files' title='Files' class='control_label' id='line' style ='color:red;text-align: center;width:100%!important'>-------------------------------------------</label>";
                                //  addRow += "<table>";
                                for (let i = 0; i < data - 1; i++) {
                                    addRow += "<label style='color:gray; font-size:16px; margin-top:2%;'>" + test[i] + "</label></br>"
    
                                }
    
                                //   addRow += "</table>";
                                $("#description").append(addRow)
                            }
    
                        }

                    }
                    //var ticketid = $(res).filter("input#eventid");

                    var parts = LastName.split("/");
                    var namepuja = parts[0];
                    // var namepuja = LastName;
                    var evimg = ticketeventimage
                    var newname = "- " + namepuja;
                    document.getElementById("evenam").textContent = newname;
                    //document.getElementById("description").textContent=descriptiondata;

                    if (evimg != "") {
                        document.getElementById('imageevent').style.removeProperty('display');
                        //var path = "http://localhost/19april/application/web/upload/avatar/thumb/"
                        //var path = "https://durgabari.org/HDBS_PaymentNew/application/web/upload/avatar/thumb/"
                        var path = $("#container-abc-url-id").text() + "application/web/upload/avatar/thumb/"
                        var url = path+evimg;
                        var elem = document.getElementById("dataimg")
                        //var elem = document.createElement("idataimgmg");

                        elem.setAttribute("src", url);
                        // elem.setAttribute("height", "250");
                        // elem.setAttribute("width", "100");
                    }
                    else {
                        document.getElementById('imageevent').style.display = 'block';
                    }
                    //document.getElementById("Amount").value = namepuja;
                    //document.getElementById("totalamount").value = namepuja;
                    document.getElementById("eventtype").value = namepuja;
                }
                }
            });
        }
        function eventcurrent_old() {
            debugger;
            $.ajax({
                type: "POST",

                url: url + "load.php?controller=Event&action=checkticket",
                success: function (res) {
                    var priceimage = $(res).filter("input#dataprice");
                    if (priceimage.length) {
                        LastName = priceimage[0].value;
                    }
                 if(LastName != ""){
                    var ticketimage = $(res).filter("input#ticketimage");
                    if (ticketimage.length) {
                        ticketeventimage = ticketimage[0].value;
                    }
                    
                    var eventuniqueid = $(res).filter("input#eventid");
                if (eventuniqueid.length) {
                    finaluniqueid = eventuniqueid[0].value;
                    document.getElementById("ticketeventid").value = finaluniqueid;
                }
                    var descrip = $(res).filter("input#descriptiontext");
                    if (descrip.length) {
                        descriptiondata = descrip[0].value;
                        var test = descriptiondata.split(".");
                        var data = test.length;


                        var addRow = "";
                        
                        if(ticketeventimage == "")
                        {
                            if (test !== null || test !== undefined) {
                                addRow += "<label for='Files' title='Files' class='control_label' id='description' style ='color:red;position: relative;left: 40%;text-align: center;margin: 0 auto; '>Important Instructions</label>";
                                addRow += "<label for='Files' title='Files' class='control_label' id='line' style ='color:red;text-align: center;width:100%!important'>-------------------------------------------</label>";
                                //  addRow += "<table>";
                                for (let i = 0; i < data - 1; i++) {
                                    addRow +="<label style='color:gray; font-size:15px; margin-top:2%;position: relative;text-align: center;'>" + test[i] + "</label></br>"
    
                                }
    
                                //   addRow += "</table>";
                                $("#description").append(addRow)
                            }
    

                        }
                        else{

                            if (test !== null || test !== undefined) {
                                addRow += "<label for='Files' title='Files' class='control_label' id='description' style ='color:red;position: relative;left: 25%;text-align: center;margin: 0 auto; '>Important Instructions</label>";
                                addRow += "<label for='Files' title='Files' class='control_label' id='line' style ='color:red;text-align: center;width:100%!important'>-------------------------------------------</label>";
                                //  addRow += "<table>";
                                for (let i = 0; i < data - 1; i++) {
                                    addRow += "<label style='color:gray; font-size:70%; margin-top:2%;'>" + test[i] + "</label></br>"
    
                                }
    
                                //   addRow += "</table>";
                                $("#description").append(addRow)
                            }
    
                        }

                    }
                    var ticketid = $(res).filter("input#eventid");
                    //    if( ticketid.length){
                    //     valticket =  ticketid[0].value; 
                    //     $.ajax({
                    //      type: "POST",
                    //                 data: {
                    //                     valticket: valticket
                    //                  },
                    //            url: "http://localhost/6feb/load.php?controller=Event&action=ticketprice&cid",
                    //             //url: "http://localhost/HDBS_Payment/priestModule/load.php?controller=Event&action=ticketprice&cid", 
                    //             //url: "http://localhost/HDBS_Payment/priestModule/load.php?controller=Event&action=checkticket&cid",   
                    //                 success: function (res) { 
                    //                     var newOption = $(res);
                    //                     var newOption1 = $('<option value="1">Select event day</option>');
                    //                     $('#ticketday').append(newOption1);
                    //                     $('#ticketday').append(newOption);
                    //                     $('#ticketday').trigger("chosen:updated");

                    //                 }
                    //  })

                    //    }
                    var parts = LastName.split("/");
                    var namepuja = parts[0];
                    // var namepuja = LastName;
                    var evimg = ticketeventimage
                    var newname = "- " + namepuja;
                    document.getElementById("evenam").textContent = newname;
                    //document.getElementById("description").textContent=descriptiondata;

                    if (evimg != "") {
                        document.getElementById('imageevent').style.removeProperty('display');
                        var path = $("#container-abc-url-id").text() + "application/web/upload/avatar/thumb/"
                        var url = path+evimg;
                        var elem = document.getElementById("dataimg")
                        //var elem = document.createElement("idataimgmg");

                        elem.setAttribute("src", url);
                        // elem.setAttribute("height", "250");
                        // elem.setAttribute("width", "100");
                    }
                    else {
                        document.getElementById('imageevent').style.display = 'block';
                    }
                    //document.getElementById("Amount").value = namepuja;
                    //document.getElementById("totalamount").value = namepuja;
                    document.getElementById("eventtype").value = namepuja;
                }
                }
            });
        }

        function MemberSelectticketevent() {
            debugger
            var self = this;
            var data = $("#termMember").val();
            var term = $("#term").val();
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

                            // let MemberfullName= "";
                            // const MemberfullNameElement = $(res).filter("input#MemberName");
                            // if (MemberfullNameElement.length) {
                            //     MemberfullName = MemberfullNameElement[0].value;
                            // }



                            let memberid = "";
                            const memberElement = $(res).filter("input#memberid");
                            if (memberElement.length) {
                                memberid = memberElement[0].value;
                            }
                            document.getElementById("demmember").value = memberid;
                            // if(memberid != ""){
                            // document.getElementById("demmember").value = memberid;
                            // var url ="http://localhost/HDBS_Payment/priestModule/Member/membermaintenance/" +memberid
                            // window.location.assign(url);
                            // }
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


        //eventdelete code
        $("#tab-1-table-id").delegate('a.icon-delete', 'click', function (e) {
            debugger;
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#dialogDelete').dialog('open');
        });
        if ($("#dialogDelete").length > 0) {
            debugger;
            $("#dialogDelete").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function () {
                    $('#record_id').text('');
                },
                buttons: [{
                    html: "<i class='fa fa-trash-o'></i>&nbsp; Delete item",
                    "class": "btn btn-danger",
                    click: function () {
                        $.ajax({
                            type: "POST",
                            data: {
                                id: $('#record_id').text(),
                                controller: 'Eventadmin',
                                action: 'delete'
                            },
                            url: url + "index.php?controller=Eventadmin&action=delete",
                            beforeSend: function () {
                                $(".overlay").css('display', 'block');
                                $(".loading-img").css('display', 'block');
                            },
                            success: function (res) {
                                $("#tab-1-table-id").html(res);
                                $(".overlay").css('display', 'none');
                                $(".loading-img").css('display', 'none');

                                $('#tab-1-table-id').dataTable({
                                    "aoColumnDefs": [
                                        { 'bSortable': false, 'aTargets': [5, 6] }
                                    ]
                                });
                            }
                        });
                        $(this).dialog('close');

                    }
                }, {
                    html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                    "class": "btn btn-default",
                    click: function () {
                        $(this).dialog('close');
                    }
                }]
            });
        }
        $(document).ready(function () {
            debugger;
            eventcurrent();
            $('#registrationmember').change(function () {
                selectVal = $('#registrationmember').val();
                if (selectVal == "member") {
                    $('#IDMembertd').find(':input').prop("disabled", false);
                    $("#demmember").prop('required',true);
                }
                else {
                    $('#IDMembertd').find(':input').prop("disabled", true);
                     $("#demmember").prop('required',false); 
                }
            })
        });
        $("#ticket-table-id").delegate('a.icon-delete', 'click', function (e) {
            debugger;
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#dialogDelete').dialog('open');
        });
        if ($("#dialogDelete").length > 0) {
            debugger;
            $("#dialogDelete").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function () {
                    $('#record_id').text('');
                },
                buttons: [{
                    html: "<i class='fa fa-trash-o'></i>&nbsp; Delete item",
                    "class": "btn btn-danger",
                    click: function () {
                        $.ajax({
                            type: "POST",
                            data: {
                                id: $('#record_id').text(),
                                controller: 'Eventadmin',
                                action: 'delete'
                            },
                            url: url + "index.php?controller=Eventadmin&action=ticketdelete",
                            beforeSend: function () {
                                $(".overlay").css('display', 'block');
                                $(".loading-img").css('display', 'block');
                            },
                            success: function (res) {
                                $("#ticket-table-id").html(res);
                                $(".overlay").css('display', 'none');
                                $(".loading-img").css('display', 'none');

                                $('#ticket-table-id').dataTable({
                                    "aoColumnDefs": [
                                        { 'bSortable': false, 'aTargets': [5, 6] }
                                    ]
                                });
                            }
                        });
                        $(this).dialog('close');

                    }
                }, {
                    html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                    "class": "btn btn-default",
                    click: function () {
                        $(this).dialog('close');
                    }
                }]
            });
        }

        //image delete code 
       if ($("#dialogDelete").length > 0) {
            $("#dialogDelete").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function() {
                    $('#record_id').text('');
                },
                buttons: [{
                        html: "<i class='fa fa-trash-o'></i>&nbsp; Delete item",
                        "class": "btn btn-danger",
                        click: function() {
                            $.ajax({
                                type: "POST",
                                data: {
                                    id: $('#record_id').text(),
                                    controller: 'Eventadmin',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=Eventadmin&action=delete",
                                beforeSend: function() {
                                    $(".overlay").css('display', 'block');
                                    $(".loading-img").css('display', 'block');
                                },
                                success: function(res) {
                                    $("#table-frm-id").html(res);

                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');

                                    $('#gzhotel-booking-user-id').dataTable({
                                        "aoColumnDefs": [
                                            {'bSortable': false, 'aTargets': [5, 6]}
                                        ]
                                    });
                                }
                            });
                            $(this).dialog('close');

                        }}, {
                        html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                        "class": "btn btn-default",
                        click: function() {
                            $(this).dialog('close');
                        }}]
            });
        }
        if ($("a.gallery-delete").length > 0) {
            $("#table-frm-id").delegate("a.gallery-delete", 'click', function (e) {
                e.preventDefault();
                $('#record_id').text($(this).attr('rev'));
                $('#dialogDeleteGallery').dialog('open');
            });

            $("#edit_user").delegate("a.gallery-delete", 'click', function (e) {
                debugger;
                e.preventDefault();
                $('#record_id').text($(this).attr('rev'));
                $('#dialogDeleteImage').dialog('open');
            });
        }
      if ($("#dialogDeleteImage").length > 0) {
            debugger;
            $("#dialogDeleteImage").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function () {
                    $('#record_id').text('');
                },
                buttons: {
                    "Delete": function () {
                        $.ajax({
                            type: "POST",
                            data: {
                                id: $('#record_id').text(),
                                controller: 'Eventadmin',
                                action: 'deleteEditedImage'
                            },
                            url: url + "index.php?controller=Eventadmin&action=deleteEditedImage",
                            success: function (res) {
                                $("#img-file-id").html(res);
                            }
                        });
                        $(this).dialog('close');
                    },
                    'Cancel': function () {
                        $(this).dialog('close');
                    }
                }
            });
        }
        if ($("#dialogDeleteImage").length > 0) {
            debugger;
            $("#dialogDeleteImage").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function () {
                    $('#record_id').text('');
                },
                buttons: {
                    "Delete": function () {
                        $.ajax({
                            type: "POST",
                            data: {
                                id: $('#record_id').text(),
                                controller: 'Eventadmin',
                                action: 'deleteEditedticketImage'
                            },
                            url: url + "index.php?controller=Eventadmin&action=deleteEditedticketImage",
                            success: function (res) {
                                $("#allticketevent").html(res);
                            }
                        });
                        $(this).dialog('close');
                    },
                    'Cancel': function () {
                        $(this).dialog('close');
                    }
                }
            });
        }
        $(document).delegate('#reset-btn-id', 'click', function (e) {
            $('#donation-frm-id')[0].reset();
        }).delegate('#Donation_Type', 'change', function (e) {
            var val = $(this).val();

            if (val === '1') {
                $('#hide1').hide();
            } else {
                $('#hide1').show();
            }
        }).delegate('#PaymentOption', 'change', function (e) {
            var val = $(this).val();
            var amount = $("#Amount").val();
            if (amount == "" || amount == " ") {
                alert('please Select Ticket Type');
                $("#ticketday").prop('required', true);
                document.getElementById("PaymentOption").value = "";
                return;
            }
            if (val == 'stripe') {
                debugger;
                $("#others_details").hide();
                $("#stripe_details").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
                $("#MemberID").prop('required',false);
                $('#payment_btn_id').prop('disabled', false);
                 $("#payment_btn_id").removeClass('disabled');
                var elements = stripe.elements();

                var style = {
                    base: {
                        // Add your base input styles here. For example:
                        fontSize: '16px',
                        color: "#32325d",
                    }
                };

                var card = elements.create('card', { style: style });

                card.mount('#card-element');

                card.addEventListener('change', function (event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });


                var form = document.getElementById('donation-frm-id');

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
                // $('#error_code1').html("Step 1 - Send your Zelle payment to treasurer@durgabari.org." + "<br>" + "Step 2 - Click get zelle payment details button." + "<br>" + "Step 3 - Select your payment details from  dropdown.");
                // $("#stripe_details").hide();
                // $("#MemberID1").show();
                //  $("#MemberID").prop('required',true);
                // //$("#others_details").show();
                
                
                // 28 july
                
                let account = document.getElementById("account_type").innerText.trim();
                debugger;

                $('#error_codeimg').empty().hide();
                document.getElementById("error_code1").style.marginLeft = "150px";
                document.getElementById("error_code1").style.paddingTop = "12px";
                document.getElementById("checkPaymentData").style.display = "block";
                document.getElementById("MemberID1").style.display = "block";
                document.getElementById("error_code1").style.display = "block";
                document.getElementById("error_code1").style.color = "#ff0000";
               

                let email_address = ""
                if (account == 'Pujaaccount') {
                    email_address = "treasurerpuja@durgabari.org";

                   
                    // $("#error_code1").html("Step 1 - Without closing this page, open a new web page and go to your Bank’s portal." + "<br>" + "Step 2 - : From the Bank’s portal, send your Zelle payment to   <span style='font-weight: 700; color: #17af22;'>treasurerpuja@durgabari.org </span>. To register HDBS Puja as a new recipient, Name = Houston Durga Bari Society, Email = treasurerpuja@durgabari.org PLEASE DO NOT MAKE PAYMENT TO ANY OTHER ACCOUNT WITH A DIFFERENT EMAIL ADDRESS. This system will not be able to retrieve the payment information in that case." + "<br>" + "Step 3 - Return to this page and click ‘Get Zelle Payment Details’ button." + "<br>" + "Step 4 - Select your payment details from the dropdown (click on ‘Please select your payment details)." + "<br>" + "Step 5 - Make Payment." + "<br>");
                 $("#error_code1").html(`
                           <div style="font-family: Arial, sans-serif; font-size: 14px; line-height: 1.6; color: #333;">
                              <strong>Step 1:</strong> Without closing this page, open a new web page and go to your Bank’s portal.<br><br>

                               <strong>Step 2:</strong> From the Bank’s portal, send your Zelle payment to 
                                       <span style="font-weight: bold; color: #17af22;">treasurerpuja@durgabari.org</span>.<br>
                                                               To register HDBS Puja as a new recipient:<br>
                                                               Name = <strong>Houston Durga Bari Society</strong><br>
                                                               Email = <strong>treasurerpuja@durgabari.org</strong><br>
                                                               
                                             <span style="color: red; font-weight: bold;">
                                                      PLEASE DO NOT MAKE PAYMENT TO ANY OTHER ACCOUNT WITH A DIFFERENT EMAIL ADDRESS.
                                                         This system will not be able to retrieve the payment information in that case.
                                             </span><br><br>

                       <strong>Step 3:</strong> Return to this page and click the 
                       <em>‘Get Zelle Payment Details’</em> button.<br><br>

                        <strong>Step 4:</strong> Select your payment details from the dropdown 
                        (click on ‘Please select your payment details’).<br><br>

                    <strong>Step 5:</strong> Make Payment.
                  </div> `);

                    
                    
                    
                }
                else {
                    email_address = 'treasurer@durgabari.org';
                    $('#error_code1').html(`
                        Step 1 - Send your Zelle payment to treasurer@durgabari.org. <br>
                        Step 2 - Click get Zelle payment details button. <br>
                        Step 3 - Select your payment details from dropdown.
                    `);
                   
                }
                // $('#error_code1').html("Step 1 - Send your Zelle payment to treasurer@durgabari.org." + "<br>" + "Step 2 - Click get zelle payment details button." + "<br>" + "Step 3 - Select your payment details from  dropdown.");
                

                $("#stripe_details").hide();
                $("#MemberID1").show();
                $("#MemberID").prop('required', true);
                //$("#others_details").show();
                
            } else {
                $("#stripe_details").hide();
                $("#others_details").hide();
            }
        }).delegate('#confirm_code', 'change', function (event) {
            debugger;
            var frm = $("#payment-form");
            $("#error_code1").css('display', 'none');
            $("#error_codeimg").css('display', 'none');
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode",
                // url: url + "load.php?controller=GzFront&action=checkCode&cid=" + cal_id + "&account=" + account,
                success: function (res) {
                    debugger;
                    var check = res.includes("Your payment code is matched you can book");

                    if (check == true) {
                        $("#payment_btn_id").removeClass('disabled');
                    } else {
                        $("#payment_btn_id").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
        }).delegate('#checkPaymentData', 'click', function (event) {
            debugger
            var self = this;
            $("#error_code1").css('display', 'none');
            $("#error_codeimg").css('display', 'none');
            var frm = $("#payment-form");
            var cal_id = $("#calendar_id").val();
            $.LoadingOverlay("show");
            //$(".overlay").css('display', 'block');
            //$(".loading-img").css('display', 'block');
            
            let account = document.getElementById("account_type").innerText.trim();
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                // url: url + "load.php?controller=GzFront&action=checkCode&cid=" + cal_id,
                url: url + "load.php?controller=GzFront&action=checkCode&cid=" + cal_id + "&account=" + account,
                success: function (res) {
                    debugger
                    $.LoadingOverlay("hide");
                    //$(".overlay").css('display', 'none');
                    //$(".loading-img").css('display', 'none');
                    var check = res.includes("Your payment code is matched you can book");
                    if (check == true) {


                        $("#details_frm_btn_id").removeClass('disabled');


                    }
                    else {
                        $("#details_frm_btn_id").addClass('disabled');


                    }
                    $('#error_code').html(res);

                }
            });
        }).delegate('#MemberID', 'change', function (event) {
            //debugger
            var dd = $("#MemberID").val();

            var parts = dd.split("/");
            var cmCode = parts[3];
            var name = parts[1];
            var price = parts[2].replace(/ /gi, '').trim();;
            //var newprice = price.replace('$', "");
            var newp =price.replace('$', "");
             var newprice = newp.replace(',','').trim();
            //var totalprice =   $("#total").text();
            var totalprice = $("#totalamount").val();
            var tot = totalprice.replace(/ /gi, '').trim();
            if (cmCode != null) {
                $("#Zellecode").val(cmCode);
            }

            if (tot === newprice) {
                $('#payment_btn_id').prop("disabled", false);
                $("#payment_btn_id").removeClass('disabled');
                //$("#payment_btn_id").removeClass('disabled');
            }
            else {

                $("#payment_btn_id").addClass('disabled');
                alert('Total price and select  price is not same please select correct payment');
            }
            //$.LoadingOverlay("show");

            // $.ajax({
            //     type: "POST",
            //     data: {
            //         code: cmCode
            //     },
            //     url: self.options.server + "load.php?controller=GzFront&action=UpdateCodeData&cid=" + self.options.cal_id,
            //     success: function (res) {
            //         $("#details_frm_btn_id").removeClass('disabled');
            //         $('#error_code').html(res);
            //     }

            // });

        }).delegate("#term1", "keypress", function (e) {
            e.stopImmediatePropagation();
            if (e.keyCode === 13 || e.which === 13) {
                MemberSelect();
            }

            e.preventDefault();
        }).delegate("#term1", "change", function (e) {
            e.stopImmediatePropagation();

            MemberSelect.call(self);
            e.preventDefault();
        }).delegate("#term1", "click", function (e) {
            e.stopImmediatePropagation();

            MemberSelect.call(self);
            e.preventDefault();
        }).delegate('#registrationmember', 'change', function (event) {
            debugger;
            var regmember = $("#registrationmember").val();
            selectVal = $('#registrationmember').val();
            if (selectVal == "member") {
                $("#IDMembertd").removeClass("disabledbutton");
                document.getElementById("demmember").value = "";
                document.getElementById("namenonmember").value = "";
                document.getElementById("Tele1").value = "";
                document.getElementById("Email").value = "";
                document.getElementById("term").value = "";

                $('#nonmembername').hide();
                $('#fieldtest').hide();
                $('#namemeemberregister').show();
                $('#IDMembertd').show();
                $("#namenonmember").prop('required', false);
                $("#term").prop('required', true);
                $("#demmember").prop('required',true); 
            }
            if (selectVal == "nonmember") {
                $("#IDMembertd").addClass("disabledbutton");
                document.getElementById("demmember").value = "";
                document.getElementById("namenonmember").value = "";
                document.getElementById("Tele1").value = "";
                document.getElementById("Email").value = "";
                document.getElementById("term").value = "";
                $('#namemeemberregister').hide();
                $('#IDMembertd').hide();
                $('#nonmembername').show();
                $('#fieldtest').show();
                $("#fieldtest").prop('readonly', true);
                $("#namenonmember").prop('required', true);
                $("#term").prop('required', false);
                $("#demmember").prop('required',false); 

            }
            if (selectVal == "" || selectVal == " ") {
                document.getElementById("demmember").value = "";
                document.getElementById("namenonmember").value = "";
                document.getElementById("Tele1").value = "";
                document.getElementById("Email").value = "";
                document.getElementById("term").value = "";
                $("#IDMembertd").removeClass("disabledbutton");
            }
        });
    });
}(jQuery));
