<?php
/**
 * Author Archive
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 3.6.0
 */ ?>

</main>
	
<footer id="footer">
	<div id="footer-widget-wrap" class="clr">
		<div class="et-row clr">
			<div id="footer-widget-first" class="et-col span_1_of_4"><?php dynamic_sidebar( 'footer-widget-first' ); ?></div>
			<div id="footer-widget-second" class="et-col span_1_of_4"><?php dynamic_sidebar( 'footer-widget-second' ); ?></div>
			<div id="footer-widget-third" class="et-col span_1_of_4"><?php dynamic_sidebar( 'footer-widget-third' ); ?></div>
			<div id="footer-widget-fourth" class="et-col span_1_of_4"><?php dynamic_sidebar( 'footer-widget-fourth' ); ?></div>
		</div>
	</div>
	<div id="footer-botttom" class="clr">
		<div id="footer-copyright">
			<?php if ( $copy = earth_get_option( 'custom_copyright' ) ) { ?>
				<?php echo wp_kses_post( $copy ); ?>
			<?php } else { ?>
				 <p><?php esc_html_e( 'Copyright', 'earth' ); ?> <?php echo date('Y'); ?></p>
			<?php } ?>
		</div>
		<div id="footer-menu">
			<?php wp_nav_menu( array(
				'container'      => false,
				'theme_location' => 'footer_menu',
				'sort_column'    => 'menu_order',
				'fallback_cb'    => ''
			) ); ?>
		</div>
	</div>
</footer>
		
</div><?php // End wrapper that starts in header.php ?>
	
<a href="#toplink" class="backup" title="<?php esc_html_e('scroll up','earth'); ?>"><span class="fa fa-chevron-up"></span></a>

<?php wp_footer(); ?>
</body>
</html>