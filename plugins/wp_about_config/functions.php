<?php

////////// INCLUDES //////////

function register_config_api() {
	if (test_config('include-api') == true) {
		//$config = get_config('byname', 'activate-api');
		//if ($config['activate-api'] == true || $config['activate-api'] == 't' || $config['activate-api'] == 1 || $config['activate-api'] == 'yes') {
	  add_submenu_page( 'edit.php?post_type=config', 'API', 'API', 'manage_options', 'config-api', 'wp_about_config_api' ); 
	  //include(site_url().'/wp-content/plugins/wp_about_config/api.php');
	}
}
function wp_about_config_api() {
   echo '<h3>WP About Confgi API</h3>';
}
add_action('admin_menu', 'register_config_api');

function include_config_api() {
	if (test_config('include-api') == true) {
		//$config = get_config('byname', 'activate-api');
		//if ($config['activate-api'] == true || $config['activate-api'] == 't' || $config['activate-api'] == 1 || $config['activate-api'] == 'yes') {
	  //add_submenu_page( 'edit.php?post_type=config', 'API', 'API', 'manage_options', 'config-api', 'wp_about_config_api' ); 
	  include_once('api.php');
	}
}
add_action('init', 'include_config_api');

////////// CSS INJECTION //////////

/* function admin_theme_overide(){
  $config_id = get_config_id('wp-admin-css');
  $style_elements = get_config('byparent',$config_id);
  echo '<!-- wp about:config wp-admin-css -->'."\n";
  echo '<style>'."\n";
  echo '#wp-admin-bar-wp-logo > .ab-item .ab-icon, #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {background-image: url('.site_url().'/wp-content/plugins/wp_about_config/logo.png)!important;}';
  foreach ($style_elements as $style) {
  	$css = $style->post_content;
		$css = str_replace(';', '!important;', $css);
  	echo $style->post_title.'{'.$css.'}'."\n";
  }
  //$config = get_config('byname', 'hide-config-row-actions');
  if (test_config('hide-config-row-actions') == true) {
  	//if ($config['hide-config-row-actions'] == true || $config['hide-config-row-actions'] == 't' || $config['hide-config-row-actions'] == 1 || $config['hide-config-row-actions'] == 'yes') {
    echo 'tr.type-config .row-actions {display:none;}';
  }
  echo '</style>'."\n";
}
function css_injection (){
	add_action('admin_head', 'admin_theme_overide');
}
add_action('init', 'css_injection'); */

////////// CALLS & HOOKS //////////

// get_...
// the_...
// echo_...
// test_...

////////// GET functions //////////

// functions:
//- get_config_id($data)
//- get_config($by,$data,$n)

// attributes:
//- $data = config slug
//- $by = 'byname' OR 'bytype' OR 'byparent'

function get_config_id($data){
	global $wpdb;
	unset($results);
	$args=array(
	  'name' => $data,
	  'post_type' => 'config',
	  'post_status' => 'publish',
	  'posts_per_page' => 1,
	);
	$cposts = get_posts($args);
	$results = $cposts[0]->ID;
	return $results;
}

function get_config($by,$data,$n=1){
	global $wpdb;
	unset($results);
	switch ($by) {
		case 'byname':
				$args=array(
			  'name' => $data,
			  'post_type' => 'config',
			  'post_status' => 'publish',
			  'posts_per_page' => $n,
			);
			break;
		case 'bytype':
				$args=array(
			  'tax_query' => array(
					array(
						'taxonomy' => 'config_type',
						'field' => 'slug',
						'terms' => $data
					)
				),
			  'post_type' => 'config',
			  'post_status' => 'publish',
			  'posts_per_page' => $n
			);
			break;
		case 'byparent':
			 $querydetails = "
			   SELECT wposts.*
			   FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
			   WHERE wposts.ID = wpostmeta.post_id
			   AND wpostmeta.meta_key = 'config_parent'
			   AND wpostmeta.meta_value = '$data'
			   AND wposts.post_status = 'publish'
			   AND wposts.post_type = 'config'
			   ORDER BY wposts.post_date DESC
			 ";
			$results = $wpdb->get_results($querydetails, OBJECT);
			break;
		default:
			break;
		}
		if ($by !='byparent' && !$results) {
			$cposts = get_posts($args);
			foreach($cposts as $cpost) {
			$results[$cpost->post_title] = $cpost->post_content;
		} 
	}
	return $results;
}

////////// THE functions //////////

// functions:
//- the_config_id($data,$action)
//- the_config($by,$data,$action)

// attributes:
//- $data = config slug
//- $action = 'echo' OR 'return'

function the_config_id($data,$action='echo'){
	$config_id = get_config_id($data);
	if ($action =='echo') echo $config_id;
	if ($action =='return') return $config_id;
}

function the_config($by,$data,$action='echo') {
	$config = get_config($by,$data);
	if ($action =='echo') echo $config[$data];
	if ($action =='return') return $config[$data];
}

////////// ECHO Functions //////////

// functions:
//- echo_config($by,$data,$before,$after)

// attributes:
//- $by = 'byname' OR 'bytype' OR 'byparent'
//- $data = config slug
//- $before = HTML to inject before
//- $after = HTML to inject after

function echo_config($by,$data,$before='',$after=''){
	$config = get_config($by,$data);
	echo $before;
	echo $config[$data];
	echo $after;
}

////////// TEST Functions //////////

// functions:
//- test_config($name)

// attributes:
//- $data = config slug

function test_config($data) {
	$config = get_config('byname',$data);
	if ($config[$data] === 'true' || $config[$data] === 't' || $config[$data] === 1 || $config[$data] === 'yes') {
		return true;
	} else {
		return false;
	}
}

?>