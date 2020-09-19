<?php
/*
 * Title: Archive Panel
 * Type: custom
 * Desc: Recent Posts card for ASCM Panels recipe.
 * Date: April 22, 2020
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
 * 
 * @since 1.1.7
 */

$metas 			= wfc_get_post_meta( $panel['data']['post']->ID );
$img 			= wfc_get_image( $panel['data']['post']->ID, 'featured',  'large' );
$card_template  = isset( $metas['archive_panel_card_type'][0] ) ? $metas['archive_panel_card_type'][0] : '';

$post_type  	= isset( $metas['archive_panel_post_type'][0] ) ? $metas['archive_panel_post_type'][0] : '';
$img_pos  		= isset( $metas['ap_image_position'][0] ) ? $metas['ap_image_position'][0] : '';

$content_class	= ( $img_pos == 'left' ) ? 'order-md-1' : 'order-md-0';
$img_class		= ( $img_pos == 'left' ) ? 'order-md-0' : 'order-md-1';

$outerwrapclass = $panel['data']['standard']['outerwrapclass'];
$innerwrapclass = $panel['data']['standard']['innerwrapclass'];

?>
<section id="<?php echo esc_attr( 'panel-' . $panel['data']['post']->ID ); ?>" class="container-fluid outer panel-archive<?php echo empty( $outerwrapclass ) ? '' : ' ' . $outerwrapclass ; ?>">
	<div class="wrapper inner<?php echo empty( $innerwrapclass ) ? '' : ' ' . $innerwrapclass ; ?>">
		<div class="row">
			<div class="col-sm col-md col-lg">
				<div class="row panel-archive-head">
					<div class="col-sm col-md-6 col-lg-6 <?php echo $content_class; ?> order-1">
						<div class="panel-archive-content">
							<?php ASCM_Panels_Renderer::render_title( $panel ); ?>
							<?php ASCM_Panels_Renderer::render_content( $panel ); ?>
						</div>
					</div>
					<div class="col-sm col-md-6 col-lg-6 <?php echo $img_class; ?> order-0">
						<div style="background-image: url(<?php echo $img; ?>);" class="panel-archive-img panel-bg-img"></div>
					</div>
				</div>
				<div class="row panel-archive-cards">
					<?php
					if( !empty( $post_type ) ):
						
						$args = array(
							'post_type'			=> $post_type,
							'orderby'       	=> 'menu_order', 
							'order'         	=> 'ASC',
							'posts_per_page'	=> 3
						);
						
						$query = new WP_Query( $args );
						
						if ( $query->have_posts() ):

							while ( $query->have_posts() ) :
								$query->the_post();

								$address_post_id = get_the_ID();
								echo '<div class="col-sm col-md-4 col-lg-4 panel-archive-item">';
								echo wfc_get_card( $card_template, $address_post_id ); 
								echo '</div>';
							endwhile;

							wp_reset_postdata();
						endif;
					endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
