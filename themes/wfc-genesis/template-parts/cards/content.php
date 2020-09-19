<?php
/*
 * Title: Content Card
 * Slug: content
 * Type: card
 * Description: Card for displaying content
 *
 * Variables:
 * $args - Contains the data needed about the this template.
 *
 * Note: A function is available to render this template : wfc_get_card( string $template, int $post_id = 0, array $args = array() );
 */

?>
<a class="card-border-top border1" href="<?php echo get_permalink( $wfc_source_post ); ?>">
	<div class="card-body">
		<p class="card-title h4"><?php echo __( get_the_title( $wfc_source_post ), 'wfc-genesis' ); ?></p>
		<p class="card-text"><?php echo __( wfc_get_post_excerpt( $wfc_source_post->ID ), 'wfc-genesis' ); ?></p>
		<span class="btn btn-outline-primary card-cta-label">Read More</span>
	</div>
</a>