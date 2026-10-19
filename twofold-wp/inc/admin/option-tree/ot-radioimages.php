<?php

function thb_filter_radio_images( $array, $field_id ) {

	/* only run the filter where the field ID is my_radio_images */
	if ( $field_id == 'color_theme' ) {
		$array = array(
			array(
				'value' => 'light-theme',
				'label' => esc_html__( 'Light - White Background', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/light_dark/light.png',
			),
			array(
				'value' => 'dark-theme',
				'label' => esc_html__( 'Dark - Black Background', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/light_dark/dark.png',
			),
		);
	}

	if ( $field_id == 'lightbox_theme' ) {
		$array = array(
			array(
				'value' => 'light-box',
				'label' => esc_html__( 'Light - White Background', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/light_dark/light.png',
			),
			array(
				'value' => 'dark-box',
				'label' => esc_html__( 'Dark - Black Background', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/light_dark/dark.png',
			),
		);
	}

	if ( strpos( $field_id, 'home_slides_logo_color_' ) !== false ) {
		$array = array(
			array(
				'value' => 'logo-light',
				'label' => esc_html__( 'Light', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/light_dark/light.png',
			),
			array(
				'value' => 'logo-dark',
				'label' => esc_html__( 'Dark', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/light_dark/dark.png',
			),
		);
	}

	if ( $field_id == 'album_layout' || $field_id == 'gallery_layout' ) {
		$array = array(
			array(
				'value' => 'style1',
				'label' => esc_html__( 'Masonry - Style 1', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/album/style1.jpg',
			),
			array(
				'value' => 'style2',
				'label' => esc_html__( 'Masonry - Style 2', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/album/style2.jpg',
			),
			array(
				'value' => 'style3',
				'label' => esc_html__( 'Masonry - Style 3', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/album/style3.jpg',
			),
			array(
				'value' => 'style7',
				'label' => esc_html__( 'Masonry - Style 4', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/album/style7.jpg',
			),
			array(
				'value' => 'style4',
				'label' => esc_html__( 'Grid', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/album/style4.jpg',
			),
			array(
				'value' => 'style6',
				'label' => esc_html__( 'Grid v2', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/album/style6.jpg',
			),
			array(
				'value' => 'style5',
				'label' => esc_html__( 'Vertical', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/album/style5.jpg',
			),
		);
	}
	if ( $field_id == 'collection_layout' ) {
		$array = array(
			array(
				'value' => 'style1',
				'label' => esc_html__( 'Masonry', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/collection/style1.jpg',
			),
			array(
				'value' => 'style2',
				'label' => esc_html__( 'Vertical', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/collection/style2.jpg',
			),
			array(
				'value' => 'style3',
				'label' => esc_html__( 'Horizontal', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/collection/style3.jpg',
			),
			array(
				'value' => 'style4',
				'label' => esc_html__( 'Rail', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/collection/style4.jpg',
			),
			array(
				'value' => 'style5',
				'label' => esc_html__( 'Vertical Parallax', 'twofold' ),
				'src'   => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/collection/style5.jpg',
			),
		);
	}
	return $array;

}
add_filter( 'ot_radio_images', 'thb_filter_radio_images', 10, 2 );

function thb_filter_options_name() {
	return wp_kses(
		__( '<a href="http://fuelthemes.net">Fuel Themes</a>', 'twofold' ),
		array(
			'a' => array(
				'href'  => array(),
				'title' => array(),
			),
		)
	);
}
add_filter( 'ot_header_version_text', 'thb_filter_options_name', 10, 2 );

function thb_filter_page_title() {
	return wp_kses(
		__( 'TwoFold Theme Options', 'twofold' ),
		array(
			'a' => array(
				'href'  => array(),
				'title' => array(),
			),
		)
	);
}
add_filter( 'ot_theme_options_page_title', 'thb_filter_page_title', 10, 2 );

function thb_filter_menu_title() {
	return wp_kses(
		__( 'TwoFold Options', 'twofold' ),
		array(
			'a' => array(
				'href'  => array(),
				'title' => array(),
			),
		)
	);
}
add_filter( 'ot_theme_options_menu_title', 'thb_filter_menu_title', 10, 2 );

function thb_filter_upload_text() {
	return wp_kses(
		__( 'Send to Theme Options', 'twofold' ),
		array(
			'a' => array(
				'href'  => array(),
				'title' => array(),
			),
		)
	);
}
add_filter( 'ot_upload_text', 'thb_filter_upload_text', 10, 2 );

function thb_header_list() {
	echo '<li class="theme_link"><a href="http://fuelthemes.ticksy.com/" target="_blank">Support Forum</a></li>';
}
add_filter( 'ot_header_list', 'thb_header_list' );

function thb_filter_ot_recognized_font_families( $array, $field_id ) {
	$array['helveticaneue'] = "'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif";
	ot_fetch_google_fonts( true, false );
	$ot_google_fonts = wp_list_pluck( get_theme_mod( 'ot_google_fonts', array() ), 'family' );
	$array           = array_merge( $array, $ot_google_fonts );

	if ( ot_get_option( 'typekit_id' ) ) {
		$typekit_fonts = trim( ot_get_option( 'typekit_fonts' ), ' ' );
		$typekit_fonts = explode( ',', $typekit_fonts );

		$array = array_merge( $array, $typekit_fonts );
	}

	foreach ( $array as $font => $value ) {
		$thb_font_array[ $value ] = $value;
	}
	return $thb_font_array;
}
add_filter( 'ot_recognized_font_families', 'thb_filter_ot_recognized_font_families', 10, 2 );

function thb_filter_typography_fields( $array, $field_id ) {

	if ( $field_id == 'title_type' || $field_id == 'body_type' || $field_id == 'menu_fonttype' ) {
		$array = array( 'font-family' );
	}

	if ( $field_id == 'album_font' || $field_id == 'full_menu_font' || $field_id == 'menu_font' || $field_id == 'menu_submenu_font' || $field_id == 'footer_font' || $field_id == 'caption_font' ) {
		$array = array( 'font-size', 'text-transform', 'font-weight', 'letter-spacing' );
	}

	if ( $field_id == 'footer_social_font' ) {
		$array = array( 'font-size' );
	}

	return $array;

}

add_filter( 'ot_recognized_typography_fields', 'thb_filter_typography_fields', 10, 2 );
