<?php
/**
 * Build Events Calendar
 *
 * Credits : http://davidwalsh.name/php-calendar
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* draws a calendar */
add_action( 'wp_ajax_get_calendar', 'fetch_calendar' );
add_action( 'wp_ajax_nopriv_get_calendar', 'fetch_calendar' );

function fetch_calendar() {

	//security check
	$nonce=$_POST['security'];
	if ( ! wp_verify_nonce($nonce, 'events_calendar' ) ) {
		die( '-1' );
	}

	//get ajax data
	wp_parse_str( stripslashes( $_POST['data'] ), $data );
	$month	= $data['month'];
	$year	= $data['year'];

	//build the title, navs etc
	$months = earth_get_months(); ?>

	<script type="text/javascript">
	jQuery( function( $ ) {
		$(document).ready(function(){
			// render fancy select
			$( '#cal-trigger' ).jqTransform();
			if ( $( window ).width() < 768 ) {
				$( '.calendar-row.days-row' ).hide();
				$( 'td.calendar-day' ).css( {
					'display'    : 'block',
					'min-height' : '0px',
					'width'      : '100%',
					'float'      : 'left',
					'box-sizing' : 'border-box'
				} );
			}
		} );
	} );
	</script>

	<h2 id="calendar_title">
		<i class="fa fa-calendar"></i>
		<?php echo esc_html( $months[$month] ) .' '. esc_html( $year ); ?>
	</h2>

	<div id="calendar-month-select">
		<form id="cal-trigger">
			<select name="month">
			<?php
			// Loopt hrough months
			foreach ( $months as $key => $mth ) {
				echo '<option value="'. esc_attr( $key ) .'" '. selected( $key, $month, false ) .'>'. esc_html( $mth ) .'</option>';
			} ?>
			</select>
			<select name="year">
				<?php
				// Get years range
				$years = earth_calendar_years_range();
				// Loop through years and add select options
				foreach( $years as $yr ) {
					echo '<option value="'. esc_attr( $yr ) .'" '. selected( $yr, $year, false ) .'>'. esc_html( $yr ) .'</option>';
				} ?>
			</select>
			<a id="submit" class="cal-submit yellow-btn" href="#"><?php esc_html_e( 'Go', 'earth' ) ?></a>
		</form>
	</div><!-- #calendar-month-select -->

	<div class="clear"></div>

	<div id="calendar"></div><!-- #calendar -->

	<?php
	//return calendar to js
	echo draw_calendar( $month, $year ); ?>

	<div id="cal-nav">

		<?php
		// Get next month and year
		$next_month	= $month + 1;
		$next_month	= $next_month > 12 ? 1 : $next_month;
		$next_year	= $next_month === 1 ? $year + 1 : $year;

		// Get previous month and year
		$prev_month	= $month - 1;
		$prev_month	= $prev_month <= 0 ? 12 : $prev_month;
		$prev_year	= $prev_month === 12 ? $year - 1 : $year;	 ?>

		<?php if ( earth_get_option( 'event_next_prev', '1' ) == '1' ) { ?>

			<form id="cal-prev_val">
				<input type="hidden" name="month" class="month" value="<?php echo esc_attr( $prev_month ); ?>">
				<input type="hidden" name="year" class="year" value="<?php echo esc_attr( $prev_year ); ?>">
			</form>
			<form id="cal-next_val">
				<input type="hidden" name="month" class="month" value="<?php echo esc_attr( $next_month ); ?>">
				<input type="hidden" name="year" class="year" value="<?php echo esc_attr( $next_year ); ?>">
			</form>
			<input type="button" id="cal-prev" class="yellow-btn" value="&laquo; <?php esc_html_e( 'Prev', 'earth' ); ?>">
			<input type="button" id="cal-next" class="yellow-btn" value="<?php esc_html_e( 'Next', 'earth' ); ?> &raquo;">

		<?php } ?>

	</div><!-- #cal-nav -->

	<?php
	// Crucial!!!
	die();
}

