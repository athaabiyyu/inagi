<?php
/**
 * Template functions related to the header.
 *
 * @package Finder
 */

use HivePress\Menus\User_Account;
use HivePress\Forms\User_Login;
use HivePress\Forms\User_Register;
use HivePress\Forms\User_Password_Request;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'finder_header_markup' ) ) {
	/**
	 * Site Header - <header>
	 */
	function finder_header_markup() {
		do_action( 'finder_header_markup_before' );
		?>
		<header 
		<?php
		finder_render_attr(
			'header',
			array(
				'id'    => 'masthead',
				'class' => join(
					' ',
					finder_get_header_classes()
				),
			)
		);
		?>
		>
			<?php
			finder_masthead_top();

			finder_masthead();

			finder_masthead_bottom();

			do_action( 'finder_sticky_header_markup' );
			do_action( 'finder_bottom_header_after_markup' );
			?>
		</header>
		<?php
		do_action( 'finder_header_markup_after' );
	}
}

if ( ! function_exists( 'finder_header_container_wrap_start' ) ) {
	/**
	 * Header Container Wrap.
	 */
	function finder_header_container_wrap_start() {
		?>
		<div class="container">
		<?php
	}
}
if ( ! function_exists( 'finder_header_container_wrap_end' ) ) {
	/**
	 * Header Container Wrap.
	 */
	function finder_header_container_wrap_end() {
		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_get_header' ) ) {
	/**
	 * Header Versions
	 */
	function finder_get_header() {
		$header_style = finder_get_header_style();
		finder_get_template( 'header/header-' . $header_style . '.php' );
	}
}

if ( ! function_exists( 'finder_navbar_brand_classes' ) ) {
	/**
	 * Override get_custom_logo function to add navbar-brand class.
	 *
	 * @param string $html custom logo HTML.
	 * @return string
	 */
	function finder_navbar_brand_classes( $html ) {

		if ( preg_match( '/custom-logo-link/', $html ) ) {
			$html = str_replace( 'custom-logo-link', 'navbar-brand me-3 me-xl-4', $html );
		}
		if ( preg_match( '/custom-logo/', $html ) ) {
			$html = str_replace( 'custom-logo', 'd-block', $html );
		}

		return $html;
	}
}

if ( ! function_exists( 'finder_site_branding' ) ) {
	/**
	 * Site branding wrapper and display
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function finder_site_branding() {
		finder_site_title_or_logo( true );
	}
}

if ( ! function_exists( 'finder_navbar_toggler' ) ) {
	/**
	 * Display navbar toggler.
	 */
	function finder_navbar_toggler() {
		?>
		<button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
			aria-controls="navbarNav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'finder' ); ?>">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php
	}
}

if ( ! function_exists( 'finder_navbar_nav_primary' ) ) {
	/**
	 * Display Primary Navbar.
	 */
	function finder_navbar_nav_primary() {
		?>
		<div class="collapse navbar-collapse order-md-2" id="navbarNav">
		<?php

		wp_nav_menu(
			array(
				'container'      => false,
				'theme_location' => 'primary',
				'menu_class'     => 'navbar-nav flex-wrap',
				'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
				'walker'         => new WP_Bootstrap_Navwalker(),
			)
		);

		?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_navbar_button' ) ) {
	/**
	 *  Header Navbar Buy Finder Button.
	 */
	function finder_navbar_button() {

		$is_custom_header = finder_header_acf_is_custom_header();
		$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data  = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}
		
		if ( finder_header_buy_finder_button() ) :

			if ( finder_has_custom_header( $fn_page_options ) ) {
				$button_text  = isset( $fn_page_options['header']['finder_buy_finder_button_text'] ) ? $fn_page_options['header']['finder_buy_finder_button_text'] : 'Buy Finder';
				$button_url   = isset( $fn_page_options['header']['finder_buy_finder_button_url'] ) ? $fn_page_options['header']['finder_buy_finder_button_url'] : '#';
				$button_color = isset( $fn_page_options['header']['finder_buy_finder_button_color'] ) ? 'btn-' . $fn_page_options['header']['finder_buy_finder_button_color'] : 'btn-primary';
				$button_size  = isset( $fn_page_options['header']['finder_buy_finder_button_size'] ) ? 'btn-' . $fn_page_options['header']['finder_buy_finder_button_size'] : 'btn-sm';
				$button_shape = isset( $fn_page_options['header']['finder_buy_finder_button_shape'] ) ? $fn_page_options['header']['finder_buy_finder_button_shape'] : 'rounded-pill';
				$button_icon  = isset( $fn_page_options['header']['finder_buy_finder_button_icon'] ) ? $fn_page_options['header']['finder_buy_finder_button_icon'] : 'fi-cart';
		
			} elseif ( $is_custom_header ) {

				$button_text  = finder_get_field( 'buy_finder_button_text' );
				$button_url   = finder_get_field( 'buy_finder_button_url' );
				$button_color = 'btn-' . finder_get_field( 'buy_finder_button_color' );
				$button_size  = 'btn-' . finder_get_field( 'buy_finder_button_size' );
				$button_shape = finder_get_field( 'buy_finder_button_shape' );
				$button_icon  = finder_get_field( 'buy_finder_button_icon' );

			} else {

				$button_text  = get_theme_mod( 'header_button_text', 'Buy Finder' );
				$button_url   = get_theme_mod( 'button_url', '#' );
				$button_color = 'btn-' . get_theme_mod( 'header_button_color', 'primary' );
				$button_size  = 'btn-' . get_theme_mod( 'finder_header_button_size', 'sm' );
				$button_shape = get_theme_mod( 'finder_header_button_shape', 'rounded-pill' );
				$button_icon  = get_theme_mod( 'finder_button_icon', 'fi-cart' );
			}

			$button_class = array(
				'finder-header-button',
				'btn',
				$button_color,
				$button_size,
				$button_shape,
				'ms-2',
				'order-md-3',
			);
			?>
		<a 
			<?php
			finder_render_attr(
				'header_button',
				array(
					'href'  => $button_url,
					'class' => join(
						' ',
						$button_class
					),
				)
			);
			?>
		>
			<i class="<?php echo esc_attr( apply_filters( 'finder_navbar_button_css_classes', $button_icon ) ); ?> fs-base me-2"></i><?php echo esc_html( $button_text ); ?>
		</a>
			<?php
		endif;
	}
}

if ( ! function_exists( 'finder_header_add_listing' ) ) {
	/**
	 * Header Add Properties Button.
	 */
	function finder_header_add_listing() {
		if ( finder_is_hivepress_activated() && finder_header_add_properties_button() ) {
			finder_hivepress_template( 'listing/submit/listing-submit-link' );
		}
	}
}

if ( ! function_exists( 'finder_header_post_resume_button' ) ) {
	/**
	 *  Header Post Resume Button.
	 */
	function finder_header_post_resume_button() {

		$is_custom_header = finder_header_acf_is_custom_header();
		$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data  = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}

		if ( finder_is_wp_job_manager_activated() && finder_header_enable_post_resume_button() ) :

			if ( finder_has_custom_header( $fn_page_options ) ) {
				$post_resume_button_text  = isset( $fn_page_options['header']['finder_post_resume_button_text'] ) ? $fn_page_options['header']['finder_post_resume_button_text'] : 'Post resume';
				$post_resume_button_url   = isset( $fn_page_options['header']['finder_post_resume_button_url'] ) ? $fn_page_options['header']['finder_post_resume_button_url'] : '#';
				$post_resume_button_color = isset( $fn_page_options['header']['finder_post_resume_button_colorr'] ) ? 'btn-' . $fn_page_options['header']['finder_post_resume_button_colorr'] : 'btn-Primary';
				$post_resume_button_size  = isset( $fn_page_options['header']['finder_post_resume_button_size'] ) ? 'btn-' . $fn_page_options['header']['finder_post_resume_button_size'] : 'btn-sm';
				$post_resume_button_shape = isset( $fn_page_options['header']['finder_post_resume_button_shape'] ) ? $fn_page_options['header']['finder_post_resume_button_shape'] : 'rounded-pill';
				$post_resume_button_icon  = isset( $fn_page_options['header']['finder_post_resume_button_icon'] ) ? $fn_page_options['header']['finder_post_resume_button_icon'] : 'fi-plus';

			} elseif ( $is_custom_header ) {

				$post_resume_button_text  = finder_get_field( 'post_resume_button_text' );
				$post_resume_button_url   = finder_get_field( 'post_resume_button_url' );
				$post_resume_button_color = 'btn-' . finder_get_field( 'post_resume_button_color' );
				$post_resume_button_size  = 'btn-' . finder_get_field( 'post_resume_button_size' );
				$post_resume_button_shape = finder_get_field( 'post_resume_button_shape' );
				$post_resume_button_icon  = finder_get_field( 'post_resume_button_icon' );

			} else {

				$post_resume_button_text  = get_theme_mod( 'finder_header_post_resume_button_text', esc_html__( 'Post resume', 'finder' ) );
				$post_resume_button_url   = get_theme_mod( 'finder_header_post_resume_button_url', '#' );
				$post_resume_button_color = 'btn-' . get_theme_mod( 'finder_header_post_resume_button_color', 'primary' );
				$post_resume_button_size  = 'btn-' . get_theme_mod( 'finder_header_post_resume_button_size', 'sm' );
				$post_resume_button_shape = get_theme_mod( 'finder_header_post_resume_button_shape', 'rounded-pill' );
				$post_resume_button_icon  = get_theme_mod( 'finder_header_post_resume_button_icon', 'fi-plus' );
			}
			$post_resume_button_class = array(
				'finder-header-post-resume-button',
				'btn',
				$post_resume_button_color,
				$post_resume_button_size,
				$post_resume_button_shape,
				'ms-2',
				'order-lg-3',

			);

			?>
		<a 
			<?php
			finder_render_attr(
				'employers_button',
				array(
					'href'  => $post_resume_button_url,
					'class' => join(
						' ',
						$post_resume_button_class
					),
				)
			);
			?>
		>
			<i class="<?php echo esc_attr( apply_filters( 'finder_header_post_resume_button_css_classes', $post_resume_button_icon ) ); ?> me-2"></i><?php echo wp_kses_post( $post_resume_button_text ); ?>
		</a>
			<?php
		endif;
	}
}

