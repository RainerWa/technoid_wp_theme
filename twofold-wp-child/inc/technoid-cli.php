<?php
/**
 * WP-CLI-Befehle für den Foto-Import.
 *
 *   wp technoid import "/Pfad/zu/1997-01-14 - Clubnight - DJ Dag"
 *   wp technoid import "/Pfad/zu/_1997" --recursive
 *   wp technoid resync [--replace]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Technoid_CLI {

	/**
	 * Importiert Event-Ordner: pro Ordner ein Album mit einer Galerie.
	 *
	 * Der Ordnername wird zum Albumtitel. Beginnt er mit einem Datum
	 * (1997-01-14 oder 1997_01_14), wird das zum Datum des Albums.
	 * Bereits importierte Ordner werden übersprungen.
	 *
	 * ## OPTIONS
	 *
	 * <folder>...
	 * : Ein oder mehrere Event-Ordner.
	 *
	 * [--recursive]
	 * : Alle Unterordner mit Bildern als eigenes Event importieren.
	 *
	 * [--status=<status>]
	 * : Status der neuen Alben.
	 * ---
	 * default: publish
	 * options:
	 *   - publish
	 *   - draft
	 * ---
	 */
	public function import( $args, $assoc ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$folders = array();
		foreach ( $args as $folder ) {
			$folder = rtrim( $folder, '/' );
			if ( ! is_dir( $folder ) ) {
				WP_CLI::warning( "Kein Ordner: $folder" );
				continue;
			}
			$folders[] = $folder;
			if ( ! empty( $assoc['recursive'] ) ) {
				$it = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $folder, FilesystemIterator::SKIP_DOTS ), RecursiveIteratorIterator::SELF_FIRST );
				foreach ( $it as $f ) {
					if ( $f->isDir() ) {
						$folders[] = $f->getPathname();
					}
				}
			}
		}

		foreach ( $folders as $folder ) {
			$images = $this->images_in( $folder );
			if ( ! $images ) {
				continue;
			}
			$this->import_folder( $folder, $images, $assoc['status'] );
		}
	}

	/**
	 * Liest die Tags aller Fotos neu aus den Dateien und gleicht alle Alben ab.
	 *
	 * ## OPTIONS
	 *
	 * [--replace]
	 * : Vorhandene Begriffe an den Fotos ersetzen statt ergänzen
	 *   (überschreibt Korrekturen, die in WordPress gemacht wurden).
	 */
	public function resync( $args, $assoc ) {
		$GLOBALS['technoid_defer_sync'] = true;
		$ids = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'post_mime_type' => 'image',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);
		$progress = WP_CLI\Utils\make_progress_bar( 'Fotos', count( $ids ) );
		foreach ( $ids as $id ) {
			technoid_apply_file_terms( $id, ! empty( $assoc['replace'] ) );
			$progress->tick();
		}
		$progress->finish();
		$GLOBALS['technoid_defer_sync'] = false;

		$albums = get_posts( array( 'post_type' => 'album', 'post_status' => 'any', 'posts_per_page' => -1, 'fields' => 'ids' ) );
		foreach ( $albums as $album_id ) {
			technoid_sync_album( $album_id );
		}
		WP_CLI::success( count( $ids ) . ' Fotos und ' . count( $albums ) . ' Alben abgeglichen.' );
	}

	private function images_in( $folder ) {
		$images = array();
		foreach ( scandir( $folder ) as $name ) {
			if ( '.' !== $name[0] && preg_match( '/\.(jpe?g|png|webp)$/i', $name ) ) {
				$images[] = $folder . '/' . $name;
			}
		}
		natcasesort( $images );
		return array_values( $images );
	}

	private function import_folder( $folder, $images, $status ) {
		$source = realpath( $folder );
		$exists = get_posts(
			array(
				'post_type'      => 'album',
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_key'       => '_technoid_source',
				'meta_value'     => $source,
			)
		);
		if ( $exists ) {
			WP_CLI::log( "Übersprungen (schon importiert als Album #{$exists[0]}): " . basename( $folder ) );
			return;
		}

		$title = trim( preg_replace( '/\s+/', ' ', basename( $folder ) ) );
		$date  = current_time( 'mysql' );
		if ( preg_match( '/^((?:19|20)\d{2})[-_.](\d{2})[-_.](\d{2})/', $title, $d ) && checkdate( (int) $d[2], (int) $d[3], (int) $d[1] ) ) {
			$date = "{$d[1]}-{$d[2]}-{$d[3]} 20:00:00";
		}

		$GLOBALS['technoid_defer_sync'] = true;

		$album_id = wp_insert_post(
			array(
				'post_type'   => 'album',
				'post_title'  => $title,
				'post_status'    => 'draft',
				'comment_status' => 'closed',
				'post_date'      => $date,
				'post_date_gmt' => get_gmt_from_date( $date ), // sonst setzt WordPress Entwürfe beim Veröffentlichen auf "jetzt"
			),
			true
		);
		if ( is_wp_error( $album_id ) ) {
			WP_CLI::warning( $album_id->get_error_message() );
			return;
		}

		$progress = WP_CLI\Utils\make_progress_bar( $title, count( $images ) );
		$photo_ids = array();
		foreach ( $images as $i => $path ) {
			// media_handle_sideload verschiebt die Datei, daher mit einer Kopie arbeiten.
			$tmp = wp_tempnam( basename( $path ) );
			copy( $path, $tmp );
			$id = media_handle_sideload(
				array(
					'name'     => basename( $path ),
					'tmp_name' => $tmp,
				),
				$album_id,
				null,
				array( 'post_date' => date( 'Y-m-d H:i:s', strtotime( $date ) + $i ) )
			);
			if ( is_wp_error( $id ) ) {
				WP_CLI::warning( basename( $path ) . ': ' . $id->get_error_message() );
				@unlink( $tmp );
			} else {
				$photo_ids[] = $id;
			}
			$progress->tick();
		}
		$progress->finish();

		if ( ! $photo_ids ) {
			wp_delete_post( $album_id, true );
			$GLOBALS['technoid_defer_sync'] = false;
			return;
		}

		$gallery_id = wp_insert_post(
			array(
				'post_type'   => 'gallery',
				'post_title'  => $title,
				'post_status' => 'publish',
				'post_date'   => $date,
			)
		);
		update_post_meta( $gallery_id, 'gallery_photos', implode( ',', $photo_ids ) );

		update_post_meta( $album_id, 'album_gallery', array( $gallery_id => (string) $gallery_id ) );
		update_post_meta( $album_id, 'album_layout', 'style1' );
		update_post_meta( $album_id, 'album_share', 'on' );
		update_post_meta( $album_id, 'album_navigation', 'on' );
		update_post_meta( $album_id, '_technoid_source', $source );
		set_post_thumbnail( $album_id, $photo_ids[0] );

		$GLOBALS['technoid_defer_sync'] = false;
		technoid_sync_album( $album_id );
		wp_update_post( array( 'ID' => $album_id, 'post_status' => $status ) );

		WP_CLI::success( sprintf( '%s: %d Fotos → Album #%d (%s)', $title, count( $photo_ids ), $album_id, technoid_term_links( $album_id, null, false ) ) );
	}
}

WP_CLI::add_command( 'technoid', 'Technoid_CLI' );
