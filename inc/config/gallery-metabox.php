<?php
/**
 * Gallery metabox settings
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Change gallery metabox post types
function earth_gallery_metabox_config() {
	return array(
		'post_types' => array( 'events', 'gallery' ),
		'dir_uri'    => EARTH_INC_DIR_URI .'lib/wpex-gallery-metabox/',
		'lightbox'   => false,
	);
}
add_filter( 'wpex_gallery_metabox_config', 'earth_gallery_metabox_config' );