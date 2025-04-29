<?php
/**
 * ACF Functions related to single post.
 *
 * @package Finder.
 */

if ( ! function_exists( 'finder_acf_single_post_styles' ) ) {
	/**
	 * Single Post Custom Field Options
	 */
	function finder_acf_single_post_styles() {
		return finder_get_field( 'single_post_styles' );
	}
}

if ( ! function_exists( 'finder_acf_single_post_author_by_line' ) ) {
	/**
	 * Single post author by line.
	 */
	function finder_acf_single_post_author_by_line() {
		$author_id = get_the_author_meta( 'ID' );
		return finder_get_field( 'single_post_author_by_line', 'user_' . $author_id );
	}
}

if ( ! function_exists( 'finder_acf_single_post_social_share' ) ) {
	/**
	 * Single post social share.
	 */
	function finder_acf_single_post_social_share() {
		return finder_get_field( 'single_post_social_share' );
	}
}

if ( ! function_exists( 'finder_user_social_links' ) ) {
	/**
	 * Finder User Profile Links.
	 */
	function finder_user_social_links() {
		$author_id = get_the_author_meta( 'ID' );
		return finder_get_field( 'social_profile_links', 'user_' . $author_id );
	}
}


if ( ! function_exists( 'finder_acf_blog_post_badge' ) ) {
	/**
	 * Blog post badge.
	 */
	function finder_acf_blog_post_badge() {
		return finder_get_field( 'blog_post_badge' );
	}
}

if ( ! function_exists( 'finder_acf_cover_image' ) ) {
	/**
	 * Blog post badge.
	 */
	function finder_acf_cover_image() {
		return finder_get_field( 'cover_url' );
	}
}
