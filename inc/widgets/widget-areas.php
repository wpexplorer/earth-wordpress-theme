<?php
/**
 * Register widget areas
 *
 * @package WordPress
 * @subpackage Earth WordPress Theme
 */

function earth_register_sidebars() {

	// Sidebar
	register_sidebar( array(
		'name'			=> esc_html__( 'Main Sidebar', 'earth' ),
		'id'			=> 'sidebar',
		'before_widget'	=> '<div id="%1$s" class="sidebar-box %2$s clearfix">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4><span>',
		'after_title'	=> '</span></h4>',
	) );

	// Events Sidebar
	if ( earth_get_option( 'events', true ) && earth_get_option( 'events_sidebar', true ) ) {

		register_sidebar( array(
			'name'			=> esc_html__( 'Events Sidebar', 'earth' ),
			'id'			=> 'events_sidebar',
			'before_widget'	=> '<div id="%1$s" class="sidebar-box %2$s clearfix">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4><span>',
			'after_title'	=> '</span></h4>',
		) );

	}

	if ( class_exists( 'WooCommerce' ) ) {

		register_sidebar( array(
			'name'			=> esc_html__( 'WooCommerce Sidebar', 'earth' ),
			'id'			=> 'woo_sidebar',
			'before_widget'	=> '<div id="%1$s" class="sidebar-box %2$s clearfix">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4><span>',
			'after_title'	=> '</span></h4>',
		) );

	}

	// Footer 1
	register_sidebar( array(
		'name'			=> esc_html__( 'Footer First', 'earth' ),
		'id'			=> 'footer-widget-first',
		'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clearfix">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>',
	) );

	// Footer 2
	register_sidebar( array(
		'name'			=> esc_html__( 'Footer Second', 'earth' ),
		'id'			=> 'footer-widget-second',
		'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clearfix">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>',
	) );

	// Footer 3
	register_sidebar( array(
		'name'			=> esc_html__( 'Footer Third', 'earth' ),
		'id'			=> 'footer-widget-third',
		'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clearfix">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>',
	) );

	// Footer 4
	register_sidebar( array(
		'name'			=> esc_html__( 'Footer Fourth', 'earth' ),
		'id'			=> 'footer-widget-fourth',
		'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clearfix">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h4>',
		'after_title'	=> '</h4>',
	) );

}
add_action( 'widgets_init', 'earth_register_sidebars' );