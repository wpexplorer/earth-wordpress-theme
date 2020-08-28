<?php
/**
 * Configure post metabox
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_post_metabox_options( $options ) {

	$prefix = 'earth_';

	$categories = array( 'none' => esc_html__( 'None', 'earth' ) );
	$get_cats = get_terms( 'category' );
	if ( $get_cats ) {
		foreach ( $get_cats as $cat ) {
			$categories[$cat->term_id] = $cat->name;
		}
	}

	$gallery_cats = array( 'none' => esc_html__( 'None', 'earth' ) );
	if ( taxonomy_exists( 'gallery_cats' ) ) {
		$get_cats = get_terms( 'gallery_cats' );
		if ( $get_cats ) {
			foreach ( $get_cats as $cat ) {
				$gallery_cats[$cat->term_id] = $cat->name;
			}
		}
	}

	$img_sliders = array( 'none' => esc_html__( 'None', 'earth' ) );
	if ( taxonomy_exists( 'img_sliders' ) ) {
		$get_cats = get_terms( 'img_sliders' );
		if ( $get_cats ) {
			foreach ( $get_cats as $cat ) {
				$img_sliders[$cat->term_id] = $cat->name;
			}
		}
	}

	// Posts
	$options['post'] = array(
		'title'      => esc_html__( 'Post Settings', 'earth' ),
		'post_types' => array( 'post' ),
		'fields'     => array(
			array(
				'name'  => esc_html__( 'oEmbed URL (video)', 'earth' ),
				'id'    => $prefix . 'post_oembed',
				'type'  => 'text',
				'desc'  => esc_html__( 'Enter a URL that is compatible with WP\'s built-in oEmbed feature. This will override your featured image.', 'earth' ),
			),
		),
	);

	// Pages
	$options['pages'] = array(
		'title'      => esc_html__( 'Page Settings', 'earth' ),
		'post_types' => array( 'page' ),
		'fields'     => array(
			array(
				'name'	=> esc_html__( 'Slider Shortcode', 'earth' ),
				'id'	=> $prefix . 'page_slider_shortcode',
				'type'	=> 'text_html',
				'desc'	=> esc_html__( 'Insert your slider shortcode here.', 'earth' )
			),
			array(
				'name'	=> esc_html__( 'Flickr SlideShow URL', 'earth' ),
				'desc'	=> esc_html__( 'Enter the URL to a flickr slideshow if you want one at top of your page.', 'earth' ),
				'id'	=> $prefix . 'flickr_show',
				'type'	=> 'text'
			),
			array(
				'name'	=> esc_html__( 'oEmbed URL (video)', 'earth' ),
				'desc'	=>  esc_html__( 'Enter the video URL that is compatible with WP\'s built-in oEmbed feature.', 'earth' ) .' <a href="http://codex.wordpress.org/Embeds" target="_blank">'. esc_html__( 'Learn More', 'earth' ) .' &rarr;</a>',
				'id'	=> $prefix . 'page_oembed',
				'type'	=> 'text',
			),
			array(
				'name'		=> esc_html__( 'Title', 'earth' ),
				'desc'		=> esc_html__( 'Select to enable disable the main title.', 'earth' ),
				'id'		=> $prefix . 'page_title',
				'type'		=> 'select',
				'choices'	=> array(
					'Enable'  => esc_html__( 'Enable', 'earth' ),
					'Disable' => esc_html__( 'Disable', 'earth' )
				),
			),
			array(
				'name'    => esc_html__( 'Image Slider', 'earth' ),
				'id'      => $prefix . 'img_slider_cat',
				'type'	  => 'select',
				'desc'    => esc_html__( 'Select an image slider if you want one at the top of your page. For the homepage please use the admin setting.', 'earth' ),
				'choices' => $img_sliders,
			),
			array(
				'name'    => esc_html__( 'Blog Template Category', 'earth' ),
				'id'      => $prefix . 'blog_parent',
				'type'    => 'select',
				'choices' => $categories,
				'desc'    => esc_html__( 'Select a category for your blog page.', 'earth' )
			),
			array(
				'name'    => esc_html__( 'Gallery Template Category', 'earth' ),
				'id'      => $prefix . 'gallery_parent',
				'type'    => 'select',
				'choices' => $gallery_cats,
				'desc'    => esc_html__( 'Select a category for your gallery page.', 'earth' )
			),
		),
	);

	// Highlights
	$options['hp_highlights'] = array(
		'title'      => esc_html__( 'Highlight Settings', 'earth' ),
		'post_types' => array( 'hp_highlights' ),
		'fields'     => array(
			array(
				'name' => esc_html__( 'URL', 'earth' ),
				'desc' => esc_html__( 'Enter a URL to link the title of this highlight to. Optional.', 'earth' ),
				'id'   => $prefix . 'hp_highlights_url',
				'type' => 'url',
			),
		),
	);

	// Slides
	$options['slides'] = array(
		'title'      => esc_html__( 'Slide Settings', 'earth' ),
		'post_types' => array( 'slides' ),
		'fields'     => array(
			array(
				'name'	=> esc_html__( 'Slide URL', 'earth' ),
				'desc'	=> esc_html__( 'Enter a URL to link this slide to.', 'earth' ),
				'id'	=> $prefix . 'slides_url',
				'type'	=> 'text',
			),
			array(
				'name'    => esc_html__( 'Slider URL Target', 'earth' ),
				'desc'    => esc_html__( 'Select your slide URL target.', 'earth' ),
				'id'      => $prefix . 'slides_url_target',
				'type'    => 'select',
				'choices' => array(
					'self'  => esc_html__( 'Self', 'earth' ),
					'blank' => esc_html__( 'Blank', 'earth' ),
				),
			),
			array(
				'name'	=> esc_html__( 'oEmbed URL (video)', 'earth' ),
				'desc'	=>  esc_html__( 'Enter the video URL that is compatible with WP\'s built-in oEmbed feature.', 'earth' ) .' <a href="http://codex.wordpress.org/Embeds" target="_blank">'. esc_html__( 'Learn More', 'earth' ) .' &rarr;</a>',
				'id'	=> $prefix . 'slides_video_oembed',
				'type'	=> 'text',
			),
			array(
				'name'	=> esc_html__( 'Caption', 'earth' ),
				'desc'	=> esc_html__( 'Enter a description for your slide.', 'earth' ),
				'id'	=> $prefix . 'slides_description',
				'type'	=> 'editor',
			),
		),
	);

	// Events
	$options['events'] = array(
		'title'      => esc_html__( 'Event Settings', 'earth' ),
		'post_types' => array( 'events' ),
		'fields'     => array(
			array(
				'name'		=> esc_html__( 'Title', 'earth' ),
				'desc'		=> esc_html__( 'Select to enable disable the main title.', 'earth' ),
				'id'		=> $prefix . 'page_title',
				'type'		=> 'select',
				'choices' => array(
					''       => esc_html__( 'Default', 'earth' ),
					'Enable' => esc_html__( 'Yes', 'earth' ),
					'Disable' => esc_html__( 'No', 'earth' ),
				),
			),
			array(
				'name'		=> esc_html__( 'Featured Event?', 'earth' ),
				'desc'		=> esc_html__( 'Is this a featured event? This setting is used for the homepage event module and event widget.', 'earth' ),
				'id'		=> $prefix . 'featured_event',
				'type'		=> 'select',
				'choices' => array(
					'no' => esc_html__( 'No', 'earth' ),
					'yes' => esc_html__( 'Yes', 'earth' ),
				),
			),
			array( 
				'name'	=> esc_html__( 'Disable Event Tabs', 'earth' ),
				'desc'	=> esc_html__( 'Check to disable the tabs on this event (details, map, gallery).', 'earth' ),
				'id'	=> $prefix . 'single_event_tabs',
				'type'	=> 'checkbox',
			),
			array(
				'name' => esc_html__( 'Event Start Day', 'earth' ),
				'desc' => '',
				'id'   => $prefix . 'event_startdate',
				'type' => 'date',
				'desc'	=> esc_html__( 'Enter a start day for your event.', 'earth' ),
			),
			array(
				'name' => esc_html__( 'Event End Day', 'earth' ),
				'desc' => '',
				'id'   => $prefix . 'event_enddate',
				'type' => 'date',
				'desc'	=> esc_html__( 'Enter an end date for your event.', 'earth' ),
			),
			array(
				'name' => esc_html__( 'Start Time', 'earth' ),
				'desc' => '',
				'id'   => $prefix . 'event_start_time',
				'type' => 'time',
				'desc'	=> esc_html__( 'Enter a start time for your event.', 'earth' ),
			),
			array(
				'name' => esc_html__( 'End Time', 'earth' ),
				'desc' => '',
				'id'   => $prefix . 'event_end_time',
				'type' => 'time',
				'desc'	=> esc_html__( 'Enter an end time for your event.', 'earth' ),
			),
			array(
				'name'	=> esc_html__( 'Slider Shortcode', 'earth' ),
				'id'	=> $prefix . 'page_slider_shortcode',
				'type'	=> 'text_html',
				'desc'	=> esc_html__( 'Insert your slider shortcode here.', 'earth' )
			),
			array(
				'name'	=> esc_html__( 'oEmbed URL (video)', 'earth' ),
				'desc'	=>  esc_html__( 'Enter the video URL that is compatible with WP\'s built-in oEmbed feature. This will override your featured image.', 'earth' ) .'<br /><a href="http://codex.wordpress.org/Embeds" target="_blank">'. esc_html__( 'Learn More', 'earth' ) .' &rarr;</a>',
				'id'	=> $prefix . 'post_oembed',
				'type'	=> 'text',
			),
			array(
				'name'	=> esc_html__( 'Event Address', 'earth' ),
				'desc'	=> esc_html__( 'Enter your adddress or Google Map embed code. If you enter an address you will have to enter your Google Maps API key in the theme options panel.', 'earth' ),
				'id'	=> $prefix . 'event_location_address',
				'type'	=> 'textarea',
				'rows'  => 4,
			),
			array(
				'name'	=> esc_html__( 'Google Map Embed Code', 'earth' ),
				'desc'	=> esc_html__( 'Alternative method for displaying your map.', 'earth' ),
				'id'	=> $prefix . 'event_location',
				'type'	=> 'code',
				'rows'  => 4,
			),
			array(
				'name'    => esc_html__( 'Event Description', 'earth' ),
				'desc'    => esc_html__( 'This will override the default trimmed excerpt based on the post content.', 'earth' ),
				'id'      => $prefix . 'event_description',
				'type'    => 'editor',
			),
		),
	);


	// Return settings
	return $options;

}
add_filter( 'wpex_post_meta_options', 'earth_post_metabox_options', 10 );