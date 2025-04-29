<?php
/**
 * Functions used in HTML markup
 *
 * @package Finder
 */

/**
 * Build list of attributes into a string and apply contextual filter on string.
 *
 * The contextual filter is of the form `finder_attr_{context}_output`.
 *
 * @param string $context    The context, to build filter name.
 * @param array  $attributes Optional. Extra attributes to merge with defaults.
 * @param array  $args       Optional. Custom data to pass to filter.
 * @param bool   $echo       Optional. Should return or output.
 * @return void|bool
 */
function finder_render_attr( $context, $attributes = array(), $args = array(), $echo = true ) {
	$output = '';

	// Cycle through attributes, build tag attribute string.
	foreach ( $attributes as $key => $value ) {

		if ( ! $value ) {
			continue;
		}

		if ( true === $value ) {
			$output .= esc_html( $key ) . ' ';
		} else {
			if ( 'href' === $key || 'src' === $key ) {
				$output .= sprintf( '%s="%s" ', esc_html( $key ), esc_url( $value ) );
			} else {
				$output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
			}
		}
	}

	$output = apply_filters( "finder_attr_{$context}_output", $output, $attributes, $context, $args );

	if ( $echo ) {
		echo trim( $output ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return trim( $output );
	}
}

/**
 * Return classnames for <header> element.
 *
 * @return array classnames for the <header>
 */
function finder_get_header_classes() {

	$navbar_dark = finder_is_header_navbar_dark();

	$classes = array( 'navbar', 'navbar-expand-lg' );

	if ( $navbar_dark ) {
		$classes[] = 'navbar-dark'; // header_navbar_text.

		if ( ! finder_is_header_transparent_navbar() ) {
			$classes[] = 'bg-dark'; // header_navbar_bg.
		}
	} else {
		$classes[] = 'navbar-light'; // header_navbar_text.

		if ( ! finder_is_header_transparent_navbar() ) {
			$classes[] = 'bg-light'; // header_navbar_bg.
		}
	}

	if ( finder_is_sticky_header() ) {
		$classes[] = 'fixed-top'; // header_navbar_pos.
	}

	$classes = array_unique( apply_filters( 'finder_header_class', $classes ) );
	$classes = array_map( 'sanitize_html_class', $classes );

	return apply_filters( 'finder_get_header_classes', $classes );
}

/**
 * Sanitize Form HTML.
 *
 * @param string $input html.
 * @return string html.
 */
function finder_sanitize_html( $input ) {

	$allowed = array(
		'a'      => array(
			'href'   => array(),
			'title'  => array(),
			'target' => array(),
			'class'  => array(),
		),
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
		'p'      => array(
			'class' => array(),
		),
		'span'   => array(
			'class' => array(),
		),
		'i'      => array(
			'class' => array(),
		),
		'form'   => array(
			'accept-charset' => array(),
			'autocomplete'   => array(),
			'enctype'        => array(),
			'class'          => array(),
			'method'         => array(),
			'action'         => array(),
			'name'           => array(),
			'novalidate'     => array(),
			'rel'            => array(),
			'target'         => array(),
		),
		'label'  => array(
			'for'   => array(),
			'class' => array(),
		),
		'input'  => array(
			'id'             => array(),
			'type'           => array(),
			'class'          => array(),
			'placeholder'    => array(),
			'name'           => array(),
			'required'       => array(),
			'value'          => array(),
			'disabled'       => array(),
			'size'           => array(),
			'readonly'       => array(),
			'maxlength'      => array(),
			'min'            => array(),
			'max'            => array(),
			'multiple'       => array(),
			'title'          => array(),
			'pattern'        => array(),
			'form'           => array(),
			'formaction'     => array(),
			'formenctype'    => array(),
			'formmethod'     => array(),
			'formtarget'     => array(),
			'formnovalidate' => array(),
			'novalidate'     => array(),
		),
		'button' => array(
			'class' => array(),
			'type'  => array(),
			'name'  => array(),
		),
		'div'    => array(
			'class' => array(),
		),
	);

	return wp_kses( $input, $allowed );
}

/**
 * Gets an array of HTML allowed in post meta.
 *
 * @return array
 */
function finder_get_post_meta_allowed_html() {
	return array(
		'span' => array(
			'class' => array(),
		),
		'i'    => array(
			'class' => array(),
		),
		'a'    => array(
			'href'  => array(),
			'title' => array(),
			'rel'   => array(),
			'class' => array(),
		),
		'time' => array(
			'datetime' => array(),
			'class'    => array(),
		),
	);
}

