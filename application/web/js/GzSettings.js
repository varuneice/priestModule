(function($) {
    $(function() {
        var url = $("#container-abc-url-id").text();
        
        function languages_table_sort() {
            if ($("#gz-shopping-cart-languages-table-id tbody").length > 0) {
                $("#gz-shopping-cart-languages-table-id tbody").sortable({
                    placeholder: '<tr class="placeholder"/>',
                    update: function(event, ui)
                    {
                        var order = $("#gz-shopping-cart-languages-table-id tbody").find('input')
                                .not('input[type=button]')
                                .serialize();

                        $(".overlay").css('display', 'block');
                        $(".loading-img").css('display', 'block');

                        $.ajax({
                            type: "POST",
                            data: order,
                            url: url + "index.php?controller=Settings&action=sort_languages",
                            success: function(res) {
                                languages_table_sort();
                                $(".overlay").css('display', 'none');
                                $(".loading-img").css('display', 'none');
                            }
                        });
                    }
                });
            }
        }

        languages_table_sort();

        if ($('.add-local').length > 0) {
            if ($("#dialogAddLocal").length > 0) {
                $("#dialogAddLocal").dialog({
                    autoOpen: false,
                    resizable: true,
                    draggable: false,
                    height: 570,
                    width: 690,
                    modal: true,
                    buttons: {}
                });
            }
        }
        if ($('#add-language-id').length > 0) {
            if ($("#dialogAddLanguage").length > 0) {
                $("#dialogAddLanguage").dialog({
                    autoOpen: false,
                    resizable: true,
                    draggable: false,
                    height: 370,
                    width: 690,
                    modal: true,
                    buttons: {}
                });
            }
        }
        if ($("#dialogDeleteLanguage").length > 0) {
            $("#dialogDeleteLanguage").dialog({
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
                                    controller: 'Settings',
                                    action: 'delete_language'
                                },
                                url: url + "index.php?controller=Settings&action=delete_language",
                                success: function(res) {
                                    $("#tab_2").html(res);
                                    $('#shopping-cart-languages-table-id').dataTable({
                                        "aoColumnDefs": [
                                            {'bSortable': false, 'aTargets': [3]}
                                        ]
                                    });
                                    languages_table_sort();
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
        if ($("#dialogEditLanguage").length > 0) {
            $("#dialogEditLanguage").dialog({
                autoOpen: false,
                resizable: true,
                draggable: false,
                height: 340,
                width: 590,
                modal: true,
                buttons: {
                }
            });
        }

        $("#gz-time-slot-booking-container-id").delegate(".add-local", "click", function(e) {
            e.preventDefault();
            $('#language_id').val($(this).attr('rev'));
            $('#dialogAddLocal').dialog('open');
        }).delegate("#add-language-id", "click", function(e) {
            e.preventDefault();
            $('#dialogAddLanguage').dialog('open');
        }).delegate('a.icon-delete', 'click', function(e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#dialogDeleteLanguage').dialog('open');
        }).delegate(".local-value", "blur", function(e) {
            $(".overlay").css('display', 'block');
            $(".loading-img").css('display', 'block');

            var id = $(this).attr('data-id');
            var value = $(this).val();
            var language_id = $(this).attr('data-tab');
            $.ajax({
                type: "POST",
                data: {
                    id: id,
                    value: value,
                    language_id: language_id,
                },
                url: url + "index.php?controller=Settings&action=updaet_local",
                success: function(res) {
                    $(".overlay").css('display', 'none');
                    $(".loading-img").css('display', 'none');
                }
            });
        }).delegate(".gz-disabled", "click", function(e) {
            $(".overlay").css('display', 'block');
            $(".loading-img").css('display', 'block');

            var id = $(this).attr('data-id');
            var $this = $(this);

            $.ajax({
                type: "POST",
                data: {
                    id: id,
                },
                url: url + "index.php?controller=Settings&action=active_language",
                success: function(res) {
                    $("#tab_2").html(res);
                    $('#shopping-cart-languages-table-id').dataTable({
                        "aoColumnDefs": [
                            {'bSortable': false, 'aTargets': [3]}
                        ]
                    });
                    languages_table_sort();
                    $(".overlay").css('display', 'none');
                    $(".loading-img").css('display', 'none');
                }
            });
        }).delegate(".icon-edit", "click", function(e) {
            e.preventDefault();

            $(".overlay").css('display', 'block');
            $(".loading-img").css('display', 'block');

            $.ajax({
                type: "POST",
                data: {
                    id: $(this).attr('rev'),
                    controller: 'Settings',
                    action: 'get_frm_edit_language'
                },
                url: url + "index.php?controller=Settings&action=get_frm_edit_language",
                success: function(res) {
                    $(".overlay").css('display', 'none');
                    $(".loading-img").css('display', 'none');

                    $("#dialogEditLanguage").html(res);
                    $('#dialogEditLanguage').dialog('open');

                    $("#edit_language_id").ajaxForm({
                        beforeSubmit: function() {
                            if ($("#edit_language_id").valid()) {
                                $(".overlay").css('display', 'block');
                                $(".loading-img").css('display', 'block');
                                return true;
                            } else {
                                return false;
                            }
                        },
                        complete: function(res) {
                            $("#tab_2").html(res.responseText);
                            $('#shopping-cart-languages-table-id').dataTable({
                                "aoColumnDefs": [
                                    {'bSortable': false, 'aTargets': [3]}
                                ]
                            });
                            languages_table_sort();
                            $(".overlay").css('display', 'none');
                            $(".loading-img").css('display', 'none');
                            $("#dialogEditLanguage").dialog('close');
                        }
                    });
                }
            });
        });

        $("#frm_add_local_id").ajaxForm({
            beforeSubmit: function() {
                if ($("#frm_add_local_id").valid()) {
                    $(".overlay").css('display', 'block');
                    $(".loading-img").css('display', 'block');
                    return true;
                } else {
                    return false;
                }
            },
            complete: function(res) {
                $("#tab_1").html(res.responseText);
                $('.gz-shopping-cart-local-table').dataTable();
                $(".overlay").css('display', 'none');
                $(".loading-img").css('display', 'none');
                $("#dialogAddLocal").dialog('close');
            }
        });

        $("#add_language_id").ajaxForm({
            beforeSubmit: function() {
                if ($("#add_language_id").valid()) {
                    $(".overlay").css('display', 'block');
                    $(".loading-img").css('display', 'block');
                    return true;
                } else {
                    return false;
                }
            },
            complete: function(res) {
                $("#tab_2").html(res.responseText);
                $('#shopping-cart-languages-table-id').dataTable({
                    "aoColumnDefs": [
                        {'bSortable': false, 'aTargets': [3]}
                    ]
                });
                languages_table_sort();
                $(".overlay").css('display', 'none');
                $(".loading-img").css('display', 'none');
                $("#dialogAddLanguage").dialog('close');
            }
        });

        if ($('.gz-shopping-cart-local-table').length > 0) {
            $('.gz-shopping-cart-local-table').dataTable();
        }

        $("#peyment_options").delegate("#paypal_allow", "change", function(e) {
            if ($(this).val() != '1|2::1') {
                $('.paypal_class').hide();
            } else {
                $('.paypal_class').show();
            }
        }).delegate("#authorize_allow", "change", function(e) {
            if ($(this).val() != '1|2::1') {
                $('.authorize_class').hide();
            } else {
                $('.authorize_class').show();
            }
        }).delegate("#2checkout_allow", "change", function(e) {
            if ($(this).val() != '1|2::1') {
                $('.checkout_class').hide();
            } else {
                $('.checkout_class').show();
            }
        }).delegate("#bank_acount_allow", "change", function(e) {
            if ($(this).val() != '1|2::1') {
                $('.bank_account_class').hide();
            } else {
                $('.bank_account_class').show();
            }
        });

        if ($('#invoice_options_id').length > 0 || $('#terms_options_id').length > 0 || $("#email_options").length > 0) {
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