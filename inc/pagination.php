<?php
/**
 * Numbered pagination
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_pagination( $query = '', $echo = true ) {

	// Arrows with RTL support
	$prev_arrow = is_rtl() ? 'fa fa-angle-right' : 'fa fa-angle-left';
	$next_arrow = is_rtl() ? 'fa fa-angle-left' : 'fa fa-angle-right';
	
	// Get global $query
	if ( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}

	// Set vars
	$total  = is_numeric( $query ) ? $query : $query->max_num_pages;
	$big    = 999999999;

	// Display pagination
	if ( $total > 1 ) {

		// Get current page
		if ( $current_page = get_query_var( 'paged' ) ) {
			$current_page = $current_page;
		} elseif ( $current_page = get_query_var( 'page' ) ) {
			$current_page = $current_page;
		} else {
			$current_page = 1;
		}

		// Get permalink structure
		if ( get_option( 'permalink_structure' ) ) {
			if ( is_page() ) {
				$format = 'page/%#%/';
			} else {
				$format = '/%#%/';
			}
		} else {
			$format = '&paged=%#%';
		}

		$args = apply_filters( 'earth_pagination_args', array(
			'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
			'format'    => $format,
			'current'   => max( 1, $current_page ),
			'total'     => $total,
			'mid_size'  => 3,
			'type'      => 'list',
			'prev_text' => '<i class="' . $prev_arrow . '"></i>',
			'next_text' => '<i class="' . $next_arrow . '"></i>',
		) );

		// Output pagination
		if ( $echo ) {
			echo paginate_links( $args );
		} else {
			return paginate_links( $args );
		}

	 }
}