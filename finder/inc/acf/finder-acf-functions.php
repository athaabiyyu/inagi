<?php
/**
 * Finder ACF functions
 *
 * @package  finder
 */

if ( ! function_exists( 'finder_get_field' ) ) {
	/**
	 * Wrapper for ACF's get_field function.
	 *
	 * @param string   $field custom field key.
	 * @param int|bool $post_id ID of the post.
	 * @param bool     $format_value should format the meta value or not.
	 * @return mixed
	 */
	function finder_get_field( $field, $post_id = false, $format_value = true ) {
		if ( function_exists( 'get_field' ) ) {
			return get_field( $field, $post_id, $format_value );
		}

		return false;
	}
}

/**
 * Get term field
 *
 * @param string $field_name The meta field name.
 * @param string $taxonomy_name taxonamy key.
 * @param int    $term_id taxonamy ID.
 * @return mixed
 */
function finder_acf_get_term_field( $field_name, $taxonomy_name, $term_id ) {

	$value = finder_get_field( $field_name, $taxonomy_name . '_' . $term_id );

	return $value;
}


require_once FINDER_THEME_DIR . 'inc/acf/blog-post.php';
require_once FINDER_THEME_DIR . 'inc/acf/tax.php';
require_once FINDER_THEME_DIR . 'inc/acf/vendor.php';
require_once FINDER_THEME_DIR . 'inc/acf/job-listing.php';
require_once FINDER_THEME_DIR . 'inc/acf/listing.php';
require_once FINDER_THEME_DIR . 'inc/acf/page.php';




