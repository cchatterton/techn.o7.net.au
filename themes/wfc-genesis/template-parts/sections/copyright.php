<?php

$copyright_statement 	= get_theme_mod( 'copyright_statement' );
$bg_color 				= get_theme_mod( 'copyright_background_color', '#007bff' );
$text_color 			= get_theme_mod( 'copyright_text_color', '#ffffff' );

?>
<style>
	.footer-copyright {
		background-color: <?php echo $bg_color; ?>;
	}
	.footer-copyright span, .footer-copyright a {
		color: <?php echo $text_color; ?>;
	}
	.footer-copyright a:hover {
		text-decoration: none;
	}
</style>
<section class="container-fluid outer footer-copyright">
	<div class="wrapper inner">
		<div class="row">
			<div class="col-sm col-md col-lg">
				<span class="float-left"><?php echo $copyright_statement; ?></span>
				<span class="float-right">Website by <a href="<?php echo esc_url( 'https://alphasys.com.au/' ); ?>">AlphaSys</a></span>
			</div>
		</div>
	</div>
</section>