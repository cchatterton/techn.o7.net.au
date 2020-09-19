<?php
/**
 * Class ASCM_RepostPostType
 * This class handles the meta data for ASCM Repost.
 *

 * @author Junjie Canonio <junjie@alphasys.com.au>
 *
 * @since  1.0.0
 *
 * @LastUpdated   February 13, 2019
 */
class ASCM_RepostPostType{
	
	/**
	 * ASCM_RepostPostType constructor.
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'ascm_repost_custom_post_type'));
		add_filter( 'manage_ascm_repost_posts_columns', array( $this, "ascm_repost_custom_columns_list"));
		add_action( 'manage_posts_custom_column',  array( $this, "ascm_repost_show_columns"));

		//add_action( 'add_meta_boxes', array($this, 'ascm_repost_hidden_meta_boxes') );
		add_action( 'edit_form_after_title', array( $this, 'ascm_repost_hidden_meta_boxes') );

		add_action( 'edit_form_after_title', array( $this, 'ascm_repost_requiredfields_callback') ); 
		add_action( 'save_post' , array($this, 'ascm_repost_save_postdata') );


		add_filter( 'pre_get_posts' , array($this, 'set_repost_as_blog') , 20);
		add_filter( 'post_type_link' , array($this, 'override_repost_link_url') ,10,2);

		add_action( 'init', array($this, 'create_repost_category') );

		add_action( "category_edit_form", array($this, 'hide_fields_on_category_form') );
		add_action( "category_add_form", array($this, 'hide_ascmrepost_on_category_list') );

		add_filter( 'the_content', array($this, 'insert_extracontents' ), 8 );
	}
	
	/**
	 * This function enqueue scripts and styles for ASCM Repost
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 * @LastUpdated   February 13, 2019
	 */
	public function enqueue_scriptsstyles(){

		wp_enqueue_style( 
			'grid-system-admin', 
			plugin_dir_url( __FILE__ ) . '../../admin/css/grid-system-admin.css', 
			array(), 
			'', 
			'all' 
		);

		wp_enqueue_style( 
			'ascm-repost-css', 
			plugin_dir_url( __FILE__ ) . '../../admin/css/ascm-repost-admin.css', 
			array(), 
			'', 
			'all' 
		);
	}
	
	/**
	 *Registers the Repost custom Post type.
	 */
	public function ascm_repost_custom_post_type() {

		$options = get_option( 'ascm_generaloptions' );
	    $enable_repost = isset( $options['ascm_enable_repost'] ) ? $options['ascm_enable_repost'] : 'off';

	    if ( $enable_repost == 'on' ) {	 
		    $labels = array(
		        'name'                => _x( 'Repost', 'Post Type General Name', 'ascm' ),
		        'singular_name'       => _x( 'Repost', 'Post Type Singular Name', 'ascm' ),
		        'menu_name'           => __( 'Repost', 'ascm' ),
		        'parent_item_colon'   => __( 'Parent Repost', 'ascm' ),
		        'all_items'           => __( 'All Repost', 'ascm' ),
		        'view_item'           => __( 'View Repost', 'ascm' ),
		        'add_new_item'        => __( 'Add New Repost', 'ascm' ),
		        'add_new'             => __( 'Add New', 'ascm' ),
		        'edit_item'           => __( 'Edit Repost', 'ascm' ),
		        'update_item'         => __( 'Update Repost', 'ascm' ),
		        'search_items'        => __( 'Search Repost', 'ascm' ),
		        'not_found'           => __( 'Not Found', 'ascm' ),
		        'not_found_in_trash'  => __( 'Not found in Trash', 'ascm' ),
		    );
		     
		    $args = array(
		        'label'               => __( 'Repost', 'ascm' ),
		        'description'         => __( 'Repost news and reviews', 'ascm' ),
		        'labels'              => $labels,
		        //'taxonomies'          => array('topics', 'category' ),
		        'hierarchical'        => false,
		        'public'              => true,
		        'show_ui'             => true,
		        'show_in_menu'        => true,
		        'show_in_nav_menus'   => false,
		      //  'rewrite'            => array( 'slug' => 'brands' ),
		        'show_in_admin_bar'   => false,
		        'menu_position'       => 5,
		        'menu_icon'			  => 'dashicons-image-rotate',
		        'can_export'          => true,
		        'has_archive'         => true,
		        'exclude_from_search' => true,
		        'publicly_queryable'  => true,
		        'supports'            => array( 'title', 'editor', 'comments', 'excerpt', 'author', 'thumbnail', 'revisions'),
		        'capability_type'     => 'page',
		    );
	     
	    	// Registering your Custom Post Type
	    	register_post_type( 'ascm_repost', $args );
	    }
	 
	}
	
