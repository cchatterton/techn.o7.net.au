<?php

function cpt_tn_form() {
	$labels = array(
		'name'               => _x( 'Forms', 'post type general name' ), //s
		'singular_name'      => _x( 'Form', 'post type singular name' ),
		'add_new'            => _x( 'New Form', 'Form' ),
		'add_new_item'       => __( 'Add New Form' ),
		'edit_item'          => __( 'Edit Form' ),
		'new_item'           => __( 'New Form' ),
		'all_items'          => __( 'Forms' ), //s
		'view_item'          => __( 'View Forms' ), //s
		'search_items'       => __( 'Search Forms' ), //s
		'not_found'          => __( 'No Forms found' ), //s
		'not_found_in_trash' => __( 'No Forms found in the Trash' ),  //s
		'parent_item_colon'  => '',
		'menu_name'          => 'Forms' //s
	);
	$args = array(
		'labels'        	=> $labels,
		'description'   	=> 'Holds our Forms',
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
	register_post_type( 'tn_forms', $args );	
}
add_action( 'init', 'cpt_tn_form' );

// Styling for the custom post type icon
function cpt_tn_form_icon() { 
	$menu = site_url().'/wp-admin/images/menu.png';
	$icon = site_url().'/wp-admin/images/icons32.png';
	echo '<style type="text/css" media="screen">'."\n";
  echo '	#menu-posts-tn_forms .wp-menu-image { background: url('.$menu.') no-repeat 1px -33px!important; }'."\n";
	echo '	#menu-posts-tn_forms:hover .wp-menu-image {background: url('.$menu.') no-repeat 1px -1px!important; }'."\n";
	echo '	#icon-edit.icon32-posts-tn_forms {background: url('.$icon.') no-repeat -12px -5px;}'."\n";
	echo '  #tn_forms_value {width: 50%;}'."\n";
  echo '</style>'."\n";
}
add_action( 'admin_head', 'cpt_tn_form_icon' );

// Set Messages
function cpt_tn_form_updated_messages( $messages ) {
//http://codex.wordpress.org/Function_Reference/register_post_type
  global $post, $post_ID;
  $messages['tn_forms'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Form updated.', 'your_text_domain'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'your_text_domain'),
    3 => __('Custom field deleted.', 'your_text_domain'),
    4 => __('Form updated.', 'your_text_domain'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Form restored to revision from %s', 'your_text_domain'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Form published. <a href="%s">View Form</a>', 'your_text_domain'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Form saved.', 'your_text_domain'),
    8 => sprintf( __('Form submitted. <a target="_blank" href="%s">Preview Form</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Form scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Form</a>', 'your_text_domain'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Form draft updated. <a target="_blank" href="%s">Preview Form</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'cpt_tn_form_updated_messages' );

?>