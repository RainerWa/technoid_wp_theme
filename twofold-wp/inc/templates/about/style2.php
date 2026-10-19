<?php $image_id = get_post_thumbnail_id(); $image_url = wp_get_attachment_image_src($image_id, 'full'); ?>
<div class="page-padding">
	<div <?php post_class( 'post post-detail'); ?>>
		<figure class="post-gallery parallax">
			<div class="parallax_bg" 
						data-top-bottom="transform: translate3d(0px, 40%, 0px);"
						data-top="transform: translate3d(0px, 0%, 0px);"
						style="background-image: url(<?php echo esc_html($image_url[0]); ?>);"></div>
			<header class="post-title entry-header">
				<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			</header>
		</figure>
		<div class="about-container">
			<div class="row align-center">
				<div class="small-12 medium-7 large-6 xlarge-5 columns">
					<div class="page-padding">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>