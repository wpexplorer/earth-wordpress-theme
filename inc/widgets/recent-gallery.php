<?php
class earth_recent_gallery extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'earth_recent_gallery',
			esc_html__( 'Earth - Recent Gallery Items', 'earth' ),
			array(
                'customize_selective_refresh' => true,
            )
		);

	}

	public function widget($args, $instance) {
		extract( $args );
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$number = isset( $instance['number'] ) ? $instance['number'] : 12;
		$category = isset( $instance['category'] ) ? $instance['category'] : 'all-cats'; ?>
			<?php echo wp_kses_post( $before_widget ); ?>
				<?php if ( $title ) {
					echo wp_kses_post( $before_title . $title . $after_title );
				} ?>
				<div class="widget-recent-gallery clearfix">
					<?php
					global $post;
					$tmp_post = $post;
					$args = array(
						'post_type'        => 'gallery',
						'posts_per_page'   => $number,
						'suppress_filters' => false,
						'meta_key'         => '_thumbnail_id',
					);
					if ( $category && $category != 'all-cats' ){
						$args['tax_query'] = array( array(
							'taxonomy' => 'gallery_cats',
							'field'    => 'id',
							'terms'    => $category,
						) );
					}
					$earth_query = new WP_Query( $args );
					if ( $earth_query->have_posts() ) : ?>
						<div class="et-row et-gap-10 clr">
							<?php
							$count=0;
							while ( $earth_query->have_posts() ) : $earth_query->the_post();
							$count++; ?>
								<div class="et-nr-col span_1_of_4 et-col-<?php echo intval( $count ); ?>">
									<a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>" class="styled-img">
										<?php echo earth_get_post_thumbnail( array(
											'width'  => 150,
											'height' => 150,
											'crop'   => true,
										) ); ?>
										<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
									</a>
								</div>
							<?php if ( 4 == $count ) $count = 0; ?>
							<?php endwhile; ?>
						</div>
					<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				</div>
			<?php echo wp_kses_post( $after_widget ); ?>
		<?php
			}
		
			/** @see WP_Widget::update */
			function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['category'] = strip_tags($new_instance['category']);
				return $instance;
			}
		
			/** @see WP_Widget::form */
			function form( $instance ) {

				extract( wp_parse_args( (array) $instance, array(
					'title'    => '',
					'id'       => '',
					'number'   => 12,
					'category' => 'all-cats',
				) ) ); ?>
				
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'earth' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title','earth' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number to Show:', 'earth' ); ?></label> 
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number  ); ?>" />
				</p>
				
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select a Category:', 'earth' ); ?></label> 
					<select class='earth-select' name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
					<option value="all-cats" <?php if ($category == 'all-cats' ) { ?>selected="selected"<?php } ?>><?php esc_html_e( 'All', 'earth' ); ?></option>
					<?php
					//get terms
					$cat_args = array( 'hide_empty' => '1' );
					$cat_terms = get_terms( 'gallery_cats', $cat_args);
					foreach ( $cat_terms as $cat_term) { ?>
						<option value="<?php echo esc_attr( $cat_term->term_id ); ?>" id="<?php echo esc_attr( $cat_term->term_id ); ?>" <?php if ($category == $cat_term->term_id) { ?>selected="selected"<?php } ?>><?php echo esc_attr( $cat_term->name ); ?></option>
					<?php } ?>
					</select>
				</p>

		<?php 
	}

}
function earth_register_recent_gallery_widget() {
	register_widget( 'earth_recent_gallery' );
}
add_action( 'widgets_init', 'earth_register_recent_gallery_widget' );