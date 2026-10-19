<?php
require get_template_directory() . '/inc/admin/plugins/class-tgm-plugin-activation.php';

function thb_register_required_plugins() {
	$plugins[] = array(
		'name'               => esc_html__( 'WooCommerce', 'twofold' ), // The plugin name
		'slug'               => 'woocommerce', // The plugin slug (typically the folder name)
		'required'           => true,
		'force_activation'   => false,
		'force_deactivation' => false,
		'image_url'          => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/plugins/woo.png',
	);
	$plugins[] = array(
		'name'               => esc_html__( 'Classic Editor', 'twofold' ),
		'slug'               => 'classic-editor',
		'required'           => true,
		'force_activation'   => false,
		'force_deactivation' => false,
		'image_url'          => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/plugins/classic-editor.png',
	);
	$plugins[] = array(
		'name'               => esc_html__( 'Classic Widgets', 'twofold' ),
		'slug'               => 'classic-widgets',
		'required'           => true,
		'force_activation'   => false,
		'force_deactivation' => false,
		'image_url'          => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/plugins/classic-widgets.png',
	);
	$plugins[] = array(
		'name'               => esc_html__( 'TwoFold - Custom Post Types', 'twofold' ), // The plugin name
		'slug'               => 'twofold-post-types', // The plugin slug (typically the folder name)
		'source'             => get_template_directory() . '/inc/plugins/twofold-post-types.zip', // The plugin source
		'version'            => '2.0.3',
		'required'           => true,
		'force_activation'   => false,
		'force_deactivation' => false,
		'image_url'          => Thb_Theme_Admin::$thb_theme_directory_uri . 'assets/img/admin/plugins/twofold.png',
	);
	$plugins[] = array(
		'name'               => esc_html__( 'Thumbnail Crop Position', 'twofold' ), // The plugin name
		'slug'               => 'thumbnail-crop-position', // The plugin slug (typically the folder name)
		'required'           => false, // If false, the plugin is only 'recommended' instead of required
		'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
	);
	$plugins[] = array(
		'name'               => esc_html__( 'Contact Form 7', 'twofold' ), // The plugin name
		'slug'               => 'contact-form-7', // The plugin source
		'required'           => false, // If false, the plugin is only 'recommended' instead of required
		'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
		'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
	);
	$config    = array(
		'id'           => 'thb',
		'domain'       => 'twofold',           // Text domain - likely want to be the same as your theme.
		'default_path' => '',                          // Default absolute path to pre-packaged plugins
		'parent_slug'  => 'themes.php',
		'menu'         => 'install-required-plugins',  // Menu slug
		'has_notices'  => true,                        // Show admin notices or not
		'is_automatic' => false,                     // Automatically activate plugins after installation or not
		'message'      => '',                          // Message to output right before the plugins table
		'strings'      => array(
			'return' => esc_html__( 'Return to Theme Plugins', 'twofold' ),
		),
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'thb_register_required_plugins' );
