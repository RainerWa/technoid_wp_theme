<?php
/**
 * Raster mit Alben im Stil der TwoFold-Collections.
 * $args['albums']  = Album-IDs
 * $args['columns'] = 2–5
 */
$albums  = isset( $args['albums'] ) ? $args['albums'] : array();
$columns = isset( $args['columns'] ) ? $args['columns'] : 4;
?>
<div class="masonry isotope-grid no-padding row expanded technoid-album-grid">
	<?php
	foreach ( $albums as $i => $album ) {
		$column_size = thb_get_column_size( 'style1', $i, $columns );
		$image_url   = wp_get_attachment_image_src( get_post_thumbnail_id( $album ), 'twofold-1' );
		$meta        = technoid_term_links( $album, array( 'jahr', 'location' ), false );
		?>
		<figure class="item small-12 medium-6 <?php echo esc_attr( $column_size ); ?> columns">
			<a href="<?php echo esc_url( get_permalink( $album ) ); ?>" class="photo album" style="background-image:url('<?php echo esc_url( $image_url ? $image_url[0] : '' ); ?>');">
				<div class="album_overlay">
					<h3><?php echo esc_html( get_the_title( $album ) ); ?></h3>
					<?php if ( $meta ) { ?>
						<hr />
						<aside class="meta"><?php echo esc_html( $meta ); ?></aside>
					<?php } ?>
				</div>
			</a>
		</figure>
	<?php } ?>
</div>
