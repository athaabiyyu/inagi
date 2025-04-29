<?php
/**
 * Finder Theme Options
 *
 * @package     Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme Options
 */
if ( ! class_exists( 'Finder_Theme_Options' ) ) {
	/**
	 * Theme Options
	 */
	class Finder_Theme_Options {

		/**
		 * Class instance.
		 *
		 * @var $instance Class instance.
		 */
		private static $instance;

		/**
		 * Customizer defaults.
		 *
		 * @var Array
		 */
		private static $defaults;

		/**
		 * Post id.
		 *
		 * @var $instance Post id.
		 */
		public static $post_id = null;

		/**
		 * A static option variable.
		 *
		 * @var mixed $db_options
		 */
		private static $db_options;

		/**
		 * A static option variable.
		 *
		 * @var mixed $db_options
		 */
		private static $db_options_no_defaults;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {

			// Refresh options variables after customizer save.
			add_action( 'after_setup_theme', array( $this, 'refresh' ) );

		}

		/**
		 * Set default theme option values
		 *
		 * @since 1.0.0
		 * @return default values of the theme.
		 */
		public static function defaults() {

			if ( ! is_null( self::$defaults ) ) {
				return self::$defaults;
			}

			// Defaults list of options.
			self::$defaults = apply_filters(
				'finder_theme_defaults',
				array()
			);

			return self::$defaults;
		}

		/**
		 * Get theme options from static array()
		 *
		 * @return array    Return array of theme options.
		 */
		public static function get_options() {
			return self::$db_options;
		}

		/**
		 * Update theme static option array.
		 */
		public static function refresh() {
			self::$db_options = wp_parse_args(
				self::get_db_options(),
				self::defaults()
			);
		}

		/**
		 * Get theme options from static array() from database
		 *
		 * @return array    Return array of theme options from database.
		 */
		public static function get_db_options() {
			self::$db_options_no_defaults = get_option( FINDER_THEME_SETTINGS );
			return self::$db_options_no_defaults;
		}
	}
}
/**
 * Kicking this off by calling 'get_instance()' method
 */
Finder_Theme_Options::get_instance();
