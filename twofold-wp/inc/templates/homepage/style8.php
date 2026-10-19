<?php
	$thb_id = get_the_ID();
	$home_slides = get_post_meta( $thb_id, 'home_slides', true );
	$home_autoplay = get_post_meta( $thb_id, 'home_autoplay', true );
	$home_autoplay_speed = get_post_meta( $thb_id, 'home_autoplay_speed', true );
	$total = sizeof($home_slides);

	$home_random = get_post_meta( $thb_id, 'home_random', true );
	if ( $home_random === 'on' ) {
		shuffle( $home_slides );
	}
?>
<div id="home-split-tile" data-autoplay="<?php echo esc_attr($home_autoplay); ?>" data-autoplay-speed="<?php echo esc_attr($home_autoplay_speed); ?>">
	<?php if ( ! $home_slides ) { 	?>
			<div class="panel no-slides">
				<h2><?php esc_html_e( 'Please assign slides inside Page Settings', 'twofold' ); ?></h2>
			</div>
	<?php } else { ?>
		<?php foreach ( $home_slides as $slide ) { ?>
			<div class="panel" data-color="<?php echo esc_attr($slide['logo_color']); ?>" id="slide-image-<?php echo esc_attr($slide['image']); ?>">
				<?php echo wp_get_attachment_image( $slide['image'], 'full'); ?>
			</div>
		<?php } ?>
		<?php do_action( 'thb_swiper_nav' ); ?>
	<?php } ?>
</div>