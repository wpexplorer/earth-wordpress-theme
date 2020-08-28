<?php
/**
 * Single Gallery
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

get_header(); ?>

	<div class="post full-width et-fitvids clr">

		<?php while ( have_posts() ) : the_post(); ?>

			<header id="page-heading">
				<h1><?php the_title(); ?></h1>
				<?php earth_breadcrumbs(); ?>
			</header>

			<article id="single-gallery" class="clr">
				<?php
				// Get images
				$attachments = wpex_get_gallery_ids();
				if ( ! $attachments && apply_filters( 'earth_gallery_attachments_fallback', true ) ) {
					$get_attachments = get_children( array(
						'post_parent'    => get_the_ID(),
						'post_type'      => 'attachment',
						'post_mime_type' => 'image'
					) );
					if ( $get_attachments ) {
						foreach ( $get_attachments as $attachment ) {
							$attachments[] = $attachment->ID;
						}
					}
				}
				// If images exist lets display them
				if ( $attachments && ! post_password_required() ) { ?>
					<div id="single-gallery-media" class="earth-lightbox-gallery clr et-row">
						<?php
						// Loop through attachments
						$count=0;
						$columns = intval( earth_get_option( 'gallery_post_columns', 4 ) );
						$columns = $columns ? $columns : 4;
						foreach ( $attachments as $attachment ) :
							if ( 'attachment' != get_post_type( $attachment ) ) {
								continue;
							}
							$dims = apply_filters( 'earth_single_gallery_img_dims', array(
								'width'  => earth_get_option( 'gallery_post_thumb_width', 210 ),
								'height' => earth_get_option( 'gallery_post_thumb_height', 170 ),
								'crop'   => earth_get_option( 'gallery_post_thumb_crop', true ),
							) );
							$count++;
							$alt = get_post_meta( $attachment, '_wp_attachment_image_alt', true );
							$alt = $alt ? $alt : get_the_title( $attachment ); ?>
							<div class="et-col span_1_of_<?php echo esc_attr( $columns ); ?> clr">
								<a href="<?php echo wp_get_attachment_url( $attachment ); ?>" title="<?php echo esc_attr( $alt ); ?>" class="styled-img">
									<?php echo earth_get_attachment_thumbnail( $attachment, $dims ); ?>
									<div class="img-overlay"><span class="fa fa-search"></span></div>
								</a>
							</div>
							<?php
							// Clear floats
							if ( $count == $columns ) {
								echo '<div class="clear"></div>';
								$count = 0;
							} ?>
						<?php endforeach; ?>
					</div>
				<?php } ?>
				<div id="single-gallery-content"><?php the_content(); ?></div>
				<?php
				// Display comments
				if ( earth_get_option( 'enable_disable_gallery_comments', '1' ) ) {
					comments_template();
				} ?>
			</article>
		<?php endwhile; ?>
	</div>
<?php get_footer(); ?>