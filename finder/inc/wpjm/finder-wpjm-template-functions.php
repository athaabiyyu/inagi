<?php
/**
 * Finder WPJM Template Functions
 *
 * @package Finder
 */

// Load all template function files separately.
require_once FINDER_THEME_DIR . 'inc/wpjm/template-functions/single-job-listing.php';

if ( ! function_exists( 'finder_job_listing_loop_content_open' ) ) {
	/**
	 * Job Listing Loop Start.
	 */
	function finder_job_listing_loop_content_open() {
		?>
		<div class="position-relative bg-white rounded-xxl-4 zindex-5" style="margin-top: -30px;">
			<div class="container pt-4 pb-5 mb-md-4">
				<div class ="row">
			<?php
	}
}

if ( ! function_exists( 'finder_job_listing_loop_content_end' ) ) {
	/**
	 * Job Listing Loop End.
	 */
	function finder_job_listing_loop_content_end() {

		?>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_archive_listings_loop_column_start' ) ) {
	/**
	 * Archive listings Loop Start.
	 */
	function finder_archive_listings_loop_column_start() {

		$layout = finder_get_wpjm_job_listing_layout();

		if ( 'full-width' === $layout ) {
			$column_classes = 'col-12';
		} elseif ( 'left-sidebar' === $layout ) {
			$column_classes = 'col-lg-5 col-md-6 order-2';
		} else {
			$column_classes = ( is_active_sidebar( 'job-listing-sidebar' ) ) ? ' col-lg-5 col-md-6' : ' col-lg-7 col-md-10 mx-auto';
		}
		?>
			<!-- List of jobs-->
			<div class="<?php echo esc_attr( $column_classes ); ?> position-relative mb-4 mb-md-0" style="z-index: 1025;">
			<?php finder_breadcrumb(); ?>
			<?php
	}
}

if ( ! function_exists( 'finder_archive_post_jobs_count' ) ) {
	/**
	 * Display archive post jobs_count.
	 */
	function finder_archive_post_jobs_count() {
		$total_posts = wp_count_posts( 'job_listing' )->publish;

		if ( 0 === (int) $total_posts ) {
			echo esc_html__( '0 jobs', 'finder' );
		} else {
			echo esc_html(
				sprintf(
					/* translators: 1: number of jobs, 2: post title */
					esc_html( _nx( '%1$s job', '%1$s jobs', $total_posts, 'jobs title', 'finder' ) ),
					number_format_i18n( $total_posts )
				)
			);
		}
	}
}

if ( ! function_exists( 'finder_archive_listing_loop_sorting_with_job_count' ) ) {
	/**
	 * Archive listings Loop Sorting.
	 */
	function finder_archive_listing_loop_sorting_with_job_count() {

		if ( ! finder_wpjm_get_loop_prop( 'is_paginated' ) || 0 >= finder_wpjm_get_loop_prop( 'total', 0 ) ) {
			return;
		}

		$catalog_orderby_options = apply_filters(
			'finder_jobs_catalog_orderby',
			array(
				'featured'   => esc_html__( 'Featured', 'finder' ),
				'date'       => esc_html__( 'New Job', 'finder' ),
				'menu_order' => esc_html__( 'Menu Order', 'finder' ),
				'title-asc'  => esc_html__( 'Name: Ascending', 'finder' ),
				'title-desc' => esc_html__( 'Name: Descending', 'finder' ),
			)
		);

		$default_orderby = finder_wpjm_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'finder_job_listing_default_catalog_orderby', 'date' );
		$orderby         = isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.

		if ( finder_wpjm_get_loop_prop( 'is_search' ) ) {
			$catalog_orderby_options = array_merge( array( 'relevance' => esc_html__( 'Relevance', 'finder' ) ), $catalog_orderby_options );

			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
			$orderby = current( array_keys( $catalog_orderby_options ) );
		}

		$current_page_query_args = Finder_WPJM::get_current_page_query_args();

		?>
		<div class="d-sm-flex align-items-center justify-content-between pb-4 mb-sm-2">
			<form method="get">
				<div class="d-flex align-items-center">
					<label class="fs-sm me-2 pe-1 text-nowrap" for="sorting">
						<i class="fi-arrows-sort mt-n1 me-2"></i>
						<?php esc_html_e( 'Sort by:', 'finder' ); ?>
					</label>
					<select id="sorting" name="orderby" class="form-select form-select-sm" onchange="this.form.submit();">
						<?php foreach ( $catalog_orderby_options as $id => $catalog_orderby_option ) : ?>
							<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $catalog_orderby_option ); ?></option>
						<?php endforeach; ?>
					</select>
					<input type="hidden" name="paged" value="1" />
					<?php
					if ( is_array( $current_page_query_args ) && ! empty( $current_page_query_args ) ) :
						foreach ( $current_page_query_args as $key => $current_page_query_arg ) :
							if ( 'orderby' !== $key ) :
								?>
								<input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $current_page_query_arg ); ?>" >
								<?php
							endif;
						endforeach;
					endif;
					?>
				</div>
			</form>
			<div class="text-muted fs-sm text-nowrap">
				<i class="fi-briefcase fs-base mt-n1 me-2"></i>
				<?php finder_archive_post_jobs_count(); ?>
			</div>
		</div>
		<?php

	}
}

