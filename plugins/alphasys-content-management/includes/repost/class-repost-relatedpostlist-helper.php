<?php

defined('ABSPATH') or die('No script kiddie please!');

if (! class_exists('ASCM_Repost_RelatedPostListHelper')) {
	/**
	* Class ASCM_Repost_RelatedPostListHelper
	 *
	* Helper class with functionalities needed by other classes.
	*
	* @author Junjie Canonio <junjie@alphasys.com.au>
	* @since  1.0.0
	*
	* @LastUpdated   April 2, 2019
	*/
	class ASCM_Repost_RelatedPostListHelper {

		public function __construct() {

		}
		
		/**
		 * Checks if the custom template file exist.
		 *
		 * LastUpdated : April 2, 2019
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $template_dir
		 * @param $template_file
		 *
		 * @return bool
		 * @since  1.0.0
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
		 * @LastUpdated   April 2, 2019
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
		 * This function will render template file
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param         $template
		 * @param  array  $params
		 *
		 * @return false|string
		 *
		 * @LastUpdated   April 2, 2019
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
		 * This function will fetch all the posts base on array of ids.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array  $ids
		 *
		 * @return array
		 *
		 * @LastUpdated   April 3, 2019
		 */
		public static function get_posts_by_id($ids = array()) {

			if (empty($ids)) {
				return array(
					'posts' => array(),
					'post_count' => 0, //total post count
				);	
			}

			/*
			* get selected custom post type to be cart product
			*/
			$cpt = array('post', 'ascm_repost');

			/*
			* item order on page
			*/
			$Sortorder = 'DESC';
			$Sortorder = filter_var( $Sortorder, FILTER_SANITIZE_STRING );

			$args = array(
				'posts_per_page' => 10, 
				'post_status' => array('publish'),
				'post_type' => $cpt,               
				'orderby' => 'date',
				'order' => $Sortorder,
				'post__in' => $ids
			);

			/*
			* querying/getting cart products
			*/
			$query = new WP_Query( $args );

			/*
			* get total number of cart products
			*/
			$post_count = $query->found_posts;

			return array(
				'posts' => $query->posts, // array of posts result
				'post_count' => $post_count, //total post count
			);	
		}
		
		/**
		 * Get post meta value using the post id and meta key.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param          $post_id
		 * @param          $configs
		 * @param  string  $size
		 *
		 * @return string
		 *
		 * @LastUpdated   April 3, 2019
		 */
		public static function get_featuredimgurl($post_id, $configs, $size = 'full') {
			$fallback_img = isset($configs['fallback_img']) ? $configs['fallback_img'] : '';
			$thumbnail_url = get_the_post_thumbnail_url($post_id, $size);
			if ($thumbnail_url != false) {
				return $thumbnail_url;
			}else {
				if (!empty($fallback_img)) {
					return $fallback_img;
				}else {
					return 'https://via.placeholder.com/600x400';
				}
			}
		}
		
		/**
		 * Fetch post meta value using post id and meta key
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $post_id
		 * @param $meta_key
		 *
		 * @return mixed
		 *
		 * @LastUpdated   April 3, 2019
		 */
		public static function get_postmeta($post_id, $meta_key) {
			return get_post_meta( $post_id, $meta_key, true );
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
		 * @LastUpdated   April 2, 2019
		 */
		public static function get_posts($args = array()) {
			$category = isset($args['category']) ? $args['category'] : 'news';
			$search = isset($args['search']) ? $args['search'] : null;
			$offset = isset($args['offset']) ? $args['offset'] : null;
			$post_per_page = isset($args['post_per_page']) ? $args['post_per_page'] : 10;


	 		/*
			* get selected custom post type to be cart product
			*/
			$cpt = array('post', 'ascm_repost');

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
				);
			}


			if (!empty($category)) {
				$args['tax_query'] = array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => array($category),
					),
				);
			}else {
				$tax_query[] = array();
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
				//'query' => $query, // wp_query - total cart product
				'posts' => $query->posts, // array of posts result
				//'max_num_pages' => $max_num_pages, // total pages
				//'post_count' => $post_count, //total post count
			);	
		}	
	}
	new ASCM_Repost_RelatedPostListHelper();
}