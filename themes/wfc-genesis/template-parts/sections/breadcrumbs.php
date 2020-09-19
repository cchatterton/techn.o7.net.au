<?php
/**
 * Section Name: breadcrumbs
 * Description: Section to use for displaying the breadcrumbs.
 * 
 * Use wfc_get_section( 'breadcrumbs' ) in the template to use this section.
 * 
 */
global $post;

if ( wp_get_post_parent_id( $post ) ) {
	?>
	<section class="container-fluid outer breadcrumbs d-none d-md-block">
		<div class="wrapper inner">
			<div class="row">
				<div class="col-sm col-md col-lg">
					<?php WFC_Yoast_Breadcrumbs::yoast_breadcrumbs_markup(); ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}