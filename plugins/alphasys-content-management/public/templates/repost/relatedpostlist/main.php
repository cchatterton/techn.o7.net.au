<?php
/*
 * Title: Related Post List Content Template
 * Desc: Item template of ASCM Repost Related Post List
 * Date: April 3, 2019
 *
 * This template can be overridden by copying it to yourtheme/ascm-templates/relatedpostlist/main.php.
 *
 * Varaiables:
 * $params - Contains the configurations for ASCM Repost Related Post List 
 *
 * Static functions usages:
 * ASCM_Repost_RelatedPostListRenderer::enqueue_style_scripts() - This is where you enqueue your styles and scripts. You can register your own and call the slug
 * ASCM_Repost_RelatedPostListRenderer::render_listtitle($params) - This will render the title for the related post list set on the shortcode
 * ASCM_Repost_RelatedPostListRenderer::render_list($params) - This will render the title for the related post list set on the shortcode
 *
 * Additional Notes:
 * Only edit contents inside the item content.
 *
 * @package ascm-templates/relatedpostlist
 * @version 1.0.0.0
 */

ASCM_Repost_RelatedPostListRenderer::enqueue_styles_scripts(
	array(
		'ascm-bootstrap-css',
		'ascm-animate-css',
	),
	array()
);
?>
<div class="<?php echo $params['configs']['outercontclass']; ?>">
	<div class="<?php echo $params['configs']['innercontclass']; ?>">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px;">
				<?php ASCM_Repost_RelatedPostListRenderer::render_listtitle($params); ?>
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12">
				<?php ASCM_Repost_RelatedPostListRenderer::render_list($params); ?>
			</div>
		</div>
	</div>
</div>

