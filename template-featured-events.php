<?php
/**
 * Template Name: Featured Events
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php if ( get_post_meta( get_the_ID(), 'earth_page_title', true ) !== 'Disable' ) : ?>

		<header id="page-heading" class="clr">
			<h1><?php the_title(); ?></h1>
			<?php earth_breadcrumbs(); ?>
		</header>
		
	<?php endif; ?>
		
	<div class="post clr">
		<?php if ( get_the_content() ) { ?>
			<div id="event-description" class="clr"><?php the_content(); ?></div>
		<?php } ?>
		<div id="event-wrap" class="clr">
			<?php
			// Get events
			query_posts( array(
				'post_type'			=>'events',
				'posts_per_page'	=> 10,
				'paged'				=> $paged,
				'orderby'			=> 'meta_value_num',
				'order'				=> earth_get_option( 'events_order' ),
				'meta_key'			=> 'earth_event_startdate',
				'meta_query'		=> array(
					array (
						'key'		=> 'earth_featured_event',
						'value'		=> 'yes',
						'compare'	=> '=',
					)
				),
				'post__not_in'		=> earth_loop_exclude_past_events() // exclude past events
			) );
			//start loop
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					earth_get_template_part( 'events/entry', 'loop-entry' );
				endwhile;
			endif; ?>
		</div>
		<div id="event-pagination" class="clr"><?php earth_pagination(); ?></div>
		<?php wp_reset_query(); ?>
	</div>

<?php endwhile; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>