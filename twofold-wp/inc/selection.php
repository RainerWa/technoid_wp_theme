<?php function thb_selection() {
	$id = get_queried_object_id();
	ob_start();
	?>
/* Typography */
body {
	<?php thb_typeoutput( ot_get_option( 'body_type' ), false, 'Anonymous Pro' ); ?>
}
.titlefont, h1, h2, h3, h4, h5, h6, blockquote, .post .post-meta, .tag-link, .photo .album_no, .photo .inside, .navigation-menu, .btn, #comments ol.commentlist .comment .comment-meta, #comments ol.commentlist .comment .vcard, #comments ol.commentlist .comment .reply, .swiper-container.swiper-container-vertical > .swiper-pagination .swiper-pagination-bullet em, .selectric, .selectric-items, .pagination, #multiscroll-nav a em, .price, .shop_attributes tr th, #side-cart ul li .list_content h5+div, .shop_table thead tr th, .shop_table tbody tr th, .shop_table tfoot th, .woocommerce-checkout-payment label, .thb_shop_bar, label, .woocommerce-MyAccount-navigation ul li a,.add_to_cart_button, .woocommerce-tabs .tabs, .thb-full-menu {
	<?php thb_typeoutput( ot_get_option( 'title_type' ), false, 'Rajdhani' ); ?>
}
.thb-full-menu, .navigation-menu {
	<?php thb_typeoutput( ot_get_option( 'menu_fonttype' ), false, 'Rajdhani' ); ?>
}
.album-header h2 {
	<?php thb_typeoutput( ot_get_option( 'album_font' ) ); ?>
}
.navigation-menu li a {
	<?php thb_typeoutput( ot_get_option( 'menu_font' ) ); ?>
}
.navigation-menu .sub-menu li a {
	<?php thb_typeoutput( ot_get_option( 'menu_submenu_font' ) ); ?>
}
.thb-full-menu li a {
	<?php thb_typeoutput( ot_get_option( 'full_menu_font' ) ); ?>
}
.footer-menu li a,
.left-side .footer-menu li+li:before {
	<?php thb_typeoutput( ot_get_option( 'footer_font' ) ); ?>
}
#footer .right-side a {
	<?php thb_typeoutput( ot_get_option( 'footer_social_font' ) ); ?>
}
.lg-sub-html .image-information .image-caption p {
	<?php thb_typeoutput( ot_get_option( 'caption_font' ) ); ?>
}
/* Accent Colors */
	<?php if ( $accent_color = ot_get_option( 'accent_color' ) ) { ?>
a:hover, .thb-full-menu li.menu-item-has-children.sfHover>a, label small, #comments .comments-title span, #comments ol.commentlist .comment .reply, #comments ol.commentlist .comment .reply a, .comment-respond .comment-reply-title small a, .selectric-items li.selected, .selectric-items li:hover, .price, .product-detail .entry-summary .product_meta>span a, .woocommerce-tabs .tabs li a:hover, .woocommerce-tabs .tabs li.active a, .woocommerce-info a, .woocommerce-info a:hover, .woocommerce-password-strength {
	color: <?php echo esc_attr( $accent_color ); ?>;
}
.photo-actions li a:hover, .lg-progress-bar .lg-progress, .pace .pace-progress, .submit.single_add_to_cart_button:hover, .woocommerce-MyAccount-navigation ul li.is-active a, .btn.black:hover, .btn.single_add_to_cart_button:hover, .button:not(.selectric-button).black:hover, .button:not(.selectric-button).single_add_to_cart_button:hover, .submit.black:hover, .submit.single_add_to_cart_button:hover {
  background: <?php echo esc_attr( $accent_color ); ?>;
}
.photo-actions li a:hover, .submit.single_add_to_cart_button:hover, .woocommerce-tabs .tabs li a:after, .woocommerce-MyAccount-navigation ul li.is-active a, .btn.black:hover, .btn.single_add_to_cart_button:hover, .button:not(.selectric-button).black:hover, .button:not(.selectric-button).single_add_to_cart_button:hover, .submit.black:hover, .submit.single_add_to_cart_button:hover {
  border-color: <?php echo esc_attr( $accent_color ); ?>;
}
.woocommerce-MyAccount-navigation ul li.is-active+li a {
	border-top-color: <?php echo esc_attr( $accent_color ); ?>;
}
.thb-thumbnails .thb-thumbnail-container .thumbnail-toggle:hover polyline {
  stroke: <?php echo esc_attr( $accent_color ); ?>;
}
<?php } ?>
	<?php if ( $accent_color2 = ot_get_option( 'accent_color2' ) ) { ?>
.btn:hover, .dark-colors .btn:hover, body.dark-theme:not(.logo-dark) .btn:hover, body.light-theme.logo-light:not(.menu-open) .btn:hover, .quick_cart, .btn:not(.single_add_to_cart_button).alt, .button:not(.selectric-button):not(.single_add_to_cart_button).alt, .dark-colors .btn:not(.grey):not(.alt):hover, body.dark-theme:not(.logo-dark) .btn:not(.grey):not(.alt):hover, body.light-theme.logo-light:not(.menu-open) .btn:not(.grey):not(.alt):hover, .dark-colors .button:not(.grey):not(.alt):hover, body.dark-theme:not(.logo-dark) .button:not(.grey):not(.alt):hover, body.light-theme.logo-light:not(.menu-open) .button:not(.grey):not(.alt):hover, .dark-colors .submit:hover, body.dark-theme:not(.logo-dark) .submit:hover, body.light-theme.logo-light:not(.menu-open) .submit:hover {
  background: <?php echo esc_attr( $accent_color2 ); ?>;
}
.btn:hover, .dark-colors .btn:hover, body.dark-theme:not(.logo-dark) .btn:hover, body.light-theme.logo-light:not(.menu-open) .btn:hover, .quick_cart .float_count, .btn:not(.single_add_to_cart_button).alt, .button:not(.selectric-button):not(.single_add_to_cart_button).alt, .dark-colors .btn:not(.grey):not(.alt):hover, body.dark-theme:not(.logo-dark) .btn:not(.grey):not(.alt):hover, body.light-theme.logo-light:not(.menu-open) .btn:not(.grey):not(.alt):hover, .dark-colors .button:not(.grey):not(.alt):hover, body.dark-theme:not(.logo-dark) .button:not(.grey):not(.alt):hover, body.light-theme.logo-light:not(.menu-open) .button:not(.grey):not(.alt):hover, .dark-colors .submit:hover, body.dark-theme:not(.logo-dark) .submit:hover, body.light-theme.logo-light:not(.menu-open) .submit:hover {
  border-color: <?php echo esc_attr( $accent_color2 ); ?>;
}
.btn:not(.single_add_to_cart_button).alt:hover, .button:not(.selectric-button):not(.single_add_to_cart_button).alt:hover {
	background: <?php echo thb_adjustColorLightenDarken( $accent_color2, 5 ); ?>;
	border-color: <?php echo thb_adjustColorLightenDarken( $accent_color2, 5 ); ?>;
}
.swiper-nav .thb-arrow .thb-progress {
	stroke: <?php echo esc_attr( $accent_color2 ); ?>;
}
<?php } ?>
/* Logo Height */
#navigation-menu > div {
	margin-top: <?php thb_measurementoutput( ot_get_option( 'logo_height' ) ); ?>;
}
@media only screen and (min-width: 48.063em) {
	#header .logo .logoimg {
		max-height: <?php thb_measurementoutput( ot_get_option( 'logo_height' ), array( '20', 'px' ) ); ?>;
	}
}
	<?php if ( $mobile_logo_height = ot_get_option( 'mobile_logo_height' ) ) { ?>
@media only screen and (max-width: 48.063em) {
	#header .logo .logoimg {
		max-height: <?php thb_measurementoutput( ot_get_option( 'mobile_logo_height' ), array( '20', 'px' ) ); ?>;
	}
	#navigation-menu > div {
		margin-top: <?php thb_measurementoutput( ot_get_option( 'mobile_logo_height' ), array( '20', 'px' ) ); ?>;
	}
}
<?php } ?>
	<?php if ( $menu_margin = ot_get_option( 'menu_margin' ) ) { ?>
.thb-full-menu>li+li {
	margin-left: <?php thb_measurementoutput( $menu_margin ); ?>
}
<?php } ?>
/* Backgrounds */
	<?php if ( $header_fixed_bg = ot_get_option( 'header_fixed_bg' ) ) { ?>
#header.fixed {
		<?php thb_bgoutput( $header_fixed_bg ); ?>
}
<?php } ?>
#navigation-menu,
.dark-colors #navigation-menu, body.dark-theme:not(.logo-dark) #navigation-menu,
body.light-theme.logo-light:not(.menu-open) #navigation-menu {
	<?php thb_bgoutput( ot_get_option( 'mobilemenu_bg' ) ); ?>
}
.content404 {
	<?php thb_bgoutput( ot_get_option( 'page404_bg' ) ); ?>
}
.password-protected {
	<?php thb_bgoutput( ot_get_option( 'password_bg' ) ); ?>
}
.pace {
	<?php thb_bgoutput( ot_get_option( 'preloader_bg' ) ); ?>
}
.page-id-<?php echo esc_attr( $id ); ?> #wrapper {
	<?php thb_bgoutput( get_post_meta( $id, 'page_bg', true ) ); ?>
}

/* Preloader Image */
	<?php if ( $preloader_image = ot_get_option( 'preloader-image' ) ) { ?>
.pace:before {
	background-image: url(<?php echo esc_attr( $preloader_image ); ?>);
}
<?php } ?>

/* Extra CSS */
	<?php
	echo ot_get_option( 'extra_css' );
	?>
	<?php
	$out = ob_get_clean();
	// Remove comments
	$out = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $out );
	// Remove space after colons
	$out = str_replace( ': ', ':', $out );
	// Remove whitespace
	$out = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $out );

	return $out;
}
