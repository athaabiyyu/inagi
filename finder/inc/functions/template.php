<?php
/**
 * Functions for the templating systems.
 *
 * @package finder
 */

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @param string $template_name Template name.
 * @param array  $args          Arguments. (default: array).
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 */
function finder_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	global $finder_version;
	$cache_key = sanitize_key( implode( '-', array( 'template', $template_name, $template_path, $default_path, $finder_version ) ) );
	$template  = (string) wp_cache_get( $cache_key, 'finder' );

	if ( ! $template ) {
		$template = finder_locate_template( $template_name, $template_path, $default_path );

		// Don't cache the absolute path so that it can be shared between web servers with different paths.
		$cache_path = finder_tokenize_path( $template, finder_get_path_define_tokens() );

		finder_set_template_cache( $cache_key, $cache_path );
	} else {
		// Make sure that the absolute path to the template is resolved.
		$template = finder_untokenize_path( $template, finder_get_path_define_tokens() );
	}

	// Allow 3rd party plugin filter template file from their plugin.
	$filter_template = apply_filters( 'finder_get_template', $template, $template_name, $args, $template_path, $default_path );

	if ( $filter_template !== $template ) {
		if ( ! file_exists( $filter_template ) ) {
			/* translators: %s template */
			_doing_it_wrong( __FUNCTION__, sprintf( esc_html__( '%s does not exist.', 'finder' ), '<code>' . esc_html( $filter_template ) . '</code>' ), '2.1' );
			return;
		}
		$template = $filter_template;
	}

	$action_args = array(
		'template_name' => $template_name,
		'template_path' => $template_path,
		'located'       => $template,
		'args'          => $args,
	);

	if ( ! empty( $args ) && is_array( $args ) ) {
		if ( isset( $args['action_args'] ) ) {
			_doing_it_wrong(
				__FUNCTION__,
				esc_html__( 'action_args should not be overwritten when calling finder_get_template.', 'finder' ),
				'3.6.0'
			);
			unset( $args['action_args'] );
		}
		extract( $args ); // @codingStandardsIgnoreLine
	}

	do_action( 'finder_before_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args'] );

	include $action_args['located'];

	do_action( 'finder_after_template_part', $action_args['template_name'], $action_args['template_path'], $action_args['located'], $action_args['args'] );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 * yourtheme/$template_path/$template_name
 * yourtheme/$template_name
 * $default_path/$template_name
 *
 * @param string $template_name Template name.
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 * @return string
 */
function finder_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	if ( ! $template_path ) {
		$template_path = 'templates/';
	}

	if ( ! $default_path ) {
		$default_path = 'templates/';
	}

	// Look within passed path within the theme - this is priority.
	if ( false !== strpos( $template_name, 'product_cat' ) || false !== strpos( $template_name, 'product_tag' ) ) {
		$cs_template = str_replace( '_', '-', $template_name );
		$template    = locate_template(
			array(
				trailingslashit( $template_path ) . $cs_template,
				$cs_template,
			)
		);
	}

	if ( empty( $template ) ) {
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name,
			)
		);
	}

	// Get default template/.
	if ( ! $template ) {
		if ( empty( $cs_template ) ) {
			$template = $default_path . $template_name;
		} else {
			$template = $default_path . $cs_template;
		}
	}

	// Return what we found.
	return apply_filters( 'finder_locate_template', $template, $template_name, $template_path );
}

/**
 * Given a path, this will convert any of the subpaths into their corresponding tokens.
 *
 * @param string $path The absolute path to tokenize.
 * @param array  $path_tokens An array keyed with the token, containing paths that should be replaced.
 * @return string The tokenized path.
 */
function finder_tokenize_path( $path, $path_tokens ) {
	// Order most to least specific so that the token can encompass as much of the path as possible.
	uasort(
		$path_tokens,
		function ( $a, $b ) {
			$a = strlen( $a );
			$b = strlen( $b );

			if ( $a > $b ) {
				return -1;
			}

			if ( $b > $a ) {
				return 1;
			}

			return 0;
		}
	);

	foreach ( $path_tokens as $token => $token_path ) {
		if ( 0 !== strpos( $path, $token_path ) ) {
			continue;
		}

		$path = str_replace( $token_path, '{{' . $token . '}}', $path );
	}

	return $path;
}

/**
 * Given a tokenized path, this will expand the tokens to their full path.
 *
 * @param string $path The absolute path to expand.
 * @param array  $path_tokens An array keyed with the token, containing paths that should be expanded.
 * @return string The absolute path.
 */
