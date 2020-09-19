<div class="site-offcanvas">

    <div class="container toggle-container">
		<span class="site-offcanvas-close nav-toggle"><i class="fas fa-times"></i></span>
     </div>

	<div class="container overflow-auto m-auto">
		<?php

		wp_nav_menu( array(
            'theme_location'    => 'offcanvas-menu',
            'container'         => 'ul',
            'container_class'   => 'container'
		) );
		?>

	</div>
</div>