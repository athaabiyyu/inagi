<?php
/**
 * The Template for displaying listing categories
 *
 * @package Finder
 */

use HivePress\Blocks\Listing_Categories;

$listing_categories_args = apply_filters(
	'finder_listing_categories_page_args',
	array(
		'columns' => 3,
		'number'  => 0,
	)
);

$listing_categories = new Listing_Categories( $listing_categories_args );

$render = $listing_categories->render();

if ( preg_match( '/hp-row/i', $render ) ) {
	$render = str_replace(
		'hp-row',
		'hp-row row row-cols-1 row-cols-md-2 row-cols-lg-' . $listing_categories_args['columns'],
		$render
	);
}

if ( preg_match( '/hp-grid__item/i', $render ) ) {
	$render = str_replace(
		'hp-grid__item',
		'hp-grid__item col mb-4',
		$render
	);
}

?>
<div class="container mt-5 py-5">
	<?php echo wp_kses_post( $render ); ?>
</div>
