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
 * This file contains the JS code to support filter_tabs.
 *
 * @package    filter_tabs
 * @copyright  2026 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

const context = this;

class AddonTabsFilterHandler {

    constructor() {
        this.name = 'AddonTabsFilterHandler';
        this.filterName = 'tabs';
        this.timeoutId = 0;
    }

    isEnabled() {
        return true;
    }

    shouldBeApplied(options, site) {
        return !!(site && site.getId() === context.CoreSitesProvider.getCurrentSiteId());
    }

    filter(text, filter, options, siteId) {
        return text;
    }

    handleHtml(container, filter, options, viewContainerRef, component, componentId, siteId) {
        const segments = container.querySelectorAll('ion-segment');
        segments.forEach(segment => {
            segment.addEventListener('ionChange', (event) => {
                event.stopPropagation();
            });
        });
    }
}

this.CoreFilterDelegate.registerHandler(new AddonTabsFilterHandler());