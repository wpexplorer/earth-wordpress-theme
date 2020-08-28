<?php
/**
 * Event helper functions
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return correct event date format
if ( ! function_exists( 'earth_get_event_date_format' ) ) {
	function earth_get_event_date_format() {
		return apply_filters( 'earth_get_event_date_format', get_option( 'date_format' ) );
	}
}

// Convert date format to PHP
if ( ! function_exists( 'earth_convert_php_date_format_to_jquery' ) ) {
	function earth_convert_php_date_format_to_jquery( $php_format ) {
	    $matching_symbols = array(

	        // Day
	        'd' => 'dd',
	        'D' => 'D',
	        'j' => 'd',
	        'l' => 'DD',
	        'N' => '',
	        'S' => '',
	        'w' => '',
	        'z' => 'o',

	        // Week
	        'W' => '',

	        // Month
	        'F' => 'MM',
	        'm' => 'mm',
	        'M' => 'M',
	        'n' => 'm',
	        't' => '',

	        // Year
	        'L' => '',
	        'o' => '',
	        'Y' => 'yy',
	        'y' => 'y',
	        // Time
	        'a' => '',
	        'A' => '',
	        'B' => '',
	        'g' => '',
	        'G' => '',
	        'h' => '',
	        'H' => '',
	        'i' => '',
	        's' => '',
	        'u' => ''
	    );
	    $jqueryui_format = "";
	    $escaping = false;
	    for ( $i = 0; $i < strlen( $php_format ); $i++ ) {
	        $char = $php_format[$i];
	        if ( $char === '\\' ) // PHP date format escaping character
	        {
	            $i++;
	            if ( $escaping ) {
					$jqueryui_format .= $php_format[$i];
	            } else {
					$jqueryui_format .= '\'' . $php_format[$i];
	            }
	            $escaping = true;
	        } else {
	            if ( $escaping ) {
	            	$jqueryui_format .= "'"; $escaping = false;
	            }
	            if ( isset( $matching_symbols[$char] ) ) {
	                $jqueryui_format .= $matching_symbols[$char];
	            } else {
	                $jqueryui_format .= $char;
	            }
	        }
	    }
	    return $jqueryui_format;
	}
}

// Check if the event calendar should display
if ( ! function_exists( 'earth_has_event_sidebar' ) ) {
	function earth_has_event_sidebar() {
		$bool = false;
		if ( earth_get_option( 'events', true ) && earth_get_option( 'events_sidebar', true ) ) {
			if ( is_singular( 'events' )
				|| is_page_template( 'template-events.php' )
				|| is_archive( 'events' )
			) {
				$bool = true;
			}
		} else {
			$bool = false;
		}
		return apply_filters( 'earth_has_event_sidebar', $bool );
	}
}
 
// Return calendar years range
if ( ! function_exists( 'earth_calendar_years_range' ) ) {
	function earth_calendar_years_range() {
		$range = range( 2016, 2019, 1 );
		$range = apply_filters( 'earth_calendar_years_range', $range );
		return $range;

	}
}

// Get Event Months
if ( ! function_exists( 'earth_get_months' ) ) {
	function earth_get_months() {
		return apply_filters( 'earth_get_months', array (
			1  => esc_html__( 'Jan', 'earth' ),
			2  => esc_html__( 'Feb', 'earth' ),
			3  => esc_html__( 'Mar', 'earth' ),
			4  => esc_html__( 'Apr', 'earth' ),
			5  => esc_html__( 'May', 'earth' ),
			6  => esc_html__( 'Jun', 'earth' ),
			7  => esc_html__( 'July', 'earth' ),
			8  => esc_html__( 'Aug', 'earth' ),
			9  => esc_html__( 'Sep', 'earth' ),
			10 => esc_html__( 'Oct', 'earth' ),
			11 => esc_html__( 'Nov', 'earth' ),
			12 => esc_html__( 'Dec', 'earth' ),
		) );
	}
}

if ( ! function_exists( 'earth_numeric_month' ) ) {
	function earth_numeric_month( $month ) {
		if ( 'Jan' == $month ) {
			return 1;
		} elseif ( 'Jan' == $month ) {
			return 2;
		} elseif ( 'Feb' == $month ) {
			return 3;
		} elseif ( 'Mar' == $month ) {
			return 4;
		} elseif ( 'May' == $month ) {
			return 5;
		} elseif ( 'Jun' == $month ) {
			return 6;
		} elseif ( 'July' == $month ) {
			return 7;
		} elseif ( 'Aug' == $month ) {
			return 8;
		} elseif ( 'Sep' == $month ) {
			return 9;
		} elseif ( 'Oct' == $month ) {
			return 10;
		} elseif ( 'Nov' == $month ) {
			return 11;
		} elseif ( 'Dec' == $month ) {
			return 12;
		}
	}
}

// Display event start date
if ( ! function_exists( 'earth_event_display_start_date' ) ) {
	function earth_event_display_start_date( $post_id = '' ) {
		$date = earth_event_timestamp( 'start', $post_id );
		return $date ? date_i18n( earth_get_event_date_format(), esc_attr( $date ) ) : '';
	}
}

// Display event end date
if ( ! function_exists( 'earth_event_display_end_date' ) ) {
	function earth_event_display_end_date( $post_id = '' ) {
		$date = earth_event_timestamp( 'end', $post_id );
		return $date ? date_i18n( earth_get_event_date_format(), esc_attr( $date ) ) : earth_event_display_start_date( $post_id );
	}
}

// Get Event date
if ( ! function_exists( 'earth_event_date' ) ) {
	function earth_event_date( $display = 'month' ) {

		// Get post data
		global $post;

		// Make sure we have a post
		if ( empty( $post ) ) {
			return;
		}

		// Get post meta
		$post_id             = $post->ID;
		$months              = earth_get_months();
		$start_date          = get_post_meta( $post_id, 'earth_event_start_date', true );
		$start_date_new      = get_post_meta( $post_id, 'earth_event_startdate', true );
		$start_data_fallback = get_post_meta( $post_id, 'timestamp_earth_event_start_date', true );

		if ( ! empty( $start_date_new ) ) {
			if ( $display == 'year' ) {
				return date_i18n( 'Y', $start_date_new );
			} elseif ( $display == 'month' ) {
				return date_i18n( 'M', $start_date_new );
			} elseif ( $display == 'day' ) {
				return date_i18n( 'd', $start_date_new );
			}
		} elseif ( ! empty( $start_date ) ) {
			if ( $display == 'month' ) {
				if ( $months[$start_date['month']] ) {
					return $months[$start_date['month']];
				} else {
					return $start_date['month'];
				}
			} else {
				return $start_date[$display];
			}
		} elseif ( ! empty( $start_data_fallback ) ) {
			if ( $display == 'year' ) {
				return date_i18n( 'Y', $start_data_fallback );
			} elseif ( $display == 'month' ) {
				return date_i18n( 'M', $start_data_fallback );
			} elseif ( $display == 'day' ) {
				return date_i18n( 'd', $start_data_fallback );
			}
		}
		
	}
}

// Get Event time
function earth_get_event_start_time( $id = '' ) {
	$id = $id ? $id : get_the_ID();
	$event_time = get_post_meta( $id, 'earth_event_start_time', true );
	if ( $event_time ) {
		if ( '24' == earth_get_option( 'events_time_clock' ) ) {
			$event_time = date( 'H:i', strtotime( $event_time ) );
		} else {
			$event_time = date( 'g:i a', strtotime( $event_time ) );
		}
	}
	return apply_filters( 'earth_get_event_start_time', $event_time );
}
function earth_get_event_end_time( $id = '' ) {
	$id = $id ? $id : get_the_ID();
	$event_time = get_post_meta( $id, 'earth_event_end_time', true );
	if ( $event_time ) {
		if ( '24' == earth_get_option( 'events_time_clock' ) ) {
			$event_time = date( 'H:i', strtotime( $event_time ) );
		} else {
			$event_time = date( 'g:i a', strtotime( $event_time ) );
		}
	}
	return apply_filters( 'earth_get_event_end_time', $event_time );
}

// Get Event date
if ( ! function_exists( 'earth_event_end_date' ) ) {
	function earth_event_end_date( $display = 'month' ) {
		global $post;
		if ( isset( $post ) ) {
			$post_id      = $post->ID;
			$months       = earth_get_months();
			$end_date     = get_post_meta($post_id, 'earth_event_end_date', true);
			$end_date_new = get_post_meta( $post_id, 'earth_event_enddate', true );
			if ( ! $end_date && ! $end_date_new ) {
				return earth_event_date( $display ); // Return start date if end date isn't set
			}
			if ( $end_date_new ) {
				if ( $display == 'year' ) {
					return date( 'Y', $end_date_new );
				} elseif ( $display == 'month' ) {
					return date( 'M', $end_date_new );
				} elseif ( $display == 'day' ) {
					return date( 'd', $end_date_new );
				}
			} else {
				return $end_date[$display];
			}
		}
	}
}

// Event Target (for countdown)
if ( ! function_exists( 'earth_get_event_target' ) ) {
	function earth_get_event_target() {
		if ( is_admin() ) return;
		global $post;
		if ( isset( $post ) ) {
			$post_id    = $post->ID;
			$start_time = get_post_meta( $post_id, 'earth_event_start_time', true );
			$start_time = str_replace( 'a.m.', 'am', $start_time );
			$start_time = str_replace( 'p.m.', 'pm', $start_time );
			$start_time = str_replace( 'am', ' am', $start_time );
			$start_time = str_replace( 'pm', ' pm', $start_time );
			if ( 'noon' == $start_time ) {
				$start_time = '12:00pm';
			}
			if ( $start_date_new = get_post_meta( $post_id, 'earth_event_startdate', true ) ) {
				$target_date = date( 'm', $start_date_new ) . '/' . date( 'd', $start_date_new ) . '/' . date( 'Y', $start_date_new ) .' ' . $start_time;
			} elseif ( $start_date = get_post_meta( $post_id, 'earth_event_start_date', true ) ) {
				$target_date = $start_date['month'] . '/' . $start_date['day'] . '/' . $start_date['year'] . ' ' . $start_time;
			}
			return $target_date;
		}
	}
}


// Event timestamp
if ( ! function_exists( 'earth_event_timestamp' ) ) {
	function earth_event_timestamp( $start_end = 'start', $post_id = '' ) {

		$post_id = $post_id ? $post_id : get_the_ID();

		// Return start date timestamp
		if ( 'start' == $start_end ) {

			// Earth 3.0
			if ( $start_date_new = get_post_meta( $post_id, 'earth_event_startdate', true ) ) {

				return $start_date_new;

			}

			// Earth < 3.0
			if ( $start_date = get_post_meta( $post_id, 'earth_event_start_date', true ) ) {
				
				// Make sure month is numberic
				if ( ! is_numeric( $start_date['month'] ) ) {
					$start_date['month'] = earth_numeric_month( $start_date['month'] );
				}

				$month = intval( $start_date['month'] );
				$day   = intval( $start_date['day'] );
				$year  = intval( $start_date['year'] );
					
				if ( $month && $day && $year ) {
					return intval( mktime( 0, 0, 0, $month, $day, $year ) );
				}

			}

			// Original timestamp date
			if ( $old_start = get_post_meta( $post_id, 'timestamp_earth_event_start_date', true ) ) {
				return $old_start;
			}

		}

		// Return End
		elseif ( 'end' == $start_end ) {

			// New field
			if ( $end_date_new = get_post_meta( $post_id, 'earth_event_enddate', true ) ) {
				return $end_date_new;
			}

			// Deprecated field
			if ( $end_date = get_post_meta( $post_id, 'earth_event_end_date', true ) ) {

				if ( ! is_array( $end_date ) ) {
					return;
				}

				if ( ! is_numeric( $end_date['month'] ) ) {
					$end_date['month'] = earth_numeric_month( $end_date['month'] );
				}

				$month = intval( $end_date['month'] );
				$day   = intval( $end_date['day'] );
				$year  = intval( $end_date['year'] );

				if ( $month && $day && $year ) {
					return intval( mktime( 0, 0, 0, $month, $day, $year ) );
				}

			}

		}

	}
}

// Get Expired Events
if ( ! function_exists( 'earth_get_expired_events_ids' ) ) {
	function earth_get_expired_events_ids() {

		// Clear transient
		if ( isset( $_GET['purge_cache'] ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			delete_transient( 'earth_get_expired_events' );
		}

		// Return transient
		if ( $transient = get_transient( 'earth_get_expired_events' ) ) {
			return $transient;
		}

		// Setup array for the ids
		$ids = array();
		
		// Query Events
		$events = new WP_Query( array(
			'post_type'      => array( 'events' ),
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'post_status'    => 'publish',
		) );

		$events = $events->posts;
		
		// Loop through events
		foreach ( $events as $event_id ) {

			// Update event startdate if not found
			if ( ! is_admin() ) {

				// First add start event if it doesn't exist
				if ( ! get_post_meta( $event_id, 'earth_event_startdate', true )
					&& $old_start = get_post_meta( $event_id, 'timestamp_earth_event_start_date', true )
				) {
					update_post_meta( $event_id, 'earth_event_startdate', $old_start );
				}

			}

			// Check if it has ended
			if ( earth_has_event_ended( $event_id ) ) {
				$ids[] = $event_id;
			}

		}

		// Save transient
		set_transient( 'earth_get_expired_events', $ids, DAY_IN_SECONDS );
		
		// Return ID's
		return $ids;

	}
}

if ( ! function_exists( 'earth_has_event_ended' ) ) {
	function earth_has_event_ended( $event_id = '' ) {
		$event_id = $event_id ? $event_id : get_the_ID();
		$today = mktime( 0, 0, 0, date( 'm' ), date( 'd' ), date( 'Y' ) );

		$end_date = earth_event_timestamp( 'end', $event_id );
		$end_date = $end_date ? $end_date : earth_event_timestamp( 'start', $event_id );
		
		if ( $end_date < $today ) {
			return true;
		}

	}
}

if ( ! function_exists( 'earth_loop_exclude_past_events' ) ) {
	function earth_loop_exclude_past_events() {
		$return = null;
		if ( earth_get_option( 'hide_past_events', true ) ) {
			global $earth_passed_events;
			$return = $earth_passed_events;
		}
		$return = apply_filters( 'earth_loop_exclude_past_events', $return );
		return $return;
	}
}

// Check if event has ended
if ( ! function_exists( 'earth_event_ended' ) ) {
	function earth_event_ended( $post_id = '' ) {
		$post_id = $post_id ? $post_id : '';
		global $earth_passed_events;
		if ( in_array( $post_id, $earth_passed_events ) ) {
			return true;
		}
	}
}

// Check if event is featured
if ( ! function_exists( 'earth_event_is_featured' ) ) {
	function earth_event_is_featured( $post_id = '') {
		$post_id = $post_id ? $post_id : get_the_ID();
		if ( 'yes' == get_post_meta( $post_id, 'earth_featured_event', true ) ) {
			return true;
		} else {
			return false;
		}
	}
}