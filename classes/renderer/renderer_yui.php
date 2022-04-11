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

namespace filter_tabs\renderer;

use filter_tabs\renderer\renderer;

/**
 * YUI tabs renderer
 *
 * @package    filter_tabs
 * @copyright  2022 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer_yui implements renderer {

    /**
     * Generates legacy YUI tabs.
     *
     * @param array $matches
     * @return string
     */
    public function render(int $tabgroupcounter, array $matches) {
        // Start tab group.
        $newtext = '<div id="filter-tabs-tabgroup-'.$tabgroupcounter.'" class="filter-tabs-tabgroup yui3-tabview-loading">';

        // Create tab titles.
        $newtext .= '<ul class="filter-tabs-titlegroup">';
        foreach ($matches[1] as $key => $tabtitle) {
            $newtext .= '<li class="filter-tabs-title">'
                    . '<a href="#filter-tabs-text-'.$tabgroupcounter.'-'.($key + 1).'">'.$tabtitle.'</a>'
                    . '</li>';
        }
        $newtext .= '</ul>';

        // Create tab texts.
        $newtext .= '<div class="filter-tabs-textgroup">';
        foreach ($matches[2] as $key => $tabtext) {
            $newtext .= '<div id="filter-tabs-text-'.$tabgroupcounter.'-'.($key + 1).'" class="filter-tabs-text">'
                    . '<p>'.$tabtext.'</p>'
                    . '</div>';
        }
        $newtext .= '</div>';

        // End tab group.
        $newtext .= '</div>';

        // Add YUI enhancement.
        $newtext .= '<script type="text/javascript">
                        YUI().use(\'tabview\', function(Y) {
                        var tabview = new Y.TabView({srcNode:\'#filter-tabs-tabgroup-'.$tabgroupcounter.'\'});
                        tabview.render();
                        });
                </script>';

        return $newtext;
    }
}
