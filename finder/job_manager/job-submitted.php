<?php
/**
 * Notice when job has been submitted.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-submitted.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     finder
 * @version     1.34.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$sticky_header = finder_is_sticky_header();
$wrap_class    = 'mt-4 mb-md-4';

if ( $sticky_header ) {
	$wrap_class = 'mt-5 mb-md-4 py-5';
}

global $wp_post_types;

?><div class="container <?php echo esc_attr( $wrap_class ); ?>">
<?php
switch ( $job->post_status ) :
	case 'publish':
		echo '<div class="job-manager-message alert alert-success">' . wp_kses_post(
			sprintf(
				// translators: %1$s is the job listing post type name, %2$s is the job listing URL.
				__( '%1$s listed successfully. To view your listing <a href="%2$s">click here</a>.', 'finder' ),
				esc_html( $wp_post_types['job_listing']->labels->singular_name ),
				get_permalink( $job->ID )
			)
		) . '</div>';
		break;
	case 'pending':
		echo '<div class="job-manager-message alert alert-info">' . wp_kses_post(
			sprintf(
				// translators: Placeholder %s is the job listing post type name.
				esc_html__( '%s submitted successfully. Your listing will be visible once approved.', 'finder' ),
				esc_html( $wp_post_types['job_listing']->labels->singular_name )
			)
		) . '</div>';
		break;
	default:
		break;
	endswitch;
	do_action( 'job_manager_job_submitted_content_after', sanitize_title( $job->post_status ), $job );
?>
</div>
<?php
