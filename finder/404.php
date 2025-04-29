<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Finder
 */

get_header( '404' );
do_action( 'finder_header_404' );
	$page_variant = get_theme_mod( 'finder_404_version', 'v1' );
	finder_get_template( '404/404-' . $page_variant . '.php' );

get_footer( '404' );
