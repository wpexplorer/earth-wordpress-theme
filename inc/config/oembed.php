<?php
/**
 * Filter the oEmbed output
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_embed_oembed_html( $cache, $url, $attr, $post_ID ) {

	// Remove frameborder
	$cache = str_replace( 'frameborder="0"', '', $cache );

	// Supported video embeds
	$hosts = apply_filters( 'earth_oembed_responsive_hosts', array(
		'vimeo.com',
		'youtube.com',
		'blip.tv',
		'money.cnn.com',
		'dailymotion.com',
		'flickr.com',
		'hulu.com',
		'kickstarter.com',
		'vine.co',
		'soundcloud.com',
	) );

	// Supports responsive
	$supports_responsive = false;

	// Check if responsive wrap should be added
	foreach( $hosts as $host ) {
		if ( strpos( $url, $host ) !== false ) {
			$supports_responsive = true;
			break; // no need to loop further
		}
	}

	// Output code
	if ( $supports_responsive ) {
		return '<p class="responsive-embed-wrap clr">' . $cache . '</p>';
	} else {
		return $cache;
	}

}
add_filter( 'embed_oembed_html', 'earth_embed_oembed_html', 99, 4 );