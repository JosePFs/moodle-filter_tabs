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
 * Filter "tabs" - Settings
 *
 * @package    filter_tabs
 * @copyright  2014 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de> /
 *             2017 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    global $CFG;
    require_once($CFG->dirroot . '/filter/tabs/filter.php');
    require_once($CFG->dirroot . '/filter/tabs/classes/helper.php');

    // Appearance.
    $settings->add(new admin_setting_heading(
                'filter_tabs/bootstrapheading',
                get_string('bootstrapheading', 'filter_tabs', null, true),
                '')
            );

    $tabstypesoptions = array(
        filter_tabs::YUI_TABS => get_string('enableyui', 'filter_tabs', null, true),
        filter_tabs::BOOTSTRAP_2_TABS => get_string('enablebootstrap2', 'filter_tabs', null, true),
        filter_tabs::BOOTSTRAP_4_TABS => get_string('enablebootstrap4', 'filter_tabs', null, true)
        );

    $settings->add(new admin_setting_configselect(
                'filter_tabs/enablebootstrap',
                get_string('selecttabs', 'filter_tabs', null, true),
                get_string('selecttabs_desc', 'filter_tabs', null, true),
                filter_tabs::BOOTSTRAP_2_TABS,
                $tabstypesoptions)
            );

    if (($bootsrapversion = filter_tabs_helper::get_bootstrap_version())) {
        $version = substr($bootsrapversion, 0, 1);
        $suggestedoption = '';
        if ($version !== '4') {
            $suggestedoption .= '<br /><small>' . get_string('suggestedoption', 'filter_tabs', null, true) .
                                ": [ \"{$tabstypesoptions[filter_tabs::BOOTSTRAP_2_TABS]}\" ]</small>";
        } else {
            $suggestedoption .= '<br /><small>' . get_string('suggestedoption', 'filter_tabs', null, true) .
                                ": [ \"{$tabstypesoptions[filter_tabs::BOOTSTRAP_4_TABS]}\" ]</small>";
        }

        // Bootstrap suggestion.
        $settings->add(new admin_setting_heading(
                'filter_tabs_bootstrap_version_header',
                get_string('selecttabs_hint', 'filter_tabs'),
                $bootsrapversion . $suggestedoption)
            );

        // Preview.
        $filtertabs = new filter_tabs(context_system::instance(), array());
        $tabsfilteredtext = $filtertabs->filter('{%:First tab}Some text{%}{%:Second tab}Another text{%}');
        $settings->add(new admin_setting_heading(
                'filter_tabs_preview_header',
                get_string('previewheading', 'filter_tabs'),
                trim(preg_replace('/\s\s+/', ' ', $tabsfilteredtext)))
            );
    }
}
