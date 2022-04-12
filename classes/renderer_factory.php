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

use filter_tabs\plugin_config;
use filter_tabs\renderer\renderer_bootstrap4;
use filter_tabs\renderer\renderer_bootstrap2;
use filter_tabs\renderer\renderer_yui;
use filter_tabs\renderer\renderer;

/**
 * Tabs renderers factory
 *
 * @package    filter_tabs
 * @copyright  2022 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer_factory {

    /**
     * @param plugin_config $config
     *
     * @return renderer
     */
    public static function create(plugin_config $config) {
        if ($config->isbootstrap4()) {
            return new renderer_bootstrap4();
        } else if ($config->isbootstrap2()) {
            return new renderer_bootstrap2();
        } else {
            return new renderer_yui();
        }
    }

}
