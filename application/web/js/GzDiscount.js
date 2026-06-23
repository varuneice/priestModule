(function($) {
    $(function() {

        var url = $("#container-abc-url-id").text();

        if ($('#gzhotel-booking-discount-id').length > 0) {
            $('#gzhotel-booking-discount-id').dataTable();
        }

        $("#gz-time-slot-booking-container-id").delegate('a.room_type_drop_down', 'click', function(e) {
            $(".overlay").css('display', 'block');
            $(".loading-img").css('display', 'block');

            e.preventDefault();
            var room_type_id = $(this).attr('rel');
            $.ajax({
                type: "POST",
                data: {
                    room_type_id: room_type_id
                },
                url: url + "index.php?controller=Discount&action=get_discount_table",
                success: function(res) {
                    $("#discount-frm-id").html(res);
                    $("#hidden_room_type_id").val(room_type_id);
                    $('#gzhotel-booking-discount-id').dataTable();
                    $(".overlay").css('display', 'none');
                    $(".loading-img").css('display', 'none');
                }
            });
        });
        if ($('#add_discount_id').length > 0) {
            var startDate, endDate;
            if ($("#dialogAddDiscount").length > 0) {
                $("#dialogAddDiscount").dialog({
                    autoOpen: false,
                    resizable: true,
                    draggable: false,
                    height: 510,
                    width: 690,
                    modal: true,
                    open: function() {
                        $('#daterange-btn').daterangepicker({
                            timePicker: false,
                            format: $('#edit-daterange-btn').attr('date-format')
                        });
                    },
                    buttons: {
                        "Add": function() {
                            if ($(this).dialog().find('form').valid()) {
                                $(".overlay").css('display', 'block');
                                $(".loading-img").css('display', 'block');

                                $.ajax({
                                    type: "POST",
                                    data: $(this).dialog().find('form').serialize(),
                                    url: url + "index.php?controller=Discount&action=add_discount",
                                    success: function(res) {
                                        $("#discount-frm-id").html(res);
                                        $('#gzhotel-booking-discount-id').dataTable();
                                        $(".overlay").css('display', 'none');
                                        $(".loading-img").css('display', 'none');
                                    }
                                });
                                $(this).dialog('close');
                            }
                        },
                        'Cancel': function() {
                            $(this).dialog('close');
                        }
                    }
                });
            }
            $("#gz-time-slot-booking-container-id").delegate("#add_discount_id", "click", function(e) {
                e.preventDefault();
                $('#dialogAddDiscount').dialog('open');
            });
        }

        if ($('.icon-edit').length > 0) {

            if ($("#dialogEditDiscount").length > 0) {
                $("#dialogEditDiscount").dialog({
                    autoOpen: false,
                    resizable: true,
                    draggable: false,
                    height: 510,
                    width: 690,
                    id: $('#record_id').text(),
                    room_type_id: $("#room_type_id").text(),
                    modal: true,
                    open: function() {
                        $('#edit-daterange-btn').daterangepicker({
                            timePicker: false,
                            startDate: $("#edit_from_date").val(),
                            endDate: $("#edit_to_date").val(),
                            format: $('#edit-daterange-btn').attr('date-format')
                        });
                    },
                    buttons: {
                        "Edit": function() {
                            if ($(this).dialog().find('form').valid()) {
                                $(".overlay").css('display', 'block');
                                $(".loading-img").css('display', 'block');

                                $.ajax({
                                    type: "POST",
                                    data: $(this).dialog().find('form').serialize(),
                                    url: url + "index.php?controller=Discount&action=edit",
                                    success: function(res) {
                                        $("#discount-frm-id").html(res);
                                        $('#gzhotel-booking-discount-id').dataTable();
                                        $(".overlay").css('display', 'none');
                                        $(".loading-img").css('display', 'none');
                                    }
                                });
                                $(this).dialog('close');
                            }
                        },
                        'Cancel': function() {
                            $(this).dialog('close');
                        }
                    }
                });
            }
            $("#gz-time-slot-booking-container-id").delegate(".icon-edit", "click", function(e) {
                e.preventDefault();
                $(".overlay").css('display', 'block');
                $(".loading-img").css('display', 'block');
                $.ajax({
                    type: "POST",
                    data: {
                        id: $(this).attr('rev'),
                        room_type_id: $(this).attr('rel'),
                        controller: 'Discount',
                        action: 'get_frm_edit_discount'
                    },
                    url: url + "index.php?controller=Discount&action=get_frm_edit_discount",
                    success: function(res) {
                        $("#dialogEditDiscount").html(res);
                        $('#dialogEditDiscount').dialog('open');
                        $(".overlay").css('display', 'none');
                        $(".loading-img").css('display', 'none');

                    }
                });
            });
        }

        $("#gz-time-slot-booking-container-id").delegate('a.icon-delete', 'click', function(e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#room_type_id').text($(this).attr('rel'));
            $('#dialogDelete').dialog('open');
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
                                    room_type_id: $("#room_type_id").text(),
                                    controller: 'Discount',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=Discount&action=delete",
                                success: function(res) {
                                    $("#discount-frm-id").html(res);
                                    $('#gzhotel-booking-discount-id').dataTable();
                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');
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
    });
}(jQuery));