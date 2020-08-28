<?php
/**
 * Visual Composer Leader
 */

if ( ! class_exists( 'Earth_Leader_Shortcode' ) ) {

	class Earth_Leader_Shortcode {

		/**
		 * Main constructor
		 *
		 * @since 3.5.0
		 */
		public function __construct() {
			
			// Add shortcode
			add_shortcode( 'css_leader', array( 'Earth_Leader_Shortcode', 'output' ) );

			// Map to VC
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'css_leader', array( 'Earth_Leader_Shortcode', 'map' ) );
			}

		}

		/**
		 * Shortcode output => Get template file and display shortcode
		 *
		 * @since 3.5.0
		 */
		public static function output( $atts, $content = null ) {

			// Not needed in admin ever
			if ( is_admin() ) {
				return;
			}

			// Required VC functions
			if ( ! function_exists( 'vc_map_get_attributes' ) || ! function_exists( 'vc_param_group_parse_atts' ) ) {
				vcex_function_needed_notice();
				return;
			}

			// Get and extract shortcode attributes
			extract( vc_map_get_attributes( 'css_leader', $atts ) );

			$leaders = (array) vc_param_group_parse_atts( $leaders );

			if ( $leaders ) {

				$inline_style = earth_inline_style( array(
					'color'      => $color,
					'font_size'  => $font_size,
				) );

				$output = '<ul class="css-leader css-leader-'. $style .' clearfix"'. $inline_style .'>';

				$label_typo = earth_inline_style( array(
					'color'       => $label_color,
					'font_weight' => $label_font_weight,
					'font_style'  => $label_font_style,
					'font_family' => $label_font_family,
					'background'  => $background,
				) );

				if ( $label_font_family ) {
					earth_enqueue_google_font( $label_font_family );
				}

				$value_typo = earth_inline_style( array(
					'color'       => $value_color,
					'font_weight' => $value_font_weight,
					'font_style'  => $value_font_style,
					'font_family' => $value_font_family,
					'background'  => $background,
				) );

				if ( $value_font_family ) {
					earth_enqueue_google_font( $value_font_family );
				}

				foreach ( $leaders as $leader ) {

					$label = isset( $leader['label'] ) ? $leader['label'] : esc_html__( 'Label', 'earth' );
					$value = isset( $leader['value'] ) ? $leader['value'] : esc_html__( 'Value', 'earth' );

					$output .= '<li>';
						$output .= '<span class="css-leader-first"'. $label_typo .'>'. esc_html( $label ) .'</span>';
						$output .= '<span class="css-leader-last"'. $value_typo .'>'. esc_html( $value ) .'</span>';
					$output .= '</li>';

				}

				$output .= '</ul>';

				return $output;

			}

		}

		/**
		 * Map shortcode to VC
		 *
		 * @since 3.5.0
		 */
		public static function map() {
			$font_weights = array(
				''         => esc_html__( 'Default', 'earth' ),
				'normal'   => esc_html__( 'Normal', 'earth' ),
				'semibold' => esc_html__( 'Semibold','earth' ),
				'bold'     => esc_html__( 'Bold', 'earth' ),
				'bolder'   => esc_html__( 'Bolder', 'earth' ),
				'100'      => '100',
				'200'      => '200',
				'300'      => '300',
				'400'      => '400',
				'500'      => '500',
				'600'      => '600',
				'700'      => '700',
				'800'      => '800',
				'900'      => '900',
			);
			return array(
				'name' => esc_html__( 'Leader (Menu Items)', 'earth' ),
				'description' => esc_html__( 'CSS dot or line leader (menu item)', 'earth' ),
				'base' => 'css_leader',
				'icon' => 'earth-vc-icon fa fa-long-arrow-right',
				'category' => "Earth",
				'params' => array(
					// Leaders
					array(
						'type' => 'param_group',
						'param_name' => 'leaders',
						'group' => esc_html__( 'Leaders', 'earth' ),
						'value' => urlencode( json_encode( array(
							array(
								'label' => esc_html__( 'One', 'earth' ),
								'value' => '$10',
							),
							array(
								'label' => esc_html__( 'Two', 'earth' ),
								'value' => '$20',
							),
						) ) ),
						'params' => array(
							array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Label', 'earth' ),
								'param_name' => 'label',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Value', 'earth' ),
								'param_name' => 'value',
								'admin_label' => true,
							),
						),
					),
					// General
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Classes', 'earth' ),
						'param_name' => 'el_class',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Appear Animation', 'earth' ),
						'param_name' => 'css_animation',
						'value' => array(
							__( 'No', 'earth' ) => '',
							__( 'Top to bottom', 'earth' ) => 'top-to-bottom',
							__( 'Bottom to top', 'earth' ) => 'bottom-to-top',
							__( 'Left to right', 'earth' ) => 'left-to-right',
							__( 'Right to left', 'earth' ) => 'right-to-left',
							__( 'Appear from center', 'earth' ) => 'appear'
						),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Style', 'earth' ),
						'param_name' => 'style',
						'value' => array(
							__( 'Dots', 'earth' ) => 'dots',
							__( 'Dashes', 'earth' ) => 'dashes',
						),
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Color', 'earth' ),
						'param_name' => 'color',
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Background', 'earth' ),
						'param_name' => 'background',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Font Size', 'earth' ),
						'param_name' => 'font_size',
					),
					// Label
					array(
						'type' => 'colorpicker',
						'param_name' => 'label_color',
						'heading' => esc_html__( 'Color', 'earth' ),
						'group' => esc_html__( 'Label', 'earth' ),
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'label_font_weight',
						'heading' => esc_html__( 'Font Weight', 'earth' ),
						'group' => esc_html__( 'Label', 'earth' ),
						'std' => '',
						'value' => array_flip( $font_weights ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Font Style', 'earth' ),
						'param_name' => 'label_font_style',
						'value' => array(
							esc_html__( 'Normal', 'earth' ) => '',
							esc_html__( 'Italic', 'earth' ) => 'italic',
						),
						'group' => esc_html__( 'Label', 'earth' ),
					),
					array(
						'type'  => 'earth_font_family_select',
						'heading' => esc_html__( 'Font Family', 'earth' ),
						'param_name' => 'label_font_family',
						'group' => esc_html__( 'Label', 'earth' ),
					),
					// Color
					array(
						'type' => 'colorpicker',
						'param_name' => 'value_color',
						'heading' => esc_html__( 'Color', 'earth' ),
						'group' => esc_html__( 'Value', 'earth' ),
					),
					array(
						'type' => 'dropdown',
						'param_name' => 'value_font_weight',
						'heading' => esc_html__( 'Font Weight', 'earth' ),
						'group' => esc_html__( 'Value', 'earth' ),
						'std' => '',
						'value' => array_flip( $font_weights ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'font Style', 'earth' ),
						'param_name' => 'value_font_style',
						'value' => array(
							esc_html__( 'Normal', 'earth' ) => '',
							esc_html__( 'Italic', 'earth' ) => 'italic',
						),
						'group' => esc_html__( 'Value', 'earth' ),
					),
					array(
						'type'  => 'earth_font_family_select',
						'heading' => esc_html__( 'Font Family', 'earth' ),
						'param_name' => 'value_font_family',
						'group' => esc_html__( 'Value', 'earth' ),
					),
				)
			);
		}

	}

}
new Earth_Leader_Shortcode;