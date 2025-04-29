<?php
/**
 * Finder HivePress Listings Template Functions
 *
 * @package Finder
 */

use HivePress\Blocks\Listings;
use HivePress\Forms\Review_Submit;
use HivePress\Models\Review;
use HivePress\Blocks\Favorite_Toggle;
use Hivepress\Models\Listing;
use HivePress\Forms\Message_Send;
use HivePress\Blocks\Message_Send_Form;
use HivePress\Forms\Listing_Report;
use HivePress\Forms\Listing_Claim_Submit;

if ( ! function_exists( 'finder_hivepress_listing_single_version' ) ) {
	/**
	 * Display hivepress listings single version.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_version( $listing ) {

		$listing_single_style = finder_hivepress_get_listing_single_style();

		$listing_args = array(
			'listing' => $listing,
		);

		finder_get_template( 'hivepress/listing-single/listing-single-' . $listing_single_style . '.php', $listing_args );
	}

/**************************************** The functons related to real estate atrributes -- START  */

if ( ! function_exists( 'finder_hivepress_listing_single_real_estate_attribute_default' ) ) {
	/**
	 * Hivepress listing single attributes.
	 *
	 * @param array $listing listing arguments.
	 * @param array $fields listing arguments.
	 */
	function finder_hivepress_listing_single_real_estate_attribute_default( $listing, $fields ) {

		if ( $fields ) {
			foreach ( $fields as $key => $field ) {

				if ( ! is_null( $field->get_value() ) ) {
					?>
					<p class="mb-2"><?php echo wp_kses_post( $field->display() ); ?></p>
					<?php
				}
			}
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_real_estate_attribute_location' ) ) {
	/**
	 * Hivepress listing single attributes.
	 *
	 * @param array $listing listing arguments.
	 * @param array $fields listing arguments.
	 */
	function finder_hivepress_listing_single_real_estate_attribute_location( $listing, $fields ) {

		if ( $fields ) {
			foreach ( $fields as $key => $field ) {

				$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
				$attribute_style      = finder_get_field( 'style', $attribute_id );
				$attribute_view_style = finder_get_field( 'real_estate_view_style', $attribute_id );

				if ( ! is_null( $field->get_value() ) ) {

					$display = $field->display();

					if ( 'location' === $attribute_view_style ) {
						?>
						<p class="mb-2 pb-1 fs-lg"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'single_listing_icon_classes', $attribute_id ) ); ?></p>
						<?php
					}
				}
			}
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_real_estate_attribute_price' ) ) {
	/**
	 * Hivepress listing single attributes.
	 *
	 * @param array $listing listing arguments.
	 * @param array $fields listing arguments.
	 */
	function finder_hivepress_listing_single_real_estate_attribute_price( $listing, $fields ) {

		if ( $fields ) {
			foreach ( $fields as $key => $field ) {

				$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
				$attribute_style      = finder_get_field( 'style', $attribute_id );
				$attribute_view_style = finder_get_field( 'real_estate_view_style', $attribute_id );

				if ( ! is_null( $field->get_value() ) ) {

					if ( 'price' === $attribute_view_style ) {
						?>
						<h2 class="h3 mb-4 pb-4 border-bottom">
							<?php echo wp_kses_post( $field->display() ); ?>
						</h2>
						<?php
					}
				}
			}
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_real_estate_attribute_badge' ) ) {
	/**
	 * Hivepress listing single attributes.
	 *
	 * @param array $listing listing arguments.
	 * @param array $fields listing arguments.
	 * @param null  $badge_value listing arguments.
	 */
	function finder_hivepress_listing_single_real_estate_attribute_badge( $listing, $fields, $badge_value = null ) {

		if ( $fields ) {
			foreach ( $fields as $key => $field ) {

				$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
				$attribute_style      = finder_get_field( 'style', $attribute_id );
				$attribute_view_style = finder_get_field( 'real_estate_view_style', $attribute_id );

				if ( ! is_null( $field->get_value() ) ) {

					if ( 'badge' === $attribute_view_style ) {
						?>
						<span class="badge bg-info me-2 mb-3">
							<?php echo wp_kses_post( $field->display() ); ?>
						</span>
						<?php
					}
				}
			}
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_real_estate_attribute_icon' ) ) {
	/**
	 * Hivepress listing single attributes.
	 *
	 * @param array $listing listing arguments.
	 * @param array $fields listing arguments.
	 */
	function finder_hivepress_listing_single_real_estate_attribute_icon( $listing, $fields ) {
		if ( $fields ) {

				$args  = array(
					'location'   => 'view_page_primary',
					'key'        => 'real_estate_view_style',
					'attr_style' => 'icon',
				);
				$count = finder_hivepress_attribute_count( $listing, $args );
				$i     = 1;
				foreach ( $fields as $field ) {

					$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
					$attribute_style      = finder_get_field( 'style', $attribute_id );
					$attribute_view_style = finder_get_field( 'real_estate_view_style', $attribute_id );
					$display              = $field->display();

					if ( ! is_null( $field->get_value() ) ) {

						if ( 'icon' === $attribute_view_style ) {
							if ( 1 === $i ) {
								?>
								<ul class="d-flex mb-4 list-unstyled">
								<?php
							}
							$border_class = $count === $i ? '' : ' border-end';
							?>
							<li class="me-3 pe-3<?php echo esc_attr( $border_class ); ?>"><b>
								<?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'single_listing_icon_classes', $attribute_id ) ); ?></b>
							</li>
							<?php
							if ( $i === $count ) {
								?>
								</ul>
								<?php
							}
							$i++;
						}
					}
				}
				?>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_real_estate_attributes_primary_top' ) ) {
	/**
	 * Hivepress listing single attributes.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_real_estate_attributes_primary_top( $listing ) {

		$fields = $listing->_get_fields( 'view_page_primary' );

		if ( ! finder_is_acf_activated() ) {
			finder_hivepress_listing_single_real_estate_attribute_default( $listing, $fields );
			return;
		}

		finder_hivepress_listing_single_real_estate_attribute_location( $listing, $fields );
		finder_hivepress_listing_single_real_estate_attribute_badge( $listing, $fields );
		finder_hivepress_listing_single_real_estate_attribute_price( $listing, $fields );
		
		// Tambahkan tombol booking dan konsultasi di sini, setelah harga dan sebelum deskripsi
		//finder_hivepress_add_booking_buttons( $listing );
	}
}

if ( ! function_exists( 'finder_hivepress_listing_geo_location' ) ) {
	/**
	 * Hivepress listing single geolocation.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_geo_location( $listing ) {
		if ( $listing->get_location() ) :

			$url = hivepress()->router->get_url(
				'location_view_page',
				array(
					'latitude'  => $listing->get_latitude(),
					'longitude' => $listing->get_longitude(),
				)
			);

			?>
				<p class="hp-listing__location mb-2 pb-1 fs-lg">
				<?php if ( get_option( 'hp_geolocation_hide_address' ) ) : ?>
					<span><?php echo esc_html( $listing->get_location() ); ?></span>
				<?php else : ?>
					<a href="<?php echo esc_url( $url ); ?>" target="_blank"><?php echo esc_html( $listing->get_location() ); ?></a>
				<?php endif; ?>
			</p>
			<?php
		endif;
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_real_estate_attributes_primary_bottom' ) ) {
	/**
	 * Hivepress listing single attributes.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_real_estate_attributes_primary_bottom( $listing ) {

		$fields = $listing->_get_fields( 'view_page_primary' );

		if ( ! finder_is_acf_activated() ) {
			return;
		}

		finder_hivepress_listing_single_real_estate_attribute_icon( $listing, $fields );
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_real_estate_attributes_secondary_top' ) ) {
	/**
	 * Hivepress listing single attributes.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_real_estate_attributes_secondary_top( $listing ) {

		$fields = $listing->_get_fields( 'view_page_secondary' );

		if ( ! finder_is_acf_activated() ) {
			finder_hivepress_listing_single_real_estate_attribute_default( $listing, $fields );
			return;
		}

		finder_hivepress_listing_single_real_estate_attribute_badge( $listing, $fields );
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_real_estate_attributes_secondary_bottom' ) ) {
	/**
	 * Hivepress listing single attributes.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_real_estate_attributes_secondary_bottom( $listing ) {

		$fields = $listing->_get_fields( 'view_page_secondary' );

		if ( ! finder_is_acf_activated() ) {
			return;
		}

		finder_hivepress_listing_single_real_estate_attribute_location( $listing, $fields );
		finder_hivepress_listing_single_real_estate_attribute_price( $listing, $fields );
		finder_hivepress_listing_single_real_estate_attribute_icon( $listing, $fields );
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_related_post' ) ) {
	/**
	 * Hivepress listing single related listing.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_related_post( $listing ) {

		if ( ! finder_hivepress_is_related_listing_enabled() ) {
			return;
		}

		$related_style = finder_hivepress_get_listing_single_style();

		$realted_query_args = array(
			'status'     => 'publish',
			'id__not_in' => array( $listing->get_id() ),
		);

		// Set categories.
		if ( $listing->get_categories__id() ) {
			$realted_query_args['categories__in'] = $listing->get_categories__id();
		}

		// Query realted listings.
		$realted_query = new WP_Query(
			Hivepress\Models\Listing::query()->filter( $realted_query_args )->order( 'random' )->limit( get_option( 'hp_listings_related_per_page' ) )->get_args()
		);

		if ( 'real-estate' === $related_style ) {

			$carousel_args = apply_filters(
				'finder_related_listings_carousel_args',
				array(
					'items'      => 4,
					'responsive' => array(
						'0'   => array(
							'items' => 1,
						),
						'500' => array(
							'items' => 2,
						),
						'768' => array(
							'items' => 3,
						),
						'992' => array(
							'items' => 4,
						),

					),
				)
			);
		}

		if ( 'city-guide' === $related_style ) {

			$carousel_args = apply_filters(
				'finder_related_listings_carousel_args',
				array(
					'items'      => 3,
					'gutter'     => 24,
					'responsive' => array(
						'0'    => array(
							'items' => 1,
							'nav'   => true,
						),
						'500'  => array(
							'items' => 2,
						),
						'850'  => array(
							'items' => 3,
						),
						'1400' => array(
							'items' => 3,
							'nav'   => false,
						),

					),
				)
			);
		}

		if ( 'car-finder' === $related_style ) {

			$carousel_args = apply_filters(
				'finder_related_listings_carousel_args',
				array(
					'items'      => 3,
					'responsive' => array(
						'0'    => array(
							'items'  => 1,
							'gutter' => 16,
						),
						'500'  => array(
							'items'  => 2,
							'gutter' => 18,
						),
						'900'  => array(
							'items'  => 3,
							'gutter' => 20,
						),
						'1100' => array(
							'gutter' => 24,
						),

					),
				)
			);
		}

		$related_listing_text     = get_theme_mod( 'finder_related_single_listing_title_text', esc_html__( 'Recently viewed', 'finder' ) );
		$related_listing_text_acf = finder_hivepress_acf_get_related_listing_title();

		if ( $related_listing_text_acf ) {
			$related_listing_text = $related_listing_text_acf;
		}

		$related_listing_action_text     = get_theme_mod( 'finder_related_single_listing_link_text', esc_html__( 'View all', 'finder' ) );
		$related_listing_action_text_acf = finder_hivepress_acf_get_related_listing_action_text();

		if ( $related_listing_action_text_acf ) {
			$related_listing_action_text = $related_listing_action_text_acf;
		}

		$related_listing_action_text_url     = ! empty( get_theme_mod( 'finder_related_single_listing_link_text_url' ) ) ? get_theme_mod( 'finder_related_single_listing_link_text_url' ) : finder_hivepress_get_listings_page_url();
		$related_listing_action_text_url_acf = finder_hivepress_acf_related_listing_action_text_url();

		if ( $related_listing_action_text_url_acf ) {
			$related_listing_action_text_url = $related_listing_action_text_url_acf;
		}

		if ( $realted_query ) {

			switch ( $related_style ) {
				case 'real-estate':
					$wrap_class           = ' mb-3';
					$link_class           = '';
					$carousel_wrapper     = ' tns-nav-outside-flush mx-n2';
					$carousel_inner_class = ' row gx-4 mx-0 pt-3 pb-4';
					break;
				case 'city-guide':
					$wrap_class           = ' mb-4 pb-2';
					$link_class           = ' ms-sm-3';
					$carousel_wrapper     = ' mb-xxl-2';
					$carousel_inner_class = '';
					break;
				case 'car-finder':
					$carousel_wrapper     = ' tns-carousel-light';
					$carousel_inner_class = '';
					$link_class           = '';
					break;
			}
			if ( $realted_query->have_posts() ) {

				if ( 'real-estate' === $related_style ) {
					?>
					<section class="container mb-5 pb-2 pb-lg-4">
					<?php
				}
				if ( 'city-guide' === $related_style ) {
					?>
					<section class="container pb-5 mb-lg-4">
					<?php
				}

				if ( 'car-finder' === $related_style ) {
					?>
					<div class="d-flex align-items-center justify-content-between pt-5 pb-3 mt-md-4"> 
						<h2 class="h3 text-light"><?php echo esc_html( $related_listing_text ); ?></h2>
						<a class="btn btn-link text-light fw-normal p-0<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $related_listing_action_text_url ); ?>">
							<?php echo esc_html( $related_listing_action_text ); ?>
							<i class="fi-arrow-long-right ms-2 text-light"></i>
						</a>
					</div>
					<?php
				} else {
					?>
						<div class="d-flex align-items-center justify-content-between <?php echo esc_attr( $wrap_class ); ?>"> 
							<h2 class="h3 mb-0"><?php echo esc_html( $related_listing_text ); ?></h2>
							<a class="btn btn-link fw-normal p-0<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $related_listing_action_text_url ); ?>">
					<?php echo esc_html( $related_listing_action_text ); ?>
								<i class="fi-arrow-long-right ms-2"></i>
							</a>
						</div>
						<?php
				}
				?>
				<div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside<?php echo esc_attr( $carousel_wrapper ); ?>">
					<div class="tns-carousel-inner<?php echo esc_attr( $carousel_inner_class ); ?>" data-carousel-options="<?php echo esc_attr( wp_json_encode( $carousel_args ) ); ?>">
						<?php
						while ( $realted_query->have_posts() ) {
							$realted_query->the_post();

							// Get realted listing.
							$realted_listing = Listing::query()->get_by_id( get_post() );

							if ( $realted_listing ) {

								$realted_listing_args = array(
									'listing' => $realted_listing,
								);

								finder_get_template( 'hivepress/listing-single/related-listings/related-listings-' . $related_style . '.php', $realted_listing_args );
							}
						}
						?>
					</div>
				</div>
				<?php
				if ( 'real-estate' === $related_style ) {
					?>
					</section>
					<?php
				}
				if ( 'city-guide' === $related_style ) {
					?>
					</section>
					<?php
				}
			}
		}
	}
}

if ( ! function_exists( 'finder_hivepress_add_booking_buttons' ) ) {
    /**
     * Menambahkan tombol booking dan konsultasi di bawah harga, tepat sebelum deskripsi
     *
     * @param array $listing Objek listing
     */
    function finder_hivepress_add_booking_buttons( $listing ) {
        // Ambil data listing
        $listing_id = $listing->get_id();
        $listing_title = $listing->get_title();
        $listing_price = $listing->get_meta('price');
        $listing_url = get_permalink($listing_id);
        
        // Encode parameter untuk dibawa ke booking.html
        $booking_params = http_build_query([
            'id' => $listing_id,
            'title' => urlencode($listing_title),
            'price' => $listing_price,
            'url' => urlencode($listing_url)
        ]);
        
        // URL Booking dengan parameter absolut
        $booking_url = 'https://homeart.id/booking.html?' . $booking_params;
        
        // Format pesan WhatsApp
        $whatsapp_message = rawurlencode(
            "Halo, saya ingin konsultasi \n" .
            "Judul Layanan: " . $listing_title . "\n" .
            "Harga: Rp " . number_format($listing_price, 0, ',', '.') . "\n" .
            "Link Listing: " . $listing_url . "\n"
        );
        
        // URL WhatsApp
        $whatsapp_url = 'https://wa.me/6281236937200?text=' . $whatsapp_message;
        ?>
        
<!-- Tombol Booking dan Konsultasi - Hanya tampil di Desktop -->
        <div class="booking-buttons-container mb-4 pb-3 d-none d-md-block">
            <div class="d-flex justify-content-start gap-3">
                <a href="<?php echo esc_url($booking_url); ?>" 
                   class="btn btn-booking">
                    <i class="fi-calendar me-2"></i>Booking Sekarang
                </a>
                <a href="<?php echo esc_url($whatsapp_url); ?>" 
                   class="btn btn-whatsapp" 
                   target="_blank"
                   rel="noopener noreferrer">
                    <i class="fi-whatsapp me-2"></i>Konsultasi
                </a>
            </div>
        </div>

        <!-- Tombol Floating Mobile - Hanya tampil di Mobile -->
        <div class="mobile-buttons fixed-bottom d-md-none p-3 bg-white shadow-lg">
            <div class="d-flex gap-2">
                <a href="<?php echo esc_url($booking_url); ?>" 
                   class="btn btn-booking flex-grow-1 py-3">
                    <i class="fi-calendar me-2"></i>Booking
                </a>
                <a href="<?php echo esc_url($whatsapp_url); ?>" 
                   class="btn btn-whatsapp flex-grow-1 py-3" 
                   target="_blank"
                   rel="noopener noreferrer">
                    <i class="fi-whatsapp me-2"></i>Chat
                </a>
            </div>
        </div>

        <style>
            /* Style Tombol */
            .btn-booking {
                background: #000;
                color: #fff;
                border: 2px solid #000;
                border-radius: 8px;
                transition: all 0.3s;
                padding: 10px 20px;
                font-weight: 500;
            }
            
            .btn-whatsapp {
                background: rgb(252, 252, 252);
                color: #000;
                border: 2px solid rgb(11, 12, 12);
                border-radius: 8px;
                transition: all 0.3s;
                padding: 10px 20px;
                font-weight: 500;
            }

            /* Hover Effects */
            .btn-booking:hover {
                background: #333;
                border-color: #333;
                color: #fff;
            }
            
            .btn-whatsapp:hover {
                background: #128C7E;
                border-color: #128C7E;
                color: #fff;
            }
            
            /* Mobile Floating Style */
            .mobile-buttons {
                z-index: 9999;
                bottom: 0;
                left: 0;
                right: 0;
                transform: translateY(0);
                transition: transform 0.3s;
                box-shadow: 0 -4px 12px rgba(0,0,0,0.1);
                border-top-left-radius: 16px;
                border-top-right-radius: 16px;
            }
        </style>
        <?php
    }
}
}

if ( ! function_exists( 'finder_hivepress_listing_single_breadcrumb' ) ) {
	/**
	 * Hivepress listings breadcrumb.
	 */
	function finder_hivepress_listing_single_breadcrumb() {

		$style = finder_hivepress_get_listing_single_style();

		if ( 'car-finder' === $style ) {
			$args = array(
				'style'     => 'light',
				'nav_class' => 'mb-3 pt-md-3',
			);

			finder_breadcrumb( $args );
		} else {
			finder_breadcrumb();
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_title' ) ) {
	/**
	 * Hivepress listing single title.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_title( $listing ) {
		$style = finder_hivepress_get_listing_single_style();

		switch ( $style ) {
			case 'real-estate':
				$title_class = ' mb-2';
				break;
			case 'city-guide':
				$title_class = ' me-3 mb-sm-0';
				break;
			case 'car-finder':
				$title_class = ' text-light mb-md-0';
				break;
		}
		?>
		<h1 class="h2 finder-hp-listing-single-title<?php echo esc_attr( $title_class ); ?>"><?php echo esc_html( $listing->get_title() ); ?></h1>
		<?php
	}
}

/* The functons related to real estate demo. */

if ( ! function_exists( 'finder_hivepress_listing_single_features_wrap_start' ) ) {
	/**
	 * Hivepress listing single wrap start.
	 */
	function finder_hivepress_listing_single_features_wrap_start() {
		$style         = finder_hivepress_get_listing_single_style();
		$wrapper_class = ( 'car-finder' === $style ) ? ' pt-3 pt-sm-0' : '';
		?>
		<div class="text-nowrap<?php echo esc_attr( $wrapper_class ); ?>">
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_add_to_wishlist' ) ) {
	/**
	 * Hivepress listing single wishlist.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_add_to_wishlist( $listing ) {

		$style = finder_hivepress_get_listing_single_style();

		if ( finder_is_hivepress_favorites_activated() ) :
			$fav_args = array(
				'view'       => 'icon',
				'icon'       => 'heart fi-heart',
				'url'        => hivepress()->router->get_url( 'listing_favorite_action', array( 'listing_id' => $listing->get_id() ) ),
				'attributes' => array(
					'class'          => 'btn btn-icon btn-' . esc_attr( 'car-finder' === $style ? 'translucent-' : '' ) . 'light btn-xs' . esc_attr( 'car-finder' !== $style ? ' text-body' : '' ) . ' shadow-sm rounded-circle ms-2 mb-2 hp-listing__action hp-listing__action--favorite',
					'data-bs-toggle' => 'modal',
				),
				'context'    => array(
					'listing' => $listing,
				),
			);

			$fav_toggle = new Favorite_Toggle( $fav_args );

			echo wp_kses_post( str_replace( 'fas fa-', '', $fav_toggle->render() ) );
		endif;
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_social_share' ) ) {
	/**
	 * Hivepress listing single social share.
	 */
	function finder_hivepress_listing_single_social_share() {

		$style = finder_hivepress_get_listing_single_style();

		?>
		<div class="dropdown d-inline-block" data-bs-toggle="tooltip" data-bs-original-title="Share">
			<button class="btn btn-icon btn-<?php echo esc_attr( 'car-finder' === $style ? 'translucent-light' : 'light-primary' ); ?> btn-xs shadow-sm rounded-circle ms-2 mb-2" type="button" data-bs-toggle="dropdown"><i class="fi-share"></i></button>
			<div class="dropdown-menu dropdown-menu-end my-1">
				<?php
				$services = Finder_SocialShare::get_share_services();
				foreach ( $services as $service ) :
					if ( ! isset( $service['share'] ) ) {
						continue; }
					?>
					<a href="<?php echo esc_url( $service['share'] ); ?>" class="dropdown-item" target="_blank" rel="noopener noreferrer">
						<?php if ( isset( $service['icon'] ) ) : ?>
							<i class="fs-base opacity-75 me-2 <?php echo esc_attr( $service['icon'] ); ?>"></i><?php echo esc_html( $service['name'] ); ?>
						<?php endif; ?>
					</a>
					<?php
				endforeach;
				?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_features_wrap_end' ) ) {
	/**
	 * Hivepress listing single wrap end.
	 */
	function finder_hivepress_listing_single_features_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_gallery_item' ) ) {
	/**
	 * Hivepress listing single gallery item.
	 *
	 * @param string $image_url image url.
	 * @param string $image_classes image classes.
	 * @param string $image_caption image caption.
	 */
	function finder_hivepress_listing_single_gallery_item( $image_url, $image_classes, $image_caption ) {
		if ( get_option( 'hp_listing_enable_image_zoom' ) ) :
			?>
			<a class="<?php echo esc_attr( $image_classes ); ?>" href="<?php echo esc_url( $image_url ); ?>" data-sub-html="<h6 class=&quot;fs-sm text-light&quot;><?php echo esc_html( $image_caption ); ?></h6>">
		<?php else : ?>
			<div class="<?php echo esc_attr( $image_classes ); ?>">
		<?php endif; ?>
			<img src="<?php echo esc_attr( $image_url ); ?>" class="w-full h-full object-center object-cover"alt="<?php echo esc_attr( $image_caption ); ?>">
		<?php if ( get_option( 'hp_listing_enable_image_zoom' ) ) : ?>
			</a>
		<?php else : ?>
			</div>
			<?php
		endif;
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_gallery' ) ) {
	/**
	 * Hivepress listing single gallery.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_gallery( $listing ) {

		$listing_images_ids = $listing->get_images__id();
		$listing_images = array();
		if ( $listing_images_ids ) {
			foreach( $listing_images_ids as $listing_images_id ) {
				$listing_images[] = wp_get_attachment_image_url( $listing_images_id, 'full' );
			}
		}

		$gallery_attr = array(
			'class' => 'finder-hp-listing-single-images row g-2 g-md-3',
			'style' => 'min-width: 30rem;',
		);

		if ( get_option( 'hp_listing_enable_image_zoom' ) ) {
			$gallery_attr['class']          .= ' gallery gallery-js';
			$gallery_attr['data-thumbnails'] = 'true';
		} else {
			$gallery_attr['class'] .= ' finder-gallery-zoom-diabled';
		}

		$i = 1;
		?>
		<?php
		if ( $listing_images ) {

			$post_style = finder_hivepress_get_listing_single_style();

			$container_class = ( 'city-guide' === $post_style ) ? ' mb-5' : ' mb-4 pb-3';
			?>
			<div class="container overflow-auto <?php echo esc_attr( $container_class ); ?>" data-simplebar>
				<div <?php finder_render_attr( 'listing_single_gallery_attr', $gallery_attr ); ?>>
					<?php foreach ( $listing_images as $image_url ) : ?>
						<?php
							$image_classes = 'gallery-item';

						if ( 1 === $i || 2 === $i || 3 === $i ) {
							$image_classes .= ' aspect-ratio aspect-w-10 aspect-h-7 rounded rounded-md-3';
						}

						if ( 2 === $i ) {
							$image_classes .= ' mb-2 mb-md-3';
						}

						if ( 3 < $i ) {
							$image_classes .= ' aspect-ratio aspect-w-10 aspect-h-6 rounded-1 rounded-md-2';
						}

							$image_caption = wp_get_attachment_caption( isset( $listing->get_images()[ $i - 1 ] ) ? $listing->get_images()[ $i - 1 ]->get_id() : 0 );


							if ( 1 === $i ) {
								?>
								<div class="col-8">
								<?php
							}

							if ( 2 === $i ) {
								?>
								<div class="col-4">
								<?php
							}

							if ( 4 === $i ) {
								?>
								<div class="col-12"><div class="row g-2 g-md-3">
								<?php
							}

							if ( $i >= 4 ) {
								?>
								<div class="col">
								<?php
							}

							finder_hivepress_listing_single_gallery_item( $image_url, $image_classes, $image_caption );

							if ( 1 === $i || ( count( $listing_images ) >= 3 && 3 === $i ) || ( count( $listing_images ) < 3 && 2 === $i ) ) {
								?>
								</div>
								<?php
							}

							if ( 8 === $i && ( count( $listing_images ) >= 8 ) ) {
								?>
								</div></div>
								<?php
							}
							if ( count( $listing_images ) === $i && ( count( $listing_images ) < 8 && count( $listing_images ) > 3 ) ) {
								?>
								</div></div>
								<?php
							}

							if ( $i >= 4 ) {
								?>
								</div>
								<?php
							}
						?>
						<?php $i++; ?>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_verified_badge' ) ) {
	/**
	 * Hivepress listing single verified badge.
	 *
	 * @param object $listing listing object.
	 * @param string $badge_class badge classes.
	 */
	function finder_hivepress_listing_single_verified_badge( $listing, $badge_class = 'badge bg-success me-2 mb-3' ) {

		$verified_text = esc_html__( 'Verified', 'finder' );

		if ( $listing->is_verified() ) {
			?>
			<span class="<?php echo esc_attr( $badge_class ); ?>"><?php echo esc_html( $verified_text ); ?></span>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_featured_badge' ) ) {
	/**
	 * Hivepress listing single featured badge.
	 *
	 * @param object $listing listing object.
	 * @param string $badge_class badge classes.
	 */
	function finder_hivepress_listing_single_featured_badge( $listing, $badge_class = 'badge bg-info me-2 mb-3' ) {

		if ( $listing->is_featured() ) {
			?>
			<span class="<?php echo esc_attr( $badge_class ); ?>"><?php esc_html_e( 'Featured', 'finder' ); ?></span>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_meta' ) ) {
	/**
	 * Hivepress listing single post meta.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_meta( $listing ) {

		global $post;
		$border_class   = ! empty( $post->post_content ) && isset( $post->post_content ) ? ' border-top' : '';
		$post_meta_text = esc_html__( 'Published:', 'finder' );

		?>
		<div class="mb-lg-5 mb-md-4 pb-lg-2 py-4<?php echo esc_attr( $border_class ); ?>">
			<ul class="d-flex mb-4 list-unstyled fs-sm">
				<li class="me-3 pe-3"><?php echo esc_html( $post_meta_text ); ?> <b><?php echo esc_html( $listing->display_created_date() ); ?></b></li>
			</ul>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_post_content' ) ) {
	/**
	 * Hivepress listing single post meta.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_post_content( $listing ) {

		?>
		<?php the_content(); ?>
		<?php

	}
}

if ( ! function_exists( 'finder_hivepress_listing_single_review' ) ) {
	/**
	 * Hivepress listing single review.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_single_review( $listing ) {

		if ( ! finder_is_hivepress_reviews_activated() ) {
			return;
		}

		$post_style = finder_hivepress_get_listing_single_style();

		// Set query.
		$review_query = Review::query()->filter(
			array(
				'approved' => true,
				'listing'  => $listing->get_id(),
			)
		)->order( array( 'created_date' => 'desc' ) )
		->limit( 1000 );

		// Query reviews.
		$reviews = $review_query->get();

		$border_wrap_class = '';
		if ( ( 0 < $reviews->count() ) ) {
			$border_wrap_class = ( 'car-finder' === $post_style ) ? ' border-bottom border-light' : ' border-bottom';
		}
		$header_wrap_class = ( 'car-finder' === $post_style ) ? ' text-light' : '';
		?>
		<div id="reviews">
			<div class="mb-4 pb-4<?php echo esc_attr( $border_wrap_class ); ?>">
				<h3 class="h4 pb-3<?php echo esc_attr( $header_wrap_class ); ?>">
					<i class="fi-star-filled mt-n1 me-2 lead align-middle text-warning"></i>
					<?php
					echo wp_kses_post(
						sprintf(
							/* translators: 1: number of comments, 2: post title */
							esc_html( _nx( '%2$s ( %1$s Review )', '%2$s ( %1$s Reviews )', $listing->display_rating_count() ?? 0, 'review count', 'finder' ) ),
							number_format_i18n( $listing->display_rating_count() ?? 0 ),
							esc_html( $listing->display_rating() )
						)
					);
					
					?>
				</h3>
				<div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch justify-content-between">
					<?php

					$args = array(
						'fields' => array(
							'listing' => array(
								'display_type' => 'hidden',
								'value'        => $listing->get_id(),
							),
							'text'    => array(
								'attributes' => array(
									'rows' => 5,
								),
							),
						),
						'button' => array(
							'label'      => esc_html__( 'Submit a review', 'finder' ),
							'attributes' => array(
								'class' => array( 'btn btn-primary d-block w-100 mb-4 mt-4' ),
							),
						),
					);

					$listing_review = new Review_Submit( $args );

					$modal_id_reference = 'user_login_modal';
					if ( is_user_logged_in() ) {
						$modal_id_reference = 'review_submit';
					}

					$modal_content_class = ( 'car-finder' === $post_style ) ? ' bg-dark border-light' : '';
					$modal_title_class   = ( 'car-finder' === $post_style ) ? ' text-light' : '';
					?>
					<div class="modal fade listing-single-review-form<?php echo esc_attr( 'car-finder' === $post_style ? ' finder-form-dark' : '' ); ?>" id="review_submit" tabindex="-1" aria-modal="true" role="dialog">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content<?php echo esc_attr( $modal_content_class ); ?>">
								<div class="modal-header d-block position-relative border-0 pb-0 px-sm-5 px-4">
									<h3 class="modal-title mt-4 text-center<?php echo esc_attr( $modal_title_class ); ?>"><?php esc_html_e( 'Leave a review', 'finder' ); ?></h3>
									<button class="btn-close position-absolute top-0 end-0 mt-3 me-3<?php echo esc_attr( 'car-finder' === $post_style ? ' btn-close-white' : '' ); ?>" type="button" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'finder'); ?>"></button>
								</div>
								<div class="modal-body px-sm-5 px-4">
									<?php echo apply_filters( 'finder_listing_review_form_output', $listing_review->render() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							</div>
						</div>
					</div>
					<?php
					$button_class        = ( 'city-guide' === $post_style ) ? ' btn btn-outline-primary rounded-pill' : ' btn btn-outline-primary';
					$button_class        = ( 'car-finder' === $post_style ) ? ' btn btn-primary' : $button_class;
					$author_class        = ( 'car-finder' === $post_style ) ? ' text-light' : '';
					$review_border_class = ( 'car-finder' === $post_style ) ? ' border-light' : '';
					$review_date_class   = ( 'car-finder' === $post_style ) ? ' text-light opacity-50' : ' text-muted';
					?>
					<a class="mb-sm-0 mb-3<?php echo esc_attr( $button_class ); ?>" href="#<?php echo esc_attr( $modal_id_reference ); ?>" data-bs-toggle="modal" style="z-index: 1">
						<i class="fi-edit me-1"></i>
						<?php esc_html_e( 'Add review', 'finder' ); ?>
					</a>
				</div>
			</div>
			<?php if ( $reviews->count() ) : ?>
				<?php foreach ( $reviews as $review ) : ?>
					<!-- Review-->
					<div class="mb-4 pb-4 border-bottom<?php echo esc_attr( $review_border_class ); ?>">
						<div class="d-flex justify-content-between mb-3">
							<div class="d-flex align-items-center pe-2">
								<img class="rounded-circle me-1" src="<?php echo esc_url( get_avatar_url( $review->get_author__id() ) ); ?>" width="48" alt="<?php echo esc_attr( $review->get_author__display_name() ); ?>">
								<div class="ps-2">
									<h6 class="fs-base mb-0<?php echo esc_attr( $author_class ); ?>"><?php echo esc_html( $review->get_author__display_name() ); ?></h6>
									<span class="star-rating">
										<?php
										for ( $i = 1; $i <= 5; $i++ ) {
											$icon = ( $i <= $review->get_rating() ) ? 'fi-star-filled active' : 'fi-star';
											?>
											<i class="star-rating-icon <?php echo esc_attr( $icon ); ?>"></i>
											<?php
										}
										?>
									</span>
								</div>
							</div><span class="fs-sm<?php echo esc_attr( $review_date_class ); ?>"><?php echo esc_html( $review->display_created_date() ); ?></span>
						</div>
						<?php
						if ( 'car-finder' === $post_style ) {
							?>
							<div class="text-light opacity-70">
							<?php
						}
						comment_text( $review->get_id() );
						if ( 'car-finder' === $post_style ) {
							?>
							</div>
							<?php
						}
						?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listing_real_estate_vendor_block' ) ) {
	/**
	 * Hivepress listing single right sidebar.
	 *
	 * @param array $listing listing arguments.
	 */
	function finder_hivepress_listing_real_estate_vendor_block( $listing ) {

		if ( ! $listing->get_vendor() ) {
			return;
		}

		?>
		<div class="card shadow-sm mb-4">
			<div class="card-body hp-message-form">
				<div class="d-flex align-items-start justify-content-between">
					<a class="text-decoration-none" href="<?php echo esc_attr( get_permalink( $listing->get_vendor__id() ) ); ?>">
						<?php if ( $listing->get_vendor()->get_image__url() ) : ?>
							<img class="rounded-circle mb-2" src="<?php echo esc_url( $listing->get_vendor()->get_image__url() ); ?>" alt="<?php echo esc_attr( $listing->get_vendor()->get_name() ); ?>" loading="lazy" width="60">
						<?php else : ?>
							<img class="rounded-circle mb-2" src="<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/user-square.svg' ); ?>" alt="<?php echo esc_attr( $listing->get_vendor()->get_name() ); ?>" loading="lazy" width="60">
						<?php endif; ?>
						<h5 class="d-flex align-items-center mb-1">
							<?php echo esc_html( $listing->get_vendor()->get_name() ); ?>
							<?php if ( $listing->get_vendor()->is_verified() ) : ?>
								<i class="fi-check-circle text-success ms-2"></i>
							<?php endif; ?>
						</h5>
						<div class="mb-1">
							<?php if ( finder_is_hivepress_reviews_activated() && $listing->get_vendor()->get_rating() ) : ?>
								<span class="hp-rating__star hp-rating-stars star-rating" data-component="rating" data-value="<?php echo esc_attr( $listing->get_vendor()->get_rating() ); ?>"></span>
								<span class="ms-1 fs-sm text-muted">
									<?php
									echo esc_html(
										sprintf(
										/* translators: 1: number of reviews, 2: review count */
											esc_html( _nx( '(%1$s Review)', '(%1$s Reviews)', $listing->get_vendor()->display_rating_count(), 'review count', 'finder' ) ),
											number_format_i18n( $listing->get_vendor()->display_rating_count() )
										)
									);
									?>
								</span>	
							<?php endif; ?>	
						</div>
						<?php if ( $listing->get_vendor()->_get_fields( 'view_block_primary' ) ) : ?>
							<?php foreach ( $listing->get_vendor()->_get_fields( 'view_block_primary' ) as $field ) : ?>
								<?php
								$attribute_id = finder_hivepress_get_vendor_attribute_id_by_slug( $field->get_slug() );
								$display      = $field->display();
								?>
								<?php if ( ! is_null( $field->get_value() ) ) : ?>
									<p class="text-body">
										<?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_vendor_icon_classes', $attribute_id ) ); ?>
									</p>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</a>
				</div>
				<?php if ( $listing->get_vendor()->_get_fields( 'view_block_secondary' ) ) : ?>
					<ul class="list-unstyled border-bottom mb-4 pb-4">
						<?php foreach ( $listing->get_vendor()->_get_fields( 'view_block_secondary' ) as $field ) : ?>
							<?php
							$attribute_id = finder_hivepress_get_vendor_attribute_id_by_slug( $field->get_slug() );
							$display      = $field->display();
							?>
							<?php if ( ! is_null( $field->get_value() ) ) : ?>
								<li class="nav-link fw-normal p-0">
									<?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_vendor_icon_classes', $attribute_id ) ); ?>
								</li>				
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php
				if ( finder_is_hivepress_messages_activated() && is_user_logged_in() ) {

					$msg_forms = new Message_Send_Form();

					

					$msg_form_args = array(
						'attributes' => array(
							'data-reset' => 'true',
							
						),
						'fields'     => array(
							'text'      => array(
								'label'      => false,
								'attributes' => array(
									'rows'        => 3,
									'placeholder' => esc_html__( 'Message', 'finder' ),
								),
							),
							'listing'   => array(
								'display_type' => 'hidden',
								'value'        => $listing->get_id(),
							),
							'recipient' => array(
								'display_type' => 'hidden',
								'value'        => $listing->get_user__id(),
							),
						),
						'button'     => array(
							'label'      => esc_html__( 'kirim pesan', 'finder' ),
							'attributes' => array(
								'class' => array( 'btn', 'btn-primary', 'btn-lg', 'd-block', 'w-100' ),
							),
						),
					);

					if ( ! empty( $msg_forms->get_context()['message'] ) ) {
						$data_id = $msg_forms->get_context()['message']->get_id();
						$msg_form_args['attributes']['data-id'] = $data_id;
					}

					$msg_form = new Message_Send( $msg_form_args );

					echo apply_filters( 'finder_message_send_form_output', $msg_form->render() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_hivepress_listing_message_block' ) ) {
	    function finder_hivepress_listing_message_block( $listing, $id = 'm1' ) {
        // isi fungsi
    } // tutup fungsi
} // tutup if

	/**
	 * Hivepress listing single right sidebar message.
	 *
	 * @param array $listing listing arguments.
	 * @param string $id ID for modal.
	 */
	function finder_hivepress_listing_message_block( $listing , $id = 'm1'  ) {

		$post_style = finder_hivepress_get_listing_single_style();

		if ( ! class_exists('\HivePress\Blocks\Message_Send_Form')) {
			return;
		}
	
		$msg_forms = new Message_Send_Form();
		

		if ( finder_is_hivepress_messages_activated() ) {
			$msg_form_args = array(
				'attributes' => array(
					'class'      => array( 'modal-body' ),
					'data-reset' => 'true',
				),
				'fields'     => array(
					'text'      => array(
						'label'      => false,
						'attributes' => array(
							'rows'        => 3,
							'placeholder' => esc_html__( 'Message', 'finder' ),
						),
					),
					'listing'   => array(
						'display_type' => 'hidden',
						'value'        => $listing->get_id(),
					),
					'recipient' => array(
						'display_type' => 'hidden',
						'value'        => $listing->get_user__id(),
					),
				),
				'button'     => array(
					'label'      => esc_html__( 'Send message', 'finder' ),
					'attributes' => array(
						'class' => array( 'btn', 'btn-primary', 'mt-2', 'mb-2' ),
					),
				),
			);

			if ( ! empty( $msg_forms->get_context()['message'] ) ) {
				$data_id = $msg_forms->get_context()['message']->get_id();
				$msg_form_args['attributes']['data-id'] = $data_id;
			}
			

			$msg_form = new Message_Send( $msg_form_args );
			

			?>
			<div class="modal fade listing-message-form" id="message_send_modal_<?php echo esc_attr( $listing->get_id() . '_' . $id ); ?>" tabindex="-1" aria-modal="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="fs-base modal-title"><?php echo esc_html( sprintf( 'Reply to  %s', $listing->get_title() ) ); ?></h3>
							<button class="btn-close ms-0" type="button" data-bs-dismiss="modal"></button>
						</div>
						<?php echo apply_filters( 'finder_message_send_form_output', $msg_form->render() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
			</div>
			<?php
			$btn_class = ( 'car-finder' === $post_style ) ? ' btn btn-outline-light' : ' btn btn-outline-primary';
			?>
			<?php
					$url_attr = 'user_login_modal';

				if ( is_user_logged_in() ) {
					$url_attr = 'message_send_modal_' . $listing->get_id() . '_' . $id;
				}
				?>
			<button class="rounded mb-3<?php echo esc_attr( $btn_class ); ?>" type="button" data-bs-toggle="modal" data-bs-target="#<?php echo esc_attr( $url_attr); ?>"><i class="fi-reply me-2"></i><?php echo esc_html__( 'Reply to listing', 'finder' ); ?></button>
			<?php
		}
	}