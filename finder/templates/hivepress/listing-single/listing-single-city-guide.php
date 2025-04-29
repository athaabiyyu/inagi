<?php
/**
 * Listing single city guide template.
 *
 * @package Finder
 */

$container_class = 'container';
$sticky_header   = finder_is_sticky_header();

if ( $sticky_header ) {
	$container_class .= ' pt-5 mt-5';
}

?>
<!-- Page header-->
<div class="<?php echo esc_attr( $container_class ); ?>">
	<?php
	/**
	 * Functions hooked into finder_hivepress_listing_single_city_guide_breadcrumb action
	 *
	 * @hooked finder_hivepress_listing_single_breadcrumb - 10
	 */
	do_action( 'finder_hivepress_listing_single_city_guide_breadcrumb', $listing );
	?>
	<div class="d-sm-flex align-items-center justify-content-between mb-4 pb-sm-2"> 
		<?php
		/**
		 * Functions hooked into finder_listing_single_city_guide_header action
		 *
		 * @hooked finder_hivepress_listing_single_title - 10
		 * @hooked finder_hivepress_listing_single_features_wrap_start - 20
		 * @hooked finder_hivepress_listing_single_add_to_wishlist - 30
		 * @hooked finder_hivepress_listing_single_social_share - 40
		 * @hooked finder_hivepress_listing_single_features_wrap_end - 50
		 */
		do_action( 'finder_hivepress_listing_single_city_guide_header', $listing );
		?>
	</div>
	<?php
	/**
	 * Functions hooked into finder_hivepress_single_listing_city_guide_summary action
	 *
	 * @hooked finder_hivepress_single_listing_city_guide_data_tabs - 10
	 */
	do_action( 'finder_hivepress_single_listing_city_guide_summary', $listing );
	?>
</div>
<!-- Recently viewed-->
<?php
/**
 * Functions hooked in to finder_hivepress_single_listing_city_guide_footer action
 *
 * @hooked finder_hivepress_listing_single_related_post - 20
 */
do_action( 'finder_hivepress_single_listing_city_guide_footer', $listing );
?>
