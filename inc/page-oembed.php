<?php
/**
 * Page oembed output
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'earth_post_oembed' ) ) {
	function earth_post_oembed() {
		if ( is_singular( 'page' ) && $oembed = get_post_meta( get_the_ID(), 'earth_page_oembed', true ) ) { ?>
			<div id="page-oembed-shortcode" class="clearfix et-fitvids">
				<div class="responsive-embed-wrap clr"><?php echo wp_oembed_get( $oembed ); ?></div>
			</div>
		<?php }
	}
}

// Deprecated
if ( ! function_exists( 'wpex_post_oembed' ) ) {
	function wpex_post_oembed() {
		return earth_post_oembed();
	}
}