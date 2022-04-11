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

use filter_tabs\plugin_config;
use filter_tabs\renderer_factory;

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
     * Placeholder for tabs.
     */
    const PLACEHOLDER_PATTERN = '/\{%:([^}]*)\}(.*?)\{%\}/s';

    /**
     * This was implemented with a random number previously, but was changed to a static counter for performance reasons.
     *
     * @var integer Counter for tabgroups
     */
    private static $tabgroupcounter = 1;

    /**
     * Insert JS scripts to page using amd.
     *
     * @param moodle_page $page The current page.
     * @param context $context The current context.
     */
    public function setup($page, $context) {
        $page->requires->js_call_amd('filter_tabs/tabs', 'init');
    }

    /**
     * This function replaces the tab syntax with YUI / Bootstrap HTML code.
     *
     * @param string $text The text to filter.
     * @param array $options The filter options.
     */
    public function filter($text, array $options = array() ) {
        if (!($matches = $this->get_matches($text))) {
            return $text;
        }

        return $this->replace_text($text, $matches);
    }

    /**
     * Looks for placeholders.
     *
     * @param string $text
     * @return null|array
     */
    private function get_matches(string $text) {
        if (!is_string($text) || empty($text) || strpos($text, '{%') === false ||
            !preg_match_all(self::PLACEHOLDER_PATTERN, $text, $matches)) {
            return null;
        }
        return $matches;
    }

    /**
     * Replaces placeholders with tabs.
     *
     * @param string $text
     * @param array $matches
     * @return string
     */
    private function replace_text(string $text, array $matches) {
        $textbefore = substr($text, 0, strpos($text, "{%:"));
        $textafter = substr($text, strpos($text, "{%:"));
        $text = preg_replace(self::PLACEHOLDER_PATTERN, "", $textbefore)
                . $this->generate_tabs($matches) .
                preg_replace(self::PLACEHOLDER_PATTERN, "", $textafter);

        return $text;
    }

    /**
     * Generates tabs.
     *
     * @param array $matches
     * @return config
     */
    private function generate_tabs(array $matches) {
        $config = plugin_config::create(get_config('filter_tabs'));
        $renderer = renderer_factory::create($config);
        $html = $renderer->render(self::$tabgroupcounter, $matches);

        self::increase_group_counter();

        return $html;
    }

    /**
     * Increases group counter id.
     */
    public static function increase_group_counter() {
        self::$tabgroupcounter++;
    }
}
