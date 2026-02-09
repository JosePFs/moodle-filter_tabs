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

/**
 * Tabs filter upgrade code.
 *
 * @package    filter_tabs
 * @copyright  2017 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use filter_tabs\config;
use filter_tabs\helper;

/**
 * Tasks to do when plugin version is upgraded
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_filter_tabs_upgrade($oldversion) {

    // Moodle v5.0.0 release upgrade line.
    // Put any upgrade step following this.
    if ($oldversion < 2026020905) {
        if (($bootsrapversion = helper::get_bootstrap_version())) {
            $majorbootstrapversion = substr($bootsrapversion, 0, 1);
            if ($majorbootstrapversion === '5') {
                set_config('enablebootstrap', config::BOOTSTRAP_5_TABS, 'filter_tabs');
            } else if ($majorbootstrapversion === '4') {
                set_config('enablebootstrap', config::BOOTSTRAP_4_TABS, 'filter_tabs');
            } else if ($majorbootstrapversion === '2') {
                set_config('enablebootstrap', config::BOOTSTRAP_2_TABS, 'filter_tabs');
            } else {
                set_config('enablebootstrap', config::YUI_TABS, 'filter_tabs');
            }
        }

        upgrade_plugin_savepoint(true, 2026020905, 'filter', 'tabs');
    }

    return true;
}