	/**
	 * This will add custom column headers to the default column headers on wordpress list.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $columns
	 *
	 * @return array
	 * @since  1.0.0
     *
     * @LastUpdated   January 29, 2019
	 */
	public function ascm_repost_custom_columns_list($columns) {	    
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
	    $columns['ascm_reposturl']     = 'Repost URL';
	    return $columns;
	}
	
	/**
	 * This will add custom columns of data to the default columns on wordpress  list
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $name
	 *
	 * @return void
	 * @since  1.0.0
     *
     * @LastUpdated   January 29, 2019
	 */
	public function ascm_repost_show_columns($name) {
	    global $post;
	    $ascm_repost_redirecturl = get_post_meta( $post->ID, 'ascm-repost-redirecturl', true );
	    switch ($name) {
	        case 'ascm_reposturl':
	        	echo '<a href="'.$ascm_repost_redirecturl.'">'.$ascm_repost_redirecturl.'</a>';
	    }
	}
	
	/**
	 * This function handles repost hidden meta boxes
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $post
	 *
     * @LastUpdated   April 8, 2019
	 */
	public function ascm_repost_hidden_meta_boxes( $post ) {
		if (isset($post->post_type) && $post->post_type == 'post') {
			$pts = array(
				'post',
			);

			$ascm_repost_term = get_option('ascm-repost-term');
			if (isset($ascm_repost_term['term_id']) && !empty($ascm_repost_term['term_id'])) {
				?>
                <style type="text/css">
                    #category-<?php echo $ascm_repost_term['term_id']; ?>,
                    #editor-post-taxonomies-hierarchical-term-<?php echo $ascm_repost_term['term_id']; ?>,
                    [for=editor-post-taxonomies-hierarchical-term-<?php echo $ascm_repost_term['term_id']; ?>] {
                        display: none;
                    }
                </style>
				<?php
			}
		}
	}
	
	/**
	 * This function handles the registration of meta boxes
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @LastUpdated   February 13, 2019
	 */
	public function ascm_repost_register_meta_boxes() {
	    add_meta_box( 
	    	'ascm_repost_requiredfields', 
	    	__( 'Repost', 'ascm' ),
	    	array( $this, 'ascm_repost_scheduleoptions_callback' ),
	    	'ascm_repost',
	    	'core',
	    	'high' 
	    );
	}
	
