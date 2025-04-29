<?php
/**
 * ACF Functions related to Blog post.
 *
 * @package Finder.
 */

/**
 * Get display posts style for the taxonomy.
 *
 * @param WP_Term $term Term object.
 * @return string
 */
function finder_acf_blog_post_style( $term ) {
	$style = finder_get_field( 'blog_styles', $term );

	return $style;
}

/**
 * Get display Blog Post column Layout for the taxonomy.
 *
 * @param WP_Term $term Term object.
 * @return string
 */
function finder_acf_get_blog_post_column( $term ) {
	$column = finder_get_field( 'blog_column', $term );

	return $column;
}
