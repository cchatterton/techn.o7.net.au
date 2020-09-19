<div class="wrapper inner">
	<div class="row">
		<div class="col-sm col-md col-lg">
			<div class="footer-logo">
				<a href="<?php echo esc_url( home_url() ); ?>">
					<img class="img-fluid" src="<?php echo esc_url( wfc_get_main_logo() ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				</a>
			</div>
		</div>
		<div class="col-sm col-md-6 col-lg-6">
			<div class="footer-menu">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'footer'
					) );
				?>
			</div>
		</div>
		<div class="col-sm col-md col-lg">
			<div class="footer-social">
				<!-- Go to www.addthis.com/dashboard to customize your tools -->
				<div class="addthis_inline_follow_toolbox"></div>
			</div>
		</div>
	</div>
</div>