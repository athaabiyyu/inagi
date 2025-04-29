<?php
/**
 * Vendor single city guide content template.
 *
 * @package Finder
 */

use HivePress\Blocks\Favorite_Toggle;

$listing_image_url = $listing->get_image__url( 'full' );
$i                 = 1;

?>
<div class="position-relative">
	<div class="position-relative mb-3">
		
		<?php if ( $listing->is_verified() || $listing->is_featured() ) : ?>
		<div class="position-absolute start-0 top-0 pt-3 ps-3">
			<?php finder_hivepress_listing_loop_verified_badge( $listing ); ?>
			<?php finder_hivepress_listing_loop_featured_badge( $listing ); ?>
		</div>
		<?php endif; ?>
		<div class="dropdown position-absolute zindex-5 top-0 end-0 mt-3 me-3">
			<?php if ( finder_is_hivepress_favorites_activated() ) : ?>
				<?php
					$fav_args = array(
						'view'       => 'icon',
						'icon'       => 'heart fi-heart',
						'url'        => hivepress()->router->get_url( 'listing_favorite_action', array( 'listing_id' => $listing->get_id() ) ),
						'attributes' => array(
							'class' => 'btn btn-icon btn-light btn-xs rounded-circle shadow-sm hp-listing__action hp-listing__action--favorite',
						),
						'context'    => array(
							'listing' => $listing,
						),
					);

					$fav_toggle = new Favorite_Toggle( $fav_args );

					echo wp_kses_post( str_replace( 'fas fa-', '', $fav_toggle->render() ) );
					?>
			<?php endif; ?>
		</div>
		<?php if ( $listing_image_url ) : ?>
			<div class ="aspect-ratio aspect-w-219 aspect-h-142">
				<img class="w-full h-full object-center object-cover rounded-3" src="<?php echo esc_url( $listing_image_url ); ?>" alt="<?php echo esc_attr( $listing->get_title() ); ?>" loading="lazy">
			</div>
		<?php else : ?>
			<div class ="aspect-ratio aspect-w-219 aspect-h-142">
				<img class="w-full h-full object-center object-cover rounded-3" src="<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/image-landscape.svg' ); ?>" alt="<?php echo esc_attr( $listing->get_title() ); ?>" loading="lazy">
			</div>
		<?php endif; ?>
	</div>
	<?php finder_hivepress_listing_loop_title( $listing, 'mb-2 fs-lg' ); ?>
	<?php if ( $listing->_get_fields( 'view_block_secondary' ) || ( finder_is_hivepress_reviews_activated() && $listing->get_rating() ) ) : ?>
		<ul class="list-inline mb-0 fs-xs hp-listing__attributes hp-listing__attributes--secondary mt-2">
			<?php if ( finder_is_hivepress_reviews_activated() && $listing->get_rating() ) : ?>
				<li class="list-inline-item pe-1">
					<?php
						echo wp_kses_post(
							sprintf(
								'<i class="fi-star-filled mt-n1 me-1 fs-base text-warning align-middle"></i><b>%1$s</b><span class="text-muted"> (%2$s)</span></li>',
								esc_html( $listing->display_rating() ),
								esc_html( $listing->display_rating_count() )
							)
						);
					?>
			<?php endif; ?>
			<?php if ( $listing->_get_fields( 'view_block_primary' ) || $listing->get_rating() ) : ?>
				<?php foreach ( $listing->_get_fields( 'view_block_primary' ) as $field ) : ?>
					<?php if ( ! is_null( $field->get_value() ) ) : ?>
						<li class="list-inline-item pe-1"><?php echo wp_kses_post( $field->display() ); ?></li>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if ( $listing->_get_fields( 'view_block_secondary' ) ) : ?>
				<?php foreach ( $listing->_get_fields( 'view_block_secondary' ) as $field ) : ?>
					<?php if ( ! is_null( $field->get_value() ) ) : ?>
						<li class="list-inline-item pe-1"><?php echo wp_kses_post( $field->display() ); ?></li>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	<?php endif; ?> 
</div>




