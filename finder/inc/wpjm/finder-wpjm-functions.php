<?php
/**
 * Finder WPJM Functions
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get page id.
 *
 * @param string $page of arguments.
 */
function finder_wpjm_get_page_id( $page ) {

	$option_name = '';
	switch ( $page ) {
		case 'jobs':
			$option_name = 'job_manager_jobs_page_id';
			break;
		case 'jobs-dashboard':
			$option_name = 'job_manager_job_dashboard_page_id';
			break;
		case 'post-a-job':
			$option_name = 'job_manager_submit_job_form_page_id';
			break;
	}

	$page_id = 0;

	if ( ! empty( $option_name ) ) {
		$page_id = get_option( $option_name );
	}

	$page_id = apply_filters( 'finder_wpjm_get_' . $page . '_page_id', $page_id );
	return $page_id ? absint( $page_id ) : -1;
}

/**
 * Is_job_listing_taxonomy - Returns true when viewing a job_listing taxonomy archive.
 *
 * @return bool
 */
function finder_is_job_listing_taxonomy() {
	return is_tax( get_object_taxonomies( 'job_listing' ) );
}

/**
 * Get the default wpjm listing layout.
 *
 * @return string
 */
function finder_wpjm_get_default_listings_layout() {
	return apply_filters( 'finder_wpjm_default_listings_layout', 'right-sidebar' );
}

/**
 * Get the wpjm listing layout.
 *
 * @return string
 */
function finder_get_wpjm_job_listing_layout() {

	$default_listing_layout = finder_wpjm_get_default_listings_layout();
	$layout                 = get_theme_mod( 'finder_wpjm_listings_layout', $default_listing_layout );

	return (string) apply_filters( 'finder_get_wpjm_job_listing_layout', $layout );
}


if ( ! function_exists( 'finder_get_the_company_job_listing' ) ) {
	/**
	 * Get job listings.
	 *
	 * @param object $post post object as arguments.
	 */
	function finder_get_the_company_job_listing( $post = null ) {
		if ( ! $post ) {
			global $post;
		}

		return get_posts(
			array(
				'post_type'  => 'job_listing',
				'meta_value' => $post->_job_location,
				'nopaging'   => true,
			)
		);
	}
}

if ( ! function_exists( 'finder_get_the_company_job_listing_count' ) ) {
	/**
	 * Get the company openings count.
	 *
	 * @param object $post post object as arguments.
	 */
	function finder_get_the_company_job_listing_count( $post = null ) {
		$posts = finder_get_the_company_job_listing( $post );
		return count( $posts );
	}
}

/**
 * Get the jobmanager single related post enable or disable.
 *
 * @return boolean
 */
function finder_job_related_post_enabled() {
	$related_post_enable_disable     = get_theme_mod( 'finder_jobmanger_single_post_related_post', false );
	$related_post_enable_disable_acf = finder_acf_job_single_related_post();

	if ( finder_is_acf_activated() ) {
		$related_post_enable_disable = $related_post_enable_disable_acf;
	}

	return (bool) apply_filters( 'finder_job_enable_related_post', $related_post_enable_disable );
}

/**
 * Sets up the finder_wpjm_loop global from the passed args or from the main query.
 *
 * @param array $args Args to pass into the global.
 */
function finder_wpjm_setup_loop( $args = array() ) {
	$default_args = array(
		'loop'         => 0,
		'columns'      => 1,
		'name'         => '',
		'is_shortcode' => false,
		'is_paginated' => true,
		'is_search'    => false,
		'is_filtered'  => false,
		'total'        => 0,
		'total_pages'  => 0,
		'per_page'     => 0,
		'current_page' => 1,
	);

	// If this is a main WC query, use global args as defaults.
	if ( $GLOBALS['wp_query']->get( 'finder_wpjm_query' ) ) {
		$default_args = array_merge(
			$default_args,
			array(
				'is_search'    => $GLOBALS['wp_query']->is_search(),
				'total'        => $GLOBALS['wp_query']->found_posts,
				'total_pages'  => $GLOBALS['wp_query']->max_num_pages,
				'per_page'     => $GLOBALS['wp_query']->get( 'posts_per_page' ),
				'current_page' => max( 1, $GLOBALS['wp_query']->get( 'paged', 1 ) ),
			)
		);
	}

	// Merge any existing values.
	if ( isset( $GLOBALS['finder_wpjm_loop'] ) ) {
		$default_args = array_merge( $default_args, $GLOBALS['finder_wpjm_loop'] );
	}

	$GLOBALS['finder_wpjm_loop'] = wp_parse_args( $args, $default_args );
}

/**
 * Resets the finder_wpjm_loop global.
 */
function finder_wpjm_reset_loop() {
	unset( $GLOBALS['finder_wpjm_loop'] );
}

/**
 * Gets a property from the finder_wpjm_loop global.
 *
 * @param string $prop Prop to get.
 * @param string $default Default if the prop does not exist.
 * @return mixed
 */
function finder_wpjm_get_loop_prop( $prop, $default = '' ) {
	finder_wpjm_setup_loop(); // Ensure shop loop is setup.

	return isset( $GLOBALS['finder_wpjm_loop'], $GLOBALS['finder_wpjm_loop'][ $prop ] ) ? $GLOBALS['finder_wpjm_loop'][ $prop ] : $default;
}

/**
 * Sets a property in the finder_wpjm_loop global.
 *
 * @param string $prop Prop to set.
 * @param string $value Value to set.
 */
function finder_wpjm_set_loop_prop( $prop, $value = '' ) {
	if ( ! isset( $GLOBALS['finder_wpjm_loop'] ) ) {
		finder_wpjm_setup_loop();
	}
	$GLOBALS['finder_wpjm_loop'][ $prop ] = $value;
}

/**
 * Get the jobmanager taxonomies.
 *
 * @return array
 */
function finder_wpjm_get_all_taxonomies() {
	$taxonomies = array();

	$taxonomy_objects = get_object_taxonomies( 'job_listing', 'objects' );
	foreach ( $taxonomy_objects as $taxonomy_object ) {
		$taxonomies[] = array(
			'taxonomy' => $taxonomy_object->name,
			'name'     => $taxonomy_object->label,
		);
	}

	return $taxonomies;
}

/**
 * Enable Category Job Manager.
 *
 * @return string
 */
function finder_wpjm_enable_category() {
	return get_option( 'job_manager_enable_categories' );
}

/**
 * Enable job-type Job Manager.
 *
 * @return string
 */
function finder_wpjm_enable_job_types() {
	return get_option( 'job_manager_enable_types' );
}
