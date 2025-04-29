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
<article class="col pb-2 pb-md-1 position-relative">
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="aspect-ratio aspect-w-54 aspect-h-25 mb-3"><?php the_post_thumbnail( 'full', array( 'class' => 'd-block rounded-3 w-full h-full object-center object-cover' ) ); ?></div>
	<?php endif; ?>
	<div class="text-primary"><?php finder_loop_post_category( 'fs-sm' ); ?></div>
	<h3 class="h5 text-light mb-2 pt-1"><a class="nav-link stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<div class="text-light opacity-70 mb-3 mb-0-last-child"><?php the_excerpt(); ?></div>
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
</article>
