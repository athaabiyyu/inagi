<?php
/**
 * ACF Functions related to vendor single post.
 *
 * @package Finder.
 */

if ( ! function_exists( 'finder_acf_vendor_single_style' ) ) {
	/**
	 * Vendor single listing style.
	 */
	function finder_acf_vendor_single_style() {
		return finder_get_field( 'vendor_styles' );
	}
}


