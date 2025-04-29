<?php
/**
 * The loop template file used in Real Estate demo.
 *
 * @package finder/car-finder
 */

do_action( 'finder_loop_before' );

$posts_index            = 0;
$printed_wrapper        = false;
$printed_sticky_wrapper = false;
$sticky_count           = 0;

get_template_part( 'templates/demos/car-finder/blog-control-bar' );

while ( have_posts() ) :

	the_post();

	if ( is_sticky() && ! $printed_wrapper ) {

		if ( 0 === $sticky_count ) {
			get_template_part( 'templates/demos/car-finder/loop-post', 'sticky-first' );
		}

		if ( ! $printed_sticky_wrapper && 0 !== $sticky_count ) {
			echo '<div class="row row-cols-1 row-cols-md-2 gy-md-5 gy-4 mb-lg-5 mb-4">';
			$printed_sticky_wrapper = true;
		}

		if ( 0 !== $sticky_count ) {
			get_template_part( 'templates/demos/car-finder/loop-post', 'sticky' );
		}

		$sticky_count++;

	} else {

		if ( $printed_sticky_wrapper && ! $printed_wrapper ) {
			echo '</div>';
		}

		if ( ! $printed_wrapper ) {
			echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 gx-3 gx-md-4 gy-md-5 gy-4 mb-lg-5 mb-4">';
			$printed_wrapper = true;
		}

		get_template_part( 'templates/demos/car-finder/loop-post' );

		if ( $wp_query->post_count === $wp_query->current_post + 1 ) {
			echo '</div>';
		}
	}

endwhile;

finder_loop_post_pagination( 'car-finder' );
