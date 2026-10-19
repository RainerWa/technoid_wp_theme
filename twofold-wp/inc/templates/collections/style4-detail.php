<div class="collection-style4-detail">
	<aside class="style4-album-detail">
		<h5><?php the_title(); ?></h5>
		<?php the_excerpt(); ?>
		<div class="detail-meta">
			<?php do_action( 'thb_share' ); ?>
			<a href="#" class="back_to_list"><?php esc_html_e( 'Back to List', 'twofold' ); ?></a>
		</div>
	</aside>
	<div class="custom_scroll" id="album-scroll-<?php echo esc_attr( rand( 0, 999 ) ); ?>" data-horizontal="true">
		<ul>
			<?php
				$album_galleries    = get_post_meta( get_the_ID(), 'album_gallery', true );
				$album_photos_array = array();
			if ( $album_galleries ) {
				foreach ( $album_galleries as $gallery ) {
					$gallery_photos_array = explode( ',', get_post_meta( $gallery, 'gallery_photos', true ) );
					$album_photos_array   = array_merge( $album_photos_array, $gallery_photos_array );
				}
				$i = 0;
				foreach ( $album_photos_array as $photo ) {
					$i++;
					$rand         = wp_rand( 0, 1000 );
					$full_url     = wp_get_attachment_image_src( $photo, 'full' );
					$image_url    = $full_url;
					$image_width  = ( 180 * $full_url[1] ) / $full_url[2];
					$aspect_ratio = $photo && $full_url ? ( $full_url[2] / $full_url[1] ) : '0.65';
					?>
					<li class="style4-album" data-aspect="<?php echo esc_attr( $aspect_ratio ); ?>">
						<strong><?php echo esc_html( $i ); ?></strong>
						<figure class="album-image">
						<?php do_action( 'thb_render_photo', 'off', false, $photo, $image_url, $full_url, $rand, true ); ?>
						<?php do_action( 'thb_display_caption', $rand, $photo, $full_url ); ?>
						</figure>
					</li>
					<?php
				}
			}
			?>
		</ul>
	</figure>
</div>
