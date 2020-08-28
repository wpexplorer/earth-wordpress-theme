<?php
/**
 * Event entry
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Classes
$class = array( 'event-entry', 'clr' );
if ( earth_event_is_featured() ) {
	$class[] = 'featured';
} ?>

<article <?php post_class( $class ); ?>>
	<div class="event-date clr">
		<div class="event-month"><?php echo earth_event_date( 'month' ); ?></div>
		<div class="event-day"><?php echo earth_event_date( 'day' ); ?></div>
	</div>
	<div class="event-entry-content clr">
		<h3><a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>">
			<?php the_title(); ?>
			<?php if ( earth_get_option( 'enable_disable_event_list_time', false ) ) {
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
				} ?>
			<?php } ?>
		</a></h3>
		<?php if ( $description = get_post_meta( get_the_ID(), 'earth_event_description', true ) ) {
			echo wp_kses_post( do_shortcode( $description ) );
		} elseif ( has_excerpt() ) {
			global $post;
			echo wp_kses_post( $post->post_excerpt );
		} else {
			echo wp_trim_words( strip_shortcodes( get_the_content() ), 11, '&hellip;' );
		} ?>
	</div>
</article>