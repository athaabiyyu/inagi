<?php
/**
 * Loop posts template for City Guide.
 *
 * @package finder/city-guide
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$badge     = finder_acf_blog_post_badge();
?>
<article class="card card-horizontal border-0 mb-4 position-relative">
	<?php if ( has_post_thumbnail() ) : ?>
	<a class="card-img-top position-relative rounded-3 me-sm-4 mb-sm-0 mb-3" style="background-image: url(<?php the_post_thumbnail_url( 'full' ); ?>);">
		<?php if ( 'yes' === $badge ) : ?>
			<span class="badge bg-info position-absolute top-0 end-0 m-3 fs-sm"><?php echo esc_html__( 'New', 'finder' ); ?></span>
		<?php endif; ?>	
	</a>
	<?php endif; ?>
	<div class="card-body px-0 pt-0 pb-lg-5 pb-sm-4 pb-2">
		<div class="text-primary"><?php finder_loop_post_category( 'fs-sm' ); ?></div>
		<?php the_title( sprintf( '<h3 class="h5 pt-1 mb-2"><a href="%s" class="nav-link stretched-link" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		<div class="fs-sm text-muted line-clamp-3"><?php the_excerpt(); ?></div>
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="d-flex align-items-center text-decoration-none url fn" rel="author">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 48, '', '', array( 'class' => 'rounded-circle' ) ); ?>
			<div class="ps-2">
				<h6 class="fs-sm text-nav lh-base mb-1"><?php echo esc_html( get_the_author() ); ?></h6>
				<div class="d-flex text-body fs-xs">
					<?php finder_the_post_date(); ?>
					<?php finder_the_post_comments(); ?>
				</div>
			</div>
		</a>
	</div>
</article>
