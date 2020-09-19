<?php
/**
 * WFC Genesis.
 *
 * This file adds functions to the WFC Genesis Child Theme.
 *
 * @package WFC_Genesis/Core
 * @author  AlphaSys
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

 // Adds theme functions.
require_once get_stylesheet_directory() . '/includes/theme-functions.php';
require_once get_stylesheet_directory() . '/includes/layout.php';

add_theme_support(
    'genesis-menus', array(
        'main'   		=> __( 'Main Menu', 'wfc-genesis' ),
        'footer' 		=> __( 'Footer Menu', 'wfc-genesis' ),
		'cta' 			=> __( 'CTA Menu', 'wfc-genesis' ),
        'offcanvas-menu' 	=> __( 'Offcanvas Menu', 'wfc-genesis' ),
    )
);

add_action( 'wp_enqueue_scripts', 'wfc_enqueue_custom_scripts' );
/**
 * Enqueue scripts.
 */
function wfc_enqueue_custom_scripts() {

	$addthis_id = get_theme_mod( 'addthis_id' );

	if ( ! empty( $addthis_id ) ) {
		wp_enqueue_script( 'addthis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=' . $addthis_id, array(), false, true );
	}
}

add_filter( 'wfc_dynamic_css', 'wfc_custom_dynamic_css' );
/**
 * Generates and returns dynamic CSS.
 * 
 * @param string $css CSS styles set from other filter handler.
 * 
 * @return string
 */
function wfc_custom_dynamic_css( $css ) {

	$site_max_width 		= get_theme_mod( 'max_site_width', '100rem' );
	$row_max_width 			= get_theme_mod( 'max_row_width', '80rem' );
	$full_width_margin 		= '-' . ( ( $site_max_width - $row_max_width ) / 2 ) . 'rem';
	
	$button_text_color 		= get_theme_mod( 'button_text_color', '#ffffff' );
	$header_bg_color 		= get_theme_mod( 'header_background_color', '#007bff' );
	$site_bg_color 			= get_theme_mod( 'site_background_color', '#eeeeee' );
	$page_bg_color			= get_theme_mod( 'page_background_color', '#eeeeee' );
	
	$header_text_color 		= get_theme_mod( 'header_text_color', '#ffffff' );

	$color_4				= get_theme_mod( 'color_palette_4', '#ffffff' );
	$color_6				= get_theme_mod( 'color_palette_6', '#ffffff' );
	$color_7				= get_theme_mod( 'color_palette_7', '#ffffff' );
	$link_text_color		= get_theme_mod( 'text_color', '#ffffff' );
	$link_border_color		= get_theme_mod( 'link_color', '#ffffff' );
	$button_color_secondary	= get_theme_mod( 'button_color_secondary', '#ffffff' );
	
	$height_sm  = get_theme_mod( 'hero_height_other_sm', '18.75rem' );

	$css .= "
	
		body {
			background-color: {$site_bg_color} 
		}
		
		.site-container {
			background-color: {$page_bg_color} 
		}
			
		.site-offcanvas,
		.search-popup,
		.topbar {
			background-color: {$header_bg_color};
		}
		
		.hero-info {
			background: {$page_bg_color};
		}

		.nav-toggle .line {
			background-color: {$header_text_color};
		}
		
		.site-offcanvas,
		.topbar,
		.search-popup,
		.search-input-wrap input {
			color: {$header_text_color};
		} 
		
		.btn:not(.btn-outline-primary):not(.btn-outline-secondary):not(.btn-outline-tertiary) {
			color: {$button_text_color};
		}

		.tags > a,
		.tags > li > a,
		a.tag {
			border: 1px solid {$color_4};
			background: {$page_bg_color};
			color: {$color_6};
		}

		.tags > a:hover,
		.tags > li > a:hover,
		a.tag:hover {
			color: {$button_text_color};
			background: {$button_color_secondary};
			border-color: {$button_color_secondary};
		}

		.links > a,
		.links > li > a,
		a.link {
			border-bottom: 1px dotted {$color_7};
			color: {$link_text_color};
		}

		.links > a:hover,
		.links > li > a:hover,
		a.link:hover {
			border-color: {$link_border_color};
		}
		
		.full-width-img-cont {
			height: {$height_sm};
		}
		
		@media (min-width: 62rem) {
			.full-w-margin {
				margin-right: {$full_width_margin};
				margin-left:  {$full_width_margin};
			} 
		}

	";	
	
	if ( ! empty( $site_max_width ) ) {
		$css .= "
			.site-container {
				max-width: $site_max_width;
			}
		";
	} 

	if ( ! empty( $row_max_width ) ) {
		$css .= "
			.wrapper {
				max-width: $row_max_width;
			}
		";
	}

	if ( ! empty( $header_bg_color ) ) {
		$css .= "
			.site-footer {
				background-color: $header_bg_color;
				color: $header_text_color;
			}
		";
	}



	return $css;
}

