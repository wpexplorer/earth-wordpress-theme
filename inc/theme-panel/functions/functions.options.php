<?php
/**
 * Admin options
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'of_options' ) ) {

	function of_options() {

		// Store arrays
		$asc_desc =  array( 'ASC','DESC');
		$enable_disable = array( 'enable','disable');
		$disable_enable = array( 'disable','enable'); 
		$blank_self = array( 'blank','self');	
		$of_options_events_radio = array( 'no','yes');
		$of_options_homepage_blocks = array(
			"enabled" => array (
			"placebo" => "placebo",
			"home_highlights" => esc_html__( "Highlights", "earth" ),
			"home_blog_events" => esc_html__( "Events & Blog", "earth" ),
			"home_blog" => esc_html__( "Blog", "earth" ),
			"home_events" => esc_html__( "Events", "earth" ),
			"home_gallery" => esc_html__( "Gallery Items", "earth" ),
			),
			"disabled" => array (
			"placebo" => "placebo",
			"home_static_page" => esc_html__( "Static Page", "earth" ),
			"home_gallery_single" => esc_html__( "Single Gallery", "earth" ),
			),
		);

		// Layouts
		$layouts = array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'earth' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'earth' ),
			'full-width'    => esc_html__( 'Full Width', 'earth' ),
		);
		
		// Image crop locations
		$img_crop_locations = array(
			''              => esc_html__( 'Default', 'earth' ),
			'left-top'      => esc_html__( 'Top Left', 'earth' ),
			'right-top'     => esc_html__( 'Top Right', 'earth' ),
			'center-top'    => esc_html__( 'Top Center', 'earth' ),
			'left-center'   => esc_html__( 'Center Left', 'earth' ),
			'right-center'  => esc_html__( 'Center Right', 'earth' ),
			'center-center' => esc_html__( 'Center Center', 'earth' ),
			'left-bottom'   => esc_html__( 'Bottom Left', 'earth' ),
			'right-bottom'  => esc_html__( 'Bottom Right', 'earth' ),
			'center-bottom' => esc_html__( 'Bottom Center', 'earth' ),
		);

		/*-----------------------------------------------------------------------------------*/
		/* The Options Array */
		/*-----------------------------------------------------------------------------------*/
		global $of_options;
		$of_options = array();
		
		// GENERAL
		$of_options[] = array(
			'name'	=> esc_html__( 'General', 'earth' ),
			'type'	=> 'heading'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Main Logo Upload', 'earth' ),
			'desc'	=> esc_html__( 'Upload your custom logo using the native media uploader, or define the URL directly', 'earth' ),
			'id'	=> "custom_logo",
			'std'	=> '',
			'type'	=> 'media'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Custom Favicon', 'earth' ),
			'desc'	=> esc_html__( 'Upload or past the URL for your custom favicon.', 'earth' ),
			'id'	=> 'custom_favicon',
			'std'	=> '',
			'type'	=> 'upload'
		);

		//login logo
		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Login Logo','earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Custom Login Logo', 'earth' ),
			'desc'	=> esc_html__( 'Upload a custom logo for your Wordpress login screen.', 'earth' ),
			'id'	=> "custom_login_logo",
			'std'	=> '',
			'type'	=> 'media'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Custom Login Logo Height', 'earth' ),
			'desc'	=> esc_html__( 'Enter the height of your custom logo to override the default WordPress image height.', 'earth' ),
			'id'	=> "custom_login_logo_height",
			'std'	=> '',
			'type'	=> 'text'
		);
		
		//header
		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Header','earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Header Top Padding', 'earth' ),
			'desc'	=> esc_html__( 'Top padding value for your header in pixels. Default: 25px', 'earth' ),
			'id'	=> "header_top_padding",
			'std'	=> "35px",
			'type'	=> 'text'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Header Bottom Padding', 'earth' ),
			'desc'	=> esc_html__( 'Bottom padding value for your header in pixels. Default: 25px', 'earth' ),
			'id'	=> "header_bottom_padding",
			'std'	=> "35px",
			'type'	=> 'text'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Header Search Bar', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the header search bar.', 'earth' ),
			'id'	=> "disable_search",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Header Search Bar Width', 'earth' ),
			'desc'	=> esc_html__( 'Enter a custom width for your searchbar', 'earth' ),
			'id'	=> "search_width",
			'std'	=> '180px',
			'type'	=> 'text',
			'fold'	=> "disable_search",
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Custom Responsive Menu Text', 'earth' ),
			'desc'	=> esc_html__( 'Custom Responsive menu text. Please leave blank if using WPML to translate it.', 'earth' ),
			'id'	=> "responsive_text",
			'std'	=> '',
			'type'	=> 'text'
		);
			
		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Donate Button','earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Header Donate Button', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the header donate button.', 'earth' ),
			'id'	=> "header_donate",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Header Donate Button Text', 'earth' ),
			'desc'	=> esc_html__( 'Enter the text for your top bar callout button.', 'earth' ),
			'id'	=> "callout_text",
			'std'	=> "Donate",
			'type'	=> 'text',
			'fold'	=> "header_donate",
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Header Donate Button Link', 'earth' ),
			'desc'	=> esc_html__( 'Enter the url to link your top bar callout button to', 'earth' ),
			'id'	=> "callout_link",
			'std'	=> "#sample-url",
			'type'	=> 'text',
			'fold'	=> "header_donate",
		);
		
		$of_options[] = array(
			'name'	  => esc_html__( 'Header Donate Button Link Target', 'earth' ),
			'desc'	  => esc_html__( 'Select your link target', 'earth' ),
			'id'	  => "callout_target",
			'std'	  => "blank",
			'type'	  => "select",
			'options' => $blank_self,
			'fold'	  => "header_donate",
		);
		
		$of_options[] = array(
			'name'		=> esc_html__( 'Header Donate Button Icon', 'earth' ),
			'desc'		=> esc_html__( 'Select your preferred icon. You can preview the icons at <a href="http://fortawesome.github.com/Font-Awesome/">font awesome</a>.', 'earth' ),
			'id'		=> "callout_icon",
			'std'		=> "Select",
			'type'		=> "select",
			'options'	=> earth_get_awesome_icons(),
			'fold'		=> "header_donate",
		);
			
			
		// STYLING			
		$of_options = earth_styling_options( $of_options );
		
		// FONTS
		$of_options[] = array(
			'name'	=> esc_html__( 'Typography', 'earth' ),
			'type'	=> 'heading'
		);				
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Body Font', 'earth' ),
			'desc'	=> esc_html__( 'Body font properties', 'earth' ),
			'id'	=> "body_font",
			'std'	=> array( 'face' => 'Droid Sans', 'style' => 'normal',),
			'type'	=> "typography"
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Logo Font', 'earth' ),
			'desc'	=> esc_html__( 'Body font properties', 'earth' ),
			'id'	=> "logo_font",
			'std'	=> array( 'face' => 'Chewy', 'style' => 'normal',),
			'type'	=> "typography"
		); 

		$of_options[] = array(
			'name'	=> esc_html__( 'Headings', 'earth' ),
			'desc'	=> esc_html__( 'Deadings font properties. This will be applied to h1, h2, h3, h4, h5, h6 tags.', 'earth' ),
			'id'	=> "headings_font",
			'std'	=> array( 'face' => 'Bree Serif', 'style' => 'normal' ),
			'type'	=> "typography"
		);
		 
	$of_options[] = array(
			'name'	=> esc_html__( 'Donate Button', 'earth' ),
			'desc'	=> esc_html__( 'Donate button font properties.', 'earth' ),
			'id'	=> "donate_font",
			'std'	=> array( 'size' => '18px', 'face' => 'Chewy','style' => 'normal'),
			'type'	=> "typography"
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Navigation', 'earth' ),
			'desc'	=> esc_html__( 'Navigation button font properties.', 'earth' ),
			'id'	=> "navigation_font",
			'std'	=> array( 'size'	=> '13px', 'face' => 'default','style' => 'bold',),
			'type'	=> "typography"
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Slider Caption', 'earth' ),
			'desc'	=> esc_html__( 'Slider caption font properties.', 'earth' ),
			'id'	=> "slider_caption_font",
			'std'	=> array( 'size'	=> '14px', 'face' => 'Bree Serif', 'style' => 'normal',),
			'type'	=> "typography"
		);
		
		
		// HOME				 
		$of_options[] = array(
		'name'	=> esc_html__( 'Home', 'earth' ),
		'type'	=> 'heading');
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Homepage Layout Manager', 'earth' ),
			'desc'	=> esc_html__( 'Organize how you want the layout to appear on the homepage.', 'earth' ),
			'id'	=> "homepage_blocks",
			'std'	=> $of_options_homepage_blocks,
			'type'	=> "sorter"
		);
		
		// Events
		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Events', 'earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Events Title', 'earth' ),
			'desc'	=> esc_html__( 'Enter your custom title for the events module. Enter "disable" to disable the title completely.', 'earth' ),
			'id'	=> "home_events_title",
			'std'	=> esc_html__( 'Upcoming Events','earth' ),
			'type'	=> 'text'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Events Title Link', 'earth' ),
			'desc'	=> esc_html__( 'Enter a link for your events title (optional).', 'earth' ),
			'id'	=> "home_events_title_link",
			'std'	=> '',
			'type'	=> 'text'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'How Many Events', 'earth' ),
			'desc'	=> esc_html__( 'How many events do you want to show on the homepage.', 'earth' ),
			'id'	=> "home_events_count",
			'std'	=> "4",
			'type'	=> 'text'
		);
		
		$of_options[] = array(
			'name'	=> "Show Only Featured Events?",
			'desc'	=>  esc_html__( 'Check this box to only show featured events on the homepage.', 'earth' ),
			'id'	=> "home_featured_event",
			'std'	=> "0",
			'type'	=> "checkbox",
			'options' => $of_options_events_radio
		);
		
		// Recent news
		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Blog', 'earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Recent News Title', 'earth' ),
			'desc'	=> esc_html__( 'Enter your custom title for the latest blog items module. Enter "disable" to disable the title completely.', 'earth' ),
			'id'	=> "home_blog_title",
			'std'	=> esc_html__( 'From The Blog','earth' ),
			'type'	=> 'text'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Recent News Title Link', 'earth' ),
			'desc'	=> esc_html__( 'Enter a link for your recent news title (optional).', 'earth' ),
			'id'	=> "home_blog_title_link",
			'std'	=> '',
			'type'	=> 'text'
		);
		
		$of_options[] = array(
			'name'		=> esc_html__( 'Recent News Category', 'earth' ),
			'desc'		=> esc_html__( 'If you do not want recent blog posts from all the most recent posts, select a specific category below to pull the posts from.', 'earth' ),
			'id'		=> "home_blog_cat",
			'std'		=> "-",
			'type'		=> "select",
			'options'	=> earth_get_cats()
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'How Recent News Posts?', 'earth' ),
			'desc'	=> esc_html__( 'How many latest blog posts do you want to show on the homepage.', 'earth' ),
			'id'	=> "home_blog_count",
			'std'	=> "3",
			'type'	=> 'text'
		);
		
		// Gallery
		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Gallery', 'earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Gallery Items Title', 'earth' ),
			'desc'	=> esc_html__( 'Enter your custom title for the latest gallery items module. Enter "disable" to disable the title completely.', 'earth' ),
			'id'	=> "home_gallery_title",
			'std'	=> esc_html__( 'Recent Galleries','earth' ),
			'type'	=> 'text'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Gallery Items Title Link', 'earth' ),
			'desc'	=> esc_html__( 'Enter a link for your recent galleries title (optional).', 'earth' ),
			'id'	=> "home_gallery_title_link",
			'std'	=> '',
			'type'	=> 'text'
		);
		
		$of_options[] = array(
			'name'		=> esc_html__( 'Gallery Category', 'earth' ),
			'desc'		=> esc_html__( 'If you do not want to show all the recent gallery items, select a specific category below.', 'earth' ),
			'id'		=> "home_gallery_cat",
			'std'		=> "-",
			'type'		=> "select",
			'options'	=> earth_get_gallery_cats()
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'How Many Latest Gallery Items', 'earth' ),
			'desc'	=> esc_html__( 'How many latest gallery items do you want to show on the homepage.', 'earth' ),
			'id'	=> "home_gallery_count",
			'std'	=> "10",
			'type'	=> 'text'
		);
		
		//Single Gallery
		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Single Gallery', 'earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Single Gallery Title', 'earth' ),
			'desc'	=> esc_html__( 'Enter your custom title for the latest gallery items module. Enter "disable" to disable the title completely.', 'earth' ),
			'id'	=> "home_gallery_single_title",
			'std'	=> esc_html__( 'Featured Gallery','earth' ),
			'type'	=> 'text'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Single Gallery Title Link', 'earth' ),
			'desc'	=> esc_html__( 'Enter a link for your single gallery title (optional).', 'earth' ),
			'id'	=> "home_gallery_single_title_link",
			'std'	=> '',
			'type'	=> 'text'
		);
		
		$of_options[] = array(
			'name'		=> esc_html__( 'Single Gallery', 'earth' ),
			'desc'		=> esc_html__( 'Select the gallery to display.', 'earth' ),
			'id'		=> "home_gallery_single_slug",
			'std'		=> '',
			'type'		=> "select",
			'options'	=> earth_get_gallery_posts()
		);
		
		
		//Static Page
		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Static Page', 'earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Static Page Title', 'earth' ),
			'desc'	=> esc_html__( 'Enter the text for your static page module. (optional)', 'earth' ),
			'id'	=> "home_static_page_title",
			'std'	=> "Sample Title",
			'type'	=> 'text',
		);
		
		$of_options[] = array(
			'name'		=> esc_html__( 'Static Page', 'earth' ),
			'desc'		=> esc_html__( 'Select a page for your homepage static page module. <strong>Important:</strong> Pages with custom loops like the portfolio, services, staff..etc, pages will not work.This only shows the content from the post editor.', 'earth' ),
			'id'		=> "home_static_page",
			'std'		=> "-",
			'type'		=> "select",
			'options'	=> earth_get_pages()
		);
			
		// SLIDER SETTINGS		
		$of_options[] = array(
			'name'	=> esc_html__( 'Slider','earth' ),
			'type'	=> 'heading'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Slides', 'earth' ),
			'desc'	=> esc_html__( 'Enable or disable the built-in slides post type. Refresh your browser after altering this setting.', 'earth' ),
			'id'	=> "slides",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
		);

		$of_options[] = array(
			'name'	=>  esc_html__( 'Slider Width','earth' ),
			'id'	=> "slider_width",
			'std'	=> "940",
			'type'	=> 'text',
			'fold'	=> "slides",
		);
				
		$of_options[] = array(
			'name'	=>  esc_html__( 'Slider Height','earth' ),
			'id'	=> "slider_height",
			'std'	=> "9999",
			'type'	=> 'text',
			'fold'	=> "slides",
		);	

		$of_options[] = array(
			'name'	  => esc_html__( 'Event Post Image Crop', 'earth' ),
			'id'	  => "slider_crop",
			'type'	  => 'select',
			'std'     => '',
			'options' => $img_crop_locations,
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=>  esc_html__( 'Animation','earth' ),
			'desc'	=>  esc_html__( 'Select your desired slider animation.','earth' ),
			'id'	=> "slider_animation",
			'std'	=> "slide",
			'type'	=> "select",
			'options'	=> array(
			'fade'	=> 'fade',
			'slide'	=> 'slide',
			),
			'fold'	=> "slides",
		);
		
		$of_options[] = array(
			'name'	=>  esc_html__( 'Animation Direction','earth' ),
			'desc'	=>  esc_html__( 'Select your desired direction for the slider animation.<br /><br /><strong>Note:</strong> If you choose vertical slides, all slides must be the same height to prevent issues.','earth' ),
			'id'	=> "slider_direction",
			'std'	=> "horizontal",
			'type'	=> "select",
			'options'	=> array(
			'horizontal'	=> 'horizontal',
			'vertical'	=> 'vertical',
			),
			'fold'	=> "slides",
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Auto Slideshow','earth' ),
			'desc'	=> esc_html__( 'Do you wish to enable or disable the automatic slideshow','earth' ),
			'id'	=> "slider_slideshow",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
			'fold'	=> "slides",
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Randomize Slideshow','earth' ),
			'desc'	=> esc_html__( 'Do you wish to enable or disable random slide order.','earth' ),
			'id'	=> "slider_randomize",
			'std'	=> '0',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
			'fold'	=> "slides",
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Slideshow Speed', 'earth' ),
			'desc'	=> esc_html__( 'Adjust the slideshow speed of your homepage slider. Time in milliseconds','earth' ),
			'id'	=> "slider_slideshow_speed",
			'std'	=> "7000",
			"min"	=> "2000",
			"step"	=> "500",
			"max"	=> "20000",
			'type'	=> "sliderui",
			'fold'	=> "slides",
				);
				
		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Home Slider','earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info',
			'fold'	=> "slides",
		);
		
		$of_options[] = array(
			'name'		=> esc_html__( 'Slider Category', 'earth' ),
			'desc'		=> esc_html__( 'Choose your image slider. If you leave this option alone it will display all your slides.', 'earth' ),
			'id'		=> "home_img_slider",
			'std'		=> "-",
			'type'		=> "select",
			'options'	=> earth_get_sliders(),
			'fold'		=> "slides",
		);
				
		$of_options[] = array( 
			'name'	=>  esc_html__( 'Slider Alternate','earth' ),
			'desc'	=>  esc_html__( 'Use this field to insert a shortcode or other HTML to replace the default flexslider','earth' ),
			'id'	=> "slider_alternative",
			'std'	=> '',
			'type'	=> "textarea",
			'fold'	=> "slides",
		);	
			
		// EVENTS
		$of_options[] = array(
			'name'	=> esc_html__( 'Events', 'earth' ),
			'type'	=> 'heading'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Events', 'earth' ),
			'desc'	=> esc_html__( 'Enable or disable the built-in events post type. Refresh your browser after altering this setting.', 'earth' ),
			'id'	=> "events",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Custom Events Sidebar', 'earth' ),
			'id'	=> "events_sidebar",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Hide Past Events', 'earth' ),
			'desc'	=> esc_html__( 'Select the hide past events from the calendar/archive.', 'earth' ),
			'id'	=> "hide_past_events",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Show Event Time On Archive', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the event time on the event posts while viewing the Event list.', 'earth' ),
			'id'	=> "enable_disable_event_list_time",
			'std'	=> false,
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Events Posts Per Page', 'earth' ),
			'desc'	=> esc_html__( 'How many events to display on the events list before displaying the numbered pagination', 'earth' ),
			'id'	=> "events_list_ppp",
			'std'	=> "10",
			'type'	=> 'text',
			'fold'  => 'events',
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Events Order', 'earth' ),
			'desc'	=> esc_html__( 'Select your preferred events order (Ascending or Descending)', 'earth' ),
			'id'	=> "events_order",
			'std'	=> "ASC",
			'type'	=> "select",
			'options'	=> $asc_desc,
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Event Time Clock', 'earth' ),
			'desc'	=> '',
			'id'	=> "events_time_clock",
			'std'	=> "12",
			'type'	=> "select",
			'options'	=> array( '12','24' ),
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Calendar','earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Show Event Time On Calendar', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the event time on the event posts while viewing the Calendar.', 'earth' ),
			'id'	=> "enable_disable_calendar_time",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Next/Prev Calendar Buttons', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the next and previous buttons on the events calendar.', 'earth' ),
			'id'	=> "event_next_prev",
			'std'	=> '0',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Post','earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	  => esc_html__( 'Single Event Layout', 'earth' ),
			'id'	  => "single_event_layout",
			'std'	  => "right-sidebar",
			'type'	  => "select",
			'options' => $layouts,
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Countdown', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the event countdown on the event posts.', 'earth' ),
			'id'	=> "enable_disable_countdown",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Extended Countdown', 'earth' ),
			'desc'	=> esc_html__( 'Will display days and hours, seconds, minutes until the event.', 'earth' ),
			'id'	=> "enable_extended_countdown",
			'std'	=> false,
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Event Tabs', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the tabs on events (details, map, gallery).', 'earth' ),
			'id'	=> "single_event_tabs",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Lighbox on Featured Image', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the lightbox function when clicking a featured image on a single event.', 'earth' ),
			'id'	=> "event_image_lightbox",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Event Post Image Width', 'earth' ),
			'id'	=> "event_thumb_width",
			'std'	=> 620,
			'type'	=> 'text',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Event Post Image Height', 'earth' ),
			'id'	=> "event_thumb_height",
			'std'	=> 9999,
			'type'	=> 'text',
			'fold'  => 'events',
		);

		$of_options[] = array(
			'name'	  => esc_html__( 'Event Post Image Crop', 'earth' ),
			'id'	  => "event_thumb_crop",
			'type'	  => 'select',
			'std'     => '',
			'options' => $img_crop_locations,
			'fold'  => 'events',
		);

		// Gallery				
		$of_options[] = array(
			'name'	=> esc_html__( 'Gallery', 'earth' ),
			'type'	=> 'heading',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Gallery', 'earth' ),
			'id'	=> 'gallery',
			'desc'	=> esc_html__( 'Enable or disable the built-in gallery post type. Refresh your browser after altering this setting.', 'earth' ),
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable', 'earth' ),
			'off'	=> esc_html__( 'Disable', 'earth' ),
			'type'	=> 'switch',
		);

		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Entry', 'earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info',
			'fold'	=> "gallery",
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Gallery Entry Image Width', 'earth' ),
			'id'	=> "gallery_entry_thumb_width",
			'std'	=> 210,
			'type'	=> 'text',
			'fold'	=> "gallery",
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Gallery Entry Image Height', 'earth' ),
			'id'	=> "gallery_entry_thumb_height",
			'std'	=> 170,
			'type'	=> 'text',
			'fold'	=> "gallery",
		);

		$of_options[] = array(
			'name'	  => esc_html__( 'Gallery Entry Image Crop', 'earth' ),
			'id'	  => "gallery_entry_thumb_crop",
			'type'	  => 'select',
			'std'     => '',
			'options' => $img_crop_locations,
			'fold'	=> "gallery",
		);

		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Post', 'earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info',
			'fold'	=> "gallery",
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Gallery Post Image Width', 'earth' ),
			'id'	=> "gallery_post_thumb_width",
			'std'	=> 210,
			'type'	=> 'text',
			'fold'	=> "gallery",
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Gallery Post Image Height', 'earth' ),
			'id'	=> "gallery_post_thumb_height",
			'std'	=> 170,
			'type'	=> 'text',
			'fold'	=> "gallery",
		);

		$of_options[] = array(
			'name'	  => esc_html__( 'Gallery Post Image Crop', 'earth' ),
			'id'	  => "gallery_post_thumb_crop",
			'type'	  => 'select',
			'std'     => '',
			'options' => $img_crop_locations,
			'fold'	=> "gallery",
		);
		
		// BLOG				
		$of_options[] = array(
			'name'	=> esc_html__( 'Blog', 'earth' ),
			'type'	=> 'heading',
		);
		
		$of_options[] = array(
			'name'		=> esc_html__( 'Blog Style', 'earth' ),
			'desc'		=> esc_html__( 'Select your blog style.', 'earth' ),
			'id'		=> "blog_style",
			'std'		=> "1",
			'type'		=> "select",
			'options'	=> array( '1','2')
		);
		
		$of_options[] = array(
			'name'		=> esc_html__( 'Divider Icon', 'earth' ),
			'desc'		=> esc_html__( 'Change the default <strong>leaf divider</strong> to another icon. You can preview the icons at <a href="http://fortawesome.github.com/Font-Awesome/">font awesome</a>.', 'earth' ),
			'id'		=> "divider_icon",
			'std'		=> "leaf",
			'type'		=> "select",
			'options'	=> earth_get_awesome_icons(),
		);

		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Entry', 'earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info',
			'fold'	=> "gallery",
		);

	$of_options[] = array(
			'name'	=> esc_html__( 'Featured Image On Blog Entries', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the featured image on the blog page and archive entries.', 'earth' ),
			'id'	=> "enable_disable_entry_image",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Entry Image Width', 'earth' ),
			'id'	=> "entry_thumb_width",
			'std'	=> 620,
			'type'	=> 'text',
			'fold'	=> "enable_disable_entry_image",
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Entry Image Height', 'earth' ),
			'id'	=> "entry_thumb_height",
			'std'	=> 9999,
			'type'	=> 'text',
			'fold'	=> "enable_disable_entry_image",
		);

		$of_options[] = array(
			'name'	  => esc_html__( 'Entry Image Crop', 'earth' ),
			'id'	  => "entry_thumb_crop",
			'type'	  => 'select',
			'std'     => '',
			'options' => $img_crop_locations,
			'fold'	=> "enable_disable_entry_image",
		);
		
		$of_options[] = array(
			'name'		=> esc_html__( 'Entry Excerpts', 'earth' ),
			'desc'		=> esc_html__( 'If enabeld the blog will display excerpts. If disabeled it will display the full post content for entries.', 'earth' ),
			'id'		=> "blog_excerpt",
			'std'		=> '1',
			'on'		=> esc_html__( 'Enable','earth' ),
			'off'		=> esc_html__( 'Disable','earth' ),
			'type'		=> 'switch'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Excerpt Length', 'earth' ),
			'desc'	=> esc_html__( 'Add your own custom blog excerpt length. Used for blog page, archives and search results.', 'earth' ),
			'id'	=> "blog_excerpt_length",
			'std'	=> "35",
			'type'	=> 'text',
			'fold'	=> "blog_excerpt",
		);

		$of_options[] = array(
			'name'	=> '',
			'desc'	=> '',
			'id'	=> 'subheading',
			'std'	=> "<h3 style=\"margin: 0;\">". esc_html__( 'Post', 'earth' ) ."</h3>",
			"icon"	=> true,
			'type'	=> 'info',
			'fold'	=> "gallery",
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Single Posts Main Heading', 'earth' ),
			'desc'	=> esc_html__( 'Enter a custom title for the single posts main heading. Default is "News".', 'earth' ),
			'id'	=> "blog_single_heading",
			'std'	=> "News",
			'type'	=> 'text',
		);

		$of_options[] = array(
			'name'		=> esc_html__( 'Display Category Name For Post Main Heading', 'earth' ),
			'desc'		=> esc_html__( 'If enabled instead of showing "News" as the main heading on your blog posts it will show the name of the first category the post is in.', 'earth' ),
			'id'		=> "blog_single_heading_term_name",
			'on'		=> esc_html__( 'Enable','earth' ),
			'off'		=> esc_html__( 'Disable','earth' ),
			'type'		=> 'switch'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Featured Image On Blog Posts', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the featured image on single blog posts.', 'earth' ),
			'id'	=> "enable_disable_post_image",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Entry Image Width', 'earth' ),
			'id'	=> "post_thumb_width",
			'std'	=> 620,
			'type'	=> 'text',
			'fold'	=> "enable_disable_post_image",
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Entry Image Height', 'earth' ),
			'id'	=> "post_thumb_height",
			'std'	=> 9999,
			'type'	=> 'text',
			'fold'	=> "enable_disable_post_image",
		);

		$of_options[] = array(
			'name'	  => esc_html__( 'Entry Image Crop', 'earth' ),
			'id'	  => "post_thumb_crop",
			'type'	  => 'select',
			'std'     => '',
			'options' => $img_crop_locations,
			'fold'	=> "enable_disable_post_image",
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Lighbox on Featured Image', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the lightbox function when clicking a featured image on a single blog post.', 'earth' ),
			'id'	=> "post_image_lightbox",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Related Blog Posts', 'earth' ),
			'desc'	=> esc_html__( 'Select to display related blog posts or not.', 'earth' ),
			'id'	=> "related_posts",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch',
		);

		if ( class_exists( 'WooCommerce' ) ) {

			// WooCommerce			
			$of_options[] = array(
				'name'	=> esc_html__( 'WooCommerce', 'earth' ),
				'type'	=> 'heading'
			);

			$of_options[] = array(
				'name'	  => esc_html__( 'Shop Layout', 'earth' ),
				'id'	  => "woo_shop_layout",
				'std'	  => "full-width",
				'type'	  => "select",
				'options' => $layouts,
			);

			$of_options[] = array(
				'name'		=> esc_html__( 'Shop Columns', 'earth' ),
				'desc'		=> esc_html__( 'Select how many columns you want for your shop page.', 'earth' ),
				'id'		=> "woo_shop_cols",
				'std'		=> "3",
				'type'		=> "select",
				'options'	=> array( '2', '3', '4' )
			);

			$of_options[] = array(
				'name'		=> esc_html__( 'Shop Posts Per Page', 'earth' ),
				'desc'		=> esc_html__( 'Select how many products to display on the shop page before displaying pagination.', 'earth' ),
				'id'		=> "woo_shop_ppp",
				'std'		=> "12",
				'type'		=> "text",
			);

			$of_options[] = array(
				'name'	  => esc_html__( 'Product Layout', 'earth' ),
				'id'	  => "woo_product_layout",
				'std'	  => "full-width",
				'type'	  => "select",
				'options' => $layouts,
			);

		}
		
		// SOCIAL			
		$of_options[] = array(
			'name'	=> esc_html__( 'Social', 'earth' ),
			'type'	=> 'heading'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Social Links In header', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable the social icons in the header.', 'earth' ),
			'id'	=> "enable_disable_social",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Social Font Icons', 'earth' ),
			'id'	=> "header_social_fa",
			'std'	=> false,
			'type'	=> 'switch',
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Social Margin Top', 'earth' ),
			'desc'	=> esc_html__( 'Enter a custom top margin for your social links.', 'earth' ),
			'id'	=> "social_margin_top",
			'std'	=> '',
			'type'	=> 'text',
			'fold'	=> "enable_disable_social",
		);
			
		$social_links = earth_social_links();

		if ( is_array( $social_links ) ) {

			foreach( $social_links as $key => $val ) {

				$label = isset( $val['label'] ) ? $val['label'] : ucfirst( $key );

				$of_options[] = array(
					'name' => $label,
					'desc'	=> ' '. esc_html__( 'Enter your ','earth' ) . $key . esc_html__( ' url','earth' ) .' <br />'. esc_html__( 'Include http:// at the front of the url.', 'earth' ),
					'id'	=> $key,
					'type'	=> 'text',
					'fold'	=> "enable_disable_social",
				);

			}

		}
			
		// TRACKING
		$of_options[] = array(
			'name'	=> esc_html__( 'Tracking', 'earth' ),
			'type'	=> 'heading'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Tracking Code (Header)', 'earth' ),
			'desc'	=> esc_html__( 'Paste your full Google Analytics code (or other) tracking code here. This will be added into the header template of your theme.', 'earth' ),
			'id'	=> "tracking_header",
			'std'	=> '',
			'type'	=> "textarea"
		);    
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Tracking Code (Footer)', 'earth' ),
			'desc'	=> esc_html__( 'Paste your full Google Analytics code (or other) tracking code here. This will be added into the footer template of your theme.', 'earth' ),
			'id'	=> "tracking_footer",
			'std'	=> '',
			'type'	=> "textarea"
		);
		
		// FOOTER
		$of_options[] = array(
			'name'	=> esc_html__( 'Footer', 'earth' ),
			'type'	=> 'heading'
		);	
				
		$of_options[] = array(
			'name'	=> esc_html__( 'Custom Copyright Text', 'earth' ),
			'desc'	=> esc_html__( 'Enter your custom copyright text here.', 'earth' ),
			'id'	=> "custom_copyright",
			'std'	=> '',
			'type'	=> "textarea",
		);
		
		// CSS
		$of_options[] = array(	'name'	=> esc_html__( 'Custom CSS', 'earth' ),
			'type'	=> 'heading'
		);
			
		$of_options[] = array(	'name'	=> esc_html__( 'Custom CSS', 'earth' ),
			'desc'	=> '',
			'id'	=> 'custom_css',
			'std'	=> '',
			"rows"	=> '55',
			'type'	=> 'css',
		);
		
		// OTHER				
		$of_options[] = array(
			'name'	=> esc_html__( 'Other', 'earth' ),
			'type'	=> 'heading'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Highlights', 'earth' ),
			'id'	=> 'highlights',
			'desc'	=> esc_html__( 'Enable or disable the built-in Highlights post type. Refresh your browser after altering this setting.', 'earth' ),
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable', 'earth' ),
			'off'	=> esc_html__( 'Disable', 'earth' ),
			'type'	=> 'switch',
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'FAQs Post Type', 'earth' ),
			'id'	=> 'faqs',
			'desc'	=> esc_html__( 'Enable or disable the built-in faqs post type. Refresh your browser after altering this setting.', 'earth' ),
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable', 'earth' ),
			'off'	=> esc_html__( 'Disable', 'earth' ),
			'type'	=> 'switch',
		);

		$of_options[] = array( 'name'	=> esc_html__( 'Retina Support', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable or disable retina support. Disable to save server space.', 'earth' ),
			'id'	=> "retina",
			'std'	=> '0',
			'on'	=> esc_html__( 'Enable', 'earth' ),
			'off'	=> esc_html__( 'Disable', 'earth' ),
			'type'	=> 'switch'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Menu Dropdown Arrows', 'earth' ),
			'desc'	=> esc_html__( 'Select to show or hide the dropdown arrows in the main menu.', 'earth' ),
			'id'	=> "menu_arrows",
			'std'	=> '1',
			'on'	=> esc_html__( 'Show', 'earth' ),
			'off'	=> esc_html__( 'Hide', 'earth' ),
			'type'	=> 'switch'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Comments On Blog Posts', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable/disable comments on blog posts.', 'earth' ),
			'id'	=> "enable_disable_blog_comments",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Comments On Galleries', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable/disable comments on single gallery posts.', 'earth' ),
			'id'	=> "enable_disable_gallery_comments",
			'std'	=> '1',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Comments On Pages', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable/disable comments on regular pages.', 'earth' ),
			'id'	=> "enable_disable_page_comments",
			'std'	=> '0',
			'on'	=> esc_html__( 'Enable','earth' ),
			'off'	=> esc_html__( 'Disable','earth' ),
			'type'	=> 'switch'
		);

		$of_options[] = array(
			'name'	=> esc_html__( 'Google API Key', 'earth' ),
			'desc'	=> esc_html__( 'Select to enable/disable comments on regular pages.', 'earth' ),
			'id'	=> "google_api_key",
			'type'	=> 'text'
		);
			
		// BACKUP
		$of_options[] = array(
			'name'	=> esc_html__( 'Backup', 'earth' ),
			'type'	=> 'heading'
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Backup and Restore Option', 'earth' ),
			'id'	=> "of_backup",
			'std'	=> '',
			'type'	=> "backup",
			'desc'	=> esc_html__( 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'earth' ),
		);
		
		$of_options[] = array(
			'name'	=> esc_html__( 'Transfer Theme Options Data', 'earth' ),
			'id'	=> "of_transfer",
			'std'	=> '',
			'type'	=> "transfer",
			'desc'	=> esc_html__( 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options.', 'earth' ),
		);
				
	}
}
add_action( 'init', 'of_options' );