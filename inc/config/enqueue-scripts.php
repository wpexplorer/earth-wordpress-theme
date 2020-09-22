<?php
/**
 * Core theme scripts and styles
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_scripts() {

	/*******
	*** CSS
	*******************/
	wp_enqueue_style( 'earth-style', get_stylesheet_uri() );

	wp_enqueue_style( 'earth-ie7', EARTH_ASSETS_DIR_URI . 'css/ie7.css' );
	wp_style_add_data( 'earth-ie7', 'conditional', 'IE 7' );

	if ( earth_get_option( 'responsive', true ) ) {

		wp_enqueue_style(
			'earth-responsive',
			EARTH_ASSETS_DIR_URI . 'css/responsive.css',
			array( 'earth-style' )
		);
	}

	wp_deregister_style( 'font-awesome' );
	wp_dequeue_style( 'font-awesome' );

	wp_enqueue_style(
		'earth-font-awesome',
		EARTH_ASSETS_DIR_URI . 'css/font-awesome.min.css'
	);

	/*******
	*** JS
	*******************/

	// Load jQuery
	wp_enqueue_script( 'jquery' );

	// Define FAQ script
	wp_register_script(
		'earth-faqs',
		EARTH_ASSETS_DIR_URI . 'js/faqs.js',
		array( 'jquery' ),
		'1.0',
		true
	);

	// Load Retina js
	if ( earth_get_option( 'retina', false ) ) {

		wp_enqueue_script(
			'earth-retina',
			EARTH_ASSETS_DIR_URI . 'js/retina.js',
			array( 'jquery' ),
			'0.0.2',
			true
		);

	}

	// Calendar template js
	if ( is_page_template( 'template-events-calendar.php' ) ) {

		wp_enqueue_script(
			'earth-calendar',
			EARTH_ASSETS_DIR_URI . 'js/calendar.js',
			array( 'jquery' ),
			'1.0',
			true
		);

		wp_localize_script( 'earth-calendar', 'aqvars', array(
			'templateurl' => trailingslashit(get_template_directory_uri()),
			'ajaxurl'     => admin_url( 'admin-ajax.php' ),
		) );

	}

	// Threaded comments js
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Masonry galleries
	wp_register_script(
		'images-loaded',
		EARTH_ASSETS_DIR_URI . 'js/images-loaded.js',
		array( 'jquery' ),
		'3.1.8',
		true
	);

	wp_register_script(
		'isotope',
		EARTH_ASSETS_DIR_URI . 'js/isotope.js',
		array( 'jquery' ),
		'2.0',
		true
	);

	wp_register_script(
		'isotope-vc-galleries',
		EARTH_ASSETS_DIR_URI . 'js/isotope-vc-galleries.js',
		array( 'jquery', 'isotope', 'images-loaded' ),
		'1.0',
		true
	);

	wp_register_script(
		'isotope',
		EARTH_ASSETS_DIR_URI . '/js/isotope.js',
		array( 'jquery' ),
		'1.5.19',
		true
	);

	wp_register_script(
		'isotope-gallery',
		EARTH_ASSETS_DIR_URI . '/js/isotope-gallery.js',
		array( 'jquery', 'isotope' ),
		'1.0',
		true
	);

	// Events
	wp_register_script(
		'earth-event-tabs',
		EARTH_ASSETS_DIR_URI . '/js/event-tabs.js',
		array( 'jquery' ),
		'1.0',
		true
	);
	wp_register_script(
		'googlemap_api',
		'https://maps.googleapis.com/maps/api/js?key=' . earth_get_option( 'google_api_key' ),
		array( 'jquery' ),
		'1.0',
		true
	);

	// Global theme js
	wp_enqueue_script(
		'earth-functions',
		EARTH_ASSETS_DIR_URI . 'js/earth-functions.js',
		array( 'jquery' ),
		'1.0',
		true
	);

	$vars = apply_filters( 'earth_script_vars', array(
		'responsiveMenuText' => earth_get_option( 'responsive_text' ) ? earth_get_option( 'responsive_text' ) : esc_html__( 'Menu', 'earth' ),
		'removeMenuDropdownCurrentClass' => true,
	) );

	wp_localize_script( 'earth-functions', 'earthVars', $vars );

}
add_action( 'wp_enqueue_scripts', 'earth_scripts' );

// Site tracking header
function earth_tracking_header() {
	echo earth_get_option( 'tracking_header' );
}
add_action( 'wp_head', 'earth_tracking_header' );

// Site tracking footer
function earth_tracking_footer() {
	echo earth_get_option( 'tracking_footer' );
}
add_action( 'wp_footer', 'earth_tracking_footer' );