<?php
/**
 * Listing car finder list content template.
 *
 * @package Finder
 */

use HivePress\Blocks\Favorite_Toggle;

$listing_images_ids = $listing->get_images__id();
$listing_images = array();
if ( $listing_images_ids ) {
	foreach( $listing_images_ids as $listing_images_id ) {
		$listing_images[] = wp_get_attachment_image_url( $listing_images_id, 'full' );
	}
}

$i          = 1;
$badge_args = array(
	'location'   => 'view_block_primary',
	'key'        => 'car_finder_archive_view_style',
	'attr_style' => 'badge',
);
?>
<div class="card card-light card-hover card-horizontal mb-4">
	<div class="finder-hp-listing-images tns-carousel-wrapper card-img-top card-img-hover">
		<a class="img-overlay" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_view_page', array( 'listing_id' => $listing->get_id() ) ) ); ?>"></a>
		<?php if ( $listing->is_verified() || $listing->is_featured() || finder_hivepress_attribute_count( $listing, $badge_args ) ) : ?>
			<div class="position-absolute start-0 top-0 pt-3 ps-3">
				<?php finder_hivepress_listing_loop_featured_badge( $listing, 'd-table badge bg-info mb-1' ); ?>
				<?php finder_hivepress_listing_loop_verified_badge( $listing ); ?>
				<?php if ( $listing->_get_fields( 'view_block_primary' ) ) : ?>
					<div class="hp-listing__attributes hp-listing__attributes--primary">
						<?php
						$i = 1;
						foreach ( $listing->_get_fields( 'view_block_primary' ) as $key => $field ) {

							$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
							$attribute_style      = finder_get_field( 'style', $attribute_id );
							$attribute_view_style = finder_get_field( 'car_finder_archive_view_style', $attribute_id );
							$display              = $field->display();

							if ( ! is_null( $field->get_value() ) ) {

								if ( 'badge' === $attribute_view_style ) {
									?>
									<span class="d-table badge bg-info"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></span>
									<?php

								}
							}
						}
						?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php if ( finder_is_hivepress_favorites_activated() ) : ?>
			<?php
				$fav_args = array(
					'view'       => 'icon',
					'icon'       => 'heart fi-heart',
					'url'        => hivepress()->router->get_url( 'listing_favorite_action', array( 'listing_id' => $listing->get_id() ) ),
					'attributes' => array(
						'class' => 'btn btn-icon btn-light btn-xs text-primary rounded-circle hp-listing__action hp-listing__action--favorite active-state-v1',
						'data-bs-toggle' => "modal",
					),
					'context'    => array(
						'listing' => $listing,
					),
				);

				$fav_toggle = new Favorite_Toggle( $fav_args );
				?>
			<div class="content-overlay end-0 top-0 pt-3 pe-3">
				<?php echo wp_kses_post( str_replace( 'fas fa-', '', $fav_toggle->render() ) ); ?>
			</div>
		<?php endif; ?>

		<div class="tns-carousel-inner position-absolute top-0 h-100">
			<?php if ( $listing_images ) : ?>
				<?php foreach ( $listing_images as $image_url ) : ?>
					<div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url(<?php echo esc_url( $image_url ); ?>);"></div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url(<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/image-landscape.svg' ); ?>);"></div>
			<?php endif; ?>
		</div>
	</div>
	<div class="card-body">
	<?php finder_hivepress_listing_car_finder_loop_title_before( $listing ); ?>
		<?php finder_hivepress_listing_loop_title( $listing, 'h6 mb-1', 'nav-link-light' ); ?>
		<?php if ( $listing->_get_fields( 'view_block_primary' ) && ! empty( finder_hivepress_default_attribute_count( $listing, 'view_block_primary' ) ) ) : ?>
			<div class="hp-listing__attributes hp-listing__attributes--primary">
				<?php
				$i = 1;
				foreach ( $listing->_get_fields( 'view_block_primary' ) as $key => $field ) {

					$field_slug           = preg_replace("/[\-_]/", "_", $field->get_slug());
					$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field_slug  );
					$attribute_style      = finder_get_field( 'style', $attribute_id );
					$attribute_view_style = finder_get_field( 'car_finder_archive_view_style', $attribute_id );
					$display              = $field->display();

					if ( ! is_null( $field->get_value() ) ) {

						if ( 'year' === $attribute_view_style ) {
							continue;
						}

						if ( 'price' === $attribute_view_style ) {
							?>
							<div class= "text-primary fw-bold mb-1"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></div>
							<?php
						} elseif ( 'location' === $attribute_view_style ) {
							?>
							<div class="fs-sm text-light opacity-70"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></div>
							<?php
						} elseif ( 'boxed' === $attribute_view_style ) {
							$args = array(
								'location'   => 'view_block_primary',
								'key'        => 'car_finder_archive_view_style',
								'attr_style' => 'boxed',
							);
							if ( 1 === $i ) :
								?>
							<div class="row g-2">
								<?php
							endif;
							$col_class = ( finder_hivepress_attribute_count( $listing, $args ) === $i ) ? 'col' : 'col me-sm-1';
							?>
							<div class="<?php echo esc_attr( $col_class ); ?>">
								<div class="bg-dark rounded text-center w-100 h-100 p-2">
								<span class="fs-xs text-light"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></span>
								</div>
							</div>
							<?php if ( finder_hivepress_attribute_count( $listing, $args ) === $i ) : ?> 
							</div>
								<?php
							endif;
							$i++;
						} elseif ( 'badge' === $attribute_view_style ) {
							continue;

						} else {
							?>
							<div><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></div>
							<?php
						}
					}
				}
				?>
			</div>
		<?php endif; ?>
		<?php
		if ( $listing->get_location() ) :
			?>
			<div class="hp-listing__location fs-sm text-light opacity-70">
				<i class="fi-map-pin me-1"></i>
				<?php if ( get_option( 'hp_geolocation_hide_address' ) ) : ?>
					<span><?php echo esc_html( $listing->get_location() ); ?></span>
				<?php else : ?>
					<a href="
					<?php
					echo esc_url(
						hivepress()->router->get_url(
							'location_view_page',
							array(
								'latitude'  => $listing->get_latitude(),
								'longitude' => $listing->get_longitude(),
							)
						)
					);
					?>
								" target="_blank"><?php echo esc_html( $listing->get_location() ); ?></a>
				<?php endif; ?>
			</div>
			<?php
		endif;
		?>
		<?php if ( $listing->_get_fields( 'view_block_secondary' ) && ! empty( finder_hivepress_default_attribute_count( $listing, 'view_block_secondary' ) ) ) : ?>
			<div class="border-top border-light mt-3 pt-3">
				<div class="hp-listing__attributes hp-listing__attributes--secondary">
				<?php
					$i = 1;
				foreach ( $listing->_get_fields( 'view_block_secondary' ) as $key => $field ) {

					$attribute_id         = finder_hivepress_get_listing_attribute_id_by_slug( $field->get_slug() );
					$attribute_style      = finder_get_field( 'style', $attribute_id );
					$attribute_view_style = finder_get_field( 'car_finder_archive_view_style', $attribute_id );
					$display              = $field->display();

					if ( ! is_null( $field->get_value() ) ) {

						if ( 'price' === $attribute_view_style ) {
							?>
							<div class= "text-primary fw-bold mb-1"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></div>
							<?php
						} elseif ( 'location' === $attribute_view_style ) {
							?>
							<div class="fs-sm text-light opacity-70"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></div>
							<?php
						} elseif ( 'boxed' === $attribute_view_style ) {
							$args = array(
								'location'   => 'view_block_secondary',
								'key'        => 'car_finder_archive_view_style',
								'attr_style' => 'boxed',
							);
							if ( 1 === $i ) :
								?>
																							 
							<div class="row g-2">
								<?php
							endif;
							$col_class = ( finder_hivepress_attribute_count( $listing, $args ) === $i ) ? 'col' : 'col me-sm-1';
							?>
							<div class="<?php echo esc_attr( $col_class ); ?>">
								<div class="bg-dark rounded text-center w-100 h-100 p-2">
								<span class="fs-xs text-light"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></span>
								</div>
							</div>
							<?php if ( finder_hivepress_attribute_count( $listing, $args ) === $i ) : ?> 
							</div>
								<?php
							endif;
							$i++;
						} elseif ( 'badge' === $attribute_view_style ) {
							continue;

						} else {
							if ( 1 === $i ) :
								?>
																							 
								<div class="row g-2">
									<?php
									endif;
									$col_class = ( count( $listing->_get_fields( 'view_block_secondary' ) ) === $i ) ? 'col' : 'col me-sm-1';
									$def_attr  = finder_hivepress_default_attribute_count( $listing, 'view_block_secondary' );
							?>
									<div class="<?php echo esc_attr( $col_class ); ?>">
										<div class="bg-dark rounded text-center w-100 h-100 p-2">
											<span class="fs-xs text-light"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_listing_icon_classes', $attribute_id ) ); ?></span>
										</div>
									</div>
							<?php
							if ( $def_attr === $i ) :
								?>
																							 
								</div>
								<?php
							endif;
							$i++;
						}
					}
				}
				?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
