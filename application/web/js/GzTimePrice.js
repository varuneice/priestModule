(function ($) {
    $(function () {
        var url = $("#container-abc-url-id").text();

        $('.datepicker').datepicker({
            firstDay: $('.datepicker').attr('first-day'),
            format: $('.datepicker').attr('date-format'),
            autoclose: true
        });

        $(document).delegate(".customize_price", "click", function (e) {
            var calendar_id = $("#calendar_id").val();
            var day = $(this).attr('data-day');

            $.ajax({
                type: "POST",
                data: {
                    day: day,
                    calendar_id: calendar_id
                },
                url: url + "load.php?controller=TimePrice&action=getCustomPriceFrm",
                success: function (res) {
                    $('#set_custom_price_id').html(res);
                    $("#dialogSetCustomPrice").dialog('open');
                }
            });
        }).delegate("#add-time-id", "click", function (e) {

            var frm = $("#custom-prce-plan-id");
            $(".overlay").css('display', 'block');
            $(".loading-img").css('display', 'block');

            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "load.php?controller=TimePrice&action=addCustomTimePrices",
                success: function (res) {
                    $('#custom-prices-container-id').html(res);

                    $(".overlay").css('display', 'none');
                    $(".loading-img").css('display', 'none');
                }
            });
        }).delegate("a.icon-edit", 'click', function (e) {
            var $this = $(this);

            var id = $this.attr('rev');

            e.preventDefault();
            $(".overlay").css('display', 'block');
            $(".loading-img").css('display', 'block');
            $.ajax({
                type: "POST",
                data: {
                    id: id,
                    controller: 'TimePrice',
                    action: 'getEditCustomTime'
                },
                url: url + "index.php?controller=TimePrice&action=getEditCustomTime",
                success: function (res) {
                    $("#dialogEditCustomTime").html(res);
                    $('#dialogEditCustomTime').dialog('open');
                    $(".overlay").css('display', 'none');
                    $(".loading-img").css('display', 'none');
                }
            });
        }).delegate("a.custom-icon-delete", 'click', function (e) {
            e.preventDefault();
            $('#record_id').text($(this).attr('rev'));
            $('#dialogDelete').dialog('open');
        });

        $(".touchSpin").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'glyphicon glyphicon-plus',
            verticaldownclass: 'glyphicon glyphicon-minus'
        });

        $('.timepicker').timepicker({
            showInputs: false,
            disableFocus: true,
            showMeridian: false
        });

        $('input[type="checkbox"]').on('ifChecked', function (event) {

            var parent = $(this).parent();
            var cl = parent.find(".is_day_off").attr('rel');

            $("." + cl).hide();
        });
        $('input[type="checkbox"]').on('ifUnchecked', function (event) {

            var parent = $(this).parent();
            var cl = parent.find(".is_day_off").attr('rel');

            $("." + cl).show();
        });

        if ($("#dialogEditCustomTime").length > 0) {
            $("#dialogEditCustomTime").dialog({
                autoOpen: false,
                resizable: true,
                draggable: false,
                height: 710,
                width: 690,
                id: $('#record_id').text(),
                modal: true,
                open: function () {
                    $('#edit-datepicker').datepicker({
                        firstDay: $('.datepicker').attr('first-day'),
                        format: $('.datepicker').attr('date-format'),
                        autoclose: true
                    });
                    $('#edit-end-datepicker').datepicker({
                        firstDay: $('.datepicker').attr('first-day'),
                        format: $('.datepicker').attr('date-format'),
                        autoclose: true
                    });
                    $('.edit-timepicker').timepicker({
                        showInputs: false,
                        disableFocus: true,
                        showMeridian: false
                    });
                },
                buttons: {
                    "Edit": function () {
                        if ($(this).dialog().find('form').valid()) {
                            $(".overlay").css('display', 'block');
                            $(".loading-img").css('display', 'block');

                            $.ajax({
                                type: "POST",
                                data: $(this).dialog().find('form').serialize(),
                                url: url + "index.php?controller=TimePrice&action=edit",
                                success: function (res) {
                                    $("#custom-prices-container-id").html(res);
                                    $('#working-time-table-id').dataTable();
                                    $(".overlay").css('display', 'none');
                                    $(".loading-img").css('display', 'none');
                                }
                            });
                            $(this).dialog('close');
                        }
                    },
                    'Cancel': function () {
                        $(this).dialog('close');
                    }
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
                                    controller: 'TimePrice',
                                    action: 'delete'
                                },
                                url: url + "index.php?controller=TimePrice&action=delete",
                                success: function (res) {
                                    $('#custom-prices-container-id').html(res);
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

        $("#dialogSetCustomPrice").dialog({
            autoOpen: false,
            resizable: false,
            draggable: false,
            height: 610,
            width: 610,
            modal: true,
            close: function () {
            },
            buttons: {
                "Save": function () {
                    $.ajax({
                        type: "POST",
                        data: $("#dialogSetCustomPriceFrmId").serialize(),
                        url: url + "index.php?controller=TimePrice&action=saveCustomPrice",
                        success: function (res) {
                        }
                    });
                    $(this).dialog('close');
                },
                'Cancel': function () {
                    $(this).dialog('close');
                }
            }
        });
    });
}(jQuery));