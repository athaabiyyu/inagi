<?php
/**
 * Template for displayig footer v5.
 *
 * @package finder
 */

$has_widgets  = is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' );
$footer_class = $has_widgets ? 'pt-lg-5 pt-4 ' : '';
?>

<footer class="footer <?php echo esc_attr( $footer_class ); ?>bg-dark text-light">
	<?php if ( $has_widgets ) : ?>
	<div class="container mb-4 py-4 pb-lg-5">
		<div class="row gy-4 footer-widgets-dark-v2">
			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="col-lg-3 col-md-6 col-sm-4">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
			<div class="col-lg-2 col-md-3 col-sm-4">
				<?php dynamic_sidebar( 'footer-2' ); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
			<div class="col-lg-2 col-md-3 col-sm-4">
				<?php dynamic_sidebar( 'footer-3' ); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
			<div class="col-lg-4 offset-lg-1">
				<?php dynamic_sidebar( 'footer-4' ); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
	<div class="py-4<?php echo esc_attr( $has_widgets ? ' border-top border-light' : '' ); ?>">
		<div class="container d-flex flex-column flex-lg-row align-items-center justify-content-between py-2">
			<?php $copyright_html = finder_get_copyright_html(); ?>
			<?php if ( ! empty( $copyright_html ) ) : ?>
			<p class="order-lg-1 order-2 fs-sm mb-2 mb-lg-0">
				<?php echo wp_kses_post( $copyright_html ); ?>
			</p>
			<?php endif; ?>
			<div class="d-flex flex-lg-row flex-column align-items-center order-lg-2 order-1 ms-lg-4 mb-lg-0 mb-4">
				<!-- Links-->
				<div class="d-flex flex-wrap fs-sm mb-lg-0 mb-4 pe-lg-4">
					<?php finder_footer_links(); ?>
				</div>
				<div class="d-flex align-items-center">
					<!-- Language switcher-->
					<div class="text-nowrap">
						<?php finder_footer_social_media_links(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

