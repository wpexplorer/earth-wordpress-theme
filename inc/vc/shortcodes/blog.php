<?php
// Blog Shortcode
if ( ! function_exists( 'blog_shortcode' ) ) {

	function blog_shortcode($atts) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
				'unique_id'				=> '',
				'term_slug'				=> '',
				'include_categories'	=> '',
				'exclude_categories'	=> '',
				'posts_per_page'		=> '4',
				'order'					=> 'ASC',
				'orderby'				=> 'date',
				'excerpt'				=> 'true',
				'excerpt_length'		=> '30',
				'pagination'			=> 'false',
				'filter_content'		=> 'false',
				'offset'				=> 0,
				'img_width'				=> '120',
				'img_height'			=> '100',
				'img_crop'              => '',
			), $atts));
			
		// Get global $post
		global $post;
		
		// Pagination var
		if ( $pagination == 'true' ) {
			global $paged;
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		} else {
			$paged = NULL;
		}

		// Include categories
		$include_categories = ( '' != $include_categories ) ? $include_categories : $term_slug;
		$include_categories = ( 'all' == $include_categories ) ? '' : $include_categories;
		$filter_cats_include = '';
		if ( $include_categories ) {
			$include_categories = explode( ',', $include_categories );
			$filter_cats_include = array();
			foreach ( $include_categories as $key ) {
				$key = get_term_by( 'slug', $key, 'category' );
				$filter_cats_include[] = $key->term_id;
			}
		}

		// Exclude categories
		$filter_cats_exclude = '';
		if ( $exclude_categories ) {
			$exclude_categories = explode( ',', $exclude_categories );
			if ( ! empty( $exclude_categories ) && is_array( $exclude_categories ) ) {
			$filter_cats_exclude = array();
			foreach ( $exclude_categories as $key ) {
				$key = get_term_by( 'slug', $key, 'category' );
				$filter_cats_exclude[] = $key->term_id;
			}
			$exclude_categories = array(
				'taxonomy'	=> 'category',
				'field'		=> 'slug',
				'terms'		=> $exclude_categories,
				'operator'	=> 'NOT IN',
			);
			} else {
				$exclude_categories = '';
			}
		}
		
		// Start Tax Query
		if ( ! empty( $include_categories ) && is_array( $include_categories ) ) {
			$include_categories = array(
				'taxonomy'	=> 'category',
				'field'		=> 'slug',
				'terms'		=> $include_categories,
				'operator'	=> 'IN',
			);
		} else {
			$include_categories = '';
		}
		
		// The Query
		$wpex_query = new WP_Query( array(
			'post_type'			=> 'post',
			'posts_per_page'	=> $posts_per_page,
			'offset'			=> $offset,
			'filter_content'	=> $filter_content,
			'paged'				=> $paged,
			'oder'				=> $order,
			'orderby'			=> $orderby,
			'tax_query'			=> array(
				'relation'		=> 'AND',
				$include_categories,
				$exclude_categories,
			),
		) );

		//Output posts
		if ( $wpex_query->posts ) :
			ob_start(); ?>

				<div class="recent-posts" id="<?php echo esc_attr( $unique_id ); ?>">
					<?php
					// Start loop
					foreach ( $wpex_query->posts as $post ) : setup_postdata( $post ); ?>
						<article class="recent-post-entry clearfix <?php if ( ! has_post_thumbnail() ) echo 'no-thumbnail'; ?>">
							<?php if ( has_post_thumbnail() ) { ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="styled-img featured-image">
									<?php echo earth_get_post_thumbnail( array(
										'width'  => $img_width,
										'height' => $img_height,
										'crop'   => ( $img_height == 9999 && ! $img_crop ) ? false : $img_crop,
									) ); ?>
									<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
								</a>
							<?php } ?>
							<div class="recent-post-entry-content">
								<h3 class="recent-post-entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
								<div class="entry-meta">
									<?php esc_html_e('Posted On ','earth'); ?> <?php echo get_the_date(); ?> <?php if ( comments_open() ) { ?> ~ <?php  comments_popup_link( esc_html__( '0 Comments', 'earth' ), esc_html__( '1 Comment', 'earth' ), esc_html__( '% Comments', 'earth' ) ); ?> <?php } ?>
								</div><!-- /entry-meta -->
								<?php if ( 'false' != $excerpt ) {
									echo wp_trim_words( strip_shortcodes( get_the_content() ), $excerpt_length, '...' );
								} ?>
							</div><!-- /recent-post-entry-content -->
						</article><!-- /recent-post-entry -->
					<?php endforeach; ?>
				</div><!-- .wpex-blog-grid -->
				
				<?php
				// Paginate Posts
				if ( $pagination == 'true' ) {
					$total = $wpex_query->max_num_pages;
					$big = 999999999; // need an unlikely integer
					if ( $total > 1 )  {
						if ( !$current_page = get_query_var('paged') )
							 $current_page = 1;
						if ( get_option('permalink_structure') ) {
							 $format = 'page/%#%/';
						} else {
							 $format = '&paged=%#%';
						}
						echo paginate_links(array(
							'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format'		=> $format,
							'current'		=> max( 1, get_query_var('paged') ),
							'total'			=> $total,
							'mid_size'		=> 2,
							'type'			=> 'list',
							'prev_text'		=> '<i class="fa fa-angle-left"></i>',
							'next_text'		=> '<i class="fa fa-angle-right"></i>',
						) );
					}
				}
				
			// Set things back to normal
			wp_reset_postdata();
		
			return ob_get_clean();
			
			endif; // End has posts check
		
	}
}
add_shortcode( "blog", "blog_shortcode" );

