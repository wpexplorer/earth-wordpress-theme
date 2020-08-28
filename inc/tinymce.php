<?php
/**
 * Tiny MCE Tweaks
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add font select sizes to mce
function earth_mce_buttons_2( $buttons ) {
	array_shift( $buttons );
	array_unshift( $buttons, 'fontsizeselect');
	array_unshift( $buttons, 'formatselect');
	return $buttons;
}
add_filter( 'mce_buttons_2', 'earth_mce_buttons_2' );

function earth_mce_font_sizes( $initArray ){
	$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
	return $initArray;
}
add_filter( 'tiny_mce_before_init', 'earth_mce_font_sizes' );