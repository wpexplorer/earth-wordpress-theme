<?php
/**
 * Blog entry
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wpex_cats = get_the_category(); ?>

<article class="loop-entry clr">
	<?php if ( '1' == earth_get_option( 'blog_style', '1' ) ) { ?>
		<div class="loop-entry-left"> 
			<section class="post-meta clr">
				<ul>
					<li class="meta-date"><span class="fa fa-calendar"></span><?php echo get_the_date(); ?></li>    
					<?php if ($wpex_cats[0]){ ?>
						<li class="meta-category"><span class="fa fa-folder-open"></span><a href="<?php echo get_category_link($wpex_cats[0]->term_id ); ?>" title="<?php echo esc_attr( $wpex_cats[0]->cat_name ); ?>"><?php echo esc_html( $wpex_cats[0]->cat_name ); ?></a></li>
					<?php } ?>
					<?php if ( comments_open() ) { ?>
						<li class="meta-comments"><span class="fa fa-comment"></span><?php comments_popup_link( esc_html__( '0 Comments', 'earth' ), esc_html__( '1 Comment', 'earth' ), esc_html__( '% Comments', 'earth' ) ) ?></li>
					<?php } ?>
					<li class="meta-author"><span class="fa fa-user"></span><?php the_author_posts_link(); ?></li>
				</ul>
			</section>
		</div>
	<?php } ?>
	<div class="loop-entry-right clr <?php if ( earth_get_option( 'blog_style', '1' ) == '2' ) echo 'full-width'; ?>">
		<h2><a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>"><?php the_title(); ?></a></h2>
		<?php
		// Blog style 2 meta
		if ( '2' == earth_get_option( 'blog_style', '1' ) ) { ?>
			<div class="blog-style-two-meta clr">
				<span class="blog-style-two-meta-date"><?php esc_html_e( 'Published on', 'earth' ); ?> <?php echo get_the_date(); ?></span>
				<?php if ($wpex_cats[0]){ ?>
					<span class="blog-style-two-meta-category"><?php esc_html_e( 'under', 'earth' ); ?> <a href="<?php echo get_category_link($wpex_cats[0]->term_id ); ?>" title="<?php echo esc_attr( $wpex_cats[0]->cat_name ); ?>"><?php echo esc_html( $wpex_cats[0]->cat_name ); ?></a></span>
				<?php } ?>
			</div>
		<?php } ?>
		<?php
		//  Video embed
		if ( $embed = get_post_meta( get_the_ID(), 'earth_post_oembed', true ) ) { ?>
			<div class="blog-oembed clr"><div class="responsive-embed-wrap clr"><?php echo wp_oembed_get( $embed ); ?></div></div>
		<?php
		// Featured image
		} elseif ( earth_get_option( 'enable_disable_post_image' ) !== 'disable' &&  earth_get_option( 'enable_disable_entry_image', '1' ) !== '0' && has_post_thumbnail() ) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>" class="loop-entry-thumbnail styled-img">
				<?php echo earth_get_post_thumbnail( 'entry' ); ?>
				<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
			</a>
		<?php } ?>
		<?php
		// Excerpt
		if ( earth_get_option( 'blog_excerpt', '1' ) == '1' ) {
			earth_excerpt( earth_get_option( 'blog_excerpt_length', '35' ), false );
			echo '<div class="clear"></div><a href="'. get_permalink( $post->ID ) . '" class="read-more">'. esc_html__( 'continue reading','earth' ) .'</a>';
		} else {
			the_content();
		} ?>
	</div>
</article>

<div class="leaf-divider">
	<?php
	$icon = earth_get_option( 'divider_icon' );
	if ( $icon && 'None' != $icon ) { ?>
		<span class="fa fa-<?php echo esc_attr( $icon ); ?>"></span>
	<?php } ?>
</div>