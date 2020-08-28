<?php
// Add shortcode
if ( ! function_exists( 'events_shortcode' ) ) {

	function events_shortcode( $atts ) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
				'unique_id'				=> '',
				'term_slug'				=> '',
				'posts_per_page'		=> '4',
				'order'					=> 'ASC',
				'orderby'				=> 'event_date',
				'excerpt'				=> 'true',
				'excerpt_length'		=> '20',
				'pagination'			=> 'false',
				'offset'				=> 0,
				'exclude_past_events'	=> 'true',
				'past_events_only'		=> '',
				'month_color'			=> '',
				'date_border_color'		=> '',
				'display_time'          => 'false',
			), $atts ) );
			
		// Get global $post
		global $post;
		
		// Pagination var
		if ( $pagination == 'true' ) {
			global $paged;
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		} else {
			$paged = NULL;
		}

		// Args
		$args = array(
			'post_type'      => 'events',
			'posts_per_page' => $posts_per_page,
			'offset'         => $offset ? $offset : false,
			'paged'          => $paged,
		);

		// Orderby args
		$orderby_array = array();
		if ( 'event_date' == $orderby ) {
			$orderby_array = array (
				'orderby'	=> 'meta_value_num',
				'order'		=> $order,
				'meta_key'	=> 'earth_event_startdate',
			);
		} else {
			$orderby_array = array (
				'oder'		=> $order,
				'orderby'	=> $orderby,
			);
		}

		// Exclude past events
		$exclude_events = array();
		$include_posts = array();
		if ( 'true' == $exclude_past_events && 'true' != $past_events_only ) {
			$exclude_events = array(
				'post__not_in'	=> earth_get_expired_events_ids()
			);
		}

		if ( 'true' == $past_events_only ) {
			$include_posts = array(
				'post__in'	=> earth_get_expired_events_ids()
			);
		}

		$args = array_merge( $args, $orderby_array, $exclude_events, $include_posts );
		
		// The Query
		$wpex_query = new WP_Query( $args );

		//Output posts
		if ( $wpex_query->posts ) :

			// Design
			$date_style = '';
			if ( $date_border_color ) {
				$date_style .= 'border-color:'. $date_border_color .';';
				$date_style = 'style="'. $date_style .'"';
			}

			$month_style = '';
			if ( $month_color ) {
				$month_style = 'background:'. $month_color .';border-color:'. $month_color .';';
				$month_style = 'style="'. $month_style .'"';
			}

			// Start output
			ob_start(); ?>

				<div class="recent-events" id="<?php echo esc_attr( $unique_id ); ?>">
					<?php foreach ( $wpex_query->posts as $post ) : setup_postdata( $post ); ?>
						<article class="event-entry clearfix">
							<div class="event-date">
								<div class="event-month" <?php echo $month_style; ?>>
									<?php echo earth_event_date( 'month' ); ?>
								</div><!-- /event-month -->
								<div class="event-day" <?php echo $date_style; ?>>
									<?php echo earth_event_date( 'day' ); ?>
								</div><!-- /event-day -->
							</div><!--/event-date -->
							<div class="event-entry-content">
								<h3 class="recent-envents-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?>
									<?php if ( 'true' == $display_time ) :
										$stime = earth_get_event_start_time();
										$etime = earth_get_event_end_time(); ?>
										<?php if ( $stime || $etime ) {
											echo '<span class="event-entry-time">(';
												if ( $stime ) {
													echo esc_html( $stime );
												}
												if ( $etime && $stime != $etime ) {
													echo '-'. esc_html( $etime );
												}
											echo ')</span>';
										}
									endif; ?>
								</a></h3>
								<?php if ( 'false' != $excerpt ) {
									if ( get_post_meta( get_the_ID(), 'earth_event_description', TRUE ) ) {
										echo do_shortcode( wp_trim_words( get_post_meta( get_the_ID(), 'earth_event_description', TRUE ), $excerpt_length, '...' ) );
									} else {
										echo wp_trim_words( strip_shortcodes( get_the_content() ), $excerpt_length, '...' );
									}
								} ?>
							</div><!-- /event-entry-content -->
						</article><!-- /event-entry-content -->
					<?php endforeach; ?>
				</div><!-- .wpex-events-grid -->
				
				<?php
				// Paginate Posts
				if ( $pagination == 'true' ) {
					$total = $wpex_query->max_num_pages;
					$big = 999999999;
					if ( $total > 1 )  {
						if ( $current_page = get_query_var( 'paged' ) ) {
							$current_page = $current_page;
						} elseif ( $current_page = get_query_var( 'page' ) ) {
							$current_page = $current_page;
						} else {
							$current_page = 1;
						}
						if ( get_option( 'permalink_structure' ) ) {
							if ( is_page() ) {
								$format = 'page/%#%/';
							} else {
								$format = '/%#%/';
							}
						} else {
							$format = '&paged=%#%';
						}
						echo paginate_links( array(
							'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format'    => $format,
							'current'   => max( 1, $current_page ),
							'total'     => $total,
							'mid_size'  => 2,
							'type'      => 'list',
							'prev_text' => '<i class="fa fa-angle-left"></i>',
							'next_text' => '<i class="fa fa-angle-right"></i>',
					) );
					}
				}
				
			// Set things back to normal
			wp_reset_postdata();
		
			return ob_get_clean();
			
			endif; // End has posts check
		
	}
}
add_shortcode( "events", "events_shortcode" );

