<?php
/**
 * Finder HivePress Listings Template Hooks
 *
 * @package Finder
 */

// Main Single Version Hook.
add_action( 'finder_hivepress_listing_single', 'finder_hivepress_listing_single_version', 10 );

// Real Estate Demo Listing Single hooks.
add_action( 'finder_hivepress_listing_single_real_estate_header', 'finder_hivepress_listing_single_breadcrumb', 10 );
add_action( 'finder_hivepress_listing_single_real_estate_header', 'finder_hivepress_listing_single_title', 20 );
add_action( 'finder_hivepress_listing_single_real_estate_header', 'finder_hivepress_listing_geo_location', 30 );
add_action( 'finder_hivepress_listing_single_real_estate_header', 'finder_hivepress_listing_single_real_estate_attributes_primary_top', 40 );

add_action( 'finder_hivepress_listing_single_real_estate_features', 'finder_hivepress_listing_single_real_estate_attributes_primary_bottom', 10 );
add_action( 'finder_hivepress_listing_single_real_estate_features', 'finder_hivepress_listing_single_features_wrap_start', 20 );
add_action( 'finder_hivepress_listing_single_real_estate_features', 'finder_hivepress_listing_single_add_to_wishlist', 30 );
add_action( 'finder_hivepress_listing_single_real_estate_features', 'finder_hivepress_listing_single_social_share', 40 );
add_action( 'finder_hivepress_listing_single_real_estate_features', 'finder_hivepress_listing_single_features_wrap_end', 50 );

add_action( 'finder_hivepress_listing_single_real_estate_gallery', 'finder_hivepress_listing_single_gallery', 10 );

add_action( 'finder_hivepress_listing_single_real_estate_body', 'finder_hivepress_listing_single_verified_badge', 10 );
add_action( 'finder_hivepress_listing_single_real_estate_body', 'finder_hivepress_listing_single_featured_badge', 20 );
add_action( 'finder_hivepress_listing_single_real_estate_body', 'finder_hivepress_listing_single_real_estate_attributes_secondary_top', 30 );
add_action( 'finder_hivepress_listing_single_real_estate_body', 'finder_hivepress_listing_single_real_estate_attributes_secondary_bottom', 40 );
add_action( 'finder_hivepress_listing_single_real_estate_body', 'finder_hivepress_listing_single_post_content', 50 );
add_action( 'finder_hivepress_listing_single_real_estate_body', 'finder_hivepress_listing_single_meta', 60 );
add_action( 'finder_hivepress_listing_single_real_estate_body', 'finder_hivepress_listing_single_review', 70 );




add_action( 'finder_hivepress_listing_single_real_estate_footer', 'finder_hivepress_listing_single_related_post', 10 );

remove_action( 'finder_hivepress_listing_single_real_estate_right_sidebar', 'finder_hivepress_listing_message_block', 20 );
remove_action( 'finder_hivepress_listing_single_real_estate_right_sidebar', 'finder_hivepress_listing_report_block', 30 );
remove_action( 'finder_hivepress_listing_single_real_estate_right_sidebar', 'finder_hivepress_claim_listing_block', 40 );



add_action( 'finder_hivepress_listing_single_real_estate_body', 'finder_hivepress_add_booking_buttons', 35 );



