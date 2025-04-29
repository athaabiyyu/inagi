<?php
/**
 * The Template for displaying listing submit link page
 *
 * @package Finder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$is_custom_header = finder_header_acf_is_custom_header();
$fn_page_options = array();

if ( function_exists( 'finder_option_enabled_post_types' ) && is_singular( finder_option_enabled_post_types() ) ) {
	$clean_meta_data  = get_post_meta( get_the_ID(), '_fn_page_options', true );
	$_fn_page_options = maybe_unserialize( $clean_meta_data );

	if ( is_array( $_fn_page_options ) ) {
		$fn_page_options = $_fn_page_options;
	}
}
if ( finder_has_custom_header( $fn_page_options ) ) {
	$button_text  = isset( $fn_page_options['header']['finder_add_listing_button_text'] ) ? $fn_page_options['header']['finder_add_listing_button_text'] : 'Add Property';
	$button_color = isset( $fn_page_options['header']['finder_add_listing_button_color'] ) ? 'btn-' . $fn_page_options['header']['finder_add_listing_button_color'] : 'btn-Primary';
	$button_size  = isset( $fn_page_options['header']['finder_add_listing_button_size'] ) ? 'btn-' . $fn_page_options['header']['finder_add_listing_button_size'] : 'btn-sm';
	$button_shape = isset( $fn_page_options['header']['finder_add_listing_button_shape'] ) ? $fn_page_options['header']['finder_add_listing_button_shape'] : 'default';
	$button_icon = isset( $fn_page_options['header']['finder_add_listing_button_icon'] ) ? $fn_page_options['header']['finder_add_listing_button_icon'] : 'fi-plus';

} elseif ( $is_custom_header ) {

	$button_text  = finder_get_field( 'add_listing_button_text' );
	$button_color = 'btn-' . finder_get_field( 'add_listing_button_color' );
	$button_size  = 'btn-' . finder_get_field( 'add_listing_button_size' );
	$button_shape = finder_get_field( 'add_listing_button_shape' );
	$button_icon  = finder_get_field( 'add_listing_button_icon' );

} else {

	$button_text  = get_theme_mod( 'finder_header_listing_button_text', 'Add property' );
	$button_color = 'btn-' . get_theme_mod( 'finder_header_listing_button_color', 'primary' );
	$button_size  = 'btn-' . get_theme_mod( 'finder_header_listing_button_size', 'sm' );
	$button_shape = get_theme_mod( 'finder_header_listing_button_shape', '' );
	$button_icon  = get_theme_mod( 'finder_header_listing_button_icon', 'fi-plus' );

}
	$button_class = array(
		'finder-header-listing-button',
		'btn',
		$button_color,
		$button_size,
		$button_shape,
		'ms-2',
		'order-lg-3',
	);

	if ( get_option( 'hp_listing_enable_submission' ) ) :
		?>
	<a
		<?php
			finder_render_attr(
				'header_listing_button',
				array(
					'class'          => join(
						' ',
						$button_class
					),
					'data-component' => 'link',
				)
			);
		?>
			data-url="<?php echo esc_url( hivepress()->router->get_url( 'listing_submit_page' ) ); ?>">
		<i class="<?php echo esc_attr( apply_filters( 'finder_header_listing_button_css_classes', $button_icon ) ); ?> me-2"></i><span><?php echo wp_kses_post( $button_text ); ?></span>
	</a>
		<?php
endif;
