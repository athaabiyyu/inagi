<?php
/**
 * The Template for displaying listing submit details page
 *
 * @package Finder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$sticky_header   = finder_is_sticky_header();
$container_class = 'container mt-5 py-5';

if ( ! $sticky_header ) {
	$container_class = 'container mt-4 mb-md-4';
}

?><div class="<?php echo esc_attr( $container_class ); ?>">
	<div class="row">
		<div><?php printf( esc_html( hivepress()->translator->get_string( 'listing_has_been_submitted' ) ), $listing->get_title() ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<div>
			<button type="button" class="btn btn-primary px-3 px-sm-4 mt-4" data-component="link" data-url="<?php echo esc_url( hivepress()->router->get_url( 'user_account_page' ) ); ?>"><?php echo esc_html( hivepress()->translator->get_string( 'return_to_my_account' ) ); ?></button>
		</div>
	</div>
</div>

