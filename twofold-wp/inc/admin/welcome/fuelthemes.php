<?php
class Thb_Theme_Admin {
	/**
	 *  Main instance
	 */
	private static $_instance;

	/**
	 *  Theme Name
	 */
	public static $thb_theme_name;

	/**
	 *  Theme Version
	 */
	public static $thb_theme_version;

	/**
	 *  Theme Slug
	 */
	public static $thb_theme_slug;

	/**
	 *  Theme Directory
	 */
	public static $thb_theme_directory;

	/**
	 *  Theme Directory URL
	 */
	public static $thb_theme_directory_uri;

	/**
	 *  Product Key
	 */
	public static $thb_product_key;

	/**
	 *  Product Key Expiration
	 */
	public static $thb_product_key_expired;

	/**
	 *  Theme Constructor executed only once per request
	 */
	public function __construct() {
		if ( self::$_instance ) {
			_doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', '2.0' );
		}
	}

	/**
	 * You cannot clone this class
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', '2.0' );
	}

	/**
	 * You cannot unserialize instances of this class
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, 'Cheatin&#8217; huh?', '2.0' );
	}

	public static function instance() {
		global $thb_Theme_Admin;
		if ( ! self::$_instance ) {
			self::$_instance = new self();
			$thb_Theme_Admin = self::$_instance;

			// Theme Variables
			$theme                         = wp_get_theme();
			self::$thb_theme_name          = $theme->get( 'Name' );
			self::$thb_theme_version       = $theme->parent() ? $theme->parent()->get( 'Version' ) : $theme->get( 'Version' );
			self::$thb_theme_slug          = $theme->template;
			self::$thb_theme_directory     = get_template_directory() . '/';
			self::$thb_theme_directory_uri = get_template_directory_uri() . '/';

			self::$thb_product_key         = get_option( 'thb_' . self::$thb_theme_slug . '_key' );
			self::$thb_product_key_expired = get_option( 'thb_' . self::$thb_theme_slug . '_key_expired' );

			// After Setup Theme
			add_action( 'after_setup_theme', array( self::$_instance, 'afterSetupTheme' ) );

			// Setup Admin Menus
			if ( is_admin() ) {
				self::$_instance->initAdminPages();
			}
		}

		return self::$_instance;
	}
	/**
	 *  After Theme Setup
	 */
	public function afterSetupTheme() {
		/* WooCommerce Support */
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );

		/* WooCommerce Products per Page */
		add_filter( 'loop_shop_per_page', 'thb_shops_per_page', 20 );

		function thb_shops_per_page( $products_per_page ) {
			$products_per_page_get = filter_input( INPUT_GET, 'products_per_page', FILTER_VALIDATE_INT );
			$products_per_page     = isset( $products_per_page_get ) ? $products_per_page_get : ot_get_option( 'products_per_page' );
			return $products_per_page;
		}

