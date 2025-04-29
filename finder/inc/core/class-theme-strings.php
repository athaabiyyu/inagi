<?php
/**
 * Finder Theme Strings
 *
 * @package     Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Default Strings
 */
if ( ! function_exists( 'finder_default_strings' ) ) {

	/**
	 * Default Strings
	 *
	 * @since 1.0.0
	 * @param  string  $key  String key.
	 * @param  boolean $echo Print string.
	 * @return mixed        Return string or nothing.
	 */
	function finder_default_strings( $key, $echo = true ) {

		$defaults = apply_filters(
			'finder_default_strings',
			array(

				// Header.
				'string-header-skip-link'                => __( 'Skip to content', 'finder' ),

				// 404 Page Strings.
				'string-404-sub-title'                   => __( 'It looks like the link pointing here was faulty. Maybe try searching?', 'finder' ),

				// Search Page Strings.
				'string-search-nothing-found'            => __( 'Nothing Found', 'finder' ),
				'string-search-nothing-found-message'    => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'finder' ),
				'string-full-width-search-message'       => __( 'Start typing and press enter to search', 'finder' ),
				'string-full-width-search-placeholder'   => __( 'Search &hellip;', 'finder' ),
				'string-header-cover-search-placeholder' => __( 'Search &hellip;', 'finder' ),
				'string-search-input-placeholder'        => __( 'Search &hellip;', 'finder' ),

				// Comment Template Strings.
				'string-comment-reply-link'              => __( 'Reply', 'finder' ),
				'string-comment-edit-link'               => __( 'Edit', 'finder' ),
				'string-comment-awaiting-moderation'     => __( 'Your comment is awaiting moderation.', 'finder' ),
				'string-comment-title-reply'             => __( 'Leave a Comment', 'finder' ),
				'string-comment-cancel-reply-link'       => __( 'Cancel Reply', 'finder' ),
				'string-comment-label-submit'            => __( 'Post Comment &raquo;', 'finder' ),
				'string-comment-label-message'           => __( 'Type here..', 'finder' ),
				'string-comment-label-name'              => __( 'Name*', 'finder' ),
				'string-comment-label-email'             => __( 'Email*', 'finder' ),
				'string-comment-label-website'           => __( 'Website', 'finder' ),
				'string-comment-closed'                  => __( 'Comments are closed.', 'finder' ),
				'string-comment-navigation-title'        => __( 'Comment navigation', 'finder' ),
				'string-comment-navigation-next'         => __( 'Newer Comments', 'finder' ),
				'string-comment-navigation-previous'     => __( 'Older Comments', 'finder' ),

				// Blog Default Strings.
				'string-blog-page-links-before'          => __( 'Pages:', 'finder' ),
				'string-blog-meta-author-by'             => __( 'By ', 'finder' ),
				'string-blog-meta-leave-a-comment'       => __( 'Leave a Comment', 'finder' ),
				'string-blog-meta-one-comment'           => __( '1 Comment', 'finder' ),
				'string-blog-meta-multiple-comment'      => __( '% Comments', 'finder' ),
				'string-blog-navigation-next'            => __( 'Next Page', 'finder' ) . ' <span class="ast-right-arrow">&rarr;</span>',
				'string-blog-navigation-previous'        => '<span class="ast-left-arrow">&larr;</span> ' . __( 'Previous Page', 'finder' ),

				// Single Post Default Strings.
				'string-single-page-links-before'        => __( 'Pages:', 'finder' ),
				/* translators: 1: Post type label */
				'string-single-navigation-next'          => __( 'Next %s', 'finder' ) . ' <span class="ast-right-arrow">&rarr;</span>',
				/* translators: 1: Post type label */
				'string-single-navigation-previous'      => '<span class="ast-left-arrow">&larr;</span> ' . __( 'Previous %s', 'finder' ),

				// Content None.
				'string-content-nothing-found-message'   => __( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'finder' ),

			)
		);

		if ( is_rtl() ) {
			$defaults['string-blog-navigation-next']     = __( 'Next Page', 'finder' ) . ' <span class="ast-left-arrow">&larr;</span>';
			$defaults['string-blog-navigation-previous'] = '<span class="ast-right-arrow">&rarr;</span> ' . __( 'Previous Page', 'finder' );

			/* translators: 1: Post type label */
			$defaults['string-single-navigation-next'] = __( 'Next %s', 'finder' ) . ' <span class="ast-left-arrow">&larr;</span>';
			/* translators: 1: Post type label */
			$defaults['string-single-navigation-previous'] = '<span class="ast-right-arrow">&rarr;</span> ' . __( 'Previous %s', 'finder' );
		}

		$output = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

		/**
		 * Print or return
		 */
		if ( $echo ) {
			echo apply_filters( 'finder_default_strings_output', $output, $echo ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			return apply_filters( 'finder_default_strings_output', $output, $echo );
		}
	}
}
