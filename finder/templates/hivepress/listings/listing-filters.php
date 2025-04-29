<?php
/**
 * Listing filters template.
 *
 * @package Finder
 */

use HivePress\Forms\Listing_Filter;

$listing_style = finder_hivepress_get_listings_style();

$listing_filter_obj = new Listing_Filter();

$listing_filter_fields = $listing_filter_obj->get_fields();

$listings_page_url = finder_hivepress_get_listings_page_url();

$filter_button_classes = 'me-2 mb-1 btn btn-outline-' . ( 'dark' === $variant ? 'light' : 'primary' );
$reset_filter_button_classes = 'mb-1 btn btn-outline-' . ( 'dark' === $variant ? 'light' : 'primary' );

if ( 'city-guide' === $listing_style ) {
	$filter_button_classes .= ' rounded-pill';
	$reset_filter_button_classes .= ' rounded-pill';
}

$border_classes = 'border-top py-4';

if ( 'dark' === $variant ) {
	$border_classes .= ' border-light';
}
$location_classes = 'form-control';
$location_title_class = 'h6';

if ( 'dark' === $variant ) {
	$location_classes .= ' form-control-light';
	$location_title_class .= ' text-light';
}
$listing_home_url = home_url();
	if ( ! empty( get_queried_object_id() ) ){
		$cat_default = get_queried_object_id();
		$listing_home_url = add_query_arg( '_category', get_queried_object_id(),  home_url() );
	} else {
		$selected = '';
		if ( isset( $_GET[ '_category' ] ) && ! empty( $_GET[ '_category' ] ) ) {
			$selected = filter_var( wp_unslash( $_GET[ '_category' ] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
		} elseif ( get_query_var( '_category' ) ) {
			$selected = get_query_var( '_category' );
		}
		$cat_default = $selected;

		$listing_home_url = add_query_arg( '_category', $selected,  home_url() );
	}
?>
<form action="<?php echo esc_url( $listing_home_url ); ?>" method="GET">
	<?php $sort = finder_hivepress_listings_orderby(); ?>

	<?php if ( isset( $listing_filter_fields['_sort'] ) ) : ?>
		<input type="<?php echo esc_attr( $listing_filter_fields['_sort']->get_args()['display_type'] ); ?>" name="<?php echo esc_attr( $listing_filter_fields['_sort']->get_args()['name'] ); ?>" value="<?php echo esc_attr( $sort ); ?>">
	<?php endif; ?>

	<?php if ( isset( $listing_filter_fields['s'] ) ) : ?>
		<input type="<?php echo esc_attr( $listing_filter_fields['s']->get_args()['display_type'] ); ?>" name="<?php echo esc_attr( $listing_filter_fields['s']->get_args()['name'] ); ?>">
	<?php endif; ?>

	<?php if ( isset( $listing_filter_fields['post_type'] ) ) : ?>
		<input type="<?php echo esc_attr( $listing_filter_fields['post_type']->get_args()['display_type'] ); ?>" name="<?php echo esc_attr( $listing_filter_fields['post_type']->get_args()['name'] ); ?>" value="<?php echo esc_attr( $listing_filter_fields['post_type']->get_value() ); ?>">
	<?php endif; ?>

	<input type="hidden" name="filter_active" value="1">
	
	<?php //finder_hivepress_listing_category_filters( $listing_filter_fields, $variant ); ?>
	<?php if ( class_exists( 'HivePress\Components\Geolocation' ) ) :
		$countries = array_filter( (array) get_option( 'hp_geolocation_countries' ) );
		$location_value = "";
		$countries = wp_json_encode($countries);
		if ( isset( $_GET[ 'location' ] ) && ! empty( $_GET[ 'location' ] ) ) {
			$location_value = filter_var( wp_unslash( $_GET[ 'location' ] ), FILTER_CALLBACK, array( 'options' => 'finder_clean' ) );
		} elseif ( get_query_var( 'location' ) ) {
			$location_value = get_query_var( 'location' );
		}
		?>
		<div class="pb-4 mb-2">
			<h3 class="<?php echo esc_attr( $location_title_class ); ?>"><?php echo esc_html__( 'Location', 'finder' ); ?></h3>
			<input type="hidden" name="post_type" value="hp_listing">
			<input type="hidden" name="latitude" value="" data-coordinate="lat">
			<input type="hidden" name="longitude" value="" data-coordinate="lng">
			<div data-countries="<?php echo esc_attr( $countries ); ?>" data-component="location">
				<input value="<?php echo esc_attr( $location_value ); ?>" type="text" name="location" placeholder="<?php echo esc_attr__( 'Enter the Location', 'finder' ); ?>" maxlength="256" class="<?php echo esc_attr( $location_classes ); ?>">
			</div>
		</div>
	<?php endif;
	
		finder_hivepress_category_filter_dropdown_list();
	?>
	<?php finder_hivepress_listing_attribute_filters( $listing_filter_fields, $variant ); ?>

	<div class="<?php echo esc_attr( $border_classes ); ?>">
		<button type="submit" class="<?php echo esc_attr( $filter_button_classes ); ?>"><?php esc_html_e( 'Filter', 'finder' ); ?></button>
		<a href="<?php echo esc_url( $listings_page_url ); ?>" class="<?php echo esc_attr( $reset_filter_button_classes ); ?>"><i class="fi-rotate-right me-2"></i><?php esc_html_e( 'Reset filters', 'finder' ); ?></a>
	</div>
</form>
