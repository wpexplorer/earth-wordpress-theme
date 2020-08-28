<?php
/**
 * Search page
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

<header id="page-heading" class="clr">
	<h1 id="archive-title"><?php esc_html_e('Search Results For', 'earth'); ?> "<?php the_search_query(); ?>"</h1>
	<?php earth_breadcrumbs(); ?>
</header>

<section class="post clr">  

	<?php if ( have_posts() ) : ?>
		
		<div class="loop-wrap clr">
			<?php while ( have_posts() ) : the_post(); ?>
				<article class="search-entry clr">
					<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<?php if ( has_post_thumbnail() ) { ?>
						<a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>" class="search-entry-img styled-img">
							<?php echo earth_get_post_thumbnail( 'search_entry' ); ?>
							<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
						</a>
						<?php } ?>
					<div class="search-entry-content clr"><?php earth_excerpt( '50' ); ?></div>
				</article>
			<?php endwhile; ?>
		</div>

		<?php earth_pagination(); ?>
		
	<?php else : ?>
		<p class="no-results"><?php esc_html_e('No Results Found', 'earth'); ?></p> 
	<?php endif; ?>
	
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>