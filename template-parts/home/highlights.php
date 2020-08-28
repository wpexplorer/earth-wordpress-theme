<?php
/**
 * Home highlights
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
$hp_highlights = new WP_Query( array(
	'post_type'      => 'hp_highlights',
	'order'          => 'DESC',
	'orderby'        => 'date',
	'posts_per_page' => '-1',
	'no_found_rows'  => true,
) );

//show highlights
if ( $hp_highlights->have_posts() ) : ?>

	<section id="home-highlights" class="et-fitvids et-row clr">
		<?php $count=0; ?>
		<?php while ( $hp_highlights->have_posts() ) : $hp_highlights->the_post();
			$count++;
			$url = get_post_meta( get_the_ID(), 'earth_hp_highlights_url', TRUE ); ?>
			<div id="post-<?php the_ID(); ?>" class="hp-highlight span_1_of_3 et-col et-col-<?php echo esc_attr( $count ); ?>">
				<?php if ( $url ) { ?>
					<h2 class="heading"><a href="<?php echo esc_url( $url ); ?>" title="<?php earth_esc_title(); ?>"><?php the_title(); ?></a></h2>
				<?php } else { ?>
					<h2 class="heading"><?php the_title(); ?></h2>
				<?php } ?>
				<div class="hp-highlight-details clr">
					<?php if ( has_post_thumbnail() ) {
						$dims = apply_filters( 'earth_highlight_img_dims', array(
							'width'  => 525,
							'height' => 300,
							'crop'   => true,
						) );
						if ( $url ) { ?>
							<div class="hp-highlight-media clr">
								<a href="<?php echo esc_url( $url ); ?>" title="<?php earth_esc_title(); ?>" class="styled-img">
									<?php echo earth_get_post_thumbnail( $dims ); ?>
									<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
								</a>
							</div>
						<?php } else { ?>
							<div class="hp-highlight-media clr">
								<div class="styled-img">
									<?php echo earth_get_post_thumbnail( $dims ); ?>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<div class="hp-highlight-content clr">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
			<?php if ( $count == '3' ) {
				$count=0;
			} ?>
		<?php endwhile; ?>
	</section>

<?php endif; ?>

<?php wp_reset_postdata(); ?>
