JSON Feed Plugin for Wordpress
==============================

This is a 'fork' of Chris Northwood's popular [JSON Feed plugin for version 1.3](http://wordpress.org/support/plugin/json-feed).

It provides he ability to generate feeds in JSON format from any place on your WordPress site.

Below is a list of the changes made to version 1.3:

* The `limit` parameter has been added to control the number of results returned. The default is set to 10.
* JSONP support has been modified to expect a parameter named `callback` instead of the original `jsonp`
* The list of columns returned has been limited to `title`, `excerpt`, `permalink`, `display_date` and `unix_date`
* `title` and `excerpt` are now stripped off tags and HTML entities encoded.