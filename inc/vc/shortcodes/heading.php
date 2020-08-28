<?php
// Heading Shortcode
if ( !function_exists( 'heading_shortcode' ) ) {
	function heading_shortcode($atts) {
		extract( shortcode_atts( array(
				'unique_id'		=> '',
				'heading'		=> 'Sample Heading',
				'link'			=> '',
				'element'		=> 'h2',
				'margin_bottom'	=> '20px',
				'text_align'	=> 'left',
				'font_size'     => '',
		), $atts));

		// Link
		if ( $link ) {
			$link = ( $link == '||' ) ? '' : $link;
			$link = vc_build_link( $link );
			$a_href = esc_url($link['url']);
			$a_title = $link['title'];
			$a_target = $link['target'];
		}

		// Inline CSS
		$inline_style = earth_inline_style( array(
			'font_size'     => $font_size,
			'margin_bottom' => $margin_bottom,
		) );

		// Return heading
		$output = '<'. $element .' class="heading text-align-'. $text_align .'"'. $inline_style .'>';
		if ( $link ) {
			$output .= '<a href="'. $a_href .'" title="'. $a_title .'" target="'.$a_target .'">'. $heading .'</a>';
		} else {
			$output .= $heading;
		}
		$output .= '</'. $element .'>';
		return $output;
	}
}
add_shortcode( "heading", "heading_shortcode" );

// Add to Visual Composer
if ( ! function_exists( 'heading_vcmap' ) ) {
	function heading_vcmap() {
		return array(
			"name"					=> esc_html__( "Heading", 'earth' ),
			'description'			=> esc_html__( "Standard theme heading.", 'earth' ),
			"base"					=> "heading",
			'category'				=> "Earth",
			"icon"					=> "earth-vc-icon fa fa-font",
			"params"		=> array(
				array(
					'type'			=> 'textfield',
					"heading"		=> esc_html__( "Unique Id", 'earth' ),
					'param_name'	=> "unique_id",
					'value'			=> '',
				),
				array(
					'type'			=> 'textfield',
					"heading"		=> esc_html__( "Heading Text", 'earth' ),
					'param_name'	=> "heading",
					'value'			=> esc_html__( 'Your Heading', 'earth' ),
				),
				array(
					'type'			=> 'textfield',
					"heading"		=> esc_html__( "Font Size", 'earth' ),
					'param_name'	=> "font_size",
				),
				array(
					'type'			=> 'textfield',
					"heading"		=> esc_html__( 'Bottom Margin', 'earth' ),
					'param_name'	=> "margin_bottom",
					'value'			=> '20px',
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> esc_html__( 'Text Align', 'earth' ),
					'param_name'	=> 'text_align',
					'value'			=> array(
						esc_html__( 'Left', 'earth' )	=> 'left',
						esc_html__( 'Center', 'earth' )	=> 'center',
						esc_html__( 'Right', 'earth' )	=> 'right',
					),
				),
				array(
					'type'			=> 'vc_link',
					'heading'		=> esc_html__( 'URL (Link)', 'earth' ),
					'param_name'	=> 'link',
				),
			)
		);
	}
}
vc_lean_map( 'heading', 'heading_vcmap' );