<?php
// Add shortcode
if ( ! function_exists( 'events_grid_shortcode' ) ) {

	function events_grid_shortcode( $atts ) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
			'unique_id'				=> '',
			'term_slug'				=> '',
			'columns'				=> '4',
			'posts_per_page'		=> '12',
			'order'					=> 'ASC',
			'orderby'				=> 'event_date',
			'title'					=> 'true',
			'excerpt'				=> '',
			'excerpt_length'		=> '20',
			'pagination'			=> 'false',
			'offset'				=> 0,
			'img_width'				=> '9999',
			'img_height'			=> '9999',
			'img_crop'              => '',
			'exclude_past_events'   => 'true',
			'past_events_only'      => 'false',
			'date'                  => '',
			'display_time'          => 'false',
		), $atts ) );

		ob_start();
			
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
		if ( $wpex_query->posts ) : ?>

				<div class="events-grid clr et-row" id="<?php echo esc_attr( $unique_id ); ?>">
					<?php
					$count=0;
					// Start loop
					foreach ( $wpex_query->posts as $post ) : setup_postdata( $post );
						$count++;
						if ( 'false' != $date ) {
							if ( earth_event_ended( get_the_ID() ) ) {
								$date = esc_html__( 'Ended', 'earth' );
							} else {
								$date = earth_event_display_start_date();
								$date = apply_filters( 'events_grid_date_format', $date );
							} 
						} ?>
						<div class="events-grid-entry clr et-col span_1_of_<?php echo esc_attr( $columns ); ?> et-col-<?php echo esc_attr( $count ); ?>">
							<?php if ( has_post_thumbnail() ) { ?>
								<div class="events-grid-entry-thumbnail clearfix">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="styled-img">
										<?php echo earth_get_post_thumbnail( array(
											'width'  => $img_width,
											'height' => $img_height,
											'crop'   => ( $img_height == 9999 && ! $img_crop ) ? false : $img_crop,
										) ); ?>
										<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
										<?php if ( 'false' != $date ) { ?>
										<div class="events-grid-date"><?php echo esc_html( $date ); ?></div>
										<?php } ?>
									</a>
								</div>
							<?php } ?>
							<?php if ( 'false' != $title ) { ?>
								<h3 class="events-grid-entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?>
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
							<?php } ?>
							<?php if ( 'false' != $excerpt ) { ?>
							<div class="events-grid-entry-excerpt clearfix">
								<?php if ( get_post_meta( get_the_ID(), 'earth_event_description', TRUE ) ) {
									echo do_shortcode( get_post_meta( get_the_ID(), 'earth_event_description', TRUE ) );
								} elseif ( has_excerpt() ) {
									global $post;
									echo wp_kses_post( $post->post_excerpt );
								} else {
									echo wp_trim_words( strip_shortcodes( get_the_content() ), $excerpt_length, '&hellip;' );
								} ?>
							</div>
							<?php } ?>
						</div>
					<?php
					if ( $count == $columns ) {
						$count = 0;
					}
					endforeach; ?>
				</div>
				
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

		// End has posts check
		endif;
				
		// Set things back to normal
		wp_reset_postdata();
		
		return ob_get_clean();
		
	}
}
add_shortcode( "events_grid", "events_grid_shortcode" );

