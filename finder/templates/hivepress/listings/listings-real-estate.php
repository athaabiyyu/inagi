<?php
/**
 * Listing real estate template.
 *
 * @package Finder
 */

?>
<div class="finder-listings-wrap">
	<?php
		/**
		 * Functions hooked in to finder_listings_real_estate_loop_before action
		 *
		 * @hooked finder_hivepress_listings_container_wrap_start - 10
		 * @hooked finder_hivepress_listings_row_wrap_start - 20
		 * @hooked finder_hivepress_listings_sidebar - 30
		 * @hooked finder_hivepress_listings_loop_column_wrap_start - 40
		 * @hooked finder_hivepress_listings_breadcrumb - 50
		 * @hooked finder_hivepress_listings_page_header - 60
		 * @hooked finder_hivepress_listings_top_control_bar - 70
		 */
		do_action( 'finder_listings_real_estate_loop_before' );

		/**
		 * Functions hooked in to finder_listings_real_estate_loop action
		 *
		 * @hooked finder_hivepress_listings_real_state_loop_content - 10
		 */
		do_action( 'finder_listings_real_estate_loop' );

		/**
		 * Functions hooked in to finder_listings_real_estate_loop_after action
		 *
		 * @hooked finder_hivepress_listings_pagination - 10
		 * @hooked finder_hivepress_listings_loop_column_wrap_end - 20
		 * @hooked finder_hivepress_listings_row_wrap_end - 30
		 * @hooked finder_hivepress_listings_container_wrap_end - 40
		 */
		do_action( 'finder_listings_real_estate_loop_after' );
	?>
</div>
