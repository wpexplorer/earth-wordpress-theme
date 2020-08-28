<?php
class earth_flickr extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'earth_flickr',
			$name = esc_html__( 'Earth - Flickr', 'earth' )
		);

	}
	
	// display the widget in the theme
	public function widget( $args, $instance ) {
		extract($args);
		
		$title = apply_filters( 'widget_title', $instance['title']);
	  	$number = (int) strip_tags($instance['number']);
	  	$id = strip_tags($instance['id']);
		
		echo wp_kses_post( $before_widget ); ?>
                  <?php if ( $title )
                        echo wp_kses_post( $before_title . $title . $after_title ); ?>
				<div class="earth-flickr-widget">
					<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo intval( $number ); ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo esc_attr( $id ); ?>"></script>
				</div>
			<?php
			
		echo wp_kses_post( $after_widget );
		
		//end
	}
	
	// update the widget when new options have been entered
	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) strip_tags($new_instance['number']);
		$instance['id'] = strip_tags($new_instance['id']);

		return $instance;
	}
	
	// print the widget option form on the widget management screen
	public function form( $instance ) {

	// combine provided fields with defaults
	$instance = wp_parse_args( (array) $instance, array( 'title' => 'Flickr Feed', 'id' => '', 'number'=> 6 ) );
	$id = strip_tags($instance['id']);
	$number = strip_tags($instance['number']);
	$title = strip_tags($instance['title']); ?>

	<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php esc_html_e( 'Title:', 'earth' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo
		esc_attr($title); ?>" /></p>
	
	<p><label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>">
		<?php esc_html_e( 'Flickr ID ', 'earth' ); ?>(<a href="http://www.idgettr.com" target="_blank">idGettr</a>):</label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>" type="text" value="<?php echo
		esc_attr($id); ?>" /></p>

	<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
		<?php esc_html_e( 'Number:', 'earth' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo
		esc_attr($number); ?>" /></p>

	<?php
	}
}
function earth_register_flickr_widget() {
	register_widget( 'earth_flickr' );
}
add_action( 'widgets_init', 'earth_register_flickr_widget' );	