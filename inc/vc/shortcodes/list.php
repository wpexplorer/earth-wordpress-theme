<?php
/**
 * Adds list module to Visual Composer
 *
 * @package WordPress
 * @subpackage Earth
*/

if ( ! function_exists( 'earth_list_vcmap' ) ) {
	function earth_list_vcmap() {
		return array(
			"name" => esc_html__( "List", 'earth' ),
			"base" => "list",
			"category" => esc_html__( 'Earth', 'earth' ),
			'description' => esc_html__( "Styled bulleted list.", 'earth' ),
			"icon" => "earth-vc-icon fa fa-dot-circle-o",
			"params" => array(
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Style", 'earth' ),
					"param_name" => "type",
					"value" => array(
						esc_html__( "Check", "earth") => "check",
						esc_html__( "Black", "earth" ) => "bullets-black",
						esc_html__( "Blue", "earth" ) => "bullets-blue",
						esc_html__( "Gray", "earth" ) => "bullets-gray",
						esc_html__( "Purple", "earth" )	=> "bullets-purple",
						esc_html__( "Red", "earth" ) => "bullets-red",
					),
				),
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => esc_html__( "List", 'earth' ),
					"param_name" => "content",
					"value" => "<ul><li>List 1</li><li>List 2</li><li>List 3</li><li>List 4</li></ul>",
				),
			)
		);
	}
}
vc_lean_map( 'list', 'earth_list_vcmap' );