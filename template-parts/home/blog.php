<?php
/**
 * Home Blog section
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

// Query args
$args = array(
	'post_type'      => 'post',
	'posts_per_page' => earth_get_option( 'home_blog_count' ),
	'no_found_rows'  => true,
);

// Get and set blog category
$home_cat = earth_get_option( 'home_blog_cat', '-' );
if ( $home_cat != '-' && $home_cat != 'Select' ) {
	$args['tax_query'] = array( array(
		'taxonomy'	=> 'category',
		'field' 	=> 'slug',
		'terms' 	=> $home_cat
	) );
}

// Get posts
$blog_posts = new WP_Query( $args );

// Display posts
if ( $blog_posts->have_posts() ) :

	// Section title
	$wpex_section_title = '';
	if ( earth_get_option( 'home_blog_title' ) ) {
		$wpex_section_title = earth_get_option( 'home_blog_title' );
	} else {
		$wpex_section_title = esc_html__('Recent Events','earth');
	} ?>
	<div id="recent-news" class="clearfix et-col span_1_of_2">
		<?php if ( 'disable' != $wpex_section_title ) { ?>
		<h2 class="heading">
			<?php
			// Title link
			$link = earth_get_option( 'home_blog_title_link' );
			if ( $link ) { ?>
				<a href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( $wpex_section_title ); ?>">
			<?php }
			// Title text
			echo esc_html( $wpex_section_title );
			if ( $link ) {
				echo '</a>';
			} ?>
		</h2>
		<?php } ?>
		<?php
		$count=0;
		while ( $blog_posts->have_posts() ) : $blog_posts->the_post();
			$count++; ?>
			<article class="recent-entry clearfix<?php if ( $count == earth_get_option( 'home_blog_count' ) ) { echo ' last-recent-entry'; } ?>">
				<?php if ( has_post_thumbnail() ) {
					$dims = apply_filters( 'earth_home_blog_img_dims', array(
						'width'  => 120,
						'height' => 100,
						'crop'   => true,
					) ); ?>
					<a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>" class="styled-img featured-image">
						<?php echo earth_get_post_thumbnail( $dims ); ?>
						<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
					</a>
				<?php } ?>
				<div class="recent-entry-content <?php if ( ! has_post_thumbnail() ) echo 'full-width'; ?>">
					<h3><a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>"><?php the_title(); ?></a></h3>
					<div class="entry-meta">
						<?php esc_html_e('Posted On ','earth'); ?> <?php echo get_the_date(); ?> <?php if ( comments_open() ) { ?> ~ <?php  comments_popup_link( esc_html__( '0 Comments', 'earth' ), esc_html__( '1 Comment', 'earth' ), esc_html__( '% Comments', 'earth' ) ); ?> <?php } ?>
					</div>
					<?php echo wp_trim_words( strip_shortcodes( get_the_content() ), 11, '...' ); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
	
<?php endif; ?>

<?php wp_reset_postdata(); ?>