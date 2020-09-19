<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', 'wfc_register_tracker_customizer_settings' );
/**
 * Register customizer settings to be used for the
 * standard(core) cookie.
 *
 * @param WP_Customize_Manager $wp_customize The wp customizer manager.
 */
function wfc_register_tracker_customizer_settings( $wp_customize ) {
	$wp_customize->add_section( 'wfc_cookie_tracking' , array(
		'title' 	=> __( 'Cookie Tracking', 'wfc-genesis' ),
		'priority' 	=> 99,
	) );

	$wp_customize->add_setting( 'wfc_cookie_duration', array(
		'default' => ''
	) );

	$wp_customize->add_control( 'wfc_cookie_duration_control', array(
		'label' 	=> __( 'Cookie Duration', 'wfc-genesis' ),
		'type' 		=> 'number',
		'section' 	=> 'wfc_cookie_tracking',
		'settings' 	=> 'wfc_cookie_duration',
	) );

	$wp_customize->add_setting( 'wfc_track_logged_in_users', array(
		'default' => ''
	) );

	$wp_customize->add_control( 'wfc_track_logged_in_users_control', array(
		'label' 	=> __( 'Track Logged In Users', 'wfc-genesis' ),
		'type' 		=> 'checkbox',
		'section' 	=> 'wfc_cookie_tracking',
		'settings' 	=> 'wfc_track_logged_in_users',
	) );
}

add_action( 'template_redirect', 'wfc_track_last_visited_page' );
/**
 * Track last visited page.
 */
function wfc_track_last_visited_page() {
	remove_action( 'template_redirect', 'wfc_track_last_visited_page' );

	global $post_type;

	$current_page = 0;

	if ( is_archive() || is_search() ) {
		$pt = is_search() ? 'search' : $post_type;
		$archive_page = get_page_by_path( $pt );

		if ( is_a( $archive_page, 'WP_Post' ) ) {
			$current_page = $archive_page->ID;
		}
	} else if ( is_singular() ) {
		$current_page = get_the_ID();
	}

	if ( $current_page ) {
		wfc_tracker()->set_cookie( 'wfc__p', $current_page );
	}
}

add_action( 'gform_after_submission', 'wfc_track_gform_submit', 10, 2 );
/**
 * Track the submitted forms.
 *
 * @param GF_Entry $entry  GF entry object.
 * @param GF_Form  $form   GF form object.
 */
function wfc_track_gform_submit( $entry, $form ) {
	remove_action( 'template_redirect', 'wfc_track_gform_submit' );

	$form_id = rgar( $form, 'id' );

	$form_ids = wfc_tracker()->get_local_cookie( 'wfc__f' );
	$form_ids = trim( $form_ids );
	$form_ids = $form_ids != '' ? explode( ',', $form_ids ) : array();

	if ( ! in_array( $form_id, $form_ids ) ) {
		$form_ids[] = $form_id;
	}

	wfc_tracker()->set_cookie( 'wfc__f', implode( ',', $form_ids ) );
}

add_action( 'wp_footer', 'wfc_save_cookie' );
/**
 * Save cookie to database.
 */
function wfc_save_cookie() {
	remove_action( 'wp_footer', 'wfc_save_cookie' );

	if ( ! is_admin()) {
		wfc_tracker()->save();
	}
}