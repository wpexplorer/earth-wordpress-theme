<?php
// Register Shortcode
if ( ! function_exists( 'image_grid_shortcode' ) ) {

	function image_grid_shortcode($atts) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
				'unique_id' => '',
				'columns' => '4',
				'image_ids' => '',
				'thumbnail_link' => 'lightbox',
				'custom_links' => '',
				'custom_links_target' => '_self',
				'img_width' => '9999',
				'img_height' => '9999',
				'img_crop' => '',
				'title' => 'true',
			), $atts ) );
			
		if ( empty($image_ids) ) {
			return '<p>'. esc_html__( 'Please select your images for your grid', 'earth' ) .'</p>';
		}
			
		$output = '';
		
		// Get Attachments
		$images = explode(",",$image_ids);
		$images = array_combine($images,$images);
		
		// Custom Links
		if ( $thumbnail_link == 'custom_link' ) {
			$custom_links = explode( ',', $custom_links);
		}

		//Output posts
		if ( $images ) :

			// Grid wrap classes
			$wrap_classes = 'image-grid clr et-row';
			$wrap_classes .=' cols-'. $columns;

			// Lightbox Class
			if ( 'lightbox' == $thumbnail_link ) {
				$wrap_classes .= ' earth-lightbox-gallery';
			}
		
			// Main wrapper div
			$output .= '<div class="'. $wrap_classes .'" id="'. $unique_id .'">';
				
				$count=0;
				// Loop through images
				$count2=-1;
				foreach ( $images as $attachment ) :
					
					// Load scripts
					if ( 'lightbox' == $thumbnail_link ) {
						wp_enqueue_script( 'vcex-magnific-popup' );
						wp_enqueue_script( 'vcex-lightbox' );
					}

					// Sanitize image crop
					$img_crop = ( $img_height == 9999 && ! $img_crop ) ? false : $img_crop;
					
					// Crop featured images if necessary
					$img_src = earth_resize_thumbnail( $attachment, $img_width, $img_height, $img_crop );
					
					// Image needed
					if ( empty( $img_src['url'] ) ) {
						continue;
					}

					// Get image meta data
					$attachment_img_url = wp_get_attachment_url( $attachment );
					$attachment_img     = wp_get_attachment_url( $attachment );
					$attachment_alt     = strip_tags( get_post_meta($attachment, '_wp_attachment_image_alt', true) );
					$attachment_title   = get_the_title( $attachment );
					$attachment_caption = get_post_field( 'post_excerpt', $attachment );

					// Add to counter
					$count++;
					$count2++;

					// Output image
					$img_attr = array(
						'src'    => $img_src['url'],
						'alt'    => esc_attr( $attachment_alt ),
						'width'  => $img_src['width'],
						'height' => $img_src['height'],
					);
					if ( ! empty( $img_src['retina'] ) ) {
						$img_attr['data-at2x'] = $img_src['retina'];
					}

				    $image_output = '<img';
					foreach ( $img_attr as $name => $value ) {
						$image_output .= " $name=" . '"' . $value . '"';
					}
					$image_output .= ' />';
		
					// Slide item start
					$output .= '<article class="image-grid-entry et-col et-col-'. $count .' span_1_of_'. $columns .'">';

							$output .= '<div class="image-grid-entry-img">';
							
								if ( 'lightbox' == $thumbnail_link ) {
									$output .= '<a href="'. esc_url( $attachment_img_url ) .'" title="'. esc_attr( $attachment_caption ) .'" class="image-grid-entry-img styled-img">';
										$output .= $image_output;
										$output .='<div class="img-overlay"><span class="fa fa-search"></span></div>';
									$output .= '</a><!-- .image-grid-entry-img -->';
								} elseif ( 'custom_link' == $thumbnail_link ) {
									$custom_link = !empty($custom_links[$count2]) ? $custom_links[$count2] : '#';
									if ( '#' == $custom_link ) {
										$output .= $image_output;
									} else {
										$output .= '<a href="'. esc_url( $custom_link ) .'" title="'. esc_attr( $attachment_caption ) .'" class="image-grid-entry-img styled-img" target="'. $custom_links_target .'">';
											$output .= $image_output;
											$output .='<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>';
										$output .= '</a>';
									}
								} else {
									$output .= $image_output;
								}
								
								if ( $title == 'yes' && $attachment_title ) {
									$output .= '<div class="image-grid-entry-title">'. $attachment_title .'</div>';
								}
								
							$output .= '</div>';
						
					// Close main wrap
					$output .= '</article>';
					
					if ( $count == $columns ) {
						$count = 0;
					}
				
				// End foreach loop
				endforeach;
			
			// Close main wrap
			$output .= '</div>';
		
		endif; // End has posts check
		
		// Reset query
		wp_reset_postdata();

		// Return data
		return $output;
		
	}
}
add_shortcode("image_grid", "image_grid_shortcode");

