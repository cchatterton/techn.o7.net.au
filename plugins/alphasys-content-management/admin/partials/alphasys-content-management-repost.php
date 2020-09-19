<?php
$ascm_mod_settings = get_option('ascm-mod-settings-repost');

$ascm_repost_relatedpostlist_fallback_img = 
isset($ascm_mod_settings['ascm-repost-relatedpostlist-fallback-img']) ? 
$ascm_mod_settings['ascm-repost-relatedpostlist-fallback-img'] : '';

$ascm_repost_relatedpostlist_outercontclass = 
isset($ascm_mod_settings['ascm-repost-relatedpostlist-outercontclass']) ? 
$ascm_mod_settings['ascm-repost-relatedpostlist-outercontclass'] : '';

$ascm_repost_relatedpostlist_innercontclass = 
isset($ascm_mod_settings['ascm-repost-relatedpostlist-innercontclass']) ? 
$ascm_mod_settings['ascm-repost-relatedpostlist-innercontclass'] : '';
?>
<div id="ascm-mod-settings-main-cont-repost" class="ascm-mod-settings-main-cont">
	<div id="ascm-mod-settings-sub-cont-repost" class="ascm-mod-settings-sub-cont">
		<div id="ascm-mod-settings-fields-cont-repost" class="ascm-mod-settings-fields-cont">

			<div class="ascm-mod-settings-section-title"><?php _e( 'Related Post List', 'ascm' ); ?></div>
			<div class="ascm-mod-settings-field-cont ascm-field-col s12 m6 l6">
				<label><?php _e( 'Outer Container Class', 'ascm' ); ?></label>
				<input type="text" class="ascm-mod-settings-input" id="ascm-repost-relatedpostlist-outercontclass" value="<?php echo $ascm_repost_relatedpostlist_outercontclass;?>">
			</div>
			<div class="ascm-mod-settings-field-cont ascm-field-col s12 m6 l6">
				<label><?php _e( 'Inner Container Class', 'ascm' ); ?></label>
				<input type="text" class="ascm-mod-settings-input" id="ascm-repost-relatedpostlist-innercontclass" value="<?php echo $ascm_repost_relatedpostlist_innercontclass;?>">
			</div>
			<div class="ascm-mod-settings-field-cont ascm-field-col s12 m6 l6">
				<label><?php _e( 'Template File Indicator', 'ascm' ); ?></label>
				<div class="ascm-template-identifier">
					<ul>
		                <li class="<?php echo ASCM_Repost_RelatedPostListHelper::is_custom_template_exist('repost/relatedpostlist', 'main.php') ? 'custom' : 'default'; ?>">Main</li>
		                <li class="<?php echo ASCM_Repost_RelatedPostListHelper::is_custom_template_exist('repost/relatedpostlist', 'listitem.php') ? 'custom' : 'default'; ?>">Item Content </li>
		            </ul>
		            <small><?php _e( 'Indicates if a <span>Default</span> or a <span>Custom</span> template file is being used', 'ascm' ); ?></small>
				</div>
			</div>
			<div class="ascm-mod-settings-field-cont ascm-field-col s12 m6 l6">
				<label><?php _e( 'Fallback Feature Image', 'ascm' ); ?></label>
				<div class='image-preview-wrapper'>
					<?php if(!empty($ascm_repost_relatedpostlist_fallback_img)) : ?>
						<img id='ascm-repost-relatedpostlist-fallback-img-preview' src="<?php echo wp_get_attachment_url($ascm_repost_relatedpostlist_fallback_img); ?>" width='150' height='100' style='max-height: 100px; width: 150px;'>
					<?php else : ?>
						<img id='ascm-repost-relatedpostlist-fallback-img-preview' src="<?php echo 'https://via.placeholder.com/600x400';?>" width='150' height='100' style='max-height: 100px; width: 150px;'>		
					<?php endif; ?>
				</div>
				<input id="ascm_repost_relatedpostlist_fallback_img_button" type="button" class="button" value="<?php _e( 'Upload image', 'ascm' ); ?>" />
				<input id="ascm_repost_relatedpostlist_fallback_img_clearbtn" type="button" class="button" value="<?php _e( 'Clear image', 'ascm' ); ?>" />
				<input type='hidden' id='ascm-repost-relatedpostlist-fallback-img' name='ascm-repost-relatedpostlist-fallback-img' value="<?php echo $ascm_repost_relatedpostlist_fallback_img;?>">
			</div>



		</div>
		<div class="ascm-field-col s12 m12 l12">
			<div id="ascm-mod-settings-loading-cont-repost" class="ascm-mod-settings-loading-cont ascm-hidden">
				<i class="fa fa fa-spinner fa-spin fa-2x"></i>
				<span style="padding: 5px;"><?php _e( 'Saving', 'ascm' ); ?> . . . . . </span>
			</div>
			<div class="ascm-mod-settings-btn-cont">
				<span id="ascm-mod-settings-save-btn-repost" class="ascm-mod-settings-save-btn"><?php _e( 'Save', 'ascm' ); ?></span>
				<span id="ascm-mod-settings-cancel-btn-repost" class="ascm-mod-settings-cancel-btn"><?php _e( 'Cancel', 'ascm' ); ?></span>
			</div>
		</div>
	</div>
</div>	