<?php
	$locations         = ot_get_option( 'map_locations' );
	$contact_shortcode = get_post_meta( get_the_ID(), 'contact_shortcode', true );
?>
<div id="contact_area" class="contact-container style2">
	<div class="contact-content">
		<div class="row full-width-row no-padding">
			<div class="small-12 large-6 columns">
				<div class="page-padding">
					<div class="contact-style2-content">
							<?php the_content(); ?>
							<?php echo do_shortcode( $contact_shortcode ); ?>
					</div>
				</div>
			</div>
			<?php if ( ot_get_option( 'contact_map', 'on' ) === 'on' ) { ?>
			<div class="small-12 large-6 columns">
				<div class="thb-fixed">
					<div
						class="contact_map google_map thb-fixed"
						data-map-zoom="<?php echo esc_attr( ot_get_option( 'contact_zoom', 17 ) ); ?>"
						data-map-center-lat="<?php echo esc_attr( ot_get_option( 'map_center_lat', '59.93815' ) ); ?>"
						data-map-center-long="<?php echo esc_attr( ot_get_option( 'map_center_long', '10.76537' ) ); ?>"
						data-latlong="<?php echo esc_attr( wp_json_encode( $locations ) ); ?>"
						data-pin-image="<?php echo esc_attr( ot_get_option( 'map_pin_image', Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/pin.png' ) ); ?>">
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
