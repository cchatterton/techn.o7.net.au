<?php

//* Remove the entry title (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//* Remove Genesis Loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

//* Add the loop with the contents rendered as cards
add_action( 'genesis_loop', function() {
	
	global $post_type;
	$archive_page = get_page_by_path( $post_type );
	$card = 'content-w-image';

	if ( $archive_page ) {
		
		$archive_card_slug = strip_tags ( get_post_meta( $archive_page->ID , 'archive_card' , true ) );
		$magic_card_exist = $archive_card_slug ? get_page_by_path( $archive_card_slug, OBJECT, 'ascm-magic-card' ) : '';
		$options = get_option('ascm_generaloptions');
		
		$col_md = get_post_meta( $archive_page->ID , 'col-md' , true ); 
		$col_lg = get_post_meta( $archive_page->ID , 'col-lg' , true ); 
		
		if ( $magic_card_exist && ( isset( $options['ascm_enable_magic_card'] ) && $options['ascm_enable_magic_card'] == 'on' ) ) {
			$card = $archive_card_slug;
		} else {
			$card_file = sprintf( '%s/%s.php', wfc_get_cards_dir(), $archive_card_slug );
			$card = file_exists ( $card_file ) ? $archive_card_slug : $card;
		}
		
	}
	
	$col_md = $col_md ? $col_md : '6';
	$col_lg = $col_lg ? $col_lg : '4';
	
	if ( have_posts() ) {
		do_action( 'genesis_before_while' );
		?>
		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="col-sm-12 col-md-<?php echo $col_md; ?> col-lg-<?php echo $col_lg; ?> card-wrapper">
					<?php echo wfc_get_card( $card, get_the_ID() ); ?>
				</div>
			<?php endwhile; ?>
		</div>
		<?php do_action( 'genesis_after_endwhile' ); ?>
		<?php
	}
	
	
} );

genesis();