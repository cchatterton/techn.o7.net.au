<?php

add_filter( 'genesis_attr_site-footer', 'wfc_add_site_footer_class' );
/**
* Adds extra class to site-footer element.
 * 
 * @param array $attributes Attributes of the site footer element.
 * 
 * @return array
 */
function wfc_add_site_footer_class( $attributes ) {

	$attributes['class'] .= ' container-fluid outer';

	return $attributes;
}

/**
*	Replace header with topbar section temporarily
*/
add_action( 'genesis_setup', function() {
	remove_action( 'genesis_header', 'genesis_do_header' );
});

add_action( 'genesis_before_header', 'wfc_render_topbar_section' ); 
/**
* Render Topbar section in header
*
* @since 1.0.0
*
*/
function wfc_render_topbar_section() {
	echo wfc_get_section( 'topbar' );
}

add_action( 'genesis_before_header', 'wfc_render_offcanvas_section', 8 ); 
/**
* Render offcanvas section
*
* @since 1.0.0
*
*/
function wfc_render_offcanvas_section() {
	echo wfc_get_section('offcanvas');
}

add_action( 'genesis_after_header', 'wfc_do_breadcrumbs' );
/**
 * Add breadcrumbs after header
 *
 * @author Rowelle Gem Daguman
 */
function wfc_do_breadcrumbs() {
	echo wfc_get_section( 'breadcrumbs' );
}

add_action( 'genesis_after_header', 'wfc_do_hero', 11 );
/**
 * Add the hero section after the breadcrumbs
 */
function wfc_do_hero() {
	
	$post_id = wfc_get_page_id();
	
	$hero_type = get_post_meta( $post_id, 'wfc_hero_type', true );
	
	if ( $hero_type == 'hero-w-cta' ) {
		echo wfc_get_section( 'hero-with-cta' );
	} else if ( $hero_type == 'hero-simple' ) {
		echo wfc_get_section( 'hero-simple' );
	} else {
		echo wfc_get_section( 'hero' );
	}
	
}

/**
 * Remove genesis_do_footer
 * 
 * @author Rowelle Gem Daguman
 */
add_action( 'genesis_footer', function() {
	remove_action( 'genesis_footer', 'genesis_do_footer' );
}, 5 );

add_action( 'genesis_footer', 'wfc_do_footer' );
/**
 * Renders the footer section.
 */
function wfc_do_footer() {
	echo wfc_get_section( 'footer' );
}

add_action( 'genesis_after_footer', 'wfc_do_copyright' );
/**
 * Add copyright after footer.
 * 
 * @author Rowelle Gem Daguman
 */
function wfc_do_copyright() {
	echo wfc_get_section( 'copyright' );
}


add_action( 'wp_footer', 'wfc_render_search_popup' );

/**
 * Function Name: wfc_render_search_popup() 
 * Author: Jimson Rudinas
 * Short Description: This function is for custom search popup
 *
 * @since 1.0.0
 */
function wfc_render_search_popup() {

	$search_string = isset( $_GET[ 's' ] ) ? $_GET[ 's' ] : '';

	?>
	<div class="search-popup">
		<div class="container">
			<span class="search-popup-close"><i class="fas fa-times"></i></span>
			<div class="search-popup-wrap">
				<form role="search" method="get" action="<?php echo home_url( '/' ); ?>">
					<div class="search-input-wrap mb-4">
						<input id="popup-search-input" class="h4 border4" type="text" name="s" placeholder="<?php _e( 'Search' ); ?>" value="<?php echo $search_string; ?>"/>
						<label for="popup-search-input"><i class="far fa-search"></i></label>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-secondary">Search</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'genesis_before_content', 'wfc_add_site_inner_row_opening_wrapper', 4 );
/**
 * Add opening wrapper right after the content-sidebar-wrap element.
 */
function wfc_add_site_inner_row_opening_wrapper() {
	echo '<div class="row">';
}

add_action( 'genesis_after_content', 'wfc_add_site_inner_row_closing_wrapper', 1000 );
/**
 * Add closing wrapper the added wrapper after content-sidebar-wrap element.
 */
function wfc_add_site_inner_row_closing_wrapper() {
	echo '</div>';
}

add_filter( 'genesis_attr_site-inner', 'wfc_add_site_inner_class', 99 );
/**
 * Adds extra class to entry element.
 * 
 * @param array $attributes Attributes of the entry element.
 * 
 * @return array
 */
function wfc_add_site_inner_class( $attributes ) {

	$attributes['class'] .= ' container-fluid outer';

	return $attributes;
}

add_filter( 'genesis_attr_content-sidebar-wrap', 'wfc_add_content_sidebar_wrap_class', 99 );
/**
 * Adds extra class to entry element.
 * 
 * @param array $attributes Attributes of the entry element.
 * 
 * @return array
 */
function wfc_add_content_sidebar_wrap_class( $attributes ) {

	$attributes['class'] .= ' wrapper inner';

	return $attributes;
}