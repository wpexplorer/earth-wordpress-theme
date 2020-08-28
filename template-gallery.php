<?php
/**
 * Template Name: Gallery
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php if ( get_post_meta( get_the_ID(), 'earth_page_title', true ) !== 'Disable' ) { ?>
		<header id="page-heading" class="clr">
			<h1><?php the_title(); ?></h1>
			<?php earth_breadcrumbs(); ?>
		</header>
	<?php } ?>
	
	<div class="post full-width clr">
	
		<?php if ( get_the_content() ) { ?>
			<div id="gallery-description" class="clr"><?php the_content(); ?></div>
		<?php } ?>
		
		<div id="gallery-wrap" class="et-row clr">
			<?php
			//get meta to set parent category
			$gallery_filter_parent = '';
			$gallery_parent = get_post_meta($post->ID, 'earth_gallery_parent', true);
			$gallery_filter_parent = ( $gallery_parent !== 'select_gallery_parent' && $gallery_parent !== 'none' ) ? $gallery_parent : $gallery_filter_parent = NULL;

			// Query args
			$args = array(
				'post_type'       => 'gallery',
				'posts_per_page'  => 12,
				'paged'           => $paged,
				'supress_filters' => false,
			);

			// Tax query
			if ( $gallery_filter_parent ) {
				$args['tax_query'] = array( array(
					'taxonomy'	=> 'gallery_cats',
					'field' 	=> 'id',
					'terms' 	=> $gallery_filter_parent
				) );
			}
			
			// Get post type ==> gallery
			query_posts( $args );
			
			//start loop
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
		
		<div id="gallery-pagination" class="clr"><?php earth_pagination(); ?></div>
		
		<?php wp_reset_query(); ?>
		
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>