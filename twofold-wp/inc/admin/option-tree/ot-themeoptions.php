<?php
/**
 * Initialize the options before anything else.
 */
add_action( 'admin_init', 'thb_custom_theme_options', 1 );

/**
 * Theme Mode demo code of all the available option types.
 *
 * @return    void
 *
 * @access    private
 * @since     2.0
 */
function thb_custom_theme_options() {

	/**
	 * Get a copy of the saved settings array.
	 */
	$saved_settings = get_option( 'option_tree_settings', array() );

	/**
	 * Create a custom settings array that we pass to
	 * the OptionTree Settings API Class.
	 */
	$custom_settings = array(
		'sections' => array(
			array(
				'title' => esc_html__( 'General', 'twofold' ),
				'id'    => 'general',
			),
			array(
				'title' => esc_html__( 'Header', 'twofold' ),
				'id'    => 'header',
			),
			array(
				'title' => esc_html__( 'Shop', 'twofold' ),
				'id'    => 'shop',
			),
			array(
				'title' => esc_html__( 'Customization', 'twofold' ),
				'id'    => 'customization',
			),
			array(
				'title' => esc_html__( 'Footers', 'twofold' ),
				'id'    => 'footer',
			),
			array(
				'title' => esc_html__( 'Misc', 'twofold' ),
				'id'    => 'misc',
			),
			array(
				'title' => esc_html__( 'Contact Page', 'twofold' ),
				'id'    => 'contact',
			),
		),
		'settings' => array(
			array(
				'id'      => 'general_tab0',
				'label'   => esc_html__( 'General', 'twofold' ),
				'type'    => 'tab',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Main Color Theme', 'twofold' ),
				'id'      => 'color_theme',
				'type'    => 'radio-image',
				'desc'    => esc_html__( 'You can change the main color theme here', 'twofold' ),
				'std'     => 'light-theme',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Image Hover Effect', 'twofold' ),
				'id'      => 'image_effect',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can change the main image hover effect.', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Simple', 'twofold' ),
						'value' => 'style1',
					),
					array(
						'label' => esc_html__( '3D', 'twofold' ),
						'value' => 'style2',
					),
					array(
						'label' => esc_html__( 'Pan', 'twofold' ),
						'value' => 'style3',
					),
				),
				'std'     => 'style1',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Mouse Cursor', 'twofold' ),
				'id'      => 'mouse_effect',
				'type'    => 'radio',
				'desc'    => esc_html__( 'This is the mouse cursor used for sliders.', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Angled Square', 'twofold' ),
						'value' => 'style1',
					),
					array(
						'label' => esc_html__( 'Circular', 'twofold' ),
						'value' => 'style2',
					),
					array(
						'label' => esc_html__( 'Regular', 'twofold' ),
						'value' => 'style3',
					),
				),
				'std'     => 'style1',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Preloader', 'twofold' ),
				'id'      => 'preloader',
				'type'    => 'on_off',
				'desc'    => esc_html__( 'You can disable the page preloader here', 'twofold' ),
				'section' => 'general',
				'std'     => 'on',
			),
			array(
				'label'   => esc_html__( 'Right Click Protection', 'twofold' ),
				'id'      => 'right_click',
				'type'    => 'on_off',
				'desc'    => esc_html__( 'You can disable right click here.', 'twofold' ),
				'section' => 'general',
				'std'     => 'on',
			),
			array(
				'label'   => esc_html__( 'Right Click Text Content', 'twofold' ),
				'id'      => 'right_click_content',
				'type'    => 'textarea',
				'desc'    => esc_html__( 'This content appears inside the right click protection overlay.', 'twofold' ),
				'rows'    => '4',
				'section' => 'general',
				'cond'    => 'right_click:is(on)',
			),
			array(
				'id'      => 'general_tab1',
				'label'   => esc_html__( 'Lightbox', 'twofold' ),
				'type'    => 'tab',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Lightbox Color Theme', 'twofold' ),
				'id'      => 'lightbox_theme',
				'type'    => 'radio-image',
				'desc'    => esc_html__( 'You can change the lightbox color theme here', 'twofold' ),
				'std'     => 'light-box',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Lightbox Downloads', 'twofold' ),
				'id'      => 'lightbox_downloads',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can allow the visitors to download the photos within the lightbox.', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Enabled', 'twofold' ),
						'value' => 'lightbox-download-enabled',
					),
					array(
						'label' => esc_html__( 'Disabled', 'twofold' ),
						'value' => 'lightbox-download-disabled',
					),
				),
				'std'     => 'lightbox-download-enabled',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Lightbox Thumbnails', 'twofold' ),
				'id'      => 'lightbox_thumbnails',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can show a thumbnail strip at the bottom if you want.', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Enabled', 'twofold' ),
						'value' => 'lightbox-thumbnails-enabled',
					),
					array(
						'label' => esc_html__( 'Disabled', 'twofold' ),
						'value' => 'lightbox-thumbnails-disabled',
					),
				),
				'std'     => 'lightbox-thumbnails-disabled',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Display Thumnails by default', 'twofold' ),
				'id'      => 'lightbox_thumbnails_default',
				'type'    => 'on_off',
				'desc'    => esc_html__( 'You can toggle if you want the thumbnails to be visible by default or activated by button.', 'twofold' ),
				'section' => 'general',
				'std'     => 'on',
				'cond'    => 'lightbox_thumbnails:is(lightbox-thumbnails-enabled)',
			),
			array(
				'label'   => esc_html__( 'Lightbox Shares', 'twofold' ),
				'id'      => 'lightbox_shares',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can toggle the share feature of the lightbox', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Enabled', 'twofold' ),
						'value' => 'lightbox-shares-enabled',
					),
					array(
						'label' => esc_html__( 'Disabled', 'twofold' ),
						'value' => 'lightbox-shares-disabled',
					),
				),
				'std'     => 'lightbox-shares-enabled',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Lightbox Zoom', 'twofold' ),
				'id'      => 'lightbox_zoom',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can toggle the zoom feature of the lightbox.', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Enabled', 'twofold' ),
						'value' => 'lightbox-zoom-enabled',
					),
					array(
						'label' => esc_html__( 'Disabled', 'twofold' ),
						'value' => 'lightbox-zoom-disabled',
					),
				),
				'std'     => 'lightbox-zoom-enabled',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Lightbox AutoPlay', 'twofold' ),
				'id'      => 'lightbox_autoplay',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can toggle the autoplay feature of the lightbox.', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Enabled', 'twofold' ),
						'value' => 'lightbox-autoplay-enabled',
					),
					array(
						'label' => esc_html__( 'Disabled', 'twofold' ),
						'value' => 'lightbox-autoplay-disabled',
					),
				),
				'std'     => 'lightbox-autoplay-enabled',
				'section' => 'general',
			),
			array(
				'label'        => esc_html__( 'Lightbox AutoPlay Duration', 'twofold' ),
				'id'           => 'lightbox_autoplay_duration',
				'std'          => '5',
				'type'         => 'numeric-slider',
				'desc'         => esc_html__( 'The amount of time between next slides in seconds.', 'twofold' ),
				'min_max_step' => '1,10,0.5',
				'section'      => 'general',
			),
			array(
				'label'   => esc_html__( 'Lightbox Effect', 'twofold' ),
				'id'      => 'lightbox_effect',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can change the lightbox photo change effect', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Slide', 'twofold' ),
						'value' => 'lg-slide',
					),
					array(
						'label' => esc_html__( 'Fade', 'twofold' ),
						'value' => 'lg-fade',
					),
					array(
						'label' => esc_html__( 'Zoom In', 'twofold' ),
						'value' => 'lg-zoom-in',
					),
					array(
						'label' => esc_html__( 'Zoom Out', 'twofold' ),
						'value' => 'lg-zoom-out',
					),
					array(
						'label' => esc_html__( 'Soft Zoom', 'twofold' ),
						'value' => 'lg-soft-zoom',
					),
					array(
						'label' => esc_html__( 'Slide Circular', 'twofold' ),
						'value' => 'lg-slide-circular',
					),
					array(
						'label' => esc_html__( 'Slide Vertical', 'twofold' ),
						'value' => 'lg-slide-vertical',
					),
					array(
						'label' => esc_html__( 'Slide Skew', 'twofold' ),
						'value' => 'lg-slide-skew',
					),
				),
				'std'     => 'lg-slide',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Display EXIF Info?', 'twofold' ),
				'id'      => 'lightbox_exif',
				'type'    => 'on_off',
				'desc'    => esc_html__( 'You can disable the exif information on lightboxes here', 'twofold' ),
				'section' => 'general',
				'std'     => 'on',
			),
			array(
				'id'      => 'general_tab2',
				'label'   => esc_html__( 'Blog', 'twofold' ),
				'type'    => 'tab',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Blog Style', 'twofold' ),
				'id'      => 'blog_style',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can choose different blog styles here', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Style 1 - Masonry', 'twofold' ),
						'value' => 'style1',
					),
					array(
						'label' => esc_html__( 'Style 2 - Vertical', 'twofold' ),
						'value' => 'style2',
					),
					array(
						'label' => esc_html__( 'Style 3 - List', 'twofold' ),
						'value' => 'style3',
					),
				),
				'std'     => 'style1',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Blog Pagination Style', 'twofold' ),
				'id'      => 'blog_pagination_style',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can choose different blog pagination styles here. The regular pagination will be used for archive pages.', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Regular Pagination', 'twofold' ),
						'value' => 'style1',
					),
					array(
						'label' => esc_html__( 'Load More Button', 'twofold' ),
						'value' => 'style2',
					),
					array(
						'label' => esc_html__( 'Infinite Scroll', 'twofold' ),
						'value' => 'style3',
					),
				),
				'std'     => 'style1',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Blog Header', 'twofold' ),
				'id'      => 'blog_header',
				'type'    => 'textarea',
				'desc'    => esc_html__( 'This content appears on top of the main blog page.', 'twofold' ),
				'rows'    => '4',
				'section' => 'general',
			),
			array(
				'id'      => 'general_tab3',
				'label'   => esc_html__( 'Permalink Slugs', 'twofold' ),
				'type'    => 'tab',
				'section' => 'general',
			),
			array(
				'label'   => esc_html__( 'Gallery Slug', 'twofold' ),
				'id'      => 'gallery_slug',
				'type'    => 'text',
				'section' => 'general',
				'std'     => 'gallery',
			),
			array(
				'label'   => esc_html__( 'Album Slug', 'twofold' ),
				'id'      => 'album_slug',
				'type'    => 'text',
				'section' => 'general',
				'std'     => 'album',
			),
			array(
				'label'   => esc_html__( 'Collection Slug', 'twofold' ),
				'id'      => 'collection_slug',
				'type'    => 'text',
				'section' => 'general',
				'std'     => 'collection',
			),
			array(
				'id'      => 'header_tab1',
				'label'   => esc_html__( 'General Settings', 'twofold' ),
				'type'    => 'tab',
				'section' => 'header',
			),
			array(
				'label'   => esc_html__( 'Logo Position', 'twofold' ),
				'id'      => 'logo_position',
				'type'    => 'radio',
				'desc'    => esc_html__( 'Where would you like to show your logo?', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Left', 'twofold' ),
						'value' => 'thb-logo-left',
					),
					array(
						'label' => esc_html__( 'Center', 'twofold' ),
						'value' => 'thb-logo-center',
					),
				),
				'std'     => 'thb-logo-left',
				'section' => 'header',
			),
			array(
				'label'   => esc_html__( 'Mobile Menu Position', 'twofold' ),
				'id'      => 'menu_position',
				'type'    => 'radio',
				'desc'    => esc_html__( 'Where would you like to show your menu?', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Left', 'twofold' ),
						'value' => 'thb-menu-left',
					),
					array(
						'label' => esc_html__( 'Right', 'twofold' ),
						'value' => 'thb-menu-right',
					),
				),
				'std'     => 'thb-menu-left',
				'section' => 'header',
			),
			array(
				'label'   => esc_html__( 'Menu Type', 'twofold' ),
				'id'      => 'menu_type',
				'type'    => 'radio',
				'desc'    => __( 'This changes how the menu is displayed. <strong>Only available in Left Logo option.</strong>', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Mobile Icon', 'twofold' ),
						'value' => 'thb-mobile-icon',
					),
					array(
						'label' => esc_html__( 'Full Menu on Top', 'twofold' ),
						'value' => 'thb-full-menu',
					),
					array(
						'label' => esc_html__( 'Full Menu on Left', 'twofold' ),
						'value' => 'thb-full-menu-left',
					),
				),
				'std'     => 'thb-mobile-icon',
				'section' => 'header',
			),
			array(
				'id'        => 'menu_margin',
				'label'     => esc_html__( 'Top Level Item Margin', 'twofold' ),
				'desc'      => esc_html__( 'If you want to fit more menu items to the given space, you can decrease the margin between them here. The default margin is 25px', 'twofold' ),
				'type'      => 'measurement',
				'section'   => 'header',
				'condition' => 'menu_type:is(thb-full-menu)',
			),
			array(
				'label'        => esc_html__( 'Mobile Menu Animation Speed', 'twofold' ),
				'id'           => 'menu_speed',
				'type'         => 'numeric-slider',
				'desc'         => esc_html__( 'This changes the speed of the menu items appearing. A larger value means a slower animation.', 'twofold' ),
				'min_max_step' => '0.1,1.00,0.01',
				'std'          => '0.5',
				'section'      => 'header',
			),
			array(
				'label'   => esc_html__( 'Submenu Behaviour', 'twofold' ),
				'id'      => 'submenu_behaviour',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can choose how your + signs work', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Default - Clickable parent links', 'twofold' ),
						'value' => 'thb-default',
					),
					array(
						'label' => esc_html__( 'Open Submenu - Parent links open submenus', 'twofold' ),
						'value' => 'thb-submenu',
					),
				),
				'std'     => 'thb-default',
				'section' => 'header',
			),
			array(
				'id'      => 'header_tab2',
				'label'   => esc_html__( 'Logo Settings', 'twofold' ),
				'type'    => 'tab',
				'section' => 'header',
			),
			array(
				'label'   => esc_html__( 'Light Logo Upload', 'twofold' ),
				'id'      => 'logo_light',
				'type'    => 'upload',
				'desc'    => __( 'You can upload your own logo here. Since this theme is retina-ready, <strong>please upload a double size image.</strong>', 'twofold' ),
				'section' => 'header',
			),
			array(
				'label'   => esc_html__( 'Dark Logo Upload', 'twofold' ),
				'id'      => 'logo_dark',
				'type'    => 'upload',
				'desc'    => __( 'You can upload your own logo here. Since this theme is retina-ready, <strong>please upload a double size image.</strong>', 'twofold' ),
				'section' => 'header',
			),
			array(
				'label'   => esc_html__( 'Logo Height', 'twofold' ),
				'id'      => 'logo_height',
				'type'    => 'measurement',
				'desc'    => esc_html__( 'You can modify the logo height from here. This is maximum height, so your logo may get smaller depending on spacing inside header', 'twofold' ),
				'section' => 'header',
			),
			array(
				'label'   => esc_html__( 'Mobile Logo Height', 'twofold' ),
				'id'      => 'mobile_logo_height',
				'type'    => 'measurement',
				'desc'    => esc_html__( 'You can modify the logo height for the mobile here.', 'twofold' ),
				'section' => 'header',
			),
			array(
				'id'      => 'shop_tab0',
				'label'   => esc_html__( 'General', 'twofold' ),
				'type'    => 'tab',
				'section' => 'shop',
			),
			array(
				'label'   => esc_html__( 'Shop Sidebar', 'twofold' ),
				'id'      => 'shop_sidebar',
				'type'    => 'radio',
				'desc'    => esc_html__( 'Would you like to display sidebar on shop main and category pages?', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'No Sidebar', 'twofold' ),
						'value' => 'no',
					),
					array(
						'label' => esc_html__( 'Right Sidebar', 'twofold' ),
						'value' => 'right',
					),
					array(
						'label' => esc_html__( 'Left Sidebar', 'twofold' ),
						'value' => 'left',
					),
				),
				'std'     => 'no',
				'section' => 'shop',
			),
			array(
				'label'   => esc_html__( 'Products Per Page', 'twofold' ),
				'id'      => 'products_per_page',
				'type'    => 'text',
				'section' => 'shop',
				'std'     => '12',
			),
			array(
				'label'        => esc_html__( 'Products Per Row', 'twofold' ),
				'id'           => 'products_per_row',
				'std'          => '4',
				'type'         => 'numeric-slider',
				'section'      => 'shop',
				'min_max_step' => '2,6,1',
			),
			array(
				'id'      => 'misc_tab1',
				'label'   => esc_html__( 'General', 'twofold' ),
				'type'    => 'tab',
				'section' => 'misc',
			),
			array(
				'label'   => esc_html__( 'Use Combined JavaScript Library?', 'twofold' ),
				'id'      => 'thb_combined_libraries',
				'type'    => 'on_off',
				'desc'    => esc_html__( 'When disabled, each javascript library will be loaded on its own. It will allow for greater control using plugins, but may hinder site speed as multiple files will be loaded instead of one.', 'twofold' ),
				'std'     => 'on',
				'section' => 'misc',
			),
			array(
				'label'   => esc_html__( 'Extra CSS', 'twofold' ),
				'id'      => 'extra_css',
				'type'    => 'css',
				'desc'    => esc_html__( 'Any CSS that you would like to add to the theme.', 'twofold' ),
				'section' => 'misc',
			),
			array(
				'id'      => 'misc_tab12',
				'label'   => esc_html__( '404 Page', 'twofold' ),
				'type'    => 'tab',
				'section' => 'misc',
			),
			array(
				'label'   => esc_html__( '404 Page Image', 'twofold' ),
				'id'      => '404-image',
				'type'    => 'upload',
				'desc'    => esc_html__( 'This will change the actual 404 image in the middle.', 'twofold' ),
				'section' => 'misc',
			),
			array(
				'id'      => 'misc_tab13',
				'label'   => esc_html__( 'Preloader', 'twofold' ),
				'type'    => 'tab',
				'section' => 'misc',
			),
			array(
				'label'   => esc_html__( 'Preloader Image', 'twofold' ),
				'id'      => 'preloader-image',
				'type'    => 'upload',
				'desc'    => esc_html__( 'This will change the preloader logo in the middle. Should be 500x500 pixels maximum.', 'twofold' ),
				'section' => 'misc',
			),
			array(
				'id'      => 'customization_tab0',
				'label'   => esc_html__( 'Colors', 'twofold' ),
				'type'    => 'tab',
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Accent Color', 'twofold' ),
				'id'      => 'accent_color',
				'type'    => 'colorpicker',
				'std'     => '#e03737',
				'desc'    => esc_html__( 'Change the accent color used throughout the theme', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Accent Color 2', 'twofold' ),
				'id'      => 'accent_color2',
				'type'    => 'colorpicker',
				'std'     => '#fcef1a',
				'desc'    => esc_html__( 'Change the accent color used throughout the theme', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'id'      => 'customization_tab2',
				'label'   => esc_html__( 'Typography', 'twofold' ),
				'type'    => 'tab',
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Font Subsets', 'twofold' ),
				'id'      => 'font_subsets',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can add additional character subset specific to your language.', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'No Subset', 'twofold' ),
						'value' => 'no-subset',
					),
					array(
						'label' => esc_html__( 'Greek', 'twofold' ),
						'value' => 'greek',
					),
					array(
						'label' => esc_html__( 'Cyrillic', 'twofold' ),
						'value' => 'cyrillic',
					),
					array(
						'label' => esc_html__( 'Vietnamese', 'twofold' ),
						'value' => 'vietnamese',
					),
				),
				'std'     => 'no-subset',
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Title Typography', 'twofold' ),
				'id'      => 'title_type',
				'type'    => 'typography',
				'desc'    => esc_html__( 'Font Settings for the titles', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Body Text Typography', 'twofold' ),
				'id'      => 'body_type',
				'type'    => 'typography',
				'desc'    => esc_html__( 'Font Settings for general body font', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Menu Typography', 'twofold' ),
				'id'      => 'menu_fonttype',
				'type'    => 'typography',
				'desc'    => esc_html__( 'Font Settings for the mobile and the full menu', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'id'      => 'customization_tab3',
				'label'   => esc_html__( 'Typekit Support', 'twofold' ),
				'type'    => 'tab',
				'section' => 'customization',
			),
			array(
				'id'      => 'typekit_text',
				'label'   => esc_html__( 'About Typekit Support', 'twofold' ),
				'desc'    => esc_html__( 'Please make sure that you enter your Typekit ID or the fonts wont work. After adding Typekit Font Names, these names will appear on the font selection dropdown on the Typography tab.', 'twofold' ),
				'std'     => '',
				'type'    => 'textblock',
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Typekit Kit ID', 'twofold' ),
				'id'      => 'typekit_id',
				'type'    => 'text',
				'desc'    => __( 'Paste the provided Typekit Kit ID. <small>Usually 6-7 random letters</small>', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Typekit Font Names', 'twofold' ),
				'id'      => 'typekit_fonts',
				'type'    => 'text',
				'desc'    => __( 'Enter your Typekit Font Name, seperated by comma. For example: futura-pt,aktiv-grotesk <strong>Do not leave spaces between commas</strong>', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'id'      => 'customization_tab4',
				'label'   => esc_html__( 'Font Adjustments', 'twofold' ),
				'type'    => 'tab',
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Album Title Font Typography', 'twofold' ),
				'id'      => 'album_font',
				'type'    => 'typography',
				'desc'    => esc_html__( 'Font Settings for album titles', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Full Menu Font Adjustment', 'twofold' ),
				'id'      => 'full_menu_font',
				'type'    => 'typography',
				'desc'    => esc_html__( 'Font Settings for menu.', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Mobile Menu Font Adjustment', 'twofold' ),
				'id'      => 'menu_font',
				'type'    => 'typography',
				'desc'    => esc_html__( 'Font Settings for menu.', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Mobile Menu Sub-Menu Font Adjustment', 'twofold' ),
				'id'      => 'menu_submenu_font',
				'type'    => 'typography',
				'desc'    => esc_html__( 'Font Settings for sub-menus inside the mobile menu.', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Lightbox Caption Font', 'twofold' ),
				'id'      => 'caption_font',
				'type'    => 'typography',
				'desc'    => esc_html__( 'Font Settings for lightbox captions.', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Footer Menu Font Adjustment', 'twofold' ),
				'id'      => 'footer_font',
				'type'    => 'typography',
				'desc'    => esc_html__( 'Font Settings for menu in the footer.', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Footer Social Icon Font Adjustment', 'twofold' ),
				'id'      => 'footer_social_font',
				'type'    => 'typography',
				'desc'    => esc_html__( 'Font Settings for social icons in the footer.', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'id'      => 'customization_tab5',
				'label'   => esc_html__( 'Backgrounds', 'twofold' ),
				'type'    => 'tab',
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Fixed Header Background', 'twofold' ),
				'id'      => 'header_fixed_bg',
				'type'    => 'background',
				'desc'    => esc_html__( 'Background setting for the header when you scroll down.', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Mobile Menu Background', 'twofold' ),
				'id'      => 'mobilemenu_bg',
				'type'    => 'background',
				'desc'    => esc_html__( 'Background settings for the mobile menu.', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( '404 Page Background', 'twofold' ),
				'id'      => 'page404_bg',
				'type'    => 'background',
				'desc'    => esc_html__( 'Background settings for the 404 Page. You can change the center image inside Theme Options > Misc.', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Password Protected Page Background', 'twofold' ),
				'id'      => 'password_bg',
				'type'    => 'background',
				'desc'    => esc_html__( 'Background settings for the password protected pages', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'label'   => esc_html__( 'Preloader Background', 'twofold' ),
				'id'      => 'preloader_bg',
				'type'    => 'background',
				'desc'    => esc_html__( 'Background settings for the Preloader. You can change the center image inside Theme Options > Misc.', 'twofold' ),
				'section' => 'customization',
			),
			array(
				'id'      => 'footer_tab1',
				'label'   => esc_html__( 'General', 'twofold' ),
				'type'    => 'tab',
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Footer Left content', 'twofold' ),
				'id'      => 'footer_left_content',
				'type'    => 'radio',
				'desc'    => esc_html__( 'You can change the left content of the footer here.', 'twofold' ),
				'choices' => array(
					array(
						'label' => esc_html__( 'Menu', 'twofold' ),
						'value' => 'menu',
					),
					array(
						'label' => esc_html__( 'Text', 'twofold' ),
						'value' => 'text',
					),
				),
				'std'     => 'menu',
				'section' => 'footer',
			),
			array(
				'label'     => esc_html__( 'Text Content', 'twofold' ),
				'id'        => 'footer_left_text',
				'type'      => 'textarea',
				'desc'      => esc_html__( 'Text Content of the footer', 'twofold' ),
				'section'   => 'footer',
				'condition' => 'footer_left_content:is(text)',
			),
			array(
				'id'      => 'footer_tab2',
				'label'   => esc_html__( 'Social Links in Footer', 'twofold' ),
				'type'    => 'tab',
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Facebook Link', 'twofold' ),
				'id'      => 'fb_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Facebook profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Pinterest Link', 'twofold' ),
				'id'      => 'pinterest_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Pinterest profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Twitter Link', 'twofold' ),
				'id'      => 'twitter_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Twitter profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Linkedin Link', 'twofold' ),
				'id'      => 'linkedin_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Linkedin profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Instagram Link', 'twofold' ),
				'id'      => 'instragram_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Instagram profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Xing Link', 'twofold' ),
				'id'      => 'xing_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Xing profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Tumblr Link', 'twofold' ),
				'id'      => 'tumblr_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Tumblr profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Vkontakte Link', 'twofold' ),
				'id'      => 'vk_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Vkontakte profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'SoundCloud Link', 'twofold' ),
				'id'      => 'soundcloud_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'SoundCloud profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Dribbble Link', 'twofold' ),
				'id'      => 'dribbble_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Dribbbble profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'YouTube Link', 'twofold' ),
				'id'      => 'youtube_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Youtube profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Spotify Link', 'twofold' ),
				'id'      => 'spotify_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Spotify profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Behance Link', 'twofold' ),
				'id'      => 'behance_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Behance profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'DeviantArt Link', 'twofold' ),
				'id'      => 'deviantart_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'DeviantArt profile/page link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Vimeo Link', 'twofold' ),
				'id'      => 'vimeo_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Vimeo profile/video link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( '500px Link', 'twofold' ),
				'id'      => 'fivehundred_link',
				'type'    => 'text',
				'desc'    => esc_html__( '500px profile link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'label'   => esc_html__( 'Flickr Link', 'twofold' ),
				'id'      => 'flickr_link',
				'type'    => 'text',
				'desc'    => esc_html__( 'Flickr link', 'twofold' ),
				'section' => 'footer',
			),
			array(
				'id'      => 'contact_text',
				'label'   => esc_html__( 'About Contact Page Settings', 'twofold' ),
				'desc'    => esc_html__( 'These settings will be used for the map inside Contact Page template.', 'twofold' ),
				'std'     => '',
				'type'    => 'textblock',
				'section' => 'contact',
			),
			array(
				'label'   => esc_html__( 'Display Map?', 'twofold' ),
				'id'      => 'contact_map',
				'type'    => 'on_off',
				'desc'    => esc_html__( 'You can disable map if you want', 'twofold' ),
				'section' => 'contact',
				'std'     => 'on',
			),
			array(
				'label'   => esc_html__( 'Google Maps API Key', 'twofold' ),
				'id'      => 'map_api_key',
				'type'    => 'text',
				'desc'    => __( 'Please enter the Google Maps Api Key. <small>You need to create a browser API key. For more information, please visit: <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">https://developers.google.com/maps/documentation/javascript/get-api-key</a></small>', 'twofold' ),
				'section' => 'contact',
			),
			array(
				'label'        => esc_html__( 'Map Zoom Amount', 'twofold' ),
				'id'           => 'contact_zoom',
				'desc'         => esc_html__( 'Value should be between 1-18, 1 being the entire earth and 18 being right at street level.', 'twofold' ),
				'std'          => '17',
				'type'         => 'numeric-slider',
				'section'      => 'contact',
				'min_max_step' => '1,18,1',
			),
			array(
				'label'   => esc_html__( 'Map Pin Image', 'twofold' ),
				'id'      => 'map_pin_image',
				'type'    => 'upload',
				'desc'    => esc_html__( 'If you would like to use your own pin, you can upload it here', 'twofold' ),
				'section' => 'contact',
			),
			array(
				'label'   => esc_html__( 'Map Center Latitude', 'twofold' ),
				'id'      => 'map_center_lat',
				'type'    => 'text',
				'desc'    => __( 'Please enter the latitude for the maps center point. <small>You can get lat-long coordinates using <a href="http://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Latlong.net</a></small>', 'twofold' ),
				'section' => 'contact',
			),
			array(
				'label'   => esc_html__( 'Map Center Longtitude', 'twofold' ),
				'id'      => 'map_center_long',
				'type'    => 'text',
				'desc'    => esc_html__( 'Please enter the longitude for the maps center point.', 'twofold' ),
				'section' => 'contact',
			),
			array(
				'label'    => esc_html__( 'Google Map Pin Locations', 'twofold' ),
				'id'       => 'map_locations',
				'type'     => 'list-item',
				'desc'     => esc_html__( 'Coordinates to shop on the map', 'twofold' ),
				'settings' => array(
					array(
						'label' => esc_html__( 'Coordinates', 'twofold' ),
						'id'    => 'lat_long',
						'type'  => 'text',
						'desc'  => __( 'Coordinates of this location separated by comma. <small>You can get lat-long coordinates using <a href="http://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Latlong.net</a></small>', 'twofold' ),
						'rows'  => '1',
					),
					array(
						'label' => esc_html__( 'Information', 'twofold' ),
						'id'    => 'information',
						'type'  => 'textarea',
						'desc'  => esc_html__( 'This content appears below the title of the tooltip', 'twofold' ),
						'rows'  => '2',
					),
				),
				'section'  => 'contact',
			),
			array(
				'label'   => esc_html__( 'Google Map Style', 'twofold' ),
				'id'      => 'map_style',
				'type'    => 'textarea_simple',
				'desc'    => __( 'You can use your own map style from <a href="https://snazzymaps.com/" target="_blank"Snazzymaps</a>.', 'twofold' ),
				'rows'    => '4',
				'section' => 'contact',
			),
		),
	);

	/* settings are not the same update the DB */
	if ( $saved_settings !== $custom_settings ) {
		update_option( 'option_tree_settings', $custom_settings );
	}
}

/**
 * Gallery Checkbox option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_gallery_checkbox' ) ) {

	function ot_type_gallery_checkbox( $args = array() ) {

		/* turns arguments array into variables */
		extract( $args );

		/* verify a description */
		$has_desc = $field_desc ? true : false;

		/* format setting outer wrapper */
		echo '<div class="format-setting type-category-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

		/* description */
		if ( $has_desc ) {
			echo '<div class="description">' . wp_kses_post( wp_specialchars_decode( $field_desc ) ) . '</div>'; }

		/* format setting inner wrapper */
		echo '<div class="format-setting-inner">';

		echo '<ul class="option-tree-setting-wrap option-tree-sortable" data-name="' . esc_attr( $field_id ) . '" data-id="' . esc_attr( $post_id ) . '" data-type="' . esc_attr( $type ) . '">';

		$field_value = is_array( $field_value ) ? $field_value : array();
		/* get gallery array */
		$args     = array(
			'posts_per_page' => -1,
			'post_type'      => 'gallery',
			'post_status'    => 'publish',
			'no_found_rows'  => true,
		);
		$gallerys = new WP_Query( $args );

		$gallery_ids   = wp_list_pluck( $gallerys->posts, 'ID' );
		$all_galleries = array_combine( $gallery_ids, $gallery_ids );
		$merged_array  = array_replace( $field_value, $all_galleries );

		$args     = array(
			'posts_per_page' => -1,
			'post_type'      => 'gallery',
			'post_status'    => 'publish',
			'post__in'       => $merged_array,
			'orderby'        => 'post__in',
			'no_found_rows'  => true,
		);
		$gallerys = new WP_Query( $args );
		/* build categories */
		if ( ! empty( $gallerys->posts ) ) {
			foreach ( $gallerys->posts as $gallery ) {
				echo '<li class="ui-state-default list-list-item"><div class="option-tree-setting"><div class="open">';
				echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $gallery->ID ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $gallery->ID ) . '" value="' . esc_attr( $gallery->ID ) . '" ' . ( isset( $field_value[ $gallery->ID ] ) ? checked( $field_value[ $gallery->ID ], $gallery->ID, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
				echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $gallery->ID ) . '">' . esc_attr( $gallery->post_title ) . ' (' . esc_attr( $gallery->post_name ) . ')</label>';
				echo '</li>';
			}
		} else {
			echo '<li>' . esc_html__( 'No Galleries Found', 'twofold' ) . '</li>';
		}

		echo '</ul>';

		echo '</div>';

		echo '</div>';

	}
}

/**
 * Album Checkbox option type.
 *
 * See @ot_display_by_type to see the full list of available arguments.
 *
 * @param     array     An array of arguments.
 * @return    string
 *
 * @access    public
 * @since     2.0
 */
if ( ! function_exists( 'ot_type_album_checkbox' ) ) {

	function ot_type_album_checkbox( $args = array() ) {

		/* turns arguments array into variables */
		extract( $args );

		/* verify a description */
		$has_desc = $field_desc ? true : false;

		/* format setting outer wrapper */
		echo '<div class="format-setting type-category-checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

		/* description */
		if ( $has_desc ) {
			echo '<div class="description">' . wp_kses_post( wp_specialchars_decode( $field_desc ) ) . '</div>'; }

		/* format setting inner wrapper */
		echo '<div class="format-setting-inner">';

		echo '<ul class="option-tree-setting-wrap option-tree-sortable" data-name="' . esc_attr( $field_id ) . '" data-id="' . esc_attr( $post_id ) . '" data-type="' . esc_attr( $type ) . '">';

		$field_value = is_array( $field_value ) ? $field_value : array();
		/* get album array */
		$args         = array(
			'posts_per_page' => -1,
			'post_type'      => 'album',
			'post_status'    => 'publish',
			'no_found_rows'  => true,
		);
		$albums       = new WP_Query( $args );
		$album_ids    = wp_list_pluck( $albums->posts, 'ID' );
		$all_albums   = array_combine( $album_ids, $album_ids );
		$merged_array = array_replace( $field_value, $all_albums );

		$args   = array(
			'posts_per_page' => -1,
			'post_type'      => 'album',
			'post_status'    => 'publish',
			'post__in'       => $merged_array,
			'orderby'        => 'post__in',
			'no_found_rows'  => true,
		);
		$albums = new WP_Query( $args );
		/* build categories */
		if ( ! empty( $albums->posts ) ) {
			foreach ( $albums->posts as $album ) {
				echo '<li class="ui-state-default list-list-item"><div class="option-tree-setting"><div class="open">';

				echo '<input type="checkbox" name="' . esc_attr( $field_name ) . '[' . esc_attr( $album->ID ) . ']" id="' . esc_attr( $field_id ) . '-' . esc_attr( $album->ID ) . '" value="' . esc_attr( $album->ID ) . '" ' . ( isset( $field_value[ $album->ID ] ) ? checked( $field_value[ $album->ID ], $album->ID, false ) : '' ) . ' class="option-tree-ui-checkbox ' . esc_attr( $field_class ) . '" />';
				echo '<label for="' . esc_attr( $field_id ) . '-' . esc_attr( $album->ID ) . '">' . esc_attr( $album->post_title ) . ' (' . esc_attr( $album->post_name ) . ')</label>';
				echo '</div></div></li>';
			}
		} else {
			echo '<li>' . esc_html__( 'No Albums Found', 'twofold' ) . '</li>';
		}

		echo '</ul>';

		echo '</div>';

		echo '</div>';

	}
}
