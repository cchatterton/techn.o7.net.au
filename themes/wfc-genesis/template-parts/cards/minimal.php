<?php
/*
 * Title: Minimal Card
 * Slug: minimal
 * Type: card
 * Description: Card for displaying image and title
 *
 * Variables:
 * $args - Contains the data needed about the this template.
 *
 * Note: A function is available to render this template : wfc_get_card( string $template, int $post_id = 0, array $args = array() );
 */
$image      = wfc_get_image( $wfc_source_post->ID, 'featured', 'medium' );
$date       = get_the_date( 'c', $wfc_source_post );
$date       = !empty( $date ) ? strtotime( $date ) : '';
$date       = !empty( $date ) ? date( 'D, M j', $date ) : '';

?>
<a href="<?php echo get_permalink( $wfc_source_post->ID ); ?>">
    <div class="card-background-img" style="background-image: url(<?php echo esc_url( $image ); ?>);"></div>
	<div class="card-body">
        <p class="date text1"><?php echo $date; ?></p>	
        <p class="card-title h4"><?php echo get_the_title( $wfc_source_post ); ?></p>
	</div>
</a>