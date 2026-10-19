<?php
	$thb_id             = get_the_ID();
	$page_padding       = get_post_meta( $thb_id, 'page_padding', true );
	$photo_proof        = get_post_meta( $thb_id, 'photo_proof', true );
	$album_photos_array = explode( ',', get_post_meta( $thb_id, 'gallery_photos', true ) );
?>
	<?php if ( $page_padding === 'on' ) { ?><div class="page-padding"><?php } ?>
	<div class="side_padding">
		<div class="masonry isotope-grid row expanded gallery-style6 <?php if ($photo_proof === 'on') { echo 'photo-proof-enabled'; } ?>">
		<?php
			if ( $album_photos_array ) {
				$i = 0;
				foreach ( $album_photos_array as $photo ) {
					$rand = wp_rand(0, 1000);
					$full_url = wp_get_attachment_image_src( $photo, 'full' );
					$image_url = wp_get_attachment_image_src( $photo, 'twofold-2');
					$image_width = $image_url[1] / 2;
					$padding = (190 / $image_width) * 100;
					$proof_class = $photo_proof === 'on' ? thb_proof_class( $photo ) : '';
					?>
					<div class="item columns">
						<figure class="no-padding" style="width: <?php echo esc_attr($image_width); ?>px; padding-bottom: <?php echo esc_attr($padding); ?>%;">
							<?php do_action( 'thb_render_photo', $photo_proof, $proof_class, $photo, $image_url, $full_url, $rand, false); ?>
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
