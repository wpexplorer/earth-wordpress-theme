<?php
/**
 * Template Name: FAQs
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php
	// Display featured image
	if ( has_post_thumbnail() ) : ?>

		<div id="page-featured-image">
			<?php earth_post_thumbnail( 'page', array(
				'alt' => earth_get_esc_title(),
			) ); ?>
		</div><!-- #page-featured-image -->

	<?php endif; ?>

	<?php
	// Display page title if not disabled
	if ( 'Disable' != get_post_meta( get_the_ID(), 'earth_page_title', true ) ) : ?>

		<header id="page-heading" class="clr">
			<h1><?php the_title(); ?></h1>
			<?php earth_breadcrumbs(); ?>
		</header><!-- #page-heading -->

	<?php endif; ?>
	
	<div id="faqs-wrap" class="post clr">
		<?php
		// Load FAQ script
		wp_enqueue_script( 'earth-faqs' );

		// Get FAQs
		global $post;
		$faq_posts = get_posts( array(
			'post_type'        => 'faqs',
			'numberposts'      => '-1',
			'suppress_filters' => false
		) );

		// If faq posts exist lets display them
		if ( $faq_posts ) :

			// Loop through FAQ posts
			foreach ( $faq_posts as $post ) : setup_postdata( $post );

				earth_get_template_part( 'faqs/entry', 'loop-faq' );

			endforeach;

		endif;

		wp_reset_postdata(); ?>
		
	</div>
	
<?php endwhile; ?>	
<?php get_sidebar(); ?>
<?php get_footer(); ?>