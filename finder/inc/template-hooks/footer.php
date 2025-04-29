<?php
/**
 * Template hooks used in Single Post.
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Footer Hooks.
 */
add_action( 'finder_footer', 'finder_get_footer' );

// Footer 404 copyright.
add_action( 'finder_footer_404', 'finder_footer_404_copyright', 10 );
// Footer 404 social media links.
add_action( 'finder_footer_404', 'finder_footer_404_social_media_links_wrap', 20 );
