<?php

$pages = get_posts( array(
	'post_type' => 'page',
	'post_status' => 'publish',
	'posts_per_page' => -1,
) );
$pages = wp_list_pluck( $pages, 'post_title', 'ID' );

$spinners = array(
    'ball_8bits',
    'ball_atom',
    'ball_beat',
    'ball_circus',
    'ball_climbing_dot',
    'ball_clip_rotate',
    'ball_clip_rotate_multiple',
    'ball_clip_rotate_pulse',
    'ball_elastic_dots',
    'ball_fall',
    'ball_fussion',
    'ball_grid_beat',
    'ball_grid_pulse',
    'ball_newton_cradle',
    'ball_pulse',
    'ball_pulse_rise',
    'ball_pulse_sync',
    'ball_rotate',
    'ball_running_dots',
    'ball_scale',
    'ball_scale_multiple',
    'ball_scale_pulse',
    'ball_scale_ripple',
    'ball_scale_ripple_multiply',
    'ball_spin',
    'ball_spin_clockwise',
    'ball_spin_clockwise_fade',
    'ball_spin_clockwise_fade_rotating',
    'ball_spin_fade',
    'ball_spin_fade_rotating',
    'ball_spin_rotate',
    'ball_square_clockwise_spin',
    'ball_square_spin',
    'ball_triangle_path',
    'ball_zigzag',
    'ball_zigzag_deflect',
    'cog',
    'cube_transition',
    'fire',
    'line_scale',
    'line_scale_party',
    'line_scale_pulse_out',
    'line_scale_pulse_out_rapid',
    'line_spin_clockwise_fade',
    'line_spin_clockwise_fade_rotating',
    'line_spin_fade',
    'line_spin_fade_rotating',
    'pacman',
    'square_jelly_box',
    'square_loader',
    'square_spin',
    'timer',
    'triangle_skew_spin',
);

// Retrieve saved options
$enable_preloader = wfc_toolkit_get_option( 'enable_preloader', false );
$preloader_page = wfc_toolkit_get_option( 'preloader_page', 'all' );
$preloader_page_except = wfc_toolkit_get_option( 'preloader_page_except', array() );
$preloader_selected_page = wfc_toolkit_get_option( 'preloader_selected_page', array() );
$preloader_type = wfc_toolkit_get_option( 'preloader_type', 'spinner' );
$preloader_spinner = wfc_toolkit_get_option( 'preloader_spinner', 'line_scale' );
$preloader_spinner_color = wfc_toolkit_get_option( 'preloader_spinner_color', '#ffffff' );
$preloader_spinner_size = wfc_toolkit_get_option( 'preloader_spinner_size', 'small' );
$preloader_spinner_width = wfc_toolkit_get_option( 'preloader_spinner_width', 100 );
$preloader_spinner_image = wfc_toolkit_get_option( 'preloader_spinner_image' );
$preloader_background = wfc_toolkit_get_option( 'preloader_background', '#000000' );
$preloader_text = wfc_toolkit_get_option( 'preloader_text', 'Loading...' );
$preloader_text_color = wfc_toolkit_get_option( 'preloader_text_color', '#ffffff' );
$preloader_text_size = wfc_toolkit_get_option( 'preloader_text_size', 10 );

$enable_sticky_elements = wfc_toolkit_get_option( 'enable_sticky_elements', false );
$sticky_target_element = wfc_toolkit_get_option( 'sticky_target_element', '.is-sticky' );
$enable_sticky_on_desktop = wfc_toolkit_get_option( 'enable_sticky_on_desktop', true );
$enable_sticky_on_tablet = wfc_toolkit_get_option( 'enable_sticky_on_tablet', true );
$enable_sticky_on_mobile = wfc_toolkit_get_option( 'enable_sticky_on_mobile', true );
//$sticky_desktop_breakpoint = wfc_toolkit_get_option( 'sticky_desktop_breakpoint', '992' );
//$sticky_mobile_breakpoint = wfc_toolkit_get_option( 'sticky_mobile_breakpoint', '768' );

