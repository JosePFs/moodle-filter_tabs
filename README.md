moodle-filter_tabs
===================
Moodle filter which creates tabs in textfields


Requirements
============
This plugin requires Moodle 2.2+


Changes
=======
2012-12-20 - Add missing pluginname zu language file
2012-11-27 - Initial version


Installation
============
Install the plugin like any other plugin to folder
/filter/tabs

See http://docs.moodle.org/23/en/Installing_plugins for details on installing Moodle plugins


Usage
=====
First, activate the filter_tabs plugin in Site Administration -> Plugins -> Filters -> Manage filters

To create tabs in textfields, use the following syntax:
{%:Tab title}Tab text{%}


Example
=======
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


Themes
======
filter_tabs should work with all themes from moodle core.
filter_tabs provides a fallback for browsers with JavaScript disabled.


Settings
========
filter_tabs has neither a settings page nor settings in config.php.


Further information
===================
filter_tabs is found in the Moodle Plugins repository: http://moodle.org/plugins/view.php?plugin=filter_tabs

Report a bug or suggest an improvement: https://github.com/abias/moodle-filter_tabs/issues


Copyright
=========
Written by Stefan Lehneis, University of Regensburg
Packaged by Alexander Bias, University of Ulm