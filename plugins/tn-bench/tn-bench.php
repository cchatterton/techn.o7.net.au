<?php
/*
Plugin Name: TN Bench
Plugin URI: http://techn.com.au/plugins/
Version: 0.1
Author: TECH N
Author URI: http://techn.com.au
Description: Provides a stats on performance, screen size and browsers. For use on Zurb Foundation 4+ websites.
License: GPL2
------------------------------------------------------------------------

Copyright 2013. This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

*/
$tnbench_option = get_option('tnbench_forced', true);
require_once('includes/functions.php');

if ( strtolower( $_GET['tnbench'] ) == 'on' || $tnbench_option ) {
	require_once('includes/ubench.php');
	add_action('wp_head', 'tnbench_start');
	add_action('wp_footer', 'tnbench_end');
}

function tn_bench_enqueue() {
	wp_enqueue_style( 'tnbench', '/wp-content/plugins/tn-bench/includes/style.css','', date('c') );
	wp_enqueue_script( 'verge','/wp-content/plugins/tn-bench/includes/verge.min.js', array('jquery'), '1.9.1+201402130803', false );
}
add_action( 'wp_enqueue_scripts', 'tn_bench_enqueue' );

?>