?>
<div class="wrap wfc-settings">
	<h1><?php esc_html_e( 'WFC Toolkit Settings', 'wfc-toolkit' ); ?></h1>
	<div class="wfc-box">
		<div class="wfc-box-header">
			<ul class="wfc-tabs">
				<li class="wfc-tabs-item wfc-tabs-item-active" data-content="wfc-privacy-devtools">
					<a class="wfc-tabs-switcher" href="javascript:void(0)">
						<?php esc_html_e( 'Privacy and Dev Tools', 'wfc-toolkit' ); ?>
					</a>
				</li>
				<li class="wfc-tabs-item" data-content="wfc-img-config">
					<a class="wfc-tabs-switcher" href="javascript:void(0)">
						<?php esc_html_e( 'Image Configuration', 'wfc-toolkit' ); ?>
					</a>
				</li>
				<li class="wfc-tabs-item" data-content="wfc-theme-ui-ux">
					<a class="wfc-tabs-switcher" href="javascript:void(0)">
						<?php esc_html_e( 'Theme UI/UX', 'wfc-toolkit' ); ?>
					</a>
				</li>
			</ul>
		</div>
		<div class="wfc-box-content">
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<div id="wfc-privacy-devtools" class="wfc-content-wrap wfc-content-active">
					<div class="wfc-option">
						<div class="wfc-option-wrap">
							<div class="wfc-option-info">
								<p class="wfc-option-label">
									Developer Mode
								</p>
								<p class="wfc-option-description">
									Enable developer mode feature.
								</p>
							</div>
							<div class="wfc-option-field">
								<label class="wfc-switch">
									<input type="checkbox" name="enable_developer_mode"<?php echo wfc_toolkit_get_option( 'enable_developer_mode', false ) ? ' checked="checked"' : ''; ?>>
									<span class="wfc-slider wfc-slider-round"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="wfc-option">
						<div class="wfc-option-wrap">
							<div class="wfc-option-info">
								<p class="wfc-option-label">
									Tracking and Personalization
								</p>
								<p class="wfc-option-description">
									Enable tracking and personalization feature.
								</p>
							</div>
							<div class="wfc-option-field">
								<label class="wfc-switch">
									<input type="checkbox" name="enable_tracking_personalization"<?php echo wfc_toolkit_get_option( 'enable_tracking_personalization', false ) ? ' checked="checked"' : ''; ?>>
									<span class="wfc-slider wfc-slider-round"></span>
								</label>
							</div>
						</div>
					</div>
				</div> 
				<div id="wfc-img-config" class="wfc-content-wrap">
					<div class="wfc-option">
						<div class="wfc-option-wrap">
							<div class="wfc-option-info">
								<p class="wfc-option-label">
									Fail Graceful
								</p>
								<p class="wfc-option-description">
									Enable fail graceful feature.
								</p>
							</div>
							<div class="wfc-option-field">
								<label class="wfc-switch">
								    <div class="wfc-check-wrapper wfc-slider-round">
										<div class="wfc-check"></div>
									</div>
								</label>
							</div>
						</div>
					</div>
					<div class="wfc-option">
						<div class="wfc-option-wrap">
							<div class="wfc-option-info">
								<p class="wfc-option-label">
									Image Gallery
								</p>
								<p class="wfc-option-description">
									Enable image gallery feature.
								</p>
							</div>
							<div class="wfc-option-field">
								<label class="wfc-switch">
									<input type="checkbox" name="enable_image_gallery"<?php echo wfc_toolkit_get_option( 'enable_image_gallery', false ) ? ' checked="checked"' : ''; ?>>
									<span class="wfc-slider wfc-slider-round"></span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div id="wfc-theme-ui-ux" class="wfc-content-wrap">
					<div class="wfc-option">
						<div class="wfc-option-wrap">
							<div class="wfc-option-info">
								<p class="wfc-option-label">
									Hero Images
								</p>
								<p class="wfc-option-description">
									Enable image Hero Images feature.
								</p>
							</div>
							<div class="wfc-option-field">
								<label class="wfc-switch">
									<span class="wfc-check-wrapper wfc-slider-round">
										<div class="wfc-check"></div>
									</span>
								</label>
							</div>
						</div>
					</div>
					<div class="wfc-section">
						<div class="wfc-section-wrap">
							<div class="wfc-section-info">
								<p class="wfc-section-label">
									Sticky Elements
								</p>
								<p class="wfc-section-description">
									Settings for Sticky Elements
								</p>
							</div>
							<div class="wfc-section-content">
								<div class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Sticky Elements
											</p>
											<p class="wfc-option-description">
												Enable sticky elements feature.
											</p>
										</div>
										<div class="wfc-option-field">
											<label class="wfc-switch">
												<input type="checkbox" name="enable_sticky_elements"<?php echo $enable_sticky_elements  ? ' checked="checked"' : ''; ?>>
												<span class="wfc-slider wfc-slider-round"></span>
											</label>
										</div>
									</div>
								</div>
								<div id="sticky-target-element" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Target Element
											</p>
											<p class="wfc-option-description">
												Set which element to target(eg. '#mycustomelement' or '.mycustomelement').
											</p>
										</div>
										<div class="wfc-option-field">
											<input type="text" name="sticky_target_element" value="<?php echo esc_attr( $sticky_target_element ); ?>">
										</div>
									</div>
								</div>
								<div id="enable-sticky-on-desktop" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Enable Desktop
											</p>
											<p class="wfc-option-description">
												Choose whether to enable/disable feature on desktop.
											</p>
										</div>
										<div class="wfc-option-field">
											<label class="wfc-switch">
												<input type="checkbox" name="enable_sticky_on_desktop"<?php echo $enable_sticky_on_desktop ? ' checked="checked"' : ''; ?>>
												<span class="wfc-slider wfc-slider-round"></span>
											</label>
										</div>
									</div>
								</div>
								<div id="enable-sticky-on-tablet" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Enable Tablet
											</p>
											<p class="wfc-option-description">
												Choose whether to enable/disable feature on tablet.
											</p>
										</div>
										<div class="wfc-option-field">
											<label class="wfc-switch">
												<input type="checkbox" name="enable_sticky_on_tablet"<?php echo $enable_sticky_on_tablet ? ' checked="checked"' : ''; ?>>
												<span class="wfc-slider wfc-slider-round"></span>
											</label>
										</div>
									</div>
								</div>
								<div id="enable-sticky-on-mobile" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Enable on Mobile
											</p>
											<p class="wfc-option-description">
												Choose whether to enable/disable feature on mobile.
											</p>
										</div>
										<div class="wfc-option-field">
											<label class="wfc-switch">
												<input type="checkbox" name="enable_sticky_on_mobile"<?php echo $enable_sticky_on_mobile ? ' checked="checked"' : ''; ?>>
												<span class="wfc-slider wfc-slider-round"></span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="wfc-section">
						<div class="wfc-section-wrap">
							<div class="wfc-section-info">
								<p class="wfc-section-label">
									Pre-loader
								</p>
								<p class="wfc-section-description">
									Settings for Pre-loader.
								</p>
							</div>
							<div class="wfc-section-content">
								<div class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Enable Pre-loader
											</p>
											<p class="wfc-option-description">
												Enable image Pre-loader feature.
											</p>
										</div>
										<div class="wfc-option-field">
											<label class="wfc-switch">
												<input type="checkbox" name="enable_preloader"<?php echo $enable_preloader ? ' checked="checked"' : ''; ?>>
												<span class="wfc-slider wfc-slider-round"></span>
											</label>
										</div>
									</div>
								</div>
								<div id="preloader-page" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Page
											</p>
											<p class="wfc-option-description">
												Select where the pre-preloader_text is going to be shown.
											</p>
										</div>
										<div class="wfc-option-field">
											<select name="preloader_page">
												<option value="all"<?php echo $preloader_page == 'all' ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'All', 'wfc-toolkit' ); ?></option>
												<option value="page_except"<?php echo $preloader_page == 'page_except' ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Page Except', 'wfc-toolkit' ); ?></option>
												<option value="selected_page"<?php echo $preloader_page == 'selected_page' ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Selected Page', 'wfc-toolkit' ); ?></option>
											</select>
										</div>
									</div>
								</div>
								<div id="preloader-page-except" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Page Except
											</p>
											<p class="wfc-option-description">
												Select page where the pre-preloader_text is not going to be shown.
											</p>
										</div>
										<div class="wfc-option-field">
											<select class="wfc-select-multi" name="preloader_page_except[]" multiple="multiple" style="width: 60%;">
												<?php foreach ( $pages as $ID => $title ) : ?>
													<option value="<?php echo esc_attr( $ID ); ?>"<?php echo in_array( $ID, $preloader_page_except ) ? ' selected="selected"' : ''; ?>><?php echo esc_html( $title ); ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								<div id="preloader-selected-page" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Selected Page
											</p>
											<p class="wfc-option-description">
												Select pages where the pre-preloader_text is going shown.
											</p>
										</div>
										<div class="wfc-option-field">
											<select class="wfc-select-multi" name="preloader_selected_page[]" multiple="multiple" style="width: 60%;">
												<?php foreach ( $pages as $ID => $title ) : ?>
													<option value="<?php echo esc_attr( $ID ); ?>"<?php echo in_array( $ID, $preloader_selected_page ) ? ' selected="selected"' : ''; ?>><?php echo esc_html( $title ); ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								<div id="preloader-type" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Type
											</p>
											<p class="wfc-option-description">
												Select pre-loader type.
											</p>
										</div>
										<div class="wfc-option-field">
											<div class="wfc-radion-text">
												<span>
													<input id="preloader-type-spinner" type="radio" name="preloader_type" value="spinner"<?php echo $preloader_type == 'spinner' ? ' checked="checked"' : ''; ?>>
													<label for="preloader-type-spinner"><?php esc_html_e( 'Spinner', 'wfc-toolkit' ); ?></label>
												</span>
												<span>
													<input id="preloader-type-image" type="radio" name="preloader_type" value="image"<?php echo $preloader_type == 'image' ? ' checked="checked"' : ''; ?>>
													<label for="preloader-type-image"><?php esc_html_e( 'Image', 'wfc-toolkit' ); ?></label>
												</span>
												<span>
													<input id="preloader-type-none" type="radio" name="preloader_type" value="none"<?php echo $preloader_type == 'none' ? ' checked="checked"' : ''; ?>>
													<label for="preloader-type-none"><?php esc_html_e( 'None', 'wfc-toolkit' ); ?></label>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div id="preloader-spinner" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Spinner
											</p>
											<p class="wfc-option-description">
												Select spinner.
											</p>
										</div>
										<div class="wfc-option-field">
											<select class="wfc-select" name="preloader_spinner">
												<?php foreach ( $spinners as $spinner ) : ?>
													<option value="<?php echo esc_attr( $spinner ); ?>"<?php echo $spinner == $preloader_spinner ? ' selected="selected"' : ''; ?>><?php echo $spinner; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</div>
								<div id="preloader-spinner-color" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Spinner Color
											</p>
											<p class="wfc-option-description">
												Select color for the spinner.
											</p>
										</div>
										<div class="wfc-option-field">
											<div class="wfc-color-picker">
												<input type="text" name="preloader_spinner_color" value="<?php echo esc_attr( $preloader_spinner_color ); ?>">
											</div>
										</div>
									</div>
								</div>
								<div id="preloader-spinner-size" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Spinner Size
											</p>
											<p class="wfc-option-description">
												Select spinner size.
											</p>
										</div>
										<div class="wfc-option-field">
											<select class="wfc-select" name="preloader_spinner_size">
												<option value="small"<?php echo $preloader_spinner_size == 'small' ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Small', 'wfc-toolkit' ); ?></option>
												<option value="normal"<?php echo $preloader_spinner_size == 'normal' ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Normal', 'wfc-toolkit' ); ?></option>
												<option value="medium"<?php echo $preloader_spinner_size == 'medium' ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Medium', 'wfc-toolkit' ); ?></option>
												<option value="large"<?php echo $preloader_spinner_size == 'large' ? ' selected="selected"' : ''; ?>><?php esc_html_e( 'Large', 'wfc-toolkit' ); ?></option>
											</select>
										</div>
									</div>
								</div>
								<div id="preloader-spinner-image" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Spinner Image
											</p>
											<p class="wfc-option-description">
												The spinner width.
											</p>
										</div>
										<div class="wfc-option-field">
											<div class="wfc-img-upload">
												<input class="wfc-img-upload-field" type="hidden" name="preloader_spinner_image" value="<?php echo esc_attr( $preloader_spinner_image ); ?>">
												<input class="wfc-img-upload-btn" type="button" value="<?php empty( $preloader_spinner_image ) ? esc_html_e( 'Upload Image', 'wfc-toolkit' ) : esc_html_e( 'Change Image', 'wfc-toolkit' ); ?>">
												<div class="wfc-img-upload-preview">
													<?php if ( ! empty( $preloader_spinner_image ) ) : ?>
														<img src="<?php echo esc_url( $preloader_spinner_image ); ?>" />
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="preloader-spinner-width" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Spinner Width
											</p>
											<p class="wfc-option-description">
												The spinner width.
											</p>
										</div>
										<div class="wfc-option-field">
											<div class="wfc-range" data-unit="px">
												<input type="range" name="preloader_spinner_width" min="100" max="800" value="<?php echo esc_attr( $preloader_spinner_width ); ?>">
												<span class="wfc-range-value"><?php echo esc_attr( $preloader_spinner_width ); ?></span>
											</div>
										</div>
									</div>
								</div>
								<div id="preloader-bg-color" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Background Color
											</p>
											<p class="wfc-option-description">
												Select color for the background.
											</p>
										</div>
										<div class="wfc-option-field">
											<div class="wfc-color-picker">
												<input type="text" name="preloader_background" value="<?php echo esc_attr( $preloader_background ); ?>">
											</div>
										</div>
									</div>
								</div>
								<div id="preloader-text" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												preloader_text Text
											</p>
											<p class="wfc-option-description">
												Enter text to be shown in the pre-loader.
											</p>
										</div>
										<div class="wfc-option-field">
											<input type="text" name="preloader_text" value="<?php echo esc_attr( $preloader_text ); ?>">
										</div>
									</div>
								</div>
								<div id="preloader-text-color" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Loading Text Color
											</p>
											<p class="wfc-option-description">
												Select color for the loading text.
											</p>
										</div>
										<div class="wfc-option-field">
											<div class="wfc-color-picker">
												<input type="text" name="preloader_text_color" value="<?php echo esc_attr( $preloader_text_color ); ?>">
											</div>
										</div>
									</div>
								</div>
								<div id="preloader-text-size" class="wfc-option">
									<div class="wfc-option-wrap">
										<div class="wfc-option-info">
											<p class="wfc-option-label">
												Loading Text Size
											</p>
											<p class="wfc-option-description">
												Select text size for the loading text.
											</p>
										</div>
										<div class="wfc-option-field">
											<div class="wfc-range" data-unit="px">
												<input type="range" name="preloader_text_size" min="10" max="100" value="<?php echo esc_attr( $preloader_text_size ); ?>">
												<span class="wfc-range-value"><?php echo esc_attr( $preloader_text_size ); ?></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="wfc-box-footer">
				<input type="hidden" name="action" value="wfc_toolkit_settings">
				<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'wfc_toolkit_settings_nonce' ) ); ?>">
				<button type="submit" class="wfc-btn-submit"><?php esc_html_e( 'Save', 'wfc-toolkit' ); ?></button>
			</div>
		</form>
	</div>
</div>