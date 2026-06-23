(function($) {
    $(function() {
        var url = $("#container-abc-url-id").text();

        $("#gz-time-slot-booking-container-id").delegate("a.icon-delete", 'click', function(e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#cat_id').text($(this).attr('cat'));
            $('#dialogDelete').dialog('open');
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
        if ($('#select_date').length > 0) {
            $('#select_date').datepicker({
                firstDay: $('#select_date').attr('first-day'),
                format: $('#select_date').attr('data-format'),
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

        if ($("#dialogSlots").length > 0) {
            $("#dialogSlots").dialog({
                autoOpen: false,
                resizable: false,
                draggable: false,
                height: 420,
                width: 420,
                modal: true,
                buttons: {
                    'Close': function() {
                        $.ajax({
                            type: "POST",
                            url: url + "index.php?controller=Booking&action=getSlotsTable",
                            data: {
                                calendar_id: $("#calendar_id").val()
                            },
                            success: function(res) {
                                $('#slotsTable').html(res);
                            }
                        });
                        $(this).dialog('close');
                    }
                },
                close: function() {
                    $.ajax({
                        type: "POST",
                        url: url + "index.php?controller=Booking&action=getSlotsTable",
                        data: {
                            calendar_id: $("#calendar_id").val()
                        },
                        success: function(res) {
                            $('#slotsTable').html(res);
                        }
                    });
                }
            });
        }

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
                            $(".overlay").css('display', 'block');
                            $(".loading-img").css('display', 'block');
                            var cat = $('#cat_id').text();
                            $.ajax({
                                type: "POST",
                                data: {
                                    id: $('#record_id').text(),
                                    cat: cat,
                                    controller: 'Booking',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=Booking&action=delete",
                                success: function(res) {
                                   if (cat === '1') {
                                    $('#gzhotel-booking-booking-id').html(res);
                                    if ($('#gzhotel-booking-booking-id').length > 0) {
                                        $('#gzhotel-booking-booking-id').dataTable({
                                            "aoColumnDefs": [
                                                {'bSortable': false, 'aTargets': [0, 6, 7, 8]}
                                            ]
                                        });
                                    }
                                }
                                if (cat === '2') {
                                    $('#tab-pujaprice-table-id').html(res);
                                    if ($('#tab-pujaprice-table-id').length > 0) {
                                        $('#tab-pujaprice-table-id').dataTable({
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
                        click: function() {
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
                        click: function() {
                            $(".overlay").css('display', 'block');
                            $(".loading-img").css('display', 'block');

                            $("#table-frm-id").ajaxForm({
                                target: '#table-frm-id',
                                success: function() {
                                    if ($('#gzhotel-booking-booking-id').length > 0) {
                                        $('#gzhotel-booking-booking-id').dataTable({
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
                        click: function() {
                            $(this).dialog("close");
                        }
                    }]
            });
        }

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