<?php
/**
 * Loads custom fonts in header
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_body_classes( $classes ) {
	if ( earth_get_option( 'responsive', true ) ) {
		$classes[] = 'earth-responsive';
	}
	if ( earth_get_option( 'menu_arrows', true ) ) {
		$classes[] = 'earth-menu-arrows';
	}
	$classes[] = earth_get_post_layout();
	return $classes;
}
add_filter( 'body_class', 'earth_body_classes' );