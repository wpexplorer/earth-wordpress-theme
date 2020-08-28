<?php
/**
 * Template Name: Homepage
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Get homepage layout blocks
global $data;
$layout = $data['homepage_blocks']['enabled'];

if ( $layout ) : ?>

	<div id="home-wrap" class="clr">

		<?php
		// Loop through layout blocks and get correct partial file
		foreach ( $layout as $key=>$value ) :

			switch( $key ) {
			
				case 'home_highlights' :
					earth_get_template_part( 'home/highlights', 'includes/home/highlights' );
				break;
				
				case 'home_blog_events' :
					echo '<div class="home-events-blog et-row et-gap-30 clr">';
						earth_get_template_part( 'home/events', 'includes/home/events' );
						earth_get_template_part( 'home/blog', 'includes/home/blog' );
					echo '</div>';
				break;
				
				case 'home_events' :
					earth_get_template_part( 'home/events-full', 'includes/home/events-full' );
				break;
				
				case 'home_blog' :
					earth_get_template_part( 'home/blog-full', 'includes/home/blog-full' );
				break;

				case 'home_gallery' :
					earth_get_template_part( 'home/gallery', 'includes/home/gallery' );
				break;
				
				case 'home_gallery_single' :
					earth_get_template_part( 'home/gallery-single', 'includes/home/gallery-single' );
				break;
				
				case 'home_static_page' :
					earth_get_template_part( 'home/static-page', 'includes/home/static-page' );
				break;

			}

		endforeach; ?>

	</div><!-- #home-wrap -->

<?php endif; ?>

<?php get_footer(); ?>
