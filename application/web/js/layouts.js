(function() {
    if ($(".colorpicker").length > 0) {
        $('.colorpicker').colorpicker({
            parts: 'full',
            alpha: true,
            showOn: 'both',
            buttonColorize: true,
            showNoneButton: true
        });
    }
    if ($(".toogle")) {
        $(".toogle").click(function(e) {
            e.preventDefault();

            var $this = $(this);
            var toogle_url = $(this).attr('href');

            $.ajax({
                type: "GET",
                url: toogle_url,
                success: function(res) {

                    if ($this.hasClass('icon-disable')) {
                        $this.toggleClass('icon-disable icon-active');
                    } else {
                        $this.toggleClass('icon-active icon-disable');
                    }
                    $(".toogle").html(res);

                    $this.html(res);
                }
            });
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
            buttons: {
                "Delete": function() {
                    $.ajax({
                        type: "POST",
                        data: {
                            page: $('span.page.gradient.active').text(),
                            id: $('#record_id').text(),
                        },
                        url: "index.php?controller=GzLayouts&action=delete",
                        success: function(res) {
                            $("#gzblog-body-id").html(res);
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
    $("#body-contetn").on('click', 'a.icon-delete', function(e) {
        e.preventDefault();
        $('#record_id').text($(this).attr('rev'));
        $('#dialogDelete').dialog('open');
    });

    if ($("#new_layout, #edit_layout").length > 0) {
        $("#new_layout, #edit_layout").validate({
            rules: {
                layout: "required",
                post_title_color: "required",
                post_title_size: "required",
                author_color: "required",
                author_size: "required",
                date_bg_color: "required",
                date_size: "required",
                date_color: "required",
                date_font_color: "required",
                post_text_color: "required",
                post_text_size: "required",
                menu_color: "required",
                menu_size: "required",
                category_color: "required",
                category_size: "required",
                button_bg_color: "required",
                button_hover_bg_color: "required",
                button_font_color: "required"
            },
            messages: {
                layout: "Field is required",
                post_title_color: "Field is required",
                post_title_size: "Field is required",
                author_color: "Field is required",
                author_size: "Field is required",
                date_bg_color: "Field is required",
                date_size: "Field is required",
                date_color: "Field is required",
                date_font_color: "Field is required",
                post_text_color: "Field is required",
                post_text_size: "Field is required",
                menu_color: "Field is required",
                menu_size: "Field is required",
                category_color: "Field is required",
                category_size: "Field is required",
                button_bg_color: "Field is required",
                button_hover_bg_color: "Field is required",
                button_font_color: "Field is required"
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    }
}(jQuery));