add_filter( 'wfc_customizer_settings', 'wfc_add_customizer_settings', 10, 2 );
/**
 * Registers custom customizer settings.
 * 
 * Note: These settings are not part of the core.
 * 
 * @param array $customizer_settings
 * 
 * @return array
 */
function wfc_add_customizer_settings( $customizer_settings, $wp_customize ) {

	$customizer_settings['sections'] = array_merge( $customizer_settings['sections'], array(
		array(
			'id' 		=> 'social_media',
			'panel' 	=> 'site_configuration',
			'title' 	=> esc_html__( 'Social Media', 'wfc-genesis' )
		),
	) );

	$customizer_settings['controls'] = array_merge( $customizer_settings['controls'], array(
		// Under Brand Settings > Logos and Images section.
		array(
			'type' 			=> 'image',
			'section' 		=> 'logos_and_images',
			'id' 			=> 'login_logo',
			'default' 		=> '',
			'label' 		=> esc_html__( 'Login Logo', 'wfc-genesis' ),
			'description' 	=> esc_html__( 'Set the logo for login page.', 'wfc-genesis' ),
		),

		// Under Site Configurations > Social Media section.
		array(
			'type' 			=> 'text',
			'section' 		=> 'social_media',
			'id' 			=> 'addthis_id',
			'default' 		=> '',
			'label' 		=> esc_html__( 'Addthis ID', 'wfc-genesis' ),
			'description' 	=> esc_html__( 'Set the ID of addthis social share.', 'wfc-genesis' ),
		),

		//  Under Brand Settings > Logos and Images section.
		array(
			'type'			=> 'image',
			'section'		=> 'logos_and_images',
			'id'			=> 'knife_edge_img',
			'default'		=> '',
			'label'			=> esc_html__( 'Knife Edge Image', 'wfc-genesis' ),
			'description'	=> esc_html__( 'Set the image to use as overlay on the hero.', 'wfc-genesis' ),
		),

	) );

	// Add Icons Section on Brand Settings Panel
	$wp_customize->add_section( 'icons', array(
		'title' 		=> esc_html__( 'Icons', 'wfc-genesis' ),
		'panel'			=> 'brand_settings'
	) );

	// Add Settings for the Icon Section Controls
	$wp_customize->add_setting( 'mission_challenge_icon', array(
		'default'		=> ''
	) );

	$wp_customize->add_setting( 'results_outcomes_icon', array(
		'default'		=> ''
	) );

	$wp_customize->add_setting( 'links_icon', array(
		'default'		=> ''
	) );

	$wp_customize->add_setting( 'tags_icon', array(
		'default'		=> ''
	) );

	// Add Controls for the Icon Section
	$wp_customize->add_control( 'mission_challenge_icon', array(
		'label'			=> esc_html__( 'Mission/Challenge', 'wfc-genesis' ),
		'description'	=> esc_html__( 'Set icon to be used for Mission/Challenge. Use fontawesome html markup for the icon.', 'wfc-genesis' ),
		'section'		=> 'icons',
		'settings'		=> 'mission_challenge_icon'
	) );

	$wp_customize->add_control( 'results_outcomes_icon', array(
		'label'			=> esc_html__( 'Results/Outcomes', 'wfc-genesis' ),
		'description'	=> esc_html__( 'Set icon to be used for Results/Outcomes. Use fontawesome html markup for the icon.', 'wfc-genesis' ),
		'section'		=> 'icons',
		'settings'		=> 'results_outcomes_icon'
	) );

	$wp_customize->add_control( 'links_icon', array(
		'label'			=> esc_html__( 'Links', 'wfc-genesis' ),
		'description'	=> esc_html__( 'Set icon to be used for Links. Use fontawesome html markup for the icon.', 'wfc-genesis' ),
		'section'		=> 'icons',
		'settings'		=> 'links_icon'
	) );

	$wp_customize->add_control( 'tags_icon', array(
		'label'			=> esc_html__( 'Tags', 'wfc-genesis' ),
		'description'	=> esc_html__( 'Set icon to be used for Tags. Use fontawesome html markup for the icon.', 'wfc-genesis' ),
		'section'		=> 'icons',
		'settings'		=> 'tags_icon'
	) );

	return $customizer_settings;
}

