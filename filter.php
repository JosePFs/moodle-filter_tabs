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

use filter_tabs\config;
use filter_tabs\output\renderable;
use filter_tabs\output\renderer;
use filter_tabs\tab;

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
     * Page.
     *
     * @var moodle_page $page.
     */
    private $page;

    /**
     * Plugin renderer.
     *
     * @var renderer $renderer.
     */
    private $renderer;

    /**
     * Insert JS scripts to page using amd.
     *
     * @param moodle_page $page The current page.
     * @param context $context The current context.
     */
    public function setup($page, $context) {
        $this->page = $page;

        static $initialised = false;

        if(!$initialised){
            $page->requires->js_call_amd('filter_tabs/tabs', 'init');
            $initialised = true;
        }

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
            !preg_match_all(self::PLACEHOLDER_PATTERN, $text, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
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
     * @return string
     */
    private function generate_tabs(array $matches) {
        if ($this->renderer === null) {
            $this->renderer = $this->page->get_renderer('filter_tabs');
        }

        $config = config::create(get_config('filter_tabs'));
        $tabs = tab::from_matches($matches);

        return $this->renderer->render(new renderable($config->get_template(), $tabs));
    }
}
