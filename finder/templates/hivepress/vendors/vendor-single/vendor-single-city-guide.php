<?php
/**
 * Listing city guide template.
 *
 * @package Finder
 */

?>
<div class="finder-vendor-single-wrap bg-secondary">
	<?php
		/**
		 * Functions hooked in to finder_vendor_single_city_guide_before action
		 *
		 * @hooked finder_hivepress_vendor_city_guide_container_wrap_start - 10
		 * @hooked finder_hivepress_vendor_single_breadcrumb - 12
		 * @hooked finder_hivepress_vendor_single_city_guide_page_header - 15
		 * @hooked finder_hivepress_vendor_city_guide_row_wrap_start - 20
		 * @hooked finder_hivepress_vendor_city_guide_sidebar - 30
		 * @hooked finder_hivepress_vendor_city_guide_loop_column_wrap_start - 40
		 */
		do_action( 'finder_vendor_single_city_guide_before', $vendor );
	?>
	<?php
		/**
		 * Functions hooked in to finder_vendor_single_city_guide action
		 *
		 * @hooked finder_hivepress_vendor_single_city_guide_loop - 10
		 * @hooked finder_hivepress_vendor_single_pagination - 20
		 */
		do_action( 'finder_vendor_single_city_guide', $vendor );
	?>
	<?php
		/**
		 * Functions hooked in to finder_vendor_single_city_guide_after action
		 *
		 * @hooked finder_hivepress_vendor_city_guide_loop_column_wrap_end - 20
		 * @hooked finder_hivepress_vendor_city_guide_row_wrap_end - 30
		 * @hooked finder_hivepress_vendor_city_guide_container_wrap_end - 40
		 */
		do_action( 'finder_vendor_single_city_guide_after', $vendor );
	?>
</div>
