<?php
/**
 * Finder functions.
 *
 * @package Finder
 */

// Load all functions files separately.
require_once FINDER_THEME_DIR . '/inc/functions/conditional.php';
require_once FINDER_THEME_DIR . 'inc/functions/template.php';
require_once FINDER_THEME_DIR . 'inc/functions/utilities.php';
require_once FINDER_THEME_DIR . 'inc/functions/markup.php';
require_once FINDER_THEME_DIR . 'inc/functions/global.php';

/**
 * Returns true when viewing the default homepage.
 *
 * @return bool
 */
function finder_is_default_homepage() {
	return is_front_page() && is_home();
}

/**
 * Returns true when viewing the blog homepage.
 *
 * @return bool
 */
function finder_is_blog_homepage() {
	return ! is_front_page() && is_home();
}

/**
 * Returns true when viewing the static homepage.
 *
 * @return bool
 */
function finder_is_static_homepage() {
	return is_front_page() && ! is_home();
}

/**
 * Get the default single blog post style.
 *
 * @return string
 */
function finder_get_default_blog_single_style() {
	return apply_filters( 'finder_default_blog_single_style', 'default' );
}

/**
 * Get the single blog post style.
 *
 * @return string
 */
function finder_get_blog_single_style() {
	global $post;

	$default_blog_single_style = finder_get_default_blog_single_style();
	$blog_single_style         = get_theme_mod( 'finder_blog_single_style', $default_blog_single_style );

	$blog_single_style_acf = finder_acf_single_post_styles();

	if ( isset( $post->ID ) && is_singular( 'post' ) && $blog_single_style_acf && 'default' !== $blog_single_style_acf ) {
		$blog_single_style = $blog_single_style_acf;
	}

	return (string) apply_filters( 'finder_single_post_version', $blog_single_style );
}

/**
 * Get the default blog style.
 *
 * @return string
 */
function finder_get_default_blog_style() {
	return apply_filters( 'finder_default_blog_style', 'default' );
}

/**
 * Get the blog style.
 *
 * @return string
 */
function finder_get_blog_style() {
	$default    = finder_get_default_blog_style();
	$blog_style = get_theme_mod( 'finder_blog_post_style', $default );

	if ( is_tag() ) {
		$term           = get_queried_object();
		$blog_style_acf = finder_acf_blog_post_style( $term );

		if ( $blog_style_acf && 'default' !== $blog_style_acf ) {
			$blog_style = $blog_style_acf;
		}
	}

	return (string) apply_filters( 'finder_default_blog_post_style', $blog_style );
}

if ( ! function_exists( 'finder_option_enabled_post_types' ) ) {
	/**
	 * Option enabled post types.
	 *
	 * @return array
	 */
	function finder_option_enabled_post_types() {
		$post_types = array( 'post', 'page', 'job_listing', 'hp_listing', 'hp_vendor' );
		return apply_filters( 'finder_option_enabled_post_types', $post_types );
	}
}

/**
 * Get the blog column style.
 *
 * @return string
 */
function finder_get_blog_column_style() {
	$col_style = get_theme_mod( 'finder_blog_archive_columns', '4' );

	if ( is_tag() ) {
		$term          = get_queried_object();
		$col_style_acf = finder_acf_get_blog_post_column( $term );

		if ( $col_style_acf && 'default' !== $col_style_acf ) {
			$col_style = $col_style_acf;
		}
	}

	return (string) apply_filters( 'finder_blog_column_style', $col_style );
}

/**
 * Get the blog sidebar.
 *
 * @return string
 */
function finder_get_blog_layout() {

	$layout = get_theme_mod( 'blog_sidebar', 'sidebar-right' );

	if ( ( 'sidebar-left' === $layout || 'sidebar-right' === $layout ) ) {
		if ( ! is_active_sidebar( 'sidebar-blog' ) ) {
			$layout = 'full-width';
		}
	}

	return sanitize_key( apply_filters( 'finder_blog_sidebar_layout', $layout ) );
}

/**
 * Return if the blog has sidebar or not.
 */
function finder_has_blog_sidebar() {
	$layout = finder_get_blog_layout();
	return ( 'sidebar-left' === $layout || 'sidebar-right' === $layout );
}

/**
 * Get the blog single sidebar.
 *
 * @return string
 */
