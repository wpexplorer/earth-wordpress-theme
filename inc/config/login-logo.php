<?php
/**
 * Custom admin login logo
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
if ( ! function_exists( 'earth_custom_login_logo' ) ) {

	function earth_custom_login_logo() {

		if ( $logo = earth_get_option( 'custom_login_logo' ) ) {

			echo '<style type="text/css">';

				echo '.login h1 a {';

				echo 'background-image:url('. esc_url( $logo ) .') !important;width: auto !important;background-size: auto !important;';
				
				if ( $logo_height = earth_get_option( 'custom_login_logo_height' ) ) {
					echo 'height: '. esc_attr( $logo_height ) .' !important;';
				}
				
			echo '}</style>';

	
		}

	}

}
add_action( 'login_head', 'earth_custom_login_logo' );