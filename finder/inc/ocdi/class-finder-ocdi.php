<?php
/**
 * Finder OCDI Class
 *
 * @package finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Finder_OCDI' ) ) :
	/**
	 * The one click demo import class.
	 */
	class Finder_OCDI {

		/**
		 * Stores the assets URL.
		 *
		 * @var string
		 */
		public $assets_url;

		/**
		 * Stores the demo URL.
		 *
		 * @var string
		 */
		public $demo_url;

		/**
		 * Instantiate the class.
		 */
		public function __construct() {

			$this->assets_url = 'https://transvelo.github.io/finder/assets/';
			$this->demo_url   = 'https://finder.madrasthemes.com/';

			add_filter( 'pt-ocdi/confirmation_dialog_options', [ $this, 'confirmation_dialog_options' ], 10, 1 );

			add_action( 'pt-ocdi/import_files', [ $this, 'import_files' ] );

			add_action( 'pt-ocdi/after_import', [ $this, 'import_wpforms' ] );
			add_action( 'pt-ocdi/enable_wp_customize_save_hooks', '__return_true' );
			add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
			add_action( 'pt-ocdi/after_import', [ $this, 'replace_uploads_dir' ] );

			add_filter( 'ocdi/register_plugins', [ $this, 'register_plugins' ] );

			add_filter( 'upload_mimes', [ $this, 'cc_mime_types' ] );
		}

		/**
		 * OCDI JSON Import
		 *
		 * @param array $mimes mimes.
		 * @return array
		 */
		public function cc_mime_types( $mimes ) {
			$mimes['json'] = 'application/json';
			$mimes['svg']  = 'image/svg+xml';
			return $mimes;
		}


		/**
		 * Confirmation dialog box options.
		 *
		 * @param array $options The dialog options.
		 * @return array
		 */
		public function confirmation_dialog_options( $options ) {
			return array_merge(
				$options,
				array(
					'width' => 410,
				)
			);
		}

		/**
		 * Register plugins in OCDI.
		 *
		 * @param array $plugins List of plugins.
		 */
		public function register_plugins( $plugins ) {
			global $finder;

			$profile = 'default';

			if ( isset( $_GET['import'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$demo_id = absint( $_GET['import'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				switch ( $demo_id ) {
					case 0:
						$profile = 'hivepress';
						break;
					case 1:
						$profile = 'hivepress';
						break;
					case 2:
						$profile = 'hivepress';
						break;
					case 3:
						$profile = 'job';
						break;
				}
			}

			return $finder->plugin_install->get_demo_plugins( $profile );
		}

		/**
		 * Trigger after import
		 */
		public function trigger_ocdi_after_import() {
			$import_files    = $this->import_files();
			$selected_import = end( $import_files );
			do_action( 'pt-ocdi/after_import', $selected_import ); //phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
		}

		/**
		 * Replace uploads Dir.
		 *
		 * @param array $selected_import The import that just ran.
		 */
		public function replace_uploads_dir( $selected_import ) {
			if ( isset( $selected_import['uploads_dir'] ) ) {
				$from = $selected_import['uploads_dir'] . '/';
			} else {
				$from = 'https://finder.madrasthemes.com/finder/';
			}

			$site_upload_dir = wp_get_upload_dir();
			$to              = $site_upload_dir['baseurl'] . '/';
			\Elementor\Utils::replace_urls( $from, $to );
		}

		/**
		 * Clear default widgets.
		 */
		public function clear_default_widgets() {
			$sidebars_widgets = get_option( 'sidebars_widgets' );
			$all_widgets      = array();

			array_walk_recursive(
				$sidebars_widgets,
				function ( $item, $key ) use ( &$all_widgets ) {
					if ( ! isset( $all_widgets[ $key ] ) ) {
						$all_widgets[ $key ] = $item;
					} else {
						$all_widgets[] = $item;
					}
				}
			);

			if ( isset( $all_widgets['array_version'] ) ) {
				$array_version = $all_widgets['array_version'];
				unset( $all_widgets['array_version'] );
			}

			$new_sidebars_widgets = array_fill_keys( array_keys( $sidebars_widgets ), array() );

			$new_sidebars_widgets['wp_inactive_widgets'] = $all_widgets;
			if ( isset( $array_version ) ) {
				$new_sidebars_widgets['array_version'] = $array_version;
			}

			update_option( 'sidebars_widgets', $new_sidebars_widgets );
		}

		/**
		 * Set site options.
		 *
		 * @param array $selected_import The import that just ran.
		 */
		public function set_site_options( $selected_import ) {
			if ( isset( $selected_import['set_pages'] ) && $selected_import['set_pages'] ) {
				$front_page_title = isset( $selected_import['front_page_title'] ) ? $selected_import['front_page_title'] : 'Basic';
				$front_page_id    = get_page_by_title( $front_page_title );

				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $front_page_id->ID );
			}

			update_option( 'posts_per_page', 9 );
		}

		/**
		 * Set the nav menus.
		 *
		 * @param array $selected_import The import that just ran.
		 */
		public function set_nav_menus( $selected_import ) {
			if ( isset( $selected_import['set_nav_menus'] ) && $selected_import['set_nav_menus'] ) {
				$main_menu   = get_term_by( 'name', 'Main Menu', 'nav_menu' );
				$social_menu = get_term_by( 'name', 'Social Icons', 'nav_menu' );
				$locations   = [
					'navbar_nav'   => $main_menu->term_id,
					'social_media' => $social_menu->term_id,
				];

				set_theme_mod( 'nav_menu_locations', $locations );
			}
		}

		/**
		 * Import WPForms.
		 */
		public function import_wpforms( $selected_import ) {

			$ocdi_host   = 'https://transvelo.github.io/finder';
			$dd_url      = $ocdi_host . '/assets/wpforms/';

			switch ( $selected_import['import_key_name'] ) {
				case 'real-estate':
					$file = 'real-estate.json';
					break;
				case 'car-finder':
					$file = 'car-finder.json';
					break;
				case 'job-board':
					$file = 'job-board.json';
					break;
				case 'city-guide':
					$file = 'city-guide.json';
					break;
			}

			if ( ! function_exists( 'wpforms' ) || ! isset( $file ) ) {
				return;
			}

			$wpform_file_url = $dd_url . $file;
			$response        = wp_remote_get( $wpform_file_url );

			if ( is_wp_error( $response ) || 200 !== $response['response']['code'] ) {
				return;
			}

			$form_json = wp_remote_retrieve_body( $response );

			if ( is_wp_error( $form_json ) ) {
				return;
			}

			$forms = json_decode( $form_json, true );

			foreach ( $forms as $form_data ) {
				$form_title = $form_data['settings']['form_title'];

				if ( ! empty( $form_data['id'] ) ) {
					$form_content = array(
						'field_id' => '0',
						'settings' => array(
							'form_title' => sanitize_text_field( $form_title ),
							'form_desc'  => '',
						),
					);

					// Merge args and create the form.
					$form = array(
						'import_id'    => (int) $form_data['id'],
						'post_title'   => esc_html( $form_title ),
						'post_status'  => 'publish',
						'post_type'    => 'wpforms',
						'post_content' => wpforms_encode( $form_content ),
					);

					$form_id = wp_insert_post( $form );
				} else {
					// Create initial form to get the form ID.
					$form_id = wpforms()->form->add( $form_title );
				}

				if ( empty( $form_id ) ) {
					continue;
				}

				$form_data['id'] = $form_id;
				// Save the form data to the new form.
				wpforms()->form->update( $form_id, $form_data );
			}

		}

		/**
		 * Import Files from each demo.
		 */
		public function import_files() {
			$ocdi_host   = 'https://transvelo.github.io/finder';
			$dd_url      = $ocdi_host . '/assets';
			$widget_url  = $ocdi_host  . '/assets/widgets';
			$image_url = $ocdi_host . '/assets/images';
			/* translators: %1$s - The demo name. %2$s - Minutes. */
			$notice  = esc_html__( 'This demo will import %1$s. It may take %2$s', 'finder' );
			$notice .= '<br><br>' . esc_html__( 'Menus, Widgets and Settings will not be imported. Content imported already will not be imported.', 'finder' );
			$notice .= '<br><br>' . esc_html__( 'Alternatively, you can import this template directly into your page via Edit with Elementor.', 'finder' );

			return apply_filters(
				'finder_ocdi_files_args',
				array(
					array(
						'import_file_name'         => esc_html__( 'Real Estate', 'finder' ),
						'import_key_name'          => 'real-estate',
						'categories'               => array( 'Real Estate' ),
						'import_file_url'          => $dd_url . '/xml/real-estate/real-estate.xml',
						'import_preview_image_url' => $image_url . '/real-estate.jpeg',
						'preview_url'              => 'https://finder.madrasthemes.com/real-estate',
						'import_widget_file_url'   => $widget_url . '/real-estate.wie',
						// 'local_import_customizer_file' => $dd_url . '/customizer/real-estate.dat',
						'plugin_profile'           => 'hivepress',
						'uploads_dir'              => 'https://finder.madrasthemes.com/real-estate/wp-content/uploads/sites/2',
					),

					array(
						'import_file_name'         => esc_html__( 'Car Finder', 'finder' ),
						'import_key_name'          => 'car-finder',
						'categories'               => array( 'Car Finder' ),
						'import_file_url'          => $dd_url . '/xml/car-finder/car-finder.xml',
						'import_preview_image_url' => $image_url . '/car-finder.jpeg',
						'preview_url'              => 'https://finder.madrasthemes.com/car-finder',
						'import_widget_file_url'   => $widget_url . '/car-finder.wie',
						'plugin_profile'           => 'hivepress',
						'uploads_dir'              => 'https://finder.madrasthemes.com/car-finder/wp-content/uploads/sites/3',
						// 'local_import_customizer_file' => $dd_url . '/customizer/car-finder.dat',

					),
					array(
						'import_file_name'         => esc_html__( 'Job Board', 'finder' ),
						'import_key_name'          => 'job-board',
						'categories'               => array( 'Job Board' ),
						'import_file_url'          => $dd_url . '/xml/job-board/job-board.xml',
						'import_preview_image_url' => $image_url . '/job-board.jpeg',
						'preview_url'              => 'https://finder.madrasthemes.com/job-board',
						'import_widget_file_url'   => $widget_url . '/job-board.wie',
						// 'local_import_customizer_file' => $dd_url . '/customizer/job-board.dat',
						'uploads_dir'              => 'https://finder.madrasthemes.com/job-board/wp-content/uploads/sites/4',
						'plugin_profile'           => 'job',
					),
					array(
						'import_file_name'         => esc_html__( 'City Guide', 'finder' ),
						'import_key_name'          => 'city-guide',
						'categories'               => array( 'City Guide' ),
						'import_file_url'          => $dd_url . '/xml/city-guide/city-guide.xml',
						'import_preview_image_url' => $image_url . '/city-guide.jpeg',
						'preview_url'              => 'https://finder.madrasthemes.com/city-guide',
						'import_widget_file_url'   => $widget_url . '/city-guide.wie',
						'plugin_profile'           => 'hivepress',
						'uploads_dir'              => 'https://finder.madrasthemes.com/city-guide/wp-content/uploads/sites/5',
						// 'local_import_customizer_file' => $dd_url . '/customizer/city-guide.dat',
					),
				)
			);
		}

	}

endif;

return new Finder_OCDI();
