// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Filter "tabs"
 *
 * @package    filter_tabs
 * @copyright  2019 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery'], function($) {
    return {
        init: function() {
            var url = document.URL;
            var hash = url.substring(url.indexOf('#'));
            var timer = setInterval(initializeTabs, 0);

            /**
             * Selects tab when hash is changed manually.
             *
             * @returns {undefined}
             */
            function hashHandler() {
                if (isValidHash()) {
                    $("a[href='" + location.hash + "']").tab('show');
                    hash = location.hash;
                }
            }
            window.addEventListener('hashchange', hashHandler, false);

            /**
             * Checks hash is selectable.
             *
             * @returns {Boolean}
             */
            function isValidHash() {
                return hash !== location.hash &&
                        typeof $.fn.tab !== 'undefined' &&
                        $("a[href='" + location.hash + "']");
            }

            /**
             * Preserves fragment identifier when tab is clicked, allowing to save bookmarks.
             *
             * @returns {undefined}
             */
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
                        hash = location.hash;
                    });
                });
                clearInterval(timer);
            }
        }
    };
});
