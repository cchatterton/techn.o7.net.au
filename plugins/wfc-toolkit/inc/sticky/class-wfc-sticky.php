<?php
/**
 * @package WFC_Toolkit\WFC_Sticky
 * @author AlphaSys
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if access directly.
}

if ( !class_exists( 'WFC_Sticky' ) ) {
	class WFC_Sticky {

		public function __construct() {
			define( 'WFC_STK_ASSETS', plugin_dir_url( __FILE__ ) . 'assets' );
			define( 'WFC_STK_CSS', WFC_STK_ASSETS . '/css' );
			define( 'WFC_STK_JS', WFC_STK_ASSETS . '/js' );

			add_action( 'wp_enqueue_scripts', array( $this, 'public_enqueues' ) );
		}

		public function public_enqueues() {
			wp_enqueue_script(
				'wfc-jquery-sticky-js',
				WFC_STK_JS . '/jquery.sticky.js',
				array( 'jquery' ),
				'',
				true
			);			
			wp_enqueue_script(
				'wfc-sticky-js',
				WFC_STK_JS . '/sticky.js',
				array( 'jquery' ),
				'',
				true
			);

			$enable_sticky_on_desktop = wfc_toolkit_get_option( 'enable_sticky_on_desktop' );
			$enable_sticky_on_tablet = wfc_toolkit_get_option( 'enable_sticky_on_tablet' );
			$enable_sticky_on_mobile = wfc_toolkit_get_option( 'enable_sticky_on_mobile' );
			$sticky_target_element = wfc_toolkit_get_option( 'sticky_target_element' );

			wp_localize_script(
				'wfc-sticky-js',
				'wfc_sticky',
				array(
					'enableDesktop' => $enable_sticky_on_desktop,
					'enableMobile'	=> $enable_sticky_on_mobile,
					'enableTablet'	=> $enable_sticky_on_tablet,
					'targetElem'	=> $sticky_target_element,
				)
			);
		}
	}
}

new WFC_Sticky();