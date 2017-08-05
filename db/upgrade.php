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

defined('MOODLE_INTERNAL') || die();

/**
 * Boostrap version used by new themes based on Boots (for example).
 */
define('BOOTSTRAP_4_VERSION', '4');

/**
 * Tasks to do when plugin version is upgraded
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_filter_tabs_upgrade($oldversion) {

    // Moodle v3.2.0 release upgrade line.
    // Put any upgrade step following this.
    if ($oldversion < 2017072700) {
        global $CFG;
        require_once($CFG->dirroot . '/filter/tabs/filter.php');
        require_once($CFG->dirroot . '/filter/tabs/classes/helper.php');

        if (($bootsrapversion = filter_tabs_helper::get_bootstrap_version())) {
            if (substr($bootsrapversion, 0, 1) === BOOTSTRAP_4_VERSION) {
                set_config('enablebootstrap', filter_tabs::BOOTSTRAP_4_TABS, 'filter_tabs');
            }
        }

        upgrade_plugin_savepoint(true, 2017072700, 'filter', 'tabs');
    }

    return true;
}
