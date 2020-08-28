<?php
/**
 * Events Full Section
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//meta query = show all events or just featured?
if ( earth_get_option( 'home_featured_event' ) == '1' ){
	$meta_query = array(
		array (
			'key' 		=> 'earth_featured_event',
			'value'		=> 'yes',
			'compare'	=> '=',
		)
	);
} else { $meta_query = NULL; }

//get post type ==> events
global $post;
$args = array(
	'post_type'			=> 'events',
	'numberposts'		=> earth_get_option( 'home_events_count' ),
	'orderby'			=> 'meta_value',
	'order'				=> earth_get_option( 'events_order' ),
	'meta_key'			=> 'earth_event_startdate',
	'meta_query'		=> $meta_query,
	'suppress_filters'	=> false, // WPML Support
	'post__not_in'		=> earth_loop_exclude_past_events() // exclude past events
);
$wpex_query = get_posts($args);

// Show section if posts exist
if ( $wpex_query ) :

	// Section title
	$wpex_section_title = '';
	if ( earth_get_option( 'home_events_title' ) ) {
		$wpex_section_title = earth_get_option( 'home_events_title' );
	} else {
		$wpex_section_title = esc_html__( 'Recent Events', 'earth' );
	} ?>
	<div id="recent-events" class="full-width clr">
		<?php if ( 'disable' != $wpex_section_title ) { ?>
			<h2 class="heading">
				<?php
				// Title link
				$link = earth_get_option( 'home_events_title_link' );
				if ( $link ) { ?>
					<a href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( $wpex_section_title ); ?>">
				<?php }
				// Title text
				echo esc_html( $wpex_section_title );
				// Close link tag
				if ( $link ) {
					echo '</a>';
				} ?>
			</h2>
		<?php } ?>
		<?php
		// Loop through events
		foreach( $wpex_query as $post) : setup_postdata($post);
			earth_get_template_part( 'events/entry', 'loop-event' );
		endforeach; ?>
	</div>

<?php endif; ?>


<?php wp_reset_postdata(); ?>