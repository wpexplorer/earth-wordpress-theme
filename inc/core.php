<?php
/**
 * Core functions
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get theme option value
 *
 * @since 4.0
 */
function earth_get_option( $id, $fallback = false ) {
	global $smof_data;
	global $data;
	$smof_data = $data;
	$fallback  = $fallback == false ? '' : $fallback;
	$output = isset( $smof_data[ $id ] ) ? $smof_data[$id] : $fallback;
	return $output;
}

/**
 * Get correct template part with fallback checks for older includes folder
 *
 * @since 4.0
 */
function earth_get_template_part( $part, $fallback = '' ) {
	if ( $fallback && locate_template( $fallback . '.php', false, true ) ) {
		get_template_part( $fallback );
		return;
	}
	return get_template_part( 'template-parts/' . $part );
}


/**
 * Get correct template part with fallback checks for older includes folder
 *
 * @since 4.0
 */
function earth_get_sidebar() {
	$sidebar = 'sidebar';
	if ( class_exists( 'WooCommerce' )
		&& ( is_woocommerce() || is_shop() || is_cart() || is_checkout() || is_account_page() )
	) {
		$sidebar = 'woo_sidebar';
	} elseif ( earth_has_event_sidebar() ) {
		$sidebar = 'events_sidebar'; 
	}
	$sidebar = apply_filters( 'earth_get_sidebar', $sidebar );
	if ( 'sidebar' != $sidebar && ! is_active_sidebar( $sidebar ) ) {
		$sidebar = 'sidebar';
	}
	return $sidebar;
}

/**
 * Output breadcrumbs
 *
 * @since 4.0
 */
function earth_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<nav id="breadcrumbs">','</nav>' );
	}
}

/**
 * Echo post thumbnail
 *
 * @since 4.0
 */
function earth_post_thumbnail( $size = '', $attr = array() ) {
	echo earth_get_post_thumbnail( $size, $attr );
}

// Returns escaped post title
function earth_get_esc_title() {
	return esc_attr( the_title_attribute( 'echo=0' ) );
}

// Outputs escaped post title
function earth_esc_title() {
	echo earth_get_esc_title();
}

// Check current page layout
function earth_get_post_layout() {
	$layout = 'right-sidebar';
	if ( is_page_template( 'template-fullwidth.php' ) ) {
		$layout = 'full-width';
	} elseif ( is_singular( 'gallery' ) ) {
		$layout = 'full-width';
	} elseif ( is_singular( 'events' ) ) {
		$layout = earth_get_option( 'single_event_layout', 'right-sidebar' );
	}
	return apply_filters( 'earth_get_post_layout', $layout );
}

// Custom excerpt
function earth_excerpt( $length=30, $readmore=false ) {
	$output       = '';
	$post         = get_post();
	$post_id      = $post->ID;
	$post_content = $post->post_content;
	$post_excerpt = $post->post_excerpt;
	$meta_length  = get_post_meta( $post_id, 'earth_excerpt_length', true );
	$length       = $meta_length ? $meta_length : $length;
	if ( $post_excerpt ) {
		$output = apply_filters( 'the_content', $post_excerpt );
	} elseif ( $post_content ) {
		$output = wp_trim_words( strip_shortcodes( $post_content ), $length);
		if ( $readmore == true ) {
			$readmore_link = '<a href="'. get_permalink( $post_id ) .'" title="'. esc_html__( 'continue reading', 'earth' ) .'" rel="bookmark" class="readmore-link">'. esc_html__( 'continue reading', 'earth' ) .' &rarr;</a>';
			$output .= apply_filters( 'wpex_readmore_link', $readmore_link );
		}
	}
	echo wp_kses_post( $output );
}

/**
 * Returns 1st term name
 *
 * @since 3.5.3
 */
function earth_get_first_term_name( $post_id = '', $taxonomy = 'category' ) {
	if ( ! taxonomy_exists( $taxonomy ) ) return;
	$post_id = $post_id ? $post_id : get_the_ID();
	$terms   = wp_get_post_terms( $post_id, $taxonomy );
	if ( ! empty( $terms[0] ) ) {
		return $terms[0]->name;
	}
}

/**
 * Get attachment
 *
 * @since 4.0
 */
function wpex_get_attachment_data( $attachment = '', $return = 'array' ) {

	// Initial checks
	if ( ! $attachment || 'none' == $return ) {
		return;
	}

	// Sanitize return value
	$return = $return ? $return : 'array';

	// Return data
	if ( 'array' == $return ) {
		return array(
			'url'         => get_post_meta( $attachment, '_wp_attachment_url', true ),
			'src'         => wp_get_attachment_url( $attachment ),
			'alt'         => get_post_meta( $attachment, '_wp_attachment_image_alt', true ),
			'title'       => get_the_title( $attachment ),
			'caption'     => get_post_field( 'post_excerpt', $attachment ),
			'description' => get_post_field( 'post_content', $attachment ),
			'video'       => esc_url( get_post_meta( $attachment, '_video_url', true ) ),
		);
	} elseif ( 'url' == $return ) {
		return get_post_meta( $attachment, '_wp_attachment_url', true );
	} elseif ( 'src' == $return ) {
		return get_post_meta( $attachment, '_wp_attachment_url', true );
	} elseif ( 'alt' == $return ) {
		return get_post_meta( $attachment, '_wp_attachment_image_alt', true );
	} elseif ( 'title' == $return ) {
		return get_the_title( $attachment );
	} elseif ( 'caption' == $return ) {
		return get_post_field( 'post_excerpt', $attachment );
	} elseif ( 'description' == $return ) {
		return get_post_field( 'post_content', $attachment );
	} elseif ( 'video' == $return ) {
		return esc_url( get_post_meta( $attachment, '_video_url', true ) );
	}

	// Set alt to title if alt not defined => Removed in v4.0
	//$array['alt'] = $array['alt'] ? $array['alt'] : $array['title'];

}

/**
 * Allow to remove method for an hook when, it's a class method used and class doesn't have global for instanciation
 *
 * @since 3.5.5
 */
function earth_remove_class_filter( $hook_name = '', $class_name ='', $method_name = '', $priority = 0 ) {
	global $wp_filter;

	// Make sure class exists
	if ( ! class_exists( $class_name ) ) {
		return false;
	}
	
	// Take only filters on right hook name and priority
	if ( ! isset($wp_filter[$hook_name][$priority] ) || ! is_array( $wp_filter[$hook_name][$priority] ) ) {
		return false;
	}
	
	// Loop on filters registered
	foreach( (array) $wp_filter[$hook_name][$priority] as $unique_id => $filter_array ) {
		
		// Test if filter is an array ! (always for class/method)
		if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {

			// Test if object is a class, class and method is equal to param !
			if ( is_object( $filter_array['function'][0] )
				&& get_class( $filter_array['function'][0] )
				&& get_class( $filter_array['function'][0] ) == $class_name
				&& $filter_array['function'][1] == $method_name
			) {
				if ( isset( $wp_filter[$hook_name] ) ) {
					// WP 4.7
					if ( is_object( $wp_filter[$hook_name] ) ) {
						unset( $wp_filter[$hook_name]->callbacks[$priority][$unique_id] );
					}
					// WP 4.6
					else {
						unset( $wp_filter[$hook_name][$priority][$unique_id] );
					}
				}
			}

		}
		
	}
	return false;
}