<?php
/**
 * Loop posts template for Car Finder.
 *
 * @package finder/car-finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$badge     = finder_acf_blog_post_badge();
?>
<article class="col pb-2 pb-md-1 position-relative">
	<?php if ( 'yes' === $badge ) : ?>
		<span class="badge bg-info position-absolute top-0 end-0 m-3 fs-sm"><?php echo esc_html__( 'New', 'finder' ); ?></span>
	<?php endif; ?>
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="aspect-ratio aspect-w-54 aspect-h-25 mb-3"><?php the_post_thumbnail( 'full', array( 'class' => 'd-block rounded-3 w-full h-full object-center object-cover' ) ); ?></div>
	<?php endif; ?>
	<div class="text-primary"><?php finder_loop_post_category( 'fs-sm' ); ?></div>
	<?php the_title( sprintf( '<h3 class="fs-base text-light pt-1"><a href="%s" class="nav-link stretched-link" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="d-flex align-items-center text-decoration-none url fn" rel="author">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 44, '', '', array( 'class' => 'rounded-circle' ) ); ?>
		<div class="ps-2">
			<h6 class="fs-sm text-light lh-base mb-1"><?php echo esc_html( get_the_author() ); ?></h6>
			<div class="d-flex fs-xs text-light opacity-70">
				<?php finder_the_post_date(); ?>
				<?php finder_the_post_comments(); ?>
			</div>
		</div>
	</a>
</article>
