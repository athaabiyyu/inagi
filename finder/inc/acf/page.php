<?php
/**
 * ACF Functions related to Header Options.
 *
 * @package Finder.
 */

if ( ! function_exists( 'finder_header_acf_is_custom_header' ) ) {
	/**
	 * Custom Header Option.
	 */
	function finder_header_acf_is_custom_header() {
		$is_custom_header = finder_get_field( 'is_custom_header' );

		return filter_var( $is_custom_header, FILTER_VALIDATE_BOOLEAN );
	}
}

if ( ! function_exists( 'finder_acf_get_page_header' ) ) {
	/**
	 * Page Header Option.
	 */
	function finder_acf_get_page_header() {
		$page_header = finder_get_field( 'disable_page_header' );

		return filter_var( $page_header, FILTER_VALIDATE_BOOLEAN );
	}
}

if ( ! function_exists( 'finder_acf_get_page_additional_classes' ) ) {
	/**
	 * Get Additional classes for page.
	 */
	function finder_acf_get_page_additional_classes() {
		return finder_get_field( 'body_css_class' );
	}
}

if ( ! function_exists( 'finder_footer_acf_is_custom_footer' ) ) {
	/**
	 * Footer Option.
	 */
	function finder_footer_acf_is_custom_footer() {
		$is_custom_footer = finder_get_field( 'enable_custom_footer' );

		return $is_custom_footer;
	}
}

if ( ! function_exists( 'finder_footer_acf_footer_version' ) ) {
	/**
	 * Footer Option.
	 */
	function finder_footer_acf_footer_version() {
		$footer_version = finder_get_field( 'footer_version' );

		return $footer_version;
	}
}

if ( ! function_exists( 'finder_footer_acf_copyrights' ) ) {
	/**
	 * Footer Copyrights.
	 */
	function finder_footer_acf_copyrights() {
		$footer_copyrights = finder_get_field( 'footer_copyrights' );

		return $footer_copyrights;
	}
}

if ( ! function_exists( 'finder_footer_acf_banner_title' ) ) {
	/**
	 * Footer Banner Title.
	 */
	function finder_footer_acf_banner_title() {
		$footer_banner_title = finder_get_field( 'footer_banner_title' );

		return $footer_banner_title;
	}
}

if ( ! function_exists( 'finder_footer_acf_banner_description' ) ) {
	/**
	 * Footer Banner Description.
	 */
	function finder_footer_acf_banner_description() {
		$footer_banner_description = finder_get_field( 'footer_banner_description' );

		return $footer_banner_description;
	}
}

if ( ! function_exists( 'finder_footer_acf_banner_images' ) ) {
	/**
	 * Footer Banner Images.
	 */
	function finder_footer_acf_banner_images() {
		$footer_banner_images = finder_get_field( 'footer_banner_image' );

		return $footer_banner_images;
	}
}

if ( ! function_exists( 'finder_footer_acf_banner_app_store_images' ) ) {
	/**
	 * Footer Banner App Images.
	 */
	function finder_footer_acf_banner_app_store_images() {
		$footer_banner_app_store_images = finder_get_field( 'footer_banner_app_store_image' );

		return $footer_banner_app_store_images;
	}
}

if ( ! function_exists( 'finder_footer_acf_banner_app_store_images_url' ) ) {
	/**
	 * Footer Banner App Images URL.
	 */
	function finder_footer_acf_banner_app_store_images_url() {
		$footer_banner_app_store_images_url = finder_get_field( 'footer_banner_app_store_image_url' );

		return $footer_banner_app_store_images_url;
	}
}

if ( ! function_exists( 'finder_footer_acf_banner_google_play_images' ) ) {
	/**
	 * Footer Banner Google Play Images.
	 */
	function finder_footer_acf_banner_google_play_images() {
		$footer_banner_google_images = finder_get_field( 'footer_banner_google_play_image' );

		return $footer_banner_google_images;
	}
}

if ( ! function_exists( 'finder_footer_acf_banner_google_play_images_url' ) ) {
	/**
	 * Footer Banner Google Play Images URL.
	 */
	function finder_footer_acf_banner_google_play_images_url() {
		$footer_banner_google_images_url = finder_get_field( 'footer_banner_google_play_image_url' );

		return $footer_banner_google_images_url;
	}
}

if ( ! function_exists( 'finder_footer_acf_form_title' ) ) {
	/**
	 * Footer Form Title.
	 */
	function finder_footer_acf_form_title() {
		$footer_form_title = finder_get_field( 'footer_form_title' );

		return $footer_form_title;
	}
}

if ( ! function_exists( 'finder_footer_acf_form' ) ) {
	/**
	 * Footer Form .
	 */
	function finder_footer_acf_form() {
		$footer_form_acf = finder_get_field( 'footer_form' );

		return $footer_form_acf;
	}
}

if ( ! function_exists( 'finder_footer_acf_form_description' ) ) {
	/**
	 * Footer Form Description.
	 */
	function finder_footer_acf_form_description() {
		$footer_form_description = finder_get_field( 'footer_form_description' );

		return $footer_form_description;
	}
}