function finder_get_blog_single_layout() {

	$sidebar = get_theme_mod( 'blog_single_sidebar', 'full-width' );

	if ( ! is_active_sidebar( 'blog-single-sidebar' ) ) {
		$sidebar = 'full-width';
	}

	return sanitize_key( apply_filters( 'finder_blog_single_sidebar_layout', $sidebar ) );
}

/**
 * Get the single post share enable or disable.
 *
 * @return boolean
 */
function finder_single_post_is_share_enabled() {
	$social_share_enable_disable     = get_theme_mod( 'finder_single_post_social_share', false );
	$social_share_acf_enable_disable = finder_acf_single_post_social_share();

	if ( finder_is_acf_activated() && $social_share_acf_enable_disable ) {
		$social_share_enable_disable = $social_share_acf_enable_disable;
	}

	return (bool) apply_filters( 'finder_single_post_enable_share', $social_share_enable_disable );
}

/**
 * Get the single post related post enable or disable.
 *
 * @return boolean
 */
function finder_single_post_is_related_post_enabled() {
	$related_post_enable_disable = get_theme_mod( 'finder_single_post_related_post', false );

	return (bool) apply_filters( 'finder_single_post_enable_related_post', $related_post_enable_disable );
}

/**
 * Returns the default footer version for the website.
 *
 * @return string
 */
function finder_get_default_footer_version() {
	return apply_filters( 'finder_default_footer_style', 'v6' );
}

/**
 * Returns the version of the footer for the website.
 *
 * @return string
 */
function finder_get_footer_version() {
	$default            = finder_get_default_footer_version();
	$is_custom_footer   = finder_footer_acf_is_custom_footer();
	$footer_acf_version = finder_footer_acf_footer_version();
	$version = get_theme_mod( 'finder_footer_version', $default );

	$fn_page_options = array();

		if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
			$clean_meta_data  = get_post_meta( get_the_ID(), '_fn_page_options', true );
			$_fn_page_options = maybe_unserialize( $clean_meta_data );

			if ( is_array( $_fn_page_options ) ) {
				$fn_page_options = $_fn_page_options;
			}
		}

	if ( finder_has_custom_footer( $fn_page_options ) ) {
		$version  = isset( $fn_page_options['footer']['finder_footer_version'] ) ? $fn_page_options['footer']['finder_footer_version'] : $default;


	 } elseif ( $is_custom_footer ) {
		if ( $footer_acf_version && 'default' !== $footer_acf_version ) {
	 		$version = $footer_acf_version;
	 	}
	}else {
		$version = get_theme_mod( 'finder_footer_version', $default );
	}

	return (string) apply_filters( 'finder_footer_version', $version );
	
}

/**
 * Footer Logo
 *
 * @return bool
 */
function finder_has_footer_logo() {
	$footer_logo = get_theme_mod( 'footer_logo', '' );

	if ( ! empty( $footer_logo ) ) {
		return true;
	}

	return false;
}

/**
 * Footer Logo
 *
 * @return string
 */
function finder_get_footer_logo() {
	$footer_logo = get_theme_mod( 'footer_logo', '' );

	return $footer_logo;
}

if ( ! function_exists( 'finder_kses_allowed_html' ) ) {
	/**
	 * Custom allowed HTML for kses function.
	 *
	 * @param array  $tags Array of tags that are allowed.
	 * @param string $context Context of the kses.
	 */
	function finder_kses_allowed_html( $tags, $context ) {

		switch ( $context ) {
			case 'login_form':
				$tags = array(
					'div'  => array(
						'class'                 => array(),
						'data-component'		=> array(),
					),
					'label'  => array( 'class' => array() ),
					'button'  => array( 
						'type' => array(),
						'class' => array(),
					),
					'form'    => array(
						'data-model'            => array(),
						'action'                => array(),
						'data-action'        	=> array(),
						'method'       			=> array(),
						'data-redirect'			=> array(),
						'data-component'        => array(),
						'class'                 => array(),
					),
					'input'    => array(
						'type'      	=> array(),
						'name'      	=> array(),
						'value'     	=> array(),
						'class'       	=> array(),
						'placeholder'	=> array(),
						'maxlength'     => array(),
						'minlength'     => array(),
						'required'      => array(),
						'autocomplete'	=> array(),
					),
				);
			break;
		}
		return $tags;
	}
}

