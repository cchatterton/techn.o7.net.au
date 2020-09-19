<?php
/*
*	Topbar Section
*/
?>
<section class="topbar container-fluid outer">
	<div class="wrapper inner">
		<div class="row">
			<div class="col-sm col-md col-lg">
				<div class="d-flex justify-content-between">
					<div class="logo">
						<a href="<? echo esc_url( get_site_url() ); ?>"> 
							<img src="<?php echo esc_url( wfc_get_main_logo() ); ?>" alt="<?php echo __( 'Logo', 'wfc-genesis' ); ?>"> 
						</a>
					</div>
					<nav class="primary-nav">
					<?php 
						if ( has_nav_menu( 'main' ) ) {
							$args = array(
								'menu_class' => 'nav',        
								'theme_location' => 'main',
								'container_class' => 'main-nav',
								'item_spacing' => 'discard'
							);
							wp_nav_menu( $args );
						}
					?>
					<div class="menu-toggle">
						<a class="nav-toggle" href="#">
							<i class="fas fa-bars"></i>
						</a>
					</div>
					<div class="site-search menu-search-popup">
						<a href="#">
							<i class="far fa-search"></i>
						</a>
					</div>
					<?php 
					if ( has_nav_menu( 'cta' ) ) {
						$args = array(
							'menu_class' => 'nav',        
							'theme_location' => 'cta',
							'container_class' => 'cta-nav',
							'item_spacing' => 'discard'
						);
						wp_nav_menu( $args );
					}
					?>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>

