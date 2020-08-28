<?php
/**
 * Theme Setup
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.2.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_theme_setup() {

	// Content width
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 900;
	}
	
	// Localization support
	load_theme_textdomain( 'earth', get_template_directory() .'/languages' );

	// Register navigation menus
	register_nav_menus ( array(
		'main_menu'   => esc_html__( 'Main', 'earth' ),
		'footer_menu' => esc_html__( 'Footer', 'earth' )
	) );
		
	// Add theme support
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'customize-selective-refresh-widgets' );

}
add_action( 'after_setup_theme', 'earth_theme_setup' );