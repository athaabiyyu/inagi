<?php
/**
 * Finder Admin Class
 *
 * @package  finder
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Finder_Admin' ) ) :
	/**
	 * The Finder admin class
	 */
	class Finder_Admin {

		/**
		 * Instantiate class object
		 */
		public function __construct() {
			add_action( 'admin_init', [ $this, 'run_once' ] );
			add_action( 'admin_init', [ $this, 'disable_redirects' ], 1 );
		}

		/**
		 * Disable Elementor redirect.
		 */
		public function disable_redirects() {
			if ( did_action( 'elementor/loaded' ) ) {
				remove_action( 'admin_init', [ \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ] );
			}
		}

		/**
		 * Run this function only once in the admin panel.
		 */
		public function run_once() {
			if ( get_option( 'finder_admin_run_once_completed', false ) ) {
				return;
			}

			do_action( 'finder_admin_run_once' );

			update_option( 'finder_admin_run_once_completed', true );
		}
	}

endif;

return new Finder_Admin();
