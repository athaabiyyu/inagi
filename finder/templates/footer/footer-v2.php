<?php
/**
 * Template for displayig footer v5.
 *
 * @package finder
 */

?>
<footer class="footer bg-secondary pt-5">
	<div class="container pt-lg-4 pb-4">
		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
		<div class="row mb-5 pb-md-3 pb-lg-4 footer-widgets">
			<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
			<div class="col-lg-6 mb-lg-0 mb-4">
				<div class="d-flex flex-sm-row flex-column justify-content-between mx-n2">
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<div class="mb-sm-0 mb-4 px-2">
							<?php dynamic_sidebar( 'footer-1' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<div class="mb-sm-0 mb-4 px-2">
							<?php dynamic_sidebar( 'footer-2' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<div class="px-2">
							<?php dynamic_sidebar( 'footer-3' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
				<div class="col-xl-5 col-lg-6 offset-xl-1">
					<?php dynamic_sidebar( 'footer-4' ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="bg-dark rounded-3">
			<div class="col-xxl-10 col-md-11 col-10 d-flex flex-md-row flex-column-reverse align-items-md-end align-items-center mx-auto px-0"><?php finder_banner_image(); ?>
				<div class="align-self-center d-flex flex-lg-row flex-column align-items-lg-center pt-md-3 pt-5 ps-xxl-4 text-md-start text-center">
					<div class="me-md-5">
						<?php finder_footer_banner_title(); ?>
						<?php finder_footer_banner_description(); ?>
					</div>
					<div class="flex-shrink-0">						
						<?php finder_banner_appstore_image(); ?>						
						<?php finder_banner_googleplay_image(); ?>						
					</div>
				</div>
			</div>
		</div>
		<?php $copyright_html = finder_get_copyright_html(); ?>
		<?php if ( ! empty( $copyright_html ) ) : ?>
		<div class="text-center fs-sm pt-4 mt-3 pb-2">
			<?php echo wp_kses_post( $copyright_html ); ?>
		</div>
		<?php endif; ?>
	</div>
</footer>

