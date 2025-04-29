<?php
/**
 * Map Listing content template.
 *
 * @package Finder
 */

$listing_image_url = $listing->get_image__url( 'full' );

?>
<a href="<?php echo esc_url( hivepress()->router->get_url( 'listing_view_page', array( 'listing_id' => $listing->get_id() ) ) ); ?>" class="d-block">
	<?php if ( $listing_image_url ) : ?>
		<img src="<?php echo esc_url( $listing_image_url ); ?>" alt="<?php echo esc_attr( $listing->get_title() ); ?>" loading="lazy">
	<?php else : ?>
		<img src="<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/image-landscape.svg' ); ?>" alt="<?php echo esc_attr( $listing->get_title() ); ?>" loading="lazy">
	<?php endif; ?>
</a>
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
	<h3 class="h6 mb-1 fs-sm">
		<a href="<?php echo esc_url( hivepress()->router->get_url( 'listing_view_page', array( 'listing_id' => $listing->get_id() ) ) ); ?>" class="nav-link stretched-link"><?php echo esc_html( $listing->get_title() ); ?></a>
	</h3>
	<p class="mt-0 mb-2 fs-xs text-muted"><?php echo wp_kses_post( $listing->get_location() ); ?></p>
</div>
