<?php
/**
 * Loads custom fonts in header
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 3.7.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_custom_fonts() {

	//standard fonts
	$standard_fonts = array( 'default', 'Arial', 'Lucida Sans Unicode', 'Times New Roman', 'Verdana', 'Helvetica' );
	
	//font options
	$load_google_fonts = array();
	$body_font = earth_get_option( 'body_font' );
	$logo_font = earth_get_option( 'logo_font' );
	$headings_font = earth_get_option( 'headings_font' );
	$donate_font = earth_get_option( 'donate_font' );
	$navigation_font = earth_get_option( 'navigation_font' );
	$slider_caption_font = earth_get_option( 'slider_caption_font' );
	
	$font_options = array(
		$body_font['face'],
		$logo_font['face'],
		$headings_font['face'],
		$donate_font['face'],
		$navigation_font['face'],
		$slider_caption_font['face']
	);
				
	//loop through each font option
	foreach( $font_options as $font_option ) {
	
		//load stylesheet only when needed
		if ( ! in_array( $font_option, $standard_fonts ) ) {
			$load_google_fonts[] = $font_option;
		}
	
	}
	
	if ( $load_google_fonts ) {
		$load_google_fonts = array_unique( $load_google_fonts );
		foreach ( $load_google_fonts as $load_google_font ) {
			echo '<link href="https://fonts.googleapis.com/css?family='. str_replace(' ', '+', $load_google_font) .':300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic" rel="stylesheet" type="text/css">';
		}
	}

}
add_action( 'wp_head', 'earth_custom_fonts' );