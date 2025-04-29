<?php
/**
 * Finder functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Assign the Finder version to a var
 */
$theme          = wp_get_theme( 'inatech' );
$finder_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 856; /* pixels */
}


/**
 * Define Constants
 */
define( 'FINDER_THEME_VERSION', $finder_version );
define( 'FINDER_THEME_SETTINGS', 'finder-settings' );
define( 'FINDER_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'FINDER_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );

$finder = (object) array(
	'version'    => $finder_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require_once FINDER_THEME_DIR . 'inc/class-finder.php',
	'customizer' => require_once FINDER_THEME_DIR . 'inc/customizer/class-finder-customizer.php',

);

/**
 * Setup helper functions of Astra.
 */
require_once FINDER_THEME_DIR . 'inc/core/class-finder-theme-options.php';
require_once FINDER_THEME_DIR . 'inc/core/class-theme-strings.php';

require_once FINDER_THEME_DIR . 'inc/classes/class-wp-bootstrap-navwalker.php';


/**
 * Custom template tags for this theme.
 */
require_once FINDER_THEME_DIR . 'inc/core/theme-hooks.php';
require_once FINDER_THEME_DIR . 'inc/finder-functions.php';
require_once FINDER_THEME_DIR . 'inc/finder-template-hooks.php';
require_once FINDER_THEME_DIR . 'inc/finder-template-functions.php';

/**
 * Social Share
 */
require FINDER_THEME_DIR . 'inc/classes/class-finder-socialshare.php';

if ( finder_is_hivepress_activated() ) {
	$finder->hivepress            = require FINDER_THEME_DIR . 'inc/hivepress/class-finder-hivepress.php';
	$finder->hivepress_customizer = require FINDER_THEME_DIR . 'inc/hivepress/class-finder-hivepress-customizer.php';
	require FINDER_THEME_DIR . '/inc/hivepress/finder-hivepress-functions.php';
	require FINDER_THEME_DIR . '/inc/hivepress/finder-hivepress-template-functions.php';
	require FINDER_THEME_DIR . '/inc/hivepress/finder-hivepress-template-hooks.php';
	if ( class_exists('HivePress\Blocks\Opening_Hours')) {
		require FINDER_THEME_DIR . '/hivepress/extensions/opening-hours/class-finder-opening-hours.php';
	}
	if ( class_exists('HivePress\Blocks\Social_Links')) {
		require FINDER_THEME_DIR . '/hivepress/extensions/social-links/class-finder-social-links.php';
	}
}

/**
 * ACF
 */
if ( finder_is_acf_activated() ) {
	$finder->acf = require FINDER_THEME_DIR . 'inc/acf/class-finder-acf.php';
}

require FINDER_THEME_DIR . 'inc/acf/finder-acf-functions.php';
require FINDER_THEME_DIR . 'inc/acf/finder-acf-hooks.php';

if ( finder_is_wp_job_manager_activated() ) {
	$finder->wpjm            = require FINDER_THEME_DIR . 'inc/wpjm/class-finder-wpjm.php';
	$finder->wpjm_customizer = require FINDER_THEME_DIR . 'inc/wpjm/class-finder-wpjm-customizer.php';

	require FINDER_THEME_DIR . 'inc/wpjm/finder-wpjm-functions.php';
	require FINDER_THEME_DIR . 'inc/wpjm/finder-wpjm-template-hooks.php';
	require FINDER_THEME_DIR . 'inc/wpjm/finder-wpjm-template-functions.php';
}

if ( function_exists( 'wpforms' ) ) {
	require get_template_directory() . '/inc/wpforms/integration.php';
}
/**
 * TGM Plugin Activation class.
 */
require FINDER_THEME_DIR . 'inc/classes/class-tgm-plugin-activation.php';

if ( is_admin() ) {
	$finder->admin = require get_template_directory() . '/inc/admin/class-finder-admin.php';
	$finder->plugin_install = require get_template_directory() . '/inc/admin/class-finder-plugin-install.php';
}
if ( finder_is_ocdi_activated() ) {
	$finder->ocdi = require get_template_directory() . '/inc/ocdi/class-finder-ocdi.php';
}

/**
 * Functions used for Finder Custom Theme Color
 */
require get_template_directory() . '/inc/finder-custom-color-functions.php';

function custom_enqueue_styles() {
    wp_enqueue_style('custom-styles', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'custom_enqueue_styles');

/** Code Style */
function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');


/**
 * Membuat REST API endpoint untuk mengambil data listing
 */
function indopacking_register_listing_api() {
    register_rest_route('indopacking/v1', '/listing/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'indopacking_get_listing_data',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'indopacking_register_listing_api');

/**
 * Callback function untuk mengambil data listing
 *
 * @param WP_REST_Request $request Request object.
 * @return WP_REST_Response|WP_Error Response data atau error.
 */
function indopacking_get_listing_data($request) {
    $listing_id = $request->get_param('id');
    
    // Pastikan listing ID valid
    if (!$listing_id || !is_numeric($listing_id)) {
        return new WP_Error('invalid_listing', 'ID listing tidak valid', array('status' => 400));
    }
    
    // Ambil data listing dari HivePress
    $listing = \HivePress\Models\Listing::query()->get_by_id($listing_id);
    
    if (!$listing) {
        return new WP_Error('listing_not_found', 'Listing tidak ditemukan', array('status' => 404));
    }
    
    // Siapkan data listing untuk response
    $response_data = array(
        'id' => $listing->get_id(),
        'title' => $listing->get_title(),
        'url' => get_permalink($listing_id),
        'categories' => array(),
        'attributes' => array(),
    );
    
    // Cari atribut harga
    $fields = $listing->_get_fields('view_page_primary');
    $price = null;
    
    if ($fields) {
        foreach ($fields as $field) {
            if (!is_null($field->get_value())) {
                $attribute_id = finder_hivepress_get_listing_attribute_id_by_slug($field->get_slug());
                $attribute_view_style = finder_get_field('real_estate_view_style', $attribute_id);
                
                // Simpan nilai harga jika ditemukan
                if ('price' === $attribute_view_style) {
                    $price = $field->get_value();
                    $response_data['price'] = $price;
                    $response_data['price_display'] = $field->display();
                }
                
                // Tambahkan semua atribut ke response
                $response_data['attributes'][$field->get_slug()] = array(
                    'value' => $field->get_value(),
                    'display' => $field->display(),
                    'type' => $attribute_view_style
                );
            }
        }
    }
    
    // Jika harga tidak ditemukan dalam atribut, coba ambil dari meta
    if (is_null($price)) {
        $price = $listing->get_meta('price');
        if ($price) {
            $response_data['price'] = $price;
        }
    }
    
    // Tambahkan kategori jika ada
    if ($listing->get_categories__id()) {
        foreach ($listing->get_categories__id() as $cat_id) {
            $term = get_term($cat_id);
            if ($term && !is_wp_error($term)) {
                $response_data['categories'][] = array(
                    'id' => $term->term_id,
                    'name' => $term->name,
                    'slug' => $term->slug,
                );
            }
        }
    }
    
    return new WP_REST_Response($response_data, 200);
}