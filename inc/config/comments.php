<?php
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments
 * template simply create your own wpex_comment(), and that function
 * will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @package Earth WordPress Theme
 * @subpackage Functions
 * @version 3.7.0
 *
 * @todo deprecrate and use native WP output
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function earth_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 50 ); ?>
			</div><!-- .comment-author -->
			
			<div class="comment-details clr">
			
				<header class="comment-meta">
					<cite class="fn"><?php comment_author_link(); ?></cite>
					<br />
					<div class="comment-date">
					<?php
						printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							sprintf( _x( '%1$s at %2$s', '1: date, 2: time', 'earth' ), get_comment_date(), get_comment_time() )
						);
						edit_comment_link( esc_html__( 'Edit', 'earth' ), ' <span class="edit-link">', '<span>' ); ?>
					</div><!-- .comment-date -->
				</header><!-- .comment-meta -->
	
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'earth' ); ?></p>
				<?php endif; ?>
	
				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->
	
				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'reply to comment', 'earth' ) . ' &rarr;', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
				
			</div><!-- .comment-details -->
			
		</article><!-- #comment-## -->
	<?php
}

// Deprecated
if ( ! function_exists( 'wpex_comment' ) ) {
	function wpex_comment( $comment, $args, $depth ) {
		return earth_comment( $comment, $args, $depth );
	}
}