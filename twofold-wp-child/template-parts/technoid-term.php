<?php
/**
 * Archivseite für DJ, Event, Location und Jahr:
 * oben alle Alben (Events), bei DJs darunter alle Fotos, auf denen er zu sehen ist.
 */
$term       = get_queried_object();
$taxonomies = technoid_taxonomies();
$label      = $taxonomies[ $term->taxonomy ][0];

$albums = get_posts(
	array(
		'post_type'      => 'album',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'orderby'        => 'date',
		'order'          => 'ASC',
		'tax_query'      => array( array( 'taxonomy' => $term->taxonomy, 'terms' => $term->term_id ) ),
	)
);

$photos = array();
if ( 'dj' === $term->taxonomy ) {
	$photos = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'orderby'        => 'date',
			'order'          => 'ASC',
			'tax_query'      => array( array( 'taxonomy' => 'dj', 'terms' => $term->term_id ) ),
		)
	);
}

get_header();
?>
<div class="page-padding">
	<div class="side_padding">
		<div class="row align-center expanded">
			<div class="small-12 medium-10 large-6 columns text-center album-header post">
				<aside class="post-meta"><?php echo esc_html( $label ); ?></aside>
				<h2 class="entry-title"><?php echo esc_html( $term->name ); ?></h2>
				<?php echo wp_kses_post( wpautop( $term->description ) ); ?>
			</div>
		</div>

		<?php if ( $albums ) { ?>
			<?php get_template_part( 'template-parts/technoid-album-grid', null, array( 'albums' => $albums ) ); ?>
		<?php } else { ?>
			<p class="text-center">Noch keine Events.</p>
		<?php } ?>

		<?php if ( $photos ) { ?>
			<div class="row align-center expanded">
				<div class="small-12 medium-10 large-6 columns text-center album-header post technoid-photos-header">
					<h3 class="entry-title">Fotos mit <?php echo esc_html( $term->name ); ?></h3>
					<aside class="post-meta"><?php echo esc_html( count( $photos ) . ' Fotos' ); ?></aside>
				</div>
			</div>
			<?php get_template_part( 'template-parts/technoid-photo-grid', null, array( 'photos' => $photos ) ); ?>
		<?php } ?>
	</div>
</div>
<?php
get_footer();
