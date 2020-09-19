<?php
/**
 * Displays child pages as list.
 * 
 * Template Name: Children as list
 */

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

/**
 * Display additional contents to entry content.
 */
add_action( 'genesis_entry_content', function() {

	global $post;

	$child_pages = get_children( array(
		'post_parent' => $post->ID,
		'post_type'   => $post->post_type,
		'post_status' => 'publish',
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
		'numberposts' => -1,
	) );

	if ( ! empty( $child_pages ) ) :
	?>
		<div class="wfc-children-list">
			<?php foreach ( $child_pages as $key => $page_data ): ?>
				<div class="card">
					<img class="img-fluid" src="<?php echo wfc_get_image( $key ); ?>" />
					<div class="card-body">
						<h4><?php echo $page_data->post_title; ?></h4>
						<div><?php echo wp_trim_words( apply_filters( 'the_content', $page_data->post_content ) ); ?></div>
						<a href="<?php echo esc_url( get_permalink( $key ) ); ?>"><?php esc_html_e( 'View more...', 'wfc-genesis' ); ?></a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php
	endif;

} );
genesis();
