var handleScrollToTopButton = function() {
    "use strict";
    $(document).scroll(function() {
        var e = $(document).scrollTop();
        if (e >= 200) {
            $("[data-click=scroll-top]").addClass("in")
        } else {
            $("[data-click=scroll-top]").removeClass("in")
        }
    });
    $("[data-click=scroll-top]").click(function(e) {
        e.preventDefault();
        $("html, body").animate({scrollTop: $("body").offset().top}, 500)
    })
}
var App = function() {
    "use strict";
    return{init: function() {
            handleScrollToTopButton();
        }}
}();
(function() {
    $(function() {
        App.init();
    });
}(jQuery));