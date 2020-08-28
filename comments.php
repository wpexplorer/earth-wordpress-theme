 <?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments and the comment
 * form. The actual display of comments is handled by a callback to
 * wpex_comment() which is located at functions/comments-callback.php
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

// Display if comments are open or there is at least 1 comment
if ( comments_open() || get_comments_number() > 0 ) { ?>

	<div class="leaf-divider">
		<?php if ( earth_get_option( 'divider_icon' ) !== 'None' ) { ?>
			<span class="fa fa-<?php echo earth_get_option( 'divider_icon' ); ?>"></span>
		<?php } ?>
	</div>

	<?php if ( is_singular( 'post' ) ) { ?>
	
		<div class="entry-left">
			<h3 class="comments-title">
				<span class="fa fa-comments"></span><?php comments_number( esc_html__( '0 Comments', 'earth' ), esc_html__( '1 Comment', 'earth' ), esc_html__( '% Comments', 'earth' ) );?>
			</h3>
		</div>

	<?php } else { ?>
		
		<h3 class="page-comments-title">
			<?php comments_number( esc_html__( '0 Comments', 'earth' ), esc_html__( '1 Comment', 'earth' ), esc_html__( '% Comments', 'earth' ) );?>
		</h3>

	<?php } ?>

 	<div class="clearfix <?php if ( is_singular( 'post' ) ) echo 'entry-right'; ?>">
		<section id="comments" class="comments-area clearfix <?php if ( ! comments_open() && get_comments_number() < 1 ) echo 'empty-closed-comments'; ?>">

			<?php if ( have_comments() ) : ?>

				<ol class="comment-list">
					<?php wp_list_comments( array( 'callback' => 'earth_comment', 'style' => 'ol' ) ); ?>
				</ol>

				<?php
				// Are there comments to navigate through?
				if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

					<nav class="navigation comment-navigation row clr" role="navigation">
						<h4 class="assistive-text section-heading heading"><span><?php esc_html_e( 'Comment navigation', 'earth' ); ?></span></h4>
						<div class="nav-previous span_12 col clr-margin"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'earth' ) ); ?></div>
						<div class="nav-next span_12 col"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'earth' ) ); ?></div>
					</nav>
				
				<?php endif; // Check for comment navigation ?>
				
				<?php if ( ! comments_open() && get_comments_number() ) : ?>
					<p class="no-comments"><i class="fa fa-times-circle"></i><?php esc_html_e( 'Comments are closed.' , 'earth' ); ?></p>
				<?php endif; ?>

			<?php endif; // have_comments() ?>

			<?php comment_form(); ?>

		</section>
		
	</div>

<?php } ?>