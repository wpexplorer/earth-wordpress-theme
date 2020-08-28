<?php
/**
 * Template Name: All Gallery Photos
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php if ( get_post_meta( get_the_ID(), 'earth_page_title', true ) !== 'Disable' ) { ?>
		<header id="page-heading" class="clr">
			<h1><?php the_title(); ?></h1>
			<?php earth_breadcrumbs(); ?>
		</header>
	<?php } ?>
	
	<div class="post full-width clearfix">
	
		<?php if ( get_the_content() ) { ?>
			<div id="gallery-description" class="clearfix"><?php the_content(); ?></div>
		<?php } ?>
		
		<div id="all-gallery-photos" class="earth-lightbox-gallery et-row clr">
			<?php query_posts( array(
				'post_type'        => 'gallery',
				'posts_per_page'   => '-1',
				'no_found_rows'    => true,
				'suppress_filters' => false,
			) );
			
			//start loop
			$count=0;
			while ( have_posts() ) : the_post();
				$attachments = wpex_get_gallery_ids();
				if ( $attachments ) {
					foreach ( $attachments as $attachment ) :
						$attachment_meta = wpex_get_attachment( $attachment );
						$width  = earth_get_option( 'gallery_entry_thumb_width', 210 );
						$height = earth_get_option( 'gallery_entry_thumb_height', 170 );
						$crop   = earth_get_option( 'gallery_entry_thumb_crop', true );
						$crop   = $height == '9999' ? false : $crop; ?>
						<?php if ( 'attachment' == get_post_type( $attachment ) ) {
							$count++; ?>
							<div class="et-col et-col-<?php echo esc_attr( $count ); ?> span_1_of_4">
								<a href="<?php echo wp_get_attachment_url( $attachment ); ?>" title="<?php echo esc_attr( $attachment_meta['title'] ); ?>" class="styled-img">
									<?php echo earth_get_attachment_thumbnail( $attachment, array(
										'width'  => $width,
										'height' => $height,
										'crop'   => $crop,
									) ); ?>
									<div class="img-overlay"><span class="fa fa-search"></span></div>
								</a>
							</div>
						<?php } ?>
					<?php
					if ( '4' == $count ) {
						$count=0;
					}
					endforeach;
				}
			endwhile; ?>
		</div>
		
		<div id="gallery-pagination" class="clr"><?php earth_pagination(); ?></div>
		
		<?php wp_reset_query(); ?>
		
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>