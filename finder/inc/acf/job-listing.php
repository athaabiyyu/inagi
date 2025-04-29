<?php
/**
 * ACF Functions related to jobmanager single post.
 *
 * @package Finder.
 */

if ( ! function_exists( 'finder_acf_job_single_related_post' ) ) {
	/**
	 * Job single related post.
	 */
	function finder_acf_job_single_related_post() {
		return finder_get_field( 'related_job_enable_disable' );
	}
}

if ( ! function_exists( 'finder_acf_job_single_related_title_text' ) ) {
	/**
	 * Job single related title text.
	 */
	function finder_acf_job_single_related_title_text() {
		return finder_get_field( 'related_job_title_text' );
	}
}

if ( ! function_exists( 'finder_acf_job_single_related_action_text_url' ) ) {
	/**
	 * Job single related action text url.
	 */
	function finder_acf_job_single_related_action_text_url() {
		return finder_get_field( 'related_job_action_text_url' );
	}
}

if ( ! function_exists( 'finder_acf_job_single_related_action_text' ) ) {
	/**
	 * Job single related action text .
	 */
	function finder_acf_job_single_related_action_text() {
		return finder_get_field( 'related_job_action_text' );
	}
}

if ( ! function_exists( 'finder_acf_job_single_related_per_page' ) ) {
	/**
	 * Job single related post per page.
	 */
	function finder_acf_job_single_related_per_page() {
		return finder_get_field( 'related_job_per_page' );
	}
}

