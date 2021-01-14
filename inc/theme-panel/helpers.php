<?php
/**
 * Admin helpers
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0.1
 */

// Get Standard Cats
if ( ! function_exists( 'earth_get_cats' ) ) {
	function earth_get_cats() {
		$cats = array();
		$get_cats = get_categories( 'hide_empty=0' );
		if ( $get_cats && ! is_wp_error( $get_cats ) ) {
			foreach( $get_cats as $cat ) {
				$cats[$cat->cat_ID] = $cat->slug;
			}
		}
		return $cats;
	}
}

// Get Pages
if ( ! function_exists( 'earth_get_pages' ) ) {
	function earth_get_pages() {
		$pages = array();
		$get_pages = get_pages( 'sort_column=post_parent,menu_order' );
		if ( $get_pages && ! is_wp_error( $get_pages ) ) {
			foreach( $get_pages as $page ) {
				$get_pages[$of_page->ID] = $page->post_name;
			}
		}
		return $pages;
	}
}

// Get Slides
if ( ! function_exists( 'earth_get_sliders' ) ) {
	function earth_get_sliders() {
		$sliders = array();
		$get_sliders = get_terms( 'img_sliders', array( 'hide_empty' => false ) );
		if ( $get_sliders && ! is_wp_error( $get_sliders ) ) {
			foreach( $get_sliders as $slider ) {
				$sliders[$slider->term_id] = $slider->slug;
			}
		}
		return $sliders;
	}
}

// Get Gallery Cats
if ( ! function_exists( 'earth_get_gallery_cats' ) ) {
	function earth_get_gallery_cats() {
		if ( ! taxonomy_exists( 'gallery_cats' ) ) {
			return array( 'hide_empty' => false );
		}
		$cats = array();
		$get_cats = get_terms( 'gallery_cats', array( 'hide_empty' => false ) );
		if ( ! empty( $get_cats ) && ! is_wp_error( $get_cats ) ) {
			foreach( $get_cats as $cat ) {
				$cats[$cat->term_id] = $cat->slug;
			}
		}
		return $cats;
	}
}

// Gallery ID's
if ( ! function_exists( 'earth_get_gallery_posts' ) ) {
	function earth_get_gallery_posts() {
		$posts = array();
		$get_posts = get_posts( array(
			'posts_per_page' => 50, // cap at 50
			'post_type'      => 'gallery',
		) );
		if ( $get_posts ) {
			foreach( $get_posts as $post) {
				$posts[$post->ID] = $post->post_name;
			}
			$posts = array_unshift( $posts, '-' );
		}
		return $posts;
	}
}