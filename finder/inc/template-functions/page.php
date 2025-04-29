<?php
/**
 * Template functions related to Page.
 *
 * @package finder/Templates/Page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'finder_page_header' ) ) {
	/**
	 * Display the page header
	 */
	function finder_page_header() {
		if ( apply_filters( 'finder_disable_page_header', false ) ) {
			return;
		}

		get_template_part( 'templates/global/page', 'header' );
	}
}

if ( ! function_exists( 'finder_page_content' ) ) {
	/**
	 * Display the page content
	 */
	function finder_page_content() {
		global $post;

		$wrap_class = finder_get_page_content_class();
		$is_prose   = finder_is_prose_enabled();
		$column_classes = 'mb-5 col-lg-8 col-12';

		if ( function_exists( 'finder_wpjm_get_page_id' ) && ( finder_wpjm_get_page_id( 'jobs-dashboard' ) === $post->ID || finder_wpjm_get_page_id( 'post-a-job' ) === $post->ID ) ) {
			$column_classes = 'col-12';
		}

		if ( $is_prose ) {
			$page_content_class = ' prose';
		} else {
			$page_content_class = ' not-prose';
		}

		?>
		<div class="<?php echo esc_attr( $wrap_class ); ?>">
			<div class="container">
				<div class="row">
					<div class="<?php echo esc_attr( $column_classes ); ?>">
						<div class="<?php echo esc_attr( $page_content_class ); ?>">
							<?php the_content(); 
							finder_link_pages(); ?>
						</div>
						<?php finder_single_post_comment(); ?>
					</div>
				</div>
			</div><!-- /.container -->
			<?php finder_single_post_comment_form(); ?>
		</div><!-- .page__content -->
		<?php
	}
}

/**
 * Get page content classes
 *
 * @return string
 */
function finder_get_page_content_class() {
	global $post;

	$is_prose   = finder_is_prose_enabled();
	$is_rounded = finder_is_img_rounded_enabled();
	$classes    = 'page__content pb-5 mb-4';

	$is_job_dashboard = function_exists( 'finder_wpjm_get_page_id' ) && finder_wpjm_get_page_id( 'jobs-dashboard' ) === $post->ID;
	$is_sticky_header = finder_is_sticky_header();

	if ( comments_open() || $is_job_dashboard ) {
		$classes = 'page__content';

		if ( $is_job_dashboard && ! is_user_logged_in() ) {
			$classes .= $is_sticky_header ? ' mt-5 pt-5' : ' mt-4 mb-2';
		}
	}

	if ( $is_prose ) {
		$classes .= ' fs-base';
	}

	if ( $is_rounded ) {
		$classes .= ' img-rounded-enabled';
	}

	return $classes;
}

/**
 * Return if prose is enabled or not.
 */
function finder_is_prose_enabled() {
	return apply_filters( 'finder_setup_prose', true );
}

/**
 * Return if rounded img is enabled.
 */
function finder_is_img_rounded_enabled() {
	return apply_filters( 'finder_rounded_img', true );
}

if ( ! function_exists( 'finder_setup_prose' ) ) {
	/**
	 * Filter main content for prose.
	 *
	 * @param string $content The main content.
	 * @return string
	 */
	function finder_setup_prose( $content ) {
		$is_prose_enabled = finder_is_prose_enabled();
		if ( ( is_page() || is_singular( 'post' ) ) && $is_prose_enabled ) {

			$search = array(
				' cite="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/blockquote">',
				'<blockquote>',
				'<h1>',
				'<h2>',
				'<h3>',
				'<h4>',
				'<h5>',
				'<h6>',
				'<table>',
			);

			$replace = array(
				'>',
				'<blockquote class="fs-3 text-dark lh-lg mb-4">',
				'<h1 class="fw-bold mb-3">',
				'<h2 class="fw-bold mb-3 mt-5">',
				'<h3 class="fw-bold mb-3 mt-5">',
				'<h4 class="fw-bold mb-3">',
				'<h5 class="fw-bold mb-3">',
				'<h6 class="fw-bold mb-3">',
				'<table class="table table-bordered">',
			);
			$content = str_replace( $search, $replace, $content );
		}
		return $content;
	}
}

if ( ! function_exists( 'finder_scroll_to_top' ) ) {
	/**
	 * Display scroll to top button
	 *
	 * @hooked finder_footer_after 100
	 */
	function finder_scroll_to_top() {
		if ( apply_filters( 'finder_scroll_to_top', filter_var( get_theme_mod( 'enable_scroll_to_top', 'yes' ), FILTER_VALIDATE_BOOLEAN ) ) ) {

			?>

			<a class="btn-scroll-top" href="#top" data-scroll="">
				<span class="btn-scroll-top-tooltip text-muted fs-sm me-2">
					<?php echo esc_html__( 'Top', 'finder' ); ?>
				</span>
				<i class="btn-scroll-top-icon fi-chevron-up"></i>
			</a>
		   
			<?php
		}
	}
}


if ( ! function_exists( 'finder_sidebar_button' ) ) {
	/**
	 * Display sidebar button
	 *
	 * @hooked finder_footer_after 100
	 */
	function finder_sidebar_button() {
		?>
		<button class="btn btn-primary btn-sm w-100 rounded-0 fixed-bottom d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#blog-sidebar">
			<i class="fi-sidebar-right me-2"></i><?php echo esc_html('Sidebar') ?>
		</button>
		<?php
	}
}