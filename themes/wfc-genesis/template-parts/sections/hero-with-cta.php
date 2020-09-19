<?php

$post_id = wfc_get_page_id();

$wfc_adaptive_image = get_post_meta( $post_id, 'wfc_adaptive_image', true );

$hero_img_lg_x_pos = get_post_meta( $post_id, 'wfc_heroimages_large-xpos', true  ) == false ? 'center' : get_post_meta( $post_id, 'wfc_heroimages_large-xpos', true  );
$hero_img_lg_y_pos = get_post_meta( $post_id, 'wfc_heroimages_large-ypos', true ) == false ? 'center' : get_post_meta( $post_id, 'wfc_heroimages_large-ypos', true );

/* Check if Adaptive Image is enabled */
if ( ! empty( $wfc_adaptive_image ) ) {

	/**
	 * Check if the heroimages meta for small exists and use it. If it doesn't, check if the meta for medium exists and use it,
	 * If medium also doesn't exist, check if the meta for large exists. If it also doesn't exist, fail graceful.
	 */
	$hero_img_sm = ! empty( get_post_meta( $post_id, 'wfc_heroimages_small', true ) ) ? get_post_meta( $post_id, 'wfc_heroimages_small', true ) : get_post_meta( $post_id, 'wfc_heroimages_medium', true );
	$hero_img_sm = ! empty( $hero_img_sm ) ? $hero_img_sm : get_post_meta( $post_id, 'wfc_heroimages_large', true );
	$hero_img_sm = ! empty( $hero_img_sm ) ? $hero_img_sm : wfc_get_image( $post_id, 'hero', 'small' );

	/**
	 * Check if the heroimages meta for medium exists and use it. If it doesn't, check if the meta for large exists and use it.
	 * If it doesn't, fail graceful.
	 */
	$hero_img_md = ! empty( get_post_meta( $post_id, 'wfc_heroimages_medium', true ) ) ? get_post_meta( $post_id, 'wfc_heroimages_medium', true ) : get_post_meta( $post_id, 'wfc_heroimages_large', true );
	$hero_img_md = ! empty( $hero_img_md ) ? $hero_img_md : wfc_get_image( $post_id, 'hero', 'medium' );

	/**
	 * Check if the heroimages meta for large exists and use it. If it doesn't, fail graceful
	 */
	$hero_img_lg = ! empty( get_post_meta( $post_id, 'wfc_heroimages_large', true ) ) ? get_post_meta( $post_id, 'wfc_heroimages_large', true ) : wfc_get_image( $post_id, 'hero', 'large' );

	$hero_img_md_x_pos =  get_post_meta( $post_id, 'wfc_heroimages_medium-xpos', true  ) == false ? 'center' : get_post_meta( $post_id, 'wfc_heroimages_medium-xpos', true  );
	$hero_img_md_y_pos =  get_post_meta( $post_id, 'wfc_heroimages_medium-ypos', true  ) == false ? 'center' : get_post_meta( $post_id, 'wfc_heroimages_medium-ypos', true  );
	$hero_img_sm_x_pos =  get_post_meta( $post_id, 'wfc_heroimages_small-xpos', true  ) == false ? 'center' : get_post_meta( $post_id, 'wfc_heroimages_small-xpos', true  );
	$hero_img_sm_y_pos =  get_post_meta( $post_id, 'wfc_heroimages_small-ypos', true  ) == false ? 'center' : get_post_meta( $post_id, 'wfc_heroimages_small-ypos', true  );
		
} else {
	$hero_img_lg = wfc_get_image( $post_id, 'hero', 'large' );
	
	$hero_img_md = $hero_img_lg;
	$hero_img_sm = $hero_img_lg;
	
	$hero_img_md_x_pos =  $hero_img_lg_x_pos;
	$hero_img_md_y_pos =  $hero_img_lg_y_pos;
	$hero_img_sm_x_pos =  $hero_img_lg_x_pos;
	$hero_img_sm_y_pos =  $hero_img_lg_y_pos;
	
}