add_action( 'login_enqueue_scripts', 'wfc_login_logo' );
/**
 * Change the logo on the home page with the image
 * set in Login Logo settings from customizer.
 * 
 * If not logo was set, then the WP Logo will remain.
 */
function wfc_login_logo() {

	$logo_url = get_theme_mod( 'login_logo' );
	$img_id = attachment_url_to_postid( $logo_url );
	$fix_width = 320;

	if ( $img_id ) {
		$attach_data = wp_get_attachment_image_src( $img_id, 'full' );

		$width = isset( $attach_data[1] ) ? $attach_data[1] : '';
		$height = isset( $attach_data[2] ) ? $attach_data[2] : '';
	}

	// Recalculate image size.
	if ( ! empty( $width ) && ! empty( $height ) && absint( $width ) > $fix_width ) {
		$width = absint( $width );
		$height = absint( $height );
		$ratio = $width / $height;

		$height = floor( $fix_width / $ratio );
		$width = $fix_width;
	}

	if ( ! empty( $logo_url ) ) :
	?>
		<style type="text/css">
			#login h1 a,
			.login h1 a {
				background-image: url(<?php echo esc_url( $logo_url ); ?>);
				<?php if ( ! empty( $width ) && ! empty( $height ) ) : ?>
					background-size: contain;
					width: <?php echo $width; ?>px;
					height: <?php echo $height; ?>px;
				<?php endif; ?>
			}
		</style>
	<?php
	endif;
}

add_filter( 'login_headerurl', 'wfc_login_logo_url' );
/**
 * Change the logo URL to home page of the site.
 * 
 * @return string
 */
function wfc_login_logo_url() {
    return home_url();
}

/**
 * Get section template. Returns false if section
 * doesn't exists.
 * 
 * @param string $section_name Template name without extension.
 * 
 * @return string|bool
 */
function wfc_get_section( $section_name ) {
	
	$section_dir = get_stylesheet_directory() . '/template-parts/sections';
	/**
	 * The section directory.
	 * 
	 * @param string $section_dir The directory of the sections.
	 */
	$section_dir = apply_filters( 'wfc_section_dir', $section_dir );
	$section_dir = trailingslashit( $section_dir );

	$section_file = $section_dir . $section_name . '.php';
	$section = '';
	
	if ( file_exists( $section_file ) ) {
		ob_start();

		include $section_file;

		return ob_get_clean();
	}

	return false;

}

/**
 * Return the post excerpt else get the first 200 characters in a post content 
 * and return the cut off string of the last word 
 *
 * @author Jimson Rudinas
 *
 * @param id $id 
 *
 * @return string
 */
