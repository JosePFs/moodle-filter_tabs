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

use filter_tabs\config;
use filter_tabs\helper;
use filter_tabs\text_filter;

if ($ADMIN->fulltree) {
    global $CFG, $PAGE;

    require_once($CFG->dirroot . '/filter/tabs/classes/text_filter.php');

    /** @var admin_settingpage $settings */
    $settings->add(new admin_setting_heading(
        'filter_tabs/bootstrapheading',
        get_string('bootstrapheading', 'filter_tabs', null, true),
        ''
    ));

    $tabsconfigsoptions = [
        config::YUI_TABS => get_string('enableyui', 'filter_tabs', null, true),
        config::BOOTSTRAP_2_TABS => get_string('enablebootstrap2', 'filter_tabs', null, true),
        config::BOOTSTRAP_4_TABS => get_string('enablebootstrap4', 'filter_tabs', null, true),
        config::BOOTSTRAP_5_TABS => get_string('enablebootstrap5', 'filter_tabs', null, true),
        ];

    if (($bootstrapversion = helper::get_bootstrap_version())) {
        $version = (int) substr($bootstrapversion, 0, 1);
    }

    $settings->add(new admin_setting_configselect(
        'filter_tabs/enablebootstrap',
        get_string('selecttabs', 'filter_tabs', null, true),
        get_string('selecttabs_desc', 'filter_tabs', null, true),
        $version ?? config::BOOTSTRAP_5_TABS,
        $tabsconfigsoptions
    ));

    if ($bootstrapversion) {
        $suggestedoption = '';
        if ($version === config::BOOTSTRAP_5_TABS) {
            $suggestedoption .= '<br /><small>' . get_string('suggestedoption', 'filter_tabs', null, true) .
                                ": [ \"{$tabsconfigsoptions[config::BOOTSTRAP_5_TABS]}\" ]</small>";
        } else if ($version === config::BOOTSTRAP_4_TABS) {
            $suggestedoption .= '<br /><small>' . get_string('suggestedoption', 'filter_tabs', null, true) .
                                ": [ \"{$tabsconfigsoptions[config::BOOTSTRAP_4_TABS]}\" ]</small>";
        } else if ($version === config::BOOTSTRAP_2_TABS) {
            $suggestedoption .= '<br /><small>' . get_string('suggestedoption', 'filter_tabs', null, true) .
                                ": [ \"{$tabsconfigsoptions[config::BOOTSTRAP_2_TABS]}\" ]</small>";
        } else {
             $suggestedoption .= '<br /><small>' . get_string('suggestedoption', 'filter_tabs', null, true) .
                                 ": [ \"{$tabsconfigsoptions[config::YUI_TABS]}\" ]</small>";
        }

        // Bootstrap or YUI suggestion.
        $settings->add(new admin_setting_heading(
            'filter_tabs_bootstrap_version_header',
            get_string('selecttabs_hint', 'filter_tabs'),
            $bootstrapversion . $suggestedoption
        ));

        // Preview.
        $context = context_system::instance();
        $filtertabs = new text_filter($context, []);
        $filtertabs->setup($PAGE, $context);
        $tabsfilteredtext = $filtertabs->filter('{%:First tab}Some text{%}{%:Second tab}Another text{%}');
        $settings->add(new admin_setting_heading(
            'filter_tabs_preview_header',
            get_string('previewheading', 'filter_tabs'),
            trim(preg_replace('/\s\s+/', ' ', $tabsfilteredtext))
        ));
    }
}
