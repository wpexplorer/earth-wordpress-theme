<?php
/**
 * Default Template
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

    <div class="post et-fitvids clearfix">
        <?php if ( have_posts() ) : ?>
			<div class="loop-wrap clr">
				<?php
				// Loop through posts and get entry output file
				// See template-parts/post-entry.php
				while ( have_posts() ) : the_post();
					earth_get_template_part( 'post-entry' );
				endwhile; ?>
			</div><!-- .loop-wrap -->
			<?php earth_pagination(); ?>
        <?php endif; ?>
    </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>