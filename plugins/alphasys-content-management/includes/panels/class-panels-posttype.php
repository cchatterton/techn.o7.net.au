<?php
/**
 * Class ASCM_PanelsPostType
 * This will add a custom columns of data to the default columns on wordpress  list
 *
 * @author Junjie Canonio <junjie@alphasys.com.au>
 * @author Rowelle Gem Daguman <rowelle@alphasys.com.au>
 *
 * @since  1.0.0
 *
 * @LastUpdated   January 29, 2019
 */
class ASCM_PanelsPostType {

	public function __construct() {
		add_action( 'init', array( $this, "ascm_panels_postype") );
		add_action( 'admin_menu', array( $this, 'ascm_panel_manager' ) );
		add_filter( 'manage_ascm_panels_posts_columns', array( $this, "ascm_panels_custom_columns_list") );
		add_action( 'manage_ascm_panels_posts_custom_column',  array( $this, "ascm_panels_show_columns") );

		add_action( 'edit_form_after_title', array( $this, 'panels_options_meta_box') ); 
		add_action( 'save_post' , array($this, 'save_panels_options') );
	}

	/**
	 * Function Name: enqueue_scriptsstyles()
	 * Author: Junjie Canonio <junjie@alphasys.com.au> 
	 * Short Description: This function enqueue scripts and styles for ASCM Panels
	 * 
	 * @since 1.0.0
	 */
	public function enqueue_scriptsstyles(){

		// enqueue CSS
		wp_enqueue_style('ascm-codemirror-css');
		wp_enqueue_style('ascm-codemirror-darcula-theme-css');

		wp_enqueue_style( 
			'grid-system-admin', 
			plugin_dir_url( __FILE__ ) . '../../admin/css/grid-system-admin.css', 
			array(), 
			'', 
			'all' 
		);

		wp_enqueue_style( 
			'ascm-panels-css', 
			plugin_dir_url( __FILE__ ) . '../../admin/css/ascm-panels-posttype.css', 
			array(), 
			'', 
			'all' 
		);


		// enqueue JS
		wp_enqueue_script( 
			'ascm-panels-posttype-js', 
			plugin_dir_url( __FILE__ ) . '../../admin/js/ascm-panels-posttype.js', 
			array( 'jquery' ), 
			'', 
			false 
		);
	
	}
	/**
	 * Function Name: ascm_panels_postype()
	 * Author: Junjie Canonio <junjie@alphasys.com.au>
	 * Author: Rowelle Gem Daguman <rowelle@alphasys.com.au> 
	 * Short Description: This function will register a custom post type for ASCM Panels
	 * 
	 * @since 1.0.0
	 */
	public function ascm_panels_postype() {

		$options = get_option( 'ascm_generaloptions' );
		$enable_panels = isset( $options['ascm_enable_panels'] ) ? $options['ascm_enable_panels'] : 'off';

		if ( $enable_panels == 'on' ) {
			$labels = array(
				'name'               => _x( 'Panels', 'post type general name', 'ascm' ),
				'singular_name'      => _x( 'Panel', 'post type singular name', 'ascm' ),
				'menu_name'          => _x( 'Panels', 'admin menu', 'ascm-panels' ),
				'name_admin_bar'     => _x( 'Panel', 'add new on admin bar', 'ascm' ),
				'add_new'            => _x( 'Add New', 'panel', 'ascm' ),
				'add_new_item'       => __( 'Add New Panel', 'ascm' ),
				'new_item'           => __( 'New Panel', 'ascm' ),
				'edit_item'          => __( 'Edit Panel', 'ascm' ),
				'view_item'          => __( 'View Panel', 'ascm' ),
				'all_items'          => __( 'All panels', 'ascm' ),
				'search_items'       => __( 'Search panels', 'ascm' ),
				'parent_item_colon'  => __( 'Parent panels:', 'ascm' ),
				'not_found'          => __( 'No panels found.', 'ascm' ),
				'not_found_in_trash' => __( 'No panels found in Trash.', 'ascm' )
			);

			$args = array(
				'labels'             	=> $labels,
		        'description'        	=> __( 'Description.', 'ascm' ),
				'public'             	=> true,
				'publicly_queryable' 	=> false,
				'exclude_from_search'	=> true,
				'show_in_menu'       	=> true,
		        'show_in_nav_menus'  	=> false,
		        'show_in_admin_bar'  	=> false,
				'query_var'          	=> true,
				'rewrite'            	=> array( 'slug' => 'ascm' ),
				'capability_type'    	=> 'post',
				'has_archive'        	=> true,
				'hierarchical'       	=> true,
				'menu_position'      	=> true,
				'menu_icon'				=> 'dashicons-excerpt-view',
				'supports'           	=> array( 'title','thumbnail', 'editor', 'author' )
			);

			register_post_type( 'ascm_panels', $args );
		}

	}

