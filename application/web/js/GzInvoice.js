(function($) {
    $(function() {
        var url = $("#container-abc-url-id").text();
        
        $('#reservationtime').daterangepicker({
            timePicker: false,
            format: $('#reservationtime').attr('date-format')
        });

        if ($('#gzhotel-booking-invoice-id').length > 0) {
            $('#gzhotel-booking-invoice-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [0, 6, 7, 8, 9]}
                ],
                "aaSorting": [[1, "desc"]]
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
                            $.ajax({
                                type: "POST",
                                data: {
                                    id: $('#record_id').text(),
                                    controller: 'Invoice',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=Invoice&action=delete",
                                success: function(res) {
                                    $('#gzhotel-booking-invoice-id_wrapper').html(res);
                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');

                                    $('#gzhotel-booking-invoice-id').dataTable({
                                        "aoColumnDefs": [
                                            {'bSortable': false, 'aTargets': [0, 6, 7, 8, 9]}
                                        ]
                                    });

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
                                    if ($('#gzhotel-booking-invoice-id').length > 0) {
                                        $('#gzhotel-booking-invoice-id').dataTable({
                                            "aoColumnDefs": [
                                                {'bSortable': false, 'aTargets': [0, 6, 7, 8, 9]}
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

        if ($("a.icon-delete").length > 0) {
            $("#gz-time-slot-booking-container-id").delegate("a.icon-delete", 'click', function(e) {
                e.preventDefault();
                $('#record_id').text($(this).attr('rev'));
                $('#dialogDelete').dialog('open');
            });
        }
        if ($("#mark-all-id").length > 0) {
            $("#gz-time-slot-booking-container-id").delegate("#mark-all-id", 'click', function(e) {
                if ($(this).prop('checked')) {
                    $(".mark").prop('checked', true);
                } else {
                    $(".mark").prop('checked', false);
                }
            });
            if ($("#delete-selected-id").length > 0) {
                $("#gz-time-slot-booking-container-id").delegate('#delete-selected-id', 'click', function(e) {
                    $('#dialogDeleteSelected').dialog('open');
                });
            }
        }

        $(".frm-class").delegate("#booking_id", "change", function(e) {
            e.preventDefault();
            var $this = $(this);

            $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    id: $this.val()
                },
                url: url + "index.php?controller=Invoice&action=getBookingDetails",
                success: function(json) {
                    $.each(json, function(k, v) {
                        if ($("#" + k).length > 0) {
                            if (k == 'status' || k == 'currency' || k == 'payment_method') {
                                $("#" + k + " option").prop('selected', false)
                                        .filter('[value="' + v + '"]')
                                        .prop('selected', true);

                            } else {
                                $("#" + k).val(v);
                            }
                        }
                    });
                }
            });
        });

        if ($('#send_invoice_emal_id').length > 0) {
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
        if ($("#new_booking").length > 0) {
            $("#new_booking").validate({
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
}(jQuery));