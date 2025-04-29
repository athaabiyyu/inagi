<?php
/**
 * The Template for my account city-guide page content
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

?><div class="col pt-2">
	<div class="position-relative">
		<div class="position-relative mb-3"><?php if ( finder_is_hivepress_favorites_activated() ) : ?>
			<?php
				$fav_args = array(
					'view'       => 'icon',
					'icon'       => 'heart fi-heart',
					'url'        => hivepress()->router->get_url( 'listing_favorite_action', array( 'listing_id' => $listing->get_id() ) ),
					'attributes' => array(
						'class' => 'btn btn-icon btn-light-primary btn-xs text-primary rounded-circle hp-listing__action hp-listing__action--favorite',
					),
					'context'    => array(
						'listing' => $listing,
					),
				);

				$fav_toggle = new Favorite_Toggle( $fav_args );
				?>
			<div class="position-absolute top-0 end-0 m-3 zindex-5">
				<?php echo wp_kses_post( str_replace( 'fas fa-', '', $fav_toggle->render() ) ); ?>
			</div>
		<?php endif; ?>
		<?php if ( $listing->get_image__url() ) : ?>
			<img class="rounded-3" src="<?php echo esc_url( $listing->get_image__url( 'full' ) ); ?>" alt="<?php echo esc_attr( $listing->get_title() ); ?>">
		<?php else : ?>
			<img class="rounded-3" src="<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/image-landscape.svg' ); ?>" alt="<?php echo esc_attr( $listing->get_title() ); ?>">
		<?php endif; ?>
		</div>
		<?php if ( $listing->get_status() === 'pending' ) : ?>
				<span><?php echo esc_html( $listing->get_title() ); ?></span>
		<?php else : ?>
			<h3 class="mb-2 fs-lg">
				<a class="nav-link stretched-link" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_edit_page', array( 'listing_id' => $listing->get_id() ) ) ); ?>"><?php echo esc_html( $listing->get_title() ); ?></a>
			</h3>
		<?php endif; ?> 
		<?php if ( $listing->_get_fields( 'view_block_primary' ) || $listing->get_rating() ) : ?>
			<ul class="list-inline mb-0 fs-xs hp-listing__attributes hp-listing__attributes--primary">
				<?php foreach ( $listing->_get_fields( 'view_block_primary' ) as $field ) : ?>
					<?php if ( ! is_null( $field->get_value() ) ) : ?>
						<li class="list-inline-item pe-1"><?php echo wp_kses_post( $field->display() ); ?></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
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
</div>
