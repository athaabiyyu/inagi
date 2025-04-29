<?php
/**
 * Template for displayig footer v3.
 *
 * @package finder
 */

$has_widgets = is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' );
?>

<footer class="footer bg-dark pt-5">
	<div class="container pb-2">
		<div class="row align-items-center pb-4">
			<div class="col-md-6 col-xl-5">
				<?php if ( $has_widgets ) : ?>
				<div class="row footer-widgets-dark">
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<div class="col-sm-4 mb-4">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<div class="col-sm-4 mb-4">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<div class="col-sm-4 mb-4">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<div class="text-nowrap py-4<?php echo esc_attr( $has_widgets ? ' border-top border-light' : '' ); ?>">
					<?php finder_footer_social_media_links(); ?>
				</div>
			</div>
			<div class="col-md-6 offset-xl-1">
				<div class="d-flex align-items-center">
					<div class="card card-light card-body p-4 p-xl-5 my-2 my-md-0" style="max-width: 526px;">
						<div style="max-width: 380px;">
							<?php finder_footer_banner_title(); ?>
							<?php finder_footer_banner_description(); ?>
							<div class="d-flex flex-column flex-sm-row">								
								<?php finder_banner_appstore_image(); ?>
								<?php finder_banner_googleplay_image(); ?>
						</div>
						</div>
					</div><?php finder_banner_image(); ?>
				</div>
			</div>
		</div>
		<?php $copyright_html = finder_get_copyright_html(); ?>
			<?php if ( ! empty( $copyright_html ) ) : ?>
		<p class="fs-sm text-center text-sm-start mb-4">
				<?php echo wp_kses_post( $copyright_html ); ?>				
		</p>
		<?php endif; ?>
	</div>
</footer>
