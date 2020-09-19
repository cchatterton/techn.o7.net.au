<?php
/**
 * WFC Genesis.
 *
 * This file adds the Customizer additions to the WFC Genesis Child Theme.
 *
 * @package WFC_Genesis/Core
 * @author  AlphaSys
 */

/**
 * Registers settings and controls with the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
add_action( 'customize_register',  function( $wp_customize ) {

	require_once get_stylesheet_directory() . '/includes/customizer/functions.php';
	require_once get_stylesheet_directory() . '/includes/customizer/google-fonts/google-fonts.php';
	require_once get_stylesheet_directory() . '/includes/customizer/alpha-color-picker/alpha-color-picker.php';

	$customizer_settings = array( 
		'panels' => array(

			array(
				'id' 		=> 'site_configuration',
				'title' => esc_html__( 'Site Configuration', 'wfc-genesis' ),
				'priority'	=> 21
			),
			array(
				'id' 		=> 'brand_settings',
				'title' => esc_html__( 'Brand Settings', 'wfc-genesis' ),
				'priority'	=> 22
			),

		),
		'sections' => array(

			/*=== Contact Details Section ===*/
			array(
				'id' 		=> 'contact_details',
				'title' 	=> esc_html__( 'Contact Details', 'wfc-genesis' ),
				'priority'	=> 23
			),

			/*=== Brand Settings Panel Sections ===*/
			array(
				'id' 		=> 'theme_colors',
				'panel' 	=> 'brand_settings',
				'title' 	=> esc_html__( 'Colors', 'wfc-genesis' )
			),
			array(
				'id' 		=> 'typography',
				'panel' 	=> 'brand_settings',
				'title' 	=> esc_html__( 'Typography', 'wfc-genesis' )
			),
			array(
				'id' 		=> 'logos_and_images',
				'panel' 	=> 'brand_settings',
				'title' 	=> esc_html__( 'Logos and Images', 'wfc-genesis' )
			),

			/*=== Site Configuration Panel Sections ===*/
			array(
				'id' 		=> 'general',
				'panel' 	=> 'site_configuration',
				'title' 	=> esc_html__( 'General', 'wfc-genesis' )
			),
			array(
				'id' 		=> 'dimensions',
				'panel' 	=> 'site_configuration',
				'title' 	=> esc_html__( 'Site Dimensions', 'wfc-genesis' )
			)
			
		),
		'controls' => array(

			/*=== Site Identity ===*/
			array( 
				'type' 		=> 'textarea',
				'section' 	=> 'title_tagline',
				'id' 		=> 'copyright_statement',
				'label' 	=> esc_html__( 'Copyright Statement', 'wfc-genesis' ),
			),

			/*=== Contact Details ===*/
			array( 
				'type' 		=> 'tel',
				'section' 	=> 'contact_details',
				'id' 		=> 'phone_number',
				'label' 	=> esc_html__( 'Phone Number', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'email',
				'section' 	=> 'contact_details',
				'id' 		=> 'email_address',
				'label' 	=> esc_html__( 'Email Address', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'textarea',
				'section' 	=> 'contact_details',
				'id' 		=> 'postal_address',
				'label' 	=> esc_html__( 'Postal Address', 'wfc-genesis' ),
			),

			/*=== Colors ===*/
			array(
				'priority'	=> 7,
				'type' 		=> 'select',
				'section' 	=> 'theme_colors',	
				'id' 		=> 'theme_class',
				'default'	=> 'light',
				'label' 	=> esc_html__( 'Theme Class', 'wfc-genesis' ),
				'choices' 	=> array( 
		         	'light' 	=> esc_html__( 'Light', 'wfc-genesis' ),
		         	'dark' 		=> esc_html__( 'Dark', 'wfc-genesis' ),
		      	)
			),
			array( 
				'priority'	=> 7,
				'type' 		=> 'separator',
				'section' 	=> 'theme_colors',
				'id' 		=> 'color_palette',
				'label' 	=> esc_html__( 'Color Palettes', 'wfc-genesis' ),
			),
			array( 
				'priority'	=> 8,
				'type' 		=> 'number',
				'section' 	=> 'theme_colors',
				'id' 		=> 'color_count',
				'default'	=> 8,
				'label' 	=> esc_html__( 'Theme Color Count', 'wfc-genesis' ),
				'description' => esc_html__( 'Set number of colors for the theme palette.', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'separator',
				'section' 	=> 'theme_colors',
				'id' 		=> 'button_color',
				'label' 	=> esc_html__( 'Buttons', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'color',
				'section' 	=> 'theme_colors',
				'id' 		=> 'button_color_primary',
				'default'	=> '#007bff',
				'label' 	=> esc_html__( 'Primary', 'wfc-genesis' ),
				'description' => esc_html__( '( btn btn-primary, btn btn-outline-primary )', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'color',
				'section' 	=> 'theme_colors',
				'id' 		=> 'button_color_secondary',
				'default'	=> '#6c757d',
				'label' 	=> esc_html__( 'Secondary', 'wfc-genesis' ),
				'description' => esc_html__( '( btn btn-secondary, btn btn-outline-secondary )', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'color',
				'section' 	=> 'theme_colors',
				'id' 		=> 'button_color_tertiary',
				'default'	=> '#28a745',
				'label' 	=> esc_html__( 'Tertiary', 'wfc-genesis' ),
				'description' => esc_html__( '( btn btn-tertiary, btn btn-outline-tertiary )', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'color',
				'section' 	=> 'theme_colors',
				'id' 		=> 'button_text_color',
				'default'	=> '#ffffff',
				'label' 	=> esc_html__( 'Button text', 'wfc-genesis' ),
				'description' => esc_html__( 'Button default text color', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'separator',
				'section' 	=> 'theme_colors',
				'id' 		=> 'text_and_links',
				'label' 	=> esc_html__( 'Text and Links', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'color',
				'section' 	=> 'theme_colors',
				'id' 		=> 'text_color',
				'default'	=> '#212529',
				'label' 	=> esc_html__( 'Text', 'wfc-genesis' ),
				'description' => esc_html__( 'Site default text color.', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'color',
				'section' 	=> 'theme_colors',
				'id' 		=> 'link_color',
				'default'	=> '#007bff',
				'label' 	=> esc_html__( 'Link', 'wfc-genesis' ),
				'description' => esc_html__( 'Site default link color.', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'color',
				'section' 	=> 'theme_colors',
				'id' 		=> 'header_text_color',
				'default'	=> '#ffffff',
				'label' 	=> esc_html__( 'Header/Footer', 'wfc-genesis' ),
				'description' => esc_html__( 'Site default header and footer color.', 'wfc-genesis' ),
			),
			array(
				'type'			=> 'color',
				'section'		=> 'theme_colors',
				'id'			=> 'hero_text_color',
				'default'		=> '#ffffff',
				'label'			=> esc_html__( 'Hero', 'wfc-genesis' ),
				'description'	=> esc_html__( 'Site default hero color', 'wfc-genesis' ),
			),
			array(
				'type'			=> 'color',
				'section'		=> 'theme_colors',
				'id'			=> 'copyright_text_color',
				'default'		=> '#ffffff',
				'label'			=> esc_html__( 'Copyright', 'wfc-genesis' ),
				'description'	=> esc_html__( 'Site default copyright color', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'separator',
				'section' 	=> 'theme_colors',
				'id' 		=> 'header_color',
				'label' 	=> esc_html__( 'Background Colors', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'color-alpha',
				'section' 	=> 'theme_colors',
				'id' 		=> 'header_background_color',
				'default'	=> '#007bff',
				'label' 	=> esc_html__( 'Header/Footer Background', 'wfc-genesis' ),
				'description' => esc_html__( 'The background color that will be applied to the site header.', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'color-alpha',
				'section' 	=> 'theme_colors',
				'id' 		=> 'site_background_color',
				'default'	=> '#eeeeee',
				'label' 	=> esc_html__( 'Site Background', 'wfc-genesis' ),
				'description' => esc_html__( 'The background color that will be applied to the site.', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'color-alpha',
				'section' 	=> 'theme_colors',
				'id' 		=> 'page_background_color',
				'default'	=> '#ffffff',
				'label' 	=> esc_html__( 'Page Background', 'wfc-genesis' ),
				'description' => esc_html__( 'The background color that will be applied to the page.', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'color-alpha',
				'section' 	=> 'theme_colors',
				'id' 		=> 'copyright_background_color',
				'default'	=> '#007bff',
				'label' 	=> esc_html__( 'Copyright Background', 'wfc-genesis' ),
				'description' => esc_html__( 'The background color that will be applied to the copyright section.', 'wfc-genesis' ),
			),

			/*=== Typography ===*/
			array( 
				'type' 			=> 'googlefonts',
				'section' 		=> 'typography',
				'id' 			=> 'base_font',
				'label' 		=> esc_html__( 'Base Font', 'wfc-genesis' ),
				'description' 	=> esc_html__( 'Select and configure the font for your content.', 'wfc-genesis' ),
			),
			array( 
				'type' 			=> 'googlefonts',
				'section' 		=> 'typography',
				'id' 			=> 'heading_font',
				'label' 		=> esc_html__( 'Headings Font', 'wfc-genesis' ),
				'description' 	=> esc_html__( 'Select and configure the font for your headings.', 'wfc-genesis' ),
			),
			array( 
				'type' 			=> 'googlefonts',
				'section' 		=> 'typography',
				'id' 			=> 'button_input_font',
				'label' 		=> esc_html__( 'Buttons and Inputs Font', 'wfc-genesis' ),
				'description' 	=> esc_html__( 'Select and configure the font for your input fields and buttons.', 'wfc-genesis' ),
			),
			array( 
				'type' 			=> 'fallbackfonts',
				'section' 		=> 'typography',
				'id' 			=> 'fallback_font',
				'default'		=> 'Arial, Helvetica Neue, Helvetica, sans-serif',
				'label' 		=> esc_html__( 'Fallback Font', 'wfc-genesis' ),
				'description' 	=> esc_html__( 'Fallback font will be used if all other fonts are not available.', 'wfc-genesis' ),
			),

			/*=== Logos and Images ===*/
			array( 
				'type' 		=> 'image',
				'section' 	=> 'logos_and_images',
				'id' 		=> 'logo_light',
				'label' 	=> esc_html__( 'Light Logo', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'image',
				'section' 	=> 'logos_and_images',
				'id' 		=> 'logo_coloured',
				'label' 	=> esc_html__( 'Coloured Logo', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'image',
				'section' 	=> 'logos_and_images',
				'id' 		=> 'logo_dark',
				'label' 	=> esc_html__( 'Dark Logo', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'select',
				'section' 	=> 'logos_and_images',
				'id' 		=> 'main_logo',
				'default'	=> 'logo_light',
				'label' 	=> esc_html__( 'Main Logo', 'wfc-genesis' ),
				'choices' 	=> array( 
		         	'logo_light' 	=> esc_html__( 'Light Logo', 'wfc-genesis' ),
		         	'logo_coloured' => esc_html__( 'Coloured Logo', 'wfc-genesis' ),
		         	'logo_dark' 	=> esc_html__( 'Dark Logo', 'wfc-genesis' )
		      	)
			),
			array( 
				'type' 		=> 'image',
				'section' 	=> 'logos_and_images',
				'id' 		=> 'default_image',
				'label' 	=> esc_html__( 'Default Image', 'wfc-genesis' ),
			),

			/*=== General ===*/
			array( 
				'type' 		=> 'separator',
				'section' 	=> 'general',
				'id' 		=> 'google_api',
				'label' 	=> esc_html__( 'Google API', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'text',
				'section' 	=> 'general',
				'id' 		=> 'google_api_key',
				'label' 	=> esc_html__( 'API Key', 'wfc-genesis' ),
				'description' => esc_html__( 'Note : This API Key is needed for Google fonts functionality.', 'wfc-genesis' ) . sprintf( '<p>%s <a href="https://asapidocs.alphasys.com/docs/wfc-api-documentation/wfc-genesis/#google_fonts" target="_blank">%s</a></p>',
					esc_html__( 'Trouble in getting the Google API Key?', 'wfc-genesis' ),
					esc_html__( 'Click here.', 'wfc-genesis' )
				),
			),

			/*=== Site Dimensions ===*/
			array( 
				'type' 		=> 'text',
				'section' 	=> 'dimensions',
				'id' 		=> 'max_site_width',
				'default'	=> '100rem',
				'label' 	=> esc_html__( 'Max Site Width', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'text',
				'section' 	=> 'dimensions',
				'id' 		=> 'max_row_width',
				'default'	=> '80rem',
				'label' 	=> esc_html__( 'Max Row Width', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'separator',
				'section' 	=> 'dimensions',
				'id' 		=> 'hero_height',
				'label' 	=> esc_html__( 'Hero Heights', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'text',
				'section' 	=> 'dimensions',
				'id' 		=> 'hero_height_home_sm',
				'default'	=> '300px',
				'label' 	=> esc_html__( 'Home (small)', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'text',
				'section' 	=> 'dimensions',
				'id' 		=> 'hero_height_home_md',
				'default'	=> '450px',
				'label' 	=> esc_html__( 'Home (medium)', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'text',
				'section' 	=> 'dimensions',
				'id' 		=> 'hero_height_home_lg',
				'default'	=> '600px',
				'label' 	=> esc_html__( 'Home (large)', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'text',
				'section' 	=> 'dimensions',
				'id' 		=> 'hero_height_other_sm',
				'default'	=> '300px',
				'label' 	=> esc_html__( 'Other (small)', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'text',
				'section' 	=> 'dimensions',
				'id' 		=> 'hero_height_other_md',
				'default'	=> '400px',
				'label' 	=> esc_html__( 'Other (medium)', 'wfc-genesis' ),
			),
			array( 
				'type' 		=> 'text',
				'section' 	=> 'dimensions',
				'id' 		=> 'hero_height_other_lg',
				'default'	=> '500px',
				'label' 	=> esc_html__( 'Other (large)', 'wfc-genesis' ),
			),

			/*=== Header ===*/
			array( 
				'type' 		=> 'text',
				'section' 	=> 'header',
				'id' 		=> 'setting33',
				'label' 	=> esc_html__( 'Setting Sample 33', 'wfc-genesis' ),
			),

		)
	);

	/* Add 20 Color Pallete Controls */
	for ( $i = 1; $i <= 20 ; $i++ ) { 
		$customizer_settings[ 'controls' ][] = array( 
			'priority'		=> 9,
			'type' 			=> 'color-alpha',
			'section' 		=> 'theme_colors',
			'id' 			=> "color_palette_" . $i,
			'label' 		=> esc_html__( "Color " . $i, 'wfc-genesis' ),
			'description' 	=> sprintf( '( bg%1$s, hbg%1$s, text%1$s, htext%1$s, border%1$s, hborder%1$s )', $i ),
			'active_callback' => function( $control ) use ( $i ) { 
				return wfc_color_pallete_callback( $control, $i );
			}
		);
	}

	/**
	 * Filter `wfc_customizer_settings`.
	 * 
	 * Filter used to extend the theme default customizer settings. 
	 * 
	 * @param Array $customizer_settings The theme customizer settings.
	 * @param WP_Customize_Manager $$wp_customize The current environment, false if not defined.
	 */
	$customizer_settings = apply_filters( 'wfc_customizer_settings', $customizer_settings, $wp_customize );
	
	wfc_register_customizer_controls( $customizer_settings, $wp_customize );
 
} );

/**
 * Enqueue the google fonts based from customizer typography settings.
 */
add_action( 'wp_enqueue_scripts', function( ) {

    $base_font = get_theme_mod( 'base_font', '' );
    $heading_font = get_theme_mod( 'heading_font', '' );
    $button_input_font = get_theme_mod( 'button_input_font', '' );

    $font_families = array();

    if ( $base_font ) 
        $font_families[] = $base_font;

    if ( $heading_font ) 
        $font_families[] = $heading_font;

    if ( $button_input_font ) 
        $font_families[] = $button_input_font;

    if ( count( $font_families ) ) {

    	$query_args = array(
	        'family' => urlencode( implode( '|', array_unique( $font_families ) ) )
	    );

	    $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	    wp_enqueue_style( 'googlefonts', esc_url_raw( $fonts_url ) );
    }

}, 9 ); 

/**
 * Enqueue the dynamic css generated from the customizer.
 */
add_action( 'wp_enqueue_scripts', function( ) {

	if ( is_customize_preview() ) {

		if ( is_plugin_active( 'alphasys-content-management/alphasys-content-management.php' ) ) {
			wp_add_inline_style( 'bootstrap', wfc_build_css_string() );
		} else {
    		wp_add_inline_style( 'wfc-genesis', wfc_build_css_string() );
		}
	} else {

		// Check if multisite and load the right css file for the subsite
		if ( is_multisite() ) {
			$blog_id = get_current_blog_id();

			wp_enqueue_style( 'dynamic-css', get_stylesheet_directory_uri() . "/assets/css/dynamic{$blog_id}.css" );

		} else {
			wp_enqueue_style( 'dynamic-css', get_stylesheet_directory_uri() . '/assets/css/dynamic.css' );
		}
    }

}, 20 ); 

/**
 * Update the dynamic.css file 
 * when the customizers settings has been saved. 
 */
add_action( 'customize_save_after', function( ) {

	wfc_generate_dynamic_css();

} );

/**
 * Generate the dynamic.css file if not exist and
 * force update the file if dynamic_css_refresh query string was set on url.
 */
add_action( 'init', function() {

	$dynamic_css_dir = get_stylesheet_directory() . '/assets/css/dynamic.css' ;

	if ( !file_exists( $dynamic_css_dir ) || isset( $_GET[ 'dynamic_css_refresh' ] ) ) {
		wfc_generate_dynamic_css();
	}

} );

/**
 * Create a dynamic.css file if not exists 
 * and write the custom css style on it based on customizer settings.
 */
function wfc_generate_dynamic_css( ) {

	$dynamic_css_dir = get_stylesheet_directory() . '/assets/css/dynamic.css' ;
	$dynamic_css_exist = file_exists( $dynamic_css_dir );

	if ( ! $dynamic_css_exist ) 
		$dynamic_css_exist = touch( $dynamic_css_dir );
	
	if ( ! $dynamic_css_exist )
		return;

	$dynamic_css = wfc_build_css_string();

	$fopen = fopen( $dynamic_css_dir, "w" ); 
    $write = fputs( $fopen, $dynamic_css ); 
    fclose( $fopen );

}

/**
 * Build the custom css styles base on customizer settings.
 * 
 * @param bool $minified Whether CSS string is to be minified.
 */
function wfc_build_css_string( $minified = true ) {

	$css = '';

    $fallback_font = get_theme_mod( 'fallback_font', 'Arial, Helvetica Neue, Helvetica, sans-serif' );

    /* Body */
	$base_font = get_theme_mod( 'base_font', '' );
	$text_color = get_theme_mod( 'text_color', '#212529' );

    if ( ! empty( $base_font ) || ! empty( $text_color ) ) {
		$css .= 'body {';
		$css .= ! empty( $base_font ) ? sprintf( 'font-family: \'%s\', %s;', $base_font, $fallback_font ) : '';
		$css .= ! empty( $text_color ) ? sprintf( 'color: %s;', $text_color ) : '';
		$css .= '}';
    }

    /* Heading */
    $heading_font = get_theme_mod( 'heading_font', '' );

    if ( ! empty( $heading_font ) ) {
    	$css .= 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {';
    	$css .= sprintf( 'font-family: \'%s\', %s;', $heading_font, $fallback_font );
    	$css .= '}';
    }

    /* Button and Input */
    $button_input_font = get_theme_mod( 'button_input_font', '' );

    if ( ! empty( $button_input_font ) ) {
    	$css .= 'button, input, select, textarea {';
    	$css .= sprintf( 'font-family: \'%s\', %s;', $button_input_font, $fallback_font );
    	$css .= '}';
    }

    /* Button colors */
    $button_color_primary = get_theme_mod( 'button_color_primary', '#007bff' );
    $button_color_secondary = get_theme_mod( 'button_color_secondary', '#6c757d' );
    $button_color_tertiary = get_theme_mod( 'button_color_tertiary', '#28a745' );

    /* Button Primary */
    if ( ! empty( $button_color_primary ) ) {
    	$css .= '.btn-primary {';
    	$css .= sprintf( 'background-color: %s;', $button_color_primary );
    	$css .= '}';

    	$css .= '.btn-outline-primary {';
    	$css .= sprintf( 'color: %s;', $button_color_primary );
    	$css .= sprintf( 'border-color: %s;', $button_color_primary );
    	$css .= '}';
    }

    /* Button Secondary */
    if ( ! empty( $button_color_secondary ) ) {
    	$css .= '.btn-secondary {';
    	$css .= sprintf( 'background-color: %s;', $button_color_secondary );
    	$css .= '}';

    	$css .= '.btn-outline-secondary {';
    	$css .= sprintf( 'color: %s;', $button_color_secondary );
    	$css .= sprintf( 'border-color: %s;', $button_color_secondary );
    	$css .= '}';
    }

    /* Button Tertiary */
    if ( ! empty( $button_color_tertiary ) ) {
    	$css .= '.btn-tertiary {';
    	$css .= sprintf( 'background-color: %s;', $button_color_tertiary );
    	$css .= '}';

    	$css .= '.btn-outline-tertiary {';
    	$css .= sprintf( 'color: %s;', $button_color_tertiary );
    	$css .= sprintf( 'border-color: %s;', $button_color_tertiary );
    	$css .= '}';
    }

    /* Header */
	$header_background_color = get_theme_mod( 'header_background_color', '#007bff' );
	$header_text_color = get_theme_mod( 'header_text_color', '#ffffff' );

	if ( ! empty( $header_background_color ) ) {
		$css .= '.site-header {';
		$css .= sprintf( 'background-color: %s;', $header_background_color );
		$css .= '}';
	}

	if ( ! empty( $header_text_color ) ) {
		$css .= '.site-header, .site-header * {';
		$css .= sprintf( 'color: %s;', $header_text_color );
		$css .= '}';
	}

    /* Color Pallete helper classes */
	$color_count = get_theme_mod( 'color_count', 8 );

	for ( $i = 1;  $i < 10;  $i++ ) { 
		$color = get_theme_mod( 'color_palette_' . $i, '' );

		if ( ! empty( $color ) ) {
			$css .= sprintf( '.text%1$d, .htext%1$d:hover {', $i );
			$css .= sprintf( 'color: %s !important;', $color );
			$css .= '}';

			$css .= sprintf( '.bg%1$d, .hbg%1$d:hover {', $i );
			$css .= sprintf( 'background-color: %s !important;', $color );
			$css .= '}';

			$css .= sprintf( '.border%1$d, .hborder%1$d:hover {', $i );
			$css .= sprintf( 'border-color: %s !important;', $color );
			$css .= '}';
		}
	}

	/* Links */
	$link_color = get_theme_mod( 'link_color', '#007bff' );

	if ( ! empty( $link_color ) ) {
		$css .= sprintf( 'a {' );
		$css .= sprintf( 'color: %s;', $link_color );
		$css .= '}';
	}

	/**
	 * Filter `wfc_dynamic_css`.
	 * 
	 * Filter used to extend the theme dynamic css styles 
	 * when the customizer settings has been saved.
	 * 
	 * @param String $css The theme dynamic css styles.
	 */
	$css = apply_filters( 'wfc_dynamic_css', $css );

	if ( $minified ) {
		$css = preg_replace( '/\s\s+/', '', $css );
		$css = preg_replace( '/\s\{+/', '{', $css );
		$css = preg_replace( '/\:\s+/', ':', $css );
	}

	return $css;

}