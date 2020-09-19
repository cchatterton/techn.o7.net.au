<?php
/*
 * Title: Project Card
 * Slug: project
 * Type: card
 * Description: Card for displaying project type card
 *
 * Variables:
 * $args - Contains the data needed about the this template.
 *
 * Note: A function is available to render this template : wfc_get_card( string $template, int $post_id = 0, array $args = array() );
 */
 
$details = function_exists( 'get_field' ) ? get_field( 'details', $wfc_source_post->ID ) : array();
$mission_text = $wfc_source_post_meta['mission_text'][0];
$results_text = $wfc_source_post_meta['results_text'][0];
$mission_icon = get_theme_mod( 'mission_challenge_icon', '' );
$results_icon = get_theme_mod( 'results_outcomes_icon', '' );
$featured_img = wfc_get_image( $wfc_source_post->ID, 'featured', 'large' );
$permalink = get_the_permalink( $wfc_source_post->ID );

?>
<style>
	.card-project#card-<?php echo $wfc_source_post->ID; ?> .card-half-background-img::before {
		background-image: url(<?php echo $featured_img; ?>);
	}
</style>

<div class="card-body">
	<p class="card-title h2"><?php echo get_the_title( $wfc_source_post ); ?></p>
	<ul class="topics">
		<?php foreach ( $details as $detail ) : 
				if ( ! empty( $detail['topic'] ) ) :
					$topic_link = get_the_permalink( $detail['topic']->ID );
					$topic_title = $detail['topic']->post_title; ?>
					<li class="border4">
						<a href="<?php echo esc_url( $topic_link )?>"><?php echo $topic_title ?></a>
					</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	<?php if ( $mission_text ) : ?>
		<p class="h3"><?php echo $mission_icon; ?>Mission/Challenge</p>
		<p><?php echo $mission_text; ?></p>
	<?php endif; ?>
	<?php if ( $results_text ) : ?>
		<p class="h3"><?php echo $results_icon; ?>Results/Outcomes</p>
		<p><?php echo $results_text ?></p>
	<?php endif; ?>
	<a class="link" href="<?php echo esc_url( $permalink ); ?>"><i class="fad fa-caret-right"></i>Read More</a>
</div>
<div class="full-w-margin full-width-img-cont full-width-img-cont-sm">
	<div class="card-half-background-img"></div>
</div>





