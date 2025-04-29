<?php
/**
 * Template for Default blog posts.
 *
 * @package finder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$card_body_class = 'card-body position-relative px-0 pt-0 mw-100 space-y-5';

if ( has_post_thumbnail() ) {
	$card_body_class .= ' pb-lg-5 pb-sm-4 pb-2';
} else {
	$card_body_class .= ' pb-0';
}

$badge = '';
if ( is_sticky() ) {
	$badge = '<span class="badge bg-info ms-2 fs-xs">' . esc_html__( 'Featured', 'finder' ) . '</span>';
}

?>
<article class="card card-horizontal border-0">
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="card-img-top position-relative rounded-3 me-sm-4 mb-sm-0 mb-3" href="<?php echo esc_url( get_permalink() ); ?>" style="background-image: url(<?php the_post_thumbnail_url( 'full' ); ?>);"></a>
	<?php endif; ?>
	<div class="<?php echo esc_attr( $card_body_class ); ?>">
		<div class="space-y-1">
			<div class="text-primary"><?php finder_loop_post_category( 'fs-sm', 'single-post-default' ); ?></div>
			<?php the_title( sprintf( '<h3 class="h5 mb-0"><a href="%s" class="nav-link stretched-link" rel="bookmark">', esc_url( get_permalink() ) ), $badge . '</a></h3>' ); ?>
		</div>
		<div class="prose text-muted mb-0-last-child mt-2"><?php the_excerpt(); ?></div>
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="d-flex align-items-center text-decoration-none url fn" rel="author">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 48, '', '', array( 'class' => 'rounded-circle' ) ); ?>
			<div class="ps-2">
				<h6 class="fs-sm text-nav lh-base mb-1"><?php echo esc_html( get_the_author() ); ?></h6>
				<div class="d-flex text-body fs-xs">
					<?php finder_the_post_meta( 'date' ); ?></span>
					<?php finder_the_post_meta( 'comments' ); ?>
				</div>
			</div>
		</a>
	</div>
</article>
