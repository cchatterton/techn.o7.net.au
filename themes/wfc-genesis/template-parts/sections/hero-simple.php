<?php
/**
 *  Hero section (For Pages) 
 * 
 */
    global $post;

    $id		    = wfc_get_page_id();;

	$wfc_adaptive_image = get_post_meta( $id, 'wfc_adaptive_image', true );
	
	$bg_lg_xpos     = get_post_meta( $id, 'wfc_heroimages_large-xpos', true );
    $bg_lg_ypos     = get_post_meta( $id, 'wfc_heroimages_large-ypos', true );
    $bg_lg_pos      = ( ! empty( $bg_lg_ypos ) && ! empty( $bg_lg_xpos ) ) ? "{$bg_lg_ypos} {$bg_lg_xpos}" : 'center';
	
	if ( ! empty( $wfc_adaptive_image ) ) {
		
    /**
     * Check if the heroimages meta for small exists and use it. If it doesn't, check if the meta for medium exists and use it,
     * If medium also doesn't exist, check if the meta for large exists. If it also doesn't exist, fail graceful.
     */
    $bg_sm = ! empty( get_post_meta( $id, 'wfc_heroimages_small', true ) ) ? get_post_meta( $id, 'wfc_heroimages_small', true ) : get_post_meta( $id, 'wfc_heroimages_medium', true );
    $bg_sm = ! empty( $bg_sm ) ? $bg_sm : get_post_meta( $id, 'wfc_heroimages_large', true );
    $bg_sm = ! empty( $bg_sm ) ? $bg_sm : wfc_get_image( $id, 'hero', 'small' );

    /**
     * Check if the heroimages meta for medium exists and use it. If it doesn't, check if the meta for large exists and use it.
     * If it doesn't, fail graceful.
     */
    $bg_md = ! empty( get_post_meta( $id, 'wfc_heroimages_medium', true ) ) ? get_post_meta( $id, 'wfc_heroimages_medium', true ) : get_post_meta( $id, 'wfc_heroimages_large', true );
    $bg_md = ! empty( $bg_md ) ? $bg_md : wfc_get_image( $id, 'hero', 'medium' );

    /**
     * Check if the heroimages meta for large exists and use it. If it doesn't, fail graceful
     */
    $bg_lg = ! empty( get_post_meta( $id, 'wfc_heroimages_large', true ) ) ? get_post_meta( $id, 'wfc_heroimages_large', true ) : wfc_get_image( $id, 'hero', 'large' );
		
		$bg_sm_xpos     = get_post_meta( $id, 'wfc_heroimages_small-xpos', true );
		$bg_sm_ypos     = get_post_meta( $id, 'wfc_heroimages_small-ypos', true );  
		$bg_sm_pos      = ( !empty( $bg_sm_ypos ) && !empty( $bg_sm_xpos ) ) ? "{$bg_sm_ypos} {$bg_sm_xpos}" : 'center';

		$bg_md_xpos     = get_post_meta( $id, 'wfc_heroimages_medium-xpos', true );
		$bg_md_ypos     = get_post_meta( $id, 'wfc_heroimages_medium-ypos', true ); 
		$bg_md_pos      = ( !empty( $bg_md_ypos ) && !empty( $bg_md_xpos ) ) ? "{$bg_md_ypos} {$bg_md_xpos}" : 'center';
	
	} else {
        $bg_lg = wfc_get_image( $id, 'hero', 'large' );
		
		$bg_sm = $bg_lg;
		$bg_md = $bg_lg;
		
		$bg_sm_pos = $bg_lg_pos;
		$bg_md_pos = $bg_lg_pos;
		
	}
	
    $height_sm  = is_front_page() ? get_theme_mod( 'hero_height_home_sm', '18.75rem' ) : get_theme_mod( 'hero_height_other_sm', '18.75rem' );
    $height_md  = is_front_page() ? get_theme_mod( 'hero_height_home_md', '28.125rem' ): get_theme_mod( 'hero_height_other_md', '28.125rem' );
	$height_lg 	= is_front_page() ? get_theme_mod( 'hero_height_home_lg', '37.5rem' ) : get_theme_mod( 'hero_height_other_lg', '37.5rem' );
	
	$page_title = wfc_get_page_title_by_path();
	
?>
<style>
    .hero-bg {
        min-height: <?php echo $height_sm; ?>;
        background-image: url(<?php echo $bg_sm; ?>);
        background-position: <?php echo $bg_sm_pos; ?>;
    }

    @media (min-width: 36rem) {
        .hero-bg {
            min-height: <?php echo $height_md; ?>;
            background-image: url(<?php echo $bg_md; ?>);
            background-position: <?php echo $bg_md_pos; ?>;
        }
    }

    @media (min-width: 62rem) {
        .hero-bg {
			min-height: <?php echo $height_lg; ?>;
            background-image: url(<?php echo $bg_lg; ?>);
            background-position: <?php echo $bg_lg_pos; ?>;
        }
    }
</style>
<section class="container-fluid outer hero simple">
    <div class="wrapper inner">
        <div class="row">
            <div class="col-sm col-md col-lg hero-bg"></div>
        </div>
        <div class="row">
            <p class="col-sm col-md col-lg hero-title h2"><?php echo $page_title; ?></p>
        </div>
    </div>
</section>