function finder_untokenize_path( $path, $path_tokens ) {
	foreach ( $path_tokens as $token => $token_path ) {
		$path = str_replace( '{{' . $token . '}}', $token_path, $path );
	}

	return $path;
}

/**
 * Fetches an array containing all of the configurable path constants to be used in tokenization.
 *
 * @return array The key is the define and the path is the constant.
 */
function finder_get_path_define_tokens() {
	$defines = array(
		'ABSPATH',
		'WP_CONTENT_DIR',
		'WP_PLUGIN_DIR',
		'WPMU_PLUGIN_DIR',
		// 'PLUGINDIR',
		'WP_THEME_DIR',
	);

	$path_tokens = array();
	foreach ( $defines as $define ) {
		if ( defined( $define ) ) {
			$path_tokens[ $define ] = constant( $define );
		}
	}

	return apply_filters( 'finder_get_path_define_tokens', $path_tokens );
}

/**
 * Add a template to the template cache.
 *
 * @param string $cache_key Object cache key.
 * @param string $template Located template.
 */
function finder_set_template_cache( $cache_key, $template ) {
	wp_cache_set( $cache_key, $template, 'finder' );

	$cached_templates = wp_cache_get( 'cached_templates', 'finder' );
	if ( is_array( $cached_templates ) ) {
		$cached_templates[] = $cache_key;
	} else {
		$cached_templates = array( $cache_key );
	}

	wp_cache_set( 'cached_templates', $cached_templates, 'finder' );
}

/**
 * Clear the template cache.
 */
function finder_clear_template_cache() {
	$cached_templates = wp_cache_get( 'cached_templates', 'finder' );
	if ( is_array( $cached_templates ) ) {
		foreach ( $cached_templates as $cache_key ) {
			wp_cache_delete( $cache_key, 'finder' );
		}

		wp_cache_delete( 'cached_templates', 'finder' );
	}
}

/**
 * Displays the class names for the .site-content element.
 *
 * @param string|string[] $class Space-separated string or array of class names to add to the class list.
 */
function finder_site_content_class( $class = '' ) {
	// Separates class names with a single space, collates class names for .site-content element.
	echo 'class="' . esc_attr( implode( ' ', finder_get_site_content_class( $class ) ) ) . '"';
}

/**
 * Retrieves an array of the class names for the .site-content element.
 *
 * @since 2.8.0
 *
 * @global WP_Query $wp_query WordPress Query object.
 *
 * @param string|string[] $class Space-separated string or array of class names to add to the class list.
 * @return string[] Array of class names.
 */
function finder_get_site_content_class( $class = '' ) {
	$classes = array( 'site-content' );

	// if ( finder_is_sticky_header() ) {
	// 	$classes[] = 'mt-5';
	// 	$classes[] = 'mb-md-4';
	// 	$classes[] = 'py-5';
	// }

	$classes = array_map( 'esc_attr', $classes );

	/**
	 * Filters the list of CSS .site-content class names for the current post or page.
	 *
	 * @since 2.8.0
	 *
	 * @param string[] $classes An array of .site-content class names.
	 * @param string[] $class   An array of additional class names added to the .site-content.
	 */
	$classes = apply_filters( 'finder_site_content_class', $classes, $class );

	return array_unique( $classes );
}

/**
 * Get main and content area classes
 *
 * @return array
 */
function finder_get_main_and_content_area_classes() {
	$layout      = finder_get_blog_layout();
	$has_sidebar = finder_has_blog_sidebar();
	$style       = finder_get_blog_style();

	$content_area_class = 'content-area';
	$main_class         = 'site-main';
	$should_pad_main    = true;
	$pad_class          = '';

	if ( $has_sidebar ) {
		if ( 'job-board' === $style ) {
			$content_area_class .= ' col-lg-8';
			$should_pad_main     = false;
		} elseif ( 'city-guide' === $style ) {
			$content_area_class .= ' col-lg-12'; // We'll set the widget inside the loop for the sidebar.
			$should_pad_main     = false;
		} elseif ( 'default' === $style ) {
			$content_area_class .= ' col-lg-9';
		} else {
			$content_area_class .= ' col-lg-12';
		}
	} else {
		$content_area_class .= ' col-lg-12';
	}

	if ( 'sidebar-left' === $layout ) {
		$pad_class           = 'ps-lg-3';
		$content_area_class .= ' order-1';
	} elseif ( 'sidebar-right' === $layout ) {
		$pad_class = 'pe-lg-3';
	}

	if ( $should_pad_main ) {
		$main_class .= ' ' . $pad_class;
	}

	return array(
		'main'         => $main_class,
		'content_area' => $content_area_class,
	);
}
