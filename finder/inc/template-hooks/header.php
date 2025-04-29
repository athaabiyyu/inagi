<?php
/**
 * Template hooks used in Header.
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Signin Hooks.
 */
add_action( 'wp_footer', 'finder_header_user_signin_form', 10 );
add_filter( 'wp_kses_allowed_html', 'finder_kses_allowed_html', 10, 2 );

/**
* Signup Hooks.
*/
add_action( 'wp_footer', 'finder_header_user_signup_form', 20 );

/**
* Forgot password Hooks.
*/
add_action( 'wp_footer', 'finder_header_forgot_password_form', 30 );

// Logo.
add_filter( 'get_custom_logo', 'finder_navbar_brand_classes', 10 );
// Offcanvas Icon.
add_action( 'finder_header', 'finder_offcanvas_button', 10 );
// Offcanvas Sidebar.
add_action( 'finder_header', 'finder_offcanvas_sidebar', 10 );
// Render attr For Header Class.
add_action( 'finder_header', 'finder_header_markup', 10 );
// Header Container Start.
add_action( 'finder_masthead', 'finder_header_container_wrap_start', 10 );
// Header Logo.
add_action( 'finder_masthead', 'finder_site_branding', 20 );
// Header Toggler.
add_action( 'finder_masthead', 'finder_navbar_toggler', 30 );
// Header My Account.
add_action( 'finder_masthead', 'finder_header_myaccount', 40 );
// Header Primary Button.
add_action( 'finder_masthead', 'finder_navbar_button', 50 );
// Header Add Listing.
add_action( 'finder_masthead', 'finder_header_add_listing', 60 );
// Header Post Resume Button.
add_action( 'finder_masthead', 'finder_header_post_resume_button', 70 );
// Header Primary Employer Button.
add_action( 'finder_masthead', 'finder_navbar_employer_button', 80 );
// Header Primary Menu.
add_action( 'finder_masthead', 'finder_navbar_nav_primary', 90 );
// Header Container End.
add_action( 'finder_masthead', 'finder_header_container_wrap_end', 100 );

// Header Speciality.
add_action( 'finder_header_404', 'finder_offcanvas_button', 20 );
add_action( 'finder_header_404', 'finder_offcanvas_sidebar', 30 );

