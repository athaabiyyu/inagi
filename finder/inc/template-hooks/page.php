<?php
/**
 * Template hooks used in page.
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Page Hooks.
 */
add_action( 'finder_page', 'finder_page_header', 10 );
add_action( 'finder_page', 'finder_page_content', 20 );
add_action( 'finder_body_bottom', 'finder_scroll_to_top', 50 );

/**
 * Breadcrumb blog.
 */
add_filter( 'finder_get_breadcrumb', 'finder_get_post_breadcrumb', 99, 2 );