function wfc_get_post_excerpt( $id = '' ) {
	
	if ( is_int( $id ) ) {
		$content = get_the_excerpt($id);
	} else {
		$content = get_the_excerpt();
	}
	
	if ( strlen($content) >= 200 ) {
		$excerpt = substr($content, 0, 200);
		$content = substr($excerpt, 0, strrpos($excerpt, ' '));	
	}
	
	return $content;
}

/**
 * Returns the page layout of a particular page. Will get the
 * default layout if not set on the page.
 *
 * @author Carl Ortiz
 *
 * @param int $id The id of the page.
 *
 * @return string
 */
function wfc_get_get_layout( $id ) {

	$page_layout = genesis_get_layout( $id );

	if ( is_null( $page_layout ) ) {
		$page_layout = genesis_get_default_layout();
	}

	return $page_layout;
}

/**
 * Add Output Buffering iside the body tag
 *
 * @author Jimson Rudinas
 * 
 */
function wfc_after_body_open() {
	ob_start();
}
add_action('wp_body_open', 'wfc_after_body_open');

/**
 * Search and replace the placeholder %%year%% from the body 
 * before outputting the whole content
 *
 * @author Jimson Rudinas
 *
 */
function wfc_before_body_close() {
	
	$output  = ob_get_clean();
	
	$current_year = date("Y");
	$output  = str_ireplace("%%year%%", $current_year, $output );
	echo $output ; 
	
	ob_end_flush();
	
}
add_action('wp_footer', 'wfc_before_body_close');

/*
 * Return the modified search results size in the search query
 *
 * @author Jimson Rudinas
 *
 * @param array $query The query vars
 *
 * @return array
 */

function wfc_search_size($query) {
    if ( $query->is_search ) 
        $query->query_vars['posts_per_page'] = -1; 
	
	return $query; // Return our modified query variables
}
add_filter('pre_get_posts', 'wfc_search_size'); 

/**
 * Enable show_in_rest option in CPT-Onomy to enable gutenberg
 *
 * @author Jimson Rudinas
 *
 * @param array $args The CPT args.
 * @param string $post_type The CPT name.
 
 * @return array
 */
function wfc_enable_cpt_rest( $args, $post_type ){
	
	if ( isset($args['created_by_cpt_onomies']) ) {
		if ( $args['created_by_cpt_onomies'] == true && $args['public'] == true ) {
			$args['show_in_rest'] = true;
		}
	}
		
	return $args;
	
}
add_filter( 'register_post_type_args', 'wfc_enable_cpt_rest' , 10, 2 );

/**
 * Add classes to body.
 * 
 * @author Jimson Rudinas
 * 
 * @param $classes array Body classes.
 * 
 * @return array
 */
