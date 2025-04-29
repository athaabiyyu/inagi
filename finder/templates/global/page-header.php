<?php
/**
 * Displays the page header.
 *
 * @package finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$class = 'page__header';
$space = finder_is_sticky_header() ? 'mt-5 pt-5 pb-3 mb-1' : 'my-1 py-3';
$single_style = finder_get_blog_single_style();
$inner = 'container-inner';

if ( $single_style = 'default' && is_single() ) {
	$inner .= ' col-lg-9 mx-auto';
}
 

if ( is_front_page() && is_home() ) {
	// Default homepage.
	$class .= ' ' . $space;
} elseif ( is_front_page() ) {
	// Static homepage.
	$class .= ' container ' . $space ;
} elseif ( is_home() ) {
	// Blog page.
	$class .= ' ' . $space;
} elseif ( is_archive() ) {
	$class .= ' ' . $space;
} elseif ( is_single() ) {
	$class .= ' container ' . $space;
} elseif ( is_front_page() && ! is_home() ) {
	$class .= ' container py-5';
} else {
	$class .= ' container ' . $space . ' px-0';
}

if ( 'default' === $single_style && is_single() ) {
	$class = has_post_thumbnail() ? 'page__header container my-1 py-3' : 'page__header container my-1 pt-3';
}

?>
<div class="<?php echo esc_attr( $class ); ?>">
	<div class="<?php echo esc_attr( $inner ); ?>">
		<?php
		finder_breadcrumb();
		finder_page_title();
		?>
	</div>
</div>
