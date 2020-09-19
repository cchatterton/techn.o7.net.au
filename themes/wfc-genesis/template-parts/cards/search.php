<?php
/*
 * Title: Search Card
 * Slug: search
 * Type: card
 * Description: Card for search results
 *
 * Variables:
 * $args - Contains the data needed about the this template.
 *
 * Note: A function is available to render this template : wfc_get_card( string $template, int $post_id = 0, array $args = array() );
 */
 
$featured_img = wfc_get_image( $wfc_source_post->ID, 'featured', 'large' ); 
$permalink = get_the_permalink( $wfc_source_post->ID );
$color1 = get_theme_mod( 'color_palette_1' , '#000000' );

?>
<style>
	.card-search#<?php echo 'card-'.$wfc_source_post->ID; ?> .card-innerwrapper:hover,
	.card-search#<?php echo 'card-'.$wfc_source_post->ID; ?> .card-innerwrapper:hover .text1 {
		color: #ffffff !important;
	}
	
	.card-search#<?php echo 'card-'.$wfc_source_post->ID; ?> .card-innerwrapper:hover.border1 {
		border-color:  <?php wfc_colour_darker( $color1 ); ?> !important;
	}
	
	.card-search#<?php echo 'card-'.$wfc_source_post->ID; ?> .card-background-img::before {
		background-image: url(<?php echo $featured_img; ?>); 
	}
</style> 

<a class="card-innerwrapper card-border-bottom border1 hbg1 flex-row flex-wrap" href="<?php echo esc_url( $permalink ); ?>">
	<div class="row no-gutters">
		<div class="col-auto">
			<div class="card-img-wrap">
				<div class="card-background-img card-img-left"></div>
			</div>
		</div>
		<div class="col">
			<div class="card-block"> 
				<p class="card-title h4"><?php echo __( get_the_title( $wfc_source_post ), 'wfc-genesis' ); ?></p>
				<p class="card-text"><?php echo __( wfc_get_post_excerpt($wfc_source_post->ID), 'wfc-genesis' ); ?></p>
			</div>
		</div>
	</div>
	<div class="card-footer w-100 d-flex">
		<i class="card-icon far fa-angle-right text1"></i>
	</div>
</a>
 
