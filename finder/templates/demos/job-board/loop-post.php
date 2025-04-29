<?php
/**
 * Loop posts template for Job Board.
 *
 * @package finder/job-board
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$badge     = finder_acf_blog_post_badge();

?>
<article class="card border-0 shadow-sm card-hover card-horizontal mb-4">
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="card-img-top overflow-hidden">
		<?php if ( 'yes' === $badge ) : ?>
			<span class="badge bg-faded-info position-absolute top-0 end-0 fs-sm rounded-pill m-3"><?php echo esc_html__( 'New', 'finder' ); ?></span>
		<?php endif; ?>
		<div class="aspect-ratio aspect-w-167 aspect-h-101 h-full"><?php the_post_thumbnail( 'full', array( 'class' => 'd-block w-full h-full object-center object-cover' ) ); ?></div>
	</div>
	<?php endif; ?>
	<div class="card-body">
		<div class="text-primary"><?php finder_loop_post_category( 'fs-sm' ); ?></div>
		<h3 class="fs-base pt-1 mb-2"><a class="nav-link stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="fs-sm text-muted line-clamp-2 mb-[1.25rem]"><?php the_excerpt(); ?></div>
		<a class="d-flex align-items-center text-decoration-none" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 44, '', '', array( 'class' => 'rounded-circle' ) ); ?>
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
