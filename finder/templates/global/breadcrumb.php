<?php
/**
 * Site breadcrumb
 *
 * @package     Finder\Templates
 * @see         finder_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	$output = $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		if ( ! empty( $crumb[1] ) && count( $breadcrumb ) !== $key + 1 ) {
			$output .= $before;

			$home_prefix = '';
			if ( 0 === $key ) {
				$home_prefix = '';
			}

			$output .= '<a href="' . esc_url( $crumb[1] ) . '">' . wp_kses_post( $home_prefix ) . esc_html( $crumb[0] ) . '</a>';
		} else {
			$output .= str_replace( 'breadcrumb-item', 'breadcrumb-item active', $before );
			$output .= esc_html( $crumb[0] );
		}

		$output .= $after;

		if ( count( $breadcrumb ) !== $key + 1 ) {
			$output .= $delimiter;
		}
	}

	$output .= $wrap_after;

	echo wp_kses_post( $output );

}
