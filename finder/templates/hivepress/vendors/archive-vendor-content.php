<?php
/**
 * Archive Vendor template.
 *
 * @package Finder
 */

?>
<div class="col mb-4">
	<div class="card card-hover bg-white h-100">
		<div class="card-body py-5 px-4">
			<div class="finder-hp-vendor__image">
				<?php if ( $vendor->get_image__url() ) : ?>
					<a href="<?php echo esc_url( hivepress()->router->get_url( 'vendor_view_page', array( 'vendor_id' => $vendor->get_id() ) ) ); ?>">
						<img class="d-block rounded-circle mx-auto mb-1" src="<?php echo esc_url( $vendor->get_image__url() ); ?>" alt="<?php echo esc_attr( $vendor->get_name() ); ?>" loading="lazy" width="160">
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url( hivepress()->router->get_url( 'vendor_view_page', array( 'vendor_id' => $vendor->get_id() ) ) ); ?>">
						<img class="d-block rounded-circle mx-auto mb-1" src="<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/user-square.svg' ); ?>" alt="<?php echo esc_attr( $vendor->get_name() ); ?>" loading="lazy" width="160">
					</a>
				<?php endif; ?>
			</div>
			<div class="text-center mt-4">
				<h4 class="align-items-center d-flex h5 justify-content-center mb-1">
					<a href="<?php echo esc_url( hivepress()->router->get_url( 'vendor_view_page', array( 'vendor_id' => $vendor->get_id() ) ) ); ?>" class="text-decoration-none nav-link"><?php echo esc_html( $vendor->get_name() ); ?></a>
					<?php if ( $vendor->is_verified() ) : ?>
						<i class="fi-check-circle text-success ms-2"></i>
					<?php endif; ?>
				</h4>
				<small>
					<?php
					/* translators: %s: date. */
					printf( esc_html__( 'Member since %s', 'finder' ), esc_html( $vendor->display_registered_date() ) );
					?>
				</small>
				<?php if ( $vendor->get_rating() ) : ?>
					<div class="hp-vendor__rating hp-rating mt-2 justify-content-center">
						<div class="hp-rating__stars hp-rating-stars" data-component="rating" data-value="<?php echo esc_attr( $vendor->get_rating() ); ?>"></div>
						<div class="hp-rating__details">
							<span class="hp-rating__value"><?php echo esc_html( $vendor->display_rating() ); ?></span>
							<span class="hp-rating__count">(<?php echo esc_html( $vendor->display_rating_count() ); ?>)</span>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $vendor->_get_fields( 'view_block_primary' ) || $vendor->_get_fields( 'view_block_secondary' ) ) : ?>
					<div class="mt-3">
						<?php if ( $vendor->_get_fields( 'view_block_primary' ) ) : ?>
							<ul class="list-unstyled mb-0 fs-sm hp-vendor__attributes hp-vendor__attributes--primary">
								<?php
								foreach ( $vendor->_get_fields( 'view_block_primary' ) as $field ) :
									$display      = $field->display();
									$attribute_id = finder_hivepress_get_vendor_attribute_id_by_slug( $field->get_slug() );
									?>
									<?php if ( ! is_null( $field->get_value() ) ) : ?>
										<li class="mb-2"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_vendor_icon_classes', $attribute_id ) ); ?></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<?php if ( $vendor->_get_fields( 'view_block_secondary' ) ) : ?>
							<ul class="list-unstyled mb-0 fs-sm hp-vendor__attributes hp-vendor__attributes--secondary">
								<?php
								foreach ( $vendor->_get_fields( 'view_block_secondary' ) as $field ) :
										$display      = $field->display();
										$attribute_id = finder_hivepress_get_vendor_attribute_id_by_slug( $field->get_slug() );
									?>
									<?php if ( ! is_null( $field->get_value() ) ) : ?>
										<li class="mb-2"><?php echo wp_kses_post( finder_hivepress_get_attribute_display( $display, 'archive_vendor_icon_classes', $attribute_id ) ); ?></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>	
		</div>
		<?php if ( finder_is_hivepress_messages_activated() ) : ?>
			<hr>
			<div class="hp-vendor__footer p-3 d-flex text-center justify-content-end">
				<?php
					$url_attr = 'user_login_modal';

				if ( is_user_logged_in() ) {
					$url_attr = 'message_send_modal_' . $vendor->get_id();
				}
				?>
				<a href="#<?php echo esc_attr( $url_attr ); ?>" class="hp-vendor__action hp-vendor__action--message" data-bs-toggle="modal">
					<i class="fi-chat-circle"></i>
				</a>
			</div>
			<?php finder_hivepress_vendor_message_form( $vendor ); ?>
		<?php endif; ?>
	</div>
</div>
