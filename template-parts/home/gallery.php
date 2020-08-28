<?php
/**
 * Home gallery
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Query args
$args = array(
	'post_type'		 => 'gallery',
	'posts_per_page' => earth_get_option( 'home_gallery_count' ),
	'no_found_rows'	 => true,
	'meta_key'       => '_thumbnail_id',
);

// Get and set Gallery category
$cat = earth_get_option( 'home_gallery_cat' );
if ( $cat != 'Select' && $cat !== '-' ) {
	$args['tax_query'] = array( array(
		'taxonomy'	=> 'gallery_cats',
		'field'		=> 'slug',
		'terms'		=> $cat
	) );
}

// Query Posts
$gallery_posts = new WP_Query( $args );

// Show section if posts exist
if ( $gallery_posts ) {

	// Section title
	$wpex_section_title = '';
	if ( earth_get_option( 'home_blog_title' ) ) {
		$wpex_section_title = earth_get_option( 'home_gallery_title' );
	} else {
		$wpex_section_title = esc_html__( 'Recent Galleries', 'earth' );
	} ?>

	<div id="recent-photos" class="clr">

		<?php if ( 'disable' != $wpex_section_title ) { ?>
			<h2 class="heading">
				<?php
				// Title link
				if ( earth_get_option( 'home_gallery_title_link' ) ) { ?>
					<a href="<?php echo esc_url( earth_get_option( 'home_gallery_title_link' ) ); ?>" title="<?php echo esc_attr( $wpex_section_title ); ?>">
				<?php }
				// Title text
				echo esc_html( $wpex_section_title );
				// Close link tag
				if ( earth_get_option( 'home_gallery_title_link' ) ) {
					echo '</a>';
				} ?>
			</h2>
		<?php } ?>

		<div class="et-row et-gap-10 clr">
			<?php
			$count=0;
			while ( $gallery_posts->have_posts() ) : $gallery_posts->the_post(); ?>
				<?php if ( has_post_thumbnail() ) {
					$dims = apply_filters( 'earth_home_gallery_img_dims', array(
						'width'  => 120,
						'height' => 100,
						'crop'   => true,
					) );
					$count++; ?>
					<div class="et-col span_1_of_10 et-col-<?php echo esc_attr( $count ); ?>">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="recent-photo tipsy-tooltip styled-img">
							<?php echo earth_get_post_thumbnail( $dims ); ?>
							<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
						</a>
					</div>
					<?php if ( 10 == $count ) $count = 0; ?>
				<?php } ?>
			<?php endwhile;  ?>
		</div>

	</div>

<?php } ?>

<?php wp_reset_postdata(); ?>