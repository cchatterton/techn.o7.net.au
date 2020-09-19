<?php
/**
 * WFC Genesis.
 *
 * This file adds helper functions to the WFC Genesis Child Theme.
 *
 * @package WFC_Genesis/Core
 * @author  AlphaSys
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Converts colours from RGB to Hex and vice-versa
 * 
 * @param string|array $colour Colour as hex string or RGB array
 * @param string $as Optional. Defines the type of value returned. Accepted values are 'string' or 'array'.
 * @param boolean $wrap_rgb Optional. Wrap converted RGB colour with 'rgb()', else just return comma-separated values
 * 
 * @return string|array|boolean Returns converted version, false if failed to convert.
 */
function wfc_convert_colour( $colour, $as = 'string', $wrap_rgb = true ) {
	// do we have what we need for this function?
	if ( strpos( $colour, '#' ) === false || ( is_array( $colour ) && count( $colour ) != 3 ) ) {
		// return false;
	}
	if ( $as != 'string' && $as != 'array' ) {
		return false;
	}
	if ( strpos( $colour, ',' ) ) {
		$colour = preg_replace( array( '/^rgb\(/', '/\s/', '/\)$/' ), '', $colour );
		$colour = explode( ',', $colour );

		$hex = "#";
		$hex .= str_pad( dechex( $colour[0] ), 2, "0", STR_PAD_LEFT );
		$hex .= str_pad( dechex( $colour[1] ), 2, "0", STR_PAD_LEFT );
		$hex .= str_pad( dechex( $colour[2] ), 2, "0", STR_PAD_LEFT );

		return $hex; // returns the hex value including the number sign (#)
	}

	if ( strpos( $colour, '#' ) !== false ) {
		$hex = str_replace( "#", "", $colour );

		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = array(
			$r,
			$g,
			$b,
		);

		if ( $as == 'string' ) {
			if ( $wrap_rgb )
				return 'rgb(' . implode( ",", $rgb ) . ')'; // returns the rgb values wrapped with rgb()
			else
				return implode( ",", $rgb ); // returns the rgb values separated by commas
		}
		if ( $as == 'array' ) {
			return $rgb; // returns an array with the rgb values
		}
	} // end $from = hex

	return false;
}

/**
 * Convert a hex colour to a semi-transparent RGBA
 * 
 * @param string $hex
 * @param float $opacity
 * 
 * @return string
 */
function wfc_colour_opacity( $colour, $opacity ){

	$opacity = absint( $opacity );

	// Maximum opacity is 10
	if ( $opacity > 10 ) {
		$opacity = 10;
	}
	// Minimum opacity is 1
	else if ( $opacity < 1 ) {
		$opacity = 1;
	}

	// Convert Hex to RGBA and apply the opacity.
	if ( strpos( $colour, '#' ) !== false ) {
		return 'rgba(' . wfc_convert_colour( $colour, 'string', false ) . ', ' . $opacity . ')';
	}
	// Or convert RGB to RGBA and apply opacity.
	else if ( strpos( $colour, ',' ) ) {
		$rgb = preg_replace( array( '/^rgb\(/', '/\s/', '/\)$/' ), '', $colour );

		return 'rgba(' . $rgb . ', ' . $opacity . ')';
	}
	else {
		return false;
	}
}

/**
 * Darken a colour
 * 
 * @param string|array $colour Colour as hex string or RGB array
 * @param number $change Amount to change colour by. Default 30.
 * @param boolean $echo Whether to echo the result. Default true.
 * 
 * @return string|null RGB array or null, based on value of $echo
 */
function wfc_colour_darker( $colour, $change = 30, $echo = true ) {
	return wfc_colour_change( $colour, -( $change ), $echo );
}

/**
 * Lighten a colour
 * 
 * @param string|array $colour Colour as hex string or RGB array
 * @param number $change Amount to change colour by. Default 30.
 * @param boolean $echo Whether to echo the result. Default true.
 * 
 * @return string|null RGB array or null, based on value of $echo
 */
function wfc_colour_lighter( $colour, $change = 30, $echo = true ) {
	return wfc_colour_change( $colour, $change, $echo );
}

/**
 * Make a colour lighter or darker
 * 
 * @param string|array $colour Colour as hex string or RGB array
 * @param number $change Amount to change colour by. Positive values will produce a lighter colour; negative will produce a darker colour. Default 30.
 * @param boolean $echo Whether to echo the result. Default true.
 * 
 * @return string|false RGB array or null, based on value of $echo
 */
