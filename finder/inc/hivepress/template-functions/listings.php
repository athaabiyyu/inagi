<?php
/**
 * Finder HivePress Listings Template Functions
 *
 * @package Finder
 */

use HivePress\Blocks\Listings;

if ( ! function_exists( 'finder_hivepress_listings' ) ) {
	/**
	 * Display hivepress listings content.
	 */
	function finder_hivepress_listings() {

		$listing_style = finder_hivepress_get_listings_style();
		finder_get_template( 'hivepress/listings/listings-' . $listing_style . '.php' );
	}
}

if ( ! function_exists( 'finder_hivepress_listings_container_wrap_start' ) ) {
	/**
	 * Hivepress listings container wrap start.
	 */
	function finder_hivepress_listings_container_wrap_start() {

		$is_sticky_header = finder_is_sticky_header();
		$listing_style    = finder_hivepress_get_listings_style();

		$container_classes = 'container-fluid p-0';

		if ( $is_sticky_header ) {
			$container_classes .= ' mt-5 pt-5';
		} else {
			$container_classes .= ' pt-3';
		}

		if ( 'car-finder' === $listing_style ) {
			$container_classes = 'container py-5';

			if ( $is_sticky_header ) {
				$container_classes .= ' mt-5';
			}
		}

		?>
		<div class="<?php echo esc_attr( $container_classes ); ?>">
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listings_container_wrap_end' ) ) {
	/**
	 * Hivepress listings container wrap end.
	 */
	function finder_hivepress_listings_container_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listings_row_wrap_start' ) ) {
	/**
	 * Hivepress listings row wrap start.
	 */
	function finder_hivepress_listings_row_wrap_start() {

		$listing_style = finder_hivepress_get_listings_style();
		$row_classes   = 'row';

		if ( 'car-finder' === $listing_style ) {
			$row_classes .= ' mb-md-4 py-md-1';
		} else {
			$row_classes .= ' g-0 mt-n3';
		}

		?>
		<div class="<?php echo esc_attr( $row_classes ); ?>">	
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listings_row_wrap_end' ) ) {
	/**
	 * Hivepress listings row wrap end.
	 */
	function finder_hivepress_listings_row_wrap_end() {
		?>
		</div>	
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listings_sidebar' ) ) {
	/**
	 * Hivepress listings sidebar.
	 */
	function finder_hivepress_listings_sidebar() {

		$listing_layout = finder_hivepress_get_listings_layout();
		$listing_style  = finder_hivepress_get_listings_style();

		if ( 'full-width' === $listing_layout ) {
			return;
		}

		$column_classes    = 'col-lg-4 col-xl-3 border-top-lg border-end-lg shadow-sm px-3 px-xl-4 px-xxl-5 pt-lg-2';
		$offcanvas_classes = 'offcanvas offcanvas-start offcanvas-collapse';

		if ( 'car-finder' === $listing_style ) {
			$column_classes     = 'col-lg-3 pe-xl-4';
			$offcanvas_classes .= ' bg-dark';
		}

		if ( 'right-sidebar' === $listing_layout ) {
			$column_classes .= ' order-last';
		}

		$filters_text = esc_html__( 'Filters', 'finder' );

		$taxonomy = 'hp_listing_category';

		$listing_category_args = array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
			'orderby'    => 'slug',
		);

		$listing_categories = get_terms( $listing_category_args );

		$iterator = 1;

		?>
		<aside class="<?php echo esc_attr( $column_classes ); ?>">
			<div class="<?php echo esc_attr( $offcanvas_classes ); ?>" id="filters-sidebar">
				<?php if ( 'car-finder' === $listing_style ) : ?>
					<div class="offcanvas-header bg-transparent d-flex d-lg-none align-items-center">
						<h2 class="h5 text-light mb-0"><?php echo esc_html( $filters_text ); ?></h2>
						<button class="btn-close btn-close-white" type="button" data-bs-dismiss="offcanvas"></button>
					</div>
					<?php
					$categories_list = get_categories(array( 'taxonomy' => 'hp_listing_category' ));
					$category_class  = 'nav nav-tabs nav-tabs-light mb-0';
					?>
					<div class="offcanvas-header bg-transparent d-block border-bottom border-light pt-0 pt-lg-4 px-lg-0">
						<ul class="<?php echo esc_attr( $category_class )?>">
							<?php foreach( $categories_list as $index => $category ) :
								$car_cat_active      = is_tax( 'hp_listing_category', $category->term_id ) ? 'nav-link active' : 'nav-link';
								$icon_class = finder_acf_get_term_field( 'hp_listing_category_icon', $taxonomy, $category->term_id );?>
							<li class="nav-item mb-2"><a class="<?php echo esc_attr( $car_cat_active ); ?>" href="<?php echo esc_attr( esc_url( get_category_link( $category->term_id ) ) )?>"><?php if ( ! empty( $icon_class ) ) :?>
								<i class="<?php echo esc_attr( $icon_class );?> fs-base me-2"></i>
								<?php endif; ?><?php echo esc_html( $category->name );?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="offcanvas-body py-lg-4">
						<?php
							$liting_filter_args = array(
								'variant' => 'dark',
							);

							finder_get_template( 'hivepress/listings/listing-filters.php', $liting_filter_args );
							if ( is_active_sidebar( 'sidebar-hivepress-listing' ) ) {
								dynamic_sidebar( 'sidebar-hivepress-listing' );
							}
							?>
					</div>
				<?php else : ?>
					<div class="offcanvas-header d-flex d-lg-none align-items-center">
						<h2 class="h5 mb-0"><?php echo esc_html( $filters_text ); ?></h2>
						<button class="btn-close" type="button" data-bs-dismiss="offcanvas"></button>
					</div>
					<?php if ( 'city-guide' !== $listing_style ) : 
						?><?php do_action( 'finder_sidebar_category' ); ?>
					<?php endif; ?>
					<?php if ( 'city-guide' === $listing_style ) : ?>
						<div class="offcanvas-header d-block border-bottom pt-0 pt-lg-4 px-lg-0">
							<form class="form-group mb-lg-2 rounded-pill" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<div class="input-group">
									<span class="input-group-text text-muted"><i class="fi-search"></i></span>
									<input class="form-control" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search...', 'finder' ); ?>">
									<input type="hidden" class="form-control" name="post_type" value="hp_listing">
								</div>
								<button class="btn btn-primary rounded-pill d-lg-inline-block d-none" type="submit"><?php esc_html_e( 'Search', 'finder' ); ?></button>
								<button class="btn btn-icon btn-primary rounded-circle flex-shrink-0 d-lg-none d-inline-flex" type="submit"><i class="fi-search mt-n2"></i></button>
							</form>
						</div>
					<?php endif; ?>
					<?php if ( 'city-guide' === $listing_style && ! is_wp_error( $listing_categories ) && $listing_categories ) : ?>
						<?php
							$cat_nav_item_classes    = 'nav-link d-flex align-items-center';
							$filter_nav_item_classes = $cat_nav_item_classes;

						if ( isset( $_GET['filter_active'] ) && finder_clean( filter_var( wp_unslash( $_GET['filter_active'] ), FILTER_SANITIZE_NUMBER_INT ) ) ) {
							$filter_nav_item_classes .= ' active';
						} else {
							$cat_nav_item_classes .= ' active';
						}
						?>
						<div class="offcanvas-header d-block border-bottom py-lg-4 py-3 px-lg-0">
							<ul class="nav nav-pills" role="tablist">
								<li class="nav-item">
									<a class="<?php echo esc_attr( $cat_nav_item_classes ); ?>" href="#categories" data-bs-toggle="tab" role="tab" aria-selected="true">
										<i class="fi-list me-2"></i>
										<?php esc_attr_e( 'Categories', 'finder' ); ?>
									</a>
								</li>
								<li class="nav-item">
									<a class="<?php echo esc_attr( $filter_nav_item_classes ); ?>" href="#filters" data-bs-toggle="tab" role="tab" aria-selected="false">
										<i class="fi-filter-alt-horizontal me-2"></i>
										<?php esc_attr_e( 'Filters', 'finder' ); ?>
									</a>
								</li>
							</ul>
						</div>
					<?php endif; ?>
					<div class="offcanvas-body py-lg-4">
						<?php if ( 'city-guide' === $listing_style && ! is_wp_error( $listing_categories ) && $listing_categories ) : ?>
							<?php
								$cat_content_classes    = 'tab-pane fade';
								$filter_content_classes = $cat_content_classes;

							if ( isset( $_GET['filter_active'] ) && finder_clean( filter_var( wp_unslash( $_GET['filter_active'] ), FILTER_SANITIZE_NUMBER_INT ) ) ) {
								$filter_content_classes .= ' active show';
							} else {
								$cat_content_classes .= ' active show';
							}
							?>
							<div class="tab-content">
								<div class="<?php echo esc_attr( $cat_content_classes ); ?>" id="categories" role="tabpanel">
									<?php if ( $listing_categories ) : ?>
										<div class="row row-cols-lg-2 row-cols-1 g-3">
											<?php foreach ( $listing_categories as $category ) : ?>
												<?php
												$color_class = 'info';

												switch ( $iterator % 10 ) {
													case 1:
														$color_class = 'accent';
														break;
													case 2:
													case 5:
													case 9:
														$color_class = 'primary';
														break;
													case 3:
													case 8:
														$color_class = 'warning';
														break;
													case 4:
													case 7:
														$color_class = 'success';
														break;
												}

												$icon_wrapper_classes = 'icon-box-media bg-faded-' . $color_class . ' text-' . $color_class . ' rounded-circle mb-3 mx-auto';
												$icon_anchor_classes  = 'icon-box card card-body h-100 border-0 shadow-sm card-hover text-center';

												if ( is_tax( $taxonomy ) ) {
													if ( get_queried_object_id() && get_queried_object_id() === $category->term_id ) {
														$icon_anchor_classes .= ' active';
													}
												}

												$icon_class = finder_acf_get_term_field( 'hp_listing_category_icon', $taxonomy, $category->term_id );

												if ( ! $icon_class || empty( $icon_class ) ) {
													$icon_class = 'fi-archive';
												}
												?>
												<div class="col">
													<a class="<?php echo esc_attr( $icon_anchor_classes ); ?>" href="<?php echo esc_url( get_term_link( $category ) ); ?>">
														<div class="<?php echo esc_attr( $icon_wrapper_classes ); ?>">
															<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
														</div>
														<h3 class="icon-box-title fs-base mb-0"><?php echo esc_html( $category->name ); ?></h3>
													</a>
												</div>
												<?php $iterator++; ?>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
								</div>
								<div class="<?php echo esc_attr( $filter_content_classes ); ?>" id="filters" role="tabpanel">
						<?php endif; ?>
							<?php
							$liting_filter_args = array(
								'variant' => 'light',
							);
							finder_get_template( 'hivepress/listings/listing-filters.php', $liting_filter_args );
							if ( is_active_sidebar( 'sidebar-hivepress-listing' ) ) {
								dynamic_sidebar( 'sidebar-hivepress-listing' );
							}
							?>
						<?php if ( 'city-guide' === $listing_style && ! is_wp_error( $listing_categories ) && $listing_categories ) : ?>
							</div></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
			<button class="btn btn-primary btn-sm w-100 rounded-0 fixed-bottom d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#filters-sidebar">
				<i class="fi-filter me-2"></i>
				<?php echo esc_html( $filters_text ); ?>
			</button>
		</aside>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listings_sidebar_category' ) ) {
	/**
	 * Hivepress listings sidebar.
	 */
	function finder_hivepress_listings_sidebar_category() {

		$taxonomy = 'hp_listing_category';
		$categories_list = get_categories(array( 'taxonomy' => 'hp_listing_category' ));
			$category_class  = 'nav nav-tabs mb-0';
			?>
			<div class="offcanvas-header d-block border-bottom pt-0 pt-lg-4 px-lg-0">
				<ul class="<?php echo esc_attr( $category_class )?>">
					<?php foreach( $categories_list as $index => $category ) :
						$cat_active      = is_tax( 'hp_listing_category', $category->term_id ) ? 'nav-link active' : 'nav-link';
						$icon_class = finder_acf_get_term_field( 'hp_listing_category_icon', $taxonomy, $category->term_id );?>
					<li class="nav-item mb-2"><a class="<?php echo esc_attr( $cat_active ); ?>" href="<?php echo esc_attr( esc_url( get_category_link( $category->term_id ) ) )?>">
					<?php if ( ! empty( $icon_class ) ) :?>
					<i class="<?php echo esc_attr( $icon_class );?> fs-base me-2"></i>
					<?php endif; ?>
					<?php echo esc_html( $category->name );?></a></li>
					<?php endforeach; ?>
				</ul>
			</div><?php
		}
	}


if ( ! function_exists( 'finder_hivepress_listings_loop_column_wrap_start' ) ) {
	/**
	 * Hivepress listings loop column wrap start.
	 */
	function finder_hivepress_listings_loop_column_wrap_start() {

		$listing_layout = finder_hivepress_get_listings_layout();
		$listing_style  = finder_hivepress_get_listings_style();

		$wrapper_classes = 'col-lg-8 col-xl-9 position-relative overflow-hidden pb-5 pt-4 px-3 px-xl-4 px-xxl-5';

		if ( 'car-finder' === $listing_style ) {
			$wrapper_classes = 'col-lg-9 position-relative';
		}

		if ( 'full-width' === $listing_layout ) {
			$wrapper_classes .= ' mx-auto';
		}

		?>
		<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listings_loop_column_wrap_end' ) ) {
	/**
	 * Hivepress listings loop column wrap end.
	 */
	function finder_hivepress_listings_loop_column_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listings_breadcrumb' ) ) {
	/**
	 * Hivepress listings breadcrumb.
	 */
	function finder_hivepress_listings_breadcrumb() {

		$listing_style = finder_hivepress_get_listings_style();

		if ( 'car-finder' === $listing_style ) {
			$args = array(
				'style'     => 'light',
				'nav_class' => 'mb-3 pt-md-2 pt-lg-4',
			);

			finder_breadcrumb( $args );
		} else {
			finder_breadcrumb();
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listings_geolocations' ) ) {
	/**
	 * Hivepress listings geolocations.
	 */
	function finder_hivepress_listings_geolocations() {
		if ( ! finder_is_hivepress_geolocation_activated() ) {
			return;
		}

		// Query featured listings.
		$featured_query = new \WP_Query(
			HivePress\Models\Listing::query()->filter(
				array(
					'status' => 'publish',
					'id__in' => hivepress()->request->get_context( 'featured_ids', array() ),
				)
			)->order( 'random' )
			->limit( get_option( 'hp_listings_featured_per_page' ) )
			->get_args()
		);

		$i                      = 1;
		$listing_with_locations = array();
		$latitudes              = array();
		$longitudes             = array();

		if ( $featured_query->have_posts() || have_posts() ) {
			while ( $featured_query->have_posts() ) {
				$featured_query->the_post();

				// Get listing.
				$listing = HivePress\Models\Listing::query()->get_by_id( get_post() );

				$listing_args = array(
					'listing' => $listing,
					'i'       => $i,
				);

				if ( $listing ) {
					if ( $listing->get_location() && $listing->get_latitude() && $listing->get_longitude() ) {
						$slug         = get_post_field( 'post_name', get_the_ID() );
						$latitudes[]  = $listing->get_latitude();
						$longitudes[] = $listing->get_longitude();
						$listing_with_locations[ $slug ]['className']   = 'custom-marker-dot';
						$listing_with_locations[ $slug ]['coordinates'] = array( $listing->get_latitude(), $listing->get_longitude() );

						ob_start();
							finder_get_template( 'hivepress/listings/content/content-map-listing.php', $listing_args );
						$listing_with_locations[ $slug ]['popup'] = ob_get_clean();
						$listing_with_locations[ $slug ]['popup'] = str_replace( array( "\n", "\t" ), '', $listing_with_locations[ $slug ]['popup'] );
					}
				}
			}
			wp_reset_postdata();

			// Render regular listings.
			while ( have_posts() ) {
				the_post();

				// Get listing.
				$listing = HivePress\Models\Listing::query()->get_by_id( get_post() );

				$listing_args = array(
					'listing' => $listing,
					'i'       => $i,
				);

				if ( $listing ) {
					if ( $listing->get_location() && $listing->get_latitude() && $listing->get_longitude() ) {

						$slug         = get_post_field( 'post_name', get_the_ID() );
						$latitudes[]  = $listing->get_latitude();
						$longitudes[] = $listing->get_longitude();
						$listing_with_locations[ $slug ]['className']   = 'custom-marker-dot';
						$listing_with_locations[ $slug ]['coordinates'] = array( $listing->get_latitude(), $listing->get_longitude() );

						ob_start();
							finder_get_template( 'hivepress/listings/content/content-map-listing.php', $listing_args );
						$listing_with_locations[ $slug ]['popup'] = ob_get_clean();
						$listing_with_locations[ $slug ]['popup'] = str_replace( array( "\n", "\t" ), '', $listing_with_locations[ $slug ]['popup'] );
					}
				}
			}
		}

		$listing_with_locations = array_values( $listing_with_locations );

		$map_obj = array(
			'mapLayer'        => 'https://api.maptiler.com/maps/pastel/{z}/{x}/{y}.png?key=JlBYgyPJAvtWyOYAERlf',
			'scrollWheelZoom' => false,
			'coordinates'     => ( is_array( $latitudes ) && is_array( $longitudes ) && isset( $latitudes[0] ) && isset( $longitudes[0] ) ) ? array( $latitudes[0], $longitudes[0] ) : array(),
			'zoom'            => get_option( 'hp_geolocation_max_zoom' ),
			'markers'         => $listing_with_locations,
		);
		$map_obj['mapLayer'] = apply_filters('finder_listings_maptiler_api', 'https://api.maptiler.com/maps/pastel/{z}/{x}/{y}.png?key=JlBYgyPJAvtWyOYAERlf' );

		?>
		<div id="map" class="map-popup invisible">
			<button class="btn btn-icon btn-light btn-sm shadow-sm rounded-circle" type="button" data-bs-toggle-class="invisible" data-bs-target="#map"><i class="fi-x fs-xs"></i></button>
			<div class="interactive-map" data-map-options='<?php echo wp_json_encode( $map_obj, JSON_UNESCAPED_SLASHES ); ?>'></div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listings_page_header' ) ) {
	/**
	 * Hivepress listings page header.
	 */
	function finder_hivepress_listings_page_header() {

		$listing_style = finder_hivepress_get_listings_style();
		$total_results = finder_hivepress_get_listings_result_count();

		// Get page ID.
		$listing_page_id    = finder_hivepress_get_listings_page_id();
		$listing_page_title = get_the_title( $listing_page_id );

		if ( ! $listing_page_id ) {
			$listing_page_title = esc_html__( 'Listings', 'finder' );
		}

		if ( is_tax() ) {
			$listing_page_title = single_term_title( '', false );
		}

		finder_hivepress_listings_geolocations();

		if ( 'car-finder' === $listing_style ) {
			?>
			<div class="d-flex align-items-center justify-content-between pb-4 mb-2">
				<h1 class="text-light me-3 mb-0"><?php echo esc_html( $listing_page_title ); ?></h1>
				<div class="text-light">
					<?php if ( $total_results > 0 ) : ?>
						<span class="align-middle">
						<?php
						echo esc_html(
							sprintf(
							/* translators: 1: number of offers, 2: post title */
								esc_html( _nx( '%1$s offer', '%1$s offers', $total_results, 'results title', 'finder' ) ),
								number_format_i18n( $total_results )
							)
						);
						?>
						</span>
					<?php endif; ?>
					<?php if ( finder_is_hivepress_geolocation_activated() ) : ?>
						<a class="d-inline-block fw-bold text-decoration-none py-1 ms-2 text-light" href="#" data-bs-toggle-class="invisible" data-bs-target="#map">
							<i class="fi-map me-2"></i>
							<?php esc_html_e( 'Map view', 'finder' ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<?php
		} else {
			?>
			<div class="d-sm-flex align-items-center justify-content-between pb-3 pb-sm-4">
				<h1 class="h2 mb-sm-0"><?php echo esc_html( $listing_page_title ); ?></h1>
				<?php if ( finder_is_hivepress_geolocation_activated() ) : ?>
					<a class="d-inline-block fw-bold text-decoration-none py-1" href="#" data-bs-toggle-class="invisible" data-bs-target="#map">
						<i class="fi-map me-2"></i>
						<?php esc_html_e( 'Map view', 'finder' ); ?>
					</a>
				<?php endif; ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listings_views' ) ) {
	/**
	 * Returns the available views where key is a view name and value is a view icon
	 *
	 * Theme support grid and list view modes.
	 *
	 * @return array
	 */
	function finder_hivepress_listings_views() {
		return (array) apply_filters(
			'finder_hivepress_listings_views',
			array(
				'list' => '<i class="fi-list"></i>',
				'grid' => '<i class="fi-grid"></i>',
			)
		);
	}
}

if ( ! function_exists( 'finder_hivepress_listings_catalog_views_car_finder' ) ) {
	/**
	 * Display the view switcher.
	 */
	function finder_hivepress_listings_catalog_views_car_finder() {
		$current_view = finder_hivepress_get_listings_catalog_view();
		$views        = finder_hivepress_listings_views();

		foreach ( $views as $view => $content ) {
			echo wp_kses_post(
				sprintf(
					'<a class="nav-link nav-link-light px-2%1$s" href="%2$s" data-bs-toggle="tooltip" data-bs-original-title=%3$s" aria-label=%3$s">%4$s</a>',
					esc_attr( $view === $current_view ? ' active' : '' ),
					esc_url( add_query_arg( 'view', rawurlencode( $view ), false ) ),
					'grid' === $view ? esc_attr__( 'Grid view', 'finder' ) : esc_attr__( 'List view', 'finder' ),
					wp_kses_post( $content )
				)
			);
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listings_orderby' ) ) :
	/**
	 * Listings orderby options
	 */
	function finder_hivepress_listings_orderby() {
		$sort = apply_filters( 'finder_hivepress_listings_orderby_default', '' );

		if ( isset( $_GET['_sort'] ) && ! empty( $_GET['_sort'] ) ) {
			$sort = filter_var( wp_unslash( $_GET['_sort'] ), FILTER_SANITIZE_STRING );
		} elseif ( get_query_var( '_sort' ) ) {
			$sort = get_query_var( '_sort' );
		}

		return $sort;
	}

endif;

if ( ! function_exists( 'finder_hivepress_listings_top_control_bar' ) ) {
	/**
	 * Hivepress listings top control bar.
	 */
	function finder_hivepress_listings_top_control_bar() {

        $listing_style   = finder_hivepress_get_listings_style();
        $total_results   = finder_hivepress_get_listings_result_count();
        $sorting         = new HivePress\Forms\Listing_Sort();
        $sorting_options = $sorting->get_fields()['_sort']->get_args()['options'];
        $orderby         = finder_hivepress_listings_orderby();
		$listing_get_query_args = get_queried_object();

        if ( 'car-finder' === $listing_style ) {
            ?>
            <div class="d-sm-flex align-items-center justify-content-between pb-4 mb-2">
                <form class="d-flex align-items-center me-sm-4 finder-hivepress-sorting" id="finder-hivepress-sorting-form" action="<?php echo esc_url( home_url($_SERVER['REQUEST_URI']) ); ?>" method="GET">
                    <input type="hidden" name="post_type" value="hp_listing" class="hp-field hp-field--hidden">
                    <label class="fs-sm text-light me-2 pe-1 text-nowrap" for="finder-hivepress-sorting-form">
                        <i class="fi-arrows-sort mt-n1 me-2"></i>
                        <?php echo esc_html__( 'Sort by:', 'finder' ); ?>
                    </label>
                    <select name="_sort" class="listing-orderby form-select form-select-light form-select-sm me-sm-4" id="finder-hivepress-sorting-select">
                        <?php foreach ( $sorting_options as $key => $option ) : ?>
                            <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $orderby, $key ); ?>><?php echo esc_html( $option ); ?></option>
                        <?php endforeach; ?>
                    </select>
					
                </form>
                <div class="d-none d-sm-flex">
                    <?php finder_hivepress_listings_catalog_views_car_finder(); ?>
                </div>
            </div>
            <?php
        } else {
            ?>
            <?php
			// print_r(get_query_var());
            if ( $total_results > 0 ) {
				$listing_home_url = home_url();
				if ( isset( $listing_get_query_args->term_id ) ){
					$listing_home_url = add_query_arg( '_category', $listing_get_query_args->term_id,  home_url($_SERVER['REQUEST_URI']) );
				}
                ?>
                <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch my-2">
                    <form class="d-flex align-items-center flex-shrink-0 finder-hivepress-sorting" id="finder-hivepress-sorting-form" action="<?php echo esc_url( $listing_home_url ); ?>" method="GET">
                        <input type="hidden" name="post_type" value="hp_listing" class="hp-field hp-field--hidden">
                        <label class="fs-sm me-2 pe-1 text-nowrap" for="sortby">
                            <i class="fi-arrows-sort text-muted mt-n1 me-2"></i>
                            <?php echo esc_html__( 'Sort by:', 'finder' ); ?>
                        </label>
                        <select name="_sort" class="listing-orderby form-select form-select-sm" id="finder-hivepress-sorting-select">
                            <?php foreach ( $sorting_options as $key => $option ) : ?>
                                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $orderby, $key ); ?>><?php echo esc_html( $option ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                    <hr class="d-none d-sm-block w-100 mx-4">
                    <div class="d-none d-sm-flex align-items-center flex-shrink-0 text-muted">
                        <i class="fi-check-circle me-2"></i>
                        <span class="fs-sm mt-n1">
                        <?php
                            echo esc_html(
                                sprintf(
                                /* translators: 1: number of offers, 2: post title */
                                    esc_html( _nx( '%1$s result', '%1$s results', $total_results, 'results title', 'finder' ) ),
                                    number_format_i18n( $total_results )
                                )
                            );
                        ?>
                        </span>
                    </div>      
                </div>
                <?php
            }
        }
    }
}

if ( ! function_exists( 'finder_hivepress_listings_car_finder_bottom_control_bar' ) ) {
	/**
	 * Hivepress listings car finder bottom control bar.
	 */
	function finder_hivepress_listings_car_finder_bottom_control_bar() {

		$sorting         = new HivePress\Forms\Listing_Sort();
		$sorting_options = $sorting->get_fields()['_sort']->get_args()['options'];
		$orderby         = finder_hivepress_listings_orderby();

		?>
		<div class="d-flex align-items-center justify-content-between py-2">
			<form class="d-flex align-items-center me-sm-4 finder-hivepress-sorting d-none d-md-flex" action="<?php echo esc_url( home_url() ); ?>" method="GET">
				<input type="hidden" name="post_type" value="hp_listing" class="hp-field hp-field--hidden">
				<label class="fs-sm text-light me-2 pe-1 text-nowrap" for="sorting2">
					<i class="fi-arrows-sort mt-n1 me-2"></i>
					<?php echo esc_html__( 'Sort by:', 'finder' ); ?>
				</label>
				<select name="_sort" class="listing-orderby form-select form-select-light form-select-sm me-2 me-sm-4" id="sorting2" onchange="this.form.submit();">
					<?php foreach ( $sorting_options as $key => $option ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $orderby, $key ); ?>><?php echo esc_html( $option ); ?></option>
					<?php endforeach; ?>
				</select>
			</form>
			<?php finder_bootstrap_pagination( null, true, '', 'pagination-light mb-0' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listings_pagination' ) ) {
	/**
	 * Hivepress listings pagination.
	 */
	function finder_hivepress_listings_pagination() {

		$listing_style = finder_hivepress_get_listings_style();
		$nav_classes   = 'border-top pb-md-4 pt-4';
		$ul_classes    = 'mb-1';

		if ( 'real-estate' === $listing_style ) {
			$nav_classes .= ' mt-2';
		}

		finder_bootstrap_pagination( null, true, $nav_classes, $ul_classes );
	}
}

if ( ! function_exists( 'finder_hivepress_listings_loop' ) ) {
	/**
	 * Hivepress listings loop.
	 *
	 * @param array $args array of arguments.
	 */
	function finder_hivepress_listings_loop( $args = array() ) {

		$defaults = array(
			'row_classes'    => 'row g-4 py-4 row-cols-sm-2 row-cols-xl-3 row-cols-1',
			'column_classes' => 'col ',
			'template'       => 'hivepress/listings/content/content-real-estate.php',
		);

		$args = wp_parse_args( $args, $defaults );

		// Query featured listings.
		$featured_query = new \WP_Query(
			HivePress\Models\Listing::query()->filter(
				array(
					'status' => 'publish',
					'id__in' => hivepress()->request->get_context( 'featured_ids', array() ),
				)
			)->order( 'random' )
			->limit( get_option( 'hp_listings_featured_per_page' ) )
			->get_args()
		);

		if ( $featured_query->have_posts() || have_posts() ) {
			?>
			<div class="<?php echo esc_attr( $args['row_classes'] ); ?>">
				<?php
				while ( $featured_query->have_posts() ) {
					$featured_query->the_post();

					// Get listing.
					$listing = HivePress\Models\Listing::query()->get_by_id( get_post() );

					if ( $listing ) {

						$listing_args = array(
							'listing' => $listing,
						);

						?>
							<div class="<?php echo esc_attr( $args['column_classes'] ); ?>">
							<?php finder_get_template( $args['template'], $listing_args ); ?>
							</div>
							<?php
					}
				}
				wp_reset_postdata();

				// Render regular listings.
				while ( have_posts() ) {
					the_post();

					// Get listing.
					$listing = HivePress\Models\Listing::query()->get_by_id( get_post() );

					if ( $listing ) {
						$listing_args = array(
							'listing' => $listing,
						);

						?>
							<div class="<?php echo esc_attr( $args['column_classes'] ); ?>">
							<?php finder_get_template( $args['template'], $listing_args ); ?>
							</div>
							<?php
					}
				}
				?>
			</div>
			<?php
		} else {
			finder_get_template( 'hivepress/listings/content-none.php' );
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listings_real_state_loop_content' ) ) {
	/**
	 * Hivepress listings real estate loop content.
	 */
	function finder_hivepress_listings_real_state_loop_content() {
		$col_layout = finder_hivepress_listing_columns();
		$args       = array(
			'row_classes'    => 'row g-4 py-4 row-cols-sm-2 row-cols-1 row-cols-xl-' . $col_layout . '',
			'column_classes' => 'col ',
			'template'       => 'hivepress/listings/content/content-real-estate.php',
		);

		finder_hivepress_listings_loop( $args );
	}
}

if ( ! function_exists( 'finder_hivepress_listings_city_guide_loop_content' ) ) {
	/**
	 * Hivepress listings real estate loop content.
	 */
	function finder_hivepress_listings_city_guide_loop_content() {
		$col_layout = finder_hivepress_listing_columns();
		$args       = array(
			'row_classes'    => 'row row-cols-xl-' . $col_layout . ' row-cols-sm-2 row-cols-1 gy-4 gx-3 gx-xxl-4 py-4',
			'column_classes' => 'col pb-sm-2',
			'template'       => 'hivepress/listings/content/content-city-guide.php',
		);

		finder_hivepress_listings_loop( $args );
	}
}

if ( ! function_exists( 'finder_hivepress_listings_car_finder_loop_content' ) ) {
	/**
	 * Hivepress listings car finder loop content.
	 */
	function finder_hivepress_listings_car_finder_loop_content() {
		$col_layout          = finder_hivepress_listing_columns();
		$car_style_variation = finder_hivepress_get_listings_catalog_view();

		$row_classes    = 'row row-cols-xl-' . $col_layout . ' row-cols-sm-2 row-cols-1';
		$column_classes = 'col mb-4';

		if ( 'list' === $car_style_variation ) {
			$row_classes    = 'row';
			$column_classes = 'col-12';
		}

		$listing_style = finder_hivepress_get_listings_style();

		if ( 'car-finder' === $listing_style ) {
			$listing_style = $listing_style . '-' . $car_style_variation;
		}

		$args = array(
			'row_classes'    => $row_classes,
			'column_classes' => $column_classes,
			'template'       => 'hivepress/listings/content/content-' . $listing_style . '.php',
		);

		finder_hivepress_listings_loop( $args );
	}
}

if ( ! function_exists( 'finder_hivepress_listing_loop_title' ) ) {
	/**
	 * Hivepress listing loop title.
	 *
	 * @param object $listing listing object.
	 * @param string $title_class title classes.
	 * @param string $anchor_class anchor classes.
	 */
	function finder_hivepress_listing_loop_title( $listing, $title_class = ' h6 mb-2 fs-base', $anchor_class = 'nav-link stretched-link' ) {
		?>
		<h3 class="finder-hp-listing-title <?php echo esc_attr( $title_class ); ?>">
			<a class="<?php echo esc_attr( $anchor_class ); ?>" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_view_page', array( 'listing_id' => $listing->get_id() ) ) ); ?>"><?php echo esc_html( $listing->get_title() ); ?></a>
		</h3>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listing_loop_featured_badge' ) ) {
	/**
	 * Hivepress listing loop featured badge.
	 *
	 * @param object $listing listing object.
	 * @param string $badge_class badge classes.
	 */
	function finder_hivepress_listing_loop_featured_badge( $listing, $badge_class = 'd-table badge bg-danger' ) {

		if ( $listing->is_featured() ) {
			?>
			<span class="<?php echo esc_attr( $badge_class ); ?>"><?php esc_html_e( 'Featured', 'finder' ); ?></span>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listing_loop_verified_badge' ) ) {
	/**
	 * Hivepress listing loop verified badge.
	 *
	 * @param object $listing listing object.
	 * @param string $badge_class badge classes.
	 */
	function finder_hivepress_listing_loop_verified_badge( $listing, $badge_class = 'd-table badge bg-success mb-1' ) {

		$listing_style = finder_hivepress_get_listings_style();

		$verified_text = esc_html__( 'Verified', 'finder' );

		if ( 'car-finder' === $listing_style ) {
			$verified_text = esc_html__( 'Certified', 'finder' );
		}

		if ( $listing->is_verified() ) {
			?>
			<span class="<?php echo esc_attr( $badge_class ); ?>"><?php echo esc_html( $verified_text ); ?></span>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listing_loop_category' ) ) {
	/**
	 * Hivepress listing loop category.
	 *
	 * @param object $listing listing object.
	 * @param string $wrap_class wrapper classes.
	 * @param string $cat_class category classes.
	 */
	function finder_hivepress_listing_loop_category( $listing, $wrap_class = 'd-flex align-items-center justify-content-between pb-1', $cat_class = 'fs-sm text-light me-3' ) {
		?>
		<?php if ( $listing->get_categories() ) : ?>
			<div class="finder-hp-listing-category <?php echo esc_attr( $wrap_class ); ?>">
				<?php foreach ( $listing->get_categories() as $category ) : ?>
					<span class="<?php echo esc_attr( $cat_class ); ?>"><?php echo esc_html( $category->get_name() ); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listing_car_finder_loop_title_before' ) ) {
	/**
	 * Hivepress listing loop category.
	 *
	 * @param object $listing listing object.
	 * @param string $wrap_class wrapper classes.
	 * @param string $cat_class category classes.
	 */
	function finder_hivepress_listing_car_finder_loop_title_before( $listing, $wrap_class = 'd-flex align-items-center justify-content-between pb-1', $cat_class = 'fs-sm text-light me-3' ) {
		?>
		<?php if ( $listing->_get_fields( 'view_block_primary' ) && ! empty( finder_hivepress_default_attribute_count( $listing, 'view_block_primary' ) ) ) : ?>
				<?php
				$i = 1;
				foreach ( $listing->_get_fields( 'view_block_primary' ) as $key => $field ) {
					
					$field_slug           = preg_replace("/[\-_]/", "_", $field->get_slug());
					$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field_slug );
					$attribute_style      = finder_get_field( 'style', $attribute_id );
					$attribute_view_style = finder_get_field( 'car_finder_archive_view_style', $attribute_id );
					$display              = $field->display();

					if ( ! is_null( $field->get_value() ) ) {

						if ( 'year' === $attribute_view_style ) {
							?>
							<div class="finder-hp-listing-category <?php echo esc_attr( $wrap_class ); ?>">
								<span class="<?php echo esc_attr( $cat_class ); ?>"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></span>
							</div>
							<?php
						}
					}
				}
				?>
		<?php endif; ?>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_category_filter_dropdown' ) ) {
	/**
	 * Hivepress listing loop category.
	 *
	 * @param object $listing listing object.
	 * @param string $wrap_class wrapper classes.
	 * @param string $cat_class category classes.
	 */
	function finder_hivepress_category_filter_dropdown() {
		$taxonomy = 'hp_listing_category';
		$listing_get_query_args = get_queried_object();
		$listing_style = finder_hivepress_get_listings_style();
		
		$listing_category_args = array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
			'orderby'    => 'slug',
		);
		$label_class = "";
		if ( $listing_style === "car-finder") {
			$label_class = "text-light";
		}
		$categories_list = get_categories( $listing_category_args );
		if ( ! empty ( $categories_list )):
			$i = 0;
			?>
			<div class="pb-4 mb-2">
				<h3 class="h6 <?php echo esc_attr( $label_class ); ?>">Category</h3>
				<div class="dropdown mb-sm-0 mb-3" data-bs-toggle="select">
					<button class="btn btn-outline-secondary d-flex align-items-center w-100 px-4 fw-normal text-start dropdown-toggle" type="button" data-bs-toggle="dropdown"><i class="fi-list me-2 text-muted"></i><span class="dropdown-toggle-label d-block w-100"><?php echo esc_html( 'Categories' ); ?></span></button>
					<?php if (  isset( $listing_get_query_args->term_id ) &&  $listing_get_query_args->term_id  ) {
						?><input type="hidden" value="<?php echo esc_attr($listing_get_query_args->term_id); ?>" name="_category" class="hivepress-elementor-dropdown"><?php
					}
					else{
						?><input type="hidden" name="_category" class="hivepress-elementor-dropdown"><?php
					}?>
						<?php
					?>
						<ul class="dropdown-menu w-100">
							<?php foreach ( $categories_list as $index => $category ) : 
								if( 0 === $i ){
									?><li>
									<a class="dropdown-item" href="#">
									<?php
									if ( finder_is_acf_activated() ) { 
										?><i class="fi-home me-2 fs-lg opacity-60"></i><?php
									} ?>
									<span class="dropdown-item-value d-none"><?php echo esc_html( 0 ); ?></span><span class="dropdown-item-label hivepress-advanced"><?php echo esc_html__( "All Categories", 'finder' ); ?></span>
									</a>
								</li><?php
								}
								?>
								<?php if (  isset( $listing_get_query_args->taxonomy) &&  $listing_get_query_args->term_id === $category->term_id ) {
									?><li>
										<a class="dropdown-item" href="#">
										<?php
										if ( finder_is_acf_activated() ) { 
											$icon_class = finder_acf_get_term_field( 'hp_listing_category_icon', 'hp_listing_category', $category->term_id );
											if ( ! empty( $icon_class )) {
												?><i class="<?php echo esc_attr( $icon_class ); ?> me-2 fs-lg opacity-60"></i><?php
											}
										} ?>
										<span class="dropdown-item-value d-none"><?php echo esc_html( $category->term_id ); ?></span><span class="dropdown-item-label hivepress-advanced"><?php echo esc_html( $category->name ); ?></span>
										</a>
									</li><?php
								}
								if( ! isset( $listing_get_query_args->taxonomy) ) {
									?><li>
										<a class="dropdown-item" href="#">
										<?php
										if ( finder_is_acf_activated() ) { 
											$icon_class = finder_acf_get_term_field( 'hp_listing_category_icon', 'hp_listing_category', $category->term_id );
											if ( ! empty( $icon_class )) {
												?><i class="<?php echo esc_attr( $icon_class ); ?> me-2 fs-lg opacity-60"></i><?php
											}
										} ?>
										<span class="dropdown-item-value d-none"><?php echo esc_html( $category->term_id ); ?></span><span class="dropdown-item-label hivepress-advanced"><?php echo esc_html( $category->name ); ?></span>
										</a>
									</li><?php
								}?>
							<?php
							$i++;
							endforeach; ?>
						</ul>
				</div>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'finder_hivepress_category_filter_dropdown_list' ) ) {
	/**
	 * Hivepress listing loop category.
	 *
	 * @param object $listing listing object.
	 * @param string $wrap_class wrapper classes.
	 * @param string $cat_class category classes.
	 */
	function finder_hivepress_category_filter_dropdown_list() {
		$taxonomy = 'hp_listing_category';
		$listing_get_query_args = get_queried_object();
		$listing_style = finder_hivepress_get_listings_style();

		
		
		$listing_category_args = array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
			'orderby'    => 'slug',
		);
		$label_classes        = 'h6';
		$wrapper_classes = 'form-check';

		if ( 'car-finder' === $listing_style ) {
			$wrapper_classes .= ' form-check-light';
		}
				
		$categories_list = get_categories( $listing_category_args );
				
					// $categories_list = $field->get_args()['options'];

					$selected = '';
					// if ( isset( $_GET[ '_category' ] ) && ! empty( $_GET[ '_category' ] ) ) {
					// 	$selected = filter_var( wp_unslash( $_GET[ '_category' ] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
					// } elseif ( get_query_var( '_category' ) ) {
					// 	$selected = get_query_var( '_category' );
					// }

					if ( ! empty( get_queried_object_id() ) ){
						$selected = get_queried_object_id();
					} else {
						$selected = '';
						if ( isset( $_GET[ '_category' ] ) && ! empty( $_GET[ '_category' ] ) ) {
							$selected = filter_var( wp_unslash( $_GET[ '_category' ] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
						} elseif ( get_query_var( '_category' ) ) {
							$selected = get_query_var( '_category' );
						}
						
					}

					?>
					<div class="pb-4 mb-2">
						<h3 class="<?php echo esc_attr( $label_classes ); ?>"><?php echo esc_html( "Categories" ); ?></h3>
						<?php if ( count( $categories_list ) > 6 ) : ?>
							<div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" style="height: 11rem;">
						<?php endif; ?>
						<?php foreach ( $categories_list as $key => $option ) : ?>
							<?php
								$unique_id = 'category_' . uniqid();

								// $wrapper_classes = 'form-check';

							// if ( 'dark' === $variant ) {
							// 	$wrapper_classes .= ' form-check-light';
							// }

								$checkbox_options_attr = array(
									'id'    => $unique_id,
									'type'  => 'radio',
									'class' => 'form-check-input',
									'value' => $option->term_id,
									'name'  => '_category',

								);

								if ( isset( $selected ) && ! empty( $selected ) ) {
									if ( is_array( $selected ) && in_array( $option->term_id, $selected ) || $option->term_id == (int) $selected ) {
										$checkbox_options_attr['checked'] = true;
									}
								}
								?>
							<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
								<input <?php finder_render_attr( 'listing_attribute_filter_select_options_' . $option->term_id, $checkbox_options_attr ); ?>>
								<label class="form-check-label fs-sm" for="<?php echo esc_attr( $unique_id ); ?>"><?php echo esc_html( $option->name ); ?></label>
							</div>
						<?php endforeach; ?>
						<?php if ( count( $categories_list ) > 6 ) : ?>
							</div>
						<?php endif; ?>
					</div>
					<?php
	}
}

