<?php
/**
 * Loop Post Sticky Template.
 *
 * @package @finder/real-estate
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<!-- Item-->
<div>
	<article class="row">
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="col-md-7 col-lg-8 mb-lg-0 mb-3 mb-md-0">
			<a class="d-block position-relative" href="<?php the_permalink(); ?>">
				<span class="badge bg-success position-absolute top-0 end-0 m-3 fs-sm"><?php echo esc_html__( 'Featured', 'finder' ); ?></span><img class="rounded-3" src="<?php the_post_thumbnail_url( 'full' ); ?>" alt="<?php echo esc_attr__( 'Post image', 'finder' ); ?>"></a>
		</div>
		<?php endif; ?>
		<div class="col-md-5 col-lg-4"><div class="text-primary"><?php finder_loop_post_category( 'fs-sm' ); ?></div>
			<?php the_title( sprintf( '<h2 class="h5 pt-1"><a href="%s" class="nav-link stretched-link" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<div class="d-md-none d-xl-block mb-4 mb-0-last-child"><?php the_excerpt(); ?></div>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="d-flex align-items-center text-decoration-none url fn" rel="author">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 48, '', '', array( 'class' => 'rounded-circle' ) ); ?>
				<div class="ps-2">
					<h6 class="fs-base text-nav lh-base mb-1"><?php echo esc_html( get_the_author() ); ?></h6>
					<div class="d-flex text-body fs-sm">
						<?php finder_the_post_date(); ?>
						<?php finder_the_post_comments(); ?>
					</div>
				</div>
			</a>
		</div>
	</article>
</div>