/**
 * Default Global Colors
 */
function finder_default_colors() {
	$finder_colors = array(
		array(
			'_id'   => 'primary',
			'title' => esc_html__( 'Primary', 'finder' ),
			'color' => '#fd5631',
		),
		array(
			'_id'   => 'secondary',
			'title' => esc_html__( 'Secondary', 'finder' ),
			'color' => '#e4dfeb',
		),
		array(
			'_id'   => 'success',
			'title' => esc_html__( 'Success', 'finder' ),
			'color' => '#07c98b',
		),
		array(
			'_id'   => 'info',
			'title' => esc_html__( 'Info', 'finder' ),
			'color' => '#3c76f2',
		),
		array(
			'_id'   => 'warning',
			'title' => esc_html__( 'Warning', 'finder' ),
			'color' => '#fdbc31',
		),
		array(
			'_id'   => 'danger',
			'title' => esc_html__( 'Danger', 'finder' ),
			'color' => '#f23c49',
		),
		array(
			'_id'   => 'light',
			'title' => esc_html__( 'Light', 'finder' ),
			'color' => '#ffffff',
		),
		array(
			'_id'   => 'dark',
			'title' => esc_html__( 'Dark', 'finder' ),
			'color' => '#1f1b2d',
		),
		array(
			'_id'   => 'accent',
			'title' => esc_html__( 'Text', 'finder' ),
			'color' => '#5d3cf2',
		),
	);

	return apply_filters( 'finder_default_colors', $finder_colors );
}

/**
 * Display pagination in Bootstrap format.
 *
 * @param WP_Query|null $wp_query WordPress query.
 * @param bool          $echo     should echo or return.
 * @param string        $nav_class class for the <nav> wrapper.
 * @param string        $ul_class class for the <ul> wrapper.
 * @param string        $a_class  class for the anchor.
 *
 * @return string
 * Accepts a WP_Query instance to build pagination (for custom wp_query()),
 * or nothing to use the current global $wp_query (eg: taxonomy term page)
 * - Tested on WP 4.9.5
 * - Tested with Bootstrap 4.1
 * - Tested on Sage 9
 *
 * USAGE:
 *     <?php echo finder_bootstrap_pagination(); ?> //uses global $wp_query
 * or with custom WP_Query():
 *     <?php
 *      $query = new \WP_Query($args);
 *       ... while(have_posts()), $query->posts stuff ...
 *       echo finder_bootstrap_pagination($query);
 *     ?>
 */
function finder_bootstrap_pagination( \WP_Query $wp_query = null, $echo = true, $nav_class = '', $ul_class = '', $a_class = '' ) {

	if ( null === $wp_query ) {
		global $wp_query;
	}

	$pages = paginate_links(
		array(
			'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'format'       => '?paged=%#%',
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'total'        => $wp_query->max_num_pages,
			'type'         => 'array',
			'show_all'     => false,
			'end_size'     => 3,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => esc_html__( '&laquo; Prev', 'finder' ),
			'next_text'    => esc_html__( 'Next &raquo;', 'finder' ),
			'add_args'     => false,
			'add_fragment' => '',
		)
	);

	if ( is_array( $pages ) ) {

		if ( ! empty( $ul_class ) ) {
			$ul_class = ' ' . $ul_class;
		}
		if ( ! empty( $nav_class ) ) {
			$nav_class = ' ' . $nav_class;
		}

		$pagination = '<nav class="page' . esc_attr( $nav_class ) . '" aria-label="' . esc_attr__( 'Blog Pagination', 'finder' ) . '"><ul class="pagination' . esc_attr( $ul_class ) . '">';

		$pagination = '<nav class="finder-pagination' . esc_attr( $nav_class ) . '" aria-label="' . esc_attr__( 'Pagination', 'finder' ) . '"><ul class="pagination' . esc_attr( $ul_class ) . '">';

		foreach ( $pages as $page ) {
			$t          = ( strpos( $page, 'current' ) === false ) ? $a_class : '';
			$t         .= ' page-link';
			$icon_right = '<i class="fi-chevron-right"></i>';
			$icon_left  = '<i class="fi-chevron-left"></i>';
			$prev_icon  = str_replace( '&laquo; Prev', $icon_left, $page );
			$next_icon  = str_replace( 'Next &raquo;', $icon_right, $prev_icon );

			$pagination .= '<li class="page-item d-sm-block' . ( strpos( $page, 'current' ) !== false ? ' active' : '' ) . '">' . str_replace( 'page-numbers', $t, $next_icon ) . '</li>';

		}
		$pagination .= '</ul></nav>';

		if ( $echo ) {
			echo wp_kses_post( $pagination );
		} else {
			return $pagination;
		}
	}

	return null;
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 *
 * @param string|array $var Data to sanitize.
 * @return string|array
 */
function finder_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'finder_clean', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}

