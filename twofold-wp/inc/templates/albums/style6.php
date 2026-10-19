<?php
	$thb_id             = get_the_ID();
	$photo_proof        = get_post_meta( $thb_id, 'photo_proof', true );
	$album_galleries    = get_post_meta( $thb_id, 'album_gallery', true );
	$true_aspect_ratio  = get_post_meta( $thb_id, 'true_aspect_ratio', true ) ? get_post_meta( $thb_id, 'true_aspect_ratio', true ) : 'off';
	$album_share        = get_post_meta( $thb_id, 'album_share', true ) ? get_post_meta( $thb_id, 'album_share', true ) : 'on';
	$album_photos_array = thb_get_album_photos( $album_galleries );
	$meta               = get_the_term_list( $thb_id, 'album-category', '', ', ', '' );
	$meta               = preg_replace( '/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $meta );
?>
<div class="page-padding">
	<div class="side_padding">
		<div class="row align-center expanded">
			<div class="small-12 medium-10 large-6 columns text-center album-header post">
				<?php if ( $meta ) { ?>
				<aside class="post-meta"><?php echo esc_html( $meta ); ?></aside>
				<?php } ?>
				<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
				<?php the_content(); ?>
				<?php
				if ( $album_share === 'on' ) {
					do_action( 'thb_share' ); }
				?>
			</div>
		</div>
		<div class="masonry isotope-grid row expanded gallery-style6 
		<?php
		if ( $photo_proof === 'on' ) {
			echo 'photo-proof-enabled'; }
		?>
		">
		<?php
		if ( $album_photos_array ) {
			$i = 0;
			foreach ( $album_photos_array as $photo ) {
				$rand        = wp_rand( 0, 1000 );
				$full_url    = wp_get_attachment_image_src( $photo, 'full' );
				$image_url   = wp_get_attachment_image_src( $photo, 'twofold-2' );
				$image_width = $image_url[1] / 2;
				$padding     = ( 190 / $image_width ) * 100;
				$proof_class = $photo_proof === 'on' ? thb_proof_class( $photo ) : '';

				?>
					<div class="item columns">
						<figure class="no-padding" style="width: <?php echo esc_attr( $image_width ); ?>px; padding-bottom: <?php echo esc_attr( $padding ); ?>%;">
						<?php do_action( 'thb_render_photo', $photo_proof, $proof_class, $photo, $image_url, $full_url, $rand, $true_aspect_ratio ); ?>
						<?php do_action( 'thb_display_caption', $rand, $photo, $full_url ); ?>
						</figure>
					</div>
					<?php
					$i++;
			}
		}
		?>
		</div>
	</div>
</div>