		/* Gutenberg */
		add_theme_support( 'align-wide' );
		add_theme_support( 'align-full' );
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Accent Color', 'twofold' ),
					'slug'  => 'thb-accent',
					'color' => ot_get_option( 'accent_color', '#e03737' ),
				),
			)
		);

		/* Text Domain */
		load_theme_textdomain( 'twofold', get_stylesheet_directory() . '/inc/languages' );

		/* Background Support */
		add_theme_support(
			'custom-background',
			array(
				'default-color'    => 'ffffff',
				'wp-head-callback' => 'thb_change_custom_background_cb',
			)
		);

		/* Title Support */
		add_theme_support( 'title-tag' );

		/* Required Settings */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 1170; }
		add_theme_support( 'automatic-feed-links' );

		/* Image Settings */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 80, 75, true );
		add_image_size( 'twofold-1', 800, 600, true );
		add_image_size( 'twofold-2', 9999, 380, false );
		add_image_size( 'twofold-3', 1200, 900, true );
		add_image_size( 'twofold-blog-style1', 800, 9999, false );
		add_image_size( 'twofold-blog-style2', 1050, 640, true );
		add_image_size( 'twofold-blog-style3', 600, 400, true );
		add_image_size( 'twofold-collection-style1', 320, 180, true );
		add_image_size( 'twofold-collection-style1-ta', 9999, 180, false );

		if ( false === get_option( 'medium_crop' ) ) {
			add_option( 'medium_crop', '1' );
		} else {
			update_option( 'medium_crop', '1' );
		}

		/* HTML5 Galleries */
		add_theme_support( 'html5', array( 'gallery', 'caption' ) );

		/* Register Menus */
		add_theme_support( 'nav-menus' );
		register_nav_menus(
			array(
				'nav-menu'    => esc_html__( 'Navigation Menu', 'twofold' ),
				'footer-menu' => esc_html__( 'Footer Menu', 'twofold' ),
			)
		);

		$sidebars = ot_get_option( 'sidebars' );
		if ( ! empty( $sidebars ) ) {
			foreach ( $sidebars as $sidebar ) {
				register_sidebar(
					array(
						'name'          => $sidebar['title'],
						'id'            => $sidebar['id'],
						'description'   => '',
						'before_widget' => '<div id="%1$s" class="widget cf %2$s">',
						'after_widget'  => '</div>',
						'before_title'  => '<h6>',
						'after_title'   => '</h6>',
					)
				);
			}
		}
	}
	public function thbDemos() {
		return array(
			array(
				'import_file_name'         => 'Light Demo',
				'import_file_url'          => self::$thb_theme_directory_uri . 'demo-import/light/demo-content.xml',
				'import_theme_options_url' => self::$thb_theme_directory_uri . 'demo-import/light/theme-options.txt',
				'import_image'             => self::$thb_theme_directory_uri . 'assets/img/admin/demos/light.jpg',
				'import_demo_url'          => 'https://twofold.wpthemestudios.com/',
			),
			array(
				'import_file_name'         => 'Dark Demo',
				'import_file_url'          => self::$thb_theme_directory_uri . 'demo-import/dark/demo-content.xml',
				'import_theme_options_url' => self::$thb_theme_directory_uri . 'demo-import/dark/theme-options.txt',
				'import_image'             => self::$thb_theme_directory_uri . 'assets/img/admin/demos/dark.jpg',
				'import_demo_url'          => 'https://twofold.wpthemestudios.com/dark-demo',
			),
		);
	}
	/**
	 *  Inintialize Admin Pages
	 */
	public function initAdminPages() {
		global $pagenow;

		// Script and styles
		add_action( 'admin_enqueue_scripts', array( & $this, 'adminPageEnqueue' ) );

		// Menu Pages
		add_action( 'admin_menu', array( & $this, 'adminSetupMenu' ), 1 );

		// Theme Options Redirect
		if ( 'admin.php' == $pagenow && 'thb-theme-options' == $_GET['page'] ) {
			if ( ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
				wp_redirect( admin_url( 'themes.php?page=ot-theme-options' ) );
				die();
			}
		}

		// Redirect to Main Page
		add_action( 'after_switch_theme', array( & $this, 'thb_activation_redirect' ) );

		// Ajax Option Update
		add_action( 'wp_ajax_thb_update_options', array( & $this, 'thb_update_options' ) );
		add_action( 'wp_ajax_nopriv_thb_update_options', array( & $this, 'thb_update_options' ) );

		// Admin Notices
		add_action( 'admin_notices', array( & $this, 'thb_admin_notices' ) );

		// Theme Updates
		add_action( 'admin_init', array( & $this, 'thb_theme_update' ) );

		// Plugin Update Nonce
		add_action( 'register_sidebar', array( & $this, 'thb_theme_admin_init' ) );

	}
	function thb_admin_notices() {
		$remote_ver = get_option( 'thb_' . self::$thb_theme_slug . '_remote_ver' ) ? get_option( 'thb_' . self::$thb_theme_slug . '_remote_ver' ) : self::$thb_theme_version;
		$local_ver  = self::$thb_theme_version;

		if ( version_compare( $local_ver, $remote_ver, '<' ) ) {
			if (
				( ! self::$thb_product_key && ( self::$thb_product_key_expired == 0 ) ) ||
				( self::$thb_product_key && ( self::$thb_product_key_expired == 1 ) )
			) {
				echo '<div class="notice is-dismissible error thb_admin_notices">
				<p>There is an update available for the <strong>' . self::$thb_theme_name . '</strong> theme. Go to <a href="' . esc_url( admin_url( 'admin.php?page=thb-product-registration' ) ) . '">Product Registration</a> to enable theme updates.</p>
				</div>';
			}

			if ( ( self::$thb_product_key && ( self::$thb_product_key_expired == 0 ) ) ) {
				echo '<div class="notice is-dismissible error thb_admin_notices">
				<p>There is an update available for the <strong>' . self::$thb_theme_name . '</strong> theme. <a href="' . esc_url( admin_url() ) . 'update-core.php">Update now</a>.</p>
				</div>';
			}
		}
	}
	public function thb_update_options() {
		check_ajax_referer( 'thb_register_ajax', 'security' );
		$key     = !empty($_POST['key']) ? sanitize_text_field( $_POST['key'] ) : '';
		$expired = filter_input( INPUT_POST, 'expired', FILTER_VALIDATE_BOOLEAN );
		update_option( 'thb_' . self::$thb_theme_slug . '_key', $key );
		update_option( 'thb_' . self::$thb_theme_slug . '_key_expired', $expired );
	}
	public function thb_theme_update() {
		add_filter( 'pre_set_site_transient_update_themes', array( & $this, 'thb_check_for_update_theme' ) );
		add_filter( 'upgrader_pre_download', array( $this, 'thb_upgradeFilter' ), 10, 4 );
	}
	public function thb_check_for_update_plugins() {
		$args    = array(
			'timeout' => 30,
			'body'    => array(
				'item_ids'    => '242431',
				'product_key' => self::$thb_product_key,
			),
		);
		$request = wp_remote_get( self::$_instance->thb_dashboard_url( 'plugin/version' ), $args );

		$data = '';
		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			$data = json_decode( wp_remote_retrieve_body( $request ) );
		}
		return $data;
	}
	public function thb_check_for_update_theme( $transient ) {
		global $wp_filesystem;
		$args = array(
			'timeout' => 30,
			'body'    => array(
				'theme_name'  => self::$thb_theme_name,
				'product_key' => self::$thb_product_key,
			),
		);

		$request = wp_remote_get( self::$_instance->thb_dashboard_url( 'version' ), $args );

		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			$data = json_decode( wp_remote_retrieve_body( $request ) );
			update_option( 'thb_' . self::$thb_theme_slug . '_key_expired', 0 );

			if ( isset( $data->success ) && $data->success == false ) {
				self::$thb_product_key_expired = 1;
				update_option( 'thb_' . self::$thb_theme_slug . '_key_expired', 1 );
			} else {
				if ( version_compare( self::$thb_theme_version, $data->version, '<' ) ) {
					$transient->response[ self::$thb_theme_slug ] = array(
						'new_version' => $data->version,
						'package'     => $data->download_url,
						'url'         => 'https://wpthemestudios.com',
					);

					update_option( 'thb_' . self::$thb_theme_slug . '_remote_ver', $data->version );
				}
			}
		}
		return $transient;
	}
	public function thb_upgradeFilter( $reply, $package, $updater ) {
		global $wp_filesystem;
		$cond = ( ! self::$thb_product_key || ( self::$thb_product_key_expired == 1 ) );
		if ( isset( $updater->skin->theme_info ) && $updater->skin->theme_info['Name'] == self::$thb_theme_name ) {
			if ( $cond ) {
				return new WP_Error( 'no_credentials', sprintf( __( 'To receive automatic updates, registration is required. Please visit <a href="%1$s" target="_blank">Product Registration</a> to activate your theme.', 'twofold' ), esc_url( admin_url( 'admin.php?page=thb-product-registration' ) ) ) );
			}
		}

		// VisualComposer
		if ( ( isset( $updater->skin->plugin ) ) && ( $updater->skin->plugin == 'js_composer/js_composer.php' ) ) {
			if ( $cond ) {
				return new WP_Error( 'no_credentials', sprintf( __( 'To receive automatic updates, registration is required. Please visit <a href="%1$s" target="_blank">Product Registration</a> to activate your theme.', 'twofold' ), esc_url( admin_url( 'admin.php?page=thb-product-registration' ) ) ) );
			}
		}
		return $reply;
	}
	public function thb_plugins_install( $item ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$installed_plugins = get_plugins();

		$item['sanitized_plugin'] = $item['name'];

		// WordPress Repository
		if ( ! $item['version'] ) {
			$item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $item['slug'] );
		}

		// Install Link
		if ( ! isset( $installed_plugins[ $item['file_path'] ] ) ) {
			$actions = array(
				'install' => sprintf(
					'<a href="%1$s" class="button" title="Install %2$s">Install Now</a>',
					esc_url(
						wp_nonce_url(
							add_query_arg(
								array(
									'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
									'plugin'        => urlencode( $item['slug'] ),
									'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
									'tgmpa-install' => 'install-plugin',
									'return_url'    => network_admin_url( 'admin.php?page=thb-plugins' ),
								),
								TGM_Plugin_Activation::$instance->get_tgmpa_url()
							),
							'tgmpa-install',
							'tgmpa-nonce'
						)
					),
					$item['sanitized_plugin']
				),
			);
		}
		// Activate Link
		elseif ( is_plugin_inactive( $item['file_path'] ) ) {
			$actions = array(
				'activate' => sprintf(
					'<a href="%1$s" class="button button-primary" title="Activate %2$s">Activate</a>',
					esc_url(
						add_query_arg(
							array(
								'plugin'             => urlencode( $item['slug'] ),
								'plugin_name'        => urlencode( $item['sanitized_plugin'] ),
								'thb-activate'       => 'activate-plugin',
								'thb-activate-nonce' => wp_create_nonce( 'thb-activate' ),
								'return_url'         => network_admin_url( 'admin.php?page=thb-plugins' ),
							),
							admin_url( 'admin.php?page=thb-plugins' )
						)
					),
					$item['sanitized_plugin']
				),
			);
		}
		// Update Link

		elseif ( version_compare( $installed_plugins[ $item['file_path'] ]['Version'], $item['version'], '<' ) ) {
			$actions = array(
				'update' => sprintf(
					'<a href="%1$s" class="button button-update" title="Install %2$s"><span class="dashicons dashicons-update"></span> Update</a>',
					wp_nonce_url(
						add_query_arg(
							array(
								'page'         => urlencode( TGM_Plugin_Activation::$instance->menu ),
								'plugin'       => urlencode( $item['slug'] ),
								'tgmpa-update' => 'update-plugin',
								'version'      => urlencode( $item['version'] ),
								'return_url'   => network_admin_url( 'admin.php?page=thb-plugins' ),
							),
							TGM_Plugin_Activation::$instance->get_tgmpa_url()
						),
						'tgmpa-update',
						'tgmpa-nonce'
					),
					$item['sanitized_plugin']
				),
			);
		} elseif ( self::$_instance->thb_ispluginactive( $item['file_path'] ) ) {
			$actions = array(
				'deactivate' => sprintf(
					'<a href="%1$s" class="button" title="Deactivate %2$s">Deactivate</a>',
					esc_url(
						add_query_arg(
							array(
								'plugin'               => urlencode( $item['slug'] ),
								'plugin_name'          => urlencode( $item['sanitized_plugin'] ),
								// 'plugin_source'          => urlencode( $item['source'] ),
								'thb-deactivate'       => 'deactivate-plugin',
								'thb-deactivate-nonce' => wp_create_nonce( 'thb-deactivate' ),
							),
							admin_url( 'admin.php?page=thb-plugins' )
						)
					),
					$item['sanitized_plugin']
				),
			);
		}

		return $actions;
	}
	public function thb_theme_admin_init() {
		$get_name = !empty($_GET['plugin_name']) ? sanitize_text_field( $_GET['plugin_name'] ) : '';

		if ( isset( $_GET['thb-deactivate'] ) && $_GET['thb-deactivate'] == 'deactivate-plugin' ) {

			check_admin_referer( 'thb-deactivate', 'thb-deactivate-nonce' );

			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$plugins = get_plugins();

			foreach ( $plugins as $plugin_name => $plugin ) {
				if ( $plugin['Name'] == $get_name ) {
						deactivate_plugins( $plugin_name );
				}
			}
		}

		if ( isset( $_GET['thb-activate'] ) && $_GET['thb-activate'] == 'activate-plugin' ) {

			check_admin_referer( 'thb-activate', 'thb-activate-nonce' );

			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$plugins = get_plugins();

			foreach ( $plugins as $plugin_name => $plugin ) {
				if ( $plugin['Name'] == $get_name ) {
					activate_plugin( $plugin_name );
				}
			}
		}

	}
	public function thb_activation_redirect() {
		if ( ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
			$twofold_installed = 'twofold_installed';

			if ( false == get_option( $twofold_installed, false ) ) {
				update_option( $twofold_installed, true );
				wp_redirect( admin_url( 'admin.php?page=thb-product-registration' ) );
				die();
			}

			delete_option( $twofold_installed );
		}
	}
	public function adminPageEnqueue() {
		wp_enqueue_script( 'thb-admin-meta', self::$thb_theme_directory_uri . 'assets/js/admin-meta.min.js', array( 'jquery' ), esc_attr( self::$thb_theme_version ) );
		wp_enqueue_style( 'thb-admin-css', self::$thb_theme_directory_uri . 'assets/css/admin.css', null, esc_attr( self::$thb_theme_version ) );

		if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
			wp_enqueue_style( 'vc_extra_css', self::$thb_theme_directory_uri . 'assets/css/vc_extra.css' );
		}
	}
	public function adminSetupMenu() {

		// Product Registration
		add_menu_page( self::$thb_theme_name, self::$thb_theme_name, 'edit_theme_options', 'thb-product-registration', array( & $this, 'thb_Product_Registration' ), self::$thb_theme_directory_uri . 'assets/img/admin/fuelthemes-icon.svg', 3 );

		// Product Registration
		add_submenu_page( 'thb-product-registration', 'Registration', 'Registration', 'edit_theme_options', 'thb-product-registration', array( & $this, 'thb_Product_Registration' ) );

		// Main Menu Item
		add_submenu_page( 'thb-product-registration', 'Plugins', 'Plugins', 'edit_theme_options', 'thb-plugins', array( & $this, 'thb_Plugins' ) );

		// Demo Import
		add_submenu_page( 'thb-product-registration', 'Demo Import', 'Demo Import', 'edit_theme_options', 'thb-demo-import', array( & $this, 'thb_Demo_Import' ) );

		// Theme Options
		add_submenu_page( 'thb-product-registration', 'Theme Options', 'Theme Options', 'edit_theme_options', 'thb-theme-options', '__return_false' );

	}
	public function thb_Plugins() {
		get_template_part( 'inc/admin/welcome/pages/plugins' );
	}
	public function thb_Product_Registration() {
		get_template_part( 'inc/admin/welcome/pages/registration' );
	}
	public function thb_Demo_Import() {
		get_template_part( 'inc/admin/welcome/pages/demo-import' );
	}
	public function thb_ispluginactive( $value ) {
		$func = 'is_plugin' . '_active';
		return $func( $value );
	}
	/**
	 *  Inintialize API
	 */
	public function thb_dashboard_url( $type = null ) {
		$url = 'https://my.wpthemestudios.com';
		switch ( $type ) {
			case 'verify':
				$url .= '/api/verify';
				break;
			case 'verify-by-purchase':
				$url .= '/api/verify-by-purchase';
				break;
			case 'version':
				$url .= '/api/version';
				break;
			case 'plugin/version':
				$url .= '/api/plugin/version';
				break;
			case 'demo':
				$url .= '/api/demo';
				break;
		}
		return $url;
	}
}
// Main instance shortcut
function thb_Theme_Admin() {
	global $thb_Theme_Admin;
	return $thb_Theme_Admin;
}
Thb_Theme_Admin::instance();
