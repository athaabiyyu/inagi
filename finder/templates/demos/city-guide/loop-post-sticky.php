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
<article class="col pb-2 pb-md-0 position-relative">
	<div class="card border-0 h-100">
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="position-relative mb-3">
			<span class="badge bg-success position-absolute top-0 end-0 m-3 fs-sm z-10"><?php echo esc_html__( 'Featured', 'finder' ); ?></span>
			<div class="aspect-ratio aspect-w-53 aspect-h-25">
				<?php the_post_thumbnail( 'full', array( 'class' => 'd-block rounded-3 w-full h-full object-center object-cover' ) ); ?>
			</div>
		</div>
		<?php endif; ?>
		<div class="card-body p-0">
			<div class="text-primary"><?php finder_loop_post_category( 'fs-sm' ); ?></div>
			<?php the_title( sprintf( '<h2 class="h5 pt-1 mb-2 h5 pt-1"><a href="%s" class="nav-link stretched-link" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<?php if( has_excerpt() ) {
				?><p class="mb-md-4 text-muted mb-0-last-child line-clamp-3"><?php echo esc_html( get_the_excerpt() ); ?></p><?php
			}?>
		</div>
		<div class="card-footer p-0 border-top-0">
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="d-flex align-items-center text-decoration-none position-relative zindex-5 url fn" rel="author">
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
	</div>
</article>
