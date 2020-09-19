<?php
/**
 * Displays child pages as paragraph.
 *
 * Template Name: Children as paragraph
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
		<div class="wfc-children-paragraph">
			<?php foreach ( $child_pages as $key => $page_data ) : ?>
				<div class="paragraph-wrapper">
					<h2><?php echo esc_html( $page_data->post_title ); ?></h2>
					<div>
						<?php echo apply_filters( 'the_content', $page_data->post_content ); ?>
					</div>
				</div>
			<?php endforeach;?>
		</div>
	<?php
	endif;

} );

genesis();