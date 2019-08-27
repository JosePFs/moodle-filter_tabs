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
 * Filter "tabs"
 *
 * @package    filter_tabs
 * @copyright  2013 Stefan Lehneis, University of Regensburg <stefan.lehneis@rz.uni-regensburg.de> /
 *             2014 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de> /
 *             2017 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Filter converting token text into tabs
 *
 * @package    filter_tabs
 * @copyright  2013 Stefan Lehneis, University of Regensburg <stefan.lehneis@rz.uni-regensburg.de> /
 *             2014 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de> /
 *             2017 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_tabs extends moodle_text_filter {

    /**
     * Legacy YUI tabs,
     */
    const YUI_TABS = '0';

    /**
     * Bootstrap version 2 tabs.
     */
    const BOOTSTRAP_2_TABS = '1';

    /**
     * Bootstrap version 4 tabs.
     */
    const BOOTSTRAP_4_TABS = '2';

    /**
     * This function replaces the tab syntax with YUI / Bootstrap HTML code.
     *
     * @param string $text The text to filter.
     * @param array $options The filter options.
     */
    public function filter($text, array $options = array() ) {
        global $PAGE;

        if (!is_string($text) || empty($text) || strpos($text, '{%') === false ||
           (!$successmatch = preg_match_all("/\{%:([^}]*)\}(.*?)\{%\}/s", $text, $matches))) {
            return $text;
        }
        // Get config.
        $filtertabsconfig = get_config('filter_tabs');

        $isbootstrapenabled = isset($filtertabsconfig->enablebootstrap) &&
                              $filtertabsconfig->enablebootstrap !== self::YUI_TABS;

        $renderer = $PAGE->get_renderer('filter_tabs');
        // Generate tabs.
        if ($isbootstrapenabled && $filtertabsconfig->enablebootstrap === self::BOOTSTRAP_4_TABS) {
            $newtext = $renderer->render_bootstrap4_tabs($matches);
        } else if ($isbootstrapenabled) {
            $newtext = $renderer->render_bootstrap2_tabs($matches);
        } else { // Or provide legacy YUI tabs.
            $newtext = $renderer->render_yui_tabs($matches);
        }

        filter_tabs_renderer::increase_group_counter();

        // Apply filter.
        $textbefore = substr($text, 0, strpos($text, "{%:"));
        $textafter = substr($text, strpos($text, "{%:"));
        $text = preg_replace("/\{%:([^}]*)\}(.*?)\{%\}/s", "", $textbefore)
                . $newtext .
                preg_replace("/\{%:([^}]*)\}(.*?)\{%\}/s", "", $textafter);

        return $text;
    }
}