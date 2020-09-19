<?php
	//print_r(ASCM_Repost_RelatedPostListHelper::get_posts());
	$options = get_option( 'ascm_generaloptions' );

	$enable_bestbefore 	= isset( $options['ascm_enable_bestbefore'] ) && $options['ascm_enable_bestbefore'] == 'on' ? 'checked' : '';
	$enable_repost 		= isset( $options['ascm_enable_repost'] ) && $options['ascm_enable_repost'] == 'on' ? 'checked' : '';
	$enable_panels 		= isset( $options['ascm_enable_panels'] ) && $options['ascm_enable_panels'] == 'on' ? 'checked' : '';
	$enable_magic_card 	= isset( $options['ascm_enable_magic_card'] ) && $options['ascm_enable_magic_card'] == 'on' ? 'checked' : '';
?>
<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
	<div class="ascm-main-container">
		<div class="ascm-main-sub-container">
			<div class="ascm-main-header">
				<img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/ascm.png'; ?>">
				<span><?php _e( 'AlphaSys Content Management', 'ascm' ); ?></span>
			</div>
			<div class="ascm-main-sidemenu-content-container">
				<div class="ascm-main-content">
					<div id="ascm-main-content-title" class="ascm-main-content-title">
						<span><?php _e( 'Enable Modules', 'ascm' ); ?></span>
					</div>
                    
					<div class="ascm-main-content-mod-cont">
						<div class="ascm-main-content-mod-field-main-cont animated bounceIn faster">
							<div class="ascm-main-content-mod-title-cont">
								<div class="ascm-main-content-mod-title"><?php _e( 'Best Before Module', 'ascm' ); ?></div>
							</div>
							<div class="ascm-main-content-mod-field-sub-cont">
								<div class="ascm-main-content-mod-desc-cont"><img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/best-before-150.png'; ?>"><?php _e( 'Best Before Module can set an expiry date schedule for availability on our website and is very useful especially for events and custom posts which has either a due date or a specific duration of availability. This also allows us to either set it to draft or as pending status depending on how the post is used.', 'ascm' ); ?></div>
								<div class="ascm-main-content-mod-enable-cont">
									<div class="ascm-main-content-mod-field-label"><?php _e( 'Enable', 'ascm' ); ?></div>
									<div class="ascm-onoffswitch">
									    <input type="checkbox" name="ascm_enable_bestbefore" class="ascm-onoffswitch-checkbox" id="ascm_enable_bestbefore" <?php echo $enable_bestbefore; ?>>
									    <label class="ascm-onoffswitch-label" for="ascm_enable_bestbefore">
									        <span class="ascm-onoffswitch-inner"></span>
									        <span class="ascm-onoffswitch-switch"></span>
									    </label>
									</div>
									<div class="ascm-main-content-mod-field-note"><small><b>Note: </b><?php _e( 'Switch this field to enable the Best Before functionality.', 'ascm' ); ?></small></div>
								</div>
								<span class="ascm-main-content-mod-gear-cont"></span>
								<?php if ( $enable_bestbefore == 'checked' ) : ?>
                                	<span id="ascm-mod-settings-btn-bestbefore" class="ascm-main-content-mod-gear-icon-cont"><i class="fa fa-cog fa-2x"></i></span>
								<?php endif; ?>
							</div>
						</div>

						<div class="ascm-main-content-mod-field-main-cont animated bounceIn faster">
							<div class="ascm-main-content-mod-title-cont">
								<div class="ascm-main-content-mod-title"><?php _e( 'Repost Module', 'ascm' ); ?></div>
							</div>
							<div class="ascm-main-content-mod-field-sub-cont">
								<div class="ascm-main-content-mod-desc-cont"><img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/repost-150.png'; ?>"><?php _e( 'ASCM Repost Module allows us to re-post a certain post using the post\'s URL and add our own comment/message and is saved as a blog post. This will be rendered and displayed as a blog post in the front end and is accessible through the blog page. This shortcode <b>[ascm-repost]</b> is available to initially display the recent Repost.', 'ascm' ); ?>
								</div>
								<div class="ascm-main-content-mod-enable-cont">
									<div class="ascm-main-content-mod-field-label"><?php _e( 'Enable', 'ascm' ); ?></div>
									<div class="ascm-onoffswitch">
									    <input type="checkbox" name="ascm_enable_repost" class="ascm-onoffswitch-checkbox" id="ascm_enable_repost" <?php echo $enable_repost; ?>>
									    <label class="ascm-onoffswitch-label" for="ascm_enable_repost">
									        <span class="ascm-onoffswitch-inner"></span>
									        <span class="ascm-onoffswitch-switch"></span>
									    </label>
									</div>
									<div class="ascm-main-content-mod-field-note"><small><b>Note: </b><?php _e( 'Switch this field to enable the Repost functionality.', 'ascm' ); ?></small></div>
								</div>
								<span class="ascm-main-content-mod-gear-cont"></span>
                                <?php if ( $enable_repost == 'checked' ) : ?>
									<span id="ascm-mod-settings-btn-repost" class="ascm-main-content-mod-gear-icon-cont"><i class="fa fa-cog fa-2x"></i></span>
                                <?php endif; ?>
                            </div>
						</div>

						<div class="ascm-main-content-mod-field-main-cont animated bounceIn faster">
							<div class="ascm-main-content-mod-title-cont">
								<div class="ascm-main-content-mod-title"><?php _e( 'Panels Module', 'ascm' ); ?></div>
							</div>
							<div class="ascm-main-content-mod-field-sub-cont">
								<div class="ascm-main-content-mod-desc-cont"><img src="<?php echo plugin_dir_url( __FILE__ ).'../../images/panel-150.png'; ?>"><?php _e( 'Panels module allows us to insert contents to any page in the site using shortcodes generated after a panel is published. This reduces the amount of time we rendered on customizing our site by simply reusing the panels which contain the same content and injecting the corresponding panel\'s shortcode to the post or template part you want it to be displayed into.', 'ascm' ); ?></div>
								<div class="ascm-main-content-mod-enable-cont">
									<div class="ascm-main-content-mod-field-label"><?php _e( 'Enable', 'ascm' ); ?></div>
									<div class="ascm-onoffswitch">
									    <input type="checkbox" name="ascm_enable_panels" class="ascm-onoffswitch-checkbox" id="ascm_enable_panels" <?php echo $enable_panels; ?>>
									    <label class="ascm-onoffswitch-label" for="ascm_enable_panels">
									        <span class="ascm-onoffswitch-inner"></span>
									        <span class="ascm-onoffswitch-switch"></span>
									    </label>
									</div>
									<div class="ascm-main-content-mod-field-note"><small><b>Note: </b><?php _e( 'Switch this field to enable the Panels functionality.', 'ascm' ); ?></small></div>
								</div>
                                <span class="ascm-main-content-mod-gear-cont"></span>
								<?php if ( $enable_panels == 'checked' ): ?>
								<a href ="<?php echo admin_url( '/edit.php?post_type=ascm_panels&page=ascm-panel-manager' ); ?>" id="ascm-mod-settings-btn-panels" class="ascm-main-content-mod-gear-icon-cont"><i class="fa fa-cog fa-2x"></i></a>
								<?php endif; ?>
                            </div>
						</div>

						<!-- Card option -->
						<div class="ascm-main-content-mod-field-main-cont animated bounceIn faster">
							<div class="ascm-main-content-mod-title-cont">
								<div class="ascm-main-content-mod-title"><?php _e( 'Magic Card Module', 'alphasys-content-management' ); ?></div>
							</div>
							<div class="ascm-main-content-mod-field-sub-cont">
								<div class="ascm-main-content-mod-desc-cont"><img src="<?php echo plugin_dir_url( __FILE__ ) . '../../images/repost-150.png'; ?>"><?php _e( 'Magic Card module is where you can create a custom and dynamic card and use it like a normal card created in code. Card also has custom templating.', 'alphasys-content-management' ); ?></div>
								<div class="ascm-main-content-mod-enable-cont">
									<div class="ascm-main-content-mod-field-label"><?php _e( 'Enable', 'alphasys-content-management' ); ?></div>
									<div class="ascm-onoffswitch">
									    <input type="checkbox" name="ascm_enable_magic_card" class="ascm-onoffswitch-checkbox" id="ascm_enable_magic_card" <?php echo $enable_magic_card; ?>>
									    <label class="ascm-onoffswitch-label" for="ascm_enable_magic_card">
									        <span class="ascm-onoffswitch-inner"></span>
									        <span class="ascm-onoffswitch-switch"></span>
									    </label>
									</div>
									<div class="ascm-main-content-mod-field-note"><small><b>Note: </b><?php _e( 'Switch this field to enable the Card module.', 'alphasys-content-management' ); ?></small></div>
								</div>
                            </div>
						</div>

						<div class="ascm-main-content-btn-cont">
							<input type="hidden" name="action" value="ascm_generaloptions">
	       					<input class="ascm-button" type="submit" value="Save">
						</div>

					</div>			
				</div>
			</div>
		</div>
	</div>
</form>
<div><?php if($ascm_enable_bestbefore == 'on') { require_once('alphasys-content-management-best-before.php'); } ?></div>
<div><?php if($ascm_enable_repost == 'on') { require_once('alphasys-content-management-repost.php'); } ?></div>

