<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package finder
 */

get_header();

while ( have_posts() ) :

	the_post();

	do_action( 'finder_page_before' );

	get_template_part( 'templates/page/content', 'page' );

	/**
	 * Functions hooked in to finder_page_after action
	 *
	 * @hooked finder_display_comments - 10
	 */
	do_action( 'finder_page_after' );

endwhile; // End of the loop.

get_footer();
