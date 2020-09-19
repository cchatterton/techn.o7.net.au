<?php

//* Remove the entry title (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//* Remove Genesis Loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

//* Add the loop with the contents rendered as cards
add_action( 'genesis_loop', function() {
	if ( have_posts() ) {
		do_action( 'genesis_before_while' );
		?>
		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="col-12 col-md-6 col-lg-4 card-wrapper">
					<?php echo wfc_get_card( 'content-w-image', get_the_ID() ); ?>
				</div>
			<?php endwhile; ?>
		</div>
		<?php do_action( 'genesis_after_endwhile' ); ?>
		<?php
	}
} );

genesis();