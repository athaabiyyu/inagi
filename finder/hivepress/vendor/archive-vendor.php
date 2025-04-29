<?php
/**
 * Listing real estate template.
 *
 * @package Finder
 */

$is_sticky_header = finder_is_sticky_header();
$col_style        = get_theme_mod( 'finder_vendors_columns', '4' );
$div_attr         = 'row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-' . $col_style . ' mt-5';

$container_class = 'container mb-md-4';

if ( $is_sticky_header ) {
	$container_class .= ' py-5 mt-5';
} else {
	$container_class .= ' pt-3 pb-5 mt-1';
}

?>
<div class="finder-archive-vendors-wrap">
	<div class="<?php echo esc_attr( $container_class ); ?>">
		<?php if ( have_posts() ) : ?>
			<div class="<?php echo esc_attr( $div_attr ); ?>">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<?php
					$vendor = HivePress\Models\Vendor::query()->get_by_id( get_post() );
					do_action( 'finder_hivepress_vendors_content', $vendor );
				endwhile;
				?>
			</div>
		<?php endif; ?>
	</div>
</div>
