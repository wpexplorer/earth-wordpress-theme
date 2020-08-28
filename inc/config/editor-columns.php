<?php
/**
 * Custom admin columns
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Slides
add_filter( 'manage_slides_posts_columns', 'earth_edit_slides_columns' );
add_action( 'manage_slides_posts_custom_column', 'earth_custom_slides_columns', 10, 2 );

function earth_edit_slides_columns( $columns ) {
     return array_merge( $columns, array(
		'cb'           => "<input type ='checkbox' />",
		'title'        => esc_html__( 'Slide','earth' ),
		"slides_url"   => esc_html__( 'URL','earth' ),
		"img_sliders"  => esc_html__( 'Slider','earth' ),
		"slides_image" => esc_html__( 'Thumbnail','earth' )
	) );
}

function earth_custom_slides_columns( $column, $post_id ) {

	global $post;

	switch ( $column ) {

		case "slides_url" :

			if ( $url = get_post_meta( $post_id, 'earth_slides_url', true ) ) {
				echo '<a href="' . esc_url( $url ) . '" target="_blank">' . esc_url( $url ) . '</a>';
			} else {
				echo '&dash;';
			}

		break;
		
		case "img_sliders" :

			$img_sliders_terms = get_the_term_list( $post_id, 'img_sliders', ' ', ' , ', ' ' );
			
			echo strip_tags( $img_sliders_terms );

		break;
		
		case "slides_image" :

			if ( has_post_thumbnail( $post_id ) ) {
				the_post_thumbnail( 'small-thumb' );
			}
			else {
				echo '&dash;';
			}

		break;
	}

}

// Highlights
add_filter( 'manage_hp_highlights_posts_columns', 'earth_edit_hp_highlights_columns' );
add_action( 'manage_hp_highlights_posts_custom_column', 'earth_custom_hp_highlights_columns', 10, 2 );

function earth_edit_hp_highlights_columns( $columns ) {
	return array_merge( $columns, array(
		'cb'    => "<input type ='checkbox' />",
		'title' => esc_html__( 'Title','earth' ),
		'url'   => esc_html__( 'URL','earth' ),
		'image' => esc_html__( 'Thumbnail','earth' )
	) );
}

function earth_custom_hp_highlights_columns( $column, $post_id ) {
	
	switch ( $column ) {
		
		case "url" :

			if ( $url = get_post_meta( $post_id, 'earth_hp_highlights_url', true ) ) {
				echo '<a href="' . esc_url( $url ) . '" target="_blank">' . esc_url( $url ) . '</a>';
			} else {
				echo '&dash;';
			}

		break;
		
		case "image" :

			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'small-thumb' );
			} else {
				echo '&dash;';
			}

		break;

	}

}

// Gallery
add_filter( 'manage_gallery_posts_columns', 'earth_edit_gallery_columns' );
add_action( 'manage_gallery_posts_custom_column', 'earth_custom_gallery_columns', 10, 2 );

function earth_edit_gallery_columns( $columns ) {
	return array_merge( $columns, array(
		'cb'       => "<input type ='checkbox' />",
		'title'    => esc_html__( 'Title','earth' ),
		"category" => esc_html__( 'Category','earth' ),
		"image"    => esc_html__( 'Thumbnail','earth' )
	) );
}

function earth_custom_gallery_columns( $column, $post_id ) {

	switch ( $column ) {
		
		case "category" :

			echo get_the_term_list( $post_id, 'gallery_cats', ' ', ' , ', ' ' );

		break;

		case "image" :

			if ( has_post_thumbnail( $post_id ) ) {
				the_post_thumbnail( 'small-thumb' );
			} else {
				echo '&dash;';
			}

		break;

	}

}

// Events
add_filter( 'manage_events_posts_columns', 'earth_edit_events_columns' );
add_action( 'manage_events_posts_custom_column', 'earth_custom_events_columns', 10, 2 );

function earth_edit_events_columns( $columns ) {
	unset( $columns['date'] );
	return array_merge( $columns, array(
		'cb'             => "<input type ='checkbox' />",
		'title'          => esc_html__( 'Title','earth' ),
		'start_date'     => esc_html__( 'Start Date','earth' ),
		'end_date'       => esc_html__( 'End Date','earth' ),
		'featured_event' => esc_html__( 'Featured','earth' ),
		'events_image'   => esc_html__( 'Thumbnail','earth' )
    ) );
}

function earth_custom_events_columns( $column, $post_id ) {

	switch ( $column ) {
			
		case "start_date" :

			if ( $date = earth_event_display_start_date() ) {
				echo esc_html( $date );
			} else {
				echo '&dash;';
			}

		break;

		case "end_date" :

			if ( $date = earth_event_display_end_date() ) {
				echo esc_html( $date );
			} else {
				echo '&dash;';
			}

		break;

		case "featured_event" :

			$featured = get_post_meta( $post_id, 'earth_featured_event', true );

			if ( 'yes' == $featured || 'true' == $featured ) {
				echo '<span class="dashicons dashicons-star-filled"></span>';
			} else {
				echo '&dash;';
			}

		break;

		case "events_image" :

			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'small-thumb' );
			} else {
				echo '&dash;';
			}

		break;

	}

}


// FAQ
add_filter( 'manage_edit-faqs_columns', 'earth_edit_faqs_columns' );
add_action( 'manage_posts_custom_column', 'earth_custom_faqs_columns' );

function earth_edit_faqs_columns( $columns ) {
	$columns = array(
		'cb'            => "<input type ='checkbox' />",
		'title'         => esc_html__( 'Title','earth' ),
		'faqs_category' => esc_html__( 'Category','earth' )
	);
	return $columns;
}

function earth_custom_faqs_columns( $columns ) {
	global $post;
	switch ( $columns ) {

		case 'faqs_category':

			echo get_the_term_list( get_the_ID(), 'faq_cats', ' ', ' , ', ' ' );

		break;

	}
}