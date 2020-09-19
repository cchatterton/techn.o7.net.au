<?php

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_action( 'genesis_after_header', function() {
	
	$id     = get_option('page_on_front');
	$title	= sprintf( __( 'Search for: %s', 'wfc-genesis' ), get_search_query( true ) );
	?>
	
	<div class="wrap">
        <div class="row">
            <p class="col h2"><?php echo $title; ?></p>
        </div>
    </div>
	
	<?php
}, 12 );

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', function() {

	if( have_posts() ) : ?>

			<div class="row">
				<?php
					while( have_posts() ) : the_post();
						?>
							<div class="col-12 col-md-6 col-lg-4 card-wrapper">
								<?php echo wfc_get_card( 'search', get_the_ID() );?>
							</div>
						<?php
					endwhile;
				?>
			</div>

	<?php
	endif;
} );

genesis();