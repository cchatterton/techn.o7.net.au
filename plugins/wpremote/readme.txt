=== The WP Remote WordPress Plugin ===
Contributors: BlogVault Backup
Tags: wpremote, remote administration, multiple wordpress, backup, wordpress backup
Plugin URI: https://wpremote.com/
Donate link: https://app.wpremote.com/home/signup
Requires at least: 4.0
Tested up to: 5.5
Requires PHP: 5.4.0
Stable tag: 4.36
License: GPLv2 or later
License URI: [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html)

== DESCRIPTION ==
The WP Remote WordPress Plugin works with [WP Remote](https://app.wpremote.com/) to enable you to remotely manage and update all your WordPress sites.
WP Remote has been acquired by BlogVault.

= Features =

* Free to update an unlimited number of sites.
* Track and update all of your WordPress sites from one place.
* Track and update all of your WordPress plugins and themes from one place.
* Install and activate plugins and themes from the one place.

= Support =

You can email us at support@wpremote.com for support.

== Installation ==

1. Install The WP Remote WordPress Plugin either via the WordPress.org plugin directory, or by uploading the files to your server.
2. Activate the plugin.
3. Sign up for an account at wpremote.com and add your site.

== CHANGELOG ==

= 4.36 =
* Block WordPress auto update feature

= 4.31 =
* Fetching Mysql Version
* Robust data fetch APIs
* Core plugin changes
* Sanitizing incoming params
* Update Database after wp-core update
* Handling Child theme upgrade code
* FSWrite wing improvements for older PHP versions

= 4.26 =
* Handling Premium plugin and themes updates

= 4.22 =
* Sending plugname in request to backend servers
* Firewall in prepend mode
* Robust Firewall and Login protection
* Robust write callbacks
* Without FTP cleanup and restore support

= 3.4 =
* Plugin branding fixes

= 3.3 =
* Whitelabel fixes

= 3.2 =
* Integrating with BlogVault.

#### 2.8.4.3 (11 January 2019)

* Backport bug fix for theme updates from v3.0.a
* Plugins will now be re-installed if they vanish and add in user_abort prevention.

#### 2.8.4.2 (9 January 2019)

* Backport WPEngine bug fix from v3.0.a

#### 2.8.4.1 (3 December 2017)

* Correct handling of up_to_date error

#### 2.8.4 (3 December 2017)

* Modify error message response in certain situations

#### 2.8.3 (21 November 2017)

* Add endpoint to validate plugin update
* Improved error handling
* Fix 'Clear Api' redirect

#### 2.8.2 (25 October 2017)

* Change settings page function name for compatibility
* Allow the WP Remote API key to be updated from CLI

#### 2.8.1 (10 October 2017)

* Add link to clear API key from the plugin settings page.
* Prevent WP Remote from clearing the API key on deactivation
* Clear API key on uninstall