// Draw calendar
function draw_calendar( $month, $year ) {

	// Clear transient
	if ( isset( $_GET['purge_cache'] ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		delete_transient( 'earth_draw_calendar' );
	}

	// Cache
	if ( $transient = get_transient( 'earth_draw_calendar' ) ) {
		return $transient;
	}

	//start draw table
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	// Check if start day is monday or sunday
	$start_of_week = get_option( 'start_of_week' );
	$start_of_week = ( 1 == $start_of_week ) ? $start_of_week : '';

	// Table headings
	if ( ! $start_of_week ) {
		$headings = array(
			esc_html__( 'Sunday', 'earth' ),
			esc_html__( 'Monday', 'earth' ),
			esc_html__( 'Tuesday', 'earth' ),
			esc_html__( 'Wednesday', 'earth' ),
			esc_html__( 'Thursday', 'earth' ),
			esc_html__( 'Friday', 'earth' ),
			esc_html__( 'Saturday', 'earth' ),
		);
	} else {
		$headings = array(
			esc_html__( 'Monday', 'earth' ),
			esc_html__( 'Tuesday', 'earth' ),
			esc_html__( 'Wednesday', 'earth' ),
			esc_html__( 'Thursday', 'earth' ),
			esc_html__( 'Friday', 'earth' ),
			esc_html__( 'Saturday', 'earth' ),
			esc_html__( 'Sunday', 'earth' ),
		);
	}

	$calendar .= '<tr class="calendar-row days-row">';
		$calendar .= '<td class="calendar-day-head">' . implode( '</td><td class="calendar-day-head">', $headings ) . '</td>';
	$calendar .= '</tr>';

	// Get days of week
	$running_day = date( 'w', mktime( 0, 0, 0, $month, 1, $year ) );

	// Fix when week starts on Monday
	if ( $start_of_week ) {
		$running_day = date( 'N', mktime( 0, 0, 0, $month, 1, $year ) ) -1;
	}

	// Get days in months
	$days_in_month		= date( 't', mktime( 0, 0, 0, $month, 1, $year ) );
	$days_in_this_week	= 1;
	$day_counter		= 0;
	$dates_array		= array();

	//get today's date
	$time			= current_time( 'timestamp' );
	$today_day		= date( 'j', $time );
	$today_month	= date( 'n', $time );
	$today_year		= date( 'Y', $time );

	//row for week one */
	$calendar .= '<tr class="calendar-row">';

	//print "blank" days until the first of the current week
	for( $x = 0; $x < $running_day; $x++ ):

		$calendar .= '<td class="calendar-day-np">'.str_repeat( '<p>&nbsp;</p>', 2 ).'</td>';
		$days_in_this_week++;

	endfor;

	//keep going with days
	for( $list_day = 1; $list_day <= $days_in_month; $list_day++ ):

		if ( $today_day == $list_day && $today_month == $month && $today_year == $year ) {
			$today = 'today';
		} else {
			$today = '';
		}

		$cal_day = '<td class="calendar-day '. $today .'">';

		//add in the day numbering
		$cal_day .= '<div class="day-number">'. esc_html( $list_day ) .'</div>';

		// QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !!
		$events = new WP_Query( array(
			'numberposts'      => -1,
			'post_type'        => 'events',
			'post_status'      => 'publish',
			'posts_per_page'   => -1,
			'fields'           => 'ids',
		) );

		$events = $events->posts;

		$cal_event = '';

		foreach ( $events as $event_id ) :

			$id = $event_id;

			// Event time
			$event_time_display	= '';
			$event_time = earth_get_event_start_time( $id );

			if ( $event_time && earth_get_option( 'enable_disable_calendar_time', true ) ) {
				$event_time_display	= ' '. esc_html__( 'at', 'earth' ) .' ' . $event_time;
			}

			//define start date
			$timestamp	= earth_event_timestamp( 'start', $id );
			if ( ! $timestamp ) continue;
			$evt_day	= date( 'j', $timestamp );
			$evt_month	= date( 'n', $timestamp );
			$evt_year	= date( 'Y', $timestamp );

			//max days in the event's month
			$last_day = date( 't', mktime(0, 0, 0, $evt_month, 1, $evt_year));

			//define end date
			$end_timestamp	= earth_event_timestamp( 'end', $id );
			$end_timestamp  = $end_timestamp ? $end_timestamp : $timestamp; // If no end date set to start date
			$evt_end_day	= date( 'j', $end_timestamp );
			$evt_end_month	= date( 'n', $end_timestamp );
			$evt_end_year	= date( 'Y', $end_timestamp );
			$days_span		= round( ( $end_timestamp - $timestamp ) / ( 60*60*24 ) );

			// Year range
			$year_range     = earth_calendar_years_range();
			$year_range_min = $year_range[0];
			$year_range_max = count( $year_range ) - 1;
			$year_range_max = $year_range[$year_range_max];

			if ( $evt_end_year < $year_range_min ||  $evt_end_year > $year_range_max ) {
				continue;
			}

			//check time diff
			if ( ( $end_timestamp - $timestamp )/(60*60*24) > 0 ) {

				//we check if event spans between two diff months
				if ( ( $evt_day + $days_span ) > $last_day ) :

					for( $running_evt_day = $evt_day, $evt_end_day = $evt_day + $days_span ; $running_evt_day <= $evt_end_day; $running_evt_day++ ) {

						$jimbo = $running_evt_day;
						$limbo = $evt_month;
						$kimbo = $evt_year;

						if ( $running_evt_day > $last_day ) {

							$jimbo = $running_evt_day - $last_day;
							$limbo = $evt_end_month;
							$kimbo = $evt_end_year;

						}

						if ( $jimbo == $list_day && $limbo == $month && $kimbo == $year ) {

							// Event classes
							$entry_classes = array( 'event-calendar-entry' );
							if ( earth_event_is_featured( $id ) ) {
								$entry_classes[] = 'featured';
							}
							$entry_classes = implode( ' ', $entry_classes );

							// Display event
							$cal_event .= '<a href="'. get_permalink( $id ) .'" class="'. $entry_classes .'"><i class="fa fa-dot-circle-o"></i>'. get_the_title( $id ) . $event_time_display .'</a>';

						}

					}

				//else just consider for single month
				else :

					for ( $running_evt_day = $evt_day, $evt_end_day = $evt_day + $days_span ; $running_evt_day <= $evt_end_day; $running_evt_day++ ) {

						if (
							$running_evt_day == $list_day &&
							$evt_month == $month &&
							$evt_year == $year
						) {

							// Event classes
							$entry_classes = array( 'event-calendar-entry' );
							if ( earth_event_is_featured( $id ) ) {
								$entry_classes[] = 'featured';
							}
							$entry_classes = implode( ' ', $entry_classes );

							// Display event
							$cal_event .= '<a href="'. get_permalink( $id ) .'" class="'. $entry_classes .'"><i class="fa fa-dot-circle-o"></i>'. get_the_title( $id ) . $event_time_display .'</a>';

						}

					}

				endif;

			} else {
				// We check if any events exists on current iteration
				// If yes, return the link to event
				if ( $evt_day == $list_day && $evt_month == $month && $evt_year == $year ) {

					// Event classes
					$entry_classes = array( 'event-calendar-entry' );
					if ( earth_event_is_featured( $id ) ) {
						$entry_classes[] = 'featured';
					}
					$entry_classes = implode( ' ', $entry_classes );

					$cal_event .= '<a href="'. get_permalink( $id ) .'" class="'. $entry_classes .'"><i class="fa fa-dot-circle-o"></i>'. get_the_title( $id ) . $event_time_display .'</a>';

				}
			}

		endforeach;

		$calendar .= $cal_day;

		$calendar .= $cal_event ? $cal_event : str_repeat( '<p>&nbsp;</p>',2);

		$calendar .= '</td>';

		if ( $running_day == 6 ):

			$calendar .= '</tr>';

			if ( ( $day_counter+1 ) != $days_in_month ):
				$calendar .= '<tr class="calendar-row">';
			endif;

			$running_day = -1;
			$days_in_this_week = 0;

		endif;

		$days_in_this_week++; $running_day++; $day_counter++;

	endfor;

	// Finish the rest of the days in the week
	if ( $days_in_this_week < 8 and $running_day ) :
		for( $x = 1; $x <= ( 8 - $days_in_this_week ); $x++ ):
			$calendar .= '<td class="calendar-day-np">' . str_repeat( '<p>&nbsp;</p>', 2 ) . '</td>';
		endfor;
	endif;

	//final row
	$calendar .= '</tr>';

	//end the table
	$calendar .= '</table>';

	// Save transient
	set_transient( 'earth_draw_calendar', $calendar, HOUR_IN_SECONDS );

	//all done, return the completed table
	return $calendar;
}