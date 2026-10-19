<?php
	$logo_light    = ot_get_option( 'logo_light', Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/logo_light.png' );
	$logo_dark     = ot_get_option( 'logo_dark', Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/logo_dark.png' );
	$logo_position = ot_get_option( 'logo_position', 'thb-logo-left' );
	$menu_type     = ot_get_option( 'menu_type', 'thb-mobile-icon' );
?>
<header id="header">
	<div class="logo-holder">
		<div class="mobile-toggle">
			<?php get_template_part( 'assets/svg/mobile-toggle.svg' ); ?>
		</div>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
			<img src="<?php echo esc_attr( $logo_light ); ?>" class="logoimg logo_light" alt="<?php esc_attr( bloginfo( 'name' ) ); ?>"/>
			<img src="<?php echo esc_attr( $logo_dark ); ?>" class="logoimg logo_dark" alt="<?php esc_attr( bloginfo( 'name' ) ); ?>"/>
		</a>
	</div>
	<div class="right-holder">
		<?php if ( $menu_type === 'thb-full-menu' && $logo_position !== 'thb-logo-center' ) { ?>
			<?php if ( has_nav_menu( 'nav-menu' ) ) { ?>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'nav-menu',
						'depth'          => 3,
						'container'      => false,
						'menu_class'     => 'thb-full-menu',
						'walker'         => new thb_mobileDropdown(),
					)
				);
				?>
			<?php } else { ?>
				<ul class="full-menu">
					<li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>"><?php esc_html_e( 'Please assign a menu', 'twofold' ); ?></a></li>
				</ul>
			<?php } ?>
		<?php } ?>
		<?php
		if ( is_singular( 'collection' ) ) {
			do_action( 'thb_collection_nav' ); }
		?>
	</div>
</header>
