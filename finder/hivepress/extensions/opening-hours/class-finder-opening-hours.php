<?php
/**
 * Opening hours block.
 *
 * @package HivePress\Blocks
 */

use HivePress\Blocks\Opening_Hours;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Opening hours block class.
 *
 * @class Opening_Hours
 */
class Finder_Opening_Hours extends Opening_Hours {
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
}