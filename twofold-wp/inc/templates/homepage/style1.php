<?php
	$thb_id = get_the_ID();
	$home_slides = get_post_meta( $thb_id, 'home_slides', true );
	$home_autoplay = get_post_meta( $thb_id, 'home_autoplay', true );
	$home_autoplay_speed = get_post_meta( $thb_id, 'home_autoplay_speed', true );
	$home_effect = get_post_meta( $thb_id, 'home_effect', true ) ? get_post_meta( $thb_id, 'home_effect', true ) : 'slide';
	$total = sizeof($home_slides);

	$home_random = get_post_meta( $thb_id, 'home_random', true );
	if ( $home_random === 'on' ) {
		shuffle( $home_slides );
	}
?>
<div class="swiper-container swiper-gallery bottom-slide" data-autoplay="<?php echo esc_attr($home_autoplay); ?>" data-autoplay-speed="<?php echo esc_attr($home_autoplay_speed); ?>" data-effect="<?php echo esc_attr($home_effect); ?>">
  <div class="swiper-wrapper">
  	<?php
  	if (!$home_slides) {
  		?>
  			<div class="swiper-slide page-padding no-slides">
  				<h2><?php esc_html_e( 'Please assign slides inside Page Settings', 'twofold' ); ?></h2>
  			</div>
  		<?php
  	} else {
  		$i = 1;
    	foreach ( $home_slides as $slide ) { ?>
    		<?php $full_image = wp_get_attachment_image_src($slide['image'], 'full'); ?>
    		<div class="swiper-slide page-padding swiper-lazy" data-background="<?php echo esc_attr($full_image[0]); ?>" data-color="<?php echo esc_attr($slide['logo_color']); ?>" id="slide-image-<?php echo esc_attr($slide['image']); ?>">
    			<div class="photo-caption">
    				<em><?php echo esc_html($i.'/'.$total); ?></em>
    				<?php echo esc_html($slide['title']); ?>
    			</div>
    		</div>
    		<?php $i++; ?>
    	<?php } ?>
  	<?php } ?>
  </div>
  <!-- Add Arrows -->
  <?php do_action( 'thb_swiper_nav' ); ?>
</div>