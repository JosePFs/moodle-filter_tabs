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
 * Unit tests.
 *
 * @package filter_tabs
 * @category test
 * @copyright 2017 José Puente <jpuentefs@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use filter_tabs\plugin_config;

/**
 * Tests for filter_tabs.
 *
 * @package filter_tabs
 * @copyright 2017 José Puente
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_tabs_filter_testcase extends advanced_testcase {

    /**
     * Tests setup
     */
    public function setUp() : void {
        parent::setUp();

        $this->resetAfterTest(true);
        $this->setAdminUser();

        filter_manager::reset_caches();
        filter_set_global_state('tabs', TEXTFILTER_ON);
    }

    /**
     * Test filter no modified
     */
    public function test_filter_no_modified() {
        $html = '<p>No modificable content</p>';
        $filtered = format_text($html, FORMAT_HTML);
        $this->assertEquals($html, $filtered);
    }

    /**
     * Test filter modified yui
     */
    public function test_filter_modified_yui() {
        set_config('enablebootstrap', plugin_config::YUI_TABS, 'filter_tabs');

        $html = '<p>{%:First tab}Some text{%}{%:Second tab}Another text{%}</p>';
        $filtered = format_text($html, FORMAT_HTML);
        $this->assertStringContainsStringIgnoringCase('yui3-tabview-loading', $filtered);
    }

    /**
     * Test filter modified bootstrap2
     */
    public function test_filter_modified_bootstrap2() {
        set_config('enablebootstrap', plugin_config::BOOTSTRAP_2_TABS, 'filter_tabs');

        $html = '<p>{%:First tab}Some text{%}{%:Second tab}Another text{%}</p>';
        $filtered = format_text($html, FORMAT_HTML);
        $this->assertStringContainsStringIgnoringCase('tab-content', $filtered);
        $this->assertStringNotContainsString('boots-tabs', $filtered);
    }

    /**
     * Test filter modified bootstrap4
     */
    public function test_filter_modified_bootstrap4() {
        set_config('enablebootstrap', plugin_config::BOOTSTRAP_4_TABS, 'filter_tabs');

        $html = '<p>{%:First tab}Some text{%}{%:Second tab}Another text{%}</p>';
        $filtered = format_text($html, FORMAT_HTML);
        $this->assertStringContainsStringIgnoringCase('boots-tabs', $filtered);
    }
}
