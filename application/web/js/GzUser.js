(function($) {
    $(function() {
        var url = $("#container-abc-url-id").text();
        
       // $('#gz-abc-user-id').dataTable({
        //     "aoColumnDefs": [
        //         {'bSortable': false, 'aTargets': [5, 6]}
        //     ]
        // });

        if ($('#gz-abc-user-id').length > 0) {
            $('#gz-abc-user-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [5, 6]}
                ]
            });
        }

        $("#gz-time-slot-booking-container-id").delegate('a.icon-delete', 'click', function(e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
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
                            $.ajax({
                                type: "POST",
                                data: {
                                    id: $('#record_id').text(),
                                    controller: 'User',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=User&action=delete",
                                beforeSend: function() {
                                    $(".overlay").css('display', 'block');
                                    $(".loading-img").css('display', 'block');
                                },
                                success: function(res) {
                                    $("#user-table-frm-id").html(res);

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
        if ($("#dialogDeleteGallery").length > 0) {
            $("#dialogDeleteGallery").dialog({
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
                                controller: 'User',
                                action: 'deleteImage'
                            },
                            url: url + "index.php?controller=User&action=deleteImage",
                            beforeSend: function() {
                                $(".overlay").css('display', 'block');
                                $(".loading-img").css('display', 'block');
                            },
                            success: function(res) {
                                $("#user-table-frm-id").html(res);

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
                    },
                    'Cancel': function() {
                        $(this).dialog('close');
                    }
                }
            });
        }
        if ($("a.gallery-delete").length > 0) {
            $("#user-table-frm-id").delegate("a.gallery-delete", 'click', function(e) {
                e.preventDefault();
                $('#record_id').text($(this).attr('rev'));
                $('#dialogDeleteGallery').dialog('open');
            });

            $("#edit_user").delegate("a.gallery-delete", 'click', function(e) {
                e.preventDefault();
                $('#record_id').text($(this).attr('rev'));
                $('#dialogDeleteImage').dialog('open');
            });
        }
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
                                controller: 'User',
                                action: 'deleteEditedImage'
                            },
                            url: url + "index.php?controller=User&action=deleteEditedImage",
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

        if ($("#new_user").length > 0) {
            $("#new_user").validate({
                rules: {
                    type: "required",
                    first: "required",
                    last: "required",
                    status: "required",
                    password: {
                        required: true,
                        minlength: 3
                    },
                    confirm_password: {
                        required: true,
                        minlength: 3,
                        equalTo: "#password"
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    confirm_email: {
                        required: true,
                        email: true,
                        equalTo: "#email"
                    }
                },
                messages: {
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 3 characters long"
                    },
                    password_confirm: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 3 characters long",
                        equalTo: "Please enter the same password as above"
                    },
                    email_confirm: {
                        required: "Please provide a confirm email",
                        equalTo: "Please enter the same email as above"
                    }
                }
            });
        }


        if ($("#edit_user").length > 0) {
            $("#edit_user").validate({
                rules: {
                    type: "required",
                    first: "required",
                    last: "required",
                    status: "required",
                    password: {
                        required: true,
                        equalTo: "#password",
                        minlength: 3
                    },
                    confirm_password: {
                       required: true,
                        minlength: 3,
                        equalTo: "#password"
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    confirm_email: {
                        required: true,
                        email: true,
                        equalTo: "#email"
                    }
                },
                messages: {
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 3 characters long"
                    },
                    password_confirm: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 3 characters long",
                        equalTo: "Please enter the same password as above"
                    },
                    email_confirm: {
                        required: "Please provide a confirm email",
                        equalTo: "Please enter the same email as above"
                    }
                }
            });
        }
    });
}(jQuery));