<?php
/**
 * Single Listing tab content
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
<div id="pills-listing-tab-content" class="tab-content">
	<?php foreach ( $listing_tabs as $key => $listing_tab ) : ?>
		<div class="tab-pane fade pt-6<?php echo esc_attr( $key === $default_active_tab ? ' active show' : '' ); ?> "id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
			<?php
			if ( isset( $listing_tab['callback'] ) ) {
				call_user_func( $listing_tab['callback'], $key, $listing_tab, $listing );
			}
			?>
		</div>
	<?php endforeach; ?>

	<?php do_action( 'finder_hp_listing_after_tab_content' ); ?>
</div>
<?php endif; ?>
