<?php
/**
 * WooCommerce Page Template
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

<?php
// Display main header
if ( 'Disable' != get_post_meta( get_the_ID(), 'earth_page_title', true ) ) : ?>

	<header id="page-heading" class="clr">
		<?php if ( is_shop() || is_singular( 'product' ) ) {
			$shop_id = wc_get_page_id( 'shop' ); ?>
			<h1><?php
			if ( $shop_id ) {
				echo esc_html( get_the_title( $shop_id ) );
			} else {
				echo esc_html__( 'Shop', 'earth' );
			} ?></h1>
		<?php } else { ?>
			<h1><?php the_title(); ?></h1>
		<?php } ?>
		<?php earth_breadcrumbs(); ?>
	</header><!-- #page-heading -->

<?php endif; ?>
		
<article class="post et-fitvids clr">
	
	<div class="entry clr">	
		<?php woocommerce_content(); // WooCommerce content is added here ?>
		<?php edit_post_link( __( 'Edit This', 'earth' ), '<div id="post-edit-links" class="clr">', '</div>' ); ?>
	</div><!-- .entry -->

</article><!-- .post -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>