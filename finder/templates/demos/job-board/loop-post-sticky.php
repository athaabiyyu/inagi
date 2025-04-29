<?php
/**
 * Loop Post Sticky Template.
 *
 * @package @finder/city-guide
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<article class="col mb-4 position-relative">
	<div class="card card-hover border-0 shadow-sm h-100">
		<div class="card-img-top overflow-hidden position-relative">
			<span class="badge bg-faded-info position-absolute top-0 end-0 fs-sm rounded-pill m-3 z-10"><?php echo esc_html__( 'Featured', 'finder' ); ?></span>
			<div class="aspect-ratio aspect-w-104 aspect-h-53"><?php the_post_thumbnail( 'full', array( 'class' => 'd-block w-full h-full object-center object-cover' ) ); ?></div>
		</div>
		<div class="card-body pb-3">
			<div class="text-primary"><?php finder_loop_post_category( 'fs-sm' ); ?></div>
			<h3 class="fs-base pt-1 mb-2"><a class="nav-link stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<div class="fs-sm text-muted m-0 mb-0-last-child line-clamp-2"><?php the_excerpt(); ?></div>
		</div>
		<a class="card-footer d-flex align-items-center text-decoration-none border-top-0 pt-0 mb-1" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 44, '', '', array( 'class' => 'rounded-circle' ) ); ?>
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
