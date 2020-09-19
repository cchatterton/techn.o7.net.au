<?php
		$pluginSlug = "wpremote";
		$headerLogoLink = $this->getWebPage() . "/?utm_source=mc_plugin_lp_logo&utm_medium=logo_link&utm_campaign=mc_plugin_lp_header&utm_term=header_logo&utm_content=image_link";
?>
<div id="content-wrapper" style="width: 99%;">
	<!-- Content HTML goes here -->
	<div class="mui-container-fluid">
		<div class="mui--appbar-height"></div>
		<br><br>
		<div class="mui-row">

			<div style="background: linear-gradient(to right, #2c3e50, #586f87); overflow: hidden;">
				<a href="<?php echo $headerLogoLink; ?>"><img src="<?php echo plugins_url($this->getPluginLogo(), __FILE__); ?>" style="width:13%; padding: 10px;"></a>
				<div class="top-links">
					<span class="bv-top-button"><a href="https://wordpress.org/support/plugin/<?php echo $pluginSlug; ?>/reviews/#new-post">Leave a Review</a></span>
					<span class="bv-top-button"><a href="https://wordpress.org/support/plugin/<?php echo $pluginSlug; ?>/">Need Help?</a></span>
				</div>
			</div>
		</div>
	</div>
</div>