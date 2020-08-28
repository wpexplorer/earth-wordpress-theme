<?php
/**
 * Array of styling settings
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_styling_options( $options = array() ) {

	// BG options
	$img_path = EARTH_ASSETS_DIR_URI . '/images/bg/';
	$bg_images = array(
		$img_path .'0.png',
		$img_path .'1.png',
		$img_path .'2.png',
		$img_path .'3.png',
		$img_path .'4.png',
		$img_path .'5.png',
		$img_path .'6.jpg'
	);

	$earth_bg_images = apply_filters( 'earth_bg_images', $bg_images );

	// Array of settings
	$options[] = array(
		'name'  => esc_html__( 'Styling', 'earth' ),
		'type'  => "heading"
	);

	$options[] = array(
		'name'  => esc_html__( 'Responsive Layout', 'earth' ),
		'desc'  => esc_html__( 'Select to enable or disable the responsive layout.', 'earth' ),
		'id'    => "responsive",
		'std'   => '1',
		'on'    => esc_html__( 'Enable', 'earth' ),
		'off'   => esc_html__( 'Disable', 'earth' ),
		'type'  => "switch"
	);
	
	$options[] = array(
		'name'  => esc_html__( 'Main Background Color', 'earth' ),
		'desc'  => "",
		'id'    => "background_color",
		'std'   => "",
		'type'  => "color"
	);
			
	$options[] = array(
		'name'      => esc_html__( 'Main Background Image', 'earth' ),
		'desc'      => esc_html__( 'Select a background pattern. You can always upload a custom background at Apperance->Background. Just make sure to first set this option to "none".', 'earth' ),
		'id'        => "custom_bg",
		'std'       => $img_path. "1.png",
		'type'      => "tiles",
		"options"   => $earth_bg_images,
	);

	$options[] = array(
		'name'  => esc_html__( 'Custom Colors', 'earth' ),
		'desc'  => esc_html__( 'Select to enable or disable the custom color options below. Useful for testing purposes.', 'earth' ),
		'id'    => "custom_styling",
		'std'   => '1',
		'on'    => esc_html__( 'Enable', 'earth' ),
		'off'   => esc_html__( 'Disable', 'earth' ),
		'type'  => "switch"
	);

	//Logo Colors
	$options[] = array(
		'name'  => "",
		'desc'  => "",
		'id'    => "subheading",
		'std'   => "<h3 style=\"margin: 0;\">". esc_html__( 'Logo','earth' ) ."</h3>",
		"icon"  => true,
		'type'  => "info",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Text Logo Color', 'earth' ),
		'desc'  => '',
		'id'    => "logo_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);
	
	$options[] = array(
		'name'  => esc_html__( 'Text Logo Hover Color', 'earth' ),
		'desc'  => '',
		'id'    => "logo_hover_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	//Donate Colors
	$options[] = array(
		'name'  => "",
		'desc'  => "",
		'id'    => "subheading",
		'std'   => "<h3 style=\"margin: 0;\">". esc_html__( 'Donation Button','earth' ) ."</h3>",
		"icon"  => true,
		'type'  => "info",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Donation Button Background', 'earth' ),
		'desc'  => '',
		'id'    => "donation_bg",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Donation Button Color', 'earth' ),
		'desc'  => '',
		'id'    => "donation_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Donation Button Hover Background', 'earth' ),
		'desc'  => '',
		'id'    => "donation_hover_bg",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Donation Button Hover Color', 'earth' ),
		'desc'  => '',
		'id'    => "donation_hover_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Donation Button Hover Animation', 'earth' ),
		'desc'  => esc_html__( 'Do you want the donation button to animate on hover?', 'earth' ),
		'id'    => "donation_hover_animation",
		'std'   => '1',
		'type'  => "checkbox",
		"fold"  => "custom_styling",
	);
	
	//Nav Colors
	$options[] = array(
		'name'  => "",
		'desc'  => "",
		'id'    => "subheading",
		'std'   => "<h3 style=\"margin: 0;\">". esc_html__( 'Menu Colors','earth' ) ."</h3>",
		"icon"  => true,
		'type'  => "info",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Menu Background Top Gradient', 'earth' ),
		'desc'  => '',
		'id'    => "menu_bg_top",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Menu Background Bottom Gradient', 'earth' ),
		'desc'  => '',
		'id'    => "menu_bg_bottom",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Menu Link Right Border', 'earth' ),
		'desc'  => '',
		'id'    => "menu_link_right_border",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Menu Link Left Border', 'earth' ),
		'desc'  => '',
		'id'    => "menu_link_left_border",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Menu Link Color', 'earth' ),
		'desc'  => '',
		'id'    => "menu_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Menu Hover & Active Background', 'earth' ),
		'desc'  => '',
		'id'    => "menu_bg_hover",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);
	
	$options[] = array(
		'name'  => esc_html__( 'Dropdown Background', 'earth' ),
		'desc'  => '',
		'id'    => "dropdown_bg",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);
	
	$options[] = array(
		'name'  => esc_html__( 'Dropdown Link Border Top Color', 'earth' ),
		'desc'  => '',
		'id'    => "dropdown_top_border",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Dropdown Link Border Bottom Color', 'earth' ),
		'desc'  => '',
		'id'    => "dropdown_bottom_border",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);
	
	$options[] = array(
		'name'  => esc_html__( 'Dropdown Link Color', 'earth' ),
		'desc'  => '',
		'id'    => "dropdown_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Dropdown Link Hover Background', 'earth' ),
		'desc'  => '',
		'id'    => "dropdown_bg_hover",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);
	
	$options[] = array(
		'name'  => esc_html__( 'Dropdown Link Hover Color', 'earth' ),
		'desc'  => '',
		'id'    => "dropdown_color_hover",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Menu Link Text Shadow', 'earth' ),
		'desc'  => esc_html__( 'Do you want text shadow applied to your navigation links?', 'earth' ),
		'id'    => "menu_text_shadow",
		'std'   => '1',
		'type'  => "checkbox",
		"fold"  => "custom_styling",
	);

	// Footer colors
	$options[] = array(
		'name'  => "",
		'desc'  => "",
		'id'    => "subheading",
		'std'   => "<h3 style=\"margin: 0;\">". esc_html__( 'Footer Colors','earth' ) ."</h3>",
		"icon"  => true,
		'type'  => "info",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Footer Background', 'earth' ),
		'desc'  => '',
		'id'    => "footer_bg",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Footer Background Bottom Border', 'earth' ),
		'desc'  => '',
		'id'    => "footer_border",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Footer Headings Color', 'earth' ),
		'desc'  => '',
		'id'    => "footer_headings_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Footer Text Color', 'earth' ),
		'desc'  => '',
		'id'    => "footer_text_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Footer Link Color', 'earth' ),
		'desc'  => '',
		'id'    => "footer_link_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Footer Link Hover Color', 'earth' ),
		'desc'  => '',
		'id'    => "footer_link_hover_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Footer Link Hover Background', 'earth' ),
		'desc'  => '',
		'id'    => "footer_link_hover_bg",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Footer List Item Bottom Border', 'earth' ),
		'desc'  => '',
		'id'    => "footer_li_border",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	// Copyright colors
	$options[] = array(
		'name'  => "",
		'desc'  => "",
		'id'    => "subheading",
		'std'   => "<h3 style=\"margin: 0;\">". esc_html__( 'Copyright  & Bottom Menu Colors','earth' ) ."</h3>",
		"icon"  => true,
		'type'  => "info",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Copyright Background', 'earth' ),
		'desc'  => '',
		'id'    => "copyright_bg",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Copyright Top Border', 'earth' ),
		'desc'  => '',
		'id'    => "copyright_border",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Copyright Text Color', 'earth' ),
		'desc'  => '',
		'id'    => "copyright_text_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Copyright Link Color', 'earth' ),
		'desc'  => '',
		'id'    => "copyright_link_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	$options[] = array(
		'name'  => esc_html__( 'Copyright Link Hover Color', 'earth' ),
		'desc'  => '',
		'id'    => "copyright_link_hover_color",
		'std'   => "",
		'type'  => "color",
		"fold"  => "custom_styling",
	);

	return $options;

}