if ( ! function_exists( 'finder_custom_excerpt_length' ) ) {
	/**
	 * Excerpt length.
	 *
	 * @param  int $length default excerpt length.
	 * @return int
	 */
	function finder_custom_excerpt_length( $length ) {
		$show_masonry = finder_posts_masonry_enabled();

		if ( is_sticky() && ! $show_masonry ) {
			$length = 18;
		} else {
			$length = 12;
		}
		return $length;
	}
}

if ( ! function_exists( 'finder_excerpt_more' ) ) {
	/**
	 * Excerpt more.
	 *
	 * @param  string $more default excerpt text.
	 * @return string
	 */
	function finder_excerpt_more( $more ) {
		return '...';
	}
}

/**
 * Get All Meta Values of Post Type.
 *
 * @param string $key meta key.
 * @param string $post_type post type.
 * @param string $post_status post status.
 * @return array
 */
function finder_get_post_meta_values( $key = '', $post_type = 'post', $post_status = 'publish' ) {
	global $wpdb;

	if ( empty( $key ) ) {
		return;
	}

	$meta_objects = $wpdb->get_results(
		$wpdb->prepare(
			"
		SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
		LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
		WHERE pm.meta_key = %s
		AND pm.meta_value is not null
		AND pm.meta_value != ''
		AND p.post_status = %s
		AND p.post_type = %s
		",
			$key,
			$post_status,
			$post_type
		)
	);

	$metas = array();

	if ( $meta_objects ) {
		foreach ( $meta_objects as $meta ) {
			$metas[] = $meta->meta_value;
		}
	}

	return $metas;
}

/**
 * Should display comments link.
 *
 * @return bool
 */
function finder_should_display_comments_link() {
	$should_display = false;

	if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
		$should_display = true;
	}
	return $should_display;
}

/**
 * Adjust a hex color brightness
 * Allows us to create hover styles for custom link colors
 *
 * @since 2.5.8 Added $opacity argument.
 *
 * @param  strong  $hex     Hex color e.g. #111111.
 * @param  integer $steps   Factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
 * @param  float   $opacity Opacity factor between 0 and 1.
 * @return string           Brightened/darkened color (hex by default, rgba if opacity is set to a valid value below 1).
 * @since  1.0.0
 */
function finder_adjust_color_brightness( $hex, $steps, $opacity = 1 ) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter.
	$steps = max( -255, min( 255, $steps ) );

	$rgb_values = get_rgb_values_from_hex( $hex );

	// Adjust number of steps and keep it inside 0 to 255.
	$r = max( 0, min( 255, $rgb_values['r'] + $steps ) );
	$g = max( 0, min( 255, $rgb_values['g'] + $steps ) );
	$b = max( 0, min( 255, $rgb_values['b'] + $steps ) );

	if ( $opacity >= 0 && $opacity < 1 ) {
		return 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $opacity . ')';
	}

	$r_hex = str_pad(dechex(intval($r)), 2, '0', STR_PAD_LEFT);
	$g_hex = str_pad(dechex(intval($g)), 2, '0', STR_PAD_LEFT);
	$b_hex = str_pad(dechex(intval($b)), 2, '0', STR_PAD_LEFT);

	return '#' . $r_hex . $g_hex . $b_hex;
}

/**
 * Given an hex colors, returns an array with the colors components.
 *
 * @param  strong $hex Hex color e.g. #111111.
 * @return bool        Array with color components (r, g, b).
 * @since  2.5.8
 */
function get_rgb_values_from_hex( $hex ) {
	// Format the hex color string.
	$hex = str_replace( '#', '', $hex );

	if ( 3 === strlen( $hex ) ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Get decimal values.
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );

	return array(
		'r' => $r,
		'g' => $g,
		'b' => $b,
	);
}
