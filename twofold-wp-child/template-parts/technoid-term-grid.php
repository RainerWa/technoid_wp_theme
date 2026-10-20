<?php
/**
 * Kacheln für die Übersicht aller DJs / Events / Locations / Jahre.
 * $args['terms'], $args['columns']
 */
$terms   = isset( $args['terms'] ) ? $args['terms'] : array();
$columns = isset( $args['columns'] ) ? $args['columns'] : 4;
?>
<div class="masonry isotope-grid no-padding row expanded technoid-term-grid">
	<?php
	foreach ( $terms as $i => $term ) {
		$column_size = thb_get_column_size( 'style1', $i, $columns );
		$image_url   = wp_get_attachment_image_src( technoid_term_image_id( $term ), 'twofold-1' );
		$album_count = count(
			get_posts(
				array(
					'post_type'      => 'album',
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'tax_query'      => array( array( 'taxonomy' => $term->taxonomy, 'terms' => $term->term_id ) ),
				)
			)
		);
		?>
		<figure class="item small-12 medium-6 <?php echo esc_attr( $column_size ); ?> columns">
			<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="photo album" style="background-image:url('<?php echo esc_url( $image_url ? $image_url[0] : '' ); ?>');">
				<div class="album_overlay">
					<h3><?php echo esc_html( $term->name ); ?></h3>
					<hr />
					<aside class="meta"><?php echo esc_html( sprintf( _n( '%d Event', '%d Events', $album_count, 'twofold' ), $album_count ) ); ?></aside>
				</div>
			</a>
		</figure>
	<?php } ?>
</div>
