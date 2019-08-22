define(['jquery'], function($) {
    return {
        init: function() {
            var url = document.URL;
            var hash = url.substring(url.indexOf('#'));
            var timer = setInterval(initializeTabs, 0);

            function initializeTabs() {
                if (typeof $.fn.tab === 'undefined') {
                    return;
                }
                $(".filter-tabs-bootstrap .nav-tabs").find("li a").each(function(key, val) {
                    if (hash === $(val).attr('href')) {
                        $(val).tab('show');
                    }

                    $(val).click(function() {
                        location.hash = $(this).attr('href');
                    });
                });
                clearInterval(timer);
            }
        }
    };
});