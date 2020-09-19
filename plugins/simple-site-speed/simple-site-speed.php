<?php
/*
Plugin Name: Simple Site Speed
Plugin URI: http://gearside.com/simple-site-speed
Description: Add page load times for admins on the front-end.
Version: 1.0.2
Author: Chris Blakley
Author URI: http://gearside.com
License: GPL2
*/
/*
Copyright 2013  Chris Blakley  (email : chris@gearside.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('Simple_Site_Speed'))
{
	class Simple_Site_Speed
	{   
		/**
		 * Activate the plugin
		 */
		public static function activate()
		{
			// Do nothing
		} // END public static function activate
	
		/**
		 * Deactivate the plugin
		 */		
		public static function deactivate()
		{
			// Do nothing
		} // END public static function deactivate
	} // END class Simple_Site_Speed
} // END if(!class_exists('Simple_Site_Speed'))

if(class_exists('Simple_Site_Speed'))
{
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('Simple_Site_Speed', 'activate'));
	register_deactivation_hook(__FILE__, array('Simple_Site_Speed', 'deactivate'));

	// instantiate the plugin class
	$Simple_Site_Speed = new Simple_Site_Speed();

    function load_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('mainscript', '/wp-content/plugins/simple-site-speed/simplesitespeed.js');
        wp_enqueue_style('mainstyle', '/wp-content/plugins/simple-site-speed/style.css');
    }
    add_action('wp_enqueue_scripts', 'load_scripts');

	function includeFrontend() {
		include('frontend.php');
	}
	add_action('wp_footer', 'includeFrontend');		
}