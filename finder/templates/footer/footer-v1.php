<?php
/**
 * Template for displayig footer v1.
 *
 * @package finder
 */

?>
<footer class="position-relative pb-5" style="padding-top: 9rem;">
	<div class="d-none d-xxl-block position-absolute top-0 start-0 w-100 h-100 bg-dark" style="border-top-left-radius: 1.875rem; border-top-right-radius: 1.875rem;"></div>
	<div class="d-xxl-none position-absolute top-0 start-0 w-100 h-100 bg-dark"></div>
	<div class="container content-overlay text-center py-md-3 py-lg-5">
		<?php footer_newsletter_form(); ?>
		<?php $copyright_html = finder_get_copyright_html(); ?>
		<?php if ( ! empty( $copyright_html ) ) : ?>
			<p class="fs-sm mb-0 footer-copyright"><?php echo wp_kses_post( $copyright_html ); ?></p>
		<?php endif; ?>
	</div>
</footer>
	
