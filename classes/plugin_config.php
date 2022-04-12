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
class plugin_config {

    /**
     * Legacy YUI tabs.
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
     * @var string Tabs type
     */
    private $style;

    /**
     * Private constructor
     *
     * @param string $style
     */
    private function __construct(string $style) {
        $this->style = $style;
    }

    /**
     * Creates config plugin.
     *
     * @param \stdClass $filtertabsconfig
     * @return bool
     */
    public static function create(\stdClass $filtertabsconfig) {
        $style = isset($filtertabsconfig->enablebootstrap)
                ? $filtertabsconfig->enablebootstrap
                : self::BOOTSTRAP_4_TABS;
        return new plugin_config($style);
    }

    /**
     * True when are Bootstrap 4 tabs.
     *
     * @return bool
     */
    public function isbootstrap4() {
        return $this->style === self::BOOTSTRAP_4_TABS;
    }

    /**
     * True when are Bootstrap 2 tabs.
     *
     * @return bool
     */
    public function isbootstrap2() {
        return $this->style === self::BOOTSTRAP_2_TABS;
    }

    /**
     * True when are YUI tabs.
     *
     * @return bool
     */
    public function isyui() {
        return $this->style === self::YUI_TABS;
    }
}
