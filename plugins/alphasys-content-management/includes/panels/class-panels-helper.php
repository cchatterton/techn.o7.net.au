<?php

defined('ABSPATH') or die('No script kiddie please!');

if (! class_exists('ASCM_Panels_Helper')) {
	/**
	* Class ASCM_Panels_Helper
	* Helper class with functionalities needed by the Renderer class get all available pages.
	*
	* @author Junjie Canonio <junjie@alphasys.com.au>
	* @since  1.0.0
	* @LastUpdated   April 5, 2019
	*/
	class ASCM_Panels_Helper {
		
		/**
		 * ASCM_Panels_Helper constructor.
		 */
		public function __construct() {

		}
		
		/**
		 * Get All ASCM Panels cards template from plugin, current theme or current child theme
		 *
		 * @author        Junjie Canonio <junjie@alphasys.com.au>
		 * @return array
		 * @LastUpdated   April 5, 2019
		 * @since         1.0.0
		 */
		public static function get_templates() {
			/*
			 * Fetch recipes on ASCM plugin
			*/
			$dir = plugin_dir_path( __FILE__ ) . '../../public/templates/panels/recipes/';
			$dirItems = scandir( $dir );
			$templates = array();
			foreach ( $dirItems as $file ) {
				if( !is_file( $file ) && !is_dir( $file ) ) {
					$title_data = get_file_data( $dir . $file, array( 'Title' ) );
					$type_data = get_file_data( $dir . $file, array( 'Type' ) );
					$settings_data = get_file_data( $dir . $file, array( 'Settings' ) );

					$temp_title = isset($title_data[0]) ? $title_data[0] : '';
					$temp_type = isset($type_data[0]) ? $type_data[0] : '';
					$temp_settings = isset($settings_data[0]) ? $settings_data[0] : '';

					$temp_path = $dir . $file;

					$templates[$temp_path] = array(
						'title' => $temp_title,
						'type' => $temp_type,
						'settings' => $temp_settings,
					);
				}
			}
				
			/*
			 * Fetch recipes on addon plugin
			 */
			$plugin_list = get_plugins();
			$plugins_as_addon = array();
			foreach ($plugin_list as $plugin_list_key => $plugin_list_value) {
				$plugins_as_addon_val = explode("/", $plugin_list_key);
				$plugins_as_addon_val = isset($plugins_as_addon_val[0]) ? $plugins_as_addon_val[0] : $plugin_list_key;
				$plugins_as_addon[$plugins_as_addon_val] = isset($plugin_list_value['Name']) ? $plugin_list_value['Name'] : 'None';
			}
			foreach ($plugins_as_addon as $plugins_as_addon_key => $value) {
				$addon_dir = ABSPATH . 'wp-content/plugins/'.$plugins_as_addon_key.'/ascm-templates/panels/recipes/';
				if( is_dir($addon_dir) === true ){
					$addon_dirItems = scandir( $addon_dir );
					foreach ( $addon_dirItems as $file ) {
						if( $file != '.' && $file != '..'){
							if( !is_file( $file ) && !is_dir( $file ) ) {
								$title_data = get_file_data( $addon_dir . $file, array( 'Title' ) );
								$type_data = get_file_data( $addon_dir . $file, array( 'Type' ) );
								$settings_data = get_file_data( $addon_dir . $file, array( 'Settings' ) );

								$temp_title = isset($title_data[0]) ? $title_data[0] : '';
								$temp_type = isset($type_data[0]) ? $type_data[0] : '';
								$temp_settings = isset($settings_data[0]) ? $settings_data[0] : '';

								$temp_path = $addon_dir . $file;

								$templates[$temp_path] = array(
									'title' => $temp_title,
									'type' => $temp_type,
									'settings' => $temp_settings,
								);
							}
						}
					}
				}
			}

			/*
			 * Fetch recipes on theme
			 */
			$theme_dir = get_template_directory() . '/custom/ascm-templates/panels/recipes/';
			if( is_dir($theme_dir) === true ){
				$theme_dirItems = scandir( $theme_dir );
				foreach ( $theme_dirItems as $file ) {
					if( $file != '.' && $file != '..'){
						if( !is_file( $file ) && !is_dir( $file ) ) {
							$title_data = get_file_data( $theme_dir . $file, array( 'Title' ) );
							$type_data = get_file_data( $theme_dir . $file, array( 'Type' ) );
							$settings_data = get_file_data( $theme_dir . $file, array( 'Settings' ) );

							$temp_title = isset($title_data[0]) ? $title_data[0] : '';
							$temp_type = isset($type_data[0]) ? $type_data[0] : '';
							$temp_settings = isset($settings_data[0]) ? $settings_data[0] : '';

							$temp_path = $theme_dir . $file;

							$templates[$temp_path] = array(
								'title' => $temp_title,
								'type' => $temp_type,
								'settings' => $temp_settings,
							);
						}
					}
				}
			}

			/*
			 * Fetch recipes on child theme
			 */
			$childtheme_dir = get_stylesheet_directory() . '/custom/ascm-templates/panels/recipes/';
			if( is_dir($childtheme_dir) === true ){
				$childtheme_dirItems = scandir( $childtheme_dir );
				foreach ( $childtheme_dirItems as $file ) {
					if( $file != '.' && $file != '..'){
						if( !is_file( $file ) && !is_dir( $file ) ) {
							$title_data = get_file_data( $childtheme_dir . $file, array( 'Title' ) );
							$type_data = get_file_data( $childtheme_dir . $file, array( 'Type' ) );
							$settings_data = get_file_data( $childtheme_dir . $file, array( 'Settings' ) );

							$temp_title = isset($title_data[0]) ? $title_data[0] : '';
							$temp_type = isset($type_data[0]) ? $type_data[0] : '';
							$temp_settings = isset($settings_data[0]) ? $settings_data[0] : '';

							$temp_path = $childtheme_dir . $file;

							$templates[$temp_path] = array(
								'title' => $temp_title,
								'type' => $temp_type,
								'settings' => $temp_settings,
							);
						}
					}
				}
			}
			
			return $templates;
		}
		
		/**
		 * This function will render template file.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 *
		 * @param         $template
		 * @param  array  $params
		 *
		 * @return false|string
		 *
		 * @LastUpdated   April 9, 2019
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
		 * This function will fetch all the data of the panel.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $post_id
		 *
		 * @return array
		 *
		 * @LastUpdated   April 9, 2019
		 */
		public static function get_panel_data( $post_id ) {
			$panel_post = get_post( $post_id );
			$post_meta = get_post_meta($post_id);

			// Main Option
			$ascm_panels_panelascontent = isset($post_meta['ascm-panels-panelascontent'][0]) ? $post_meta['ascm-panels-panelascontent'][0] : '';

			// Settings
			$ascm_panels_hidetitle = isset($post_meta['ascm-panels-hidetitle'][0]) ? $post_meta['ascm-panels-hidetitle'][0] : 'off';
			$ascm_panels_parentpanel = isset($panel_post->post_parent) ? $panel_post->post_parent : '';
			$ascm_panels_menuorder = isset($panel_post->menu_order) ? $panel_post->menu_order : '0';
			$ascm_panels_displayclildrenas = isset($post_meta['ascm-panels-displayclildrenas'][0]) ? $post_meta['ascm-panels-displayclildrenas'][0] : '';
			$ascm_panels_displayclildrenas = !empty($ascm_panels_displayclildrenas) ? $ascm_panels_displayclildrenas : 'donothing';
			$ascm_panels_displaytype = isset($post_meta['ascm-panels-displaytype'][0]) ? $post_meta['ascm-panels-displaytype'][0] : '';
			$ascm_panels_displaytype = !empty($ascm_panels_displaytype) ? $ascm_panels_displaytype : 'fullwdth';

			// Recipe
			$ascm_panels_recipe = isset($post_meta['ascm-panels-recipe'][0]) ? $post_meta['ascm-panels-recipe'][0] : '';
			$ascm_panels_recipe_type = isset($post_meta['ascm-panels-recipe-type'][0]) ? $post_meta['ascm-panels-recipe-type'][0] : '';

			// Half Image Recipe
			$ascm_panels_halfimage_image = isset($post_meta['ascm-panels-halfimage-image'][0]) ? $post_meta['ascm-panels-halfimage-image'][0] : '';
			$ascm_panels_halfimage_imageposition = isset($post_meta['ascm-panels-halfimage-imageposition'][0]) ? $post_meta['ascm-panels-halfimage-imageposition'][0] : 'left';
			$ascm_panels_halfimage_imageposition = !empty($ascm_panels_halfimage_imageposition) ? $ascm_panels_halfimage_imageposition : 'left';
			$ascm_panels_halfimage_containedimage = isset($post_meta['ascm-panels-halfimage-containedimage'][0]) ? $post_meta['ascm-panels-halfimage-containedimage'][0] : '';

			// Post Gallery Recipe
			$ascm_panels_postgallery_posttype = isset($post_meta['ascm-panels-postgallery-posttype'][0]) ? $post_meta['ascm-panels-postgallery-posttype'][0] : '';
			$ascm_panels_postgallery_maxnumofitems = isset($post_meta['ascm-panels-postgallery-maxnumofitems'][0]) ? $post_meta['ascm-panels-postgallery-maxnumofitems'][0] : '9';
			$ascm_panels_postgallery_maxnumofitems = !empty($ascm_panels_postgallery_maxnumofitems) ? $ascm_panels_postgallery_maxnumofitems : '9';
			$ascm_panels_postgallery_orderby = isset($post_meta['ascm-panels-postgallery-orderby'][0]) ? $post_meta['ascm-panels-postgallery-orderby'][0] : 'post_title';
			$ascm_panels_postgallery_sortorder = isset($post_meta['ascm-panels-postgallery-sortorder'][0]) ? $post_meta['ascm-panels-postgallery-sortorder'][0] : 'DESC';
			$ascm_panels_postgallery_itemsperrowlrg = isset($post_meta['ascm-panels-postgallery-itemsperrowlrg'][0]) ? $post_meta['ascm-panels-postgallery-itemsperrowlrg'][0] : 'fourperrow';
			$ascm_panels_postgallery_itemsperrowlrg = !empty($ascm_panels_postgallery_itemsperrowlrg) ? $ascm_panels_postgallery_itemsperrowlrg : 'fourperrow';
			$ascm_panels_postgallery_itemsperrowmed = isset($post_meta['ascm-panels-postgallery-itemsperrowmed'][0]) ? $post_meta['ascm-panels-postgallery-itemsperrowmed'][0] : 'twoperrow';
			$ascm_panels_postgallery_itemsperrowmed = !empty($ascm_panels_postgallery_itemsperrowmed) ? $ascm_panels_postgallery_itemsperrowmed : 'twoperrow';

			// Recent Posts Recipe
			$ascm_panels_recentposts_category = isset($post_meta['ascm-panels-recentposts-category'][0]) ? $post_meta['ascm-panels-recentposts-category'][0] : '';
			$ascm_panels_recentposts_maxnumofitems = isset($post_meta['ascm-panels-recentposts-maxnumofitems'][0]) ? $post_meta['ascm-panels-recentposts-maxnumofitems'][0] : '9';
			$ascm_panels_recentposts_maxnumofitems = !empty($ascm_panels_recentposts_maxnumofitems) ? $ascm_panels_recentposts_maxnumofitems : '9';
			$ascm_panels_recentposts_itemsperrowlrg = isset($post_meta['ascm-panels-recentposts-itemsperrowlrg'][0]) ? $post_meta['ascm-panels-recentposts-itemsperrowlrg'][0] : 'fourperrow';
			$ascm_panels_recentposts_itemsperrowlrg = !empty($ascm_panels_recentposts_itemsperrowlrg) ? $ascm_panels_recentposts_itemsperrowlrg : 'fourperrow';
			$ascm_panels_recentposts_itemsperrowmed = isset($post_meta['ascm-panels-recentposts-itemsperrowmed'][0]) ? $post_meta['ascm-panels-recentposts-itemsperrowmed'][0] : 'twoperrow';
			$ascm_panels_recentposts_itemsperrowmed = !empty($ascm_panels_recentposts_itemsperrowmed) ? $ascm_panels_recentposts_itemsperrowmed : 'twoperrow';

			// Tile Menu Recipe
			$ascm_panels_tilemenu_navmenu = isset($post_meta['ascm-panels-tilemenu-navmenu'][0]) ? $post_meta['ascm-panels-tilemenu-navmenu'][0] : '';
			$ascm_panels_tilemenu_itemsperrowlrg = isset($post_meta['ascm-panels-tilemenu-itemsperrowlrg'][0]) ? $post_meta['ascm-panels-tilemenu-itemsperrowlrg'][0] : 'fourperrow';
			$ascm_panels_tilemenu_itemsperrowlrg = !empty($ascm_panels_tilemenu_itemsperrowlrg) ? $ascm_panels_tilemenu_itemsperrowlrg : 'fourperrow';
			$ascm_panels_tilemenu_itemsperrowmed = isset($post_meta['ascm-panels-tilemenu-itemsperrowmed'][0]) ? $post_meta['ascm-panels-tilemenu-itemsperrowmed'][0] : 'twoperrow';
			$ascm_panels_tilemenu_itemsperrowmed = !empty($ascm_panels_tilemenu_itemsperrowmed) ? $ascm_panels_tilemenu_itemsperrowmed : 'twoperrow';

			// Video Recipe
			$ascm_panels_video_videoembedcode = isset($post_meta['ascm-panels-video-videoembedcode'][0]) ? $post_meta['ascm-panels-video-videoembedcode'][0] : '';

			// With Image Recipe
			$ascm_panels_withimage_image = isset($post_meta['ascm-panels-withimage-image'][0]) ? $post_meta['ascm-panels-withimage-image'][0] : '';
			$ascm_panels_withimage_imageposition = isset($post_meta['ascm-panels-withimage-imageposition'][0]) ? $post_meta['ascm-panels-withimage-imageposition'][0] : 'left';
			$ascm_panels_withimage_imageposition = !empty($ascm_panels_withimage_imageposition) ? $ascm_panels_withimage_imageposition : 'left';
			$ascm_panels_withimage_wrapimagewithcont = isset($post_meta['ascm-panels-withimage-wrapimagewithcont'][0]) ? $post_meta['ascm-panels-withimage-wrapimagewithcont'][0] : '';


			// Call to Action
			$ascm_panels_cta_url = isset($post_meta['ascm-panels-cta-url'][0]) ? $post_meta['ascm-panels-cta-url'][0] : '';
			$ascm_panels_cta_wrapppanel = isset($post_meta['ascm-panels-cta-wrapppanel'][0]) ? $post_meta['ascm-panels-cta-wrapppanel'][0] : '';
			$ascm_panels_cta_btntext = isset($post_meta['ascm-panels-cta-btntext'][0]) ? $post_meta['ascm-panels-cta-btntext'][0] : '';

			// Background
			$ascm_panels_bg_img_opcty = isset($post_meta['ascm-panels-bg-img-opcty'][0]) ? $post_meta['ascm-panels-bg-img-opcty'][0] : '1';
			$ascm_panels_bg_img_opcty = !empty($ascm_panels_bg_img_opcty) ? $ascm_panels_bg_img_opcty : '1';
			$ascm_panels_bg_img_anchor_hor = isset($post_meta['ascm-panels-bg-img-anchor-hor'][0]) ? $post_meta['ascm-panels-bg-img-anchor-hor'][0] : 'center';
			$ascm_panels_bg_img_anchor_hor = !empty($ascm_panels_bg_img_anchor_hor) ? $ascm_panels_bg_img_anchor_hor : 'center';
			$ascm_panels_bg_img_anchor_ver = isset($post_meta['ascm-panels-bg-img-anchor-ver'][0]) ? $post_meta['ascm-panels-bg-img-anchor-ver'][0] : 'center';
			$ascm_panels_bg_img_anchor_ver = !empty($ascm_panels_bg_img_anchor_ver) ? $ascm_panels_bg_img_anchor_ver : 'center';
			$ascm_panels_bg_clr = isset($post_meta['ascm-panels-bg-clr'][0]) ? $post_meta['ascm-panels-bg-clr'][0] : 'transparent';
			$ascm_panels_bg_clr = !empty($ascm_panels_bg_clr) ? $ascm_panels_bg_clr : 'transparent';

			// Custom CSS
			$ascm_panels_outerwrapclass = isset($post_meta['ascm-panels-outerwrapclass'][0]) ? $post_meta['ascm-panels-outerwrapclass'][0] : '';
			$ascm_panels_innerwrapclass = isset($post_meta['ascm-panels-innerwrapclass'][0]) ? $post_meta['ascm-panels-innerwrapclass'][0] : '';
			$ascm_panels_csscode = isset($post_meta['ascm-panels-csscode'][0]) ? $post_meta['ascm-panels-csscode'][0] : '';

			$standard = array(
				'panelascontent' =>  filter_var( $ascm_panels_panelascontent, FILTER_SANITIZE_STRING),

				'hidetitle' =>  filter_var( $ascm_panels_hidetitle, FILTER_SANITIZE_STRING),
				'parentpanel' =>  (int)filter_var( $ascm_panels_parentpanel, FILTER_SANITIZE_NUMBER_INT),
				'menuorder' =>  (int)filter_var( $ascm_panels_menuorder, FILTER_SANITIZE_NUMBER_INT),
				'displayclildrenas' =>  filter_var( $ascm_panels_displayclildrenas, FILTER_SANITIZE_STRING),
				'displaytype' =>  filter_var( $ascm_panels_displaytype, FILTER_SANITIZE_STRING),

				'recipe' =>  filter_var( $ascm_panels_recipe, FILTER_SANITIZE_STRING),
				'recipe_type' =>  filter_var( $ascm_panels_recipe_type, FILTER_SANITIZE_STRING),

				'halfimage_image' =>  filter_var( $ascm_panels_halfimage_image, FILTER_SANITIZE_STRING),
				'halfimage_imageposition' =>  filter_var( $ascm_panels_halfimage_imageposition, FILTER_SANITIZE_STRING),
				'halfimage_containedimage' =>  filter_var( $ascm_panels_halfimage_containedimage, FILTER_SANITIZE_STRING),

				'postgallery_posttype' =>  filter_var( $ascm_panels_postgallery_posttype, FILTER_SANITIZE_STRING),
				'postgallery_maxnumofitems' =>  filter_var( $ascm_panels_postgallery_maxnumofitems, FILTER_SANITIZE_STRING),
				'postgallery_orderby' =>  filter_var( $ascm_panels_postgallery_orderby, FILTER_SANITIZE_STRING),
				'postgallery_sortorder' =>  filter_var( $ascm_panels_postgallery_sortorder, FILTER_SANITIZE_STRING),
				'postgallery_itemsperrowlrg' =>  filter_var( $ascm_panels_postgallery_itemsperrowlrg, FILTER_SANITIZE_STRING),
				'postgallery_itemsperrowmed' =>  filter_var( $ascm_panels_postgallery_itemsperrowmed, FILTER_SANITIZE_STRING),

				'recentposts_category' =>  filter_var( $ascm_panels_recentposts_category, FILTER_SANITIZE_STRING),
				'recentposts_maxnumofitems' =>  filter_var( $ascm_panels_recentposts_maxnumofitems, FILTER_SANITIZE_STRING),
				'recentposts_itemsperrowlrg' =>  filter_var( $ascm_panels_recentposts_itemsperrowlrg, FILTER_SANITIZE_STRING),
				'recentposts_itemsperrowmed' =>  filter_var( $ascm_panels_recentposts_itemsperrowmed, FILTER_SANITIZE_STRING),

				'tilemenu_navmenu' =>  filter_var( $ascm_panels_tilemenu_navmenu, FILTER_SANITIZE_STRING),
				'tilemenu_itemsperrowlrg' =>  filter_var( $ascm_panels_tilemenu_itemsperrowlrg, FILTER_SANITIZE_STRING),
				'tilemenu_itemsperrowmed' =>  filter_var( $ascm_panels_tilemenu_itemsperrowmed, FILTER_SANITIZE_STRING),

				'video_videoembedcode' =>  $ascm_panels_video_videoembedcode,

				'withimage_image' =>  filter_var( $ascm_panels_withimage_image, FILTER_SANITIZE_STRING),
				'withimage_imageposition' =>  filter_var( $ascm_panels_withimage_imageposition, FILTER_SANITIZE_STRING),
				'withimage_wrapimagewithcont' =>  filter_var( $ascm_panels_withimage_wrapimagewithcont, FILTER_SANITIZE_STRING),

				'cta_url' =>  filter_var( $ascm_panels_cta_url, FILTER_SANITIZE_STRING),
				'cta_wrapppanel' =>  filter_var( $ascm_panels_cta_wrapppanel, FILTER_SANITIZE_STRING),
				'cta_btntext' =>  filter_var( $ascm_panels_cta_btntext, FILTER_SANITIZE_STRING),

				'bg_img_opcty' =>  filter_var ( $ascm_panels_bg_img_opcty, FILTER_SANITIZE_STRING),
				'bg_img_anchor_hor' =>  filter_var( $ascm_panels_bg_img_anchor_hor, FILTER_SANITIZE_STRING),
				'bg_img_anchor_ver' =>  filter_var( $ascm_panels_bg_img_anchor_ver, FILTER_SANITIZE_STRING),
				'bg_clr' =>  filter_var( $ascm_panels_bg_clr, FILTER_SANITIZE_STRING),
				
				'outerwrapclass' =>  filter_var( $ascm_panels_outerwrapclass, FILTER_SANITIZE_STRING),
				'innerwrapclass' =>  filter_var( $ascm_panels_innerwrapclass, FILTER_SANITIZE_STRING),
				'csscode' =>  filter_var( $ascm_panels_csscode, FILTER_SANITIZE_STRING),
			);

			return array(
				'post' => $panel_post,
				'standard' => $standard,
				'custom' => $post_meta
			);
		}


		/**
		 * This function will fetch all the data of the panel
		 *
		 * @author       Junjie Canonio <junjie@alphasys.com.au>
		 * @return array
		 * @LastUpdated  May 7, 2019
		 */
		public static function get_allavailablepanels() {
			//  Query all ASCM Panels custom post 
			$query = new WP_Query(
			    array(
					'post_type' => 'ascm_panels',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'orderby' => 'title',
					'order'   => 'ASC',
			    )
			);
			$available_panels = isset($query->posts) ?  $query->posts : array();
			$available_panels_arr = array(); 
			foreach ($available_panels as $key => $value) {
				// Fetch all meta data
				$post_meta = get_post_meta($value->ID);

				// Main Options
				$ascm_panels_panelascontent = isset($post_meta['ascm-panels-panelascontent'][0]) ? $post_meta['ascm-panels-panelascontent'][0] : '';

				//Settings
				$ascm_panels_displayclildrenas = isset($post_meta['ascm-panels-displayclildrenas'][0]) ? $post_meta['ascm-panels-displayclildrenas'][0] : '';
				$ascm_panels_displayclildrenas = !empty($ascm_panels_displayclildrenas) ? $ascm_panels_displayclildrenas : 'donothing';

				// Recipes
				$ascm_panels_recipe = isset($post_meta['ascm-panels-recipe'][0]) ? $post_meta['ascm-panels-recipe'][0] : '';
				$ascm_panels_recipe_type = isset($post_meta['ascm-panels-recipe-type'][0]) ? $post_meta['ascm-panels-recipe-type'][0] : '';
				$ascm_panels_recipe_type = preg_replace('/\s+/', '', $ascm_panels_recipe_type);

				if ($ascm_panels_recipe_type == 'default') {
					if ($ascm_panels_displayclildrenas == 'donothing' && $ascm_panels_panelascontent == 'on') {
						$fontawesomeicon = '<i class="fas fa-align-left"></i>';
					}elseif ($ascm_panels_displayclildrenas == 'donothing' && $ascm_panels_panelascontent != 'on'){
						$fontawesomeicon = '<i class="fas fa-clipboard"></i>';
					}else {
						$fontawesomeicon = '<i class="fas fa-universal-access"></i>';
					}
					$recipe_type = 'default';
				}elseif ($ascm_panels_recipe_type == 'half_image') {
					$fontawesomeicon = '<i class="fas fas fa-address-card"></i>';
					$recipe_type = 'half_image';
				}elseif ($ascm_panels_recipe_type == 'post_gallery') {
					$fontawesomeicon = '<i class="fas fa-th"></i>';
					$recipe_type = 'post_gallery';
				}elseif ($ascm_panels_recipe_type == 'recent_posts') {
					$fontawesomeicon = '<i class="fas fa-newspaper"></i>';
					$recipe_type = 'recent_posts';
				}elseif ($ascm_panels_recipe_type == 'tile_menu') {
					$fontawesomeicon = '<i class="fas fa-th-large"></i>';
					$recipe_type = 'tile_menu';
				}elseif ($ascm_panels_recipe_type == 'video') {
					$fontawesomeicon = '<i class="fas fa-film"></i>';
					$recipe_type = 'video';
				}elseif ($ascm_panels_recipe_type == 'with_image') {
					$fontawesomeicon = '<i class="fas fa-images"></i>';
					$recipe_type = 'with_image';
				}else {
					$fontawesomeicon = '<i class="fas fa-mortar-pestle"></i>';
					$recipe_type = 'custom';
				}	

				$available_panels_arr[$value->ID] = array(
					'title' => $value->post_title,
					'edit_url' => get_site_url().'/wp-admin/post.php?post='.$value->ID.'&action=edit',
					'fontawesomeicon' => $fontawesomeicon,
					'recipe_type' => $recipe_type,
					'post_data' => $value
				);
			}

			return $available_panels_arr;
		}
		
		/**
		 * This function will determine the recipe type of the recipe
		 *
		 * @author       Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $path_url
		 *
		 * @return string
		 * @LastUpdated  May 17, 2019
		 */
		public static function get_panelrecipetype($path_url){
			$data = get_file_data( $path_url, array('Type' ) );
			$recipe_type = isset($data[0]) ? $data[0] : 'custom';
			return $recipe_type;
		}
		
		/**
		 * This function will fetch all the data of the panel.
		 *
		 * @author        Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @return array
		 *
		 * @LastUpdated   May 7, 2019
		 */
		public static function get_allavailablepages() {
			$genesisdefaultlayout = '';
			if(has_action('genesis_init') != false){
				$genesisdefaultlayout = genesis_get_option('site_layout');
			}
			$genesisdefaultlayout = !empty($genesisdefaultlayout) ? $genesisdefaultlayout : 'full-width-content';

			$posttypes = get_post_types( array( 'public' => true ) );

			unset($posttypes['ascm_panels']); 

			//  Query all ASCM Panels custom post 
			$query = new WP_Query(
			    array(
					'post_type' => $posttypes,
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'orderby' => 'title',
					'order'   => 'ASC',
			    )
			);

			$available_pages = isset($query->posts) ?  $query->posts : array();

			$available_pages_arr = array(); 
			foreach ($available_pages as $key => $value) {
				$post_meta = get_post_meta($value->ID);

				// Standard Themes
				$afterheader = isset($post_meta['ascm-panels-afterheader'][0]) ? $post_meta['ascm-panels-afterheader'][0] : '';
				$beforecontent = isset($post_meta['ascm-panels-beforecontent'][0]) ? $post_meta['ascm-panels-beforecontent'][0] : '';
				$aftercontent = isset($post_meta['ascm-panels-aftercontent'][0]) ? $post_meta['ascm-panels-aftercontent'][0] : '';
				$beforefooter = isset($post_meta['ascm-panels-beforefooter'][0]) ? $post_meta['ascm-panels-beforefooter'][0] : '';

				// Genesis Child Theme
				$genesispagelayout = isset($post_meta['_genesis_layout'][0]) ? $post_meta['_genesis_layout'][0] : $genesisdefaultlayout;
				$genesisbeforeheader = isset($post_meta['ascm-panels-genesisbeforeheader'][0]) ? $post_meta['ascm-panels-genesisbeforeheader'][0] : '';
				$genesisafterheader = isset($post_meta['ascm-panels-genesisafterheader'][0]) ? $post_meta['ascm-panels-genesisafterheader'][0] : '';
				$genesisbeforeentry = isset($post_meta['ascm-panels-genesisbeforeentry'][0]) ? $post_meta['ascm-panels-genesisbeforeentry'][0] : '';
				$genesisafterentry = isset($post_meta['ascm-panels-genesisafterentry'][0]) ? $post_meta['ascm-panels-genesisafterentry'][0] : '';
				$genesisbeforefooter = isset($post_meta['ascm-panels-genesisbeforefooter'][0]) ? $post_meta['ascm-panels-genesisbeforefooter'][0] : '';
				$genesisafterfooter = isset($post_meta['ascm-panels-genesisafterfooter'][0]) ? $post_meta['ascm-panels-genesisafterfooter'][0] : '';


				$available_pages_arr[$value->ID] = array(
					'title' => $value->post_title,
					'afterheader' => maybe_unserialize($afterheader),
					'beforecontent' => maybe_unserialize($beforecontent),
					'aftercontent' => maybe_unserialize($aftercontent),
					'beforefooter' => maybe_unserialize($beforefooter),

					'genesisbeforeheader' => maybe_unserialize($genesisbeforeheader),
					'genesisafterheader' => maybe_unserialize($genesisafterheader),
					'genesisbeforeentry' => maybe_unserialize($genesisbeforeentry),
					'genesisafterentry' => maybe_unserialize($genesisafterentry),
					'genesisbeforefooter' => maybe_unserialize($genesisbeforefooter),
					'genesisafterfooter' => maybe_unserialize($genesisafterfooter),

					'genesispagelayout' => $genesispagelayout,
					'post_type' => $value->post_type,
					'post_id' => $value->ID,
					'post_data' => $value
				);
			}
			
			return $available_pages_arr;
		}
		
		/**
		 * Get page info by Id relating to Panels.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $page_id
		 *
		 * @return array
		 *
		 * @LastUpdated   May 28, 2019
		 */
		public static function get_pageinfobyid($page_id) {
			if (!empty($page_id) && $page_id != null) {

				$query = new WP_Query(
				    array(
				    	'p' => $page_id,
						'post_type' => 'any',
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'orderby' => 'date',
						'order'   => 'ASC',
				    )
				);
				$page_info = isset($query->posts) ?  $query->posts : array();
				$page_info = isset($page_info[0]) ? $page_info[0] : null;

				if (!empty($page_info) && $page_info != null) {
					$genesisdefaultlayout = '';
					if(has_action('genesis_init') != false){
						$genesisdefaultlayout = genesis_get_option('site_layout');
					}
					$genesisdefaultlayout = !empty($genesisdefaultlayout) ? $genesisdefaultlayout : 'full-width-content';

					$post_meta = get_post_meta($page_id);

					// Standard Themes
					$afterheader = isset($post_meta['ascm-panels-afterheader'][0]) ? $post_meta['ascm-panels-afterheader'][0] : '';
					$beforecontent = isset($post_meta['ascm-panels-beforecontent'][0]) ? $post_meta['ascm-panels-beforecontent'][0] : '';
					$aftercontent = isset($post_meta['ascm-panels-aftercontent'][0]) ? $post_meta['ascm-panels-aftercontent'][0] : '';
					$beforefooter = isset($post_meta['ascm-panels-beforefooter'][0]) ? $post_meta['ascm-panels-beforefooter'][0] : '';

					// Genesis Child Theme
					$genesispagelayout = isset($post_meta['_genesis_layout'][0]) ? $post_meta['_genesis_layout'][0] : $genesisdefaultlayout;
					$genesisbeforeheader = isset($post_meta['ascm-panels-genesisbeforeheader'][0]) ? $post_meta['ascm-panels-genesisbeforeheader'][0] : '';
					$genesisafterheader = isset($post_meta['ascm-panels-genesisafterheader'][0]) ? $post_meta['ascm-panels-genesisafterheader'][0] : '';
					$genesisbeforeentry = isset($post_meta['ascm-panels-genesisbeforeentry'][0]) ? $post_meta['ascm-panels-genesisbeforeentry'][0] : '';
					$genesisafterentry = isset($post_meta['ascm-panels-genesisafterentry'][0]) ? $post_meta['ascm-panels-genesisafterentry'][0] : '';
					$genesisbeforefooter = isset($post_meta['ascm-panels-genesisbeforefooter'][0]) ? $post_meta['ascm-panels-genesisbeforefooter'][0] : '';
					$genesisafterfooter = isset($post_meta['ascm-panels-genesisafterfooter'][0]) ? $post_meta['ascm-panels-genesisafterfooter'][0] : '';


					return array(
						'post_data' => $page_info,
						'afterheader' => maybe_unserialize($afterheader),
						'beforecontent' => maybe_unserialize($beforecontent),
						'aftercontent' => maybe_unserialize($aftercontent),
						'beforefooter' => maybe_unserialize($beforefooter),

						'genesisbeforeheader' => maybe_unserialize($genesisbeforeheader),
						'genesisafterheader' => maybe_unserialize($genesisafterheader),
						'genesisbeforeentry' => maybe_unserialize($genesisbeforeentry),
						'genesisafterentry' => maybe_unserialize($genesisafterentry),
						'genesisbeforefooter' => maybe_unserialize($genesisbeforefooter),
						'genesisafterfooter' => maybe_unserialize($genesisafterfooter),
					);
					
				}else {

					return array(
						'status' => 'failed',
						'message' => 'Page does not exist.'
					);

				}

			}else {
				return array(
					'status' => 'failed',
					'message' => 'Invalid Page Id.'
				);
			}
		}
		
		/**
		 * This function will fetch all category of post.
		 *
		 * @author        Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @return array
		 *
		 * @LastUpdated   May 17, 2019
		 */
		public static function get_allpostcategories() {
			$categories = get_categories(array('hide_empty' => 0 ));
			return $categories;
		}
		
		/**
		 * This function will fetch all the recent posts base on the category and number of items.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $panel
		 *
		 * @return array
		 *
		 * @LastUpdated  May 15, 2019
		 */
		public static function get_recentposts( $panel ) {
			$panel_id = isset($panel['id']) ? $panel['id'] : '';

			$recentposts_category = isset($panel['data']['standard']['recentposts_category']) ? $panel['data']['standard']['recentposts_category'] : '';
			$recentposts_maxnumofitems = isset($panel['data']['standard']['recentposts_maxnumofitems']) ? $panel['data']['standard']['recentposts_maxnumofitems'] : '9';
			$recentposts_itemsperrowlrg = isset($panel['data']['standard']['recentposts_itemsperrowlrg']) ? $panel['data']['standard']['recentposts_itemsperrowlrg'] : 'fourperrow';
			$recentposts_itemsperrowmed = isset($panel['data']['standard']['recentposts_itemsperrowmed']) ? $panel['data']['standard']['recentposts_itemsperrowmed'] : 'twoperrow';

			$args = array(
				'posts_per_page' => $recentposts_maxnumofitems,
			);
			if (!empty($recentposts_category)) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'terms' => $recentposts_category,
						'field' => 'term_id',
					),
				);
			}

			return get_posts($args);
		}
		
		/**
		 * This function will fetch all the navigation menu item base on the menu term ID.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param $panel
		 *
		 * @return array
		 *
		 * @LastUpdated  May 20, 2019
		 */
		public static function get_navmenuitems( $panel ) {
			$panel_id = isset($panel['id']) ? $panel['id'] : '';

			$tilemenu_navmenu = isset($panel['data']['standard']['tilemenu_navmenu']) ? $panel['data']['standard']['tilemenu_navmenu'] : '';

			if(!empty($tilemenu_navmenu)){
				$menu_items = wp_get_nav_menu_items($tilemenu_navmenu);
			}else {
				$menu_items = '';
			}

			return $menu_items;
		}

		/**
		 * This function will fetch all colors on .
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @return array
		 *
		 * @LastUpdated   June 17, 2019
		 */
		public static function get_wfcgenesis_themecolors() {

			$theme_colors = array('transparent');
			$wfcg_theme_color_count = (Int)get_theme_mod('wfcg_theme_color_count', 8);
			for ($i=1; $i<=$wfcg_theme_color_count; $i++) {
				$wfcg_theme_color = wfcg_get_theme_mod('wfcg_theme_color_'.$i);
				//$wfcg_theme_color = (String)get_theme_mod('wfcg_theme_color_'.$i, '#ffffff');
				if(!empty($wfcg_theme_color) && !in_array($wfcg_theme_color, $theme_colors)){
					array_push($theme_colors,$wfcg_theme_color);
				}
			}
			return $theme_colors;

		}

	}
	new ASCM_Panels_Helper();
}