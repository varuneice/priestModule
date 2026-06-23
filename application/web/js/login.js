(function($) {
    $(function() {
        if ($("#login").length > 0) {
            $("#login").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: "required",
                },
                messages: {
                    email: "Email is required",
                    password: "Password is required",
                }
            });
        }
            $("#registration").validate({
                submitHandler: function (form) {
                    form.submit();
              }
            });
    });
})(jQuery);