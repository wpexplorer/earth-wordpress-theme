<?php
/**
 * Tweak default image sizes
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_image_size( 'full-size',  9999, 9999, false );
add_image_size( 'small-thumb',  60, 60, true );