<?php
/**
 * Single Posts
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post();

	// Get post categories
	$categories = ( 'post' == get_post_type() ) ? get_the_category() : ''; ?>

	<header id="page-heading" class="clr">
		<?php
		// Get heading
		$heading = earth_get_option( 'blog_single_heading' ) ? earth_get_option( 'blog_single_heading' ) : esc_html_e( 'News', 'earth' );
		if ( earth_get_option( 'blog_single_heading_term_name' ) ) {
			$heading = earth_get_first_term_name();
		}
		// Display heading
		echo esc_html( $heading ); ?>
		<?php earth_breadcrumbs(); ?>
	</header><!-- #page-heading -->

	<article class="post clr et-fitvids">

		<div class="entry clr">
			
			<?php
			// Blog style 1
			if ( '1' == earth_get_option( 'blog_style', '1' ) ) : ?>

				<div class="entry-left">
					<section class="post-meta clr">
						<ul>
							<li class="meta-date"><span class="fa fa-calendar"></span><?php echo get_the_date(); ?></li>
							<?php
							// Display categories in meta if enabled and there are categories to display
							if ( $categories && ! empty( $categories[0] ) ) { ?>
								<li class="meta-category"><span class="fa fa-folder-open"></span><a href="<?php echo get_category_link($categories[0]->term_id ); ?>" title="<?php echo esc_attr( $categories[0]->cat_name ); ?>"><?php echo esc_html( $categories[0]->cat_name ); ?></a></li>
							<?php } ?>
							<?php
							// Display comment count in meta if comments are enabled
							if ( comments_open() ) { ?>
								<li class="meta-comments"><span class="fa fa-comment"></span><?php comments_popup_link( esc_html__( '0 Comments', 'earth' ), esc_html__( '1 Comment', 'earth' ), esc_html__( '% Comments', 'earth' ) ) ?></li>
							<?php } ?>
							<li class="meta-author"><span class="fa fa-user"></span><?php the_author_posts_link(); ?></li>
						</ul>
					</section><!-- .post-meta -->
				</div><!-- .entry-left -->

			<?php endif; ?>

			<div class="entry-right clr <?php if ( earth_get_option( 'blog_style', '1' ) == '2' ) echo 'full-width'; ?>">
				
				<h1 id="post-title"><?php the_title(); ?></h1>
				
				<?php
				// Blog style 2 meta
				if ( '2' == earth_get_option( 'blog_style', '1' ) ) : ?>
					
					<div class="blog-style-two-meta clr">
						<span class="blog-style-two-meta-date"><?php esc_html_e( 'Published on', 'earth' ); ?> <?php echo get_the_date(); ?></span>
						<?php
						// Display categories in meta if enabled and there are categories to display
						if ( $categories && ! empty( $categories[0] ) ) { ?>
							<span class="blog-style-two-meta-category"><?php esc_html_e( 'under', 'earth' ); ?> <a href="<?php echo get_category_link($categories[0]->term_id ); ?>" title="<?php echo esc_attr( $categories[0]->cat_name ); ?>"><?php echo esc_html( $categories[0]->cat_name ); ?></a></span>
						<?php } ?>
					</div>

				<?php endif; ?>

				<?php
				// Display post video if defiend
				if ( $embed = get_post_meta( get_the_ID(), 'earth_post_oembed', true ) ) { ?>

					<div class="blog-oembed clr">
						<div class="responsive-embed-wrap clr"><?php echo wp_oembed_get( $embed ); ?></div>
					</div><!-- .blog-oembed -->

				<?php
				// Display post featured image if enabled and defined
				} elseif ( 'disable' !== earth_get_option( 'enable_disable_post_image' )
					&& earth_get_option( 'enable_disable_post_image', true )
					&& has_post_thumbnail()
				) { ?>
					<div id="post-thumbnail">
						<?php
						// Add lightbox to post thumbnail if enabled
						if ( earth_get_option( 'post_image_lightbox' , true ) ) { ?>
							<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" class="earth-lightbox styled-img" title="<?php earth_esc_title(); ?>">
						<?php } ?>
							<?php
							// Display post thumbnail
							earth_post_thumbnail( 'post', array(
								'alt' => earth_get_esc_title(),
							) ); ?>
						<?php
						// Add overlay icon hover if lightbox is enabled
						if ( earth_get_option( 'post_image_lightbox' , true ) ) { ?>
							<div class="img-overlay"><span class="fa fa-search"></span></div><!-- magnifying hover -->
						</a>
						<?php } ?>
					</div>

				<?php } ?>

				<?php
				// Display post main content
				the_content(); ?>
				
				<div class="clear"></div>

				<?php
				// Edit post link
				edit_post_link( __( 'Edit This', 'earth' ), '<div id="post-edit-links" class="clr">', '</div>' ); ?>
			
				<?php
				// Post pagination
				wp_link_pages( 'before=<div id="post-page-navigation" class="clr">&after=</div>&link_before=<span>&link_after=</span>' ); ?>
				
				<?php
				// Post tags
				the_tags( '<div id="post-tags" class="clr"><strong>'. esc_html__( 'Tagged:', 'earth' ) .'</strong> ', ' , ', '</div>' ); ?>

		</div><!-- .entry -->
		
		<div class="clear"></div>
 
		<?php
		/*-----------------------------------------------------------------------------------*/
		/*	Related Posts
		/*-----------------------------------------------------------------------------------*/
		if ( earth_get_option( 'related_posts', '1' ) ) :

			$cats = wp_get_post_terms( get_the_ID(), 'category' ); //get post categories
			
			$first_cat = $cats[0]->term_id;

			if ( ! empty( $cats[1]) ) {
				$second_cat = $cats[1]->term_id;
			}  else {
				$second_cat = NULL;
			}
			if ( ! empty( $cats[2] ) ) {
				$third_cat = $cats[2]->term_id;
			} else {
				$third_cat = NULL;
			}

			// Get posts
			$related_posts = new WP_Query( array(
				'posts_per_page' => '3',
				'orderby'        => 'rand',
				'exclude'        => get_the_ID(),
				'no_found_rows'	 => true,
				'tax_query'      => array(
					'relation'	=> 'OR',
					array(
						'taxonomy'	=> 'category',
						'terms' 	=> $first_cat,
						'field'		=> 'id',
						'operator'	=> 'IN',
					),
					array(
						'taxonomy'	=> 'category',
						'terms' 	=> $second_cat,
						'field'		=> 'id',
						'operator'	=> 'IN',
					),
					array(
						'taxonomy'	=> 'category',
						'terms' 	=> $third_cat,
						'field'		=> 'id',
						'operator'	=> 'IN',
					)
				)
			) );

			// Display posts
			if ( $related_posts->have_posts() ) : ?>

				<div class="leaf-divider">
					<?php if ( earth_get_option( 'divider_icon' ) !== 'None' ) { ?>
						<span class="fa fa-<?php echo esc_attr( earth_get_option( 'divider_icon' ) ); ?>"></span>
					<?php } ?>
				</div><!-- .leaf-divider -->

				<section id="related-posts">
					
					<div class="entry-left">
						<h2><span class="fa fa-pencil"></span><?php esc_html_e( 'Related Articles', 'earth' ); ?></h2>
					</div><!-- .entry-left -->

					<div class="entry-right">
						
						<?php
						// Loop through related posts
						while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
						
							<article class="related-entry clr">
								
								<?php
								// Display related entry featured image
								if ( has_post_thumbnail() ) { ?>
									<div class="featured-image">
										<a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>" class="styled-img">
											<?php
											// Display related post thumbnail
											earth_post_thumbnail( 'standard_post_related', array(
												'alt' => earth_get_esc_title(),
											) ); ?>
											<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
										</a>
									</div><!-- .featured-image -->
								<?php } ?>

								<div class="related-entry-content <?php if ( !has_post_thumbnail() ) echo 'full-width'; ?>">
									<h3><a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>"><?php the_title(); ?></a></h3>
									<div class="entry-meta">
										<?php esc_html_e( 'Posted On ', 'earth' ); ?> <?php echo get_the_date(); ?><?php if ( comments_open() ) { ?> ~ <?php  comments_popup_link( esc_html__( '0 Comments', 'earth' ), esc_html__( '1 Comment', 'earth' ), esc_html__( '% Comments', 'earth' ) ) ?><?php } ?>
									</div><!-- .entry-meta -->
									<?php
									// Display related post excerpt
									echo earth_excerpt( '25' ); ?>
								</div><!-- .related-entry-content -->

							</article>

						<?php endwhile; ?>

						<?php wp_reset_postdata(); ?>
					</div><!-- .entry-right -->

				</section><!-- #related-posts -->

			<?php endif; ?>

		<?php endif; ?>
		
		</div>

		<?php
		// Display comments if enabled
		if ( earth_get_option( 'enable_disable_blog_comments', true ) ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>
	
	</article>

<?php endwhile;  ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>