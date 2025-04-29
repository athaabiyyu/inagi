<?php
/**
 * Job Listing Archive Page.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     wp-job-manager
 * @since       1.0.0
 * @version     1.34.0
 */

$layout = finder_get_wpjm_job_listing_layout();

$template = apply_filters( 'finder_wpjm_job_listing_archive_template', 'default' );

get_header();

	do_action( 'job_listing_before_loop_content' );

if ( have_posts() ) {

	do_action( 'job_listing_before_loop' );

	get_job_manager_template( 'job-listings-start.php', array( 'layout' => $layout ) );

	do_action( 'job_listing_loop_start' );

	while ( have_posts() ) :

		the_post();

		do_action( 'job_listing_loop' );

		get_job_manager_template_part( 'content-job_listing', $template );

		endwhile; // End of the loop.

	do_action( 'job_listing_loop_end' );

	get_job_manager_template( 'job-listings-end.php', array( 'layout' => $layout ) );

	do_action( 'job_listing_after_loop' );

} else {
	do_action( 'job_manager_output_jobs_no_results' );
}

	do_action( 'job_listing_after_loop_content' );

get_footer();
