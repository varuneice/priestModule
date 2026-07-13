    function getSafeResponseInput(res, id, jq) {
        var $jq = jq || (typeof gz$ !== 'undefined' ? gz$ : $);
        var nodes = $jq.parseHTML($jq.trim(res || ''), document, false) || [];
        var $nodes = $jq(nodes);
        var $el = $nodes.filter('input#' + id);
        if (!$el.length) {
            $el = $jq('<div>').append($nodes).find('input#' + id);
        }
        return $el;
    }
(function($) {
    $(function() {
         var url = $("#container-abc-url-id").text();
       
        if ($('#stripe_secret_key_id').length > 0) {
            var stripe_publish_key = $("#stripe_secret_key_id").text();
            var stripe = Stripe(stripe_publish_key);
        }
        $("#tab-rental-table-id").delegate("a.icon-delete33", 'click', function(e) {
            //e.preventDefault();
           // $('#record_id').text($(this).attr('rev'));
            //$('#dialogDelete').dialog('open');
        }).delegate("#mark-all-id", 'click', function(e) {
            if ($(this).prop('checked')) {
                $(".mark").prop('checked', true);
            } else {
                $(".mark").prop('checked', false);
            }
        }).delegate('#delete-selected-id', 'click', function(e) {
            $('#dialogDeleteSelected').dialog('open');
        }).delegate("#search-drop-btn-id", "click", function(e) {
            e.preventDefault();

            if ($('#search-booking-frm-id').is(':visible')) {
                $('#search-booking-frm-id').slideUp();
            } else {
                $('#search-booking-frm-id').slideDown();
            }

        });

        // $(document).ready(function() {
        //     debugger;
           
        //   var location = $("#location").val();
        //   var notmem = $("#membertype").val();
        //   var notgegister = notmem.replace(/ /gi,'').trim();
        //   var membertype = notgegister.toLowerCase();
        //  //$.blockUI();
        //  // $.LoadingOverlay("show");
        //  //var url = $("#container-abc-url-id").text();
        //  $.ajax({
        //     type: "POST",
        //     data: {
        //         location: location,
        //         membertype: membertype,
        //     },
        //     url: url + "load.php?controller=RentalBooking&action=locationprice&cid=location",
        //     success: function (res) {
        //         let price = "";
        //         // const locationpriceElement = getSafeResponseInput(res, "rentallocationprice", $);
        //         // if (locationpriceElement.length) {
        //         //     price = locationpriceElement[0].value;
        //         // }
                
        //         //document.getElementById("rentalprice").value = price;
        //         var rentalprice =  $("#rentalprice").val();
        //         var advanceamount = $("#advanceamount").val();
        //         var remainingamount = parseInt(rentalprice)-parseInt(advanceamount);
        //         $("#remainingamount").val(remainingamount);
        //         var extra_amount = $("#extra_amount").val();
        //         var total = parseInt(remainingamount) + parseInt(extra_amount);
        //         $("#total").val(total);
                
                
        //     }
        // });
            
        // }); 
        $(document).delegate(".gzTimeSlotButtonPlusClass", "click", function(e) {
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
                success: function(res) {
                }
            });

            $(this).removeClass();
            $(this).addClass('gzTimeSlotButtonMinusClass fa fa-fw fa-minus-square');
        }).delegate(".gzTimeSlotDropDownClass", "change", function(e) {
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
                success: function(res) {
                }
            });
        }).delegate(".gzTimeSlotButtonMinusClass", "click", function(e) {
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
                success: function(res) {
                }
            });

            $(this).removeClass();
            $(this).addClass('gzTimeSlotButtonPlusClass fa fa-fw fa-plus-square');
        }).delegate(".gzRemoveTimeSlotClass", "click", function(e) {
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
                success: function(res) {
                }
            });
            $(this).parent().parent().remove();
        }).delegate('#payment_method', 'change', function (e) {
            debugger;
            // e.preventDefault();
            var val = $(this).val();
            var total =   $("#total").val();
            if(total == "NaN"){
              alert('Price should be greaer than 0');
            
              document.getElementById("payment_method").value = "";
             
              return;
                }
            
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


                var form = document.getElementById('edit_bookingnew');

                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    stripe.createToken(card).then(function (result) {
                        if (result.error) {
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                           var textField = document.getElementById("paras");
                            textField.setAttribute("value", "Method 2");
                            $("#paras").val("paras");
                            //$("#paras").text("paras1");
                            $("#stripeToken").val(result.token.id);
                            //$("#paras").text(result.token.id);
                            
                            form.submit();
                            
                        }
                    });
                });
                
            } else if (val == 'others') {
                //debugger
                var elem = document.createElement("img");
                    elem.setAttribute("src", url + "zelle.png");
                    elem.setAttribute("height", "600");
                    elem.setAttribute("width", "600");

                    elem.setAttribute("alt", "Flower");
                    $('#error_codeimg').html(elem);
                    document.getElementById("error_codeimg").style.marginLeft = "82px";
                    document.getElementById("error_codeimg").style.marginTop = "30px";
                    document.getElementById("error_code1").style.marginLeft = "200px";
                    document.getElementById("error_code1").style.paddingTop = "12px";
                    document.getElementById("checkPaymentData").style.display = "block";
                    document.getElementById("MemberID1").style.display = "block";
                    document.getElementById("error_code1").style.display = "block";
                    document.getElementById("error_codeimg").style.display = "block";
                    $('#error_code1').html("Step 1 - Send your Zelle payment to treasurer@durgabari.org;" + "<br>" + "Step 2 - Click get zelle payment details button."+ "<br>" + "Step 3 - Select your payment details from  dropdown.");
                $("#stripe_details").hide();
                $("#MemberID1").show();
                $("#MemberID").prop('required',true);
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
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=GzFront&action=checkCode&cid="  + cal_id,
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
        }).delegate("a.icon-delete", 'click', function (e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#cat_id').text($(this).attr('cat'));
            $('#dialogDelete').dialog('open');
        }).delegate('#MemberID', 'click', function (event) {
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
            //var newprice =price.replace('$', "");
            var newp =price.replace('$', "");
             var newprice = newp.replace(',','').trim();
            //var totalprice =   $("#total").text();
            var totalprice =   $("#total").val();
            var tot = totalprice.replace(/ /gi,'').trim();
          
           if(cmCode !=null){
                $("#Zellecode").val(cmCode);
                }
            
                    if(tot===newprice){
                         $('#payment_btn_id').prop("disabled", false);
                         $("#payment_btn_id").removeClass('disabled');
                    }
                    else{
                      
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

        });
        if ($('#search-booking-frm-id').length > 0) {
            $('#from_start_time').datepicker({
                firstDay: $('#from_start_time').attr('first-day'),
                format: $('#start_time').attr('data-format'),
                onSelect: function(selectedDate) {
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
                onSelect: function(selectedDate) {
                    $('#to_end_time').datepicker('option', 'minDate', selectedDate);
                }
            });
            $('#to_end_time').datepicker({
                firstDay: $('#to_end_time').attr('first-day'),
                format: $('#to_end_time').attr('data-format'),
            });
        }
        if ($('#select_date1').length > 0) {
            $('#select_date1').datepicker({
                firstDay: $('#select_date1').attr('first-day'),
                format: $('#select_date1').attr('data-format'),
            }).on('changeDate', function(e) {
                var frm = $("#new_booking, #edit_booking");
                $.ajax({
                    type: "POST",
                    data: frm.serialize(),
                    url: url + "index.php?controller=Booking&action=getSlots",
                    success: function(res) {
                        $('#dialogSlotsDivId').html(res);
                        $("#dialogSlots").dialog('open');
                    }
                });
                $(this).datepicker('hide');
            });
        }
        if ($('#gzhotel-booking-booking-id').length > 0) {
            $('#gzhotel-booking-booking-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [0, 6, 7, 8]}
                ],
                "aaSorting": [[1, "desc"]]
            });
        }

        // if ($("#dialogSlots").length > 0) {
        //     $("#dialogSlots").dialog({
        //         autoOpen: false,
        //         resizable: false,
        //         draggable: false,
        //         height: 420,
        //         width: 420,
        //         modal: true,
        //         buttons: {
        //             'Close': function() {
        //                 $.ajax({
        //                     type: "POST",
        //                     url: url + "index.php?controller=Booking&action=getSlotsTable",
        //                     data: {
        //                         calendar_id: $("#calendar_id").val()
        //                     },
        //                     success: function(res) {
        //                         $('#slotsTable').html(res);
        //                     }
        //                 });
        //                 $(this).dialog('close');
        //             }
        //         },
        //         close: function() {
        //             $.ajax({
        //                 type: "POST",
        //                 url: url + "index.php?controller=Booking&action=getSlotsTable",
        //                 data: {
        //                     calendar_id: $("#calendar_id").val()
        //                 },
        //                 success: function(res) {
        //                     $('#slotsTable').html(res);
        //                 }
        //             });
        //         }
        //     });
        // }

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
                                    controller: 'RentalBooking',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=RentalBooking&action=delete",
                                success: function (res) {

                                    if (cat === '1') {
                                        $('#tab_1').html(res);

                                        if ($('#gzhotel-booking-booking-id').length > 0) {
                                            $('#gzhotel-booking-booking-id').dataTable({
                                                "aoColumnDefs": [
                                                    {'bSortable': false, 'aTargets': [0, 6, 7, 8]}
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

                                        if ($('#advanceamount-table-id').length > 0) {
                                            $('#advanceamount-table-id').dataTable({
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

        // if ($("#dialogDelete").length > 0) {
        //     $("#dialogDelete").dialog({
        //         autoOpen: false,
        //         resizable: false,
        //         draggable: false,
        //         height: 220,
        //         modal: true,
        //         close: function() {
        //             $('#record_id').text('');
        //         },
        //         buttons: [{
        //                 html: "<i class='fa fa-trash-o'></i>&nbsp; Delete item",
        //                 "class": "btn btn-danger",
        //                 click: function() {
        //                     $(".overlay").css('display', 'block');
        //                     $(".loading-img").css('display', 'block');
        //                     $.ajax({
        //                         type: "POST",
        //                         data: {
        //                             id: $('#record_id').text(),
        //                             controller: 'RentalBooking',
        //                             action: 'delete'
        //                         },
        //                         url: url + "index.php?controller=RentalBooking&action=delete",
        //                         success: function(res) {
        //                             $('#tab-rental-table-id').html(res);
        //                             if ($('#tab-rental-table-id').length > 0) {
        //                                 $('#tab-rental-table-id').dataTable({
        //                                     "aoColumnDefs": [
        //                                         {'bSortable': false, 'aTargets': [1, 3]}
        //                                     ]
        //                                 });
        //                             }
        //                             $(".overlay").css('display', 'none');
        //                             $(".loading-img").css('display', 'none');
        //                         }
        //                     });
        //                     $(this).dialog('close');
        //                 }
        //             }, {
        //                 html: "<i class='fa fa-times'></i>&nbsp; Cancel",
        //                 "class": "btn btn-default",
        //                 click: function() {
        //                     $(this).dialog("close");
        //                 }
        //             }]
        //     });
        // }

        // if ($("#dialogDeleteSelected").length > 0) {
        //     $("#dialogDeleteSelected").dialog({
        //         autoOpen: false,
        //         resizable: false,
        //         draggable: false,
        //         height: 220,
        //         modal: true,
        //         buttons: [{
        //                 html: "<i class='fa fa-trash-o'></i>&nbsp; Delete selected",
        //                 "class": "btn btn-danger",
        //                 click: function() {
        //                     $(".overlay").css('display', 'block');
        //                     $(".loading-img").css('display', 'block');

        //                     $("#table-frm-id").ajaxForm({
        //                         target: '#table-frm-id',
        //                         success: function() {
        //                             if ($('#gzhotel-booking-booking-id').length > 0) {
        //                                 $('#gzhotel-booking-booking-id').dataTable({
        //                                     "aoColumnDefs": [
        //                                         {'bSortable': false, 'aTargets': [0, 6, 7, 8]}
        //                                     ]
        //                                 });
        //                             }
        //                             $(".overlay").css('display', 'none');
        //                             $(".loading-img").css('display', 'none');
        //                         }
        //                     }).submit();
        //                     $(this).dialog('close');
        //                 }
        //             }, {
        //                 html: "<i class='fa fa-times'></i>&nbsp; Cancel",
        //                 "class": "btn btn-default",
        //                 click: function() {
        //                     $(this).dialog("close");
        //                 }
        //             }]
        //     });
        // }

        $("body").delegate(".calculate-price-class", "click", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                dataType: 'json',
                data: $(".booking-frm-class").serialize(),
                url: url + "index.php?controller=Booking&action=calculatePrice",
                success: function(json) {

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

        $("#new_booking").delegate("#payment_method", "change", function(e) {

            if ($(this).val() == 'credit_card') {
                $("#credit_card_details").show();
            } else {
                $("#credit_card_details").hide();
            }
        });

        $("#cal-container").delegate(".calendar", "click", function(e) {
            e.preventDefault();
        });

        $("#cal-container").delegate(".reserved", "click", function(e) {
            e.preventDefault();
            var $this = $(this);
            $.ajax({
                type: "post",
                data: {
                    timestamp: $this.attr('rev')
                },
                url: url + "index.php?controller=Booking&action=getBooking",
                success: function(result) {
                    $("#booking_container").html(result);
                }
            });
        });

        if ($("#email_message_id").length > 0) {
            tinymce.init({
                file_browser_callback: function(field, url, type, win) {
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