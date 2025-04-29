<?php
/**
 * Finder conditional functions.
 *
 * @package Finder
 */

/**
 * Check if Hivepress is activated
 *
 * @return bool
 */
function finder_is_hivepress_activated() {
	return function_exists( 'hivepress' ) ? true : false;
}

if ( ! function_exists( 'finder_is_wp_job_manager_activated' ) ) {
	/**
	 * Check if WP Job Manager is activated
	 */
	function finder_is_wp_job_manager_activated() {
		return class_exists( 'WP_Job_Manager' ) ? true : false;
	}
}

/**
 * Check if a page has custom footer
 *
 * @param array $options Page meta options.
 */
function finder_has_custom_footer( $options ) {

	$has_custom_footer = false;

	if ( isset( $options['footer'] ) && isset( $options['footer']['finder_enable_custom_footer'] ) && 'yes' === $options['footer']['finder_enable_custom_footer'] ) {
		$has_custom_footer = true;
	}
	return $has_custom_footer;
}

/**
 * Query Hivepress Extension Activation.
 *
 * @param  string $extension main extension class name.
 * @return boolean
 */
function finder_is_hivepress_extension_activated( $extension ) {
	if ( finder_is_hivepress_activated() ) {
		$is_activated = class_exists( $extension ) ? true : false;
	} else {
		$is_activated = false;
	}

	return $is_activated;
}

/**
 * Checks if HivePress Favorites is activated
 *
 * @return boolean
 */
function finder_is_hivepress_favorites_activated() {
	return finder_is_hivepress_extension_activated( 'HivePress\Blocks\Favorite_Toggle' );
}

/**
 * Checks if HivePress Reviews is activated
 *
 * @return boolean
 */
function finder_is_hivepress_reviews_activated() {
	return finder_is_hivepress_extension_activated( 'HivePress\Blocks\Reviews' );
}

/**
 * Checks if HivePress Reviews is activated
 *
 * @return boolean
 */
function finder_is_hivepress_messages_activated() {
	return finder_is_hivepress_extension_activated( 'HivePress\Blocks\Messages' );
}

/**
 * Checks if HivePress Claim Listings is activated
 *
 * @return boolean
 */
function finder_is_hivepress_claim_listings_activated() {
	return finder_is_hivepress_extension_activated( 'HivePress\Blocks\Listing_Claim_Submit_Form' );
}

/**
 * Checks if HivePress Geolocation is activated
 *
 * @return boolean
 */
function finder_is_hivepress_geolocation_activated() {
	return finder_is_hivepress_extension_activated( 'HivePress\Blocks\Listing_Map' );
}

/**
 * Check if a page has custom header
 *
 * @param array $options Page meta options.
 */
function finder_has_custom_header( $options ) {

	$has_custom_header = false;

	if ( isset( $options['header'] ) && isset( $options['header']['finder_enable_custom_header'] ) && 'yes' === $options['header']['finder_enable_custom_header'] ) {
		$has_custom_header = true;
	}
	return $has_custom_header;
}

/**
 * Check Header Sticky Enable or Disable.
 *
 * @return bool
 */
function finder_is_sticky_header() {

	$is_custom_header = finder_header_acf_is_custom_header();
	$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}

		if ( finder_has_custom_header( $fn_page_options ) ) {
			$sticky_header = isset( $fn_page_options['header']['finder_enable_sticky_header'] ) ? $fn_page_options['header']['finder_enable_sticky_header'] : '';

		} elseif ( $is_custom_header ) {
			$sticky_header = finder_get_field( 'is_sticky_header' );
		} else{
			$sticky_header    = get_theme_mod( 'finder_header_sticky', 'no' );
		}

	return apply_filters( 'finder_is_sticky_header', filter_var( $sticky_header, FILTER_VALIDATE_BOOLEAN ) );
}

/**
 * Check Header Signin Enable or Disable.
 *
 * @return bool
 */
function finder_header_enable_signin() {

	$is_custom_header = finder_header_acf_is_custom_header();
	$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}

		if ( finder_has_custom_header( $fn_page_options ) ) {
			$enable_signin = isset( $fn_page_options['header']['finder_enable_signin_button'] ) ? $fn_page_options['header']['finder_enable_signin_button'] : '';
		} elseif ( $is_custom_header ) {
			$enable_signin = finder_get_field( 'header_enable_signin_button' );
		} else {
			$enable_signin = get_theme_mod( 'enable_signin_button', 'yes' );
		}

	return apply_filters( 'finder_header_signin', filter_var( $enable_signin, FILTER_VALIDATE_BOOLEAN ) );
}

/**
 * Check Header Navbar Dark Enable or Disable.
 *
 * @return bool
 */
function finder_is_header_navbar_dark() {

	$is_custom_header = finder_header_acf_is_custom_header();
	$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}

		if ( finder_has_custom_header( $fn_page_options ) ) {
			$header_navbar_dark = isset( $fn_page_options['header']['finder_enable_navbar_dark'] ) ? $fn_page_options['header']['finder_enable_navbar_dark'] : '';
		} elseif ( $is_custom_header ) {
			$header_navbar_dark = finder_get_field( 'is_header_navbar_dark' );
		} else {
			$header_navbar_dark = get_theme_mod( 'finder_header_navbar_dark', 'no' );
		}

	return apply_filters( 'finder_is_header_navbar_dark', filter_var( $header_navbar_dark, FILTER_VALIDATE_BOOLEAN ) );
}


