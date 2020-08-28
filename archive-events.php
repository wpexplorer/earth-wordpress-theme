<?php
/**
 * Events Post Type Archive
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

	<header id="page-heading" class="clr">
		<h1><?php post_type_archive_title(); ?></h1>
		<?php earth_breadcrumbs(); ?>
	</header>
	
	<div class="post clr">
		<div id="event-wrap" class="clr">
			<?php while ( have_posts() ) : the_post();
				earth_get_template_part( 'events/entry', 'loop-entry' );
			endwhile; ?>
		</div>
		<div id="event-pagination"><?php earth_pagination(); ?></div>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>