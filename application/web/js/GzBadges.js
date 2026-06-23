(function ($) {
    $(function () {
        var url = $("#container-abc-url-id").text();

        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }

        if ($('#tab-1-table-id').length > 0) {
            $('#tab-1-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

        if ($('#tab-2-table-id').length > 0) {
            $('#tab-2-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

       // if ($('#tab-3-table-id').length > 0) {
        //     $('#tab-3-table-id').dataTable({
        //         "aoColumnDefs": [
        //             {'bSortable': false, 'aTargets': [6, 7]}
        //         ]
        //     });
        // }

        if ($('#tab-4-table-id').length > 0) {
            $('#tab-4-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

        if ($('#tab-5-table-id').length > 0) {
            $('#tab-5-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

        if ($('#tab-6-table-id').length > 0) {
            $('#tab-6-table-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [6, 7]}
                ]
            });
        }

        var ignoreChange = false;
        $('input:radio[name=rate]').on('ifChanged', function (event) {
            var frm = $('#payment-form');

            if (ignoreChange) {
                ignoreChange = false;
                return;
            }

            $.ajax({
                type: "POST",
                data: frm.serialize(),
                dataType: 'json',
                url: url + "load.php?controller=Member&action=calculatePrice",
                success: function (json) {
                    $("#gmi_amount").val(json.gmi_amount);
                    $("#gmf_amount").val(json.gmf_amount);
                    $("#lm_amount").val(json.lm_amount);
                    $("#bf_amount").val(json.bf_amount);
                    $("#pm_amount").val(json.pm_amount);
                    $("#lm_h_amount").val(json.lm_h_amount);
                    $("#total").val(json.total);

                    ignoreChange = true;
                }
            });
        });

        var ignoreChange = false;
        let selectedSize;
        $('input:radio[name=membership_type]').on('ifChanged', function (event) {
           // var frm = $('#payment-form');
           const radioButtons = document.querySelectorAll('input[name="membership_type"]');
            if (ignoreChange) {
                ignoreChange = false;
                return;
            }
            debugger
            for (const radioButton of radioButtons) {
                if (radioButton.checked) {
                    selectedSize = radioButton.value;
                    break;
                }
            }
            if (selectedSize == "individual_membership") {
                document.getElementById('children').style.display = 'none';
            } else{
                document.getElementById('children').style.display = 'block';
            }
           
        });

        var ignoreChange2 = false;
        let selectedSize2;
        $('input:radio[name=information]').on('ifChanged', function (event) {
           // var frm = $('#payment-form');
           const radioButtons = document.querySelectorAll('input[name="information"]');
            if (ignoreChange2) {
                ignoreChange2 = false;
                return;
            }
            debugger
            for (const radioButton of radioButtons) {
                if (radioButton.checked) {
                    selectedSize = radioButton.value;
                    break;
                }
            }
            if (selectedSize == "renewal") {
                document.getElementById('renew').style.display = 'block';
                document.getElementById('new').style.display = 'none';
            } else{
                document.getElementById('new').style.display = 'block';
                document.getElementById('renew').style.display = 'none';
            }
           
        });

        var ignoreChange = false;
        let selectedSize1;
        $('input:radio[name=GovtissueID]').on('ifChanged', function (event) {
           // var frm = $('#payment-form');
           const radioButtons = document.querySelectorAll('input[name="GovtissueID"]');
            if (ignoreChange) {
                ignoreChange = false;
                return;
            }
            debugger
            for (const radioButton of radioButtons) {
                if (radioButton.checked) {
                    selectedSize1 = radioButton.value;
                    break;
                }
            }
            if (selectedSize1 == "checked") {
                document.getElementById('govtid').style.display = 'block';
            } else{
                document.getElementById('govtid').style.display = 'none';
            }
           
        });

        $(document).delegate("a.gallery-delete", 'click', function (e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#dialogDeleteImage').dialog('open');
        }).delegate('#donation', 'change', function (e) {
            var frm = $('#payment-form');

            $.ajax({
                type: "POST",
                data: frm.serialize(),
                dataType: 'json',
                url: url + "load.php?controller=Member&action=calculatePrice",
                success: function (json) {
                    $("#gmi_amount").val(json.gmi_amount);
                    $("#gmf_amount").val(json.gmf_amount);
                    $("#lm_amount").val(json.lm_amount);
                    $("#bf_amount").val(json.bf_amount);
                    $("#pm_amount").val(json.pm_amount);
                    $("#lm_h_amount").val(json.lm_h_amount);
                    $("#total").val(json.total);
                }
            });
        }).delegate('#Payment_method', 'change', function (e) {
            var val = $(this).val();

            if (val == 'stripe') {
                $("#others_details").hide();
                $("#stripe_details").show();
                document.getElementById("error_code1").style.display = "none";
                document.getElementById("error_codeimg").style.display = "none";
                document.getElementById("checkPaymentData").style.display = "none";
                document.getElementById("MemberID1").style.display = "none";
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
                    elem.setAttribute("src", url + "zelle.png");
                    elem.setAttribute("height", "600");
                    elem.setAttribute("width", "600");

                    elem.setAttribute("alt", "Flower");
                    $('#error_codeimg').html(elem);
                    document.getElementById("error_codeimg").style.marginLeft = "290px";
                    document.getElementById("error_codeimg").style.marginTop = "87px";
                    document.getElementById("error_code1").style.marginLeft = "420px";
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
        }).delegate("a.icon-delete", 'click', function (e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#cat_id').text($(this).attr('cat'));
            $('#dialogDelete').dialog('open');
        }).delegate("#mark-all-id", 'click', function (e) {
            if ($(this).prop('checked')) {
                $(".mark").prop('checked', true);
            } else {
                $(".mark").prop('checked', false);
            }
        }).delegate('#delete-selected-id', 'click', function (e) {
            $('#dialogDeleteSelected').dialog('open');
        }).delegate("#search-drop-btn-id", "click", function (e) {
            e.preventDefault();

            if ($('#search-booking-frm-id').is(':visible')) {
                $('#search-booking-frm-id').slideUp();
            } else {
                $('#search-booking-frm-id').slideDown();
            }
        }).delegate('#confirm_code', 'change', function (event) {
            var frm = $("#payment-form");
            $("#error_code1").css('display', 'none');
            $("#error_codeimg").css('display', 'none');
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode",
                success: function (res) {
                    var check = res.includes("Your payment code is matched you can book");

                    if (check == true) {
                        $("#member_btn_id").removeClass('disabled');
                    } else {
                        $("#member_btn_id").addClass('disabled');
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
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode&cid="  + cal_id,
                success: function (res) {

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
            debugger
            var dd = $("#MemberID").val();
          
            var parts = dd.split("/");
            var cmCode = parts[3];
            var name =parts[1];
            var price =parts[2].replace(/ /gi,'').trim();;
          
            var totalprice =   $("#total").text();
            var tot = totalprice.replace(/ /gi,'').trim();
          
            
                    if(tot===price){
                        $("#details_frm_btn_id").removeClass('disabled');
                    }
                    else{
                      
                        $("#details_frm_btn_id").addClass('disabled');
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

        }).delegate('#MemberID', 'click', function (event) {
            var self = this;
           debugger
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
                    $('#MemberID').empty(); //remove all child nodes
                    var newOption = $(myString1);
                    var newOption1 = $('<option value="1">Please select your payment details</option>');
                    $('#MemberID').append(newOption1);
                    $('#MemberID').append(newOption);
                    $('#MemberID').trigger("chosen:updated");
                    var dd = $("#MemberID").val();
                   
                    if (dd == "1") {
                      // gz$("#member_btn_id").addClass('disabled');
                      document.getElementById("member_btn_id").disabled = true;
                    }
                    //  var parts = myString1.split("/"); 
                    //  var cmCode =parts[3];
                }
            });

        });

        $(document).delegate(".gzTimeSlotButtonPlusClass", "click", function (e) {
            var slot = $(this).attr('data-start-time');
            var date = $(this).attr('data-date');
            var cal_id = $("#calendar_id").val();
            var count = 1;

            $.ajax({
                type: "POST",
                data: {
                    date: date,
                    slot: slot,
                    count: count,
                    cal_id: cal_id
                },
                url: url + "load.php?controller=Booking&action=addTimeSlot&cid=" + cal_id,
                success: function (res) {
                }
            });

            $(this).removeClass();
            $(this).addClass('gzTimeSlotButtonMinusClass fa fa-fw fa-minus-square');
        }).delegate(".gzTimeSlotDropDownClass", "change", function (e) {
            var slot = $(this).attr('data-start-time');
            var date = $(this).attr('data-date');
            var cal_id = $("#calendar_id").val();
            var count = $(this).val();

            $.ajax({
                type: "POST",
                data: {
                    date: date,
                    slot: slot,
                    count: count,
                    cal_id: cal_id
                },
                url: url + "load.php?controller=Booking&action=addTimeSlot&cid=" + cal_id,
                success: function (res) {
                }
            });
        }).delegate(".gzTimeSlotButtonMinusClass", "click", function (e) {
            var slot = $(this).attr('data-start-time');
            var date = $(this).attr('data-date');
            var cal_id = $("#calendar_id").val();
            var count = 1;

            $.ajax({
                type: "POST",
                data: {
                    date: date,
                    slot: slot,
                    count: count,
                    cal_id: cal_id
                },
                url: url + "load.php?controller=Booking&action=removeTimeSlot&cid=" + cal_id,
                success: function (res) {
                }
            });

            $(this).removeClass();
            $(this).addClass('gzTimeSlotButtonPlusClass fa fa-fw fa-plus-square');
        }).delegate(".gzRemoveTimeSlotClass", "click", function (e) {
            var slot = $(this).attr('data-start-time');
            var date = $(this).attr('data-date');
            var cal_id = $("#calendar_id").val();
            var count = 1;

            $.ajax({
                type: "POST",
                data: {
                    date: date,
                    slot: slot,
                    count: count,
                    cal_id: cal_id
                },
                url: url + "load.php?controller=Booking&action=removeTimeSlot&cid=" + cal_id,
                success: function (res) {
                }
            });
            $(this).parent().parent().remove();
        });
        if ($('#search-booking-frm-id').length > 0) {
            $('#from_start_time').datepicker({
                firstDay: $('#from_start_time').attr('first-day'),
                format: $('#start_time').attr('data-format'),
                onSelect: function (selectedDate) {
                    $('#project_to_start_time').datepicker('option', 'minDate', selectedDate);
                }
            });
            $('#to_start_time').datepicker({
                firstDay: $('#to_start_time').attr('first-day'),
                format: $('#to_start_time').attr('data-format'),
            });
            $('#from_end_time').datepicker({
                firstDay: $('#from_end_time').attr('first-day'),
                format: $('#from_end_time').attr('data-format'),
                onSelect: function (selectedDate) {
                    $('#to_end_time').datepicker('option', 'minDate', selectedDate);
                }
            });
            $('#to_end_time').datepicker({
                firstDay: $('#to_end_time').attr('first-day'),
                format: $('#to_end_time').attr('data-format'),
            });
        }
        if ($('#select_date').length > 0) {
            $('#select_date').datepicker({
                firstDay: $('#select_date').attr('first-day'),
                format: $('#select_date').attr('data-format'),
            }).on('changeDate', function (e) {
                var frm = $("#new_booking, #edit_booking");
                $.ajax({
                    type: "POST",
                    data: frm.serialize(),
                    url: url + "index.php?controller=Booking&action=getSlots",
                    success: function (res) {
                        $('#dialogSlotsDivId').html(res);
                        $("#dialogSlots").dialog('open');
                    }
                });
                $(this).datepicker('hide');
            });
        }
        if ($('#gz-abc-member-ID').length > 0) {
            $('#gz-abc-member-ID').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [0, 6, 7, 8]}
                ]
            });
        }

        if ($("#dialogDelete").length > 0) {
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
                                    controller: 'Member',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=Member&action=delete",
                                success: function (res) {

                                    if (cat === '1') {
                                        $('#tab_1').html(res);

                                        if ($('#tab-1-table-id').length > 0) {
                                            $('#tab-1-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '2') {
                                        $('#tab_2').html(res);

                                        if ($('#tab-2-table-id').length > 0) {
                                            $('#tab-2-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '3') {
                                        $('#tab_3').html(res);

                                        if ($('#tab-3-table-id').length > 0) {
                                            $('#tab-3-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '4') {
                                        $('#tab_4').html(res);

                                        if ($('#tab-4-table-id').length > 0) {
                                            $('#tab-4-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '5') {
                                        $('#tab_5').html(res);

                                        if ($('#tab-5-table-id').length > 0) {
                                            $('#tab-5-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
                                                ]
                                            });
                                        }
                                    } else if (cat === '6') {
                                        $('#tab_6').html(res);

                                        if ($('#tab-6-table-id').length > 0) {
                                            $('#tab-6-table-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [6, 7]}
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

        if ($("#dialogDeleteSelected").length > 0) {
            $("#dialogDeleteSelected").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                buttons: [{
                        html: "<i class='fa fa-trash-o'></i>&nbsp; Delete selected",
                        "class": "btn btn-danger",
                        click: function () {
                            $(".overlay").css('display', 'block');
                            $(".loading-img").css('display', 'block');

                            $("#table-frm-id").ajaxForm({
                                target: '#table-frm-id',
                                success: function () {
                                    if ($('#gz-abc-member-ID').length > 0) {
                                        $('#gz-abc-member-ID').dataTable({
                                            "aoColumnDefs": [
                                                {'bSortable': false, 'aTargets': [0, 6, 7, 8]}
                                            ]
                                        });
                                    }
                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');
                                }
                            }).submit();
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


        if ($("#dialogDeleteSelected").length > 0) {
            $("#dialogDeleteSelected").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                buttons: [{
                        html: "<i class='fa fa-trash-o'></i>&nbsp; Delete selected",
                        "class": "btn btn-danger",
                        click: function () {
                            $(".overlay").css('display', 'block');
                            $(".loading-img").css('display', 'block');

                            $("#table-frm-id").ajaxForm({
                                target: '#table-frm-id',
                                success: function () {
                                    if ($('#gz-abc-member-ID').length > 0) {
                                        $('#gz-abc-member-ID').dataTable({
                                            "aoColumnDefs": [
                                                {'bSortable': false, 'aTargets': [0, 6, 7, 8]}
                                            ]
                                        });
                                    }
                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');
                                }
                            }).submit();
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

        $("body").delegate(".calculate-price-class", "click", function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                dataType: 'json',
                data: $(".booking-frm-class").serialize(),
                url: url + "index.php?controller=Booking&action=calculatePrice",
                success: function (json) {

                    $("#calendars_price").val(json.calendars_price);
                    $("#extra_price").val(json.extra_price);
                    $("#tax").val(json.tax);
                    $("#security").val(json.security);
                    $("#deposit").val(json.deposit);
                    $("#discount").val(json.discount);
                    $("#total").val(json.total);
                }
            });
        });

        if ($("#new_booking").length > 0) {
            $("#new_booking").validate();
        }

        $("#new_booking").delegate("#payment_method", "change", function (e) {

            if ($(this).val() == 'credit_card') {
                $("#credit_card_details").show();
            } else {
                $("#credit_card_details").hide();
            }
        });

        $("#cal-container").delegate(".calendar", "click", function (e) {
            e.preventDefault();
        });

        $("#cal-container").delegate(".reserved", "click", function (e) {
            e.preventDefault();
            var $this = $(this);
            $.ajax({
                type: "post",
                data: {
                    timestamp: $this.attr('rev')
                },
                url: url + "index.php?controller=Booking&action=getBooking",
                success: function (result) {
                    $("#booking_container").html(result);
                }
            });
        });
        
        if ($("#dialogDeleteImage").length > 0) {
            $("#dialogDeleteImage").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 220,
                modal: true,
                close: function() {
                    $('#record_id').text('');
                },
                buttons: {
                    "Delete": function() {
                        $.ajax({
                            type: "POST",
                            data: {
                                id: $('#record_id').text(),
                                controller: 'Member',
                                action: 'deleteEditedImage'
                            },
                            url: url + "index.php?controller=Member&action=deleteEditedImage",
                            success: function(res) {
                                $("#img-file-id").html(res);
                            }
                        });
                        $(this).dialog('close');
                    },
                    'Cancel': function() {
                        $(this).dialog('close');
                    }
                }
            });
        }

        if ($("#email_message_id").length > 0) {
            tinymce.init({
                file_browser_callback: function (field, url, type, win) {
                    tinyMCE.activeEditor.windowManager.open({
                        file: 'core/libs/kcfinder/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
                        title: 'KCFinder',
                        width: 700,
                        height: 500,
                        inline: true,
                        close_previous: false
                    }, {
                        window: win,
                        input: field
                    });
                    return false;
                },
                selector: "textarea",
                theme: "modern",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                toolbar2: "print preview media | forecolor backcolor emoticons",
                image_advtab: true,
                templates: [
                    {title: 'Test template 1', content: 'Test 1'},
                    {title: 'Test template 2', content: 'Test 2'}
                ],
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true,
            });
        }
    });
}(jQuery));