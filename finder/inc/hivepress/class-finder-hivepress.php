<?php
/**
 * Finder HivePress
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use HivePress\Helpers as hp;

if ( ! class_exists( 'Finder_Hivepress' ) ) :

	/**
	 * Finder HivePress Integration
	 */
	class Finder_Hivepress {

		/**
		 * Instantiate object.
		 */
		public function __construct() {
			$this->init_hooks();
		}

		/**
		 * Initialize Hooks
		 */
		private function init_hooks() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_filter( 'hivepress/v1/styles', array( $this, 'set_styles' ) );
			add_filter( 'hivepress/v1/templates/listings_view_page/blocks', array( $this, 'build_listings_view_page' ) );
			add_filter( 'hivepress/v1/templates/listing_categories_view_page/blocks', array( $this, 'build_listings_categories_view_page' ) );
			add_filter( 'hivepress/v1/templates/listing_category_view_block', array( $this, 'build_listing_category_content' ) );
			add_filter( 'hivepress/v1/templates/vendor_view_page/blocks', array( $this, 'build_vendor_view_page' ) );
			add_filter( 'hivepress/v1/templates/site_footer_block/blocks', array( $this, 'remove_default_modal_form' ) );
			add_filter( 'hivepress/v1/templates/vendors_view_page/blocks', array( $this, 'build_vendors_view_page' ) );
			add_filter( 'hivepress/v1/templates/listing_view_page/blocks', array( $this, 'build_listing_view_page' ) );
			add_filter( 'hivepress/v1/templates/listing_submit_category_page/blocks', array( $this, 'build_listing_submit_category_page_content' ) );
			add_filter( 'hivepress/v1/templates/listings_edit_page/blocks', array( $this, 'build_my_account_listing_edit_page' ) );
			add_filter( 'hivepress/v1/templates/listings_favorite_page/blocks', array( $this, 'build_my_account_listings_favourite_page' ) );
			add_filter( 'hivepress/v1/templates/messages_thread_page/blocks', array( $this, 'build_my_account_messages_thread_page' ) );
			add_filter( 'hivepress/v1/templates/user_edit_settings_page/blocks', array( $this, 'build_my_account_settings_page' ) );
			add_filter( 'hivepress/v1/templates/messages_view_page/blocks', array( $this, 'build_my_account_messages_page' ) );
			add_filter( 'hivepress/v1/templates/listing_edit_page/blocks', array( $this, 'build_my_account_listing_edit_form_page' ) );
			add_filter( 'hivepress/v1/templates/listing_submit_details_page/blocks', array( $this, 'build_my_account_listing_submit_details_page' ) );
			add_filter( 'hivepress/v1/templates/listing_submit_complete_page/blocks', array( $this, 'build_my_account_listing_submit_complete_page' ) );
			add_filter( 'hivepress/v1/templates/user_listing_packages_view_page/blocks', array( $this, 'build_my_account_user_listing_packages' ) );
			add_filter( 'hivepress/v1/icons', array( $this, 'add_finder_icon_attribute' ) );
			add_filter( 'hivepress/v1/templates/user_login_page/blocks', array( $this, 'build_my_account_login_page' ) );
			add_filter( 'finder_is_dark_background', array( $this, 'enable_dark_background' ) );
			add_filter( 'body_class', array( $this, 'body_classes' ) );
			remove_filter( 'wp_nav_menu_items', array( hivepress()->template, 'add_menu_items' ), 10, 2 );
		}

		/**
		 * Add body classes.
		 *
		 * @param array $body_classes array of body classes.
		 */
		public function body_classes( $body_classes ) {

			$account_style = finder_hivepress_get_user_account_style();
			$vendor_style  = finder_hivepress_get_vendor_single_style();

			$hp_route = hivepress()->router->get_current_route_name();

			if ( ! empty( $hp_route ) ) {
				if ( in_array( $hp_route, array( 'user_login_page', 'user_edit_settings_page', 'listings_edit_page', 'messages_view_page', 'messages_thread_page', 'listings_favorite_page', 'user_listing_packages_view_page' ), true ) ) {
					if ( 'city-guide' === $account_style ) {
						$body_classes[] = 'bg-secondary';
					}
				}
				if ( in_array( $hp_route, array( 'vendor_view_page' ), true ) ) {
					if ( 'city-guide' === $vendor_style ) {
						$body_classes[] = 'bg-secondary';
					}
				}
			}

			return $body_classes;
		}

		/**
		 * Add body classes.
		 *
		 * @param array $is_enabled array of body classes.
		 */
		public function enable_dark_background( $is_enabled ) {
			$listings_style       = finder_hivepress_get_listings_style();
			$listing_single_style = finder_hivepress_get_listing_single_style();
			$account_style        = finder_hivepress_get_user_account_style();
			$vendor_style         = finder_hivepress_get_vendor_single_style();

			$hp_route = hivepress()->router->get_current_route_name();

			if ( ! empty( $hp_route ) ) {
				if ( in_array( $hp_route, array( 'listing_view_page', 'listing_edit_page', 'listing_submit_details_page' ), true ) ) {
					if ( 'car-finder' === $listing_single_style ) {
						$is_enabled = true;
					}
				}
				if ( in_array( $hp_route, array( 'listings_view_page', 'listing_submit_category_page' ), true ) ) {
					if ( 'car-finder' === $listings_style ) {
						$is_enabled = true;
					}
				}

				if ( in_array( $hp_route, array( 'user_login_page', 'user_edit_settings_page', 'listings_edit_page', 'messages_view_page', 'messages_thread_page', 'listings_favorite_page', 'user_listing_packages_view_page' ), true ) ) {
					if ( 'car-finder' === $account_style ) {
						$is_enabled = true;
					}
				}

				if ( in_array( $hp_route, array( 'vendor_view_page', 'vendors_view_page' ), true ) ) {
					if ( 'car-finder' === $vendor_style ) {
						$is_enabled = true;
					}
				}
			}

			return $is_enabled;
		}

		/**
		 * Sets up theme defaults and registers support for Hivepress.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function setup() {

			// Declare Hivepress support.
			add_theme_support( 'hivepress' );
		}

		/**
		 * Register widget area.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
		 */
		public function widgets_init() {

			$sidebar_hivepress_listing_args = apply_filters(
				'finder_hivepress_listing_sidebar_args',
				array(
					'name'          => esc_html__( 'Listing Sidebar', 'finder' ),
					'id'            => 'sidebar-hivepress-listing',
					'description'   => '',
					'before_title'  => '<h3 class="h6">',
					'after_title'   => '</h3>',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
				)
			);

			register_sidebar( $sidebar_hivepress_listing_args );
		}

		/**
		 * Remove Hivepress default styles.
		 *
		 * @param array $styles hivepress stylesheets.
		 * @return array $styles hivepress stylesheets.
		 */
		public function set_styles( $styles ) {

			$unset_styles = array(
				'core_frontend',
			);

			if ( isset( $styles['grid'] ) ) {
				$styles['grid']['scope'] = array( 'backend', 'editor' );
			}

			foreach ( $unset_styles as $unset_style ) {
				if ( isset( $styles[ $unset_style ] ) ) {
					unset( $styles[ $unset_style ] );
				}
			}

			return $styles;
		}

		/**
		 * Changing list view template file
		 *
		 * @param array $args listing page args.
		 * @return array $args listing page args.
		 */
		public function build_listings_view_page( $args ) {

			$args = array(
				'listings_page_content' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'listings_view_page_content' => array(
							'type' => 'part',
							'path' => 'listing/archive-listing',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Changing list category view template file
		 *
		 * @param array $args listing category page args.
		 * @return array $args listing category page args.
		 */
		public function build_listings_categories_view_page( $args ) {

			$args = array(
				'listings_categories_page_content' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'listings_categories_view_page_content' => array(
							'type' => 'part',
							'path' => 'listing-category/listing-category',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Changing list category content template file
		 *
		 * @param array $args listing category args.
		 * @return array $args listing category args.
		 */
		public function build_listing_category_content( $args ) {

			$args['blocks'] = array(
				'listing_category_container' => array(
					'type' => 'part',
					'path' => 'listing-category/listing-category-content',
				),
			);

			return $args;
		}

		/**
		 * Changing my_account_listing_edit_page template file
		 *
		 * @param array $args my_account_listing_edit_page args.
		 * @return array $args my_account_listing_edit_page args.
		 */
		public function build_my_account_listing_edit_page( $args ) {

			$args = array(
				'listings_edit_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'listings_edit_page_content' => array(
							'type' => 'part',
							'path' => 'user/my-account/listing-edit',
						),
					),
				),
			);
			return $args;
		}

		/**
		 * Changing user account template file
		 *
		 * @param array $args my_account_listings_favourite_page args.
		 * @return array $args my_account_listings_favourite_page args.
		 */
		public function build_my_account_listings_favourite_page( $args ) {

			$args = array(
				'listings_favourite_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'listings_favourite_page_content' => array(
							'type' => 'part',
							'path' => 'user/my-account/listing-favourite',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Changing user account template file
		 *
		 * @param array $args my_account_messages_thread_page args.
		 * @return array $args my_account_messages_thread_page args.
		 */
		public function build_my_account_messages_thread_page( $args ) {

			$args = array(
				'listings_messages_thread_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'listings_messages_thread_page_content' => array(
							'type' => 'part',
							'path' => 'user/my-account/messages-thread',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Changing user account template file
		 *
		 * @param array $args my_account_messages_page args.
		 * @return array $args my_account_messages_page args.
		 */
		public function build_my_account_messages_page( $args ) {

			$args = array(
				'listings_messages_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'listings_messages_page_content' => array(
							'type' => 'part',
							'path' => 'user/my-account/messages',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Changing user account template file
		 *
		 * @param array $args my_account_listing_form_page args.
		 * @return array $args my_account_listing_form_page args.
		 */
		public function build_my_account_listing_edit_form_page( $args ) {

			$args = array(
				'listing_edit_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'listing_edit_page_content' => array(
							'type' => 'part',
							'path' => 'user/my-account/listing-form',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Changing user account template file
		 *
		 * @param array $args my_account_settings_page args.
		 * @return array $args my_account_settings_page args.
		 */
		public function build_my_account_settings_page( $args ) {

			$args = array(
				'listings_settings_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'listings_settings_page_content' => array(
							'type' => 'part',
							'path' => 'user/my-account/settings',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Changing listing_submit_category_page_content file
		 *
		 * @param array $args listing_submit_category_page_content args.
		 * @return array $args listing_submit_category_page_content args.
		 */
		public function build_listing_submit_category_page_content( $args ) {

			$args = array(
				'listing_submit_category_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'listing_submit_category_view_page_content' => array(
							'type' => 'part',
							'path' => 'listing/submit/listing-submit-category',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Changing listing_submit_category_page_content file
		 *
		 * @param array $args listing_submit_category_page_content args.
		 * @return array $args listing_submit_category_page_content args.
		 */
		public function build_my_account_listing_submit_details_page( $args ) {

			$args = array(
				'listing_submit_details_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'listing_submit_details_page_content' => array(
							'type' => 'part',
							'path' => 'listing/submit/listing-submit-details-page',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Changing build_my_account_listing_submit_complete_page file
		 *
		 * @param array $args build_my_account_listing_submit_complete_page args.
		 * @return array $args build_my_account_listing_submit_complete_page args.
		 */
		public function build_my_account_listing_submit_complete_page( $args ) {

			$args = array(
				'listing_submit_complete_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'listing_submit_complete_page_content' => array(
							'type' => 'part',
							'path' => 'listing/submit/listing-submit-complete-page',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Changing build_my_account_login_page file
		 *
		 * @param array $args build_my_account_login_page args.
		 * @return array $args build_my_account_login_page args.
		 */
		public function build_my_account_login_page( $args ) {

			$args = array(
				'login_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'login_page_content' => array(
							'type' => 'part',
							'path' => 'user/login/user-login-page',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Changing vendor view template file
		 *
		 * @param array $args user account page args.
		 * @return array $args user account page args.
		 */
		public function build_vendor_view_page( $args ) {

			$args = array(
				'build_vendor_view_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'build_vendor_view_page_content' => array(
							'type' => 'part',
							'path' => 'vendor/vendor-single',
						),

					),

				),
			);

			return $args;
		}

		/**
		 * Changing listing view template file
		 *
		 * @param array $args user account page args.
		 * @return array $args user account page args.
		 */
		public function build_listing_view_page( $args ) {

			$args = array(
				'build_listing_view_page' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'build_listing_view_page_content' => array(
							'type' => 'part',
							'path' => 'listing/listing-single',
						),

					),

				),
			);

			return $args;
		}

		/**
		 * Changing user account template file
		 *
		 * @param array $args user account page args.
		 * @return array $args user account page args.
		 */
		public function remove_default_modal_form( $args ) {

			$args = array();

			return $args;
		}


		/**
		 * Changing user account template file
		 *
		 * @param array $args user account page args.
		 * @return array $args user account page args.
		 */
		public function build_vendors_view_page( $args ) {
			$args = array(
				'vendors_page_content' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'vendors_view_page_content' => array(
							'type' => 'part',
							'path' => 'vendor/archive-vendor',
						),
					),
				),
			);

			return $args;
		}

		/**
		 * Add finder icon in hivepress attributes
		 *
		 * @param array $icons icons.
		 * @return array $icons icons.
		 */
		public function add_finder_icon_attribute( $icons ) {

			$finder_icons = finder_get_icons();

			$icons = array_merge( $finder_icons, $icons );

			return $icons;
		}

		/**
		 * Changing user account listing packages
		 *
		 * @param array $args user account page args.
		 * @return array $args user account page args.
		 */
		public function build_my_account_user_listing_packages( $args ) {
			$args = array(
				'user_listing_packages_content' => array(
					'type'   => 'page',
					'_order' => 10,
					'blocks' => array(
						'user_listing_view_packages_content' => array(
							'type' => 'part',
							'path' => 'user/my-account/listing-packages',
						),
					),
				),
			);

			return $args;
		}
	}

endif;

return new Finder_Hivepress();