	/**
	 * This function is the callback function for 'ascm_bestbefore_scheduleoptions' meta box
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $post
	 *
	 * @LastUpdated   February 13, 2019
	 */
	public function ascm_repost_requiredfields_callback( $post ) {
		if (isset($post->post_type) && $post->post_type == 'ascm_repost') {

			// $categories = wp_get_post_categories($post->ID);
			// print_r($categories);

			$this->enqueue_scriptsstyles();

			$ascm_repost_redirecturl = get_post_meta( $post->ID, 'ascm-repost-redirecturl', true );
			if (empty($ascm_repost_redirecturl)){
				$ascm_repost_redirecturl = get_post_meta( $post->ID, 'ascm_repost_redirecturl', true );
			}

			$ascm_repost_description = get_post_meta( $post->ID, 'ascm-repost-description', true );
			if (empty($ascm_repost_description)){
				$ascm_repost_description = get_post_meta( $post->ID, 'ascm_repost_description', true );
            }

			$ascm_repost_overrideurlredirect = get_post_meta( $post->ID, 'ascm-repost-overrideurlredirect', true );
			$ascm_repost_overrideurlredirect_status = ($ascm_repost_overrideurlredirect == 'on') ? 'checked' : '';

			?>
            <input type="hidden" name="ascm-repost-save-post">
			<div class="ascm-repost-prioritymetabox-main-container">
				<div class="ascm-repost-prioritymetabox-title-container">
					<h2 class="hndle ui-sortable-handle">
						<img id="ascm_logo" src="<?php echo plugin_dir_url( __FILE__ ).'../../images/ascm.png';?>">
						<span><?php _e( 'Repost - Required Fields', 'ascm' ); ?></span>
					</h2>
				</div>
				<div class="ascm-repost-prioritymetabox-sub-container">
					<div class="ascm-container">
						<div class="ascm-container-padding ascm-field-col s12 m12 l12">
							<div class="ascm-repost-prioritymetabox-label"><?php _e( 'Post URL', 'ascm' ); ?></div>
							<input type="url" name="ascm-repost-redirecturl" value="<?php echo $ascm_repost_redirecturl; ?>" required>
						</div>
						<div class="ascm-container-padding ascm-field-col s12 m12 l12">
							<div class="ascm-repost-prioritymetabox-label"><?php _e( 'Override URL Redirection', 'ascm' ); ?></div>
							<div class="ascm-onoffswitch">
							    <input type="checkbox" name="ascm-repost-overrideurlredirect" class="ascm-onoffswitch-checkbox" id="ascm-repost-overrideurlredirect" <?php echo $ascm_repost_overrideurlredirect_status; ?>>
							    <label class="ascm-onoffswitch-label" for="ascm-repost-overrideurlredirect">
							        <span class="ascm-onoffswitch-inner"></span>
							        <span class="ascm-onoffswitch-switch"></span>
							    </label>
							</div>
							<div class="ascm-main-content-mod-field-note"><small><b>Note: </b> <?php _e( 'Switching this field <b>ON</b> will override the permalink redirection of this post and will redirect to the page set on the Post URL field.', 'ascm' ); ?></small></div>
						</div>
                        <div class="ascm-container-padding ascm-field-col s12 m12 l12">
                            <div class="ascm-repost-prioritymetabox-label"><?php _e( 'Post Short Content', 'ascm' ); ?></div>
                            <textarea name="ascm-repost-description"><?php echo $ascm_repost_description; ?></textarea>
                        </div>
					</div>
				</div>

			</div>
			<?php
		}elseif (isset($post->post_type) && $post->post_type == 'post') {
			
		}
	}
	
	/**
	 * This function handles the save post for repost meta data.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $post_id
	 *
	 * @LastUpdated   February 13, 2019
	 */
	public function ascm_repost_save_postdata($post_id){

		$post_type = get_post_type($post_id);
		if ($post_type == 'ascm_repost' && isset($_POST['ascm-repost-save-post'])) {
			
			$ascm_repost_redirecturl = isset($_POST['ascm-repost-redirecturl']) ? $_POST['ascm-repost-redirecturl'] : '';

			$ascm_repost_overrideurlredirect = isset($_POST['ascm-repost-overrideurlredirect']) ? $_POST['ascm-repost-overrideurlredirect'] : 'off';

			$ascm_repost_description = isset($_POST['ascm-repost-description']) ? $_POST['ascm-repost-description'] : '';

			update_post_meta(
	            $post_id,
	            'ascm-repost-redirecturl',
	           	$ascm_repost_redirecturl
	        );
			update_post_meta(
				$post_id,
				'ascm_repost_redirecturl',
				$ascm_repost_redirecturl
			);

	        update_post_meta(
	            $post_id,
	            'ascm-repost-overrideurlredirect',
	           	$ascm_repost_overrideurlredirect
	        );

			update_post_meta(
				$post_id,
				'ascm-repost-description',
				$ascm_repost_description
			);
			update_post_meta(
				$post_id,
				'ascm_repost_description',
				$ascm_repost_description
			);


	       	$term = get_term_by('slug', 'ascm-repost', 'category');
	       	if (isset($term->term_id) && !empty($term->term_id)) {
	       		wp_set_post_categories($post_id, array($term->term_id));
	       	}
		}

	}
	
