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
<div class="multiscroll split" data-autoplay="<?php echo esc_attr($home_autoplay); ?>" data-autoplay-speed="<?php echo esc_attr($home_autoplay_speed); ?>">
 	<div class="ms-left-container">
    <div class="ms-left">
      <?php if ( ! $home_slides ) { 	?>
      		<div class="ms-section page-padding no-slides">
      			<h2><?php esc_html_e( 'Please assign slides inside Page Settings', 'twofold' ); ?></h2>
      		</div>
      	<?php
      } else {
      	$i = 1;
      	foreach ( $home_slides as $slide ) {
      		if ($i % 2 !== 0) { ?>
	      	<?php
	      	  $rand = wp_rand(0, 1000);
	      	  $photo = $slide['image'];
	      	  $full_url = wp_get_attachment_image_src($slide['image'], 'full');
	      	?>
	      	<div href="<?php echo esc_attr($full_url[0]); ?>" rel="lightbox" class="ms-section" id="slide-image-<?php echo esc_attr($slide['image']); ?>" data-sub-html="#photo-caption-<?php echo esc_attr($rand); ?>">
	      		<div class="ms-section-inner" style="background-image:url(<?php echo esc_attr($full_url[0]); ?>)"></div>
	      		<?php do_action( 'thb_display_caption', $rand, $photo, $full_url ); ?>
	      	</div>
	      <?php } $i++; } ?>
      <?php } ?>
    </div>
  </div>
  <div class="ms-right-container">
    <div class="ms-right">
    	<?php if ($home_slides) { ?>
	      <?php $i = 1; foreach ( $home_slides as $slide ) { if ($i % 2 == 0) {?>
	      	<?php
	      	  $rand = wp_rand(0, 1000);
	      	  $photo = $slide['image'];
	      	  $full_url = wp_get_attachment_image_src($slide['image'], 'full');
	      	?>
	      	<div href="<?php echo esc_attr($full_url[0]); ?>" rel="lightbox" class="ms-section" id="slide-image-<?php echo esc_attr($slide['image']); ?>" data-sub-html="#photo-caption-<?php echo esc_attr($rand); ?>">
	      		<div class="ms-section-inner" style="background-image:url(<?php echo esc_attr($full_url[0]); ?>)"></div>
	      		<?php do_action( 'thb_display_caption', $rand, $photo, $full_url ); ?>
	      	</div>
	      <?php } $i++; } ?>
      <?php } ?>
    </div>
  </div>
</div>
<?php if (get_post_meta( $thb_id, 'home_pagination', true ) !== 'off') { ?>
<div id="multiscroll-nav"></div>
<?php } ?>