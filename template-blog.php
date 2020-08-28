<?php
/**
 * Template Name: Blog
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

	<div class="post et-fitvids clr">
		<?php
		// Query Arguments
		$args = array(
			'post_type'       => 'post',
			'paged'           => $paged,
			'supress_filters' => false,
		);
		// Query by category
		$blog_parent = get_post_meta( get_the_ID(), 'earth_blog_parent', true);
		if ( $blog_parent !== 'select_blog_parent' && $blog_parent !== 'none' ) {
			$args['tax_query'] = array( array(
				'taxonomy' => 'category',
				'field'    => 'id',
				'terms'    => $blog_parent,
			) );
		}

		// Query posts
		$blog_posts = new WP_Query( $args ); ?>

		<?php if ( $blog_posts->have_posts() ) : ?>
			<div class="loop-wrap clr">
				<?php
				// Loop through posts and get entry output file
				// See template-parts/post-entry.php
				while ( $blog_posts->have_posts() ) : $blog_posts->the_post();
					earth_get_template_part( 'post-entry' );
				endwhile; ?>
			</div><!-- .loop-wrap -->
		<?php endif; ?>

		<?php earth_pagination( $blog_posts ); wp_reset_postdata(); ?>

	</div>

<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>