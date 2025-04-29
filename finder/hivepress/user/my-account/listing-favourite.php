<?php
/**
 * The Template for my account
 *
 * @package Finder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$account_style = finder_hivepress_get_user_account_style();
$card_class    = '';
$bg_class      = '';
$header_class  = finder_hivepress_user_account_header_classes();
$sticky_header = finder_is_sticky_header();

if ( 'car-finder' === $account_style ) {
	$card_class = 'card-light';
	$bg_class   = 'bg-dark';
}
$container_class = 'container pt-5 pb-lg-4 mt-5 mb-sm-2';
if ( ! $sticky_header ) {
	$container_class = 'container mt-4 mb-md-4';
}
?>

<div class="<?php echo esc_attr( $bg_class ); ?>">
	<div class="<?php echo esc_attr( $container_class ); ?>">
	<?php finder_breadcrumb(); ?>
		<?php
		if ( 'city-guide' === $account_style ) {

			finder_hivepress_sidebar_city_guide_listing();
			?>
				<div class="card card-body p-4 p-md-5 shadow-sm">
					<?php
					finder_hivepress_sidebar_city_guide_content();
					?>
					<div class="d-flex flex-md-row flex-column align-items-md-center justify-content-md-between mb-4 pt-2">
						<h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html__( 'Favourites', 'finder' ); ?></h1>
					</div>
					<div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4 gx-3 gx-lg-4">
					<?php
					while ( have_posts() ) {
						the_post();
						// Get listing.
						$listing = HivePress\Models\Listing::query()->get_by_id( get_post() );
						if ( $listing ) {

							$listing_args = array(
								'listing' => $listing,
							);

							finder_get_template( 'hivepress/listings-edit/content/myaccount-city-guide.php', $listing_args );
						}
					}
					?>
					</div>
				</div>
				<?php

		} else {
			?>
			<div class="row">
				<aside class="col-lg-4 col-md-5 pe-xl-4 mb-5">
					<div class="card card-body <?php echo esc_attr( $card_class ); ?> border-0 shadow-sm pb-1 me-lg-1">
						<?php
							finder_hivepress_sidebar_author_meta();
							finder_hivepress_sidebar_listing();
						?>
					</div>
				</aside>
				<div class="col-lg-8 col-md-7 mb-5">
					<h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html__( 'Favourites', 'finder' ); ?></h1>
					<?php
					while ( have_posts() ) {
						the_post();
						// Get listing.
						$listing = HivePress\Models\Listing::query()->get_by_id( get_post() );
						if ( $listing ) {

							$listing_args = array(
								'listing' => $listing,
							);

							finder_get_template( 'hivepress/listings-edit/content/myaccount-' . $account_style . '.php', $listing_args );
						}
					}
					?>
					<?php
					$nav_classes = 'mt-5';
					$ul_classes  = '';

					if ( 'car-finder' === $account_style ) {
						$nav_classes = ' mt-2';
						$ul_classes .= ' pagination-light';
					}

					finder_bootstrap_pagination( null, true, $nav_classes, $ul_classes );
					?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
