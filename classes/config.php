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

use core_useragent;

/**
 * Tab type that contains config options
 *
 * @package    filter_tabs
 * @copyright  2026 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class config {
    /**
     * Legacy YUI tabs.
     */
    public const YUI_TABS = 0;

    /**
     * Mobileapp tabs.
     */
    public const MOBILEAPP_TABS = 1;

    /**
     * Bootstrap version 2 tabs.
     */
    public const BOOTSTRAP_2_TABS = 2;

    /**
     * Bootstrap version 4 tabs.
     */
    public const BOOTSTRAP_4_TABS = 4;

    /**
     * Bootstrap version 5 tabs.
     */
    public const BOOTSTRAP_5_TABS = 5;

    /**
     * Templates filename mapping.
     *
     * @var array
     */
    private const TEMPLATES = [
        self::YUI_TABS => [
            'template' => 'filter_tabs/yui',
            'version'  => self::YUI_TABS,
        ],
        self::MOBILEAPP_TABS => [
            'template' => 'filter_tabs/mobileapp',
            'version'  => self::MOBILEAPP_TABS,
        ],
        self::BOOTSTRAP_2_TABS => [
            'template' => 'filter_tabs/bootstrap2',
            'version'  => self::BOOTSTRAP_2_TABS,
        ],
        self::BOOTSTRAP_4_TABS => [
            'template' => 'filter_tabs/bootstrap4',
            'version'  => self::BOOTSTRAP_4_TABS,
        ],
        self::BOOTSTRAP_5_TABS => [
            'template' => 'filter_tabs/bootstrap5',
            'version'  => self::BOOTSTRAP_5_TABS,
        ],
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
     * @return config
     */
    public static function create(\stdClass $filtertabsconfig): config {
        if (core_useragent::is_moodle_app()) {
            return new config(self::TEMPLATES[self::MOBILEAPP_TABS]['template']);
        }

        $templateconfig = self::TEMPLATES[(int) $filtertabsconfig->enablebootstrap];

        return new config($templateconfig['template']);
    }

    /**
     * Gets template filename.
     *
     * @return string
     */
    public function get_template(): string {
        return $this->template;
    }
}
