<?php
/*
 * Title: With Image
 * Type: with_image
 * Settings: with_image
 * Desc: With Image card for ASCM Panels recipe.
 * Date: June 3, 2019
 *
 * Varaiables:
 * $panel - Contains the data needed for the Panel.
 *
 * Static functions usages:
 * ASCM_Panels_Renderer::enqueue_style_scripts() - This is where you enqueue your styles and scripts. You can register your own and call the slug
 *
 *
 * This template can be overridden by copying it to yourtheme/ascm-templates/panels/recipes/with_image.php.
 * @package ascm-templates/panels/recipes/
 * @version 1.0.0.0
 */
ASCM_Panels_Renderer::enqueue_styles_scripts(
	array(
		'bootstrap'
	),
	array(
		'ascm-panels-public-js',
	)
);
//print_r($panel);
$panel_id = $panel['data']['post']->ID;
$outerwrapclass = $panel['data']['standard']['outerwrapclass'];
$innerwrapclass = $panel['data']['standard']['innerwrapclass'];
$cta_wrapppanel = isset($panel['data']['standard']['cta_wrapppanel']) ? $panel['data']['standard']['cta_wrapppanel'] : '';
$cta_url = isset($panel['data']['standard']['cta_url']) ? $panel['data']['standard']['cta_url'] : '';

if ( $cta_wrapppanel !== 'on' ) { 
	?>
	<section id="<?php echo 'ascm-panels-main-cont-'.$panel_id; ?>" class="panel container-fluid outer <?php echo 'ascm-panels-main-cont-'.$panel_id .' '.$outerwrapclass; ?>">
		<div class="wrapper inner">
			<div class="row">
			    <div id="<?php echo 'ascm-panels-sub-cont-'.$panel_id; ?>" class="col-sm col-md col-lg <?php echo 'ascm-panels-sub-cont-'.$panel_id.' '.$innerwrapclass; ?>">
			        <div class="ascm-panels-halfimage-content-cont">
						<?php ASCM_Panels_Renderer::render_withimage_content($panel); ?>
			        </div>
			    </div>
			</div>
		</div>
	</section>
	<?php
} else {
	?>
	<a href="<?php echo $cta_url; ?>" class="full-panel-cta">
		<div id="<?php echo 'ascm-panels-main-cont-'.$panel_id; ?>" class="panel <?php echo 'ascm-panels-main-cont-'.$panel_id .' '.$outerwrapclass; ?>">
		    <div id="<?php echo 'ascm-panels-sub-cont-'.$panel_id; ?>" class="<?php echo 'ascm-panels-sub-cont-'.$panel_id.' '.$innerwrapclass; ?>">
		        <div class="ascm-panels-halfimage-content-cont">
					<?php ASCM_Panels_Renderer::render_withimage_content($panel); ?>
		        </div>
		    </div>
		</div>
	</a>
	<?php
}