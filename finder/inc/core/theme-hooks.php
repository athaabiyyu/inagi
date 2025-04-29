<?php
/**
 * Theme Hook Alliance hook stub list.
 *
 * @see  https://github.com/zamoose/themehookalliance
 *
 * @package     Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Themes and Plugins can check for finder_hooks using current_theme_supports( 'finder_hooks', $hook )
 * to determine whether a theme declares itself to support this specific hook type.
 *
 * Example:
 * <code>
 *      // Declare support for all hook types
 *      add_theme_support( 'finder_hooks', array( 'all' ) );
 *
 *      // Declare support for certain hook types only
 *      add_theme_support( 'finder_hooks', array( 'header', 'content', 'footer' ) );
 * </code>
 */
add_theme_support(
	'finder_hooks',
	array(

		/**
		 * As a Theme developer, use the 'all' parameter, to declare support for all
		 * hook types.
		 * Please make sure you then actually reference all the hooks in this file,
		 * Plugin developers depend on it!
		 */
		'all',

		/**
		 * Themes can also choose to only support certain hook types.
		 * Please make sure you then actually reference all the hooks in this type
		 * family.
		 *
		 * When the 'all' parameter was set, specific hook types do not need to be
		 * added explicitly.
		 */
		'html',
		'body',
		'head',
		'header',
		'content',
		'entry',
		'comments',
		'sidebars',
		'sidebar',
		'footer',

	/**
	 * If/when WordPress Core implements similar methodology, Themes and Plugins
	 * will be able to check whether the version of THA supplied by the theme
	 * supports Core hooks.
	 */
	)
);

/**
 * Determines, whether the specific hook type is actually supported.
 *
 * Plugin developers should always check for the support of a <strong>specific</strong>
 * hook type before hooking a callback function to a hook of this type.
 *
 * Example:
 * <code>
 *      if ( current_theme_supports( 'finder_hooks', 'header' ) )
 *          add_action( 'finder_head_top', 'prefix_header_top' );
 * </code>
 *
 * @param bool  $bool true.
 * @param array $args The hook type being checked.
 * @param array $registered All registered hook types.
 *
 * @return bool
 */
function finder_current_theme_supports( $bool, $args, $registered ) {
	return in_array( $args[0], $registered[0] ) || in_array( 'all', $registered[0] );
}
add_filter( 'current_theme_supports-finder_hooks', 'finder_current_theme_supports', 10, 3 );

/**
 * HTML <html> hook
 * Special case, useful for <DOCTYPE>, etc.
 * $finder_supports[] = 'html;
 */
function finder_html_before() {
	do_action( 'finder_html_before' );
}

/**
 * Body Bottom
 */
function finder_body_bottom() {
	do_action( 'finder_body_bottom' );
}

/**
 * HTML <head> hooks
 *
 * $finder_supports[] = 'head';
 */
function finder_head_top() {
	do_action( 'finder_head_top' );
}

/**
 * Head Bottom
 */
function finder_head_bottom() {
	do_action( 'finder_head_bottom' );
}

/**
 * Semantic <header> hooks
 *
 * $finder_supports[] = 'header';
 */
function finder_header_before() {
	do_action( 'finder_header_before' );
}

/**
 * Site Header
 */
function finder_header() {
	do_action( 'finder_header' );
}

/**
 * Masthead Top
 */
function finder_masthead_top() {
	do_action( 'finder_masthead_top' );
}

/**
 * Masthead
 */
function finder_masthead() {
	do_action( 'finder_masthead' );
}

/**
 * Masthead Bottom
 */
function finder_masthead_bottom() {
	do_action( 'finder_masthead_bottom' );
}

/**
 * Header After
 */
function finder_header_after() {
	do_action( 'finder_header_after' );
}

/**
 * Main Header bar top
 */
function finder_main_header_bar_top() {
	do_action( 'finder_main_header_bar_top' );
}

/**
 * Main Header bar bottom
 */
function finder_main_header_bar_bottom() {
	do_action( 'finder_main_header_bar_bottom' );
}

/**
 * Main Header Content
 */
function finder_masthead_content() {
	do_action( 'finder_masthead_content' );
}
/**
 * Main toggle button before
 */
function finder_masthead_toggle_buttons_before() {
	do_action( 'finder_masthead_toggle_buttons_before' );
}

/**
 * Main toggle buttons
 */
function finder_masthead_toggle_buttons() {
	do_action( 'finder_masthead_toggle_buttons' );
}

/**
 * Main toggle button after
 */
function finder_masthead_toggle_buttons_after() {
	do_action( 'finder_masthead_toggle_buttons_after' );
}

/**
 * Semantic <content> hooks
 *
 * $finder_supports[] = 'content';
 */