	/**
	 * This function set Repost custom post type as blog
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $query
	 *
	 * @return mixed
     *
     * @LastUpdated   April 1, 2019
	 */
	public function set_repost_as_blog( $query ) {
		global $wp_query;
		if ( isset( $wp_query ) && ! is_admin() ) {

			if( isset( $wp_query ) && is_category() ) {
			    $post_type = get_query_var('post_type');
			    if($post_type) {
			        $post_type = $post_type;
			    } else {
			        $post_type = array('nav_menu_item', 'post', 'ascm_repost' ); // don't forget nav_menu_item to allow menus to work!
			    }
			    $query->set('post_type',$post_type);
			    return $query;
			} else {

			    if ( isset( $wp_query ) && is_home() && $query->is_main_query() ) {
			        $query->set( 'post_type', array( 'post', 'ascm_repost' ) );
			    }

			}

		}


	    return $query;
	}
	
	/**
	 * This function set Repost link to redirect to external URL
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $permalink
	 * @param $post
	 *
	 * @return string
     *
     * @LastUpdated   April 1, 2019
	 */
	public function override_repost_link_url( $permalink, $post ) {
		
	    if( $post->post_type == 'ascm_repost' ) {
	    	$ascm_repost_redirecturl = get_post_meta( $post->ID, 'ascm-repost-redirecturl', true );
	    	$url  = esc_url( filter_var( $ascm_repost_redirecturl, FILTER_VALIDATE_URL ) );

	    	$ascm_repost_overrideurlredirect = get_post_meta( $post->ID, 'ascm-repost-overrideurlredirect', true );
	
	    	if ($ascm_repost_overrideurlredirect == 'on') {
		        $permalink = $url ? $url : $permalink;    		
	    	}
	    }
	    return $permalink;
	}
	
	/**
	 * Generate Repost post category.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
     *
	 * @LastUpdated   April 1, 2019
	 */
	public function create_repost_category() {
		
		if (current_user_can('administrator')) {
			$term = term_exists( 'ascm-repost', 'category' );
			if ( $term !== 0 && $term !== null ) {
				update_option('ascm-repost-term', $term);
			}else {
				$created_term = wp_insert_term(
				    'External Post',   // the term 
				    'category', // the taxonomy
				    array(
				        'description' => 'These are posts that are from another websites and treated as external post.',
				        'slug'        => 'ascm-repost',
				    )
				);

				update_option('ascm-repost-term', $created_term);
			}
		}

	}
	
	/**
	 * Hides the fields on the category add or edit form,
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
     *
	 * @LastUpdated   April 8, 2019
	 */
	public function hide_fields_on_category_form() {
		if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'category') {
		    echo "<style> .term-slug-wrap, .term-description-wrap { display:none; } </style>";
		}
	}
	
	/**
	 * Hide the ascm-repost category on the category list
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
     *
	 * @LastUpdated   April 8, 2019
	 */
	public function hide_ascmrepost_on_category_list() {

		$ascm_repost_term = get_option('ascm-repost-term');
		if (isset($ascm_repost_term['term_id']) && !empty($ascm_repost_term['term_id'])) {
			echo "<style> #tag-".$ascm_repost_term['term_id']."{ display:none; } </style>";
		}

	}
	
	/**
	 * This function extra contents on the repost custom post type content.
	 *
	 * @author Junjie Canonio <junjie@alphasys.com.au>
	 *
	 * @param $content
	 *
	 * @return string
	 * @since  1.0.0
     *
     * @LastUpdated   April 10, 2019
	 */
    public function insert_extracontents( $content ) {
    	if ( in_the_loop() && is_main_query() ) {
			global $post;
			if ( get_post_type( $post->ID ) != '' && get_post_type( $post->ID ) == 'ascm_repost' ) { 
				$ascm_repost_redirecturl = get_post_meta( $post->ID, 'ascm-repost-redirecturl', true ); 
				$content = $content . '<br><a class="ascm-repost-readmore-repost" href="'.$ascm_repost_redirecturl.'">Read more . . .';
			}elseif( get_post_type( $post->ID ) != '' && get_post_type( $post->ID ) == 'post' ) {
				$content = $content . '<br><a class="ascm-repost-readmore-post" href="'.get_post_permalink( $post->ID ).'">Read more . . .';
			}
		}
		return $content;
    }

}
new ASCM_RepostPostType();