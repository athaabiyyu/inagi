<?php
/**
 * Template functions related to Footer.
 *
 * @package Finder/TemplateFunctions/Footer
 */

/**
 * Display footer template.
 */
function finder_get_footer() {
	$footer_style = finder_get_footer_version();
	if ( 'default' === $footer_style ) {
		$footer_style = 'v6';
	}
	finder_get_template( 'footer/footer-' . $footer_style . '.php' );
}

if ( ! function_exists( 'footer_newsletter_form' ) ) {
	/**
	 * Display Single Post Newsletter
	 */
	function footer_newsletter_form() {

		$title             = get_theme_mod( 'footer_form_title', esc_html__( 'Subscribe to our newsletter', 'finder' ) );
		$footer_form_title = finder_footer_acf_form_title();
		$is_custom_footer  = finder_footer_acf_is_custom_footer();

 		$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}
		if ( finder_has_custom_footer( $fn_page_options ) ) {
			$footer_form_description = isset( $fn_page_options['footer']['finder_footer_form'] ) ? $fn_page_options['footer']['finder_footer_form'] : '';

		} elseif ( $is_custom_footer ) {
			$title = $footer_form_title;
		}

		$lead                    = get_theme_mod( 'footer_form_description', esc_html__( '*Subscribe to our newsletter to receive early discount offers, updates and new products info.', 'finder' ) );
		$footer_form_description = finder_footer_acf_form_description();

		if ( $is_custom_footer ) {
			$lead = $footer_form_description;
		}

		$form            = finder_sanitize_html( '<form class="subscription-form validate"><div class="form-group form-group-light rounded-pill"><div class="input-group flex-nowrap"><span class="input-group-text text-muted"><i class="fi-mail"></i></span><input class="form-control" type="email" name="EMAIL" placeholder="Your email" required></div><button class="btn btn-primary rounded-pill" type="submit" name="subscribe">Subscribe*</button></div></form>' );
		$footer_form_acf = finder_footer_acf_form();

		$form = get_theme_mod( 'footer_newsletter_subscription_form', $form );

		if ( $is_custom_footer ) {
			$form = $footer_form_acf;
		}

		if ( isset( $title ) && ! empty( $title ) ) : ?>			
			<h2 class="h3 text-light pb-3 footer-form-title"><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>
		<div class="row justify-content-center mb-5 pb-lg-3">
			<div class="col-lg-6 col-md-7 col-sm-9">
				<?php if ( ! empty( $form ) ) : ?>
					<div class="footer-form">
						<?php echo do_shortcode( $form ); ?>
					</div>
				<?php endif; ?>
				<?php if ( isset( $lead ) && ! empty( $lead ) ) : ?>
					<div class="form-text text-light fs-xs opacity-70 mt-3 footer-form-desc"><?php echo esc_html( $lead ); ?></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_get_copyright_html' ) ) {
	/**
	 * Get copyright HTML for the site.
	 *
	 * @return string
	 */
	function finder_get_copyright_html() {


		$is_custom_footer = finder_footer_acf_is_custom_footer();

		$default = sprintf(/* translators: footer copy  rights*/
			'<span class="text-light opacity-50">© All rights reserved. Made by </span><a class="nav-link-light fw-bold" href="https://madrasthemes.com" target="_blank" rel="noopener"> %s</a>',
			get_bloginfo( 'name' )
		);

		$footer_copyrights = finder_footer_acf_copyrights();

		$html = get_theme_mod( 'footer_copyright', $default );

		$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}
		if ( finder_has_custom_footer( $fn_page_options ) ) {
			$footer_copyrights = isset( $fn_page_options['footer']['finder_footer_copyrights'] ) ? $fn_page_options['footer']['finder_footer_copyrights'] : '';

		} 

		elseif ( $is_custom_footer ) {
			$html = $footer_copyrights;
		}

		return apply_filters( 'finder_footer_copyright', $html );
	}
}

