<?php

function cpt_tn_form_data() {
	$labels = array(
		'name'               => _x( 'Data', 'post type general name' ), //s
		'singular_name'      => _x( 'Data', 'post type singular name' ),
	//'add_new'            => _x( 'New Form', 'Form' ),
	//'add_new_item'       => __( 'Add New Form' ),
		'edit_item'          => __( 'Edit Data' ),
		'new_item'           => __( 'New Data' ),
		'all_items'          => __( 'Data' ), //s
		'view_item'          => __( 'View Data' ), //s
		'search_items'       => __( 'Search Data' ), //s
		'not_found'          => __( 'No Data found' ), //s
		'not_found_in_trash' => __( 'No Data found in the Trash' ),  //s
		'parent_item_colon'  => '',
		'menu_name'          => 'Data' //s
	);
	$args = array(
		'labels'        	=> $labels,
		'description'   	=> 'Holds our Data',
		'public'        	=> true,
	//'show_in_menu'		=> 'your-custom-menu-slug.php',
		'menu_position' 	=> 20,
		'show_ui' 				=> true, 
		'query_var' 			=> true,
		'rewrite' 				=> true,
		'capability_type' => 'post',
		'hierarchical' 		=> false,
	//'supports'      	=> array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'supports'      	=> array( 'title', 'editor' ),
		'has_archive'   	=> true
	);
	register_post_type( 'tn_forms_data', $args );	
}
add_action( 'init', 'cpt_tn_form_data' );

?>