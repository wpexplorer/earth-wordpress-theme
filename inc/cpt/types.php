<?php
/**
 * Register custom post types
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

if ( ! function_exists( 'earth_create_post_types' ) ) {

	function earth_create_post_types() {
		
		// Register slides if enabled
		if ( earth_get_option( 'slides', true ) ) {

			register_post_type( 'slides', array(
				'labels' => array(
					'name'               => esc_html__( 'Slides', 'earth' ),
					'singular_name'      => esc_html__( 'Slide', 'earth' ),
					'add_new'            => esc_html__( 'Add New', 'earth' ),
					'add_new_item'       => esc_html__( 'Add New Slide', 'earth' ),
					'edit_item'          => esc_html__( 'Edit Slide', 'earth' ),
					'new_item'           => esc_html__( 'New Slide', 'earth' ),
					'view_item'          => esc_html__( 'View Slide', 'earth' ),
					'search_items'       => esc_html__( 'Search Slides', 'earth' ),
					'not_found'          => esc_html__( 'No Slides found', 'earth' ),
					'not_found_in_trash' => esc_html__( 'No Slides Found In Trash', 'earth' ),
					'parent_item_colon'  => ''
				),
				'public'              => true,
				'has_archive'         => false,
				'query_var'           => true,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				'menu_icon'           => 'dashicons-format-gallery',
				'menu_position'       => 5,
				'supports'            => array(
					'title',
					'thumbnail',
					'revisions',
					'custom-fields'
				),
			) );
		  
		}
		
		// Register highlights if enabled
		if ( earth_get_option( 'highlights', true ) ) {
			
			register_post_type( 'hp_highlights',
				array(
				'labels'					=> array(
					'name'					=> esc_html__( 'Highlights', 'earth' ),
					'singular_name'			=> esc_html__( 'Highlight', 'earth' ),
					'add_new'				=> esc_html__( 'Add New', 'earth' ),
					'add_new_item'			=> esc_html__( 'Add New Highlight', 'earth' ),
					'edit_item'				=> esc_html__( 'Edit Highlight', 'earth' ),
					'new_item'				=> esc_html__( 'New Highlight', 'earth' ),
					'view_item'				=> esc_html__( 'View Highlight', 'earth' ),
					'search_items'			=> esc_html__( 'Search Highlights', 'earth' ),
					'not_found'				=> esc_html__( 'No Highlights Found', 'earth' ),
					'not_found_in_trash'	=> esc_html__( 'No Highlights Found In Trash', 'earth' ),
					'parent_item_colon'		=> ''
					
				  ),
				  'public'					=> true,
				  'supports'				=> array( 'title', 'thumbnail', 'revisions', 'custom-fields', 'editor' ),
				  'query_var'				=> true,
				  'rewrite'					=> array( 'slug'	=> 'hp-highlights' ),
				  'show_in_nav_menus'		=> false,
				  'exclude_from_search'		=> true,
				  'menu_icon'				=> 'dashicons-star-filled',
				  'menu_position'			=> 20,
				)
			  );
		  
		}
		  
		// Register gallery if enabled
		if ( earth_get_option( 'gallery', true ) ) {
			
			register_post_type( 'gallery',
				array(
				  'labels'					=> array(
					'name'					=> esc_html__( 'Gallery','earth' ),
					'singular_name'			=> esc_html__( 'Gallery','earth' ),
					'add_new'				=> esc_html__( 'Add New','earth' ),
					'add_new_item'			=> esc_html__( 'Add New Gallery','earth' ),
					'edit_item'				=> esc_html__( 'Edit Gallery','earth' ),
					'new_item'				=> esc_html__( 'New Gallery','earth' ),
					'view_item'				=> esc_html__( 'View Gallery','earth' ),
					'search_items'			=> esc_html__( 'Search Galleries','earth' ),
					'not_found'				=> esc_html__( 'No Galleries found','earth' ),
					'not_found_in_trash'	=> esc_html__( 'No Galleries Found In Trash','earth' ),
					'parent_item_colon'		=> ''
					
				  ),
				  'has_archive'				=> true,
				  'public'					=> true,
				  'exclude_from_search'		=> false,
				  'supports'				=> array( 'title', 'thumbnail', 'revisions', 'custom-fields', 'editor', 'comments' ),
				  'menu_icon'				=> 'dashicons-format-image',
				  'query_var'				=> true,
				  'rewrite'					=> array( 'slug'	=> 'gallery' ),
				  'menu_position'			=> 20,
				)
			);
		
		}
		
		// Register events if enabled
		if ( earth_get_option( 'events', true ) ) {
		
			register_post_type( 'events',
				array(
				  'labels'					=> array(
					'name'					=> esc_html__( 'Events','earth' ),
					'singular_name'			=> esc_html__( 'Event','earth' ),
					'add_new'				=> esc_html__( 'Add New','earth' ),
					'add_new_item'			=> esc_html__( 'Add New Event','earth' ),
					'edit_item'				=> esc_html__( 'Edit Event','earth' ),
					'new_item'				=> esc_html__( 'New Event','earth' ),
					'view_item'				=> esc_html__( 'View Event','earth' ),
					'search_items'			=> esc_html__( 'Search Events','earth' ),
					'not_found'				=> esc_html__( 'No Events Found','earth' ),
					'not_found_in_trash'	=> esc_html__( 'No Events Found In Trash','earth' ),
					'parent_item_colon'		=> ''
					
				  ),
				  'public'					=> true,
				  'has_archive'				=> true,
				  'exclude_from_search'		=> false,
				  'supports'				=> array( 'title', 'thumbnail', 'revisions', 'custom-fields', 'editor', 'excerpt' ),
				  'menu_icon'				=> 'dashicons-calendar',
				  'query_var'				=> true,
				  'rewrite'					=> array( 'slug'	=> 'event' ),
				  'menu_position'			=> 20,
				)
			);
		
		}
	
		// Register FAQ if enabled
		if ( earth_get_option( 'faqs', true ) ) {
			
			register_post_type( 'faqs',
				array(
				  'labels'					=> array(
					'name'					=> esc_html__( 'FAQs','earth' ),
					'singular_name'			=> esc_html__( 'FAQ','earth' ),
					'add_new'				=> esc_html__( 'Add New', 'earth' ),
					'add_new_item'			=> esc_html__( 'Add New FAQ','earth' ),
					'edit_item'				=> esc_html__( 'Edit FAQ','earth' ),
					'new_item'				=> esc_html__( 'New FAQ','earth' ),
					'view_item'				=> esc_html__( 'View FAQ','earth' ),
					'search_items'			=> esc_html__( 'Search FAQs','earth' ),
					'not_found'				=> esc_html__( 'No FAQs Found','earth' ),
					'not_found_in_trash'	=> esc_html__( 'No FAQs Found In Trash','earth' ),
					'parent_item_colon'		=> '',
					
				  ),
				  'public'					=> true,
				  'has_archive'				=> true,
				  'exclude_from_search'		=> false,
				  'supports'				=> array( 'title', 'thumbnail', 'revisions', 'custom-fields', 'editor' ),
				  'menu_icon'				=> 'dashicons-editor-help',
				  'query_var'				=> true,
				  'rewrite'					=> array( 'slug'	=> 'faqs' ),
				  'menu_position'			=> 20,
				)
			);
		
		}
	
	}

}
add_action( 'init', 'earth_create_post_types' );