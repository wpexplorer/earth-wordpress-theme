<?php
/**
 * Single Highlight
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

// Redirect this custom post type to your homepage because it has no content --- Used for homepage only.
wp_redirect( esc_url( home_url( '/' ) ) ); exit;

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
	
		<header id="page-heading">
			<h1><?php the_title(); ?></h1>
			<?php earth_breadcrumbs(); ?>
		</header>
			
		<article class="post">
		
			<div class="entry clearfix"><?php the_content(); ?></div>
			
			<?php if ( earth_get_option( 'enable_disable_page_comments' ) !== 'disable' ) comments_template(); ?>   
		
		</article>
	
	<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>