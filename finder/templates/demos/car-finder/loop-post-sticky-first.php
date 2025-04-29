<?php
/**
 * Template for the first sticky post.
 *
 * @package @finder/car-finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<article class="row pb-2 pb-md-1 mb-4 mb-md-5 position-relative">
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="col-md-7 col-lg-8 mb-lg-0 mb-3 mb-md-0">
		<div class="aspect-ratio aspect-w-107 aspect-h-50 mb-3"><?php the_post_thumbnail( 'full', array( 'class' => 'd-block rounded-3 w-full h-full object-center object-cover' ) ); ?></div>
	</div>
	<?php endif; ?>
	<div class="col-md-5 col-lg-4">
		<div class="text-primary"><?php finder_loop_post_category( 'fs-sm' ); ?></div>
		<h2 class="h5 text-light pt-1"><a class="nav-link stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="d-md-none d-xl-block text-light opacity-70 mb-4 mb-0-last-child"><?php the_excerpt(); ?></div>
		<a class="d-flex align-items-center text-decoration-none" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 48, '', '', array( 'class' => 'rounded-circle' ) ); ?>
			<div class="ps-2">
				<h6 class="fs-base text-light lh-base mb-1"><?php echo esc_html( get_the_author() ); ?></h6>
				<div class="d-flex fs-sm text-light opacity-70">
					<?php finder_the_post_date(); ?>
					<?php finder_the_post_comments(); ?>
				</div>
			</div>
		</a>
	</div>
</article>
