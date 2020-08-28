<?php
/**
 * Adds buttons module to Visual Composer
 *
 * @package WordPress
 * @subpackage Earth
*/

if ( ! function_exists( 'earth_buttons_vcmap' ) ) {
	function earth_buttons_vcmap() {
		return array(
			"name"					=> esc_html__( "Button", 'earth' ),
			"base"					=> "button",
			"class"					=> "",
			"category"				=> esc_html__( 'Earth', 'earth' ),
			'description'			=> esc_html__( "Theme button.", 'earth' ),
			"icon"					=> "earth-vc-icon fa fa-external-link",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> esc_html__( "URL", 'earth' ),
					"param_name"	=> "url",
					"value"			=> "http://www.google.com/",
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> esc_html__( "Content", 'earth' ),
					"param_name"	=> "content",
					"value"			=> "Button Text",
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> esc_html__( "Title Attribute", 'earth' ),
					"param_name"	=> "title",
					"value"			=> "Title Attribute",
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> esc_html__( "Button Color", 'earth' ),
					"param_name"	=> "color",
					"std"           => "brown",
					"value"			=> array(
						esc_html__( "Brown", "earth" )		=> "brown",
						esc_html__( "Black", "earth")		=> "black",
						esc_html__( "Blue", "earth" )		=> "blue",
						esc_html__( "Grey", "earth" )		=> "grey",
						esc_html__( "Light Grey", "earth" )	=> "light-grey",
						esc_html__( "Green", "earth" )		=> "green",
						esc_html__( "Gold", "earth" )		=> "gold",
						esc_html__( "Orange", "earth" )		=> "orange",
						esc_html__( "Pink", "earth" )		=> "pink",
						esc_html__( "Purple", "earth" )		=> "purple",
						esc_html__( "Red", "earth" )		=> "red",
						esc_html__( "Rosy", "earth" )		=> "rosy",
					),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> esc_html__( "Link Target", 'earth' ),
					"param_name"	=> "target",
					"value"			=> array(
						 esc_html__( "Self", "earth")	=> "self",
						 esc_html__( "Blank", "earth" )	=> "blank",
					),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> esc_html__( "Link Rel", 'earth' ),
					"param_name"	=> "rel",
					"value"			=> array(
						esc_html__( "None", "earth")		=> "",
						esc_html__( "Nofollow", "earth" )	=> "nofollow",
					),
				),
			)
		);
	}
}
vc_lean_map( 'button', 'earth_buttons_vcmap' );