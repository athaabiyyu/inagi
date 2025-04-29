<?php
/**
 * Finder Job Manager Class
 *
 * @package finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Finder_WPJM' ) ) :

	/**
	 * The Finder WP Job Manager Integration class
	 */
	class Finder_WPJM {

		/**
		 * Instantiate object.
		 */
		public function __construct() {
			$this->includes();
			$this->init_hooks();
		}

		/**
		 * Initialize Hooks
		 */
		private function init_hooks() {
			add_filter( 'job_manager_enqueue_frontend_style', '__return_false', 30 );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_filter( 'register_post_type_job_listing', array( $this, 'modify_register_post_type_job_listing' ) );
			add_filter( 'body_class', array( $this, 'finder_wpjm_body_classes' ) );
			add_filter( 'finder_disable_page_header', array( $this, 'finder_wpjm_job_dashboard' ) );
			add_filter( 'job_manager_single_job_content', 'get_the_content' );
		}

		/**
		 * Body Classes for Job Manager Related Pages
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		public function finder_wpjm_body_classes( $classes ) {
			$classes[] = 'wpjm-activated';

			if ( is_post_type_archive( 'job_listing' ) || is_page( finder_wpjm_get_page_id( 'jobs' ) ) || is_page( finder_wpjm_get_page_id( 'jobs-dashboard' ) ) || is_page( finder_wpjm_get_page_id( 'post-a-job' ) ) || finder_is_job_listing_taxonomy() || is_singular( 'job_listing' ) ) {
				$classes[] = 'finder-wpjm-pages';
			}

			if ( current_theme_supports( 'job-manager-archive' ) && ( is_post_type_archive( 'job_listing' ) || is_page( finder_wpjm_get_page_id( 'jobs' ) ) || finder_is_job_listing_taxonomy() ) ) {
				$classes[] = 'post-type-archive-job_listing';
			}

			return $classes;
		}

		/**
		 * Modify register_post_type_job_listing
		 *
		 * @param array $args job listing arguments.
		 * @return string  $args job listing arguments.
		 */
		public function modify_register_post_type_job_listing( $args ) {
			$args['show_in_rest']  = true;
			$args['template']      = array();
			$args['template_lock'] = false;
			$jobs_page_id          = finder_wpjm_get_page_id( 'jobs' );
			if ( current_theme_supports( 'job-manager-archive' ) && $jobs_page_id && get_post( $jobs_page_id ) ) {
				$permalinks          = WP_Job_Manager_Post_Types::get_permalink_structure();
				$args['has_archive'] = urldecode( get_page_uri( $jobs_page_id ) );
				$args['rewrite']     = $permalinks['job_rewrite_slug'] ? array(
					'slug'       => $permalinks['job_rewrite_slug'],
					'with_front' => false,
					'feeds'      => true,
				) : false;
			}

			return $args;
		}

		/**
		 * Sets up theme defaults job manager templates & job manager archive.
		 */
		public function setup() {
			// Declare WP Job Manager Templates support.
			add_theme_support( 'job-manager-templates' );

			// Declare WP Job Manager Archive support.
			add_theme_support( 'job-manager-archive' );
		}

		/**
		 * Include Finder Job Manager Dependent Classes.
		 */
		public function includes() {
			include_once FINDER_THEME_DIR . 'inc/wpjm/class-finder-wpjm-template-loader.php';
			include_once FINDER_THEME_DIR . 'inc/wpjm/class-finder-wpjm-query.php';
		}

		/**
		 * Register widget area.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
		 */
		public function widgets_init() {

			register_sidebar(
				apply_filters(
					'finder_job_listing_sidebar_args',
					array(
						'name'          => esc_html__( 'Job Archive Sidebar', 'finder' ),
						'id'            => 'job-listing-sidebar',
						'description'   => '',
						'before_widget' => '<div id="%1$s" class="widget %2$s">',
						'after_widget'  => '</div>',
						'before_title'  => '<h3 class="h5 widget-title">',
						'after_title'   => '</h3>',
					)
				)
			);

			register_sidebar(
				apply_filters(
					'finder_single_job_listing_sidebar_args',
					array(
						'name'          => esc_html__( 'Job Single Sidebar', 'finder' ),
						'id'            => 'job-single-sidebar',
						'description'   => '',
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h3 class="h5 widget-title">',
						'after_title'   => '</h3>',
					)
				)
			);
		}

		/**
		 * Get Current Page URL.
		 */
		public static function get_current_page_url() {
			if ( defined( 'JOBS_IS_ON_FRONT' ) ) {
				$link = home_url( '/' );
			} elseif ( is_post_type_archive( 'job_listing' ) || is_page( finder_wpjm_get_page_id( 'jobs' ) ) || is_singular( 'job_listing' ) ) {
				$link = get_permalink( finder_wpjm_get_page_id( 'jobs' ) );
			} else {
				$queried_object = get_queried_object();
				$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
			}

			// Order by.
			if ( isset( $_GET['orderby'] ) ) {
				$link = add_query_arg( 'orderby', filter_var( wp_unslash( $_GET['orderby'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ), $link );
			}

			// Company Name.
			if ( isset( $_GET['company_name'] ) ) {
				$link = add_query_arg( 'company_name', filter_var( wp_unslash( $_GET['company_name'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ), $link );
			}

			// Company Id.
			if ( isset( $_GET['company_id'] ) ) {
				$link = add_query_arg( 'company_id', filter_var( wp_unslash( $_GET['company_id'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ), $link );
			}

			/**
			 * Search Arg.
			 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
			 */
			if ( get_search_query() ) {
				$link = add_query_arg( 'search_keywords', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
			}

			// Post Type Arg.
			if ( isset( $_GET['post_type'] ) ) {
				$link = add_query_arg( 'post_type', filter_var( wp_unslash( $_GET['post_type'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ), $link );
			}

			// Location Arg.
			if ( isset( $_GET['search_location'] ) ) {
				$link = add_query_arg( 'search_location', filter_var( wp_unslash( $_GET['search_location'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ), $link );
			}

			// Date Filter Arg.
			if ( isset( $_GET['posted_before'] ) ) {
				$link = add_query_arg( 'posted_before', filter_var( wp_unslash( $_GET['posted_before'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ), $link );
			}

			$_chosen_taxonomies = Finder_WPJM_Query::get_layered_nav_chosen_taxonomies();

			// All current filters.
			if ( $_chosen_taxonomies ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
				foreach ( $_chosen_taxonomies as $name => $data ) {
					$filter_name = sanitize_title( $name );
					if ( ! empty( $data['terms'] ) ) {
						$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
					}
					if ( 'or' === $data['query_type'] ) {
						$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
					}
				}
			}

			return $link;
		}

		/**
		 * Get Current Page Query args.
		 */
		public static function get_current_page_query_args() {
			$args = array();

			// Order by.
			if ( isset( $_GET['orderby'] ) ) {
				$args['orderby'] = filter_var( wp_unslash( $_GET['orderby'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
			}

			// Company Name.
			if ( isset( $_GET['company_name'] ) ) {
				$args['company_name'] = filter_var( wp_unslash( $_GET['company_name'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
			}

			// Company ID.
			if ( isset( $_GET['company_id'] ) ) {
				$args['company_id'] = filter_var( wp_unslash( $_GET['company_id'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
			}

			/**
			 * Search Arg.
			 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
			 */
			if ( get_search_query() ) {
				$args['search_keywords'] = rawurlencode( wp_specialchars_decode( get_search_query() ) );
			}

			// Post Type Arg.
			if ( isset( $_GET['post_type'] ) ) {
				$args['post_type'] = filter_var( wp_unslash( $_GET['post_type'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
			}

			// Location Arg.
			if ( isset( $_GET['search_location'] ) ) {
				$args['search_location'] = filter_var( wp_unslash( $_GET['search_location'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
			}

			// Category Arg.
			if ( isset( $_GET['search_category'] ) ) {
				$args['search_category'] = filter_var( wp_unslash( $_GET['search_category'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
			}

			// Type Arg.
			if ( isset( $_GET['search_type'] ) ) {
				$args['search_type'] = filter_var( wp_unslash( $_GET['search_type'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
			}

			// Date Filter Arg.
			if ( isset( $_GET['posted_before'] ) ) {
				$args['posted_before'] = filter_var( wp_unslash( $_GET['posted_before'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
			}

			$_chosen_taxonomies = Finder_WPJM_Query::get_layered_nav_chosen_taxonomies();

			// All current filters.
			if ( $_chosen_taxonomies ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
				foreach ( $_chosen_taxonomies as $name => $data ) {
					$filter_name = sanitize_title( $name );
					if ( ! empty( $data['terms'] ) ) {
						$args[ 'filter_' . $filter_name ] = implode( ',', $data['terms'] );
					}
					if ( 'or' === $data['query_type'] ) {
						$args[ 'query_type_' . $filter_name ] = 'or';
					}
				}
			}

			return $args;
		}

		/**
		 * Job-dashboard filter page header disbled.
		 *
		 * @param array $is_enabled Page header.
		 */
		public function finder_wpjm_job_dashboard( $is_enabled ) {

			if ( is_page( finder_wpjm_get_page_id( 'jobs-dashboard' ) ) || is_page( finder_wpjm_get_page_id( 'post-a-job' ) ) ) {
				$is_enabled = true;
			}

			return $is_enabled;
		}
	}

endif;

new Finder_WPJM();
