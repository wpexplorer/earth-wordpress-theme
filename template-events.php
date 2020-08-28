<?php
/**
 * Template Name: Events
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php
	// Display main page title
	if ( 'Disable' != get_post_meta( get_the_ID(), 'earth_page_title', true ) ) : ?>

		<header id="page-heading" class="clr">
			<h1><?php the_title(); ?></h1>
			<?php earth_breadcrumbs(); ?>
		</header>

	<?php endif; ?>
		
	<div class="post clr">

		<?php
		// Display page content
		if ( get_the_content() ) : ?>

			<div id="event-description" class="clr"><?php the_content(); ?></div>

		<?php endif; ?>

		<?php
		// Pagination vars
		global $post, $paged, $more;
		$more = 0;
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} else if ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		// Posts per page
		$ppp = earth_get_option( 'events_list_ppp' );
		$ppp = $ppp ? $ppp : 10;

		// Order
		$order = earth_get_option( 'events_order' );
		$order = $order ? $order : 'ASC';

		// Query posts
		$events_query = new WP_Query( array(
			'post_type'      =>'events',
			'posts_per_page' => $ppp,
			'paged'          => $paged,
			'orderby'        => 'meta_value_num',
			'meta_query'     => array( array(
				'key' => 'earth_event_startdate',
			) ),
			'order'          => $order,
			'post__not_in'   => earth_loop_exclude_past_events(),
		) );

		// Display events if there are events to show
		if ( $events_query->have_posts() ) :

			// For pagination
			$max_num_pages = $events_query->max_num_pages; ?>

			<div id="event-wrap" class="clr">

				<?php
				// Loop through events
				while ( $events_query->have_posts() ) :

					// Setup post data
					$events_query->the_post();

					// Display event
					earth_get_template_part( 'events/entry', 'loop-entry' );

				// End event loop
				endwhile; ?>

			</div><!-- #event-wrap -->

			<div id="event-pagination" class="clr"><?php earth_pagination( $events_query ); ?></div>

		<?php wp_reset_postdata(); endif; ?>

	</div><!-- .post -->

<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>