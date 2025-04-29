<?php
/**
 * Finder HivePress Template Hooks
 *
 * @package Finder
 */

add_action( 'finder_hivepress_vendor_single', 'finder_hivepress_vendor_single_template', 10 );

// Real Estate Demo Vendor Single hooks.
add_action( 'finder_vendor_single_real_estate_before', 'finder_hivepress_vendor_single_container_wrap_start', 10 );
add_action( 'finder_vendor_single_real_estate_before', 'finder_hivepress_vendor_single_breadcrumb', 15 );
add_action( 'finder_vendor_single_real_estate_before', 'finder_hivepress_vendor_single_row_wrap_start', 20 );
add_action( 'finder_vendor_single_real_estate_before', 'finder_hivepress_vendor_single_sidebar_wrap_start', 25 );
add_action( 'finder_vendor_single_real_estate_before', 'finder_hivepress_vendor_single_sidebar', 30 );
add_action( 'finder_vendor_single_real_estate_before', 'finder_hivepress_vendor_single_sidebar_wrap_end', 35 );
add_action( 'finder_vendor_single_real_estate_before', 'finder_hivepress_vendor_single_loop_column_wrap_start', 40 );
add_action( 'finder_vendor_single_real_estate_before', 'finder_hivepress_vendor_single_page_header', 50 );

add_action( 'finder_vendor_single_real_estate', 'finder_hivepress_vendor_single_real_estate_loop', 10 );
add_action( 'finder_vendor_single_real_estate', 'finder_hivepress_vendor_single_pagination', 20 );

add_action( 'finder_vendor_single_real_estate_after', 'finder_hivepress_vendor_single_loop_column_wrap_end', 20 );
add_action( 'finder_vendor_single_real_estate_after', 'finder_hivepress_vendor_single_row_wrap_end', 30 );
add_action( 'finder_vendor_single_real_estate_after', 'finder_hivepress_vendor_single_container_wrap_end', 40 );


// Car Finder Demo Vendor Single hooks.
add_action( 'finder_vendor_single_car_finder_before', 'finder_hivepress_vendor_car_finder_container_wrap_start', 10 );
add_action( 'finder_vendor_single_car_finder_before', 'finder_hivepress_vendor_single_breadcrumb', 12 );
add_action( 'finder_vendor_single_car_finder_before', 'finder_hivepress_vendor_car_finder_row_wrap_start', 20 );
add_action( 'finder_vendor_single_car_finder_before', 'finder_hivepress_vendor_car_finder_sidebar', 30 );
add_action( 'finder_vendor_single_car_finder_before', 'finder_hivepress_vendor_car_finder_loop_column_wrap_start', 40 );

add_action( 'finder_vendor_single_car_finder', 'finder_hivepress_vendor_single_car_finder_page_header', 10 );
add_action( 'finder_vendor_single_car_finder', 'finder_hivepress_vendor_single_car_finder_loop', 15 );
add_action( 'finder_vendor_single_car_finder', 'finder_hivepress_vendor_single_pagination', 20 );

add_action( 'finder_vendor_single_car_finder_after', 'finder_hivepress_vendor_car_finder_loop_column_wrap_end', 20 );
add_action( 'finder_vendor_single_car_finder_after', 'finder_hivepress_vendor_car_finder_row_wrap_end', 30 );
add_action( 'finder_vendor_single_car_finder_after', 'finder_hivepress_vendor_single_related_post', 40 );
add_action( 'finder_vendor_single_car_finder_after', 'finder_hivepress_vendor_car_finder_container_wrap_end', 50 );

// City Guide Demo Vendor Single hooks.
add_action( 'finder_vendor_single_city_guide_before', 'finder_hivepress_vendor_city_guide_container_wrap_start', 10 );
add_action( 'finder_vendor_single_city_guide_before', 'finder_hivepress_vendor_single_breadcrumb', 12 );
add_action( 'finder_vendor_single_city_guide_before', 'finder_hivepress_vendor_single_city_guide_page_header', 15 );
add_action( 'finder_vendor_single_city_guide_before', 'finder_hivepress_vendor_city_guide_row_wrap_start', 20 );
add_action( 'finder_vendor_single_city_guide_before', 'finder_hivepress_vendor_single_city_guide_sidebar_wrap_start', 25 );
add_action( 'finder_vendor_single_city_guide_before', 'finder_hivepress_vendor_city_guide_sidebar', 30 );
add_action( 'finder_vendor_single_city_guide_before', 'finder_hivepress_vendor_single_city_guide_sidebar_wrap_end', 35 );
add_action( 'finder_vendor_single_city_guide_before', 'finder_hivepress_vendor_city_guide_loop_column_wrap_start', 40 );

add_action( 'finder_vendor_single_city_guide', 'finder_hivepress_vendor_single_city_guide_loop', 10 );
add_action( 'finder_vendor_single_city_guide', 'finder_hivepress_vendor_single_pagination', 20 );

add_action( 'finder_vendor_single_city_guide_after', 'finder_hivepress_vendor_city_guide_loop_column_wrap_end', 20 );
add_action( 'finder_vendor_single_city_guide_after', 'finder_hivepress_vendor_city_guide_row_wrap_end', 30 );
add_action( 'finder_vendor_single_city_guide_after', 'finder_hivepress_vendor_city_guide_container_wrap_end', 40 );
