<?php
/**
 * Array of social settings
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Create Social Array
if ( ! function_exists( 'earth_social_links' ) ) {
	function earth_social_links() {
		return apply_filters( 'wpex_social_links', array(
			'twitter' => array(
				'label' => 'Twitter',
				'icon'  => 'fa fa-twitter',
			),
			'facebook' => array(
				'label' => 'Facebook',
				'icon'  => 'fa fa-facebook',
			),
			'google' => array(
				'label' => 'Google Plus',
				'icon'  => 'fa fa-google-plus',
			),
			'youtube' => array(
				'label' => 'Youtube',
				'icon'  => 'fa fa-youtube',
			),
			'flickr' => array(
				'label' => 'Flickr',
				'icon'  => 'fa fa-flickr',
			),
			'vimeo' => array(
				'label' => 'Vimeo',
				'icon'  => 'fa fa-vimeo',
			),
			'calendar' => array(
				'label' => esc_html__( 'Calendar', 'earth' ),
				'icon'  => 'fa fa-calendar',
			),
			'contact' => array(
				'label' => esc_html__( 'Contact', 'earth' ),
				'icon'  => 'fa fa-envelope',
			),
			'rss' => array(
				'label' => esc_html__( 'RSS Feed', 'earth' ),
				'icon'  => 'fa fa-rss',
			),
		) );		
	}
}

if ( ! function_exists( 'wpex_social_links' ) ) {
	function wpex_social_links() {
		return earth_social_links();
	}
}