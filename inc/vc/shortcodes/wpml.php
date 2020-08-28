<?php
/**
 * Adds wpml module to Visual Composer
 *
 * @package WordPress
 * @subpackage Earth
*/


if ( ! function_exists( 'earth_wpml_vcmap' ) ) {
	function earth_wpml_vcmap() {
			vc_map( array(
			"name"					=> esc_html__( "WPML", 'earth' ),
			"base"					=> "wpml",
			"category"				=> esc_html__( 'Earth', 'earth' ),
			'description'			=> esc_html__( "Display content in different language.", 'earth' ),
			"icon"					=> "earth-vc-icon fa fa-language",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> esc_html__( "Language", 'earth' ),
					"param_name"	=> "lang",
					"value"			=> "es",
					"description"	=> esc_html__( "Select a WPML language.", 'earth' ),
				),
				array(
					"type"			=> "textarea_html",
					"class"			=> "",
					"heading"		=> esc_html__( "Content", 'earth' ),
					"param_name"	=> "content",
					"value"			=> "Hola",
				),
			)
		) );
	}
}
add_action( 'init', 'earth_wpml_vcmap' );