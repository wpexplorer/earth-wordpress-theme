<?php
/**
 * Resize images dinamically
 *
 *
 * @param  string $attach_id
 * @param  string $dims
 * @return array
 * @since  1.0
 *
 * @todo See if we should update to use image_make_intermediate_size
 */
function earth_resize_thumbnail( $attach_id = '', $width = '', $height = '', $crop = '', $retina = false ) {

	// Check if retina support is enabled
	$retina_support = earth_get_option( 'retina', false );

	// Sanitize dims
	$width  = intval( $width );
	$height = intval( $height );
	$crop   = esc_html( $crop );

	// If width or height are empty set them to a large integer
	$width  = $width ? $width : 9999;
	$height = $height ? $height : 9999;

	// Get attachment data
	$src  = wp_get_attachment_image_src( $attach_id, 'full' );
	$path = get_attached_file( $attach_id );

	// Can't locate image so return
	if ( empty( $path ) ) {
		return;
	}

	// Set crop to false if width or height are very large
	if ( $height >= 9999 || $width >= 9999  ) {
		$crop = false;
	}

	// If crop dims aren't defined set to true (aka center-center)
	elseif ( ! $crop ) {
		$crop = true;
	}

	// Get attachment details
	$meta         = wp_get_attachment_metadata( $attach_id );
	$info         = pathinfo( $path );
	$extension    = '.' . $info['extension'];
	$path_no_ext  = $info['dirname'] . '/' . $info['filename'];
	$crop_array   = ( $crop && ! is_array( $crop ) ) ? explode( '-', $crop ) : '';
	$cropped_dims = image_resize_dimensions( $src[1], $src[2], $width, $height, $crop_array );

	// Target image size dims
	$dst_w = isset( $cropped_dims[4] ) ? $cropped_dims[4] : '';
	$dst_h = isset( $cropped_dims[5] ) ? $cropped_dims[5] : '';

	// If current image size is smaller or equal to target size return full image
	if ( empty( $cropped_dims ) || $dst_w > $src[1] || $dst_h > $src[2] ) {
		
		if ( $retina ) {
			return;
		}

		return array(
			'url'    => $src[0],
			'width'  => $src[1],
			'height' => $src[2],
		);

	}

	// Retina can't be cropped to exactly 2x
	if ( $retina && ( $dst_w !== $width || $dst_h !== $height ) ) {
		return;
	}

	// Array of valid crop locations
	$crop_locations = array(
		'left-top',
		'right-top',
		'center-top',
		'left-center',
		'right-center',
		'center-center',
		'left-bottom',
		'right-bottom',
		'center-bottom',
	);

	// Define crop suffix if custom crop is set
	$crop_suffix = ( ! is_bool( $crop ) && in_array( $crop, $crop_locations ) ) ? $crop : '';

	// Define suffix
	if ( $retina ) {
		$suffix = $width / 2 . 'x' . $height / 2; // Use original sizes for naming
	} else {
		$suffix = $dst_w . 'x' . $dst_h;
	}
	$suffix = $crop_suffix ? $suffix . '-' . $crop_suffix : $suffix;
	$suffix = $retina ? $suffix . '@2x' : $suffix;

	// Get cropped path
	$cropped_path = $path_no_ext . '-' . $suffix . $extension;

	// Return chached image
	// And try and generate retina if not created already
	if ( file_exists( $cropped_path ) ) {

		$new_path = str_replace( basename( $src[0] ), basename( $cropped_path ), $src[0] );

		if ( ! $retina && $retina_support ) {
			$retina_src = earth_resize_thumbnail( $attach_id, $dst_w*2, $dst_h*2, $crop, true );
		}

		return array(
			'url'    => $new_path,
			'width'  => $dst_w,
			'height' => $dst_h,
			'retina' => ! empty( $retina_src['url'] ) ? $retina_src['url'] : '',
		);

	}

	// Define intermediate size name
	$int_size = 'earth_' . $suffix;

	// Crop image
	$editor = wp_get_image_editor( $path );

	if ( ! is_wp_error( $editor ) && ! is_wp_error( $editor->resize( $width, $height, $crop_array ) ) ) {

		// Get resized file
		$new_path = $editor->generate_filename( $suffix );
		$editor   = $editor->save( $new_path );

		// Set new image url from resized image
		if ( ! is_wp_error( $editor ) ) {

			// Cropped image
			$cropped_img = str_replace( basename( $src[0] ), basename( $new_path ), $src[0] );

			// Generate retina version
			if ( ! $retina && $retina_support ) {
				$retina_src = earth_resize_thumbnail( $attach_id, $dst_w*2, $dst_h*2, $crop, true );
			}

			// Update meta
			if ( is_array( $meta ) ) {

				$meta['sizes'] = isset( $meta['sizes'] ) ? $meta['sizes'] : array();

				if ( ! array_key_exists( $int_size, $meta['sizes'] )
					|| ( $dst_w != $meta['sizes'][$int_size]['width'] || $dst_h != $meta['sizes'][$int_size]['height'] )
				) {

					// Check correct mime type
					$mime_type = wp_check_filetype( $cropped_img );
					$mime_type = isset( $mime_type['type'] ) ? $mime_type['type'] : '';

					// Add cropped image to image meta
					$meta['sizes'][$int_size] = array(
						'file'      => $new_path,
						'width'     => $dst_w,
						'height'    => $dst_h,
						'mime-type' => $mime_type,
						'earth-img' => true,
					);

					// Update meta
					wp_update_attachment_metadata( $attach_id, $meta );

				}

			}

			// Return cropped image
			return array(
				'url'    => $cropped_img,
				'width'  => $dst_w,
				'height' => $dst_h,
				'retina' => ! empty( $retina_src['url'] ) ? $retina_src['url'] : '',
			);

		}

	}

	// Couldn't dynamically create image so return original
	else {

		return array(
			'url'    => $src[0],
			'width'  => $src[1],
			'height' => $src[2],
		);

	}

}

// Deprecated
function aq_resize() {
	_deprecated_function( 'aq_resize', '4.0', 'earth_resize_thumbnail' );
}