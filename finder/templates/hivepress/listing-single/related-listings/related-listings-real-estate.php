<?php
/**
 * Related Listings for single-listing real-estate demo.
 *
 * @package Finder
 */

$listing_image_url = $listing->get_image__url( 'full' );
$i                 = 1;

$badge_args = array(
	'location'   => 'view_block_primary',
	'key'        => 'real_estate_archive_view_style',
	'attr_style' => 'badge',
);

?>
<div class="col">
	<div class="card shadow-sm card-hover border-0 h-100">
		<div class="card-img-top card-img-hover">
			<a class="img-overlay" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_view_page', array( 'listing_id' => $listing->get_id() ) ) ); ?>"></a>
			<?php if ( $listing->is_verified() || $listing->is_featured() || finder_hivepress_attribute_count( $listing, $badge_args ) ) : ?>
				<div class="position-absolute start-0 top-0 pt-3 ps-3">
					<?php finder_hivepress_listing_loop_verified_badge( $listing ); ?>
					<?php finder_hivepress_listing_loop_featured_badge( $listing ); ?>
					<?php
					foreach ( $listing->_get_fields( 'view_block_primary' ) as $field ) {
						$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
						$attribute_style      = finder_get_field( 'style', $attribute_id );
						$attribute_view_style = finder_get_field( 'real_estate_archive_view_style', $attribute_id );

						if ( ! is_null( $field->get_value() ) ) {

							$display = $field->display();

							if ( 'badge' === $attribute_view_style ) {
								?>
								<span class="d-table badge bg-info mt-1"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></span>
								<?php
							}
						}
					}
					?>
				</div>
			<?php endif; ?>
			<div class="content-overlay end-0 top-0 pt-3 pe-3">
				<?php finder_hivepress_listing_single_add_to_wishlist( $listing ); ?>
			</div>
			<?php if ( $listing_image_url ) : ?>
				<div>
					<div class="aspect-ratio aspect-w-219 aspect-h-142">
						<img class="w-full h-full object-center object-cover" src="<?php echo esc_url( $listing_image_url ); ?>" alt="<?php echo esc_attr( $listing->get_title() ); ?>" loading="lazy">
					</div>
				</div>
			<?php else : ?>
				<div class="aspect-ratio aspect-w-219 aspect-h-142">
					<img class="w-full h-full object-center object-cover" src="<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/image-landscape.svg' ); ?>" alt="<?php echo esc_attr( $listing->get_title() ); ?>" loading="lazy">
				</div>
			<?php endif; ?>
		</div>
		<div class="card-body position-relative pb-3">
			<?php if ( $listing->get_categories__id() ) : ?>
				<h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary">
					<?php foreach ( $listing->get_categories() as $category ) : ?>
						<?php
						echo esc_html( $category->get_name() );
						echo esc_html( count( $listing->get_categories() ) !== $i ? ' ,' : '' );
						?>
						<?php $i++; ?>
					<?php endforeach; ?>
				</h4>
			<?php endif; ?>
			<?php finder_hivepress_listing_loop_title( $listing ); ?>
			<?php
			if ( $listing->get_location() ) :
				?>
				<p class="mb-2 fs-sm text-muted"><?php echo esc_html( $listing->get_location() ); ?></p>
				<?php
			endif;
			?>
			<?php if ( $listing->_get_fields( 'view_block_primary' ) && ! empty( finder_hivepress_default_attribute_count( $listing, 'view_block_primary' ) ) ) : ?>
				<div class="hp-listing__attributes hp-listing__attributes--primary">
					<?php
					foreach ( $listing->_get_fields( 'view_block_primary' ) as $field ) {

						$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
						$attribute_style      = finder_get_field( 'style', $attribute_id );
						$attribute_view_style = finder_get_field( 'real_estate_archive_view_style', $attribute_id );

						if ( ! is_null( $field->get_value() ) ) {

							$display = $field->display();

							if ( 'price' === $attribute_view_style ) {
								?>
								<div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>
									<?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?>
								</div>
								<?php
							} elseif ( 'address' === $attribute_view_style ) {
								?>
								<p class="mb-2 fs-sm text-muted"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></p>
								<?php
							} elseif ( 'badge' === $attribute_view_style ) {
								continue;
							} else {
								?>
								<p class="mb-2"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></p>
								<?php
							}
						}
					}
					?>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $listing->_get_fields( 'view_block_secondary' ) && ! empty( finder_hivepress_default_attribute_count( $listing, 'view_block_secondary' ) ) ) : ?>
			<div class="card-footer d-flex align-items-center justify-content-center mx-3 pt-3 text-nowrap hp-listing__attributes hp-listing__attributes--secondary">
				<?php foreach ( $listing->_get_fields( 'view_block_secondary' ) as $field ) : ?>
						<?php

						$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
						$attribute_style      = finder_get_field( 'style', $attribute_id );
						$attribute_view_style = finder_get_field( 'real_estate_archive_view_style', $attribute_id );

						if ( ! is_null( $field->get_value() ) ) {
							?>
							<span class="d-inline-block mx-1 px-2 fs-sm">
							<?php
								$display = $field->display();

							if ( 'price' === $attribute_view_style ) {
								?>
									<div class="fw-bold"><i class="fi-cash mt-n1 me-2 lead align-middle opacity-70"></i>
									<?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?>
									</div>
									<?php
							} elseif ( 'address' === $attribute_view_style ) {
								?>
										<p class="mb-2 fs-sm text-muted"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></p>
									<?php
							} elseif ( 'badge' === $attribute_view_style ) {
								?>
										<span class="d-table badge bg-info"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></span>
									<?php
							} else {
								echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) );
							}
							?>
							</span>
							<?php
						}
					endforeach;
				?>
			</div>
		<?php endif; ?>
	</div>
</div>
