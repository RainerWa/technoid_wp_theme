<?php
/**
 * Technoid: Taxonomien DJ, Event, Location, Jahr für Alben und Fotos.
 *
 * - Beim Upload werden die digiKam-Tags (XMP lr:hierarchicalSubject) übernommen,
 *   das Jahr kommt aus dem Dateinamen (1997_01_14_...).
 * - Alben übernehmen automatisch die Begriffe ihrer Fotos. Von Hand am Album
 *   gesetzte Begriffe bleiben erhalten.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Taxonomie-Slug => [Einzahl, Mehrzahl, oberster digiKam-Tag].
 */
function technoid_taxonomies() {
	return array(
		'dj'       => array( 'DJ', 'DJs', 'People' ),
		'event'    => array( 'Event', 'Events', 'Event' ),
		'location' => array( 'Location', 'Locations', 'Location' ),
		'jahr'     => array( 'Jahr', 'Jahre', 'Jahr' ),
	);
}

// Interne Gesichts-Tags von digiKam, die nie übernommen werden.
function technoid_skip_tags() {
	return array( 'Unknown', 'Unconfirmed', 'Ignored' );
}

add_action(
	'init',
	function () {
		foreach ( technoid_taxonomies() as $slug => $t ) {
			register_taxonomy(
				$slug,
				array( 'album', 'attachment' ),
				array(
					'labels'            => array(
						'name'          => $t[1],
						'singular_name' => $t[0],
						'menu_name'     => $t[1],
						'all_items'     => 'Alle ' . $t[1],
						'add_new_item'  => $t[0] . ' hinzufügen',
						'edit_item'     => $t[0] . ' bearbeiten',
					),
					'public'            => true,
					'hierarchical'      => false,
					'show_admin_column' => true,
					'show_in_rest'      => true,
					'rewrite'           => array(
						'slug'       => $slug,
						'with_front' => false,
					),
				)
			);
		}
	},
	20 // nach den TwoFold-Post-Types
);

/* ------------------------------------------------------------------------
 * Metadaten aus der Datei lesen
 * --------------------------------------------------------------------- */

/**
 * Liefert die hierarchischen digiKam-Tags, z.B. ["Event|Clubnight", "People|DJ Dag"].
 */
function technoid_read_xmp_paths( $file ) {
	$head = @file_get_contents( $file, false, null, 0, 1024 * 1024 ); // XMP steht am Dateianfang
	if ( ! $head || ! preg_match( '#<lr:hierarchicalSubject>(.*?)</lr:hierarchicalSubject>#s', $head, $m ) ) {
		return array();
	}
	preg_match_all( '#<rdf:li>(.*?)</rdf:li>#s', $m[1], $items );
	return array_map(
		function ( $s ) {
			return html_entity_decode( trim( $s ), ENT_QUOTES | ENT_XML1, 'UTF-8' );
		},
		$items[1]
	);
}

/**
 * Liefert ['dj' => [...], 'event' => [...], ...] aus XMP und Dateiname.
 */
function technoid_terms_from_file( $file ) {
	$taxonomies = technoid_taxonomies();
	$roots      = array();
	$terms      = array();
	foreach ( $taxonomies as $slug => $t ) {
		$roots[ $t[2] ] = $slug;
		$terms[ $slug ] = array();
	}

	foreach ( technoid_read_xmp_paths( $file ) as $path ) {
		$parts = array_map( 'trim', explode( '|', $path ) );
		if ( count( $parts ) < 2 || ! isset( $roots[ $parts[0] ] ) ) {
			continue;
		}
		$name = end( $parts );
		if ( '' === $name || in_array( $name, technoid_skip_tags(), true ) ) {
			continue;
		}
		$terms[ $roots[ $parts[0] ] ][] = $name;
	}

	if ( empty( $terms['jahr'] ) && preg_match( '/^((?:19|20)\d{2})[_-]/', basename( $file ), $y ) ) {
		$terms['jahr'][] = $y[1];
	}

	return array_map( 'array_unique', $terms );
}