function wfc_colour_change( $colour, $change = 30, $echo = true ) {
	if ( strpos( $colour, '#' ) !== false ) {
		$colour = wfc_convert_colour( $colour, 'array', false );
	}
	else if ( strpos( $colour, ',' ) ) {
		$colour = preg_replace( array( '/^rgb\(/', '/\s/', '/\)$/' ), '', $colour );
		$colour = explode( ',', $colour );
	}
	else {
		return false;
	}
	for ( $i = 0; $i < 3; $i++ ) {
		$colour[$i] = $colour[$i] + $change;
		if ( $colour[$i] < 0 ) {
			$colour[$i] = 0;
		} elseif ( $colour[$i] > 255 ) {
			$colour[$i] = 255;
		}
	}
	$colour = 'rgb(' . implode( ',', $colour ) . ')';
	if ( $echo ) {
		echo $colour;
	} else {
		return $colour;
	}
}

/**
 * Whether to support transient in a particular environment.
 * 
 * Will not be supporting transient in development.
 *
 * @return bool
 */
function wfc_support_transient() {

	$support = true;

	if ( isset( $_GET[ 'disable_transient' ] ) && $_GET[ 'disable_transient' ] === 'true' ) {
		$support = false;
	}

	/**
	 * Filter `wfc_support_transient`.
	 * 
	 * Whether to support transient in a particular environment.
	 * 
	 * @param bool $support Whether to support transient.
	 */
	return apply_filters( 'wfc_support_transient', $support );
}

/**
 * Whether to refresh transients from the current page.
 * 
 * @return bool
 */
function wfc_is_transient_refresh() {

	$refresh = false;

	if ( wfc_support_transient() && isset( $_GET[ 'refresh' ] ) && $_GET[ 'refresh' ] === 'true' ) {
		$refresh = true;
	}

	/**
	 * Filter `wfc_is_transient_refresh`.
	 * 
	 * Whether to refresh transients from the current page.
	 * 
	 * @param bool $refresh Whether to refresh transients.
	 */
	return apply_filters( 'wfc_is_transient_refresh', $refresh );
}

/**
 * Retrieve transient duration. Default is DAY_IN_SECONDS.
 * 
 * @return int
 */
function wfc_get_transient_duration() {

	$duration = DAY_IN_SECONDS;

	if ( defined( 'WFC_TRANSIENT_DURATION' ) ) {
		$temp_duration = absint( WFC_TRANSIENT_DURATION );

		if ( $temp_duration ) {
			$duration = $temp_duration;
		}
	}

	return $duration;
}

/**
 * Retrieve post and store it in a transient with a key
 * concatenated with the post ID.
 *
 * @param int $id Post ID.
 *
 * @return WP_Post/null
 */
function wfc_get_post( $id ) {

	$id = absint( $id );
	$key = sprintf( 'wfc_post_%d', $id );
	$support_transient = wfc_support_transient();
	$post = false;

	/**
	 * Don't retrieve transient post if transient is not supported.
	 * And refresh the transient if `refresh=true` query string
	 * exists.
	 */
	if ( $support_transient && ! wfc_is_transient_refresh() ) {
		$post = unserialize( get_transient( $key ) );
	}

	if ( $post === false ) {
		$post = get_post( $id );

		if ( $support_transient && is_a( $post, 'WP_Post' ) ) {
			set_transient( $key, serialize( $post ), wfc_get_transient_duration() );
		}
	}

	if ( is_a( $post , 'WP_Post' ) ) {
		/**
		 * Hook `wfc_get_post`.
		 * 
		 * Post retrieved using `wfc_get_post`.
		 * 
		 * @param WP_Post $post Currently retrieved WP Post.
		 * @param int $id The ID of the post used to retrieve the actual post object.
		 */
		$post = apply_filters( 'wfc_get_post', $post, $id );

		/**
		 * Hook `wfc_get_post_{$id}`.
		 * 
		 * Post retrieved using `wfc_get_post`.
		 * 
		 * @param WP_Post $post Currently retrieved WP Post.
		 * @param int $id The ID of the post used to retrieve the actual post object.
		 */
		$post = apply_filters( sprintf( 'wfc_get_post_%d', $id ), $post, $id );
	}

	return $post;
}

/**
 * Retrieve post metadata and store it in a transient.
 *
 * @param int $id The post ID.
 *
 * @return array
 */
