<?php
/**
 * Apply by email content.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-application-email.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     wp-job-manager
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<p class="pt-2 mb-1">
	<?php
	printf(
		// translators: %s is the job title.
		esc_html__( 'Please, send your CV marked “%s” in the subject via e-mail:', 'finder' ),
		esc_html( wpjm_get_the_job_title() )
	);
	?>
</p>
<?php
printf(
	// translators: %1$s & %2$s is the subject query args.
	wp_kses_post( '<a class="job_application_email nav-link-muted fw-bold" href="mailto:%1$s%2$s">%1$s</a>' ),
	esc_html( $apply->email ),
	'?subject=' . rawurlencode( $apply->subject )
);
