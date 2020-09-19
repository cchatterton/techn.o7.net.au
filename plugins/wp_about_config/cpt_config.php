<?php 

function my_custom_post_config() {
	$labels = array(
		'name'               => _x( 'Configurables', 'post type general name' ),
		'singular_name'      => _x( 'Configurable', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Configurable' ),
		'add_new_item'       => __( 'Add New Configurable' ),
		'edit_item'          => __( 'Edit Configurable' ),
		'new_item'           => __( 'New Configurable' ),
		'all_items'          => __( 'All Configurables' ),
		'view_item'          => __( 'View Configurables' ),
		'search_items'       => __( 'Search Configurables' ),
		'not_found'          => __( 'No Configurables found' ),
		'not_found_in_trash' => __( 'No Configurables found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Configurables'
	);
	
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our configurables',
		'public'        => true,
		'menu_position' => 20,
 // 'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'supports'      => array( 'title', 'editor' ),
		'has_archive'   => true,
	);
	register_post_type( 'config', $args );	
}

add_action( 'init', 'my_custom_post_config' );

function my_taxonomies_config() {
	$labels = array(
		'name'              => _x( 'Config Type', 'taxonomy general name' ),
		'singular_name'     => _x( 'Config Type', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Config Types' ),
		'all_items'         => __( 'All Config Types' ),
		'parent_item'       => __( 'Parent Config Type' ),
		'parent_item_colon' => __( 'Parent Config Type:' ),
		'edit_item'         => __( 'Edit Config Type' ), 
		'update_item'       => __( 'Update Config Type' ),
		'add_new_item'      => __( 'Add New Config Type' ),
		'new_item_name'     => __( 'New Config Type' ),
		'menu_name'         => __( 'Config Types' ),
	);
	$args = array(
		'labels' => $labels,
		'show_admin_column' => true,
		'hierarchical' => true,
	);
	register_taxonomy( 'config_type', 'config', $args );
}

add_action( 'init', 'my_taxonomies_config', 0 );

// Styling for the custom post type icon

function my_config_icon() { 

	$menu = site_url().'/wp-admin/images/menu.png';
	$icon = site_url().'/wp-admin/images/icons32.png';

	echo '<style type="text/css" media="screen">'."\n";
  echo '	#menu-posts-config .wp-menu-image { background: url('.$menu.') no-repeat 1px -33px!important; }'."\n";
	echo '	#menu-posts-config:hover .wp-menu-image {background: url('.$menu.') no-repeat 1px -1px!important; }'."\n";
	echo '	#icon-edit.icon32-posts-config {background: url('.$icon.') no-repeat -12px -5px;}'."\n";
	echo '  #config_value {width: 50%;}'."\n";
  echo '</style>'."\n";

}

add_action( 'admin_head', 'my_config_icon' );

// Set Messages
function config_updated_messages( $messages ) {
//http://codex.wordpress.org/Function_Reference/register_post_type

  global $post, $post_ID;

  $messages['config'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Configurable updated. Configurable title updated as per slug', 'your_text_domain'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'your_text_domain'),
    3 => __('Custom field deleted.', 'your_text_domain'),
    4 => __('Configurable updated.', 'your_text_domain'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Configurable restored to revision from %s', 'your_text_domain'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Configurable published. <a href="%s">View Configurable</a>', 'your_text_domain'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Configurable saved.', 'your_text_domain'),
    8 => sprintf( __('Configurable submitted. <a target="_blank" href="%s">Preview Configurable</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Configurable scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Configurable</a>', 'your_text_domain'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Configurable draft updated. <a target="_blank" href="%s">Preview Configurable</a>', 'your_text_domain'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'config_updated_messages' );


// Add New Column 
function my_config_columns_head($defaults) {  
    $defaults['config_value'] = 'Config Value';
    $defaults['config_parent'] = 'Parent';  
    $defaults['config_children'] = 'Children';  
    return $defaults;  
}  
  
// Show Data in Column
function my_config_columns_content($column_name, $post_ID) {  
 $null = '<span class="config-col-bg">_</span>';
 $config = get_config('byname','max-config-string-length');

 	// Show config value
  if ($column_name == 'config_value') {  
    echo '<span class="config-edit" title="edit"> </span><span class="config-trash" title="delete"> </span>';
		$my_config_post = get_post($post_ID); 
		if (isset($config['max-config-string-length']) && strlen($my_config_post->post_content)> $config['max-config-string-length']) {
			echo strip_tags(substr($my_config_post->post_content, 0,$config['max-config-string-length']),'<strong><em>').'...';

		} else {
			echo strip_tags($my_config_post->post_content,'<strong><em>');
		}
  }

  // Show config_parent
  if ($column_name == 'config_parent') {  
  	$pid = get_post_meta( $post_ID, 'config_parent', true );
  	if ($pid == '_') {
  		echo $null;
  	} else {
  		$ptitle = get_post( $pid);
  		echo '<span class="config-more config-col-bg" title="'.$ptitle->post_title.'">'.$pid.'</span>';	
  	}
  }

  // Show Children
  if ($column_name == 'config_children') {  
  	$children = get_config('byparent',$post_ID);
  	foreach ($children as $child) {
  		$s .= $child->post_title;
  		$s .= (count($children)>1) ? ', ' :'';
  	}
  	//echo $s; 
  	if (count($children)>0) {
  		echo '<span class="config-more config-col-bg" title="'.$s.'">'.count($children).'</span>';
  	} else {
  		echo $null;
  	}	
  	unset($children);
  }
}
add_filter('manage_config_posts_columns', 'my_config_columns_head');  
add_action('manage_config_posts_custom_column', 'my_config_columns_content', 10, 2);  

function restrict_listings_by_config_type() {
    global $typenow;
    global $wp_query;
    if ($typenow=='config') {
        $taxonomy = 'config_type';
        $config_type_taxonomy = get_taxonomy($taxonomy);
        wp_dropdown_categories(array(
            'show_option_all' =>  __("Show All {$config_type_taxonomy->label}"),
            'taxonomy'        =>  $taxonomy,
            'name'            =>  'Config Types',
            'orderby'         =>  'name',
            'selected'        =>  $wp_query->query['term'],
            'hierarchical'    =>  true,
            'depth'           =>  3,
            'show_count'      =>  true, // Show # listings in parens
            'hide_empty'      =>  true, // Don't show businesses w/o listings
        ));
    }
}
add_action('restrict_manage_posts','restrict_listings_by_config_type');

function save_config_post(){

	if ( ! wp_is_post_revision( $post_id ) ){
	
		// unhook this function so it doesn't loop infinitely
		remove_action('save_post', 'save_config_post');
	
		// update the post, which calls save_post again
		$p1 = get_post();
		//show($p1->ID);
		$terms = wp_get_post_terms( $p1->ID, 'config_type');
		if($p1->post_type == 'config' && !in_array('css', (get_object_vars($terms[0]))) ) {
			$p2['ID'] = $p1->ID;
			$p2['post_title']=$p1->post_name;
			wp_update_post( $p2 );
    }

		// re-hook this function
		add_action('save_post', 'save_config_post');

	}
}
add_action( 'save_post', 'save_config_post' );

// Custom Post Meta
function config_meta_box() {
//http://codex.wordpress.org/Function_Reference/add_meta_box
    add_meta_box( 
        'config_meta_box',
        __( 'Child Of', 'myplugin_textdomain' ),
        'config_meta_box_content', // <- same as funtion name
        'config',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'config_meta_box' );

function config_meta_box_content( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'config_meta_box_content_nonce' ); 

	$args = array( 'post_type' => 'config','numberposts' => 9999,'offset' => 0);
  $configs = get_posts( $args ); 
  //var_dump($subjects);

  // create subject list
  //echo '<div style="display:inline-block;width:100px;text-align:right;padding-right:5px;""><label for"subject">config_parent</label></div>'."\n";
	echo '<select id="config_parent" name="config_parent" style="margin-left:4px; width: 250px;">'."\n";
	$custom_meta_value = get_post_meta( $post->ID, 'config_parent', true );	

	$selected = ($custom_meta_value == '_') ? 'selected' : '';
	echo "\n".'<option value="_" '.$selected.'>_</option>'."\n";

	foreach ($configs as $config) {
		if ($config->post_name != $post->post_name) {
			$selected = ($custom_meta_value == $config->ID) ? 'selected' : '';
			echo "\n".'<option value="'.$config->ID.'" '.$selected.'>'.$config->post_title.'</option>'."\n";
		}
	}
	echo '</select>';
}
add_action( 'save_post', 'config_meta_box_save' );

function config_meta_box_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	return;

	if ( !wp_verify_nonce( $_POST['config_meta_box_content_nonce'], plugin_basename( __FILE__ ) ) )
	return;

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	}

	// save config list
	$custom_meta_value = $_POST['config_parent'];
	update_post_meta( $post_id, 'config_parent', $custom_meta_value );
}

function config_children() {
//http://codex.wordpress.org/Function_Reference/add_meta_box
  $pid = $_GET[post];
  $children = get_config('byparent',$pid);
  $count = count($children);

    add_meta_box( 
        'config_children',
        __( 'Children ('.$count.')', 'myplugin_textdomain' ),
        'config_children_content', // <- same as funtion name
        'config',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'config_children' );

function config_children_content( $post ) {

  	$children = get_config('byparent',$post->ID);
        //echo count($children);
	$s = '<div style="display:table">';
  	foreach ($children as $child) {
		$url = site_url();
		$location = "location.href='$url/post.php?post=$child->ID&action=edit';";
		$s .= '<div class="config_clickable" style="display:table-row;font-size:0.8em;" onclick="'.$location.'">';
		$s .= '<div class="config_clickable" style="display:table-cell;font-size:0.8em;">'.$child->ID.'</div>';
		$s .= '<div class="config_clickable" style="display:table-cell;font-size:0.8em;padding-left:5px;">'.$child->post_title.'</div>';
  		$s .= '</div>';
  	}
  	$s .= '</div>';
	echo $s; 
}

function about_config_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array(
		'parent' => 'wp-logo', // use 'false' for a root menu, or pass the ID of the parent menu
		'id' => 'about_config', // link ID, defaults to a sanitized title value
		'title' => __('About Config'), // link title
		'href' => 'http://techn.com.au', // name of file
		'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
	));
	$wp_admin_bar->add_menu( array(
		'parent' => 'wp-logo', 
		'id' => 'abput_wordpressn', 
		'title' => __('About WordpressN'), 
		'href' => 'http://techn.com.au', 
		'meta' => false 
	));
	$wp_admin_bar->add_menu( array(
		'parent' => 'wp-logo', 
		'id' => 'about_techn', 
		'title' => __('About TECHN'), 
		'href' => 'http://techn.com.au', 
		'meta' => false 
	));
}
add_action( 'wp_before_admin_bar_render', 'about_config_admin_bar' );

?>