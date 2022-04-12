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
 * Bootstrap2 tabs renderer
 *
 * @package    filter_tabs
 * @copyright  2022 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer_bootstrap2 implements renderer {

    /**
     * Generates Bootstrap 2 tabs.
     *
     * @param int $tabgroupcounter
     * @param array $matches
     * @return string
     */
    public function render(int $tabgroupcounter, array $matches) {
        // Start tabs group.
        $newtext = '<div id="filter-tabs-tabgroup-'.$tabgroupcounter.'" class="filter-tabs-bootstrap">';

        // Create tabs titles.
        $newtext .= '<ul id="filter-tabs-titlegroup-'.$tabgroupcounter.'" class="nav nav-tabs">';

        // Create tabs titles.
        foreach ($matches[1] as $key => $tabtitle) {
            $active = '';
            // The first tab is active.
            if ($key === 0) {
                $active = 'active';
            }
            $newtext .= '<li class="' . $active . '">'
                        . '<a href="#filter-tabs-content-'.$tabgroupcounter.'-'.($key + 1).'" data-toggle="tab">'.$tabtitle.'</a>'
                        . '</li>';
        }
        $newtext .= '</ul>';

        // Create tabs content.
        $newtext .= '<div id="filter-tabs-content-'.$tabgroupcounter.'" class="tab-content">';
        foreach ($matches[2] as $key => $tabtext) {
            $active = '';
            // The first tab is active.
            if ($key === 0) {
                $active = 'active';
            }
            $newtext .= '<div id="filter-tabs-content-'.$tabgroupcounter.'-'.($key + 1).'" class="tab-pane ' . $active . '">'
                        . '<p>'.$tabtext.'</p>'
                        . '</div>';
        }

        // End tabs content.
        $newtext .= '</div>';

        // End tabs group.
        $newtext .= '</div>';

        return $newtext;
    }
}
