<?php
/**
 * FAQ Categories
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

	<header id="page-heading" class="clr">
		<h1><?php echo single_term_title(); ?></h1>
		<?php earth_breadcrumbs(); ?>
	</header><!-- #page-heading -->

	<div id="faqs-wrap" class="post clr">

		<?php
		// Load FAQ script
		wp_enqueue_script( 'earth-faqs' );

		// Loop through posts
		while ( have_posts() ) : the_post();

			earth_get_template_part( 'faqs/entry', 'loop-faq' );

		endwhile; ?>

	</div><!-- #faqs-wrap -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>