$hero_height_sm = is_front_page() ? get_theme_mod( 'hero_height_home_sm', '18.75rem' ) : get_theme_mod( 'hero_height_other_sm', '18.75rem' );
$hero_height_md = is_front_page() ? get_theme_mod( 'hero_height_home_md', '28.125rem' ): get_theme_mod( 'hero_height_other_md', '28.125rem' );
$hero_height_lg = is_front_page() ? get_theme_mod( 'hero_height_home_lg', '37.5rem' ) : get_theme_mod( 'hero_height_other_lg', '37.5rem' );
$hero_bg_color_sm = get_theme_mod( 'header_background_color', '#ffffff' );
$hero_text_color = get_theme_mod( 'hero_text_color', '#ffffff' );


$page_title = wfc_get_page_title_by_path();

if ( has_excerpt( $post_id ) ) { 
	$cta_subtitle = get_the_excerpt( $post_id );
}

$cta_label = get_post_meta( $post_id, 'wfc_hero_cta_label', true );
$cta_url = get_post_meta( $post_id, 'wfc_hero_cta_url', true );

?>
<style>

	.hero-img-back {
		width: 100%;
	}   
	
	.hero-img-back {
		background-image: url( <?php echo $hero_img_sm; ?> );
		background-position: <?php echo sprintf( '%s %s', $hero_img_sm_x_pos, $hero_img_sm_y_pos ); ?>;
	}

	.hero {
		height: <?php echo $hero_height_sm; ?>;
	}

	.hero-sm-overlay-front {
		background-image:url(<?php echo $hero_img_sm?>);
		height:<?php echo $hero_height_sm; ?>
	}

	.hero-text-color {
		color: <?php echo $hero_text_color; ?>;
	}
	@media ( min-width: 36rem ) {		
		.hero-img-back {
			background-image: url( <?php echo $hero_img_md; ?> );
			background-position: <?php echo sprintf( '%s %s', $hero_img_md_x_pos, $hero_img_md_y_pos ); ?>;
		}

		.hero {
			height: <?php echo $hero_height_md; ?>;
		}
	}

	@media ( min-width: 62rem ) {
		.hero-img-back {
			background-image: url( <?php echo $hero_img_lg; ?> );
			background-position: <?php echo sprintf( '%s %s', $hero_img_lg_x_pos, $hero_img_lg_y_pos ); ?>;
		}

		.hero {
			height: <?php echo $hero_height_lg; ?>;
		}
	}
</style>

<section class="container-fluid outer hero d-none d-md-block">
	<div class="wrapper inner hero-wrap">
		<div class="row w-100">
			<div class="hero-text-color hero-info-wrap align-items-center col-sm-6 col-md-8 col-lg-6 d-flex order-2 order-md-1">
				<div class="hero-info">
					<h2><?php echo $page_title; ?></h2>
					<?php if( !empty( $cta_subtitle ) ) : ?>
						<p><?php echo $cta_subtitle; ?></p>
					<?php endif; ?>
					<?php if( !empty( $cta_label ) && !empty( $cta_url ) ) : ?>
						<a href="<?php echo $cta_url?>" class="btn btn-primary"><?php echo $cta_label; ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="hero-img-back"></div>
</section>

<section class="container-fluid outer hero-sm d-block d-md-none w-100">
	<div class="wrapper inner">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 w-100 hero-sm-overlay-front"></div>
			<div class="col-sm col-md col-lg w-100">
				<div class="row d-flex d-md-none align-items-center h-100">
					<div class="col-sm col-md col-lg text-left hero-text-color hero-info">
						<h2><?php echo $page_title; ?></h2>
						<?php if( !empty( $cta_subtitle ) ) : ?>
							<p><?php echo $cta_subtitle; ?></p>
						<?php endif; ?>
						<?php if( !empty( $cta_label ) && !empty( $cta_url ) ) : ?>
							<a href="<?php echo $cta_url?>" class="btn btn-primary"><?php echo $cta_label; ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
