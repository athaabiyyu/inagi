<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Finder
 */

get_header(); ?>
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
get_footer();
