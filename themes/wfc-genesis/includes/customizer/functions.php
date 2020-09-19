<?php

/**
 * Registers custom sections and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @param Array $theme_settings Arrays of sections and controls to be created.
 */
function wfc_register_customizer_controls( $theme_settings, $wp_customize ) { 

	$panels   = $theme_settings[ 'panels' ];
	$sections = $theme_settings[ 'sections' ];
	$controls = $theme_settings[ 'controls' ];

	foreach ( $panels as $panel ) {
		if ( !$wp_customize->get_panel( $panel[ 'id' ] ) ) {
			$wp_customize->add_panel( $panel[ 'id' ], $panel );
		}
	}

	foreach ( $sections as $section ) {
		if ( !$wp_customize->get_section( $section[ 'id' ] ) ) {
			$wp_customize->add_section( $section[ 'id' ], $section );
		}
	}

	$sanitization = array(
		'email' 	=> 'sanitize_email',
		'color' 	=> 'sanitize_hex_color',
		'checkbox' 	=> 'wfc_sanitize_checkbox',
		'textarea'	=> ''
	);

	foreach ( $controls as $control ) {

		if ( !isset( $control[ 'id' ] ) )
			break;

		$setting_id = $control[ 'id' ];
		$setting_type = $control[ 'type' ];

		$setting_args = array();
		$setting_args[ 'default' ] = ( isset( $control[ 'default' ] ) ) ? $control[ 'default' ] : '';

		if ( isset( $control[ 'sanitize_callback' ] ) ) 
			$setting_args[ 'sanitize_callback' ] = $control[ 'sanitize_callback' ];
		else 
			$setting_args[ 'sanitize_callback' ] = ( isset( $sanitization[ $setting_type ] ) ) ? $sanitization[ $setting_type ] : 'wp_filter_nohtml_kses';

		$wp_customize->add_setting( $setting_id, $setting_args );

		if ( $setting_type == 'color' ) {

			$wp_customize->add_control(
				new WP_Customize_Color_Control( $wp_customize, $setting_id, $control )
			);

		} elseif ( $setting_type == 'color-alpha' ) {

			$wp_customize->add_control(
				new Customize_Alpha_Color_Control( $wp_customize, $setting_id, $control )
			);

		} elseif ( $setting_type == 'image' ) {

			$wp_customize->add_control(
				new WP_Customize_Image_Control( $wp_customize, $setting_id, $control )
			);

		} elseif ( $setting_type == 'separator' ) {

			$wp_customize->add_control(
				new WFC_Separator_Control( $wp_customize, $setting_id, $control )
			);

		} elseif ( $setting_type == 'googlefonts' || $setting_type == 'fallbackfonts' ) {

			$wp_customize->add_control(
				new WFC_Google_Fonts_Control( $wp_customize, $setting_id, $control )
			);

		} else {

			$wp_customize->add_control( $setting_id, $control );

		}

	}

}

/**
 * Checkbox sanitization callback.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function wfc_sanitize_checkbox( $checked ) {

 	return ( ( isset( $checked ) && true == $checked ) ? true : false );

}

/**
 * Color pallete callback.
 * 
 * Hide/Show the color pallete base on color count settings.
 *
 * @param object $control Customizer object.
 * @return bool Whether this color pallete will be visible or hidden.
 */
function wfc_color_pallete_callback( $control, $index ) {

	if ( $control->manager->get_setting( 'color_count' )->value() >= $index ) 
      return true;
   	else 
      return false;

}


/**
 * class `WFC_Separator_Control`.
 * 
 * Register a customizer custom separator control.
 */
class WFC_Separator_Control extends WP_Customize_Control {

	public $type = 'separator';

	public function enqueue() {
		wp_enqueue_style( 'wfc-customizer', get_stylesheet_directory_uri().'/includes/customizer/customizer.css' );
	}

	public function render_content() {

		printf( 
			'<div class="wfc-separator">
				<h3 class="wfc-separator-title">%s</h3>
				<p class="wfc-separator-desc">%s</p>
			</div>', 
			esc_html( $this->label ), 
			wp_kses_post( $this->description ) 
		);
		
	}

}