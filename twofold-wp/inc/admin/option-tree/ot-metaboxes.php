<?php
/**
 * Initialize the meta boxes.
 */
add_action( 'admin_init', 'thb_custom_meta_boxes' );

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types
 * in demo-theme-options.php.
 *
 * @return    void
 *
 * @access    private
 * @since     2.0
 */


function thb_custom_meta_boxes() {

	/**
	 * Create a custom meta boxes array that we pass to
	 * the OptionTree Meta Box API Class.
	 */

	$page_meta_box = array(
		'id'       => 'page_settings',
		'title'    => esc_html__( 'Page Settings', 'twofold' ),
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'id'    => 'tab1',
				'label' => esc_html__( 'Home Page Layout', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'id'    => 'homepage_text',
				'label' => esc_html__( 'About Home Page Settings', 'twofold' ),
				'desc'  => esc_html__( 'Below settings are used when the Home Page template is selected. Not all slide settings are used for every layout.', 'twofold' ),
				'type'  => 'textblock',
			),
			array(
				'label'   => esc_html__( 'Home Page Layout', 'twofold' ),
				'id'      => 'home_layout',
				'type'    => 'radio',
				'choices' => array(
					array(
						'label' => esc_html__( 'Image Slider', 'twofold' ),
						'value' => 'style1',
					),
					array(
						'label' => esc_html__( 'Image Slider with Ken Burns Effect', 'twofold' ),
						'value' => 'style4',
					),
					array(
						'label' => esc_html__( 'Image Slider with Thumbnails', 'twofold' ),
						'value' => 'style2',
					),
					array(
						'label' => esc_html__( 'Vertical Content Slider - Cube Effect', 'twofold' ),
						'value' => 'style3',
					),
					array(
						'label' => esc_html__( 'Vertical Split Slider', 'twofold' ),
						'value' => 'style5',
					),
					array(
						'label' => esc_html__( 'Vertical Split Slider - Double images (make sure you have even count of images)', 'twofold' ),
						'value' => 'style6',
					),
					array(
						'label' => esc_html__( 'Full Screen Video', 'twofold' ),
						'value' => 'style7',
					),
					array(
						'label' => esc_html__( 'Split Tile', 'twofold' ),
						'value' => 'style8',
					),
				),
				'std'     => 'style1',
			),
			array(
				'label'     => esc_html__( 'Home Page Slider Effect', 'twofold' ),
				'id'        => 'home_effect',
				'type'      => 'radio',
				'choices'   => array(
					array(
						'label' => esc_html__( 'Slide', 'twofold' ),
						'value' => 'slide',
					),
					array(
						'label' => esc_html__( 'Fade', 'twofold' ),
						'value' => 'fade',
					),
				),
				'std'       => 'slide',
				'operator'  => 'or',
				'condition' => 'home_layout:is(style1),home_layout:is(style2),home_layout:is(style4)',
			),
			array(
				'label'     => esc_html__( 'Auto Play', 'twofold' ),
				'id'        => 'home_autoplay',
				'type'      => 'on_off',
				'desc'      => esc_html__( 'Do you want to auto-play the slides?', 'twofold' ),
				'std'       => 'off',
				'operator'  => 'or',
				'condition' => 'home_layout:is(style1),home_layout:is(style2),home_layout:is(style3),home_layout:is(style4),home_layout:is(style5),home_layout:is(style6),home_layout:is(style8),home_layout:is(style9),home_layout:is(style10)',
			),
			array(
				'label'     => esc_html__( 'Pagination Lines', 'twofold' ),
				'id'        => 'home_pagination',
				'type'      => 'on_off',
				'desc'      => esc_html__( 'Do you want to display the pagination lines on the side?', 'twofold' ),
				'std'       => 'on',
				'operator'  => 'or',
				'condition' => 'home_layout:is(style3),home_layout:is(style5),home_layout:is(style6)',
			),
			array(
				'id'           => 'home_autoplay_speed',
				'label'        => esc_html__( 'Auto Play Duration', 'twofold' ),
				'desc'         => esc_html__( 'How long it should pass before the slides change. The numbers are in miliseconds (ms)', 'twofold' ),
				'std'          => '5000',
				'type'         => 'numeric-slider',
				'min_max_step' => '500,10000,100',
				'condition'    => 'home_autoplay:is(on)',
			),
			array(
				'label'   => esc_html__( 'Video Type', 'twofold' ),
				'id'      => 'home_video_type',
				'type'    => 'radio',
				'choices' => array(
					array(
						'label' => esc_html__( 'Youtube, Vimeo...', 'twofold' ),
						'value' => '3rdparty',
					),
					array(
						'label' => esc_html__( 'Self Hosted', 'twofold' ),
						'value' => 'hosted',
					),
				),
				'std'     => '3rdparty',
			),
			array(
				'label'     => esc_html__( 'Video URL', 'twofold' ),
				'id'        => 'home_video_url',
				'type'      => 'text',
				'desc'      => __( '<a href="https://codex.wordpress.org/Embeds" target="_blank">oEmbed Video Providers</a> or MP4,OGG, etc files', 'twofold' ),
				'operator'  => 'and',
				'condition' => 'home_layout:is(style7),home_video_type:is(3rdparty)',
			),
			array(
				'label'     => esc_html__( 'Self Hosted Video (mp4)', 'twofold' ),
				'id'        => 'home_video_hosted',
				'type'      => 'upload',
				'class'     => 'ot-upload-attachment-id',
				'desc'      => esc_html__( 'Select the video you want to show.', 'twofold' ),
				'operator'  => 'and',
				'condition' => 'home_layout:is(style7),home_video_type:is(hosted)',
			),
			array(
				'id'    => 'tab2',
				'label' => esc_html__( 'Home Page Slides', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'id'    => 'homepage_slides_text',
				'label' => esc_html__( 'About Home Page Slides', 'twofold' ),
				'desc'  => esc_html__( 'Below settings are used when you choose a slider as the Home Page layout.', 'twofold' ),
				'type'  => 'textblock',
			),
			array(
				'label' => esc_html__( 'Randomize Slides?', 'twofold' ),
				'id'    => 'home_random',
				'type'  => 'on_off',
				'desc'  => esc_html__( 'This will randomize the slides regardless of their order below.', 'twofold' ),
				'std'   => 'off',
			),
			array(
				'label'    => esc_html__( 'Home Page Slides', 'twofold' ),
				'id'       => 'home_slides',
				'type'     => 'list-item',
				'settings' => array(
					array(
						'label' => esc_html__( 'Description', 'twofold' ),
						'id'    => 'description',
						'type'  => 'text',
						'desc'  => esc_html__( 'Slide Description used on Cube Effect', 'twofold' ),
					),
					array(
						'label' => esc_html__( 'Slide Image', 'twofold' ),
						'id'    => 'image',
						'type'  => 'upload',
						'class' => 'ot-upload-attachment-id',
						'desc'  => esc_html__( 'Recommended image size is 1900x1200', 'twofold' ),
					),
					array(
						'label' => esc_html__( 'Logo Color', 'twofold' ),
						'id'    => 'logo_color',
						'type'  => 'radio-image',
						'std'   => 'logo-dark',
					),
					array(
						'label' => esc_html__( 'Add Button?', 'twofold' ),
						'id'    => 'home_btn',
						'type'  => 'on_off',
						'desc'  => esc_html__( 'Do you want to display a button? Used on Cube Effect', 'twofold' ),
						'std'   => 'off',
					),
					array(
						'label'     => esc_html__( 'Button Label', 'twofold' ),
						'id'        => 'btn_text',
						'type'      => 'text',
						'condition' => 'home_btn:is(on)',
					),
					array(
						'label'     => esc_html__( 'Button Link', 'twofold' ),
						'id'        => 'btn_link',
						'type'      => 'text',
						'condition' => 'home_btn:is(on)',
					),
				),
			),
			array(
				'id'    => 'tab3',
				'label' => esc_html__( 'About Page', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'id'    => 'contactpage_text',
				'label' => esc_html__( 'About Page Settings', 'twofold' ),
				'desc'  => esc_html__( 'Below settings are used when the About Page template is selected.', 'twofold' ),
				'type'  => 'textblock',
			),
			array(
				'label'   => esc_html__( 'Layout', 'twofold' ),
				'id'      => 'about_layout',
				'type'    => 'radio',
				'choices' => array(
					array(
						'label' => esc_html__( 'Style 1', 'twofold' ),
						'value' => 'style1',
					),
					array(
						'label' => esc_html__( 'Style 2', 'twofold' ),
						'value' => 'style2',
					),
				),
				'std'     => 'style1',
			),
			array(
				'id'    => 'tab4',
				'label' => esc_html__( 'Contact Page', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'id'    => 'contactpage_text',
				'label' => esc_html__( 'About Contact Page Settings', 'twofold' ),
				'desc'  => esc_html__( 'Below settings are used when the Contact template is selected.', 'twofold' ),
				'type'  => 'textblock',
			),
			array(
				'label'   => esc_html__( 'Layout', 'twofold' ),
				'id'      => 'contact_layout',
				'type'    => 'radio',
				'choices' => array(
					array(
						'label' => esc_html__( 'Style 1', 'twofold' ),
						'value' => 'style1',
					),
					array(
						'label' => esc_html__( 'Style 2', 'twofold' ),
						'value' => 'style2',
					),
				),
				'std'     => 'style1',
			),
			array(
				'label' => esc_html__( 'Contact Form 7 Shortcode', 'twofold' ),
				'id'    => 'contact_shortcode',
				'type'  => 'text',
				'desc'  => esc_html__( 'You can paste the Contact Form 7 shortcode here', 'twofold' ),
				'rows'  => '1',
			),
			array(
				'id'    => 'tab5',
				'label' => esc_html__( 'General Page Settings', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'label' => esc_html__( 'Page Background', 'twofold' ),
				'id'    => 'page_bg',
				'type'  => 'background',
				'desc'  => esc_html__( 'Background settings for the page.', 'twofold' ),
			),
			array(
				'label' => esc_html__( 'Show Date', 'twofold' ),
				'id'    => 'page_date',
				'type'  => 'on_off',
				'desc'  => esc_html__( 'You can toggle page date using this setting', 'twofold' ),
				'std'   => 'on',
			),
			array(
				'label' => esc_html__( 'Show Title', 'twofold' ),
				'id'    => 'page_title',
				'type'  => 'on_off',
				'desc'  => esc_html__( 'You can toggle page title using this setting', 'twofold' ),
				'std'   => 'on',
			),

		),
	);

	$collection_meta_box = array(
		'id'       => 'collection_settings',
		'title'    => esc_html__( 'Collection Settings', 'twofold' ),
		'pages'    => array( 'collection' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'id'    => 'tab1',
				'label' => esc_html__( 'Album Selection', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'label' => esc_html__( 'Show Filter?', 'twofold' ),
				'id'    => 'album_filter',
				'type'  => 'on_off',
				'desc'  => esc_html__( 'This will display a filter on the top right', 'twofold' ),
				'std'   => 'off',
			),
			array(
				'id'        => 'album_taxonomy',
				'label'     => esc_html__( 'Album Categories', 'twofold' ),
				'desc'      => esc_html__( 'Select which albums categories to show the filter for', 'twofold' ),
				'type'      => 'taxonomy-checkbox',
				'post_type' => 'album',
				'taxonomy'  => 'album-category',
				'condition' => 'album_filter:is(on)',
			),
			array(
				'id'    => 'collection_albums',
				'label' => esc_html__( 'Albums to Display', 'twofold' ),
				'type'  => 'album_checkbox',
				'desc'  => esc_html__( 'Select which albums to display inside this collection', 'twofold' ),
			),
			array(
				'id'    => 'tab2',
				'label' => esc_html__( 'Layout', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'label'     => esc_html__( 'Page Padding', 'twofold' ),
				'id'        => 'page_padding',
				'type'      => 'on_off',
				'desc'      => esc_html__( 'This will add spacing at the top and the bottom.', 'twofold' ),
				'std'       => 'off',
				'condition' => 'collection_layout:is(style1)',
			),
			array(
				'label'     => esc_html__( 'Enable True Aspect Ratio', 'twofold' ),
				'id'        => 'true_aspect_ratio',
				'type'      => 'on_off',
				'desc'      => esc_html__( 'This will force the theme to display correct aspect ratio for the photos. However, it might break the layouts.', 'twofold' ),
				'std'       => 'off',
				'operator'  => 'or',
				'condition' => 'collection_layout:is(style1),collection_layout:is(style2)',
			),
			array(
				'label'     => esc_html__( 'Columns', 'twofold' ),
				'id'        => 'style3-columns',
				'type'      => 'radio',
				'choices'   => array(
					array(
						'label' => esc_html__( '5 Columns', 'twofold' ),
						'value' => '5',
					),
					array(
						'label' => esc_html__( '4 Columns', 'twofold' ),
						'value' => '4',
					),
					array(
						'label' => esc_html__( '3 Columns', 'twofold' ),
						'value' => '3',
					),
					array(
						'label' => esc_html__( '2 Columns', 'twofold' ),
						'value' => '2',
					),
				),
				'std'       => '5',
				'operator'  => 'or',
				'condition' => 'collection_layout:is(style3),collection_layout:is(style1)',
			),
			array(
				'label' => esc_html__( 'Collection Layout Style', 'twofold' ),
				'id'    => 'collection_layout',
				'type'  => 'radio-image',
				'std'   => 'style1',
			),
		),
	);

	$album_meta_box = array(
		'id'       => 'album_settings',
		'title'    => esc_html__( 'Album Settings', 'twofold' ),
		'pages'    => array( 'album' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'id'    => 'tab1',
				'label' => esc_html__( 'Album Photos', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'label' => esc_html__( 'Display Share Icon?', 'twofold' ),
				'id'    => 'album_share',
				'type'  => 'on_off',
				'desc'  => esc_html__( 'This will show a share icon above the photos.', 'twofold' ),
				'std'   => 'on',
			),
			array(
				'id'    => 'album_gallery',
				'label' => esc_html__( 'Galleries to Display', 'twofold' ),
				'type'  => 'gallery_checkbox',
				'desc'  => esc_html__( 'Select which gallery to display inside this album', 'twofold' ),
			),
			array(
				'id'    => 'tab2',
				'label' => esc_html__( 'Layout', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'label'     => esc_html__( 'Enable True Aspect Ratio', 'twofold' ),
				'id'        => 'true_aspect_ratio',
				'type'      => 'on_off',
				'desc'      => esc_html__( 'This will force the theme to display correct aspect ratio for the photos. However, it might break the layouts.', 'twofold' ),
				'std'       => 'off',
				'operator'  => 'or',
				'condition' => 'album_layout:is(style1),album_layout:is(style2),album_layout:is(style3),album_layout:is(style4),album_layout:is(style5)',
			),
			array(
				'label' => esc_html__( 'Album Layout Style', 'twofold' ),
				'id'    => 'album_layout',
				'type'  => 'radio-image',
				'std'   => 'style1',
			),
			array(
				'id'    => 'tab3',
				'label' => esc_html__( 'Other Settings', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'label' => esc_html__( 'Enable Photo Proof?', 'twofold' ),
				'id'    => 'photo_proof',
				'type'  => 'on_off',
				'desc'  => esc_html__( 'This will enable photo proofing so you can allow customers to select images.', 'twofold' ),
				'std'   => 'off',
			),
			array(
				'label'     => esc_html__( 'Enable Photo Proof Download Button', 'twofold' ),
				'id'        => 'photo_proof_download',
				'type'      => 'on_off',
				'desc'      => esc_html__( 'This will add a download button for the checked images with the photo-proof', 'twofold' ),
				'std'       => 'off',
				'condition' => 'photo_proof:is(on)',
			),
			array(
				'label' => esc_html__( 'Display Album Navigation?', 'twofold' ),
				'id'    => 'album_navigation',
				'type'  => 'on_off',
				'desc'  => esc_html__( 'This displays the album navigation.', 'twofold' ),
				'std'   => 'on',
			),
		),
	);

	$gallery_meta_box = array(
		'id'       => 'gallery_settings',
		'title'    => esc_html__( 'Gallery Settings', 'twofold' ),
		'pages'    => array( 'gallery' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'id'    => 'tab1',
				'label' => esc_html__( 'Gallery Photos', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'id'        => 'gallery_photos',
				'type'      => 'gallery',
				'post_type' => 'post',
			),
			array(
				'id'    => 'tab2',
				'label' => esc_html__( 'Layout', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'label' => esc_html__( 'Page Padding', 'twofold' ),
				'id'    => 'page_padding',
				'type'  => 'on_off',
				'desc'  => esc_html__( 'This will add spacing at the top and the bottom.', 'twofold' ),
				'std'   => 'off',
			),
			array(
				'label'     => esc_html__( 'Enable True Aspect Ratio', 'twofold' ),
				'id'        => 'true_aspect_ratio',
				'type'      => 'on_off',
				'desc'      => esc_html__( 'This will force the theme to display correct aspect ratio for the photos. However, it might break the layouts.', 'twofold' ),
				'std'       => 'off',
				'operator'  => 'or',
				'condition' => 'gallery_layout:is(style1),gallery_layout:is(style2),gallery_layout:is(style3),gallery_layout:is(style4),gallery_layout:is(style5)',
			),
			array(
				'label'     => esc_html__( 'Grid Columns', 'twofold' ),
				'id'        => 'columns',
				'type'      => 'radio',
				'choices'   => array(
					array(
						'label' => esc_html__( '5 Columns', 'twofold' ),
						'value' => 'thb-twenty',
					),
					array(
						'label' => esc_html__( '4 Columns', 'twofold' ),
						'value' => 'large-3',
					),
					array(
						'label' => esc_html__( '3 Columns', 'twofold' ),
						'value' => 'large-4',
					),
					array(
						'label' => esc_html__( '2 Columns', 'twofold' ),
						'value' => 'large-6',
					),
				),
				'std'       => 'thb-twenty',
				'condition' => 'gallery_layout:is(style4)',
			),
			array(
				'label' => esc_html__( 'Gallery Layout Style', 'twofold' ),
				'id'    => 'gallery_layout',
				'type'  => 'radio-image',
				'std'   => 'style1',
			),
			array(
				'id'    => 'tab3',
				'label' => esc_html__( 'Photo Proof', 'twofold' ),
				'type'  => 'tab',
			),
			array(
				'label' => esc_html__( 'Enable Photo Proof?', 'twofold' ),
				'id'    => 'photo_proof',
				'type'  => 'on_off',
				'desc'  => esc_html__( 'This will enable photo proofing so you can allow customers to select images.', 'twofold' ),
				'std'   => 'off',
			),
			array(
				'label'     => esc_html__( 'Enable Photo Proof Download Button', 'twofold' ),
				'id'        => 'photo_proof_download',
				'type'      => 'on_off',
				'desc'      => esc_html__( 'This will add a download button for the checked images with the photo-proof', 'twofold' ),
				'std'       => 'off',
				'condition' => 'photo_proof:is(on)',
			),
		),
	);

	/**
	 * Register our meta boxes using the
	 * ot_register_meta_box() function.
	 */
	ot_register_meta_box( $page_meta_box );
	ot_register_meta_box( $collection_meta_box );
	ot_register_meta_box( $album_meta_box );
	ot_register_meta_box( $gallery_meta_box );
}
