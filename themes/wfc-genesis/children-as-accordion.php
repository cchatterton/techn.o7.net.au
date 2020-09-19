<?php
/**
 * Displays child pages as accordion.
 *
 * Template Name: Children as accordion
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

	$first_key = array_keys( $child_pages );
	$first_key = array_reverse( $first_key, true );
	$first_key = array_pop( $first_key );

	if ( ! empty( $child_pages ) ) :
	?>
		<div class="accordion wfc-accordion" id="children-accordion">
			<?php foreach ( $child_pages as $key => $page_data ): ?>
				<div class="card">
					<a class="card-header" href="<?php echo esc_attr( '#collapse-' . $key ); ?>" data-toggle="collapse" data-target="<?php echo esc_attr( '#collapse-' . $key ); ?>" aria-expanded="true" aria-controls="<?php echo esc_attr( 'collapse-' . $key ); ?>">
						<button class="btn"><?php echo esc_html( $page_data->post_title ); ?></button>
					</a>
					<div id="<?php echo esc_attr( 'collapse-' . $key ); ?>" class="<?php echo esc_attr( 'collapse' . ( $first_key === $key ? ' show' : '' ) ); ?>" data-parent="#children-accordion">
						<div class="card-body">
							<?php echo apply_filters( 'the_content', $page_data->post_content ); ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php
	endif;

} );

genesis();