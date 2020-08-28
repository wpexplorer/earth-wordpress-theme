<?php
/**
 * Register custom taxonomies
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

if ( ! function_exists( 'earth_create_taxonomies' ) ) {

	function earth_create_taxonomies() {

		if ( earth_get_option( 'gallery', true ) ) {
		
			// gallery taxonomies
			$gallery_cat_labels = array(
				'name'					=> esc_html__( 'Gallery Categories', 'earth' ),
				'singular_name'			=> esc_html__( 'Gallery Category', 'earth' ),
				'search_items'			=> esc_html__( 'Search Gallery Categories', 'earth' ),
				'all_items'				=> esc_html__( 'All Gallery Categories', 'earth' ),
				'parent_item'			=> esc_html__( 'Parent Gallery Category', 'earth' ),
				'parent_item_colon'		=> esc_html__( 'Parent Gallery Category:', 'earth' ),
				'edit_item'				=> esc_html__( 'Edit Gallery Category', 'earth' ),
				'update_item'			=> esc_html__( 'Update Gallery Category', 'earth' ),
				'add_new_item'			=> esc_html__( 'Add New Gallery Category', 'earth' ),
				'new_item_name'			=> esc_html__( 'New Gallery Category Name', 'earth' ),
				'choose_from_most_used'	=> esc_html__( 'Choose from the most used gallery categories', 'earth' )
			); 	
		
			register_taxonomy( 'gallery_cats','gallery',array(
				'public'			=> true,
				'hierarchical'		=> true,
				'labels'			=> $gallery_cat_labels,
				'query_var'			=> true,
				'show_in_nav_menus'	=> true,
				'rewrite'			=> array( 'slug'	=> 'gallery-category' ),
			) );

		}
		
		// FAQs taxonomies
		if ( earth_get_option( 'faqs', true ) ) {

			$faqs_cat_labels = array(
				'name'					=> esc_html__( 'Topics', 'earth' ),
				'singular_name'			=> esc_html__( 'Topic', 'earth' ),
				'search_items'			=> esc_html__( 'Search Topics', 'earth' ),
				'all_items'				=> esc_html__( 'All Topics', 'earth' ),
				'parent_item'			=> esc_html__( 'Parent Topics', 'earth' ),
				'parent_item_colon'		=> esc_html__( 'Parent Topics:', 'earth' ),
				'edit_item'				=> esc_html__( 'Edit Topics', 'earth' ),
				'update_item'			=> esc_html__( 'Update Topics', 'earth' ),
				'add_new_item'			=> esc_html__( 'Add New Topics', 'earth' ),
				'new_item_name'			=> esc_html__( 'New Topics', 'earth' ),
				'choose_from_most_used'	=> esc_html__( 'Choose from the most used faq categories', 'earth' )
			); 	
		
			register_taxonomy( 'faq_cats','faqs',array(
				'hierarchical'		=> true,
				'labels'			=> $faqs_cat_labels,
				'query_var'			=> true,
				'show_in_nav_menus'	=> true,
				'rewrite'			=> array( 'slug'	=> 'faqs-category' ),
			) );

		}
			
		// Image slide taxonomies
		if ( earth_get_option( 'slides', true ) ) {

			$slider_cat_labels = array(
				'name'					=> esc_html__( 'Sliders', 'earth' ),
				'singular_name'			=> esc_html__( 'Slider', 'earth' ),
				'search_items'			=> esc_html__( 'Search Sliders', 'earth' ),
				'all_items'				=> esc_html__( 'All Sliders', 'earth' ),
				'edit_item'				=> esc_html__( 'Edit Slider', 'earth' ),
				'update_item'			=> esc_html__( 'Update Slider', 'earth' ),
				'add_new_item'			=> esc_html__( 'Add New Slider', 'earth' ),
				'new_item_name'			=> esc_html__( 'New Slider', 'earth' ),
				'choose_from_most_used'	=> esc_html__( 'Choose from the most used sliders', 'earth' )
			); 	
		
			register_taxonomy( 'img_sliders','slides',array(
				'hierarchical'		=> true,
				'labels'			=> $slider_cat_labels,
				'query_var'			=> true,
				'show_in_nav_menus'	=> false,
				'show_tagcloud'		=> false
			) );

		}
		
	}

}
add_action( 'init', 'earth_create_taxonomies' );