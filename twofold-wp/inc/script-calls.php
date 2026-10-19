<?php
// De-register Contact Form 7 styles.
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

// Main Styles.
function thb_main_styles() {
	$thb_theme_version = Thb_Theme_Admin::$thb_theme_version;

	// Enqueue.
	wp_enqueue_style( 'thb-fa', esc_url( get_theme_file_uri( 'assets/css/font-awesome.min.css' ) ), null, '4.7.0' );
	wp_enqueue_style( 'thb-app', esc_url( get_theme_file_uri( 'assets/css/app.css' ) ), null, esc_attr( $thb_theme_version ) );

	if ( ! defined( 'THB_DEMO_SITE' ) ) {
		wp_enqueue_style( 'style', get_stylesheet_uri(), null, esc_attr( $thb_theme_version ) );
	}
	wp_enqueue_style( 'thb-google-fonts', thb_google_webfont(), null, esc_attr( $thb_theme_version ) );
	wp_add_inline_style( 'thb-app', thb_selection() );

	if ( is_page_template( 'template-contact.php' ) ) {
		if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
			wpcf7_enqueue_styles();
		}
	}
}

add_action( 'wp_enqueue_scripts', 'thb_main_styles' );


// Main Scripts.
function thb_register_js() {
	if ( ! is_admin() ) {
		$thb_combined_libraries = ot_get_option( 'thb_combined_libraries', 'on' );
		$thb_api_key            = ot_get_option( 'map_api_key' );
		$thb_dependency         = array( 'jquery', 'underscore' );
		$thb_theme_version      = Thb_Theme_Admin::$thb_theme_version;

		// Register.
		if ( 'on' === $thb_combined_libraries ) {
			wp_enqueue_script( 'thb-vendor', esc_url( get_theme_file_uri( 'assets/js/vendor.min.js' ) ), array( 'jquery' ), esc_attr( $thb_theme_version ), true );
			$thb_dependency[] = 'thb-vendor';
		} else {
			$thb_js_libraries = array(
				'TweenMax'                  => '_0TweenMax.min.js',
				'TweenMax-DrawSVGPlugin'    => '_2DrawSVGPlugin.js',
				'atvImg'                    => 'atvImg.js',
				'bezier-easing'             => 'bezier-easing.js',
				'classie'                   => 'classie.js',
				'froogaloop2'               => 'froogaloop2.min.js',
				'googlemaps-infobox'        => 'googlemaps.infobox.min.js',
				'isInViewport'              => 'isInViewport.min.js',
				'isotope'                   => 'isotope.pkgd.min.js',
				'isotope-packery-mode'      => 'packery-mode.pkgd.min.js',
				'jarallax'                  => 'jarallax-0.min.js',
				'jarallax-video'            => 'jarallax-video.min.js',
				'jquery-foundation-plugins' => 'jquery.foundation.plugins.js',
				'jquery-mousewheel'         => 'jquery.mousewheel.min.js',
				'jquery-multiscroll'        => 'jquery.multiscroll.js',
				'jquery-panr'               => 'jquery.panr.js',
				'jquery-selectric'          => 'jquery.selectric.min.js',
				'vide'                      => 'jquery.vide.js',
				'lightgallery'              => 'lightgallery-all.min.js',
				'mobile-detect'             => 'mobile-detect.min.js',
				'modernizr-custom'          => 'modernizr.custom.js',
				'mp-boxesFx'                => 'mp-boxesFx.js',
				'pace'                      => 'pace.min.js',
				'perfect-scrollbar'         => 'perfect-scrollbar.jquery.min.js',
				'skrollr'                   => 'skrollr.min.js',
				'slick'                     => 'slick.min.js',
				'swiper'                    => 'swiper.jquery.min.js',
			);
			foreach ( $thb_js_libraries as $handle => $value ) {
				wp_enqueue_script( $handle, esc_url( get_theme_file_uri( 'assets/js/vendor/' . esc_attr( $value ) ) ), array( 'jquery' ), esc_attr( $thb_theme_version ), true );
			}
		}
		wp_enqueue_script( 'thb-app', esc_url( get_theme_file_uri( 'assets/js/app.min.js' ) ), $thb_dependency, esc_attr( $thb_theme_version ), true );

		// Enqueue.
		if ( is_page_template( 'template-contact.php' ) ) {
			wp_enqueue_script( 'gmapdep', 'https://maps.google.com/maps/api/js?key=' . esc_attr( $thb_api_key ), false, esc_attr( $thb_theme_version ), false );

			if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
				wpcf7_enqueue_scripts();
			}
		}
		if ( is_singular() && comments_open() && ( get_option( 'thread_comments' ) ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Typekit.
		$typekit_id = ot_get_option( 'typekit_id' );
		if ( $typekit_id ) {
			wp_enqueue_script( 'thb-typekit', 'https://use.typekit.net/' . $typekit_id . '.js', array(), null, false );
			wp_add_inline_script( 'thb-typekit', 'try{Typekit.load({ async: true });}catch(e){}' );
		}

		wp_enqueue_script( 'thb-vendor' );
		wp_enqueue_script( 'underscore' );
		wp_enqueue_script( 'thb-app' );
		wp_localize_script(
			'thb-app',
			'themeajax',
			array(
				'url'      => admin_url( 'admin-ajax.php' ),
				'settings' => array(
					'lightbox_effect'             => ot_get_option( 'lightbox_effect', 'slide' ),
					'lightbox_autoplay_duration'  => ot_get_option( 'lightbox_autoplay_duration', '5' ),
					'lightbox_thumbnails_default' => ot_get_option( 'lightbox_thumbnails_default', 'on' ),
					'map_style'                   => ot_get_option( 'map_style' ),
					'right_click'                 => ot_get_option( 'right_click', 'on' ),
					'custom_select'               => apply_filters( 'thb_custom_select', true ),
				),
				'l10n'     => array(
					'loading'             => esc_html__( 'Loading ...', 'twofold' ),
					'nomore'              => esc_html__( 'Nothing left to load', 'twofold' ),
					'added'               => esc_html__( 'Added To Cart', 'twofold' ),
					'added_svg'           => thb_load_template_part( 'assets/svg/arrows_check.svg' ),
					'lightbox_tweet_text' => htmlspecialchars( rawurlencode( html_entity_decode( get_bloginfo( 'name' ) ) ) ),
				),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'thb_register_js' );

// WooCommerce.
add_filter( 'woocommerce_enqueue_styles', '__return_false' );