if ( ! function_exists( 'finder_archive_listings_loop_column_end' ) ) {
	/**
	 * Archive listings Loop End.
	 */
	function finder_archive_listings_loop_column_end() {

		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_job_archive_listings_sidebar' ) ) {
	/**
	 * Archive listings sidebar.
	 */
	function finder_job_archive_listings_sidebar() {

		$layout = finder_get_wpjm_job_listing_layout();

		if ( 'full-width' === $layout ) {
			return;
		}

		?>
		<?php if ( is_active_sidebar( 'job-listing-sidebar' ) ) : ?>
			<aside class="col-lg-7 col-md-6" style="margin-top: -6rem;">
				<div class="sticky-top" style="padding-top: 6rem;">
					<div class="card shadow-sm p-lg-3 mb-3 mb-lg-0">
						<div class="card-body p-lg-4">
						<?php dynamic_sidebar( 'job-listing-sidebar' ); ?>
						</div>
					</div>
				</div>
			</aside>
		<?php endif; ?>
		<?php
	}
}

if ( ! function_exists( 'finder_job_archive_listings_loop_post_pagination' ) ) {
	/**
	 * Display Job archive loop Post Pagination.
	 */
	function finder_job_archive_listings_loop_post_pagination() {
		global $wp_query;

		$total   = isset( $total ) ? $total : finder_wpjm_get_loop_prop( 'total_pages' );
		$current = isset( $current ) ? $current : finder_wpjm_get_loop_prop( 'current_page' );
		$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( '', get_pagenum_link( 999999999, false ) ) ) );
		$format  = isset( $format ) ? $format : '';
		if ( $total <= 1 ) {
			return;
		}

		$page_links = paginate_links(
			apply_filters(
				'finder_wpjm_pagination_args',
				array( // WPCS: XSS ok.
					'base'      => $base,
					'format'    => $format,
					'add_args'  => false,
					'type'      => 'array',
					'current'   => max( 1, $current ),
					'total'     => $total,
					'prev_text' => esc_html__( '&laquo; Prev', 'finder' ),
					'next_text' => esc_html__( 'Next &raquo;', 'finder' ),
					'mid_size'  => 1,
				)
			)
		);

		if ( is_array( $page_links ) && count( $page_links ) > 0 ) :
			?>
			<nav class="finder-wpjm-pagination pt-4 pb-2">
				<ul class="pagination mb-0">
				<?php
					$pagination = '';

				foreach ( $page_links as $page_link ) {
					$t          = 'page-link';
					$icon_right = '<i class="fi-chevron-right"></i>';
					$icon_left  = '<i class="fi-chevron-left"></i>';
					$prev_icon  = str_replace( '&laquo; Prev', $icon_left, $page_link );
					$next_icon  = str_replace( 'Next &raquo;', $icon_right, $prev_icon );

					$pagination .= '<li class="page-item d-sm-block' . ( strpos( $page_link, 'current' ) !== false ? ' active' : '' ) . '">' . str_replace( 'page-numbers', $t, $next_icon ) . '</li>';

				}

					echo wp_kses_post( $pagination );
				?>
				</ul>
			</nav>
			<?php
		endif;
	}
}

