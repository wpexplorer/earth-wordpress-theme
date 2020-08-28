<?php
/**
 * 404 Template
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 3.6.0
 */
get_header(); ?>
<div id="error-page" class="post full-width clr">
	<h1 id="error-page-title">404</h1>
	<p id="error-page-text"><?php esc_html_e('Unfortunately, the page you tried accessing could not be retrieved. Please visit the','earth'); ?> <a href="<?php echo home_url() ?>/" title="<?php esc_attr( bloginfo( 'name' ) ); ?>" rel="home"><?php esc_html_e('homepage','earth'); ?></a>.</p>
</div>
<?php get_footer(); ?>