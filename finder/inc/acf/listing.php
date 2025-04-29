<?php
/**
 * ACF Functions related to listing single post.
 *
 * @package Finder.
 */

if ( ! function_exists( 'finder_hivepress_acf_get_listing_single_style' ) ) {
	/**
	 * Listings Style.
	 */
	function finder_hivepress_acf_get_listing_single_style() {
		return finder_get_field( 'single_listing_style' );
	}
}

if ( ! function_exists( 'finder_hivepress_acf_is_related_listing_enabled' ) ) {
	/**
	 * Related Listings Enable or Disable.
	 */
	function finder_hivepress_acf_is_related_listing_enabled() {
		return finder_get_field( 'related_listing_enable_disable' );
	}
}

if ( ! function_exists( 'finder_hivepress_acf_get_related_listing_title' ) ) {
	/**
	 * Related Listings Title.
	 */
	function finder_hivepress_acf_get_related_listing_title() {
		return finder_get_field( 'related_listing_title' );
	}
}

if ( ! function_exists( 'finder_hivepress_acf_get_related_listing_action_text' ) ) {
	/**
	 * Related Listings Action Text.
	 */
	function finder_hivepress_acf_get_related_listing_action_text() {
		return finder_get_field( 'related_listing_action_text' );
	}
}

if ( ! function_exists( 'finder_hivepress_acf_related_listing_action_text_url' ) ) {
	/**
	 * Related Listings Action Text URL.
	 */
	function finder_hivepress_acf_related_listing_action_text_url() {
		return finder_get_field( 'related_listing_text_url' );
	}
}
