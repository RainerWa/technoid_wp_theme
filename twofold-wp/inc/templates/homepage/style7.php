<?php
	$thb_id = get_the_ID();
	$home_video_type = get_post_meta( $thb_id, 'home_video_type', true ) ? get_post_meta( $thb_id, 'home_video_type', true ) : '3rdparty';
	$attributes = $home_video_type === 'hosted' ? thb_video_attributes() : array('');

	$classes[] = 'video-container';
	$classes[] = $home_video_type !== 'hosted' ? 'jarallax-video' : false;
	$attributes[] = 'data-video="'.get_post_meta( $thb_id, 'home_video_url', true ).'"';
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php echo implode( ' ', $attributes ); ?>>
</div>