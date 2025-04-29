<?php
/**
 * The template for displaying Archive pages.
 *
 * @package finder
 */

get_header();

do_action( 'finder_archive_page_before' );

?>
<?php $classes = finder_get_main_and_content_area_classes(); ?>
<div class="container">
	<?php get_template_part( 'templates/global/page', 'header' ); ?>
	<div class="row">
		<div id="primary" class="<?php echo esc_attr( $classes['content_area'] ); ?>">
			<main id="main" class="<?php echo esc_attr( $classes['main'] ); ?>" role="main">
			<?php

			if ( have_posts() ) :

				get_template_part( 'loop' );

			else :

				get_template_part( 'content', 'none' );

			endif;
			?>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php do_action( 'finder_sidebar' ); ?>

	</div>
</div>
<?php

do_action( 'finder_archive_page_after' );

get_footer();
