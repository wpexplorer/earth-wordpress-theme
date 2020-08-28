<?php
/**
 * Pre Get Posts Filter
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_pre_get_posts( $query ) {

	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( is_post_type_archive( 'gallery' ) || is_tax( 'gallery_cats') ) {
		$query->set( 'posts_per_page', '12' );
		return;
	}

	if ( is_post_type_archive( 'events' ) ) {
		$query->set( 'posts_per_page', '12' );
		return;
	}

	if ( is_post_type_archive( 'faqs' ) ) {
		$query->set( 'posts_per_page', '-1' );
		return;
	}

	if ( is_search() ) {
		$query->set( 'posts_per_page', '6' );
		return;
	}

}
add_action( 'pre_get_posts', 'earth_pre_get_posts' );