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
 * @package     filter
 * @subpackage  filter_tabs
 * @copyright   2013 Alexander Bias, University of Ulm <alexander.bias@uni-ulm.de>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class filter_tabs extends moodle_text_filter {
    function filter ($text, array $options = array() ) {
        global $CFG;

        // Search filter placeholder
        preg_match_all("/\{%:([^}]*)\}(.*?)\{%\}/s", $text, $matches);

        // Do if placeholder is found
        if (count($matches[1]) > 0) {
            // Create random ID for tab group
            $id = rand()*100000;

            // Start tab group
            $newtext ='<div id="filter-tabs-tabgroup-'.$id.'" class="filter-tabs-tabgroup yui3-tabview-loading">';

            // Create tab titles
            $newtext.='<ul class="filter-tabs-titlegroup">';
            foreach ($matches[1] as $key => $tabtitle) {
                $newtext.= '<li class="filter-tabs-title"><a href="#filter-tabs-text-'.$id.'-'.($key+1).'">'.$tabtitle.'</a></li>';
            }
            $newtext.='</ul>';

            // Create tab texts
            $newtext.='<div class="filter-tabs-textgroup">';
            foreach ($matches[2] as $key => $tabtext) {
                $newtext.= '<div id="filter-tabs-text-'.$id.'-'.($key+1).'" class="filter-tabs-text"><p>'.$tabtext.'</p></div>';
            }
            $newtext.='</div>';

            // End tab group
            $newtext.='</div>';

            // Add YUI enhancement
            $newtext.='<script type="text/javascript">
                            YUI().use(\'tabview\', function(Y) {
                            var tabview = new Y.TabView({srcNode:\'#filter-tabs-tabgroup-'.$id.'\'});
                            tabview.render();
                            });
                    </script>';

            // Apply filter
            $text_before = substr($text, 0, strpos($text, "{%:"));
            $text_after = substr($text, strpos($text, "{%:"));
            $text = preg_replace("/\{%:([^}]*)\}(.*?)\{%\}/s", "", $text_before).$newtext.preg_replace("/\{%:([^}]*)\}(.*?)\{%\}/s", "", $text_after);
        }

        return $text;
    }
}
