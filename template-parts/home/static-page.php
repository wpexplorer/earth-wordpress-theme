<?php
/**
 * Home Static Page
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page = earth_get_option( 'home_static_page', '-' );
if ( $page !== '-' && $page !== 'Select a page:' ) {
	$page = get_page_by_path( $page );
	$page_id = $page->ID; ?>
    <div id="home-static-page" class="et-fitvids clearfix">
        <?php if ( earth_get_option( 'home_static_page_title' ) !== '' ) { ?>
            <h2 class="heading"><?php echo earth_get_option( 'home_static_page_title' ); ?></h2>
        <?php }
        //show page content
        $page = new WP_Query( array(
            'post_type'		=> 'page',
            'page_id'		=> $page_id,
            'showposts'		=> '1',
            'no_found_rows'	=> true,
        ) );
       foreach( $page->posts as $post ) : setup_postdata( $post );
			$content = get_the_content();
			echo apply_filters( 'the_content', $content );
		endforeach; ?>
        <?php wp_reset_postdata(); ?>
    </div>
<?php } wp_reset_postdata(); ?>