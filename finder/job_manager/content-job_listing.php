<?php
/**
 * Job listing in the loop.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     wp-job-manager
 * @since       1.0.0
 * @version     1.34.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $post;
$job_link = ! empty( get_the_company_logo() ) ? ( get_the_company_logo() ) : ( apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ) );
$job_salary = get_the_job_salary( $post );
$job_salary_currency = get_the_job_salary_currency( $post );
?>
<div class="card bg-secondary card-hover mb-2">
	<div class="card-body">
		<div class="d-flex justify-content-between align-items-start mb-2">
			<div class="d-flex align-items-center">
			<img class="me-2" src="<?php echo esc_url( $job_link ); ?>" width="24" alt="<?php echo esc_attr( get_the_company_name( $post ) ); ?>">
				<span class="fs-sm text-dark opacity-80 px-1"><?php the_company_name(); ?></span>
				<?php if ( is_position_featured() ) : ?>
					<span class="badge bg-faded-accent rounded-pill fs-sm ms-2"><?php echo esc_html__( 'Featured', 'finder' ); ?></span>
				<?php endif; ?>
			</div>
		</div>
		<h3 class="h6 card-title pt-1 mb-3">
			<a class="text-nav stretched-link text-decoration-none" href="<?php the_job_permalink(); ?>"><?php wpjm_the_job_title(); ?></a>
		</h3>
		<div class="fs-sm">
			<span class="text-nowrap me-3"><i class="fi-map-pin text-muted me-1"></i><?php the_job_location( false ); ?></span><?php
			if( ! empty( $job_salary ) ) {
				?><span class="text-nowrap me-3"><i class="fi-cash fs-base text-muted me-1"></i><?php echo esc_attr( $job_salary_currency .  $job_salary ); ?></span><?php
			}?>
		</div>
	</div>
</div>