function wfc_get_post_meta( $id = 0 ) {

	$id = absint( $id );

	if ( ! $id ) {
		$id = get_the_ID();
	}

	$key = sprintf( 'wfc_post_meta_%d', $id );
	$support_transient = wfc_support_transient();
	$post_meta = false;

	/**
	 * Don't retrieve transient post meta if transient is not supported.
	 * And refresh the transient if `refresh=true` query string
	 * exists.
	 */
	if ( $support_transient && ! wfc_is_transient_refresh() ) {
		$post_meta = unserialize( get_transient( $key ) );
	}

	if ( $post_meta === false ) {
		$post_meta = get_post_meta( $id );

		if ( $support_transient && ! empty( $post_meta ) ) {
			set_transient( $key, serialize( $post_meta ), wfc_get_transient_duration() );
		}
	}

	if ( ! empty( $post_meta ) ) {
		/**
		 * Hook `wfc_get_post_meta`.
		 * 
		 * Post meta retrieved using `wfc_get_post_meta`.
		 * 
		 * @param WP_Post $post_meta Currently retrieved WP Post.
		 * @param int $id The ID of the post used to retrieve the actual post object.
		 */
		$post_meta = apply_filters( 'wfc_get_post_meta', $post_meta, $id );

		/**
		 * Hook `wfc_get_post_meta_{$id}`.
		 * 
		 * Post meta retrieved using `wfc_get_post_meta`.
		 * 
		 * @param WP_Post $post_meta Currently retrieved post meta.
		 * @param int $id The ID of the post used to retrieve the post meta.
		 */
		$post_meta = apply_filters( sprintf( 'wfc_get_post_meta_%d', $id ), $post_meta, $id );
	}

	return $post_meta;
}

/**
 * Returns the cards directory.
 *
 * @return string
 */
function wfc_get_cards_dir() {

	$dir = get_stylesheet_directory() . '/template-parts/cards';

	if ( defined( 'WFC_CARDS_DIR' ) && is_dir( WFC_CARDS_DIR ) ) {
		$dir = WFC_CARDS_DIR;
	}

	/**
	 * Hook `wfc_cards_dir`.
	 * 
	 * The directory of cards.
	 * 
	 * @param string $dir The directory of cards.
	 */
	$dir = apply_filters( 'wfc_cards_dir', $dir );

	return untrailingslashit( $dir );
}

/**
 * Retrieve card template using post ID.
 *
 * @param int $id Post ID.
 * @param string $template Template file name (file extension excluded)
 * @param array $args Extra arguments to be passed to the card template.
 *
 * @return string
 */
function wfc_get_card( $template, $id = 0, $args = array() ) {

	$id = absint( $id );

	if ( ! $id ) {
		$id = get_the_ID();
	}

	if ( get_post_status( $id ) !== 'publish' ) {
		return '';
	}

	if ( ! is_string( $template ) ) {
		return '';
	}

	$support_transient = wfc_support_transient();
	$transient_key = sprintf( 'wfc_card_%s_%d', str_replace( '-', '_', $template ), $id );
	$card = false;

	/**
	 * Don't retrieve transient card if transient is not supported.
	 * And refresh the transient if `refresh=true` query string
	 * exists.
	 */
	if ( $support_transient && ! wfc_is_transient_refresh() ) {
		$card = get_transient( $transient_key );
	}

	if ( $card === false ) {
		$magic_card = function_exists( '_ascm_get_magic_card' ) ? _ascm_get_magic_card( $template, $id ) : false;

		if ( $magic_card !== false ) {
			ob_start();

			echo $magic_card;

			$card = ob_get_clean();
		} else {
			$card_file = sprintf( '%s/%s.php', wfc_get_cards_dir(), $template );
			$wfc_source_post = wfc_get_post( $id );
			$wfc_source_post_meta = wfc_get_post_meta( $id );

			is_array( $args ) ? extract( $args ) : parse_str( $args );

			$default_classes = array( 'card', 'card-' . $template );
			$classes = isset( $classes ) && is_array( $classes ) ? array_merge( $default_classes, $classes ) : $default_classes;

			ob_start();
			?>
			<div id="<?php echo esc_attr( 'card-' . $id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<?php
					if ( file_exists( $card_file ) ) {
						include $card_file;
					} else {
						echo esc_html__( 'No card template found at ' . $card_file, 'wfc-genesis' );
					}
				?>
			</div>
			<?php
			$card = ob_get_clean();
		}

		if ( $support_transient ) {
			set_transient( $transient_key, $card, wfc_get_transient_duration() );
		}
	}

	return $card;
}

