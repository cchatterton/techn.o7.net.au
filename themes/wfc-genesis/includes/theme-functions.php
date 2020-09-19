<?php
/**
 * WFC Genesis.
 *
 * This file adds theme functions to the WFC Genesis Child Theme.
 *
 * @package WFC_Genesis/Core
 * @author  AlphaSys
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add Theme Support for Yoast SEO Breadcrumbs
add_theme_support( 'yoast-seo-breadcrumbs' );

/**
 * Enqueue WFC Genesis theme style sheet at higher priority
 */ 
add_action( 'genesis_setup', function() {

	// Remove structural wraps support
	remove_theme_support( 'genesis-structural-wraps' );

	remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
	add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 15 );

} );

/**
 * Enqueues scripts and styles.
 */
add_action( 'wp_enqueue_scripts', function() {


	$dir_uri = get_stylesheet_directory_uri();
	$cdn_uri = '//cdnjs.cloudflare.com/ajax/libs';

	$styles = [
		[ 'js-offcanvas', '//npmcdn.com/js-offcanvas/dist/_css/minified/js-offcanvas.css' ],
		[ 'fontawesome', $dir_uri . '/assets/lib/fontawesome-pro/css/all.min.css' ],
		[ 'bootstrap', $cdn_uri . '/twitter-bootstrap/4.3.1/css/bootstrap.min.css' ],
		[ 'fullpage', $cdn_uri . '/fullPage.js/3.0.7/fullpage.min.css' ],
		[ 'wfc-card', $dir_uri . '/assets/css/card.css' ],
	];

	$scripts = [
		[ 'bootstrap', $cdn_uri . '/twitter-bootstrap/4.3.1/js/bootstrap.min.js', ['jquery'] ],
		[ 'match-height', $cdn_uri . '/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js' ],
		[ 'js-offcanvas', '//npmcdn.com/js-offcanvas/dist/_js/js-offcanvas.pkgd.min.js' ],
		[ 'fullpage', $cdn_uri . '/fullPage.js/3.0.7/fullpage.min.js' ],
		[ 'wfc-custom', $dir_uri . '/assets/js/custom.js' ],
	];
	
	foreach ( $styles as $style ) {
		wp_enqueue_style( $style[0], $style[1] );
	}

	foreach ( $scripts as $script ) {
		$dep = isset( $script[2] ) ? $script[2] : [];
		wp_enqueue_script( $script[0], $script[1], $dep, null, true );
	}

} );

/**
 * Defines all required Class.
 */
$require_classes = [
	/* Adds helper functions */
	'/includes/helper-functions.php',

	/* Adds custom sections and controls to Customizer. */
	'/includes/customizer/customizer.php',

	/* Adds TGM Plugin Activation support. */
	'/includes/tgm-plugin/tgm-plugin-init.php',

	/* Optimization */
	'/includes/optimization/disable-emojis.php', 
	'/includes/optimization/scripts-styles.php', 
	'/includes/optimization/clean-menu.php',

	/* WFC Yoast Breadcrumbs */
	'/includes/yoast-breadcrumbs.php', 
];

foreach ( $require_classes as $class ) {
	require_once get_stylesheet_directory() . $class;
}

/**
 * Initialize the off canvas library.
 */
add_action( 'wp_footer', function() { 
   
    ?>

    <script type="text/javascript">
        jQuery( document ).ready( function( $ ) {
          $( document ).trigger( 'enhance' );
        });
    </script>

    <?php

}, 11 );

/**
 * Displays error when WFC Toolkit plugin is not
 * installed and active.
 */
add_action( 'admin_notices', function() {
	if ( ! is_plugin_active( 'wfc-toolkit/wfc-toolkit.php' ) ) {
		?>
		<div class="notice notice-error is-dismissible">
			<p><?php _e( '<strong>Error:</strong> WFC Toolkit plugin is required to install when using WFC Genesis child theme.', 'wfc-genesis' ); ?></p>
		</div>
		<?php
	}
} );

add_action( 'save_post', 'wfc_delete_post_related_transients', 10, 3 );
/**
 * Deletes all related transients of the post.
 *
 * @param int $post_id Post ID.
 * @param WP_Post $post Post object.
 * @param bool $update Whether this is an existing post being updated or not.
 */
function wfc_delete_post_related_transients( $post_id, $post, $update ) {

	if ( $update ) {
		// Deletes all WFC transient on the currently updated post.
		wfc_delete_post_transients( $post_id );

		/*
		 * Deletes all WFC image transient from posts with the
		 * post type slug like the currently edited post's slug.
		 * This part is for the fail graceful. 
		 */
		if ( post_type_exists( $post->post_name ) ) {
			$ids = get_posts( array(
				'fields' 			=> 'ids',
				'posts_per_page' 	=> -1,
				'post_type' 		=> $post->post_name
			) );

			array_walk( $ids, 'wfc_delete_post_image_transients' );
		}
	}

	// Make sure to run only once when updating post.
	remove_action( 'save_post', 'wfc_delete_post_related_transients' );
}
