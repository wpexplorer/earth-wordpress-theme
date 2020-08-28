<?php
/**
 * Single FAQ
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
			<?php
			// Display the thumbnail
			earth_post_thumbnail( 'page', array(
				'alt' => earth_get_esc_title(),
			) ); ?>
		</div><!-- #page-featured-image -->

	<?php endif; ?>
	
	<header id="page-heading" class="clr">
		<h1><?php the_title(); ?></h1>
		<?php earth_breadcrumbs(); ?>
	</header>
		
	<article class="post full-width et-fitvids clr">	
		<div class="entry clr"><?php the_content(); ?></div>
	</article>
	
<?php endwhile; ?>
<?php get_footer(); ?>