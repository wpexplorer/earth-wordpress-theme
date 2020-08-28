<?php
/**
 * Custom CSS output based on theme settings
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_custom_css() {
		
		$custom_css ='';
		
		/**custom css field**/
		if ( earth_get_option( 'custom_css' ) ) {
			$custom_css .= earth_get_option( 'custom_css' );
		}
		
		//background
		if ( $bg = earth_get_option( 'custom_bg' ) ) {
			if ( false == stripos( $bg, '0.png' ) ) {
				$custom_css .= 'body{ background-image: url( '. esc_url( $bg ) .' ); }';
			}
		}
		if ( earth_get_option( 'background_color' ) ) {
			$custom_css .= 'body{background-color: '.earth_get_option( 'background_color' ).';}';
		}
		
		// Header padding
		if ( $padding = earth_get_option( 'header_top_padding' ) ) {
			if ( '35px' !== $padding ) {
				$custom_css .= '#masterhead{ padding-top: ' . intval( $padding ) . 'px; }';
			}
		}
		if (  $padding = earth_get_option('header_bottom_padding' ) ) {
			if ( '35px' !== $padding ) {
				$custom_css .= '#masterhead{ padding-bottom: ' . intval( $padding ) . 'px; }';
			}
		}
		
		// Social Margin
		if ( $margin = earth_get_option( 'social_margin_top' ) ) {
			$custom_css .= '#mastersocial{ margin-top: ' . intval( $margin ) . 'px; }';
		}

		// Searchbar width
		if ( $width = earth_get_option( 'search_width', '180px' ) ) {
			if ( '180px' !== $width ) {
				$custom_css .= '#mainnav #searchbar { width: '. intval( $width ) .'px; }';
			}
		}

		// Header aside top value
		if ( $top = earth_get_option( 'header_aside_top' ) ) {
			$custom_css .= '#masterhead-aside{ top: ' . intval( $top ) . 'px; }';
		}
		
		// CUSTOM STYLING OPTIONS
		if ( earth_get_option( 'custom_styling', true ) ) {
			
			// Logo
			$logo_color = earth_get_option( 'logo_color' );
			$logo_hover_color = earth_get_option( 'logo_hover_color' );
			
			if ( $logo_color ) {
				$custom_css .='.text-logo { color: '. $logo_color .'; }';
			}
			
			if ( $logo_hover_color ) {
				$custom_css .='.text-logo:hover { color: '. $logo_hover_color .'; }';
			}
		
			// Donation Button
			$donation_bg = earth_get_option( 'donation_bg' );
			$donation_color = earth_get_option( 'donation_color' );
			$donation_hover_bg = earth_get_option( 'donation_hover_bg' );
			$donation_hover_color = earth_get_option( 'donation_hover_color' );
			$donation_hover_animation = earth_get_option( 'donation_hover_animation', '1' );
			
			
			if ( $donation_bg ) {
				$custom_css .='#header-donate { background: '. $donation_bg .'; border-color: rgba(0,0,0,0.3) }';
				$custom_css .='#header-donate-inner { border-color: rgba(255,255,255,0.3); }';
			}
			
			if ( $donation_color ) {
				$custom_css .='#header-donate { color: '. $donation_color .';}';
			}
			
			if ( $donation_hover_bg ) {
				$custom_css .='#header-donate:hover { background: '. $donation_hover_bg .';}';
			}
			
			if ( $donation_hover_color ) {
				$custom_css .='#header-donate:hover { color: '. $donation_hover_color .';}';
			}
			
			if ( $donation_hover_animation !== '1' ) {
				$custom_css .='#header-donate:hover #header-donate-inner { height: 35px; line-height: 35px; }';
			}
	
			// Navigation
			$menu_bg_top = earth_get_option( 'menu_bg_top' );
			$menu_bg_bottom = earth_get_option( 'menu_bg_bottom' );
			$menu_top_border = earth_get_option( 'menu_top_border' );
			$menu_link_right_border = earth_get_option( 'menu_link_right_border' );
			$menu_link_left_border = earth_get_option( 'menu_link_left_border' );
			$menu_color = earth_get_option( 'menu_color' );
			$menu_bg_hover = earth_get_option( 'menu_bg_hover' );
			$menu_color_hover = earth_get_option( 'menu_color_hover' );
			$dropdown_bg = earth_get_option( 'dropdown_bg' );
			$dropdown_top_border = earth_get_option( 'dropdown_top_border' );
			$dropdown_bottom_border = earth_get_option( 'dropdown_bottom_border' );
			$dropdown_color = earth_get_option( 'dropdown_color' );
			$dropdown_bg_hover = earth_get_option( 'dropdown_bg_hover' );
			$dropdown_color_hover = earth_get_option( 'dropdown_color_hover' );
			$menu_text_shadow = earth_get_option( 'menu_text_shadow' );
			
			if ( $menu_bg_top && $menu_bg_bottom == '' ) {
				$custom_css .='#mainnav { background: '. $menu_bg_top .'; } #mainnav .sf-menu > li { background: none; }';
			}
			
			if ( $menu_bg_top && $menu_bg_bottom ) {
				$custom_css .= '
					#mainnav {
					/* IE10 Consumer Preview */
					background-image: -ms-linear-gradient(top, '. $menu_bg_top .' 0%, '. $menu_bg_bottom .' 100%);
					/* Mozilla Firefox */
					background-image: -moz-linear-gradient(top,'. $menu_bg_top .' 0%,'. $menu_bg_bottom .' 100%);
					/* Opera */
					background-image: -o-linear-gradient(top,'. $menu_bg_top .' 0%,'. $menu_bg_bottom .' 100%);
					/* Webkit (Safari/Chrome 10) */
					background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0,'. $menu_bg_top .' ),color-stop(1,'. $menu_bg_bottom .' ));
					/* Webkit (Chrome 11+) */
					background-image: -webkit-linear-gradient(top,'. $menu_bg_top .' 0%,'. $menu_bg_bottom .' 100%);
					/* W3C Markup, IE10 Release Preview */
					background-image: linear-gradient(to bottom,'. $menu_bg_top .' 0%,'. $menu_bg_bottom .' 100%);
				}';
			}
	
			if ( $menu_bg_top || $menu_bg_bottom ) {
				$custom_css .='#mainnav { border: none; }';
			}
			
			if ( $menu_link_right_border ) {
				$custom_css .='#mainnav .sf-menu > li { border-right: 1px solid '. $menu_link_right_border .'; padding-right: 0; }';
			}
			if ( $menu_link_left_border ) {
				$custom_css .='#mainnav .sf-menu { border-right: 1px solid '. $menu_link_left_border .'; } #mainnav .sf-menu > li { border-left: 1px solid '. $menu_link_left_border .'; padding-right: 0; }#mainnav .sf-menu > li:first-child { border-left: 0; }';
			}
			if ( $menu_link_right_border || $menu_link_left_border ) {
				$custom_css .='#mainnav .sf-menu > li{ background:none;}';
			}
			
			if ( $menu_color ) {
				$custom_css .='#mainnav .sf-menu a, #navigation-responsive-toggle { color: '. $menu_color.'; }';
			}
			
			if ( $menu_bg_hover ) {
				$custom_css .='#mainnav .sf-menu a:hover, #mainnav .sf-menu li.sfHover > a, #mainnav .sf-menu .current-menu-item > a, #mainnav .sf-menu .current-menu-parent > a { background: '. $menu_bg_hover.'; }';
			}
			
			if ( $menu_color_hover ) {
				$custom_css .='#mainnav .sf-menu a:hover, #mainnav .sf-menu li.sfHover > a, #mainnav .sf-menu .current-menu-item > a, #mainnav .sf-menu .current-menu-parent > a { color: '. $menu_color_hover.'; }';
			}
			
			if ( $dropdown_bg ) {
				$custom_css .='#mainnav .sf-menu ul { background: '. $dropdown_bg.'; }';
			}
			
			if ( $dropdown_top_border ) {
				$custom_css .='#mainnav .sf-menu ul li { border-top-color: '. $dropdown_top_border.'; }';
			}
			
			if ( $dropdown_bottom_border ) {
				$custom_css .='#mainnav .sf-menu ul li { border-bottom-color: '. $dropdown_bottom_border.'; }';
			}
			
			if ( $dropdown_color ) {
				$custom_css .='#mainnav .sf-menu ul a { color: '. $dropdown_color.'; }';
			}
			
			if ( $dropdown_bg_hover ) {
				$custom_css .='#mainnav .sf-menu ul a:hover { background: '. $dropdown_bg_hover.'; }';
			}
			
			if ( $dropdown_color_hover ) {
				$custom_css .='#mainnav .sf-menu ul a:hover { color: '. $dropdown_color_hover.'; }';
			}
			
			if ( $menu_text_shadow !== '1' ) {
				$custom_css .='#mainnav .sf-menu a, #navigation-responsive-toggle { text-shadow: none !important; }';
			}
			
			
			// Footer Colors
			$footer_bg = earth_get_option( 'footer_bg' );
			$footer_border = earth_get_option( 'footer_border' );
			$footer_headings_color = earth_get_option( 'footer_headings_color' );
			$footer_text_color = earth_get_option( 'footer_text_color' );
			$footer_link_color = earth_get_option( 'footer_link_color' );
			$footer_link_hover_color = earth_get_option( 'footer_link_hover_color' );
			$footer_link_hover_bg = earth_get_option( 'footer_link_hover_bg' );
			$footer_li_border = earth_get_option( 'footer_li_border' );
			
				
			if ( $footer_bg ) {
				$custom_css .='#footer-widget-wrap, #footer { background: '. $footer_bg.'; }';
			}
			
			if ( $footer_border ) {
				$custom_css .='#footer-widget-wrap { border-bottom-color: '. $footer_border.'; }';
			}
			
			if ( $footer_headings_color ) {
				$custom_css .='.footer-widget h4, #footer h2, #footer h3, #footer h5, #footer h4 { color: '. $footer_headings_color.'; }';
			}
			
			if ( $footer_text_color ) {
				$custom_css .='#footer-widget-wrap, #footer-widget-wrap p { color: '. $footer_text_color.'; }';
			}
			
			if ( $footer_link_color ) {
				$custom_css .='#footer-widget-wrap a{ color: '. $footer_link_color.'; }';
			}
			
			if ( $footer_link_hover_color ) {
				$custom_css .='#footer-widget-wrap a:hover { color: '. $footer_link_hover_color.'; }';
			}
			
			if ( $footer_link_hover_bg ) {
				$custom_css .='#footer .widget_recent_entries a:hover, #footer .widget_categories a:hover, #footer .widget_pages a:hover, #footer .widget_links a:hover, #footer .widget_archive a:hover, #footer .widget_meta a:hover, #footer .widget_nav_menu a:hover { background: '. $footer_link_hover_bg.'; }';
			}
			
			if ( $footer_li_border ) {
				$custom_css .='#footer .widget_recent_entries li,#footer .widget_categories li,#footer .widget_pages li,#footer .widget_links li,#footer .widget_archive li,#footer .widget_meta li,#footer .widget_nav_menu li { background: none; margin-bottom: 2px; border-bottom: 1px solid '. $footer_li_border  .'; }';
				$custom_css .='.footer-widget h4{background: none;border-bottom: 1px solid '. $footer_li_border  .';}';
			}
			
			// Copyright Colors
			$copyright_border = earth_get_option( 'copyright_border' );
			$copyright_bg = earth_get_option( 'copyright_bg' );
			$copyright_text_color = earth_get_option( 'copyright_text_color' );
			$copyright_link_color = earth_get_option( 'copyright_link_color' );
			$copyright_link_hover_color = earth_get_option( 'copyright_link_hover_color' );
			
			if ( $copyright_bg ) {
				$custom_css .='#footer-botttom{ background: '. $copyright_bg.'; }';
			}
			
			if ( $copyright_border ) {
				$custom_css .='#footer-botttom { border-top-color: '. $copyright_border.'; }';
			}
			
			if ( $copyright_text_color ) {
				$custom_css .='#footer-botttom, #footer-bottom p { color: '. $copyright_text_color.'; }';
			}
			
			if ( $copyright_link_color ) {
				$custom_css .='#footer-botttom a{ color: '. $copyright_link_color.'; }';
			}
			
			if ( $copyright_link_hover_color ) {
				$custom_css .='#footer-botttom a:hover{ color: '. $copyright_link_hover_color.'; }';
			}


		} // custom styling check
		
		//Font Variables
		$body_font = earth_get_option( 'body_font' );
		$logo_font = earth_get_option( 'logo_font' );
		$headings_font = earth_get_option( 'headings_font' );
		$donate_font = earth_get_option( 'donate_font' );
		$navigation_font = earth_get_option( 'navigation_font' );
		$slider_caption_font = earth_get_option( 'slider_caption_font' );
		
		//font face-types
		if ( $body_font['face'] && $body_font['face'] != 'default' ) {
			$custom_css .= 'body{font-family: '. $body_font['face'] .';}';
		}
		
		if ( $logo_font['face'] && $logo_font['face'] != 'default' ) {
			$custom_css .= '#logo {font-family: '. $logo_font['face'] .';}';
		}
			
		if ( $headings_font['face'] && $headings_font['face'] != 'default' ) {
			$custom_css .= 'h1,h2,h3,h4,h5,h6, #page-heading, #wrapper .wpb_tour .wpb_tabs_nav li a{font-family: '. $headings_font['face'] .' !important;}';
		}
		
		if ( $donate_font['face'] && $donate_font['face'] != 'default' ) {
			$custom_css .= '#header-donate, #header-donate a{font-family: '. $donate_font['face'] .' !important;}';
		}
		
		if ( $navigation_font['face'] && $navigation_font['face'] != 'default' ) {
			$custom_css .= '#mainnav{font-family: '. $navigation_font['face'] .' !important;}';
		}	
		
		if ( $slider_caption_font['face'] && $slider_caption_font['face'] != 'default' ) {
			$custom_css .= '#slider-wrap .caption{font-family: '. $slider_caption_font['face'] .' !important;}';
		}
		
		//font weights
		if ( $body_font['style'] == 'italic' ) {
			$custom_css .= 'body{font-style: italic; font-weight: normal;}';
		}
		if ( $body_font['style'] == 'bold' ) {
			$custom_css .= 'body{font-weight: bold;}';
		}
		if ( $body_font['style'] == 'bold italic' ) {
			$custom_css .= 'body{font-weight: bold;font-style: italic;}';
		}
		
		
		if ( $headings_font['style'] == 'normal' ) {
			$custom_css .= 'h1,h2,h3,h4,h5,h6,h2 a,h3 a,h4 a, #page-heading{font-weight: normal !important;}';
		}
		if ( $headings_font['style'] == 'italic' ) {
			$custom_css .= 'h1,h2,h3,h4,h5,h6,h2 a,h3 a,h4 a, #page-heading{font-style: italic; font-weight: nomal !important;}';
		}
		if ( $headings_font['style'] == 'bold italic' ) {
			$custom_css .= 'h1,h2,h3,h4,h5,h6,h2 a,h3 a,h4 a, #page-heading{font-weight: bold;font-style: italic !important;}';
		}
		
		
		if ( $donate_font['style'] == 'normal' ) {
			$custom_css .= '#header-donate{font-weight: normal;}';
		}
		if ( $donate_font['style'] == 'italic' ) {
			$custom_css .= '#header-donate{font-style: italic; font-weight: normal;}';
		}
		if ( $donate_font['style'] == 'bold italic' ) {
			$custom_css .= '#header-donate{font-weight: bold;font-style: italic;}';
		}
		
		
		if ( $navigation_font['style'] == 'italic' ) {
			$custom_css .= '#mainnav,#mainnav a{font-style: italic; font-weight: normal;}';
		}
		if ( $navigation_font['style'] == 'normal' ) {
			$custom_css .= '#mainnav, #mainnav a{font-weight: normal;}';
		}
		if ( $navigation_font['style'] == 'bold italic' ) {
			$custom_css .= '#mainnav, #mainnav a{font-weight: bold;font-style: italic;}';
		}
		
		
		if ( $slider_caption_font['style'] == 'normal' ) {
			$custom_css .= '#slider-wrap .caption{font-weight: normal;}';
		}
		if ( $slider_caption_font['style'] == 'italic' ) {
			$custom_css .= '#slider-wrap .caption{font-style: italic; font-weight: normal;}';
		}
		if ( $slider_caption_font['style'] == 'bold' ) {
			$custom_css .= '#slider-wrap .caption{font-weight: bold;}';
		}
		if ( $slider_caption_font['style'] == 'bold italic' ) {
			$custom_css .= '#slider-wrap .caption{font-weight: bold;font-style: italic;}';
		}
		
		//font sizes
		if ( $donate_font['size'] != '13px' ) {
			$custom_css .= 'a#header-donate{font-size: '. $donate_font['size'] .';}';
		}
		
		if ( $navigation_font['size'] != '13px' ) {
			$custom_css .= '#mainnav .sf-menu a{font-size: '. $navigation_font['size'] .';}';
		}
		
		if ( $slider_caption_font['size'] != '14px' ) {
			$custom_css .= '#slider-wrap .caption{font-size: '. $slider_caption_font['size'] .';}';
		}

		// Return if there isn't any CSS to output
		if ( ! $custom_css  ) {
			return;
		}
		
		// trim white space for faster page loading
		$custom_css_trimmed = preg_replace( '/\s+/', ' ', $custom_css );
		
		// Output css on front end
		if ( $custom_css_trimmed ) {
			echo "<!-- Custom CSS -->\n<style type=\"text/css\">\n" . $custom_css_trimmed . "\n</style>";
		}

}
add_action( 'wp_head', 'earth_custom_css' );