<?php
/*
 * Title: Related Post List Item Content Template
 * Desc: Item template of ASCM Repost Related Post List which are in one row
 * Date: April 3, 2019
 *
 * This template can be overridden by copying it to yourtheme/ascm-templates/relatedpostlist/item-content.php.
 *
 * Varaiables:
 * $configs - Contains the configurations for ASCM Repost Related Post List 
 * $post - Contains the standard info of the current post
 *
 * Static functions usages:
 * ASCM_Repost_RelatedPostListHelper::get_featuredimgurl(id,$configs,size) - Returns the img url for base on the post id
 * ASCM_Repost_RelatedPostListHelper::get_postmeta(id,'meta_key') - Returns custom meta data from the provided meta key
 *
 * Additional Notes:
 * Only edit contents inside the item content.
 *
 * @package ascm-templates/relatedpostlist
 * @version 1.0.0.0
 */
?> 
<img src="<?php echo ASCM_Repost_RelatedPostListHelper::get_featuredimgurl($post->ID,$configs); ?>">
<a href="<?php echo get_post_permalink($post->ID); ?>" target="_blank">
	<span class="animated flipInX"><?php echo $post->post_title; ?></span>
</a>