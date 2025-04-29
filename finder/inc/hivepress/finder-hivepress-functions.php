<?php
/**
 * Finder HivePress Functions
 *
 * @package Finder
 */

use HivePress\Blocks\Part;

/**
 * Hivepress templates part.
 *
 * @param string $template_part template part.
 * @return void
 */
function finder_hivepress_template( $template_part ) {
	echo ( new Part( array( 'path' => $template_part ) ) )->render(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Get the hivepress listings page Id.
 *
 * @return integer
 */
function finder_hivepress_get_listings_page_id() {

	$page_id = 0;

	if ( get_option( 'hp_page_listings' ) ) {
		$page_id = absint( get_option( 'hp_page_listings' ) );
	}

	return $page_id;
}

/**
 * Get the hivepress listings page URL.
 *
 * @return string
 */
function finder_hivepress_get_listings_page_url() {
	$page_id = finder_hivepress_get_listings_page_id();

	if ( $page_id ) {
		$url = get_permalink( $page_id );
	} else {
		$url = get_post_type_archive_link( 'hp_listing' );
	}

	return $url;
}

/**
 * Get the default hivepress listing layout.
 *
 * @return string
 */
function finder_hivepress_get_default_listings_layout() {
	return apply_filters( 'finder_hivepress_default_listings_layout', 'left-sidebar' );
}

/**
 * Get the hivepress listing layout.
 *
 * @return string
 */
function finder_hivepress_get_listings_layout() {

	$default_listing_layout = finder_hivepress_get_default_listings_layout();
	$listing_layout         = get_theme_mod( 'finder_hivepress_listings_layout', $default_listing_layout );

	return (string) apply_filters( 'finder_hivepress_listings_layout_version', $listing_layout );
}

/**
 * Get the default hivepress listing style.
 *
 * @return string
 */
function finder_hivepress_get_default_listings_style() {
	return apply_filters( 'finder_hivepress_default_listings_style', 'real-estate' );
}

/**
 * Get the hivepress listing style.
 *
 * @return string
 */
function finder_hivepress_get_listings_style() {

	$default_listing_style = finder_hivepress_get_default_listings_style();
	$listing_style         = get_theme_mod( 'finder_hivepress_listings_style', $default_listing_style );

	return (string) apply_filters( 'finder_hivepress_listings_style_version', $listing_style );
}

/**
 * Get the default hivepress listing single style.
 *
 * @return string
 */
function finder_hivepress_get_default_listing_single_style() {
	return apply_filters( 'finder_hivepress_default_listing_single_style', 'real-estate' );
}

/**
 * Get the hivepress listing single style.
 *
 * @return string
 */
function finder_hivepress_get_listing_single_style() {

	$default_listing_single_style = finder_hivepress_get_default_listing_single_style();
	$listing_single_style         = get_theme_mod( 'finder_hivepress_listing_single_style', $default_listing_single_style );
	$listing_single_style_acf     = finder_hivepress_acf_get_listing_single_style();

	if ( $listing_single_style_acf && 'default' !== $listing_single_style_acf ) {
		$listing_single_style = $listing_single_style_acf;
	}

	return (string) apply_filters( 'finder_hivepress_listings_single_style_version', $listing_single_style );
}

/**
 * Get the hivepress single related listing enable or disable.
 *
 * @return boolean
 */
function finder_hivepress_is_related_listing_enabled() {
	$related_listing_enable_disable = get_theme_mod( 'finder_related_single_listing_enable_disable', 'yes' );

	if ( 'yes' === $related_listing_enable_disable ) {
		$related_listing_enable_disable = true;
	} else {
		$related_listing_enable_disable = false;
	}

	$related_listing_acf_enable_disable = finder_hivepress_acf_is_related_listing_enabled();

	if ( finder_is_acf_activated() && true === $related_listing_acf_enable_disable ) {
		$related_listing_enable_disable = $related_listing_acf_enable_disable;
	}

	return (bool) apply_filters( 'finder_hivepress_single_enable_related_listing', $related_listing_enable_disable );
}

/**
 * Get the hivepress single related listing enable or disable.
 *
 * @return boolean
 */
function finder_hivepress_is_related_vendor_enabled() {
		$related_vendor_enable_disable = get_theme_mod( 'finder_related_single_vendor_enable_disable', 'no' );
		return apply_filters( 'finder_hivepress_single_enable_related_vendor', $related_vendor_enable_disable );
}

/**
 * Returns the current view mode
 *
 * @return string
 *
 * @since 1.0.0
 */
function finder_hivepress_get_listings_catalog_view() {
	if ( isset( $_GET['view'] ) && ! empty( $_GET['view'] ) ) {
		$view = sanitize_key( wp_unslash( $_GET['view'] ) );
	} else {
		$view = get_theme_mod( 'finder_hivepress_listings_car_finder_catalog_layout', 'grid' );
	}

	return (string) apply_filters( 'finder_hivepress_listings_view', $view );
}

/**
 * Get the hivepress listing count.
 *
 * @return integer
 */
function finder_hivepress_get_listings_result_count() {
	global $wp_query;

	$total_results = '';

	if ( $wp_query->found_posts || hivepress()->request->get_context( 'featured_ids' ) ) {

		// Get total results.
		$total_results = $wp_query->found_posts;

		// Add featured results.
		if ( hivepress()->request->get_context( 'featured_ids' ) ) {
			$featured_results = count( hivepress()->request->get_context( 'featured_ids' ) );

			$total_results += $featured_results;
		}
	}

	return $total_results;
}

/**
 * Get the default hivepress listing style.
 *
 * @return string
 */
function finder_hivepress_get_default_vendor_single_style() {
	return apply_filters( 'finder_hivepress_default_vendor_single_style', 'real-estate' );
}

/**
 * Get the hivepress listing style.
 *
 * @return string
 */
function finder_hivepress_get_vendor_single_style() {
	$vendor_single_style_acf     = finder_acf_vendor_single_style();
	$default_vendor_single_style = finder_hivepress_get_default_vendor_single_style();
	$vendor_single_style         = get_theme_mod( 'finder_hivepress_vendor_single_style', $default_vendor_single_style );

	if ( finder_is_acf_activated() ) {
		if ( $vendor_single_style_acf && 'default' !== $vendor_single_style_acf ) {
			$vendor_single_style = $vendor_single_style_acf;
		}
	}

	return (string) apply_filters( 'finder_hivepress_vendor_single_style_version', $vendor_single_style );
}


/**
 * Get the default hivepress user account style.
 *
 * @return string
 */
function finder_hivepress_get_default_user_account_style() {
	return apply_filters( 'finder_hivepress_get_default_user_account_style', 'real-estate' );
}

/**
 * Get the hivepress user account style.
 *
 * @return string
 */
function finder_hivepress_get_user_account_style() {

	$default_account_style = finder_hivepress_get_default_user_account_style();
	$account_style         = get_theme_mod( 'finder_hivepress_my_account_style', $default_account_style );

	return (string) apply_filters( 'finder_hivepress_my_account_style_version', $account_style );
}

/**
 * Get the hivepress listing attribute id by attribute slug.
 *
 * @param string $slug attribute slug.
 * @return integer attribute_id attribute id.
 */
function finder_hivepress_get_listing_attribute_id_by_slug( $slug ) {

	$args = array(
		'post_type'      => 'hp_listing_attribute',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	);

	$listing_attributes = get_posts( $args );

	$attribute_id = 0;

	foreach ( $listing_attributes as $attribute ) {
		if ( $attribute->post_name === $slug ) {
			$attribute_id = $attribute->ID;
		}
	}

	return $attribute_id;
}

/**
 * Get the hivepress vendor attribute id by attribute slug.
 *
 * @param string $slug attribute slug.
 * @return integer attribute_id attribute id.
 */
function finder_hivepress_get_vendor_attribute_id_by_slug( $slug ) {

	$args = array(
		'post_type'      => 'hp_vendor_attribute',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	);

	$vendor_attributes = get_posts( $args );

	$attribute_id = 0;

	foreach ( $vendor_attributes as $attribute ) {
		if ( $attribute->post_name === $slug ) {
			$attribute_id = $attribute->ID;
		}
	}

	return $attribute_id;
}

/**
 * Get the hivepress listing column style.
 *
 * @return string
 */
function finder_hivepress_listing_columns() {

	$col_style = get_theme_mod( 'finder_listing_columns', '3' );

	return (string) apply_filters( 'finder_hivepress_listing_column_style', $col_style );
}

/**
 * Hivepress Get Attribute Display.
 *
 * @param object $display display field.
 * @param string $field_key acf style key.
 * @param string $attribute_id attribute id.
 * @return string
 */
function finder_hivepress_get_attribute_display( $display, $field_key = '', $attribute_id = '' ) {

	if ( empty( $field_key ) || empty( $attribute_id ) ) {
		return $display;
	}

	$attribute_css_classes = finder_get_field( $field_key, $attribute_id );
	$icon_classess         = '';

	if ( ! empty( $attribute_css_classes ) ) {
		$icon_classess = ' ' . $attribute_css_classes;
	}

	if ( preg_match( '/fi-/i', $display ) ) {
		$display = str_replace(
			'hp-icon fas fa-fw fa-none',
			'finder-icon' . $icon_classess,
			$display
		);
	} else {
		$display = str_replace(
			'hp-icon',
			'hp-icon' . $icon_classess,
			$display
		);
	}

	return $display;
}


/**
 * Hivepress Attribute Count.
 *
 * @param object $listing listing object.
 * @param array  $args array for the required attribute count.
 * @return integer
 */
function finder_hivepress_attribute_count( $listing, $args ) {

	$default_args = array(
		'location'   => 'view_block_primary',
		'key'        => '',
		'attr_style' => '',
	);

	$args = wp_parse_args( $args, $default_args );

	$i = 0;

	if ( $listing->_get_fields( $args['location'] ) ) :

		foreach ( $listing->_get_fields( $args['location'] ) as $key => $field ) {

			$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
			$attribute_view_style = finder_get_field( $args['key'], $attribute_id );

			if ( ! is_null( $field->get_value() ) ) {

				if ( ! empty( $args['key'] ) ) {

					if ( ! empty( $args['attr_style'] ) && $args['attr_style'] === $attribute_view_style ) {
						$i++;
					}
				} else {
					$i++;
				}
			}
		}

	endif;

	return $i;
}

/**
 * Hivepress Default Attribute Count.
 *
 * @param object $listing listing object.
 * @param array  $location location for the required attribute count.
 * @return integer
 */
function finder_hivepress_default_attribute_count( $listing, $location ) {

	$i = 0;

	if ( $listing->_get_fields( $location ) ) {

		foreach ( $listing->_get_fields( $location ) as $field ) {

			$attribute_id = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );

			if ( ! is_null( $field->get_value() ) ) {
				$i++;
			}
		}
	}

	return $i;
}

/**
 * Get the hivepress registration enable or disable.
 *
 * @return boolean
 */
function finder_hivepress_is_registration_enabled() {
	$is_register_enabled = get_option( 'hp_user_enable_registration', true );

	return $is_register_enabled;
}

/**
 * Get the hivepress listing attributes.
 *
 * @param  array $args hp_listing_attribute arguments.
 * @return array $attribute_options.
 */
function finder_hivepress_get_listing_attributes( $args = array() ) {

	$default_args = array(
		'post_type'   => 'hp_listing_attribute',
		'numberposts' => -1,
		'post_status' => 'publish',
	);

	$args = wp_parse_args( $args, $default_args );

	$listing_attributes = get_posts( $args );

	$attribute_options = array();

	return $listing_attributes;
}

/**
 * Get the hivepress listing attributes.
 *
 * @param  array $args hp_listing_attribute arguments.
 * @return array $attribute_options.
 */
function finder_hivepress_get_listing_attributes_options( $args = array() ) {

	$listing_attributes = finder_hivepress_get_listing_attributes( $args );

	$attribute_options = array();

	if ( $listing_attributes ) {
		foreach ( $listing_attributes as $attribute ) {
			$key                       = str_replace( '-', '_', $attribute->post_name );
			$attribute_options[ $key ] = $attribute->post_title;
		}
	} else {
		$attribute_options[''] = esc_html__( 'No Attributes Found', 'finder' );
	}

	return $attribute_options;
}

/**
 * Get the hivepress listing attributes.
 *
 * @param string $slug attribute slug.
 * @param array  $args hp_listing_attribute arguments.
 */
function finder_hivepress_get_listing_attribute_icon( $slug, $args = array() ) {

	$listing_attributes = finder_hivepress_get_listing_attributes( $args );

	$attribute_icon = false;

	if ( $listing_attributes ) {
		foreach ( $listing_attributes as $attribute ) {
			if ( $attribute->post_name === $slug && $attribute->hp_icon ) {
				$attribute_icon = $attribute->hp_icon;
				$attribute_icon = str_replace( 'none ', '', $attribute_icon );

				if ( ! preg_match( '/fi-/i', $attribute_icon ) ) {
					$attribute_icon = 'fas fa-fw fa-' . $attribute_icon;
				}
			}
		}
	}

	return $attribute_icon;
}

/**
 * Returns the Maptiler API.
 *
 * @return string
 *
 * @since 1.0.0
 */
function finder_hivepress_get_maptiler_api() {
	$key     = 'JlBYgyPJAvtWyOYAERlf';
	$default = apply_filters( 'finder_hivepress_default_api_key_format', 'https://api.maptiler.com/maps/pastel/{z}/{x}/{y}.png?key=' );
	$listing_map_api = $default . get_theme_mod( 'finder_listings_map_api_key', $key );
	return $listing_map_api;
}