if ( ! function_exists( 'finder_navbar_employer_button' ) ) {
	/**
	 *  Header Navbar Employer Button.
	 */
	function finder_navbar_employer_button() {

		$is_custom_header = finder_header_acf_is_custom_header();
		$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data  = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}

		if ( finder_is_wp_job_manager_activated() && finder_header_employers_button() ) :

			if ( finder_has_custom_header( $fn_page_options ) ) {
				$employers_button_text  = isset( $fn_page_options['header']['finder_employers_button_text'] ) ? $fn_page_options['header']['finder_employers_button_text'] : 'For employers';
				$employers_button_url   = isset( $fn_page_options['header']['finder_employers_button_url'] ) ? $fn_page_options['header']['finder_employers_button_url'] : '#';
				$employers_button_color = isset( $fn_page_options['header']['finder_employers_button_color'] ) ? 'btn-' . $fn_page_options['header']['finder_employers_button_color'] : 'btn-Primary';
				$employers_button_color = 'link' === $employers_button_color ? 'btn-' . $employers_button_color . ' btn-light' : 'btn-' . $employers_button_color;
				$employers_button_size  = isset( $fn_page_options['header']['finder_employers_button_size'] ) ? 'btn-' . $fn_page_options['header']['finder_employers_button_size'] : 'btn-sm';

			} elseif ( $is_custom_header ) {

				$employers_button_text  = finder_get_field( 'employers_button_text' );
				$employers_button_url   = finder_get_field( 'employers_button_url' );
				$employers_button_color = finder_get_field( 'employers_button_color' );
				$employers_button_color = 'link' === $employers_button_color ? 'btn-' . $employers_button_color . ' btn-light' : 'btn-' . $employers_button_color;
				$employers_button_size  = 'btn-' . finder_get_field( 'employers_button_size' );

			} else {

				$employers_button_text  = get_theme_mod( 'header_employers_button_text', esc_html__( 'For employers', 'finder' ) );
				$employers_button_url   = get_theme_mod( 'header_employers_button_url', '#' );
				$employers_button_color = get_theme_mod( 'header_employers_button_color', 'link' );
				$employers_button_color = 'link' === $employers_button_color ? 'btn-' . $employers_button_color . ' btn-light' : 'btn-' . $employers_button_color;
				$employers_button_size  = 'btn-' . get_theme_mod( 'header_employers_button_size', 'sm' );

			}

			$employers_button_class = array(
				'finder-header-employers-button',
				'btn',
				$employers_button_color,
				$employers_button_size,
				'd-none',
				'd-lg-block',
				'order-lg-3',
				'pe-0',
				'ms-2',
			);

			?>
		<a 
			<?php
			finder_render_attr(
				'employers_button',
				array(
					'href'  => $employers_button_url,
					'class' => join(
						' ',
						$employers_button_class
					),
				)
			);
			?>
		>
			<?php echo esc_html( $employers_button_text ); ?><i class="fi-arrow-long-right ms-2"></i>
		</a>
			<?php
		endif;
	}
}

	/**
	 *  Header primary navbar offcanvas enable.
	 */
