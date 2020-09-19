<?php

/**
 * Filters the ID applied to a menu item’s list item element.
 *
 * @param  string  	$id      	The ID that is applied to the menu item's <li> element.
 * @param  WP_Post 	$item       The current menu item.
 * @param  stdClass $args 		An object of wp_nav_menu() arguments.
 *
 * @return string               The modified menu ID.
 */
add_filter( 'nav_menu_item_id', function( $id, $item, $args ) {

	return '';

}, 11, 3 );

/**
 * Filters the CSS classes applied to a menu item’s list item element.
 *
 * @param  Array  	$classes    Array of the CSS classes that are applied to the menu item's <li> element.
 * @param  WP_Post 	$item       The current menu item.
 * @param  stdClass $args 		An object of wp_nav_menu() arguments.
 *
 * @return string               The modified menu classes.
 */
add_filter( 'nav_menu_css_class', function( $classes, $item, $args ) {

	$menu_class = [];

	foreach ( $classes as $class ) {
		$menu_class[] = $class;

		if ( $class == 'menu-item' ) {
			if ( in_array('current-menu-item', $classes ) )
		        $menu_class[] = 'menu-item-active';
			break;
		}
	}

    return $menu_class;

}, 11, 3 );