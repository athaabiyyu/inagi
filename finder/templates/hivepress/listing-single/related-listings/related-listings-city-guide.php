<?php
/**
 * Related Listings for single-listing city-guide demo.
 *
 * @package Finder
 */

$listing_args = array(
	'listing' => $listing,
);

?>
<div>
<?php finder_get_template( 'hivepress/listings/content/content-city-guide.php', $listing_args ); ?>
</div>
