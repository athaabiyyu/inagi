<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package finder
 */

$style = finder_get_blog_style();

if ( 'default' === $style ) {

	do_action( 'finder_loop_before' );

	?>
	<div class="row row-cols-1 gy-md-5 gy-4 mb-4 mb-md-5">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'templates/posts/loop-post', 'default' );

		endwhile;

		finder_loop_post_pagination( 'default' );
		?>
	</div>
	<?php

	/**
	 * Functions hooked in to finder_paging_nav action
	 *
	 * @hooked finder_paging_nav - 10
	 */
	do_action( 'finder_loop_after' );

} else {
	get_template_part( 'templates/demos/' . $style . '/loop' );
}
