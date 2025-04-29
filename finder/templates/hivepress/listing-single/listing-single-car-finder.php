<?php
/**
 * Listing single car-finder template.
 *
 * @package Finder
 */

$container_class  = 'container mb-md-4';
$sticky_header    = finder_is_sticky_header();

if ( $sticky_header ) {
	$container_class = 'container mt-5 mb-md-4 py-5';
}

?>
<!-- Page content-->
<div class="<?php echo esc_attr( $container_class ); ?>">
	<?php
	/**
	 * Functions hooked in to finder_hivepress_listing_single_car_finder_breadcrumb action
	 *
	 * @hooked finder_hivepress_listing_single_breadcrumb - 10
	 */
	do_action( 'finder_hivepress_listing_single_car_finder_breadcrumb', $listing );
	?>
	<!-- Title + Sharing-->
	<div class="d-sm-flex align-items-end align-items-md-center justify-content-between position-relative mb-4" style="z-index: 1025;">
		<div class="me-3">
			<?php
			/**
			 * Functions hooked in to finder_hivepress_listing_single_car_finder_header action
			 *
			 * @hooked finder_hivepress_listing_single_title - 10
			 */
			do_action( 'finder_hivepress_listing_single_car_finder_header', $listing );
			?>
		</div>
		<?php
		/**
		 * Functions hooked in to finder_hivepress_listing_single_car_finder_features action
		 *
		 * @hooked finder_hivepress_listing_single_features_wrap_start - 10
		 * @hooked finder_hivepress_listing_single_add_to_wishlist - 20
		 * @hooked finder_hivepress_listing_single_social_share - 30
		 * @hooked finder_hivepress_listing_single_features_wrap_end - 40
		 */
		do_action( 'finder_hivepress_listing_single_car_finder_features', $listing );
		?>
	</div>
	<div class="row">        
		<div class="col-md-7">
			<?php
			/**
			 * Functions hooked in to finder_hivepress_listing_single_car_finder_body action
			 *
			 * @hooked finder_hivepress_listing_car_finder_gallery - 10
			 * @hooked finder_hivepress_listing_single_post_content - 20
			 * @hooked finder_hivepress_listing_car_finder_single_meta - 30
			 * @hooked finder_hivepress_listing_single_rating_advanced - 40
			 * @hooked finder_hivepress_listing_single_review - 50
			 */
			do_action( 'finder_hivepress_listing_single_car_finder_body', $listing );
			?>
		</div>
		<div class="col-md-5 pt-5 pt-md-0" style="margin-top: -6rem;">
			<div class="sticky-top pt-5">
				<?php
				/**
				 * Functions hooked in to finder_hivepress_listing_single_car_finder_sidebar action
				 *
				 * @hooked finder_hivepress_listing_car_finder_attributes - 10
				 * @hooked finder_hivepress_listing_car_finder_vendor_block - 20
				 * @hooked finder_hivepress_listing_car_finder_email - 30
				 */
				do_action( 'finder_hivepress_listing_single_car_finder_sidebar', $listing );
				?>
			</div>
		</div>
	</div>
	<?php
	/**
	 * Functions hooked in to finder_hivepress_listing_single_car_finder_footer action
	 *
	 * @hooked finder_hivepress_listing_single_related_post - 10
	 */
	do_action( 'finder_hivepress_listing_single_car_finder_footer', $listing );
	?>
</div>
