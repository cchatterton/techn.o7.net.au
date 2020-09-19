<?php
/*
 * Title: Content With Image Card
 * Slug: content-w-image
 * Type: card
 * Description: Card for displaying content with image
 *
 * Variables:
 * $args - Contains the data needed about the this template.
 *
 * Note: A function is available to render this template : wfc_get_card( string $template, int $post_id = 0, array $args = array() );
 */
 
$fname = get_the_author_meta( 'first_name', $wfc_source_post->post_author );
$lname = get_the_author_meta( 'last_name', $wfc_source_post->post_author );
$author_name = !empty( $fname ) && !empty( $lname ) ? sprintf( '%s %s', $fname, $lname ) : get_the_author( $wfc_source_post->ID );
$featured_img = wfc_get_image( $wfc_source_post->ID, 'featured', 'large' );
$permalink = get_the_permalink( $wfc_source_post->ID );
$color1 = get_theme_mod( 'color_palette_1' , '#000000' );
$color4 = get_theme_mod( 'color_palette_4' , '#ffffff' );

?>
<style>
	.card-content-w-image#<?php echo 'card-'.$wfc_source_post->ID; ?> .card-innerwrapper:hover .border1 {
		border-color:  <?php wfc_colour_darker( $color1 ); ?> !important;
	}
	
	.card-content-w-image#<?php echo 'card-'.$wfc_source_post->ID; ?> .card-innerwrapper:hover,
	.card-content-w-image#<?php echo 'card-'.$wfc_source_post->ID; ?> .card-innerwrapper:hover .text1 {
		color:  #ffffff !important;
	}
	
	.card-content-w-image#<?php echo 'card-'.$wfc_source_post->ID; ?> .card-innerwrapper:hover .btn {
		background-color: #ffffff;
	}	
	
	.card-content-w-image#<?php echo 'card-'.$wfc_source_post->ID; ?> .card-background-img::before {
		background-image: url(<?php echo $featured_img; ?>);
	}
</style>

<a class="card-innerwrapper hbg1" href="<?php echo esc_url( $permalink ); ?>">
	<div class="card-background-img card-border-bottom border1"></div>
	<div class="card-body">
		<p class="card-title h4"><?php echo __( get_the_title( $wfc_source_post ) , 'wfc-genesis' ); ?></p>
		<p class="card-info text1"><?php echo $author_name; ?></p>
		<p class="card-text"><?php echo __( wfc_get_post_excerpt( $wfc_source_post->ID ), 'wfc-genesis'); ?></p>
	</div>
	<div class="card-footer">
		<span class="btn btn-outline-primary card-cta-label" href="<?php echo esc_url( $permalink ); ?>">Read More</span>
	</div>
</a>
