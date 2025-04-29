<?php
/**
 * Template hooks used in Blog Post.
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'finder_sidebar', 'finder_blog_sidebar' );
add_filter( 'excerpt_more', 'finder_excerpt_more', 20 );
