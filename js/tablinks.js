$(window).on('load', function() {
    // Globals.
    var url = getUrl();
    var loadSuccess = false;

    if (location.hash.startsWith('#filter-tabs-')) {
        scrollAndShowTab();
    }

    // When tab is clicked, change hash and go to clicked tab.
    $('a[href*="#filter-tabs-"]').on('click', function() {
        updateUrl($(this).attr('href').substring(1));
        scrollAndShowTab();
    });

    // When url is changed, go to tab and show.
    window.onhashchange = () => {
        updateUrl(getUrl()[1]);
        scrollAndShowTab();
    };

    // Clean and split url (second element is the hash).
    function getUrl() {
        return location.href.replace(/\/$/, '').split('#');
    }

    // Replace url's hash with a new one.
    function updateUrl(newHash) {
        url[1] = newHash;
        // Updates the current entry in the session history to have the given URL.
        history.replaceState(null, null, url[0] + '#' + url[1]);
    }

    // Scrolls to and shows the tab indicated by hash.
    function scrollAndShowTab() {
        var selectedTab = $('a[href="#' + url[1] + '"]');
        // Use setInterval because we don't know when dependent code is ready.
        var interval = setInterval(function() {
            try {
                selectedTab.tab('show');
                scrollToTab(selectedTab);
                loadSuccess = true;
            } catch(event) {
                // Make sure code does not stop.
            }
            if (loadSuccess) {
                clearInterval(interval);
            }
        }, 5);
    }

    // Scrolls to the selected tab.
    function scrollToTab(selectedTab) {
        var headerHeight = $('.header-main.row').height() + 10;
        if (selectedTab.length) {
            var topOfTab = selectedTab.offset().top - headerHeight;
            $(window).scrollTop(topOfTab);
        }
    }
});