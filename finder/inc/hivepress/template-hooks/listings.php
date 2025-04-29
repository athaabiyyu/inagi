<?php
/**
 * Finder HivePress Listings Template Hooks
 *
 * @package Finder
 */

add_action( 'finder_hivepress_archive_listings', 'finder_hivepress_listings', 10 );

// Real Estate Demo Listings hooks.
add_action( 'finder_listings_real_estate_loop_before', 'finder_hivepress_listings_container_wrap_start', 10 );
add_action( 'finder_listings_real_estate_loop_before', 'finder_hivepress_listings_row_wrap_start', 20 );
add_action( 'finder_listings_real_estate_loop_before', 'finder_hivepress_listings_sidebar', 30 );
add_action( 'finder_listings_real_estate_loop_before', 'finder_hivepress_listings_loop_column_wrap_start', 40 );
add_action( 'finder_listings_real_estate_loop_before', 'finder_hivepress_listings_breadcrumb', 50 );
add_action( 'finder_listings_real_estate_loop_before', 'finder_hivepress_listings_page_header', 60 );
add_action( 'finder_listings_real_estate_loop_before', 'finder_hivepress_listings_top_control_bar', 70 );

add_action( 'finder_listings_real_estate_loop', 'finder_hivepress_listings_real_state_loop_content', 10 );

add_action( 'finder_listings_real_estate_loop_after', 'finder_hivepress_listings_pagination', 10 );
add_action( 'finder_listings_real_estate_loop_after', 'finder_hivepress_listings_loop_column_wrap_end', 20 );
add_action( 'finder_listings_real_estate_loop_after', 'finder_hivepress_listings_row_wrap_end', 30 );
add_action( 'finder_listings_real_estate_loop_after', 'finder_hivepress_listings_container_wrap_end', 40 );


// City Guide Demo Listings hooks.
add_action( 'finder_listings_city_guide_loop_before', 'finder_hivepress_listings_container_wrap_start', 10 );
add_action( 'finder_listings_city_guide_loop_before', 'finder_hivepress_listings_row_wrap_start', 20 );
add_action( 'finder_listings_city_guide_loop_before', 'finder_hivepress_listings_sidebar', 30 );
add_action( 'finder_listings_city_guide_loop_before', 'finder_hivepress_listings_loop_column_wrap_start', 40 );
add_action( 'finder_listings_city_guide_loop_before', 'finder_hivepress_listings_breadcrumb', 50 );
add_action( 'finder_listings_city_guide_loop_before', 'finder_hivepress_listings_page_header', 60 );
add_action( 'finder_listings_city_guide_loop_before', 'finder_hivepress_listings_top_control_bar', 70 );

add_action( 'finder_listings_city_guide_loop', 'finder_hivepress_listings_city_guide_loop_content', 10 );

add_action( 'finder_listings_city_guide_loop_after', 'finder_hivepress_listings_pagination', 10 );
add_action( 'finder_listings_city_guide_loop_after', 'finder_hivepress_listings_loop_column_wrap_end', 20 );
add_action( 'finder_listings_city_guide_loop_after', 'finder_hivepress_listings_row_wrap_end', 30 );
add_action( 'finder_listings_city_guide_loop_after', 'finder_hivepress_listings_container_wrap_end', 40 );


// Car Finder Demo Listings hooks.
add_action( 'finder_listings_car_finder_loop_before', 'finder_hivepress_listings_container_wrap_start', 10 );
add_action( 'finder_listings_car_finder_loop_before', 'finder_hivepress_listings_row_wrap_start', 20 );
add_action( 'finder_listings_car_finder_loop_before', 'finder_hivepress_listings_sidebar', 30 );
add_action( 'finder_listings_car_finder_loop_before', 'finder_hivepress_listings_loop_column_wrap_start', 40 );
add_action( 'finder_listings_car_finder_loop_before', 'finder_hivepress_listings_breadcrumb', 50 );
add_action( 'finder_listings_car_finder_loop_before', 'finder_hivepress_listings_page_header', 60 );
add_action( 'finder_listings_car_finder_loop_before', 'finder_hivepress_listings_top_control_bar', 70 );

add_action( 'finder_listings_car_finder_loop', 'finder_hivepress_listings_car_finder_loop_content', 10 );

add_action( 'finder_listings_car_finder_loop_after', 'finder_hivepress_listings_car_finder_bottom_control_bar', 10 );
add_action( 'finder_listings_car_finder_loop_after', 'finder_hivepress_listings_loop_column_wrap_end', 20 );
add_action( 'finder_listings_car_finder_loop_after', 'finder_hivepress_listings_row_wrap_end', 30 );
add_action( 'finder_listings_car_finder_loop_after', 'finder_hivepress_listings_container_wrap_end', 40 );

// Maptiler API.
add_filter( 'finder_listings_maptiler_api', 'finder_hivepress_get_maptiler_api', 10 );
