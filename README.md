moodle-filter_tabs
===================

Moodle filter which creates tabs in textfields


Requirements
------------

This plugin requires Moodle 3.1+


Installation
------------

Install the plugin like any other plugin to folder
/filter/tabs

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


Usage
-----

First, activate the filter_tabs plugin in Site administration -> Plugins -> Filters -> Manage filters

To create tabs in textfields, use the following syntax:
```
{%:Tab title}Tab text{%}
```


Example
-------

The following placeholders in a textfield:

```
{%:First tab}Some text{%}
{%:Second tab}Another text{%}
```

will produce this tab group:

```
+-----------+------------+
| First tab | Second tab |
+------------------------+-------------------------+
| Some text                                        |
|                                                  |
+--------------------------------------------------+
```


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

Report a bug or suggest an improvement: https://github.com/JosePFs/moodle-filter_tabs/issues


Moodle release support
----------------------

Due to limited resources, filter_tabs is only maintained for the most recent major release of Moodle. However, previous versions of this plugin which work in legacy major releases of Moodle are still available as-is without any further updates in the Moodle Plugins repository.

There may be several weeks after a new major release of Moodle has been published until we can do a compatibility check and fix problems if necessary. If you encounter problems with a new major release of Moodle - or can confirm that filter_tabs still works with a new major relase - please let us know on https://github.com/JosePFs/moodle-filter_tabs/issues


Right-to-left support
---------------------

This plugin leverages Moodle's support for right-to-left (RTL) languages. This support was added as a contribution by nadavkav.
However, we don't regularly test it with a RTL language. If you have problems with the plugin and a RTL language, you are free to send us a pull request on github with modifications.


PHP7 Support
------------

Since Moodle 3.0, Moodle core basically supports PHP7.
Please note that PHP7 support is on our roadmap for this plugin, but it has not yet been thoroughly tested for PHP7 support and we are still running it in production on PHP5.
If you encounter any success or failure with this plugin and PHP7, please let us know.


Copyright
---------

2017 onwards José Puente Fuentes


Original author
---------------

University of Regensburg
Stefan Lehneis

Ulm University
kiz - Media Department
Team Web & Teaching Support
Alexander Bias


Change of maintainer
---------------------

On 02/08/2017, this plugin was transferred to José Puente Fuentes who is now the main maintainer.


Credits
-------

Logo by <a href="http://www.flaticon.com/">Flaticon</a>.