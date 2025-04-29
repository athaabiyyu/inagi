<?php
/**
 * The template for displaying job single post.
 *
 * @package finder
 */

get_header();

while ( have_posts() ) :

	the_post();

	do_action( 'finder_wpjm_single_job_listing_before' );

	?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php

			get_job_manager_template_part( 'content-single', 'job_listing' );

		?>
	</div>
	<?php
	do_action( 'finder_wpjm_single_job_listing_after' );

endwhile; // End of the loop.

get_footer();
