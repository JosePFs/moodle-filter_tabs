moodle-filter_tabs
===================

Moodle filter which creates tabs in textfields


Requirements
------------

This plugin requires Moodle 2.9+


Changes
-------

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


Installation
------------

Install the plugin like any other plugin to folder
/filter/tabs

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


Usage
-----

First, activate the filter_tabs plugin in Site Administration -> Plugins -> Filters -> Manage filters

To create tabs in textfields, use the following syntax:
{%:Tab title}Tab text{%}


Example
-------

The following placeholders in a textfield:

{%:First tab}Some text{%}
{%:Second tab}Another text{%}

will produce this tab group:

+-----------+------------+
| First tab | Second tab |
+------------------------+-------------------------+
| Some text                                        |
|                                                  |
+--------------------------------------------------+


Settings
--------

When you install filter_tabs with its default settings, it will replace the tab syntax with tabs provided by the Bootstrap framework which is present in Moodle since Moodle 2.5.

However, Moodle still ships with the YUI JavaScript library which has been used in Moodle for a long time and which also provides a tabs functionality.
While the default Bootstrap tabs conform to modern Bootstrap based themes much better than YUI tabs, there might still be the need to have YUI tabs in some installations. filter_tabs will continue to support YUI tabs as long as Moodle core ships YUI.

To make use of the legacy YUI tabs, please visit Plugins -> Filters -> Tabs.
There you can disable Bootstrap tabs.


Themes
------

filter_tabs should work with all themes from moodle core and with 3rd party Bootstrap based themes.

filter_tabs provides a fallback for browsers with JavaScript disabled.


Further information
-------------------

filter_tabs is found in the Moodle Plugins repository: https://moodle.org/plugins/view/filter_tabs

Report a bug or suggest an improvement: https://github.com/moodleuulm/moodle-filter_tabs/issues


Moodle release support
----------------------

Due to limited ressources, filter_tabs is only maintained for the most recent major release of Moodle. However, previous versions of this plugin which work in legacy major releases of Moodle are still available as-is without any further updates in the Moodle Plugins repository.

There may be several weeks after a new major release of Moodle has been published until we can do a compatibility check and fix problems if necessary. If you encounter problems with a new major release of Moodle - or can confirm that filter_tabs still works with a new major relase - please let us know on https://github.com/moodleuulm/moodle-filter_tabs/issues


Right-to-left support
---------------------

This plugin has not been tested with Moodle's support for right-to-left (RTL) languages.
If you want to use this plugin with a RTL language and it doesn't work as-is, you are free to send me a pull request on
github with modifications.


Copyright
---------

University of Regensburg
Stefan Lehneis

University of Ulm
kiz - Media Department
Team Web & Teaching Support
Alexander Bias
