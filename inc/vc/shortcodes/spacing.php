<?php
/**
 * Adds spacing module to Visual Composer
 *
 * @package WordPress
 * @subpackage Earth
*/


if ( ! function_exists( 'earth_spacing_vcmap' ) ) {
	function earth_spacing_vcmap() {
		return array(
			"name" => esc_html__( "Spacing", 'earth' ),
			"base" => "spacing",
			"category" => esc_html__( 'Earth', 'earth' ),
			'description' => esc_html__( "Spacing for seperating modules.", 'earth' ),
			"icon" => "earth-vc-icon fa fa-arrows-v",
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Spacing", 'earth' ),
					"param_name" => "size",
					"value" => "30px",
					"description" => esc_html__( "Enter a height in pixels for your spacing.", 'earth' )
				),
			)
		);
	}
}
vc_lean_map( 'spacing', 'earth_spacing_vcmap' );