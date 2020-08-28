<?php
/**
 * FAQ Post Type Archive
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

	<header id="page-heading" class="clr">
		<h1><?php post_type_archive_title(); ?></h1>
		<?php earth_breadcrumbs(); ?>
	</header><!-- #page-heading -->

	<div id="faqs-wrap" class="post clr">

		<?php
		// Load FAQ toggle script
		wp_enqueue_script( 'earth-faqs' );

		// Loop through FAQs
		while ( have_posts() ) : the_post();

			earth_get_template_part( 'faqs/entry', 'loop-faq' );

		endwhile; ?>

	</div><!-- #faqs-wrap -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>