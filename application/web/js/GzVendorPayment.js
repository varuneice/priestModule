(function ($) {
    $(function () {
        var url = $("#container-abc-url-id").text();

        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }

        
        if ($('#vendor_tab_data').length > 0) {
            $('#vendor_tab_data').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }
        $(document).delegate('#reset-btn-id', 'click',  function (e) {
             $('#donation-frm-id')[0].reset();
        }).delegate('a.icon-delete', 'click', function (e) {
            debugger;
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#cat_id').text($(this).attr('cat'));
            $('#dialogDelete').dialog('open');
        }).delegate('#payment_method', 'change', function (e) {
            var val = $(this).val();

            if (val == 'stripe') {
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


                var form = document.getElementById('edit_vendoruserdata');

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
                // var elem = document.createElement("img");
                //     elem.setAttribute("src", "http://localhost/HDBS_Payment/priestModule/zelle.png");
                //     elem.setAttribute("height", "600");
                //     elem.setAttribute("width", "600");

                //     elem.setAttribute("alt", "Flower");
                //     $('#error_codeimg').html(elem);
                //     document.getElementById("error_codeimg").style.marginLeft = "63px";
                //     document.getElementById("error_codeimg").style.marginTop = "30px";
                //     document.getElementById("error_code1").style.marginLeft = "163px";
                //     document.getElementById("error_code1").style.paddingTop = "12px";
                //     document.getElementById("checkPaymentData").style.display = "block";
                //     document.getElementById("MemberID1").style.display = "block";
                //     document.getElementById("error_code1").style.display = "block";
                //     document.getElementById("error_codeimg").style.display = "block";
                //     $('#error_code1').html("Step 1 - Send your Zelle payment to treasurer@durgabari.org;" + "<br>" + "Step 2 - Click get zelle payment details button."+ "<br>" + "Step 3 - Select your payment details from  dropdown.");
                // $("#stripe_details").hide();
                // $("#MemberID1").show();
                //  $("#MemberID").prop('required',true);
                // //$("#others_details").show();
                
                
                let account = document.getElementById("account_type").innerText.trim();

                if(!(account == 'Pujaaccount'))
                {
                    var elem = document.createElement("img");
                    elem.setAttribute("src", url + "zelle.png");
                    elem.setAttribute("height", "600");
                    elem.setAttribute("width", "600");
    
                    elem.setAttribute("alt", "Flower");

                }

                $('#error_codeimg').html(elem);
                document.getElementById("error_codeimg").style.marginLeft = "58px";
                document.getElementById("error_codeimg").style.marginTop = "30px";
                document.getElementById("error_code1").style.marginLeft = "150px";
                document.getElementById("error_code1").style.paddingTop = "12px";
                document.getElementById("checkPaymentData").style.display = "block";
                document.getElementById("MemberID1").style.display = "block";
                document.getElementById("error_code1").style.display = "block";
                document.getElementById("error_codeimg").style.display = "block";
                document.getElementById("error_code1").style.color = "#ff0000";
               

                let email_address = ""
                if (account == 'Pujaaccount') {
                    email_address = "treasurerpuja@durgabari.org";

                   
                    $("#error_code1").html("Step 1 - Without closing this page, open a new web page and go to your Bank’s portal." + "<br>" + "Step 2 - : From the Bank’s portal, send your Zelle payment to   <span style='font-weight: 700; color: #17af22;'>treasurerpuja@durgabari.org </span>. To register HDBS Puja as a new recipient, Name = Houston Durga Bari Society, Email = treasurerpuja@durgabari.org PLEASE DO NOT MAKE PAYMENT TO ANY OTHER ACCOUNT WITH A DIFFERENT EMAIL ADDRESS. This system will not be able to retrieve the payment information in that case." + "<br>" + "Step 3 - Return to this page and click ‘Get Zelle Payment Details’ button." + "<br>" + "Step 4 - Select your payment details from the dropdown (click on ‘Please select your payment details)." + "<br>" + "Step 5 - Make Payment." + "<br>");
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
        }).delegate('#checkPaymentData', 'click', function (event) {
            //debugger
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
                // url: url + "load.php?controller=GzFront&action=checkCode&cid="  + cal_id,
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
        }).delegate('#MemberID', 'click', function (event) {
            var self = this;
           //debugger
            var frm = $("#payment-form");
            //$.LoadingOverlay("show");
            var cal_id = $("#calendar_id").val();
             let account = document.getElementById("account_type").innerText.trim();
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                // url: url + "load.php?controller=GzFront&action=checkCodeDD&cid=" + cal_id,
                url: url + "load.php?controller=GzFront&action=checkCodeDD&cid=" + cal_id + "&account=" + account,
                success: function (res) {
                    
                    //var myString = res.replace("echo", '');
                    var myString1 = res.replace("", '');
                    //= myString.replace("",'');
                    $('#MemberID').empty(); //remove all child nodes
                    var newOption = $(myString1);
                    var newOption1 = $('<option value="1">Please select your payment details</option>');
                    $('#MemberID').append(newOption1);
                    $('#MemberID').append(newOption);
                    $('#MemberID').trigger("chosen:updated");
                    var dd = $("#MemberID").val();
                   
                    if (dd == "1") {
                      // gz$("#member_btn_id").addClass('disabled');
                      document.getElementById("payment_btn_id").disabled = true;
                    }
                    //  var parts = myString1.split("/"); 
                    //  var cmCode =parts[3];
                }
            });

        }).delegate('#MemberID', 'change', function (event) {
            debugger
            var dd = $("#MemberID").val();
          
            var parts = dd.split("/");
            var cmCode = parts[3];
            var name =parts[1];
            var price =parts[2].replace(/ /gi,'').trim();;
            var newprice =price.replace('$', "");
            //var totalprice =   $("#total").text();
            var totalprice =   $("#totalitemcost").val();
            var tot = totalprice.split(".")
            var finaltotal = tot[0];
            //var tot = totalprice.replace(/ /gi,'').trim();
          
           if(cmCode !=null){
                $("#Zellecode").val(cmCode);
                }
            
                    if(finaltotal===newprice){
                         $('#payment_btn_id').prop("disabled", false);
                         $("#payment_btn_id").removeClass('disabled');
                    }
                    else{
                      
                        $("#payment_btn_id").addClass('disabled');
                        alert('Total price and select  price is not same please select correct payment');
                    }

        }).delegate('#registrationmember', 'change', function (event) {
            debugger;
            var regmember = $("#registrationmember").val();
            selectVal = $('#registrationmember').val();
            if (selectVal == "member") {
                $("#IDMembertd").removeClass("disabledbutton");
                document.getElementById("spousename").value = "";
                document.getElementById("Street").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = "";city
                document.getElementById("state").value = "";state
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("namenonmember").value = "";
				document.getElementById("term").value = "";
                document.getElementById("demmember").value = "";
                 $('#nonmembername').hide();
                $('#fieldtest').hide();
                $('#namemeemberregister').show();
                $('#IDMembertd').show();
                $("#namenonmember").prop('required',false);
                $("#term").prop('required',true); 
    
            }
            if (selectVal == "nonmember"){
                $("#IDMembertd").addClass("disabledbutton");
                document.getElementById("spousename").value = "";
                document.getElementById("Street").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = "";city
                document.getElementById("state").value = "";state
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("namenonmember").value = "";
				document.getElementById("term").value = "";
                document.getElementById("demmember").value = "";
                 $('#namemeemberregister').hide();
                $('#IDMembertd').hide();
                $('#nonmembername').show();
                $('#fieldtest').show();
                $("#fieldtest").prop('readonly',true);
                $("#namenonmember").prop('required',true);
                $("#term").prop('required',false);
             
            }
            if(selectVal == "" || selectVal == " ") {
                document.getElementById("demmember").value = "";
                document.getElementById("spousename").value = "";
                document.getElementById("Street").value = "";
                document.getElementById("ressidentalAddress").value = "";
                document.getElementById("city").value = "";city
                document.getElementById("state").value = "";state
                document.getElementById("zip_code").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("namenonmember").value = "";
				document.getElementById("term").value = "";
                $("#IDMembertd").removeClass("disabledbutton");
            }
            
        }).delegate('#checkamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var checkamount = ($("#checkamount").val() * 1);
            var finalprice = ($("#totalamount").val() * 1);
            if( finalprice != checkamount ){
                alert('Check amount and total price not same please select correct payment');
                $("#submit").addClass('disabled');
            }
            else{
                $("#submit").removeClass('disabled');
            }
        }).delegate('#cashamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var cashamount = ($("#cashamount").val() * 1);
            var finalprice = ($("#totalamount").val() * 1);
            if( finalprice != cashamount ){
                alert('Cash amount and total price not same please select correct payment');
                $("#submit").addClass('disabled');
            }
            else{
                $("#submit").removeClass('disabled');
            }
        }).delegate('#directamount', 'change', function (e) {
            e.stopImmediatePropagation();
            debugger;
            var directdepositamount = ($("#directamount").val() * 1);
            var finalprice = ($("#totalamount").val() * 1);
            if( finalprice != directdepositamount ){
                alert('Direct deposit amount and total price not same please select correct payment');
                $("#submit").addClass('disabled');
            }
            else{
                $("#submit").removeClass('disabled');
            }
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
                            $(".overlay").css('display', 'block');
                            $(".loading-img").css('display', 'block');

                            var cat = $('#cat_id').text();

                            $.ajax({
                                type: "POST",
                                data: {
                                     id: $('#record_id').text(),
                                    cat: cat,
                                    controller: 'vendordata',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=vendordata&action=delete",
                                success: function (res) {
                                    if (cat === '1') {
                                        $('#tab_1').html(res);
                                        if ($('#vendor_tab_data').length > 0) {
                                            $('#vendor_tab_data').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '2') {
                                        $('#tab_2').html(res);
                                        if ($('#vendor-price-table-id').length > 0) {
                                            $('#vendor-price-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [1, 3]}
                                                ]
                                            });
                                        }
                                    }
                                    else if (cat === '3') {
                                    $('#tab_3').html(res);
                                    if ($('#vendor_headingtab_data').length > 0) {
                                        $('#vendor_headingtab_data').dataTable({
                                            "aoColumnDefs": [
                                                {'bSortable': false, 'aTargets': [1, 3]}
                                            ]
                                        });
                                    }
                                }

                                else if (cat === '4') {
                                    $('#tab_4').html(res);
                                    if ($('#vendor_payfortab_data').length > 0) {
                                        $('#vendor_payfortab_data').dataTable({
                                            "aoColumnDefs": [
                                                {'bSortable': false, 'aTargets': [1, 3]}
                                            ]
                                        });
                                    }
                                }
                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');
                                }
                            });
                            $(this).dialog('close');
                        }
                    }, {
                        html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                        "class": "btn btn-default",
                        click: function () {
                            $(this).dialog("close");
                        }
                    }]
            });
        }

     });

}(jQuery));