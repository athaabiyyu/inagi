<?php
/**
 * Listing car finder template.
 *
 * @package Finder
 */

?>
<div class="finder-vendor-single-wrap bg-dark">
	<?php
		/**
		 * Functions hooked in to finder_vendor_single_car_finder_before action
		 *
		 * @hooked finder_hivepress_vendor_car_finder_container_wrap_start - 10
		 * @hooked finder_hivepress_vendor_single_breadcrumb - 12
		 * @hooked finder_hivepress_vendor_single_car_finder_page_header - 15
		 * @hooked finder_hivepress_vendor_car_finder_row_wrap_start - 20
		 * @hooked finder_hivepress_vendor_car_finder_sidebar - 30
		 * @hooked finder_hivepress_vendor_car_finder_loop_column_wrap_start - 40
		 */
		do_action( 'finder_vendor_single_car_finder_before', $vendor );

		/**
		 * Functions hooked in to finder_vendor_single_car_finder action
		 *
		 * @hooked finder_hivepress_vendor_single_car_finder_loop - 10
		 * @hooked finder_hivepress_vendor_single_pagination - 20
		 */
		do_action( 'finder_vendor_single_car_finder', $vendor );

		/**
		 * Functions hooked in to finder_vendor_single_car_finder_after action
		 *
		 * @hooked finder_hivepress_vendor_car_finder_loop_column_wrap_end - 20
		 * @hooked finder_hivepress_vendor_car_finder_row_wrap_end - 30
		 * @hooked finder_hivepress_vendor_car_finder_container_wrap_end - 40
		 */
		do_action( 'finder_vendor_single_car_finder_after', $vendor );
	?>
</div>
