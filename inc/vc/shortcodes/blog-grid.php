<?php
// Blog Grid Shortcode
if ( ! function_exists( 'blog_grid_shortcode' ) ) {

	function blog_grid_shortcode( $atts ) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
			'unique_id'				=> '',
			'term_slug'				=> '',
			'include_categories'	=> '',
			'exclude_categories'	=> '',
			'columns'				=> '4',
			'posts_per_page'		=> '12',
			'order'					=> 'ASC',
			'orderby'				=> 'date',
			'date'					=> 'true',
			'excerpt'				=> 'true',
			'excerpt_length'		=> '20',
			'pagination'			=> 'false',
			'filter_content'		=> 'false',
			'offset'				=> 0,
			'img_width'				=> '9999',
			'img_height'			=> '9999',
			'img_crop'              => '',
		), $atts ) );

		ob_start();
		
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

		// Pagination var
		if ( 'true' == $pagination ) {
			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} else if ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}
		} else {
			$paged = NULL;
		}
		
		// The Query
		$wpex_query = new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => $posts_per_page,
			'paged'          => $paged,
			'offset'         => $offset ? $offset : false,
			'order'          => $order,
			'orderby'        => $orderby,
			'tax_query'      => array(
				'relation'   => 'AND',
				$include_categories,
				$exclude_categories,
			),
		) );

		//Output posts
		if ( $wpex_query->posts ) : ?>

			<div class="blog-grid clearfix et-row" id="<?php echo esc_attr( $unique_id ); ?>">
				<?php
				$count=0;
				// Start loop
				while ( $wpex_query->have_posts() ) : $wpex_query->the_post();
					$count++; ?>
					<div class="blog-grid-entry clr et-col span_1_of_<?php echo esc_attr( $columns ); ?> et-col-<?php echo esc_attr( $count ); ?>">
						<?php if ( has_post_thumbnail() ) { ?>
							<div class="blog-grid-entry-thumbnail clearfix">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="styled-img">
									<?php echo earth_get_post_thumbnail( array(
										'width'  => $img_width,
										'height' => $img_height,
										'crop'   => ( $img_height == 9999 && ! $img_crop ) ? false : $img_crop,
									) ); ?>
									<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
								</a>
							</div>
						<?php } ?>
						<h3 class="blog-grid-entry-title">
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a>
						</h3>
						<?php if ( 'false' != $date ) {?>
							<div class="blog-grid-entry-date clearfix">
								<span class="fa fa-clock-o"></span><?php echo get_the_date(); ?>
							</div>
						<?php } ?>
						<div class="blog-grid-entry-excerpt clearfix">
							<?php if ( has_excerpt( get_the_ID() ) ) {
								$content = $post->post_excerpt;
							} else {
								echo wp_trim_words(
									strip_shortcodes( get_the_content() ),
									$excerpt_length,
									'...'
								);
							} ?>
						</div>
					</div>
				<?php
				if ( $count == $columns ) {
					$count = 0;
				}
				endwhile; ?>
			</div>
			
			<?php
			// Paginate Posts
			if ( 'true' == $pagination ) {
				$total = $wpex_query->max_num_pages;
				$big = 999999999;
				if ( $total > 1 )  {
					if ( $current_page = get_query_var( 'paged' ) ) {
						$current_page = $current_page;
					} elseif ( $current_page = get_query_var( 'page' ) ) {
						$current_page = $current_page;
					} else {
						$current_page = 1;
					}
					if ( get_option( 'permalink_structure' ) ) {
						if ( is_page() ) {
							$format = 'page/%#%/';
						} else {
							$format = '/%#%/';
						}
					} else {
						$format = '&paged=%#%';
					}
					echo paginate_links( array(
						'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'    => $format,
						'current'   => max( 1, $current_page ),
						'total'     => $total,
						'mid_size'  => 2,
						'type'      => 'list',
						'prev_text' => '<i class="fa fa-angle-left"></i>',
						'next_text' => '<i class="fa fa-angle-right"></i>',
					) );
				}
			}
		
		// End has posts check
		endif;

		// Set things back to normal
		wp_reset_postdata();

		return ob_get_clean();
		
	}
}
add_shortcode( 'blog_grid', 'blog_grid_shortcode' );

// Add to Visual Composer
if ( ! function_exists( 'blog_grid_vcmap' ) ) {
	function blog_grid_vcmap() {
		return array(
			'name' => esc_html__( 'Blog Grid', 'earth' ),
			'description' => esc_html__( 'Recent posts in grid format.', 'earth' ),
			'base' => 'blog_grid',
			'category' => 'Earth',
			'icon' => 'earth-vc-icon fa fa-file-text-o',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Unique Id', 'earth' ),
					'param_name' => 'unique_id',
					'value' => '',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Columns', 'earth' ),
					'param_name' => 'columns',
					'std' => '4', // required
					'value' => array(
						'4' =>'4',
						'3'	=>'3',
						'2'	=>'2',
						'1' =>'1',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order By', 'earth' ),
					'param_name' => 'orderby',
					'value' => array(
						esc_html__( 'Date', 'earth' ) => 'date',
						esc_html__( 'Name', 'earth' ) => 'name',
						esc_html__( 'Modified', 'earth' ) => 'modified',
						esc_html__( 'Author', 'earth' ) => 'author',
						esc_html__( 'Random', 'earth' ) => 'rand',
						esc_html__( 'Comment Count', 'earth' ) => 'comment_count',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order', 'earth' ),
					'param_name' => 'order',
					'value' => array(
						esc_html__( 'ASC', 'earth' ) => 'ASC',
						esc_html__( 'DESC', 'earth' ) => 'DESC',
					),
				),
				array(
					'type' => 'textfield',
					'class' => '',
					'heading' => esc_html__( 'Include Categories', 'earth' ),
					'param_name' => 'include_categories',
					'admin_label' => true,
					'value' => '',
					'description' => esc_html__('Enter the slugs of a categories (comma seperated) to pull posts from or enter "all" to pull recent posts from all categories. Example: category-1, category-2.','earth'),
				),
				array(
					'type' => 'textfield',
					'class' => '',
					'heading' => esc_html__( 'Exclude Categories', 'earth' ),
					'param_name' => 'exclude_categories',
					'admin_label' => true,
					'value' => '',
					'description' => esc_html__('Enter the slugs of a categories (comma seperated) to exclude. Example: category-1, category-2.','earth'),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Posts Per Page', 'earth' ),
					'param_name' => 'posts_per_page',
					'value' => '12',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Pagination', 'earth' ),
					'param_name' => 'pagination',
					'value' => array(
						esc_html__( 'No', 'earth' ) => 'false',
						esc_html__( 'Yes', 'earth' ) => 'true',
					),
					'description' => esc_html__('Paginate posts? Important: Pagination will not work on your homepage because of how WordPress works.','earth' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Date', 'earth' ),
					'param_name' => 'date',
					'value' => array(
						esc_html__( 'Yes', 'earth' ) => 'true',
						esc_html__( 'No', 'earth' )	=> 'false',
					),
					'group' => esc_html__( 'Description', 'earth' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Excerpt', 'earth' ),
					'param_name' => 'excerpt',
					'value' => array(
						esc_html__( 'Yes', 'earth' ) => 'true',
						esc_html__( 'No', 'earth' )	=> 'false',
					),
					'group' => esc_html__( 'Description', 'earth' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Excerpt Length', 'earth' ),
					'param_name' => 'excerpt_length',
					'value' => '20',
					'group' => esc_html__( 'Description', 'earth' ),
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
vc_lean_map( 'blog_grid', 'blog_grid_vcmap' );