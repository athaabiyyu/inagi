<?php
/**
 * The Template for my account real estate page content
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

if ( ! $listing_images && $listing->get_image__url( 'full' ) ) {
	$listing_images[] = $listing->get_image__url( 'full' );
}
?><div class="card card-hover card-horizontal border-0 shadow-sm mb-4">
	<?php if ( $listing_images ) : ?>
	<div class="card-img-top position-relative"  style="background-image: url(<?php echo esc_url( $listing->get_image__url( 'full' ) ); ?>">
	<?php else : ?>
		<div class="card-img-top position-relative"  style="background-image: url(<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/image-landscape.svg' ); ?>">
	<?php endif; ?>
		<a class="nav-link" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_edit_page', array( 'listing_id' => $listing->get_id() ) ) ); ?>" >
			<?php if ( $listing->is_verified() || $listing->is_featured() ) : ?>
				<div class="position-absolute start-0 top-0 pt-3 ps-3">
					<?php if ( $listing->is_verified() ) : ?>
						<span class="d-table badge bg-success mb-1"><?php esc_html_e( 'Verified', 'finder' ); ?></span>
					<?php endif; ?>
					<?php if ( $listing->is_featured() ) : ?>
						<span class="d-table badge bg-danger"><?php esc_html_e( 'Featured', 'finder' ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</a>
		<?php if ( finder_is_hivepress_favorites_activated() ) : ?>
			<?php
				$fav_args = array(
					'view'       => 'icon',
					'icon'       => 'heart fi-heart',
					'url'        => hivepress()->router->get_url( 'listing_favorite_action', array( 'listing_id' => $listing->get_id() ) ),
					'attributes' => array(
						'class' => 'btn btn-icon btn-light btn-xs text-primary rounded-circle hp-listing__action hp-listing__action--favorite',
					),
					'context'    => array(
						'listing' => $listing,
					),
				);

				$fav_toggle = new Favorite_Toggle( $fav_args );
				?>
			<div class="position-absolute end-0 top-0 pt-3 pe-3 zindex-5">
				<?php echo wp_kses_post( str_replace( 'fas fa-', '', $fav_toggle->render() ) ); ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="card-body position-relative pb-3">
		<?php 
        $fav_url = 'listing_view_page';
        if ( $listing->get_user__id() === get_current_user_id() ) :
            $fav_url = 'listing_edit_page';
            ?>
		<div class="dropdown position-absolute zindex-5 top-0 end-0 mt-3 me-3">
			<?php if ( $listing->display_status() ) : ?>
					<span class="badge bg-warning text-dark me-2"><?php echo esc_html( $listing->display_status() ); ?></span>
			<?php endif; ?>
			<?php if ( 'Pending' !== $listing->display_status() ) : ?>
				<button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
				<ul class="dropdown-menu my-1" aria-labelledby="contextMenu1">
					<?php
					$icons = array(
						'Edit'   => 'fi-edit',
						'View'   => 'fi-eye-on',
					);
					$icon_url_path = 'listing_edit_page';
					foreach ( $icons as $key => $value ) {
						if( 'View' === $key ) {
							$icon_url_path = 'listing_view_page';
						}

						if ( ! $listing->display_status() ) :
							?>
							<li>
								<a class="text-decoration-none" href="<?php echo esc_url( hivepress()->router->get_url( $icon_url_path, array( 'listing_id' => $listing->get_id() ) ) ); ?>">
									<button class="dropdown-item" type="button"><i class="<?php echo esc_attr( $value ); ?> opacity-60 me-2"></i><?php echo esc_html( $key, 'finder' ); ?></button>
								</a>
							</li>
							<?php
							elseif ( $listing->display_status() && 'View' !== $key ) :
								?>
							<li>
								<a class="text-decoration-none" href="<?php echo esc_url( hivepress()->router->get_url( $icon_url_path, array( 'listing_id' => $listing->get_id() ) ) ); ?>">
									<button class="dropdown-item" type="button"><i class="<?php echo esc_attr( $value ); ?> opacity-60 me-2"></i><?php echo esc_html( $key, 'finder' ); ?></button>
								</a>
							</li>
								<?php
						endif;
					}
					?>
				</ul>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<h4 class="mb-1 fs-xs fw-normal text-uppercase text-primary"><?php echo esc_html( $listing->display_categories() ); ?></h4>
		<?php if ( $listing->get_status() === 'pending' ) : ?>
				<span><?php echo esc_html( $listing->get_title() ); ?></span>
		<?php else : ?>
		<h3 class="h6 mb-2 fs-base">
			<a class="nav-link stretched-link" href="<?php echo esc_url( hivepress()->router->get_url( $fav_url, array( 'listing_id' => $listing->get_id() ) ) ); ?>"><?php echo esc_html( $listing->get_title() ); ?></a>
		</h3>
		<?php endif; ?> 
		<?php if ( $listing->_get_fields( 'view_block_primary' ) ) : ?>
			<div class="fw-bold hp-listing__attributes hp-listing__attributes--primary">
				<?php foreach ( $listing->_get_fields( 'view_block_primary' ) as $field ) : ?>
					<?php if ( ! is_null( $field->get_value() ) ) : ?>
						<?php echo wp_kses_post( $field->display() ); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php if ( $listing->_get_fields( 'view_block_secondary' ) ) : ?>
			<div class="d-flex align-items-center justify-content-center justify-content-sm-start border-top pt-3 pb-2 mt-3 text-nowrap flex-wrap hp-listing__attributes hp-listing__attributes--secondary">
				<?php foreach ( $listing->_get_fields( 'view_block_secondary' ) as $field ) : ?>
					<?php if ( ! is_null( $field->get_value() ) ) : ?>
						<span class="d-inline-block me-4 fs-sm">
							<?php echo wp_kses_post( $field->display() ); ?>
						</span>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
