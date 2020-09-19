<?php
/*
 * Title: Recent Posts
 * Type: recent_posts
 * Settings: recent_posts
 * Desc: Recent Posts card for ASCM Panels recipe.
 * Date: May 15, 2019
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
$recent_posts = ASCM_Panels_Helper::get_recentposts($panel);
?>
<section id="<?php echo 'ascm-panels-main-cont-'.$panel_id; ?>" class="panel container-fluid outer <?php echo 'ascm-panels-main-cont-'.$panel_id .' '.$outerwrapclass; ?>">
    <div class="wrapper inner">
        <div class="row">
            <div id="<?php echo 'ascm-panels-sub-cont-'.$panel_id; ?>" class="col-sm col-md col-lg <?php echo 'ascm-panels-sub-cont-'.$panel_id.' '.$innerwrapclass; ?>">
        		<?php ASCM_Panels_Renderer::render_title($panel); ?>
        		<?php ASCM_Panels_Renderer::render_content($panel); ?>
        	    <?php ASCM_Panels_Renderer::render_recent_posts_list($panel, $recent_posts); ?>
            </div>
        </div>
    </div>
</section>


