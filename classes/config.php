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

namespace filter_tabs;

/**
 * Tab type that contains config options
 *
 * @package    filter_tabs
 * @copyright  2022 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class config {

    /**
     * Legacy YUI tabs.
     */
    const YUI_TABS = "0";

    /**
     * Bootstrap version 2 tabs.
     */
    const BOOTSTRAP_2_TABS = "1";

    /**
     * Bootstrap version 4 tabs.
     */
    const BOOTSTRAP_4_TABS = "2";

    /**
     * Templates filename mapping.
     *
     * @var array
     */
    const TEMPLATES = [
        self::YUI_TABS => "filter_tabs/yui",
        self::BOOTSTRAP_2_TABS => "filter_tabs/bootstrap2",
        self::BOOTSTRAP_4_TABS => "filter_tabs/bootstrap4",
    ];

    /**
     * @var string Template filename
     */
    private $template;

    /**
     * Private constructor
     *
     * @param string $template
     */
    private function __construct(string $template) {
        $this->template = $template;
    }

    /**
     * Creates config plugin.
     *
     * @param \stdClass $filtertabsconfig
     * @return bool
     */
    public static function create(\stdClass $filtertabsconfig) {
        $type = isset($filtertabsconfig->enablebootstrap)
                ? $filtertabsconfig->enablebootstrap
                : self::BOOTSTRAP_4_TABS;
        return new config(self::TEMPLATES[$type]);
    }

    /**
     * Gets template filename.
     *
     * @return string
     */
    public function get_template() {
        return $this->template;
    }
}
