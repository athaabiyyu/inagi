<?php
/**
 * Filters in `[jobs]` shortcode.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-filters.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @package     wp-job-manager
 * @version     1.33.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$sticky_header   = finder_is_sticky_header();
$container_class = 'container py-5';
$bg_class        = 'rounded bg-dark pt-5';

if ( ! $sticky_header ) {
	$container_class = 'container pb-5 pt-4';
	$bg_class        = 'rounded bg-dark';
}

$has_categories_visible = $show_categories && ! is_tax( 'job_listing_category' ) && get_terms( array( 'taxonomy' => 'job_listing_category' ) );

wp_enqueue_script( 'wp-job-manager-ajax-filters' );

do_action( 'job_manager_job_filters_before', $atts );
?>

<div class="<?php echo esc_attr( $bg_class ); ?>">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<h1 class="text-light pt-1 pt-md-3 mb-4"><?php esc_html_e( 'Find jobs', 'finder' ); ?></h1>
		<form class="job_filters">
			<?php do_action( 'job_manager_job_filters_start', $atts ); ?>

			<div class="search_jobs form-group form-group-light d-block rounded-lg-pill mb-4">
				<div class="row align-items-center g-0 ms-n2">
					<?php do_action( 'job_manager_job_filters_search_jobs_start', $atts ); ?>

					<div class="search_keywords col-lg-5">
						<div class="input-group input-group-lg border-end-lg border-light">
							<span class="input-group-text text-light rounded-pill opacity-50 ps-3"><i class="fi-search"></i></span>
							<input type="text" name="search_keywords" id="search_keywords" class="form-control" placeholder="<?php esc_attr_e( 'Keywords', 'finder' ); ?>" value="<?php echo esc_attr( $keywords ); ?>" />
						</div>
					</div>

					<hr class="hr-light d-lg-none my-2">

					<div class="search_location col-lg-4">
						<div class="input-group input-group-lg">
							<span class="input-group-text text-light rounded-pill opacity-50 ps-3"><i class="fi-map-pin"></i></span>
							<input type="text" name="search_location" id="search_location" class="form-control" placeholder="<?php esc_attr_e( 'Location', 'finder' ); ?>" value="<?php echo esc_attr( $location ); ?>" />
						</div>
					</div>

					<?php
					/**
					 * Show the submit button on the job filters form.
					 *
					 * @since 1.33.0
					 *
					 * @param bool $show_submit_button Whether to show the button. Defaults to true.
					 * @return bool
					 */
					if ( apply_filters( 'job_manager_job_filters_show_submit_button', true ) ) :
						?>
						<div class="search_submit ms-auto col-lg-3 d-flex align-items-center">
							<input type="submit" class="btn btn-primary btn-lg w-50 w-lg-auto rounded-pill ms-auto" value="<?php esc_attr_e( 'Find jobs', 'finder' ); ?>">
						</div>
					<?php endif; ?>

					<?php do_action( 'job_manager_job_filters_search_jobs_end', $atts ); ?>
				</div>
			</div>

			<div class="row">
				
				<?php if ( $categories ) : ?>
					<?php foreach ( $categories as $category ) : ?>
						<input type="hidden" name="search_categories[]" value="<?php echo esc_attr( sanitize_title( $category ) ); ?>" />
					<?php endforeach; ?>
				<?php elseif ( $has_categories_visible ) : ?>
					<div class="search_categories col-md-6 mb-4 mb-md-0">
						<?php if ( $show_category_multiselect ) : ?>
							<?php
							job_manager_dropdown_categories(
								array(
									'taxonomy'     => 'job_listing_category',
									'hierarchical' => 1,
									'name'         => 'search_categories',
									'orderby'      => 'name',
									'selected'     => $selected_category,
									'hide_empty'   => true,
								)
							);
							?>
						<?php else : ?>
							<?php
							job_manager_dropdown_categories(
								array(
									'taxonomy'        => 'job_listing_category',
									'hierarchical'    => 1,
									'show_option_all' => __( 'Any category', 'finder' ),
									'name'            => 'search_categories',
									'orderby'         => 'name',
									'selected'        => $selected_category,
									'multiple'        => false,
									'hide_empty'      => true,
								)
							);
							?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php do_action( 'job_manager_job_filters_end', $atts ); ?>

			</div>
		</form>
	</div>
</div>

<?php do_action( 'job_manager_job_filters_after', $atts ); ?>

<noscript><?php esc_html_e( 'Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.', 'finder' ); ?></noscript>