if ( ! function_exists( 'finder_footer_404_copyright' ) ) {
	/**
	 * Displays footer 404 copyright wrap
	 */
	function finder_footer_404_copyright() {

		$default = '© 2021 Finder. All Rights Reserved';

		$copyright = apply_filters( 'finder_404_copyright', get_theme_mod( 'footer_copyright_text', $default ) );
		?>
		<div class="col-md-6 col-12 text-center text-md-start mb-3 mb-md-0">
			<span class="footer-copyright-text mb-0 text-muted"><?php echo wp_kses_post( $copyright ); ?></span>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_footer_social_media_links' ) ) {
	/**
	 * Displays social media links
	 */
	function finder_footer_social_media_links() {

		$footer_version = finder_get_footer_version();

		$anchor_class = array();

		if ( 'v4' === $footer_version ) {
			$anchor_class = 'btn btn-icon btn-translucent-light btn-xs rounded-circle me-2';
		} elseif ( 'v5' === $footer_version ) {
			$anchor_class = 'btn btn-icon btn-translucent-light btn-xs rounded-circle ms-2';
		}

		wp_nav_menu(
			array(
				'theme_location' => 'social_media',
				'container'      => false,
				'item_class'     => array( 'mb-0' ),
				'menu_class'     => 'nav',
				'anchor_class'   => array( $anchor_class ),
				'icon_class'     => array( 'nav-social-icon' ),
				'walker'         => new WP_Bootstrap_Navwalker(),
				'depth'          => 1,
				'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
			)
		);
	}
}

if ( ! function_exists( 'finder_footer_404_social_media_links' ) ) {
	/**
	 * Displays social media links
	 */
	function finder_footer_404_social_media_links() {

		$anchor_class = 'btn btn-icon shadow-sm me-2 btn-xs rounded-circle';

		wp_nav_menu(
			array(
				'theme_location' => 'social_media',
				'container'      => false,
				'menu_class'     => 'social-menu nav',
				'anchor_class'   => array( $anchor_class ),
				'walker'         => new WP_Bootstrap_Navwalker(),
				'depth'          => 1,
				'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
			)
		);
	}
}

if ( ! function_exists( 'finder_footer_404_social_media_links_wrap' ) ) {
	/**
	 * Displays footer 404 social media wrap
	 */
	function finder_footer_404_social_media_links_wrap() {
		?>
		<div class="col-md-6 col-12 d-flex justify-content-center justify-content-md-end mt-1 mt-md-0">
			<?php finder_footer_404_social_media_links(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_footer_links' ) ) {
	/**
	 *  Display Footer  links in Footer 5.
	 */
	function finder_footer_links() {

		$footer_version = finder_get_footer_version();

		$anchor_class = array();

		if ( 'v3' === $footer_version ) {
			$anchor_class = array( 'nav-link', 'nav-link-light', 'fw-normal' );
		} elseif ( 'v5' === $footer_version ) {
			$anchor_class = array( 'nav-link-light', 'px-2', 'mx-1' );
		}

		$args = apply_filters(
			'finder_footer_menu_args',
			array(
				'theme_location' => 'footer',
				'container'      => false,
				'item_class'     => array( 'mb-0' ),
				'menu_class'     => 'nav',
				'walker'         => new WP_Bootstrap_Navwalker(),
				'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
				'anchor_class'   => $anchor_class,
				'depth'          => 1,
			)
		);

		wp_nav_menu( $args );
	}
}

if ( ! function_exists( 'finder_footer_site_branding' ) ) {
	/**
	 * Footer Logo
	 */
	function finder_footer_site_branding() {
		finder_site_title_or_logo( true );
	}
}

if ( ! function_exists( 'finder_banner_image' ) ) {
	/**
	 *  Footer v2 Banner Image.
	 */
	function finder_banner_image() {
		$version              = finder_get_footer_version();
		$is_custom_footer     = finder_footer_acf_is_custom_footer();
		$footer_banner_images = finder_footer_acf_banner_images();
		$banner_image         = get_theme_mod( 'banner_image_option' );

		$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}
		if ( finder_has_custom_footer( $fn_page_options ) ) {
			$banner_image = isset( $fn_page_options['footer']['finder_footer_banner_image'] ) ? $fn_page_options['footer']['finder_footer_banner_image'] : '';

		} 


		elseif ( $is_custom_footer ) {
			$banner_image = $footer_banner_images;
		}

		if ( 'v2' === $version && $banner_image ) {
			?>
				<img class="flex-shrink-0 mt-md-n5 me-md-5" src="<?php echo esc_url( $banner_image ); ?>" width="240" alt="<?php esc_attr_e( 'Finder mobile app', 'finder' ); ?>">				
			<?php
		}
		if ( 'v4' === $version && $banner_image ) {
			?>
			<img class="d-none d-xl-block ms-n4" src="<?php echo esc_url( $banner_image ); ?>" width="116" alt="<?php esc_attr_e( 'Finder mobile app', 'finder' ); ?>">
			<?php
		}

	}
}

if ( ! function_exists( 'finder_footer_banner_title' ) ) {
	/**
	 * Display footer banner title.
	 */
	function finder_footer_banner_title() {
		$default             = apply_filters( 'finder_default_banner_title_text', 'Download Our App' );
		$is_custom_footer    = finder_footer_acf_is_custom_footer();
		$footer_banner_title = finder_footer_acf_banner_title();
		$html                = get_theme_mod( 'footer_banner_title', $default );

		$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}
		if ( finder_has_custom_footer( $fn_page_options ) ) {
			$footer_banner_title = isset( $fn_page_options['footer']['finder_footer_banner_title'] ) ? $fn_page_options['footer']['finder_footer_banner_title'] : '';

		} 


		elseif ( $is_custom_footer ) {
			$html = $footer_banner_title;
		}

		$version = finder_get_footer_version();

		if ( ! empty( $html ) ) :
			$title_class = '';

			if ( 'v2' === $version ) {
				$title_class = 'text-light';
				$tag         = 'h4';

			}
			if ( 'v4' === $version ) {
				$title_class = 'h4 text-light';
				$tag         = 'h3';
			}
			?>

			<<?php echo esc_html( $tag ); ?> class="<?php echo esc_attr( $title_class ); ?>"><?php echo wp_kses_post( $html ); ?></<?php echo esc_html( $tag ); ?>>
			<?php

		endif;
	}
}

if ( ! function_exists( 'finder_footer_banner_description' ) ) {
	/**
	 * Display site description in the footer.
	 */
	function finder_footer_banner_description() {

		$default          = apply_filters( 'finder_default_banner_description_text', esc_html__( 'Find everything you need for buying, selling & renting property in our new Finder App!', 'finder' ) );
		$is_custom_footer = finder_footer_acf_is_custom_footer();
		$html             = get_theme_mod( 'footer_banner_description', $default );

		$footer_banner_description = finder_footer_acf_banner_description();

		$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}
		if ( finder_has_custom_footer( $fn_page_options ) ) {
			$footer_banner_description = isset( $fn_page_options['footer']['finder_footer_banner_description'] ) ? $fn_page_options['footer']['finder_footer_banner_description'] : '';

		} 

		elseif ( $is_custom_footer ) {
			$html = $footer_banner_description;
		}

		$version = finder_get_footer_version();

		if ( ! empty( $html ) ) :
			$desc_class = '';

			if ( 'v2' === $version ) {
				$desc_class = 'mb-lg-0 text-light';
			}
			if ( 'v4' === $version ) {
				$desc_class = 'fs-sm text-light opacity-70 mb-2 mb-lg-3';
			}

			?>
			<p class="<?php echo esc_attr( $desc_class ); ?>"><?php echo wp_kses_post( $html ); ?></p>
			<?php

		endif;
	}
}

