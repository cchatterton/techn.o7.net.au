<?php
/**
 * @package WFC_Toolkit\WFC_Fail_Graceful
 * @author AlphaSys
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if access directly.
}

if ( ! class_exists( 'WFC_Fail_Graceful' ) ) {

	class WFC_Fail_Graceful {

		/**
		 * Gets the image url.
		 *
		 * @param      int  	$post_id  	The post identifier
		 * @param      string  	$size     	The size
		 *
		 * @return     string  				The image url.
		 */
		public static function get_img_url( $post_id, $size = 'large' ) {

			// Get featured image from the post
			$img_url = get_the_post_thumbnail_url( $post_id, $size );

			// Get the featured image from the parent if there is no featured image from the post
			if ( empty( $img_url ) ) {
				$post_parent_id = wp_get_post_parent_id( $post_id );

				if ( $post_parent_id != 0 && $post_parent_id != false ) {
					$img_url = get_the_post_thumbnail_url( $post_parent_id, $size );
				}
			}

			// Get the featured image from using get_page_by_path($post->post_type) if there is no image set on the parent post
			if ( empty( $img_url ) ) {

				global $wp_query;

				if ( is_archive() ) {
					global $post_type;
					
					$archive_page = get_page_by_path( $post_type );

					if ( ! empty( $archive_page ) ) {
						$wfc_img_url = get_the_post_thumbnail_url( $archive_page->ID, $size );
					}
				} elseif ( is_search() ) {
					$post_type = 'search';
					$search_page = get_page_by_path( $post_type );

					if ( ! empty( $search_page ) ) {
						$img_url = get_the_post_thumbnail_url( $search_page->ID, $size );
					}
				} else {
					$post_type = get_post_type( $post_id );
					$same_page = get_page_by_path( $post_type );

					if ( ! empty( $same_page ) ) {
						$img_url = get_the_post_thumbnail_url( $same_page->ID, $size );
					}
				}
			}

			// Get the featured image from the frontpage if there is no image set from using get_page_by_path($post->post_type)
			if ( empty( $img_url ) ) {

				$frontpage_id = get_option( 'page_on_front' );

				if ( ! empty( $frontpage_id ) ) {
					$img_url = get_the_post_thumbnail_url( $frontpage_id, $size );
				}
			}

			//Get the image from the customizer
			if ( empty( $img_url ) ) {
				$img_url = get_theme_mod( 'default_image' );
			}

			//Get the default image
			if ( empty( $img_url ) ) {
				$img_url = WFCT_IMG_URL . 'fail-graceful-large.png';
			}

			return $img_url;
		}
	}
}

new WFC_Fail_Graceful();