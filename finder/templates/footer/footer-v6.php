<?php
/**
 * Template for displayig footer v6.
 *
 * @package finder
 */

?>
<footer class="footer bg-dark text-light">   
	<div class="container text-center py-4">
		<?php $copyright_html = finder_get_copyright_html(); ?>
		<?php if ( ! empty( $copyright_html ) ) : ?>
		<p class="fs-sm mb-0 py-2"><?php echo wp_kses_post( $copyright_html ); ?></p> 
		<?php endif; ?>
	</div> 
</footer>
