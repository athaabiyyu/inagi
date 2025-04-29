<?php
/**
 * Listing city guide content template.
 *
 * @package Finder
 */

use HivePress\Blocks\Favorite_Toggle;

$listing_image_url = $listing->get_image__url( 'full' );
$i                 = 1;

?>
<article class="position-relative">
	<div class="position-relative mb-3">
		<?php if ( $listing->is_verified() || $listing->is_featured() ) : ?>
			<div class="position-absolute start-0 top-0 pt-3 ps-3">
				<?php finder_hivepress_listing_loop_verified_badge( $listing ); ?>
				<?php finder_hivepress_listing_loop_featured_badge( $listing ); ?>
			</div>
		<?php endif; ?>
		<?php if ( finder_is_hivepress_favorites_activated() ) : ?>
			<?php
				$fav_args = array(
					'view'       => 'icon',
					'icon'       => 'heart fi-heart',
					'url'        => hivepress()->router->get_url( 'listing_favorite_action', array( 'listing_id' => $listing->get_id() ) ),
					'attributes' => array(
						'class' => 'btn btn-icon btn-light btn-xs text-primary rounded-circle position-absolute top-0 end-0 m-3 zindex-5 hp-listing__action hp-listing__action--favorite active-state-v1',
						'data-bs-toggle' => "modal",
					),
					'context'    => array(
						'listing' => $listing,
					),
				);

				$fav_toggle = new Favorite_Toggle( $fav_args );

				echo wp_kses_post( str_replace( 'fas fa-', '', $fav_toggle->render() ) );
				?>
		<?php endif; ?>
		<?php if ( $listing_image_url ) : ?>
			<div>
				<div class="aspect-ratio aspect-w-219 aspect-h-100">
					<img class="w-full h-full object-center object-cover finder-hp-listing-images rounded-3" src="<?php echo esc_url( $listing_image_url ); ?>" alt="<?php echo esc_attr( $listing->get_title() ); ?>" loading="lazy">
				</div>
			</div>
		<?php else : ?>
				<div class="aspect-ratio aspect-w-219 aspect-h-100">
					<img class="finder-hp-listing-images rounded-3 w-full h-full object-center object-cover" src="<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/image-landscape.svg' ); ?>" alt="<?php echo esc_attr( $listing->get_title() ); ?>" loading="lazy">
				</div>
		<?php endif; ?>
	</div>
	<?php finder_hivepress_listing_loop_title( $listing, 'mb-2 fs-lg' ); ?>
	<?php if ( $listing->_get_fields( 'view_block_primary' ) || $listing->_get_fields( 'view_block_secondary' ) || ( finder_is_hivepress_reviews_activated() && $listing->get_rating() ) ) : ?>
		<ul class="list-inline mb-0 fs-xs hp-listing__attributes hp-listing__attributes--secondary">
			<?php
			if ( finder_is_hivepress_reviews_activated() && $listing->get_rating() ) {
				?>
					<li class="list-inline-item pe-1">
					<?php
						echo wp_kses_post(
							sprintf(
								'<i class="fi-star-filled mt-n1 me-1 fs-base text-warning align-middle"></i><b>%1$s</b><span class="text-muted"> (%2$s)</span>',
								esc_html( $listing->display_rating() ),
								esc_html( $listing->display_rating_count() )
							)
						);
					?>
					</li>
					<?php
			}

			if ( $listing->_get_fields( 'view_block_primary' ) ) {
				foreach ( $listing->_get_fields( 'view_block_primary' ) as $field ) {
					if ( ! is_null( $field->get_value() ) ) {
						$attribute_id = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
						$display      = $field->display();

						?>
							<li class="list-inline-item pe-1"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></li>
							<?php
					}
				}
			}

			if ( $listing->_get_fields( 'view_block_secondary' ) ) {
				foreach ( $listing->_get_fields( 'view_block_secondary' ) as $field ) {
					if ( ! is_null( $field->get_value() ) ) {
						$attribute_id = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
						$display      = $field->display();

						?>
							<li class="list-inline-item pe-1"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></li>
							<?php
					}
				}
			}
			?>
		</ul>
	<?php endif; ?>
</article>
