<?php
/**
 * The Template for displaying listing single.
 *
 * @package Finder
 */

?>
<div class="finder-hivepress-listing-single">
	<?php
		/**
		 * Functions hooked in to finder_hivepress_listing_single action
		 *
		 * @hooked finder_hivepress_listing_single_content - 10
		 */
		do_action( 'finder_hivepress_listing_single', $listing );
	?>
</div>
