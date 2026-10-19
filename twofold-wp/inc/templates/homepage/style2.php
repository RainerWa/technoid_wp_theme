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
  	<?php if ( ! $home_slides ) { 	?>
  			<div class="swiper-slide page-padding no-slides">
  				<h2><?php esc_html_e( 'Please assign slides inside Page Settings', 'twofold' ); ?></h2>
  			</div>
  		<?php
  	} else { $i = 1;
  		foreach ( $home_slides as $slide ) { ?>
  		<?php $full_image = wp_get_attachment_image_src($slide['image'], 'full'); ?>
  		<div class="swiper-slide page-padding swiper-lazy" data-background="<?php echo esc_attr($full_image[0]); ?>" data-color="<?php echo esc_attr($slide['logo_color']); ?>" id="slide-image-<?php echo esc_attr($slide['image']); ?>">
  			<div class="photo-caption">
  				<em><?php echo esc_html($i.'/'.$total); ?></em>
  				<?php echo esc_html($slide['title']); ?>
  			</div>
  		</div>
  		<?php $i++; } ?>
  	<?php } ?>
  </div>
  <!-- Add Arrows -->
  <?php do_action( 'thb_swiper_nav' ); ?>
</div>
<div class="thb-thumbnails">
	<div class="thb-thumbnail-container">
		<div class="thumbnail-toggle">
			<svg version="1.1" id="thumbnail-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				 width="26.025px" height="26.009px" viewBox="0 0 26.025 26.009" enable-background="new 0 0 26.025 26.009" xml:space="preserve">
			<polyline class="thb-gallery-icon" fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" points="1,0.997 1,24.997 25,24.997 25,0.997
				1,0.997 25,24.997 "/>
			<polyline class="thb-thumbnail-icon" fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" points="16.318,24.997 16.318,0.997 25,0.997
				1,24.913 "/>
			</svg>
		</div>
		<div class="swiper-container swiper-thumbnails">
	    <div class="swiper-wrapper">
	    	<?php if ( ! $home_slides ) { 	?>
	    			<div class="swiper-slide page-padding no-slides">
	    				<h6><?php esc_html_e( 'Please assign slides inside Page Settings', 'twofold' ); ?></h6>
	    			</div>
	    		<?php
	    	} else {
	    		foreach ( $home_slides as $slide ) { ?>
		    		<?php
		    			$full_image = wp_get_attachment_image_src($slide['image'], 'twofold-blog-style3');
		    		?>
		    		<div class="swiper-slide" style="background-image:url(<?php echo esc_attr($full_image[0]); ?>)"><div></div></div>
		    	<?php } ?>
	    	<?php } ?>
	    </div>
		</div>
	</div>
</div>