if ( ! function_exists( 'finder_banner_appstore_image' ) ) {
	/**
	 *  Footer v2,v4 Banner Button Image.
	 */
	function finder_banner_appstore_image() {
		$banner_appstore_image              = get_theme_mod( 'banner_appstore_image_option' );
		$banner_appstore_image_url          = get_theme_mod( 'banner_appstore_image_url', '#' );
		$footer_banner_app_store_images     = finder_footer_acf_banner_app_store_images();
		$footer_banner_app_store_images_url = finder_footer_acf_banner_app_store_images_url();
		$is_custom_footer                   = finder_footer_acf_is_custom_footer();

		$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}
		if ( finder_has_custom_footer( $fn_page_options ) ) {
			$footer_banner_appstore_image = isset( $fn_page_options['footer']['finder_footer_banner_app_store_image'] ) ? $fn_page_options['footer']['finder_footer_banner_app_store_image'] : '';

		} 

		elseif ( $is_custom_footer ) {
			$banner_appstore_image = $footer_banner_app_store_images;
		}

		if ( $is_custom_footer ) {
			$banner_appstore_image_url = $footer_banner_app_store_images_url;
		}

		$version = finder_get_footer_version();

		if ( $banner_appstore_image ) {
			if ( 'v2' === $version ) {
				?>
			<a class="btn-market mx-2 ms-sm-0 me-sm-4 mb-3" href="<?php echo esc_url( $banner_appstore_image_url ); ?>" role="button">
				<?php
			}
			if ( 'v4' === $version ) {
				?>
			<a class="btn-market me-sm-3 mt-3" href="<?php echo esc_url( $banner_appstore_image_url ); ?>" role="button">
				<?php
			}
			?>
				<img  src="<?php echo esc_url( $banner_appstore_image ); ?>"  alt="<?php esc_attr_e( 'Finder mobile app', 'finder' ); ?>">				
			<?php
			if ( 'v4' === $version || 'v2' === $version ) {
				?>
				</a>
				<?php
			}
		}
	}
}

