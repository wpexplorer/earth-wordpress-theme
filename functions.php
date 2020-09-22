<?php
/**
 *  Functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4.1
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*--------------------------------------*/
/* Define Constants
/*--------------------------------------*/
define( 'EARTH_THEME_VERSION', '4.4.1' );
define( 'EARTH_ASSETS_DIR_URI', get_template_directory_uri() . '/assets/' );
define( 'EARTH_INC_DIR', get_template_directory() . '/inc/' );
define( 'EARTH_INC_DIR_URI', get_template_directory_uri() . '/inc/' );
define( 'ADMIN_PATH', EARTH_INC_DIR . 'theme-panel/' );
define( 'ADMIN_DIR', EARTH_INC_DIR_URI . 'theme-panel/' );

/*--------------------------------------*/
/* Theme Setup & Core functions
/*--------------------------------------*/
require_once EARTH_INC_DIR . 'deprecated.php';
require_once EARTH_INC_DIR . 'globals.php';
require_once EARTH_INC_DIR . 'core.php';
require_once EARTH_INC_DIR . 'updates.php';
require_once EARTH_INC_DIR . 'fonts.php';
require_once EARTH_INC_DIR . 'styling.php';
require_once EARTH_INC_DIR . 'image-resizer.php';

/*--------------------------------------*/
/* Libraries
/*--------------------------------------*/
require_once EARTH_INC_DIR . 'lib/wpex-post-metabox/class.php';
require_once EARTH_INC_DIR . 'lib/wpex-gallery-metabox/init.php';

/*--------------------------------------*/
/* Include functions
/*--------------------------------------*/
require_once EARTH_INC_DIR . 'post-thumbnails.php';
require_once EARTH_INC_DIR . 'excerpts.php';
require_once EARTH_INC_DIR . 'tinymce.php';
require_once EARTH_INC_DIR . 'cpt/types.php';
require_once EARTH_INC_DIR . 'cpt/taxonomies.php';
require_once EARTH_INC_DIR . 'event-helpers.php';
require_once EARTH_INC_DIR . 'social.php';
require_once EARTH_INC_DIR . 'font-awesome.php';
require_once EARTH_INC_DIR . 'calendar.php';
require_once EARTH_INC_DIR . 'custom-css.php';
require_once EARTH_INC_DIR . 'shortcodes.php';
require_once EARTH_INC_DIR . 'pagination.php';
require_once EARTH_INC_DIR . 'page-slider.php';
require_once EARTH_INC_DIR . 'page-oembed.php';
require_once EARTH_INC_DIR . 'social-output.php';
require_once EARTH_INC_DIR . 'custom-fonts.php';

// Custom widgets
require_once EARTH_INC_DIR . 'widgets/widget-areas.php';
require_once EARTH_INC_DIR . 'widgets/recent-posts.php';
require_once EARTH_INC_DIR . 'widgets/flickr-widget.php';
require_once EARTH_INC_DIR . 'widgets/recent-gallery.php';
require_once EARTH_INC_DIR . 'widgets/featured-events.php';

/*--------------------------------------*/
/* Configs
/*-------------------------------------*/
require_once EARTH_INC_DIR . 'config/theme-setup.php';
require_once EARTH_INC_DIR . 'config/core-image-sizes.php';
require_once EARTH_INC_DIR . 'config/enqueue-scripts.php';
require_once EARTH_INC_DIR . 'config/post-metabox.php';
require_once EARTH_INC_DIR . 'config/gallery-metabox.php';
require_once EARTH_INC_DIR . 'config/tagcloud.php';
require_once EARTH_INC_DIR . 'config/oembed.php';
require_once EARTH_INC_DIR . 'config/move-comment-form-fields.php';
require_once EARTH_INC_DIR . 'config/editor-columns.php';
require_once EARTH_INC_DIR . 'config/comments.php';
require_once EARTH_INC_DIR . 'config/login-logo.php';
require_once EARTH_INC_DIR . 'config/body-classes.php';
require_once EARTH_INC_DIR . 'config/posts-per-page.php';
require_once EARTH_INC_DIR . 'config/layerslider.php';

/*--------------------------------------*/
/* Include SMOF Admin Panel
/*--------------------------------------*/
require_once EARTH_INC_DIR . 'theme-panel/helpers.php';
require_once EARTH_INC_DIR . 'theme-panel/index.php';

/*--------------------------------------*/
/* 3rd Party Integration
/*--------------------------------------*/

// Visual Composer
if ( class_exists( 'Vc_Manager' ) ) {
	require_once EARTH_INC_DIR . 'vc/extend.php';
}

// WooCommerce
if ( class_exists( 'WooCommerce' ) ) {
	require_once EARTH_INC_DIR . 'config/woocommerce.php';
}