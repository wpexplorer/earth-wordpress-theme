<?php
/**
 * Template Name: Gallery With Filter
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

get_header(); ?>

<?php
// Loop start
while ( have_posts() ) : the_post();

	// Load required scripts
	wp_enqueue_script( 'isotope' );
	wp_enqueue_script( 'isotope-gallery' ); ?>

	<?php
	// Display page header
	if ( get_post_meta( get_the_ID(), 'earth_page_title', true ) !== 'Disable' ) { ?>
		<header id="page-heading" class="clr"><h1>
			<?php the_title(); ?></h1>
			<?php earth_breadcrumbs(); ?>
		</header>
	<?php } ?>
	
	<div class="post full-width clr">
		
		<?php if ( get_the_content() ) { ?>
			<div id="gallery-description" class="clr"><?php the_content(); ?></div>
		<?php } ?>
		
		<?php 
		//get meta to set parent category
		$gallery_filter_parent	= '';
		$gallery_parent			= get_post_meta( get_the_ID(), 'earth_gallery_parent', true );
		$gallery_filter_parent	= ( $gallery_parent != 'select_gallery_parent' && $gallery_parent != 'none' ) ? $gallery_parent : NULL;
				
		//get gallery categories
		$cats = get_terms( 'gallery_cats', array (
			'hide_empty'	=> '1',
			'child_of'		=> $gallery_filter_parent
		) );
		
		//show filter if categories exist
		if ( ! empty( $cats ) ) { ?>

			<ul id="gallery-cats" class="filter clr">
				<li><a href="#" class="active" data-filter="*"><span><?php esc_html_e( 'All', 'earth' ); ?></span></a></li>
				<?php foreach ($cats as $cat ) : ?>
					<li><a href="#" data-filter=".<?php echo 'cat-'. $cat->term_id; ?>"><span><?php echo esc_html( $cat->name ); ?></span></a></li>
				<?php endforeach; ?>
			</ul>

		<?php } ?>
		
		<div id="gallery-wrap" class="et-row clr">
		   <?php
			// Query args
			$args = array(
				'post_type'       => 'gallery',
				'posts_per_page'  => -1,
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

			// Loop through gallery items
			while ( have_posts() ) : the_post();
				
				earth_get_template_part( 'gallery/entry', 'loop-gallery' );
			
			endwhile; ?>

		</div>
		
		<?php wp_reset_query(); ?>
		<?php wp_reset_postdata(); ?>
	
	</div>
	
<?php endwhile; ?>

<?php get_footer(); ?>