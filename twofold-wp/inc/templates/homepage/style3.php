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
<div class="swiper-container center-slide swiper-gallery" data-effect="cube" data-speed="1000" data-autoplay="<?php echo esc_attr($home_autoplay); ?>" data-autoplay-speed="<?php echo esc_attr($home_autoplay_speed); ?>">
  <div class="swiper-wrapper">
  	<?php if ( ! $home_slides ) { 	?>
  			<div class="swiper-slide page-padding no-slides">
  				<h2><?php esc_html_e( 'Please assign slides inside Page Settings', 'twofold' ); ?></h2>
  			</div>
  		<?php
  	} else { $i = 1;
  		foreach ( $home_slides as $slide ) { ?>
    		<?php $full_image = wp_get_attachment_image_src($slide['image'], 'full'); ?>
    		<div class="swiper-slide swiper-lazy" data-background="<?php echo esc_attr($full_image[0]); ?>" data-color="<?php echo esc_attr($slide['logo_color']); ?>" id="slide-image-<?php echo esc_attr($slide['image']); ?>">
    			<div class="text-container">
    		  	<h1><?php echo esc_html($slide['title']); ?></h1>
    		  	<p><?php echo esc_html($slide['description']); ?></p>
    		  	<?php if ($slide['home_btn'] === 'on') { ?>
    		  	<a href="<?php echo esc_attr($slide['btn_link']); ?>" class="btn"><?php echo esc_html($slide['btn_text']); ?></a>
    		  	<?php } ?>
    			</div>
    		</div>
    	<?php $i++; } ?>
  	<?php } ?>
  </div>
  <?php if (get_post_meta( $thb_id, 'home_pagination', true ) !== 'off') { ?>
  <!-- Add Pagination -->
  <div class="swiper-pagination">
  	<?php $i = 1; foreach ( $home_slides as $slide ) { ?><span class="swiper-pagination-bullet <?php if ($i == 1) { ?>swiper-pagination-bullet-active <?php } ?>"><em><?php echo esc_html($slide['title']); ?></em></span><?php $i++; } ?>
  </div>
  <?php } ?>
</div>