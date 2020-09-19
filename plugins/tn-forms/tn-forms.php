<?php
/*

Plugin Name: TN Forms
Plugin URI: http://techn.com.au/plugins/
Version: 1.0
Author: TECHN
Author URI: http://techn.com.au
Description: Hooks HTML forms to a set of custom-post-types for easy storage and use.  
License: GPL2

Copyright 2013. This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

*/

require_once('cpt-form.php');  // the html form itself
require_once('cpt-form-submission.php'); // the record of submission (parent)
require_once('cpt-form-data.php'); // normalised data for each feild (child)
require_once('functions.php');
require_once('defaults.php');

function tn_style() {
   wp_register_style('tn_style', site_url().'/wp-content/plugins/tn-forms/style.css');
   wp_enqueue_style('tn_style');
}
add_action('admin_head', 'tn_style');

?>