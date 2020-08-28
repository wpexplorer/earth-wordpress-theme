<?php
/**
 * Gallery Post Type Archive
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

	<header id="page-heading" class="clr">
		<h1><?php post_type_archive_title(); ?></h1>
		<?php earth_breadcrumbs(); ?>
	</header>

	<div class="post full-width clr">   
		<?php if ( get_the_content() ) { ?>
			<div id="gallery-description" class="clr"><?php the_content(); ?></div>
		<?php } ?>
		<div id="gallery-wrap" class="clr et-row">
			<?php
			$count=0;
			while ( have_posts() ) : the_post();
				$count++;
				earth_get_template_part( 'gallery/entry', 'loop-gallery' );
				if ( 4 == $count ) {
					echo '<div class="clear"></div>';
					$count=0;
				}
			endwhile; ?>
		</div>
		<div id="gallery-pagination"><?php earth_pagination(); ?></div>
	</div>
	
<?php get_footer(); ?>