if ( ! function_exists( 'finder_banner_googleplay_image' ) ) {
	/**
	 *  Footer v2,v4 Banner Button Image.
	 */
	function finder_banner_googleplay_image() {
		$banner_googleplay_image         = get_theme_mod( 'banner_googleplay_image_option' );
		$banner_googleplay_image_url     = get_theme_mod( 'banner_googleplay_image_url', '#' );
		$footer_banner_google_images     = finder_footer_acf_banner_google_play_images();
		$footer_banner_google_images_url = finder_footer_acf_banner_google_play_images_url();
		$is_custom_footer                = finder_footer_acf_is_custom_footer();

		$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data   = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}
		if ( finder_has_custom_footer( $fn_page_options ) ) {
			$banner_googleplay_image = isset( $fn_page_options['footer']['finder_footer_banner_google_play_image'] ) ? $fn_page_options['footer']['finder_footer_banner_google_play_image'] : '';

		} 
		elseif ( $is_custom_footer ) {
			$banner_googleplay_image = $footer_banner_google_images;
		}

		if ( $is_custom_footer ) {
			$banner_googleplay_image_url = $footer_banner_google_images_url;
		}

		$version = finder_get_footer_version();

		if ( $banner_googleplay_image ) {
			if ( 'v2' === $version ) {
				?>
			<a class="btn-market mb-3" href="<?php echo esc_url( $banner_googleplay_image_url ); ?>" role="button">
				<?php
			}
			if ( 'v4' === $version ) {
				?>
			<a class="btn-market mt-3" href="<?php echo esc_url( $banner_googleplay_image_url ); ?>" role="button">
				<?php
			}
			?>
				<img  src="<?php echo esc_url( $banner_googleplay_image ); ?>"  alt="<?php esc_attr_e( 'Finder mobile app', 'finder' ); ?>">				
			<?php
			if ( 'v4' === $version || 'v2' === $version ) {
				?>
				</a>
				<?php
			}
		}
	}
}
