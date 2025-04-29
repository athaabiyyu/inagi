<?php
/**
 * The Template for listing loop item
 *
 * @package Finder
 */

$listing_style = finder_hivepress_get_listings_style();

if ( 'car-finder' === $listing_style ) {
	$listing_style = $listing_style . '-' . finder_hivepress_get_listings_catalog_view();
}

$listing_args = array(
	'listing' => $listing,
);

finder_get_template( 'hivepress/listings/content/content-' . $listing_style . '.php', $listing_args );