// Add to Visual Composer
if ( ! function_exists( 'events_vcmap' ) ) {
	function events_vcmap() {
		return array(
			"name"					=> esc_html__( "Events", 'earth' ),
			'description'			=> esc_html__( "Recent events.", 'earth' ),
			"base"					=> "events",
			"class"					=> "events",
			'category'				=> "Earth",
			"icon"					=> "earth-vc-icon fa fa-calendar",
			"params"				=> array(
				array(
					'type'			=> "textfield",
					"heading"		=> esc_html__( "Unique Id", 'earth' ),
					'param_name'	=> "unique_id",
					'value'			=> "",
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> esc_html__( "Display Event Time", 'earth' ),
					'param_name'	=> "display_time",
					'value'			=> array(
						esc_html__( "No", "earth" )	=> "false",
						esc_html__( "Yes", "earth")	=> "true",
					),
					'std'			=> '',
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> esc_html__( "Excerpt", 'earth' ),
					'param_name'	=> "excerpt",
					'value'			=> array(
						esc_html__( "Yes", "earth")	=> "true",
						esc_html__( "No", "earth" )	=> "false",
					),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> esc_html__( "Excerpt Length", 'earth' ),
					'param_name'	=> "excerpt_length",
					'value'			=> "20",
				),
				// Query
				array(
					'type'			=> "dropdown",
					"heading"		=> esc_html__( "Exclude Past Events", 'earth' ),
					'param_name'	=> "exclude_past_events",
					'value'			=> array(
						esc_html__( "Yes", "earth")	=> "true",
						esc_html__( "No", "earth" )	=> "false",
					),
					'group'			=> esc_html__( 'Query', 'earth' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> esc_html__( "Display Past Events Only", 'earth' ),
					'param_name'	=> "past_events_only",
					'value'			=> array(
						esc_html__( "No", "earth" )	=> "",
						esc_html__( "Yes", "earth")	=> "true",
					),
					'group'			=> esc_html__( 'Query', 'earth' ),
					'std'			=> '',
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> esc_html__( "Order By", 'earth' ),
					'param_name'	=> "orderby",
					'value'			=> array(
						esc_html__( "Event Date", "earth")		=> "event_date",
						esc_html__( "Post Date", "earth")		=> "date",
						esc_html__( "Name", "earth" )			=> "name",
						esc_html__( "Modified", "earth")			=> "modified",
						esc_html__( "Author", "earth" )			=> "author",
						esc_html__( "Random", "earth")			=> "rand",
						esc_html__( "Comment Count", "earth" )	=> "comment_count",
					),
					'group'			=> esc_html__( 'Query', 'earth' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> esc_html__( "Order", 'earth' ),
					'param_name'	=> "order",
					'value'			=> array(
						esc_html__( "ASC", "earth" )	=> "ASC",
						esc_html__( "DESC", "earth")	=> "DESC",
					),
					'group'			=> esc_html__( 'Query', 'earth' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> esc_html__( "Posts Per Page", 'earth' ),
					'param_name'	=> "posts_per_page",
					'value'			=> "4",
					'group'			=> esc_html__( 'Query', 'earth' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> esc_html__( "Pagination", 'earth' ),
					'param_name'	=> "pagination",
					'value'			=> array(
						esc_html__( "No", "earth")	=> "false",
						esc_html__( "Yes", "earth" )	=> "true",
					),
					'group'			=> esc_html__( 'Query', 'earth' ),
				),
				// Design
				array(
					'type'			=> "colorpicker",
					"heading"		=> esc_html__( "Date Border Color", 'earth' ),
					'param_name'	=> "date_border_color",
					'value'			=> "",
					'group'			=> esc_html__( 'Design', 'earth' ),
				),
				array(
					'type'			=> "colorpicker",
					"heading"		=> esc_html__( "Month Color", 'earth' ),
					'param_name'	=> "month_color",
					'value'			=> "",
					'group'			=> esc_html__( 'Design', 'earth' ),
				),
			)
		);
	}
}
vc_lean_map( 'events', 'events_vcmap' );