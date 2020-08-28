<?php
/**
 * Home single gallery
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slug = earth_get_option( 'home_gallery_single_slug', '-' );

if ( '-' != $slug && $slug ) : ?>

	<?php
	//get post type ==> gallery
	$gallery_posts = new WP_Query( array(
		'post_type'	     => 'gallery',
		'name'		     => earth_get_option( 'home_gallery_single_slug' ),
		'posts_per_page' => '1',
	) );

	// Section title
	$heading = '';
	if ( earth_get_option( 'home_gallery_single_title' ) ) {
		$heading = earth_get_option( 'home_gallery_single_title' );
	} else {
		$heading = esc_html__('Featured Gallery','earth');
	}

	// Loop through posts
	foreach( $gallery_posts->posts as $post ) : setup_postdata( $post ); ?>
		<div id="recent-photos" class="clr">
		<?php if ( 'disable' != $heading ) { ?>
			<h2 class="heading">
				<?php
				// Title link
				if ( earth_get_option( 'home_gallery_single_title_link' ) ) { ?>
					<a href="<?php echo esc_url( earth_get_option( 'home_gallery_single_title_link' ) ); ?>" title="<?php echo esc_attr( $heading ); ?>">
				<?php }
				// Title text
				echo esc_html( $heading );
				// Close link tag
				if ( 'disable' != earth_get_option( 'home_gallery_single_title' ) ) {
					 echo '</a>';
				} ?>
			</h2>
		<?php } ?>
			<div class="earth-lightbox-gallery et-row et-gap-10 clr">
				<?php
				$attachments = wpex_get_gallery_ids();
				if ( $attachments ) :
					$count = 0;
					foreach( $attachments as $attachment ) :
						$dims = apply_filters( 'earth_home_gallery_img_dims', array(
							'width'  => 120,
							'height' => 100,
							'crop'   => true,
						) );
						if ( 'attachment' == get_post_type( $attachment ) ) {
							$count ++;
							$alt = get_post_meta( $attachment, '_wp_attachment_image_alt', true );
							$alt = $alt ? $alt : get_the_title( $attachment ); ?>
							<div class="et-col span_1_of_10 et-count-<?php esc_attr( $count ); ?> clr">
								<a href="<?php echo wp_get_attachment_url( $attachment ); ?>" title="<?php echo esc_attr( $alt ); ?>" class="recent-photo styled-img">
									<?php echo earth_get_attachment_thumbnail( $attachment, $dims ); ?>
									<div class="img-overlay"><span class="fa fa-search"></span></div>
								</a>
							</div>
						<?php } ?>
						<?php if ( 10 == $count ) $count = 0; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>