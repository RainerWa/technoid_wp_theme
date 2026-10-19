<?php
	$thb_id             = get_the_ID();
	$page_padding       = get_post_meta( $thb_id, 'page_padding', true );
	$true_aspect_ratio  = get_post_meta( $thb_id, 'true_aspect_ratio', true );
	$photo_proof        = get_post_meta( $thb_id, 'photo_proof', true );
	$album_photos_array = explode( ',', get_post_meta( $thb_id, 'gallery_photos', true ) );
?>
	<?php if ( $page_padding === 'on' ) { ?><div class="page-padding"><?php } ?>
	<div class="side_padding">
		<div class="masonry isotope-grid row max-width <?php if ($photo_proof === 'on') { echo 'photo-proof-enabled'; } ?> gallery-style7">
		<?php
			if ( $album_photos_array ) {
				$i = 0;
				foreach ( $album_photos_array as $photo ) {
					$rand = wp_rand(0, 1000);
					$full_url = wp_get_attachment_image_src( $photo, 'full' );
					$image_url = wp_get_attachment_image_src( $photo, 'twofold-blog-style1');

					$column_size = thb_get_column_size('style1', $i);
					$proof_class = $photo_proof === 'on' ? thb_proof_class( $photo ) : '';

					$aspect_ratio = $photo ? (($full_url[2] / $full_url[1]) * 100).'%' : '100%';
					$column_size .= ' thb-true-aspect';
					?>
					<div class="item small-12 medium-4 thb-true-aspect columns">
						<figure style="padding-bottom: <?php echo esc_attr( $aspect_ratio ); ?>">
							<?php do_action( 'thb_render_photo', $photo_proof, $proof_class, $photo, $image_url, $full_url, $rand, $true_aspect_ratio); ?>
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
	<?php if ($page_padding === 'on') { ?></div><?php } ?>