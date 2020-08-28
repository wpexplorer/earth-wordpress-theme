<?php
/**
 * Template Name: Full-Width
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
	
	<?php
	// Display main header
	if ( 'Disable' != get_post_meta( get_the_ID(), 'earth_page_title', true ) ) : ?>

		<header id="page-heading" class="clr">
			<h1><?php the_title(); ?></h1>
			<?php earth_breadcrumbs(); ?>
		</header><!-- #page-heading -->

	<?php endif; ?>
	
	<article class="post full-width et-fitvids clr">	
		
		<div class="entry clr">
			<?php the_content(); ?>
			<?php edit_post_link( __( 'Edit This', 'earth' ), '<div id="post-edit-links" class="clr">', '</div>' ); ?>
		</div><!-- .entry -->
		
		<?php
		// Display comments if enabled
		if ( earth_get_option( 'enable_disable_page_comments', false ) ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>

	</article><!-- .post -->
	
<?php endwhile; ?>

<?php get_footer(); ?>