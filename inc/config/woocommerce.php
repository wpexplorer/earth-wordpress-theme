<?php
/**
 * WooCommerce Support
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Declare support
add_action( 'after_setup_theme', function() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'wc-product-gallery-lightbox' );
} );

// Disable shop title
add_filter( 'woocommerce_show_page_title', '__return_false' );

// Change layouts
function earth_woo_layouts( $layout ) {
	if ( is_woocommerce() || is_shop() || is_cart() || is_checkout() || is_account_page() ) {
		if ( is_singular( 'product' ) ) {
			$layout = earth_get_option( 'woo_product_layout' );
		} else {
			$layout = earth_get_option( 'woo_shop_layout' );
		}
		$layout = $layout ? $layout : 'full-width';
	}
	return $layout;
}
add_filter( 'earth_get_post_layout', 'earth_woo_layouts' );

// Alter WooCommerce shop posts per page
function earth_woo_posts_per_page( $cols ) {
	$ppp = intval( earth_get_option( 'woo_shop_ppp' ) );
	$ppp = $ppp ? $ppp : 12;
    return $ppp;
}
add_filter( 'loop_shop_per_page', 'earth_woo_posts_per_page' );

// Alter shop columns
function earth_woo_shop_columns( $columns ) {
	$cols = intval( earth_get_option( 'woo_shop_cols' ) );
	$cols = $cols ? $cols : 3;
	return $cols;
}
add_filter( 'loop_shop_columns', 'earth_woo_shop_columns' );

// Add correct body class for shop columns
function earth_woo_shop_columns_body_class( $classes ) {
	if ( is_shop() || is_product_category() || is_product_tag() || is_singular( 'product' ) ) {
		$cols = intval( earth_get_option( 'woo_shop_cols' ) );
		$cols = $cols ? $cols : 3;
		$classes[] = 'columns-'. $cols;
	}
	return $classes;
}
add_filter( 'body_class', 'earth_woo_shop_columns_body_class' );

// Change number of cross-sell items
function earth_woo_cross_sells_total( $total ) {
	return 2;
}
add_filter( 'woocommerce_cross_sells_total', 'earth_woo_cross_sells_total' );

// Filter up-sells columns
function earth_woo_single_loops_columns( $columns ) {
	$cols = intval( earth_get_option( 'woo_shop_cols' ) );
	$cols = $cols ? $cols : 3;
	return $cols;
}
add_filter( 'woocommerce_up_sells_columns', 'earth_woo_single_loops_columns' );

// Filter related args
function earth_woo_related_columns( $args ) {
	$cols = intval( earth_get_option( 'woo_shop_cols' ) );
	$cols = $cols ? $cols : 3;
	$args['columns'] = $cols;
	$args['posts_per_page'] = $cols;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'earth_woo_related_columns', 10 );