/**
 * Check Header Navbar Transparent Enable or Disable.
 *
 * @return bool
 */
function finder_is_header_transparent_navbar() {

	$is_custom_header = finder_header_acf_is_custom_header();
	$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}

		if ( finder_has_custom_header( $fn_page_options ) ) {
			$header_navbar_transparent = isset( $fn_page_options['header']['finder_enable_navbar_transparent'] ) ? $fn_page_options['header']['finder_enable_navbar_transparent'] : '';
		} elseif ( $is_custom_header ) {
			$header_navbar_transparent = finder_get_field( 'is_header_navbar_transparent' );
		} else {
			$header_navbar_transparent = get_theme_mod( 'finder_header_transparent_navbar', 'no' );
		}

	return apply_filters( 'finder_header_transparent_navbar', filter_var( $header_navbar_transparent, FILTER_VALIDATE_BOOLEAN ) );
}

/**
 * Check Header Buy Finder Button Enable or Disable.
 *
 * @return bool
 */
function finder_header_buy_finder_button() {

	$is_custom_header = finder_header_acf_is_custom_header();
	$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}

		if ( finder_has_custom_header( $fn_page_options ) ) {
			$buy_finder_button = isset( $fn_page_options['header']['finder_enable_buy_finder_button'] ) ? $fn_page_options['header']['finder_enable_buy_finder_button'] : '';

		} elseif ( $is_custom_header ) {
			$buy_finder_button = finder_get_field( 'header_enable_buy_finder_button' );
		} else{
			$buy_finder_button = get_theme_mod( 'enable_primary_nav_button', 'no' );
		}

	return apply_filters( 'finder_buy_finder_button', filter_var( $buy_finder_button, FILTER_VALIDATE_BOOLEAN ) );
}

/**
 * Check Header Add Properties Button Enable or Disable.
 *
 * @return bool
 */
function finder_header_add_properties_button() {

	$is_custom_header = finder_header_acf_is_custom_header();
	$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}

		if ( finder_has_custom_header( $fn_page_options ) ) {
			$add_listing_button = isset( $fn_page_options['header']['finder_enable_add_listing_button'] ) ? $fn_page_options['header']['finder_enable_add_listing_button'] : '';
		
		} elseif ( $is_custom_header ) {
			$add_listing_button = finder_get_field( 'header_enable_add_listing_button' );
		} else {
			$add_listing_button = get_theme_mod( 'enable_add_listing_button', 'yes' );

		}

	return apply_filters( 'finder_add_listing_button', filter_var( $add_listing_button, FILTER_VALIDATE_BOOLEAN ) );
}

/**
 * Check Header Post Resume Button Enable or Disable.
 *
 * @return bool
 */
function finder_header_enable_post_resume_button() {

	$is_custom_header = finder_header_acf_is_custom_header();
	$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}

		if ( finder_has_custom_header( $fn_page_options ) ) {
			$post_resume_button = isset( $fn_page_options['header']['finder_enable_post_resume_button'] ) ? $fn_page_options['header']['finder_enable_post_resume_button'] : '';
		} elseif ( $is_custom_header ) {
			$post_resume_button = finder_get_field( 'header_enable_post_resume_button' );
		} else{
			$post_resume_button = get_theme_mod( 'enable_post_resume_button', 'no' );

		}

	return apply_filters( 'finder_post_resume_button', filter_var( $post_resume_button, FILTER_VALIDATE_BOOLEAN ) );
}

/**
 * Check Header Employers Button Enable or Disable.
 *
 * @return bool
 */
function finder_header_employers_button() {

	$is_custom_header = finder_header_acf_is_custom_header();
	$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}

		if ( finder_has_custom_header( $fn_page_options ) ) {
			$employers_button = isset( $fn_page_options['header']['finder_enable_employers_button'] ) ? $fn_page_options['header']['finder_enable_employers_button'] : '';
		} elseif ( $is_custom_header ) {
			$employers_button = finder_get_field( 'header_enable_employers_button' );
		} else {
			$employers_button = get_theme_mod( 'enable_employers_link_button', 'no' );
		}

	return apply_filters( 'finder_employers_link_button', filter_var( $employers_button, FILTER_VALIDATE_BOOLEAN ) );
}

/**
 * Checks if WP Job Mananger activated.
 *
 * @return bool
 */
function finder_is_wp_job_manager_activated() {
	return class_exists( 'WP_Job_Manager' ) ? true : false;
}

/**
 * Checks if ACF activated.
 *
 * @return bool
 */
function finder_is_acf_activated() {
	return function_exists( 'get_field' ) ? true : false;
}

/**
 * Check Dark Enable or Disable.
 *
 * @return bool
 */
function finder_is_dark_background() {
	$is_dark = false;
	if ( 'car-finder' === finder_get_blog_style() && ( is_post_type_archive( 'posts' ) || is_tag() || is_category() )  ) {
		$is_dark = true;
	}
	return apply_filters( 'finder_is_dark_background', $is_dark );
}
/**
 * Check if One Click Demo Import is activated
 *
 * @return bool
 */
function finder_is_ocdi_activated() {
	return class_exists( 'OCDI_Plugin' ) ? true : false;
}

/**
 * Should add .container to .site-content element.
 */
function finder_contain_site_content() {
	return apply_filters( 'finder_contain_site_content', true );
}
