<?php

defined('ABSPATH') or die('No script kiddie please!');

if (! class_exists('ASCM_Repost_RelatedPostListRenderer')) {
	/**
	* Class ASCM_Repost_RelatedPostListRenderer
	* Class for handling rendering functionalities on the template
	*
	* @author Junjie Canonio <junjie@alphasys.com.au>
	* @since  1.0.0
	* @LastUpdated   April 2, 2019
	*/
	class ASCM_Repost_RelatedPostListRenderer{
		
		/**
		 * ASCM_Repost_RelatedPostListRenderer constructor.
		 */
		public function __construct() {


		}
		
		/**
		 * Enqueues styles and scripts.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array  $styles   Array of styles slug name
		 * @param  array  $scripts  Array of scripts slug name
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   April 2, 2019
		 */
		public static function enqueue_styles_scripts($styles, $scripts) {

			wp_register_script( 
				'ascm-repost-public-js', 
				plugin_dir_url( __FILE__ ) . '../../public/js/ascm-repost-public.js', 
				array( 'jquery' ), 
				'', 
				false 
			);

			wp_register_script( 
				'ascm-repost-relatedpostlist-renderer-js', 
				plugin_dir_url( __FILE__ ) . '../../public/js/ascm-repost-relatedpostlist-renderer.js', 
				array( 'jquery' ), 
				'', 
				false 
			);

			wp_register_style( 
				'ascm-repost-public-css', 
				plugin_dir_url( __FILE__ ) . '../../public/css/ascm-repost-public.css', 
				array(), 
				'', 
				'all' 
			);

			wp_register_style( 
				'ascm-repost-relatedpostlist-renderer-css', 
				plugin_dir_url( __FILE__ ) . '../../public/css/ascm-repost-relatedpostlist-renderer.css', 
				array(), 
				'', 
				'all' 
			);

			if (is_array($styles) && ! empty($styles)) {
				foreach ($styles as $style) {
					wp_enqueue_style($style);
				}
			}

			if (is_array($scripts) && ! empty($scripts)) {
				foreach ($scripts as $script) {
					wp_enqueue_script($script);
				}
			}

			
		}
		
		/**
		 * Renders the related list container of Repost.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $params
		 *
		 * @return void
		 * @since  1.0.0
         *
         * @LastUpdated   April 2, 2019
		 */
		public static function render_list($params) {
			
			wp_enqueue_script('ascm-repost-relatedpostlist-renderer-js');
			wp_enqueue_style('ascm-repost-relatedpostlist-renderer-css');


			$configs = isset($params['configs']) ? $params['configs'] : array();

			$posts_arr = array();
			$ids = isset($configs['id']) ? $configs['id'] : '';
			$ids = explode( ',', $ids );
			if (!empty($ids) && is_array($ids)) {
				$posts_arr = ASCM_Repost_RelatedPostListHelper::get_posts_by_id($ids);
				$posts_arr = isset($posts_arr['posts']) ? $posts_arr['posts'] : array();
			}

			?>
			<div 
				id="ascm-repost-relatedpostlist-items-cont" 
				class="ascm-repost-relatedpostlist-items-cont">
			<?php 
			foreach ($posts_arr as $key => $value){
				$params['post'] = !empty($value) ? $value : array(); 
				?> 
				<div class="ascm-repost-relatedpostlist-item-cont">   
				<?php ASCM_Repost_RelatedPostListRenderer::render_listitem($params); ?>
				</div>
				<?php
			}
			?>
			</div>

			<?php
		}
		
		/**
		 * Renders the title of related post list.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $params
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   April 3, 2019
		 */
		public static function render_listtitle($params) {
			$configs = isset($params['configs']) ? $params['configs'] : array();
			$title = isset($configs['title']) ? $configs['title'] : '';
			?>	
			<span class="ascm-repost-relatedpostlist-title"><?php echo $title; ?></span>
			<?php
		}
		
		/**
		 * Renders the list item of the campaign.
		 *
		 * @author Junjie Canonio <junjie@alphasys.com.au>
		 *
		 * @param  array $params
		 *
		 * @since  1.0.0
         *
         * @LastUpdated   April 3, 2019
		 */
		public static function render_listitem($params) {

			$configs = isset($params['configs']) ? $params['configs'] : array();
			$post = isset($params['post']) ? $params['post'] : array();

			$listitem_form_body = array(
				'configs' => $configs,
	            'post' => $post
	        );

			$info_template =
			ASCM_Repost_RelatedPostListHelper::is_custom_template_exist('repost/relatedpostlist','item-content.php') ? 
			ASCM_Repost_RelatedPostListHelper::get_template_file_dir('repost/relatedpostlist','item-content.php') : 
			plugin_dir_path( __FILE__ ).'../../public/templates/repost/relatedpostlist/item-content.php';  

			require( $info_template );

		}

	}
	new ASCM_Repost_RelatedPostListRenderer();
}	