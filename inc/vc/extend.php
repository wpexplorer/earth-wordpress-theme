<?php
/**
 * Extends the Visual Composer plugin to add a few more epic modules
 *
 * @package WordPress
 * @subpackage Earth
 * @version 4.0
 */

define( 'EARTH_VC_DIR', EARTH_INC_DIR . '/vc/' );
define( 'EARTH_VC_DIR_URI', EARTH_INC_DIR_URI . '/vc/' );

// Remove nasty vc logo
function earth_vc_remove_branding() {
	return '<div id="vc_logo" class="vc_navbar-brand" aria-hidden="true"></div>';
}
add_filter( 'vc_nav_front_logo', 'earth_vc_remove_branding' );

// Load admin scripts
function earth_vc_admin_scripts( $hook ) {

	$hooks = array(
		'edit.php',
		'post.php',
		'post-new.php',
		'widgets.php',
		'toolset_page_ct-editor', // Support VC widget plugin
	);

	if ( ! in_array( $hook, $hooks ) ) {
		return;
	}

	wp_enqueue_style(
		'earth-vc-admin',
		EARTH_ASSETS_DIR_URI . 'css/vc-admin.css',
		array(),
		EARTH_THEME_VERSION
	);

}
add_action( 'admin_enqueue_scripts', 'earth_vc_admin_scripts', 20 );

// Load iFrame scripts
function earth_vc_iframe_scripts() {
	wp_enqueue_style(
		'earth-vc-iframe',
		EARTH_ASSETS_DIR_URI . 'css/vc-iframe.css',
		array(),
		EARTH_THEME_VERSION
	);
}
add_action( 'vc_load_iframe_jscss', 'earth_vc_iframe_scripts' );

// Check if VC theme mode is enabled
function earth_theme_mode_check() {
	$theme_mode = apply_filters( 'earth_vc_set_as_theme', false );
	if ( vc_license()->isActivated() ) {
		$theme_mode = false; // disable if VC is active
	}
	return $theme_mode;
}

// Set vc in theme mode
if ( earth_theme_mode_check() && function_exists( 'vc_set_as_theme' ) ) {
	vc_set_as_theme( true );
}

// Remove things if license isn't active
if ( apply_filters( 'earth_hide_vc_license_tab', true ) && ! vc_license()->isActivated() && is_admin() ) {
	
	// Remove purchase notice
	function earth_remove_vc_purchase_notice() {
		earth_remove_class_filter( 'admin_notices', 'Vc_License', 'adminNoticeLicenseActivation', 10 );
		earth_remove_class_filter( 'plugins_api', 'Vc_Updating_Manager', 'check_info', 10, 3 );
		earth_remove_class_filter( 'pre_set_site_transient_update_plugins', 'Vc_Updating_Manager', 'check_update', 10 );
		if ( function_exists( 'vc_plugin_name' ) ) {
			earth_remove_class_filter( 'in_plugin_update_message-' . vc_plugin_name(), 'Vc_Updating_Manager', 'addUpgradeMessageLink', 10 );
		}
	}
	add_action( 'admin_init',  'earth_remove_vc_purchase_notice', 20 );

	// Disable (hide) Template Library
	function earth_disable_vc_template_library( $data ) {
		foreach( $data as $key => $val ) {
			if ( isset( $val['category'] ) && 'shared_templates' == $val['category'] ) {
				unset( $data[$key] );
			}
		}
		return $data;
	}
	add_filter( 'vc_get_all_templates', 'earth_disable_vc_template_library', 99 );

	// Remove plugin license admin tab
	function earth_vc_remove_plugin_license_submenu_page(){
		remove_submenu_page( VC_PAGE_MAIN_SLUG, 'vc-updater' );
	}
	add_action( 'admin_menu', 'earth_vc_remove_plugin_license_submenu_page', 999 );

	// Remove plugin license tab
	function earth_vc_remove_plugin_license_tab() { ?>
		<script>
			( function( $ ) {

				"use strict";

				$( document ).on( 'ready', function() {

					var $vctabs = $( '.vc_settings .nav-tab' );

					$vctabs.each( function() {

						var href = $( this ).attr( 'href' );

						if ( href.indexOf( 'updater' ) > -1 ) {
							$( this ).hide();
						}

					} );

				} );

			} ) ( jQuery );
		</script>
	<?php }
	add_action( 'admin_footer-toplevel_page_vc-general', 'earth_vc_remove_plugin_license_tab' );
	add_action( 'admin_footer-visual-composer_page_vc-roles', 'earth_vc_remove_plugin_license_tab' );
	add_action( 'admin_footer-visual-composer_page_vc-automapper', 'earth_vc_remove_plugin_license_tab' );
	add_action( 'admin_footer-visual-composer_page_templatera', 'earth_vc_remove_plugin_license_tab' );
	add_action( 'admin_footer-visual-composer_page_vc-templatera', 'earth_vc_remove_plugin_license_tab' );

}