function wfc_add_body_class( $classes ) {
	
	$has_panels 	= false;
	$post_id = wfc_get_page_id();
	$post = get_post($post_id); 
	$hero_type 		= get_post_meta( $post_id, 'wfc_hero_type', true );
	$theme_class	= get_theme_mod( 'theme_class', 'light' );
	
	if ( class_exists( 'ASCM_Panels_Helper' ) ) {
		
		$ascm_hooks = ASCM_Panels_Helper::get_pageinfobyid( $post->ID );
		if ( ! empty( $ascm_hooks ) ) {
		
			if (	! empty ( $ascm_hooks['afterheader'] ) ||
					! empty ( $ascm_hooks['beforecontent'] ) ||
					! empty ( $ascm_hooks['aftercontent'] ) ||
					! empty ( $ascm_hooks['beforefooter'] ) ||
					! empty ( $ascm_hooks['genesisbeforeheader'] ) ||
					! empty ( $ascm_hooks['genesisafterheader'] ) ||
					! empty ( $ascm_hooks['genesisentryheader'] ) ||
					! empty ( $ascm_hooks['genesisentryfooter'] ) ||
					! empty ( $ascm_hooks['genesisbeforefooter'] ) ||
					! empty ( $ascm_hooks['genesisafterfooter'] ) ) {
						
				$has_panels = true;
				
			} 
		}
	}
	
	$classes[] = ( is_archive() )       ? '' : 'not-archive'; 
	$classes[] = ( is_attachment() )    ? 'attachment' : 'not-attachment';
	$classes[] = ( is_front_page() )    ? '' : 'not-home';
	$classes[] = ( is_home() )          ? '' : 'not-blog'; 
	$classes[] = ( is_page() )          ? '' : 'not-page'; 
	$classes[] = ( is_search() )        ? '' : 'not-search';
	$classes[] = ( is_single() )        ? '' : 'not-single';
	$classes[] = ( is_tax() )           ? 'tax' : 'not-tax';
	$classes[] = ( ! empty( $post ) && ! empty( $post->post_content ) ) ? '' : 'no-content';
	$classes[] =  $has_panels          	? 'has-panels' : 'no-panels';
	$classes[] = ( ! empty ( $hero_type ) ) ? $hero_type : 'hero-knife-edge';
	$classes[] = $theme_class;
	
	return $classes;
}
add_filter( 'body_class','wfc_add_body_class' );

/**
 * Get the current page ID by path
 * 
 * @author Jimson Rudinas
 * 
 * @return int
 */
function wfc_get_page_id() {
	
	$post_id = get_option('page_on_front');
	
	if ( is_archive() ) {
		global $post_type;
		$archive_page = get_page_by_path( $post_type );

		if( $archive_page ) {
			$post_id = $archive_page->ID;
		}

	} elseif ( is_search() ) {
		$archive_page = get_page_by_path( 'search' );
		
		if ( $archive_page ) {
			$post_id = $archive_page->ID;
		}
	} elseif ( is_home() ) {
		$archive_page = get_page_by_path( 'blog' );

		if ( $archive_page ) {
			$post_id = $archive_page->ID;
		}
	} else {
		$post_id = get_the_ID();
	}
	
	return $post_id;
	
}

/**
 * Get the current page title by path
 * 
 * @author Jimson Rudinas
 * 
 * @return string
 */
function wfc_get_page_title_by_path() {
	
	if ( is_home() ) {
		$archive_page = get_page_by_path( 'blog' );

		if ( $archive_page ) {
			$page_title = __( get_the_title( $archive_page->ID ), 'wfc-genesis' );
		} else {
			$page_title = 'Blog';
		}

	} elseif ( is_search() ) {
		$archive_page = get_page_by_path( 'search' );

		if ( $archive_page ) {
			$page_title = __( get_the_title( $archive_page->ID ), 'wfc-genesis' );
		} else {
			$page_title = 'Search';
		}
		
	} elseif ( is_archive() ) {
		global $post_type;
		
		$archive_page = get_page_by_path( $post_type );

		if( $archive_page ) {
			$page_title = __( get_the_title( $archive_page->ID ), 'wfc-genesis' );
		} else {
		$page_title = get_the_archive_title();
		}
		
	} else {
		$page_title = __( get_the_title(), 'wfc-genesis' );
	}
	
	return $page_title;
	
}

/**
* Function Name: wfc_modify_archive_query()
* Author: Jimson Rudinas <jimson@alphasys.com.au>
* Short Description: Modify the archive main query 
* to make it sortable from the archive page meta
*/
function wfc_modify_archive_query( $query ) {

	if( $query->is_main_query() && is_post_type_archive() ) {
			
		$archive_page = get_page_by_path( $query->query['post_type'] );
		
		if ( $archive_page ) {
			$archive_order = get_post_meta( $archive_page->ID , 'sort_order', true );
			$archive_orderby = get_post_meta( $archive_page->ID , 'order_by', true );
			$archive_post_num = get_post_meta( $archive_page->ID , 'post_per_page', true );
			
			$query->set( 'order', $archive_order );
			$query->set( 'orderby', $archive_orderby );
			$query->set( 'posts_per_page', (int) $archive_post_num );
		}
		
	}
	
	return $query; 
	
}
add_filter('pre_get_posts', 'wfc_modify_archive_query'); 

