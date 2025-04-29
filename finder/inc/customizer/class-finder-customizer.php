<?php
/**
 * Finder Customizer Class
 *
 * @package  finder
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Finder_Customizer' ) ) :

	/**
	 * The Finder Customizer class
	 */
	class Finder_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			add_action( 'customize_register', array( $this, 'customize_header' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_general' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_blog' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_404' ), 10 );
			add_action( 'customize_register', array( $this, 'customize_footer' ), 10 );
			add_action( 'customize_controls_print_scripts', array( $this, 'add_scripts' ), 30 );
			add_action( 'customize_register', array( $this, 'customize_customcolor' ), 10 );
		}

		/**
		 * Customize site header
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_header( $wp_customize ) {
			$wp_customize->add_panel(
				'finder_header',
				array(
					'title'       => esc_html__( 'Header', 'finder' ),
					'description' => esc_html__( 'Customize the theme header.', 'finder' ),
					'priority'    => 40,

				)
			);
			$this->add_header_general_settings( $wp_customize );
			$this->add_finder_my_account_settings( $wp_customize );
		}

		/**
		 * Customize Header.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_header_general_settings( $wp_customize ) {
			$wp_customize->add_section(
				'finder_header_section',
				array(
					'title'       => esc_html__( 'General', 'finder' ),
					'description' => esc_html__( 'Customize the theme header.', 'finder' ),
					'priority'    => 10,
					'panel'       => 'finder_header',
				)
			);

			$wp_customize->add_setting(
				'finder_header_sticky',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_sticky',
				array(
					'type'        => 'radio',
					'section'     => 'finder_header_section',
					'label'       => esc_html__( 'Enable Sticky Header ?  ', 'finder' ),
					'description' => esc_html__( 'This setting allows you to enable or disable sticky header.', 'finder' ),
					'choices'     => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
				)
			);

			$wp_customize->add_setting(
				'finder_header_navbar_dark',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_navbar_dark',
				array(
					'type'        => 'radio',
					'section'     => 'finder_header_section',
					'label'       => esc_html__( 'Enable Navbar Dark ?  ', 'finder' ),
					'description' => esc_html__( 'This setting allows you to enable or disable dark header.', 'finder' ),
					'choices'     => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
				)
			);

			$wp_customize->add_setting(
				'finder_header_transparent_navbar',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_transparent_navbar',
				array(
					'type'        => 'radio',
					'section'     => 'finder_header_section',
					'label'       => esc_html__( 'Enable transparent Navbar ?  ', 'finder' ),
					'description' => esc_html__( 'This setting allows you to enable or disable transparent header.', 'finder' ),
					'choices'     => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
				)
			);

			$wp_customize->add_setting(
				'enable_signin_button',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'enable_signin_button',
				array(
					'type'            => 'radio',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Enable Signin Button ? ', 'finder' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
					'active_callback' => function () {
						return finder_is_hivepress_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'enable_primary_nav_button',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'enable_primary_nav_button',
				array(
					'type'    => 'radio',
					'section' => 'finder_header_section',
					'label'   => esc_html__( 'Enable Buy Finder Button ?', 'finder' ),
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
				)
			);

			$wp_customize->add_setting(
				'finder_button_icon',
				array(
					'default'           => 'fi-cart',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_button_icon',
				array(
					'type'            => 'text',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Change Buy Finder Button Icon', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button icon', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_primary_nav_button', 'no' );
					},

				)
			);

			$wp_customize->add_setting(
				'header_button_color',
				array(
					'default'           => 'primary',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_button_color',
				array(
					'type'            => 'select',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Buy Finder Button Color', 'finder' ),
					'choices'         => array(
						'primary'  => esc_html_x( 'Primary', 'button', 'finder' ),
						'accent'   => esc_html_x( 'Accent', 'button', 'finder' ),
						'success'  => esc_html_x( 'Success', 'button', 'finder' ),
						'danger'   => esc_html_x( 'Danger', 'button', 'finder' ),
						'warning'  => esc_html_x( 'Warning', 'button', 'finder' ),
						'info'     => esc_html_x( 'Info', 'button', 'finder' ),
						'dark'     => esc_html_x( 'Dark', 'button', 'finder' ),
						'gradient' => esc_html_x( 'Gradient', 'button', 'finder' ),
						'link'     => esc_html_x( 'Link', 'button', 'finder' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_primary_nav_button', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'header_button_text',
				array(
					'default'           => esc_html__( 'Buy Finder', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'header_button_text',
				array(
					'type'            => 'text',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Buy Finder Button Text', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button text', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_primary_nav_button', 'yes' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'header_button_text',
				array(
					'selector'         => '.finder-header-button',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'button_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'button_url',
				array(
					'type'            => 'url',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Buy Finder Button Link', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button link', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_primary_nav_button', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_header_button_size',
				array(
					'default'           => 'sm',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_button_size',
				array(
					'type'            => 'select',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Buy Finder Button Size', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your header button size.', 'finder' ),
					'choices'         => array(
						'xs' => esc_html__( 'Extra Small', 'finder' ),
						'sm' => esc_html__( 'Small', 'finder' ),
						'lg' => esc_html__( 'Large', 'finder' ),
					),
					'active_callback' => function () {
							return 'yes' === get_theme_mod( 'enable_primary_nav_button', 'yes' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_header_button_shape',
				array(
					'default'           => 'rounded-pill',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_button_shape',
				array(
					'type'            => 'select',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Buy Finder Button Shape', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your header button shape.', 'finder' ),
					'choices'         => array(
						''             => esc_html__( 'Default', 'finder' ),
						'rounded-pill' => esc_html__( 'Pill', 'finder' ),
						'rounded-0'    => esc_html__( 'Square', 'finder' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_primary_nav_button', 'yes' );
					},

				)
			);

			$wp_customize->add_setting(
				'enable_add_listing_button',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'enable_add_listing_button',
				array(
					'type'            => 'radio',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Enable Add Listing Button ? ', 'finder' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
					'active_callback' => function () {
						return finder_is_hivepress_activated();
					},

				)
			);

			$wp_customize->add_setting(
				'finder_header_listing_button_size',
				array(
					'default'           => 'sm',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_listing_button_size',
				array(
					'type'            => 'select',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Header Listing Button Size', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your header listing button size.', 'finder' ),
					'choices'         => array(
						'xs' => esc_html__( 'Extra Small', 'finder' ),
						'sm' => esc_html__( 'Small', 'finder' ),
						'lg' => esc_html__( 'Large', 'finder' ),
					),
					'active_callback' => function () {
							return 'yes' === get_theme_mod( 'enable_add_listing_button', 'yes' ) && finder_is_hivepress_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'finder_header_listing_button_shape',
				array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_listing_button_shape',
				array(
					'type'            => 'select',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Header Listing Button Shape', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your header listing button shape.', 'finder' ),
					'choices'         => array(
						''             => esc_html__( 'Default', 'finder' ),
						'rounded-pill' => esc_html__( 'Pill', 'finder' ),
						'rounded-0'    => esc_html__( 'Square', 'finder' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_add_listing_button', 'no' ) && finder_is_hivepress_activated();
					},

				)
			);

			$wp_customize->add_setting(
				'finder_header_listing_button_text',
				array(
					'default'           => esc_html__( 'Add property', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_header_listing_button_text',
				array(
					'type'            => 'text',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Header Listing Button Text', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the listing button text', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_add_listing_button', 'no' ) && finder_is_hivepress_activated();
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_header_listing_button_text',
				array(
					'selector'         => '.finder-header-listing-button',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_header_listing_button_icon',
				array(
					'default'           => 'fi-plus',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_listing_button_icon',
				array(
					'type'            => 'text',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Header Listing Button Icon', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button icon', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_add_listing_button', 'no' ) && finder_is_hivepress_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'finder_header_listing_button_color',
				array(
					'default'           => 'primary',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_listing_button_color',
				array(
					'type'            => 'select',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Header Listing Button Color', 'finder' ),
					'choices'         => array(
						'primary' => esc_html_x( 'Primary', 'button', 'finder' ),
						'accent'  => esc_html_x( 'Accent', 'button', 'finder' ),
						'success' => esc_html_x( 'Success', 'button', 'finder' ),
						'danger'  => esc_html_x( 'Danger', 'button', 'finder' ),
						'warning' => esc_html_x( 'Warning', 'button', 'finder' ),
						'info'    => esc_html_x( 'Info', 'button', 'finder' ),
						'dark'    => esc_html_x( 'Dark', 'button', 'finder' ),
						'link'    => esc_html_x( 'Link', 'button', 'finder' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_add_listing_button', 'no' ) && finder_is_hivepress_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'enable_post_resume_button',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'enable_post_resume_button',
				array(
					'type'            => 'radio',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Enable Post Resume Button ? ', 'finder' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
					'active_callback' => function () {
						return finder_is_wp_job_manager_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'finder_header_post_resume_button_size',
				array(
					'default'           => 'sm',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_post_resume_button_size',
				array(
					'type'            => 'select',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Header Post Resume Button Size', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your post resume button size.', 'finder' ),
					'choices'         => array(
						'xs' => esc_html__( 'Extra Small', 'finder' ),
						'sm' => esc_html__( 'Small', 'finder' ),
						'lg' => esc_html__( 'Large', 'finder' ),
					),
					'active_callback' => function () {
							return 'yes' === get_theme_mod( 'enable_post_resume_button', 'no' ) && finder_is_wp_job_manager_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'finder_header_post_resume_button_shape',
				array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_post_resume_button_shape',
				array(
					'type'            => 'select',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Header Post Resume Button Shape', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your post resume button shape.', 'finder' ),
					'choices'         => array(
						''             => esc_html__( 'Default', 'finder' ),
						'rounded-pill' => esc_html__( 'Pill', 'finder' ),
						'rounded-0'    => esc_html__( 'Square', 'finder' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_post_resume_button', 'no' ) && finder_is_wp_job_manager_activated();
					},

				)
			);

			$wp_customize->add_setting(
				'finder_header_post_resume_button_text',
				array(
					'default'           => esc_html__( 'Post resume', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_header_post_resume_button_text',
				array(
					'type'            => 'text',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Header Post Resume Button Text', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the Post resume button text', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_post_resume_button', 'no' ) && finder_is_wp_job_manager_activated();
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_header_post_resume_button_text',
				array(
					'selector'         => '.finder-header-post-resume-button',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_header_post_resume_button_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'finder_header_post_resume_button_url',
				array(
					'type'            => 'url',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Post Resume Button Link', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button link', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_post_resume_button', 'no' ) && finder_is_wp_job_manager_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'finder_header_post_resume_button_icon',
				array(
					'default'           => 'fi-plus',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_post_resume_button_icon',
				array(
					'type'            => 'text',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Header Post Resume Button Icon', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button icon', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_post_resume_button', 'no' ) && finder_is_wp_job_manager_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'finder_header_post_resume_button_color',
				array(
					'default'           => 'primary',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_header_post_resume_button_color',
				array(
					'type'            => 'select',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Header Post Resume Button Color', 'finder' ),
					'choices'         => array(
						'primary' => esc_html_x( 'Primary', 'button', 'finder' ),
						'accent'  => esc_html_x( 'Accent', 'button', 'finder' ),
						'success' => esc_html_x( 'Success', 'button', 'finder' ),
						'danger'  => esc_html_x( 'Danger', 'button', 'finder' ),
						'warning' => esc_html_x( 'Warning', 'button', 'finder' ),
						'info'    => esc_html_x( 'Info', 'button', 'finder' ),
						'dark'    => esc_html_x( 'Dark', 'button', 'finder' ),
						'link'    => esc_html_x( 'Link', 'button', 'finder' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_post_resume_button', 'no' ) && finder_is_wp_job_manager_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'enable_employers_link_button',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'enable_employers_link_button',
				array(
					'type'            => 'radio',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Enable Employers Button ? ', 'finder' ),
					'choices'         => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
					'active_callback' => function () {
						return finder_is_wp_job_manager_activated();
					},

				)
			);

			$wp_customize->add_setting(
				'header_employers_button_color',
				array(
					'default'           => 'link',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_employers_button_color',
				array(
					'type'            => 'select',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Employers Button Color', 'finder' ),
					'choices'         => array(
						'primary'  => esc_html_x( 'Primary', 'button', 'finder' ),
						'success'  => esc_html_x( 'Success', 'button', 'finder' ),
						'danger'   => esc_html_x( 'Danger', 'button', 'finder' ),
						'warning'  => esc_html_x( 'Warning', 'button', 'finder' ),
						'info'     => esc_html_x( 'Info', 'button', 'finder' ),
						'dark'     => esc_html_x( 'Dark', 'button', 'finder' ),
						'gradient' => esc_html_x( 'Gradient', 'button', 'finder' ),
						'link'     => esc_html_x( 'Link', 'button', 'finder' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_employers_link_button', 'no' ) && finder_is_wp_job_manager_activated();
					},

				)
			);

			$wp_customize->add_setting(
				'header_employers_button_text',
				array(
					'default'           => esc_html__( 'For employers', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'header_employers_button_text',
				array(
					'type'            => 'text',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Employers Button Text', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button text', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_employers_link_button', 'no' ) && finder_is_wp_job_manager_activated();
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'header_employers_button_text',
				array(
					'selector'         => '.finder-header-employers-button',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'header_employers_button_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'header_employers_button_url',
				array(
					'type'            => 'url',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Employers Button Link', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button link', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_employers_link_button', 'no' ) && finder_is_wp_job_manager_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'header_employers_button_size',
				array(
					'default'           => 'sm',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'header_employers_button_size',
				array(
					'type'            => 'select',
					'section'         => 'finder_header_section',
					'label'           => esc_html__( 'Employers Button Size', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your button size.', 'finder' ),
					'choices'         => array(
						'xs' => esc_html__( 'Extra Small', 'finder' ),
						'sm' => esc_html__( 'Small', 'finder' ),
						'lg' => esc_html__( 'Large', 'finder' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'enable_employers_link_button', 'no' ) && finder_is_wp_job_manager_activated();
					},

				)
			);
		}

		/**
		 * Customize Header.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_finder_my_account_settings( $wp_customize ) {
			$wp_customize->add_section(
				'finder_account_section',
				array(
					'title'           => esc_html__( 'My Account', 'finder' ),
					'description'     => esc_html__( 'Customize the theme Signin and Signup.', 'finder' ),
					'priority'        => 20,
					'panel'           => 'finder_header',
					'active_callback' => function () {
						return finder_is_hivepress_activated();
					},
				)
			);

			$wp_customize->add_setting(
				'finder_signin_title',
				array(
					'default'           => esc_html__( 'Hey there!<br>Welcome back.', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_signin_title',
				array(
					'type'        => 'text',
					'section'     => 'finder_account_section',
					'label'       => esc_html__( 'Sign in Title', 'finder' ),
					'description' => esc_html__( 'This setting allows you to change the signin title', 'finder' ),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_signin_title',
				array(
					'selector'         => '.finder-signin-title',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_signin_image_option',
				array(
					'transport'         => 'postMessage',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					'finder_signin_image_option',
					array(
						'section'     => 'finder_account_section',
						'label'       => esc_html__( 'Sign in Image Upload', 'finder' ),
						'description' => esc_html__(
							'This setting allows you to upload an image for Signin page.',
							'finder'
						),
						'mime_type'   => 'image',
					)
				)
			);

			$wp_customize->add_setting(
				'finder_signup_title',
				array(
					'default'           => esc_html__( 'Join Finder.<br>Get premium benefits:', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_signup_title',
				array(
					'type'        => 'text',
					'section'     => 'finder_account_section',
					'label'       => esc_html__( 'Signup Title', 'finder' ),
					'description' => esc_html__( 'This setting allows you to change the signup title', 'finder' ),
				)
			);

			$wp_customize->add_setting(
				'finder_header_popup_signup_form_features',
				array(
					'default'           => esc_html__( "Add and promote your listings\nEasily manage your wishlist\nLeave reviews", 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_header_popup_signup_form_features',
				array(
					'type'        => 'textarea',
					'section'     => 'finder_account_section',
					'label'       => esc_html__( 'Signup Features', 'finder' ),
					'description' => esc_html__( 'Enter Each feature in a separate line.', 'finder' ),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_signup_title',
				array(
					'selector'         => '.finder-signup-title',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_signup_image_option',
				array(
					'transport'         => 'postMessage',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					'finder_signup_image_option',
					array(
						'section'     => 'finder_account_section',
						'label'       => esc_html__( 'Signup Image Upload', 'finder' ),
						'description' => esc_html__(
							'This setting allows you to upload an image for Signup page.',
							'finder'
						),
						'mime_type'   => 'image',
					)
				)
			);

			$wp_customize->add_setting(
				'finder_register_password_title',
				array(
					'default'           => esc_html__( 'Reset Password', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_register_password_title',
				array(
					'type'        => 'text',
					'section'     => 'finder_account_section',
					'label'       => esc_html__( 'Forgot password Form Title', 'finder' ),
					'description' => esc_html__( 'This setting allows you to change the reset password page title', 'finder' ),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_register_password_title',
				array(
					'selector'         => '.finder_register_password_title',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_register_password_desc',
				array(
					'default'           => esc_html__( 'Enter your email to reset your password.', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_register_password_desc',
				array(
					'type'        => 'textarea',
					'section'     => 'finder_account_section',
					'label'       => esc_html__( 'Forgot password Form Description', 'finder' ),
					'description' => esc_html__( 'This setting allows you to change the reset password page description', 'finder' ),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_register_password_desc',
				array(
					'selector'         => '.finder_register_password_description',
					'fallback_refresh' => true,
				)
			);
		}

		/**
		 * General Panel
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_general( $wp_customize ) {

			$wp_customize->add_panel(
				'finder_general_panel',
				array(
					'priority'    => 30,
					'title'       => esc_html__( 'General', 'finder' ),
					'description' => esc_html__( 'Option for offcanvas', 'finder' ),
				)
			);
			$this->add_finder_offcanvas_settings( $wp_customize );
			$this->add_finder_enable_scroll_to_top( $wp_customize );
		}

		/**
		 * Customize enable_scroll_to_top.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_finder_enable_scroll_to_top( $wp_customize ) {
			$wp_customize->add_section(
				'finder_enable_scroll_to_top',
				array(
					'title'       => esc_html__( 'Scroll to Top', 'finder' ),
					'description' => esc_html__( 'Customize the theme scroll to top.', 'finder' ),
					'priority'    => 20,
					'panel'       => 'finder_general_panel',
				)
			);
			$wp_customize->add_setting(
				'enable_scroll_to_top',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);
			$wp_customize->add_control(
				'enable_scroll_to_top',
				array(
					'type'    => 'radio',
					'section' => 'finder_enable_scroll_to_top',
					'label'   => esc_html__( 'Enable Scroll to Top', 'finder' ),
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
				)
			);
			$wp_customize->selective_refresh->add_partial(
				'enable_scroll_to_top',
				array(
					'fallback_refresh' => true,
				)
			);
		}

		/**
		 * Customize offcanvas.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_finder_offcanvas_settings( $wp_customize ) {
			$wp_customize->add_section(
				'finder_offcanvas',
				array(
					'title'       => esc_html__( 'Offcanvas', 'finder' ),
					'description' => esc_html__( 'Customize the theme offcanvas.', 'finder' ),
					'priority'    => 10,
					'panel'       => 'finder_general_panel',
				)
			);

			$wp_customize->add_setting(
				'finder_enable_offcanvas',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_enable_offcanvas',
				array(
					'type'    => 'radio',
					'section' => 'finder_offcanvas',
					'label'   => esc_html__( 'Enable Offcanvas ?  ', 'finder' ),
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
				)
			);

			$wp_customize->add_setting(
				'finder_offcanvas_title',
				array(
					'default'           => esc_html_x( 'Choose Demo', 'title', 'finder' ),
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => 'postMessage',
				)
			);
			$wp_customize->add_control(
				'finder_offcanvas_title',
				array(
					'type'            => 'text',
					'section'         => 'finder_offcanvas',
					'label'           => esc_html__( 'Offcanvas Title', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_enable_offcanvas', 'no' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_offcanvas_title',
				array(
					'selector'         => '.finder-offcanvas-title',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_offcanvas_footer_button_color',
				array(
					'default'           => 'primary',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_offcanvas_footer_button_color',
				array(
					'type'            => 'select',
					'section'         => 'finder_offcanvas',
					'label'           => esc_html__( 'Offcanvas Footer Button Color', 'finder' ),
					'choices'         => array(
						'primary'  => esc_html_x( 'Primary', 'button', 'finder' ),
						'accent'   => esc_html_x( 'Accent', 'button', 'finder' ),
						'success'  => esc_html_x( 'Success', 'button', 'finder' ),
						'danger'   => esc_html_x( 'Danger', 'button', 'finder' ),
						'warning'  => esc_html_x( 'Warning', 'button', 'finder' ),
						'info'     => esc_html_x( 'Info', 'button', 'finder' ),
						'dark'     => esc_html_x( 'Dark', 'button', 'finder' ),
						'gradient' => esc_html_x( 'Gradient', 'button', 'finder' ),
						'link'     => esc_html_x( 'Link', 'button', 'finder' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_enable_offcanvas', 'no' );
					},

				)
			);

			$wp_customize->add_setting(
				'finder_offcanvas_footer_button_text',
				array(
					'default'           => esc_html__( 'Buy Finder', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_offcanvas_footer_button_text',
				array(
					'type'            => 'text',
					'section'         => 'finder_offcanvas',
					'label'           => esc_html__( 'Offcanvas Footer Button Text', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button text', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_enable_offcanvas', 'no' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_offcanvas_footer_button_text',
				array(
					'selector'         => '.finder-offcanvas-footer-button',
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_offcanvas_footer_button_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'finder_offcanvas_footer_button_url',
				array(
					'type'            => 'url',
					'section'         => 'finder_offcanvas',
					'label'           => esc_html__( 'Offcanvas Footer Button Link', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button link', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_enable_offcanvas', 'no' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_offcanvas_footer_button_size',
				array(
					'default'           => 'lg',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_offcanvas_footer_button_size',
				array(
					'type'            => 'select',
					'section'         => 'finder_offcanvas',
					'label'           => esc_html__( 'Offcanvas Footer Button Size', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your button size.', 'finder' ),
					'choices'         => array(
						'xs' => esc_html__( 'Extra Small', 'finder' ),
						'sm' => esc_html__( 'Small', 'finder' ),
						'lg' => esc_html__( 'Large', 'finder' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_enable_offcanvas', 'no' );
					},

				)
			);

			$wp_customize->add_setting(
				'finder_offcanvas_footer_button_icon',
				array(
					'default'           => 'fi-cart',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_offcanvas_footer_button_icon',
				array(
					'type'            => 'text',
					'section'         => 'finder_offcanvas',
					'label'           => esc_html__( 'Offcanvas Footer Button Icon', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button icon', 'finder' ),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_enable_offcanvas', 'no' );
					},

				)
			);

			$wp_customize->add_setting(
				'finder_offcanvas_icon_position',
				array(
					'default'           => 'end',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_offcanvas_icon_position',
				array(
					'type'            => 'select',
					'section'         => 'finder_offcanvas',
					'label'           => esc_html__( 'Offcanvas Start Icon Position', 'finder' ),
					'choices'         => array(
						'start' => esc_html_x( 'Start', 'position', 'finder' ),
						'end'   => esc_html_x( 'End', 'position', 'finder' ),
					),
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_enable_offcanvas', 'no' );
					},

				)
			);

		}

		/**
		 * Blog Panel
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_blog( $wp_customize ) {

			$wp_customize->add_panel(
				'finder_blog_post_panel',
				array(
					'priority'    => 100,
					'title'       => esc_html__( 'Blog', 'finder' ),
					'description' => esc_html__( 'Option for blog single post', 'finder' ),
				)
			);

			$this->add_single_post_settings( $wp_customize );
			$this->add_blog_post_settings( $wp_customize );
		}

		/**
		 * Customize all available Blog posts styles
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function add_blog_post_settings( $wp_customize ) {
			$wp_customize->add_section(
				'finder_blog_post_section',
				array(
					'priority' => 10,
					'title'    => esc_html__( 'Blog Archive', 'finder' ),
					'panel'    => 'finder_blog_post_panel',
				)
			);

			$wp_customize->add_setting(
				'finder_blog_post_style',
				array(
					'default'           => 'default',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_blog_post_style',
				array(
					'label'       => esc_html__( 'Blog Styles', 'finder' ),
					'description' => esc_html__( 'Select blog post version', 'finder' ),
					'section'     => 'finder_blog_post_section',
					'priority'    => 30,
					'type'        => 'select',
					'choices'     => array(
						'default'     => 'Default',
						'real-estate' => 'Real Estate',
						'car-finder'  => 'Car Finder',
						'city-guide'  => 'City Guide',
						'job-board'   => 'Job Board',
					),
				)
			);

			// $wp_customize->add_setting(
			// 	'finder_blog_archive_columns',
			// 	array(
			// 		'default'           => '4',
			// 		'sanitize_callback' => 'sanitize_key',
			// 	)
			// );

			// $wp_customize->add_control(
			// 	'finder_blog_archive_columns',
			// 	array(
			// 		'type'            => 'select',
			// 		'section'         => 'finder_blog_post_section',
			// 		'priority'        => 40,
			// 		'label'           => esc_html__( ' Columns', 'finder' ),
			// 		'choices'         => array(
			// 			'1' => esc_html__( '1', 'finder' ),
			// 			'2' => esc_html__( '2', 'finder' ),
			// 			'3' => esc_html__( '3', 'finder' ),
			// 			'4' => esc_html__( '4', 'finder' ),
			// 			'5' => esc_html__( '5', 'finder' ),
			// 			'6' => esc_html__( '6', 'finder' ),

			// 		),
			// 		'active_callback' => function () {
			// 			return 'city-guide' !== get_theme_mod( 'finder_blog_post_style' );
			// 		},
			// 	)
			// );

			$wp_customize->add_setting(
				'blog_sidebar',
				array(
					'default'           => 'full-width',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'blog_sidebar',
				array(
					'type'            => 'select',
					'section'         => 'finder_blog_post_section',
					'priority'        => 50,
					/* translators: label field of control in Customizer */
					'label'           => esc_html__( 'Blog Sidebar', 'finder' ),
					'description'     => esc_html__( 'This setting affects blog archives. This works when blog sidebar has widgets', 'finder' ),
					'choices'         => array(
						'sidebar-left'  => esc_html__( 'Left Sidebar', 'finder' ),
						'sidebar-right' => esc_html__( 'Right Sidebar', 'finder' ),
						'full-width'    => esc_html__( 'Full Width', 'finder' ),
					),
					'active_callback' => function () {
						return ( is_active_sidebar( 'sidebar-blog' ) && in_array( get_theme_mod( 'finder_blog_post_style' ), array( 'job-board', 'city-guide' ), true ) );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'blog_sidebar',
				array(
					'fallback_refresh' => true,
				)
			);
		}

		/**
		 * Customize all available single posts styles
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function add_single_post_settings( $wp_customize ) {
			$wp_customize->add_section(
				'blog_single_post_section',
				array(
					'priority' => 10,
					'title'    => esc_html__( 'Blog Single', 'finder' ),
					'panel'    => 'finder_blog_post_panel',
				)
			);

			$wp_customize->add_setting(
				'finder_blog_single_style',
				array(
					'default'           => 'default',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_blog_single_style',
				array(
					'label'       => esc_html__( 'Style', 'finder' ),
					'description' => esc_html__( 'Select single post version', 'finder' ),
					'section'     => 'blog_single_post_section',
					'priority'    => 10,
					'type'        => 'select',
					'choices'     => array(
						'default' => 'Default',
						'real-estate' => 'Real Estate',
						'job-board'   => 'Job Board',
						'city-guide'  => 'City Guide',
						'car-finder'  => 'Car Finder',
					),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_single_post_social_share',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_single_post_social_share',
				array(
					'default'           => false,
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_single_post_social_share',
				array(
					'type'        => 'checkbox',
					'priority'    => 20,
					'label'       => esc_html__( 'Single post social share', 'finder' ),
					'description' => esc_html__( 'This setting allows you to enable or disable post social share.', 'finder' ),
					'section'     => 'blog_single_post_section',
					'active_callback' => function () {
						return get_theme_mod( 'finder_blog_single_style' ) !== 'default';
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_single_post_related_post',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_single_post_related_post',
				array(
					'default'           => false,
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_single_post_related_post',
				array(
					'type'        => 'checkbox',
					'priority'    => 30,
					'label'       => esc_html__( 'Single post related posts', 'finder' ),
					'description' => esc_html__( 'This setting allows you to enable or disable related posts', 'finder' ),
					'section'     => 'blog_single_post_section',
					'active_callback' => function () {
						return get_theme_mod( 'finder_blog_single_style' ) !== 'default';
					},
				)
			);

			$wp_customize->add_setting(
				'finder_related_posts_title_text',
				array(
					'default'           => esc_html__( 'You may be also interested in', 'finder' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_related_posts_title_text',
				array(
					'label'           => esc_html__( 'Related Post Text', 'finder' ),
					'description'     => esc_html__( 'Enter your custom title', 'finder' ),
					'section'         => 'blog_single_post_section',
					'priority'        => 40,
					'type'            => 'text',
					'active_callback' => function () {
						return true == get_theme_mod( 'finder_single_post_related_post' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_related_posts_title_text',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_related_posts_link_text',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_related_posts_link_text',
				array(
					'default'           => esc_html__( 'Go to blog', 'finder' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_related_posts_link_text',
				array(
					'label'           => esc_html__( 'Related Post Link Text', 'finder' ),
					'description'     => esc_html__( 'Enter your custom link text', 'finder' ),
					'section'         => 'blog_single_post_section',
					'priority'        => 50,
					'type'            => 'text',
					'active_callback' => function () {
						return true == get_theme_mod( 'finder_single_post_related_post' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_related_posts_action_text_url',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_related_posts_action_text_url',
				array(
					'label'           => esc_html__( 'Related Post Url', 'finder' ),
					'description'     => esc_html__( 'Enter your custom url', 'finder' ),
					'section'         => 'blog_single_post_section',
					'priority'        => 60,
					'type'            => 'url',
					'active_callback' => function () {
						return true == get_theme_mod( 'finder_single_post_related_post' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_related_posts_action_text_url',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_related_posts_column_options',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 1,
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				'finder_related_posts_column_options',
				array(
					'type'            => 'number',
					'section'         => 'blog_single_post_section',
					'label'           => esc_html__( 'Related Post Column options', 'finder' ),
					'description'     => esc_html__( 'Enter your custom number.', 'finder' ),
					'priority'        => 70,
					'active_callback' => function () {
						return true == get_theme_mod( 'finder_single_post_related_post' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_related_posts_per_page_options',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 1,
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				'finder_related_posts_per_page_options',
				array(
					'type'            => 'number',
					'section'         => 'blog_single_post_section',
					'label'           => esc_html__( 'Related Post per page options', 'finder' ),
					'description'     => esc_html__( 'Enter your custom number.', 'finder' ),
					'priority'        => 80,
					'active_callback' => function () {
						return true == get_theme_mod( 'finder_single_post_related_post' );
					},
				)
			);

			$wp_customize->add_setting(
				'blog_single_sidebar',
				array(
					'default'           => 'full-width',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'blog_single_sidebar',
				array(
					'type'            => 'select',
					'section'         => 'blog_single_post_section',
					'priority'        => 50,
					/* translators: label field of control in Customizer */
					'label'           => esc_html__( 'Blog Single Sidebar', 'finder' ),
					'description'     => esc_html__( 'This setting affects blog single post. This works when blog sidebar has widgets', 'finder' ),
					'choices'         => array(
						'left-sidebar'  => esc_html__( 'Left Sidebar', 'finder' ),
						'right-sidebar' => esc_html__( 'Right Sidebar', 'finder' ),
						'full-width'    => esc_html__( 'Full Width', 'finder' ),
					),
					'active_callback' => function () {
						return ( is_active_sidebar( 'blog-single-sidebar' ) && in_array( get_theme_mod( 'finder_blog_single_style' ), array( 'job-board', 'city-guide', 'car-finder' ), true ) );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'blog_single_sidebar',
				array(
					'fallback_refresh' => true,
				)
			);
		}

		/**
		 * Customize site 404
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_404( $wp_customize ) {

			$wp_customize->add_section(
				'finder_404',
				array(
					'title'    => esc_html__( '404', 'finder' ),
					'priority' => 110,
				)
			);

			$this->add_404_section( $wp_customize );
		}

		/**
		 * Customizer Controls For site 404.
		 *
		 *  @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_404_section( $wp_customize ) {

			$wp_customize->add_setting(
				'finder_404_version',
				array(
					'default'           => 'v1',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_404_version',
				array(
					'type'        => 'select',
					'section'     => 'finder_404',
					'label'       => esc_html__( '404 Page Variant', 'finder' ),
					'description' => esc_html__( 'This setting allows you to choose your 404 page types.', 'finder' ),
					'choices'     => array(
						'v1' => esc_html__( '404 v1', 'finder' ),
						'v2' => esc_html__( '404 v2', 'finder' ),
						'v3' => esc_html__( '404 v3', 'finder' ),
						'v4' => esc_html__( '404 v4', 'finder' ),
					),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_404_image_option',
				array(
					'selector'        => '.404_image',
					'render_callback' => function () {
						return esc_html( get_theme_mod( '404_image_option' ) );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_image_option',
				array(
					'transport'         => 'postMessage',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					'finder_404_image_option',
					array(
						'section'     => 'finder_404',
						'label'       => esc_html__( '404 Image Upload', 'finder' ),
						'description' => esc_html__(
							'This setting allows you to upload an image for 404 page.',
							'finder'
						),
						'mime_type'   => 'image',
					)
				)
			);

			$wp_customize->add_setting(
				'finder_404_title',
				array(
					'default'           => 'Page Not Found.',
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_404_title',
				array(
					'type'    => 'textarea',
					'section' => 'finder_404',
					'label'   => esc_html__( '404 Title', 'finder' ),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_404_title',
				array(
					'selector'        => '.404_title',
					'render_callback' => function () {
						return esc_html( get_theme_mod( 'finder_404_title' ) );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_description',
				array(
					'default'           => esc_html__( 'Sorry, we can’t find the page you are looking for. We suggest you go to homepage while we are fixing the problem.', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_404_description',
				array(
					'type'    => 'textarea',
					'section' => 'finder_404',
					'label'   => esc_html__( 'Description', 'finder' ),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_404_description',
				array(
					'selector'        => '.404_desc',
					'render_callback' => function () {
						return esc_html( get_theme_mod( 'finder_404_description' ) );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_primary_button_text',
				array(
					'default'           => esc_html__( 'Go to homepage', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_404_primary_button_text',
				array(
					'type'            => 'text',
					'section'         => 'finder_404',
					'label'           => esc_html__( 'Primary Button Text', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button text', 'finder' ),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' );
					},

				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_404_primary_button_text',
				array(
					'selector'         => '.404_primary_button_text',
					'fallback_refresh' => true,

				)
			);

			$wp_customize->add_setting(
				'finder_404_primary_button_color',
				array(
					'default'           => 'primary',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_404_primary_button_color',
				array(
					'type'            => 'select',
					'section'         => 'finder_404',
					'label'           => esc_html__( 'Primary Button Color', 'finder' ),
					'choices'         => array(
						'primary' => esc_html_x( 'Primary', 'button', 'finder' ),
						'success' => esc_html_x( 'Success', 'button', 'finder' ),
						'danger'  => esc_html_x( 'Danger', 'button', 'finder' ),
						'warning' => esc_html_x( 'Warning', 'button', 'finder' ),
						'info'    => esc_html_x( 'Info', 'button', 'finder' ),
						'dark'    => esc_html_x( 'Dark', 'button', 'finder' ),
						'accent'  => esc_html_x( 'Accent', 'button', 'finder' ),
						'link'    => esc_html_x( 'Link', 'button', 'finder' ),
					),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_primary_button_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'finder_404_primary_button_url',
				array(
					'type'            => 'url',
					'section'         => 'finder_404',
					'label'           => esc_html__( 'Primary Button Url', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change button url.', 'finder' ),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_primary_button_shape',
				array(
					'default'           => 'default',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_404_primary_button_shape',
				array(
					'type'            => 'select',
					'section'         => 'finder_404',
					'label'           => esc_html__( 'Primary Button Shape', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your 404 Page button shape.', 'finder' ),
					'choices'         => array(
						'default'      => esc_html__( 'Default', 'finder' ),
						'rounded-pill' => esc_html__( 'Pill', 'finder' ),
						'rounded-0'    => esc_html__( 'Square', 'finder' ),
					),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_primary_button_size',
				array(
					'default'           => 'lg',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_404_primary_button_size',
				array(
					'type'            => 'select',
					'section'         => 'finder_404',
					'label'           => esc_html__( 'Primary Button Size', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your 404 page primary button size.', 'finder' ),
					'choices'         => array(
						'xs' => esc_html__( 'Extra Small', 'finder' ),
						'sm' => esc_html__( 'Small', 'finder' ),
						'lg' => esc_html__( 'Large', 'finder' ),
					),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_enable_secondary_button',
				array(
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_404_enable_secondary_button',
				array(
					'type'        => 'radio',
					'section'     => 'finder_404',
					'label'       => esc_html__( 'Enable Secondary Button ?  ', 'finder' ),
					'description' => esc_html__( 'This setting allows you to enable or disable secondary button.', 'finder' ),
					'choices'     => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_link_button_text',
				array(
					'default'           => esc_html__( 'Visit help center', 'finder' ),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'finder_404_link_button_text',
				array(
					'type'            => 'text',
					'section'         => 'finder_404',
					'label'           => esc_html__( 'Secondary Button Text', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the button text', 'finder' ),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' ) && 'yes' === get_theme_mod( 'finder_404_enable_secondary_button', 'no' );
					},

				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_404_link_button_text',
				array(
					'selector'         => '.404_link_button_text',
					'fallback_refresh' => true,

				)
			);

			$wp_customize->add_setting(
				'finder_404_link_button_color',
				array(
					'default'           => 'light',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_404_link_button_color',
				array(
					'type'            => 'select',
					'section'         => 'finder_404',
					'label'           => esc_html__( 'Secondary Button Color', 'finder' ),
					'choices'         => array(
						'primary' => esc_html__( 'Primary', 'finder' ),
						'success' => esc_html__( 'Success', 'finder' ),
						'danger'  => esc_html__( 'Danger', 'finder' ),
						'warning' => esc_html__( 'Warning', 'finder' ),
						'info'    => esc_html__( 'Info', 'finder' ),
						'dark'    => esc_html__( 'Dark', 'finder' ),
						'accent'  => esc_html__( 'Accent', 'finder' ),
						'link'    => esc_html__( 'Link', 'finder' ),
						'light'   => esc_html__( 'Light', 'finder' ),
					),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' ) && 'yes' === get_theme_mod( 'finder_404_enable_secondary_button', 'no' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_link_button_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'finder_404_link_button_url',
				array(
					'type'            => 'url',
					'section'         => 'finder_404',
					'label'           => esc_html__( 'Secondary Button Url', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change button url.', 'finder' ),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' ) && 'yes' === get_theme_mod( 'finder_404_enable_secondary_button', 'no' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_link_button_shape',
				array(
					'default'           => 'default',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_404_link_button_shape',
				array(
					'type'            => 'select',
					'section'         => 'finder_404',
					'label'           => esc_html__( 'Secondary Button Shape', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your 404 Page Secondary button shape.', 'finder' ),
					'choices'         => array(
						'default'      => esc_html__( 'Default', 'finder' ),
						'rounded-pill' => esc_html__( 'Pill', 'finder' ),
						'rounded-0'    => esc_html__( 'Square', 'finder' ),
					),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' ) && 'yes' === get_theme_mod( 'finder_404_enable_secondary_button', 'no' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_link_button_size',
				array(
					'default'           => 'lg',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_404_link_button_size',
				array(
					'type'            => 'select',
					'section'         => 'finder_404',
					'label'           => esc_html__( 'Secondary Button Size', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your 404 page secondary button size.', 'finder' ),
					'choices'         => array(
						'xs' => esc_html__( 'Extra Small', 'finder' ),
						'sm' => esc_html__( 'Small', 'finder' ),
						'lg' => esc_html__( 'Large', 'finder' ),
					),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' ) && 'yes' === get_theme_mod( 'finder_404_enable_secondary_button', 'no' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_404_link_button_variant',
				array(
					'default'           => 'outline',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_404_link_button_variant',
				array(
					'type'            => 'select',
					'section'         => 'finder_404',
					'label'           => esc_html__( 'Secondary Button Variant', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to choose your 404 Page secondary button variant.', 'finder' ),
					'choices'         => array(
						''            => esc_html__( 'Default', 'finder' ),
						'outline'     => esc_html__( 'Outline', 'finder' ),
						'translucent' => esc_html__( 'Translucent', 'finder' ),
					),
					'active_callback' => function () {
						return 'v3' !== get_theme_mod( 'finder_404_version' ) && 'yes' === get_theme_mod( 'finder_404_enable_secondary_button', 'no' );
					},
				)
			);
		}

		/**
		 * Footer Panel
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_footer( $wp_customize ) {

			$wp_customize->add_section(
				'finder_footer_style',
				array(
					'title'    => esc_html__( 'Footer', 'finder' ),
					'priority' => 50,
				)
			);

			$this->add_footer_settings( $wp_customize );
		}

		/**
		 * Customize all available Blog posts styles
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		private function add_footer_settings( $wp_customize ) {

			$wp_customize->add_setting(
				'finder_footer_version',
				array(
					'default'           => 'v6',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_footer_version',
				array(
					'type'        => 'select',
					'section'     => 'finder_footer_style',
					'label'       => esc_html__( 'Footer Variant', 'finder' ),
					'description' => esc_html__( 'This setting allows you to choose your footer type.', 'finder' ),
					'choices'     => array(
						'v1' => esc_html__( 'Footer v1', 'finder' ),
						'v2' => esc_html__( 'Footer v2', 'finder' ),
						'v3' => esc_html__( 'Footer v3', 'finder' ),
						'v4' => esc_html__( 'Footer v4', 'finder' ),
						'v5' => esc_html__( 'Footer v5', 'finder' ),
						'v6' => esc_html__( 'Footer v6', 'finder' ),

					),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'footer_form_title',
				array(
					'selector' => '.footer-form-title',
				)
			);

			$wp_customize->add_setting(
				'footer_form_title',
				array(
					'default'           => esc_html__( 'Subscribe to our newsletter', 'finder' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'footer_form_title',
				array(
					'label'           => esc_html__( 'Form Title', 'finder' ),
					'description'     => esc_html__( 'Title of your form to be displayed in the footer.', 'finder' ),
					'type'            => 'text',
					'section'         => 'finder_footer_style',
					'active_callback' => function () {
						return 'v1' === get_theme_mod( 'finder_footer_version' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'footer_newsletter_subscription_form',
				array(
					'selector' => '.footer-form',
				)
			);

			$wp_customize->add_setting(
				'footer_newsletter_subscription_form',
				array(
					'default'           => finder_sanitize_html( '<form class="subscription-form validate"><div class="form-group form-group-light rounded-pill"><div class="input-group flex-nowrap"><span class="input-group-text text-muted"><i class="fi-mail"></i></span><input class="form-control" type="email" name="EMAIL" placeholder="Your email" required></div><button class="btn btn-primary rounded-pill" type="submit" name="subscribe">Subscribe*</button></div></form>' ),
					'sanitize_callback' => 'finder_sanitize_html',
				)
			);

			$wp_customize->add_control(
				'footer_newsletter_subscription_form',
				array(
					'type'            => 'textarea',
					'section'         => 'finder_footer_style',
					'label'           => esc_html__( 'Enter Newsletter Form Shortcode', 'finder' ),
					'description'     => esc_html__( 'Paste your newsletter signup form or shortcode', 'finder' ),
					'active_callback' => function () {
						return 'v1' === get_theme_mod( 'finder_footer_version' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'footer_form_description',
				array(
					'selector' => '.footer-form-desc',
				)
			);

			$wp_customize->add_setting(
				'footer_form_description',
				array(
					'default'           => esc_html__( '*Subscribe to our newsletter to receive early discount offers, updates and new products info.', 'finder' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'footer_form_description',
				array(
					'label'           => esc_html__( 'Footer Form Description', 'finder' ),
					'description'     => esc_html__( 'Description of your form to be displayed in the footer.', 'finder' ),
					'type'            => 'textarea',
					'section'         => 'finder_footer_style',
					'active_callback' => function () {
						return 'v1' === get_theme_mod( 'finder_footer_version' );
					},
				)
			);

			$wp_customize->add_setting(
				'banner_image_option',
				array(
					'default'           => '',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'banner_image_option',
					array(
						'label'           => esc_html__( 'Upload a banner image', 'finder' ),
						'description'     => esc_html__( 'Upload a banner image for footer', 'finder' ),
						'section'         => 'finder_footer_style',
						'active_callback' => function () {
							return in_array(
								get_theme_mod( 'finder_footer_version' ),
								array(
									'v2',
									'v4',
								),
								true
							);
						},
					)
				)
			);

			$wp_customize->add_setting(
				'banner_appstore_image_option',
				array(
					'default'           => '',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'banner_appstore_image_option',
					array(
						'label'           => esc_html__( 'Upload a banner appstore image', 'finder' ),
						'description'     => esc_html__( 'Upload a banner appstore image for footer', 'finder' ),
						'section'         => 'finder_footer_style',
						'active_callback' => function () {
							return in_array(
								get_theme_mod( 'finder_footer_version' ),
								array(
									'v2',
									'v4',
								),
								true
							);
						},
					)
				)
			);

			$wp_customize->add_setting(
				'banner_appstore_image_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'banner_appstore_image_url',
				array(
					'type'            => 'url',
					'section'         => 'finder_footer_style',
					'label'           => esc_html__( 'Banner appstore image Link', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the Banner appstore image link', 'finder' ),
					'active_callback' => function () {
						return in_array(
							get_theme_mod( 'finder_footer_version' ),
							array(
								'v2',
								'v4',
							),
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'banner_googleplay_image_option',
				array(
					'default'           => '',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'banner_googleplay_image_option',
					array(
						'label'           => esc_html__( 'Upload a banner googleplay image', 'finder' ),
						'description'     => esc_html__( 'Upload a banner googleplay image for footer', 'finder' ),
						'section'         => 'finder_footer_style',
						'active_callback' => function () {
								return in_array(
									get_theme_mod( 'finder_footer_version' ),
									array(
										'v2',
										'v4',
									),
									true
								);
						},
					)
				)
			);

			$wp_customize->add_setting(
				'banner_googleplay_image_url',
				array(
					'default'           => '#',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'banner_googleplay_image_url',
				array(
					'type'            => 'url',
					'section'         => 'finder_footer_style',
					'label'           => esc_html__( 'Banner googleplay image Link', 'finder' ),
					'description'     => esc_html__( 'This setting allows you to change the Banner googleplay image link', 'finder' ),
					'active_callback' => function () {
						return in_array(
							get_theme_mod( 'finder_footer_version' ),
							array(
								'v2',
								'v4',
							),
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'footer_banner_title',
				array(
					'default'           => 'Download Our App',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'footer_banner_title',
				array(
					'label'           => esc_html__( 'Footer Banner Title', 'finder' ),
					'description'     => esc_html__( 'Title of your banner to be displayed in the footer.', 'finder' ),
					'type'            => 'text',
					'section'         => 'finder_footer_style',
					'active_callback' => function () {
						return in_array(
							get_theme_mod( 'finder_footer_version' ),
							array(
								'v2',
								'v4',

							),
							true
						);
					},
				)
			);

			$wp_customize->add_setting(
				'footer_banner_description',
				array(
					'default'           => 'Find everything you need for buying, selling & renting property in our new Finder App!',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'footer_banner_description',
				array(
					'label'           => esc_html__( 'Footer Banner Description', 'finder' ),
					'description'     => esc_html__( 'Description of your banner to be displayed in the footer.', 'finder' ),
					'type'            => 'textarea',
					'section'         => 'finder_footer_style',
					'active_callback' => function () {
						return in_array(
							get_theme_mod( 'finder_footer_version' ),
							array(
								'v2',
								'v4',

							),
							true
						);
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'footer_copyright',
				array(
					'selector' => '.footer-copyright',
				)
			);

			$wp_customize->add_setting(
				'footer_copyright',
				array(
					'default'           => sprintf(/* translators: footer copy  rights*/
						'<span class="text-light">© All rights reserved. Made by </span><a class="nav-link-light fw-bold" href="https://madrasthemes.com" target="_blank" rel="noopener"> %s</a>',
						get_bloginfo( ' name' )
					),
					'sanitize_callback' => 'wp_filter_post_kses',
				)
			);

			$wp_customize->add_control(
				'footer_copyright',
				array(
					'label'       => esc_html__( 'Copyright Text', 'finder' ),
					'description' => esc_html__( 'Enter your copyright text below', 'finder' ),
					'type'        => 'textarea',
					'section'     => 'finder_footer_style',
				)
			);
		}

		/**
		 * Customize site Custom Theme Color
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_customcolor( $wp_customize ) {
			/*
			 * Custom Color Enable / Disble Toggle
			 */
			$wp_customize->add_setting(
				'finder_enable_custom_color',
				[
					'default'           => 'no',
					'sanitize_callback' => 'sanitize_key',
				]
			);

			$wp_customize->add_control(
				'finder_enable_custom_color',
				[
					'type'        => 'radio',
					'section'     => 'colors',
					'label'       => esc_html__( 'Enable Custom Color?', 'finder' ),
					'description' => esc_html__(
						'This settings allow you to apply your custom color option.',
						'finder'
					),
					'choices'     => [
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					],
				]
			);

			/**
			 * Primary Color
			 */
			$wp_customize->add_setting(
				'finder_primary_color',
				array(
					'default'           => apply_filters( 'finder_default_primary_color', '#fd5631' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'finder_primary_color',
					array(
						'label'           => esc_html__( 'Primary color', 'finder' ),
						'section'         => 'colors',
						'settings'        => 'finder_primary_color',
						'active_callback' => function () {
							return get_theme_mod( 'finder_enable_custom_color', 'no' ) === 'yes';
						},
					)
				)
			);
		}


		/**
		 * Scripts to improve our form.
		 */
		public function add_scripts() {
			$blog_url = finder_get_blog_page_permalink();

			?>
			<script type="text/javascript">
				jQuery( function( $ ) {
					wp.customize.section( 'finder_blog_post_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $blog_url ); ?>' );
							}
						} );
					} );
				} );
			</script>
			<?php
		}
	}

endif;

return new Finder_Customizer();
