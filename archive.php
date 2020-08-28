<?php
/**
 * Standard Archive Template
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>
	
	<header id="page-heading" class="clr">
		<h1><?php if ( is_day() ) :
			printf( esc_html__( 'Daily Archives: %s', 'earth' ), get_the_date() );
		elseif ( is_month() ) :
			printf( esc_html__( 'Monthly Archives: %s', 'earth' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'earth' ) ) );
		elseif ( is_year() ) :
			printf( esc_html__( 'Yearly Archives: %s', 'earth' ), get_the_date( _x( 'Y', 'yearly archives date format', 'earth' ) ) );
		else :
			the_archive_title();
		endif;
		?></h1>
		<?php earth_breadcrumbs(); ?>
	</header>

	<section class="post et-fitvids clearfix">
		
		<?php
		// Archive description
		if ( $description = term_description() ) : ?>

			<div id="archive-description"><?php echo wp_kses_post( $description ); ?></div>
			<div class="leaf-divider">
				<?php
				// Divider icon
				$icon = earth_get_option( 'divider_icon' );
				if ( $icon && 'None' != $icon ) { ?>
					<span class="fa fa-<?php echo esc_attr( $icon ); ?>"></span>
				<?php } ?>
			</div>

		<?php endif; ?>

		<div class="loop-wrap clr">
			<?php
			// Loop through posts and get entry output file
			// See template-parts/post-entry.php
			while ( have_posts() ) : the_post();
				earth_get_template_part( 'post-entry' );
			endwhile; ?>
		</div><!-- .loop-wrap -->

		<?php earth_pagination(); ?>

	</section>

<?php endif; ?>

<?php get_sidebar(); ?>	  
<?php get_footer(); ?>