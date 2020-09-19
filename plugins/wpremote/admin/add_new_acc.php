<?php
		$signupFormTitle = "Let's add your site for remote management";
		$signupPurpose = array("Manage", "Others");
		$signupButtonText = "Get started";
		$signupButtonColor = "#25bea0";
?>
<div id="content-wrapper" style="width: 99%">
	<div class="mui-container-fluid" style="padding: 0px;">
		<div style="padding-left: 0px; width: 80%; margin: 0 auto;">
			<br>
			<div class="bv-box" style="padding-top: 10px; padding-bottom: 10px; margin: 0 auto;">
			<?php require_once dirname( __FILE__ ) . "/top_box.php";?>
			</div>
			<div class="mui-panel new-account-panel">
				<form dummy=">" action="<?php echo $this->bvinfo->appUrl(); ?>/plugin/bvstart" style="padding-top:10px; margin: 0px;" onsubmit="document.getElementById('get-started').disabled = true;"  method="post" name="signup">
					<div style="width: 800px; margin: 0 auto; padding: 10px;">
					<div class="mui--text-title form-title"><?php echo $signupFormTitle; ?></div>
						<input type='hidden' name='bvsrc' value='wpplugin' />
							<?php echo $this->siteInfoTags(); ?>
						<input type="text" class="bv-input" id="email" name="email" style="width:430px;" placeholder="Enter your email" required>
						<button id="get-started" class="mui-btn mui-btn--raised mui-btn--primaryi get-started-button" type="submit" style="background: <?php echo $signupButtonColor; ?>;"><?php echo $signupButtonText; ?></button><br/>
						<input type="checkbox" name="consent" value="1" required/>I agree to WPRemote <a href="https://wpremote.com/tos/" target="_blank" rel="noopener noreferrer">Terms of Service</a> and <a href="https://wpremote.com/privacy/" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
					</div>
				</form>
				<br/>
			</div>
		</div>
</div>