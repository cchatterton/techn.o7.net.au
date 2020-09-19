<?php
/**
 * WFC Genesis.
 *
 * This file contains google font api functionality.
 *
 * @package WFC_Genesis/Core
 * @author  AlphaSys
 */

/**
 * class `WFC_Google_Fonts_Control`.
 * 
 * Register a customizer Google Fonts dropdown control.
 */
class WFC_Google_Fonts_Control extends WP_Customize_Control {

    public function render_content() {

    	$id = esc_attr( $this->id );
    	$value = $this->value();
    	$google_fonts = $this->get_google_fonts();
    	$fallback_fonts = $this->get_fallback_fonts();

        ?>

            <label class='wfc-font-list'>
                <span class='customize-control-title'><?php echo esc_html( $this->label ) ?></span>
                <span class='description customize-control-description'><?php echo esc_html( $this->description ) ?></span>
            	<select id='<?php echo $id; ?>' name='<?php echo $id; ?>' data-customize-setting-link='<?php echo $id; ?>'>
                	<?php
                		if ( $this->type == 'googlefonts' ) {

	                		echo '<option value="">Default Font</option>';
	            			echo '<optgroup label="-- Google Fonts --">';
	                        foreach ( $google_fonts as $font ) {
	                            printf( '<option value="%1$s" %2$s>%1$s</option>', $font[ 'family' ], selected( $value, $font[ 'family' ], false ) );
	                        }
	                        echo '</optgroup>';

	                    } elseif ( $this->type == 'fallbackfonts' ) {

							foreach ( $fallback_fonts as $font ) {
	                            printf( '<option value="%s" %s>%s</option>', $font[ 'value' ], selected( $value, $font[ 'value' ], false ), $font[ 'label' ] );
	                        }

						}
                    ?>
                </select>
            </label>

        <?php

    }

    /**
	 * Get Google Fonts font listing.
	 * 
	 * @return Array Google Fonts font array.
	 */
	public function get_google_fonts() {

		if ( get_transient( 'wfc_google_fonts' ) ) {

        	$fonts = get_transient( 'wfc_google_fonts' );

	    } else {

	    	$api_key = get_theme_mod( 'google_api_key', false );
	    	$api_key = ( $api_key ) ? $api_key : 'AIzaSyA2HFVb-wF8PupiqpgNtAid-0hFcZxo28Y';
	        $api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=' . $api_key;
	        $api_response = wp_remote_get( $api_url, array( 'sslverify' => false ) );
	        $body = json_decode( $api_response[ 'body' ], true );
	        $fonts = isset( $body[ 'items' ] ) ? $body[ 'items' ] : [];

	        if ( count( $fonts ) )
	        	set_transient( 'wfc_google_fonts', $fonts, 0 );

	    }

	    return $fonts;

	}

	/**
	 * Get Fallback font listing.
	 * 
	 * @return Array Fallback font array.
	 */
	public function get_fallback_fonts() {

		$fallback_fonts = array(
			array(
				'label' => esc_html__( 'Arial', 'olympus-google-fonts' ),
				'value' => 'Arial, Helvetica Neue, Helvetica, sans-serif',
			),
			array(
				'label' => esc_html__( 'Calibri', 'olympus-google-fonts' ),
				'value' => 'Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;',
			),
			array(
				'label' => esc_html__( 'Consolas', 'olympus-google-fonts' ),
				'value' => 'Consolas, monaco, monospace',
			),
			array(
				'label' => esc_html__( 'Courier New', 'olympus-google-fonts' ),
				'value' => 'Courier New, Courier, Lucida Sans Typewriter, Lucida Typewriter, monospace',
			),
			array(
				'label' => esc_html__( 'Helvetica', 'olympus-google-fonts' ),
				'value' => 'Helvetica Neue, Helvetica, Arial, sans-serif',
			),
			array(
				'label' => esc_html__( 'Georgia', 'olympus-google-fonts' ),
				'value' => 'Georgia, Times, Times New Roman, serif',
			),
			array(
				'label' => esc_html__( 'Futura', 'olympus-google-fonts' ),
				'value' => 'Futura, Trebuchet MS, Arial, sans-serif',
			),
			array(
				'label' => esc_html__( 'Lucida Grande', 'olympus-google-fonts' ),
				'value' => 'Lucida Grande, Lucida Sans Unicode, Lucida Sans, Geneva, Verdana, sans-serif',
			),
			array(
				'label' => esc_html__( 'Tahoma', 'olympus-google-fonts' ),
				'value' => 'Tahoma, Verdana, Segoe, sans-serif',
			),
			array(
				'label' => esc_html__( 'Times New Roman', 'olympus-google-fonts' ),
				'value' => 'TimesNewRoman, Times New Roman, Times, Baskerville, Georgia, serif',
			),
			array(
				'label' => esc_html__( 'Trebuchet MS', 'olympus-google-fonts' ),
				'value' => 'Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif',
			),
			array(
				'label' => esc_html__( 'Palatino', 'olympus-google-fonts' ),
				'value' => 'Palatino, Palatino Linotype, Palatino LT STD, Book Antiqua, Georgia, serif',
			),
			array(
				'label' => esc_html__( 'Verdana', 'olympus-google-fonts' ),
				'value' => 'Verdana, Geneva, sans-serif;',
			),
		);

		return $fallback_fonts;

	}

}