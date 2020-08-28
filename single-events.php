<?php
/**
 * Single Event
 *
 * @package Earth WordPress Theme
 * @subpackage Templates
 * @version 4.4
 */

get_header(); ?>

<?php
// Single post loop starts here
while ( have_posts() ) : the_post();
	
	// Get data
	$post_id          = get_the_ID();
	$attachments      = wpex_get_gallery_ids();
	$location_address = get_post_meta( $post_id, 'earth_event_location_address', true );
	$event_location   = get_post_meta( $post_id, 'earth_event_location', true );

	// Display title if not disabled
	if ( get_post_meta( $post_id, 'earth_page_title', true ) !== 'Disable' ) { ?>

		<header id="page-heading" class="clr">

			<h1><span><?php esc_html_e( 'Event: ', 'earth' ); ?></span><?php the_title(); ?></h1>

			<?php
			// Display countdown if enabled
			if ( earth_get_option( 'enable_disable_countdown', true ) ) :

				// Detailed countdown html
				if ( earth_get_option( 'enable_extended_countdown', false ) ) {
					$countdown_format = '<div id="event-meta"><span class="fa fa-clock-o"></span><strong>'. esc_html__( 'Time to event', 'earth' ) .':</strong> %%D%% '. esc_html__( 'days', 'earth' ) .' - %%H%% '. esc_html__( 'hours', 'earth' ) .' - %%M%% '. esc_html__( 'minutes', 'earth' ) .' - %%S%% '. esc_html__( 'seconds', 'earth' ) .'</div>';
				}

				// Minimal countdown html
				else {
					$countdown_format = '<div id="event-meta"><span class="fa fa-clock-o"></span><strong>'. esc_html__( 'Time to event', 'earth' ) .':</strong> %%D%% '. esc_html__( 'days', 'earth' ) .'</div>';
				} ?>
				
				<script type="text/javascript">
					CountActive   = true;
					LeadingZero   = false;
					TargetDate    = "<?php echo earth_get_event_target(); ?>";
					DisplayFormat = '<?php echo $countdown_format; // already sanitized ?>';
					FinishMessage = '<div id="event-meta"><span class="fa fa-clock-o"></span><strong><?php esc_html_e( 'Time to event', 'earth' ); ?>:</strong> <?php esc_html_e( 'This event has already started/finished', 'earth' ); ?></div>';
				</script>
				<script language="JavaScript" src="<?php echo esc_url( EARTH_ASSETS_DIR_URI . '/js/countdown.js' ); ?>"></script>

			<?php else : ?>

				<?php earth_breadcrumbs(); ?>

			<?php endif; ?>

		</header>

	<?php } ?>
	
	<article class="post clr et-fitvids">
		
		<div class="entry clr">

			<?php
			// Display oEmbed (video )
			if ( $embed = get_post_meta( $post_id, 'earth_post_oembed', true ) ) : ?>
				
				<div id="event-oembed" class="clr">
					<div class="responsive-embed-wrap clr"><?php echo wp_oembed_get( $embed ); ?></div>
				</div>

			<?php

			// Display post thumbnail
			elseif ( has_post_thumbnail() ) : ?>

				<div id="post-thumbnail">
					<?php
					// Add lightbox link open wrap
					if ( $has_lightbox = earth_get_option( 'event_image_lightbox', true ) ) { ?>

						<a href="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>" class="earth-lightbox styled-img" title="<?php earth_esc_title(); ?>">

					<?php }

						// Display post thumbnail
						earth_post_thumbnail( 'single_event', array(
							'alt' => earth_get_esc_title(),
						) );
						
					// Close lightbox link and add magnifying icon
					if ( $has_lightbox ) { ?>

						<div class="img-overlay"><span class="fa fa-search"></span></div>
						</a>

					<?php } ?>

				</div>

			<?php endif; ?>
			

			<?php
			/** Event Tabs **/
			if ( earth_get_option( 'single_event_tabs','1' ) == '1'
				&& get_post_meta( $post_id, 'earth_single_event_tabs', true ) !== 'on'
			) { ?>

				<?php
				// Load jquery tabs js
				wp_enqueue_script( 'earth-event-tabs' ); ?>
				
				<div id="event-tabs" class="tabs tab-shortcode">
				
					<ul class="clr event-tabs-nav">
						<li class="active"><a href="#tab-details"><i class="fa fa-file-text"></i><span><?php esc_html_e( 'Details', 'earth' ); ?></span></a></li>
						<?php
						// Location tab
						if ( $event_location
							|| ( $location_address && earth_get_option( 'google_api_key' ) )
						) { ?>
							<li><a href="#tab-location"><i class="fa fa-map-marker"></i><span><?php esc_html_e( 'Map', 'earth' ); ?></span></a></li>
						<?php }
						// Gallery tab
						if ( $attachments ) { ?>
								<li><a href="#tab-gallery"><i class="fa fa-picture-o"></i><span><?php _e ( 'Gallery', 'earth' ); ?></span></a></li>
						<?php } ?>
					</ul>
					
					<div id="tab-details" class="event-tab-content visible clr">
						<div id="event-details-left">
							<div class="event-date">
								<div class="event-month"><?php echo earth_event_date( 'month' ); ?></div>
								<div class="event-day"><?php echo earth_event_date( 'day' ); ?></div>
							</div>
						</div>
						<div id="event-details-right">
							<?php if ( $title = get_post_meta( $post_id, 'earth_event_details_title', true ) ) { ?>
								<h2 id="event-details-title"><?php echo esc_html( $title ); ?></h2>
							<?php }?>
							<?php the_content(); ?>
						</div>
						<div class="clear"></div>
					</div>
			
					<?php
					if ( $location_address || $event_location ) {

						// If location is iframe then set as event location
						if ( strpos( $location_address, 'iframe ' ) !== false ) { 
							$event_location = $location_address;
							$location_address = '';
						} ?>

						<div id="tab-location" class="event-tab-content clr">
							<?php
							// Event by adddress
							if ( $location_address && earth_get_option( 'google_api_key' ) ) { ?>

								<?php wp_enqueue_script( 'googlemap_api' ); ?>

								<div id="map_canvas_<?php echo rand(1, 100); ?>" class="googlemap" style="height:300px;width:100%">
									<input class="title" type="hidden" value="<?php the_title(); ?>" />
									<input class="location" type="hidden" value="<?php echo esc_html( $location_address ); ?>" />
									<input class="zoom" type="hidden" value="8" />
									 <div class="map_canvas"></div>
								</div>

							<?php }

							// Google Map embed style
							elseif ( $event_location ) {

								echo $event_location;

							} ?>
						</div>

					<?php } ?>
					
					
					<?php
					// Display gallery if there is more then 0 attachments
					if ( $attachments ) : ?>

						<div id="tab-gallery" class="event-tab-content clr">

							<div id="tab-gallery-inner" class="earth-lightbox-gallery clr">

								<div class="et-row clr">
									<?php
									// Loop through attachments
									$wpex_count = 0;
									foreach ( $attachments as $attachment ) {

										// Get image
										if ( 'full-width' == earth_get_post_layout() ) {
											$image_src = earth_resize_thumbnail( $attachment, 205, 195, true );
										} else {
											$image_src = earth_resize_thumbnail( $attachment, 180, 170, true );
										}

										if ( empty( $image_src['url'] ) ) {
											continue;
										}

										$wpex_count++;
										$attachment_meta = wpex_get_attachment( $attachment ); ?>

										<div class="et-col span_1_of_4 clr et-col-<?php echo esc_attr( $wpex_count ); ?>">
											<a href="<?php echo wp_get_attachment_url( $attachment ); ?>" title="<?php echo esc_attr( $attachment_meta['title'] ); ?>" class="styled-img">
												<img src="<?php echo esc_url( $image_src['url'] ); ?>" alt="<?php echo esc_attr( $attachment_meta['alt'] ); ?>" height="<?php echo esc_attr( $image_src['height'] ); ?>" width="<?php echo esc_attr( $image_src['width'] ); ?>" />
												<div class="img-overlay"><span class="fa fa-search"></span></div>
											</a>
										</div>

										<?php
										// Clear counter
										if ( 4 == $wpex_count ) {
											$wpex_count = 0;
										} ?>

									<?php } ?>

								</div>

							</div>

						</div>

					<?php endif; ?>
				
				</div>

			<?php }

			// Tabs are disabled
			else { ?>

				<div class="event-content clr"><?php the_content(); ?></div>

			<?php } // End if tabs enabled check ?>
			
			<div class="clear"></div>

			<?php
			// Display edit post link
			edit_post_link( __( 'Edit This', 'earth' ), '<div id="post-edit-links" class="clr">', '</div>' ); ?>

			<?php
			// Display comments if enabled
			if ( earth_get_option( 'enable_disable_blog_comments' ) !== 'disable' ) {
				comments_template();
			} ?>

		</div><!-- .entry -->

	</article>

<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>