/**
 * Function Name: wfc_localize_tags_and_links()
 * Author: Rowelle Gem Daguman <rowelle@alphasys.com.au>
 * Short Description: Localize wfc custom js script to pass
 * the values from customizer icons for links and tags
 */
function wfc_localize_tags_and_links() {
	$l10n_arr = array(
		'links_icon'	=> get_theme_mod( 'links_icon', '' ),
		'tags_icon'		=> get_theme_mod( 'tags_icon', '' ),
	);
	wp_localize_script( 'wfc-custom', 'tags_links_icon', $l10n_arr );
}

add_action( 'wp_enqueue_scripts', 'wfc_localize_tags_and_links' );


/**
 * Function Name: wfc_add_archive_state()
 * Author: Rowelle Gem Daguman <rowelle@alphasys.com.au>
 * Short Description: add Archive Page label to pages with
 * slug = post_types
 * 
 * @param array $state An array of post display state
 * @param WP_Post $post The current post object
 * 
 * @return array
 */
function wfc_add_archive_state( $states, $post ) {
	$post_slug = $post->post_name;
	$post_types = get_post_types( array(
		'public'	=> true,
		'_builtin'	=> false
	) );

	if( in_array( $post_slug, $post_types ) ) {
		$states[] = __( 'Archive Page' );
	}

	return $states;
}

add_filter( 'display_post_states', 'wfc_add_archive_state', 10, 2 );

/**
 * Function Name wfc_display_childposts_metabox()
 * Author: Rowelle Gem Daguman <rowelle@alphasys.com.au>
 * Short Description: The callback function for displaying the metabox content
 * for Child Posts Metabox
 *
 * @param WP_Post $post The current post object
 */
function wfc_display_childposts_metabox( $post ) {
	$post_children = get_pages( array( 'child_of' => $post->ID ) );
	$post_children_details = [];

	if ( count( $post_children ) ) {
		foreach ( $post_children as $post_child ) {
			$post_children_details[$post_child->ID] = array(
				'post_title'	=> $post_child->post_title,
				'post_link'		=> get_edit_post_link( $post_child->ID )
			);
		}
	}
	?>
	<div>
		<ul>
			<?php foreach( $post_children_details as $post_child ) : ?>
			<li>
				<a href="<?php echo $post_child['post_link']; ?>" target="_blank"><?php echo $post_child['post_title']; ?></a>
			</li>
			<?php endforeach ?>
		</ul>
	</div>
	<?php
}

/**
 * Function Name: wfc_register_childposts_metabox()
 * Author: Rowelle Gem Daguman <rowelle@alphasys.com.au>
 * Short Description: Register the Metabox for Child Posts
 */
function wfc_register_childposts_metabox( $post_type, $post ) {
	$post_children = get_pages( array( 'child_of' => $post->ID ) );

	if ( count( $post_children ) ) {
		add_meta_box( 'wfc_childposts_metabox', __( 'Child Posts', 'wfc-genesis' ), 'wfc_display_childposts_metabox', null, 'side' );
	}
}

add_action( 'add_meta_boxes', 'wfc_register_childposts_metabox', 10, 2 );

/**
 * Function Name: wfc_add_edit_archive_link()
 * Author: Rowelle Gem Daguman <rowelle@alphasys.com.au>
 * Short Description: Add and Edit Archive link on the Post Types Admin Menu
 */
