<?php
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

namespace filter_tabs\output;

/**
 * Renderable tabs.
 *
 * @package    filter_tabs
 * @copyright  2022 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mobile {
    /**
     * Initialization function for filter_tabs in Moodle Mobile.
     *
     * @param  array $args Arguments from tool_mobile_get_content WS
     * @return array Templates and javascript
     */
    public static function mobile_init($args): array|null {
        global $CFG;

        if (!filter_is_enabled('tabs')) {
            return null;
        }

        return [
            'templates' => [],
            'javascript' => file_get_contents($CFG->dirroot . '/filter/tabs/mobileapp/init.js'),
        ];
    }
}
