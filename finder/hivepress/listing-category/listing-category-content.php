<?php
/**
 * The Template for displaying listing category content
 *
 * @package Finder
 */

$cat_image_url = hivepress()->get_url() . '/assets/images/placeholders/image-landscape.svg';

if ( $listing_category->get_image__url() ) {
	$cat_image_url = $listing_category->get_image__url( 'full' );
}

?>
<a href="<?php echo esc_url( $listing_category_url ); ?>" class="card card-hover shadow bg-size-cover bg-position-center border-0 overflow-hidden h-100" style="background-image: url(<?php echo esc_url( $cat_image_url ); ?>);min-height: 32rem;">
	<span class="img-gradient-overlay"></span>
	<div class="card-body content-overlay pb-0">
		<span class="badge bg-info fs-sm rounded-pill"><?php printf( esc_html( translate_nooped_plural( hivepress()->translator->get_string( 'n_listings' ), esc_html( $listing_category->get_item_count() ), 'hivepress' ) ), esc_html( $listing_category->display_item_count() ) ); ?></span>
	</div>
	<div class="card-footer content-overlay border-0 pt-0 pb-4">
		<div class="pt-5 mt-2 mt-sm-5">
			<h3 class="h5 text-light mb-0"><?php echo esc_html( $listing_category->get_name() ); ?></h3>
			<?php if ( $listing_category->get_description() ) : ?>
				<p class="mb-0 fs-sm text-light opacity-70 mt-1"><?php echo esc_html( $listing_category->get_description() ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</a>
