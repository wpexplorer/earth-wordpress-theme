<?php
/**
 * Gallery entry
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get gallery terms
$terms = get_the_terms( get_the_ID(), 'gallery_cats' ); ?>

<article class="gallery-entry et-col span_1_of_4 <?php if ( $terms ) foreach ( $terms as $term ) echo 'cat-'. $term->term_id .' '; ?>">
	<?php if ( has_post_thumbnail() ) { ?>
		<a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>" class="styled-img">
			<?php echo earth_get_post_thumbnail( 'gallery_entry' ); ?>
			<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
		</a>
	<?php } ?>
	<div class="gallery-entry-content">
		<h2 class="heading"><a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>"><?php the_title(); ?></a></h2>
	</div>
</article>