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
 * Basic tabs strategy renderer
 *
 * @package    filter_tabs
 * @copyright  2022 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer_bootstrap4 implements renderer {

    /**
     * Renders Bootstrap 4 tabs.
     *
     * @param array $titlesandcontents
     * @return string
     */
    public function render(int $tabgroupcounter, array $titlesandcontents) {
        $newtext = $this->create_tabs_group($tabgroupcounter);

        $newtext .= $this->create_tabs_container($tabgroupcounter);
        foreach ($titlesandcontents[1] as $key => $tabtitle) {
            $newtext .= $this->create_tab_title($tabgroupcounter, $key, $tabtitle);
        }
        $newtext .= $this->close_tabs_container();

        $newtext .= $this->create_tabs_content_container($tabgroupcounter);
        foreach ($titlesandcontents[2] as $key => $tabtext) {
            $newtext .= $this->create_tab_content($tabgroupcounter, $key, $tabtext, $titlesandcontents[1]);
        }
        $newtext .= $this->close_tabs_content_container();

        $newtext .= $this->close_tabs_group();

        return $newtext;
    }

    /**
     * Creates Bootstrap 4 div tabs group.
     *
     * @param int $tabgroupcounter
     * @return string
     */
    private function create_tabs_group(int $tabgroupcounter) {
        return '<div id="filter-tabs-tabgroup-'.$tabgroupcounter.'" class="filter-tabs-bootstrap boots-tabs">';
    }

    /**
     * Closes Bootstrap 4 div tabs group.
     *
     * @return string
     */
    private function close_tabs_group() {
        return '</div>';
    }

    /**
     * Creates Bootstrap 4 ul tabs container.
     *
     * @param string $tabgroupcounter
     * @return string
     */
    private function create_tabs_container(string $tabgroupcounter) {
        return '<ul id="filter-tabs-titlegroup-'.$tabgroupcounter.'" class="nav nav-tabs" role="tablist">';
    }

    /**
     * Closes Bootstrap 4 ul tabs container.
     *
     * @return string
     */
    private function close_tabs_container() {
        return '</ul>';
    }

    /**
     * Creates Bootstrap 4 tab title.
     *
     * @param int $tabgroupcounter
     * @param int $key
     * @param string $tabtitle
     * @return string
     */
    private function create_tab_title(int $tabgroupcounter, int $key, string $tabtitle) {
        $activeclass = $key === 0 ? 'active' : '';

        return '<li class="nav-item">'
                . '<a class="nav-link '.$activeclass.'" href="#filter-tabs-content-'
                . $tabgroupcounter.'-'.($key + 1)
                . '" data-toggle="tab" role="tab">'.$tabtitle .'</a>'
                . '</li>';
    }

    /**
     * Creates Bootstrap 4 ul tabs content container.
     *
     * @param int $tabgroupcounter
     * @return string
     */
    private function create_tabs_content_container(int $tabgroupcounter) {
        return '<div id="filter-tabs-content-'.$tabgroupcounter.'" class="tab-content">';
    }

    /**
     * Closes Bootstrap 4 ul tabs content container.
     *
     * @return string
     */
    private function close_tabs_content_container() {
        return '</div>';
    }

    /**
     * Creates Bootstrap 4 tab content.
     *
     * @param int $tabgroupcounter
     * @param int $key
     * @param string $tabtext
     * @param array $titles
     * @return string
     */
    private function create_tab_content(int $tabgroupcounter, int $key, string $tabtext, array $titles) {
        $activeclass = $key === 0 ? 'in active' : '';

        return '<div id="filter-tabs-content-'.$tabgroupcounter.'-'.($key + 1).'" class="tab-pane fade '
                    . $activeclass.'" role="tabpanel">'
                    . $this->create_tabs_container($tabgroupcounter.'-printable')
                    . $this->create_tab_title_printable($titles[$key])
                    . '</ul>'
                    . '<p>'.$tabtext.'</p>'
                    . '</div>';
    }

    /**
     * Creates Bootstrap 4 printable tab title.
     *
     * @param string $tabtitle
     * @return string
     */
    private function create_tab_title_printable(string $tabtitle) {
        return '<li class="nav-item"><span class="nav-link active">'.$tabtitle.'</span></li>';
    }
}



