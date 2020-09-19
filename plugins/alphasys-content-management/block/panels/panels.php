<?php

function loadASCMPanelsBlock() {
  wp_enqueue_script(
    'ascm-panels-block-js',
    plugin_dir_url(__FILE__) . 'panels.js',
    array('wp-blocks', 'wp-i18n', 'wp-editor'),
    true
  );

  $query = new WP_Query(
    array(
      'post_type' => 'ascm_panels',
      'post_status' => 'publish',
      'posts_per_page' => -1
    )
  );
  
  wp_localize_script(
    'ascm-panels-block-js', 
    'ascm_panels_param', 
    array(
      'ascm-panels-available' => isset($query->posts) ?  $query->posts : array(),
    )
  );
}
add_action('enqueue_block_editor_assets', 'loadASCMPanelsBlock');

/* To make your block "dynamic" uncomment
  the code below and in your JS have your "save"
  method return null
*/

// function blockOutput($props) {
//   return $props['wfcg_shortcode_panel'];
// }
// register_block_type( 
//   'wfcg-panels/shortcode-panels', 
//   array(
//     'render_callback' => 'blockOutput',
//   ) 
// );

/* To Save Post Meta from your block uncomment
  the code below and adjust the post type and
  meta name values accordingly. If you want to
  allow multiple values (array) per meta remove
  the 'single' property.
*/

// function myBlockMeta() {
//   register_meta(
//   	'post', 
//   	'color', 
//   	array(
//   		'show_in_rest' => true, 
//   		'type' => 'string', 
//   		'single' => true
//   	)
//   );
// }
// add_action('init', 'myBlockMeta');


// Register new custom block category
function ascm_panels_block_category( $categories, $post ) {
  return array_merge(
    $categories,
    array(
      array(
        'slug' => 'ascm-panels-block-category',
        'title' => __( 'AlphaSys Content Managment - Panels', 'ascm-panels' ),
      ),
    )
  );
}
add_filter( 'block_categories', 'ascm_panels_block_category', 10, 2);
