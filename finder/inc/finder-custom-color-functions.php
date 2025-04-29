<?php
/**
 * Finder Theme Customizer
 *
 * @package Finder
 */

if ( ! function_exists( 'finder_sass_hex_to_rgba' ) ) {
	function finder_sass_hex_to_rgba( $hex, $alpa = '' ) {
		$hex = sanitize_hex_color( $hex );
		preg_match( '/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $matches );
		for ( $i = 1; $i <= 3; $i++ ) {
			$matches[ $i ] = hexdec( $matches[ $i ] );
		}
		if ( ! empty( $alpa ) ) {
			$rgb = 'rgba(' . $matches[1] . ', ' . $matches[2] . ', ' . $matches[3] . ', ' . $alpa . ')';
		} else {
			$rgb = 'rgba(' . $matches[1] . ', ' . $matches[2] . ', ' . $matches[3] . ')';
		}
		return $rgb;
	}
}

if ( ! function_exists( 'finder_sass_yiq' ) ) {
	function finder_sass_yiq( $hex ) {
		$hex    = sanitize_hex_color( $hex );
		$length = strlen( $hex );
		if ( $length < 5 ) {
			$hex = ltrim( $hex, '#' );
			$hex = '#' . $hex . $hex;
		}

		preg_match( '/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $matches );

		for ( $i = 1; $i <= 3; $i++ ) {
			$matches[ $i ] = hexdec( $matches[ $i ] );
		}
		$yiq = ( ( $matches[1] * 299 ) + ( $matches[2] * 587 ) + ( $matches[3] * 114 ) ) / 1000;
		return ( $yiq >= 128 ) ? '#000' : '#fff';
	}
}

/**
 * Get all of the finder theme colors.
 *
 * @return array $finder_theme_colors The finder Theme Colors.
 */
if ( ! function_exists( 'finder_get_theme_colors' ) ) {
	function finder_get_theme_colors() {
		$finder_theme_colors = array(
			'primary_color' => get_theme_mod( 'finder_primary_color', apply_filters( 'finder_default_primary_color', '#fd5631' ) ),
		);

		return apply_filters( 'finder_get_theme_colors', $finder_theme_colors );
	}
}

/**
 * Get Customizer Color css.
 *
 * @see finder_get_custom_color_css()
 * @return array $styles the css
 */
if ( ! function_exists( 'finder_get_custom_color_css' ) ) {
	function finder_get_custom_color_css() {
		$finder_theme_colors      = finder_get_theme_colors();
		$primary_color             = $finder_theme_colors['primary_color'];
		$primary_color_yiq         = finder_sass_yiq( $primary_color );
		$primary_color_darken_10p  = finder_adjust_color_brightness( $primary_color, -4.5 );
		$primary_color_darken_15p  = finder_adjust_color_brightness( $primary_color, -5.7 );
		$primary_color_lighten_20p = finder_adjust_color_brightness( $primary_color, 20 );
		$primary_color_lighten_10p = finder_adjust_color_brightness( $primary_color, 27.7 );


		$styles =
		'
/*
 * Primary Color
 */


';

		return apply_filters( 'finder_get_custom_color_css', $styles );
	}
}


/**
 * Add CSS in <head> for styles handled by the theme customizer
 *
 * @since 1.0.0
 * @return void
 */
if ( ! function_exists( 'finder_enqueue_custom_color_css' ) ) {
	function finder_enqueue_custom_color_css() {
		if ( get_theme_mod( 'finder_enable_custom_color', 'no' ) === 'yes' ) {
			$finder_theme_colors      = finder_get_theme_colors();

			$primary_color             = $finder_theme_colors['primary_color'];
			$primary_color_yiq         = finder_sass_yiq( $primary_color );
			$primary_color_darken_10p  = finder_adjust_color_brightness( $primary_color, -18 );
			$primary_color_darken_15p  = finder_adjust_color_brightness( $primary_color, -5.7 );
			$primary_color_darken_45p  = finder_adjust_color_brightness( $primary_color, -45 );
			$primary_color_soft_10     = finder_sass_hex_to_rgba( $primary_color, '.1' );
			$primary_color_faded       = finder_sass_hex_to_rgba( $primary_color, '.12' );
			$primary_color_shadow      = finder_sass_hex_to_rgba( $primary_color, '.9' );
			$primary_color_shadow_sm   = finder_sass_hex_to_rgba( $primary_color, '.2' );
			$primary_color_border      = finder_sass_hex_to_rgba( $primary_color, '.35' );
			$primary_color_soft_10d    = finder_sass_hex_to_rgba( $primary_color, '.12' );
			$primary_color_desat       = finder_sass_hex_to_rgba( $primary_color, '.6' );
			$primary_color_opacity     = finder_sass_hex_to_rgba( $primary_color, '.05' );
			$primary_color_outline_20  = finder_sass_hex_to_rgba( $primary_color, '.2' );
			$primary_color_bg_outline  = finder_sass_hex_to_rgba( $primary_color, '.08' );
			$primary_color_outline_70  = finder_sass_hex_to_rgba( $primary_color, '.7' );
			$primary_color_outline_5   = finder_sass_hex_to_rgba( $primary_color, '.5' );
			$primary_color_opacity_15  = finder_sass_hex_to_rgba( $primary_color, '.20' );
			$primary_color_opacity_8   = finder_sass_hex_to_rgba( $primary_color, '.8' );

			$color_root = ':root {
				--fr-primary: 				' . $finder_theme_colors['primary_color'] . ';
				--fr-primary-shadow:		' . $primary_color_shadow . ';
				--fr-primary-shadow-sm:		' . $primary_color_shadow_sm . ';
				--fr-primary-faded:		    ' . $primary_color_faded . ';
				--fr-primary-border:		' . $primary_color_border . ';
				--fr-primary-bg-d: 			' . $primary_color_darken_10p . ';
				--fr-primary-border-d: 		' . $primary_color_darken_15p . ';
				--fr-primary-soft: 			' . $primary_color_soft_10 . ';
				--fr-primary-soft-d: 		' . $primary_color_soft_10d . ';
				--fr-primary-desat: 		' . $primary_color_desat . ';
				--fr-primary-o-5: 			' . $primary_color_opacity . ';
				--fr-primary-outline-20: 	' . $primary_color_outline_20 . ';
				--fr-primary-outline-bg: 	' . $primary_color_bg_outline . ';
				--fr-dark-primary: 			' . $primary_color_darken_45p . ';
				--fr-primary-outline-5: 	' . $primary_color_outline_5 .';
				--fr-primary-outline-75: 	' . $primary_color_outline_70 . ';
				--fr-primary-opacity-15: 	' . $primary_color_opacity_15 . ';
				--fr-primary-opacity-8: 	' . $primary_color_opacity_8 . ';
			}';
			$styles     = $color_root . finder_get_custom_color_css();

			wp_add_inline_style( 'finder-color', $styles );
		}
	}
}


add_action( 'wp_enqueue_scripts', 'finder_enqueue_custom_color_css', 130 );