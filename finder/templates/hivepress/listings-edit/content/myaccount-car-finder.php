<?php
/**
 * The Template for my account car-finder page content
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

$i = 1;
?>
<div class="card card-light card-hover card-horizontal mb-4">
	<div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_edit_page', array( 'listing_id' => $listing->get_id() ) ) ); ?>"></a>
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
			<div class="content-overlay end-0 top-0 pt-3 pe-3">
				<?php echo wp_kses_post( str_replace( 'fas fa-', '', $fav_toggle->render() ) ); ?>
			</div>
		<?php endif; ?>
			<div class="tns-carousel-inner position-absolute top-0 h-100">
			<?php if ( $listing_images ) : ?>
				<?php foreach ( $listing_images as $image ) : ?>
					<div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url(<?php echo esc_url( $image ); ?>);"></div>
				<?php endforeach; ?>
				<?php else : ?>
				<div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url(<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/image-landscape.svg' ); ?>);"></div>
			<?php endif; ?>
			</div>
		</div>
	<div class="card-body position-relative">
		<div class="dropdown position-absolute zindex-5 top-0 end-0 mt-3 me-3">
			<?php if ( $listing->display_status() ) : ?>
					<span class="badge bg-warning text-light me-2"><?php echo esc_html( $listing->display_status() ); ?></span>
			<?php endif; ?>
			<?php if ( 'Pending' !== $listing->display_status() ) : ?>
				<button class="btn btn-icon btn-translucent-light btn-xs rounded-circle" type="button" id="contextMenu1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
				<ul class="dropdown-menu dropdown-menu-dark my-1" aria-labelledby="contextMenu1">          
				<?php
					$icons = array(
						'Edit'   => 'fi-edit',
						'Hide'   => 'fi-power',
						'Delete' => 'fi-trash',
					);
					foreach ( $icons as $key => $value ) {
						if ( ! $listing->display_status() ) :
							?>
							<li>
								<a class="text-decoration-none" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_edit_page', array( 'listing_id' => $listing->get_id() ) ) ); ?>">
									<button class="dropdown-item" type="button"><i class="<?php echo esc_attr( $value ); ?> me-2"></i><?php echo esc_html( $key, 'finder' ); ?></button>
								</a>
							</li>
							<?php
							elseif ( $listing->display_status() && 'Hide' !== $key ) :
								?>
							<li>
								<a class="text-decoration-none" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_edit_page', array( 'listing_id' => $listing->get_id() ) ) ); ?>">
									<button class="dropdown-item" type="button"><i class="<?php echo esc_attr( $value ); ?> me-2"></i><?php echo esc_html( $key, 'finder' ); ?></button>
								</a>
							</li>
								<?php
						endif;
					}
					?>
				</ul>
			<?php endif; ?>
		</div>
	<div class="fs-sm text-light pb-1"><?php echo esc_html( $listing->display_categories() ); ?></div>
		<?php if ( $listing->get_status() === 'pending' ) : ?>
				<span><?php echo esc_html( $listing->get_title() ); ?></span>
		<?php else : ?>
		<h3 class="h6 mb-1">
			<a class="nav-link-light" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_edit_page', array( 'listing_id' => $listing->get_id() ) ) ); ?>"><?php echo esc_html( $listing->get_title() ); ?></a>
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
			<div class="border-top border-light mt-3 pt-3">
				<div class="row g-2 hp-listing__attributes hp-listing__attributes--secondary">
					<?php foreach ( $listing->_get_fields( 'view_block_secondary' ) as $field ) : ?>
						<?php if ( ! is_null( $field->get_value() ) ) : ?>
							<?php
								$column_classes = 'col';

							if ( count( $listing->_get_fields( 'view_block_secondary' ) ) !== $i ) {
								$column_classes .= ' me-sm-1';
							}
							?>
							<div class="<?php echo esc_attr( $column_classes ); ?>">
								<div class="bg-dark rounded text-center w-100 h-100 p-2">
									<?php echo wp_kses_post( $field->display() ); ?>
								</div>
							</div>
						<?php endif; ?>
						<?php $i++; ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
