<?php
/**
 * Job listing preview when submitting job listings.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-preview.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     finder
 * @version     1.32.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$sticky_header   = finder_is_sticky_header();
$container_class = 'container mt-4 mb-md-4';

if ( $sticky_header ) {
	$container_class = 'container mt-5 mb-md-4 py-5';
}
?>
<div class="<?php echo esc_attr( $container_class ); ?>">
	<form method="post" id="job_preview" action="<?php echo esc_url( $form->get_action() ); ?>">
		<?php
		/**
		 * Fires at the top of the preview job form.
		 *
		 * @since 1.32.2
		 */
		do_action( 'preview_job_form_start' );
		?>
		<div class="job_listing_preview_title d-flex justify-content-between">
			<h2><?php esc_html_e( 'Preview', 'finder' ); ?></h2>
			<div>
				<input type="submit" name="continue" id="job_preview_submit_button" class="button job-manager-button-submit-listing btn btn-primary me-2" value="<?php echo esc_attr( apply_filters( 'submit_job_step_preview_submit_text', __( 'Submit Job', 'finder' ) ) ); ?>" />
				<input type="submit" name="edit_job" class="button job-manager-button-edit-listing btn btn-primary" value="<?php esc_attr_e( 'Edit Job', 'finder' ); ?>" />
			</div>
		</div>
		<div class="job_listing_preview single_job_listing">
			<h1><?php wpjm_the_job_title(); ?></h1>

			<?php
			finder_breadcrumb();
			finder_wpjm_job_listing_header();
			finder_wpjm_job_listing_meta();
			finder_wpjm_job_listing_description();
			if ( get_the_company_logo() ){
				?><h6 class="mb-2"><?php esc_html_e( 'Company Logo', 'finder' ); ?></h6><?php
				the_company_logo();
			}
			?>

			<input type="hidden" name="job_id" value="<?php echo esc_attr( $form->get_job_id() ); ?>" />
			<input type="hidden" name="step" value="<?php echo esc_attr( $form->get_step() ); ?>" />
			<input type="hidden" name="job_manager_form" value="<?php echo esc_attr( $form->get_form_name() ); ?>" />
		</div>
		<?php
		/**
		 * Fires at the bottom of the preview job form.
		 *
		 * @since 1.32.2
		 */
		do_action( 'preview_job_form_end' );
		?>
	</form>
</div>
