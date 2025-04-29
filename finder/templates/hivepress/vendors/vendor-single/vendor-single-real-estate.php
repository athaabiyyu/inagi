<?php
/**
 * Listing real estate template.
 *
 * @package Finder
 */

?>
<div class="finder-vendor-single-wrap">
	<?php
		/**
		 * Functions hooked in to finder_vendor_single_real_estate_before action
		 *
		 * @hooked finder_hivepress_vendor_single_container_wrap_start - 10
		 * @hooked finder_hivepress_vendor_single_breadcrumb - 15
		 * @hooked finder_hivepress_vendor_single_row_wrap_start - 20
		 * @hooked finder_hivepress_vendor_single_sidebar - 30
		 * @hooked finder_hivepress_vendor_single_loop_column_wrap_start - 40
		 * @hooked finder_hivepress_vendor_single_page_header - 50
		 */
		do_action( 'finder_vendor_single_real_estate_before', $vendor );

		/**
		 * Functions hooked in to finder_vendor_single_real_estate action
		 *
		 * @hooked finder_hivepress_vendor_single_real_estate_loop -10
		 * @hooked finder_hivepress_vendor_single_pagination - 20
		 */
		do_action( 'finder_vendor_single_real_estate', $vendor );

		/**
		 * Functions hooked in to finder_vendor_single_real_estate_after action
		 *
		 * @hooked finder_hivepress_vendor_single_loop_column_wrap_end - 20
		 * @hooked finder_hivepress_vendor_single_row_wrap_end - 30
		 * @hooked finder_hivepress_vendor_single_container_wrap_end - 40
		 */
		do_action( 'finder_vendor_single_real_estate_after', $vendor );
	?>
</div>
