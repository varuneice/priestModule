(function($) {
    $(function() {
        $('#reservationtime').daterangepicker({
            timePicker: false,
            format: 'MM/DD/YYYY'
        });

        $('#reservationtime').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            start: moment().subtract('days', 29),
            end: moment()
        });

        $("#nights_from").spinner({
            spin: function(event, ui) {
                if (ui.value > 30) {
                    $(this).spinner("value", 0);
                    return false;
                } else if (ui.value < 0) {
                    $(this).spinner("value", 30);
                    return false;
                }
            }
        });
        $("#nights_to").spinner({
            spin: function(event, ui) {
                if (ui.value > 30) {
                    $(this).spinner("value", 0);
                    return false;
                } else if (ui.value < 0) {
                    $(this).spinner("value", 30);
                    return false;
                }
            }
        });
    });
}(jQuery));