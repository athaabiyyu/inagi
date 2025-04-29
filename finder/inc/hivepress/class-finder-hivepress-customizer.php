<?php
/**
 * Finder Hivepress Customizer Class
 *
 * @package  finder
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Finder_Hivepress_Customizer' ) ) :

	/**
	 * The Finder Hivepress Customizer Class
	 */
	class Finder_Hivepress_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_hivepress' ), 10 );
			add_action( 'customize_controls_print_scripts', array( $this, 'add_scripts' ), 30 );
		}

		/**
		 * Hivepress Panel
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function customize_hivepress( $wp_customize ) {

			$wp_customize->add_panel(
				'hivepress_panel',
				array(
					'priority' => 100,
					'title'    => esc_html__( 'Hivepress', 'finder' ),
				)
			);

			$this->add_listings_page_settings( $wp_customize );
			$this->add_vendor_single_page_settings( $wp_customize );
			$this->add_vendors_page_settings( $wp_customize );
			$this->add_listings_myaccount_page_settings( $wp_customize );

		}

		/**
		 * Customize Listing Page
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function add_listings_page_settings( $wp_customize ) {

			$wp_customize->add_section(
				'finder_listings_section',
				array(
					'priority' => 10,
					'title'    => esc_html__( 'Listing Archive', 'finder' ),
					'panel'    => 'hivepress_panel',
				)
			);

			$wp_customize->add_setting(
				'finder_listing_columns',
				array(
					'default' => '3',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_listing_columns',
				array(
					'type'            => 'select',
					'section'         => 'finder_listings_section',
					'label'           => esc_html__( ' Columns', 'finder' ),
					'choices'         => array(
						'1' => esc_html__( '1', 'finder' ),
						'2' => esc_html__( '2', 'finder' ),
						'3' => esc_html__( '3', 'finder' ),
						'4' => esc_html__( '4', 'finder' ),
						'5' => esc_html__( '5', 'finder' ),
						'6' => esc_html__( '6', 'finder' ),

					),
					'active_callback' => function () {
						return 'list' !== get_theme_mod( 'finder_hivepress_listings_car_finder_catalog_layout' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_hivepress_listings_layout',
				array(
					'default'           => 'left-sidebar',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_hivepress_listings_layout',
				array(
					'label'       => esc_html__( 'Listings Layout', 'finder' ),
					'description' => esc_html__( 'Select listings layout', 'finder' ),
					'section'     => 'finder_listings_section',
					'priority'    => 10,
					'type'        => 'select',
					'choices'     => array(
						'left-sidebar'  => 'Left Sidebar',
						'right-sidebar' => 'Right Sidebar',
						'full-width'    => 'Full Width',
					),
					// 'active_callback' => function () {
					// return is_active_sidebar( 'sidebar-hivepress-listing' );
					// },
				)
			);

			$wp_customize->add_setting(
				'finder_hivepress_listings_style',
				array(
					'default'           => 'real-estate',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_hivepress_listings_style',
				array(
					'label'       => esc_html__( 'Listings Style', 'finder' ),
					'description' => esc_html__( 'Select listings version', 'finder' ),
					'section'     => 'finder_listings_section',
					'priority'    => 20,
					'type'        => 'select',
					'choices'     => array(
						'real-estate' => esc_html__( 'Real Estate', 'finder' ),
						'city-guide'  => esc_html__( 'City Guide', 'finder' ),
						'car-finder'  => esc_html__( 'Car Finder', 'finder' ),
					),
				)
			);

			$wp_customize->add_section(
				'finder_listing_single_section',
				array(
					'priority' => 10,
					'title'    => esc_html__( 'Listing Single', 'finder' ),
					'panel'    => 'hivepress_panel',
				)
			);

			$wp_customize->add_setting(
				'finder_hivepress_listing_single_style',
				array(
					'default'           => 'real-estate',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_hivepress_listing_single_style',
				array(
					'label'       => esc_html__( 'Listing Single Style', 'finder' ),
					'description' => esc_html__( 'Select listings version', 'finder' ),
					'section'     => 'finder_listing_single_section',
					'priority'    => 10,
					'type'        => 'select',
					'choices'     => array(
						'real-estate' => esc_html__( 'Real Estate', 'finder' ),
						'city-guide'  => esc_html__( 'City Guide', 'finder' ),
						'car-finder'  => esc_html__( 'Car Finder', 'finder' ),
					),
				)
			);

			$wp_customize->add_setting(
				'finder_related_single_listing_enable_disable',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_related_single_listing_enable_disable',
				array(
					'type'        => 'radio',
					'section'     => 'finder_listing_single_section',
					'label'       => esc_html__( 'Single post related listings', 'finder' ),
					'description' => esc_html__( 'This setting allows you to enable or disable related posts', 'finder' ),
					'choices'     => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_related_single_listing_enable_disable',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_related_single_listing_title_text',
				array(
					'default'           => esc_html__( 'Recently viewed', 'finder' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_related_single_listing_title_text',
				array(
					'label'           => esc_html__( 'Related Listing Text', 'finder' ),
					'description'     => esc_html__( 'Enter your custom title', 'finder' ),
					'section'         => 'finder_listing_single_section',
					'priority'        => 20,
					'type'            => 'text',
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_related_single_listing_enable_disable' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_related_single_listing_title_text',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_related_single_listing_link_text',
				array(
					'default'           => esc_html__( 'View all', 'finder' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_related_single_listing_link_text',
				array(
					'label'           => esc_html__( 'Related Listing Link Text', 'finder' ),
					'description'     => esc_html__( 'Enter your custom link text', 'finder' ),
					'section'         => 'finder_listing_single_section',
					'priority'        => 30,
					'type'            => 'text',
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_related_single_listing_enable_disable' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_related_single_listing_link_text',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_related_single_listing_link_text_url',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_related_single_listing_link_text_url',
				array(
					'label'           => esc_html__( 'Related Listing Url', 'finder' ),
					'description'     => esc_html__( 'Enter your custom url', 'finder' ),
					'section'         => 'finder_listing_single_section',
					'priority'        => 40,
					'type'            => 'url',
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_related_single_listing_enable_disable' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_related_single_listing_link_text_url',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_hivepress_listings_car_finder_catalog_layout',
				array(
					'default'           => 'grid',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_hivepress_listings_car_finder_catalog_layout',
				array(
					'label'           => esc_html__( 'Catalog Layout', 'finder' ),
					'description'     => esc_html__( 'Select catalog layout variation', 'finder' ),
					'section'         => 'finder_listings_section',
					'priority'        => 30,
					'type'            => 'select',
					'choices'         => array(
						'grid' => esc_html__( 'Grid', 'finder' ),
						'list' => esc_html__( 'List', 'finder' ),
					),
					'active_callback' => function () {
						return 'car-finder' === get_theme_mod( 'finder_hivepress_listings_style' );
					},
				)
			);

			$wp_customize->add_setting(
				'finder_listings_map_api_key',
				array(
					'default'           => 'JlBYgyPJAvtWyOYAERlf',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_listings_map_api_key',
				array(
					'label'           => esc_html__( 'Map Api', 'finder' ),
					'description'     => esc_html__( 'Enter your maptiler api', 'finder' ),
					'section'         => 'finder_listings_section',
					'priority'        => 30,
					'type'            => 'text',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_listings_map_api_key',
				array(
					'fallback_refresh' => true,
				)
			);
		}

		/**
		 * Customize Listing My-account Page
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function add_listings_myaccount_page_settings( $wp_customize ) {
			$wp_customize->add_section(
				'finder_hivepress_my_account_section',
				array(
					'priority' => 20,
					'title'    => esc_html__( 'My Account', 'finder' ),
					'panel'    => 'hivepress_panel',
				)
			);

			$wp_customize->add_setting(
				'finder_hivepress_my_account_style',
				array(
					'default'           => 'real-estate',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_hivepress_my_account_style',
				array(
					'label'       => esc_html__( 'My Account Styles', 'finder' ),
					'description' => esc_html__( 'Select my account post version', 'finder' ),
					'section'     => 'finder_hivepress_my_account_section',
					'priority'    => 50,
					'type'        => 'select',
					'choices'     => array(
						'real-estate' => 'Real Estate',
						'car-finder'  => 'Car Finder',
						'city-guide'  => 'City Guide',
					),
				)
			);
		}

		/**
		 * Customize Vendor single Page
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function add_vendor_single_page_settings( $wp_customize ) {

			$wp_customize->add_section(
				'finder_vendor_single_section',
				array(
					'priority' => 10,
					'title'    => esc_html__( 'Vendor Single', 'finder' ),
					'panel'    => 'hivepress_panel',
				)
			);

			$wp_customize->add_setting(
				'finder_hivepress_vendor_single_style',
				array(
					'default'           => 'real-estate',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_hivepress_vendor_single_style',
				array(
					'label'       => esc_html__( 'Vendor Single Style', 'finder' ),
					'description' => esc_html__( 'Select listings version', 'finder' ),
					'section'     => 'finder_vendor_single_section',
					'priority'    => 20,
					'type'        => 'select',
					'choices'     => array(
						'real-estate' => esc_html__( 'Real Estate', 'finder' ),
						'city-guide'  => esc_html__( 'City Guide', 'finder' ),
						'car-finder'  => esc_html__( 'Car Finder', 'finder' ),
					),

				)
			);

			$wp_customize->add_setting(
				'finder_related_single_vendor_enable_disable',
				array(
					'default'           => 'yes',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_related_single_vendor_enable_disable',
				array(
					'type'        => 'radio',
					'section'     => 'finder_vendor_single_section',
					'label'       => esc_html__( 'Single vendor related listings', 'finder' ),
					'description' => esc_html__( 'This setting allows you to enable or disable related posts', 'finder' ),
					'choices'     => array(
						'yes' => esc_html__( 'Yes', 'finder' ),
						'no'  => esc_html__( 'No', 'finder' ),
					),
					'active_callback' => function () {
						return 'car-finder' === get_theme_mod( 'finder_hivepress_vendor_single_style' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_related_single_vendor_enable_disable',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_related_single_vendor_title_text',
				array(
					'default'           => esc_html__( 'Recently viewed', 'finder' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_related_single_vendor_title_text',
				array(
					'label'           => esc_html__( 'Related Listing Text', 'finder' ),
					'description'     => esc_html__( 'Enter your custom title', 'finder' ),
					'section'         => 'finder_vendor_single_section',
					'priority'        => 20,
					'type'            => 'text',
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_related_single_vendor_enable_disable' ) && 'car-finder' === get_theme_mod( 'finder_hivepress_vendor_single_style' );
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_related_single_vendor_title_text',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_related_single_vendor_link_text',
				array(
					'default'           => esc_html__( 'View all', 'finder' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_related_single_vendor_link_text',
				array(
					'label'           => esc_html__( 'Related Listing Link Text', 'finder' ),
					'description'     => esc_html__( 'Enter your custom link text', 'finder' ),
					'section'         => 'finder_vendor_single_section',
					'priority'        => 30,
					'type'            => 'text',
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_related_single_vendor_enable_disable' );
							
					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_related_single_vendor_link_text',
				array(
					'fallback_refresh' => true,
				)
			);

			$wp_customize->add_setting(
				'finder_related_single_vendor_link_text_url',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				'finder_related_single_vendor_link_text_url',
				array(
					'label'           => esc_html__( 'Related Listing Url', 'finder' ),
					'description'     => esc_html__( 'Enter your custom url', 'finder' ),
					'section'         => 'finder_vendor_single_section',
					'priority'        => 40,
					'type'            => 'url',
					'active_callback' => function () {
						return 'yes' === get_theme_mod( 'finder_related_single_vendor_enable_disable' );

					},
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'finder_related_single_vendor_link_text_url',
				array(
					'fallback_refresh' => true,
				)
			);


		}

		/**
		 * Customize Vendors Page
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function add_vendors_page_settings( $wp_customize ) {

			$wp_customize->add_section(
				'finder_vendors_section',
				array(
					'priority' => 10,
					'title'    => esc_html__( 'Vendor Archive', 'finder' ),
					'panel'    => 'hivepress_panel',
				)
			);

			$wp_customize->add_setting(
				'finder_vendors_columns',
				array(
					'default' => '4',
					'sanitize_callback' => 'sanitize_key',
				)
			);

			$wp_customize->add_control(
				'finder_vendors_columns',
				array(
					'type'    => 'select',
					'section' => 'finder_vendors_section',
					'label'   => esc_html__( ' Columns', 'finder' ),
					'choices' => array(
						'1' => esc_html__( '1', 'finder' ),
						'2' => esc_html__( '2', 'finder' ),
						'3' => esc_html__( '3', 'finder' ),
						'4' => esc_html__( '4', 'finder' ),
						'5' => esc_html__( '5', 'finder' ),
						'6' => esc_html__( '6', 'finder' ),

					),
				)
			);

		}

		/**
		 * Scripts to improve our form.
		 */
		public function add_scripts() {
			$listings_page_url = get_permalink( finder_hivepress_get_listings_page_id() );

			?>
			<script type="text/javascript">
				jQuery( function( $ ) {
					wp.customize.section( 'finder_listings_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $listings_page_url ); ?>' );
							}
						} );
					} );
				} );
			</script>
			<?php
		}
	}

endif;

return new Finder_Hivepress_Customizer();
