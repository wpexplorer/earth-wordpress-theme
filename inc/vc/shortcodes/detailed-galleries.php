<?php
// Add Gallery shortcode
if ( ! function_exists( 'detailed_galleries_shortcode' ) ) {

	function detailed_galleries_shortcode($atts) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
			'unique_id' => '',
			'term_slug' => '',
			'include_categories' => '',
			'exclude_categories' => '',
			'columns' => '4',
			'posts_per_page' => '12',
			'order' => 'ASC',
			'orderby' => 'date',
			'excerpt' => 'true',
			'excerpt_length' => '20',
			'pagination' => 'false',
			'filter_content' => 'false',
			'offset' => 0,
			'img_width' => '9999',
			'img_height' => '9999',
			'img_crop' => '',
			'filter' => '',
			'center_filter' => '',
			'all_text' => '',
		), $atts ) );

		ob_start();
			
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
				$key = get_term_by( 'slug', $key, 'gallery_cats' );
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
				$key = get_term_by( 'slug', $key, 'gallery_cats' );
				$filter_cats_exclude[] = $key->term_id;
			}
			$exclude_categories = array(
				'taxonomy'	=> 'gallery_cats',
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
				'taxonomy'	=> 'gallery_cats',
				'field'		=> 'slug',
				'terms'		=> $include_categories,
				'operator'	=> 'IN',
			);
		} else {
			$include_categories = '';
		}
		
		// The Query
		$wpex_query = new WP_Query( array(
			'post_type'			=> 'gallery',
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

			// Inline js for the front-end
			vc_front_end_inline_isotope_js();

			// Display filter links
			if ( 'true' == $filter && taxonomy_exists( 'gallery_cats' ) ) {
				// Load js
				wp_enqueue_script( 'isotope-vc-galleries' );
				// Unique ID
				$unique_id = $unique_id ? $unique_id : 'simple-galleries-'. rand( 1, 100 );
				// Get the terms for the filter
				$terms = get_terms( 'gallery_cats', array(
					'include'	=> $filter_cats_include,
					'exclude'	=> $filter_cats_exclude,
				) );
				// Display filter only if terms exist and there is more then 1
				if ( $terms && count( $terms ) > '1') {
					// Center filter links
					$center_filter = 'yes' == $center_filter ? 'center' : '';
					// All text
					if ( $all_text ) {
						$all_text = $all_text;
					} else {
						$all_text = esc_html__( 'All', 'earth' );
					} ?>
					<ul class="galleries-filter filter-<?php echo esc_attr( $unique_id ); ?> vcex-filter-links <?php echo esc_attr( $center_filter ); ?> clr">
						<li class="active"><a href="#" data-filter="*"><span><?php echo esc_html( $all_text ); ?></span></a></li>
						<?php foreach ( $terms as $term ) : ?>
							<li><a href="#" data-filter=".cat-<?php echo esc_attr( $term->term_id ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php } ?>
			<?php }

			// Unique ID
			if ( $unique_id ) {
				$unique_id = 'id="'. $unique_id .'"';
			}

			// Wrap classes
			$classes = 'detailed-galleries clr et-row';
			$classes .= ' cols-'. $columns;
			if ( 'true' == $filter ) {
				$classes .= ' isotope-grid';
			} ?>

			<div class="<?php echo esc_attr( $classes ); ?>" <?php echo esc_attr( $unique_id ); ?>>
				<?php
				$count=0;
				// Start loop
				foreach ( $wpex_query->posts as $post ) : setup_postdata( $post );
					$count++;
					$classes = 'detailed-gallery-entry clr et-col';
					$classes .= ' span_1_of_'. $columns;
					$classes .= ' et-col-'. $count;
					if ( 'true' == $filter ) {
						$classes .= ' isotope-entry';
						$post_terms = get_the_terms( $post, 'gallery_cats' );
						if ( $post_terms ) {
							foreach ( $post_terms as $post_term ) {
								$classes .= ' cat-'. $post_term->term_id;
							}
						}
					} ?>
					<div class="<?php echo esc_attr( $classes ); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="detailed-gallery-entry-thumbnail clearfix">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="styled-img">
									<?php echo earth_get_post_thumbnail( array(
										'width'  => $img_width,
										'height' => $img_height,
										'crop'   => ( $img_height == 9999 && ! $img_crop ) ? false : $img_crop,
									) ); ?>
									<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
								</a>
							</div>
						<?php endif; ?>
						<h3 class="detailed-gallery-entry-title">
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a>
						</h3>
						<?php if ( 'true' == $excerpt ) : ?>
							<div class="detailed-gallery-entry-excerpt clearfix">
								<?php if ( has_excerpt( get_the_ID() ) ) {
									$content = $post->post_excerpt;
								} else {
									echo wp_trim_words( strip_shortcodes( get_the_content() ), $excerpt_length, '...' );
								} ?>
							</div>
						<?php endif; ?>
					</div>
				<?php
				if ( $count == $columns ) {
					$count = 0;
				}
				endforeach; ?>
			</div>
			
			<?php
			// Paginate Posts
			if ( $pagination == 'true' ) {
				$total = $wpex_query->max_num_pages;
				$big = 999999999;
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

		// End has posts check
		endif;

		// Set things back to normal
		wp_reset_postdata();
		
	return ob_get_clean();
		
	}
}
add_shortcode( "detailed_galleries", "detailed_galleries_shortcode" );

// Add to Visual Composer
if ( ! function_exists( 'detailed_galleries_vcmap' ) ) {
	function detailed_galleries_vcmap() {
		return array(
			"name" => esc_html__( "Detailed Galleries", 'earth' ),
			'description' => esc_html__( "Recent gallery posts (with details).", 'earth' ),
			"base" => "detailed_galleries",
			'category' => "Earth",
			"icon" => "earth-vc-icon fa fa-picture-o",
			"params" => array(
				array(
					'type' => "textfield",
					"heading" => esc_html__( "Unique Id", 'earth' ),
					'param_name' => "unique_id",
					'value' => "",
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Columns", 'earth' ),
					"param_name" => "columns",
					"value" => array(
						'4' =>'4',
						'3' =>'3',
						'2' =>'2',
						'1' =>'1',
					),
				),
				// Query
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Order By", 'earth' ),
					'param_name' => "orderby",
					'description' => sprintf( esc_html__( 'Select how to sort retrieved posts. More at %s.', 'earth' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
					'value' => array(
						esc_html__( "Date", "earth") => "date",
						esc_html__( "Name", "earth" )  => "name",
						esc_html__( "Modified", "earth") => "modified",
						esc_html__( "Author", "earth" ) => "author",
						esc_html__( "Random", "earth") => "rand",
						esc_html__( "Comment Count", "earth" )  => "comment_count",
					),
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Order", 'earth' ),
					'param_name' => "order",
					'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'earth' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
					'value' => array(
						esc_html__( "ASC", "earth" ) => "ASC",
						esc_html__( "DESC", "earth") => "DESC",
					),
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Include Categories", 'earth' ),
					"param_name" => "include_categories",
					"admin_label" => true,
					"value" => "",
					"description" => esc_html__('Enter the slugs of a categories (comma seperated) to pull posts from or enter "all" to pull recent posts from all categories. Example: category-1, category-2.','earth'),
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Exclude Categories", 'earth' ),
					"param_name" => "exclude_categories",
					"admin_label" => true,
					"value" => "",
					"description" => esc_html__('Enter the slugs of a categories (comma seperated) to exclude. Example: category-1, category-2.','earth'),
				),
				array(
					'type' => "textfield",
					"heading" => esc_html__( "Posts Per Page", 'earth' ),
					'param_name' => "posts_per_page",
					'value' => "12",
					'description' => esc_html__( "How many posts do you wish to show?", 'earth' ),
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Pagination", 'earth' ),
					'param_name' => "pagination",
					'value' => array(
						esc_html__( "No", "earth")  => "false",
						esc_html__( "Yes", "earth" ) => "true",
					),
					'description' => esc_html__("Paginate posts? Important: Pagination will not work on your homepage because of how WordPress works.","earth"),
				),
				// Filter
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Category Filter", 'earth' ),
					'param_name' => "filter",
					'value' => array(
						esc_html__( "No", "earth" ) => "",
						esc_html__( "Yes", "earth") => "true",
					),
					'group' => esc_html__( 'Filter', 'earth' ),
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Center Filter Links", 'earth' ),
					'param_name' => "center_filter",
					'value' => array(
						esc_html__( 'No', 'earth' ) => '',
						esc_html__( 'Yes', 'earth' ) => 'yes',
					),
					'group' => esc_html__( 'Filter', 'earth' ),
				),
				array(
					'type' => "textfield",
					"heading" => esc_html__( 'Custom Category Filter "All" Text', 'earth' ),
					'param_name' => "all_text",
					'value' => '',
					'group' => esc_html__( 'Filter', 'earth' ),
				),
				// Description
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Excerpt", 'earth' ),
					'param_name' => "excerpt",
					'value' => array(
						esc_html__( "Yes", "earth") => "true",
						esc_html__( "No", "earth" ) => "false",
					),
					'group' => esc_html__( 'Description', 'earth' ),
				),
				array(
					'type' => "textfield",
					"heading" => esc_html__( "Excerpt Length", 'earth' ),
					'param_name' => "excerpt_length",
					'value' => "20",
					'group' => esc_html__( 'Description', 'earth' ),
					'dependency' => array( 'element' => 'excerpt', 'value' => 'true' ),
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
vc_lean_map( 'detailed_galleries', 'detailed_galleries_vcmap' );