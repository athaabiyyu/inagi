<?php
/**
 * Finder WPJM Template Hooks
 *
 * @package Finder
 */

// Load all template hooks files separately.
require_once FINDER_THEME_DIR . 'inc/wpjm/template-hooks/single-job-listing.php';

// Job Listing Archive Search Form.
add_action( 'job_listing_before_loop_content', 'finder_job_header_search_form', 10 );
// Job Listing Archive Container Start.
add_action( 'job_listing_before_loop', 'finder_job_listing_loop_content_open', 10 );
// Job Listing Archive Loop Start.
add_action( 'job_listing_before_loop', 'finder_archive_listings_loop_column_start', 20 );
// Job listing loop sorting.
add_action( 'job_listing_before_loop', 'finder_archive_listing_loop_sorting_with_job_count', 30 );
// Job Listing Archive Loop Start.
add_action( 'job_listing_after_loop', 'finder_archive_listings_loop_column_end', 10 );
// Job Listing Archive Sidebar.
add_action( 'job_listing_after_loop', 'finder_job_archive_listings_sidebar', 20 );
// Job Listing Archive Loop post Pagination.
add_action( 'job_listing_after_loop', 'finder_job_archive_listings_loop_post_pagination', 5 );
// Job Listing Archive Container End.
add_action( 'job_listing_after_loop', 'finder_job_listing_loop_content_end', 30 );
