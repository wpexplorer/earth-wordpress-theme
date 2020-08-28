<?php
/**
 * Theme shortcodes
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 3.7.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*-----------------------------------------------------------------------------------*/
/*	Shortcode filters - alow shortcodes in widgets
/*-----------------------------------------------------------------------------------*/
add_filter('widget_text', 'do_shortcode');


/*-----------------------------------------------------------------------------------*/
/*	Fix Shortcodes
/*-----------------------------------------------------------------------------------*/
add_filter('the_content', 'earth_fix_shortcodes');
if ( ! function_exists('earth_fix_shortcodes') ) {
	function earth_fix_shortcodes($content){   
		$array = array (
			'<p>[' => '[', 
			']</p>' => ']', 
			']<br />' => ']'
		);
		$content = strtr($content, $array);
		return $content;
	}
}

/*-----------------------------------------------------------------------------------*/
/*	WPML
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_wpml_shortcode') ) {
	function earth_wpml_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'lang'	=> '',
		), $atts));
		if ( ! defined('ICL_LANGUAGE_CODE') ) return esc_html__( 'WPML ICL_LANGUAGE_CODE constant does not exist. If you want to translate something please first install the WPML plugin.', 'earth' );
		$lang_active = ICL_LANGUAGE_CODE;
		if ($lang == $lang_active){
			return do_shortcode($content);
		}
	}
}
add_shortcode( 'wpml', 'earth_wpml_shortcode' );

/*-----------------------------------------------------------------------------------*/
/* Spacing 
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_spacing_shortcode') ) {
	function earth_spacing_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'size'	=> '20px',
			'class'	=> '',
		  ),
		  $atts ) );
	 return '<hr class="spacing '. $class .'" style="height: '. $size .'" />';
	}
}
add_shortcode( 'spacing', 'earth_spacing_shortcode' );

/*-----------------------------------------------------------------------------------*/
/*	Google Maps Shortcode
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_google_maps_shortcode') ) {
	function earth_google_maps_shortcode($atts, $content = null) {
	   extract(shortcode_atts(array(
		  "width" 	=> '640',
		  "height"	=> '480',
		  "src" 	=> ''
	   ), $atts));
	   return '<div class="google-map"><iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'&amp;output=embed"></iframe></div>';
	}
}
add_shortcode("googlemap", "earth_google_maps_shortcode");


/*-----------------------------------------------------------------------------------*/
/*	Colored Buttons
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_button_shortcode') ) {
	function earth_button_shortcode( $atts, $content=null ) {
		extract( shortcode_atts( array(
			'color'  => 'brown',
			'url'    => 'http://www.google.com/',
			'target' => 'self',
			'rel'    => '',
			'title'  => __( 'Title Attribute', 'earth' )
		), $atts ) );
		$content = $content ? $content : __( 'Button Text', 'earth' );
		if ( $url ) {
			return '<a href="' . $url . '" class="button ' . $color . '" target="_'.$target.'" rel="'. $rel .'" title="' . $title . '"><span>' . $content . '</span></a>';
		} else {
			return '<div class="button ' . $color . '">' . $content . '</div>';
		}
	}
}
add_shortcode( 'button', 'earth_button_shortcode' );


/*-----------------------------------------------------------------------------------*/
/*	Lists
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_list_shortcode') ) {
	function earth_list_shortcode( $atts, $content = null ) {
		extract(
		shortcode_atts( array(
		  'type' => 'check'
		  ),
		  $atts ) );
			return '<div class="' . $type . '">' . $content . '</div>';
	}
}
add_shortcode('list', 'earth_list_shortcode');


/*-----------------------------------------------------------------------------------*/
/*	Clear
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_clear_shortcode') ) {
	function earth_clear_shortcode() {
	   return '<div class="clear"></div>';
	}
}
add_shortcode( 'clear', 'earth_clear_shortcode' );


/*-----------------------------------------------------------------------------------*/
/*	BR
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_br_shortcode') ) {
	function earth_br_shortcode( ) {
	   return '<br />';
	}
}
add_shortcode( 'br', 'earth_br_shortcode' );



/*-----------------------------------------------------------------------------------*/
/*	HR
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_hr_shortcode') ) {
	function earth_hr_shortcode( $atts, $content = null ){
		extract(shortcode_atts(array(
			'style' => '',
			'margin_top' => '',
			'margin_bottom' => ''
		), $atts ));
	   return '<div class="clear"></div><hr class="'.$style.'" style="margin-top: '.$margin_top.'px; margin-bottom:'.$margin_bottom.'px;" />';
	}
}
add_shortcode( 'hr', 'earth_hr_shortcode' );


/*-----------------------------------------------------------------------------------*/
/*	Testimonial
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_testimonial_shortcode') ) {
	function earth_testimonial_shortcode( $atts, $content = null  ) {
		
		extract( shortcode_atts( array(
			'id' => ''
		  ), $atts ) );
		  
		$post_id = get_post($id); 
		$title = $post_id->post_title;
		$content = $post_id->post_content;
		
		$testimonial_content = '';
		$testimonial_content .= '<article class="testimonial testimonial-shortcode"><div class="testimonial-content">';
		$testimonial_content .= $content;
		$testimonial_content .= '</div><div class="testimonial-author">';
		$testimonial_content .= $title .'</div></article>';
			
		return $testimonial_content;
	}
}
add_shortcode( 'testimonial', 'earth_testimonial_shortcode' );


/*-----------------------------------------------------------------------------------*/
/*	Togggle
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_toggle_shortcode') ) {
	function earth_toggle_shortcode( $atts, $content = null )
	{
		extract( shortcode_atts(
		array(
		  'title'	=> 'Click To Open',
		  'state'	=> '',
		  ),
		  $atts ) );
			$state = ( $state == 'open' ) ? 'open-toggle' : null;
			$active = ( $state == 'open-toggle' ) ? 'active' : null;
			return '<div class="toggle-wrap '. $state  .'"><h3 class="trigger '. $active .'"><a href="#" title="'. esc_html__('Toggle', 'earth') .'">'. $title .'</a></h3><div class="toggle_container">' . do_shortcode($content) . '</div></div>';
	}
}
add_shortcode('toggle', 'earth_toggle_shortcode');


/*-----------------------------------------------------------------------------------*/
/*	Accordion
/*-----------------------------------------------------------------------------------*/


