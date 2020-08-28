<?php
/**
 * LayerSlider Tweaks
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'LS_Sliders' ) ) {
	return;
}

// Edits when layerSlider plugin is not authorized
if ( defined( 'LS_PLUGIN_BASE' ) && ! get_option( 'layerslider-authorized-site', null ) ) {

	// Remove purchase notice on plugins page
	remove_action( 'after_plugin_row_' . LS_PLUGIN_BASE, 'layerslider_plugins_purchase_notice', 10, 3 );

	// Remove updates
	earth_remove_class_filter( 'pre_set_site_transient_update_plugins', 'KM_PluginUpdatesV3', 'set_update_transient', 10 );

	earth_remove_class_filter( 'plugins_api', 'KM_PluginUpdatesV3', 'set_updates_api_results', 10 );

	earth_remove_class_filter( 'upgrader_pre_download', 'KM_PluginUpdatesV3', 'pre_download_filter', 10 );

}