<?php
/**
 * Template for displayig footer v4.
 *
 * @package finder
 */

$has_widgets = is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-5' );

?>
<footer class="footer bg-faded-light">
	<div class="py-4 border-bottom border-light">
		<div class="container d-sm-flex align-items-center justify-content-between">
			<?php finder_footer_site_branding(); ?>
		</div>
	</div>
	<?php if ( $has_widgets ) : ?>
	<div class="container pt-4 pb-3 pt-lg-5 pb-lg-4">
		<div class="row pt-2 pt-lg-0 footer-widgets-dark">
			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="col-lg-3 pb-2 mb-4">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
			<div class="col-lg-2 col-md-3 col-sm-6 offset-xl-1 mb-2 mb-sm-4">
				<?php dynamic_sidebar( 'footer-2' ); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
			<div class="col-lg-2 col-md-3 col-sm-6 mb-2 mb-sm-4">
				<?php dynamic_sidebar( 'footer-3' ); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
			<div class="col-lg-2 col-md-3 col-sm-6 mb-2 mb-sm-4">
				<?php dynamic_sidebar( 'footer-4' ); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-5' ) ) : ?>
			<div class="col-xl-2 col-lg-3 col-sm-6 col-md-3 mb-2 mb-sm-4">
				<?php dynamic_sidebar( 'footer-5' ); ?>
			</div>
			<?php endif; ?>
		  
		</div>
	</div>
	<?php endif; ?>
	<div class="container d-lg-flex align-items-center justify-content-between fs-sm <?php echo esc_attr( $has_widgets ? 'pb-3' : 'py-3' ); ?>">
		<div class="d-flex flex-wrap justify-content-center order-lg-2">
			<?php finder_footer_links(); ?>
		</div>
		<?php $copyright_html = finder_get_copyright_html(); ?>
		<?php if ( ! empty( $copyright_html ) ) : ?>
		<p class="text-center text-lg-start order-lg-1 mb-lg-0">
			<?php echo wp_kses_post( $copyright_html ); ?>
		</p>
		<?php endif; ?>
	</div>
</footer>