function wfc_add_edit_archive_link() {
	global $submenu;

	$post_types = get_post_types( array(
		'public'	=> true,
		'_builtin'	=> false
	) );

	$excluded_post_types = array(
		'ascm_repost',
		'ascm_panels'
	);

	$post_types = array_diff( $post_types, $excluded_post_types );

	foreach ( $post_types as $post_type ) {
		$archive_page = get_page_by_path( $post_type );		

		if ( $archive_page ) {
			$edit_link = get_edit_post_link( $archive_page->ID );
			$submenu['edit.php?post_type='.$post_type][] = array( 'Edit Archive Page', 'manage_options', $edit_link );
		}		
	}
}

add_action( 'admin_menu', 'wfc_add_edit_archive_link' );

/**
 * Function Name: wfc_card_exists()
 * Author: Carl Ortiz
 * Short Description: Check if card exists in post type Magic Card or
 *                    as card file.
 *                    
 * @param string $slug Card slug, file name or slug of magic card.
 * 
 * @return bool
 */
function wfc_card_exists( $slug ) {

	if ( ! is_string( $slug ) ) {
		return false;
	}

	$m_card = get_page_by_path( $slug, OBJECT, 'ascm-magic-card' );

	if ( ! is_null( $m_card ) ) {
		return true;
	}

	$card_file = sprintf( '%s/%s.php', wfc_get_cards_dir(), $slug );

	if ( file_exists( $card_file ) ) {
		return true;
	}

	return false;
}

/**
 * Function Name: setup_social_media_sharing_cards() 
 * Author: Vincent Liong
 * Short Description: Setup site header meta for social media sharing Summary Card on the following sites (Facebook, Twitter, and Linkedin)
 *
 * Using the two 'wfc_get_image' to retrieve the fail graceful image URLs
 * 
 * @since 1.0.0
 */
function setup_social_media_sharing_cards() {
	
    global $post;

	$id 	= get_the_ID();
	$image 	= '';
    if ( $post->post_type == 'post' ) {
        if ( empty( $bg_sm = get_post_meta( $id, 'wfc_heroimages_small', true ) ) ) {
            if ( empty( $bg_sm = get_the_post_thumbnail_url( $id, 'large' ) ) ) {
                $bg_sm = !empty( $bg_sm = get_post_meta( $id, 'featured_image_url_thumbnail', true ) ) ? $bg_sm : wfc_get_image( $id, 'hero', 'small' );
            }
        }

        if ( empty( $bg_md = get_post_meta( $id, 'wfc_heroimages_medium', true ) ) ) {
            if ( empty( $bg_md = get_the_post_thumbnail_url( $id, 'large' ) ) ) {
                $bg_md = !empty( $bg_md = get_post_meta( $id, 'featured_image_url_medium', true ) ) ? $bg_md : wfc_get_image( $id, 'hero', 'medium' );
            }
        }

        if ( empty( $bg_lg = get_post_meta( $id, 'wfc_heroimages_large', true ) ) ) {
            if ( empty( $bg_lg = get_the_post_thumbnail_url( $id, 'large' ) ) ) {
                $bg_lg = !empty( $bg_lg = get_post_meta( $id, 'featured_image_url_large', true ) ) ? $bg_lg : wfc_get_image( $id, 'hero', 'large' );
            }
        }        
    } else {
        $bg_sm = wfc_get_image( $id, 'hero', 'small' );
        $bg_md = wfc_get_image( $id, 'hero', 'medium' );
        $bg_lg = wfc_get_image( $id, 'hero', 'large' );
	}
	
	if ( !empty( $bg_lg ) ) {
		$image = $bg_lg;
	} elseif ( !empty( $bg_md ) ) {
		$image = $bg_md;
	} else {
		$image = $bg_sm;
	}

	echo "<!-- Setup WFC Genesis header meta -->";
	echo "<meta property='og:image'	content='{$image}' />";

	echo "<!-- Twitter -->";
	echo "<meta name='twitter:image' content='{$image}'>";

	echo "<!-- End of setup WFC Genesis header meta -->";

}
add_action('genesis_meta', 'setup_social_media_sharing_cards');