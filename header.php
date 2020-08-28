<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 3.7.0
 */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	// Add custom favicon
	if ( earth_get_option( 'custom_favicon' ) ) { ?>
		<link rel="icon" type="image/png" href="<?php echo earth_get_option( 'custom_favicon' ); ?>" />
	<?php } ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header id="masterhead" class="clr">
		
		<div id="logo">
			<?php
			// Custom Logo
			if ( $logo = earth_get_option( 'custom_logo' ) ) { ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home">
					<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
				</a>
			<?php
			// Text logo
			} else { ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home" class="text-logo"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
			<?php } ?>
		</div>

		<?php
		// Display social icons if enabled - see functions/social-output.php
		if ( earth_get_option( 'enable_disable_social','1' ) == '1' ) {
			earth_display_social();
		} ?>

		<?php
		// Display Donate button
		$donate_link = earth_get_option( 'callout_link' );
		if ( $donate_link && earth_get_option( 'header_donate', '1' ) == '1' ) { ?>

			<a href="<?php echo esc_url( $donate_link ); ?>" id="header-donate" title="<?php echo esc_attr( earth_get_option( 'callout_text' ) ); ?>" target="_<?php echo esc_attr( earth_get_option( 'callout_target' ) ); ?>">
				<div id="header-donate-inner">
					<?php
					// Donate icon
					$donate_icon = earth_get_option( 'callout_icon' );
					if ( $donate_icon && 'Select' != $donate_icon ) { ?>
						<span class="fa fa-<?php echo esc_attr( $donate_icon ); ?>"></span>
					<?php } ?>
					<?php echo wp_kses_post( earth_get_option( 'callout_text' ) ); ?>
				</div>
			</a>

		<?php } ?>

	</header>
	
	<div id="wrapper" class="clr">

		<main id="main" class="clr">

			<?php
			// Check for nav search
			$has_search = earth_get_option( 'disable_search' );
			$has_search = ( 'disable' != $has_search && '0' != $has_search ) ? true : false; ?>

			<nav id="mainnav" class="clr<?php if ( $has_search ) echo ' has-search'; ?>">
				<?php wp_nav_menu( array(
					'container_class' => 'mainnav-container clr',
					'theme_location'  => 'main_menu',
					'sort_column'     => 'menu_order',
					'menu_class'      => 'sf-menu clr'
				) );
				//show search box
				if ( $has_search ) {
					get_search_form();
				} ?>   
			</nav>

			<?php earth_page_slider() ?>
			<?php earth_post_oembed(); ?>