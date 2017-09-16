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
     * This was implemented with a random number previously, but was changed to a static counter for performance reasons.
     *
     * @var integer Counter for tabgroups
     */
    private static $filtertabstabgroupcounter = 1;

    /**
     * This function replaces the tab syntax with YUI / Bootstrap HTML code.
     *
     * @param string $text The text to filter.
     * @param array $options The filter options.
     */
    public function filter ($text, array $options = array() ) {
        if (!is_string($text) || empty($text) || strpos($text, '{%') === false ||
           (!$successmatch = preg_match_all("/\{%:([^}]*)\}(.*?)\{%\}/s", $text, $matches))) {
            return $text;
        }
        // Get config.
        $filtertabsconfig = get_config('filter_tabs');

        // Prepare newtext variable.
        $newtext = '';

        $isbootstrapenabled = isset($filtertabsconfig->enablebootstrap) &&
                              $filtertabsconfig->enablebootstrap !== self::YUI_TABS;

        // Generate tabs.
        if ($isbootstrapenabled && $filtertabsconfig->enablebootstrap === self::BOOTSTRAP_4_TABS) {
            $newtext = $this->generate_bootstrap4_tabs($matches);
        } else if ($isbootstrapenabled) {
            $newtext = $this->generate_bootstrap2_tabs($matches);
        } else { // Or provide legacy YUI tabs.
            $newtext = $this->generate_yui_tabs($matches);
        }

        // Increase tabgroup counter.
        self::$filtertabstabgroupcounter++;

        // Apply filter.
        $textbefore = substr($text, 0, strpos($text, "{%:"));
        $textafter = substr($text, strpos($text, "{%:"));
        $text = preg_replace("/\{%:([^}]*)\}(.*?)\{%\}/s", "", $textbefore)
                . $newtext .
                preg_replace("/\{%:([^}]*)\}(.*?)\{%\}/s", "", $textafter);

        return $text;
    }

    /**
     * Generate bootstrap 4 tabs.
     *
     * @param array $matches
     * @return string
     */
    private function generate_bootstrap4_tabs(array $matches) {
        // Get ID for tab group.
        $id = self::$filtertabstabgroupcounter;

        // Start tabs group.
        $newtext = '<div id="filter-tabs-tabgroup-'.$id.'" class="filter-tabs-bootstrap boots-tabs">';

        // Create tabs titles.
        $newtext .= '<ul id="filter-tabs-titlegroup-'.$id.'" class="nav nav-tabs" role="tablist">';

        // Create tabs titles.
        foreach ($matches[1] as $key => $tabtitle) {
            $active = '';
            // The first tab is active.
            if ($key === 0) {
                $active = 'active';
            }
            $newtext .= '<li class="nav-item">'
                    . '<a class="nav-link ' . $active . '" href="#filter-tabs-content-'.$id.'-'.($key + 1).
                    '" data-toggle="tab" role="tab">' . $tabtitle . '</a>'
                    . '</li>';
        }
        $newtext .= '</ul>';

        // Create tabs content.
        $newtext .= '<div id="filter-tabs-content-'.$id.'" class="tab-content">';
        foreach ($matches[2] as $key => $tabtext) {
            $active = '';
            // The first tab is active.
            if ($key === 0) {
                $active = 'in active';
            }
            $newtext .= '<div id="filter-tabs-content-'.$id.'-'.($key + 1).'" class="tab-pane fade '
                    . $active .  '" role="tabpanel">'
                    . '<p>'.$tabtext.'</p>'
                    . '</div>';
        }

        // End tabs content.
        $newtext .= '</div>';

        // End tabs group.
        $newtext .= '</div>';

        return $newtext;
    }

    /**
     * Generates Bootstrap 2 tabs.
     *
     * @param array $matches
     * @return string
     */
    private function generate_bootstrap2_tabs(array $matches) {
        // Get ID for tab group.
        $id = self::$filtertabstabgroupcounter;

        // Start tabs group.
        $newtext = '<div id="filter-tabs-tabgroup-'.$id.'" class="filter-tabs-bootstrap">';

        // Create tabs titles.
        $newtext .= '<ul id="filter-tabs-titlegroup-'.$id.'" class="nav nav-tabs">';

        // Create tabs titles.
        foreach ($matches[1] as $key => $tabtitle) {
            $active = '';
            // The first tab is active.
            if ($key === 0) {
                $active = 'active';
            }
            $newtext .= '<li class="' . $active . '">'
                        . '<a href="#filter-tabs-content-'.$id.'-'.($key + 1).'" data-toggle="tab">'.$tabtitle.'</a>'
                        . '</li>';
        }
        $newtext .= '</ul>';

        // Create tabs content.
        $newtext .= '<div id="filter-tabs-content-'.$id.'" class="tab-content">';
        foreach ($matches[2] as $key => $tabtext) {
            $active = '';
            // The first tab is active.
            if ($key === 0) {
                $active = 'active';
            }
            $newtext .= '<div id="filter-tabs-content-'.$id.'-'.($key + 1).'" class="tab-pane ' . $active . '">'
                        . '<p>'.$tabtext.'</p>'
                        . '</div>';
        }

        // End tabs content.
        $newtext .= '</div>';

        // End tabs group.
        $newtext .= '</div>';

        return $newtext;
    }

    /**
     * Generate legacy YUI tabs.
     *
     * @param array $matches
     * @return string
     */
    private function generate_yui_tabs(array $matches) {
        // Get ID for tab group.
        $id = self::$filtertabstabgroupcounter;

        // Start tab group.
        $newtext = '<div id="filter-tabs-tabgroup-'.$id.'" class="filter-tabs-tabgroup yui3-tabview-loading">';

        // Create tab titles.
        $newtext .= '<ul class="filter-tabs-titlegroup">';
        foreach ($matches[1] as $key => $tabtitle) {
            $newtext .= '<li class="filter-tabs-title"><a href="#filter-tabs-text-'.$id.'-'.($key + 1).'">'.$tabtitle.'</a></li>';
        }
        $newtext .= '</ul>';

        // Create tab texts.
        $newtext .= '<div class="filter-tabs-textgroup">';
        foreach ($matches[2] as $key => $tabtext) {
            $newtext .= '<div id="filter-tabs-text-'.$id.'-'.($key + 1).'" class="filter-tabs-text"><p>'.$tabtext.'</p></div>';
        }
        $newtext .= '</div>';

        // End tab group.
        $newtext .= '</div>';

        // Add YUI enhancement.
        $newtext .= '<script type="text/javascript">
                        YUI().use(\'tabview\', function(Y) {
                        var tabview = new Y.TabView({srcNode:\'#filter-tabs-tabgroup-'.$id.'\'});
                        tabview.render();
                        });
                </script>';

        return $newtext;
    }
}