/**
 * Überträgt die Begriffe aus der Bilddatei auf das Foto.
 * $replace = true ersetzt vorhandene Begriffe (z.B. nach Korrektur in digiKam).
 */
function technoid_apply_file_terms( $attachment_id, $replace = false ) {
	$file = get_attached_file( $attachment_id, true );
	if ( ! $file || ! file_exists( $file ) ) {
		return;
	}
	foreach ( technoid_terms_from_file( $file ) as $tax => $names ) {
		if ( $names || $replace ) {
			wp_set_object_terms( $attachment_id, $names, $tax, ! $replace );
		}
	}
}

add_action(
	'add_attachment',
	function ( $attachment_id ) {
		if ( wp_attachment_is_image( $attachment_id ) ) {
			technoid_apply_file_terms( $attachment_id );
		}
	}
);

/* ------------------------------------------------------------------------
 * Album übernimmt die Begriffe seiner Fotos
 * --------------------------------------------------------------------- */

function technoid_album_photo_ids( $album_id ) {
	$galleries = get_post_meta( $album_id, 'album_gallery', true );
	if ( ! $galleries || ! function_exists( 'thb_get_album_photos' ) ) {
		return array();
	}
	return array_values( array_filter( array_map( 'intval', thb_get_album_photos( $galleries ) ) ) );
}

function technoid_sync_album( $album_id ) {
	if ( ! empty( $GLOBALS['technoid_defer_sync'] ) ) {
		return;
	}
	$photos    = technoid_album_photo_ids( $album_id );
	$prev_auto = get_post_meta( $album_id, '_technoid_auto_terms', true );
	$prev_auto = is_array( $prev_auto ) ? $prev_auto : array();
	$auto      = array();

	foreach ( array_keys( technoid_taxonomies() ) as $tax ) {
		$from_photos = $photos ? array_map( 'intval', wp_get_object_terms( $photos, $tax, array( 'fields' => 'ids' ) ) ) : array();
		$current     = array_map( 'intval', wp_get_object_terms( $album_id, $tax, array( 'fields' => 'ids' ) ) );
		$manual      = array_diff( $current, isset( $prev_auto[ $tax ] ) ? $prev_auto[ $tax ] : array() );

		wp_set_object_terms( $album_id, array_values( array_unique( array_merge( $manual, $from_photos ) ) ), $tax );
		$auto[ $tax ] = array_values( array_diff( $from_photos, $manual ) );
	}

	update_post_meta( $album_id, '_technoid_auto_terms', $auto );
}

function technoid_albums_with_gallery( $gallery_id ) {
	return get_posts(
		array(
			'post_type'      => 'album',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'meta_query'     => array(
				array(
					'key'     => 'album_gallery',
					'value'   => '"' . (int) $gallery_id . '"',
					'compare' => 'LIKE',
				),
			),
		)
	);
}

function technoid_albums_with_photo( $attachment_id ) {
	$galleries = get_posts(
		array(
			'post_type'      => 'gallery',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'meta_query'     => array(
				array(
					'key'     => 'gallery_photos',
					'value'   => '(^|,)' . (int) $attachment_id . '(,|$)',
					'compare' => 'REGEXP',
				),
			),
		)
	);
	$albums = array();
	foreach ( $galleries as $gallery_id ) {
		$albums = array_merge( $albums, technoid_albums_with_gallery( $gallery_id ) );
	}
	return array_unique( $albums );
}

// Album oder Galerie gespeichert -> abgleichen. Läuft auf 'save_post' mit später
// Priorität, weil TwoFold (OptionTree) die Fotoauswahl erst dort speichert.
add_action(
	'save_post',
	function ( $post_id, $post ) {
		if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
			return;
		}
		if ( 'album' === $post->post_type ) {
			technoid_sync_album( $post_id );
		} elseif ( 'gallery' === $post->post_type ) {
			foreach ( technoid_albums_with_gallery( $post_id ) as $album_id ) {
				technoid_sync_album( $album_id );
			}
		}
	},
	99,
	2
);

