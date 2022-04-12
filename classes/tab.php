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

use Stringable;

/**
 * Tab.
 *
 * @package    filter_tabs
 * @copyright  2022 José Puente <jpuentefs@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class tab {

    private $title;

    private $content;

    private $key;

    private $active = "";

    private function __construct(string $title, string $content, int $key, string $active) {
        $this->title = $title;
        $this->content = $content;
        $this->key = $key;
        $this->active = $active;
    }

    private static function create(string $title, string $content, int $key, string $active) {
        return new tab($title, $content, $key, $active);
    }

    public static function from_matches(array $matches) {
        return array_map(function ($match, $key) {
            return static::create($match[1][0], $match[2][0], $key + 1, $key === 0 ? "active" : "");
        }, $matches, array_keys($matches));
    }

    public function get_title() {
        return $this->title;
    }

    public function get_content() {
        return $this->content;
    }

    public function get_key() {
        return $this->key;
    }

    public function get_active() {
        return $this->active;
    }
}
