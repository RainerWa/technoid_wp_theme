<?php $image_id = get_post_thumbnail_id(); $image_url = wp_get_attachment_image_src($image_id, 'full'); ?>
<div <?php post_class( 'post post-detail'); ?>>
	<div class="about-container" style="background-image: url(<?php echo esc_attr($image_url[0]); ?>);">
		<div class="row align-center">
			<div class="small-12 medium-offset-2 medium-7 large-6 columns">
				<div class="page-padding">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
</div>