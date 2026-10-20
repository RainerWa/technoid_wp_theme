<?php
/**
 * Foto-Raster mit Lightbox wie in den TwoFold-Alben.
 * $args['photos'] = Attachment-IDs
 */
$photos = isset( $args['photos'] ) ? $args['photos'] : array();
?>
<div class="masonry isotope-grid row expanded technoid-photo-grid">
	<?php
	foreach ( $photos as $i => $photo ) {
		$rand        = wp_rand( 0, 1000 );
		$full_url    = wp_get_attachment_image_src( $photo, 'full' );
		$image_url   = wp_get_attachment_image_src( $photo, 'twofold-1' );
		$column_size = thb_get_column_size( 'style1', $i );
		?>
		<figure class="item small-12 medium-6 <?php echo esc_attr( $column_size ); ?> columns">
			<?php do_action( 'thb_render_photo', 'off', '', $photo, $image_url, $full_url, $rand, 'off' ); ?>
			<?php do_action( 'thb_display_caption', $rand, $photo, $full_url ); ?>
		</figure>
	<?php } ?>
</div>
