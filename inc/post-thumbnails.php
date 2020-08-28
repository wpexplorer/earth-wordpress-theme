<?php
/**
 * Post Thumbnails
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

function earth_get_post_thumbnail( $size = '', $attr = array() ) {

	$attachment_id = get_post_thumbnail_id();

	if ( ! $attachment_id ) {
		return;
	}

	$dims = array(
		'width'  => 9999,
		'height' => 9999,
		'crop'   => true,
	);

	// Loop through image sizes to get correct dimensions
	if ( is_array( $size ) ) {

		$dims = $size;

	} elseif ( 'page' == $size ) {

		$dims = array(
			'width'  => 940,
			'height' => 9999,
			'crop'   => false,
		);

	} elseif ( 'search' == $size ) {

		$dims = array(
			'width'  => 120,
			'height' => 100,
			'crop'   => true,
		);

	} elseif ( 'slider' == $size ) {

		$width  = earth_get_option( 'slider_width', 940 );
		$height = earth_get_option( 'slider_height', 9999 );
		$crop   = earth_get_option( 'slider_crop', false );
		$crop   = $height == 9999 ? false : $crop;

		$dims = array(
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop,
		);

	} elseif ( 'post' == $size ) {

		$width  = earth_get_option( 'post_thumb_width', 620 );
		$height = earth_get_option( 'post_thumb_height', 9999 );
		$crop   = earth_get_option( 'post_thumb_crop', false );
		$crop   = $height == 9999 ? false : $crop;

		$dims = array(
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop,
		);

		$dims = array(
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop,
		);

	} elseif ( 'entry' == $size ) {

		$width  = earth_get_option( 'entry_thumb_width', 620 );
		$height = earth_get_option( 'entry_thumb_height', 9999 );
		$crop   = earth_get_option( 'entry_thumb_crop', false );
		$crop   = $height == 9999 ? false : $crop;

		$dims = array(
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop,
		);

	} elseif( 'standard_post_related' == $size ) {

		$dims = array(
			'width'  => 120,
			'height' => 100,
			'crop'   => true,
		);

	} elseif ( 'single_event' == $size ) {

		$width  = earth_get_option( 'event_thumb_width', 620 );
		$height = earth_get_option( 'event_thumb_height', 9999 );
		$crop   = earth_get_option( 'event_thumb_crop', true );
		$crop   = $height == '9999' ? false : $crop;

		$dims = array(
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop,
		);

	} elseif ( 'gallery_entry' == $size ) {

		$width  = earth_get_option( 'gallery_entry_thumb_width', 210 );
		$height = earth_get_option( 'gallery_entry_thumb_height', 170 );
		$crop   = earth_get_option( 'gallery_entry_thumb_crop', true );
		$crop   = $height == '9999' ? false : $crop;

		$dims = array(
			'width'  => $width,
			'height' => $height,
			'crop'   => $crop,
		);

	}

	if ( ! is_array( $size ) ) {

		$dims = apply_filters( 'earth_get_thumbnail_dims', $dims, $size );

	}

	$cropped_img = earth_resize_thumbnail( $attachment_id, $dims['width'], $dims['height'], $dims['crop'] );

	if ( empty( $cropped_img ) ) {
		return;
	}

 	$default_attr = array(
		'src'    => $cropped_img['url'],
		'height' => $cropped_img['height'],
		'width'  => $cropped_img['width'],
		'alt'    => earth_get_esc_title(),
    );

	$attr = wp_parse_args( $attr, $default_attr );

	if ( ! empty( $cropped_img['retina'] ) ) {
		$attr['data-at2x'] = $cropped_img['retina'];
	}

	$attr = array_map( 'esc_attr', $attr );
    $html = '<img';
	foreach ( $attr as $name => $value ) {
		$html .= " $name=" . '"' . $value . '"';
	}
	$html .= ' />';
	
	return apply_filters( 'earth_get_thumbnail', $html, $size );

}

function earth_get_attachment_thumbnail( $attachment, $dims = '' ) {

	$dims = wp_parse_args( $dims, array(
		'width'  => 9999,
		'height' => 9999,
		'crop'   => true,
	) );

	$cropped_img = earth_resize_thumbnail( $attachment, $dims['width'], $dims['height'], $dims['crop'] );

	if ( empty( $cropped_img ) ) {
		return;
	}

	$alt = get_post_meta( $attachment, '_wp_attachment_image_alt', true );
	$alt = $alt ? $alt : get_the_title( $attachment );

	$attr = array(
		'src'    => $cropped_img['url'],
		'height' => $cropped_img['height'],
		'width'  => $cropped_img['width'],
		'alt'    => $alt,
    );

    if ( ! empty( $cropped_img['retina'] ) ) {
		$attr['data-at2x'] = $cropped_img['retina'];
	}

    $attr = array_map( 'esc_attr', $attr );
    $html = '<img';
	foreach ( $attr as $name => $value ) {
		$html .= " $name=" . '"' . $value . '"';
	}
	$html .= ' />';
	
	return $html;

}