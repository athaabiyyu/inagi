<?php
/**
 * Finder Job Manager Query Class
 *
 * @package Finder
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Finder_WPJM_Query' ) ) {

	/**
	 * The Finder WP Job Manager Query class
	 */
	class Finder_WPJM_Query {

		/**
		 * Reference to the main job query on the page.
		 *
		 * @var array
		 */
		private static $finder_wpjm_query;

		/**
		 * Stores chosen taxonomies.
		 *
		 * @var array
		 */
		private static $_chosen_taxonomies;

		/**
		 * Instantiate object.
		 */
		public function __construct() {
			if ( ! is_admin() ) {
				add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
			}
		}

		/**
		 * Are we currently on the front page?
		 *
		 * @param WP_Query $q Query instance.
		 * @return bool
		 */
		private function is_showing_page_on_front( $q ) {
			return $q->is_home() && 'page' === get_option( 'show_on_front' );
		}

		/**
		 * Is the front page a page we define
		 *
		 * @param int $page_id Page ID.
		 * @return bool
		 */
		private function page_on_front_is( $page_id ) {
			return absint( get_option( 'page_on_front' ) ) === absint( $page_id );
		}

		/**
		 * Setup Job Query
		 *
		 * @param object $q Query Object.
		 */
		public function pre_get_posts( $q ) {
			if ( ! $q->is_main_query() ) {
				return;
			}

			// When orderby is set, WordPress shows posts on the front-page. Get around that here.
			if ( $this->is_showing_page_on_front( $q ) && $this->page_on_front_is( finder_wpjm_get_page_id( 'jobs' ) ) ) {
				$_query = wp_parse_args( $q->query );
				if ( empty( $_query ) || ! array_diff( array_keys( $_query ), array( 'preview', 'page', 'paged', 'cpage', 'orderby' ) ) ) {
					$q->set( 'page_id', (int) get_option( 'page_on_front' ) );
					$q->is_page = true;
					$q->is_home = false;

					// WP supporting themes show post type archive.
					$q->set( 'post_type', 'job_listing' );
				}
			}

			// Special check for jobs with the PRODUCT POST TYPE ARCHIVE on front.
			if ( $q->is_page() && 'page' === get_option( 'show_on_front' ) && absint( $q->get( 'page_id' ) ) === finder_wpjm_get_page_id( 'jobs' ) ) {
				// This is a front-page jobs.
				$q->set( 'post_type', 'job_listing' );
				$q->set( 'page_id', '' );

				if ( isset( $q->query['paged'] ) ) {
					$q->set( 'paged', $q->query['paged'] );
				}

				// Define a variable so we know this is the front page jobs later on.
				if ( ! defined( 'JOBS_IS_ON_FRONT' ) ) {
					define( 'JOBS_IS_ON_FRONT', true );
				}

				// Get the actual WP page to avoid errors and let us use is_front_page().
				// This is hacky but works. Awaiting https://core.trac.wordpress.org/ticket/21096.
				global $wp_post_types;

				$jobs_page = get_post( finder_wpjm_get_page_id( 'jobs' ) );

				$wp_post_types['job_listing']->ID         = $jobs_page->ID;
				$wp_post_types['job_listing']->post_title = $jobs_page->post_title;
				$wp_post_types['job_listing']->post_name  = $jobs_page->post_name;
				$wp_post_types['job_listing']->post_type  = $jobs_page->post_type;
				$wp_post_types['job_listing']->ancestors  = get_ancestors( $jobs_page->ID, $jobs_page->post_type );

				// Fix conditional Functions like is_front_page.
				$q->is_singular          = false;
				$q->is_post_type_archive = true;
				$q->is_archive           = true;
				$q->is_page              = true;

				// Remove post type archive name from front page title tag.
				add_filter( 'post_type_archive_title', '__return_empty_string', 5 );
			} elseif ( ! $q->is_post_type_archive( 'job_listing' ) && ! $q->is_tax( get_object_taxonomies( 'job_listing' ) ) ) {
				// Only apply to job_listing categories, the job_listing post archive, the jobs page, and job_listing taxonomies.
				return;
			}

			if ( ! is_feed() ) {
				$ordering = $this->get_catalog_ordering_args();
				$q->set( 'orderby', $ordering['orderby'] );
				$q->set( 'order', $ordering['order'] );

				if ( isset( $ordering['meta_key'] ) ) {
					$q->set( 'meta_key', $ordering['meta_key'] );
				}
			}

			// Query vars that affect posts shown.
			$this->get_search_query( $q );
			$q->set( 'meta_query', $this->get_meta_query( $q->get( 'meta_query' ), true ) );
			$q->set( 'tax_query', $this->get_tax_query( $q->get( 'tax_query' ), true ) );
			$q->set( 'date_query', $this->get_date_query( $q->get( 'date_query' ), true ) );
			$q->set( 'finder_wpjm_query', 'job_listing_query' );
			$q->set( 'posts_per_page', $this->get_posts_per_page( $q->get( 'posts_per_page' ), true ) );

			// Hide Expired jobs.
			if ( 0 === intval( get_option( 'job_manager_hide_expired', get_option( 'job_manager_hide_expired_content', 1 ) ) ) ) {
				$post_status = array( 'publish', 'expired' );
			} else {
				$post_status = array( 'publish' );
			}

			$q->set( 'post_status', $post_status );

			// Store reference to this query.
			self::$finder_wpjm_query = $q;
		}

		/**
		 * Appends meta queries to an array.
		 *
		 * @param object $q Meta query.
		 */
		public function get_search_query( $q ) {
			if ( ! empty( $_GET['search_keywords'] ) ) {
				global $job_manager_keyword;
				$job_manager_keyword = sanitize_text_field( wp_unslash( $_GET['search_keywords'] ) );

				if ( ! empty( $job_manager_keyword ) && strlen( $job_manager_keyword ) >= apply_filters( 'job_manager_get_listings_keyword_length_threshold', 2 ) ) {
					$q->set( 's', $job_manager_keyword );
					add_filter( 'posts_search', 'get_job_listings_keyword_search' );
				}
			} elseif ( ! empty( $_GET['s'] ) ) {
				global $job_manager_keyword;
				$job_manager_keyword = sanitize_text_field( wp_unslash( $_GET['s'] ) );

				if ( ! empty( $job_manager_keyword ) && strlen( $job_manager_keyword ) >= apply_filters( 'job_manager_get_listings_keyword_length_threshold', 2 ) ) {
					add_filter( 'posts_search', 'get_job_listings_keyword_search' );
				}
			}
		}

		/**
		 * Appends meta queries to an array.
		 *
		 * @param  array $meta_query Meta query.
		 * @param  bool  $main_query If is main query.
		 * @return array
		 */
		public function get_meta_query( $meta_query = array(), $main_query = false ) {
			if ( ! is_array( $meta_query ) ) {
				$meta_query = array();
			}

			$meta_query['search_location_filter'] = $this->search_location_filter_meta_query();
			$meta_query['company_name_filter']    = $this->company_name_filter_meta_query();
			$meta_query['company_id_filter']      = $this->company_id_filter_meta_query();

			if ( 1 === absint( get_option( 'job_manager_hide_filled_positions' ) ) ) {
				$meta_query[] = array(
					'key'     => '_filled',
					'value'   => '1',
					'compare' => '!=',
				);
			}

			return array_filter( apply_filters( 'finder_job_listing_query_meta_query', $meta_query, $this ) );
		}

		/**
		 * Appends tax queries to an array.
		 *
		 * @param  array $tax_query  Tax query.
		 * @param  bool  $main_query If is main query.
		 * @return array
		 */
		public function get_tax_query( $tax_query = array(), $main_query = false ) {
			if ( ! is_array( $tax_query ) ) {
				$tax_query = array(
					'relation' => 'AND',
				);
			}

			// Layered nav filters on terms.
			if ( $main_query ) {
				foreach ( $this->get_layered_nav_chosen_taxonomies() as $taxonomy => $data ) {
					$tax_query[] = array(
						'taxonomy'         => $taxonomy,
						'field'            => 'slug',
						'terms'            => $data['terms'],
						'operator'         => 'and' === $data['query_type'] ? 'AND' : 'IN',
						'include_children' => false,
					);
				}
			}

			// Filter by category.
			if ( ! empty( $_GET['search_category'] ) ) {

				$search_category = filter_var( wp_unslash( $_GET['search_category'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );

				$categories  = is_array( $_GET['search_category'] ) ? $search_category : array_filter( array_map( 'trim', explode( ',', $search_category ) ) );
				$field       = is_numeric( $categories[0] ) ? 'term_id' : 'slug';
				$operator    = 'all' === get_option( 'job_manager_category_filter_type', 'all' ) && count( $categories ) > 1 ? 'AND' : 'IN';
				$tax_query[] = array(
					'taxonomy'         => 'job_listing_category',
					'field'            => $field,
					'terms'            => array_values( $categories ),
					'include_children' => 'AND' !== $operator,
					'operator'         => $operator,
				);
			}

			// Filter by type.
			if ( ! empty( $_GET['search_type'] ) ) {

				$search_type = filter_var( wp_unslash( $_GET['search_type'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );

				$types  = is_array( $_GET['search_type'] ) ? $search_type : array_filter( array_map( 'trim', explode( ',', $search_type ) ) );
				$field       = is_numeric( $types[0] ) ? 'term_id' : 'slug';
				$operator    = 'all' === get_option( 'job_manager_type_filter_type', 'all' ) && count( $types ) > 1 ? 'AND' : 'IN';
				$tax_query[] = array(
					'taxonomy'         => 'job_listing_type',
					'field'            => $field,
					'terms'            => array_values( $types ),
					'include_children' => 'AND' !== $operator,
					'operator'         => $operator,
				);
			}

			return array_filter( apply_filters( 'finder_job_listing_query_tax_query', $tax_query, $this ) );
		}

		/**
		 * Appends date queries to an array.
		 *
		 * @param  array $date_query Date query.
		 * @param  bool  $main_query If is main query.
		 * @return array
		 */
		public function get_date_query( $date_query = array(), $main_query = false ) {
			if ( ! is_array( $date_query ) ) {
				$date_query = array();
			}

			if ( ! empty( $_GET['posted_before'] ) ) {
				$posted_before = filter_var( wp_unslash( $_GET['posted_before'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
				$posted_arr    = explode( '-', $posted_before );
				$date_query[]  = array(
					'after' => implode( ' ', $posted_arr ) . ' ago',
				);
			}

			return array_filter( apply_filters( 'finder_job_listing_query_date_query', $date_query, $this ) );
		}

		/**
		 * Return posts_per_page value.
		 *
		 * @param  int  $per_page posts_per_page value.
		 * @param  bool $main_query If is main query.
		 * @return int
		 */
		public function get_posts_per_page( $per_page = 10, $main_query = false ) {
			if ( $main_query ) {
				$per_page = get_option( 'job_manager_per_page' );
			}

			return intval( apply_filters( 'finder_job_listing_query_posts_per_page', $per_page ) );
		}

		/**
		 * Return a meta query for filtering by location.
		 *
		 * @return array
		 */
		private function search_location_filter_meta_query() {
			if ( ! empty( $_GET['search_location'] ) ) {
				$location_meta_keys = array( 'geolocation_formatted_address', '_job_location', 'geolocation_state_long' );
				$location_search    = array( 'relation' => 'OR' );
				foreach ( $location_meta_keys as $meta_key ) {
					$location_search[] = array(
						'key'     => $meta_key,
						'value'   => filter_var( wp_unslash( $_GET['search_location'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ),
						'compare' => 'like',
					);
				}

				return $location_search;
			}

			return array();
		}

		/**
		 * Return a meta query for filtering by company name.
		 *
		 * @return array
		 */
		private function company_name_filter_meta_query() {
			$company_names = ! empty( $_GET['company_name'] ) ? explode( ',', filter_var( wp_unslash( $_GET['company_name'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ) ) : array();
			if ( ! empty( $company_names ) ) {
				$company_name_search = array( 'relation' => 'OR' );
				foreach ( $company_names as $company_name ) {
					$company_name_search[] = array(
						'key'     => '_company_name',
						'value'   => $company_name,
						'compare' => '=',
					);
				}

				return $company_name_search;
			}

			return array();
		}

		/**
		 * Return a meta query for filtering by company id.
		 *
		 * @return array
		 */
		private function company_id_filter_meta_query() {

			$company_ids = ! empty( $_GET['company_id'] ) ? explode( ',', filter_var( wp_unslash( $_GET['company_id'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ) ) : array();
			if ( ! empty( $company_ids ) ) {
				$company_id_search = array( 'relation' => 'OR' );
				foreach ( $company_ids as $company_id ) {
					$company_id_search[] = array(
						'key'     => '_company_id',
						'value'   => $company_id,
						'compare' => '=',
					);
				}

				return $company_id_search;
			}

			return array();
		}

		/**
		 * Returns an array of arguments for ordering jobs based on the selected values.
		 *
		 * @param string $orderby Order by param.
		 * @param string $order Order param.
		 * @return array
		 */
		public function get_catalog_ordering_args( $orderby = '', $order = '' ) {
			// Get ordering from query string unless defined.
			if ( ! $orderby ) {
				$orderby_value = isset( $_GET['orderby'] ) ? finder_clean( (string) wp_unslash( $_GET['orderby'] ) ) : finder_clean( get_query_var( 'orderby' ) ); // WPCS: sanitization ok, input var ok, CSRF ok.

				if ( ! $orderby_value ) {
					if ( is_search() ) {
						$orderby_value = 'relevance';
					} else {
						$orderby_value = apply_filters( 'front_job_listing_default_catalog_orderby', 'date' );
					}
				}

				// Get order + orderby args from string.
				$orderby_value = explode( '-', $orderby_value );
				$orderby       = esc_attr( $orderby_value[0] );
				$order         = ! empty( $orderby_value[1] ) ? $orderby_value[1] : $order;
			}

			$orderby = strtolower( $orderby );
			$order   = strtoupper( $order );
			$args    = array(
				'orderby'  => $orderby,
				'order'    => ( 'DESC' === $order ) ? 'DESC' : 'ASC',
				'meta_key' => '', // @codingStandardsIgnoreLine
			);

			switch ( $orderby ) {
				case 'menu_order':
					$args['orderby'] = 'menu_order title';
					break;
				case 'title':
					$args['orderby'] = 'title';
					$args['order']   = ( 'DESC' === $order ) ? 'DESC' : 'ASC';
					break;
				case 'relevance':
					$args['orderby'] = 'relevance';
					$args['order']   = 'DESC';
					break;
				case 'rand':
					$args['orderby'] = 'rand'; // @codingStandardsIgnoreLine
					break;
				case 'date':
					$args['orderby'] = 'date ID';
					$args['order']   = ( 'ASC' === $order ) ? 'ASC' : 'DESC';
					break;
				case 'featured':
					$args['orderby']  = 'meta_value date ID';
					$args['meta_key'] = '_featured';
					$args['order']    = ( 'ASC' === $order ) ? 'ASC' : 'DESC';
					break;
			}

			return apply_filters( 'finder_job_listing_get_catalog_ordering_args', $args );
		}

		/**
		 * Get the main query which job queries ran against.
		 *
		 * @return array
		 */
		public static function get_main_query() {
			return self::$finder_wpjm_query;
		}

		/**
		 * Get the tax query which was used by the main query.
		 *
		 * @return array
		 */
		public static function get_main_tax_query() {
			$tax_query = isset( self::$finder_wpjm_query->tax_query, self::$finder_wpjm_query->tax_query->queries ) ? self::$finder_wpjm_query->tax_query->queries : array();

			return $tax_query;
		}

		/**
		 * Get the meta query which was used by the main query.
		 *
		 * @return array
		 */
		public static function get_main_meta_query() {
			$args       = isset( self::$finder_wpjm_query->query_vars ) ? self::$finder_wpjm_query->query_vars : array();
			$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

			return $meta_query;
		}

		/**
		 * Get the date query which was used by the main query.
		 *
		 * @return array
		 */
		public static function get_main_date_query() {
			$date_query = isset( self::$finder_wpjm_query->date_query, self::$finder_wpjm_query->date_query->queries ) ? self::$finder_wpjm_query->date_query->queries : array();

			return $date_query;
		}

		/**
		 * Based on WP_Query::parse_search
		 */
		public static function get_main_search_query_sql() {
			global $wpdb;

			$args         = isset( self::$finder_wpjm_query->query_vars ) ? self::$finder_wpjm_query->query_vars : array();
			$search_terms = isset( $args['search_terms'] ) ? $args['search_terms'] : array();
			$sql          = array();

			foreach ( $search_terms as $term ) {
				// Terms prefixed with '-' should be excluded.
				$include = '-' !== substr( $term, 0, 1 );

				if ( $include ) {
					$like_op  = 'LIKE';
					$andor_op = 'OR';
				} else {
					$like_op  = 'NOT LIKE';
					$andor_op = 'AND';
					$term     = substr( $term, 1 );
				}

				$like  = '%' . $wpdb->esc_like( $term ) . '%';
				$sql[] = $wpdb->prepare( "(($wpdb->posts.post_title $like_op %s) $andor_op ($wpdb->posts.post_excerpt $like_op %s) $andor_op ($wpdb->posts.post_content $like_op %s))", $like, $like, $like ); // unprepared SQL ok.
			}

			if ( ! empty( $sql ) && ! is_user_logged_in() ) {
				$sql[] = "($wpdb->posts.post_password = '')";
			}

			return implode( ' AND ', $sql );
		}

		/**
		 * Get an array of taxonomies and terms selected with the layered nav widget.
		 *
		 * @return array
		 */
		public static function get_layered_nav_chosen_taxonomies() {
			if ( ! is_array( self::$_chosen_taxonomies ) ) {
				self::$_chosen_taxonomies = array();
				$taxonomies               = finder_wpjm_get_all_taxonomies();

				if ( ! empty( $taxonomies ) ) {
					foreach ( $taxonomies as $tax ) {
						$taxonomy     = $tax['taxonomy'];
						$filter_terms = ! empty( $_GET[ 'filter_' . $taxonomy ] ) ? explode( ',', finder_clean( wp_unslash( $_GET[ 'filter_' . $taxonomy ] ) ) ) : array(); // WPCS: sanitization ok, input var ok, CSRF ok.

						if ( empty( $filter_terms ) || ! taxonomy_exists( $taxonomy ) ) {
							continue;
						}

						$query_type                                     = ! empty( $_GET[ 'query_type_' . $taxonomy ] ) && in_array( $_GET[ 'query_type_' . $taxonomy ], array( 'and', 'or' ), true ) ? finder_clean( wp_unslash( $_GET[ 'query_type_' . $taxonomy ] ) ) : ''; // WPCS: sanitization ok, input var ok, CSRF ok.
						self::$_chosen_taxonomies[ $taxonomy ]['terms'] = array_map( 'sanitize_title', $filter_terms ); // Ensures correct encoding.
						self::$_chosen_taxonomies[ $taxonomy ]['query_type'] = $query_type ? $query_type : apply_filters( 'finder_wpjm_layered_nav_default_query_type', 'and' );
					}
				}
			}

			return self::$_chosen_taxonomies;
		}
	}
}

$finder_wpjm_query = new Finder_WPJM_Query();
