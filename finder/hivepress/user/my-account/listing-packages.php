<?php
/**
 * The Template for my account
 *
 * @package Finder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use HivePress\Blocks\User_Listing_Packages;

$account_style = finder_hivepress_get_user_account_style();
$card_class    = '';
$bg_class      = '';
$header_class  = finder_hivepress_user_account_header_classes();
$sticky_header = finder_is_sticky_header();

if ( 'car-finder' === $account_style ) {
	$card_class = 'card-light';
}

$container_class = 'container pt-5 pb-lg-4 mt-5 mb-sm-2';
if ( ! $sticky_header ) {
	$container_class = 'container mt-4 mb-md-4';
}
?>
<div class="<?php echo esc_attr( $container_class ); ?>">
	<?php if ( 'city-guide' === $account_style ) : ?>
		<div class="pt-5">
		<?php finder_hivepress_sidebar_city_guide_listing(); ?>
		</div>
		<div class="card card-body p-4 p-md-5 shadow-sm">
			<?php finder_hivepress_sidebar_city_guide_content(); ?>
			<div class="d-flex flex-md-row flex-column align-items-md-center justify-content-md-between mb-4 pt-2">
				<h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html__( 'Packages', 'finder' ); ?></h1>
				<?php
				$listing_packages = new User_Listing_Packages();
				echo apply_filters( 'finder_user_listing_packages_output', $listing_packages->render() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</div>
		</div>
	<?php else : ?>
		<div class="row pt-5">
			<aside class="col-lg-4 col-md-5 pe-xl-4 mb-5">
				<div class="card card-body <?php echo esc_attr( $card_class ); ?> border-0 shadow-sm pb-1 me-lg-1">
					<?php
						finder_hivepress_sidebar_author_meta();
						finder_hivepress_sidebar_listing();
					?>
				</div>
			</aside>
			<div class="col-lg-8 col-md-7 mb-5">
				<h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html__( 'Packages', 'finder' ); ?></h1>
				<?php
				$listing_packages = new User_Listing_Packages();
				echo apply_filters( 'finder_user_listing_packages_output', $listing_packages->render() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</div>
		</div>
	<?php endif; ?>
</div>
