<?php
	$thb_id            = get_the_ID();
	$page_padding      = get_post_meta( $thb_id, 'page_padding', true );
	$collection_albums = get_post_meta( $thb_id, 'collection_albums', true );
	$true_aspect_ratio = get_post_meta( $thb_id, 'true_aspect_ratio', true );
?>
<?php
if ( post_password_required() ) {
	get_template_part( 'inc/templates/password-protected' ); } else {
	?>
<div class="side_padding large-side-padding">
<div class="page-padding flex collection-style4">
	<div class="collection-style4-container">
		<div class="custom_scroll style4-main" id="album-scroll-<?php echo esc_attr( rand( 0, 999 ) ); ?>" data-horizontal="true">
			<ul>
				<?php
				if ( $collection_albums ) {
					$i = 0;
					foreach ( $collection_albums as $album ) {
						$image_id = get_post_thumbnail_id( $album );
						$full_url = wp_get_attachment_image_src( $image_id, 'full' );
						$terms    = get_the_terms( $album, 'album-category' );
						$cats     = '';
						if ( ! empty( $terms ) ) {
							foreach ( $terms as $thb_term ) {
								$cats .= ' filter-' . strtolower( $thb_term->slug );
							}
						}
						$meta = get_the_term_list( $album, 'album-category', '', ', ', '' );
						$meta = preg_replace( '/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $meta );

						$aspect_ratio = $image_id && $full_url ? $full_url[2] / $full_url[1] : '80';

						/* Count Photos */
						if ( false === ( $count = get_transient( 'thb-album-photos-count-' . $album ) ) ) {
							$album_galleries    = get_post_meta( $album, 'album_gallery', true );
							$album_photos_array = array();
							if ( $album_galleries ) {
								foreach ( $album_galleries as $gallery ) {
									$gallery_photos_array = explode( ',', get_post_meta( $gallery, 'gallery_photos', true ) );
									$album_photos_array   = array_merge( $album_photos_array, $gallery_photos_array );
								}
								$count = sizeof( $album_photos_array );
								set_transient( 'thb-album-photos-count-' . $album, $count, DAY_IN_SECONDS );
							}
						}
						?>
						<li class="style4-album<?php echo esc_attr( $cats ); ?>" data-aspect="<?php echo esc_attr( $aspect_ratio ); ?>">
							<a href="<?php echo esc_url( get_permalink( $album ) ); ?>" class="album-link" data-albumid="<?php echo esc_attr( $album ); ?>" data-security="<?php echo esc_attr( wp_create_nonce( 'thb_collection_style4_ajax' ) ); ?>">
								<h5><?php echo esc_html( get_the_title( $album ) ); ?></h5>
								<p><?php echo esc_html( $count ); ?> <?php esc_html_e( 'Photos', 'twofold' ); ?></p>
								<figure class="album-image" style="background-image:url('<?php echo esc_url( $full_url[0] ); ?>');">

								</figure>
							</a>
						</li>
						<?php
						$i++;
					}
				}
				?>
			</ul>
		</div>
	</div>
</div>
</div>
	<?php } ?>