/**
 * Deletes all WFC transient attach to a post($post_id).
 * 
 * @param int $post_id The post ID
 * 
 * @return bool
 */
function wfc_delete_post_transients( $post_id ) {

	$post_id = absint( $post_id );

	if ( get_post_status( $post_id ) ) {

		global $wpdb;

		$transient_key = $wpdb->esc_like( '_transient_wfc_' ) . '%' . $wpdb->esc_like( '_' . $post_id );
		$transient_exp_key = $wpdb->esc_like( '_transient_timeout_wfc_' ) . '%' . $wpdb->esc_like( '_' . $post_id );

		$result = $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s", $transient_key, $transient_exp_key ) );

		if ( $result !== false ) {
			return true;
		}
	}

	return false;
}

/**
 * Deletes all WFC image transient attach to a post($post_id).
 * 
 * @param int $post_id The post ID
 * 
 * @return bool
 */
function wfc_delete_post_image_transients( $post_id ) {

	$post_id = absint( $post_id );

	if ( get_post_status( $post_id ) ) {

		global $wpdb;

		$transient_key = $wpdb->esc_like( '_transient_wfc_image_' ) . '%' . $wpdb->esc_like( '_' . $post_id );
		$transient_exp_key = $wpdb->esc_like( '_transient_timeout_wfc_image_' ) . '%' . $wpdb->esc_like( '_' . $post_id );

		$result = $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s", $transient_key, $transient_exp_key ) );

		if ( $result !== false ) {
			return true;
		}
	}

	return false;
}

/**
 * Retrieve hero or featured image by post ID, type and size.
 * 
 * Returns false if post ID is not valid or the classes required
 * doesn't exists or settings for either fail gracefull or hero images
 * is turned off.
 * 
 * @param int $id Post ID.
 * @param string $type Whether the image is hero or featured.
 * @param string $size Size of the image to retrieve.
 * 
 * @return string|bool
 */
function wfc_get_image( $id, $type = 'featured', $size = 'large' ) {

	$id = absint( $id );

	// Check post ID validity.
	if ( ! $id || get_post_status( $id ) === false ) {
		return false;
	}

	$support_transient = wfc_support_transient();
	$transient_key = sprintf( 'wfc_image_%s_%s_%d', $type, $size, $id );
	$image = false;

	/**
	 * Don't retrieve transient post meta if transient is not supported.
	 * And refresh the transient if `refresh=true` query string
	 * exists.
	 */
	if ( $support_transient && ! wfc_is_transient_refresh() ) {
		$image = get_transient( $transient_key );
	}

	/* Retrieve the actual image manually if transient
	 * doesn't exists yet or transient support is turned off.
	 */
	if ( $image === false ) {
		$temp_image = false;

		// Get post image using fail graceful.
		if ( $type == 'featured' && class_exists( 'WFC_Fail_Graceful', 'get_img_url' ) ) {
			$temp_image = WFC_Fail_Graceful::get_img_url( $id, $size );
		}
		// Get hero image.
		elseif ( $type == 'hero' && class_exists( 'WFC_Hero_Images', 'get_img_url' ) ) {
			$temp_image = WFC_Hero_Images::get_img_url( $id, $size );
		}

		// Store the image URL to transient if not empty.
		if ( ! empty( $temp_image ) && $support_transient ) {
			set_transient( $transient_key, $temp_image, wfc_get_transient_duration() );
		}

		$image = $temp_image;
	}

	return $image;
}

/**
 * Retrieves the url of the logo by type
 * 
 * @param string $logo_type Whether the image is light, coloured, or dark.
 *
 * @return string|bool
 */
function wfc_get_logo( $logo_type = 'light' ) {
	
	switch ( $logo_type ) {
		case 'light':
		case 'logo_light':
			$logo = get_theme_mod('logo_light');
			break;
		case 'coloured':
		case 'logo_coloured':
			$logo = get_theme_mod('logo_coloured');
			break; 
		case 'dark';
		case 'logo_dark':
			$logo = get_theme_mod('logo_dark');
			break;
		default:
			$logo = false;
			break;
	}
	
	return $logo;
	
} 

/**
 * Retrieves the url of main logo
 * 
 * @return string|bool
 */
function wfc_get_main_logo() {
	
	$logo = false;
	$main_logo = get_theme_mod('main_logo');
	
	if ( $main_logo ) 
		$logo = wfc_get_logo($main_logo);
	
	return $logo;
	
}