<?php
/**
 * Finder Job Manager Customizer Class
 *
 * @package  finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Finder_WPJM_Customizer' ) ) :


	/**
	 * The Finder WP Job Customizer class
	 */
	class Finder_WPJM_Customizer extends Finder_Customizer {
		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_jobmanager' ), 10 );
			add_action( 'customize_controls_print_scripts', array( $this, 'add_scripts' ), 30 );
		}

		/**
		 * Jobmanager Panel
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_jobmanager( $wp_customize ) {

			$wp_customize->add_panel(
				'jobmanager_panel',
				array(
					'priority'    => 110,
					'title'       => esc_html__( 'Job Manager', 'finder' ),
					'description' => esc_html__( 'Option for jobmanager single job', 'finder' ),
				)
			);

			$this->add_jobmanager_single_job_settings( $wp_customize );
			$this->add_wpjm_job_listing_settings( $wp_customize );

		}

		/**
		 * Customize Jobmanager Job Listing
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function add_wpjm_job_listing_settings( $wp_customize ) {

			$wp_customize->add_section(
				'finder_job_listing_section',
				array(
					'priority' => 10,
					'title'    => esc_html__( 'Job Listing', 'finder' ),
					'panel'    => 'jobmanager_panel',
				)
			);

			$wp_customize->add_setting(
				'finder_wpjm_listings_layout',
				array(
					'default'           => 'right-sidebar',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_wpjm_listings_layout',
				array(
					'label'       => esc_html__( 'Listings Layout', 'finder' ),
					'description' => esc_html__( 'Select listings layout', 'finder' ),
					'section'     => 'finder_job_listing_section',
					'priority'    => 10,
					'type'        => 'select',
					'choices'     => array(
						'left-sidebar'  => 'Left Sidebar',
						'right-sidebar' => 'Right Sidebar',
						'full-width'    => 'Full Width',
					),

				)
			);
		}

		/**
		 * Customize Jobmanager single Job
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function add_jobmanager_single_job_settings( $wp_customize ) {

			$wp_customize->add_section(
				'jobmanager_single_job_section',
				array(
					'priority' => 10,
					'title'    => esc_html__( 'Jobmanager Single', 'finder' ),
					'panel'    => 'jobmanager_panel',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_jobmanager_single_post_related_post',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_jobmanager_single_post_related_post',
				array(
					'default' => false,
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_jobmanager_single_post_related_post',
				array(
					'type'        => 'checkbox',
					'priority'    => 10,
					'label'       => esc_html__( 'Jobmanager single related posts', 'finder' ),
					'description' => esc_html__( 'This setting allows you to enable or disable related posts', 'finder' ),
					'section'     => 'jobmanager_single_job_section',

				)
			);

			$wp_customize->add_setting(
				'job_related_single_job_title_text',
				array(
					'default'           => esc_html__( 'You may be interested in', 'finder' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'job_related_single_job_title_text',
				array(
					'label'           => esc_html__( 'Related Job Text', 'finder' ),
					'description'     => esc_html__( 'Enter your custom title', 'finder' ),
					'section'         => 'jobmanager_single_job_section',
					'priority'        => 20,
					'type'            => 'text',
					'active_callback' => function () {
						return get_theme_mod( 'finder_jobmanger_single_post_related_post' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'job_related_single_job_title_text',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'job_related_single_job_link_text',
				array(
					'default'           => esc_html__( 'View all', 'finder' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'job_related_single_job_link_text',
				array(
					'label'           => esc_html__( 'Related Job Link Text', 'finder' ),
					'description'     => esc_html__( 'Enter your custom link text', 'finder' ),
					'section'         => 'jobmanager_single_job_section',
					'priority'        => 30,
					'type'            => 'text',
					'active_callback' => function () {
						return get_theme_mod( 'finder_jobmanger_single_post_related_post' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'job_related_single_job_link_text',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'job_related_single_job_link_text_url',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'job_related_single_job_link_text_url',
				array(
					'label'           => esc_html__( 'Related Job Url', 'finder' ),
					'description'     => esc_html__( 'Enter your custom url', 'finder' ),
					'section'         => 'jobmanager_single_job_section',
					'priority'        => 40,
					'type'            => 'url',
					'active_callback' => function () {
						return get_theme_mod( 'finder_jobmanger_single_post_related_post' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'job_related_single_job_link_text_url',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_jobmanager_single_layout',
				array(
					'default'           => 'right-sidebar',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_jobmanager_single_layout',
				array(
					'label'       => esc_html__( 'Single Layout', 'finder' ),
					'description' => esc_html__( 'Select sidebar layout', 'finder' ),
					'section'     => 'jobmanager_single_job_section',
					'priority'    => 60,
					'type'        => 'select',
					'choices'     => array(
						'right-sidebar' => 'Right Sidebar',
						'full-width'    => 'Full Width',
					),

				)
			);

			$wp_customize->add_setting(
				'finder_job_related_posts_per_page_options',
				array(
					'capability' => 'edit_theme_options',
					'default'    => 1,
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				'finder_job_related_posts_per_page_options',
				array(
					'type'            => 'number',
					'section'         => 'jobmanager_single_job_section',
					'label'           => esc_html__( 'Related Post per page options', 'finder' ),
					'description'     => esc_html__( 'Enter your custom number.', 'finder' ),
					'priority'        => 50,
					'active_callback' => function () {
						return get_theme_mod( 'finder_jobmanger_single_post_related_post' );
					},

				)
			);

		}

	}

endif;

return new Finder_WPJM_Customizer();
