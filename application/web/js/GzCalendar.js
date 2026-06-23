(function ($) {
    $(function () {

        var url = $("#container-abc-url-id").text();

        if ($('#gz-booking-calendar-id').length > 0) {
            $('#gz-booking-calendar-id').dataTable({
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [0, 3, 4, 5]}
                ]
            });
        }

        if ($('#general-options-id').length > 0) {
            $('.colorbox').colorpicker();
        }

        if ($('#frm_calendar').length > 0 || $('#general-options-id').length > 0) {
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
                            $.ajax({
                                type: "POST",
                                data: {
                                    id: $('#record_id').text(),
                                    controller: 'Calendar',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=Calendar&action=delete",
                                success: function (res) {
                                    $("#table-frm-id").html(res);
                                    if ($('#gz-booking-calendar-id').length > 0) {
                                        $('#gz-booking-calendar-id').dataTable({
                                            "aoColumnDefs": [
                                                {'bSortable': false, 'aTargets': [0, 3, 4, 5]}
                                            ]
                                        });
                                    }
                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');
                                }
                            });
                            $(this).dialog('close');
                        }}, {
                        html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                        "class": "btn btn-default",
                        click: function () {
                            $(this).dialog('close');
                        }}]
            });
        }

        $("#gz-time-slot-booking-container-id").delegate("a.icon-delete", 'click', function (e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#dialogDelete').dialog('open');
        }).delegate("a.gallery-delete", 'click', function (e) {
            e.preventDefault();

            $('#image_id').text($(this).attr('rev'));
            $('#type_id').text($(this).attr('rel'));
            $('#dialogDeleteGallery').dialog('open');
        }).delegate(".icon-edit", "click", function (e) {
            e.preventDefault();

            $(".overlay").css('display', 'block');
            $(".loading-img").css('display', 'block');
            $.ajax({
                type: "POST",
                data: {
                    id: $(this).attr('rel'),
                    controller: 'Calendar',
                    action: 'get_frm_edit_block'
                },
                url: url + "index.php?controller=Calendar&action=get_frm_edit_block",
                success: function (res) {
                    $("#dialogEditBlocking").html(res);
                    $('#dialogEditBlocking').dialog('open');
                    $(".overlay").css('display', 'none');
                    $(".loading-img").css('display', 'none');
                }
            });
        }).delegate("#mark-all-id", 'click', function (e) {
            if ($(this).prop('checked')) {
                $(".mark").prop('checked', true);
            } else {
                $(".mark").prop('checked', false);
            }
        }).delegate('#delete-selected-id', 'click', function (e) {
            $('#dialogDeleteSelected').dialog('open');
        }).delegate("#paypal_allow", "change", function (e) {
            if ($(this).val() != '1|2::1') {
                $('.paypal_class').hide();
            } else {
                $('.paypal_class').show();
            }
        }).delegate("#authorize_allow", "change", function (e) {
            if ($(this).val() != '1|2::1') {
                $('.authorize_class').hide();
            } else {
                $('.authorize_class').show();
            }
        }).delegate("#2checkout_allow", "change", function (e) {
            if ($(this).val() != '1|2::1') {
                $('.checkout_class').hide();
            } else {
                $('.checkout_class').show();
            }
        }).delegate("#bank_acount_allow", "change", function (e) {
            if ($(this).val() != '1|2::1') {
                $('.bank_account_class').hide();
            } else {
                $('.bank_account_class').show();
            }
        });
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
                                    if ($('#gz-booking-calendar-id').length > 0) {
                                        $('#gz-booking-calendar-id').dataTable({
                                            "aoColumnDefs": [
                                                {'bSortable': false, 'aTargets': [0, 3, 4, 5]}
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
        if ($("#frm_calendar").length > 0) {
            $("#frm_calendar").validate();
        }
    });
}(jQuery));