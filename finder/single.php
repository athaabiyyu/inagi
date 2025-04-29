<?php
/**
 * The template for displaying all single posts.
 *
 * @package finder
 */

$style = finder_get_blog_single_style();

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :

			the_post();

			if ( 'default' === $style ) {

				do_action( 'finder_single_post_before' );

				do_action( 'finder_single_post' );

				do_action( 'finder_single_post_after' );

			} else {
				get_template_part( 'templates/single-post/single-post-' . $style );
			}

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
