<?php
/**
 * Technoid: Upload-Ordner nach dem Datum im Dateinamen statt nach Upload-Datum.
 *
 *   1997_01_04_Clubnight_001.jpg  -> uploads/1997/01/
 *   1997_Flyer.jpg                -> uploads/1997/
 *   flyer.jpg                     -> uploads/
 *
 * Gilt für Uploads im Backend und für den Import per WP-CLI.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Liefert den Unterordner für einen Dateinamen, z.B. "/1997/01", "/1997" oder "".
 */
function technoid_subdir_from_filename( $filename ) {
	if ( ! preg_match( '/^((?:19|20)\d{2})(?:[-_.](0[1-9]|1[0-2])(?=[-_.]|$))?/', basename( $filename ), $m ) ) {
		return '';
	}
	if ( (int) $m[1] > (int) gmdate( 'Y' ) ) {
		return '';
	}
	return '/' . $m[1] . ( isset( $m[2] ) ? '/' . $m[2] : '' );
}

// Dateinamen merken, bevor WordPress den Zielordner bestimmt.
function technoid_remember_upload_name( $file ) {
	$GLOBALS['technoid_upload_subdir'] = technoid_subdir_from_filename( $file['name'] );
	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'technoid_remember_upload_name' );
add_filter( 'wp_handle_sideload_prefilter', 'technoid_remember_upload_name' );

add_filter(
	'upload_dir',
	function ( $uploads ) {
		if ( ! isset( $GLOBALS['technoid_upload_subdir'] ) ) {
			return $uploads;
		}
		$subdir            = $GLOBALS['technoid_upload_subdir'];
		$uploads['subdir'] = $subdir;
		$uploads['path']   = $uploads['basedir'] . $subdir;
		$uploads['url']    = $uploads['baseurl'] . $subdir;
		return $uploads;
	}
);

// Nach dem Upload wieder die normale Logik verwenden.
add_filter(
	'wp_handle_upload',
	function ( $upload ) {
		unset( $GLOBALS['technoid_upload_subdir'] );
		return $upload;
	}
);