// Remove default templates
function earth_remove_default_vc_templates( $templates ) {
	return array();
}
add_filter( 'vc_load_default_templates', 'earth_remove_default_vc_templates' );

// Check if using the front-end composer
if ( ! function_exists( 'earth_is_front_end_composer' ) ) {
	function earth_is_front_end_composer() {
		if ( ! function_exists('vc_is_inline') ) {
			return false;
		} elseif ( vc_is_inline() ) {
			return true;
		} else{
			return false;
		}
	}
}

// Add new parameter types
if ( function_exists( 'vc_add_shortcode_param' ) ) {
	function earth_font_family_select( $settings, $value ) {
		$output = '<select name="'
				. $settings['param_name']
				. '" class="wpb_vc_param_value wpb-input wpb-select '
				. $settings['param_name']
				. ' ' . $settings['type'] .'">'
				. '<option value="" '. selected( $value, '', false ) .'>'. esc_html__( 'Default', 'earth' ) .'</option>';
		// Custom fonts
		if ( function_exists( 'earth_add_custom_fonts' ) ) {
			$fonts = earth_add_custom_fonts();
			if ( $fonts && is_array( $fonts ) ) {
				$output .= '<optgroup label="'. esc_html__( 'Custom Fonts', 'earth' ) .'">';
				foreach ( $fonts as $font ) {
					$output .= '<option value="'. esc_html( $font ) .'" '. selected( $value, $font, false ) .'>'. esc_html( $font ) .'</option>';
				}
				$output .= '</optgroup>';
			}
		}
		// Get Standard font options
		if ( $std_fonts = earth_standard_fonts() ) {
			$output .= '<optgroup label="'. esc_html__( 'Standard Fonts', 'earth' ) .'">';
				foreach ( $std_fonts as $font ) {
					$output .= '<option value="'. esc_html( $font ) .'" '. selected( $font, $value, false ) .'>'. esc_html( $font ) .'</option>';
				}
			$output .= '</optgroup>';
		}
		// Google font options
		if ( $google_fonts = earth_google_fonts_array() ) {
			$output .= '<optgroup label="'. esc_html__( 'Google Fonts', 'earth' ) .'">';
				foreach ( $google_fonts as $font ) {
					$output .= '<option value="'. esc_html( $font ) .'" '. selected( $font, $value ) .'>'. esc_html( $font ) .'</option>';
				}
			$output .= '</optgroup>';
		}
		$output .= '</select>';
		return $output;
	}
	vc_add_shortcode_param( 'earth_font_family_select', 'earth_font_family_select' );
}

// Load functions/files if the vc_map function exists
function earth_visual_composer_config() {

	// Inline styles
	require_once( EARTH_VC_DIR .'inline-style.php' );
	require_once( EARTH_VC_DIR .'sanitize-data.php' );

	// Remove VC Teaser metabox
	if ( is_admin() ) {
		function earth_remove_vc_boxes(){
			$post_types = get_post_types( '', 'names' );
			foreach ( $post_types as $post_type ) {
				remove_meta_box('vc_teaser',  $post_type, 'side');
			}
		}
		add_action( 'do_meta_boxes', 'earth_remove_vc_boxes' );
	}

	// Register scripts for the front-end editor
	function earth_vc_frontend_css() {

		wp_enqueue_style( 'earth-vc-css', EARTH_ASSETS_DIR_URI . 'css/vc.css' );

	}

	add_action( 'admin_enqueue_scripts', 'earth_vc_frontend_css' );

	// Load shortcode functions
	if ( function_exists( 'vc_lean_map' )  ) {

		require_once( EARTH_VC_DIR . 'shortcodes/heading.php' );
		require_once( EARTH_VC_DIR . 'shortcodes/leader.php' );
		require_once( EARTH_VC_DIR . 'shortcodes/blog.php' );
		require_once( EARTH_VC_DIR . 'shortcodes/blog-grid.php' );
		require_once( EARTH_VC_DIR . 'shortcodes/simple-galleries.php' );
		require_once( EARTH_VC_DIR . 'shortcodes/detailed-galleries.php' );
		require_once( EARTH_VC_DIR . 'shortcodes/image-grid.php' );
		require_once( EARTH_VC_DIR . 'shortcodes/spacing.php' );
		require_once( EARTH_VC_DIR . 'shortcodes/list.php' );
		require_once( EARTH_VC_DIR . 'shortcodes/buttons.php' );
		require_once( EARTH_VC_DIR . 'shortcodes/wpml.php' );

		if ( earth_get_option( 'events', true ) ) {
			require_once( EARTH_VC_DIR . 'shortcodes/events.php' );
			require_once( EARTH_VC_DIR . 'shortcodes/events-grid.php' );
		}

	}

}
add_action( 'init', 'earth_visual_composer_config' );