	/**
	 * Function Name: ascm_panels_custom_columns_list()
	 * Author: Junjie Canonio <junjie@alphasys.com.au>
	 * Short Description: This function will add custom column headers to the default column headers on wordpress list
	 * 
	 * @since 1.0.0
	 * 
	 * @param array $columns Array of columns
	 * 
	 * @return array Array Array of columns with the the added ascm column
	 */
	public function ascm_panels_custom_columns_list($columns) {	    
		?>
		<style type="text/css">
			thead tr{
				background: linear-gradient(45deg, #fea576, #fe7e75) !important;
			}
			thead th, thead th a, thead td {
			    color: #ffffff !important;
			    
			    font-weight: 600 !important;
			}
			th .sorting-indicator:before{
	            color: #ffffff !important;
	        }
	        tfoot{
	            display: none !important;
	        }
		</style>
		<?php
	    $columns['ascm_shortcode']     = 'Shortcode';
	    return $columns;
	}
		
	/**
	 * This will add custom columns of data to the default columns on wordpress  list
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $name
	 *
	 * @since  1.0.0
     *
     * @LastUpdated  January 29, 2019
	 */
	public function ascm_panels_show_columns($name) {
	    global $post;
	    $post_shortcode = isset($post->ID) ? '[ascm-panels id='.$post->ID.']' : '';
	    switch ($name) {
	        case 'ascm_shortcode':
	        	echo '<input style="width: 100%;" type="text" readonly value="'.$post_shortcode.'">';
	    }
	}
	
	/**
	 * This function is the callback function for 'panels options' meta box
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $post
	 *
	 * @LastUpdated   April 4, 2019
	 */
	public function panels_options_meta_box( $post ) {

		if (isset($post->post_type) && $post->post_type == 'ascm_panels') {

			$this->enqueue_scriptsstyles();


			//  Query all ASCM Panels custom post 
			$query = new WP_Query(
			    array(
			      'post_type' => 'ascm_panels',
			      'post_status' => 'publish',
			      'posts_per_page' => -1
			    )
			);
			$ascm_panels_available = isset($query->posts) ?  $query->posts : array();
			$ascm_panels_available_arr = array(); 
			foreach ($ascm_panels_available as $key => $value) {
				if ($value->ID != $post->ID) {
					$ascm_panels_available_arr[$value->ID] = $value->post_title;
				}
			}


			//  Fetch list of recipes on the ASCM Panel recipe dir and the them recipe dir
			$default_recipe = '';
			$ascm_panels_recipes_arr = ASCM_Panels_Helper::get_templates();
			foreach ($ascm_panels_recipes_arr as $key => $value) {
				if (isset($value['type']) && $value['type'] == 'default') {
					$default_recipe = $key;
				}
			}

			// Fetch all post type
			$post_types = get_post_types();
			$post_types = !empty($post_types) ? $post_types : array();
			if(is_array($post_types) && isset($post_types['ascm_panels'])){
				unset($post_types['ascm_panels']);
            }

			// Fetch all theme colors
			if(has_action('genesis_init') && function_exists('wfcg_get_theme_mod')){
				$themecolors = ASCM_Panels_Helper::get_wfcgenesis_themecolors();
				$themecolors = implode(",", $themecolors);
			}else{
				$themecolors = '';
            }


            // Fetch all post category
			$postcategories = ASCM_Panels_Helper::get_allpostcategories();

			// Fetch all available navigation menu
			$nav_menus = get_terms('nav_menu');

			// Fetch all meta data
			$post_meta = get_post_meta($post->ID);

			// Main Options
			$ascm_panels_panelascontent = isset($post_meta['ascm-panels-panelascontent'][0]) ? $post_meta['ascm-panels-panelascontent'][0] : '';
			$ascm_panels_panelascontent_status = ($ascm_panels_panelascontent == 'on') ? 'checked' : '';

			// Settings
			$ascm_panels_hidetitle = isset($post_meta['ascm-panels-hidetitle'][0]) ? $post_meta['ascm-panels-hidetitle'][0] : 'off';
			$ascm_panels_hidetitle_status = ($ascm_panels_hidetitle == 'on') ? 'checked' : '';
			$ascm_panels_parentpanel = isset($post->post_parent) ? $post->post_parent : '';
			$ascm_panels_menuorder = isset($post->menu_order) ? $post->menu_order : '0';
			$ascm_panels_displayclildrenas = isset($post_meta['ascm-panels-displayclildrenas'][0]) ? $post_meta['ascm-panels-displayclildrenas'][0] : '';
			$ascm_panels_displayclildrenas = !empty($ascm_panels_displayclildrenas) ? $ascm_panels_displayclildrenas : 'donothing';
			$ascm_panels_displaytype = isset($post_meta['ascm-panels-displaytype'][0]) ? $post_meta['ascm-panels-displaytype'][0] : '';
			$ascm_panels_displaytype = !empty($ascm_panels_displaytype) ? $ascm_panels_displaytype : 'fullwdth';

			// Recipes
			$ascm_panels_recipe = isset($post_meta['ascm-panels-recipe'][0]) ? $post_meta['ascm-panels-recipe'][0] : '';
			$ascm_panels_card_overwrite = isset($post_meta['ascm-panels-card-overwrite'][0]) ? $post_meta['ascm-panels-card-overwrite'][0] : '';
			
			// ========= Half Image ========== // 
			$ascm_panels_halfimage_image = isset($post_meta['ascm-panels-halfimage-image'][0]) ? $post_meta['ascm-panels-halfimage-image'][0] : '';
			$ascm_panels_halfimage_imageposition = isset($post_meta['ascm-panels-halfimage-imageposition'][0]) ? $post_meta['ascm-panels-halfimage-imageposition'][0] : 'left';
			$ascm_panels_halfimage_imageposition = !empty($ascm_panels_halfimage_imageposition) ? $ascm_panels_halfimage_imageposition : 'left';
			$ascm_panels_halfimage_containedimage = isset($post_meta['ascm-panels-halfimage-containedimage'][0]) ? $post_meta['ascm-panels-halfimage-containedimage'][0] : '';
			$ascm_panels_halfimage_containedimage_status = ($ascm_panels_halfimage_containedimage == 'on') ? 'checked' : '';
			// ========= Post Gallery ========== //
			$ascm_panels_postgallery_posttype = isset($post_meta['ascm-panels-postgallery-posttype'][0]) ? $post_meta['ascm-panels-postgallery-posttype'][0] : '';
			$ascm_panels_postgallery_maxnumofitems = isset($post_meta['ascm-panels-postgallery-maxnumofitems'][0]) ? $post_meta['ascm-panels-postgallery-maxnumofitems'][0] : '9';
			$ascm_panels_postgallery_maxnumofitems = !empty($ascm_panels_postgallery_maxnumofitems) ? $ascm_panels_postgallery_maxnumofitems : '9';
			$ascm_panels_postgallery_orderby = isset($post_meta['ascm-panels-postgallery-orderby'][0]) ? $post_meta['ascm-panels-postgallery-orderby'][0] : 'post_title';
			$ascm_panels_postgallery_sortorder = isset($post_meta['ascm-panels-postgallery-sortorder'][0]) ? $post_meta['ascm-panels-postgallery-sortorder'][0] : 'DESC';
			$ascm_panels_postgallery_itemsperrowlrg = isset($post_meta['ascm-panels-postgallery-itemsperrowlrg'][0]) ? $post_meta['ascm-panels-postgallery-itemsperrowlrg'][0] : 'fourperrow';
			$ascm_panels_postgallery_itemsperrowlrg = !empty($ascm_panels_postgallery_itemsperrowlrg) ? $ascm_panels_postgallery_itemsperrowlrg : 'fourperrow';
			$ascm_panels_postgallery_itemsperrowmed = isset($post_meta['ascm-panels-postgallery-itemsperrowmed'][0]) ? $post_meta['ascm-panels-postgallery-itemsperrowmed'][0] : 'twoperrow';
			$ascm_panels_postgallery_itemsperrowmed = !empty($ascm_panels_postgallery_itemsperrowmed) ? $ascm_panels_postgallery_itemsperrowmed : 'twoperrow';
			// ========= Recent Posts ========== //
			$ascm_panels_recentposts_category = isset($post_meta['ascm-panels-recentposts-category'][0]) ? $post_meta['ascm-panels-recentposts-category'][0] : '';
			$ascm_panels_recentposts_maxnumofitems = isset($post_meta['ascm-panels-recentposts-maxnumofitems'][0]) ? $post_meta['ascm-panels-recentposts-maxnumofitems'][0] : '9';
			$ascm_panels_recentposts_maxnumofitems = !empty($ascm_panels_recentposts_maxnumofitems) ? $ascm_panels_recentposts_maxnumofitems : '9';
			$ascm_panels_recentposts_itemsperrowlrg = isset($post_meta['ascm-panels-recentposts-itemsperrowlrg'][0]) ? $post_meta['ascm-panels-recentposts-itemsperrowlrg'][0] : 'fourperrow';
			$ascm_panels_recentposts_itemsperrowlrg = !empty($ascm_panels_recentposts_itemsperrowlrg) ? $ascm_panels_recentposts_itemsperrowlrg : 'fourperrow';
			$ascm_panels_recentposts_itemsperrowmed = isset($post_meta['ascm-panels-recentposts-itemsperrowmed'][0]) ? $post_meta['ascm-panels-recentposts-itemsperrowmed'][0] : 'twoperrow';
			$ascm_panels_recentposts_itemsperrowmed = !empty($ascm_panels_recentposts_itemsperrowmed) ? $ascm_panels_recentposts_itemsperrowmed : 'twoperrow';
			// ========= Tile Menu ========== //
			$ascm_panels_tilemenu_navmenu = isset($post_meta['ascm-panels-tilemenu-navmenu'][0]) ? $post_meta['ascm-panels-tilemenu-navmenu'][0] : '';
			$ascm_panels_tilemenu_itemsperrowlrg = isset($post_meta['ascm-panels-tilemenu-itemsperrowlrg'][0]) ? $post_meta['ascm-panels-tilemenu-itemsperrowlrg'][0] : 'fourperrow';
			$ascm_panels_tilemenu_itemsperrowlrg = !empty($ascm_panels_tilemenu_itemsperrowlrg) ? $ascm_panels_tilemenu_itemsperrowlrg : 'fourperrow';
			$ascm_panels_tilemenu_itemsperrowmed = isset($post_meta['ascm-panels-tilemenu-itemsperrowmed'][0]) ? $post_meta['ascm-panels-tilemenu-itemsperrowmed'][0] : 'twoperrow';
			$ascm_panels_tilemenu_itemsperrowmed = !empty($ascm_panels_tilemenu_itemsperrowmed) ? $ascm_panels_tilemenu_itemsperrowmed : 'twoperrow';
			// ========= Video ========== //
			$ascm_panels_video_videoembedcode = isset($post_meta['ascm-panels-video-videoembedcode'][0]) ? $post_meta['ascm-panels-video-videoembedcode'][0] : '';
			$ascm_panels_video_videoembedcode = !empty($ascm_panels_video_videoembedcode) ? (String)$ascm_panels_video_videoembedcode : '<iframe width="1280" height="720" src="https://www.youtube.com/embed/8AZ8GqW5iak" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
			// ========= With Image ========== //
			$ascm_panels_withimage_image = isset($post_meta['ascm-panels-withimage-image'][0]) ? $post_meta['ascm-panels-withimage-image'][0] : '';
			$ascm_panels_withimage_imageposition = isset($post_meta['ascm-panels-withimage-imageposition'][0]) ? $post_meta['ascm-panels-withimage-imageposition'][0] : 'left';
			$ascm_panels_withimage_imageposition = !empty($ascm_panels_withimage_imageposition) ? $ascm_panels_withimage_imageposition : 'left';
			$ascm_panels_withimage_wrapimagewithcont = isset($post_meta['ascm-panels-withimage-wrapimagewithcont'][0]) ? $post_meta['ascm-panels-withimage-wrapimagewithcont'][0] : '';
			$ascm_panels_withimage_wrapimagewithcont_status = ($ascm_panels_withimage_wrapimagewithcont == 'on') ? 'checked' : '';


            $ascm_panels_cta_url = isset($post_meta['ascm-panels-cta-url'][0]) ? $post_meta['ascm-panels-cta-url'][0] : '';
			$ascm_panels_cta_wrapppanel = isset($post_meta['ascm-panels-cta-wrapppanel'][0]) ? $post_meta['ascm-panels-cta-wrapppanel'][0] : '';
			$ascm_panels_cta_wrapppanel_status = ($ascm_panels_cta_wrapppanel == 'on') ? 'checked' : '';
			$ascm_panels_cta_btntext = isset($post_meta['ascm-panels-cta-btntext'][0]) ? $post_meta['ascm-panels-cta-btntext'][0] : '';

			$ascm_panels_bg_img_opcty = isset($post_meta['ascm-panels-bg-img-opcty'][0]) ? $post_meta['ascm-panels-bg-img-opcty'][0] : '';
			$ascm_panels_bg_img_opcty = !empty($ascm_panels_bg_img_opcty) ? $ascm_panels_bg_img_opcty : '100';
			$ascm_panels_bg_img_opcty = (Float)$ascm_panels_bg_img_opcty * 100;
			$ascm_panels_bg_img_anchor_hor = isset($post_meta['ascm-panels-bg-img-anchor-hor'][0]) ? $post_meta['ascm-panels-bg-img-anchor-hor'][0] : 'center';
			$ascm_panels_bg_img_anchor_hor = !empty($ascm_panels_bg_img_anchor_hor) ? $ascm_panels_bg_img_anchor_hor : 'center';
			$ascm_panels_bg_img_anchor_ver = isset($post_meta['ascm-panels-bg-img-anchor-ver'][0]) ? $post_meta['ascm-panels-bg-img-anchor-ver'][0] : 'center';
			$ascm_panels_bg_img_anchor_ver = !empty($ascm_panels_bg_img_anchor_ver) ? $ascm_panels_bg_img_anchor_ver : 'center';
			$ascm_panels_bg_clr = isset($post_meta['ascm-panels-bg-clr'][0]) ? $post_meta['ascm-panels-bg-clr'][0] : 'transparent';
			$ascm_panels_bg_clr = !empty($ascm_panels_bg_clr) ? $ascm_panels_bg_clr : 'transparent';

			$ascm_panels_outerwrapclass = isset($post_meta['ascm-panels-outerwrapclass'][0]) ? $post_meta['ascm-panels-outerwrapclass'][0] : '';
			$ascm_panels_innerwrapclass = isset($post_meta['ascm-panels-innerwrapclass'][0]) ? $post_meta['ascm-panels-innerwrapclass'][0] : '';
			$ascm_panels_csscode = isset($post_meta['ascm-panels-csscode'][0]) ? $post_meta['ascm-panels-csscode'][0] : '';
			$ascm_panels_csscode = !empty($ascm_panels_csscode) ? $ascm_panels_csscode : '/**
* Any custom CSS for your panel should be included here.
*/

.Sample-class {
  background-color: #fff;
}';

			?>

			<input type="hidden" name="ascm-panels-nonce" value="ascm-panels-savepost">				
			<div class="ascm-panels-prioritymetabox-main-container">
				<div class="ascm-panels-prioritymetabox-title-container">
					<h2 class="hndle ui-sortable-handle">
						<img id="ascm_logo" src="<?php echo plugin_dir_url( __FILE__ ).'../../images/ascm.png';?>">
						<span><?php _e( 'Panel Options', 'ascm' ); ?></span>
					</h2>
				</div>
				<div class="ascm-panels-prioritymetabox-sub-container">
					<div class="ascm-panels-primary-option">
						<div class="ascm-container">
							<div class="ascm-container-padding ascm-field-col s12 m6 l6">
								<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Panel as Content', 'ascm' ); ?></div>
								<div class="ascm-onoffswitch">
								    <input type="checkbox" name="ascm-panels-panelascontent" class="ascm-onoffswitch-checkbox" id="ascm-panels-panelascontent" <?php echo $ascm_panels_panelascontent_status; ?>>
								    <label class="ascm-onoffswitch-label" for="ascm-panels-panelascontent">
								        <span class="ascm-onoffswitch-inner"></span>
								        <span class="ascm-onoffswitch-switch"></span>
								    </label>
								</div>
								<div class="ascm-main-content-mod-field-note"><small><b>Note: </b> <?php _e( 'Switching this field <b>ON</b> will disable most of the recipe functionality of the panel and will render the content only. Enabling this functionality will render most of the panel options unavailable.', 'ascm' ); ?></small></div>
							</div>
						</div>
					</div>
					<div id="ascm-panels-accordion" class="ascm-panels-accordion-container">

						<article id="ascm-panel-settings" class="ascm-panels-content-entry">
							<div class="ascm-panels-article-title"><?php _e( 'Settings', 'ascm' ); ?></div>
							<div class="ascm-panels-accordion-content">
								<div class="ascm-container">
									<div id="ascm-panels-hidetitle-maincont" class="ascm-field-col s12 m6 l6">
										<div id="ascm-panels-hidetitle-subcont" class="ascm-container-padding">
											<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Hide Title', 'ascm' ); ?></div>
											<div class="ascm-onoffswitch">
											    <input type="checkbox" name="ascm-panels-hidetitle" class="ascm-onoffswitch-checkbox" id="ascm-panels-hidetitle" <?php echo $ascm_panels_hidetitle_status; ?>>
											    <label class="ascm-onoffswitch-label" for="ascm-panels-hidetitle">
											        <span class="ascm-onoffswitch-inner"></span>
											        <span class="ascm-onoffswitch-switch"></span>
											    </label>
											</div>
											<div class="ascm-main-content-mod-field-note"><small><b>Note: </b> <?php _e( 'Switching this field <b>ON</b> will hide the title of the panel.', 'ascm' ); ?></small></div>
										</div>
									</div>
									<div id="ascm-panels-parentpanel-maincont" class="ascm-field-col s12 m6 l6">
										<div id="ascm-panels-parentpanel-subcont" class="ascm-container-padding">
											<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Parent Panel', 'ascm' ); ?></div>
											<small><?php _e( "Set a parent panel for this panel which will make this panel a child of the panel selected of the Parent Panel field.", 'ascm' ); ?></small>
											<div style="margin-top: 5px;">
												<select name="ascm-panels-parentpanel">
													<option value="" <?php selected( '', $ascm_panels_parentpanel ); ?>><?php _e( '(No Parent)', 'ascm' ); ?></option>
													<?php foreach ($ascm_panels_available_arr as $key => $value) : ?>
													<option value="<?php echo $key;?>" <?php selected( $key, $ascm_panels_parentpanel ); ?>><?php echo $value;?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
									<div id="ascm-panels-parentmenuorder-maincont" class="ascm-field-col s12 m6 l6">
										<div id="ascm-panels-parentmenuorder-subcont" class="ascm-container-padding">
											<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Panel Order', 'ascm' ); ?></div>
											<small><?php _e( 'Set the priority order number for this panel.', 'ascm' ); ?></small>
											<div class="ascm-rangeslider">
												<div class="ascm-rangeslider-slider-cont">
													<input id="ascm-panels-parentmenuorder" name="ascm-panels-parentmenuorder" type="range" min="0" max="100" step="1" value="<?php echo $ascm_panels_menuorder; ?>" class="slider"/>
												</div>
												<span id="ascm-panels-parentmenuorder-rangeslider-info" class="ascm-rangeslider-info"></span>
											</div>
										</div>
									</div>
									<div id="ascm-panels-displayclildrenas-maincont" class="ascm-field-col s12 m6 l6">
										<div id="ascm-panels-displayclildrenas-subcont" class="ascm-container-padding">
											<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Display Children As', 'ascm' ); ?></div>
											<small><?php _e( 'If this panel has child panels, they can either be displayed as a slider or a series of tiles. Note that if this panel has children most of the following options are ignored.', 'ascm' ); ?></small>
											<div style="margin-top: 5px;">
												<label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-displayclildrenas-donothing">
													<input type="radio" id="ascm-panels-displayclildrenas-donothing" name="ascm-panels-displayclildrenas" value="donothing" <?php checked( $ascm_panels_displayclildrenas, 'donothing' ); ?>><?php _e( 'Do Nothing', 'ascm' ); ?>
												</label>
												<label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-displayclildrenas-slider">
													<input type="radio" id="ascm-panels-displayclildrenas-slider" name="ascm-panels-displayclildrenas" value="slider" <?php checked( $ascm_panels_displayclildrenas, 'slider' ); ?>><?php _e( 'Slider', 'ascm' ); ?>
												</label>
												<label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-displayclildrenas-tiles">
													<input type="radio" id="ascm-panels-displayclildrenas-tiles" name="ascm-panels-displayclildrenas" value="tiles" <?php checked( $ascm_panels_displayclildrenas, 'tiles' ); ?>><?php _e( 'Tiles', 'ascm' ); ?>
												</label>
											</div>
										</div>
									</div>
                                    <div id="ascm-panels-displaytype-maincont" class="ascm-field-col s12 m6 l6">
                                        <div id="ascm-panels-displaytype-subcont" class="ascm-container-padding">
                                            <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Panel Display Style', 'ascm' ); ?></div>
                                            <small><?php _e( 'How do you want this panel displayed.', 'ascm' ); ?></small>
                                            <div style="margin-top: 5px; display: grid;">
                                                <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-displaytype-fullwdth" style="margin-top: 5px;">
                                                    <input type="radio" id="ascm-panels-displaytype-fullwdth" name="ascm-panels-displaytype" value="fullwdth" <?php checked( $ascm_panels_displaytype, 'fullwdth' ); ?>><?php _e( 'Full width', 'ascm' ); ?>
                                                </label>
                                                <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-displaytype-fullwdthbgimgcontainedcont" style="margin-top: 5px;">
                                                    <input type="radio" id="ascm-panels-displaytype-fullwdthbgimgcontainedcont" name="ascm-panels-displaytype" value="fullwdthbgimgcontainedcont" <?php checked( $ascm_panels_displaytype, 'fullwdthbgimgcontainedcont' ); ?>><?php _e( 'Full width background image, contained content', 'ascm' ); ?>
                                                </label>
                                                <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-displaytype-containedimgandcont" style="margin-top: 5px;">
                                                    <input type="radio" id="ascm-panels-displaytype-containedimgandcont" name="ascm-panels-displaytype" value="containedimgandcont" <?php checked( $ascm_panels_displaytype, 'containedimgandcont' ); ?>><?php _e( 'Contained background image and content', 'ascm' ); ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
								</div>
							</div>
						</article>

						<article id="ascm-panel-recipe" class="ascm-panels-content-entry">
							<div class="ascm-panels-article-title"><?php _e( 'Recipe', 'ascm' ); ?></span></div>
							<div class="ascm-panels-accordion-content">
								<div class="ascm-container">
									<div class="ascm-container-padding ascm-field-col s12 m6 l6">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Recipe', 'ascm' ); ?></div>
										<small><?php _e( 'If this panel has child panels, they can either be displayed as a slider or a series of tiles. Note that if this panel has children most of the following options are ignored.', 'ascm' ); ?></small>
										<div style="margin-top: 5px;">
											<input type="hidden" name="ascm-panels-default-recipe" value="<?php echo $default_recipe; ?>">
											<select name="ascm-panels-recipe">
												<?php foreach ($ascm_panels_recipes_arr as $key => $value):
                                                    $recipe_title = isset($value['title']) ? $value['title'] : '';
													$recipe_type = isset($value['type']) ? $value['type'] : '';
													$recipe_settings = isset($value['settings']) ? $value['settings'] : '';
                                                    ?>
													<option value="<?php echo $key; ?>" <?php selected( $key, $ascm_panels_recipe ); ?> recipe-type="<?php echo esc_html($recipe_type); ?>" recipe-settings="<?php echo esc_html($recipe_settings); ?>"><?php echo esc_html($recipe_title); ?></option>
												<?php endforeach; ?>	
											</select>
										</div>
										<div class="ascm-panels-card-overwrite-wrapper">
											<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Card Type', 'ascm' ); ?></div>
											<div style="margin-top: 5px;">
												<input type="text" name="ascm-panels-card-overwrite" value="<?php echo $ascm_panels_card_overwrite; ?>" >
											</div>
										</div>
									</div>
								</div>


                                <?php
                                require_once plugin_dir_path( dirname( __FILE__ ) ) . '../public/templates/panels/recipe-settings/half_image_settings.php';
                                ?>

								<!--========================= Half Image recipe extra settings =========================-->
								<div id="ascm-panels-halfimage" class="ascm-container ascm-panels-extrasettings-cont">
									<div class="ascm-container-padding ascm-field-col s12 m6 l6">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Image', 'ascm' ); ?></div>
										<small><?php _e( 'This will be the image that will be rendered beside the content half of the panel.', 'ascm' ); ?></small>
										<div class="ascm-image-uploader" style="margin-top: 5px;">
											<div class="image-preview-wrapper">
												<?php if(!empty($ascm_panels_halfimage_image)) : ?>
													<img id='ascm-panels-halfimage-image-preview' src="<?php echo wp_get_attachment_url($ascm_panels_halfimage_image); ?>" width='150' height='100' style='max-height: 100px; width: 150px;'>
												<?php else : ?>
													<img id='ascm-panels-halfimage-image-preview' src="<?php echo 'https://via.placeholder.com/600x400';?>" width='150' height='100' style='max-height: 100px; width: 150px;'>		
												<?php endif; ?>
											</div>
											<div class="image-buttons-wrapper">
												<input id="ascm_panels_halfimage_image_button" type="button" class="ascm-image-uploader-uploadbtn button" value="<?php _e( 'Upload image', 'ascm' ); ?>" />
												<input id="ascm_panels_halfimage_image_clearbtn" type="button" class="ascm-image-uploader-clearbtn button" value="<?php _e( 'Clear image', 'ascm' ); ?>" />
											</div>
											<input type='hidden' id='ascm-panels-halfimage-image' name='ascm-panels-halfimage-image' value="<?php echo $ascm_panels_halfimage_image;?>">
										</div>
									</div>
									<div class="ascm-container-padding ascm-field-col s12 m6 l6">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Image Position', 'ascm' ); ?></div>
										<small><?php _e( 'Select the desired position of the image.', 'ascm' ); ?></small>
										<div class="ascm-panels-halfimage-imageposition-cont ascm-panels-radio-btn-v1" style="margin-top: 5px;">
											<input type="radio" id="ascm-panels-halfimage-imageposition-left" name="ascm-panels-halfimage-imageposition" value="left" <?php checked( $ascm_panels_halfimage_imageposition, 'left' ); ?>>
											<label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-halfimage-imageposition-left">Left</label>

											<input type="radio" id="ascm-panels-halfimage-imageposition-right" name="ascm-panels-halfimage-imageposition" value="right" <?php checked( $ascm_panels_halfimage_imageposition, 'right' ); ?>>
											<label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-halfimage-imageposition-right">Right</label>
										</div>
									</div>
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Contained Image', 'ascm' ); ?></div>
                                        <div class="ascm-onoffswitch">
                                            <input type="checkbox" name="ascm-panels-halfimage-containedimage" class="ascm-onoffswitch-checkbox" id="ascm-panels-halfimage-containedimage" <?php echo $ascm_panels_halfimage_containedimage_status; ?>>
                                            <label class="ascm-onoffswitch-label" for="ascm-panels-halfimage-containedimage">
                                                <span class="ascm-onoffswitch-inner"></span>
                                                <span class="ascm-onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ascm-main-content-mod-field-note"><small><b>Note: </b> Switching this field <b>ON</b> to force the image to be contained similar to the content.</div>
                                    </div>
								</div>
								<!--========================= Half Image recipe extra settings =========================-->

                                <!--========================= Post Gallery recipe extra settings =========================-->
                                <div id="ascm-panels-postgallery" class="ascm-container ascm-panels-extrasettings-cont">
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Post Type', 'ascm' ); ?></div>
                                        <small><?php _e( 'Choose the post posttype for post gallery.', 'ascm' ); ?></small>
                                        <select id="ascm-panels-postgallery-posttype" name="ascm-panels-postgallery-posttype" style="margin-top: 5px;">
		                                    <?php foreach($post_types as $key => $value ): ?>
                                                <option value="<?php esc_html_e( $key, 'ascm' ); ?>" <?php selected( $key, $ascm_panels_postgallery_posttype ); ?>><?php esc_html_e( $key, 'ascm' ); ?></option>
		                                    <?php endforeach; ?>
                                        </select>

                                    </div>
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Maximum Number of Items', 'ascm' ); ?></div>
                                        <small><?php _e( 'Set the number of posts to display per page.', 'ascm' ); ?></small>
                                        <div class="ascm-rangeslider">
                                            <div class="ascm-rangeslider-slider-cont">
                                                <input id="ascm-panels-postgallery-maxnumofitems" name="ascm-panels-postgallery-maxnumofitems" type="range" min="1" max="30" step="1" value="<?php echo $ascm_panels_postgallery_maxnumofitems; ?>" class="slider"/>
                                            </div>
                                            <span id="ascm-panels-postgallery-maxnumofitems-rangeslider-info" class="ascm-rangeslider-info"></span>
                                        </div>
                                    </div>
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Order By', 'ascm' ); ?></div>
                                        <small><?php _e( 'Choose the sort order by for post gallery.', 'ascm' ); ?></small>
                                        <select id="ascm-panels-postgallery-orderby" name="ascm-panels-postgallery-orderby" style="margin-top: 5px;">
                                            <option value="<?php esc_html_e( 'post_title', 'ascm' ); ?>" <?php selected( 'post_title', $ascm_panels_postgallery_orderby ); ?>><?php esc_html_e( 'post_title', 'ascm' ); ?></option>
                                            <option value="<?php esc_html_e( 'date', 'ascm' ); ?>" <?php selected( 'date', $ascm_panels_postgallery_orderby ); ?>><?php esc_html_e( 'date', 'ascm' ); ?></option>
                                        </select>
                                    </div>
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Order By', 'ascm' ); ?></div>
                                        <small><?php _e( 'Choose the sort order for post gallery.', 'ascm' ); ?></small>
                                        <select id="ascm-panels-postgallery-sortorder" name="ascm-panels-postgallery-sortorder" style="margin-top: 5px;">
                                            <option value="<?php esc_html_e( 'DESC', 'ascm' ); ?>" <?php selected( 'DESC', $ascm_panels_postgallery_sortorder ); ?>><?php esc_html_e( 'DESC', 'ascm' ); ?></option>
                                            <option value="<?php esc_html_e( 'ASC', 'ascm' ); ?>" <?php selected( 'ASC', $ascm_panels_postgallery_sortorder ); ?>><?php esc_html_e( 'ASC', 'ascm' ); ?></option>
                                        </select>
                                    </div>
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Items Per Row (Large Screen)', 'ascm' ); ?></div>
                                        <small><?php _e( 'Select number of items in every row on a large screen.', 'ascm' ); ?></small>
                                        <div class="ascm-panels-postgallery-itemsperrowlrg-cont ascm-panels-radio-btn-v1" style="margin-top: 5px;">
                                            <input type="radio" id="ascm-panels-postgallery-itemsperrowlrg-fourperrow" name="ascm-panels-postgallery-itemsperrowlrg" value="fourperrow" <?php checked( $ascm_panels_postgallery_itemsperrowlrg, 'fourperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-postgallery-itemsperrowlrg-fourperrow"><?php _e( 'Four Per Row', 'ascm' ); ?></label>

                                            <input type="radio" id="ascm-panels-postgallery-itemsperrowlrg-threeperrow" name="ascm-panels-postgallery-itemsperrowlrg" value="threeperrow" <?php checked( $ascm_panels_postgallery_itemsperrowlrg, 'threeperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-postgallery-itemsperrowlrg-threeperrow"><?php _e( 'Three Per Row', 'ascm' ); ?></label>

                                            <input type="radio" id="ascm-panels-postgallery-itemsperrowlrg-twoperrow" name="ascm-panels-postgallery-itemsperrowlrg" value="twoperrow" <?php checked( $ascm_panels_postgallery_itemsperrowlrg, 'twoperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-postgallery-itemsperrowlrg-twoperrow"><?php _e( 'Two Per Row', 'ascm' ); ?></label>

                                            <input type="radio" id="ascm-panels-postgallery-itemsperrowlrg-oneperrow" name="ascm-panels-postgallery-itemsperrowlrg" value="oneperrow" <?php checked( $ascm_panels_postgallery_itemsperrowlrg, 'oneperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-postgallery-itemsperrowlrg-oneperrow"><?php _e( 'One Per Row', 'ascm' ); ?></label>
                                        </div>
                                    </div>
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Items Per Row (Medium Screen)', 'ascm' ); ?></div>
                                        <small><?php _e( 'Select number of items in every row on a medium screen.', 'ascm' ); ?></small>
                                        <div class="ascm-panels-postgallery-itemsperrowmed-cont ascm-panels-radio-btn-v1" style="margin-top: 5px;">
                                            <input type="radio" id="ascm-panels-postgallery-itemsperrowmed-twoperrow" name="ascm-panels-postgallery-itemsperrowmed" value="twoperrow" <?php checked( $ascm_panels_postgallery_itemsperrowmed, 'twoperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-postgallery-itemsperrowmed-twoperrow"><?php _e( 'Two Per Row', 'ascm' ); ?></label>

                                            <input type="radio" id="ascm-panels-postgallery-itemsperrowmed-oneperrow" name="ascm-panels-postgallery-itemsperrowmed" value="oneperrow" <?php checked( $ascm_panels_postgallery_itemsperrowmed, 'oneperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-postgallery-itemsperrowmed-oneperrow"><?php _e( 'One Per Row', 'ascm' ); ?></label>

                                        </div>
                                    </div>
                                </div>
                                <!--========================= Post Gallery recipe extra settings =========================-->

								<!--========================= Recent Posts recipe extra settings =========================-->
								<div id="ascm-panels-recentposts" class="ascm-container ascm-panels-extrasettings-cont">
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Post Category', 'ascm' ); ?></div>
                                        <small><?php _e( 'Choose the post category for recent posts.', 'ascm' ); ?></small>
                                        <select id="ascm-panels-recentposts-category" name="ascm-panels-recentposts-category" style="margin-top: 5px;">
                                            <option value="" <?php selected( '', $ascm_panels_recentposts_category ); ?>><?php _e( 'All', 'ascm' ); ?></option>
                                        <?php foreach($postcategories as $key => $value ):
                                            $category_id = isset($value->term_id) ? $value->term_id : '';
	                                        $category_name = isset($value->name) ? $value->name : '';
	                                    ?>

                                            <option value="<?php esc_html_e( $category_id, 'ascm' ); ?>" <?php selected( $category_id, $ascm_panels_recentposts_category ); ?>><?php esc_html_e( $category_name, 'ascm' ); ?></option>

                                        <?php endforeach; ?>
                                        </select>


                                    </div>
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Maximum Number of Items', 'ascm' ); ?></div>
										<small><?php _e( 'Set the number of recent posts to display.', 'ascm' ); ?></small>
										<div class="ascm-rangeslider">
											<div class="ascm-rangeslider-slider-cont">
												<input id="ascm-panels-recentposts-maxnumofitems" name="ascm-panels-recentposts-maxnumofitems" type="range" min="0" max="100" step="1" value="<?php echo $ascm_panels_recentposts_maxnumofitems; ?>" class="slider"/>
											</div>
											<span id="ascm-panels-recentposts-maxnumofitems-rangeslider-info" class="ascm-rangeslider-info"></span>
										</div>	
									</div>
									<div class="ascm-container-padding ascm-field-col s12 m6 l6">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Items Per Row (Large Screen)', 'ascm' ); ?></div>
										<small><?php _e( 'Select number of items in every row on a large screen.', 'ascm' ); ?></small>
										<div class="ascm-panels-recentposts-itemsperrowlrg-cont ascm-panels-radio-btn-v1" style="margin-top: 5px;">
											<input type="radio" id="ascm-panels-recentposts-itemsperrowlrg-fourperrow" name="ascm-panels-recentposts-itemsperrowlrg" value="fourperrow" <?php checked( $ascm_panels_recentposts_itemsperrowlrg, 'fourperrow' ); ?>>
											<label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-recentposts-itemsperrowlrg-fourperrow"><?php _e( 'Four Per Row', 'ascm' ); ?></label>
											
											<input type="radio" id="ascm-panels-recentposts-itemsperrowlrg-threeperrow" name="ascm-panels-recentposts-itemsperrowlrg" value="threeperrow" <?php checked( $ascm_panels_recentposts_itemsperrowlrg, 'threeperrow' ); ?>>
											<label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-recentposts-itemsperrowlrg-threeperrow"><?php _e( 'Three Per Row', 'ascm' ); ?></label>
											
											<input type="radio" id="ascm-panels-recentposts-itemsperrowlrg-twoperrow" name="ascm-panels-recentposts-itemsperrowlrg" value="twoperrow" <?php checked( $ascm_panels_recentposts_itemsperrowlrg, 'twoperrow' ); ?>>
											<label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-recentposts-itemsperrowlrg-twoperrow"><?php _e( 'Two Per Row', 'ascm' ); ?></label>

											<input type="radio" id="ascm-panels-recentposts-itemsperrowlrg-oneperrow" name="ascm-panels-recentposts-itemsperrowlrg" value="oneperrow" <?php checked( $ascm_panels_recentposts_itemsperrowlrg, 'oneperrow' ); ?>>
											<label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-recentposts-itemsperrowlrg-oneperrow"><?php _e( 'One Per Row', 'ascm' ); ?></label>
										</div>
									</div>
									<div class="ascm-container-padding ascm-field-col s12 m6 l6">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Items Per Row (Medium Screen)', 'ascm' ); ?></div>
										<small><?php _e( 'Select number of items in every row on a medium screen.', 'ascm' ); ?></small>
										<div class="ascm-panels-recentposts-itemsperrowmed-cont ascm-panels-radio-btn-v1" style="margin-top: 5px;">
											<input type="radio" id="ascm-panels-recentposts-itemsperrowmed-twoperrow" name="ascm-panels-recentposts-itemsperrowmed" value="twoperrow" <?php checked( $ascm_panels_recentposts_itemsperrowmed, 'twoperrow' ); ?>>
											<label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-recentposts-itemsperrowmed-twoperrow"><?php _e( 'Two Per Row', 'ascm' ); ?></label>

											<input type="radio" id="ascm-panels-recentposts-itemsperrowmed-oneperrow" name="ascm-panels-recentposts-itemsperrowmed" value="oneperrow" <?php checked( $ascm_panels_recentposts_itemsperrowmed, 'oneperrow' ); ?>>
											<label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-recentposts-itemsperrowmed-oneperrow"><?php _e( 'One Per Row', 'ascm' ); ?></label>
											
										</div>
									</div>
								</div>
								<!--========================= Recent Posts recipe extra settings =========================-->

                                <!--========================= Tile Menu recipe extra settings =========================-->
                                <div id="ascm-panels-tilemenu" class="ascm-container ascm-panels-extrasettings-cont">
                                    <div class="ascm-container-padding ascm-field-col s12 m12 l12">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Menus', 'ascm' ); ?></div>
                                        <small><?php _e( 'Each menu item in the selected menu will become a tile, with the featured image of the page as background image.', 'ascm' ); ?></small>
                                        <select id="ascm-panels-tilemenu-navmenu" name="ascm-panels-tilemenu-navmenu" style="margin-top: 5px;">
                                            <option value="" <?php selected( '', $ascm_panels_tilemenu_navmenu ); ?>><?php _e( 'Menus', 'ascm' ); ?>None</option>
											<?php foreach($nav_menus as $key => $value ):
												$nav_menu_id = isset($value->term_id) ? $value->term_id : '';
												$nav_menu_name = isset($value->name) ? $value->name : '';
												?>

                                                <option value="<?php esc_html_e( $nav_menu_id, 'ascm' ); ?>" <?php selected( $nav_menu_id, $ascm_panels_tilemenu_navmenu ); ?>><?php esc_html_e( $nav_menu_name, 'ascm' ); ?></option>

											<?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Items Per Row (Large Screen)', 'ascm' ); ?></div>
                                        <small><?php _e( 'Select number of items in every row on a large screen.', 'ascm' ); ?></small>
                                        <div class="ascm-panels-tilemenu-itemsperrowlrg-cont ascm-panels-radio-btn-v1" style="margin-top: 5px;">
                                            <input type="radio" id="ascm-panels-tilemenu-itemsperrowlrg-fourperrow" name="ascm-panels-tilemenu-itemsperrowlrg" value="fourperrow" <?php checked( $ascm_panels_tilemenu_itemsperrowlrg, 'fourperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-tilemenu-itemsperrowlrg-fourperrow"><?php _e( 'Four Per Row', 'ascm' ); ?></label>

                                            <input type="radio" id="ascm-panels-tilemenu-itemsperrowlrg-threeperrow" name="ascm-panels-tilemenu-itemsperrowlrg" value="threeperrow" <?php checked( $ascm_panels_tilemenu_itemsperrowlrg, 'threeperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-tilemenu-itemsperrowlrg-threeperrow"><?php _e( 'Three Per Row', 'ascm' ); ?></label>

                                            <input type="radio" id="ascm-panels-tilemenu-itemsperrowlrg-twoperrow" name="ascm-panels-tilemenu-itemsperrowlrg" value="twoperrow" <?php checked( $ascm_panels_tilemenu_itemsperrowlrg, 'twoperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-tilemenu-itemsperrowlrg-twoperrow"><?php _e( 'Two Per Row', 'ascm' ); ?></label>

                                            <input type="radio" id="ascm-panels-tilemenu-itemsperrowlrg-oneperrow" name="ascm-panels-tilemenu-itemsperrowlrg" value="oneperrow" <?php checked( $ascm_panels_tilemenu_itemsperrowlrg, 'oneperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-tilemenu-itemsperrowlrg-oneperrow"><?php _e( 'One Per Row', 'ascm' ); ?></label>
                                        </div>
                                    </div>
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Items Per Row (Medium Screen)', 'ascm' ); ?></div>
                                        <small><?php _e( 'Select number of items in every row on a medium screen.', 'ascm' ); ?></small>
                                        <div class="ascm-panels-tilemenu-itemsperrowmed-cont ascm-panels-radio-btn-v1" style="margin-top: 5px;">
                                            <input type="radio" id="ascm-panels-tilemenu-itemsperrowmed-twoperrow" name="ascm-panels-tilemenu-itemsperrowmed" value="twoperrow" <?php checked( $ascm_panels_tilemenu_itemsperrowmed, 'twoperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-tilemenu-itemsperrowmed-twoperrow"><?php _e( 'Two Per Row', 'ascm' ); ?></label>

                                            <input type="radio" id="ascm-panels-tilemenu-itemsperrowmed-oneperrow" name="ascm-panels-tilemenu-itemsperrowmed" value="oneperrow" <?php checked( $ascm_panels_tilemenu_itemsperrowmed, 'oneperrow' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-tilemenu-itemsperrowmed-oneperrow"><?php _e( 'One Per Row', 'ascm' ); ?></label>

                                        </div>
                                    </div>
                                </div>
                                <!--========================= Title Menu recipe extra settings =========================-->

                                <!--========================= Video recipe extra settings =========================-->
                                <div id="ascm-panels-video" class="ascm-container ascm-panels-extrasettings-cont">
                                    <div class="ascm-container-padding ascm-field-col s12 m12 l12">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Video Embed Code', 'ascm' ); ?></div>
                                        <small><?php _e( 'Provide the embed code of the video here.', 'ascm' ); ?></small>
                                        <div style="margin-top: 5px;">
                                            <textarea id="ascm-panels-video-videoembedcode" name="ascm-panels-video-videoembedcode" class="ascm-panels-video-videoembedcode"><?php echo $ascm_panels_video_videoembedcode; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--========================= Video recipe extra settings =========================-->

                                <!--========================= With Image recipe extra settings =========================-->
                                <div id="ascm-panels-withimage" class="ascm-container ascm-panels-extrasettings-cont">
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Image', 'ascm' ); ?></div>
                                        <small><?php _e( 'This will be the image that will be rendered beside the content half of the panel.', 'ascm' ); ?></small>
                                        <div class="ascm-image-uploader" style="margin-top: 5px;">
                                            <div class="image-preview-wrapper">
												<?php if(!empty($ascm_panels_withimage_image)) : ?>
                                                    <img id='ascm-panels-withimage-image-preview' src="<?php echo wp_get_attachment_url($ascm_panels_withimage_image); ?>" width='150' height='100' style='max-height: 100px; width: 150px;'>
												<?php else : ?>
                                                    <img id='ascm-panels-withimage-image-preview' src="<?php echo 'https://via.placeholder.com/600x400';?>" width='150' height='100' style='max-height: 100px; width: 150px;'>
												<?php endif; ?>
                                            </div>
                                            <div class="image-buttons-wrapper">
                                                <input id="ascm_panels_withimage_image_button" type="button" class="ascm-image-uploader-uploadbtn button" value="<?php _e( 'Upload image' ); ?>" />
                                                <input id="ascm_panels_withimage_image_clearbtn" type="button" class="ascm-image-uploader-clearbtn button" value="<?php _e( 'Clear image' ); ?>" />
                                            </div>
                                            <input type='hidden' id='ascm-panels-withimage-image' name='ascm-panels-withimage-image' value="<?php echo $ascm_panels_withimage_image;?>">
                                        </div>
                                    </div>
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Image Position', 'ascm' ); ?></div>
                                        <small><?php _e( 'Select the desired position of the image.', 'ascm' ); ?></small>
                                        <div class="ascm-panels-withimage-imageposition-cont ascm-panels-radio-btn-v1" style="margin-top: 5px;">
                                            <input type="radio" id="ascm-panels-withimage-imageposition-left" name="ascm-panels-withimage-imageposition" value="left" <?php checked( $ascm_panels_withimage_imageposition, 'left' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-withimage-imageposition-left"><?php _e( 'Left', 'ascm' ); ?></label>

                                            <input type="radio" id="ascm-panels-withimage-imageposition-right" name="ascm-panels-withimage-imageposition" value="right" <?php checked( $ascm_panels_withimage_imageposition, 'right' ); ?>>
                                            <label class="ascm-panels-prioritymetabox-radionlabel" for="ascm-panels-withimage-imageposition-right"><?php _e( 'Right', 'ascm' ); ?></label>
                                        </div>
                                    </div>
                                    <div class="ascm-container-padding ascm-field-col s12 m6 l6">
                                        <div class="ascm-panels-prioritymetabox-label"><?php _e( 'Wrap Image With Content', 'ascm' ); ?></div>
                                        <div class="ascm-onoffswitch">
                                            <input type="checkbox" name="ascm-panels-withimage-wrapimagewithcont" class="ascm-onoffswitch-checkbox" id="ascm-panels-withimage-wrapimagewithcont" <?php echo $ascm_panels_withimage_wrapimagewithcont_status; ?>>
                                            <label class="ascm-onoffswitch-label" for="ascm-panels-withimage-wrapimagewithcont">
                                                <span class="ascm-onoffswitch-inner"></span>
                                                <span class="ascm-onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ascm-main-content-mod-field-note"><small><b>Note: </b> <?php _e( 'Switching this field <b>ON</b> will wrap the image with the content of panel. Please make sure not to put any container like <b>div</b> on the content to properly apply the wrap content on image functionality.', 'ascm' ); ?></small></div>
                                    </div>
                                </div>
                                <!--========================= With Image recipe extra settings =========================-->

                            </div>
						</article>

						<article id="ascm-panel-calltoaction" class="ascm-panels-content-entry">
							<div class="ascm-panels-article-title"><?php _e( 'Call to Action', 'ascm' ); ?></div>
							<div class="ascm-panels-accordion-content">
								<div class="ascm-container">
									<div class="ascm-container-padding ascm-field-col s12 m12 l12">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Destination URL', 'ascm' ); ?></div>
										<input type="text" name="ascm-panels-cta-url" class="ascm-panels-prioritymetabox-input" value="<?php echo $ascm_panels_cta_url; ?>">
										<div class="ascm-main-content-mod-field-note"><small><b>Note: </b> <?php _e( 'The call to action functionality highly depends on this field. If this field is empty, all call to action functionality will be disabled.', 'ascm' ); ?></small></div>
									</div> 
									<div class="ascm-container-padding ascm-field-col s12 m6 l6">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Wrap panel with action (Optional)', 'ascm' ); ?></div>
										<div class="ascm-onoffswitch">
										    <input type="checkbox" name="ascm-panels-cta-wrapppanel" class="ascm-onoffswitch-checkbox" id="ascm-panels-cta-wrapppanel" <?php echo $ascm_panels_cta_wrapppanel_status; ?>>
										    <label class="ascm-onoffswitch-label" for="ascm-panels-cta-wrapppanel">
										        <span class="ascm-onoffswitch-inner"></span>
										        <span class="ascm-onoffswitch-switch"></span>
										    </label>
										</div>
										<div class="ascm-main-content-mod-field-note"><small><b>Note: </b> <?php _e( 'Switching this field <b>ON</b> will wrap the action to the content of the panel which will redirect the visitor to the destination URL provided. This option will only work on the <b>Default</b>, <b>Half Image</b> and <b>With Image</b> Recipes.', 'ascm' ); ?></small></div>
									</div>
									<div class="ascm-container-padding ascm-field-col s12 m6 l6">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Action Text (Optional)', 'ascm' ); ?></div>
										<input type="text" name="ascm-panels-cta-btntext" class="ascm-panels-prioritymetabox-input" value="<?php echo $ascm_panels_cta_btntext; ?>">
										<div class="ascm-main-content-mod-field-note"><small><b>Note: </b> <?php _e( 'Providing a text value on this field will automatically generate a redirect button which redirects the visitor to the destination URL provided.', 'ascm' ); ?></small></div>
									</div>
								</div>
							</div>
						</article>

						<article id="ascm-panel-background" class="ascm-panels-content-entry">
							<div class="ascm-panels-article-title"><?php _e( 'Background', 'ascm' ); ?></div>
							<div class="ascm-panels-accordion-content">
								<div class="ascm-container">
									<div class="ascm-container-padding ascm-field-col s12 m12 l12">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Background Image Opacity', 'ascm' ); ?></div>
										<div class="ascm-rangeslider" append-char=" %">
											<div class="ascm-rangeslider-slider-cont">
												<input id="ascm-panels-bg-img-opcty" name="ascm-panels-bg-img-opcty" type="range" min="0" max="100" step="10" value="<?php echo $ascm_panels_bg_img_opcty; ?>" class="slider"/>
											</div>
											<span id="ascm-panels-bg-img-opcty-rangeslider-info" class="ascm-rangeslider-info"></span>
										</div>
										<small><b>Note: </b> <?php _e( 'Featured image of this panel will be used as background image.', 'ascm' ); ?></small>
									</div>
									<div class="ascm-container-padding ascm-field-col s12 m6 l6">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Background Image Anchor (Horizontal)', 'ascm' ); ?></div>
										<div class="ascm-panels-bg-img-anchor-radio-cont">
											<input type="radio" name="ascm-panels-bg-img-anchor-hor" id="ascm-panels-bg-img-anchor-hor-left" value="left" <?php checked( $ascm_panels_bg_img_anchor_hor, 'left' ); ?>>
											<label for="ascm-panels-bg-img-anchor-hor-left">
												<span><?php _e( 'Left', 'ascm' ); ?></span>
												<img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/bg-img-position/horizontal-left.png';?>">
											</label>

											<input type="radio" name="ascm-panels-bg-img-anchor-hor" id="ascm-panels-bg-img-anchor-hor-25%" value="25%" <?php checked( $ascm_panels_bg_img_anchor_hor, '25%' ); ?>>
											<label for="ascm-panels-bg-img-anchor-hor-25%">
												<span><?php _e( '25%', 'ascm' ); ?></span>
												<img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/bg-img-position/horizontal-25.png';?>">
											</label>

											<input type="radio" name="ascm-panels-bg-img-anchor-hor" id="ascm-panels-bg-img-anchor-hor-center" value="center" <?php checked( $ascm_panels_bg_img_anchor_hor, 'center' ); ?>>
											<label for="ascm-panels-bg-img-anchor-hor-center">
												<span><?php _e( 'Center', 'ascm' ); ?></span>
												<img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/bg-img-position/horizontal-center.png';?>">
											</label>

											<input type="radio" name="ascm-panels-bg-img-anchor-hor" id="ascm-panels-bg-img-anchor-hor-75%" value="75%" <?php checked( $ascm_panels_bg_img_anchor_hor, '75%' ); ?>>
											<label for="ascm-panels-bg-img-anchor-hor-75%">
												<span><?php _e( '75%', 'ascm' ); ?></span>
												<img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/bg-img-position/horizontal-75.png';?>">
											</label>

											<input type="radio" name="ascm-panels-bg-img-anchor-hor" id="ascm-panels-bg-img-anchor-hor-right" value="right" <?php checked( $ascm_panels_bg_img_anchor_hor, 'right' ); ?>>
											<label for="ascm-panels-bg-img-anchor-hor-right">
												<span><?php _e( 'Right', 'ascm' ); ?></span>
												<img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/bg-img-position/horizontal-right.png';?>">
											</label>
										</div>	
									</div>
									<div class="ascm-container-padding ascm-field-col s12 m6 l6">
										<div class="ascm-panels-prioritymetabox-label">Background Image Anchor (Vertical)</div>
										<div class="ascm-panels-bg-img-anchor-radio-cont">
											<input type="radio" name="ascm-panels-bg-img-anchor-ver" id="ascm-panels-bg-img-anchor-ver-top" value="top" <?php checked( $ascm_panels_bg_img_anchor_ver, 'top' ); ?>>
											<label for="ascm-panels-bg-img-anchor-ver-top">
												<span><?php _e( 'Top', 'ascm' ); ?></span>
												<img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/bg-img-position/vertical-top.png';?>">
											</label>

											<input type="radio" name="ascm-panels-bg-img-anchor-ver" id="ascm-panels-bg-img-anchor-ver-25%" value="25%" <?php checked( $ascm_panels_bg_img_anchor_ver, '25%' ); ?>>
											<label for="ascm-panels-bg-img-anchor-ver-25%">
												<span><?php _e( '25%', 'ascm' ); ?></span>
												<img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/bg-img-position/vertical-25.png';?>">
											</label>

											<input type="radio" name="ascm-panels-bg-img-anchor-ver" id="ascm-panels-bg-img-anchor-ver-center" value="center" <?php checked( $ascm_panels_bg_img_anchor_ver, 'center' ); ?>>
											<label for="ascm-panels-bg-img-anchor-ver-center">
												<span><?php _e( 'Center', 'ascm' ); ?></span>
												<img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/bg-img-position/vertical-center.png';?>">
											</label>

											<input type="radio" name="ascm-panels-bg-img-anchor-ver" id="ascm-panels-bg-img-anchor-ver-75%" value="75%" <?php checked( $ascm_panels_bg_img_anchor_ver, '75%' ); ?>>
											<label for="ascm-panels-bg-img-anchor-ver-75%">
												<span><?php _e( '75%', 'ascm' ); ?></span>
												<img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/bg-img-position/vertical-75.png';?>">
											</label>

											<input type="radio" name="ascm-panels-bg-img-anchor-ver" id="ascm-panels-bg-img-anchor-ver-bottom" value="bottom" <?php checked( $ascm_panels_bg_img_anchor_ver, 'bottom' ); ?>>
											<label for="ascm-panels-bg-img-anchor-ver-bottom">
												<span><?php _e( 'Bottom', 'ascm' ); ?></span>
												<img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/bg-img-position/vertical-bottom.png';?>">
											</label>
										</div>		
									</div>
									<div class="ascm-container-padding ascm-field-col s12 m12 l12">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Background Colour', 'ascm' ); ?></div>
										<div id="color-picker">
			                                <?php if(has_action('genesis_init') && function_exists('wfcg_get_theme_mod')): ?>
                                            <div class="ascm-simplecolorpicker" simplecolorpicker-name="ascm-panels-bg-clr" simplecolorpicker-value="<?php echo $ascm_panels_bg_clr; ?>" simplecolorpicker-colors="<?php echo $themecolors; ?>"></div>
			                                <?php else: ?>
                                            <div class="ascm-simplecolorpicker" simplecolorpicker-name="ascm-panels-bg-clr" simplecolorpicker-value="<?php echo $ascm_panels_bg_clr; ?>" simplecolorpicker-colors="not_wfc_genesis"></div>
			                                <?php endif; ?>
                                        </div>
									</div>
								</div>
							</div>
						</article>

						<article id="ascm-panel-customcss" class="ascm-panels-content-entry">
							<div class="ascm-panels-article-title"><?php _e( 'Custom CSS', 'ascm' ); ?></div>
							<div class="ascm-panels-accordion-content">
								<div class="ascm-container">
									<div id="ascm-panels-outerwrapperclass-maincont" class="ascm-field-col s12 m6 l6">
										<div id="ascm-panels-outerwrapperclass-subcont" class="ascm-container-padding">
											<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Outer Wrapper Class (Optional)', 'ascm' ); ?></div>
											<input type="text" name="ascm-panels-outerwrapclass" class="ascm-panels-prioritymetabox-input" value="<?php echo $ascm_panels_outerwrapclass; ?>">
										</div>
									</div>
									<div id="ascm-panels-innerwrapperclass-maincont" class="ascm-field-col s12 m6 l6">
										<div id="ascm-panels-innerwrapperclass-subcont" class="ascm-container-padding">
											<div class="ascm-panels-prioritymetabox-label"><?php _e( 'Inner Wrapper Class (Optional)', 'ascm' ); ?></div>
											<input type="text" name="ascm-panels-innerwrapclass" class="ascm-panels-prioritymetabox-input" value="<?php echo $ascm_panels_innerwrapclass; ?>">
										</div>
									</div>
									<div class="ascm-container-padding ascm-field-col s12 m12 l12">
										<div class="ascm-panels-prioritymetabox-label"><?php _e( 'CSS (Optional)', 'ascm' ); ?></div>
										<small><?php _e( 'Your CSS code will be placed in a Style Block', 'ascm' ); ?></small>
										<div style="margin-top: 5px;">
											<textarea id="ascm-panels-csscode" name="ascm-panels-csscode" class="ascm-panels-csscode"><?php echo $ascm_panels_csscode; ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</article>

					</div>

				</div>
			</div>
			<?php
		}
	}
	
	/**
	 * This function handles the save post for panels meta data
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $post_id
	 *
	 * @LastUpdated   April 5, 2019
	 */
	public function save_panels_options($post_id){

		if (get_post_type($post_id) == 'ascm_panels' && isset($_POST['ascm-panels-nonce']) && $_POST['ascm-panels-nonce'] == 'ascm-panels-savepost') {
            
			$default_recipe = isset($_POST['ascm-panels-default-recipe']) ? $_POST['ascm-panels-default-recipe'] : '';

			// Main Option
			$ascm_panels_panelascontent = isset($_POST['ascm-panels-panelascontent']) ? $_POST['ascm-panels-panelascontent'] : 'off';

			// Settings
			$ascm_panels_hidetitle = isset($_POST['ascm-panels-hidetitle']) ? $_POST['ascm-panels-hidetitle'] : 'off';
			$ascm_panels_displayclildrenas = isset($_POST['ascm-panels-displayclildrenas']) ? $_POST['ascm-panels-displayclildrenas'] : 'donothing';
			$ascm_panels_displaytype = isset($_POST['ascm-panels-displaytype']) ? $_POST['ascm-panels-displaytype'] : 'fullwdth';

			//  Recipes
			$ascm_panels_recipe = isset($_POST['ascm-panels-recipe']) ? $_POST['ascm-panels-recipe'] : $default_recipe;
			$ascm_panels_recipe = ($ascm_panels_displayclildrenas != 'donothing') ? $default_recipe : $ascm_panels_recipe;
			$ascm_panels_card_overwrite = isset($_POST['ascm-panels-card-overwrite']) ? $_POST['ascm-panels-card-overwrite'] : $default_recipe;
			
			// Half Image Recipe
			$ascm_panels_halfimage_image = isset($_POST['ascm-panels-halfimage-image']) ? $_POST['ascm-panels-halfimage-image'] : '';
			$ascm_panels_halfimage_imageposition = isset($_POST['ascm-panels-halfimage-imageposition']) ? $_POST['ascm-panels-halfimage-imageposition'] : 'left';
			$ascm_panels_halfimage_containedimage = isset($_POST['ascm-panels-halfimage-containedimage']) ? $_POST['ascm-panels-halfimage-containedimage'] : 'off';

			// Post Gallery Recipe
			$ascm_panels_postgallery_posttype = isset($_POST['ascm-panels-postgallery-posttype']) ? $_POST['ascm-panels-postgallery-posttype'] : '';
			$ascm_panels_postgallery_maxnumofitems = isset($_POST['ascm-panels-postgallery-maxnumofitems']) ? $_POST['ascm-panels-postgallery-maxnumofitems'] : '9';
			$ascm_panels_postgallery_orderby = isset($_POST['ascm-panels-postgallery-orderby']) ? $_POST['ascm-panels-postgallery-orderby'] : 'post_title';
			$ascm_panels_postgallery_sortorder = isset($_POST['ascm-panels-postgallery-sortorder']) ? $_POST['ascm-panels-postgallery-sortorder'] : 'DESC';
			$ascm_panels_postgallery_itemsperrowlrg = isset($_POST['ascm-panels-postgallery-itemsperrowlrg']) ? $_POST['ascm-panels-postgallery-itemsperrowlrg'] : 'fourperrow';
			$ascm_panels_postgallery_itemsperrowmed = isset($_POST['ascm-panels-postgallery-itemsperrowmed']) ? $_POST['ascm-panels-postgallery-itemsperrowmed'] : 'twoperrow';

			// Recent Posts Recipe
			$ascm_panels_recentposts_category = isset($_POST['ascm-panels-recentposts-category']) ? $_POST['ascm-panels-recentposts-category'] : '';
			$ascm_panels_recentposts_maxnumofitems = isset($_POST['ascm-panels-recentposts-maxnumofitems']) ? $_POST['ascm-panels-recentposts-maxnumofitems'] : '9';
			$ascm_panels_recentposts_itemsperrowlrg = isset($_POST['ascm-panels-recentposts-itemsperrowlrg']) ? $_POST['ascm-panels-recentposts-itemsperrowlrg'] : 'fourperrow';
			$ascm_panels_recentposts_itemsperrowmed = isset($_POST['ascm-panels-recentposts-itemsperrowmed']) ? $_POST['ascm-panels-recentposts-itemsperrowmed'] : 'twoperrow';

			//Tile Menu Recipe
			$ascm_panels_tilemenu_navmenu = isset($_POST['ascm-panels-tilemenu-navmenu']) ? $_POST['ascm-panels-tilemenu-navmenu'] : '';
			$ascm_panels_tilemenu_itemsperrowlrg = isset($_POST['ascm-panels-tilemenu-itemsperrowlrg']) ? $_POST['ascm-panels-tilemenu-itemsperrowlrg'] : 'fourperrow';
			$ascm_panels_tilemenu_itemsperrowmed = isset($_POST['ascm-panels-tilemenu-itemsperrowmed']) ? $_POST['ascm-panels-tilemenu-itemsperrowmed'] : 'twoperrow';

			//Video Menu Recipe
			$ascm_panels_video_videoembedcode = isset($_POST['ascm-panels-video-videoembedcode']) ? $_POST['ascm-panels-video-videoembedcode'] : '';

			// With Image Recipe
			$ascm_panels_withimage_image = isset($_POST['ascm-panels-withimage-image']) ? $_POST['ascm-panels-withimage-image'] : '';
			$ascm_panels_withimage_imageposition = isset($_POST['ascm-panels-withimage-imageposition']) ? $_POST['ascm-panels-withimage-imageposition'] : 'left';
			$ascm_panels_withimage_wrapimagewithcont = isset($_POST['ascm-panels-withimage-wrapimagewithcont']) ? $_POST['ascm-panels-withimage-wrapimagewithcont'] : 'off';


			// Call to Action
			$ascm_panels_cta_url = isset($_POST['ascm-panels-cta-url']) ? $_POST['ascm-panels-cta-url'] : '';
			$ascm_panels_cta_url = ($ascm_panels_displayclildrenas != 'donothing') ? '' : $ascm_panels_cta_url;
			$ascm_panels_cta_wrapppanel = isset($_POST['ascm-panels-cta-wrapppanel']) ? $_POST['ascm-panels-cta-wrapppanel'] : 'off';
			$ascm_panels_cta_wrapppanel = ($ascm_panels_displayclildrenas != 'donothing') ? 'off' : $ascm_panels_cta_wrapppanel;
			$ascm_panels_cta_btntext = isset($_POST['ascm-panels-cta-btntext']) ? $_POST['ascm-panels-cta-btntext'] : '';
			$ascm_panels_cta_btntext = ($ascm_panels_displayclildrenas != 'donothing') ? '' : $ascm_panels_cta_btntext;

			// Background
			$ascm_panels_bg_img_opcty = isset($_POST['ascm-panels-bg-img-opcty']) ? $_POST['ascm-panels-bg-img-opcty'] : '100';
			$ascm_panels_bg_img_opcty = (Int)$ascm_panels_bg_img_opcty / 100;
			$ascm_panels_bg_img_opcty = (String)$ascm_panels_bg_img_opcty;
			$ascm_panels_bg_img_anchor_hor = isset($_POST['ascm-panels-bg-img-anchor-hor']) ? $_POST['ascm-panels-bg-img-anchor-hor'] : 'center';
			$ascm_panels_bg_img_anchor_ver = isset($_POST['ascm-panels-bg-img-anchor-ver']) ? $_POST['ascm-panels-bg-img-anchor-ver'] : 'center';
			$ascm_panels_bg_clr = isset($_POST['ascm-panels-bg-clr']) ? $_POST['ascm-panels-bg-clr'] : 'transparent';

			// Custom CSS
			$ascm_panels_outerwrapclass = isset($_POST['ascm-panels-outerwrapclass']) ? $_POST['ascm-panels-outerwrapclass'] : '';
			$ascm_panels_innerwrapclass = isset($_POST['ascm-panels-innerwrapclass']) ? $_POST['ascm-panels-innerwrapclass'] : '';
			$ascm_panels_csscode = isset($_POST['ascm-panels-csscode']) ? $_POST['ascm-panels-csscode'] : '';


			// Main Option
			update_post_meta(
	            $post_id,
	            'ascm-panels-panelascontent',
	           	$ascm_panels_panelascontent
	        );

			// Settings
			update_post_meta(
	            $post_id,
	            'ascm-panels-hidetitle',
	           	$ascm_panels_hidetitle
	        );
			update_post_meta(
	            $post_id,
	            'ascm-panels-displayclildrenas',
	           	$ascm_panels_displayclildrenas
	        );
			update_post_meta(
	            $post_id,
	            'ascm-panels-displaytype',
	           	$ascm_panels_displaytype
	        );


			// Recipes
	        update_post_meta(
	            $post_id,
	            'ascm-panels-recipe',
	           	(String)$ascm_panels_recipe
	        );
			update_post_meta(
				$post_id,
				'ascm-panels-recipe-type',
				ASCM_Panels_Helper::get_panelrecipetype($ascm_panels_recipe)
			);
			update_post_meta(
				$post_id,
				'ascm-panels-card-overwrite',
				(String)$ascm_panels_card_overwrite
			);			

	        // Half Image
	        update_post_meta(
	            $post_id,
	            'ascm-panels-halfimage-image',
	           	(String)$ascm_panels_halfimage_image
	        );
	        update_post_meta(
	            $post_id,
	            'ascm-panels-halfimage-imageposition',
	           	(String)$ascm_panels_halfimage_imageposition
	        );
			update_post_meta(
				$post_id,
				'ascm-panels-halfimage-containedimage',
				(String)$ascm_panels_halfimage_containedimage
			);

			// Post Gallery
			update_post_meta(
				$post_id,
				'ascm-panels-postgallery-posttype',
				(String)$ascm_panels_postgallery_posttype
			);
			update_post_meta(
				$post_id,
				'ascm-panels-postgallery-maxnumofitems',
				(String)$ascm_panels_postgallery_maxnumofitems
			);
            update_post_meta(
                $post_id,
                'ascm-panels-postgallery-orderby',
                (String)$ascm_panels_postgallery_orderby
            );
			update_post_meta(
				$post_id,
				'ascm-panels-postgallery-sortorder',
				(String)$ascm_panels_postgallery_sortorder
			);
			update_post_meta(
				$post_id,
				'ascm-panels-postgallery-itemsperrowlrg',
				(String)$ascm_panels_postgallery_itemsperrowlrg
			);
			update_post_meta(
				$post_id,
				'ascm-panels-postgallery-itemsperrowmed',
				(String)$ascm_panels_postgallery_itemsperrowmed
			);

	        // Recent Posts
			update_post_meta(
				$post_id,
				'ascm-panels-recentposts-category',
				(String)$ascm_panels_recentposts_category
			);
	        update_post_meta(
	            $post_id,
	            'ascm-panels-recentposts-maxnumofitems',
	           	(String)$ascm_panels_recentposts_maxnumofitems
	        );
	        update_post_meta(
	            $post_id,
	            'ascm-panels-recentposts-itemsperrowlrg',
	           	(String)$ascm_panels_recentposts_itemsperrowlrg
	        );
	        update_post_meta(
	            $post_id,
	            'ascm-panels-recentposts-itemsperrowmed',
	           	(String)$ascm_panels_recentposts_itemsperrowmed
	        );

			// Tile Menu
			update_post_meta(
				$post_id,
				'ascm-panels-tilemenu-navmenu',
				(String)$ascm_panels_tilemenu_navmenu
			);
			update_post_meta(
				$post_id,
				'ascm-panels-tilemenu-itemsperrowlrg',
				(String)$ascm_panels_tilemenu_itemsperrowlrg
			);
			update_post_meta(
				$post_id,
				'ascm-panels-tilemenu-itemsperrowmed',
				(String)$ascm_panels_tilemenu_itemsperrowmed
			);
			// Video
			update_post_meta(
				$post_id,
				'ascm-panels-video-videoembedcode',
				(String)$ascm_panels_video_videoembedcode
			);
			// With Image
			update_post_meta(
				$post_id,
				'ascm-panels-withimage-image',
				(String)$ascm_panels_withimage_image
			);
			update_post_meta(
				$post_id,
				'ascm-panels-withimage-imageposition',
				(String)$ascm_panels_withimage_imageposition
			);
			update_post_meta(
				$post_id,
				'ascm-panels-withimage-wrapimagewithcont',
				(String)$ascm_panels_withimage_wrapimagewithcont
			);



			// Call to Action
	        update_post_meta(
	            $post_id,
	            'ascm-panels-cta-url',
	           	$ascm_panels_cta_url
	        );
	        update_post_meta(
	            $post_id,
	            'ascm-panels-cta-wrapppanel',
	           	$ascm_panels_cta_wrapppanel
	        );
	        update_post_meta(
	            $post_id,
	            'ascm-panels-cta-btntext',
	           	$ascm_panels_cta_btntext
	        );

	        // Background
	        update_post_meta(
	            $post_id,
	            'ascm-panels-bg-img-opcty',
	           	$ascm_panels_bg_img_opcty
	        );
	        update_post_meta(
	            $post_id,
	            'ascm-panels-bg-img-anchor-hor',
	           	$ascm_panels_bg_img_anchor_hor
	        );
	        update_post_meta(
	            $post_id,
	            'ascm-panels-bg-img-anchor-ver',
	           	$ascm_panels_bg_img_anchor_ver
	        );
	        update_post_meta(
	            $post_id,
	            'ascm-panels-bg-clr',
	           	$ascm_panels_bg_clr
	        );

	        // Custom CSS
			update_post_meta(
	            $post_id,
	            'ascm-panels-outerwrapclass',
	           	$ascm_panels_outerwrapclass
	        );
	        update_post_meta(
	            $post_id,
	            'ascm-panels-innerwrapclass',
	           	$ascm_panels_innerwrapclass
	        );
			update_post_meta(
	            $post_id,
	            'ascm-panels-csscode',
	           	$ascm_panels_csscode
	        );

			// Update post parent id and menu order
			$ascm_panels_parentpanel = isset($_POST['ascm-panels-parentpanel']) ? $_POST['ascm-panels-parentpanel'] : '';
			$ascm_panels_parentpanel = (Int)$ascm_panels_parentpanel;
			$ascm_panels_parentpanel = ($ascm_panels_displayclildrenas != 'donothing') ? '' : $ascm_panels_parentpanel;
			$ascm_panels_parentmenuorder = isset($_POST['ascm-panels-parentmenuorder']) ? $_POST['ascm-panels-parentmenuorder'] : '';
			$ascm_panels_parentmenuorder = (Int)$ascm_panels_parentmenuorder;
			
			global $wpdb;
    		$rows_affected = $wpdb->query(
			    $wpdb->prepare(
			        "UPDATE {$wpdb->prefix}posts SET post_parent = %d, menu_order = %d WHERE ID = %d",
			        $ascm_panels_parentpanel, $ascm_panels_parentmenuorder, $post_id
			    )
			);
		}
	}

	/**
	 * Function Name: ascm_panel_manager()
	 * Author: Rowelle Gem Daguman <rowelle@alphasys.com.au>
	 * Short Description: Add a Panel Manger settings Page for the Panels
	 * 
	 * @since 1.1.7
	 */
	public function ascm_panel_manager() {
		add_submenu_page( 'edit.php?post_type=ascm_panels', __( 'Panel Manager', 'ascm' ), __( 'Panel Manager', 'ascm' ), 'manage_options', 'ascm-panel-manager', array( $this, 'ascm_get_panel_manager' ) );
	}

	/**
	 * Function Name: ascm_get_panel_manager()
	 * Author: Rowelle Gem Daguman <rowelle@alphasys.com.au>
	 * Short Description: Get the Panel Manager Page Template
	 * 
	 * since 1.1.7
	 */
	public function ascm_get_panel_manager() {
		wp_enqueue_style( 'ascm-admin-css' );
		wp_enqueue_style( 'ascm-panels-admin-css' );
		wp_enqueue_script( 'ascm-admin-js' );
		wp_enqueue_script( 'ascm-panels-admin-js' );
		wp_enqueue_script('ascm-sortable-js');
		wp_enqueue_style('ascm-animate-css');
		wp_enqueue_style('ascm-grid-system-admin-css');

		$allavailablepages_arr = array();
		$allavailablepages_str = '';
		if (class_exists('ASCM_Panels_Helper')) {
			$allavailablepages = ASCM_Panels_Helper::get_allavailablepages();
			if (!empty($allavailablepages) && is_array($allavailablepages)){
				foreach ($allavailablepages as $key => $value) {
					array_push($allavailablepages_arr , $key);
				}
			}
        }

		if ( has_action( 'genesis_init' ) == false ) {
            $genesis_detected = false;
        } else {
			$genesis_detected = true;
        }

		wp_localize_script( 
			'ascm-panels-admin-js', 
			'ascm_modsettings_panels_param', 
			array(
				'url'     	 => admin_url('admin-ajax.php'),
				'plugin_url' => trailingslashit( plugin_dir_url( __FILE__ ) ),
        		'nonce'      => wp_create_nonce('ajax-nonce'),
        		'allavailablepages_arr' => $allavailablepages_arr,
                'genesis_detected' => $genesis_detected
			)
		);

		include plugin_dir_path( __FILE__ ) . '../../admin/partials/alphasys-content-management-panels.php';
	}
}
new ASCM_PanelsPostType();