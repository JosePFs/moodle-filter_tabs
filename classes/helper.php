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
 * Theme verifications helper
 *
 * @package    filter_tabs
 * @copyright  2017 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Checks current theme in use.
 *
 * @package    filter_tabs
 * @copyright  2017 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_tabs_helper {

    /**
     * Bootstraps's string in thirdpartylibs file.
     */
    const BOOTSTRAP_DEFINITION = 'Twitter Bootstrap';

    /**
     * Get Bootstrap version of the current theme and its parents.
     *
     * @return boolean|string Version or false if not found.
     */
    public static function get_bootstrap_version() {
        global $PAGE, $CFG;

        $currentthemedir = isset($CFG->themedir) ? $CFG->themedir : $PAGE->theme->dir;
        $thirdpartylibsfile = $currentthemedir . '/thirdpartylibs.xml';
        if (($version = self::get_version_from_xml_file($thirdpartylibsfile))) {
            return $version;
        }

        $themedir = isset($CFG->themedir) ? $CFG->themedir : $CFG->dirroot . '/theme';
        foreach ($PAGE->theme->parents as $parent) {
            $thirdpartylibsfile = $themedir . '/' . $parent . '/thirdpartylibs.xml';
            if (($version = self::get_version_from_xml_file($thirdpartylibsfile))) {
                return $version;
            }
        }
        return false;
    }

    /**
     * Checks xml file searching 'Twitter Bootstrap'
     *
     * @param string $path
     * @return boolean|string Version or false if not found.
     */
    private static function get_version_from_xml_file($path) {
        if (!file_exists($path)) {
            return false;
        }

        $xml = simplexml_load_file($path);
        foreach ($xml->library as $libobject) {
            if ((string) $libobject->name === self::BOOTSTRAP_DEFINITION) {
                return (string) $libobject->version;
            }
        }
        return false;
    }
}