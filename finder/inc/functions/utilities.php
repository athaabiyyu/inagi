<?php
/**
 * All types of utility functions used by the theme goes here.
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get a specific property of an array without needing to check if that property exists.
 *
 * Provide a default value if you want to return a specific value if the property is not set.
 *
 * @param array  $array   Array from which the property's value should be retrieved.
 * @param string $prop    Name of the property to be retrieved.
 * @param string $default Optional. Value that should be returned if the property is not set or empty. Defaults to null.
 *
 * @return null|string|mixed The value
 */
function finder_get_prop( $array, $prop, $default = null ) {

	if ( ! is_array( $array ) && ! ( is_object( $array ) && $array instanceof ArrayAccess ) ) {
		return $default;
	}

	if ( ( isset( $array[ $prop ] ) && false === $array[ $prop ] ) ) {
		return false;
	}

	if ( isset( $array[ $prop ] ) ) {
		$value = $array[ $prop ];
	} else {
		$value = '';
	}

	return empty( $value ) && null !== $default ? $default : $value;
}
