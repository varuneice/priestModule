(function($) {
    $(function() {
        var url = $("#container-abc-url-id").text();

        $('#reservationtime').daterangepicker({
            timePicker: false,
            format: $('#reservationtime').attr('date-format')
        });

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
                            $.ajax({
                                type: "POST",
                                data: {
                                    id: $('#record_id').text(),
                                    controller: 'Booking',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=Booking&action=delete",
                                success: function(res) {
                                    $('#gzhotel-booking-booking-id').html(res);
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

        $("#gz-time-slot-booking-container-id").delegate("a.icon-delete", 'click', function(e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#dialogDelete').dialog('open');
        });

        $("#gz-time-slot-booking-container-id").delegate("#mark-all-id", 'click', function(e) {
            if ($(this).prop('checked')) {
                $(".mark").prop('checked', true);
            } else {
                $(".mark").prop('checked', false);
            }
        });

        $("#gz-time-slot-booking-container-idg-container-id").delegate('#delete-selected-id', 'click', function(e) {
            $('#dialogDeleteSelected').dialog('open');
        })

        $("#gz-time-slot-booking-container-id").delegate("#add-room-id", "click", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                data: {
                    form: $("#new_booking").serialize()
                },
                url: "index.php?controller=Booking&action=addBookingRoomsType",
                success: function(res) {
                    $('#dialogAddBookingRoomFrmId').html(res);
                    $('#dialogAddBookingRoom').dialog('open');
                }
            });
        });
        $('#dialogAddBookingRoom').delegate("#room_type_id", "change", function(e) {
            $.ajax({
                type: "POST",
                data: {
                    form: $("#new_booking").serialize(),
                    id: $(this).val(),
                    room_id: $(".room_id_class").serialize()
                },
                url: url + "index.php?controller=Booking&action=addBookingRooms",
                success: function(res) {
                    $("#select-rooms-id").html(res);
                }
            });
        });
        $("#dialogAddBookingRoom").dialog({
            autoOpen: false,
            resizable: false,
            draggable: false,
            height: 310,
            modal: true,
            close: function() {
                $('#record_id').text('');
            },
            buttons: {
                "Add": function() {
                    $.ajax({
                        type: "POST",
                        data: $("#dialogAddBookingRoomFrmId").serialize(),
                        url: url + "index.php?controller=Booking&action=getRoomTable",
                        success: function(res) {
                            $("#rooms-table-id").html(res);
                        }
                    });
                    $(this).dialog('close');
                },
                'Cancel': function() {
                    $(this).dialog('close');
                }
            }
        });
        $("body").delegate(".calculate-price-class", "click", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    controller: 'Booking',
                    action: 'calculatePrice',
                    frm: $(".booking-frm-class").serialize()
                },
                url: url + "index.php?controller=Booking&action=calculatePrice",
                success: function(json) {

                    $("#rooms_price").val(json.rooms_price);
                    $("#extra_price").val(json.extra_price);
                    $("#tax").val(json.tax);
                    $("#security").val(json.security);
                    $("#deposit").val(json.deposit);
                    $("#discount").val(json.discount);
                    $("#total").val(json.total);
                }
            });
        });
        if ($("#dialogRoomDelete").length > 0) {
            $("#dialogRoomDelete").dialog({
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
                            data: $(".room_id_class").serialize(),
                            url: url + "index.php?controller=Booking&action=delete_room&deleted_room_id=" + $('#div_room_id').text(),
                            success: function(res) {
                                $("#rooms-table-id").html(res);
                                $("a.icon-room-delete").on('click', function(e) {
                                    e.preventDefault();
                                    $('#div_room_id').text($(this).attr('rev'));
                                    $('#dialogRoomDelete').dialog('open');
                                });
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
        $("a.icon-room-delete").on('click', function(e) {
            e.preventDefault();
            $('#div_room_id').text($(this).attr('rev'));
            $('#dialogRoomDelete').dialog('open');
        });
        $("#cal-container").delegate("a.gz-summary-link-month", "click", function(e) {
            e.preventDefault();
            var $this = $(this), date = $this.attr("rel");
            $.ajax({
                type: "GET",
                data: {
                    day: date.split("-")[0],
                    month: date.split("-")[1],
                    year: date.split("-")[2],
                    view: date.split("-")[3]
                },
                beforeSend: function() {
                    $(".overlay").css('display', 'block');
                    $(".loading-img").css('display', 'block');
                },
                url: url + "index.php?controller=Booking&action=get_summary",
                success: function(result) {
                    $("#cal-container").html(result);
                    $(".overlay").css('display', 'none');
                    $(".loading-img").css('display', 'none');
                }
            });
        });

        if ($("#new_booking").length > 0) {
            $("#new_booking").validate({
                submitHandler: function(form) {
                    form.submit();
                }
            });
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

    });
}(jQuery));