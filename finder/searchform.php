<?php
/**
 * The searchform.php template.
 *
 * Used any time that get_search_form() is called.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Finder
 */

$blog_style  = finder_get_blog_style();
$div_attr    = 'position-relative';
$input_class = 'form-control pe-5';
$icon_class  = 'fi-search position-absolute top-50 end-0 translate-middle-y me-3';

if ( 'car-finder' === $blog_style ) {
	$div_attr   .= ' flex-grow-1';
	$input_class = 'form-control form-control-light';
	$icon_class .= ' text-light opacity-70';
}

?><div class="<?php echo esc_attr( $div_attr ); ?>">
	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input class="<?php echo esc_attr( $input_class ); ?>" type="text" placeholder="<?php esc_attr_e( 'Search articles by keywords...', 'finder' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s"><i class="<?php echo esc_attr( $icon_class ); ?>"></i>
	</form>
</div>
