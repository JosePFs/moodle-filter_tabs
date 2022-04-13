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

namespace filter_tabs\output;

/**
 * Renderable tabs.
 *
 * @package    filter_tabs
 * @copyright  2022 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderable implements \renderable, \templatable {

    /**
     * Template filename.
     *
     * @var string $template
     */
    private $template;

    /**
     * Tabs.
     *
     * @var array $tabs
     */
    private $tabs;

    /**
     * Creates renderable.
     *
     * @param string $template
     * @param array $tabs
     */
    public function __construct(string $template, array $tabs) {
        $this->template = $template;
        $this->tabs = $tabs;
    }

    /**
     * Gets $templatetype
     *
     * @return string
     */
    public function get_template() {
        return $this->template;
    }

    /**
     * Export data for template.
     *
     * @param \renderer_base $renderer
     *
     * @return array
     */
    public function export_for_template(\renderer_base $renderer) {
        return [
            'tabgroupcounter' => renderer::get_group_counter(),
            'tabs' => $this->tabs,
        ];
    }

}