// Add to Visual Composer
if ( ! function_exists( 'earth_blog_vcmap' ) ) {
	function earth_blog_vcmap() {
		return array(
			"name"					=> esc_html__( "Blog", 'earth' ),
			'description'			=> esc_html__( "Recent blog posts.", 'earth' ),
			"base"					=> "blog",
			'category'				=> "Earth",
			"icon"					=> "earth-vc-icon fa fa-file-text-o",
			"params"				=> array(
				array(
					'type'			=> "textfield",
					"heading"		=> esc_html__( "Unique Id", 'earth' ),
					'param_name'	=> "unique_id",
					'value'			=> "",
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> esc_html__( "Order By", 'earth' ),
					'param_name'	=> "orderby",
					'description'	=> sprintf( esc_html__( 'Select how to sort retrieved posts. More at %s.', 'earth' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
					'value'			=> array(
						esc_html__( "Date", "earth")		=> "date",
						esc_html__( "Name", "earth" )			=> "name",
						esc_html__( "Modified", "earth")			=> "modified",
						esc_html__( "Author", "earth" )			=> "author",
						esc_html__( "Random", "earth")			=> "rand",
						esc_html__( "Comment Count", "earth" )	=> "comment_count",
					),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> esc_html__( "Order", 'earth' ),
					'param_name'	=> "order",
					'description'	=> sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'earth' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
					'value'			=> array(
						esc_html__( "ASC", "earth" )	=> "ASC",
						esc_html__( "DESC", "earth")	=> "DESC",
					),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> esc_html__( "Include Categories", 'earth' ),
					"param_name"	=> "include_categories",
					"admin_label"	=> true,
					"value"			=> "",
					"description"	=> esc_html__('Enter the slugs of a categories (comma seperated) to pull posts from or enter "all" to pull recent posts from all categories. Example: category-1, category-2.','earth'),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> esc_html__( "Exclude Categories", 'earth' ),
					"param_name"	=> "exclude_categories",
					"admin_label"	=> true,
					"value"			=> "",
					"description"	=> esc_html__('Enter the slugs of a categories (comma seperated) to exclude. Example: category-1, category-2.','earth'),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> esc_html__( "Posts Per Page", 'earth' ),
					'param_name'	=> "posts_per_page",
					'value'			=> "4",
					'description'	=> esc_html__( "How many posts do you wish to show?", 'earth' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> esc_html__( "Pagination", 'earth' ),
					'param_name'	=> "pagination",
					'value'			=> array(
						esc_html__( "No", "earth")	=> "false",
						esc_html__( "Yes", "earth" )	=> "true",
					),
					'description'	=> esc_html__("Paginate posts? Important: Pagination will not work on your homepage because of how WordPress works.","earth"),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> esc_html__( "Excerpt", 'earth' ),
					'param_name'	=> "excerpt",
					'value'			=> array(
						esc_html__( "Yes", "earth")	=> "true",
						esc_html__( "No", "earth" )	=> "false",
					),
					'group'			=> esc_html__( 'Excerpt', 'earth' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> esc_html__( "Excerpt Length", 'earth' ),
					'param_name'	=> "excerpt_length",
					'value'			=> "30",
					'group'			=> esc_html__( 'Excerpt', 'earth' ),
				),
				array(
					'type' => 'textfield',
					'class' => '',
					'heading' => esc_html__( 'Image Width', 'earth' ),
					'param_name' => 'img_width',
					'value' => '9999',
					'group' => esc_html__( 'Image', 'earth' ),
				),
				array(
					'type' => 'textfield',
					'class' => '',
					'heading' => esc_html__( 'Image Height', 'earth' ),
					'param_name' => 'img_height',
					'value' => '9999',
					'group' => esc_html__( 'Image', 'earth' ),
				),
				array(
					'type' => 'dropdown',
					'class' => '',
					'heading' => esc_html__( 'Image Crop', 'earth' ),
					'param_name' => 'img_crop',
					'group' => esc_html__( 'Image', 'earth' ),
					'value' => earth_vc_image_crop_options(),
				),
			)
		);
	}
}
vc_lean_map( 'blog', 'earth_blog_vcmap' );