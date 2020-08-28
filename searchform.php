<?php
/**
 * Searchform template
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 3.6.0
 */ ?>

<form method="get" id="searchbar" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" size="16" name="s" value="" id="search" />
	<input type="submit" value="<?php esc_html_e( 'Search', 'earth' ); ?>" id="searchsubmit" />
</form>