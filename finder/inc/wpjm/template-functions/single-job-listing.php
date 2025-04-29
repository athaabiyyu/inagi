<?php
/**
 * Finder WPJM Single Job Listings Template Functions
 *
 * @package Finder
 */

if ( ! function_exists( 'finder_wpjm_job_listing_content_section_start' ) ) {
	/**
	 * Function to display single job listing starting header
	 */
	function finder_wpjm_job_listing_content_section_start() { ?>
		<section class="position-relative bg-white rounded-xxl-4 zindex-5" style="margin-top: -30px;">
			<div class="container pt-4 pb-5 mb-md-4">
				<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_content_section_end' ) ) {
	/**
	 * Function to display single job listing starting header
	 */
	function finder_wpjm_job_listing_content_section_end() {
		?>
			</div>
		</section>
		<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_content_row_start' ) ) {
	/**
	 * Function to display single job listing starting header
	 */
	function finder_wpjm_job_listing_content_row_start() {
		?>
		<div class="row">
			<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_content_row_end' ) ) {
	/**
	 * Function to display single job listing starting header
	 */
	function finder_wpjm_job_listing_content_row_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_single_job_content_start' ) ) {
	/**
	 * Function to display single job listing starting header
	 */
	function finder_wpjm_job_listing_single_job_content_start() {

		$layout = get_theme_mod( 'finder_jobmanager_single_layout', 'right-sidebar' );
		if ( 'full-width' === $layout ) {
			$column_classes = 'col-12';
		} else {
			$column_classes = ( is_active_sidebar( 'job-single-sidebar' ) ) ? ' col-lg-7' : ' col-lg-9 mx-auto';
		}
		?>
		<div class="<?php echo esc_attr( $column_classes ); ?> position-relative pe-lg-5 mb-5 mb-lg-0">
			<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_single_job_content_end' ) ) {
	/**
	 * Function to display single job listing starting header
	 */
	function finder_wpjm_job_listing_single_job_content_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_single_job_sidebar' ) ) {
	/**
	 * Function to display single job listing starting header
	 */
	function finder_wpjm_job_listing_single_job_sidebar() {
		$layout = get_theme_mod( 'finder_jobmanager_single_layout', 'right-sidebar' );
		if ( 'full-width' === $layout ) {
			return;
		}
		?>
		<?php if ( is_active_sidebar( 'job-single-sidebar' ) ) : ?>
			<aside class="col-lg-5" style="margin-top: -6rem;">
				<div class="sticky-top" style="padding-top: 6rem;">
					<div class="card shadow-sm p-lg-3 mb-3 mb-lg-0">
						<div class="card-body p-lg-4">
						<?php dynamic_sidebar( 'job-single-sidebar' ); ?>
						</div>
					</div>
				</div>
			</aside>
		<?php endif; ?>
		<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_breadcrumb' ) ) {
	/**
	 * Function to display single job listing breadcrumb
	 */
	function finder_wpjm_job_listing_breadcrumb() {

		$args = array(
			'nav_class' => 'pb-4 my-2',
		);

		finder_breadcrumb( $args );

	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_header' ) ) {
	/**
	 * Function to display single job listing starting header
	 */
	function finder_wpjm_job_listing_header() {
		?>
		<div class="d-flex justify-content-between mb-2">
			<?php finder_wpjm_job_listing_title(); ?>
			<?php finder_wpjm_job_listing_post_date(); ?>
		</div>
			<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_title' ) ) {
	/**
	 * Function to display single job listing title
	 */
	function finder_wpjm_job_listing_title() {
		?>

		<h2 class="h3 mb-0">
			<?php wpjm_the_job_title(); ?>
		</h2>
		<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_post_date' ) ) {
	/**
	 * Function to display single job listing post date
	 */
	function finder_wpjm_job_listing_post_date() {
		?>

		<div class="text-end">
		<?php if ( is_position_featured() ) : ?>
			<span class="badge bg-faded-accent rounded-pill fs-sm mb-2"><?php echo esc_html__( 'Featured', 'finder' ); ?></span>
		<?php endif; ?>
			<div class="fs-sm text-muted"><?php the_job_publish_date(); ?></div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_meta' ) ) {
	/**
	 * Function to display single job listing location and type
	 */
	function finder_wpjm_job_listing_meta() {
		global $post;
		$job_salary = get_the_job_salary( $post );
		$job_salary_currency = get_the_job_salary_currency( $post );
		?>
		<ul class="list-unstyled fs-sm mb-4">
		<?php if ( is_position_filled() ) : ?>
			<li class="position-filled text-primary mb-2"><i class="fi-alert-circle alert-primary me-1"></i><?php esc_html_e( 'This position has been filled', 'finder' ); ?></li>
		<?php elseif ( ! candidates_can_apply() && 'preview' !== $post->post_status ) : ?>
			<li class="listing-expired mb-2"><i class="fi-x-circle alert-danger me-1"></i><?php esc_html_e( 'Applications have closed', 'finder' ); ?></li>
		<?php endif; ?>
			<?php
			if ( ! empty( get_the_company_name() ) ) :
				?>
				<li class="d-flex align-items-center mb-2">
					<a class="text-decoration-none" href="<?php the_job_permalink(); ?>">
						<i class="fi-external-link me-2"></i>
						<span class="text-decoration-underline"><?php the_company_name(); ?></span>
					</a>
					<?php if ( ! empty( get_the_company_tagline() ) ) : ?>
						<span class="text-decoration-none ms-2"><?php the_company_tagline( '(', ')' ); ?></span>
					<?php endif; ?>
				</li>
			<?php endif; ?>
			<?php if ( finder_wpjm_enable_job_types() ) { ?>
				<?php $types = wpjm_get_the_job_types(); ?>
				<?php
				if ( ! empty( $types ) ) :
					foreach ( $types as $type ) :
						?>
					<li class="d-flex align-items-center mb-2 job-type <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>"><i class="fi-clock text-muted me-2"></i><span class="me-2"><?php echo esc_html( $type->name ); ?></span></li>
						<?php
					endforeach;
				endif;
				?>
			<?php } ?>
			<li class="d-flex align-items-center mb-2"><i class="fi-map-pin text-muted me-2"></i><span><?php the_job_location(); ?></span></li>	
			<?php if( ! empty( $job_salary ) ) : ?>
			<li class="d-flex align-items-center mb-2"><i class="fi-cash fs-base text-muted me-2"></i><span><?php echo esc_attr( $job_salary_currency .  $job_salary ); ?></span></li>
				<?php
			endif;
			$website = get_the_company_website();
			?>
			<?php if ( $website ) : ?>
				<li class="d-flex align-items-center mb-2"><i class="fi-globe text-muted me-2"></i>
					<span><a class="website" href="<?php echo esc_url( $website ); ?>" rel="nofollow"><?php esc_html_e( 'Website', 'finder' ); ?></a></span>
				</li>
			<?php endif; ?>
			<?php if ( get_the_company_twitter() ) : ?>
				<li class="d-flex align-items-center mb-2"><i class="fi-twitter text-muted me-2"></i><span><?php the_company_twitter(); ?></span></li>
			<?php endif; ?>			
		</ul>
		<?php the_company_video(); ?>
		<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_description' ) ) {
	/**
	 * Function to display single job listing description
	 */
	function finder_wpjm_job_listing_description() {
		the_content();
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_apply_job' ) ) {
	/**
	 * Function to display single job listing description
	 */
	function finder_wpjm_job_listing_apply_job() {
		$apply = get_the_job_application_method();
		if ( $apply ) :
			wp_enqueue_script( 'wp-job-manager-job-application' );
			?>
			<div class="job_application application">
				<?php do_action( 'job_application_start', $apply ); ?>
				<div class="collapse" id="job_application_apply">
					<?php
						/**
						 * Job_manager_application_details_email or job_manager_application_details_url hook
						 */
						do_action( 'job_manager_application_details_' . $apply->type, $apply );
					?>
				</div>
				<div class="py-4"><hr></div>
				<div class="btn-group btn-group-lg">
					<button class="btn btn-primary rounded-pill ps-4 pe-3 application_button" type="button" data-bs-toggle="collapse" data-bs-target="#job_application_apply" aria-expanded="false" aria-controls="job_application_apply"><?php esc_html_e( 'Apply for this position', 'finder' ); ?></button>
				</div>
				<?php do_action( 'job_application_end', $apply ); ?>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_related_job_section_start' ) ) {
	/**
	 * Function to display single job listing starting header
	 */
	function finder_wpjm_job_listing_related_job_section_start() {
		?>
		<section class="container pt-md-2 pb-5 mb-md-4">
		<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_related_job_section_end' ) ) {
	/**
	 * Function to display single job listing starting header
	 */
	function finder_wpjm_job_listing_related_job_section_end() {
		?>
		</section>
		<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_related_job_header' ) ) {
	/**
	 * Function to display single job listing starting header
	 */
	function finder_wpjm_job_listing_related_job_header() {
		?>
		<div class="d-sm-flex align-items-center justify-content-between pb-4 mb-sm-2">
				<?php
				if ( ! finder_job_related_post_enabled() ) {
					return;
				}
				$related_job_text     = get_theme_mod( 'job_related_single_job_title_text', esc_html__( 'You may be interested in', 'finder' ) );
				$related_job_text_acf = finder_acf_job_single_related_title_text();

				if ( finder_is_acf_activated() ) {
					$related_job_text = $related_job_text_acf;
				}

				$related_job_action_text     = get_theme_mod( 'job_related_single_job_link_text', esc_html__( 'View all', 'finder' ) );
				$related_job_action_text_acf = finder_acf_job_single_related_action_text();

				if ( finder_is_acf_activated() ) {
					$related_job_action_text = $related_job_action_text_acf;
				}

				$related_job_action_text_url     = get_theme_mod( 'job_related_single_job_link_text_url' );
				$related_job_action_text_url_acf = finder_acf_job_single_related_action_text_url();

				if ( finder_is_acf_activated() ) {
					$related_job_action_text_url = $related_job_action_text_url_acf;
				}

				?>
				<h2 class="h3 mb-sm-0"><?php echo esc_html( $related_job_text ); ?></h2>
				<a class="btn btn-link fw-normal p-0" href="<?php echo esc_url( $related_job_action_text_url ); ?>">
				<?php echo esc_html( $related_job_action_text ); ?><i class="fi-arrow-long-right ms-2"></i>
				</a>
			</div>
			<?php
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_single_related_job' ) ) {
	/**
	 * Job listing single related job.
	 */
	function finder_wpjm_job_listing_single_related_job() {

		if ( ! finder_job_related_post_enabled() ) {
			return;
		}

		$related_post_per_page     = get_theme_mod( 'finder_job_related_posts_per_page_options', esc_html__( '4', 'finder' ) );
		$related_post_acf_per_page = finder_acf_job_single_related_per_page();

		if ( finder_is_acf_activated() ) {
			$related_post_per_page = $related_post_acf_per_page;
		}
		if ( finder_wpjm_enable_category() ) {
			$categories = get_the_terms( get_the_ID(), 'job_listing_category' );
			if ( $categories ) {
				foreach ( $categories as $category ) {
					$category_ids[] = $category->term_id;

				}
			}
		}

		$job_typo = get_the_terms( get_the_ID(), 'job_listing_type' );
		$job_tipe_ids = array();
		if ( $job_typo ) {
			foreach ( $job_typo as $job_tipe ) {
				$job_tipe_ids[] = $job_tipe->term_id;

			}
		}
		if ( ! empty( $category ) ) {
			$args = array(
				'post_type'      => array(
					'job_listing',
				),
				'post_status'    => 'publish',
				'posts_per_page' => $related_post_per_page,  // Get all posts.
				'post__not_in'   => array( get_the_ID() ),  // Hide current post in list of related content.
				'tax_query'      => array(// phpcs:ignore WordPress.DB.DirectDatabaseQuery.: slow query ok.
					array(
						'taxonomy' => 'job_listing_category',
						'field'    => 'term_id',
						'terms'    => $category_ids,
					),
				),
			);
		} else {
			$args = array(
				'post_type'      => array(
					'job_listing',
				),
				'post_status'    => 'publish',
				'posts_per_page' => $related_post_per_page,  // Get all posts.
				'post__not_in'   => array( get_the_ID() ),  // Hide current post in list of related content.
				'tax_query'      => array(// phpcs:ignore WordPress.DB.DirectDatabaseQuery.: slow query ok.
					array(
						'taxonomy' => 'job_listing_type',
						'field'    => 'term_id',
						'terms'    => $job_tipe_ids,
					),

				),
			);

		}

		$carousel_args = apply_filters(
			'finder_related_job_carousel_args',
			array(
				'responsive' => array(
					'0'   => array(
						'items'  => 1,
						'gutter' => 16,
					),
					'600' => array(
						'items'  => 2,
						'gutter' => 16,
					),
					'768' => array(
						'items'  => 2,
						'gutter' => 24,
					),
					'992' => array(
						'items'  => 3,
						'gutter' => 24,
					),

				),
			)
		);

		$related_articles_query = new WP_Query( $args );

		if ( $related_articles_query->have_posts() ) :
			?>
			<div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush">
				<div class="tns-carousel-inner" data-carousel-options="<?php echo esc_attr( wp_json_encode( $carousel_args ) ); ?>">
					<?php
					while ( $related_articles_query->have_posts() ) :
						$related_articles_query->the_post();
						$job_link = ! empty( get_the_company_logo() ) ? ( get_the_company_logo() ) : ( apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ) );
						?>
					<div class="pb-4">
						<div class="card bg-secondary card-hover h-100">
							<div class="card-body pb-3">
								<div class="d-flex align-items-center mb-2">
									<img class="me-2" src="<?php echo esc_url( $job_link ); ?>" width="24" alt="<?php echo esc_attr__( 'Zapier Logo', 'finder' ); ?>">
									<span class="fs-sm text-dark opacity-80 px-1"><?php the_company_name(); ?></span>
								</div>
								<h3 class="h6 card-title pt-1 mb-2">
									<a class="text-nav stretched-link text-decoration-none" href="<?php the_job_permalink(); ?>"><?php wpjm_the_job_title(); ?></a>
								</h3>
								<?php if ( has_excerpt() ) : ?>
									<p class="fs-sm mb-0"><?php echo esc_html( get_the_excerpt() ); ?></p>
								<?php endif; ?>
							</div>
							<div class="card-footer d-flex align-items-center justify-content-between border-0 pt-0">
								<div class="fs-sm">
									<span class="text-nowrap me-3"><i class="fi-map-pin text-muted me-1"></i><?php the_job_location( false ); ?></span>
									<?php
									do_action( 'job_listing_meta_start' );

									if ( finder_wpjm_enable_job_types() ) {

										$job_types = wpjm_get_the_job_types();
										if ( ! empty( $job_types ) ) :
											foreach ( $job_types as $job_type ) :
												?>
												<span class="job-type text-nowrap me-3 <?php echo esc_attr( sanitize_title( $job_type->slug ) ); ?>">
													<?php echo esc_html( $job_type->name ); ?>
												</span>
												<?php
											endforeach;
										endif;
									}

									do_action( 'job_listing_meta_end' );
									?>
									<span class="text-nowrap me-3">
										<?php if( ! empty( $job_salary ) ) : ?>
											<i class="fi-cash fs-base text-muted me-2"></i><?php echo esc_attr( $job_salary_currency .  $job_salary ); ?>
										<?php endif; ?>			
									</span>
									<span class="text-nowrap me-3">
										<?php wpjm_the_job_categories(); ?>
									</span>
								</div>
							</div>
						</div>
					</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'finder_wpjm_job_listing_single_job_page_header' ) ) {
	/**
	 * Jobmanager listing single job page header.
	 */
	function finder_wpjm_job_listing_single_job_page_header() {
		finder_job_header_search_form();
	}
}
