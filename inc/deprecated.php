<?php
/**
 * Deprecated functions
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wpex_get_attachment( $attachment ) {
	return wpex_get_attachment_data( $attachment );
}

function earth_get_data( $id, $fallback = false ) {
	return earth_get_option( $id, $fallback );
}