/*main*/
function accordion_shortcode( $atts, $content = null  ) {
	wp_enqueue_script( 'jquery-ui-accordion' );
	wp_enqueue_script( 'wpex-accordion', EARTH_ASSETS_DIR_URI . '/js/accordion.js', array( 'jquery' ), '1.0', true );	
	return '<div class="accordion earth-accordion">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'accordion', 'accordion_shortcode' );


/*section*/
function accordion_section_shortcode( $atts, $content = null  ) {	
	extract( shortcode_atts( array(
      'title' => 'Title',
	), $atts ) );	  
   return '<h3><a href="#">'. $title .'</a></h3><div class="ui-accordion-content">' . do_shortcode($content) . '</div>';
}

add_shortcode( 'accordion_section', 'accordion_section_shortcode' );


/*-----------------------------------------------------------------------------------*/
/*	Tabs
/*-----------------------------------------------------------------------------------*/

function tabgroup_shortcode( $atts, $content = null ){
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script( 'wpex-tabs', EARTH_ASSETS_DIR_URI . '/js/tabs.js', array( 'jquery' ), '1.0', true );
	
	extract(shortcode_atts(
	array(
      	'set' => '1',
	 	'titles' => '',
		'margin' => '0'
      ),
	  $atts ) );
	  
	  $tabgroup_titles = esc_attr($titles);
	  $tabgroub_title = explode(",", $tabgroup_titles);
	  
	  	$tabgroup_content = '';
		
		$tabgroup_content .='<div class="tabs tab-shortcode" style="margin: '.$margin.'px 0;"><ul class="clearfix ui-tabs-nav">';

		$count = 1;
		for( $i = 0; $i <= count($tabgroub_title)-1; $i++) {
			$tabgroup_content .= '<li><a href="#tabs-'. $set .'-'.$count++.'">'.trim($tabgroub_title[$i]).'</a></li>';
		}
		
		$tabgroup_content .='</ul>'. do_shortcode($content);
			
		$tabgroup_content .='</div>';
		
		return $tabgroup_content;
}
add_shortcode('tabgroup', 'tabgroup_shortcode');


function single_tab( $atts, $content = null ){
	extract(shortcode_atts(
	array(
      'set' => '1',
	  'position' =>''
      ),
	  $atts ) );
	  
	    $tab_content = '';
		$tab_content .='<div id="tabs-'. $set .'-'. $position .'" class="tab_content">'. do_shortcode($content) .'</div>';
		
		return $tab_content;
}
add_shortcode( 'tab', 'single_tab' );



/*-----------------------------------------------------------------------------------*/
/*	Alerts
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_alert_shortcode') ) {
	function earth_alert_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => '',
			'align' =>'center',
			'title' => ''
		  ), $atts ) );
		  
		  $alert_content = '';
		  $alert_content .= '<div class="alert-' . $color . ' align'.$align.'">';
			if ($title) {
				$alert_content .='<h2 class="alert-title">'.$title.'</h2>';
			}
		  $alert_content .= ' '.do_shortcode($content) .'</div>';
	
		  return $alert_content;
	
	}
}
add_shortcode('alert', 'earth_alert_shortcode');


/*-----------------------------------------------------------------------------------*/
/*	Columns
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('earth_column_shortcode') ) {
	function earth_column_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
		  'offset' =>'',
		  'size' => '',
		  'position' =>''
		  ), $atts ) );
	
	
		  if ($offset !='') { $column_offset = $offset; } else { $column_offset ='one'; }
			
		  return '<div class="'.$column_offset.'-' . $size . ' column-'.$position.'">' . do_shortcode($content) . '</div>';
	
	}
}
add_shortcode('column', 'earth_column_shortcode');