<?php
/**
 * Listing single real estate template.
 *
 * @package Finder
 */

$container_class  = 'container mb-md-4';
$sticky_header    = finder_is_sticky_header();

if ( $sticky_header ) {
	$container_class = 'container pt-5 mt-5';
}

?>
<!-- Page header-->
<div class="<?php echo esc_attr( $container_class ); ?>">
	<?php
	/**
	 * Functions hooked in to finder_hivepress_listing_single_real_estate_header action
	 *
	 * @hooked finder_hivepress_listing_single_breadcrumb - 10
	 * @hooked finder_hivepress_listing_single_title - 20
	 * @hooked finder_hivepress_listing_single_real_estate_attributes_primary - 30
	 */
	do_action( 'finder_hivepress_listing_single_real_estate_header', $listing );

	?>
	<div class="d-flex justify-content-between align-items-center">
		<?php
		/**
		 * Functions hooked in to finder_hivepress_listing_single_real_estate_features action
		 *
		 * @hooked finder_hivepress_listing_single_real_estate_attributes_feature_primary - 10
		 * @hooked finder_hivepress_listing_single_features_wrap_start - 20
		 * @hooked finder_hivepress_listing_single_add_to_wishlist - 30
		 * @hooked finder_hivepress_listing_single_social_share - 40
		 * @hooked finder_hivepress_listing_single_features_wrap_end - 50
		 */
		do_action( 'finder_hivepress_listing_single_real_estate_features', $listing );
		?>
	</div>
</div>
<!-- Gallery-->
<?php
/**
 * Functions hooked in to finder_hivepress_listing_single_real_estate_gallery action
 *
 * @hooked finder_hivepress_listing_single_gallery - 10
 */
do_action( 'finder_hivepress_listing_single_real_estate_gallery', $listing );
?>
<!-- Post content-->
<section class="container mb-5 pb-1">
	<div class="row">
		<div class="col-md-7 mb-md-0 mb-4">
			<?php
			/**
			 * Functions hooked in to finder_hivepress_listing_single_real_estate_body action
			 *
			 * @hooked finder_hivepress_listing_single_verified_badge - 10
			 * @hooked finder_hivepress_listing_single_featured_badge - 20
			 * @hooked finder_hivepress_listing_single_real_estate_attributes_secondary_top - 30
			 * @hooked finder_hivepress_listing_single_real_estate_attributes_secondary_bottom - 40
			 * @hooked finder_hivepress_listing_single_post_content - 50
			 * @hooked finder_hivepress_listing_single_meta - 60
			 * @hooked finder_hivepress_listing_single_review - 70
			 */
			do_action( 'finder_hivepress_listing_single_real_estate_body', $listing );
			?>
		</div>
		<aside class="col-lg-4 col-md-5 ms-lg-auto pb-1">
			<?php
			/**
			 * Functions hooked in to finder_hivepress_listing_single_real_estate_right_sidebar action
			 *
			 * @hooked finder_hivepress_listing_single_right_sidebar - 10
			 */
			do_action( 'finder_hivepress_listing_single_real_estate_right_sidebar', $listing );
			?>
		</aside>
	</div>
</section>
<!-- Recently viewed-->
<?php
/**
 * Functions hooked in to finder_hivepress_listing_single_real_estate_footer action
 *
 * @hooked finder_hivepress_listing_single_related_post - 10
 */
do_action( 'finder_hivepress_listing_single_real_estate_footer', $listing );
?>
