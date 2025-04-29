<?php
/**
 * The loop template file used in Real Estate demo.
 *
 * @package finder/city-guide
 */

do_action( 'finder_loop_before' );

$posts_index            = 0;
$printed_wrapper        = false;
$printed_sticky_wrapper = false;

$has_sidebar = finder_has_blog_sidebar();
$classes     = finder_get_main_and_content_area_classes();
$layout      = finder_get_blog_layout();

while ( have_posts() ) :

	the_post();

	if ( is_sticky() && ! $printed_wrapper ) {

		if ( ! $printed_sticky_wrapper ) {
			echo '<div class="row row-cols-1 row-cols-md-2 gy-4 mb-md-5 mb-4 pb-md-5 pb-4 border-bottom">';
			$printed_sticky_wrapper = true;
		}

		get_template_part( 'templates/demos/city-guide/loop-post', 'sticky' );

	} else {

		if ( $printed_sticky_wrapper && ! $printed_wrapper ) {
			echo '</div>';
		}

		if ( ! $printed_wrapper ) {
			echo '<div class="row">';

			if ( $has_sidebar ) {
				$classes['content_area'] = 'col-lg-9';
			}

			if ( 'sidebar-left' === $layout ) {
				$classes['main'] .= ' ps-lg-3';
				$classes['content_area'] .= ' order-last';
			} elseif ( 'sidebar-right' === $layout ) {
				$classes['main'] .= ' pe-lg-3';
				$classes['content_area'] .= ' order-first';
			}

			echo '<div class="' . esc_attr( $classes['content_area'] ) . '">';
			echo '<div class="' . esc_attr( $classes['main'] ) . '">';
			$printed_wrapper = true;
		}

		get_template_part( 'templates/demos/city-guide/loop-post' );

		if ( $wp_query->post_count === $wp_query->current_post + 1 ) {
			echo '</div>';
			finder_loop_post_pagination( 'city-guide' );
			echo '</div>';

			if ( $has_sidebar ) {
				echo '<div class="col-lg-3 blog-sidebar-widgets">';
				get_template_part( 'templates/demos/city-guide/sidebar-blog' );
				echo '</div>';
				finder_sidebar_button();
			}
		}
	}

endwhile;