function finder_offcanvas_enable() {

	$enable_offcavas = get_theme_mod( 'finder_enable_offcanvas', 'yes' );

	return $enable_offcavas;

}

if ( ! function_exists( 'finder_offcanvas_button' ) ) {
	/**
	 *  Header Navbar offcanvas button.
	 */
	function finder_offcanvas_button() {

		if ( 'yes' !== finder_offcanvas_enable() ) {
			return;
		}
		$style        = finder_get_blog_style();
		$single_style = finder_get_blog_single_style();
		if ( 'default' === $style || 'default' === $single_style ) {
			return;
		}
		$offcanvas_icon_position = get_theme_mod( 'finder_offcanvas_icon_position', 'end' );
		if ( ! empty( $offcanvas_icon_position ) ) {
			$offcanvas_icon_position = $offcanvas_icon_position . '-0';
		}
		$offcanvas_title = get_theme_mod( 'finder_offcanvas_title', esc_html__( 'Choose Demo', 'finder' ) );
		?>
		<button class="btn btn-icon btn-light rounded-circle shadow position-fixed top-50 <?php echo esc_attr( $offcanvas_icon_position ); ?> translate-middle-y me-3" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="<?php echo esc_html( $offcanvas_title ); ?>" style="z-index: 1035;">
			<span class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 rounded-circle" data-bs-toggle="offcanvas" data-bs-target="#demo-switcher">
				<i class="fi-layers"></i>
			</span>
		</button>
		<?php
	}
}

