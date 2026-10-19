<?php
	$thb_id            = get_the_ID();
	$collection_albums = get_post_meta( $thb_id, 'collection_albums', true );
	$true_aspect_ratio = get_post_meta( $thb_id, 'true_aspect_ratio', true ) ? get_post_meta( $thb_id, 'true_aspect_ratio', true ) : 'off';
?>
<?php
if ( post_password_required() ) {
	get_template_part( 'inc/templates/password-protected' ); } else {
	?>
<div class="page-padding">
	<div class="side_padding">
		<div class="row expanded">
			<div class="small-12 columns isotope-grid">
					<?php
					if ( $collection_albums ) {
						foreach ( $collection_albums as $album ) {
							$terms = get_the_terms( $album, 'album-category' );
							$cats  = '';
							if ( ! empty( $terms ) ) {
								foreach ( $terms as $thb_term ) {
									$cats .= ' filter-' . strtolower( $thb_term->slug ); }
							}
							?>
							<div class="item collection_album <?php echo esc_attr( $cats ); ?>">
								<h6><a href="<?php echo esc_url( get_permalink( $album ) ); ?>" title="<?php the_title_attribute( false, false, true, $album ); ?>"><?php echo get_the_title( $album ); ?></a></h6>
								<div class="custom_scroll" id="album-scroll-<?php echo esc_attr( rand( 0, 999 ) ); ?>" data-horizontal="true">
									<ul>
									<?php
										$album_galleries    = get_post_meta( $album, 'album_gallery', true );
										$album_photos_array = array();
									if ( $album_galleries ) {
										foreach ( $album_galleries as $gallery ) {
											$gallery_photos_array = explode( ',', get_post_meta( $gallery, 'gallery_photos', true ) );
											$album_photos_array   = array_merge( $album_photos_array, $gallery_photos_array );
										}
										foreach ( $album_photos_array as $photo ) {

											$rand         = wp_rand( 0, 1000 ) . '-' . $photo;
											$full_url     = wp_get_attachment_image_src( $photo, 'full' );
											$image_url    = wp_get_attachment_image_src( $photo, 'twofold-collection-style1' );
											$image_width  = ( 180 * $full_url[1] ) / $full_url[2];
											$aspect_ratio = '';
											if ( $true_aspect_ratio === 'on' ) {
												$aspect_ratio = $photo && $full_url ? ( ( $full_url[2] / $full_url[1] ) * 100 ) . '%' : '100%';
												$image_url    = wp_get_attachment_image_src( $photo, 'twofold-collection-style1-ta' );
											}
											?>
												<li>
											<?php if ( $true_aspect_ratio === 'on' ) { ?>
													<figure class="album_list style1 thb-true-aspect-collection"
													<?php
													if ( $true_aspect_ratio === 'on' ) {
														echo ' style="width:' . esc_attr( $image_width ) . 'px; padding-bottom:' . esc_attr( $aspect_ratio ) . ' !important"'; }
													?>
													>
													<?php } else { ?>
													<figure class="album_list style1">
													<?php } ?>
													<?php do_action( 'thb_render_photo', 'off', false, $photo, $image_url, $full_url, $rand, $true_aspect_ratio ); ?>
													<?php do_action( 'thb_display_caption', $rand, $photo, $full_url ); ?>
													</figure>
												</li>
												<?php
										}
									}
									?>
									</ul>
								</div>
							</div>
								<?php
						}
					}
					?>
			</div>
		</div>
	</div>
</div>
<?php } ?>