// Map to VC
if ( ! function_exists( 'image_grid_shortcode_vc_map' ) ) {
	function image_grid_shortcode_vc_map() {
		return array(
			"name" => esc_html__( "Image Grid", 'earth' ),
			"description" => esc_html__( "Responsive image gallery", 'earth' ),
			"base" => "image_grid",
			"icon" => "earth-vc-icon fa fa-picture-o",
			'category' => "Earth",
			"params" => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( "Unique Id", 'earth' ),
					'param_name' => "unique_id",
					'value' => '',
				),
				array(
					'type' => "attach_images",
					"admin_label" => true,
					'heading' => esc_html__( "Attach Images", 'earth' ),
					'param_name' => "image_ids",
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( "Columns", 'earth' ),
					'param_name' => "columns",
					'std' => '4',
					'value' => array(
						'6' => '6',
						'5' => '5',
						'4' => '4',
						'3' => '3',
						'2' => '2',
						'1' => '1',
					),
					'group' => esc_html__( 'Design', 'earth' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( "Display Title", 'earth' ),
					'param_name' => "title",
					'value' => array(
						esc_html__( 'No', 'earth' ) => '',
						esc_html__( 'Yes', 'earth' ) => 'yes'
					),
					'group'		=> esc_html__( 'Design', 'earth' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( "Image Link", 'earth' ),
					'param_name' => "thumbnail_link",
					'value' => array(
						esc_html__( 'None', 'earth' ) => "none",
						esc_html__( 'Lightbox', 'earth' ) => "lightbox",
						esc_html__( 'Custom Links', 'earth' ) => "custom_link",
					),
					'group' => esc_html__( 'Links', 'earth' ),
				),
				array(
					'type' => "exploded_textarea",
					'heading' => esc_html__("Custom links", 'earth' ),
					'param_name' => "custom_links",
					"description" => esc_html__( 'Enter links for each slide here. Divide links with linebreaks (Enter). For images without a link enter a # symbol. And don\'t forget to include the http:// at the front.', 'earth' ),
					"dependency" => array(
						'element' => "thumbnail_link",
						'value' => array( 'custom_link' )
					),
					'group' => esc_html__( 'Links', 'earth' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__("Custom link target", 'earth' ),
					'param_name' => "custom_links_target",
					"dependency" => array(
						'element' => "thumbnail_link",
						'value' => array( 'custom_link' )
					),
					'value' => array(
						esc_html__("Same window", 'earth' )	=> "_self",
						esc_html__("New window", 'earth' )	=> "_blank"
					),
					'group' => esc_html__( 'Links', 'earth' ),
				),
				array(
					'type' => 'textfield',
					'class' => '',
					'heading' => esc_html__( 'Image Width', 'earth' ),
					'param_name' => 'img_width',
					'value' => '9999',
					'group' => esc_html__( 'Image', 'earth' ),
				),
				array(
					'type' => 'textfield',
					'class' => '',
					'heading' => esc_html__( 'Image Height', 'earth' ),
					'param_name' => 'img_height',
					'value' => '9999',
					'group' => esc_html__( 'Image', 'earth' ),
				),
				array(
					'type' => 'dropdown',
					'class' => '',
					'heading' => esc_html__( 'Image Crop', 'earth' ),
					'param_name' => 'img_crop',
					'group' => esc_html__( 'Image', 'earth' ),
					'value' => earth_vc_image_crop_options(),
				),
			)
		);
	}
}
vc_lean_map( 'image_grid', 'image_grid_shortcode_vc_map' );