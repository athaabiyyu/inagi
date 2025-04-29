<?php
/**
 * Single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-single-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     wp-job-manager
 * @since       1.0.0
 * @version     1.28.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

	$sticky_header   = finder_is_sticky_header();
	$container_class = 'container pt-5 pb-lg-4 mt-5 mb-sm-2';

if ( ! $sticky_header ) {
	$container_class = 'container mt-4 mb-md-4 pt-2';
}
if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) :
	?><div class="<?php echo esc_attr( $container_class ); ?>">
				<div class="row">
					<div class="job-manager-info">
						<div class="alert alert-info mb-0 p-4">
							<div class="fw-bold text-center">
								<i class="fi-alert-circle me-2 mt-0 fs-1"></i>
								<h4 class="mb-0 mt-2 text-info"><?php esc_html_e( 'This listing has expired.', 'finder' ); ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		else :
			/**
			 * Functions hooked in to finder_wpjm_single_job_listing_content_before action
			 *
			 * @hooked finder_wpjm_job_listing_single_job_page_header - 10
			 */
			do_action( 'finder_wpjm_single_job_listing_content_before' );

			/**
			 * Functions hooked in to finder_wpjm_single_job_listing_content action
			 *
			 * @hooked finder_wpjm_job_listing_content_section_start - 10
			 * @hooked finder_wpjm_job_listing_breadcrumb - 20
			 * @hooked finder_wpjm_job_listing_content_row_start - 30
			 * @hooked finder_wpjm_job_listing_single_job_content_start - 40
			 * @hooked finder_wpjm_job_listing_header - 50
			 * @hooked finder_wpjm_job_listing_meta - 60
			 * @hooked finder_wpjm_job_listing_description - 70
			 * @hooked finder_wpjm_job_listing_apply_job - 75
			 * @hooked finder_wpjm_job_listing_single_job_content_end - 80
			 * @hooked finder_wpjm_job_listing_single_job_sidebar - 90
			 * @hooked finder_wpjm_job_listing_content_row_end - 100
			 * @hooked finder_wpjm_job_listing_content_section_end - 110
			 */
			do_action( 'finder_wpjm_single_job_listing_content' );

			/**
			 * Functions hooked in to finder_wpjm_single_job_listing_content_after action
			 *
			 * @hooked finder_wpjm_job_listing_related_job_section_start - 10
			 * @hooked finder_wpjm_job_listing_related_job_header - 20
			 * @hooked finder_wpjm_job_listing_single_related_job - 30
			 * @hooked finder_wpjm_job_listing_related_job_section_end - 40
			 */
			do_action( 'finder_wpjm_single_job_listing_content_after' );

		endif;
