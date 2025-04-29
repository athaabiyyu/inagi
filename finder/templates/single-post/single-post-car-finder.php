<?php
/**
 * Single Post for Car Finder Template.
 *
 * @package finder/car-finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$has_sidebar = finder_get_blog_single_layout();

?>
<div class="container pt-5 pb-lg-4 my-5">
	<!--Breadcrumb-->
	<?php $args = array( 'style' => 'light' ); ?>
	<?php finder_breadcrumb( $args ); ?>
	<!-- Page title-->
	<?php the_title( '<h1 class="h2 text-light pb-3">', '</h1>' ); ?>
	<!-- Featured Image-->
	<?php the_post_thumbnail( 'full', array( 'class' => 'rounded-3 w-100' ) ); ?>
	<div class="row mt-4 pt-3">
		<!-- Post content-->
		<?php if ( 'full-width' !== $has_sidebar ) {
			?><div class="col-lg-8"><?php
		} else {
			?><div class = "col-lg-10 mx-auto"><?php
		}
			?><!-- Post meta-->
			<div class="d-flex flex-wrap border-bottom border-light pb-3 mb-4">
				<div class="text-primary">
					<?php finder_single_post_category( 'car-finder' ); ?>
				</div>
				<?php finder_single_post_date(); ?>
				<div class="d-flex align-items-center text-light border-end border-light pe-3 me-3 mb-2">
					<i class="fi-clock opacity-70 me-2"></i>
					<span><?php finder_single_post_reading_time(); ?></span>
				</div>
				<a class="d-flex align-items-center text-light text-decoration-none mb-2" href="#comments" data-scroll=""><i class="fi-chat-circle opacity-70 me-2"></i><span><?php finder_single_post_comments_count(); ?></span></a>
			</div>
			<?php finder_single_post_excerpt(); ?>
			<!-- Post content prose-->
			<div class="prose prose-car-finder">
				<?php the_content(); ?>
			</div>
			<!-- Tags + Sharing-->
			<div class="pt-4 pb-5 mb-md-3">
				<div class="d-md-flex align-items-center justify-content-between border-top border-light pt-4">
					<?php finder_single_post_tag( 'car-finder' ); ?>
					<?php finder_single_post_share(); ?>
				</div>
			</div>
			<!-- Comments-->
			<?php finder_single_post_comment(); ?>
			<!-- Comment form-->
			<?php finder_single_post_comment_form(); ?>
		</div>
		<!-- Sidebar-->
		<?php finder_blog_single_sidebar(); ?>
	</div>
	<?php finder_single_post_recent_posts() ?>
</div>
