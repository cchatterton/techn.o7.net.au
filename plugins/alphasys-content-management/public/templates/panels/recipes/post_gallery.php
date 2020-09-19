<?php
/*
 * Title: Post Gallery
 * Type: post_gallery
 * Settings: post_gallery
 * Desc: Default card for ASCM Panels recipe.
 * Date: April 5, 2019
 *
 * Varaiables:
 * $panel - Contains the data needed for the Penel.
 *
 * Static functions usages:
 * ASCM_Panels_Renderer::enqueue_style_scripts() - This is where you enqueue your styles and scripts. You can register your own and call the slug
 *
 *
 * This template can be overridden by copying it to yourtheme/ascm-templates/panels/recipes/default.php.
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
$panel_id = $panel['data']['post']->ID;
$outerwrapclass = $panel['data']['standard']['outerwrapclass'];
$innerwrapclass = $panel['data']['standard']['innerwrapclass'];

// Query posts base on panel options
$posts = ASCM_Panels_CPTQueries::get_posts($panel);

$searchelement_config = array(
	'search_fld' => array(
		'placeholder' => 'Search . . .'
	),
	'search_btn' => array(
		'label' => 'Search'
	)
);

$config = array(
	'pageinfo' => array(
		'label' => 'Page ',
		'class' => '',
	),
	'firstpage_btn' => array(
		'label' => 'FIRST',
		'class' => '',
	),
	'previouspage_btn' => array(
		'label' => 'PREV',
		'class' => '',
	),
	'pagenum_btn' => array(
		'range' => 3,
		'class' => '',
	),
	'nextpage_btn' => array(
		'label' => 'NEXT',
		'class' => '',
	),
	'lastpage_btn' => array(
		'label' => 'LAST',
		'class' => '',
	)
);
?>
<section id="<?php echo 'ascm-panels-main-cont-'.$panel_id; ?>" class="panel container-fluid outer <?php echo 'ascm-panels-main-cont-'.$panel_id .' '.$outerwrapclass; ?>">
	<div class="wrapper inner">
		<div class="row">
			<div id="<?php echo 'ascm-panels-sub-cont-'.$panel_id; ?>" class="col-sm col-md col-lg <?php echo 'ascm-panels-sub-cont-'.$panel_id.' '.$innerwrapclass; ?>">
				<?php ASCM_Panels_Renderer::render_title($panel); ?>
				<?php ASCM_Panels_Renderer::render_content($panel); ?>
		        <div class="ascm-panels-postgallery-cont">
			        <?php ASCM_Panels_CPTQueries::render_postgallerysearchelements($searchelement_config, $panel); ?>
			        <?php ASCM_Panels_CPTQueries::render_postgallerypostlist($posts, $panel); ?>
			        <?php ASCM_Panels_CPTQueries::render_postgallerypaginationelements($posts, $config); ?>
		        </div>
			</div>
		</div>
	</div>
</section>

