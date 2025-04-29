<?php
/**
 * Finder HivePress Template Functions
 *
 * @package Finder
 */

use HivePress\blocks\Message_Send_Form;
use HivePress\Forms\Message_Send;

if ( ! function_exists( 'finder_hivepress_vendor_single_template' ) ) {
	/**
	 * Display hivepress single content.
	 *
	 * @param object $vendor vendor object.
	 */
	function finder_hivepress_vendor_single_template( $vendor ) {

		$args = array(
			'vendor' => $vendor,
		);

		$vendor_style = finder_hivepress_get_vendor_single_style();

		finder_get_template( 'hivepress/vendors/vendor-single/vendor-single-' . $vendor_style . '.php', $args );
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_container_wrap_start' ) ) {
	/**
	 * Hivepress vendor single container wrap start.
	 */
	function finder_hivepress_vendor_single_container_wrap_start() {
		$is_sticky_header = finder_is_sticky_header();

		$container_classes = 'container mb-md-4';

		if ( $is_sticky_header ) {
			$container_classes .= ' mt-5 py-5';
		} else {
			$container_classes .= ' pt-3 mt-1';
		}

		?>
		<div class="<?php echo esc_attr( $container_classes ); ?>">
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_container_wrap_end' ) ) {
	/**
	 * Hivepress vendor single container wrap end.
	 */
	function finder_hivepress_vendor_single_container_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_row_wrap_start' ) ) {
	/**
	 * Hivepress vendor single row wrap start.
	 */
	function finder_hivepress_vendor_single_row_wrap_start() {
		?>
		<div class="row">	
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_row_wrap_end' ) ) {
	/**
	 * Hivepress vendor single row wrap end.
	 */
	function finder_hivepress_vendor_single_row_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_sidebar_wrap_start' ) ) {
	/**
	 * Hivepress vendor single real estate sidebar wrap start.
	 */
	function finder_hivepress_vendor_single_sidebar_wrap_start() {
		?>
		<aside class="col-lg-3 col-md-4 mb-5">	
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_sidebar_wrap_end' ) ) {
	/**
	 * Hivepress vendor single real estate sidebar wrap end.
	 */
	function finder_hivepress_vendor_single_sidebar_wrap_end() {
		?>
		</aside>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_sidebar' ) ) {
	/**
	 * Hivepress vendor single sidebar.
	 *
	 * @param object $vendor vendor object.
	 */
	function finder_hivepress_vendor_single_sidebar( $vendor ) {

		$vendor_style = finder_hivepress_get_vendor_single_style();
		?>
		<div class="pe-lg-3">
			<div class="finder-hp-vendor__image">
				<?php if ( $vendor->get_image__url() ) : ?>
					<img class="d-block rounded-circle mx-auto mx-md-0 mb-3" src="<?php echo esc_url( $vendor->get_image__url() ); ?>" alt="<?php echo esc_attr( $vendor->get_name() ); ?>" loading="lazy" width="120">
				<?php else : ?>
					<img class="d-block rounded-circle mx-auto mx-md-0 mb-3" src="<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/user-square.svg' ); ?>" alt="<?php echo esc_attr( $vendor->get_name() ); ?>" loading="lazy" width="120">
				<?php endif; ?>
			</div>
			<h2 class="align-items-center d-flex h4 justify-content-center justify-content-md-start mb-1">
				<?php echo esc_html( $vendor->get_name() ); ?>
				<?php if ( $vendor->is_verified() ) : ?>
					<i class="fi-check-circle text-success ms-2"></i>
				<?php endif; ?>
			</h2>
			<?php if ( $vendor->_get_fields( 'view_block_primary' ) ) : ?>
				<?php foreach ( $vendor->_get_fields( 'view_block_primary' ) as $field ) : ?>
					<?php if ( ! is_null( $field->get_value() ) ) : ?>
						<p class="text-center text-md-start mb-2 pb-1">
							<?php echo wp_kses_post( $field->display() ); ?>
						</p>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if ( finder_is_hivepress_reviews_activated() && $vendor->get_rating() ) : ?>
				<div class="hp-vendor__rating hp-rating d-flex justify-content-center justify-content-md-start border-bottom pb-4 mb-4">
					<span class="hp-rating__star hp-rating-stars star-rating" data-component="rating" data-value="<?php echo esc_attr( $vendor->get_rating() ); ?>"></span>
					<span class="hp-rating__count ms-2 text-primary text-decoration-underline">
					<?php
					echo esc_html(
						sprintf(
						/* translators: 1: number of reviews, 2: review count */
							esc_html( _nx( '%1$s Review', '%1$s Reviews', $vendor->display_rating_count(), 'review count', 'finder' ) ),
							number_format_i18n( $vendor->display_rating_count() )
						)
					);
					?>
					</span>	
				</div>
			<?php endif; ?>	
			<?php
			if ( get_the_content() ) :
				?>
				<div class="border-bottom pb-4 mb-4"><div class="hp-vendor__description"><?php endif; ?>
				<?php the_content(); ?>
			<?php
			if ( get_the_content() ) :
				?>
				</div></div><?php endif; ?>
			<?php
			if ( 'real-estate' === $vendor_style ) {
					// Vendor Social Links.
					finder_display_vendor_social_links( $vendor );
					finder_hivepress_vendor_single_real_estate_attributes_secondary_top( $vendor );
			}
			?>
			<?php
			if ( 'city-guide' === $vendor_style ) {
					// Vendor Social Links.
					finder_display_vendor_social_links( $vendor );
					finder_hivepress_vendor_single_city_guide_attributes_secondary_top( $vendor );
			}
			?>
			<?php
			$modal_id_attr = 'user_login_modal';

			if ( is_user_logged_in() ) {
				$modal_id_attr = 'message_send_modal_' . $vendor->get_id();
			}
			?>
			<?php if ( finder_is_hivepress_messages_activated() ) : ?>	
				<div class="text-center text-md-start pt-md-2 mt-4">
					<a class="btn btn-primary" href="#<?php echo esc_attr( $modal_id_attr ); ?>" data-bs-toggle="modal">
						<i class="fi-chat-left fs-sm me-2"></i>
						<?php esc_html_e( 'Direct message', 'finder' ); ?>
					</a>
				</div>
				<?php finder_hivepress_vendor_message_form( $vendor ); ?>
			<?php endif; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_loop_column_wrap_start' ) ) {
	/**
	 * Hivepress vendor single loop column wrap start.
	 */
	function finder_hivepress_vendor_single_loop_column_wrap_start() {
		?>
		<div class="col-lg-9 col-md-8">			
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_loop_column_wrap_end' ) ) {
	/**
	 * Hivepress vendor single loop column wrap end.
	 */
	function finder_hivepress_vendor_single_loop_column_wrap_end() {
		?>
	</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_real_estate_loop' ) ) {
	/**
	 * Hivepress vendor single loop.
	 */
	function finder_hivepress_vendor_single_real_estate_loop() {
		$args = array(
			'row_classes'    => 'row g-4 g-md-3 g-lg-4 pt-2',
			'column_classes' => 'col-sm-6 col-lg-4',
			'template'       => 'hivepress/listings/content/content-real-estate.php',
		);

		finder_hivepress_listings_loop( $args );
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_page_title' ) ) {
		/**
		 * Hivepress vendor single page title.
		 *
		 * @param object $vendor vendor object.
		 */
	function finder_hivepress_vendor_single_page_title( $vendor ) {
		?>
		<h1 class="hp-page__title h2 text-center text-sm-start mb-4"><?php echo sprintf( 'Listings by %s', esc_html( $vendor->get_name() ) ); ?></h1>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_car_finder_container_wrap_start' ) ) {
	/**
	 * Hivepress vendor car finder container wrap start.
	 */
	function finder_hivepress_vendor_car_finder_container_wrap_start() {
		$is_sticky_header = finder_is_sticky_header();

		$container_classes = 'container pb-lg-4';

		if ( $is_sticky_header ) {
			$container_classes .= ' pt-5  mt-5';
		} else {
			$container_classes .= ' py-1';
		}

		?>
		<div class="<?php echo esc_attr( $container_classes ); ?>">
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_car_finder_container_wrap_end' ) ) {
	/**
	 * Hivepress vendor car finder container wrap end.
	 */
	function finder_hivepress_vendor_car_finder_container_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_car_finder_row_wrap_start' ) ) {
	/**
	 * Hivepress vendor car_finder row wrap start.
	 */
	function finder_hivepress_vendor_car_finder_row_wrap_start() {
		?>
		<div class="row">	
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_car_finder_row_wrap_end' ) ) {
	/**
	 * Hivepress vendor car_finder row wrap end.
	 */
	function finder_hivepress_vendor_car_finder_row_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_car_finder_loop_column_wrap_start' ) ) {
	/**
	 * Hivepress vendor car_finder loop column wrap start.
	 */
	function finder_hivepress_vendor_car_finder_loop_column_wrap_start() {

		?>
		<div class="col-lg-8 order-lg-2 mb-5">			
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_car_finder_loop_column_wrap_end' ) ) {
	/**
	 * Hivepress vendor car_finder loop column wrap end.
	 */
	function finder_hivepress_vendor_car_finder_loop_column_wrap_end() {
		?>
	</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_car_finder_sidebar' ) ) {
	/**
	 * Hivepress vendor car_finder sidebar.
	 *
	 * @param object $vendor vendor object.
	 */
	function finder_hivepress_vendor_car_finder_sidebar( $vendor ) {
		if ( ! finder_is_hivepress_activated() ) {
			return;
		}
		if ( finder_is_hivepress_messages_activated() ) {

			$msg_forms = new Message_Send_Form();
			

			$msg_form_args = array(
				'attributes' => array(
					'class'      => array( 'modal-body' ),
					'data-reset' => 'true',
					
				),
				'fields'     => array(
					'text'      => array(
						'label'      => false,
						'attributes' => array(
							'rows'        => 6,
							'placeholder' => esc_html__( 'Type your message here', 'finder' ),
						),
					),
					'recipient' => array(
						'display_type' => 'hidden',
						'value'        => $vendor->get_user__id(),
					),
				),
				'button'     => array(
					'label'      => esc_html__( 'Send message', 'finder' ),
					'attributes' => array(
						'class' => array( 'btn', 'btn-primary', 'mb-2', 'mt-2' ),
					),
				),
			);

			if ( ! empty( $msg_forms->get_context()['message'] ) ) {
				$data_id = $msg_forms->get_context()['message']->get_id();
				$msg_form_args['attributes']['data-id'] = $data_id;
			}

			$msg_form = new Message_Send( $msg_form_args );
		}

		?>
		<aside class="col-lg-4 order-2 order-lg-1 pe-xl-4 mb-5">
			<div class="d-flex align-items-start mb-4">
				<?php if ( $vendor->get_image__url() ) : ?>
					<img class="rounded-circle" src="<?php echo esc_url( $vendor->get_image__url() ); ?>" alt="<?php echo esc_attr( $vendor->get_name() ); ?>" loading="lazy" width="70">
				<?php else : ?>
					<img class="rounded-circle" src="<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/user-square.svg' ); ?>" alt="<?php echo esc_attr( $vendor->get_name() ); ?>" loading="lazy" width="70">
				<?php endif; ?>
				<div class="ps-2">
					<h2 class="h4 text-light mb-1">
						<?php echo esc_html( $vendor->get_name() ); ?>		
					</h2>
					<?php finder_hivepress_vendor_single_car_finder_attributes_page_top( $vendor ); ?>
				</div>
			</div>
			<?php finder_hivepress_vendor_single_car_finder_attributes_secondary_top( $vendor ); ?>
			<!-- Vendor Social Links -->
			<?php finder_display_vendor_social_links( $vendor ); ?>
			<?php finder_hivepress_vendor_single_car_finder_attributes_page_bottom( $vendor ); ?> 
			<?php if ( finder_is_hivepress_messages_activated() ) : ?>
				<div class="modal fade" id="user_vendor_message" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 550px;">
						<div class="modal-content">
							<div class="modal-body px-0 py-2 py-sm-0">
								<div class="modal-header">
									<h3 class="fs-base modal-title"><?php echo esc_html( sprintf( 'Message to  %s', $vendor->get_name() ) ); ?></h3>
								</div>
								<button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal"></button>
								<div class="row mx-0 align-items-center">
									<div class="col-12">
										<?php echo apply_filters( 'finder_vendor_single_msg_form_output', $msg_form->render() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<button href="#user_vendor_message" class="btn btn-primary btn-lg" type="submit" data-bs-toggle="modal"><i class="fi-send me-2"></i><?php echo esc_html__( 'Send message', 'finder' ); ?></button>
			<?php endif; ?>        
		</aside>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_car_finder_page_title' ) ) {
		/**
		 * Hivepress vendor car_finder page title.
		 *
		 * @param object $vendor vendor object.
		 */
	function finder_hivepress_vendor_car_finder_page_title( $vendor ) {
		?>
			<h1 class="hp-page__title h3 text-light mb-sm-0 me-sm-3"><?php echo sprintf( 'Available car by %s', esc_html( $vendor->get_name() ) ); ?></h1>	
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_car_finder_loop' ) ) {
	/**
	 * Hivepress vendor single loop.
	 */
	function finder_hivepress_vendor_single_car_finder_loop() {
		$args = array(
			'row_classes'    => 'row',
			'column_classes' => 'col-12',
			'template'       => 'hivepress/listings/content/content-car-finder-list.php',
		);
		finder_hivepress_listings_loop( $args );
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_city_guide_container_wrap_start' ) ) {
	/**
	 * Hivepress vendor city guide container wrap start.
	 */
	function finder_hivepress_vendor_city_guide_container_wrap_start() {
		$is_sticky_header = finder_is_sticky_header();

		$container_classes = 'container mb-md-4';

		if ( $is_sticky_header ) {
			$container_classes .= ' mt-5 py-5';
		} else {
			$container_classes .= ' pt-3 my-1';
		}

		?>
		<div class="<?php echo esc_attr( $container_classes ); ?>">
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_city_guide_container_wrap_end' ) ) {
	/**
	 * Hivepress vendor city guide container wrap end.
	 */
	function finder_hivepress_vendor_city_guide_container_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_city_guide_row_wrap_start' ) ) {
	/**
	 * Hivepress vendor city_guide row wrap start.
	 */
	function finder_hivepress_vendor_city_guide_row_wrap_start() {
		?>
		<div class="card p-sm-4 border-0 shadow-sm">
			<div class="card-body">
				<div class="row">
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_city_guide_row_wrap_end' ) ) {
	/**
	 * Hivepress vendor city_guide row wrap end.
	 */
	function finder_hivepress_vendor_city_guide_row_wrap_end() {
		?>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_city_guide_loop_column_wrap_start' ) ) {
	/**
	 * Hivepress vendor city_guide loop column wrap start.
	 */
	function finder_hivepress_vendor_city_guide_loop_column_wrap_start() {
		?>
		<div class="col-lg-9 col-md-8">	
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_city_guide_loop_column_wrap_end' ) ) {
	/**
	 * Hivepress vendor city_guide loop column wrap end.
	 */
	function finder_hivepress_vendor_city_guide_loop_column_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_city_guide_loop' ) ) {
	/**
	 * Hivepress vendor single loop.
	 */
	function finder_hivepress_vendor_single_city_guide_loop() {
		$args = array(
			'row_classes'    => 'row row-cols-md-2 row-cols-lg-3 row-cols-sm-2 row-cols-1 g-3 g-xl-4',
			'column_classes' => 'col pb-2',
			'template'       => 'hivepress/vendors/vendor-single/vendor-single-content/vendor-single-city-guide.php',
		);
		finder_hivepress_listings_loop( $args );
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_city_guide_sidebar_wrap_start' ) ) {
	/**
	 * Hivepress vendor single city guide sidebar wrap start.
	 */
	function finder_hivepress_vendor_single_city_guide_sidebar_wrap_start() {
		?>
		<aside class="col-lg-3 col-md-4 mb-lg-0 mb-4 pb-2 pe-xl-5">	
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_city_guide_sidebar_wrap_end' ) ) {
	/**
	 * Hivepress vendor single city guide sidebar wrap end.
	 */
	function finder_hivepress_vendor_single_city_guide_sidebar_wrap_end() {
		?>
		</aside>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_city_guide_sidebar' ) ) {
	/**
	 * Hivepress vendor city_guide sidebar.
	 *
	 * @param object $vendor vendor object.
	 */
	function finder_hivepress_vendor_city_guide_sidebar( $vendor ) {

		finder_hivepress_vendor_single_sidebar( $vendor );
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_city_guide_page_title' ) ) {
		/**
		 * Hivepress vendor city_guide page title.
		 *
		 * @param object $vendor vendor object.
		 */
	function finder_hivepress_vendor_city_guide_page_title( $vendor ) {

		?>

		<h1 class="hp-page__title h2 mb-sm-0"><?php echo sprintf( 'Listings by %s', esc_html( $vendor->get_name() ) ); ?></h1>	
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_breadcrumb' ) ) {
	/**
	 * Hivepress listings breadcrumb.
	 */
	function finder_hivepress_vendor_single_breadcrumb() {

		$vendor_single_style_acf = finder_acf_vendor_single_style();
		$vendor_style            = finder_hivepress_get_vendor_single_style();

		if ( finder_is_acf_activated() ) {

			if ( $vendor_single_style_acf && 'default' !== $vendor_single_style_acf ) {
				$vendor_style = $vendor_single_style_acf;
			}
		}

		if ( 'car-finder' === $vendor_style ) {

			$args = array(
				'style'     => 'light',
				'nav_class' => 'mb-4 pb-md-1 pt-md-3 mt-3',
			);

			finder_breadcrumb( $args );
		} elseif ( 'real-estate' === $vendor_style ) {

			$args = array(
				'nav_class' => 'mb-4 pt-md-3',
			);

			finder_breadcrumb( $args );
		} else {
			finder_breadcrumb();
		}
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_pagination' ) ) {
	/**
	 * Hivepress vendor single pagination.
	 */
	function finder_hivepress_vendor_single_pagination() {

		$vendor_style = finder_hivepress_get_vendor_single_style();
		$nav_classes  = 'mt-5';
		$ul_classes   = '';

		if ( 'car-finder' === $vendor_style ) {
			$nav_classes = ' mt-2';
			$ul_classes .= ' pagination-light';
		}

		finder_bootstrap_pagination( null, true, $nav_classes, $ul_classes );
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_page_header' ) ) {
	/**
	 * Hivepress vendor single real estate page header.
	 *
	 * @param object $vendor vendor object.
	 */
	function finder_hivepress_vendor_single_page_header( $vendor ) {

		finder_hivepress_vendor_single_page_title( $vendor );

	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_city_guide_page_header' ) ) {
	/**
	 * Hivepress vendor single city guide page header.
	 *
	 * @param object $vendor vendor object.
	 */
	function finder_hivepress_vendor_single_city_guide_page_header( $vendor ) {

		?>
		<div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch justify-content-between pb-4 mb-2 mb-md-3">
			<?php finder_hivepress_vendor_city_guide_page_title( $vendor ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_car_finder_page_header' ) ) {
	/**
	 * Hivepress vendor single car finder page header.
	 *
	 * @param object $vendor vendor object.
	 */
	function finder_hivepress_vendor_single_car_finder_page_header( $vendor ) {

		?>
		<div class="d-sm-flex align-items-center justify-content-between pb-4 mb-sm-2">
			<?php finder_hivepress_vendor_car_finder_page_title( $vendor ); ?>	
		</div>
		<?php
	}
}

/****************VENDOR SINGLE REAL ESTATE ATTRIBUTES*/

if ( ! function_exists( 'finder_hivepress_vendor_single_real_estate_attribute_contact_details' ) ) {
	/**
	 * Hivepress vendor single real estate attributes.
	 *
	 * @param array $vendor listing arguments.
	 * @param array $fields listing arguments.
	 */
	function finder_hivepress_vendor_single_real_estate_attribute_contact_details( $vendor, $fields ) {

		if ( $fields ) {
			?>
			<ul class="d-table list-unstyled mx-auto mx-md-0 mb-3 mb-md-4">
				<?php
				foreach ( $fields as $key => $field ) {

					$attribute_id         = finder_hivepress_get_vendor_attribute_id_by_slug( $field->get_slug() );
					$attribute_style      = finder_get_field( 'style', $attribute_id );
					$attribute_view_style = finder_get_field( 'real_estate_vendor_view_style', $attribute_id );

					if ( ! is_null( $field->get_value() ) ) {

						$display = $field->display();

						if ( 'contacts' === $attribute_view_style ) {
							?>
							<li class="mb-2 nav-link fw-normal p-0">
								<?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'single_vendor_icon_classes', $attribute_id ) ); ?>
							</li>
							<?php
						}
					}
				}
				?>
			</ul>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_real_estate_attributes_secondary_top' ) ) {
	/**
	 * Hivepress vendor single attributes.
	 *
	 * @param array $vendor listing arguments.
	 */
	function finder_hivepress_vendor_single_real_estate_attributes_secondary_top( $vendor ) {

		$fields = $vendor->_get_fields( 'view_page_secondary' );

		finder_hivepress_vendor_single_real_estate_attribute_contact_details( $vendor, $fields );
	}
}

/*************************VENDOR SINGLE CITY GUIDE ATTRIBUTES*/
if ( ! function_exists( 'finder_hivepress_vendor_single_city_guide_attribute_contact_details' ) ) {
	/**
	 * Hivepress vendor single city guide attributes.
	 *
	 * @param array $vendor listing arguments.
	 * @param array $fields listing arguments.
	 */
	function finder_hivepress_vendor_single_city_guide_attribute_contact_details( $vendor, $fields ) {

		if ( $fields ) {
			?>
			<ul class="nav flex-column mb-4 pb-lg-3">
				<?php
				foreach ( $fields as $key => $field ) {

					$attribute_id         = finder_hivepress_get_vendor_attribute_id_by_slug( $field->get_slug() );
					$attribute_style      = finder_get_field( 'style', $attribute_id );
					$attribute_view_style = finder_get_field( 'city_guide_vendor_view_style', $attribute_id );

					if ( ! is_null( $field->get_value() ) ) {

						$display = $field->display();

						if ( 'details' === $attribute_view_style ) {
							?>
							<li class="nav-item nav-link py-1 px-0 fs-sm fw-normal">
								<?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'single_vendor_icon_classes', $attribute_id ) ); ?>
							</li>
							<?php
						}
					}
				}
				?>
			</ul>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_city_guide_attributes_secondary_top' ) ) {
	/**
	 * Hivepress vendor single attributes.
	 *
	 * @param array $vendor listing arguments.
	 */
	function finder_hivepress_vendor_single_city_guide_attributes_secondary_top( $vendor ) {

		$fields = $vendor->_get_fields( 'view_page_secondary' );

		finder_hivepress_vendor_single_city_guide_attribute_contact_details( $vendor, $fields );
	}
}

/*************************VENDOR SINGLE CAR FINDER ATTRIBUTES*/
if ( ! function_exists( 'finder_hivepress_vendor_single_car_finder_attribute_contact_details' ) ) {
	/**
	 * Hivepress vendor single car finder attributes.
	 *
	 * @param array $vendor listing arguments.
	 * @param array $fields listing arguments.
	 */
	function finder_hivepress_vendor_single_car_finder_attribute_contact_details( $vendor, $fields ) {

		if ( $fields ) {
			?>
			<ul class="list-unstyled text-light py-2 mb-3">
				<?php
				foreach ( $fields as $key => $field ) {

					$attribute_id         = finder_hivepress_get_vendor_attribute_id_by_slug( $field->get_slug() );
					$attribute_style      = finder_get_field( 'style', $attribute_id );
					$attribute_view_style = finder_get_field( 'car_finder_vendor_view_style', $attribute_id );

					if ( ! is_null( $field->get_value() ) ) {

						if ( 'detail' === $attribute_view_style ) {
							?>
							<li>
								<strong><?php echo wp_kses_post( $field->get_label() ); ?></strong>
								<span class="opacity-70"> <?php echo wp_kses_post( $field->display() ); ?></span>
							</li>
							<?php
						}
					}
				}
				?>
			</ul>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_car_finder_attributes_secondary_top' ) ) {
	/**
	 * Hivepress vendor single attributes.
	 *
	 * @param array $vendor listing arguments.
	 */
	function finder_hivepress_vendor_single_car_finder_attributes_secondary_top( $vendor ) {

		$fields = $vendor->_get_fields( 'view_page_secondary' );

		finder_hivepress_vendor_single_car_finder_attribute_contact_details( $vendor, $fields );
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_car_finder_attribute_location_details' ) ) {
	/**
	 * Hivepress vendor single car fider attributes.
	 *
	 * @param array $vendor listing arguments.
	 * @param array $fields listing arguments.
	 */
	function finder_hivepress_vendor_single_car_finder_attribute_location_details( $vendor, $fields ) {

		if ( $fields ) {
			?>
			<p class="d-flex align-items-center text-light opacity-70">
				<?php
				foreach ( $fields as $key => $field ) {

					$attribute_id         = finder_hivepress_get_vendor_attribute_id_by_slug( $field->get_slug() );
					$attribute_style      = finder_get_field( 'style', $attribute_id );
					$attribute_view_style = finder_get_field( 'car_finder_vendor_view_style', $attribute_id );

					if ( ! is_null( $field->get_value() ) ) {

						$display = $field->display();

						if ( 'location' === $attribute_view_style ) {
							?>
								<span>
									<?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'single_vendor_icon_classes', $attribute_id ) ); ?>
								</span>
							<?php
						}
					}
				}
				?>
			</p>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_car_finder_attributes_page_top' ) ) {
	/**
	 * Hivepress vendor single attributes.
	 *
	 * @param array $vendor listing arguments.
	 */
	function finder_hivepress_vendor_single_car_finder_attributes_page_top( $vendor ) {

		$fields = $vendor->_get_fields( 'view_page_primary' );

		finder_hivepress_vendor_single_car_finder_attribute_location_details( $vendor, $fields );
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_car_finder_attribute_button' ) ) {
	/**
	 * Hivepress vendor single car finder attributes.
	 *
	 * @param array $vendor listing arguments.
	 * @param array $fields listing arguments.
	 */
	function finder_hivepress_vendor_single_car_finder_attribute_button( $vendor, $fields ) {

		if ( $fields ) {
			?>
				<?php
				foreach ( $fields as $key => $field ) {

					$attribute_id         = finder_hivepress_get_vendor_attribute_id_by_slug( $field->get_slug() );
					$attribute_style      = finder_get_field( 'style', $attribute_id );
					$attribute_view_style = finder_get_field( 'car_finder_vendor_view_style', $attribute_id );
					$display              = $field->display();

					if ( ! is_null( $field->get_value() ) ) {

						if ( 'button' === $attribute_view_style ) {
							?>
								<button class="btn btn-outline-light btn-lg px-4 mb-4" type="button">
									<?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'single_vendor_icon_classes', $attribute_id ) ); ?>
								</button>
							<?php
						}
					}
				}
				?>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_vendor_single_car_finder_attributes_page_bottom' ) ) {
	/**
	 * Hivepress vendor single attributes.
	 *
	 * @param array $vendor listing arguments.
	 */
	function finder_hivepress_vendor_single_car_finder_attributes_page_bottom( $vendor ) {

		$fields = $vendor->_get_fields( 'view_page_secondary' );

		finder_hivepress_vendor_single_car_finder_attribute_button( $vendor, $fields );
	}
}


if ( ! function_exists( 'finder_display_vendor_social_links' ) ) {
	/**
	 * Hivepress vendor single social links.
	 *
	 * @param array $vendor vendor arguments.
	 */

	function finder_display_vendor_social_links( $vendor ) {
		if ( class_exists('HivePress\Blocks\Social_Links') ) {
			$social_links_block = new Finder_Social_Links();
			$social_links_block->finder_set_model('vendor');
			
			$social_links_block->finder_set_context('vendor', $vendor);
			// print_r($social_links_block->get_context('vendor'));
			$vendor_style = finder_hivepress_get_vendor_single_style();
			$title_class = 'text-dark';
			$classes    = 'py-3';
			$wrap_class = 'mb-3';
			$wrap_class .= ' finder-hivepress-social-links finder-' . $vendor_style . '-social-links';

			if ('city-guide' === $vendor_style ) {
				$classes    = '';
				$wrap_class .= ' mt-3 pt-3';
			} 
			if ('car-finder' === $vendor_style ) {
				$title_class = 'text-light';
			}
			// Call the render() method to generate the HTML output
			$html_output = $social_links_block->render();
			?>
			<div class="<?php echo esc_attr( $wrap_class ); ?>">
				<div class="<?php echo esc_attr( $classes ); ?>">
				<?php echo wp_kses_post( $html_output ); ?>
				</div>
			</div>
			<?php
		}
	}
}
