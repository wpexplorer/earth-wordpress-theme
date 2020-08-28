<?php
/**
 * Social Header Output
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'earth_display_social' ) ) {
	function earth_display_social() {

		$social_links = earth_social_links();

		if ( ! $social_links ) {
			return;
		}

		$output = '<ul id="mastersocial" class="clr">';

			foreach ( $social_links as $key => $val ) {

				if ( $url = earth_get_option( $key ) ) {

					$label = isset( $val['label'] ) ? $val['label'] : ucfirst( $key );

					$output .= '<li class="' . esc_attr( $key ) . '">';

					$output .= '<a href="' . esc_url( $url ) . '" title="' . esc_attr( $label ) . '" target="_blank">';

					if ( earth_get_option( 'header_social_fa', false ) ) {

						$output .= '<span class="' . $val['icon'] . '" aria-hidden="true"></span>';

						$output .= '<span class="screen-reader-text">' . $label . '</span>';

					} else {

						$img = isset( $val['img'] ) ? $val['img'] : EARTH_ASSETS_DIR_URI . 'images/social/' . $key . '.png';

						$output .= '<img src="' . $img . '" alt="' . esc_attr( $label ) . '" />';

					}

					$output .= '</a>';

					$output .= '</li>';
				
				}
			}
		$output .= '</ul>';

		$output = apply_filters( 'wpex_display_social', $output ); // @todo deprecate

		echo apply_filters( 'earth_display_social', $output );


	}

}

if ( ! function_exists( 'wpex_display_social' ) ) {
	function wpex_display_social() {
		return earth_display_social();
	}
}