<?php
/**
 * Finder WPJM Template Hooks
 *
 * @package Finder
 */

 // Single Job Listing hooks.
add_action( 'finder_wpjm_single_job_listing_content_before', 'finder_wpjm_job_listing_single_job_page_header', 10 );

add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_content_section_start', 10 );
add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_breadcrumb', 20 );
add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_content_row_start', 30 );
add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_single_job_content_start', 40 );
add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_header', 50 );
add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_meta', 60 );
add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_description', 70 );
add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_apply_job', 75 );
add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_single_job_content_end', 80 );
add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_single_job_sidebar', 90 );
add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_content_row_end', 100 );
add_action( 'finder_wpjm_single_job_listing_content', 'finder_wpjm_job_listing_content_section_end', 110 );

add_action( 'finder_wpjm_single_job_listing_content_after', 'finder_wpjm_job_listing_related_job_section_start', 10 );
add_action( 'finder_wpjm_single_job_listing_content_after', 'finder_wpjm_job_listing_related_job_header', 20 );
add_action( 'finder_wpjm_single_job_listing_content_after', 'finder_wpjm_job_listing_single_related_job', 30 );
add_action( 'finder_wpjm_single_job_listing_content_after', 'finder_wpjm_job_listing_related_job_section_end', 40 );


