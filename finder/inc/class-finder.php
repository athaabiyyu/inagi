<?php
/**
 * Finder Class
 *
 * @package  Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Finder' ) ) :

	/**
	 * The main Finder class
	 */
	class Finder {

		/**
		 * Setup class.
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'child_scripts' ), 30 ); // After WooCommerce.
			add_action( 'enqueue_block_assets', array( $this, 'block_assets' ) );
			add_action( 'wp_head', array( $this, 'pingback_header' ) );
			add_filter( 'body_class', array( $this, 'body_classes' ) );
			add_filter( 'wp_page_menu_args', array( $this, 'page_menu_args' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ), 10 );
			add_filter( 'finder_is_dark_background', array( $this, 'enable_dark_background' ) );
			add_filter( 'finder_disable_page_header', array( $this, 'disable_page_header' ) );
			// add_filter( 'finder_blog_sidebar_args', array( $this, 'override_sidebar_args' ) );
			// add_filter( 'finder_blog_single_sidebar_args', array( $this, 'override_single_sidebar_args' ) );
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 */
		public function setup() {
			/*
			 * Load Localisation files.
			 *
			 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
			 */

			// Loads wp-content/languages/themes/finder-it_IT.mo.
			load_theme_textdomain( 'finder', trailingslashit( WP_LANG_DIR ) . 'themes' );

			// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
			load_theme_textdomain( 'finder', get_stylesheet_directory() . '/languages' );

			// Loads wp-content/themes/finder/languages/it_IT.mo.
			load_theme_textdomain( 'finder', get_template_directory() . '/languages' );

			/**
			 * Add default posts and comments RSS feed links to head.
			 */
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );

			/**
			 * Enable support for site logo.
			 */
			add_theme_support(
				'custom-logo',
				apply_filters(
					'finder_custom_logo_args',
					array(
						'height'      => 110,
						'width'       => 470,
						'flex-width'  => true,
						'flex-height' => true,
					)
				)
			);

			/**
			 * Register menu locations.
			 */
			register_nav_menus(
				apply_filters(
					'finder_register_nav_menus',
					array(
						'primary'        => esc_html__( 'Primary Menu', 'finder' ),
						'offcanvas_menu' => esc_html__( 'Offcanvas Menu', 'finder' ),
						'social_media'   => esc_html__( 'Social Media', 'finder' ),
						'footer'         => esc_html__( 'Footer Menu', 'finder' ),
					)
				)
			);

			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			add_theme_support(
				'html5',
				apply_filters(
					'finder_html5_args',
					array(
						'search-form',
						'comment-form',
						'comment-list',
						'gallery',
						'caption',
						'widgets',
						'style',
						'script',
					)
				)
			);

			/**
			 *  Add support for the Site Logo plugin and the site logo functionality in JetPack
			 *  https://github.com/automattic/site-logo
			 *  http://jetpack.me/
			 */
			add_theme_support(
				'site-logo',
				apply_filters(
					'finder_site_logo_args',
					array(
						'size' => 'full',
					)
				)
			);

			/**
			 * Declare support for title theme feature.
			 */
			add_theme_support( 'title-tag' );

			/**
			 * Declare support for selective refreshing of widgets.
			 */
			add_theme_support( 'customize-selective-refresh-widgets' );

			/**
			 * Add support for Block Styles.
			 */
			add_theme_support( 'wp-block-styles' );

			/**
			 * Add support for full and wide align images.
			 */
			add_theme_support( 'align-wide' );

			/**
			 * Add support for editor styles.
			 */
			add_theme_support( 'editor-styles' );
			add_editor_style( array( 'assets/css/gutenberg-editor.css' ) );

			/**
			 * Add support for editor font sizes.
			 */
			add_theme_support(
				'editor-font-sizes',
				array(
					array(
						'name' => __( 'Small', 'finder' ),
						'size' => 14,
						'slug' => 'small',
					),
					array(
						'name' => __( 'Normal', 'finder' ),
						'size' => 16,
						'slug' => 'normal',
					),
					array(
						'name' => __( 'Medium', 'finder' ),
						'size' => 23,
						'slug' => 'medium',
					),
					array(
						'name' => __( 'Large', 'finder' ),
						'size' => 26,
						'slug' => 'large',
					),
					array(
						'name' => __( 'Huge', 'finder' ),
						'size' => 37,
						'slug' => 'huge',
					),
				)
			);

			/**
			 * Add support for responsive embedded content.
			 */
			add_theme_support( 'responsive-embeds' );

			/**
			 * Add job_listing post type support for excerpt.
			 */
			add_post_type_support( 'job_listing', 'excerpt' );

		}

		/**
		 * Register widget area.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
		 */
		public function widgets_init() {

			register_sidebar(
				apply_filters(
					'finder_blog_sidebar_args',
					array(
						'name'          => esc_html__( 'Blog Sidebar', 'finder' ),
						'id'            => 'sidebar-blog',
						'description'   => '',
						'before_widget' => '<div id="%1$s" class="card card-flush pb-2 pb-lg-0 mb-4 widget %2$s"><div class="card-body">',
						'after_widget'  => '</div></div>',
						'before_title'  => '<h3 class="h5 widget-title">',
						'after_title'   => '</h3>',
					)
				)
			);

			register_sidebar(
				apply_filters(
					'finder_blog_single_sidebar_args',
					array(
						'name'          => esc_html__( 'Blog Single Sidebar', 'finder' ),
						'id'            => 'blog-single-sidebar',
						'description'   => '',
						'before_widget' => '<div id="%1$s" class="card-transparent card card-flush pb-3 pb-lg-0 mb-4 widget %2$s"><div class="card-body">',
						'after_widget'  => '</div></div>',
						'before_title'  => '<h3 class="h5 widget-title">',
						'after_title'   => '</h3>',
					)
				)
			);

			register_sidebar(
				apply_filters(
					'finder_sidebar_args',
					array(
						'name'          => esc_html__( 'Offcanvas Sidebar', 'finder' ),
						'id'            => 'offcanvas-sidebar',
						'description'   => '',
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h2 class="h5 mb-0 widget-title">',
						'after_title'   => '</h2>',
					)
				)
			);

			/**
			 * Footer Widget.
			 */
			$rows    = intval( apply_filters( 'finder_footer_widget_rows', 1 ) );
			$regions = intval( apply_filters( 'finder_footer_widget_columns', 5 ) );

			for ( $row = 1; $row <= $rows; $row++ ) {
				for ( $region = 1; $region <= $regions; $region++ ) {
					$footer_n = $region + $regions * ( $row - 1 ); // Defines footer sidebar ID.
					$footer   = sprintf( 'footer_%d', $footer_n );

					if ( 1 === $rows ) {
						/* translators: 1: column number */
						$footer_region_name = sprintf( esc_html__( 'Footer Column %1$d', 'finder' ), $region );

						/* translators: 1: column number */
						$footer_region_description = sprintf( esc_html__( 'Widgets added here will appear in column %1$d of the footer.', 'finder' ), $region );
					} else {
						/* translators: 1: row number, 2: column number */
						$footer_region_name = sprintf( esc_html__( 'Footer Row %1$d - Column %2$d', 'finder' ), $row, $region );

						/* translators: 1: column number, 2: row number */
						$footer_region_description = sprintf( esc_html__( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'finder' ), $region, $row );
					}

					$sidebar_args[ $footer ] = array(
						'name'        => $footer_region_name,
						'id'          => sprintf( 'footer-%d', $footer_n ),
						'description' => $footer_region_description,
					);
				}
			}

			$sidebar_args = apply_filters( 'finder_sidebar_args', $sidebar_args );

			$before_title = '<h4 class="h5 widget-title">';
			$after_title  = '</h4>';

			$footer_version = finder_get_footer_version();

			switch ( $footer_version ) {
				case 'v3':
				case 'v5':
					$before_title = '<h3 class="fs-base text-light widget-title">';
					$after_title  = '</h3>';
					break;
				case 'v4':
					$before_title = '<h3 class="h6 mb-2 pb-1 fs-base text-light widget-title">';
					$after_title  = '</h3>';
					break;
			}

			foreach ( $sidebar_args as $sidebar => $args ) {
				$widget_tags = array(
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => $before_title,
					'after_title'   => $after_title,
				);

				/**
				 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
				 *
				 * 'finder_header_widget_tags'
				 * 'finder_sidebar_widget_tags'
				 *
				 * 'finder_footer_1_widget_tags'
				 * 'finder_footer_2_widget_tags'
				 * 'finder_footer_3_widget_tags'
				 * 'finder_footer_4_widget_tags'
				 */
				$filter_hook = sprintf( 'finder_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );

				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			}

		}

		/**
		 * Enqueue admin styles.
		 */
		public function admin_styles() {
			global $finder_version;

			/**
			 * Finder Icon Styles
			 */
			wp_enqueue_style( 'finder-icons', FINDER_THEME_URI . 'assets/fonts/finder-icons.css', '', $finder_version );
		}

		/**
		 * Enqueue scripts and styles.
		 */
		public function scripts() {
			global $finder_version;

			/**
			 * Styles
			 */
			$css_vendor_assets = apply_filters(
				'finder_css_vendor_assets',
				array(
					'simplebar'        => 'assets/vendor/simplebar/dist/simplebar.min.css',
					'leaflet'          => 'assets/vendor/leaflet/dist/leaflet.css',
					'tiny-slider'      => 'assets/vendor/tiny-slider/dist/tiny-slider.css',
					'nouislider'       => 'assets/vendor/nouislider/dist/nouislider.min.css',
					'jarallax'         => 'assets/vendor/jarallax/dist/jarallax.css',
					'flatpickr'        => 'assets/vendor/flatpickr/dist/flatpickr.min.css',
					'lightgallery'     => 'assets/vendor/lightgallery.js/dist/css/lightgallery.min.css',
					'filepond'         => 'assets/vendor/filepond/dist/filepond.min.css',
					'filepond-preview' => 'assets/vendor/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css',
				)
			);

			foreach ( $css_vendor_assets as $handle => $css_asset ) {
				wp_enqueue_style( $handle, FINDER_THEME_URI . $css_asset, '', $finder_version );
			}

			/**
			 * Theme Styles
			 */
			wp_enqueue_style( 'finder-style', FINDER_THEME_URI . 'style.css', '', $finder_version );
			wp_style_add_data( 'finder-style', 'rtl', 'replace' );

			/**
			 * Scripts
			 */
			$js_vendor_assets = apply_filters(
				'finder_js_vendor_assets',
				array(
					'bootstrap-bundle'   => 'assets/vendor/bootstrap/dist/js/bootstrap.bundle.js',
					'simplebar'          => 'assets/vendor/simplebar/dist/simplebar.min.js',
					'smooth-scroll'      => 'assets/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js',
					'leaflet'            => 'assets/vendor/leaflet/dist/leaflet.js',
					'tiny-slider'        => 'assets/vendor/tiny-slider/dist/min/tiny-slider.js',
					'nouislider'         => 'assets/vendor/nouislider/dist/nouislider.min.js',
					'jarallax'           => 'assets/vendor/jarallax/dist/jarallax.min.js',
					'jarallax-element'   => 'assets/vendor/jarallax/dist/jarallax-element.min.js',
					'cleave'             => 'assets/vendor/cleave.js/dist/cleave.min.js',
					'filepond'           => 'assets/vendor/filepond/dist/filepond.min.js',
					'filepond-size'      => 'assets/vendor/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js',
					'filepond-type'      => 'assets/vendor/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js',
					'filepond-crop'      => 'assets/vendor/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.min.js',
					'filepond-preview'   => 'assets/vendor/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js',
					'filepond-resize'    => 'assets/vendor/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.min.js',
					'filepond-transform' => 'assets/vendor/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.min.js',
					'range-js'           => 'assets/vendor/flatpickr/dist/plugins/rangePlugin.js',
					'flatpickr'          => 'assets/vendor/flatpickr/dist/flatpickr.min.js',
					'lightgallery'       => 'assets/vendor/lightgallery.js/dist/js/lightgallery.min.js',
					'lg-fullscreen'      => 'assets/vendor/lg-fullscreen.js/dist/lg-fullscreen.min.js',
					'lg-zoom'            => 'assets/vendor/lg-zoom.js/dist/lg-zoom.min.js',
					'lg-video'           => 'assets/vendor/lg-video.js/dist/lg-video.min.js',
					'lg-thumbnail'       => 'assets/vendor/lg-thumbnail.js/dist/lg-thumbnail.min.js',
					'parallax-js'        => 'assets/vendor/parallax-js/dist/parallax.min.js',
					'masonry'            => 'assets/vendor/masonry/masonry.pkgd.min.js',
					'lottie-player'      => 'assets/vendor/@lottiefiles/lottie-player/dist/lottie-player.js',
				)
			);

			foreach ( $js_vendor_assets as $handle => $js_asset ) {
				wp_enqueue_script( $handle, FINDER_THEME_URI . $js_asset, array( 'jquery' ), $finder_version, true );
			}

			// Theme JS.
			wp_enqueue_script( 'finder-js', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery' ), $finder_version, true );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			$finder_options = apply_filters(
				'finder_localize_script_data',
				array(
					'theme_url' => FINDER_THEME_URI,
				)
			);

			wp_localize_script( 'finder-js', 'finder_options', $finder_options );

			if ( apply_filters( 'finder_use_predefined_colors', true ) && filter_var( get_theme_mod( 'finder_enable_custom_color', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
				wp_enqueue_style( 'finder-color', get_template_directory_uri() . '/assets/css/colors/color.css', '', $finder_version );
			}
		}

		/**
		 * Enqueue block assets.
		 */
		public function block_assets() {}

		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
		 * primary css and the separate WooCommerce css.
		 */
		public function child_scripts() {
			if ( is_child_theme() ) {
				$child_theme = wp_get_theme( get_stylesheet() );
				wp_enqueue_style( 'finder-child-style', get_stylesheet_uri(), array(), $child_theme->get( 'Version' ) );
			}
		}

		/**
		 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
		 *
		 * @param array $args Configuration arguments.
		 * @return array
		 */
		public function page_menu_args( $args ) {
			$args['show_home'] = true;
			return $args;
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		public function body_classes( $classes ) {
			$page_variant = get_theme_mod( 'finder_404_version' );
			// Current Astra verion.
			$classes[] = esc_attr( 'finder-' . FINDER_THEME_VERSION );

			if ( finder_is_dark_background() ) {
				$classes[] = 'bg-dark';
			}
			if ( is_404() && 'v2' === $page_variant ) {
				$classes[] = 'bg-dark';
			}

			if ( finder_is_acf_activated() && function_exists( 'finder_acf_get_page_additional_classes' ) && ! empty( finder_acf_get_page_additional_classes() ) ) {
				$classes[] = finder_acf_get_page_additional_classes();
			}

			return $classes;
		}

		/**
		 * Disable Page Header.
		 *
		 * @return bool
		 */
		public function disable_page_header() {

			$page_header = true;

			if ( is_page() ) {
				$page_header = finder_acf_get_page_header();
			}

			return $page_header;
		}

		/**
		 * Adds enable_dark_background classes to the array of body classes.
		 *
		 * @param boolean $is_enabled true.
		 * @return bool
		 */
		public function enable_dark_background( $is_enabled ) {
			$blog_archive_style = finder_get_blog_style();
			$blog_single_style  = finder_get_blog_single_style();

			if ( ( is_home() || is_tag() || is_category() || is_search() ) && ! is_archive() ) {
				if ( 'car-finder' === $blog_archive_style ) {
					$is_enabled = true;
				}
			}

			if ( is_singular( 'post' ) ) {
				if ( 'car-finder' === $blog_single_style ) {
					$is_enabled = true;
				}
			}

			return $is_enabled;
		}

		/**
		 * Add a pingback url auto-discovery header for singularly identifiable articles.
		 */
		public function pingback_header() {
			if ( is_singular() && pings_open() ) {
				printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
			}
		}
	}
endif;

return new Finder();
