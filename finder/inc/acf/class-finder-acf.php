<?php
/**
 * Finder ACF Class
 *
 * @package  finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Finder_ACF' ) ) {
	/**
	 * The Finder ACF Integration class
	 */
	class Finder_ACF {

		/**
		 * Setup class.
		 */
		public function __construct() {
			$this->includes();
		}

		/**
		 * Include settings.
		 */
		public function includes() {
			if ( function_exists( 'acf_add_local_field_group' ) ) {

				$settings = array( 'blog-post', 'tax', 'vendor', 'job-listing', 'listing', 'listing-attributes', 'page' );

				foreach ( $settings as $setting ) {

					require FINDER_THEME_DIR . 'inc/acf/settings/' . $setting . '.php';
				}
			}
		}
	}
}

return new Finder_ACF();