if ( ! function_exists( 'finder_offcanvas_menu' ) ) {
	/**
	 *  Header offcanvas Menu.
	 */
	function finder_offcanvas_menu() {

		wp_nav_menu(
			array(
				'container'      => false,
				'theme_location' => 'offcanvas_menu',
				'menu_class'     => 'd-flex list-unstyled mb-0',
				'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
				'walker'         => new WP_Bootstrap_Navwalker(),
				'anchor_class'   => array( 'btn', 'btn-outline-secondary', 'btn-sm', 'w-100', 'me-2' ),
			)
		);
	}
}

if ( ! function_exists( 'finder_offcanvas_sidebar' ) ) {
	/**
	 *  Header offcanvas sidebar.
	 */
	function finder_offcanvas_sidebar() {
		$offcanvas_icon_position = get_theme_mod( 'finder_offcanvas_icon_position', 'end' );

		$offcanvas_title               = get_theme_mod( 'finder_offcanvas_title', esc_html__( 'Choose Demo', 'finder' ) );
		$offcanvas_footer_button_color = 'btn-' . get_theme_mod( 'finder_offcanvas_footer_button_color', 'primary' );
		$offcanvas_footer_button_size  = 'btn-' . get_theme_mod( 'finder_offcanvas_footer_button_size', 'lg' );
		$offcanvas_footer_button_url   = get_theme_mod( 'finder_offcanvas_footer_button_url', '#' );
		$offcanvas_footer_button_text  = get_theme_mod( 'finder_offcanvas_footer_button_text', 'Buy Finder' );
		$offcanvas_footer_button_icon  = get_theme_mod( 'finder_offcanvas_footer_button_icon', 'fi-cart' );
		$offcanvas_options             = array(
			'finder-offcanvas-footer-button',
			'btn',
			$offcanvas_footer_button_color,
			$offcanvas_footer_button_size,
			'w-100',
		);

		?>
		<div class="offcanvas offcanvas-<?php echo esc_attr( $offcanvas_icon_position ); ?>" id="demo-switcher" aria-modal="true" role="dialog">
			<div class="offcanvas-header d-block border-bottom">
				<div class="finder-offcanvas-title d-flex align-items-center justify-content-between mb-4">
					<h2 class="h5 mb-0"><?php echo esc_html( $offcanvas_title ); ?></h2>
					<button class="btn-close" type="button" data-bs-dismiss="offcanvas"></button>
				</div>
				<?php finder_offcanvas_menu(); ?>
			</div>
			<div class="offcanvas-body">
				<?php if ( is_active_sidebar( 'offcanvas-sidebar' ) ) : ?>
					<?php dynamic_sidebar( 'offcanvas-sidebar' ); ?>
				<?php endif; ?>
			</div>
			<div class="offcanvas-footer border-top">
				<a 
					<?php
					finder_render_attr(
						'offcanvas_options',
						array(
							'href'  => $offcanvas_footer_button_url,
							'class' => join(
								' ',
								$offcanvas_options
							),
						)
					);
					?>
					target="_blank" rel="noopener"
				>
					<i class="<?php echo esc_attr( apply_filters( 'finder_offcanvas_button_css_classes', $offcanvas_footer_button_icon ) ); ?> fs-lg me-2">
					</i><?php echo esc_html( $offcanvas_footer_button_text ); ?>
				</a>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_header_myaccount' ) ) {
	/**
	 * Header myaccount
	 */
	function finder_header_myaccount() {
		if ( finder_is_hivepress_activated() && finder_header_enable_signin() ) {
			finder_hivepress_template( 'user/login/user-login-link' );
		}
	}
}

if ( ! function_exists( 'finder_header_myaccount_dropdown_items' ) ) {
	/**
	 * Header myaccount dropdown items
	 */
	function finder_header_myaccount_dropdown_items() {
		if ( finder_is_hivepress_activated() ) {

			$user = wp_get_current_user();

			// Get menu items.
			$menu_items = ( new User_Account() )->get_items();

			$default_icons = apply_filters(
				'finder_header_myaccount_dropdown_items_icons',
				array(
					'listings_edit'      => 'fi-home',
					'messages_thread'    => 'fi-chat-circle',
					'listings_favorite'  => 'fi-heart',
					'user_edit_settings' => 'fi-settings',
					'user_logout'        => 'fi-logout',
					'user_listing_packages_view' => 'fi-file-clean',
					'orders_view'                => 'fi-file',
					'vendor_dashboard'   => 'fi-dashboard',
				)
			);

			?>
			<div class="dropdown-menu dropdown-menu-end">
				<div class="d-flex align-items-start border-bottom px-3 py-1 mb-2" style="width: 16rem;">
					<?php echo get_avatar( $user->ID, 48, '', '', array( 'class' => 'rounded-circle' ) ); ?>
					<div class="ps-2">
						<h6 class="fs-base mb-0"><?php echo esc_html( $user->display_name ); ?></h6>
						<div class="fs-xs py-2"><?php echo esc_html( $user->user_email ); ?></div>
					</div>
				</div>
				<?php foreach ( $menu_items as $key => $menu_item ) : ?>
					<?php if ( 'user_logout' === $key ) : ?>
						<div class="dropdown-divider"></div>
					<?php endif; ?>
					<a class="dropdown-item" href="<?php echo esc_url( $menu_item['url'] ); ?>">
						<i class="<?php echo esc_attr( $default_icons[ $key ] ); ?> opacity-60 me-2"></i>
						<?php echo esc_html( $menu_item['label'] ); ?>
						<?php if ( hivepress()->request->get_context( 'notice_count' ) && 'messages_thread' === $key ) : ?>
							<small class="badge rounded-pill bg-primary ms-1"><?php echo esc_html( hivepress()->request->get_context( 'notice_count' ) ); ?></small>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'finder_header_user_signin_form' ) ) {
	/**
	 * Signin Form
	 */
	function finder_header_user_signin_form() {

		if ( ! finder_is_hivepress_activated() ) {
			return;
		}

		$is_dark_header = finder_is_header_navbar_dark();

		$signin_title = get_theme_mod( 'finder_signin_title', wp_kses_post( 'Hey there!<br>Welcome back.' ) );
		$signin_image = get_theme_mod( 'finder_signin_image_option' );

		$user_login_form_args = array(
			'button' => array(
				'label'      => esc_html__( 'Sign in', 'finder' ),
				'attributes' => array(
					'class' => array( 'btn', 'btn-primary', 'btn-lg', 'w-100', 'mt-2', 'mb-2' ),
				),
			),
			'fields' => array(
				'username_or_email' => array(
					'placeholder' => esc_html__( 'Enter your email', 'finder' ),
					'attributes'  => array(
						'class' => array( 'mb-4' ),
					),
				),
				'password'          => array(
					'placeholder' => esc_html__( 'Enter password', 'finder' ),
				),
			),
		);

		$user_login_form = new User_Login( $user_login_form_args );

		?>
		<div class="modal fade" id="user_login_modal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 950px;">
			<div class="modal-content<?php echo esc_attr( $is_dark_header ? ' bg-dark border-light' : '' ); ?>">
				<div class="modal-body px-0 py-2 py-sm-0">
				<button class="btn-close position-absolute top-0 end-0 mt-3 me-3<?php echo esc_attr( $is_dark_header ? ' btn-close-white' : '' ); ?>" type="button" data-bs-dismiss="modal"></button>
				<div class="row mx-0 align-items-center">
					<div class="col-md-6 border-end-md p-4 p-sm-5<?php echo esc_attr( $is_dark_header ? ' border-light' : '' ); ?>">
						<?php if ( ! empty( $signin_title ) ) : ?>
							<h2 class="h3 mb-4 mb-sm-5<?php echo esc_attr( $is_dark_header ? ' text-light' : '' ); ?>">
								<?php echo wp_kses_post( $signin_title ); ?>
							</h2>
						<?php endif; ?>
						<?php if ( ! empty( $signin_image ) ) : ?>
							<img class="d-block mx-auto" src="<?php echo esc_url( wp_get_attachment_url( $signin_image ) ); ?>" alt="<?php esc_attr_e( 'Illustartion', 'finder' ); ?>">
						<?php endif; ?>
						<?php if ( finder_hivepress_is_registration_enabled() ) : ?>
							<div class="mt-4 mt-sm-5<?php echo esc_attr( $is_dark_header ? ' text-light' : '' ); ?>">
								<?php if ( $is_dark_header ) : ?>
								<span class="opacity-60">
								<?php endif; ?>
									<?php esc_html_e( "Don't have an account?", 'finder' ); ?>
								<?php if ( $is_dark_header ) : ?>
								</span>
								<?php endif; ?>
								
								<a class="signup-link<?php echo esc_attr( $is_dark_header ? ' text-light' : '' ); ?>" href="#user_signup_modal" data-bs-toggle="modal" data-bs-dismiss="modal"><?php esc_html_e( 'Sign up here', 'finder' ); ?></a>
							</div>
						<?php endif; ?>
					</div>
					<div class="col-md-6 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">
						<div class="finder-hp-singin-popup-form<?php echo esc_attr( $is_dark_header ? ' finder-form-dark' : '' ); ?>">
							<?php echo  wp_kses( $user_login_form->render(), 'login_form'); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div class="d-flex justify-content-end">
							<a href="#user_password_request_modal" data-bs-toggle="modal" data-bs-dismiss="modal" class="hp-form_action hp-form_action--user-password-request fs-sm<?php echo esc_attr( $is_dark_header ? ' text-light' : '' ); ?>"><?php esc_html_e( 'Forgot password?', 'finder' ); ?></a>
						</div>
					</div>

				</div>
				</div>
			</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_header_user_signup_form' ) ) {
	/**
	 * Signin Form
	 */
	function finder_header_user_signup_form() {
		if ( ! finder_is_hivepress_activated() ) {
			return;
		}

		$is_dark_header = finder_is_header_navbar_dark();

		$default      = apply_filters( 'finder_default_signup_title', 'Join Finder.<br>Get premium benefits:' );
		$signup_title = get_theme_mod( 'finder_signup_title', $default );
		$signup_image = get_theme_mod( 'finder_signup_image_option' );

		$user_signup_form_args = array(
			'button' => array(
				'label'      => esc_html__( 'Sign up', 'finder' ),
				'attributes' => array(
					'class' => array( 'btn', 'btn-primary', 'btn-lg', 'w-100', 'mt-2' ),
				),
			),
			'fields' => array(
				'username' => array(
					'placeholder' => esc_html__( 'Enter your full name', 'finder' ),
					'attributes'  => array(
						'class' => array( 'mb-4' ),
					),
				),
				'email'    => array(
					'placeholder' => esc_html__( 'Enter your email', 'finder' ),
				),
				'password' => array(
					'placeholder' => esc_html__( 'Enter your password min 8 char', 'finder' ),
				),
			),
		);

		$user_signup_form = new User_Register( $user_signup_form_args );

		$features_str = get_theme_mod( 'finder_header_popup_signup_form_features', esc_html__( "Add and promote your listings\nEasily manage your wishlist\nLeave reviews", 'finder' ) );

		$features = explode( "\n", $features_str );

		$count = 0;
		foreach ( $features as $feature ) {
			if ( empty( trim( $feature ) ) ) {
				continue;
			}

			$count ++;
		}

		?>
		<div class="modal fade" id="user_signup_modal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 950px;">
				<div class="modal-content<?php echo esc_attr( $is_dark_header ? ' bg-dark border-light' : '' ); ?>">
					<div class="modal-body px-0 py-2 py-sm-0">
						<button class="btn-close position-absolute top-0 end-0 mt-3 me-3<?php echo esc_attr( $is_dark_header ? ' btn-close-white' : '' ); ?>" type="button" data-bs-dismiss="modal"></button>
						<div class="row mx-0 align-items-center">
							<div class="col-md-6 border-end-md p-4 p-sm-5<?php echo esc_attr( $is_dark_header ? ' border-light' : '' ); ?>">
								<?php if ( ! empty( $signup_title ) ) : ?>
								<h2 class="finder-signup-title h3 mb-4 mb-sm-5<?php echo esc_attr( $is_dark_header ? ' text-light' : '' ); ?>"><?php echo wp_kses_post( $signup_title ); ?></h2>
								<?php endif; ?>
								<?php if ( 0 < $count ) : ?>
									<ul class="list-unstyled mb-4 mb-sm-5">
										<?php foreach ( $features as $key => $feature ) : ?>
											<li class="d-flex mb-<?php echo esc_attr( $count === $key + 1 ? '0' : '2' ); ?>">
												<i class="fi-check-circle text-primary mt-1 me-2"></i>
												<span class="list-text<?php echo esc_attr( $is_dark_header ? ' text-light' : '' ); ?>"><?php echo esc_html( $feature ); ?></span>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
								<?php if ( ! empty( $signup_image ) ) : ?>
								<img class="d-block mx-auto" src="<?php echo esc_url( wp_get_attachment_url( $signup_image ) ); ?>" alt="<?php esc_attr_e( 'Illustartion', 'finder' ); ?>">
								<?php endif; ?>
								<div class="mt-sm-4 pt-md-3<?php echo esc_attr( $is_dark_header ? ' text-light' : '' ); ?>">
									<?php
										printf(
											'%1$s <a href="#user_login_modal" class="signin-link%2$s" data-bs-toggle="modal" data-bs-dismiss="modal">%3$s</a>',
											esc_html__( 'Already have an account?', 'finder' ),
											esc_attr( $is_dark_header ? ' text-light' : '' ),
											esc_html__( 'Sign in', 'finder' )
										);
									?>
								</div>
							</div>
							<div class="col-md-6 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">
								<div class="finder-hp-singup-popup-form<?php echo esc_attr( $is_dark_header ? ' finder-form-dark' : '' ); ?>">
									<?php echo wp_kses( $user_signup_form->render(), 'login_form' ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'finder_header_forgot_password_form' ) ) {
	/**
	 * Reset Password Form
	 */
	function finder_header_forgot_password_form() {

		if ( ! finder_is_hivepress_activated() ) {
			return;
		}

		$is_dark_header = finder_is_header_navbar_dark();

		$reset_password_title = get_theme_mod( 'finder_register_password_title', wp_kses_post( 'Reset Password' ) );
		$reset_password_desc  = get_theme_mod( 'finder_register_password_desc', wp_kses_post( 'Enter your email to reset your password.' ) );

		$user_reset_password_form_args = array(
			'button' => array(
				'label'      => esc_html__( 'Reset Password', 'finder' ),
				'attributes' => array(
					'class' => array( 'btn', 'btn-primary', 'btn-lg', 'w-100', 'mt-2', 'mb-2' ),
				),
			),
			'fields' => array(
				'username_or_email' => array(
					'placeholder' => esc_html__( 'Enter your email', 'finder' ),
				),
			),
		);

		$user_reset_password_form = new User_Password_Request( $user_reset_password_form_args );
		?>
		<div class="modal fade" id="user_password_request_modal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-md modal-dialog-centered p-2 my-0 mx-auto">
				<div class="modal-content<?php echo esc_attr( $is_dark_header ? ' bg-dark border-light' : '' ); ?>">
					<div class="modal-body px-0 py-2 py-sm-0">
						<button class="btn-close position-absolute top-0 end-0 mt-3 me-3<?php echo esc_attr( $is_dark_header ? ' btn-close-white' : '' ); ?>" type="button" data-bs-dismiss="modal"></button>
						<div class="row mx-0 align-items-center">
							<div class="col-12 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">
								<h3 class="h3 mb-2<?php echo esc_attr( $is_dark_header ? ' text-light' : '' ); ?>"><?php echo wp_kses_post( $reset_password_title ); ?> </h3>
								<p class="mb-4<?php echo esc_attr( $is_dark_header ? ' text-light' : '' ); ?>"><?php echo wp_kses_post( $reset_password_desc ); ?></p>
								<div class="finder-hp-password-popup-form<?php echo esc_attr( $is_dark_header ? ' finder-form-dark' : '' ); ?>">
									<?php echo wp_kses( $user_reset_password_form->render(), 'login_form'); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
								<a href="#user_login_modal" class="signin-link<?php echo esc_attr( $is_dark_header ? ' text-light' : '' ); ?>" data-bs-toggle="modal" data-bs-dismiss="modal"><?php esc_html_e( 'Return to Sign in', 'finder' ); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
