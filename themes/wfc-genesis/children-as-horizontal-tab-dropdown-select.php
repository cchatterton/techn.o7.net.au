<?php
/**
 * Displays child as horizontal tab and accordion on mobile view.
 *
 * Template Name: Children as horizontal tab/Dropdown Select Mobile View
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
		<div class="wfc-horizontal-tab d-none d-md-block">
			<ul class="nav nav-tabs">
				<?php foreach ( $child_pages as $key => $page_data ): ?>
					<li class="nav-item">
						<a class="<?php echo esc_attr( 'nav-link border-bottom p-3' . ( $first_key === $key ? ' active' : '' ) ); ?>" href="<?php echo esc_attr( '#collapse-' . $key ); ?>" data-toggle="pill" role="tab" aria-controls="<?php echo esc_attr( 'collapse-' . $key ); ?>"><?php echo $page_data->post_title; ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="tab-content border border-top-0">
				<?php foreach ( $child_pages as $key => $page_data ): ?>
					<div class="<?php echo esc_attr( 'tab-pane fade' . ( $first_key === $key ? ' show active' : '' ) ); ?>" id="<?php echo esc_attr( 'collapse-' . $key ); ?>" role="tabpanel">
						<?php echo apply_filters( 'the_content', $page_data->post_content ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="wfc-dropdown-toggle d-block d-md-none">
			<div>
				<select id="children-dropdown" class="form-control">
					<?php foreach ( $child_pages as $key => $page_data ): ?>
						<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $page_data->post_title ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="tab-content border">
				<?php foreach ( $child_pages as $key => $page_data ): ?>
					<div class="tab-pane fade" id="<?php echo esc_attr( 'collapse-' . $key ); ?>" role="tabpanel">
						<?php echo apply_filters( 'the_content', $page_data->post_content ); ?>
					</div>
				<?php endforeach; ?>
			</div>
			<script type="text/javascript">
				(function($) {
					$('#children-dropdown').on('change', function(e) {
						var val = $(this).val();

						$('.wfc-dropdown-toggle .tab-content .tab-pane').removeClass('show active');
						$('.wfc-dropdown-toggle .tab-content #collapse-' + val).addClass('show active');
					}).trigger('change');
				})(window.jQuery);
			</script>
		</div>
	<?php
	endif;
	
} );
genesis();