<?php
/**
 * Page slider output
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'earth_page_slider' ) ) {
	
	function earth_page_slider() {
		
		// Prevent slider display here
		if ( ! is_singular() || is_paged() ) {
			return;
		}
		
		// Get vars
		$slider_shortcode  = get_post_meta( get_the_ID(), 'earth_page_slider_shortcode', true );
		$earth_flickr_show = get_post_meta(get_the_ID(), 'earth_flickr_show', TRUE);
		$img_slider_cat    = get_post_meta( get_the_ID(), 'earth_img_slider_cat', TRUE );
		
		// Shortcode Slider
		if ( $slider_shortcode ) { ?>
			<div id="page-slider-shortcode" class="clearfix"><?php echo do_shortcode( $slider_shortcode ); ?></div>
		<?php }
		
		// Homepage Slider
		if ( is_front_page() ) {
			earth_get_template_part( 'home/slides', 'includes/home/slides' );
		}
		
		// Page Slider
		if ( $img_slider_cat ) {
			
			// Regular slider
			if ( $img_slider_cat != 'select_slider_cat' && $img_slider_cat != 'none' ){
				earth_get_template_part( 'img-slider' );
			}
				
			// Flickr
			if ( $earth_flickr_show ){
				global $wp_embed;
				echo '<div id="flickr-slideshow-wrap">' . $wp_embed->shortcode( array( "width" => 940, "height" => 400 ), $earth_flickr_show ) . '</div>';
			}
			
		}
	
	}
	
}


// Deprecated
if ( ! function_exists( 'wpex_page_slider' ) ) {
	function wpex_page_slider() {
		return earth_page_slider();
	}
}