// Begriffe an einem Foto geändert (z.B. DJ korrigiert) -> betroffene Alben abgleichen.
add_action(
	'set_object_terms',
	function ( $object_id, $terms, $tt_ids, $taxonomy ) {
		if ( ! isset( technoid_taxonomies()[ $taxonomy ] ) || 'attachment' !== get_post_type( $object_id ) ) {
			return;
		}
		foreach ( technoid_albums_with_photo( $object_id ) as $album_id ) {
			technoid_sync_album( $album_id );
		}
	},
	10,
	4
);

/* ------------------------------------------------------------------------
 * Ausgabe
 * --------------------------------------------------------------------- */

/**
 * Verlinkte Begriffe eines Albums oder Fotos, z.B. "DJ Dag · Clubnight · 1997".
 */
function technoid_term_links( $post_id, $taxonomies = null, $link = true ) {
	$out = array();
	foreach ( $taxonomies ? $taxonomies : array_keys( technoid_taxonomies() ) as $tax ) {
		$terms = get_the_terms( $post_id, $tax );
		if ( ! $terms || is_wp_error( $terms ) ) {
			continue;
		}
		foreach ( $terms as $term ) {
			$out[] = $link
				? '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>'
				: $term->name;
		}
	}
	return implode( ' · ', $out );
}

// Auf der Albumseite die Begriffe als Links unter dem Text anzeigen.
add_filter(
	'the_content',
	function ( $content ) {
		if ( is_singular( 'album' ) && in_the_loop() && is_main_query() ) {
			$links = technoid_term_links( get_the_ID() );
			if ( $links ) {
				$content .= '<p class="technoid-terms">' . $links . '</p>';
			}
		}
		return $content;
	}
);

/**
 * Übersicht aller Begriffe einer Taxonomie als Kachel-Raster.
 * Beispiel: [technoid_uebersicht taxonomy="dj"]
 */
add_shortcode(
	'technoid_uebersicht',
	function ( $atts ) {
		$atts = shortcode_atts(
			array(
				'taxonomy' => 'dj',
				'columns'  => 4,
			),
			$atts
		);
		if ( ! isset( technoid_taxonomies()[ $atts['taxonomy'] ] ) ) {
			return '';
		}
		$terms = get_terms(
			array(
				'taxonomy'   => $atts['taxonomy'],
				'hide_empty' => true,
				'orderby'    => 'name',
				'order'      => 'jahr' === $atts['taxonomy'] ? 'DESC' : 'ASC',
			)
		);
		if ( ! $terms || is_wp_error( $terms ) ) {
			return '';
		}

		ob_start();
		get_template_part(
			'template-parts/technoid-term-grid',
			null,
			array(
				'terms'   => $terms,
				'columns' => (int) $atts['columns'],
			)
		);
		return ob_get_clean();
	}
);

/**
 * Titelbild für einen Begriff: Titelbild des neuesten Albums, sonst neuestes Foto.
 */
function technoid_term_image_id( $term ) {
	$albums = get_posts(
		array(
			'post_type'      => 'album',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'tax_query'      => array( array( 'taxonomy' => $term->taxonomy, 'terms' => $term->term_id ) ),
			'meta_query'     => array( array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ) ),
		)
	);
	if ( $albums && 'dj' !== $term->taxonomy ) {
		return get_post_thumbnail_id( $albums[0] );
	}
	// Bei DJs lieber ein Foto, auf dem der DJ selbst zu sehen ist.
	$photos = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'tax_query'      => array( array( 'taxonomy' => $term->taxonomy, 'terms' => $term->term_id ) ),
		)
	);
	if ( $photos ) {
		return $photos[0];
	}
	return $albums ? get_post_thumbnail_id( $albums[0] ) : 0;
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once __DIR__ . '/technoid-cli.php';
}
