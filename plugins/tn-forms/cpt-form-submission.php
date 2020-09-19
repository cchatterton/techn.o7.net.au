<?php

function cpt_tn_form_submissions() {
	$labels = array(
		'name'               => _x( 'Submissions', 'post type general name' ), //s
		'singular_name'      => _x( 'Submission', 'post type singular name' ),
	//'add_new'            => _x( 'Add New', 'Submission' ),
		'add_new_item'       => __( 'Add New Submission' ),
		'edit_item'          => __( 'Edit Submission' ),
		'new_item'           => __( 'New Submission' ),
		'all_items'          => __( 'Submissions' ), //s
		'view_item'          => __( 'View Submissions' ), //s
		'search_items'       => __( 'Search Submissions' ), //s
		'not_found'          => __( 'No Submissions found' ), //s
		'not_found_in_trash' => __( 'No Submissions found in the Trash' ),  //s
		'parent_item_colon'  => '',
		'menu_name'          => 'Forms' //s
	);
	$args = array(
		'labels'        	=> $labels,
		'description'   	=> 'Holds our Form Submissions',
		'public'        	=> true,
		'show_in_menu'		=> 'edit.php?post_type=tn_forms',
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
	register_post_type( 'tn_submissions', $args );	
}
add_action( 'init', 'cpt_tn_form_submissions' );

// Styling for the custom post type icon
function cpt_tn_form_submissions_icon() { 
	$menu = site_url().'/wp-admin/images/menu.png';
	$icon = site_url().'/wp-admin/images/icons32.png';
	echo '<style type="text/css" media="screen">'."\n";
  echo '	#menu-posts-tn_submissions .wp-menu-image { background: url('.$menu.') no-repeat 1px -33px!important; }'."\n";
	echo '	#menu-posts-tn_submissions:hover .wp-menu-image {background: url('.$menu.') no-repeat 1px -1px!important; }'."\n";
	echo '	#icon-edit.icon32-posts-tn_submissions {background: url('.$icon.') no-repeat -12px -5px;}'."\n";
	echo '  #tn_submissions_value {width: 50%;}'."\n";
  echo '</style>'."\n";
}
add_action( 'admin_head', 'cpt_tn_form_submissions_icon' );

// Add New Column 
// Form ID #
// Count of Submissions

?>