// Make shortcode to VC
if ( ! function_exists( 'events_grid_vcmap' ) ) {
	function events_grid_vcmap() {
		return array(
			"name" => esc_html__( "Events Grid", 'earth' ),
			'description'  => esc_html__( "Recent events in grid format.", 'earth' ),
			"base" => "events_grid",
			'category'  => "Earth",
			"icon" => "earth-vc-icon fa fa-calendar",
			"params" => array(
				// General
				array(
					'type' => "textfield",
					"heading" => esc_html__( "Unique Id", 'earth' ),
					'param_name' => "unique_id",
					'value' => "",
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Columns", 'earth' ),
					"param_name" => "columns",
					"std" => '4', // required
					"value" => array(
						'4' =>'4',
						'3' =>'3',
						'2' =>'2',
						'1' =>'1',
					),
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Date", 'earth' ),
					'param_name' => "date",
					'value' => array(
						esc_html__( "Yes", "earth") => "",
						esc_html__( "No", "earth" ) => "false",
					),
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Title", 'earth' ),
					'param_name' => "title",
					'value' => array(
						esc_html__( "Yes", "earth") => "true",
						esc_html__( "No", "earth" ) => "false",
					),
					'std' => 'true',
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Display Event Time", 'earth' ),
					'param_name' => "display_time",
					'value' => array(
						esc_html__( "No", "earth" ) => "false",
						esc_html__( "Yes", "earth") => "true",
					),
					'std'  => 'false',
					'dependency' => array( 'element' => 'title', 'value' => 'true' )
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Excerpt", 'earth' ),
					'param_name' => "excerpt",
					'value' => array(
						esc_html__( "Yes", "earth") => "",
						esc_html__( "No", "earth" ) => "false",
					),
				),
				array(
					'type' => "textfield",
					"heading" => esc_html__( "Excerpt Length", 'earth' ),
					'param_name' => "excerpt_length",
					'value' => "20",
				),
				//Query
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Exclude Past Events", 'earth' ),
					'param_name' => "exclude_past_events",
					'value' => array(
						esc_html__( "Yes", "earth") => "true",
						esc_html__( "No", "earth" ) => "false",
					),
					'group' => esc_html__( 'Query', 'earth' ),
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Display Past Events Only", 'earth' ),
					'param_name' => "past_events_only",
					'value' => array(
						esc_html__( "No", "earth" ) => "false",
						esc_html__( "Yes", "earth") => "true",
					),
					'group' => esc_html__( 'Query', 'earth' ),
					'std'  => '',
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Order By", 'earth' ),
					'param_name' => "orderby",
					'value' => array(
						esc_html__( "Event Date", "earth") => "event_date",
						esc_html__( "Post Date", "earth") => "date",
						esc_html__( "Name", "earth" )  => "name",
						esc_html__( "Modified", "earth") => "modified",
						esc_html__( "Author", "earth" ) => "author",
						esc_html__( "Random", "earth") => "rand",
						esc_html__( "Comment Count", "earth" )  => "comment_count",
					),
					'group' => esc_html__( 'Query', 'earth' ),
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Order", 'earth' ),
					'param_name' => "order",
					'value' => array(
						esc_html__( "ASC", "earth" ) => "ASC",
						esc_html__( "DESC", "earth") => "DESC",
					),
					'group' => esc_html__( 'Query', 'earth' ),
				),
				array(
					'type' => "textfield",
					"heading" => esc_html__( "Posts Per Page", 'earth' ),
					'param_name' => "posts_per_page",
					'value' => "12",
					'group' => esc_html__( 'Query', 'earth' ),
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Pagination", 'earth' ),
					'param_name' => "pagination",
					'value' => array(
						esc_html__( "No", "earth")  => "false",
						esc_html__( "Yes", "earth" ) => "true",
					),
					'group' => esc_html__( 'Query', 'earth' ),
				),
				// Image Settings
				array(
					'type' => 'textfield',
					'class' => '',
					'heading' => esc_html__( 'Image Width', 'earth' ),
					'param_name' => 'img_width',
					'value' => '9999',
					'group' => esc_html__( 'Image', 'earth' ),
				),
				array(
					'type' => 'textfield',
					'class' => '',
					'heading' => esc_html__( 'Image Height', 'earth' ),
					'param_name' => 'img_height',
					'value' => '9999',
					'group' => esc_html__( 'Image', 'earth' ),
				),
				array(
					'type' => 'dropdown',
					'class' => '',
					'heading' => esc_html__( 'Image Crop', 'earth' ),
					'param_name' => 'img_crop',
					'group' => esc_html__( 'Image', 'earth' ),
					'value' => earth_vc_image_crop_options(),
				),
			)
		);
	}
}
vc_lean_map( 'events_grid', 'events_grid_vcmap' );