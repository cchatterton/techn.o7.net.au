<?php
/**
 * @package WFC_Toolkit
 * @author AlphaSys
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if access directly.
}

add_action( 'admin_menu', 'wfc_toolkit_register_settings_submenu_page' );
/**
 * Registers admin menu under settings menu.
 */
function wfc_toolkit_register_settings_submenu_page() {

	add_submenu_page(
		'options-general.php',
		esc_html__( 'WFC Toolkit Settings', 'wfc-toolkit' ),
		esc_html__( 'WFC Toolkit', 'wfc-toolkit' ),
		'manage_options',
		'wfc-toolkit-settings',
		'wfc_toolkit_settings_page_callback'
	);
}

/**
 * The output callback for settings page.
 */
function wfc_toolkit_settings_page_callback() {
	include WFCT_TPL . 'settings.php';
}

add_action( 'admin_post_wfc_toolkit_settings', 'wfc_toolkit_save_settings' );
/**
 * Save settings to WP options.
 */
function wfc_toolkit_save_settings() {

	$error = false;

	if ( ! isset( $_POST[ 'nonce' ] ) || ! wp_verify_nonce( $_POST[ 'nonce' ], 'wfc_toolkit_settings_nonce' ) ) {
		// Redirect to the setting page and show error.
		$error = true;
	}

	if ( ! $error ) {
		$expected_settings = array(
			// Privacy and Dev Tools tab
			'enable_developer_mode' 			=> 'checkbox',
			'enable_tracking_personalization' 	=> 'checkbox',

			// Image Configuration tab
			'enable_fail_graceful' 				=> 'checkbox',
			'enable_image_gallery' 				=> 'checkbox',

			// Theme UI/UX tab
			'enable_hero_images' 				=> 'checkbox',
			'enable_sticky_elements' 			=> 'checkbox',
			'sticky_target_element'				=> 'text',
			'enable_sticky_on_desktop'			=> 'checkbox',
			'enable_sticky_on_mobile'			=> 'checkbox',
			'enable_sticky_on_tablet'			=> 'checkbox',

			// Pre loader section
			'enable_preloader' 					=> 'checkbox',
			'preloader_page' 					=> 'select',
			'preloader_page_except' 			=> 'array',
			'preloader_selected_page' 			=> 'array',
			'preloader_type' 					=> 'option',
			'preloader_spinner' 				=> 'select',
			'preloader_spinner_color' 			=> 'color',
			'preloader_spinner_size' 			=> 'select',
			'preloader_spinner_width' 			=> 'number',
			'preloader_spinner_image' 			=> 'image',
			'preloader_background' 				=> 'color',
			'preloader_text' 					=> 'text',
			'preloader_text_color' 				=> 'color',
			'preloader_text_size' 				=> 'number',

		);

		$settings = get_option( 'wfc_toolkit_settings', array() );

		// Sanitize expected post data.
		foreach ( $expected_settings as $key => $type ) {

			$value = '';

			switch ( $type ) {
				case 'checkbox':
					$value = isset( $_POST[ $key ] ) && $_POST[ $key ] === 'on' ? true : false;
					break;

				case 'textarea':
					if ( isset( $_POST[ $key ] ) ) {
						$value = sanitize_textarea_field( $_POST[ $key ] );
					}
					break;

				case 'email':
					if ( isset( $_POST[ $key ] ) ) {
						$value = sanitize_email( $_POST[ $key ] );
					}
					break;

				case 'number':
					if ( isset( $_POST[ $key ] ) ) {
						$value = intval( $_POST[ $key ] );
					}
					break;

				case 'float':
					if ( isset( $_POST[ $key ] ) ) {
						$value = floatval( $_POST[ $key ] );
					}
					break;

				case 'array':
					$value = array();

					if ( isset( $_POST[ $key ] ) ) {
						$value = $_POST[ $key ];

						foreach ( $value as &$val ) {
							$val = sanitize_text_field( $val );
						}
					}
					break;

				case 'color':
					if ( isset( $_POST[ $key ] ) ) {
						$value = sanitize_hex_color( $_POST[ $key ] );
					}
					break;

				case 'image':
					if ( isset( $_POST[ $key ] ) ) {
						$value = esc_url( $_POST[ $key ] );
					}
					break;
				
				case 'option':
				case 'text':
				case 'select':
				default:
					if ( isset( $_POST[ $key ] ) ) {
						$value = sanitize_text_field( $_POST[ $key ] );
					}
					break;
			}

			$settings[ $key ] = $value;
		}

		// Save settings.
		update_option( 'wfc_toolkit_settings', $settings );
	}

	// Redirect to the setting page.
	wp_safe_redirect( add_query_arg( array(
		'page' => 'wfc-toolkit-settings',
		'saved' => $error ? 0 : 1
	), admin_url( 'options-general.php' ) ) );
	die();
}

/**
 * Retrieve toolkit settings option.
 *
 * @param string $option_name Option name.
 * @param mixed $default The default value to return if option not exists.
 *
 * @return mixed
 */
function wfc_toolkit_get_option( $option_name, $default = '' ) {

	global $wfc_toolkit_settings;

	if ( ! is_array( $wfc_toolkit_settings ) ) {
		$wfc_toolkit_settings = get_option( 'wfc_toolkit_settings', array() );
	}

	if ( isset( $wfc_toolkit_settings[ $option_name ] ) ) {
		return $wfc_toolkit_settings[ $option_name ];
	}

	return $default;
}

add_action( 'admin_notices', 'wfc_toolkit_show_notices_on_save_settings' );
/**
 * Display notices after saving settings.
 */
function wfc_toolkit_show_notices_on_save_settings() {

	$screen = get_current_screen();

	if ( ! isset( $_GET[ 'page' ] ) || $_GET[ 'page' ] != 'wfc-toolkit-settings' ) {
		return;
	}

	if ( isset( $_GET[ 'saved' ] ) && $_GET[ 'saved' ] == true ) : ?>
		<div class="notice notice-success">
			<p><?php _e( '<strong>Yey! </strong> Successfully saved settings!', 'wfc-toolkit' ); ?></p>
		</div>
	<?php elseif ( isset( $_GET[ 'saved' ] ) && $_GET[ 'saved' ] == false ) : ?>
		<div class="notice notice-error">
			<p><?php _e( '<strong>Opps! </strong> Could not save settings!', 'wfc-toolkit' ); ?></p>
		</div>
	<?php
	endif;
}