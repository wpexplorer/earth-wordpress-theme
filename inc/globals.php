<?php
/**
 * Global vars
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Save passed events in var since it's used multiple times in loops
function earth_globals() {
	global $earth_passed_events;
	$earth_passed_events = earth_get_expired_events_ids();
}
add_action( 'init', 'earth_globals' );