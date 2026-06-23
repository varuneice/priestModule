(function($) {
    $(function() {
        var url = $("#container-abc-url-id").text();

        var $eventSelect = $(".select2").select2({theme: "classic"});
        $("#months_id").hide();

        $eventSelect.on("change", function(e) {
            var frm = $("#install_frm");
            if ($(this).val() != null) {
                $("#months_id").show();
            } else {
                $("#months_id").hide();
            }
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "index.php?controller=GzInstall&action=getCode",
                success: function(res) {
                    $('#install_code').val(res);
                }
            });
        });

        $("#months_id").on("change", function(e) {
            var frm = $("#install_frm");
            $.ajax({
                type: "POST",
                data: frm.serialize(),
                url: url + "index.php?controller=GzInstall&action=getCode",
                success: function(res) {
                    $('#install_code').val(res);
                }
            });
        })
    });
}(jQuery));