if ( ! function_exists( 'finder_job_header_search_form' ) ) {
	/**
	 * Display Job Header Search Form
	 */
	function finder_job_header_search_form() {
		$current_page_url        = ! empty( $current_page_url ) ? $current_page_url : Finder_WPJM::get_current_page_url();
		$current_page_query_args = Finder_WPJM::get_current_page_query_args();

		$job_listing_categories   = get_job_listing_categories();
		$selected_job_listing_cat = isset( $_GET['search_category'] ) ? filter_var( wp_unslash( $_GET['search_category'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ) : '';

		$is_category_enable = finder_wpjm_enable_category();
		$has_categories     = $is_category_enable && ! empty( $job_listing_categories );

		$job_listing_types         = get_job_listing_types();
		$selected_job_listing_type = isset( $_GET['search_type'] ) ? filter_var( wp_unslash( $_GET['search_type'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ) : '';

		$is_type_enable = finder_wpjm_enable_category();
		$has_types      = $is_type_enable && ! empty( $job_listing_types );

		$company_names         = finder_get_post_meta_values( '_company_name', 'job_listing' );
		$selected_company_name = isset( $_GET['company_name'] ) ? filter_var( wp_unslash( $_GET['company_name'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ) : '';

		$selected_posted_date = isset( $_GET['posted_before'] ) ? filter_var( wp_unslash( $_GET['posted_before'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ) : '';

		$days_ago = array( '5 days', '15 days', '1 week', '1 month' );

		$sticky_header   = finder_is_sticky_header();
		$container_class = 'container py-5';
		$bg_class        = 'bg-dark pt-5';

		if ( ! $sticky_header ) {
			$container_class = 'container pb-5 pt-4';
			$bg_class        = 'bg-dark';
		}

		?>
		<section class="<?php echo esc_attr( $bg_class ); ?>">
			<div class="<?php echo esc_attr( $container_class ); ?>">
				<h1 class="text-light pt-1 pt-md-3 mb-4"><?php esc_html_e( 'Find jobs', 'finder' ); ?></h1>
				<!-- Search form-->
				<form class="job_filters" action="<?php echo esc_attr( $current_page_url ); ?>">
					<input type="hidden" name="post_type" value="job_listing">
					<?php do_action( 'job_manager_job_header_search_block_start' ); ?>

					<div class="form-group form-group-light d-block rounded-lg-pill mb-4">
						<div class="row align-items-center g-0 ms-n2">

							<div class="col-lg-<?php echo esc_attr( $has_categories ? '4' : '5' ); ?>">
								<div class="input-group input-group-lg border-end-lg border-light">
									<span class="input-group-text text-light rounded-pill opacity-50 ps-3">
										<i class="fi-search"></i>
									</span>
									<input class="form-control" type="text" name="search_keywords" id="search_keywords"  placeholder="<?php esc_attr_e( 'Keyword or title...', 'finder' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
								</div>
							</div>
							<hr class="hr-light d-lg-none my-2">

							<div class="col-lg-<?php echo esc_attr( $has_categories ? '3' : '5' ); ?>">
								<div class="input-group input-group-lg<?php echo esc_attr( $has_categories ? ' border-end-lg border-light' : '' ); ?>">
									<span class="input-group-text text-light rounded-pill opacity-50 ps-3">
										<i class="fi-search"></i>
									</span>
									<input class="form-control" type="text" name="search_location" id="search_location"  placeholder="<?php esc_attr_e( 'City, state, or zip...', 'finder' ); ?>" value="<?php echo esc_attr( isset( $_GET['search_location'] ) ? filter_var( wp_unslash( $_GET['search_location'] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) ) : '' ); ?>">
								</div>
							</div>
							<hr class="hr-light d-lg-none my-2">

							<?php if ( $has_categories ) : ?>
								<div class="col-lg-3 d-sm-flex">
									<?php if ( get_option( 'job_manager_enable_categories' ) && ! empty( $job_listing_categories ) ) : ?>
										<div class="dropdown" data-bs-toggle="select">
											<button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="fi-list me-2"></i>
												<span class="dropdown-toggle-label">
													<?php
													if ( $selected_job_listing_cat ) {
														echo esc_html( $selected_job_listing_cat );
													} else {
														esc_html_e( 'Category', 'finder' );
													}
													?>
												</span>
											</button>
											<input name="search_category" type="hidden" value="<?php echo esc_attr( $selected_job_listing_cat ); ?>">
											<ul class="dropdown-menu dropdown-menu-dark my-3">
												<?php foreach ( $job_listing_categories as $cat ) : ?>
													<li><a class="dropdown-item" href="#"><span class="dropdown-item-label"><?php echo esc_html( $cat->name ); ?></span></a></li>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<hr class="hr-light d-lg-none my-2">

							<div class="ms-auto col-lg-2 d-flex align-items-center">
								<button class="btn btn-primary btn-lg w-50 w-lg-auto rounded-pill ms-auto" type="submit"><?php esc_html_e( 'Find jobs', 'finder' ); ?></button>
							</div>
						</div>
					</div>

					<div class="d-sm-flex justify-content-between pt-2 pb-1 pb-md-3 pb-lg-4">
						<div class="d-flex flex-column flex-sm-row flex-wrap">
							
							<div class="dropdown me-sm-3 mb-2 mb-sm-3" data-bs-toggle="select">
								<button class="btn btn-translucent-light btn-sm dropdown-toggle fs-base fw-normal w-100 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<span class="dropdown-toggle-label">
										<?php
										if ( $selected_posted_date ) {
											echo esc_html( $selected_posted_date );
										} else {
											esc_html_e( 'Publication date', 'finder' );
										}
										?>
									</span>
								</button>
								<input name="posted_before" type="hidden" value="<?php echo esc_attr( $selected_posted_date ); ?>">
								<ul class="dropdown-menu my-1">
									<?php foreach ( $days_ago as $day ) : ?>
										<li><a class="dropdown-item" href="#"><span class="dropdown-item-label"><?php echo esc_html( $day ); ?></span></a></li>
									<?php endforeach; ?>
								</ul>
							</div>

							<?php if ( $has_types ) : ?>
								<div class="dropdown me-sm-3 mb-2 mb-sm-3" data-bs-toggle="select">
									<button class="btn btn-translucent-light btn-sm dropdown-toggle fs-base fw-normal w-100 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<span class="dropdown-toggle-label">
											<?php
											if ( $selected_job_listing_type ) {
												echo esc_html( $selected_job_listing_type );
											} else {
												esc_html_e( 'Job type', 'finder' );
											}
											?>
										</span>
									</button>
									<input name="search_type" type="hidden" value="<?php echo esc_attr( $selected_job_listing_type ); ?>">
									<ul class="dropdown-menu my-1">
										<?php foreach ( $job_listing_types as $type ) : ?>
											<li><a class="dropdown-item" href="#"><span class="dropdown-item-label"><?php echo esc_html( $type->name ); ?></span></a></li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
							
							<?php if ( $company_names ) : ?>
							<div class="dropdown me-sm-3 mb-2 mb-sm-3" data-bs-toggle="select">
								<button class="btn btn-translucent-light btn-sm dropdown-toggle fs-base fw-normal w-100 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<span class="dropdown-toggle-label">
										<?php
										if ( $selected_company_name ) {
											echo esc_html( $selected_company_name );
										} else {
											esc_html_e( 'Company', 'finder' );
										}
										?>
									</span>
								</button>
								<input name="company_name" type="hidden" value="<?php echo esc_attr( $selected_company_name ); ?>">
								<ul class="dropdown-menu my-1">
									<?php foreach ( $company_names as $company_name ) : ?>
										<li><a class="dropdown-item" href="#"><span class="dropdown-item-label"><?php echo esc_html( $company_name ); ?></span></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<?php endif; ?>

						</div>
					</div>

					<?php do_action( 'job_manager_job_header_search_block_end' ); ?>

				</form>
			</div>
		</section>
		<?php
	}
}
