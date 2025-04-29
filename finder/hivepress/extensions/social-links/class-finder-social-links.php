<?php
/**
 * Social Links block.
 *
 * @package HivePress\Blocks
 */

use HivePress\Blocks\Social_Links;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Social Links block class.
 *
 * @class Social_Links
 */
class Finder_Social_Links extends Social_Links {
    /**
	 * Sets object context value.
	 *
	 * @param string $name Context name.
	 * @param mixed  $value Context value.
	 */
	public function finder_set_context( $name, $value = null ) {
		if ( is_array( $name ) ) {
			$this->context = $name;
		} else {
			$this->context[ $name ] = $value;
		}
	}

    /**
	 * Sets object model value.
	 *
	 * @param string $model model value.
	 */
	public function finder_set_model( $model ) {
			$this->model = $model;	
	}
}