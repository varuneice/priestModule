(function($) {
    $(function() {
        if ($("#step1-installer-id").length > 0) {
            $("#step1-installer-id").validate({
                rules: {
                    hostname: "required",
                    username: "required",
                    database: "required",
                },
                messages: {
                    hostname: "Hostname is required",
                    username: "Username is required",
                    database: "Database is required",
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
        if ($("#frmStep2").length > 0) {
            $("#frmStep2").validate({
                rules: {
                    admin_email: {
                        required: true,
                        email: true
                    },
                    admin_password: "required",
                },
                messages: {
                    admin_email: "Email is required",
                    admin_password: "Password is required",
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    });
})(jQuery);