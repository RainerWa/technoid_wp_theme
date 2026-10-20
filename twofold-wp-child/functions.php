<?php
// Sicherheitscheck
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function register_media_category_taxonomy() {

	register_taxonomy(
		'media_category',
		'attachment',
		array(
			'label' => 'Medien Kategorien',
			'hierarchical' => true,
			'show_admin_column' => true,
			'public' => true,
			'show_in_rest' => true,
			'rewrite' => array(
				'slug' => 'media-category',
				'with_front' => false
			),
		)
	);

}
add_action('init', 'register_media_category_taxonomy');


// DJ, Event, Location, Jahr für Alben und Fotos (inkl. digiKam-Import)
require_once get_stylesheet_directory() . '/inc/technoid-photos.php';
require_once get_stylesheet_directory() . '/inc/technoid-upload-dirs.php';
