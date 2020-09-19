<?php

// Remove sidebar in 404 page
remove_action('genesis_sidebar', 'genesis_do_sidebar');

/**
 * Replace 404 content with custom message
 */
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', function() {

	$title	= __( 'Sorry, we could not find what you were looking for. Please try another page.', 'wfc-genesis');
	?>
		<p class="h2"><?php echo $title; ?></p>
	<?php

});

genesis();