<?php
/*

Plugin Name: WP About Config
Plugin URI: http://techn.com.au/plugins/
Version: 1.0
Author: TECHN
Author URI: http://techn.com.au
Description: Provides configurables for use in themes similar to about:config for Firefox. 
License: GPL2

Copyright 2013. This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

*/

require_once('cpt_config.php'); 
require_once('functions.php');
require_once('default.php');

function wp_about_config_styles() {
   wp_register_style('wp_about_config_style', site_url().'/wp-content/plugins/wp_about_config/style.css');
   wp_enqueue_style('wp_about_config_style');
}
add_action('admin_head', 'wp_about_config_styles');

?>