// Add color options
function earth_edit_vc_params() {

	// Tabs
	$param = WPBMap::getParam( 'vc_tta_tabs', 'color' );
	$param['std'] = 'earth';
	$param['value'][__( 'Earth', 'earth' )] = 'earth';
	vc_update_shortcode_param( 'vc_tta_tabs', $param );

	// Tours
	$param = WPBMap::getParam( 'vc_tta_tour', 'color' );
	$param['std'] = 'earth';
	$param['value'][__( 'Earth', 'earth' )] = 'earth';
	vc_update_shortcode_param( 'vc_tta_tour', $param );

	// Accordion
	$param = WPBMap::getParam( 'vc_tta_accordion', 'color' );
	$param['std'] = 'earth';
	$param['value'][__( 'Earth', 'earth' )] = 'earth';
	vc_update_shortcode_param( 'vc_tta_accordion', $param );

	// Button
	$param = WPBMap::getParam( 'vc_btn', 'color' );
	$param['std'] = 'earth';
	$param['value'][__( 'Earth', 'earth' )] = 'earth';
	vc_update_shortcode_param( 'vc_btn', $param );

}
add_action( 'vc_after_init', 'earth_edit_vc_params' );

// Inline js for grids
if ( ! function_exists( 'vc_front_end_inline_isotope_js' ) ) {
	function vc_front_end_inline_isotope_js( $style = '' ) {
		if ( ! earth_is_front_end_composer() ) return; ?>
		<script type="text/javascript">
			(function($) {
				"use strict";
					function wpexFilterGalleries() {
						if ( $('.isotope-grid').length ) {
							$('.isotope-grid').each( function () {
								// Initialize isotope
								var $container = $(this);
								$container.isotope({
									itemSelector: '.isotope-entry'
								});
								// Isotope filter links
								var $filter = $container.prev('.galleries-filter');
								var $filterLinks = $filter.find('a');
								$filterLinks.each( function() {
									var $filterableDiv = $(this).data('filter');
									if ( $filterableDiv !== '*' && ! $container.find($filterableDiv).length ) {
										$(this).parent().hide('100');
									}
								});
								$filterLinks.css({ opacity: 1 } );
								$filterLinks.click(function(){
								var selector = $(this).attr('data-filter');
									$container.isotope({
										filter: selector
									});
									$(this).parents('ul').find('li').removeClass('active');
									$(this).parent('li').addClass('active');
								return false;
								});
							});
						}
					}

					if ( $.fn.imagesLoaded ) {
						$( '#wrapper' ).imagesLoaded(function(){
							wpexFilterGalleries();
						});
					}

					// Run or re-run functions on resize and orientation change
					var isIE8 = $.browser.msie && +$.browser.version === 8;
					if (isIE8) {
						document.body.onresize = function () {
							wpexFilterGalleries();
						};
					} else {
						$(window).resize(function () {
							wpexFilterGalleries();
						});
						window.addEventListener("orientationchange", function() {
							wpexFilterGalleries();
						});
					}
			})(jQuery);
		</script>
	<?php }
}

// Array of image crop settings
function earth_vc_image_crop_options() {
	return array(
		__( 'Default', 'earth' ) => '',
		__( 'Top Left', 'earth' ) => 'left-top',
		__( 'Top Right', 'earth' ) => 'right-top',
		__( 'Top Center', 'earth' ) => 'center-top',
		__( 'Center Left', 'earth' ) => 'left-center',
		__( 'Center Right', 'earth' ) => 'right-center',
		__( 'Center Center', 'earth' ) => 'center-center',
		__( 'Bottom Left', 'earth' ) => 'left-bottom',
		__( 'Bottom Right', 'earth' ) => 'right-bottom',
		__( 'Bottom Center', 'earth' ) => 'center-bottom',
	);
}