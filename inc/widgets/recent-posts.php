<?php
class earth_recent_posts extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'earth_recent_posts',
			esc_html__( 'Earth - Recent Posts With Thumbnails', 'earth' ),
			array(
                'customize_selective_refresh' => true,
            )
		);

	}
		
	public function widget( $args, $instance ) {
		extract( $args );
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$number = $instance['number'];
		$category = $instance['category']; ?>
			<?php echo wp_kses_post( $before_widget ); ?>
				<?php if ( $title )
				echo wp_kses_post( $before_title . $title . $after_title ); ?>
					<ul class="widget-recent-posts clearfix">
						<?php
						$query_args = array(
							'post_type'      => 'post',
							'posts_per_page' => $number,
							'meta_query'     => array( 'key' => '_thumbnail_id' ) 
						);
						if ( $category && $category != 'all-cats' ) {
							$query_args['tax_query'] = array( array(
								'taxonomy'	=> 'category',
								'field'		=> 'id',
								'terms'		=> $category
							) );
						}
						$et_query = new WP_Query( $query_args ); 
						if ( $et_query->have_posts() ) :
							while ( $et_query->have_posts() ) : $et_query->the_post(); ?>
								<li class="recent-post clearfix">
									<a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>" class="styled-img recent-post-thumb">
										<?php echo earth_get_post_thumbnail( array(
												'width'  => 80,
												'height' => 65,
												'crop'   => true,
											) ); ?>
										<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
									</a>
									<h5><a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>"><?php the_title(); ?></a></h5>
									- <span class="recent-post-date"><?php echo get_the_date(); ?></span>
								</li>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						<?php endif;?>
					</ul>
			  <?php echo wp_kses_post( $after_widget ); ?>
			<?php
			}
		
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title']    = strip_tags( $new_instance['title'] );
			$instance['number']   = strip_tags( $new_instance['number'] );
			$instance['category'] = strip_tags( $new_instance['category'] );
			return $instance;
		}
	
		public function form( $instance ) {
			
			extract( wp_parse_args( (array) $instance, array(
				'title'    => '',
				'id'       => '',
				'number'   => 3,
				'category' => 'all-cats'
			) ) ); ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'earth' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title','earth' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number to Show:', 'earth' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select a Category:', 'earth' ); ?></label> 
				<select class='earth-select' name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
				<option value="all-cats" <?php if ($category == 'all-cats' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'All', 'earth' ); ?></option>
				<?php
				//get terms
				$cat_args = array( 'hide_empty' => '1' );
				$cat_terms = get_terms( 'category', $cat_args);
				foreach ( $cat_terms as $cat_term) { ?>
					<option value="<?php echo esc_attr( $cat_term->term_id ); ?>" id="<?php echo esc_attr( $cat_term->term_id ); ?>" <?php if ($category == $cat_term->term_id) { ?>selected="selected"<?php } ?>><?php echo esc_attr( $cat_term->name ); ?></option>
				<?php } ?>
				</select>
			</p>

		<?php
	}

}
function earth_register_recent_posts_widget() {
	register_widget( 'earth_recent_posts' );
}
add_action( 'widgets_init', 'earth_register_recent_posts_widget' );	