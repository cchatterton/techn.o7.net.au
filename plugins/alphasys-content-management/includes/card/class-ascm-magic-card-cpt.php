<?php

/**
 * Class ASCM_Magic_Card_Cpt
 *
 * Register Magic Card as custom post type and added necessarry
 * meta.
 * 
 * @since 1.2.0
 *
 * @author Carl Ortiz
 */
class ASCM_Magic_Card_Cpt {

	/**
	 * CPT slug.
	 * 
	 * @since 1.2.0
	 * 
	 * @var string $pt
	 */
	public $pt = 'ascm-magic-card';

	/**
	 * Function Name: __construct() 
	 * Author: Carl Ortiz
	 * Short Description: Initializes hooks for CPT registration.
	 *
	 * @since 1.2.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_cpt' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'do_meta_boxes', array( $this, 'remove_unnecessary_metaboxes' ) );
		add_action( 'save_post', array( $this, 'save_meta' ) );
	}

	/**
	 * Function Name: enqueue_scripts() 
	 * Author: Carl Ortiz
	 * Short Description: Enqueue styles and scripts in admin side of the
	 * CPT.
	 *
	 * @since 1.2.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'card-cpt', plugin_dir_url( __FILE__ ) . '../../admin/css/admin-card-cpt.css' );
	}

	/**
	 * Function Name: register_cpt() 
	 * Author: Carl Ortiz
	 * Short Description: Register CPT.
	 *
	 * @since 1.2.0
	 */
	public function register_cpt() {

		$labels = array(
			'name'               => _x( 'Magic Cards', 'Post type general name', 'alphasys-content-management' ),
			'singular_name'      => _x( 'Magic Card', 'Post type singular name', 'alphasys-content-management' ),
			'menu_name'          => _x( 'Magic Cards', 'Admin Menu text', 'alphasys-content-management' ),
			'name_admin_bar'     => _x( 'Magic Card', 'Add New on Toolbar', 'alphasys-content-management' ),
			'add_new'            => __( 'Add New', 'alphasys-content-management' ),
			'add_new_item'       => __( 'Add New Magic Card', 'alphasys-content-management' ),
			'new_item'           => __( 'New Magic Card', 'alphasys-content-management' ),
			'edit_item'          => __( 'Edit Magic Card', 'alphasys-content-management' ),
			'view_item'          => __( 'View Magic Card', 'alphasys-content-management' ),
			'all_items'          => __( 'All Magic Cards', 'alphasys-content-management' ),
			'search_items'       => __( 'Search Magic Cards', 'alphasys-content-management' ),
			'parent_item_colon'  => __( 'Parent Magic Cards:', 'alphasys-content-management' ),
			'not_found'          => __( 'No Magic Cards found.', 'alphasys-content-management' ),
			'not_found_in_trash' => __( 'No Magic Cards found in Trash.', 'alphasys-content-management' )
		);

		$args = array(
			'labels'             	=> $labels,
	        'description'        	=> __( 'Description', 'alphasys-content-management' ),
			'public'             	=> true,
			'publicly_queryable' 	=> false,
			'exclude_from_search'	=> true,
			'show_in_menu'       	=> true,
	        'show_in_nav_menus'  	=> false,
	        'show_in_admin_bar'  	=> false,
			'query_var'          	=> true,
			'capability_type'    	=> 'post',
			'has_archive'        	=> true,
			'hierarchical'       	=> true,
			'menu_position'      	=> true,
			'menu_icon'				=> 'dashicons-schedule',
			'supports'           	=> array( 'title', 'author' )
		);

		register_post_type( $this->pt, $args );
	}

	/**
	 * Function Name: add_meta_boxes() 
	 * Author: Carl Ortiz
	 * Short Description: Register meta box for magic card markup.
	 *
	 * @since 1.2.0
	 */
	public function add_meta_boxes() {
		add_meta_box( 'ascm-magic-card-markup', __( 'Markup', 'alphasys-content-management' ), array( $this, 'render_markup_metabox' ), $this->pt, 'normal', 'high' );
	}

	/**
	 * Function Name: remove_unnecessary_metaboxes() 
	 * Author: Carl Ortiz
	 * Short Description: Remove unnecessarry metaboxes.
	 *
	 * @since 1.2.0
	 */
	public function remove_unnecessary_metaboxes() {
		remove_meta_box( 'ascm_bestbefore_scheduleoptions', $this->pt, 'side' );
		remove_meta_box( 'wfc-hero-metabox', $this->pt, 'side' );
	}

	/**
	 * Function Name: render_markup_metabox() 
	 * Author: Carl Ortiz
	 * Short Description: Render metabox that contains markup field.
	 *
	 * @since 1.2.0
	 * 
	 * @param WP_Post $post Current post.
	 */
	public function render_markup_metabox( $post ) {
		$markup_val = get_post_meta( $post->ID, 'ascm_magic_card_markup', true );

		wp_editor( htmlspecialchars_decode( $markup_val ), 'ascm_magic_card_markup', array(
			'wpautop' => false,
			'media_buttons' => false,
			'drag_drop_upload' => false,
			'tinymce' => false
		) );

		wp_nonce_field( 'ascm_magic_card_security', 'ascm_magic_card_meta_nonce' );
	}

	/**
	 * Function Name: save_meta() 
	 * Author: Carl Ortiz
	 * Short Description: Save markup meta.
	 *
	 * @since 1.2.0
	 * 
	 * @param int $post_id Current post ID.
	 */
	public function save_meta( $post_id ) {

		if ( ! isset( $_POST['ascm_magic_card_meta_nonce'] ) || ! wp_verify_nonce( $_POST['ascm_magic_card_meta_nonce'], 'ascm_magic_card_security' ) ) {
			return;
		}

		update_post_meta( $post_id, 'ascm_magic_card_markup', htmlspecialchars( $_POST['ascm_magic_card_markup'] ) );
	}
}

// Immediate initialization.
new ASCM_Magic_Card_Cpt();