function finder_content_before() {
	do_action( 'finder_content_before' );
}

/**
 * Content after
 */
function finder_content_after() {
	do_action( 'finder_content_after' );
}

/**
 * Content top
 */
function finder_content_top() {
	do_action( 'finder_content_top' );
}

/**
 * Content bottom
 */
function finder_content_bottom() {
	do_action( 'finder_content_bottom' );
}

/**
 * Content while before
 */
function finder_content_while_before() {
	do_action( 'finder_content_while_before' );
}

/**
 * Content loop
 */
function finder_content_loop() {
	do_action( 'finder_content_loop' );
}

/**
 * Conten Page Loop.
 *
 * Called from page.php
 */
function finder_content_page_loop() {
	do_action( 'finder_content_page_loop' );
}

/**
 * Content while after
 */
function finder_content_while_after() {
	do_action( 'finder_content_while_after' );
}

/**
 * Semantic <entry> hooks
 *
 * $finder_supports[] = 'entry';
 */
function finder_entry_before() {
	do_action( 'finder_entry_before' );
}

/**
 * Entry after
 */
function finder_entry_after() {
	do_action( 'finder_entry_after' );
}

/**
 * Entry content before
 */
function finder_entry_content_before() {
	do_action( 'finder_entry_content_before' );
}

/**
 * Entry content after
 */
function finder_entry_content_after() {
	do_action( 'finder_entry_content_after' );
}

/**
 * Entry Top
 */
function finder_entry_top() {
	do_action( 'finder_entry_top' );
}

/**
 * Entry bottom
 */
function finder_entry_bottom() {
	do_action( 'finder_entry_bottom' );
}

/**
 * Single Post Header Before
 */
function finder_single_header_before() {
	do_action( 'finder_single_header_before' );
}

/**
 * Single Post Header After
 */
function finder_single_header_after() {
	do_action( 'finder_single_header_after' );
}

/**
 * Single Post Header Top
 */
function finder_single_header_top() {
	do_action( 'finder_single_header_top' );
}

/**
 * Single Post Header Bottom
 */
function finder_single_header_bottom() {
	do_action( 'finder_single_header_bottom' );
}

/**
 * Comments block hooks
 *
 * $finder_supports[] = 'comments';
 */
function finder_comments_before() {
	do_action( 'finder_comments_before' );
}

/**
 * Comments after.
 */
function finder_comments_after() {
	do_action( 'finder_comments_after' );
}

/**
 * Semantic <sidebar> hooks
 *
 * $finder_supports[] = 'sidebar';
 */
function finder_sidebars_before() {
	do_action( 'finder_sidebars_before' );
}

/**
 * Sidebars after
 */
function finder_sidebars_after() {
	do_action( 'finder_sidebars_after' );
}

/**
 * Semantic <footer> hooks
 *
 * $finder_supports[] = 'footer';
 */
function finder_footer() {
	do_action( 'finder_footer' );
}

/**
 * Footer before
 */
function finder_footer_before() {
	do_action( 'finder_footer_before' );
}

/**
 * Footer after
 */
function finder_footer_after() {
	do_action( 'finder_footer_after' );
}

/**
 * Footer top
 */
function finder_footer_content_top() {
	do_action( 'finder_footer_content_top' );
}

/**
 * Footer
 */
function finder_footer_content() {
	do_action( 'finder_footer_content' );
}

/**
 * Footer bottom
 */
function finder_footer_content_bottom() {
	do_action( 'finder_footer_content_bottom' );
}

/**
 * Archive header
 */
function finder_archive_header() {
	do_action( 'finder_archive_header' );
}

/**
 * Pagination
 */
function finder_pagination() {
	do_action( 'finder_pagination' );
}

/**
 * Entry content single
 */
function finder_entry_content_single() {
	do_action( 'finder_entry_content_single' );
}

/**
 * 404
 */
function finder_entry_content_404_page() {
	do_action( 'finder_entry_content_404_page' );
}

/**
 * Entry content blog
 */
function finder_entry_content_blog() {
	do_action( 'finder_entry_content_blog' );
}

/**
 * Blog featured post section
 */
function finder_blog_post_featured_format() {
	do_action( 'finder_blog_post_featured_format' );
}

/**
 * Primary Content Top
 */
function finder_primary_content_top() {
	do_action( 'finder_primary_content_top' );
}

/**
 * Primary Content Bottom
 */
function finder_primary_content_bottom() {
	do_action( 'finder_primary_content_bottom' );
}

/**
 * 404 Page content template action.
 */
function finder_404_content_template() {
	do_action( 'finder_404_content_template' );
}

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Fire the wp_body_open action.
	 * Adds backward compatibility for WordPress versions < 5.2
	 *
	 * @since 1.8.7
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}
