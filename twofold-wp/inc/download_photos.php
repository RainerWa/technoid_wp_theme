<?php
function thb_image_export() {
	$download = !empty($_GET['thb_download_photos']) ? sanitize_text_field( $_GET['thb_download_photos'] ) : '';
	$ids 			= !empty($_GET['ids']) ? sanitize_text_field( $_GET['ids'] ) : '';

	if ( $download == true && $ids ) {
		$files = explode( '-', $ids );

		$zipname = uniqid( 'thb-' ) . '.zip';
		$zip     = new ZipArchive();
		if ( $zip->open( $zipname, ZIPARCHIVE::CREATE ) === true ) {
			foreach ( $files as $file ) {
				$filename = get_attached_file( $file, true );
				$zip->addFile( $filename, basename( $filename ) );
			}
			$zip->close();
		}

		header( 'Content-Type: application/zip' );
		header( 'Content-disposition: attachment; filename=' . $zipname );
		header( 'Content-Length: ' . filesize( $zipname ) );
		header( 'Content-Description: File Transfer' );
		echo readfile( "$zipname" );
	}
}
add_action( 'init', 'thb_image_export' );
