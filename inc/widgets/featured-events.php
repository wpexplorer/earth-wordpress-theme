<?php
class earth_upcoming_events extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'earth_upcoming_events',
			esc_html__( 'Earth - Featured Events','earth' ),
			array(
                'customize_selective_refresh' => true,
            )
		);

	}

    public function widget($args, $instance) {

        extract( $args );
        
        $title  = isset( $instance['title'] ) ? $instance['title'] : '';
        $title  = apply_filters( 'widget_title', $instance['title'] );
        $number = apply_filters( 'widget_title', $instance['number'] ); ?>

              <?php echo wp_kses_post( $before_widget ); ?>
                  <?php if ( $title )
                        echo wp_kses_post( $before_title . $title . $after_title ); ?>
							<ul class="widget-event clearfix">
							<?php
								global $post;
								$tmp_post = $post;
								$args = array(
									'post_type'        => 'events',
									'numberposts'      => $number,
									'orderby'          => 'meta_value_num',
									'order'            => earth_get_option( 'events_order' ),
									'no_found_rows'    => true,
									'post__not_in'     => earth_loop_exclude_past_events(),
									'meta_key'         => 'earth_event_startdate',
									'suppress_filters' => false,
									'meta_query'       => array( array(
										'key'     => 'earth_featured_event',
										'value'   => 'yes',
										'compare' => '=',
									) )
								);
								$myposts = get_posts( $args );
								foreach( $myposts as $post ) : setup_postdata($post);
								
								//description
								$event_description = get_post_meta($post->ID, 'earth_event_description', TRUE); ?>
                                    
                                    <li class="widget-event-entry clearfix">
                                        <div class="widget-event-date">
                                            <div class="widget-event-month">
                                                <?php echo earth_event_date( 'month' ); ?>
                                            </div><!-- /widget-event-month -->
                                            <div class="widget-event-day">
                                                <?php echo earth_event_date( 'day' ); ?>
                                            </div><!-- /widget-event-day -->
                                        </div><!--/widget-event-date -->
                                        <div class="widget-event-entry-content">
                                            <h5><a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>"><?php the_title(); ?></a></h5>
                                            <?php if ($event_description) { echo do_shortcode($event_description); } else { echo wp_trim_words( get_the_content(), 11, '...' ); } ?>
                                        </div><!-- /widget-event-entry-content -->
                                    </li>

								<?php endforeach; ?>

								<?php $post = $tmp_post; ?>

							</ul>
                            <!-- /widget-event -->

              <?php echo wp_kses_post( $after_widget ); ?>

        	<?php
			}
		
			public function update( $new_instance, $old_instance ) {				
				$instance           = $old_instance;
				$instance['title']  = strip_tags($new_instance['title']);
				$instance['number'] = strip_tags($new_instance['number']);
				return $instance;
			}
		
			public function form($instance) {
				extract( wp_parse_args( (array) $instance, array(
					'title'  => '',
					'id'     => '',
					'number' => 3,
				) ) ); ?>
				
				 <p>
				  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'earth' ); ?></label> 
				  <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title','earth' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</p>
				
				<p>
				  <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number to Show:', 'earth' ); ?></label> 
				  <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
				</p>
        <?php 
    }

}
function earth_register_upcoming_events_widget() {
	register_widget( 'earth_upcoming_events' );
}
add_action( 'widgets_init', 'earth_register_upcoming_events_widget' );	