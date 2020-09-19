<?php

defined('ABSPATH') or die('No script kiddie please!');

if (! class_exists('ASCM_Repost_ListHelper')) {
	/**
	 * Class ASCM_Repost_ListHelper
	 * Helper class with functionalities needed by the Renderer class
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @since  1.0.0
	 * @LastUpdated   March 18, 2019
	 */
	class ASCM_Repost_ListHelper {

		public function __construct() {

			/*clean and validation data ajax callback */	
			add_action( 
				'wp_ajax_fetch_renderPaginatedList', 
				array( $this, 'ascm_repost_fetch_renderPaginatedList') 
			);
			add_action( 
				'wp_ajax_nopriv_fetch_renderPaginatedList', 
				array( $this, 'ascm_repost_fetch_renderPaginatedList') 
			);
		}
		
		/**
		 * Checks if a custom template file exist.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $template_dir
		 * @param $template_file
		 *
		 * @return boolean
		 *
		 * @since  1.0.0
		 *
		 * @LastUpdated   March 18, 2019
		 */
		public static function is_custom_template_exist($template_dir, $template_file) {
			$customtempexist = false;

			$theme_dir = get_template_directory() . '/ascm-templates/' . $template_dir . '/';
			if( is_dir($theme_dir) === true ){
				$theme_dirItems = scandir( $theme_dir );
				foreach ( $theme_dirItems as $file ) {
				 	$theme_full_directory = get_template_directory() . '/ascm-templates/' . $template_dir . '/'. $template_file;
					if ($file != '.' && $file != '..' && is_file( $theme_full_directory ) && !is_dir( $theme_full_directory ) && $file == $template_file) {
						$customtempexist = true;
					}
				}
			}

			if ($customtempexist == false) {
				$theme_dir = get_stylesheet_directory() . '/ascm-templates/' . $template_dir . '/';
				if( is_dir($theme_dir) === true ){
					$theme_dirItems = scandir( $theme_dir );
					foreach ( $theme_dirItems as $file ) {
					 	$theme_full_directory = get_stylesheet_directory() . '/ascm-templates/' . $template_dir . '/'. $template_file;
						if ($file != '.' && $file != '..' && is_file( $theme_full_directory ) && !is_dir( $theme_full_directory ) && $file == $template_file) {
							$customtempexist = true;
						}
					}
				}
			}

			return $customtempexist;
		}
		
		/**
		 * Fetches the template file directory.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $template_dir
		 * @param $template_file
		 *
		 * @return bool|string
		 * @since  1.0.0
		 *
		 * @LastUpdated   March 18, 2019
		 */
		public static function get_template_file_dir($template_dir, $template_file) {
			$customtempexist = false;

			$theme_dir = get_template_directory() . '/ascm-templates/' . $template_dir . '/';
			if( is_dir($theme_dir) === true ){
				$theme_dirItems = scandir( $theme_dir );
				foreach ( $theme_dirItems as $file ) {
					$theme_full_directory = get_template_directory() . '/ascm-templates/' . $template_dir . '/'. $template_file;
					if ($file != '.' && $file != '..') {
						if (is_file( $theme_full_directory ) && !is_dir( $theme_full_directory ) && $file == $template_file) {
							$customtempexist = true;
							return $theme_full_directory;
						}
					}
				}
			}

			if ($customtempexist == false) {
				$theme_dir = get_stylesheet_directory() . '/ascm-templates/' . $template_dir . '/';
				if( is_dir($theme_dir) === true ){
					$theme_dirItems = scandir( $theme_dir );
					foreach ( $theme_dirItems as $file ) {
						$theme_full_directory = get_stylesheet_directory() . '/ascm-templates/' . $template_dir . '/'. $template_file;
						if ($file != '.' && $file != '..') {
							if (is_file( $theme_full_directory ) && !is_dir( $theme_full_directory ) && $file == $template_file) {
								$customtempexist = true;
								return $theme_full_directory;
							}
						}
					}
				}
			}

			return $customtempexist;
		}
		
		/**
		 * This function will render template file.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  string $template
		 * @param  array  $params
		 *
		 * @return false|string
		 *
		 * @LastUpdated   March 18, 2019
		 */
		public static function get_template( $template, $params = array() ) {
			ob_start();
			extract($params);
			require( $template );
			$var = ob_get_contents();
			ob_end_clean();
			return $var;
		}
		
		/**
		 * This function will fetch all the posts of Repost post type base on the query
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array  $args
		 *
		 * @return array
		 *
		 * @LastUpdated   March 21, 2019
		 */
		public static function get_repost_posts($args = array()) {
			$category = isset($args['category']) ? $args['category'] : null;
			$search = isset($args['search']) ? $args['search'] : null;
			$offset = isset($args['offset']) ? $args['offset'] : null;
			$post_per_page = isset($args['post_per_page']) ? $args['post_per_page'] : 10;


	 		/*
			* get selected custom post type to be cart product
			*/
			$cpt = 'ascm_repost';
			$cpt = filter_var( $cpt, FILTER_SANITIZE_STRING );

			/*
			* item order on page
			*/
			$Sortorder = 'DESC';
			$Sortorder = filter_var( $Sortorder, FILTER_SANITIZE_STRING );

			/*
			* item limit on page
			*/
			$post_per_page = (Int)$post_per_page;
			$ppp = filter_var( $post_per_page, FILTER_VALIDATE_INT );


			/*
			* pagination parameters
			*/
			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}

			if ($category == null || $category == 'all' || empty($category)) {
				$meta_query[] = array(
					'relation' => 'OR',
					array(
						'key' 		 => 'ascm_repost_category',
						'compare'    => '=',
						'value'      => '',
					),
					array(
						'key' 		 => 'ascm_repost_category',
						'compare'    => '=',
						'value'      => 'all',
					),
					array(
						'key' 		 => 'ascm_repost_category',
						'compare'    => '=',
						'value'      => 'blog',
					),
					array(
						'key' 		 => 'ascm_repost_category',
						'compare'    => '=',
						'value'      => 'news',
					),
					array(
						'key' => 'ascm_repost_category',
						'compare' => 'NOT EXISTS' // this should work...
				    ),
				);
			}else {
				$meta_query[] = array(
					'relation' => 'OR',
					array(
						'key' 		 => 'ascm_repost_category',
						'compare'    => '=',
						'value'      => $category,
					),
				);
			}


			// Calculate term offset
			// $offset = ( ( $paged - 1 ) * $ppp );
			

			if ($offset !== null) {
				$args = array(
					'posts_per_page' => $ppp,
					'post_status' => array('publish'),
					'paged' => $paged,
					'post_type' => $cpt,
					'orderby' => 'date',
					'order' => $Sortorder,
					'offset' => $offset,
					's' => isset( $search ) ? $search : '',
					'meta_query'    => $meta_query,
				);
			}else{
				$args = array(
					'posts_per_page' => $ppp, 
					'post_status' => array('publish'),
					'paged' => $paged,
					'post_type' => $cpt,               
					'orderby' => 'date',
					'order' => $Sortorder,
					's' => isset( $search ) ? $search : '',
					'meta_query'    => $meta_query,
				);
			}

			/*
			* querying/getting cart products
			*/
			$query = new WP_Query( $args );

			/*
			* get total number of cart products
			*/
			$post_count = $query->found_posts;

			/*
			* calculating total page
			*/
			$max_num_pages = ceil( $post_count / $ppp );
			// $max_num_pages = ceil( $post_count);

			return array(
				'query' => $query, // wp_query - total cart product
				'posts' => $query->posts, // array of posts result
				'max_num_pages' => $max_num_pages, // total pages
				'post_count' => $post_count, //total post count
			);	
		}
		
		/**
		 * Gets the post thumbnail url value by using the post id
		 * LastUpdated : March 21, 2019
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  integer $post_id
		 * @param  string  $size
		 *
		 * @return string
		 */
		public static function get_repost_thumbnail_url($post_id, $size = 'full') {
			$thumbnail_url = get_the_post_thumbnail_url($post_id, $size);
			if ($thumbnail_url != false) {
				return $thumbnail_url;
			}else {
				return plugin_dir_url( __FILE__ ).'../../images/fail-graceful.png';
			}
		}
		
		/**
		 * Get post meta value using post id and meta key
		 * LastUpdated : March 21, 2019
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $post_id
		 * @param $meta_key
		 *
		 * @return mixed
		 */
		public static function get_repost_post_meta($post_id, $meta_key) {
			return get_post_meta( $post_id, $meta_key, true );
		}



	}
	new ASCM_Repost_ListHelper();
}