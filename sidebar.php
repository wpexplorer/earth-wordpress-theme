<?php
/**
 * Sidebar template
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

// Not needed for full-width layout
if ( 'full-width' == earth_get_post_layout() ) {
	return;
} ?>

<aside id="sidebar"><?php dynamic_sidebar( earth_get_sidebar() ); ?></aside>