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
			echo '<div class="pb-5 mb-lg-3" style="margin-top:-1.25rem;"><div class="tns-carousel-wrapper"><div class="tns-carousel-inner" data-carousel-options="{&quot;mode&quot;: &quot;gallery&quot;, &quot;nav&quot;: false, &quot;controlsContainer&quot;: &quot;#sticky-news-controls&quot;}">';
			$printed_sticky_wrapper = true;
		}

		get_template_part( 'templates/demos/real-estate/loop-post', 'sticky' );

	} else {

		if ( $printed_sticky_wrapper && ! $printed_wrapper ) {
			echo '</div></div><div class="tns-carousel-controls pt-2 mt-4" id="sticky-news-controls"><button class="me-3" type="button"><i class="fi-chevron-left fs-xs"></i></button><button type="button"><i class="fi-chevron-right fs-xs"></i></button></div></div>';
		}

		if ( ! $printed_wrapper ) {
			get_template_part( 'templates/demos/real-estate/blog-control-bar' );
			echo '<div class="row row-cols-md-2 row-cols-1 gy-md-5 gy-4 mb-lg-5 mb-4">';
			$printed_wrapper = true;
		}

		get_template_part( 'templates/demos/real-estate/loop-post' );

		if ( $wp_query->post_count === $wp_query->current_post + 1 ) {
			echo '</div>';
		}
	}

endwhile;

finder_loop_post_pagination( 'real-estate' );
