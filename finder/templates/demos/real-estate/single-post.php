<?php
/**
 * Template for displayig single finder posts.
 *
 * @package finder
 */

$single_post_style = 'real-estate';
$post_style        = 'single-post-real-estate';

$sticky_header = finder_is_sticky_header();

if ( $sticky_header ) {
	$container_class = 'container mt-5 mb-md-4 py-5';
} else {
	$container_class = 'container mt-[-29px] mb-md-4 py-5';
}

?>
<div class="<?php echo esc_attr( $container_class ); ?>">
	<?php finder_breadcrumb(); ?>
	<?php finder_the_post_meta( 'categories', 'single-post-real-estate' ); ?>
	<?php the_title( '<h1 class="h2 mb-4">', '</h1>' ); ?>
	<div class="mb-4 pb-1">
		<ul class="list-unstyled d-flex flex-wrap mb-0 text-nowrap">
			<li class="me-3"><?php finder_the_post_date( 'single-post-real-estate' ); ?></li>
			<li class="me-3 border-end"></li>
			<li class="me-3"><?php finder_the_post_read( 'single-post-real-estate' ); ?></li>
			<?php if ( finder_should_display_comments_link() ) : ?>
			<li class="me-3 border-end"></li>
			<li class="me-3"><a class="nav-link-muted" href="#comments" data-scroll><?php finder_the_post_comments( $post_style ); ?></a></li>
			<?php endif; ?>
		</ul>
	</div>
	<div class="mb-4 pb-md-3">
		<?php finder_the_post_thumbnail( 'full', array( 'class' => 'rounded-3' ), 54, 25 ); ?>
	</div>
	<div class="row">
		<div class="col-lg-2 col-md-1 mb-md-0 mb-4 mt-md-n5">
			<?php finder_single_post_share( $single_post_style ); ?>
		</div>
		<div class="col-lg-8 col-md-10">
			<?php finder_single_post_author(); ?>
			<div class="entry-content"><?php the_content(); ?></div>
			<div class="mt-md-5 mt-4 pt-md-4 pt-3 border-top">
				<?php finder_single_post_tags( $single_post_style ); ?>
				<?php finder_single_post_comment(); ?>
			</div>
		</div>
	</div>
</div>
