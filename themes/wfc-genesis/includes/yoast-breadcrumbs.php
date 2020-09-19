<?php
/**
 * WFC Genesis.
 *
 * This file adds WFC_Yoast_Breadcrumbs to the WFC Genesis Child Theme.
 *
 * @package WFC_Genesis/Core
 * @author  AlphaSys
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if (! class_exists('WFC_Yoast_Breadcrumbs')) {
    class WFC_Yoast_Breadcrumbs {
        /**
         * Constructor.
         */
        public function __construct() {

        	$yoast_dir = 'wordpress-seo/wp-seo.php';

        	$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

        	if( ! in_array( $yoast_dir, $active_plugins ) ) {
        		//echo 'Yoast Not Active';
        	} else {
	        	// stop displaying genesis breadcrumbs
	            remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

	            // remove breadcrumbs section on Customizer
	            add_action( 'init', function() {
	            	remove_theme_support( 'genesis-breadcrumbs' );
	            } );

	            // remove breadcrumbs settings meta box on Genesis Theme Settings
	            add_action ('genesis_theme_settings_metaboxes', array( $this, 'genesis_remove_breadcrumbs_meta_box' ) );	
        	}    		
        }

        /**
         * Remove the breadcrumbs meta box from the Genesis Admin Menu Theme Settings.
         *
         * @param      string  $_genesis_theme_settings_pagehook  The genesis theme settings pagehook
         */
        public function genesis_remove_breadcrumbs_meta_box( $_genesis_theme_settings_pagehook ) {
            remove_meta_box( 'genesis-theme-settings-breadcrumb', $_genesis_theme_settings_pagehook, 'main' );
        }

        /**
         * Modify the yoast breadcrumbs markup if it exists.
         */
        public static function yoast_breadcrumbs_markup() {
            if ( function_exists( 'yoast_breadcrumb' ) ) {
                yoast_breadcrumb( '<p class="wfc-yoast-breadcrumbs">','</p>' );
            }
        }
    }
}

new WFC_Yoast_Breadcrumbs();