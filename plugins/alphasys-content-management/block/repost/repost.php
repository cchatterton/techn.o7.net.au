<?php

function loadASCMRepostBlock() {
  wp_enqueue_script(
    'ascm-repost-block-js',
    plugin_dir_url(__FILE__) . 'repost.js',
    array('wp-blocks', 'wp-i18n', 'wp-editor'),
    true
  );

  $listtype = array(
    'paginated' => 'Paginated'
  );
  
  wp_localize_script(
    'ascm-repost-block-js', 
    'ascm_repost_param', 
    array(
      'ascm-repost-list-type' => $listtype,
    )
  );
}
add_action('enqueue_block_editor_assets', 'loadASCMRepostBlock');


// Register new custom block category
function ascm_repost_block_category( $categories, $post ) {
  return array_merge(
    $categories,
    array(
      array(
        'slug' => 'ascm-repost-block-category',
        'title' => __( 'AlphaSys Content Managment - Repost', 'ascm-repost' ),
      ),
    )
  );
}
add_filter( 'block_categories', 'ascm_repost_block_category', 10, 2);