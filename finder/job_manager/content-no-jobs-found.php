<?php
/**
 * Notice when no jobs were found in `[jobs]` shortcode.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-no-jobs-found.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     finder
 * @since       1.0.0
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="container my-5">
	<div class="alert alert-info mb-0 p-4">
		<div class="fw-bold text-center">
			<i class="fi-alert-circle me-2 mt-0 fs-1"></i>
			<?php if ( defined( 'DOING_AJAX' ) ) : ?>
				<h4 class="mb-0 mt-2 text-info no_job_listings_found"><?php esc_html_e( 'There are no listings matching your search.', 'finder' ); ?></h4>
			<?php else : ?>
				<h4 class="mb-0 mt-2 text-info no_job_listings_found"><?php esc_html_e( 'There are currently no vacancies', 'finder' ); ?></h4>
			<?php endif; ?>
		</div>
	</div>
</div>
