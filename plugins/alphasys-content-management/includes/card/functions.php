<?php

/**
 * Function Name: ascm_get_magic_card() 
 * Author: Carl Ortiz
 * Short Description: Returns card template enter in markup metabox and
 * replace all template variables with actual data.
 *
 * @since 1.2.0
 *
 * @param string $template Magic card slug.
 * @param int $id The ID of the post in which the data will come from.
 * 
 * @return string|bool Returns the card template, returns false if ID
 * 					   doesn't exist or the card doesn't exist.
 */
function _ascm_get_magic_card( $template, $id = 0 ) {

	$id = absint( $id );

	if ( ! $id ) {
		$id = get_the_ID();
	}

	if ( get_post_status( $id ) !== 'publish' ) {
		return false;
	}

	$card_p = get_page_by_path( $template, OBJECT, 'ascm-magic-card' );

	if ( $card_p !== null ) {
		$markup = get_post_meta( $card_p->ID, 'ascm_magic_card_markup', true );
		$markup = htmlspecialchars_decode( $markup );

		// Collect all template variables.
		$matched_vars 		= array();
		$tpl_vars 			= array();
		$tpl_placeholders 	= array();

		preg_match_all( '/%%(.*)%%/U', $markup, $matched_vars );

		if ( isset( $matched_vars[0] ) ) {
			$tpl_placeholders = $matched_vars[0];
		}

		if ( isset( $matched_vars[1] ) ) {
			$tpl_vars = $matched_vars[1];
		}

		// Replace placeholders with actual data.
		// Flags
		$get_post 	= false;
		$get_meta 	= false;

		// Data sources variables.
		$source_post = null;
		$source_meta = null;

		$to_be_replaced 	= array();
		$data_to_replace 	= array();

		foreach ( $tpl_vars as $i => $v ) {
			$get_post = $get_post || strpos( $v, '$post->' ) !== false;
			$get_meta = $get_meta || strpos( $v, '$meta->' ) !== false;

			if ( $get_post && is_null( $source_post ) ) {
				$source_post = function_exists( 'wfc_get_post' ) ? wfc_get_post( $id ) : get_post( $id );
			}

			if ( $get_meta && is_null( $source_meta ) ) {
				$source_meta = function_exists( 'wfc_get_post_meta' ) ? wfc_get_post_meta( $id ) : get_post_meta( $id );
			}

			$temp_val = "";
			$temp_ph = "";

			// Replace placeholder using post object as source.
			if ( strpos( $v, '$post->' ) === 0 && ! is_null( $source_post ) ) {
				$temp_var = substr( $v, strlen( '$post->' ) );
				$temp_ph = $tpl_placeholders[$i];

				if ( property_exists( $source_post, $temp_var ) ) {
					$temp_val = $source_post->{$temp_var};
				}
			}
			// Replace placeholder using meta as source.
			elseif ( strpos( $v, '$meta->' ) === 0 && ! is_null( $source_meta ) ) {
				$temp_var = substr( $v, strlen( '$meta->' ) );
				$temp_ph = $tpl_placeholders[$i];

				if ( isset( $source_meta[$temp_var] ) && isset( $source_meta[$temp_var][0] ) && ! is_array( $source_meta[$temp_var][0] ) ) {
					$temp_val = $source_meta[$temp_var][0];
				}
			}
			// Replace placeholder using ACF as source.
			elseif ( strpos( $v, '$acf->' ) === 0 && ! is_null( $source_meta ) && function_exists( 'get_field' ) ) {
				$temp_var = substr( $v, strlen( '$acf->' ) );
				$val = get_field( $temp_var, $id );
				$temp_ph = $tpl_placeholders[$i];

				if ( ! is_array( $val ) && ! is_object( $val ) ) {
					$temp_val = $val;
				}
			}
			// Replace placeholder using Options as source.
			elseif ( strpos( $v, '$option->' ) === 0 ) {
				$temp_var = substr( $v, strlen( '$option->' ) );//var_dump($temp_var, get_option($temp_var));die();
				$val = get_option( $temp_var, '' );
				$temp_ph = $tpl_placeholders[$i];

				if ( ! is_array( $val ) && ! is_object( $val ) ) {
					$temp_val = $val;
				}
			}
			// Replace placeholder using Options as source.
			elseif ( strpos( $v, '$image->' ) === 0 && function_exists( 'wfc_get_image' ) ) {
				global $as3cf;

				$temp_var = substr( $v, strlen( '$image->' ) );
				$val = wfc_get_image( $id, $temp_var, 'large' );
				$temp_ph = $tpl_placeholders[$i];

				if ( $as3cf ) {
					$val = $as3cf->filter_local->filter_post( $val );
				}
				
				if ( $val ) {
					$temp_val = $val;
				}
			}

			if ( ! empty( $temp_ph ) ) {
				$to_be_replaced[] = $temp_ph;
				$data_to_replace[] = $temp_val;
			}
		}

		return str_replace( $to_be_replaced, $data_to_replace, $markup );
	}

	return false;
}