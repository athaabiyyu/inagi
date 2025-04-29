<?php
/**
 * Job dashboard shortcode content.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-dashboard.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     finder
 * @version     1.35.0
 *
 * @since 1.34.4 Available job actions are passed in an array (`$job_actions`, keyed by job ID) and not generated in the template.
 * @since 1.35.0 Switched to new date functions.
 *
 * @var array     $job_dashboard_columns Array of the columns to show on the job dashboard page.
 * @var int       $max_num_pages         Maximum number of pages
 * @var WP_Post[] $jobs                  Array of job post results.
 * @var array     $job_actions           Array of actions available for each job.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $post;
$user = wp_get_current_user();

$breadcrumb_args = array(
	'style' => 'light',
);
$sticky_header   = finder_is_sticky_header();
$wrap_class      = 'mt-4 mb-md-4';

if ( $sticky_header ) {
	$wrap_class = 'mt-5 mb-md-4 py-5';
}
?>
<div class="position-absolute top-0 start-0 w-100 bg-dark" style="height: 398px;z-index: -1;"></div>
<div class="container content-overlay <?php echo esc_attr( $wrap_class ); ?>">
	<?php finder_breadcrumb( $breadcrumb_args ); ?>
	<div id="job-manager-job-dashboard">
		<div class="bg-light shadow-sm rounded-3 p-4 p-md-5 mb-2">
			<div class="d-flex align-items-start justify-content-between pb-4 mb-2">
				<div class="d-flex align-items-start">
					<div class="position-relative flex-shrink-0">
						<?php echo get_avatar( $user->ID, 100, '', $user->display_name, array( 'class' => 'rounded-circle' ) ); ?>
					</div>
					<div class="ps-3 ps-sm-4">
						<h3 class="h5"><?php echo esc_html( $user->display_name ); ?></h3>
						<ul class="list-unstyled fs-sm mb-0">
							<li class="d-flex text-nav text-break"><i class="fi-mail opacity-60 mt-1 me-2"></i><?php echo esc_html( $user->user_email ); ?></li>
						</ul>
					</div>
				</div>
				<a class="nav-link p-0 d-none d-md-block" href="<?php echo esc_url( apply_filters( 'submit_job_form_logout_url', wp_logout_url( get_permalink() ) ) ); ?>"><i class="fi-logout mt-n1 me-2"></i><?php esc_html_e( 'Sign out', 'finder' ); ?></a>
			</div>
			<div class="row g-2 g-md-4">
				<?php if ( ! $jobs ) : ?>
					<tr>
						<td colspan="<?php echo intval( count( $job_dashboard_columns ) ); ?>"><?php esc_html_e( 'You do not have any active listings.', 'finder' ); ?></td>
					</tr>
				<?php else : ?>
					<?php foreach ( $jobs as $key => $job ) : ?>
						<?php $job_link = ! empty( get_the_company_logo( $job ) ) ? ( get_the_company_logo( $job ) ) : ( apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ) ); ?>
						<div class="col-md-6 col-lg-4">
							<div class="card bg-secondary card-hover h-100">
								<div class="card-body mb-2">
									<?php foreach ( $job_dashboard_columns as $key => $column ) : ?>
										<?php if ( 'job_title' === $key ) : ?>
										<div class="d-flex align-items-center mb-3">
												<img class="me-2" src="<?php echo esc_url( $job_link ); ?>" width="24" alt="<?php echo esc_attr( get_the_company_name( $job ) ); ?>">
											<?php if ( get_the_company_name( $job ) ) : ?>
												<span class="fs-sm text-dark opacity-80 px-1"><?php echo esc_html( get_the_company_name( $job ) ); ?></span>
											<?php endif; ?>
											<?php if ( is_position_featured( $job ) ) : ?>
												<span class="badge bg-faded-accent rounded-pill fs-sm ms-auto"><?php echo esc_html__( 'Featured', 'finder' ); ?></span>
											<?php endif; ?>
										</div>
											<?php if ( 'publish' === $job->post_status ) : ?>
										<h3 class="h6 card-title mb-2"><a class="text-nav text-decoration-none" href="<?php echo esc_url( get_permalink( $job->ID ) ); ?>"><?php wpjm_the_job_title( $job ); ?></a></h3>
									<?php else : ?>
										<h3 class="h6 card-title mb-2"><?php wpjm_the_job_title( $job ); ?> <small>(<?php the_job_status( $job ); ?>)</small></h3>
									<?php endif; ?>		
								</div>
								<div class="card-footer d-flex align-items-center justify-content-between border-0 pt-0">
									<div class="fs-sm">
										<?php elseif ( 'date' === $key ) : ?>
											<span class="text-nowrap me-3"><?php echo esc_html( wp_date( get_option( 'date_format' ), get_post_datetime( $job )->getTimestamp() ) ); ?></span>
										<?php elseif ( 'expires' === $key ) : ?>
											<?php
											$job_expires = WP_Job_Manager_Post_Types::instance()->get_job_expiration( $job );
											?>
											<span class="text-nowrap me-3"><?php echo esc_html( $job_expires ? wp_date( get_option( 'date_format' ), $job_expires->getTimestamp() ) : 'No Expiry Date' ); ?> </span>
										<?php elseif ( 'filled' === $key ) : ?>
											<div class="mb-2">
											<?php echo is_position_filled( $job ) ? '<span class="badge bg-faded-success rounded-pill fs-sm ms-auto">Filled</span>' : '<span class="badge bg-faded-danger rounded-pill fs-sm ms-auto">Not filled</span>'; ?>
											</div>
										<?php endif; ?>
										<?php endforeach; ?>
									</div>
									<button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
									<ul class="dropdown-menu my-1" aria-labelledby="contextMenu1">
										<?php
										if ( ! empty( $job_actions[ $job->ID ] ) ) {
											foreach ( $job_actions[ $job->ID ] as $action_key => $value ) {
												$icons      = array(
													'Edit' => 'fi-edit',
													'Duplicate' => 'fi-folders',
													'Mark filled' => 'fi-check',
													'Mark not filled' => 'fi-x-square',
													'Delete' => 'fi-trash',
													'Continue Submission' => 'fi-send',
													'Relist' => 'fi-arrow-back-up',
												);
												$action_url = add_query_arg(
													array(
														'action' => $action_key,
														'job_id' => $job->ID,
													)
												);
												if ( $value['nonce'] ) {
													$action_url = wp_nonce_url( $action_url, $value['nonce'] );
												}
												echo '<li><button class="dropdown-item" type="button"><a href="' . esc_url( $action_url ) . '" class="job-dashboard-action-' . esc_attr( $action_key ) . '"><i class=" opacity-60 me-2 ' . esc_attr( $icons[ $value['label'] ] ) . '"></i>' . esc_html( $value['label'] ) . '</a></button></li>';

											}
										}
										?>
									</ul>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
