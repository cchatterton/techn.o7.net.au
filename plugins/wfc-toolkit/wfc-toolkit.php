<?php
/**
 * @package WFC_Toolkit
 * @author AlphaSys
 */
/*
Plugin Name: WFC - Toolkit
Description: Has features that can be used by developers to speed up the development. This plugin is also required for WFC Genesis V2 child theme.
Version: 1.0.0
Author: AlphaSys
Author URI: https://alphasys.com.au/
Text Domain: wfc-toolkit
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if access directly.
}

/**
 * The base class for this plugin.
 * 
 * This class is responsible for initializing
 * all features.
 * 
 * @final
 */
final class WFC_Toolkit {

	/**
	 * Contains functions calls to initialize
	 * the plugins.
	 */
	public function __construct() {
		$this->defines();
		$this->includes();
		$this->init();
	}

	/**
	 * Defines constants.
	 */
	private function defines() {
		$this->define( 'WFCT_VERSION', '1.0.0' );
		$this->define( 'WFCT_DIR', plugin_dir_path( __FILE__ ) );
		$this->define( 'WFCT_INC', WFCT_DIR . 'inc/' );
		$this->define( 'WFCT_TPL', WFCT_DIR . 'templates/' );

		$this->define( 'WFCT_ASSET_URL', plugin_dir_url( __FILE__ ) . 'assets/' );
		$this->define( 'WFCT_JS_URL', WFCT_ASSET_URL . 'js/' );
		$this->define( 'WFCT_CSS_URL', WFCT_ASSET_URL . 'css/' );
		$this->define( 'WFCT_IMG_URL', WFCT_ASSET_URL . 'img/' );
	}

	/**
	 * Includes necessary files.
	 */
	private function includes() {
		require WFCT_DIR . 'functions.php';

		require WFCT_INC . 'environment-indicator/class-environment-indicator.php';
		require WFCT_INC . 'cookie-tracker/class-wfc-tracker.php';
		require WFCT_INC . 'fail-graceful/class-wfc-fail-graceful.php';
		require WFCT_INC . 'hero-images/class-wfc-hero-images.php';
		
		if ( wfc_toolkit_get_option( 'enable_preloader', false ) ) {
			require WFCT_INC . 'preloader/class-wfc-preloader.php';
		}

		if ( wfc_toolkit_get_option( 'enable_image_gallery', false ) ) {
			require WFCT_INC . 'image-gallery/class-wfc-image-gallery.php';
		}

		if ( wfc_toolkit_get_option( 'enable_sticky_elements', false ) ) {
			require WFCT_INC . 'sticky/class-wfc-sticky.php';
		}
	}

	/**
	 * Initializes all the features.
	 */
	private function init() {

		if ( defined( 'WFC_ENV' ) ) {
			new WFC_Enviroment_Indicator( WFC_ENV );
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
		
	}

	/**
	 * Registers admin scripts and styles.
	 *
	 * @param string $hook Current page.
	 */
	public function register_admin_scripts( $hook ) {

		if ( $hook == 'settings_page_wfc-toolkit-settings' ) {
			// Media
			wp_enqueue_media();

			// CSS
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css', array() );
			wp_enqueue_style( 'wfc-toolkit-settings', WFCT_CSS_URL . 'admin-settings.css', array(), WFCT_VERSION );

			// JS
			wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'wfc-toolkit-settings', WFCT_JS_URL . 'admin-settings.js', array( 'jquery', 'wp-color-picker' ), WFCT_VERSION, true );
		}
	}

	/**
	 * Defines a constant if it doesn't exists.
	 * 
	 * @param string $name Constant variable name.
	 * @param mixed $value The value of the constant.
	 */
	public function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}
}

new WFC_Toolkit();