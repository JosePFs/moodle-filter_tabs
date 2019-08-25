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
 * Bootstrap 4 HTML renderer
 *
 * @package    filter_tabs
 * @copyright  2019 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Renders Bootstrap 4 tabs HTML
 *
 * @package    filter_tabs
 * @copyright  2019 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class bootstrap4_renderer {

    /**
     * Filter tab group counter.
     *
     * @var integer
     */
    private $id;

    public function __construct(int $id) {
        $this->id = $id;
    }

    public function render(array $titlesandcontents) {
        $newtext = $this->create_tabs_group();
        $newtext .= $this->create_tabs_container();

        // Create tabs titles.
        foreach ($titlesandcontents[1] as $key => $tabtitle) {
            $newtext .= $this->create_tab_title($key, $tabtitle);
        }
        // End tabs container.
        $newtext .= '</ul>';

        // Create tabs content.
        $newtext .= $this->create_tabs_content_container();
        foreach ($titlesandcontents[2] as $key => $tabtext) {
            $newtext .= $this->create_tab_content($key, $tabtext, $titlesandcontents[1]);
        }

        // End tabs content. End tabs group.
        $newtext .= '</div></div>';

        return $newtext;
    }

    /**
     * Creates Bootstrap 4 div tabs group.
     *
     * @return string
     */
    private function create_tabs_group() {
        return '<div id="filter-tabs-tabgroup-'.$this->id.'" class="filter-tabs-bootstrap boots-tabs">';
    }

    /**
     * Creates Bootstrap 4 ul tabs container.
     *
     * @return string
     */
    private function create_tabs_container() {
        return '<ul id="filter-tabs-titlegroup-'.$this->id.'" class="nav nav-tabs" role="tablist">';
    }

    /**
     * Creates Bootstrap 4 tab title.
     *
     * @param int $key
     * @param string $tabtitle
     * @return string
     */
    private function create_tab_title(int $key, string $tabtitle) {
        $activeclass = $key === 0 ? 'active' : '';

        return '<li class="nav-item">'
                . '<a class="nav-link '.$activeclass.'" href="#filter-tabs-content-'
                . $this->id.'-'.($key + 1)
                . '" data-toggle="tab" role="tab">'.$tabtitle .'</a>'
                . '</li>';
    }

    /**
     * Creates Bootstrap 4 ul tabs content container.
     *
     * @return string
     */
    private function create_tabs_content_container() {
        return '<div id="filter-tabs-content-'.$this->id.'" class="tab-content">';
    }

    /**
     * Creates Bootstrap 4 tab content.
     *
     * @param int $key
     * @param string $tabtext
     * @param array $titles
     * @return string
     */
    private function create_tab_content(int $key, string $tabtext, array $titles) {
        $activeclass = $key === 0 ? 'in active' : '';

        return '<div id="filter-tabs-content-'.$this->id.'-'.($key + 1).'" class="tab-pane fade '
                    . $activeclass.'" role="tabpanel">'
                    . $this->create_tabs_container($this->id.'-printable')
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