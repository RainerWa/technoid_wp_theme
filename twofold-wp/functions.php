<?php

/*
 * Here we have all the custom functions for the theme
 * Please be extremely cautious editing this file.
 * You have been warned!
 *
 */

// Option-Tree Theme Mode.
require get_theme_file_path( '/inc/admin/option-tree/init.php' );

// Theme Admin.
require get_theme_file_path( '/inc/admin/welcome/fuelthemes.php' );

// TGM Plugin Activation Class.
require get_theme_file_path( '/inc/admin/plugins/plugins.php' );

// Imports.
require get_theme_file_path( '/inc/admin/imports/import.php' );

// Misc.
require get_theme_file_path( '/inc/misc.php' );

// Download Images.
require get_theme_file_path( '/inc/download_photos.php' );

// Add Menu Support.
require get_theme_file_path( '/inc/wp3menu.php' );

// Enable Sidebars.
require get_theme_file_path( '/inc/sidebar.php' );

// CSS Output of Theme Options.
require get_theme_file_path( '/inc/selection.php' );

// Script Calls.
require get_theme_file_path( '/inc/script-calls.php' );

// Ajax.
require get_theme_file_path( '/inc/ajax.php' );

// WooCommerce Support.
require get_theme_file_path( '/inc/woocommerce.php' );
