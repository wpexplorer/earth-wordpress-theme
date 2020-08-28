<?php
// Galleries Shortcode
if ( ! function_exists( 'simple_galleries_shortcode' ) ) {

	function simple_galleries_shortcode($atts) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
				'unique_id' => '',
				'term_slug' => '',
				'include_categories' => '',
				'exclude_categories' => '',
				'columns' => '4',
				'posts_per_page' => '10',
				'order' => 'ASC',
				'orderby' => 'date',
				'title' => 'true',
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
				$term = get_term_by( 'slug', $key, 'gallery_cats' );
				if ( $term ) {
					$filter_cats_include[] = $term->term_id;
				}
			}
		}

		// Exclude categories
		$filter_cats_exclude = '';
		if ( $exclude_categories ) {
			$exclude_categories = explode( ',', $exclude_categories );
			if ( ! empty( $exclude_categories ) && is_array( $exclude_categories ) ) {
			$filter_cats_exclude = array();
			foreach ( $exclude_categories as $key ) {
				$term = get_term_by( 'slug', $key, 'gallery_cats' );
				if ( $term ) {
					$filter_cats_exclude[] = $term->term_id;
				}
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
					</ul><!-- .galleries-filter -->
				<?php } ?>
			<?php }

			// Unique ID
			if ( $unique_id ) {
				$unique_id = 'id="'. $unique_id .'"';
			}

			// Wrap classes
			$classes = 'simple-galleries clr et-row';
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
					$has_thumbnail = has_post_thumbnail();
					$classes = 'simple-galleries-photo clr et-col';
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
					}
					if ( 'true' == $title ) {
						$classes .= ' has-title';
					} ?>
					<?php if ( 'true' == $title || $has_thumbnail ) : ?>
						<div class="<?php echo esc_attr( $classes ); ?>">
							<?php if ( $has_thumbnail ) : ?>
								<a href="<?php the_permalink(); ?>" title="<?php earth_esc_title(); ?>" class="recent-gallery styled-img <?php if ( 'true' != $title) echo 'tipsy-tooltip'; ?>">
									<?php echo earth_get_post_thumbnail( array(
										'width'  => $img_width,
										'height' => $img_height,
										'crop'   => ( $img_height == 9999 && ! $img_crop ) ? false : $img_crop,
									) ); ?>
									<div class="img-overlay"><span class="fa fa-plus-circle"></span></div>
								</a>
							<?php endif; ?>
							<?php if ( 'true' == $title ) { ?>
								<div class="simple-galleries-photo-title heading"><?php the_title(); ?></div>
							<?php } ?>
						</div>
					<?php endif; ?>
				<?php
				if ( $count == $columns ) {
					$count = '';
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
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => $format,
						'current' => max( 1, get_query_var('paged') ),
						'total' => $total,
						'mid_size' => 2,
						'type' => 'list',
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
add_shortcode( "simple_galleries", "simple_galleries_shortcode" );

// Add to Visual Composer
vc_lean_map( 'simple_galleries', 'simple_galleries_vcmap' );
if ( ! function_exists( 'simple_galleries_vcmap' ) ) {
	function simple_galleries_vcmap() {
		return array(
			"name" => esc_html__( "Simple Galleries", 'earth' ),
			'description' => esc_html__( "Recent gallery posts (simple).", 'earth' ),
			"base" => "simple_galleries",
			'category' => "Earth",
			"icon" => "earth-vc-icon fa fa-picture-o",
			"params" => array(
				// General
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
					'std' => '4',
					"value" => array(
						'10' => '10',
						'9' => '9',
						'8' => '8',
						'7' => '7',
						'6' => '6',
						'5' => '5',
						'4' => '4',
						'3' => '3',
						'2' => '2',
						'1' => '1',
					),
					"std" => '4',
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Display Title", 'earth' ),
					'param_name' => "title",
					'value' => array(
						esc_html__( "Yes", "earth") => "true",
						esc_html__( "No", "earth" ) => "no",
					),
					'std' => 'true'
				),
				// Query
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Order By", 'earth' ),
					'param_name' => "orderby",
					'description' => sprintf( esc_html__( 'Select how to sort retrieved posts. More at %s.', 'earth' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
					'value' => array(
						esc_html__( "Date", "earth") => "date",
						esc_html__( "Name", "earth" ) => "name",
						esc_html__( "Modified", "earth") => "modified",
						esc_html__( "Author", "earth" ) => "author",
						esc_html__( "Random", "earth") => "rand",
						esc_html__( "Comment Count", "earth" ) => "comment_count",
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
					'value' => "10",
					'description' => esc_html__( "How many posts do you wish to show?", 'earth' ),
				),
				array(
					'type' => "dropdown",
					"heading" => esc_html__( "Pagination", 'earth' ),
					'param_name' => "pagination",
					'value' => array(
						esc_html__( "No", "earth") => "false",
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
				// Image settings
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