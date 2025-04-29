<?php
/**
 * Single Listing tab link
 *
 * @package Finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see finder_hp_default_listing_tabs()
 */

$listing_tabs = apply_filters( 'finder_hp_listing_tabs', $listing, array() );

if ( empty( $default_active_tab ) ) {
	if ( $listing_tabs ) {
		$listing_tabs_keys = array_keys( $listing_tabs );

		if ( isset( $listing_tabs_keys[0] ) ) {
			$default_active_tab = $listing_tabs_keys[0];
		}
	}
}

if ( ! empty( $listing_tabs ) ) : ?>
<ul id="pills-listing-tab" class="nav nav-pills border-bottom pb-3 mb-4" role="tablist">
	<?php foreach ( $listing_tabs as $key => $listing_tab ) : ?>
		<li class="<?php echo esc_attr( $key ); ?>_tab nav-item" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
			<a href="#tab-<?php echo esc_attr( $key ); ?>" class="nav-link d-flex align-items-center<?php echo esc_attr( $key === $default_active_tab ? ' active show' : '' ); ?>" data-bs-toggle="pill">
				<?php echo wp_kses_post( apply_filters( 'finder_hp_listing_' . $key . '_tab_title', $listing_tab['title'], $key ) ); ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
