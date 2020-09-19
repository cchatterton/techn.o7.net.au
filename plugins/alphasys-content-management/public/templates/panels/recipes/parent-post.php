<?php
/*
 * Title: Parent Post
 * Type: custom
 * Desc: Custom Panel
 * Date: April 23, 2020
 *
 * Varaiables:
 * $panel - Contains the data needed for the Panel.
 *
 * Static functions usages:
 * ASCM_Panels_Renderer::enqueue_style_scripts() - This is where you enqueue your styles and scripts. You can register your own and call the slug
 * ASCM_Panels_Helper::get_recentposts($panel) - This function fetches and returns a list of available recent post base on the settings set for the Panel.
 * ASCM_Panels_Renderer::render_title($panel) - This function renders the title of the panel.
 * ASCM_Panels_Renderer::render_content($panel) - This function renders the content of the panel.
 * ASCM_Panels_Renderer::render_recent_posts_list($panel, $recent_posts) - This function renders the list of recent post base on the data provided by the "ASCM_Panels_Helper::get_recentposts($panel)" function and panel settings.
 *
 * This template can be overridden by copying it to yourtheme/ascm-templates/panels/recipes/recent_posts.php.
 * @package ascm-templates/panels/recipes/
 * @version 1.0.0.0
 */

//$title  		= $panel['data']['post']->post_title;
$img 			= wfc_get_image( $panel['data']['post']->ID, 'featured',  'large' );
$parent_post 	= get_post_meta( $panel['data']['post']->ID, 'parent_post', true );

$outerwrapclass = $panel['data']['standard']['outerwrapclass'];
$innerwrapclass = $panel['data']['standard']['innerwrapclass'];

ASCM_Panels_Renderer::enqueue_styles_scripts(
	array(
 		'bootstrap'
 	),
 	array(
 		'ascm-panels-public-js',
 	)
);

?>
<section id="<?php echo esc_attr( 'panel-' . $panel['data']['post']->ID ); ?>" class="container-fluid outer panel-pp <?php echo empty( $outerwrapclass ) ? '' : ' ' . $outerwrapclass ; ?>">
	<div class="wrapper inner<?php echo empty( $innerwrapclass ) ? '' : ' ' . $innerwrapclass ; ?>">
		<div class="row">
			<div class="col-sm col-md col-lg">
				<div class="row panel-pp-head">
					<div class="col-md-12">
						<?php ASCM_Panels_Renderer::render_title( $panel ); ?>
						<?php ASCM_Panels_Renderer::render_content( $panel ); ?>
					</div>
				</div>
				<?php if ( absint( $parent_post ) ) : ?>
					<div class="row panel-pp-cards">
						<div class="col-sm col-md-4 col-lg-4 panel-pp-item">
							<?php echo wfc_get_card( 'content', $panel['data']['post']->ID ); ?>
						</div>
						<?php

							$args = array(
								'post_type'      => 'any',
								'posts_per_page' => -1,
								'post_parent'    => $parent_post,
								'order'          => 'ASC',
								'orderby'        => 'menu_order'
							);

							$parent = new WP_Query( $args );

							if ( $parent->have_posts() ) : ?>

							<?php 
							while ( $parent->have_posts() ) : $parent->the_post(); ?>

								<div class="col-sm col-md-4 col-lg-4 panel-pp-item">
									<?php echo wfc_get_card( 'content', get_the_ID() ); ?>
								</div>

							<?php 
							endwhile;

							wp_reset_postdata();
						endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>