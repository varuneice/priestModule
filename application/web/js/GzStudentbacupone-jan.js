(function ($) {
    $(function () {
        //debugger;
        var url = $("#container-abc-url-id").text();
     
        var selcetsubj = null;
        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }
        
        function zelleDropDownUpdate() {
            var self = this;
            //debugger
            var frm = $("#payment-form");
            //$.LoadingOverlay("show");
            var cal_id = $("#calendar_id").val();
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCodeDD&cid=" + cal_id,
                success: function (res) {

                    //var myString = res.replace("echo", '');
                    var myString1 = res.replace("", '');
                    //= myString.replace("",'');
                    $('#zelleid').empty(); //remove all child nodes
                    var newOption = $(myString1);
                    var newOption1 = $('<option value="1">Please select your payment details</option>');
                    $('#zelleid').append(newOption1);
                    $('#zelleid').append(newOption);
                    $('#zelleid').trigger("chosen:updated");
                    var dd = $("#zelleid").val();

                    if (dd == "1") {
                        // gz$("#member_btn_id").addClass('disabled');
                        document.getElementById("payment_btn_id").disabled = true;
                    }
                    //  var parts = myString1.split("/"); 
                    //  var cmCode =parts[3];
                }
            });
        }

        function MemberSelect() {
            //debugger
            var self = this;
            var term = $("#termMember").val();
            var data = $("#termMember").val();
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
        //student delete code
        $("#gzhotel-booking-booking-id").delegate('a.icon-delete', 'click', function (e) {
            // debugger;
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#dialogDelete').dialog('open');
        });
        if ($("#dialogDelete").length > 0) {
            // debugger;
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
                                controller: 'Student',
                                action: 'delete'
                            },
                            url: url + "index.php?controller=Student&action=delete",
                            beforeSend: function () {
                                $(".overlay").css('display', 'block');
                                $(".loading-img").css('display', 'block');
                            },
                            success: function (res) {
                                $("#gzhotel-booking-booking-id").html(res);
                                $(".overlay").css('display', 'none');
                                $(".loading-img").css('display', 'none');

                                $('#gzhotel-booking-booking-id').dataTable({
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

        if ($('#MemberID').length > 0) {
            $('#MemberID').selectpicker();
        }



        $(document).delegate('#reset-btn-id', 'click', function (e) {
            $('#new_student')[0].reset();
            $('#edit_student')[0].reset();
        }).delegate('#payment_method', 'change', function (e) {
            var val = $(this).val();
            if (val == 'stripe') {
                $("#others_details").hide();
                $("#stripe_details").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
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


                var form = document.getElementById('new_student');

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
                //debugger
                var elem = document.createElement("img");
                elem.setAttribute("src", "http://localhost/HDBS_Payment/priestModule/zelle.png");
                elem.setAttribute("height", "600");
                elem.setAttribute("width", "600");

                elem.setAttribute("alt", "Flower");
                $('#error_codeimg').html(elem);
                document.getElementById("error_codeimg").style.marginLeft = "260px";
                document.getElementById("error_codeimg").style.marginTop = "30px";
                document.getElementById("error_code1").style.marginLeft = "340px";
                document.getElementById("error_code1").style.paddingTop = "12px";
                document.getElementById("checkPaymentData").style.display = "block";
                document.getElementById("MemberID1").style.display = "block";
                document.getElementById("error_code1").style.display = "block";
                document.getElementById("error_codeimg").style.display = "block";
                document.getElementById("error_code1").style.color = "#ff0000";
                $('#error_code1').html("Step 1 - Send your Zelle payment to treasurer@durgabari.org." + "<br>" + "Step 2 - Click get zelle payment details button." + "<br>" + "Step 3 - Select your payment details from  dropdown.");
                $("#stripe_details").hide();
                $("#MemberID1").show();
                zelleDropDownUpdate.call(self);
                
                //$("#others_details").show();
            } else {
                $("#stripe_details").hide();
                $("#others_details").hide();
            }
        }).delegate('#confirm_code', 'change', function (event) {
            //debugger;
            var frm = $("#payment-form");
            $("#error_code1").css('display', 'none');
            $("#error_codeimg").css('display', 'none');
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode",
                success: function (res) {
                    //debugger;
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
            //debugger
            var self = this;
            $("#error_code1").css('display', 'none');
            $("#error_codeimg").css('display', 'none');
            var frm = $("#payment-form");
            var cal_id = $("#calendar_id").val();
            // $.LoadingOverlay("show");
            $.blockUI();
            //$(".overlay").css('display', 'block');
            //$(".loading-img").css('display', 'block');
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode&cid=" + cal_id,
                success: function (res) {
                    //debugger;
                    $.unblockUI();
                    zelleDropDownUpdate.call(self);
                    //$.LoadingOverlay("hide");
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
        }).delegate('#zelleid', 'change', function (event) {
            //debugger
            var dd = $("#zelleid").val();

            var parts = dd.split("/");
            var cmCode = parts[3];
            var name = parts[1];
            var price = parts[2].replace(/ /gi, '').trim();
            var newprice = price.replace('$', "");
            //var totalprice =   $("#total").text();
            var totalprice = $("#Amount").val();
            var tot = totalprice.replace(/ /gi, '').trim();
            if(cmCode !=null){
                $("#Zellecode").val(cmCode);
                }

            if (tot === newprice) {
                $('#payment_btn_id').prop("disabled", false);
                // $("#payment_btn_id").removeClass('disabled');
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

        }).delegate('#zelleid1', 'click', function (event) {
            var self = this;
            //debugger
            var frm = $("#payment-form");
            //$.LoadingOverlay("show");
            var cal_id = $("#calendar_id").val();
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCodeDD&cid=" + cal_id,
                success: function (res) {

                    //var myString = res.replace("echo", '');
                    var myString1 = res.replace("", '');
                    //= myString.replace("",'');
                    $('#zelleid').empty(); //remove all child nodes
                    var newOption = $(myString1);
                    var newOption1 = $('<option value="1">Please select your payment details</option>');
                    $('#zelleid').append(newOption1);
                    $('#zelleid').append(newOption);
                    $('#zelleid').trigger("chosen:updated");
                    var dd = $("#zelleid").val();

                    if (dd == "1") {
                        // gz$("#member_btn_id").addClass('disabled');
                        document.getElementById("payment_btn_id").disabled = true;
                    }
                    //  var parts = myString1.split("/"); 
                    //  var cmCode =parts[3];
                }
            });

        }).delegate('#confirm_code', 'change', function (event) {
            var frm = $("#new_student");

            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode",
                success: function (res) {
                    var check = res.includes("Your payment code is matched you can book");

                    if (check == true) {
                        $("#payment_btn_id").prop("disabled", false);
                        $("#payment_btn_id").removeClass('disabled');
                    } else {
                        $("#payment_btn_id").prop("disabled", true);
                        $("#payment_btn_id").addClass('disabled');
                    }
                    $('#error_code').html(res);
                }
            });
        }).delegate("#term1", "change", function (e) {

            e.preventDefault();
            MemberSelect.call(self);

        }).delegate("#term1", "click", function (e) {

            e.preventDefault();
            MemberSelect.call(self);
        }).delegate("#term1", "keyup", function (e) {

            e.preventDefault();
            MemberSelect.call(self);
        }).delegate('#registrationtype', 'change', function (event) {
            //debugger;
            var regtype = $("#registrationtype").val();
            document.getElementById("fee").value = "";
            document.getElementById("Amount").value = "";
            if (regtype == "workshops" || regtype == "library") {
                //$("#type").prop('readonly', true);
                $("#typecheck").prop('required', false);
                $("#type1").prop('required', false);
                document.getElementById('allsubject').style.display = 'none';
                $('#subjectrow').hide();
                //document.getElementById('type1').style.display = 'none';
            } else {
                document.getElementById('allsubject').style.removeProperty('display');
                $('#subjectrow').show();
                //document.getElementById('type1').style.removeProperty('display');
            }

            $.ajax({
                type: "POST",
                data: {
                    regtype: regtype
                },
                url: url + "load.php?controller=Student&action=subjectsstudent",
                success: function (res) {

                    //debugger;
                    $('#typecheck').empty(); //remove all child nodes
                    $('#type1').empty();  //remove all child nodes
                    var newOption = $(res);
                    var secondOption = $(res);
                    $('#typecheck').append(newOption);
                    $('#typecheck').trigger("chosen:updated");
                    $('#type1').append(secondOption);
                    $('#type1').trigger("chosen:updated");
                    $('#registrationmember').change();
                }
            });
        });
    }).delegate("#typecheck", "change", function (e) {
        debugger;
        e.stopImmediatePropagation();
        var typemember = $("#registrationmember").val();
        var regtype = $("#registrationtype").val();
        var typec = $("#typecheck").val();
        let date =  new Date().getFullYear();
        let latefeedate= '31'+'/03/'+date;
        let currentdaydate = formatDate(new Date());
         if(typec == ""){
             document.getElementById("Amount").value = "";
           
         }
         if (regtype = "" || typemember == "") {
            alert("Please Select Registration Type/ Member Type First");
            return false;
         }
        //e.stopImmediatePropagation();
        var selected = [];
        for (var option of document.getElementById('typecheck').options) {
            if (option.selected) {
                selected.push(option.value);
            }
        }
        selcetsubj = selected;
        var retype = $("#registrationtype").val();
        var dd2 = $("#type1").val();
        if (retype == 'BanglaSchool') {
            if (selcetsubj.length > 1) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            if (selcetsubj.length > 2) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        var cat = $("#cattype").val();
        var price = $("#fee").val();
        if (dd2 == "") {

            var test =document.getElementById("typecheck").value;
            if (selcetsubj.length > 1 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
              if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    // Avinash new code for late fee
                    var courceCount = selcetsubj.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }

                //document.getElementById("Amount").value = totalprice;
              
            }
            else if (selcetsubj.length > 0 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;

                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = selcetsubj.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
                //document.getElementById("Amount").value = totalprice;
             
            }
        } else {
            var newsubjectrec = selcetsubj.concat(subjectsecond);
            if (selcetsubj.length > 1 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = selcetsubj.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
                //document.getElementById("Amount").value = totalprice;
                
            }
            else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;

                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = selcetsubj.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
                //document.getElementById("Amount").value = totalprice;
              
            }
            else if (newsubjectrec.length > 3) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = newsubjectrec.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
               // document.getElementById("Amount").value = totalprice;
               

            }
            else if (newsubjectrec.length > 2) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = newsubjectrec.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
                //document.getElementById("Amount").value = totalprice;
             
            }
            else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
                var totalsub = selcetsubj.concat(subjectsecond);
                var courceCount = totalsub.length
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = totalsub.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
                //document.getElementById("Amount").value = totalprice;
              
            }
        }



    }).delegate("#typecheck", "click", function (e) {
       debugger;
        e.stopImmediatePropagation();
        var typemember = $("#registrationmember").val();
        var regtype = $("#registrationtype").val();
        var typec = $("#typecheck").val();
        let date =  new Date().getFullYear();
        let latefeedate= '31'+'/03/'+date;
        let currentdaydate = formatDate(new Date());
         if(typec == ""){
             document.getElementById("Amount").value = "";
           
         }
         if (regtype = "" || typemember == "") {
            alert("Please Select Registration Type/ Member Type First");
            return false;
         }
        //e.stopImmediatePropagation();
        var selected = [];
        for (var option of document.getElementById('typecheck').options) {
            if (option.selected) {
                selected.push(option.value);
            }
        }
        selcetsubj = selected;
        var retype = $("#registrationtype").val();
        var dd2 = $("#type1").val();
        if (retype == 'BanglaSchool') {
            if (selcetsubj.length > 1) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            if (selcetsubj.length > 2) {
                selcetsubj.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        var cat = $("#cattype").val();
        var price = $("#fee").val();
        if (dd2 == "") {

            var test =document.getElementById("typecheck").value;
            if (selcetsubj.length > 1 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
              if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = selcetsubj.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }

                //document.getElementById("Amount").value = totalprice;
              
            }
            else if (selcetsubj.length > 0 && dd2 == "") {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;

                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = selcetsubj.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
                //document.getElementById("Amount").value = totalprice;
             
            }
        } else {
            var newsubjectrec = selcetsubj.concat(subjectsecond);
            if (selcetsubj.length > 1 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = selcetsubj.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
                //document.getElementById("Amount").value = totalprice;
                
            }
            else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
                var courceCount = selcetsubj.length;
                var amount = courceCount * price;
                var totalprice = amount;

                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = selcetsubj.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
                //document.getElementById("Amount").value = totalprice;
              
            }
            else if (newsubjectrec.length > 3) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
               if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = newsubjectrec.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
                //document.getElementById("Amount").value = totalprice;
               

            }
            else if (newsubjectrec.length > 2) {
                var courceCount = newsubjectrec.length;
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = newsubjectrec.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }

                //document.getElementById("Amount").value = totalprice;
             
            }
            else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
                var totalsub = selcetsubj.concat(subjectsecond);
                var courceCount = totalsub.length
                var amount = courceCount * price;
                if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }

                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = totalsub.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
                //document.getElementById("Amount").value = totalprice;
              
             }
        }

}).delegate("#SecondStudentName", "keyup", function (e) {
           e.stopImmediatePropagation();

         var stu2 = $("#SecondStudentName").val();
        //  var schoolregisternew = $("#registrationtype").val();
        //  if (schoolregisternew == "Kalabhavan" || schoolregisternew == "BanglaSchool") {
        //     if (studentFirst != "" && studentSecond == "") {
        //         document.getElementById("type1").value = "";
        //     }}
        let date =  new Date().getFullYear();
        let latefeedate= '31'+'/03/'+date;
        let currentdaydate = formatDate(new Date());

        var first = $("#FirstStudentName").val();
        if(first == "" || first == null){
            alert("Please fill First Student Name first");
            $("#SecondStudentName").val('');
            return;
        }
        
        if ($(this).val().length != 0) {
            //debugger;
            $('#type1').attr('disabled', false);
            var schoolregister = $("#registrationtype").val();
            var amountfee = $("#fee").val();
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();

            
            if (schoolregister == "workshops" || schoolregister == "library") {
                if (studentFirst.trim() != "" && studentSecond.trim() != "") {

                    var tot = amountfee;
                    var amount = tot * 2;
                    var totalprice = amount;
                    document.getElementById("Amount").value = totalprice;
                    
                }
                
                 e.stopImmediatePropagation();
                
            }
            

        }
        else {
          
            $('#type1').attr('disabled', true);
            var schoolregistercheck = $("#registrationtype").val();
            var stu1 = $("#FirstStudentName").val();
            var stu2 = $("#SecondStudentName").val();
            var getvalueseconddubject = $("#type1").val();
            var getvaluefirstdubject = $("#typecheck").val();
            var amountfeenew = $("#fee").val(); 
             var cat = $("#cattype").val();
            if (schoolregistercheck == "BanglaSchool"){
                if((stu1.trim() !="") && (stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    // if(currentdaydate < latefeedate){ 

                    //     document.getElementById("Amount").value = amountfeenew + 10;
                    //  }
                    //  else{
                    //     document.getElementById("Amount").value = amountfeenew;
                    //  }
                    document.getElementById("Amount").value = amountfeenew;  
                }
                
              }

              if (schoolregistercheck == "Kalabhavan"){
                if((stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    var len = getvaluefirstdubject.length;
                    if(len == 2){
                    var getvaluefirstdubject = amountfeenew * 2
                   if(cat=="GD" || cat=="GC"){
                     var discountprice =  getvaluefirstdubject;
                    }else{
                    var discountprice =  getvaluefirstdubject - 10;
                    }
                    
                    document.getElementById("Amount").value = discountprice;   
                     
                    }else{
                        document.getElementById("Amount").value = amountfeenew;  
                    }
                    
                }
              }
         if (schoolregistercheck == "workshops" || schoolregistercheck == "library"){
            if(stu1!=""){
                document.getElementById("Amount").value = amountfeenew;

            }
         }
        }
    }).delegate("#SecondStudentName", "click", function (e) {
       debugger
       var amountfee = $("#fee").val();
        e.stopImmediatePropagation();
         var stu2 = $("#SecondStudentName").val();
         let date =  new Date().getFullYear();
         let latefeedate= '31'+'/03/'+date;
         let currentdaydate = formatDate(new Date());

        //  if(stu2==""){
        //      document.getElementById("Amount").value = "";
        //       // $("#FirstStudentName").val("");
        //  }
        // var schoolregisternew = $("#registrationtype").val();
        // if (schoolregisternew == "Kalabhavan" || schoolregisternew == "BanglaSchool") {
        //    if (studentFirst != "" && studentSecond == "") {
        //        document.getElementById("type1").value = "";
        //    }}
        if ($(this).val().length != 0) {
            //debugger;
            $('#type1').attr('disabled', false);
            var schoolregister = $("#registrationtype").val();
            var amountfee = $("#fee").val();
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();


            if (schoolregister == "workshops" || schoolregister == "library") {
                if (studentFirst.trim() != "" && studentSecond.trim() != "") {

                    var tot = amountfee;
                    var amount = tot * 2;
                    var totalprice = amount;
                    document.getElementById("Amount").value = totalprice;
                }
                
                    
                
            }

        }
        else {
            $('#type1').attr('disabled', true);
            var stu1 = $("#FirstStudentName").val();
            var stu2 = $("#SecondStudentName").val();
            var schoolregistercheck = $("#registrationtype").val();
            var amountfeenew = parseInt($("#fee").val());
            var getvalueseconddubject = $("#type1").val();
            var getvaluefirstdubject = $("#typecheck").val();
             var cat = $("#cattype").val()
            if (schoolregistercheck == "BanglaSchool"){
                if((stu1.trim() !="") && (stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    document.getElementById("Amount").value = amountfeenew;  
                }
              }

              if (schoolregistercheck == "Kalabhavan"){
                if((stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    var len = getvaluefirstdubject.length;
                    if(len == 2){
                    var getvaluefirstdubject = amountfeenew * 2
                   if(cat=="GD" || cat=="GC"){
                     var discountprice =  getvaluefirstdubject;
                    }else{
                    var discountprice =  getvaluefirstdubject - 10;
                    }
                    //document.getElementById("Amount").value = discountprice;  
                    if(currentdaydate < latefeedate){ 
                        var courceCount = getvaluefirstdubject.length;
                        var totallatefee =  courceCount * 10;
                        document.getElementById("Amount").value = discountprice + totallatefee;
                     }
                     else{
                        document.getElementById("Amount").value = discountprice;
                     } 
                    }else{
                        //document.getElementById("Amount").value = amountfeenew; 
                        if(currentdaydate < latefeedate){ 
                            var courceCount = getvaluefirstdubject.length;
                            var totallatefee =  courceCount * 10;
                            document.getElementById("Amount").value = amountfeenew + totallatefee;
                         }
                         else{
                            document.getElementById("Amount").value = amountfeenew;
                         } 
                    }
                    
                }
              }
             if (schoolregistercheck == "workshops" || schoolregistercheck == "library"){
                //debugger;
                if(stu1.trim() !=""){
                    document.getElementById("Amount").value = amountfeenew;
                }
             }
        }
        e.preventDefault();
    }).delegate("#SecondStudentName", "change", function (e) {
        //debugger;
       var stu2 = $("#SecondStudentName").val();
       var amountfee = $("#fee").val();
        let date =  new Date().getFullYear();
        let latefeedate= '31'+'/03/'+date;
        let currentdaydate = formatDate(new Date());
        e.stopImmediatePropagation();
        var first = $("#FirstStudentName").val();
       
        if(first == "" || first == null){
            alert("Please fill First Student Name first");
            $("#SecondStudentName").val('');
            return;
        }
        //if (first.trim() = "") {
        //   alert("Please fill first student name.");
        //}
        var fname = first.replace(/^\s+|\s+$/gm,'');
        if (fname= "") {
           alert("Please fill first student name.");
        }
        
        
        

        if ($(this).val().length != 0) {
            //debugger;
            $('#type1').attr('disabled', false);
            var schoolregister = $("#registrationtype").val();
            var amountfee = parseInt($("#fee").val());
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();

            var second = $("#SecondStudentName").val();
            if (second.trim() == "") {

                document.getElementById("Amount").value = "";

            }
            if (schoolregister == "workshops" || schoolregister == "library") {
                if (studentFirst.trim() != "" && studentSecond.trim() != "") {

                    var tot = amountfee;
                    var amount = tot * 2;
                    var totalprice = amount;
                    document.getElementById("Amount").value = totalprice;
                }
                
                
            }

        }
        else {
           // debugger;
            $('#type1').attr('disabled', true);
            var stu1 = $("#FirstStudentName").val();
            var stu2 = $("#SecondStudentName").val();
            var schoolregistercheck = $("#registrationtype").val();
            var amountfeenew = parseInt($("#fee").val());
            var getvalueseconddubject = $("#type1").val();
            var getvaluefirstdubject = $("#typecheck").val();
             var cat = $("#cattype").val();
            if (schoolregistercheck == "BanglaSchool"){
                if((stu1.trim() !="") && (stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    document.getElementById("Amount").value = amountfeenew;  
                }
              }

              if (schoolregistercheck == "Kalabhavan"){
                //debugger;
                if((stu2.trim() =="")){
                    document.getElementById("type1").value = "";
                    var len = getvaluefirstdubject.length;
                    if(len == 2){
                    var getvaluefirstdubject = amountfeenew * 2
                     if(cat=="GD" || cat=="GC"){
                     var discountprice =  getvaluefirstdubject;
                    }else{
                    var discountprice =  getvaluefirstdubject - 10;
                    }
                    //document.getElementById("Amount").value = discountprice;
                    if(currentdaydate < latefeedate){ 
                        var courceCount = getvaluefirstdubject.length;
                        var totallatefee =  courceCount * 10;
                        document.getElementById("Amount").value = discountprice + totallatefee;
                     }
                     else{
                        document.getElementById("Amount").value = discountprice;
                     }
                    
                    }else{
                        //document.getElementById("Amount").value = amountfeenew;  
                        if(currentdaydate < latefeedate){ 
                            var courceCount = getvaluefirstdubject.length;
                            var totallatefee =  courceCount * 10;
                            document.getElementById("Amount").value = amountfeenew + totallatefee;
                         }
                         else{
                            document.getElementById("Amount").value = amountfeenew;
                         }
                    }
                    
                }
              }
             if (schoolregistercheck == "workshops" || schoolregistercheck == "library"){
                //debugger;
                if(stu1.trim() !=""){
                    document.getElementById("Amount").value = amountfeenew;
                }
             }
        }
        e.preventDefault();
    }).delegate("#FirstStudentName", "click", function (e) {
        e.preventDefault();
        var schoolregister = $("#registrationtype").val();
        var amountfee = $("#fee").val();
        var studentSecond = $("#SecondStudentName").val();
        var studentFirst = $("#FirstStudentName").val();



        if ((schoolregister == "workshops" || schoolregister == "library")) {
            if (studentFirst.trim() != "" && studentSecond.trim() == "") {
                document.getElementById("Amount").value = amountfee;
            }
        }
        e.preventDefault();
    }).delegate("#FirstStudentName", "change", function (e) {
        e.stopImmediatePropagation();
        var stu1 = $("#FirstStudentName").val();
         if(stu1.trim() ==""){
             document.getElementById("Amount").value = "";
         }
        //debugger;
        var regtype = $("#registrationtype").val();
        var typemember = $("#registrationmember").val();
        if (regtype.trim() == "" || typemember.trim() == "") {
            alert("Please Select Registration Type/ Member Type First");
            return false;

        } else {

            var schoolregister = $("#registrationtype").val();
            var amountfee = $("#fee").val();
            var studentSecond = $("#SecondStudentName").val();
            var studentFirst = $("#FirstStudentName").val();



            if ((schoolregister == "workshops" || schoolregister == "library")) {
                if (studentFirst.trim() != "" && studentSecond.trim() == "") {
                    document.getElementById("Amount").value = amountfee;
                }
            }
        }
        e.preventDefault();
       
    }).delegate("#type1", "change", function (e) {
       
        var typemember = $("#registrationmember").val();
         var type = $("#type1").val();
         if(type==""){
             document.getElementById("Amount").value = "";
         }
 

        var selected1 = [];
        for (var option of document.getElementById('type1').options) {
            if (option.selected) {
                selected1.push(option.value);
            }
        }
        subjectsecond = selected1;
 //alert(subjectsecond);
 // alert(selected1);
        var retype = $("#registrationtype").val();
        //debugger;
        if (retype == 'BanglaSchool') {
              
            if (subjectsecond.length > 1) {
               
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            
            if (subjectsecond.length > 2) {
                 
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }

        //debugger;
        var newsubjectrec = selcetsubj.concat(subjectsecond);
        var price = $("#fee").val();
        var cat = $("#cattype").val();
        if (selcetsubj.length > 1 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                let date =  new Date().getFullYear();
                let latefeedate= '31'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = selcetsubj.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
           // document.getElementById("Amount").value = totalprice;
            
        }
        else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
            var totalprice = amount;
            let date =  new Date().getFullYear();
            let latefeedate= '31'+'/03/'+date;
            let currentdaydate = formatDate(new Date());
            if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                var courceCount = selcetsubj.length;
                var totallatefee =  courceCount * 10;
                document.getElementById("Amount").value = totalprice + totallatefee;
             }
             else{
                document.getElementById("Amount").value = totalprice;
             }
            //document.getElementById("Amount").value = totalprice;
           
        }
        else if (newsubjectrec.length > 3) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                let date =  new Date().getFullYear();
                let latefeedate= '31'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = newsubjectrec.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
            //document.getElementById("Amount").value = totalprice;
         

        }
        else if (newsubjectrec.length > 2) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                let date =  new Date().getFullYear();
                let latefeedate= '31'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = newsubjectrec.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
            //document.getElementById("Amount").value = totalprice;
        
        }
        else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
            var totalsub = selcetsubj.concat(subjectsecond);
            var courceCount = totalsub.length
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                let date =  new Date().getFullYear();
                let latefeedate= '31'+'/03/'+date;
                let currentdaydate = formatDate(new Date());
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = totalsub.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
            //document.getElementById("Amount").value = totalprice;
          
        }


    }).delegate("#type1", "click", function (e) {
       
        var typemember = $("#registrationmember").val();
         var type = $("#type1").val();
         let date =  new Date().getFullYear();
         let latefeedate= '31'+'/03/'+date;
         let currentdaydate = formatDate(new Date());

         if(type==""){
             document.getElementById("Amount").value = "";
         }
 

        var selected1 = [];
        for (var option of document.getElementById('type1').options) {
            if (option.selected) {
                selected1.push(option.value);
            }
        }
        subjectsecond = selected1;
 //alert(subjectsecond);
 // alert(selected1);
        var retype = $("#registrationtype").val();
        //debugger;
        if (retype == 'BanglaSchool') {
              
            if (subjectsecond.length > 1) {
               
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only one subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }
        if (retype == 'Kalabhavan') {
            
            if (subjectsecond.length > 2) {
                 
                subjectsecond.splice(-1);
                $(this).val(last_valid_selection);
                alert("Please Select only two subject");
            } else {
                last_valid_selection = $(this).val();
            }
        }

        //debugger;
        var newsubjectrec = selcetsubj.concat(subjectsecond);
        var price = $("#fee").val();
        var cat = $("#cattype").val();
        if (selcetsubj.length > 1 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = selcetsubj.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
            //document.getElementById("Amount").value = totalprice;
            
        }
        else if (selcetsubj.length > 0 && subjectsecond.length == 0) {
            var courceCount = selcetsubj.length;
            var amount = courceCount * price;
            var totalprice = amount;
            if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 

                document.getElementById("Amount").value = totalprice + 10;
             }
             else{
                document.getElementById("Amount").value = totalprice;
             }
            //document.getElementById("Amount").value = totalprice;
           
        }
        else if (newsubjectrec.length > 3) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 20;
                }
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = newsubjectrec.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
            //document.getElementById("Amount").value = totalprice;
         

        }
        else if (newsubjectrec.length > 2) {
            var courceCount = newsubjectrec.length;
            var amount = courceCount * price;
            if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = newsubjectrec.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
            //document.getElementById("Amount").value = totalprice;
        
        }
        else if (selcetsubj.length > 0 && subjectsecond.length > 0) {
            var totalsub = selcetsubj.concat(subjectsecond);
            var courceCount = totalsub.length
            var amount = courceCount * price;
           if(cat=="GD" || cat=="GC"){
                    var totalprice = amount;
                }else{
                    var totalprice = amount - 10;
                }
                if(currentdaydate < latefeedate && retype == 'Kalabhavan'){ 
                    var courceCount = totalsub.length;
                    var totallatefee =  courceCount * 10;
                    document.getElementById("Amount").value = totalprice + totallatefee;
                 }
                 else{
                    document.getElementById("Amount").value = totalprice;
                 }
            //document.getElementById("Amount").value = totalprice;
          
        }


    }).delegate('#registrationmember', 'change', function (event) {
        debugger;
        //var regmember = $("#registrationmember").val();
        var typeregistration = $("#registrationtype").val();
         var schoolregister = $("#registrationtype").val();
        if (schoolregister == "workshops" || schoolregister == "library") {
            $("#SecondStudentName").val('');
            $("#FirstStudentName").val('');
        }
        selectVal = $('#registrationmember').val();
        if (selectVal == "member") {
            $("#IDMembertd").removeClass("disabledbutton");
            document.getElementById("Amount").value = "";
             document.getElementById("FirstStudentName").value = "";
             document.getElementById("SecondStudentName").value = "";
            document.getElementById("type1").value = "";
            document.getElementById("typecheck").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("demmember").value = "";
            document.getElementById("Your_E-mail").value = "";
            document.getElementById("Your_Number").value = "";
            document.getElementById("term").value = "";
            document.getElementById("termMember").value = "";
             document.getElementById("cattype").value = "";
            $('#nonmembername').hide();
            $('#fieldtest').hide();
            $('#namemeemberregister').show();
            $('#IDMembertd').show();
            $("#namenonmember").prop('required',false);
             $("#term").prop('required',true);
            $("#demmember").prop('required',true);
          
        }
      //FirstStudentName
        if (selectVal == "nonmember") {
            $("#IDMembertd").addClass("disabledbutton");
            document.getElementById("Amount").value = "";
             document.getElementById("FirstStudentName").value = "";
             document.getElementById("SecondStudentName").value = "";
            document.getElementById("type1").value = "";
            document.getElementById("typecheck").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("demmember").value = "";
            document.getElementById("Your_E-mail").value = "";
            document.getElementById("Your_Number").value = "";
            document.getElementById("term").value = "";
            document.getElementById("termMember").value = "";
              document.getElementById("cattype").value = "";
            //$('#IDMembertd').find(':input').prop("disabled", true);
             $('#namemeemberregister').hide();
            $('#IDMembertd').hide();
            $('#nonmembername').show();
            $('#fieldtest').show();
            $("#fieldtest").prop('readonly',true);
            $("#namenonmember").prop('required',true);
             $("#term").prop('required',false);
            $("#demmember").prop('required',false);
           
        }
        if (selectVal.trim() == "" ) {
            $("#IDMembertd").removeClass("disabledbutton");
            document.getElementById("Amount").value = "";
            document.getElementById("type1").value = "";
            document.getElementById("typecheck").value = "";
            document.getElementById("namenonmember").value = "";
            document.getElementById("demmember").value = "";
            document.getElementById("Your_E-mail").value = "";
            document.getElementById("Your_Number").value = "";
            document.getElementById("term").value = "";
            document.getElementById("termMember").value = ""; 
              document.getElementById("cattype").value = "";
            document.getElementById("FirstStudentName").value = "";
            document.getElementById("SecondStudentName").value = "";
          
        }
       
        $.blockUI();
        // $.LoadingOverlay("show");
        var url = $("#container-abc-url-id").text();
        $.ajax({
            type: "POST",
            data: {
                regmember: selectVal,
                typeregistration: typeregistration,
            },
            url: url + "load.php?controller=Student&action=feeprice&cid=regmember",
            success: function (res) {
                //  $.LoadingOverlay("hide");
                $.unblockUI();
                //debugger;
                $('#fee').empty(); //remove all child nodes
                var feenewOption = $(res);
                $('#fee').append(feenewOption);
                $('#fee').trigger("chosen:updated");
                $('#FirstStudentName').click();
                $('#SecondStudentName').click();
            }
        });
    }).delegate('#IDMember22', 'change', function (event) {
        //debugger; 
        var Memberid = $("#IDMember22").val();
        var url = $("#container-abc-url-id").text();
        if ((Memberid != "GD") && (Memberid != "")) {
            $.ajax({
                type: "POST",
                data: {
                    memberid: Memberid
                },
                //url: url  +"load.php?controller=Member&action=AllMember",
                url: url + "load.php?controller=Student&action=AllMember",
                success: function (res) {
                    //debugger;
                    let memberid = "";
                    const memberElement = $(res).filter("input#memberid");
                    if (memberElement.length) {
                        memberid = memberElement[0].value;
                    }
                    document.getElementById("demmember").value = memberid;


                    let phoneNo = "";
                    const phoneNoElement = $(res).filter("input#Tele1");
                    if (phoneNoElement.length) {
                        phoneNo = phoneNoElement[0].value;
                    }
                    document.getElementById("Your_Number").value = phoneNo;

                    let email = "";
                    const emailElement = $(res).filter("input#email");
                    if (emailElement.length) {
                        email = emailElement[0].value;
                    }
                    document.getElementById("Your_E-mail").value = email;

                }
            });
        } else {
            $("#MemberName").val("");
            $("#phone").val("");
            $("#email").val("");

        }
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