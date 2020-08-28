<?php
/**
 * Template Name: FAQs - By Category
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php
	// Display post thumbnail if enabled
	if ( has_post_thumbnail() ) : ?>

		<div id="page-featured-image">
			<?php earth_post_thumbnail( 'page', array(
				'alt' => earth_get_esc_title(),
			) ); ?>
		</div><!-- #page-featured-image -->

	<?php endif; ?>

	<?php
	// Display page title unless disabled
	if ( 'Disable' != get_post_meta( get_the_ID(), 'earth_page_title', true ) ) : ?>

		<header id="page-heading" class="clr">
			<h1><?php the_title(); ?></h1>
			<?php earth_breadcrumbs(); ?>
		</header><!-- #page-heading -->

	<?php endif; ?>
	
	<div id="faqs-wrap" class="post clr">  
	
		<?php
		// Display post content
		if ( get_the_content() ) : ?>

			<div id="faqs-description" class="clr">
				<?php the_content(); ?>
			</div><!-- #faqs-description -->

		<?php endif; ?>
		
		<?php
		// Load FAQ toggle script
		wp_enqueue_script( 'earth-faqs' );

		$terms = get_terms( 'faq_cats','orderby=custom_sort&hide_empty=1');

		if ( ! empty( $terms ) && is_array( $terms ) ) :

			foreach( $terms as $term ) : ?>
			
				<h2 class="faqs-topic-title"><span><?php echo esc_html( $term->name ); ?></span></h2>
				
				<div class="faqs-topic clr">

					<?php
					// Query terms
					$tax_query = array( array(
						'taxonomy'	=> 'faq_cats',
						'terms'		=> $term->slug,
						'field'		=> 'slug'
					) );

					// Query posts from each term
					global $post;
					$term_post_args = array(
						'post_type'		  => 'faqs',
						'numberposts'	  => '-1',
						'tax_query'		  => $tax_query,
						'supress_filters' => false,
					);

					$term_posts = get_posts( $term_post_args );

					// If posts are found lets show them
					if ( $term_posts ) :
						
						// Loop through posts
						foreach ( $term_posts as $post ) : setup_postdata( $post );

							// Get entry template part
							earth_get_template_part( 'faqs/entry', 'loop-faq' );

						endforeach;

					endif;

					wp_reset_postdata(); ?>

				</div><!-- .faqs-topic -->
				
			<?php endforeach; ?>

		<?php endif; ?>

		<?php wp_reset_postdata(); ?>
		
	</div><!-- #faqs-wrap -->
	
<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>