moodle-filter_tabs
===================

Changes
-------

### v3.2-r4

* 2017-09-16 - Fix php unit notice

### v3.2-r3

* 2017-09-16 - Fix code checker errors

### v3.2-r2

* 2017-08-05 - Added tabs preview in settings page

### v3.2-r1

* 2017-07-27 - Added compatibility for Moodle 3.2

### Unreleased

* 2017-01-12 - Move Changelog from README.md to CHANGES.md

### v3.1-r1

* 2016-07-19 - Check compatibility for Moodle 3.1, no functionality change

### Changes before v3.1

* 2016-02-10 - Change plugin version and release scheme to the scheme promoted by moodle.org, no functionality change
* 2016-02-03 - Remove Bootstrap tabs library which was shipped with this plugin as it should be contained in Moodle themes.
* 2016-01-01 - Remove loading of jQuery and the Bootstrap tabs library because of problems in recent Moodle versions. The filter should still work in all Bootstrap based Moodle themes. If you encounter problems in your theme, please report the problem on https://github.com/moodleuulm/moodle-filter_tabs/issues and / or use the 2.9 version of the plugin
* 2016-01-01 - Check compatibility for Moodle 3.0, no functionality change
* 2015-11-29 - Add support for right-to-left (RTL) languages - Credtits to nadavkav
* 2015-11-02 - Supress the list item bullet point which appeared in some themes within the tab
* 2015-08-31 - Remove experimental status for Bootstrap tabs and make them default. Settings of existing installations won't be changed.
* 2015-08-31 - Check compatibility for Moodle 2.9, no functionality change
* 2015-01-23 - Check compatibility for Moodle 2.8, no functionality change
* 2015-01-23 - Bugfix: Bootstrap tabs interfered custom menu; the filter now loads only bootstrap-tabs.js and not the complete bootstrap.js library anymore
* 2014-10-26 - Change the tabgroup counter from a random number to a static counter for performance reasons
* 2014-08-29 - Update README file
* 2014-08-22 - Add support for Bootstrap tabs (experimental)
* 2014-06-30 - Check compatibility for Moodle 2.7, no functionality change
* 2014-01-31 - Check compatibility for Moodle 2.6, no functionality change
* 2013-07-30 - Transfer Github repository from github.com/abias/... to github.com/moodleuulm/...; Please update your Git paths if necessary
* 2013-07-30 - Check compatibility for Moodle 2.5, no functionality change
* 2013-03-18 - Small code improvement, Code cleanup according to moodle codechecker
* 2013-02-18 - Check compatibility for Moodle 2.4
* 2012-12-20 - Add missing pluginname zu language file
* 2012-11-27 - Initial version
