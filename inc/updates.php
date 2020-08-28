<?php
/**
 * Theme update functions
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_updates() {

	// Migrate old background URL to new background
	if ( $bg = earth_get_option( 'custom_bg' ) ) {
		if ( false === strpos( $bg, 'assets' ) ) {
			$bg = str_replace( get_template_directory_uri() . '/', EARTH_ASSETS_DIR_URI, $bg );
			set_theme_mod( 'custom_bg', $bg );
		}
	}

}
add_action( 'init', 'earth_updates' );