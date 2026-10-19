<?php
	$thb_id            = get_the_ID();
	$collection_albums = get_post_meta( $thb_id, 'collection_albums', true );
	$true_aspect_ratio = get_post_meta( $thb_id, 'true_aspect_ratio', true );
?>
<?php
if ( post_password_required() ) {
	get_template_part( 'inc/templates/password-protected' ); } else {
	?>
<div class="collection-style5-container">
		<?php
		if ( $collection_albums ) {
			$i = 0;
			foreach ( $collection_albums as $album ) {
				$thb_post = get_post( $album );
				setup_postdata( $thb_post );
				$album_galleries = get_post_meta( $album, 'album_gallery', true );
				$image_id        = get_post_thumbnail_id( $album );
				$full_url        = wp_get_attachment_image_src( $image_id, 'full' );

				$aspect_ratio = $image_id && $full_url ? ( ( $full_url[2] / $full_url[1] ) * 100 ) . '%' : '100%';

				$class = $i % 2 ? 'align-right' : '';

				$albums_meta[] = array(
					'i'           => $album,
					'title'       => get_the_title( $album ),
					'link'        => get_permalink( $album ),
					'description' => get_the_excerpt( $album ),
				);
				?>
				<div class="collection-style5" data-target="#collection-style5-<?php echo esc_attr( $album ); ?>">
					<div class="row max-width <?php echo esc_attr( $class ); ?> align-middle">
						<div class="small-12 medium-6 columns">
							<figure class="item parallax_bg" style="padding-bottom: <?php echo esc_attr( $aspect_ratio ); ?>">
								<div class="photo album" style="background-image:url('<?php echo esc_url( $full_url[0] ); ?>');"></div>
							</figure>
						</div>
					</div>
				</div>
				<?php
				$i++;
			}
			wp_reset_postdata();
		}
		?>
	<div class="style5-overlay">
		<?php
		foreach ( $albums_meta as $album ) {
			?>
			<div class="album_meta" id="collection-style5-<?php echo esc_attr( $album['i'] ); ?>">
				<div class="row align-center">
					<div class="small-12 medium-9 large-7 xlarge-4 columns text-center">
						<h1><?php echo esc_html( $album['title'] ); ?></h1>
						<p><?php echo esc_html( $album['description'] ); ?></p>
						<a href="<?php echo esc_url( $album['link'] ); ?>" class="btn"><?php esc_html_e( 'Discover Now', 'twofold' ); ?></a>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
<?php } ?>
