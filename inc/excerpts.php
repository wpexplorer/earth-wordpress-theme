<?php
/**
 * Excerpt settings
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Limit excerpt length
if ( ! function_exists( 'earth_excerpt_length' ) ) {
	function earth_excerpt_length($length) {
		global $data;
		return earth_get_option( 'blog_excerpt_length', '35' );
	}
}
add_filter( 'excerpt_length', 'earth_excerpt_length' );

// Change default readmore
if ( ! function_exists( 'earth_excerpt_more' ) ) {
	function earth_excerpt_more($more) {
		global $post;
		if ( !is_search() ) {
			return '...';
		}
	}
}
add_filter( 'excerpt_more', 'earth_excerpt_more' );