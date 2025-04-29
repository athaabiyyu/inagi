<?php
/**
 * The Template for displaying listing archives
 *
 * @package Finder
 */

?>
<div class="finder-hivepress-listings">
	<?php
		/**
		 * Functions hooked in to finder_hivepress_archive_listings action
		 *
		 * @hooked finder_hivepress_listings - 10
		 */
		do_action( 'finder_hivepress_archive_listings' );
	?>
</div>
