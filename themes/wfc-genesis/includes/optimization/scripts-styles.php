<?php
/*
 * This file contains all the Scripts and Styles optimization
 */

add_action( 'init', function() {

	if ( is_admin() || 'wp-login.php' == $GLOBALS['pagenow'] ) 
		return;

	global $wp_scripts;

	if ( isset( $wp_scripts->registered['jquery']->ver ) ) 
		$ver = str_replace( '-wp', '', $wp_scripts->registered['jquery']->ver );
	else 
		$ver = '1.12.4';

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', "//cdnjs.cloudflare.com/ajax/libs/jquery/$ver/jquery.min.js", false, $ver );

});

function remove_scripts_and_styles_version( $src ) {

	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );

	return $src;

}
add_filter( 'style_loader_src', 'remove_scripts_and_styles_version', 999 );
add_filter( 'script_loader_src', 'remove_scripts_and_styles_version', 999 );

add_filter( 'style_loader_tag', function( $html, $handle, $href, $media ) {

	$html = str_replace( " id='$handle-css' ", '', $html );
	$html = str_replace( " media='$media' ", '', $html );

	return $html;

}, 999, 4 );