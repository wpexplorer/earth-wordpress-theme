<?php
/**
 * Gallery Categories
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

<header id="page-heading">
	<h1><?php echo single_term_title(); ?></h1>
	<?php earth_breadcrumbs(); ?>
</header>

<div class="post full-width clr">
	
	<?php if ( $description = term_description() ) { ?>
		<div id="gallery-description"><?php echo do_shortcode( wp_kses_post( $description ) ); ?></div>
	<?php } ?>
	
	<div id="gallery-wrap" class="et-row clr">
		<?php
		$count=0;
		while ( have_posts() ) : the_post();
			$count++;
			earth_get_template_part( 'gallery/entry', 'loop-gallery' );
			if ( $count == '4' ) {
				echo '<div class="clear"></div>';
				$count=0;
		}
		endwhile; ?>
	</div>
	
	<div id="gallery-pagination"><?php earth_pagination(); ?></div>
		
	<?php wp_reset_query(); ?>
	
</div>

<?php get_footer(); ?>