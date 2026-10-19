<?php $html_class[] = thb_overflow_class(); ?>
<!doctype html>
<html <?php language_attributes(); ?> class="<?php echo esc_attr( implode( ' ', $html_class ) ); ?>")>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php

		/*
		 * Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
	?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div class="pace"></div>
	<?php do_action( 'thb_side_cart' ); ?>
	<?php get_template_part( 'inc/templates/header/header-style1-' . ot_get_option( 'menu_position', 'thb-menu-left' ) ); ?>
	<?php get_template_part( 'inc/templates/navigation-menu' ); ?>
	<?php
	if ( is_singular( 'post' ) || is_singular( 'album' ) ) {
		do_action( 'thb_article_nav' );
	}
	?>
	<div id="wrapper">
