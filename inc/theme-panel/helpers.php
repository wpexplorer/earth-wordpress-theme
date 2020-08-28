<?php
/**
 * Admin helpers
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Get Standard Cats
if ( ! function_exists( 'earth_get_cats' ) ) {
	function earth_get_cats() {
		$of_categories = array();  
		$of_categories_obj = get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
			$of_categories[$of_cat->cat_ID] = $of_cat->slug;
		}
		$categories_tmp = array_unshift($of_categories, "-");
		return $of_categories;
	}
}

// Get Pages
if ( ! function_exists( 'earth_get_pages' ) ) {
	function earth_get_pages() {
		$of_pages = array();
		$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
			$of_pages[$of_page->ID] = $of_page->post_name;
		}
		$of_pages_tmp = array_unshift($of_pages, "-" );
		return $of_pages;
	}
}

// Get Slides
if ( ! function_exists( 'earth_get_sliders' ) ) {
	function earth_get_sliders() {
		$img_sliders_args = array( 'hide_empty'	=> false );
		$img_sliders_terms = get_terms('img_sliders', $img_sliders_args);
		$img_sliders_tax = array();
		foreach ( $img_sliders_terms as $img_sliders_term) {
			$img_sliders_tax[$img_sliders_term->term_id] = $img_sliders_term->slug;
		}
		$img_sliders_tax_tmp = array_unshift($img_sliders_tax, "-");
		return $img_sliders_tax;
	}
}

// Get Gallery Cats
if ( ! function_exists( 'earth_get_gallery_cats' ) ) {
	function earth_get_gallery_cats() {
		if ( ! taxonomy_exists( 'gallery_cats' ) ) {
			return array( 'hide_empty' => false );
		}
		$cats_args = array( 'hide_empty' => false );
		$cats_terms = get_terms('gallery_cats', $cats_args);
		$cats_tax = array();
		foreach ( $cats_terms as $cats_term) {
			$cats_tax[$cats_term->term_id] = $cats_term->slug;
		}
		$cats_tax_tmp = array_unshift($cats_tax, "-");
		return $cats_tax;
	}
}

// Gallery ID's
if ( ! function_exists( 'earth_get_gallery_posts' ) ) {
	function earth_get_gallery_posts() {
		$posts = array();
		$posts_obj = get_posts( array(
			'posts_per_page' => 50, // cap at 50
			'post_type'      => 'gallery',
		) );
		foreach ($posts_obj as $post) {
			$posts[$post->ID] = $post->post_name;
		}
		$posts_tmp = array_unshift($posts, '-' );
		return $posts;
	}
}