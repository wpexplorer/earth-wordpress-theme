<?php
/**
 * Image Slider
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get slides
$slides = new WP_Query( array(
	'post_type'   =>'slides',
	'numberposts' => -1,
	'order'       => 'ASC',
	'tax_query'   => array( array(
		'taxonomy' => 'img_sliders',
		'field'    => 'id',
		'terms'    => get_post_meta( get_the_ID(), 'earth_img_slider_cat', true )
	) ),
	'no_found_rows' => true,
) );

// Display posts
if ( $slides->have_posts() ) :
	
	// Load slider scripts
	//wp_deregister_script( 'flexslider' ); // fix bug with 3rd party plugins
	wp_enqueue_script(
		'flexslider',
		EARTH_ASSETS_DIR_URI . 'js/flexslider.js',
		array( 'jquery' ),
		'2.0',
		true
	);

	wp_enqueue_script(
		'wpex-slider-init',
		EARTH_ASSETS_DIR_URI . 'js/slider-init.js',
		array( 'jquery', 'flexslider' ),
		'1.0',
		true
	);
	
	// Vars
	$wpex_slideshow = ( earth_get_option('slider_slideshow', '1') == 1 ) ? 'true' : 'false';
	$wpex_slider_randomize = ( earth_get_option('slider_randomize', '1') == 1 ) ? 'true' : 'false';
	
	// Set slider options
	$flex_params = array(
		'slideshow'      => $wpex_slideshow,
		'randomize'      => $wpex_slider_randomize ,		
		'animation'      => earth_get_option('slider_animation','slide'),
		'direction'      => earth_get_option('slider_direction','horizontal'),
		'slideshowSpeed' => earth_get_option('slider_slideshow_speed','7000')
	);
	
	// Localize slider script
	wp_localize_script( 'wpex-slider-init', 'flexLocalize', $flex_params ); ?>

	<div id="slider-wrap" class="slides-loading et-fitvids flex-container clr">

		<div id="slider" class="flexslider">

			<ul class="slides">
				<?php
				// Slider height crop
				$earth_slide_crop = earth_get_option( 'slider_height' ) ? true : false;
				
				//start loop
				while ( $slides->have_posts() ) : $slides->the_post(); ?>
				
					<li class="flex-slide">

						<?php
						// Video slide
						if ( get_post_meta( get_the_ID(), 'earth_slides_video', true )
							|| get_post_meta( get_the_ID(), 'earth_slides_video_oembed', true )
						) : ?>
														
							<div class="single_slide video-slide responsive-embed-wrap">
								<?php if ( $video = get_post_meta( get_the_ID(), 'earth_slides_video_oembed', true ) ) { ?>
									<?php echo wp_oembed_get( esc_url( $video ) ); ?>
								<?php } else { ?>
									<?php echo do_shortcode( get_post_meta( get_the_ID(), 'earth_slides_video', true ) ); ?>
								<?php } ?>
							</div>
							
						<?php

						// Image slide
						elseif ( has_post_thumbnail() ) : ?>

							<div class="single_slide">
								<?php if ( $url = get_post_meta(get_the_ID(), 'earth_slides_url', true ) ) { ?>
									<a href="<?php echo esc_url( $url ); ?>" title="<?php earth_esc_title(); ?>" target="_<?php echo get_post_meta( get_the_ID(), 'earth_slides_url_target', true); ?>">
										<?php echo earth_get_post_thumbnail( 'slider' ); ?>
									</a>
								<?php } else { ?> 
									<?php echo earth_get_post_thumbnail( 'slider' ); ?>
								<?php } ?>
								<?php if ( $caption = get_post_meta(get_the_ID(), 'earth_slides_description', true ) ) { ?>
									<div class="caption"><?php echo apply_filters( 'the_content', $caption ); ?></div>
								<?php } ?>
							</div>

						<?php endif; ?>

					</li>
				
				<?php endwhile; ?>
			</ul>

		</div>

	</div>
	
<?php endif; wp_reset_postdata(); ?>