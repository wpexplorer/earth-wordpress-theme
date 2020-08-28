<?php
/**
 * Immage attachment page
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

<div id="page-heading" class="clr">
	<h1><?php the_title(); ?></h1>
	<?php earth_breadcrumbs(); ?>
</div>

<div class="post full-width clr">
    <div class="entry clr">
	<div id="img-attch-page">
		<a href="<?php echo esc_url( wp_get_attachment_url( $post->ID, 'full-size' ) ); ?>" class="view">
			<?php echo wp_get_attachment_image( get_the_ID(), 'full' ); ?>
		</a>
        </div>
	</div>
</div>
            
<?php get_footer(); ?>