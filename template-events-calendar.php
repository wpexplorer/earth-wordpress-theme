<?php
/**
 * Template Name:  Events Calendar
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
	
		<div id="content-full-width" class="cf">
		
			<?php if ( get_post_meta( get_the_ID(), 'earth_page_title', true ) !== 'Disable' ) { ?>
				<header id="page-heading" class="clr">
					<h1><?php the_title(); ?></h1>
					<div id="ajax-loader"></div>
					<?php earth_breadcrumbs(); ?>
				</header>
			<?php } ?>
		
			<div id="page-<?php the_ID(); ?>" <?php post_class('single-page') ?>>
				<div class="the-content cf">
					<?php the_content(); ?>
					<input id="security" name="aq_nonce" type="hidden" value="<?php echo wp_create_nonce('events_calendar') ?>" />
					<div id="events_calendar" class="clr">

						<div id="events-calendar-title" class="clr">

							<?php
							// Date Vars
							$time        = current_time( 'timestamp' );
							$today_month = date( 'n', $time );
							$today_year  = date( 'Y', $time );
							$months      = earth_get_months(); ?>

							<h2 id="calendar_title"><i class="fa fa-calendar"></i><?php echo esc_html( $months[$today_month] .' '. $today_year ); ?></h2>

							<div id="calendar-month-select" class="clr">
								<form id="cal-trigger">
									<select name="month">
									<?php
									// Loop through months
									foreach( $months as $key=>$month ) {
										$selected = $key == $today_month ? 'selected' : '';
										echo '<option value="'.$key.'" '.$selected.'>'. $month .'</option>';
									} ?>
									</select>
									<select name="year">
										<?php 
										// Get years range
										$years = earth_calendar_years_range();
										// Loop through years and add options to select
										foreach( $years as $year ) {
											$selected = $year == $today_year ? 'selected' : '';
											echo '<option value="'. $year .'" '. $selected .'>'. $year .'</option>';
										} ?>
									</select>
									<a id="submit" class="cal-submit yellow-btn" href="#"><?php esc_html_e('Go','earth') ?></a>
								</form>
							</div>

						</div>

						<div id="calendar" class="clr">
							<?php echo draw_calendar( $today_month, $today_year ); ?>
						</div>

						<div id="cal-nav" class="clr">
							<?php
							$next_year	= $prev_year = $today_year;
							$next_month	= $today_month + 1;

							if ( $next_month > 12) {
								$next_month	= 1;
								$next_year	= $today_year + 1;
							}
							
							$prev_month = $today_month - 1;

							if ( $prev_month < 1 ) {
								$prev_month	= 12;
								$prev_year	= $today_year - 1;
							}

							// Display next and previous buttons if enabled
							if ( earth_get_option( 'event_next_prev', '1' ) == '1' ) : ?>

								<form id="cal-prev_val">
									<input type="hidden" name="month" class="month" value="<?php echo esc_attr( $prev_month ); ?>">
									<input type="hidden" name="year" class="year" value="<?php echo esc_attr( $prev_year ); ?>">
								</form>
								<form id="cal-next_val">
									<input type="hidden" name="month" class="month" value="<?php echo esc_attr( $next_month ); ?>">
									<input type="hidden" name="year" class="year" value="<?php echo esc_attr( $next_year ); ?>">
								</form>
								<input type="button" id="cal-prev" class="yellow-btn" value="&laquo; <?php esc_html_e( 'Prev','earth'); ?>">
								<input type="button" id="cal-next" class="yellow-btn" value="<?php esc_html_e( 'Next','earth'); ?> &raquo;">
							
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	<?php endwhile; ?>
	
<?php get_footer(); ?>
