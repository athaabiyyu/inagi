<?php
/**
 * The loop template file used in Real Estate demo.
 *
 * @package finder/real-estate
 */

do_action( 'finder_loop_before' );

$posts_index            = 0;
$printed_wrapper        = false;
$printed_sticky_wrapper = false;

while ( have_posts() ) :

	the_post();

	if ( is_sticky() && ! $printed_wrapper ) {

		if ( ! $printed_sticky_wrapper ) {
			echo '<div class="border-bottom pb-2"><div class="row row-cols-1 row-cols-sm-2">';
			$printed_sticky_wrapper = true;
		}

		get_template_part( 'templates/demos/job-board/loop-post', 'sticky' );

	} else {

		if ( $printed_sticky_wrapper && ! $printed_wrapper ) {
			echo '</div></div>';
		}

		if ( ! $printed_wrapper ) {
			echo '<div class="pt-4 pb-2 mt-2">';
			$printed_wrapper = true;
		}

		get_template_part( 'templates/demos/job-board/loop-post' );

		if ( $wp_query->post_count === $wp_query->current_post + 1 ) {
			echo '</div>';
		}
	}

endwhile;

finder_loop_post_pagination( 'job-board' );
